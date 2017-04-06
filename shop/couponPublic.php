<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponShop.php');

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


$coupon = new coupon($dbMaster);
$coupon->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$couponBookset = new couponBookset($dbMaster);
$couponBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponBookset->setPost();
$couponBookset->check();

//$couponPay = new kobPay($dbMaster);
$couponPlanTarget = new couponPlan($dbMaster);

if ($_POST) {
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	$collection->setByKey($collection->getKeyValue(), "COUPONPLAN_ID", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"));

	//	料金設定検索
//	$couponPay->selectList($collection);

	$couponPlanTarget->select($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
}

//print_r($couponPlanTarget);
if ($collection->getByKey($collection->getKeyValue(), "regist")) {

	if ($couponPlanTarget->getCount() > 0) {
		if (!$couponPlanTarget->statusPublic()) {
			$couponPlanTarget->setErrorFirst("プランの公開に失敗しました。");
			$couponPlanTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
		$couponPlanTarget->setErrorFirst("料金設定が行われていません。");
		$couponPlanTarget->setErrorFirst("プラン設定から料金の設定を行ってください。");
	}

}
elseif ($collection->getByKey($collection->getKeyValue(), "disabled")) {

	if ($couponPlanTarget->getCount() > 0) {
		if (!$couponPlanTarget->statusDisabled()) {
			$couponPlanTarget->setErrorFirst("プランの非公開に失敗しました。");
			$couponPlanTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
		$couponPlanTarget->setErrorFirst("料金設定が行われていません。");
		$couponPlanTarget->setErrorFirst("プラン設定から料金の設定を行ってください。");
	}
}
//print_r($collection);
$couponPlan = new couponPlan($dbMaster);
$couponPlan->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

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
	<title>クーポン情報公開設定｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
	<script type="text/javascript">
	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:750,
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
	<div id="container">
		<?php
			require("includes/box/common/header.php");
		?>
		<div id="contents">
			<div id="contentsData" class="circle">
				<?php require("includes/box/common/mainMenu.php");?>
				<?php require("includes/box/common/menuCoupon.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">



				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>クーポン情報公開設定</h2>

						<?php
							require("includes/box/coupon/listPublic.php");
						?>

				</div>
				<br />

			</div>
			<br class="clearfix" />

			</div>
		</div>
		<?php require("includes/box/common/footer.php");?>
	</div>
</body>
</html>