<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<title>予約完了 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->
<!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="detail" class="reservation">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>レジャー予約完了</span></li>
        </ul>


     <div class="mainbox">
        <!--日付・人数から検索-->
        <section class="box">
        	<?php /*
        	<h2 class="title"><img src="<?php print URL_PUBLIC?>images/regist2.png" width="207" height="29" alt="予約完了"></h2>
        	*/?>
        	<div id="fix_mes">
    	    	<p>ご入力頂いたメールアドレス宛てにメールを送信しました。</p>
    	    	<div>
    	    		<h3>予約が完了いたしました。</h3>
	    	    	<!--<p>予約番号:<span>Ox21275z</span></p>
    		    	<p>予約申し込み日時:<span>2013/00/00｜AM:00:00</span></p>-->
    		    </div>
	        	<p><a href="#"><img src="<?php print URL_PUBLIC?>images/form/btreservation-Confirmation.png" width="259" height="54" alt="予約内容の確認" /></a></p>
        	<div class="logout r-txt">→<a href="<?php print URL_PUBLIC?>">TOPページへ</a></div>
        	</div>

        </section>
    </div>
        
        <ul id="social">
            <li><a href="#"><img src="images/common/common-bottom-twitter.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mixi.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-gree.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-fb.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mail.png"></a></li>
        </ul>

    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->

    <!--side-->
    <?php require("includes/box/common/right.php");?>
    <!--/side-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
