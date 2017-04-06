<?php
require_once('includes/applicationInc.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");


$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);

$collection->setByKey($collection->getKeyValue(), "top_area", 1);
$inputs = new inputs(); ?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title>ココトモ新規会員登録キャンペーン開催中！<?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>

<link rel="stylesheet" href="<?php print URL_SLAKER_COMMON?>css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_SLAKER_COMMON?>js/popupwindow-1.6.js"></script>
<style>
.dspNon {
	display: none;
}
</style>
<script type="text/javascript">
var pop;
function openChildSet() {
	<?php for ($i=1; $i<=6; $i++) {?>
	var num<?php print $i?> = $("#child_number<?php print $i?>").val();
	<?php }?>
	var rheight = 110 + (170*parseInt($("#room_number").val()));
	if (rheight > 620) {
		rheight = 620;
	}
	pop= new $pop('popchildset.php?num1='+num1+'&num2='+num2+'&num3='+num3+'&num4='+num4+'&num5='+num5+'&num6='+num6, { type:'iframe', title:'人数設定',effect:'normal',width:650,height:rheight,windowmode:false,resize: false } );
}
function setData() {
	pop.close();
	$("#ori_adult").css("display","none");
}
</script>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_n.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->

<!-- InstanceEndEditable -->

<!--Content-->
<div id="content" class="clearfix" style="padding:0; ">

<!-- /mainimage-->

<!--main-->
<main id="cpn_topbox">
<div id="cpn_top">

<img src="./images/cpn201508_top/img_12.jpg" alt="" class="img_center">
<img src="./images/cpn201508_top/img_13.jpg" alt="" class="img_center">
<img src="./images/cpn201508_top/img_14.jpg" alt="" class="img_center"><br/>

<div id="topcpn_main">
<div class="cpn_contents">
<img src="./images/cpn201508_top/img_15.jpg" alt="" class="img_center"><br/>
<a href="/cpn_newer201509.html">
<img src="./images/cpn201508_top/img_16.jpg" alt="" class="img_center">
</a>
</div>

<div class="cpn_contents">
<img src="./images/cpn201508_top/img_6.jpg" alt="" class="img_center"><br/>
<a href="/cpn_coupon201508.html">
<img src="./images/cpn201508_top/img_7.jpg" alt="" class="img_center">
</a>
</div>

<div class="cpn_contents">
<img src="./images/cpn201508_top/img_8.jpg" alt="" class="img_center"><br/>
<a href="/cpn_hotel201508.html">
<img src="./images/cpn201508_top/img_9.jpg" alt="" class="img_center">
</a>
</div>

<br/><br/>
<img src="./images/cpn201508_top/img_10.jpg" alt="" class="img_center"><br/>
<img src="./images/cpn201508_top/img_11.jpg" alt="" class="img_center"><br/>

</div>

<a href="/intro.html"><img src="./images/cpn201508_ice/submit_btn.png" alt="会員登録はこちら" class="img_center"></a>
</div>

</div>
		</main>
<!-- /main-->
</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_n.php");?>
<!--/footer-->
</body>
<!-- InstanceEnd --></html>
