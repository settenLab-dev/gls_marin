<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/activity.php');

$dbMaster = new dbMaster();

$collection = new collection($db);
$collection->setPost();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$activity = new activity($dbMaster);
$activity->selectList($collection);

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>アクティビティ情報一覧｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">

	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:850,
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
	<div id="container">
		<?php require("includes/box/common/header.php");?>
		<div id="contents">
			<div id="contentsData" class="circle">
				<?php require("includes/box/common/mainMenu.php");?>

			<div id="colLeft">

				<div class="datalistHeader circle">
					<table cellspacing="0" border="0" width="100%">
						<tr>
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="アクティビティ情報一覧" title="アクティビティ情報一覧" width="40" height="40"  /></td>
							<td valign="middle"><h2>アクティビティ情報一覧</h2></td>
						</tr>
					</table>
				</div>

				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="30"><p>ID</p></th>
							<th><p>店舗名</p></th>
							<th><p>契約ﾌﾟﾗﾝ</p></th>
							<th width="70"><p>契約満了日</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($activity->getCount() > 0) {?>
							<?php foreach ($activity->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["ACTIVITY_STATUS"] == 4) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["COMPANY_ID"]?></td>
							<td <?=$rclass?>><?=$ad["ACTIVITY_SHOPNAME"]?></td>
							<td <?=$rclass?>><?=$ad["COMPANY_CONTRACT_NAME"]?></td>
							<td <?=$rclass?>><?=$ad["COMPANY_CONTRACT_DATE_END"]?></td>
							<td <?=$rclass?> align="center"><a href="activityEdit.html?id=<?=$ad["COMPANY_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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

			<div id="colRight">
				<?php /*
					<a href="activityEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しいアクティビティ情報","circle longButton")?></a>
				*/?>

				<div class="actions circle">
					<h2>検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">ID</td>
								<td>
									<?=$inputs->text("COMPANY_ID",$collection->getByKey($collection->getKeyValue(),"COMPANY_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>店舗名</td>
								<td>
									<?=$inputs->text("ACTIVITY_SHOPNAME",$collection->getByKey($collection->getKeyValue(),"ACTIVITY_SHOPNAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php //$op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("ACTIVITY_STATUS1","ACTIVITY_STATUS1",1,$collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS1")," ".cmFlgContentsStatus(1), "", $op)?>&nbsp;
								<?=$inputs->checkbox("ACTIVITY_STATUS2","ACTIVITY_STATUS2",2,$collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS2")," ".cmFlgContentsStatus(2), "", $op)?>&nbsp;<br />
								<?=$inputs->checkbox("ACTIVITY_STATUS3","ACTIVITY_STATUS3",3,$collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS3")," ".cmFlgContentsStatus(3), "", $op)?>&nbsp;
								</td>
							</tr>
						</table>
						<ul class="buttons">
							<li><?=$inputs->submit("","login","検索", "circle")?></li>
						</ul>
					</form>
				</div>

			</div>
			<br class="clearfix" />

			</div>

		</div>
		<?php
			require("includes/box/common/footer.php");
		?>
	</div>
</body>
</html>