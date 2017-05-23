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
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="content" class="searchdetail">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">検索結果</a></li>
            <li><span>地図・アクセス</span></li>
        </ul>

	<!-- プラン詳細 -->
	<article id="detail_plan">

		<!-- ショップメニュー -->
		<?php $company_id = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"); ?>
		<section id="detail_menu">
			<ul>
				<li>
					<a href="/shop-detail.html?cid=<?php echo $company_id; ?>">ショップ情報</a>
				</li>
				<li>
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
				<li class="current">
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

		<!-- 
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
				<a href="/shop-report.html?cid=<?php print $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");?>"><?php print count($reportTarget);?> 件</a>
			</div>
		</section>
		 -->
			
		<setcion id="detail_box">
			<section id="info_access" class="shop">
				<h3 class="info_label">地図・アクセス情報</h3>
				<table>
					<tr>
						<th>
							所在地
						</th>
						<td>
							<p class="add_info"><?php echo nl2br($shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_ADDRESS")); ?></p>
							<?php //TODO 公開時APIキーを取得して設定 ?>
							<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARHX6DkSJkgcGW2ZtJiQquQnbqnskxoNI" type="text/javascript"></script>
							<script type="text/javascript">
								$(function() {
									var query = '<?php echo $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_ADDRESS"); ?>';
									var lon = '';
									var lat = '';
									var geocoder;
									var map;
									function initialize() {
										geocoder = new google.maps.Geocoder();
										var myOptions = {
											center: new google.maps.LatLng(lon, lat),
											zoom: 18,
											mapTypeId: google.maps.MapTypeId.ROADMAP  
										}
										map = new google.maps.Map(document.getElementById("shop_map"),myOptions);
										codeAddress();
										google.maps.event.trigger(map, 'resize');
										
									}
									function codeAddress() {
										var address = query;
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
									}
									google.maps.event.addDomListener(window, 'load', initialize);
								});
							</script>
							<div class="map" id='shop_map' style='width: 764px; height: 450px;'>
								<!-- <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="http://maps.google.co.jp/maps?q=沖縄県那覇市久米1-1-13&iwloc=J&output=embed"></iframe> -->
							</div>
						</td>
					</tr>
					<tr>
						<th>
							交通アクセス
						</th>
						<td>
							<?php echo nl2br($shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_TEXT")); ?>
						</td>
					</tr>
					<tr>
						<th>
							駐車場について
						</th>
						<td>
							<?php
								$parking_flg = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_PARKINGFLG");
								if($parking_flg == 1){
									echo "あり";
									
									echo "<br>";
									
// 									echo "<br>【駐車場料金】<br>";
									$parking_money_flg = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_PARKINGMONEYFLG");
									if($parking_money_flg == 1){
										echo "無料";
									}elseif($parking_money_flg == 2){
										echo "有料";
										$parking_money = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_PARKINGMONEY");
										if(!empty($parking_money)){
											echo "(".$parking_money.")";
										}
									}
									echo "<br>";
									
// 									echo "<br>【駐車場事前予約】<br>";
									$parking_book_flg = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_PARKINGBOOKFLG");
									if($parking_book_flg == 1){
										echo "事前予約不要";
									}elseif($parking_flg == 2){
										echo "事前予約必要";
									}
									echo "<br>";
									
// 									echo "<br>【駐車台数】<br>";
									$parking_cap = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_PARKINGCAP");
									echo $parking_cap;
									
								}elseif($parking_flg == 2){
									echo "なし";
								}
								
							?>
							<?php print $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_PARKING")?>
					</td>
					</tr>
				</table>
			</section>
			
		</setcion>
		
	</article><!-- /#detail_plan -->
				
	
	<!-- /プラン詳細 -->
       


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
