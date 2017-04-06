<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookset.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPic.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$couponBookset = new couponBookset($dbMaster);
$couponBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$couponPlanOrigin = new couponPlan($dbMaster);
$couponPlanOrigin->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), "1,2");

$couponPlan = new couponPlan($dbMaster);
// $couponPlan->select(cmIdCheck(constant("hotelPlan::keyName")), "1,2");

$couponPic = new couponPic($dbMaster);
$couponPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($couponPlanOrigin->getCount() > 0) {
	foreach ($couponPlanOrigin->getCollectionByKey($couponPlanOrigin->getKeyValue()) as $k=>$v) {
		if ($k == "COUPONPLAN_ID") continue;
		$couponPlan->setByKey($couponPlan->getKeyValue(), $k, $v);
	}
}

$couponPlan->setByKey($couponPlan->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponPlan->setPost();
$couponPlan->check();

$couponRoom = new hotelRoom($dbMaster);
$couponRoom->select("", "1", cmKeyCheck(constant("coupon::keyName")));

if ($couponPlan->getByKey($couponPlan->getKeyValue(), "regist") and $couponPlan->getErrorCount() <= 0) {
	if (!$couponPlan->save()) {
		$couponPlan->setErrorFirst("プランの作成に失敗しました。");
		$couponPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($couponPlan->getByKey($couponPlan->getKeyValue(), "delete") and $couponPlan->getErrorCount() <= 0) {
	if (!$couponPlan->delete()) {
		$couponPlan->setErrorFirst("プランの削除に失敗しました。");
		$couponPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<?php if (($couponPlan->getByKey($couponPlan->getKeyValue(), "regist") or $couponPlan->getByKey($couponPlan->getKeyValue(), "delete")) and $couponPlan->getErrorCount() <= 0) {?>
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
					if ($couponPlan->getByKey($couponPlan->getKeyValue(), "regist") and $couponPlan->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/coupon/inputPlan.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>