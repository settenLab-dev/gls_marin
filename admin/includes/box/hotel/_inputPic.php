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
			<?php if ($hotelPicGroup->getCount() > 0) {?>
			<select name="HOTELPICGROUP_ID" class="circle">
				<option value="">---</option>
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
			</select>
			<?php }?>
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
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPic->getErrorByKey("HOTELPIC_STATUS"))?>
			<?php print $inputs->radio("HOTELPIC_STATUS1", "HOTELPIC_STATUS", 1, $hotelPic->getByKey($hotelPic->getKeyValue(), "HOTELPIC_STATUS") ," 非公開")?>
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
