<?php
var_dump($_POST);

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

if($_POST){
	$collection->setPost();
	cmSetHotelSearchDef($collection);
		//	$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
}
else {
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["cid"]);

	$collection->setByKey($collection->getKeyValue(), "priceper_num", $_GET["num"]);
	$collection->setByKey($collection->getKeyValue(), "usetime", $_GET["usetime"]);
	$collection->setByKey($collection->getKeyValue(), "price", $_GET["price"]);
	$collection->setByKey($collection->getKeyValue(), "age", $_GET["age"]);
	$collection->setByKey($collection->getKeyValue(), "facility", $_GET["fa"]);

	// <<<<< add settenLab
	$collection->setByKey($collection->getKeyValue(), "top_area_id", $_GET["ta"]);
	$collection->setByKey($collection->getKeyValue(), "top_category_id", $_GET["tc"]);
	// >>>>> add settenLab
	
	$collection->setByKey($collection->getKeyValue(), "area", $_GET["area"]);
	$collection->setByKey($collection->getKeyValue(), "category", $_GET["cate"]);
	$collection->setByKey($collection->getKeyValue(), "tag", $_GET["tag"]);
	
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
	  	if($_GET["undecide_sch"] != ""){
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", $_GET["undecide_sch"]);
	  	}
	 	else{
			//$collection->setByKey($collection->getKeyValue(), "undecide_sch", "2");
// 			$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
		}
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y年m月d日'));
// 		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
	if($_GET["calender"] != ""){
		$collection->setByKey($collection->getKeyValue(), "calender", $_GET["calender"]);
	}
	else {
	}

	cmSetHotelSearchDef($collection);
}

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

//print($shop->getMaxCount());

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

// <<<<< add settenLab

// TOPエリア取得
$mAreaTop = new mArea($dbMaster);
$mAreaTop->selectTop();
$mAreaTop->setPost();

$arrAreaTopData = $mAreaTop->getCollection();
$arrAreaTop     = array();
$arrAreaPlanCnt = array();
// 配列生成
foreach($arrAreaTopData as $top_data){
	$arrAreaTop[$top_data['M_AREA_ID']] = $top_data['M_AREA_NAME'];
	$arrAreaPlanCnt[$top_data['M_AREA_ID']] = 0;
}

// エリア別プラン数取得
$mAreaTopPlan       = new mArea($dbMaster);
$arrAreaTopPlanData = $mAreaTopPlan->selectTopAreaPlanCnt();
// 配列生成
foreach($arrAreaTopPlanData as $plan_data){
	$arrAreaPlanCnt[$plan_data['area_id']] = $plan_data['cnt'];
}


// ジャンル(TOPカテゴリ)取得
$arrTopCategoryData = $mActivityCategory->getCollection();
$arrTopCategory     = array();
$arrCategoryPlanCnt = array();
// 配列作成
foreach($arrTopCategoryData as $cat_data){
	// TOPカテゴリのみ
	if($cat_data['M_ACT_CATEGORY_TYPE'] == 1){
		$arrTopCategory[$cat_data['M_ACT_CATEGORY_ID']] = $cat_data['M_ACT_CATEGORY_NAME'];
		$arrCategoryPlanCnt[$cat_data['M_ACT_CATEGORY_ID']] = 0;
	}
}

// カテゴリ別プラン数取得
$arrCategoryPlanData = $mAreaTopPlan->selectTopCategoryPlanCnt();
// 配列生成
foreach($arrCategoryPlanData as $plan_data){
	$arrCategoryPlanCnt[$plan_data['category_id']] = $plan_data['cnt'];
}

// プルダウンoption配列
$arrPrice   = array(1000,2000,3000,4000,5000,6000,8000,10000,15000,20000,30000,40000,50000);
$arrAge     = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,50,60);
$arrUseTime = array(
				array('val' => 30, 'label' => "30分以内")
				,array('val' => 60, 'label' => "1時間以内")
				,array('val' => 90, 'label' => "1時間30分以内")
				,array('val' => 120, 'label' => "2時間以内")
				,array('val' => 180, 'label' => "3時間以内")
				,array('val' => 240, 'label' => "4時間以内")
				,array('val' => 360, 'label' => "6時間以内")
				,array('val' => 1440, 'label' => "1日以内")
				,array('val' => 2880, 'label' => "2日以内")
			);

