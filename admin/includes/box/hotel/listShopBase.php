<?php if ($hotelShopBase->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelShopBase->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>

		<tr>
			<th colspan="8">
				<h3>
				<a href="hotelShopBaseEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい部屋タイプを登録","circle ")?></a>
				<a href="hotelShopBaseOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","部屋タイプを並び替える","circle ")?></a>
				</h3>
			</th>
		</tr>

		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>部屋タイプ名</p></th>
			<th><p>定員</p></th>
			<th><p>多言語受入</p></th>
			<th width="50"><p>編集</p></th>
			<th width="50"><p>複製</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($hotelShopBase->getCount() > 0) {?>
			<?php foreach ($hotelShopBase->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["SHOP_BASE_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["SHOP_BASE_ID"]?></td>
			<td <?=$rclass?>><?=$ad["SHOP_BASE_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["SHOP_BASE_CAPACITY_FROM"]?>～<?=$ad["SHOP_BASE_CAPACITY_TO"]?></td>
			<td <?=$rclass?>>
				<?php
				if ($ad["SHOP_BASE_PET_FLG"] == 1) {
					print "可";
				}
				elseif ($ad["SHOP_BASE_PET_FLG"] == 2) {
					print "不可";
				}
				?>
			</td>
			<td <?=$rclass?> align="center">

			<a href="hotelShopBaseEdit.html?id=<?=$ad["SHOP_BASE_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>

			</td>
			<td <?=$rclass?> align="center">

			<a href="hotelShopBaseCopy.html?id=<?=$ad["SHOP_BASE_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","複製","circle")?></a>

			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
