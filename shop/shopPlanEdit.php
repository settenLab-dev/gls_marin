<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelShopBase.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/ShopAccess.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mArea.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategory.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategoryDetail.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mTag.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$shop = new shop($dbMaster);
$shop->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


$company = new company($dbMaster);
$company->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopPlan = new shopPlan($dbMaster);
$shopPlan->select(cmIdCheck(constant("shopPlan::keyName")), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$shopPlan->setByKey($shopPlan->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$shopPlan->setPost();
$shopPlan->check();

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelPriceType = new hotelPriceType($dbMaster);
$hotelPriceType->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$ShopAccess = new ShopAccess($dbMaster);
$ShopAccess->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

//エリア指定
$mArea = new mArea($dbMaster);
$mArea->select();
$mArea->setPost();

$mAreaTop = new mArea($dbMaster);
$mAreaTop->selectTop();
$mAreaTop->setPost();

$mAreaParent = new mArea($dbMaster);
$mAreaParent->selectParent();
$mAreaParent->setPost();

$mAreaChild = new mArea($dbMaster);
$mAreaChild->selectChild();
$mAreaChild->setPost();


//カテゴリ指定
$mActivityCategory = new mActivityCategory($dbMaster);
$mActivityCategory->select();
$mActivityCategory->setPost();

$mActivityCategoryTop = new mActivityCategory($dbMaster);
$mActivityCategoryTop->selectTop();
$mActivityCategoryTop->setPost();

$mActivityCategoryParent = new mActivityCategory($dbMaster);
$mActivityCategoryParent->selectParent();
$mActivityCategoryParent->setPost();

$mActivityCategoryChild = new mActivityCategory($dbMaster);
$mActivityCategoryChild->selectChild();
$mActivityCategoryChild->setPost();

$mActivityCategoryDetail = new mActivityCategoryDetail($dbMaster);
$mActivityCategoryDetail->select();
$mActivityCategoryDetail->setPost();

//タグ
$mTag = new mTag($dbMaster);
$mTag->select($collection);
$mTag->setPost();
//print_r($mTag);

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

// if ($shopPlan->getCount() == 1) {
// 	$hotelType = new hotelType($dbMaster);
// 	$hotelType->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), $shopPlan->getKeyValue());
// }

if ($shopPlan->getByKey($shopPlan->getKeyValue(), "regist") and $shopPlan->getErrorCount() <= 0) {
	if (!$shopPlan->save()) {
		$shopPlan->setErrorFirst("プランの作成に失敗しました。");
		$shopPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($shopPlan->getByKey($shopPlan->getKeyValue(), "delete") and $shopPlan->getErrorCount() <= 0) {
	if (!$shopPlan->delete()) {
		$shopPlan->setErrorFirst("プランの削除に失敗しました。");
		$shopPlan->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$inputs = new inputs();
$inputsOnly = new inputs(true);


//print_r($hotel)."★";

//print_r($hotelRoom)."☆";

//print_r($hotelPriceType)."★";



?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>プラン｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />

	<?php //プランタイプによって項目表示分け ?>

	<script type="text/javascript">

	$(function() {
	    $('input[type=radio]').change(function() {
	        $('#standard_plan,#ticket').removeClass('invisible');
	 
	        if ($("input:radio[name='SHOPPLAN_FLG']:checked").val() == "1") {
	            $('#ticket').addClass('invisible');
	        } else if($("input:radio[name='SHOPPLAN_FLG']:checked").val() == "2") {
	            $('#standard_plan').addClass('invisible');
	        } 
	    }).trigger('change'); //←(1)
	});


	<?php if (($shopPlan->getByKey($shopPlan->getKeyValue(), "regist") or $shopPlan->getByKey($shopPlan->getKeyValue(), "delete")) and $shopPlan->getErrorCount() <= 0) {?>
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
   		if($("#HOTELPLAN_FLG_DAYUSE2").attr('checked')){
   			$("#HOTELPLAN_NIGHTS_FLG12").attr("checked","checked");
   			$("#HOTELPLAN_NIGHTS_FLG22").attr("checked","checked");
   			$("#HOTELPLAN_NIGHTS_FLG12").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_FLG22").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_FLG11").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_FLG21").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_NUM1").attr('value',0);
   			$("#HOTELPLAN_NIGHTS_NUM2").attr('value',0);
   			$("#HOTELPLAN_NIGHTS_NUM1").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_NUM2").attr('disabled',true);
   		}
   		$("#HOTELPLAN_FLG_DAYUSE2").click(function(){
   			$("#HOTELPLAN_NIGHTS_FLG12").attr("checked","checked");
   			$("#HOTELPLAN_NIGHTS_FLG22").attr("checked","checked");
   			$("#HOTELPLAN_NIGHTS_FLG12").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_FLG22").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_FLG11").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_FLG21").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_NUM1").attr('value',0);
   			$("#HOTELPLAN_NIGHTS_NUM2").attr('value',0);
   			$("#HOTELPLAN_NIGHTS_NUM1").attr('disabled',true);
   			$("#HOTELPLAN_NIGHTS_NUM2").attr('disabled',true);
   	   	});
   		$("#HOTELPLAN_FLG_DAYUSE1").click(function(){
   			$("#HOTELPLAN_NIGHTS_FLG12").attr('disabled',false);
   			$("#HOTELPLAN_NIGHTS_FLG22").attr('disabled',false);
   			$("#HOTELPLAN_NIGHTS_FLG11").attr('disabled',false);
   			$("#HOTELPLAN_NIGHTS_FLG21").attr('disabled',false);
   			$("#HOTELPLAN_NIGHTS_NUM1").attr('disabled',false);
   			$("#HOTELPLAN_NIGHTS_NUM2").attr('disabled',false);

   			$("#HOTELPLAN_NIGHTS_FLG11").attr("checked","checked");
   			$("#HOTELPLAN_NIGHTS_FLG21").attr("checked","checked");
   	   	});

   		if($("#HOTELPLAN_QUESTION_REC").attr('checked'))  $("#HOTELPLAN_DEMAND").attr('checked',true);
   		if(!$("#HOTELPLAN_QUESTION_REC").attr('checked'))  $("#HOTELPLAN_DEMAND").attr('checked',false);
   		$("#HOTELPLAN_QUESTION_REC").click(function(){
   			if(!$("#HOTELPLAN_QUESTION_REC").attr('checked')) {
   				$("#HOTELPLAN_QUESTION_REC").attr('checked',false);
   				$("#HOTELPLAN_DEMAND").attr('checked',false);
   			}
   	   	});
//   		$("#HOTELPLAN_DEMAND").click(function(){
//   			if($("#HOTELPLAN_DEMAND").attr('checked')){
//   	   			$("#HOTELPLAN_QUESTION_REC").attr('checked',true);
//   			}
//   			
//   	   	});
   	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>プラン 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "regist") and $shopPlan->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputPlan.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>