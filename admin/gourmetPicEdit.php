<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmet.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPicGroup.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$gourmetPic = new gourmetPic($dbMaster);
$gourmetPic->select(cmIdCheck(constant("gourmetPic::keyName")), "1,2", cmKeyCheck(constant("gourmet::keyName")));
$gourmetPic->setByKey($gourmetPic->getKeyValue(), "COMPANY_ID", cmKeyCheck(constant("gourmet::keyName")));
$gourmetPic->setPost();
$gourmetPic->check();

$gourmetPicGroup = new gourmetPicGroup($dbMaster);
$gourmetPicGroup->select("", "1", cmIdCheck(constant("gourmet::keyName")));

if ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "regist") and $gourmetPic->getErrorCount() <= 0) {
	if (!$gourmetPic->save()) {
		$gourmetPic->setErrorFirst("ホテル画像の作成に失敗しました。");
		$gourmetPic->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "delete") and $gourmetPic->getErrorCount() <= 0) {
	if (!$gourmetPic->delete()) {
		$gourmetPic->setErrorFirst("ホテル画像の削除に失敗しました。");
		$gourmetPic->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<?php if (($gourmetPic->getByKey($gourmetPic->getKeyValue(), "regist") or $gourmetPic->getByKey($gourmetPic->getKeyValue(), "delete")) and $gourmetPic->getErrorCount() <= 0) {?>
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
					if ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "regist") and $gourmetPic->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/gourmet/inputPic.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>