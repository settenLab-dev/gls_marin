<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmet.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPicGroup.php');

$dbMaster = new dbMaster();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setPost();

$gourmetPicGroup = new gourmetPicGroup($dbMaster);
$gourmetPicGroup->select("", "1", cmIdCheck(constant("gourmet::keyName")));


if ($collection->getByKey($collection->getKeyValue(), "GOURMETPICGROUP_ID") == "") {
	if ($gourmetPicGroup->getCount() > 0) {
		foreach ($gourmetPicGroup->getCollection() as $d) {
			$collection->setByKey($collection->getKeyValue(), "GOURMETPICGROUP_ID", $d["GOURMETPICGROUP_ID"]);
			break;
		}
	}
}

$gourmetPic = new gourmetPic($dbMaster);
$gourmetPic->select("", "1,2", cmIdCheck(constant("gourmet::keyName")), $collection->getByKey($collection->getKeyValue(), "GOURMETPICGROUP_ID"));
$gourmetPic->setByKey($gourmetPic->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("gourmet::keyName")));
$gourmetPic->setPost();


if ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "regist") and $gourmetPic->getErrorCount() <= 0) {
	if (!$gourmetPic->saveOrder()) {
		$gourmetPic->setErrorFirst("ホテル写真の並び替えに失敗しました。");
		$gourmetPic->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<title>ホテル写真 並び替え｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "regist") and $gourmetPic->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>ホテル写真 並び替え</h2>
		<p>並び替えるデータをドラッグして移動して下さい。</p>
		<div id="contentsPop" class="circle">
			<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<table cellspacing="10">
					<tr>
						<td>
							<?php $op = 'onchange="document.frmSearch.submit();"';?>
							<?php if ($gourmetPicGroup->getCount() > 0) {?>
							<select name="GOURMETPICGROUP_ID" class="circle" <?php print $op;?>>
								<option value="">---</option>
								<option value="-1" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-1)?'selected="selected"':''?>>部屋</option>
								<option value="-2" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-2)?'selected="selected"':''?>>食事</option>
								<option value="-3" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-3)?'selected="selected"':''?>>館内施設</option>
								<option value="-4" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-4)?'selected="selected"':''?>>風景</option>
								<option value="-5" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-5)?'selected="selected"':''?>>その他</option>
								<?php
								$selectd = '';
								foreach ($gourmetPicGroup->getCollection() as $data) {
									$selectd = '';
									if ($collection->getByKey($collection->getKeyValue(), "GOURMETPICGROUP_ID") == $data["GOURMETPICGROUP_ID"]) {
										$selectd = 'selected="selected"';
									}
								?>
								<option value="<?php print $data["GOURMETPICGROUP_ID"]?>" <?php print $selectd?>><?php print $data["GOURMETPICGROUP_NAME"]?></option>
								<?php }?>
							</select>
							<?php }?>
						</td>
					</tr>
				</table>
			</form>

			<?php if ($gourmetPic->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "regist") and $gourmetPic->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/gourmet/orderPic.php");
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