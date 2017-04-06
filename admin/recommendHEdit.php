<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/recommendH.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);

$hotel = new hotel($dbMaster);
$hotel->selectList($collection);

$recommendH = new recommendH($dbMaster);
$recommendH->select(cmIdCheck(constant("recommendH::keyName")));
$recommendH->setByKey($recommendH->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$recommendH->setPost();
$recommendH->check();

if ($recommendH->getByKey($recommendH->getKeyValue(), "regist") and $recommendH->getErrorCount() <= 0) {
	if (!$recommendH->save()) {
		$recommendH->setErrorFirst("お勧め情報の作成に失敗しました。");
		$recommendH->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($recommendH->getByKey($recommendH->getKeyValue(), "delete")) {
	if (!$recommendH->delete()) {
		$recommendH->setErrorFirst("お勧め情報の削除に失敗しました。");
		$recommendH->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>お勧め(ホテル) 編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($recommendH->getByKey($recommendH->getKeyValue(), "regist")  and $recommendH->getErrorCount() <= 0) {?>
	window.close();
	<?php }elseif ($recommendH->getByKey($recommendH->getKeyValue(), "delete")) {?>
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
				<h2>お勧め(ホテル) 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($recommendH->getByKey($recommendH->getKeyValue(), "regist") and $recommendH->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/recommendH/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>