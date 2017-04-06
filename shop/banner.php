<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mBannerplace.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$mBannerplace = new mBannerplace($dbMaster);
$mBannerplace->select("", 1);

$banner = new banner($dbMaster);
$banner->select("", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), "", true);
$banner->setPost();
$banner->check($mBannerplace);


if ($banner->getByKey($banner->getKeyValue(), "regist") and $banner->getErrorCount() <= 0) {
	if (!$banner->save()) {
		$banner->setErrorFirst("広告バナー情報の保存に失敗しました。");
		$banner->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}

$inputs = new inputs(true);
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>広告バナー情報｜<?=SITE_SLAKER_NAME?></title>
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
				<div class="manageMenu circle">

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frmSearch" name="frmSearch"></form>

					<h2>広告バナー情報</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_AD") != 1) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>広告バナー情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>


					<?php
					if ($mBannerplace->getCount() > 0) {
					?>
					<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
						<?php
						foreach ($mBannerplace->getCollection() as $data) {
						?>
						<tr>
							<th valign="top">
								<p><?php print $data["M_BANNER_PLACE_NAME"]?></p>
							</th>
							<td align="left">
								<table class="inner" cellspacing="5">
									<tr>
										<td valign="top">画像 <span class="colorRed">※</span></td>
										<td>
										<?=$inputs->image("BANNER_PIC", $banner->getByKey($data["M_BANNER_PLACE_ID"], "BANNER_PIC"), $data["M_BANNER_PLACE_SIZE_W"], $data["M_BANNER_PLACE_SIZE_H"], $data["M_BANNER_PLACE_SIZE_C"], "")?>
										</td>
									</tr>
									<tr>
										<td valign="top">画像(マウスオーバー)</td>
										<td>
										<?=$inputs->image("BANNER_PIC_HOVER", $banner->getByKey($data["M_BANNER_PLACE_ID"], "BANNER_PIC_HOVER"), $data["M_BANNER_PLACE_SIZE_W"], $data["M_BANNER_PLACE_SIZE_H"], $data["M_BANNER_PLACE_SIZE_C"], "")?>
										</td>
									</tr>
									<tr>
										<td valign="top">リンク先URL <span class="colorRed">※</span></td>
										<td><?php print $banner->getByKey($data["M_BANNER_PLACE_ID"], "BANNER_URL")?></td>
									</tr>
									<tr>
										<td valign="top">ALT表示内容 <span class="colorRed">※</span></td>
										<td><?php print $banner->getByKey($data["M_BANNER_PLACE_ID"], "BANNER_ALT")?></td>
									</tr>
									<tr>
										<td valign="top">ステータス</td>
										<td>
											<?php
											if ($banner->getByKey($data["M_BANNER_PLACE_ID"], "BANNER_ID") != "") {
												print cmFlgPublicStatus($banner->getByKey($data["M_BANNER_PLACE_ID"], "BANNER_STATUS"));
											}
											else {
												print "未登録";
											}
											?>
										</td>
									</tr>
									<?php if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
									<tr>
										<td valign="top" colspan="2">
											<a href="bannerEdit.html?id=<?php print $banner->getByKey($data["M_BANNER_PLACE_ID"], "BANNER_ID");?>&key=<?php print $data["M_BANNER_PLACE_ID"];?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle ")?></a>
										</td>
									</tr>
									<?php }?>
								</table>
							</td>
						</tr>
						<?php
						}
						?>
					</table>
					<?php
					}
					?>

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