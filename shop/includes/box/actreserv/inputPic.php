<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($hotelPic->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelPic->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>写真グループ</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPic->getErrorByKey("HOTELPICGROUP_ID"))?>
			<select name="HOTELPICGROUP_ID" class="circle">
				<option value="">---</option>
				<option value="-1" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-1)?'selected="selected"':''?>>部屋</option>
				<option value="-2" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-2)?'selected="selected"':''?>>食事</option>
				<option value="-3" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-3)?'selected="selected"':''?>>館内施設</option>
				<option value="-4" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-4)?'selected="selected"':''?>>風景</option>
				<option value="-5" <?php print ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID")==-5)?'selected="selected"':''?>>その他</option>
			<?php if ($hotelPicGroup->getCount() > 0) {?>
				<?php
				$selectd = '';
				foreach ($hotelPicGroup->getCollection() as $data) {
					$selectd = '';
					if ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPICGROUP_ID") == $data["HOTELPICGROUP_ID"]) {
						$selectd = 'selected="selected"';
					}
				?>
				<option value="<?php print $data["HOTELPICGROUP_ID"]?>" <?php print $selectd?>><?php print $data["HOTELPICGROUP_NAME"]?></option>
				<?php }?>
			<?php }?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>ホテル画像 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPic->getErrorByKey("HOTELPIC_DATA"))?>
			<?=$inputs->image("HOTELPIC_DATA", $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_DATA"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>ホテル画像説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPic->getErrorByKey("HOTELPIC_DISCRIPTION"))?>
			<?=$inputs->textarea("HOTELPIC_DISCRIPTION", $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_DISCRIPTION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ギャラリー表示 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPic->getErrorByKey("HOTELPIC_DISPLAY_FLG"))?>
			<?php print $inputs->radio("HOTELPIC_DISPLAY_FLG1", "HOTELPIC_DISPLAY_FLG", 1, $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_DISPLAY_FLG") ," 表示する")?>
			<?php print $inputs->radio("HOTELPIC_DISPLAY_FLG2", "HOTELPIC_DISPLAY_FLG", 2, $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_DISPLAY_FLG") ," 表示しない")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPic->getErrorByKey("HOTELPIC_STATUS"))?>
			<?php print $inputs->radio("HOTELPIC_STATUS1", "HOTELPIC_STATUS", 1, $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_STATUS") ," 非公開")?>
			<!-- 非公開:1 公開:2 0908追加 公開で登録しでも非公開になります -->
			<?php print $inputs->radio("HOTELPIC_STATUS2", "HOTELPIC_STATUS", 2, $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_STATUS") ," 公開")?>
			<?php if ($hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_STATUS") == 3) {?>
				<?php print $inputs->radio("HOTELPIC_STATUS3", "HOTELPIC_STATUS", 3, $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($hotelPic->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("hotelPic::keyName"), $hotelPic->getKeyValue())?>
