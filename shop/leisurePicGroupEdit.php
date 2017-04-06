<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPicGroup.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelPicGroup = new hotelPicGroup($dbMaster);
$hotelPicGroup->select(cmIdCheck(constant("hotelPicGroup::keyName")), "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelPicGroup->setByKey($hotelPicGroup->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelPicGroup->setPost();
$hotelPicGroup->check();

if ($hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "regist") and $hotelPicGroup->getErrorCount() <= 0) {
	if (!$hotelPicGroup->save()) {
		$hotelPicGroup->setErrorFirst("写真グループの作成に失敗しました。");
		$hotelPicGroup->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "delete") and $hotelPicGroup->getErrorCount() <= 0) {
	if (!$hotelPicGroup->delete()) {
		$hotelPicGroup->setErrorFirst("写真グループの削除に失敗しました。");
		$hotelPicGroup->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<?php if (($hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "regist") or $hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "delete")) and $hotelPicGroup->getErrorCount() <= 0) {?>
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
					if ($hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "regist") and $hotelPicGroup->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/actreserv/inputPicGroup.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>