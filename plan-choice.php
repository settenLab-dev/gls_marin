<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');


$dbMaster = new dbMaster();

//  print_r($_POST);exit;
$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

//会員しか見えない
/*
if (!$sess->sessionCheck()) {
	$_SESSION['ref_url']=$_SERVER['REQUEST_URI'];
	cmLocationChange("login.html");
}
*/

$collection = new collection($db);

if($_POST){
	$collection->setPost();
	cmSetHotelSearchDef($collection);
}
else {
//	$collection->setByKey($collection->getKeyValue(), "ROOM_ID", $_GET["room_id"]);
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["company_id"]);
	$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $_GET["plan_id"]);
	$collection->setByKey($collection->getKeyValue(), "priceper_num", $_GET["p_num"]);
//	$collection->setByKey($collection->getKeyValue(), "room_number", $_GET["room_number"]);
//	$collection->setByKey($collection->getKeyValue(), "adult_number1", $_GET["adult_number1"]);
	
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
	  	if($_GET["undecide_sch"] != ""){
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", $_GET["undecide_sch"]);
	  	}
	 	else{
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
			// テストで１に設定。通常は２
		}
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y年m月d日'));
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
	if($_GET["calender"] != ""){
		$collection->setByKey($collection->getKeyValue(), "calender", $_GET["calender"]);
	}
	else {
	}

	cmSetHotelSearchDef($collection);
}


