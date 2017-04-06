<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomiPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');

$dbMaster = new dbMaster();

$collection = new collection($db);
$collection->setPost();


$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$kuchikomi = new kuchikomi($dbMaster);
$kuchikomi->select(cmIdCheck(constant("kuchikomi::keyName")));

	$kuchikomi->setPost();

$kuchikomi->setByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_ID", cmIdCheck(constant("kuchikomi::keyName")));

// if ($kuchikomi->getByKey($kuchikomi->getKeyValue(), "check_none") == "") {
// }
	$kuchikomi->check();

$kuchikomiPic = new kuchikomiPic($dbMaster);
$kuchikomiPic->select("", "1,2", cmIdCheck(constant("kuchikomi::keyName")));

$shop = new shop($dbMaster);
$shop->selectList($collection);

//print_r($shop);

$shopPlan = new shopPlan($dbMaster);
$shopPlan->selectList($collection);

//print_r($shopPlan);


if ($kuchikomi->getByKey($kuchikomi->getKeyValue(), "regist") and $kuchikomi->getErrorCount() <= 0) {
	if (!$kuchikomi->save()) {
		$kuchikomi->setErrorFirst("クチコミ情報の保存に失敗しました。");
		$kuchikomi->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($kuchikomi->getByKey($kuchikomi->getKeyValue(), "regist")){

}
else {
}


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$kuchikomi->setErrorFirst("エリアデータの読み込みに失敗しました");
}






$inputs = new inputs();
$inputsOnly = new inputs(true);


?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>体験レポート編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>

	<script type="text/javascript">

	<?php if (($kuchikomi->getByKey($kuchikomi->getKeyValue(), "regist") or $kuchikomi->getByKey($kuchikomi->getKeyValue(), "delete")) and $kuchikomi->getErrorCount() <= 0) {?>
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

	</script>

</head>
<body id="">
<?php /*
	<div id="headerPop">
		<h1><img src="<?=URL_SLAKER_COMMON?>assets/header/logo.png" alt="<?=SITE_NAME?>" width="106" height="29" /></h1>
	</div>
*/?>
	<div id="containerPop">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
				<?php
					if ($kuchikomi->getByKey($kuchikomi->getKeyValue(), "regist") and $kuchikomi->getErrorCount() <= 0) {?>
						<script type="text/javascript">
						$().toastmessage( 'showToast', {
							inEffectDuration:500,
							text:"保存完了しました。",
							type:"success",
							sticky: false,
							position:"middle-center"
						});
						</script>

						<?php
					}
					require("includes/box/kuchikomi/inputBasic.php");
				?>
			</form>

	</div>
</body>
</html>