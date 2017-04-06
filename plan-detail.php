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
	$ShopAccess->select($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_MEET_PLACE1"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));


	
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
			$arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$arPayList[$hp["HOTELPAY_DATE"]]["SHOP_PRICETYPE_ID"] = $hp["SHOP_PRICETYPE_ID"];
			$arPayList[$hp["HOTELPAY_DATE"]]["priceper_num"] = $collection->getByKey($collection->getKeyValue(), "priceper_num");

			$arPayList[$hp["HOTELPAY_DATE"]]["date"] = $hp["HOTELPAY_DATE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_ID"] = $hp["HOTELPAY_ID"];

			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY_FLG"] = $hp["HOTELPAY_MONEY_FLG"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE"] = $hp["HOTELPAY_SERVICE"];
			$arPayList[$hp["HOTELPAY_DATE"]]["HOTELPAY_REMARKS"] = $hp["HOTELPAY_REMARKS"];
			
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
				<li>
					<a href="/shop-report.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">レポート</a>
				</li>
				<li>
					<a href="/shop-gallery.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">写真・動画</a>
				</li>
				<li>
					<a href="/shop-map.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">地図・アクセス</a>
				</li>
				<li>
					<a href="/shop-etc.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID")?>">その他</a>
				</li>
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
			<div>
				<h2>レポート</h2>
				<a href=""><?php print count($reportTarget);?> 件</a>
			</div>
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
				?>
							<li><?php print ($tag["M_TAG_NAME"])?></li>
					<?php
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
							// 締め切り時間
							$acc_day = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_DAY");
							$acc_hour = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_HOUR");
							$acc_min = $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_MIN");
								if($acc_hour == 1){$acc_hour = 5;}
								elseif($acc_hour == 2){$acc_hour = 6;}
								elseif($acc_hour == 3){$acc_hour = 7;}
								elseif($acc_hour == 4){$acc_hour = 8;}
								elseif($acc_hour == 5){$acc_hour = 9;}
								elseif($acc_hour == 6){$acc_hour = 10;}
								elseif($acc_hour == 7){$acc_hour = 11;}
								elseif($acc_hour == 8){$acc_hour = 12;}
								elseif($acc_hour == 9){$acc_hour = 13;}
								elseif($acc_hour == 10){$acc_hour = 14;}
								elseif($acc_hour == 11){$acc_hour = 15;}
								elseif($acc_hour == 12){$acc_hour = 16;}
								elseif($acc_hour == 13){$acc_hour = 17;}
								elseif($acc_hour == 14){$acc_hour = 18;}
								elseif($acc_hour == 15){$acc_hour = 19;}
								elseif($acc_hour == 16){$acc_hour = 20;}
								elseif($acc_hour == 17){$acc_hour = 21;}
								elseif($acc_hour == 18){$acc_hour = 22;}
								elseif($acc_hour == 19){$acc_hour = 23;}
								elseif($acc_hour == 20){$acc_hour = 24;}

								if($acc_min == 1){$acc_min = 00;}
								elseif($acc_min == 2){$acc_min = 05;}
								elseif($acc_min == 3){$acc_min = 10;}
								elseif($acc_min == 4){$acc_min = 15;}
								elseif($acc_min == 5){$acc_min = 20;}
								elseif($acc_min == 6){$acc_min = 25;}
								elseif($acc_min == 7){$acc_min = 30;}
								elseif($acc_min == 8){$acc_min = 35;}
								elseif($acc_min == 9){$acc_min = 40;}
								elseif($acc_min == 10){$acc_min = 45;}
								elseif($acc_min == 11){$acc_min = 50;}
								elseif($acc_min == 12){$acc_min = 55;}

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
							<span><?php print number_format($collection->getByKey($collection->getKeyValue(), "calender_mon"))?></span>円～
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
							<?php print $acc_day?>日前の<?php print date("h",$acc_hour)?>時<?php print date("i",$acc_min)?>分まで
						</td>
					</tr>
					<tr>
						<th>
							集合場所
						</th>
					</tr>
					<tr>
						<td>
							沖縄県那覇市久米
						</td>
					</tr>
					<tr>
						<th>
							体験場所
						</th>
					</tr>
					<tr>
						<td>
							沖縄県那覇市波の上
						</td>
					</tr>

				</table>

				<div class="btn_cal"><a href="#calender"></a></div>

			</section>

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
							沖縄県那覇市波の上
						</td>
					</tr>

					<tr>
						<th>
							開催期間
						</th>
						<td>
							1時間半～
						</td>
					</tr>				
					<tr>
						<th>
							所要時間
						</th>
						<td>
							1時間半～
						</td>
					</tr>
					<tr>
						<th>
							最少催行人数
						</th>
						<td>
							申し込み可能人数
						</td>
					</tr>
					<tr>
						<th>
							予約締切
						</th>
						<td>
							沖縄県那覇市波の上
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
							内容
						</td>
					</tr>
					<tr>
						<th>
							お支払方法について
						</th>
						<td>
							内容
						</td>
					</tr>
					<tr>
						<th>
							キャンセル・変更について
						</th>
						<td>
							内容
						</td>
					</tr>
					<tr>
						<th>
							開催条件・天候不良による中止について
						</th>
						<td>
							内容
						</td>
					</tr>
					<tr>
						<th>
							お客様にご用意いただくもの（服装・持ち物など）
						</th>
						<td>
							内容
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
							沖縄県那覇市久米
						</td>
					</tr>
					<tr>
						<th>
							集合場所
						</th>
						<td>
							<ul>
								<li class="address">
									〒住所
								</li>
								<li class="address_map">
									〒住所
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th>
							アクセス
						</th>
						<td>
							沖縄県那覇市波の上
						</td>
					</tr>
					<tr>
						<th>
							駐車場について
						</th>
						<td>
							沖縄県那覇市波の上
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
							5歳以上～
						</td>
					</tr>
					<tr>
						<th>
							参加資格
						</th>
						<td>
							2016年11月1日～2017年3月31日
						</td>
					</tr>
					<tr>
						<th>
							その他備考
						</th>
						<td>
							内容
						</td>
					</tr>
				</table>
			</section>

		</section>
	</article>
	<!-- /プラン詳細 -->
       
