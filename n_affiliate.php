<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliate.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');


$dbMaster = new dbMaster();

//	表示するバナー表示箇所ID
$bannerId = 1;

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");


$affiliate = new affiliate($dbMaster);

$collection = new collection($dbMaster);
$collection->setPost();

$affiliate->selectList($collection);


$xmlCategory = new xml(XML_AFFILIATE_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$affiliate->setErrorFirst("カテゴリデータの読み込みに失敗しました");
}

$xmlCategoryDetail = new xml(XML_AFFILIATE_CATEGORY_DETAIL);
$xmlCategoryDetail->load();
if (!$xmlCategoryDetail->getXml()) {
	$affiliate->setErrorFirst("詳細カテゴリデータの読み込みに失敗しました");
}

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$affiliate->setErrorFirst("エリアデータの読み込みに失敗しました");
}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>お買い物でポイントを貯めよう！ネットでお買い物 ｜ 地域限定！お得なレジャーとグルメの専門サイト「ココトモ」</title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<script type="text/javascript">
function showAll(id){
	$(".r-column"+id).show();
}
/**
 * var has=true;
function showAll(id){
if(has){
	$(".r-column"+id).fadeIn();
	has=false;
}else{
	$(".r-column"+id).fadeOut();
	has=true;
}
}
 */
</script>

</head>

