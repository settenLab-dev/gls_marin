<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotel = new hotel($dbMaster);
$hotel->select(cmKeyCheck(constant("hotel::keyName")));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmKeyCheck(constant("hotel::keyName")));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", cmKeyCheck(constant("hotel::keyName")));
$hotelRoom->setPost();

if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") and $hotelRoom->getErrorCount() <= 0) {
	if (!$hotelRoom->saveOrder()) {
		$hotelRoom->setErrorFirst("部屋タイプの並び替えに失敗しました。");
		$hotelRoom->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>部屋タイプ 並び替え｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") and $hotelRoom->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>部屋タイプ 並び替え</h2>
		<p>並び替えるデータをドラッグして移動して下さい。</p>
		<div id="contentsPop" class="circle">
			<?php if ($hotelRoom->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") and $hotelRoom->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/orderRoom.php");
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