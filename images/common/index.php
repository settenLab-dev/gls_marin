<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);
//print_r($collection);

$collection->setByKey($collection->getKeyValue(), "limitptn", "top");

$kuchikomi = new kuchikomi($dbMaster);
$kuchikomi->selectSide($collection);
$dspKArray = array();
if ($kuchikomi->getCount() > 0) {
	foreach ($kuchikomi->getCollection() as $kuchidata) {
	//	print_r($kuchidata);
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_ID"] = $kuchidata["KUCHIKOMI_ID"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_FACILITY_NAME"] = $kuchidata["KUCHIKOMI_FACILITY_NAME"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_TITLE"] = $kuchidata["KUCHIKOMI_TITLE"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_DETAIL"] = $kuchidata["KUCHIKOMI_DETAIL"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_PIC1"] = $kuchidata["KUCHIKOMI_PIC1"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_AREA"] = $kuchidata["KUCHIKOMI_AREA"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_CATEGORY"] = $kuchidata["KUCHIKOMI_CATEGORY"];
	}
}

$inputs = new inputs(); ?>


<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<link rel="canonical" href="<?php print URL_PUBLIC?>" />
<title><?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />

<link rel="stylesheet" href="//playbooking.jp/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="//playbooking.jp/js/jquery-ui-1.10.3.custom.min.js"></script>

<link rel="stylesheet" href="//playbooking.jp/common/css/popupwindow.css" type="text/css" media="screen" />
<script type="text/javascript" src="//playbooking.jp/common/js/popupwindow-1.6.js"></script>
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

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide1').bxSlider({
	auto: true,
	autoHover: false,
	pause:	5000,
	speed: 1000,
	pager: false,
	touchEnabled: true,
	swipeThreshold: 50,
	oneToOneTouch: true,
	slideWidth: 1600,
	minSlides: 1,
	maxSlides: 1,
	moveSlides: 1,
	slideMargin: 0,
	infiniteLoop: true,
        prevText: '<',
        nextText: '>'
        });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide2').bxSlider({
	auto: true,
	autoHover: false,
	pause:	5000,
	speed: 1000,
	pager: false,
	slideWidth: 300,
	minSlides: 3,
	maxSlides: 3,
	moveSlides: 1,
	slideMargin: 5,
	infiniteLoop: true,
        prevText: '<',
        nextText: '>'
        });
  });
</script>
</head>

<body id="index2016" style="background:none;">



<!--header-->

<?php require("includes/box/common/header_common.php");?>

<!--/header-->

<!--pickup-->
<div id="pickup">

		<div class="clearfix">

		<ul class="slide1">
			<li class="ti"><span>「PlayBookingで見つけよう」</span><img src="images/common/image_top2.png"></li>
			<li class="ti"><span>「PlayBookingで楽しもう」</span><img src="images/common/image_top2.png"></li>
			<li class="ti"><span>「PlayBookingで出かけよう」</span><img src="images/common/image_top2.png"></li>
		</ul>

		</div>
</div>
<!--/pickup-->

<!--Content-->
<div id="content" class="clearfix">
	<!--main-->
	<main>
		<article>

		<ul class="top_banner">
			<li><a href=""><img src="images/common/bnr_01.png"></a></li>
			<li><a href=""><img src="images/common/bnr_02.png"></a></li>
			<li><a href=""><img src="images/common/bnr_03.png"></a></li>
		</ul>
				<!--検索-->
	        	<section>	   

<div id="tabmenu">
    <div id="tab">
        <a href="#1day">今日(11/30)</a>
        <a href="#2day">明日(12/1)</a>
        <a href="#3day">明後日(12/2)</a>
    </div>
    <div id="tab_contents">
        <ul>
            <li id="1day" name="1day">"No1" this is tab container.you can write anythig.</li>
            <li id="2day" name="2day">"No2" this is tab container.you can write anythig.</li>
            <li id="3day" name="3day">"No3" this is tab container.you can write anythig.</li>
            <li id="result" name="result">"SEARCHresult" this is tab container.you can write anythig.</li>
        </ul>
    </div>
