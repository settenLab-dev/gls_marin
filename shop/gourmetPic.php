<?php
require_once('includes/applicationInc.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/groumet.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPic.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/gourmetPicGroup.php');
$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$groumet = new groumet($dbMaster);
$groumet->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$groumet->setPost();
$groumet->setByKey($groumet->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


$gourmetPic = new gourmetPic($dbMaster);
$gourmetPic->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$gourmetPicGroup = new gourmetPicGroup($dbMaster);
$gourmetPicGroup->select("", "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
	//	契約満了
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
	$inputs = new inputs();
	$disabled = '';
}
}

$inputsOnly = new inputs(true);
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>グルメ画像登録｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
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
				<?php require("includes/box/common/menuGourmet.php");?>


			<div id="colLeft">
				<div class="manageMenu circle">
				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>グルメ画像設定</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_GURUME") != 1) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>ホテル情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							require("includes/box/gourmet/listPic.php");
						?>
					</form>
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