<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);

$member = new member($dbMaster);
$member->select(cmIdCheck(constant("member::keyName")));
$member->setByKey($member->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$member->setPost();
$member->check();

if ($member->getByKey($member->getKeyValue(), "regist") and $member->getErrorCount() <= 0) {
	if (!$member->save()) {
		$member->setErrorFirst("会員の作成に失敗しました。");
		$member->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($member->getByKey($member->getKeyValue(), "delete")) {
	if (!$member->delete()) {
		$member->setErrorFirst("会員の削除に失敗しました。");
		$member->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
	if ($member->getByKey($member->getKeyValue(), "MEMBER_LOGIN_PASSWORD") != "") {
		$member->setByKey($member->getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, $member->getByKey($member->getKeyValue(), "MEMBER_LOGIN_PASSWORD"));
	}
}

$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>会員編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($member->getByKey($member->getKeyValue(), "regist")  and $member->getErrorCount() <= 0) {?>
	window.close();
	<?php }elseif ($member->getByKey($member->getKeyValue(), "delete")) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
</head>
<body id="">
<?php /*
	<div id="headerPop">
		<h1><img src="<?=URL_SLAKER_COMMON?>assets/header/logo.png" alt="<?=SITE_NAME?>" width="106" height="29" /></h1>
	</div>
*/?>
	<div id="containerPop">
				<h2>会員</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($member->getByKey($member->getKeyValue(), "regist") and $member->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/member/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>