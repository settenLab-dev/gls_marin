<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$collection = new collection($db);
$collection->setPost();

$targetId = "";

$coupon = new coupon($dbMaster);
	$coupon->selectListPublicCoupon($collection);

//print_r($coupon->getCollection());

$companyCnt = 0;
$planCnt = 0;
$dspArray = array();
if ($coupon->getCount() > 0) {
	foreach ($coupon->getCollection() as $data) {
		$planCnt++;
		$dspArray[$planCnt]["COMPANY_ID"] = $data["COMPANY_ID"];
		$dspArray[$planCnt]["COUPON_NAME"] = $data["COUPON_NAME"];
		$dspArray[$planCnt]["COUPON_ADDRESS"] = $data["COUPON_ADDRESS"];
		$dspArray[$planCnt]["COUPONPLAN_ID"] = $data["COUPONPLAN_ID"];
		$dspArray[$planCnt]["COUPONPLAN_SHOP_LIST"] = $data["COUPONPLAN_SHOP_LIST"];
		$dspArray[$planCnt]["COUPONPLAN_TYPE"] = $data["COUPONPLAN_TYPE"];
		$dspArray[$planCnt]["COUPONPLAN_PIC2"] = $data["COUPONPLAN_PIC2"];
		$dspArray[$planCnt]["COUPONPLAN_SALE_FROM"] = $data["COUPONPLAN_SALE_FROM"];
		$dspArray[$planCnt]["COUPONPLAN_SALE_TO"] = $data["COUPONPLAN_SALE_TO"];
		$dspArray[$planCnt]["COUPONPLAN_DEAL_SP"] = $data["COUPONPLAN_DEAL_SP"];
		$dspArray[$planCnt]["COUPONPLAN_PROVIDE_FLG"] = $data["COUPONPLAN_PROVIDE_FLG"];
		$dspArray[$planCnt]["COUPONPLAN_PROVIDE_MAX"] = $data["COUPONPLAN_PROVIDE_MAX"];
		$dspArray[$planCnt]["COUPONPLAN_PROVIDE_SELL"] = $data["COUPONPLAN_PROVIDE_SELL"];
		$dspArray[$planCnt]["COUPONPLAN_USE_END"] = $data["COUPONPLAN_USE_END"];
		$dspArray[$planCnt]["COUPONPLAN_POSITION"] = $data["COUPONPLAN_POSITION"];
		$dspArray[$planCnt]["COUPONPLAN_NAME"] = $data["COUPONPLAN_NAME"];

		$dspArray[$planCnt]["COUPONPLAN_DETAIL"] = $data["COUPONPLAN_DETAIL"];
		$dspArray[$planCnt]["COUPONPLAN_CATCH"] = $data["COUPONPLAN_CATCH"];
		$dspArray[$planCnt]["COUPONPLAN_USE"] = $data["COUPONPLAN_USE"];
		$dspArray[$planCnt]["COUPONPLAN_RESERVE"] = $data["COUPONPLAN_RESERVE"];
		$dspArray[$planCnt]["COUPONPLAN_CATEGORY_LIST"] = $data["COUPONPLAN_CATEGORY_LIST"];
		$dspArray[$planCnt]["COUPONPLAN_AREA_LIST"] = $data["COUPONPLAN_AREA_LIST"];
		$dspArray[$planCnt]["COUPONPLAN_SELL_PRICE"] = $data["COUPONPLAN_SELL_PRICE"];
		$dspArray[$planCnt]["COUPONPLAN_DEAL_PRICE"] = $data["COUPONPLAN_DEAL_PRICE"];
	}
}

//print_r($data);

$inputs = new inputs(); ?>


<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>ココトモのクーポン ココポン 沖縄限定のお得な購入クーポン♪ | 地域限定！お得なレジャーとグルメの専門サイト「ココトモ」</title>
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

<!--count-->
<script type="text/javascript" src="<?=URL_PUBLIC?>js/jquery-1.5.1.js"></script>
<script src="<?=URL_PUBLIC?>js/java.js"></script>
<!--/count-->
</head>

