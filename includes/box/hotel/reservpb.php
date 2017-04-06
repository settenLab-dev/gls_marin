<?php

$shopPlan = new shopPlan($dbMaster);
$shopPlan->select($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

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
	$search_collection = new collection($db);
	$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
	$search_collection->setByKey($search_collection->getKeyValue(), "SHOP_PRICETYPE_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID"));
	$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
	$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON1", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON1"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON2", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON3", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON4", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON5", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON6", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON7", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7"));
	$search_collection->setByKey($search_collection->getKeyValue(), "BOOKING_PRICEPERSON8", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8"));
	$roomPerDay = $shop->selectMoneyEveryRoomInsert($search_collection);	
	//print_r($roomPerDay);


$money_all_all = 0;
	$money_all_all += $roomPerDay["money_ALL"];
	$money_all[$j] += $roomPerDay["money_ALL"];

//print($money_all_all);

//------------------end-------------------//


$hotelProvide = new hotelProvide($dbMaster);
$hotelProvide->select($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"), $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"), $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

// $hotelBookingcont = new hotelBookingcont($dbMaster);
// print_r($collection);
// print_r($shopPlan->getCollection());
// print_r($hotelPayDsp->getCollection());
// print '------------------------';
$shopBookingcontArray = array();


if ($collection->getByKey($collection->getKeyValue(), "confirm_x") or $collection->getByKey($collection->getKeyValue(), "regist") or $collection->getByKey($collection->getKeyValue(), "change")) {
	// if ($_POST) {

	$mail_contents = "";
	//	泊数ごとの料金
	$money_night = 0;

	$point_all = 0;
	$cnt=0;
	for ($nightNum=1; $nightNum<=1; $nightNum++) {

	/* ポイント付与は後日実装
		if ($hotelPayDsp->getByKey($nightNum, "HOTELPAY_ROOM_NUM") > 0) {
			$point_all += floor($money_all[$nightNum] * ($hotelPayDsp->getByKey($nightNum, "HOTELPAY_ROOM_NUM")/100));
		}
	*/
		$money_night = 0;

		for ($roomNum=1; $roomNum<=1; $roomNum++) {

			//$mail_contents .= "(".$roomNum."部屋目)\n";

			$cnt++;
			$shopBookingcontArray[$cnt]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$shopBookingcontArray[$cnt]["BOOKING_DATE"] = $collection->getByKey($collection->getKeyValue(), "target_date");
			$shopBookingcontArray[$cnt]["BOOKING_ROOM"] = $roomNum;
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

	$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

//	$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOP_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_KIND"));

	$shopBooking->setByKey($shopBooking->getKeyValue(), "HOTELPAY_ID", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_ID"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

	// 店舗対応状況：初期は未設定
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_SHOP_STATUS", 1);
	// 予約方法：PlayBookingから
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_HOW", 0);
	
	// ※予約コード、キーコードはinsert時に生成

	// 催行日
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DATE", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"));

	//集合時間・場所
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MEET_TIME", $collection->getByKey($collection->getKeyValue(), "BOOKING_MEET_TIME"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MEET_PLACE", $collection->getByKey($collection->getKeyValue(), "BOOKING_MEET_PLACE"));

	//料金と人数

	//種別・料金名
	for ($i=1; $i<=6; $i++) {
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND".$i, $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND".$i));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE".$i, $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_MONEY".$i));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON".$i, $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON".$i));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MONEY".$i, $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_MONEY".$i));
	}

		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND7", 4);
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE7", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND7")."(".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_MONEY7MIN")."～".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_MONEY7MAX").")");
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON7", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7"));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MONEY7", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_MONEY7"));

	// 人数追加フラグがtrueの時
	if ($collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ADDFLG") == 1){
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND8", 4);
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE8", "人数追加");
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON8", $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8"));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MONEY8", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_MONEY8"));
	}

	// 合計料金

		$all_money = $roomPerDay["money_ALL"]; 
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ALL_MONEY", $all_money);


	///////////////////////
	//	fax
	//	FAX番号
	$shopBooking->setByKey($shopBooking->getKeyValue(), "COMPANY_FAX", $company->getByKey($company->getKeyValue(), "COMPANY_FAX"));
	//	通知方法
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKSET_BOOKING_HOW1", $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_BOOKING_HOW1"));
	///////////////////////


	$d = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_DAY");
	$h = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_HOUR");
	$m = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_MIN");
	$candate = date("Y-m-d",strtotime("-".($d-1)." day" ,strtotime($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"))));
	/*
	 $arData = cmHotelDaySelect();
	$d = $arData[$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_DAY")];
	$h = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_HOUR");
	$m = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_MIN");
	$candate = $d." ".$h."時".$m."分";
	*/
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END", $candate);
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END_TIME", $h.":".$m);

	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MEMBER_FLG", $collection->getByKey($collection->getKeyValue(), "BOOKING_MEMBER_FLG"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "MEMBER_ID", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"));

	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_NAME1", $collection->getByKey($collection->getKeyValue(), "BOOKING_NAME1"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_NAME2", $collection->getByKey($collection->getKeyValue(), "BOOKING_NAME2"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_KANA1", $collection->getByKey($collection->getKeyValue(), "BOOKING_KANA1"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_KANA2", $collection->getByKey($collection->getKeyValue(), "BOOKING_KANA2"));

	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS", $collection->getByKey($collection->getKeyValue(), "BOOKING_MAILADDRESS"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ZIP", $collection->getByKey($collection->getKeyValue(), "BOOKING_ZIP"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PREF_ID", $collection->getByKey($collection->getKeyValue(), "BOOKING_PREF_ID"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_CITY", $collection->getByKey($collection->getKeyValue(), "BOOKING_CITY"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS", $collection->getByKey($collection->getKeyValue(), "BOOKING_ADDRESS"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_BUILD", $collection->getByKey($collection->getKeyValue(), "BOOKING_BUILD"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_TEL", $collection->getByKey($collection->getKeyValue(), "BOOKING_TEL"));

	//質問への回答
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ANSWER", $collection->getByKey($collection->getKeyValue(), "BOOKING_ANSWER"));
	//要望
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DEMAND", $collection->getByKey($collection->getKeyValue(), "BOOKING_DEMAND"));

	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_STATUS", $collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS"));

	if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {
		//$money_all_all = $money_all_all + ($money_all_all * ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_SERVICE", $money_all_all*$hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100);
	}
//	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_ALL_MONEY", $money_all_all);
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_PAYMENT", $collection->getByKey($collection->getKeyValue(), "BOOKING_PAYMENT"));


	$mail_contents .= "-----------------------------------------------------------------------\n";
	$mail_contents .= "合計：".number_format($money_all_all)."円（[税込]・[サービス料込]）\n\n";


	if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION") != "") {
		if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION_REC")==1) {
			//	回答必須
			$shopBooking->setByKey($shopBooking->getKeyValue(), "question_req", 1);
		}

		$shopBooking->setByKey($shopBooking->getKeyValue(), "question", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION"));

	}
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_POINT_USE", $point_all);



	//	キャンセルポリシー
	$dataCancel = "";
	if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG_CANCEL") == 1) {

		if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {

			if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
				$can = "";
				if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
					$can = "料金の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
				}
				else {
					$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
				}
				$dataCancel .= "無連絡キャンセル ".$can."\n";
			}

			if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {
				$can = "";
				if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
					$can = "料金の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
				}
				else {
					$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
				}
				$dataCancel .= "当日キャンセル ".$can."\n";
			}

			for ($i=3; $i<=7; $i++) {
				if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {
					$can = "";
					if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
						$can = "料金の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
					}
					else {
						$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
					}
					$dataCancel .= $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで".$can."\n";
				}
			}

		}

	}
	else {

		if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG1") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1") != "") {
			$can = "";
			if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG1") == 1) {
				$can = "料金の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."%";
			}
			else {
				$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."円";
			}
			$dataCancel .= "無連絡キャンセル ".$can."\n";
		}

		if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG2") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2") != "") {
			$can = "";
			if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG2") == 1) {
				$can = "料金の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."%";
			}
			else {
				$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."円";
			}
			$dataCancel .= "当日キャンセル ".$can."\n";
		}

		for ($i=3; $i<=6; $i++) {
			if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i) != "") {
				$can = "";
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) == 1) {
					$can = "料金の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."%";
				}
				else {
					$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."円";
				}
				$dataCancel .= $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i)."～".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_TO".$i)."日前まで".$can."\n";
			}
		}
	}

	$xmlArea = new xml(XML_AREA);
	$xmlArea->load();
	if (!$xmlArea->getXml()) {
		$shopBooking->setErrorFirst("エリアデータの読み込みに失敗しました");
	}

	$shopBooking->setByKey($shopBooking->getKeyValue(), "cancel_data", $dataCancel);
	$shopBooking->setByKey($shopBooking->getKeyValue(), "shop_name", $shop->getByKey($shop->getKeyValue(), "SHOP_NAME"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "shop_tel", $shop->getByKey($shop->getKeyValue(), "SHOP_TEL"));
//	$shopBooking->setByKey($shopBooking->getKeyValue(), "shop_zip", $shop->getByKey($shop->getKeyValue(), "SHOP_ZIP"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "shop_address", $shop->getByKey($shop->getKeyValue(), "SHOP_CITY").$shop->getByKey($shop->getKeyValue(), "SHOP_ADDRESS"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "shop_checkin", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "room_type", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME"));
//	$shopBooking->setByKey($shopBooking->getKeyValue(), "night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
//	$shopBooking->setByKey($shopBooking->getKeyValue(), "room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "plan_name", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_NAME"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "check_out_time", $collection->getByKey($collection->getKeyValue(), "BOOKING_MEET_TIME"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "cancel", $dataCancel);
	$shopBooking->setByKey($shopBooking->getKeyValue(), "payment", $mail_contents);
	$shopBooking->setByKey($shopBooking->getKeyValue(), "BOOKING_DEMAND", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEMAND"));
	$shopBooking->setByKey($shopBooking->getKeyValue(), "shop_url", URL_PUBLIC."search-detail.html?id=".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

	$shopBooking->setByKey($shopBooking->getKeyValue(), "plan_contents", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DISCRIPTION"));

	
	print_r($shopBooking);
	$shopBooking->checkAll($shopBookingcontArray);

	if ($shopBooking->getCount() <= 0) {

		// 		print_r($shopBookingcontArray);

		if ($collection->getByKey($collection->getKeyValue(), "regist")) {

			$saveStat = $shopBooking->save($shopBookingcontArray,$is_request);
			if (!$saveStat) {
				$shopBooking->setErrorFirst("予約情報の保存に失敗しました。");
			}
			else {
//				if($collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS") == "5"){
//					cmLocationChange("reservation-requestcomplete.html");
//				}
//				else {
//					cmLocationChange("reservationcomplete.html");
//				}
				
			}

		}
	}

}

?>