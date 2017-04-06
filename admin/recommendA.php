<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/recommendA.php');

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

$collection2 = new collection($dbMaster);

$inputs = new inputs();


if ($collection->getByKey($collection->getKeyValue(), "search")) {
}
else {
	$collection->setByKey($collection->getKeyValue(), "RECMMEND_A_STATUS1", 1);
	$collection->setByKey($collection->getKeyValue(), "RECMMEND_A_STATUS2", 2);
}

$recommendA = new recommendA($dbMaster);
$recommendA->selectList($collection);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>お勧め情報(アクティビティ)一覧｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">

	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:650,
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
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="お勧め情報(アクティビティ)一覧" title="お勧め情報(アクティビティ)一覧" width="40" height="40"  /></td>
							<td valign="middle"><h2>お勧め情報(アクティビティ)一覧</h2></td>
						</tr>
					</table>
				</div>

				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="30"><p>ID</p></th>
							<th><p>店舗名</p></th>
							<th width="70"><p>ｽﾃｰﾀｽ</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($recommendA->getCount() > 0) {?>
							<?php foreach ($recommendA->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["RECMMEND_A_STATUS"] == 3) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["RECMMEND_A_ID"]?></td>
							<td <?=$rclass?>><?=$ad["ACTIVITY_SHOPNAME"]?></td>
							<td <?=$rclass?>>
								<?php
								$st = "";
								if ($ad["RECMMEND_A_STATUS"] == 1) {
									$st = "表示";
								}
								if ($ad["RECMMEND_A_STATUS"] == 2) {
									$st = "非表示";
								}
								if ($ad["RECMMEND_A_STATUS"] == 3) {
									$st = "削除";
								}
								?>
								<?=$st?>
							</td>
							<td <?=$rclass?> align="center"><a href="recommendAEdit.html?id=<?=$ad["RECMMEND_A_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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
					<a href="recommendAEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しいお勧め情報","circle longButton")?></a>
					<a href="recommendAOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","並び替え","circle longButton")?></a>

				<div class="actions circle">
					<h2>表示切り替え</h2>
					<table cellspacing="10">
						<tr>
							<td>
								<p><a href="recommendG.html">グルメ情報</a></p>
							</td>
						</tr>
						<tr>
							<td>
								<a href="recommendA.html">アクティビティ情報</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="recommendH.html">ホテル情報</a>
							</td>
						</tr>
					</table>
				</div>
				<div class="actions circle">
					<h2>検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">ID</td>
								<td>
									<?=$inputs->text("RECMMEND_A_ID",$collection->getByKey($collection->getKeyValue(),"RECMMEND_A_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>店舗名</td>
								<td>
									<?=$inputs->text("GOURMET_SHOPNAME",$collection->getByKey($collection->getKeyValue(),"GOURMET_SHOPNAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>お勧めﾀｲﾄﾙ</td>
								<td>
									<?=$inputs->text("RECMMEND_A_TITLE",$collection->getByKey($collection->getKeyValue(),"RECMMEND_A_TITLE"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php //$op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("RECMMEND_A_STATUS1","RECMMEND_A_STATUS1",1,$collection->getByKey($collection->getKeyValue(), "RECMMEND_A_STATUS1")," 表示", "", $op)?>&nbsp;
								<?=$inputs->checkbox("RECMMEND_A_STATUS2","RECMMEND_A_STATUS2",2,$collection->getByKey($collection->getKeyValue(), "RECMMEND_A_STATUS2")," 非表示", "", $op)?>&nbsp;<br />
								<?=$inputs->checkbox("RECMMEND_A_STATUS3","RECMMEND_A_STATUS3",3,$collection->getByKey($collection->getKeyValue(), "RECMMEND_A_STATUS3")," 削除済", "", $op)?>&nbsp;
								</td>
							</tr>
						</table>
						<ul class="buttons">
							<li><?=$inputs->submit("","search","検索", "circle")?></li>
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