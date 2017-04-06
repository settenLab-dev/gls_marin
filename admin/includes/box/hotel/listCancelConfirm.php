<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
				<thead>
					<tr>
						<th width="50" rowspan="2"><p>宿泊日</p></th>
						<th width="50" rowspan="2"><p>部屋目</p></th>
						<th rowspan="2"><p>大人</p></th>
						<th colspan="2"><p>小学生</p></th>
						<th colspan="4"><p>幼児</p></th>
						<th rowspan="2"><p>料金合計</p></th>
						<th rowspan="2"><p>ｷｬﾝｾﾙ</p></th>
					</tr>
					<tr>
						<th><p>低学年</p></th>
						<th><p>高学年</p></th>
						<th><p>食・布)</p></th>
						<th><p>食のみ</p></th>
						<th><p>布のみ</p></th>
						<th><p>なし</p></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$all_cancel = true;
					if ($hotelBookingcont->getCount() > 0) {
					?>
						<?php foreach ($hotelBookingcont->getCollection() as $ad) {?>
						<?php
						$rclass = '';
						if ($_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 1 || $_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 2) {
							//	キャンセル予定データ
						}
						elseif ($ad["BOOKINGCONT_STATUS"] == 2 ) {
							//	キャンセル済みデータ
							$rclass = 'class="bgLightGrey"';
						}
						else {
							$all_cancel = false;
							$rclass = 'class="bgLightGrey"';
						}
						?>
					<tr>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_DATE"]?></td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_ROOM"]?></td>
						<td <?=$rclass?>>男:<?=$ad["BOOKINGCONT_NUM1"]?> 女:<?=$ad["BOOKINGCONT_NUM2"]?><br /><?=number_format($ad["BOOKINGCONT_MONEY1"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM3"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY2"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM4"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY3"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM5"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY4"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM6"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY5"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM7"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY6"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM8"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY7"])?>円</td>
						<td <?=$rclass?>><?=number_format($ad["BOOKINGCONT_MONEY"])?></td>
						<td <?=$rclass?>>
							<?php
							$checked = '';
							if ($_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 1) {
							?>
							<input type="hidden" name="canceldata[<?php print $ad["BOOKINGCONT_ID"]?>]" value="1" />
							<?php
							}elseif ($_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 2) {
?>
<input type="hidden" name="canceldata[<?php print $ad["BOOKINGCONT_ID"]?>]" value="2" />
							<?php }else  {?>
								<p><?php print $ad["BOOKINGCONT_DATE_CANCEL"]?></p>
								<p><?php print number_format($ad["BOOKINGCONT_MONEY_CANCEL"])?>円</p>
							<?php }?>
						</td>
					</tr>
						<?php }?>
					<?php }else {?>
					<?php }?>
				</tbody>
			</table>
			<br />


			<?php print create_error_msg($hotelBookingcont->getErrorByKey("targetCancel"))?>

			<?php
			$dataCancel = "";
			if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {

				if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {

					if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
						$can = "";
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {

// 							$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
// 							print "無不泊連絡";
							?>

							<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "無不泊連絡 : 宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%")?><br />

							<?php
						}
						else {
						?>

							<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "無不泊連絡 : ".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円")?><br />

						<?php
// 							$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
						}
// 						$dataCancel .= "無不泊連絡 ".$can."\n";
					}

					if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {

// 						print "当日キャンセル";

						$can = "";
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
						?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "当日キャンセル : 宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%")?><br />

						<?php
// 							$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
						}
						else {
						?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "当日キャンセル : ".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円")?><br />

						<?php
// 							$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
						}
// 						$dataCancel .= "当日キャンセル ".$can."\n";
					}

					for ($i=3; $i<=7; $i++) {
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {
							$can = "";
							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
							?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで : 宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%")?><br />

							<?php
// 								$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
							}
							else {
							?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで : ".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円")?><br />

							<?php
// 								$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
							}
// 							$dataCancel .= $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで".$can."\n";
						}
					}

				}

			}
			else {

				if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {
					$can = "";
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {

// 						print "無不泊連絡";
					?>

					<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "無不泊連絡 : 宿泊料の".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%")?><br />

					<?php
// 						$can = "宿泊料の".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%";
					}
					else {
					?>

							<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "無不泊連絡 : ".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円")?><br />

						<?php
// 						$can = "".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円";
					}
// 					$dataCancel .= "無不泊連絡 ".$can."\n";
				}

				if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {
					$can = "";

// 					print "当日キャンセル";

					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
					?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "当日キャンセル : 宿泊料の".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%")?><br />

					<?php
// 						$can = "宿泊料の".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%";
					}
					else {
					?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "当日キャンセル : ".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円")?><br />

					<?php
// 						$can = "".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円";
					}
// 					$dataCancel .= "当日キャンセル ".$can."\n";
				}

				for ($i=3; $i<=6; $i++) {
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {
						$can = "";
						if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
						?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)."～".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)."日前まで : 宿泊料の".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%")?>

						<?php
// 							$can = "宿泊料の".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%";
						}
						else {
						?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)."～".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)."日前まで : 宿泊料の".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円")?>

						<?php
// 							$can = "".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円";
						}
// 						$dataCancel .= $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)."～".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)."日前まで".$can."\n";
					}
				}
			}

			?>
			<?php print $inputs->radio("targetCancel0", "targetCancel", 0, $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "targetCancel") , "キャンセル料なし")?>

			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<?php if ($all_cancel) {?>
				<tr>
					<td align="center">
						<p>全ての予約をキャンセルします</p>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td align="center">
						<?=$inputs->submit("","cancel","キャンセル実行", "circle")?>
						<?=$inputs->submit("","change","戻る", "circle")?>
					</td>
				</tr>
			</table>
			<?=$inputs->hidden("all_cancel",$all_cancel)?>

