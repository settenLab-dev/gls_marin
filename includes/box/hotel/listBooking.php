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
			<?php foreach ($booking->getCollection() as $ad): ?>
				<?php if ($ad["BOOKING_STATUS"] != 9){ ?>
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
						<td <?php echo $rclass; ?>><?php echo $ad["BOOKING_CODE"]; ?></td>
						<td <?php echo $rclass; ?>><?php echo $shop_name; ?></td>
						<td <?php echo $rclass; ?>><?php echo $ad["BOOKING_DATE"]; ?></td>
						<td <?php echo $rclass; ?>><?php echo $ad["SHOPPLAN_NAME"]; ?></td>
						<td <?php echo $rclass; ?>>
							<?php if($ad["SHOP_PRICETYPE_KIND"] == 1):?>
								<?php echo $ad["BOOKING_PRICEPERSON1"]+$ad["BOOKING_PRICEPERSON2"]+$ad["BOOKING_PRICEPERSON3"]+$ad["BOOKING_PRICEPERSON4"]+$ad["BOOKING_PRICEPERSON5"]+$ad["BOOKING_PRICEPERSON6"]; ?> 人
							<?php elseif($ad["SHOP_PRICETYPE_KIND"] == 2):?>
								<?php echo $ad["BOOKING_PRICEPERSON7"]; ?> 組(追加:<?php echo $ad["BOOKING_PRICEPERSON8"]; ?> 人)
							<?php endif;?>
						</td>
						<td <?php echo $rclass; ?>><?php echo number_format($ad["BOOKING_ALL_MONEY"]); ?> 円</td>
						<td <?php echo $rclass; ?>>
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
						<td <?php echo $rclass; ?>><?php echo $ad["BOOKING_DATE_START"]; ?></td>
						<td <?php echo $rclass; ?> align="center">
							<?php if ($ad["BOOKING_STATUS"] != 9){ ?>
								<?php $edit_html_name = (strstr($hotel_name,'ツアー'))?'myactbookingedit':'myhotelbookingedit';?>
								<a href="<?php echo $edit_html_name; ?>.html?id=<?php echo $ad["BOOKING_ID"]?>" class="popup" rel="windowCallUnload"><?php echo $inputs->button("","","予約の確認","circle")?></a>
							<?php }else{ ?>
								予約失敗
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			<?php endforeach; ?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
