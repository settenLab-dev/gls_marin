<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopPlanOrigin = new shopPlan($dbMaster);
$shopPlanOrigin->select(cmIdCheck(constant("shopPlan::keyName")), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopPlan = new shopPlan($dbMaster);
// $shopPlan->select(cmIdCheck(constant("shopPlan::keyName")), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($shopPlanOrigin->getCount() > 0) {
	foreach ($shopPlanOrigin->getCollectionByKey($shopPlanOrigin->getKeyValue()) as $k=>$v) {
		if ($k == "HOTELPLAN_ID") continue;
		$shopPlan->setByKey($shopPlan->getKeyValue(), $k, $v);
	}
}
$shopPlan->setByKey($shopPlan->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopPlan->setPost();
$shopPlan->check();

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

// if ($shopPlan->getCount() == 1) {
// 	$hotelType = new hotelType($dbMaster);
// 	$hotelType->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), $shopPlan->getKeyValue());
// }

if ($shopPlan->getByKey($shopPlan->getKeyValue(), "regist") and $shopPlan->getErrorCount() <= 0) {
	if (!$shopPlan->save()) {
		$shopPlan->setErrorFirst("プランの作成に失敗しました。");
		$shopPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($shopPlan->getByKey($shopPlan->getKeyValue(), "delete") and $shopPlan->getErrorCount() <= 0) {
	if (!$shopPlan->delete()) {
		$shopPlan->setErrorFirst("プランの削除に失敗しました。");
		$shopPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>プラン｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($shopPlan->getByKey($shopPlan->getKeyValue(), "regist") or $shopPlan->getByKey($shopPlan->getKeyValue(), "delete")) and $shopPlan->getErrorCount() <= 0) {?>
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
		<h2>プラン 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "regist") and $shopPlan->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputPlan.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>