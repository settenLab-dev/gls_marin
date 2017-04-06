<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
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

print_r($collection);

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

$shop = new shop($dbMaster);
$shop->selectListPublicPlan($collection);

// print_r($shop);


//設定
//$collection->setByKey($collection->getKeyValue(), "priceper_num", 3);



$companyCnt = 0;
$planCnt = 0;
$dspArray = array();
if ($shop->getCount() > 0) {
	foreach ($shop->getCollection() as $data) {
//print_r($dspArray);
		$planCnt++;
		$dspArray[$planCnt]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$planCnt]["SHOP_ID"] = $data["SHOP_ID"];
		$dspArray[$planCnt]["SHOP_NAME"] = $data["SHOP_NAME"];
		$dspArray[$planCnt]["SHOPPLAN_ID"] = $data["SHOPPLAN_ID"];
		$dspArray[$planCnt]["SHOPPLAN_NAME"] = $data["SHOPPLAN_NAME"];
		$dspArray[$planCnt]["SHOPPLAN_PIC1"] = $data["SHOPPLAN_PIC1"];
		$dspArray[$planCnt]["SHOPPLAN_SALE_FROM"] = $data["SHOPPLAN_SALE_FROM"];
		$dspArray[$planCnt]["SHOPPLAN_SALE_TO"] = $data["SHOPPLAN_SALE_TO"];

		$dspArray[$planCnt]["SHOPPLAN_DISCRIPTION"] = $data["SHOPPLAN_DISCRIPTION"];

		$dspArray[$planCnt]["SHOP_LIST_AREA"] = $data["SHOP_LIST_AREA"];
		$dspArray[$planCnt]["SHOPPLAN_AREA_LIST1"] = $data["SHOPPLAN_AREA_LIST1"];
		$dspArray[$planCnt]["SHOPPLAN_AREA_LIST2"] = $data["SHOPPLAN_AREA_LIST2"];
		$dspArray[$planCnt]["SHOPPLAN_AREA_LIST3"] = $data["SHOPPLAN_AREA_LIST3"];

		$dspArray[$planCnt]["SHOPPLAN_CATEGORY_LIST1"] = $data["SHOPPLAN_CATEGORY_LIST1"];
		$dspArray[$planCnt]["SHOPPLAN_CATEGORY_LIST2"] = $data["SHOPPLAN_CATEGORY_LIST2"];
		$dspArray[$planCnt]["SHOPPLAN_CATEGORY_LIST3"] = $data["SHOPPLAN_CATEGORY_LIST3"];

		$dspArray[$planCnt]["SHOPPLAN_TAG_LIST"] = $data["SHOPPLAN_TAG_LIST"];


		$count_spi = "";
		for ($i=1; $i<=12; $i++){
			if($data["SHOPPLAN_MEET_TIMEHOUR".$i] > "0"){
			$dspArray[$planCnt]["SHOPPLAN_MEET_TIMEHOUR".$i] = $data["SHOPPLAN_MEET_TIMEHOUR".$i];
				$count_spi = $i;
			}
		}
//print $count_spi;

		for ($i=1; $i<=$count_spi; $i++){
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE".$i] = $data["SHOP_PRICETYPE_ID".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_KIND".$i] = $data["SHOP_PRICETYPE_KIND".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND1".$i] = $data["SHOP_PRICETYPE_MONEYKIND1".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND2".$i] = $data["SHOP_PRICETYPE_MONEYKIND2".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND3".$i] = $data["SHOP_PRICETYPE_MONEYKIND3".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND4".$i] = $data["SHOP_PRICETYPE_MONEYKIND4".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND5".$i] = $data["SHOP_PRICETYPE_MONEYKIND5".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND6".$i] = $data["SHOP_PRICETYPE_MONEYKIND6".$i];
			$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND7".$i] = $data["SHOP_PRICETYPE_MONEYKIND7".$i];
		//	$dspArray[$planCnt]["SHOPPLAN_PRICETYPE_MONEYKIND8".$i] = $data["SHOP_PRICETYPE_MONEYKIND8".$i];
			$dspArray[$planCnt]["SHOPPLAN_ROOM".$i] = $data["ROOM_ID".$i];
		}
	//	$dspArray[$planCnt]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];



			//	$collection->setByKey($collection->getKeyValue(), "undecide_sch", 1);		
		//各部屋の料金書き出す
		for ($i=1; $i<=$count_spi; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $data["SHOPPLAN_ID"]);
//				$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $data["ROOM_ID".$i]);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOP_PRICETYPE_ID", $data["SHOP_PRICETYPE_ID".$i]);
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
				//日付指定なし
				$search_collection->setByKey($search_collection->getKeyValue(), "undecide_sch", 1);
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

					if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
						//	指定なし

						$room_sch = $shop->selectMoneyEveryRoomUndecideSch($search_collection);	

						// 設定されている料金帯の数をカウント
						if($room_sch != ""){
							$room[$i] = $room_sch;	
						}
					}
					else {
						$room_sch = $shop->selectMoneyEveryRoom($search_collection);	
						if($room_sch != ""){
							$room[$i] = $room_sch;	
						}
					}



		}
					//print_r($room);
		/*
		//料金表示ロジック
		*/

		$money_total = "";
		$money_total_perroom = 0;
		for ($i=1; $i<=12; $i++){
			if($room[$i]["money_ALL"] !=""){
				$money_total[$i] = $room[$i]["money_ALL"];
			}
		}

// print_r($money_total);


//		$money_total_min = min($money_total);

//		$dspArray[$planCnt]["money_all"] = $money_total_min;

		asort($money_total);
