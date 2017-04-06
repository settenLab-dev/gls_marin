<?php

$date = "";
if ($collection->getByKey($collection->getKeyValue(), "target_date") != "") {
	$date = str_replace("-", "", $collection->getByKey($collection->getKeyValue(), "target_date"));
	$date = str_replace("月", "", $date);
	$date = str_replace("日", "", $date);
}
$startDay = $date;
$endDay = date("Ymd",strtotime(($collection->getByKey($collection->getKeyValue(), "night_number"))." day" ,strtotime($startDay)));
//print $startDay;

$hotelCode = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
$roomCode = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
$planCode = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");

$hotelPlan = new tlPlan($dbMaster);
$hotelPlan->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $planCode, $roomCode);

$hotelRoom = new tlRoom($dbMaster);
$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $roomCode);

// 	print_r($hotelRoom->getCollection());


	foreach ($hotelPlan->getCollection() as $plan) {
		//print_r($plan);
	}
	foreach ($collection->getCollection() as $param) {
		//print_r($param);
	}
	
	for ($roomNum=1; $roomNum<=$param["room_number"]; $roomNum++) {
		$adultNum = $param["adult_number".$roomNum];
		$childNum = 0;
		if($param["child_number".$roomNum."1"] > 0 && $plan["HOTELPAY_PS_DATA22"] == "1"){
			$childNum += $param["child_number".$roomNum."1"];
		}
		if($param["child_number".$roomNum."2"] > 0 && $plan["HOTELPAY_PS_DATA2"] == "1"){
			$childNum += $param["child_number".$roomNum."2"];
		}
		if($param["child_number".$roomNum."3"] > 0 && $plan["HOTELPAY_BB_DATA2"] == "1"){
			$childNum += $param["child_number".$roomNum."3"];
		}
		if($param["child_number".$roomNum."4"] > 0 && $plan["TL_PLAN_C_FLG_NUM4"] == "4"){
			$childNum += $param["child_number".$roomNum."4"];
		}
		if($param["child_number".$roomNum."5"] > 0 && $plan["HOTELPAY_BB_DATA9"] == "1"){
			$childNum +=$param["child_number".$roomNum."5"];
		}
		if($param["child_number".$roomNum."6"] > 0 && $plan["TL_PLAN_C_FLG_NUM6"] == "6"){
			$childNum += $param["child_number".$roomNum."6"];
		}
		$count = $adultNum + $childNum;

		if ($count > 10 ) {
			$count = 10;
		}
		$num = $count;
		$flgImport = false;
	}

/*
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
*/


//	料金取得
require_once('includes/link/planPriceInfoAcquisition.php');
$dataarPay = $ar;

// print_r($dataarPay);

$arPayList = array();

