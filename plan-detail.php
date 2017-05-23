<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/ShopAccess.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/mArea.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategory.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategoryDetail.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mTag.php');

$dbMaster = new dbMaster();

 // print_r($_POST);
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
		//	$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
}
else {
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["cid"]);
	$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $_GET["pid"]);
	$collection->setByKey($collection->getKeyValue(), "priceper_num", $_GET["num"]);
	
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
	  	if($_GET["undecide_sch"] != ""){
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", $_GET["undecide_sch"]);
	  	}
	 	else{
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", "2");
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

//company_idに属するplan_idでない場合にエラーを起こすチェッカーつける



//print_r($collection);exit;

$shopTarget = new shop($dbMaster);
$shopTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$reportTarget = new kuchikomi($dbMaster);
$reportTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$mArea = new mArea($dbMaster);
$mArea->selectListGroup($collection);

$mActivityCategory = new mActivityCategory($dbMaster);
$mActivityCategory->selectList($collection);

$mActivityCategoryDetail = new mActivityCategoryDetail($dbMaster);
$mActivityCategoryDetail->selectList($collection);

$mTag = new mTag($dbMaster);
$mTag->selectList($collection);



	//	ココトモ
	$shopPlanTarget = new shopPlan($dbMaster);
	$shopPlanTarget->select($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

	$hotelRoom = new hotelRoom($dbMaster);
	$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

	$ShopAccess = new ShopAccess($dbMaster);
// 	$ShopAccess->select($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_MEET_PLACE1"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	$ShopAccess->select("", "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));


	
	foreach ($shopPlanTarget->getCollection() as $plan) {
		
//print_r($plan);
	}
	foreach ($collection->getCollection() as $param) {
		//print_r($param);
	}




$shop = new shop($dbMaster);

$shopBooking = new shopBooking($dbMaster);
$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", "");
//$shop->selectListPublicPlan($collection);

$planCnt = 0;
$dspArray = array();

$money_1 = "";
$money_all = "";



// reset calendar show flg
$calendarNoShowFlg = 0;

	$arPayList = array();

	//	料金カレンダー
	$hotelPay = new hotelPay($dbMaster);
	$hotelPayTarget = new hotelPay($dbMaster);

	//	料金設定検索
	//print_r($shopPlanTarget);
	$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ACC_DAY", $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_DAY"));
//	$collection->setByKey($collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
//print_r($collection);
	$hotelPay->selectListMin($collection);
 
//	print_r($hotelPay);
	
	//	登録済みデータ設定
	if ($hotelPay->getCount() > 0) {
		foreach ($hotelPay->getCollection() as $hp) {
	//print_r($hp);
			//	POSTデータ
			$arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"]        = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["SHOP_PRICETYPE_ID"] = $hp["SHOP_PRICETYPE_ID"];
			$arPayList[$hp["HOTELPAY_DATE"]]["priceper_num"]      = $collection->getByKey($collection->getKeyValue(), "priceper_num");

			$arPayList[$hp["HOTELPAY_DATE"]]["date"]        = $hp["HOTELPAY_DATE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ID"] = $hp["HOTELPAY_ID"];

			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY_FLG"]   = $hp["HOTELPAY_MONEY_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE"]     = $hp["HOTELPAY_SERVICE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_REMARKS"]     = $hp["HOTELPAY_REMARKS"];
			
			//------------------start-------------------//

			//各日程の料金書き出す
			for ($i=1; $i<=1; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $hp["HOTELPAY_DATE"]);
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

				$room_perday = $shop->selectMoneyEveryRoomDay($search_collection);	
//print_r($room_perday);
				if($room_perday != ""){
					$roomPerDay[$i] = $room_perday;	
				}

			}
			//	print_r($roomPerDay);
			
			$money_perperson = "";
			$money_totol     = 0;
			for ($i=1; $i<=1; $i++){
				$money_perperson[$i] = $roomPerDay[$i]["money_perperson"];
				$money_totol        += $roomPerDay[$i]["money_ALL"];
				$calender_price      = $roomPerDay[$i]["calender_price"];
				$calender_room       = $roomPerDay[$i]["calender_room"];
			}
			asort($money_perperson);
//			print_r($money_perperson);
	
			$arPayList[$hp["HOTELPAY_DATE"]]["money_all"] = $money_totol;
			$arPayList[$hp["HOTELPAY_DATE"]]["money_1"]   = $money_perperson[1];
			$arPayList[$hp["HOTELPAY_DATE"]]["diff_flg"]  = $diff_flg;

			// カレンダーに表示する代表料金・在庫ステータス
			$arPayList[$hp["HOTELPAY_DATE"]]["calender_price"] = $calender_price;
			$arPayList[$hp["HOTELPAY_DATE"]]["calender_room"]  = $calender_room;

			$arPayList[$hp["HOTELPAY_DATE"]]["SHOPPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");

			//------------------end-------------------//
			
			//$arPayList[$hp["HOTELPAY_DATE"]]["money_all"] = $hp["money_all"];
			//$arPayList[$hp["HOTELPAY_DATE"]]["money_1"] = $hp["money_1"];
			
			//当日の予約数
			$collection_booked = new collection($db);
			$collection_booked->setByKey($collection->getKeyValue(), "COMPANY_ID", $arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $data["SHOPPLAN_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "BOOKING_DATE", $arPayList[$hp["HOTELPAY_DATE"]]["date"]);

			//$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPROVIDE_BOOKEDNUM"] = $shopBooking->selectBookedNum($collection_booked);
//			print_r($arPayList[$hp["HOTELPAY_DATE"]]["HOTELPROVIDE_BOOKEDNUM"]);
			
		}
	}

	//print_r($arPayList);

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




 //print_r($arPayList);


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$shopTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();

// <<<<< add settenLab
$arrShopAccess = array();
foreach($ShopAccess->getCollection() as $shop){
	$arrShopAccess[$shop['SHOP_ACCESS_ID']] = $shop;
}
// >>>>> add settenLab
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("includes/box/common/meta_detail.php"); ?>
<title>プラン詳細 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="プラン,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />


<!-- ?窗 -->
<script type="text/javascript" src="/js/common.js"></script>
<link rel="stylesheet" href="<?php print URL_PUBLIC?>common/css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>common/js/popupwindow-1.6.js"></script>
<script type="text/javascript" src="/js/lineup.js"></script>
<style>
.dspNon {
	display: none;
}
</style>

<script>
	jQuery(function($){
		$(".line_box").lineUp({
			onFontResize : false,
			onResize : false
		});
	});
</script>

<script type="text/javascript"> 
$(document).ready(function() {
	$(".content").hide(); 
	$("ul.tabs li:first").addClass("active").show(); 
	$(".content:first").show(); 
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); 
		$(this).addClass("active");
		$(".content").hide();
		var activeTab = $(this).find("a").attr("href"); 
		$(activeTab).fadeIn();
		return false;
	});
});
</script>

