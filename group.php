<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);

// $hotel = new hotel($dbMaster);
// $hotel->selectListPublic($collection);

// print_r($hotel->getCollection());

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title><?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>

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
	            <li><span>ココトモ！団体予約</span></li>
	        </ul>
	
			<section class="howto">
				<h2 class="title2016" style="margin-bottom:15px;">グループ、団体予約もココトモでかんたんお得に！</h2>
				<div class="howto_case">
					<h4>ココトモ！はグループ、団体でのおでかけ、宴会や模合をお手伝いします！</br>
					まずは、お気軽にご相談ください。</br></br>
					<B>【お問い合わせ先】</br>
					Mail：<a href="mailto:info@cocotomo.net">info@cocotomo.net</a></br>
					TEL ：098-988-8105　（ココトモ！担当まで）</B></p></h4>
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

