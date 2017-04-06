<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');

///////////////////////
//	fax
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
///////////////////////


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('login_reserve.php');
	exit;
}


$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);


$shop = new shop($dbMaster);
$shop->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

///////////////////////
//	fax
$company = new company($dbMaster);
$company->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
///////////////////////

$shopBooking = new shopBooking($dbMaster);

$is_request=true;

require_once('includes/box/hotel/reservpb.php');

$inputs = new inputs();
?>

<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>リクエスト予約フォーム ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="予約,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="PlayBookingの予約ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
<SCRIPT>
	history.forward();
</SCRIPT>
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
	<main id="detail" class="reservation">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>リクエスト予約</span></li>
        </ul>

        <div class="mainbox ">
        	こちらのプランは予約リクエストの受付となります。予約リクエストの送信後、施設店舗より予約可否をご連絡いたします。<br/>
        	以下の必要事項を入力し、確認ページへお進みください。<br/><br/>
        	<?php
			if ($hotelBooking->getErrorCount() > 0) {
			?>
						<?php print create_error_caption($hotelBooking->getError())?>
			<?php
			}
			?>
        	<form method="post" action="">
            	<?php
					if ($collection->getByKey($collection->getKeyValue(), "regist") and $hotelBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/completeRequestResrv.php");
					}
					elseif ($collection->getByKey($collection->getKeyValue(), "confirm_x") and $hotelBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/confirmRequestReserv.php");
					}
					else {
						require("includes/box/hotel/inputRequestReserv.php");
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