// print_r($money_total);

		$keys = array_keys($money_total);
		$money_total_cid = $keys[0];
		
		if ($dspArray[$planCnt]["money_all"] == "" or $dspArray[$planCnt]["money_all"] > $data["money_all"]) {
			$dspArray[$planCnt]["money_all"] = $money_total[$money_total_cid];
		}
	//	$dspArray[$planCnt]["point"] = $room[$money_total_cid]["point"];

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

//print "★";

$inputs = new inputs();

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$shop->setErrorFirst("エリアデータの読み込みに失敗しました");
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
		'totalItems' => $shop->getMaxCount(),   // ページング対象データの総数
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
<?php require("includes/box/common/meta201505.php"); ?>
<title>プラン検索 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="//playbooking.jp/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//playbooking.jp/js/jquery-ui-1.10.3.custom.min.js"></script>

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
        <li><span>プラン検索結果</span></li>
    </ul>

<div class="l-content-inner clearfix">



    <div class="l-main-area_r l-main-area_r_search">

    <div class="big-banner">
    <a href="http://www.jtb.co.jp/kokunai_htl/?RegistFrom=asoviewj" class="big-banner_link_"><img class="big-banner__image" src="//d3e8ogs60q6bjk.cloudfront.net/image/production/houseAd/b92b6d8f-a7a2-4169-8821-99afd485628e.jpg" alt="jtb広告2"></a></div>
<div class="search-result-head">
      <h1 class="search-result-head__heading">検索結果</h1>
      </div>
    <div id="search-condition-editor"><form name="searchActionForm" id="searchForm" method="GET" action="/search/">
<div class="search-condition-editor-wrap">
  

<div class="search-condition-editor">
  <div class="search-condition-editor__options-wrap">
    <ul class="search-condition-editor__options">
      <li class="search-condition-editor__option"><button class="search-condition-editor__option-button" data-asv-target="show-editor-tip" data-asv-property="when" type="button">日付未定</button></li>
      <li class="search-condition-editor__option"><button class="search-condition-editor__option-button" data-asv-target="show-editor-tip" data-asv-property="where" type="button">エリア</button></li>
      <li class="search-condition-editor__option"><button class="search-condition-editor__option-button" data-asv-target="show-editor-tip" data-asv-property="what" type="button">ジャンル</button></li>
      <li class="search-condition-editor__option"><button class="search-condition-editor__option-button" data-asv-target="show-editor-tip" data-asv-property="who" type="button">人数</button></li>
      <li class="search-condition-editor__option"><button class="search-condition-editor__option-button" data-asv-target="show-editor-tip" data-asv-property="more" type="button">さらに詳しく</button></li>
    </ul>
    <button class="search-condition-editor__submit-button" type="submit" onclick="ga('send','event','search','search','search_search-condition-editor__btn-submit_PC');">この条件で検索</button>
  </div>
</div>

