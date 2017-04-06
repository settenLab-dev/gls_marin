<?php
require_once('includes/applicationInc.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

//	基本情報
$hotel = new hotel($dbMaster);
$hotel->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//	予約基本
$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

//	料金設定の対象プラン
$hotelPlanTarget = new hotelPlan($dbMaster);
$hotelPlanTarget->select(cmIdCheck("HOTELPLAN_ID"), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
//	料金設定対象の部屋
$hotelRoomTrget = new hotelRoom($dbMaster);
$hotelRoomTrget->select(cmKeyCheck("ROOM_ID"), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collection = new collection($dbMaster);
$collection->setPost();

$hotelPay = new hotelPay($dbMaster);
$hotelPayTarget = new hotelPay($dbMaster);

//	料金設定検索
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", cmIdCheck("HOTELPLAN_ID"));
$collection->setByKey($collection->getKeyValue(), "ROOM_ID", cmKeyCheck("ROOM_ID"));
$hotelPay->selectList($collection);

$inputs = new inputs();
$inputsOnly = new inputs(true);

$collection2 = new collection($dbMaster);
$collection2->setPost();
if ($collection2->getByKey($collection2->getKeyValue(), "searchMonth") == "") {
	$collection2->setByKey($collection2->getKeyValue(), "searchMonth", date("Y-m-1"));
}

if ($hotelPlanTarget->getCount() != 1) {
	$collection2->setErrorFirst("プランの取得に失敗しました。");
	$collection2->setErrorFirst("この画面を閉じてプランを選択して下さい。");
}
elseif($hotelRoomTrget->getCount() != 1) {
	$collection2->setErrorFirst("部屋タイプの取得に失敗しました。");
	$collection2->setErrorFirst("この画面を閉じて部屋タイプを選択して下さい。");
}

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>日付｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($collection2->getByKey($collection2->getKeyValue(), "regist") or $collection2->getByKey($collection2->getKeyValue(), "delete")) and $collection2->getErrorCount() <= 0) {?>

	var a = new Array();
	<?php
	foreach ($collection2Target->getCollection() as $data) {
		foreach ($data as $k=>$v) {
	?>
	a['<?php print $k?>'] = '<?php print $v?>';
	<?php
		}
	}
	?>

	window.opener.memberset(a);
	window.close();
	<?php }?>

	$(document).ready(function(){
		$("#sortList")
		.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>予約日設定</h2>
		<div id="contentsPop" class="circle">




			<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
				<tr>
					<td valign="top">
						<p>予約日設定</p>
						<?php if ($collection2->getErrorCount() > 0) {?>
						<?php print create_error_caption($collection2->getError())?>
						<?php }else{?>

						<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList"  border="0">
							<tr>
								<td width="40">
									<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
									<?=$inputs->submit("","search","前の月", "circle")?>
									<?php print $inputs->hidden("searchMonth", date("Y-m-1",strtotime("-1 month" ,strtotime($collection2->getByKey($collection2->getKeyValue(), "searchMonth")))))?>
									</form>
								</td>
								<td width="40">
									<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
									<?=$inputs->submit("","search","次の月", "circle")?>
									<?php print $inputs->hidden("searchMonth", date("Y-m-1",strtotime("1 month" ,strtotime($collection2->getByKey($collection2->getKeyValue(), "searchMonth")))))?>
									</form>
								</td>
							</tr>
						</table>

						<?php
							if ($collection2->getByKey($collection2->getKeyValue(), "regist") and $collection2->getErrorCount() <= 0) {
							}
							else {
								require("includes/box/hotel/listStayDate.php");
							}
						?>

						<?php }?>

					</td>
				</tr>
			</table>

		</div>
		<br />
	</div>
</body>
</html>