<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/mArea.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategory.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategoryDetail.php');


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);
//print_r($collection);

$collection->setByKey($collection->getKeyValue(), "limitptn", "top");

$kuchikomi = new kuchikomi($dbMaster);
$kuchikomi->selectSide($collection);
$dspKArray = array();
if ($kuchikomi->getCount() > 0) {
	foreach ($kuchikomi->getCollection() as $kuchidata) {
	//	print_r($kuchidata);
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_ID"] = $kuchidata["KUCHIKOMI_ID"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_FACILITY_NAME"] = $kuchidata["KUCHIKOMI_FACILITY_NAME"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_TITLE"] = $kuchidata["KUCHIKOMI_TITLE"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_DETAIL"] = $kuchidata["KUCHIKOMI_DETAIL"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_PIC1"] = $kuchidata["KUCHIKOMI_PIC1"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_AREA"] = $kuchidata["KUCHIKOMI_AREA"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_CATEGORY"] = $kuchidata["KUCHIKOMI_CATEGORY"];
	}
}

$inputs = new inputs();

// プラン取得(今日を含む後３日分)
$shop       = new shop($dbMaster);
$collection = new collection($db);
$arrPlan = array();
$after_days = 2;
for($i = 0; $i <= $after_days; $i++){
	$search_date = ($i==0)?date('Y-m-d'):date('Y-m-d', strtotime('+' .$i. ' day'));
	
	// 日付と人数をセット
	$collection->setByKey($collection->getKeyValue(), "area", '');
	$collection->setByKey($collection->getKeyValue(), "category", '');
	$collection->setByKey($collection->getKeyValue(), "limit", 5);
	$collection->setByKey($collection->getKeyValue(), "limitptn", "plan");
	$collection->setByKey($collection->getKeyValue(), "search_date", $search_date);
// 	$collection->setByKey($collection->getKeyValue(), "priceper_num", 1);	// 人数指定なし
	cmSetHotelSearchDef($collection);
	
	$shop->selectListPublicPlan($collection);
	$arrPlanData = $shop->getCollection();
	
	foreach($arrPlanData as $key => $data) {
		$count_spi = "";
		for ($j=1; $j<=12; $j++){
			if($data["SHOPPLAN_MEET_TIMEHOUR".$j] > "0"){
				$count_spi = $j;
			}
		}
		
		// 各プランの料金書き出す
		for ($j=1; $j<=$count_spi; $j++){
			$search_collection = new collection($db);
			$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $data["SHOPPLAN_ID"]);
			$search_collection->setByKey($search_collection->getKeyValue(), "SHOP_PRICETYPE_ID", $data["SHOP_PRICETYPE_ID".$j]);
			$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
			//日付指定なし
// 			$search_collection->setByKey($search_collection->getKeyValue(), "undecide_sch", 1);
// 			$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));
		
			if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
				//	指定なし
		
				//ルーム毎の大人人数計算
				$room_sch = $shop->selectMoneyEveryRoomUndecideSch($search_collection);
		
				// 設定されている料金帯の数をカウント
				if($room_sch != ""){
					$room[$j] = $room_sch;
				}
			}
			else {
				//ルーム毎の大人人数計算
				$room_sch = $shop->selectMoneyEveryRoom($search_collection);
				if($room_sch != ""){
					$room[$j] = $room_sch;
				}
			}
		}
		
		$money_total = "";
		$money_total_perroom = 0;
		for ($j=1; $j<=12; $j++){
			if($room[$j]["money_ALL"] !=""){
				$money_total[$j] = $room[$j]["money_ALL"];
			}
		}
		
		asort($money_total);
		
		$keys = array_keys($money_total);
		$money_total_cid = $keys[0];
		
		// 最安料金をセット
		if ($arrPlanData[$key]["money_all"] == "" || $arrPlanData[$key]["money_all"] > $data["money_all"]) {
			$arrPlanData[$key]["money_all"] = $money_total[$money_total_cid];
		}
	}
	$arrPlan[] = $arrPlanData;
}

//エリア指定
$mAreaTop = new mArea($dbMaster);
$mAreaTop->selectTop();
$mAreaTop->setPost();

$mAreaParent = new mArea($dbMaster);
$mAreaParent->selectParent();
$mAreaParent->setPost();

$mAreaChild = new mArea($dbMaster);
$mAreaChild->selectChild();
$mAreaChild->setPost();