<div class="search-condition-editor-tip-wrap">

  <div class="search-condition-editor-tip search-condition-editor-tip--when" data-asv-target="editor-tip-when">
    <div class="search-condition-editor-tip__inner">
      <b class="search-condition-editor-tip__heading">日付</b>
      <div class="search-condition-editor-tip__input-wrap search-condition-editor-tip__input-wrap--date">
        <input type="text" name="ymd" value="" id="datepicker" class="search-condition-editor-tip__date-input">
        <div class="search-condition-editor-tip__date-picker" data-asv-target="datepicker"><div class="pika-single"><div class="pika-lendar"><div class="pika-title"><div class="pika-label">2016年<select class="pika-select pika-select-year"><option value="2016" selected="">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option></select></div><div class="pika-label">12月<select class="pika-select pika-select-month"><option value="0" disabled="">1月</option><option value="1" disabled="">2月</option><option value="2" disabled="">3月</option><option value="3" disabled="">4月</option><option value="4" disabled="">5月</option><option value="5" disabled="">6月</option><option value="6" disabled="">7月</option><option value="7" disabled="">8月</option><option value="8" disabled="">9月</option><option value="9" disabled="">10月</option><option value="10" disabled="">11月</option><option value="11" selected="">12月</option></select></div><button class="pika-prev is-disabled" type="button">&lt;前へ</button></div><table cellpadding="0" cellspacing="0" class="pika-table"><thead><tr><th scope="col"><abbr title="日曜日">日</abbr></th><th scope="col"><abbr title="月曜日">月</abbr></th><th scope="col"><abbr title="火曜日">火</abbr></th><th scope="col"><abbr title="水曜日">水</abbr></th><th scope="col"><abbr title="木曜日">木</abbr></th><th scope="col"><abbr title="金曜日">金</abbr></th><th scope="col"><abbr title="土曜日">土</abbr></th></tr></thead><tbody><tr><td class="is-empty"></td><td class="is-empty"></td><td class="is-empty"></td><td class="is-empty"></td><td data-day="1" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="1">1</button></td><td data-day="2" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="2">2</button></td><td data-day="3" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="3">3</button></td></tr><tr><td data-day="4" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="4">4</button></td><td data-day="5" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="5">5</button></td><td data-day="6" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="6">6</button></td><td data-day="7" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="7">7</button></td><td data-day="8" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="8">8</button></td><td data-day="9" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="9">9</button></td><td data-day="10" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="10">10</button></td></tr><tr><td data-day="11" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="11">11</button></td><td data-day="12" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="12">12</button></td><td data-day="13" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="13">13</button></td><td data-day="14" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="14">14</button></td><td data-day="15" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="15">15</button></td><td data-day="16" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="16">16</button></td><td data-day="17" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="17">17</button></td></tr><tr><td data-day="18" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="18">18</button></td><td data-day="19" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="19">19</button></td><td data-day="20" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="20">20</button></td><td data-day="21" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="21">21</button></td><td data-day="22" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="22">22</button></td><td data-day="23" class="is-disabled"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="23">23</button></td><td data-day="24" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="24">24</button></td></tr><tr><td data-day="25" class="is-disabled holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="25">25</button></td><td data-day="26" class="is-today"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="26">26</button></td><td data-day="27" class=""><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="27">27</button></td><td data-day="28" class=""><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="28">28</button></td><td data-day="29" class=""><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="29">29</button></td><td data-day="30" class=""><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="30">30</button></td><td data-day="31" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2016" data-pika-month="11" data-pika-day="31">31</button></td></tr></tbody></table></div><div class="pika-lendar"><div class="pika-title"><div class="pika-label">2017年<select class="pika-select pika-select-year"><option value="2016">2016</option><option value="2017" selected="">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option></select></div><div class="pika-label">1月<select class="pika-select pika-select-month"><option value="11" selected="">1月</option><option value="12">2月</option><option value="13">3月</option><option value="14">4月</option><option value="15">5月</option><option value="16">6月</option><option value="17">7月</option><option value="18">8月</option><option value="19">9月</option><option value="20">10月</option><option value="21">11月</option><option value="22">12月</option></select></div><button class="pika-next" type="button">次へ&gt;</button></div><table cellpadding="0" cellspacing="0" class="pika-table"><thead><tr><th scope="col"><abbr title="日曜日">日</abbr></th><th scope="col"><abbr title="月曜日">月</abbr></th><th scope="col"><abbr title="火曜日">火</abbr></th><th scope="col"><abbr title="水曜日">水</abbr></th><th scope="col"><abbr title="木曜日">木</abbr></th><th scope="col"><abbr title="金曜日">金</abbr></th><th scope="col"><abbr title="土曜日">土</abbr></th></tr></thead><tbody><tr><td data-day="1" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="1">1</button></td><td data-day="2" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="2">2</button></td><td data-day="3" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="3">3</button></td><td data-day="4" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="4">4</button></td><td data-day="5" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="5">5</button></td><td data-day="6" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="6">6</button></td><td data-day="7" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="7">7</button></td></tr><tr><td data-day="8" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="8">8</button></td><td data-day="9" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="9">9</button></td><td data-day="10" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="10">10</button></td><td data-day="11" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="11">11</button></td><td data-day="12" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="12">12</button></td><td data-day="13" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="13">13</button></td><td data-day="14" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="14">14</button></td></tr><tr><td data-day="15" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="15">15</button></td><td data-day="16" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="16">16</button></td><td data-day="17" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="17">17</button></td><td data-day="18" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="18">18</button></td><td data-day="19" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="19">19</button></td><td data-day="20" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="20">20</button></td><td data-day="21" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="21">21</button></td></tr><tr><td data-day="22" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="22">22</button></td><td data-day="23" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="23">23</button></td><td data-day="24" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="24">24</button></td><td data-day="25" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="25">25</button></td><td data-day="26" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="26">26</button></td><td data-day="27" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="27">27</button></td><td data-day="28" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="28">28</button></td></tr><tr><td data-day="29" class="holiday"><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="29">29</button></td><td data-day="30" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="30">30</button></td><td data-day="31" class=""><button class="pika-button pika-day" type="button" data-pika-year="2017" data-pika-month="0" data-pika-day="31">31</button></td><td class="is-empty"></td><td class="is-empty"></td><td class="is-empty"></td><td class="is-empty"></td></tr></tbody></table></div></div></div>
        <div class="search-condition-editor-tip__no-date"><button class="search-condition-editor-tip__no-date-button" data-asv-target="no-date" type="button">日付未定</button></div>
      </div>
    </div>
  </div>

  <div class="search-condition-editor-tip search-condition-editor-tip--where" data-asv-target="editor-tip-where">
    <div class="search-condition-editor-tip__inner">
      <b class="search-condition-editor-tip__heading">エリア</b>
      <div class="search-condition-editor-tip__input-wrap">
        <select name="rg" id="select-rg" class="search-condition-editor-tip__narrow-select"><option value="">全ての地方</option><option value="rgn01">北海道</option><option value="rgn02">東北</option><option value="rgn04">関東</option><option value="rgn05">甲信越</option><option value="rgn06">北陸</option><option value="rgn07">東海</option><option value="rgn08">関西</option><option value="rgn09">山陰・山陽</option><option value="rgn10">四国</option><option value="rgn11">九州</option><option value="rgn12">沖縄</option></select>
        <select name="pr" id="select-pr" class="search-condition-editor-tip__narrow-select" disabled="disabled"><option value="">全ての都道府県</option></select>
        <select name="ar" id="select-ar" class="search-condition-editor-tip__narrow-select" disabled="disabled"><option value="">全てのエリア</option></select>
        <select name="smallAreas" id="select-smallAreas" class="search-condition-editor-tip__narrow-select" disabled="disabled"><option value="">全ての小エリア</option></select>
      </div>
    </div>
  </div>

  <div class="search-condition-editor-tip search-condition-editor-tip--what" data-asv-target="editor-tip-what">
    <div class="search-condition-editor-tip__inner">
      <b class="search-condition-editor-tip__heading">ジャンル</b>
      <div class="search-condition-editor-tip__input-wrap">
        <select name="ct" id="select-ct" class="search-condition-editor-tip__narrow-select"><option value="">全てのカテゴリ</option><option value="1">空</option><option value="2">川・滝</option><option value="3">海</option><option value="4">湖・池</option><option value="5">山・自然</option><option value="6">乗り物</option><option value="7">観光・レジャー</option><option value="8">スポーツ・フィットネス</option><option value="9">雪</option><option value="10">ものづくり・クラフト</option><option value="11">日本文化</option><option value="12">サブカルチャー</option><option value="13">テクノロジー</option><option value="14">スポーツ・フィットネス</option><option value="15">日本文化</option><option value="16">料理・お酒</option><option value="17">ものづくり・クラフト</option><option value="18">花・ガーデニング</option></select>
        <select name="ac" id="select-ac" class="search-condition-editor-tip__narrow-select" disabled="disabled"><option value="">全てのジャンル</option></select>
      </div>
    </div>
  </div>

  <div class="search-condition-editor-tip search-condition-editor-tip--who" data-asv-target="editor-tip-who">
    <div class="search-condition-editor-tip__inner">
      <b class="search-condition-editor-tip__heading">人数</b>
      <div class="search-condition-editor-tip__input-wrap">
        <label><input type="number" name="np" min="1" max="999999999" value="" id="number-of-people"> 人</label>
      </div>
    </div>
  </div>

  <div class="search-condition-editor-tip search-condition-editor-tip--more" data-asv-target="editor-tip-more">
    <div class="search-condition-editor-tip__inner">
      <b class="search-condition-editor-tip__heading">さらに詳しく</b>
      <div class="search-condition-editor-tip__more-row">
        <div class="search-condition-editor-tip__more-column-3">
          <b class="search-condition-editor-tip__sub-heading">キーワード</b>
          <div class="search-condition-editor-tip__input-wrap"><input type="text" name="q" size="20" value=""></div>
        </div>
        <div class="search-condition-editor-tip__more-column-3">
          <b class="search-condition-editor-tip__sub-heading">予算</b>
          <div class="search-condition-editor-tip__input-wrap"><select name="bd"><option value="">指定なし</option><option value="1000">\1,000以内</option><option value="2000">\2,000以内</option><option value="3000">\3,000以内</option><option value="4000">\4,000以内</option><option value="5000">\5,000以内</option><option value="6000">\6,000以内</option><option value="8000">\8,000以内</option><option value="10000">\10,000以内</option><option value="15000">\15,000以内</option><option value="20000">\20,000以内</option><option value="30000">\30,000以内</option><option value="40000">\40,000以内</option><option value="50000">\50,000以内</option></select></div>
        </div>
        <div class="search-condition-editor-tip__more-column-3">
          <b class="search-condition-editor-tip__sub-heading">対象年齢</b>
          <div class="search-condition-editor-tip__input-wrap"><select name="targetAge"><option value="">指定なし</option><option value="0">0歳以上</option><option value="1">1歳以上</option><option value="2">2歳以上</option><option value="3">3歳以上</option><option value="4">4歳以上</option><option value="5">5歳以上</option><option value="6">6歳以上</option><option value="7">7歳以上</option><option value="8">8歳以上</option><option value="9">9歳以上</option><option value="10">10歳以上</option><option value="11">11歳以上</option><option value="12">12歳以上</option><option value="13">13歳以上</option><option value="14">14歳以上</option><option value="15">15歳以上</option><option value="16">16歳以上</option><option value="17">17歳以上</option><option value="18">18歳以上</option><option value="50">50歳以上</option><option value="60">60歳以上</option></select></div>
        </div>
        <div class="search-condition-editor-tip__more-column-3">
          <b class="search-condition-editor-tip__sub-heading">所要時間</b>
          <div class="search-condition-editor-tip__input-wrap"><select name="timeRequired"><option value="">指定なし</option><option value="30">30分以内</option><option value="60">1時間以内</option><option value="90">1時間30分以内</option><option value="120">2時間以内</option><option value="180">3時間以内</option><option value="240">4時間以内</option><option value="360">6時間以内</option><option value="1440">1日以内</option><option value="2880">2日以内</option></select></div>
        </div>
      </div>
        <div class="search-condition-editor-tip__more-row">
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">利用シーン</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="6">1人参加可</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="13">こどもとおでかけ</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="14">デート</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="15">記念日</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="16">女子会・女子旅</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="17">夜景</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="18">雨の日</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="23">3000円以下</label></div>
            </div>
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">支払い方法</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="11">現地払い</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="12">事前払い</label></div>
            </div>
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">団体予約</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="19">10人以上</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="20">20人以上</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="21">30人以上</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="22">100人以上</label></div>
            </div>
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">サービス</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="1">食事付</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="2">送迎付</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="3">ガイド同行</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="7">ペット参加可</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="8">貸切可</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="29">料金割引</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="30">ライセンス</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="31">保険</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="32">レンタル</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="33">初心者OK</label></div>
            </div>
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">空間・設備</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="amenities" value="1">シャワー</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="amenities" value="2">トイレ</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="amenities" value="3">ドライヤー</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="amenities" value="4">ロッカー</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="amenities" value="5">売店</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="amenities" value="6">更衣室</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="amenities" value="7">貴重品預かり</label></div>
            </div>
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">駐車場あり</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="accesses" value="1">有料駐車場</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="accesses" value="2">無料駐車場</label></div>
            </div>
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">日程</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="9">午前</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="10">午後</label></div>
            </div>
            <div class="search-condition-editor-tip__more-column-12">
              <b class="search-condition-editor-tip__sub-heading">シーズン</b>
              <div class="search-condition-editor-tip__input-wrap"><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="24">オールシーズン</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="25">春</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="26">夏</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="27">秋</label><label class="search-condition-editor-tip__multiple-option"><input type="checkbox" name="tg" value="28">冬</label></div>
            </div>
        </div>
      </div>
  </div>
