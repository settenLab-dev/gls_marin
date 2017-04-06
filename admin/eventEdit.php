<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/event.php');
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/eventPic.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();


require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$event = new event($dbMaster);
$event->select(cmIdCheck(constant("event::keyName")));

	$event->setPost();

$event->setByKey($event->getKeyValue(), "EVENT_ID", cmIdCheck(constant("event::keyName")));

// if ($event->getByKey($event->getKeyValue(), "check_none") == "") {
// }
$event->check();

if ($event->getByKey($event->getKeyValue(), "regist") and $event->getErrorCount() <= 0) {
	if (!$event->save()) {
		$event->setErrorFirst("イベント情報の保存に失敗しました。");
		$event->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($event->getByKey($event->getKeyValue(), "regist")){
}
else {
}


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$event->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
$disabled = '';

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>イベント情報編集｜<?=SITE_SLAKER_NAME?></title>
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
<body id="">
	<div id="containerPop">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
				<?php
					if ($event->getByKey($event->getKeyValue(), "regist") and $event->getErrorCount() <= 0) {
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
					require("includes/box/event/inputBasic.php");
				?>
			</form>

	</div>
</body>
</html>