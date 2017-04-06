<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" widtd="100%">
	<?php
	if ($hotelProvide->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelProvide->getError())?>
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
			<p><?php print $date?></p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>在庫タイプ名</p>
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
			<?php print create_error_msg($hotelProvide->getErrorByKey("HOTELPROVIDE_FLG_STOP"))?>
			<?php if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") == 1) {?>
			<p>現在ステータスは「販売」に設定されています。</p>
			<?php }elseif ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") == 2) {?>
			<p>現在ステータスは「売止」に設定されています。</p>
			<?php }else{?>
			<p>現在ステータスは未設定です</p>
			<?php }?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_STOP1", "HOTELPROVIDE_FLG_STOP", 1, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") ," 販売")?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_STOP2", "HOTELPROVIDE_FLG_STOP", 2, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") ," 売止(キャンセル再販無し)")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>リクエスト予約 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelProvide->getErrorByKey("HOTELPROVIDE_FLG_REQUEST"))?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_REQUEST1", "HOTELPROVIDE_FLG_REQUEST", 1, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST") ," 設定する")?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_REQUEST2", "HOTELPROVIDE_FLG_REQUEST", 2, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST") ," 設定しない")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>提供在庫数の変更 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelProvide->getErrorByKey("HOTELPROVIDE_NUM"))?>
				<p>変更前 <?php print intval($nowUsed)?>席 → <?php print $inputs->text("HOTELPROVIDE_NUM", $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_NUM") ,"imeDisabled circle wNum",50)?> 席</p>
			<p>※半角数字10文字以内でご入力下さい。</p>
			<p>※リクエスト予約設定時は未入力でも可。</p>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelProvide->getKeyValue())?>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelRoom->getKeyValue())?>
