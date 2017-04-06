<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

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

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelPlan = new hotelPlan($dbMaster);
$hotelPlan->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// print_r($hotelPlan->getCollection());

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// print_r($hotelRoom->getCollection());

$collection = new collection($dbMaster);
$collection->setPost();

$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") == "") {
	$collection->setByKey($collection->getKeyValue(), "HOTELPAY_DATE", date("Y-m-d"));
}
$collection->setByKey($collection->getKeyValue(), "search_term", 6);
// $collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

$hotelPay = new hotelPay($dbMaster);
$hotelPay->selectList($collection);

$dspData = array();
$roomUsed = array();
$roomUsedPlan = array();
$cnt = 0;
if ($hotelRoom->getCount() > 0) {
	foreach ($hotelRoom->getCollection() as $r) {

		$cnt++;

		//	部屋タイプ
		$dspData[$cnt]["ROOM_ID"] = $r["ROOM_ID"];
		$dspData[$cnt]["ROOM_NAME"] = $r["ROOM_NAME"];
		for ($i=1; $i<=7; $i++) {
			$dspData[$cnt]["ROOM_NUM".$i] = $r["ROOM_NUM".$i];
		}

		if ($hotelPlan->getCount() > 0) {
			foreach ($hotelPlan->getCollection() as $p) {

				$arRoom = array();
				$arTemp = explode(":", $p["HOTELPLAN_ROOM_LIST"]);
				if (count($arTemp) > 0) {
					foreach ($arTemp as $data) {
						if ($data != "") {
							$arRoom[$data] = $data;
						}
					}
				}

				if ($arRoom[$r["ROOM_ID"]] != "") {

					//	プラン
					$dspData[$cnt]["plan"][] = $p;
					/*
					$dspData[$cnt]["HOTELPLAN_ID"] = $p["HOTELPLAN_ID"];
					$dspData[$cnt]["HOTELPLAN_NAME"] = $p["HOTELPLAN_NAME"];
					*/

					//	料金情報
					if ($hotelPay->getCount() > 0) {
						foreach ($hotelPay->getCollection() as $hpay) {
// 							if ($hpay["ROOM_ID"] == $r["ROOM_ID"]) {
							if ($hpay["ROOM_ID"] == $r["ROOM_ID"] and $hpay["HOTELPLAN_ID"] == $p["HOTELPLAN_ID"]) {
								$dspData[$cnt]["pay"][] = $hpay;
								$roomUsed[$hpay["ROOM_ID"]][$hpay["HOTELPAY_DATE"]] += $hpay["HOTELPAY_ROOM_NUM"];
								$roomUsedPlan[$hpay["ROOM_ID"]][$hpay["HOTELPLAN_ID"]][$hpay["HOTELPAY_DATE"]]["num"] += $hpay["HOTELPAY_ROOM_NUM"];
								$roomUsedPlan[$hpay["ROOM_ID"]][$hpay["HOTELPLAN_ID"]][$hpay["HOTELPAY_DATE"]]["id"] = $hpay["HOTELPAY_ID"];
							}
						}
					}

				}

			}
		}

	}
}

// print_r($dspData);

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

					<h2>提供部屋数調整</h2>
					<p>「×」の箇所はまず、プラン設定から料金設定を行って下さい。</p>
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
								<?=$inputs->submit("","search","前の週", "circle")?>
								<?php print $inputs->hidden("HOTELPAY_DATE", date("Y-m-d",strtotime("-7 day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))))?>
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
								<?=$inputs->submit("","search","次の週", "circle")?>
								<?php print $inputs->hidden("HOTELPAY_DATE", date("Y-m-d",strtotime("7 day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))))?>
								</form>
							</td>
						</tr>
					</table>

					<?php require("includes/box/hotel/listProvide.php");?>

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