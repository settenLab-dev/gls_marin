<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/event.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/job.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);
//print_r($collection);

$collection->setByKey($collection->getKeyValue(), "limitptn", "top");

$event = new event($dbMaster);
$event->selectSide($collection);
//print $event->getCount();
$dspEArray = array();
if ($event->getCount() > 0) {
	foreach ($event->getCollection() as $eventdata) {
	//	print_r($eventdata);
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_ID"] = $eventdata["EVENT_ID"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_POST_FROM"] = $eventdata["EVENT_POST_FROM"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_NAME"] = $eventdata["EVENT_NAME"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_DETAIL"] = $eventdata["EVENT_DETAIL"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_PIC1"] = $eventdata["EVENT_PIC1"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_AREA"] = $eventdata["EVENT_AREA"];
		$dspEArray[$eventdata["EVENT_ID"]]["EVENT_CATEGORY"] = $eventdata["EVENT_CATEGORY"];
	}
}

$kuchikomi = new kuchikomi($dbMaster);
$kuchikomi->selectSide($collection);
$dspKArray = array();
if ($kuchikomi->getCount() > 0) {
	foreach ($kuchikomi->getCollection() as $kuchidata) {
	//	print_r($kuchidata);
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_ID"] = $kuchidata["KUCHIKOMI_ID"];
	//	$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_POST_FROM"] = $kuchidata["KUCHIKOMI_POST_FROM"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_FACILITY_NAME"] = $kuchidata["KUCHIKOMI_FACILITY_NAME"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_TITLE"] = $kuchidata["KUCHIKOMI_TITLE"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_DETAIL"] = $kuchidata["KUCHIKOMI_DETAIL"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_PIC1"] = $kuchidata["KUCHIKOMI_PIC1"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_AREA"] = $kuchidata["KUCHIKOMI_AREA"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_CATEGORY"] = $kuchidata["KUCHIKOMI_CATEGORY"];
	}
}


