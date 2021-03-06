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

if($_POST){
	$collection->setPost();
	cmSetHotelSearchDef($collection);
		//	$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
}
else {
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["cid"]);

	$collection->setByKey($collection->getKeyValue(), "priceper_num", $_GET["num"]);
	$collection->setByKey($collection->getKeyValue(), "usetime", $_GET["ut"]);
	$collection->setByKey($collection->getKeyValue(), "price", $_GET["pr"]);
	$collection->setByKey($collection->getKeyValue(), "age", $_GET["age"]);
	$collection->setByKey($collection->getKeyValue(), "facility", $_GET["fa"]);

	$collection->setByKey($collection->getKeyValue(), "area", $_GET["area"]);
	$collection->setByKey($collection->getKeyValue(), "category", $_GET["cate"]);
	$collection->setByKey($collection->getKeyValue(), "tag", $_GET["tag"]);
	
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
	  	if($_GET["undecide_sch"] != ""){
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
			//$collection->setByKey($collection->getKeyValue(), "undecide_sch", $_GET["undecide_sch"]);
	  	}
	 	else{
			//$collection->setByKey($collection->getKeyValue(), "undecide_sch", "2");
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
		}
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y???m???d???'));
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
	if($_GET["calender"] != ""){
		$collection->setByKey($collection->getKeyValue(), "calender", $_GET["cal"]);
	}
	else {
	}

	cmSetHotelSearchDef($collection);
}






$collection->setByKey($collection->getKeyValue(), "pageNum", 10);

//print_r($collection);

//	??????????????????
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

//	?????????????????????
$targetId = "";

$shop = new shop($dbMaster);
$shop->selectListPublicPlan($collection);


//print($shop->getMaxCount());









//??????
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
		//??????????????????????????????
		for ($i=1; $i<=$count_spi; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $data["SHOPPLAN_ID"]);
//				$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $data["ROOM_ID".$i]);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOP_PRICETYPE_ID", $data["SHOP_PRICETYPE_ID".$i]);
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
				//??????????????????
				$search_collection->setByKey($search_collection->getKeyValue(), "undecide_sch", 1);
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

					if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
						//	????????????

						$room_sch = $shop->selectMoneyEveryRoomUndecideSch($search_collection);	

						// ???????????????????????????????????????????????????
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
		//????????????????????????
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

// ordertype???????????????????????????
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
	$shop->setErrorFirst("??????????????????????????????????????????????????????");
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
//	??????????????????
$pager_options = array(
		'mode'       => 'Jumping', // ???????????????(Jumping/Sliding)
		'perPage'    => $perpage,        // ????????????????????????????????????
		'totalItems' => $shop->getMaxCount(),   // ???????????????????????????????????????
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '<span class="prev">??????</span>',
		'nextImg'=> '<span class="next">??????</span>',
		'extraVars'  =>$page_post
);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();
?>




<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta_detail.php"); ?>
<title>??????????????? ??? <?php print SITE_PUBLIC_NAME?></title>
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
	$(document).click(function() {???$(".menu1, .menu2, .menu3, .menu4, .menu5").hide();???});
	$(".menu1, .menu2, .menu3, .menu4, .menu5").click(function() {???event.stopPropagation();???});
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
        <li><span>????????????</span></li>
    </ul>