</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail_plan" class="searchdetail">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">検索結果</a></li>
            <li><span>プラン詳細</span></li>
        </ul>

	<!-- プラン詳細 -->
	<article id="detail_plan">

		<!-- ショップメニュー -->
		<section id="detail_menu">
			<ul>
				<li>
					<a href="/shop-detail.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">ショップ情報</a>
				</li>
				<li>
					<a href="/shop-search.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">プラン一覧</a>
				</li>
				<!-- 
				<li>
					<a href="/shop-report.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">レポート</a>
				</li>
				 -->
				<li>
					<a href="/shop-gallery.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">写真・動画</a>
				</li>
				<li>
					<a href="/shop-map.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">地図・アクセス</a>
				</li>
				<!-- 
				<li>
					<a href="/shop-etc.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">その他</a>
				</li>
				 -->
			<ul>
		</section>
		<!-- /ショップメニュー -->


		<section id="plan_name">
			<h1><?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?></h1>
		</section>

		<section id="shop_name">
			<h2>[催行会社] <?php print $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME")?></h2>
		</section>

		<section id="area_tag">
			<div>
				<h2>エリア</h2>
				<ul class="area">
       			<?php
				foreach($mArea->getCollection() as $area){
			?>

				<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AREA_LIST1") !=""){
					     if($area["M_AREA_ID"] == $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AREA_LIST1")){?>
					<li>
						<?php print ($area["M_AREA_NAME"])?>エリア
					</li>
				<?php	    }
				      }
				?>
				<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AREA_LIST2") !=""){
					     if($area["M_AREA_ID"] == $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AREA_LIST2")){?>
					<li>
						<?php print " ＞ ".$area["M_AREA_NAME"]?>
					</li>
				<?php	    }
				      }
				?>
				<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AREA_LIST3") !=""){
					     if($area["M_AREA_ID"] == $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AREA_LIST3")){?>
					<li>
						<?php print " ＞ ".$area["M_AREA_NAME"]?>
					</li>
				<?php	    }
				      }
				?>
			<?php
				}
			?>

				</ul>
			</div>
			<div>
				<h2>カテゴリ</h2>
				<ul class="category">
       			<?php
				foreach($mActivityCategory->getCollection() as $ac){
			?>

				<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY1") !=""){
					     if($ac["M_ACT_CATEGORY_ID"] == $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY1")){?>
					<li>
						<?php print ($ac["M_ACT_CATEGORY_NAME"])?>
					</li>
				<?php	    }
				      }
				?>
				<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY2") !=""){
					     if($ac["M_ACT_CATEGORY_ID"] == $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY2")){?>
					<li>
						<?php print " ＞ ".$ac["M_ACT_CATEGORY_NAME"]?>
					</li>
				<?php	    }
				      }
				?>
				<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY3") !=""){
					     if($ac["M_ACT_CATEGORY_ID"] == $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY3")){?>
					<li>
						<?php print " ＞ ".$ac["M_ACT_CATEGORY_NAME"]?>
					</li>
				<?php	    }
				      }
				?>
			<?php
				}
			?>
       			<?php
				foreach($mActivityCategoryDetail->getCollection() as $acd){
			?>
				<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY_DETAIL") !=""){
					     if($ac["M_ACT_D_CATEGORY_ID"] == $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATEGORY_DETAIL")){?>
					<li>
						<?php print " ＞ ".$ac["M_ACT_D_CATEGORY_NAME"]?>
					</li>
				<?php	    }
				      }
				?>
			<?php
				}
			?>
				</ul>
			</div>
			<!-- 
			<div>
				<h2>レポート</h2>
				<a href=""><?php print count($reportTarget);?> 件</a>
			</div>
			 -->
		</section>


		<!-- leftコンテンツ -->
		<section id="left">
		
			<section id="plan_tag">
				<div>
					<ul class="tag">
					<?php
						$arTag = array();
						$arTemp = explode(":", $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_TAG_LIST"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arTag[$data] = $data;
								}
							}
						}
	
						$tagCnt = 0;
						if (count($arTag) > 0) {
							foreach ($arTag as $d) {
								$tagCnt++;
								foreach($mTag->getCollection() as $tag){
									if($tag["M_TAG_ID"] == $d){
										echo "<li>".$tag["M_TAG_NAME"]."</li>";
									}
								}
							}
						}
						?>
					</ul>
				</div>
			</section>

			<section id="pic">
				<div id="mainimage" class="main">
					<?php if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC1") != ""){ ?>
						<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC1")?>" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>">
					<?php }else{?>
						<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>">
					<?php }?>

				</div>

				<ul id="subimage" class="sub">
						<?php for ($i=1; $i<=4; $i++) {?>
							<?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC".$i) != "") {?>
								<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PIC".$i)?>" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>"></a>
							<?php }?>
						<?php }?>
				</ul>
			</section>

			<section id="description">
				<h2><?php print redirectForReturn($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CATCH"))?></h2>
				<h3><?php print redirectForReturn($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_DISCRIPTION"))?></h3>
			</section>

			<section id="pr">
				<h2>プランの魅力</h2>
				<ul>
					<?php for ($i=1; $i<=9; $i++) {?>
					 	<?php if ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_POINT_TEXT".$i) != "") {?>
							<li class="line_box">
							<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_POINT_PIC".$i)?>" alt="<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME")?>">
							<h3><?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_POINT_TEXT".$i)?></h3>
						<?php }?>
					<?php }?>
				</ul>
			</section>
		</section>



		<!-- rightコンテンツ -->


		<?php
			// 締め切り時間・キャンセル時間変換
			
			$arrHourConv = array();
			$hour_start = 5;
			for($i = 1; $i <= 20;$i++){
				$arrHourConv[$i] = $hour_start;
				$hour_start++;
			}
			
			$arrMinConv = array();
			$min_start = 0;
			for($i = 1; $i <= 12;$i++){
				$arrMinConv[$i] = $min_start;
				$min_start += 5;
			}
			// 締め切り時間
			$acc_day  = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_DAY");
			$acc_hour = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_HOUR");
			$acc_min  = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_MIN");
			
			$acc_hour = $arrHourConv[$acc_hour];
			$acc_min  = $arrMinConv[$acc_min];
			
			// キャンセル時間
			$can_day  = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CAN_DAY");
			$can_hour = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CAN_HOUR");
			$can_min  = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CAN_MIN");
				
			$can_hour = $arrHourConv[$can_hour];
			$can_min  = $arrMinConv[$can_min];
			
