<?php
$options = array(
// 		'location'=> "https://test472.tl-lincoln.net/agtapi/v1/xml/RoomAndPlanInquiryService",
// 		'uri' => "https://test472.tl-lincoln.net/agtapi/v1/xml/",
// 		'soap_version' => SOAP_1_2,
		'trace' => 1
);

$client = new SoapClient("https://test472.tl-lincoln.net/agtapi/v1/xml/RoomAndPlanInquiryService?wsdl", $options);

$ar_children =
array(
	new SoapVar(array(
				new SoapVar(array(
						new SoapVar(SITE_TL_ID, XSD_STRING , null, null, 'agtId'),
						new SoapVar(SITE_TL_PASS, XSD_STRING , null, null, 'agtPassword'),
						new SoapVar(date("c"), XSD_DATETIME, null, null, 'systemDate'),
				), SOAP_ENC_OBJECT, null, null, 'commonRequest'),
				new SoapVar(array(
						new SoapVar($startDay, XSD_DATE, null, null, 'startDay'),
						new SoapVar($endDay, XSD_DATE, null, null, 'endDay'),
						new SoapVar("", XSD_INTEGER, null, null, 'minPrice'),
						new SoapVar("", XSD_INTEGER, null, null, 'maxPrice'),
						new SoapVar($num, XSD_INTEGER, null, null, 'perPaxCount'),
				), SOAP_ENC_OBJECT, null, null, 'extractionRequest'),
				new SoapVar(array(
						new SoapVar($hotelCode, XSD_STRING, null, null, 'tllHotelCode'),
						new SoapVar(array(
								new SoapVar($roomCode, XSD_INTEGER, null, null, 'tllRmTypeCode'),
								new SoapVar($planCode, XSD_INTEGER, null, null, 'tllPlanCode'),
						), SOAP_ENC_OBJECT, null, null, 'tllPlanInfos')
				), SOAP_ENC_OBJECT, null, null, 'hotelInfos')
			), SOAP_ENC_OBJECT, null, null, 'planPriceInfoAcquisitionRequest')
		);
$obj_parent = new SoapVar($ar_children, SOAP_ENC_OBJECT, null, null, 'planPriceInfoAcquisition');

// print_r($obj_parent);

try {
	$result = $client->planPriceInfoAcquisition($obj_parent);
// 	print_r($result);

	$ar = obj2arr($result);

}
catch (Exception $e) {
// 	var_dump($e);
	$error = "接続に失敗しました。";
}

?>