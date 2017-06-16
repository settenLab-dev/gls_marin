<?php
require_once('includes/applicationInc.php');

require_once(PATH_SLAKER_COMMON.'includes/lib/Pager/Pager.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();


require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}

// 予約したプランの取得
$collection = new collection($dbMaster);
if($_POST){
	$collection->setPost();
}
$collection->setByKey($collection->getKeyValue(), "MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));

$booking = new shopBooking($dbMaster);
$booking->selectList($collection);

$shopPlan = new shopPlan($dbMaster);

$arrBooking = array();
$arrPlan    = array();

if ($booking->getCount() > 0) {
	$arrBooking = $booking->getCollection();
	foreach($arrBooking as $booking_data){
		$plan_id    = $booking_data["SHOPPLAN_ID"];
		$company_id = $booking_data["COMPANY_ID"];
		
		$shopPlan->select($plan_id, "", $company_id);
		$shop_plan_data = $shopPlan->getCollection();
		
		$arrPlan[$plan_id] = array_shift($shop_plan_data);
	}
}

//	ページャ設定
// 表示件数
$perpage = $collection->getByKey($collection->getKeyValue(), "pageNum");
if(empty($perpage)){
	$perpage = 10;
}
// 現在のページ
$page = $collection->getByKey($collection->getKeyValue(), "pageID");
if(empty($page)){
	$page = 1;
}
$currentPage = 0;
if (!cmCheckNull($page) or !cmCheckPtn($page, CHK_PTN_NUM) or $page <= 0) {
	$currentPage = 0;
} else {
	$currentPage = $page-1;
}

$limit = ($currentPage * $perpage).",".$perpage;
// var_dump($limit);
$collection->setByKey($collection->getKeyValue(), "limit", $limit);
$collection->setByKey($collection->getKeyValue(), "limitptn", "plan");

//	ページャ取得
$pager_options = array(
		'mode'       => 'Jumping',              // 表示タイプ(Jumping/Sliding)
		'perPage'    => $perpage,               // 一ページ内で表示する件数
		'totalItems' => $booking->getMaxCount(),   // ページング対象データの総数
		'httpMethod' => 'POST',
		'importQuery'=> FALSE,
		'spacesBeforeSeparator'=> 2,
		'spacesAfterSeparator'=> 2,
		'prevImg'=> '<span class="prev">前へ</span>',
		'nextImg'=> '<span class="next">次へ</span>',
		// 		'extraVars'  =>$page_post
);
$pager =& Pager::factory($pager_options);
$navi = $pager->getLinks();

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
			<li><span>マイページ</span></li>
		</ul>
	
		
		<!-- side nav -->
		<div id="left">
			<div class="inner">
				<!-- <div class="notice">
					<p class="name">ニックネームさん</p>
					<p class="alert">未読メッセージがあります</p>
				</div>
				 -->
				<ul class="menu-list">
					<li><a href="<?php print URL_PUBLIC?>mypage.html">マイページトップ</a></li>
					<li><a href="<?php print URL_PUBLIC?>myreserve.html">予約の確認</a></li>
					<?php if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_STATUS") != 4): ?>
						<!-- <li><a href="<?php print URL_PUBLIC?>myticket.html">購入したチケット</a></li> -->
						<li><a href="<?php print URL_PUBLIC?>mybasic.html">会員基本情報確認・変更</a></li>
						<!-- <li><a href="<?php print URL_PUBLIC?>mybasic.html">体験レポートの投稿</a></li> -->
						<li><a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></li>
					<?php endif; ?>
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
			<?php if (count($arrBooking) > 0) {?>
			
			<?php if ($booking->getErrorCount() > 0) {?>
				<?php print create_error_caption($booking->getError())?>
			<?php }?>
			<table cellspacing="0" cellpadding="5" class="tblInput booking" id="sortList" style="width: 780px;">
				<thead>
					<tr>
						<th width=""><p>予約番号</p></th>
						<th width=""><p>催行会社名</p></th>
						<th width=""><p>催行日</p></th>
						<th><p>プラン</p></th>
						<th width=""><p>人数</p></th>
						<th width=""><p>料金合計</p></th>
						<th width=""><p>ｽﾃｰﾀｽ</p></th>
						<th width=""><p>予約日</p></th>
						<th width=""><p>詳細</p></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($booking->getCount() > 0) {?>
						<?php foreach ($booking->getCollection() as $ad): ?>
							<?php if ($ad["BOOKING_STATUS"] != 9){ ?>
								<?php
									$rclass = '';
									if ($ad["BOOKING_STATUS"] == 3 || $ad["BOOKING_STATUS"] == 9) {
										$rclass = 'class="bgLightGrey"';
									}
									$shopTarget = new shop($dbMaster);
									$shopTarget->select($ad["COMPANY_ID"]);
									$shop_name = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME");
								?>
								<tr>
									<td <?php echo $rclass; ?>><?php echo $ad["BOOKING_CODE"]; ?></td>
									<td <?php echo $rclass; ?>><?php echo $shop_name; ?></td>
									<td <?php echo $rclass; ?>><?php echo $ad["BOOKING_DATE"]; ?></td>
									<td <?php echo $rclass; ?>><?php echo $ad["SHOPPLAN_NAME"]; ?></td>
									<td <?php echo $rclass; ?>>
										<?php if($ad["SHOP_PRICETYPE_KIND"] == 1):?>
											<?php echo $ad["BOOKING_PRICEPERSON1"]+$ad["BOOKING_PRICEPERSON2"]+$ad["BOOKING_PRICEPERSON3"]+$ad["BOOKING_PRICEPERSON4"]+$ad["BOOKING_PRICEPERSON5"]+$ad["BOOKING_PRICEPERSON6"]; ?> 人
										<?php elseif($ad["SHOP_PRICETYPE_KIND"] == 2):?>
											<?php echo $ad["BOOKING_PRICEPERSON7"]; ?> 組(追加:<?php echo $ad["BOOKING_PRICEPERSON8"]; ?> 人)
										<?php endif;?>
									</td>
									<td <?php echo $rclass; ?>><?php echo number_format($ad["BOOKING_ALL_MONEY"]); ?> 円</td>
									<td <?php echo $rclass; ?>>
										<?php
										if ($ad["BOOKING_STATUS"] == 1) {
											print '<img src="./images/mypage/icon/icon-completion.png" />';
										}
										elseif ($ad["BOOKING_STATUS"] == 2) {
											print '<img src="./images/mypage/icon/icon-cancel.png" />';
										}
										elseif ($ad["BOOKING_STATUS"] == 3) {
											print '<img src="./images/mypage/icon/icon-hide.png" />';
										}
										elseif ($ad["BOOKING_STATUS"] == 4) {
											print '<img src="./images/mypage/icon/icon-already.png" />';
										}
										elseif ($ad["BOOKING_STATUS"] == 5) {
											print '<img src="./images/mypage/icon/icon-wait.png" />';
										}
										elseif ($ad["BOOKING_STATUS"] == 6) {
											print '<img src="./images/mypage/icon/icon-unjustifiable.png" />';
										}
										elseif ($ad["BOOKING_STATUS"] == 9) {
											print '<img src="./images/mypage/icon/icon-hide.png" />';
										}
										?>
									</td>
									<td <?php echo $rclass; ?>><?php echo $ad["BOOKING_DATE_START"]; ?></td>
									<td <?php echo $rclass; ?> align="center">
										<?php if ($ad["BOOKING_STATUS"] != 9){ ?>
											<?php $edit_html_name = (strstr($hotel_name,'ツアー'))?'myactbookingedit':'myreserveedit';?>
											<a href="<?php echo $edit_html_name; ?>.html?id=<?php echo $ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?php echo $inputs->button("","","予約の確認","circle")?></a>
										<?php }else{ ?>
											予約失敗
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						<?php endforeach; ?>
					<?php }?>
				</tbody>
			</table>
			
			<?php } else { ?>
				<p>予約・申込履歴がありません。</p>
			<?php } ?>
			
		</div>
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
