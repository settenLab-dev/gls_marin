<?php if ($booking->getErrorCount() > 0) {?>
<?php print create_error_caption($booking->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput booking" id="sortList" width="100%">
	<thead>
		<tr>
			<th width="50"><p>予約番号</p></th>
			<th width="180"><p>催行会社名</p></th>
			<th width="150"><p>催行日</p></th>
			<th><p>プラン</p></th>
			<th width="50"><p>人数</p></th>
			<th width="120"><p>料金合計</p></th>
			<th width="50"><p>ｽﾃｰﾀｽ</p></th>
			<th width="150"><p>予約日</p></th>
			<th width="80"><p>詳細</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($booking->getCount() > 0) {?>
			<?php foreach ($booking->getCollection() as $ad) {?>
			<?php if ($ad["BOOKING_STATUS"] != 9) {?>
			<?php
			$rclass = '';
			if ($ad["BOOKING_STATUS"] == 3 || $ad["BOOKING_STATUS"] == 9) {
				$rclass = 'class="bgLightGrey"';
			}
			$shopTarget = new shop($dbMaster);
			$shopTarget->select($ad["COMPANY_ID"]);
			$shop_name = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME");
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["BOOKING_CODE"]?></td>
			<td <?=$rclass?>><?=$shop_name?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE"]?></td>
			<td <?=$rclass?>><?=$ad["SHOPPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERNUM"]?></td>
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
				elseif ($ad["BOOKING_STATUS"] == 9) {
					print '<img src="./images/mypage/icon/icon-hide.png" />';
				}
				?>
			</td>
			<td <?=$rclass?>><?=$ad["BOOKING_DATE_START"]?></td>
			<td <?=$rclass?> align="center">
			<?php if ($ad["BOOKING_STATUS"] != 9){ ?>
			<a href="<?php if (strstr($hotel_name,'ツアー')){ print 'myactbookingedit'; }
						   else { print 'myhotelbookingedit'; }?>.html?id=<?=$ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","予約の確認","circle")?></a>
			<?php }else { print "予約失敗";}?>
			</td>
		</tr>
			<?php }?>
	<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
