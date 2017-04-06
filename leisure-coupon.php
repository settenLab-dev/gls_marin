<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/activity.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/coupon.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('login.php');
	exit;
}

$activity = new activity($dbMaster);
$activity->select(cmIdCheck(constant("activity::keyName")), "2");

$coupon = new coupon($dbMaster);
$coupon->select("", "2", cmIdCheck(constant("activity::keyName")), 2);

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
<?php require("includes/box/common/meta201505.php"); ?>
<title>レジャー情報 クーポン｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="レジャー,クーポン,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
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
            <li><a href="leisure-list.html">グルメ情報</a></li>
            <li><span>レジャークーポン</span></li>
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
		<li class="menu_g2"><a href="<?php URL_PUBLIC?>leisure-menu<?php print $activity->getByKey($activity->getKeyValue(), "COMPANY_ID");?>.html" class="link2">メニュー</a></li>
		<li class="menu_g4"><a href="<?php URL_PUBLIC?>leisure-coupon<?php print $activity->getByKey($activity->getKeyValue(), "COMPANY_ID");?>.html" class="stay4">クーポン</a></li>
		</ul>
		</div>

			<article class="inner detailText1 cf">
				<div>
					<p><?php print redirectForReturn($activity->getByKey($activity->getKeyValue(), "ACTIVITY_STAFFPUSHU"))?></p>
				</div>
				<ul>
					<li>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC2") != "") {?>
						<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC2")?>" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>">
					<?php }else{?>
						<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>">
					<?php }?>
					</li>
					<li>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC3") != "") {?>
						<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC3")?>" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>">
					<?php }else{?>
						<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="125" height="90" alt="<?php print $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME");?>">
					<?php }?>
					</li>
				</ul>
			</article>


			<article class="coupon-list-l">
				<h2 style="margin-bottom: 15px;margin-left: 5px;"><img src="./images/category/cheack-coupon-bg_n2.jpg" width="931" height="147" alt="限定クーポンでお得に楽しもう" /></h2>
				<ul class="coupon-leisure">
				
					<?php
					if ($coupon->getCount() > 0) {
						foreach ($coupon->getCollection() as $k=>$data) {
							$i=1;
					?>
						<?php if ($data["COUPON_NAME"] != "") {?>
						<li class="c-l0<?=$i?>">
							<div>
								<h3><?php print $data["COUPON_NAME"]?></h3>
								<ul>
									<li><?php print redirectForReturn($data["COUPON_CONTENT"])?></li>
									<!--<li>金額：<?php print number_format($data["COUPON_PAY"])?>円</li>-->
									<li>有効期限：<?php print $data["COUPON_DATE_FROM"]?> ～ <?php print $data["COUPON_DATE_TO"]?>
									</li>
								</ul>
							</div>
							<ul class="link">
								<li><a href="" onclick="window.print()"><img src="./images/category/print-bt.png" width="190" height="27" alt="このクーポンを印刷する" /></a></li>
								<!--<li><a href=""><img src="./images/category/mail.bt.png" width="190" height="27" alt="このクーポンを携帯に送る" /></a></li>-->
							</ul>
						
						</li>
					<?php 
						$i++;
						}?>
					<?php
						}
					}
					?>

				</ul>
			</article>


        <!--bottom-->
		<article id="subbox">
			<h2>お店の基本情報</h2>
			<div class="inner">
				<table>
					<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TIME") != "") {?>
					<tr>
						<th>営業時間</th>
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
    