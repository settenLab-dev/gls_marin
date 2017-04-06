<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponShop.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$coupon = new coupon($dbMaster);
$coupon->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$couponBookset = new couponBookset($dbMaster);
$couponBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponBookset->setPost();
$couponBookset->check();

$couponShop = new couponShop($dbMaster);
$couponShop->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponShop->setPost();

if ($couponShop->getByKey($couponShop->getKeyValue(), "regist") and $couponShop->getErrorCount() <= 0) {
	if (!$couponShop->saveOrder()) {
		$couponShop->setErrorFirst("部屋タイプの並び替えに失敗しました。");
		$couponShop->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<?php if ($couponShop->getByKey($couponShop->getKeyValue(), "regist") and $couponShop->getErrorCount() <= 0) {?>
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
			<?php if ($couponShop->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($couponShop->getByKey($couponShop->getKeyValue(), "regist") and $couponShop->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/coupon/orderShop.php");
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