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
<title>お問い合わせ先 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
	            <li><a href="index.html">サイトの利用方法</a></li>
	            <li><span>お問い合わせ先</span></li>
	        </ul>
	
			<section class="howto">
				<h2 class="t-title"><img src="./images/howto/contact.png" width="697" height="39" alt="お問い合わせ先" /></h2>
				<div class="howto_case">
					<p class="ntxt">ココトモ！へのお問い合わせはこちらからどうぞ。</p>
					<ul class="infoList">
						<li>■<span class="rsp">メール</span><a href="mailto:info@cocotomo.net">info@cocotomo.net</a></li>
						<li>■<span class="rsp">電話番号</span>098-988-8105</li>
						<li>■<span class="rsp">営業時間</span>平日 月～金（AM9:00～PM18:00）</li>
					</ul>
					<p>
						※営業時間外のお問い合わせにつきましては、翌営業日以降のご連絡となります。何卒ご了承ください。	
					</p>
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
