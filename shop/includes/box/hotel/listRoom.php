<?php if ($hotelRoom->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelRoom->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
		<tr>
			<th colspan="8">
				<h3>
				<a href="hotelRoomEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい在庫タイプを登録","circle ")?></a>
				<a href="hotelRoomOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","並び替え","circle ")?></a>
				</h3>
			</th>
		</tr>
			<?php }?>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>在庫タイプ名</p></th>
			<th width="50"><p>編集</p></th>
			<th width="50"><p>在庫数設定</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($hotelRoom->getCount() > 0) {?>
			<?php foreach ($hotelRoom->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["ROOM_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["ROOM_ID"]?></td>
			<td <?=$rclass?>><?=$ad["ROOM_NAME"]?></td>
			<td <?=$rclass?> align="center">
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="shopRoomEdit.html?id=<?=$ad["ROOM_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			<?php }?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="shopProvide.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","在庫数設定","circle")?></a>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
