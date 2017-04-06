<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');

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
//	cmSetHotelSearchDef($collection);
}
else {
	$collection->setByKey($collection->getKeyValue(), "KUCHIKOMI_ID", $_GET["k_id"]);
}


$kuchikomiTarget = new kuchikomi($dbMaster);
$kuchikomiTarget->selectSide($collection);
//print_r($kuchikomiTarget);
$dspKArray = array();

if ($kuchikomiTarget->getCount() > 0) {
	foreach ($kuchikomiTarget->getCollection() as $kuchidata) {
	//	print_r($kuchidata);
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_ID"] = $kuchidata["KUCHIKOMI_ID"];
	//	$dspKArray[$eventdata["KUCHIKOMI_ID"]]["KUCHIKOMI_POST_FROM"] = $kuchidata["KUCHIKOMI_POST_FROM"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_FACILITY_NAME"] = $kuchidata["KUCHIKOMI_FACILITY_NAME"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_TITLE"] = $kuchidata["KUCHIKOMI_TITLE"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_DETAIL"] = $kuchidata["KUCHIKOMI_DETAIL"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_PIC1"] = $kuchidata["KUCHIKOMI_PIC1"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_AREA"] = $kuchidata["KUCHIKOMI_AREA"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_CATEGORY"] = $kuchidata["KUCHIKOMI_CATEGORY"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_WHO"] = $kuchidata["KUCHIKOMI_WHO"];
	}
}
// print_r($collection);exit;

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotelTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("includes/box/common/meta201505.php"); ?>
<title><?php print $kuchidata["KUCHIKOMI_FACILITY_NAME"] ?>のクチコミ ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="クチコミ,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="クチコミ詳細のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- ?窗 -->
<link rel="stylesheet" href="<?php print URL_SLAKER_COMMON?>css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/popupwindow-1.6.js"></script>
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
        	<li><a href="index.html">TOP</a></li>
            <li><a href="plan-search.html">クチコミ一覧</a></li>
            <li><span>クチコミ詳細</span></li>
        </ul>
        
        <article class="mainbox" id="ag">
			<div class="inner">
			<h2 class="bl-bg"><span class="new-b"></span><B><?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_FACILITY_NAME")?></B>　のクチコミ</h2>
			<div class="cont" style="margin-top:-10px;">
				<div class="tb-sp20 sealetime">
				    <p style="word-break:break-all;"><B><?php print redirectForReturn($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_TITLE"))?></B></p>

					【利用日】<span><?php print date("Y年m月d日", strtotime($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_USE_DATE")))?>
					</span>
					/【投稿者】<span><?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_NAME")?> さん
					</span><br>
				</div>
				<div class="image">
				    <div id="mainimage">
				    	 <?php if ($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC1") != "") {?>
							<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC1")?>" width="359" height="265">
				    	<?php }else{?>
				    		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="358" height="265" alt="<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_NAME")?>">
				    	<?php }?>
				    </div>
				    <ul id="subimage">
			    			<?php if ($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC2") != "" && $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC3") == ""){ ?>
						 		<?php for ($i=1; $i<=2; $i++) {?>
				    			 	<?php if ($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i) != "") {?>
				    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i)?>" width="84" height="75" alt="<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_NAME")?>"></a>
				    				<?php }?>
				    				<?php }?>
			    			<?php } ?>
			    			<?php if ($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC2") != "" && $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC3") != "" && $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC4") == ""){ ?>
						 		<?php for ($i=1; $i<=3; $i++) {?>
				    			 	<?php if ($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i) != "") {?>
				    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i)?>" width="84" height="75" alt="<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_NAME")?>"></a>
				    				<?php }?>
				    				<?php }?>
			    			<?php } ?>
			    			<?php if ($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC2") != "" && $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC3") != "" && $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC4") != ""){ ?>
						 		<?php for ($i=1; $i<=4; $i++) {?>
				    			 	<?php if ($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i) != "") {?>
				    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_PIC".$i)?>" width="84" height="75" alt="<?php print $kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_NAME")?>"></a>
				    				<?php }?>
				    				<?php }?>
			    			<?php } ?>
				    </ul>
				</div>
				<section class="section1 cf">
				    <p style="word-break:break-all;"><?php print redirectForReturn($kuchikomiTarget->getByKey($kuchikomiTarget->getKeyValue(), "KUCHIKOMI_DETAIL"))?></p>
				</section>
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