<div class="">

   <div class="">

   <!-- side nav -->
    <div id="left">
	<div class="inner">
  
      <section class="accordion">
        <h4 class="search-title" >?????????????????????<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
        <ul class="nest">
		  <li>
              <p class="link">
                <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                 <a href="/plan-search.html?area=11">?????????</a>
              </p>
          </li>  
          
          <li>
              <p class="link">   
				  <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                  <a href="/plan-search.html?area=10">??????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">  
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>   
                  <a href="/plan-search.html?area=9">??????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">    
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                  <a href="/plan-search.html?area=8">?????????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">    
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                  <a href="/plan-search.html?area=7">??????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">  
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                  <a href="/plan-search.html?area=6">??????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">   
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                  <a href="/plan-search.html?area=5">??????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">  
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>  
                  <a href="/plan-search.html?area=4">???????????????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">   
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                  <a href="/plan-search.html?area=3">??????</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">    
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                  <a href="/plan-search.html?area=2">??????(6790)</a>
              </p>
          </li>
            
          
          <li>
              <p class="link">   
                 <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>  
                  <a href="/plan-search.html?area=1">??????</a>
              </p>
          </li>
        </ul>
      </section>
      
      
      <section class="accordion">
        <h4 class="search-title">????????????????????????<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
        <ul class="nest">

	<?php// foreach($mActivityCategory->getCollection() as $ac){?>
          <li>
              <p class="link">  
                    <i class="fa fa-caret-right fa-1 listtop" aria-hidden="true"></i>
                     <a href="/plan-search.html?cate=1">?????????????????????</a>
                 </p>
          </li>
        </ul>
      </section>


   <form name="search-side-list" id="search-side-list" method="POST" action="/plan-search.html">
      <section class="accordion">
      <h4 class="search-title">???????????????????????????<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
      <ul class="nest">
        <input type="hidden" name="search_date" value="">
        <li class="title"><label for="priceper_num">??????</label></li>
        	<li class=""><input type="number" name="priceper_num" min="1" max="999" value="" id="priceper_num">???</li>
        <li class="title"><label for="price">??????</label></li>
			<li class="">
				<select name="price">
				<option value="">????????????</option>
				<option value="1000">\1,000??????</option>
				<option value="2000">\2,000??????</option>
				<option value="3000">\3,000??????</option>
				<option value="4000">\4,000??????</option>
				<option value="5000">\5,000??????</option>
				<option value="6000">\6,000??????</option>
				<option value="8000">\8,000??????</option>
				<option value="10000">\10,000??????</option>
				<option value="15000">\15,000??????</option>
				<option value="20000">\20,000??????</option>
				<option value="30000">\30,000??????</option>
				<option value="40000">\40,000??????</option>
				<option value="50000">\50,000??????</option>
				</select>
			</li>
        <li class="title"><label for="targetAge">????????????</label></li>
        <li class="">
        	<select name="targetAge" id="targetAge" class="">
        		<option value="">????????????</option>
        		<option value="0">0?????????</option>
        		<option value="1">1?????????</option>
        		<option value="2">2?????????</option>
        		<option value="3">3?????????</option>
        		<option value="4">4?????????</option>
        		<option value="5">5?????????</option>
        		<option value="6">6?????????</option>
        		<option value="7">7?????????</option>
        		<option value="8">8?????????</option>
        		<option value="9">9?????????</option>
        		<option value="10">10?????????</option>
        		<option value="11">11?????????</option>
        		<option value="12">12?????????</option>
        		<option value="13">13?????????</option>
        		<option value="14">14?????????</option>
        		<option value="15">15?????????</option>
        		<option value="16">16?????????</option>
        		<option value="17">17?????????</option>
        		<option value="18">18?????????</option>
        		<option value="50">50?????????</option>
        		<option value="60">60?????????</option>
        	</select>
        </li>
        <li class="title"><label for="usetime">????????????</label></li>
        	<li class="">
        		<select name="usetime" id="usetime" class="">
        			<option value="">????????????</option>
        			<option value="30">30?????????</option>
        			<option value="60">1????????????</option>
        			<option value="90">1??????30?????????</option>
        			<option value="120">2????????????</option>
        			<option value="180">3????????????</option>
        			<option value="240">4????????????</option>
        			<option value="360">6????????????</option>
        			<option value="1440">1?????????</option>
        			<option value="2880">2?????????</option>
				</select>
       		</li>
        <li class="btn">
            <div class="btn_submit"><input type="submit" value="?????????????????????" onclick="document.search-side-list.submit();" class="search-list-btn"></div>
        </li>
      </ul>
      </section>
      
      
      <section class="accordion">
        <h4 class="search-title">????????????????????????<a class="toggle"><i class="fa fa-arrow-circle-down fa-2" aria-hidden="true"></i></a></h4>
        <ul class="nest">
           
            <li class="subtitle">???????????????</li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="6" id="tag6"> 1????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="13" id="tag13"> ????????????????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="14" id="tag14"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="15" id="tag15"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="16" id="tag16"> ?????????????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="17" id="tag17"> ??????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="18" id="tag18"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="23" id="tag23"> 3000?????????</label>
              </li>
              
            <li class="subtitle">???????????????</li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="11" id="tag11"> ????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="12" id="tag12"> ????????????</label>
              </li>
              
            <li class="subtitle">????????????</li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="19" id="tag19"> 10?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="20" id="tag20"> 20?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="21" id="tag21"> 30?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="22" id="tag22"> 100?????????</label>
              </li>
              
            <li class="subtitle">????????????</li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="1" id="tag1"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="2" id="tag2"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="3" id="tag3"> ???????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="7" id="tag7"> ??????????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="8" id="tag8"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="29" id="tag29"> ????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="30" id="tag30"> ???????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="31" id="tag31"> ??????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="32" id="tag32"> ????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="33" id="tag33"> ?????????OK</label>
              </li>
              
            <li class="subtitle">???????????????</li>
              <li class="check">
                <label><input type="checkbox" name="facility" value="1" id="facility1"> ????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="facility" value="2" id="facility2"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="facility" value="3" id="facility3"> ???????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="facility" value="4" id="facility4"> ????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="facility" value="5" id="facility5"> ??????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="facility" value="6" id="facility6"> ?????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="facility" value="7" id="facility7"> ??????????????????</label>
              </li>
            <li class="subtitle">???????????????</li>
              <li class="check">
                <label><input type="checkbox" name="access" value="1" id="access1"> ???????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="access" value="2" id="access2"> ???????????????</label>
              </li>
              
            <li class="subtitle">??????</li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="9" id="tag9"> ??????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="10" id="tag10"> ??????</label>
              </li>
              
            <li class="subtitle">????????????</li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="24" id="tag24"> ?????????????????????</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="25" id="tag25"> ???</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="26" id="tag26"> ???</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="27" id="tag27"> ???</label>
              </li>
              <li class="check">
                <label><input type="checkbox" name="tag" value="28" id="tag28"> ???</label>
              </li>
          <li class="btn">
            <div class="btn_submit"><input type="submit" value="???????????????????????????" onclick="document.search-side-list.submit();" class="search-list-btn"></div>
          </li>
        </ul>
      </section>
 
	</div>
