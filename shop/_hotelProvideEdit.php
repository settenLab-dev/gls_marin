<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$rID = "";
if ($_GET["r"] != "") {
	$rID = $_GET["r"];
}
elseif ($_POST["ROOM_ID"] != "") {
	$rID = $_POST["ROOM_ID"];
}

$hotelPlan = new hotelPlan($dbMaster);
$hotelPlan->select(cmKeyCheck(constant("hotelPlan::keyName")), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select($rID, "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelPay = new hotelPay($dbMaster);

$hotelPayUsed = new hotelPay($dbMaster);


if ($hotelPlan->getCount() != 1) {
	$hotelPlan->setErrorFirst("プランの取得に失敗しました。");
}
elseif ($hotelRoom->getCount() != 1) {
	$hotelRoom->setErrorFirst("部屋タイプの取得に失敗しました。");
}
else {

	$hotelPay->select(cmIdCheck(constant("hotelPay::keyName")), $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), cmKeyCheck(constant("hotelPlan::keyName")), $rID);
	$hotelPay->setByKey($hotelPay->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

	//	部屋の合計部屋数
	$date = $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE");
	$time = strtotime($date);
	$w = date("w", $time);
	$max = intval($hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM".($w+1)));

	//	使用中の部屋数
	$hotelPayUsed->selectRoomUsed($rID, $date);
// 	print_r($hotelPayUsed->getCollection());
	$used = intval($hotelPayUsed->getByKey($hotelPayUsed->getKeyValue(), "use_num"));

	//	現在の部屋数
	$nowUsed = $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_ROOM_NUM");
}

$hotelPay->setPost();
$hotelPay->checkOnly($max-$used+$nowUsed);

if ($hotelPay->getByKey($hotelPay->getKeyValue(), "regist") and $hotelPay->getErrorCount() <= 0) {
	if (!$hotelPay->saveOnly()) {
		$hotelPay->setErrorFirst("料金設定の保存に失敗しました。");
		$hotelPay->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelPay->getByKey($hotelPay->getKeyValue(), "delete") and $hotelPay->getErrorCount() <= 0) {
	if (!$hotelPay->delete()) {
		$hotelPay->setErrorFirst("料金設定の削除に失敗しました。");
		$hotelPay->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
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
	<?php if (($hotelPay->getByKey($hotelPay->getKeyValue(), "regist") or $hotelPay->getByKey($hotelPay->getKeyValue(), "delete")) and $hotelPay->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>部屋数調整</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelPlan->getErrorCount() > 0) {
						print create_error_caption($hotelPlan->getError());
					}
					elseif ($hotelRoom->getErrorCount() > 0) {
						print create_error_caption($hotelRoom->getError());
					}
					else {
						if ($hotelPay->getByKey($hotelPay->getKeyValue(), "regist") and $hotelPay->getErrorCount() <= 0) {
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