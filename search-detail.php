<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPicGroup.php');
require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();

//print_r($collection);exit;
//add for hotel_url
if(!$_POST){
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET['hid']);
	$collection->setByKey($collection->getKeyValue(), "undecide_sch", $_GET['undecide_sch']);
}

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

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

//	ホテル詳細
$hotelTarget = new hotel($dbMaster);
$hotelTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$hotelPicGroup = new hotelPicGroup($dbMaster);
$hotelPicGroup->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// echo 'a'.$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID");exit;
$inputsOnly = new inputs(true);
foreach ($hotelPic->getCollection() as $ad) {
	if ($ad["HOTELPICGROUP_ID"] > 0) {
		$hotelpics[6][$ad["HOTELPICGROUP_ID"]][]=$ad;
	}else{
		switch ($ad["HOTELPICGROUP_ID"]) {
			case -1:
				$hotelpics[1][]=$ad;
				//print "部屋";
				break;
			case -2:
				$hotelpics[2][]=$ad;
				//print "食事";
				break;
			case -3:
				$hotelpics[3][]=$ad;
				//print "館内施設";
				break;
			case -4:
				$hotelpics[4][]=$ad;
				//print "風景";
				break;
			case -5:
				$hotelpics[5][]=$ad;
				//print "その他";
				break;
		}
	}
}
// print_r($collection);exit;
// print_r($hotelPic->getCollection());exit;

$ar = cmGetPrefName();
$hotel_address  = $ar[$hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PREF")];
$hotel_address .= $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CITY");
$hotel_address .= $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ADDRESS");


$hotelPlanTarget = new hotelPlan($dbMaster);
$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
// print_r($hotelPlanTarget->getCollection());exit;

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$hotel = new hotel($dbMaster);
//	※プランを特定しない
$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", "");
$collection->setByKey($collection->getKeyValue(), "ROOM_ID", "");
$hotel->selectListPublicHotel($collection);

$planCnt = 0;
$dspArray = array();

$money_1 = "";
$money_all = "";

if ($hotel->getCount() > 0) {
	foreach ($hotel->getCollection() as $data) {
// 		if ($hotelRoom->getKeyValue() == $data["ROOM_ID"]) {
// 			continue;
// 		}
		$dspArray[$data["HOTELPLAN_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["COMPANY_LINK"] = $data["COMPANY_LINK"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_NAME"] = $data["HOTELPLAN_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTEL_PIC_APP"] = $data["HOTEL_PIC_APP"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_PIC"] = $data["HOTELPLAN_PIC"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_DATE_SALE_FROM"] = $data["HOTELPLAN_DATE_SALE_FROM"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_DATE_SALE_TO"] = $data["HOTELPLAN_DATE_SALE_TO"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_BF_FLG"] = $data["HOTELPLAN_BF_FLG"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_DN_FLG"] = $data["HOTELPLAN_DN_FLG"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_LN_FLG"] = $data["HOTELPLAN_LN_FLG"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_CHECKIN"] = $data["HOTELPLAN_CHECKIN"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_CHECKIN_LAST"] = $data["HOTELPLAN_CHECKIN_LAST"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_CHECKOUT"] = $data["HOTELPLAN_CHECKOUT"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_FEATURE"] = $data["HOTELPLAN_FEATURE"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_FLG_DAYUSE"] = $data["HOTELPLAN_FLG_DAYUSE"];
		$dspArray[$data["HOTELPLAN_ID"]]["HOTELPLAN_DISCOUNT"] = $data["HOTELPLAN_DISCOUNT"];

				
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
		
		if ($dspArray[$data["HOTELPLAN_ID"]]["money_all"] == "" or $dspArray[$data["HOTELPLAN_ID"]]["money_all"] > $data["money_all"]) {
			$dspArray[$data["HOTELPLAN_ID"]]["money_1"] = $room[$money_total_cid]["money_perperson"];
			$dspArray[$data["HOTELPLAN_ID"]]["money_all"] = $money_total[$money_total_cid];
		}

		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["money_1"] = $room[$money_total_cid]["money_perperson"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["money_all"] = $money_total_perroom;
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["point"] = $room[$money_total_cid]["point"];
		
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["COMPANY_LINK"] = $data["COMPANY_LINK"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_NAME"] = $data["ROOM_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_TYPE"] = $data["ROOM_TYPE"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_CAPACITY_TO"] = $data["ROOM_CAPACITY_TO"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_BREADTH"] = $data["ROOM_BREADTH"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_FEATURE_LIST3"] = $data["ROOM_FEATURE_LIST3"];

	}
}

// print_r($dspArray);
// print_r($hotelPlanTarget->getCollection());
// print_r($hotel->getCollection());

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


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotelTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();

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
		'prevImg'=> '前へ',
		'nextImg'=> '次へ',
		'separator'=>'|',
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
<title>ホテル情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="プラン,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="ホテルのプラン詳細のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="//cocotomo.net/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//cocotomo.net/js/jquery-ui-1.10.3.custom.min.js"></script>

<link rel="stylesheet" href="//cocotomo.net/common/css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="//cocotomo.net/common/js/popupwindow-1.6.js"></script>


<!-- Arquivos utilizados pelo jQuery lightBox plugin -->
    <!--<script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/jquery.js"></script>-->
  <script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/jquery.lightbox-0.5.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php print URL_PUBLIC?>css/jquery.lightbox-0.5.css" media="screen" />
    <!-- / fim dos arquivos utilizados pelo jQuery lightBox plugin -->
<script type="text/javascript">
$(function() {
	$('#lightboxes a').lightBox({fixedNavigation:true});
});
var pop;
function openChildSet() {
	<?php for ($i=1; $i<=6; $i++) {?>
	var num<?php print $i?> = $("#child_number<?php print $i?>").val();
	<?php }?>
	var rheight = 110 + (170*parseInt($("#room_number").val()));
	if (rheight > 620) {
		rheight = 620;
	}
	pop= new $pop('popchildset.php?num1='+num1+'&num2='+num2+'&num3='+num3+'&num4='+num4+'&num5='+num5+'&num6='+num6, { type:'iframe', title:'人数設定',effect:'normal',width:650,height:rheight,windowmode:false,resize: false } );
}
function setData() {
	pop.close();
}
</script>

<!--
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
})
</script>
 -->
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
var query = '<?= $hotel_address ?>';
var lon = '<?=$hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_LON")?>';
var lat = '<?=$hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_LAT")?>';
var geocoder;
var map;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var myOptions = {
   		center: new google.maps.LatLng(lon, lat),
        zoom: 18,//?放比例
        mapTypeId: google.maps.MapTypeId.ROADMAP //地??型 ?MapTypeId.ROADMAP ?MapTypeId.SATELLITE ?MapTypeId.HYBRID ?MapTypeId.TERRAIN 

    }
    map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
    codeAddress();
map.checkResize();
}
function codeAddress() {
    var address = query;
    geocoder.geocode({ 'address': address }, function (results, status) { //地址解析
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);//依据解析的?度?度?置坐?居中
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                title:address,
                animation: google.maps.Animation.DROP //坐??画效果
            });
            var infowindow = new google.maps.InfoWindow({
                content: "<span style='font-size:11px'><b>住所：</b>" + address + "</span>",
                pixelOffset:0, //坐?偏移量，一般不用修改
                position: results[0].geometry.location

            });
            //infowindow.open(map, marker);←默?打?信息窗口。↓点?做伴?出信息窗口
            google.maps.event.addListener(marker, 'click', function () { infowindow.open(map, marker); });
        } else {
            //alert("この住所が存在しておりません");
        }
    });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<STYLE TYPE="text/css"><!--