if ($dataarPay["planPriceInfoResult"]["commonResponse"]["resultCode"] == "True") {
	$retar = $dataarPay["planPriceInfoResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]["priceInfos"];

	$dayCount = 0;

	if (count($retar) > 0) {
		foreach ($retar as $dd) {
 		//	print_r($dd);
			$d = $dd->salesDate;
//print $d;
// 			$d = date("Y-m-d",strtotime($dd->salesDate));

			$dayCount++;
			if ($dayCount > $collection->getByKey($collection->getKeyValue(), "night_number")) break;

			$arPayList[$d]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$arPayList[$d]["COMPANY_LINK"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
			$arPayList[$d]["HOTELPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
			$arPayList[$d]["ROOM_ID"] = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$arPayList[$d]["night_number"] = $collection->getByKey($collection->getKeyValue(), "night_number");
			$arPayList[$d]["room_number"] = $collection->getByKey($collection->getKeyValue(), "room_number");


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


			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				//	予約人数セット
				$arPayList[$d]["adult_number".$roomNum] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
				for ($i=1; $i<=6; $i++) {
					$arPayList[$d]["child_number".$roomNum.$i] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);
				}

				//	部屋別大人料金セット
				if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) > 0) {
					$arPayList[$d][$roomNum]["money_adult"] =  $arPayList[$d]["money_1"];
					$arPayList[$d][$roomNum]["money_adult_all"] =  $arPayList[$d]["money_1"] * $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
					//	部屋別合計
					$arPayList[$d][$roomNum]["money_all"] += $arPayList[$d][$roomNum]["money_adult_all"];
					//	一泊の合計
					$arPayList[$d]["money_all_all"] += $arPayList[$d][$roomNum]["money_adult_all"];
				}
				//	部屋別小学生(低)金額セット
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") > 0) {
					$arPayList[$d][$roomNum]["money_child1"] =  $dd->childA2Price;
					$arPayList[$d][$roomNum]["money_child1_all"] =  intval($dd->childA2Price) * $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1");
					//	部屋別合計
					$arPayList[$d][$roomNum]["money_all"] += $arPayList[$d][$roomNum]["money_child1_all"];
					//	全体の合計
					$arPayList[$d]["money_all_all"] += $arPayList[$d][$roomNum]["money_child1_all"];
				}
				//	部屋別小学生(高)金額セット
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") > 0) {
					$arPayList[$d][$roomNum]["money_child2"] =  intval($dd->childAPrice);
					$arPayList[$d][$roomNum]["money_child2_all"] =  intval($dd->childAPrice) * $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2");
					//	部屋別合計
					$arPayList[$d][$roomNum]["money_all"] += $arPayList[$d][$roomNum]["money_child2_all"];
					//	一泊の合計
					$arPayList[$d]["money_all_all"] += $arPayList[$d][$roomNum]["money_child2_all"];
				}
				//	部屋別幼児金額セット
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") > 0) {
					$arPayList[$d][$roomNum]["money_child3"] =  intval($dd->childBPrice);
					$arPayList[$d][$roomNum]["money_child3_all"] =  intval($dd->childBPrice) * $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3");
					//	部屋別合計
					$arPayList[$d][$roomNum]["money_all"] += $arPayList[$d][$roomNum]["money_child3_all"];
					//	一泊の合計
					$arPayList[$d]["money_all_all"] += $arPayList[$d][$roomNum]["money_child3_all"];
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") > 0) {
					$arPayList[$d][$roomNum]["money_child4"] =  intval($dd->childB2Price);
					$arPayList[$d][$roomNum]["money_child4_all"] =  intval($dd->childB2Price) * $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4");
					//	部屋別合計
					$arPayList[$d][$roomNum]["money_all"] += $arPayList[$d][$roomNum]["money_child4_all"];
					//	一泊の合計
					$arPayList[$d]["money_all_all"] += $arPayList[$d][$roomNum]["money_child4_all"];
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") > 0) {
					$arPayList[$d][$roomNum]["money_child5"] =  intval($dd->childCPrice);
					$arPayList[$d][$roomNum]["money_child5_all"] =  intval($dd->childCPrice) * $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5");
					//	部屋別合計
					$arPayList[$d][$roomNum]["money_all"] += $arPayList[$d][$roomNum]["money_child5_all"];
					//	一泊の合計
					$arPayList[$d]["money_all_all"] += $arPayList[$d][$roomNum]["money_child5_all"];
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") > 0) {
					$arPayList[$d][$roomNum]["money_child6"] =  intval($dd->childDPrice);
					$arPayList[$d][$roomNum]["money_child6_all"] =  intval($dd->childDPrice) * $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6");
					//	部屋別合計
					$arPayList[$d][$roomNum]["money_all"] += $arPayList[$d][$roomNum]["money_child6_all"];
					//	一泊の合計
					$arPayList[$d]["money_all_all"] += $arPayList[$d][$roomNum]["money_child6_all"];
				}


			}

			//	全ての合計
			$arPayList["money_all"] += $arPayList[$d]["money_all_all"];

		}
	}

}

// print_r($arPayList);


