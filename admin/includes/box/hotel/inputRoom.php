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
			<p><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_ID")?></p>
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

</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($hotelRoom->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelRoom->getKeyValue())?>
