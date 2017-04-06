<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
// require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/linkCount.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');


$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setPost();

$hotel = new hotel($dbMaster);
$hotel->selectList($collection);

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "BOOKING_ID", cmIdCheck("BOOKING_ID"));
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelBooking = new hotelBooking($dbMaster);
$hotelBooking->selectCancelData(cmIdCheck("BOOKING_ID"), "", "", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// print_r($hotelBooking->getCollection());

$hotelBookingcont = new hotelBookingcont($dbMaster);
$hotelBookingcont->selectList($collection);
$hotelBookingcont->setPost();




if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_LINK") == "") {

	if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm")) {

		$hotelBookingcont->checkCancelConfirm();

	}
	elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel")) {

		$hotelBookingcont->checkCancel();

		if ( $hotelBookingcont->getErrorCount() <= 0 ) {
			if (!$hotelBookingcont->cancel($hotelBooking, $hotelBookset)) {
				$hotelBookingcont->setErrorFirst("予約のキャンセルに失敗しました。");
				$hotelBookingcont->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
			}
		}

	}
	else {
	}

}
else {

	$hotelCode = $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_LINK");
	$roomCode = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "ROOM_ID");
	$planCode = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ID");
	$bookingCode = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_BOOKING_CODE");
	$bookingDate = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DATE");

	$hotelPlan = new tlPlan($dbMaster);
	$hotelPlan->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_LINK"), $planCode, $roomCode);

	if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm")) {
	}
	elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel")) {

		$linkCount = new linkCount($dbMaster);
		if (!$linkCount->save()) {
			return false;
		}
		$linkCount->getByKey($linkCount->getKeyValue(), "ID");

		require_once('includes/link/deleteBooking.php');
		$dataarCancel = $ar;

		if ($dataarCancel["deleteBookingResult"]["commonResponse"]["resultCode"] == "True") {
					if ( $hotelBooking->getErrorCount() <= 0 ) {
						if (!$hotelBooking->cancelBookingLink()) {
							$hotelBooking->setErrorFirst("予約のキャンセルに失敗しました。");
							$hotelBooking->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
						}
					}
		}
		else {
			$msgAr = $dataarCancel["deleteBookingResult"]["commonResponse"]["errorInfos"];
			$hotelBookingcont->setErrorFirst($msgAr["errorMsg"]);
// 			if (count($msgAr) > 0) {
// 				foreach ($msgAr as $m) {
// 					$hotelBookingcont->setErrorFirst($m["errorMsg"]);
// 				}
// 			}
		}

	}
	else {
	}

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
	<?php if (($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") or $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "delete")) and $hotelBookingcont->getErrorCount() <= 0) {?>
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

			<?php if ($hotelBookingcont->getErrorCount() > 0) {?>
			<?php print create_error_caption($hotelBookingcont->getError())?>
			<br />
			<?php }?>

			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">

			<?php
			if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_LINK") == "") {
				if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() <= 0) {
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() > 0) {
					require("includes/box/actreserv/listCancelConfirm.php");
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm") and $hotelBookingcont->getErrorCount() <= 0) {
					require("includes/box/actreserv/listCancelConfirm.php");
				}
				else {
					require("includes/box/actreserv/listCancel.php");
				}

			}
			else {
				if ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() <= 0) {
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancel") and $hotelBookingcont->getErrorCount() > 0) {
					require("includes/box/actreserv/listCancelConfirm.php");
				}
				elseif ($hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelconfirm") and $hotelBookingcont->getErrorCount() <= 0) {
					require("includes/box/actreserv/listCancelConfirmLink.php");
				}
				else {
					require("includes/box/actreserv/listCancelLink.php");
				}
			}
			?>

			</form>
			<br />

			<?php /*
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "regist") and $hotelPlan->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/actreserv/inputBooking.php");
					}
				?>
			</form>
			*/?>
		</div>
		<br />
	</div>
</body>
</html>