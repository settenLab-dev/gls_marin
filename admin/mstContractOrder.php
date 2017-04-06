<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mContract.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mContract = new mContract($dbMaster);
$mContract->select("", "1,2");
//$mContract->setByKey($mContract->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$mContract->setPost();
//$mContract->check();

if ($mContract->getByKey($mContract->getKeyValue(), "regist") and $mContract->getErrorCount() <= 0) {
	if (!$mContract->saveOrder()) {
		$mContract->setErrorFirst("契約プランの並び替えに失敗しました。");
		$mContract->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>契約プラン並び替え｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($mContract->getByKey($mContract->getKeyValue(), "regist") and $mContract->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>契約プランマスタ 並び替え</h2>
		<p>並び替えるデータをドラッグして移動して下さい。</p>
		<div id="contentsPop" class="circle">
			<?php if ($mContract->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($mContract->getByKey($mContract->getKeyValue(), "regist") and $mContract->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/mContract/order.php");
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