// >>>>> add settenLab
?>




<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta_detail.php"); ?>
<title>プラン検索 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="//playbooking.jp/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//playbooking.jp/js/jquery-ui-1.10.3.custom.min.js"></script>

<script type="text/javascript"> 

// Menu
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



// ACCORDION
$(function() {
    function accordion() {
        $(this).toggleClass("active").next().slideToggle(300);
    }
    $(".accordion .toggle").click(accordion);
});




</script>




</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="content" class="search">

    <ul id="panlist">
        <li><a href="/">TOP</a></li>
        <li><span>検索結果</span></li>
    </ul>

<div class="">

   <div class="">

   <!-- side nav -->
    <div id="left">
	<div class="inner">
	
	<section class="accordion">
		<h4 class="search-title" >エリアから探す<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
		<?php if(count($arrAreaTop) > 0):?>
			<ul class="nest">
				<?php foreach($arrAreaTop as $area_id => $area_name):?>
					<li>
						<p class="link">
							<i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
							<a href="/plan-search.html?ta=<?php echo $area_id; ?>"><?php echo $area_name; ?>(<?php echo $arrAreaPlanCnt[$area_id]; ?>)</a>
						</p>
					</li>
				<?php endforeach;?>
			</ul>
		<?php endif?>
	</section>
			
	<section class="accordion">
		<h4 class="search-title">ジャンルから探す<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
		<?php if(count($arrTopCategory) > 0):?>
			<ul class="nest">
				<?php foreach($arrTopCategory as $category_id => $category_name):?>
					<li>
						<p class="link">
							<i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
							<a href="/plan-search.html?tc=<?php echo $category_id; ?>"><?php echo $category_name; ?>(<?php echo $arrCategoryPlanCnt[$category_id]; ?>)</a>
						</p>
					</li>
				<?php endforeach;?>
			</ul>
		<?php endif;?>
	</section>


	<form name="search_side_list" id="search_side_list" method="POST" action="/plan-search.html">
		<input type="hidden" name="search_date" value="<?php print $collection->getByKey($collection->getKeyValue(), "search_date");?>">
		<section class="accordion">
			<h4 class="search-title">希望・予算から探す<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
			<ul class="nest">
				<li class="title"><label for="priceper_num">人数</label></li>
				<li class=""><input type="number" name="priceper_num" min="1" max="999" value="<?php echo $collection->getByKey($collection->getKeyValue(), "priceper_num");?>" id="priceper_num">人</li>
				<li class="title"><label for="price">予算</label></li>
					<li class="">
						<select name="price">
						<option value="">指定なし</option>
						<?php
							$price = $collection->getByKey($collection->getKeyValue(), "price");
							foreach($arrPrice as $p){
								$selected = ($price != "" && $p == $price)?"selected='selected'":"";
								echo "<option value='".$p."' ".$selected.">&yen;".number_format($p)."以内</option>";
							}
						?>
						</select>
					</li>
				<li class="title"><label for="targetAge">対象年齢</label></li>
				<li class="">
					<select name="targetAge" id="targetAge" class="">
						<option value="">指定なし</option>
						<?php
							$targetAge = $collection->getByKey($collection->getKeyValue(), "targetAge");
							foreach($arrAge as $age){
								$selected = ($targetAge != "" && $age == $targetAge)?"selected='selected'":"";
								echo "<option value='".$age."' ".$selected.">".$age."歳以上</option>";
							}
						?>
					</select>
				</li>
				<li class="title"><label for="usetime">所要時間</label></li>
					<li class="">
						<select name="usetime" id="usetime" class="">
							<option value="">指定なし</option>
							<?php
								$usetime = $collection->getByKey($collection->getKeyValue(), "usetime");
								foreach($arrUseTime as $time){
									$selected = ($usetime != "" && $time['val'] == $usetime)?"selected='selected'":"";
									echo "<option value='".$time['val']."' ".$selected.">".$time['label']."</option>";
								}
							?>
						</select>
					</li>
				<li class="btn">
					<div class="btn_submit"><input type="button" value="この条件で検索" onclick="document.search_side_list.submit();" class="search-list-btn"></div>
				</li>
			</ul>
		</section>
		
		<section class="accordion">
			<h4 class="search-title">詳細条件から探す<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
			<ul class="nest">
				 
				<li class="subtitle">利用シーン</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="6" id="tag6"> 1人参加可</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="13" id="tag13"> こどもとおでかけ</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="14" id="tag14"> デート</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="15" id="tag15"> 記念日</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="16" id="tag16"> 女子会・女子旅</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="17" id="tag17"> 夜景</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="18" id="tag18"> 雨の日</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="23" id="tag23"> 3000円以下</label>
					</li>
					
				<li class="subtitle">支払い方法</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="11" id="tag11"> 現地払い</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="12" id="tag12"> 事前払い</label>
					</li>
					
				<li class="subtitle">団体予約</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="19" id="tag19"> 10人以上</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="20" id="tag20"> 20人以上</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="21" id="tag21"> 30人以上</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="22" id="tag22"> 100人以上</label>
					</li>
					
				<li class="subtitle">サービス</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="1" id="tag1"> 食事付</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="2" id="tag2"> 送迎付</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="3" id="tag3"> ガイド同行</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="7" id="tag7"> ペット参加可</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="8" id="tag8"> 貸切可</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="29" id="tag29"> 料金割引</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="30" id="tag30"> ライセンス</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="31" id="tag31"> 保険</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="32" id="tag32"> レンタル</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="33" id="tag33"> 初心者OK</label>
					</li>
					
				<li class="subtitle">空間・設備</li>
					<li class="check">
						<label><input type="checkbox" name="facility" value="1" id="facility1"> シャワー</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="facility" value="2" id="facility2"> トイレ</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="facility" value="3" id="facility3"> ドライヤー</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="facility" value="4" id="facility4"> ロッカー</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="facility" value="5" id="facility5"> 売店</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="facility" value="6" id="facility6"> 更衣室</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="facility" value="7" id="facility7"> 貴重品預かり</label>
					</li>
				<li class="subtitle">駐車場あり</li>
					<li class="check">
						<label><input type="checkbox" name="access" value="1" id="access1"> 有料駐車場</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="access" value="2" id="access2"> 無料駐車場</label>
					</li>
					
				<li class="subtitle">日程</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="9" id="tag9"> 午前</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="10" id="tag10"> 午後</label>
					</li>
					
				<li class="subtitle">シーズン</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="24" id="tag24"> オールシーズン</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="25" id="tag25"> 春</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="26" id="tag26"> 夏</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="27" id="tag27"> 秋</label>
					</li>
					<li class="check">
						<label><input type="checkbox" name="tag" value="28" id="tag28"> 冬</label>
					</li>
				<li class="btn">
					<div class="btn_submit"><input type="button" value="この条件で検索する" onclick="document.search_side_list.submit();" class="search-list-btn"></div>
				</li>
			</ul>
		</section>
	</form>
	</div>
