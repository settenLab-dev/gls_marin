<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/Room.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

/*
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}
*/

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
$collection->setPost();

$shopBooking = new shopBooking($dbMaster);
$shopBooking->selectCancelData(cmIdCheck("BOOKING_ID"), "", "", "", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
$shopBooking->setPost();
if ($shopBooking->getByKey($shopBooking->getKeyValue(), "bookingConfirm")) {
	$shopBooking->saveBooking();
	//$member->saveBirth();
}

$shop = new shop($dbMaster);
$shopBookset = new shopBookset($dbMaster);


if ($shopBooking->getCount() > 0) {

	if($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")){
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "COMPANY_ID"));
	}
	
	$collection->setByKey($collection->getKeyValue(), "BOOKING_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ID"));


	$hotel->selectList($collection);
	$hotelBookset->select($shopBooking->getByKey($shopBooking->getKeyValue(), "COMPANY_ID"));

	$shopBookingcont = new shopBookingcont($dbMaster);
	$shopBookingcont->selectList($collection);
	$shopBookingcont->setPost();
	$roomid = $shopBooking->getByKey($shopBooking->getKeyValue(), "ROOM_ID");
	$shopBookingcont->setByKey($shopBookingcont->getKeyValue(),"ROOM_ID", $roomid);

	if ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_LINK") == "") {
		//	ココモ
		$shopPlan = new shopPlan($dbMaster);
		$shopPlan->select($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
		$shopBookingcont->setByKey($shopBookingcont->getKeyValue(), "SHOPPLAN_CAN_DAY", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_DAY"));
		if ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancelconfirm")) {
			$shopBookingcont->checkCancelConfirm();
		}
		elseif ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel")) {
			$shopBookingcont->checkCancel();

			if ( $shopBookingcont->getErrorCount() <= 0 ) {
				/**
				 * ?置?件>>>>>>>>>>>
				 */
				/*?置?件--begin*/
					
				cmSetHotelSearchDef($collection);
					
				$shopPlan = new shopPlan($dbMaster);
				$shopPlan->select($shopBooking->getByKey($shopBooking->getKeyValue(), "SHOPPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
					
				$hotelRoom = new Room($dbMaster);
				$hotelRoom->select($shopBooking->getByKey($shopBooking->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
					
				//	料金設定表示用
				$hotelPayDsp = new hotelPay($dbMaster);
					
				//	料金設定検索
				$hotelPay = new hotelPay($dbMaster);
				$hotelPay->selectListPublic($collection);
				if ($hotelPay->getCount() > 0) {
					foreach ($hotelPay->getCollectionByKey($hotelPay->getKeyValue()) as $k=>$v) {
						$hotelPayDsp->setByKey(1, $k, $v);
					}
				}
				$hotelPayNext = new hotelPay($dbMaster);
				if ($collection->getByKey($collection->getKeyValue(), "night_number") > 1) {
					$collection->setByKey($collection->getKeyValue(), "HOTELPAY_DATE", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"));
					$hotelPayNext->selectListPublicNext($collection);
				}
					
				//print_r($collection);exit;
				if ($hotelPayNext->getCount() > 0) {
					$roo = 1;
					foreach ($hotelPayNext->getCollection() as $k=>$v) {
						$roo++;
						foreach ($hotelPayNext->getCollectionByKey($k) as $k2=>$v2) {
							$hotelPayDsp->setByKey($roo, $k2, $v2);
						}
					}
				}
					
				//------------------start-------------------//
				// new money logic, pick the cheapest one to show
				for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
					$search_collection = new collection($db);
					$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "HOTELPLAN_ID"));
					$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "ROOM_ID"));
					$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE"));
					$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));
					$roomPerDay[$i] = $shop->selectMoneyEveryRoom($search_collection);
					// 						print_r($shopBooking->getCollection());exit;
				}
					
				$money_all_all = 0;
				for ($j=1; $j<=$collection->getByKey($collection->getKeyValue(), "night_number"); $j++){
					for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
						$money_all_all += $roomPerDay[$i]["money_ALL"];
						$money_all[$j] += $roomPerDay[$i]["money_ALL"];
					}
				}
					
					
					
				$hotelProvide = new hotelProvide($dbMaster);
				$hotelProvide->select($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"), $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"), $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
				$shopBookingcontArray = array();
				$mail_contents = "";
				//	泊数ごとの料金
				$money_night = 0;
					
				$point_all = 0;
				$cnt=0;
				for ($nightNum=1; $nightNum<=$collection->getByKey($collection->getKeyValue(), "night_number"); $nightNum++) {
				
				
					if ($hotelPayDsp->getByKey($nightNum, "HOTELPAY_ROOM_NUM") > 0) {
						$point_all += floor($money_all[$nightNum] * ($hotelPayDsp->getByKey($nightNum, "HOTELPAY_ROOM_NUM")/100));
					}
					$mail_contents .= "【".$nightNum."泊目】\n";
				
					$money_night = 0;
				
					for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
							
						$mail_contents .= "(".$roomNum."部屋目)\n";
							
						$cnt++;
						$shopBookingcontArray[$cnt]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
						$shopBookingcontArray[$cnt]["BOOKINGCONT_DATE"] = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE");
						//$shopBookingcontArray[$cnt]["BOOKINGCONT_DATE"] = $collection->getByKey($collection->getKeyValue(), "target_date");
						$shopBookingcontArray[$cnt]["BOOKINGCONT_ROOM"] = $roomNum;
						$shopBookingcontArray[$cnt]["BOOKINGCONT_NUM1"] = $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
						$shopBookingcontArray[$cnt]["BOOKINGCONT_NUM2"] = $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);
						$shopBookingcontArray[$cnt]["night_number"] = $nightNum;
						$shopBookingcontArray[$cnt]["adult_number"] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
						for ($i=1; $i<=6; $i++) {
							$shopBookingcontArray[$cnt]["BOOKINGCONT_NUM".($i+2)] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i."");
							$shopBookingcontArray[$cnt]["BOOKINGCONT_MONEY".($i+1)] = $roomPerDay[$roomNum]["childFee".$i];
						}
						$shopBookingcontArray[$cnt]["BOOKINGCONT_MONEY1"] = $roomPerDay[$roomNum]["money_perperson"]*$collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
				
				
						if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) > 0) {
							$mail_contents .= "大人：".$roomPerDay[$roomNum]["money_perperson"]."円 × ".$collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") > 0) {
							$mail_contents .= "小学生（低学年）：".number_format($roomPerDay[$roomNum]["childFee1"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") > 0) {
							$mail_contents .= "小学生（高学年）：".number_format($roomPerDay[$roomNum]["childFee2"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") > 0) {
							$mail_contents .= "幼児（食事・布団あり）：".number_format($roomPerDay[$roomNum]["childFee3"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") > 0) {
							$mail_contents .= "幼児（食事あり）：".number_format($roomPerDay[$roomNum]["childFee4"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") > 0) {
							$mail_contents .= "幼児（布団あり）：".number_format($roomPerDay[$roomNum]["childFee5"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") > 0) {
							$mail_contents .= "幼児（食事・布団なし）：".number_format($roomPerDay[$roomNum]["childFee6"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6")."人\n";
						}
							
						$shopBookingcontArray[$cnt]["BOOKINGCONT_MONEY"] = $roomPerDay[$roomNum]["money_ALL"];
							
						$money_night += $shopBookingcontArray[$cnt]["BOOKINGCONT_MONEY"];
							
						$shopBookingcontArray[$cnt]["BOOKINGCONT_STATUS"] = $collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS");
					}
				
					$mail_contents .= "小計：".number_format($money_night)."円\n\n";
				}
					
				//	 	print_r($shopBookingcontArray);
					
				$shopBooking->setByKey($shopBooking->getKeyValue(), "HOTELPLAN_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "HOTELPLAN_ID"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "HOTELPAY_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "HOTELPAY_ID"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DATE", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE"));
// 				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_CHECKIN", $collection->getByKey($collection->getKeyValue(), "BOOKING_CHECKIN"));
					
				///////////////////////
				//	fax
				//	FAX番号
// 				$shopBooking->setByKey($shopBooking->getKeyValue(), "COMPANY_FAX", $company->getByKey($company->getKeyValue(), "COMPANY_FAX"));
				//	通知方法
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKSET_BOOKING_HOW1", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW1"));
				///////////////////////
					
					
				// set notification id
				$shopBooking->setByKey($shopBooking->getKeyValue(), "NOTIFICATION_ID", $shopBooking->getLastNotificationID($collection->getByKey($collection->getKeyValue(), "COMPANY_ID")));
					
					
				$d = $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CAN_DAY");
				$h = $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
				$m = $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");
				$candate = date("Y-m-d",strtotime("-".($d-1)." day" ,strtotime($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE"))));
				/*
				 $arData = cmHotelDaySelect();
				$d = $arData[$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")];
				$h = $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
				$m = $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");
				$candate = $d." ".$h."時".$m."分";
				*/
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END", $candate);
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END_TIME", $h.":".$m);
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_NUM_NIGHT", $collection->getByKey($collection->getKeyValue(), "night_number"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_NUM_ROOM", $collection->getByKey($collection->getKeyValue(), "room_number"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_NAME1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_NAME2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_KANA1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_KANA2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"));
				// 				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ZIP", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ZIP"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PREF_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_PREF"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_CITY", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_CITY"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ADDRESS"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_BUILD", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_BUILD"));
				// 				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_TEL", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ANSWER", $collection->getByKey($collection->getKeyValue(), "BOOKING_ANSWER"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DEMAND", $collection->getByKey($collection->getKeyValue(), "BOOKING_DEMAND"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_HOW", $collection->getByKey($collection->getKeyValue(), "BOOKING_HOW"));
				//クーポンID
				$shopBooking->setByKey($shopBooking->getKeyValue(), "COUPON_ID_NUM", $shopBooking->getByKey($shopBooking->getKeyValue(), "COUPON_ID_NUM"));
					
// 				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_STATUS", $collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS"));
					
				if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {
					//$money_all_all = $money_all_all + ($money_all_all * ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100));
					$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_SERVICE", $money_all_all*$hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100);
				}
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MONEY", $money_all_all);
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_HOW", $collection->getByKey($collection->getKeyValue(), "BOOKING_HOW"));
					
					
				$mail_contents .= "-----------------------------------------------------------------------\n";
				$mail_contents .= "合計：".number_format($money_all_all)."円（[税込]・[サービス料込]）\n\n";
					
					
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_QUESTION") != "") {
					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_QUESTION_REC")==1) {
						//	回答必須
						$shopBooking->setByKey($shopBooking->getKeyValue(), "question_req", 1);
					}
				
					$shopBooking->setByKey($shopBooking->getKeyValue(), "question", $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_QUESTION"));
				
				}
				$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_POINT_USE", $point_all);
					
					
					
				//	キャンセルポリシー
				$dataCancel = "";
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {
				
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
				
					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {
						$can = "";
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
							$can = "宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%";
						}
						else {
							$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円";
						}
						$dataCancel .= "無不泊連絡 ".$can."\n";
					}
				
					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {
						$can = "";
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
							$can = "宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%";
						}
						else {
							$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円";
						}
						$dataCancel .= "当日キャンセル ".$can."\n";
					}
				
					for ($i=3; $i<=6; $i++) {
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {
							$can = "";
							if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
								$can = "宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%";
							}
							else {
								$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円";
							}
							$dataCancel .= $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)."～".$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)."日前まで".$can."\n";
						}
					}
				}
					
				$xmlArea = new xml(XML_AREA);
				$xmlArea->load();
				if (!$xmlArea->getXml()) {
					$shopBooking->setErrorFirst("エリアデータの読み込みに失敗しました");
				}
					
				$shopBooking->setByKey($shopBooking->getKeyValue(), "cancel_data", $dataCancel);
				$shopBooking->setByKey($shopBooking->getKeyValue(), "hotel_name", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "hotel_tel", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TEL"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "hotel_zip", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ZIP"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "hotel_address", $xmlArea->getNameByValue($hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF")).$hotel->getByKey($hotel->getKeyValue(), "HOTEL_CITY").$hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "hotel_checkin", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "room_type", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "plan_name", $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_NAME"));
				$tmp_arr = explode(':',$shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_CHECKOUT"));
				if(strlen($tmp_arr[1])==1);
				$checkout = $tmp_arr[0].':0'.$tmp_arr[1];
				$shopBooking->setByKey($shopBooking->getKeyValue(), "check_out_time",$checkout );
				$shopBooking->setByKey($shopBooking->getKeyValue(), "cancel", $dataCancel);
				$shopBooking->setByKey($shopBooking->getKeyValue(), "payment", $mail_contents);
				$shopBooking->setByKey($shopBooking->getKeyValue(), "demand", $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_DEMAND"));
				$shopBooking->setByKey($shopBooking->getKeyValue(), "hotel_url", URL_PUBLIC."search-detail.html?hid=".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
					
					
				$meal = "";
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 2) {
					$meal .= "朝食：あり";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 1) {
					$meal .= "朝食：なし";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_BF_CHECK1") == 1) {
					$meal .= "　部屋だし";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_BF_CHECK2") == 1) {
					$meal .= "　個室利用可";
				}
				$meal .= "\n";
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
					$meal .= "昼食：あり";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 1) {
					$meal .= "昼食：なし";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_LN_CHECK1") == 1) {
					$meal .= "　部屋だし";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_LN_CHECK2") == 1) {
					$meal .= "　個室利用可";
				}
				$meal .= "\n";
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 2) {
					$meal .= "夜食：あり";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 1) {
					$meal .= "夜食：なし";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_DN_CHECK1") == 1) {
					$meal .= "　部屋だし";
				}
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_DN_CHECK2") == 1) {
					$meal .= "　個室利用可";
				}
				$shopBooking->setByKey($shopBooking->getKeyValue(), "meal", $meal);
				$shopBooking->setByKey($shopBooking->getKeyValue(), "plan_contents", $shopPlan->getByKey($shopPlan->getKeyValue(), "HOTELPLAN_FEATURE"));
					
					
				//	print_r($shopBooking);
					
				/**
				 *
				 * <<<<<<<<<<end
				 */
				if (!$shopBookingcont->cancel($shopBooking, $hotelBookset)) {
					$shopBookingcont->setErrorFirst("予約のキャンセルに失敗しました。");
					$shopBookingcont->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
				}
			}

		}
		else {
		}

	}

}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_detail.php"); ?>
<title>予約申し込み履歴 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<script type="text/javascript">
$(function() {
   		$("#BOOKING_REQUEST").attr("disabled","disabled");
});
</script>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->
<!-- InstanceEndEditable -->

