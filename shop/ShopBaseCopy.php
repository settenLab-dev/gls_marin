<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelShopBase.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelShopBaseOrigin = new hotelShopBase($dbMaster);
$hotelShopBaseOrigin->select(cmIdCheck(constant("hotelShopBase::keyName")), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelShopBase = new hotelShopBase($dbMaster);
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_NAME", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_NAME"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_DISCRITION", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_DISCRITION"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_CAPACITY_FROM", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_CAPACITY_FROM"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_CAPACITY_TO", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_CAPACITY_TO"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_TYPE", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_TYPE"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_FEATURE_LIST", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_FEATURE_LIST"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_FEATURE_LIST2", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_FEATURE_LIST2"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_FEATURE_LIST3", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_FEATURE_LIST3"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PET_FLG", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_PET_FLG"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PET_LIST", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_PET_LIST"));
for ($i=1; $i<=4; $i++) {
	$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PIC".$i, $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_PIC".$i));
	$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PIC_DISCRIPTION".$i, $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_PIC_DISCRIPTION".$i));
}
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_STATUS", $hotelShopBaseOrigin->getByKey($hotelShopBaseOrigin->getKeyValue(), "SHOP_BASE_STATUS"));
$hotelShopBase->setPost();
$hotelShopBase->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "regist") and $hotelShopBase->getErrorCount() <= 0) {
	if (!$hotelShopBase->save()) {
		$hotelShopBase->setErrorFirst("ホテル画像の作成に失敗しました。");
		$hotelShopBase->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "delete") and $hotelShopBase->getErrorCount() <= 0) {
	if (!$hotelShopBase->delete()) {
		$hotelShopBase->setErrorFirst("ホテル画像の削除に失敗しました。");
		$hotelShopBase->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>ホテル部屋タイプ｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "regist") or $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "delete")) and $hotelShopBase->getErrorCount() <= 0) {?>
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
		<h2>ホテル部屋タイプ 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "regist") and $hotelShopBase->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputShopBase.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>