$job = new job($dbMaster);
$job->selectSide($collection);
$planCnt = 0;
$dspArray = array();
if ($job->getCount() > 0) {
	foreach ($job->getCollection() as $data) {
		//print_r($data);
		$planCnt++;
		$dspArray[$planCnt]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$planCnt]["JOBPLAN_ID"] = $data["JOBPLAN_ID"];
		$dspArray[$planCnt]["JOB_NAME"] = $data["JOB_NAME"];
//		$dspArray[$planCnt]["JOB_PIC_APP"] = $data["JOB_PIC_APP"];
		$dspArray[$planCnt]["JOB_PIC2"] = $data["JOB_PIC2"];
		$dspArray[$planCnt]["JOB_CATCH"] = $data["JOB_CATCH"];
		$dspArray[$planCnt]["JOB_FEATURE"] = $data["JOB_FEATURE"];
		$dspArray[$planCnt]["JOB_AREA_LIST"] = $data["JOB_AREA_LIST"];
		$dspArray[$planCnt]["JOB_SEASON_LIST"] = $data["JOB_SEASON_LIST"];
		$dspArray[$planCnt]["JOB_EMPLOYTYPE_LIST"] = $data["JOB_EMPLOYTYPE_LIST"];
		$dspArray[$planCnt]["JOB_KINDTYPE_LIST"] = $data["JOB_KINDTYPE_LIST"];
		$dspArray[$planCnt]["JOB_ICON_LIST"] = $data["JOB_ICON_LIST"];
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

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide1').bxSlider({
	auto: true,
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

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide2').bxSlider({
	auto: true,
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

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide3').bxSlider({
	auto: true,
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

<body id="index2015">

<!--header-->
<?php require("includes/box/common/header2015.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->

<!-- InstanceEndEditable -->

<!--Content-->
<div id="content" class="clearfix" style="padding:0;">



<!--main-->
	 <main id="index2015">
<!-- Left side-->
		<div id="side_l">
			<section>
			    <div class="mainimage" style="margin-bottom:10px;">
			<img src="./images/top2015/img_top2.jpg" width="980" height="200" alt="お得なレジャー専門サイト「ココトモ！」" /></a></li>
				</div>
			</section>

			<div id="news_box">
				<ul id="ticker01">
				<?php require("includes/box/common/news_top.php");?>
				</ul>
			</div>
<!--宿泊予約-->
	<div class="contents_box cf">
			<div class="title">
				<span>宿泊予約</span>
				<!--<img src="images/top2015/icon_hotel.png" width="176" height="40">-->
				<h1>県民価格のお得なプランあり！みんなで泊まりに行こう！</h1>
			</div>
		<!-- コンテンツ始点 -->
		<div class="inner_box cf">
			<a href="http://cocotomo.net/n_hotel.html">
			<div class="cont_main_hotel">
				<p class="description">
					人気のホテルやリゾートへ県民価格でお得に宿泊しよう！カップル、夫婦、家族旅行はもちろん、模合やお祝いにも♪団体のご相談もお気軽に！
				</p>
			</div>
			</a>
			<div class="hotel_plan cf">
				<a href="http://cocotomo.net/plan-detail.html?hotelplan_id=617&company_id=9&room_id=222">
					<h1>GRGホテル那覇</h1>
					<img src="http://common.cocotomo.net/images/9/HOTELPIC_DATA_20130827681a6aa62573fed636d5c8ee921ca3a7e6f82551.jpg" width="140" height="100">
					<img src="http://common.cocotomo.net/images/9/HOTEL_PIC_APP_20130901186c0a913ef98cb16c60601448726373399cbffb.jpg" width="140" height="100">
					<p>カップルおすすめ♪ココトモだけの特別価格！松山のお洒落なビジネス。飲んだ帰りは泊まった方がお得かも！</p>
				</a>
				<div class="qab">
					<a href="http://www.qab.co.jp/spice/present" target="blank">
						<img src="images/top2015/btn_present.png" width="180" height="32">
					</a>
				</div>
			</div>

<!--検索-->
	        	<div class="search cf">
	        	<h2><img src="./images/top2015/hotel_search.png" width="38" height="79" alt="検索" /></h2>
	        	<form method="post" action="facility-search.html#">
	                <table class="form">
	                	<tr>
	                		<th>宿泊日</th>
	                		<th>宿泊日数</th>
	                		<!--<th>ご利用部屋数</th>-->
	                		<th colspan="2" style="width:150px;">ご利用人数</th>
	                		<th colspan="2" style="width:150px;">エリア</th>
	                	</tr>
	                	<tr>
	                         <td id="search_datetd">
	                         <?php 
	                         print $inputs->text("search_date", $collection->getByKey($collection->getKeyValue(), "search_date") ,"imeDisabled wDateJp")?>
	                         <script type="text/javascript">
	                         $.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
	                         $("#search_date").datepicker(
	                         		{
	                         			showOn: 'button',
	                         			buttonImage: 'images/index/index-search-icon.png',
	                         			buttonImageOnly: true,
	                         			dateFormat: 'yy年mm月dd日',
	                         			changeMonth: true,
	                         			changeYear: true,
	                         			yearRange: '<?php print date("Y")?>:<?php print date("Y",strtotime("+1 year"))?>',
	                         			showMonthAfterYear: true,
	                         			monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                                     dayNamesMin: ['日','月','火','水','木','金','土']
	                         		});
	                         </script>
	                         </td>
	                        <td>
	                        	<div class="selectbox lbox">
	                        		<div class="select-inner select2"><span></span></div>
	                        		<select class="select2" name="night_number" id="night_number">
	                        		<?php
	                        		for ($i=1; $i<=SITE_STAY_NUM; $i++) {
	                        			$selected = '';
	                        			if ($collection->getByKey($collection->getKeyValue(), "night_number") == $i) {
	                        				$selected = 'selected="selected"';
	                        			}
	                        		?>
	                        		<option value="<?php print $i?>" <?=$selected;?>><?=$i?></option>
	                        		<?php }?>
	                        		</select>
	                        	</div><span>泊</span>
					<input type="hidden" id="room_number" name="room_number" value="1">
	                        </td>
	                       <!-- <td>
	                        	<div class="selectbox lbox">
	                        		<div class="select-inner select2"><span></span></div>
	                        		<select class="select2" name="room_number" id="room_number">
	                        		<?php
	                        		for ($i=1; $i<=SITE_ROOM_NUM; $i++) {
	                        			$selected = '';
	                        			if ($collection->getByKey($collection->getKeyValue(), "room_number") == $i) {
	                        				$selected = 'selected="selected"';
	                        			}
	                        		?>
	                        		<option value="<?=$i?>" <?=$selected;?>><?=$i?></option>
	                        		<?php }?>
	                        		</select>
	                        	</div><span>部屋</span>
	                        </td>-->
	                    	<td>
	                    		　大人
	                    		<?php
	                            	$num = 0;
	                            	for ($room=1; $room<=SITE_ROOM_NUM; $room++) {
										$num += intval($collection->getByKey($collection->getKeyValue(), "adult_number".$room));
	                            		if ($room == 1) {
								?>
									<div class="selectbox" id="ori_adult">
									<div class="select-inner select2 adultseldiv"><span></span></div>
		                            <select name="adult_number<?php print $room?>" id="adult_number<?php print $room?>" class="select2 adultnumset adult_sgl">
	                        		<?php
	                        		for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "adult_number".$room) == $i) {
											$selected = 'selected="selected"';
										}
									?>
	                                <option value="<?php print $i?>" <?php print $selected;?>><?php print $i?><?php print ($i==SITE_ADULT_NUM)?"～":""?></option>
	                        		<?php }?>
	                            	</select></div>

	                            <?php }else {?>
	                        		<?php print $inputs->hidden("adult_number".$room, $collection->getByKey($collection->getKeyValue(), "adult_number".$room))?>
	                        	<?php }?>

	                        	<?php }?>

	                            <div class="selectbox adultnumset adult_dbl">
									<a href="javascript:void(0)" onclick="openChildSet()" id="adult_text"><?php print $num?></a>
	                            </div>

	                        	<script type="text/javascript">
	                            $(document).ready(function(){
	                            	$("#room_number").change(function () {
	                            		roomChange();
	                            		if ($("#room_number").val() > 1) {
	                            			if (pop === undefined) {
		                            		}
	                            			else {
			                            		pop.close();
	                            			}
		                            		openChildSet();
	                            		}
	                            		else {
		                            		pop.close();
	                            		}
	                            	});
	                            	roomChange();
	                            });
	                            function roomChange() {
	                        		$(".adultnumset").addClass('dspNon');
	                        		$("#adult_number").addClass('dspNon');
	                            	if ($("#room_number").val() > 1) {
	                            		$(".adult_dbl").removeClass('dspNon');
	                            	}
	                            	else {
	                            		$(".adult_sgl").removeClass('dspNon');
	                            	}
	                            }
	                            </script>
	                            <span>名</span>
	                    	</td>
	                    	<td>
	                    		 子供
	                    		<div class="selectbox">
	                    			<?php
	                    				$num = 0;
	                    				for ($room=1; $room<=SITE_ROOM_NUM; $room++) {
	                    					for ($i=1; $i<=6; $i++) {
	                    						$num += intval($collection->getByKey($collection->getKeyValue(), "child_number".$room.$i));
	                    				?>
	                    				<?php print $inputs->hidden("child_number".$room.$i, $collection->getByKey($collection->getKeyValue(), "child_number".$room.$i))?>
	                    				<?php
	                    					}
	                    				}
	                    				?>
	                    				<a href="javascript:void(0)" onclick="openChildSet()" id="child_text"><?php print $num?></a>
	                    		</div><span>名</span>
	                    	</td>
	                        <td colspan="4" id="arearadio" style="margin-top: -10px;">
		                        <!--<div class="checkmitei"><?=$inputs->checkbox("undecide_sch","undecide_sch",1,$collection->getByKey($collection->getKeyValue(), "undecide_sch"),"日程未定", "")?></div>-->
	                        	<div class="radius5 erea"><span class="r-sp">エリア</span>
	                        	<input type="radio" value="19" name="area" id="area19" checked="checked">北部　
	                        	<input type="radio" value="18" name="area" id="area18">中部　
	                        	<input type="radio" value="20" name="area" id="area20">那覇・南部
		                        </div>
	                        </td>
	                        <td class="searchinput">
	                        	<input class="search_btn" type="submit" value="" name="" id="">
	                        </td>
	                	</tr>
	                	</table>
	           	</form>
	        	</div>

			<div class="pickup">
			<div class="title2">
				<span>おすすめプランPickup！</span>
				<a href="/sp-backnumber2.html"><img src="images/top2015/btn_hotelplan.png" width="234" height="30"></a>
			</div>

				<ul>
					<li>
						<a href="http://cocotomo.net/plan-detail.html?hotelplan_id=14835308&company_id=22&company_link=M87396&room_id=18">
						<img src="https://www.tl-lincoln.net/accomodation/accomodation_image/M/M87396/00161385.jpg" width="140" height="90">
						<span><B>オキナワマリオットリゾート＆スパ</B></span><br/>
						<p>人気リゾートがお得な県民価格で！絞りたての生フルーツジュースや県産マグロや新鮮な食材を使ったメニューが評判の朝食付き！</p>
						</a>
					</li>
					<li>
						<a href="http://cocotomo.net/plan-detail.html?hotelplan_id=14207570&company_id=49&company_link=I20893&room_id=7">
						<img src="https://www.tl-lincoln.net/accomodation/accomodation_image/I/I20893/00160248.jpg" width="140" height="90">
						<span><B>ホテルマハイナウェルネスリゾートオキナワ</B></span><br/>
						<p>北部リゾートがおひとり様5,500円～！地元食材たっぷりの朝食バイキング付き♪海のミネラルたっぷりの大浴場やプールも入り放題！</p>
						</a>
					</li>
					<li>
						<a href="http://cocotomo.net/plan-detail.html?hotelplan_id=16350477&company_id=46&company_link=W87065&room_id=12">
						<img src="https://www.tl-lincoln.net/accomodation/accomodation_image/W/W87065/00158504.jpg" width="140" height="90">
						<span><B>サザンビーチホテル＆リゾート</B></span><br/>
						<p>夕朝2食付でお得！豪華ステーキorローストビーフやお寿司のほか、シェフが目の前で作り上げていくスイーツやペストリーが充実！</p>
						</a>
					</li>
					<li>
						<a href="http://cocotomo.net/plan-detail.html?hotelplan_id=16248249&company_id=47&company_link=R06780&room_id=17">
						<img src="https://www.tl-lincoln.net/accomodation/accomodation_image/R/R06780/00160256.jpg" width="140" height="90">
						<span><B>ホテルゆがふいんおきなわ</B></span><br/>
						<p>本場職人の手作り飲茶や薬膳料理など、ここでしか食べられない絶品中華が食べ放題！中華料理コンクール入賞経歴ありで味はお墨付き♪</p>
						</a>
					</li>

			</div>
		<!-- コンテンツ終点 -->
		</div>
	</div>


