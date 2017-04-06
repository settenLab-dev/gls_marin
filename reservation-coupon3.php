<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponShop.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBooking.php');

///////////////////////
//	fax
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
///////////////////////


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('login.php');
	exit;
}


$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);

$coupon = new coupon($dbMaster);
$coupon->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

///////////////////////
//	fax
$company = new company($dbMaster);
$company->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
///////////////////////

$couponBooking = new couponBooking($dbMaster);
$is_request=false;
require_once('includes/box/coupon/reservcoupon.php');


$inputs = new inputs(); ?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta_new1.php"); ?>
<title>クーポン購入手続き ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="クーポン購入,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="クーポン購入ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.min.js"></script>
<SCRIPT>
	history.forward();
</SCRIPT>
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
	<main id="detail_n" class="reservation_n">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>クーポン購入手続き</span></li>
        </ul>

        <div class="mainbox">
        	<?php
			if ($couponBooking->getErrorCount() > 0) {
			?>
				<?php print create_error_caption($couponBooking->getError())?>
			<?php
			}
			?>
        	<form method="post" action="">
            	<?php require("includes/box/coupon/completeResrv-coupon2.php");?>
            </form>
        </div>

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
