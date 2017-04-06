<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlRoom.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
//会員しか見えない
if (!$sess->sessionCheck()) {
	$_SESSION['ref_url']=$_SERVER['REQUEST_URI'];
	cmLocationChange("login.html");
}


$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);

// print_r($collection->getCollection());

$hotelTarget = new hotel($dbMaster);
$hotelTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));


// decode the url
function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}

function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

$key = $_GET["cid"].$_GET["id"].$_GET["rid"];
if( $key != passport_decrypt($_GET["key"], $key) ){
	echo "<head><meta charset='utf-8'></head><body>無効リンクです。<br/>管理員と連絡して下さい。</body>";
	exit;
}


if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
	//	ココモ
	$hotelPlanTarget = new hotelPlan($dbMaster);
		
	if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") == "") {
		if ($_GET['id']) {
			$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $_GET['id']);;
		}
	}
	if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") == "") {
		if ($_GET['rid']) {
			$collection->setByKey($collection->getKeyValue(), "ROOM_ID", $_GET['rid']);;
		}
	}
	if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") == "") {
		if ($_GET['cid']) {
			$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET['cid']);;
		}
	}
	
	
	$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

	$hotelRoom = new hotelRoom($dbMaster);
	$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	$hotelTarget = new hotel($dbMaster);
	$hotelTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	$hotelBookset = new hotelBookset($dbMaster);
	$hotelBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
}
else {
	//	リンカーン
	$date = "";
	if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
		$date = str_replace("年", "", $collection->getByKey($collection->getKeyValue(), "search_date"));
		$date = str_replace("月", "", $date);
		$date = str_replace("日", "", $date);
	}
	$startDay = $date;
	$endDay = date("Ymd",strtotime("30 day" ,strtotime($startDay)));
	$hotelCode = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
	$roomCode = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
	$planCode = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");

	$hotelPlanTarget = new tlPlan($dbMaster);
	$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $planCode, $roomCode);

	$hotelRoom = new tlRoom($dbMaster);
	$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $roomCode);

// 	print_r($hotelRoom->getCollection());

	//	大人数
	$checkNum = intval($collection->getByKey($collection->getKeyValue(), "adult_number1"));
	//	小学生(低学年)
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."1"));
	//	小学生(高学年)
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."2"));
	//	幼児:食事・布団あり
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."3"));
	//	幼児:布団あり
	$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number1"."5"));

	if ($checkNum > 10 ) {
		$checkNum = 10;
	}
// 	$num = 1;
	$num = $checkNum;
	$flgImport = false;

// 	//	部屋数取得
// 	require_once('includes/link/roomAvailability.php');
// 	$dataarRoom = $ar;


	//	料金取得
	require_once('includes/link/planPriceInfoAcquisition.php');
	$dataarPay = $ar;

// 	print_r($dataarPay);
}





$hotel = new hotel($dbMaster);
// $collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", "");
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", "");
$hotel->selectListPublicHotel($collection);

$planCnt = 0;
$dspArray = array();

$money_1 = "";
$money_all = "";

if ($hotel->getCount() > 0) {
	foreach ($hotel->getCollection() as $data) {
		$dspArray[$data["ROOM_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["ROOM_ID"]]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$data["ROOM_ID"]]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$data["ROOM_ID"]]["money_1"] = $data["money_1"];
		$dspArray[$data["ROOM_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["ROOM_ID"]]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$data["ROOM_ID"]]["ROOM_NAME"] = $data["ROOM_NAME"];
		$dspArray[$data["ROOM_ID"]]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$data["ROOM_ID"]]["ROOM_TYPE"] = $data["ROOM_TYPE"];
		$dspArray[$data["ROOM_ID"]]["ROOM_CAPACITY_TO"] = $data["ROOM_CAPACITY_TO"];
		$dspArray[$data["ROOM_ID"]]["ROOM_BREADTH"] = $data["ROOM_BREADTH"];
		$dspArray[$data["ROOM_ID"]]["ROOM_FEATURE_LIST3"] = $data["ROOM_FEATURE_LIST3"];
	}
}

// print_r($dspArray);
// print_r($hotelPlanTarget->getCollection());
// print_r($hotel->getCollection());



if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
	//	ココモ
	$arPayList = array();

	//	料金カレンダー
	$hotelPay = new hotelPay($dbMaster);
	$hotelPayTarget = new hotelPay($dbMaster);
	//	料金設定検索
	$hotelPay->selectListPublic($collection);
	// print_r($hotelPay->getCollection());

	//	登録済みデータ設定
	if ($hotelPay->getCount() > 0) {
		foreach ($hotelPay->getCollection() as $hp) {
			//	POSTデータ
			$arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["ROOM_ID"] = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["night_number"] = $collection->getByKey($collection->getKeyValue(), "night_number");
			$arPayList[$hp["HOTELPAY_DATE"]]["room_number"] = $collection->getByKey($collection->getKeyValue(), "room_number");

			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["adult_number".$roomNum] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
				for ($i=1; $i<=6; $i++) {
					$arPayList[$hp["HOTELPAY_DATE"]]["child_number".$roomNum.$i] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);
				}
			}


			$arPayList[$hp["HOTELPAY_DATE"]]["date"] = $hp["HOTELPAY_DATE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ID"] = $hp["HOTELPAY_ID"];
			for ($i=1; $i<=6; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY".$i] = $hp["HOTELPAY_MONEY".$i];
			}
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ROOM_NUM"] = $hp["HOTELPAY_ROOM_NUM"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ROOM_OVER"] = $hp["HOTELPAY_ROOM_OVER"];

			for ($i=1; $i<=4; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_PS_DATA".$i] = $hp["HOTELPAY_PS_DATA".$i];
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_PS_DATA".$i."2"] = $hp["HOTELPAY_PS_DATA".$i."2"];
			}
			for ($i=1; $i<=14; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_BB_DATA".$i] = $hp["HOTELPAY_BB_DATA".$i];
			}
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY_FLG"] = $hp["HOTELPAY_MONEY_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE"] = $hp["HOTELPAY_SERVICE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_REMARKS"] = $hp["HOTELPAY_REMARKS"];

			$arPayList[$hp["HOTELPAY_DATE"]]["money_all"] = $hp["money_all"];
			$arPayList[$hp["HOTELPAY_DATE"]]["money_1"] = $hp["money_1"];
		}
	}

