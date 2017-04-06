<?php

$jobPlan = new jobPlan($dbMaster);
$jobPlan->select($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

//$jobRoom = new hotelRoom($dbMaster);
//$jobRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

//	料金設定表示用
//$jobPayDsp = new hotelPay($dbMaster);

//	料金設定検索
/*
$jobPay = new hotelPay($dbMaster);
$jobPay->selectListPublic($collection);
if ($jobPay->getCount() > 0) {
	foreach ($jobPay->getCollectionByKey($jobPay->getKeyValue()) as $k=>$v) {
		$jobPayDsp->setByKey(1, $k, $v);
	}
}

$jobPayNext = new hotelPay($dbMaster);
if ($collection->getByKey($collection->getKeyValue(), "night_number") > 1) {
	$collection->setByKey($collection->getKeyValue(), "HOTELPAY_DATE", $jobPay->getByKey($jobPay->getKeyValue(), "HOTELPAY_DATE"));
	$jobPayNext->selectListPublicNext($collection);
}

//print_r($collection);exit;
if ($jobPayNext->getCount() > 0) {
	$roo = 1;
	foreach ($jobPayNext->getCollection() as $k=>$v) {
		$roo++;
		foreach ($jobPayNext->getCollectionByKey($k) as $k2=>$v2) {
			$jobPayDsp->setByKey($roo, $k2, $v2);
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
//	$roomPerDay[$i] = $job->selectMoneyEveryRoom($search_collection);	
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
$jobProvide = new hotelProvide($dbMaster);
$jobProvide->select($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"), $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"), $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

// $jobBookingcont = new hotelBookingcont($dbMaster);
// print_r($collection);
// print_r($jobPlan->getCollection());
// print_r($jobPayDsp->getCollection());
// print '------------------------';
*/

$jobBookingcontArray = array();


if ($collection->getByKey($collection->getKeyValue(), "confirm_x") or $collection->getByKey($collection->getKeyValue(), "regist") or $collection->getByKey($collection->getKeyValue(), "change")) {
	// if ($_POST) {

	$mail_contents = "";
	$cnt=0;

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBPLAN_ID", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "MAIL_DATE", $collection->getByKey($collection->getKeyValue(), "MAIL_DATE"));
	if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1") != "" ){
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_NAME1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_NAME2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_KANA1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_KANA2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "MAIL_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"));
	}
	else{
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_NAME1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_NAME1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_NAME2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_NAME2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_KANA1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_KANA1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_KANA2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_KANA2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "MAIL_ADDRESS", $collection->getByKey($collection->getKeyValue(), "MAIL_ADDRESS"));
	}
	$jobBooking->setByKey($jobBooking->getKeyValue(), "SEX", $collection->getByKey($collection->getKeyValue(), "SEX"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_BIRTH1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_BIRTH2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_BIRTH3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_AGE", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_AGE"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_PREF", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_PREF"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_CITY", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_CITY"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_ADD", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ADD"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_BILD", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BILD"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_ACCESS_STATION", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_STATION"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_ACCESS_TOOL", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_TOOL"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_ACCESS_TIME", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_TIME"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_TEL1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TEL1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_TEL2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TEL2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_FAMILY", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_FAMILY"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_EDUCATION", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_EDUCATION"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_SCHOOL_NAME", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_NAME"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_SCHOOL_CORSE", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_CORSE"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_GRADUATION_DATE1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_GRADUATION_DATE1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_GRADUATION_DATE2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_GRADUATION_DATE2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_SCHOOL_ETC", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_ETC"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_TOEIC", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TOEIC"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_TOEFL", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TOEFL"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_STEP", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_STEP"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_E_LEVEL", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_E_LEVEL"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_LANGUAGE", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_LANGUAGE"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_OS", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_OS"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_SOFT", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SOFT"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_SOFT_HOTEL", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SOFT_HOTEL"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_SOFT_ETC", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SOFT_ETC"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_CAPACITY", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_CAPACITY"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_START", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_START"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_INCOME", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_INCOME"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_SELF_PR", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SELF_PR"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_MEMO", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_MEMO"));

	// 職務経歴
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD11", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD11"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD12", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD12"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD13", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD13"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD14", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD14"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL1"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO1", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO1"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD21", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD21"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD22", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD22"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD23", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD23"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD24", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD24"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL2"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO2", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO2"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD31", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD31"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD32", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD32"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD33", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD33"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD34", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD34"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL3"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO3", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO3"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY4"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME4"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY4"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD41", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD41"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD42", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD42"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD43", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD43"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD44", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD44"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND4"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION4"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE4"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL4"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO4", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO4"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY5"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME5"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY5"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD51", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD51"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD52", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD52"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD53", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD53"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD54", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD54"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND5"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION5"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE5"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL5"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO5", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO5"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY6"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME6"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY6"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD61", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD61"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD62", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD62"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD63", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD63"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD64", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD64"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND6"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION6"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE6"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL6"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO6", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO6"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY7"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME7"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY7"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD71", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD71"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD72", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD72"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD73", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD73"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD74", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD74"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND7"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION7"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE7"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL7"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO7", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO7"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY8"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME8"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY8"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD81", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD81"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD82", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD82"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD83", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD83"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD84", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD84"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND8"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION8"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE8"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL8"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO8", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO8"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY9"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME9"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY9"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD91", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD91"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD92", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD92"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD93", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD93"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD94", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD94"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND9"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION9"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE9"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL9"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO9", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO9"));

	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_COMPANY10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY10"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME10"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_COMPANY10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY10"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD101", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD101"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD102", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD102"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD103", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD103"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_PERIOD104", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD104"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_KIND10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND10"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_POSITION10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION10"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_TYPE10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE10"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_DETAIL10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL10"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "JOBBOOK_WORK_MEMO10", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO10"));

	$xmlArea = new xml(XML_AREA);
	$xmlArea->load();
	if (!$xmlArea->getXml()) {
		$jobBooking->setErrorFirst("エリアデータの読み込みに失敗しました");
	}

	$jobBooking->setByKey($jobBooking->getKeyValue(), "cancel_data", $dataCancel);
	$jobBooking->setByKey($jobBooking->getKeyValue(), "hotel_name", $job->getByKey($job->getKeyValue(), "JOBCOMPANY_NAME"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "hotel_tel", $job->getByKey($job->getKeyValue(), "JOB_TEL"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "hotel_zip", $job->getByKey($job->getKeyValue(), "JOB_PREF"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "hotel_address", $xmlArea->getNameByValue($job->getByKey($job->getKeyValue(), "JOB_PREF")).$job->getByKey($job->getKeyValue(), "JOB_CITY").$job->getByKey($job->getKeyValue(), "JOB_ADDRESS"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "hotel_checkin", $collection->getByKey($collection->getKeyValue(), "BOOKING_DATE"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "room_type", $jobRoom->getByKey($jobRoom->getKeyValue(), "ROOM_NAME"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_name", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_NAME"));

					$arTemp = explode(":", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_AREA_LIST"));
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
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_area", $area);

						$arTemp = explode(":", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_EMPLOYTYPE_LIST"));
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arEmploy[$data] = $data;
							
        							}
        						}
		        			}
						$dataEmploy = cmJobEmploy();
						if (count($dataEmploy) > 0) {
							foreach ($dataEmploy as $k=>$v) {
								if ($arEmploy[$k] != "") {
									$employ .= "$v";
									$employ .= "・";
								}
							}
						}
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_employ", $employ);

						$arTemp = explode(":", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_KINDTYPE_LIST"));
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arKind[$data] = $data;
        							}
        						}
		        			}
						$dataKind = cmJobKind();
						$cnt = 0;
						if (count($dataKind) > 0) {
							foreach ($dataKind as $k=>$v) {
								$cnt++;
								if ($cnt > 15) {
									break;
								}
								$checked = '';
								if ($arKind[$k] != "") {
									$kind .= "$v";
									$kind .= "・";
								}
							}
						}
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_kind", $kind);

						$arTemp = explode(":", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_COMPANYTYPE_LIST"));
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arCompany[$data] = $data;
        							}
        						}
		        			}
						$dataCompany = cmJobCompany();
						$cnt = 0;
						if (count($dataCompany) > 0) {
							foreach ($dataCompany as $k=>$v) {
								$cnt++;
								if ($cnt > 15) {
									break;
								}
								$checked = '';
								if ($arCompany[$k] != "") {
									$company .= "$v";
								}
							}
						}
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_company", $company);

						$arIcon = "";
						$arTemp = explode(":", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_ICON_LIST"));
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arIcon[$data] = $data;
        							}
        						}
		        			}
						$dataIcon = cmJobIcon();
						$cnt = 0;
						if (count($dataIcon) > 0) {
							foreach ($dataIcon as $k=>$v) {
								$cnt++;
								if ($cnt > 35) {
									break;
								}
								$checked = '';
								if ($arIcon[$k] != "") {
									$icon .= "$v";
									$icon .= "・";
								}
							}
						}

	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_icon", $icon);
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "check_out_time", $jobPlan->getByKey($jobPlan->getKeyValue(), "HOTELPLAN_CHECKOUT"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "cancel", $dataCancel);
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "payment", $mail_contents);
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "demand", $jobPlan->getByKey($jobPlan->getKeyValue(), "HOTELPLAN_DEMAND"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "hotel_url", URL_PUBLIC."search-detail.html?hid=".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
//	$jobBooking->setByKey($jobBooking->getKeyValue(), "meal", $meal);
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_worktime", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_WORKTIME"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_holyday", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_HOLYDAY"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_condition", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_CONDITION"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_money", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_MONEY"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_memo", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_MEMO"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_treat", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_TREAT"));
	$jobBooking->setByKey($jobBooking->getKeyValue(), "plan_contents", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_CONTENTS"));

	
//	print_r($jobBooking);exit;
	$jobBooking->checkAll($jobBookingcontArray);

	if ($jobBooking->getCount() <= 0) {

//		 print_r($jobBookingcontArray);

		if ($collection->getByKey($collection->getKeyValue(), "regist")) {

			$saveStat = $jobBooking->save($jobBookingcontArray,$is_request);

			if (!$saveStat) {
				$jobBooking->setErrorFirst("問い合わせの送信に失敗しました。");
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