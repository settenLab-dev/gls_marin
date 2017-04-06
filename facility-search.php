<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
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
$collection->setByKey($collection->getKeyValue(), "limitptn", "company");

//	検索するホテル
$targetId = "";
$tl_targetId = "";
$hotelCompany = new hotel($dbMaster);
$hotelCompany->selectListCompanyCount($collection);

$company = new company($dbMaster);

$hotel = new hotel($dbMaster);

if ($hotelCompany->getCount() > 0) {
	foreach ($hotelCompany->getCollection() as $cc) {
		if ($targetId != "") {
			$targetId .= ",";
		}
		$targetId .= $cc["COMPANY_ID"];
		if ($targetId_link != "") {
			$targetId_link .= ",";
		}
		$targetId_link .= "'".$cc["COMPANY_LINK"]."'";
	}
	$collection->setByKey($collection->getKeyValue(), "targetId", $targetId);
	$collection->setByKey($collection->getKeyValue(), "targetId_link", $targetId_link);

//print_r($hotelCompany->getCollection());
	$hotel->selectListPublicHotel($collection);
}
// $hotel_plan = new hotel($dbMaster);
// $hotel_plan->selectListPublicPlan($collection);
//print_r($hotel);exit;
// print_r($hotelCompany->getCollection());

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotel->setErrorFirst("エリアデータの読み込みに失敗しました");
}
$companyCnt = 0;
$planCnt = 0;
$dspArray = array();
if ($hotel->getCount() > 0) {
	foreach ($hotel->getCollection() as $data) {
		if ($companyCnt < $data["datacnt"]) {
			$companyCnt = $data["datacnt"];
		}
		//print_r($data);
		$dspArray[$data["COMPANY_ID"]]["datacnt"] = $data["datacnt"];
		$dspArray[$data["COMPANY_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["COMPANY_ID"]]["COMPANY_LINK"] = $data["COMPANY_LINK"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_CATCHCOPY"] = $data["HOTEL_CATCHCOPY"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_DETAIL"] = $data["HOTEL_DETAIL"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_PIC_APP"] = $data["HOTEL_PIC_APP"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_LIST_AREA"] = $data["HOTEL_LIST_AREA"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_ZIP"] = $data["HOTEL_ZIP"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_CITY"] = $data["HOTEL_CITY"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_ADDRESS"] = $data["HOTEL_ADDRESS"];
		$dspArray[$data["COMPANY_ID"]]["HOTEL_PREF"] = $xmlArea->getNameByValue($data["HOTEL_PREF"]);
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["HOTELPLAN_NAME"] = $data["HOTELPLAN_NAME"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["ROOM_NAME"] = $data["ROOM_NAME"];
		//$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["money_1"] = $data["money_1"];
		//$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["HOTELPLAN_BF_FLG"] = $data["HOTELPLAN_BF_FLG"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["HOTELPLAN_DN_FLG"] = $data["HOTELPLAN_DN_FLG"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["HOTELPLAN_LN_FLG"] = $data["HOTELPLAN_LN_FLG"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["ROOM_TYPE"] = $data["ROOM_TYPE"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["HOTELPLAN_DISCOUNT"] = $data["HOTELPLAN_DISCOUNT"];
		
		//各部屋の料金書き出す
		for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
			$search_collection = new collection($db);
			$search_collection->setByKey($search_collection->getKeyValue(), "HOTELPLAN_ID", $data["HOTELPLAN_ID"]);
			$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $data["ROOM_ID"]);
			$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$search_collection->setByKey($search_collection->getKeyValue(), "adult_number", $collection->getByKey($collection->getKeyValue(), "adult_number".$i));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number2", $collection->getByKey($collection->getKeyValue(), "child_number".$i."1"));
			$search_collection->setByKey($search_collection->getKeyValue(), "child_number1", $collection->getByKey($collection->getKeyValue(), "child_number".$i."2"));
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
				if(trim($data["COMPANY_LINK"]) != ""){
					$room[$i] = $hotel->selectMoneyEveryRoomLink($search_collection);	
					//print_r($room[$i]);
				}
				else{
					$room[$i] = $hotel->selectMoneyEveryRoom($search_collection);	
				}
			}
			
//			print_r($room[$i]);
		}
		
		/*
		//料金表示ロジック
		*/
//		print_r($collection);
		$diff_flg = 0;
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
//		print($diff_flg);
		$money_total = "";
		$money_total_perroom = 0;
		for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
			$money_total[$i] = $room[$i]["money_ALL"];
			$money_total_perroom += $room[$i]["money_ALL"];
		}
		asort($money_total);