// 	print_r($arPayList);


	$hotelProvide = new hotelProvide($dbMaster);
	$hotelProvide->selectListPublic($collection);
	if ($hotelProvide->getCount() > 0) {
		foreach ($hotelProvide->getCollection() as $hp) {
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["date"] = $hp["HOTELPROVIDE_DATE"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_ID"] = $hp["HOTELPROVIDE_ID"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_STOP"] = $hp["HOTELPROVIDE_FLG_STOP"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_REQUEST"] = $hp["HOTELPROVIDE_FLG_REQUEST"];
			$arPayList[$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_NUM"] = $hp["HOTELPROVIDE_NUM"];
// 			print $hp["HOTELPROVIDE_DATE"]."/".$hp["HOTELPROVIDE_NUM"]."<br />";
		}
	}

// 	print_r($arPayList);
// 	print_r($hotelProvide->getCollection());



}
else {

	//	部屋数取得
// 	$dataarRoom = $ar;
	//	料金取得
// 	$dataarPay = $ar;

	$hotelPay = new tlPlan($dbMaster);
	$hotelPay->select($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"), $planCode, $roomCode);
// 	print_r($hotelPay->getCollection());

// 	print_r($dataarPay);
	if ($dataarPay["planPriceInfoResult"]["commonResponse"]["resultCode"] == "True") {
		$retar = $dataarPay["planPriceInfoResult"]["hotelInfos"]["tllPlanInfos"]["tllRmTypeInfos"]["priceInfos"];
		if (count($retar) > 0) {
			foreach ($retar as $dd) {

				$d = date("Y-m-d",strtotime($dd->salesDate));

				$arPayList[$d]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
				$arPayList[$d]["COMPANY_LINK"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");
				$arPayList[$d]["HOTELPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
				$arPayList[$d]["ROOM_ID"] = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
				$arPayList[$d]["night_number"] = $collection->getByKey($collection->getKeyValue(), "night_number");
				$arPayList[$d]["room_number"] = $collection->getByKey($collection->getKeyValue(), "room_number");

				for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
					$arPayList[$d]["adult_number".$roomNum] = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
					for ($i=1; $i<=6; $i++) {
						$arPayList[$d]["child_number".$roomNum.$i] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);
					}
				}

				$arPayList[$d]["date"] = $d;
				$arPayList[$d]["HOTELPAY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK");

				$arPayList[$d]["HOTELPAY_MONEY1"] = $dd->adultPrice1;
				$arPayList[$d]["HOTELPAY_MONEY2"] = $dd->adultPrice2;
				$arPayList[$d]["HOTELPAY_MONEY3"] = $dd->adultPrice3;
				$arPayList[$d]["HOTELPAY_MONEY4"] = $dd->adultPrice4;
				$arPayList[$d]["HOTELPAY_MONEY5"] = $dd->adultPrice5;
				$arPayList[$d]["HOTELPAY_MONEY6"] = $dd->adultPrice6;
				$arPayList[$d]["HOTELPAY_MONEY7"] = $dd->adultPrice7;
				$arPayList[$d]["HOTELPAY_MONEY8"] = $dd->adultPrice8;
				$arPayList[$d]["HOTELPAY_MONEY9"] = $dd->adultPrice9;
				$arPayList[$d]["HOTELPAY_MONEY10"] = $dd->adultPrice10;

				//	ポイント
				$arPayList[$d]["HOTELPAY_ROOM_NUM"] = 1;
// 				$arPayList[$d]["HOTELPAY_ROOM_OVER"] = $hp["HOTELPAY_ROOM_OVER"];

				$arPayList[$d]["childAPrice"] = $dd->childAPrice;
				$arPayList[$d]["childA2Price"] = $dd->childA2Price;
				$arPayList[$d]["childBPrice"] = $dd->childBPrice;
				$arPayList[$d]["childB2Price"] = $dd->childB2Price;
				$arPayList[$d]["childCPrice"] = $dd->childCPrice;
				$arPayList[$d]["childDPrice"] = $dd->childDPrice;

				$arPayList[$d]["HOTELPROVIDE_NUM"] = $dd->stockCount;
				$arPayList[$d]["planStockCount"] = $dd->planStockCount;

				if ($dd->salesStatus == 0) {
					//	販売
					$arPayList[$d]["HOTELPROVIDE_FLG_STOP"] = 1;
				}
				else {
					//	販売停止
					$arPayList[$d]["HOTELPROVIDE_FLG_STOP"] = 2;
				}


				/*
				for ($i=1; $i<=4; $i++) {
					$arPayList[$d]["HOTELPAY_PS_DATA".$i] = $hp["HOTELPAY_PS_DATA".$i];
					$arPayList[$d]["HOTELPAY_PS_DATA".$i."2"] = $hp["HOTELPAY_PS_DATA".$i."2"];
				}
				for ($i=1; $i<=14; $i++) {
					$arPayList[$d]["HOTELPAY_BB_DATA".$i] = $hp["HOTELPAY_BB_DATA".$i];
				}

				$arPayList[$d]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
				$arPayList[$d]["HOTELPAY_MONEY_FLG"] = $hp["HOTELPAY_MONEY_FLG"];
				$arPayList[$d]["HOTELPAY_SERVICE"] = $hp["HOTELPAY_SERVICE"];
				$arPayList[$d]["HOTELPAY_REMARKS"] = $hp["HOTELPAY_REMARKS"];
				*/


				for ($i=1; $i<=10; $i++) {
					if ($arPayList[$d]["HOTELPAY_MONEY".$i] != "") {
						$arPayList[$d]["money_1"]  = $arPayList[$d]["HOTELPAY_MONEY".$i];
						break;
					}
				}

				$rink_money_all = 0;
				if ($collection->getByKey($collection->getKeyValue(), "adult_number1") > 0) {
					$rink_money_all =  $arPayList[$d]["money_1"] * $collection->getByKey($collection->getKeyValue(), "adult_number1");
				}

				if ($collection->getByKey($collection->getKeyValue(), "child_number12") > 0) {
					$rink_money_all +=  intval($dd->childAPrice) * $collection->getByKey($collection->getKeyValue(), "child_number12");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number11") > 0) {
					$rink_money_all +=  intval($dd->childA2Price) * $collection->getByKey($collection->getKeyValue(), "child_number11");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number13") > 0) {
					$rink_money_all +=  intval($dd->childBPrice) * $collection->getByKey($collection->getKeyValue(), "child_number13");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number14") > 0) {
					$rink_money_all +=  intval($dd->childB2Price) * $collection->getByKey($collection->getKeyValue(), "child_number14");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number15") > 0) {
					$rink_money_all +=  intval($dd->childCPrice) * $collection->getByKey($collection->getKeyValue(), "child_number15");
				}
				if ($collection->getByKey($collection->getKeyValue(), "child_number16") > 0) {
					$rink_money_all +=  intval($dd->childDPrice) * $collection->getByKey($collection->getKeyValue(), "child_number16");
				}

				$arPayList[$d]["money_all"] = $rink_money_all;

			}
		}

	}


}

// print_r($arPayList);


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotelTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("includes/box/common/meta201505.php"); ?>
<title>プラン詳細 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="プラン,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="ホテルのプラン詳細のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- ?窗 -->
<link rel="stylesheet" href="<?php print URL_SLAKER_COMMON?>css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/popupwindow-1.6.js"></script>
<style>
.dspNon {
	display: none;
}
</style>
<script>
//?窗
var pop;
function openChildSet() {
	<?php for ($i=1; $i<=6; $i++) {?>
	var num<?php print $i?> = $("#child_number<?php print $i?>").val();
	<?php }?>
	var rheight = 110 + (170*parseInt($("#room_number").val()));
	if (rheight > 620) {
		rheight = 620;
	}
	pop= new $pop('popchildset_plandetail.php?num1='+num1+'&num2='+num2+'&num3='+num3+'&num4='+num4+'&num5='+num5+'&num6='+num6, { type:'iframe', title:'人数設定',effect:'normal',width:650,height:rheight,windowmode:false,resize: false } );
}
function setData() {
	pop.close();
	$("#ori_adult").css("display","none");
}


$('a[href=#top]').click(function() {
    ('a:not(.calendarLink[href*=#]')
   var speed = 500;
   var href= $(this).attr("href");
   var target = $(href == "#" || href == "" ? 'html' : href);
   var position = target.offset().top;
   $('body,html').animate({scrollTop:position}, 500, 'swing');
   return false;
});
</script>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail_n" class="searchdetail">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">検索結果</a></li>
            <li><span>プラン詳細</span></li>
        </ul>
        
        <article class="titlecase2">
       		<div>
       			<h2><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?></h2>
       			<ul class="icon-type">
       				<?php /*<li class="type01">施設タイプ</lI> */ ?>
       				<?php
					$arArea = array();
					$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_LIST_AREA"));
					if (count($arTemp) > 0) {
						foreach ($arTemp as $data) {
							if ($data != "") {
								$arArea[$data] = $data;
							}
						}
					}

					$areaCnt = 0;
					if (count($arArea) > 0) {
						foreach ($arArea as $d) {
							$areaCnt++;
					?>
					<li class="area01"><?php print $xmlArea->getNameByValue($d)?></li>
					<?php
							if ($areaCnt >= 2) break;
						}
					}
					?>
    	   		</ul>

	       		<ul class="subtab-bt">
       				<li><?php $formname = "basic_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail.html?basic=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu01_n.png" width="113" height="30" alt="基本情報" ></a>
       					<?php print $inputs->hidden("current_page", "1")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					<!-- 
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					 -->
       					 <input type="hidden" name="search_date" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<input type="hidden" name="child_number<?= $roomNum.$i?>" value="<?php echo $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);?>">
       					<?php //print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?> 
       					<?php
       						}
       					}
       					?>
       				</form></li>
       				<li><?php $formname = "info_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail.html?info=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu02_n.png" width="113" height="30" alt="宿泊プラン一覧" ></a>
       					<?php print $inputs->hidden("current_page", "2")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					<!-- 
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					 -->
				<?php if ($collection->getByKey($collection->getKeyValue(), "undeide_sch") != 1){ ?>
       					 <input type="hidden" name="search_date" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
					<?php }	else{?>
       					 <input type="hidden" name="search_date" value="<?php echo date("Y-m-d",strtotime("+1 day"));?>">
					<?php }?>
       					<!--<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>-->
       					<!--<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>-->
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<input type="hidden" name="child_number<?= $roomNum.$i?>" value="<?php echo $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);?>">
       					<?php //print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?> 
       					<?php
       						}
       					}
       					?>
       				</form></li>
       				<li><?php $formname = "map_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail.html?map=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu03_n.png" width="113" height="30" alt="地図・アクセス" ></a>
       					<?php print $inputs->hidden("current_page", "6")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					<!-- 
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					 -->
       					 <input type="hidden" name="search_date" type="hidden" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<input type="hidden" name="child_number<?= $roomNum.$i?>" value="<?php echo $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);?>">
       					<?php //print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?> 
       					<?php
       						}
       					}
       					?>
       				</form></li>
    	   			<!--<li><a href="#"><img src="./images/common/tab-submenu04.png" width="78" height="23" alt="お気に入りに追加" ></a></li>-->
	       		</ul>
       		</div>
       	</article>

        <article class="mainbox" id="ag">
			<div class="inner">
			<h2 class="bl-bg"><span class="new-b"></span><B><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?></B></h2>
			<div class="cont">
				<div class="clearfix">
					<ul class="icon">
						<!--<li><img src="./images/common/icon-nomeal.jpg"</li>-->
						<?php
						$meal = "";
						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_BF_FLG") == 2) {
							$meal = "朝";
						}
						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DN_FLG") == 2) {
							$meal .= "夕";
						}
						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {
							$meal .= "昼";
						}
						if ($meal != "") {
							$meal .= "食あり";
						}
						else {
							$meal .= "食事なし";
						}
						?>
						<li class="radius5"><?php print $meal?></li><?php /*&nbsp;&nbsp;&nbsp;<li><img src="./images/common/icon-Limit.jpg"</li> */?>
					</ul>
					<div class="checkin">
					<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
					チェックイン：<?php print date("H:i", strtotime($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CHECKIN")))?>～<?php print date("H:i", strtotime($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CHECKIN_LAST")))?> / チェックアウト～<?php print date("H:i", strtotime($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CHECKOUT")))?>
					<?php }else{?>
					チェックイン：<?php print substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_DATE_CHECKIN_FROM"),0,2).":".substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_DATE_CHECKIN_FROM"),2,2)."～".substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_DATE_CHECKIN_TO"),0,2).":".substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_DATE_CHECKIN_TO"),2,2);
					?> / チェックアウト～<?php 
					if(strlen($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_TIME_CHECKOUT")) == 3){
						print substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_TIME_CHECKOUT"),0,1).":".substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_TIME_CHECKOUT"),1,2);
					}
					else {
						print substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_TIME_CHECKOUT"),0,2).":".substr($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_TIME_CHECKOUT"),2,2);
					}?>
					<?php }?>
					</div>
				    <a href="#calendermain" class="vacancy_c">料金・空室を見る</a>
				</div>
				<div class="tb-sp20 sealetime">
					<?php $fromDate = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"))?>
					<?php $toDate = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"))?>
					<B>【販売期間】<span><?php 
					if($fromDate["y"] == "0000"){
						print "～";
					}
					else {
						print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"."～".$toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日";
					}
					?></span></B><br>
					<!--<span>このプランは○泊~○泊</span>-->
				</div>
				<div class="image">
				    <!--<div class="off">
				        <b>最大00％OF！</b><span>通常料金￥00,000～</span>
				        <strong>→￥00,000～</strong>
				    </div>-->
				    <div id="mainimage">
				    	 <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC") != "" || $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC1") != "") {?>
							<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
							<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC")?>" width="359" height="265" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?>">
							<?php }else{?>
				    		<img src="<?php print URL_PUBLIC_LINK.$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC1")?>" width="355" height="265" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?>">
							<?php }?>
				    	<?php }else{?>
				    		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="358" height="265" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?>">
				    	<?php }?>
				    </div>
				    <ul id="subimage">
			    		<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
			    			<?php for ($i=""; $i<=4; $i++) {?>
			    			 	<?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i) != "") {?>
			    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i)?>" width="84" height="75" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?>"></a>
			    				<?php }?>
			    			<?php }?>
			    		<?php }else{?>
			    	    	<?php for ($i=1; $i<=3; $i++) {?>
			    	    	 	<?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i) != "") {?>
			    	    		<li><a href="<?php print URL_PUBLIC_LINK.$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i)?>"><img src="<?php print URL_PUBLIC_LINK.$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_PIC".$i)?>" width="84" height="75" alt="<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_PIC_CAP".$i)?>"></a>
			    	    		<?php }?>
			    	    	<?php }?>
			    		<?php }?>
				    </ul>
				</div>
				<section class="section1 cf">
				    <p style="word-break:break-all;"><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FEATURE"))?></p>
				</section>

				<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
				<section class="section3">
				    <h3>○特 典</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CONTENTS"))?></p>
				</section>
				<?php }?>
				
				 <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_BF_FLG") == 2
			    		or $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DN_FLG") == 2
			    		or $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {?>
			    <section class="section3">
			        <h3>○お食事</h3>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_BF_FLG") == 2) {?>
			        <p><span class="icon radius5">朝食</span></p>
			        <?php }?>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD1") != "") {?>
			        <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD1"))?></p>
			        <?php }?>
			
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DN_FLG") == 2) {?>
			        <p><span class="icon radius5">夕食</span></p>
			        <?php }?>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD2") != "") {?>
			        <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD2"))?></p>
			        <?php }?>
			
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_LN_FLG") == 2) {?>
			        <p><span class="icon radius5">昼食</span></p>
			        <?php }?>
			        <?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD3") != "") {?>
			        <p><?php print redirectForReturn($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FOOD3"))?></p>
			        <?php }?>
			    </section>
			    <?php }?>

                   
                <section class="section5">
                    <h3>○お部屋情報</h3>
                    <section>
                        <h4><span class="type">お部屋タイプ</span><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></h4>
                        <div class="image">
                        	<?php if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC1") != "" || $hotelRoom->getByKey($hotelRoom->getKeyValue(), "TL_ROOM_PIC") != "") {?>
								<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
                        		<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC1")?>" width="156" height="116" alt="<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?>">
								<?php }else{?>
                        		<img src="<?php print URL_PUBLIC_LINK.$hotelRoom->getByKey($hotelRoom->getKeyValue(), "TL_ROOM_PIC")?>" width="156" height="116" alt="<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?>">
								<?php }?>
                            <?php }else{?>
                        	<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="156" height="116" alt="<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?>">
                            <?php }?>
                            <?php /*
                            <ul>
                                <li>・<a href="#">360度ビューで見る</a></li>
                                <li>・<a href="#">フォトギャラリーへ</a></li>
                            </ul>
                            */?>
                        </div>
                        <div class="text2">
                            <ul>
								<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
                                <li>広さ：<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_BREADTH")?>㎡／定員：<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_FROM")?>～<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_TO")?>人</li>
								<?php }else{?>
								<li>定員：<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_FROM")?>～<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_TO")?>人</li>
								<?php }?>

                                <?php /*
                                <li class="radius5">禁煙ルーム</li>
                                <li class="radius5">ネット接続OK</li>
                                <li class="radius5">バス・トイレ別</li>
                                */?>
                            </ul>
                            <p style="word-break:break-all; "><?php print redirectForReturn($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_DISCRITION"))?></p>
                        </div>
                    </section>
                </section>


<!--カレンダー-->
                    <section class="calendar" id="#calendarLink">
                    <div class="calendermain"><a name="calendermain"></a>
                    	<h3>▼料金・空室カレンダー</h3>
                    	<section id="searchchange">
                    	<font style="font-size: 14px;color: #696969;">▼現在の検索条件</font><font style="font-size: 13px;color: #ff0000;">　※条件の変更後は必ず「変更」ボタンを押してください。</font>
	    					<form class="form"  method="post" action="plan-detail.html#calendarmain" name="changeDay" id="changeDay">
								<input type="hidden" name="ROOM_ID" value="<?=$collection->getByKey($collection->getKeyValue(), "ROOM_ID")?>" />
								<input type="hidden" name="COMPANY_LINK" value="<?=$collection->getByKey($collection->getKeyValue(), "COMPANY_LINK")?>" />
								<input type="hidden" name="COMPANY_ID" value="<?=$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>" />
								<input type="hidden" name="HOTELPLAN_ID" value="<?=$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")?>" />
	    						<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
	    						<table name="searchchange">
									
	    							<tr>
	    							<?php if($_POST["calendarLink"]<>1 && $_POST['undecide_sch']<>1):?>
	    								<td class="w111">
	    									宿泊日<?php print $inputs->text("search_date", $collection->getByKey($collection->getKeyValue(), "search_date") ,"imeDisabled wDateJp")?>
	    									<script type="text/javascript">
	    									$.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
	    			                         $("#search_date").datepicker(
	    			                         		{
	    			                         			showOn: 'button',
	    			                         			buttonImage: 'images/index/index-search-icon.png',
	    			                         			buttonImageOnly: true,
	    			                         			dateFormat: 'yy年mm月dd日',
	    			                         			changeMonth: true,
	    			                         			changeYear: true,
	    			                         			yearRange: '<?php print date("Y")?>:<?php print date("Y",strtotime("+1 year"))?>',
	    			                         			showMonthAfterYear: true,
	    			                         			monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	    			                                     dayNamesMin: ['日','月','火','水','木','金','土']
	    			                         		});
	    									</script>
	    								</td>
	    								<?php endif;?>
	    								
	    								<td>
	    									<div class="selectbox lbox">
	    										<div class="select-inner select2"><span></span></div>
	    										<select class="select2" name="night_number" id="night_number">
	    	                        		<?php
	    	                        		for ($i=1; $i<=SITE_STAY_NUM; $i++) {
	    	                        			$selected = '';
	    	                        			if ($collection->getByKey($collection->getKeyValue(), "night_number") == $i) {
	    	                        				$selected = 'selected="selected"';
	    	                        			}
	    	                        		?>
	    	                        		<option value="<?php print $i?>" <?=$selected;?>><?=$i?></option>
	    	                        		<?php }?>
	    	                        		</select>
	    									</div><span>泊</span>
	    								</td>