</div>

</div>

</form></div>

      <div class="plan-summary">
        <section>
          <div class="plan-summary-control">
              <h2 class="plan-summary-control__control-heading">検索結果一覧</h2>
              <p class="plan-summary-control__control-name">表示順序：</p>
              <ul class="plan-summary-control__sort-list">
                <li class="plan-summary-control__sort-item plan-summary-control__sort-item--sorted">おすすめ順</li>
                  <li class="plan-summary-control__sort-item"><a class="plan-summary-control__sort-link" href="/search/?sort=2" title="新着順で見る">新着順</a></li>
                  <li class="plan-summary-control__sort-item"><a class="plan-summary-control__sort-link" href="/search/?sort=3" title="料金が安い順で見る">料金が安い順</a></li>
                  </ul>
              <p class="plan-summary-control__plan-count">78,404&nbsp;件中&nbsp;1&nbsp;-&nbsp;20&nbsp;件</p>
            </div>
            <ul class="plan-summary-list">
              <li class="plan-summary-list__item js-prAd_impression" data-pr-no="">

    <div class="plan-summary-list__plan-title-wrap">
      <a href="/act/pottery/tokyo/are0136200/pln3000002928/" class="plan-summary-list__plan-title-link js-prAd_click">銀座駅から徒歩1分！手びねり陶芸体験（約2～3時間）</a></div>
    <p class="plan-summary-list__company-name-wrap"><a href="/company/3000001270/" class="plan-summary-list__company-name-link">GINZA自遊工房</a></p>
    <div class="plan-summary-list__detail-wrap">
      <figure class="plan-summary-list__image-wrap">
        <a href="/act/pottery/tokyo/are0136200/pln3000002928/" class="plan-summary-list__image-link js-prAd_click"><img class="plan-summary-list__image" src="//d15no6vzq701ao.cloudfront.net/image/production/acp/3000001270/pln3000002928/47ceb813-0331-41dd-b69e-e7124568f8aa.jpg?width=360&amp;height=240&amp;type=resize" data-original="//d15no6vzq701ao.cloudfront.net/image/production/acp/3000001270/pln3000002928/47ceb813-0331-41dd-b69e-e7124568f8aa.jpg?width=360&amp;height=240&amp;type=resize" alt="銀座駅から徒歩1分！手びねり陶芸体験（約2～3時間）の写真" style="display: inline;"></a></figure>
      <div class="plan-summary-list__datas">
        <ul class="plan-summary-list__tag-list">
          <li class="plan-summary-list__tag-item">グループ・団体向け</li>
          <li class="plan-summary-list__tag-item">子供参加可</li>
          <li class="plan-summary-list__tag-item">午後</li>
          <li class="plan-summary-list__tag-item">現地払い</li>
          <li class="plan-summary-list__tag-item">雨の日</li>
          <li class="plan-summary-list__tag-item">オールシーズン</li>
          </ul>
        <div class="plan-summary-list__access-wrap">
            <p class="plan-summary-list__access-address"><span class="ico-map-marker"></span> 東京都中央区銀座5-10-1プリンスビル3階</p>
          </div>
        <div class="plan-summary-list__plan-fee-wrap">
          <span class="plan-summary-list__plan-fee"><span class="ico-jpy"></span> 3,240円<span class="plan-summary-list__plan-fee-note">（税込）?</span></span>
          </div>
        <div class="plan-summary-list__vacancy-wrap">
          <ul class="plan-summary-list__vacancy-list">
            <li class="plan-summary-list__vacancy-item">
                <span class="plan-summary-list__vacancy-date">12/26</span>
                <span class="plan-summary-list__vacancy-day">月</span>
                <span class="plan-summary-list__vacancy-status"><span class="plan-summary-list__vacancy-status-icon plan-summary-list__vacancy-status-icon--unknown"></span></span></li>
            <li class="plan-summary-list__vacancy-item">
                <span class="plan-summary-list__vacancy-date">12/27</span>
                <span class="plan-summary-list__vacancy-day">火</span>
                <span class="plan-summary-list__vacancy-status"><span class="plan-summary-list__vacancy-status-icon plan-summary-list__vacancy-status-icon--ok"></span></span></li>
            <li class="plan-summary-list__vacancy-item">
                <span class="plan-summary-list__vacancy-date">12/28</span>
                <span class="plan-summary-list__vacancy-day">水</span>
                <span class="plan-summary-list__vacancy-status"><span class="plan-summary-list__vacancy-status-icon plan-summary-list__vacancy-status-icon--ok"></span></span></li>
            <li class="plan-summary-list__vacancy-item">
                <span class="plan-summary-list__vacancy-date">12/29</span>
                <span class="plan-summary-list__vacancy-day">木</span>
                <span class="plan-summary-list__vacancy-status"><span class="plan-summary-list__vacancy-status-icon plan-summary-list__vacancy-status-icon--ok"></span></span></li>
            <li class="plan-summary-list__vacancy-item">
                <span class="plan-summary-list__vacancy-date">12/30</span>
                <span class="plan-summary-list__vacancy-day">金</span>
                <span class="plan-summary-list__vacancy-status"><span class="plan-summary-list__vacancy-status-icon plan-summary-list__vacancy-status-icon--ok"></span></span></li>
            <li class="plan-summary-list__vacancy-item">
                <span class="plan-summary-list__vacancy-date">12/31</span>
                <span class="plan-summary-list__vacancy-day">土</span>
                <span class="plan-summary-list__vacancy-status"><span class="plan-summary-list__vacancy-status-icon plan-summary-list__vacancy-status-icon--ok"></span></span></li>
            <li class="plan-summary-list__vacancy-item">
                <span class="plan-summary-list__vacancy-date">1/1</span>
                <span class="plan-summary-list__vacancy-day">日</span>
                <span class="plan-summary-list__vacancy-status"><span class="plan-summary-list__vacancy-status-icon plan-summary-list__vacancy-status-icon--unknown"></span></span></li>
            </ul>
          <a href="/act/pottery/tokyo/are0136200/pln3000002928/" class="plan-summary-list__btn-reserve js-prAd_click">詳しく見る</a></div>
        </div>
      </div>

    <p class="plan-summary-list__plan-description">土のかたまりを、陶器に生まれ変わらせよう！銀座にある陶芸教室で、ものづくりの楽しさを体験。お渡しするのは、ゴロンとした土のかたまり。これをあなたの手で、器へと生まれ変わらせます！カップ・お茶碗・置物・お皿・湯のみなど、作品のアイデアは無限大。自作の湯のみでお茶を飲んだり、イヌやネコの置物を部屋に飾ったり、日常にホッと癒やしをもたらしてくれますよ。優しい人柄の講師が、お客様を見守ります初めての方に、リラックスして陶芸を楽しんでもらいたい。講師がお客様に寄りそうようにして、優しく見守ります。「先生が優しく指導 ...</p>
    </li>
