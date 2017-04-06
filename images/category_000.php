<?php
require_once('includes/applicationInc.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');

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
<link rel="stylesheet" href="/css/style_category.css" type="text/css" media="screen" />
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta_new.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title>カテゴリーページ | <?php print SITE_PUBLIC_NAME?></title>
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
<?php require("includes/box/common/header_hotel.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->

<!-- InstanceEndEditable -->

<!--Content-->
<div id="content" class="clearfix" style="padding:0;">

<!-- /mainimage-->

<!--main-->
		<main id="content-cate">
		<div class="backnumber_box cf">
<section>
	<div class="category_title" style="background:#ff9c00">
    		<h1 style="font-size:25px;">カテゴリーページテンプレート</h1>
    		<h2 style="font-size:15px">サブタイトル</h2>
	</div>
</section></br>
			</ul>
			<ul class="plan">
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=795&company_id=106&room_id=652"><img src="./images/hotel/bkn74.jpg" width="294" height="176" alt="那覇グランドホテル" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=795&company_id=106&room_id=652">那覇グランドホテル</a></br>国際通りのどまんなか♪１月限定￥2500～</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=812&company_id=129&room_id=751"><img src="./images/hotel/bkn75.jpg" width="294" height="176" alt="ホテル国際プラザ" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=812&company_id=129&room_id=751">ホテル国際プラザ</a></br>ココトモ新登場☆国際通り沿いにあり、県庁もすぐ近く。				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=825&company_id=147&room_id=760"><img src="./images/hotel/bkn76.jpg" width="294" height="176" alt="北谷ジャーガル邸" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=825&company_id=147&room_id=760">北谷ジャーガル邸</a></br>沖縄古民家（築５６年）を活用した１日１組限定の宿♪</div></li>
			</ul>
			<ul class="plan">
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=705&company_id=8&room_id=362"><img src="./images/hotel/bkn73.jpg" width="294" height="176" alt="ホテル ピースランド久米" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=705&company_id=8&room_id=362">ホテル ピースランド久米</a></br>住めるほどに充実した設備・グッズが揃ったホテル♪</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=737&company_id=60&room_id=453"><img src="./images/hotel/bkn72.jpg" width="294" height="176" alt="ワンスイートホテル＆リゾート古宇利島" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=737&company_id=60&room_id=453">ワンスイートホテル＆リゾート古宇利島</a></br>一面の緑と海に包まれた贅沢なスイートルームをまるごと貸切！</div></li>

				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=723&company_id=98&room_id=654"><img src="./images/hotel/bkn71.jpg" width="294" height="176" alt="貸別荘ゆくら今帰仁" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=723&company_id=98&room_id=654">貸別荘ゆくら今帰仁</a></br>今帰仁の青い海と自然を満喫！ゆっくり気ままに過ごせる1棟限定の貸別荘！</div></li>

				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=12526690&company_id=37&company_link=S01392&room_id=4"><img src="./images/hotel/bkn70.jpg" width="294" height="176" alt="東京第一ホテル オキナワグランメールリゾート" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=12526690&company_id=37&company_link=S01392&room_id=4">東京第一ホテル オキナワグランメールリゾート</a></br>夜は「カニが！」食べ放題♪さらに飲み放題も付いてきます！食欲の秋を堪能！</div></li>

			</ul>
			<ul class="plan">
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=652&company_id=121&room_id=726"><img src="./images/hotel/bkn69.jpg" width="294" height="176" alt="ホテルブライオン那覇" /></a>
					<div class="caption">
						<a href="http://cocotomo.net/plan-detail.html?hotelplan_id=652&company_id=121&room_id=726">ホテルブライオン那覇</a></br>松山から徒歩１分♪「豪華さ」と「美しさ」を兼ね備えたビジネスホテル！</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=652&company_id=121&room_id=726"><img src="./images/hotel/bkn68.jpg" width="294" height="176" alt="美ら海沖縄の宿　結来(ゆくら)" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=652&company_id=121&room_id=726">美ら海沖縄の宿　結来(ゆくら)</a></br>美ら海水族館から車で５分！やんばるの自然に囲まれた隠れ家的一軒家。</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=205&company_id=21&room_id=715"><img src="./images/hotel/bkn67.jpg" width="294" height="176" alt="なかどまinn" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=205&company_id=21&room_id=715">本部グリーンパークホテル</a></br>本部の大自然を満喫！初心者から楽しめる人気のゴルフコースもお得にプレー可能！</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=615&company_id=94&room_id=620"><img src="./images/hotel/bkn66.jpg" width="294" height="176" alt="なかどまinn" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=615&company_id=94&room_id=620">なかどまinn</a></br>恩納村にある木のぬくもり溢れるトロピカルなホテル♪</div></li>
			</ul>
			<ul class="plan">
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=13142301&company_id=28&company_link=F63451&room_id=2"><img src="./images/hotel/bkn65.jpg" width="294" height="176" alt="沖縄サンコーストホテル" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=13142301&company_id=28&company_link=F63451&room_id=2">沖縄サンコーストホテル</a></br>目の前は徒歩１分にビーチ♪全室キッチン付きのコンドミニアムタイプ♪</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=616&company_id=32&room_id=376"><img src="./images/hotel/bkn64.jpg" width="294" height="176" alt="ホテルベルモア東洋" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=616&company_id=32&room_id=376">ホテルベルモア東洋</a></br>リーズナブルな宿泊費と観光地への抜群のアクセス！</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=621&company_id=10&room_id=256"><img src="./images/hotel/bkn63.jpg" width="294" height="176" alt="ホテルブライオン那覇" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=621&company_id=10&room_id=256">ホテルブライオン那覇</a></br>松山から徒歩１分♪朝食付きのお得価格♪</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=15757482&company_id=118&company_link=W92910&room_id=2"><img src="./images/hotel/bkn62.jpg" width="294" height="176" alt="リゾネックス那覇" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=15757482&company_id=118&company_link=W92910&room_id=2">リゾネックス那覇</a></br>おいしいランチバイキングのペアチケットが当たる♪</div></li>
			</ul>
		<!--	<ul class="day">
				<li><a href="http://cocotomo.net/plan-detail-secret-act.html?id=601&rid=633&cid=92&key=XW0HM103UWoHY1NlCG9Zag=="><span>▼6/13放送</span></a></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=14318984&company_id=48&company_link=I30265&room_id=1"><span>▼6/6放送</span></a></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=617&company_id=9&room_id=222"><span>▼5/30放送</span></a></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=567&company_id=7&room_id=306"><span>▼5/23放送</span></a></li>
			</ul>
		-->
			<ul class="plan">
				<li><a href="http://cocotomo.net/plan-detail-secret-act.html?id=601&rid=633&cid=92&key=XW0HM103UWoHY1NlCG9Zag=="><img src="./images/hotel/bkn61.jpg" width="294" height="176" alt="もとぶ元気村" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail-secret-act.html?id=601&rid=633&cid=92&key=XW0HM103UWoHY1NlCG9Zag==">もとぶ元気村</a></br>イルカやリグガメ、ウミガメにご飯をあげよう♪</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=14318984&company_id=48&company_link=I30265&room_id=1"><img src="./images/hotel/bkn60.jpg" width="294" height="176" alt="ホテルゆがふいんBISE" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=14318984&company_id=48&company_link=I30265&room_id=1">ホテルゆがふいんBISE</a></br>ファミリーおすすめ♪広々和洋室！水族館のチケット付！</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=617&company_id=9&room_id=222"><img src="./images/hotel/bkn59.jpg" width="294" height="176" alt="ＧＲＧホテル那覇" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=617&company_id=9&room_id=222">ＧＲＧホテル那覇</a></br>カップルおすすめ♪松山のどまんなか！お得価格は８月末まで♪</div></li>
				<li><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=567&company_id=7&room_id=306"><img src="./images/hotel/bkn58.jpg" width="294" height="176" alt="ホテルピースランド那覇" /></a>
					<div class="caption"><a href="http://cocotomo.net/plan-detail.html?hotelplan_id=567&company_id=7&room_id=306">ホテルピースランド那覇</a></br>とまりん(泊港)のすぐとなり♪観光にもビジネスにも便利♪</div></li>
			</ul>
		</div>
<br/>

		</main>
<!-- /main-->
	</div>
</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_n.php");?>
<!--/footer-->
</body>
<!-- InstanceEnd --></html>
