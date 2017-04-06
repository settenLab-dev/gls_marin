<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliate.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>ココトモ！でポイントを貯めよう ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_short" class="clearfix">

	<!--main-->
		<!-- InstanceBeginEditable name="maincontents" -->
		<main id="reservation">
	
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><a href="index.html">サイトの利用方法</a></li>
	            <li><span>グルメ・レジャー情報の使い方</span></li>
	        </ul>
	
			<section>
				<h2 class="t-title"><img src="./images/rule/title-gourmet-leisure-description.png" width="723" height="39" alt="グルメ・レジャー情報の使い方" /></h2>
				<p class="t-txt">グルメ情報、レジャー情報では、ココトモ！スタッフがいちおしのお店を厳選してご紹介します。<br>お得なクーポンもご利用いただけます！</p>
				<div class="gourmet-leisure cf">
					<img class="reservationimg" src="./images/rule/gourmet-leisure-description1.jpg" width="299" height="660" alt="グルメ・レジャー情報説明" />
					<ul class="descriptionList">
						<li class="no1 on-txt">
							<span>お店の特徴やエリアを示すアイコンです</span>
						</li>
						<li class="no2">
							<span>新着TOPICS</span>
							<ul><li class="ntxt">お店からの旬な情報が届きます！</li></ul>
						</li>
						<li class="no3">
							<span>編集部レポート</span>
							<ul><li class="ntxt">ココトモ！スタッフが好き勝手にお店をレポート！</li></ul>
						</li>
						<li class="no4">
							<span>こんなトコ！</span>
						<ul><li class="ntxt">取材記事でお店を詳し</li></ul>
						</li>
						<li class="no5">
							<span>クーポン</span>
							<ul><li class="ntxt">お得にお店を楽しめるクーポンをゲットできます
	プリントアウトしたページや、携帯画面を店員さんにお見せください。</li></ul>
						</li>
						<li class="no6">
							<span>お店の基本情報</span>
							<ul>
									<li class="ntxt">お店の場所や営業時間、連絡先を確認できます。</li>
							</ul>
						</li>
					</ul>
				</div>
			</section>
	
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