// 			if($acc_hour == 1){$acc_hour = 5;}
// 			elseif($acc_hour == 2){$acc_hour = 6;}
// 			elseif($acc_hour == 3){$acc_hour = 7;}
// 			elseif($acc_hour == 4){$acc_hour = 8;}
// 			elseif($acc_hour == 5){$acc_hour = 9;}
// 			elseif($acc_hour == 6){$acc_hour = 10;}
// 			elseif($acc_hour == 7){$acc_hour = 11;}
// 			elseif($acc_hour == 8){$acc_hour = 12;}
// 			elseif($acc_hour == 9){$acc_hour = 13;}
// 			elseif($acc_hour == 10){$acc_hour = 14;}
// 			elseif($acc_hour == 11){$acc_hour = 15;}
// 			elseif($acc_hour == 12){$acc_hour = 16;}
// 			elseif($acc_hour == 13){$acc_hour = 17;}
// 			elseif($acc_hour == 14){$acc_hour = 18;}
// 			elseif($acc_hour == 15){$acc_hour = 19;}
// 			elseif($acc_hour == 16){$acc_hour = 20;}
// 			elseif($acc_hour == 17){$acc_hour = 21;}
// 			elseif($acc_hour == 18){$acc_hour = 22;}
// 			elseif($acc_hour == 19){$acc_hour = 23;}
// 			elseif($acc_hour == 20){$acc_hour = 24;}

// 			if($acc_min == 1){$acc_min = 00;}
// 			elseif($acc_min == 2){$acc_min = 05;}
// 			elseif($acc_min == 3){$acc_min = 10;}
// 			elseif($acc_min == 4){$acc_min = 15;}
// 			elseif($acc_min == 5){$acc_min = 20;}
// 			elseif($acc_min == 6){$acc_min = 25;}
// 			elseif($acc_min == 7){$acc_min = 30;}
// 			elseif($acc_min == 8){$acc_min = 35;}
// 			elseif($acc_min == 9){$acc_min = 40;}
// 			elseif($acc_min == 10){$acc_min = 45;}
// 			elseif($acc_min == 11){$acc_min = 50;}
// 			elseif($acc_min == 12){$acc_min = 55;}

			//$acc_datetime = $acc_day." ".$acc_hour.":".$acc_min;
		?>


		<section id="right">
			<section id="btn">
				<a href="#calenderlink"><p class="btn_cal">空き状況を見る</p></a>
			</section>

			<section id="base">
				<table>
					<tr>
						<th>
							料金(税込) 

						</th>
					</tr>
					<tr>
						<td class="price">
							<span>
								<?php 
									$search_date = $collection->getByKey($collection->getKeyValue(), "search_date");
									if(empty($search_date)){
										$search_date = date('Y-m-d');
									}else{
										$search_date = preg_replace("/年|月/", "-", $search_date);
										$search_date = preg_replace("/日/", "", $search_date);
									}
									echo number_format($arPayList[$search_date]['money_all']);
