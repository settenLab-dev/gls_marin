<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponShop.php');

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


$coupon = new coupon($dbMaster);
$coupon->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

//$couponPayCheck = new couponPay($dbMaster);
//$couponPayCheck->selectSetCheck(cmIdCheck(constant("coupon::keyName")));

$couponBookset = new couponBookset($dbMaster);
$couponBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$couponBookset->setPost();
$couponBookset->check();

$couponPlan = new couponPlan($dbMaster);
$couponPlan->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$couponShop = new couponShop($dbMaster);
$couponShop->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


//print $couponPlan->getByKey($couponPlan->getKeyValue(),"COMPANY_ID");



//$couponPay = new hotelPay($dbMaster);
//$couponPayTarget = new hotelPay($dbMaster);


/*
if ($_POST) {
	//	料金設定の対象プラン
	$couponPlanTarget = new couponPlan($dbMaster);
	$couponPlanTarget->select($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"), "1,2", cmIdCheck(constant("coupon::keyName")));
	//	料金設定対象の部屋
	$couponShopTrget = new couponShop($dbMaster);
	$couponShopTrget->select($collection->getByKey($collection->getKeyValue(), "SHOP_ID"), "1", cmIdCheck(constant("coupon::keyName")));

	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("coupon::keyName")));
	$collection->setByKey($collection->getKeyValue(), "JOBPLAN_ID", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"));
	$collection->setByKey($collection->getKeyValue(), "SHOP_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"));

	//	料金設定検索
	$couponPay->selectList($collection);

// 	print_r($couponPay->getCollection());

	//	登録済みデータ設定
	if ($couponPay->getCount() > 0) {
		foreach ($couponPay->getCollection() as $hp) {
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "COMPANY_ID", cmIdCheck(constant("coupon::keyName")));
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));

			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_DATE", $hp["HOTELPAY_DATE"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_ID", $hp["HOTELPAY_ID"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY1", $hp["HOTELPAY_MONEY1"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY2", $hp["HOTELPAY_MONEY2"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY3", $hp["HOTELPAY_MONEY3"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY4", $hp["HOTELPAY_MONEY4"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY5", $hp["HOTELPAY_MONEY5"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_MONEY6", $hp["HOTELPAY_MONEY6"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_FLG_STOP", $hp["HOTELPAY_FLG_STOP"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_ROOM_NUM", $hp["HOTELPAY_ROOM_NUM"]);
			$couponPayTarget->setByKey($hp["HOTELPAY_DATE"], "HOTELPAY_ROOM_OVER", $hp["HOTELPAY_ROOM_OVER"]);
		}
	}
	for ($i=1; $i<=4; $i++) {
		$couponPayTarget->setByKey($couponPayTarget->getKeyValue(), "HOTELPAY_PS_DATA".$i, $hp["HOTELPAY_PS_DATA".$i]);
	}
	for ($i=1; $i<=14; $i++) {
		$couponPayTarget->setByKey($couponPayTarget->getKeyValue(), "HOTELPAY_BB_DATA".$i, $hp["HOTELPAY_BB_DATA".$i]);
	}
	$couponPayTarget->setByKey($couponPayTarget->getKeyValue(), "HOTELPAY_SERVICE_FLG", $hp["HOTELPAY_SERVICE_FLG"]);
	$couponPayTarget->setByKey($couponPayTarget->getKeyValue(), "HOTELPAY_SERVICE", $hp["HOTELPAY_SERVICE"]);
	$couponPayTarget->setByKey($couponPayTarget->getKeyValue(), "HOTELPAY_REMARKS", $hp["HOTELPAY_REMARKS"]);

// 	print_r($couponPayTarget->getCollection());
}

if ($collection->getByKey($collection->getKeyValue(), "search")) {

}
elseif ($collection->getByKey($collection->getKeyValue(), "regist")) {

	$couponPayTarget->setPost();
	$couponPayTarget->setByKey("COMPANY_ID", "COMPANY_ID", cmIdCheck(constant("coupon::keyName")));
	$couponPayTarget->setByKey("HOTELPLAN_ID", "HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
	$couponPayTarget->setByKey("ROOM_ID", "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
	$couponPayTarget->check($couponPlanTarget);

// 	print "aa".$couponPayTarget->getByKey("2013-07-20", "HOTELPAY_MONEY1");

// 	print_r($couponPayTarget->getCollection());

	 if (!$couponPayTarget->save($couponPlanTarget)) {
// 		$couponPayTarget->setErrorFirst("料金の設定に失敗しました。");
// 		$couponPayTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
*/

//print_r($collection);


if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS") == 3) {
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
	<title>クーポン情報登録｜<?=SITE_SLAKER_NAME?></title>
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
	<div id="container">
		<?php
			require("includes/box/common/header.php");
		?>
		<div id="contents">
			<div id="contentsData" class="circle">
				<?php require("includes/box/common/mainMenu.php");?>
				<?php require("includes/box/common/menuCoupon.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">
				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>クーポン情報登録</h2>

						<?php
		//				if ($collection->getByKey($collection->getKeyValue(), "regist") and $couponPayTarget->getErrorCount() <= 0) {
						if ($collection->getByKey($collection->getKeyValue(), "regist")) {
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

						require("includes/box/coupon/listPlan.php");
						?>

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