<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
							<tr>
								<th width="120">プラン名
								</th>
								<td><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?></td>
	</tr>
	<tr>
		<th >在庫タイプ名
		</th>
		<td><?php print $hotelRoomTrget->getByKey($hotelRoomTrget->getKeyValue(), "ROOM_NAME")?></td>
	</tr>
	<tr>
		<th >売り出し期間
		</th>
		<td><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM")?> ～ <?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO")?></td>
	</tr>
	<?php /*
	<tr>
		<th >子供料金の設定 <span class="colorRed">※</span></th>
		<td>
			<table class="inner" cellspacing="5" width="100%">
				<tr>
					<th valign="top" colspan="2"></th>
					<th valign="top" >受け入れ</th>
					<th valign="top" >大人料金概算時<br />に数える</th>
					<th valign="top" >値段・率</th>
					<th valign="top" >単位</th>
				</tr>
				<tr>
					<th valign="top" colspan="2">小人</th>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA1"))?>
						<?php print $inputs->radio("HOTELPAY_PS_DATA11", "HOTELPAY_PS_DATA1", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA1") ," あり")?>
						<?php print $inputs->radio("HOTELPAY_PS_DATA12", "HOTELPAY_PS_DATA1", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA1") ," なし")?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA2"))?>
						<?=$inputs->checkbox("HOTELPAY_PS_DATA2","HOTELPAY_PS_DATA2",1,$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA2")," 数える", "")?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA3"))?>
						<?php print $inputs->text("HOTELPAY_PS_DATA3", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA3") ,"imeDisabled circle wTime",50)?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA4"))?>
						<?php print $inputs->radio("HOTELPAY_PS_DATA41", "HOTELPAY_PS_DATA4", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA4") ," %")?>
						<?php print $inputs->radio("HOTELPAY_PS_DATA42", "HOTELPAY_PS_DATA4", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA4") ," 円")?><br />
						<?php print $inputs->radio("HOTELPAY_PS_DATA43", "HOTELPAY_PS_DATA4", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA4") ," 円引")?>
					</td>
				</tr>
				<tr>
					<th valign="top" rowspan="4">幼児</th>
					<th valign="top" >(A)</th>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA1"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA11", "HOTELPAY_BB_DATA1", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA1") ," あり")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA12", "HOTELPAY_BB_DATA1", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA1") ," なし")?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA2"))?>
						<?=$inputs->checkbox("HOTELPAY_BB_DATA2","HOTELPAY_BB_DATA2",1,$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA2")," 数える", "")?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA3"))?>
						<?php print $inputs->text("HOTELPAY_BB_DATA3", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA3") ,"imeDisabled circle wTime",50)?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA4"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA41", "HOTELPAY_BB_DATA4", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA4") ," %")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA42", "HOTELPAY_BB_DATA4", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA4") ," 円")?><br />
						<?php print $inputs->radio("HOTELPAY_BB_DATA43", "HOTELPAY_BB_DATA4", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA4") ," 円引")?>
					</td>
				</tr>
				<tr>
					<th valign="top" >(B)</th>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA5"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA51", "HOTELPAY_BB_DATA5", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA5") ," あり")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA52", "HOTELPAY_BB_DATA5", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA5") ," なし")?>
					</td>
					<td>-
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA6"))?>
						<?php print $inputs->text("HOTELPAY_BB_DATA6", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA6") ,"imeDisabled circle wTime",50)?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA7"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA71", "HOTELPAY_BB_DATA7", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA7") ," %")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA72", "HOTELPAY_BB_DATA7", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA7") ," 円")?><br />
						<?php print $inputs->radio("HOTELPAY_BB_DATA73", "HOTELPAY_BB_DATA7", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA7") ," 円引")?>
					</td>
				</tr>
				<tr>
					<th valign="top" >(C)</th>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA8"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA81", "HOTELPAY_BB_DATA8", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA8") ," あり")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA82", "HOTELPAY_BB_DATA8", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA8") ," なし")?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA9"))?>
						<?=$inputs->checkbox("HOTELPAY_BB_DATA9","HOTELPAY_BB_DATA9",1,$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA9")," 数える", "")?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA10"))?>
						<?php print $inputs->text("HOTELPAY_BB_DATA10", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA10") ,"imeDisabled circle wTime",50)?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA11"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA111", "HOTELPAY_BB_DATA11", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA11") ," %")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA112", "HOTELPAY_BB_DATA11", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA11") ," 円")?><br />
						<?php print $inputs->radio("HOTELPAY_BB_DATA113", "HOTELPAY_BB_DATA11", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA11") ," 円引")?>
					</td>
				</tr>
				<tr>
					<th valign="top" >(D)</th>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA12"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA121", "HOTELPAY_BB_DATA12", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA12") ," あり")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA122", "HOTELPAY_BB_DATA12", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA12") ," なし")?>
					</td>
					<td>-
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA13"))?>
						<?php print $inputs->text("HOTELPAY_BB_DATA13", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA13") ,"imeDisabled circle wTime",50)?>
					</td>
					<td>
						<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA14"))?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA141", "HOTELPAY_BB_DATA14", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA14") ," %")?>
						<?php print $inputs->radio("HOTELPAY_BB_DATA142", "HOTELPAY_BB_DATA14", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA14") ," 円")?><br />
						<?php print $inputs->radio("HOTELPAY_BB_DATA143", "HOTELPAY_BB_DATA14", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA14") ," 円引")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th >サービス料 <span class="colorRed">※</span></th>
		<td>
			<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_SERVICE_FLG"))?>
			<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA13"))?>
			<?php print $inputs->radio("HOTELPAY_SERVICE_FLG1", "HOTELPAY_SERVICE_FLG", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE_FLG") ," サ込")?>
			<?php print $inputs->radio("HOTELPAY_SERVICE_FLG2", "HOTELPAY_SERVICE_FLG", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE_FLG") ," サ別")?>
			<?php print $inputs->text("HOTELPAY_SERVICE", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE") ,"imeDisabled circle wTime",50)?> %
		</td>
	</tr>
	<tr>
		<th >料金特記事項</th>
		<td>
			<?php print create_error_msg($hotelPay->getErrorByKey("HOTELPAY_REMARKS"))?>
			<?=$inputs->textarea("HOTELPAY_REMARKS", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_REMARKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	*/?>
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