if ($collection->getByKey($collection->getKeyValue(), "confirm_x") or $collection->getByKey($collection->getKeyValue(), "regist")) {

	$mail_contents = "";
	//	泊数ごとの料金
	$money_night = 0;

	$money_all_all = 0;
	$point_all = 0;
	$cnt=0;

	$nightNum = 0;

	//	泊数ごと、部屋ごとの設定
	if (count($arPayList) > 0) {
		foreach ($arPayList as $ad) {

			$nightNum++;
			if ($nightNum > $collection->getByKey($collection->getKeyValue(), "night_number")) break;

			$tdate =  date("Ymd",strtotime(($nightNum-1)." day" ,strtotime($startDay)));


			$mail_contents .= "【".$nightNum."泊目】\n";


			//	部屋ごとの設定
			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				$mail_contents .= "(".$roomNum."部屋目)\n";

				$cnt++;
				$hotelBookingcontArray[$cnt]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
				//	リンカーン施設コード
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_LINK"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_DATE"] = $date;
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_ROOM"] = $roomNum;
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM1"] = $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM2"] = $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);
				$hotelBookingcontArray[$cnt]["night_number"] = $nightNum;
				$hotelBookingcontArray[$cnt]["adult_number"] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
				for ($i=1; $i<=6; $i++) {
					$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM".($i+2)] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i."");
				}

				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY1"] = $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_MONEY1");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY2"] = $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_MONEY2");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY3"] = $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_MONEY3");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY4"] = $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_MONEY4");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY5"] = $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_MONEY5");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY6"] = $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_MONEY6");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY7"] = $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_MONEY7");

				$hotelBookingcontArray[$cnt]["BOOKINGCONT_STATUS"] = 1;


				if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) > 0) {
					$mail_contents .= "大人：".number_format($collection->getByKey($collection->getKeyValue(), "ADULT_MONEY1"))."円 × ".$collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") > 0) {
					$mail_contents .= "小学生（低学年）：".number_format($collection->getByKey($collection->getKeyValue(), "CHILD_MONEY1"))."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") > 0) {
					$mail_contents .= "小学生（高学年）：".number_format($collection->getByKey($collection->getKeyValue(), "CHILD_MONEY2"))."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") > 0) {
					$mail_contents .= "幼児（食事・布団あり）：".number_format($collection->getByKey($collection->getKeyValue(), "CHILD_MONEY3"))."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") > 0) {
					$mail_contents .= "幼児（食事あり）：".number_format($collection->getByKey($collection->getKeyValue(), "CHILD_MONEY4"))."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") > 0) {
					$mail_contents .= "幼児（布団あり）：".number_format($collection->getByKey($collection->getKeyValue(), "CHILD_MONEY5"))."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") > 0) {
					$mail_contents .= "幼児（食事・布団なし）：".number_format($collection->getByKey($collection->getKeyValue(), "CHILD_MONEY6"))."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6")."人\n";
				}


				$mail_contents .= "小計：".number_format($collection->getByKey($collection->getKeyValue(), "ROOM_MONEY1"))."円\n\n";
//				$mail_contents .= "小計：".number_format($arPayList[$tdate]["money_all_all"])."円\n\n";

			}

		}
	}