//カテゴリ指定
$mActivityCategoryParent = new mActivityCategory($dbMaster);
$mActivityCategoryParent->selectParent();
$mActivityCategoryParent->setPost();

// エリア配列の作成
// トップ
$arrAreaTopData = $mAreaTop->getCollection();
$arrAreaTop = array();
foreach($arrAreaTopData as $top_data){
	$arrAreaTop[$top_data['M_AREA_ID']] = $top_data['M_AREA_NAME'];
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
// 沖縄限定子エリアの作成
$arrPullAreaChild = array();
foreach($arrAreaChildData as $area_child){
	if($area_child['M_AREA_PARENT'] == 14){
		$arrPullAreaChild[] = $area_child;
	}
}

// カテゴリの作成
$arrCategoryParentData = $mActivityCategoryParent->getCollection();
$arrPullCategoryParent = array();
foreach($arrCategoryParentData as $categ_parent){
	// フライボートに限定
	if($categ_parent['M_ACT_CATEGORY_ID'] == 3){
		$arrPullCategoryParent[] = $categ_parent;
	}
}

// inputクラス生成
$inputs = new inputs();

?>


<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta_detail.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title><?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="//playbooking.jp/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//playbooking.jp/js/jquery-ui-1.10.3.custom.min.js"></script>

<link rel="stylesheet" href="//playbooking.jp/common/css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="//playbooking.jp/common/js/popupwindow-1.6.js"></script>
<style>
.dspNon {
	display: none;
}
</style>
<script type="text/javascript">
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
	$("#ori_adult").css("display","none");
}
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide1').bxSlider({
	auto: true,
	autoHover: false,
	pause:	5000,
	speed: 1000,
	pager: false,
	touchEnabled: true,
	swipeThreshold: 50,
	oneToOneTouch: true,
	slideWidth: 1600,
	minSlides: 1,
	maxSlides: 1,
	moveSlides: 1,
	slideMargin: 0,
	infiniteLoop: true,
        prevText: '<',
        nextText: '>'
        });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide2').bxSlider({
	auto: true,
	autoHover: false,
	pause:	5000,
	speed: 1000,
	pager: false,
	slideWidth: 300,
	minSlides: 3,
	maxSlides: 3,
	moveSlides: 1,
	slideMargin: 5,
	infiniteLoop: true,
        prevText: '<',
        nextText: '>'
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

<body id="top" style="background:none;">

<?php print_r($ua_flg."★"); ?>

<!--header-->

<?php require("includes/box/common/header_common.php");?>

<!--/header-->

<!--pickup-->
<div id="pickup">

		<div class="clearfix">

		<ul class="slide1">
			<li class="ti"><span>「PlayBookingで見つけよう」</span><img src="images/common/image_top2.png"></li>
			<li class="ti"><span>「PlayBookingで楽しもう」</span><img src="images/common/image_top2.png"></li>
			<li class="ti"><span>「PlayBookingで出かけよう」</span><img src="images/common/image_top2.png"></li>
		</ul>

		</div>
</div>
<!--/pickup-->