</form>
</div>




    <!--<div class="banner_area">
    	<a href="" class=""><img class="" src="" alt=""></a>
??????</div>-->
<div id="right">
	
	<?php if($_GET["cate"] != ""){

		$searchCategory = new mActivityCategory($dbMaster);
		$searchCategory->select($_GET["cate"],"1");
	
		foreach($searchCategory as $category){
	?>
	
		<div class="category-result">
??????	 	<h1 class="title_def"><?php $category["M_ACT_CATEGORY_NAME"];?></h1>
      		<ul class="search-cate">
      			<li class="right">
					<div class="sub_img">
						<img src="http://common.playbooking.jp/images/1/SHOPPLAN_PIC1_201611141e2022285614ca8675b069558e412f2daed348dc.jpg">
					</div>
				</li>
				<li class="left">
					<p class="sub_text">
						<?php $category["M_ACT_CATEGORY_TEXT"];?>
					</p>					
				</li>
			</ul>
     	</div>
	<?php }}?>
	
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
							                       			dateFormat: 'yy???mm???dd???',
							                       			changeMonth: true,
							                       			changeYear: true,
							                       			yearRange: '2017:2027',
							                       			showMonthAfterYear: true,
							                       			monthNamesShort: ['1???','2???','3???','4???','5???','6???','7???','8???','9???','10???','11???','12???'],
							                                   dayNamesMin: ['???','???','???','???','???','???','???']
							                       		});
		  			</script>
	</li>
      	<li class="int_cross">??</li>
      <li class="box"><a href="#menu2">?????????</a></li>
      	<li class="int_cross">??</li>
      <li class="box"><a href="#menu3">???????????????</a></li>
      	<li class="int_cross">??</li>
      <li class="box"><a href="#menu4">??????</a></li>
      	<li class="int_cross">??</li>
      <li class="box"><a href="#menu5">??????????????????</a></li>
    </ul>
    <button class="search-change-btn" type="submit" onclick="document.search-change.submit();">?????????????????????</button>
  </div>

 
  <div class="menu2" id="menu2">
    <div class="inner">
      <b class="heading"><i class="fa fa-map-marker fa-1" aria-hidden="true"></i>????????????</b>
      <div class="search-wrap">
       <div class="sub-inner">
        <select name="a_top" id="a_top">
			<option value="">??????????????????</option>
			<option value="">?????????</option>
			<option value="">??????</option>
			<option value="">??????</option>
			<option value="">?????????</option>
			<option value="">??????</option>
			<option value="">??????</option>
			<option value="">??????</option>
			<option value="">???????????????</option>
			<option value="">??????</option>
			<option value="">??????</option>
			<option value="">??????</option>
        </select>
	  </div>
       <div class="sub-inner">
        <select name="a_parent" id="a_parent">
        	<option value="">?????????????????????</option>
        	<option value=""></option></select>
       	</div>
       <div class="sub-inner">
       	<select name="a_child" id="a_child">
        	<option value="">???????????????</option>
        	<option value=""></option></select>
	</div>
      </div>
    </div>
  </div>

  <div class="menu3" id="menu3">
    <div class="inner">
      <b class="heading"><i class="fa fa-star fa-1" aria-hidden="true"></i>???????????????</b>
      <div class="search-wrap">
        <select name="cate" id="cate">
        	<option value="">??????????????????????????????</option>
		</select>
        <select name="cate" id="cate">
        	<option value="">?????????????????????</option>
        </select>
        <select name="cate" id="cate">
        	<option value="">?????????????????????</option>
        </select>
        <select name="cate" id="cate">
        	<option value="">????????????????????????</option>
        </select>
      </div>
    </div>
  </div>

  <div class="menu4" id="menu4">
    <div class="inner">
      <b class="heading"><i class="fa fa-users fa-1" aria-hidden="true"></i>?????????</b>
      <div class="search-wrap">
        <label><input type="number" name="priceper_num" min="1" max="999" value="" id="priceper_num"> ???</label>
      </div>
    </div>
  </div>

  <div class="menu5" id="menu5">
    <div class="inner">
      <b class="heading"><i class="fa fa-asterisk fa-1" aria-hidden="true"></i>?????????????????????</b>
      <div class="search-wrap">

        <div class="sub-inner">
          <b class="sub-head">???????????????</b>
          <div class="sub-wrap"><input type="text" name="free" id="free" size="20" value=""></div>
        </div>

        <div class="sub-inner">
          <b class="sub-head">??????</b>
          <div class="sub-wrap">
		<select name="price" id="price">
			<option value="">????????????</option>
			<option value="1000">???1,000??????</option>
			<option value="2000">???2,000??????</option>
			<option value="3000">???3,000??????</option>
			<option value="4000">???4,000??????</option>
			<option value="5000">???5,000??????</option>
			<option value="6000">???6,000??????</option>
			<option value="8000">???8,000??????</option>
			<option value="10000">???10,000??????</option>
			<option value="15000">???15,000??????</option>
			<option value="20000">???20,000??????</option>
			<option value="30000">???30,000??????</option>
			<option value="40000">???40,000??????</option>
			<option value="50000">???50,000??????</option>
		</select>
	</div>
      </div>


      <div class="sub-inner">
          <b class="sub-head">????????????</b>
          <div class="sub-wrap">
		<select name="age" id="age">
			<option value="">????????????</option>
			<option value="0">0?????????</option>
			<option value="1">1?????????</option>
			<option value="2">2?????????</option>
			<option value="3">3?????????</option>
			<option value="4">4?????????</option>
			<option value="5">5?????????</option>
			<option value="6">6?????????</option>
			<option value="7">7?????????</option>
			<option value="8">8?????????</option>
			<option value="9">9?????????</option>
			<option value="10">10?????????</option>
			<option value="11">11?????????</option>
			<option value="12">12?????????</option>
			<option value="13">13?????????</option>
			<option value="14">14?????????</option>
			<option value="15">15?????????</option>
			<option value="16">16?????????</option>
			<option value="17">17?????????</option>
			<option value="18">18?????????</option>
			<option value="50">50?????????</option>
			<option value="60">60?????????</option>
		</select>
	</div>
        </div>
        <div class="sub-inner">
          <b class="sub-head">????????????</b>
          <div class="sub-wrap">
          <select name="usetime" id="usetime">
          	<option value="">????????????</option>
          	<option value="30">30?????????</option>
          	<option value="60">1????????????</option>
          	<option value="90">1??????30?????????</option>
          	<option value="120">2????????????</option>
          	<option value="180">3????????????</option>
          	<option value="240">4????????????</option>
          	<option value="360">6????????????</option>
          	<option value="1440">1?????????</option>
          	<option value="2880">2?????????</option>
          </select>
          </div>
        </div>
      </div>
        <div class="sub-inner">
              <b class="sub-head">???????????????</b>
              <div class="sub-wrap">
				  <label class="multiple-option"><input type="checkbox" name="tag" value="6">1????????????</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="13">????????????????????????</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="14">?????????</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="15">?????????</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="16">?????????????????????</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="17">??????</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="18">?????????</label>
				  <label class="multiple-option"><input type="checkbox" name="tag" value="23">3000?????????</label>
              </div>
              <b class="sub-head">???????????????</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="11">????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="12">????????????</label>
              </div>

              <b class="sub-head">????????????</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="19">10?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="20">20?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="21">30?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="22">100?????????</label>
              </div>
              <b class="sub-head">????????????</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="1">?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="2">?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="3">???????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="7">??????????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="8">?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="29">????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="30">???????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="31">??????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="32">????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="33">?????????OK</label>
              </div>
              <b class="sub-head">???????????????</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="facility" value="1">????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="2">?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="3">???????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="4">????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="5">??????</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="6">?????????</label>
              	<label class="multiple-option"><input type="checkbox" name="facility" value="7">??????????????????</label>
             </div>
             <b class="sub-head">???????????????</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="access" value="1">???????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="access" value="2">???????????????</label>
             ???</div>
              <b class="sub-head">??????</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="9">??????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="10">??????</label>
