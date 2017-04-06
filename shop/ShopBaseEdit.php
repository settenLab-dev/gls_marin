<?php
require_once('includes/applicationInc.php');
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

$hotelShopBase = new hotelShopBase($dbMaster);
$hotelShopBase->select(cmIdCheck(constant("hotelShopBase::keyName")), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelShopBase->setByKey($hotelShopBase->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelShopBase->setPost();
$hotelShopBase->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//  echo $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_BREADTH");exit;

if ($hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "regist") and $hotelShopBase->getErrorCount() <= 0) {
	if (!$hotelShopBase->save()) {
		$hotelShopBase->setErrorFirst("画像の作成に失敗しました。");
		$hotelShopBase->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "delete") and $hotelShopBase->getErrorCount() <= 0) {
	if (!$hotelShopBase->delete()) {
		$hotelShopBase->setErrorFirst("画像の削除に失敗しました。");
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
	<title>支店登録｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "regist") or $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "delete")) and $hotelShopBase->getErrorCount() <= 0) {?>
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
		<h2>支店情報 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data" id="frmSearch" name="frmSearch">
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