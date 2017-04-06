<?php if ($hotelPic->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelPic->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
		<th colspan="3">
			<h3>写真グループ

			<a href="shopPicGroupEdit.html" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","新しいグループを登録","circle ")?></a> <a href="shopPicGroupOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","グループを並び替える","circle ")?></a>

			</h3>
		</th>
	</tr>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>名称</p></th>
			<th width="50"><p>編集</p></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>体験風景</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>お客様</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>館内施設</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>風景</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>その他</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<?php if ($hotelPicGroup->getCount() > 0) {?>
			<?php foreach ($hotelPicGroup->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["HOTELPICGROUP_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["HOTELPICGROUP_ID"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPICGROUP_NAME"]?></td>
			<td <?=$rclass?> align="center">

			<a href="shopPicGroupEdit.html?id=<?=$ad["HOTELPICGROUP_ID"]?>" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","編集","circle")?></a>

			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />

<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>登録中の写真

			<a href="shopPicEdit.html?key=<?php print $hotelPic->getByKey($hotelPic->getKeyValue(), "COMPANY_ID")?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい写真を登録","circle ")?></a> <a href="shopPicOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","写真を並び替える","circle ")?></a>

			</h3>
		</th>
	</tr>
	<?php if ($hotelPic->getCount() > 0) {?>
	<tr>
		<th colspan="2">
			<?php
			$cnt = 0;
			$cntAll = 0;
			foreach ($hotelPic->getCollection() as $ad) {?>
			<?php
			$cnt++;
			$cntAll++;
			$rclass = '';
			if ($ad["HOTELPIC_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}

			if ($cnt == 1) {
				print '<div class="clearfix">';
			}
			?>

			<table cellspacing="0" cellpadding="0" border="0" class="blockHotelPic">
				<tr>
					<td colspan="2">

						<?php if ($ad["HOTELPICGROUP_ID"] > 0) {?>
						<?php print $hotelPicGroup->getByKey($ad["HOTELPICGROUP_ID"], "HOTELPICGROUP_NAME")?>
						<?php }else{
							switch ($ad["HOTELPICGROUP_ID"]) {
								case -1:
									print "体験風景";
									break;
								case -2:
									print "お客様";
									break;
								case -3:
									print "館内施設";
									break;
								case -4:
									print "風景";
									break;
								case -5:
									print "その他";
									break;
							}
						}?>
				

					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?=$inputsOnly->image("HOTELPIC_DATA", $ad["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>
					</td>
				</tr>
				<?php /*
				<tr>
					<td colspan="2"><img src="<?php print URL_SLAKER_COMMON."images/".$ad["HOTELPIC_DATA"]?>" /></td>
				</tr>
				*/?>
				<tr>

					<td>ステータス</td>
					<td>
						<?php
						if ($ad["HOTELPIC_STATUS"] == 1) {
							print "非公開";
						}
						elseif ($ad["HOTELPIC_STATUS"] == 2) {
							print "公開中";
						}
						?>
					</td>
				</tr>
				<tr>
					<td>ギャラリー</td>
					<td>
						<?php
						if ($ad["HOTELPIC_DISPLAY_FLG"] == 1) {
							print "表示";
						}
						elseif ($ad["HOTELPIC_STATUS"] == 2) {
							print "非表示";
						}
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left">
						<?php print redirectForReturn($ad["HOTELPIC_DISCRIPTION"])?>
					</td>
				</tr>
						<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
				<tr>
					<td colspan="2" align="center">
						<a href="shopPicEdit.html?id=<?php print $ad["HOTELPIC_ID"]?>&key=<?php print $ad["COMPANY_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle ")?></a>
					</td>
				</tr>
						<?php }?>
			</table>
			<?php
			if ($i == 4 or $hotelPic->getCount() == $cntAll) {
				print '</div>';
				$i = 0;
			}
			?>
			<?php }?>
		<?php }?>

		</th>
	</tr>
</table>
<br />