</div>




    <!--<div class="banner_area">
    	<a href="" class=""><img class="" src="" alt=""></a>
　　</div>-->
<div id="right">
		<div class="category-result">
　　	 	<h1 class="title_def">カテゴリー指定</h1>
      		<ul class="search-cate">
      			<li class="right">
					<div class="sub_img">
						<img src="http://common.playbooking.jp/images/1/SHOPPLAN_PIC1_201611141e2022285614ca8675b069558e412f2daed348dc.jpg">
					</div>
				</li>
				<li class="left">
					<p class="sub_text">
						テキストテキストテキストテキスト
					</p>					
				</li>
			</ul>
     	</div>
     	
<div class="search-result">
  	
    		<form name="search-change" id="search-change" method="POST" action="/plan-search.html?area=<?php print $collection->getByKey($collection->getKeyValue(), "area");?>&cate=<?php print $collection->getByKey($collection->getKeyValue(), "category");?>&num=<?php print $collection->getByKey($collection->getKeyValue(), "priceper_num");?>&search_date=<?php print $collection->getByKey($collection->getKeyValue(), "search_date");?>&undicide_sch=<?php print $collection->getByKey($collection->getKeyValue(), "undicide_sch");?>">
	<div class="">
  

  <div class="search-change-box">
    <ul class="search-menu">
      <li class="box">
	       	<input type="text" id="search_date" name="search_date" value="<?php print $collection->getByKey($collection->getKeyValue(), "search_date");?>" class="imeDisabled" />
			       	<script type="text/javascript">
							                       $.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
							                        $("#search_date").datepicker(
							                        		{
												numberOfMonths: 2,
							                       			dateFormat: 'yy年mm月dd日',
							                       			changeMonth: true,
							                       			changeYear: true,
							                       			yearRange: '2017:2027',
							                       			showMonthAfterYear: true,
							                       			monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
							                                   dayNamesMin: ['日','月','火','水','木','金','土']
							                       		});
		  			</script>
	</li>
      	<li class="int_cross">×</li>
      <li class="box"><a href="#menu2">エリア</a></li>
      	<li class="int_cross">×</li>
      <li class="box"><a href="#menu3">カテゴリー</a></li>
      	<li class="int_cross">×</li>
      <li class="box"><a href="#menu4">人数</a></li>
      	<li class="int_cross">×</li>
      <li class="box"><a href="#menu5">さらに詳しく</a></li>
    </ul>
    <button class="search-change-btn" type="submit" onclick="document.search-change.submit();">この条件で検索</button>
  </div>

 
  <div class="menu2" id="menu2">
    <div class="inner">
      <b class="heading"><i class="fa fa-map-marker fa-1" aria-hidden="true"></i>　エリア</b>
      <div class="search-wrap">
       <div class="sub-inner">
        <select name="a_top" id="a_top">
			<option value="">全てのエリア</option>
			<option value="">北海道</option>
			<option value="">東北</option>
			<option value="">関東</option>
			<option value="">甲信越</option>
			<option value="">北陸</option>
			<option value="">東海</option>
			<option value="">関西</option>
			<option value="">山陰・山陽</option>
			<option value="">四国</option>
			<option value="">九州</option>
			<option value="">沖縄</option>
        </select>
	  </div>
       <div class="sub-inner">
        <select name="a_parent" id="a_parent">
        	<option value="">全ての都道府県</option>
        	<option value=""></option></select>
       	</div>
       <div class="sub-inner">
       	<select name="a_child" id="a_child">
        	<option value="">全ての地域</option>
        	<option value=""></option></select>
	</div>
      </div>
    </div>
  </div>

  <div class="menu3" id="menu3">
    <div class="inner">
      <b class="heading"><i class="fa fa-star fa-1" aria-hidden="true"></i>　ジャンル</b>
      <div class="search-wrap">
        <select name="cate" id="cate">
        	<option value="">全てのマリンレジャー</option>
		</select>
        <select name="cate" id="cate">
        	<option value="">全てのカテゴリ</option>
        </select>
        <select name="cate" id="cate">
        	<option value="">全てのジャンル</option>
        </select>
        <select name="cate" id="cate">
        	<option value="">全ての小ジャンル</option>
        </select>
      </div>
    </div>
  </div>

  <div class="menu4" id="menu4">
    <div class="inner">
      <b class="heading"><i class="fa fa-users fa-1" aria-hidden="true"></i>　人数</b>
      <div class="search-wrap">
        <label><input type="number" name="priceper_num" min="1" max="999" value="" id="priceper_num"> 人</label>
      </div>
    </div>
  </div>

  <div class="menu5" id="menu5">
    <div class="inner">
      <b class="heading"><i class="fa fa-asterisk fa-1" aria-hidden="true"></i>　さらに詳しく</b>
      <div class="search-wrap">

        <div class="sub-inner">
          <b class="sub-head">キーワード</b>
          <div class="sub-wrap"><input type="text" name="free" id="free" size="20" value=""></div>
        </div>

        <div class="sub-inner">
          <b class="sub-head">予算</b>
          <div class="sub-wrap">
		<select name="price" id="price">
			<option value="">指定なし</option>
			<option value="1000">￥1,000以内</option>
			<option value="2000">￥2,000以内</option>
			<option value="3000">￥3,000以内</option>
			<option value="4000">￥4,000以内</option>
			<option value="5000">￥5,000以内</option>
			<option value="6000">￥6,000以内</option>
			<option value="8000">￥8,000以内</option>
			<option value="10000">￥10,000以内</option>
			<option value="15000">￥15,000以内</option>
			<option value="20000">￥20,000以内</option>
			<option value="30000">￥30,000以内</option>
			<option value="40000">￥40,000以内</option>
			<option value="50000">￥50,000以内</option>
		</select>
	</div>
      </div>


      <div class="sub-inner">
          <b class="sub-head">対象年齢</b>
          <div class="sub-wrap">
		<select name="age" id="age">
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
        <div class="sub-inner">
          <b class="sub-head">所要時間</b>
          <div class="sub-wrap">
          <select name="usetime" id="usetime">
          	<option value="">指定なし</option>
          	<option value="30">30分以内</option>
          	<option value="60">1時間以内</option>
          	<option value="90">1時間30分以内</option>
          	<option value="120">2時間以内</option>
          	<option value="180">3時間以内</option>
          	<option value="240">4時間以内</option>
          	<option value="360">6時間以内</option>
          	<option value="1440">1日以内</option>
          	<option value="2880">2日以内</option>
          </select>
          </div>
        </div>
      </div>
        <div class="sub-inner">
              <b class="sub-head">利用シーン</b>
              <div class="sub-wrap">
				  <label class="multiple-option"><input type="checkbox" name="tag" value="6">1人参加可</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="13">こどもとおでかけ</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="14">デート</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="15">記念日</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="16">女子会・女子旅</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="17">夜景</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="18">雨の日</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="23">3000円以下</label>
              </div>
              <b class="sub-head">支払い方法</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="11">現地払い</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="12">事前払い</label>
              </div>

              <b class="sub-head">団体予約</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="19">10人以上</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="20">20人以上</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="21">30人以上</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="22">100人以上</label>
              </div>
              <b class="sub-head">サービス</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="1">食事付</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="2">送迎付</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="3">ガイド同行</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="7">ペット参加可</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="8">貸切可</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="29">料金割引</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="30">ライセンス</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="31">保険</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="32">レンタル</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="33">初心者OK</label>
              </div>
              <b class="sub-head">空間・設備</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="facility" value="1">シャワー</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="2">トイレ</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="3">ドライヤー</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="4">ロッカー</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="5">売店</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="6">更衣室</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="7">貴重品預かり</label>
             </div>
             <b class="sub-head">駐車場あり</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="access" value="1">有料駐車場</label>
              	<label class="multiple-option"><input type="checkbox" name="access" value="2">無料駐車場</label>
             　</div>
              <b class="sub-head">日程</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="9">午前</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="10">午後</label>