div.tuzukiwaku{display:none;}
--></STYLE>
<SCRIPT language="JavaScript"><!--
function ot_hiraku(geID,geIDB1,geIDB2){ 
document.getElementById(geID).style.display = "block"; //文表示
document.getElementById(geIDB1).style.display = "none"; //ボタン1非表示
document.getElementById(geIDB2).style.display = "inline"; //ボタン2表示
}
function ot_tatamu(geID,geIDB1,geIDB2){
document.getElementById(geID).style.display = "none"; //文非表示
document.getElementById(geIDB1).style.display = "inline"; //ボタン1表示
document.getElementById(geIDB2).style.display = "none"; //ボタン2非表示
}
//--></SCRIPT>
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
    <main id="detail_n" class="searchdetail search">
    
		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">検索結果</a></li>
            <li><span>宿泊プラン一覧</span></li>
        </ul>
		<article class="mainbox searchagain" id="ag">
			<div class="inner2">
    			<h3><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CATCHCOPY")?></h3>
       			<ul class="icon-type cf">
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
					<li class="area"><?php print $xmlArea->getNameByValue($d)?></li>
					<?php
							if ($areaCnt >= 2) break;
						}
					}
					?>
    	   		</ul>
			<h2><span class="new"></span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?></h2>
			<!--<div class="cont cf">
			</div>-->
			</div>
		</article>

		<?php if(!$_GET) $_GET['info']=1;?>
		<div id="menu_box">
		<ul class="menu_list cf" id="tab">
		<li class="menu_h1 <?php if($_GET['basic']):?>current<?php endif;?>"><a href="#" class="link1">基本情報</a></li>
		<li class="menu_h2 <?php if($_GET['info']):?>current<?php endif;?>"><a href="#" class="link2">宿泊プラン一覧</a></li>
		<li class="menu_h3 <?php if($_GET['morepic']):?>current<?php endif;?>"><a href="#" class="link3">フォトギャラリー</a></li>
		<li class="menu_h4 <?php if($_GET['map']):?>current<?php endif;?>"><a href="#" class="link4">地図・アクセス</a></li>
		</ul>
		</div>
        <!--<ul class="tab" id="tab">
            <li class="tab-1 <?php if($_GET['basic']):?>current<?php endif;?>"><a>基本情報</a></li>
            <li class="tab-2 <?php if($_GET['info']):?>current<?php endif;?>"><a>宿泊プラン一覧</a></li>
            <li class="tab-3 <?php if($_GET['morepic']):?>current<?php endif;?>"><a>フォトギャラリー</a></li>
            <li class="tab-6 <?php if($_GET['map']):?>current<?php endif;?>"><a>地図・アクセス</a></li>
        </ul>-->
            <!--<li class="tab-4 <?php if($_GET['dayinfo']):?>current<?php endif;?>"><a>日帰りプラン一覧</a></li>-->
            <!--<li class="tab-5 <?php if($_GET['detail']):?>current<?php endif;?>"><a>クチコミ</a></li>-->
        <script type="text/javascript">
        $(function() {
        	    $("#tab li").click(function() {
        	        var num = $("#tab li").index(this);
        	        $(".tabframe").addClass('dspNon');
        	        $(".tabframe").eq(num).removeClass('dspNon');
        	        $("#tab li").removeClass('current');
        	        $(this).addClass('current')
        	    });
        	});
        </script>
		
		
		<article id="basickinfo">
		<div class="tabframe  <?php if(!$_GET['basic']):?>dspNon<?php endif;?>">
        	<section class="inner2 cf">
        		<!--<h2>設備写真</h2>-->

		<script type="text/javascript">
		$(function(){$(window).load(function() {
			$('.bxslider2').bxSlider({
			auto:true,
			speed:1000,
			pause:6000,
			controls: false,
			captions: true,
			startSlide:0,
			pager: true,
			pagerCustom: '.bx-pager2'
				});
			});
			});
		</script>
			<div class="slide_box cf">
			<div class="slider2">
        		<ul class="bxslider2">
				<li><?php if ($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_APP") != "") {?>
					<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_APP")?>" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" style="margin-top:-30px;">
        			<?php }else{?>
        				<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>">
				<?php }?></li>
        			<li><?php if ($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC1") != "") {?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC1")?>" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" style="margin-top:-30px;">
        			<?php }else{?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>">
        			<?php }?></li>
        			<li><?php if ($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC2") != "") {?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC2")?>" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" style="margin-top:-30px;">
        			<?php }else{?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>">
        			<?php }?></li>
        			<li><?php if ($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC3") != "") {?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC3")?>" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" style="margin-top:-30px;">
        			<?php }else{?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>">
        			<?php }?></li>
        			<li><?php if ($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC4") != "") {?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC4")?>" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" style="margin-top:-30px;">
        			<?php }else{?>
        				<img class="hide" src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="700" height="466" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>">
        			<?php }?></li>
        		</ul>
			</div>
			<div class="bx-pager2">  
				<div class="thum"><a data-slide-index="0" href=""><img style="margin-top:-19px;" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_APP")?>" width="170" height="113" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" /></a></div>
				<div class="thum"><a data-slide-index="1" href=""><img style="margin-top:-19px;" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC1")?>" width="170" height="113" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" /></a></div>
				<div class="thum"><a data-slide-index="2" href=""><img style="margin-top:-19px;" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC2")?>" width="170" height="113" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" /></a></div>
				<div class="thum"><a data-slide-index="3" href=""><img style="margin-top:-19px;" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC3")?>" width="170" height="113" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" /></a></div>
				<div class="thum"><a data-slide-index="4" href="" class="thumb-edge"><img style="margin-top:-19px;" src="<?php print URL_SLAKER_COMMON?>images/<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PIC_FAC4")?>" width="170" height="113" alt="<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME")?>" /></a></div>
			</div>
  			</div>
        		<!--<div class="rLink" style="color:#FFF; float:right;">
        		<span class="radius10_or" style="width:130px; height:15px; padding:3px; font-size:11px; text-align:center;">>><a href="?hid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");?>&morepic=1" style="color:#FFF;">フォトギャラリーへ</a></span>
        		</div>-->

