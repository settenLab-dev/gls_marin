<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

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

$company = new company($dbMaster);
$company->select(cmIdCheck(constant("hotel::keyName")));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmIdCheck(constant("hotel::keyName")));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", cmIdCheck(constant("hotel::keyName")));

$collection = new collection($db);

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

					<h2>ホテル部屋タイプ</h2>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							require("includes/box/hotel/listRoom.php");
						?>
					</form>
	</div>
</body>
</html>