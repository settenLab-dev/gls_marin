<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/job.php');
require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
//require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
//print_r($collection);
// print_r($collection->getCollection());
//cmSetHotelSearchDef($collection);
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
// $jobCompany = new hotel($dbMaster);
// $jobCompany->selectListCompanyCount($collection);

$job = new job($dbMaster);

// if ($jobCompany->getCount() > 0) {
// 	foreach ($jobCompany->getCollection() as $cc) {
// 		if ($targetId != "") {
// 			$targetId .= ",";
// 		}
// 		$targetId .= $cc["COMPANY_ID"];
// 	}
// 	$collection->setByKey($collection->getKeyValue(), "targetId", $targetId);
	$job->selectListPublicJob($collection);
// }
//print_r($job);
// $job_plan = new hotel($dbMaster);
// $job_plan->selectListPublicPlan($collection);
// print_r($job->getCollection());
// print_r($jobCompany->getCollection());

$companyCnt = 0;
$planCnt = 0;
$dspArray = array();
if ($job->getCount() > 0) {
	foreach ($job->getCollection() as $data) {
		$planCnt++;
		$dspArray[$planCnt]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$planCnt]["JOBCOMPANY_NAME"] = $data["JOBCOMPANY_NAME"];
		$dspArray[$planCnt]["JOB_NAME"] = $data["JOB_NAME"];
		$dspArray[$planCnt]["JOBPLAN_ID"] = $data["JOBPLAN_ID"];
		$dspArray[$planCnt]["JOB_NAME"] = $data["JOB_NAME"];
//		$dspArray[$planCnt]["JOB_PIC_APP"] = $data["JOB_PIC_APP"];
		$dspArray[$planCnt]["JOB_PIC2"] = $data["JOB_PIC2"];
		$dspArray[$planCnt]["JOB_SHOW_FROM"] = $data["JOB_SHOW_FROM"];
		$dspArray[$planCnt]["JOB_SHOW_TO"] = $data["JOB_SHOW_TO"];
		$dspArray[$planCnt]["JOB_CATCH"] = $data["JOB_CATCH"];
		$dspArray[$planCnt]["JOB_FEATURE"] = $data["JOB_FEATURE"];
		$dspArray[$planCnt]["JOB_CONTENTS"] = $data["JOB_CONTENTS"];
		$dspArray[$planCnt]["JOB_MONEY"] = $data["JOB_MONEY"];
		$dspArray[$planCnt]["JOB_WORKTIME"] = $data["JOB_WORKTIME"];

		$dspArray[$planCnt]["JOB_AREA_LIST"] = $data["JOB_AREA_LIST"];
		$dspArray[$planCnt]["JOB_SEASON_LIST"] = $data["JOB_SEASON_LIST"];
		$dspArray[$planCnt]["JOB_COMPANYTYPE_LIST"] = $data["JOB_COMPANYTYPE_LIST"];
		$dspArray[$planCnt]["JOB_EMPLOYTYPE_LIST"] = $data["JOB_EMPLOYTYPE_LIST"];
		$dspArray[$planCnt]["JOB_COMPANYTYPE_LIST"] = $data["JOB_COMPANYTYPE_LIST"];
		$dspArray[$planCnt]["JOB_KINDTYPE_LIST"] = $data["JOB_KINDTYPE_LIST"];
		$dspArray[$planCnt]["JOB_ICON_LIST"] = $data["JOB_ICON_LIST"];

//		if ($dspArray[$planCnt]["money_all"] == "" or $dspArray[$planCnt]["money_all"] > $data["money_all"]) {
//			$dspArray[$planCnt]["money_1"] = $data["money_1"];
//			$dspArray[$planCnt]["money_all"] = $data["money_all"];
//		}

//		$dspArray[$planCnt]["SHOP_ID"] = $data["SHOP_ID"];
//		$dspArray[$planCnt]["SHOP_NAME"] = $data["SHOP_NAME"];
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

//print_r($collection);

// ordertype料金安順と料金高順
function array_sort($arr,$keys,$type='asc'){ 
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array; 
}

if($collection->getByKey($collection->getKeyValue(), "orderdata") == "1"){
	$dspArray = array_sort($dspArray,'money_all');
}
if($collection->getByKey($collection->getKeyValue(), "orderdata") == "2"){
	$dspArray = array_sort($dspArray,'money_all','dsc');
}



$inputs = new inputs();

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$job->setErrorFirst("エリアデータの読み込みに失敗しました");
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
		'totalItems' => $job->getMaxCount(),   // ページング対象データの総数
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
<?php require("includes/box/common/meta201505.php"); ?>
<title>お仕事情報検索 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="お仕事情報,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="お仕事情報の検索ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>



</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="detail_n" class="search">

    <ul id="panlist">
        <li><a href="n_job.html">お仕事情報TOP</a></li>
        <li><span>お仕事情報の検索結果</span></li>
    </ul>

 <img src="images/job/img_jobsearch.jpg" width="950" height="150" alt="仕事情報一覧">
    <!--searchbox-->
    <?php require("includes/box/job/searchbox.php");?>
    


    <!--searchresult-->
<!--    <ul class="tab">
    	<li class="tab1"><a href="javascript:void(0)" onclick="document.<?php print $formnamePlan?>.submit();">企業で探す</a></li>
        <li class="tab2 currenttab"><a>お仕事情報で探す</a></li>
    </ul>
-->
    <section class="mainbox resultbox_job form">
	<div class="result_sort cf">
    	<?php $scope = $pager->getOffsetByPageId()?>
    	<div class="result">検索結果：<b><?php print $job->getMaxCount()?>件</b>のお仕事情報のうち <b><?php print $scope['0']?></b>件～<b><?php print $scope['1']?></b>件を表示</div>

      <?/*  <div class="order">
        	並び替え
            <div class="selectbox">
                <div class="select-inner select4"><span></span></div>
                <select class="select4" name="orderdata">
                    <option value="" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="")?'selected="selected"':''?>>人気順</option>
                    <option value="1" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="1")?'selected="selected"':''?>>料金が安い順</option>
                    <option value="2" <?php print ($collection->getByKey($collection->getKeyValue(), "orderdata")=="2")?'selected="selected"':''?>>料金が高い順</option>
                </select>
            </div>*/?>
		<script type="text/javascript">
		    function ordertype_submit(ordertype){
		    	$("input[name='orderdata']").val(ordertype);
		    	document.frmResearch.submit();
			}
		</script>
		<!--<div class="order">
			<dl>
				<dt>並び替え<dt>
				<input type="hidden" name="orderdata" value="" />
				<dd><a href="javascript: ordertype_submit(0);">人気順</a><dd>
				<dd><a href="javascript: ordertype_submit(1);">料金が安い順</a><dd>
				<dd><a href="javascript: ordertype_submit(2);">料金が高い順</a><dd>
			</dl>
		</div>-->
		

        
        <?php if ($navi["back"] != "" or $navi["next"] != "") {?>
        <ul class="navigation-se">
        	<?php if ($navi["back"] != "") {?>
            <li class="prev"><?=$navi["back"]?> | </li>
            <?php }?>
            <?=$navi["pages"]?>
            <!--<li class="current">1 | </li>
            <li><a href="#">2</a> | </li>
            <li><a href="#">3</a> | </li>
            <li><a href="#">4</a> | </li>
            <li><a href="#">5</a> | </li>
            <li><a href="#">6</a> | </li>
            <li><a href="#">7</a> | </li>
            <li><a href="#">8</a> | </li>
            <li><a href="#">9</a> | </li>
            <li><a href="#">10</a> | </li>-->
            <?php if ($navi["next"] != "") {?>
            <li class="next"><?=$navi["next"]?></li>
            <?php }?>
        </ul>
		<?php }?>
		
	</div>

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>

        <!--item-->
		<article style="min-height:235px;">
        	<div class="inner cf">
    	    	<div class="innerhed cf">
    	    		<!--<span class="option01"></span>-->
	        		<h3>
	        		<?php $formname = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["JOBPLAN_ID"];?>
		        	<form action="job-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><B><?php print $plandata["JOB_NAME"]?></B></a>
	            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	            	<?php print $inputs->hidden("JOBPLAN_ID", $plandata["JOBPLAN_ID"])?>
		        	</form>
	        		</h3>
        		</div>
			<div class="inner-plan cf">
        		<div class="hotel-subinfo cf">
				<div class="icon_img">
	        		<ul class="type-h">
        					<?php 
						$arEmploy = "";
						$arTemp = explode(":", $plandata["JOB_EMPLOYTYPE_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arEmploy[$data] = $data;
							
        							}
        						}
		        			}
						$dataEmploy = cmJobEmploy();
						if (count($dataEmploy) > 0) {
							foreach ($dataEmploy as $k=>$v) {
								if ($arEmploy[$k] != "") {
									echo "<li class='type radius5 cf'>".$v."</li>";
								}
							}
						}
						?>
	        		</ul>
        			<?php if ($plandata["JOB_PIC2"] != "") {?>
        			<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $plandata["JOB_PIC2"]?>" width="248" height="165" class="fl-l" alt="<?php print $plandata["JOB_NAME"]?>"></a>
        			<?php }else{?>
        			<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="248" height="165" class="fl-l" alt="<?php print $plandata["JOB_NAME"]?>"></a>
        			<?php }?>
      			<div class="s-txt-dates">掲載期間：<?php $fromDate = cmDateDivide($plandata["JOB_SHOW_FROM"])?>
      			<?php $toDate = cmDateDivide($plandata["JOB_SHOW_TO"])?>
      			<?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?>～<?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?></div>

				</div>

      				<h4 class="hotel-copy">
      				<?php $formname = "frm".$plandata["COMPANY_ID"]."_".$plandata["JOBPLAN_ID"];?>
		        	<form action="job-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
						<?php /*<span class="new">NEW</span>*/?><!--<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><?php print $plandata["JOB_NAME"]?></a>-->
		            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
		            	<?php print $inputs->hidden("JOBPLAN_ID", $plandata["JOBPLAN_ID"])?>
		        	</form></h4>

		<div class="hotel-text">
				<ul class="2c">
        					<?php
						$arIcon = "";
						$arTemp = explode(":", $plandata["JOB_ICON_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arIcon[$data] = $data;
        							}
        						}
		        			}
						$dataIcon = cmJobIcon();
						$cnt = 0;
						if (count($dataIcon) > 0) {
							foreach ($dataIcon as $k=>$v) {
								$cnt++;
								if ($cnt > 35) {
									break;
								}
								$checked = '';
								if ($arIcon[$k] != "") {
									echo "<li class='icon radius5' style='background: #e5e5e5; color:#000; max-width:150px;'>".$v."</li>";
								}
							}
						}
						?>
        				</ul>
        			<div class="hotel-text ss-text">
		
		    <table class="job_detail">
			<tr>
				<th>業種</th>
				<td>
				<ul class="2c">
        					<?php
						$arCompany = "";
						$arTemp = explode(":", $plandata["JOB_COMPANYTYPE_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arCompany[$data] = $data;
        							}
        						}
		        			}
						$dataCompany = cmJobCompany();
						$cnt = 0;
						if (count($dataCompany) > 0) {
							foreach ($dataCompany as $k=>$v) {
								$cnt++;
								if ($cnt > 15) {
									break;
								}
								$checked = '';
								if ($arCompany[$k] != "") {
									echo "<li>".$v."</li>";
								}
							}
						}
						?>
        				</ul>

				</td>
			</tr>
			<tr>
				<th>職種</th>
				<td>
				<ul class="2c">
        					<?php
						$arKind = "";
						$arTemp = explode(":", $plandata["JOB_KINDTYPE_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arKind[$data] = $data;
        							}
        						}
		        			}
						$dataKind = cmJobKind();
						$cnt = 0;
						if (count($dataKind) > 0) {
							foreach ($dataKind as $k=>$v) {
								$cnt++;
								if ($cnt > 15) {
									break;
								}
								$checked = '';
								if ($arKind[$k] != "") {
									echo "<li>".$v."</li>";
								}
							}
						}
						?>
        				</ul>

				</td>
			</tr>
			<tr>
				<th>勤務地</th>
				<td>
				<ul class="2c">
        					<?php
						$arArea = "";
						$arTemp = explode(":", $plandata["JOB_AREA_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arArea[$data] = $data;
        							}
        						}
		        			}
						$dataArea = cmJobArea();
						$cnt = 0;
						if (count($dataArea) > 0) {
							foreach ($dataArea as $k=>$v) {
								$cnt++;
								if ($cnt > 27) {
									break;
								}
								$checked = '';
								if ($arArea[$k] != "") {
									echo "<li>".$v."</li>";
								}
							}
						}
						?>
        				</ul>

				</td>
			</tr>
			<tr>
				<th>仕事内容</th>
				<td><?php print $plandata["JOB_CONTENTS"]?></td>
			</tr>
			<tr>
				<th>勤務時間</th>
				<td><?php print $plandata["JOB_WORKTIME"]?></td>
			</tr>
			<tr>
				<th>応募先</th>
				<td><?php print $plandata["JOBCOMPANY_NAME"]?></td>
			</tr>
		    </table>
       			</div>
			<div>
				<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();" class="job_btn" alt="詳しい情報を見る"></a>
			</div>
        		</div>

		</div>
        	</div>
		</article>

                <!--/item-->
	        <?php }?>
        <?php }?>


		<?php if ($navi["back"] != "" or $navi["next"] != "") {?>
        <ul class="navigation-se">
        	<?php if ($navi["back"] != "") {?>
            <li class="prev"><?=$navi["back"]?> | </li>
            <?php }?>
            <?=$navi["pages"]?>
            <!--<li class="current">1 | </li>
            <li><a href="#">2</a> | </li>
            <li><a href="#">3</a> | </li>
            <li><a href="#">4</a> | </li>
            <li><a href="#">5</a> | </li>
            <li><a href="#">6</a> | </li>
            <li><a href="#">7</a> | </li>
            <li><a href="#">8</a> | </li>
            <li><a href="#">9</a> | </li>
            <li><a href="#">10</a> | </li>-->
            <?php if ($navi["next"] != "") {?>
            <li class="next"><?=$navi["next"]?></li>
            <?php }?>
        </ul>
		<?php }?>
		<br/><br/><br/>

    </section>

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
