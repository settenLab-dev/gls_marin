<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPicGroup.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

/*
if ($_GET["divide"] == 2) {
	$hotel = new hotelRoom($dbMaster);
	$hotel->select(cmKeyCheck(constant("hotelRoom::keyName")), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
}
else {
	$hotel = new hotel($dbMaster);
	$hotel->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
}
$hotel->setPost();
$hotel->check();
*/

$hotelPic = new hotelPic($dbMaster);
$hotelPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$hotelPic->setPost();

$hotelPicGroup = new hotelPicGroup($dbMaster);
$hotelPicGroup->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

// if ($hotel->getByKey($hotel->getKeyValue(), "regist") and $hotel->getErrorCount() <= 0) {
// 	if (!$hotel->savePic($hotel->getByKey($hotel->getKeyValue(), "pic"), $hotel->getByKey($hotel->getKeyValue(), "target"))) {
// 		$hotel->setErrorFirst("ホテル画像の変更に失敗しました。");
// 		$hotel->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
// 	}
// }
// else {
// }

$inputs = new inputs();
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ホテル画像｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelPic->getByKey($hotelPic->getKeyValue(), "regist") or $hotelPic->getByKey($hotelPic->getKeyValue(), "delete")) and $hotelPic->getErrorCount() <= 0) {?>
	window.opener.$("#<?php print $_GET["id"]?>_setup").val("<?php print $hotelPic->getByKey($hotelPic->getKeyValue(), "pic")?>");
	window.close();
	<?php }?>

	$(document).ready(function(){
		$("#sortList")
		.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>ホテル画像 編集</h2>
		<div id="contentsPop" class="circle">

			<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
				<tr>
					<td valign="top">
						<p>選択可能画像</p>
						<?php if ($hotelPic->getErrorCount() > 0) {?>
						<?php print create_error_caption($hotelPic->getError())?>
						<?php }?>

						<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="100%">
							<thead>
								<tr>
									<th width="50"><p>選択</p></th>
									<th><p>画像</p></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($hotelPic->getCount() > 0) {?>
									<?php foreach ($hotelPic->getCollection() as $ad) {?>
								<tr>
									<td>
										<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
											<?=$inputs->submit("","regist","この画像を設定する", "circle")?>
											<?=$inputs->hidden("pic",$ad["HOTELPIC_DATA"])?>
											<?=$inputs->hidden("target",$_GET["id"])?>
										</form>
									</td>
									<td><?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></td>
								</tr>
									<?php }?>
								<?php }else {?>
									<tr>
										<td>設定可能な画像がありません。</td>
									</tr>
								<?php }?>
							</tbody>
						</table>
						<div id="pager" class="pager">
							<form>
								<div class="paging">
									<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/first.png" class="first"/>
									<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/prev.png" class="prev"/>
									<input type="text" class="pagedisplay bgLightGrey circle" readonly="readonly" />
									<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/next.png" class="next"/>
									<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/last.png" class="last"/>
								</div>
								<select class="pagesize circle">
									<option selected="selected"  value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option  value="40">40</option>
								</select>
							</form>
						</div>

					</td>
				</tr>
			</table>

		</div>
		<br />
	</div>
</body>
</html>