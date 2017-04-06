<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
$dbMaster = new dbMaster();


$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$admin = new admin($dbMaster);
$admin->select($sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ダッシュボード｜<?=SITE_SLAKER_NAME?></title>
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

			<div id="colLeft">
				<?php
				//	管理メニュー
				?>
				<div class="manageMenu circle">
					<table cellspacing="15">
						<tr>
						<td><?php print SITE_PUBLIC_NAME;?>へようこそ！</td>
						</tr>
					</table>
				</div>
				<br />
				<?php /*
				<div class="manageMenu circle">
					<table cellspacing="15">
						<tr>
							<td align="center"><a href="site.html"><img src="<?=URL_SLAKER_COMMON?>assets/top/shop.png" alt="サイト一覧" width="50" height="50" /></a><br />サイト一覧</td>
							<td align="center"><a href="siteadmin.html"><img src="<?=URL_SLAKER_COMMON?>assets/top/account.png" alt="サイト管理者" width="50" height="50" /></a><br />ｻｲﾄ管理者</td>
							<td align="center"><a href="product.html"><img src="<?=URL_SLAKER_COMMON?>assets/top/girl.png" alt="商品" width="50" height="50" /></a><br />商品</td>
							<td align="center"><a href="movie.html"><img src="<?=URL_SLAKER_COMMON?>assets/top/scout.png" alt="動画" width="50" height="50" /></a><br />動画</td>
						</tr>
					</table>
				</div>
				<br />
				*/?>

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