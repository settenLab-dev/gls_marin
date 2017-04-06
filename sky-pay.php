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
<meta charset="utf-8">
<!--<link href="<?=URL_PUBLIC?>css/style.css" rel="stylesheet" type="text/css">-->
<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/common.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=URL_PUBLIC?>css/base.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=URL_PUBLIC?>css/style2.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=URL_PUBLIC?>css/style201505.css" type="text/css" media="screen" />
<!--<link rel="stylesheet" href="<?=URL_PUBLIC?>css/new-style.css" type="text/css" media="screen" />-->
<link rel="stylesheet" href="<?=URL_PUBLIC?>js/slider/jquery.bxslider.css" type="text/css" media="screen">
<link href="<?=URL_PUBLIC?>js/scroller/li-scroller.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?=URL_PUBLIC?>js/jquery-1.10.2.min.js"></script>
<script src="<?=URL_PUBLIC?>js/scroller/jquery.li-scroller.1.0.js"></script>
<script type="text/javascript" src="<?=URL_PUBLIC?>js/common.js"></script>
<script type="text/javascript" src="<?=URL_PUBLIC?>js/slider/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?=URL_PUBLIC?>js/function.js"></script>

<!--[if lt IE 9]>
<script src="<?=URL_PUBLIC?>js/html5shiv.js"></script>
<script src="<?=URL_PUBLIC?>js/PIE.js"></script>
<![endif]-->

<title>スカイツアーズお支払方法のご案内<?php print SITE_PUBLIC_NAME?></title>
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
	<main id="opensale" class="">
    
    	<!--top-image-->

		<ul id="panlist">
        	<li><span><a href="index.html">TOPページ</a></span></li>
            <li><span><a href="tour-pickup.html">日帰りレジャー特集</a></span></li>
            <li>スカイツアーズお支払方法</span></li>
        </ul>

		<!--topimage-->
		<div id="opensale_cn">
		<img src="./images/opnesale/payment.jpg" width="698" alt="お支払方法のご案内" /></br>
			<!--<section id="topimage">
			</section>--></br>

<!--PlanningOpensele-->
		
			<!--terms-->
				<section>
					<div>
						<div>
						</div>
					</div>
				</section>
		</div>

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

