<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
// require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmKeyCheck(constant("hotel::keyName")));

$hotelPlan = new hotelPlan($dbMaster);
$hotelPlan->select(cmIdCheck(constant("hotelPlan::keyName")), "1,2");
$hotelPlan->setByKey($hotelPlan->getKeyValue(), "COMPANY_ID", cmKeyCheck(constant("hotel::keyName")));
$hotelPlan->setPost();
$hotelPlan->check();

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", cmKeyCheck(constant("hotel::keyName")));

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", cmKeyCheck(constant("hotel::keyName")));

if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "regist") and $hotelPlan->getErrorCount() <= 0) {
	if (!$hotelPlan->save()) {
		$hotelPlan->setErrorFirst("プランの作成に失敗しました。");
		$hotelPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "delete") and $hotelPlan->getErrorCount() <= 0) {
	if (!$hotelPlan->delete()) {
		$hotelPlan->setErrorFirst("プランの削除に失敗しました。");
		$hotelPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$xmlRecomCategory = new xml(XML_RECOM_CATEGORY_H);
$xmlRecomCategory->load();
if (!$xmlRecomCategory->getXml()) {
	$hotelPlan->setErrorFirst("お勧めカテゴリデータの読み込みに失敗しました");
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
	<?php if (($hotelPlan->getByKey($hotelPlan->getKeyValue(), "regist") or $hotelPlan->getByKey($hotelPlan->getKeyValue(), "delete")) and $hotelPlan->getErrorCount() <= 0) {?>
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
		},
	};

	function unloadcallback() {
		//$('#check_none').val("none");
		//document.frmSearch.submit();
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
					if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "regist") and $hotelPlan->getErrorCount() <= 0) {
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