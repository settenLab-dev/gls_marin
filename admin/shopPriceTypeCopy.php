<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelPriceTypeOrigin = new hotelPriceType($dbMaster);
$hotelPriceTypeOrigin->select(cmIdCheck(constant("hotelPriceType::keyName")), "1", cmIdCheck(constant("shop::keyName")));

$hotelPriceType = new hotelPriceType($dbMaster);
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("shop::keyName")));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_NAME", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_NAME"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_DISCRITION", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_DISCRITION"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_CAPACITY_FROM", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_CAPACITY_FROM"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_CAPACITY_TO", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_CAPACITY_TO"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_TYPE", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_TYPE"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_FEATURE_LIST", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_FEATURE_LIST"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_FEATURE_LIST2", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_FEATURE_LIST2"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_FEATURE_LIST3", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_FEATURE_LIST3"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_BREADTH", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_BREADTH"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_PET_FLG", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_PET_FLG"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_PET_LIST", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_PET_LIST"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_YEAR_FROM", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_YEAR_FROM"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_MONTH_FROM", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_MONTH_FROM"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_DAY_FROM", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_DAY_FROM"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_YEAR_TO", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_YEAR_TO"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_MONTH_TO", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_MONTH_TO"));
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_DAY_TO", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_DAY_TO"));
for ($i=1; $i<=7; $i++) {
	$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_NUM".$i, $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_NUM".$i));
}
for ($i=1; $i<=4; $i++) {
	$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_PIC".$i, $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_PIC".$i));
	$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_PIC_DISCRIPTION".$i, $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_PIC_DISCRIPTION".$i));
}
$hotelPriceType->setByKey($hotelPriceType->getKeyValue(), "ROOM_STATUS", $hotelPriceTypeOrigin->getByKey($hotelPriceTypeOrigin->getKeyValue(), "ROOM_STATUS"));
$hotelPriceType->setPost();
$hotelPriceType->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", cmIdCheck(constant("shop::keyName")));

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
	<title>料金タイプ｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") or $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "delete")) and $hotelPriceType->getErrorCount() <= 0) {?>
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
		}
	};

	function unloadcallback() {
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>料金タイプ 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "regist") and $hotelPriceType->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/inputRoom.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>