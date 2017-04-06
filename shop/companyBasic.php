<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mContract.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$mContract = new mContract($dbMaster);
$mContract->selectList($collection);

$company = new company($dbMaster);
$company->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$company->setPost();
$company->setByKey($company->getKeyValue(), "COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM, $company->getByKey($company->getKeyValue(), "COMPANY_LOGIN_PASSWORD"));
$company->check();

if ($company->getByKey($company->getKeyValue(), "regist") and $company->getErrorCount() <= 0) {
	if (!$company->save()) {
		$company->setErrorFirst("店舗基本情報の保存に失敗しました。");
		$company->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($company->getByKey($company->getKeyValue(), "regist")){
}
else {
}


	$inputs = new inputs();
	$inputsOnly = new inputs(true);
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>契約情報｜<?=SITE_SLAKER_NAME?></title>
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
				<?php require("includes/box/common/menuCompany.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">

					<h2>契約情報</h2>
					<?php
					if ($company->getByKey($company->getKeyValue(), "COMPANY_STATUS") != 2) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>現在この情報は閲覧、編集ができなくなっています。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<?php
							if ($company->getByKey($company->getKeyValue(), "regist") and $company->getErrorCount() <= 0) {
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
								require("includes/box/company/inputBasic.php");
							}
							else {
								require("includes/box/company/inputBasic.php");
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