<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput booking" id="sortList" width="100%">
	<thead>
		<tr>
			<th width="30"><p>予約番号</p></th>
			<th width="120"><p>ホテル名</p></th>
			<th width="80"><p>宿泊日</p></th>
			<th width="30"><p>泊数</p></th>
			<th width="30"><p>人数</p></th>
			<!--<th width="50"><p>代表者</p></th>
			<th><p>プラン</p></th>
			<th width="100"><p>部屋タイプ</p></th>-->
			<th width="60"><p>料金合計</p></th>
			<th width="50"><p>ｽﾃｰﾀｽ</p></th>
			<th width="80"><p>予約日</p></th>
			<th width="50"><p>編集</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($booking->getCount() > 0) {?>
			<?php foreach ($booking->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["BOOKING_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			$hotelTarget = new hotel($dbMaster);
			$hotelTarget->select($ad["COMPANY_ID"]);
			$hotel_name = $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME");
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["BOOKING_ID"]?></td>
			<td <?=$rclass?>><?=$hotel_name?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE"]?><Br><?=$ad["BOOKING_CHECKIN"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NUM_NIGHT"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NUM_ROOM"]?></td>
			<!--<td <?=$rclass?>><?=$ad["BOOKING_NAME1"]?><?=$ad["BOOKING_NAME2"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["ROOM_NAME"]?></td>-->
			<td <?=$rclass?>><?=number_format($ad["BOOKING_MONEY"])?> 円</td>
			<td <?=$rclass?>>
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
				?>
			</td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE_START"]?></td>
			<td <?=$rclass?> align="center">
			<a href="myhotelbookingedit.html?id=<?=$ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","予約の確認","circle")?></a>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
