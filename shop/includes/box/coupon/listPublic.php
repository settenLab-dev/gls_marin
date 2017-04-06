<?php if ($couponPlanTarget->getErrorCount() > 0) {?>
<?php print create_error_caption($couponPlanTarget->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>クーポン名</p></th>
			<th width="80"><p>掲載開始</p></th>
			<th width="80"><p>掲載終了</p></th>
			<th width="100"><p>公開/非公開切り替え</p></th>
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
			<td <?=$rclass?>><?=$ad["COUPONPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_SALE_FROM"]?></td>
			<td <?=$rclass?>><?=$ad["COUPONPLAN_SALE_TO"]?></td>
			<td <?=$rclass?> align="center">
			<?php if ($coupon->getByKey($coupon->getKeyValue(), "COUPONPLAN_STATUS") != 3) {?>
				<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
					<?php if ($ad["COUPONPLAN_STATUS"] == 2) {?>
						<?=$inputs->submit("","disabled","公開中", "circle bgOrange")?>
					<?php }else {?>
						<?=$inputs->submit("","regist","非公開", "circle")?>
					<?php }?>
					<?php print $inputs->hidden("COUPONPLAN_ID", $ad["COUPONPLAN_ID"])?>
					<?php print $inputs->hidden("COUPONSHOP_ID", $d["COUPONSHOP_ID"])?>
				</form>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		現在公開可能なクーポンはございません。クーポン情報を登録してください。
		<?php }?>
	</tbody>
</table>
<br />

