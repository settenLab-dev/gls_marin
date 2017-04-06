<?php

$options = array(
// 		'location'=> "https://test472.tl-lincoln.net/agtapi/v1/xml/RoomAndPlanInquiryService",
// 		'uri' => "https://test472.tl-lincoln.net/agtapi/v1/xml/",
// 		'soap_version' => SOAP_1_2,
		'trace' => 1
);

$client = new SoapClient("https://www.tl-lincoln.net/agtapi/v1/xml/RoomAndPlanInquiryService?wsdl", $options);

//	ルーム指定
$roomAr = array();
if ($roomCode != "") {
	$roomAr = new SoapVar(array(
			new SoapVar($roomCode, XSD_INTEGER, null, null, 'tllRmTypeCode'),
	), SOAP_ENC_OBJECT, null, null, 'tllRmTypeInfos');
}

$ar_children =
array(
		new SoapVar(array(
				new SoapVar(array(
						new SoapVar(SITE_TL_ID, XSD_STRING , null, null, 'agtId'),
						new SoapVar(SITE_TL_PASS, XSD_STRING , null, null, 'agtPassword'),
						new SoapVar(date("c"), XSD_DATETIME, null, null, 'systemDate'),
				), SOAP_ENC_OBJECT, null, null, 'commonRequest'),
				new SoapVar(array(
						new SoapVar($num, XSD_INTEGER, null, null, 'perRmPaxCount'),
						new SoapVar($startDay, XSD_DATE, null, null, 'startDay'),
						new SoapVar($endDay, XSD_DATE, null, null, 'endDay'),
				), SOAP_ENC_OBJECT, null, null, 'extractionRequest'),
				new SoapVar(array(
						new SoapVar($hotelCode, XSD_STRING, null, null, 'tllHotelCode'),
						$roomAr
				), SOAP_ENC_OBJECT, null, null, 'hotelInfos')
		), SOAP_ENC_OBJECT, null, null, 'roomAvailabilityRequest')
);
$obj_parent = new SoapVar($ar_children, SOAP_ENC_OBJECT, null, null, 'roomAvailability');

try {
	$result = $client->roomAvailability($obj_parent);

	$ar = obj2arr($result);

 	//print_r($ar);
}
catch (Exception $e) {
// 	var_dump($e);
	$error = "接続に失敗しました。";
}

?>