<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/pointHistory.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$member = new member($dbMaster);
$member->select(cmIdCheck(constant("member::keyName")));
$member->setPost();

$pointHistory = new pointHistory($dbMaster);
$pointHistory->setByKey($pointHistory->getKeyValue(), "POINT_HISTORY_DIVIDE", 3);
$pointHistory->setByKey($pointHistory->getKeyValue(), "POINT_HISTORY_STATUS", 1);
$pointHistory->setByKey($pointHistory->getKeyValue(), "MEMBER_ID", $member->getByKey($member->getKeyValue(), "MEMBER_ID"));
$pointHistory->setByKey($pointHistory->getKeyValue(), "POINT_HISTORY_NUM", $member->getByKey($member->getKeyValue(), "POINT_HISTORY_NUM"));
$pointHistory->setByKey($pointHistory->getKeyValue(), "POINT_HISTORY_NAME", $member->getByKey($member->getKeyValue(), "POINT_HISTORY_NAME"));

if ($member->getByKey($member->getKeyValue(), "regist") and $member->getErrorCount() <= 0) {
	if (!$member->savePoint($pointHistory)) {
		$member->setErrorFirst("アフィリエイト情報の保存に失敗しました。");
		$member->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>ポイント付与｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($member->getByKey($member->getKeyValue(), "regist") or $member->getByKey($member->getKeyValue(), "delete")) and $member->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>ポイント付与</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
				<?php
					if ($member->getCount() != 1) {
						print "成約情報がみつかりませんでした。";
					}
					else {
						if ($member->getByKey($member->getKeyValue(), "regist") and $member->getErrorCount() <= 0) {
						}
						else {
							require("includes/box/member/inputPoint.php");
						}
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>