　             </div>
              <b class="sub-head">シーズン</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="24">オールシーズン</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="25">春</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="26">夏</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="27">秋</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="28">冬</label>
             </div>
            </div>
            </div>
        </div>
      </div>
</div>

</form>

      <div class="">
        <div class="search-result sort_list">
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
          </div>

<ul class="search-result">

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
        <!--item-->
		<?php //print_r($plandata);?>

    <li class="plan-result">

    	<div class="inner">
			<div class="plan-title">
			  <h2 class="title_search">
						<?php $formplan = "frm".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
						<form action="plan-detail.html?cid=<?php print $plandata["COMPANY_ID"];?>&pid=<?php print $plandata["SHOPPLAN_ID"];?>&num=<?php print $collection->getByKey($collection->getKeyValue(), "priceper_num");?>" method="post" id="<?php print $formplan?>" name="<?php print $formplan?>">
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
		  
			<div class="plan-shop">
					<?php $formshop = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
					<form action="plan-detail.html?cid=<?php print $plandata["COMPANY_ID"];?>&pid=<?php print $plandata["SHOPPLAN_ID"];?>&num=<?php print $collection->getByKey($collection->getKeyValue(), "priceper_num");?>" method="post" id="<?php print $formshop?>" name="<?php print $formshop?>">
					<h3><a href="javascript:void(0)" onclick="document.<?php print $formshop?>.submit();"><?php print $plandata["SHOP_NAME"]?></a></h3>
						<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
						<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
						<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
						<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
						<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
						<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
						<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
					</form>
			</div>

			<div class="plan-img">
					<?php if ($plandata["SHOPPLAN_PIC1"] != "" || $plandata["SHOPPLAN_PIC1"] != "") {?>
						<a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><img src="<?php print URL_SLAKER_COMMON."/images/".$plandata["SHOPPLAN_PIC1"]?>" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
					<?php }else{?>
						<a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
					<?php }?>

					<p><?php $fromDate = cmDateDivide($plandata["SHOPPLAN_SALE_FROM"])?>
						<?php $toDate = cmDateDivide($plandata["SHOPPLAN_SALE_TO"])?>
						<?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?>～<?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?>まで
					</p>
			</div>

			<div class="plan-contena">
				
				<!--	<ul class="category">
					  <li class="">グループ・団体向け</li>
					  <li class="">子供参加可</li>
					  <li class="">午後</li>
					  <li class="">現地払い</li>
					</ul>
				-->
	
					<ul class="tag">
					  <li class="">グループ・団体向け</li>
					  <li class="">子供参加可</li>
					  <li class="">午後</li>
					  <li class="">現地払い</li>
					  <li class="">雨の日</li>
					  <li class="">オールシーズン</li>
					</ul>

					<p class="plan-disc"><?php print cmStrimWidth($plandata["SHOPPLAN_DISCRIPTION"], 0, 272, '…')?></p>

					<div class="box_detail">
						<div class="plan-address">
							<p><i class="fa fa-map-marker fa-1" aria-hidden="true"></i> 東京都中央区銀座5-10-1プリンスビル3階(サンプル)</p>
						</div>
						<ul>
							<li>
								<p>
									【所要時間】1時間半～
								</p>
							</li>
							<li>
								<p>
									【対象年齢】1時間半～
								</p>
							</li>
							<li>
								<p>
									【催行人数】1時間半～
								</p>
							</li>
						</ul>
					</div>
					<ul class="box_submit">
						<li class="plan-price">
									  <span class=""><span class="price"><?php print number_format($plandata["money_all"])?></span>円<span class="tax">(税込)～</span></span>
						</li>
						<li class="plan-btn">
									  <a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();">詳しく見る</a>
						</li>
					</ul>
  			 </div>
		</div>
    </li>

                <!--/item-->
	        <?php }?>
        <?php }?>

</ul>


        <?php if ($navi["back"] != "" or $navi["next"] != "") {?>
        <ul class="navigation-se clearfix">
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
		
		
		<div class="nav_cont">
		 <ul class="navigation-se">
			 <li class="prev"><a href="#">前へ</a></li>
			<li class="current">1</li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#">7</a></li>
            <li><a href="#">8</a></li>
            <li><a href="#">9</a></li>
            <li><a href="#">10</a></li>
			 <li class="next"><a href="#">次へ</a></li>
        </ul>
	   </div>
</div>
</div>



  </div>
</div>
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
