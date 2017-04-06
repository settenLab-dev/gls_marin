<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
// print_r($collection->getCollection());
cmSetHotelSearchDef($collection);
$collection->setByKey($collection->getKeyValue(), "pageNum", 10);


//	ページャ設定
$perpage = $collection->getByKey($collection->getKeyValue(), "pageNum");
$page = $collection->getByKey($collection->getKeyValue(), "pageID");
$currentPage = 0;
if (!cmCheckNull($page) or !cmCheckPtn($page, CHK_PTN_NUM) or $page <= 0) {
	$currentPage = 0;
}
else {
	$currentPage = $page-1;
}
$limit = ($currentPage*$perpage).",".$perpage;
$collection->setByKey($collection->getKeyValue(), "limit", $limit);
$collection->setByKey($collection->getKeyValue(), "limitptn", "plan");

//	検索するホテル
$targetId = "";
// $hotelCompany = new hotel($dbMaster);
// $hotelCompany->selectListCompanyCount($collection);

$hotel = new hotel($dbMaster);

// if ($hotelCompany->getCount() > 0) {
// 	foreach ($hotelCompany->getCollection() as $cc) {
// 		if ($targetId != "") {
// 			$targetId .= ",";
// 		}
// 		$targetId .= $cc["COMPANY_ID"];
// 	}
// 	$collection->setByKey($collection->getKeyValue(), "targetId", $targetId);
	$hotel->selectListPublicHotel($collection);
// }

// $hotel_plan = new hotel($dbMaster);
// $hotel_plan->selectListPublicPlan($collection);
// print_r($hotel->getCollection());
// print_r($hotelCompany->getCollection());

$companyCnt = 0;
$planCnt = 0;
$dspArray = array();
if ($hotel->getCount() > 0) {
	foreach ($hotel->getCollection() as $data) {
		$planCnt++;
		$dspArray[$planCnt]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$planCnt]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$planCnt]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$planCnt]["HOTELPLAN_NAME"] = $data["HOTELPLAN_NAME"];
		$dspArray[$planCnt]["HOTEL_PIC_APP"] = $data["HOTEL_PIC_APP"];
		$dspArray[$planCnt]["HOTELPLAN_PIC"] = $data["HOTELPLAN_PIC"];
		$dspArray[$planCnt]["HOTELPLAN_DATE_POST_FROM"] = $data["HOTELPLAN_DATE_POST_FROM"];
		$dspArray[$planCnt]["HOTELPLAN_DATE_POST_TO"] = $data["HOTELPLAN_DATE_POST_TO"];
		$dspArray[$planCnt]["HOTELPLAN_BF_FLG"] = $data["HOTELPLAN_BF_FLG"];
		$dspArray[$planCnt]["HOTELPLAN_DN_FLG"] = $data["HOTELPLAN_DN_FLG"];
		$dspArray[$planCnt]["HOTELPLAN_LN_FLG"] = $data["HOTELPLAN_LN_FLG"];
		$dspArray[$planCnt]["HOTELPLAN_CHECKIN"] = $data["HOTELPLAN_CHECKIN"];
		$dspArray[$planCnt]["HOTELPLAN_CHECKIN_LAST"] = $data["HOTELPLAN_CHECKIN_LAST"];
		$dspArray[$planCnt]["HOTELPLAN_CHECKOUT"] = $data["HOTELPLAN_CHECKOUT"];
		$dspArray[$planCnt]["HOTELPLAN_FEATURE"] = $data["HOTELPLAN_FEATURE"];
		$dspArray[$planCnt]["HOTELPLAN_FLG_DAYUSE"] = $data["HOTELPLAN_FLG_DAYUSE"];
		$dspArray[$planCnt]["HOTELPLAN_DISCOUNT"] = $data["HOTELPLAN_DISCOUNT"];
		$dspArray[$planCnt]["HOTELPLAN_CONTENTS"] = $data["HOTELPLAN_CONTENTS"];

		$dspArray[$planCnt]["HOTEL_LIST_AREA"] = $data["HOTEL_LIST_AREA"];

		if ($dspArray[$planCnt]["money_all"] == "" or $dspArray[$planCnt]["money_all"] > $data["money_all"]) {
			$dspArray[$planCnt]["money_1"] = $data["money_1"];
			$dspArray[$planCnt]["money_all"] = $data["money_all"];
		}

		$dspArray[$planCnt]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$planCnt]["ROOM_NAME"] = $data["ROOM_NAME"];
		$dspArray[$planCnt]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$planCnt]["ROOM_BREADTH"] = $data["ROOM_BREADTH"];
		$dspArray[$planCnt]["ROOM_FEATURE_LIST3"] = $data["ROOM_FEATURE_LIST3"];
		/*
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTELPLAN_ID"] = $data["HOTELPLAN_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTEL_NAME"] = $data["HOTEL_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["money_1"] = $data["money_1"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_ID"] = $data["ROOM_ID"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_NAME"] = $data["ROOM_NAME"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["HOTELPAY_ROOM_NUM"] = $data["HOTELPAY_ROOM_NUM"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_TYPE"] = $data["ROOM_TYPE"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_CAPACITY_TO"] = $data["ROOM_CAPACITY_TO"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_BREADTH"] = $data["ROOM_BREADTH"];
		$dspArray[$data["HOTELPLAN_ID"]]["room"][$data["ROOM_ID"]]["ROOM_FEATURE_LIST3"] = $data["ROOM_FEATURE_LIST3"];
		*/
	}
}

