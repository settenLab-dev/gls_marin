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

	$form_make->setByKey($form_make->getKeyValue(), "COUPONPLAN_ID", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"));
	$form_make->setByKey($form_make->getKeyValue(), "COUPONSHOP_ID", $collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"));
	$form_make->setByKey($form_make->getKeyValue(), "COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	$form_make->setByKey($form_make->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));

	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOK_NAME1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1"));
	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOK_NAME2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"));
	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOK_KANA1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1"));
	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOK_KANA2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"));
	$form_make->setByKey($form_make->getKeyValue(), "MAIL_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"));

	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOKPLAN_USE_FROM", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_FROM"));
	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOKPLAN_USE_TO", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO"));
	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOK_NUM", 1);
	$form_make->setByKey($form_make->getKeyValue(), "COUPONBOOK_PRICE", $data["COUPONPLAN_SELL_PRICE"]);

	$xmlArea = new xml(XML_AREA);
	$xmlArea->load();
	if (!$xmlArea->getXml()) {
		$couponBooking->setErrorFirst("エリアデータの読み込みに失敗しました");
	}

	$form_make->setByKey($form_make->getKeyValue(), "couponshop_name", $data["COUPON_NAME"]);
	$form_make->setByKey($form_make->getKeyValue(), "couponshop_tel", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_TEL"));
	$form_make->setByKey($form_make->getKeyValue(), "couponshop_address", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_ADDRESS"));

	$form_make->setByKey($form_make->getKeyValue(), "plan_name", $data["COUPONPLAN_NAME"]);
	$form_make->setByKey($form_make->getKeyValue(), "plan_useto", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO"));

	//print_r($form_make);exit;

	if ($form_make->getCount() <= 0) {

		 
//print_r($couponBookingcontArray);

		if ($collection->getByKey($collection->getKeyValue(), "regist")) {

			$saveStat = $form_make->saveCouponForm($couponBookingcontArray,$is_request);

			if (!$saveStat) {
				$form_make->setErrorFirst("応募の送信に失敗しました。");
			}
			else {

				
			}

		}
	}

}

?>