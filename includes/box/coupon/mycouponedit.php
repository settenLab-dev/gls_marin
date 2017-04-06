<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBooking.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponShop.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}


$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
$collection->setPost();

$couponBooking = new couponBooking($dbMaster);
$couponBooking->selectCancelData(cmIdCheck("COUPONBOOK_ID"), "", "", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
$couponBooking->setPost();


if ($couponBooking->getByKey($couponBooking->getKeyValue(), "bookingConfirm")) {
	$couponBooking->saveBooking();
	//$member->saveBirth();
}

$coupon = new coupon($dbMaster);
//$couponBookset = new couponBookset($dbMaster);


if ($couponBooking->getCount() > 0) {

	if($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")){
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $couponBooking->getByKey($couponBooking->getKeyValue(), "COMPANY_ID"));
	}
	
	$collection->setByKey($collection->getKeyValue(), "COUPONBOOK_ID", $couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_ID"));


	$coupon->selectList($collection);
//	$couponBookset->select($couponBooking->getByKey($couponBooking->getKeyValue(), "COMPANY_ID"));

//	$couponBookingcont = new couponBookingcont($dbMaster);
//	$couponBookingcont->selectList($collection);
//	$couponBookingcont->setPost();
	$shopid = $couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_ID");
//	$couponBookingcont->setByKey($couponBookingcont->getKeyValue(),"ROOM_ID", $roomid);

	if ($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_LINK") == "") {
		//	ココモ
		$couponPlan = new couponPlan($dbMaster);
		$couponPlan->select($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"));
//		$couponBookingcont->setByKey($couponBookingcont->getKeyValue(), "HOTELPLAN_CAN_DAY", $couponPlan->getByKey($couponPlan->getKeyValue(), "HOTELPLAN_CAN_DAY"));

	}
	else {
	}

}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_new1.php"); ?>
<title>購入したクーポン情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<script type="text/javascript">
$(function() {
   		$("#BOOKING_REQUEST").attr("disabled","disabled");
});
</script>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_n.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->
<!-- InstanceEndEditable -->

<!--content-->
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="mypoint">

        <!--日付・人数から検索-->
        <section class="box">
			<div class="inner">
        	<div id="hmenu_cn" class="radius10">
    	    	<menu class="mypge-menu">
	        		<li><a href="<?php print URL_PUBLIC?>mypage.html">マイページトップ</a></li>
	        		<li><a href="<?php print URL_PUBLIC?>mybasic.html">会員基本情報確認・変更</a></li>
        			<li><a href="<?php print URL_PUBLIC?>myhotel.html">宿泊・レジャー予約情報</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mycoupon.html">購入したクーポン</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mypoint.html">ポイント履歴</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></li>
    	    	</menu>
	        	<div class="bt-logout_cn">
        			<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
        	         <p class="bt-td"><?=$inputs->submit("","logout","ログアウト", "circle")?></p>
    	       		</form>
	           	</div>
           	</div>

        	<h2 class="title">購入したクーポン情報</h2>

        	
        	<?php if ($couponBooking->getErrorCount() > 0) {?>
			<?php print create_error_caption($couponBooking->getError())?>
			<br />
			<?php }?>

        	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
        	<?php
				require("includes/box/coupon/listCancelcoupon.php");
			?>
			<?php print $inputs->hidden("COUPONBOOK_ID", $couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_ID"));?>
			</form>
			</div>
        </section>

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
