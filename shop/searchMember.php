<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection2 = new collection($dbMaster);
$collection2->setPost();

$member = new member($dbMaster);
$member->selectList($collection);

if ($collection2->getByKey($collection2->getKeyValue(), "regist")) {
	$memberTarget = new member($dbMaster);
	$memberTarget->select($collection2->getByKey($collection2->getKeyValue(), "MEMBER_ID"));
	if ($memberTarget->getCount() != 1) {
		$collection2->setErrorFirst("会員の取得に失敗しました。");
	}
}

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
	<?php if (($collection2->getByKey($collection2->getKeyValue(), "regist") or $collection2->getByKey($collection2->getKeyValue(), "delete")) and $collection2->getErrorCount() <= 0) {?>

	var a = new Array();
	<?php
	foreach ($memberTarget->getCollection() as $data) {
		foreach ($data as $k=>$v) {
	?>
	a['<?php print $k?>'] = '<?php print $v?>';
	<?php
		}
	}
	?>

	window.opener.memberset(a);
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
		<h2>会員選択</h2>
		<div id="contentsPop" class="circle">

			<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
				<tr>
					<td valign="top">
						<p>会員選択</p>
						<?php if ($collection2->getErrorCount() > 0) {?>
						<?php print create_error_caption($collection2->getError())?>
						<?php }?>

						<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="100%">
							<thead>
								<tr>
									<th width="50"><p>選択</p></th>
									<th><p>氏名</p></th>
									<th><p>TEL</p></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($member->getCount() > 0) {?>
									<?php foreach ($member->getCollection() as $ad) {?>
								<tr>
									<td>
										<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
											<?=$inputs->submit("","regist","選択", "circle")?>
											<?=$inputs->hidden("MEMBER_ID",$ad["MEMBER_ID"])?>
										</form>
									</td>
									<td><?php print $ad["MEMBER_NAME1"]." ".$ad["MEMBER_NAME2"]?></td>
									<td><?php print $ad["MEMBER_TEL1"]?></td>
								</tr>
									<?php }?>
								<?php }else {?>
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