// 									print number_format($collection->getByKey($collection->getKeyValue(), "calender_mon))；
								?>
							</span>円～
						</td>
					</tr>

					<tr>
						<th>
							所要時間
						</th>
					</tr>
					<tr>
						<td>
							～<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ALL_TIME")?>
						</td>
					</tr>
					<tr>
						<th>
							対象年齢
						</th>
					</tr>
					<tr>
						<td>
							<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AGE_FROM")?>歳～<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AGE_TO")?>歳
						</td>
					</tr>
					<tr>
						<th>
							開催期間
						</th>
					</tr>
					<tr>
						<td>
							<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_FROM")?>～<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO")?>
						</td>
					</tr>
					<tr>
						<th>
							予約締切
						</th>
					</tr>
					<tr>
						<td>
							<?php print $acc_day?>日前の<?php echo sprintf('%02d',$acc_hour); ?>時<?php echo sprintf('%02d',$acc_min); ?>分まで
						</td>
					</tr>
					<tr>
						<th>
							集合場所
						</th>
					</tr>
					<tr>
						<td>
							<ul>
							<?php 
								for($i = 1; $i <= 3; $i++){
									${"shop_access_id".$i}  = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_MEET_PLACE".$i);
									$access_id = ${"shop_access_id".$i};
									if(!empty($access_id)){
										echo "<li>".$arrShopAccess[$access_id]['SHOP_ACCESS_NAME']."</li>";
									}
								}
							?>
							</ul>
						</td>
					</tr>
					<tr>
						<th>
							体験場所
						</th>
					</tr>
					<tr>
						<td>
							<?php echo $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PLAY_PLACE"); ?>
						</td>
					</tr>

				</table>

				<div class="btn_cal"><a href="#calender"></a></div>

			</section>

			<!-- 
			<section id="report">
				<h2>このプランの体験レポート</h2>
				<a href="">
					<ul>
						<li class="img">
							<img src="/images/common/test.png" alt="">
						</li>
						<li class="text">
							<p>
							テキストテキストテキストテキストテキストテキストテキストテキストテキスト
							</p>
						</li>
					</ul>
				</a>
			</section>

			<section id="panorama">
				<h2>360度パノラマビュー</h2>
				<a href="http://pn.3d-pace.com/azimut/" target="_blank">
					<ul>
						<li class="img">
							<img src="/images/common/test.png" alt="">
						</li>
						<li class="text">
							<p>
							クリックでバーチャル体験ツアーをスタート！まるで実際に体験しているようなリアル体験♪

							</p>
						</li>
					</ul>
				</a>	
			</section>
			 -->
		</section>


		<section id="detail_box">

			<!-- info メニュー -->
			<section id="info_menu">
				<ul class="tabs">
					<li class="active">
						<a href="#info_main">基本情報</a>
					</li>
					<li class="">
						<a href="#info_plan">プラン詳細</a>
					</li>
					<li class="">
						<a href="#info_access">集合場所・体験場所</a>
					</li>
					<li class="">
						<a href="#info_etc">参加条件、その他備考・特記事項</a>
					</li>
				<ul>
			</section>
			<!-- /info メニュー -->

			<section id="info_main" class="content">
			<h3 class="info_label">基本情報</h3>
				<table>
					<tr>
						<th>
							料金に含まれるもの
						</th>
						<td>
							<?php echo nl2br($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_INCLUDE")); ?><br>
							【別途費用】<br>
							<?php echo nl2br($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_OPTION")); ?>
						</td>
					</tr>
					<tr>
						<th>
							開催期間
						</th>
						<td>
							<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_FROM")?>～<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO")?>
						</td>
					</tr>
					<tr>
						<th>
							所要時間
						</th>
						<td>
							<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ALL_TIME")?>
						</td>
					</tr>
					<tr>
						<th>
							最少催行人数
						</th>
						<td>
							<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_DEPARTS_MIN")?>人<br>
							【申し込み可能人数】<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ENTRY_FROM")?>～<?php print $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ENTRY_TO")?>人
						</td>
					</tr>
					<tr>
						<th>
							予約締切
						</th>
						<td>
							<?php print $acc_day?>日前の<?php echo sprintf('%02d',$acc_hour); ?>時<?php echo sprintf('%02d',$acc_min); ?>分まで
						</td>
					</tr>

				</table>
			</section>

			<section id="info_plan" class="content">
			<h3 class="info_label">プラン詳細</h3>
				<table>
					<tr>
						<th>
							体験のスケジュール・詳細
						</th>
						<td>
							<?php
								for($i = 1; $i <= 8; $i++){
									$s_title = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SCEDULE_TITLE".$i);
									$s_time  = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SCEDULE_TIME".$i);
									
									if(!empty($s_title)){
										echo $s_title;
									}
									if(!empty($s_time)){
										echo "&nbsp(約".$s_time."分)";
									}
									
									if(!empty($s_title) || !empty($s_time)){
										echo "<br>";
									}
								}
							?>
						</td>
					</tr>
					<tr>
						<th>
							お支払方法について
						</th>
						<td>
							【決済方法】<br>
							<?php
								$arrPayment = array(
									1 => '現地で現金決済',
									2 => '現地でカード決済',
									3 => '事前に現金決済(銀行振込等)',
									4 => '事前にカード決済'
								);
								$card_flg = false;
								for($i = 1; $i <= 4; $i++){
									$payment = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PAYMENT".$i);
									
									if(!empty($payment) && $payment == 1){
										// カード利用フラグ
										if($i == 2 || $i == 4){
											$card_flg = true;
										}
										echo $arrPayment[$i]."<br>";
									}
								}
							?>
							<?php
								// ご利用可能カード
								if($card_flg){
									$arrCardData = cmShopCard();
									$arrCardText = array();
									
									$shop_charge_card = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_CHARGE_CARD");
									
									$arrShopCardCharge = array();
									$arrShopCardCharge = explode(":", $shop_charge_card);
									$arrShopCardCharge = array_values(array_filter($arrShopCardCharge));
									
									foreach($arrShopCardCharge as $card_id){
										$arrCardText[] = $arrCardData[$card_id];
									}
									
									$cardTxt = implode("&nbsp;/&nbsp;", $arrCardText);
									
									echo "<br>"."【ご利用可能カード】"."<br>";
									echo $cardTxt."<br>";
								}
							?>
							<?php
								$other_payment = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PAYMENT5");
								if(!empty($other_payment)){
									echo "<br>"."【その他の決済方法】<br>".nl2br($other_payment)."<br>";
								}
							?>
						</td>
					</tr>
					<tr>
						<th>
							キャンセル・変更について
						</th>
						<td>
							【予約キャンセル締め切り】<br>
							<?php print $can_day?>日前の<?php echo sprintf('%02d',$can_hour); ?>時<?php echo sprintf('%02d',$can_min); ?>分まで
							
							<?php
								// 基本キャンセル規定が設定されている場合はキャンセル規定を表示する
								// 標準設定
								if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_FLG_CANCEL") == 1){
									// ショップで登録されている規定を表示する
									if($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1){
										echo "<br><br>"."【キャンセル規定】"."<br>";
										$list_cnt = 1;
										for($i = 1; $i <= 7; $i++){
											if($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1){
												$divide = $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i);
												$pay    = $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i);
												
												echo $list_cnt.")";
												if($i == 1){
													echo "無断キャンセルの場合&nbsp;";
												} elseif($i == 2) {
													echo "当日キャンセルの場合&nbsp;";
												} else {
													$can_date_from = $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i);
													$can_date_to   = $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i);
													
													echo "催行日の".$can_date_from."日前&#x301c;".$can_date_to."日前までのキャンセル&nbsp;";
												}
												
												if ($divide == 1) {
													echo "プラン料金の".$pay."%";
												} else {
													echo number_format($pay)."円";
												}
												
												echo "<br>";
												$list_cnt++;
											}
										}
									}
								// 個別設定
								} else {
									// プランに設定されている規定を表示する
									echo "<br><br>"."【キャンセル規定】"."<br>";
									$list_cnt = 1;
									for($i = 1; $i <= 6; $i++){
										$divide = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i);
										$pay    = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i);
										if(!empty($divide)){
											echo $list_cnt.")";
											if($i == 1){
												echo "無断キャンセルの場合&nbsp;";
											} elseif($i == 2) {
												echo "当日キャンセルの場合&nbsp;";
											} else {
												$can_date_from = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i);
												$can_date_to   = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CANCEL_TO".$i);
													
												echo "催行日の".$can_date_from."日前&#x301c;".$can_date_to."日前までのキャンセル&nbsp;";
											}
								
											if ($divide == 1) {
												echo "プラン料金の".$pay."%";
											} else {
												echo number_format($pay)."円";
											}
								
											echo "<br>";
											$list_cnt++;
										}
									}
								}
							?>
						</td>
					</tr>
					<tr>
						<th>
							開催条件・天候不良による中止について
						</th>
						<td>
							<?php
								$stop1 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP1");
								if(!empty($stop1)){
									echo "【雨天時催行】<br>".$stop1."<br>";
								}
								$stop2 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP2");
								if(!empty($stop2)){
									echo "<br>"."【天候不良・自然災害による中止】<br>".$stop2."<br>";
								}
								$stop3 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP3");
								if(!empty($stop3)){
									echo "<br>"."【機材・設備故障による中止】<br>".$stop3."<br>";
								}
								$stop4 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP4");
								if(!empty($stop4)){
									echo "<br>"."【内容変更】<br>".$stop4."<br>";
								}
								$stop5 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP5");
								if(!empty($stop5)){
									echo "<br>"."【中止の確認方法】<br>".$stop5."<br>";
								}
								$stop6 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP6");
								if(!empty($stop6)){
									echo "<br>"."【中止連絡日】<br>".$stop6."<br>";
								}
								$stop7 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP7");
								if(!empty($stop7)){
									echo "<br>"."【中止連絡時間】<br>".$stop7."<br>";
								}
								$stop8 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_STOP8");
								if(!empty($stop8)){
									echo "<br>"."【中止時の対応】<br>".$stop8."<br>";
								}
								
								$etc = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ETC");
								if(!empty($etc)){
									echo "<br>".nl2br($etc);
								}
							?>
						</td>
					</tr>
					<tr>
						<th>
							お客様にご用意いただくもの（服装・持ち物など）
						</th>
						<td>
							<?php
								$preparation = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_GUEST_PREPARATION");
								if(!empty($preparation)){
									echo nl2br($preparation);
								}
							?>
						</td>
					</tr>
				</table>
			</section>

			<section id="info_access" class="content">
			<h3 class="info_label">集合場所・体験場所</h3>
				<table>
					<tr>
						<th>
							集合時間
						</th>
						<td>
							<ul>
								<?php
									$meet_cnt = 1;
									for($i = 1; $i <= 12; $i++){ 
										$meet_hour = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_MEET_TIMEHOUR".$i);
										$meet_min  = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_MEET_TIMEMIN".$i);
										if(!empty($meet_hour) && !empty($meet_min)){
											echo "<li>".$meet_cnt.")&nbsp;".sprintf('%02d',$arrHourConv[$meet_hour])."時".sprintf('%02d',$arrMinConv[$meet_min])."分</li>";
											$meet_cnt++;
										}
									}
								?>
							</ul>
						</td>
					</tr>
					<tr>
						<th>
							集合場所
						</th>
						<td>
							<?php //TODO 公開時APIキーを取得して設定 ?>
							<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARHX6DkSJkgcGW2ZtJiQquQnbqnskxoNI" type="text/javascript"></script>
							<ul>
								<?php for($i = 1; $i <= 3; $i++): ?>
									<li class="address">
										<?php
											$access_id = ${"shop_access_id".$i};
											if(!empty($access_id)){
												echo $i.")&nbsp;".$arrShopAccess[$access_id]['SHOP_ACCESS_ADDRESS'];
											}
										?>
									</li>
									<!-- 地図マップ -->
									<li class="address_map">
										<div id="address_map<?php echo $i; ?>" style='width: 800px; height: 300px;'></div>
										<script type="text/javascript">
										$(function() {
											var query = '<?php echo $arrShopAccess[$access_id]['SHOP_ACCESS_ADDRESS']; ?>';
											var lon = '';
											var lat = '';
											var geocoder;
											var map;

											var init_flg = true;
											
											function initialize() {
												$("#info_access").show();
												geocoder = new google.maps.Geocoder();
												var myOptions = {
													center: new google.maps.LatLng(lon, lat),
													zoom: 18,
													mapTypeId: google.maps.MapTypeId.ROADMAP  
												}
												map = new google.maps.Map(document.getElementById("address_map<?php echo $i; ?>"),myOptions);
												google.maps.event.addDomListener(map, 'tilesloaded', codeAddress);
// 												codeAddress();
// 												google.maps.event.trigger(map, 'resize');
// 												map.checkResize();
											}
											function codeAddress() {
												var address = query;
												if(init_flg){
													geocoder.geocode({ 'address': address }, function (results, status) {
														if (status == google.maps.GeocoderStatus.OK) {
															map.setCenter(results[0].geometry.location);
															var marker = new google.maps.Marker({
																map: map,
																position: results[0].geometry.location,
																title:address,
																animation: google.maps.Animation.DROP 
															});
															var infowindow = new google.maps.InfoWindow({
																content: "<span style='font-size:11px'><b>住所：</b>" + address + "</span>",
																pixelOffset:0, 
																position: results[0].geometry.location
												
															});
															google.maps.event.addListener(marker, 'click', function () { infowindow.open(map, marker); });
														} else {
															//alert("この住所が存在しておりません");
														}
													});
												
													$("#info_access").hide();
													init_flg = false;
												}
											}
											google.maps.event.addDomListener(window, 'load', initialize);
											
										});
										</script>
									</li>
								<?php endfor;?>
							</ul>
						</td>
					</tr>
					<tr>
						<th>
							アクセス
						</th>
						<td>
							<ul>
								<?php for($i = 1; $i <= 3; $i++): ?>
									<li class="address">
										<?php
											$access_id = ${"shop_access_id".$i};
											if(!empty($access_id)){
												echo $i.")&nbsp;".$arrShopAccess[$access_id]['SHOP_ACCESS_ROUTE'];
											}
										?>
									</li>
								<?php endfor;?>
							</ul>
						</td>
					</tr>
					<tr>
						<th>
							駐車場について
						</th>
						<td>
							<ul>
								<?php for($i = 1; $i <= 3; $i++): ?>
									<?php
										$access_id = ${"shop_access_id".$i};
										$txt = "";
										if(!empty($access_id)){
											$txt .= "<li style='margin-bottom: 15px;'>";
											$txt .= "-------------------------- 集合場所".$i."--------------------------<br>";
											// 駐車場あり
											if($arrShopAccess[$access_id]['SHOP_ACCESS_PARKINGFLG'] == 1){
												$txt .= "駐車場あり<br>";
												
												$txt .= "<br>"."【駐車場料金】"."<br>";
												// 無料・有料
												if($arrShopAccess[$access_id]['SHOP_ACCESS_PARKINGMONEYFLG'] == 1){
													$txt .= "無料"."<br>";
												}else{
													$txt .= "有料"."<br>";
													// 有料の場合の料金
													if(!empty($arrShopAccess[$access_id]['SHOP_ACCESS_PARKINGMONEY'])){
														$txt .= nl2br($arrShopAccess[$access_id]['SHOP_ACCESS_PARKINGMONEY']);
													}
												}
												$txt .= "<br>";
												
												// 駐車場の事前予約
												$txt .= "<br>"."【駐車場の事前予約】"."<br>";
												if($arrShopAccess[$access_id]['SHOP_ACCESS_PARKINGBOOKFLG'] == 1){
													$txt .= "不要"."<br>";
												}else{
													$txt .= "必要"."<br>";
												}
												
												// 駐車台数
												$txt .= "<br>"."【駐車台数】"."<br>";
												$txt .= $arrShopAccess[$access_id]['SHOP_ACCESS_PARKINGCAP']."台";
												
												$txt .= "<br><br>";
												
												// 画像
												$txt .= "<ul>";
												for ($j = 1; $j <= 4; $j++) {
													if ($arrShopAccess[$access_id]['SHOP_ACCESS_PIC'.$j] != "") {
														$txt .= "<li style='display: inline-block;margin-right: 5px;'>";
														$txt .= "<img src='".URL_SLAKER_COMMON."images/". $arrShopAccess[$access_id]['SHOP_ACCESS_PIC'.$j]."' alt='ショップアクセス".$i.$j."' style='width: 180px;'>";
														$txt .= "<h3>".nl2br($arrShopAccess[$access_id]['SHOP_ACCESS_PIC_DISCRIPTION'.$j])."</h3>";
														$txt .= "</li>";
													}
												}
												$txt .= "</ul>";
											// 駐車場なし
											}else{
												$txt .= "駐車場なし";
											}
											
											$txt .= "</li>";
											echo $txt;
										}
									?>
								<?php endfor;?>
							</ul>
						</td>
					</tr>
				</table>
			</section>

			<section id="info_etc" class="content">
			<h3 class="info_label">参加条件・その他備考・特記事項</h3>
				<table>
					<tr>
						<th>
							対象年齢
						</th>
						<td>
							<?php echo $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AGE_FROM"); ?>歳&#x301c;<?php echo $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_AGE_TO"); ?>歳
							
							<?php
								$plan_parent = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PARENT1");
								$plan_parent2 = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_PARENT2");
								if(!empty($plan_parent)){
									echo "<br> [保護者同伴]&nbsp;".$plan_parent."歳未満";
								}
								if(!empty($plan_parent2)){
									echo "<br> [保護者同意]&nbsp;".$plan_parent2."歳未満";
								}
							?>
						</td>
					</tr>
					<tr>
						<th>
							参加資格
						</th>
						<td>
							<?php echo nl2br($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_LISENCE")); ?>
						</td>
					</tr>
					<tr>
						<th>
							その他備考
						</th>
						<td>
							<?php echo nl2br($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_CAUTION")); ?>
						</td>
					</tr>
				</table>
			</section>

		</section>
	</article><!-- /#detail_plan -->
	<!-- /プラン詳細 -->
	
	<?php
	//掲載期間が切れていたら警告文表示
	if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") < date("Y-m-d") && ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") != NULL)){
	?>
		<article class="mainbox" id="ag">
			<div class="inner">
				<center><b><font color="red">＞＞　ご指定のプランは販売期間が過ぎました。　＜＜</font></b></center>
			</div>
		</article>
	<?php }else{ ?>
	<?php }?>


	<!--カレンダー-->
	<section class="calender" id="calendar">
		<a name="calenderlink" id="calenderlink"></a>
	<h2>空き状況</h2>
	
	<div class="calendermain">
		
		<?php
			// 締め切り時間
			$acc_day = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_DAY");
			$acc_hour = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_HOUR");
			$acc_min = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_MIN");
			
			$acc_hour = $arrHourConv[$acc_hour];
			$acc_min  = $arrMinConv[$acc_min];
			
