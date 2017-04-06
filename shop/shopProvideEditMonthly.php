<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$date = "";
if ($_GET["date"] != "") {
	$date = $_GET["date"];
}
elseif ($_POST["date"] != "") {
	$date = $_POST["date"];
}
// $shopPlan = new shopPlan($dbMaster);
// $shopPlan->select(cmKeyCheck(constant("shopPlan::keyName")), "1,2", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelRoom = new hotelRoom($dbMaster);
$hotelRoom->select(cmKeyCheck("ROOM_ID"), "1", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$hotelProvide = new hotelProvide($dbMaster);
$hotelProvide->select(cmIdCheck("HOTELPROVIDE_ID"), $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), cmKeyCheck("ROOM_ID"));

$nowUsed = $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_NUM");




$hotelProvide->setPost();
if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_DATE") == "") {
	$hotelProvide->setByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_DATE", $date);
}
$hotelProvide->setByKey($hotelProvide->getKeyValue(), "ROOM_ID", cmKeyCheck("ROOM_ID"));
$hotelProvide->setByKey($hotelProvide->getKeyValue(), "COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$tmp_arr = explode("-",$date);
$total_day = get_total_days($tmp_arr[1], $tmp_arr[0]);

for ($i = 1; $i <= $total_day; $i++) {
	if (!$_POST["HOTELPROVIDE_FLG_STOP$i"] || !$_POST["HOTELPROVIDE_FLG_REQUEST$i"]) {
		$hotelProvide->check();
	}
}
if ($hotelRoom->getCount() != 1) {
	$hotelRoom->setErrorFirst("部屋タイプの取得に失敗しました。");
}
else {
}

/*
if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "regist") and $hotelProvide->getErrorCount() <= 0) {
	for ($i = 1; $i <=$total_day; $i++) {
		if ($_POST["HOTELPROVIDE_FLG_STOP$i"]) {
			$d = $date.'-'.($i<10?'0'.$i:$i);
			$hotelProvide->select(cmIdCheck("HOTELPROVIDE_ID"), $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), cmKeyCheck("ROOM_ID") ,$d);
			
			$hotelProvide->setByKey($hotelProvide->getKeyValue(), 'HOTELPROVIDE_FLG_STOP', $_POST["HOTELPROVIDE_FLG_STOP$i"]);
			$hotelProvide->setByKey($hotelProvide->getKeyValue(), 'HOTELPROVIDE_FLG_REQUEST', $_POST["HOTELPROVIDE_FLG_REQUEST$i"]);
			$hotelProvide->setByKey($hotelProvide->getKeyValue(), 'HOTELPROVIDE_NUM', $_POST["HOTELPROVIDE_NUM$i"]);
			$hotelProvide->setByKey($hotelProvide->getKeyValue(), 'COMPANY_ID', $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
			$hotelProvide->setByKey($hotelProvide->getKeyValue(), 'HOTELPROVIDE_DATE',$d);
			$hotelProvide->setByKey($hotelProvide->getKeyValue(), 'ROOM_ID', $_POST['ROOM_ID']);
			
			if (!$hotelProvide->save()) {
				$hotelProvide->setErrorFirst("料金設定の保存に失敗しました。");
				$hotelProvide->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
			}
		}
	}
}
*/
$_POST['COMPANY_ID']=$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID");
if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "regist") and $hotelProvide->getErrorCount() <= 0) {
	if (!$hotelProvide->saveAll()) {
			$hotelProvide->setErrorFirst("料金設定の保存に失敗しました。");
			$hotelProvide->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
elseif ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "delete") and $hotelProvide->getErrorCount() <= 0) {
	if (!$hotelProvide->delete()) {
		$hotelProvide->setErrorFirst("料金設定の削除に失敗しました。");
		$hotelProvide->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}
else {
	if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST") == "") {
		$hotelProvide->setByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST", 2);
	}
}

