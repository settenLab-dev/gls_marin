<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');

$dbMaster = new dbMaster();


$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setPost();


$hotel = new hotel($dbMaster);
$hotel->select(cmIdCheck(constant("hotel::keyName")));

//リンカーンプラン----------
$company = new company($dbMaster);
$company->select(cmIdCheck(constant("hotel::keyName")));

$collectionLink = new collection($db);
$collectionLink->setByKey($collectionLink->getKeyValue(), "TL_HOTEL_ID", $company->getByKey($company->getKeyValue(), "COMPANY_LINK"));

$hotelPlanLink = new tlPlan($dbMaster);
$hotelPlanLink->selectList($collectionLink);
//---------------------------


$hotelPayCheck = new hotelPay($dbMaster);
$hotelPayCheck->selectSetCheck(cmIdCheck(constant("hotel::keyName")));

$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select(cmIdCheck(constant("hotel::keyName")));
$hotelBookset->setPost();
$hotelBookset->check();

$hotelPlan = new hotelPlan($dbMaster);
$hotelPlan->select("", "1,2", cmIdCheck(constant("hotel::keyName")));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", cmIdCheck(constant("hotel::keyName")));

$hotelPay = new hotelPay($dbMaster);
$hotelPayTarget = new hotelPay($dbMaster);


if ($_POST) {
	//	料金設定の対象プラン
	$hotelPlanTarget = new hotelPlan($dbMaster);
	$hotelPlanTarget->select($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"), "1,2", cmIdCheck(constant("hotel::keyName")));
	//	料金設定対象の部屋
	$hotelRoomTrget = new hotelRoom($dbMaster);
	$hotelRoomTrget->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", cmIdCheck(constant("hotel::keyName")));

	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("hotel::keyName")));
	$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
	$collection->setByKey($collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

	//	料金設定検索
	$hotelPay->selectList($collection);

// 	print_r($hotelPay->getCollection());

	//	登録済みデータ設定
	if ($hotelPay->getCount() > 0) {
		foreach ($hotelPay->getCollection() as $hp) {
			$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "COMPANY_ID", cmIdCheck(constant("hotel::keyName")));
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
	$hotelPayTarget->setByKey("COMPANY_ID", "COMPANY_ID", cmIdCheck(constant("hotel::keyName")));
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
			height:600,
			width:850,
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
   		$(".popup2").popupwindow(profiles);
   	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body>
	<div id="containerPop">
				<?php require("includes/box/common/menuHotel.php");?>
				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>ホテルプラン設定</h2>

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

		</div>
	</div>
</body>
</html>