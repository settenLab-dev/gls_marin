<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($jobPic->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($jobPic->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>画像選択<span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($jobPic->getErrorByKey("HOTELPIC_DATA"))?>
			<?=$inputs->image("HOTELPIC_DATA", $jobPic->getByKey($jobPic->getKeyValue(), "HOTELPIC_DATA"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>画像説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($jobPic->getErrorByKey("HOTELPIC_DISCRIPTION"))?>
			<?=$inputs->textarea("HOTELPIC_DISCRIPTION", $jobPic->getByKey($jobPic->getKeyValue(), "HOTELPIC_DISCRIPTION"), "imeActive circle",30,4)?>
		</td>
	</tr>
			<?php print $inputs->hidden("HOTELPIC_DISPLAY_FLG2", "HOTELPIC_DISPLAY_FLG", 2, $jobPic->getByKey($jobPic->getKeyValue(), "HOTELPIC_DISPLAY_FLG") ," 表示する")?>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($jobPic->getErrorByKey("HOTELPIC_STATUS"))?>
			<?php print $inputs->radio("HOTELPIC_STATUS1", "HOTELPIC_STATUS", 1, $jobPic->getByKey($jobPic->getKeyValue(), "HOTELPIC_STATUS") ," 非公開")?>
			<?php print $inputs->radio("HOTELPIC_STATUS2", "HOTELPIC_STATUS", 2, $jobPic->getByKey($jobPic->getKeyValue(), "HOTELPIC_STATUS") ," 公開")?>
			<?php if ($jobPic->getByKey($jobPic->getKeyValue(), "HOTELPIC_STATUS") == 3) {?>
				<?php print $inputs->radio("HOTELPIC_STATUS3", "HOTELPIC_STATUS", 3, $jobPic->getByKey($jobPic->getKeyValue(), "HOTELPIC_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($jobPic->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("jobPic::keyName"), $jobPic->getKeyValue())?>