/*
if ($collection->getByKey($collection->getKeyValue(), "confirm_x") or $collection->getByKey($collection->getKeyValue(), "regist")) {

	$mail_contents = "";
	//	泊数ごとの料金
	$money_night = 0;

	$money_all_all = 0;
	$point_all = 0;
	$cnt=0;

	$nightNum = 0;

	//	泊数ごと、部屋ごとの設定
	if (count($arPayList) > 0) {
		foreach ($arPayList as $ad) {

			$nightNum++;
			if ($nightNum > $collection->getByKey($collection->getKeyValue(), "night_number")) break;

			$tdate =  date("Ymd",strtotime(($nightNum-1)." day" ,strtotime($startDay)));


			$mail_contents .= "【".$nightNum."泊目】\n";


			//	部屋ごとの設定
			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				$mail_contents .= "(".$roomNum."部屋目)\n";

				$cnt++;
				$hotelBookingcontArray[$cnt]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
				//	リンカーン施設コード
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_LINK"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_DATE"] = $date;
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_ROOM"] = $roomNum;
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM1"] = $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM2"] = $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);
				$hotelBookingcontArray[$cnt]["night_number"] = $nightNum;
				$hotelBookingcontArray[$cnt]["adult_number"] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
				for ($i=1; $i<=6; $i++) {
					$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM".($i+2)] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i."");
				}

				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY1"] = $arPayList[$tdate][$roomNum]["money_adult_all"];
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY2"] = $arPayList[$tdate][$roomNum]["money_child1_all"];
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY3"] = $arPayList[$tdate][$roomNum]["money_child2_all"];
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY4"] = $arPayList[$tdate][$roomNum]["money_child3_all"];
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY5"] = $arPayList[$tdate][$roomNum]["money_child4_all"];
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY6"] = $arPayList[$tdate][$roomNum]["money_child5_all"];
				$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY7"] = $arPayList[$tdate][$roomNum]["money_child6_all"];

				$hotelBookingcontArray[$cnt]["BOOKINGCONT_STATUS"] = 1;


				if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) > 0) {
					$mail_contents .= "大人：".number_format($arPayList[$tdate][$roomNum]["money_adult"])."円 × ".$collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") > 0) {
					$mail_contents .= "小学生（低学年）：".number_format($arPayList[$tdate][$roomNum]["money_child1"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") > 0) {
					$mail_contents .= "小学生（高学年）：".number_format($arPayList[$tdate][$roomNum]["money_child2"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") > 0) {
					$mail_contents .= "幼児（食事・布団あり）：".number_format($arPayList[$tdate][$roomNum]["money_child3"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") > 0) {
					$mail_contents .= "幼児（食事あり）：".number_format($arPayList[$tdate][$roomNum]["money_child4"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") > 0) {
					$mail_contents .= "幼児（布団あり）：".number_format($arPayList[$tdate][$roomNum]["money_child5"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5")."人\n";
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") > 0) {
					$mail_contents .= "幼児（食事・布団なし）：".number_format($arPayList[$tdate][$roomNum]["money_child6"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6")."人\n";
				}


				$mail_contents .= "小計：".number_format($arPayList[$tdate]["money_all_all"])."円\n\n";

			}

		}
	}
*/

	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "HOTELPAY_ID", -1);
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_CHECKIN", $collection->getByKey($collection->getKeyValue(), "BOOKING_CHECKIN"));


	///////////////////////
	//	fax
	//	FAX番号
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "COMPANY_FAX", $company->getByKey($company->getKeyValue(), "COMPANY_FAX"));
	//	通知方法
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKSET_BOOKING_HOW1", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW1"));
	///////////////////////



	$d = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY");
	$h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
	$m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");
	/*
	$candate = date("Y-m-d",strtotime("-".($d-1)." day" ,strtotime($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"))));
	 $arData = cmHotelDaySelect();
	$d = $arData[$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")];
	$h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
	$m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");
	$candate = $d." ".$h."時".$m."分";
	*/
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END", '');
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END_TIME", '');
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_NIGHT", $collection->getByKey($collection->getKeyValue(), "night_number"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM", $collection->getByKey($collection->getKeyValue(), "room_number"));

	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NAME1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NAME2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_KANA1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_KANA2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_MAILADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_ZIP", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ZIP"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_PREF_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_PREF"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_CITY", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_CITY"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ADDRESS"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_BUILD", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_BUILD"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_TEL", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER", $collection->getByKey($collection->getKeyValue(), "BOOKING_ANSWER"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DEMAND", $collection->getByKey($collection->getKeyValue(), "BOOKING_DEMAND"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_STATUS", 1);

	/*
	if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {
		$money_all_all = $money_all_all + ($money_all_all * ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100));
		$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_SERVICE", $money_all_all);
	}
	*/
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_MONEY", $collection->getByKey($collection->getKeyValue(), "BOOKING_MONEY"));
//	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_MONEY", $arPayList["money_all"]);
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_HOW", $collection->getByKey($collection->getKeyValue(), "BOOKING_HOW"));


	$mail_contents .= "-----------------------------------------------------------------------\n";
	$mail_contents .= "合計：".number_format($collection->getByKey($collection->getKeyValue(), "BOOKING_MONEY"))."円（税・サービス料込）\n\n";
