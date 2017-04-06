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
<title>ココトモの利用方法 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
		<main id="howto">
	
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><span>サイトの利用方法</span></li>
	        </ul>
	
			<section class="howto">
				<h2 class="title2016" style="margin-bottom:15px;">ココトモの利用方法</h2>
				<div class="howto_case">
					<p>ココトモをお得に楽しくご利用いただくための利用方法をご案内します。</p>
					<ul class="infoList">
						<li>■<a href="lodging-reservation.html">宿泊予約の利用方法</a></li>
						<li>■<a href="save-points.html">ポイントの貯め方・特典との交換方法、お買い物時の注意点</a></li>
						<li>■<a href="gourmet-leisure-description.html">グルメ・レジャー情報の利用方法</a></li>
						<li>■<a href="contact.html">お問い合わせ</a></li>
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
