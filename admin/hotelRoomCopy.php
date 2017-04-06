<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelRoomOrigin = new hotelRoom($dbMaster);
$hotelRoomOrigin->select(cmIdCheck(constant("hotelRoom::keyName")), "1", cmKeyCheck(constant("hotel::keyName")));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "COMPANY_ID", cmKeyCheck(constant("hotel::keyName")));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_NAME", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_NAME"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_DISCRITION", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_DISCRITION"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_FROM", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_CAPACITY_FROM"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_TO", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_CAPACITY_TO"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_TYPE", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_TYPE"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_FEATURE_LIST", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_FEATURE_LIST"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_FEATURE_LIST2", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_FEATURE_LIST2"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_FEATURE_LIST3", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_FEATURE_LIST3"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_BREADTH", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_BREADTH"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_PET_FLG", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_PET_FLG"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_PET_LIST", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_PET_LIST"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_YEAR_FROM", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_YEAR_FROM"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_MONTH_FROM", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_MONTH_FROM"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_DAY_FROM", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_DAY_FROM"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_YEAR_TO", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_YEAR_TO"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_MONTH_TO", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_MONTH_TO"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_DAY_TO", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_DAY_TO"));
for ($i=1; $i<=7; $i++) {
	$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_NUM".$i, $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_NUM".$i));
}
for ($i=1; $i<=4; $i++) {
	$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_PIC".$i, $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_PIC".$i));
	$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_PIC_DISCRIPTION".$i, $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_PIC_DISCRIPTION".$i));
}
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "ROOM_STATUS", $hotelRoomOrigin->getByKey($hotelRoomOrigin->getKeyValue(), "ROOM_STATUS"));
$hotelRoom->setPost();
$hotelRoom->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") and $hotelRoom->getErrorCount() <= 0) {
	if (!$hotelRoom->save()) {
		$hotelRoom->setErrorFirst("ホテル画像の作成に失敗しました。");
		$hotelRoom->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "delete") and $hotelRoom->getErrorCount() <= 0) {
	if (!$hotelRoom->delete()) {
		$hotelRoom->setErrorFirst("ホテル画像の削除に失敗しました。");
		$hotelRoom->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>ホテル部屋タイプ｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") or $hotelRoom->getByKey($hotelRoom->getKeyValue(), "delete")) and $hotelRoom->getErrorCount() <= 0) {?>
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
		<h2>ホテル部屋タイプ 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") and $hotelRoom->getErrorCount() <= 0) {
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