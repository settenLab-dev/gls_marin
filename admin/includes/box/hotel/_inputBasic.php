<?php if ($hotel->getErrorCount() > 0) {?>
<?php print create_error_caption($hotel->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>施設概要</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>ホテル名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_NAME"))?>
			<?php print $inputs->text("HOTEL_NAME", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>ホテル名(カナ) <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_NAME_KANA"))?>
			<?php print $inputs->text("HOTEL_NAME_KANA", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME_KANA") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>キャッチコピー <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_CATCHCOPY"))?>
			<?=$inputs->textarea("HOTEL_CATCHCOPY", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CATCHCOPY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>宿種 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php $ar = cmHotelKind();?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FLG_KIND"))?>
			<div class="labelNoWrap">
			<?php if (count($ar) > 0) {?>
			<ul>
			<?php foreach ($ar as $k=>$v) {?>
			<li><?php print $inputs->radio("HOTEL_FLG_KIND".$k, "HOTEL_FLG_KIND", $k, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FLG_KIND") ," ".$v)?></li>
			<?php }?>
			</ul>
			<?php }?>
			</div>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>公共の宿 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_FLG_PUBLIC"))?>
			<?php print $inputs->radio("HOTEL_FLG_PUBLIC1", "HOTEL_FLG_PUBLIC", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FLG_PUBLIC") ," 該当する")?>
			<?php print $inputs->radio("HOTEL_FLG_PUBLIC2", "HOTEL_FLG_PUBLIC", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_FLG_PUBLIC") ," 該当しない")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ホテル住所 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top">郵便番号</th>
					<td>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ZIP"))?>
						<?php print $inputs->text("HOTEL_ZIP", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'HOTEL_PREF\',\'HOTEL_CITY\',\'HOTEL_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
						<p>自動で住所が入力されます。</p>
					</td>
				</tr>
				<tr>
					<th>都道府県</th>
					<td>
					<?php
					$arPref = cmGetPrefName();
					if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") == 3) {
					?>
					<p><?php print $arPref[$hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF")]?></p>
					<?php print $inputs->hidden("HOTEL_PREF", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF") ,"imeDisabled circle wNum",50)?>
					<?php
					}
					else {
					?>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_PREF"))?>
						<?php if (count($arPref) > 0) {?>
						<select name="HOTEL_PREF" id="HOTEL_PREF" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_PREF")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						<?php }?>
		                </select>
		             <?php
		             }
		             ?>
					</td>
				</tr>
				<tr>
					<th>市区町村</th>
					<td>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_CITY"))?>
						<?php print $inputs->text("HOTEL_CITY", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<th>その他住所</th>
					<td>
						<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ADDRESS"))?>
						<?php print $inputs->text("HOTEL_ADDRESS", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS") ,"imeActive circle", "50")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TEL"))?>
			<?php print $inputs->text("HOTEL_TEL", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TEL") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>外観写真 </p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_PIC_APP"))?>
			<?=$inputs->image("HOTEL_PIC_APP", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_PIC_APP"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>
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
	<tr>
		<th valign="top">
			<p>パーキング</p>
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
			<p>送迎サービス</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
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
</table>
<br />



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
		<th valign="top">
			<p>洋室合計</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA2"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA2", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA2") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>洋室内訳</p>
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
									<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA8"))?>
									<p><?php print $inputs->text("HOTEL_ROOM_DATA10", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA10") ,"imeDisabled circle wTime",50)?>㎡ ～
									<?php print $inputs->text("HOTEL_ROOM_DATA11", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA11") ,"imeDisabled circle wTime",50)?>㎡</p>
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
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>和室数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA13"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA13", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA13") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>和洋室数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA14"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA14", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA14") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>和洋室数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA14"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA14", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA14") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>その他<br />トリプル、4ベッドなど</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_ROOM_DATA15"))?>
			<?php print $inputs->text("HOTEL_ROOM_DATA15", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ROOM_DATA15") ,"imeDisabled circle wNum",50)?> 室
		</td>
	</tr>
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
			<p>温泉の特徴</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("HOTEL_SPA_REMARKS", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_REMARKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
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
			<p>露天風呂利用条件</p>
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
			<p class="colorRed">※「全室」となっているものは全室に配置されていなければ、「ある」にできません。</p>
		</th>
	</tr>
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
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>施設</h3>
		</th>
	</tr>
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
			<p><?php print $inputs->text("HOTEL_TIME_RECEPT_FROM", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_RECEPT_FROM") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle1","クリア"," circle",'onclick="$(\'#HOTEL_TIME_RECEPT_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("HOTEL_TIME_RECEPT_TO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_RECEPT_TO") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle2","クリア"," circle",'onclick="$(\'#HOTEL_TIME_RECEPT_TO\').val(\'\');"')?></p>
			<script type="text/javascript">
				$(function(){
	              $('#HOTEL_TIME_RECEPT_FROM').timepickr({trigger:'click'});
	              $('#HOTEL_TIME_RECEPT_TO').timepickr({trigger:'click'});
	            });
			</script>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>チェックイン時間</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKIN_FROM"))?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKIN_TO"))?>
			<p><?php print $inputs->text("HOTEL_TIME_CHECKIN_FROM", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKIN_FROM") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle1","クリア"," circle",'onclick="$(\'#HOTEL_TIME_CHECKIN_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("HOTEL_TIME_CHECKIN_TO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKIN_TO") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle2","クリア"," circle",'onclick="$(\'#HOTEL_TIME_CHECKIN_TO\').val(\'\');"')?></p>
			<script type="text/javascript">
				$(function(){
	              $('#HOTEL_TIME_CHECKIN_FROM').timepickr({trigger:'click'});
	              $('#HOTEL_TIME_CHECKIN_TO').timepickr({trigger:'click'});
	            });
			</script>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>チェックアウト時間</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKOUT_FROM"))?>
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_TIME_CHECKOUT_TO"))?>
			<p><?php print $inputs->text("HOTEL_TIME_CHECKOUT_FROM", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKOUT_FROM") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle1","クリア"," circle",'onclick="$(\'#HOTEL_TIME_CHECKOUT_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("HOTEL_TIME_CHECKOUT_TO", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TIME_CHECKOUT_TO") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle2","クリア"," circle",'onclick="$(\'#HOTEL_TIME_CHECKOUT_TO\').val(\'\');"')?></p>
			<script type="text/javascript">
				$(function(){
	              $('#HOTEL_TIME_CHECKOUT_FROM').timepickr({trigger:'click'});
	              $('#HOTEL_TIME_CHECKOUT_TO').timepickr({trigger:'click'});
	            });
			</script>
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
			<h3>諸税設定</h3>
		</th>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>入浴税の設定</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotel->getErrorByKey("HOTEL_SPA_TAX"))?>
			<?php print $inputs->radio("HOTEL_SPA_TAX1", "HOTEL_SPA_TAX", 1, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_TAX") ," あり")?>
			<?php print $inputs->radio("HOTEL_SPA_TAX2", "HOTEL_SPA_TAX", 2, $hotel->getByKey($hotel->getKeyValue(), "HOTEL_SPA_TAX") ," なし")?>
		</td>
	</tr>
</table>
<br />


<ul class="buttons">
	<li><?=$inputs->submit("","regist","ホテル基本情報を保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("hotel::keyName"), $hotel->getKeyValue())?>
