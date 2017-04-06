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
			<p><?php print cmKeyCheck(constant("hotel::keyName"))?><?php print str_pad($hotelPlan->getKeyValue(), 8, "0", STR_PAD_LEFT);?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
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
			<p>売り出し期間 <span class="colorRed">※</span></p>
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
					changeMontd: true,
	                changeYear: true,
	                montdNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土'],
				});
				$("#HOTELPLAN_DATE_SALE_TO").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMontd: true,
	                changeYear: true,
	                montdNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土'],
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
		<td valign="top">
			<p>プランの特徴</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_FEATURE"))?>
			<?=$inputs->textarea("HOTELPLAN_FEATURE", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FEATURE"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>予約受け付け・<span class="colorRed">※</span><br />予約変更締切</p>
		</td>
		<td align="left">
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

			<?php /*
			<?php $arData = cmHotelHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_ACC_HOUR" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_HOUR")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_ACC_MIN" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
			*/?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>予約キャンセル締切</p>
		</td>
		<td align="left">
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

			<?php /*
			<?php $arData = cmHotelHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_HOUR1" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_HOUR1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_MIN1" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_MIN1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
			*/?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>チェックイン時間 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN"))?>
			<?php print $inputs->text("HOTELPLAN_CHECKIN", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle3","クリア"," circle",'onclick="$(\'#HOTELPLAN_CHECKIN\').val(\'\');"')?>
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_CHECKIN').timepickr({trigger:'click'});
	            });
			</script>

			<?php /*
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_HOUR1"))?>
			<?php $arData = cmHotelHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_HOUR1" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_HOUR1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_MIN1" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_MIN1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
			*/?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>チェックイン時間(最終) <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_LAST"))?>
			<?php print $inputs->text("HOTELPLAN_CHECKIN_LAST", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_LAST") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle4","クリア"," circle",'onclick="$(\'#HOTELPLAN_CHECKIN_LAST\').val(\'\');"')?>
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_CHECKIN_LAST').timepickr({trigger:'click'});
	            });
			</script>
			<?php /*
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_HOUR2"))?>
			<?php $arData = cmHotelHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_HOUR2" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_HOUR2")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_MIN2" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_MIN2")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
			*/?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>チェックアウト時間 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKOUT"))?>
			<?php print $inputs->text("HOTELPLAN_CHECKOUT", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKOUT") ,"imeDisabled circle wTime",50)?> <?php print $inputs->button("","cle5","クリア"," circle",'onclick="$(\'#HOTELPLAN_CHECKOUT\').val(\'\');"')?>
			<script type="text/javascript">
				$(function(){
	              $('#HOTELPLAN_CHECKOUT').timepickr({trigger:'click'});
	            });
			</script>

			<?php /*>
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_CHECKIN_HOUR2"))?>
			<?php $arData = cmHotelHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_HOUR2" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_HOUR2")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="HOTELPLAN_CHECKIN_MIN2" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CHECKIN_MIN2")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
			*/?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>最短連泊数 <span class="colorRed">※</span></p>
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
			<p>最長連泊数 <span class="colorRed">※</span></p>
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
			<table class="inner" cellspacing="5">
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
					<td valign="top">夕食</td>
					<td align="left">
						<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DN_FLG"))?>
						<?php print $inputs->radio("HOTELPLAN_DN_FLG1", "HOTELPLAN_DN_FLG", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") ," なし")?>
						<?php print $inputs->radio("HOTELPLAN_DN_FLG2", "HOTELPLAN_DN_FLG", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_FLG") ," 付き")?>
						<?=$inputs->checkbox("HOTELPLAN_DN_CHECK1","HOTELPLAN_DN_CHECK1",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_CHECK1")," 部屋だし", "")?>
						<?=$inputs->checkbox("HOTELPLAN_DN_CHECK2","HOTELPLAN_DN_CHECK2",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DN_CHECK2")," 個室利用", "")?>
					</td>
				</tr>
			</table>
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
			<p>宿への要望を聞く</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("HOTELPLAN_DEMAND"))?>
			<?=$inputs->checkbox("HOTELPLAN_DEMAND","HOTELPLAN_DEMAND",1,$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION_REC")," 予約者へ宿への要望を聞く", "")?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($hotelPlan->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("hotelPlan::keyName"), $hotelPlan->getKeyValue())?>
