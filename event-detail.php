<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/event.php');

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
	$collection->setByKey($collection->getKeyValue(), "EVENT_ID", $_GET["e_id"]);
}


$eventTarget = new event($dbMaster);
$eventTarget->selectSide($collection);
//print_r($eventTarget);
$dspEArray = array();

if ($eventTarget->getCount() > 0) {
	foreach ($eventTarget->getCollection() as $eventdata) {
	//	print_r($eventdata);
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_ID"] = $eventdata["EVENT_ID"];
	//	$dspEArray[$eventdata["EVENT_ID"]]["EVENT_POST_FROM"] = $eventdata["EVENT_POST_FROM"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_FACILITY_NAME"] = $eventdata["EVENT_FACILITY_NAME"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_TITLE"] = $eventdata["EVENT_TITLE"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_DETAIL"] = $eventdata["EVENT_DETAIL"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_PIC1"] = $eventdata["EVENT_PIC1"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_AREA"] = $eventdata["EVENT_AREA"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_CATEGORY"] = $eventdata["EVENT_CATEGORY"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_WHO"] = $eventdata["EVENT_WHO"];
	}
}
// print_r($collection);exit;

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$eventTarget->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require("includes/box/common/meta201505.php"); ?>
<title><?php print $eventdata["EVENT_NAME"] ?> ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="イベント,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="イベント詳細のページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
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
            <li><a href="event-search.html">イベント一覧</a></li>
            <li><span>イベント詳細</span></li>
        </ul>
        
        <article class="mainbox" id="ag">
			<div class="inner">
			<h2 class="bl-bg"><span class="new-b"></span><B><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_NAME"))?></B></h2>
			<div class="cont" style="margin-top:-10px;">
				<div class="tb-sp20 sealetime">
					【開催期間】<span><?php print date("Y年m月d日", strtotime($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_POST_FROM")))?>
							<?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_POST_FROM") != $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_POST_TO")){ ?>
							～<?php print date("Y年m月d日", strtotime($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_POST_TO")))?>
							<?php } ?>
					</span></br>
					【エリア】
       					<?php
					$arArea = array();
					$arTemp = explode(":", $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_AREA"));
					if (count($arTemp) > 0) {
						foreach ($arTemp as $data) {
							if ($data != "") {
								$arArea[$data] = $data;
							}
						}
					}

					$areaCnt = 0;
					if (count($arArea) > 0) {
						foreach ($arArea as $d) {
							$areaCnt++;
					?>
					<span><?php print $xmlArea->getNameByValue($d)?></span>
					<?php
							if ($areaCnt >= 2) break;
						}
					}
					?></br>

					【カテゴリ】

		                    	<?php
		                    	$dataCategory = cmEventCategory();
		                    	$arCategory = array();
		                    	$arTemp = explode(":", $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_CATEGORY"));
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

				</div>
				<div class="image">
				    <div id="mainimage">
				    	 <?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC1") != "") {?>
							<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC1")?>" width="359" height="265">
				    	<?php }else{?>
				    		<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="358" height="265" alt="<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_NAME")?>">
				    	<?php }?>
				    </div>
				    <ul id="subimage">
			    			<?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC2") != "" && $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC3") == ""){ ?>
						 		<?php for ($i=1; $i<=2; $i++) {?>
				    			 	<?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i) != "") {?>
				    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i)?>" width="84" height="75" alt="<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_NAME")?>"></a>
				    				<?php }?>
				    				<?php }?>
			    			<?php } ?>
			    			<?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC2") != "" && $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC3") != "" && $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC4") == ""){ ?>
						 		<?php for ($i=1; $i<=3; $i++) {?>
				    			 	<?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i) != "") {?>
				    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i)?>" width="84" height="75" alt="<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_NAME")?>"></a>
				    				<?php }?>
				    				<?php }?>
			    			<?php } ?>
			    			<?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC2") != "" && $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC3") != "" && $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC4") != ""){ ?>
						 		<?php for ($i=1; $i<=4; $i++) {?>
				    			 	<?php if ($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i) != "") {?>
				    				<li><a href="<?php print URL_SLAKER_COMMON?>images/<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i)?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PIC".$i)?>" width="84" height="75" alt="<?php print $eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_NAME")?>"></a>
				    				<?php }?>
				    				<?php }?>
			    			<?php } ?>
				    </ul>
				</div>
				<section class="section1 cf">
				    <p style="word-break:break-all;"><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_DETAIL"))?></p>
				</section>

				<?php if($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_NOVELTY") != ""){ ?>
				<section class="section3">
				    <h3>○特 典</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_NOVELTY"))?></p>
				</section>
				<?php }?>

				<?php if($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PRICE") != ""){ ?>
				<section class="section3">
				    <h3>○参加料金</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_PRICE"))?></p>
				</section>
				<?php }?>

				<?php if($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_ENTRY_HOW") != ""){ ?>
				<section class="section3">
				    <h3>○参加方法・参加条件</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_ENTRY_HOW"))?></p>
				</section>
				<?php }?>

				<?php if($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_ADDRESS") != ""){ ?>
				<section class="section3">
				    <h3>○開催場所・アクセス</h3>
				    <p style="word-break:break-all;">【開催場所】</br><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_ADDRESS"))?></p>
					<?php if($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_ACCESS") != ""){ ?>
				   		 <p style="word-break:break-all;">【アクセス】</br><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_ACCESS"))?></p>
					<?php }?>
				</section>
				<?php }?>

				<?php if($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_CONTACT") != ""){ ?>
				<section class="section3">
				    <h3>○問い合わせ先</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_CONTACT"))?></p>
				</section>
				<?php }?>

				<?php if($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_COMPANY") != ""){ ?>
				<section class="section3">
				    <h3>○主催</h3>
				    <p style="word-break:break-all;"><?php print redirectForReturn($eventTarget->getByKey($eventTarget->getKeyValue(), "EVENT_COMPANY"))?></p>
				</section>
				<?php }?>

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
