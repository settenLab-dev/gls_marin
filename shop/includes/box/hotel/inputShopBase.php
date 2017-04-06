<?php print_r($collection); ?>


<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($hotelShopBase->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelShopBase->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>支店コード</p>
		</td>
		<td align="left">
			<?php if ($hotelShopBase->getKeyValue() > 0) {?>
			<p><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")?><?php print str_pad($hotelShopBase->getKeyValue(), 8, "0", STR_PAD_LEFT);?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>支店名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_NAME"))?>
			<?php print $inputs->text("SHOP_BASE_NAME", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_NAME") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>支店の紹介</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_DISCRITION"))?>
			<?=$inputs->textarea("SHOP_BASE_DISCRITION", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_DISCRITION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>支店担当者 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_HOST"))?>
			<?php print $inputs->text("SHOP_BASE_HOST", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_HOST") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>支店連絡先メールアドレス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_MAIL"))?>
			<?php print $inputs->text("SHOP_BASE_MAIL", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_MAIL") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>支店電話番号 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_TEL"))?>
			<?php print $inputs->text("SHOP_BASE_TEL", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_TEL") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>最大受入人数 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">最小</td>
					<td align="left">
						<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_CAPACITY_FROM"))?>
						<?php print $inputs->text("SHOP_BASE_CAPACITY_FROM", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_CAPACITY_FROM") ,"imeDisabled circle wNum",50)?> 人
						<p>※半角数字1文字でご入力下さい。</p>
					</td>
				</tr>
				<tr>
					<td valign="top">最大</td>
					<td align="left">
						<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_CAPACITY_TO"))?>
						<?php print $inputs->text("SHOP_BASE_CAPACITY_TO", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_CAPACITY_TO") ,"imeDisabled circle wNum",50)?> 人
						<p>※半角数字2文字以内でご入力下さい。</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>多言語対応</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_PET_FLG"))?>
			<?php print $inputs->radio("SHOP_BASE_PET_FLG1", "SHOP_BASE_PET_FLG", 1, $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PET_FLG") ," 受け入れる")?>
			<?php print $inputs->radio("SHOP_BASE_PET_FLG2", "SHOP_BASE_PET_FLG", 2, $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PET_FLG") ," 受け入れない")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>対応可能言語</p>
		</td>
		<td align="left">
			<?php
			$arPet = array();
			$arTemp = explode(":", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PET_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arPet[$data] = $data;
					}
				}
			}
			?>
			<div class="labelNoWrap">
				<ul>
			<?php
			$dataPet = cmHotelPet();
			if (count($dataPet) > 0) {
				foreach ($dataPet as $k=>$v) {
					if ($k >= 10) {
						break;
					}
					$checked = '';
					if ($arPet[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<li><input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label></li>
						<?php
				}
			}
			?>
				</ul>
			</div>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>支店の特徴</p>
		</td>
		<td align="left">
			<table width="100%">
				<tr>
					<td width="50" valign="top">設備</td>
					<td>
						<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_FEATURE_LIST2"))?>
						<?php
						$arFearture2 = array();
						$arTemp = explode(":", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_FEATURE_LIST2"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arFearture2[$data] = $data;
								}
							}
						}

						$dataFeature2 = cmShopBaseFeature();
						if (count($dataFeature2) >0) {
						?>
						<div class="labelNoWrap">
							<ul>
						<?php
							foreach ($dataFeature2 as $k=>$v) {
								$checked = '';
								if ($arFearture2[$k] != "") {
									$checked = 'checked="checked"';
								}
						?>
						<li><input type="checkbox" id="fearture2<?php print $k?>" name="fearture2[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="fearture2<?php print $k?>"> <?php print $v?></label></li>
						<?php
							}
						?>
							</ul>
						</div>
						<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td width="50" valign="top">特徴・バリアフリー対応</td>
					<td>
						<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_FEATURE_LIST3"))?>
						<?php
						$arFearture3 = array();
						$arTemp = explode(":", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_FEATURE_LIST3"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arFearture3[$data] = $data;
								}
							}
						}

						$dataFeature3 = cmShopBaseFeature2();
						if (count($dataFeature3) >0) {
						?>
						<div class="labelNoWrap">
							<ul>
						<?php
							foreach ($dataFeature3 as $k=>$v) {
								$checked = '';
								if ($arFearture3[$k] != "") {
									$checked = 'checked="checked"';
								}
						?>
						<li><input type="checkbox" id="fearture3<?php print $k?>" name="fearture3[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="fearture3<?php print $k?>"> <?php print $v?></label></li>
						<?php
							}
						?>
							</ul>
						</div>
						<?php
						}
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<?php for ($i=1; $i<=4; $i++) {?>
	<tr>
		<td valign="top">
			<p>画像<?php print $i;?></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">画像</td>
					<td align="left">

						<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_PIC".$i))?>
						<?=$inputs->image("SHOP_BASE_PIC".$i, $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

						<?php if ($hotelPic->getCount() > 0) {?>
						<a href="hotelGalleryEdit.html?id=SHOP_BASE_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
						<?php print $inputsOnly->text("SHOP_BASE_PIC".$i."_setup", $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
						<a href="hotelGalleryEdit.html?id=SHOP_BASE_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
						<?php }?>

					</td>
				</tr>
				<tr>
					<td valign="top">画像の説明</td>
					<td align="left">
						<?php print create_error_msg($hotelShopBase->getErrorByKey("SHOP_BASE_PIC_DISCRIPTION".$i))?>
						<?=$inputs->textarea("SHOP_BASE_PIC_DISCRIPTION".$i, $hotelShopBase->getByKey($hotelShopBase->getKeyValue(), "SHOP_BASE_PIC_DISCRIPTION".$i), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($hotelShopBase->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("hotelShopBase::keyName"), $hotelShopBase->getKeyValue())?>
