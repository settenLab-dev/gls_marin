<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput booking" id="sortList" width="100%">
	<thead>
		<tr>
			<th width="30"><p>購入番号</p></th>
			<th width="120"><p>店舗名</p></th>
			<th width="80"><p>クーポン名</p></th>
			<th width="30"><p>枚数</p></th>
			<th width="30"><p>1枚の料金</p></th>
			<th width="60"><p>料金合計</p></th>
			<th width="50"><p>ｽﾃｰﾀｽ</p></th>
			<th width="80"><p>申込日</p></th>
			<th width="50"><p>詳細・使う</p></th>
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
			$coupon_name = $couponTarget->getByKey($couponTarget->getKeyValue(), "COUPONSHOP_NAME");
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_ID"]?></td>
			<td <?=$rclass?>><?=$coupon_name?></td>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_NUM"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_PRICE"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_PRICE_ALL"]?></td>
			<td <?=$rclass?>>
				<?php
				if ($ad["COUPONBOOK_STATUS"] == 1) {
					print '<img src="./images/mypage/icon/icon-completion.png" />';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 2) {
					print '<img src="./images/mypage/icon/icon-cancel.png" />';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 3) {
					print '<img src="./images/mypage/icon/icon-hide.png" />';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 4) {
					print '<img src="./images/mypage/icon/icon-already.png" />';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 5) {
					print '<img src="./images/mypage/icon/icon-wait.png" />';
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 6) {
					print '<img src="./images/mypage/icon/icon-unjustifiable.png" />';
				}
				?>
			</td>
			<td <?=$rclass?>><?=$ad["COUPONBOOK_DATE"]?></td>
			<td <?=$rclass?> align="center">
			<a href="mycouponedit.html?id=<?=$ad["COUPONBOOK_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","詳細・使う","circle")?></a>
			</td>
			<?php }?>
		</tr>
			<?php }?>
	</tbody>
</table>
<br />
