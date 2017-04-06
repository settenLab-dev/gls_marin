<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponShop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPic.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$couponShop = new couponShop($dbMaster);
$couponShop->select(cmIdCheck(constant("couponShop::keyName")), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponShop->setByKey($couponShop->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponShop->setPost();
$couponShop->check();

$couponPic = new couponPic($dbMaster);
$couponPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($couponShop->getByKey($couponShop->getKeyValue(), "regist") and $couponShop->getErrorCount() <= 0) {
	if (!$couponShop->save()) {
		$couponShop->setErrorFirst("ホテル画像の作成に失敗しました。");
		$couponShop->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($couponShop->getByKey($couponShop->getKeyValue(), "delete") and $couponShop->getErrorCount() <= 0) {
	if (!$couponShop->delete()) {
		$couponShop->setErrorFirst("ホテル画像の削除に失敗しました。");
		$couponShop->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>店舗の登録｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($couponShop->getByKey($couponShop->getKeyValue(), "regist") or $couponShop->getByKey($couponShop->getKeyValue(), "delete")) and $couponShop->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>

	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:550,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		}
	};

	function unloadcallback() {
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>店舗情報の編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($couponShop->getByKey($couponShop->getKeyValue(), "regist") and $couponShop->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/coupon/inputShop.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>