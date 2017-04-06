<?php if ($couponBooking->getCount() > 0) {?>
<?php $k = 0;$can_cancel = 0;
//print_r($couponBooking->getCollection());?>

<!--<h3>
<?
if($title == ""){
	if($ad["BOOKINGCONT_STATUS"] == 2){
		$title = "この予約はキャンセル済みです。";
	}
	else if ($ad["BOOKINGCONT_STATUS"] == 3) {
		$title = "この予約はノーショーです。";
	}
	else if ($ad["BOOKINGCONT_STATUS"] == 4) {
		$title = "この予約は宿泊済みです。";
	}
	else if ($ad["BOOKINGCONT_STATUS"] == 6) {
		$title = "この予約は受入れ不可です。";
	}
	else {
		$title = "以下より予約をキャンセルします。";
	}
}

?></h3>-->

					<?php
					foreach ($couponBooking->getCollection() as $ad) {
						$rclass = '';
						if ($ad["COUPONBOOK_STATUS"] == 2) {
							//	キャンセル済み
							$rclass = 'class="bgLightGrey"';
						}
						
						if($ad["COUPONBOOK_STATUS"]==1 || $ad["COUPONBOOK_STATUS"]==5){
							$can_cancel = 1;
						}?>
						<?php }?>
					<?php }else {?>
					<?php }?>
			</form>
			<?php if ($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_STATUS") == 5 || $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") != "") {
			?>			
			リクエスト回答
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<tr>
			<th width="160" valign="top">
				<p>予約リクエスト回答</p>
			</th>
			<td align="left">
				<?php 
				if($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") == 1){
					print "予約可能";
				}
				else if($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") == 2){
					print "受入れ不可";
				}
				else{
					print "回答待ち";
				}
				//print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",1,$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") ,"予約可能") ?>
				&nbsp; <?php 
				//print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",2,$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") ,"受入れ不可") ?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>施設からのリクエスト回答</p>
			</th>
			<td align="left">
				<?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER") ?>
			</td>
			</tr>
			</table>
			<br/>
			<div><a href="javascript:history.go(-1);">予約情報一覧に戻る</a></div>
			<?php }?>
			<br/>
			
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
			<table cellspacing="0" cellpadding="5" class="tblInput edit" id="sortList" width="100%">
			<tr>
			<th width="160" valign="top">
				<p>クーポンID</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPON_ID_NUM")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>購入番号</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_ID")?>　　　　　　　　　　[購入日：<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_DATE")?>]</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>クーポン名</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_NAME")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>店舗名</p>
			</th>
			<td align="left">
				<p><B><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_NAME")?></B></br>
				住所： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_ADDRESS")?></br>
				電話番号： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_TEL")?></br>
				アクセス： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_ACCESS")?></br>
				営業時間： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_OPEN")?></br>
				定休日： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_HOLYDAY")?></br>
				</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>購入枚数</p>
			</th>
			<td align="left">
				<p><?php print number_format($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_NUM"))?> 枚</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>クーポン1枚あたりの料金</p>
			</th>
			<td align="left">
				<p><?php print number_format($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_PRICE"))?> 円</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>合計料金</p>
			</th>
			<td align="left">
				<p><?php print number_format($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_PRICE_ALL"))?> 円</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>購入者</p>
			</th>
			<td align="left">
				<?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME1")?>
				<?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME2")?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>有効期間</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE_FROM")?>～<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE_TO")?>迄</br>
				<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE_MEMO")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>利用条件</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>予約方法</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_RESERVE")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>クーポン内容</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_DETAIL")?></p>
			</td>
			</tr>
			</table>
			<br/>
			<!--<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center" class="bt-td">
						<?=$inputs->submit("","bookingConfirm","予約変更する", "circle")?>
					</td>
				</tr>
			</table> -->
			</form>
			<br/>
			<div><a href="javascript:history.go(-1);">予約情報一覧に戻る</a></div>