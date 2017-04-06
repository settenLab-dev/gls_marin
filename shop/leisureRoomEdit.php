<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select(cmIdCheck(constant("hotelRoom::keyName")), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelRoom->setByKey($hotelRoom->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelRoom->setPost();
$hotelRoom->check();

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//  echo $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_BREADTH");exit;

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
	<title>在庫タイプ｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") or $hotelRoom->getByKey($hotelRoom->getKeyValue(), "delete")) and $hotelRoom->getErrorCount() <= 0) {?>
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
</head>
<body id="">
	<div id="containerPop">
		<h2>在庫タイプ 編集</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data" id="frmSearch" name="frmSearch">
				<?php
					if ($hotelRoom->getByKey($hotelRoom->getKeyValue(), "regist") and $hotelRoom->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/actreserv/inputRoom.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>