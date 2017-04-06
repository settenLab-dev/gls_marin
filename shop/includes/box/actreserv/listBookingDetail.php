<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
				<thead>
					<tr>
						<th width="50" rowspan="2"><p>利用日</p></th>
						<th width="50" rowspan="2"><p>組数</p></th>
						<th rowspan="2"><p>大人</p></th>
						<th colspan="2"><p>小人</p></th>
						<th colspan="4"><p>幼児</p></th>
						<th rowspan="2"><p>料金合計</p></th>
						<th rowspan="2"><p>ｷｬﾝｾﾙ</p></th>
					</tr>
					<tr>
						<th><p>(A)</p></th>
						<th><p>(B)</p></th>
						<th><p>(A)</p></th>
						<th><p>(B)</p></th>
						<th><p>(C)</p></th>
						<th><p>(D)</p></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($hotelBookingcont->getCount() > 0) {?>
						<?php foreach ($hotelBookingcont->getCollection() as $ad) {?>
						<?php
						$rclass = '';
						if ($ad["BOOKINGCONT_STATUS"] == 2) {
							//	キャンセル済み
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
							<?php if ($ad["BOOKINGCONT_STATUS"] == 1) {?>
								<?php
								$checked = '';
								if ($_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 1) {
									$checked = 'checked="checked"';
								}
								?>
								<input type="checkbox" id="canceldata<?=$ad["BOOKINGCONT_ID"]?>" name="canceldata[<?=$ad["BOOKINGCONT_ID"]?>]" value="1" <?php print $checked?> />
							<?php }else{?>
								<p><?php print $ad["BOOKINGCONT_DATE_CANCEL"]?></p>
								<p><?php print number_format($ad["BOOKINGCONT_MONEY_CANCEL"])?>円</p>
							<?php }?>
							<?php /*
							<?php print create_error_msg($hotelBookingcont->getErrorByKey("cancelMoney".$ad["BOOKINGCONT_ID"]))?>
							<?php print $inputs->text("cancelMoney".$ad["BOOKINGCONT_ID"], $hotelBookingcont->getByKey($hotelBookingcont->getKeyValue(), "cancelMoney".$ad["BOOKINGCONT_ID"]) ,"imeDisabled circle wNum dspNon",50)?>

							<script type="text/javascript">
							$(document).ready(function(){
								$("#canceldata<?=$ad["BOOKINGCONT_ID"]?>").change(function(){
									cancelDisabled<?=$ad["BOOKINGCONT_ID"]?>();
								});
								cancelDisabled<?=$ad["BOOKINGCONT_ID"]?>();
							});
							function cancelDisabled<?=$ad["BOOKINGCONT_ID"]?>() {
								if ($("#canceldata<?=$ad["BOOKINGCONT_ID"]?>:checked").val() == 1) {
									$("#cancelMoney<?=$ad["BOOKINGCONT_ID"]?>").removeClass('dspNon');
								}
								else {
									$("#cancelMoney<?=$ad["BOOKINGCONT_ID"]?>").addClass('dspNon');
								}
							}
							</script>
							*/?>
						</td>
					</tr>
						<?php }?>
					<?php }else {?>
					<?php }?>
				</tbody>
			</table>
			<br />
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center">
						<?=$inputs->submit("","cancelconfirm","キャンセル確認", "circle")?>
					</td>
				</tr>
			</table>