<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/groumet.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/coupon.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$coupon = new coupon($dbMaster);
$coupon->select("", "", cmIdCheck(constant("groumet::keyName")), 1);


$groumet = new groumet($dbMaster);
$groumet->select(cmIdCheck(constant("groumet::keyName")));
$groumet->setPost();
$groumet->check();


if ($coupon->getCount() > 0) {
	foreach ($coupon->getCollection() as $da) {
		$i = $da["COUPON_ORDER"];
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_ID".$i, $da["COUPON_ID"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_NAME".$i, $da["COUPON_NAME"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_PAY".$i, $da["COUPON_PAY"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_CONTENT".$i, $da["COUPON_CONTENT"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_DATE_FROM".$i, $da["COUPON_DATE_FROM"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_DATE_TO".$i, $da["COUPON_DATE_TO"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_MEMO".$i, $da["COUPON_MEMO"]);
		$coupon->setByKey($coupon->getKeyValue(), "COUPON_STATUS".$i, $da["COUPON_STATUS"]);
	}
}

$coupon->setPost();
$coupon->setByKey("COMPANY_ID", "COMPANY_ID", cmIdCheck(constant("groumet::keyName")));
$coupon->setByKey("COUPON_FLG_TARGET", "COUPON_FLG_TARGET", 1);
$coupon->check();

if ($groumet->getByKey($groumet->getKeyValue(), "regist") and $groumet->getErrorCount() <= 0  and $coupon->getErrorCount() <= 0) {
	if (!$groumet->save()) {
		$groumet->setErrorFirst("アカウントの保存に失敗しました。");
		$groumet->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
	else {
		if (!$coupon->save()) {
			$coupon->setErrorFirst("クーポン情報の保存に失敗しました。");
			$coupon->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
}
elseif ($groumet->getByKey($groumet->getKeyValue(), "delete") and $groumet->getErrorCount() <= 0) {
	if (!$groumet->delete()) {
		$groumet->setErrorFirst("アカウントの削除に失敗しました。");
		$groumet->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$inputs = new inputs();
$inputsOnly = new inputs(true);


$xmlCategory = new xml(XML_GOURMET_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$groumet->setErrorFirst("カテゴリデータの読み込みに失敗しました");
}

$xmlCategoryDetail = new xml(XML_GOURMET_CATEGORY_DETAIL);
$xmlCategoryDetail->load();
if (!$xmlCategoryDetail->getXml()) {
	$groumet->setErrorFirst("詳細カテゴリデータの読み込みに失敗しました");
}

$xmlFeature = new xml(XML_FEATURE);
$xmlFeature->load();
if (!$xmlFeature->getXml()) {
	$groumet->setErrorFirst("特徴データの読み込みに失敗しました");
}

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$groumet->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$xmlRecomCategory = new xml(XML_RECOM_CATEGORY);
$xmlRecomCategory->load();
if (!$xmlRecomCategory->getXml()) {
	$groumet->setErrorFirst("お勧めカテゴリデータの読み込みに失敗しました");
}

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>グルメ情報編集｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($groumet->getByKey($groumet->getKeyValue(), "regist") or $groumet->getByKey($groumet->getKeyValue(), "delete")) and $groumet->getErrorCount() <= 0   and $coupon->getErrorCount() <= 0) {?>
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

			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($groumet->getByKey($groumet->getKeyValue(), "regist") and $groumet->getErrorCount() <= 0   and $coupon->getErrorCount() <= 0) {
					}
					else {
				?>
				<?php if ($groumet->getErrorCount() > 0) {?>
					<div class="error"><p>グルメ情報にエラーが見つかりました。 </p></div>
					<br />
				<?php }?>
				<?php if ($coupon->getErrorCount() > 0) {?>
					<div class="error"><p>クーポン情報にエラーが見つかりました。 </p></div>
					<br />
				<?php }?>
				<?php
						require("includes/box/gourmet/inputBasic.php");
						require("includes/box/gourmet/inputCategory.php");
						require("includes/box/gourmet/inputList.php");
						require("includes/box/gourmet/inputMain.php");
						require("includes/box/gourmet/inputCoupon.php");
						require("includes/box/gourmet/inputPublic.php");
					}
				?>

				<br />
				<ul class="buttons">
					<li><?=$inputs->submit("","regist","グルメ情報を保存する", "circle")?></li>
					<li>　　　　　<a href="http://cocotomo.net/gourmet-detail-prev.html?id=<?php print $groumet->getByKey($groumet->getKeyValue(),"COMPANY_ID") ?>" target="blank" rel="windowCallUnload3">
						<?=$inputs->button("","","プレビュー表示","circle")?></a></li>
				</ul>
			</form>

	</div>
</body>
</html>