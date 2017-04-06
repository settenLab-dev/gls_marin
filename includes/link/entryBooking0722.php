<?php
$options = array(
// 		'location'=> "https://test472.tl-lincoln.net/agtapi/v1/xml/RoomAndPlanInquiryService",
// 		'uri' => "https://test472.tl-lincoln.net/agtapi/v1/xml/",
// 		'soap_version' => SOAP_1_2,
		'trace' => 1
);

$client = new SoapClient("https://www.tl-lincoln.net/agtapi/v1/xml/ReservationControlService?wsdl", $options);

$bookingdata = array (

);

//	合計男人数
$man_all = 0;
//	合計女人数
$woman_all;
//	合計小学生(低)
$child1_all = 0;
//	合計小学生(高)
$child2_all = 0;
//	幼児
$child3_all = 0;
$child4_all = 0;
$child5_all = 0;
$child6_all = 0;
//	各情報配列

	foreach ($hotelPlan->getCollection() as $plan) {
		//print_r($plan);
	}
	foreach ($collection->getCollection() as $param) {
		//print_r($param);
	}
$arRooms = array();
for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
	$man_all += $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
	$woman_all += $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);

	$child1_all += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1");
	$child2_all += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2");
	$child3_all += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3");
	$child4_all += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4");
	$child5_all += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5");
	$child6_all += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6");

	//	部屋ごとの宿泊人数
	$arRooms[$roomNum]["otoko_ninnzuu"] = $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
	$arRooms[$roomNum]["onna_ninnzuu"] = $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);
	$arRooms[$roomNum]["otona_ninnzuu"] += $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
	$arRooms[$roomNum]["otona_ninnzuu"] += $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);
	$arRooms[$roomNum]["kodomo_ninnzu1"] += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1");
	$arRooms[$roomNum]["kodomo_ninnzu2"] += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2");
	$arRooms[$roomNum]["kodomo_ninnzu3"] += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3");
	$arRooms[$roomNum]["kodomo_ninnzu4"] += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4");
	$arRooms[$roomNum]["kodomo_ninnzu5"] += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5");
	$arRooms[$roomNum]["kodomo_ninnzu6"] += $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6");

	//	部屋ごとの有効人数を足し算
		$adultNum += $param["adult_man_".$roomNum];
		$adultNum += $param["adult_woman_".$roomNum];
		$childNum = 0;
//	$arRooms[$roomNum]["yuukou_ninnzuu"] += $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);
//	$arRooms[$roomNum]["yuukou_ninnzuu"] += $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);
	if($param["child_number".$roomNum."1"] > 0 && $plan["HOTELPAY_PS_DATA22"] == "1"){
	$childNum += $param["child_number".$roomNum."1"];
	}
	if($param["child_number".$roomNum."2"] > 0 && $plan["HOTELPAY_PS_DATA2"] == "1"){
	$childNum += $param["child_number".$roomNum."2"];
	}
	if($param["child_number".$roomNum."3"] > 0 && $plan["HOTELPAY_BB_DATA2"] == "1"){
	$childNum += $param["child_number".$roomNum."3"];
	}
	if($param["child_number".$roomNum."5"] > 0 && $plan["HOTELPAY_BB_DATA9"] == "1"){
	$childNum += $param["child_number".$roomNum."5"];
	}

	$arRooms[$roomNum]["yuukou_ninnzuu"] = $adultNum + $childNum;

}

//	リンカーン税区分
$flgtax = "";

if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPAY_MONEY_FLG") == 2) {
	$flgtax = "RoomRate";
}
else {
	$flgtax = "PersonalRate";
}


//	リンカーン用食事
$mealLinkCode = "";

$MealCondition = "";
$SpecificMealCondition = "";
$OtherServiceInformation = "";

