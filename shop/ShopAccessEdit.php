<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/ShopAccess.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$ShopAccess = new ShopAccess($dbMaster);
$ShopAccess->select(cmIdCheck(constant("ShopAccess::keyName")), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$ShopAccess->setPost();
$ShopAccess->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//  echo $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_BREADTH");exit;

if ($ShopAccess->getByKey($ShopAccess->getKeyValue(), "regist") and $ShopAccess->getErrorCount() <= 0) {
	if (!$ShopAccess->save()) {
		$ShopAccess->setErrorFirst("画像の作成に失敗しました。");
		$ShopAccess->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($ShopAccess->getByKey($ShopAccess->getKeyValue(), "delete") and $ShopAccess->getErrorCount() <= 0) {
	if (!$ShopAccess->delete()) {
		$ShopAccess->setErrorFirst("画像の削除に失敗しました。");
		$ShopAccess->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>集合場所の設定｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($ShopAccess->getByKey($ShopAccess->getKeyValue(), "regist") or $ShopAccess->getByKey($ShopAccess->getKeyValue(), "delete")) and $ShopAccess->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	</script>
	<script type="text/javascript">
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
		<h2>集合場所情報の編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data" id="frmSearch" name="frmSearch">
				<?php
					if ($ShopAccess->getByKey($ShopAccess->getKeyValue(), "regist") and $ShopAccess->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputShopAccess.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>