<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/groumet.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/recommendG.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);

$groumet = new groumet($dbMaster);
$groumet->selectList($collection);

$recommendG = new recommendG($dbMaster);
$recommendG->select(cmIdCheck(constant("recommendG::keyName")));
$recommendG->setByKey($recommendG->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$recommendG->setPost();
$recommendG->check();

if ($recommendG->getByKey($recommendG->getKeyValue(), "regist") and $recommendG->getErrorCount() <= 0) {
	if (!$recommendG->save()) {
		$recommendG->setErrorFirst("お勧め情報の作成に失敗しました。");
		$recommendG->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($recommendG->getByKey($recommendG->getKeyValue(), "delete")) {
	if (!$recommendG->delete()) {
		$recommendG->setErrorFirst("お勧め情報の削除に失敗しました。");
		$recommendG->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>お勧め(グルメ) 編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($recommendG->getByKey($recommendG->getKeyValue(), "regist")  and $recommendG->getErrorCount() <= 0) {?>
	window.close();
	<?php }elseif ($recommendG->getByKey($recommendG->getKeyValue(), "delete")) {?>
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
				<h2>お勧め(グルメ)</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($recommendG->getByKey($recommendG->getKeyValue(), "regist") and $recommendG->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/recommendG/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>