<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/job.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobShop.php');

$dbMaster = new dbMaster();

//  print_r($_POST);exit;
$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
//会員しか見えない
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}

$collection = new collection($db);

if($_POST){
	$collection->setPost();
}
else {
	$collection->setByKey($collection->getKeyValue(), "SHOP_ID", $_GET["shop_id"]);
	$collection->setByKey($collection->getKeyValue(), "COMPANY_ID", $_GET["company_id"]);
	$collection->setByKey($collection->getKeyValue(), "JOBPLAN_ID", $_GET["jobplan_id"]);
//	$collection->setByKey($collection->getKeyValue(), "night_number", $_GET["night_number"]);
//	$collection->setByKey($collection->getKeyValue(), "room_number", $_GET["room_number"]);
//	$collection->setByKey($collection->getKeyValue(), "adult_number1", $_GET["adult_number1"]);
	
/*
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "2");
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y年m月d日'));
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
	cmSetHotelSearchDef($collection);
*/
}


$jobTarget = new job($dbMaster);
$jobTarget->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

$jobBookset = new jobBookset($dbMaster);
$jobBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));


	//	ココモ
	$jobPlanTarget = new jobPlan($dbMaster);
	$jobPlanTarget->select($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"), "2", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

	$jobShop = new jobShop($dbMaster);
	$jobShop->select($collection->getByKey($collection->getKeyValue(), "SHOP_ID"), "1", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
	
	foreach ($jobPlanTarget->getCollection() as $plan) {
		//print_r($plan);
	}
	foreach ($collection->getCollection() as $param) {
		//print_r($param);
	}



$job = new job($dbMaster);

$jobBooking = new jobBooking($dbMaster);
// $collection->setByKey($collection->getKeyValue(), "JOBPLAN_ID", "");
// $collection->setByKey($collection->getKeyValue(), "ROOM_ID", "");
$job->selectListPublicHotel($collection);

$planCnt = 0;
$dspArray = array();

//$money_1 = "";
//$money_all = "";

if ($job->getCount() > 0) {
	foreach ($job->getCollection() as $data) {
		$dspArray[$data["SHOP_ID"]]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$data["SHOP_ID"]]["JOBPLAN_ID"] = $data["JOBPLAN_ID"];
		$dspArray[$data["SHOP_ID"]]["JOB_NAME"] = $data["JOB_NAME"];
//		$dspArray[$data["SHOP_ID"]]["money_1"] = $data["money_1"];
//		$dspArray[$data["SHOP_ID"]]["money_all"] = $data["money_all"];
		$dspArray[$data["SHOP_ID"]]["SHOP_ID"] = $data["SHOP_ID"];
		$dspArray[$data["SHOP_ID"]]["SHOP_NAME"] = $data["SHOP_NAME"];
		$dspArray[$data["SHOP_ID"]]["JOB_SHOW_FROM"] = $data["JOB_SHOW_FROM"];
		$dspArray[$data["SHOP_ID"]]["JOB_SHOW_TO"] = $data["JOB_SHOW_TO"];
		$dspArray[$data["SHOP_ID"]]["JOB_CATCH"] = $data["JOB_CATCH"];
		$dspArray[$data["SHOP_ID"]]["JOB_FEATURE"] = $data["JOB_FEATURE"];
		$dspArray[$data["SHOP_ID"]]["JOB_CONTENTS"] = $data["JOB_CONTENTS"];
		$dspArray[$data["SHOP_ID"]]["JOB_CONDITION"] = $data["JOB_CONDITION"];
		$dspArray[$data["SHOP_ID"]]["JOB_ACCESS"] = $data["JOB_ACCESS"];
		$dspArray[$data["SHOP_ID"]]["JOB_MONEY"] = $data["JOB_MONEY"];
		$dspArray[$data["SHOP_ID"]]["JOB_WORKTIME"] = $data["JOB_WORKTIME"];
		$dspArray[$data["SHOP_ID"]]["JOB_HOLYDAY"] = $data["JOB_HOLYDAY"];
		$dspArray[$data["SHOP_ID"]]["JOB_TREAT"] = $data["JOB_TREAT"];
		$dspArray[$data["SHOP_ID"]]["JOB_MEMO"] = $data["JOB_MEMO"];
		$dspArray[$data["SHOP_ID"]]["JOB_CONTACT"] = $data["JOB_CONTACT"];
	}
}
// print_r($collection);exit;


$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$jobTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("includes/box/common/meta201505.php"); ?>
<title>お仕事情報の詳細 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="お仕事情報,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="お仕事情報の詳細ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- ?窗 -->
<link rel="stylesheet" href="<?php print URL_SLAKER_COMMON?>css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/popupwindow-1.6.js"></script>
<style>
.dspNon {
	display: none;
}
</style>
<script>
//?窗
var pop;
function openChildSet() {
	<?php for ($i=1; $i<=6; $i++) {?>
	var num<?php print $i?> = $("#child_number<?php print $i?>").val();
	<?php }?>
	var rheight = 110 + (170*parseInt($("#room_number").val()));
	if (rheight > 620) {
		rheight = 620;
	}
	pop= new $pop('popchildset_plandetail.php?num1='+num1+'&num2='+num2+'&num3='+num3+'&num4='+num4+'&num5='+num5+'&num6='+num6, { type:'iframe', title:'人数設定',effect:'normal',width:650,height:rheight,windowmode:false,resize: false } );
}
function setData() {
	pop.close();
	$("#ori_adult").css("display","none");
}


$('a[href=#top]').click(function() {
    ('a:not(.calendarLink[href*=#]')
   var speed = 500;
   var href= $(this).attr("href");
   var target = $(href == "#" || href == "" ? 'html' : href);
   var position = target.offset().top;
   $('body,html').animate({scrollTop:position}, 500, 'swing');
   return false;
});
</script>
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
    <main id="detail_n" class="searchdetail">

		<ul id="panlist">
        	<li><span><a href="n_job.html">お仕事情報TOP</a></span></li>
            <li><span><a href="job-search.html">お仕事情報の検索結果</a></span></li>
            <li>お仕事情報詳細</li>
        </ul>
        
        <!--<article class="titlecase_job cf">
       		<div>
       			<h2><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "HOTEL_NAME")?></h2>
	       		<ul class="subtab-bt">
       				<li><?php $formname = "basic_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail2.html?basic=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu01.png" width"78" height="23" alt="基本情報" ></a>
       					<?php print $inputs->hidden("current_page", "1")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("JOBPLAN_ID", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					 <input type="hidden" name="search_date" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<input type="hidden" name="child_number<?= $roomNum.$i?>" value="<?php echo $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);?>">
       					<?php //print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?> 
       					<?php
       						}
       					}
       					?>
       				</form></li>
       				<li><?php $formname = "info_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail2.html?info=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu02.png" width"78" height="23" alt="宿泊プラン一覧" ></a>
       					<?php print $inputs->hidden("current_page", "2")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("JOBPLAN_ID", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					 <input type="hidden" name="search_date" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<input type="hidden" name="child_number<?= $roomNum.$i?>" value="<?php echo $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);?>">
       					<?php //print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?> 
       					<?php
       						}
       					}
       					?>
       				</form></li>
       				<li><?php $formname = "map_frmSearch".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")."_".$collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID")."_".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");?>
       				<form action="search-detail2.html?map=1" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
       					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="./images/common/tab-submenu03.png" width"78" height="23" alt="地図・アクセス" ></a>
       					<?php print $inputs->hidden("current_page", "6")?>
       					<?php print $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))?>
       					<?php print $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"))?>
       					<?php print $inputs->hidden("JOBPLAN_ID", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))?>
       					<?php print $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))?>
       					 <input type="hidden" name="search_date" type="hidden" value="<?php echo $collection->getByKey($collection->getKeyValue(), "search_date");?>">
       					<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
       					<?php print $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"))?>
       					<?php print $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"))?>
       					<?php
       					if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
       						for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
       					?>
       					<?php print $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))?>
       					<?php for ($i=1; $i<=6; $i++) {?>
       					<input type="hidden" name="child_number<?= $roomNum.$i?>" value="<?php echo $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i);?>">
       					<?php //print $inputs->hidden("child_number".$roomNum.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$i))?>
       					<?php }?> 
       					<?php
       						}
       					}
       					?>
       				</form></li>
	       		</ul>
       		</div>
       	</article>-->

        <article class="mainbox" id="ag">
			<div class="inner">
			<h2 class="gr-bg"><span class="new-b"></span><B><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_NAME")?></B></h2>
			<div class="cont">
				<div class="clearfix">
       			<ul class="icon-type">
        					<?php $arTemp = explode(":", $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_EMPLOYTYPE_LIST"));
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arEmploy[$data] = $data;
        							}
        						}
		        			}
						$dataEmploy = cmJobEmploy();
						$cnt = 0;
						if (count($dataEmploy) > 0) {
							foreach ($dataEmploy as $k=>$v) {
								$cnt++;
								if ($cnt > 4) {
									break;
								}
								$checked = '';
								if ($arEmploy[$k] != "") {
									echo "<li class=type>".$v."</li>";
								}
							}
						}
						?>
    	   		</ul>

					<!--<ul class="icon">
						<?php
						$meal = "";
						if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_BF_FLG") == 2) {
							$meal = "朝";
						}
						if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_DN_FLG") == 2) {
							$meal .= "夕";
						}
						if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_LN_FLG") == 2) {
							$meal .= "昼";
						}
						if ($meal != "") {
							$meal .= "食あり";
						}
						else {
							$meal .= "食事なし";
						}
						?>
						<li class="radius5"><?php print $meal?></li><?php /*&nbsp;&nbsp;&nbsp;<li><img src="./images/common/icon-Limit.jpg"</li> */?>
					</ul>-->
				<div class="catch_job">
					<p><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_CATCH")?></p>
				</div>
				</div>
				<div class="image_job">
				    <!--<div class="off">
				        <b>最大00％OF！</b><span>通常料金￥00,000～</span>
				        <strong>→￥00,000～</strong>
				    </div>-->
				    <div id="mainimage" class="cf">
				    	 <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC") != "" || $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC1") != "") {?>
							<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
							<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC")?>" width="300" height="200" alt="<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_NAME")?>">
							<?php }else{?>
				    		<img src="<?php print URL_PUBLIC_LINK.$jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC1")?>" width="300" height="200" alt="<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_NAME")?>">
							<?php }?>
				    	<?php }else{?>
				    		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="300" height="200" alt="<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_NAME")?>">
				    	<?php }?>
				    </div>
				<ul class="icon_job">
        					<?php $arTemp = explode(":", $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_ICON_LIST"));
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
									echo "<li>".$v."</li>";
								}
							}
						}
						?>
				</ul>
				<section class="section_job1 cf">
				    <p style="word-break:break-all;"><?php print redirectForReturn($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_FEATURE"))?></p>
				</section>
				    <ul id="subimage">
			    		<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
			    			<?php for ($i="2"; $i<=4; $i++) {?>
			    			 	<?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC".$i) != "") {?>
			    				<li><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC".$i)?>" width="300" height="200" alt="<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_NAME")?>">
			    				<?php }?>
			    			<?php }?>
			    		<?php }else{?>
			    	    	<?php for ($i=1; $i<=3; $i++) {?>
			    	    	 	<?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC".$i) != "") {?>
			    	    		<li><img src="<?php print URL_PUBLIC_LINK.$jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_PIC".$i)?>" width="300" height="200" alt="<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "TL_PLAN_PIC_CAP".$i)?>">
			    	    		<?php }?>
			    	    	<?php }?>
			    		<?php }?>
				    </ul>
				</div>
			<p class="job_title">■お仕事内容の詳細</p>
			<table class="job_detail">
				<tr class="first">
 					<th>業種</th>
					<td>
	        			<ul class="2c">
        					<?php $arTemp = explode(":", $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_COMPANYTYPE_LIST"));
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
        					<?php $arTemp = explode(":", $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_KINDTYPE_LIST"));
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
					<td>那覇市安里</td>
				</tr>
				<tr>
 					<th>仕事No</th>
					<td>J-<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "COMPANY_ID")?>-<?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_ID")?></td>
				</tr>
				<tr>
 					<th>アクセス</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_ACCESS")?></td>
				</tr>
				<tr>
 					<th>仕事内容</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_CONTENTS")?></td>
				</tr>
				<tr>
 					<th>給与</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_MONEY")?></td>
				</tr>
				<tr>
 					<th>勤務時間</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_WORKTIME")?></td>
				</tr>
				<tr>
 					<th>休日</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_HOLYDAY")?></td>
				</tr>
				<tr>
 					<th>待遇</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_TREAT")?></td>
				</tr>
				<tr>
 					<th>応募資格</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_CONDITION")?></td>
				</tr>
				<tr>
 					<th>備考</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_MEMO")?></td>
				</tr>
			</table>

			<p class="job_title">■会社概要</p>
			<table class="job_detail">
				<tr class="first">
 					<th>社名</th>
					<td><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOBCOMPANY_NAME")?></td>
				</tr>
				<tr>
 					<th>住所</th>
					<td>〒<?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOB_ZIP")?><br/>
					<?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOB_PREF")?><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOB_CITY")?><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOB_ADDRESS")?></td>
				</tr>
				<tr>
 					<th>電話番号</th>
					<td><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOB_TEL")?></td>
				</tr>
				<tr>
 					<th>URL</th>
					<td><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOBCOMPANY_URL")?></td>
				</tr>
				<tr>
 					<th>事業内容</th>
					<td><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOBCOMPANY_DETAIL")?></td>
				</tr>
				<tr>
 					<th>設立</th>
					<td><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOBCOMPANY_DATE")?></td>
				</tr>
				<tr>
 					<th>代表</th>
					<td><?php print $jobTarget->getByKey($jobTarget->getKeyValue(), "JOB_ORNER")?></td>
				</tr>
			</table>
			<p class="job_title">■応募方法</p>
			<table class="job_detail">
				<tr class="first">
 					<th>お申込み</th>
					<td><?php print $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_CONTACT")?></br>
				</tr>
			<!--	<tr>
 					<th>お電話での応募</th>
					<td>000-0000-0000　（採用担当まで）</td>
				</tr>
				<tr>
 					<th>メールで応募</th>
					<td>recruit@○○○.net</td>
				</tr>
			-->
				<tr>
 					<th>掲載期間</th>
					<td><?php $fromDate = cmDateDivide($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_SHOW_FROM"))?>
					<?php $toDate = cmDateDivide($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOB_SHOW_TO"))?>
					<?php 
					if($fromDate["y"] == "0000"){
						print "～";
					}
					else {
						print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"."～".$toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日";
					}
					?>
</td>
				</tr>
			</table>
	<br/>
			<div style="margin-left:35%;">
			<a href="https://cocotomo.net/contact_hotelform.html"><img src="/images/job/btn_form.png" width="286" height="73" alt="この求人に応募する"></a>
			</div>

			<!--
				<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
				<section class="section_job2">
				    <h3>○特 典</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_CONTENTS"))?></p>
				</section>
			-->
			<!--	<?php }?>
				
				 <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_BF_FLG") == 2
			    		or $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_DN_FLG") == 2
			    		or $jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_LN_FLG") == 2) {?>
			    <section class="section3">
			        <h3>○お食事</h3>
			        <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_BF_FLG") == 2) {?>
			        <p><span class="icon radius5">朝食</span></p>
			        <?php }?>
			        <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_FOOD1") != "") {?>
			        <p><?php print redirectForReturn($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_FOOD1"))?></p>
			        <?php }?>
			
			        <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_DN_FLG") == 2) {?>
			        <p><span class="icon radius5">夕食</span></p>
			        <?php }?>
			        <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_FOOD2") != "") {?>
			        <p><?php print redirectForReturn($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_FOOD2"))?></p>
			        <?php }?>
			
			        <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_LN_FLG") == 2) {?>
			        <p><span class="icon radius5">昼食</span></p>
			        <?php }?>
			        <?php if ($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_FOOD3") != "") {?>
			        <p><?php print redirectForReturn($jobPlanTarget->getByKey($jobPlanTarget->getKeyValue(), "JOBPLAN_FOOD3"))?></p>
			        <?php }?>
			    </section>
			    <?php }?>
			-->
                <!--<section class="section5">
                    <h3>○お部屋情報</h3>
                    <section>
                        <h4><span class="type">お部屋タイプ</span><?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_NAME")?></h4>
                        <div class="image">
                        	<?php if ($jobShop->getByKey($jobShop->getKeyValue(), "ROOM_PIC1") != "" || $jobShop->getByKey($jobShop->getKeyValue(), "TL_ROOM_PIC") != "") {?>
								<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
                        		<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_PIC1")?>" width="156" height="116" alt="<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_NAME")?>">
								<?php }else{?>
                        		<img src="<?php print URL_PUBLIC_LINK.$jobShop->getByKey($jobShop->getKeyValue(), "TL_ROOM_PIC")?>" width="156" height="116" alt="<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_NAME")?>">
								<?php }?>
                            <?php }else{?>
                        	<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="156" height="116" alt="<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_NAME")?>">
                            <?php }?>
                            <?php /*
                            <ul>
                                <li>・<a href="#">360度ビューで見る</a></li>
                                <li>・<a href="#">フォトギャラリーへ</a></li>
                            </ul>
                            */?>
                        </div>
                        <div class="text2">
                            <ul>
								<?php if($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == ""){ ?>
                                <li>広さ：<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_BREADTH")?>㎡／定員：<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_CAPACITY_FROM")?>～<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_CAPACITY_TO")?>人</li>
								<?php }else{?>
								<li>定員：<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_CAPACITY_FROM")?>～<?php print $jobShop->getByKey($jobShop->getKeyValue(), "ROOM_CAPACITY_TO")?>人</li>
								<?php }?>

                                <?php /*
                                <li class="radius5">禁煙ルーム</li>
                                <li class="radius5">ネット接続OK</li>
                                <li class="radius5">バス・トイレ別</li>
                                */?>
                            </ul>
                            <p style="word-break:break-all; "><?php print redirectForReturn($jobShop->getByKey($jobShop->getKeyValue(), "ROOM_DISCRITION"))?></p>
                        </div>
                    </section>
                </section>-->


                </div>
            </div>
        </article>
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
