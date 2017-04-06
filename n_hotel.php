<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);

$collection->setByKey($collection->getKeyValue(), "top_area", 1);
//	八重山 11
$hotel11 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 11);
$hotel11->selectListCompanyCount($collection);
//	石垣 10
$hotel10 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 10);
$hotel10->selectListCompanyCount($collection);
//	久米島 13
$hotel13 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 13);
$hotel13->selectListCompanyCount($collection);
//	慶良間諸島 14
$hotel14 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 14);
$hotel14->selectListCompanyCount($collection);
//	国頭 9
$hotel9 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 9);
$hotel9->selectListCompanyCount($collection);
//	本部・今帰仁 8
$hotel8 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 8);
$hotel8->selectListCompanyCount($collection);
//	名護 7
$hotel7 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 7);
$hotel7->selectListCompanyCount($collection);
//	恩納村 6
$hotel6 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 6);
$hotel6->selectListCompanyCount($collection);
//	宜野湾市　21
$hotel21 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 21);
$hotel21->selectListCompanyCount($collection);
//	北谷町・読谷村　5
$hotel5 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 5);
$hotel5->selectListCompanyCount($collection);
//	北中城村・沖縄・うるま市　4
$hotel4 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 4);
$hotel4->selectListCompanyCount($collection);
//	那覇 2
$hotel2 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 2);
$hotel2->selectListCompanyCount($collection);
//	本島南部 3
$hotel3 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 3);
$hotel3->selectListCompanyCount($collection);
//	宮古島	12
$hotel12 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 12);
$hotel12->selectListCompanyCount($collection);
//	島尻	15 	その他島を適用
$hotel15 = new hotel($dbMaster);
$collection->setByKey($collection->getKeyValue(), "area", 15);
$hotel15->selectListCompanyCount($collection);

$inputs = new inputs(); ?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<link rel="stylesheet" href="/css/style_category.css" type="text/css" media="screen" />

<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title>沖縄の宿泊予約－県民価格のお得なプランも！ |<?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="//cocotomo.net/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//cocotomo.net/js/jquery-ui-1.10.3.custom.min.js"></script>

<link rel="stylesheet" href="//cocotomo.net/common/css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="//cocotomo.net/common/js/popupwindow-1.6.js"></script>
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

<body id="top" style="background:none;border-top:none;">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->

<!-- InstanceEndEditable -->

<!--Content-->
<div id="content" class="clearfix">

<section>
    <div class="mainimage">
	<img src="./images/hotel/hotel_top_re.jpg" width="1323" height="250" alt="宿泊予約" />
    </div>
<!--    <div class="use_step" style="margin-top:10px">
	<img src="./images/common/bg_step.jpg" width="1323" height="60" alt="ステップ" />


	<ul>
		<li>
			宿泊予約の使い方
		</li>
		<li>
			<h2>STEP.1</h2>
			<p>テキストテキストテキストテキストテキスト</p>
			<img src="#"/>
		</li>
		<li>
			<h2>STEP.2</h2>
			<p>テキストテキストテキストテキストテキスト</p>
			<img src="#"/>

		</li>
		<li>
			<h2>STEP.3</h2>
			<p>テキストテキストテキストテキストテキスト</p>
			<img src="#"/>
		</li>
	</ul>

    </div>-->
</section>

<!-- /mainimage-->

<!-- Left side-->
		<div id="content-ln">
<?php require("includes/box/common/kuchikomi2016.php");?>
			<aside class="banerList">

				<ul>
					<li style="margin-bottom: 10px; margin-top:10px;"><a href="/n_coupon.html" target="_blank"><img src="http://cocotomo.net/images/coupon/top_image.png" width="220" height="70" alt="ココトモのクーポン！ココポン" /></a></li>
					<li style="margin-bottom: 10px;"><a href="/gourmet-list.html" target="_blank"><img src="http://cocotomo.net/images/gl/gourme_top.jpg" width="220" height="70" alt="グルメ情報" /></a></li>
					<li style="margin-bottom: 10px;"><a href="/leisure-list.html" target="_blank"><img src="http://cocotomo.net/images/gl/leisure_top.jpg" width="220" height="70" alt="レジャー予約" /></a></li>
					<li style="margin-bottom: 10px;"><a href="group.html"><img src="./images/side-l/img_group.png" width="220" alt="グループ旅行や宴会をお手伝いします" /></a></li>
				</ul>
			</aside>
		</div>
<!-- /Left side-->

<!--main-->
		<main id="content-r">


	<h2 class="title2016">Pick UP！</h2>

		<div class="contents_box cf">
			<div class="pickup cf">

<?php require("hotel_tokushu.php");?>


			</div>
<!--
			<div class="toku">
				<a href="/plan-detail.html?hotelplan_id=621&company_id=10&room_id=256"><img src="/images/hotel/pick69.png" width="399" height="236" alt="今週のお得な限定プランはコチラ！！" /></a>
			</div>
			<div class="toku_l">
				<ul class="toku">
				<li><a href="/sp-backnumber2.html"><img src="./images/hotel/sp_bk.jpg" width="261" height="94" alt="" /></br>▼TV番組で放送!!お得なプランはコチラ！</a></br></br></li>
				<li><a href="javascript:void(0);" onclick="document.frmRecommend5.submit();"><img src="./images/hotel/pet.jpg" width="261" height="94" alt="ペットとお泊まり" /></br>▼大切な家族！ペットも一緒に泊まろう！</a></li>
				</ul>
			</div>
			<div class="toku_r">
				<ul class="toku">
				<li><a href="javascript:void(0);" onclick="document.frmRecommend2.submit();"><img src="./images/hotel/dinner.jpg" width="261" height="94" alt="一人一万円以下" /></br>▼1人1万円以下でディナー付き！</a></br></br></li>
				<li><a href="javascript:void(0);" onclick="document.frmRecommend4.submit();"><img src="./images/hotel/tatami.jpg" width="261" height="94" alt="たたみのお部屋" /></br>▼小さなお子様も安心の畳のお部屋</a></li>
				</ul>
			</div>