</ul>
<div class="pager">
<ul class="pager-num clearfix">
  <li class="pager-current">1</li><li class="pager-number"><a href="/search/?page=2">2</a></li><li class="pager-number"><a href="/search/?page=3">3</a></li><li class="pager-number"><a href="/search/?page=4">4</a></li><li class="pager-number"><a href="/search/?page=5">5</a></li><li class="pager-number"><a href="/search/?page=6">6</a></li><li class="pager-number"><a href="/search/?page=7">7</a></li><li class="pager-leader">…</li><li class="pager-number"><a href="/search/?page=3920">3920</a></li><li class="pager-number"><a href="/search/?page=3921">3921</a></li><li class="pager-next"><a href="/search/?page=2"><span class="icon-arrow-right_green"></span></a></li></ul>
</div></section>
      </div>
      </div>
    <div id="side-nav-wrap" class="l-side-navi-l l-side-navi-l_search"><form name="searchActionForm" id="searchForm" method="GET" action="/search/">
<div class="bl-side-navi">
  <div class="js-accordion">
      <section>
        <h4 class="bl-side-navi__heading bl-side-navi__heading-search js-accordion-link open" data-collapse-summary="" aria-expanded="true"><a href="#" class="bl-side-navi__title minus">エリアから探す</a></h4>
        <ul class="bl-search-side-navi js-accordion" aria-hidden="false">
          
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn01">北海道(4207)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn02">東北(5160)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn04">関東(25164)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn05">甲信越(4597)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn06">北陸(1957)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn07">東海(8282)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn08">関西(10902)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn09">山陰・山陽(4104)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn10">四国(2146)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn11">九州(6790)</a>
              </p>
            </li>
            
          
            <li class="bl-search-side-navi__item">
              <p class="bl-search-side-navi__item_first">
                <span class="bl-search-side-navi__arrow--right"></span>
                  <a href="/search/?sort=1&amp;rg=rgn12">沖縄(5140)</a>
              </p>
            </li>
            
          
        </ul>
      </section>
      <section>
        <h4 class="bl-side-navi__heading bl-side-navi__heading-search js-accordion-link open" data-collapse-summary="" aria-expanded="true"><a href="#" class="bl-side-navi__title minus">ジャンルから探す</a></h4>
        <ul class="bl-search-side-navi js-accordion" aria-hidden="false">
          <li class="bl-search-side-navi__sub-heading">
            <p class="bl-search-side-navi__item_all">
              </p><div class="popular-genre-tip">
                <button class="popular-genre-tip__btn-show" data-asv-target="show-popular-genre-tip" type="button" onclick="ga('send','event','search','click','click_popular-genre-tip__btn-show_PC');">おすすめジャンル</button>
                <ul class="popular-genre-tip__main">
                  <li class="popular-genre-tip__item">
                    <p>読み込み中</p>
                  </li>
                </ul>
              </div>
            <p></p>
          </li>
          
          
              <li class="bl-search-side-navi__sub-heading side-navi-color">アウトドア体験</li>
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=1">空(544)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=2">川・滝(2858)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=3">海(9412)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=4">湖・池(2380)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=5">山・自然(5123)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=6">乗り物(998)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=7">観光・レジャー(14474)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=8">スポーツ・フィットネス(9613)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=9">雪(403)</a>
                  </p>
                </li>
                
              
          
              <li class="bl-search-side-navi__sub-heading side-navi-color">アウトドア創作</li>
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=10">ものづくり・クラフト(2)</a>
                  </p>
                </li>
                
              
          
              <li class="bl-search-side-navi__sub-heading side-navi-color">インドア体験</li>
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=11">日本文化(3612)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=12">サブカルチャー(8296)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=13">テクノロジー(35)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=14">スポーツ・フィットネス(12929)</a>
                  </p>
                </li>
                
              
          
              <li class="bl-search-side-navi__sub-heading side-navi-color">インドア創作</li>
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=15">日本文化(1860)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=16">料理・お酒(1044)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=17">ものづくり・クラフト(11979)</a>
                  </p>
                </li>
                
              
                <li class="bl-search-side-navi__item">
                  <p class="bl-search-side-navi__item_first">
                    <span class="bl-search-side-navi__arrow--right"></span>
                      <a href="/search/?sort=1&amp;ct=18">花・ガーデニング(3118)</a>
                  </p>
                </li>
                
              
          
        </ul>
      </section>
      <section>
      <h4 class="bl-side-navi__heading bl-side-navi__heading-search js-accordion-link open" data-collapse-summary="" aria-expanded="true"><a href="#" class="bl-side-navi__title minus">希望・予算から探す</a></h4>
      <ul class="bl-search-side-navi--hope js-accordion" aria-hidden="false">
        <input type="hidden" name="ymd" value="">
        <li class="bl-side-navi--hope__sub-heading"><label for="np">人数</label></li>
        <li class="bl-search-side-navi--hope__item"><input type="number" name="np" min="1" max="999999999" value="" id="np">人</li>
        <li class="bl-side-navi--hope__sub-heading"><label for="bd">予算</label></li>
        <li class="bl-search-side-navi--hope__item"><select name="bd"><option value="">指定なし</option><option value="1000">\1,000以内</option><option value="2000">\2,000以内</option><option value="3000">\3,000以内</option><option value="4000">\4,000以内</option><option value="5000">\5,000以内</option><option value="6000">\6,000以内</option><option value="8000">\8,000以内</option><option value="10000">\10,000以内</option><option value="15000">\15,000以内</option><option value="20000">\20,000以内</option><option value="30000">\30,000以内</option><option value="40000">\40,000以内</option><option value="50000">\50,000以内</option></select></li>
        <li class="bl-side-navi--hope__sub-heading"><label for="targetAge">対象年齢</label></li>
        <li class="bl-search-side-navi--hope__item"><select name="targetAge" id="targetAge" class=""><option value="">指定なし</option><option value="0">0歳以上</option><option value="1">1歳以上</option><option value="2">2歳以上</option><option value="3">3歳以上</option><option value="4">4歳以上</option><option value="5">5歳以上</option><option value="6">6歳以上</option><option value="7">7歳以上</option><option value="8">8歳以上</option><option value="9">9歳以上</option><option value="10">10歳以上</option><option value="11">11歳以上</option><option value="12">12歳以上</option><option value="13">13歳以上</option><option value="14">14歳以上</option><option value="15">15歳以上</option><option value="16">16歳以上</option><option value="17">17歳以上</option><option value="18">18歳以上</option><option value="50">50歳以上</option><option value="60">60歳以上</option></select></li>
        <li class="bl-side-navi--hope__sub-heading"><label for="timeRequired">所要時間</label></li>
        <li class="bl-search-side-navi--hope__item"><select name="timeRequired" id="timeRequired" class=""><option value="">指定なし</option><option value="30">30分以内</option><option value="60">1時間以内</option><option value="90">1時間30分以内</option><option value="120">2時間以内</option><option value="180">3時間以内</option><option value="240">4時間以内</option><option value="360">6時間以内</option><option value="1440">1日以内</option><option value="2880">2日以内</option></select></li>
        <li class="bl-search-side-navi--hope__item">
          <div class="bl-side-navi__search hl_solid-line-t"><input type="submit" value="この条件で検索する" onclick="ga('send','event','search','search','search_side-navi-budget-btn_PC');" class="btn-submit_green"></div>
        </li>
      </ul>
      </section>
      <section>
        <h4 class="bl-side-navi__heading bl-side-navi__heading-search js-accordion-link open" data-collapse-summary="" aria-expanded="true"><a href="#" class="bl-side-navi__title minus">詳細条件から探す</a></h4>
        <ul class="bl-search-side-navi--tag js-accordion" aria-hidden="false">
            <li class="bl-search-side-navi__sub-heading side-navi-color">利用シーン</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="6" id="tg6"> 1人参加可</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="13" id="tg13"> こどもとおでかけ</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="14" id="tg14"> デート</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="15" id="tg15"> 記念日</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="16" id="tg16"> 女子会・女子旅</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="17" id="tg17"> 夜景</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="18" id="tg18"> 雨の日</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="23" id="tg23"> 3000円以下</label>
              </li>
            <li class="bl-search-side-navi__sub-heading side-navi-color">支払い方法</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="11" id="tg11"> 現地払い</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="12" id="tg12"> 事前払い</label>
              </li>
            <li class="bl-search-side-navi__sub-heading side-navi-color">団体予約</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="19" id="tg19"> 10人以上</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="20" id="tg20"> 20人以上</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="21" id="tg21"> 30人以上</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="22" id="tg22"> 100人以上</label>
              </li>
            <li class="bl-search-side-navi__sub-heading side-navi-color">サービス</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="1" id="tg1"> 食事付</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="2" id="tg2"> 送迎付</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="3" id="tg3"> ガイド同行</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="7" id="tg7"> ペット参加可</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="8" id="tg8"> 貸切可</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="29" id="tg29"> 料金割引</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="30" id="tg30"> ライセンス</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="31" id="tg31"> 保険</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="32" id="tg32"> レンタル</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="33" id="tg33"> 初心者OK</label>
              </li>
            <li class="bl-search-side-navi__sub-heading side-navi-color">空間・設備</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="amenities" value="1" id="amenities1"> シャワー</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="amenities" value="2" id="amenities2"> トイレ</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="amenities" value="3" id="amenities3"> ドライヤー</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="amenities" value="4" id="amenities4"> ロッカー</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="amenities" value="5" id="amenities5"> 売店</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="amenities" value="6" id="amenities6"> 更衣室</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="amenities" value="7" id="amenities7"> 貴重品預かり</label>
              </li>
            <li class="bl-search-side-navi__sub-heading side-navi-color">駐車場あり</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="accesses" value="1" id="accesses1"> 有料駐車場</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="accesses" value="2" id="accesses2"> 無料駐車場</label>
              </li>
            <li class="bl-search-side-navi__sub-heading side-navi-color">日程</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="9" id="tg9"> 午前</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="10" id="tg10"> 午後</label>
              </li>
            <li class="bl-search-side-navi__sub-heading side-navi-color">シーズン</li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="24" id="tg24"> オールシーズン</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="25" id="tg25"> 春</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="26" id="tg26"> 夏</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="27" id="tg27"> 秋</label>
              </li>
              <li class="bl-search-side-navi--tag__item">
                <label><input type="checkbox" name="tg" value="28" id="tg28"> 冬</label>
              </li>
          <li class="bl-search-side-navi--tag__item">
            <div class="bl-side-navi__search hl_solid-line-t"><input type="submit" value="この条件で検索する" onclick="ga('send','event','search','search','search_side-navi-detail-condition-btn_PC');" class="btn-submit_green"></div>
          </li>
        </ul>
      </section>
  </div>
