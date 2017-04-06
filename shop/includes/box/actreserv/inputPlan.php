<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" widtd="100%">
	<?php
	if ($hotelPlan->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelPlan->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>プランコード</p>
		</td>
		<td align="left">
			<?php if ($hotelPlan->getKeyValue() > 0) {?>
			<p><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")?><?php print str_pad($hotelPlan->getKeyValue(), 8, "0", STR_PAD_LEFT);?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>プラン設定</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_FLG_DAYUSE"))?>
			<!--<?php print $inputs->radio("HOTELPLAN_FLG_DAYUSE1", "HOTELPLAN_FLG_DAYUSE", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_DAYUSE") ," 通常プラン")?>-->
			<!--<?php print $inputs->radio("HOTELPLAN_FLG_DAYUSE2", "HOTELPLAN_FLG_DAYUSE", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_DAYUSE") ," 日帰りプラン")?>-->
			<?php print $inputs->radio("HOTELPLAN_FLG_DAYUSE3", "HOTELPLAN_FLG_DAYUSE", 3, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_DAYUSE") ," 通常レジャープラン")?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>売り出す部屋 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("room"))?>
			<?php
			$arRoom = array();
			$arTemp = explode(":", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ROOM_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arRoom[$data] = $data;
					}
				}
			}

			if ($hotelRoom->getCount() >0) {
			?>
			<div class="labelNoWrap">
				<ul>
			<?php
				foreach ($hotelRoom->getCollection() as $d) {
					$checked = '';
					if ($arRoom[$d["ROOM_ID"]] != "") {
						$checked = 'checked="checked"';
					}
			?>
			<li><input type="checkbox" id="room<?php print $d["ROOM_ID"]?>" name="room[<?php print $d["ROOM_ID"]?>]" value="<?php print $d["ROOM_ID"]?>" <?php print $checked;?> <?php print $disabled;?> /><label for="room<?php print $d["ROOM_ID"]?>"> <?php print $d["ROOM_NAME"]?></label></li>
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
		<td widtd="160" valign="top">
			<p>販売期間 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DATE_SALE_FROM"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DATE_SALE_TO"))?>
			<?php print $inputs->text("HOTELPLAN_DATE_SALE_FROM", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#HOTELPLAN_DATE_SALE_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("HOTELPLAN_DATE_SALE_TO", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_SALE_TO") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#HOTELPLAN_DATE_SALE_TO\').val(\'\');"')?>

			<script type="text/javascript">
			$(function() {
				$("#HOTELPLAN_DATE_SALE_FROM").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
				$("#HOTELPLAN_DATE_SALE_TO").datepicker({
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
			<p>掲載期間 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DATE_POST_FROM"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DATE_POST_TO"))?>
			<?php print $inputs->text("HOTELPLAN_DATE_POST_FROM", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_POST_FROM") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#HOTELPLAN_DATE_POST_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("HOTELPLAN_DATE_POST_TO", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_POST_TO") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#HOTELPLAN_DATE_POST_TO\').val(\'\');"')?>

			<script type="text/javascript">
			$(function() {
				$("#HOTELPLAN_DATE_POST_FROM").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
				$("#HOTELPLAN_DATE_POST_TO").datepicker({
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
			<p>プラン名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_NAME"))?>
			<?php print $inputs->text("HOTELPLAN_NAME", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME") ,"imeActive circle",50)?>
			<p>※全角50文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>プラン画像1</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_PIC"))?>
			<?=$inputs->image("HOTELPLAN_PIC", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_PIC"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

				<?php if ($hotelPic->getCount() > 0) {?>
				<a href="hotelGalleryEdit.html?id=HOTELPLAN_PIC" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("HOTELPLAN_PIC_setup", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_PIC_setup") ,"imeDisabled circle wNum",50)?>
				<a href="hotelGalleryEdit.html?id=HOTELPLAN_PIC" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>

		</td>
	</tr>
	<?php for ($i=2; $i<=4; $i++) {?>
	<tr>
		<td widtd="160" valign="top">
			<p>プラン画像<?php print $i?></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_PIC".$i))?>
			<?=$inputs->image("HOTELPLAN_PIC".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

				<?php if ($hotelPic->getCount() > 0) {?>
				<a href="hotelGalleryEdit.html?id=HOTELPLAN_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("HOTELPLAN_PIC".$i."_setup", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
				<a href="hotelGalleryEdit.html?id=HOTELPLAN_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>

		</td>
	</tr>
	<?php }?>
	<tr>
		<td widtd="160" valign="top">
			<p>一日の部屋数制限 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_ROOM_NUM"))?>
			<?php print $inputs->text("HOTELPLAN_ROOM_NUM", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ROOM_NUM") ,"imeDisabled circle wNum",50)?> 室
			<?php
			if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ROOM_NUM") != "") {
				if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_POST_FROM") != "" and $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_POST_TO") != "") {
					print ' （上限部屋数：'.(intval($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ROOM_NUM")) * cmDateDiff($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_POST_FROM"), $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DATE_POST_TO")))." 室）";
				}
			}
			?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>シークレット設定 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_FLG_SEACRET"))?>
			<?php print $inputs->radio("HOTELPLAN_FLG_SEACRET1", "HOTELPLAN_FLG_SEACRET", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_SEACRET") ," シークレットを設定")?>
			<!--<?php print $inputs->radio("HOTELPLAN_FLG_SEACRET2", "HOTELPLAN_FLG_SEACRET", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_SEACRET") ," 設定しない")?>-->
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>決済方法 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_PAYMENT"))?>
			<?php print $inputs->radio("HOTELPLAN_PAYMENT1", "HOTELPLAN_PAYMENT", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_PAYMENT") ," 現地決済")?>
			<?php print $inputs->radio("HOTELPLAN_PAYMENT2", "HOTELPLAN_PAYMENT", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_PAYMENT") ," 事前支払")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>プランの内容 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_FEATURE"))?>
			<?=$inputs->textarea("HOTELPLAN_FEATURE", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FEATURE"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>備考</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CONTENTS"))?>
			<?=$inputs->textarea("HOTELPLAN_CONTENTS", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CONTENTS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>予約受け付け・<span class="colorRed">※</span><br />予約変更締切</p>
		</td>
		<td align="left">
			<?php /*
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_ACC_DAY"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_ACC"))?>

			<p>
			<?php $arData = cmHotelDaySelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_ACC_DAY" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_DAY")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select>
			<?php }?>

			<?php print $inputs->text("HOTELPLAN_ACC", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle1","クリア"," circle",'onclick="$(\'#HOTELPLAN_ACC\').val(\'\');"')?>

			</p>
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_ACC').timepickr({trigger:'click'});
	            });
			</script>
			*/?>

			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_ACC_DAY"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_ACC_HOUR"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_ACC_MIN"))?>

			<?php $arData = cmHotelDaySelect($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_DAY"));?>
			<?php if (count($arData) > 0) {?>
			<?php print $inputs->text("HOTELPLAN_ACC_DAY", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_DAY") ,"imeDisabled circle wNum",5)?> 日前
			<?php }?>

			<?php $arData = cmHotelHourSelect($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOUR"));?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_ACC_HOUR" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_HOUR")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MIN"));?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_ACC_MIN" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>予約キャンセル締切</p>
		</td>
		<td align="left">
			<?php /*
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CAN_DAY"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CAN"))?>
			<?php $arData = cmHotelDaySelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CAN_DAY" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select>
			<?php }?>

			<?php print $inputs->text("HOTELPLAN_CAN", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle2","クリア"," circle",'onclick="$(\'#HOTELPLAN_CAN\').val(\'\');"')?>

			</p>
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_CAN').timepickr({trigger:'click'});
	            });
			</script>
			*/?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CAN_DAY"))?>
			<?php $arData = cmHotelDaySelect($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DAY"));?>
			<!-- 
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CAN_DAY" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select>
			<?php }?>
			 -->
			<?php print $inputs->text("HOTELPLAN_CAN_DAY", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY") ,"imeDisabled circle wNum",5)?> 日前
			<?php $arData = cmHotelHourSelect($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_HOUR"));?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CAN_HOUR" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_MIN"));?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CAN_MIN" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>

		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>出発時間 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
		<!-- 
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN"))?>
			<?php print $inputs->text("HOTELPLAN_CHECKIN", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle3","クリア"," circle",'onclick="$(\'#HOTELPLAN_CHECKIN\').val(\'\');"')?>
			 -->
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_CHECKIN').timepickr({trigger:'click'});
	            });
			</script>

			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_HOUR1"))?>
			<?php $arData = cmHotelHourSelect_inputPlan();?>
			<?php 
			$whole = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN");
			$hour = explode(':', $whole);
			if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_HOUR1" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print (intval($hour[0])==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect_inputPlan();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_MIN1" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print (intval($hour[1])==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>出発時間(最終) <span class="colorRed">※</span></p>
		</td>
		<td align="left">
		<!-- 
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_LAST"))?>
			<?php print $inputs->text("HOTELPLAN_CHECKIN_LAST", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_LAST") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle4","クリア"," circle",'onclick="$(\'#HOTELPLAN_CHECKIN_LAST\').val(\'\');"')?>
			 -->
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_CHECKIN_LAST').timepickr({trigger:'click'});
	            });
			</script>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_HOUR2"))?>
			<?php $arData = cmHotelHourSelect_inputPlan();?>
			<?php 
			$whole = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_LAST");
			$hour = explode(':', $whole);
			if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_HOUR2" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print (intval($hour[0])==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect_inputPlan();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_MIN2" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print (intval($hour[1])==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>※入力不要 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
		<!-- 
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKOUT"))?>
			<?php print $inputs->text("HOTELPLAN_CHECKOUT", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKOUT") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle5","クリア"," circle",'onclick="$(\'#HOTELPLAN_CHECKOUT\').val(\'\');"')?>
			 -->
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_CHECKOUT').timepickr({trigger:'click'});
	            });
			</script>

			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_HOUR2"))?>
			<?php $arData = cmHotelHourSelect_inputPlan();?>
			<?php 
			$whole = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKOUT");
			$hour = explode(':', $whole);
			if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_HOUR3" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print (intval($hour[0])==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect_inputPlan();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_MIN3" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print (intval($hour[1])==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>最短連泊数 <span class="colorRed">※宿泊を伴わない場合は「制限なし」に設定</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_NIGHTS_FLG1"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_NIGHTS_NUM1"))?>
			<?php print $inputs->radio("HOTELPLAN_NIGHTS_FLG11", "HOTELPLAN_NIGHTS_FLG1", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NIGHTS_FLG1") ," 制限なし")?>
			<?php print $inputs->radio("HOTELPLAN_NIGHTS_FLG12", "HOTELPLAN_NIGHTS_FLG1", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NIGHTS_FLG1") ," 制限あり")?>
			(最低 <?php print $inputs->text("HOTELPLAN_NIGHTS_NUM1", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NIGHTS_NUM1") ,"imeDisabled circle wNum",50)?> 泊以上)
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>最長連泊数 <span class="colorRed">※宿泊を伴わない場合は「制限なし」に設定</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_NIGHTS_FLG2"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_NIGHTS_NUM2"))?>
			<?php print $inputs->radio("HOTELPLAN_NIGHTS_FLG21", "HOTELPLAN_NIGHTS_FLG2", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NIGHTS_FLG2") ," 制限なし")?>
			<?php print $inputs->radio("HOTELPLAN_NIGHTS_FLG22", "HOTELPLAN_NIGHTS_FLG2", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NIGHTS_FLG2") ," 制限あり")?>
			(最低 <?php print $inputs->text("HOTELPLAN_NIGHTS_NUM2", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NIGHTS_NUM2") ,"imeDisabled circle wNum",50)?> 泊以上)
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>食事設定 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5" width="100%">
				<tr>
					<td valign="top">朝食</td>
					<td align="left">
						<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_BF_FLG"))?>
						<?php print $inputs->radio("HOTELPLAN_BF_FLG1", "HOTELPLAN_BF_FLG", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") ," なし")?>
						<?php print $inputs->radio("HOTELPLAN_BF_FLG2", "HOTELPLAN_BF_FLG", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_FLG") ," 付き")?>
						<?=$inputs->checkbox("HOTELPLAN_BF_CHECK1","HOTELPLAN_BF_CHECK1",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_CHECK1")," 部屋だし", "")?>
						<?=$inputs->checkbox("HOTELPLAN_BF_CHECK2","HOTELPLAN_BF_CHECK2",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_BF_CHECK2")," 個室利用", "")?>
					</td>
				</tr>
				<tr>
					<td valign="top">朝食内容</td>
					<td align="left">
						<?=$inputs->textarea("HOTELPLAN_FOOD1", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FOOD1"), "imeActive circle",30,4)?>
					</td>
				</tr>
				<tr>
					<td valign="top">昼食</td>
					<td align="left">
						<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_LN_FLG"))?>
						<?php print $inputs->radio("HOTELPLAN_LN_FLG1", "HOTELPLAN_LN_FLG", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") ," なし")?>
						<?php print $inputs->radio("HOTELPLAN_LN_FLG2", "HOTELPLAN_LN_FLG", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_FLG") ," 付き")?>
						<?=$inputs->checkbox("HOTELPLAN_LN_CHECK1","HOTELPLAN_LN_CHECK1",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_CHECK1")," 部屋だし", "")?>
						<?=$inputs->checkbox("HOTELPLAN_LN_CHECK2","HOTELPLAN_LN_CHECK2",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_LN_CHECK2")," 個室利用", "")?>
					</td>
				</tr>
				<tr>
					<td valign="top">昼食内容</td>
					<td align="left">
						<?=$inputs->textarea("HOTELPLAN_FOOD2", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FOOD2"), "imeActive circle",30,4)?>
					</td>
				</tr>
				<tr>
					<td valign="top">夕食</td>
					<td align="left">
						<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DN_FLG"))?>
						<?php print $inputs->radio("HOTELPLAN_DN_FLG1", "HOTELPLAN_DN_FLG", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") ," なし")?>
						<?php print $inputs->radio("HOTELPLAN_DN_FLG2", "HOTELPLAN_DN_FLG", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") ," 付き")?>
						<?=$inputs->checkbox("HOTELPLAN_DN_CHECK1","HOTELPLAN_DN_CHECK1",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_CHECK1")," 部屋だし", "")?>
						<?=$inputs->checkbox("HOTELPLAN_DN_CHECK2","HOTELPLAN_DN_CHECK2",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_CHECK2")," 個室利用", "")?>
					</td>
				</tr>
				<tr>
					<td valign="top">夕食内容</td>
					<td align="left">
						<?=$inputs->textarea("HOTELPLAN_FOOD3", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FOOD3"), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>割引率</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DISCOUNT"))?>
			<?php print $inputs->text("HOTELPLAN_DISCOUNT", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DISCOUNT") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>キャンセルポリシー設定 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_FLG_CANCEL"))?>
			<?php print $inputs->radio("HOTELPLAN_FLG_CANCEL1", "HOTELPLAN_FLG_CANCEL", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_CANCEL") ," 標準設定")?>
			<?php print $inputs->radio("HOTELPLAN_FLG_CANCEL2", "HOTELPLAN_FLG_CANCEL", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_CANCEL") ," 個別設定")?>

			<table class="inner" id="candata" cellspacing="10">
			<?php for ($i=1; $i<=6; $i++) {?>
				<tr>
					<td valign="top" width="100">
						<?php if ($i == 1) {?>
						<p>無連絡不着</p>
						<?php }elseif ($i == 2) {?>
						<p>当日キャンセル</p>
						<?php }else {?>
						<p>設定<?php print $i?></p>
						<?php }?>
					</td>
					<td align="left">

						<table class="inner" cellspacing="10">
							<?php if ($i >= 3) {?>
							<tr>
								<td valign="top" width="80">キャンセル日</td>
								<td >
									<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CANCEL_FROM".$i))?>
									<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CANCEL_TO".$i))?>
									<p>宿泊日の<?php print $inputs->text("HOTELPLAN_CANCEL_FROM".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i) ,"imeDisabled circle wTime",50)?> 日前 ～
									<?php print $inputs->text("HOTELPLAN_CANCEL_TO".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i) ,"imeDisabled circle wTime",50)?> 日前までのキャンセル</p>
								</td>
							</tr>
							<?php }?>
							<tr >
								<td valign="top" width="80">料金設定</td>
								<td >
									<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CANCEL_FLG".$i))?>
									<?php print $inputs->radio("HOTELPLAN_CANCEL_FLG1".$i, "HOTELPLAN_CANCEL_FLG".$i, 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) ," パーセンテージ")?>
									<?php print $inputs->radio("HOTELPLAN_CANCEL_FLG2".$i, "HOTELPLAN_CANCEL_FLG".$i, 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) ," 固定料金")?>
								</td>
							</tr>
							<tr>
								<td valign="top" >料金</td>
								<td >
									<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CANCEL_MONEY".$i))?>
									<?php print $inputs->text("HOTELPLAN_CANCEL_MONEY".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) ,"imeDisabled circle wNum",50)?> ％ / 円
								</td>
							</tr>
						</table>

					</td>
				</tr>
			<?php }?>
			</table>

			<script type="text/javascript">
					$(function(){
					    $('#HOTELPLAN_FLG_CANCEL1').click(function(){
						    $('#candata').addClass('dspNon');
					  	});
					    $('#HOTELPLAN_FLG_CANCEL2').click(function(){
						    $('#candata').removeClass('dspNon');
					  	});

					    <?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1 or $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == "") {?>
					    $('#candata').addClass('dspNon');
					    <?php }?>
					});
			</script>

		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>予約者への質問</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_QUESTION"))?>
			<?=$inputs->textarea("HOTELPLAN_QUESTION", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION"), "imeActive circle",30,4)?>
			<?=$inputs->checkbox("HOTELPLAN_QUESTION_REC","HOTELPLAN_QUESTION_REC",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION_REC")," 予約者の回答を必須にする", "")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>お客様からの要望を聞く</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DEMAND"))?>
			<?=$inputs->checkbox("HOTELPLAN_DEMAND","HOTELPLAN_DEMAND",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DEMAND")," 予約者の要望を聞く", "")?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","●保存する", "circle")?></li>
	<li>　　　　　　　　　　　</li>
	<?php if ($hotelPlan->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","×削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("hotelPlan::keyName"), $hotelPlan->getKeyValue())?>
