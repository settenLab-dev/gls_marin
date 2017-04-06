<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th><p>購入番号</p></th>
			<th><p>購入者名</p></th>
			<th><p>クーポンID(キーコード)</p></th>
			<th><p>クーポン名</p></th>
			<th><p>購入数</p></th>
			<th><p>合計金額</p></th>
			<th><p>ステータス</p></th>
			<!--<th><p>使用状況</p></th>-->
			<th><p>購入日</p></th>
			<th><p>更新日</p></th>
			<th width="30"><p>編集</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($booking->getCount() > 0) {?>
			<?php foreach ($booking->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["COUPONBOOK_STATUS"] != 9) {
			if ($ad["COUPONBOOK_STATUS"] == 3 || $ad["COUPONBOOK_STATUS"] == 9) {
				$rclass = 'class="bgLightGrey"';
			}
			
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_ID"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_NAME1"]?><?=$ad["COUPONBOOK_NAME2"]?></br>(<?=$ad["COUPONBOOK_KANA1"]?><?=$ad["COUPONBOOK_KANA2"]?>)</td>
			<td <?=$rclass?>><?=$ad["COUPON_ID_NUM"]?>(<?=$ad["COUPON_KEY_CODE"]?>)</td>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_NUM"]?></td>
			<td <?=$rclass?>><?=number_format($ad["COUPONBOOK_PRICE_ALL"])?></br>(単価：<?=number_format($ad["COUPONBOOK_PRICE"])?>×<?=$ad["COUPONBOOK_NUM"]?>)</td>
			<td <?=$rclass?>>
				<?php
				if ($ad["COUPONBOOK_STATUS"] == 1) {
					print "利用可能<br/>(購入完了)";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 2) {
					print "利用済み";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 3) {
					print "期限切れ";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 4) {
					print "停止";
				}
				?>
			</td>
			<!--<td <?=$rclass?>><?=$ad["COUPONBOOK_NUM"]?></td>-->
			<td <?=$rclass?>><?=$ad["COUPONBOOK_DATE"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_UPDATE"]?></td>
			<td <?=$rclass?> align="center">
			<a href="couponBookingEdit.html?id=<?=$ad["COUPONBOOK_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			</td>
		</tr>
			<?php }?>
	<?php }?>
		<?php }else {?>
		現在購入済みのクーポンはありません。
		<?php }?>
	</tbody>
</table>
<br />
