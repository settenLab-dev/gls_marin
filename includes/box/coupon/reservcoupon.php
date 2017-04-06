<?php

$couponPlan = new couponPlan($dbMaster);
$couponPlan->select($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$couponShop = new couponShop($dbMaster);
$couponShop->select($collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

//	料金設定表示用
//$couponPayDsp = new hotelPay($dbMaster);

//	料金設定検索
/*
$couponPay = new hotelPay($dbMaster);
$couponPay->selectListPublic($collection);
if ($couponPay->getCount() > 0) {
	foreach ($couponPay->getCollectionByKey($couponPay->getKeyValue()) as $k=>$v) {
		$couponPayDsp->setByKey(1, $k, $v);
	}
}

$couponPayNext = new hotelPay($dbMaster);
if ($collection->getByKey($collection->getKeyValue(), "night_number") > 1) {
	$collection->setByKey($collection->getKeyValue(), "HOTELPAY_DATE", $couponPay->getByKey($couponPay->getKeyValue(), "HOTELPAY_DATE"));
	$couponPayNext->selectListPublicNext($collection);
}

//print_r($collection);exit;
if ($couponPayNext->getCount() > 0) {
	$roo = 1;
	foreach ($couponPayNext->getCollection() as $k=>$v) {
		$roo++;
		foreach ($couponPayNext->getCollectionByKey($k) as $k2=>$v2) {
			$couponPayDsp->setByKey($roo, $k2, $v2);
		}
	}
}
*/
//------------------start-------------------//
// new money logic, pick the cheapest one to show
/*
	$search_collection = new collection($db);
	$search_collection->setByKey($search_collection->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
	$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
	$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
	$search_collection->setByKey($search_collection->getKeyValue(), "adult_number", $collection->getByKey($collection->getKeyValue(), "adult_number".$i));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number1", $collection->getByKey($collection->getKeyValue(), "child_number".$i."1"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number2", $collection->getByKey($collection->getKeyValue(), "child_number".$i."2"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number3", $collection->getByKey($collection->getKeyValue(), "child_number".$i."3"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number4", $collection->getByKey($collection->getKeyValue(), "child_number".$i."4"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number5", $collection->getByKey($collection->getKeyValue(), "child_number".$i."5"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number6", $collection->getByKey($collection->getKeyValue(), "child_number".$i."6"));
*/
//	$roomPerDay[$i] = $coupon->selectMoneyEveryRoom($search_collection);	
//	print_r($search_collection);exit;
//	print_r($roomPerDay[$i]);exit;

/*
$money_all_all = 0;
for ($j=1; $j<=$collection->getByKey($collection->getKeyValue(), "night_number"); $j++){
	for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
		$money_all_all += $roomPerDay[$i]["money_ALL"];
		$money_all[$j] += $roomPerDay[$i]["money_ALL"];
	}
}
*/
//print($money_all_all);exit;

//------------------end-------------------//

/*
$couponProvide = new hotelProvide($dbMaster);
$couponProvide->select($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"), $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"), $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

// $couponBookingcont = new hotelBookingcont($dbMaster);
// print_r($collection);
// print_r($couponPlan->getCollection());
// print_r($couponPayDsp->getCollection());
// print '------------------------';
*/

$couponBookingcontArray = array();


if ($collection->getByKey($collection->getKeyValue(), "confirm_x") or $collection->getByKey($collection->getKeyValue(), "regist") or $collection->getByKey($collection->getKeyValue(), "change")) {
	// if ($_POST) {

	$mail_contents = "";
	$cnt=0;

	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONPLAN_ID", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONSHOP_ID", $collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPON_ID_NUM", $collection->getByKey($collection->getKeyValue(), "COUPON_ID_NUM"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPON_KEY_CODE", $collection->getByKey($collection->getKeyValue(), "COUPON_KEY_CODE"));

	if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1") != "" ){
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_KANA1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_KANA2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "MAIL_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"));
	}
	else{
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME1", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NAME1"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME2", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NAME2"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_KANA1", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_KANA1"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_KANA2", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_KANA2"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "MAIL_ADDRESS", $collection->getByKey($collection->getKeyValue(), "MAIL_ADDRESS"));
	}
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOKPLAN_USE_FROM", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_FROM"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOKPLAN_USE_TO", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_NUM", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NUM"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_PRICE", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_PRICE_ALL", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE_ALL"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "COUPONBOOK_STATUS", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_STATUS"));

	$xmlArea = new xml(XML_AREA);
	$xmlArea->load();
	if (!$xmlArea->getXml()) {
		$couponBooking->setErrorFirst("エリアデータの読み込みに失敗しました");
	}

	$couponBooking->setByKey($couponBooking->getKeyValue(), "cancel_data", $dataCancel);
	$couponBooking->setByKey($couponBooking->getKeyValue(), "couponshop_name", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_NAME"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "couponshop_tel", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_TEL"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "couponshop_address", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_ADDRESS"));

	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_name", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_NAME"));

					$arTemp = explode(":", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_AREA_LIST"));
 					if (count($arTemp) > 0) {
      						foreach ($arTemp as $data) {
      							if ($data != "") {
     								$arArea[$data] = $data;
       							}
       						}
	        			}
					$dataArea = cmJobArea();
					$cnt = 0;
					if (count($dataArea) > 0) {
						foreach ($dataArea as $k=>$v) {
							$cnt++;
							if ($cnt > 38) {
								break;
							}
							if ($arArea[$k] != "") {
								$area .= "$v";
								$area .= "・";
							}
						}
					}
	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_area", $area);

						$arCategory = "";
						$arTemp = explode(":", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_CATEGORY_LIST"));
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arCategory[$data] = $data;
        							}
        						}
		        			}
						$dataIcon = cmCouponCategory();
						$cnt = 0;
						if (count($dataCategory) > 0) {
							foreach ($dataCategory as $k=>$v) {
								$cnt++;
								if ($cnt > 35) {
									break;
								}
								$checked = '';
								if ($arCategory[$k] != "") {
									$category .= "$v";
								}
							}
						}
	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_category", $icon);

	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_reserve", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_RESERVE"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_useto", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_FROM")."～".$couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_use", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_use_memo", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_MEMO"));
	$couponBooking->setByKey($couponBooking->getKeyValue(), "plan_detail", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DETAIL"));
	
	//print_r($couponBooking);exit;
	$couponBooking->checkAll($couponBookingcontArray);

	if ($couponBooking->getCount() <= 0) {

		 //print_r($couponBookingcontArray);

		if ($collection->getByKey($collection->getKeyValue(), "regist")) {

			$saveStat = $couponBooking->save($couponBookingcontArray,$is_request);

			if (!$saveStat) {
				$couponBooking->setErrorFirst("問い合わせの送信に失敗しました。");
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