// print_r($dspArray);

$inputs = new inputs();

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotel->setErrorFirst("エリアデータの読み込みに失敗しました");
}



$page_post = array();
if ($_POST) {
	foreach ($collection->getCollectionByKey("") as $k=>$v) {
		if ($k == "research") {
			continue;
		}
		$page_post[$k] = $v;
	}
}
else {
	foreach ($collection->getCollectionByKey("") as $k=>$v) {
		$page_post[$k] = $v;
	}
}
//	ページャ取得
$pager_options = array(
		'mode'       => 'Jumping', // 表示タイプ(Jumping/Sliding)
		'perPage'    => $perpage,        // 一ページ内で表示する件数
		'totalItems' => $hotel->getMaxCount(),   // ページング対象データの総数
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '<span class="prev">前へ</span>',
		'nextImg'=> '<span class="next">次へ</span>',
		'extraVars'  =>$page_post
);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta.php"); ?>
<title>プラン検索 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="ホテル,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="ホテル、プラン検索のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>

<script type="text/javascript">
$(document).ready( function() {
	<?php
	if ($collection->getByKey($collection->getKeyValue(), "research")) {
	?>
	$('#searchtable').hide();
	<?php
	}
	else {
	?>
	$('#searchafterList').hide();
	<?php
	}
	?>

	$(".close_bt a").click(function(){
		$('#searchafterList').slideToggle(800);
		$('#searchtable').slideToggle();
	});
});

</script>

