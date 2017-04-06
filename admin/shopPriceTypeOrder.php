<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$shop = new shop($dbMaster);
$shop->select(cmIdCheck(constant("shop::keyName")));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmIdCheck(constant("shop::keyName")));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelPriceType = new hotelPriceType($dbMaster);
$hotelPriceType->select("", "1", cmIdCheck(constant("shop::keyName")));
$hotelPriceType->setPost();

if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") and $hotelPriceType->getErrorCount() <= 0) {
	if (!$hotelPriceType->saveOrder()) {
		$hotelPriceType->setErrorFirst("部屋タイプの並び替えに失敗しました。");
		$hotelPriceType->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<?php if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") and $hotelPriceType->getErrorCount() <= 0) {?>
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
			<?php if ($hotelPriceType->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") and $hotelPriceType->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/orderPriceType.php");
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