</div>
</form></div>

  </div>


<!-- demo -->





    <!--searchbox-->
    <?php require("includes/box/hotel/searchbox2.php");?>
    
	<?php $formnamePlan = "frmFacSearch";?>
	<form action="plan-search.html" method="post" id="<?php print $formnamePlan?>" name="<?php print $formnamePlan?>">
	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
	<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
	<?php print $inputs->hidden("area", $collection->getByKey($collection->getKeyValue(), "area"))?>
	<?php print $inputs->hidden("category", $collection->getByKey($collection->getKeyValue(), "category"))?>

	<?php print $inputs->hidden("budget_from", $collection->getByKey($collection->getKeyValue(), "budget_from"))?>
	<?php print $inputs->hidden("budget_to", $collection->getByKey($collection->getKeyValue(), "budget_to"))?>
	</form>


    <!--searchresult-->
    <ul class="tab">
        <li class="tab2 currenttab"><a>検索結果</a></li>
    </ul>
    <section class="mainbox resultbox form">
	<div class="result_sort">
    	<?php $scope = $pager->getOffsetByPageId()?>
    	<div class="result">検索結果：<b><?php print $shop->getMaxCount()?>件</b>のプランのうち <b><?php print $scope['0']?></b>件～<b><?php print $scope['1']?></b>件を表示</div>
        <p class="caution">※表示の料金は1名様あたりの最安値（税込）です。<br></p>

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
				<dd><a href="javascript: ordertype_submit(0);">新着順</a><dd>
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


        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
        <!--item-->
		<?php //print_r($plandata);?>

		<article style="min-height:235px;">
        	<div class="inner cf">
    	    	<div class="innerhed cf">
    	    		<!--<span class="option01"></span>-->
	        		<h3>
	        		<?php $formname = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"]."_".$plandata["ROOM_ID"];?>
		        	<form action="search-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><B><?php print $plandata["SHOP_NAME"]?></B></a>
	            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	            	<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
	            	<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
	            	<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
	            	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
	            	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
	            	<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>

		        	</form>
	        		</h3>
	        		<ul class="type-h">
	        			<!--<li class="type">施設タイプ</li>-->
	        			<?php
	        			$arArea = array();
	        			$arTemp = explode(":", $plandata["SHOP_LIST_AREA"]);
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
			<div class="inner-plan cf">
        		<div class="hotel-subinfo cf">
        			<?php if ($plandata["SHOPPLAN_PIC1"] != "" || $plandata["SHOPPLAN_PIC1"] != "") {?>
					<a href="#"><img src="<?php print URL_SLAKER_COMMON."/images/".$plandata["SHOPPLAN_PIC1"]?>" width="248" height="165" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
				<?php }else{?>
					<a href="#"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="248" height="165" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
				<?php }?>


      				<h4 class="hotel-copy">
      				<?php $formname = "frm".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
		        	<form action="plan-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
						<?php /*<span class="new">NEW</span>*/?><a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><?php print $plandata["SHOPPLAN_NAME"]?></a>
		            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
		            	<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
		            	<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
		            	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
		                    	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
		            	<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
		            	<?php print $inputs->hidden("calender_mon", $plandata["money_all"])?>
		        	</form></h4>

                		<!--<ul class="icon">
                    		<li><img src="./images/common/icon-nomeal.jpg"</li>
                    		<li><img src="./images/common/icon-Limit.jpg"</li>
                    	</ul>-->
		<div class="hotel-text">
      			<div class="hotel-text ss-text">
			<?php print redirectForReturn($plandata["SHOPPLAN_DISCRIPTION"])?>
       			</div>

                		<div class="off_bo">
                			<?php if ($plandata["SHOPPLAN_DISCOUNT"] != "") {?>
                			<div class="offtxt radius10"><b><?php print $plandata["SHOPPLAN_DISCOUNT"]?>%</b>OFF</div>
                			<?php }?>
                			<div class="off-inner  radius10">
                				<b>料金</b><br />
	                    		<strong>￥<?php print number_format($plandata["money_all"])?>～</strong><br />
                        		<p class="point" style="color: #ff4500;"></p>
                    		</div>
                    	</div>

        		</div>
      			<div class="s-txt-dates">催行期間：<?php $fromDate = cmDateDivide($plandata["SHOPPLAN_SALE_FROM"])?>
      			<?php $toDate = cmDateDivide($plandata["SHOPPLAN_SALE_TO"])?>
      			<?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?>～<?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?></div>

		</div>
        	</div>
		</article>

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


</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
