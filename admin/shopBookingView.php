<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setPost();

$shop = new shop($dbMaster);
$shop->selectList($collection);

$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "BOOKING_ID", cmIdCheck("BOOKING_ID"));
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopBooking = new shopBooking($dbMaster);
$shopBooking->selectCancelData(cmIdCheck("BOOKING_ID"), "", "", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// print_r($shopBooking->getCollection());

$shopBookingcont = new shopBookingcont($dbMaster);
$shopBookingcont->selectList($collection);
$shopBookingcont->setPost();



	if ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancelconfirm")) {

		$shopBookingcont->checkCancelConfirm();

	}
	elseif ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel")) {

		$shopBookingcont->checkCancel();

		if ( $shopBookingcont->getErrorCount() <= 0 ) {
			if (!$shopBookingcont->cancel($shopBooking, $shopBookset)) {
				$shopBookingcont->setErrorFirst("予約のキャンセルに失敗しました。");
				$shopBookingcont->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
			}
		}

	}
	else {
	}


$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>予約｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel") or $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "delete")) and $shopBookingcont->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:550,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		},
	};

	function unloadcallback() {
		//$('#check_none').val("none");
		//document.frmSearch.submit();
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});

   	function memberset(mdata) {
   	   	//alert(mdata["MEMBER_NAME1"]);
   	   	$('#BOOKING_NAME1').val(mdata["MEMBER_NAME1"]);
   	   	$('#BOOKING_NAME2').val(mdata["MEMBER_NAME2"]);
   	   	$('#BOOKING_KANA1').val(mdata["MEMBER_NAME_KANA1"]);
   	   	$('#BOOKING_KANA2').val(mdata["MEMBER_NAME_KANA2"]);
   	   	$('#BOOKING_ZIP').val(mdata["MEMBER_ZIP"]);
   	   	$('#BOOKING_PREF_ID').val(mdata["MEMBER_PREF"]);
   	   	$('#BOOKING_CITY').val(mdata["MEMBER_CITY"]);
   	   	$('#BOOKING_ADDRESS').val(mdata["MEMBER_ADDRESS"]);
   	   	$('#BOOKING_NAME2').val(mdata["MEMBER_ADDRESS"]);
   	   	$('#BOOKING_BUILD').val(mdata["MEMBER_BUILD"]);
   	   	$('#BOOKING_TEL').val(mdata["MEMBER_TEL1"]);
   	}

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
</head>
<body id="">
	<div id="containerPop">
		<h2>予約 編集</h2>
		<div id="contentsPop" class="circle">

			<?php if ($shopBookingcont->getErrorCount() > 0) {?>
			<?php print create_error_caption($shopBookingcont->getError())?>
			<br />
			<?php }?>

			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">

			<?php
				if ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel") and $shopBookingcont->getErrorCount() <= 0) {
				}
				elseif ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel") and $shopBookingcont->getErrorCount() > 0) {
					require("includes/box/hotel/listCancelConfirm.php");
				}
				elseif ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancelconfirm") and $shopBookingcont->getErrorCount() <= 0) {
					require("includes/box/hotel/listCancelConfirm.php");
				}
				else {
					require("includes/box/hotel/listCancel.php");
				}
			?>

			</form>
			<br />

		</div>
		<br />
	</div>
</body>
</html>