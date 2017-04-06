<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/groumet.php');

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
$groumet->checkBasic();

if ($groumet->getByKey($groumet->getKeyValue(), "regist") and $groumet->getErrorCount() <= 0) {

	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_LNG") == "" and $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_LAT") == "") {
		$ar = cmGetPrefName();
		$pref  = $ar[$groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_PREF_ID")];
		$city = $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_CITY");
		$latlng = cmGetLatLng($pref.$city.$groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_ADDRESS"), SITE_GOOGLE_SHOP);
		if ($latlng) {
			list($lng,$lat) = explode(',',$latlng);
		}
		else {
			$lng = "";
			$lat = "";
		}
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_BASIC_LNG", $lng);
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_BASIC_LAT", $lat);
	}

	if (!$groumet->save()) {
		$groumet->setErrorFirst("店舗基本情報の保存に失敗しました。");
		$groumet->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($groumet->getByKey($groumet->getKeyValue(), "regist")){
}
else {
	//	セッションからの初期値
	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_SHOPNAME") == "") {
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_SHOPNAME", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_NAME")." ".$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_SHOP_NAME"));
	}
	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_ZIP") == "") {
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_BASIC_ZIP", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ZIP"));
	}
	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_PREF_ID") == "") {
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_BASIC_PREF_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "PREF_ID"));
	}
	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_CITY") == "") {
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_BASIC_CITY", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_CITY"));
	}
	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_ADDRESS") == "") {
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_BASIC_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ADDRESS"));
	}
	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_TEL") == "") {
		$groumet->setByKey($groumet->getKeyValue(), "GOURMET_BASIC_TEL", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_TEL1"));
	}
}

if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
	//	契約満了
	$inputs = new inputs(true);
}
else {
	if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") == 3) {
		//	編集不可
		$inputs = new inputs(true);
	}
	else {
		$inputs = new inputs();
	}
}
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>グルメ情報｜<?=SITE_SLAKER_NAME?></title>
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
				<?php require("includes/box/common/menuGourmet.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">

					<h2>店舗の基本情報</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_GURUME") != 1) {
						//	グルメ情報設定可否
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>グルメ情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<?php
							if ($groumet->getByKey($groumet->getKeyValue(), "regist") and $groumet->getErrorCount() <= 0) {
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
								require("includes/box/gourmet/inputBasic.php");
							}
							else {
								require("includes/box/gourmet/inputBasic.php");
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