<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
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

$collection = new collection($dbMaster);
$collection->setPost();


$hotel = new hotel($dbMaster);
$hotel->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

//リンカーンプラン----------
$company = new company($dbMaster);
$company->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collectionLink = new collection($db);
//---------------------------

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelPlan = new hotelPlan($dbMaster);
$hotelPlan->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelPay = new hotelPay($dbMaster);
$hotelPayTarget = new hotelPay($dbMaster);

$hotelPayCheck = new hotelPay($dbMaster);
$hotelPayCheck->selectSetCheck($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($_POST) {
	//	料金設定の対象プラン
	$hotelPlanTarget = new hotelPlan($dbMaster);
	$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	//	料金設定対象の部屋
	$hotelRoomTrget = new hotelRoom($dbMaster);
	$hotelRoomTrget->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
	$collection->setByKey($collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

	//	料金設定検索
	$hotelPay->selectList($collection);

// 	print_r($hotelPay->getCollection());

	//	登録済みデータ設定
	if ($hotelPay->getCount() > 0) {
		foreach ($hotelPay->getCollection() as $hp) {
			$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
			$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
			$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

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
	for ($i=1; $i<=4; $i++) {
		$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA".$i, $hp["HOTELPAY_PS_DATA".$i]);
	}
	for ($i=1; $i<=14; $i++) {
		$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA".$i, $hp["HOTELPAY_BB_DATA".$i]);
	}
	$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE_FLG", $hp["HOTELPAY_SERVICE_FLG"]);
	$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE", $hp["HOTELPAY_SERVICE"]);
	$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_REMARKS", $hp["HOTELPAY_REMARKS"]);

// 	print_r($hotelPayTarget->getCollection());
}

if ($collection->getByKey($collection->getKeyValue(), "search")) {

}
elseif ($collection->getByKey($collection->getKeyValue(), "regist")) {

	$hotelPayTarget->setPost();
	$hotelPayTarget->setByKey("COMPANY_ID", "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
	$hotelPayTarget->setByKey("HOTELPLAN_ID", "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
	$hotelPayTarget->setByKey("ROOM_ID", "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
	$hotelPayTarget->check($hotelPlanTarget);

// 	print "aa".$hotelPayTarget->getByKey("2013-07-20", "HOTELPAY_MONEY1");

// 	print_r($hotelPayTarget->getCollection());

	 if (!$hotelPayTarget->save($hotelPlanTarget)) {
// 		$hotelPayTarget->setErrorFirst("料金の設定に失敗しました。");
// 		$hotelPayTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}

$only = false;

if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
	//	契約満了
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
	$only = true;
}
else {
if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
	$only = true;
}
else {
	$inputs = new inputs();
	$disabled = '';
}
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
			width:850,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		},
		windowCallUnload2:
		{
			height:600,
			width:850,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		},
		windowCallUnload3:
		{
			height:150,
			width:600,
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
				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>ホテルプラン設定</h2>
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

						<?php
						if ($collection->getByKey($collection->getKeyValue(), "regist") and $hotelPayTarget->getErrorCount() <= 0) {
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

						require("includes/box/hotel/listPlan.php");
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