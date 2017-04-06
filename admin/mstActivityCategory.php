<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategory.php');

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

$mActivityCategory = new mActivityCategory($dbMaster);
$mActivityCategory->selectList($collection);

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>アクティビティカテゴリマスター｜<?=SITE_SLAKER_NAME?></title>
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
	<div id="container">
		<?php require("includes/box/common/header.php");?>

		<div id="contents">
			<div id="contentsData" class="circle">

			<?php require("includes/box/common/mainMenu.php");?>
			<?php require("includes/box/common/mstMenu.php");?>

			<div id="colLeft">
				<div class="datalistHeader circle">
					<table cellspacing="0" border="0" width="100%">
						<tr>
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="アクティビティカテゴリマスター" title="アクティビティカテゴリマスター" width="40" height="40"  /></td>
							<td valign="middle"><h2>アクティビティカテゴリマスター</h2></td>
						</tr>
					</table>
				</div>


				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="50"><p>ID</p></th>
							<th width="50"><p>エリア<br />タイプ</p></th>
							<th><p>名称</p></th>
							<th><p>URL</p></th>
							<th width="100"><p>ステータス</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($mActivityCategory->getCount() > 0) {?>
							<?php foreach ($mActivityCategory->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["M_ACT_CATEGORY_STATUS"] == 3) {
								$rclass = 'class="bgLightGrey"';
							}
							if ($ad["M_ACT_CATEGORY_TYPE"] == 1) {
								$rclass = 'style="background:#ffe6ea;"';
							}
							if ($ad["M_ACT_CATEGORY_TYPE"] == 2) {
								$rclass = 'style="background:#e6f2ff;"';
							}
							if ($ad["M_ACT_CATEGORY_TYPE"] == 3) {
								$rclass = 'style="background:#ffffe0;"';
							}

							?>
						<tr>
							<td <?=$rclass?>><?=$ad["M_ACT_CATEGORY_ID"]?></td>
							<td <?=$rclass?>>
								<?php if($ad["M_ACT_CATEGORY_TYPE"] == "1"){ print "TOP"; }
								elseif($ad["M_ACT_CATEGORY_TYPE"] == "2"){ print "親"; }
								elseif($ad["M_ACT_CATEGORY_TYPE"] == "3"){ print "子"; }?>
							
							</td>
							<td <?=$rclass?>><?=$ad["M_ACT_CATEGORY_NAME"]?></td>
							<td <?=$rclass?>><?=$ad["M_ACT_CATEGORY_URL"]?></td>
							<td <?=$rclass?>><?=cmFlgPublicStatus($ad["M_ACT_CATEGORY_STATUS"])?></td>
							<td <?=$rclass?> align="center"><a href="mstActivityCategoryEdit.html?id=<?=$ad["M_ACT_CATEGORY_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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

				<a href="mstActivityCategoryEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しいアクティビティカテゴリ","circle longButton")?></a>
				<a href="mstActivityCategoryOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","並び替える","circle longButton")?></a>

				<div class="actions circle">
					<h2>検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="60">ID</td>
								<td>
									<?=$inputs->text("M_ACT_CATEGORY_ID",$collection->getByKey($collection->getKeyValue(),"M_ACT_CATEGORY_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>名称</td>
								<td>
									<?=$inputs->text("M_ACT_CATEGORY_NAME",$collection->getByKey($collection->getKeyValue(),"M_ACT_CATEGORY_NAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>URL</td>
								<td>
									<?=$inputs->text("M_ACT_CATEGORY_URL",$collection->getByKey($collection->getKeyValue(),"M_ACT_CATEGORY_URL"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php $op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("M_ACT_CATEGORY_STATUS1","M_ACT_CATEGORY_STATUS1",1,$collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_STATUS1")," 公開中", "", $op)?>&nbsp;
								<?=$inputs->checkbox("M_ACT_CATEGORY_STATUS2","M_ACT_CATEGORY_STATUS2",2,$collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_STATUS2")," 非公開", "", $op)?>&nbsp;
								<?=$inputs->checkbox("M_ACT_CATEGORY_STATUS3","M_ACT_CATEGORY_STATUS3",3,$collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_STATUS3")," 削除済", "", $op)?>&nbsp;
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