// 				if($acc_hour == 1){$acc_hour = 5;}
// 				elseif($acc_hour == 2){$acc_hour = 6;}
// 				elseif($acc_hour == 3){$acc_hour = 7;}
// 				elseif($acc_hour == 4){$acc_hour = 8;}
// 				elseif($acc_hour == 5){$acc_hour = 9;}
// 				elseif($acc_hour == 6){$acc_hour = 10;}
// 				elseif($acc_hour == 7){$acc_hour = 11;}
// 				elseif($acc_hour == 8){$acc_hour = 12;}
// 				elseif($acc_hour == 9){$acc_hour = 13;}
// 				elseif($acc_hour == 10){$acc_hour = 14;}
// 				elseif($acc_hour == 11){$acc_hour = 15;}
// 				elseif($acc_hour == 12){$acc_hour = 16;}
// 				elseif($acc_hour == 13){$acc_hour = 17;}
// 				elseif($acc_hour == 14){$acc_hour = 18;}
// 				elseif($acc_hour == 15){$acc_hour = 19;}
// 				elseif($acc_hour == 16){$acc_hour = 20;}
// 				elseif($acc_hour == 17){$acc_hour = 21;}
// 				elseif($acc_hour == 18){$acc_hour = 22;}
// 				elseif($acc_hour == 19){$acc_hour = 23;}
// 				elseif($acc_hour == 20){$acc_hour = 24;}