-->
		</div>



<div class="cf" style="margin-bottom:20px;">
        <!--日付・人数から検索-->
<!--	<img src="/images/hotel/title_search.png" alt="エリアから探す" />	-->
	<!--エリアform-->
           	<form name="frm20" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 20); print $inputs->hidden("undecide_sch", 1)?></form>
            	<form name="frm18" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 18); print $inputs->hidden("undecide_sch", 1)?></form>
            	<form name="frm19" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 19); print $inputs->hidden("undecide_sch", 1)?></form>
            	<form name="frm22" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 22); print $inputs->hidden("undecide_sch", 1)?></form>

	<!--テキストform-->

		<form name="frmRecommend6" method="post" action="facility-search.html"><?php print $inputs->hidden("recommend", 6); print $inputs->hidden("undecide_sch", 1);?></form>
		<form name="frmRecommend7" method="post" action="facility-search.html"><?php print $inputs->hidden("recommend", 7); print $inputs->hidden("undecide_sch", 1);?></form>
		<form name="frmRecommend8" method="post" action="facility-search.html"><?php print $inputs->hidden("recommend", 8); print $inputs->hidden("undecide_sch", 1);?></form>

<!--	<div id="area_box"> -->
	<!--	<ul class="a_search"> -->
		<!--	<li><a href="javascript: void(0);" onclick="document.frm20.submit();"><img src="./images/hotel/hotel4.png" width="233" height="76" alt="那覇・南部" /></a>-->
			<!--</br><a href="javascript:void(0);" onclick="document.frmRecommend6.submit();">▼アウトレットモールあしびなー近く</a>-->
			<!--</li>-->
		<!--	<li><a href="javascript: void(0);" onclick="document.frm18.submit();"><img src="./images/hotel/hotel5.png" width="233" height="76" alt="中部" /></a>-->
			<!--</br><a href="javascript:void(0);" onclick="document.frmRecommend7.submit();">▼海浜公園・コンベンション近く</a>-->
			<!--</li>-->
	<!--		<li><a href="javascript: void(0);" onclick="document.frm19.submit();"><img src="./images/hotel/hotel6.png" width="234" height="78" alt="北部" /></a>-->
			<!--</br><a href="javascript:void(0);" onclick="document.frmRecommend8.submit();">▼美ら海水族館・海洋博公園近く</a>-->
			<!--</li>-->
	<!--		<li><a href="javascript: void(0);" onclick="document.frm22.submit();"><img src="./images/hotel/hotel7.png" width="233" height="76" alt="那覇・南部" /></a>-->
			<!--</li>-->
	
	<!--	</ul>-->
<!--	</div>-->


	<h2 class="title2016" style="margin-bottom:15px;">日付・人数から探す</h2>
<!--	<div id="attention_h">
			誠に申し訳ございませんが、ただいまシステム調整のため検索速度が非常に遅くなる場合がございます。<br>
			ホテルや宿泊プランの内容・空き状況等お調べいたします。お気軽にお問合せください。<br>
			【お問い合わせ先】TEL：098-988-8105(平日10～18時)　/　MAIL：<a href="mailto:info@cocotomo.net">info@cocotomo.net</a>
	</div>
-->
        <!--地図から検索-->
			<section class="map">
        	<h2><img src="./images/front/search-title02.jpg" width="518" height="30" alt="地図から検索" /></h2>
	
        	<form name="frm9" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 9); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm8" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 8); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm7" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 7); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm6" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 6); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm21" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 21); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm5" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 5); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm4" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 4); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm2" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 2); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm3" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 3); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm10" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 10); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm11" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 11); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm12" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 12); print $inputs->hidden("undecide_sch", 2)?></form>
<!--            	<form name="frm13" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 13); print $inputs->hidden("undecide_sch", 2)?></form>-->
            	<form name="frm14" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 14); print $inputs->hidden("undecide_sch", 2)?></form>
            	<form name="frm15" method="post" action="facility-search.html"><?php print $inputs->hidden("area", 15); print $inputs->hidden("undecide_sch", 2)?></form>

            <div class="mapimg"><img id="map" src="images/front/index-map-normal.jpg" width="518" height="362" usemap="#map">
                <map id="maparea" name="map">
                    <area class="map-01" shape="poly" coords="174,58,156,86,143,87,134,84,127,95,131,103,137,116,151,122,165,118,176,76,184,60" href="javascript: void(0);" onclick="document.frm10.submit();">
                    <area class="map-02" shape="poly" coords="95,102,84,84,71,88,62,105,49,118,56,130,90,136,110,145,127,139,139,119" href="javascript: void(0);" onclick="document.frm11.submit();">
                    <area class="map-03" shape="poly" coords="74,179,50,189,51,200,67,208,78,221,94,230,93,222,95,212,136,203,135,197,102,200,87,177" href="javascript: void(0);" onclick="document.frm13.submit();">
                    <area class="map-04" shape="poly" coords="58,285,42,295,25,299,25,336,53,343,84,346,126,314,132,290,100,282" href="javascript: void(0);" onclick="document.frm14.submit();">
                    <area class="map-05" shape="poly" coords="390,58,384,61,388,68,378,91,365,103,355,105,357,112,356,116,368,123,372,128,378,121,383,121,393,135,398,131,413,108,412,83,407,69" href="javascript: void(0);" onclick="document.frm9.submit();">
                    <area class="map-06" shape="poly" coords="317,116,275,121,266,117,262,128,266,133,242,139,244,145,263,151,274,161,274,154,281,146,288,148,294,145,301,143,304,138,318,142" href="javascript: void(0);" onclick="document.frm8.submit();">
                    <area class="map-07" shape="poly" coords="275,156,282,147,288,148,304,140,308,146,318,144,334,142,339,150,341,156,346,160,351,160,356,169,352,173,339,183,327,177,322,178,324,187,306,193,299,185,289,190,285,180,290,176,298,166,284,158" href="javascript: void(0);" onclick="document.frm7.submit();">
                    <area class="map-08" shape="poly" coords="224,221,227,225,232,223,239,225,240,221,267,202,272,202,275,197,280,199,289,190,288,190,285,182,280,187,271,190,264,188,255,191,256,199,243,210,242,214,238,215,234,212" href="javascript: void(0);" onclick="document.frm6.submit();">
                    <area class="map-09" shape="poly" coords="215,214,215,228,223,243,235,239,237,230,241,224,227,224" href="javascript: void(0);" onclick="document.frm5.submit();">
                    <area class="map-09" shape="poly" coords="226,249,236,250,235,253,238,259,237,267,228,267,229,260,222,254" href="javascript: void(0);" onclick="document.frm5.submit();">
                    <area class="map-10" shape="poly" coords="201,282,212,288,224,288,223,296,216,306,208,305,195,313,189,303,195,295,197,296,202,293" href="javascript: void(0);" onclick="document.frm2.submit();">
                    <area class="map-11" shape="poly" coords="223,297,216,305,207,306,195,314,198,318,192,321,192,326,197,328,196,344,201,349,211,343,216,343,243,325,251,316,273,320,281,310,245,303,238,309,230,298" href="javascript: void(0);" onclick="document.frm3.submit();">
                    <area class="map-12" shape="poly" coords="429,267,408,290,414,299,430,301,429,316,434,319,471,316,479,317,469,303,461,299,454,295,450,271" href="javascript: void(0);" onclick="document.frm12.submit();">
