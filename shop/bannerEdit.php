<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mBannerplace.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mBannerplace = new mBannerplace($dbMaster);
$mBannerplace->select(cmKeyCheck(constant("banner::keyName")), 1);

$banner = new banner($dbMaster);
$banner->select(cmIdCheck(constant("banner::keyName")), "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$banner->setByKey($banner->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$banner->setPost();
$banner->check($mBannerplace);

if ($banner->getByKey($banner->getKeyValue(), "regist") and $banner->getErrorCount() <= 0) {
	if (!$banner->save()) {
		$banner->setErrorFirst("広告バナーの作成に失敗しました。");
		$banner->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($banner->getByKey($banner->getKeyValue(), "delete") and $banner->getErrorCount() <= 0) {
	if (!$banner->delete()) {
		$banner->setErrorFirst("広告バナーの削除に失敗しました。");
		$banner->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$inputs = new inputs();

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>広告バナー編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($banner->getByKey($banner->getKeyValue(), "regist") or $banner->getByKey($banner->getKeyValue(), "delete")) and $banner->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>広告バナー</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
				<?php
					if ($banner->getByKey($banner->getKeyValue(), "regist") and $banner->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/banner/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>