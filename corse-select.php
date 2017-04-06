<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');


$dbMaster = new dbMaster();

//  print_r($_POST);
$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

//会員しか見えない
/*
if (!$sess->sessionCheck()) {
	$_SESSION['ref_url']=$_SERVER['REQUEST_URI'];
	cmLocationChange("login.html");
}
*/

$collection = new collection($db);

if($_POST){

	$collection->setPost();
	cmSetHotelSearchDef($collection);


}
else {
//	$collection->setByKey($collection->getKeyValue(), "ROOM_ID", $_GET["room_id"]);
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["company_id"]);
	$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $_GET["plan_id"]);
	$collection->setByKey($collection->getKeyValue(), "priceper_num", $_GET["p_num"]);
//	$collection->setByKey($collection->getKeyValue(), "room_number", $_GET["room_number"]);
//	$collection->setByKey($collection->getKeyValue(), "adult_number1", $_GET["adult_number1"]);
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
	  	if($_GET["undecide_sch"] != ""){
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", $_GET["undecide_sch"]);
	  	}
	 	else{
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
			// テストで１に設定。通常は２
		}
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y年m月d日'));
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
	if($_GET["calender"] != ""){
		$collection->setByKey($collection->getKeyValue(), "calender", $_GET["calender"]);
	}
	else {
	}

	cmSetHotelSearchDef($collection);
}