<!--Content-->
<div id="content" class="clearfix">
	<!--main-->
	<main>
		<article>

		<ul class="top_banner">
			<li><a href=""><img src="images/common/bnr_01.png"></a></li>
			<li><a href=""><img src="images/common/bnr_02.png"></a></li>
			<li><a href=""><img src="images/common/bnr_03.png"></a></li>
		</ul>
		
		<!--検索-->
		<section>
			<section id="result_box">
				<form method="post" action="plan-search.html" name="search_form" id="search_form">
					<!-- <input type="hidden" name="priceper_num" id="priceper_num" value="1"> --><?php // del settenLab 人数指定は必要ないためコメントアウト ?>
					<ul class="search_selecter">
						<li class="search_icon"> </li>
						<li class="search_area">
							<select name="child_area_id" id="child_area_id">
								<option value="" selected="selected">エリアを選択</option>
								<?php if (count($arrPullAreaChild) > 0) {?>
									<?php
									foreach ($arrPullAreaChild as $data) {
									?>
									<option value="<?php print $data["M_AREA_ID"]?>"><?php print $data["M_AREA_NAME"]?></option>
									<?php }?>
								<?php }?>
							</select>
							<span>×</span>
						</li>
						<li class="search_category">
							<select name="parent_category_id" id="parent_category_id">
								<option value="" selected="selected">カテゴリを選択</option>
								<?php if (count($arrPullCategoryParent) > 0) {?>
								<?php
								foreach ($arrPullCategoryParent as $data) {
								?>
								<option value="<?php print $data["M_ACT_CATEGORY_ID"]?>"><?php print $data["M_ACT_CATEGORY_NAME"]?></option>
								<?php }?>
							<?php }?>
							</select>
							<span>×</span>
						</li>
						<li class="search_date">
							<input type="text" id="search_date" name="search_date" value="<?php print date("Y年m月d日") ?>" class="imeDisabled wDateJp" readonly='readonly' />
							<script type="text/javascript">
								$.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
								$("#search_date").datepicker({
									showOn: 'button',
									buttonImage: 'images/index2016/index-search-icon.png',
									buttonImageOnly: true,
									dateFormat: 'yy年mm月dd日',
									changeMonth: true,
									changeYear: true,
									yearRange: '2016:2017',
									showMonthAfterYear: true,
									monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
									dayNamesMin: ['日','月','火','水','木','金','土']
								});
								$('#search_date').on('click',function(){$(this).datepicker('show');});
							</script>
						</li>
					</ul>
					<ul class="tabs" id="result_menu">
						<li class="active"><a href="#tab1">今日(<?php echo date('n/j'); ?>)</a></li>
						<li class=""><a href="#tab2">明日(<?php echo date('n/j', strtotime('+1 day')); ?>)</a></li>
						<li class=""><a href="#tab3">明後日(<?php echo date('n/j', strtotime('+2 day')); ?>)</a></li>
					</ul>
				</form>

				<!-- プラン一覧 -->
				<?php if(count($arrPlan) > 0):?>
					<?php foreach($arrPlan as $key => $plans):?>
						<div id="tab<?php echo $key + 1;?>" class="content outer">
							<?php foreach($plans as $plandata):?>
								<ul class="plan_box">
									<li class="inner">
										<?php $formplan = "frm_".$key."_".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
										<form action="plan-detail.html?cid=<?php echo $plandata["COMPANY_ID"];?>&pid=<?php echo $plandata["SHOPPLAN_ID"];?>&num=<?php echo $collection->getByKey($collection->getKeyValue(), "priceper_num");?>" method="post" id="<?php echo $formplan; ?>" name="<?php echo $formplan; ?>">
											<?php echo $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
											<?php echo $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
											<?php echo $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
											<?php echo $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
											<?php echo $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
											<?php echo $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
											<?php echo $inputs->hidden("calender_mon", $plandata["money_all"])?>
										</form>
										<a href="javascript:void(0);" onclick='document.<?php echo $formplan; ?>.submit();'>
											<?php if ($plandata["SHOPPLAN_PIC1"] != "" || $plandata["SHOPPLAN_PIC1"] != "") {?>
												<img src="<?php echo URL_SLAKER_COMMON."/images/".$plandata["SHOPPLAN_PIC1"]?>" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>" style='width: 170px;'>
											<?php }else{?>
												<img src="<?php echo URL_SLAKER_COMMON?>assets/noImage.jpg" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>">
											<?php }?>
											
											<p class="title">
												<?php 
													echo mb_substr(redirectForReturn($plandata['SHOPPLAN_CATCH']), 0, 40, 'UTF-8');
												
													if(mb_strlen( $plandata['SHOPPLAN_CATCH']) > 40){
														echo "…";
													}
												?>
											</p>
												<ul class="area">
													<li><img src="images/common/icon_map.png"></li>
													<li><?php echo $arrAreaParent[$plandata['SHOPPLAN_AREA_LIST2']]; ?> ＞ </li>
													<li><?php echo $arrAreaChild[$plandata['SHOPPLAN_AREA_LIST3']]; ?></li>
												</ul>
											<p class="price"><?php echo number_format($plandata['money_all']); ?>円～</p>
										</a>
									</li>
								</ul>
							<?php endforeach;?>
						</div>
					<?php endforeach;?>
				<?php endif;?>
				<!-- // プラン一覧 -->
				<a href="javascript:;" onclick="document.search_form.submit();" style=""><div class="search_form">プラン一覧を表示</div></a>
			</section>
		</section>



			<section style="clear: both;margin-top: 100px;">
		        <!-- ピックアップ -->
	        	<section id="pick_up">	        		
		        	<h2>ピックアップ！</h2>
					<div class="outer">
						<ul class="pick_up">
							<li class="inner"><a href="">
							<img src="images/common/bnr_pick1.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/bnr_pick2.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/bnr_pick3.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/bnr_pick4.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/bnr_pick5.png">
							</a></li>
						</ul>
					</div>
		        </section>
		        <!--/ピックアップ-->



			<section style="clear: both;margin-top: 50px;">
		        <!-- エリアTOP -->
	        	<section id="area_top">	        		
		        	<h2>エリアTOPページへ</h2>
					<div class="outer">
						<ul class="area_top">
							<li class="inner"><a href="">
							<img src="images/common/area_01.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_02.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_03.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_04.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_05.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_06.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_07.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_08.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_09.png">
							</a></li>
							<li class="inner"><a href="">
							<img src="images/common/area_10.png">
							</a></li>
							<li class="inner" style="clear:both;"><a href="">
							<img src="images/common/area_11.png">
							</a></li>
						</ul>
					</div>
		        </section>
		        <!-- /エリアTOP -->


