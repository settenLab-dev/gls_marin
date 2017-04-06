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
<?php require("includes/box/common/meta_new.php"); ?>
<title>グルメ情報 ｜ 地域限定レジャーサイトCOCOTOMO（ココトモ！）</title>
<meta name="keywords" content="グルメ,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_gourmet.php");?>
<!--/header-->
<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

<section>
    <div class="mainimage">
    	<img src="./images/gl/gourme_top.jpg" width="1323" height="324" alt="グルメ情報" /></a>
	</div>
</section>

<!-- /mainimage-->

<!-- Left side-->
		<div id="content-ln">
<?php require("includes/box/common/kuchikomi.php");?>	</div>
	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="content-r">
    
        <!--topics-->

        
        <!--pickup-->
        <!--list-->
	<img src="images/gl/title_g.jpg" width="1079" height="50" alt="グルメ情報一覧">
	<p>4件中1～4件を表示中</p>
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
            <article>
	<div id="gl_list">
		<div class="c_left">

			<div class="c_icon"><p1>NEW！</p1>
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

			<?php if (count($arArea) > 0) {?>
                    		<?php foreach ($arArea as $k=>$v) {?>
                    	    <p2><?php print $xmlArea->getNameByValue($k)?></p2>
                    	    <?php }?>
                    	<?php }?>
			<p3>居酒屋</p3></div>
			<div class="c_pic"><?php if ($data["GOURMET_PIC2"] != "") {?>
                        	<img id="dispImage<?php print $data["COMPANY_ID"]?>" src="<?php print URL_SLAKER_COMMON."images/".$data["GOURMET_PIC2"]?>" width="300" height="200" alt="<?php print $data["GOURMET_SHOPNAME"]?>">
                        	<?php }?></div>
		</div>
		<div class="c_right">
			<div class="gl_title"><img src="images/gl/rec_icon.jpg" width="55" height="33" alt="ココがおすすめ！"><span><?php print $data["GOURMET_CATCHCOPY"]?></span></div>
			<div class="gl_title"><a href="gourmet-detail<?php print $data["COMPANY_ID"]?>.html"><?php print $data["GOURMET_SHOPNAME"]?></a></div>
			 <?php if (count($arFeature) > 0) {?>
                        	<ul>
                        	<?php foreach ($arFeature as $k=>$v) {?>
                        	<img src="<?php print URL_PUBLIC.cmFeatureImageG($k)?>" alt="<?php print $xmlFeature->getNameByValue($k)?>">
                        	<?php }?>
                        </ul>
                        <?php }?>
			<div class="gl_text"><B>【編集部レポート】</B></br>
                            <?php print cmStrimWidth($data["GOURMET_STAFFPUSHU"], 0, 300, '…')?>
                            <?php if ($data["GOURMET_STAFFPUSHU"] != "") {?>
                            <div class="more"><a href="gourmet-detail<?php print $data["COMPANY_ID"]?>.html">続きを読む>></a></div>
                            <?php }?>
			</div>
			<div class="r"><a href="gourmet-detail<?php print $data["COMPANY_ID"]?>.html"><img src="images/gl/detail_btn.png" width="222" height="37" alt="詳細を見る"></a></div>
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
    