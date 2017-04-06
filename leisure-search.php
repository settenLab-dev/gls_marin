<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
// print_r($collection->getCollection());
cmSetHotelSearchDef($collection);
$collection->setByKey($collection->getKeyValue(), "pageNum", 10);


//	ページャ設定
$perpage = $collection->getByKey($collection->getKeyValue(), "pageNum");
$page = $collection->getByKey($collection->getKeyValue(), "pageID");
$currentPage = 0;
if (!cmCheckNull($page) or !cmCheckPtn($page, CHK_PTN_NUM) or $page <= 0) {
	$currentPage = 0;
}
else {
	$currentPage = $page-1;
}
$limit = ($currentPage*$perpage).",".$perpage;
$collection->setByKey($collection->getKeyValue(), "limit", $limit);
$collection->setByKey($collection->getKeyValue(), "limitptn", "plan");

//	検索するホテル
$targetId = "";
// $hotelCompany = new hotel($dbMaster);
// $hotelCompany->selectListCompanyCount($collection);

$hotel = new hotel($dbMaster);

// if ($hotelCompany->getCount() > 0) {
// 	foreach ($hotelCompany->getCollection() as $cc) {
// 		if ($targetId != "") {
// 			$targetId .= ",";
// 		}
// 		$targetId .= $cc["COMPANY_ID"];
// 	}
// 	$collection->setByKey($collection->getKeyValue(), "targetId", $targetId);
	$hotel->selectListPublicHotel($collection);
// }

// $hotel_plan = new hotel($dbMaster);
// $hotel_plan->selectListPublicPlan($collection);
// print_r($hotel->getCollection());
// print_r($hotelCompany->getCollection());

$companyCnt = 0;
$planCnt = 0;
$dspArray = array();
if ($hotel->getCount() > 0) {
	foreach ($hotel->getCollection() as $data) {
		$planCnt++;
		$dspArray[$planCnt]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$planCnt]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$planCnt]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$planCnt]["HOTELPLAN_NAME"] = $data["HOTELPLAN_NAME"];
		$dspArray[$planCnt]["HOTEL_PIC_APP"] = $data["HOTEL_PIC_APP"];
		$dspArray[$planCnt]["HOTELPLAN_PIC"] = $data["HOTELPLAN_PIC"];
		$dspArray[$planCnt]["HOTELPLAN_DATE_SALE_FROM"] = $data["HOTELPLAN_DATE_SALE_FROM"];
		$dspArray[$planCnt]["HOTELPLAN_DATE_SALE_TO"] = $data["HOTELPLAN_DATE_SALE_TO"];
		$dspArray[$planCnt]["HOTELPLAN_BF_FLG"] = $data["HOTELPLAN_BF_FLG"];
		$dspArray[$planCnt]["HOTELPLAN_DN_FLG"] = $data["HOTELPLAN_DN_FLG"];
		$dspArray[$planCnt]["HOTELPLAN_LN_FLG"] = $data["HOTELPLAN_LN_FLG"];
		$dspArray[$planCnt]["HOTELPLAN_CHECKIN"] = $data["HOTELPLAN_CHECKIN"];
		$dspArray[$planCnt]["HOTELPLAN_CHECKIN_LAST"] = $data["HOTELPLAN_CHECKIN_LAST"];
		$dspArray[$planCnt]["HOTELPLAN_CHECKOUT"] = $data["HOTELPLAN_CHECKOUT"];
		$dspArray[$planCnt]["HOTELPLAN_FEATURE"] = $data["HOTELPLAN_FEATURE"];
		$dspArray[$planCnt]["HOTELPLAN_FLG_DAYUSE"] = $data["HOTELPLAN_FLG_DAYUSE"];
		$dspArray[$planCnt]["HOTELPLAN_DISCOUNT"] = $data["HOTELPLAN_DISCOUNT"];
		$dspArray[$planCnt]["HOTELPLAN_CONTENTS"] = $data["HOTELPLAN_CONTENTS"];

		$dspArray[$planCnt]["HOTEL_LIST_AREA"] = $data["HOTEL_LIST_AREA"];

