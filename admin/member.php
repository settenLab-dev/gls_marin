<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
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

$admin = new admin($dbMaster);
$admin->select($sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));



$collection2 = new collection($dbMaster);
$mContract = new mContract($dbMaster);
$mContract->selectList($collection2);

if ($collection->getByKey($collection->getKeyValue(), "search")) {
}
else {
	$collection->setByKey($collection->getKeyValue(), "MEMBER_STATUS1", 1);
	$collection->setByKey($collection->getKeyValue(), "MEMBER_STATUS2", 2);
}

$member = new member($dbMaster);
$member->selectList($collection);

$inputs = new inputs();



?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>会員一覧｜<?=SITE_SLAKER_NAME?></title>
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
		windowCallUnload2:
		{
			height:400,
			width:550,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		}
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
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="会員一覧" title="会員一覧" width="40" height="40"  /></td>
							<td valign="middle"><h2>会員一覧</h2></td>
						</tr>
					</table>
				</div>

				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="30"><p>ID</p></th>
							<th><p>会員名</p></th>
							<th><p>ﾒｰﾙｱﾄﾞﾚｽ</p></th>
							<th width="60"><p>tel</p></th>
							<th width="80"><p>ﾎﾟｲﾝﾄ履歴</p></th>
							<th width="70"><p>ｽﾃｰﾀｽ</p></th>
							<th width="50"><p>登録日</p></th>
							<th width="50"><p>更新日</p></th>
							<th width="50"><p>編集</p></th>
							<th width="50"><p>P追加</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($member->getCount() > 0) {?>
							<?php foreach ($member->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["MEMBER_STATUS"] == 4) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["MEMBER_ID"]?></td>
							<td <?=$rclass?>><?=$ad["MEMBER_NAME1"]." ".$ad["MEMBER_NAME2"]?></td>
							<td <?=$rclass?>><?=$ad["MEMBER_LOGIN_ID"]?></td>
							<td <?=$rclass?>><?=$ad["MEMBER_TEL1"]?></td>
							<td <?=$rclass?> align="right">
								<?php if (intval($ad["MEMBER_POINT"]) <= 0) {?>
								0
								<?php }else{?>
								<a href="pointHistory.html?id=<?php print $ad["MEMBER_ID"]?>" class="popup" rel="windowCallUnload"><?=intval($ad["MEMBER_POINT"])?></a>
								<?php }?>
							</td>
							<td <?=$rclass?>>
								<?php
								$st = "";
								if ($ad["MEMBER_STATUS"] == 1) {
									$st = "仮登録";
								}
								if ($ad["MEMBER_STATUS"] == 2) {
									$st = "登録済";
								}
								if ($ad["MEMBER_STATUS"] == 3) {
									$st = "退会";
								}
								if ($ad["MEMBER_STATUS"] == 4) {
									$st = "削除";
								}
								?>
								<?=$st?>
							</td>
							<td <?=$rclass?>><?=$ad["MEMBER_DATE_REGIST"]?></td>
							<td <?=$rclass?>><?=$ad["MEMBER_DATE_UPDATE"]?></td>
							<td <?=$rclass?> align="center"><a href="memberEdit.html?id=<?=$ad["MEMBER_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
							<td <?=$rclass?> align="center"><a href="pointEdit.html?id=<?=$ad["MEMBER_ID"]?>" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","P","circle")?></a></td>
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
					<a href="memberEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい会員","circle longButton")?></a>

				<div class="actions circle">
					<h2>検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">ID</td>
								<td>
									<?=$inputs->text("MEMBER_ID",$collection->getByKey($collection->getKeyValue(),"MEMBER_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>会員名</td>
								<td>
									<?=$inputs->text("MEMBER_NAME",$collection->getByKey($collection->getKeyValue(),"MEMBER_NAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>会員カナ</td>
								<td>
									<?=$inputs->text("MEMBER_NAME_KANA",$collection->getByKey($collection->getKeyValue(),"MEMBER_NAME_KANA"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>mail</td>
								<td>
									<?=$inputs->text("MEMBER_LOGIN_ID",$collection->getByKey($collection->getKeyValue(),"MEMBER_LOGIN_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php //$op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("MEMBER_STATUS1","MEMBER_STATUS1",1,$collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS1")," 仮登録", "", $op)?>&nbsp;
								<?=$inputs->checkbox("MEMBUS2","MEMBER_STATUS2",2,$collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS2")," 登録済み", "", $op)?>&nbsp;<br />
								<?=$inputs->checkbox("MEMBER_STATUS3","MEMBER_STATUS3",3,$collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS3")," 退会", "", $op)?>&nbsp;
								<?=$inputs->checkbox("MEMBER_STATUS4","MEMBER_STATUS4",4,$collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS4")," 削除済", "", $op)?>&nbsp;
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