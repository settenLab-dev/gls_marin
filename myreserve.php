<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

/*
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}
*/

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));


$booking = new shopBooking($dbMaster);
$booking->selectList($collection);



$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_detail.php"); ?>
<title>予約の確認 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="content">

        <!--日付・人数から検索-->
        <section class="box">
			<div class="inner">
        	<div id="hmenu_cn" class="radius10">
    	    	<menu class="mypge-menu">
	        		<li><a href="<?php print URL_PUBLIC?>mypage.html">マイページトップ</a></li>
	        		<li><a href="<?php print URL_PUBLIC?>mybasic.html">会員基本情報確認・変更</a></li>
        			<li><a href="<?php print URL_PUBLIC?>myhotel.html">予約の確認</a></li>
     <!--   			<li><a href="<?php print URL_PUBLIC?>mycoupon.html">購入したクーポン</a></li>-->
     <!--   			<li><a href="<?php print URL_PUBLIC?>mypoint.html">ポイント履歴</a></li>-->
        			<li><a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></li>
    	    	</menu>
	        	<div class="bt-logout_cn">
        			<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
        	         <p class="bt-td"><?=$inputs->submit("","logout","ログアウト", "circle")?></p>
    	       		</form>
	           	</div>
           	</div>

        	<h2 class="title">現在の予約情報</h2>

        	<p>こんにちは！ <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?>さん。</p>
        	<p>以下より予約したプランの確認・キャンセルを行うことができます。</p>
        	<br />

        	<?php
				require("includes/box/hotel/listBooking.php");
			?>
			</div>
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
