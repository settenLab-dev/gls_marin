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

// 非会員がログインしている状態の場合はログアウト処理
if($sess->getSessionByKey($sess->getSessionLogninKey(), 'MEMBER_STATUS') == 4){
	//cookieをタイムアウト設定
	$sess->setCookieData($memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_ID"), $memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_PASSWORD"), time() - 3600);

	$sess->destroy();
}

// 非会員で予約できるようにする
if (empty($_POST['nomember']) && !$sess->sessionCheck()) {
	// プランIDを保持していない場合はトップページへ
	if (empty($_POST['SHOPPLAN_ID'])){
		cmLocationChange("index.html");
		exit;
	}
	
	require_once('login_reserve.php');
	exit;
}

// プランIDを保持していない場合はトップページへ
if (empty($_POST['SHOPPLAN_ID'])){
	cmLocationChange("index.html");
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
$shopBooking->setPost();

$is_request=false;

require_once('includes/box/hotel/reservpb.php');

//print_r($_POST);
//print_r($collection);







$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<SCRIPT>
	history.forward();
</SCRIPT>
<?php require("includes/box/common/meta201505.php"); ?>
<title>お申込フォーム ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="予約,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="PlayBookingの予約お申込みページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="detail_n" class="reservation_n">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>レジャー予約</span></li>
        </ul>

        <div class="mainbox ">
        	<?php
			if ($shopBooking->getErrorCount() > 0) {
			?>
				<?php print create_error_caption($shopBooking->getError());?>
			<?php
			}
			?>
        	<form method="post" action="">
            	<?php
					if ($collection->getByKey($collection->getKeyValue(), "regist") and $shopBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/completeResrv.php");
					}
					elseif ($collection->getByKey($collection->getKeyValue(), "confirm_x") and $shopBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/confirmReserv.php");
					}
					else {
						require("includes/box/hotel/inputReserv.php");
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