</div>


     		
		        	<h2>ホテルを探す</h2>
		        		<div class="search_box">
				        	<p class="ti"><img src="images/index2016/search_ti.png" width="127" height="28" alt="日付から探す" /></p>
				        	<div class="search_box_in">
					        	<form method="post" action="plan-search.html">
					        		<ul>
							        	<li><input type="text" id="search_date" name="search_date" value="<?php print date("Y年m月d日", strtotime("+1 day")) ?>" class="imeDisabled wDateJp" />
								        	<script type="text/javascript">
								                         $.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
								                         $("#search_date").datepicker(
								                         		{
								                         			showOn: 'button',
								                         			buttonImage: 'images/index2016/index-search-icon.png',
								                         			buttonImageOnly: true,
								                         			dateFormat: 'yy年mm月dd日',
								                         			changeMonth: true,
								                         			changeYear: true,
								                         			yearRange: '2016:2017',
								                         			showMonthAfterYear: true,
								                         			monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
								                                     dayNamesMin: ['日','月','火','水','木','金','土']
								                         		});
								            </script>
							        	</li>	    
							          <li>
							            	<input type="checkbox" name="example" value="日付未定"><span class="undecided">日付<br>未定</span>
							            </li>
										<li>
											人数
											<div class="select_box">
												<select name="priceper_num" id="priceper_num" class="select2 adultnumset adult_sgl">
												<option value="1" >1</option>
												<option value="2" selected="selected">2</option>
												<option value="3" >3</option>
												<option value="4" >4</option>
												<option value="5" >5</option>
												<option value="6" >6</option>
												<option value="7" >7</option>
												<option value="8" >8</option>
												<option value="9" >9～</option>
												</select>
											</div>


											<input type="hidden" id="adult_number2" name="adult_number2" value="0" />	                        	
											<input type="hidden" id="adult_number3" name="adult_number3" value="0" />	                        	
											<input type="hidden" id="adult_number4" name="adult_number4" value="0" />	                        	
											<input type="hidden" id="adult_number5" name="adult_number5" value="0" />	                        	
											<input type="hidden" id="adult_number6" name="adult_number6" value="0" />	                        	
											<input type="hidden" id="adult_number7" name="adult_number7" value="0" />	                        	
											<input type="hidden" id="adult_number8" name="adult_number8" value="0" />	                        	
											<input type="hidden" id="adult_number9" name="adult_number9" value="0" />	                        	
											<input type="hidden" id="adult_number10" name="adult_number10" value="0" />

											<div class="selectbox adultnumset adult_dbl">
												<a href="javascript:void(0)" onclick="openChildSet()" id="adult_text">2</a>
											</div>
										<li>
											<span>エリア</span>
											<div class="select_box02"><select name="area" id="area">
											<option value="19" selected="selected">北部</option>
											<option value="18" >中部</option>
											<option value="2" >那覇</option>
											<option value="3" >南部</option>
											<option value="16" >石垣島・八重山</option>
											<option value="12" >宮古島</option>
											<option value="22" >その他離島</option>
										</select></div>
										</li>
										<li>
											<input class="search_btn_new" type="submit" value="検索する" name="検索する" id="">
										</li>
						        	</ul>
					           	</form>
				           </div>
			           </div>       		        		
	        	</section>
				<!--/検索-->

		<!--スタッフおすすめ情報-->
			<section>
				<h2>スタッフおすすめ情報</h2>

			        	<?php require("index_osusume.php");?>
					
			</section>
			<!--/スタッフおすすめ情報-->




		        <!--口コミ-->
	        	<section>	        		
		        	<h2>おすすめクチコミ</h2>
        <?php if (count($dspKArray) > 0) {
			foreach ($dspKArray as $kk) {
			//print_r($kk);
	?>
			        	<a href="/kuchikomi-detail.html?k_id=<?php print $kk["KUCHIKOMI_ID"]?>">
			        		<ul>
			        			<li>
			        				<p>
									<?php if ($kk["KUCHIKOMI_PIC1"] != "") {?>
										<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kk["KUCHIKOMI_PIC1"]?>" width="80" height="70" class="fl-l"  alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
									<?php }else{?>
										<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="80" height="70" class="fl-l" alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
									<?php }?>
								</p>
			        				<dl>
			        					<dt><?php print cmStrimWidth($kk["KUCHIKOMI_FACILITY_NAME"], 0, 20, '…')?></dt>
			        					<dd><?php print cmStrimWidth($kk["KUCHIKOMI_TITLE"], 0, 100, '…')?></dd>
			        					<dd class="link"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 続きを読む</dd>
			        				</dl>
			        			</li>
			        		</ul>
			        	</a>
        <?php
			}
	}
	?>


		        		<p class="btn"><a href="/kuchikomi-search.html"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> クチコミをもっと見る</a></p>
		        </section>
		        <!--/口コミ-->

		
		</article>
	</main>
	<!-- /main-->
</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>

<!--analitics-->
<!-- タグ取得後挿入 -->

<!--/analitics-->

<!--/footer-->
</body>
<!-- InstanceEnd --></html>
