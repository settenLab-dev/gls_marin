<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBooking.php');
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookingcont.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

// require("includes/box/login/loginAction.php");
// if (!$sess->sessionCheck()) {
// 	require_once('includes/box/login/loginBox.php');
// 	exit;
// }

$coupon = new coupon($dbMaster);
$coupon->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

//$couponBookset = new couponBookset($dbMaster);
//$couponBookset->select($_GET['id']);
//$couponBookset->setPost();
//$couponBookset->check();

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setPost();

$booking = new couponBooking($dbMaster);
$booking->selectList($collection);
//print_r($booking);//exit;
//$bookingcont = new couponBookingcont($dbMaster);
//$bookingcont->selectList($collection);

// add by 0909
$couponPlan = new couponPlan($dbMaster);
//$couponRoom = new couponRoom($dbMaster);


if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS") == 3) {
	//	編集不可
	$inputs = new inputs(true);
	$disabled = 'disabled="disabled"';
}
else {
	$inputs = new inputs();
	$disabled = '';
}
$inputsOnly = new inputs(true);

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>クーポン購入履歴｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
	<script type="text/javascript">
	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:750,
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
				<?php require("includes/box/common/menuCoupon.php");?>

			<div id="colLeft">
				<div class="manageMenu circle">


				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>クーポン購入履歴</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_COUPON") != 1) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>クーポン情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							require("includes/box/coupon/listBooking.php");
						?>
					</form>
					<?php
					}
					?>
				</div>
				<br />

			</div>
			<div id="colRight">

				<div class="actions circle">
					<h2>検索　※現在機能調整中</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">クーポン番号</td>
								<td>
									<?=$inputs->text("COUPON_ID_NUM",$collection->getByKey($collection->getKeyValue(),"COUPON_ID_NUM"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>購入者名</td>
								<td>
									姓<?=$inputs->text("COUPONBOOK_NAME1",$collection->getByKey($collection->getKeyValue(),"COUPONBOOK_NAME1"),"imeActive circle",30)?><br/>
									名<?=$inputs->text("COUPONBOOK_NAME2",$collection->getByKey($collection->getKeyValue(),"COUPONBOOK_NAME2"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>購入者カナ</td>
								<td>
									セイ<?=$inputs->text("COUPONBOOK_KANA1",$collection->getByKey($collection->getKeyValue(),"COUPONBOOK_KANA1"),"imeActive circle",30)?><br/>
									メイ<?=$inputs->text("COUPONBOOK_KANA2",$collection->getByKey($collection->getKeyValue(),"COUPONBOOK_KANA2"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>クーポン名</td>
								<td>
									<?=$inputs->text("COUPONPLAN_NAME",$collection->getByKey($collection->getKeyValue(),"MEMBER_LOGIN_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php //$op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("COUPONBOOK_STATUS1","COUPONBOOK_STATUS1",1,$collection->getByKey($collection->getKeyValue(), "COUPONBOOK_STATUS1")," 利用可", "", $op)?>&nbsp;
								<?=$inputs->checkbox("COUPONBOOK_STATUS2","COUPONBOOK_STATUS2",2,$collection->getByKey($collection->getKeyValue(), "COUPONBOOK_STATUS2")," 利用済", "", $op)?>&nbsp;<br />
								<?=$inputs->checkbox("COUPONBOOK_STATUS3","COUPONBOOK_STATUS3",3,$collection->getByKey($collection->getKeyValue(), "COUPONBOOK_STATUS3")," 期限切", "", $op)?>&nbsp;
								<?=$inputs->checkbox("COUPONBOOK_STATUS4","COUPONBOOK_STATUS4",4,$collection->getByKey($collection->getKeyValue(), "COUPONBOOK_STATUS4")," 利用停止", "", $op)?>&nbsp;
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
		<?php require("includes/box/common/footer.php");?>
	</div>
</body>
</html>