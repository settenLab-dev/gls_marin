<?php if ($hotelRoom->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelRoom->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
		<tr>
			<th colspan="8">
				<h3>
				<a href="leisureRoomEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい在庫タイプを登録","circle ")?></a>
				<a href="leisureRoomOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","在庫タイプを並び替える","circle ")?></a>
				</h3>
			</th>
		</tr>
			<?php }?>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>在庫タイプ名</p></th>
			<th><p>定員</p></th>
			<th><p>ルームタイプ</p></th>
			<th><p>在庫コード</p></th>
			<th><p>ペット受入</p></th>
			<th width="50"><p>編集</p></th>
			<th width="50"><p>複製</p></th>
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
			<td <?=$rclass?>><?=$ad["ROOM_CAPACITY_FROM"]?>～<?=$ad["ROOM_CAPACITY_TO"]?></td>
			<td <?=$rclass?>>
				<?php $ar = cmHotelRoomType();?>
				<?php print $ar[$ad["ROOM_TYPE"]]?>
			</td>
			<td <?=$rclass?>>
				<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")?><?php print str_pad($ad["ROOM_ID"], 8, "0", STR_PAD_LEFT);?>
			</td>
			<td <?=$rclass?>>
				<?php
				if ($ad["ROOM_PET_FLG"] == 1) {
					print "可";
				}
				elseif ($ad["ROOM_PET_FLG"] == 2) {
					print "不可";
				}
				?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="leisureRoomEdit.html?id=<?=$ad["ROOM_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			<?php }?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="leisureRoomCopy.html?id=<?=$ad["ROOM_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","複製","circle")?></a>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
