<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlProvide.php');

$dbMaster = new dbMaster();
$collection = new collection($dbMaster);

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
					new SoapVar($roomId, XSD_INTEGER, null, null, 'tllRmTypeCode'),
	), SOAP_ENC_OBJECT, null, null, 'tllRmTypeInfos');
}

$ar_children =
array(
		new SoapVar(array(
				new SoapVar(array(
						new SoapVar(SITE_TL_ID, XSD_STRING , null, null, 'agtId'),
						new SoapVar(SITE_TL_PASS, XSD_STRING , null, null, 'agtPassword'),
						new SoapVar(date("c"), XSD_DATETIME, null, null, 'systemDate')
				), SOAP_ENC_OBJECT, null, null, 'commonRequest'),
				new SoapVar(array(
						new SoapVar($startDay, XSD_DATE, null, null, 'startDay'),
						new SoapVar($endDay, XSD_DATE, null, null, 'endDay')
				), SOAP_ENC_OBJECT, null, null, 'extractionRequest'),
				new SoapVar(array(
						new SoapVar($hotelId, XSD_STRING, null, null, 'tllHotelCode'),
						$roomAr
				), SOAP_ENC_OBJECT, null, null, 'hotelInfos')
		), SOAP_ENC_OBJECT, null, null, 'roomAvailabilityAllRequest')
);


$obj_parent = new SoapVar($ar_children, SOAP_ENC_OBJECT, null, null, 'roomAvailabilityAll');

try {
	$result = $client->roomAvailabilityAll($obj_parent);

	$ar = obj2arr($result);

// 	print_r($ar);

	if ($ar["roomAvailabilityAllResult"]["commonResponse"]["resultCode"] == "True") {
		//	成功
		if ($flgInsert) {

			$hotelCode = $ar["roomAvailabilityAllResult"]["hotelInfos"]["tllHotelCode"];
// 			print $hotelCode;
// 			print "<br />------------------------<br />";

// 			print count($ar["roomAvailabilityAllResult"]["hotelInfos"]["tllRmTypeInfos"]);
// 			print_r($ar["roomAvailabilityAllResult"]["hotelInfos"]["tllRmTypeInfos"]);

			if (count($ar["roomAvailabilityAllResult"]["hotelInfos"]["tllRmTypeInfos"]) > 0) {
				foreach ($ar["roomAvailabilityAllResult"]["hotelInfos"]["tllRmTypeInfos"] as $data1) {

					$rRoomCode = $data1->tllRmTypeCode;
					$vacancyInfos = $data1->vacancyInfos;
// 					print $rRoomCode;
// 					print_r($vacancyInfos);
// 					print "<br />------------------------<br />";
					if (count($vacancyInfos) > 0) {
						foreach ($vacancyInfos as $d) {
// 							print_r($d);

							$tlProvide = new tlProvide($dbMaster);
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_HOTEL_ID", $hotelCode);
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_ROOM_TYPECODE", $rRoomCode);
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_PROVIDE_DATE", $d->salesDate);
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_PROVIDE_NUM", $d->stockCount);
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_PROVIDE_FLG_DELETE", "0");

							if (!$tlProvide->save()) {
							}

// 							print_r($tlProvide->getCollection());
// 							print "<br />------------------------<br />";
						}
					}
				}

			}

		}
		else {

			print_r($ar);

		}

	}
	else {
		//	失敗
		print_r($ar);
		print "接続失敗";
	}
}
catch (Exception $e) {
	var_dump($e);
}

?>