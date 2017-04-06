<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');

$dbMaster = new dbMaster();


$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotel = new hotel($dbMaster);
$hotel->select(cmIdCheck(constant("hotel::keyName")));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmIdCheck(constant("hotel::keyName")));
$hotelBookset->setPost();
$hotelBookset->check();

if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "regist") and $hotelBookset->getErrorCount() <= 0) {
	if (!$hotelBookset->save()) {
		$hotelBookset->setErrorFirst("ホテル予約設定の保存に失敗しました。");
		$hotelBookset->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
	if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS") != "") {
		$hotelBookset->setByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS"));
	}
	if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2") != "") {
		$hotelBookset->setByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2"));
	}
	if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3") != "") {
		$hotelBookset->setByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3"));
	}
}


if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
	$inputs = new inputs();
	$disabled = '';
}
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ホテル情報｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
	<script type="text/javascript">
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
		document.frmSearch.submit();
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body>
	<div id="containerPop">
				<?php require("includes/box/common/menuHotel.php");?>

					<h2>ホテルの予約基本設定</h2>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "regist") and $hotelBookset->getErrorCount() <= 0) {
						?>
						<script type="text/javascript">
						$().toastmessage( 'showToast', {
							inEffectDuration:500,
							text:"保存完了しました。",
							type:"success",
							sticky: false,
							position:"middle-center"
						});
						</script>
						<?php
								require("includes/box/hotel/inputBookset.php");
							}
							else {
								require("includes/box/hotel/inputBookset.php");
							}
						?>
					</form>
		</div>
</body>
</html>