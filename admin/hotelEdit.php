<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotel = new hotel($dbMaster);
$hotel->select(cmIdCheck(constant("hotel::keyName")));
// $hotel->setPost();
// $hotel->check();


	$hotel->setPost();
// if ($_POST and $hotel->getByKey($hotel->getKeyValue(), "regist")) {
// }
// elseif ($_POST) {
// 	$hotel->setPost(true);
// }

// print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PIC_APP")."<br />";

$hotel->setByKey($hotel->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("hotel::keyName")));



// if ($hotel->getByKey($hotel->getKeyValue(), "check_none") == "") {
// }
	$hotel->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", cmIdCheck(constant("hotel::keyName")));



if ($hotel->getByKey($hotel->getKeyValue(), "regist") and $hotel->getErrorCount() <= 0) {
	if (!$hotel->save()) {
		$hotel->setErrorFirst("ホテル基本情報の保存に失敗しました。");
		$hotel->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotel->getByKey($hotel->getKeyValue(), "regist")){
}
else {
}


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotel->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
$inputsOnly = new inputs(true);


?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ホテル情報編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>

	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
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
		<?php require("includes/box/common/menuHotel.php");?>

			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data" id="frmSearch" name="frmSearch">
				<?php
					if ($hotel->getByKey($hotel->getKeyValue(), "regist") and $hotel->getErrorCount() <= 0) {
?>
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
					require("includes/box/hotel/inputBasic.php");
				?>
			</form>

	</div>
</body>
</html>