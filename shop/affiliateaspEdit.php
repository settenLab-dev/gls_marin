<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliateasp.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$member = new member($dbMaster);
$member->select(cmKeyCheck(constant("member::keyName")));

$affiliateasp = new affiliateasp($dbMaster);
$affiliateasp->select(cmIdCheck(constant("affiliateasp::keyName")), "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$affiliateasp->setByKey($affiliateasp->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$affiliateasp->setPost();
$affiliateasp->checkUpdate();

if ($affiliateasp->getByKey($affiliateasp->getKeyValue(), "regist") and $affiliateasp->getErrorCount() <= 0) {
	if (!$affiliateasp->save()) {
		$affiliateasp->setErrorFirst("アフィリエイト情報の保存に失敗しました。");
		$affiliateasp->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>成約情報 編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($affiliateasp->getByKey($affiliateasp->getKeyValue(), "regist") or $affiliateasp->getByKey($affiliateasp->getKeyValue(), "delete")) and $affiliateasp->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>成約情報</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
				<?php
					if ($affiliateasp->getCount() != 1) {
						print "成約情報がみつかりませんでした。";
					}
					else {
						if ($affiliateasp->getByKey($affiliateasp->getKeyValue(), "regist") and $affiliateasp->getErrorCount() <= 0) {
						}
						else {
							require("includes/box/affiliate/inputAsp.php");
						}
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>