<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput booking" id="sortList" width="100%">
	<thead>
		<tr>
			<th width="30"><p>購入番号</p></th>
			<th width=""><p>クーポン名</p></th>
			<th width=""><p>店舗名</p></th>
			<th width=""><p>枚数</p></th>
			<th width=""><p>料金合計</p></th>
			<th width=""><p>有効期限</p></th>
			<th width=""><p>ｽﾃｰﾀｽ</p></th>
			<th width=""><p>詳細・使う</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($booking->getCount() > 0) {?>
			<?php foreach ($booking->getCollection() as $ad) {?>

			<?php
			$rclass = '';
			if ($ad["COUPONBOOK_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}

			$couponTarget = new coupon($dbMaster);
			$couponTarget->select($ad["COMPANY_ID"]);
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_ID"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONSHOP_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_NUM"]?></td>
			<td <?=$rclass?>><?=number_format($ad["COUPONBOOK_PRICE_ALL"])?>円</td>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_USE_TO"]?>迄</td>
			<td <?=$rclass?>>
				<?php
				if ($ad["COUPONBOOK_STATUS"] == 1) {
					print '<font color="blue"><B>利用可能</B>';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 2) {
					print '<font color="red"><B>利用済み</B>';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 3) {
					print '<font color="red"><B>期限切れ</B>';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 4) {
					print '<font color="red"><B>利用停止</B>';
				}
				?>
			</td>
			<!--<td <?=$rclass?>><?=$ad["COUPONBOOK_DATE"]?></td>-->
			<td <?=$rclass?> align="center">
			<a href="mycouponedit.html?id=<?=$ad["COUPONBOOK_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","詳細・使う","circle")?></a>
			</td>
			<?php }?>
		</tr>
			<?php }?>
	</tbody>
</table>
<br />
