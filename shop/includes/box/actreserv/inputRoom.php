<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($hotelRoom->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelRoom->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>在庫コード</p>
		</td>
		<td align="left">
			<?php if ($hotelRoom->getKeyValue() > 0) {?>
			<p><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")?><?php print str_pad($hotelRoom->getKeyValue(), 8, "0", STR_PAD_LEFT);?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>在庫タイプ名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NAME"))?>
			<?php print $inputs->text("ROOM_NAME", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>在庫タイプ説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_DISCRITION"))?>
			<?=$inputs->textarea("ROOM_DISCRITION", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_DISCRITION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>定員 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">最小</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_CAPACITY_FROM"))?>
						<?php print $inputs->text("ROOM_CAPACITY_FROM", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_FROM") ,"imeDisabled circle wNum",50)?> 人
						<p>※半角数字1文字でご入力下さい。</p>
					</td>
				</tr>
				<tr>
					<td valign="top">最大</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_CAPACITY_TO"))?>
						<?php print $inputs->text("ROOM_CAPACITY_TO", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_CAPACITY_TO") ,"imeDisabled circle wNum",50)?> 人
						<p>※半角数字2文字以内でご入力下さい。</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<!--	<tr>
		<td valign="top">
			<p>ルームタイプ（その他を選択） <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_TYPE"))?>
			<?php $ar = cmHotelRoomType();?>
			<div class="labelNoWrap">
			<?php if (count($ar) > 0) {?>
			<ul>
			<?php foreach ($ar as $k=>$v) {?>
			<li><?php print $inputs->radio("ROOM_TYPE".$k, "ROOM_TYPE", $k, $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_TYPE") ," ".$v)?></li>
			<?php }?>
			</ul>
			<?php }?>
		</td>
	</tr>
-->
	<tr>
		<td valign="top">
			<p>広さ</p><input type="hidden" id="ROOM_TYPE10" name="ROOM_TYPE" value="10"  /><label for="ROOM_TYPE10" > その他</label>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_BREADTH"))?>
			<?php print $inputs->text("ROOM_BREADTH", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_BREADTH") ,"imeDisabled circle wNum",50)?> ㎡
			<p>※半角数字10文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ペット受入</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_PET_FLG"))?>
			<?php print $inputs->radio("ROOM_PET_FLG1", "ROOM_PET_FLG", 1, $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PET_FLG") ," 受け入れる")?>
			<?php print $inputs->radio("ROOM_PET_FLG2", "ROOM_PET_FLG", 2, $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PET_FLG") ," 受け入れない")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>受入可能ペット</p>
		</td>
		<td align="left">
			<?php
			$arPet = array();
			$arTemp = explode(":", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PET_LIST"));
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
	<!--<tr>
		<td valign="top">
			<p>在庫の特徴</p>
		</td>
		<td align="left">
			<table width="100%">
				<tr>
					<td width="50" valign="top">種類</td>
					<td>
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_FEATURE_LIST"))?>
						<?php
						$arFearture = array();
						$arTemp = explode(":", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_FEATURE_LIST"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arFearture[$data] = $data;
								}
							}
						}

						$dataFeature = cmHotelRoomFeature();
						if (count($dataFeature) >0) {
						?>
						<div class="labelNoWrap">
							<ul>
						<?php
							foreach ($dataFeature as $k=>$v) {
								$checked = '';
								if ($arFearture[$k] != "") {
									$checked = 'checked="checked"';
								}
						?>
						<li><input type="checkbox" id="fearture<?php print $k?>" name="fearture[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="fearture<?php print $k?>"> <?php print $v?></label></li>
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
					<td width="50" valign="top">設備</td>
					<td>
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_FEATURE_LIST2"))?>
						<?php
						$arFearture2 = array();
						$arTemp = explode(":", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_FEATURE_LIST2"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arFearture2[$data] = $data;
								}
							}
						}

						$dataFeature2 = cmHotelRoomFeature2();
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
					<td width="50" valign="top">特徴</td>
					<td>
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_FEATURE_LIST3"))?>
						<?php
						$arFearture3 = array();
						$arTemp = explode(":", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_FEATURE_LIST3"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arFearture3[$data] = $data;
								}
							}
						}

						$dataFeature3 = cmHotelRoomFeature3();
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
				</tr>-->
			</table>
		</td>
	</tr>
	<?php /*
	<tr>
		<td valign="top">
			<p>基本提供部屋数 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">日曜日</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NUM1"))?>
						<?php print $inputs->text("ROOM_NUM1", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM1") ,"imeDisabled circle wNum",50)?> 室
					</td>
				</tr>
				<tr>
					<td valign="top">月曜日</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NUM2"))?>
						<?php print $inputs->text("ROOM_NUM2", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM2") ,"imeDisabled circle wNum",50)?> 室
					</td>
				</tr>
				<tr>
					<td valign="top">火曜日</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NUM3"))?>
						<?php print $inputs->text("ROOM_NUM3", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM3") ,"imeDisabled circle wNum",50)?> 室
					</td>
				</tr>
				<tr>
					<td valign="top">水曜日</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NUM4"))?>
						<?php print $inputs->text("ROOM_NUM4", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM4") ,"imeDisabled circle wNum",50)?> 室
					</td>
				</tr>
				<tr>
					<td valign="top">木曜日</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NUM5"))?>
						<?php print $inputs->text("ROOM_NUM5", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM5") ,"imeDisabled circle wNum",50)?> 室
					</td>
				</tr>
				<tr>
					<td valign="top">金曜日</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NUM6"))?>
						<?php print $inputs->text("ROOM_NUM6", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM6") ,"imeDisabled circle wNum",50)?> 室
					</td>
				</tr>
				<tr>
					<td valign="top">土曜日</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_NUM7"))?>
						<?php print $inputs->text("ROOM_NUM7", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NUM7") ,"imeDisabled circle wNum",50)?> 室
					</td>
				</tr>
			</table>
			<p>※売り出す最小の提供部屋数を設定して下さい。</p>
		</td>
	</tr>
	*/?>
	<?php for ($i=1; $i<=1; $i++) {?>
	<tr>
		<td valign="top">
			<p>イメージ画像<?php print $i;?></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">画像</td>
					<td align="left">

						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_PIC".$i))?>
						<?=$inputs->image("ROOM_PIC".$i, $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

						<?php if ($hotelPic->getCount() > 0) {?>
						<a href="hotelGalleryEdit.html?id=ROOM_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
						<?php print $inputsOnly->text("ROOM_PIC".$i."_setup", $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
						<a href="hotelGalleryEdit.html?id=ROOM_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
						<?php }?>

					</td>
				</tr>
				<tr>
					<td valign="top">画像説明</td>
					<td align="left">
						<?php print create_error_msg($hotelRoom->getErrorByKey("ROOM_PIC_DISCRIPTION".$i))?>
						<?=$inputs->textarea("ROOM_PIC_DISCRIPTION".$i, $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_PIC_DISCRIPTION".$i), "imeActive circle",30,4)?>
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
	<?php if ($hotelRoom->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelRoom->getKeyValue())?>