$shopTarget = new shop($dbMaster);
$shopTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$shopBookset = new shopBookset($dbMaster);
$shopBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));




	//	ココトモ
	$shopPlanTarget = new shopPlan($dbMaster);
	$shopPlanTarget->select($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

	$hotelRoom = new hotelRoom($dbMaster);
	$hotelRoom->select($collection->getByKey($collection->getKeyValue(), "ROOM_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	foreach ($shopPlanTarget->getCollection() as $plan) {
		
//print_r($plan);
	}
	foreach ($collection->getCollection() as $param) {
		//print_r($param);
	}


//print_r($collection);

$shop = new shop($dbMaster);

$shopBooking = new shopBooking($dbMaster);
// $collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
$shop->selectListPublicPlan($collection);


$planCnt = 0;
$dspArray = array();

$money_1 = "";
$money_all = "";

if ($shop->getCount() > 0) {
	foreach ($shop->getCollection() as $data) {

//print_r($data);
		$dspArray[$data["SHOPPLAN_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_ID"] = $data["SHOPPLAN_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_NAME"] = $data["SHOP_NAME"];
		$dspArray[$data["SHOPPLAN_ID"]]["money_1"] = $data["money_1"];
		$dspArray[$data["SHOPPLAN_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["SHOPPLAN_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_ID"] = $data["SHOP_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_NAME"] = $data["SHOP_NAME"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_ID"] = $data["SHOPPLAN_ID"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_NAME"] = $data["SHOPPLAN_NAME"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_PIC_APP"] = $data["SHOP_PIC_APP"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PIC"] = $data["SHOPPLAN_PIC"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_SALE_FROM"] = $data["SHOPPLAN_SALE_FROM"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_SALE_TO"] = $data["SHOPPLAN_SALE_TO"];

		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_DISCRIPTION"] = $data["SHOPPLAN_DISCRIPTION"];

		$dspArray[$data["SHOPPLAN_ID"]]["SHOP_LIST_AREA"] = $data["SHOP_LIST_AREA"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_AREA_LIST1"] = $data["SHOPPLAN_AREA_LIST1"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_AREA_LIST2"] = $data["SHOPPLAN_AREA_LIST2"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_AREA_LIST3"] = $data["SHOPPLAN_AREA_LIST3"];

		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_CATEGORY_LIST1"] = $data["SHOPPLAN_CATEGORY_LIST1"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_CATEGORY_LIST2"] = $data["SHOPPLAN_CATEGORY_LIST2"];
		$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_CATEGORY_LIST3"] = $data["SHOPPLAN_CATEGORY_LIST3"];


		$count_spi = "";
		for ($i=1; $i<=12; $i++){
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_MEET_TIMEHOUR".$i] = $data["SHOPPLAN_MEET_TIMEHOUR".$i];
			if($data["SHOPPLAN_MEET_TIMEHOUR".$i] != ""){
				$count_spi = $i;
			}
		}
//print $count_spi;

		for ($i=1; $i<=$count_spi; $i++){
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE".$i] = $data["SHOP_PRICETYPE_ID".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_KIND".$i] = $data["SHOP_PRICETYPE_KIND".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND1".$i] = $data["SHOP_PRICETYPE_MONEYKIND1".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND2".$i] = $data["SHOP_PRICETYPE_MONEYKIND2".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND3".$i] = $data["SHOP_PRICETYPE_MONEYKIND3".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND4".$i] = $data["SHOP_PRICETYPE_MONEYKIND4".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND5".$i] = $data["SHOP_PRICETYPE_MONEYKIND5".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND6".$i] = $data["SHOP_PRICETYPE_MONEYKIND6".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_PRICETYPE_MONEYKIND7".$i] = $data["SHOP_PRICETYPE_MONEYKIND7".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_ROOM".$i] = $data["ROOM_ID".$i];

			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_MEET_TIMEHOUR".$i] = $data["SHOPPLAN_MEET_TIMEHOUR".$i];
			$dspArray[$data["SHOPPLAN_ID"]]["SHOPPLAN_MEET_TIMEMIN".$i] = $data["SHOPPLAN_MEET_TIMEMIN".$i];

		}

	}
}
//print_r($dspArray);
		//各部屋の料金書き出す
		for ($i=1; $i<=1; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $data["SHOPPLAN_ID"]);
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

					$room_sch = $shop->selectMoneyEveryRoom($search_collection);	
					if($room_sch != ""){
						$room[$i] = $room_sch;	
					}
	//print_r($room[$i]);



		}

foreach($room[$i] as $data){
	if($data["money_perperson"] == ""){	
		//$noChildFlg = 1;
	}
}

// print_r($shopPlanTarget->getCollection());
// print_r($hotel->getCollection());
$money_all_all = 0;
for ($j=1; $j<=1; $j++){
	for ($i=1; $i<=1; $i++){
		$money_all_all += $room[$i]["money_ALL"];
	}
}

// reset calendar show flg
$calendarNoShowFlg = 0;

	$arPayList = array();

	//	料金カレンダー
	$hotelPay = new hotelPay($dbMaster);
	$hotelPayTarget = new hotelPay($dbMaster);

	//	料金設定検索
	//print_r($shopPlanTarget);
//print_r($collection);
	$collection->setByKey($collection->getKeyValue(), "SHOPPLAN_ACC_DAY", $shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_ACC_DAY"));
	
	$collection->setByKey($collection->getKeyValue(), "TARGET_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
	$hotelPay->selectListMin_corse($collection);
 
//	print_r($hotelPay);
	
	//	登録済みデータ設定
	if ($hotelPay->getCount() > 0) {
		foreach ($hotelPay->getCollection() as $hp) {
//	print_r($hp);
			//	POSTデータ
			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["COMPANY_ID"] = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["SHOP_PRICETYPE_ID"] = $hp["SHOP_PRICETYPE_ID"];
			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["priceper_num"] = $collection->getByKey($collection->getKeyValue(), "priceper_num");

			for ($roomNum=1; $roomNum<=1; $roomNum++) {
				$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["priceper_num"] = $collection->getByKey($collection->getKeyValue(), "priceper_num");
			}

			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["date"] = $hp["HOTELPAY_DATE"];
			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["HOTELPAY_ID"] = $hp["HOTELPAY_ID"];

			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE_FLG"] = $hp["HOTELPAY_SERVICE_FLG"];
			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["HOTELPAY_MONEY_FLG"] = $hp["HOTELPAY_MONEY_FLG"];
			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["HOTELPAY_SERVICE"] = $hp["HOTELPAY_SERVICE"];
			$arPayList[$hp["SHOP_PRICETYPE_ID"]][$hp["HOTELPAY_DATE"]]["HOTELPAY_REMARKS"] = $hp["HOTELPAY_REMARKS"];
			
			//------------------start-------------------//

			//各日程の料金書き出す
			for ($i=1; $i<=1; $i++){
				$search_collection = new collection($db);
				$search_collection->setByKey($search_collection->getKeyValue(), "SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
				$search_collection->setByKey($search_collection->getKeyValue(), "SEARCH_DATE", $hp["HOTELPAY_DATE"]);
				$search_collection->setByKey($search_collection->getKeyValue(), "priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));

					$room_perday = $shop->selectMoneyEveryRoomBook($search_collection);	
//print_r($room_perday);
					if($room_perday != ""){
						$roomPerDay = $room_perday;	
					}

			}
				//print_r($roomPerDay);
			
			$diff_flg = 0;
			//------------------end-------------------//
			
			
			//当日の予約数
			$collection_booked = new collection($db);
			$collection_booked->setByKey($collection->getKeyValue(), "COMPANY_ID", $arPayList[$hp["HOTELPAY_DATE"]]["COMPANY_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "SHOPPLAN_ID", $arPayList[$hp["HOTELPAY_DATE"]]["SHOPPLAN_ID"]);
			$collection_booked->setByKey($collection->getKeyValue(), "BOOKING_DATE", $arPayList[$hp["HOTELPAY_DATE"]]["date"]);
			
		}
	}

	//print_r($arPayList);

	$hotelProvide = new hotelProvide($dbMaster);
	$hotelProvide->selectListPublic($collection);
	if ($hotelProvide->getCount() > 0) {
		foreach ($hotelProvide->getCollection() as $hp) {
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["date"] = $hp["HOTELPROVIDE_DATE"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_ID"] = $hp["HOTELPROVIDE_ID"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_STOP"] = $hp["HOTELPROVIDE_FLG_STOP"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_FLG_REQUEST"] = $hp["HOTELPROVIDE_FLG_REQUEST"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_NUM"] = $hp["HOTELPROVIDE_NUM"];
			$arPayList[$hp["ROOM_ID"]][$hp["HOTELPROVIDE_DATE"]]["HOTELPROVIDE_BOOKEDNUM"] = $hp["HOTELPROVIDE_BOOKEDNUM"];
// 			print $hp["HOTELPROVIDE_DATE"]."/".$hp["HOTELPROVIDE_NUM"]."<br />";

		}
	}

//	print_r($arPayList[$hp["HOTELPROVIDE_DATE"]]);
//	print_r($hotelProvide->getCollection());
	//print_r($arPayList);



 //print_r($roomPerDay);


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$shopTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("includes/box/common/meta_detail.php"); ?>
<title>コース選択 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="コース選択,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- ?窗 -->
<link rel="stylesheet" href="/common/css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="/common/js/popupwindow-1.6.js"></script>
<style>
.dspNon {
	display: none;
}
</style>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="content" class="searchdetail">


		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">検索結果</a></li>
            <li><span>コース選択</span></li>
        </ul>
        

<?php
//掲載期間が切れていたら警告文表示
if($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") < date("Y-m-d") && ($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_SALE_TO") != NULL)){?>
        <article id="corse_box">
			<div class="inner">
			<center><B><font color="red">＞＞　ご指定のプランは販売期間が過ぎました。　＜＜</font></B></center>
	</article>
<?php }else{ ?>

        <article id="corse_box">

			<p>ご希望のコースをお選びください</p>

			<h2 class="plan_info">[選択中の日程] <?php print $collection->getByKey($collection->getKeyValue(), "search_date")?></h2>
			<h2 class="plan_info">[選択中のプラン] <?php print cmStrimWidth($shopPlanTarget->getByKey($shopPlanTarget->getKeyValue(), "SHOPPLAN_NAME"), 0, 90, '…')?></h2>
			<h2 class="plan_info">[催行会社] <?php print cmStrimWidth($shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME"), 0, 90, '…')?></h2>

		<div class="inner">
					<table class="corse_select">
						<tr>
							<th class="plan">コース</th>
							<th class="price">料金</th>
							<th class="btn">申込み</th>
						</tr>

						<?php $count_for = count($roomPerDay); ?>
						<?php for ($i=0;$i<$count_for;$i++){?>

						<tr>
							<td>
								<p>
										<?php $arData = cmShopHourSelect();?>
										<?php if (count($arData) > 0) {?>
											<?php $k = $roomPerDay[$i]["hour"];?>
											<?php print $arData[$k];?>
										<?php } ?>
										:
										<?php $arData = cmShopMinSelect();?>
										<?php if (count($arData) > 0) {?>
											<?php $k = $roomPerDay[$i]["min"];?>
											<?php print $arData[$k];?>
										<?php } ?>
								</p>
							</td>
							<td>
								<p class="price_name">
									<?php if($roomPerDay[$i]["kind"] == "2"){?>
										<?php print ($roomPerDay[$i]["group"]);?>あたり
									<?php }elseif($roomPerDay[$i]["kind"] == "1"){?>
										お一人様あたり
									<?php }?>
								</p>
								<p class="price"><?php print number_format($roomPerDay[$i]["price"]);?>円～</p>
								<!--<p class="price_link">料金の詳細</p>-->
							</td>
								<td><?php if($roomPerDay[$i]["room"] == "x"){
										print "×";
									}elseif($roomPerDay[$i]["room"] == "R"){
						        		$formname = "frm".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID").$i."_".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID")."_".str_replace("-", "", $collection->getByKey($collection->getKeyValue(), "target_date"));?>
										<a href="javascript:;"  onclick="document.<?php print $formname; ?>.submit();" style="">
	            								<form action="reservation-request.html" method="post" id="<?php print $formname; ?>" name="<?php print $formname; ?>">
											<div class="btn_request">
												<p>リクエストへ</p>
											</div>
											<?php $tmp = "";?>
											<?php $tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));?>
											<?php $tmp .=  $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));?>
											<?php $tmp .=  $inputs->hidden("SHOPPLAN_MEET_TIMEHOUR", $roomPerDay[$i]["hour"]);?>
											<?php $tmp .=  $inputs->hidden("SHOPPLAN_MEET_TIMEMIN", $roomPerDay[$i]["min"]);?>
											<?php $tmp .=  $inputs->hidden("SHOP_PRICETYPE_ID", $roomPerDay[$i]["pid"]);?>
											<?php $tmp .=  $inputs->hidden("ROOM_ID", $roomPerDay[$i]["rid"]);?>
											<?php $tmp .=  $inputs->hidden("HOTELPAY_ID", $arPayList[$roomPerDay[$i]["pid"]][$collection->getByKey($collection->getKeyValue(), "target_date")]["HOTELPAY_ID"]);?>
											<?php $tmp .=  $inputs->hidden("HOTELPROVIDE_ID", $arPayList[$roomPerDay[$i]["rid"]][$collection->getByKey($collection->getKeyValue(), "target_date")]["HOTELPROVIDE_ID"]);?>
											<?php $tmp .=  $inputs->hidden("target_date", $collection->getByKey($collection->getKeyValue(), "target_date"));?>
											<?php print $tmp;?>
										</form>
										</a>
									<?php }elseif($roomPerDay[$i]["room"] > 0){ ?>
						        		<?php $formname = "frm".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID").$i."_".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID")."_".str_replace("-", "", $collection->getByKey($collection->getKeyValue(), "target_date"));?>
										<a href="javascript:;"  onclick="document.<?php print $formname; ?>.submit();" style="">
	            								<form action="reservation.html" method="post" id="<?php print $formname; ?>" name="<?php print $formname; ?>">
											<div class="btn_reserve">
												<p>申込へ</p>
											</div>
											<?php $tmp = "";?>
											<?php $tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));?>
											<?php $tmp .=  $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));?>
											<?php $tmp .=  $inputs->hidden("SHOPPLAN_MEET_TIMEHOUR", $roomPerDay[$i]["hour"]);?>
											<?php $tmp .=  $inputs->hidden("SHOPPLAN_MEET_TIMEMIN", $roomPerDay[$i]["min"]);?>
											<?php $tmp .=  $inputs->hidden("SHOP_PRICETYPE_ID", $roomPerDay[$i]["pid"]);?>
											<?php $tmp .=  $inputs->hidden("ROOM_ID", $roomPerDay[$i]["rid"]);?>
											<?php $tmp .=  $inputs->hidden("HOTELPAY_ID", $arPayList[$roomPerDay[$i]["pid"]][$collection->getByKey($collection->getKeyValue(), "target_date")]["HOTELPAY_ID"]);?>
											<?php $tmp .=  $inputs->hidden("HOTELPROVIDE_ID", $arPayList[$roomPerDay[$i]["rid"]][$collection->getByKey($collection->getKeyValue(), "target_date")]["HOTELPROVIDE_ID"]);?>
											<?php $tmp .=  $inputs->hidden("target_date", $collection->getByKey($collection->getKeyValue(), "target_date"));?>
											<?php print $tmp;?>										</form>
										</a>
								 	<?php } ?>
								</td>						</tr>
							</tr>
						<?php } ?>
					</table>
					<p class="coment">※申込み「リクエスト」の場合は催行会社からの予約確認、受け入れ可否の連絡によって予約確定します。</p>

					<a href="javascript:history.back();"><p class="back_btn">前のページに戻る</p></a>
            </div>
        </article>



<?php }?>
    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->


</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
