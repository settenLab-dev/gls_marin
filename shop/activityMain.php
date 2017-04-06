<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/activity.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$activity = new activity($dbMaster);
$activity->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$activity->setPost();
$activity->setByKey($activity->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$activity->checkMain();

if ($activity->getByKey($activity->getKeyValue(), "regist") and $activity->getErrorCount() <= 0) {
	if (!$activity->save()) {
		$activity->setErrorFirst("店舗メイン情報の保存に失敗しました。");
		$activity->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
	//	契約満了
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
}
else {
	$inputs = new inputs();
}
}
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>アクティビティ情報｜<?=SITE_SLAKER_NAME?></title>
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
				<?php require("includes/box/common/menuActivity.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">

					<h2>店舗のメイン情報</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_ACT") != 1) {
						//	アクティビティ情報設定可否
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>アクティビティ情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							if ($activity->getByKey($activity->getKeyValue(), "regist") and $activity->getErrorCount() <= 0) {
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
								require("includes/box/activity/inputMain.php");
							}
							else {
								require("includes/box/activity/inputMain.php");
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