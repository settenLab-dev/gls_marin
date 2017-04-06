<?php// print_r($collection); ?>

<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($ShopAccess->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($ShopAccess->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="250" valign="top">
			<p>ID</p>
		</td>
		<td align="left">
			<?php if ($ShopAccess->getKeyValue() > 0) {?>
			<p><?php print $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_ID")?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>集合場所<br />名称 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_NAME"))?>
			<?php print $inputs->text("SHOP_ACCESS_NAME", $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_NAME") ,"imeActive circle",50)?>
			<p>※最大全角100文字まで入力できます。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>住所  <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_ADDRESS"))?>
			<?=$inputs->text("SHOP_ACCESS_ADDRESS", $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_ADDRESS"), "imeActive circle",50,4)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>電話番号 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_TEL"))?>
			<?php print $inputs->text("SHOP_ACCESS_TEL", $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_TEL") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>アクセス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PARKINGFLG"))?>
			<?php print $inputs->text("SHOP_ACCESS_ROUTE", $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_ROUTE") ,"imeActive circle",50)?>
			<p>例）車で○○インターチェンジより約15分　/　○○バス停より徒歩5分　等</p>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>駐車場の有無 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PARKINGFLG"))?>
			<?php print $inputs->radio("SHOP_ACCESS_PARKINGFLG1", "SHOP_ACCESS_PARKINGFLG", 1, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGFLG") ," あり")?>
			<?php print $inputs->radio("SHOP_ACCESS_PARKINGFLG2", "SHOP_ACCESS_PARKINGFLG", 2, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGFLG") ," なし")?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>駐車場料金 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PARKINGMONEYFLG"))?>
			<?php print $inputs->radio("SHOP_ACCESS_PARKINGMONEYFLG1", "SHOP_ACCESS_PARKINGMONEYFLG", 1, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGMONEYFLG") ," 無料")?>
			<?php print $inputs->radio("SHOP_ACCESS_PARKINGMONEYFLG2", "SHOP_ACCESS_PARKINGMONEYFLG", 2, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGMONEYFLG") ," 有料")?><br /><br />
			※有料の場合のみ料金を入力<br />
			<?=$inputs->textarea("SHOP_ACCESS_PARKINGMONEY", $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGMONEY"), "imeActive circle",30,4)?>

		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>駐車場の<br />事前予約 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PARKINGBOOKFLG"))?>
			<?php print $inputs->radio("SHOP_ACCESS_PARKINGBOOKFLG1", "SHOP_ACCESS_PARKINGBOOKFLG", 1, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGBOOKFLG") ," 不要")?>
			<?php print $inputs->radio("SHOP_ACCESS_PARKINGBOOKFLG2", "SHOP_ACCESS_PARKINGBOOKFLG", 2, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGBOOKFLG") ," 必要")?>
		</td>

	</tr>
	<tr>
		<td valign="top">
			<p>駐車台数 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td align="left">
						<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PARKINGCAP"))?>
						<?=$inputs->text("SHOP_ACCESS_PARKINGCAP", $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PARKINGCAP"), "imeActive circle",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<?php for ($i=1; $i<=4; $i++) {?>
	<tr>
		<td valign="top">
			<p>画像<?php print $i;?></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td valign="top">画像</td>
					<td align="left">

						<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PIC".$i))?>
						<?=$inputs->image("SHOP_ACCESS_PIC".$i, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

						<?php if ($hotelPic->getCount() > 0) {?>
						<a href="shopGalleryEdit.html?id=SHOP_ACCESS_PIC<?php print $i?>&key=<?php print $ShopAccess->getByKey($ShopAccess->getKeyValue(), "COMPANY_ID") ?>" class="popup" rel="windowCallUnload"></a>
						<?php print $inputsOnly->text("SHOP_ACCESS_PIC".$i."_setup", $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
						<a href="shopGalleryEdit.html?id=SHOP_ACCESS_PIC<?php print $i?>&key=<?php print $ShopAccess->getByKey($ShopAccess->getKeyValue(), "COMPANY_ID") ?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
						<?php }?>

					</td>
				</tr>
				<tr>
					<td valign="top">画像の説明</td>
					<td align="left">
						<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PIC_DISCRIPTION".$i))?>
						<?=$inputs->textarea("SHOP_ACCESS_PIC_DISCRIPTION".$i, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PIC_DISCRIPTION".$i), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>
		<td width="160" valign="top">
			<p>公開状態 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($ShopAccess->getErrorByKey("SHOP_ACCESS_PUBLICFLG"))?>
			<?php print $inputs->radio("SHOP_ACCESS_PUBLICFLG1", "SHOP_ACCESS_PUBLICFLG", 1, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PUBLICFLG") ," 公開")?>
			<?php print $inputs->radio("SHOP_ACCESS_PUBLICFLG2", "SHOP_ACCESS_PUBLICFLG", 2, $ShopAccess->getByKey($ShopAccess->getKeyValue(), "SHOP_ACCESS_PUBLICFLG") ," 非公開")?>
		</td>

</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($ShopAccess->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("ShopAccess::keyName"), $ShopAccess->getKeyValue())?>
