<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');

error_reporting(1);

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

$hotelPay = new hotelPay($dbMaster);
$hotelPayTarget = new hotelPay($dbMaster);

$hotelPayCheck = new hotelPay($dbMaster);
$hotelPayCheck->selectSetCheck($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


//	料金設定の対象プラン
//$hotelPlanTarget = new hotelPlan($dbMaster);
//$hotelPlanTarget->select(cmIdCheck("HOTELPLAN_ID"), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//	料金設定対象の部屋
$hotelPriceType = new hotelPriceType($dbMaster);
$hotelPriceType->select(cmKeyCheck("SHOP_PRICETYPE_ID"), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collection = new collection($dbMaster);
$collection->setPost();

$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", cmIdCheck("HOTELPLAN_ID"));
$collection->setByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID", cmKeyCheck("SHOP_PRICETYPE_ID"));

//	料金設定検索
$hotelPay->selectList($collection);

//print_r($hotelPay);
// 	print_r($hotelPay->getCollection());

//	登録済みデータ設定
if ($hotelPay->getCount() > 0) {
	foreach ($hotelPay->getCollection() as $hp) {
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPLAN_ID", cmIdCheck("HOTELPLAN_ID"));
		$hotelPayTarget->setByKey($hp["HOTELPAY_DATE"], "SHOP_PRICETYPE_ID", cmKeyCheck("SHOP_PRICETYPE_ID"));

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
	$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA".$i."2", $hp["HOTELPAY_PS_DATA".$i."2"]);
}
for ($i=1; $i<=14; $i++) {
	$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA".$i, $hp["HOTELPAY_BB_DATA".$i]);
}
$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE_FLG", $hp["HOTELPAY_SERVICE_FLG"]);
$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_MONEY_FLG", $hp["HOTELPAY_MONEY_FLG"]);
$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE", $hp["HOTELPAY_SERVICE"]);
$hotelPayTarget->setByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_REMARKS", $hp["HOTELPAY_REMARKS"]);


if ($collection->getByKey($collection->getKeyValue(), "regist")) {

	$hotelPayTarget->setPost();
	$hotelPayTarget->setByKey("COMPANY_ID", "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//	$hotelPayTarget->setByKey("HOTELPLAN_ID", "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
	$hotelPayTarget->setByKey("SHOP_PRICETYPE_ID", "SHOP_PRICETYPE_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID"));

	//	料金アラームチェック用
	$hotelPayTarget->setByKey("BOOKSET_PAY_ALARM", "BOOKSET_PAY_ALARM", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_PAY_ALARM"));
	$hotelPayTarget->check($hotelPlanTarget);

	if ($hotelPayTarget->getErrorCount() <= 0) {
// 		print_r($hotelPlanTarget);exit;
		if (!$hotelPayTarget->save($hotelPlanTarget)) {
			echo("料金の登録が失敗しました。管理者へご連絡ください。");
			exit;
		}
	}

}

//print_r($hotelPayTarget->getErrorCount());

/*
if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "regist") and $hotelPlan->getErrorCount() <= 0) {
	if (!$hotelPlan->save()) {
		$hotelPlan->setErrorFirst("プランの作成に失敗しました。");
		$hotelPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "delete") and $hotelPlan->getErrorCount() <= 0) {
	if (!$hotelPlan->delete()) {
		$hotelPlan->setErrorFirst("プランの削除に失敗しました。");
		$hotelPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}
*/

$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>プラン｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "regist") or $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "delete")) and $hotelPayTarget->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
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
<body id="">
	<div id="containerPop">
		<h2>料金設定 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "regist") and $hotelPayTarget->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputPay.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>