<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponShop.php');

$dbMaster = new dbMaster();

// print_r($_POST);exit;
$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
//会員しか見えない
if (!$sess->sessionCheck()) {
	$_SESSION['ref_url']='n_coupon.html';
	cmLocationChange("login.html");
}

$collection = new collection($db);


if($_POST){
	$collection->setPost();
//	cmSetHotelSearchDef($collection);
}
else {
	$collection->setByKey($collection->getKeyValue(), "COUPONSHOP_ID", $_GET["shop_id"]);
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["company_id"]);
	$collection->setByKey($collection->getKeyValue(), "COUPONPLAN_ID", $_GET["cplan_id"]);
//	$collection->setByKey($collection->getKeyValue(), "night_number", $_GET["night_number"]);
//	$collection->setByKey($collection->getKeyValue(), "room_number", $_GET["room_number"]);
//	$collection->setByKey($collection->getKeyValue(), "adult_number1", $_GET["adult_number1"]);
	
/*	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "2");
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y年m月d日'));
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
	cmSetHotelSearchDef($collection);
*/
}

// decode the url

function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}

function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

$key = $_GET["cid"].$_GET["cpid"].$_GET["sid"];
if( $key != passport_decrypt($_GET["key"], $key) ){
	echo "<head><meta charset='utf-8'></head><body>無効リンクです。<br/>管理員と連絡して下さい。</body>";
	exit;
}

	//	ココモ
	$couponPlanTarget = new couponPlan($dbMaster);
		
	if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") == "") {
		if ($_GET['cpid']) {
			$collection->setByKey($collection->getKeyValue(), "COUPONPLAN_ID", $_GET['cpid']);;
		}
	}
	if ($collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID") == "") {
		if ($_GET['sid']) {
			$collection->setByKey($collection->getKeyValue(), "COUPONSHOP_ID", $_GET['sid']);;
		}
	}
	if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") == "") {
		if ($_GET['cid']) {
			$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET['cid']);;
		}
	}
	
	
	$couponPlanTarget->select($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	$HOTELPLAN_CHECKIN = $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MIN");
	$HOTELPLAN_CHECKIN_LAST = $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX");

	$couponShop = new couponShop($dbMaster);
	$couponShop->select($collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	$couponTarget = new coupon($dbMaster);
	$couponTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
//	$couponBookset = new couponBookset($dbMaster);
//	$couponBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	


$coupon = new coupon($dbMaster);

$couponBooking = new couponBooking($dbMaster);
// $collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", "");
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", "");
$coupon->selectListPublicCoupon($collection);

$planCnt = 0;
$dspArray = array();


if ($coupon->getCount() > 0) {
	foreach ($coupon->getCollection() as $data) {
		$dspArray[$data["COUPONSHOP_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_ID"] = $data["COUPONPLAN_ID"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPON_NAME"] = $data["COUPON_NAME"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_NAME"] = $data["COUPONPLAN_NAME"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_CATCH"] = $data["COUPONPLAN_CATCH"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONSHOP_ID"] = $data["COUPONSHOP_ID"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONSHOP_NAME"] = $data["COUPONSHOP_NAME"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_CATCH"] = $data["COUPONPLAN_CATCH"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DETAIL"] = $data["COUPONPLAN_DETAIL"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_RESERVE"] = $data["COUPONPLAN_RESERVE"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_USE"] = $data["COUPONPLAN_USE"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_USE_FROM"] = $data["COUPONPLAN_USE_FROM"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_USE_TO"] = $data["COUPONPLAN_USE_TO"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_SELL_PRICE"] = $data["COUPONPLAN_SELL_PRICE"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEAL_PRICE"] = $data["COUPONPLAN_DEAL_PRICE"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEAL_SP"] = $data["COUPONPLAN_DEAL_SP"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_PROVIDE_FLG"] = $data["COUPONPLAN_PROVIDE_FLG"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_PROVIDE_MAX"] = $data["COUPONPLAN_PROVIDE_MAX"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_PROVIDE_SELL"] = $data["COUPONPLAN_PROVIDE_SELL"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEALNUM_FLG"] = $data["COUPONPLAN_DEALNUM_FLG"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEALNUM_MAX"] = $data["COUPONPLAN_DEALNUM_MAX"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEALNUM_MIN"] = $data["COUPONPLAN_DEALNUM_MIN"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEALPER_FLG"] = $data["COUPONPLAN_DEALPER_FLG"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEALPER_MAX"] = $data["COUPONPLAN_DEALPER_MAX"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_DEALPER_MIN"] = $data["COUPONPLAN_DEALPER_MIN"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_SALE_FROM"] = $data["COUPONPLAN_SALE_FROM"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_SALE_TO"] = $data["COUPONPLAN_SALE_TO"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_AREA_LIST"] = $data["COUPONPLAN_AREA_LIST"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_CATEGORY_LIST"] = $data["COUPONPLAN_CATEGORY_LIST"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_PIC"] = $data["COUPONPLAN_PIC"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_PIC2"] = $data["COUPONPLAN_PIC2"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_PIC3"] = $data["COUPONPLAN_PIC3"];
		$dspArray[$data["COUPONSHOP_ID"]]["COUPONPLAN_PIC4"] = $data["COUPONPLAN_PIC4"];
	}
}
//print_r($data);
// print_r($collection);exit;

//各部屋の料金書き出す
/*
for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
	$search_collection = new collection($db);
	$search_collection->setByKey($search_collection->getKeyValue(), "HOTELPLAN_ID", $dspArray[$data["ROOM_ID"]]["HOTELPLAN_ID"]);
	$search_collection->setByKey($search_collection->getKeyValue(), "ROOM_ID", $dspArray[$data["ROOM_ID"]]["ROOM_ID"]);
	$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "search_date"));
	$search_collection->setByKey($search_collection->getKeyValue(), "adult_number", $collection->getByKey($collection->getKeyValue(), "adult_number".$i));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number1", $collection->getByKey($collection->getKeyValue(), "child_number".$i."1"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number2", $collection->getByKey($collection->getKeyValue(), "child_number".$i."2"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number3", $collection->getByKey($collection->getKeyValue(), "child_number".$i."3"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number4", $collection->getByKey($collection->getKeyValue(), "child_number".$i."4"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number5", $collection->getByKey($collection->getKeyValue(), "child_number".$i."5"));
	$search_collection->setByKey($search_collection->getKeyValue(), "child_number6", $collection->getByKey($collection->getKeyValue(), "child_number".$i."6"));
	$room[$i] = $coupon->selectMoneyEveryShop($search_collection);	
//	print_r($room[$i]);
}

// print_r($couponPlanTarget->getCollection());
// print_r($coupon->getCollection());
$money_all_all = 0;
for ($j=1; $j<=$collection->getByKey($collection->getKeyValue(), "night_number"); $j++){
	for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
		$money_all_all += $room[$i]["money_ALL"];
	}
}
*/

//print($collection);exit;

// print_r($arPayList);


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$couponTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<title>クーポン詳細 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="プラン,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="クーポンの詳細ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- 蠑ｹ窗 -->
<link rel="stylesheet" href="<?php print URL_SLAKER_COMMON?>css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/popupwindow-1.6.js"></script>
<style>
.dspNon {
	display: none;
}
</style>


<!--count-->
<script type="text/javascript" src="<?=URL_PUBLIC?>js/jquery-1.5.1.js"></script>
<script src="<?=URL_PUBLIC?>js/java.js"></script>
<!--/count-->

<script>
//蠑ｹ窗
var pop;
function openChildSet() {
	<?php for ($i=1; $i<=6; $i++) {?>
	var num<?php print $i?> = $("#child_number<?php print $i?>").val();
	<?php }?>
	var rheight = 110 + (170*parseInt($"#room_number").val()));
	if (rheight > 620) {
		rheight = 620;
	}
	pop= new $pop('popchildset.php?num1='+num1+'&num2='+num2+'&num3='+num3+'&num4='+num4+'&num5='+num5+'&num6='+num6, { type:'iframe', title:'人数設定',effect:'normal',width:650,height:rheight,windowmode:false,resize: false } );
}
function setData() {
	pop.close();
	$("#ori_adult").css("display","none");
}


$('a[href=#top]').click(function() {
    ('a:not(.calendarLink[href*=#]')
   var speed = 500;
   var href= $(this).attr("href");
   var target = $(href == "#" || href == "" ? 'html' : href);
   var position = target.offset().top;
   $('body,html').animate({scrollTop:position}, 500, 'swing');
   return false;
});
</script>
</head>

<body id="top">

<!--count-->
<input type="hidden" id="TimerStart" value="<?php echo date('Y/m/d H:i:s');?>" >
<!--/count-->

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->

    <main id="detail_n">


<?php
//掲載期間が切れていたら警告文表示
if($data["COUPONPLAN_SALE_TO"] < date("Y-m-d") || $data["COUPONPLAN_SALE_FROM"] > date("Y-m-d")){?>
        <article class="mainbox" id="ag">
			<div class="inner" style="margin:200px;">
			<center><B><font color="red">＞＞　ご指定のクーポンは現在受付しておりません　＜＜</font></B></center>
	</article>
<?php } else {?>


		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="coupon_top.html">クーポン一覧</a></li>
            <li><span>クーポン詳細</span></li>
        </ul>
        
        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>

        <article class="cd_title">
       		<div class="c_icon">
		       	<p1></p1><p2><?php 
						$arArea = "";
						$arTemp = explode(":", $plandata["COUPONPLAN_AREA_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arArea[$data] = $data;
							
        							}
        						}
		        			}
						$dataArea = cmJobArea();
						if (count($dataArea) > 0) {
							foreach ($dataArea as $k=>$v) {
								if ($arArea[$k] != "") {
									echo "$v";
								}
							}
						}
					?>
	        		</p2>
				<p3><?php 
						$arCategory = "";
						$arTemp = explode(":", $plandata["COUPONPLAN_CATEGORY_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arCategory[$data] = $data;
        							}
        						}
		        			}
						$dataCategory = cmCouponCategory();
						if (count($dataCategory) > 0) {
							foreach ($dataCategory as $k=>$v) {
								if ($arCategory[$k] != "") {
									echo "$v";
								}
							}
						}
					?></p3>
			<p4><?php print $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_NAME")?></p4>
		</div></br></br>

	<p><?php print $plandata["COUPONPLAN_CATCH"]?></p>
       	</article>

        <article class="cd_main">
			<div class="cd_price">
				<div class="cd_value"><?php print $plandata["COUPONPLAN_SELL_PRICE"]?>円<span>（税込）</span></div>
					<div class="cd_value2">
								<?php if ($plandata["COUPONPLAN_DEAL_SP"] == 1){?>
									<span>特別価格</span>
								<?php }elseif ($plandata["COUPONPLAN_DEAL_SP"] == 2){?>
									通常価格：<S><?php print $plandata["COUPONPLAN_DEAL_PRICE"]?>円</S>　≫　
									<span><?php print floor(100-(($plandata["COUPONPLAN_SELL_PRICE"]/$plandata["COUPONPLAN_DEAL_PRICE"])*100))?>％OFF！！</span>
								<?php }else{}?>


						<table><tr><td><div class="cd_point">ポイント1％</div></td><td><B><?php print floor($plandata["COUPONPLAN_SELL_PRICE"]*0.92/100)?>ポイント</B>貯まる♪</td></tr></table>
					</div>
<!--枚数変更-->
                    <section>
                    	
                    	<?php if (($collection->getByKey($collection->getKeyValue(), "undecide_sch") != 1) || ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1)) {?>
                    	
<section>
		<div class="cd_box">
            <table class="cd">
            <tbody>
                <tr>
                    <td colspan="2">
                        <!--<?=$inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>-->
			<!--<?=$inputs->hidden("night_number","night_number",1,$collection->getByKey($collection->getKeyValue(), "night_number"),"", "")?>-->
			<!--<?=$inputs->hidden("room_number","room_number",1,$collection->getByKey($collection->getKeyValue(), "room_number"),"", "")?>-->
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table id="datainput1" class="inner datainputset" style="font-size: 15px;">
                        <tbody>
                            <tr class="first2">
                                <td colspan="2">
                                <h3>購入する枚数を選択してください。</h3></td>
				</td><td></td></tr>
				<tr>
				<td>
                                <div class="cd_selectbox">
                                <?php $selected='';?>
                                	<!--<div class="select-inner"><span></span></div>-->
                    				<?php $formname = "frmNext"?>
		                        	<form action="https://cocotomo.net/reservation-coupon.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">

	                                <select id="COUPONBOOK_NUM" name="COUPONBOOK_NUM" class="select-inner adultset">
							<?php if ($plandata["COUPONPLAN_DEALNUM_FLG"] == 1){
								$couponPlanTarget->setByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX",10);
								$couponPlanTarget->setByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MIN",1);
								}?>									

										<?php
										for ($i=$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MIN"); $i<=$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX"); $i++) {
											if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_DEALNUM") == $i) {
												$selected = 'selected="selected"';
											}
										}
										if ($selected == 'selected="selected"') {
											for ($i=$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MIN"); $i<=$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX"); $i++) {
												$selected = '';
												if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
													$selected = 'selected="selected"';
												}
												?>
												<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX"))?'':''?></option>
												<?php }
												}else{
										for ($i=$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MIN"); $i<=$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX"); $i++) {
											$selected = '';
											if (2 == $i) {
												$selected = 'selected="selected"';
												}
											
										?>
										<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==$couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX"))?'':''?></option>
										<?php }
										}
										?>
									</select>

								</div>枚　
                                </td>
				<!--<td><input type="submit" name="research" value=" " class="change_btn"></input></td>-->
                           </tr>
                       </tbody>
                       </table>
                    </td>
                </tr>
            </tbody>
            </table>

                <?php print $inputs->hidden("orderdata", $collection->getByKey($collection->getKeyValue(), "orderdata"))?>

    </section>
						<?php }?>
						

