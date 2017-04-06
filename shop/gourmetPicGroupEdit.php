<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPicGroup.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$gourmetPicGroup = new gourmetPicGroup($dbMaster);
$gourmetPicGroup->select(cmIdCheck(constant("gourmetPicGroup::keyName")), "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$gourmetPicGroup->setByKey($gourmetPicGroup->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$gourmetPicGroup->setPost();
$gourmetPicGroup->check();

if ($gourmetPicGroup->getByKey($gourmetPicGroup->getKeyValue(), "regist") and $gourmetPicGroup->getErrorCount() <= 0) {
	if (!$gourmetPicGroup->save()) {
		$gourmetPicGroup->setErrorFirst("写真グループの作成に失敗しました。");
		$gourmetPicGroup->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($gourmetPicGroup->getByKey($gourmetPicGroup->getKeyValue(), "delete") and $gourmetPicGroup->getErrorCount() <= 0) {
	if (!$gourmetPicGroup->delete()) {
		$gourmetPicGroup->setErrorFirst("写真グループの削除に失敗しました。");
		$gourmetPicGroup->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>写真グループ編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($gourmetPicGroup->getByKey($gourmetPicGroup->getKeyValue(), "regist") or $gourmetPicGroup->getByKey($gourmetPicGroup->getKeyValue(), "delete")) and $gourmetPicGroup->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>写真グループ</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($gourmetPicGroup->getByKey($gourmetPicGroup->getKeyValue(), "regist") and $gourmetPicGroup->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/gourmet/inputPicGroup.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>