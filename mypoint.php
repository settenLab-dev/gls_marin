<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/pointHistory.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}


$collection = new collection($dbMaster);
$collection->setPost();
$collection->setByKey($collection->getKeyValue(),  "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));

$pointHistory = new pointHistory($dbMaster);
$pointHistory->selectList($collection);

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<title>会員情報ポイント履歴 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="mypoint">

        <!--日付・人数から検索-->
        <section class="box">
				<div class="inner">
        	<div id="hmenu_cn" class="radius10">
    	    	<menu class="mypge-menu">
	        		<li><a href="<?php print URL_PUBLIC?>mypage.html">マイページトップ</a></li>
	        		<li><a href="<?php print URL_PUBLIC?>mybasic.html">会員基本情報確認・変更</a></li>
        			<li><a href="<?php print URL_PUBLIC?>myhotel.html">宿泊・レジャー予約情報</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mycoupon.html">購入したクーポン</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mypoint.html">ポイント履歴</a></li>
        			<li><a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></li>
    	    	</menu>
	        	<div class="bt-logout_cn">
        			<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
        	         <p class="bt-td"><?=$inputs->submit("","logout","ログアウト", "circle")?></p>
    	       		</form>
	           	</div>
           	</div>

        	<h2 class="title">ポイント履歴</h2>
					<p class="bline">取得済みのポイント数の確認と、これから取得予定のポイントを確認することができます。</p>

					<section id="point" class="clearfix point">
						<ul class="point-no">
							<li>
								<div>
									<h3>現在ご利用いただけるポイント</h3>
									<p><strong><?php 
									if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT")>0){
										print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT");
									}else {
										print 0;
									}?></strong> ポイント</p>
								</div>
							</li>
							<li class="ss">
								※ポイントの有効期限は<br /><span>2017年4月30日</span>です！
							</li>
						</ul>

						<div class="point-afterList">
							<h3 class="radius10 sqtitle_blue">これから取得予定のポイント</h3>
							<ul>
								<!--<li><a href="#">2013/○/○以降○○ポイント　（宿泊予約：施設名-------）</a></li>
								<li><a href="#">2013/○/○以降○○ポイント　（宿泊予約：施設名-------）</a></li>
								<li><a href="#">2013/○/○以降○○ポイント　（イベント参加：イベント名-------）</a></li>
								<li><a href="#">2013/○/○以降○○ポイント　（提携サービス：サービス名-------）</a></li>-->
							</ul>
						</div>
					</section>

					<section class="point">
						<table class="pointtable">
							<thead>
								<tr>
									<th colspan="6">ポイント履歴</span></th>
								</tr>
							</thead>
							<tr>
								<th>区分</th>
								<th>サービス名</th>
								<th>ポイント</th>
								<th>ステータス</th>
								<th>付与日</th>
							</tr>
							<?php if ($pointHistory->getCount() > 0) {?>
								<?php foreach ($pointHistory->getCollection() as $ad) {?>
								<?php
								$rclass = '';
								if ($ad["POINT_HISTORY_STATUS"] == 3) {
									$rclass = 'class="bgLightGrey"';
								}
								?>
							<tr>
								<!--<td <?=$rclass?>><?=$ad["POINT_HISTORY_ID"]?></td>-->
								<td <?=$rclass?>>
									<?php
									if ($ad["POINT_HISTORY_DIVIDE"] == 1) {
										print "アフィリエイト";
									}
									if ($ad["POINT_HISTORY_DIVIDE"] == 2) {
										print "ホテル";
									}
									if ($ad["POINT_HISTORY_DIVIDE"] == 3) {
										print "管理より";
									}
									if ($ad["POINT_HISTORY_DIVIDE"] == 4) {
										print "ポイント交換特典";
									}
									?>
								</td>
								<td <?=$rclass?>><?=$ad["POINT_HISTORY_NAME"]?></td>
								<td <?=$rclass?>><?php 
								if ($ad["POINT_HISTORY_DIVIDE"] == 4) {
									print "-".$ad["POINT_HISTORY_NUM"];
								}
								else {
									print $ad["POINT_HISTORY_NUM"];
								}
								?></td>
								<td <?=$rclass?>>
									<?php
									if ($ad["POINT_HISTORY_STATUS"] == 1) {
										print "有効";
									}
									if ($ad["POINT_HISTORY_STATUS"] == 2) {
										print "期限切れ";
									}
									if ($ad["POINT_HISTORY_STATUS"] == 0) {
										print "-";
									}
									?>
								</td>
								<td <?=$rclass?>><?=$ad["POINT_HISTORY_DATE_REGIST"]?></td>
								<?php /*
								<td <?=$rclass?> align="center"><a href="pointHistoryEdit.html?id=<?=$ad["AFFILIATEASP_ID"]?>&key=<?=$ad["MEMBER_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
								*/?>
							</tr>
								<?php }?>
							<?php }else {?>
							<?php }?>
						</table>
						<!--<table class="pointtable">
							<thead>
								<tr>
									<th colspan="6">参加表明中のイベント<span>イベントポイントを獲得するには参加確認の回答をしてください。</span></th>
								</tr>
							</thead>
							<tr>
								<th>開催日</th>
								<th>イベント名</th>
								<th>ポイント</th>
								<th>確認方法</th>
								<th>&nbsp;</th>
								<th>回答期限</th>
							</tr>
							<tr>
								<td class="ctxt">2013/06/06</td>
								<td>イベント名：イベント名</td>
								<td class="rtxt">50</td>
								<td>アンケートに回答</td>
								<td class="w-sp"><button class="radius10" id="" name="">回答する</button><button class="radius10" id="" name="">参加をキャンセル</button></td>
								<td class="ctxt">2013/06/28</td>
							</tr>
							<tr>
								<td class="ctxt">2013/06/06</td>
								<td>イベント名：イベント名</td>
								<td class="rtxt">3</td>
								<td>当日ブースに訪問</td>
								<td>参加確認済み</td>
								<td class="ctxt">2013/06/28</td>
							</tr>
						</table>-->

						<ul class="point-infolink cf">
							<li><a href="affiliate-exchange.html"><img src="images/affiliate/affiliate-btn02.png" width="327" height="72" alt="ポイントの貯め方" /></a></li>
							<li><a href="save-points.html"><img src="images/affiliate/affiliate-btn01.png" width="327" height="72" alt="ポイントと特典を交換する" /></a></li>
						</ul>
  					</section>
  				</div>
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

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>