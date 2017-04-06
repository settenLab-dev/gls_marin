<?php if ($coupon->getErrorCount() > 0) {?>
<?php print create_error_caption($coupon->getError())?>
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
			<p>施設名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($coupon->getErrorByKey("COUPON_NAME"))?>
			<?php print $inputs->text("COUPON_NAME", $coupon->getByKey($coupon->getKeyValue(), "COUPON_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>施設名(カナ) <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($coupon->getErrorByKey("COUPON_KANA"))?>
			<?php print $inputs->text("COUPON_KANA", $coupon->getByKey($coupon->getKeyValue(), "COUPON_KANA") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>住所 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?=$inputs->textarea("COUPON_ADDRESS", $coupon->getByKey($coupon->getKeyValue(), "COUPON_ADDRESS"), "imeActive circle",50,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($coupon->getErrorByKey("COUPON_TEL"))?>
			<?php print $inputs->text("COUPON_TEL", $coupon->getByKey($coupon->getKeyValue(), "COUPON_TEL") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>問い合わせMAIL <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($coupon->getErrorByKey("COUPON_MAIL"))?>
			<?php print $inputs->text("COUPON_MAIL", $coupon->getByKey($coupon->getKeyValue(), "COUPON_MAIL") ,"imeDisabled circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>交通アクセス<span class="colorRed">※</span></p>
	</th>
		<td align="left">
			<?php print create_error_msg($coupon->getErrorByKey("COUPON_MANAGER"))?>
			<?=$inputs->textarea("COUPON_MANAGER", $coupon->getByKey($coupon->getKeyValue(), "COUPON_MANAGER"), "imeActive circle",30)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>営業時間<span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?=$inputs->textarea("COUPON_OPEN", $coupon->getByKey($coupon->getKeyValue(), "COUPON_OPEN"), "imeActive circle",30)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>定休日<span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?=$inputs->textarea("COUPON_HOLYDAY", $coupon->getByKey($coupon->getKeyValue(), "COUPON_HOLYDAY"), "imeActive circle",30)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>備考<span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?=$inputs->textarea("COUPON_MEMO", $coupon->getByKey($coupon->getKeyValue(), "COUPON_MEMO"), "imeActive circle",30)?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>イメージ写真 </p>
		</th>
		<td align="left">
		<?=$inputs->hidden("check_none", "")?>

			<?php print create_error_msg($coupon->getErrorByKey("COUPON_PIC_APP"))?>
			<?=$inputs->image("COUPON_PIC_APP", $coupon->getByKey($coupon->getKeyValue(), "COUPON_PIC_APP"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

				<?php if ($couponPic->getCount() > 0) {?>
				<a href="couponGalleryEdit.html?id=COUPON_PIC_APP&key=<?php print cmIdCheck(constant("coupon::keyName"))?>" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("COUPON_PIC_APP_setup", $coupon->getByKey($coupon->getKeyValue(), "COUPON_PIC_APP_setup") ,"imeDisabled circle wNum",50)?>
				<a href="couponGalleryEdit.html?id=COUPON_PIC_APP&key=<?php print cmIdCheck(constant("coupon::keyName"))?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>


		</td>
	</tr>

	</table>
	<br />
</table>

<br />

<ul class="buttons">
	<li><?=$inputs->submit("","regist","企業基本情報を保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("coupon::keyName"), $coupon->getKeyValue())?>