<!-- 
			<section style="clear: both;margin-top: 100px;">
 -->
		        <!--口コミ-->
<!--  
	        	<section id="report_list">	        		
		        	<h2>みんなの体験レポート</h2>
		        	<a href="/kuchikomi-search.html"><div class="search_report">体験レポートをもっと見る</div></a>
-->
        <?php if (count($dspKArray) > 0) {
			foreach ($dspKArray as $kk) {
			//print_r($kk);
	?>
<!-- 
					<div class="outer">
						<ul class="plan_box">
							<li class="inner"><a href="">
							<img src="images/common/img_demo2.png">
							<p class="title">マングローブカヤック初挑戦！</p>
							<p class="text">今回は会社初めての社員旅行ということで、みんなで楽しめるレジャーを探していまし…</p>
							</a></li>
						</ul>
						<ul class="plan_box">
							<li class="inner"><a href="">
							<img src="images/common/img_demo2.png">
							<p class="title">マングローブカヤック初挑戦！</p>
							<p class="text">今回は会社初めての社員旅行ということで、みんなで楽しめるレジャーを探していまし…</p>
							</a></li>
						</ul>
						<ul class="plan_box">
							<li class="inner"><a href="">
							<img src="images/common/img_demo2.png">
							<p class="title">マングローブカヤック初挑戦！</p>
							<p class="text">今回は会社初めての社員旅行ということで、みんなで楽しめるレジャーを探していまし…</p>
							</a></li>
						</ul>
						<ul class="plan_box">
							<li class="inner"><a href="">
							<img src="images/common/img_demo2.png">
							<p class="title">マングローブカヤック初挑戦！</p>
							<p class="text">今回は会社初めての社員旅行ということで、みんなで楽しめるレジャーを探していまし…</p>
							</a></li>
						</ul>
						<ul class="plan_box">
							<li class="inner"><a href="">
							<img src="images/common/img_demo2.png">
							<p class="title">マングローブカヤック初挑戦！</p>
							<p class="text">今回は会社初めての社員旅行ということで、みんなで楽しめるレジャーを探していまし…</p>
							</a></li>
						</ul>
					</div>
 -->
<!--
			        	<a href="/kuchikomi-detail.html?k_id=<?php print $kk["KUCHIKOMI_ID"]?>">
			        		<ul>
			        			<li>
			        				<p>
									<?php if ($kk["KUCHIKOMI_PIC1"] != "") {?>
										<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kk["KUCHIKOMI_PIC1"]?>" width="80" height="70" class="fl-l"  alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
									<?php }else{?>
										<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="80" height="70" class="fl-l" alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
									<?php }?>
								</p>
			        				<dl>
			        					<dt><?php print cmStrimWidth($kk["KUCHIKOMI_FACILITY_NAME"], 0, 20, '…')?></dt>
			        					<dd><?php print cmStrimWidth($kk["KUCHIKOMI_TITLE"], 0, 100, '…')?></dd>
			        					<dd class="link"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 続きを読む</dd>
			        				</dl>
			        			</li>
			        		</ul>
			        	</a>
-->

        <?php
			}
	}
	?>
<!-- 
		        </section>
 -->
		        <!--/口コミ-->

		
		</article>
	</main>
	<!-- /main-->
</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>

<!--analitics-->
<!-- タグ取得後挿入 -->

<!--/analitics-->

<!--/footer-->
</body>
<!-- InstanceEnd --></html>