//		if ($dspArray[$planCnt]["money_all"] == "" or $dspArray[$planCnt]["money_all"] > $data["money_all"]) {
//			$dspArray[$planCnt]["money_1"] = $data["money_1"];
//			$dspArray[$planCnt]["money_all"] = $data["money_all"];
//		}

		$dspArray[$planCnt]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$planCnt]["ROOM_NAME"] = $data["ROOM_NAME"];
		$dspArray[$planCnt]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$planCnt]["ROOM_BREADTH"] = $data["ROOM_BREADTH"];
		$dspArray[$planCnt]["ROOM_FEATURE_LIST3"] = $data["ROOM_FEATURE_LIST3"];
		/*
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["money_1"] = $data["money_1"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_NAME"] = $data["ROOM_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_TYPE"] = $data["ROOM_TYPE"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_CAPACITY_TO"] = $data["ROOM_CAPACITY_TO"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_BREADTH"] = $data["ROOM_BREADTH"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_FEATURE_LIST3"] = $data["ROOM_FEATURE_LIST3"];
		*/
		
		//各部屋の料金書き出す
		for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
			$search_collection = new collection($db);
			$search_collection->setByKey($search_collection->getKeyValue(), "HOTELPLAN_ID", $data["HOTELPLAN_ID"]);
			$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $data["ROOM_ID"]);
			$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$search_collection->setByKey($search_collection->getKeyValue(), "adult_number", $collection->getByKey($collection->getKeyValue(), "adult_number".$i));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number1", $collection->getByKey($collection->getKeyValue(), "child_number".$i."1"));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number2", $collection->getByKey($collection->getKeyValue(), "child_number".$i."2"));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number3", $collection->getByKey($collection->getKeyValue(), "child_number".$i."3"));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number4", $collection->getByKey($collection->getKeyValue(), "child_number".$i."4"));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number5", $collection->getByKey($collection->getKeyValue(), "child_number".$i."5"));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number6", $collection->getByKey($collection->getKeyValue(), "child_number".$i."6"));
			if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
				//	指定なし
				$room[$i] = $hotel->selectMoneyEveryRoomUndecideSch($search_collection);	
			}
			else {
				//	指定日
				$room[$i] = $hotel->selectMoneyEveryRoom($search_collection);	
			}
			
//			print_r($room[$i]);
		}
		
		/*
		//料金表示ロジック
		*/

		$money_total = "";
		$money_total_perroom = 0;
		for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
			$money_total[$i] = $room[$i]["money_ALL"];
		}
		asort($money_total);
		$keys = array_keys($money_total);
		$money_total_cid = $keys[0];
		
		if ($dspArray[$planCnt]["money_all"] == "" or $dspArray[$planCnt]["money_all"] > $data["money_all"]) {
			$dspArray[$planCnt]["money_all"] = $money_total[$money_total_cid];
		}
		$dspArray[$planCnt]["point"] = $room[$money_total_cid]["point"];
	}
}

// print_r($dspArray);

// ordertype料金安順と料金高順
function array_sort($arr,$keys,$type='asc'){ 
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array; 
}

if($collection->getByKey($collection->getKeyValue(), "orderdata") == "1"){
	$dspArray = array_sort($dspArray,'money_all');
}
if($collection->getByKey($collection->getKeyValue(), "orderdata") == "2"){
	$dspArray = array_sort($dspArray,'money_all','dsc');
}



$inputs = new inputs();

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotel->setErrorFirst("エリアデータの読み込みに失敗しました");
}



$page_post = array();
if ($_POST) {
	foreach ($collection->getCollectionByKey("") as $k=>$v) {
		if ($k == "research") {
			continue;
		}
		$page_post[$k] = $v;
	}
}
else {
	foreach ($collection->getCollectionByKey("") as $k=>$v) {
		$page_post[$k] = $v;
	}
}
//	ページャ取得
$pager_options = array(
		'mode'       => 'Jumping', // 表示タイプ(Jumping/Sliding)
		'perPage'    => $perpage,        // 一ページ内で表示する件数
		'totalItems' => $hotel->getMaxCount(),   // ページング対象データの総数
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '<span class="prev">前へ</span>',
		'nextImg'=> '<span class="next">次へ</span>',
		'extraVars'  =>$page_post
);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta.php"); ?>
<title>レジャープラン検索 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="レジャー,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="レジャー、プラン検索のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>

