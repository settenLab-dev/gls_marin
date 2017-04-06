<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
				<thead>
					<tr>
						<th width="50" rowspan="2"><p>宿泊日</p></th>
						<th width="50" rowspan="2"><p>部屋目</p></th>
						<th rowspan="2"><p>大人</p></th>
						<th colspan="2"><p>小学生</p></th>
						<th colspan="4"><p>幼児</p></th>
						<th rowspan="2"><p>料金合計</p></th>
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