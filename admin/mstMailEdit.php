<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mMail.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mMail = new mMail($dbMaster);
$mMail->select(cmIdCheck(constant("mMail::keyName")));
$mMail->setByKey($mMail->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$mMail->setPost();
$mMail->check();

if ($mMail->getByKey($mMail->getKeyValue(), "regist") and $mMail->getErrorCount() <= 0) {
	if (!$mMail->save()) {
		$mMail->setErrorFirst("メールテンプレートの作成に失敗しました。");
		$mMail->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($mMail->getByKey($mMail->getKeyValue(), "delete") and $mMail->getErrorCount() <= 0) {
	if (!$mMail->delete()) {
		$mMail->setErrorFirst("メールテンプレートの削除に失敗しました。");
		$mMail->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>メールテンプレート編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($mMail->getByKey($mMail->getKeyValue(), "regist") or $mMail->getByKey($mMail->getKeyValue(), "delete")) and $mMail->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="bodyPop">
	<div id="headerPop">
		<h1><img src="<?=URL_SLAKER_COMMON?>assets/header/logo.png" alt="<?=SITE_NAME?>" width="106" height="29" /></h1>
	</div>
	<div id="containerPop">
				<h2>メールテンプレートマスタ</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($mMail->getByKey($mMail->getKeyValue(), "regist") and $mMail->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/mMail/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>