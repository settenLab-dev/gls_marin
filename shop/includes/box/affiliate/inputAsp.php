<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($affiliateasp->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($affiliateasp->getError())?>
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
		<td valign="top">成約日</td>
		<td>
			<?php print $affiliateasp->getByKey($affiliateasp->getKeyValue(), "AFFILIATEASP_DATE_CONTATS");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>金額 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($affiliateasp->getErrorByKey("AFFILIATEASP_MONEY"))?>
			<?php print $inputs->text("AFFILIATEASP_MONEY", $affiliateasp->getByKey($affiliateasp->getKeyValue(), "AFFILIATEASP_MONEY") ,"imeDisabled circle wNum",50)?> 円
			<p>成約した合計金額を入力して下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ポイント率 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($affiliateasp->getErrorByKey("AFFILIATEASP_POINT_PERCENT"))?>
			<?php print $inputs->text("AFFILIATEASP_POINT_PERCENT", $affiliateasp->getByKey($affiliateasp->getKeyValue(), "AFFILIATEASP_POINT_PERCENT") ,"imeDisabled circle wNum",50)?> %
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>付与ポイント <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($affiliateasp->getErrorByKey("AFFILIATEASP_POINT_NUM"))?>
			<?php print $inputs->text("AFFILIATEASP_POINT_NUM", $affiliateasp->getByKey($affiliateasp->getKeyValue(), "AFFILIATEASP_POINT_NUM") ,"imeDisabled circle wNum",50)?> point
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("affiliateasp::keyName"), $affiliateasp->getKeyValue())?>
