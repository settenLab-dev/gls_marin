<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mTag.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mTag = new mTag($dbMaster);
$mTag->select(cmIdCheck(constant("mTag::keyName")));
$mTag->setByKey($mTag->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$mTag->setPost();
$mTag->check();

if ($mTag->getByKey($mTag->getKeyValue(), "regist") and $mTag->getErrorCount() <= 0) {
	if (!$mTag->save()) {
		$mTag->setErrorFirst("タグの作成に失敗しました。");
		$mTag->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($mTag->getByKey($mTag->getKeyValue(), "delete") and $mTag->getErrorCount() <= 0) {
	if (!$mTag->delete()) {
		$mTag->setErrorFirst("タグの削除に失敗しました。");
		$mTag->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>タグ編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($mTag->getByKey($mTag->getKeyValue(), "regist") or $mTag->getByKey($mTag->getKeyValue(), "delete")) and $mTag->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>タグ登録</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($mTag->getByKey($mTag->getKeyValue(), "regist") and $mTag->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/mTag/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>