</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail" class="search">
        <article class="mainbox sp" id="ag">
			<div class="inner" id="fe">
			<h2><a href="">特集タイトル特集タイトル★</a></h2>
			<div class="cont">
				<table>
					<tr>
						<td valign="top">
							<div class="image-r">
								<img src="./images/sample/dummy-feature.png" width="260" height="194" alt="xxxx">
							</div>
						</td>
						<td valign="top">

							<div class="plans-section">
								<section class="detailplan-txt">
									<p>お勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメントお勧めコメント</p>
								</section>
								<div class="cf">
									<ul class="category">
										<li>那覇</li>
										<li>特集</li>
										<li>食あり</li>
									</ul>
								</div>
								<div class="period">
									販売期間:<span>2013年09月00日 〜 2013年10月00日</span>
								</div>
							</div>
						</td>
					</tr>
				</table>
		</article>

    <ul id="panlist">
        <li><a href="index.html">TOP</a></li>
        <li><span>特集</span></li>
    </ul>

    <!--searchbox-->
    <?php require("includes/box/hotel/searchbox.php");?>
    <!-- /searchbox-->

    						<?php $formnamePlan = "frmFacSearch";?>
                        	<form action="facility-search.html" method="post" id="<?php print $formnamePlan?>" name="<?php print $formnamePlan?>">
                        	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
                        	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
                        	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
                        	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
                        	<?php
                        	if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
								for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
							?>
                        	<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
                        	<?php for ($i=1; $i<=6; $i++) {?>
                        	<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
                        	<?php }?>
							<?php
								}
							}
                        	?>
                        	</form>



    <!--searchresult-->
    <section class="mainbox resultbox form">
    	<?php $scope = $pager->getOffsetByPageId()?>
    	<div class="result">検索結果：<b><?php print $hotel->getMaxCount()?>件</b>のホテル情報のうち <b><?php print $scope['0']?></b>件〜<b><?php print $scope['1']?></b>件を表示</div>
        <p class="caution">※表示の料金は1部屋・1泊あたりの合計金額（税・サービス料込）です。<br>
        2室以上のお部屋をご利用の場合は、1部屋目の人数の合計が表示されます。</p>
        <?php if ($navi["back"] != "" or $navi["next"] != "") {?>
			<div class="pagenavi2">
				<p>
				<?php if ($navi["back"] != "") {?>
					<span class="btn"><?=$navi["back"]?></span>
				<?php }?>
					<?=$navi["pages"]?>
				<?php if ($navi["next"] != "") {?>
					<span class="btn"><?=$navi["next"]?></span>
				<?php }?>
				</p>
			</div>
			<?php }?>
        <div class="order">
        	並び替え
            <div class="selectbox">
                <div class="select-inner select4"><span></span></div>
                <select class="select4" name="orderdata">
                    <option value="" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="")?'selected="selected"':''?>>人気順</option>
                    <option value="1" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="1")?'selected="selected"':''?>>料金が安い順</option>
                    <option value="2" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="2")?'selected="selected"':''?>>料金が高い順</option>
                </select>
            </div>
            <script type="text/javascript">
	                            $(document).ready(function(){
	                            	$("select[name='orderdata']").change(function () {
	                            		$("input[name='orderdata']").val($(this).val());
	                            		document.frmResearch.submit();
	                            	});
                            	});
            </script>
        </div>

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
        <!--item-->
        <article>

        							<?php $formname = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["HOTELPLAN_ID"]."_".$plandata["ROOM_ID"];?>
		                        	<form action="search-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">

		                        	<h2><?php /*<span class="high">ハイクラス</span>*/?><a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><?php print $plandata["HOTEL_NAME"]?></a></h2>

			                        	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
			                        	<?php print $inputs->hidden("HOTELPLAN_ID", $plandata["HOTELPLAN_ID"])?>
			                        	<?php print $inputs->hidden("ROOM_ID", $plandata["ROOM_ID"])?>
			                        	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
			                        	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
			                        	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
			                        	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
			                        	<?php
			                        	if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
											for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
										?>
			                        	<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
			                        	<?php for ($i=1; $i<=6; $i++) {?>
			                        	<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
			                        	<?php }?>
										<?php
											}
										}
			                        	?>
		                        	</form>



            <ul class="category" style="margin-bottom: 4px;">
            	<?php
	        	$arArea = array();
	        	$arTemp = explode(":", $plandata["HOTEL_LIST_AREA"]);
	        	if (count($arTemp) > 0) {
	        		foreach ($arTemp as $data) {
	        			if ($data != "") {
	        				$arArea[$data] = $data;
	        			}
	        		}
	        	}
	        	?>
	        	<?php
        		if (count($arArea) > 0) {
        			foreach ($arArea as $d) {
				?>
				<li><?php print $xmlArea->getNameByValue($d)?></li>
				<?php
					}
				}
        		?>
        		<?php /*
                <li>宿タイプ</li>
        		*/?>
            </ul>
            <div class="inner">

            				<?php $formname = "frm".$plandata["COMPANY_ID"]."_".$plandata["HOTELPLAN_ID"]."_".$plandata["ROOM_ID"];?>
                        	<form action="plan-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">

                        		<h3><?php /*<span class="new">NEW</span>*/?><a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><?php print $plandata["HOTELPLAN_NAME"]?></a></h3>

	                        	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	                        	<?php print $inputs->hidden("HOTELPLAN_ID", $plandata["HOTELPLAN_ID"])?>
	                        	<?php print $inputs->hidden("ROOM_ID", $plandata["ROOM_ID"])?>
	                        	<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
			                        	<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
	                        	<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
	                        	<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
	                        	<?php
	                        	if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
									for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
								?>
	                        	<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
	                        	<?php for ($i=1; $i<=6; $i++) {?>
	                        	<?php print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
	                        	<?php }?>
								<?php
									}
								}
	                        	?>
                        	</form>



            	<div class="image">
            		<?php if ($plandata["HOTELPLAN_PIC"] != "") {?>
                	<a href="#"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $plandata["HOTELPLAN_PIC"]?>" width="165" height="123" alt="<?php print $plandata["HOTELPLAN_NAME"]?>"></a>
            		<?php }else{?>
                	<a href="#"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="165" height="123" alt="<?php print $plandata["HOTELPLAN_NAME"]?>"></a>
            		<?php }?>
                	<div class="period">
                		<?php $fromDate = cmDateDivide($plandata["HOTELPLAN_DATE_POST_FROM"])?>
                    	<?php $toDate = cmDateDivide($plandata["HOTELPLAN_DATE_POST_TO"])?>
                    	<?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?><br><?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?>
                    </div>
                </div>
                <div class="cont">
                	<ul class="icon">
                		<?php
                			$meal = "";
                			if ($plandata["HOTELPLAN_BF_FLG"] == 2) {
								$meal .= "朝";
							}
                			if ($plandata["HOTELPLAN_LN_FLG"] == 2) {
								$meal .= "昼";
							}
                			if ($plandata["HOTELPLAN_DN_FLG"] == 2) {
								$meal .= "夕";
							}
							if ($meal != "") {
								$meal .= "食あり";
							}
                		?>
                		<?php if ($meal != "") {?>
                    	<li class="radius10"><?php print $meal?></li>
                		<?php }?>
                        <li class="radius10">ココモ。限定</li>
                    </ul>
                    <div class="checkin">チェックイン：<?php print $plandata["HOTELPLAN_CHECKIN"]?>～<?php print $plandata["HOTELPLAN_CHECKIN_LAST"]?> / チェックアウト～<?php print $plandata["HOTELPLAN_CHECKOUT"]?></div>

                	<div class="off_bo">
                		<?php if ($plandata["HOTELPLAN_DISCOUNT"] != "") {?>
                    	<div class="offtxt radius5"><b><?php print $plandata["HOTELPLAN_DISCOUNT"]?></b></div>
                		<?php }?>
                    	<div class="off-inner  radius10">
                    		<b>最安料金</b><br />
        	                <span>1室合計</span>
    	                    <strong>￥<?php print number_format($plandata["money_all"])?>～</strong><br>
	                        <p class="point">ポイント<?php print $plandata["HOTELPAY_ROOM_NUM"]?>%</p>
                        </div>
                    </div>
                <div class="introduction">
                	<?php if ($plandata["HOTELPLAN_CONTENTS"] != "") {?>
                	<p>
                		<span class="hi">特典</span><?php print redirectForReturn($plandata["HOTELPLAN_CONTENTS"])?>
                	</p>
                	<?php }?>
                </div>
                <div class="plan-sub">
                	<p class="line_do"><?php print $plandata["ROOM_NAME"]?></p>
                	<?php
                	$dataFeature3 = cmHotelRoomFeature3();
                	$arFearture3 = array();
                	$arTemp = explode(":", $data["ROOM_FEATURE_LIST3"]);
                	$cc = 0;
                	if (count($arTemp) > 0) {
                		foreach ($arTemp as $dd) {
                			if ($dd != "") {
                				$cc++;
                				// 												if ($cc > 4) break;
                				$arFearture3[$dd] = $dd;
                			}
                		}
                	}
                	?>
                	<?php if ($plandata["ROOM_BREADTH"] != "") {?>
                	<p>広さ：<?php print $plandata["ROOM_BREADTH"]?>㎡
                	<?php }?>
                	<?php
                	$dataFeature3 = cmHotelRoomFeature3();
                	$arFearture3 = array();
                	$arTemp = explode(":", $plandata["ROOM_FEATURE_LIST3"]);
                	$cc = 0;
                	if (count($arTemp) > 0) {
                		foreach ($arTemp as $dd) {
                			if ($dd != "") {
                				$cc++;
                				$arFearture3[$dd] = $dd;
                			}
                		}
                	}
		                    		if (count($arFearture3) > 0) {
										foreach ($arFearture3 as $d) {
		                    		?>
		                    		<span class="radius10"><?php print $dataFeature3[$d]?></span>
		                    		<?php
		                    			}
									}
		                    		?>
                	</p>
                </div>
                </div>
            </div>
        </article>
        <!--/item-->
	        <?php }?>
        <?php }?>

    </section>

    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->

    <!--side-->
    <?php require("includes/box/common/right.php");?>
    <!--/side-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
