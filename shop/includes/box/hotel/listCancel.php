<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
				<thead>
					<tr>
						<th width="50" rowspan="2"><p>催行日</p></th>
						<th rowspan="2"><p>大人</p></th>
						<th colspan="2"><p>小人</p></th>
						<th colspan="4"><p>幼児</p></th>
						<th colspan="4"><p>グループ</p></th>
						<th colspan="4"><p>追加</p></th>
						<th rowspan="2"><p>合計料金</p></th>
						<th rowspan="2"><p>対応</p></th>
						<th rowspan="2"><p>状況</p></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($shopBooking->getCount() > 0) {?>
						<?php 
						$k = 0;
						foreach ($shopBooking->getCollection() as $ad) {?>
						<?php
						$rclass = '';
						if ($ad["BOOKING_STATUS"] == 2) {
							//	キャンセル済み
							$rclass = 'class="bgLightGrey"';
						}
						?>
					<tr>
						<?php  
						$k++;
						$num = ceil(($k/$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NUM_ROOM")))-1;
						$ad["BOOKING_DATE"] = $num>0?date("Y-m-d",strtotime("+$num day",strtotime($ad["BOOKING_DATE"]))):$ad["BOOKING_DATE"];
						?>
						<td <?=$rclass?>><?=$ad["BOOKING_DATE"]?></td>
						<td <?=$rclass?>><?=$ad["BOOKING_ROOM"]?></td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON1"]?><br /><?=number_format($ad["BOOKING_MONEY1"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON2"]?>人<br /><?=number_format($ad["BOOKING_MONEY2"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON3"]?>人<br /><?=number_format($ad["BOOKING_MONEY3"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON4"]?>人<br /><?=number_format($ad["BOOKING_MONEY4"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON5"]?>人<br /><?=number_format($ad["BOOKING_MONEY5"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON6"]?>人<br /><?=number_format($ad["BOOKING_MONEY6"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON7"]?>組<br /><?=number_format($ad["BOOKING_MONEY7"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKING_PRICEPERSON8"]?>人<br /><?=number_format($ad["BOOKING_MONEY8"])?>円</td>
						<td <?=$rclass?>><?=number_format($ad["BOOKING_ALL_MONEY"])?></td>
						<td <?=$rclass?>>
							<?php if ($ad["BOOKING_STATUS"] == 1 || $ad["BOOKING_STATUS"] == 5) {?>
								<?php
								$checked = '';
								if ($_POST["canceldata"][$ad["BOOKING_ID"]] == 1) {
									$checked = 'checked="checked"';
								}
								?>
								<input type="radio" id="canceldata<?=$ad["BOOKING_ID"]?>" name="canceldata[<?=$ad["BOOKING_ID"]?>]" value="1" <?php print $checked?> />
							<?php }elseif ($ad["BOOKING_STATUS"] == 2) {?>
								<p><?php print $ad["BOOKING_DATE_CANCEL"]?></p>
								<p><?php print number_format($ad["BOOKING_MONEY_CANCEL"])?>円</p>
							<?php }?>
							<?php /*
							<?php print create_error_msg($shopBookingcont->getErrorByKey("cancelMoney".$ad["BOOKING_ID"]))?>
							<?php print $inputs->text("cancelMoney".$ad["BOOKING_ID"], $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "cancelMoney".$ad["BOOKING_ID"]) ,"imeDisabled circle wNum dspNon",50)?>

							<script type="text/javascript">
							$(document).ready(function(){
								$("#canceldata<?=$ad["BOOKING_ID"]?>").change(function(){
									cancelDisabled<?=$ad["BOOKING_ID"]?>();
								});
								cancelDisabled<?=$ad["BOOKING_ID"]?>();
							});
							function cancelDisabled<?=$ad["BOOKING_ID"]?>() {
								if ($("#canceldata<?=$ad["BOOKING_ID"]?>:checked").val() == 1) {
									$("#cancelMoney<?=$ad["BOOKING_ID"]?>").removeClass('dspNon');
								}
								else {
									$("#cancelMoney<?=$ad["BOOKING_ID"]?>").addClass('dspNon');
								}
							}
							</script>
							*/?>
						</td>
						<td <?=$rclass?>>
						<?php if ($ad["BOOKING_STATUS"] == 1 || $ad["BOOKING_STATUS"] == 5) {?>
						<?php
								$checked = '';
								if ($_POST["canceldata"][$ad["BOOKING_ID"]] == 2) {
									$checked = 'checked="checked"';
								}
								?>
						<input type="radio" id="canceldata<?=$ad["BOOKING_ID"]?>" name="canceldata[<?=$ad["BOOKING_ID"]?>]" value="2" <?php print $checked?> />
						<?php }elseif ($ad["BOOKING_STATUS"] == 3) {?>
								<p><?php print $ad["BOOKING_DATE_CANCEL"]?></p>
								<p><?php print number_format($ad["BOOKING_MONEY_CANCEL"])?>円</p>
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
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "NOTIFICATION_ID")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>予約番号</p>
			</td>
			<td align="left">
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ID")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>予約時間</p>
			</td>
			<td align="left">
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE_START")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>宿泊者名</p>
			</td>
			<td align="left">
				姓　<?php print $inputs->text("BOOKING_NAME1", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME1") ,"imeDisabled circle wNum",20,"disabled")?>	　名<?php 
				print $inputs->text("BOOKING_NAME2", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME2") ,"imeDisabled circle wNum",20,"disabled")?>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>住所</p>
			</td>
			<td align="left">
				沖縄県　<?php 
				print $inputs->text("BOOKING_CITY", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_CITY") ," circle wNum",30,"disabled")?> <?php 
				print $inputs->text("BOOKING_BUILD", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_BUILD") ,"imeActive circle wNum",30,"disabled")?> <?php 
				print $inputs->text("BOOKING_ADDRESS", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS") ,"imeActive circle wNum",30,"disabled")?>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>生年月日</p>
			</td>
			<td align="left">
			<?=$inputs->hidden("MEMBER_ID",$shopBooking->getByKey($shopBooking->getKeyValue(), "MEMBER_ID"))?>
				<p><?php print $inputs->text("MEMBER_BIRTH_YEAR", $shopBooking->getByKey($shopBooking->getKeyValue(), "MEMBER_BIRTH_YEAR") ,"imeActive circle wNum",20,"disabled")?>年 <?php print $inputs->text("MEMBER_BIRTH_MONTH", $shopBooking->getByKey($shopBooking->getKeyValue(), "MEMBER_BIRTH_MONTH"),"imeActive circle wNum",20,"disabled")?>月 <?php print $inputs->text("MEMBER_BIRTH_DAY", $shopBooking->getByKey($shopBooking->getKeyValue(), "MEMBER_BIRTH_DAY") ,"imeActive circle wNum",20,"disabled")?>日</p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>電話番号</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_TEL", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_TEL") ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>メールアドレス</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_MAILADDRESS", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS") ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>チェックイン日・時間</p>
			</td>
			<td align="left">
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE")." ".$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_CHECKIN")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>泊数</p>
			</td>
			<td align="left">
			<!-- 
				<p><?php print $inputs->text("BOOKING_PRICEPERSON_NIGHT", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON_NIGHT") ,"imeActive circle",20,"disabled")?></p>
			-->
			<p><?php print $inputs->text("BOOKING_PRICEPERSON_NIGHT", ceil($cancel_num/$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON_ROOM")) ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>部屋数</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_PRICEPERSON_ROOM", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON_ROOM") ,"imeActive circle",20,"disabled")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>プラン名</p>
			</td>
			<td align="left">
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "SHOPPLAN_NAME")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>部屋タイプ</p>
			</td>
			<td align="left">
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "ROOM_NAME")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>プラン内容</p>
			</td>
			<td align="left">
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "SHOPPLAN_CONTENTS")?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>予約の合計人数</p>
			</td>
			<td align="left">
				<p><?=$ad["BOOKING_PRICEPERSON1"]+$ad["BOOKING_PRICEPERSON2"]+$ad["BOOKING_PRICEPERSON3"]+$ad["BOOKING_PRICEPERSON4"]+$ad["BOOKING_PRICEPERSON5"]+$ad["BOOKING_PRICEPERSON6"]+$ad["BOOKING_PRICEPERSON7"]+$ad["BOOKING_PRICEPERSON8"]?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>合計料金
				</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("BOOKING_ALL_MONEY", $cancel_money?$cancel_money:$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ALL_MONEY") ,"imeActive circle",20)?>円</p>
			</td>
			</tr>
			<tr>
			
			<td width="160" valign="top">
				<p>手数料
				</p>
			</td>
			<td align="left">
				<p><?php print $inputs->text("HOTELPAY_SERVICE", $hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")*($cancel_money?$cancel_money:$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MONEY"))/100 ,"imeActive circle",20,'disabled')?>円</p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>お客さまからのメッセージ</p>
			</td>
			<td align="left">
				<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DEMAND")?></p>
			</td>
			</tr>	
			<tr>
			<td width="160" valign="top">
				<p>施設からの質問への回答</p>
			</td>
			<td align="left">
				<p><?php print $inputs->textarea("BOOKING_ANSWER", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ANSWER") ,"imeActive circle",50)?></p>
			</td>
			</tr>
			 <tr>
			<td width="160" valign="top">
				<p>キャンセルの締切</p>
			</td>
			<?php
                       //                         $candate = date("Y年m月d日",strtotime("-".($d-1)." day" ,strtotime($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"))))
                        ?>
                        <td><b class="large red"><?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END") ?>日前の
						<?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE_CANCEL_END_TIME") ?></b>
					<p class="small">※上記の時間を過ぎた場合は、サイト上から変更・キャンセルを行うことができません。<br>ショップへ直接ご連絡ください。</p></td>
                   
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
			<?php if ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_STATUS") == 5 || $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") != "") {
			?>			
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
			リクエスト回答・メッセージ送信
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<tr>
			<td width="160" valign="top">
				<p>予約リクエスト回答</p>
			</td>
			<td align="left">
				予約リクエスト回答：　<?php print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",1,$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") ,"予約可能") ?>
				&nbsp; <?php print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",2,$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") ,"受入れ不可") ?>
				<br/>※　必ずどちらかを選択してメッセージ送信をしてください。<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_REQUEST"))?>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>お客様へメッセージを送る</p>
			</td>
			<td align="left"> 
				<?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER")?$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER"):$inputs->textarea("BOOKING_REQUEST_ANSWER", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER") ,"imeActive circle",50) ?>
				<br/>※お客様へのメッセージを入力してください。<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_REQUEST_ANSWER"))?>
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