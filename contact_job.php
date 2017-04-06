<?php

require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/job.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobBooking.php');


///////////////////////
//	fax
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
///////////////////////


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
//if (!$sess->sessionCheck()) {
//	require_once('login.php');
//	exit;
//}


$collection = new collection($db);
$collection->setPost();
//cmSetHotelSearchDef($collection);

$job = new job($dbMaster);
$job->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
//$jobBookset = new hotelBookset($dbMaster);
//$jobBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

///////////////////////
//	fax
//$company = new company($dbMaster);
//$company->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
///////////////////////

$jobBooking = new jobBooking($dbMaster);
$is_request=false;
require_once('includes/box/job/reservjob.php');



$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!--<SCRIPT>
	history.forward();
</SCRIPT>-->
<?php require("includes/box/common/meta201505.php"); ?>
<title>求人応募フォーム ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="求人応募,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="求人応募のメールフォームです。<?php print SITE_PUBLIC_DESCRIPTION?>" />

<style type="text/css">
#formWrap {
	width:950px;
	margin:0 auto;
	color:#0000;
	line-height:120%;
	font-size:100%;
}
table.formTable{
	width:100%;
	margin:0 auto;
	border-collapse:collapse;
}
table.formTable td,table.formTable th{
	border:1px solid #ccc;
	padding:10px;
}
table.formTable th{
	width:30%;
	font-weight:normal;
	background:#ecffe3;
	text-align:left;
}
input[type="checkbox"].ExpandCheckBox {
  display: none;
}
 
input[type="checkbox"].ExpandCheckBox + .ExpandHeader {
  display:block;
 
  text-align:left;

  background-color:#ffcf72;
 
  border:solid 1px #ffcf72;
}
 
input[type="checkbox"].ExpandCheckBox:checked + .ExpandHeader {
  display:block;
 
  text-align:left;
  background-color:#ffcf72;
   
}
 
 
input[type="checkbox"].ExpandCheckBox + label + div.panel1,
input[type="checkbox"].ExpandCheckBox + label + div.panel2,
input[type="checkbox"].ExpandCheckBox + label + div.panel3,
input[type="checkbox"].ExpandCheckBox + label + div.panel4,
input[type="checkbox"].ExpandCheckBox + label + div.panel5,
input[type="checkbox"].ExpandCheckBox + label + div.panel6,
input[type="checkbox"].ExpandCheckBox + label + div.panel7,
input[type="checkbox"].ExpandCheckBox + label + div.panel8,
input[type="checkbox"].ExpandCheckBox + label + div.panel9,
input[type="checkbox"].ExpandCheckBox + label + div.panel10,
input[type="checkbox"].ExpandCheckBox + label + div.panel11,
input[type="checkbox"].ExpandCheckBox + label + div.panel12,
input[type="checkbox"].ExpandCheckBox + label + div.panel13,
input[type="checkbox"].ExpandCheckBox + label + div.panel14
{
  display: none;
}
 
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel1,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel2,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel3,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel4,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel5,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel6,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel7,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel8,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel9,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel10,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel11,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel12,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel13,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel14
{
  display: block;
}
</style>
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
	<main id="detail_n" class="reservation_n">

		<ul id="panlist">
        	<li><a href="n_job.html">お仕事情報TOP</a></li>
            <li><span>求人応募フォーム</span></li>
        </ul>

        <div>
        	<?php
			if ($jobBooking->getErrorCount() > 0) {
			?>
				<?php print create_error_caption($jobBooking->getError())?>
			<?php
			}
			?>
        	<form method="post" action="">
            	<?php
				if ($collection->getByKey($collection->getKeyValue(), "regist") and $jobBooking->getErrorCount() <= 0) {
					require("includes/box/job/completeJobResrv.php");
				}
				elseif ($collection->getByKey($collection->getKeyValue(), "confirm_x") and $jobBooking->getErrorCount() <= 0) {
					require("includes/box/job/confirmJobReserv.php");
				}
				else {
					require("includes/box/job/inputJobReserv.php");
				}
				?>
            </form>
        </div>

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
