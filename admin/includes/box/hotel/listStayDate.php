<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
							<tr>
								<th width="120">プラン名
								</th>
								<td><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?></td>
	</tr>
	<tr>
		<th >部屋タイプ名
		</th>
		<td><?php print $hotelRoomTrget->getByKey($hotelRoomTrget->getKeyValue(), "ROOM_NAME")?></td>
	</tr>
	<tr>
		<th >売り出し期間
		</th>
		<td><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM")?> ～ <?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO")?></td>
	</tr>

	<tr>
		<td align="left" colspan="2">
			<?php

			$targetDate = cmDateDivide($collection2->getByKey($collection2->getKeyValue(), "searchMonth"));

			$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
			$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));

			for ($y=$from["y"]; $y<=$to["y"]; $y++) {
				for ($m=$from["m"]; $m<=$to["m"]; $m++) {

					if ($targetDate["y"] != $y or str_pad($targetDate["m"], 2, "0", STR_PAD_LEFT) != $m) {
						continue;
					}

					if ($from["y"] == $y and $from["m"] == $m) {
						if ($from["y"] == $to["y"] and $from["m"] == $to["m"]) {
							//	最初の月でそのまま終了の場合
							print cmCalendar($y, $m, $from["d"], $to["d"], $hotelPayTarget, "", $only);
						}
						else {
							print cmCalendar($y, $m, $from["d"], "", $hotelPayTarget, "", $only);
						}
					}
					elseif ($to["y"] == $y and $to["m"] == $m) {
						print cmCalendar($y, $m, "", $to["d"], $hotelPayTarget, "", $only);
					}
					else {
						print cmCalendar($y, $m, "", "", $hotelPayTarget, "", $only);
					}

				}
			}
			?>
		</td>
	</tr>
</table>