</br>

			<div class="hotel_catch">
			<h3 class="copy"><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CATCHCOPY")?></h3>
			<p><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_DETAIL")?><p>
			</div>



        	</section>
        	<ul class="basicMenu2">
        		<li><a href="#t1">ご連絡先・アクセス</a></li>
        		<li><a href="#t2">客室情報</a></li>
        		<li><a href="#t3">部屋設備・アメニティ</a></li>
        		<li><a href="#t4">館内設備・サービス</a></li>
        		<li><a href="#t5">お支払い・キャンセルポリシー</a></li>
        		<li><a href="#t6">その他</a></li>
        	</ul>

        	<section class="inner2 cf">
        		<h2><a name="t1">ご連絡先・アクセス</a></h2>
        		<div class="w342">
        		<table class="no-br">
        			<tr class="dot">
        				<th valign="top" width="130">住所</th><td colspan="3">〒<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ZIP")?> <?php $arPref = cmGetPrefName();?> <?php print $arPref[$hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PREF")]?>
        				<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CITY")?>
        				<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ADDRESS")?></td>
        			</tr>
        			<tr class="dot">
        				<th valign="top" width="130">電話番号</th><td><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_TEL")?></td>
        			</tr>
        			<tr class="dot">
        				<th valign="top" width="130">チェックイン</th><td><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_TIME_CHECKIN_FROM")?> ～ <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_TIME_CHECKIN_TO")?></td>
        			</tr>
        			<tr class="dot">
        				<th valign="top" width="130">チェックアウト</th><td><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_TIME_CHECKOUT_FROM")?> ～ <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_TIME_CHECKOUT_TO")?></td>
        			</tr>
        			<tr class="dot">
        				<th valign="top" width="130">アクセス</th><td><p style="word-break:break-all; "><?php print redirectForReturn($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ACCESS_SUM"))?></p></td>
        			</tr>
        			<tr>
        				<th valign="top" width="130">駐車場</th><td><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PARKING_MEMO")?></td>
        			</tr>
        		</table>
        		</div>
        	</section>

        	<section class="inner2 cf">
        		<h2><a name="t2">客室情報</a></h2>
				<div class="room_info">
        				総客室数: <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA1")?>室　　
        				収容人数: <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA48")?>人　　
        				階数: <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA49")?>階
				</div>
        				<!--<td>シングルルーム<span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA3")?></span>室</td>
        				<td>ツインルーム<span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA6")?></span>室</td>
        				<td>トリプルルーム<span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA36")?></span>室</td>
        			</tr>
        			<tr>
        				<td>ダブルルーム<span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA9")?></span>室</td>
        				<td>和室<span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA13")?></span>室</td>
        				<td>和洋室<span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA14")?></span>室</td>
        				</tr>
        				<tr>
        				<td>スィートルーム<span><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_DATA12")?></span>室</td>
        				<td></td>
        				<td></td>
        				</tr>
        			</tr>-->
        		<p>
        		備考:
        		</p>


			<?php 
			$ROOM = new hotelRoom($dbMaster);
			$ROOM->select("", "1",$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
			?>
		<?php if ($ROOM->getCount() > 0) {?>
			<?php foreach ($ROOM->getCollection() as $ad) {?>
			<div class="room">
				<div class="room_image"><img src="<?php print URL_SLAKER_COMMON?>images/<?=$ad["ROOM_PIC1"]?>" width="270" height="170" alt="<?=$ad["ROOM_NAME"]?>"></div>
				<div class="room_text"><h3><?=$ad["ROOM_NAME"]?></h3>
				広さ：約<?=$ad["ROOM_BREADTH"]?>㎡　/　定員：<?=$ad["ROOM_CAPACITY_FROM"]?>～<?=$ad["ROOM_CAPACITY_TO"]?>名</br>
				ペット受け入れ：<?php
				if ($ad["ROOM_PET_FLG"] == 1) {
					print "可";
				}
				elseif ($ad["ROOM_PET_FLG"] == 2) {
					print "不可";
				}
				?>
				<p><?php print nl2br(cmStrimWidth($ad["ROOM_DISCRITION"], 0, 340, '…'))?></p></div>
			</div>
			<?php }?>
		<?php }else {?>
		<?php }?>
        	</section>

        	<section class="inner2 cf">
        		<h2><a name="t3">部屋設備・アメニティ</a></h2><A HREF="JavaScript:ot_hiraku('tuzuki1','tuzukiB1','tuzukiB2');" ID="tuzukiB1">▼詳細を表示する</A>
									<A HREF="JavaScript:ot_tatamu('tuzuki1','tuzukiB1','tuzukiB2');" ID="tuzukiB2" style="display:none">▲詳細をたたむ</A>
		<div class="tuzukiwaku" id="tuzuki1">
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST1"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom1();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '<div class="half cf">
        			<div class="title_fac">部屋設備</div>
        			<ul class="2c">';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST2"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom2();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '<!--<h3>通信機器</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST3"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom3();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '
        			<!--<h3>お茶セット・冷蔵庫</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST4"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom4();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '
        			<!--<h3>身だしなみグッズ</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST5"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom5();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '
        			<!--<h3>空調・トイレタリー</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST6"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom6();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '
        			<!--<h3>その他家電</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST7"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom7();
			$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '
        			<!--<h3>調理器具・家電類</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST8"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom8();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '
        			<!--<h3>パソコン、周辺機器</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ROOM_LIST9"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			$dataRoomList=cmHotelRoom9();
$has = false;
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '
        			<!--<h3>その他</h3>-->
        			';
				foreach ($dataRoomList as $k=>$v) {
					if ($arRoomList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
						}
			?>
				</ul>
			</div>
        		<div class="half_r cf">
        			<div class="title_fac">アメニティ</div>
        			<ul class="2c">
        				<?php $arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_AMENITY_LIST"));
        			if (count($arTemp) > 0) {
        				foreach ($arTemp as $data) {
        					if ($data != "") {
        						$arAmenity[$data] = $data;
        					}
        				}
        			}
				$dataAmenity = cmHotelAmenity();
				$cnt = 0;
				if (count($dataAmenity) > 0) {
					foreach ($dataAmenity as $k=>$v) {
						$cnt++;
						if ($cnt > 15) {
							break;
						}
						$checked = '';
						if ($arAmenity[$k] != "") {
							echo "<li>".$v."</li>";
						}
					}
				}
				?>
        			</ul>
        		</div>
        	</section>

       		<section class="inner2 cf">
        		<h2><a name="t4">館内施設・サービス</a></h2>
<section class="cf"><?php print redirectForReturn($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_MEMO"))?></section></br>
		<div class="half cf">
        			<div class="title_fac">館内施設・サービス</div>
        			<ul>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST1"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility1();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST2"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility2();
			$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
        			echo '<!--<h3>エンターテインメント</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
       <!-- 		<?php if($hotelTarget->getByKey($hotelTarget->getKeyValue(),"HOTEL_FACILITY_NUM1")):?>
        		<div class="br_cn cf br_cnsp">
        		<h3>宴会</h3>
        		<p>
						<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_NUM1")?> 室 :
						<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_FROM1")?> ～
						<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_TO1")?> 名
					</p>
					</div>
				<?php endif;?>
				<?php if($hotelTarget->getByKey($hotelTarget->getKeyValue(),"HOTEL_FACILITY_NUM2")):?>
					<div class="br_cn cf br_cnsp">
					<h3>会議室</h3>
        		<p>
						<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_NUM2")?> 室 :
						<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_FROM2")?> ～
						<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_TO2")?> 名
					</p>
					</div>
				<?php endif;?>-->
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST3"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility3();
			$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
        			echo '<!--<h3>宴会.会議室</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST4"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility4();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
        			echo '<!--<h3>お風呂</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			
			?>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST5"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility5();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
        			echo '<!--<h3>お子様向け</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST6"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility6();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
        			echo '<!--<h3>館内ショップ</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST7"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility7();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
        			echo '<!--<h3>美容</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST9"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility9();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '<!--<h3>レジャー・スポーツ</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST10"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility10();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '<!--<h3>その他</h3>-->';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
				</ul>
        		</div>
        				<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_FACILITY_LIST8"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			$dataFacilityList = cmHotelFacility8();
$has = false;
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '<div class="half_r cf">
        			<div class="title_fac">プール情報</div>
        			<ul>';
				foreach ($dataFacilityList as $k=>$v) {
					if ($arFacilityList[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
				echo '</ul>
        		</div>';
			}
			?>

			<?php if($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_SPA_FLG")==1){?>
			<div class="half_r cf">
        		<div class="title_fac">温泉・大浴場情報</div>
        		<table class="no-br">
        			<tr>
        				<th>温泉名: <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_SPA_NAME")?></th>
        			</tr>
				<tr>
        				<th>泉質: <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_SPA_REMARKS")?></th>
				</tr>
				<tr>
        				<th>効能: <?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_SPA_REMARKS2")?></th>
				</tr>
        			<!--<tr>
        				<td>露天風呂<span>あり</span></td>
        				<td>内湯<span>あり</span></td>
        				<td>水風呂<span>あり</span></td>
        			</tr>-->
        		</table>
        		<p style="word-break:break-all; "><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_SPA_DATA15")?></p>
			</div>
        	<? } ?>
        				<?php
			$arService = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_SERVICE_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arService[$data] = $data;
					}
				}
			}
			$dataService = cmHotelService();
			$has = false;
			if (count($dataService) > 0) {
				foreach ($dataService as $k=>$v) {
					if ($arService[$k] != "") {
						$has = true;
					}
				}
			}
			if ($has) {
				echo '<div class="half_r cf">
        			<div class="title_fac">可能サービス</div>
        			<ul>';
				foreach ($dataService as $k=>$v) {
					if ($arService[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
				echo '</ul>
        		</div>';
			}
			?>
			<div class="half cf">
        		<div class="title_fac">宿泊者特典</div>
        		<ul>
        		<?php
			$arStay = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_STAY_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arStay[$data] = $data;
					}
				}
			}
			$dataStay = cmHotelStay();
			if (count($dataStay) > 0) {
				foreach ($dataStay as $k=>$v) {
					if ($k >= 10) {
						break;
					}
					$checked = '';
					if ($arStay[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        		</ul>
			</div>

        	</section>

        	<section class="inner2">
        		<h2>お子様向けサービス</h2>
        		<section class="cf"><?php print redirectForReturn($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CHILD_MEMO"))?></section></br>
        		<table class="no-br">
        		<?php for ($i=1; $i<=4; $i++) {?>
        			<tr>
        				<th valign="top" width="130">
        					<?php
        					$targetNmae = "";
        					$dataChildList = array();
        					switch ($i) {
        						case 1:
        							$targetNmae = "お子様用品の貸出";
        							$dataChildList = cmHotelChild1();
        							break;
        						case 2:
        							$targetNmae = "お子様アメニティ";
        							$dataChildList = cmHotelChild2();
        							break;
        						case 3:
        							$targetNmae = "お子様グッズの取扱い";
        							$dataChildList = cmHotelChild3();
        							break;
        						case 4:
        							$targetNmae = "お子様のお食事";
        							$dataChildList = cmHotelChild4();
        							break;
        					}
        					?>
        					<p><?php print $targetNmae?></p>
        				</th>
        				<td align="left">
        					<?php
        					$arChildList = array();
        					$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CHILD_LIST".$i));
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arChildList[$data] = $data;
        							}
        						}
        					}
        					?>
        					<div class="checkboxarea">
        					<?php
        					if (count($dataChildList) > 0) {
        						foreach ($dataChildList as $k=>$v) {
        							$checked = '';
        							if ($arChildList[$k] != "") {
        								$checked = 'checked="checked"';
        							?>
        							<?php print $v." / "?>
        						<?php
        							}
        						}
        					}
        					?>
        					</div>
        				</td>
        			</tr>
        			<?php }?>
        			<!--<tr>
        				<td>お子様用の貸し出し:<span>貸し出しテキスト</span></td>
        			</tr>
        			<tr>
        				<td>お子様アメニティ:<span>あり</span></td>
        			</tr>
        			<tr>
        				<td>お子様グッズの取扱</td>
        			</tr>
        			<tr>
        				<td>お子様お食事</td>
        			</tr>-->
        		</table>
        	</section>
			<?php
			$arPet = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_LIST_PET"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arPet[$data] = $data;
					}
				}
			}
			?>
			<?php if (count($arPet) > 0) {?>
        	<section class="inner2 cf">
        		<h2>ペットの受け入れ状況</h2>
        		<!--<?php $dataAmenity = cmHotelService();?>-->
        		<section class="cf"><?php print redirectForReturn($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PET_MEMO4"))?></section></br>
        		<table class="no-br">
        			<tr>
        				<td><B>受け入れペット:</B> <?php
					$dataPet = cmHotelPet();
        				if (count($dataPet) > 0) {
        					foreach ($dataPet as $k=>$v) {
        						if ($k >= 10) {
        							break;
        						}
        						$checked = '';
        						if ($arPet[$k] != "") {
        						$checked = 'checked="checked"';
        						?>
        						<?php print "<span>・".$v."</span>";?>
        						<?php
        						}
        					}
        				}
        				?></td>
        			</tr>
        			<tr>
        				<td><B>ペットの宿泊場所（同室OK）: </B><?php
        				if (count($dataPet) > 0) {
        					foreach ($dataPet as $k=>$v) {
        						if ($k < 10) {
        							continue;
        						}
        						if ($k >= 20) {
        							break;
        						}
        						$checked = '';
        						if ($arPet[$k] != "") {
        						?>
        						<?php print $v." / "?>
        						<?php
        						}
        					}
        				}
        				?></td>
        			</tr>
        			<tr>
        				<td><B>ペットの宿泊場所（同室NG）: </B><?php
        				if (count($dataPet) > 0) {
        					foreach ($dataPet as $k=>$v) {
        						if ($k < 20) {
        							continue;
        						}
        						if ($k >= 30) {
        							break;
        						}
        						$checked = '';
        						if ($arPet[$k] != "") {
        						?>
        						<?php print $v." / "?>
        						<?php
        						}
        					}
        				}
        				?><?php print redirectForReturn($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PET_MEMO2"))?></td>
        			</tr>
        			<tr>
        				<td><B>ペット同伴OKな場所: </B><?php
        				if (count($dataPet) > 0) {
        					foreach ($dataPet as $k=>$v) {
        						if ($k < 30) {
        							continue;
        						}
        						if ($k >= 40) {
        							break;
        						}
        						$checked = '';
        						if ($arPet[$k] != "") {
        						?>
        						<?php print $v." / "?>
        						<?php
        						}
        					}
        				}
        				?></td>
        			</tr>

        			<tr>
        				<td><B>ペット用設備:</B> <?php
        				if (count($dataPet) > 0) {
        					foreach ($dataPet as $k=>$v) {
        						if ($k < 40) {
        							continue;
        						}
        						if ($k >= 50) {
        							break;
        						}
        						$checked = '';
        						if ($arPet[$k] != "") {
        						?>
        						<?php print $v." / "?>
        						<?php
        						}
        					}
        				}
        				?></td>
        			</tr>
        			<tr>
        				<td><B>ご持参いただくもの:</B> <?php
        				if (count($dataPet) > 0) {
        					foreach ($dataPet as $k=>$v) {
        						if ($k < 50) {
        							continue;
        						}
        						if ($k >= 70) {
        							break;
        						}
        						$checked = '';
        						if ($arPet[$k] != "") {
        						?>
        						<?php print $v." / "?>
        						<?php
        						}
        					}
        				}
        				?></td>
        			</tr>
        			<tr>
        				<td><B>ペット宿泊条件:</B> <?php
        				if (count($dataPet) > 0) {
        					foreach ($dataPet as $k=>$v) {
        						if ($k < 70) {
        							continue;
        						}
        						if ($k >= 80) {
        							break;
        						}
        						$checked = '';
        						if ($arPet[$k] != "") {
        						?>
        						<?php print $v." / "?>
        						<?php
        						}
        					}
        				}
        				?>
        				<p style="word-break:break-all; "><?php print redirectForReturn($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_PET_MEMO3"))?></p></td>
        			</tr>
        		</table>
        	</section>
			<?php }?>

        	<section class="inner2 cf">
			<div class="half">
        		<h2>ご利用可能カード</h2>
        		<ul>
        		<?php
			$arCard = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CARD_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arCard[$data] = $data;
					}
				}
			}
			$dataCard = cmHotelCard();
			if (count($dataCard) > 0) {
				foreach ($dataCard as $k=>$v) {
					$checked = '';
					if ($arCard[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        		</ul>
			</div>

			<div class="half_r">
        		<h2><a name="t5">キャンセルポリシー</a></h2>
        		<p>
        		<?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {?>

	                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {?>

		                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {?>
		                		<?php
			                    $can = "";
			                    if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
									$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
								}
								else {
									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
								}
			                    ?>
    	            			無不泊連絡:<?php print $can;?><br>
	    	            	<?php }?>

		                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {?>
		                		<?php
			                    $can = "";
			                    if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
									$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
								}
								else {
									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
								}
			                    ?>
    	            			当日キャンセル:<?php print $can;?></br>
	    	            	<?php }?>

	    	            	<?php for ($i=3; $i<=7; $i++) {?>
			                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {?>
			                		<?php
				                    $can = "";
				                    if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
										$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
									}
									else {
										$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
									}
				                    ?>
	    	            			<?php print $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)?>～<?php print $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)?> 日前まで：<?php print $can;?>
		    	            	<?php }?>
	    	            	<?php }?>

	                	<?php }?>

                	<?php }else{?>
	                	<?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {?>
		                    <?php
		                    $can = "";
		                    if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
								$can = "宿泊料の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%";
							}
							else {
								$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円";
							}
		                    ?>
		                    	無不泊連絡:<?php print $can;?></br>
	                	<?php }?>
	                	<?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {?>
		                    <?php
		                    $can = "";
		                    if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
								$can = "宿泊料の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%";
							}
							else {
								$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円";
							}
		                    ?>
		                    当日:<?php print $can;?></br>
	                	<?php }?>

	                	<?php for ($i=3; $i<=6; $i++) {?>
		                	<?php if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {?>
			                    <?php
			                    $can = "";
			                    if ($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
									$can = "宿泊料の".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%";
								}
								else {
									$can = "".$hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円";
								}
			                    ?>
			                    <?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)?>～<?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)?> 日前まで:<?php print $can;?>
		                	<?php }?>
	                	<?php }?>
                	<?php }?>
        		</p>
			</div>
        	</section>

        	<section class="inner2 cf">
			<div class="half">
        		<h2><a name="t6">宿泊の条件・注意事項</a></h2>
        		<p>
        		<?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_CAUTION")?>
        		</p>
			</div>

			<div class="half_r">
        		<h2>バリアフリーの対応状況</h2>
        		<ul>
        		<?php
			$arDisabled = array();
			$arTemp = explode(":", $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_DISABLED"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arDisabled[$data] = $data;
					}
				}
			}
			$dataDisabled = cmHotelDisabled();
			if (count($dataDisabled) > 0) {
				foreach ($dataDisabled as $k=>$v) {
					$checked = '';
					if ($arDisabled[$k] != "") {
						echo "<li>".$v."</li>";
					}
				}
			}
			?>
        		</ul>
			</div>
        	</section>
        </div>
        </article>

		<article class="mainbox">
        <div class="tabframe <?php if(!$_GET['info']):?>dspNon<?php endif;?>">
        <div class="rireki cf">
        	<h3><B>【現在の検索条件】</B></h3>
        	  <form action="search-detail.html" method="post" id="frmResearch" name="frmResearch">

        	  <input type="hidden" name="COMPANY_ID" value="<?=$_POST['COMPANY_ID']?><?=$_GET['hid']?>">
        	  <input type="hidden" name="HOTELPLAN_ID" value="<?=$_POST['HOTELPLAN_ID']?>">
              <div class="stayplan form">
              <table>
              	<tr>
              		<td>
                        <B>宿泊日</B><?php print $inputs->text("search_date", $collection->getByKey($collection->getKeyValue(), "search_date") ,"imeDisabled wDateJp")?>
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
                        <!--(<?
                        print $inputs->checkbox("undecide_sch","undecide_sch",1,$collection->getByKey($collection->getKeyValue(), "undecide_sch"),"日程未定", "")?>)--> から
                       &nbsp;
                        <div class="selectbox">
                        	<div class="select-inner select2"><span></span></div>
                        	<select name="night_number" id="night_number">
                        		<?php
                        		for ($i=1; $i<=SITE_STAY_NUM; $i++) {
                        			$selected = '';
                        			if ($collection->getByKey($collection->getKeyValue(), "night_number") == $i) {
                        				$selected = 'selected="selected"';
                        			}
                        		?>
                        	    <option valu="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                        		<?php }?>
                        	</select>
                        </div>
                        泊
                       </td>
              	</tr>
              </table>
	<table>
	<tr>
	<td>
              <table class="research">
              	<tr>
                       <td class="innertable-fst">
                       <!--<B>部屋数</B>
                        <div class="selectbox">
                        	<div class="select-inner select2"><span></span></div>
                        	<select name="room_number" id="room_number">
                        		<?php
                        		for ($i=1; $i<=SITE_ROOM_NUM; $i++) {
                        			$selected = '';
                        			if ($collection->getByKey($collection->getKeyValue(), "room_number") == $i) {
                        				$selected = 'selected="selected"';
                        			}
                        		?>
                        	    <option valu="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                        		<?php }?>
                        	</select>
                        </div>
                        室-->
              		</td>

                  <td class="innertable-fst">
              			大人
                        <div class="selectbox">
                        <?php $selected='';?>
                        	<div class="select-inner select2"><span></span></div>
                            <select id="adult_number<?php print $roomNum?>" name="adult_number<?php print $roomNum?>" class="select2 adultset">
								<?php
								for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
									if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
										$selected = 'selected="selected"';
									}
								}
								if ($selected == 'selected="selected"') {
									for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
											$selected = 'selected="selected"';
										}
										?>
										<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==9)?'～':''?></option>
										<?php }
										}else{
								for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
									$selected = '';
									if (2 == $i) {
										$selected = 'selected="selected"';
										}
									
								?>
								<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==9)?'～':''?></option>
								<?php }
								}
								?>
							</select>

						</div>
                        人
                  </td>
                  <td class="innertable200">
                  	小学生低学年
                  	<div class="selectbox">
                  	    <div class="select-inner select2"><span></span></div>
                  	 <select id="child_number<?php print $roomNum?>1" name="child_number<?php print $roomNum?>1" class="select2 childset1">
                  			<option value="0">0</option>
                  			<?php
                  			for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
                  				$selected = '';
                  				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") == $i) {
                  					$selected = 'selected="selected"';
                  				}
                  			?>
                  			<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                  			<?php }?>
                  		</select>
                  	</div>
					人
                  </td>
                  <td class="innertable200">
                    小学生高学年
                    <div class="selectbox">
                        <div class="select-inner select2"><span></span></div>
                        <select id="child_number<?php print $roomNum?>2" name="child_number<?php print $roomNum?>2" class="select2 childset2">
                    		<option value="0">0</option>
                    		<?php
                    		for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
                    			$selected = '';
                    			if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") == $i) {
                    				$selected = 'selected="selected"';
                    			}
                    		?>
                    		<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                    		<?php }?>
                    	</select>
                    </div>
                    人
                  </td>
                           </tr>
                            <tr>
                            	<td colspan="2"></td>
                  <td class="innertable200">
                                幼児<span>（食事・布団あり)</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>3" name="child_number<?php print $roomNum?>3" class="select2 childset3">
                                		<option value="0">0</option>
                                		<?php
                                		for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
                                			$selected = '';
                                			if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") == $i) {
                                				$selected = 'selected="selected"';
                                			}
                                		?>
                                		<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                                		<?php }?>
                                	</select>
                                </div>
                                人
                                </td>
                  <td class="innertable200">
                                幼児<span>（食事のみ）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>4" name="child_number<?php print $roomNum?>4" class="select2 childset3">
                                		<option value="0">0</option>
                                		<?php
                                		for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
                                			$selected = '';
                                			if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") == $i) {
                                				$selected = 'selected="selected"';
                                			}
                                		?>
                                		<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                                		<?php }?>
                                	</select>
                                </div>
                                人
                                </td>
                           </tr>
                            <tr class="last">
                                <td colspan="2">
                                </td>
                  <td class="innertable200">
                               幼児<span>（布団のみ）</span>
                               <div class="selectbox">
                                   <div class="select-inner select2"><span></span></div>
                                   <select id="child_number<?php print $roomNum?>5" name="child_number<?php print $roomNum?>5" class="select2 childset3">
                               		<option value="0">0</option>
                               		<?php
                               		for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
                               			$selected = '';
                               			if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") == $i) {
                               				$selected = 'selected="selected"';
                               			}
                               		?>
                               		<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                               		<?php }?>
                               	</select>
                               </div>
                               人
                                </td>
                  <td class="innertable200">
                                幼児<span>（食事・布団なし）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>6" name="child_number<?php print $roomNum?>6" class="select2 childset3">
                                		<option value="0">0</option>
                                		<?php
                                		for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
                                			$selected = '';
                                			if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") == $i) {
                                				$selected = 'selected="selected"';
                                			}
                                		?>
                                		<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                                		<?php }?>
                                	</select>
                                </div>
                                人
                                </td>
                           </tr>
              </table>
		</td>
		</tr>
		</table>
              <script type="text/javascript">
                    $(document).ready(function(){
                    	$("#room_number").change(function () {
                    		roomChange();
                    	});
                    	roomChange();


                    	$(".adultset").change(function () {
                    		setTextAdult();
					    });
						$(".childset1").change(function () {
							//alert(""+$(this).val());
							setTextChild1();
					    });
						$(".childset2").change(function () {
							setTextChild2();
					    });
						$(".childset3").change(function () {
							setTextChild3();
					    });
						setTextAdult();
						setTextChild1();
						setTextChild2();
						setTextChild3();
                    });

                    function roomChange() {
                    	var i;
                    	$('.datainputset').addClass('dspNon');
                    	for (i = 1; i <= parseInt($('#room_number').val()); i = i +1){
                    		$('#datainput'+i).removeClass('dspNon');
                    	}
                    	$("#txt_room").text($('#room_number').val());

                    	var setAdult = 0;
                    	var setChild = 0;
                    }

                    function setTextAdult() {
                        var total = 0;
						for (i = 1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
                    			if (parseInt($('select[name="adult_number'+i+'"]').val()) != '') {
                    				total = total + parseInt($('select[name="adult_number'+i+'"]').val());
                    			}
						}
						$("#txt_adult").text(total);
                    }
                    function setTextChild1() {
                    	var total=0;

                    	var i;
                    	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
                			if ($('select[name="child_number'+i+'1"]').val() != '') {
                				total = total + parseInt($('select[name="child_number'+i+'1"]').val());
          				}
                    	}
						$("#txt_child1").text(total);
                    }
                    function setTextChild2() {
                    	var total=0;

                    	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
                    		if ($('select[name="child_number'+i+'2"]').val() != '') {
                				total = total + parseInt($('select[name="child_number'+i+'2"]').val());
          				}
                    	}
						$("#txt_child2").text(total);
                    }
                    function setTextChild3() {
                    	var total=0;
                    	var child;

                    	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
							for (child = 3; child<=6; child=child +1){
                        		if ($('select[name="child_number'+i+child+'"]').val() != '') {
                    				total = total + parseInt($('select[name="child_number'+i+child+'"]').val());
                				}
                        	}
                    	}

						$("#txt_child3").text(total);
                    }
                    </script>

              <table>
              	<tr>
              		<td colspan="2">
                        <B>部屋のタイプ</B>
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                            	<?php $ar = cmHotelRoomType();?>
                            	<?php if (count($ar) > 0) {?>
                            	<select id="ROOM_TYPE" name="ROOM_TYPE" class="select3">
                            		<option value="">指定しない</option>
                            		<?php
                            		foreach ($ar as $k=>$v) {
                            			$selected = '';
                            			if ($collection->getByKey($collection->getKeyValue(), "ROOM_TYPE") == $k) {
                            				$selected = 'selected="selected"';
                            			}
                            		?>
                            		<option value="<?php print $k?>" <?php print $selected;?>><?php print $v?></option>
                            		<?php }?>
                            	</select>
                            	<?php }?>
	                        </div>
              		</td>
              		<td>
              			<B>お食事</B>
              			<?php
              			$dataMeal = cmMeal();
              			if (count($dataMeal) > 0) {
              			?>
              			<?php
              				foreach ($dataMeal as $k=>$v) {
              					if ($k == "") {
              						continue;
              					}
              					$checked = '';
              					if ($collection->getByKey($collection->getKeyValue(), "meal".$k) == $k) {
              						$checked = 'checked="checked"';
              					}
              					?>
              						<input type="checkbox" id="meal<?php print $k?>" name="meal<?php print $k?>" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="meal<?php print $k?>"> <?php print $v?></label>
              						<?php
              				}
              			?>
              			<?php
              			}
              			?>
              		</td>
              		<td colspan="3">
              			<div class="btn"><button name="research" value="" >再検索</button></div>
              			<?php print $inputs->hidden("orderdata", $collection->getByKey($collection->getKeyValue(), "orderdata"))?>
              		</td>
              	</tr>
              </table>        
	</div>
	</form></div>

    <section class="resultbox">
    	<!--<div class="result">検索結果：<b><?php print $hotelPlanTarget->getMaxCount()?>件</b>のホテル情報のうち <b><?php print $scope['0']?></b>件?<b><?php print $scope['1']?></b>件を表示</div>-->
        <p class="caution">※表示の料金は1部屋・1泊あたりの合計金額（税・サービス料込）です。<br/>
        2室以上のお部屋をご利用の場合、最安料金は1室あたりの料金が表示されます。</p>
        
		<script type="text/javascript">
		    function ordertype_submit(ordertype){
		    	$("input[name='orderdata']").val(ordertype);
		    	document.frmResearch.submit();
			}
		</script>
		<div class="order">
			<dl>
				<dt>並び替え</dt>
				<input type="hidden" name="orderdata" value="" />
				<dd><a href="javascript: ordertype_submit(0);">人気順</a></dd>
				<dd><a href="javascript: ordertype_submit(1);">料金が安い順</a></dd>
				<dd><a href="javascript: ordertype_submit(2);">料金が高い順</a></dd>
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
        
    </section>
       
       
   		<?php if (count($dspArray) > 0) {?>
   		    <?php
   		    foreach ($dspArray as $plandata) {
   			?>
        	<div class="inner">
                <h2><span class="new-b"></span><B><?php print $plandata["HOTELPLAN_NAME"]?></B></h2>
                <div class="cont">
                	<div class="image-r">
                		<?php if ($plandata["HOTELPLAN_PIC"] != "") {?>
                			<?php if ($plandata["COMPANY_LINK"] != "") {?>
                		<img src="<?php print URL_PUBLIC_LINK?><?php print $plandata["HOTELPLAN_PIC"]?>" width="248" height="165" alt="<?php print $plandata["HOTELPLAN_NAME"]?>">
                			<?php }else {?>
                		<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $plandata["HOTELPLAN_PIC"]?>" width="248" height="165" alt="<?php print $plandata["HOTELPLAN_NAME"]?>">
                			<?php }?>
                		<?php }else{?>
                		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="248" height="168" alt="<?php print $plandata["HOTEL_NAME"]?>">
                		<?php }?>
                		<?php $fromDate = cmDateDivide($plandata["HOTELPLAN_DATE_SALE_FROM"])?>
                		<?php $toDate = cmDateDivide($plandata["HOTELPLAN_DATE_SALE_TO"])?>
                		<p class="sealetime">販売期間：<span><?php 
                		if($fromDate["y"] == "0000"){
                			print "～";
                		}
                		else {
                			print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"."～".$toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日";
                		}?></span></p>
                	</div>

                    <div class="plans-section2">
                		<ul class="icon">
                			<?php
                			$meal = "";
                			if ($plandata["HOTELPLAN_BF_FLG"] == 2) {
                				$meal = "朝";
                			}
                			if ($plandata["HOTELPLAN_LN_FLG"] == 2) {
                				$meal .= "昼";
                			}
                			if ($plandata["HOTELPLAN_DN_FLG"] == 2) {
                				$meal .= "夕";
                			}
                			if ($meal != "") {
                				$meal .= "食あり";
                			}
                			else {
                				$meal .= "食事なし";
                			}
                			?>
                			<li><?php print $meal;?></li>
                    		<!--<li><img src="./images/common/icon-nomeal.jpg"</li>
                    		<li><img src="./images/common/icon-Limit.jpg"</li>-->
                    	</ul>
                    	<div class="checkin">チェックイン：
                    	<?php if($plandata["COMPANY_LINK"] != ""){
                    		print substr($plandata["HOTELPLAN_CHECKIN"],0,2).":".substr($plandata["HOTELPLAN_CHECKIN"],2,2)."～".substr($plandata["HOTELPLAN_CHECKIN_LAST"],0,2).":".substr($plandata["HOTELPLAN_CHECKIN_LAST"],2,2);
                    	}
                    	else {
                    		$tmp = explode(':', $plandata["HOTELPLAN_CHECKIN"]); 
                    		if(strlen($tmp[1])==1) $plandata["HOTELPLAN_CHECKIN"]=$tmp[0].':0'.$tmp[1]; 
                    		print $plandata["HOTELPLAN_CHECKIN"];
                    		$tmp = explode(':', $plandata["HOTELPLAN_CHECKIN_LAST"]); 
                    		if(strlen($tmp[1])==1) $plandata["HOTELPLAN_CHECKIN_LAST"]=$tmp[0].':0'.$tmp[1];  
                    		print "～".$plandata["HOTELPLAN_CHECKIN_LAST"];
                    	}
                    	?> 
                    	/ チェックアウト～
                    	<?php   
                    	if($plandata["COMPANY_LINK"] != ""){
                    		if(strlen($plandata["HOTELPLAN_CHECKOUT"]) == 3){
                    			print substr($plandata["HOTELPLAN_CHECKOUT"],0,1).":".substr($plandata["HOTELPLAN_CHECKOUT"],1,2);
                    		}
                    		else {
                    			print substr($plandata["HOTELPLAN_CHECKOUT"],0,2).":".substr($plandata["HOTELPLAN_CHECKOUT"],2,2);
                    		}
                    	}
                    	else {
                    		$tmp = explode(':', $plandata["HOTELPLAN_CHECKOUT"]); 
                    		if(strlen($tmp[1])==1) $plandata["HOTELPLAN_CHECKOUT"]=$tmp[0].':0'.$tmp[1];  
                    		print $plandata["HOTELPLAN_CHECKOUT"];
                    	}
                    	?></div>
                    	<div class="detailplan-txt">
                        	<p style="word-break:break-all; "><?php print redirectForReturn($plandata["HOTELPLAN_FEATURE"])?></p>
                        </div>
                		<div class="off_bo">
                			<?php if ($plandata["HOTELPLAN_DISCOUNT"] != "") {?>
                			<div class="offtxt radius10"><b><?php print $plandata["HOTELPLAN_DISCOUNT"]?></b></div>
                			<?php }?>
                				<div class="off-inner  radius10">
                					<b>最安料金</b><br />
                					<span>1室合計</span>
                					<strong>￥<?php print number_format($plandata["money_all"])?>～</strong>
                					<?php if ($collection->getByKey($collection->getKeyValue(), "room_difference")) {?>
                					<p class="point">（￥<?php print number_format($plandata["money_1"])?>～/人）</p>
                					<?php }?>
                				</div>
                			</div>
                    	</div>

                <section class="list2">
                	<?php if (count($plandata["room"]) > 0) {?>
                	<h3>このプランで利用できるお部屋</h3>
                    <ul class="item">
                    	<li>大人1名</li>
                        <li><B>合計</B></li>
                    </ul>
                    <?php foreach ($plandata["room"] as $data) {?>
                    <dl>
                    	<dt>
                    		<?php
                    		$ar = cmHotelRoomType();
                    		$heya = "";
                    		if ($ar[$data["ROOM_TYPE"]] != "") {
								$heya = $ar[$data["ROOM_TYPE"]];
							}
                    		?>
                    		<div><span class="radius10"><?php print $heya?></span><?php print $data["ROOM_NAME"]?></div>
                    		<?php
                    		$hirosa = "";
                    		if ($data["money_all"] != "") {
	                    		$hirosa = $data["ROOM_BREADTH"];
							}

							$dataFeature3 = cmHotelRoomFeature3();
							$arFearture3 = array();
							$arTemp = explode(":", $data["ROOM_FEATURE_LIST3"]);
							$cc = 0;
							if (count($arTemp) > 0) {
								foreach ($arTemp as $dd) {
									if ($dd != "") {
										$cc++;
// 												if ($cc > 4) break;
										$arFearture3[$dd] = $dd;
									}
								}
							}
                    		?>
                    		<p>広さ：<?php print $hirosa?>㎡
                    		<?php
                    		if (count($arFearture3) > 0) {
                    			foreach ($arFearture3 as $d) {
                    		?>
                    		<span class="radius10"><?php print $dataFeature3[$d]?></span>
                    		<?php
                    			}
                    		}
                    		?>
                    		</p>
                    	</dt>
                    	<dd class="r-sp" style="width:50px; font-size:12px;">
                    		<?php if ($collection->getByKey($collection->getKeyValue(), "room_difference")) {?>
                    			<?php print $collection->getByKey($collection->getKeyValue(), "adult_number1")?>名1室
                    		<?php }else{?>
                    		&nbsp;
                    		<?php }?>
                    	</dd>
                    	<dd class="r-sp" style="width:80px;">
                    		<?php if ($collection->getByKey($collection->getKeyValue(), "room_difference")) {?>
                    		￥<?php print number_format($data["money_1"])?>～
                    		<?php }else{?>
                    		-
                    		<?php }?>
                    	</dd>
                    	<dd class="sp-r" style="width:80px;">
                    		<B>￥<?php print number_format($data["money_all"])?>～</B>
                    		<p class="pt">ポイント<?php print $data["point"]?>%</p>
                    	</dd>
                    	<dd class="cell3">
                    		<?php $formname = "frm".$data["COMPANY_ID"]."_".$data["HOTELPLAN_ID"]."_".$data["ROOM_ID"];?>
                    		<form action="plan-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
                    			<a href="javascript:void(0)" class="bt_plan2" onclick="document.<?php print $formname?>.submit();">プラン詳細</a>
                    			<?php print $inputs->hidden("COMPANY_ID", $data["COMPANY_ID"])?>
                    			<?php print $inputs->hidden("COMPANY_LINK", $data["COMPANY_LINK"])?>
                    			<?php print $inputs->hidden("HOTELPLAN_ID", $data["HOTELPLAN_ID"])?>
                    			<?php print $inputs->hidden("ROOM_ID", $data["ROOM_ID"])?>
                    			<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
                    			<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
                    			<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
                    			<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
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
                </section>
                </div>
            </div>
            <br />
            <?php }?>
         <?php }?>
        </div>
        </article>
         
        <article class="mainbox" style="margin-top:-20px;">
        <div class="tabframe  <?php if(!$_GET['morepic']):?>dspNon<?php endif;?>" id="lightboxes">
        <table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
        <tr><td colspan=3><B>＜＜　部屋　＞＞</B></td></tr>
    	<?php if ($hotelPic->getCount() > 0) {?>
    	<tr>
    			<?php
    			$cnt = 0;
    			$cntAll = 0;
    			foreach ($hotelpics[1] as $ad) {
    			$cnt++;
    			?>
    
    					<td>
    						<a href="http://common.kokomo-oki.net/images/<?=$ad["HOTELPIC_DATA"]?>"><?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></a>
    					</td>
    					<?php 
    					if($cnt % 3 == 0){
    					?>
    					</tr><tr>
    					<?php }?>
    			<?php }?>
    	</tr>
    	<?php }?>
    	</table>
    	
    	<table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
        <tr><td colspan=3><B>＜＜　食事　＞＞</B></td></tr>
    	<?php if ($hotelPic->getCount() > 0) {?>
    	<tr>
    			<?php
    			$cnt = 0;
    			$cntAll = 0;
    			foreach ($hotelpics[2] as $ad) {
    			$cnt++;
    			?>
    
    					<td>
    						<a href="http://common.kokomo-oki.net/images/<?=$ad["HOTELPIC_DATA"]?>"><?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></a>
    					</td>
    					<?php 
    					if($cnt % 3 == 0){
    					?>
    					</tr><tr>
    					<?php }?>
    			<?php }?>
    	</tr>
    	<?php }?>
    	</table>
    	
    	<table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
        <tr><td colspan=3><B>＜＜　館内施設　＞＞</B></td></tr>
    	<?php if ($hotelPic->getCount() > 0) {?>
    	<tr>
    			<?php
    			$cnt = 0;
    			$cntAll = 0;
    			foreach ($hotelpics[3] as $ad) {
    			$cnt++;
    			?>
    
    					<td>
    						<a href="http://common.kokomo-oki.net/images/<?=$ad["HOTELPIC_DATA"]?>"><?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></a>
    					</td>
    					<?php 
    					if($cnt % 3 == 0){
    					?>
    					</tr><tr>
    					<?php }?>
    			<?php }?>
    	</tr>
    	<?php }?>
    	</table>
    	
    	<table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
        <tr><td colspan=3><B>＜＜　風景　＞＞</B></td></tr>
    	<?php if ($hotelPic->getCount() > 0) {?>
    	<tr>
    			<?php
    			$cnt = 0;
    			$cntAll = 0;
    			foreach ($hotelpics[4] as $ad) {
    			$cnt++;
    			?>
    
    					<td>
    						<a href="http://common.kokomo-oki.net/images/<?=$ad["HOTELPIC_DATA"]?>"><?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></a>
    					</td>
    					<?php 
    					if($cnt % 3 == 0){
    					?>
    					</tr><tr>
    					<?php }?>
    			<?php }?>
    	</tr>
    	<?php }?>
    	</table>
    	
    	<table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
        <tr><td colspan=3><B>＜＜　その他　＞＞</B></td></tr>
    	<?php if ($hotelPic->getCount() > 0) {?>
    	<tr>
    			<?php
    			$cnt = 0;
    			$cntAll = 0;
    			foreach ($hotelpics[5] as $ad) {
    			$cnt++;
    			?>
    
    					<td>
    						<a href="http://common.kokomo-oki.net/images/<?=$ad["HOTELPIC_DATA"]?>"><?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></a>
    					</td>
    					<?php 
    					if($cnt % 3 == 0){
    					?>
    					</tr><tr>
    					<?php }?>
    			<?php }?>
    	</tr>
    	<?php }?>
    	</table>
    	<?php if($hotelpics[6]){ ?>
    		<?php foreach ($hotelpics[6] as $key=>$ads){?>
    		<table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
        <tr><td colspan=3><?php print $hotelPicGroup->getByKey($key, "HOTELPICGROUP_NAME");?></td></tr>
    	<?php if ($hotelPic->getCount() > 0) {?>
    	<tr>
    			<?php
    			$cnt = 0;
    			$cntAll = 0;
    			foreach ($ads as $ad) {
    			$cnt++;
    			?>
    
    					<td>
    						<a href="http://common.kokomo-oki.net/images/<?=$ad["HOTELPIC_DATA"]?>"><?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></a>
    					</td>
    					<?php 
    					if($cnt % 3 == 0){
    					?>
    					</tr><tr>
    					<?php }?>
    			<?php }?>
    	</tr>
    	<?php }?>
    	</table>
    		<?php }?>
    	<?php }?>
    	</div>
    	</article>
        	
        <!--<article class="mainbox" style="margin-top:-20px;">
        <div class="tabframe dspNon">
         	<p>ただいま準備中です。どうぞお楽しみに！</p>
        </div>
        </article>-->
        
        <!--<article class="mainbox" style="margin-top:-20px;">
        <div class="tabframe dspNon">
         	<p>ただいま準備中です。どうぞお楽しみに！</p>
     	</div>
     	</article>-->

			<!-- 地図・アクセス -->
		<article class="mainbox" style="margin-top:-20px;">
     	<div class="tabframe   <?php if(!$_GET['map']):?>dspNon<?php endif;?>">
     	<table border="0" cellpadding="0" cellspacing="10" class="" summary="管理者" width="100%">
				<tr>
					<th>住所</th>
					<td>
					<?php print $hotel_address;?>
					</td>
				</tr>
				<tr>
				<th>電話番号</th><td><?php print $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_TEL")?>
				</tr>
				<tr>
        				<th>アクセス</th><td><p style="word-break:break-all; "><?php print redirectForReturn($hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_ACCESS_SUM"))?></p></td>
        			</tr>
			</table>
			<div id="map-canvas" style="width:920px; height:500px;"></div>
			<br />
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