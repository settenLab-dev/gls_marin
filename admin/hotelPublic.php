<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();


$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setPost();


$hotel = new hotel($dbMaster);
$hotel->select(cmIdCheck(constant("hotel::keyName")));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmIdCheck(constant("hotel::keyName")));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelPay = new hotelPay($dbMaster);
$hotelPlanTarget = new hotelPlan($dbMaster);

if ($_POST) {
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("hotel::keyName")));
	$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));

	//	料金設定検索
	$hotelPay->selectList($collection);

	$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), "1,2", cmIdCheck(constant("hotel::keyName")));
}

if ($collection->getByKey($collection->getKeyValue(), "regist")) {

	if ($hotelPay->getCount() > 0) {
		if (!$hotelPlanTarget->statusPublic()) {
			$hotelPlanTarget->setErrorFirst("プランの公開に失敗しました。");
			$hotelPlanTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
		$hotelPlanTarget->setErrorFirst("料金設定が行われていません。");
		$hotelPlanTarget->setErrorFirst("プラン設定から料金の設定を行ってください。");
	}

}
elseif ($collection->getByKey($collection->getKeyValue(), "disabled")) {

	if ($hotelPay->getCount() > 0) {
		if (!$hotelPlanTarget->statusDisabled()) {
			$hotelPlanTarget->setErrorFirst("プランの非公開に失敗しました。");
			$hotelPlanTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
		$hotelPlanTarget->setErrorFirst("料金設定が行われていません。");
		$hotelPlanTarget->setErrorFirst("プラン設定から料金の設定を行ってください。");
	}
}

$hotelPlan = new hotelPlan($dbMaster);
$hotelPlan->select("", "1,2", cmIdCheck(constant("hotel::keyName")));

if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") == 3) {
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
	<div id="containerPop">
				<?php require("includes/box/common/menuHotel.php");?>


				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>ホテル公開設定</h2>

						<?php
							require("includes/box/hotel/listPublic.php");
						?>

	</div>
</body>
</html>