<!--                    <area class="map-13" shape="poly" coords="458,138,446,140,424,164,423,169,407,187,411,221,414,229,416,242,422,243,433,232,435,215,435,177,447,164" href="javascript: void(0);" onclick="document.frm15.submit();">-->
                    <area class="map-14" shape="poly" coords="253,211,239,222,235,239,236,250,237,259,237,270,244,272,253,262,258,260,263,253,281,268,289,288,308,267,310,228,296,239,288,244,289,248,282,252,273,248,270,235,256,224,260,219" href="javascript: void(0);" onclick="document.frm4.submit();">
                    <area class="map-15" shape="poly" coords="223,273,229,274,230,281,228,285,217,286,206,285,202,284,200,279,205,276,211,274,219,273" href="javascript: void(0);" onclick="document.frm21.submit();">
                </map>
          </div>
            <div id="map-01" class="areabox">
                <div class="inner">
                    <div class="title">■石垣島（2件）</div>
                    <ul>
                         <li>ホテルグランビュー石垣島</li>
                         <li>ホテルピースランド石垣島</li>
                    </ul>
                </div>
            </div>
            <div id="map-02" class="areabox">
                <div class="inner">
                    <div class="title">■八重山諸島（3件）</div>
                    <ul>
                        <li>ホテルピースアイランド竹富島</li>
                        <li>星野リゾート リゾナーレ小浜島</li>
                        <li>星野リゾート ニラカナイ西表島</li>
                    </ul>
                </div>
            </div>
            <div id="map-03" class="areabox">
                <div class="inner">
                    <div class="title">■久米島（1件）</div>
                    <ul>
                        <li>サイプレスリゾート久米島</li>
                    </ul>
                </div>
            </div>
            <div id="map-04" class="areabox">
                <div class="inner">
                    <div class="title">■慶良間諸島（0件）</div>
                    <ul>
                        <li>現在ご予約いただける施設がありません</li>
                    </ul>
                </div>
            </div>
            <div id="map-05" class="areabox">
                <div class="inner">
                    <div class="title">■国頭村・その他（2件）</div>
                    <ul>
                        <li>やんばるロハス</li>
                        <li>アダ・ガーデンホテル沖縄</li>
                    </ul>
                </div>
            </div>
            <div id="map-06" class="areabox">
                <div class="inner">
                    <div class="title">■本部・今帰仁（8件）</div>
                    <ul>
                        <li>ホテルマハイナウェルネスリゾートオキナワ</li>
                        <li>ホテルゆがふいんBISE</li>
                        <li>ロワジールホテル沖縄美ら海</li>
                        <li>本部グリーンパークホテル</li>
                        <li>マリンピアザオキナワ</li>
                        <li>WOOD PECKER Nakijin（ウッドペッカー今帰仁）</li>
                        <li>オン・ザ・ビーチルー</li>
                        <li>ワンスイート ホテル＆リゾート コウリアイランド</li>
                    </ul>
                </div>
            </div>
            <div id="map-07" class="areabox">
                <div class="inner">
                    <div class="title">■名護市（8件）</div>
                    <ul>
                        <li>ホテルゆがふいんおきなわ</li>
                        <li>オキナワ マリオット リゾート＆スパ</li>
                        <li>カヌチャベイホテル＆ヴィラズ</li>
                        <li>喜瀬ビーチパレス</li>
                        <li>喜瀬カントリークラブ</li>
                        <li>AJ幸喜リゾートホテル</li>
                        <li>沖縄サンコーストホテル</li>
                        <li>リゾネックス名護</li>
                    </ul>
                </div>
            </div>
            <div id="map-08" class="areabox">
                <div class="inner">
                    <div class="title">■恩納村（7件）</div>
                    <ul>
                        <li>シェラトン沖縄サンマリーナリゾート</li>
                        <li>ホテルムーンビーチ</li>
                        <li>沖縄かりゆしビーチリゾートオーシャンスパ</li>
                        <li>恩納マリンビューパレス</li>
                        <li>AJ恩納ビルリゾートホテル</li>
                        <li>カフーリゾートフチャク コンド・ホテル</li>
                        <li>ホテルみゆきビーチ</li>
                        <li>ホテルみゆきハマバルリゾート</li>
                    </ul>
                </div>
            </div>
            <div id="map-15" class="areabox">
                <div class="inner">
                    <div class="title">■宜野湾市（2件）</div>
                    <ul>
                        <li>ラグナガーデンホテル</li>
                        <li>ムーンオーシャン宜野湾ホテル＆レジデンス</li>
                    </ul>
                </div>
            </div>
            <div id="map-09" class="areabox">
                <div class="inner">
                    <div class="title">■北谷町・読谷村（2件）</div>
                    <ul>
                        <li>ザ・ビーチタワー沖縄</li>
                        <li>ホテル日航アリビラ</li>
                    </ul>
                </div>
            </div>
            <div id="map-10" class="areabox">
                <div class="inner">
                    <div class="title">■那覇市（21件）</div>
                    <ul>
                        <li>ホテルブライオン那覇</li>
                        <li>那覇ビーチサイドホテル</li>
                        <li>GRGホテル那覇東町</li>
                        <li>GRGホテル那覇</li>
                        <li>ホテルソルヴィータ沖縄松山</li>
                        <li>沖縄ホテル</li>
                        <li>ホテルタイラ</li>
                        <li>ホテルクレシア沖縄</li>
                        <li>南西観光ホテル</li>
                        <li>ホテル東急ビズフォート</li>
                        <li>旅の宿らくちん</li>
                        <li>那覇グランドホテル</li>
                        <li>ホテル日航那覇グランドキャッスル</li>
                        <li>沖縄サンプラザホテル</li>
                        <li>ホテルグランビュー沖縄</li>
                        <li>ホテルサン沖縄</li>
                        <li>ウィークリーハーバービューマンション</li>
                        <li>ステーションホテル牧志</li>
                        <li>ホテルピースランド那覇</li>
                        <li>ホテルピースランド久米</li>
                        <li>琉球サンロイヤルホテル</li>
                    </ul>
                </div>
            </div>
            <div id="map-11" class="areabox">
                <div class="inner">
                    <div class="title">■本島南部（3件）</div>
                    <ul>
                        <li>サザンビーチホテル＆リゾート</li>
                        <li>ユインチホテル南城</li>
                        <li>ホテルグランビューガーデン沖縄</li>
                    </ul>
                </div>
            </div>
            <div id="map-12" class="areabox">
                <div class="inner">
                    <div class="title">■宮古島（4件）</div>
                    <ul>
                        <li>ホテルピースランド宮古島</li>
                        <li>ホテルブリーズベイマリーナ</li>
                        <li>リゾートヴィラブリッサ</li>
                        <li>シギラベイサイドスイートアラマンダ</li>
                    </ul>
                </div>
            </div>