//	$mail_contents .= "合計：".number_format($arPayList["money_all"])."円（[税込]・[サービス料込]）\n\n";

	/*
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION") != "") {
		if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION_REC")==1) {
			//	回答必須
			$hotelBooking->setByKey($hotelBooking->getKeyValue(), "question_req", 1);
		}

		$hotelBooking->setByKey($hotelBooking->getKeyValue(), "question", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION"));
	}
	*/
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_POINT_USE", 1);

	//クーポンID
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "COUPON_ID_NUM", $collection->getByKey($collection->getKeyValue(), "COUPON_ID_NUM"));


	//	キャンセルポリシー
	$dataCancel = "";
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "TL_PLAN_CANCELDATA") == "") {

		if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {

			if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
				$can = "";
				if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
					$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
				}
				else {
					$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
				}
				$dataCancel .= "無不泊連絡 ".$can."\n";
			}

			if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {
				$can = "";
				if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
					$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
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
						$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
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
		$dataCancel = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "TL_PLAN_CANCELDATA");
	}

	$xmlArea = new xml(XML_AREA);
	$xmlArea->load();
	if (!$xmlArea->getXml()) {
		$hotelBooking->setErrorFirst("エリアデータの読み込みに失敗しました");
	}

	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "cancel_data", $dataCancel);
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "hotel_name", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "hotel_tel", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TEL"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "hotel_zip", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ZIP"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "hotel_address", $xmlArea->getNameByValue($hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF")).$hotel->getByKey($hotel->getKeyValue(), "HOTEL_CITY").$hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "hotel_checkin", date("Y-m-d",strtotime($startDay)));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "room_type", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "plan_name", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "check_out_time", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKOUT"));
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "cancel", $dataCancel);
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "payment", $mail_contents);
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "demand", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DEMAND"));


	$meal = "";
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 2) {
		$meal .= "朝食：あり";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 1) {
		$meal .= "朝食：なし";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_CHECK1") == 1) {
		$meal .= "　部屋だし";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_CHECK2") == 1) {
		$meal .= "　個室利用可";
	}
	$meal .= "\n";
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
		$meal .= "昼食：あり";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 1) {
		$meal .= "昼食：なし";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_CHECK1") == 1) {
		$meal .= "　部屋だし";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_CHECK2") == 1) {
		$meal .= "　個室利用可";
	}
	$meal .= "\n";
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 2) {
		$meal .= "夜食：あり";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 1) {
		$meal .= "夜食：なし";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_CHECK1") == 1) {
		$meal .= "　部屋だし";
	}
	if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_CHECK2") == 1) {
		$meal .= "　個室利用可";
	}
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "meal", $meal);
	$hotelBooking->setByKey($hotelBooking->getKeyValue(), "plan_contents", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FEATURE"));



	$hotelBooking->checkAll($hotelBookingcontArray);

	if ($hotelBooking->getCount() <= 0) {

		if ($collection->getByKey($collection->getKeyValue(), "regist")) {


			if (!$hotelBooking->save($hotelBookingcontArray)) {
				$hotelBooking->setErrorFirst("予約情報の保存に失敗しました。");

			}
			else {
				$linkCount = new linkCount($dbMaster);
				if (!$linkCount->save()) {
					return false;
				}
				$linkCount->getByKey($linkCount->getKeyValue(), "ID");
				
				require_once('includes/link/entryBooking.php');
				$entrybookret = $ar;
				//print_r($entrybookret);
//print_r(debug_backtrace());
				if ($entrybookret["entryBookingResult"]["commonResponse"]["resultCode"] == "True") {
					$bookingNum = $entrybookret["entryBookingResult"]["extendLincoln"]["tllBookingNumber"];
					if (!$hotelBooking->updateBooking($hotelBooking->getBookingId(), $bookingNum)) {
						$hotelBooking->setErrorFirst("予約情報のコード保存に失敗しました。");
					}
					else {
					$hotelBooking->linkmail($hotelBookingcontArray);
					//cmLocationChange("reservationcomplete.html");
					}
				}
				else {
					//予約失敗の場合、保存した予約をStatus変更
					$hotelBooking->updateBookingStatus($hotelBooking->getBookingId(), 9);
					$msgAr = $entrybookret["entryBookingResult"]["commonResponse"]["errorInfos"];
					if (count($msgAr) > 0) {
						foreach ($msgAr as $m) {
							$hotelBooking->setErrorFirst($m->errorMsg);
						}
					}
				}
			}

/*			if (!$hotelBooking->save($hotelBookingcontArray)) {
				$hotelBooking->setErrorFirst("予約情報の保存に失敗しました。");
			}
			else {

				$linkCount = new linkCount($dbMaster);
				if (!$linkCount->save()) {
					return false;
				}
				$linkCount->getByKey($linkCount->getKeyValue(), "ID");

				require_once('includes/link/entryBooking.php');
				$entrybookret = $ar;
//				print_r($entrybookret);exit;
				if ($entrybookret["entryBookingResult"]["commonResponse"]["resultCode"] == "True") {

					$bookingNum = $entrybookret["entryBookingResult"]["extendLincoln"]["tllBookingNumber"];
					if (!$hotelBooking->updateBooking($hotelBooking->getBookingId(), $bookingNum)) {
						$hotelBooking->setErrorFirst("予約情報のコード保存に失敗しました。");
					}
					else {
						cmLocationChange("reservationcomplete.html");
					}
				}
				else {
					//予約失敗の場合、保存した予約をStatus変更
					$hotelBooking->updateBookingStatus($hotelBooking->getBookingId(), 9);
					$msgAr = $entrybookret["entryBookingResult"]["commonResponse"]["errorInfos"];
					if (count($msgAr) > 0) {
						foreach ($msgAr as $m) {
							$hotelBooking->setErrorFirst($m->errorMsg);
						}
					}
				}
			}*/

		}
	}


}

?>