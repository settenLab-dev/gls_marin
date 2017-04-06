<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mContract.php');

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

$mContract = new mContract($dbMaster);
$mContract->selectList($collection);

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>契約プランマスター｜<?=SITE_SLAKER_NAME?></title>
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
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="契約プランマスター" title="契約プランマスター" width="40" height="40"  /></td>
							<td valign="middle"><h2>契約プランマスター</h2></td>
						</tr>
					</table>
				</div>


				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="50"><p>ID</p></th>
							<th><p>プラン名</p></th>
							<th><p>機能</p></th>
							<th width="80"><p>金額</p></th>
							<th width="50"><p>月数</p></th>
							<th width="60"><p>ｽﾃｰﾀｽ</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($mContract->getCount() > 0) {?>
							<?php foreach ($mContract->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["M_CONTRACT_STATUS"] == 3) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["M_CONTRACT_ID"]?></td>
							<td <?=$rclass?>><?=$ad["M_CONTRACT_NAME"]?></td>
							<td <?=$rclass?>>
								<?php
								$func = "";
								if ($ad["M_CONTRACT_FUNC_AD"] == 1) {
									$func = "[ﾊﾞﾅｰ]";
								}
								if ($ad["M_CONTRACT_FUNC_GURUME"] == 1) {
									$func .= "[ｸﾞﾙﾒ]";
								}
								if ($ad["M_CONTRACT_FUNC_ACT"] == 1) {
									$func .= "[ｱｸﾃｨﾋﾞﾃｨ]";
								}
								if ($ad["M_CONTRACT_FUNC_AFI"] == 1) {
									$func .= "[ｱﾌｨﾘｴｲﾄ]";
								}
								if ($ad["M_CONTRACT_FUNC_HOTEL"] == 1) {
									$func .= "[ﾎﾃﾙ]";
								}
								print $func;
								?>
							</td>
							<td <?=$rclass?>><?=number_format($ad["M_CONTRACT_PAY"])?>円</td>
							<td <?=$rclass?>><?=$ad["M_CONTRACT_TERM"]?>か月</td>
							<td <?=$rclass?>><?=cmFlgPublicStatus($ad["M_CONTRACT_STATUS"])?></td>
							<td <?=$rclass?> align="center"><a href="mstContractEdit.html?id=<?=$ad["M_CONTRACT_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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

				<a href="mstContractEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい契約プラン","circle longButton")?></a>
				<a href="mstContractOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","並び替える","circle longButton")?></a>

				<div class="actions circle">
					<h2>検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="60">ID</td>
								<td>
									<?=$inputs->text("M_CONTRACT_ID",$collection->getByKey($collection->getKeyValue(),"M_CONTRACT_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>プラン名</td>
								<td>
									<?=$inputs->text("M_CONTRACT_NAME",$collection->getByKey($collection->getKeyValue(),"M_CONTRACT_NAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php $op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("M_CONTRACT_STATUS1","M_CONTRACT_STATUS1",1,$collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS1")," 公開中", "", $op)?>&nbsp;
								<?=$inputs->checkbox("M_CONTRACT_STATUS2","M_CONTRACT_STATUS2",2,$collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS2")," 非公開", "", $op)?>&nbsp;
								<?=$inputs->checkbox("M_CONTRACT_STATUS3","M_CONTRACT_STATUS3",3,$collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS3")," 削除済", "", $op)?>&nbsp;
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