<!--content-->
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="content">

        <!--日付・人数から検索-->
        <section class="box">
			<div class="inner">
        	<div id="hmenu_cn" class="radius10">
    	    	<menu class="mypge-menu">
	        		<li><a href="<?php print URL_PUBLIC?>mypage.html">マイページトップ</a></li>
	        		<li><a href="<?php print URL_PUBLIC?>mybasic.html">会員基本情報確認・変更</a></li>
        			<li><a href="<?php print URL_PUBLIC?>myhotel.html">宿泊・レジャー予約情報</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mycoupon.html">購入したクーポン</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mypoint.html">ポイント履歴</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></li>
    	    	</menu>
	        	<div class="bt-logout_cn">
        			<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
        	         <p class="bt-td"><?=$inputs->submit("","logout","ログアウト", "circle")?></p>
    	       		</form>
	           	</div>
           	</div>

        	<h2 class="title">予約申し込み履歴</h2>

        	<?php // print_r($shopBooking);?>
        	<?php if ($shopBookingcont->getErrorCount() > 0) {?>
			<?php print create_error_caption($shopBookingcont->getError())?>
			<br />
			<?php }?>

        	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
        	<?php
				if ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel") and $shopBookingcont->getErrorCount() <= 0) {
					print "キャンセルが完了しました。";
				}
				elseif ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel") and $shopBookingcont->getErrorCount() > 0) {
					require("includes/box/hotel/listCancelConfirm.php");
				}
				elseif ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancelconfirm") and $shopBookingcont->getErrorCount() <= 0) {
					require("includes/box/hotel/listCancelConfirm.php");
				}
				else {
					require("includes/box/hotel/listCancel.php");
				}

			?>
			<?php print $inputs->hidden("BOOKING_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ID"));?>
			</form>
			</div>
        </section>


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
