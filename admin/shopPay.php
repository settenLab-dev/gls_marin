<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');

//require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');

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
$shop->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelPriceType = new hotelRoom($dbMaster);
$hotelPriceType->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelPay = new hotelPay($dbMaster);
$hotelPayTarget = new hotelPay($dbMaster);


$hotelPayCheck = new hotelPay($dbMaster);
$hotelPayCheck->selectSetCheck($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


$collection = new collection($dbMaster);
$collection->setPost();

$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") == "") {
	$collection->setByKey($collection->getKeyValue(), "HOTELPAY_DATE", date("Y-m-d"));
}
// if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") == "") {
// 	$collection->setByKey($collection->getKeyValue(), "HOTELPAY_DATE", date("Y-m-d"));
// }
$collection->setByKey($collection->getKeyValue(), "search_term", 9);
// $collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

//	料金設定検索
$hotelPay->selectList($collection);

// print_r($hotelBooking->getCollection());


$dspData = array();
$roomUsed = array();
$roomUsedPlan = array();
$cnt = 0;
if ($hotelPay->getCount() > 0) {
	foreach ($hotelPay->getCollection() as $hp) {
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
		//$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPLAN_ID", cmIdCheck("HOTELPLAN_ID"));
		//$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "ROOM_ID", cmKeyCheck("ROOM_ID"));

		$hotelPayTarget->setByKey($hp["HOTELPAY_NAME"], "HOTELPAY_NAME", $hp["HOTELPAY_NAME"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_DATE", $hp["HOTELPAY_DATE"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_ID", $hp["HOTELPAY_ID"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY1", $hp["HOTELPAY_MONEY1"]);

		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY2", $hp["HOTELPAY_MONEY2"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY3", $hp["HOTELPAY_MONEY3"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY4", $hp["HOTELPAY_MONEY4"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY5", $hp["HOTELPAY_MONEY5"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY6", $hp["HOTELPAY_MONEY6"]);

		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_FLG_STOP", $hp["HOTELPAY_FLG_STOP"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_ROOM_NUM", $hp["HOTELPAY_ROOM_NUM"]);
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_ROOM_OVER", $hp["HOTELPAY_ROOM_OVER"]);
	}
}



	$inputs = new inputs();
	$disabled = '';

$inputsOnly = new inputs(true);
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>料金タイプ設定｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
	<script type="text/javascript">
	var profiles =
	{
		windowCallUnload:
		{
			height:450,
			width:550,
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
		},
		windowCallUnload3:
		{
			height:500,
			width:750,
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
				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php print $inputs->hidden("HOTELPAY_DATE", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE"))?>
				</form>

							<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
							<?php if ($flg) {?>
								<a href="shopPayEdit.html" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","料金設定","circle")?></a>
								<?php /*
								<?=$inputs->submit("","search","料金設定old", "circle")?>
								*/?>
							<?php }else{?>
								<a href="shopPayEdit.html" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","料金設定","circle bgOrange")?></a>
								<?php /*
								<?=$inputs->submit("","search","料金設定old", "circle bgOrange")?>
								*/?>
								<p class="colorRed">※未設定</p>
							<?php }?>
							</form>


					<h2>提供在庫数調整</h2>
					<p>「×」の箇所はまず、料金タイプ設定を行って下さい。</p>
					<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
						<tr>
							<td>
								<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
								<p>表示開始日 <input type="text" id="datepicker" name="HOTELPAY_DATE" value="<?php print $collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")?>" class="imeDisabled circle wZip" /> <?=$inputs->submit("","search","切替", "circle")?></p>
								</form>
								<script type="text/javascript">
										$(function() {
											$("#datepicker").datepicker({
												dateFormat: 'yy-mm-dd',
												changeMonth: true,
								                changeYear: true,
								                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
								                dayNamesMin: ['日','月','火','水','木','金','土']
											});
										});
									</script>
							</td>
							<td width="40">
								<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
								<?=$inputs->submit("","search","前の10日", "circle")?>
								<?php print $inputs->hidden("HOTELPAY_DATE", date("Y-m-d",strtotime("-10 day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))))?>
								</form>
							</td>
							<td width="40">
								<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
								<?=$inputs->submit("","search","前の日", "circle")?>
								<?php print $inputs->hidden("HOTELPAY_DATE", date("Y-m-d",strtotime("-1 day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))))?>
								</form>
							</td>
							<td width="40">
								<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
								<?=$inputs->submit("","search","次の日", "circle")?>
								<?php print $inputs->hidden("HOTELPAY_DATE", date("Y-m-d",strtotime("1 day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))))?>
								</form>
							</td>
							<td width="40">
								<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
								<?=$inputs->submit("","search","次の10日", "circle")?>
								<?php print $inputs->hidden("HOTELPAY_DATE", date("Y-m-d",strtotime("10 day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))))?>
								</form>
							</td>
						</tr>
					</table>

					<?php require("includes/box/hotel/listPay.php");?>

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