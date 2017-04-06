<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPayment.php');

error_reporting(1);

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotel = new hotel($dbMaster);
$hotel->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collection = new collection($db);
$collection->setByKey($collection->getKeyValue(), "TL_HOTEL_ID", $company->getByKey($company->getKeyValue(), "COMPANY_LINK"));
$collection->setByKey($collection->getKeyValue(), "TL_HOTEL_ID", $_GET["id"]);
$collection->setByKey($collection->getKeyValue(), "TL_PLAN_CODE", $_GET["pid"]);
$collection->setByKey($collection->getKeyValue(), "TL_ROOM_TYPECODE", $_GET["rid"]);

$hotelPlan = new tlPlan($dbMaster);
$hotelPlan->selectList($collection);

$hotelPayment = new tlPayment($dbMaster);
$hotelPayment->selectList($collection);


$hotelPayTarget = new tlPayment($dbMaster);

//	登録済みデータ設定
if ($hotelPayment->getCount() > 0) {
	foreach ($hotelPayment->getCollection() as $hp) {
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_HOTEL_ID", $company->getByKey($company->getKeyValue(), "COMPANY_LINK"));
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "HOTELPLAN_ID", $_GET["pid"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "ROOM_ID", $_GET["rid"]);

		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_DATE", $hp["TL_PAYMENT_DATE"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_STATUS", $hp["TL_PAYMENT_STATUS"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY1", $hp["TL_PAYMENT_PAY1"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY2", $hp["TL_PAYMENT_PAY2"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY3", $hp["TL_PAYMENT_PAY3"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY4", $hp["TL_PAYMENT_PAY4"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY5", $hp["TL_PAYMENT_PAY5"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY6", $hp["TL_PAYMENT_PAY6"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY7", $hp["TL_PAYMENT_PAY7"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY8", $hp["TL_PAYMENT_PAY8"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY9", $hp["TL_PAYMENT_PAY9"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_PAY10", $hp["TL_PAYMENT_PAY10"]);
		$hotelPayTarget->setByKey($hp["TL_PAYMENT_DATE"], "TL_PAYMENT_FLG_DELETE", $hp["TL_PAYMENT_FLG_DELETE"]);
	}
}


?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>プラン｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
</head>
<body id="">
	<div id="containerPop">
		<h2>リンカーン料金(３ヶ月内)</h2>
		<div id="contentsPop" class="circle">
			<table cellspacing="10" cellpadding="0" border="0" class="calendar">
			    
				<?php

				$from = cmDateDivide($hotelPlan->getByKey($hotelPlan->getKeyValue(), "TL_PLAN_DATE_SALES_FROM"));
				$to = cmDateDivide($hotelPlan->getByKey($hotelPlan->getKeyValue(), "TL_PLAN_DATE_SALES_TO"));
				
				if($from["y"] == "" && $to["y"] == ""){
					$from = cmDateDivide(date("Y-m-d"));
					$to = cmDateDivide(date("Y-m-d",strtotime("+3 month")));
				}
				
				$cut = intval($to['y'])-intval($from['y']);
				for ($y=$from["y"]; $y<=$to["y"]; $y++) {
					if($from['m']>$to['m']){
						$ori_to_m = $to['m'];
						$ori_to_d = $to['d'];
						$to['m'] = 12;
						$to['d'] = 31;
						for ($m=$from["m"]; $m<=$to["m"]; $m++) {

							if ($from["y"] == $y and $from["m"] == $m) {
								if ($from["y"] == $to["y"] and $from["m"] == $to["m"]) {
									//	最初の月でそのまま終了の場合
									print cmCalendarLink($y, $m, $from["d"], $to["d"], $hotelPayTarget, "", $only);
								}
								else {
									print cmCalendarLink($y, $m, $from["d"], "", $hotelPayTarget, "", $only);
								}
							}
							elseif ($to["y"] == $y and $to["m"] == $m) {
								print cmCalendarLink($y, $m, "", $to["d"], $hotelPayTarget, "", $only);
							}
							else {
								print cmCalendarLink($y, $m, "", "", $hotelPayTarget, "", $only);
							}
								
						}
						$from['m']=1;
						$from['d']=1;
						$cut?$cut--:'';
						if ($cut==0) {
							$to['m']=$ori_to_m;
							$to['d']=$ori_to_d;
						}
						//output_cal($y,$from, $to);
					}else{
						if($cut>0){
							$ori_to_m = $ori_to_m?$ori_to_m:$to['m'];
							$ori_to_d = $ori_to_m?$ori_to_m:$to['d'];
							$to['m'] = 12;
							$to['d'] = 31;
						}
						for ($m=$from["m"]; $m<=$to["m"]; $m++) {

							if ($from["y"] == $y and $from["m"] == $m) {
								if ($from["y"] == $to["y"] and $from["m"] == $to["m"]) {
									//	最初の月でそのまま終了の場合
									print cmCalendarLink($y, $m, $from["d"], $to["d"], $hotelPayTarget, "", $only);
								}
								else {
									print cmCalendarLink($y, $m, $from["d"], "", $hotelPayTarget, "", $only);
								}
							}
							elseif ($to["y"] == $y and $to["m"] == $m) {
								print cmCalendarLink($y, $m, "", $to["d"], $hotelPayTarget, "", $only);
							}
							else {
								print cmCalendarLink($y, $m, "", "", $hotelPayTarget, "", $only);
							}
								
						}
						if($cut>0){
							$from['m']=1;
							$from['d']=1;
							$cut?$cut--:'';
							if ($cut==0) {
								$to['m']=$ori_to_m;
								$to['d']=$ori_to_d;
							}
						}
						
					} 

				}
				?>
			</td>
		</tr>
	</table>
		</div>
		<br />
	</div>
</body>
</html>