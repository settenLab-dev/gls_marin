<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($member->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($member->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td  width="100" valign="top">
			<p>会員名</p>
		</td>
		<td align="left">
			<?php print $member->getByKey($member->getKeyValue(), "MEMBER_NAME1");?> <?php print $member->getByKey($member->getKeyValue(), "MEMBER_NAME2");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>サービス名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("POINT_HISTORY_NAME"))?>
			<?php print $inputs->text("POINT_HISTORY_NAME", $member->getByKey($member->getKeyValue(), "POINT_HISTORY_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>付与ポイント <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("POINT_HISTORY_NUM"))?>
			<?php print $inputs->text("POINT_HISTORY_NUM", $member->getByKey($member->getKeyValue(), "POINT_HISTORY_NUM") ,"imeDisabled circle wNum",50)?> point
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","会員にポイントを付与して完了する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("member::keyName"), $member->getKeyValue())?>
