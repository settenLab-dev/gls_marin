<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');
require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
	$collection->setPost();

if($_POST){
	$collection->setPost();
//	cmSetHotelSearchDef($collection);
}
else {
	$collection->setByKey($collection->getKeyValue(), "KUCHIKOMI_ID", $_GET["id"]);
	if($_GET["search_date"] != ""){
		$collection->setByKey($collection->getKeyValue(), "search_date", $_GET["search_date"]);
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "2");
	}
	else {
		$collection->setByKey($collection->getKeyValue(), "search_date", date('Y年m月d日'));
		$collection->setByKey($collection->getKeyValue(), "undecide_sch", "1");
	}
}

// print_r($collection->getCollection());
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
$kuchikomi = new kuchikomi($dbMaster);
	$kuchikomi->selectListPublicKuchikomi($collection);



$planCnt = 0;
$dspKArray = array();
if ($kuchikomi->getCount() > 0) {
	foreach ($kuchikomi->getCollection() as $kuchidata) {
	//	print_r($kuchidata);
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_ID"] = $kuchidata["KUCHIKOMI_ID"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_USE_DATE"] = $kuchidata["KUCHIKOMI_USE_DATE"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_NAME"] = $kuchidata["KUCHIKOMI_NAME"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_FACILITY_NAME"] = $kuchidata["KUCHIKOMI_FACILITY_NAME"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_TITLE"] = $kuchidata["KUCHIKOMI_TITLE"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_DETAIL"] = $kuchidata["KUCHIKOMI_DETAIL"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_PIC1"] = $kuchidata["KUCHIKOMI_PIC1"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_AREA"] = $kuchidata["KUCHIKOMI_AREA"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_CATEGORY"] = $kuchidata["KUCHIKOMI_CATEGORY"];
	}
}

//キーワード検索初期化
$collection->setByKey($collection->getKeyValue(), "free", "");
// print_r($dspArray);

// ordertype料金安順と料金高順
/*
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

*/

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
		'totalItems' => $kuchikomi->getMaxCount(),   // ページング対象データの総数
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

<title>クチコミ一覧 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="クチコミ,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="クチコミ検索のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
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
        <li><a href="index.html">TOP</a></li>
        <li><span>クチコミ一覧</span></li>
    </ul>

<img src="images/kuchikomi/img_kuchikomi.jpg" width="950" height="150" alt="クチコミ一覧">
    <!--searchbox-->
    <?php require("includes/box/hotel/searchbox_kuchikomi.php");?>
    
	<?php $formnamePlan = "frmFacSearch";?>
	<form action="kuchikomi-search.html" method="post" id="<?php print $formnamePlan?>" name="<?php print $formnamePlan?>">
	<?php print $inputs->hidden("area", $collection->getByKey($collection->getKeyValue(), "area"))?>
	<?php print $inputs->hidden("category", $collection->getByKey($collection->getKeyValue(), "category"))?>
	<?php print $inputs->hidden("free", $collection->getByKey($collection->getKeyValue(), "free"))?>
	</form>


    <!--searchresult-->
    <section class="mainbox resultbox form">
	<div class="result_sort cf">
    	<?php $scope = $pager->getOffsetByPageId()?>
    	<div class="result">検索結果：<b><?php print $kuchikomi->getMaxCount()?>件</b>のクチコミのうち <b><?php print $scope['0']?></b>件～<b><?php print $scope['1']?></b>件を表示</div>
