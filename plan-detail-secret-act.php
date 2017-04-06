<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlRoom.php');

$dbMaster = new dbMaster();

// print_r($_POST);exit;
$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
//会員しか見えない
if (!$sess->sessionCheck()) {
	$_SESSION['ref_url']=$_SERVER['REQUEST_URI'];
	cmLocationChange("login.html");
}

$collection = new collection($db);

if($_POST){
	$collection->setPost();
	cmSetHotelSearchDef($collection);
}
else {
	$collection->setByKey($collection->getKeyValue(), "ROOM_ID", $_GET["room_id"]);
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["company_id"]);
	$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $_GET["hotelplan_id"]);
	$collection->setByKey($collection->getKeyValue(), "night_number", $_GET["night_number"]);
	$collection->setByKey($collection->getKeyValue(), "room_number", $_GET["room_number"]);
	$collection->setByKey($collection->getKeyValue(), "adult_number1", $_GET["adult_number1"]);
	
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "2");
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y年m月d日'));
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
	cmSetHotelSearchDef($collection);
}

// decode the url
function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}

function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

$key = $_GET["cid"].$_GET["id"].$_GET["rid"];
if( $key != passport_decrypt($_GET["key"], $key) ){
	echo "<head><meta charset='utf-8'></head><body>無効リンクです。<br/>管理員と連絡して下さい。</body>";
	exit;
}


if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
	//	ココモ
	$hotelPlanTarget = new hotelPlan($dbMaster);
		
	if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") == "") {
		if ($_GET['id']) {
			$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $_GET['id']);;
		}
	}
	if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") == "") {
		if ($_GET['rid']) {
			$collection->setByKey($collection->getKeyValue(), "ROOM_ID", $_GET['rid']);;
		}
	}
	if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") == "") {
		if ($_GET['cid']) {
			$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET['cid']);;
		}
	}
	
	
	$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	$HOTELPLAN_CHECKIN = $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CHECKIN");
	$HOTELPLAN_CHECKIN_LAST = $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CHECKIN_LAST");

	$hotelRoom = new hotelRoom($dbMaster);
	$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	$hotelTarget = new hotel($dbMaster);
	$hotelTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	$hotelBookset = new hotelBookset($dbMaster);
	$hotelBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
}
else {
	//	リンカーン
	$date = "";
	if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
		$date = str_replace("年", "", $collection->getByKey($collection->getKeyValue(), "search_date"));
		$date = str_replace("月", "", $date);
		$date = str_replace("日", "", $date);
	}
	$startDay = $date;
	$endDay = date("Ymd",strtotime("30 day" ,strtotime($startDay)));
	$hotelCode = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
	$roomCode = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
	$planCode = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");

	$hotelPlanTarget = new tlPlan($dbMaster);
	$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $planCode, $roomCode);

	$hotelRoom = new tlRoom($dbMaster);
	$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $roomCode);

// 	print_r($hotelRoom->getCollection());

	//	大人数
	$checkNum = intval($collection->getByKey($collection->getKeyValue(), "adult_number1"));
	//	小学生(低学年)
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."1"));
	//	小学生(高学年)
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."2"));
	//	幼児:食事・布団あり
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."3"));
	//	幼児:布団あり
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."5"));

	if ($checkNum > 10 ) {
		$checkNum = 10;
	}
// 	$num = 1;
	$num = $checkNum;
	$flgImport = false;

// 	//	部屋数取得
// 	require_once('includes/link/roomAvailability.php');
// 	$dataarRoom = $ar;


	//	料金取得
	require_once('includes/link/planPriceInfoAcquisition.php');
	$dataarPay = $ar;

// 	print_r($dataarPay);
}





$hotel = new hotel($dbMaster);

$hotelBooking = new hotelBooking($dbMaster);
// $collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", "");
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", "");
$hotel->selectListPublicHotel($collection);

$planCnt = 0;
$dspArray = array();

$money_1 = "";
$money_all = "";

