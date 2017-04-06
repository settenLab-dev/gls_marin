<?php if ($couponPlan->getErrorCount() > 0) {?>
<?php print create_error_caption($couponPlan->getError())?>
<?php }?>

<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th colspan="7">
				<?php if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS") != 3) {?>
				<a href="couponPlanEdit.html?key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"></a>
				<a href="couponPlanEdit.html?key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい情報を登録","circle ")?></a>

				<a href="couponPlanOrder.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"></a>
				<a href="couponPlanOrder.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","求人情報を並び替える","circle ")?></a>
				<?php }?>
			</th>
		</tr>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>クーポン名</p></th>
			<?php /*
			<th><p>売出</p></th>
			<th><p>売終</p></th>
			*/?>
			<th width="80"><p>情報編集</p></th>
			<th width="50"><p>適用する事業所</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($couponPlan->getCount() > 0) {?>
			<?php foreach ($couponPlan->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["COUPON_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_ID"]?></td>
			<td <?=$rclass?>><?=$ad["COUPON_NAME"]?></td>
			<td <?=$rclass?> align="center">
			<a href="couponPlanEdit.html?id=<?=$ad["COUPONPLAN_ID"]?>&key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","情報編集","circle")?></a>
			</td>
<!--
			<td <?=$rclass?> align="center">
			<a href="couponPlanCopy.html?id=<?=$ad["COUPONPLAN_ID"]?>&key=<?php print cmIdCheck(constant("coupon::keyName"));?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","プラン複製","circle")?></a>
			</td>
-->
			<td <?=$rclass?> align="center">
			<?php if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS") != 3) {?>

				<?php
				$arShop = array();
				$arTemp = explode(":", $ad["COUPONPLAN_SHOP_LIST"]);
				if (count($arTemp) > 0) {
					foreach ($arTemp as $data) {
						if ($data != "") {
							$arShop[$data] = $data;
						}
					}
				}
				?>
				<?php if ($couponShop->getCount() >0) {?>
				<table class="inner">
					<?php
					foreach ($couponShop->getCollection() as $d) {
						if ($arShop[$d["COUPONSHOP_ID"]] == "") {
							continue;
						}
					?>
					<tr>
						<th><?php print $d["COUPONSHOP_NAME"]?></th>
						<td>
						</td>
					</tr>
					<?php }?>
				</table>
				<?php }?>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />

