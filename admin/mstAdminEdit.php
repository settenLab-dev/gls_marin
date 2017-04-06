<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');

$dbMaster = new dbMaster();

$collection = new collection($db);
$collection->setPost();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$admin = new admin($dbMaster);
$admin->select(cmIdCheck(constant("admin::keyName")));

$admin->setPost();
$admin->check();
$admin->setByKey($admin->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));

if ($admin->getByKey($admin->getKeyValue(), "regist") and $admin->getErrorCount() <= 0) {
	$dbMaster->begin();
	if (!$admin->save()) {
		$admin->setErrorFirst("管理者の作成に失敗しました。");
		$admin->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
	else {
			$dbMaster->commit();
	}
}
elseif ($admin->getByKey($admin->getKeyValue(), "delete") and $admin->getErrorCount() <= 0) {
	if (!$admin->delete()) {
		$admin->setErrorFirst("管理者の削除に失敗しました。");
		$admin->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
	if ($admin->getKeyValue() > 0 and $admin->getByKey($admin->getKeyValue(), "ADMIN_LOGIN_PASSWORD") != "") {
		$admin->setByKey($admin->getKeyValue(), "ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM, $admin->getByKey($admin->getKeyValue(), "ADMIN_LOGIN_PASSWORD"));
	}
}

$inputs = new inputs();

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>管理者編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($admin->getByKey($admin->getKeyValue(), "regist") or $admin->getByKey($admin->getKeyValue(), "delete")) and $admin->getErrorCount() <= 0) {?>
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
				<h2>管理者マスタ</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($admin->getByKey($admin->getKeyValue(), "regist") and $admin->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/admin/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>