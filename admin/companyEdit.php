<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mContract.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$mContract = new mContract($dbMaster);
$mContract->selectList($collection);
// print_r($mContract->getCollection());

$company = new company($dbMaster);
$company->select(cmIdCheck(constant("company::keyName")));
$company->setByKey($company->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$company->setPost();
$company->check();

if ($company->getByKey($company->getKeyValue(), "regist") and $company->getErrorCount() <= 0) {
	if (!$company->save()) {
		$company->setErrorFirst("アカウントの作成に失敗しました。");
		$company->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($company->getByKey($company->getKeyValue(), "delete") and $company->getErrorCount() <= 0) {
	if (!$company->delete()) {
		$company->setErrorFirst("アカウントの削除に失敗しました。");
		$company->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
	if ($company->getByKey($company->getKeyValue(), "COMPANY_LOGIN_PASSWORD") != "") {
		$company->setByKey($company->getKeyValue(), "COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM, $company->getByKey($company->getKeyValue(), "COMPANY_LOGIN_PASSWORD"));
	}
}

$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>アカウント編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($company->getByKey($company->getKeyValue(), "regist") or $company->getByKey($company->getKeyValue(), "delete")) and $company->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
</head>
<body id="">
<?php /*
	<div id="headerPop">
		<h1><img src="<?=URL_SLAKER_COMMON?>assets/header/logo.png" alt="<?=SITE_NAME?>" width="106" height="29" /></h1>
	</div>
*/?>
	<div id="containerPop">
				<h2>アカウント</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($company->getByKey($company->getKeyValue(), "regist") and $company->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/company/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>