$shopTarget = new shop($dbMaster);
$shopTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));




	//	ココトモ
	$shopPlanTarget = new shopPlan($dbMaster);
	$shopPlanTarget->select($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

	$hotelRoom = new hotelRoom($dbMaster);
	$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	foreach ($shopPlanTarget->getCollection() as $plan) {
		
//print_r($plan);
	}
	foreach ($collection->getCollection() as $param) {
		//print_r($param);
	}




$shop = new shop($dbMaster);

$shopBooking = new shopBooking($dbMaster);
// $collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", "");
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", "");
$shop->selectListPublicPlan($collection);

$planCnt = 0;
$dspArray = array();

$money_1 = "";
$money_all = "";

if ($shop->getCount() > 0) {
	foreach ($shop->getCollection() as $data) {

//print_r($data);
		$dspArray[$data["SHOPPLAN_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_ID"] = $data["SHOPPLAN_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_NAME"] = $data["SHOP_NAME"];
		$dspArray[$data["SHOPPLAN_ID"]]["money_1"] = $data["money_1"];
		$dspArray[$data["SHOPPLAN_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["SHOPPLAN_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_ID"] = $data["SHOP_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_NAME"] = $data["SHOP_NAME"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_ID"] = $data["SHOPPLAN_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_NAME"] = $data["SHOPPLAN_NAME"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_PIC_APP"] = $data["SHOP_PIC_APP"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PIC"] = $data["SHOPPLAN_PIC"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_SALE_FROM"] = $data["SHOPPLAN_SALE_FROM"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_SALE_TO"] = $data["SHOPPLAN_SALE_TO"];

		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_DISCRIPTION"] = $data["SHOPPLAN_DISCRIPTION"];

		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_LIST_AREA"] = $data["SHOP_LIST_AREA"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_AREA_LIST1"] = $data["SHOPPLAN_AREA_LIST1"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_AREA_LIST2"] = $data["SHOPPLAN_AREA_LIST2"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_AREA_LIST3"] = $data["SHOPPLAN_AREA_LIST3"];

		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_CATEGORY_LIST1"] = $data["SHOPPLAN_CATEGORY_LIST1"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_CATEGORY_LIST2"] = $data["SHOPPLAN_CATEGORY_LIST2"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_CATEGORY_LIST3"] = $data["SHOPPLAN_CATEGORY_LIST3"];

/*
		$count_spi = "";
		for ($i=1; $i<=12; $i++){
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE".$i] = $data["SHOP_PRICETYPE_ID".$i];
			if($data["SHOP_PRICETYPE_ID".$i] != ""){
				$count_spi = $i;
			}
		}
//print $count_spi;

		for ($i=1; $i<=$count_spi; $i++){
			//$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE".$i] = $data["SHOP_PRICETYPE_ID".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_KIND".$i] = $data["SHOP_PRICETYPE_KIND".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND1".$i] = $data["SHOP_PRICETYPE_MONEYKIND1".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND2".$i] = $data["SHOP_PRICETYPE_MONEYKIND2".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND3".$i] = $data["SHOP_PRICETYPE_MONEYKIND3".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND4".$i] = $data["SHOP_PRICETYPE_MONEYKIND4".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND5".$i] = $data["SHOP_PRICETYPE_MONEYKIND5".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND6".$i] = $data["SHOP_PRICETYPE_MONEYKIND6".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND7".$i] = $data["SHOP_PRICETYPE_MONEYKIND7".$i];
		//	$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND8".$i] = $data["SHOP_PRICETYPE_MONEYKIND8".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_ROOM".$i] = $data["ROOM_ID".$i];
		}
	//	$dspArray[$data["SHOPPLAN_ID"]]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
*/
	}
}
//print_r($dspArray);
		//各部屋の料金書き出す
		for ($i=1; $i<=1; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $data["SHOPPLAN_ID"]);
//				$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $data["ROOM_ID".$i]);
			//	$search_collection->setByKey($search_collection->getKeyValue(), "SHOP_PRICETYPE_ID", $data["SHOP_PRICETYPE_ID".$i]);
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

					$room_sch = $shop->selectMoneyEveryRoomDay($search_collection);	
					if($room_sch != ""){
						$room[$i] = $room_sch;	
					}
	//print_r($room[$i]);



		}

foreach($room[$i] as $data){
	if($data["money_perperson"] == ""){	
		//$noChildFlg = 1;
	}
}

// print_r($shopPlanTarget->getCollection());
// print_r($hotel->getCollection());
$money_all_all = 0;
for ($j=1; $j<=1; $j++){
	for ($i=1; $i<=1; $i++){
		$money_all_all += $room[$i]["money_ALL"];
	}
}

// reset calendar show flg
$calendarNoShowFlg = 0;

	$arPayList = array();

	//	料金カレンダー
	$hotelPay = new hotelPay($dbMaster);
	$hotelPayTarget = new hotelPay($dbMaster);

	//	料金設定検索
	//print_r($shopPlanTarget);
	$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ACC_DAY", $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_DAY"));
	

	$hotelPay->selectListMin($collection);
 
//	print_r($hotelPay);
	
	//	登録済みデータ設定
	if ($hotelPay->getCount() > 0) {
		foreach ($hotelPay->getCollection() as $hp) {
	//print_r($hp);
			//	POSTデータ
			$arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["SHOP_PRICETYPE_ID"] = $hp["SHOP_PRICETYPE_ID"];
//			$arPayList[$hp["HOTELPAY_DATE"]]["ROOM_ID"] = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["priceper_num"] = $collection->getByKey($collection->getKeyValue(), "priceper_num");
			//$arPayList[$hp["HOTELPAY_DATE"]]["room_number"] = $collection->getByKey($collection->getKeyValue(), "room_number");

			for ($roomNum=1; $roomNum<=1; $roomNum++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["priceper_num"] = $collection->getByKey($collection->getKeyValue(), "priceper_num");
			/*	for ($i=1; $i<=6; $i++) {
					$arPayList[$hp["HOTELPAY_DATE"]]["child_number".$roomNum.$i] = $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);
				}
			*/
			}

			$arPayList[$hp["HOTELPAY_DATE"]]["date"] = $hp["HOTELPAY_DATE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ID"] = $hp["HOTELPAY_ID"];

/*
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ROOM_NUM"] = $hp["HOTELPAY_ROOM_NUM"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ROOM_OVER"] = $hp["HOTELPAY_ROOM_OVER"];

			for ($i=1; $i<=4; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_PS_DATA".$i] = $hp["HOTELPAY_PS_DATA".$i];
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_PS_DATA".$i."2"] = $hp["HOTELPAY_PS_DATA".$i."2"];
			}
			for ($i=1; $i<=14; $i++) {
				$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_BB_DATA".$i] = $hp["HOTELPAY_BB_DATA".$i];
			}
*/
//print "OK";
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY_FLG"] = $hp["HOTELPAY_MONEY_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE"] = $hp["HOTELPAY_SERVICE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_REMARKS"] = $hp["HOTELPAY_REMARKS"];
			
			//------------------start-------------------//

			//各日程の料金書き出す
			for ($i=1; $i<=1; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $data["SHOPPLAN_ID"]);
//				$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $data["ROOM_ID".$i]);
//				$search_collection->setByKey($search_collection->getKeyValue(), "SHOP_PRICETYPE_ID", $data["SHOP_PRICETYPE_ID".$i]);
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $hp["HOTELPAY_DATE"]);
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

					$room_perday = $shop->selectMoneyEveryRoomDay($search_collection);	
//print_r($room_perday);
					if($room_perday != ""){
						$roomPerDay[$i] = $room_perday;	
					}

			}
				//print_r($roomPerDay);
