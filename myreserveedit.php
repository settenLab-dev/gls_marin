<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/ShopAccess.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

// require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopProvide.php');
// require_once(PATH_SLAKER_COMMON.'includes/class/extends/Room.php');

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

// 予約情報取得
$shopBooking = new shopBooking($dbMaster);
$shopBooking->selectCancelData(cmIdCheck("BOOKING_ID"), "", "", "", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
$shopBooking->setPost();
if ($shopBooking->getByKey($shopBooking->getKeyValue(), "bookingConfirm")) {
	$shopBooking->saveBooking();
	//$member->saveBirth();
}

$shop = new shop($dbMaster);
$shopBookset = new shopBookset($dbMaster);

$shopAccess = new ShopAccess($dbMaster);

if ($shopBooking->getCount() > 0) {
	
	// 集合場所名をセット
	if(!empty($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MEET_PLACE"))){
		$shopAccess->select($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MEET_PLACE"));
	}
	$shop_access_name = $shopAccess->getByKey($shopAccess->getKeyValue(), "SHOP_ACCESS_NAME");
	
	if($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")){
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "COMPANY_ID"));
	}
	
	$collection->setByKey($collection->getKeyValue(), "BOOKING_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ID"));


	// ショップ情報取得
	$shop->selectList($collection);
	$shopBookset->select($shopBooking->getByKey($shopBooking->getKeyValue(), "COMPANY_ID"));

	$shopBookingcont = new shopBookingcont($dbMaster);
	$shopBookingcont->selectList($collection);
	$shopBookingcont->setPost();
	$roomid = $shopBooking->getByKey($shopBooking->getKeyValue(), "ROOM_ID");
	$shopBookingcont->setByKey($shopBookingcont->getKeyValue(),"ROOM_ID", $roomid);

	if ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_LINK") == "") {
		// プラン情報取得
		$shopPlan = new shopPlan($dbMaster);
		$shopPlan->select($shopBooking->getByKey($shopBooking->getKeyValue(), "SHOPPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
		
		// 予約キャンセル締切日セット
		$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOPPLAN_CAN_DAY", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_DAY"));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOPPLAN_CAN_HOUR", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_HOUR"));
		$shopBooking->setByKey($shopBooking->getKeyValue(), "SHOPPLAN_CAN_MIN", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_MIN"));
		
		// キャンセル確認
		if ($shopBooking->getByKey($shopBooking->getKeyValue(), "cancelconfirm")) {
			$shopBooking->checkCancelConfirm();
			
		// キャンセル実行
		} elseif ($shopBooking->getByKey($shopBooking->getKeyValue(), "cancel")) {
			$shopBooking->checkCancelConfirm();

			if ( $shopBooking->getErrorCount() <= 0 ) {
				if (!$shopBooking->cancel()) {
					$shopBookingcont->setErrorFirst("予約のキャンセルに失敗しました。");
					$shopBookingcont->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
				}
			}
		}

	}

}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_detail.php"); ?>
<title>予約申し込み履歴 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->
<!-- InstanceEndEditable -->

<!--content-->
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="mypoint">

		<!--日付・人数から検索-->
		<section class="box">
			<div class="inner">
			<div id="hmenu_cn" class="radius10">
				<menu class="mypge-menu">
					<li><a href="<?php print URL_PUBLIC?>mypage.html">マイページトップ</a></li>
					<?php if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_STATUS") != 4): ?>
						<li><a href="<?php print URL_PUBLIC?>mybasic.html">会員基本情報確認・変更</a></li>
					<?php endif; ?>
					<li><a href="<?php print URL_PUBLIC?>myreserve.html">予約の確認</a></li>
					<?php if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_STATUS") != 4): ?>
					<!--<li><a href="<?php print URL_PUBLIC?>mycoupon.html">購入したクーポン</a></li>-->
					<!--<li><a href="<?php print URL_PUBLIC?>mypoint.html">ポイント履歴</a></li>-->
						<li><a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></li>
					<?php endif; ?>
				</menu>
				<div class="bt-logout_cn">
					<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					 <p class="bt-td"><?=$inputs->submit("","logout","ログアウト", "circle")?></p>
						</form>
					</div>
				</div>

			<h2 class="title">予約申し込み履歴</h2>

			<?php // print_r($shopBooking);?>
			<?php if ($shopBooking->getErrorCount() > 0) { ?>
				<?php echo  create_error_caption($shopBooking->getError()); ?>
				<br />
			<?php } ?>

			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($shopBooking->getByKey($shopBooking->getKeyValue(), "cancel") and $shopBooking->getErrorCount() <= 0) {
						print "キャンセルが完了しました。";
					}
					elseif ($shopBooking->getByKey($shopBooking->getKeyValue(), "cancel") and $shopBooking->getErrorCount() > 0) {
						require("includes/box/hotel/listCancelConfirm.php");
					}
					elseif ($shopBooking->getByKey($shopBooking->getKeyValue(), "cancelconfirm") && $shopBooking->getErrorCount() <= 0) {
						require("includes/box/hotel/listCancelConfirm.php");
					}
					else {
						require("includes/box/hotel/listCancel.php");
					}
	
				?>
				<?php print $inputs->hidden("BOOKING_ID", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ID"));?>
			</form>
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
