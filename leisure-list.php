<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/activity.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');

require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

$dbMaster = new dbMaster();

//	表示するバナー表示箇所ID
$bannerId = 1;

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");


$activity = new activity($dbMaster);
$activityRecommend = new activity($dbMaster);

$collection = new collection($dbMaster);
$collection->setPost();
$collection->setByKey($collection->getKeyValue(), "pageNum", 10);


//	ページャー
$perpage = $collection->getByKey($collection->getKeyValue(), "pageNum");
$page = $collection->getByKey($collection->getKeyValue(), "pageID");
$currentPage = 0;
if (!cmCheckNull($page) or !cmCheckPtn($page, CHK_PTN_NUM) or $page <= 0) {
	$currentPage = 0;
}
else {
	$currentPage = $page-1;
}
$limit = ($currentPage*$perpage).",".$perpage;
$collection->setByKey($collection->getKeyValue(), "limit", $limit);

$activity->selectList($collection);

//	特集
$collectionRecomm = new collection($dbMaster);
$collectionRecomm->setByKey($collectionRecomm->getKeyValue(), "ACTIVITY_RECOMM_FLG", 1);
$activityRecommend->selectList($collectionRecomm);


$page_post = array();
if ($_POST) {
	foreach ($collection->getCollectionByKey("") as $k=>$v) {
		if ($k == "search") {
			continue;
		}
		$page_post[$k] = $v;
	}
}

//	ページャ取得
$pager_options = array(
		'mode'       => 'Jumping', // 表示タイプ(Jumping/Sliding)
		'perPage'    => $perpage,        // 一ページ内で表示する件数
		'totalItems' => $activity->getMaxCount(),   // ページング対象データの総数
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '<span class="prev">前のページへ</span>',
		'nextImg'=> '<span class="next">次のページへ</span>',
		'extraVars'  =>$page_post
);

// print_r($pager_options);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();


$xmlCategory = new xml(XML_ACTIVITY_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$activity->setErrorFirst("カテゴリデータの読み込みに失敗しました");
}

$xmlCategoryDetail = new xml(XML_ACTIVITY_CATEGORY_DETAIL);
$xmlCategoryDetail->load();
if (!$xmlCategoryDetail->getXml()) {
	$activity->setErrorFirst("詳細カテゴリデータの読み込みに失敗しました");
}

$xmlFeature = new xml(XML_FEATURE);
$xmlFeature->load();
if (!$xmlFeature->getXml()) {
	$activity->setErrorFirst("特徴データの読み込みに失敗しました");
}

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$activity->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$xmlRecomCategory = new xml(XML_RECOM_CATEGORY);
$xmlRecomCategory->load();
if (!$xmlRecomCategory->getXml()) {
	$activity->setErrorFirst("お勧めカテゴリデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<link rel="stylesheet" href="/css/style_category.css" type="text/css" media="screen" />

<title>おでかけレジャー情報 ｜ 地域限定！お得なレジャーとグルメの専門サイト「ココトモ」</title>
<meta name="keywords" content="レジャー,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top" style="background:none;border-top:none;">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->
<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

<section>
    <div class="mainimage">
    	<img src="./images/index2016/img_leisure.jpg" width="1323" height="250" alt="レジャー情報" /></a>
    </div>

</section>

<!-- /mainimage-->

<!-- Left side-->
		<div id="content-ln">
<?php require("includes/box/common/kuchikomi2016.php");?>
			<aside class="banerList">

				<ul>
					<li style="margin-bottom: 10px; margin-top:10px;"><a href="/n_coupon.html" target="_blank"><img src="http://cocotomo.net/images/coupon/top_image.png" width="220" height="70" alt="ココトモのクーポン！ココポン" /></a></li>
					<li style="margin-bottom: 10px;"><a href="/gourmet-list.html" target="_blank"><img src="http://cocotomo.net/images/gl/gourme_top.jpg" width="220" height="70" alt="グルメ情報" /></a></li>
					<li style="margin-bottom: 10px;"><a href="/n_hotel.html" target="_blank"><img src="http://cocotomo.net/images/hotel/hotel_top.jpg" width="220" height="70" alt="レジャー予約" /></a></li>
				</ul>
			</aside>


		</div>
	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->

    
        <!--topics-->

        
        <!--pickup-->
        <!--list-->
	<main id="content-r">

<!--
	<h2 class="title2016" style="margin-bottom:15px;">Pick UP！</h2>

		<div class="contents_box cf">
			<div class="pickup cf" style="margin-bottom:20px;">

			<?php // require("leisure_pickup.php");?>
		</div>

	<h2 class="title2016" style="margin-bottom:15px;">ファミリーにおすすめ！</h2>
			<div class="contents_box cf">
				<ul class="cate_l">
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				</ul>
				<ul class="cate_l">
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				</ul>
			</div>

	<h2 class="title2016" style="margin-bottom:15px;">記念日におすすめ！</h2>
			<div class="contents_box cf">
				<ul class="cate_l">
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				</ul>
				<ul class="cate_l">
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				<li><a href="/tour-pickup.html"><img src="/images/opnesale/top-banner3-3.jpg" alt="日帰りツアー特集" /></a></li>
				<li><a href="/dolphin.html"><img src="/images/dolphin/dolphin_banner.jpg" alt="イルカと遊ぼう！" /></a></li>
				</ul>
			</div>
-->

	<h2 class="title2016" style="margin-bottom:15px;">レジャー情報一覧</h2>

	<?php $scope = $pager->getOffsetByPageId()?>
	<p><b><?php print $activity->getMaxCount()?></b>件中<b><?php print $scope['0']?>～<?php print $scope['1']?></b>件を表示中</p>


		<?php if ($navi["back"] != "" or $navi["next"] != "") {?>
        <ul class="navigation-se">
        	<?php if ($navi["back"] != "") {?>
            <li class="prev"><?=$navi["back"]?> | </li>
            <?php }?>
            <?=$navi["pages"]?>
            <!--<li class="current">1 | </li>
            <li><a href="#">2</a> | </li>
            <li><a href="#">3</a> | </li>
            <li><a href="#">4</a> | </li>
            <li><a href="#">5</a> | </li>
            <li><a href="#">6</a> | </li>
            <li><a href="#">7</a> | </li>
            <li><a href="#">8</a> | </li>
            <li><a href="#">9</a> | </li>
            <li><a href="#">10</a> | </li>-->
            <?php if ($navi["next"] != "") {?>
            <li class="next"><?=$navi["next"]?></li>
            <?php }?>
        </ul>
		<?php }?>

            <!--shop-->
            <?php
            if ($activity->getCount() > 0) {
				$flgLeft = true;
				foreach ($activity->getCollection() as $data) {
					$classLeft = '';
					if ($flgLeft == true) {
						$classLeft = 'class="leftbox"';
						$flgLeft = false;
					}
					else {
						$classLeft = 'class="rightbox"';
						$flgLeft = true;
					}

					$arFeature = array();
					$arTemp = explode(":", $data["ACTIVITY_LIST_FEATURE"]);
					if (count($arTemp) > 0) {
						foreach ($arTemp as $fe) {
							if ($fe != "") {
								$arFeature[$fe] = $fe;
							}
						}
					}
            ?>
            <article>
	<div id="gl_list">
		<div class="c_left">

			<div class="c_icon"><p1>NEW！</p1>
                    <?php
                    $arArea = array();
                    $arTemp = explode(":", $data["ACTIVITY_LIST_AREA"]);
                    if (count($arTemp) > 0) {
                    	foreach ($arTemp as $a) {
                    		if ($a != "") {
                    			$arArea[$a] = $a;
                    		}
                    	}
                    }

                    $arCategory = array();
                    $arTemp = explode(":", $data["ACTIVITY_LIST_CATEGORY"]);
                    if (count($arTemp) > 0) {
                    	foreach ($arTemp as $ca) {
                    		if ($ca != "") {
                    			$arCategory[$ca] = $ca;
                    		}
                    	}
                    }
                    ?>

			<?php if (count($arArea) > 0) {?>
                    		<?php foreach ($arArea as $k=>$v) {?>
                    	    <p2><?php print $xmlArea->getNameByValue($k)?></p2>
                    	    <?php }?>
                    	<?php }?>
			<!--<p3>居酒屋</p3>--></div>
			<div class="c_pic"><?php if ($data["ACTIVITY_PIC2"] != "") {?>
                        	<img id="dispImage<?php print $data["COMPANY_ID"]?>" src="<?php print URL_SLAKER_COMMON."images/".$data["ACTIVITY_PIC2"]?>" width="300" height="200" alt="<?php print $data["ACTIVITY_SHOPNAME"]?>">
                        	<?php }?></div>
		</div>
		<div class="c_right">
			<div class="gl_title"><img src="images/gl/rec_icon.jpg" width="55" height="33" alt="ココがおすすめ！"><span><?php print $data["ACTIVITY_CATCHCOPY"]?></span></div>
			<div class="gl_title"><a href="leisure-detail<?php print $data["COMPANY_ID"]?>.html"><?php print $data["ACTIVITY_SHOPNAME"]?></a></div>
			 <?php if (count($arFeature) > 0) {?>
                        	<ul>
                        	<?php foreach ($arFeature as $k=>$v) {?>
                        	<img src="<?php print URL_PUBLIC.cmFeatureImageA($k)?>" alt="<?php print $xmlFeature->getNameByValue($k)?>">
                        	<?php }?>
                        </ul>
                        <?php }?>
			<div class="gl_text"><B>【編集部レポート】</B></br>
                            <?php print cmStrimWidth($data["ACTIVITY_STAFFPUSHU"], 0, 300, '…')?>
                            <?php if ($data["ACTIVITY_STAFFPUSHU"] != "") {?>
                            <div class="more"><a href="leisure-detail<?php print $data["COMPANY_ID"]?>.html">続きを読む>></a></div>
                            <?php }?>
			</div>
			<div class="r"><a href="leisure-detail<?php print $data["COMPANY_ID"]?>.html"><img src="images/gl/detail_btn.png" width="222" height="37" alt="詳細を見る"></a></div>
		</div>
                                 
                </div>
            </article>
			<?php
				}
			}
			?>
			
            
            <!--page-navigation-->
<!--            <ul id="navigation">
            	<li class="prev"><a href="#">前の4件</a></li>
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
                <li class="next"><a href="#">次の4件</a></li>
            </ul>-->
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
    