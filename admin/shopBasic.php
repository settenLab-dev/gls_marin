<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

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


$shop = new shop($dbMaster);
$shop->select(cmIdCheck(constant("shop::keyName")));
// print_r($_POST);exit;

	$shop->setPost();
// if ($_POST and $shop->getByKey($shop->getKeyValue(), "regist")) {
// }
// elseif ($_POST) {
// 	$shop->setPost(true);
// }

// print $shop->getByKey($shop->getKeyValue(), "HOTEL_PIC_APP")."<br />";

$shop->setByKey($shop->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("shop::keyName")));
// $shop->setByKey($shop->getKeyValue(), "HOTEL_NAME", cmIdCheck(constant("shop::keyName")));



// if ($shop->getByKey($shop->getKeyValue(), "check_none") == "") {
// }
$shop->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", cmIdCheck(constant("shop::keyName")));

if ($shop->getByKey($shop->getKeyValue(), "regist") and $shop->getErrorCount() <= 0) {

	if (!$shop->save()) {
		$shop->setErrorFirst("ショップ基本情報の保存に失敗しました。");
		$shop->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($shop->getByKey($shop->getKeyValue(), "regist")){
}
else {
}


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$shop->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ショップ基本情報｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
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

				<?php require("includes/box/common/menuHotel.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">

					<h2>ショップ基本情報</h2>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data" id="frmSearch" name="frmSearch">
						<?php
							if ($shop->getByKey($shop->getKeyValue(), "regist") and $shop->getErrorCount() <= 0) {
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
								require("includes/box/hotel/inputBasic.php");
							}
							else {
								require("includes/box/hotel/inputBasic.php");
							}
						?>
					</form>

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