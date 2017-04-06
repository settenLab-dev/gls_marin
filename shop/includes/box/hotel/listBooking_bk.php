<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th width="30"><p>予約番号</p></th>
			<th width="40"><p>宿泊<br/>者名</p></th>
			<th width="90"><p>チェクイン<br/>日時</p></th>
			<th><p>泊数</p></th>
			<th><p>部屋<br/>数</p></th>
			<th width="60"><p>プラン名</p></th>
			<th width="60"><p>部屋<br/>タイプ</p></th>
			<th><p>人数</p></th>
			<th><p>合計<br/>料金</p></th>
			<th width="40"><p>ｽﾃｰﾀｽ</p></th>
			<th width="30"><p>リピート回数</p></th>
			<th><p>予約<br/>申込日</p></th>
			<th width="30"><p>編集</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($booking->getCount() > 0) {?>
			<?php foreach ($booking->getCollection() as $ad) {?>
			<?php
			$sql = "Select count(*) BOOKING_TIME from BOOKING where MEMBER_ID = $ad[MEMBER_ID] and COMPANY_ID=$ad[COMPANY_ID] and BOOKING_DATE_START < (select BOOKING_DATE_START from BOOKING where BOOKING_ID = $ad[BOOKING_ID])";
			$rest = mysql_query($sql);
			$count =mysql_fetch_array($rest);
			$rclass = '';
			php if ($ad["BOOKING_STATUS"] != 9) {
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
			<td <?=$rclass?>><?=$ad["BOOKING_ID"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NAME1"]?><?=$ad["BOOKING_NAME2"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE"]."<br/>".$ad["BOOKING_CHECKIN"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NUM_NIGHT"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NUM_ROOM"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["ROOM_NAME"]?></td>
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
			<td <?=$rclass?>><?=$count["BOOKING_TIME"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE_START"]?></td>
			<td <?=$rclass?> align="center">
			<a href="hotelBookingEdit.html?id=<?=$ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			</td>
		</tr>
			<?php }?>
	<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