// 				if($acc_min == 1){$acc_min = 00;}
// 				elseif($acc_min == 2){$acc_min = 05;}
// 				elseif($acc_min == 3){$acc_min = 10;}
// 				elseif($acc_min == 4){$acc_min = 15;}
// 				elseif($acc_min == 5){$acc_min = 20;}
// 				elseif($acc_min == 6){$acc_min = 25;}
// 				elseif($acc_min == 7){$acc_min = 30;}
// 				elseif($acc_min == 8){$acc_min = 35;}
// 				elseif($acc_min == 9){$acc_min = 40;}
// 				elseif($acc_min == 10){$acc_min = 45;}
// 				elseif($acc_min == 11){$acc_min = 50;}
// 				elseif($acc_min == 12){$acc_min = 55;}

			//$acc_datetime = $acc_day." ".$acc_hour.":".$acc_min;
		?>



		<div class="howto">
			<ul>
				<li>体験ご希望の日程を選んでカレンダーをクリックして下さい。予約可能なコースの選択へ進みます。</li>
				<li class="view">
					<p>
						【カレンダーの見方】<br/>
						○･･･空きあり　□･･･リクエスト予約可能な空きあり（催行会社からの連絡をもって予約確定となります）×･･･空きなし　－･･･受付対象外
					</p>
				</li>
			</ul>
		</div>


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
			if (date("m",strtotime("-2 month" ,strtotime($SDate))) == date("m") and
				date("Y",strtotime("-2 month" ,strtotime($SDate))) == date("Y")) {
				//	前の月が当月
				$PDate = date("Y年m月d日");
			}
			else {
				$PDate = date("Y年m月01日",strtotime("-2 month" ,strtotime($SDate)));
			}
	
			if (date("Y年m月01日",strtotime("-1 month" ,strtotime($SDate))) < date("Y年m月01日") and
					date("Y",strtotime("-1 month" ,strtotime($SDate))) <= date("Y")) {
				$flgPrev = false;
			}
	
			//	次の月
			if (date("m",strtotime("2 month" ,strtotime($SDate))) == date("m") and
				date("Y",strtotime("2 month" ,strtotime($SDate))) == date("Y")) {
				//	次の月が当月
				$NDate = date("Y年m月d日");
			}
			else {
				$NDate = date("Y年m月01日",strtotime("2 month" ,strtotime($SDate)));
			}
		?>
		
		<?php if ($calendarNoShowFlg != 1) {?>
			<ul class="calenderMonth-Ln">
					<?php if ($flgPrev) {?>
					<li>
						<?php $formname = "frmPrev"?>
						<form action="plan-detail.html#calenderlink" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
							<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/month-back.png" width="91" height="29" alt="前の月" /></a>
							<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
							<?php print $inputs->hidden("SHOP_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"))?>
							<?php print $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))?>
							<!-- <?php print $inputs->hidden("search_date", $PDate)?> -->
							<input type="hidden" name="search_date" value="<?php echo $PDate;?>">
							<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
							<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
						</form>
					</li>
					<?php }?>
					<li style="float: right;">
						<?php $formname = "frmNext"?>
						<form action="plan-detail.html#calenderlink" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
							<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();" ><img src="./images/common/month-next.png" width="91" height="29" alt="次の月" /></a>
							<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
							<?php print $inputs->hidden("SHOP_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"))?>
							<?php print $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))?>
							<!-- <?php print $inputs->hidden("search_date", $NDate)?> -->
							<input type="hidden" name="search_date" value="<?php echo $NDate;?>">
							<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
							<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
						</form>
					</li>
				</ul>
					
			<div class="calender_tbl">
				<?php
					if (($collection->getByKey($collection->getKeyValue(), "search_date") != "") && ($collection->getByKey($collection->getKeyValue(), "calender") == "")) {
							$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
							$date = str_replace("月", "-", $date);
							$date = str_replace("日", "", $date);
						
						$next_month = date("Y-m-01",strtotime($date));
						$next_date = date("Y-m-01",strtotime('+1 month',strtotime($next_month)));
						//print($next_date);
						
						//print $date;
					}
					//	print_r($arPayList);
					//	$date = date("Y-m-d");
	
					//print $acc_datetime;
					print calendarPlan($date, $arPayList,$acc_day,$acc_hour,$acc_min);
					print calendarPlan($next_date, $arPayList,$acc_day,$acc_hour,$acc_min);
				?>
			
			</div>

		<?php }?>	
		
		<div class="aboutprice">

			<div>
				<h2>料金・お支払いについての備考</h2>
				<p>
					<?php
						if ($shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_CHARGE_FLG5") != "") { 
							echo nl2br($shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_CHARGE_FLG5"));
						}
					?>
				</p>
			</div>

		</div>

	</div>
	
</section>
	<!--カレンダー-->


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
