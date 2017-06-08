<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th width="30"><p>予約ID</p></th>
			<th width="40"><p>予約名</p></th>
			<th width="90"><p>催行日</p></th>
			<th><p>時間</p></th>
			<th width="60"><p>プラン名</p></th>
			<th width="60"><p>人数</p></th>
			<th><p>合計<br/>料金</p></th>
			<th width="40"><p>方法</p></th>
			<th width="40"><p>ｽﾃｰﾀｽ</p></th>
			<th width="30"><p>対応</p></th>
			<th><p>予約日</p></th>
			<th width="30"><p>編集</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($booking->getCount() > 0) {?>
			<?php foreach ($booking->getCollection() as $ad) {?>
			<?php
// 			$sql = "Select count(*) BOOKING_TIME from BOOKING where COMPANY_ID=$ad[COMPANY_ID] and BOOKING_DATE_START < (select BOOKING_DATE_START from BOOKING where BOOKING_ID = $ad[BOOKING_ID])";
// 			$rest = mysql_query($sql);
// 			$count =mysql_fetch_array($rest);
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
			<td <?=$rclass?>><?=$ad["BOOKING_ID"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_NAME1"]?><?=$ad["BOOKING_NAME2"]?><br/>(<?=$ad["BOOKING_KANA1"]?><?=$ad["BOOKING_KANA2"]?>)</td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_MEET_TIME"]?></td>
			<td <?=$rclass?>><?=$ad["SHOPPLAN_NAME"]?></td>
			<td <?=$rclass?>>
			<?php if($ad["SHOP_PRICETYPE_KIND"] == 1){?>
				<?=$ad["BOOKING_PRICEPERSON1"]+$ad["BOOKING_PRICEPERSON2"]+$ad["BOOKING_PRICEPERSON3"]+$ad["BOOKING_PRICEPERSON4"]+$ad["BOOKING_PRICEPERSON5"]+$ad["BOOKING_PRICEPERSON6"]?> 人
			<?php }elseif($ad["SHOP_PRICETYPE_KIND"] == 2){?>
				<?=$ad["BOOKING_PRICEPERSON7"]?> 組(追加:<?=$ad["BOOKING_PRICEPERSON8"]?> 人)
			<?php }?>
			</td>
			<td <?=$rclass?>><?=number_format($ad["BOOKING_ALL_MONEY"])?></td>
			<td <?=$rclass?>>
				<?php
				if ($ad["BOOKING_HOW"] == 0) {
					print "PB";
				}
				elseif ($ad["BOOKING_HOW"] == 1) {
					print "電話";
				}
				elseif ($ad["BOOKING_HOW"] == 2) {
					print "HP";
				}
				elseif ($ad["BOOKING_HOW"] == 3) {
					print "その他";
				}
				?>
			</td>
			<td <?=$rclass?>>
				<?php
				if ($ad["BOOKING_STATUS"] == 1) {
					print "予約OK";
				}
				elseif ($ad["BOOKING_STATUS"] == 2) {
					print "ｷｬﾝｾﾙ";
				}
				elseif ($ad["BOOKING_STATUS"] == 3) {
					print "ﾉｰｼｮｰ";
				}
				elseif ($ad["BOOKING_STATUS"] == 4) {
					print "催行済";
				}
				elseif ($ad["BOOKING_STATUS"] == 5) {
					print "ﾘｸｴｽﾄ";
				}
				elseif ($ad["BOOKING_STATUS"] == 6) {
					print "ﾘｸｴｽﾄNG";
				}
				elseif ($ad["BOOKING_STATUS"] == 9) {
					print "予約<br/>失敗";
				}
				?>
			</td>
			<td <?=$rclass?>>
				<?php
				if ($ad["BOOKING_SHOP_STATUS"] == 1) {
					print "未対応";
				}
				elseif ($ad["BOOKING_SHOP_STATUS"] == 2) {
					print "対応中";
				}
				elseif ($ad["BOOKING_SHOP_STATUS"] == 3) {
					print "予約確認";
				}
				elseif ($ad["BOOKING_SHOP_STATUS"] == 4) {
					print "予約不可";
				}
				elseif ($ad["BOOKING_SHOP_STATUS"] == 5) {
					print "催行済";
				}
				elseif ($ad["BOOKING_STATUS"] == 6) {
					print "ｷｬﾝｾﾙ済";
				}
				?>
			</td>			<td <?=$rclass?>><?=$ad["BOOKING_DATE_START"]?></td>
			<td <?=$rclass?> align="center">
			<a href="shopBookingEdit.html?id=<?=$ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			</td>
		</tr>
			<?php }?>
	<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
