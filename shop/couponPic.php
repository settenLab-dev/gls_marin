<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPicGroup.php');

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

$couponPic = new couponPic($dbMaster);
$couponPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$couponPicGroup = new couponPicGroup($dbMaster);
$couponPicGroup->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
	$inputs = new inputs();
	$disabled = '';
}
$inputsOnly = new inputs(true);
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ホテル情報｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
	<script type="text/javascript">
	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:650,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		},
		windowCallUnload2:
		{
			height:400,
			width:550,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		}
	};

	function unloadcallback() {
		document.frmSearch.submit();
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body>
	<div id="containerPop">
				<?php require("includes/box/common/menuJob.php");?>

				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>ホテルの画像設定</h2>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							require("includes/box/coupon/listPic.php");
						?>
					</form>
	</div>
</body>
</html>