if ($hotel->getCount() > 0) {
	foreach ($hotel->getCollection() as $data) {
		$dspArray[$data["ROOM_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["ROOM_ID"]]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$data["ROOM_ID"]]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$data["ROOM_ID"]]["money_1"] = $data["money_1"];
		$dspArray[$data["ROOM_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["ROOM_ID"]]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$data["ROOM_ID"]]["ROOM_NAME"] = $data["ROOM_NAME"];
		$dspArray[$data["ROOM_ID"]]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$data["ROOM_ID"]]["ROOM_TYPE"] = $data["ROOM_TYPE"];
		$dspArray[$data["ROOM_ID"]]["ROOM_CAPACITY_TO"] = $data["ROOM_CAPACITY_TO"];
		$dspArray[$data["ROOM_ID"]]["ROOM_BREADTH"] = $data["ROOM_BREADTH"];
		$dspArray[$data["ROOM_ID"]]["ROOM_FEATURE_LIST3"] = $data["ROOM_FEATURE_LIST3"];
	}
}
// print_r($collection);exit;

//各部屋の料金書き出す
for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
	$search_collection = new collection($db);
	$search_collection->setByKey($search_collection->getKeyValue(), "HOTELPLAN_ID", $dspArray[$data["ROOM_ID"]]["HOTELPLAN_ID"]);
	$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $dspArray[$data["ROOM_ID"]]["ROOM_ID"]);
	$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
	$search_collection->setByKey($search_collection->getKeyValue(), "adult_number", $collection->getByKey($collection->getKeyValue(), "adult_number".$i));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number1", $collection->getByKey($collection->getKeyValue(), "child_number".$i."1"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number2", $collection->getByKey($collection->getKeyValue(), "child_number".$i."2"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number3", $collection->getByKey($collection->getKeyValue(), "child_number".$i."3"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number4", $collection->getByKey($collection->getKeyValue(), "child_number".$i."4"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number5", $collection->getByKey($collection->getKeyValue(), "child_number".$i."5"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number6", $collection->getByKey($collection->getKeyValue(), "child_number".$i."6"));
	$room[$i] = $hotel->selectMoneyEveryRoom($search_collection);	
//	print_r($room[$i]);
}

// print_r($hotelPlanTarget->getCollection());
// print_r($hotel->getCollection());
$money_all_all = 0;
for ($j=1; $j<=$collection->getByKey($collection->getKeyValue(), "night_number"); $j++){
	for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
		$money_all_all += $room[$i]["money_ALL"];
	}
}


//print($collection);exit;
if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
	//	ココモ
	$arPayList = array();

	//	料金カレンダー
	$hotelPay = new hotelPay($dbMaster);
	$hotelPayTarget = new hotelPay($dbMaster);

	//	料金設定検索
	$hotelPay->selectListPublic($collection);
 	
	//	登録済みデータ設定
	if ($hotelPay->getCount() > 0) {
		foreach ($hotelPay->getCollection() as $hp) {
	
			//	POSTデータ
			$arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["ROOM_ID"] = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["night_number"] = $collection->getByKey($collection->getKeyValue(), "night_number");
			$arPayList[$hp["HOTELPAY_DATE"]]["room_number"] = $collection->getByKey($collection->getKeyValue(), "room_number");

			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["adult_number".$roomNum] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
				for ($i=1; $i<=6; $i++) {
					$arPayList[$hp["HOTELPAY_DATE"]]["child_number".$roomNum.$i] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);
				}
			}

			$arPayList[$hp["HOTELPAY_DATE"]]["date"] = $hp["HOTELPAY_DATE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ID"] = $hp["HOTELPAY_ID"];
			for ($i=1; $i<=6; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY".$i] = $hp["HOTELPAY_MONEY".$i];
			}
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ROOM_NUM"] = $hp["HOTELPAY_ROOM_NUM"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ROOM_OVER"] = $hp["HOTELPAY_ROOM_OVER"];

			for ($i=1; $i<=4; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_PS_DATA".$i] = $hp["HOTELPAY_PS_DATA".$i];
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_PS_DATA".$i."2"] = $hp["HOTELPAY_PS_DATA".$i."2"];
			}
			for ($i=1; $i<=14; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_BB_DATA".$i] = $hp["HOTELPAY_BB_DATA".$i];
			}
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY_FLG"] = $hp["HOTELPAY_MONEY_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE"] = $hp["HOTELPAY_SERVICE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_REMARKS"] = $hp["HOTELPAY_REMARKS"];
			
			//------------------start-------------------//
			// new money logic, pick the cheapest one to show
			for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
				$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $hp["HOTELPAY_DATE"]);
				$search_collection->setByKey($search_collection->getKeyValue(), "adult_number", $collection->getByKey($collection->getKeyValue(), "adult_number".$i));
				$search_collection->setByKey($search_collection->getKeyValue(), "child_number1", $collection->getByKey($collection->getKeyValue(), "child_number".$i."1"));
				$search_collection->setByKey($search_collection->getKeyValue(), "child_number2", $collection->getByKey($collection->getKeyValue(), "child_number".$i."2"));
				$search_collection->setByKey($search_collection->getKeyValue(), "child_number3", $collection->getByKey($collection->getKeyValue(), "child_number".$i."3"));
				$search_collection->setByKey($search_collection->getKeyValue(), "child_number4", $collection->getByKey($collection->getKeyValue(), "child_number".$i."4"));
				$search_collection->setByKey($search_collection->getKeyValue(), "child_number5", $collection->getByKey($collection->getKeyValue(), "child_number".$i."5"));
				$search_collection->setByKey($search_collection->getKeyValue(), "child_number6", $collection->getByKey($collection->getKeyValue(), "child_number".$i."6"));
				$roomPerDay[$i] = $hotel->selectMoneyEveryRoom($search_collection);	
//				print_r($roomPerDay[$i]);
			}
			 
			$diff_flg = 0;
			if($collection->getByKey($collection->getKeyValue(), "room_number") > 1){
				for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
					for($j=$i+1;$j<=$collection->getByKey($collection->getKeyValue(), "room_number"); $j++){
						if($room[$i]["money_perperson"] == $room[$j]["money_perperson"]){
							continue;
						}
						else{
							$diff_flg = 1;
							break;
						}
					}
				}
			}
			
			$money_perperson = "";
			$money_totol = 0;
			for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
				$money_perperson[$i] = $roomPerDay[$i]["money_perperson"];
				$money_totol += $roomPerDay[$i]["money_ALL"];
			}
			asort($money_perperson);
//			print_r($money_perperson);
	
			$arPayList[$hp["HOTELPAY_DATE"]]["money_all"] = $money_totol;
			$arPayList[$hp["HOTELPAY_DATE"]]["money_1"] = $money_perperson[1];
			$arPayList[$hp["HOTELPAY_DATE"]]["diff_flg"] = $diff_flg;
			//------------------end-------------------//
			
			//$arPayList[$hp["HOTELPAY_DATE"]]["money_all"] = $hp["money_all"];
			//$arPayList[$hp["HOTELPAY_DATE"]]["money_1"] = $hp["money_1"];
			
			//当日の予約数
			$collection_booked = new collection($db);
			$collection_booked->setByKey($collection->getKeyValue(), "COMPANY_ID", $arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $arPayList[$hp["HOTELPAY_DATE"]]["HOTELPLAN_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "BOOKING_DATE", $arPayList[$hp["HOTELPAY_DATE"]]["date"]);

			//$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPROVIDE_BOOKEDNUM"] = $hotelBooking->selectBookedNum($collection_booked);
//			print_r($arPayList[$hp["HOTELPAY_DATE"]]["HOTELPROVIDE_BOOKEDNUM"]);
			
		}
	}