/*
			for ($i=1; $i<=1; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
			//	$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOP_PRICETYPE_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID"));
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $hp["HOTELPAY_DATE"]);
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

				$roomPerDay[$i] = $shop->selectMoneyEveryRoom($search_collection);	
				//print_r($roomPerDay[$i]);
			
				for($k=1;$k<=6;$k++){
					if($roomPerDay[$i]["chind".$k."NoAccept"] > 0){
						$calendarNoShowFlg = 1;
					}
				}
			
			}
*/			
			$diff_flg = 0;
/*
			if($collection->getByKey($collection->getKeyValue(), "room_number") > 1){
				for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
					for($j=$i+1;$j<=$collection->getByKey($collection->getKeyValue(), "room_number"); $j++){
						if($room[$i]["money_perperson"] == $room[$j]["money_perperson"]){
							continue;
						}
						else{
							$diff_flg = 1;
							break;
						}
					}
				}
			}
*/			
			$money_perperson = "";
			$money_totol = 0;
			for ($i=1; $i<=1; $i++){
				$money_perperson[$i] = $roomPerDay[$i]["money_perperson"];
				$money_totol += $roomPerDay[$i]["money_ALL"];
				$calender_price = $roomPerDay[$i]["calender_price"];
				$calender_room = $roomPerDay[$i]["calender_room"];
			}
			asort($money_perperson);
//			print_r($money_perperson);
	
			$arPayList[$hp["HOTELPAY_DATE"]]["money_all"] = $money_totol;
			$arPayList[$hp["HOTELPAY_DATE"]]["money_1"] = $money_perperson[1];
			$arPayList[$hp["HOTELPAY_DATE"]]["diff_flg"] = $diff_flg;

			// カレンダーに表示する代表料金・在庫ステータス
			$arPayList[$hp["HOTELPAY_DATE"]]["calender_price"] = $calender_price;
			$arPayList[$hp["HOTELPAY_DATE"]]["calender_room"] = $calender_room;
			//------------------end-------------------//
			
			//$arPayList[$hp["HOTELPAY_DATE"]]["money_all"] = $hp["money_all"];
			//$arPayList[$hp["HOTELPAY_DATE"]]["money_1"] = $hp["money_1"];
			
			//当日の予約数
			$collection_booked = new collection($db);
			$collection_booked->setByKey($collection->getKeyValue(), "COMPANY_ID", $arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $arPayList[$hp["HOTELPAY_DATE"]]["SHOPPLAN_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "BOOKING_DATE", $arPayList[$hp["HOTELPAY_DATE"]]["date"]);

			//$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPROVIDE_BOOKEDNUM"] = $shopBooking->selectBookedNum($collection_booked);
//			print_r($arPayList[$hp["HOTELPAY_DATE"]]["HOTELPROVIDE_BOOKEDNUM"]);
			
		}
	}

