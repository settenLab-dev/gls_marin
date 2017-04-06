<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/activity.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
// if (!$sess->sessionCheck()) {
// 	require_once('login.php');
// 	exit;
// }

$activity = new activity($dbMaster);
$activity->select(cmIdCheck(constant("activity::keyName")), "2");


$xmlCategory = new xml(XML_ACTIVITY_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$activity->setErrorFirst("カテゴリデータの読み込みに失敗しました");
}

$xmlCategoryDetail = new xml(XML_ACTIVITY_CATEGORY_DETAIL);
$xmlCategoryDetail->load();
if (!$xmlCategoryDetail->getXml()) {
	$activity->setErrorFirst("詳細カテゴリデータの読み込みに失敗しました");
}

$xmlFeature = new xml(XML_FEATURE_A);
$xmlFeature->load();
if (!$xmlFeature->getXml()) {
	$activity->setErrorFirst("特徴データの読み込みに失敗しました");
}

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$activity->setErrorFirst("エリアデータの読み込みに失敗しました");
}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta_new.php"); ?>
<title>レジャー情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="レジャー,<?php print SITE_PUBLIC_KEYWORD?>" />
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
<?php require("includes/box/common/header_n.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail" class="gourmet">
    
		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="gourmet-list.html">レジャー情報</a></li>
            <li><span>レジャー情報詳細</span></li>
        </ul>
        
        <!--top-->
		<article id="gourmet-detaile">
			<div class="header-blu">
				<h2><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?></h2>
				<?php
                $arArea = array();
                $arTemp = explode(":", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_LIST_AREA"));
                if (count($arTemp) > 0) {
                	foreach ($arTemp as $a) {
                		if ($a != "") {
                			$arArea[$a] = $a;
                		}
                	}
                }

                $arCategory = array();
                $arTemp = explode(":", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_LIST_CATEGORY"));
                if (count($arTemp) > 0) {
                	foreach ($arTemp as $ca) {
                		if ($ca != "") {
                			$arCategory[$ca] = $ca;
                		}
                	}
                }
                ?>
				<ul>
					<?php if (count($arArea) > 0) {?>
						<?php foreach ($arArea as $k=>$v) {?>
					    <li><?php print $xmlArea->getNameByValue($k)?></li>
					    <?php }?>
					<?php }?>
					<?php if (count($arCategory) > 0) {?>
						<?php foreach ($arCategory as $k=>$v) {?>
					    <li><?php print $xmlCategory->getNameByValue($k)?></li>
					    <?php }?>
					<?php }?>
				</ul>
			</div>

			<div class="inner cf" id="lightboxes">
				<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC1") != "") {?>
					<a href="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC1")?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC1")?>" width="133" class="l-img"  height="112" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>"></a>
				<?php }else {?>
					<img src="<?php print URL_SLAKER_COMMON?>asstes/noImage.jpg" width="133" height="112" class="l-img"  alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>">
				<?php }?>
				<div class="r-cn">
                        <ul class="icon">
                        	<?php foreach ($arFeature as $k=>$v) {?>
                        	<li><img src="<?php print URL_PUBLIC.cmFeatureImageA($k)?>" alt="<?php print $xmlFeature->getNameByValue($k)?>"></li>
                        	<?php }?>
                        </ul>

					<article class="news_cn">
						<h3><img src="./images/category/gourmet-detaile-Titlenews-topic.png" width="76" height="35" alt="NEWS TOPICS" /></h3>
						<ul>
							<li><?php print redirectForReturn($activity->getByKey($activity->getKeyValue(), "ACTIVITY_TOPICKS"))?></li>
						</ul>
					</article>
				</div>
			</div>

				<article class="ceack">
					<div>
						<strong><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_CATCHCOPY")?></strong>
					</div>
				</article>

			<article class="inner detailText1 cf" id="lightboxes">
				<div>
					<p><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_STAFFPUSHU")?></p>
				</div>
				<ul>
					<li>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC2") != "") {?>
						<a href="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC2")?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC2")?>" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>"></a>
					<?php }else{?>
						<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>">
					<?php }?>
					</li>
					<li>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC3") != "") {?>
						<a href="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC3")?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC3")?>" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>"></a>
					<?php }else{?>
						<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>">
					<?php }?>
					</li>
				</ul>
			</article>


			<section>
				<h2 class="title-blu"><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?></h2>
				<div class="inner-dot cf">
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC1") != "") {?>
						<div id="lightboxes"><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC1")?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC1")?>" width="180" height="151" class="fl-l" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>"></a></div>
					<?php }?>
					<div>
						<h3><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_TITLE1")?></h3>
						<p><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_CONTENT1")?></p>
					</div>
				</div>

				<div class="inner-dot cf">
					<div class="fl-l">
						<h3><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_TITLE2")?></h3>
						<p><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_CONTENT2")?></p>
					</div>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC2") != "") {?>
						<div id="lightboxes"><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC2")?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC2")?>" width="180" height="151" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>"></a></div>
					<?php }?>
				</div>
				
				<div class="inner-dot cf">
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC3") != "") {?>
						<div id="lightboxes"><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC3")?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC3")?>" width="180" height="151" class="fl-l" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>"></a></div>
					<?php }?>
					<div>
						<h3><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_TITLE3")?></h3>
						<p><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_CONTENT3")?></p>
					</div>
				</div>
				
			</section>

			<div class="cheack-coupon2">
				<a href="<?=URL_PUBLIC?>leisure-coupon<?=$activity->getByKey($activity->getKeyValue(), "COMPANY_ID");?>.html"><img src="./images/category/bt_coupon-display.jpg" width="190" height="33" alt="クーポン券を表示" /></a>
			</div>
		</article>

        <!--bottom-->
		<article id="subbox">
			<h2>お店の基本情報</h2>
			<div class="inner">
				<table>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TIME") != "") {?>
					<tr>
						<th width="20%">営業時間</th>
						<td><?php print redirectForReturn($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TIME"))?></td>
					</tr>
					<?php }?>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_SHEET") != "") {?>
					<tr>
						<th>総席数</th>
						<td>総席数：<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_SHEET")?>席</td>
					</tr>
					<?php }?>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TIME") != "") {?>
					<tr>
						<th>予算の目安</th>
						<td><?php print redirectForReturn($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_MONEY"))?>～</td>
					</tr>
					<?php }?>
					<tr>
						<th>住所</th>
						<td>
						<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ZIP") != "") {?>
						<span>〒 <?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ZIP")?> </span>
						<?php }?>
						<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PREF_ID") != "") {?>
						<?php
						$ar = cmGetPrefName();
						?>
						<span><?php print $ar[$activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PREF_ID")]?></span>
						<?php }?>
						<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_CITY") != "") {?>
						<span><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_CITY")?> </span>
						<?php }?>
						<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ADDRESS") != "") {?>
						<span><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ADDRESS")?> </span>
						<?php }?>
						</td>
					</tr>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TEL") != "") {?>
					<tr>
						<th>電話番号</th>
						<td><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TEL")?></td>
					</tr>
					<?php }?>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ACCESS") != "") {?>
					<tr>
						<th>アクセス</th>
						<td><?php print redirectForReturn($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ACCESS"))?></td>
					</tr>
					<?php }?>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ACCESS") != "") {?>
					<tr>
						<th>駐車場</th>
						<td><?php print redirectForReturn($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PARKING"))?>台</td>
					</tr>
					<?php }?>
				</table>

				<div class="map">
					<h3>アクセスマップ</h3>
					<iframe width="242" height="239" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="http://maps.google.co.jp/maps?q=loc:<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_LAT")?>,<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_LNG")?>&iwloc=J&output=embed"></iframe>
				</div>
			</div>
		</article>
                
	</main>	
	<!-- InstanceEndEditable -->    
	
    <!--/main-->
    
</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_n.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>