<！--
            <div id="map-13" class="areabox">
                <div class="inner">
                    <div class="title">■島尻郡（0件）</div>
                    <ul>
                        <li>現在ご予約いただける施設がありません</li>
                    </ul>
                </div>
            </div>
-->
            <div id="map-14" class="areabox">
                <div class="inner">
                    <div class="title">■北中城村・沖縄市・うるま市（2件）</div>
                    <ul>
                        <li>東京第一ホテルオキナワグランメールリゾート</li>
                        <li>AJリゾートアイランド伊計島</li>
                    </ul>
                </div>
            </div>
<!--
            <div id="map-01" class="areabox">
                <div class="inner">
                    <div class="title">■石垣島（<?php print $hotel10->getCount()?>件）</div>
                    <ul>
                    	<?php
                    	if ($hotel10->getCount() > 0) {
                    		foreach ($hotel10->getCollection() as $data10) {
                    	?>
                        <li><?php print $data10["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-02" class="areabox">
                <div class="inner">
                    <div class="title">■八重山諸島（<?php print $hotel11->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel11->getCount() > 0) {
                    		foreach ($hotel11->getCollection() as $data11) {
                    	?>
                        <li><?php print $data11["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-03" class="areabox">
                <div class="inner">
                    <div class="title">■久米島（<?php print $hotel13->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel13->getCount() > 0) {
                    		foreach ($hotel13->getCollection() as $data13) {
                    	?>
                        <li><?php print $data13["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-04" class="areabox">
                <div class="inner">
                    <div class="title">■慶良間諸島（<?php print $hotel14->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel14->getCount() > 0) {
                    		foreach ($hotel14->getCollection() as $data14) {
                    	?>
                        <li><?php print $data14["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-05" class="areabox">
                <div class="inner">
                    <div class="title">■国頭村・その他（<?php print $hotel9->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel9->getCount() > 0) {
                    		foreach ($hotel9->getCollection() as $data9) {
                    	?>
                        <li><?php print $data9["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-06" class="areabox">
                <div class="inner">
                    <div class="title">■本部・今帰仁（<?php print $hotel8->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel8->getCount() > 0) {
                    		foreach ($hotel8->getCollection() as $data8) {
                    	?>
                        <li><?php print $data8["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-07" class="areabox">
                <div class="inner">
                    <div class="title">■名護市（<?php print $hotel7->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel7->getCount() > 0) {
                    		foreach ($hotel7->getCollection() as $data7) {
                    	?>
                        <li><?php print $data7["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-08" class="areabox">
                <div class="inner">
                    <div class="title">■恩納村（<?php print $hotel6->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel6->getCount() > 0) {
                    		foreach ($hotel6->getCollection() as $data6) {
                    	?>
                        <li><?php print $data6["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-15" class="areabox">
                <div class="inner">
                    <div class="title">■宜野湾市（<?php print $hotel21->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel21->getCount() > 0) {
                    		foreach ($hotel21->getCollection() as $data21) {
                    	?>
                        <li><?php print $data21["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-09" class="areabox">
                <div class="inner">
                    <div class="title">■北谷町・読谷村（<?php print $hotel5->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel5->getCount() > 0) {
                    		foreach ($hotel5->getCollection() as $data5) {
                    	?>
                        <li><?php print $data5["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-10" class="areabox">
                <div class="inner">
                    <div class="title">■那覇市（<?php print $hotel2->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel2->getCount() > 0) {
                    		foreach ($hotel2->getCollection() as $data2) {
                    	?>
                        <li><?php print $data2["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-11" class="areabox">
                <div class="inner">
                    <div class="title">■本島南部（<?php print $hotel3->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel3->getCount() > 0) {
                    		foreach ($hotel3->getCollection() as $data3) {
                    	?>
                        <li><?php print $data3["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-12" class="areabox">
                <div class="inner">
                    <div class="title">■宮古島（<?php print $hotel12->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel12->getCount() > 0) {
                    		foreach ($hotel12->getCollection() as $data12) {
                    	?>
                        <li><?php print $data12["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-13" class="areabox">
                <div class="inner">
                    <div class="title">■島尻郡（<?php print $hotel15->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel15->getCount() > 0) {
                    		foreach ($hotel15->getCollection() as $data15) {
                    	?>
                        <li><?php print $data15["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
            <div id="map-14" class="areabox">
                <div class="inner">
                    <div class="title">■北中城村・沖縄市・うるま市（<?php print $hotel4->getCount()?>件）</div>
                    <ul>
                        <?php
                    	if ($hotel4->getCount() > 0) {
                    		foreach ($hotel4->getCollection() as $data4) {
                    	?>
                        <li><?php print $data4["HOTEL_NAME"]?></li>
                    	<?php
                    		}
                    	}else{
                    	?>
                        <li>現在ご予約いただける施設がありません</li>
                    	<?php
						}
						?>
                    </ul>
                </div>
            </div>
-->
            <!--<div class="image">
            	<ul>
                	<li><img src="images/index/index_map-btn01.png" width="136" height="26" alt="人気スポットを表示"></li>
                    <li><img src="images/index/index_map-btn02.png" width="107" height="26" alt="ビーチを表示"></li>
                </ul>
            </div>
-->

<!--
            <section>
            	<h3><img src="images/index/index_map-btitle.jpg" width="190" height="29" alt="エリアから選ぶ"></h3>
                <ul>
                    <li><a href="#">国頭</a></li>
                    <li><a href="#">本部、今帰仁</a></li>
                    <li><a href="#">名護</a></li>
                    <li><a href="#">恩納村</a></li>
                    <li><a href="#">北谷町、読谷村</a></li>
                    <li><a href="#">北中城村、沖縄、うるま市</a></li>
                    <li><a href="#">那覇市内</a></li>
                    <li><a href="#">本島南部</a></li>
                    <li><a href="#">石垣島</a></li>
                    <li><a href="#">八重山諸島</a></li>
                    <li><a href="#">宮古島</a></li>
                    <li><a href="#">久米島</a></li>
                    <li><a href="#">慶良間諸島</a></li>
                </ul>
            </section>
-->
        </section>
<!-- /地図から検索-->


<!--キーワード検索-->
		<!--<section class="search2col cf">
		<section class="l-sp">
			<h2><img src="./images/front/search-title03.jpg" width="254" height="29" alt="キーワード検索" /></h2>
			<form method="post" action="facility-search.html" id="frmFree" name="frmFree">
			<div>
				<?php print $inputs->text("free", $collection->getByKey($collection->getKeyValue(), "free") ,"imeActive"); print $inputs->hidden("undecide_sch", 1);?>
				<p class="inputbox"><input type="button" value="" id="" name="" onclick="document.frmFree.submit();"></p>
			</div>
			</form>
		</section>-->

        <!--<section class="search2col cf">
        	<section class="l-sp">
        		<h2><img src="./images/front/search-title03.jpg" width="254" height="29" alt="キーワード検索" /></h2>
                    <div>
                        <form method="post" action="">
	                        <div>
	                        	<input class="" type="text" id="" name="" >
	                        	<p class="inputbox"><input type="button" value="" id="" name="" ></p>
	                        </div>
                        	<!--<?php
                        	if ($collection->getByKey($collection->getKeyValue(), "free") == "") {
                        		$collection->setByKey($collection->getKeyValue(), "free", "");
                        	}
                        	?>
                        	<?php print $inputs->text("free", $collection->getByKey($collection->getKeyValue(), "free") ,"imeActive")?>
                            <p class="inputbox"><input type="button" value="" id="" name="" ></p>--*>
                        </form>
                    </div>
	
                </section>-->

		<!--<section class="search">
		<section>
			<h2><img src="./images/front/search-title03-1.jpg" width="518" height="30" alt="キーワード検索" /></h2>
			<form method="post" action="facility-search.html" id="frmFree" name="frmFree">
			<div>
				<?php print $inputs->text("free", $collection->getByKey($collection->getKeyValue(), "free") ,"imeActive"); print $inputs->hidden("undecide_sch", 1);?>
				<input type="button" value="" id="" name="" onclick="document.frmFree.submit();">
			</div>
			</form>
			</section>
		</section>
		-->


<!--人数から検索-->

        <section class="search">
        	<h2><img src="./images/front/search-title01.jpg" width="518" height="30" alt="日付・人数から検索" /></h2>
        	<form method="post" action="facility-search.html#">
                <table class="form">
                	<tr>
                		<th>宿泊日</th>
                		<th>宿泊日数</th>
                		<!--<th>ご利用部屋数</th>-->
                		<th colspan="2" style="width:150px;">ご利用人数</th>
                	</tr>
                	<tr>
                         <td id="search_datetd">
                         <?php 
                         print $inputs->text("search_date", $collection->getByKey($collection->getKeyValue(), "search_date") ,"imeDisabled wDateJp")?>
                         <script type="text/javascript">
                         $.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
                         $("#search_date").datepicker(
                         		{
                         			showOn: 'button',
                         			buttonImage: 'images/index/index-search-icon.png',
                         			buttonImageOnly: true,
                         			dateFormat: 'yy年mm月dd日',
                         			changeMonth: true,
                         			changeYear: true,
                         			yearRange: '<?php print date("Y")?>:<?php print date("Y",strtotime("+1 year"))?>',
                         			showMonthAfterYear: true,
                         			monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                     dayNamesMin: ['日','月','火','水','木','金','土']
                         		});
                         </script>
                         </td>
                        <td>
                        	<div class="selectbox lbox">
                        		<div class="select-inner select2"><span></span></div>
                        		<select class="select2" name="night_number" id="night_number">
                        		<?php
                        		for ($i=1; $i<=SITE_STAY_NUM; $i++) {
                        			$selected = '';
                        			if ($collection->getByKey($collection->getKeyValue(), "night_number") == $i) {
                        				$selected = 'selected="selected"';
                        			}
                        		?>
                        		<option value="<?php print $i?>" <?=$selected;?>><?=$i?></option>
                        		<?php }?>
                        		</select>
                        	</div><span>泊</span>
                        </td>
                        <!--<td>
                        	<div class="selectbox lbox">
                        		<div class="select-inner select2"><span></span></div>
                        		<select class="select2" name="room_number" id="room_number">
                        		<?php
                        		for ($i=1; $i<=SITE_ROOM_NUM; $i++) {
                        			$selected = '';
                        			if ($collection->getByKey($collection->getKeyValue(), "room_number") == $i) {
                        				$selected = 'selected="selected"';
                        			}
                        		?>
                        		<option value="<?=$i?>" <?=$selected;?>><?=$i?></option>
                        		<?php }?>
                        		</select>
                        	</div><span>部屋</span>
                        </td>-->
                    	<td>
			<input type="hidden" id="room_number" name="room_number" value="1">
                    		　大人
                    		<?php
                            	$num = 0;
                            	for ($room=1; $room<=SITE_ROOM_NUM; $room++) {
									$num += intval($collection->getByKey($collection->getKeyValue(), "adult_number".$room));
                            		if ($room == 1) {
							?>
								<div class="selectbox" id="ori_adult">
								<div class="select-inner select2 adultseldiv"><span></span></div>
	                            <select name="adult_number<?php print $room?>" id="adult_number<?php print $room?>" class="select2 adultnumset adult_sgl">
                        		<?php
                        		for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
									$selected = '';
									if ($collection->getByKey($collection->getKeyValue(), "adult_number".$room) == $i) {
										$selected = 'selected="selected"';
									}
								?>
                                <option value="<?php print $i?>" <?php print $selected;?>><?php print $i?><?php print ($i==SITE_ADULT_NUM)?"～":""?></option>
                        		<?php }?>
                            	</select></div>

                            <?php }else {?>
                        		<?php print $inputs->hidden("adult_number".$room, $collection->getByKey($collection->getKeyValue(), "adult_number".$room))?>
                        	<?php }?>

                        	<?php }?>

                            <div class="selectbox adultnumset adult_dbl">
								<a href="javascript:void(0)" onclick="openChildSet()" id="adult_text"><?php print $num?></a>
                            </div>

                        	<script type="text/javascript">
                            $(document).ready(function(){
                            	$("#room_number").change(function () {
                            		roomChange();
                            		if ($("#room_number").val() > 1) {
                            			if (pop === undefined) {
	                            		}
                            			else {
		                            		pop.close();
                            			}
	                            		openChildSet();
                            		}
                            		else {
	                            		pop.close();
                            		}
                            	});
                            	roomChange();
                            });
                            function roomChange() {
                        		$(".adultnumset").addClass('dspNon');
                        		$("#adult_number").addClass('dspNon');
                            	if ($("#room_number").val() > 1) {
                            		$(".adult_dbl").removeClass('dspNon');
                            	}
                            	else {
                            		$(".adult_sgl").removeClass('dspNon');
                            	}
                            }
                            </script>
                            <span>名</span>
                    	</td>
                    	<td>
                    		 子供
                    		<div class="selectbox">
                    			<?php
                    				$num = 0;
                    				for ($room=1; $room<=SITE_ROOM_NUM; $room++) {
                    					for ($i=1; $i<=6; $i++) {
                    						$num += intval($collection->getByKey($collection->getKeyValue(), "child_number".$room.$i));
                    				?>
                    				<?php print $inputs->hidden("child_number".$room.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$room.$i))?>
                    				<?php
                    					}
                    				}
                    				?>
                    				<a href="javascript:void(0)" onclick="openChildSet()" id="child_text"><?php print $num?></a>
                    		</div><span>名</span>
                    	</td>
                	</tr>
                	</table>
                	<table>
                	<tr>
                        <td colspan="4" id="arearadio">
	                        <!--<div class="checkmitei"><?=$inputs->checkbox("undecide_sch","undecide_sch",1,$collection->getByKey($collection->getKeyValue(), "undecide_sch"),"日程未定", "")?></div>-->
                        	<div class="radius5 erea"><span class="r-sp">エリア</span>
                        	<input type="radio" value="19" name="area" id="area19" checked="checked">北部　
                        	<input type="radio" value="18" name="area" id="area18">中部　
                        	<input type="radio" value="20" name="area" id="area20">那覇・南部
	                        </div>
                        </td>
                        <td class="searchinput">
                        	<input class="search_bt-B" type="submit" value="" name="" id="">
                        </td>
                	</tr>
                </table>
           	</form>
        </section>


 <!--人気の日程-->
               <section class="search">
               	<h2><img src="./images/front/title-date-1.jpg" width="518" height="30" alt="人気の日程" /></h2>
		<?php require("includes/box/hotel/search_date.php");?>
               </section>

	<!--
		<section class="nbox" id="area">
				<h2><img src="./images/front/title-area.jpg" width="180" height="20" alt="エリアから選ぶ" /></h2>
				<div class="cf">
					<ul class="w126">
						<li><a href="javascript: void(0);" onclick="document.frm9.submit();">国頭村・その他</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm8.submit();">本部・今帰仁</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm7.submit();">名護</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm6.submit();">恩納村</a></li>
					</ul>
					<ul class="w177">
						<li><a href="javascript: void(0);" onclick="document.frm21.submit();">宜野湾市</a></li>
						<li><a href="javascript: void(0);" onclick="document.frm5.submit();">北谷町・読谷村</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm4.submit();">北中城村・沖縄・うるま市</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm2.submit();">那覇市内</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm3.submit();">本島南部</a></li>
					</ul>
					<ul class="w97">
						<li><a href="javascript: void(0);" onclick="document.frm10.submit();">石垣島</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm11.submit();">八重山諸島</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm12.submit();">宮古島</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm13.submit();">久米島</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm14.submit();">慶良間諸島</a></li>
					</ul>
				</div>
			</section>
	-->
	
<!-- /エリアから検索-->


            <!--目的・こだわりから検索-->

<!--
            <section class="search2col cf">
            <section class="l-sp">
            	<h2><img src="./images/front/search-title04.jpg" width="254" height="29" alt="ホテルこだわりから検索" /></h2>

            		<form name="frmHKodawari1" method="post" action="facility-search.html"><?php print $inputs->hidden("hKodawari1", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmHKodawari2" method="post" action="facility-search.html"><?php print $inputs->hidden("hKodawari2", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmHKodawari3" method="post" action="facility-search.html"><?php print $inputs->hidden("hKodawari3", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmHKodawari4" method="post" action="facility-search.html"><?php print $inputs->hidden("hKodawari4", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmHKodawari5" method="post" action="facility-search.html"><?php print $inputs->hidden("hKodawari5", 1); print $inputs->hidden("undecide_sch", 1);?></form>

            		<ul class="w255">
                        <?php /*
                        <li><a href="#">高級ホテル</a></li>
                    	*/?>
                        <li><a href="javascript:void(0);" onclick="document.frmHKodawari1.submit();">海が見えるリゾートホテル</a></li>
                        <li><a href="javascript:void(0);" onclick="document.frmHKodawari2.submit();">夜景がきれいなビジネス・シティ</a></li>
                        <li><a href="javascript:void(0);" onclick="document.frmHKodawari3.submit();">のんびり過ごせる小さなお宿</a></li>
                        <?php /*
                        <li><a href="javascript:void(0);" onclick="document.frmHKodawari4.submit();">気楽に泊まれる貸し切りコテージ</a></li>
                        */?>
                        <li><a href="javascript:void(0);" onclick="document.frmHKodawari5.submit();">ペットと一緒に泊まれるお宿</a></li>
                </ul>
                </section>

                <section>
                	<h2><img src="./images/front/search-title05.jpg" width="254" height="29" alt="施設こだわり検索" /></h2>

                	<form name="frmCKodawari0" method="post" action="facility-search.html"><?php print $inputs->hidden("cKodawari0", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmCKodawari1" method="post" action="facility-search.html"><?php print $inputs->hidden("cKodawari1", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmCKodawari2" method="post" action="facility-search.html"><?php print $inputs->hidden("cKodawari2", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmCKodawari3" method="post" action="facility-search.html"><?php print $inputs->hidden("cKodawari3", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmCKodawari4" method="post" action="facility-search.html"><?php print $inputs->hidden("cKodawari4", 1); print $inputs->hidden("undecide_sch", 1);?></form>
                	<form name="frmCKodawari5" method="post" action="facility-search.html"><?php print $inputs->hidden("cKodawari5", 1); print $inputs->hidden("undecide_sch", 1);?></form>

                	<ul class="w255">
                		<li><a href="javascript:void(0);" onclick="document.frmCKodawari0.submit();">ホテルのプールで思いっきり遊ぶ</a></li>
                		<li><a href="javascript:void(0);" onclick="document.frmCKodawari1.submit();">大浴場・スパでゆったりリラックス</a></li>
                		<li><a href="javascript:void(0);" onclick="document.frmCKodawari2.submit();">みんなでワイワイBBQを楽しむ</a></li>
                		<li><a href="javascript:void(0);" onclick="document.frmCKodawari3.submit();">小さなお子様も安心の和室・和洋室</a></li>
                		<li><a href="javascript:void(0);" onclick="document.frmCKodawari4.submit();">禁煙ルームで快適ステイ</a></li>
                		<li><a href="javascript:void(0);" onclick="document.frmCKodawari5.submit();">みんなに優しいバリアフリー</a></li>
                	</ul>
                </section>
			</section>
-->
</div>
<!-- /こだわり検索-->


<!-- カテゴリー/-->

	<!--
		<section id="top_category">

			<div class="outer">
				<h2 class="title2016" style="margin-bottom:15px;">カテゴリー１</h2>
				<ul>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/37/HOTELPIC_DATA_20150901aa4d204cc5848d0a3dd295d0378506e7d4fd2758.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/47/HOTELPIC_DATA_20130915b2131e8a06f48fa264cfc0a6af3e3908c671101b.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/37/HOTELPIC_DATA_201509012b96ddc9c66de7f8a2ffbfa761c9e07de98ed524.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/38/HOTEL_PIC_APP_2013091105b46ea2a03a61d024b1f601fe9510024c8b52cc.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>

				</ul>
			</div>

			<div class="outer">
				<h2 class="title2016" style="margin-bottom:15px;">カテゴリー１</h2>
				<ul>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/37/HOTELPIC_DATA_20150901aa4d204cc5848d0a3dd295d0378506e7d4fd2758.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/47/HOTELPIC_DATA_20130915b2131e8a06f48fa264cfc0a6af3e3908c671101b.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/37/HOTELPIC_DATA_201509012b96ddc9c66de7f8a2ffbfa761c9e07de98ed524.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/38/HOTEL_PIC_APP_2013091105b46ea2a03a61d024b1f601fe9510024c8b52cc.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>

				</ul>
			</div>
			<div class="outer">
				<h2 class="title2016" style="margin-bottom:15px;">カテゴリー１</h2>
				<ul>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/37/HOTELPIC_DATA_20150901aa4d204cc5848d0a3dd295d0378506e7d4fd2758.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/47/HOTELPIC_DATA_20130915b2131e8a06f48fa264cfc0a6af3e3908c671101b.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/37/HOTELPIC_DATA_201509012b96ddc9c66de7f8a2ffbfa761c9e07de98ed524.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>
					<li>
					<a href="/category_000.html">
						<img src="http://common.cocotomo.net/images/38/HOTEL_PIC_APP_2013091105b46ea2a03a61d024b1f601fe9510024c8b52cc.jpg">
						<div>
							<div class="title">カテゴリータイトル1</div>
							<div class="text">説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文説明文</div>
						</div>
					</a>
					</li>

				</ul>
			</div>
		</section>
	-->

<!--/カテゴリー-->

<br/>
		<h2 class="title2016" style="margin-bottom:15px;">ココトモ掲載中の宿泊施設はこちら</h2>

		<section class="hotel_name">
		
		<ul class="naha">
			<li><h2>那覇・南部</h2></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=46">・サザンビーチホテル＆リゾート</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=25">・ユインチホテル南城</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=64">・ホテルグランビューガーデン沖縄</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=65">・ホテルグランビュー沖縄</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=118">・リゾネックス那覇</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=27">・ホテルサン沖縄</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=19">・那覇ビーチサイドホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=54">・GRGホテル那覇東町</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=10">・ホテルブライオン那覇</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=9">・GRGホテル那覇</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=6">・沖縄ホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=8">・ホテルピースランド久米</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=7">・ホテルピースランド</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=56">・沖縄サンプラザホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=106">・那覇グランドホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=67">・ソルヴィータホテル那覇</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=20">・那覇 東急REIホテル（旧：ホテル東急ビズフォート那覇）</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=35">・琉球サンロイヤルホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=13">・ホテルタイラ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=12">・ウィークリーハーバービューマンション</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=11">・旅の宿　らくちん</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=33">・南西観光ホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=31">・ステーションホテル　牧志</a></li>
		</ul>
		
		<ul class="chuubu">
			<li><h2>中部</h2></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=29">・ホテル日航アリビラ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=114">・ザ・ビーチタワー沖縄</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=38">・ラグナガーデンホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=44">・ムーンオーシャン宜野湾ホテル＆レジデンス</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=37">・オキナワグランメールリゾート</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=104">・AJリゾートアイランド伊計島</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=34">・ビーチサイドコンドミニアムII・III</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=116">・ホテルハンビーリゾート</a></li>
		</ul>
		
		<ul class="hokubu">
			<li><h2>北部</h2></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=22">・オキナワ マリオット リゾート＆スパ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=82">・カヌチャベイホテル＆ヴィラズ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=90">・沖縄かりゆしビーチリゾート・オーシャンスパ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=68">・センチュリオンホテル沖縄美ら海（旧：ロワジールホテル沖縄美ら海）</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=57">・カフーリゾートフチャク コンド・ホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=53">・シェラトン沖縄サンマリーナリゾート(旧：サンマリーナホテル)</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=43">・ホテルムーンビーチ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=49">・ホテルマハイナウェルネスリゾートオキナワ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=48">・ホテルゆがふいんBISE</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=47">・ホテルゆがふいんおきなわ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=42">・マリンピアザオキナワ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=21">・本部グリーンパークホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=28">・沖縄サンコーストホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=95">・ホテル リゾネックス名護</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=50">・喜瀬ビーチパレス</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=52">・恩納マリンビューパレス</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=51">・喜瀬カントリークラブ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=103">・AJ幸喜リゾートホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=102">・AJ恩納ビルリゾートホテル</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=63">・みゆきハマバルリゾート</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=62">・ホテルみゆきビーチ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=94">・プチ・リゾート　なかどまｉｎｎ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=59">・オン・ザ・ビーチ ルー</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=36">・アダ・ガーデンホテル沖縄</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=60">・One suite Hotel&Resort Kouri Island</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=121">・美ら海沖縄の宿　結来</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=109">・WOOD PECKER Nakijin(ウッドペッカー今帰仁)</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=32">・ホテルベルモア東洋</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=107">・やんばるロハス</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=100">・沖縄県　今帰仁　ゆいまーる　「楽」</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=99">・沖縄県　今帰仁　「誉」</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=98">・沖縄県　今帰仁　「ゆくら」</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=97">・沖縄県　今帰仁　ワン泊ハウス「癒」</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=96">・沖縄県　今帰仁　ワン泊ハウス「遊」</a></li>
		</ul>
		
		<ul class="ritou">
			<li><h2>離島</h2></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=115">・サイプレスリゾート久米島</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=91">・ホテルピースランド石垣島</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=66">・ホテルグランビュー石垣</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=117">・ホテルピースアイランド竹富島</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=41">・ホテルピースアイランド宮古島</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=18">・ホテル ブリーズベイマリーナ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=17">・シギラベイサイドスイート アラマンダ</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=16">・ウェルネスヴィラブリッサ（旧：リゾートヴィラブリッサ）</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=15">・星野リゾートリゾナーレ西表島</a></li>
			<li><a href="http://cocotomo.net/search-detail.html?basic=1&hid=14">・星野リゾートリゾナーレ小浜島</a></li>
		</ul>
		</section>


		</main>
<!-- /main-->
	</div>
</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->
</body>
<!-- InstanceEnd --></html>
