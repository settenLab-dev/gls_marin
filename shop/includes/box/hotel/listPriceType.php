<?php if ($hotelPriceType->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelPriceType->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
		<tr>
			<th colspan="8">
				<h3>
				<a href="shopPriceTypeEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい料金タイプを登録","circle ")?></a>
				<a href="shopPriceTypeOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","並び替え","circle ")?></a>
				</h3>
			</th>
		</tr>
			<?php }?>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>料金タイプ名</p></th>
			<th width="50"><p>編集</p></th>
			<th width="50"><p>複製</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($hotelPriceType->getCount() > 0) {?>
			<?php foreach ($hotelPriceType->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["SHOP_PRICETYPE_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["SHOP_PRICETYPE_ID"]?></td>
			<td <?=$rclass?>><?=$ad["SHOP_PRICETYPE_NAME"]?></td>
			<td <?=$rclass?> align="center">
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="shopPriceTypeEdit.html?id=<?=$ad["SHOP_PRICETYPE_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			<?php }?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="ShopPriceEdit.html?id=<?=$ad["SHOP_PRICETYPE_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","料金登録","circle")?></a>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
