<?php if ($couponBooking->getCount() > 0) {?>
<?php $k = 0;$can_cancel = 0;
//print_r($couponBooking->getCollection());?>

<h3>
<?php
	if($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_STATUS") == 2){
		print "<font size=\"4.0em\" color=\"red\">【利用済みのクーポンです】</font>";
	}
	elseif ($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_STATUS") == 3) {
		print "<font size=\"4.0em\" color=\"red\">【有効期限が切れています】</font>";
	}
	elseif ($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_STATUS") == 4) {
		print "<font size=\"4.0em\" color=\"red\">【利用停止】</font>";
	}
	else {
		print "<font size=\"4.0em\" color=\"blue\">【このクーポンはご利用可能です】</font>";
		print "<form><input type=\"button\" value=\"このページを印刷\" onclick=\"window.print();\" /></form>";
	}
?>
</h3>

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
			<td><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_PIC")?>" width="156" height="116" alt="">
			</td>
			<td>
			<B>【クーポン名】<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_NAME")?></B></br>
			<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_CATCH")?>
			</td>
			</tr>
			<tr>
			<th width="100" valign="top">
				<p>クーポン番号<br/>(キーコード)</p>
			</th>
			<td>
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPON_ID_NUM")?> (キーコード：<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPON_KEY_CODE")?>)
<br/><br/>
				<font color="red">
					※ご予約の際は「ココトモのクーポン ココポン」を使う旨と、「クーポン番号（"cp"から始まる番号）」「購入者名」をお伝えください。<br/>
					※ご予約当日はこのページ(クーポン)を印刷してお持ちください。「キーコード」とご本人様の確認が必要となります。<br/>
					※ご予約・ご利用の際は「利用条件」「予約方法」をご確認ください。<br/>
				</font>
				</p>
			</td>
			</tr>
			<tr>
			<th width="100" valign="top">
				<p>購入番号</p>
			</th>
			<td>
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_ID")?>　(購入日：<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_DATE")?>)
</p>
			</td>
			</tr>
			<tr>
			<th width="100" valign="top">
				<p>購入者名</p>
			</th>
			<td>
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME1")?>　<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_NAME2")?>（<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_KANA1")?>　<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_KANA2")?>）</p>
			</td>
			</tr>
			<tr>
			<th width="100" valign="top">
				<p>合計金額</p>
			</th>
			<td>
				<p><?=number_format($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_PRICE_ALL"))?> 円　（<?=number_format($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_PRICE"))?>円×<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_NUM")?> 枚）</p>
			</td>
			</tr>
			<tr>
			<th width="100" valign="top">
				<p>支払金額</p>
			</th>
			<td>
				<p><?=number_format($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONBOOK_PRICE_ALL"))?> 円　(クレジットカード決済)</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>有効期間</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE_FROM")?>～<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE_TO")?>まで</br>
				<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE_MEMO")?></p>
			</td>
			</tr>
			<tr>
			</table>


			</br>
			<table cellspacing="0" cellpadding="5" class="tblInput edit" id="sortList" width="100%">
			<tr>
			<th width="160" valign="top">
				<p>店舗情報</p>
			</th>
			<td align="left">
				<p>店舗名：<B><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_NAME")?></B></br></br>
				住所： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_ADDRESS")?></br>
				電話番号： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_TEL")?></br>
				アクセス： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_ACCESS")?></br>
				営業時間： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_OPEN")?></br>
				定休日： <?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONSHOP_HOLYDAY")?></br></br>
				<font color="red">※ご予約・ご利用の際は「利用条件」「予約方法」をご確認ください。</br>
				※WEB予約のみの店舗では電話予約は受け付けておりませんのでご注意ください。</br>
				※ご予約の際は「ココトモのクーポン ココポン！」を使う旨と、「クーポン番号（"cp"から始まる番号）」「購入者名」をお伝えください。</font>
				</p>
			</td>
			</tr>
			<th width="160" valign="top">
				<p>利用条件</p>
			</th>
			<td align="left">
				<p><?= nl2br($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_USE"))?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>予約方法</p>
			</th>
			<td align="left">
				<p><?= nl2br($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_RESERVE"))?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>クーポン内容</p>
			</th>
			<td align="left">
				<p><?= nl2br($couponBooking->getByKey($couponBooking->getKeyValue(), "COUPONPLAN_DETAIL"))?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>決済方法</p>
			</th>
			<td align="left">
				<p>クレジットカード決済</p>
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