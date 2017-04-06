<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');

$dbMaster = new dbMaster();


$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$admin = new admin($dbMaster);
$admin->select($sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));


$collection = new collection($dbMaster);
$collection->setPost();


$shop = new shop($dbMaster);
$shop->select(cmIdCheck(constant("shop::keyName")));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmIdCheck(constant("shop::keyName")));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelPay = new hotelPay($dbMaster);
$shopPlanTarget = new shopPlan($dbMaster);

if ($_POST) {
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("shop::keyName")));
	$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));

	//	料金設定検索
	$hotelPay->selectList($collection);

	$shopPlanTarget->select($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"), "1,2", cmIdCheck(constant("shop::keyName")));
}

if ($collection->getByKey($collection->getKeyValue(), "regist")) {

	if ($hotelPay->getCount() > 0) {
		if (!$shopPlanTarget->statusPublic()) {
			$shopPlanTarget->setErrorFirst("プランの公開に失敗しました。");
			$shopPlanTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
		$shopPlanTarget->setErrorFirst("料金設定が行われていません。");
		$shopPlanTarget->setErrorFirst("プラン設定から料金の設定を行ってください。");
	}

}
elseif ($collection->getByKey($collection->getKeyValue(), "disabled")) {

	if ($hotelPay->getCount() > 0) {
		if (!$shopPlanTarget->statusDisabled()) {
			$shopPlanTarget->setErrorFirst("プランの非公開に失敗しました。");
			$shopPlanTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
		$shopPlanTarget->setErrorFirst("料金設定が行われていません。");
		$shopPlanTarget->setErrorFirst("プラン設定から料金の設定を行ってください。");
	}
}

$shopPlan = new shopPlan($dbMaster);
$shopPlan->select("", "1,2", cmIdCheck(constant("shop::keyName")));


	$inputs = new inputs();
	$disabled = '';

$inputsOnly = new inputs(true);
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>プラン公開設定｜<?=SITE_SLAKER_NAME?></title>
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
		},
		windowCallUnload3:
		{
			height:660,
			width:800,
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
				<?php require("includes/box/common/menuHotel.php");?>


			<div id="colLeft">
				<div class="manageMenu circle">
				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>プラン公開設定</h2>

						<?php
							require("includes/box/hotel/listPublic.php");
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