<script type="text/javascript">
$(document).ready( function() {
	<?php
	if ($collection->getByKey($collection->getKeyValue(), "research")) {
	?>
	$('#searchtable').hide();
	<?php
	}
	else {
	?>
	$('#searchafterList').hide();
	<?php
	}
	?>

	$(".close_bt a").click(function(){
		$('#searchafterList').slideToggle(800);
		$('#searchtable').slideToggle();
	});
});

</script>

</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail" class="search">

    <ul id="panlist">
        <li><a href="index.html">TOP</a></li>
        <li><span>検索結果</span></li>
    </ul>

    <!--searchbox-->
    <?php require("includes/box/hotel/searchbox.php");?>
    
	<?php $formnamePlan = "frmFacSearch";?>
	<form action="facility-search.html" method="post" id="<?php print $formnamePlan?>" name="<?php print $formnamePlan?>">
	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
	<?php print $inputs->hidden("area", $collection->getByKey($collection->getKeyValue(), "area"))?>
	<?php print $inputs->hidden("kind", $collection->getByKey($collection->getKeyValue(), "kind"))?>
	<?php print $inputs->hidden("room_type", $collection->getByKey($collection->getKeyValue(), "room_type"))?>
	<?php print $inputs->hidden("meal2", $collection->getByKey($collection->getKeyValue(), "meal2"))?>
	<?php print $inputs->hidden("meal3", $collection->getByKey($collection->getKeyValue(), "meal3"))?>
	<?php print $inputs->hidden("meal4", $collection->getByKey($collection->getKeyValue(), "meal4"))?>
	<?php print $inputs->hidden("budget_from", $collection->getByKey($collection->getKeyValue(), "budget_from"))?>
	<?php print $inputs->hidden("budget_to", $collection->getByKey($collection->getKeyValue(), "budget_to"))?>
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


    <!--searchresult-->
    <ul class="tab">
    	<!--<li class="tab1"><a href="javascript:void(0)" onclick="document.<?php print $formnamePlan?>.submit();">施設で探す</a></li>-->
        <li class="tab2 currenttab"><a>プランで探す</a></li>
        <!--<li class="tab3"><a href="javascript:void(0)" onclick="document.<?php print $formnameMap?>.submit();">地図で探す</a></li>-->
    </ul>
    <section class="mainbox resultbox form">
    	<?php $scope = $pager->getOffsetByPageId()?>
    	<div class="result">検索結果：<b><?php print $hotel->getMaxCount()?>件</b>のホテル情報のうち <b><?php print $scope['0']?></b>件～<b><?php print $scope['1']?></b>件を表示</div>
        <p class="caution">※表示の料金は合計金額（税・サービス料込）です。</p>

      <?/*  <div class="order">
        	並び替え
            <div class="selectbox">
                <div class="select-inner select4"><span></span></div>
                <select class="select4" name="orderdata">
                    <option value="" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="")?'selected="selected"':''?>>人気順</option>
                    <option value="1" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="1")?'selected="selected"':''?>>料金が安い順</option>
                    <option value="2" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="2")?'selected="selected"':''?>>料金が高い順</option>
                </select>
            </div>*/?>
		<script type="text/javascript">
		    function ordertype_submit(ordertype){
		    	$("input[name='orderdata']").val(ordertype);
		    	document.frmResearch.submit();
			}
		</script>
		<div class="order">
			<dl>
				<dt>並び替え<dt>
				<input type="hidden" name="orderdata" value="" />
				<!--<dd><a href="javascript: ordertype_submit(0);">人気順</a><dd>-->
				<dd><a href="javascript: ordertype_submit(1);">料金が安い順</a><dd>
				<dd><a href="javascript: ordertype_submit(2);">料金が高い順</a><dd>
			</dl>
		</div>
		

        
        <?php if ($navi["back"] != "" or $navi["next"] != "") {?>
        <ul class="navigation-se">
        	<?php if ($navi["back"] != "") {?>
            <li class="prev"><?=$navi["back"]?> | </li>
            <?php }?>
            <?=$navi["pages"]?>
            <!--<li class="current">1 | </li>
            <li><a href="#">2</a> | </li>
            <li><a href="#">3</a> | </li>
            <li><a href="#">4</a> | </li>
            <li><a href="#">5</a> | </li>
            <li><a href="#">6</a> | </li>
            <li><a href="#">7</a> | </li>
            <li><a href="#">8</a> | </li>
            <li><a href="#">9</a> | </li>
            <li><a href="#">10</a> | </li>-->
            <?php if ($navi["next"] != "") {?>
            <li class="next"><?=$navi["next"]?></li>
            <?php }?>
        </ul>
		<?php }?>
		
		

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
        <!--item-->
	<?php if ($plandata["HOTELPLAN_FLG_DAYUSE"] == 2) {?>
		<article>
        	<div class="inner">
    	    	<div class="innerhed cf">
    	    		<span class="option01"></span>
	        		<h3>
	        		<?php $formname = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["HOTELPLAN_ID"]."_".$plandata["ROOM_ID"];?>
		        	<form action="search-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><?php print $plandata["HOTEL_NAME"]?></a>
	            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	            	<?php print $inputs->hidden("HOTELPLAN_ID", $plandata["HOTELPLAN_ID"])?>
	            	<?php print $inputs->hidden("ROOM_ID", $plandata["ROOM_ID"])?>
	            	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
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
	        		</h3>
	        		<ul class="type-h">
	        			<li class="type">施設タイプ</li>
	        			<?php
	        			$arArea = array();
	        			$arTemp = explode(":", $plandata["HOTEL_LIST_AREA"]);
	        			if (count($arTemp) > 0) {
	        				foreach ($arTemp as $data) {
	        					if ($data != "") {
	        						$arArea[$data] = $data;
	        					}
	        				}
	        			}
	        			?>
	        			<?php
	        			if (count($arArea) > 0) {
	        				foreach ($arArea as $d) {
	        			?>
	        			<li class="place"><?php print $xmlArea->getNameByValue($d)?></li>
	        			<?php
	        				}
	        			}
	        			?>
	        		</ul>
        		</div>
        		<div class="hotel-subinfo cf">
        			<?php if ($plandata["HOTELPLAN_PIC"] != "") {?>
        			<a href="#"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $plandata["HOTELPLAN_PIC"]?>" width="248" height="138" class="fl-l" alt="<?php print $plandata["HOTELPLAN_NAME"]?>"></a>
        			<?php }else{?>
        			<a href="#"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="248" height="138" class="fl-l" alt="<?php print $plandata["HOTELPLAN_NAME"]?>"></a>
        			<?php }?>
      				<h4 class="hotel-copy">
      				<?php $formname = "frm".$plandata["COMPANY_ID"]."_".$plandata["HOTELPLAN_ID"]."_".$plandata["ROOM_ID"];?>
		        	<form action="plan-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
						<?php /*<span class="new">NEW</span>*/?><a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><?php print $plandata["HOTELPLAN_NAME"]?></a>
		            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
		            	<?php print $inputs->hidden("HOTELPLAN_ID", $plandata["HOTELPLAN_ID"])?>
		            	<?php print $inputs->hidden("ROOM_ID", $plandata["ROOM_ID"])?>
		            	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
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
		        	</form></h4>
                		<!--<ul class="icon">
                    		<li><img src="./images/common/icon-nomeal.jpg"</li>
                    		<li><img src="./images/common/icon-Limit.jpg"</li>
                    	</ul>-->
                    	<?php if ($plandata["HOTELPLAN_BF_FLG"] == 2) {?>
			        <span class="icon radius5">朝食</span>
			        <?php }?>
			
			        <?php if ($plandata["HOTELPLAN_DN_FLG"] == 2) {?>
			        <span class="icon radius5">夕食</span>
			        <?php }?>
			
			        <?php if ($plandata["HOTELPLAN_LN_FLG"] == 2) {?>
			        <span class="icon radius5">昼食</span>
			        <?php }?>
                    <?php if($plandata["HOTELPLAN_BF_FLG"]<>2 &&$plandata["HOTELPLAN_DN_FLG"]<>2 &&$plandata["HOTELPLAN_LN_FLG"]<>2){?>
                    <img src="./images/common/icon-nomeal.jpg">
                    <?php }?>
      				<div class="checkin">出発時間：<?php print date('H:s', strtotime($plandata["HOTELPLAN_CHECKIN"]));?>～<?php print date('H:s', strtotime($plandata["HOTELPLAN_CHECKIN_LAST"]));?><!-- / チェックアウト～<?php print date('H:s', strtotime($plandata["HOTELPLAN_CHECKOUT"]));?>--></div>
        			<div class="hotel-text ss-text">
        				<h5>特典</h5>
        				<p><?php print redirectForReturn($plandata["HOTELPLAN_CONTENTS"])?></p>
                    　<!--<dl class="plan-sub-option">
                    	<dt>
                    	<img src="./images/common/icon-roomtype.png" width="46" height="18" alt="洋室ダブル" /><?php print $plandata["ROOM_NAME"]?></dt>
                    	<dd>
                    	<?php if ($plandata["ROOM_BREADTH"] != "") {?>
                    	<span>広さ：<?php print $plandata["ROOM_BREADTH"]?>㎡</span>
                    	<?php }?>
                    	<?php
                    	$dataFeature3 = cmHotelRoomFeature3();
                    	$arFearture3 = array();
                    	$arTemp = explode(":", $plandata["ROOM_FEATURE_LIST3"]);
                    	$cc = 0;
                    	if (count($arTemp) > 0) {
                    		foreach ($arTemp as $dd) {
                    			if ($dd != "") {
                    				$cc++;
                    				$arFearture3[$dd] = $dd;
                    			}
                    		}
                    	}
                    	if (count($arFearture3) > 0) {
                    		foreach ($arFearture3 as $d) {
                    	?>
                    	<span><?php print $dataFeature3[$d]?></span>
                    	<?php
                    		}
                    	}
                    	?>
                    	<!--<span>定員2名?4名</span><span>禁煙ルーム</span<span>バス・トイレ別</span>--></dd>
                    </dl>-->
        			</div>

                		<div class="off_bo">
                			<?php if ($plandata["HOTELPLAN_DISCOUNT"] != "") {?>
                			<div class="offtxt radius10"><b><?php print $plandata["HOTELPLAN_DISCOUNT"]?>%</b>OFF</div>
                			<?php }?>
                			<div class="off-inner  radius10">
                				<b>最安料金</b><br />
	                    		<strong>1室合計￥<?php print number_format($plandata["money_all"])?>～</strong><br />
                        		<p class="point">ポイント<?php print $plandata["point"]?>%
                        		<!--（￥○、○○○～/人）--></p>
                    		</div>
                    	</div>

        		</div>

      			<div class="s-txt-dates">販売期間：<?php $fromDate = cmDateDivide($plandata["HOTELPLAN_DATE_SALE_FROM"])?>
      			<?php $toDate = cmDateDivide($plandata["HOTELPLAN_DATE_SALE_TO"])?>
      			<?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?>?<?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?></div>
        	</div>
		</article>
	        <?php }?>
                <!--/item-->
	        <?php }?>
        <?php }?>


		<?php if ($navi["back"] != "" or $navi["next"] != "") {?>
        <ul class="navigation-se">
        	<?php if ($navi["back"] != "") {?>
            <li class="prev"><?=$navi["back"]?> | </li>
            <?php }?>
            <?=$navi["pages"]?>
            <!--<li class="current">1 | </li>
            <li><a href="#">2</a> | </li>
            <li><a href="#">3</a> | </li>
            <li><a href="#">4</a> | </li>
            <li><a href="#">5</a> | </li>
            <li><a href="#">6</a> | </li>
            <li><a href="#">7</a> | </li>
            <li><a href="#">8</a> | </li>
            <li><a href="#">9</a> | </li>
            <li><a href="#">10</a> | </li>-->
            <?php if ($navi["next"] != "") {?>
            <li class="next"><?=$navi["next"]?></li>
            <?php }?>
        </ul>
		<?php }?>
		<br/><br/><br/>

    </section>

    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->

    <!--side-->
    <?php require("includes/box/common/right.php");?>
    <!--/side-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