???             </div>
              <b class="sub-head">????????????</b>
              <div class="sub-wrap">
              	<label class="multiple-option"><input type="checkbox" name="tag" value="24">?????????????????????</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="25">???</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="26">???</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="27">???</label>
              	<label class="multiple-option"><input type="checkbox" name="tag" value="28">???</label>
             </div>
            </div>
            </div>
        </div>
      </div>
</div>

</form>

      <div class="">
        <div class="search-result sort_list">
          <h2 class="result-title">??????????????????</h2>

		<script type="text/javascript">
		    function ordertype_submit(ordertype){
		    	$("input[name='orderdata']").val(ordertype);
		    	document.frmResearch.submit();
			}
		</script>
          <p class="result-sort">???????????????</p>
		<input type="hidden" name="orderdata" value="" />
          <ul class="result-sort-change">
                  <li><a href="javascript: ordertype_submit(0);">?????????</a></li>
                  <li><a href="javascript: ordertype_submit(1);">??????????????????</a></li>
                  <li><a href="javascript: ordertype_submit(2);">??????????????????</a></li>
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
						<?php print $fromDate["y"]."???".$fromDate["m"]."???".$fromDate["d"]."???"?>???<?php print $toDate["y"]."???".$toDate["m"]."???".$toDate["d"]."???"?>??????
					</p>
			</div>

			<div class="plan-contena">
				
				<!--	<ul class="category">
					  <li class="">???????????????????????????</li>
					  <li class="">???????????????</li>
					  <li class="">??????</li>
					  <li class="">????????????</li>
					</ul>
				-->
	
					<ul class="tag">
					  <li class="">???????????????????????????</li>
					  <li class="">???????????????</li>
					  <li class="">??????</li>
					  <li class="">????????????</li>
					  <li class="">?????????</li>
					  <li class="">?????????????????????</li>
					</ul>

					<p class="plan-disc"><?php print cmStrimWidth($plandata["SHOPPLAN_DISCRIPTION"], 0, 272, '???')?></p>

					<div class="box_detail">
						<div class="plan-address">
							<p><i class="fa fa-map-marker fa-1" aria-hidden="true"></i> ????????????????????????5-10-1??????????????????3???(????????????)</p>
						</div>
						<ul>
							<li>
								<p>
									??????????????????1????????????
								</p>
							</li>
							<li>
								<p>
									??????????????????1????????????
								</p>
							</li>
							<li>
								<p>
									??????????????????1????????????
								</p>
							</li>
						</ul>
					</div>
					<ul class="box_submit">
						<li class="plan-price">
									  <span class=""><span class="price"><?php print number_format($plandata["money_all"])?></span>???<span class="tax">(??????)???</span></span>
						</li>
						<li class="plan-btn">
									  <a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();">???????????????</a>
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
			 <li class="prev"><a href="#">??????</a></li>
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
			 <li class="next"><a href="#">??????</a></li>
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