<!--クーポン-->
	<div class="contents_box cf">
			<div class="title">
				<span>クーポン</span>
				<!--<img src="images/top2015/icon_coupon.png" width="168" height="43">-->
				<h1>今だけのお得なクーポン！レジャーもお買い物もお得に！</h1>
			</div>
		<!-- コンテンツ始点 -->
		<div class="inner_box cf">
			<div class="cont_main_coupon">
				<div class="description">
				沖縄県内を中心に人気のホテルやレジャー、グルメ、お買い物もお得に楽しめるクーポンを販売！まもなくサービススタート！どうぞお楽しみに♪
				</div>
			</div>
			<div class="coupon_construct"></div>

<!--
				<a href="#">
					<div class="coupon_pickup">
						<h1>クーポンタイトル</h1>
						<img src="images/top2015/img_coupon.jpg" width="230" height="135">
							<div class="off"><p>50％</br>OFF</p></div>
						<div class="plan_description">
							<h2>10000円 ＞＞ <span>5000円</span></h2>
							<p>クーポン詳細テキストテキストテキストテキストテキストテキスト</p>
						</div>
					</div>
				</a>
-->
		<!-- コンテンツ終点 -->
		</div>
	</div>


<!--イベント-->
		<div class="contents_box cf">
		<div class="inner_box cf">
			<div class="title2">
				<span>イベント</span>
				<!--<img src="images/top2015/icon_event.png" width="208" height="38">-->
				<h1>旬なイベントへおでかけしよう！</h1>
				<a href="/event-search.html">≫ イベントをもっと見る</a>
			</div>

			<div class="slide_info">
			<ul class=" slide1">
        <?php
        if (count($dspEArray) > 0) {
			foreach ($dspEArray as $dd) {
		//	print_r($dd);
	?>
				<li>
				<?php $formnames = "frmSearche".$dd["EVENT_ID"];?>
				<form action="event-detail.html" method="post" id="<?php print $formnames?>" name="<?php print $formnames?>">
					<?php print $inputs->hidden("EVENT_ID", $dd["EVENT_ID"])?>
				<?php if ($dd["EVENT_PIC1"] != "") {?>
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $dd["EVENT_PIC"]?>" width="130" height="130" class="fl-l"  alt="<?php print $dd["EVENT_NAME"]?>"></a>
				<?php }else{?>
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="130" height="130" class="fl-l" alt="<?php print $dd["EVENT_NAME"]?>"></a>
				<?php }?>
					   <span><?php print date("Y年m月d日",strtotime($dd["EVENT_POST_FROM"]))?>～</span>
	                      		   <a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();">
						<h2><?php print cmStrimWidth($dd["EVENT_NAME"], 0, 100, '…')?></h2>
					</a>

				</form>
				</li>
        <?php
			}
	}
	?>
			</ul>
			</div>
		</div>
		</div>


