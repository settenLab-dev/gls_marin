<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);

// $hotel = new hotel($dbMaster);
// $hotel->selectListPublic($collection);

// print_r($hotel->getCollection());

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!--<link href="<?=URL_PUBLIC?>css/style.css" rel="stylesheet" type="text/css">-->
<link rel="stylesheet" href="<?=URL_SLAKER_COMMON?>css/common.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=URL_PUBLIC?>css/base.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=URL_PUBLIC?>css/style2.css" type="text/css" media="screen" />
<!--<link rel="stylesheet" href="<?=URL_PUBLIC?>css/new-style.css" type="text/css" media="screen" />-->
<link rel="stylesheet" href="<?=URL_PUBLIC?>js/slider/jquery.bxslider.css" type="text/css" media="screen">
<link href="<?=URL_PUBLIC?>js/scroller/li-scroller.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?=URL_PUBLIC?>js/jquery-1.10.2.min.js"></script>
<script src="<?=URL_PUBLIC?>js/scroller/jquery.li-scroller.1.0.js"></script>
<script type="text/javascript" src="<?=URL_PUBLIC?>js/common.js"></script>
<script type="text/javascript" src="<?=URL_PUBLIC?>js/slider/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?=URL_PUBLIC?>js/function.js"></script>

<!--[if lt IE 9]>
<script src="<?=URL_PUBLIC?>js/html5shiv.js"></script>
<script src="<?=URL_PUBLIC?>js/PIE.js"></script>
<![endif]-->

<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title>フライボードを気軽に体験しよう！ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>

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
	<main id="opensale" class="">
    
    	<!--top-image-->

		<ul id="panlist">
        	<li><span><a href="index.html">TOPページ</a></span></li>
            <li>フライボードを気軽に体験しよう！</li>
        </ul>

		<!--topimage-->
		<div id="opensale_cn">
		<img src="./images/opnesale/flytop.jpg" width="698" height="250" alt="" /></br>
			<!--<section id="topimage">
			</section>--></br>

<!--PlanningOpensele-->
		
			
			<!--plan1-->
			<section id="plan1" class="waku_s2">
				<h2><img src="./images/opnesale/fly1.png" width="664" height="53" alt=" /></h2>
				<article id="opensale_cn">
				<div class="inner cf">
						<p>フライボードは、まるで空中散歩をするように空を飛ぶことができる、今TVや雑誌で話題沸騰中のレジャー！初めての人でも少し練習すれば、すぐ空を飛べるかんたんさも人気の一つ♪空から見渡す海の眺めは気分爽快！みなさんも気軽に体験してみませんか！</p>
						</div>
						<img src="./images/opnesale/fly3.jpg" width="175" height="100" alt="Fly Board Okinawa" class="img">
						<p><a href="http://cocotomo.net/leisure-detail39.html"><img src="./images/opnesale/flylink.png" width="407" height="32" alt="Fly Board Okinawa"></a></p>
				
					</article>
			</section>

			<!--plan1-->
			<section id="plan1" class="waku_s2">
				<h2><img src="./images/opnesale/fly2.png" width="664" height="53" alt=" /></h2>
				<article id="opensale_cn">
				<div class="inner cf">
					<div class="fl-l">
						<p>10/26（土）放送のTV番組『うちな～なんば～ワン』でも放送！ココトモ！なら、どこよりもお得にフライボードが楽しめる！
						なんと、ココトモ！限定でフライボードが40％OFF！通常15分￥5000のところを15分￥3000で体験できるんです！
						お得になる方法はかんたん。ココトモ！に無料会員登録して、クーポンをGETするだけ♪</br>今すぐ予約して遊びに行っちゃいましょう！</p>
						<img src="./images/opnesale/flyprice.png" width="636" height="173" alt="Fly Board Okinawa">
					</div>
									</div>
					</article>
					<article>
					<ul class="wakuList cf">
						<li>
							<div class="plan_h"><B><font color="blue">【STEP1】ココトモ！無料会員登録</font></B></div>
							<div class="plan_h">ココトモ！は使うたび、いろんな特典と交換できる楽しいポイントがどんどん貯まる！お買いもの・宿泊予約もお得♪沖縄県民限定・会員登録無料！
								</br><a href="http://cocotomo.net/intro.html">⇒ココトモ！についてもっと詳しく</a>
							</div>
							<a href="http://cocotomo.net/regist.html"><img src="http://cocotomo.net/images/common/side-bt-registration.png" width="180" height="60" /></a>
						</li>
						<li>
							<div class="plan_h"><B><font color="blue">【STEP2】お得なクーポンをGET！</font></B></div>
							<div class="plan_h">クーポンを印刷または携帯・スマホの画面に表示してお持ちください。ココトモ！クーポンがないと割引を適用できないのでご注意を！</br>
							※クーポンの表示には会員ログインが必要です。</br></br>
							<a href="http://cocotomo.net/leisure-coupon39.html"><img src="http://cocotomo.net/images/category/bt_coupon-display.jpg" width="190" height="33"></a>
							</div>
						</li>
						<li class="r-sp">
							<div class="plan_h"><B><font color="blue">【STEP3】お店に予約して楽しむ！</font></B></div>
							<div class="plan_h">
								ご予約はお電話で！「ココトモ！を見て！」とお伝えください。</br></br>
								<B>◆フライボードオキナワ</B></br>
							<img class="fl-l" src="./images/opnesale/flytel.png" width="204" height="86" alt="090-2410-2810" /></div>
						</li>
						</ul></article>
			</section>
			
				<!--terms-->
				<section>
					<div>
						<div>
						</div>
					</div>
				</section>
		</div>

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