<!--
	    								<td>
	    									<div class="selectbox lbox">
	    										<div class="select-inner select2"><span></span></div>
	    										<select class="select2" name="room_number" id="room_numbers">
	    	                        		<?php
	    	                        		
	    	                        		for ($i=1; $i<=SITE_ROOM_NUM; $i++) {
	    	                        			$selected = '';
	    	                        			if ($collection->getByKey($collection->getKeyValue(), "room_number") == $i) {
	    	                        				$selected = 'selected="selected"';
	    	                        			}
	    	                        		?>
	    	                        		<option value="<?=$i?>" <?=$selected;?>><?=$i?></option>
	    	                        		<?php }?>
	    	                        		</select>
	    									</div><span>部屋</span>
	    								</td>
-->
						<input type="hidden" name="room_number" id="room_numbers" value="1">
	    								<td>
	    									大人
	    									<?php
	    	                            	$num = 0;
	    	                            	for ($roomNum=1; $roomNum<=SITE_ROOM_NUM; $roomNum++) {
	    										$num += intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
	    	                            		if ($roomNum == 1) {
	    								?>
	    									<div class="selectbox" id="ori_adult">
	    										<div class="select-inner select2 adultseldiv"><span></span></div>
	    										<select name="adult_number<?php print $roomNum?>" id="adult_number<?php print $roomNum?>" class="select2 adultnumset adult_sgl">
	    	                        		<?php
	    	                        		for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
	    										$selected = '';
	    										if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
	    											$selected = 'selected="selected"';
	    										}
	    									?>
	    	                                <option value="<?php print $i?>" <?php print $selected;?>><?php print $i?><?php print ($i==SITE_ADULT_NUM)?"～":""?></option>
	    	                        		<?php }?>
	    	                            	</select>
	    									</div>
	    	
	    	                            <?php }else {?>
	    	                        		<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
	    	                        	<?php }?>
	    	
	    	                        	<?php }?>
	    	
	    	                            <div class="selectbox adultnumset adult_dbl">
	    									<a href="javascript:void(0)" onclick="openChildSet()" id="adult_text"><?php print $num?></a>
	    	                            </div>
	    	
	    	                        	<script type="text/javascript">
	    	                            $(document).ready(function(){
	    	                            	$("#room_numbers").change(function () {
	    	                            		roomChange();
	    	                            		if ($("#room_numbers").val() > 1) {
	    	                            			if (pop === undefined) {
	    		                            		}
	    	                            			else {
	    			                            		pop.close();
	    	                            			}
	    		                            		openChildSet();
	    	                            		}
	    	                            		else {
	    		                            		pop.close();
	    	                            		}
	    	                            	});
	    	                            	roomChange();
	    	                            });
	    	                            function roomChange() {
	    	                        		$(".adultnumset").addClass('dspNon');
	    	                        		$("#adult_number").addClass('dspNon');
	    	                            	if ($("#room_numbers").val() > 1) {
	    	                            		$(".adult_dbl").removeClass('dspNon');
	    	                            	}
	    	                            	else {
	    	                            		$(".adult_sgl").removeClass('dspNon');
	    	                            	}
	    	                            }
	    	                            </script>
	    	                            	<span>名</span>
	    								</td>
	    								<td>
	    									子供
	    									<div class="selectbox">
	    	                    			<?php
	    	                    				$num = 0;
	    	                    				for ($roomNum=1; $roomNum<=SITE_ROOM_NUM; $roomNum++) {
	    	                    					for ($i=1; $i<=6; $i++) {
	    	                    						$num += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i));
	    	                    				?>
	    	                    				<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
	    	                    				<?php
	    	                    					}
	    	                    				}
	    	                    				?>
	    	                    				<a href="javascript:void(0)" onclick="openChildSet()" id="child_text"><?php print $num?></a>
	    	                    		</div><span>名</span>
	    								</td>
									<?php if($_POST['undecide_sch']<>1):?>
										<td>
											<input class="bt-Change" type="submit" value="" onclick="document.changeDay.submit();" />
										</td>
										<?php endif;?>
	    								<?php if($_POST['undecide_sch']==1):?>
										<td>
											<input class="bt-Change" type="submit" value="" onclick="document.changeDay.submit();" />
										</td>
										<?php endif;?>
	    							</tr>
									
	    							<tr>
	    								<td colspan="4">
											<?php
												if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
													$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
													$date = str_replace("月", "-", $date);
													$date = str_replace("日", "", $date);
													$tmp = explode('-',$date);
												}
												?>
											<?php if($_POST["calendarLink"]<>1 && $_POST['undecide_sch']<>1):?>
											<font style="font-size: 13px;"><?php print $tmp[1]?>月<?php print $tmp[2]?>日の部屋数：後</font><span><?php  print $arPayList[$date]["HOTELPROVIDE_NUM"]-$arPayList[$date]["HOTELPROVIDE_BOOKEDNUM"]?></span><font style="font-size: 12px;">部屋</font>

											<?php if(number_format($money_all_all) > 0){  ?>
											<a href="javascript:void(0)" onclick="document.otherDays.submit();" style="font-size: 13px; margin-left: 30px;">▼他の日の空室・料金をカレンダーで見る</a>
											<?php }?>

											<?php endif;?>


	    								</td>
	    							</tr>
	    						</table>
	    					</form>
	    				</section>  
						
	    				<form action="plan-detail.html#calendarmain" method="post" id="otherDays" name="otherDays">
	    				<input type="hidden" name="calendarLink" value="1" />
	    				<?php print $inputs->hidden("undecide_sch","1")?>
						<?php print $inputs->hidden("search_date",$collection->getByKey($collection->getKeyValue(), "search_date"))?>
	    				<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
	    				<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
	    				<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
	    				<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
						<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ 
							//print $inputs->hidden("HOTELPAY_ID", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_ID"));
							//print $inputs->hidden("HOTELPROVIDE_ID", $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_ID"));
						}?>
	    				<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
	    				<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
	    				<?php
	    				if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
	    					for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
	    				?>
	    				<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
	    				<?php for ($i=1; $i<=6; $i++) {?>
       					<input type="hidden" name="child_number<?= $roomNum.$i?>" value="<?php echo $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);?>">
       					<?php //print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?> 
	    				<?php
	    					}
	    				}  
	    				?>
						
	    				</form>
						
	    			                    	
                    	<?php if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") != 1) {?>
           	
						<div style="background: #ffeeb7; padding:5px; padding-bottom:15px;">

						<?php if(number_format($money_all_all) == 0 || number_format($arPayList[$date]["money_all"]) == 0){  ?>
							 <span style="margin-left: 64px;margin-top:15px; color:red;">お探しの人数のプラン設定がありません。人数の条件を変更してください。</span>
						<?php } else{ ?>
                    	<ul class="priceList">
	                    	<li>合計料金:           
	                    	<b>￥<?php 
	                    	if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
	                    		print number_format($money_all_all);
	                    	}else{
	                    		print number_format($arPayList[$date]["money_all"]);
	                    	}
	                    	
	                    	?></b><font style="font-size: 12px;color: #585858;">（税込・サービス料込）</font>
	                    	</li>
	                    	<?php for ($nightNum=1; $nightNum<=$collection->getByKey($collection->getKeyValue(), "night_number"); $nightNum++) {
										print $nightNum."泊目：<br/>";
	                    			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
									?><li><?php print $roomNum?>部屋目：大人<span>
                    				<?php print $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);?>人</span>×<span> 
									<?php 
									if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
										print number_format($room[$roomNum]["money_perperson"]);
									}else{
										print number_format($arPayList[$date]["HOTELPAY_MONEY".$count]);
									}
									?>
                    				<?php
										$childStr = array("小学生低学年","小学生高学年","幼児（食事・布団あり）","幼児（食事あり）","幼児（布団あり）","幼児（食事・布団なし）");
										if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){
											for($i=1;$i<=6;$i++){
												if($room[$roomNum]["childFee".$i]){
													print "<br/> + ".$childStr[$i-1].$param["child_number".$roomNum.$i]."人× ".number_format($room[$roomNum]["childFee".$i]);

											}
											}
										}else{
											if($param["child_number".$roomNum."1"] > 0){
												$room[$roomNum]["childMath1"] = "小学生低学年".$param["child_number".$roomNum."1"]."人× ".number_format($arPayList[$date]["childA2Price"]);
											}
											if($param["child_number".$roomNum."2"] > 0){
												$room[$roomNum]["childMath2"] = "小学生高学年".$param["child_number".$roomNum."2"]."人× ".number_format($arPayList[$date]["childAPrice"]);
											}
											if($param["child_number".$roomNum."3"] > 0){
												$room[$roomNum]["childMath2"] = "幼児（食事・布団あり）".$param["child_number".$roomNum."3"]."人×  ".number_format($arPayList[$date]["childBPrice"]);
											}
											if($param["child_number".$roomNum."4"] > 0){
												$room[$roomNum]["childMath2"] = "幼児（食事あり）".$param["child_number".$roomNum."4"]."人× ".number_format($arPayList[$date]["childB2Price"]);
											}
											if($param["child_number".$roomNum."5"] > 0){
												$room[$roomNum]["childMath2"] = "幼児（布団あり）".$param["child_number".$roomNum."5"]."人× ".number_format($arPayList[$date]["childCPrice"]);
											}
											if($param["child_number".$roomNum."6"] > 0){
												$room[$roomNum]["childMath2"] = "幼児（食事・布団なし）".$param["child_number".$roomNum."6"]."人× ".number_format($arPayList[$date]["childDPrice"]);
											}
											for($i=1;$i<=6;$i++){
												if($room[$roomNum]["childMath".$i]){
													print "<br/>   + ".$room[$roomNum]["childMath".$i];
												}
											}
										} ?>
                    				= <?php 
										if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
											print number_format($room[$roomNum]["money_ALL"]);
										}else{
											print number_format($arPayList[$date]["money_all"]);
										}
										?>円</span>
                    				</li>
                    				<?php }?>
							<?php }?>
						</ul>
	                    	
						<div class="bt_cn">
						<?php
						if($arPayList[$date]["HOTELPROVIDE_NUM"]-$arPayList[$date]["HOTELPROVIDE_BOOKEDNUM"] > 0){
						?>
						<a href="javascript:void(0)" onclick="document.pointDay.submit();">予約へ進む</a>
							<?php
							if ($arPayList[$date]["HOTELPROVIDE_FLG_REQUEST"] == 1 ){
							?>
							<font style="font-size: 13px;color: #ff0000;">※この日程はリクエスト予約の受付です。</font>
							<?php
							}
							?>
						<?php
						}
						?>
						
						<?php
						if ($arPayList[$date]["HOTELPROVIDE_FLG_REQUEST"] != 1 ){
						?>
						<form action="reservation.html" method="post" id="pointDay" name="pointDay">
						<?php
						}
						?>
						<?php
						if ($arPayList[$date]["HOTELPROVIDE_FLG_REQUEST"] == 1 ){
						?>
						<form action="reservation-request.html" method="post" id="pointDay" name="pointDay">
						<?php }
						?>
						<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
						<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
						<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
						<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
						<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ 
							print $inputs->hidden("HOTELPAY_ID", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_ID"));
							print $inputs->hidden("HOTELPROVIDE_ID", $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_ID"));
						}?>
						<?php print $inputs->hidden("target_date", $date)?>
						<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
						<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
						<?php
						if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
							for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
						?>
						<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
						<?php for ($i=1; $i<=6; $i++) {?>
						<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
						<?php }?>
						<?php
							}
						}
						?>
						</form>
					</div>
					<?php }?>
					</div>
					<?php }?>
                    <br/>

					<?php if($calendarNoShowFlg){ ?>
						<div style="background: #ffeeb7; padding:5px; padding-bottom:15px;">
							<span style="margin-left: 64px;margin-top:15px; color:red;">お探しの人数のプラン設定がございません。人数の条件を変更してください。</span>
						</div><br/>
					<?php } ?>

                    <?php if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == "1" && $calendarNoShowFlg != 1 ) {?>
                    	<div class="cuki">
                    		<ul>
                    			<li>カレンダーに表記されている料金は1泊あたりの合計料金です。</li>
                    			<li>カレンダーをクリックすると予約内容の入力画面へ進みます。</li>
                    		</ul>
                    		<p>予約受付は<b><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_ACC_DAY")?><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_DAY_ACCEPT_FROM")?></b>日前の<b><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_ACC_HOUR")?><?php print date("h",$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_ACC_HOUR"))?></b>時まで</p>
                    	</div>
					<?php }?>	

                    	<?php
        				$SDate = "";
        				$PDate = "";
        				$NDate = "";
        				$flgPrev = true;
        				if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
        					$SDate = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
        					$SDate = str_replace("月", "-", $SDate);
        					$SDate = str_replace("日", "", $SDate);
        				}

        				//	前の月
        				if (date("m",strtotime("-1 month" ,strtotime($SDate))) == date("m") and
        					date("Y",strtotime("-1 month" ,strtotime($SDate))) == date("Y")) {
							//	前の月が当月
							$PDate = date("Y年m月d日");
						}
						else {
							$PDate = date("Y年m月01日",strtotime("-1 month" ,strtotime($SDate)));
						}

						if (date("m",strtotime("-1 month" ,strtotime($SDate))) < date("m") and
								date("Y",strtotime("-1 month" ,strtotime($SDate))) <= date("Y")) {
							$flgPrev = false;
						}

						//	次の月
						if (date("m",strtotime("1 month" ,strtotime($SDate))) == date("m") and
							date("Y",strtotime("1 month" ,strtotime($SDate))) == date("Y")) {
							//	次の月が当月
							$NDate = date("Y年m月d日");
						}
						else {
            				$NDate = date("Y年m月01日",strtotime("1 month" ,strtotime($SDate)));
						}

        				?>
        				
        				<?php if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == "1" && $calendarNoShowFlg != 1) {?>
                    	<ul class="calenderMonth-Ln">
                    			<?php if ($flgPrev) {?>
                    			<li>
                    				<?php $formname = "frmPrev"?>
		                        	<form action="plan-detail.html#calendermain" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
			                        	<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/month-back.png" width="91" height="29" alt="前の月" /></a>
			                        	<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
			                        	<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
			                        	<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
			                        	<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
			                        	<!-- <?php print $inputs->hidden("search_date", $PDate)?> -->
			                        	<input type="hidden" name="search_date" value="<?php echo $PDate;?>">
					                        	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
			                        	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
			                        	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
			                        	<?php
			                        	if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
											for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
										?>
			                        	<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
			                        	<?php for ($i=1; $i<=6; $i++) {?>
			                        	<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
			                        	<?php }?>
										<?php
											}
										}
			                        	?>
		                        	</form>
                    			</li>
                    			<?php }?>
                    			<li style="float: right;">
                    				<?php $formname = "frmNext"?>
		                        	<form action="plan-detail.html#calendermain" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
			                        	<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();" ><img src="./images/common/month-next.png" width="91" height="29" alt="次の月" /></a>
			                        	<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
			                        	<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
			                        	<?php print $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))?>
			                        	<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
			                        	<!-- <?php print $inputs->hidden("search_date", $NDate)?> -->
			                        	<input type="hidden" name="search_date" value="<?php echo $NDate;?>">
					                        	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
			                        	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
			                        	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
			                        	<?php
			                        	if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
											for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
										?>
			                        	<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
			                        	<?php for ($i=1; $i<=6; $i++) {?>
			                        	<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
			                        	<?php }?>
										<?php
											}
										}
			                        	?>
		                        	</form>
                    			</li>
                    		</ul>
								

                    		<?php
                    		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
                    			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
                    			$date = str_replace("月", "-", $date);
                    			$date = str_replace("日", "", $date);
                    		}
