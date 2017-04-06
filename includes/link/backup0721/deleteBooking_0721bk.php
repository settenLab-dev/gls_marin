<?php
$options = array(
// 		'location'=> "https://test472.tl-lincoln.net/agtapi/v1/xml/RoomAndPlanInquiryService",
// 		'uri' => "https://test472.tl-lincoln.net/agtapi/v1/xml/",
// 		'soap_version' => SOAP_1_2,
		'trace' => 1
);

$client = new SoapClient("https://test472.tl-lincoln.net/agtapi/v1/xml/ReservationControlService?wsdl", $options);

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
						new SoapVar($bookingCode, XSD_STRING, null, null, 'tllBookingNumber'),
						new SoapVar(date("Ymd",strtotime($bookingDate)).str_pad($linkCount->getByKey($linkCount->getKeyValue(), "ID"), 9, "0", STR_PAD_LEFT), XSD_STRING, null, null, 'DataID'),
				), SOAP_ENC_OBJECT, null, null, 'bookingInfo'),
			), SOAP_ENC_OBJECT, null, null, 'deleteBookingRequest')
		);
$obj_parent = new SoapVar($ar_children, SOAP_ENC_OBJECT, null, null, 'deleteBooking');

try {
	$result = $client->deleteBooking($obj_parent);
// 	print_r($result);

	$ar = obj2arr($result);

}
catch (Exception $e) {
// 	var_dump($e);
	$error = "接続に失敗しました。";
}

?>