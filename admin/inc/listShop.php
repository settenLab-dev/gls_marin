<?php if ($couponShop->getErrorCount() > 0) {?>
<?php print create_error_caption($couponShop->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
		<th colspan="8">
			<h3>
			<?php if ($coupon->getByKey($coupon->getKeyValue(), "JOB_STATUS") != 3) {?>
			<a href="couponShopEdit.html?key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"></a>
			<a href="couponShopEdit.html?key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい事業所を登録","circle ")?></a>
			<a href="couponShopOrder.html?key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"></a>
			<a href="couponShopOrder.html?key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","事業所を並び替える","circle ")?></a>
			<?php }?>
			</h3>
		</th>
	</tr>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>店舗名</p></th>
			<th><p>住所</p></th>
			<th><p>電話番号</p></th>
			<th><p>店舗の説明</p></th>
			<th width="50"><p>編集</p></th>
			<th width="50"><p>複製</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($couponShop->getCount() > 0) {?>
			<?php foreach ($couponShop->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["COUPONSHOP_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["COUPONSHOP_ID"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONSHOP_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONSHOP_TEL"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONSHOP_ADDRESS"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONSHOP_DETAIL"]?></td>
			<td <?=$rclass?> align="center">
			<?php if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS") != 3) {?>
			<a href="couponShopEdit.html?id=<?=$ad["COUPONSHOP_ID"]?>&key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			<?php }?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="couponShopCopy.html?id=<?=$ad["COUPONSHOP_ID"]?>&key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","複製","circle")?></a>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />
