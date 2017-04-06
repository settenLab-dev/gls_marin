<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/groumet.php');
require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

$dbMaster = new dbMaster();

//	表示するバナー表示箇所ID
$bannerId = 1;

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");


$gourmet = new groumet($dbMaster);
$gourmetRecommend = new groumet($dbMaster);

$collection = new collection($dbMaster);
$collection->setPost();
$collection->setByKey($collection->getKeyValue(), "pageNum", 4);


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

$gourmet->selectList($collection);

//	特集
$collectionRecomm = new collection($dbMaster);
$collectionRecomm->setByKey($collectionRecomm->getKeyValue(), "GOURMET_RECOMM_FLG", 1);
$gourmetRecommend->selectList($collectionRecomm);


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
		'totalItems' => $gourmet->getMaxCount(),   // ページング対象データの総数
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '<span class="prev">前の4件</span>',
		'nextImg'=> '<span class="next">次の4件</span>',
		'extraVars'  =>$page_post
);

// print_r($pager_options);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();


$xmlCategory = new xml(XML_GOURMET_CATEGORY);
$xmlCategory->load();
if (!$xmlCategory->getXml()) {
	$gourmet->setErrorFirst("カテゴリデータの読み込みに失敗しました");
}

$xmlCategoryDetail = new xml(XML_GOURMET_CATEGORY_DETAIL);
$xmlCategoryDetail->load();
if (!$xmlCategoryDetail->getXml()) {
	$gourmet->setErrorFirst("詳細カテゴリデータの読み込みに失敗しました");
}

$xmlFeature = new xml(XML_FEATURE);
$xmlFeature->load();
if (!$xmlFeature->getXml()) {
	$gourmet->setErrorFirst("特徴データの読み込みに失敗しました");
}

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$gourmet->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$xmlRecomCategory = new xml(XML_RECOM_CATEGORY);
$xmlRecomCategory->load();
if (!$xmlRecomCategory->getXml()) {
	$groumet->setErrorFirst("お勧めカテゴリデータの読み込みに失敗しました");
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta.php"); ?>
<title>グルメ情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="グルメ,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
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
	<main id="list" class="gourmet">

    	<!--top-image-->
        <section id="top-image">
        	<h2><img src="images/category/list-gourmet-topimg-text.png" width="440" height="90" alt="ココモ。厳選！地元グルメ情報！"></h2>
            <div class="text">ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。ココにページの説明が入ります。</div>
        </section>

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>グルメ情報</span></li>
        </ul>

        <!--topics-->
        <?php /*
        <section id="topics" class="box">
        	<h2 class="titile"><img src="images/category/common-topics-title.png" width="218" height="29" alt="新着TOPICS"></h2>
            <ul>
            	<li class="clearfix">
                	<time>2013/06/06</time>今日は北海道直送の真ほっけが入荷！売切れ次第終了なので今すぐどうぞ！<span>→店舗名：<a href="#">店舗名</a></span>
                </li>
                <li class="clearfix">
                	<time>2013/06/06</time>今日は北海道直送の真ほっけが入荷！売切れ次第終了なので今すぐどうぞ！<span>→店舗名：<a href="#">店舗名</a></span>
                </li>
                <li class="clearfix">
                	<time>2013/06/06</time>今日は北海道直送の真ほっけが入荷！売切れ次第終了なので今すぐどうぞ！<span>→店舗名：<a href="#">店舗名</a></span>
                </li>
                <li class="clearfix">
                	<time>2013/06/06</time>今日は北海道直送の真ほっけが入荷！売切れ次第終了なので今すぐどうぞ！<span>→店舗名：<a href="#">店舗名</a></span>
                </li>
            </ul>
        </section>
        */?>

        <!--pickup-->
        <?php if ($gourmetRecommend->getCount() > 0) {?>
        <section id="pickup" class="box">
        	<h2 class="titile"><img src="images/category/list-pickup-title.png" width="145" height="29" alt="PICK UP"></h2>
            <ul>
            	<?php
            	$cnt = 0;
            	foreach ($gourmetRecommend->getCollection() as $bg) {
				?>
	            	<?php
	            	$cnt++;
	            	$cl = '';
	            	if ($cnt == 3) {
		            	$cl = 'class="right"';
		            	$cnt = 0;
					}
	            	if ($bg["BANNER_PIC_HOVER"] == "") {
					?>
					<li><a href="gourmet/<?=$xmlRecomCategory->getByKey($bg["GOURMET_RECOMM_URL"], "url")?>/<?php print $bg["COMPANY_ID"]?>/" class="blank <?php print $cl;?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?=$bg["GOURMET_RECOMM_PIC"]?>" alt="<?=$bg["GOURMET_RECOMM_TITLE"]?>" width="<?php print IMG_RECOMMEND_WIDTH?>" height="<?php print IMG_RECOMMEND_HEIGHT?>"  /></a></li>
					<?php }else{?>
					<li><a href="gourmet/<?=$xmlRecomCategory->getByKey($bg["GOURMET_RECOMM_URL"], "url")?>/<?php print $bg["COMPANY_ID"]?>/" class="blank <?php print $cl;?>"><img src="<?php print URL_SLAKER_COMMON?>images/<?=$bg["GOURMET_RECOMM_PIC"]?>" onmouseout="<?php print URL_SLAKER_COMMON?>images/<?=$bg["GOURMET_RECOMM_PIC"]?>" onmouseover="<?php print URL_SLAKER_COMMON?>images/<?=$bg["GOURMET_RECOMM_PIC"]?>" alt="<?=$bg["BANNER_ALT"]?>"  width="<?php print IMG_RECOMMEND_WIDTH?>" height="<?php print IMG_RECOMMEND_HEIGHT?>" /></a></li>
					<?php }?>
            	<?php }?>
            </ul>
        </section>
            <?php }?>

        <!--list-->
        <section id="shoplist" class="box clearfix">
        	<h2 class="title"><img src="images/category/list-gourmet-title.png" width="145" height="29" alt="グルメ情報一覧"></h2>
        	<?php $scope = $pager->getOffsetByPageId()?>
            <div class="result">検索結果：<b><?=$gourmet->getMaxCount()?>件</b>のグルメ情報のうち <b><?php print $scope['0']?></b>件〜<b><?php print $scope['1']?></b>件を表示</div>

            <div class="clearfix">
            <!--shop-->
            <?php
            if ($gourmet->getCount() > 0) {
				$flgLeft = true;
				foreach ($gourmet->getCollection() as $data) {
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
					$arTemp = explode(":", $data["GOURMET_LIST_FEATURE"]);
					if (count($arTemp) > 0) {
						foreach ($arTemp as $fe) {
							if ($fe != "") {
								$arFeature[$fe] = $fe;
							}
						}
					}
            ?>
            <?php if (!$flgLeft) {?>
            <div class="clearfix">
            <?php }?>
            <article <?php print $classLeft;?>>
            	<header class="clearfix">
                    <div class="left">
                        <h3><?php print $data["GOURMET_CATCHCOPY"]?></h3>
                        <?php if (count($arFeature) > 0) {?>
                        <ul class="icon">
                        	<?php foreach ($arFeature as $k=>$v) {?>
                            <li><img src="<?php print URL_PUBLIC.cmFeatureImageG($k)?>" width="44" height="20" alt="<?php print $xmlFeature->getNameByValue($k)?>"></li>
                            <?php }?>
                        </ul>
                        <?php }?>
                    </div>

                    <?php
                    $arArea = array();
                    $arTemp = explode(":", $data["GOURMET_LIST_AREA"]);
                    if (count($arTemp) > 0) {
                    	foreach ($arTemp as $a) {
                    		if ($a != "") {
                    			$arArea[$a] = $a;
                    		}
                    	}
                    }

                    $arCategory = array();
                    $arTemp = explode(":", $data["GOURMET_LIST_CATEGORY"]);
                    if (count($arTemp) > 0) {
                    	foreach ($arTemp as $ca) {
                    		if ($ca != "") {
                    			$arCategory[$ca] = $ca;
                    		}
                    	}
                    }
                    ?>
                    <ul class="right">
                    	 <?php if (count($arArea) > 0) {?>
                        	<?php foreach ($arArea as $k=>$v) {?>
                            <li><?php print $xmlArea->getNameByValue($k)?></li>
                            <?php }?>
                        <?php }?>
                        <?php /*
                    	 <?php if (count($arCategory) > 0) {?>
                        	<?php foreach ($arCategory as $k=>$v) {?>
                            <li><?php print $xmlCategory->getNameByValue($k)?></li>
                            <?php }?>
                        <?php }?>
                        */?>
                    </ul>
                </header>
                <div class="inner">
                    <section class="clearfix">
                        <h4><?php print $data["GOURMET_SHOPNAME"]?></h4>
                        <div class="image">
                        	<?php if ($data["GOURMET_PIC2"] != "") {?>
                            <img id="dispImage<?php print $data["COMPANY_ID"]?>" src="<?php print URL_SLAKER_COMMON."images/".$data["GOURMET_PIC2"]?>" width="158" height="158" alt="<?php print $data["GOURMET_SHOPNAME"]?>">
                            <?php }?>
                            <ul>
                            	<?php
                            	for ($i=3; $i<=5; $i++) {
									if ($data["GOURMET_PIC".$i] == "") {
										continue;
									}
                            	?>
                                <li><a href="javascript:void(0);" id="sImage<?php print $data["COMPANY_ID"]?>" onclick="$('#dispImage<?php print $data["COMPANY_ID"]?>').attr({'src':'<?php print URL_SLAKER_COMMON."images/".$data["GOURMET_PIC".$i]?>'})"><img src="<?php print URL_SLAKER_COMMON."images/".$data["GOURMET_PIC".$i]?>"  alt="<?php print $data["GOURMET_SHOPNAME"]?>" width="49" height="49"></a></li>
                            	<?php }?>
                            </ul>
                        </div>
                        <div class="text">
                            <strong>【編集部リポート】</strong>
                            <?php print cmStrimWidth($data["GOURMET_STAFFPUSHU"], 0, 200, '…')?>
                            <?php if ($data["GOURMET_STAFFPUSHU"] != "") {?>
                            <div class="more"><a href="gourmet-detail<?php print $data["COMPANY_ID"]?>.html">続きを読む>></a></div>
                            <?php }?>
                        </div>
                    </section>
                    <a href="gourmet-detail<?php print $data["COMPANY_ID"]?>.html" class="btn">詳しい情報とクーポンを見る</a>
                </div>
            </article>
            <?php if ($flgLeft) {?>
            </div>
            <?php }?>
            <?php
            	}
            }
            ?>
            <?php if (!$flgLeft) {?>
            </div>
            <?php }?>
            </div>

            <!--page-navigation-->
			<?php if ($navi["back"] != "" or $navi["next"] != "") {?>
			<div class="pagenavi">
				<p>
				<?php if ($navi["back"] != "") {?>
					<span class="btn"><?=$navi["back"]?></span>
				<?php }?>
					<?=$navi["pages"]?>
				<?php if ($navi["next"] != "") {?>
					<span class="btn"><?=$navi["next"]?></span>
				<?php }?>
				</p>
			</div>
			<?php }?>
			<?php /*
            <ul id="navigation">
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
            </ul>
            */?>

        </section>

        <ul id="social">
            <li><a href="#"><img src="images/common/common-bottom-twitter.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mixi.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-gree.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-fb.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mail.png"></a></li>
        </ul>

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
