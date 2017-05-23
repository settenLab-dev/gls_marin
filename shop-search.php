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

// $collection->setByKey($collection->getKeyValue(), "pageNum", 10);

//print_r($collection);

//	ページャ設定
// 表示件数
$perpage = $collection->getByKey($collection->getKeyValue(), "pageNum");
if(empty($perpage)){
	$perpage = 10;
}
// 現在のページ
$page = $collection->getByKey($collection->getKeyValue(), "pageID");
if(empty($page)){
	$page = 1;
}
$currentPage = 0;
if (!cmCheckNull($page) or !cmCheckPtn($page, CHK_PTN_NUM) or $page <= 0) {
	$currentPage = 0;
} else {
	$currentPage = $page-1;
}

$limit = ($currentPage * $perpage).",".$perpage;
var_dump($limit);
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
		$dspArray[$planCnt]["COMPANY_ID"]         = $data["COMPANY_ID"];
		$dspArray[$planCnt]["SHOP_ID"]            = $data["SHOP_ID"];
		$dspArray[$planCnt]["SHOP_NAME"]          = $data["SHOP_NAME"];
		$dspArray[$planCnt]["SHOP_ADDRESS"]       = $data["SHOP_ADDRESS"];
		
		$dspArray[$planCnt]["SHOPPLAN_ID"]        = $data["SHOPPLAN_ID"];
		$dspArray[$planCnt]["SHOPPLAN_NAME"]      = $data["SHOPPLAN_NAME"];
		$dspArray[$planCnt]["SHOPPLAN_PIC1"]      = $data["SHOPPLAN_PIC1"];
		$dspArray[$planCnt]["SHOPPLAN_SALE_FROM"] = $data["SHOPPLAN_SALE_FROM"];
		$dspArray[$planCnt]["SHOPPLAN_SALE_TO"]   = $data["SHOPPLAN_SALE_TO"];

		$dspArray[$planCnt]["SHOPPLAN_DISCRIPTION"] = $data["SHOPPLAN_DISCRIPTION"];
		
		$dspArray[$planCnt]["SHOPPLAN_AGE_FROM"]    = $data["SHOPPLAN_AGE_FROM"];
		$dspArray[$planCnt]["SHOPPLAN_DEPARTS_MIN"] = $data["SHOPPLAN_DEPARTS_MIN"];
		$dspArray[$planCnt]["SHOPPLAN_ALL_TIME"]    = $data["SHOPPLAN_ALL_TIME"];

		$dspArray[$planCnt]["SHOP_LIST_AREA"]      = $data["SHOP_LIST_AREA"];
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
		'mode'       => 'Jumping',              // 表示タイプ(Jumping/Sliding)
		'perPage'    => $perpage,               // 一ページ内で表示する件数
		'totalItems' => $shop->getMaxCount(),   // ページング対象データの総数
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '<span class="prev">前へ</span>',
		'nextImg'=> '<span class="next">次へ</span>',
// 		'extraVars'  =>$page_post
);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();

// <<<<< add settenLab

$shopTarget = new shop($dbMaster);
$shopTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

// TOPエリア取得
$mAreaTop = new mArea($dbMaster);
$mAreaTop->selectTop();
$mAreaTop->setPost();

// 親エリア取得
$mAreaParent = new mArea($dbMaster);
$mAreaParent->selectParent();
$mAreaParent->setPost();

// 子エリア取得
$mAreaChild = new mArea($dbMaster);
$mAreaChild->selectChild();
$mAreaChild->setPost();

// エリア配列の作成
// TOP
$arrAreaTopData = $mAreaTop->getCollection();
$arrAreaTop     = array();
$arrAreaPlanCnt = array();

foreach($arrAreaTopData as $top_data){
	$arrAreaTop[$top_data['M_AREA_ID']] = $top_data['M_AREA_NAME'];
	$arrAreaPlanCnt[$top_data['M_AREA_ID']] = 0;
}

