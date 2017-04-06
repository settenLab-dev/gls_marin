<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($mActivityCategory->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($mActivityCategory->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>タイプ <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategory->getErrorByKey("M_ACT_CATEGORY_TYPE"))?>
			<?php print $inputs->radio("M_ACT_CATEGORY_TYPE1", "M_ACT_CATEGORY_TYPE", 1, $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TYPE") ," TOPカテゴリ")?>
			<?php print $inputs->radio("M_ACT_CATEGORY_TYPE2", "M_ACT_CATEGORY_TYPE", 2, $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TYPE") ," 親カテゴリ")?>
			<?php print $inputs->radio("M_ACT_CATEGORY_TYPE3", "M_ACT_CATEGORY_TYPE", 3, $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TYPE") ," 子カテゴリ")?>
		</td>
	</tr>
	<?php if($mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TYPE") > 1 || $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TYPE") == ""){?>


		<script>
			$(function() {
				
				// 以下のセレクトボックスの変更で発動
				$('select[name="M_ACT_CATEGORY_TOP"]').change(function() {
					
					// 選択されているTOPエリアのクラス名を取得
					var areaName = $('select[name="M_ACT_CATEGORY_TOP"] option:selected').attr("class");
					console.log(areaName);
					
					// 親エリアの要素数を取得
					var count = $('select[name="M_ACT_CATEGORY_PARENT"]').children().length;
					
					// 親エリアの要素数分、for文で回す
					for (var i=0; i<count; i++) {
						
						var area_par = $('select[name="M_ACT_CATEGORY_PARENT"] option:eq(' + i + ')');
						
						if(area_par.attr("class") === areaName) {
							// 選択したTOPエリアと同じクラス名だった場合
							
							area_par.show();
						}else {
							// 選択したTOPエリアとクラス名が違った場合
							
							if(area_par.attr("class") === "msg") {
								// 「エリアを選択して下さい」という要素だった場合
								
									area_par.show();  //「エリアを選択して下さい」を表示させる
								//	area_par.prop('selected',true);  //「エリアを選択して下さい」を強制的に選択されている状態にする
							} else {
								// 「エリア名を選択して下さい」という要素でなかった場合
								
								area_par.hide();
							}
						}
					}
				})
			})
		</script>

		<tr>
			<td width="160" valign="top">
				<p>TOPカテゴリ <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($mActivityCategory->getErrorByKey("M_ACT_CATEGORY_TOP"))?>

			<select name="M_ACT_CATEGORY_TOP" class="circle">
				<option value="0" class="msg" selected="selected">未設定</option>
				<?php if ($mActivityCategoryTop->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mActivityCategoryTop->getCollection() as $data) {
						$selectd = '';
						if ($mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TOP") == $data["M_ACT_CATEGORY_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_ACT_CATEGORY_ID"]?>" value="<?php print $data["M_ACT_CATEGORY_ID"]?>" <?php print $selectd?>><?php print $data["M_ACT_CATEGORY_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>
	<?php } ?>
	<?php if($mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TYPE") > "2" || $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_TYPE") == ""){?>
		<tr>
			<td width="160" valign="top">
				<p>親カテゴリ <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($mActivityCategory->getErrorByKey("M_ACT_CATEGORY_PARENT"))?>

			<select name="M_ACT_CATEGORY_PARENT" class="circle">
				<option value="0" class="msg" selected="selected">未設定</option>
				<?php if ($mActivityCategoryParent->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mActivityCategoryParent->getCollection() as $data) {
						$selectd = '';
						if ($mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_PARENT") == $data["M_ACT_CATEGORY_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_ACT_CATEGORY_TOP"]?>" value="<?php print $data["M_ACT_CATEGORY_ID"]?>" <?php print $selectd?>><?php print $data["M_ACT_CATEGORY_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>
	<?php } ?>



	<tr>
		<td width="160" valign="top">
			<p>カテゴリ名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategory->getErrorByKey("M_ACT_CATEGORY_NAME"))?>
			<?php print $inputs->text("M_ACT_CATEGORY_NAME", $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>URL <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategory->getErrorByKey("M_ACT_CATEGORY_URL"))?>
			<?php print $inputs->text("M_ACT_CATEGORY_URL", $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_URL") ,"imeDisabled circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mActivityCategory->getErrorByKey("M_ACT_CATEGORY_STATUS"))?>
			<?php print $inputs->radio("M_ACT_CATEGORY_STATUS1", "M_ACT_CATEGORY_STATUS", 1, $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_STATUS") ," 公開")?>
			<?php print $inputs->radio("M_ACT_CATEGORY_STATUS2", "M_ACT_CATEGORY_STATUS", 2, $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_STATUS") ," 非公開")?>
			<?php if ($mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_STATUS") == 3) {?>
				<?php print $inputs->radio("M_ACT_CATEGORY_STATUS3", "M_ACT_CATEGORY_STATUS", 3, $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($mActivityCategory->getKeyValue() > 0 and $mActivityCategory->getByKey($mActivityCategory->getKeyValue(), "M_ACT_CATEGORY_STATUS") != 3) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("mActivityCategory::keyName"), $mActivityCategory->getKeyValue())?>