<!--クチコミ-->
		<div class="contents_box cf">
		<div class="inner_box cf">

			<div class="title2">
				<span>みんなのクチコミ</span>
				<!--<img src="images/top2015/icon_kuchikomi.png" width="215" height="38">-->
				<h1>みんなの体験クチコミでもっと楽しいおでかけに！</h1>
				<a href="/kuchikomi-search.html">≫ クチコミをもっと見る</a>
			</div>

			<div class="slide_info">
			<ul class="slide2">
        <?php
        if (count($dspKArray) > 0) {
			foreach ($dspKArray as $kk) {
			//print_r($kk);
	?>
				<li>
				<?php $formnames = "frmSearchk".$kk["KUCHIKOMI_ID"];?>
				<form action="kuchikomi-detail.html" method="post" id="<?php print $formnames?>" name="<?php print $formnames?>">
					<?php print $inputs->hidden("KUCHIKOMI_ID", $kk["KUCHIKOMI_ID"])?>
				<?php if ($kk["KUCHIKOMI_PIC1"] != "") {?>
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kk["KUCHIKOMI_PIC1"]?>" width="130" height="130" class="fl-l"  alt="<?php print $kk["KUCHIKOMI_TITLE"]?>"></a>
				<?php }else{?>
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="130" height="130" class="fl-l" alt="<?php print $kk["KUCHIKOMI_TITLE"]?>"></a>
				<?php }?>
	                      		   <a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();">
						<h2><B><?php print cmStrimWidth($kk["KUCHIKOMI_FACILITY_NAME"], 0, 20, '…')?></B></h2>
						<h2><?php print cmStrimWidth($kk["KUCHIKOMI_DETAIL"], 0, 100, '…')?></h2>
					</a>

				</form>
				</li>
        <?php
			}
	}
	?>
			</ul>
			</div>
		</div>
		</div>



