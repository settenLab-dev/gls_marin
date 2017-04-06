<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$date = "";
if ($_GET["date"] != "") {
	$date = $_GET["date"];
}
elseif ($_POST["date"] != "") {
	$date = $_POST["date"];
}

// $hotelPlan = new hotelPlan($dbMaster);
// $hotelPlan->select(cmKeyCheck(constant("hotelPlan::keyName")), "1,2", cmIdCheck(constant("hotelProvide::keyName")));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select(cmKeyCheck("ROOM_ID"), "1", cmAdCheck(constant("hotelRoom::keyName")));

$hotelProvide = new hotelProvide($dbMaster);
$hotelProvide->select(cmIdCheck("HOTELPROVIDE_ID"), cmAdCheck(constant("Room::keyName")), cmKeyCheck("ROOM_ID"));

$nowUsed = $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_NUM");

$hotelProvide->setPost();
if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_DATE") == "") {
	$hotelProvide->setByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_DATE", $date);
}
$hotelProvide->setByKey($hotelProvide->getKeyValue(), "ROOM_ID", cmKeyCheck("ROOM_ID"));
$hotelProvide->setByKey($hotelProvide->getKeyValue(), "COMPANY_ID", cmAdCheck(constant("hotelRoom::keyName")));

$hotelProvide->check();

if ($hotelRoom->getCount() != 1) {
	$hotelRoom->setErrorFirst("部屋タイプの取得に失敗しました。");
}
else {
}

if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "regist") and $hotelProvide->getErrorCount() <= 0) {
	if (!$hotelProvide->save()) {
		$hotelProvide->setErrorFirst("料金設定の保存に失敗しました。");
		$hotelProvide->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "delete") and $hotelProvide->getErrorCount() <= 0) {
	if (!$hotelProvide->delete()) {
		$hotelProvide->setErrorFirst("料金設定の削除に失敗しました。");
		$hotelProvide->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
	if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST") == "") {
		$hotelProvide->setByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST", 2);
	}
}

$inputs = new inputs();

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>部屋数調整｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelProvide->getByKey($hotelProvide->getKeyValue(), "regist") or $hotelProvide->getByKey($hotelProvide->getKeyValue(), "delete")) and $hotelProvide->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');

	$(function() {
   		if($("#HOTELPROVIDE_FLG_REQUEST1").attr('checked')){
   			$("#HOTELPROVIDE_NUM").attr('disabled',true);
   			$("#HOTELPROVIDE_NUM").attr('value','');
   		}
   		$("#HOTELPROVIDE_FLG_REQUEST1").click(function(){
   			$("#HOTELPROVIDE_NUM").attr('disabled',true);
   			$("#HOTELPROVIDE_NUM").attr('value','');
   	   	});
   		$("#HOTELPROVIDE_FLG_REQUEST2").click(function(){
   			$("#HOTELPROVIDE_NUM").attr('disabled',false);
   	   	})
   	});
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>部屋数調整</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelRoom->getErrorCount() > 0) {
						print create_error_caption($hotelRoom->getError());
					}
					else {
						if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "regist") and $hotelProvide->getErrorCount() <= 0) {
						}
						else {
							require("includes/box/hotel/inputProvide.php");
						}
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>