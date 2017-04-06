<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th><p>予約番号</p></th>
			<th><p>購入者名</p></th>
			<th><p>クーポンID</p></th>
			<th><p>クーポン名</p></th>
			<th><p>購入数</p></th>
			<th><p>合計金額</p></th>
			<th><p>決済状況</p></th>
			<th><p>クーポン番号</p></th>
			<th><p>使用状況</p></th>
			<th><p>購入日</p></th>
			<th><p>使用日</p></th>
			<th width="30"><p>編集</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($booking->getCount() > 0) {?>
			<?php foreach ($booking->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["BOOKING_STATUS"] != 9) {
			if ($ad["BOOKING_STATUS"] == 3 || $ad["BOOKING_STATUS"] == 9) {
				$rclass = 'class="bgLightGrey"';
			}
			
//			$collection = new collection($dbMaster);
//			$collection->setByKey($collection->getKeyValue(), "HOTELPLAN_ID", $ad["HOTELPLAN_ID"]);
//			
//			$hotelPlan = new hotelPlan($dbMaster);
//			$hotelPlan->selectList($collection);
//			print_r($ad);
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_ID"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NAME1"]?><?=$ad["BOOKING_NAME2"]?><br/>(<?=$ad["BOOKING_KANA1"]?><?=$ad["BOOKING_KANA2"]?>)</td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE"]."<br/>".$ad["BOOKING_CHECKIN"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NUM_NIGHT"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NUM_ROOM"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_NAME"]?><?=$ad["TL_PLAN_NAME"]?></td>
		<?php if($ad["BOOKING_LINK"] == "" ){?>
			<td <?=$rclass?>><?=$ad["ROOM_NAME"]?></td>
		<?php }else{?>
			<td <?=$rclass?>><?=$ad["TL_ROOM_NAME"]?></td>
		<?php }?>
			<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM1"]+$ad["BOOKINGCONT_NUM2"]+$ad["BOOKINGCONT_NUM3"]+$ad["BOOKINGCONT_NUM4"]+$ad["BOOKINGCONT_NUM5"]+$ad["BOOKINGCONT_NUM6"]+$ad["BOOKINGCONT_NUM7"]+$ad["BOOKINGCONT_NUM8"]?></td>
			<td <?=$rclass?>><?=number_format($ad["BOOKING_MONEY"])?></td>
			<td <?=$rclass?>>
				<?php
				if ($ad["BOOKING_STATUS"] == 1) {
					print "予約<br/>完了";
				}
				elseif ($ad["BOOKING_STATUS"] == 2) {
					print "ｷｬﾝｾﾙ";
				}
				elseif ($ad["BOOKING_STATUS"] == 3) {
					print "ﾉｰｼｮｰ";
				}
				elseif ($ad["BOOKING_STATUS"] == 4) {
					print "宿泊<br/>済み";
				}
				elseif ($ad["BOOKING_STATUS"] == 5) {
					print "回答<br/>待ち";
				}
				elseif ($ad["BOOKING_STATUS"] == 6) {
					print "受入れ<br/>不可";
				}
				elseif ($ad["BOOKING_STATUS"] == 9) {
					print "予約<br/>失敗";
				}
				?>
			</td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE_START"]?></td>
			<td <?=$rclass?> align="center">
			<a href="couponBookingEdit.html?id=<?=$ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			</td>
		</tr>
			<?php }?>
	<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
