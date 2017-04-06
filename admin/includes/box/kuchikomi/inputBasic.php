<?php if ($kuchikomi->getErrorCount() > 0) {?>
<?php print create_error_caption($kuchikomi->getError())?>
エラー

<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>レポート内容</h3>

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
						if ($d["COMPANY_ID"] == $kuchikomi->getByKey($kuchikomi->getKeyValue(), "COMPANY_ID")) {
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
			<?php print $inputs->text("KUCHIKOMI_NAME", $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_NAME") ,"imeActive circle",50)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>利用日</p>
		</th>
		<td align="left">
			<?php print $inputs->text("KUCHIKOMI_USE_DATE", $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_USE_DATE") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#KUCHIKOMI_USE_DATE\').val(\'\');"')?> 
			<script type="text/javascript">
			$(function() {
				$("#KUCHIKOMI_USE_DATE").datepicker({
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
			<?php print $inputs->text("KUCHIKOMI_TITLE", $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_TITLE") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>レポート内容</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("KUCHIKOMI_DETAIL", $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_DETAIL"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>同伴者（だれと、どんなグループで）</p>
		</th>
		<td align="left">
			<?php $arData = cmShopWho();?>
			<?php if (count($arData) > 0) {?>
			<select name="KUCHIKOMI_WHO" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_WHO")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select>
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>レポート画像・写真</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<?php for ($i=1; $i<=4; $i++) {?>
				<tr>
					<th width="160" valign="top">
						<p>画像<?php print $i;?></p>
					</th>
					<td align="left">
						<?=$inputs->image("KUCHIKOMI_PIC".$i, $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_PIC".$i), IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, IMG_HOTEL_FAC_SIZE, "", 3)?>

						<?php if ($kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_STATUS") != 3) {?>
							<?php /*if ($hotelPic->getCount() > 0) {?>
						<a href="hotelGalleryEdit.html?id=HOTEL_PIC_FAC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
							<?php }*/?>

							<?php if ($kuchikomiPic->getCount() > 0) {?>
							<a href="kuchikomiGalleryEdit.html?id=KUCHIKOMI_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
							<?php print $inputsOnly->text("HOTEL_PIC_FAC".$i."_setup", $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
							<a href="kuchikomiGalleryEdit.html?id=KUCHIKOMI_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
							<?php }?>

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
			<?php print $inputs->radio("KUCHIKOMI_APPROV_SHOP1", "KUCHIKOMI_APPROV_SHOP", 1, $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_APPROV_SHOP") ," 未承認")?>
			<?php print $inputs->radio("KUCHIKOMI_APPROV_SHOP2", "KUCHIKOMI_APPROV_SHOP", 2, $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_APPROV_SHOP") ," 承認")?><br><br>

			【管理者承認】
			<?php print $inputs->radio("KUCHIKOMI_APPROV_ADMIN1", "KUCHIKOMI_APPROV_ADMIN", 1, $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_APPROV_ADMIN") ," 未承認")?>
			<?php print $inputs->radio("KUCHIKOMI_APPROV_ADMIN2", "KUCHIKOMI_APPROV_ADMIN", 2, $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_APPROV_ADMIN") ," 承認")?>
		</td>
	</tr>

	<tr>
		<th valign="top">
			<p>公開フラグ</p>
		</th>
		<td align="left">
			<?php print $inputs->radio("KUCHIKOMI_STATUS1", "KUCHIKOMI_STATUS", 1, $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_STATUS") ," 非公開")?>
			<?php print $inputs->radio("KUCHIKOMI_STATUS2", "KUCHIKOMI_STATUS", 2, $kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_STATUS") ," 公開")?>
		</td>
	</tr>
	</table>
	<br />

<ul class="buttons">
	<li><?=$inputs->submit("","regist","レポート情報を保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("kuchikomi::keyName"), $kuchikomi->getKeyValue())?>