<?php /* ?>
		<script type="text/javascript">
		    function ordertype_submit(ordertype){
		    	$("input[name='orderdata']").val(ordertype);
		    	document.frmResearch.submit();
			}
		</script>
		<div class="order">
			<dl>
				<dt>並び替え<dt>
				<input type="hidden" name="orderdata" value="" />
				<dd><a href="javascript: ordertype_submit(0);">人気順</a><dd>
				<dd><a href="javascript: ordertype_submit(1);">料金が安い順</a><dd>
				<dd><a href="javascript: ordertype_submit(2);">料金が高い順</a><dd>
			</dl>
		</div>
<?php */ ?>

        
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


        <?php if (count($dspKArray) > 0) {?>
		<?php foreach ($dspKArray as $plandata) {?>
        <!--item-->
		<?php //print_r($plandata);?>

		<article style="min-height:235px;">
        	<div class="inner cf">
    	    	<div class="innerhed cf">
    	    		<!--<span class="option01"></span>-->
	        		<h3>
	        		<?php $formname = "frmSearch".$plandata["KUCHIKOMI_ID"];?>
		        	<form action="kuchikomi-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();">
					<B>【
		                    	<?php
		                    	$dataCategory = cmKuchikomiCategory();
		                    	$arCategory = array();
		                    	$arTemp = explode(":", $plandata["KUCHIKOMI_CATEGORY"]);
		                    	if (count($arTemp) > 0) {
		                    		foreach ($arTemp as $dd) {
		                    			if ($dd != "") {
		                    				$arCategory[$dd] = $dd;
		                    			}
		                    		}
		                    	}
		                    	if (count($arCategory) > 0) {
		                    		foreach ($arCategory as $d) {
		                    	?>
		                    	<span><?php print $dataCategory[$d]?></span>
		                    	<?php
		                    		}
		                    	}
		                    	?>
					】<?php print cmStrimWidth($plandata["KUCHIKOMI_FACILITY_NAME"], 0, 50, '…')?>のクチコミ</B></a>
			            	<?php print $inputs->hidden("KUCHIKOMI_ID", $plandata["KUCHIKOMI_ID"])?>
		        	</form>
	        		</h3>
	        		<ul class="type-h">
	        			<!--<li class="type">施設タイプ</li>-->
	        			<?php
	        			$arArea = array();
	        			$arTemp = explode(":", $plandata["KUCHIKOMI_AREA"]);
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
	        			<li class="place"><?php print $xmlArea->getNameByValue($d)?></li>
	        			<?php
	        				}
	        			}
	        			?>
	        		</ul>
        		</div>
			<div class="inner-plan cf">
        		<div class="hotel-subinfo cf">
        			<?php if ($plandata["KUCHIKOMI_PIC1"] != "") {?>
					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="<?php print URL_SLAKER_COMMON."images/".$plandata["KUCHIKOMI_PIC1"]?>" width="248" height="165" class="fl-l" alt="<?php print $plandata["HOTELPLAN_NAME"]?>"></a>
				<?php }else{?>
					<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="248" height="165" class="fl-l" alt="<?php print $plandata["HOTELPLAN_NAME"]?>"></a>
				<?php }?>


      				<h4 class="hotel-copy">
      				<?php $formname = "frm".$plandata["KUCHIKOMI_ID"];?>
		        	<form action="kuchikomi-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
		            	<?php print $inputs->hidden("KUCHIKOMI_ID", $plandata["KUCHIKOMI_ID"])?>
		        	</form></h4>

		<div class="hotel-text">
      				<div class="hotel-text ss-text"><B><?php print $plandata["KUCHIKOMI_TITLE"]?></B></div>

      				<div class="hotel-text ss-text">利用日：<?php print date("Y年m月d日", strtotime($plandata["KUCHIKOMI_USE_DATE"]))?>/投稿者：<?php print $plandata["KUCHIKOMI_NAME"]?>さん</div>
		</div>
        			<div class="hotel-text ss-text">
        		<?php if($plandata["KUCHIKOMI_DETAIL"] != ""){print "<p>";}?><?php print cmStrimWidth($plandata["KUCHIKOMI_DETAIL"], 0, 500, '…')?>
				<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();">続きを読む>></a>
			<?php if($plandata["KUCHIKOMI_DETAIL"] != ""){print "</p>";}?>
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
