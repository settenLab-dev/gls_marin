<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelPriceType = new hotelPriceType($dbMaster);
$hotelPriceType->select(cmKeyCheck(constant("hotelPriceType::keyName")), "1", cmIdCheck(constant("hotelPriceType::keyName")));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("hotelPriceType::keyName")));
$hotelPriceType->setPost();
$hotelPriceType->check();


if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") and $hotelPriceType->getErrorCount() <= 0) {
	if (!$hotelPriceType->save()) {
		$hotelPriceType->setErrorFirst("料金タイプの作成に失敗しました。");
		$hotelPriceType->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "delete") and $hotelPriceType->getErrorCount() <= 0) {
	if (!$hotelPriceType->delete()) {
		$hotelPriceType->setErrorFirst("料金タイプの削除に失敗しました。");
		$hotelPriceType->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$inputs = new inputs();
$inputsOnly = new inputs(true);


?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>料金タイプの登録｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") or $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "delete")) and $hotelPriceType->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	</script>
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
		}
	};

	function unloadcallback() {
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>



	<?php //料金タイプの種類によって表示分け ?>

	<script type="text/javascript">
	$(function() {
	    $('input[type=radio]').change(function() {
	        $('#person,#group').removeClass('invisible');
	 
	        if ($("input:radio[name='SHOP_PRICETYPE_KIND']:checked").val() == "1") {
	            $('#group').addClass('invisible');
	        } else if($("input:radio[name='SHOP_PRICETYPE_KIND']:checked").val() == "2") {
	            $('#person').addClass('invisible');
	        } 
	    }).trigger('change'); //←(1)
	});
	</script>

</head>
<body id="">
	<div id="containerPop">
		<h2>料金タイプ 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data" id="frmSearch" name="frmSearch">
				<?php
					if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") and $hotelPriceType->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputPriceType.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>