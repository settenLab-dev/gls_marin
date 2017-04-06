<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/groumet.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/coupon.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('login.php');
	exit;
}

$gourmet = new groumet($dbMaster);
$gourmet->select(cmIdCheck(constant("groumet::keyName")), "2");

$coupon = new coupon($dbMaster);
$coupon->select("", "2", cmIdCheck(constant("groumet::keyName")), 1);

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


//ココポンデータの取得


$param = "http://cocotomo.net/coupon-detail.html?company_id=187&shop_id=20&cplan_id=40";
// parse_strで分解処理し、第二引数で配列の変数名を指定
parse_str($param, $str);
 
// 配列の要素として出力

//print_r($str);
//print_r($str['http://cocotomo_net/coupon-detail_html?company_id']);
//print_r($str['shop_id']);
//print_r($str['cplan_id']);


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<title>グルメ情報 クーポン｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="グルメ,クーポン,<?php print SITE_PUBLIC_KEYWORD?>" />
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
            <li><a href="gourmet-list.html">グルメ情報</a></li>
            <li><a href="gourmet-detail.html">グルメ情報詳細</a></li>
            <li><span>グルメクーポン</span></li>
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
		<li class="menu_g3"><a href="<?php URL_PUBLIC?>gourmet-gallery<?php print $gourmet->getByKey($gourmet->getKeyValue(), "COMPANY_ID");?>.html" class="link3">クーポン</a></li>
		<li class="menu_g4"><a href="<?php URL_PUBLIC?>gourmet-coupon<?php print $gourmet->getByKey($gourmet->getKeyValue(), "COMPANY_ID");?>.html" class="stay4">クーポン</a></li>
		</ul>
		</div>

		<!--
			<article class="inner detailText1 cf">
				<div>
					<p><?php print redirectForReturn($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_STAFFPUSHU"))?></p>
				</div>
				<ul>
					<li>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_PIC2") != "") {?>
						<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_PIC2")?>" width="125" height="90" alt="<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_SHOPNAME");?>">
					<?php }else{?>
						<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="125" height="90" alt="<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_SHOPNAME");?>">
					<?php }?>
					</li>
					<li>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_PIC3") != "") {?>
						<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_PIC3")?>" width="125" height="90" alt="<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_SHOPNAME");?>">
					<?php }else{?>
						<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="125" height="90" alt="<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_SHOPNAME");?>">
					<?php }?>
					</li>
				</ul>
			</article>
		-->

			<?php if ($coupon->getCount() > 0) {?>
			<article class="coupon-list-g">
				<h2 style="margin-bottom: 15px;margin-left: 5px;"><img src="./images/category/cheack-coupon-bg_n1.png" width="931" height="146" alt="限定クーポンでお得に楽しもう" /></h2>
				<ul class="coupon-leisure">
				
					<?php
					if ($coupon->getCount() > 0) {
						foreach ($coupon->getCollection() as $k=>$data) {
							$i=1;
					?>
						<?php if ($data["COUPON_NAME"] != "") {?>
						<li class="g-l0<?=$i?>">
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
								<li><a href="#" target="blank" onclick="window.print(); return false;"><img src="./images/category/print-bt.png" width="190" height="27" alt="このクーポンを印刷する" /></a></li>
								<!--<li><a href="#"><img src="./images/category/mail.bt.png" width="190" height="27" alt="このクーポンを携帯に送る" /></a></li>-->
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

			<?php }else{?>
			<section>
				</br></br>
				<center><B>ただいまクーポンの掲載準備中です。</B></center>
			</section>
			<?php }?>



        <!--bottom-->

	<!--
		<article id="subbox">
			<h2>お店の基本情報</h2>
			<div class="inner">
				<table>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_TIME") != "") {?>
					<tr>
						<th>営業時間</th>
						<td><?php print redirectForReturn($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_TIME"))?></td>
					</tr>
					<?php }?>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_SHEET") != "") {?>
					<tr>
						<th>総席数</th>
						<td>総席数：<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_SHEET")?>席</td>
					</tr>
					<?php }?>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_TIME") != "") {?>
					<tr>
						<th>予算の目安</th>
						<td><?php print redirectForReturn($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_MONEY"))?>～</td>
					</tr>
					<?php }?>
					<tr>
						<th>住所</th>
						<td>
						<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_ZIP") != "") {?>
						<span>〒 <?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_ZIP")?> </span>
						<?php }?>
						<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_PREF_ID") != "") {?>
						<?php
						$ar = cmGetPrefName();
						?>
						<span><?php print $ar[$gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_PREF_ID")]?></span>
						<?php }?>
						<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_CITY") != "") {?>
						<span><?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_CITY")?> </span>
						<?php }?>
						<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_ADDRESS") != "") {?>
						<span><?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_ADDRESS")?> </span>
						<?php }?>
						</td>
					</tr>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_TEL") != "") {?>
					<tr>
						<th>電話番号</th>
						<td><?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_TEL")?></td>
					</tr>
					<?php }?>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_ACCESS") != "") {?>
					<tr>
						<th>アクセス</th>
						<td><?php print redirectForReturn($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_ACCESS"))?></td>
					</tr>
					<?php }?>
					<?php if ($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_ACCESS") != "") {?>
					<tr>
						<th>駐車場</th>
						<td><?php print redirectForReturn($gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_PARKING"))?>台</td>
					</tr>
					<?php }?>
				</table>

				<div class="map">
					<h3>アクセスマップ</h3>
					<iframe width="242" height="239" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="http://maps.google.co.jp/maps?q=loc:<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_LAT")?>,<?php print $gourmet->getByKey($gourmet->getKeyValue(), "GOURMET_BASIC_LNG")?>&iwloc=J&output=embed"></iframe>
				</div>
			</div>
		</article>
	-->

        <ul id="social">
            <li><a href="#"><img src="images/common/common-bottom-twitter.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mixi.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-gree.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-fb.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mail.png"></a></li>
        </ul>
        
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
    