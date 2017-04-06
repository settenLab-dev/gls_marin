<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotel = new hotel($dbMaster);
$hotel->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// print_r($hotelBookset->getCollection());
$hotelBookset->setPost();
$hotelBookset->check();

if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "regist") and $hotelBookset->getErrorCount() <= 0) {
	$hotelBookset->setByKey($hotelBookset->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
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


if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
	//	契約満了
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
	$inputs = new inputs();
	$disabled = '';
}
}
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>レジャー情報｜<?=SITE_SLAKER_NAME?></title>
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
	<div id="container">
		<?php
			require("includes/box/common/header.php");
		?>
		<div id="contents">
			<div id="contentsData" class="circle">
				<?php require("includes/box/common/mainMenu.php");?>
				<?php require("includes/box/common/menuLeisure.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">

					<h2>予約基本設定</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_HOTERL") != 2) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>レジャー情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

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
								require("includes/box/actreserv/inputBookset.php");
							}
							else {
								require("includes/box/actreserv/inputBookset.php");
							}
						?>
					</form>
					<?php
					}
					?>
				</div>
				<br />

			</div>
			<div id="colRight">
				<?php require("includes/box/common/account.php");?>
			</div>
			<br class="clearfix" />

			</div>
		</div>
		<?php require("includes/box/common/footer.php");?>
	</div>
</body>
</html>