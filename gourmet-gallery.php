<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/groumet.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPicGroup.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/coupon.php');


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
// if (!$sess->sessionCheck()) {
// 	require_once('login.php');
// 	exit;
// }

$gourmet = new groumet($dbMaster);
$gourmet->select(cmIdCheck(constant("groumet::keyName")), "2");

$coupon = new coupon($dbMaster);
$coupon->select("", "2", cmIdCheck(constant("groumet::keyName")), 1);

$gourmetPic = new gourmetPic($dbMaster);
$gourmetPic->select("", "2", cmIdCheck(constant("groumet::keyName")));


$gourmetPicGroup = new gourmetPicGroup($dbMaster);
$gourmetPicGroup->select("", "1", cmIdCheck(constant("groumet::keyName")));
// echo 'a'.$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID");exit;


$inputsOnly = new inputs(true);
foreach ($gourmetPic->getCollection() as $ad) {
	if ($ad["GOURMETPICGROUP_ID"] > 0) {
		$gourmetpics[6][$ad["GOURMETPICGROUP_ID"]][]=$ad;
	}else{
		switch ($ad["GOURMETPICGROUP_ID"]) {
			case -1:
				$gourmetpics[1][]=$ad;
				//print "部屋";
				break;
			case -2:
				$gourmetpics[2][]=$ad;
				//print "食事";
				break;
			case -3:
				$gourmetpics[3][]=$ad;
				//print "館内施設";
				break;
			case -4:
				$gourmetpics[4][]=$ad;
				//print "風景";
				break;
			case -5:
				$gourmetpics[5][]=$ad;
				//print "その他";
				break;
		}
	}
}




$xmlCategory = new xml(XML_GOURMET_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$gourmet->setErrorFirst("カテゴリデータの読み込みに失敗しました");
}

$xmlCategoryDetail = new xml(XML_GOURMET_CATEGORY_DETAIL);
$xmlCategoryDetail->load();
if (!$xmlCategoryDetail->getXml()) {
	$gourmet->setErrorFirst("詳細カテゴリデータの読み込みに失敗しました");
}

$xmlFeature = new xml(XML_FEATURE);
$xmlFeature->load();
if (!$xmlFeature->getXml()) {
	$gourmet->setErrorFirst("特徴データの読み込みに失敗しました");
}

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$gourmet->setErrorFirst("エリアデータの読み込みに失敗しました");
}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>フォトギャラリー ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="グルメ,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<!-- Arquivos utilizados pelo jQuery lightBox plugin -->
    <!--<script type="text/javascript" src="http://common.cocotomo.net/js/jquery.js"></script>-->
    <script type="text/javascript" src="http://common.cocotomo.net/js/jquery.lightbox-0.5.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cocotomo.net/css/jquery.lightbox-0.5.css" media="screen" />
    <!-- / fim dos arquivos utilizados pelo jQuery lightBox plugin -->
