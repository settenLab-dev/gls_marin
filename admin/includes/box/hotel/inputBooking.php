<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" widtd="100%">
	<?php
	if ($shopBooking->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($shopBooking->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td widtd="160" valign="top">
			<p>予約方法 <span class="colorRed">※</span></p>
		</td>
		<td align="left"> 
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_HOW"))?>
				<?php $arData = cmShopBookingHow();?>
				<?php if (count($arData) > 0) {?>
				<select name="BOOKING_HOW" class="circle" onChange='keisan()' >
					<?php foreach ($arData as $k=>$v) {?>
					<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_HOW")==$k)?'selected="selected"':''?>><?php print $v;?></option>
					<?php }?>
				</select>
				<?php }?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>対応状況 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_SHOP_STATUS"))?>
				<?php $arData = cmShopBookingStatus();?>
				<?php if (count($arData) > 0) {?>
				<select name="BOOKING_SHOP_STATUS" class="circle" onChange='keisan()' >
					<?php foreach ($arData as $k=>$v) {?>
					<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_SHOP_STATUS")==$k)?'selected="selected"':''?>><?php print $v;?></option>
					<?php }?>
				</select>
				<?php }?>

		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>プラン <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php if ($shopPlan->getCount() > 0) {?>
			<select id="SHOPPLAN_ID" name="SHOPPLAN_ID" class="circle" style="width:100%;" onfocus="this.style.width='100%';" onblur="this.style.width='100%';">
				<option value="0" selected="selected">【プラン 未設定】</option>
				<?php
				foreach ($shopPlan->getCollection() as $h) {
					$selected = '';
					if ($h["SHOPPLAN_ID"] == $shopBooking->getByKey($shopBooking->getKeyValue(), "SHOPPLAN_ID")) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $h["SHOPPLAN_ID"]?>" <?php print $selected?>><?php print $h["SHOPPLAN_NAME"]?></option>
				<?php }?>
			</select>
			<?php }else {?>
				<p>設定可能なプランがありません</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>在庫タイプ <span class="colorRed">※</span></p>
		</td>
		<td align="left"> 
			<?php if ($hotelRoom->getCount() > 0) {?>
			<select id="ROOM_ID" name="ROOM_ID" class="circle" style="width:100%;" onfocus="this.style.width='100%';" onblur="this.style.width='100%';">
				<option value="0" selected="selected">【在庫 未設定】 ※自動で在庫を引き落とししません</option>
				<?php
				foreach ($hotelRoom->getCollection() as $h) {
					$selected = '';
					if ($h["ROOM_ID"] == $shopBooking->getByKey($shopBooking->getKeyValue(), "ROOM_ID")) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $h["ROOM_ID"]?>" <?php print $selected?>><?php print $h["ROOM_NAME"]?></option>
				<?php }?>
			</select>
			<?php }else {?>
				<p>設定可能な在庫タイプがありません</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>催行日 <span class="colorRed">※</span></p>
		</td>
		<td align="left"> 0000-00-00の形式で入力 or カレンダーから選択<br/>
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_DATE"))?>
			<?php print $inputs->text("BOOKING_DATE", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE") ,"imeDisabled circle wNum",50)?>

			<script type="text/javascript">
			$(function() {
				$("#BOOKING_DATE").datepicker({
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
		<td widtd="160" valign="top">
			<p>集合時間 <span class="colorRed">※</span></p>
		</td>
		<td align="left"> ※00：00の形式で入力<br/>
			<?php print $inputs->text("BOOKING_MEET_TIME", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MEET_TIME") ,"imeDisabled circle wNum",50)?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>集合場所 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php if ($ShopAccess->getCount() > 0) {?>
			<select id="BOOKING_MEET_PLACE" name="BOOKING_MEET_PLACE" class="circle" style="width:100%;" onfocus="this.style.width='100%';" onblur="this.style.width='100%';">
				<option value="0" selected="selected">【集合場所 未設定】</option>
				<?php
				foreach ($ShopAccess->getCollection() as $h) {
					$selected = '';
					if ($h["SHOP_ACCESS_ID"] == $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MEET_PLACE")) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $h["SHOP_ACCESS_ID"]?>" <?php print $selected?>><?php print $h["SHOP_ACCESS_NAME"]?></option>
				<?php }?>
			</select>
			<?php }else {?>
				<p>設定可能な集合場所がありません</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">料金の登録</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>料金の種類  <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<?php if ($shopBooking->getByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND") > 0) {?>
				<?php if ($shopBooking->getByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND") == 1) {?>
					<?php  print $inputs->radio("SHOP_PRICETYPE_KIND1", "SHOP_PRICETYPE_KIND", 1, $shopBooking->getByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND") ," 1名様ごとの料金を設定")?>
				<?php }elseif ($shopBooking->getByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND") == 2) {?>
					<?php  print $inputs->radio("SHOP_PRICETYPE_KIND2", "SHOP_PRICETYPE_KIND", 2, $shopBooking->getByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND") ," グループごとの料金を設定（貸切等)")?>
				<?php } ?>

			<?php }else{?>

			<p><span class="colorRed">※一度登録すると変更できません</span></p>
			<?php print create_error_msg($shopBooking->getErrorByKey("SHOP_PRICETYPE_KIND"))?>
	
			<input type="radio" id="SHOP_PRICETYPE_KIND1" name="SHOP_PRICETYPE_KIND" value="1"  checked /><label for="SHOP_PRICETYPE_KIND1" > 1名様ごとの料金を設定</label>
			<input type="radio" id="SHOP_PRICETYPE_KIND2" name="SHOP_PRICETYPE_KIND" value="2"  /><label for="SHOP_PRICETYPE_KIND2" > グループごとの料金を設定（貸切等)</label>
			<?php }?>

		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約人数と料金 <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<table id="person" border="0" cellpadding="0" cellspacing="0" class="" summary="マスタデータ" width="100%">
				<tr>
					<th>種別</th>
					<th>対象年齢/備考</th>
					<th>人数</th>
					<th>料金/人</th>
				</tr>
				<tr>
					<td>
						<select name="BOOKING_MONEYKIND1" class="circle">
							<option value="1" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND1")==1)?'selected="selected"':''?>>大人</option>
							<option value="2" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND1")==2)?'selected="selected"':''?>>小人</option>
							<option value="3" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND1")==3)?'selected="selected"':''?>>幼児</option>
							<option value="4" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND1")==4)?'selected="selected"':''?>>一律</option>
						</select>
					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE1", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE1") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON1" class="circle" onChange='keisan()' >
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 人
						<?php }?>
					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY1", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY1") ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
				<tr>
					<td>
						<select name="BOOKING_MONEYKIND2" class="circle">
							<option value="0">---</option>
							<option value="1" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND2")==1)?'selected="selected"':''?>>大人</option>
							<option value="2" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND2")==2)?'selected="selected"':''?>>小人</option>
							<option value="3" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND2")==3)?'selected="selected"':''?>>幼児</option>
							<option value="4" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND2")==4)?'selected="selected"':''?>>一律</option>
						</select>
					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE2", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE2") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON2" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON2")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 人
						<?php }?>					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY2", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY2") ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
				<tr>
					<td>
						<select name="BOOKING_MONEYKIND3" class="circle">
							<option value="0">---</option>
							<option value="1" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND3")==1)?'selected="selected"':''?>>大人</option>
							<option value="2" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND3")==2)?'selected="selected"':''?>>小人</option>
							<option value="3" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND3")==3)?'selected="selected"':''?>>幼児</option>
							<option value="4" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND3")==4)?'selected="selected"':''?>>一律</option>
						</select>
					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE3", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE3") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON3" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON3")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 人
						<?php }?>					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY3", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY3") ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
				<tr>
					<td>
						<select name="BOOKING_MONEYKIND4" class="circle">
							<option value="0">---</option>
							<option value="1" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND4")==1)?'selected="selected"':''?>>大人</option>
							<option value="2" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND4")==2)?'selected="selected"':''?>>小人</option>
							<option value="3" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND4")==3)?'selected="selected"':''?>>幼児</option>
							<option value="4" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND4")==4)?'selected="selected"':''?>>一律</option>
						</select>					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE4", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE4") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON4" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON4")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 人
						<?php }?>					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY4", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY4") ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
				<tr>
					<td>
						<select name="BOOKING_MONEYKIND5" class="circle">
							<option value="0">---</option>
							<option value="1" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND5")==1)?'selected="selected"':''?>>大人</option>
							<option value="2" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND5")==2)?'selected="selected"':''?>>小人</option>
							<option value="3" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND5")==3)?'selected="selected"':''?>>幼児</option>
							<option value="4" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND5")==4)?'selected="selected"':''?>>一律</option>
						</select>					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE5", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE5") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON5" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON5")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 人
						<?php }?>					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY5", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY5") ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
				<tr>
					<td>
						<select name="BOOKING_MONEYKIND6" class="circle">
							<option value="0">---</option>
							<option value="1" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND6")==1)?'selected="selected"':''?>>大人</option>
							<option value="2" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND6")==2)?'selected="selected"':''?>>小人</option>
							<option value="3" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND6")==3)?'selected="selected"':''?>>幼児</option>
							<option value="4" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEYKIND6")==4)?'selected="selected"':''?>>一律</option>
						</select>					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE6", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE6") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON6" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON6")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 人
						<?php }?>					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY6", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY6") ,"imeDisabled circle wNum",50)?> 円
					</td>

				</tr>
			</table>
			<table id="group" border="0" cellpadding="0" cellspacing="0" class="" summary="マスタデータ" width="100%">
				<tr>
					<th>種別</th>
					<th>対象人数/備考</th>
					<th>人数・組数</th>
					<th>料金</th>
				</tr>
				<tr>
					<td>
						グループ単位
					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE7", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE7") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON7" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON7")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 組
						<?php }?>
					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY7", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY7") ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
				<tr>
					<td>
						人数追加
					</td>
					<td>
						<?php print $inputs->text("BOOKING_PRICETYPE8", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICETYPE8") ,"imeDisabled circle wNum",50)?>
					</td>
					<td>
						<?php $arData = cmShopPersonSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="BOOKING_PRICEPERSON8" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON8")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> 人
						<?php }?>
					</td>
					<td>
						<?php print $inputs->text("BOOKING_MONEY8", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY8") ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
			</table>
		</td>
				<tr>
					<th>
						合計料金
					</th>
					<td> ※登録時に自動で計算します。
						
						<?php if ($shopBooking->getByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND") == 1){
							$money1 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON1")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY1"));
							$money2 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON2")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY2"));
							$money3 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON3")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY3"));
							$money4 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON4")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY4"));
							$money5 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON5")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY5"));
							$money6 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON6")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY6"));

							$all_money = $money1+$money2+$money3+$money4+$money5+$money6;

						      }elseif ($shopBooking->getByKey($shopBooking->getKeyValue(), "SHOP_PRICETYPE_KIND") == 2){
							$money7 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON7")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY7"));
							$money8 = ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON8")) * ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY8"));

							$all_money = $money7+$money8;
						      }?>
							<input type="text" id="BOOKING_ALL_MONEY" name="BOOKING_ALL_MONEY" value="<?php print $all_money;?>" class="imeDisabled circle wNum" size="50"   /> 円

					</td>
				</tr>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>決済方法 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_PAYMENT"))?>
			<?php print $inputs->radio("BOOKING_PAYMENT1", "BOOKING_PAYMENT", 1, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PAYMENT") ," 現地で現金決済")?>
			<?php print $inputs->radio("BOOKING_PAYMENT2", "BOOKING_PAYMENT", 2, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PAYMENT") ," 現地でカード決済")?>
			<?php print $inputs->radio("BOOKING_PAYMENT3", "BOOKING_PAYMENT", 3, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PAYMENT") ," 事前に現金決済")?>
			<?php print $inputs->radio("BOOKING_PAYMENT4", "BOOKING_PAYMENT", 4, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PAYMENT") ," 事前にカード決済")?>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="admin_title">予約者情報</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約代表者 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_NAME1"))?>
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_NAME2"))?>
			姓 <?php print $inputs->text("BOOKING_NAME1", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME1") ,"imeActive circle wNum",50)?>
			名 <?php print $inputs->text("BOOKING_NAME2", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME2") ,"imeActive circle wNum",50)?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約代表者(カナ) <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_KANA1"))?>
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_KANA2"))?>
			セイ <?php print $inputs->text("BOOKING_KANA1", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_KANA1") ,"imeActive circle wNum",50)?>
			メイ <?php print $inputs->text("BOOKING_KANA2", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_KANA2") ,"imeActive circle wNum",50)?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約者 住所 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<td valign="top">郵便番号</td>
					<td>
						<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_ZIP"))?>
						<?php print $inputs->text("BOOKING_ZIP", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'BOOKING_PREF_ID\',\'BOOKING_CITY\',\'BOOKING_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力</p>
					</td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td>
						<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_PREF_ID"))?>
						<?php
						$arPref = cmGetAllPrefName();
						?>
						<?php if (count($arPref) > 0) {?>
						<select name=BOOKING_PREF_ID id="BOOKING_PREF_ID" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PREF_ID")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						<?php }?>
		                </select>
					</td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td>
						<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_CITY"))?>
						<?php print $inputs->text("BOOKING_CITY", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>その他住所</td>
					<td>
						<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_ADDRESS"))?>
						<?php print $inputs->text("BOOKING_ADDRESS", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>建物名</td>
					<td>
						<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_BUILD"))?>
						<?php print $inputs->text("BOOKING_BUILD", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_BUILD") ,"imeActive circle", "50")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>電話番号 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_TEL"))?>
			<?php print $inputs->text("BOOKING_TEL", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_TEL") ,"imeDisabled circle wNum",50)?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>メールアドレス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_MAILADDRESS"))?>
			<?php print $inputs->text("BOOKING_MAILADDRESS", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS") ,"imeDisabled circle ",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>年齢 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print $inputs->text("BOOKING_AGE", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_AGE") ,"imeDisabled circle wNum",50)?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">ステータス・備考</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_STATUS"))?>
			<?php print $inputs->radio("BOOKING_STATUS1", "BOOKING_STATUS", 1, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_STATUS") ," 予約")?>
			<?php print $inputs->radio("BOOKING_STATUS5", "BOOKING_STATUS", 5, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_STATUS") ," リクエスト")?>
			<?php print $inputs->radio("BOOKING_STATUS2", "BOOKING_STATUS", 2, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_STATUS") ," キャンセル")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>管理メモ</p>
		</td>
		<td align="left">
			<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_MEMO"))?>
			<?=$inputs->textarea("BOOKING_MEMO", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
</ul>
			<br/><br/>
			<?php if ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_STATUS") == 5 || $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") != "") {
			?>			
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
			リクエスト回答・メッセージ送信
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<tr>
			<td width="160" valign="top">
				<p>予約リクエスト回答</p>
			</td>
			<td align="left">
				予約リクエスト回答：　<?php print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",1,$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") ,"予約可能") ?>
				&nbsp; <?php print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",2,$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") ,"受入れ不可") ?>
				<br/>※　必ずどちらかを選択してメッセージ送信をしてください。<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_REQUEST"))?>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>お客様へメッセージを送る</p>
			</td>
			<td align="left"> 
				<?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER")?$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER"):$inputs->textarea("BOOKING_REQUEST_ANSWER", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER") ,"imeActive circle",50) ?>
				<br/>※お客様へのメッセージを入力してください。<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_REQUEST_ANSWER"))?>
			</td>
			</tr>
			</table>
			
			<br/>
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center">
						<?=$inputs->submit("requestConfirm","requestConfirm","メッセージ送信", "circle")?>
					</td>
				</tr>
			</table> 
			</form>
			<?php }?>
<?php print $inputs->hidden(constant("shopBooking::keyName"), $shopBooking->getKeyValue())?>
<?php print $inputs->hidden("COMPANY_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"))?>
