<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');

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

$admin_conf = new admin($dbMaster);
$admin_conf->selectList($collection);
//print_r($admin);

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>運営者一覧｜<?=SITE_SLAKER_NAME?></title>
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
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="運営者一覧" title="運営者一覧" width="40" height="40"  /></td>
							<td valign="middle"><h2>運営者一覧</h2></td>
						</tr>
					</table>
				</div>

				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="80"><p>ID</p></th>
							<th><p>氏名</p></th>
							<th><p>ﾒｰﾙｱﾄﾞﾚｽ</p></th>
							<th><p>権限</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($admin_conf->getCount() > 0) {?>
							<?php foreach ($admin_conf->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["ADMIN_STATUS"] == 2) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["ADMIN_ID"]?></td>
							<td <?=$rclass?>><?=$ad["ADMIN_NAME"]?></td>
							<td <?=$rclass?>><?=$ad["ADMIN_LOGIN_MAILADDRESS"]?></td>
							<td <?=$rclass?>>
								<?php if($ad["ADMIN_LEVEL1"] == 1){ print "・契約情報<br />"; }
									if($ad["ADMIN_LEVEL2"] == 1){ print "・会員情報<br />"; }
									if($ad["ADMIN_LEVEL3"] == 1){ print "・コンテンツ管理<br />"; }
									if($ad["ADMIN_LEVEL4"] == 1){ print "・クライアント管理<br />"; }
									if($ad["ADMIN_LEVEL5"] == 1){ print "・レポート管理<br />"; }
									if($ad["ADMIN_LEVEL6"] == 1){ print "・請求管理<br />"; }
									if($ad["ADMIN_LEVEL7"] == 1){ print "・基本設定"; }
								?>
							</td>
							<td <?=$rclass?> align="center"><a href="mstAdminEdit.html?id=<?=$ad["ADMIN_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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
					<a href="mstAdminEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい運営者","circle longButton")?></a>

				<div class="actions circle">
					<h2>検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td>ID</td>
								<td>
									<?=$inputs->text("ADMIN_ID",$collection->getByKey($collection->getKeyValue(),"ADMIN_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>氏名</td>
								<td>
									<?=$inputs->text("ADMIN_NAME",$collection->getByKey($collection->getKeyValue(),"ADMIN_NAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>mail</td>
								<td>
									<?=$inputs->text("ADMIN_LOGIN_MAILADDRESS",$collection->getByKey($collection->getKeyValue(),"ADMIN_LOGIN_MAILADDRESS"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php $op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("ADMIN_STATUS","ADMIN_STATUS","delete",$collection->getByKey($collection->getKeyValue(), "ADMIN_STATUS")," 削除済も表示する", "", $op)?>&nbsp;
								</td>
							</tr>
						</table>
						<ul class="buttons">
							<li><?=$inputs->submit("","login","検索", "circle")?></li>
							<?php /*
							<li><a href="mstAdminEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい運営者","circle")?></a></li>
							*/?>
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