if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 1 and
	$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 1 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 1) {
	//	食事なし
	$MealCondition = "WithoutMeal";
	$SpecificMealCondition = "";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "食事なし";
	}
	else {
		$OtherServiceInformation = "";
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 1 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 1) {
	//	朝食付き
	$MealCondition = "1nightBreakfast";
	$SpecificMealCondition = "IncludingBreakfast";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "朝食付";
	}
	else {
		$OtherServiceInformation = "";
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 1 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 1 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
	//	昼食付き
	$MealCondition = "Other";
	$SpecificMealCondition = "IncludingLunch";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "昼食付";
	}
	else {
		$OtherServiceInformation = "";
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 1 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 1) {
	//	夕食付き
	$MealCondition = "Other";
	$SpecificMealCondition = "IncludingDinner";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "夕食付";
	}
	else {
		$OtherServiceInformation = "";
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 1 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
	//	朝昼食付き
	$MealCondition = "1night2meals";
	$SpecificMealCondition = "IncludingBreakfastAndLunch";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "朝昼食付";
	}
	else {
		$OtherServiceInformation = "朝昼食付";
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 1) {
	//	朝夕食付き
	$MealCondition = "1night2meals";
	$SpecificMealCondition = "IncludingBreakfastAndDinner";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "朝夕食付";
	}
	else {
		$OtherServiceInformation = "朝夕食付";
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 1 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
	//	昼夕食付き
	$MealCondition = "1night2meals";
	$SpecificMealCondition = "IncludingLunchAndDinner";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "昼夕食付";
	}
	else {
		$OtherServiceInformation = "昼夕食付";
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") == 2 and
		$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
	//	３食付き
	$MealCondition = "Other";
	$SpecificMealCondition = "IncludingBreakfastAndLunchAndDinner";
	if ($flgtax == "RoomRate") {
		$OtherServiceInformation = "3食付";
	}
	else {
		$OtherServiceInformation = "3食付";
	}
}

$RoomAndGuestList = array();

