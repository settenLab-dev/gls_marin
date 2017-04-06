<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');

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
<?php require("includes/box/common/meta_new1.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title><?php print SITE_PUBLIC_NAME?></title>
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
<?php require("includes/box/common/header_job.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->

<!-- InstanceEndEditable -->

<!--Content-->
<div id="content" class="clearfix" style="padding:0;">

<section>
    <div class="mainimage">
<img src="./images/job/job_top2.jpg" width="1323" height="324" alt="お仕事情報" /></a></li>
	</div>
</section>

<!-- /mainimage-->

<!-- Left side-->
		<div id="content-ln">
<?php require("includes/box/common/job_data.php");?>
</br></br>
			<aside class="banerList">
				<ul>
					<li style="margin-bottom:2px;"><a href="https:cocotomo.net/contact-form.html"><img src="./images/job/job_contact.jpg" width="222" height="119" alt="職業相談をご希望の方はコチラへ" /></a></li>
					<li><a href="http://www.regency-inc.com/kyushu/" target="blank"><img src="./images/job/banner_regency.jpg" width="219" height="68" alt="日払いバイト・人材派遣のリージェンシー" /></a></li>
					<!--<li><a href=""><img src="./images/job/banner_img.jpg" width="219" height="95" alt="バナー掲載スペースイメージ" /></a></li>
					<li><a href=""><img src="./images/job/banner_img.jpg" width="219" height="95" alt="バナー掲載スペースイメージ" /></a></li>
					<li><a href=""><img src="./images/job/banner_img.jpg" width="219" height="95" alt="バナー掲載スペースイメージ" /></a></li>
					-->
				</ul>
			</aside>
		</div>
<!-- /Left side-->

<!--main-->
		<main id="content-r">


	<img src="/images/hotel/pickup_c.png" width="1085" height="44" alt="ピックアップ" />
				<form name="frmRecommend1" method="post" action="job-search.html"><?php print $inputs->hidden("company[1]", "")?></form>
				<form name="frmRecommend2" method="post" action="job-search.html"><?php print $inputs->hidden("kind[9]", "")?></form>
				<form name="frmRecommend3" method="post" action="job-search.html"><?php print $inputs->hidden("season[1]", "")?></form>
				<form name="frmRecommend4" method="post" action="job-search.html"><?php print $inputs->hidden("kind[6]", ""); print $inputs->hidden("kind[7]", ""); print $inputs->hidden("company[1]", ""); print $inputs->hidden("company[2]", "");?></form>
				<form name="frmRecommend5" method="post" action="job-search.html"><?php print $inputs->hidden("kind[1]", ""); print $inputs->hidden("company[3]", "");?></form>

		<div class="contents_box cf">
			<div class="toku">
				<a href="javascript:void(0);" onclick="document.frmRecommend1.submit();"><img src="/images/job/banner_sample.jpg" width="399" height="236" alt="人気のホテルで働こう！！" /></a>
			</div>
			<div class="toku_l">
				<ul class="toku">
				<li><a href="javascript:void(0);" onclick="document.frmRecommend2.submit();"><img src="./images/job/banner1.jpg" width="261" height="94" alt="未経験歓迎♪簡単軽作業" /></br>▼未経験OK！誰でもできる簡単作業♪</a></br></br></li>
				<li><a href="javascript:void(0);" onclick="document.frmRecommend4.submit();"><img src="./images/job/banner3.jpg" width="261" height="94" alt="サービス業・飲食店のお仕事特集" /></br>▼接客好き・料理好き大歓迎！</a></li>
				</ul>
				</div>
			<div class="toku_r">
				<ul class="toku">
				<li><a href="javascript:void(0);" onclick="document.frmRecommend3.submit();"><img src="./images/job/banner2.jpg" width="261" height="94" alt="短期バイト！1日～のお仕事特集" /></br>▼ライフスタイルに合わせてお仕事！</a></br></br></li>
				<li><a href="javascript:void(0);" onclick="document.frmRecommend5.submit();"><img src="./images/job/banner4.jpg" width="261" height="94" alt="コールセンターのお仕事特集" /></br>▼人気の定番！コールセンター！</a></li>
				</ul>
			</div>
		</div>


			<form name="frmCategory1" method="post" action="job-search.html"><?php print $inputs->hidden("employ[1]", "")?></form>
			<form name="frmCategory2" method="post" action="job-search.html"><?php print $inputs->hidden("employ[2]", "")?></form>
			<form name="frmCategory3" method="post" action="job-search.html"><?php print $inputs->hidden("employ[3]", "")?></form>

			<section class="job_box1">
				<h2><img src="./images/job/title_job_cate3.jpg" width="207" height="32" alt="雇用形態から探す" /></h2>
				<div class="cate1 cf">
					<ul class="w150e">
						   <li><a href="javascript: void(0);" onclick="document.frmCategory1.submit();">正社員</a></li>
					</ul>
					<ul class="w150e">
	  			                   <li><a href="javascript: void(0);" onclick="document.frmCategory2.submit();">契約・パート・アルバイト</a></li>
					</ul>
					<ul class="w150e">
	        			           <li><a href="javascript: void(0);" onclick="document.frmCategory3.submit();">派遣社員</a></li>
					</ul>
				</div>
			</section>

			<form name="frmCompany1" method="post" action="job-search.html"><?php print $inputs->hidden("company[1]", "")?></form>
			<form name="frmCompany2" method="post" action="job-search.html"><?php print $inputs->hidden("company[2]", "")?></form>
			<form name="frmCompany3" method="post" action="job-search.html"><?php print $inputs->hidden("company[3]", "")?></form>
			<form name="frmCompany4" method="post" action="job-search.html"><?php print $inputs->hidden("company[4]", "")?></form>
			<form name="frmCompany5" method="post" action="job-search.html"><?php print $inputs->hidden("company[5]", "")?></form>
			<form name="frmCompany6" method="post" action="job-search.html"><?php print $inputs->hidden("company[6]", "")?></form>
			<form name="frmCompany7" method="post" action="job-search.html"><?php print $inputs->hidden("company[7]", "")?></form>
			<form name="frmCompany8" method="post" action="job-search.html"><?php print $inputs->hidden("company[8]", "")?></form>
			<form name="frmCompany9" method="post" action="job-search.html"><?php print $inputs->hidden("company[9]", "")?></form>
			<form name="frmCompany10" method="post" action="job-search.html"><?php print $inputs->hidden("company[10]", "")?></form>
			<form name="frmCompany11" method="post" action="job-search.html"><?php print $inputs->hidden("company[11]", "")?></form>


			<section class="job_box1">
				<h2><img src="./images/job/title_job_cate1.jpg" width="164" height="31" alt="業種から探す" /></h2>
				<div class="cate1 cf">
					<ul class="w150s">
						    <li><a href="javascript: void(0);" onclick="document.frmCompany1.submit();">サービス・レジャー</a></li>
				                    <li><a href="javascript: void(0);" onclick="document.frmCompany2.submit();">流通・小売・飲食</a></li>
	                			    <li><a href="javascript: void(0);" onclick="document.frmCompany3.submit();">IT・通信・インターネット</a></li>
					</ul>
					<ul class="w150">
				                    <li><a href="javascript: void(0);" onclick="document.frmCompany4.submit();">メーカー</a></li>
						    <li><a href="javascript: void(0);" onclick="document.frmCompany5.submit();">商社</a></li>
						    <li><a href="javascript: void(0);" onclick="document.frmCompany6.submit();">金融・保険</a></li>
					</ul>
					<ul class="w150e">
				                    <li><a href="javascript: void(0);" onclick="document.frmCompany7.submit();">マスコミ・広告・デザイン</a></li>
	                			    <li><a href="javascript: void(0);" onclick="document.frmCompany8.submit();">コンサルティング</a></li>
				                    <li><a href="javascript: void(0);" onclick="document.frmCompany9.submit();">不動産・建設・設備</a></li>
					</ul>
					<ul class="w150e">
						    <li><a href="javascript: void(0);" onclick="document.frmCompany10.submit();">運輸・交通・流通・倉庫</a></li>
	                			    <li><a href="javascript: void(0);" onclick="document.frmCompany11.submit();">環境・エネルギー</a></li>
					</ul>
				</div>
			</section>

			<form name="frmKind1" method="post" action="job-search.html"><?php print $inputs->hidden("kind[1]", "")?></form>
			<form name="frmKind2" method="post" action="job-search.html"><?php print $inputs->hidden("kind[2]", "")?></form>
			<form name="frmKind3" method="post" action="job-search.html"><?php print $inputs->hidden("kind[3]", "")?></form>
			<form name="frmKind4" method="post" action="job-search.html"><?php print $inputs->hidden("kind[4]", "")?></form>
			<form name="frmKind5" method="post" action="job-search.html"><?php print $inputs->hidden("kind[5]", "")?></form>
			<form name="frmKind6" method="post" action="job-search.html"><?php print $inputs->hidden("kind[6]", "")?></form>
			<form name="frmKind7" method="post" action="job-search.html"><?php print $inputs->hidden("kind[7]", "")?></form>
			<form name="frmKind8" method="post" action="job-search.html"><?php print $inputs->hidden("kind[8]", "")?></form>
			<form name="frmKind9" method="post" action="job-search.html"><?php print $inputs->hidden("kind[9]", "")?></form>
			<form name="frmKind10" method="post" action="job-search.html"><?php print $inputs->hidden("kind[10]", "")?></form>
			<form name="frmKind11" method="post" action="job-search.html"><?php print $inputs->hidden("kind[11]", "")?></form>
			<form name="frmKind12" method="post" action="job-search.html"><?php print $inputs->hidden("kind[12]", "")?></form>

			<section class="job_box1">
				<h2><img src="./images/job/title_job_cate2.jpg" width="164" height="31" alt="職種から探す" /></h2>
				<div class="cate1 cf">
					<ul class="w150s">
						    <li><a href="javascript: void(0);" onclick="document.frmKind1.submit();">オフィスワーク・事務</a></li>
	                			    <li><a href="javascript: void(0);" onclick="document.frmKind2.submit();">営業</a></li>
				                    <li><a href="javascript: void(0);" onclick="document.frmKind3.submit();">医療・介護・福祉</a></li>
					</ul>
					<ul class="w150">
	                			    <li><a href="javascript: void(0);" onclick="document.frmKind4.submit();">教育・保育</a></li>
						    <li><a href="javascript: void(0);" onclick="document.frmKind5.submit();">IT・クリエイティブ</a></li>
						    <li><a href="javascript: void(0);" onclick="document.frmKind6.submit();">フード・食品製造</a></li>
					</ul>
					<ul class="w150e">
				                    <li><a href="javascript: void(0);" onclick="document.frmKind7.submit();">販売・サービス</a></li>
	                			    <li><a href="javascript: void(0);" onclick="document.frmKind8.submit();">専門職・管理職</a></li>
				                    <li><a href="javascript: void(0);" onclick="document.frmKind9.submit();">軽作業</a></li>
					</ul>
					<ul class="w150e">
						    <li><a href="javascript: void(0);" onclick="document.frmKind10.submit();">製造・建設作業</a></li>
	                			    <li><a href="javascript: void(0);" onclick="document.frmKind11.submit();">ドライバー・物流</a></li>
				                    <li><a href="javascript: void(0);" onclick="document.frmKind12.submit();">清掃・ビル施設管理・警備</a></li>
					</ul>
				</div>
			</section>


				<br/>
				<br/>
        <!--日付・人数から検索-->
	<img src="/images/job/title_job_area.jpg" width="1071" height="43" alt="エリアから探す" /></br></br>
	<!--エリアform-->
            	<form name="frm20" method="post" action="job-search.html"><?php print $inputs->hidden("area", 20); print $inputs->hidden("undecide_sch", 1)?></form>
            	<form name="frm18" method="post" action="job-search.html"><?php print $inputs->hidden("area", 18); print $inputs->hidden("undecide_sch", 1)?></form>
            	<form name="frm19" method="post" action="job-search.html"><?php print $inputs->hidden("area", 19); print $inputs->hidden("undecide_sch", 1)?></form>
            	<form name="frm22" method="post" action="job-search.html"><?php print $inputs->hidden("area", 22); print $inputs->hidden("undecide_sch", 1)?></form>
	<!--テキストform-->
		<form name="frmRecommend6" method="post" action="job-search.html"><?php print $inputs->hidden("recommend", 6); print $inputs->hidden("undecide_sch", 1);?></form>
		<form name="frmRecommend7" method="post" action="job-search.html"><?php print $inputs->hidden("recommend", 7); print $inputs->hidden("undecide_sch", 1);?></form>
		<form name="frmRecommend8" method="post" action="job-search.html"><?php print $inputs->hidden("recommend", 8); print $inputs->hidden("undecide_sch", 1);?></form>

	<!--<div id="area_box">
		<ul class="a_search">
			<li><a href="javascript: void(0);" onclick="document.frm20.submit();"><img src="./images/hotel/hotel4.png" width="233" height="76" alt="那覇・南部" /></a>
			</li>
			<li><a href="javascript: void(0);" onclick="document.frm18.submit();"><img src="./images/hotel/hotel5.png" width="233" height="76" alt="中部" /></a>
			</li>
			<li><a href="javascript: void(0);" onclick="document.frm19.submit();"><img src="./images/hotel/hotel6.png" width="234" height="78" alt="北部" /></a>
			</li>
			<li><a href="javascript: void(0);" onclick="document.frm22.submit();"><img src="./images/hotel/hotel7.png" width="233" height="76" alt="那覇・南部" /></a>
			</li>
		</ul>
	</div>-->


	<!--<img src="./images/job/title_job_area.jpg" width="184" height="31" alt="地図・日付・人数から探す" />-->


        <!--地図から検索-->
			<section class="map">
        	<h2><img src="./images/front/search-title02.jpg" width="518" height="30" alt="地図から検索" /></h2>

        	<form name="frm9" method="post" action="job-search.html"><?php print $inputs->hidden("area[3]", "")?></form>
            	<form name="frm8" method="post" action="job-search.html"><?php print $inputs->hidden("area[3]", "")?></form>
            	<form name="frm7" method="post" action="job-search.html"><?php print $inputs->hidden("area[3]", "")?></form>
            	<form name="frm6" method="post" action="job-search.html"><?php print $inputs->hidden("area[3]", "")?></form>
            	<form name="frm21" method="post" action="job-search.html"><?php print $inputs->hidden("area[2]", "")?></form>
            	<form name="frm5" method="post" action="job-search.html"><?php print $inputs->hidden("area[2]", "")?></form>
            	<form name="frm4" method="post" action="job-search.html"><?php print $inputs->hidden("area[2]", "")?></form>
            	<form name="frm2" method="post" action="job-search.html"><?php print $inputs->hidden("area[1]", "")?></form>
            	<form name="frm3" method="post" action="job-search.html"><?php print $inputs->hidden("area[1]", "")?></form>
            	<form name="frm10" method="post" action="job-search.html"><?php print $inputs->hidden("area[4]", "")?></form>
            	<form name="frm11" method="post" action="job-search.html"><?php print $inputs->hidden("area[4]", "")?></form>
            	<form name="frm12" method="post" action="job-search.html"><?php print $inputs->hidden("area[4]", "")?></form>
            	<form name="frm13" method="post" action="job-search.html"><?php print $inputs->hidden("area[4]", "")?></form>
            	<form name="frm14" method="post" action="job-search.html"><?php print $inputs->hidden("area[4]", "")?></form>
            	<form name="frm15" method="post" action="job-search.html"><?php print $inputs->hidden("area[4]", "")?></form>

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
                    <area class="map-13" shape="poly" coords="458,138,446,140,424,164,423,169,407,187,411,221,414,229,416,242,422,243,433,232,435,215,435,177,447,164" href="javascript: void(0);" onclick="document.frm15.submit();">
                    <area class="map-14" shape="poly" coords="253,211,239,222,235,239,236,250,237,259,237,270,244,272,253,262,258,260,263,253,281,268,289,288,308,267,310,228,296,239,288,244,289,248,282,252,273,248,270,235,256,224,260,219" href="javascript: void(0);" onclick="document.frm4.submit();">
                    <area class="map-15" shape="poly" coords="223,273,229,274,230,281,228,285,217,286,206,285,202,284,200,279,205,276,211,274,219,273" href="javascript: void(0);" onclick="document.frm21.submit();">
                </map>
          </div>

            <div id="map-01" class="areabox">
                <div class="inner">
                    <div class="title">■石垣島（<!--<?php print $hotel10->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-02" class="areabox">
                <div class="inner">
                    <div class="title">■八重山諸島（<!--<?php print $hotel11->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-03" class="areabox">
                <div class="inner">
                    <div class="title">■久米島（<!--<?php print $hotel13->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-04" class="areabox">
                <div class="inner">
                    <div class="title">■慶良間諸島（<!--<?php print $hotel14->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-05" class="areabox">
                <div class="inner">
                    <div class="title">■国頭村・その他（<!--<?php print $hotel9->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-06" class="areabox">
                <div class="inner">
                    <div class="title">■本部・今帰仁（<!--<?php print $hotel8->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-07" class="areabox">
                <div class="inner">
                    <div class="title">■名護市（<!--<?php print $hotel7->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-08" class="areabox">
                <div class="inner">
                    <div class="title">■恩納村（<!--<?php print $hotel6->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-15" class="areabox">
                <div class="inner">
                    <div class="title">■宜野湾市（<!--<?php print $hotel21->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-09" class="areabox">
                <div class="inner">
                    <div class="title">■北谷町・読谷村（<!--<?php print $hotel5->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-10" class="areabox">
                <div class="inner">
                    <div class="title">■那覇市（<!--<?php print $hotel2->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-11" class="areabox">
                <div class="inner">
                    <div class="title">■本島南部（<!--<?php print $hotel3->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-12" class="areabox">
                <div class="inner">
                    <div class="title">■宮古島（<!--<?php print $hotel12->getCount()?>-->）</div>
                </div>
            </div>
            <div id="map-13" class="areabox">
                <div class="inner">
                    <div class="title">■島尻郡（<!--<?php print $hotel15->getCount()?>--）</div>
                </div>
            </div>
            <div id="map-14" class="areabox">
                <div class="inner">
                    <div class="title">■北中城村・沖縄市・うるま市（<!--<?php print $hotel4->getCount()?>-->）</div>
                </div>
            </div>

        </section>
<!-- /地図から検索-->


<!--キーワード検索-->
		<!--<section class="search2col cf">
		<section class="l-sp">
			<h2><img src="./images/front/search-title03.jpg" width="254" height="29" alt="キーワード検索" /></h2>
			<form method="post" action="job-search.html" id="frmFree" name="frmFree">
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

	<!--	<section class="search">
		<section>
			<h2><img src="./images/front/search-title03-1.jpg" width="518" height="30" alt="キーワード検索" /></h2>
			<form method="post" action="facility-search.html" id="frmFree" name="frmFree">
			<div>
				<?php print $inputs->text("free", $collection->getByKey($collection->getKeyValue(), "free") ,"imeActive"); print $inputs->hidden("undecide_sch", 1);?>
				<input type="button" value="" id="" name="" onclick="document.frmFree.submit();">
			</div>
			</form>
			</section>
		</section>-->



		<section class="job_box3">
				<!--<h2><img src="./images/front/title-area.jpg" width="180" height="20" alt="エリアから選ぶ" /></h2>-->
				<div class="cate3 cf">
					<ul class="w150s">
						<li><a href="javascript: void(0);" onclick="document.frm2.submit();">那覇・南部エリア</a></li>
						<li><a href="javascript: void(0);" onclick="document.frm4.submit();">中部エリア</a></li>
					</ul>
					<ul class="w150">
						<li><a href="javascript: void(0);" onclick="document.frm9.submit();">北部エリア</a></li>
	                    <li><a href="javascript: void(0);" onclick="document.frm11.submit();">その他離島エリア</a></li>
					</ul>
					<!--<ul class="w150e">
					</ul>-->
				</div>
			</section>
<!--
		<div class="job_banner">
			<a href=""><img src="./images/job/job_kengai.jpg" width="522" height="153" alt="県外のお仕事はコチラから！"></a>
		</div>
-->
<!-- /エリアから検索-->

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
