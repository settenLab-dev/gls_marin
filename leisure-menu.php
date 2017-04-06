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

$xmlFeature = new xml(XML_FEATURE);
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
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
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
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail_n" class="gourmet">
    
		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="leisure-list.html">レジャー情報</a></li>
            <li><span>レジャー情報詳細</span></li>
        </ul>
        
        <!--top-->
		<article id="gourmet-detaile">
			<div class="header-blu">
		<h3><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_CATCHCOPY")?></h3>
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
                ?>
                <ul class="cf">
                	<?php if (count($arArea) > 0) {?>
                    	<?php foreach ($arArea as $k=>$v) {?>
                        <li class="area"><?php print $xmlArea->getNameByValue($k)?></li>
                        <?php }?>
                    <?php }?>
                </ul>
			<h2><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?></h2>
		<div class="tokucho">
		<?php
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
						<?php
						$arFeature = array();
						$arTemp = explode(":", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_LIST_FEATURE"));
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
						<?php if (count($arFeature) > 0) {?>
							<?php foreach ($arFeature as $k=>$v) {?>
						    <li><img src="<?php print URL_PUBLIC.cmFeatureImageG($k)?>" alt="<?php print $xmlFeature->getNameByValue($k)?>"></li>
						    <?php }?>
						<?php }?>
                </ul>
		</div>
			</div>
		<div id="menu_box">
		<ul class="menu_list cf">
		<li class="menu_l1"><a href="<?php URL_PUBLIC?>leisure-detail<?php print $activity->getByKey($activity->getKeyValue(), "COMPANY_ID");?>.html" class="link1">お店の情報</a></li>
		<li class="menu_g2"><a href="<?php URL_PUBLIC?>leisure-menu<?php print $activity->getByKey($activity->getKeyValue(), "COMPANY_ID");?>.html" class="stay2">メニュー</a></li>
		<li class="menu_g4"><a href="<?php URL_PUBLIC?>leisure-coupon<?php print $activity->getByKey($activity->getKeyValue(), "COMPANY_ID");?>.html" class="link4">クーポン</a></li>
		</ul>
		</div>

			<div class="inner cf">
					<article class="news_cn">
						<h3><img src="./images/category/news_title.png" width="135" height="22" alt="NEWS TOPICS" /></h3>
						<ul>
							<li><?php print redirectForReturn($activity->getByKey($activity->getKeyValue(), "ACTIVITY_TOPICKS"))?></li>
						</ul>
					</article>
			</div>

			<section>
			<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_CONTENT4")?>
			</section>

			<div class="cheack-coupon2">
				<a href="<?php URL_PUBLIC?>gourmet-coupon<?php print $activity->getByKey($activity->getKeyValue(), "COMPANY_ID");?>.html"><img src="./images/category/bt_coupon-display.jpg" width="190" height="33" alt="クーポン券を表示" /></a>
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
					<iframe width="380" height="380" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="http://maps.google.co.jp/maps?q=<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_CITY")?><?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ADDRESS")?>&iwloc=J&output=embed"></iframe>
				</div>
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
    