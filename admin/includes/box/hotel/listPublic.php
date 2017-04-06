<?php if ($shopPlanTarget->getErrorCount() > 0) {?>
<?php print create_error_caption($shopPlanTarget->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>プラン名</p></th>
			<th width="120"><p>売出</p></th>
			<th width="120"><p>売終</p></th>
			<th width="100"><p>公開状況</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($shopPlan->getCount() > 0) {?>
			<?php foreach ($shopPlan->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["SHOPPLAN_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["SHOPPLAN_ID"]?></td>
			<td <?=$rclass?>><?=$ad["SHOPPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["SHOPPLAN_SALE_FROM"]?></td>
			<td <?=$rclass?>><?=$ad["SHOPPLAN_SALE_TO"]?></td>
			<td <?=$rclass?> align="center">

				<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
					<?php if ($ad["SHOPPLAN_STATUS"] == 2) {?>
						<?=$inputs->submit("","disabled","公開中", "circle bgOrange")?>
					<?php }else {?>
						<?=$inputs->submit("","regist","非公開", "circle")?>
					<?php }?>
					<?php print $inputs->hidden("SHOPPLAN_ID", $ad["SHOPPLAN_ID"])?>
					<?php print $inputs->hidden("ROOM_ID", $d["ROOM_ID"])?>
				</form>

			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />

