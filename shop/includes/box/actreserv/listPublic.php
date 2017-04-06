<?php if ($hotelPlanTarget->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelPlanTarget->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>プラン名</p></th>
			<th width="120"><p>売出</p></th>
			<th width="120"><p>売終</p></th>
			<th width="100"><p>プラン編集</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($hotelPlan->getCount() > 0) {?>
			<?php foreach ($hotelPlan->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["HOTELPLAN_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_ID"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_NAME"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_DATE_SALE_FROM"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_DATE_SALE_TO"]?></td>
			<td <?=$rclass?> align="center">
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
				<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
					<?php if ($ad["HOTELPLAN_STATUS"] == 2) {?>
						<?=$inputs->submit("","disabled","公開中", "circle bgOrange")?>
					<?php }else {?>
						<?=$inputs->submit("","regist","非公開", "circle")?>
					<?php }?>
					<?php print $inputs->hidden("HOTELPLAN_ID", $ad["HOTELPLAN_ID"])?>
					<?php print $inputs->hidden("ROOM_ID", $d["ROOM_ID"])?>
				</form>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />

