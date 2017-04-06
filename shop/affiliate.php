<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliate.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$affiliate = new affiliate($dbMaster);
$affiliate->select("", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), true);
$affiliate->setPost();
$affiliate->check($mBannerplace);
$affiliate->setByKey($affiliate->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

if ($affiliate->getByKey($affiliate->getKeyValue(), "regist") and $affiliate->getErrorCount() <= 0) {
	if (!$affiliate->save()) {
		$affiliate->setErrorFirst("アフィリエイト情報の保存に失敗しました。");
		$affiliate->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}


if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
	//	契約満了
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
	if ($affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_STATUS") == 3) {
		//	編集不可
		$inputs = new inputs(true);
	}
	else {
		$inputs = new inputs();
	}
}

$xmlAffiliate = new xml(XML_AFFILIATE_CATEGORY);
$xmlAffiliate->load();
if (!$xmlAffiliate->getXml()) {
	$affiliate->setErrorFirst("カテゴリデータの読み込みに失敗しました");
}

$xmlAffiliateDetail = new xml(XML_AFFILIATE_CATEGORY_DETAIL);
$xmlAffiliateDetail->load();
if (!$xmlAffiliateDetail->getXml()) {
	$affiliate->setErrorFirst("詳細カテゴリデータの読み込みに失敗しました");
}

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

					<h2>アフィリエイト情報</h2>
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

						<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
							<?php
								if ($affiliate->getByKey($affiliate->getKeyValue(), "regist") and $affiliate->getErrorCount() <= 0) {
							?>
							<script type="text/javascript">
							$().toastmessage( 'showToast', {
								inEffectDuration:500,
								text:"保存完了しました。",
								type:"success",
								sticky: false,
								position:"middle-center"
							});
							</script>
							<?php
									require("includes/box/affiliate/input.php");
								}
								else {
									require("includes/box/affiliate/input.php");
								}
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