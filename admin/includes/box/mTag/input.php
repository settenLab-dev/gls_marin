<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($mTag->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($mTag->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>タグ名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mTag->getErrorByKey("M_TAG_NAME"))?>
			<?php print $inputs->text("M_TAG_NAME", $mTag->getByKey($mTag->getKeyValue(), "M_TAG_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>URL <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mTag->getErrorByKey("M_TAG_URL"))?>
			<?php print $inputs->text("M_TAG_URL", $mTag->getByKey($mTag->getKeyValue(), "M_TAG_URL") ,"imeDisabled circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mTag->getErrorByKey("M_TAG_STATUS"))?>
			<?php print $inputs->radio("M_TAG_STATUS1", "M_TAG_STATUS", 1, $mTag->getByKey($mTag->getKeyValue(), "M_TAG_STATUS") ," 公開")?>
			<?php print $inputs->radio("M_TAG_STATUS2", "M_TAG_STATUS", 2, $mTag->getByKey($mTag->getKeyValue(), "M_TAG_STATUS") ," 非公開")?>
			<?php if ($mTag->getByKey($mTag->getKeyValue(), "M_TAG_STATUS") == 3) {?>
				<?php print $inputs->radio("M_TAG_STATUS3", "M_TAG_STATUS", 3, $mTag->getByKey($mTag->getKeyValue(), "M_TAG_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($mTag->getKeyValue() > 0 and $mTag->getByKey($mTag->getKeyValue(), "M_TAG_STATUS") != 3) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("mTag::keyName"), $mTag->getKeyValue())?>
