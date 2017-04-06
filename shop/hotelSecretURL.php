<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setPost();

function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}

function passport_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}

$url = URL_PUBLIC."plan-detail-secret.html?id=".$_GET["id"]."&rid=".$_GET["rid"]."&cid=".$_GET["cid"];

$key = $_GET["cid"].$_GET["id"].$_GET["rid"];

$secretURL = $url."&key=".passport_encrypt($key, $key);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<?php require("includes/box/common/meta.php"); ?>
<title>プラン｜<?=SITE_SLAKER_NAME?></title>
<meta name="description" content="" />
<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
<script type="text/javascript">
LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>プランURLの取得</h2>
		<div id="contentsPop" class="circle">
			<a href="<?=$secretURL?>" target="_blank"><?=$secretURL?></a>
		</div>
		<br />
	</div>
</body></html>