<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/linkCount.php');

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

$hotel = new hotel($dbMaster);
$hotel->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

///////////////////////
//	fax
$company = new company($dbMaster);
$company->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
///////////////////////

$hotelBooking = new hotelBooking($dbMaster);
$is_request=false;
if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
	require_once('includes/box/hotel/reservkokomocoupon.php');
}
else {
	require_once('includes/box/hotel/reservlinkcoupon.php');
}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<SCRIPT>
	history.forward();
</SCRIPT>
<?php require("includes/box/common/meta201505.php"); ?>
<title>予約情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="予約,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="ホテルの予約ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
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
	<main id="detail_n" class="reservation_n">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>宿泊予約</span></li>
        </ul>

        <div class="mainbox ">
        	<?php
			if ($hotelBooking->getErrorCount() > 0) {
			?>
				<?php print create_error_caption($hotelBooking->getError())?>
			<?php
			}
			?>
        	<form method="post" action="">
            	<?php
            	if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
					if ($collection->getByKey($collection->getKeyValue(), "regist") and $hotelBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/completeResrvcoupon.php");
					}
					elseif ($collection->getByKey($collection->getKeyValue(), "confirm_x") and $hotelBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/confirmReservcoupon.php");
					}
					else {
						require("includes/box/hotel/inputReservcoupon.php");
					}
				}
				else {
					if ($collection->getByKey($collection->getKeyValue(), "regist") and $hotelBooking->getErrorCount() <= 0) {
						echo 1;
					}
					elseif ($collection->getByKey($collection->getKeyValue(), "confirm_x") and $hotelBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/confirmReservLinkcoupon.php");
					}
					else {
						require("includes/box/hotel/inputReservLinkcoupon.php");
					}
				}
				?>
            </form>
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
