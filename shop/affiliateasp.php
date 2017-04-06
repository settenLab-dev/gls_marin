<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliateasp.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(),  "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setByKey($collection->getKeyValue(),  "AFFILIATEASP_STATUS2", 2);

$affiliateasp = new affiliateasp($dbMaster);
$affiliateasp->selectList($collection);
$affiliateasp->setPost();
$affiliateasp->check($mBannerplace);
$affiliateasp->setByKey($affiliateasp->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

// if ($affiliateasp->getByKey($affiliateasp->getKeyValue(), "regist") and $affiliateasp->getErrorCount() <= 0) {
// 	if (!$affiliateasp->save()) {
// 		$affiliateasp->setErrorFirst("アフィリエイト情報の保存に失敗しました。");
// 		$affiliateasp->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
// 	}
// }
// else {
// }



$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>アフィリエイト情報｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
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
		<?php
			require("includes/box/common/header.php");
		?>
		<div id="contents">
			<div id="contentsData" class="circle">
				<?php require("includes/box/common/mainMenu.php");?>
				<?php require("includes/box/common/menuAffiliate.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frmSearch" name="frmSearch"></form>

					<h2>成約会員一覧</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_AFI") != 1) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>アフィリエイト情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

						<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="100%">
							<thead>
								<tr>
									<th width="50"><p>ID</p></th>
									<th width="50"><p>会員ID</p></th>
									<th><p>氏名</p></th>
									<th><p>ﾒｰﾙｱﾄﾞﾚｽ</p></th>
									<th width="50"><p>成約日</p></th>
									<th width="50"><p>編集</p></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($affiliateasp->getCount() > 0) {?>
									<?php foreach ($affiliateasp->getCollection() as $ad) {?>
									<?php
									$rclass = '';
									if ($ad["ADMIN_STATUS"] == 2) {
										$rclass = 'class="bgLightGrey"';
									}
									?>
								<tr>
									<td <?=$rclass?>><?=$ad["AFFILIATEASP_ID"]?></td>
									<td <?=$rclass?>><?=$ad["MEMBER_ID"]?></td>
									<td <?=$rclass?>><?=$ad["MEMBER_NAME1"]?> <?=$ad["MEMBER_NAME2"]?></td>
									<td <?=$rclass?>><?=$ad["MEMBER_LOGIN_ID"]?></td>
									<td <?=$rclass?>><?=$ad["AFFILIATEASP_DATE_CONTATS"]?></td>
									<td <?=$rclass?> align="center"><a href="affiliateaspEdit.html?id=<?=$ad["AFFILIATEASP_ID"]?>&key=<?=$ad["MEMBER_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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


					<?php
					}
					?>
				</div>
				<br />

			</div>
			<div id="colRight">
				<?php require("includes/box/common/account.php");?>
			</div>
			<br class="clearfix" />

			</div>
		</div>
		<?php require("includes/box/common/footer.php");?>
	</div>
</body>
</html>