//		
		$keys = array_keys($money_total);
		$money_total_cid = $keys[0];
		

		$dspArray[$data["COMPANY_ID"]]["diff_flg"] = $diff_flg;
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["diff_flg"] = $diff_flg;
		//複数部屋検索　部屋人数が違うとき
		//大人1名　　　合計
		//-　　　　   ￥一番安い部屋の合計料金～　（○名1室は表示しない）
		//複数部屋検索　部屋人数が同じ時
		//大人1名　　　    合計
		//○名1室：￥○○○～　￥○○○～（1部屋分の料金）
//		var_dump($money_total);
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["money_all"] = $money_total_perroom;
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["money_1"] = $room[$money_total_cid]["money_perperson"];
		$dspArray[$data["COMPANY_ID"]]["plan"][$data["HOTELPLAN_ID"]][$data["ROOM_ID"]]["point"] = ($room[$money_total_cid]["point"]>0)?$room[$money_total_cid]["point"]:"1";

		if ($dspArray[$data["COMPANY_ID"]]["money_all"] == "" or $dspArray[$data["COMPANY_ID"]]["money_all"] > $money_total[$money_total_cid]) {
			$dspArray[$data["COMPANY_ID"]]["money_1"] = $room[$money_total_cid]["money_perperson"];
			$dspArray[$data["COMPANY_ID"]]["money_all"] = $money_total[$money_total_cid];
		}

		$planCnt++;
	}
}

// print_r($dspArray);exit;

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
		'totalItems' => $hotelCompany->getMaxCount(),   // ページング対象データの総数
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '前へ',
		'nextImg'=> '次へ',
		'separator'=>'|',
		'extraVars' => $page_post
);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();

?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>

