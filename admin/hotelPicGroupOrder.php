<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPicGroup.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelPicGroup = new hotelPicGroup($dbMaster);
$hotelPicGroup->select("", "1", cmIdCheck(constant("hotel::keyName")));
$hotelPicGroup->setPost();

if ($hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "regist") and $hotelPicGroup->getErrorCount() <= 0) {
	if (!$hotelPicGroup->saveOrder()) {
		$hotelPicGroup->setErrorFirst("写真グループの並び替えに失敗しました。");
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
	<title>写真グループ 並び替え｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "regist") and $hotelPicGroup->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>写真グループ 並び替え</h2>
		<p>並び替えるデータをドラッグして移動して下さい。</p>
		<div id="contentsPop" class="circle">
			<?php if ($hotelPicGroup->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($hotelPicGroup->getByKey($hotelPicGroup->getKeyValue(), "regist") and $hotelPicGroup->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/orderPicGroup.php");
					}
				?>
			</form>
			<?php } else {?>
			<p>データがみつかりません。</p>
			<?php }?>
		</div>
		<br />
	</div>
</body>
</html>