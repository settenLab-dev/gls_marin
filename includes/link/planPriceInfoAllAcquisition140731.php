<?php
require_once(PATH_SLAKER_COMMON.'/includes/class/extends/tlPayment.php');

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
// if ($roomCode != "") {
// 	$roomAr = new SoapVar(array(
// 					new SoapVar($roomCode, XSD_INTEGER, null, null, 'tllRmTypeCode'),
// 					new SoapVar($roomCode, XSD_INTEGER, null, null, 'tllPlanCode'),
// 	), SOAP_ENC_OBJECT, null, null, 'tllPlanInfos');
// }

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
						new SoapVar(array(
								new SoapVar($roomId, XSD_STRING , null, null, 'tllRmTypeCode'),
								new SoapVar($planId, XSD_STRING, null, null, 'tllPlanCode')
						), SOAP_ENC_OBJECT, null, null, 'tllPlanInfos'),
				), SOAP_ENC_OBJECT, null, null, 'hotelInfos')
		), SOAP_ENC_OBJECT, null, null, 'planPriceInfoAcquisitionAllRequest')
);

$obj_parent = new SoapVar($ar_children, SOAP_ENC_OBJECT, null, null, 'planPriceInfoAcquisitionAll');

try {
	$result = $client->planPriceInfoAcquisitionAll($obj_parent);

	$ar = obj2arr($result);

//	print_r($ar);

	// システム日付
	$sdate = $ar["planPriceInfoAllResult"]["commonResponse"]["systemDate"];
	$cdate = date('Y-m-d H:i:s',strtotime($sdate));
//	print $cdate;

	if ($ar["planPriceInfoAllResult"]["commonResponse"]["resultCode"] == "True") {
		//	成功
		if ($flgInsert || $updateFlg) {

			$hotelCode = $ar["planPriceInfoAllResult"]["hotelInfos"]["tllHotelCode"];
//			print $hotelCode;
//			print "<br />------------------------<br />";

//			print count($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]);
//			print count($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllPlanCode"]);
//			print_r($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]);
//			print_r($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]);

		// プランが1つしかない時
		if (count($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllPlanCode"]) == 1) {

			$RoomTypeInfos = $ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"];
			$rPlanCode = $ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllPlanCode"];
//			print_r($RoomTypeInfos);
//			print(count($RoomTypeInfos));
//			print(count($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]["tllRmTypeCode"]));

				// 部屋が1タイプしかない時
				if (count($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]["tllRmTypeCode"]) == 1) {
					$rRoomCode = $ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]["tllRmTypeCode"];
					$priceInfos = $ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]["priceInfos"];
//					$rPlanCode = $data1->tllPlanCode;
//print_r($RoomTypeInfos);
//					print $rRoomCode;
//					print "<br/>";
//					print $rPlanCode;
//					print "<br/>";
// 					print_r($priceInfos);
//					print "<br />------------------------<br />";
					if (count($priceInfos) > 0) {
						foreach ($priceInfos as $d) {
//							print_r($d);

							$tlPayment = new tlPayment($dbMaster);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_HOTEL_ID", $hotelCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PLAN_CODE", $rPlanCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_ROOM_TYPECODE", $rRoomCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE", $d->salesDate);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_NUM_PLAN", $d->planStockCount);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", 1);
//							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", $d->salesStatus);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY1", $d->adultPrice1);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY2", $d->adultPrice2);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY3", $d->adultPrice3);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY4", $d->adultPrice4);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY5", $d->adultPrice5);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY6", $d->adultPrice6);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY7", $d->adultPrice7);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY8", $d->adultPrice8);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY9", $d->adultPrice9);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY10", $d->adultPriceMore10);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_FLG_DELETE", 0);
 							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE_UPDATE", $cdate);
							if (!$tlPayment->save()) {
							}
//							else{ print "完了";}
// 							print_r($tlPayment->getCollection());
//							print "<br />------------------------<br />";
						}
					}

				}
				else{
					// 部屋タイプが複数ある時
					foreach ($RoomTypeInfos as $room){
//					print_r($room);
					$rRoomCode = $room->tllRmTypeCode;
					$priceInfos = $room->priceInfos;
//					$rPlanCode = $data1->tllPlanCode;
//print_r($room);

//					print $rRoomCode;
//					print "<br/>";
// 					print $rPlanCode;
//					print "<br/>";
// 					print_r($priceInfos);
//					print "<br />------------------------<br />";
					if (count($priceInfos) > 0) {
						foreach ($priceInfos as $d) {
//							print_r($d);

							$tlPayment = new tlPayment($dbMaster);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_HOTEL_ID", $hotelCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PLAN_CODE", $rPlanCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_ROOM_TYPECODE", $rRoomCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE", $d->salesDate);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_NUM_PLAN", $d->planStockCount);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", 1);
//							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", $d->salesStatus);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY1", $d->adultPrice1);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY2", $d->adultPrice2);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY3", $d->adultPrice3);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY4", $d->adultPrice4);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY5", $d->adultPrice5);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY6", $d->adultPrice6);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY7", $d->adultPrice7);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY8", $d->adultPrice8);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY9", $d->adultPrice9);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY10", $d->adultPriceMore10);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_FLG_DELETE", 0);
 							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE_UPDATE", $cdate);
							if (!$tlPayment->save()) {
							}
//							else{ print "完了";}
// 							print_r($tlPayment->getCollection());
//							print "<br />------------------------<br />";
						}
					}}

				}

		}
		else {
			// プランが複数ある時
			if (count($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"]) > 0) {
				foreach ($ar["planPriceInfoAllResult"]["hotelInfos"]["tllPlanInfos"] as $data1) {

//					print_r($data1);
					$RoomTypeInfos = $data1->tllRmTypeInfos;
//					print_r($RoomTypeInfos);
//					print_r(count($RoomTypeInfos->tllRmTypeCode));

				// 部屋タイプが1つしかない時
				if (count($RoomTypeInfos->tllRmTypeCode) == 1) {
					$rRoomCode = $RoomTypeInfos->tllRmTypeCode;
					$priceInfos = $RoomTypeInfos->priceInfos;
					$rPlanCode = $data1->tllPlanCode;
//print_r($RoomTypeInfos);
//					print $rRoomCode;
//					print "<br/>";
// 					print $rPlanCode;
//					print "<br/>";
// 					print_r($priceInfos);
//					print "<br />------------------------<br />";
					if (count($priceInfos) > 0) {
						foreach ($priceInfos as $d) {
//							print_r($d);

							$tlPayment = new tlPayment($dbMaster);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_HOTEL_ID", $hotelCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PLAN_CODE", $rPlanCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_ROOM_TYPECODE", $rRoomCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE", $d->salesDate);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_NUM_PLAN", $d->planStockCount);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", 1);
//							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", $d->salesStatus);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY1", $d->adultPrice1);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY2", $d->adultPrice2);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY3", $d->adultPrice3);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY4", $d->adultPrice4);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY5", $d->adultPrice5);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY6", $d->adultPrice6);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY7", $d->adultPrice7);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY8", $d->adultPrice8);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY9", $d->adultPrice9);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY10", $d->adultPriceMore10);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_FLG_DELETE", 0);
 							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE_UPDATE", $cdate);
							if (!$tlPayment->save()) {
							}
//							else{ print "完了";}
// 							print_r($tlPayment->getCollection());
//							print "<br />------------------------<br />";
						}
					}

				}	
				else{
					//部屋タイプが複数ある時
					foreach ($RoomTypeInfos as $room){
					$rRoomCode = $room->tllRmTypeCode;
					$priceInfos = $room->priceInfos;
					$rPlanCode = $data1->tllPlanCode;
//print_r($room);

//					print $rRoomCode;
//					print "<br/>";
// 					print $rPlanCode;
//					print "<br/>";
// 					print_r($priceInfos);
//					print "<br />------------------------<br />";
					if (count($priceInfos) > 0) {
						foreach ($priceInfos as $d) {
//							print_r($d);

							$tlPayment = new tlPayment($dbMaster);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_HOTEL_ID", $hotelCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PLAN_CODE", $rPlanCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_ROOM_TYPECODE", $rRoomCode);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE", $d->salesDate);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_NUM_PLAN", $d->planStockCount);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", 1);
//							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_STATUS", $d->salesStatus);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY1", $d->adultPrice1);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY2", $d->adultPrice2);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY3", $d->adultPrice3);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY4", $d->adultPrice4);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY5", $d->adultPrice5);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY6", $d->adultPrice6);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY7", $d->adultPrice7);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY8", $d->adultPrice8);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY9", $d->adultPrice9);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_PAY10", $d->adultPriceMore10);
							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_FLG_DELETE", 0);
 							$tlPayment->setByKey($tlPayment->getKeyValue(), "TL_PAYMENT_DATE_UPDATE", $cdate);
							if (!$tlPayment->save()) {
							}
//							else{ print "完了";}
// 							print_r($tlPayment->getCollection());
//							print "<br />------------------------<br />";
						}
					}}

				}}

			}
		}


			/*
			if (count($ar["roomAvailabilityAllResult"]["hotelInfos"]["tllRmTypeInfos"]) > 0) {
				$hotelCode = $ar["roomAvailabilityAllResult"]["hotelInfos"]["tllHotelCode"];



				foreach ($ar["roomAvailabilityAllResult"]["hotelInfos"]["tllRmTypeInfos"] as $dd) {

					$rRoomCode = $ar["roomAvailabilityAllResult"]["hotelInfos"]["tllRmTypeInfos"]["tllRmTypeCode"];
					foreach ($dd as $getdata) {

							$tlProvide = new tlProvide($dbMaster);
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_HOTEL_ID", $hotelCode);
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_ROOM_TYPECODE", $rRoomCode);

// 							if (count($getdata) > 0) {
								print_r($getdata);
// 									print $getdataAr."<br />";
// 							}
							print "<br />------------------------<br />";
// 							if (count($getdata) > 0) {
// 								foreach ($getdata as $getdataAr) {
// 									$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_PROVIDE_DATE", $getdataAr["salesDate"]);
// 									$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_PROVIDE_NUM", $getdataAr["stockCount"]);
// 								}
// 							}
							$tlProvide->setByKey($tlProvide->getKeyValue(), "TL_PROVIDE_FLG_DELETE", $getdata[""]);

// 							print $getdata["salesDate"]."<br />";
// 							print_r($tlProvide->getCollection());
// 							print_r($getdata);

					}
				}
			}
			*/
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