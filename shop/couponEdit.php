<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPic.php');
$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}



$coupon = new coupon($dbMaster);
$coupon->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
// $coupon->setPost();
// $coupon->check();


	$coupon->setPost();
// if ($_POST and $coupon->getByKey($coupon->getKeyValue(), "regist")) {
// }
// elseif ($_POST) {
// 	$coupon->setPost(true);
// }

// print $coupon->getByKey($coupon->getKeyValue(), "HOTEL_PIC_APP")."<br />";

$coupon->setByKey($coupon->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

//print $coupon->getByKey($coupon->getKeyValue(), "COMPANY_ID");

// if ($coupon->getByKey($coupon->getKeyValue(), "check_none") == "") {
// }
	$coupon->check();

$couponPic = new couponPic($dbMaster);
$couponPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));



if ($coupon->getByKey($coupon->getKeyValue(), "regist") and $coupon->getErrorCount() <= 0) {
	if (!$coupon->save()) {
		$coupon->setErrorFirst("企業基本情報の保存に失敗しました。");
		$coupon->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($coupon->getByKey($coupon->getKeyValue(), "regist")){
}
else {
}


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$coupon->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
$inputsOnly = new inputs(true);


?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>施設情報編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>

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

			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frmSearch" name="frmSearch">
				<?php
					if ($coupon->getByKey($coupon->getKeyValue(), "regist") and $coupon->getErrorCount() <= 0) {
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
					require("includes/box/coupon/inputBasic.php");
				?>
			</form>

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