<script type="text/javascript">
$(function() {
	$('#lightboxes a').lightBox({fixedNavigation:true});
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
    <main id="detail_n" class="gourmet">
    
		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="gourmet-list.html">グルメ情報</a></li>
            <li><span>グルメ情報詳細</span></li>
        </ul>
        
        <!--top-->
		<article id="gourmet-detaile">
			<div class="header">
		<h3><?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_CATCHCOPY")?></h3>
				<?php
                $arArea = array();
                $arTemp = explode(":", $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_LIST_AREA"));
                if (count($arTemp) > 0) {
                	foreach ($arTemp as $a) {
                		if ($a != "") {
                			$arArea[$a] = $a;
                		}
                	}
                }
                ?>
                <ul class="cf">
                	<?php if (count($arArea) > 0) {?>
                    	<?php foreach ($arArea as $k=>$v) {?>
                        <li class="area"><?php print $xmlArea->getNameByValue($k)?></li>
                        <?php }?>
                    <?php }?>
                </ul>
			<h2><?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_SHOPNAME");?></h2>
		<div class="tokucho">
		<?php
                $arCategory = array();
                $arTemp = explode(":", $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_LIST_CATEGORY"));
                if (count($arTemp) > 0) {
                	foreach ($arTemp as $ca) {
                		if ($ca != "") {
                			$arCategory[$ca] = $ca;
                		}
                	}
                }
                ?>
						<?php
						$arFeature = array();
						$arTemp = explode(":", $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_LIST_FEATURE"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arFeature[$data] = $data;
								}
							}
						}
						?>

                <ul class="cf">
                    <?php if (count($arCategory) > 0) {?>
                    	<?php foreach ($arCategory as $k=>$v) {?>
                        <li class="cate"><?php print $xmlCategory->getNameByValue($k)?></li>
                        <?php }?>
                    <?php }?>
<!--
						<?php if (count($arFeature) > 0) {?>
							<?php foreach ($arFeature as $k=>$v) {?>
						    <li><img src="<?php print URL_PUBLIC.cmFeatureImageG($k)?>" alt="<?php print $xmlFeature->getNameByValue($k)?>"></li>
						    <?php }?>
						<?php }?>
-->
                </ul>
		</div>
			</div>
		<div id="menu_box">
		<ul class="menu_list cf">
		<li class="menu_g1"><a href="<?php URL_PUBLIC?>gourmet-detail<?php print $gourmet->getByKey($gourmet->getKeyValue(), "COMPANY_ID");?>.html" class="link1">お店の情報</a></li>
		<li class="menu_g2"><a href="<?php URL_PUBLIC?>gourmet-menu<?php print $gourmet->getByKey($gourmet->getKeyValue(), "COMPANY_ID");?>.html" class="link2">メニュー</a></li>
		<li class="menu_g3"><a href="<?php URL_PUBLIC?>gourmet-gallery<?php print $gourmet->getByKey($gourmet->getKeyValue(), "COMPANY_ID");?>.html" class="stay3">フォトギャラリー</a></li>
		<li class="menu_g4"><a href="<?php URL_PUBLIC?>gourmet-coupon<?php print $gourmet->getByKey($gourmet->getKeyValue(), "COMPANY_ID");?>.html" class="link4">クーポン</a></li>
		</ul>
		</div>


	<section>
	<?php if($gourmetPic->getCount() > 0){?>

	<article class="mainbox">

        <div class="tabframe" id="lightboxes">
        <table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
		<tr><td colspan=3><B>＜＜　外観　＞＞</B></td></tr>
	    	<?php if ($gourmetPic->getCount() > 0) {?>
	    	<tr>
	    			<?php
	    			$cnt = 0;
	    			$cntAll = 0;
	    			foreach ($gourmetpics[1] as $ad) {
	    			$cnt++;
	    			?>
    
    					<td>
    						<a href="http://common.cocotomo.net/images/<?=$ad["GOURMETPIC_DATA"]?>" title="<?php print nl2br($ad["GOURMETPIC_DISCRIPTION"])?>">
						<?=$inputsOnly->image("GOURMETPIC_DATA", $ad["GOURMETPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?><br/>
							<?php print nl2br(cmStrimWidth($ad["GOURMETPIC_DISCRIPTION"], 0, 26, '…'))?>
							</a>
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
        	<tr><td colspan=3><B>＜＜　店内　＞＞</B></td></tr>
	    	<?php if ($gourmetPic->getCount() > 0) {?>
	    	<tr>
	    			<?php
	    			$cnt = 0;
	    			$cntAll = 0;
	    			foreach ($gourmetpics[2] as $ad) {
	    			$cnt++;
	    			?>
	    
	    					<td>
	    						<a href="http://common.cocotomo.net/images/<?=$ad["GOURMETPIC_DATA"]?>" title="<?php print nl2br($ad["GOURMETPIC_DISCRIPTION"])?>">
							<?=$inputsOnly->image("GOURMETPIC_DATA", $ad["GOURMETPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?><br/>
							<?php print nl2br(cmStrimWidth($ad["GOURMETPIC_DISCRIPTION"], 0, 26, '…'))?>
							</a>
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
	        <tr><td colspan=3><B>＜＜　料理　＞＞</B></td></tr>
	    	<?php if ($gourmetPic->getCount() > 0) {?>
	    	<tr>
	    			<?php
	    			$cnt = 0;
	    			$cntAll = 0;
	    			foreach ($gourmetpics[3] as $ad) {
	    			$cnt++;
	    			?>
	    
	    					<td>
	    						<a href="http://common.cocotomo.net/images/<?=$ad["GOURMETPIC_DATA"]?>" title="<?php print nl2br($ad["GOURMETPIC_DISCRIPTION"])?>">
							<?=$inputsOnly->image("GOURMETPIC_DATA", $ad["GOURMETPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?><br/>
							<?php print nl2br(cmStrimWidth($ad["GOURMETPIC_DISCRIPTION"], 0, 40, '…'))?>
							</a>

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
	        <tr><td colspan=3><B>＜＜　飲み物　＞＞</B></td></tr>
	    	<?php if ($gourmetPic->getCount() > 0) {?>
	    	<tr>
	    			<?php
	    			$cnt = 0;
	    			$cntAll = 0;
	    			foreach ($gourmetpics[4] as $ad) {
	    			$cnt++;
	    			?>
	    
	    					<td>
	    						<a href="http://common.cocotomo.net/images/<?=$ad["GOURMETPIC_DATA"]?>" title="<?php print nl2br($ad["GOURMETPIC_DISCRIPTION"])?>">
							<?=$inputsOnly->image("GOURMETPIC_DATA", $ad["GOURMETPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?><br/>
							<?php print nl2br(cmStrimWidth($ad["GOURMETPIC_DISCRIPTION"], 0, 26, '…'))?>
							</a>
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
	    	<?php if ($gourmetPic->getCount() > 0) {?>
	    	<tr>
	    			<?php
	    			$cnt = 0;
	    			$cntAll = 0;
	    			foreach ($gourmetpics[5] as $ad) {
	    			$cnt++;
	    			?>
	    
	    					<td>
	    						<a href="http://common.cocotomo.net/images/<?=$ad["GOURMETPIC_DATA"]?>" title="<?php print nl2br($ad["GOURMETPIC_DISCRIPTION"])?>">
							<?=$inputsOnly->image("GOURMETPIC_DATA", $ad["GOURMETPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?><br/>
							<?php print nl2br(cmStrimWidth($ad["GOURMETPIC_DISCRIPTION"], 0, 26, '…'))?>
							</a>
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

    	<?php if($gourmetpics[6]){ ?>
    		<?php foreach ($gourmetpics[6] as $key=>$ads){?>
    		<table border="0" cellpadding="10" cellspacing="10" class="" summary="マスタデータ" width="100%">
		        <tr><td colspan=3><?php print $gourmetPicGroup->getByKey($key, "GOURMETPICGROUP_NAME");?></td></tr>
		    	<?php if ($gourmetPic->getCount() > 0) {?>
		    	<tr>
		    			<?php
		    			$cnt = 0;
		    			$cntAll = 0;
		    			foreach ($ads as $ad) {
		    			$cnt++;
		    			?>
		    
		    					<td>
		    						<a href="http://common.cocotomo.net/images/<?=$ad["GOURMETPIC_DATA"]?>" title="<?php print nl2br($ad["GOURMETPIC_DISCRIPTION"])?>">
								<?=$inputsOnly->image("GOURMETPIC_DATA", $ad["GOURMETPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?><br/>
								<?php print nl2br(cmStrimWidth($ad["GOURMETPIC_DISCRIPTION"], 0, 26, '…'))?>
							</a>
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

				<?php }else{?>
					</br></br>
					<center><B>ただいま写真掲載準備中です。</B></center>
				<?php }?>
					

			</section>
			</br></br>
			<?php if ($coupon->getCount() > 0) {?>
			<div class="cheack-coupon">
				<a href="<?php URL_PUBLIC?>gourmet-coupon<?php print $gourmet->getByKey($gourmet->getKeyValue(), "COMPANY_ID");?>.html">
					<img src="./images/category/bt_coupon-display.jpg" width="190" height="33" alt="クーポン券を表示" />
				</a>
			</div>
			<?php }?>

		</article>

        <!--bottom-->


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
    