<title>施設検索 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="ホテル,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="ホテル、施設検索のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="//cocotomo.net/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//cocotomo.net/js/jquery-ui-1.10.3.custom.min.js"></script>

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
    <main id="detail_n" class="search">

    <ul id="panlist">
        <li><a href="n_hotel.html">TOP</a></li>
        <li><span>施設検索結果</span></li>
    </ul>

    <!--searchbox-->
	<?php require("includes/box/hotel/searchbox2.php");?>
    
    	<?php $formnamePlan = "frmPlanSearch";?>
    	<form action="plan-search.html" method="post" id="<?php print $formnamePlan?>" name="<?php print $formnamePlan?>">
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
    	<li class="tab1 currenttab"><a>施設で探す</a></li>
        <li class="tab2"><a href="javascript:void(0)" onclick="document.<?php print $formnamePlan?>.submit();">プランで探す</a></li>
        <!--<li class="tab3"><a href="javascript:void(0)" onclick="document.<?php print $formnameMap?>.submit();">地図で探す</a></li>-->
    </ul>
    <section class="mainbox resultbox form">
	<div class="result_sort">
    	<?php $scope = $pager->getOffsetByPageId()?>
    	<div class="result">検索結果：<b><?php print $hotelCompany->getMaxCount()?>件</b>のホテル情報のうち <b><?php print $scope['0']?></b>件～<b><?php print $scope['1']?></b>件を表示</div>
        <p class="caution">※表示の料金は1部屋・1泊あたりの合計金額（税・サービス料込）です。<br>
        2室以上のお部屋をご利用の場合、最安料金は1室あたりの料金が表示されます。</p>
       


        <?php /*        <div class="order">
        	並び替え
            <div class="selectbox">
                <div class="select-inner select4"><span></span></div>
                <select class="select4" name="orderdata">
                    <option value="" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="")?'selected="selected"':''?>>人気順</option>
                    <option value="1" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="1")?'selected="selected"':''?>>料金が安い順</option>
                    <option value="2" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="2")?'selected="selected"':''?>>料金が高い順</option>
                </select>
            </div>
            <script type="text/javascript">
	                            $(document).ready(function(){
	                            	$("select[name='orderdata']").change(function () {
	                            		$("input[name='orderdata']").val($(this).val());
	                            		document.frmResearch.submit();
	                            	});
                            	});
            </script>

        </div>        */?>
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
				<dd><a href="javascript: ordertype_submit(0);">人気順</a><dd>
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
		
	</div>


        <?php
        if (count($dspArray) > 0) {
			foreach ($dspArray as $dd) {
//			print_r($dd);
		?>
        <!--item-->

        <article>
        	<div class="inner">
        		<?php
        		$arArea = array();
        		$arTemp = explode(":", $dd["HOTEL_LIST_AREA"]);
        		if (count($arTemp) > 0) {
        			foreach ($arTemp as $data) {
        				if ($data != "") {
        					$arArea[$data] = $data;
        				}
        			}
        		}
        		?>
        		<div class="innerhed cf">
        			<h2><?php print $dd["HOTEL_CATCHCOPY"]?></h2>
        			<ul class="type-h">
        				<!--<li class="type">施設タイプ</li>-->
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
		<div class="inner-plan">
			<div class="hotel-subinfo cf">
				<?php $formnames = "frmSearch".$dd["COMPANY_ID"]."_".$vv["HOTELPLAN_ID"]."_".$vv["ROOM_ID"];?>
				<form action="search-detail.html" method="post" id="<?php print $formnames?>" name="<?php print $formnames?>">
			<?php //print_r($dd);?>
				<?php if ($dd["HOTEL_PIC_APP"] != "") {?>
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $dd["HOTEL_PIC_APP"]?>" width="248" height="165" class="fl-l"  alt="<?php print $dd["HOTEL_NAME"]?>"></a>
				<?php }else{?>
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="248" height="165" class="fl-l" alt="<?php print $dd["HOTEL_NAME"]?>"></a>
				<?php }?>
				<h3 class="hotel-name">
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();"><?php print $dd["HOTEL_NAME"]?></a>
					<?php print $inputs->hidden("COMPANY_ID", $dd["COMPANY_ID"])?>
					<?php print $inputs->hidden("COMPANY_LINK", $dd["COMPANY_LINK"])?>
					<?php print $inputs->hidden("HOTELPLAN_ID", $vv["HOTELPLAN_ID"])?>
					<?php print $inputs->hidden("ROOM_ID", $vv["ROOM_ID"])?>
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
				<div class="hotel-text">
					<p><?php print $dd["HOTEL_DETAIL"]?></p>
					<!--<ul class="facility-option">
						<li class="option01">高級</li><li class="option02">ビーチ</li><li class="option03">室内プール</li><li class="option04">屋外プール</li><li class="option05">大浴場</li><li class="option06">温泉</li><li class="option07">ペット可</li>
					</ul>-->
				</div>
	
	    		<div class="pricemax radius10">
	    			<?php if ($vv["HOTELPLAN_DISCOUNT"] != "") {?>
	    			<div class="sq_offproce radius10">
	    				<b><?php print $vv["HOTELPLAN_DISCOUNT"]?></b>
	    			</div>
	    				<?php }?>
	    			<b>最安料金</b>
	    			1室合計<strong>￥<?php print number_format($dd["money_all"])?>～</strong>
	    			<?php 
	    			if($dd["diff_flg"]){ ?>
	    			<span>（大人 ー）</span>
	    			<?php }else{ ?>
	    			<span>（大人 ￥<?php print number_format($dd["money_1"])?>～/人）</span>
	    			<?php } ?>
	    		</div>
			</div>
			<div><span>〒<?php print $dd["HOTEL_ZIP"]?>　<?php print $dd["HOTEL_PREF"]?><?php print $dd["HOTEL_CITY"]?><?php print $dd["HOTEL_ADDRESS"]?></span></div>
  
                <section class="list">
                	<h3>▼宿泊プラン</h3>
                    <ul class="item">
                    	<li>大人1名</li>
                        <li><B>合計</B></li>
                    </ul>

                    <?php
                    
                    if (count($dd["plan"]) > 0) {
                    	$cnt = 0;
                    	foreach ($dd["plan"] as $k=>$v) {
	                    	if (count($v) > 0) {
	                    		foreach ($v as $kk=>$vv) {
		                    		$cnt++;
		                    		if ($cnt>3) {
		                    			continue;
		                    		}
						?>
                    <dl class="planList">
                    	<dt>
                    		<?php $formname = "frm".$dd["COMPANY_ID"]."_".$vv["HOTELPLAN_ID"]."_".$vv["ROOM_ID"];?>
                        	<form action="plan-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
                    		<div><a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><?php print $vv["HOTELPLAN_NAME"]?></a></div>
                    	</dt>
                    	<dd style="width: 150px;">
                    		<?php
                			$meal = "";
                			if ($vv["HOTELPLAN_BF_FLG"] == 2) {
								$meal .= "朝";
							}
                			if ($vv["HOTELPLAN_LN_FLG"] == 2) {
								$meal .= "昼";
							}
                			if ($vv["HOTELPLAN_DN_FLG"] == 2) {
								$meal .= "夕";
							}
							if ($meal != "") {
								$meal .= "食あり";
							}
							if ($meal == "") {
								$meal .= "食事なし";
							}
                			?>
                			<?php if ($meal != "") {?>
                    		<span class="meal"><?php print $meal?></span>
                			<?php }?>
                			<?php
                    		$ar = cmHotelRoomType();
                    		$heya = "";
                    		if ($ar[$vv["ROOM_TYPE"]] != "") {
								$heya = $ar[$vv["ROOM_TYPE"]];
							}
                    		?>
                    		<?php if ($heya != "") {?>
                    		<span class="radius10 room"><?php print $heya?></span>
                    		<?php }?>
                    	</dd>
                    	<dd class="no" style="width:50px;">
	                    	<?php if ($dd["diff_flg"]) {?>
				
	                    	<?php }else{ print $collection->getByKey($collection->getKeyValue(), "adult_number1")?>
	                    	 名1室
	                    	<?php }?>
                    	</dd>
                    	<dd class="sp-r" style="width: 80px;">
                    		<?php if ($dd["diff_flg"]) {?>
                    		－
	                    	<?php }else{?>
	                    	￥<?php print number_format($vv["money_1"])?>～
	                    	<?php }?>
                    	</dd>
                    	<dd class="sp-r" style="width: 100px; font-weight: bold; font-size:15px;">
                    		￥<?php print number_format($vv["money_all"])?>～
                    		<p class="pt">ポイント<?php print $vv["point"]?>%</p>
                    	</dd>
                    	<dd>
	                        	<a href="javascript:void(0)" class="bt_plan2" onclick="document.<?php print $formname?>.submit();">プラン詳細</a>
	                        	<?php print $inputs->hidden("COMPANY_ID", $dd["COMPANY_ID"])?>
	                        	<?php print $inputs->hidden("COMPANY_LINK", $dd["COMPANY_LINK"])?>
	                        	<?php print $inputs->hidden("HOTELPLAN_ID", $vv["HOTELPLAN_ID"])?>
	                        	<?php print $inputs->hidden("ROOM_ID", $vv["ROOM_ID"])?>
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
                    	</dd>
                    </dl>
                    			<?php }?>
		                    <?php }?>
	                    <?php }?>
	                    	                    <?php if ($cnt>3):?><a style="float:right;" href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();">=>このほかのプランはこちら</a><?php  endif;?>
                    <?php }?>
                    <div class="otherPlan">
                    	<?php /*
                    	<a href="#">このほかのプランを見る</a><span>（○○件）</span>
                    	*/?>
                    </div>
                </section>
		</div>
            </div>
        </article>
        <?php
			}
		}
		?>
        <!--/item-->

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


</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
