<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
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
						<th rowspan="2"><p>ﾉｰｼｮｰ</p></th>
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
						<?php 
						$k = 0;
						foreach ($hotelBookingcont->getCollection() as $ad) {?>
						<?php
						$rclass = '';
						if ($ad["BOOKINGCONT_STATUS"] == 2) {
							//	キャンセル済み
							$rclass = 'class="bgLightGrey"';
						}
						?>
					<tr>
						<?php  
						$k++;
						$num = ceil(($k/$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM")))-1;
						$ad["BOOKINGCONT_DATE"] = $num>0?date("Y-m-d",strtotime("+$num day",strtotime($ad["BOOKINGCONT_DATE"]))):$ad["BOOKINGCONT_DATE"];
						?>
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
							<?php if ($ad["BOOKINGCONT_STATUS"] == 1 || $ad["BOOKINGCONT_STATUS"] == 5) {?>
								<?php
								$checked = '';
								if ($_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 1) {
									$checked = 'checked="checked"';
								}
								?>
								<input type="radio" id="canceldata<?=$ad["BOOKINGCONT_ID"]?>" name="canceldata[<?=$ad["BOOKINGCONT_ID"]?>]" value="1" <?php print $checked?> />
							<?php }elseif ($ad["BOOKINGCONT_STATUS"] == 2) {?>
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
						<td <?=$rclass?>>
						<?php if ($ad["BOOKINGCONT_STATUS"] == 1 || $ad["BOOKINGCONT_STATUS"] == 5) {?>
						<?php
								$checked = '';
								if ($_POST["canceldata"][$ad["BOOKINGCONT_ID"]] == 2) {
									$checked = 'checked="checked"';
								}
								?>
						<input type="radio" id="canceldata<?=$ad["BOOKINGCONT_ID"]?>" name="canceldata[<?=$ad["BOOKINGCONT_ID"]?>]" value="2" <?php print $checked?> />
						<?php }elseif ($ad["BOOKINGCONT_STATUS"] == 3) {?>
								<p><?php print $ad["BOOKINGCONT_DATE_CANCEL"]?></p>
								<p><?php print number_format($ad["BOOKINGCONT_MONEY_CANCEL"])?>円</p>
							<?php }?>
						<?php }?>
						</td>
					</tr>
					<?php }else {?>
					<?php }?>
				</tbody>
			</table>
			
			<br />
			
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center">
						<?=$inputs->submit("","cancelconfirm","状態変更確認", "circle")?>
					</td>
				</tr>
			</table>
			</form>
			<br/><br/>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
			予約詳細編集
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<td width="160" valign="top">
				<p>通知番号</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "NOTIFICATION_ID")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>予約番号</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ID")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>予約時間</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DATE_START")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>宿泊者名</p>
			</td>
			<td align="left">
				姓　<?php print $inputs->text("BOOKING_NAME1", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NAME1") ,"imeDisabled circle wNum",20,"disabled")?>	　名<?php 
				print $inputs->text("BOOKING_NAME2", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NAME2") ,"imeDisabled circle wNum",20,"disabled")?>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>住所</p>
			</td>
			<td align="left">
				沖縄県　<?php 
				print $inputs->text("BOOKING_CITY", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CITY") ," circle wNum",30,"disabled")?> <?php 
				print $inputs->text("BOOKING_BUILD", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_BUILD") ,"imeActive circle wNum",30,"disabled")?> <?php 
				print $inputs->text("BOOKING_ADDRESS", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ADDRESS") ,"imeActive circle wNum",30,"disabled")?>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>生年月日</p>
			</td>
			<td align="left">
			<?=$inputs->hidden("MEMBER_ID",$hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_ID"))?>
				<p><?php print $inputs->text("MEMBER_BIRTH_YEAR", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_YEAR") ,"imeActive circle wNum",20,"disabled")?>年 <?php print $inputs->text("MEMBER_BIRTH_MONTH", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_MONTH"),"imeActive circle wNum",20,"disabled")?>月 <?php print $inputs->text("MEMBER_BIRTH_DAY", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_DAY") ,"imeActive circle wNum",20,"disabled")?>日</p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>電話番号</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_TEL", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_TEL") ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>メールアドレス</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_MAILADDRESS", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_MAILADDRESS") ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>チェックイン日・時間</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DATE")." ".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CHECKIN")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>泊数</p>
			</td>
			<td align="left">
			<!-- 
				<p><?php print $inputs->text("BOOKING_NUM_NIGHT", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_NIGHT") ,"imeActive circle",20,"disabled")?></p>
			-->
			<p><?php print $inputs->text("BOOKING_NUM_NIGHT", ceil($cancel_num/$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM")) ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>部屋数</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_NUM_ROOM", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM") ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>プラン名</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_NAME")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>部屋タイプ</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "ROOM_NAME")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>プラン内容</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CONTENTS")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>予約の合計人数</p>
			</td>
			<td align="left">
				<p><?=$ad["BOOKINGCONT_NUM1"]+$ad["BOOKINGCONT_NUM2"]+$ad["BOOKINGCONT_NUM3"]+$ad["BOOKINGCONT_NUM4"]+$ad["BOOKINGCONT_NUM5"]+$ad["BOOKINGCONT_NUM6"]+$ad["BOOKINGCONT_NUM7"]+$ad["BOOKINGCONT_NUM8"]?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>合計料金
				</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_MONEY", $cancel_money?$cancel_money:$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_MONEY") ,"imeActive circle",20)?>円</p>
			</td>
			</tr>
			<tr>
			
			<td width="160" valign="top">
				<p>手数料
				</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("HOTELPAY_SERVICE", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")*($cancel_money?$cancel_money:$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_MONEY"))/100 ,"imeActive circle",20,'disabled')?>円</p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>お客さまからのメッセージ</p>
			</td>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DEMAND")?></p>
			</td>
			</tr>	
			<tr>
			<td width="160" valign="top">
				<p>施設からの質問への回答</p>
			</td>
			<td align="left">
				<p><?php print $inputs->textarea("BOOKING_ANSWER", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER") ,"imeActive circle",50)?></p>
			</td>
			</tr>
			 <tr>
			<td width="160" valign="top">
				<p>予約変更の締切</p>
			</td>
			<?php
                        $arData = cmHotelDaySelect();

                        $d = $arData[$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_DAY")];
                        $h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_HOUR");
                        $m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ACC_MIN");

//                         $candate = date("Y年m月d日",strtotime("-".($d-1)." day" ,strtotime($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"))))
                        ?>
                        <td><b class="large red"><?php print $d?> <?php print $h?>時<?php print $m?>分</b><p class="small">※上記の時間を過ぎた場合は、サイト上から変更・キャンセルを行うことができません。<br>宿泊施設へ直接ご連絡ください。</p></td>
                   
			</tr>
			 <tr>
			<td width="160" valign="top">
				<p>キャンセルの締切</p>
			</td>
			<?php
                        $arData = cmHotelDaySelect();

                        $d = $arData[$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")];
                        $h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
                        $m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");

//                         $candate = date("Y年m月d日",strtotime("-".($d-1)." day" ,strtotime($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"))))
                        ?>
                        <td><b class="large red"><?php print $d?> <?php print $h?>時<?php print $m?>分</b><p class="small">※上記の時間を過ぎた場合は、サイト上から変更・キャンセルを行うことができません。<br>宿泊施設へ直接ご連絡ください。</p></td>
                   
			</tr>
			</table>
			<br/>
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center">
						<?=$inputs->submit("","bookingConfirm","保存する", "circle")?>
					</td>
				</tr>
			</table> 
			</form>
			<br/><br/>
			<?php if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_STATUS") == 5 || $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") != "") {
			?>			
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
			リクエスト回答・メッセージ送信
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<tr>
			<td width="160" valign="top">
				<p>予約リクエスト回答</p>
			</td>
			<td align="left">
				予約リクエスト回答：　<?php print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",1,$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") ,"予約可能") ?>
				&nbsp; <?php print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",2,$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") ,"受入れ不可") ?>
				<br/>※　必ずどちらかを選択してメッセージ送信をしてください。<?php print create_error_msg($hotelBooking->getErrorByKey("BOOKING_REQUEST"))?>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>お客様へメッセージを送る</p>
			</td>
			<td align="left"> 
				<?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER")?$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER"):$inputs->textarea("BOOKING_REQUEST_ANSWER", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER") ,"imeActive circle",50) ?>
				<br/>※お客様へのメッセージを入力してください。<?php print create_error_msg($hotelBooking->getErrorByKey("BOOKING_REQUEST_ANSWER"))?>
			</td>
			</tr>
			</table>
			
			<br/>
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center">
						<?=$inputs->submit("requestConfirm","requestConfirm","メッセージ送信", "circle")?>
					</td>
				</tr>
			</table> 
			</form>
			<?php }?>