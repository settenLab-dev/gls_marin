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

$couponShopOrigin = new couponShop($dbMaster);
$couponShopOrigin->select(cmIdCheck(constant("couponShop::keyName")), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$couponShop = new couponShop($dbMaster);
$couponShop->setByKey($couponShop->getKeyValue(), "COMPANY_ID", cmKeyCheck(constant("coupon::keyName")));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_NAME", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_NAME"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_DISCRITION", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_DISCRITION"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_CAPACITY_FROM", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_CAPACITY_FROM"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_CAPACITY_TO", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_CAPACITY_TO"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_TYPE", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_TYPE"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_FEATURE_LIST", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_FEATURE_LIST"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_FEATURE_LIST2", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_FEATURE_LIST2"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_FEATURE_LIST3", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_FEATURE_LIST3"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_BREADTH", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_BREADTH"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_PET_FLG", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_PET_FLG"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_PET_LIST", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_PET_LIST"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_YEAR_FROM", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_YEAR_FROM"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_MONTH_FROM", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_MONTH_FROM"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_DAY_FROM", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_DAY_FROM"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_YEAR_TO", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_YEAR_TO"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_MONTH_TO", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_MONTH_TO"));
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_DAY_TO", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_DAY_TO"));
for ($i=1; $i<=7; $i++) {
	$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_NUM".$i, $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_NUM".$i));
}
for ($i=1; $i<=4; $i++) {
	$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_PIC".$i, $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_PIC".$i));
	$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_PIC_DISCRIPTION".$i, $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_PIC_DISCRIPTION".$i));
}
$couponShop->setByKey($couponShop->getKeyValue(), "SHOP_STATUS", $couponShopOrigin->getByKey($couponShopOrigin->getKeyValue(), "SHOP_STATUS"));
$couponShop->setPost();
$couponShop->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

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
	<title>店舗登録｜<?=SITE_SLAKER_NAME?></title>
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
		<h2>店舗 編集</h2>
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