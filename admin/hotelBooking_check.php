<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookingcont.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

// require("includes/box/login/loginAction.php");
// if (!$sess->sessionCheck()) {
// 	require_once('includes/box/login/loginBox.php');
// 	exit;
// }

$hotel = new hotel($dbMaster);
$hotel->select($_GET['id']);

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($_GET['id']);
$hotelBookset->setPost();
$hotelBookset->check();

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET['id']);

$booking = new hotelBooking($dbMaster);
$booking->selectList($collection);
//print_r($booking);exit;

/*
$bookingcont = new hotelBookingcont($dbMaster);
$bookingcont->selectList($collection);
print_r($bookingcont);
print "5";
*/
// add by 0909
$hotelPlan = new hotelPlan($dbMaster);
$hotelRoom = new hotelRoom($dbMaster);


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
		<!-- 
		<?php
			require("includes/box/common/header.php");
		?>
		 -->
				<!-- <?php require("includes/box/common/mainMenu.php");?> -->
				<?php require("includes/box/common/menuHotel.php");?>


				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>予約管理</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_HOTERL") == 1) {
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

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							require("includes/box/hotel/listBooking_check.php");
						?>
					</form>
					<?php
					}
					?>
				<br />

			<!-- 
			<div id="colRight">
				<?php require("includes/box/common/account.php");?>
			</div>
			 -->
			<br class="clearfix" />

		<!-- <?php require("includes/box/common/footer.php");?> -->
	</div>
</body>
</html>