<body id="top" style="background:none;border-top:none;">

<!--count-->
<input type="hidden" id="TimerStart" value="<?php echo date('Y/m/d H:i:s');?>" >
<!--/count-->


<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->
<!-- InstanceEndEditable -->

<!--Content-->
<div id="content" class="clearfix">
<!--index-image-->

<section>
    <div class="mainimage">
    	<img src="./images/index2016/img_cocopon.jpg" width="1323" height="250" alt="沖縄県民限定クーポン！ココトモ！のクーポン！ココポン！" /></a>
	</div>
</section>

<!--/index-image-->

		<!--<div class="indeximage_box">
		<img src="./images/front/mainimage.jpg" width="1078" height="250" alt="沖縄県民限定「簡単無料登録」沖縄をもっと楽しく" /><a href="intro.html"><img src="./images/front/mainimage_bt.png" width="144" height="34" alt="詳しくはこちら" /></a>
		</div>-->

<!-- /mainimage-->




<!-- Left side-->

		<div id="content-ln">
			<aside class="recommend-mon">
				<div>
				<img src="./images/coupon/howto.png" width="223" height="878" alt="クチコミ" /></a><br/><br/>
			<a href="/coupon-qa.html" target="blank">
				<img src="./images/coupon/qa_img.png" width="223" alt="Q&A" />
			</a><br/><br/>
			<a href="/coupon-terms.html" target="blank">
				<img src="./images/coupon/term_img.png" width="223" alt="ご利用規約" />
			</a>
				</div>
			</aside>
		</div>

<!-- /Left side-->

<!--main-->
<!--Right side-->
	<main id="content-r" style="height:2000px;">
	<!--<img src="./images/coupon/info.png" width="1078" height="167" alt="インフォメーション" />-->
<!--pickup-->

<!--/pickup-->