<?php
//掲載期間が切れていたら警告文表示
if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") < date("Y-m-d") && ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") != NULL)){?>
        <article class="mainbox" id="ag">
			<div class="inner">
			<center><B><font color="red">＞＞　ご指定のプランは販売期間が過ぎました。　＜＜</font></B></center>
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
								if($acc_hour == 1){$acc_hour = 5;}
								elseif($acc_hour == 2){$acc_hour = 6;}
								elseif($acc_hour == 3){$acc_hour = 7;}
								elseif($acc_hour == 4){$acc_hour = 8;}
								elseif($acc_hour == 5){$acc_hour = 9;}
								elseif($acc_hour == 6){$acc_hour = 10;}
								elseif($acc_hour == 7){$acc_hour = 11;}
								elseif($acc_hour == 8){$acc_hour = 12;}
								elseif($acc_hour == 9){$acc_hour = 13;}
								elseif($acc_hour == 10){$acc_hour = 14;}
								elseif($acc_hour == 11){$acc_hour = 15;}
								elseif($acc_hour == 12){$acc_hour = 16;}
								elseif($acc_hour == 13){$acc_hour = 17;}
								elseif($acc_hour == 14){$acc_hour = 18;}
								elseif($acc_hour == 15){$acc_hour = 19;}
								elseif($acc_hour == 16){$acc_hour = 20;}
								elseif($acc_hour == 17){$acc_hour = 21;}
								elseif($acc_hour == 18){$acc_hour = 22;}
								elseif($acc_hour == 19){$acc_hour = 23;}
								elseif($acc_hour == 20){$acc_hour = 24;}

								if($acc_min == 1){$acc_min = 00;}
								elseif($acc_min == 2){$acc_min = 05;}
								elseif($acc_min == 3){$acc_min = 10;}
								elseif($acc_min == 4){$acc_min = 15;}
								elseif($acc_min == 5){$acc_min = 20;}
								elseif($acc_min == 6){$acc_min = 25;}
								elseif($acc_min == 7){$acc_min = 30;}
								elseif($acc_min == 8){$acc_min = 35;}
								elseif($acc_min == 9){$acc_min = 40;}
								elseif($acc_min == 10){$acc_min = 45;}
								elseif($acc_min == 11){$acc_min = 50;}
								elseif($acc_min == 12){$acc_min = 55;}

							//$acc_datetime = $acc_day." ".$acc_hour.":".$acc_min;
						?>



                    	<div class="howto">
                    		<ul>
                    			<li>体験ご希望の日程を選んでカレンダーをクリックして下さい。予約可能なコースの選択へ進みます。</li>
                    			<li class="view"><p>
                    				
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

				
//							print_r($arPayList);
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
	                				<p><?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_REMARKS") != "") {?>
	                				<?php redirectForReturn($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_REMARKS"))?>
	                				<?php }?></p>
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
