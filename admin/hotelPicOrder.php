<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPicGroup.php');

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

$hotelPicGroup = new hotelPicGroup($dbMaster);
$hotelPicGroup->select("", "1", cmIdCheck(constant("hotel::keyName")));


if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_ID") == "") {
	if ($hotelPicGroup->getCount() > 0) {
		foreach ($hotelPicGroup->getCollection() as $d) {
			$collection->setByKey($collection->getKeyValue(), "HOTELPICGROUP_ID", $d["HOTELPICGROUP_ID"]);
			break;
		}
	}
}

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", cmIdCheck(constant("hotel::keyName")), $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_ID"));
$hotelPic->setByKey($hotelPic->getKeyValue(), "COMPANY_ID", cmIdCheck(constant("hotel::keyName")));
$hotelPic->setPost();


if ($hotelPic->getByKey($hotelPic->getKeyValue(), "regist") and $hotelPic->getErrorCount() <= 0) {
	if (!$hotelPic->saveOrder()) {
		$hotelPic->setErrorFirst("ホテル写真の並び替えに失敗しました。");
		$hotelPic->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
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
	<?php if ($hotelPic->getByKey($hotelPic->getKeyValue(), "regist") and $hotelPic->getErrorCount() <= 0) {?>
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
							<?php if ($hotelPicGroup->getCount() > 0) {?>
							<select name="HOTELPICGROUP_ID" class="circle" <?php print $op;?>>
								<option value="">---</option>
								<option value="-1" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-1)?'selected="selected"':''?>>部屋</option>
								<option value="-2" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-2)?'selected="selected"':''?>>食事</option>
								<option value="-3" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-3)?'selected="selected"':''?>>館内施設</option>
								<option value="-4" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-4)?'selected="selected"':''?>>風景</option>
								<option value="-5" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-5)?'selected="selected"':''?>>その他</option>
								<?php
								$selectd = '';
								foreach ($hotelPicGroup->getCollection() as $data) {
									$selectd = '';
									if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_ID") == $data["HOTELPICGROUP_ID"]) {
										$selectd = 'selected="selected"';
									}
								?>
								<option value="<?php print $data["HOTELPICGROUP_ID"]?>" <?php print $selectd?>><?php print $data["HOTELPICGROUP_NAME"]?></option>
								<?php }?>
							</select>
							<?php }?>
						</td>
					</tr>
				</table>
			</form>

			<?php if ($hotelPic->getCount() > 0) {?>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?php
					if ($hotelPic->getByKey($hotelPic->getKeyValue(), "regist") and $hotelPic->getErrorCount() <= 0) {
					}
					else {
						require("includes/box/hotel/orderPic.php");
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