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
<?php require("includes/box/common/meta201505.php"); ?>
<title>【試行中】ココトモでポイント貯めよう使おう！ ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>


<!-- ↓ココからHTML編集 -->



<body id="top" style="background:none;border-top:none;">

<!-- ↓ヘッダー読み込み編集不要 -->
<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->


<!--content-->
<div id="content" class="clearfix">

	<!--main-->
		<!-- InstanceBeginEditable name="maincontents" -->
		<main id="howtop">

			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><a href="index.html">サイトの利用方法</a></li>
	            <li><span>ポイントの貯め方</span></li>
	        </ul>

			<section>
			<h2>【試行中】ココトモポイントについて</h2>
                                    <p>ココトモのポイントは、会員様がココトモを使うたびにどんどん貯まり、少しのポイントを貯めるだけでお得にいろんな特典と交換できるサービスです。</br>
					現在、試行版サービスをご提供しています。</p>
                                    <h3>ポイントの貯め方</h3>
                                    <p>
                                    <img src="./images/about_p/abp_img01.jpg" alt="宿泊やレジャー、グルメ、お買い物を楽しんでポイントが貯まる！"><br />
                                    ココトモのポイントは、ココトモでご利用料金の発生するサービス（宿泊予約、レジャー予約、クーポンなど）をご利用いただく度に貯まります。<br />
（ポイントは購入金額の税抜価格を基準に計算します。）<br />
さらに、提携サイトでのお買い物でもポイントが貯まります。お買い物をしたサイトのポイントも貯まってWでお得！<br />
このほかにも、ポイント対象となるココトモの企画やイベントに参加することでもポイントが貯まります。ポイントはご利用の1～6ヶ月後に付与
されます。<br />
（※ご利用のサービス、提携サイトによってポイント付与の時期は異なります。）<br />
                                    </p>
			</section>


			<section>
				<h2>ポイントを特典と交換する</h2>
				<p>貯まったポイントは、驚きの還元率でお得に特典と交換できます。<br />
				ホテルの宿泊券やランチ券、衣類や電化製品、ココトモオリジナルグッズなど豊富な特典からお楽しみください!<br />
				<img src="./images/about_p/abp_img02.jpg" alt="貯まったポイントでホテル宿泊券やランチ券などの特典にお得に交換！">
				</p>
				<h3>交換方法</h3>
				<div class="abp_mainbox">
				<div class="abp_box1">
					<img src="./images/about_p/save-img04.jpg" alt="ポイントを特典と交換する"><br />
					<img src="./images/about_p/save-img05.jpg" alt="会員登録の住所宛てに特典をお届けします" style="margin-top:20px;">
				</div>
				<div class="abp_box2">
					<a href="n_affiliate-exchange.html"><img src="./images/about_p/abp_tokuten.jpg" alt="特典交換ページはコチラをクリック！"></a>
				</div>
				</div>
				<h3>ポイント確認方法</h3>
				<p>現在のポイント数は、サイト上のステータス画面、またはマイページの「ポイント残高」よりご確認いただけます。<br />
				<img src="./images/about_p/save-img06.jpg" alt="マイページのポイント残高にて、ポイント数を確認">
				</p>

			</section>


			<section>
				<h2>ポイント付与、ご利用時の注意点</h2>
				<p>ポイントの有効期限はポイントを獲得した日から１年間です。<br />
				新しくポイントを獲得した場合、保有しているすべてのポイントの有効期限が、新しくポイントを獲得した日から
				１年間に自動で延長されます。</p>
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


<!-- ↑ココまでHTML -->

<!-- ↓フッター読み込み編集不要 -->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
