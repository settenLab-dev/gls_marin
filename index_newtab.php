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
	pop= new $pop('popchildset.php?num1='+num1+'&num2='+num2+'&num3='+num3+'&num4='+num4+'&num5='+num5+'&num6='+num6, { type:'iframe', title:'????????????',effect:'normal',width:650,height:rheight,windowmode:false,resize: false } );
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

<script type="text/javascript">
  $(document).ready(function(){
    $('.slide3').bxSlider({
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

<body id="new_tab">

<!--header-->
<?php require("includes/box/common/header2015_newtab.php");?>
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
			<img src="./images/top2015/img_top2.jpg" width="980" height="200" alt="?????????????????????????????????????????????????????????" />
				</div>
			</section>

			<div id="news_box">
				<ul id="ticker01">
				<?php require("includes/box/common/news_top.php");?>
				</ul>
			</div>
				<a href="/cpn_top201508.html"><img src="./images/cpn201508_top/img_banner.jpg" alt="????????????????????????????????????????????????????????????"></a><br/><br/>
<!--????????????-->
	<div class="contents_box cf">
			<div class="title">
				<span>????????????</span>
				<!--<img src="images/top2015/icon_coupon.png" width="168" height="43">-->
				<h1>??????????????????????????????????????????????????????????????????????????????</h1>
			</div>
		<!-- ????????????????????? -->
		<div class="inner_box cf">
			<a href="http://cocotomo.net/n_coupon.html">
			<div class="cont_main_coupon">
				<div class="description">
				?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
				</div>
			</div>
			</a>
			<!--<div class="coupon_construct"></div>-->


				<a href="http://cocotomo.net/coupon-detail.html?company_id=87&shop_id=13&cplan_id=24">
					<div class="coupon_pickup">
						<h1>????????????????????? ????????? ?????????</h1>
						<img src="http://common.cocotomo.net/images/87/COUPONPLAN_PIC2_201509158ea5fa3c35490f1998085107a50f642b697b6652.jpg" width="230" height="135">
							<div class="off"><p>23???</br>OFF</p></div>
						<div class="plan_description">
							<h2><span>2500???</span></h2>
							<p>??????????????????80?????????????????????70??????????????????!!???????????????????????????????????????!!</p>
						</div>
					</div>
				</a>

		<!-- ????????????????????? -->
		</div>
	</div>


<!--????????????-->
	<div class="contents_box cf">
			<div class="title">
				<span>????????????</span>
				<!--<img src="images/top2015/icon_hotel.png" width="176" height="40">-->
				<h1>??????????????????????????????????????????????????????????????????????????????</h1>
			</div>
		<!-- ????????????????????? -->
		<div class="inner_box cf">
			<a href="http://cocotomo.net/n_hotel.html">
			<div class="cont_main_hotel">
				<p class="description">
					???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
				</p>
			</div>
			</a>
			<div class="hotel_plan cf">
				<?php require("hotel_pickup.php");?>

				<div class="qab">
					<a href="http://www.qab.co.jp/spice/present" target="blank">
						<img src="images/top2015/btn_present.png" width="180" height="32">
					</a>
				</div>
			</div>

<!--??????-->
	        	<div class="search cf">
	        	<h2><img src="./images/top2015/hotel_search.png" width="38" height="79" alt="??????" /></h2>
	        	<form method="post" action="facility-search.html#">
	                <table class="form">
	                	<tr>
	                		<th>?????????</th>
	                		<th>????????????</th>
	                		<!--<th>??????????????????</th>-->
	                		<th colspan="2" style="width:150px;">???????????????</th>
	                		<th colspan="2" style="width:150px;">?????????</th>
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
	                         			dateFormat: 'yy???mm???dd???',
	                         			changeMonth: true,
	                         			changeYear: true,
	                         			yearRange: '<?php print date("Y")?>:<?php print date("Y",strtotime("+1 year"))?>',
	                         			showMonthAfterYear: true,
	                         			monthNamesShort: ['1???','2???','3???','4???','5???','6???','7???','8???','9???','10???','11???','12???'],
	                                     dayNamesMin: ['???','???','???','???','???','???','???']
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
	                        	</div><span>???</span>
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
	                        	</div><span>??????</span>
	                        </td>-->
	                    	<td>
	                    		?????????
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
	                                <option value="<?php print $i?>" <?php print $selected;?>><?php print $i?><?php print ($i==SITE_ADULT_NUM)?"???":""?></option>
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
	                            <span>???</span>
	                    	</td>
	                    	<td>
	                    		 ??????
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
	                    		</div><span>???</span>
	                    	</td>
	                        <td colspan="4" id="arearadio" style="margin-top: -10px;">
		                        <!--<div class="checkmitei"><?=$inputs->checkbox("undecide_sch","undecide_sch",1,$collection->getByKey($collection->getKeyValue(), "undecide_sch"),"????????????", "")?></div>-->
	                        	<div class="radius5 erea"><span class="r-sp">?????????</span>
	                        	<input type="radio" value="19" name="area" id="area19" checked="checked">?????????
	                        	<input type="radio" value="18" name="area" id="area18">?????????
	                        	<input type="radio" value="20" name="area" id="area20">???????????????
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
				<span>?????????????????????Pickup???</span>
				<a href="/sp-backnumber2.html"><img src="images/top2015/btn_hotelplan.png" width="234" height="30"></a>
			</div>
				<?php require("plan_pickup.php");?>
			</div>
		<!-- ????????????????????? -->
		</div>
	</div>



<!--????????????-->
		<div class="contents_box cf">
		<div class="inner_box cf">
			<div class="title2">
				<span>????????????</span>
				<!--<img src="images/top2015/icon_event.png" width="208" height="38">-->
				<h1>?????????????????????????????????????????????</h1>
				<a href="/event-search.html">??? ??????????????????????????????</a>
			</div>

			<div class="slide_info">
			<ul class=" slide1">
        <?php
        if (count($dspEArray) > 0) {
			foreach ($dspEArray as $dd) {
		//	print_r($dd);
	?>
				<li>
				<a href="/event-detail.html?e_id=<?php print $dd["EVENT_ID"]?>">
				<?php if ($dd["EVENT_PIC1"] != "") {?>
					<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $dd["EVENT_PIC1"]?>" width="130" height="130" class="fl-l"  alt="<?php print $dd["EVENT_NAME"]?>">
				<?php }else{?>
					<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="130" height="130" class="fl-l" alt="<?php print $dd["EVENT_NAME"]?>">
				<?php }?>
					   <span><?php print date("Y???m???d???",strtotime($dd["EVENT_POST_FROM"]))?>???</span>
						<h2><?php print cmStrimWidth($dd["EVENT_NAME"], 0, 100, '???')?></h2>
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


<!--????????????-->
		<div class="contents_box cf">
		<div class="inner_box cf">

			<div class="title2">
				<span>????????????????????????</span>
				<!--<img src="images/top2015/icon_kuchikomi.png" width="215" height="38">-->
				<h1>?????????????????????????????????????????????????????????????????????</h1>
				<a href="/kuchikomi-search.html">??? ??????????????????????????????</a>
			</div>

			<div class="slide_info">
			<ul class="slide2">
        <?php
        if (count($dspKArray) > 0) {
			foreach ($dspKArray as $kk) {
			//print_r($kk);
	?>
				<li>
				<a href="/kuchikomi-detail.html?k_id=<?php print $kk["KUCHIKOMI_ID"]?>">
				<?php if ($kk["KUCHIKOMI_PIC1"] != "") {?>
					<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kk["KUCHIKOMI_PIC1"]?>" width="130" height="130" class="fl-l"  alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
				<?php }else{?>
					<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="130" height="130" class="fl-l" alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
				<?php }?>
						<h2><B><?php print cmStrimWidth($kk["KUCHIKOMI_FACILITY_NAME"], 0, 20, '???')?></B></h2>
						<h2><?php print cmStrimWidth($kk["KUCHIKOMI_DETAIL"], 0, 100, '???')?></h2>
				</a>
				</li>
        <?php
			}
	}
	?>
			</ul>
			</div>
		</div>
		</div>



<!--???????????????-->

		<div class="contents_box cf">
		<div class="inner_box cf">

			<div class="title2">
				<span>????????????</span>
				<h1>?????????????????????????????????????????????????????????????????????????????????</h1>
				<a href="/job-search.html">??? ??????????????????????????????</a>
			</div>

			<div class="slide_info">
			<ul class="slide3">
        <?php
        if (count($dspArray) > 0) {
			foreach ($dspArray as $plandata) {
			//print_r($plandata);

	?>
				<li>
				<a href="/job-detail.html?company_id=<?php print $plandata["COMPANY_ID"]?>&jobplan_id=<?php print $plandata["JOBPLAN_ID"]?>">
				
				<?php if ($plandata["JOB_PIC2"] != "") {?>
					<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $plandata["JOB_PIC2"]?>" width="130" height="130" class="fl-l"  alt="<?php print $plandata["JOB_NAME"]?>">
					<!--<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="130" height="130" class="fl-l" alt="<?php print $plandata["JOB_NAME"]?>">-->
				<?php }else{?>
					<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="130" height="130" class="fl-l" alt="<?php print $plandata["JOB_NAME"]?>">
				<?php }?>
						<h2><B><?php print cmStrimWidth($plandata["JOB_NAME"], 0, 20, '???')?></B></h2>
						<h2><?php print cmStrimWidth($plandata["JOB_FEATURE"], 0, 100, '???')?></h2>
				</a>

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
	               		 <p>??????????????????????????????</p>
					<a href="https://cocotomo.net/regist.html"><img src="/images/front/regist_btn.png" width="150" alt="????????????"></a>
		           	 </li>
		           	 <li>
	               		 <p>????????????????????????</p>
	            			<a href="https://cocotomo.net/login.html"><img src="/images/front/login_btn.png" width="150" alt="??????????????????"></a>
	           		 </li>
	        	</ul>
	        </aside>
			<?php
// 				require_once('includes/box/login/loginBoxRight.php');
			}
			else {
			?>

		<aside id="status_cn">
				<img src="/images/front/corner_hana.png">??????????????????<B><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_HANDLENAME")?></B>??????
			</br>
			<ul>
				<li>
					<div class="point">
						???????????????????????????<span><?php 
						if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT")>0){
							print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT");
						}else {
							print 0;
						}?> P</span>
					</div>
				</li>
				<li>
					???<a href="https://cocotomo.net/mypoint.html">????????????????????????</a>
				</li>
			</ul>
			<ul class="menu">
				<li>
					???<a href="https://cocotomo.net/myhotel.html">????????????????????????????????????</a>
				</li>
				<li>
					???<a href="https://cocotomo.net/mybasic.html">????????????????????????</a>
				</li>
				<li>
					???<a href="https://cocotomo.net/mypage.html">?????????????????????</a>
				</li>
			</ul>
				<div id="logout">
						<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					        	<?=$inputs->submit("","logout","???????????????", "circle")?>
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
				???????????????(glass space???)????????????????????????????????????????????????????????????????????????????????????!!
			</div></a>
		</div>
-->

		<p align="center">???PR??????</p>
		<div id="pr">
		<ul>
			<li>
				<a href="http://cateringblog.ti-da.net/">
				<img src="images/top2015/pr_01.jpg" width="330" height="165"></br>
				<div class="caption">???????????????????????????????????????????????????????????????????????????????????????</div></a>
			</li>
			<li>
				<a href="http://www.cerulean-blue.co.jp/">
				<img src="images/top2015/pr_02.jpg" width="330" height="165"></br>
				<div class="caption">??????????????????????????????????????????????????????????????????????????????????????????OK!</div></a>
			</li>
			<li>
				<a href="http://www.regency-inc.com/kyushu/">
				<img src="images/top2015/pr_03.jpg" width="330" height="200"></a></br>
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
