<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');


$dbMaster = new dbMaster();


$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$shop = new shop($dbMaster);
$shop->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$shopBookset->setPost();
$shopBookset->check();

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$booking = new shopBooking($dbMaster);
$booking->selectList($collection);

$bookingcont = new shopBookingcont($dbMaster);
$bookingcont->selectList($collection);
//print_r($bookingcont);
//print_r($booking);


// add by 0909
$shopPlan = new shopPlan($dbMaster);
$hotelPriceType = new hotelPriceType($dbMaster);
$hotelRoom = new hotelRoom($dbMaster);

if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") == 3) {
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
	<title>予約管理｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<meta http-equiv="x-ua-compatible" content="IE=9" >
	<meta http-equiv="x-ua-compatible" content="IE=EmulateIE9" >
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
				<?php require("includes/box/common/menuHotel.php");?>


			<div id="colLeft">
				<div class="manageMenu circle">
				<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post"></form>

					<h2>予約管理</h2>
					<?php
					if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_HOTERL") != 1) {
					?>
					<table cellspacing="10">
						<tr>
							<td>
								<p>予約情報は現在設定出来なくなっております。</p>
								<p>契約状況をご確認の上、管理者にお問い合わせ下さい。</p>
							</td>
						</tr>
					</table>
					<?php
					}else{
					?>

					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<?php
							if ($collection->getByKey($collection->getKeyValue(), "regist") and $shopBooking->getErrorCount() <= 0) {
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
							}

							require("includes/box/hotel/listBooking.php");
						?>
					</form>
					<?php
					}
					?>
				</div>
				<br />
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

				<a href="shopBookingNew.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい予約を登録","circle longButton")?></a>

				<div class="actions circle">
					<h2>予約検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">ID</td>
								<td>
									<?=$inputs->text("BOOKING_ID",$collection->getByKey($collection->getKeyValue(),"BOOKING_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>予約者名</td>
								<td>
									<?=$inputs->text("BOOKING_NAME",$collection->getByKey($collection->getKeyValue(),"BOOKING_NAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>予約者カナ</td>
								<td>
									<?=$inputs->text("BOOKING_NAME_KANA",$collection->getByKey($collection->getKeyValue(),"BOOKING_NAME_KANA"),"imeActive circle",30)?>
								</td>
							</tr>

							<tr>
								<td>キーワード</td>
								<td>
									<?=$inputs->text("BOOKING_TITLE",$collection->getByKey($collection->getKeyValue(),"BOOKING_TITLE"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>利用日</td>
								<td>
					                        <?php print $inputs->text("BOOKING_USE_DATE", $collection->getByKey($collection->getKeyValue(), "BOOKING_USE_DATE") ,"imeDisabled wDateJp")?>
					                        <script type="text/javascript">
					                        	$.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
					                        	$("#BOOKING_USE_DATE").datepicker(
					                        			{
					                        				showOn: 'button',
					                        				buttonImage: 'images/index/index-search-icon.png',
					                        				buttonImageOnly: true,
					                        				dateFormat: 'yy年mm月dd日',
					                        				changeMonth: true,
					                        				changeYear: true,
					                        				yearRange: '<?php print date("Y")?>:<?php print date("Y",strtotime("+1 year"))?>',
					                        				showMonthAfterYear: true,
					                        				monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
					                    	                dayNamesMin: ['日','月','火','水','木','金','土']
					                    				});
					                        </script>
								</td>
							</tr>

						</table>
						<ul class="buttons">
							<li><?=$inputs->submit("","login","検索", "circle")?></li>
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