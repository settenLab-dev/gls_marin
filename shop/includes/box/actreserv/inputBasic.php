<?php if ($hotel->getErrorCount() > 0) {?>
<?php print create_error_caption($hotel->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>施設概要</h3>
			<p><span class="bgLightGrey" style="width: 10px; height: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> の部分の変更は管理者にお問い合わせ下さい。</p>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>会社名 </p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_NAME"))?>
			<p><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME") ?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>会社名(カナ) </p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_NAME_KANA"))?>
			<p><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME_KANA")?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>キャッチコピー</p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_CATCHCOPY"))?>
			<p><?php print redirectForReturn($hotel->getByKey($hotel->getKeyValue(), "HOTEL_CATCHCOPY"))?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>宿種 </p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php $ar = cmHotelKind();?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FLG_KIND"))?>
			<p><?php print $ar[$hotel->getByKey($hotel->getKeyValue(), "HOTEL_FLG_KIND")]?></p>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>エリア</p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php
			$arArea = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_LIST_AREA"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arArea[$data] = $data;
					}
				}
			}

			if (count($arArea) > 0) {
				foreach ($arArea as $d) {
			?>
			<p><?php print $xmlArea->getNameByValue($d)?></p>
			<?php
				}
			}
			?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>公共の宿</p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FLG_PUBLIC"))?>
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_FLG_PUBLIC") == 1) {?>
			<p>該当する</p>
			<?php }else{?>
			<p>該当しない</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>住所 </p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10" width="100%">
				<tr>
					<th valign="top" width="120">郵便番号</th>
					<td class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ZIP"))?>
						<p><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ZIP")?></p>
					</td>
				</tr>
				<tr>
					<th>都道府県</th>
					<td class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
						<?php $arPref = cmGetPrefName();?>
						<p><?php print $arPref[$hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF")]?></p>
					</td>
				</tr>
				<tr>
					<th>市区町村</th>
					<td class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_CITY"))?>
						<p><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CITY")?></p>
					</td>
				</tr>
				<tr>
					<th>その他住所</th>
					<td class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ADDRESS"))?>
						<p><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS")?></p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号</p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TEL"))?>
			<p><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TEL")?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>会社説明文</p>
		</th>
		<td align="left" class="bgLightGrey" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TEL"))?>
			<p><?=$inputs->textarea("HOTEL_DETAIL", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_DETAIL"), "imeActive circle",30,4)?></p>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>外観写真 </p>
		</th>
		<td align="left">

			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_PIC_APP"))?>
			<?=$inputs->image("HOTEL_PIC_APP", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PIC_APP"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
				<?php /*if ($hotelPic->getCount() > 0) {?>
			<a href="hotelGalleryEdit.html?id=HOTEL_PIC_APP" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }*/?>
				<?php if ($hotelPic->getCount() > 0) {?>
				<a href="hotelGalleryEdit.html?id=HOTEL_PIC_APP" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("HOTEL_PIC_APP_setup", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PIC_APP_setup") ,"imeDisabled circle wNum",50)?>
				<a href="hotelGalleryEdit.html?id=HOTEL_PIC_APP" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>
			<?php }?>

		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>施設写真</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<?php for ($i=1; $i<=4; $i++) {?>
				<tr>
					<th width="160" valign="top">
						<p>施設写真 <?php print $i;?></p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_PIC_FAC".$i))?>
						<?=$inputs->image("HOTEL_PIC_FAC".$i, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PIC_FAC".$i), IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, IMG_HOTEL_FAC_SIZE, "", 3)?>

						<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
							<?php /*if ($hotelPic->getCount() > 0) {?>
						<a href="hotelGalleryEdit.html?id=HOTEL_PIC_FAC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
							<?php }*/?>

							<?php if ($hotelPic->getCount() > 0) {?>
							<a href="hotelGalleryEdit.html?id=HOTEL_PIC_FAC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
							<?php print $inputsOnly->text("HOTEL_PIC_FAC".$i."_setup", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PIC_FAC".$i."_setup") ,"imeDisabled circle wNum",50)?>
							<a href="hotelGalleryEdit.html?id=HOTEL_PIC_FAC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
							<?php }?>

						<?php }?>

					</td>
				</tr>
				<?php }?>
			</table>
		</td>
	</tr>
	</table>
	<br />

	<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>アクセス・パーキング</h3>
		</th>
	</tr>
	<tr>
		<th valign="top">
			<p>アクセス概要</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_SUM"))?>
			<?=$inputs->textarea("HOTEL_ACCESS_SUM", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_SUM"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<?php /*
	<tr>
		<th valign="top">
			<p>最寄駅</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<?php for ($i=1; $i<=3; $i++) {?>
				<tr>
					<th width="100" valign="top">
						<p>最寄駅<?php print $i;?></p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_STATION".$i))?>
						<?=$inputs->textarea("HOTEL_STATION".$i, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATION".$i), "imeActive circle",30,4)?>
					</td>
				</tr>
				<?php }?>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>立地状況</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_LIST_LOCATION"))?>
			<?php
			$arLocation = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_LIST_LOCATION"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arLocation[$data] = $data;
					}
				}
			}

			$dataLocation = cmHotelLocation();
			if (count($dataLocation) >0) {
			?>
			<div class="labelNoWrap">
				<ul>
			<?php
				foreach ($dataLocation as $k=>$v) {
					$checked = '';
					if ($arLocation[$k] != "") {
						$checked = 'checked="checked"';
					}
			?>
			<li><input type="checkbox" id="location<?php print $k?>" name="location[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="location<?php print $k?>"> <?php print $v?></label></li>
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
	<?php for ($i=1; $i<=2; $i++) {?>
	<tr>
		<th valign="top">
			<p>主要都市からのアクセス<?php print $i;?></p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top">
						<p>出発地</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_PLACE".$i))?>
						<?php print $inputs->text("HOTEL_ACCESS_PLACE".$i, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_PLACE".$i) ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>車意外でのアクセス<br />(飛行機・船など)</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_HOW".$i))?>
						<?=$inputs->textarea("HOTEL_ACCESS_HOW".$i, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_HOW".$i), "imeActive circle",30,4)?>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>車でのアクセス</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<td width="90">最寄IC</td>
								<td>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_IC".$i))?>
									<?php print $inputs->text("HOTEL_ACCESS_IC".$i, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_IC".$i) ,"imeActive circle", "50")?>
								</td>
							</tr>
							<tr>
								<td>最寄ICまでの<br />行き方</td>
								<td>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_IC_TO".$i))?>
									<?=$inputs->textarea("HOTEL_ACCESS_IC_TO".$i, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_IC_TO".$i), "imeActive circle",30,4)?>
								</td>
							</tr>
							<tr>
								<td>最寄ICからの<br />アクセス</td>
								<td>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_IC_FROM".$i))?>
									<?=$inputs->textarea("HOTEL_ACCESS_IC_FROM".$i, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_IC_FROM".$i), "imeActive circle",30,4)?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>
	*/?>
	<tr>
		<th valign="top">
			<p>パーキング</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10" width="100%">
				<tr>
					<th valign="top" width="90">
						<p>有無</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_PARKING"))?>
						<?php print $inputs->radio("HOTEL_PARKING1", "HOTEL_PARKING", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PARKING") ," ある(有料)")?>
						<?php print $inputs->radio("HOTEL_PARKING2", "HOTEL_PARKING", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PARKING") ," ある(無料)")?>
						<?php print $inputs->radio("HOTEL_PARKING3", "HOTEL_PARKING", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PARKING") ," なし")?>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>補足</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_PARKING_MEMO"))?>
						<?=$inputs->textarea("HOTEL_PARKING_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PARKING_MEMO"), "imeActive circle",30,4)?>
						<p>駐車場料金や台数などを入力して下さい。</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>送迎サービス</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10" width="100%">
				<tr>
					<th valign="top" width="90">
						<p>有無</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SEND"))?>
						<?php print $inputs->radio("HOTEL_SEND1", "HOTEL_SEND", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SEND") ," ある(条件付き)")?>
						<?php print $inputs->radio("HOTEL_SEND2", "HOTEL_SEND", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SEND") ," ある(条件なし)")?>
						<?php print $inputs->radio("HOTEL_SEND3", "HOTEL_SEND", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SEND") ," なし")?>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>補足</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SEND_REMARKS"))?>
						<?=$inputs->textarea("HOTEL_SEND_REMARKS", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SEND_REMARKS"), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php /*
	<tr>
		<th valign="top">
			<p>アクセスに関する補足</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>車以外</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_REMARKS"))?>
						<?=$inputs->textarea("HOTEL_ACCESS_REMARKS", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_REMARKS"), "imeActive circle",30,4)?>
						<p>※電車・船・飛行機などの場合の補足を入力して下さい。</p>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>車利用</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ACCESS_REMARKS_CAR"))?>
						<?=$inputs->textarea("HOTEL_ACCESS_REMARKS_CAR", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ACCESS_REMARKS_CAR"), "imeActive circle",30,4)?>
						<p>※車の場合の補足、駐車場の利用の補足を入力して下さい。</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	*/?>
</table>
<br />


<!--
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>この施設の部屋(部屋数・広さ）</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>部屋総数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA1"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA1", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA1") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>収容人数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA48"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA48", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA48") ,"imeDisabled circle wNum",50)?> 人
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>階数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA49"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA49", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA49") ,"imeDisabled circle wNum",50)?> 階
		</td>
	</tr>
	<?php /*
	<tr>
		<th valign="top">
			<p>洋室合計</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA2"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA2") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
	*/?>
	<tr>
		<th valign="top">
			<p>部屋内訳</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<th width="70" valign="top">
						<p>シングル</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>シングル数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA3"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA3", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA3") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA4"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA5"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA4", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA4") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA5", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA5") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>ツイン</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>ツイン数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA6"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA6", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA6") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA7"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA8"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA7", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA7") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA8", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA8") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>ダブル</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>ダブル数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA9"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA9", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA9") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA10"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA11"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA10", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA10") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA11", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA11") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>トリプル</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>トリプル数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA36"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA36", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA36") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA37"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA38"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA37", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA37") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA38", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA38") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>4ベッド以上</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>4ベッド以上数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA39"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA39", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA39") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA40"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA41"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA40", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA40") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA41", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA41") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>和室</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>和室数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA13"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA13", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA13") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA32"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA33"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA32", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA32") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA33", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA33") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>和洋室</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>和洋室数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA14"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA14", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA14") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA34"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA35"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA34", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA34") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA35", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA35") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>コネクティングルーム</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>コネクティングルーム数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA42"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA42", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA42") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA43"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA44"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA43", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA43") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA44", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA44") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>バリアフリールーム</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>バリアフリールーム数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA45"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA45", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA45") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA46"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA47"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA46", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA46") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA47", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA47") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th width="70" valign="top">
						<p>スイート</p>
					</th>
					<td align="left">
						<table class="inner" cellspacing="5">
							<tr>
								<th width="100" valign="top">
									<p>スイート数</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA12"))?>
									<?php print $inputs->text("HOTEL_ROOM_DATA12", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA12") ,"imeDisabled circle wNum",50)?> 室
								</td>
							</tr>
							<tr>
								<th valign="top">
									<p>面積</p>
								</th>
								<td align="left">
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA30"))?>
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA31"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA30", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA30") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA31", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA31") ,"imeDisabled circle wTime",50)?>㎡</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php /*
	<tr>
		<th valign="top">
			<p>その他<br />トリプル、4ベッドなど</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA15"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA15", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA15") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
	*/?>
	<tr>
		<th valign="top">
			<p>部屋補足</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_REMARKS"))?>
			<?=$inputs->textarea("HOTEL_ROOM_REMARKS", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_REMARKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>この施設の部屋(標準的な部屋設備）</h3>
		</th>
	</tr>
	<?php for ($i=1; $i<=9; $i++) {?>
	<tr>
		<th valign="top" width="160">
			<?php
			$targetNmae = "";
			$dataRoomList = array();
			switch ($i) {
				case 1:
					$targetNmae = "部屋設備";
					$dataRoomList = cmHotelRoom1();
					break;
				case 2:
					$targetNmae = "通信機器";
					$dataRoomList = cmHotelRoom2();
					break;
				case 3:
					$targetNmae = "お茶セット・冷蔵庫";
					$dataRoomList = cmHotelRoom3();
					break;
				case 4:
					$targetNmae = "身だしなみグッズ";
					$dataRoomList = cmHotelRoom4();
					break;
				case 5:
					$targetNmae = "空調・トイレタリー";
					$dataRoomList = cmHotelRoom5();
					break;
				case 6:
					$targetNmae = "その他家電";
					$dataRoomList = cmHotelRoom6();
					break;
				case 7:
					$targetNmae = "調理器具・家電類";
					$dataRoomList = cmHotelRoom7();
					break;
				case 8:
					$targetNmae = "パソコン、周辺機器";
					$dataRoomList = cmHotelRoom8();
					break;
				case 9:
					$targetNmae = "その他";
					$dataRoomList = cmHotelRoom9();
					break;
			}
			?>
			<p><?php print $targetNmae?></p>
		</th>
		<td align="left">
			<?php
			$arRoomList = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_LIST".$i));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoomList[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			if (count($dataRoomList) > 0) {
				foreach ($dataRoomList as $k=>$v) {
					$checked = '';
					if ($arRoomList[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="roomlist<?php print $i?><?php print $k?>" name="roomlist<?php print $i?>[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="roomlist<?php print $i?><?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<?php }?>
	<?php /*
	<tr>
		<th width="160" valign="top">
			<p>バス・トイレ</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>全室</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA16"))?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA161", "HOTEL_ROOM_DATA16", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA16") ," ある")?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA162", "HOTEL_ROOM_DATA16", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA16") ," なし")?>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>一部あり</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA17"))?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA171", "HOTEL_ROOM_DATA17", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA17") ," ある")?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA172", "HOTEL_ROOM_DATA17", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA17") ," なし")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>シャワー</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>全室</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA18"))?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA181", "HOTEL_ROOM_DATA18", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA18") ," ある(有料)")?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA182", "HOTEL_ROOM_DATA18", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA18") ," ある(無料)")?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA183", "HOTEL_ROOM_DATA18", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA18") ," なし")?>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>一部あり</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA19"))?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA191", "HOTEL_ROOM_DATA19", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA19") ," ある(有料)")?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA192", "HOTEL_ROOM_DATA19", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA19") ," ある(無料)")?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA193", "HOTEL_ROOM_DATA19", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA19") ," なし")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>冷暖房（全室）</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA20"))?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA201", "HOTEL_ROOM_DATA20", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA20") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA202", "HOTEL_ROOM_DATA20", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA20") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA203", "HOTEL_ROOM_DATA20", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA20") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>テレビ</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA21"))?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA211", "HOTEL_ROOM_DATA21", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA21") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA212", "HOTEL_ROOM_DATA21", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA21") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA213", "HOTEL_ROOM_DATA21", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA21") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ビデオデッキ<br />DVD含む</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA22"))?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA221", "HOTEL_ROOM_DATA22", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA22") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA222", "HOTEL_ROOM_DATA22", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA22") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA223", "HOTEL_ROOM_DATA22", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA22") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>衛星放送</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA23"))?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA231", "HOTEL_ROOM_DATA23", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA23") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA232", "HOTEL_ROOM_DATA23", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA23") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA233", "HOTEL_ROOM_DATA23", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA23") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>冷蔵庫</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA24"))?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA241", "HOTEL_ROOM_DATA24", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA24") ," ある(飲食付き)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA242", "HOTEL_ROOM_DATA24", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA24") ," なし(空冷蔵庫)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA243", "HOTEL_ROOM_DATA24", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA24") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ズボンプレッサー<br />貸出も可</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA25"))?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA251", "HOTEL_ROOM_DATA25", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA25") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA252", "HOTEL_ROOM_DATA25", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA25") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA253", "HOTEL_ROOM_DATA25", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA25") ," なし")?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>インターネット</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>接続</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA26"))?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA261", "HOTEL_ROOM_DATA26", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA26") ," 接続できる")?>
						<?php print $inputs->radio("HOTEL_ROOM_DATA262", "HOTEL_ROOM_DATA26", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA26") ," 接続できない")?>
					</td>
				</tr>
				<tr>
					<th valign="top">
						<p>接続方法・オプション</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA27"))?>
						<?php
						$arInternet = array();
						$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA27"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arInternet[$data] = $data;
								}
							}
						}

						$dataInternet = cmHotelInternet();
						if (count($dataInternet) >0) {
						?>
						<div class="labelNoWrap">
							<ul>
						<?php
							foreach ($dataInternet as $k=>$v) {
								$checked = '';
								if ($arInternet[$k] != "") {
									$checked = 'checked="checked"';
								}
						?>
						<li><input type="checkbox" id="internet<?php print $k?>" name="internet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="internet<?php print $k?>"> <?php print $v?></label></li>
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
					<th valign="top" width="90">
						<p>補足</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA28"))?>
						<?=$inputs->textarea("HOTEL_ROOM_DATA28", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA28"), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ミニバー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA29"))?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA291", "HOTEL_ROOM_DATA29", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA29") ," ある")?>
			<?php print $inputs->radio("HOTEL_ROOM_DATA292", "HOTEL_ROOM_DATA29", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA29") ," なし")?>
		</td>
	</tr>
	*/?>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>お子様向けサービス</h3>
		</th>
	</tr>
	<?php for ($i=1; $i<=4; $i++) {?>
	<tr>
		<th valign="top" width="160">
			<?php
			$targetNmae = "";
			$dataChildList = array();
			switch ($i) {
				case 1:
					$targetNmae = "お子様用品の貸出";
					$dataChildList = cmHotelChild1();
					break;
				case 2:
					$targetNmae = "お子様アメニティ";
					$dataChildList = cmHotelChild2();
					break;
				case 3:
					$targetNmae = "お子様グッズの取扱い";
					$dataChildList = cmHotelChild3();
					break;
				case 4:
					$targetNmae = "お子様のお食事";
					$dataChildList = cmHotelChild4();
					break;
			}
			?>
			<p><?php print $targetNmae?></p>
		</th>
		<td align="left">
			<?php
			$arChildList = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CHILD_LIST".$i));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arChildList[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			if (count($dataChildList) > 0) {
				foreach ($dataChildList as $k=>$v) {
					$checked = '';
					if ($arChildList[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="child<?php print $i?><?php print $k?>" name="child<?php print $i?>[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="child<?php print $i?><?php print $k?>"> <?php print $v?></label>
				<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_CHILD_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CHILD_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>温泉・風呂</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>温泉情報表示</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_FLG"))?>
			<?php print $inputs->radio("HOTEL_SPA_FLG1", "HOTEL_SPA_FLG", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_FLG") ," 表示する")?>
			<?php print $inputs->radio("HOTEL_SPA_FLG2", "HOTEL_SPA_FLG", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_FLG") ," 表示しない")?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>温泉名</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_NAME"))?>
			<?php print $inputs->text("HOTEL_SPA_NAME", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>温泉の泉質</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_SPA_REMARKS", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_REMARKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>温泉の効能</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_SPA_REMARKS2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_REMARKS2"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>温泉種類</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_KIND"))?>
			<?php print $inputs->radio("HOTEL_SPA_KIND1", "HOTEL_SPA_KIND", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_KIND") ," 天然温泉")?>
			<?php print $inputs->radio("HOTEL_SPA_KIND2", "HOTEL_SPA_KIND", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_KIND") ," 人工温泉")?>
		</td>
	</tr>
	<?php /*
	<tr>
		<th width="160" valign="top">
			<p>露天風呂の数</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>男用</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA1"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA1", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA1") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>女用</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA2"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA2") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>混浴</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA3"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA3", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA3") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	*/?>
	<tr>
		<th width="160" valign="top">
			<p>内湯</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>男用</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA4"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA4", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA4") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>女用</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA5"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA5", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA5") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>混浴</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA6"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA6", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA6") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>サウナ</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>男用</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA7"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA7", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA7") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>女用</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA8"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA8", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA8") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>混浴</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA9"))?>
						<?php print $inputs->text("HOTEL_SPA_DATA9", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA9") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>備考</p>
		</th>
		<td align="left">
			<?php $ar = cmHotelSpa();?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA10"))?>
			<?php if (count($ar) > 0) {?>
			<ul>
			<?php foreach ($ar as $k=>$v) {?>
			<li class="liststylenon"><?php print $inputs->radio("HOTEL_SPA_DATA10".$k, "HOTEL_SPA_DATA10", $k, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA10") ," ".$v)?></li>
			<?php }?>
			</ul>
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>貸切風呂</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA11"))?>
			<?php print $inputs->radio("HOTEL_SPA_DATA111", "HOTEL_SPA_DATA11", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA11") ," ある(条件あり)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA112", "HOTEL_SPA_DATA11", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA11") ," ある(条件なし)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA113", "HOTEL_SPA_DATA11", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA11") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>展望風呂</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA12"))?>
			<?php print $inputs->radio("HOTEL_SPA_DATA121", "HOTEL_SPA_DATA12", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA12") ," ある(条件あり)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA122", "HOTEL_SPA_DATA12", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA12") ," ある(条件なし)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA123", "HOTEL_SPA_DATA12", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA12") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>サウナ</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA13"))?>
			<?php print $inputs->radio("HOTEL_SPA_DATA131", "HOTEL_SPA_DATA13", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA13") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA132", "HOTEL_SPA_DATA13", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA13") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA133", "HOTEL_SPA_DATA13", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA13") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ジャグジー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_DATA14"))?>
			<?php print $inputs->radio("HOTEL_SPA_DATA141", "HOTEL_SPA_DATA14", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA14") ," ある(条件あり)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA142", "HOTEL_SPA_DATA14", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA14") ," ある(条件なし)")?>
			<?php print $inputs->radio("HOTEL_SPA_DATA143", "HOTEL_SPA_DATA14", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA14") ," なし")?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>風呂利用条件</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_SPA_DATA15", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_DATA15"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>アメニティ</h3>
			<?php /*
			<p class="colorRed">※「全室」となっているものは全室に配置されていなければ、「ある」にできません。</p>
			*/?>
		</th>
	</tr>
	<tr>
		<td valign="top" >
			<div class="checkboxarea">
				<?php
				$arAmenity = array();
				$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_LIST"));
				if (count($arTemp) > 0) {
					foreach ($arTemp as $data) {
						if ($data != "") {
							$arAmenity[$data] = $data;
						}
					}
				}
				?>
				<?php
				$dataAmenity = cmHotelAmenity();
				$cnt = 0;
				if (count($dataAmenity) > 0) {
					foreach ($dataAmenity as $k=>$v) {
						$cnt++;
						if ($cnt > 15) {
							break;
						}
						$checked = '';
						if ($arAmenity[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="amenity<?php print $k?>" name="amenity[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="amenity<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>
			</div>
		</td>
		<td align="left">
			<div class="checkboxarea">
				<?php
				$dataAmenity = cmHotelAmenity();
				$cnt = 0;
				if (count($dataAmenity) > 0) {
					foreach ($dataAmenity as $k=>$v) {
						$cnt++;
						if ($cnt <= 15) {
							continue;
						}
						$checked = '';
						if ($arAmenity[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="amenity<?php print $k?>" name="amenity[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="amenity<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>
			</div>
			<br />
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<p>備考</p>
			<?=$inputs->textarea("HOTEL_AMENITY_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<?php /*
	<tr>
		<th valign="top" width="160">
			<p>フェイスタオル・ハンドタオル</p>
		</th>
		<th width="40">
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA1"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA11", "HOTEL_AMENITY_DATA1", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA1") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA12", "HOTEL_AMENITY_DATA1", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA1") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA13", "HOTEL_AMENITY_DATA1", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA1") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>歯ブラシ<br />歯磨き粉含む</p>
		</th>
		<th >
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA2"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA21", "HOTEL_AMENITY_DATA2", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA2") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA22", "HOTEL_AMENITY_DATA2", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA2") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA23", "HOTEL_AMENITY_DATA2", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA2") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>バスタオル</p>
		</th>
		<td>
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA3"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA31", "HOTEL_AMENITY_DATA3", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA3") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA32", "HOTEL_AMENITY_DATA3", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA3") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA33", "HOTEL_AMENITY_DATA3", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA3") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>シャンプー</p>
		</th>
		<td>
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA4"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA41", "HOTEL_AMENITY_DATA4", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA4") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA42", "HOTEL_AMENITY_DATA4", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA4") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA43", "HOTEL_AMENITY_DATA4", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA4") ," なし")?>
			<p>※リンスインシャンプーの場合は「ある」にチェックして下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>リンス</p>
		</th>
		<td>
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA5"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA51", "HOTEL_AMENITY_DATA5", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA5") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA52", "HOTEL_AMENITY_DATA5", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA5") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA53", "HOTEL_AMENITY_DATA5", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA5") ," なし")?>
			<p>※リンスインシャンプーの場合は「なし」にチェックして下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ボディソープ</p>
		</th>
		<td >
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA6"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA61", "HOTEL_AMENITY_DATA6", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA6") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA62", "HOTEL_AMENITY_DATA6", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA6") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA63", "HOTEL_AMENITY_DATA6", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA6") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>石鹸</p>
		</th>
		<td >
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA7"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA71", "HOTEL_AMENITY_DATA7", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA7") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA72", "HOTEL_AMENITY_DATA7", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA7") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA73", "HOTEL_AMENITY_DATA7", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA7") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>浴衣</p>
		</th>
		<th >
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA8"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA81", "HOTEL_AMENITY_DATA8", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA8") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA82", "HOTEL_AMENITY_DATA8", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA8") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA83", "HOTEL_AMENITY_DATA8", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA8") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>パジャマ</p>
		</th>
		<th >
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA9"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA91", "HOTEL_AMENITY_DATA9", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA9") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA92", "HOTEL_AMENITY_DATA9", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA9") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA93", "HOTEL_AMENITY_DATA9", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA9") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>バスローブ</p>
		</th>
		<th >
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA10"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA101", "HOTEL_AMENITY_DATA10", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA10") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA102", "HOTEL_AMENITY_DATA10", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA10") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA103", "HOTEL_AMENITY_DATA10", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA10") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ドライヤー</p>
		</th>
		<th >
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA11"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA111", "HOTEL_AMENITY_DATA11", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA11") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA112", "HOTEL_AMENITY_DATA11", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA11") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA113", "HOTEL_AMENITY_DATA11", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA11") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>羽毛布団</p>
		</th>
		<th >
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA12"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA121", "HOTEL_AMENITY_DATA12", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA12") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA122", "HOTEL_AMENITY_DATA12", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA12") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA123", "HOTEL_AMENITY_DATA12", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA12") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>髭剃り</p>
		</th>
		<td >
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA13"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA131", "HOTEL_AMENITY_DATA13", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA13") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA132", "HOTEL_AMENITY_DATA13", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA13") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>シャワーキャップ</p>
		</th>
		<td >
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA14"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA141", "HOTEL_AMENITY_DATA14", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA14") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA142", "HOTEL_AMENITY_DATA14", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA14") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>麺棒</p>
		</th>
		<td >
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA15"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA151", "HOTEL_AMENITY_DATA15", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA15") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA152", "HOTEL_AMENITY_DATA15", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA15") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>シャワートイレ<br />ウオッシュレット</p>
		</th>
		<th >
			<p class="colorRed">全室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA16"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA161", "HOTEL_AMENITY_DATA16", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA16") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA162", "HOTEL_AMENITY_DATA16", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA16") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA163", "HOTEL_AMENITY_DATA16", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA16") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>くし・ブラシ</p>
		</th>
		<td >
		</td>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_AMENITY_DATA17"))?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA171", "HOTEL_AMENITY_DATA17", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA17") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_AMENITY_DATA172", "HOTEL_AMENITY_DATA17", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_AMENITY_DATA17") ," なし")?>
		</td>
	</tr>
	*/?>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>施設</h3>
		</th>
	</tr>
	<?php for ($i=1; $i<=10; $i++) {?>
	<tr>
		<th valign="top" width="160">
			<?php
			$targetNmae = "";
			$dataFacilityList = array();
			switch ($i) {
				case 1:
					$targetNmae = "飲食";
					$dataFacilityList = cmHotelFacility1();
					break;
				case 2:
					$targetNmae = "エンターテインメント";
					$dataFacilityList = cmHotelFacility2();
					break;
				case 3:
					$targetNmae = "宴会・会議室";
					$dataFacilityList = cmHotelFacility3();
					break;
				case 4:
					$targetNmae = "お風呂";
					$dataFacilityList = cmHotelFacility4();
					break;
				case 5:
					$targetNmae = "お子様向け";
					$dataFacilityList = cmHotelFacility5();
					break;
				case 6:
					$targetNmae = "館内ショップ";
					$dataFacilityList = cmHotelFacility6();
					break;
				case 7:
					$targetNmae = "美容";
					$dataFacilityList = cmHotelFacility7();
					break;
				case 8:
					$targetNmae = "プール";
					$dataFacilityList = cmHotelFacility8();
					break;
				case 9:
					$targetNmae = "レジャー・スポーツ";
					$dataFacilityList = cmHotelFacility9();
					break;
				case 10:
					$targetNmae = "その他";
					$dataFacilityList = cmHotelFacility10();
					break;
			}
			?>
			<p><?php print $targetNmae?></p>
		</th>
		<td align="left">
			<?php
			$arFacilityList = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_LIST".$i));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFacilityList[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			if (count($dataFacilityList) > 0) {
				foreach ($dataFacilityList as $k=>$v) {
					$checked = '';
					if ($arFacilityList[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="facilitylist<?php print $i?><?php print $k?>" name="facilitylist<?php print $i?>[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="facilitylist<?php print $i?><?php print $k?>"> <?php print $v?></label>

					<?php if ($v == "宴会場") {?>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_NUM1"))?>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_FROM1"))?>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_TO1"))?>
						<p>
						<?php print $inputs->text("HOTEL_FACILITY_NUM1", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_NUM1") ,"imeDisabled circle wTime",50)?> 室 :
						<?php print $inputs->text("HOTEL_FACILITY_FROM1", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_FROM1") ,"imeDisabled circle wTime",50)?> ～
						<?php print $inputs->text("HOTEL_FACILITY_TO1", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_TO1") ,"imeDisabled circle wTime",50)?> 名
						</p><br />
					<?php }?>
					<?php if ($v == "会議室") {?>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_NUM2"))?>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_FROM2"))?>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_TO2"))?>
						<p>
						<?php print $inputs->text("HOTEL_FACILITY_NUM2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_NUM2") ,"imeDisabled circle wTime",50)?> 室 :
						<?php print $inputs->text("HOTEL_FACILITY_FROM2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_FROM2") ,"imeDisabled circle wTime",50)?> ～
						<?php print $inputs->text("HOTEL_FACILITY_TO2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_TO2") ,"imeDisabled circle wTime",50)?> 名
						</p><br />
					<?php }?>

				<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_FACILITY_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<?php /*
	<tr>
		<th valign="top" width="160">
			<p>フィットネス</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA1"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA11", "HOTEL_FACILITY_DATA1", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA1") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA12", "HOTEL_FACILITY_DATA1", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA1") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA13", "HOTEL_FACILITY_DATA1", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA1") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>体育館</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA2"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA21", "HOTEL_FACILITY_DATA2", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA2") ," 敷地内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA22", "HOTEL_FACILITY_DATA2", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA2") ," 敷地内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA23", "HOTEL_FACILITY_DATA2", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA2") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>グラウンド</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA3"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA31", "HOTEL_FACILITY_DATA3", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA3") ," 敷地内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA32", "HOTEL_FACILITY_DATA3", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA3") ," 敷地内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA33", "HOTEL_FACILITY_DATA3", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA3") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>テニス</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA4"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA41", "HOTEL_FACILITY_DATA4", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA4") ," 敷地内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA42", "HOTEL_FACILITY_DATA4", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA4") ," 敷地内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA43", "HOTEL_FACILITY_DATA4", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA4") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>プール(屋内)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA5"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA51", "HOTEL_FACILITY_DATA5", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA5") ," 敷地内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA52", "HOTEL_FACILITY_DATA5", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA5") ," 敷地内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA53", "HOTEL_FACILITY_DATA5", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA5") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>プール(屋外)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA6"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA61", "HOTEL_FACILITY_DATA6", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA6") ," 敷地内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA62", "HOTEL_FACILITY_DATA6", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA6") ," 敷地内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA63", "HOTEL_FACILITY_DATA6", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA6") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>卓球</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA7"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA71", "HOTEL_FACILITY_DATA7", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA7") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA72", "HOTEL_FACILITY_DATA7", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA7") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA73", "HOTEL_FACILITY_DATA7", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA7") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ボウリング</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA8"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA81", "HOTEL_FACILITY_DATA8", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA8") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA82", "HOTEL_FACILITY_DATA8", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA8") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA83", "HOTEL_FACILITY_DATA8", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA8") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ビリヤード</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA9"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA91", "HOTEL_FACILITY_DATA9", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA9") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA92", "HOTEL_FACILITY_DATA9", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA9") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA93", "HOTEL_FACILITY_DATA9", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA9") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ゲームコーナー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA10"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA101", "HOTEL_FACILITY_DATA10", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA10") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA102", "HOTEL_FACILITY_DATA10", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA10") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA103", "HOTEL_FACILITY_DATA10", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA10") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>カラオケ</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA11"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA111", "HOTEL_FACILITY_DATA11", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA11") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA112", "HOTEL_FACILITY_DATA11", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA11") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA113", "HOTEL_FACILITY_DATA11", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA11") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>宴会場</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA12"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA121", "HOTEL_FACILITY_DATA12", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA12") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA122", "HOTEL_FACILITY_DATA12", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA12") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA123", "HOTEL_FACILITY_DATA12", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA12") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>バーベキュー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA13"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA131", "HOTEL_FACILITY_DATA13", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA13") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA132", "HOTEL_FACILITY_DATA13", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA13") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA133", "HOTEL_FACILITY_DATA13", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA13") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>乾燥室</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA14"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA141", "HOTEL_FACILITY_DATA14", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA14") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA142", "HOTEL_FACILITY_DATA14", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA14") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA143", "HOTEL_FACILITY_DATA14", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA14") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>バー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA15"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA151", "HOTEL_FACILITY_DATA15", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA15") ," 館内あり(有料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA152", "HOTEL_FACILITY_DATA15", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA15") ," 館内あり(無料)")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA153", "HOTEL_FACILITY_DATA15", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA15") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ラウンジ</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA16"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA161", "HOTEL_FACILITY_DATA16", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA16") ," 館内あり")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA162", "HOTEL_FACILITY_DATA16", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA16") ," ない")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ビジネスセンター</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA17"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA171", "HOTEL_FACILITY_DATA17", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA17") ," 館内あり")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA172", "HOTEL_FACILITY_DATA17", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA17") ," ない")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>禁煙ルーム</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA18"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA181", "HOTEL_FACILITY_DATA18", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA18") ," 館内あり")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA182", "HOTEL_FACILITY_DATA18", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA18") ," ない")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>囲炉裏</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA19"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA191", "HOTEL_FACILITY_DATA19", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA19") ," 館内あり")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA192", "HOTEL_FACILITY_DATA19", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA19") ," ない")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>製氷機</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FACILITY_DATA20"))?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA201", "HOTEL_FACILITY_DATA20", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA20") ," 館内あり")?>
			<?php print $inputs->radio("HOTEL_FACILITY_DATA202", "HOTEL_FACILITY_DATA20", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FACILITY_DATA20") ," ない")?>
		</td>
	</tr>
	*/?>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>サービス＆レジャー</h3>
		</th>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>可能サービス</p>
		</th>
		<td align="left">
			<?php
			$arService = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arService[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			$dataService = cmHotelService();
			if (count($dataService) > 0) {
				foreach ($dataService as $k=>$v) {
					$checked = '';
					if ($arService[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="service<?php print $k?>" name="service[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="service<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<?php /*
	<tr>
		<th valign="top" width="160">
			<p>ルームサービス</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA1"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA11", "HOTEL_SERVICE_DATA1", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA1") ," あり")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA12", "HOTEL_SERVICE_DATA1", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA1") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>クリーニングサービス</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA2"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA21", "HOTEL_SERVICE_DATA2", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA2") ," あり")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA22", "HOTEL_SERVICE_DATA2", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA2") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>エステ(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA3"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA31", "HOTEL_SERVICE_DATA3", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA3") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA32", "HOTEL_SERVICE_DATA3", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA3") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA33", "HOTEL_SERVICE_DATA3", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA3") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>マッサージ(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA4"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA41", "HOTEL_SERVICE_DATA4", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA4") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA42", "HOTEL_SERVICE_DATA4", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA4") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA43", "HOTEL_SERVICE_DATA4", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA4") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>貸しスキー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA5"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA51", "HOTEL_SERVICE_DATA5", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA5") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA52", "HOTEL_SERVICE_DATA5", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA5") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA53", "HOTEL_SERVICE_DATA5", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA5") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>貸しボード</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA6"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA61", "HOTEL_SERVICE_DATA6", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA6") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA62", "HOTEL_SERVICE_DATA6", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA6") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA63", "HOTEL_SERVICE_DATA6", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA6") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>貸し自転車</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA7"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA71", "HOTEL_SERVICE_DATA7", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA7") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA72", "HOTEL_SERVICE_DATA7", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA7") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA73", "HOTEL_SERVICE_DATA7", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA7") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>将棋</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA8"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA81", "HOTEL_SERVICE_DATA8", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA8") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA82", "HOTEL_SERVICE_DATA8", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA8") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA83", "HOTEL_SERVICE_DATA8", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA8") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>囲碁</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA9"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA91", "HOTEL_SERVICE_DATA9", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA9") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA92", "HOTEL_SERVICE_DATA9", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA9") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA93", "HOTEL_SERVICE_DATA9", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA9") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>麻雀</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA10"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA101", "HOTEL_SERVICE_DATA10", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA10") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA102", "HOTEL_SERVICE_DATA10", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA10") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA103", "HOTEL_SERVICE_DATA10", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA10") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>体育館(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA11"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA111", "HOTEL_SERVICE_DATA11", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA11") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA112", "HOTEL_SERVICE_DATA11", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA11") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA113", "HOTEL_SERVICE_DATA11", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA11") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>グラウンド(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA12"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA121", "HOTEL_SERVICE_DATA12", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA12") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA122", "HOTEL_SERVICE_DATA12", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA12") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA123", "HOTEL_SERVICE_DATA12", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA12") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>テニス(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA13"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA131", "HOTEL_SERVICE_DATA13", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA13") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA132", "HOTEL_SERVICE_DATA13", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA13") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA133", "HOTEL_SERVICE_DATA13", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA13") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ゴルフ(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA14"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA141", "HOTEL_SERVICE_DATA14", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA14") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA142", "HOTEL_SERVICE_DATA14", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA14") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA143", "HOTEL_SERVICE_DATA14", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA14") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>パターゴルフ(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA15"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA151", "HOTEL_SERVICE_DATA15", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA15") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA152", "HOTEL_SERVICE_DATA15", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA15") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA153", "HOTEL_SERVICE_DATA15", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA15") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>釣り(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA16"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA161", "HOTEL_SERVICE_DATA16", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA16") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA162", "HOTEL_SERVICE_DATA16", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA16") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA163", "HOTEL_SERVICE_DATA16", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA16") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>パラグライダー(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA17"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA171", "HOTEL_SERVICE_DATA17", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA17") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA172", "HOTEL_SERVICE_DATA17", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA17") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA173", "HOTEL_SERVICE_DATA17", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA17") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>乗馬(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA18"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA181", "HOTEL_SERVICE_DATA18", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA18") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA182", "HOTEL_SERVICE_DATA18", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA18") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA183", "HOTEL_SERVICE_DATA18", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA18") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ダイビング(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA19"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA191", "HOTEL_SERVICE_DATA19", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA19") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA192", "HOTEL_SERVICE_DATA19", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA19") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA193", "HOTEL_SERVICE_DATA19", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA19") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ラフティング(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA20"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA201", "HOTEL_SERVICE_DATA20", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA20") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA202", "HOTEL_SERVICE_DATA20", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA20") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA203", "HOTEL_SERVICE_DATA20", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA20") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>カヌー(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA21"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA211", "HOTEL_SERVICE_DATA21", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA21") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA212", "HOTEL_SERVICE_DATA21", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA21") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA213", "HOTEL_SERVICE_DATA21", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA21") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>陶芸(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA22"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA221", "HOTEL_SERVICE_DATA22", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA22") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA222", "HOTEL_SERVICE_DATA22", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA22") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA223", "HOTEL_SERVICE_DATA22", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA22") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>ソバ打ち(手配含む)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA23"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA231", "HOTEL_SERVICE_DATA23", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA23") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA232", "HOTEL_SERVICE_DATA23", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA23") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA233", "HOTEL_SERVICE_DATA23", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA23") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>デイユース<br />※泊りなし利用</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA24"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA241", "HOTEL_SERVICE_DATA24", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA24") ," ある(有料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA242", "HOTEL_SERVICE_DATA24", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA24") ," ある(無料)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA243", "HOTEL_SERVICE_DATA24", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA24") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top" >
			<p>一人宿泊</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA25"))?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA251", "HOTEL_SERVICE_DATA25", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA25") ," 可")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA252", "HOTEL_SERVICE_DATA25", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA25") ," 平日のみ可(他条件なし)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA253", "HOTEL_SERVICE_DATA25", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA25") ," 平日のみ可(他条件あり)")?>
			<?php print $inputs->radio("HOTEL_SERVICE_DATA254", "HOTEL_SERVICE_DATA25", 4, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA25") ," 不可")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ペット</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>ペットと宿泊</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA26"))?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA261", "HOTEL_SERVICE_DATA26", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA26") ," 可能(有料)")?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA262", "HOTEL_SERVICE_DATA26", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA26") ," 可能(無料)")?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA263", "HOTEL_SERVICE_DATA26", 3, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA26") ," 不可")?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>ケージ</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA27"))?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA271", "HOTEL_SERVICE_DATA27", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA27") ," ある(無料)")?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA272", "HOTEL_SERVICE_DATA27", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA27") ," ない")?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>ケージ持ち込み</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA28"))?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA281", "HOTEL_SERVICE_DATA28", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA28") ," ある(無料)")?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA282", "HOTEL_SERVICE_DATA28", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA28") ," ない")?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>部屋・ラウンジ同伴可</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA29"))?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA291", "HOTEL_SERVICE_DATA29", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA29") ," ある(無料)")?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA292", "HOTEL_SERVICE_DATA29", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA29") ," ない")?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>ペット用風呂</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SERVICE_DATA30"))?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA301", "HOTEL_SERVICE_DATA30", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA30") ," ある(無料)")?>
						<?php print $inputs->radio("HOTEL_SERVICE_DATA302", "HOTEL_SERVICE_DATA30", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SERVICE_DATA30") ," ない")?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>受入可能ペット</p>
					</th>
					<td align="left">
						<?php
						$arPet = array();
						$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_LIST_PET"));
						if (count($arTemp) > 0) {
							foreach ($arTemp as $data) {
								if ($data != "") {
									$arPet[$data] = $data;
								}
							}
						}
						?>
						<?php
						$dataPet = cmHotelPet();
						if (count($dataPet) > 0) {
							foreach ($dataPet as $k=>$v) {
								$checked = '';
								if ($arPet[$k] != "") {
									$checked = 'checked="checked"';
								}
								?>
									<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
									<?php
							}
						}
						?>
						<br />
						<br />
						<p>その他</p>
						<?=$inputs->textarea("HOTEL_PET_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PET_MEMO"), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>アメニティ・施設・サービス補足</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_DATA_REAMRKS", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_DATA_REAMRKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	*/?>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>ペット</h3>
			<p>※受け入れ可能なペットにチェックがない場合は、この項目は表示しません。</p>
		</th>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>受入可能ペット</p>
		</th>
		<td align="left">
			<?php
			$arPet = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_LIST_PET"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arPet[$data] = $data;
					}
				}
			}
			?>
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
						<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			<br />
			<br />
			<p>その他</p>
			<?=$inputs->textarea("HOTEL_PET_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PET_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>ペットの宿泊場所</p>
		</th>
		<td align="left">
			<table width="100%">
				<tr>
					<th>同室できる</th>
					<td>
						<div class="checkboxarea">
						<?php
						if (count($dataPet) > 0) {
							foreach ($dataPet as $k=>$v) {
								if ($k < 10) {
									continue;
								}
								if ($k >= 20) {
									break;
								}
								$checked = '';
								if ($arPet[$k] != "") {
									$checked = 'checked="checked"';
								}
								?>
									<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
									<?php
							}
						}
						?>
						</div>
					</td>
				</tr>
				<tr>
					<th>同室できない</th>
					<td>
						<div class="checkboxarea">
						<?php
						if (count($dataPet) > 0) {
							foreach ($dataPet as $k=>$v) {
								if ($k < 20) {
									continue;
								}
								if ($k >= 30) {
									break;
								}
								$checked = '';
								if ($arPet[$k] != "") {
									$checked = 'checked="checked"';
								}
								?>
									<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
									<?php
							}
						}
						?>
						</div>
						<?=$inputs->textarea("HOTEL_PET_MEMO2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PET_MEMO2"), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>

		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>ペット同伴OKの場所</p>
		</th>
		<td align="left">
			<div class="checkboxarea">
			<?php
			if (count($dataPet) > 0) {
				foreach ($dataPet as $k=>$v) {
					if ($k < 30) {
						continue;
					}
					if ($k >= 40) {
						break;
					}
					$checked = '';
					if ($arPet[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>ペット用設備</p>
		</th>
		<td align="left">
			<div class="checkboxarea">
			<?php
			if (count($dataPet) > 0) {
				foreach ($dataPet as $k=>$v) {
					if ($k < 40) {
						continue;
					}
					if ($k >= 50) {
						break;
					}
					$checked = '';
					if ($arPet[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>ペットの持ち物</p>
		</th>
		<td align="left">
			<div class="checkboxarea">
			<?php
			if (count($dataPet) > 0) {
				foreach ($dataPet as $k=>$v) {
					if ($k < 50) {
						continue;
					}
					if ($k >= 70) {
						break;
					}
					$checked = '';
					if ($arPet[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>ペットの宿泊条件</p>
		</th>
		<td align="left">
			<div class="checkboxarea">
			<?php
			if (count($dataPet) > 0) {
				foreach ($dataPet as $k=>$v) {
					if ($k < 70) {
						continue;
					}
					if ($k >= 80) {
						break;
					}
					$checked = '';
					if ($arPet[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="pet<?php print $k?>" name="pet[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="pet<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
			<?=$inputs->textarea("HOTEL_PET_MEMO3", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PET_MEMO3"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_PET_MEMO4", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PET_MEMO4"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>コメント・PR</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_PET_MEMO5", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PET_MEMO5"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>我が家の看板ペット</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_PET_MEMO6", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PET_MEMO6"), "imeActive circle",30,4)?>
			<p>看板ペットがいる場合は、ぜひご紹介ください。</p>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>受け付け</h3>
		</th>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>予約受付時間</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_RECEPT_FROM"))?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_RECEPT_TO"))?>
			<p><select name="HOTEL_TIME_RECEPT_FROM" class="circle ">
				<option value="">---</option>
				<?php
				for ($i = 0; $i < 96; $i++) {
					$t = date("H:i",strtotime("+". $i * 15 ." minute" ,strtotime("00:00")));
					$selected = '';
					if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_RECEPT_FROM") == $t) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $t?>" <?php print $selected?>><?php print $t?></option>
				<?php
				}
				?>
				<option value="24:00" <?php print ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_RECEPT_FROM")=="24:00"?'selected="selected"':"")?>>24:00</option>
			</select> ～
			<select name="HOTEL_TIME_RECEPT_TO" class="circle ">
				<option value="">---</option>
				<?php
				for ($i = 0; $i < 96; $i++) {
					$t = date("H:i",strtotime("+". $i * 15 ." minute" ,strtotime("00:00")));
					$selected = '';
					if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_RECEPT_TO") == $t) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $t?>" <?php print $selected?>><?php print $t?></option>
				<?php
				}
				?>
				<option value="24:00" <?php print ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_RECEPT_TO")=="24:00"?'selected="selected"':"")?>>24:00</option>
			</select></p>

		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>チェックイン時間</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKIN_FROM"))?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKIN_TO"))?>
			<p>
			<select name="HOTEL_TIME_CHECKIN_FROM" class="circle ">
				<option value="">---</option>
				<?php
				for ($i = 0; $i < 96; $i++) {
					$t = date("H:i",strtotime("+". $i * 15 ." minute" ,strtotime("00:00")));
					$selected = '';
					if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKIN_FROM") == $t) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $t?>" <?php print $selected?>><?php print $t?></option>
				<?php
				}
				?>
			</select> ～
			<select name="HOTEL_TIME_CHECKIN_TO" class="circle ">
				<option value="">---</option>
				<?php
				for ($i = 0; $i < 96; $i++) {
					$t = date("H:i",strtotime("+". $i * 15 ." minute" ,strtotime("00:00")));
					$selected = '';
					if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKIN_TO") == $t) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $t?>" <?php print $selected?>><?php print $t?></option>
				<?php
				}
				?>
			</select></p>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>チェックアウト時間</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKOUT_FROM"))?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKOUT_TO"))?>
			<p>
			<select name="HOTEL_TIME_CHECKOUT_FROM" class="circle ">
				<option value="">---</option>
				<?php
				for ($i = 0; $i < 96; $i++) {
					$t = date("H:i",strtotime("+". $i * 15 ." minute" ,strtotime("00:00")));
					$selected = '';
					if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKOUT_FROM") == $t) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $t?>" <?php print $selected?>><?php print $t?></option>
				<?php
				}
				?>
			</select> ～
			<select name="HOTEL_TIME_CHECKOUT_TO" class="circle ">
				<option value="">---</option>
				<?php
				for ($i = 0; $i < 96; $i++) {
					$t = date("H:i",strtotime("+". $i * 15 ." minute" ,strtotime("00:00")));
					$selected = '';
					if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKOUT_TO") == $t) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $t?>" <?php print $selected?>><?php print $t?></option>
				<?php
				}
				?>
			</select></p>
		</td>
	</tr>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>食事</h3>
		</th>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>個室で食事</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>朝食</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FOOD_DATA1"))?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA11", "HOTEL_FOOD_DATA1", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA1") ," あり")?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA12", "HOTEL_FOOD_DATA1", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA1") ," なし")?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>夕食</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FOOD_DATA2"))?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA21", "HOTEL_FOOD_DATA2", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA2") ," あり")?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA22", "HOTEL_FOOD_DATA2", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA2") ," なし")?>
					</td>
				</tr>
			</table>
		</td>
	<tr>
		<th valign="top" width="160">
			<p>部屋だし</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top" width="90">
						<p>朝食</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FOOD_DATA3"))?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA31", "HOTEL_FOOD_DATA3", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA3") ," あり")?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA32", "HOTEL_FOOD_DATA3", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA3") ," なし")?>
					</td>
				</tr>
				<tr>
					<th valign="top" width="90">
						<p>夕食</p>
					</th>
					<td align="left">
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FOOD_DATA4"))?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA41", "HOTEL_FOOD_DATA4", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA4") ," あり")?>
						<?php print $inputs->radio("HOTEL_FOOD_DATA42", "HOTEL_FOOD_DATA4", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FOOD_DATA4") ," なし")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>宿泊者特典</h3>
		</th>
	</tr>
	<tr>
		<td align="left">
			<?php
			$arStay = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_STAY_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arStay[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			$dataStay = cmHotelStay();
			if (count($dataStay) > 0) {
				foreach ($dataStay as $k=>$v) {
					if ($k >= 10) {
						break;
					}
					$checked = '';
					if ($arStay[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="stay<?php print $k?>" name="stay[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="stay<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
			<br />
			<p>備考</p>
			<?=$inputs->textarea("HOTEL_STAY_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_STAY_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>利用可能カード</h3>
		</th>
	</tr>
	<tr>
		<th width="160">
			<p>利用可否</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_CARD_FLG"))?>
			<?php print $inputs->radio("HOTEL_CARD_FLG1", "HOTEL_CARD_FLG", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CARD_FLG") ," 利用可")?>
			<?php print $inputs->radio("HOTEL_CARD_FLG2", "HOTEL_CARD_FLG", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CARD_FLG") ," 利用不可")?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>カード</p>
		</th>
		<td align="left">
			<?php
			$arCard = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CARD_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arCard[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			$dataCard = cmHotelCard();
			if (count($dataCard) > 0) {
				foreach ($dataCard as $k=>$v) {
					$checked = '';
					if ($arCard[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="card<?php print $k?>" name="card[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="card<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_CARD_MEMO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CARD_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>館内のバリアフリー対応状況</h3>
		</th>
	</tr>
	<tr>
		<td align="left">
			<?php
			$arDisabled = array();
			$arTemp = explode(":", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_DISABLED"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arDisabled[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			$dataDisabled = cmHotelDisabled();
			if (count($dataDisabled) > 0) {
				foreach ($dataDisabled as $k=>$v) {
					$checked = '';
					if ($arDisabled[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="disabled<?php print $k?>" name="disabled[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="disabled<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>ご宿泊の条件・注意事項</h3>
		</th>
	</tr>
	<tr>
		<td align="left">
			<?=$inputs->textarea("HOTEL_CAUTION", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CAUTION"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />
-->
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>諸税設定</h3>
		</th>
	</tr>
	<tr>
		<th valign="top" width="160">
			<!--<p>入浴税の設定</p>-->
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_TAX"))?>
			<?php print $inputs->radio("HOTEL_SPA_TAX1", "HOTEL_SPA_TAX", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_TAX") ," あり")?>
			<?php print $inputs->radio("HOTEL_SPA_TAX2", "HOTEL_SPA_TAX", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_TAX") ," なし")?>
		</td>
	</tr>
</table>
<br />



<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","ホテル基本情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>
