<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($gourmetPicGroup->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($gourmetPicGroup->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>グループ名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($gourmetPicGroup->getErrorByKey("GOURMETPICGROUP_NAME"))?>
			<?php print $inputs->text("GOURMETPICGROUP_NAME", $gourmetPicGroup->getByKey($gourmetPicGroup->getKeyValue(), "GOURMETPICGROUP_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($gourmetPicGroup->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("gourmetPicGroup::keyName"), $gourmetPicGroup->getKeyValue())?>
