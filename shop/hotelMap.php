<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');

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
$hotel->setPost();
$hotel->setByKey($hotel->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($_POST and $hotel->getErrorCount() <= 0) {
	if (!$hotel->save()) {
		$hotel->setErrorFirst("ホテル地図の設定に失敗しました。");
		$hotel->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$ar = cmGetPrefName();
$hotel_address  = $ar[$hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF")];
$hotel_address .= $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CITY");
$hotel_address .= $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS");


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/base.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/sortTableStyle.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/datePicker.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/sortTableStyle.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/jquery.toastmessage.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/common.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>js/timepicker/dist/themes/default/ui.core.css" type="text/css" media="screen" />
	<title>ホテル情報｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?=SITE_GOOGLE_SHOP?>&sensor=false" type="text/javascript"></script>
	<script language="JavaScript" src="<?=URL_SLAKER_COMMON?>js/prototype.js"></script>
	<script language="JavaScript" src="<?=URL_SLAKER_COMMON?>js/overlay.js"></script>
	<script language="JavaScript" src="<?=URL_SLAKER_COMMON?>js/windowstate.js"></script>
	<script language="JavaScript" src="<?=URL_SLAKER_COMMON?>js/form_googlemapH.js"></script>
	<script type="text/javascript">
	form_googlemap = new form_googlemap('<?= $hotel_address ?>','<?=$hotel->getByKey($hotel->getKeyValue(), "HOTEL_LON")?>','<?=$hotel->getByKey($hotel->getKeyValue(), "HOTEL_LAT")?>');
	function check(e){
		form_googlemap.fadein(e);
	}
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

					<h2>ホテル地図編集</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_HOTERL") != 1) {
						//	ホテル情報設定可否
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>ホテル情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php }elseif ($hotel->getCount() <= 0) {?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>基本情報が設定されていません。</p>
								<p>まず基本情報を設定して下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

						<?php
							if ($_POST and $hotel->getErrorCount() <= 0) {
						?>
						<script type="text/javascript">
						</script>
						<?php
								require("includes/box/hotel/inputMap.php");
							}
							else {
								require("includes/box/hotel/inputMap.php");
							}
						?>
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