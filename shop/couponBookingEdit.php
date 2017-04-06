<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/xml.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setPost();
// print_r($_POST);
//$coupon = new couponsite($dbMaster);
//$coupon->selectList($collection);

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COUPONBOOK_ID", cmIdCheck("COUPONBOOK_ID"));
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$couponBooking = new couponBooking($dbMaster);
$couponBooking->selectCancelData(cmIdCheck("COUPONBOOK_ID"), "", "",  $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"),"");
$couponBooking->setPost();

//print_r($couponBooking);
//	料金設定検索 

$member = new MEMBER($dbMaster);
// print_r($couponBooking->getCollection());
$member->setPost();


$couponPlan = new couponPlan($dbMaster);
$couponPlan->select($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_ID"), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


/*	if ($couponBookin->getByKey($couponBooking->getKeyValue(), "cancelconfirm")) {

		$couponBooking->checkCancelConfirm_shop();

	}
*/

if ($couponBooking->getByKey($couponBooking->getKeyValue(), "used")) {

	if ($couponBooking->getCount() > 0) {
		if (!$couponBooking->statusBookingUsed()) {
			$couponBooking->setErrorFirst("利用済み処理に失敗しました。");
			$couponBooking->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
}

//print_r($couponBooking);

$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>クーポン購入履歴詳細｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($couponBooking->getByKey($couponBooking->getKeyValue(), "cancel") or $couponBooking->getByKey($couponBooking->getKeyValue(), "delete")) and $couponBooking->getErrorCount() <= 0) {?>
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

   	function memberset(mdata) {
   	   	//alert(mdata["MEMBER_NAME1"]);
   	   	$('#COUPONBOOK_NAME1').val(mdata["MEMBER_NAME1"]);
   	   	$('#COUPONBOOK_NAME2').val(mdata["MEMBER_NAME2"]);
   	   	$('#COUPONBOOK_KANA1').val(mdata["MEMBER_NAME_KANA1"]);
   	   	$('#COUPONBOOK_KANA2').val(mdata["MEMBER_NAME_KANA2"]);
   	   	$('#COUPONBOOK_ZIP').val(mdata["MEMBER_ZIP"]);
   	   	$('#COUPONBOOK_PREF_ID').val(mdata["MEMBER_PREF"]);
   	   	$('#COUPONBOOK_CITY').val(mdata["MEMBER_CITY"]);
   	   	$('#COUPONBOOK_ADDRESS').val(mdata["MEMBER_ADDRESS"]);
   	   	$('#COUPONBOOK_NAME2').val(mdata["MEMBER_ADDRESS"]);
   	   	$('#COUPONBOOK_BUILD').val(mdata["MEMBER_BUILD"]);
   	   	$('#COUPONBOOK_TEL').val(mdata["MEMBER_TEL1"]);
   	}

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
</head>
<body id="">
	<div id="containerPop">
		<h2>クーポン購入の詳細・ステータス変更</h2>
		<div id="contentsPop" class="circle">

			<?php if ($couponBooking->getErrorCount() > 0) {?>
			<?php print create_error_caption($couponBooking->getError())?>
			<br />
			<?php }?>

			
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
			<?php
					require("includes/box/coupon/listCancel.php");
			?>

</form>
			<br />

		</div>
		<br />
	</div>
</body>
</html>