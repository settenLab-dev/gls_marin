<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

/*
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}
*/

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_detail.php"); ?>
<title>マイページ</title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->
<!-- InstanceEndEditable -->

<!--content-->
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
    <main id="content" class="search">

    <ul id="panlist">
        <li><a href="/">TOP</a></li>
        <li><span>検索結果</span></li>
    </ul>

  
   <!-- side nav -->
    <div id="left">
	<div class="inner">
   	    		<div class="notice">
   	    			<p class="name">ニックネームさん</p>
   	    			<p class="alert">未読メッセージがあります</p>
      			</div>
							<ul class="menu-list">
								<li><a href="<?php print URL_PUBLIC?>mypage.html">マイページトップ</a></li>
								<li><a href="<?php print URL_PUBLIC?>myreserve.html">予約の確認</a></li>
								<li><a href="<?php print URL_PUBLIC?>myticket.html">購入したチケット</a></li>
								<li><a href="<?php print URL_PUBLIC?>mybasic.html">登録情報の設定</a></li>
								<li><a href="<?php print URL_PUBLIC?>mybasic.html">体験レポートの投稿</a></li>
								<li><a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></li>
								<li>
								 <form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
									 <p class="bt-td"><?=$inputs->submit("","logout","ログアウト", "circle")?></p>
								 </form>
								</li>
							</ul>

    </div>
    </div>
    
<div id="right">
	
        <div class="search-result sort_list">
          <h2 class="result-title">予約・申し込み履歴</h2>

 	  	<?php $scope = $pager->getOffsetByPageId()?>
        </div>

<ul class="search-result">

        <?php if (count($dspArray) > 0) {?>
		<?php foreach ($dspArray as $plandata) {?>
        <!--item-->
		<?php //print_r($plandata);?>

    <li class="plan-result">

    	<div class="inner">
			<div class="plan-title">
			  <h2 class="title_search">
						<?php $formplan = "frm".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
						<form action="plan-detail.html?cid=<?php print $plandata["COMPANY_ID"];?>&pid=<?php print $plandata["SHOPPLAN_ID"];?>&num=<?php print $collection->getByKey($collection->getKeyValue(), "priceper_num");?>" method="post" id="<?php print $formplan?>" name="<?php print $formplan?>">
							<?php /*<span class="new">NEW</span>*/?><a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><?php print $plandata["SHOPPLAN_NAME"]?></a>
							<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
							<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
							<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
							<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
									<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
							<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
							<?php print $inputs->hidden("calender_mon", $plandata["money_all"])?>
						</form>
			  </h2>
			</div>
		  
			<div class="plan-shop">
					<?php $formshop = "frmSearch".$plandata["COMPANY_ID"]."_".$plandata["SHOPPLAN_ID"];?>
					<form action="plan-detail.html?cid=<?php print $plandata["COMPANY_ID"];?>&pid=<?php print $plandata["SHOPPLAN_ID"];?>&num=<?php print $collection->getByKey($collection->getKeyValue(), "priceper_num");?>" method="post" id="<?php print $formshop?>" name="<?php print $formshop?>">
					<h3><a href="javascript:void(0)" onclick="document.<?php print $formshop?>.submit();"><?php print $plandata["SHOP_NAME"]?></a></h3>
						<?php print $inputs->hidden("COMPANY_ID", $plandata["COMPANY_ID"])?>
						<?php print $inputs->hidden("SHOP_ID", $plandata["SHOP_ID"])?>
						<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
						<?php print $inputs->hidden("SHOPPLAN_ID", $plandata["SHOPPLAN_ID"])?>
						<?php print $inputs->hidden("search_date", $collection->getByKey($collection->getKeyValue(), "search_date"))?>
						<?php print $inputs->hidden("undecide_sch", $collection->getByKey($collection->getKeyValue(), "undecide_sch"))?>
						<?php print $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"))?>
					</form>
			</div>

			<div class="plan-img">
					<?php if ($plandata["SHOPPLAN_PIC1"] != "" || $plandata["SHOPPLAN_PIC1"] != "") {?>
						<a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><img src="<?php print URL_SLAKER_COMMON."/images/".$plandata["SHOPPLAN_PIC1"]?>" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
					<?php }else{?>
						<a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();"><img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" class="fl-l" alt="<?php print $plandata["SHOPPLAN_NAME"]?>"></a>
					<?php }?>

					<p><?php $fromDate = cmDateDivide($plandata["SHOPPLAN_SALE_FROM"])?>
						<?php $toDate = cmDateDivide($plandata["SHOPPLAN_SALE_TO"])?>
						<?php print $fromDate["y"]."年".$fromDate["m"]."月".$fromDate["d"]."日"?>～<?php print $toDate["y"]."年".$toDate["m"]."月".$toDate["d"]."日"?>まで
					</p>
			</div>

			<div class="plan-contena">

					<p class="plan-disc"><?php print cmStrimWidth($plandata["SHOPPLAN_DISCRIPTION"], 0, 272, '…')?></p>

					<div class="box_detail">
						<div class="plan-address">
							<p><i class="fa fa-map-marker fa-1" aria-hidden="true"></i> 東京都中央区銀座5-10-1プリンスビル3階(サンプル)</p>
						</div>
						<ul>
							<li>
								<p>
									【所要時間】1時間半～
								</p>
							</li>
							<li>
								<p>
									【対象年齢】1時間半～
								</p>
							</li>
							<li>
								<p>
									【催行人数】1時間半～
								</p>
							</li>
						</ul>
					</div>
					<ul class="box_submit">
						<li class="plan-price">
									  <span class=""><span class="price"><?php print number_format($plandata["money_all"])?></span>円<span class="tax">(税込)～</span></span>
						</li>
						<li class="plan-btn">
									  <a href="javascript:void(0)" onclick="document.<?php print $formplan?>.submit();">詳しく見る</a>
						</li>
					</ul>
  			 </div>
		</div>
    </li>

                <!--/item-->
	        <?php }?>
        <?php }?>

</ul>


        <?php if ($navi["back"] != "" or $navi["next"] != "") {?>
        <ul class="navigation-se clearfix">
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
		
		
		<div class="nav_cont">
		 <ul class="navigation-se">
			 <li class="prev"><a href="#">前へ</a></li>
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
			 <li class="next"><a href="#">次へ</a></li>
        </ul>
	   </div>
</div>



</div>
  </main>

        <section class="menu-left">
			<div class="inner">
	       	</div>
		</section>
		<section id="menu-right">
	        	<h2 class="title_def">予約・お申込み履歴</h2>
        		<div class="inner_box">

	        			<h3 class="title_def">店舗名</h3>
	        		　　　<img src="/images/common/test.png" alt="">
	        		　　　住所
	        		　　　営業時間
	        		　　　定休日	        		　　　
	        		　　　
	        		　　　プラン名
	        		　　　ステータス
	        		　　　催行日
	        		　　　申込日
	        		　　　合計金額
     		　　　        		　　　
	        		　　　詳細を確認

       	
       	
       	
       	
       	
       	
       	
       	
       	
       	
        	
	        	
        		</div>
        	</div>
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
