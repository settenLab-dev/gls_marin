<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($gourmetPic->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($gourmetPic->getError())?>
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
			<?php print create_error_msg($gourmetPic->getErrorByKey("GOURMETPICGROUP_ID"))?>
			<select name="GOURMETPICGROUP_ID" class="circle">
				<option value="">---</option>
				<option value="-1" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-1)?'selected="selected"':''?>>外観</option>
				<option value="-2" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-2)?'selected="selected"':''?>>店内</option>
				<option value="-3" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-3)?'selected="selected"':''?>>料理</option>
				<option value="-4" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-4)?'selected="selected"':''?>>飲み物</option>
				<option value="-5" <?php print ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID")==-5)?'selected="selected"':''?>>その他</option>
			<?php if ($gourmetPicGroup->getCount() > 0) {?>
				<?php
				$selectd = '';
				foreach ($gourmetPicGroup->getCollection() as $data) {
					$selectd = '';
					if ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPICGROUP_ID") == $data["GOURMETPICGROUP_ID"]) {
						$selectd = 'selected="selected"';
					}
				?>
				<option value="<?php print $data["GOURMETPICGROUP_ID"]?>" <?php print $selectd?>><?php print $data["GOURMETPICGROUP_NAME"]?></option>
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
			<?php print create_error_msg($gourmetPic->getErrorByKey("GOURMETPIC_DATA"))?>
			<?=$inputs->image("GOURMETPIC_DATA", $gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_DATA"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_GOURMET_APP_SIZE, "", 3)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>ホテル画像説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($gourmetPic->getErrorByKey("GOURMETPIC_DISCRIPTION"))?>
			<?=$inputs->textarea("GOURMETPIC_DISCRIPTION", $gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_DISCRIPTION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ギャラリー表示 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($gourmetPic->getErrorByKey("GOURMETPIC_DISPLAY_FLG"))?>
			<?php print $inputs->radio("GOURMETPIC_DISPLAY_FLG1", "GOURMETPIC_DISPLAY_FLG", 1, $gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_DISPLAY_FLG") ," 表示する")?>
			<?php print $inputs->radio("GOURMETPIC_DISPLAY_FLG2", "GOURMETPIC_DISPLAY_FLG", 2, $gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_DISPLAY_FLG") ," 表示しない")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($gourmetPic->getErrorByKey("GOURMETPIC_STATUS"))?>
			<?php print $inputs->radio("GOURMETPIC_STATUS1", "GOURMETPIC_STATUS", 1, $gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_STATUS") ," 非公開")?>
			<!-- 非公開:1 公開:2 0908追加 公開で登録しでも非公開になります -->
			<?php print $inputs->radio("GOURMETPIC_STATUS2", "GOURMETPIC_STATUS", 2, $gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_STATUS") ," 公開")?>
			<?php if ($gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_STATUS") == 3) {?>
				<?php print $inputs->radio("GOURMETPIC_STATUS3", "GOURMETPIC_STATUS", 3, $gourmetPic->getByKey($gourmetPic->getKeyValue(), "GOURMETPIC_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($gourmetPic->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("gourmetPic::keyName"), $gourmetPic->getKeyValue())?>
