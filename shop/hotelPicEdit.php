<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPicGroup.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select(cmIdCheck(constant("hotelPic::keyName")), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelPic->setByKey($hotelPic->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelPic->setPost();
$hotelPic->check();

$hotelPicGroup = new hotelPicGroup($dbMaster);
$hotelPicGroup->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($hotelPic->getByKey($hotelPic->getKeyValue(), "regist") and $hotelPic->getErrorCount() <= 0) {
	if (!$hotelPic->save()) {
		$hotelPic->setErrorFirst("ホテル画像の作成に失敗しました。");
		$hotelPic->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelPic->getByKey($hotelPic->getKeyValue(), "delete") and $hotelPic->getErrorCount() <= 0) {
	if (!$hotelPic->delete()) {
		$hotelPic->setErrorFirst("ホテル画像の削除に失敗しました。");
		$hotelPic->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>ホテル画像｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelPic->getByKey($hotelPic->getKeyValue(), "regist") or $hotelPic->getByKey($hotelPic->getKeyValue(), "delete")) and $hotelPic->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>ホテル画像 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelPic->getByKey($hotelPic->getKeyValue(), "regist") and $hotelPic->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputPic.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>