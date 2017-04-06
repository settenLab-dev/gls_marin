<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategory.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategoryDetail.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mActivityCategoryDetail = new mActivityCategoryDetail($dbMaster);
$mActivityCategoryDetail->select(cmIdCheck(constant("mActivityCategoryDetail::keyName")));
$mActivityCategoryDetail->setByKey($mActivityCategoryDetail->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$mActivityCategoryDetail->setPost();
$mActivityCategoryDetail->check();

$mActivityCategoryChild = new mActivityCategory($dbMaster);
$mActivityCategoryChild->selectChild();
$mActivityCategoryChild->setPost();



if ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "regist") and $mActivityCategoryDetail->getErrorCount() <= 0) {
	if (!$mActivityCategoryDetail->save()) {
		$mActivityCategoryDetail->setErrorFirst("アクティビティカテゴリ詳細の作成に失敗しました。");
		$mActivityCategoryDetail->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "delete") and $mActivityCategoryDetail->getErrorCount() <= 0) {
	if (!$mActivityCategoryDetail->delete()) {
		$mActivityCategoryDetail->setErrorFirst("アクティビティカテゴリ詳細の削除に失敗しました。");
		$mActivityCategoryDetail->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$inputs = new inputs();


$xmlCategory = new xml(XML_ACTIVITY_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$mActivityCategoryDetail->setErrorFirst("アクティビティカテゴリデータの読み込みに失敗しました");
}

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>アクティビティカテゴリ詳細編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "regist") or $mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "delete")) and $mActivityCategoryDetail->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>アクティビティカテゴリ詳細マスタ</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "regist") and $mActivityCategoryDetail->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/mActivityCategoryDetail/input.php");
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>