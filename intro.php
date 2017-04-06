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
<?php require("includes/box/common/meta201505.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title><?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>

</head>


<!-- ↓ココからHTML -->


<body id="top">


<!-- ↓ヘッダー読み込み編集不要 -->
<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!--content-->
<div id="content" class="clearfix">
<!-- merit start -->
<div id="merit">

<!-- パンくず -->
<ul class="panlist">
	<li><span><a href="index.html">TOPページ</a></span></li>
            <li>県民サイト『ココトモ！』のご紹介</li>
        </ul>
        <!-- パンくずここまで -->

<!-- main start -->
<main>

<!-- 大バナー -->
    <h1>
    <img src="images/merit/merit_banner.jpg" alt="ココトモ会員がお得な６つのメリット" width="1322" height="325" />
    </h1>
<!-- /大バナー -->

<!-- section -->
	<section>
	<h2 id="merit_h01">沖縄県内初登場！かんたん便利でお得なクーポン「ココポン」</h2>
	<P>県内初登場！県内の人気サービスや商品を中心に、期間限定、数量限定でお得に購入できます！<br>
会員だけのお得な限定クーポンが発売されることも…♪<br>
<br>
お得な時に買って、有効期限内ならいつでもご利用OK！<br>
※利用除外日、満席、満室などやむを得ずご利用いただけない場合を除きます。
<img src="images/merit/merit01_img.jpg" alt="お得に購入できて簡単便利に使えるココポン" />   </P>


    <h2 id="merit_h02">宿泊やレジャーの予約もお得！</h2>
    <P>宿泊やレジャーのお得な県民価格プランをご用意!週末のおでかけやデート、家族旅行はもちろん、お祝いや模合、<br />
    会社や団体のレクリエーションなどに気軽にご利用ください。<br>
グループ、団体でのご利用、宴会などのセッティングについてもぜひご相談ください!
<img src="images/merit/merit02_img.jpg" alt="宿泊やレジャーの予約もお得！お出かけや模合など団体での利用も便利" /></P>


    <h2 id="merit_h03">【試行中】遊んで買って楽しんでザクザク貯まる！ココトモだけのお得なポイント</h2>
    <P>会員になると、ココトモを使うたびにココトモポイントが貯まる！<br>
お買い物や宿泊・レジャー予約はもちろん、ココトモのイベントに参加したりクチコミ写真投稿でもポイントGET♪<br>
ポイントは少し貯めるだけで、いろんな特典とお得に交換できます！
※現在、試行版サービスをご提供しています。
<img src="images/merit/merit03_img.jpg" alt="１回宿泊やレジャーを楽しむだけですぐランチ券がもらえるかも" /></P>

    <h2 id="merit_h04">地元がもっと好きになる！ココトモ発のお得な企画・サービス</h2>
    <P>ココトモでは、地元の人と企業を繋ぐお手伝いをすることで、地元の素晴らしい商品・サービスを広めたいと考えています。<br />
ココトモのお得なサービスや企画、プレゼント、イベント等を通して、みなさんに地元の商品・サービスを体験していただき、<br />
たくさんの「良かったよ！」というお声やレポート、写真投稿を集め、県民のみなさんひいては全国のみなさんに<br />
沖縄がもっと好きになるような情報を発信していきます。ぜひ、ココトモと一緒に地元を盛り上げてください！<br />
<img src="images/merit/merit04_img.jpg" alt="ココトモとみなさんで沖縄の情報を全国へ発信しましょう！" />   </P>


    <h2 id="merit_h05">県内のいろんな情報を続々発信！</h2>
        <h3>おすすめのグルメやレジャーをスタッフが独断と偏見でレポート！</h3>
        <p><img src="images/merit/merit05_img-1.jpg" alt="おすすめグルメ、レジャーをスタッフがレポート！" /><br />
        スタッフ行きつけの美味しいお店や、つい夢中になってしまったおすすめのレジャーを独断と偏見でレポート!<br />
おでかけのネタ探しにのぞいてみてくださいね。みなさんおすすめのお店やレジャーのタレコミもお待ちしてます!</p>

        <h3>ネットでお得にいろんなお買い物！いつものお買い物でココトモのポイントもGET！</h3>
        <p><img src="images/merit/merit05_img-2.jpg" alt="ネットでいろいろお買い物！ポイントも貯まる！" /><br />
        ココトモと提携のネットショップでお得にお買い物ができます!<br />
        いつものお買い物で、お店のポイントも、ココトモのポイントも貯まってWでお得!
        提携ショップは続々追加中!お気に入りのお店を見つけてくださいね。</p>

    <h2 id="merit_h06">お仕事情報もココトモでチェック！</h2>
    <P>県内を中心にお仕事情報を掲載中！県内の各企業と提携しているので色んなお仕事情報が掲載可能♪<br />
サイト上に掲載できない、非公開のお仕事情報も…！就職のご相談も窓口からお気軽にどうぞ！<br />
企業、店舗様のお仕事情報の掲載依頼もお待ちしております。</p>
<ul class="job_mado">
<li><a href="/contact-form.html">お客様ご相談窓口はこちら</a></li>
<li><a href="mailto:info@glaspe.net">企業・店舗様お仕事情報掲載お問い合わせはこちら</a></li>
</ul>
<p><img src="images/merit/merit06_img.jpg" alt="うれしい！探しやすい！県内中心掲載" /></p>
</section>
<!-- /section -->

<section>
<div class="center_btn">
    <a href="regist.html"><img src="images/merit/merit_btn.png" alt="会員登録はこちら"></a><br />
    <ul class="member_kiyaku">
        <li><a href="#">会員規約はこちら</a></li>
    </ul>
    </div>
</section>

</main><!-- /main -->
</div><!-- /merit -->
</div>
<!--/content-->


<!-- ↑ココまでHTML -->

<!-- ↓フッター読み込み編集不要 -->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>