// 親
$arrAreaParentData = $mAreaParent->getCollection();
$arrAreaParent = array();
foreach($arrAreaParentData as $parent_data){
	$arrAreaParent[$parent_data['M_AREA_ID']] = $parent_data['M_AREA_NAME'];
}

// 子
$arrAreaChildData = $mAreaChild->getCollection();
$arrAreaChild = array();
foreach($arrAreaChildData as $child_data){
	$arrAreaChild[$child_data['M_AREA_ID']] = $child_data['M_AREA_NAME'];
}

// プルダウン用配列作成
// TOP
$arrPullAreaTop = array();
foreach($arrAreaTopData as $top_data){
	// 沖縄限定
// 	if($area_child['M_AREA_ID'] == 1){
		$arrPullAreaTop[] = $top_data;
// 	}
}
// 親
$arrPullAreaParent = array();
foreach($arrAreaParentData as $parent_data){
	// 沖縄限定
// 	if($area_child['M_AREA_ID'] == 14){
		$arrPullAreaParent[] = $parent_data;
// 	}
}
// 子
$arrPullAreaChild = array();
foreach($arrAreaChildData as $area_child){
	// 沖縄限定
// 	if($area_child['M_AREA_PARENT'] == 14){
		$arrPullAreaChild[] = $area_child;
// 	}
}

// エリア別プラン数取得
$mAreaTopPlan       = new mArea($dbMaster);
$arrAreaTopPlanData = $mAreaTopPlan->selectTopAreaPlanCnt();
// エリア別プラン数配列生成
foreach($arrAreaTopPlanData as $plan_data){
	$arrAreaPlanCnt[$plan_data['area_id']] = $plan_data['cnt'];
}


// カテゴリ取得
$arrTopCategoryData = $mActivityCategory->getCollection();
// 詳細カテゴリ取得
$arrDetailCategoryData = $mActivityCategoryDetail->getCollection();

$arrTopCategory       = array();
$arrParentCategory    = array();
$arrChildCategory     = array();
$arrDetailCategory    = array();

$arrCategoryPlanCnt = array();

// カテゴリ配列作成
foreach($arrTopCategoryData as $cat_data){
	// TOPカテゴリ
	if($cat_data['M_ACT_CATEGORY_TYPE'] == 1){
		$arrTopCategory[$cat_data['M_ACT_CATEGORY_ID']] = $cat_data['M_ACT_CATEGORY_NAME'];
		$arrCategoryPlanCnt[$cat_data['M_ACT_CATEGORY_ID']] = 0;
	}
	// 親カテゴリ
	if($cat_data['M_ACT_CATEGORY_TYPE'] == 2){
		$arrParentCategory[$cat_data['M_ACT_CATEGORY_ID']] = $cat_data['M_ACT_CATEGORY_NAME'];
	}
	// 子カテゴリ
	if($cat_data['M_ACT_CATEGORY_TYPE'] == 3){
		$arrChildCategory[$cat_data['M_ACT_CATEGORY_ID']] = $cat_data['M_ACT_CATEGORY_NAME'];
	}
}

