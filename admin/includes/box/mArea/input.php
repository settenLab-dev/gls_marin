<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($mArea->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($mArea->getError())?>
		</td>
	</tr>
	<?php
	}
// 	print_r($mArea->getError());
	?>
	<tr>
		<td width="160" valign="top">
			<p>タイプ <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mArea->getErrorByKey("M_AREA_TYPE"))?>
			<?php print $inputs->radio("M_AREA_TYPE1", "M_AREA_TYPE", 1, $mArea->getByKey($mArea->getKeyValue(), "M_AREA_TYPE") ," TOPエリア")?>
			<?php print $inputs->radio("M_AREA_TYPE2", "M_AREA_TYPE", 2, $mArea->getByKey($mArea->getKeyValue(), "M_AREA_TYPE") ," 親エリア")?>
			<?php print $inputs->radio("M_AREA_TYPE3", "M_AREA_TYPE", 3, $mArea->getByKey($mArea->getKeyValue(), "M_AREA_TYPE") ," 子エリア")?>
		</td>
	</tr>




	<?php if($mArea->getByKey($mArea->getKeyValue(), "M_AREA_TYPE") > 1 || $mArea->getByKey($mArea->getKeyValue(), "M_AREA_TYPE") == ""){?>


		<script>
			$(function() {
				
				// 以下のセレクトボックスの変更で発動
				$('select[name="M_AREA_TOP"]').change(function() {
					
					// 選択されているTOPエリアのクラス名を取得
					var areaName = $('select[name="M_AREA_TOP"] option:selected').attr("class");
					console.log(areaName);
					
					// 親エリアの要素数を取得
					var count = $('select[name="M_AREA_PARENT"]').children().length;
					
					// 親エリアの要素数分、for文で回す
					for (var i=0; i<count; i++) {
						
						var area_par = $('select[name="M_AREA_PARENT"] option:eq(' + i + ')');
						
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
				<p>TOPエリア <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($mArea->getErrorByKey("M_AREA_TOP"))?>

			<select name="M_AREA_TOP" class="circle">
				<option value="0" class="msg" selected="selected">未設定</option>
				<?php if ($mAreaTop->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mAreaTop->getCollection() as $data) {
						$selectd = '';
						if ($mArea->getByKey($mArea->getKeyValue(), "M_AREA_TOP") == $data["M_AREA_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_AREA_ID"]?>" value="<?php print $data["M_AREA_ID"]?>" <?php print $selectd?>><?php print $data["M_AREA_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>
	<?php } ?>
	<?php if($mArea->getByKey($mArea->getKeyValue(), "M_AREA_TYPE") == "3" || $mArea->getByKey($mArea->getKeyValue(), "M_AREA_TYPE") == ""){?>
		<tr>
			<td width="160" valign="top">
				<p>親エリア <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($mArea->getErrorByKey("M_AREA_PARENT"))?>

			<select name="M_AREA_PARENT" class="circle">
				<option value="0" class="msg" selected="selected">未設定</option>
				<?php if ($mAreaParent->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mAreaParent->getCollection() as $data) {
						$selectd = '';
						if ($mArea->getByKey($mArea->getKeyValue(), "M_AREA_PARENT") == $data["M_AREA_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_AREA_TOP"]?>" value="<?php print $data["M_AREA_ID"]?>" <?php print $selectd?>><?php print $data["M_AREA_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>
	<?php } ?>


	<tr>
		<td width="160" valign="top">
			<p>エリア名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mArea->getErrorByKey("M_AREA_NAME"))?>
			<?php print $inputs->text("M_AREA_NAME", $mArea->getByKey($mArea->getKeyValue(), "M_AREA_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>URL <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mArea->getErrorByKey("M_AREA_URL"))?>
			<?php print $inputs->text("M_AREA_URL", $mArea->getByKey($mArea->getKeyValue(), "M_AREA_URL") ,"imeDisabled circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mArea->getErrorByKey("M_AREA_STATUS"))?>
			<?php print $inputs->radio("M_AREA_STATUS1", "M_AREA_STATUS", 1, $mArea->getByKey($mArea->getKeyValue(), "M_AREA_STATUS") ," 公開")?>
			<?php print $inputs->radio("M_AREA_STATUS2", "M_AREA_STATUS", 2, $mArea->getByKey($mArea->getKeyValue(), "M_AREA_STATUS") ," 非公開")?>
			<?php if ($mArea->getByKey($mArea->getKeyValue(), "M_AREA_STATUS") == 3) {?>
				<?php print $inputs->radio("M_AREA_STATUS3", "M_AREA_STATUS", 3, $mArea->getByKey($mArea->getKeyValue(), "M_AREA_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($mArea->getKeyValue() > 0 and $mArea->getByKey($mArea->getKeyValue(), "M_AREA_STATUS") != 3) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("mArea::keyName"), $mArea->getKeyValue())?>