// 	print_r($arPayList);


	$hotelProvide = new hotelProvide($dbMaster);
	$hotelProvide->selectListPublic($collection);
	if ($hotelProvide->getCount() > 0) {
		foreach ($hotelProvide->getCollection() as $hp) {
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["date"] = $hp["HOTELPROVIDE_DATE"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_ID"] = $hp["HOTELPROVIDE_ID"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_STOP"] = $hp["HOTELPROVIDE_FLG_STOP"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_REQUEST"] = $hp["HOTELPROVIDE_FLG_REQUEST"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_NUM"] = $hp["HOTELPROVIDE_NUM"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_BOOKEDNUM"] = $hp["HOTELPROVIDE_BOOKEDNUM"];
// 			print $hp["HOTELPROVIDE_DATE"]."/".$hp["HOTELPROVIDE_NUM"]."<br />";
		}
	}

// 	print_r($arPayList[$hp["HOTELPROVIDE_DATE"]]);
// 	print_r($hotelProvide->getCollection());
//	print_r($arPayList);exit;


}
else {

	//	部屋数取得
// 	$dataarRoom = $ar;
	//	料金取得
// 	$dataarPay = $ar;

	$hotelPay = new tlPlan($dbMaster);
	$hotelPay->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $planCode, $roomCode);
// 	print_r($hotelPay->getCollection());

// 	print_r($dataarPay);
	if ($dataarPay["planPriceInfoResult"]["commonResponse"]["resultCode"] == "True") {
		$retar = $dataarPay["planPriceInfoResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]["priceInfos"];
		if (count($retar) > 0) {
			foreach ($retar as $dd) {

				$d = date("Y-m-d",strtotime($dd->salesDate));

				$arPayList[$d]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
				$arPayList[$d]["COMPANY_LINK"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
				$arPayList[$d]["HOTELPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
				$arPayList[$d]["ROOM_ID"] = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
				$arPayList[$d]["night_number"] = $collection->getByKey($collection->getKeyValue(), "night_number");
				$arPayList[$d]["room_number"] = $collection->getByKey($collection->getKeyValue(), "room_number");

				for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
					$arPayList[$d]["adult_number".$roomNum] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
					for ($i=1; $i<=6; $i++) {
						$arPayList[$d]["child_number".$roomNum.$i] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);
					}
				}

				$arPayList[$d]["date"] = $d;
				$arPayList[$d]["HOTELPAY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");

				$arPayList[$d]["HOTELPAY_MONEY1"] = $dd->adultPrice1;
				$arPayList[$d]["HOTELPAY_MONEY2"] = $dd->adultPrice2;
				$arPayList[$d]["HOTELPAY_MONEY3"] = $dd->adultPrice3;
				$arPayList[$d]["HOTELPAY_MONEY4"] = $dd->adultPrice4;
				$arPayList[$d]["HOTELPAY_MONEY5"] = $dd->adultPrice5;
				$arPayList[$d]["HOTELPAY_MONEY6"] = $dd->adultPrice6;
				$arPayList[$d]["HOTELPAY_MONEY7"] = $dd->adultPrice7;
				$arPayList[$d]["HOTELPAY_MONEY8"] = $dd->adultPrice8;
				$arPayList[$d]["HOTELPAY_MONEY9"] = $dd->adultPrice9;
				$arPayList[$d]["HOTELPAY_MONEY10"] = $dd->adultPrice10;

				//	ポイント
				$arPayList[$d]["HOTELPAY_ROOM_NUM"] = 1;
// 				$arPayList[$d]["HOTELPAY_ROOM_OVER"] = $hp["HOTELPAY_ROOM_OVER"];

				$arPayList[$d]["childAPrice"] = $dd->childAPrice;
				$arPayList[$d]["childA2Price"] = $dd->childA2Price;
				$arPayList[$d]["childBPrice"] = $dd->childBPrice;
				$arPayList[$d]["childB2Price"] = $dd->childB2Price;
				$arPayList[$d]["childCPrice"] = $dd->childCPrice;
				$arPayList[$d]["childDPrice"] = $dd->childDPrice;

				$arPayList[$d]["HOTELPROVIDE_NUM"] = $dd->stockCount;
				$arPayList[$d]["planStockCount"] = $dd->planStockCount;

				if ($dd->salesStatus == 0) {
					//	販売
					$arPayList[$d]["HOTELPROVIDE_FLG_STOP"] = 1;
				}
				else {
					//	販売停止
					$arPayList[$d]["HOTELPROVIDE_FLG_STOP"] = 2;
				}


				/*
				for ($i=1; $i<=4; $i++) {
					$arPayList[$d]["HOTELPAY_PS_DATA".$i] = $hp["HOTELPAY_PS_DATA".$i];
					$arPayList[$d]["HOTELPAY_PS_DATA".$i."2"] = $hp["HOTELPAY_PS_DATA".$i."2"];
				}
				for ($i=1; $i<=14; $i++) {
					$arPayList[$d]["HOTELPAY_BB_DATA".$i] = $hp["HOTELPAY_BB_DATA".$i];
				}

				$arPayList[$d]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
				$arPayList[$d]["HOTELPAY_MONEY_FLG"] = $hp["HOTELPAY_MONEY_FLG"];
				$arPayList[$d]["HOTELPAY_SERVICE"] = $hp["HOTELPAY_SERVICE"];
				$arPayList[$d]["HOTELPAY_REMARKS"] = $hp["HOTELPAY_REMARKS"];
				*/


				for ($i=1; $i<=10; $i++) {
					if ($arPayList[$d]["HOTELPAY_MONEY".$i] != "") {
						$arPayList[$d]["money_1"]  = $arPayList[$d]["HOTELPAY_MONEY".$i];
						break;
					}
				}

				$rink_money_all = 0;
				if ($collection->getByKey($collection->getKeyValue(), "adult_number1") > 0) {
					$rink_money_all =  $arPayList[$d]["money_1"] * $collection->getByKey($collection->getKeyValue(), "adult_number1");
				}

				if ($collection->getByKey($collection->getKeyValue(), "child_number12") > 0) {
					$rink_money_all +=  intval($dd->childAPrice) * $collection->getByKey($collection->getKeyValue(), "child_number12");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number11") > 0) {
					$rink_money_all +=  intval($dd->childA2Price) * $collection->getByKey($collection->getKeyValue(), "child_number11");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number13") > 0) {
					$rink_money_all +=  intval($dd->childBPrice) * $collection->getByKey($collection->getKeyValue(), "child_number13");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number14") > 0) {
					$rink_money_all +=  intval($dd->childB2Price) * $collection->getByKey($collection->getKeyValue(), "child_number14");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number15") > 0) {
					$rink_money_all +=  intval($dd->childCPrice) * $collection->getByKey($collection->getKeyValue(), "child_number15");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number16") > 0) {
					$rink_money_all +=  intval($dd->childDPrice) * $collection->getByKey($collection->getKeyValue(), "child_number16");
				}

				$arPayList[$d]["money_all"] = $rink_money_all;

			}
		}

	}


}

// print_r($arPayList);


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotelTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>レジャープラン情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="プラン,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="レジャーのプラン詳細ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- 蠑ｹ窗 -->
<link rel="stylesheet" href="<?php print URL_SLAKER_COMMON?>css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/popupwindow-1.6.js"></script>
<style>
.dspNon {
	display: none;
}
</style>

<script>
//蠑ｹ窗
var pop;
function openChildSet() {
	<?php for ($i=1; $i<=6; $i++) {?>
	var num<?php print $i?> = $("#child_number<?php print $i?>").val();
	<?php }?>
	var rheight = 110 + (170*parseInt($"#room_number").val()));
	if (rheight > 620) {
		rheight = 620;
	}
	pop= new $pop('popchildset.php?num1='+num1+'&num2='+num2+'&num3='+num3+'&num4='+num4+'&num5='+num5+'&num6='+num6, { type:'iframe', title:'人数設定',effect:'normal',width:650,height:rheight,windowmode:false,resize: false } );
}
function setData() {
	pop.close();
	$("#ori_adult").css("display","none");
}


$('a[href=#top]').click(function() {
    ('a:not(.calendarLink[href*=#]')
   var speed = 500;
   var href= $(this).attr("href");
   var target = $(href == "#" || href == "" ? 'html' : href);
   var position = target.offset().top;
   $('body,html').animate({scrollTop:position}, 500, 'swing');
   return false;
});
</script>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_short" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail" class="searchdetail">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">検索結果</a></li>
            <li><span>プラン詳細</span></li>
        </ul>
        
        <article class="titlecase">
       		<div>
       			<h2><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?></h2>
       			<ul class="icon-type">
       				<?php /*<li class="type01">施設タイプ</lI> */ ?>
       				<?php
					$arArea = array();
					$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_LIST_AREA"));
					if (count($arTemp) > 0) {
						foreach ($arTemp as $data) {
							if ($data != "") {
								$arArea[$data] = $data;
							}
						}
					}

					$areaCnt = 0;
					if (count($arArea) > 0) {
						foreach ($arArea as $d) {
							$areaCnt++;
					?>
					<li class="area01"><?php print $xmlArea->getNameByValue($d)?></li>
					<?php
							if ($areaCnt >= 2) break;
						}
					}
					?>
    	   		</ul>

	       		<ul class="subtab-bt">
       				<li><?php $formname = "basic_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail-act.html?basic=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu01.png" width"78" height="23" alt="基本情報" ></a>
       					<?php print $inputs->hidden("current_page", "1")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?>
       					<?php
       						}
       					}
       					?>
       				</form></li>
       				<!--<li><?php $formname = "info_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail-act.html?info=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu02.png" width"78" height="23" alt="宿泊プラン一覧" ></a>
       					<?php print $inputs->hidden("current_page", "2")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?>
       					<?php
       						}
       					}
       					?>
       				</form></li>-->
       				<li><?php $formname = "map_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail-act.html?map=1.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu03.png" width"78" height="23" alt="地図・アクセス" ></a>
       					<?php print $inputs->hidden("current_page", "6")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?>
       					<?php
       						}
       					}
       					?>
       				</form></li>
    	   			<!--<li><a href="#"><img src="./images/common/tab-submenu04.png" width"78" height="23" alt="お気に入りに追加" ></a></li>-->
	       		</ul>
       		</div>
       	</article>

        <article class="mainbox" id="ag">
			<div class="inner">
			<h2 class="bl-bg"><span class="new-b"></span><B><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?></B></h2>
			<div class="cont">
				<div class="clearfix">
					<ul class="icon">
						<!--<li><img src="./images/common/icon-nomeal.jpg"</li>-->
						<?php
						$meal = "";
						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_BF_FLG") == 2) {
							$meal = "朝";
						}
						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DN_FLG") == 2) {
							$meal .= "夕";
						}
						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
							$meal .= "昼";
						}
						if ($meal != "") {
							$meal .= "食あり";
						}
						else {
							$meal .= "【食事なし】";
						}
						?>
						<li><?php print $meal?></li><?php /*&nbsp;&nbsp;&nbsp;<li><img src="./images/common/icon-Limit.jpg"</li> */?>
					</ul>
					<div class="checkin">出発時間<?php print date('H:i', strtotime($HOTELPLAN_CHECKIN));?>～<?php print date('H:i', strtotime($HOTELPLAN_CHECKIN_LAST));?> <!--/ チェックアウト～<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CHECKOUT")?>--></div>
				    <a href="#calendermain" class="vacancy_c">料金・空席を見る</a>
				</div>
				<div class="tb-sp20 sealetime">
					<?php $fromDate = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"))?>
					<?php $toDate = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"))?>
					販売期間：<span><?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?>～<?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?></span><br>
					<!--<span>このプランは○泊~○泊</span>-->
				</div>
				<div class="image">
				    <!--<div class="off">
				        <b>最大00％OF！</b><span>通常料金￥00,000～</span>
				        <strong>→￥00,000～</strong>
				    </div>-->
				    <div id="mainimage">
				    	 <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC") != "") {?>
				    		<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC")?>" width="299" height="223" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?>">
				    	<?php }else{?>
				    		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="299" height="223" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?>">
				    	<?php }?>
				    </div>
				    <ul id="subimage">
				    	<?php for ($i=2; $i<=4; $i++) {?>
				    	 <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i) != "") {?>
				    		<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i)?>" width="95" height="71" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?>"></a>
				    	<?php }else{?>
				    	<?php }?>
				    	<?php }?>
				    </ul>
				</div>
				<section class="section1 cf">
				    <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FEATURE"))?></p>
				</section>
				<section class="section3">
				    <h3>○備 考</h3>
				    <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CONTENTS"))?></p>
				</section>
				
				 <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_BF_FLG") == 2
			    		or $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DN_FLG") == 2
			    		or $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_LN_FLG") == 3) {?>
			    <section class="section3">
			        <h3>○お食事</h3>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_BF_FLG") == 2) {?>
			        <p><span class="icon radius5">朝食</span></p>
			        <?php }?>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD1") != "") {?>
			        <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD1"))?></p>
			        <?php }?>
			
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DN_FLG") == 2) {?>
			        <p><span class="icon radius5">夕食</span></p>
			        <?php }?>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD2") != "") {?>
			        <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD2"))?></p>
			        <?php }?>
			
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {?>
			        <p><span class="icon radius5">昼食</span></p>
			        <?php }?>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD3") != "") {?>
			        <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD3"))?></p>
			        <?php }?>
			    </section>
			    <?php }?>

                   
                <!--<section class="section5">
                    <h3>○お部屋情報</h3>
                    <section>
                        <h4><span class="type">部屋タイプ</span><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></h4>
                        <div class="image">
                        	<?php if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC1") != "") {?>
                        	<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC1")?>" width="156" height="116" alt="<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?>">
                            <?php }else{?>
                        	<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="156" height="116" alt="<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?>">
                            <?php }?>
                            <?php /*
                            <ul>
                                <li>・<a href="#">360度ビューで見る</a></li>
                                <li>・<a href="#">フォトギャラリーへ</a></li>
                            </ul>
                            */?>
                        </div>
                        <div class="text">
                            <ul>
                                <li>広さ：<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_BREADTH")?>㎡／定員：<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_FROM")?>～<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_TO")?>人</li>
                                <?php /*
                                <li class="radius5">禁煙ルーム</li>
                                <li class="radius5">ネット接続OK</li>
                                <li class="radius5">バス・トイレ別</li>
                                */?>
                            </ul>
                            <p style="word-break:break-all; "><?php print redirectForReturn($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_DISCRITION"))?></p>
                        </div>
                    </section>
                </section>-->


<!--カレンダー-->
                    <section class="calendar" id="#calendarLink">
                    	<h3>料金・空席カレンダー</h3>
                    	
                    	<?php if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {?>
                    	
<section class="searchbox form">
    	<form action="<?=$_SERVER['REQUEST_URI']?>#calendermain" method="post" id="frmResearch" name="frmResearch">
		<div id="searchtable">
            <table>
            <tbody>
                <tr>
                    <td colspan="2">
                        <?=$inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
			<!--<?=$inputs->hidden("night_number","night_number",1,$collection->getByKey($collection->getKeyValue(), "night_number"),"", "")?>-->
			<!--<?=$inputs->hidden("room_number","room_number",1,$collection->getByKey($collection->getKeyValue(), "room_number"),"", "")?>-->
                        <div class="selectbox">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php for ($roomNum=1; $roomNum<=SITE_ROOM_NUM; $roomNum++) { ?>
                        <table id="datainput<?php print $roomNum?>" class="inner datainputset dspNon" style="font-size: 11px;">
                        <tbody>
                            <tr class="first">
                               <!-- <th rowspan="3"><?php print $roomNum?>部屋目</th>-->
                                <td class="first">
                                大人
                                <div class="selectbox">
                                <?php $selected='';?>
                                	<div class="select-inner select2"><span></span></div>
	                                <select id="adult_number<?php print $roomNum?>" name="adult_number<?php print $roomNum?>" class="select2 adultset">
										<?php
										for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
											if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
												$selected = 'selected="selected"';
											}
										}
										if ($selected == 'selected="selected"') {
											for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
												$selected = '';
												if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
													$selected = 'selected="selected"';
												}
												?>
												<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==9)?'～':''?></option>
												<?php }
												}else{
										for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
											$selected = '';
											if (2 == $i) {
												$selected = 'selected="selected"';
												}
											
										?>
										<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==9)?'～':''?></option>
										<?php }
										}
										?>
									</select>

								</div>
                                人
                                </td>
				<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA1") == 1) {?>
                                <td>
                                　小人(A)
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                 <select id="child_number<?php print $roomNum?>1>" name="child_number<?php print $roomNum?>1" class="select2 childset1">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
								</div>
                                人
                                </td><?php }?>
				<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA12") == 1) {?>
                                <td>
                                　小人(B)
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>2>" name="child_number<?php print $roomNum?>2" class="select2 childset2">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td><?php }?>
				<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA1") == 1) {?>
                                <td>
                                　幼児<span>（A)</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>3>" name="child_number<?php print $roomNum?>3" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td><?php }?>
				<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA5") == 1) {?>
                                <td>
                                　幼児<span>（B）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>4>" name="child_number<?php print $roomNum?>4" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td><?php }?>
				<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA8") == 1) {?>
                                <td>
                                　幼児<span>（C）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>5>" name="child_number<?php print $roomNum?>5" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td><?php }?>
				<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA12") == 1) {?>
                                <td>
                                　幼児<span>（D）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>6>" name="child_number<?php print $roomNum?>6" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td><?php }?>
				 <td>
				　　　<div class="btn"><button name="research" value=" ">人数を変更する</button></div>
				 </td>
                           </tr>
                       </tbody>
                       </table>
                       <?php }?>

                      		 <script type="text/javascript">
	                            $(document).ready(function(){
	                            	$("#room_number").change(function () {
	                            		roomChange();
	                            	});
	                            	roomChange();


	                            	$(".adultset").change(function () {
	                            		setTextAdult();
								    });
									$(".childset1").change(function () {
										//alert(""+$(this).val());
										setTextChild1();
								    });
									$(".childset2").change(function () {
										setTextChild2();
								    });
									$(".childset3").change(function () {
										setTextChild3();
								    });
									setTextAdult();
									setTextChild1();
									setTextChild2();
									setTextChild3();
	                            });

	                            function roomChange() {
	                            	var i;
	                            	$('.datainputset').addClass('dspNon');
	                            	for (i = 1; i <= parseInt($('#room_number').val()); i = i +1){
	                            		$('#datainput'+i).removeClass('dspNon');
	                            	}
	                            	$("#txt_room").text($('#room_number').val());

	                            	var setAdult = 0;
	                            	var setChild = 0;
	                            }

	                            function setTextAdult() {
		                            var total = 0;
									for (i = 1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
	                            			if (parseInt($('select[name="adult_number'+i+'"]').val()) != '') {
	                            				total = total + parseInt($('select[name="adult_number'+i+'"]').val());
	                            			}
									}
									$("#txt_adult").text(total);
	                            }
	                            function setTextChild1() {
	                            	var total=0;

	                            	var i;
	                            	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
	                        			if ($('select[name="child_number'+i+'1"]').val() != '') {
	                        				total = total + parseInt($('select[name="child_number'+i+'1"]').val());
                        				}
	                            	}
									$("#txt_child1").text(total);
	                            }
	                            function setTextChild2() {
	                            	var total=0;

	                            	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
	                            		if ($('select[name="child_number'+i+'2"]').val() != '') {
	                        				total = total + parseInt($('select[name="child_number'+i+'2"]').val());
                        				}
	                            	}
									$("#txt_child2").text(total);
	                            }
	                            function setTextChild3() {
	                            	var total=0;
	                            	var child;

	                            	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
										for (child = 3; child<=6; child=child +1){
		                            		if ($('select[name="child_number'+i+child+'"]').val() != '') {
		                        				total = total + parseInt($('select[name="child_number'+i+child+'"]').val());
	                        				}
		                            	}
	                            	}

									$("#txt_child3").text(total);
	                            }
	                            </script>
                    </td>
                </tr>
            </tbody>
            </table>

                <?php print $inputs->hidden("orderdata", $collection->getByKey($collection->getKeyValue(), "orderdata"))?>

        </form>
    </section>
                    	<div class="cuki">
                    		<ul>
                    			<li>カレンダーに表記されている料金は合計料金です。</li>
                    			<li>カレンダーをクリックすると予約内容の入力画面へ進みます。</li>
                    		</ul>
                    		<!--<p>予約の受付は<b><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_ACC_DAY")?></b>日前の<b><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_ACC_HOUR")?></b>時までです。</p>-->
                    	</div>
						<?php }?>
						

<!--0913
			<section id="searchchange">
				<form class="form"  method="post" action="<?php print $_SERVER['REQUEST_URI']?>">
					<table>
						<tr>
							<td class="w111">
								<?php print $inputs->text("search_date", $collection->getByKey($collection->getKeyValue(), "search_date") ,"imeDisabled wDateJp")?>
								<script type="text/javascript">
									$.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
									$("#search_date").datepicker(
											{
												showOn: 'button',
												buttonImage: 'images/index/index-search-icon.png',
												buttonImageOnly: true,
												dateFormat: 'yy年mm月dd日',
												changeMonth: true,
												changeYear: true,
												yearRange: '<?php print date("Y")?>:<?php print date("Y",strtotime("+1 year"))?>',
												showMonthAfterYear: true,
												monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
								                dayNamesMin: ['日','月','火','水','木','金','土']
											});
								</script>
							</td>
							<td>
								<div class="selectbox lbox">
									<div class="select-inner select2"><span></span></div>
									<select class="select2" name="night_number" id="night_number">
                        		<?php
                        		for ($i=1; $i<=SITE_STAY_NUM; $i++) {
                        			$selected = '';
                        			if ($collection->getByKey($collection->getKeyValue(), "night_number") == $i) {
                        				$selected = 'selected="selected"';
                        			}
                        		?>
                        		<option value="<?php print $i?>" <?=$selected;?>><?=$i?></option>
                        		<?php }?>
                        		</select>
								</div><span>泊</span>
							</td>
							<td>
								<div class="selectbox lbox">
									<div class="select-inner select2"><span></span></div>
									<select class="select2" name="room_number" id="room_numbers">
                        		<?php
                        		
                        		for ($i=1; $i<=SITE_ROOM_NUM; $i++) {
                        			$selected = '';
                        			if ($collection->getByKey($collection->getKeyValue(), "room_number") == $i) {
                        				$selected = 'selected="selected"';
                        			}
                        		?>
                        		<option value="<?=$i?>" <?=$selected;?>><?=$i?></option>
                        		<?php }?>
                        		</select>
								</div><span>部屋</span>
							</td>
							<td>
								大人
								<?php
                            	$num = 0;
                            	for ($room=1; $room<=SITE_ROOM_NUM; $room++) {
									$num += intval($collection->getByKey($collection->getKeyValue(), "adult_number".$room));
                            		if ($room == 1) {
							?>
								<div class="selectbox" id="ori_adult">
									<div class="select-inner select2 adultseldiv"><span></span></div>
									<select name="adult_number<?php print $room?>" id="adult_number<?php print $room?>" class="select2 adultnumset adult_sgl">
                        		<?php
                        		for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
									$selected = '';
									if ($collection->getByKey($collection->getKeyValue(), "adult_number".$room) == $i) {
										$selected = 'selected="selected"';
									}
								?>
                                <option value="<?php print $i?>" <?php print $selected;?>><?php print $i?><?php print ($i==SITE_ADULT_NUM)?"～":""?></option>
                        		<?php }?>
                            	</select>
								</div>

                            <?php }else {?>
                        		<?php print $inputs->hidden("adult_number".$room, $collection->getByKey($collection->getKeyValue(), "adult_number".$room))?>
                        	<?php }?>

                        	<?php }?>

                            <div class="selectbox adultnumset adult_dbl">
								<a href="javascript:void(0)" onclick="openChildSet()" id="adult_text"><?php print $num?></a>
                            </div>

                        	<script type="text/javascript">
                            $(document).ready(function(){
                            	$("#room_numbers").change(function () {
                            		roomChange();
                            		if ($("#room_numbers").val() > 1) {
                            			if (pop === undefined) {
	                            		}
                            			else {
		                            		pop.close();
                            			}
	                            		openChildSet();
                            		}
                            		else {
	                            		pop.close();
                            		}
                            	});
                            	roomChange();
                            });
                            function roomChange() {
                        		$(".adultnumset").addClass('dspNon');
                        		$("#adult_number").addClass('dspNon');
                            	if ($("#room_numbers").val() > 1) {
                            		$(".adult_dbl").removeClass('dspNon');
                            	}
                            	else {
                            		$(".adult_sgl").removeClass('dspNon');
                            	}
                            }
                            </script>
                            	<span>名</span>
							</td>
							<td>
								子供
								<div class="selectbox">
                    			<?php
                    				$num = 0;
                    				for ($room=1; $room<=SITE_ROOM_NUM; $room++) {
                    					for ($i=1; $i<=6; $i++) {
                    						$num += intval($collection->getByKey($collection->getKeyValue(), "child_number".$room.$i));
                    				?>
                    				<?php print $inputs->hidden("child_number".$room.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$room.$i))?>
                    				<?php
                    					}
                    				}
                    				?>
                    				<a href="javascript:void(0)" onclick="openChildSet()" id="child_text"><?php print $num?></a>
                    		</div><span>名</span>
							</td>
						</tr>
						<tr>
							<td colspan="6"><input class="bt-Change" type="submit" value="" name="" id=""></td>
						</tr>
					</table>
				</form>
			</section>
			-->
<!-- /日付人数から検索-->
<!--searchbox-->
<?php //require("includes/box/hotel/searchboxSimple.php");?>

<!-- /0913-->


                    	<div class="calendermain"><a name="calendermain"></a>
                    	
                    	<?php
        				$SDate = "";
        				$PDate = "";
        				$NDate = "";
        				$flgPrev = true;
        				if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
        					$SDate = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
        					$SDate = str_replace("月", "-", $SDate);
        					$SDate = str_replace("日", "", $SDate);
        				}

        				//	前の月
        				if (date("m",strtotime("-1 month" ,strtotime($SDate))) == date("m") and
        					date("Y",strtotime("-1 month" ,strtotime($SDate))) == date("Y")) {
							//	前の月が当月
							$PDate = date("Y年m月d日");
						}
						else {
							$PDate = date("Y年m月01日",strtotime("-1 month" ,strtotime($SDate)));
						}

						if (date("m",strtotime("-1 month" ,strtotime($SDate))) < date("m") and
								date("Y",strtotime("-1 month" ,strtotime($SDate))) <= date("Y")) {
							$flgPrev = false;
						}

						//	次の月
						if (date("m",strtotime("1 month" ,strtotime($SDate))) == date("m") and
							date("Y",strtotime("1 month" ,strtotime($SDate))) == date("Y")) {
							//	次の月が当月
							$NDate = date("Y年m月d日");
						}
						else {
            				$NDate = date("Y年m月01日",strtotime("1 month" ,strtotime($SDate)));
						}

        				?>
                    	<ul class="calenderMonth-Ln">
                    			<?php if ($flgPrev) {?>
                    			<li>
                    				<?php $formname = "frmPrev"?>
		                        	<form action="plan-detail-secret-act.html#calendarLink" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
			                        	<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/month-back.png" width="91" height="29" alt="前の月" /></a>
			                        	<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
			                        	<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
			                        	<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
			                        	<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
			                        	<?php print $inputs->hidden("search_date", $PDate)?>
					                        	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
			                        	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
			                        	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
			                        	<?php
			                        	if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
											for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
										?>
			                        	<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
			                        	<?php for ($i=1; $i<=6; $i++) {?>
			                        	<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
			                        	<?php }?>
										<?php
											}
										}
			                        	?>
		                        	</form>
                    			</li>
                    			<?php }?>
                    			<li style="float: right;">
                    				<?php $formname = "frmNext"?>
		                        	<form action="plan-detail-secret-act.html#calendarLink" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
			                        	<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();" ><img src="./images/common/month-next.png" width="91" height="29" alt="次の月" /></a>
			                        	<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
			                        	<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
			                        	<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
			                        	<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
			                        	<?php print $inputs->hidden("search_date", $NDate)?>
					                        	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
			                        	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
			                        	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
			                        	<?php
			                        	if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
											for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
										?>
			                        	<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
			                        	<?php for ($i=1; $i<=6; $i++) {?>
			                        	<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
			                        	<?php }?>
										<?php
											}
										}
			                        	?>
		                        	</form>
                    			</li>
                    		</ul>


                    		<?php
                    		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
                    			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
                    			$date = str_replace("月", "-", $date);
                    			$date = str_replace("日", "", $date);
                    		}

                    		print calendarPublicAct($date, $arPayList,$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_ACC_DAY"));
                    		?>
                    	</div>
    	                	<div class="section">
    	                		<h3>空室カレンダーの見方</h3>
    	                		<p>
    	                			上から順に日付、合計料金、大人1人あたりの料金、ポイント率、空席状況を表しています。
    	                		</p>
    	                		<dl class="list">
    	                			<dt>・大人1人あたりの料金について</dt>
    	                			<dd>複数のお部屋をご予約で、部屋毎に人数が異なる場合は大人1人あたりの料金が表示されません。</dd>
    	                			<dt>・空室状況について</dt>
    	                			<dd>○・・・10席以上の空席あり　1～9・・・予約できる席数　×・・・満員です<br />リクエスト受付・・・予約リクエストを受付後、施設から予約可否をご連絡します。</dd>
    	                			<dt>・表示なし</dt>
    	                			<dd>すでに予約の受付時間が過ぎた日程か、このプランの販売対象外の日程です。</dd>
    	                		</dl>
    	                	</div>

	                		<div class="aboutprice">
	                			<div>
	                				<h3>◆子供料金について</h3>
	                				<div class="cf">
                						<ul class="flList">
                							<li>
                								小人(A)
                							</li>
                							<li>
                								小人(B)
                							</li>
                							<li>
                								幼児（A)
                							</li>
                							<li>
                								幼児（B）
                							</li>
                							<li>
                								幼児（C）
                							</li>
                							<li>
                								幼児（D）
                							</li>
                						</ul>
	                					<ul class="flList">
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA1") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA4") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA3");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA4") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA3");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA4") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA3");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA12") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA42") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA32");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA42") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA32");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA42") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA32");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA1") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA4") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA3");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA4") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA3");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA4") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA3");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA5") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA7") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA6");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA7") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA6");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA7") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA6");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA8") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA11") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA10");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA11") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA10");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA11") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA10");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA12") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA14") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA13");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA14") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA13");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA14") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA13");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                					</ul>
	                				</div>
	                			</div>
	                			
	                			<div>
	                				<h3>◆料金についての備考</h3>
	                				<p><?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_REMARKS") != "") {?>
	                				<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_REMARKS");?>
	                				<?php }?></p>
	                			</div>
  
							</div>
								
	                    	<div class="aboutprice">
	                    		<div class="maxsell">
	                    			<h3>◆お支払い方法</h3>
	                    				<?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PAYMENT") == 1) {?>
	                    				<p>・現地決済</p>
	                    				<?php } else {?>
	                    				<p>・事前支払い　※ご予約受け付け後にお支払のご案内をいたします。</p>
	                    				<?php }?>

	                    				
	                    			</div>
	                    	</div>

    	                	<div class="aboutprice">
    	                		<div class="maxsell">
    	                			<h3>◆キャンセルポリシー</h3>
    	                			<div>
                					<?php
                					$dataCancel = "";
                					if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {

                						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {

                						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_REMARKS") != "") {
                							print $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_REMARKS")."<br/><br/>";
                						}

                							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
                								$can = "";
                								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
                									$can = "料金の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
                								}
                								else {
                									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
                								}
                								$dataCancel .= "無連絡不着 ".$can."\n";
                							}

                							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {
                								$can = "";
                								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
                									$can = "料金の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
                								}
                								else {
                									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
                								}
                								$dataCancel .= "当日キャンセル ".$can."\n";
                							}

                							for ($i=3; $i<=7; $i++) {
                								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {
                									$can = "";
                									if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
                										$can = "料金の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
                									}
                									else {
                										$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
                									}
                									$dataCancel .= $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで".$can."\n";
                								}
                							}

                						}

                					}
                					else {

                						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_REMARKS") != "") {
                							print $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_REMARKS")."<br/><br/>";
                						}

                						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {
                							$can = "";
                							if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
                								$can = "料金の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%";
                							}
                							else {
                								$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円";
                							}
                							$dataCancel .= "無連絡不着 ".$can."\n";
                						}

                						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {
                							$can = "";
                							if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
                								$can = "料金の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%";
                							}
                							else {
                								$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円";
                							}
                							$dataCancel .= "当日キャンセル ".$can."\n";
                						}

                						for ($i=3; $i<=6; $i++) {
                							if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {
                								$can = "";
                								if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
                									$can = "料金の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%";
                								}
                								else {
                									$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円";
                								}
                								$dataCancel .= $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)."～".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)."日前まで".$can."\n";
                							}
                						}
                					}
                					print redirectForReturn($dataCancel);
                					?>
	    	               </div>
                   		</div>
                   	</div>
               </section>
<!--カレンダー-->
                </div>
            </div>
        </article>

        <ul id="social">
            <li><a href="#"><img src="images/common/common-bottom-twitter.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mixi.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-gree.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-fb.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mail.png"></a></li>
        </ul>

    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
