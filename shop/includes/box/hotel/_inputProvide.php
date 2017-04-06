<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" widtd="100%">
	<?php
	if ($hotelPay->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelPay->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td widtd="160" valign="top">
			<p>日付</p>
		</td>
		<td align="left">
			<p><?php print $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE")?></p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>プラン名</p>
		</td>
		<td align="left">
			<p><?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME")?></p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>部屋タイプ名</p>
		</td>
		<td align="left">
			<p><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>販売ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPay->getErrorByKey("HOTELPAY_FLG_STOP"))?>
			<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_FLG_STOP") == 1) {?>
			<p>現在ステータスは「販売」に設定されています。</p>
			<?php }elseif ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_FLG_STOP") == 2) {?>
			<p>現在ステータスは「売止」に設定されています。</p>
			<?php }else{?>
			<p>現在ステータスは未設定です</p>
			<?php }?>
			<?php print $inputs->radio("HOTELPAY_FLG_STOP1", "HOTELPAY_FLG_STOP", 1, $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_FLG_STOP") ," 販売")?>
			<?php print $inputs->radio("HOTELPAY_FLG_STOP2", "HOTELPAY_FLG_STOP", 2, $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_FLG_STOP") ," 売止(キャンセル再販無し")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>提供部屋数の変更 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPay->getErrorByKey("HOTELPAY_ROOM_NUM"))?>
			<p>総部屋数 <span class="colorRed"><?php print $max?> 部屋</span> 残り部屋数 <span class="colorRed"><?php print $max-$used?> 部屋</span></p>
			<p>変更前 <?php print $nowUsed?> → <?php print $inputs->text("HOTELPAY_ROOM_NUM", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_ROOM_NUM") ,"imeDisabled circle wNum",50)?></p>
			<p>※半角数字10文字以内でご入力下さい。</p>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("hotelPay::keyName"), $hotelPay->getKeyValue())?>
<?php print $inputs->hidden(constant("hotelPlan::keyName"), $hotelPlan->getKeyValue())?>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelRoom->getKeyValue())?>
