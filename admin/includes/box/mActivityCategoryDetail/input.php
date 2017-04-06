<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($mActivityCategoryDetail->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($mActivityCategoryDetail->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>対象カテゴリ <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategoryDetail->getErrorByKey("M_ACT_CATEGORY_ID"))?>

			<select name="M_ACT_CATEGORY_ID" class="circle">
				<option value="0" class="msg" selected="selected">未設定</option>
				<?php if ($mActivityCategoryChild->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mActivityCategoryChild->getCollection() as $data) {
						$selectd = '';
						if ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_ID") == $data["M_ACT_CATEGORY_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_ACT_CATEGORY_ID"]?>" value="<?php print $data["M_ACT_CATEGORY_ID"]?>" <?php print $selectd?>><?php print $data["M_ACT_CATEGORY_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>詳細カテゴリ名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategoryDetail->getErrorByKey("M_ACT_CATEGORY_D_NAME"))?>
			<?php print $inputs->text("M_ACT_CATEGORY_D_NAME", $mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_D_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>URL <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategoryDetail->getErrorByKey("M_ACT_CATEGORY_D_URL"))?>
			<?php print $inputs->text("M_ACT_CATEGORY_D_URL", $mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_D_URL") ,"imeDisabled circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategoryDetail->getErrorByKey("M_ACT_CATEGORY_D_STATUS"))?>
			<?php print $inputs->radio("M_ACT_CATEGORY_D_STATUS1", "M_ACT_CATEGORY_D_STATUS", 1, $mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_D_STATUS") ," 公開")?>
			<?php print $inputs->radio("M_ACT_CATEGORY_D_STATUS2", "M_ACT_CATEGORY_D_STATUS", 2, $mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_D_STATUS") ," 非公開")?>
			<?php if ($mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_D_STATUS") == 3) {?>
				<?php print $inputs->radio("M_ACT_CATEGORY_D_STATUS3", "M_ACT_CATEGORY_D_STATUS", 3, $mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_D_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($mActivityCategoryDetail->getKeyValue() > 0 and $mActivityCategoryDetail->getByKey($mActivityCategoryDetail->getKeyValue(), "M_ACT_CATEGORY_D_STATUS") != 3) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("mActivityCategoryDetail::keyName"), $mActivityCategoryDetail->getKeyValue())?>
