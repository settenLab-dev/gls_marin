<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/ShopAccess.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$ShopAccessOrigin = new ShopAccess($dbMaster);
$ShopAccessOrigin->select(cmIdCheck(constant("ShopAccess::keyName")), "1", cmIdCheck(constant("shop::keyName")));

$ShopAccess = new ShopAccess($dbMaster);
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_NAME", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_NAME"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_ADDRESS", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_ADDRESS"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_ROUTE", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_ROUTE"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGFLG", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_PARKINGFLG"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGCAP", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_PARKINGCAP"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGMONEYFLG", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_PARKINGMONEYFLG"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGMONEY", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_PARKINGMONEY"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGBOOKFLG", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_PARKINGBOOKFLG"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_ZIP", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_ZIP"));
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_TEL", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_TEL"));
for ($i=1; $i<=4; $i++) {
	$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PIC".$i, $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_PIC".$i));
	$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PIC_DISCRIPTION".$i, $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_PIC_DISCRIPTION".$i));
}
$ShopAccess->setByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_STATUS", $ShopAccessOrigin->getByKey($ShopAccessOrigin->getKeyValue(), "SHOP_ACCESS_STATUS"));
$ShopAccess->setPost();
$ShopAccess->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", cmIdCheck(constant("shop::keyName")));

if ($ShopAccess->getByKey($ShopAccess->getKeyValue(), "regist") and $ShopAccess->getErrorCount() <= 0) {
	if (!$ShopAccess->save()) {
		$ShopAccess->setErrorFirst("集合場所の登録に失敗しました。");
		$ShopAccess->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($ShopAccess->getByKey($ShopAccess->getKeyValue(), "delete") and $ShopAccess->getErrorCount() <= 0) {
	if (!$ShopAccess->delete()) {
		$ShopAccess->setErrorFirst("集合場所の削除に失敗しました。");
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
	<title>集合場所のコピー｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($ShopAccess->getByKey($ShopAccess->getKeyValue(), "regist") or $ShopAccess->getByKey($ShopAccess->getKeyValue(), "delete")) and $ShopAccess->getErrorCount() <= 0) {?>
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
		<h2>集合場所コピー 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
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