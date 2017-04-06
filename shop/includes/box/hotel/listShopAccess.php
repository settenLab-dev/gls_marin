<?php if ($ShopAccess->getErrorCount() > 0) {?>
<?php print create_error_caption($ShopAccess->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
		<tr>
			<th colspan="8">
				<h3>
				<a href="ShopAccessEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい集合場所を登録","circle ")?></a>
				<a href="ShopAccessOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","並び替え","circle ")?></a>
				</h3>
			</th>
		</tr>
			<?php }?>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>集合場所名称</p></th>
			<th><p>住所</p></th>
			<th><p>公開状況</p></th>
			<th width="50"><p>編集</p></th>
			<th width="50"><p>複製</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($ShopAccess->getCount() > 0) {?>
			<?php foreach ($ShopAccess->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["SHOP_ACCESS_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["SHOP_ACCESS_ID"]?></td>
			<td <?=$rclass?>><?=$ad["SHOP_ACCESS_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["SHOP_ACCESS_ADDRESS"]?></td>
			<td <?=$rclass?>><?php if($ad["SHOP_ACCESS_PUBLICFLG"] == 1){ print "公開中"; }else{ print "非公開"; }?></td>
			<td <?=$rclass?> align="center">
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="ShopAccessEdit.html?id=<?=$ad["SHOP_ACCESS_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			<?php }?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="ShopAccessCopy.html?id=<?=$ad["SHOP_ACCESS_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","複製","circle")?></a>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
