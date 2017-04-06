<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliate.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta_new.php"); ?>
<title>ココトモ！でポイントを貯めよう ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_point.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_mini" class="clearfix">

	<!--main-->
		<!-- InstanceBeginEditable name="maincontents" -->
		<main id="howto">
	
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><a href="index.html">サイトの利用方法</a></li>
	            <li><span>ポイントの貯め方</span></li>
	        </ul>
	
			<section>
				<div class="t-title"><img src="./images/savepoint/save-_title01.jpg" width="950" alt="ポイントの貯め方" /></div>
				<div class="seave_case">
					<ul class="pointimageList cf">
						<li><img src="./images/savepoint/save-img01.jpg" width="229" height="283" alt="宿泊予約サービスを利用" /></li>
						<li class="cbox"><img src="./images/savepoint/save-img02.jpg" width="229" height="283" alt="提携サイトでお買いもの" /></li>
						<li><img src="./images/savepoint/save-img03.jpg" width="229" height="283" alt="イベントに参加お友達にココトモ！を紹介" /></li>
					</ul>
					<p>
						ココトモ！ポイントは、ココトモ！で宿泊予約サービスを利用すると貯まります。(ポイントは購入金額の税抜価格を基準に計算します。)さらに、提携サイトでのお買いものでもポイントが貯まります。お買いものをしたサイトのポイントも貯まってWでお得！
					</p>
					<p>
						このほかにも、ココトモ！のイベントに参加したり、お友達にココトモ！を紹介した時もポイントが貯まります。
	ポイントはご利用の1～6か月後に付与されます。
					</p>
					<p>
						（※ご利用のサービス、提携サイトによってポイント付与の時期は異なります。）
					</p>
				</div>
			</section>
	
	
			<section>
				<h2 class="linktxt t-title"><img src="./images/savepoint/save-_title02.jpg" width="950" alt="ポイントを使う（特典と交換する）" /><a href="n_affiliate-exchange.html">ポイントと交換できる特典はこちら>></a></h2>
				<div class="seave_case">
					<p class="t-title">貯まったポイントは、驚きの還元率でお得に特典と交換できます。<br />
	ホテルの宿泊券やランチ券、衣類や電化製品、ココトモ！オリジナルグッズなど豊富な特典からお楽しみください！</p>
					<div id="pointimage1">
						<div>
							<p>好きな特典を選んで・・・</p>
							<p>交換するボタンを押すだけ！</p>
							<p>会員登録の住所宛てに特典をお届けします♪</p>
						</div>
						<div id="savetokuten"><p>会員登録の住所宛てに特典をお届けします♪</p></div>
					</div>
				</div>
			</section>
	
			<section>
				<h2 class="t-title"><img src="./images/savepoint/save-_title03.jpg" width="950" alt="ポイント確認方法" /></h2>
				<div class="seave_case">
					<p class="t-title">現在のココトモ！ポイントは、サイト右上のステータス画面、またはマイページの「ポイント残高」よりご確認いただけます。</p>
					<div id="pointimage2">
						<p>マイページポイント残高画面</p>
						<p>ステータス画面ポイント残高</p>
					</div>
				</div>
			</section>
	
			<section>
				<h2 class="t-title"><img src="./images/savepoint/save-_title04.jpg" width="950" alt="ポイントの有効期限" /></h2>
				<div class="seave_case">
					<p class="t-title">ココトモ！ポイントの有効期限はポイントを獲得した日から1年間です。<br />
	新しくポイントを獲得した場合、保有しているすべてのポイントの有効期限が、新しくポイントを獲得した日から1年間に自動で延長されます。</p>
				</div>
			</section>
	
			<section>
				<h2 class="t-title"><img src="./images/savepoint/save-_title05.jpg" width="950" alt="宿泊予約やお買いものでポイントを貯める際の注意点" /></h2>
				<div class="seave_case">
					<ul class="pointterms">
						<li>宿泊予約やお買いものをキャンセル・返品された場合、ポイントは付与されません。無連絡不泊された場合も同様です。</li>
	
						<li>ココトモ！をご利用の際は、ブラウザのCookie設定をON（許可する）にしてください。Cookie設定がOFFになっている場合、ご予約・お買いもの状況の確認ができないため、ポイントを付与することができません。</li>
	
						<li>提携サイトでお買いものをする際、必ず「ココトモ！でポイント貯めよう」のページを通して提携サイトへお進みください。ブックマーク（お気に入り）や、Web検索から直接提携サイトへ訪問した場合、ポイントは付与されません。また、訪問中にブラウザを閉じたり、別のサイトへ移動した場合も、ポイントは付与されません。もう一度、ココトモ！から提携サイトへお進みください。</li>
	
						<li>提携サイトのお買いものでココトモ！ポイントが貯まるのは1回目の購入のみです。連続してお買いものをする場合は、もう一度ココトモ！から提携サイトへお進みください。</li>
	
						<li>ココトモ！を通して提携サイトへ進んだ場合でも、お電話やFAX、メールなど、サイトを通さずにご注文いただいた商品はポイント付与対象外です。</li>
	
						<li>提携サイトの商品、サービスにつきましては、直接提携サイトまでお問い合わせください。</li>
	
						<li>ポイントは購入金額の税抜価格を基準に計算します。小数点以下のポイント額が発生した場合は、1円分未満を切り捨てます。</li>
	
						<li>ポイントの付与率は、ココトモ！が行うキャンペーンや、提携サイトの都合などにより予告なく変更する場合があります。</li>
	
						<li>不正行為や、いたずら行為とみなされる行為が行われた場合は、ポイントが付与される権利を失います。不正行為、いたずら行為とみなす判断はココトモ！が行います。</li>
					</ul>
				</div>
			</section>
	
	    </main>
		<!-- InstanceEndEditable -->    
	    <!--/main-->		

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_n.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
