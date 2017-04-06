<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/mArea.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategory.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategoryDetail.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mTag.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");


$collection = new collection($db);
$collection->setPost();
// print_r($collection->getCollection());
cmSetHotelSearchDef($collection);
$collection->setByKey($collection->getKeyValue(), "pageNum", 10);

//print_r($collection);

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


$mArea = new mArea($dbMaster);
$mArea->selectListGroup($collection);

$mActivityCategory = new mActivityCategory($dbMaster);
$mActivityCategory->selectList($collection);

$mActivityCategoryDetail = new mActivityCategoryDetail($dbMaster);
$mActivityCategoryDetail->selectList($collection);

$mTag = new mTag($dbMaster);
$mTag->selectList($collection);



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

<script type="text/javascript"> 
$(document).ready(function() {
	$(".menu1, .menu2, .menu3, .menu4, .menu5").hide(); 
	$("ul.search-menu li:first").addClass("active").show(); 
	$(".content:first").show(); 
	$("ul.search-menu li").click(function() {
		$("ul.tabs li").removeClass("active"); 
		$(this).addClass("active");
		$(".menu1, .menu2, .menu3, .menu4, .menu5").hide();
		var activeTab = $(this).find("a").attr("href"); 
		$(activeTab).fadeIn();
		return false;
	});
	$(document).click(function() {　$(".menu1, .menu2, .menu3, .menu4, .menu5").hide();　});
	$(".menu1, .menu2, .menu3, .menu4, .menu5").click(function() {　event.stopPropagation();　});
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
    <main id="detail_n" class="search">

    <ul id="panlist">
        <li><a href="/">TOP</a></li>
        <li><span>検索結果</span></li>
    </ul>

<div class="">



    <div class="">
<!-- side nav -->


    <div id="side-list" class=""><form name="search-side-list" id="search-side-list" method="POST" action="/plan-search.html">
	<input type="hidden" name="area" id="area" value="">
<div class="">
  <div class="js-accordion">
      <section>
        <h4 class="search-title" ><a href="#" class="accordion">エリアから探す</a></h4>
        <ul class="">
          
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='11';document.search-side-list.submit();">北海道(4207)</a>
              </p>

            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='10';document.search-side-list.submit();">東北(5160)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='9';document.search-side-list.submit();">関東(25164)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='8';document.search-side-list.submit();">甲信越(4597)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='7';document.search-side-list.submit();">北陸(1957)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='6';document.search-side-list.submit();">東海(8282)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='5';document.search-side-list.submit();">関西(10902)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='4';document.search-side-list.submit();">山陰・山陽(4104)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='3';document.search-side-list.submit();">四国(2146)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value='2';document.search-side-list.submit();">九州(6790)</a>
              </p>
            </li>
            
          
            <li class="">
              <p class="">
                <span class=""></span>
                  <a href="" onclick="document.getElementById('area').value=1;">沖縄(5140)</a>
              </p>
            </li>
            
          
        </ul>
      </section>
      <section>
        <h4 class="search-title"><a href="#" class="">ジャンルから探す</a></h4>

        <ul class="">

	<?php// foreach($mActivityCategory->getCollection() as $ac){?>
               <li class="">
                 <p class="">
                   <span class=""></span>
                     <a href="">マリンレジャー(544)</a>
                 </p>
               </li>

              
          
        </ul>
      </section>
      <section>
      <h4 class="search-title"><a href="#" class="">希望・予算から探す</a></h4>
      <ul class="">
        <input type="hidden" name="ymd" value="">
        <li class=""><label for="np">人数</label></li>
        <li class=""><input type="number" name="np" min="1" max="999999999" value="" id="np">人</li>
        <li class=""><label for="bd">予算</label></li>
        <li class=""><select name="bd"><option value="">指定なし</option><option value="1000">\1,000以内</option><option value="2000">\2,000以内</option><option value="3000">\3,000以内</option><option value="4000">\4,000以内</option><option value="5000">\5,000以内</option><option value="6000">\6,000以内</option><option value="8000">\8,000以内</option><option value="10000">\10,000以内</option><option value="15000">\15,000以内</option><option value="20000">\20,000以内</option><option value="30000">\30,000以内</option><option value="40000">\40,000以内</option><option value="50000">\50,000以内</option></select></li>
        <li class=""><label for="targetAge">対象年齢</label></li>
        <li class=""><select name="targetAge" id="targetAge" class=""><option value="">指定なし</option><option value="0">0歳以上</option><option value="1">1歳以上</option><option value="2">2歳以上</option><option value="3">3歳以上</option><option value="4">4歳以上</option><option value="5">5歳以上</option><option value="6">6歳以上</option><option value="7">7歳以上</option><option value="8">8歳以上</option><option value="9">9歳以上</option><option value="10">10歳以上</option><option value="11">11歳以上</option><option value="12">12歳以上</option><option value="13">13歳以上</option><option value="14">14歳以上</option><option value="15">15歳以上</option><option value="16">16歳以上</option><option value="17">17歳以上</option><option value="18">18歳以上</option><option value="50">50歳以上</option><option value="60">60歳以上</option></select></li>
        <li class=""><label for="timeRequired">所要時間</label></li>
        <li class=""><select name="timeRequired" id="timeRequired" class=""><option value="">指定なし</option><option value="30">30分以内</option><option value="60">1時間以内</option><option value="90">1時間30分以内</option><option value="120">2時間以内</option><option value="180">3時間以内</option><option value="240">4時間以内</option><option value="360">6時間以内</option><option value="1440">1日以内</option><option value="2880">2日以内</option></select></li>
        <li class="">
            <div class=""><input type="submit" value="この条件で検索する" onclick="document.search-side-list.submit();" class="search-list-btn"></div>
        </li>
      </ul>
      </section>
      <section>
        <h4 class="search-title"><a href="#" class="">詳細条件から探す</a></h4>
        <ul class="">
            <li class="search-subtitle">利用シーン</li>
              <li class="">
                <label><input type="checkbox" name="tg" value="6" id="tg6"> 1人参加可</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="13" id="tg13"> こどもとおでかけ</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="14" id="tg14"> デート</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="15" id="tg15"> 記念日</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="16" id="tg16"> 女子会・女子旅</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="17" id="tg17"> 夜景</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="18" id="tg18"> 雨の日</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="23" id="tg23"> 3000円以下</label>
              </li>
            <li class="search-subtitle">支払い方法</li>
              <li class="">
                <label><input type="checkbox" name="tg" value="11" id="tg11"> 現地払い</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="12" id="tg12"> 事前払い</label>
              </li>
            <li class="search-subtitle">団体予約</li>
              <li class="">
                <label><input type="checkbox" name="tg" value="19" id="tg19"> 10人以上</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="20" id="tg20"> 20人以上</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="21" id="tg21"> 30人以上</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="22" id="tg22"> 100人以上</label>
              </li>
            <li class="search-subtitle">サービス</li>
              <li class="">
                <label><input type="checkbox" name="tg" value="1" id="tg1"> 食事付</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="2" id="tg2"> 送迎付</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="3" id="tg3"> ガイド同行</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="7" id="tg7"> ペット参加可</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="8" id="tg8"> 貸切可</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="29" id="tg29"> 料金割引</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="30" id="tg30"> ライセンス</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="31" id="tg31"> 保険</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="32" id="tg32"> レンタル</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="33" id="tg33"> 初心者OK</label>
              </li>
            <li class="search-subtitle">空間・設備</li>
              <li class="">
                <label><input type="checkbox" name="amenities" value="1" id="amenities1"> シャワー</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="amenities" value="2" id="amenities2"> トイレ</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="amenities" value="3" id="amenities3"> ドライヤー</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="amenities" value="4" id="amenities4"> ロッカー</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="amenities" value="5" id="amenities5"> 売店</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="amenities" value="6" id="amenities6"> 更衣室</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="amenities" value="7" id="amenities7"> 貴重品預かり</label>
              </li>
            <li class="search-subtitle">駐車場あり</li>
              <li class="">
                <label><input type="checkbox" name="accesses" value="1" id="accesses1"> 有料駐車場</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="accesses" value="2" id="accesses2"> 無料駐車場</label>
              </li>
            <li class="search-subtitle">日程</li>
              <li class="">
                <label><input type="checkbox" name="tg" value="9" id="tg9"> 午前</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="10" id="tg10"> 午後</label>
              </li>
            <li class="search-subtitle">シーズン</li>
              <li class="">
                <label><input type="checkbox" name="tg" value="24" id="tg24"> オールシーズン</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="25" id="tg25"> 春</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="26" id="tg26"> 夏</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="27" id="tg27"> 秋</label>
              </li>
              <li class="">
                <label><input type="checkbox" name="tg" value="28" id="tg28"> 冬</label>
              </li>
          <li class="">
            <div class=""><input type="submit" value="この条件で検索する" onclick="document.search-side-list.submit();" class="search-list-btn"></div>
          </li>
        </ul>
      </section>
  </div>
</div>
</form></div>




    <!--<div class="banner_area">
    	<a href="" class=""><img class="" src="" alt=""></a>
　　</div>-->

　　<div class="search-result">
      	<h1 class="search">検索結果</h1>
    </div>

    <div class="search-result"><form name="search-change" id="search-change" method="POST" action="/plan-search.html">
<div class="">
  

  <div class="search-change-box">
   <div class="search-menu-outer">
    <ul class="search-menu">
      <li class=""><a href="#menu1">日付：<?php print date("Y年m月d日") ?></a></li>
      <li class=""><a href="#menu2">エリア</a></li>
      <li class=""><a href="#menu3">カテゴリー</a></li>
      <li class=""><a href="#menu4">人数</a></li>
      <li class=""><a href="#menu5">さらに詳しく</a></li>
    </ul>
    <button class="search-change-btn" type="submit" onclick="document.search-change.submit();">この条件で検索</button>
   </div>
  </div>

<div class="">

  <div class="menu1" id="menu1">
    <div class="inner">
      <b class="heading">日付</b>
	<input type="text" id="search_date" name="search_date" value="<?php print date("Y年m月d日") ?>" class="imeDisabled wDateJp" />
        <div id="date-picker"></div>
			<script type="text/javascript">
					                $.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
							               $("#date-picker").datepicker(
							                       	{
							                       			showOn: 'button',
							                       			buttonImage: 'images/index2016/index-search-icon.png',
							                       			buttonImageOnly: true,

										onSelect: function(dateText, inst) {$('#search_date').val(dateText);},
										numberOfMonths: '2',
							                       	dateFormat: 'yy年mm月dd日',
							                       	changeMonth: true,
							                       	changeYear: true,
							                       	yearRange: '2016:2017',
							                       	showMonthAfterYear: true,
							                       	monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
							                        dayNamesMin: ['日','月','火','水','木','金','土']
							                       	});
			  </script>
    </div>
  </div>

  <div class="menu2" id="menu2">
    <div class="inner">
      <b class="heading">エリア</b>
      <div class="input-wrap">
        <select name="rg" id="select-rg" class="narrow-select"><option value="">全ての地方</option><option value="rgn01">北海道</option><option value="rgn02">東北</option><option value="rgn04">関東</option><option value="rgn05">甲信越</option><option value="rgn06">北陸</option><option value="rgn07">東海</option><option value="rgn08">関西</option><option value="rgn09">山陰・山陽</option><option value="rgn10">四国</option><option value="rgn11">九州</option><option value="rgn12">沖縄</option></select>
        <select name="pr" id="select-pr" class="narrow-select" disabled="disabled"><option value="">全ての都道府県</option></select>
        <select name="ar" id="select-ar" class="narrow-select" disabled="disabled"><option value="">全てのエリア</option></select>
        <select name="smallAreas" id="select-smallAreas" class="narrow-select" disabled="disabled"><option value="">全ての小エリア</option></select>
      </div>
    </div>
  </div>

  <div class="menu3" id="menu3">
    <div class="inner">
      <b class="heading">ジャンル</b>
      <div class="input-wrap">
        <select name="ct" id="select-ct" class="narrow-select"><option value="">全てのカテゴリ</option><option value="1">空</option><option value="2">川・滝</option><option value="3">海</option><option value="4">湖・池</option><option value="5">山・自然</option><option value="6">乗り物</option><option value="7">観光・レジャー</option><option value="8">スポーツ・フィットネス</option><option value="9">雪</option><option value="10">ものづくり・クラフト</option><option value="11">日本文化</option><option value="12">サブカルチャー</option><option value="13">テクノロジー</option><option value="14">スポーツ・フィットネス</option><option value="15">日本文化</option><option value="16">料理・お酒</option><option value="17">ものづくり・クラフト</option><option value="18">花・ガーデニング</option></select>
        <select name="ac" id="select-ac" class="narrow-select" disabled="disabled"><option value="">全てのジャンル</option></select>
      </div>
    </div>
  </div>

  <div class="menu4" id="menu4">
    <div class="inner">
      <b class="heading">人数</b>
      <div class="input-wrap">
        <label><input type="number" name="priceper_num" min="1" max="9999" value="" id="number-of-people"> 人</label>
      </div>
    </div>
  </div>

  <div class="menu5" id="menu5">
    <div class="">
      <b class="">さらに詳しく</b>
      <div class="">

        <div class="">
          <b class="">キーワード</b>
          <div class=""><input type="text" name="free" size="20" value=""></div>
        </div>

        <div class="">
          <b class="">予算</b>
          <div class="">
		<select name="">
			<option value="">指定なし</option>
			<option value="1000">\1,000以内</option>
			<option value="2000">\2,000以内</option>
			<option value="3000">\3,000以内</option>
			<option value="4000">\4,000以内</option>
			<option value="5000">\5,000以内</option>
			<option value="6000">\6,000以内</option>
			<option value="8000">\8,000以内</option>
			<option value="10000">\10,000以内</option>
			<option value="15000">\15,000以内</option>
			<option value="20000">\20,000以内</option>
			<option value="30000">\30,000以内</option>
			<option value="40000">\40,000以内</option>
			<option value="50000">\50,000以内</option>
		</select>
	</div>
      </div>


      <div class="">
          <b class="">対象年齢</b>
          <div class="">
		<select name="">
			<option value="">指定なし</option>
			<option value="0">0歳以上</option>
			<option value="1">1歳以上</option>
			<option value="2">2歳以上</option>
			<option value="3">3歳以上</option>
			<option value="4">4歳以上</option>
			<option value="5">5歳以上</option>
			<option value="6">6歳以上</option>
			<option value="7">7歳以上</option>
			<option value="8">8歳以上</option>
			<option value="9">9歳以上</option>
			<option value="10">10歳以上</option>
			<option value="11">11歳以上</option>
			<option value="12">12歳以上</option>
			<option value="13">13歳以上</option>
			<option value="14">14歳以上</option>
			<option value="15">15歳以上</option>
			<option value="16">16歳以上</option>
			<option value="17">17歳以上</option>
			<option value="18">18歳以上</option>
			<option value="50">50歳以上</option>
			<option value="60">60歳以上</option>
		</select>
	</div>
        </div>
        <div class="more-column-3">
          <b class="sub-heading">所要時間</b>
          <div class="input-wrap"><select name="timeRequired"><option value="">指定なし</option><option value="30">30分以内</option><option value="60">1時間以内</option><option value="90">1時間30分以内</option><option value="120">2時間以内</option><option value="180">3時間以内</option><option value="240">4時間以内</option><option value="360">6時間以内</option><option value="1440">1日以内</option><option value="2880">2日以内</option></select></div>
        </div>
      </div>
        <div class="">
            <div class="more-column-12">
              <b class="sub-heading">利用シーン</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="tg" value="6">1人参加可</label><label class="multiple-option"><input type="checkbox" name="tg" value="13">こどもとおでかけ</label><label class="multiple-option"><input type="checkbox" name="tg" value="14">デート</label><label class="multiple-option"><input type="checkbox" name="tg" value="15">記念日</label><label class="multiple-option"><input type="checkbox" name="tg" value="16">女子会・女子旅</label><label class="multiple-option"><input type="checkbox" name="tg" value="17">夜景</label><label class="multiple-option"><input type="checkbox" name="tg" value="18">雨の日</label><label class="multiple-option"><input type="checkbox" name="tg" value="23">3000円以下</label></div>
            </div>
            <div class="more-column-12">
              <b class="sub-heading">支払い方法</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="tg" value="11">現地払い</label><label class="multiple-option"><input type="checkbox" name="tg" value="12">事前払い</label></div>
            </div>
            <div class="more-column-12">
              <b class="sub-heading">団体予約</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="tg" value="19">10人以上</label><label class="multiple-option"><input type="checkbox" name="tg" value="20">20人以上</label><label class="multiple-option"><input type="checkbox" name="tg" value="21">30人以上</label><label class="multiple-option"><input type="checkbox" name="tg" value="22">100人以上</label></div>
            </div>
            <div class="more-column-12">
              <b class="sub-heading">サービス</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="tg" value="1">食事付</label><label class="multiple-option"><input type="checkbox" name="tg" value="2">送迎付</label><label class="multiple-option"><input type="checkbox" name="tg" value="3">ガイド同行</label><label class="multiple-option"><input type="checkbox" name="tg" value="7">ペット参加可</label><label class="multiple-option"><input type="checkbox" name="tg" value="8">貸切可</label><label class="multiple-option"><input type="checkbox" name="tg" value="29">料金割引</label><label class="multiple-option"><input type="checkbox" name="tg" value="30">ライセンス</label><label class="multiple-option"><input type="checkbox" name="tg" value="31">保険</label><label class="multiple-option"><input type="checkbox" name="tg" value="32">レンタル</label><label class="multiple-option"><input type="checkbox" name="tg" value="33">初心者OK</label></div>
            </div>
            <div class="more-column-12">
              <b class="sub-heading">空間・設備</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="amenities" value="1">シャワー</label><label class="multiple-option"><input type="checkbox" name="amenities" value="2">トイレ</label><label class="multiple-option"><input type="checkbox" name="amenities" value="3">ドライヤー</label><label class="multiple-option"><input type="checkbox" name="amenities" value="4">ロッカー</label><label class="multiple-option"><input type="checkbox" name="amenities" value="5">売店</label><label class="multiple-option"><input type="checkbox" name="amenities" value="6">更衣室</label><label class="multiple-option"><input type="checkbox" name="amenities" value="7">貴重品預かり</label></div>
            </div>
            <div class="more-column-12">
              <b class="sub-heading">駐車場あり</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="accesses" value="1">有料駐車場</label><label class="multiple-option"><input type="checkbox" name="accesses" value="2">無料駐車場</label></div>
            </div>
            <div class="more-column-12">
              <b class="sub-heading">日程</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="tg" value="9">午前</label><label class="multiple-option"><input type="checkbox" name="tg" value="10">午後</label></div>
            </div>
            <div class="more-column-12">
              <b class="sub-heading">シーズン</b>
              <div class="input-wrap"><label class="multiple-option"><input type="checkbox" name="tg" value="24">オールシーズン</label><label class="multiple-option"><input type="checkbox" name="tg" value="25">春</label><label class="multiple-option"><input type="checkbox" name="tg" value="26">夏</label><label class="multiple-option"><input type="checkbox" name="tg" value="27">秋</label><label class="multiple-option"><input type="checkbox" name="tg" value="28">冬</label></div>
            </div>
        </div>
      </div>
  </div>
</div>

</div>

</form></div>

      <div class="">
          <div class="search-result">
              <h2 class="result-title">検索結果一覧</h2>

		<script type="text/javascript">
		    function ordertype_submit(ordertype){
		    	$("input[name='orderdata']").val(ordertype);
		    	document.frmResearch.submit();
			}
		</script>
              <p class="result-sort">表示順序：</p>
		<input type="hidden" name="orderdata" value="" />
              <ul class="result-sort-change">
                  <li><a href="javascript: ordertype_submit(0);">新着順</a></li>
                  <li><a href="javascript: ordertype_submit(1);">料金が安い順</a></li>
                  <li><a href="javascript: ordertype_submit(2);">料金が高い順</a></li>
              </ul>

  	  	<?php $scope = $pager->getOffsetByPageId()?>
    		<p class="result-count"><?php print $shop->getMaxCount()?> 件中 <?php print $scope['0']?>～<?php print $scope['1']?>件</p>

           </div>

<ul class="search-result">

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
        <!--item-->
		<?php //print_r($plandata);?>







    <li class="plan-result">

	    <div class="plan-title">




	      <h2>
      				<?php $formplan = "frm".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
		        	<form action="plan-detail.html" method="post" id="<?php print $formplan?>" name="<?php print $formplan?>">
						<?php /*<span class="new">NEW</span>*/?><a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><?php print $plandata["SHOPPLAN_NAME"]?></a>
		            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
		            	<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
		            	<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
		            	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
		                    	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
		            	<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
		            	<?php print $inputs->hidden("calender_mon", $plandata["money_all"])?>
		        	</form>
	      </h2>
	    </div>
	    　　<p class="plan-shop">
	        	<?php $formshop = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
		        <form action="plan-detail.html" method="post" id="<?php print $formshop?>" name="<?php print $formshop?>">
			<a href="javascript:void(0)" onclick="document.<?php print $formshop?>.submit();"><h3><?php print $plandata["SHOP_NAME"]?></a></h3>
	            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	            	<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
	            	<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
	            	<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
	            	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
	            	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
	            	<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
			</form>
		</p>

	      	<div class="plan-img">
      				<?php $formplan = "frm".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
		        	<form action="plan-detail.html" method="post" id="<?php print $formplan?>" name="<?php print $formplan?>">
		            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
		            	<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
		            	<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
		            	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
		                    	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
		            	<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
		            	<?php print $inputs->hidden("calender_mon", $plandata["money_all"])?>

		                <?php if ($plandata["SHOPPLAN_PIC1"] != "" || $plandata["SHOPPLAN_PIC1"] != "") {?>
					<a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><img src="<?php print URL_SLAKER_COMMON."/images/".$plandata["SHOPPLAN_PIC1"]?>" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
				<?php }else{?>
					<a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
				<?php }?>
		        	</form>

		        <p>催行期間:<?php $fromDate = cmDateDivide($plandata["SHOPPLAN_SALE_FROM"])?>
      			<?php $toDate = cmDateDivide($plandata["SHOPPLAN_SALE_TO"])?>
      			<?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?>～<?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?>
			</p>
		</div>

	     <div class="plan-contena">
	        <ul class="plan-tag">
	          <li class="">グループ・団体向け</li>
	          <li class="">子供参加可</li>
	          <li class="">午後</li>
	          <li class="">現地払い</li>
	          <li class="">雨の日</li>
	          <li class="">オールシーズン</li>
	          </ul>
	        <div class="plan-address">
	            <p><span></span> 東京都中央区銀座5-10-1プリンスビル3階(サンプル)</p>
	        </div>
		        <p class="plan-disc"><?php print cmStrimWidth($plandata["SHOPPLAN_DISCRIPTION"], 0, 272, '…')?></p>
	      </div>

	      <div class="plan-etc">
		        <div class="plan-price">
		          <span class=""><span class="price"><?php print number_format($plandata["money_all"])?></span>円<span class="tax">(税込)～</span></span>
		        </div>
		        <div class="plan-calender">
　　　　　		　<p>空き状況(サンプル)</p>
		          <ul>
		            <li class="">
		                <span class="day">12/26</span><br>
		                <span class="week">月</span><br>
		                <span class="prov">〇</span></li>
		            <li class="">
		                <span class="day">12/27</span><br>
		                <span class="week">火</span><br>
		                <span class="prov">▲</span></li>
		            <li class="">
		                <span class="day">12/28</span><br>
		                <span class="week">水</span><br>
		                <span class="prov">×</span></li>
		            </ul>
		        </div>
			<div class="plan-btn">

		          <a href="javascript:void(0)" onclick="">詳しく見る</a>


			</div>
	       </div>
    </li>

                <!--/item-->
	        <?php }?>
        <?php }?>

</ul>


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
