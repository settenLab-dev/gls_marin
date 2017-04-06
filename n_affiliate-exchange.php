<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliateChange.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");


$collection = new collection($dbMaster);
$collection->setPost();

$affiliate_change = new affiliateChange($dbMaster);


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>ココトモ！でポイントを貯めよう ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">
<div id="topimage_box">
	<div class="left">
		<img src="images/front/top1.png" width="650" height="348">
	</div>
		<img src="images/front/top2.png" width="670" height="334">
</div>
</div>
<div id="content_mini" class="clearfix">

	<!--main-->
		<!-- InstanceBeginEditable name="maincontents" -->
		<main id="exchange">
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><a href="affiliate.html">ポイント情報</a></li>
	            <li><span>ポイントと特典を交換する</span></li>
	        </ul>
	
	
			<section class="pointexchangeslide">
				<h2><img src="./images/affiliate/title-recommended.png" width="159" height="29" alt="スタッフのおすすめ" /></h2>
				<div class="slideouter">
					<div class="slide">
						<ul class="slidcontents">
							<li>
								<h3 class="cach">島ぞうりもいいけど…</h3>
								<div class="wh-box">
									<img class="detailsimage" src="images/affiliate/item003-list.jpg" width="190" height="101" alt="クロックス（デザインおまかせ）" />
									<a href="affiliate-itemdetail.html?id=8">クロックス（デザインおまかせ）</a>
									<p>おでかけの必需品！水遊びにも便利なクロックスのサンダルをデザインおまかせでお届けします。</p>
									<!--<a href="affiliate-itemdetail.html"><img src="./images/affiliate/bt-coupon_details.jpg" width="190" height="26" alt="詳しい情報とクーポンを見る" /></a>-->
									<div class="privilegepoint_box">
										<div class="privilegepoint">交換ポイント：<span>500</span><span>pt</span></div>
										<div><b>交換期限：2016年9月30日</b></div>
									</div>
								</div>
							</li>
							<li>
								<h3 class="cach">海を見ながらランチを満喫♪</h3>
								<div class="wh-box">
									<img class="detailsimage" src="images/affiliate/item001-list.jpg" width="190" height="101" alt="サザンビーチホテルランチ券ペア" />
									<a href="affiliate-itemdetail.html?id=6">サザンビーチホテルランチ券ペア</a>
									<p>リニューアルしたオーシャンビューレストラン「レイール」で、糸満の海の恵みや農家直送の自然の幸をふんだんに使ったランチブッフェをお楽しみください。</p>
									<!--<a href="affiliate-itemdetail.html"><img src="./images/affiliate/bt-coupon_details.jpg" width="190" height="26" alt="詳しい情報とクーポンを見る" /></a>-->
									<div class="privilegepoint_box">
										<div class="privilegepoint">交換ポイント：<span>500</span><span>pt</span></div>
										<div><b>交換期限：2016年9月30日</b></div>
									</div>
								</div>
							</li>
							<li>
								<h3 class="cach">波音をBGMにのんびり</h3>
								<div class="wh-box">
									<img class="detailsimage" src="images/affiliate/item007-list.jpg" width="190" height="101" alt="喜瀬ビーチパレス宿泊券ペア" />
									<a href="affiliate-itemdetail.html?id=4">喜瀬ビーチパレス宿泊券ペア</a>
									<p>ビーチまで徒歩30秒の近さ！お部屋の窓からも青い海原を一望！のんびり海と過ごす休日を♪</p>
									<!--<a href="affiliate-itemdetail.html"><img src="./images/affiliate/bt-coupon_details.jpg" width="190" height="26" alt="詳しい情報とクーポンを見る" /></a>-->
									<div class="privilegepoint_box">
										<div class="privilegepoint">交換ポイント：<span>1000</span><span>pt</span></div>
										<div><b>交換期限：2016年9月30日</b></div>
									</div>
								</div>
							</li>
							<li>
								<h3 class="cach">非日常リゾート空間へ！</h3>
								<div class="wh-box">
									<img class="detailsimage" src="images/affiliate/item004-list.jpg" width="190" height="101" alt="ホテル日航アリビラ宿泊券ペア" />
									<a href="affiliate-itemdetail.html?id=1">ホテル日航アリビラ宿泊券ペア</a>
									<p>青い海に映える赤瓦屋根と白い壁。異国情緒あふれる南欧風のリゾートで優雅なプチトリップ♪</p>
									<div class="privilegepoint_box">
										<div class="privilegepoint">交換ポイント：<span>2000</span><span>pt</span></div>
										<div><b>交換期限：2016年9月30日</b></div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</section>
	<!-- /slider-->
	
			<!--<section class="form">
				<div class="order">
					並び替え
					<form>
						<div class="selectbox">
							<div class="select-inner select4"><span></span></div>
							<select class="select4">
								<option value="人気順">人気順</option>
								<option value="料金が安い順">料金が安い順</option>
								<option value="料金が高い順">料金が高い順</option>
								<option value="おすすめ順">おすすめ順</option>
							</select>
						</div>
					</form>
				</div>
			</section>-->
	
			<section class="privilegeList_cn" id="privilegeList01">
				<h2><img src="./images/affiliate/title-privilegeList.png" width="281" height="29" alt="ココトモ！ポイントと交換できる特典一覧" /></h2>
				<p class="displayed"><span>8</span>件中<span>1</span>件～<span>8</span>件を表示</p>
				<ul class="privilegeList">
					<li>
						<h3 class="cach">非日常リゾート空間へ！</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item004-list.jpg" width="190" height="101" alt="ホテル日航アリビラ宿泊券ペア" />
							<a href="affiliate-itemdetail.html?id=1">ホテル日航アリビラ宿泊券ペア</a>
							<p>青い海に映える赤瓦屋根と白い壁。異国情緒あふれる南欧風のリゾートで優雅なプチトリップ♪</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>2000</span><span>pt</span></li>
								<li><b>交換期限：2016年9月30日まで</b></li>
							</ul>
						</div>
					</li>
					<li>
						<h3 class="cach">遊んで癒されよう！</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item005-list.jpg" width="190" height="101" alt="ラグナガーデンホテルペア宿泊券" />
							<a href="affiliate-itemdetail.html?id=2">ラグナガーデンホテルペア宿泊券</a>
							<p>宜野湾の中心、ショッピングもエンターテイメントも楽しめるリゾートで楽しいひと時を！</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>1200</span><span>pt</span></li>
								<li><b>交換期限：2016年9月30日まで</b></li>
							</ul>
						</div>
					</li>
					<li>
						<h3 class="cach">波音をBGMにのんびり♪</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item007-list.jpg" width="190" height="101" alt="喜瀬ビーチパレス宿泊券ペア" />
							<a href="affiliate-itemdetail.html?id=4">喜瀬ビーチパレス宿泊券ペア</a>
							<p>ビーチまで徒歩30秒の近さ！お部屋の窓からも青い海原を一望！のんびり海と過ごす休日を♪</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>1000</span><span>pt</span></li>
								<li><b>交換期限：2016年9月30日まで</b></li>
							</ul>
						</div>
					</li>
					<li>
						<h3 class="cach">家族、グループに人気！</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item008-list.jpg" width="190" height="101" alt="恩納マリンビューパレス宿泊券ペア" />
							<a href="affiliate-itemdetail.html?id=5">恩納マリンビューパレス宿泊券ペア</a>
							<p>小さなお子様も安心の広々和洋室が人気！恩納村の中心にあり、北部へのおでかけにピッタリ！</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>1000</span><span>pt</span></li>
								<li><b>交換期限：2016年9月30日まで</b></li>
							</ul>
						</div>
					</li>
					<li>
						<h3 class="cach">海を見ながらランチを満喫♪</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item001-list.jpg" width="190" height="101" alt="サザンビーチホテルランチ券ペア" />
							<a href="affiliate-itemdetail.html?id=6">サザンビーチホテルランチ券ペア</a>
							<p>リニューアルしたオーシャンビューレストラン「レイール」で、糸満の海の恵みや農家直送の自然の幸をふんだんに使ったランチブッフェをお楽しみください。</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>500</span><span>pt</span></li>
								<li><b>交換期限：2016年9月30日まで</b></li>
							</ul>
						</div>
					</li>
					<li>
						<h3 class="cach">島ぞうりもいいけどこれもネ</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item003-list.jpg" width="190" height="101" alt="クロックス（デザインおまかせ）" />
							<a href="affiliate-itemdetail.html?id=8">クロックス（デザインおまかせ）</a>
							<p>おでかけの必需品！水遊びにも便利なクロックスのサンダルをデザインおまかせでお届けします。</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>500</span><span>pt</span></li>
								<li><b>交換期限：2016年3月31日まで</b></li>
							</ul>
						</div>
					</li>
				</ul>
	
