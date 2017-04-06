<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/activity.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/coupon.php');

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

$coupon = new coupon($dbMaster);
$coupon->select("", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), 2);

if ($coupon->getCount() > 0) {
	foreach ($coupon->getCollection() as $da) {
		$i = $da["COUPON_ORDER"];
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_ID".$i, $da["COUPON_ID"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_NAME".$i, $da["COUPON_NAME"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_PAY".$i, $da["COUPON_PAY"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_CONTENT".$i, $da["COUPON_CONTENT"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_DATE_FROM".$i, $da["COUPON_DATE_FROM"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_DATE_TO".$i, $da["COUPON_DATE_TO"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_MEMO".$i, $da["COUPON_MEMO"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_STATUS".$i, $da["COUPON_STATUS"]);
	}
}

$coupon->setPost();
$coupon->setByKey("COMPANY_ID", "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$coupon->setByKey("COUPON_FLG_TARGET", "COUPON_FLG_TARGET", 2);
$coupon->check();

if ($coupon->getByKey($coupon->getKeyValue(), "regist") and $coupon->getErrorCount() <= 0) {
	if (!$coupon->save()) {
		$coupon->setErrorFirst("クーポン情報の保存に失敗しました。");
		$coupon->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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

					<h2>クーポン情報</h2>
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
							if ($coupon->getByKey($coupon->getKeyValue(), "regist") and $coupon->getErrorCount() <= 0) {
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
								require("includes/box/activity/inputCoupon.php");
							}
							else {
								require("includes/box/activity/inputCoupon.php");
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