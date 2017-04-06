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
<?php require("includes/box/common/meta.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title><?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>

</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
		<!-- InstanceBeginEditable name="maincontents" -->
		<main id="howto">
	
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><span>ココトモ！ジョブ</span></li>
	        </ul>
	
			<section class="howto">
				<h2 class="t-title"><img src="./images/job/title_job.png" width="664" height="72" alt="ココモ。ジョブ" /></h2>
				<div class="howto_case">
					<p>ココトモ！では、飲食店やホテルなどサービス業に特化した求人情報をお届けします。</br>
					現在、公開の準備中です。どうぞ、お楽しみに！</p>
</div>
			</section>
	
	    </main>
		<!-- InstanceEndEditable -->    
	    <!--/main-->
		
    <!--side-->
	<?php require("includes/box/common/right.php");?>
    <!--/side-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>