<!--	        <ul id="navigation">
	            <li><a>1</a></li>
	            <li id="current2"><a>2</a></li>
-->

<!--	            <li class="prev"><a href="#">前の4件</a></li>
	            <li class="" id="current1">1</li>
	            <li><a id="current2">2</a></li>
	            <li><a href="#">3</a></li>
	            <li><a href="#">4</a></li>
	            <li><a href="#">5</a></li>
	            <li><a href="#">6</a></li>
	            <li><a href="#">7</a></li>
	            <li><a href="#">8</a></li>
	            <li><a href="#">9</a></li>
	            <li><a href="#">10</a></li>
	            <li class="next"><a href="#">次の4件</a></li>-->
	        </ul>
			</section>


<!--			<section class="privilegeList_cn" id="privilegeList">
				<h2><img src="./images/affiliate/title-privilegeList.png" width="281" height="29" alt="ココトモ！ポイントと交換できる特典一覧" /></h2>
				<p class="displayed"><span>8</span>件中<span>7</span>件～<span>8</span>件を表示</p>

				<ul class="privilegeList">
					<li>
						<h3 class="cach">空を飛んでみよう！</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item002-list.jpg" width="190" height="101" alt="フライボード体験15分ペア" />
							<a href="affiliate-itemdetail.html?id=7">フライボード体験15分ペア</a>
							<p>CMでも話題の水圧で空を飛ぶ新感覚のレジャー！気軽に空を飛んでみませんか！</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>250</span><span>pt</span></li>
								<li><b>交換期限：2014年3月31日まで</b></li>
							</ul>
						</div>
					</li>
					<li>
						<h3 class="cach">OPEN限定★島ぞうりもいいけど</h3>
						<div class="wh-box">
							<img class="detailsimage" src="images/affiliate/item003-list.jpg" width="190" height="101" alt="クロックス（デザインおまかせ）" />
							<a href="affiliate-itemdetail.html?id=8">クロックス（デザインおまかせ）</a>
							<p>おでかけの必需品！水遊びにも便利なクロックスのサンダルをデザインおまかせでお届けします。</p>
							<ul>
								<li class="privilegepoint">交換ポイント：<span>250</span><span>pt</span></li>
								<li><b>交換期限：2014年3月31日まで</b></li>
							</ul>
						</div>
					</li>
				</ul>
	
	        <ul id="navigation">
	            <li class="" id="current1"><a>1</a></li>
	            <li><a>2</a></li>

	            <li class="prev"><a href="#">前の4件</a></li>
	            <li class="" id="current1">1</li>
	            <li><a id="current2">2</a></li>
	            <li><a href="#">3</a></li>
	            <li><a href="#">4</a></li>
	            <li><a href="#">5</a></li>
	            <li><a href="#">6</a></li>
	            <li><a href="#">7</a></li>
	            <li><a href="#">8</a></li>
	            <li><a href="#">9</a></li>
	            <li><a href="#">10</a></li>
	            <li class="next"><a href="#">次の4件</a></li>
	        </ul>
			</section>
-->

<script type="text/javascript">
$(function(){
    $("#privilegeList").css("display", "none");
    $("#current2").click(function(){
    $("#privilegeList01").css("display", "none");
        $("#privilegeList").toggle();
    });
});

$(function(){
    $("#current1").click(function(){
    $("#privilegeList").css("display", "none");
        $("#privilegeList01").css("display", "block");
    });
});
</script>	
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