//							print_r($arPayList);
						//	$date = date("Y-m-d");
							
							if($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "COMPANY_LINK") != ""){
								print calendarPublic($date, $arPayList,$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_DAY_ACCEPT_FROM"));
							}
							else {
								print calendarPublic($date, $arPayList,$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_ACC_DAY"));
							}
                    		?>
                    	
                    		</div>
    	                	<div class="section">
    	                		<h3>◆空室カレンダーの見方</h3>
    	                		<p>
    	                			上から順に日付、1泊あたりの合計金額、大人1人あたりの料金、ポイント率、空室状況を表しています。
    	                		</p>
    	                		<dl class="list">
    	                			<dt>・大人1人あたりの料金について</dt>
    	                			<dd>複数のお部屋をご予約で、部屋毎に人数が異なる場合は大人1人あたりの料金が表示されません。</dd>
    	                			<dt>・空室状況について</dt>
    	                			<dd>○・・・10室以上の空室あり　1～9・・・予約できる残室数　×・・・満室です<br />リクエスト受付・・・予約リクエストを受付後、施設から予約可否をご連絡します。</dd>
    	                			<dt>・表示なし</dt>
    	                			<dd>すでに予約の受付時間が過ぎた日程か、このプランの販売対象外の日程です。</dd>
    	                			<dt>・ポイントUPアイコン</dt>
    	                			<dd>通常(税抜1%）よりもポイントがもらえるお得な期間を表します。</dd>
    	                		</dl>
    	                	</div>
							<?php }?>	
	                		<div class="aboutprice">
	                			<div>
	                				<h3>◆子供料金について</h3>
	                				<div class="cf">
                						<ul class="flList2">
                							<li>
                								小学生高学年
                							</li>
                							<li>
                								小学生低学年
                							</li>
                							<li>
                								幼児（食事・布団あり）
                							</li>
                							<li>
                								幼児（食事あり）
                							</li>
                							<li>
                								幼児（布団あり）
                							</li>
                							<li>
                								幼児（食事・布団なし）
                							</li>
                						</ul>
                						
	                					<ul class="flList2">
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA12") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA42") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA32");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA42") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA32");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA42") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA32");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA1") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA4") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA3");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA4") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA3");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA4") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_PS_DATA3");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA1") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA4") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA3");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA4") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA3");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA4") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA3");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA5") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA7") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA6");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA7") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA6");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA7") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA6");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA8") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA11") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA10");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA11") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA10");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA11") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA10");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                						<li>
	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA12") == 1) {?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA14") == 1) {?>
	                							大人料金の<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA13");?>%
	                							<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA14") == 2) {?>
    	                							<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA13");?>円
    	                						<?php }?>
    	                						<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA14") == 3) {?>
	                							大人料金から<?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_BB_DATA13");?>円割引き
	                							<?php }?>
	                						<?php }else {?>
	                							受け入れなし
	                						<?php }?>
	                						</li>
	                					</ul>
	                				</div>
	                			</div>
	                			
	                			<div>
	                				<h3>◆料金についての備考</h3>
	                				<p><?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_REMARKS") != "") {?>
	                				<?php redirectForReturn($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_REMARKS"))?>
	                				<?php }?></p>
	                			</div>
  
							</div>
								
	                    	<div class="aboutprice">
	                    		<div class="maxsell">
	                    			<h3>◆お支払いについて</h3>
	                    				<p>・現地決済　…　ご宿泊の際にフロントにてご宿泊料金をお支払いください。</p>
	                    			</div>
	                    	</div>

    	                	<div class="aboutprice">
    	                		<div class="maxsell">
    	                			<h3>◆キャンセルポリシー</h3>
    	                			<div><p style="word-break:break-all;">
                					<?php
								if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){
                					$dataCancel = "";
                					if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {

                						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {

                							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
                								$can = "";
                								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
                									$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
                								}
                								else {
                									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
                								}
                								$dataCancel .= "無連絡不泊 ".$can."\n";
                							}

                							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {
                								$can = "";
                								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
                									$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
                								}
                								else {
                									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
                								}
                								$dataCancel .= "当日キャンセル ".$can."\n";
                							}

                							for ($i=3; $i<=7; $i++) {
                								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {
                									$can = "";
                									if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
                										$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
                									}
                									else {
                										$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
                									}
                									$dataCancel .= $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで".$can."\n";
                								}
                							}

                						}

                					}
                					else {

                						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {
                							$can = "";
                							if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
                								$can = "宿泊料の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%";
                							}
                							else {
                								$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円";
                							}
                							$dataCancel .= "無連絡不泊 ".$can."\n";
                						}

                						if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {
                							$can = "";
                							if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
                								$can = "宿泊料の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%";
                							}
                							else {
                								$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円";
                							}
                							$dataCancel .= "当日キャンセル ".$can."\n";
                						}

                						for ($i=3; $i<=6; $i++) {
                							if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {
                								$can = "";
                								if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
                									$can = "宿泊料の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%";
                								}
                								else {
                									$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円";
                								}
                								$dataCancel .= $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)."～".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)."日前まで".$can."\n";
                							}
                						}
                					}
                					print redirectForReturn($dataCancel);
							}else{
									print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "TL_PLAN_CANCELDATA");
							}
                					?>
	    	               </p></div>
                   		</div>
                   	</div>
                   	
               </section>
<!--カレンダー-->
                </div>
            </div>
        </article>
    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->


</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
