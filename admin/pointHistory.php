<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/pointHistory.php');

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
$collection->setByKey($collection->getKeyValue(),  "MEMBER_ID", cmIdCheck("MEMBER_ID"));

$pointHistory = new pointHistory($dbMaster);
$pointHistory->selectList($collection);


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ポイント履歴｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:550,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		},
	};

	function unloadcallback() {
		document.frmSearch.submit();
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});

   	$(document).ready(function(){
		$("#sortList")
		.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body>
	<div id="containerPop">


					<h2>ポイント履歴</h2>
<br />
						<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="100%">
							<thead>
								<tr>
									<th width="50"><p>ID</p></th>
									<th><p>区分</p></th>
									<th><p>サービス名</p></th>
									<th><p>ﾎﾟｲﾝﾄ</p></th>
									<th width="50"><p>ｽﾃｰﾀｽ</p></th>
									<th width="50"><p>付与日</p></th>
									<?php /*
									<th width="50"><p>編集</p></th>
									*/?>
								</tr>
							</thead>
							<tbody>
								<?php if ($pointHistory->getCount() > 0) {?>
									<?php foreach ($pointHistory->getCollection() as $ad) {?>
									<?php
									$rclass = '';
									if ($ad["POINT_HISTORY_STATUS"] == 3) {
										$rclass = 'class="bgLightGrey"';
									}
									?>
								<tr>
									<td <?=$rclass?>><?=$ad["POINT_HISTORY_ID"]?></td>
									<td <?=$rclass?>>
										<?php
										if ($ad["POINT_HISTORY_DIVIDE"] == 1) {
											print "アフィリエイト";
										}
										if ($ad["POINT_HISTORY_DIVIDE"] == 2) {
											print "ホテル";
										}
										if ($ad["POINT_HISTORY_DIVIDE"] == 3) {
											print "管理より";
										}
										?>
									</td>
									<td <?=$rclass?>><?=$ad["POINT_HISTORY_NAME"]?></td>
									<td <?=$rclass?>><?=$ad["POINT_HISTORY_NUM"]?></td>
									<td <?=$rclass?>>
										<?php
										if ($ad["POINT_HISTORY_STATUS"] == 1) {
											print "有効";
										}
										if ($ad["POINT_HISTORY_STATUS"] == 2) {
											print "期限切れ";
										}
										?>
									</td>
									<td <?=$rclass?>><?=$ad["POINT_HISTORY_DATE_REGIST"]?></td>
									<?php /*
									<td <?=$rclass?> align="center"><a href="pointHistoryEdit.html?id=<?=$ad["AFFILIATEASP_ID"]?>&key=<?=$ad["MEMBER_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
									*/?>
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


	</div>
</body>
</html>