<!--all info-->
	<!--<img src="./images/coupon/list_title.png" width="1079" height="46" alt="クーポン一覧" />
	3件中　1～3件を表示</br>-->

   <article id="coupon_list">

	<div class="top_pickup">

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
			<?php if ($plandata["COUPONPLAN_POSITION"] == "1"){?>

	<div class="first">
		<?php $formname = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["COUPONPLAN_ID"];?>

		<?php if($plandata["COUPONPLAN_TYPE"] == "2"){?>
		<form action="coupon-present.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
		<?php }else {?>
		<form action="coupon-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
		<?php }?>
		<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();">
	            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	            	<?php print $inputs->hidden("COUPONPLAN_ID", $plandata["COUPONPLAN_ID"])?>

					<?php
					$arShop = array();
					$arTemp = explode(":", $plandata["COUPONPLAN_SHOP_LIST"]);
					if (count($arTemp) > 0) {
						foreach ($arTemp as $data) {
							if ($data != "") {
								$arShop[$data] = $data;
							}
						}
					}

					$shopCnt = 0;
					if (count($arShop) > 0) {
						foreach ($arShop as $d) {
							$shopCnt++;
					?>
			            	<?php print $inputs->hidden("COUPONSHOP_ID", $d)?>
					<?php
							if ($shopCnt >= 2) break;
						}
					}
					?>
		<div class="no1">
			<h2><U><?php print $plandata["COUPON_NAME"]?></U>
				<?php 
						$arCategory = "";
						$arTemp = explode(":", $plandata["COUPONPLAN_CATEGORY_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arCategory[$data] = $data;
        							}
        						}
		        			}
						$dataCategory = cmCouponCategory();
						if (count($dataCategory) > 0) {
							foreach ($dataCategory as $k=>$v) {
								if ($arCategory[$k] != "") {
									if ($k == 1 ){
									   print "<p3 class=\"ci_hotel\">".$v."</p3>";
									}
									elseif ($k == 2 ){
									   print "<p3 class=\"ci_leisure\">".$v."</p3>";
									}
									elseif ($k == 3 ){
									   print "<p3 class=\"ci_gourmet\">".$v."</p3>";
									}
									elseif ($k == 4 ){
									   print "<p3 class=\"ci_shopping\">".$v."</p3>";
									}
									elseif ($k == 5 ){
									   print "<p3 class=\"ci_beauty\">".$v."</p3>";
									}
									elseif ($k == 6 ){
									   print "<p3 class=\"ci_esthe\">".$v."</p3>";
									}
									elseif ($k == 7 ){
									   print "<p3 class=\"ci_massage\">".$v."</p3>";
									}
									elseif ($k == 8 ){
									   print "<p3 class=\"ci_school\">".$v."</p3>";
									}
									elseif ($k == 9 ){
									   print "<p3 class=\"ci_lifeservice\">".$v."</p3>";
									}
									else{
									   print "<p3 class=\"ci_etc\">".$v."</p3>";
									}
								}
							}
						}
					?>
			</h2>
			<div class="pic"><img src="http://common.cocotomo.net/images/<?php print $plandata["COUPONPLAN_PIC2"]?>" width="485" height="250"></div>
				<div class="detail">
					<div class="off">
						<?php 
						if ($plandata["COUPONPLAN_DEAL_SP"] == 1){?>
						<span>特別<br/>価格</span>
						<?php }elseif ($plandata["COUPONPLAN_DEAL_SP"] == 2){?>
						<span>
						<?php print floor(100-(($plandata["COUPONPLAN_SELL_PRICE"]/$plandata["COUPONPLAN_DEAL_PRICE"])*100))?>
						</span>%</br>OFF
						<?php }else{}?>
					</div>
					<div class="price">
		 				<ul>
							<?php if ($plandata["COUPONPLAN_PROVIDE_SELL"] > 0){?>
							<li><span><?php print $plandata["COUPONPLAN_PROVIDE_SELL"]?></span>枚売れてます！</li>
							<?php }else{}?>
							<li>
								<?php if ($plandata["COUPONPLAN_DEAL_SP"] == 1){?>
									<br/>
									<span class="kakaku" style="font-size:1.5em;"><?php print $plandata["COUPONPLAN_SELL_PRICE"]?>円</span>
								<?php }elseif ($plandata["COUPONPLAN_DEAL_SP"] == 2){?>
									<s><?php print $plandata["COUPONPLAN_DEAL_PRICE"]?>円</s>≫<br/>
									<span class="kakaku" style="font-size:1.5em;"><?php print $plandata["COUPONPLAN_SELL_PRICE"]?>円</span>
								<?php }else{}?>
							</li>
						</ul>
					</div>
					<div class="feature"><?php print $plandata["COUPONPLAN_CATCH"]?></div>			
				</div>
		</div>
		</a>
		</form>
	</div>
		        <?php }?>
	        <?php }?>
        <?php }?>

	<div class="second">

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
			<?php if ($plandata["COUPONPLAN_POSITION"] == "2"){?>

		<?php $formname = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["COUPONPLAN_ID"];?>
		<form action="coupon-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
		<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();">
	            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	            	<?php print $inputs->hidden("COUPONPLAN_ID", $plandata["COUPONPLAN_ID"])?>
					<?php
					$arShop = array();
					$arTemp = explode(":", $plandata["COUPONPLAN_SHOP_LIST"]);
					if (count($arTemp) > 0) {
						foreach ($arTemp as $data) {
							if ($data != "") {
								$arShop[$data] = $data;
							}
						}
					}

					$shopCnt = 0;
					if (count($arShop) > 0) {
						foreach ($arShop as $d) {
							$shopCnt++;
					?>
			            	<?php print $inputs->hidden("COUPONSHOP_ID", $d)?>
					<?php
							if ($shopCnt >= 2) break;
						}
					}
					?>

		<div class="no2">
			<h2><U><?php print $plandata["COUPON_NAME"]?></U>
				<?php 
						$arCategory = "";
						$arTemp = explode(":", $plandata["COUPONPLAN_CATEGORY_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arCategory[$data] = $data;
        							}
        						}
		        			}
						$dataCategory = cmCouponCategory();
						if (count($dataCategory) > 0) {
							foreach ($dataCategory as $k=>$v) {
								if ($arCategory[$k] != "") {
									if ($k == 1 ){
									   print "<p3 class=\"ci_hotel\">".$v."</p3>";
									}
									elseif ($k == 2 ){
									   print "<p3 class=\"ci_leisure\">".$v."</p3>";
									}
									elseif ($k == 3 ){
									   print "<p3 class=\"ci_gourmet\">".$v."</p3>";
									}
									elseif ($k == 4 ){
									   print "<p3 class=\"ci_shopping\">".$v."</p3>";
									}
									elseif ($k == 5 ){
									   print "<p3 class=\"ci_beauty\">".$v."</p3>";
									}
									elseif ($k == 6 ){
									   print "<p3 class=\"ci_esthe\">".$v."</p3>";
									}
									elseif ($k == 7 ){
									   print "<p3 class=\"ci_massage\">".$v."</p3>";
									}
									elseif ($k == 8 ){
									   print "<p3 class=\"ci_school\">".$v."</p3>";
									}
									elseif ($k == 9 ){
									   print "<p3 class=\"ci_lifeservice\">".$v."</p3>";
									}
									else{
									   print "<p3 class=\"ci_etc\">".$v."</p3>";
									}
								}
							}
						}
					?>
			</h2>
			<div class="pic"><img src="http://common.cocotomo.net/images/<?php print $plandata["COUPONPLAN_PIC2"]?>" width="175" height="120"></div>
				<div class="detail">
					<div class="off">
						<?php 
						if ($plandata["COUPONPLAN_DEAL_SP"] == 1){?>
						<span>特別<br/>価格</span>
						<?php }elseif ($plandata["COUPONPLAN_DEAL_SP"] == 2){?>
						<span>
						<?php print floor(100-(($plandata["COUPONPLAN_SELL_PRICE"]/$plandata["COUPONPLAN_DEAL_PRICE"])*100))?>
						</span>%</br>OFF
						<?php }else{}?>
					</div>
					<div class="price">
		 				<ul>
							<?php if ($plandata["COUPONPLAN_PROVIDE_SELL"] > 0){?>
							<li><span><?php print $plandata["COUPONPLAN_PROVIDE_SELL"]?></span>枚売れてます！</li>
							<?php }else{}?>
							<li>
								<?php if ($plandata["COUPONPLAN_DEAL_SP"] == 1){?>
									<br/>
									<span class="kakaku" style="font-size:1.5em;"><?php print $plandata["COUPONPLAN_SELL_PRICE"]?>円</span>
								<?php }elseif ($plandata["COUPONPLAN_DEAL_SP"] == 2){?>
									<s><?php print $plandata["COUPONPLAN_DEAL_PRICE"]?>円</s>≫
									<span class="kakaku" style="font-size:1.5em;"><?php print $plandata["COUPONPLAN_SELL_PRICE"]?>円</span>
								<?php }else{}?>
							</li>
						</ul>
					</div>
					<div class="feature"><?php print $plandata["COUPONPLAN_CATCH"]?></div>			
				</div>
		</div>
		</a>
	        	</form>
		        <?php }?>
	        <?php }?>
        <?php }?>
	</div>

	<div class="other">
	<div class="third">

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
			<?php if ($plandata["COUPONPLAN_POSITION"] == "3"){?>

		<?php $formname = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["COUPONPLAN_ID"];?>
	     	<form action="coupon-detail.html" method="post" id="<?php print $formname?>" name="<?php print $formname?>">
		<a href="javascript:void(0)" onclick="document.<?php print $formname?>.submit();">
	            	<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
	            	<?php print $inputs->hidden("COUPONPLAN_ID", $plandata["COUPONPLAN_ID"])?>

					<?php
					$arShop = array();
					$arTemp = explode(":", $plandata["COUPONPLAN_SHOP_LIST"]);
					if (count($arTemp) > 0) {
						foreach ($arTemp as $data) {
							if ($data != "") {
								$arShop[$data] = $data;
							}
						}
					}

					$shopCnt = 0;
					if (count($arShop) > 0) {
						foreach ($arShop as $d) {
							$shopCnt++;
					?>
			            	<?php print $inputs->hidden("COUPONSHOP_ID", $d)?>
					<?php
							if ($shopCnt >= 2) break;
						}
					}
					?>
		<div class="no3">
			<h2>
				<?php 
						$arCategory = "";
						$arTemp = explode(":", $plandata["COUPONPLAN_CATEGORY_LIST"]);
        					if (count($arTemp) > 0) {
        						foreach ($arTemp as $data) {
        							if ($data != "") {
        								$arCategory[$data] = $data;
        							}
        						}
		        			}
						$dataCategory = cmCouponCategory();
						if (count($dataCategory) > 0) {
							foreach ($dataCategory as $k=>$v) {
								if ($arCategory[$k] != "") {
									if ($k == 1 ){
									   print "<p3 class=\"ci_hotel\">".$v."</p3>";
									}
									elseif ($k == 2 ){
									   print "<p3 class=\"ci_leisure\">".$v."</p3>";
									}
									elseif ($k == 3 ){
									   print "<p3 class=\"ci_gourmet\">".$v."</p3>";
									}
									elseif ($k == 4 ){
									   print "<p3 class=\"ci_shopping\">".$v."</p3>";
									}
									elseif ($k == 5 ){
									   print "<p3 class=\"ci_beauty\">".$v."</p3>";
									}
									elseif ($k == 6 ){
									   print "<p3 class=\"ci_esthe\">".$v."</p3>";
									}
									elseif ($k == 7 ){
									   print "<p3 class=\"ci_massage\">".$v."</p3>";
									}
									elseif ($k == 8 ){
									   print "<p3 class=\"ci_school\">".$v."</p3>";
									}
									elseif ($k == 9 ){
									   print "<p3 class=\"ci_lifeservice\">".$v."</p3>";
									}
									else{
									   print "<p3 class=\"ci_etc\">".$v."</p3>";
									}
								}
							}
						}
					?> <U><?php print $plandata["COUPON_NAME"]?></U></h2>
			<div class="pic"><img src="http://common.cocotomo.net/images/<?php print $plandata["COUPONPLAN_PIC2"]?>" width="235" height="160"></div>
				<div class="detail">
					<div class="off">
						<?php 
						if ($plandata["COUPONPLAN_DEAL_SP"] == 1){?>
						<span>特別<br/>価格</span>
						<?php }elseif ($plandata["COUPONPLAN_DEAL_SP"] == 2){?>
						<span>
						<?php print floor(100-(($plandata["COUPONPLAN_SELL_PRICE"]/$plandata["COUPONPLAN_DEAL_PRICE"])*100))?>
						</span>%</br>OFF
						<?php }else{}?>
					</div>
					<div class="price">
		 				<ul>
							<?php if ($plandata["COUPONPLAN_PROVIDE_SELL"] > 0){?>
							<li><span><?php print $plandata["COUPONPLAN_PROVIDE_SELL"]?></span>枚売れてます！</li>
							<?php }else{}?>
							<li>
								<?php if ($plandata["COUPONPLAN_DEAL_SP"] == 1){?>
									<br/>
									<span class="kakaku" style="font-size:1.5em;"><?php print $plandata["COUPONPLAN_SELL_PRICE"]?>円</span>
								<?php }elseif ($plandata["COUPONPLAN_DEAL_SP"] == 2){?>
									<s><?php print $plandata["COUPONPLAN_DEAL_PRICE"]?>円</s>≫
									<span class="kakaku" style="font-size:1.5em;"><?php print $plandata["COUPONPLAN_SELL_PRICE"]?>円</span>
								<?php }else{}?>
							</li>
						</ul>
					</div>
					<div class="feature"><?php print $plandata["COUPONPLAN_CATCH"]?></div>			
				</div>
		</div>
		</a>
	        	</form>
		        <?php }?>
	        <?php }?>
        <?php }?>
	</div>
	</div>


	</div>



   </article>



<!--/all info-->

	</main>
<!-- /main-->

	</div>
<!--/Right side-->
<!-- /735-->

	<!-- InstanceEndEditable -->
    <!--/main-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->
</body>
<!-- InstanceEnd --></html>
