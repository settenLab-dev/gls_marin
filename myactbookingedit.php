<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
// require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/linkCount.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}


$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
$collection->setPost();

$hotelBooking = new hotelBooking($dbMaster);
$hotelBooking->selectCancelData(cmIdCheck("BOOKING_ID"), "", "", "", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
$hotelBooking->setPost();
if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "bookingConfirm")) {
	$hotelBooking->saveBooking();
	//$member->saveBirth();
}

$hotel = new hotel($dbMaster);
$hotelBookset = new hotelBookset($dbMaster);


if ($hotelBooking->getCount() > 0) {

	if($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")){
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "COMPANY_ID"));
	}
	
	$collection->setByKey($collection->getKeyValue(), "BOOKING_ID", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ID"));


	$hotel->selectList($collection);
	$hotelBookset->select($hotelBooking->getByKey($hotelBooking->getKeyValue(), "COMPANY_ID"));

	$hotelBookingcont = new hotelBookingcont($dbMaster);
	$hotelBookingcont->selectList($collection);
	$hotelBookingcont->setPost();
	$roomid = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "ROOM_ID");
	$hotelBookingcont->setByKey($hotelBookingcont->getKeyValue(),"ROOM_ID", $roomid);

	if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_LINK") == "") {
		//	ココモ
		$hotelPlan = new hotelPlan($dbMaster);
		$hotelPlan->select($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
		$hotelBookingcont->setByKey($hotelBookingcont->getKeyValue(), "HOTELPLAN_CAN_DAY", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY"));
		if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm")) {
			$hotelBookingcont->checkCancelConfirm();
		}
		elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel")) {
			$hotelBookingcont->checkCancel();

			if ( $hotelBookingcont->getErrorCount() <= 0 ) {
				/**
				 * ?置?件>>>>>>>>>>>
				 */
				/*?置?件--begin*/
					
				cmSetHotelSearchDef($collection);
					
				$hotelPlan = new hotelPlan($dbMaster);
				$hotelPlan->select($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
					
				$hotelRoom = new hotelRoom($dbMaster);
				$hotelRoom->select($hotelBooking->getByKey($hotelBooking->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
					
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
					$search_collection->setByKey($search_collection->getKeyValue(), "HOTELPLAN_ID", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ID"));
					$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "ROOM_ID"));
					$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DATE"));
					$search_collection->setByKey($search_collection->getKeyValue(), "adult_number", $collection->getByKey($collection->getKeyValue(), "adult_number".$i));
					$search_collection->setByKey($search_collection->getKeyValue(), "child_number1", $collection->getByKey($collection->getKeyValue(), "child_number".$i."1"));
					$search_collection->setByKey($search_collection->getKeyValue(), "child_number2", $collection->getByKey($collection->getKeyValue(), "child_number".$i."2"));
					$search_collection->setByKey($search_collection->getKeyValue(), "child_number3", $collection->getByKey($collection->getKeyValue(), "child_number".$i."3"));
					$search_collection->setByKey($search_collection->getKeyValue(), "child_number4", $collection->getByKey($collection->getKeyValue(), "child_number".$i."4"));
					$search_collection->setByKey($search_collection->getKeyValue(), "child_number5", $collection->getByKey($collection->getKeyValue(), "child_number".$i."5"));
					$search_collection->setByKey($search_collection->getKeyValue(), "child_number6", $collection->getByKey($collection->getKeyValue(), "child_number".$i."6"));
					$roomPerDay[$i] = $hotel->selectMoneyEveryRoom($search_collection);
					// 						print_r($hotelBooking->getCollection());exit;
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
				$hotelBookingcontArray = array();
				$mail_contents = "";
				//	泊数ごとの料金
				$money_night = 0;
					
				$point_all = 0;
				$cnt=0;
				for ($nightNum=1; $nightNum<=$collection->getByKey($collection->getKeyValue(), "night_number"); $nightNum++) {
				
				
					if ($hotelPayDsp->getByKey($nightNum, "HOTELPAY_ROOM_NUM") > 0) {
						$point_all += floor($money_all[$nightNum] * ($hotelPayDsp->getByKey($nightNum, "HOTELPAY_ROOM_NUM")/100));
					}
					//$mail_contents .= "【".$nightNum."泊目】\n";
				
					$money_night = 0;
				
					for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
							
						//$mail_contents .= "(".$roomNum."部屋目)\n";
							
						$cnt++;
						$hotelBookingcontArray[$cnt]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
						$hotelBookingcontArray[$cnt]["BOOKINGCONT_DATE"] = $collection->getByKey($collection->getKeyValue(), "target_date");
						$hotelBookingcontArray[$cnt]["BOOKINGCONT_ROOM"] = $roomNum;
						$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM1"] = $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
						$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM2"] = $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);
						$hotelBookingcontArray[$cnt]["night_number"] = $nightNum;
						$hotelBookingcontArray[$cnt]["adult_number"] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
						for ($i=1; $i<=6; $i++) {
							$hotelBookingcontArray[$cnt]["BOOKINGCONT_NUM".($i+2)] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i."");
							$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY".($i+1)] = $roomPerDay[$roomNum]["childFee".$i];
						}
						$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY1"] = $roomPerDay[$roomNum]["money_perperson"]*$collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
				
				
						if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) > 0) {
							$mail_contents .= "大人：".$roomPerDay[$roomNum]["money_perperson"]."円 × ".$collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") > 0) {
							$mail_contents .= "小人（A）：".number_format($roomPerDay[$roomNum]["childFee1"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") > 0) {
							$mail_contents .= "小人（B）：".number_format($roomPerDay[$roomNum]["childFee2"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") > 0) {
							$mail_contents .= "幼児（A）：".number_format($roomPerDay[$roomNum]["childFee3"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") > 0) {
							$mail_contents .= "幼児（B）：".number_format($roomPerDay[$roomNum]["childFee4"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") > 0) {
							$mail_contents .= "幼児（C）：".number_format($roomPerDay[$roomNum]["childFee5"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5")."人\n";
						}
						if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") > 0) {
							$mail_contents .= "幼児（D）：".number_format($roomPerDay[$roomNum]["childFee6"])."円 × ".$collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6")."人\n";
						}
							
						$hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY"] = $roomPerDay[$roomNum]["money_ALL"];
							
						$money_night += $hotelBookingcontArray[$cnt]["BOOKINGCONT_MONEY"];
							
						$hotelBookingcontArray[$cnt]["BOOKINGCONT_STATUS"] = $collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS");
					}
				
					$mail_contents .= "小計：".number_format($money_night)."円\n\n";
				}
					
				//	 	print_r($hotelBookingcontArray);
					
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "HOTELPAY_ID", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_ID"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DATE", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"));
// 				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_CHECKIN", $collection->getByKey($collection->getKeyValue(), "BOOKING_CHECKIN"));
					
				///////////////////////
				//	fax
				//	FAX番号
// 				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "COMPANY_FAX", $company->getByKey($company->getKeyValue(), "COMPANY_FAX"));
				//	通知方法
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKSET_BOOKING_HOW1", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW1"));
				///////////////////////
					
					
				// set notification id
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "NOTIFICATION_ID", $hotelBooking->getLastNotificationID($collection->getByKey($collection->getKeyValue(), "COMPANY_ID")));
					
					
				$d = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY");
				$h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
				$m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");
				$candate = date("Y-m-d",strtotime("-".($d-1)." day" ,strtotime($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"))));
				/*
				 $arData = cmHotelDaySelect();
				$d = $arData[$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")];
				$h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
				$m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");
				$candate = $d." ".$h."時".$m."分";
				*/
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END", $candate);
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END_TIME", $h.":".$m);
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_NIGHT", $collection->getByKey($collection->getKeyValue(), "night_number"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM", $collection->getByKey($collection->getKeyValue(), "room_number"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NAME1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_NAME2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_KANA1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_KANA2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"));
				// 				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_MAILADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_ZIP", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ZIP"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_PREF_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_PREF"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_CITY", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_CITY"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ADDRESS"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_BUILD", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_BUILD"));
				// 				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_TEL", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER", $collection->getByKey($collection->getKeyValue(), "BOOKING_ANSWER"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_DEMAND", $collection->getByKey($collection->getKeyValue(), "BOOKING_DEMAND"));
					
// 				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_STATUS", $collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS"));
					
				if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {
					//$money_all_all = $money_all_all + ($money_all_all * ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100));
					$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_SERVICE", $money_all_all*$hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100);
				}
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_MONEY", $money_all_all);
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_HOW", $collection->getByKey($collection->getKeyValue(), "BOOKING_HOW"));
					
					
				$mail_contents .= "-----------------------------------------------------------------------\n";
				$mail_contents .= "合計：".number_format($money_all_all)."円（税込）\n\n";
					
					
				if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION") != "") {
					if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION_REC")==1) {
						//	回答必須
						$hotelBooking->setByKey($hotelBooking->getKeyValue(), "question_req", 1);
					}
				
					$hotelBooking->setByKey($hotelBooking->getKeyValue(), "question", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION"));
				
				}
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "BOOKING_POINT_USE", $point_all);
					
					
					
				//	キャンセルポリシー
				$dataCancel = "";
				if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {
				
					if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {
							
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
				
					if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {
						$can = "";
						if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
							$can = "料金の".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%";
						}
						else {
							$can = "".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円";
						}
						$dataCancel .= "無連絡不着 ".$can."\n";
					}
				
					if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {
						$can = "";
						if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
							$can = "料金の".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%";
						}
						else {
							$can = "".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円";
						}
						$dataCancel .= "当日キャンセル ".$can."\n";
					}
				
					for ($i=3; $i<=6; $i++) {
						if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {
							$can = "";
							if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
								$can = "料金の".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%";
							}
							else {
								$can = "".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円";
							}
							$dataCancel .= $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)."～".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)."日前まで".$can."\n";
						}
					}
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
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "hotel_checkin", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "room_type", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "plan_name", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME"));
				$tmp_arr = explode(':',$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKOUT"));
				if(strlen($tmp_arr[1])==1);
				$checkout = $tmp_arr[0].':0'.$tmp_arr[1];
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "check_out_time",$checkout );
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "cancel", $dataCancel);
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "payment", $mail_contents);
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "demand", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DEMAND"));
				$hotelBooking->setByKey($hotelBooking->getKeyValue(), "hotel_url", URL_PUBLIC."search-detail.html?hid=".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
					
					
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
					
					
				//	print_r($hotelBooking);
					
				/**
				 *
				 * <<<<<<<<<<end
				 */
				if (!$hotelBookingcont->cancel($hotelBooking, $hotelBookset)) {
					$hotelBookingcont->setErrorFirst("予約のキャンセルに失敗しました。");
					$hotelBookingcont->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
				}
			}

		}
		else {
		}

	}
	else {
		//	リンカーン
		$hotelCode = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_LINK");
		$roomCode = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "ROOM_ID");
		$planCode = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ID");
		$bookingCode = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_BOOKING_CODE");
		$bookingDate = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DATE");

		$hotelPlan = new tlPlan($dbMaster);
		$hotelPlan->select($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_LINK"), $planCode, $roomCode);

		if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm")) {
		}
		elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel")) {

			$linkCount = new linkCount($dbMaster);
			if (!$linkCount->save()) {
				return false;
			}
			$linkCount->getByKey($linkCount->getKeyValue(), "ID");

			require_once('includes/link/deleteBooking.php');
			$dataarCancel = $ar;

			if ($dataarCancel["deleteBookingResult"]["commonResponse"]["resultCode"] == "True") {
				if ( $hotelBooking->getErrorCount() <= 0 ) {
					if (!$hotelBooking->cancelBookingLink()) {
						$hotelBooking->setErrorFirst("予約のキャンセルに失敗しました。");
						$hotelBooking->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
					}
				}
				else {
					cmLocationChange("myhotelbookingeditcomplete.html");
				}
			}
			else {
				$msgAr = $dataarCancel["deleteBookingResult"]["commonResponse"]["errorInfos"];
				$hotelBookingcont->setErrorFirst($msgAr["errorMsg"]);
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
<?php require("includes/box/common/meta201505.php"); ?>
<title>会員レジャー予約情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="mypoint">

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

        	<h2 class="title">会員レジャー予約情報</h2>

        	
        	<?php if ($hotelBookingcont->getErrorCount() > 0) {?>
			<?php print create_error_caption($hotelBookingcont->getError())?>
			<br />
			<?php }?>

        	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
        	<?php
        	if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_LINK") == "") {
				if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() <= 0) {
					print "キャンセルが完了しました。";
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() > 0) {
					require("includes/box/hotel/listCancelConfirmact.php");
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm") and $hotelBookingcont->getErrorCount() <= 0) {
					require("includes/box/hotel/listCancelConfirmact.php");
				}
				else {
					require("includes/box/hotel/listCancelact.php");
				}

			}
			else {
				if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() <= 0) {
					print "キャンセルが完了しました。";
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() > 0) {
					require("includes/box/hotel/listCancelConfirmLink.php");
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm") and $hotelBookingcont->getErrorCount() <= 0) {
					require("includes/box/hotel/listCancelConfirmLink.php");
				}
				else {
					require("includes/box/hotel/listCancelLink.php");
				}
			}


			?>
			<?php print $inputs->hidden("BOOKING_ID", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ID"));?>
			<?php print $inputs->hidden("BOOKING_LINK", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_LINK"));?>
			</form>
			</div>
        </section>

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