<!--お仕事情報-->

		<div class="contents_box cf">
		<div class="inner_box cf">

			<div class="title2">
				<span>仕事情報</span>
				<h1>日払いバイトから正社員まで！幅広いお仕事情報を掲載中！</h1>
				<a href="/n_job.html">≫ 仕事情報をもっと見る</a>
			</div>

			<div class="slide_info">
			<ul class="slide3">
        <?php
        if (count($dspArray) > 0) {
			foreach ($dspArray as $plandata) {
			//print_r($plandata);

	?>
				<li>
				<?php $formnames = "frmjob".$plandata["COMPANY_ID"]."_".$plandata["JOBPLAN_ID"];?>
				<form action="job-detail.html" method="post" id="<?php print $formnames?>" name="<?php print $formnames?>">
					<a href="javascript:void(0)" onclick="document.<?php print $formnames?>.submit();">
					<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
					<?php print $inputs->hidden("JOBPLAN_ID", $plandata["JOBPLAN_ID"])?>
				<!--
				<?php if ($plandata["JOB_PIC2"] != "") {?>
					<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $plandata["JOB_PIC2"]?>" width="130" height="130" class="fl-l"  alt="<?php print $plandata["JOB_NAME"]?>">
				<?php }else{?>
					<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="130" height="130" class="fl-l" alt="<?php print $plandata["JOB_NAME"]?>">
				<?php }?>
				-->
						<h2><B><?php print cmStrimWidth($plandata["JOB_NAME"], 0, 20, '…')?></B></h2>
						<h2><?php print cmStrimWidth($plandata["JOB_FEATURE"], 0, 100, '…')?></h2>
					</a>

				</form>
				</li>
        <?php
			}
	}
	?>
			</ul>
			</div>
		</div>
		</div>

	</div>