<body id="top" style="background:none;border-top:none;">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<section>
    	<div class="mainimage">
       	<img src="images/index2016/img_shopping.jpg" width="1323" height="250" alt="色んなお買いものでポイント貯めよう！">
	</div>
	</section>

	<div id="content-ln" class="cf">
		<?php require("includes/box/common/kuchikomi2016.php");?>	</div>

	<main id="content-r">
		

		<div class="intro">沖縄では、なかなか手に入らないアイテムも、通販ならラクチン便利でお得にお買い物！<br/>しかも、ココトモからのお買い物なら、ポイントもついてさらにお得♪</div>

	<!--<img src="/images/hotel/pickup_c.png" width="1085" height="44" alt="ピックアップ" />-->
		<div class="contents_box cf">
	<img src="/images/affiliate/title_ranking.jpg" width="727" height="30" alt="人気ランキング" />
			<div class="ranking">
			<div class="pic">
			<div class="title_pic"><img src="images/affiliate/rank1.png"><a href="/affiliate-link9.html"><img src="images/affiliate/crocs_banner.gif"><B>クロックス</B></a></div>
			<div class="shop_pic1">
				<span>急なカタブイにも安心♪快適くつ♪</span>
				<div class="banner"><a href="/affiliate-link9.html"><img src="http://common.cocotomo.net/images/70/AFFILIATE_PIC1_201404218f190826d8091af23572d8bb512bb67ac294c369.jpg" width="234" height="60" alt="今週のお得な限定プランはコチラ！！" /></a></div>
				<p style="font-size:12px;">通気性抜群で人気のサンダルから、オフィスでも使えるちょっとおしゃれな快適シューズ、気軽に普段使いできるブーツやパンプスまで揃います♪</p>
			</div>
			</div>
			<div class="pic">
			<div class="title_pic"><img src="images/affiliate/rank2.png"><a href="/affiliate-link15.html"><B>ベルメゾンネット</B></a></div>
			<div class="shop_pic2">
				<span>おうちで気軽にお買い物♪</span>
				<div class="banner"><a href="/affiliate-link15.html"><img src="http://common.cocotomo.net/images/93/AFFILIATE_PIC1_20150219ce9df333caa55b40be3bcd2155c727ec1e9cea15.gif" width="234" height="60" alt="今週のお得な限定プランはコチラ！！" /></a></div>
				<p style="font-size:12px;">ファッションから家具、スイーツまで、お手頃価格で種類豊富！新生活の準備も全部揃います！お仕事や家事の合間にも気軽にお買い物を楽しめちゃいますよ！</p>
			</div>
			</div>
			<div class="pic">
			<div class="title_pic"><img src="images/affiliate/rank3.png"><a href="/affiliate-link8.html"><!--<img src="images/affiliate/benesse_banner.gif">--><B>cosme.com</B></a></div>
			<div class="shop_pic3">
				<span>本当に使えるコスメが見つかる！</span>
				<div class="banner"><a href="/affiliate-link8.html"><img src="http://common.cocotomo.net/images//AFFILIATE_PIC1_20131105a5cc1f1c060c8d73274ab8268273c2bacc6a66b9.jpg" width="234" height="60" alt="今週のお得な限定プランはコチラ！！" /></a></div>
				<p style="font-size:12px;">人気のコスメクチコミサイト@cosmeのショッピングサイト！みんなのクチコミを参考にしながら、自分に合ったコスメを探して買えちゃいます♪</p>
			</div>
			</div>
			</div>
		</div>


        
        <!--list-->
	<h2 class="title2016" style="margin-bottom:15px;">提携ショップ一覧</h2>
	<p>9件中1～9件を表示中</p>
        <section>
            <?php
            if ($xmlCategory->getXml() and $affiliate->getCount() > 0) {
				$cateCnt = 0;
				foreach ($xmlCategory->getXml() as $cat) {
					$dataAr = array();
					if ("".$cat->status != 1) {
						continue;
					}

					if ($cateCnt >= 4) {
						$cateCnt = 0;
					}

					$cnt = 0;
					foreach ($affiliate->getCollection() as $data) {
						//	2件のみ表示
// 						if ($cnt >= 4) {
// 							break;
// 						}
						//	カテゴリ分割
						$arCategory = array();
						$arTemp = explode(":", $data["AFFILIATE_LIST_CATEGORY"]);
						if (count($arTemp) > 0) {
							foreach ($arTemp as $t) {
								if ($t != "") {
									$arCategory[$t] = $t;
								}
							}
						}

						if (count($arCategory) > 0) {
							foreach ($arCategory as $c) {
								if ("".$cat->value == $c) {
									$cnt++;
									$dataAr[] = $data;
								}
							}
						}
						else {
							//	カテゴリ未設定
							continue;
						}
					}
					
					
					
					if (count($dataAr) > 0) {
						$cateCnt++;
						$result[$cateCnt][]=$dataAr;
						$result[$cateCnt]['cat_name'] = $result[$cateCnt]['cat_name']?$result[$cateCnt]['cat_name']:$cat->name;
						$result[$cateCnt]['cat_value'] = $result[$cateCnt]['cat_value']?$result[$cateCnt]['cat_value']:$cat->value;
					}
            	}
            }
            ?>

            <?php foreach ($result as $k=>$af) {?>
                	<!--shop-->
                	<?php foreach ($af[0] as $kiss=>$av){?>
            <section class="clearfix">   
                	<article>
		<div id="gl_list">
			<div class="c_left">
                    	<div class="c_pic_shop">
	                    	<?php if ($av["AFFILIATE_PIC1"] != "") {?>
	                        	<?php if ($av["AFFILIATE_PIC2"] != "") {?>
	                    	<div class="image"><a href="affiliate-link<?php print $av["AFFILIATE_ID"]?>.html" class="blank"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $av["AFFILIATE_PIC1"]?>" width="234" height="60" onmouseout="<?php print URL_SLAKER_COMMON?>images/<?php print $av["AFFILIATE_PIC1"]?>" onmouseover="<?php print URL_SLAKER_COMMON?>images/<?php print $av["AFFILIATE_PIC2"]?>"></a></div>
	                        	<?php }else {?>
	                    	<div class="image"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $av["AFFILIATE_PIC1"]?>" width="234" height="60"></div>
	                        	<?php }?>
	                    	<?php }?>
			</div>
				<div class="c_point">
	                        <div class="line"><B>▼ポイントの取得方法</B></div>
	                        <ol>
	                        	<?php
	                        	for ($i=1; $i<=3; $i++) {
									$num = "";
									if ($i == 1)  $num = "①";
									if ($i == 2)  $num = "②";
									if ($i == 3)  $num = "③";
	
								?>
	                            	<?php if ($av["AFFILIATE_POINT_TERMS".$i] != "") {?>
		                                <li><?php print $num?><?php print $av["AFFILIATE_POINT_TERMS".$i]?>：
		                                <?php if ($av["AFFILIATE_POINT_FLG".$i] == 1) {?>
		                                <b><?php print $av["AFFILIATE_POINT_BACK".$i]?>ポイント</b></li>
		                                <?php }else {?>
		                                <b><?php print $av["AFFILIATE_POINT_BACK".$i]?>%</b></li>
		                                <?php }?>
	                                <?php }?>
	                            <?php }?>
	                        </ol>
	                        <div class="line"><B>▼ポイント付与時期の目安</B></div>
	                        <div class="bottom"><?php print $av["AFFILIATE_POINT_TIME1"]?>ヶ月</div>
	                    	</div>
				</div>
			<div class="c_right">
			<div class="gl_title"><img src="images/gl/rec_icon.jpg" width="55" height="33" alt="ココがおすすめ！"><span><?php print $av["AFFILIATE_CATCHCOPY"]?></span></div>
			<div class="gl_title"><a href="affiliate-link<?php print $av["AFFILIATE_ID"]?>.html" class="blank"><?php print $av["AFFILIATE_NAME"]?></a></div>
				<div class="shop_text">
	                        <B>【サービス紹介】</B>
	                        <?php print redirectForReturn($av["AFFILIATE_CONTENTS"])?><?php print redirectForReturn("&u1=".$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID")."\">")?></div>
			<div class="r"><a href="affiliate-link<?php print $av["AFFILIATE_ID"]?>.html" class="blank"><img src="images/affiliate/btn_shop.png" width="220" height="35" alt="このショップへ行く"></a></div>
			</div>
                    </article>
                    <?php }?>
            </section>
            <?php }?>
                </div>
        </section>

            <!--page-navigation-->
           <!-- <ul id="navigation">
            	<li class="prev"><a href="#">前の5件</a></li>
            	<li class="current">1</li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">6</a></li>
                <li><a href="#">7</a></li>
                <li><a href="#">8</a></li>
                <li><a href="#">9</a></li>
                <li><a href="#">10</a></li>
                <li class="next"><a href="#">次の5件</a></li>
            </ul>-->

                
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
