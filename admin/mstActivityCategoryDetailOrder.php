<?php
require_once('includes/applicationInc.php');
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
$collection = new collection($dbMaster);
$collection->setPost();

$xmlCategory = new xml(XML_ACTIVITY_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$mActivityCategoryDetail->setErrorFirst("アクティビティカテゴリデータの読み込みに失敗しました");
}

if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_ID") == "") {
	$f = $xmlCategory->getFirstData();
	$collection->setByKey($collection->getKeyValue(), "M_ACT_CATEGORY_ID", "".$f->value);
}



$mActivityCategoryDetail->select("", "1,2", $collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_ID"));
//$mActivityCategoryDetail->setByKey($mActivityCategoryDetail->getKeyValue(), "ADMIN_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));
$mActivityCategoryDetail->setPost();
//$mActivityCategoryDetail->check();

if ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "regist") and $mActivityCategoryDetail->getErrorCount() <= 0) {
	if (!$mActivityCategoryDetail->saveOrder()) {
		$mActivityCategoryDetail->setErrorFirst("アクティビティカテゴリ詳細の並び替えに失敗しました。");
		$mActivityCategoryDetail->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>アクティビティカテゴリ詳細並び替え｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "regist") and $mActivityCategoryDetail->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>アクティビティカテゴリ詳細マスタ 並び替え</h2>
		<p>並び替えるデータをドラッグして移動して下さい。</p>
		<div id="contentsPop" class="circle">

			<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<table cellspacing="10">
					<tr>
						<td>
							<?php $op = 'onchange="document.frmSearch.submit();"';?>
							<?=$inputs->selectbox("M_ACT_CATEGORY_ID", $xmlCategory->getXml(), $collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_ID"), "circle", $op)?>
						</td>
					</tr>
				</table>
			</form>

			<?php if ($mActivityCategoryDetail->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "regist") and $mActivityCategoryDetail->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/mActivityCategoryDetail/order.php");
					}
				?>
			</form>
			<?php } else {?>
			<p>データがみつかりません。</p>
			<?php }?>
		</div>
		<br />
	</div>
</body>
</html>