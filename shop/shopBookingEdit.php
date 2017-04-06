<?php
ini_set('display_errors', 1);
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/ShopAccess.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPriceType.php');  
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');  
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');


require_once(PATH_SLAKER_COMMON.'includes/class/xml.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$collection->setPost();
// print_r($_POST);exit;
$shop = new shop($dbMaster);
$shop->selectList($collection);

$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "BOOKING_ID", cmIdCheck("BOOKING_ID"));
$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopBooking = new shopBooking($dbMaster);
$shopBooking->selectCancelData(cmIdCheck("BOOKING_ID"), "", "", "", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
$cancel_num = $shopBooking->selectCancelRoom(cmIdCheck("BOOKING_ID"),$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$shopBooking->setPost();
// print_r($shopBooking);exit;
//	料金設定検索 
$hotelPay = new hotelPay($dbMaster); 
$hotelPay->selectHotelService($shopBooking->getByKey($shopBooking->getKeyValue(), "HOTELPAY_ID"));

$member = new MEMBER($dbMaster);
// print_r($shopBooking->getCollection());
$member->setPost();

if ($shopBooking->getByKey($shopBooking->getKeyValue(), "bookingConfirm")) {
	$shopBooking->saveBooking();
	//$member->saveBirth();
} 

if ($shopBooking->getByKey($shopBooking->getKeyValue(), "requestConfirm")) {
	$shopBooking->checkRequestBooking();
	$shopBooking->saveRequestBooking();
}

$shopPlan = new shopPlan($dbMaster);
$shopPlan->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$ShopAccess = new ShopAccess($dbMaster);
$ShopAccess->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select("", "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));


$shopBookingcont = new shopBookingcont($dbMaster);
$shopBookingcont->selectList($collection);
$roomid = $shopBooking->getByKey($shopBooking->getKeyValue(), "ROOM_ID");
$shopBookingcont->setByKey($shopBookingcont->getKeyValue(),"ROOM_ID", $roomid);

$shopBookingcont->setPost();

// print_r($_POST);exit;


if ($shopBooking->getByKey($shopBooking->getKeyValue(), "regist") and $shopBooking->getErrorCount() <= 0) {
	if (!$shopBooking->updateOnly()) {
		$shopBooking->setErrorFirst("予約の作成に失敗しました。");
		$shopBooking->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($shopBooking->getByKey($shopBooking->getKeyValue(), "delete") and $shopBooking->getErrorCount() <= 0) {
	if (!$shopBooking->delete()) {
		$shopBooking->setErrorFirst("予約の削除に失敗しました。");
		$shopBooking->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
}


	if ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancelconfirm")) {

		$shopBookingcont->checkCancelConfirm_shop();

	}
	elseif ($shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancel")) {
		$shopBookingcont->checkCancel();
		foreach ($_POST['canceldata'] as $k=>$v){
			$type=$v;
		}
		if ( $shopBookingcont->getErrorCount() <= 0 ) {
			if($type == 1){
				if (!$shopBookingcont->cancel($shopBooking, $shopBookset)) {
					$shopBookingcont->setErrorFirst("予約のキャンセルに失敗しました。");
					$shopBookingcont->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
				}
			}else if($type == 2){
				if (!$shopBookingcont->noshow($shopBooking, $shopBookset)) {
					$shopBookingcont->setErrorFirst("予約のキャンセルに失敗しました。");
					$shopBookingcont->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
				}
			}
		}

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
	<title>予約情報｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($shopBooking->getByKey($shopBooking->getKeyValue(), "regist") or $shopBooking->getByKey($shopBooking->getKeyValue(), "delete")) and $shopBooking->getErrorCount() <= 0) {?>
	window.close();
	<?php }?>

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
		//$('#check_none').val("none");
		//document.frmSearch.submit();
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   		var hasQ = "<?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER");?>";
   		if(hasQ){
   	   		$("#BOOKING_REQUEST").attr("disabled","disabled");
   	   		$("#requestConfirm").css("display","none");
   		}
   	});

   	function memberset(mdata) {
   	   	//alert(mdata["MEMBER_NAME1"]);
   	   	$('#BOOKING_NAME1').val(mdata["MEMBER_NAME1"]);
   	   	$('#BOOKING_NAME2').val(mdata["MEMBER_NAME2"]);
   	   	$('#BOOKING_KANA1').val(mdata["MEMBER_NAME_KANA1"]);
   	   	$('#BOOKING_KANA2').val(mdata["MEMBER_NAME_KANA2"]);
   	   	$('#BOOKING_ZIP').val(mdata["MEMBER_ZIP"]);
   	   	$('#BOOKING_PREF_ID').val(mdata["MEMBER_PREF"]);
   	   	$('#BOOKING_CITY').val(mdata["MEMBER_CITY"]);
   	   	$('#BOOKING_ADDRESS').val(mdata["MEMBER_ADDRESS"]);
   	   	$('#BOOKING_NAME2').val(mdata["MEMBER_ADDRESS"]);
   	   	$('#BOOKING_BUILD').val(mdata["MEMBER_BUILD"]);
   	   	$('#BOOKING_TEL').val(mdata["MEMBER_TEL1"]);
   	}

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>

	<?php //料金タイプの種類によって表示分け ?>

	<script type="text/javascript">
	$(function() {
	    $('input[type=radio]').change(function() {
	        $('#person,#group').removeClass('invisible');
	 
	        if ($("input:radio[name='SHOP_PRICETYPE_KIND']:checked").val() == "1") {
	            $('#group').addClass('invisible');
	        } else if($("input:radio[name='SHOP_PRICETYPE_KIND']:checked").val() == "2") {
	            $('#person').addClass('invisible');
	        } 
	    }).trigger('change'); //←(1)
	});
	</script>

	<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>


	<script type="text/javascript">
	<!--

	function keisan(){

		// 設定開始

		// 料金1
		var price1 = (document.book.BOOKING_MONEY1.value) * (document.book.BOOKING_PRICEPERSON1.selectedIndex); 
		document.book.field1.value = price1; // 小計を表示

		// 料金2
		var price2 = (document.book.BOOKING_MONEY2.value) * (document.book.BOOKING_PRICEPERSON2.selectedIndex); 
		document.book.field2.value = price2; // 小計を表示

		// 料金3
		var price3 = (document.book.BOOKING_MONEY3.value) * (document.book.BOOKING_PRICEPERSON3.selectedIndex); 
		document.book.field3.value = price3; // 小計を表示

		// 料金4
		var price4 = (document.book.BOOKING_MONEY4.value) * (document.book.BOOKING_PRICEPERSON4.selectedIndex); 
		document.book.field4.value = price4; // 小計を表示

		// 料金5
		var price5 = (document.book.BOOKING_MONEY5.value) * (document.book.BOOKING_PRICEPERSON5.selectedIndex); 
		document.book.field5.value = price5; // 小計を表示

		// 料金6
		var price6 = (document.book.BOOKING_MONEY6.value) * (document.book.BOOKING_PRICEPERSON6.selectedIndex); 
		document.book.field6.value = price6; // 小計を表示

		// 料金7
		var price7 = (document.book.BOOKING_MONEY7.value) * (document.book.BOOKING_PRICEPERSON7.selectedIndex); 
		document.book.field7.value = price7; // 小計を表示

		// 料金8
		var price8 = (document.book.BOOKING_MONEY8.value) * (document.book.BOOKING_PRICEPERSON8.selectedIndex); 
		document.book.field8.value = price8; // 小計を表示

		// 合計を計算
		document.book.BOOKING_ALL_MONEY.value = price1 + price2 + price3 + price4 + price5 + price6 + price7 + price8;


	}

	// --> 
	</script>

</head>
<body id="">
	<div id="containerPop">
		<h2>予約 編集</h2>
		<div id="contentsPop" class="circle">

			<?php if ($shopBookingcont->getErrorCount() > 0) {?>
			<?php print create_error_caption($shopBookingcont->getError())?>
			<br />
			<?php }?>

			
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data" name="book">
			<?php
					require("includes/box/hotel/inputBooking.php");
			?>
</form>
			<br />

		</div>
		<br />
	</div>
</body>
</html>