<!--Left side-->

<!--Right side-->

	<div id="side_r">

		<div class="intro">
				<a href="http://cocotomo.net/intro.html">
				<img src="images/top2015/img_intro.jpg" width="330" height="200">
				</a>
		</div>

    	<!--login-->
        <?php 
        //require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');
        //if (!cmCheckPtn($_SERVER['PHP_SELF'],'/login\.php$/')) {?>

        	<?php
			if (!$sess->sessionCheck()) {
			?>
		<aside class="login_cn">
			<ul>
				<li>
	               		 <p>簡単！無料会員登録！</p>
					<a href="https://cocotomo.net/regist.html"><img src="/images/front/regist_btn.png" width="150" alt="会員登録"></a>
		           	 </li>
		           	 <li>
	               		 <p>会員の方はコチラ</p>
	            			<a href="https://cocotomo.net/login.html"><img src="/images/front/login_btn.png" width="150" alt="会員ログイン"></a>
	           		 </li>
	        	</ul>
	        </aside>
			<?php
// 				require_once('includes/box/login/loginBoxRight.php');
			}
			else {
			?>

		<aside id="status_cn">
				<img src="/images/front/corner_hana.png">こんにちは！<B><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_HANDLENAME")?></B>さん
			</br>
			<ul>
				<li>
					<div class="point">
						　現在のポイント：<span><?php 
						if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT")>0){
							print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT");
						}else {
							print 0;
						}?> P</span>
					</div>
				</li>
				<li>
					　<a href="https://cocotomo.net/mypoint.html">▼ポイントの履歴</a>
				</li>
			</ul>
			<ul class="menu">
				<li>
					　<a href="https://cocotomo.net/myhotel.html">▼予約の確認・ｷｬﾝｾﾙ</a>
				</li>
				<li>
					　<a href="https://cocotomo.net/mybasic.html">▼会員情報の変更</a>
				</li>
				<li>
					　<a href="https://cocotomo.net/mypage.html">▼マイページへ</a>
				</li>
			</ul>
				<div id="logout">
						<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					        	<?=$inputs->submit("","logout","ログアウト", "circle")?>
					       	</form>
				</div>
		</aside>
                <?php
                }
                ?>


<!--
		<div class="bijint">
				<a href="http://glaspe.net/bijint/index.html">
				<img src="images/top2015/img_bijin.jpg" width="330" height="155">
			<div class="caption">
				ココトモ！(glass space㈱)は美人トピックの公式パートナーです。美人レポーター募集中!!
			</div></a>
		</div>
-->

		<p align="center">【PR枠】</p>
		<div id="pr">
		<ul>
			<li>
				<a href="http://cateringblog.ti-da.net/">
				<img src="images/top2015/pr_01.jpg" width="330" height="165"></br>
				<div class="caption">お届け料理はあいあいケータリング！パーティ、宴会、会議に♪</div></a>
			</li>
			<li>
				<a href="http://www.cerulean-blue.co.jp/">
				<img src="images/top2015/pr_02.jpg" width="330" height="165"></br>
				<div class="caption">沖縄の遊びはセルリアンブルーにおまかせ！フォトやチャーターもOK!</div></a>
			</li>
			<li>
				<a href="http://www.regency-inc.com/kyushu/">
				<img src="images/top2015/pr_03.jpg" width="330" height="200"></br>
			</li>
		</ul>
		</div>
	        <div id="side-fb">
			<h2><img src="images/top2015/title_facebook.png" width="330"></h2>
	        	<div>
			    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F%25E5%259C%25B0%25E5%259F%259F%25E9%2599%2590%25E5%25AE%259A%25E3%2583%25AC%25E3%2582%25B8%25E3%2583%25A3%25E3%2583%25BC%25E3%2582%25B5%25E3%2582%25A4%25E3%2583%2588COCOTOMO%25E3%2582%25B3%25E3%2582%25B3%25E3%2583%2588%25E3%2583%25A2%2F159647334241391&amp;width=330&amp;height=280&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:330px; height:280px;" allowTransparency="true"></iframe>
			</div>
	</div>
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
