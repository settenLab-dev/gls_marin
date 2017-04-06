<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotel = new hotel($dbMaster);
$hotel->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// print_r($_POST);exit;

	$hotel->setPost();
// if ($_POST and $hotel->getByKey($hotel->getKeyValue(), "regist")) {
// }
// elseif ($_POST) {
// 	$hotel->setPost(true);
// }

// print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PIC_APP")."<br />";

$hotel->setByKey($hotel->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// $hotel->setByKey($hotel->getKeyValue(), "HOTEL_NAME", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));



// if ($hotel->getByKey($hotel->getKeyValue(), "check_none") == "") {
// }
$hotel->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($hotel->getByKey($hotel->getKeyValue(), "regist") and $hotel->getErrorCount() <= 0) {

	if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_LON") == "" and $hotel->getByKey($hotel->getKeyValue(), "HOTEL_LAT") == "") {
		$ar = cmGetPrefName();
		$pref  = $ar[$hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF")];
		$city = $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CITY");
		$latlng = cmGetLatLng($pref.$city.$hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS"), SITE_GOOGLE_SHOP);
		if ($latlng) {
			list($lng,$lat) = explode(',',$latlng);
		}
		else {
			$lng = "";
			$lat = "";
		}
		$hotel->setByKey($hotel->getKeyValue(), "HOTEL_LON", $lng);
		$hotel->setByKey($hotel->getKeyValue(), "HOTEL_LAT", $lat);
	}

	if (!$hotel->save()) {
		$hotel->setErrorFirst("ホテル基本情報の保存に失敗しました。");
		$hotel->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotel->getByKey($hotel->getKeyValue(), "regist")){
}
else {
}

if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
	//	契約満了
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
	$inputs = new inputs();
	$disabled = '';
}
}


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotel->setErrorFirst("エリアデータの読み込みに失敗しました");
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
				<?php require("includes/box/common/mainMenu.php");?>
				<?php require("includes/box/common/menuHotel.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">

					<h2>ホテルの基本情報</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_HOTERL") != 1) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>ホテル情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

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
								require("includes/box/hotel/inputBasic.php");
							}
							else {
								require("includes/box/hotel/inputBasic.php");
							}
						?>
					</form>
					<?php
					}
					?>
				</div>
				<br />

			</div>
			<div id="colRight">
				<?php require("includes/box/common/account.php");?>
			</div>
			<br class="clearfix" />

			</div>
		</div>
		<?php require("includes/box/common/footer.php");?>
	</div>
</body>
</html>