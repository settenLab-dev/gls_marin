<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setPost();

$couponPlan = new couponPlan($dbMaster);
$couponPlan->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponPlan->setByKey($couponPlan->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponPlan->setPost();


if ($couponPlan->getByKey($couponPlan->getKeyValue(), "regist") and $couponPlan->getErrorCount() <= 0) {
	if (!$couponPlan->saveOrder()) {
		$couponPlan->setErrorFirst("プランの並び替えに失敗しました。");
		$couponPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}


$inputs = new inputs();
$inputsOnly = new inputs(true);
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>プラン 並び替え｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($couponPlan->getByKey($couponPlan->getKeyValue(), "regist") and $couponPlan->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>求人情報 並び替え</h2>
		<p>並び替えるデータをドラッグして移動して下さい。</p>
		<div id="contentsPop" class="circle">

			<?php if ($couponPlan->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($couponPlan->getByKey($couponPlan->getKeyValue(), "regist") and $couponPlan->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/coupon/orderPlan.php");
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