//	print_r($arPayList);

/*
	$hotelProvide = new hotelProvide($dbMaster);
	$hotelProvide->selectListPublic($collection);
	if ($hotelProvide->getCount() > 0) {
		foreach ($hotelProvide->getCollection() as $hp) {
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["date"] = $hp["HOTELPROVIDE_DATE"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_ID"] = $hp["HOTELPROVIDE_ID"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_STOP"] = $hp["HOTELPROVIDE_FLG_STOP"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_REQUEST"] = $hp["HOTELPROVIDE_FLG_REQUEST"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_NUM"] = $hp["HOTELPROVIDE_NUM"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_BOOKEDNUM"] = $hp["HOTELPROVIDE_BOOKEDNUM"];
// 			print $hp["HOTELPROVIDE_DATE"]."/".$hp["HOTELPROVIDE_NUM"]."<br />";
	//print_r($hp);
		}
	}
*/
 //	print_r($arPayList[$hp["HOTELPROVIDE_DATE"]]);
//	print_r($hotelProvide->getCollection());
//	print_r($arPayList);




// print_r($arPayList);


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$shopTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("includes/box/common/meta201505.php"); ?>
<title>プラン詳細 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="プラン,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="//cocotomo.net/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//cocotomo.net/js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- ?窗 -->
<link rel="stylesheet" href="//cocotomo.net/common/css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="//cocotomo.net/common/js/popupwindow-1.6.js"></script>
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

<div id="modal-content">
	<p>「閉じる」か「背景」をクリックするとモーダルウィンドウを終了します。</p>
	<p><a id="modal-close" class="button-link">閉じる</a></p>
</div>



		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">検索結果</a></li>
            <li><span>プラン詳細</span></li>
        </ul>
        
        <article class="titlecase2">
       		<div>
       			<h2><?php print $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME")?></h2>
       			<ul class="icon-type">
       				<?php /*<li class="type01">施設タイプ</lI> */ ?>
       				<?php
					$arArea = array();
					$arTemp = explode(":", $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_LIST_AREA"));
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
       				<li><?php $formname = "basic_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail.html?basic=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu01_n.png" width="113" height="30" alt="基本情報" ></a>
       					<?php print $inputs->hidden("current_page", "1")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("SHOP_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"))?>
       					<?php print $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))?>
       					<!-- 
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					 -->
       					 <input type="hidden" name="search_date" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
       				</form></li>
       				<li><?php $formname = "info_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail.html?info=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu02_n.png" width="113" height="30" alt="プラン一覧" ></a>
       					<?php print $inputs->hidden("current_page", "2")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("SHOP_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"))?>
       					<?php print $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))?>
       					<!-- 
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					 -->
				<?php if ($collection->getByKey($collection->getKeyValue(), "undeide_sch") != 1){ ?>
       					 <input type="hidden" name="search_date" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
					<?php }	else{?>
       					 <input type="hidden" name="search_date" value="<?php echo date("Y-m-d",strtotime("+1 day"));?>">
					<?php }?>
       					<!--<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>-->
       					<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
 
       				</form></li>
       				<li><?php $formname = "map_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail.html?map=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu03_n.png" width="113" height="30" alt="地図・アクセス" ></a>
       					<?php print $inputs->hidden("current_page", "6")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("SHOP_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"))?>
       					<?php print $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))?>
       					<!-- 
       					<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
       					 -->
       					 <input type="hidden" name="search_date" type="hidden" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>

       				</form></li>
    	   			<!--<li><a href="#"><img src="./images/common/tab-submenu04.png" width="78" height="23" alt="お気に入りに追加" ></a></li>-->
	       		</ul>
       		</div>
       	</article>