for ($nightNum=1; $nightNum<=$collection->getByKey($collection->getKeyValue(), "night_number"); $nightNum++) {

	for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {

		$room_information = array();
		$room_rate_information = array();
		$RoomAndGuest = array();

		$tdate =  date("Ymd",strtotime(($nightNum-1)." day" ,strtotime($startDay)));


		/*
		$arRooms[$roomNum]["kingaku_otona_otoko"] = $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum) * $arPayList[$tdate][$roomNum]["money_adult"];
		$arRooms[$roomNum]["kingaku_otona_onna"] = $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum) * $arPayList[$tdate][$roomNum]["money_adult"];
		$arRooms[$roomNum]["kingaku_otona"] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) * $arPayList[$tdate][$roomNum]["money_adult"];
		$arRooms[$roomNum]["kingaku_kodomo1"] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") * $arPayList[$tdate][$roomNum]["money_child1"];
		$arRooms[$roomNum]["kingaku_kodomo2"] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") * $arPayList[$tdate][$roomNum]["money_child2"];
		$arRooms[$roomNum]["kingaku_kodomo3"] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") * $arPayList[$tdate][$roomNum]["money_child3"];
		$arRooms[$roomNum]["kingaku_kodomo4"] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") * $arPayList[$tdate][$roomNum]["money_child4"];
		$arRooms[$roomNum]["kingaku_kodomo5"] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") * $arPayList[$tdate][$roomNum]["money_child5"];
		$arRooms[$roomNum]["kingaku_kodomo6"] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") * $arPayList[$tdate][$roomNum]["money_child6"];
		*/
		$arRooms[$roomNum]["kingaku_otona_otoko"] = $collection->getByKey($collection->getKeyValue(), "ADULT_MONEY1");
		$arRooms[$roomNum]["kingaku_otona_onna"] = $collection->getByKey($collection->getKeyValue(), "ADULT_MONEY1");
		$arRooms[$roomNum]["kingaku_otona"] = $collection->getByKey($collection->getKeyValue(), "ADULT_MONEY1");
		$arRooms[$roomNum]["kingaku_kodomo1"] = $collection->getByKey($collection->getKeyValue(), "CHILD_MONEY1");
		$arRooms[$roomNum]["kingaku_kodomo2"] = $collection->getByKey($collection->getKeyValue(), "CHILD_MONEY2");
		$arRooms[$roomNum]["kingaku_kodomo3"] = $collection->getByKey($collection->getKeyValue(), "CHILD_MONEY3");
		$arRooms[$roomNum]["kingaku_kodomo4"] = $collection->getByKey($collection->getKeyValue(), "CHILD_MONEY4");
		$arRooms[$roomNum]["kingaku_kodomo5"] = $collection->getByKey($collection->getKeyValue(), "CHILD_MONEY5");
		$arRooms[$roomNum]["kingaku_kodomo6"] = $collection->getByKey($collection->getKeyValue(), "CHILD_MONEY6");

		$room_information[] = new SoapVar($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), XSD_STRING, null, null, 'RoomTypeCode');
		$room_information[] =new SoapVar($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME"), XSD_STRING, null, null, 'RoomTypeName');
// 		$room_information[] =new SoapVar("", XSD_STRING, null, null, 'RelationRoomCode');
// 		$room_information[] =new SoapVar("", XSD_STRING, null, null, 'RelationRoomName');
		if ($arRooms[$roomNum]["yuukou_ninnzuu"] > 0) {
			$room_information[] =new SoapVar($arRooms[$roomNum]["yuukou_ninnzuu"], XSD_INTEGER, null, null, 'PerRoomPaxCount');
		}
// 		$room_information[] =new SoapVar("", XSD_STRING, null, null, 'RepresentativePersonName');

		//	料金
		$room_rate_information[] = new SoapVar(date("Y-m-d",strtotime($tdate)), XSD_DATETIME, null, null, 'RoomDate');
		if ($arRooms[$roomNum]["kingaku_otona_otoko"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_otona_otoko"], XSD_INTEGER, null, null, 'PerPaxRate');
		}
		if ($arRooms[$roomNum]["kingaku_otona_onna"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_otona_onna"], XSD_INTEGER, null, null, 'PerPaxFemaleRate');
		}
		if ($arRooms[$roomNum]["kingaku_kodomo2"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_kodomo2"], XSD_INTEGER, null, null, 'PerChildA70Rate');
		}
		if ($arRooms[$roomNum]["kingaku_kodomo1"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_kodomo1"], XSD_INTEGER, null, null, 'PerChildA70Rate2');
		}
		if ($arRooms[$roomNum]["kingaku_kodomo3"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_kodomo3"], XSD_INTEGER, null, null, 'PerChildB50Rate');
		}
		if ($arRooms[$roomNum]["kingaku_kodomo4"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_kodomo4"], XSD_INTEGER, null, null, 'PerChildB50Rate2');
		}
		if ($arRooms[$roomNum]["kingaku_kodomo5"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_kodomo5"], XSD_INTEGER, null, null, 'PerChildC30Rate');
		}
		if ($arRooms[$roomNum]["kingaku_kodomo6"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kingaku_kodomo6"], XSD_INTEGER, null, null, 'PerChildDNoneRate');
		}
		//	人数
		if ($arRooms[$roomNum]["otoko_ninnzuu"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["otoko_ninnzuu"], XSD_INTEGER, null, null, 'RoomRatePaxMaleCount');
		}
		if ($arRooms[$roomNum]["onna_ninnzuu"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["onna_ninnzuu"], XSD_INTEGER, null, null, 'RoomRatePaxFemaleCount');
		}
		if ($arRooms[$roomNum]["kodomo_ninnzu2"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kodomo_ninnzu2"], XSD_INTEGER, null, null, 'RoomRateChildA70Count');
		}
		if ($arRooms[$roomNum]["kodomo_ninnzu1"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kodomo_ninnzu1"], XSD_INTEGER, null, null, 'RoomRateChildA70Count2');
		}
		if ($arRooms[$roomNum]["kodomo_ninnzu3"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kodomo_ninnzu3"], XSD_INTEGER, null, null, 'RoomRateChildB50Count');
		}
		if ($arRooms[$roomNum]["kodomo_ninnzu4"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kodomo_ninnzu4"], XSD_INTEGER, null, null, 'RoomRateChildB50Count2');
		}
		if ($arRooms[$roomNum]["kodomo_ninnzu5"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kodomo_ninnzu5"], XSD_INTEGER, null, null, 'RoomRateChildC30Count');
		}
		if ($arRooms[$roomNum]["kodomo_ninnzu6"] > 0) {
			$room_rate_information[] = new SoapVar($arRooms[$roomNum]["kodomo_ninnzu6"], XSD_INTEGER, null, null, 'RoomRateChildDNoneCount');
		}

		$room_rate_information[] = new SoapVar("小学生高学年", XSD_STRING, null, null, 'RoomChildA70Request');
		$room_rate_information[] = new SoapVar("小学生低学年", XSD_STRING, null, null, 'RoomChildA70Request2');
		$room_rate_information[] = new SoapVar("幼児(食事・布団あり)", XSD_STRING, null, null, 'RoomChildB50Request');
		$room_rate_information[] = new SoapVar("幼児(食事あり)", XSD_STRING, null, null, 'RoomChildB50Request2');
		$room_rate_information[] = new SoapVar("幼児(布団あり)", XSD_STRING, null, null, 'RoomChildC30Request');
		$room_rate_information[] = new SoapVar("幼児(食事・布団なし)", XSD_STRING, null, null, 'RoomChildDNoneRequest');

		$RoomAndGuest[] = new SoapVar($room_information, SOAP_ENC_OBJECT, null, null, 'RoomInformation');
		$RoomAndGuest[] = new SoapVar($room_rate_information, SOAP_ENC_OBJECT, null, null, 'RoomRateInformation');

		$RoomAndGuestList[] = new SoapVar($RoomAndGuest, SOAP_ENC_OBJECT, null, null, 'RoomAndGuest');
	}

}

// print_r($RoomAndGuestList);


/*
なしリスト
-------------------------
OptionInformation
CheckOutTime

*/

$ar_children =
array(
	new SoapVar(array(
				new SoapVar(array(
						new SoapVar(SITE_TL_ID, XSD_STRING , null, null, 'agtId'),
						new SoapVar(SITE_TL_PASS, XSD_STRING , null, null, 'agtPassword'),
						new SoapVar(date("c"), XSD_DATETIME, null, null, 'systemDate'),
				), SOAP_ENC_OBJECT, null, null, 'commonRequest'),

				new SoapVar(array(
						new SoapVar($hotelCode, XSD_STRING, null, null, 'tllHotelCode'),
						new SoapVar(0, XSD_STRING, null, null, 'useTllPlan'),
						new SoapVar("", XSD_STRING, null, null, 'tllBookingNumber'),
						new SoapVar("", XSD_INTEGER, null, null, 'tllCharge'),
				), SOAP_ENC_OBJECT, null, null, 'extendLincoln'),

				new SoapVar(array(
						new SoapVar(1, XSD_STRING, null, null, 'assignDiv'),
						new SoapVar(1, XSD_STRING, null, null, 'genderDiv'),
				), SOAP_ENC_OBJECT, null, null, 'SendInformation'),

				new SoapVar(array(
						new SoapVar(array(
								new SoapVar("FromTravelAgency", XSD_STRING, null, null, 'DataFrom'),
								new SoapVar("NewBookReport", XSD_STRING, null, null, 'DataClassification'),
								new SoapVar(date("Ymd",strtotime($startDay)).str_pad($linkCount->getByKey($linkCount->getKeyValue(), "ID"), 9, "0", STR_PAD_LEFT), XSD_STRING, null, null, 'DataID'),
						), SOAP_ENC_OBJECT, null, null, 'TransactionType'),

						new SoapVar(array(
								new SoapVar("", XSD_STRING, null, null, 'AccommodationArea'),
								new SoapVar($hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"), XSD_STRING, null, null, 'AccommodationName'),
								new SoapVar($hotelCode, XSD_STRING, null, null, 'AccommodationCode'),
								new SoapVar("", XSD_STRING, null, null, 'ChainName'),
						), SOAP_ENC_OBJECT, null, null, 'AccommodationInformation'),

						new SoapVar(array(
								new SoapVar("GlassSpace", XSD_STRING, null, null, 'SalesOfficeCompanyName'),
								new SoapVar("glass space 株式会社", XSD_STRING, null, null, 'SalesOfficeName'),
								new SoapVar("427", XSD_STRING, null, null, 'SalesOfficeCode'),
								new SoapVar("", XSD_STRING, null, null, 'SalesOfficePersonInCharge'),
								new SoapVar("info@glaspe.net", XSD_STRING, null, null, 'SalesOfficeEmail'),
								new SoapVar("098-988-8105", XSD_STRING, null, null, 'SalesOfficePhoneNumber'),
								new SoapVar("098-988-8106", XSD_STRING, null, null, 'SalesOfficeFaxNumber'),
						), SOAP_ENC_OBJECT, null, null, 'SalesOfficeInformation'),


						new SoapVar(array(
								new SoapVar($hotelBooking->getBookingId(), XSD_STRING, null, null, 'TravelAgencyBookingNumber'),
								new SoapVar(date("Y-m-d"), XSD_DATETIME, null, null, 'TravelAgencyBookingDate'),
								new SoapVar(date("H:m:s"), XSD_DATETIME, null, null, 'TravelAgencyBookingTime'),
								new SoapVar("", XSD_STRING, null, null, 'GuestOrGroupMiddleName'),
								//new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1")." ".$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"), XSD_STRING, null, null, 'GuestOrGroupNameSingleByte'),
								new SoapVar(mb_convert_kana($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1")." ".$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"),k), XSD_STRING, null, null, 'GuestOrGroupNameSingleByte'),
								new SoapVar("", XSD_STRING, null, null, 'GuestOrGroupNameDoubleByte'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")." ".$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"), XSD_STRING, null, null, 'GuestOrGroupKanjiName'),
								new SoapVar("", XSD_STRING, null, null, 'GuestOrGroupContactDiv'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL2"), XSD_STRING, null, null, 'GuestOrGroupCellularNumber'),
								new SoapVar("", XSD_STRING, null, null, 'GuestOrGroupOfficeNumber'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1"), XSD_STRING, null, null, 'GuestOrGroupPhoneNumber'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"), XSD_STRING, null, null, 'GuestOrGroupEmail'),
								new SoapVar("", XSD_STRING, null, null, 'GuestOrGroupPostalCode'),
								new SoapVar("", XSD_STRING, null, null, 'GuestOrGroupAddress'),
								new SoapVar("", XSD_STRING, null, null, 'GroupNameWelcomeBoard'),
								new SoapVar("", XSD_STRING, null, null, 'GuestGenderDiv'),
								new SoapVar("", XSD_STRING, null, null, 'GuestGeneration'),
								new SoapVar("", XSD_STRING, null, null, 'GuestAge'),
								new SoapVar(date("Y-m-d",strtotime($startDay)), XSD_DATE, null, null, 'CheckInDate'),
								new SoapVar($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CHECKIN"), XSD_STRING, null, null, 'CheckInTime'),
								new SoapVar("", XSD_DATETIME, null, null, 'CheckOutDate'),
								new SoapVar($collection->getByKey($collection->getKeyValue(), "night_number"), XSD_INTEGER, null, null, 'Nights'),
								new SoapVar("", XSD_STRING, null, null, 'Transportaion'),
								new SoapVar($collection->getByKey($collection->getKeyValue(), "room_number"), XSD_INTEGER, null, null, 'TotalRoomCount'),
								new SoapVar(number_format($man_all+$woman_all+$child1_all+$child2_all+$child3_all+$child4_all+$child5_all+$child6_all), XSD_INTEGER, null, null, 'GrandTotalPaxCount'),
								new SoapVar($man_all, XSD_INTEGER, null, null, 'TotalPaxMaleCount'),
								new SoapVar($woman_all, XSD_INTEGER, null, null, 'TotalPaxFemaleCount'),
								new SoapVar($child2_all, XSD_INTEGER, null, null, 'TotalChildA70Count'),
								new SoapVar($child1_all, XSD_INTEGER, null, null, 'TotalChildA70Count2'),
								new SoapVar($child3_all, XSD_INTEGER, null, null, 'TotalChildB50Count'),
								new SoapVar($child4_all, XSD_INTEGER, null, null, 'TotalChildB50Count2'),
								new SoapVar($child5_all, XSD_INTEGER, null, null, 'TotalChildC30Count'),
								new SoapVar($child6_all, XSD_INTEGER, null, null, 'TotalChildDNoneCount'),
								new SoapVar("", XSD_STRING, null, null, 'TypeOfGroupDoubleByte'),
								new SoapVar("", XSD_STRING, null, null, 'PackageType'),
								new SoapVar($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME"), XSD_STRING, null, null, 'PackagePlanName'),
								new SoapVar($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), XSD_STRING, null, null, 'PackagePlanCode'),
								new SoapVar("", XSD_STRING, null, null, 'PackagePlanContent'),
								new SoapVar($MealCondition, XSD_STRING, null, null, 'MealCondition'),
								new SoapVar($SpecificMealCondition, XSD_STRING, null, null, 'SpecificMealCondition'),
								new SoapVar("", XSD_STRING, null, null, 'ModificationPoint'),
								new SoapVar($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DEMAND"), XSD_STRING, null, null, 'SpecialServiceRequest'),
								new SoapVar($OtherServiceInformation, XSD_STRING, null, null, 'OtherServiceInformation'),
								new SoapVar("", XSD_STRING, null, null, 'SalesOfficeComment'),
								new SoapVar(array(
										new SoapVar($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_QUESTION"), XSD_STRING, null, null, 'FromHotelQuestion'),
										new SoapVar($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER"), XSD_STRING, null, null, 'ToHotelAnswer'),
								), SOAP_ENC_OBJECT, null, null, 'QuestionAndAnswerList'),
						), SOAP_ENC_OBJECT, null, null, 'BasicInformation'),

						new SoapVar(array(
								new SoapVar($flgtax, XSD_STRING, null, null, 'RoomRateOrPersonalRate'),
								new SoapVar("IncludingServiceAndTax", XSD_STRING, null, null, 'TaxServiceFee'),
								new SoapVar("", XSD_STRING, null, null, 'Payment'),
								new SoapVar("0", XSD_STRING, null, null, 'SettlementDiv'),
								new SoapVar($collection->getByKey($collection->getKeyValue(), "BOOKING_MONEY"), XSD_INTEGER, null, null, 'TotalAccommodationCharge'),
								new SoapVar("", XSD_STRING, null, null, 'TotalAccommodationConsumptionTax'),
								new SoapVar("", XSD_STRING, null, null, 'TotalAccommodationHotSpringTax'),
								new SoapVar("", XSD_STRING, null, null, 'TotalAccomodationServiceCharge'),
								new SoapVar($collection->getByKey($collection->getKeyValue(), "BOOKING_MONEY"), XSD_INTEGER, null, null, 'TotalAccommodationDiscountPoints'),
								new SoapVar("", XSD_STRING, null, null, 'TotalAccommodationConsumptionTaxAfterDiscountPoints'),
								new SoapVar($collection->getByKey($collection->getKeyValue(), "BOOKING_MONEY"), XSD_INTEGER, null, null, 'AmountClaimed'),
								new SoapVar(array(
										new SoapVar(0, XSD_INTEGER, null, null, 'PointsDiv'),
										new SoapVar("", XSD_STRING, null, null, 'PointsDiscountName'),
										new SoapVar(0, XSD_INTEGER, null, null, 'PointsDiscount'),
								), SOAP_ENC_OBJECT, null, null, 'PointsDiscountList'),
								new SoapVar(array(
										new SoapVar(0, XSD_INTEGER, null, null, 'DepositAmount'),
								), SOAP_ENC_OBJECT, null, null, 'DepositList'),
								new SoapVar("JPY", XSD_STRING, null, null, 'CurrencyCode'),
						), SOAP_ENC_OBJECT, null, null, 'BasicRateInformation'),


						new SoapVar(array(
								new SoapVar(mb_convert_kana($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1")." ".$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"), "k","utf-8"), XSD_STRING, null, null, 'MemberName'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")." ".$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"), XSD_STRING, null, null, 'MemberKanjiName'),
								new SoapVar("", XSD_STRING, null, null, 'MemberMiddleName'),
								new SoapVar("", XSD_STRING, null, null, 'MemberDateOfBirth'),
								new SoapVar("", XSD_STRING, null, null, 'MemberEmergencyNumber'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOccupation'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOrganization'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOrganizationKana'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOrganizationCode'),
								new SoapVar("", XSD_STRING, null, null, 'MemberPosition'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOfficePostalCode'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOfficeAddress'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOfficeTelephoneNumber'),
								new SoapVar("", XSD_STRING, null, null, 'MemberOfficeFaxNumber'),
								new SoapVar("", XSD_STRING, null, null, 'MemberGenderDiv'),
								new SoapVar("", XSD_STRING, null, null, 'MemberClass'),
								new SoapVar("", XSD_INTEGER, null, null, 'CurrentPoints'),
								new SoapVar("", XSD_STRING, null, null, 'MailDemandDiv'),
								new SoapVar("", XSD_STRING, null, null, 'PamphletDemandDiv'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"), XSD_STRING, null, null, 'MemberID'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "TEL1"), XSD_STRING, null, null, 'MemberPhoneNumber'),
								new SoapVar($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"), XSD_STRING, null, null, 'MemberEmail'),
								new SoapVar("", XSD_STRING, null, null, 'MemberPostalCode'),
								new SoapVar("", XSD_STRING, null, null, 'MemberAddress'),
						), SOAP_ENC_OBJECT, null, null, 'MemberInformation'),

						new SoapVar(array(
								new SoapVar($RoomAndGuestList, SOAP_ENC_OBJECT, null, null, 'RoomAndGuestList'),
						), SOAP_ENC_OBJECT, null, null, 'RoomInformationList'),

				), SOAP_ENC_OBJECT, null, null, 'AllotmentBookingReport'),


			), SOAP_ENC_OBJECT, null, null, 'entryBookingRequest')
		);
$obj_parent = new SoapVar($ar_children, SOAP_ENC_OBJECT, null, null, 'entryBooking');
// print_r(obj2arr($obj_parent));
// print "<br />";
// print "<br />";
// print "<br />";
// print "<br />";
// print "<br />";

try {
	$result = $client->entryBooking($obj_parent);
// 	print_r($result);

	$ar = obj2arr($result);

}
catch (Exception $e) {
	var_dump($e);
	$error = "接続に失敗しました。";
}

?>