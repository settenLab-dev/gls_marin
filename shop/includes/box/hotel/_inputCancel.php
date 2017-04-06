<p>以下のデータをキャンセルします</p>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
				<thead>
					<tr>
						<th width="50" rowspan="2"><p>宿泊日</p></th>
						<th width="50" rowspan="2"><p>部屋目</p></th>
						<th rowspan="2"><p>大人</p></th>
						<th colspan="2"><p>小学生</p></th>
						<th colspan="4"><p>幼児</p></th>
						<th rowspan="2"><p>料金合計</p></th>
					</tr>
					<tr>
						<th><p>低学年</p></th>
						<th><p>高学年</p></th>
						<th><p>食・布)</p></th>
						<th><p>食のみ</p></th>
						<th><p>布のみ</p></th>
						<th><p>なし</p></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($hotelBookingcont->getCount() > 0) {?>
						<?php foreach ($hotelBookingcont->getCollection() as $ad) {?>
						<?php
						$rclass = '';
						if ($_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 1) {
// 							$rclass = 'class="bgLightGrey"';
						}
						else {
							continue;
						}
						?>
					<tr>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_DATE"]?></td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_ROOM"]?></td>
						<td <?=$rclass?>>男:<?=$ad["BOOKINGCONT_NUM1"]?> 女:<?=$ad["BOOKINGCONT_NUM2"]?><br /><?=number_format($ad["BOOKINGCONT_MONEY1"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM3"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY2"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM4"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY3"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM5"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY4"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM6"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY5"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM7"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY6"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM8"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY7"])?>円</td>
						<td <?=$rclass?>><?=number_format($ad["BOOKINGCONT_MONEY"])?></td>
					</tr>
						<?php }?>
					<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($hotelBookingcont->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelBookingcont->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>部屋コード</p>
		</td>
		<td align="left">
			<?php if ($hotelBookingcont->getKeyValue() > 0) {?>
			<p><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")?><?php print str_pad($hotelBookingcont->getKeyValue(), 8, "0", STR_PAD_LEFT);?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>部屋タイプ名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_NAME"))?>
			<?php print $inputs->text("ROOM_NAME", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_NAME") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>部屋タイプ説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_DISCRITION"))?>
			<?=$inputs->textarea("ROOM_DISCRITION", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_DISCRITION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>部屋定員 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">最小</td>
					<td align="left">
						<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_CAPACITY_FROM"))?>
						<?php print $inputs->text("ROOM_CAPACITY_FROM", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_CAPACITY_FROM") ,"imeDisabled circle wNum",50)?> 人
						<p>※半角数字1文字でご入力下さい。</p>
					</td>
				</tr>
				<tr>
					<td valign="top">最大</td>
					<td align="left">
						<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_CAPACITY_TO"))?>
						<?php print $inputs->text("ROOM_CAPACITY_TO", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_CAPACITY_TO") ,"imeDisabled circle wNum",50)?> 人
						<p>※半角数字2文字以内でご入力下さい。</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ルームタイプ <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_TYPE"))?>
			<?php $ar = cmHotelRoomType();?>
			<div class="labelNoWrap">
			<?php if (count($ar) > 0) {?>
			<ul>
			<?php foreach ($ar as $k=>$v) {?>
			<li><?php print $inputs->radio("ROOM_TYPE".$k, "ROOM_TYPE", $k, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_TYPE") ," ".$v)?></li>
			<?php }?>
			</ul>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>部屋の広さ</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_BREADTH"))?>
			<?php print $inputs->text("ROOM_BREADTH", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_BREADTH") ,"imeDisabled circle wNum",50)?> ㎡
			<p>※半角数字10文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ペット受入</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_PET_FLG"))?>
			<?php print $inputs->radio("ROOM_PET_FLG1", "ROOM_PET_FLG", 1, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_PET_FLG") ," 受け入れる")?>
			<?php print $inputs->radio("ROOM_PET_FLG2", "ROOM_PET_FLG", 2, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_PET_FLG") ," 受け入れない")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>受入可能ペット</p>
		</td>
		<td align="left">
			<?php
			$arPet = array();
			$arTemp = explode(":", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_PET_LIST"));
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
			<p>部屋の特徴</p>
		</td>
		<td align="left">
			<table width="100%">
				<tr>
					<td width="50" valign="top">種類</td>
					<td>
						<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_FEATURE_LIST"))?>
						<?php
						$arFearture = array();
						$arTemp = explode(":", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_FEATURE_LIST"));
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
						<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_FEATURE_LIST2"))?>
						<?php
						$arFearture2 = array();
						$arTemp = explode(":", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_FEATURE_LIST2"));
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
						<?php print create_error_msg($hotelBookingcont->getErrorByKey("ROOM_FEATURE_LIST3"))?>
						<?php
						$arFearture3 = array();
						$arTemp = explode(":", $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "ROOM_FEATURE_LIST3"));
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
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<li><?=$inputs->submit("","change","戻る", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelBookingcont->getKeyValue())?>
