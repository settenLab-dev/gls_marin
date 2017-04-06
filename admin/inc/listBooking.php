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
			$sql = "Select count(*) BOOKING_TIME from COUPONBOOKING where MEMBER_ID = $ad[MEMBER_ID] and COMPANY_ID=$ad[COMPANY_ID]";
			$rest = mysql_query($sql);
			$count =mysql_fetch_array($rest);
			$rclass = '';
			if ($ad["COUPONBOOK_STATUS"] == 3) {
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
			<td <?=$rclass?>><?=$ad["COUPONBOOK_NAME1"]?><?=$ad["COUPONBOOK_NAME2"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_KANA1"]."<br/>".$ad["COUPONBOOK_KANA2"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_NUM"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_PRICE"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["COUPON_ID_NUM"]?></td>
			<?php if($ad["COUPONUSE_FLG"] == "2" ){
				$coupon_use_flg = "使用済み"}
				else{$coupon_use_flg = "未使用"}?>
			<td <?=$rclass?>><?=$coupon_use_flg?></td>
			<td <?=$rclass?>>
				<?php
				if ($ad["COUPONBOOK_STATUS"] == 1) {
					print "購入<br/>完了";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 2) {
					print "ｷｬﾝｾﾙ";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 3) {
					print "ﾉｰｼｮｰ";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 4) {
					print "使用<br/>済み";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 5) {
					print "回答<br/>待ち";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 6) {
					print "受入れ<br/>不可";
				}
				?>
			</td>
			<td <?=$rclass?>><?=$count["COUPONUSE_DATE"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_DATE"]?></td>
			<td <?=$rclass?> align="center">
			<a href="couponBookingEdit.html?id=<?=$ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
