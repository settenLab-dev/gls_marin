<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
//会員しか見えない
if (!$sess->sessionCheck()) {
	$_SESSION['ref_url']=$_SERVER['REQUEST_URI'];
	cmLocationChange("login.html");
}

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
<?php require("includes/box/common/meta.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title><?php print SITE_PUBLIC_NAME?></title>
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
            <li>ココトモ！お年玉キャンペーン</li>
        </ul>

		<!--topimage-->
		<div id="newyear_cn">
		<img src="./images/newyear/newyear1.png" width="721" height="143" alt="" />
		<div class="topimage"><img src="./images/newyear/newyear2.png" width="378" height="130" alt="" /><a href="affiliate-exchange.html" target="blank"><img src="./images/newyear/newyear3.png" width="342" height="130" alt="" /></a></div>
		<a href="present_cpn.html" target="blank"><img src="./images/newyear/newyear4.png" width="721" height="144" alt="" /></a>
		<img src="./images/newyear/newyear5.png" width="719" height="113" alt="" />


<article id="planning">
				<ul>
					<li>
						<a href="#plan5000"><img src="./images/newyear/menu1.png" /></a>
					</li>
					<li>
						<a href="#plan10000"><img src="./images/newyear/menu2.png" /></a>
					</li>
					<li>
						<a href="#plan20000"><img src="./images/newyear/menu3.png" /></a>
					</li>
					<li>
						<a href="#plan_other"><img src="./images/newyear/menu4.png" /></a>
					</li>
							</ul>
			</article></br></br>　　　



			<div><h2><img src="./images/newyear/title1.png" width="718" height="59" alt="2人で5000円プラン" /></h2>
			<section id="plan5000" class="waku_s b-sp"></br>
				<article>
					<ul class="wakuList cf">
						<li>
							<div class="plan_h"><p>本部</p><h3>マリンピアザオキナワ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/42/HOTELPIC_DATA_20130906d6f16df3937219e0b6ddda0542d6786c623401cb.jpg?1388569851" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							このお値段はお得！美ら海水族館へ遊びに行くのも便利♪敷地内にはイルカと遊べるもとぶ元気村もありますよ！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>那覇</p><h3>ホテル東急ビズフォート那覇</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/20/HOTELPIC_DATA_20130926a014bc9450e90d60ce74b1e8c58410f6a2ae1754.jpg?1388569903" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							人気の東急ホテルにお得に泊まれる！寝心地にこだわったベッドやマッサージ効果抜群のシャワーは手放したくない心地よさ！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>豊見城</p><h3>ホテルグランビューガーデン沖縄</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/64/HOTELPIC_DATA_201310182fa111ae41d625a700c2e94f887bad100fcd1b20.jpg?1388569601" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							ゆったりツインルームがお得！アウトレットモールも近く、思う存分ショッピングも楽しめます！歩き疲れた体は大浴場で癒せます♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>那覇</p><h3>ホテルブライオン那覇</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/10/HOTELPIC_DATA_201309077b1c01a51648891d7d72f80f4b93c02b26b3e4ca.jpg?1388569925" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							ヨーロッパ調のゴージャスなホテル！上品なお部屋は快適さ◎！パンやおにぎり、おみそ汁などが並ぶ無料の朝食付♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>那覇</p><h3>ホテルピースランド久米</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/8/HOTELPIC_DATA_20130913c772757c81d813ac4ace5f8db56182dc36100efc.jpg?1388569952" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							洗濯乾燥機や電子レンジなど快適に住める設備が充実！飲んだ帰りやお仕事、デートに、おうち気分で気軽に泊まろう！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"></div>
							</br><img src="./images/newyear/new.png">
						</li>
					</ul>
				</article>
			</section>
			
						<article id="planning">
				<ul>
					<li>
						<a href="#plan5000"><img src="./images/newyear/menu1.png" /></a>
					</li>
					<li>
						<a href="#plan10000"><img src="./images/newyear/menu2.png" /></a>
					</li>
					<li>
						<a href="#plan20000"><img src="./images/newyear/menu3.png" /></a>
					</li>
					<li>
						<a href="#plan_other"><img src="./images/newyear/menu4.png" /></a>
					</li>
							</ul>
			</article>　　　
			
			<h2><img src="./images/newyear/title2.png" width="719" height="59" alt="2人で10000円プラン" /></h2>
			<section id="plan10000" class="waku_s b-sp"></br>
				<article>
					<ul class="wakuList cf">
						<li>
							<div class="plan_h"><p>恩納村</p><h3>沖縄かりゆしビーチリゾート・オーシャンスパ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/90/HOTELPIC_DATA_201312188fa2c490f644bf2d2f12b939c53b689fb935cc0d.jpg?1388569337" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							露天風呂や海の見える大浴場などスパが滞在中無料！さらに、朝食付！館内は140万個のイルミネーションでライトアップ！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>恩納村</p><h3>ホテルムーンビーチ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/43/HOTEL_PIC_APP_20130911576f1484599671ee4c83696d065ca464f9dbe43c.jpg?1388569641" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							三日月形のビーチと自然に包まれてのんびり♪朝食もビーチを眺めながらお楽しみいただけます！ほっと癒される大浴場入場券付！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>宜野湾</p><h3>ラグナガーデンホテル</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/38/HOTEL_PIC_APP_2013091105b46ea2a03a61d024b1f601fe9510024c8b52cc.jpg?1388569723" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							このお値段で和食と洋食から選べる朝食バイキング付！朝食はランチにも変更OK♪人気の屋内プール＆ジャグジーも滞在中無料！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>本部町</p><h3>チサンリゾート沖縄美ら海</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/68/HOTEL_PIC_APP_201312079b9dc8a2caa79ca1c27a65de38603b23db8e8f6c.jpg?1388569469" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							美ら海水族館目の前！美ら海のラウンジ「Sun set」ご利用OK！軽食やお酒を楽しんだり、朝食をお召し上がりいただけます♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>本部町</p><h3>マリンピアザオキナワ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/42/HOTELPIC_DATA_20130906d6f16df3937219e0b6ddda0542d6786c623401cb.jpg?1388569851" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							サンゴの海クルージング・水族館の人気者イルカを間近で体感・キラキラ輝くジェルキャンドル作りの3つから選べる体験と朝食付！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>糸満</p><h3>サザンビーチホテル＆リゾート</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/46/HOTEL_PIC_FAC1_201309076f26a0e7a631cad2f11e5f52cd9203c0a1bfc1af.jpg?1388569680" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】</br>
							1泊朝食付きでこれはお得！今夏リニューアルしたレストランは朝食もパワーアップ！焼きたてのパンやスイーツが充実♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>豊見城</p><h3>ホテルグランビューガーデン沖縄</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/64/HOTELPIC_DATA_201310182fa111ae41d625a700c2e94f887bad100fcd1b20.jpg?1388569601" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							窓から海と飛行機が楽しめます！地元の食材を使った和食レストランでの夕朝2食付♪大浴場も利用無料！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"></div>
							</br><img src="./images/newyear/new.png">
						</li>
						<!--<li class="r-sp">
							<div class="plan_h"><p>沖縄市</p><h3>東京第一ホテルオキナワグランメールリゾート</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/37/HOTELPIC_DATA_2013091748d1176bd4b7cce29dd7eafcedbd8b1a97553205.jpg?1388569746" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							先着1日1室限定でスイートルームへUPグレード！アップできなくても1人1000円分館内利用券プレゼント♪朝食バイキング付！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>恩納村</p><h3>恩納マリンビューパレス</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/52/HOTEL_PIC_APP_20130907d8a64f2d90e72cf428e100f088704e009963d8b1.jpg?1388569572" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							1月以降開催！3～5歳は無料♪冬休みに家族でクジラに会いに行きませんか！クジラに会えなかったら別の日に再乗船OK！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>名護</p><h3>喜瀬ビーチパレス</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/50/HOTEL_PIC_APP_20130907a288358b8cb339762e0f2ad586b034b7e5bfa313.jpg?1388569707" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							1月以降開催！北谷から出発して座間味島付近までクジラたちを探しに行きます！会えなかったら再乗船or全額返金！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>-->
					</ul>
				</article>
			</section>
			
			<article id="planning">
				<ul>
					<li>
						<a href="#plan5000"><img src="./images/newyear/menu1.png" /></a>
					</li>
					<li>
						<a href="#plan10000"><img src="./images/newyear/menu2.png" /></a>
					</li>
					<li>
						<a href="#plan20000"><img src="./images/newyear/menu3.png" /></a>
					</li>
					<li>
						<a href="#plan_other"><img src="./images/newyear/menu4.png" /></a>
					</li>
							</ul>
			</article>　　　
			
			<h2><img src="./images/newyear/title3.png" width="719" height="59" alt="2人で20000円プラン" /></h2>
			<section id="plan20000" class="waku_s b-sp"></br>
				<article>
					<ul class="wakuList cf">
						<li>
							<div class="plan_h"><p>名護</p><h3>オキナワ マリオット リゾート＆スパ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/22/HOTEL_PIC_APP_201309112d1bfe7bbdb01e874352be142967017ecabb3b08.jpg?1388569787" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							ブッフェ、BBQ、和食、中華から選べる夕食付！自分で絞りたてを作れるフレッシュジュースや中華粥が人気の朝食も付いてます♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>読谷村</p><h3>ホテル日航アリビラ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/29/HOTEL_PIC_APP_2013091089fabb46204f2c415029e951a46aaf1cc1ec6de0.jpg?1388569772" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							プティスイーツバイキングと、オムレツや紅芋ジャムが人気の朝食付♪さらに1人につき3000円相当の館内利用券付！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>宜野座</p><h3>アムスホテルズ カンナリゾートヴィラ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/26/HOTELPIC_DATA_201309100f2cb26e5a9be3a8f83fdc24e3e17b46060cd40d.jpg?1388569809" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							全室スイートルーム！1棟立てのヴィラはプライベート感たっぷり♪1人2000円分のレストラン利用券＆12時ﾁｪｯｸｱｳﾄ特典付！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>恩納村</p><h3>カフーリゾートフチャク コンド・ホテル</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/57/HOTEL_PIC_APP_20131009d29a65b3dbcae39d26da93a33869f5f4a168630b.jpg?1388569495" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							なんと、通常58,500円の贅沢なお部屋がお年玉限定82％OFF!?さらにランチ＆デリ朝食付♪ランチはﾁｪｯｸｲﾝ前でもOK！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>恩納村</p><h3>ホテルムーンビーチ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/43/HOTEL_PIC_APP_20130911576f1484599671ee4c83696d065ca464f9dbe43c.jpg?1388569641" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							海が見えるお部屋をご用意！さらに和洋琉ブッフェと和琉炉端焼きの2つから選べる夕食と朝食ブッフェ、大浴場入場券付♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>今帰仁</p><h3>ワンスイート古宇利島ホテル＆リゾート</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/60/HOTELPIC_DATA_20131007046a36e3887c9c69b06314e569be07bac49224c7.jpg?1388569527" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							見渡す限りの美しい海と緑！古宇利島の絶景を独り占めできる1日1組限定のスイートルーム！のんびり二人の時間を♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>本部町</p><h3>マリンピアザオキナワ</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/42/HOTELPIC_DATA_20130906d6f16df3937219e0b6ddda0542d6786c623401cb.jpg?1388569851" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							海とイルカを大満喫！美ら海水族館の入場券とクルージングorイルカを間近で見られる体験メニューの特典付！さらに夕朝2食付♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>宜野湾</p><h3>ラグナガーデンホテル</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/38/HOTEL_PIC_APP_2013091105b46ea2a03a61d024b1f601fe9510024c8b52cc.jpg?1388569723" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							オーシャンビューのお部屋をご用意！さらに4つのレストランから選べる夕食＆朝食付！プール施設も利用無料♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>宜野湾</p><h3>ムーンオーシャン宜野湾ホテル＆レジデンス</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/44/HOTEL_PIC_APP_20131009e52cca2fd056f64a3e3174508c58a96377361bba.jpg?1388569665" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							広々スイートルームで贅沢な時間♪それとも、レストランでディナーを満喫！2プランからお好みに合わせて選べます！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>糸満</p><h3>サザンビーチホテル＆リゾート</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/46/HOTEL_PIC_FAC1_201309076f26a0e7a631cad2f11e5f52cd9203c0a1bfc1af.jpg?1388569680" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							最上階特別フロアへ！ラウンジでは軽食やドリンクを楽しめます！BARタイムには種類豊富なお酒、朝食にはｴｯｸﾞﾍﾞﾈﾃﾞｨｸﾄが登場！</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
					</ul>
				</article>
			</section>

			<article id="planning">
				<ul>
					<li>
						<a href="#plan5000"><img src="./images/newyear/menu1.png" /></a>
					</li>
					<li>
						<a href="#plan10000"><img src="./images/newyear/menu2.png" /></a>
					</li>
					<li>
						<a href="#plan20000"><img src="./images/newyear/menu3.png" /></a>
					</li>
					<li>
						<a href="#plan_other"><img src="./images/newyear/menu4.png" /></a>
					</li>
							</ul>
			</article>　　　
			
			<h2><img src="./images/newyear/title4.png" width="718" height="45" alt="その他のお得なプラン" /></h2>
			<section id="plan_other" class="waku_s b-sp"></br>
				<article>
					<!--<ul class="wakuList cf">
						<li>
							<div class="plan_h"><p>今帰仁</p><h3>ワンスイート古宇利島ホテル＆リゾート</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/60/HOTELPIC_DATA_20131007d7bf194dfbbb5da8cfe4b30bfedfa93732945aae.jpg" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							ココトモ限定で50％OFF!!古宇利島の頂上、絶景を見下ろすお洒落な一戸建てリゾート！最大6名様までご宿泊OK！新年会にも♪</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>恩納村</p><h3>サンマリーナホテル</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/53/HOTEL_PIC_APP_20130910d2037bb7f89b6421a6eed301d800e763bb774095.jpg" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							南米式BBQシュラスコや自分で作れる海鮮丼など、贅沢メニュー盛りだくさんの夕食ブッフェとランチ変更OKの朝食バイキング付</br>
							</p>
							</div>
								<img src="./images/newyear/line_btn.png">
						</li>
						<li>
							<div class="plan_h"><p>名護</p><h3>カヌチャベイホテル＆リゾート</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/82/HOTELPIC_DATA_20131204fc0bbc379502278f812087b0192372f92b37fc2a.jpg" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							冬のイルミネーションといえばカヌチャ！カフェでの1杯＆ホログラスプレゼント♪館内の移動に便利なレンタルカート50％OFF！</br>
							</p>
							</div>
								<a href="http://cocotomo.net/plan-detail.html?company_id=82&hotelplan_id=327&room_id=589&night_number=1&room_number=1&adult_number1=2&undecide_sch=1"><img src="./images/newyear/line_btn.png"></a>
						</li>
						<li class="r-sp">
							<div class="plan_h"><p>恩納村</p><h3>恩納マリンビューパレス</h3></div>
							<img class="fl-l" src="http://common.cocotomo.net/images/52/HOTEL_PIC_APP_20130907d8a64f2d90e72cf428e100f088704e009963d8b1.jpg" width="160" height="140" alt="外観" />
							<div><p>【ココトモ！のおすすめ】<br>
							ピークをズラしてのんびり！最上階レストランでの夕朝バイキング2食付！家族みんなでゆったり過ごせる広々和洋室♪</br>
							</p>
							</div>
								<a href="http://cocotomo.net/plan-detail.html?company_id=52&hotelplan_id=370&room_id=260&night_number=1&room_number=1&adult_number1=2&undecide_sch=1"><img src="./images/newyear/line_btn.png"></a>
						</li>
					</ul>-->
				</article>
				
		<div>
		<a href="http://cocotomo.net/facility-search.html?room_number=1&night_number=1&adult_number1=2&undecide_srh=1" target="blank"><img src="./images/newyear/hotel_search.png" width="313" height="68" alt="" /></a>　　　　　
		<a href="http://cocotomo.net/tour-pickup.html" target="blank"><img src="./images/newyear/leisure_search.png" width="314" height="68" alt="" /></a>
				  </div>
			</section>
</div>
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

