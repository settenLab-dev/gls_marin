<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mContract.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mContract = new mContract($dbMaster);
$mContract->select(cmIdCheck(constant("mContract::keyName")));
$mContract->setByKey($mContract->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$mContract->setPost();
$mContract->check();

if ($mContract->getByKey($mContract->getKeyValue(), "regist") and $mContract->getErrorCount() <= 0) {
	if (!$mContract->save()) {
		$mContract->setErrorFirst("契約プランの作成に失敗しました。");
		$mContract->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($mContract->getByKey($mContract->getKeyValue(), "delete") and $mContract->getErrorCount() <= 0) {
	if (!$mContract->delete()) {
		$mContract->setErrorFirst("契約プランの削除に失敗しました。");
		$mContract->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>契約プラン編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($mContract->getByKey($mContract->getKeyValue(), "regist") or $mContract->getByKey($mContract->getKeyValue(), "delete")) and $mContract->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
<?php /*
	<div id="headerPop">
		<h1><img src="<?=URL_SLAKER_COMMON?>assets/header/logo.png" alt="<?=SITE_NAME?>" width="106" height="29" /></h1>
	</div>
*/?>
	<div id="containerPop">
				<h2>契約プランマスタ</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($mContract->getByKey($mContract->getKeyValue(), "regist") and $mContract->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/mContract/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>