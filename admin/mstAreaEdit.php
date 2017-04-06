<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mArea.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mArea = new mArea($dbMaster);
$mArea->select(cmIdCheck(constant("mArea::keyName")));
$mArea->setByKey($mArea->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$mArea->setPost();
$mArea->check();

$mAreaTop = new mArea($dbMaster);
$mAreaTop->selectTop();
$mAreaTop->setPost();

$mAreaParent = new mArea($dbMaster);
$mAreaParent->selectParent();
$mAreaParent->setPost();



if ($mArea->getByKey($mArea->getKeyValue(), "regist") and $mArea->getErrorCount() <= 0) {
	if (!$mArea->save()) {
		$mArea->setErrorFirst("エリアの作成に失敗しました。");
		$mArea->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($mArea->getByKey($mArea->getKeyValue(), "delete") and $mArea->getErrorCount() <= 0) {
	if (!$mArea->delete()) {
		$mArea->setErrorFirst("エリアの削除に失敗しました。");
		$mArea->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>エリア編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($mArea->getByKey($mArea->getKeyValue(), "regist") or $mArea->getByKey($mArea->getKeyValue(), "delete")) and $mArea->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>エリアマスタ</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($mArea->getByKey($mArea->getKeyValue(), "regist") and $mArea->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/mArea/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>