$inputs = new inputs();

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>月間部屋数調整｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	<?php if (($hotelProvide->getByKey($hotelProvide->getKeyValue(), "regist") or $hotelProvide->getByKey($hotelProvide->getKeyValue(), "delete")) and $hotelProvide->getErrorCount() <= 0) {?>
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
   	});
	
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	
	$(function() {
		/*up*/
		if($("#HOTELPROVIDE_FLG_REQUEST").attr('checked')){
			$("#HOTELPROVIDE_NUM").attr('disabled',true);
			$("#HOTELPROVIDE_NUM").attr('value','');
		}
		$("#HOTELPROVIDE_FLG_REQUEST").click(function(){
			$("#HOTELPROVIDE_NUM").attr('disabled',true);
			$("#HOTELPROVIDE_NUM").attr('value','');
	   	});
		$("#HOTELPROVIDE_FLG_REQUEST0").click(function(){
			$("#HOTELPROVIDE_NUM").attr('disabled',false);
	   	});
	   	/*down*/
		<?php for ($i=1;$i<=31;$i++){?>
		if($("#HOTELPROVIDE_FLG_REQUEST1<?php echo $i?>").attr('checked')){
			$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('disabled',true);
			$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('value','');
		}
		$("#HOTELPROVIDE_FLG_REQUEST1<?php echo $i?>").click(function(){
			$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('disabled',true);
			$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('value','');
	   	});
		$("#HOTELPROVIDE_FLG_REQUEST2<?php echo $i?>").click(function(){
			$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('disabled',false);
	   	});
	   	<?php }?>
	});
	function reflection(){

		if((($("#HOTELPROVIDE_FLG_STOP").attr("checked"))||($("#HOTELPROVIDE_FLG_STOP0").attr("checked"))) && (($("#HOTELPROVIDE_FLG_REQUEST").attr("checked"))||($("#HOTELPROVIDE_FLG_REQUEST0").attr("checked")))){
			if($("#HOTELPROVIDE_FLG_STOP").attr("checked")){
				$(".HOTELPROVIDE_FLG_STOP1").attr("checked","checked");
			}

			if($("#HOTELPROVIDE_FLG_STOP0").attr("checked")){
				$(".HOTELPROVIDE_FLG_STOP2").attr("checked","checked");
			}
			if($("#HOTELPROVIDE_FLG_REQUEST").attr("checked")){
				$(".HOTELPROVIDE_FLG_REQUEST1").attr("checked","checked");
				<?php for ($i=1;$i<=31;$i++){?>
				if($("#HOTELPROVIDE_FLG_REQUEST1<?php echo $i?>").attr('checked')){
					$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('disabled',true);
					$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('value','');
				}
				<?php }?>
			}

			if($("#HOTELPROVIDE_FLG_REQUEST0").attr("checked")){
				$(".HOTELPROVIDE_FLG_REQUEST2").attr("checked","checked");
				<?php for ($i=1;$i<=31;$i++){?>
				if($("#HOTELPROVIDE_FLG_REQUEST2<?php echo $i?>").attr('checked')){
					$("#HOTELPROVIDE_NUM<?php echo $i?>").attr('disabled',false);
			   	}
			   	<?php }?>
			}

			if($("#HOTELPROVIDE_NUM").val()){
				for(var i=1;i<=31;i++){
					$("#HOTELPROVIDE_NUM"+i).attr("value",$("#HOTELPROVIDE_NUM").val());
				}
			}
		}
	}
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>月間部屋数調整</h2>
		<div id="contentsPop" class="circle">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<?php
					if ($hotelRoom->getErrorCount() > 0) {
						print create_error_caption($hotelRoom->getError());
					}
					else {
						if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "regist") and $hotelProvide->getErrorCount() <= 0) {
						}
						else {
							require("includes/box/hotel/inputProvideMonthly.php");
						}
					}
				?>
			</form>
		</div>
		<br />
	</div>
</body>
</html>