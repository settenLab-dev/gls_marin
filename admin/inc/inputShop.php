<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($couponShop->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($couponShop->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>店舗コード</p>
		</td>
		<td align="left">
			<?php if ($couponShop->getKeyValue() > 0) {?>
			<p><?php print cmKeyCheck(constant("coupon::keyName"))?><?php print str_pad($couponShop->getKeyValue(), 8, "0", STR_PAD_LEFT);?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>店舗名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_NAME"))?>
			<?php print $inputs->text("COUPONSHOP_NAME", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_NAME") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>店舗名（カナ） <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_KANA"))?>
			<?php print $inputs->text("COUPONSHOP_KANA", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_KANA") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>店舗の説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_DETAIL"))?>
			<?=$inputs->textarea("COUPONSHOP_DETAIL", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_DETAIL"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>店舗の説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_ADDRESS"))?>
			<?=$inputs->textarea("COUPONSHOP_ADDRESS", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_ADDRESS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>店舗の説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_TEL"))?>
			<?=$inputs->textarea("COUPONSHOP_TEL", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_TEL"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>店舗の説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_ACCESS"))?>
			<?=$inputs->textarea("COUPONSHOP_ACCESS", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_ACCESS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>店舗の説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_OPEN"))?>
			<?=$inputs->textarea("COUPONSHOP_OPEN", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_OPEN"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>定休日</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_HOLYDAY"))?>
			<?=$inputs->textarea("COUPONSHOP_HOLYDAY", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_HOLYDAY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>備考</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_MEMO"))?>
			<?=$inputs->textarea("COUPONSHOP_MEMO", $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>

	<?php for ($i=1; $i<=1; $i++) {?>
	<tr>
		<td valign="top">
			<p>部屋画像<?php print $i;?></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">画像</td>
					<td align="left">
						<?php print create_error_msg($couponShop->getErrorByKey("COUPONSHOP_PIC".$i))?>
						<?=$inputs->image("COUPONSHOP_PIC".$i, $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

						<?php if ($couponPic->getCount() > 0) {?>
						<a href="couponGalleryEdit.html?id=SHOP_PIC<?php print $i?>&key=<?php print cmKeyCheck(constant("coupon::keyName"))?>" class="popup" rel="windowCallUnload"></a>
						<?php print $inputsOnly->text("SHOP_PIC".$i."_setup", $couponShop->getByKey($couponShop->getKeyValue(), "SHOP_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
						<a href="couponGalleryEdit.html?id=SHOP_PIC<?php print $i?>&key=<?php print cmKeyCheck(constant("coupon::keyName"))?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
						<?php }?>

					</td>
				</tr>
				<!--<tr>
					<td valign="top">画像説明</td>
					<td align="left">
						<?php print create_error_msg($couponShop->getErrorByKey("SHOP_PIC_DISCRIPTION".$i))?>
						<?=$inputs->textarea("SHOP_PIC_DISCRIPTION".$i, $couponShop->getByKey($couponShop->getKeyValue(), "SHOP_PIC_DISCRIPTION".$i), "imeActive circle",30,4)?>
					</td>
				</tr>-->
			</table>
		</td>
	</tr>
	<?php }?>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($couponShop->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("couponShop::keyName"), $couponShop->getKeyValue())?>