<?php
//掲載期間が切れていたら警告文表示
if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") < date("Y-m-d") && ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") != NULL)){?>
        <article class="mainbox" id="ag">
			<div class="inner">
			<center><B><font color="red">＞＞　ご指定のプランは販売期間が過ぎました。　＜＜</font></B></center>
	</article>
<?php }else{ ?>
        <article class="mainbox" id="ag">
			<div class="inner">
			<h2 class="bl-bg"><span class="new-b"></span><B><?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?></B></h2>
			<div class="cont">
				<div class="clearfix">
					<ul class="icon">
						<!--<li><img src="./images/common/icon-nomeal.jpg"</li>-->
						<?php
						$meal = "";
						if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_BF_FLG") == 2) {
							$meal = "朝";
						}
						if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_DN_FLG") == 2) {
							$meal .= "夕";
						}
						if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_LN_FLG") == 2) {
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
					チェックイン：<?php print date("H:i", strtotime($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CHECKIN")))?>～<?php print date("H:i", strtotime($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CHECKIN_LAST")))?> / チェックアウト～<?php print date("H:i", strtotime($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CHECKOUT")))?>
					</div>
				    <a href="#calendermain" class="vacancy_c">料金・空室を見る</a>
				</div>
				<div class="tb-sp20 sealetime">
					<?php $fromDate = cmDateDivide($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_FROM"))?>
					<?php $toDate = cmDateDivide($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO"))?>
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
				    	 <?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC") != "" || $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC1") != "") {?>
							<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
							<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC")?>" width="359" height="265" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>">
							<?php }else{?>
				    		<img src="<?php print URL_PUBLIC_LINK.$shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC1")?>" width="355" height="265" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>">
							<?php }?>
				    	<?php }else{?>
				    		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="358" height="265" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>">
				    	<?php }?>
				    </div>
				    <ul id="subimage">
			    			<?php for ($i=""; $i<=4; $i++) {?>
			    			 	<?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC".$i) != "") {?>
			    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC".$i)?>" width="84" height="75" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>"></a>
			    				<?php }?>
			    			<?php }?>
				    </ul>
				</div>
				<section class="section1 cf">
				    <p style="word-break:break-all;"><?php print redirectForReturn($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATCH"))?></p>
				</section>

				<section class="section3">
				    <h3>○特 典</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_DISCRIPTION"))?></p>
				</section>
			    <section class="section3">
			        <h3>○お食事</h3>
			        <?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_BF_FLG") == 2) {?>
			        <p><span class="icon radius5">朝食</span></p>
			        <?php }?>
			        <?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_FOOD1") != "") {?>
			        <p><?php print redirectForReturn($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_FOOD1"))?></p>
			        <?php }?>
			
			        <?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_DN_FLG") == 2) {?>
			        <p><span class="icon radius5">夕食</span></p>
			        <?php }?>
			        <?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_FOOD2") != "") {?>
			        <p><?php print redirectForReturn($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_FOOD2"))?></p>
			        <?php }?>
			
			        <?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_LN_FLG") == 2) {?>
			        <p><span class="icon radius5">昼食</span></p>
			        <?php }?>
			        <?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_FOOD3") != "") {?>
			        <p><?php print redirectForReturn($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_FOOD3"))?></p>
			        <?php }?>
			    </section>
			    <?php }?>

                   
                <section class="section5">
                    <h3>○お部屋情報</h3>
                    <section>
                        <h4><span class="type">お部屋タイプ</span><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></h4>
                        <div class="image">
                        	<?php if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC1") != "") {?>

                        		<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC1")?>" width="156" height="116" alt="<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?>">
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

                                <li>広さ：<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_BREADTH")?>㎡／定員：<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_FROM")?>～<?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_TO")?>人</li>
                            </ul>
                            <p style="word-break:break-all; "><?php print redirectForReturn($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_DISCRITION"))?></p>
                        </div>
                    </section>
                </section>

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