// 詳細カテゴリ配列作成
foreach($arrDetailCategoryData as $cat_data){
	// 詳細カテゴリ
	$arrDetailCategory[$cat_data['M_ACT_CATEGORY_D_ID']] = $cat_data['M_ACT_CATEGORY_D_NAME'];
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

// タグ取得
$arrTagData     = $mTag->getCollection();
$arrListTagData = array();
// タグ配列作成
foreach($arrTagData as $data){
	$arrTagData[$data['M_TAG_ID']] = $data["M_TAG_NAME"];
}
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
				<li><a href="plan-search.html">検索結果</a></li>
				<li><span>プラン一覧</span></li>
		</ul>
		
		<!-- ショップ詳細 -->
		<article id="detail_plan">
		
			<!-- ショップメニュー -->
			<?php $company_id = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"); ?>
			<section id="detail_menu">
				<ul>
					<li>
						<a href="/shop-detail.html?cid=<?php echo $company_id; ?>">ショップ情報</a>
					</li>
					<li class="current">
						<a href="/shop-search.html?cid=<?php echo $company_id; ?>">プラン一覧</a>
					</li>
					<!-- 
					<li>
						<a href="/shop-report.html?cid=<?php echo $company_id; ?>">レポート</a>
					</li>
					 -->
					<li>
						<a href="/shop-gallery.html?cid=<?php echo $company_id; ?>">写真・動画</a>
					</li>
					<li>
						<a href="/shop-map.html?cid=<?php echo $company_id; ?>">地図・アクセス</a>
					</li>
					<!-- 
					<li>
						<a href="/shop-etc.html?cid=<?php echo $company_id; ?>">その他</a>
					</li>
					 -->
				</ul>
			</section>
			<!-- /ショップメニュー -->
		
			
			<section id="plan_name">
				<h1><?php echo $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME"); ?></h1>
			</section>
			
		</article><!-- /#detail_plan -->
		
		<div class="">
		
			<div class="">
			
				<div id="right" class="shop">
				
					<div class="search-result">
							
						<form name="frmSearchChange" id="frmSearchChange" method="POST" action="/shop-search.html">
							<input type="hidden" name="orderdata" value="<?php echo $collection->getByKey($collection->getKeyValue(), "orderdata"); ?>" >
							<input type="hidden" name="pageID" value="<?php echo $collection->getByKey($collection->getKeyValue(), "pageID"); ?>" >
							<input type="hidden" name="COMPANY_ID" value="<?php echo $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"); ?>" >
							
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
														}
													);
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
									<button class="search-change-btn" type="submit" onclick="setPage(1);document.frmSearchChange.submit();">この条件で検索</button>
								</div>
						
								<div class="menu2" id="menu2">
									<div class="inner">
										<b class="heading"><i class="fa fa-map-marker fa-1" aria-hidden="true"></i>　エリア</b>
										<div class="search-wrap">
											<div class="sub-inner">
												<select name="top_area_id" id="">
													<option value="">全てのエリア</option>
													<?php if (count($arrPullAreaTop) > 0) {?>
														<?php $top_area_id = $collection->getByKey($collection->getKeyValue(), "top_area_id");?>
														<?php foreach ($arrPullAreaTop as $data): ?>
															<?php $selected = ($top_area_id == $data["M_AREA_ID"])?" selected='selected' ":""; ?>
															<option value="<?php echo $data["M_AREA_ID"]; ?>" <?php echo $selected; ?>><?php echo $data["M_AREA_NAME"]; ?></option>
														<?php endforeach; ?>
													<?php }?>
												</select>
											</div>
											<div class="sub-inner">
												<select name="parent_area_id" id="">
													<option value="">全ての都道府県</option>
													<?php if (count($arrPullAreaParent) > 0) {?>
														<?php $parent_area_id = $collection->getByKey($collection->getKeyValue(), "parent_area_id");?>
														<?php foreach ($arrPullAreaParent as $data): ?>
															<?php $selected = ($parent_area_id == $data["M_AREA_ID"])?" selected='selected' ":""; ?>
															<option value="<?php echo $data["M_AREA_ID"]; ?>" <?php echo $selected; ?>><?php echo $data["M_AREA_NAME"]; ?></option>
														<?php endforeach; ?>
													<?php }?>
												</select>
											</div>
											<div class="sub-inner">
												<select name="child_area_id" id="">
													<option value="">全ての地域</option>
													<?php if (count($arrPullAreaChild) > 0) {?>
														<?php $child_area_id = $collection->getByKey($collection->getKeyValue(), "child_area_id");?>
														<?php foreach ($arrPullAreaChild as $data): ?>
															<?php $selected = ($child_area_id == $data["M_AREA_ID"])?" selected='selected' ":""; ?>
															<option value="<?php echo $data["M_AREA_ID"]; ?>" <?php echo $selected; ?>><?php echo $data["M_AREA_NAME"]; ?></option>
														<?php endforeach; ?>
													<?php }?>
												</select>
											</div>
										</div>
									</div>
								</div>
						
								<div class="menu3" id="menu3">
									<div class="inner">
										<b class="heading"><i class="fa fa-star fa-1" aria-hidden="true"></i>　ジャンル</b>
										<div class="search-wrap">
											<select name="top_category_id" id="">
												<option value="">全てのマリンレジャー</option>
												<?php if (count($arrTopCategory) > 0) {?>
													<?php $top_category_id = $collection->getByKey($collection->getKeyValue(), "top_category_id");?>
													<?php foreach ($arrTopCategory as $category_id => $category_name): ?>
														<?php $selected = ($top_category_id == $category_id)?" selected='selected' ":""; ?>
														<option value="<?php echo $category_id; ?>" <?php echo $selected; ?>><?php echo $category_name; ?></option>
													<?php endforeach; ?>
												<?php }?>
											</select>
											<select name="parent_category_id" id="">
												<option value="">全てのカテゴリ</option>
												<?php if (count($arrParentCategory) > 0) {?>
													<?php $parent_category_id = $collection->getByKey($collection->getKeyValue(), "parent_category_id");?>
													<?php foreach ($arrParentCategory as $category_id => $category_name): ?>
														<?php $selected = ($parent_category_id == $category_id)?" selected='selected' ":""; ?>
														<option value="<?php echo $category_id; ?>" <?php echo $selected; ?>><?php echo $category_name; ?></option>
													<?php endforeach; ?>
												<?php }?>
											</select>
											<select name="child_category_id" id="">
												<option value="">全てのジャンル</option>
												<?php if (count($arrChildCategory) > 0) {?>
													<?php $child_category_id = $collection->getByKey($collection->getKeyValue(), "child_category_id");?>
													<?php foreach ($arrChildCategory as $category_id => $category_name): ?>
														<?php $selected = ($child_category_id == $category_id)?" selected='selected' ":""; ?>
														<option value="<?php echo $category_id; ?>" <?php echo $selected; ?>><?php echo $category_name; ?></option>
													<?php endforeach; ?>
												<?php }?>
											</select>
											<select name="detail_category_id" id="">
												<option value="">全ての小ジャンル</option>
												<?php if (count($arrDetailCategory) > 0) {?>
													<?php $detail_category_id = $collection->getByKey($collection->getKeyValue(), "detail_category_id");?>
													<?php foreach ($arrDetailCategory as $category_id => $category_name): ?>
														<?php $selected = ($detail_category_id == $category_id)?" selected='selected' ":""; ?>
														<option value="<?php echo $category_id; ?>" <?php echo $selected; ?>><?php echo $category_name; ?></option>
													<?php endforeach; ?>
												<?php }?>
											</select>
										</div>
									</div>
								</div>
						
								<div class="menu4" id="menu4">
									<div class="inner">
										<b class="heading"><i class="fa fa-users fa-1" aria-hidden="true"></i>　人数</b>
										<div class="search-wrap">
											<label><input type="number" name="priceper_num" min="1" max="999"  value="<?php echo $collection->getByKey($collection->getKeyValue(), "priceper_num");?>" id=""> 人</label>
										</div>
									</div>
								</div>
						
								<div class="menu5" id="menu5">
									<div class="inner">
										<b class="heading"><i class="fa fa-asterisk fa-1" aria-hidden="true"></i>　さらに詳しく</b>
										<div class="search-wrap">
							
											<div class="sub-inner">
												<b class="sub-head">キーワード</b>
												<div class="sub-wrap"><input type="text" name="free" id="free" size="20" value="<?php echo $collection->getByKey($collection->getKeyValue(), "free");?>"></div>
											</div>
							
											<div class="sub-inner">
												<b class="sub-head">予算</b>
												<div class="sub-wrap">
													<select name="price" id="">
														<option value="">指定なし</option>
														<?php
															$price = $collection->getByKey($collection->getKeyValue(), "price");
															foreach($arrPrice as $p){
																$selected = ($price != "" && $p == $price)?"selected='selected'":"";
																echo "<option value='".$p."' ".$selected.">&yen;".number_format($p)."以内</option>";
															}
														?>
													</select>
												</div>
											</div>
											<div class="sub-inner">
												<b class="sub-head">対象年齢</b>
												<div class="sub-wrap">
													<select name="targetAge" id="">
														<option value="">指定なし</option>
														<?php
															$targetAge = $collection->getByKey($collection->getKeyValue(), "targetAge");
															foreach($arrAge as $age){
																$selected = ($targetAge != "" && $age == $targetAge)?"selected='selected'":"";
																echo "<option value='".$age."' ".$selected.">".$age."歳以上</option>";
															}
														?>
													</select>
												</div>
											</div>
											<div class="sub-inner">
												<b class="sub-head">所要時間</b>
												<div class="sub-wrap">
													<select name="usetime" id="usetime">
														<option value="">指定なし</option>
														<?php
															$usetime = $collection->getByKey($collection->getKeyValue(), "usetime");
															foreach($arrUseTime as $time){
																$selected = ($usetime != "" && $time['val'] == $usetime)?"selected='selected'":"";
																echo "<option value='".$time['val']."' ".$selected.">".$time['label']."</option>";
															}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="sub-inner">
											<b class="sub-head">利用シーン</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="1" id="tag1" <?php if(in_array(1, $arrTag)) echo "checked='checked'"; ?>> 1人参加可</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="2" id="tag2" <?php if(in_array(2, $arrTag)) echo "checked='checked'"; ?>> こどもとおでかけ</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="8" id="tag8" <?php if(in_array(8, $arrTag)) echo "checked='checked'"; ?>> デート</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="7" id="tag7" <?php if(in_array(7, $arrTag)) echo "checked='checked'"; ?>> 記念日</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="9" id="tag9" <?php if(in_array(9, $arrTag)) echo "checked='checked'"; ?>> 女子会・女子旅</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="10" id="tag10" <?php if(in_array(10, $arrTag)) echo "checked='checked'"; ?>> 夜景</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="4" id="tag4" <?php if(in_array(4, $arrTag)) echo "checked='checked'"; ?>> 雨の日</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(0, $arrTag)) echo "checked='checked'"; ?>> 3000円以下</label>
											</div>
											<b class="sub-head">支払い方法</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="pay[]" value="11" id="tag11" <?php if(in_array(11, $arrPay)) echo "checked='checked'"; ?>> 現地払い</label>
												<label class="multiple-option"><input type="checkbox" name="pay[]" value="12" id="tag12" <?php if(in_array(12, $arrPay)) echo "checked='checked'"; ?>> 事前払い</label>
											</div>
											<!-- 
											<b class="sub-head">団体予約</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(0, $arrTag)) echo "checked='checked'"; ?>> 10人以上</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(0, $arrTag)) echo "checked='checked'"; ?>> 20人以上</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(0, $arrTag)) echo "checked='checked'"; ?>> 30人以上</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(0, $arrTag)) echo "checked='checked'"; ?>> 100人以上</label>
											</div>
											 -->
											<b class="sub-head">サービス</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="16" id="tag16" <?php if(in_array(16, $arrTag)) echo "checked='checked'"; ?>> 食事付</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="15" id="tag15" <?php if(in_array(15, $arrTag)) echo "checked='checked'"; ?>> 送迎付</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="17" id="tag17" <?php if(in_array(17, $arrTag)) echo "checked='checked'"; ?>> ガイド同行</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="18" id="tag18" <?php if(in_array(18, $arrTag)) echo "checked='checked'"; ?>> ペット参加可</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="12" id="tag12" <?php if(in_array(12, $arrTag)) echo "checked='checked'"; ?>> 貸切可</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="11" id="tag11" <?php if(in_array(11, $arrTag)) echo "checked='checked'"; ?>> 料金割引</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="13" id="tag13" <?php if(in_array(13, $arrTag)) echo "checked='checked'"; ?>> ライセンス</label>
												<label class="multiple-option"><input type="checkbox" name="insurance" value="1" id="insurance" <?php if($insurance == 1) echo "checked='checked'"; ?>> 保険</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="14" id="tag14" <?php if(in_array(14, $arrTag)) echo "checked='checked'"; ?>> レンタル</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="19" id="tag19" <?php if(in_array(19, $arrTag)) echo "checked='checked'"; ?>> 初心者OK</label>
											</div>
											<b class="sub-head">空間・設備</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="facility[]" value="1" id="facility1" <?php if(in_array(1, $arrFacility)) echo "checked='checked'"; ?>> シャワー</label>
												<label class="multiple-option"><input type="checkbox" name="facility[]" value="2" id="facility2" <?php if(in_array(2, $arrFacility)) echo "checked='checked'"; ?>> トイレ</label>
												<label class="multiple-option"><input type="checkbox" name="facility[]" value="3" id="facility3" <?php if(in_array(3, $arrFacility)) echo "checked='checked'"; ?>> ドライヤー</label>
												<label class="multiple-option"><input type="checkbox" name="facility[]" value="4" id="facility4" <?php if(in_array(4, $arrFacility)) echo "checked='checked'"; ?>> ロッカー</label>
												<label class="multiple-option"><input type="checkbox" name="facility[]" value="5" id="facility5" <?php if(in_array(5, $arrFacility)) echo "checked='checked'"; ?>> 売店</label>
												<label class="multiple-option"><input type="checkbox" name="facility[]" value="6" id="facility6" <?php if(in_array(6, $arrFacility)) echo "checked='checked'"; ?>> 更衣室</label>
												<label class="multiple-option"><input type="checkbox" name="facility[]" value="7" id="facility7" <?php if(in_array(7, $arrFacility)) echo "checked='checked'"; ?>> 貴重品預かり</label>
											</div>
											<b class="sub-head">駐車場あり</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="access[]" value="1" id="access1" <?php if(in_array(1, $arrAccess)) echo "checked='checked'"; ?>> 有料駐車場</label>
												<label class="multiple-option"><input type="checkbox" name="access[]" value="2" id="access2" <?php if(in_array(2, $arrAccess)) echo "checked='checked'"; ?>> 無料駐車場</label>
											</div>
											<b class="sub-head">日程</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="5" id="tag5" <?php if(in_array(5, $arrTag)) echo "checked='checked'"; ?>> 午前</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="6" id="tag6" <?php if(in_array(6, $arrTag)) echo "checked='checked'"; ?>> 午後</label>
											</div>
											<b class="sub-head">シーズン</b>
											<div class="sub-wrap">
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="3" id="tag3" <?php if(in_array(3, $arrTag)) echo "checked='checked'"; ?>> オールシーズン</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(999, $arrTag)) echo "checked='checked'"; ?>> 春</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(999, $arrTag)) echo "checked='checked'"; ?>> 夏</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(999, $arrTag)) echo "checked='checked'"; ?>> 秋</label>
												<label class="multiple-option"><input type="checkbox" name="tag[]" value="" id="" <?php if(in_array(999, $arrTag)) echo "checked='checked'"; ?>> 冬</label>
											</div>
										</div><!-- /.sub-inner -->
									</div><!-- /.inner -->
								</div><!-- /.menu5 -->
							</div>
						</form>
					</div><!-- /.search-result -->
				
					<div class="">
						<div class="search-result sort_list">
							<h2 class="result-title">「<?php echo $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME"); ?>」のプラン一覧</h2>
							<script type="text/javascript">
								function ordertype_submit(ordertype){
									$("input[name='orderdata']").val(ordertype);
									document.frmSearchChange.submit();
								}
							</script>
							<p class="result-sort">表示順序：</p>
							<ul class="result-sort-change">
								<li><a href="javascript: ordertype_submit(0);">新着順</a></li>
								<li><a href="javascript: ordertype_submit(1);">料金が安い順</a></li>
								<li><a href="javascript: ordertype_submit(2);">料金が高い順</a></li>
							</ul>
							<?php $scope = $pager->getOffsetByPageId()?>
						</div>
					
						<ul class="search-result">
						
							<?php if (count($dspArray) > 0): ?>
								<?php foreach ($dspArray as $plandata): ?>
								<?php //print_r($plandata);?>
								<!--item-->
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
										</div><!-- /.plan-title -->
										
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
										</div><!-- /.plan-shop -->
							
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
										</div><!-- /.plan-img -->
							
									<div class="plan-contena">
										
										<!--	<ul class="category">
												<li class="">グループ・団体向け</li>
												<li class="">子供参加可</li>
												<li class="">午後</li>
												<li class="">現地払い</li>
											</ul>
										-->
											<?php
												// 登録タグ表示
												$arrPlanTagData = array();
												$arrPlanTagData = explode(":", $plandata['SHOPPLAN_TAG_LIST']);
												$arrPlanTagData = array_values(array_filter($arrPlanTagData));
											?>
											<?php if(count($arrPlanTagData) > 0): ?>
												<ul class="tag">
													<?php foreach($arrPlanTagData as $tag_id): ?>
														<li class=''><?php echo $arrTagData[$tag_id];?></li>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>
						
											<p class="plan-disc"><?php echo cmStrimWidth($plandata["SHOPPLAN_DISCRIPTION"], 0, 272, '…');?></p>
						
											<div class="box_detail">
												<div class="plan-address">
													<p><i class="fa fa-map-marker fa-1" aria-hidden="true"></i> <?php echo $plandata['SHOP_ADDRESS']; ?></p>
												</div>
												<ul>
													<li>
														<p>
															【所要時間】<?php echo $plandata['SHOPPLAN_ALL_TIME']; ?>～
														</p>
													</li>
													<li>
														<p>
															【対象年齢】<?php echo $plandata['SHOPPLAN_AGE_FROM']; ?>歳～
														</p>
													</li>
													<li>
														<p>
															【催行人数】<?php echo $plandata['SHOPPLAN_DEPARTS_MIN']; ?>人～
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
										</div><!-- /.plan-contena -->
									</div><!-- /.inner -->
								</li>
								<!--/item-->
								<?php endforeach;?>
							<?php endif; ?>
						</ul>
					
						<!-- 
						<?php if ($navi["back"] != "" or $navi["next"] != "") {?>
							<ul class="navigation-se clearfix">
								<?php if ($navi["back"] != "") {?>
									<li class="prev"><?=$navi["back"]?> | </li>
								<?php }?>
								<?=$navi["pages"]?>
								<?php if ($navi["next"] != "") {?>
									<li class="next"><?=$navi["next"]?></li>
								<?php }?>
							</ul>
						<?php }?>
						-->
						
						<?php // ページネーション ?>
						<script type="text/javascript">
							function setPage(page){
								$("input[name='pageID']").val(page);
							}
							function page_submit(page){
								setPage (page);
								document.frmSearchChange.submit();
							}
						</script>
						<?php if($pager->numPages() > 1): ?>
							<?php
								$totalPage     = $pager->numPages();
								$currentPageID = $pager->getCurrentPageID();
								$nextPageID    = $pager->getNextPageID();
								$prevPageID    = $pager->getPreviousPageID();
							?>
							<div class="nav_cont">
								<ul class="navigation-se">
									<?php if(!empty($prevPageID)):?>
										<li class="prev"><a href="javascript:void(0);" onclick='page_submit(<?php echo $prevPageID;?>);return false;'>前へ</a></li>
									<?php endif;?>
									<?php 
										for($i = 1; $i <= $totalPage; $i++){
											if($currentPageID == $i){
												echo "<li class='current'>".$i."</li>";
											} else {
												echo "<li><a href='javascript:void(0);' onclick='page_submit(".$i.");return false;'>".$i."</a></li>";
											}
										}
									?>
									<?php if(!empty($nextPageID)):?>
										<li class="next"><a href="javascript:void(0);" onclick='page_submit(<?php echo $nextPageID;?>);return false;'>次へ</a></li>
									<?php endif;?>
								</ul>
							</div><!-- /.nav_cont -->
						<?php endif; ?>
					</div>
				</div><!-- /#right -->
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