<!--/枚数変更-->
<!--購入-->

				<?php if ((($plandata["COUPONPLAN_PROVIDE_MAX"] > $plandata["COUPONPLAN_PROVIDE_SELL"]) || ($plandata["COUPONPLAN_PROVIDE_FLG"] == 1) ) && ($plandata["COUPONPLAN_SALE_TO"] > date("Y-m-d"))){?>
                    			<div class="cd_btn">
			                        	<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();" name="confirm_x" ><img src="./images/coupon/submit_btn.png" width="262" height="68" alt="購入手続きへ進む" /></a>
			                        	<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
			                        	<?php print $inputs->hidden("COUPONPLAN_ID", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"))?>
			                        	<?php print $inputs->hidden("COUPONSHOP_ID", $collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"))?>
			                        	<?php print $inputs->hidden("COUPONPLAN_SELL_PRICE", $plandata["COUPONPLAN_SELL_PRICE"])?>
		                        	</form>
                    			</div>
				<?php }?>
<!--/購入-->

					<div class="c_count"><img src="./images/coupon/time.png" width="21" height="28" alt="販売時間" />販売時間：<span class="TimeView"><?php print $plandata["COUPONPLAN_SALE_TO"]?>まで</span>
						<input type="hidden" class="TimerEnd" value="<?php print $plandata["COUPONPLAN_SALE_TO"]?> 00:00:00" >
						<input type="hidden" class="TimerEndText" value="販売期間が終了しました" ></br>
					<?php $date = date("Y-m-d")?>
				<!--
					<?php if ($plandata["COUPONPLAN_PROVIDE_MAX"] > $plandata["COUPONPLAN_PROVIDE_SELL"]){?>
					<?php print $plandata["COUPONPLAN_PROVIDE_MAX"]?>枚限定｜<span><?php print $plandata["COUPONPLAN_PROVIDE_SELL"]?>枚</span>販売済み｜残り<?php print ($plandata["COUPONPLAN_PROVIDE_MAX"]-$plandata["COUPONPLAN_PROVIDE_SELL"])?>枚
					<?php }elseif ($plandata["COUPONPLAN_PROVIDE_FLG"] == 1){ ?>
						<?php if ($plandata["COUPONPLAN_PROVIDE_SELL"] > 0){ ?>
					<span><?php print $plandata["COUPONPLAN_PROVIDE_SELL"]?>枚</span>販売済み
						<?php }?>
					<?php }else{ ?>
					<span>完売しました!!</span>
					<?php }?>
				-->
					</div>
					</div>
				<div class="cd_img cf">
				    <div id="mainimage">
				    	 <?php if ($couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_PIC") != "") {?>
				    		<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_PIC")?>" width="600" height="365" alt="<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_NAME")?>" name="mainimage">
				    	<?php }else{?>
				    		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="600" height="365" alt="<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_NAME")?>" name="mainimage">
				    	<?php }?>
					</ul>
				    </div>
				    <ul id="subimage">
				    	<?php for ($i=""; $i<=4; $i++) {?>
				    	 <?php if ($couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_PIC".$i) != "") {?>
				    		<li><a href="javascript:document.mainimage.src ='<?php print URL_SLAKER_COMMON?>images/<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_PIC".$i)?>';void(0);"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_PIC".$i)?>" width="144" height="105" alt="<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_NAME")?>"></a>
				    	<?php }else{?>
				    	<?php }?>
				    	<?php }?>
				    </ul>
				</div>

				  <h3 style="float:left; margin-right:10px;"><img src="./images/coupon/use_title.png" width="340" height="25" alt="利用条件" /></h3>
				<h3 style="float:left;"><img src="./images/coupon/shousai_title.png" width="600" height="25" alt="プラン内容" /></h3>
				<section class="cd_section2 cf">
				    <p><B>【1度に購入可能な枚数】：<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MIN")?>～<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALNUM_MAX")?>枚</B><br/>※分割しての利用はできません。一度に利用する枚数分ご購入ください</p>

				<?php if ($plandata["COUPONPLAN_DEALPER_FLG"] == 2){?>
				    <p><B>【お一人様あたりの購入回数限度】：<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DEALPER_MAX")?>回</B></p>
				<?php }?>
				    <p><B>【有効期限】：<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_USE_FROM")?>～<?php print $couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_USE_TO")?>迄</B>
				</br><?php print redirectForReturn($couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_USE_MEMO"))?></p>
				<p><B>【ご利用上の注意】＞＞＞</B></br><?php print redirectForReturn($couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_USE"))?></p>
				<p><B>【ご予約方法】＞＞＞</B></br><?php print redirectForReturn($couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_RESERVE"))?></p>
				</section>

				<section class="cd_section1 cf">

				    <p><?php print redirectForReturn($couponPlanTarget->getByKey($couponPlanTarget->getKeyValue(), "COUPONPLAN_DETAIL"))?></p>
                <section class="cd_section3 cf">
                    <h3>■店舗情報</h3>
                    <section>
                        <div class="image">
                        	<?php if ($couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_PIC") != "") {?>
                        	<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_PIC")?>" width="156" height="116" alt="<?php print $couponShop->getByKey($couponShop->getKeyValue(), "ROOM_NAME")?>">
                            <?php }else{?>
                        	<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="156" height="116" alt="<?php print $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_NAME")?>">
                            <?php }?>
                        </div>
                        <div class="text">
                          <p style="word-break:break-all; ">【住所】<?php print redirectForReturn($couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_ADDRESS"))?></p>
                          <p style="word-break:break-all; ">【電話番号】<?php print redirectForReturn($couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_TEL"))?></p>
                          <p style="word-break:break-all; ">【営業時間】<?php print redirectForReturn($couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_OPEN"))?></p>
                          <p style="word-break:break-all; ">【定休日】<?php print redirectForReturn($couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_HOLYDAY"))?></p>
                          <p style="word-break:break-all; ">【アクセス】<?php print redirectForReturn($couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_ACCESS"))?></p>
                          <p style="word-break:break-all; ">【詳細】<?php print redirectForReturn($couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_DETAIL"))?></p>
                        </div>
                    </section>
                </section>

				</section>
				

<?php }?><?php }?>

                   




                   	</div>
               </section>

                </div>
            </div>
        </article>

<?php }?>

    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd -->
</html>
