<?php if ($contents->getErrorCount() > 0) {?>
<?php print create_error_caption($contents->getError())?>

<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>投稿内容</h3>

		</th>
	</tr>

	<tr>
		<th widtd="160" valign="top">
			<p>利用施設名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
				<?php if ($shop->getCount() >0) {?>
				<select name="COMPANY_ID" class="imeActive circle" style="width:100%;">
					<option value="0">未選択</option>

					<?php foreach ($shop->getCollection() as $d) {
						$checked = '';
						if ($d["COMPANY_ID"] == $contents->getByKey($contents->getKeyValue(), "COMPANY_ID")) {
							$checked = 'selected="selected"';
						}
					?>
					<option value="<?php print $d["COMPANY_ID"];?>" <?php print $checked;?>><?php print $d["SHOP_NAME"];?></option>
					<?php }?>
				</select>
				<?php }?>		</td>
	</tr>
	<tr>
		<th widtd="160" valign="top">
			<p>投稿者名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print $inputs->text("CONTENTS_NAME", $contents->getByKey($contents->getKeyValue(), "CONTENTS_NAME") ,"imeActive circle",50)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>利用日</p>
		</th>
		<td align="left">
			<?php print $inputs->text("CONTENTS_USE_DATE", $contents->getByKey($contents->getKeyValue(), "CONTENTS_USE_DATE") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#CONTENTS_USE_DATE\').val(\'\');"')?> 
			<script type="text/javascript">
			$(function() {
				$("#CONTENTS_USE_DATE").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
			});
			</script>

		</td>
	</tr>
	<tr>
		<th widtd="160" valign="top">
			<p>タイトル <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print $inputs->text("CONTENTS_TITLE", $contents->getByKey($contents->getKeyValue(), "CONTENTS_TITLE") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>投稿内容</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("CONTENTS_DETAIL", $contents->getByKey($contents->getKeyValue(), "CONTENTS_DETAIL"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>同伴者（だれと、どんなグループで）</p>
		</th>
		<td align="left">
			<?php $arData = cmShopWho();?>
			<?php if (count($arData) > 0) {?>
			<select name="CONTENTS_WHO" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($contents->getByKey($contents->getKeyValue(), "CONTENTS_WHO")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select>
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>投稿画像・写真</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<?php for ($i=1; $i<=4; $i++) {?>
				<tr>
					<th width="160" valign="top">
						<p>画像<?php print $i;?></p>
					</th>
					<td align="left">
						<?=$inputs->image("CONTENTS_PIC".$i, $contents->getByKey($contents->getKeyValue(), "CONTENTS_PIC".$i), IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, IMG_HOTEL_FAC_SIZE, "", 3)?>

						<?php if ($contents->getByKey($contents->getKeyValue(), "CONTENTS_STATUS") != 3) {?>

						<?php }?>
					</td>
				</tr>
				<?php }?>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>承認フラグ</p>
		</th>
		<td align="left">
			【店舗承認】
			<?php print $inputs->radio("CONTENTS_APPROV_SHOP1", "CONTENTS_APPROV_SHOP", 1, $contents->getByKey($contents->getKeyValue(), "CONTENTS_APPROV_SHOP") ," 未承認")?>
			<?php print $inputs->radio("CONTENTS_APPROV_SHOP2", "CONTENTS_APPROV_SHOP", 2, $contents->getByKey($contents->getKeyValue(), "CONTENTS_APPROV_SHOP") ," 承認")?><br><br>

			【管理者承認】
			<?php print $inputs->radio("CONTENTS_APPROV_ADMIN1", "CONTENTS_APPROV_ADMIN", 1, $contents->getByKey($contents->getKeyValue(), "CONTENTS_APPROV_ADMIN") ," 未承認")?>
			<?php print $inputs->radio("CONTENTS_APPROV_ADMIN2", "CONTENTS_APPROV_ADMIN", 2, $contents->getByKey($contents->getKeyValue(), "CONTENTS_APPROV_ADMIN") ," 承認")?>
		</td>
	</tr>

	<tr>
		<th valign="top">
			<p>公開フラグ</p>
		</th>
		<td align="left">
			<?php print $inputs->radio("CONTENTS_STATUS1", "CONTENTS_STATUS", 1, $contents->getByKey($contents->getKeyValue(), "CONTENTS_STATUS") ," 非公開")?>
			<?php print $inputs->radio("CONTENTS_STATUS2", "CONTENTS_STATUS", 2, $contents->getByKey($contents->getKeyValue(), "CONTENTS_STATUS") ," 公開")?>
		</td>
	</tr>
	</table>
	<br />

<ul class="buttons">
	<li><?=$inputs->submit("","regist","投稿情報を保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("contents::keyName"), $contents->getKeyValue())?>
