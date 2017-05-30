			<section>
				<h2>お申込み内容の確認</h2>
				<table class="style1">
					<tbody>
						<tr><th>主催会社</th><td><?php print $shop->getByKey($shop->getKeyValue(), "SHOP_NAME")?></td></tr>
						<tr><th>プラン名</th><td><?php print $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_NAME")?></td></tr>
						<!-- <tr><th>コース</th><td><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></td></tr> -->
						<?php
							$arHourData = cmShopHourSelect();
							$arMinData = cmShopMinSelect();
							
							$hour_id = $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_MEET_TIMEHOUR");
							$min_id  = $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_MEET_TIMEMIN");
						?>
						<tr>
							<th>コース</th>
							<td>
								<?php echo $inputs->hidden("BOOKING_MEET_TIME", $arHourData[$hour_id]."：".$arMinData[$min_id]); ?>
								<?php echo $arHourData[$hour_id].":".$arMinData[$min_id];?>
							</td>
						</tr>
						<tr><th>催行日</th><td><?php print $_POST['target_date']?$_POST['target_date']:$hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE")?></td></tr>
					</tbody>
				</table>

				<table class="style3">
					<tbody>
						<tr>
							<th class="bg2">申込人数</th>
							<td>
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_PRICEPERSON")); ?>
								<table>
									<?php echo $inputs->hidden("SHOP_PRICETYPE_KIND", $roomPerDay["SHOP_PRICETYPE_KIND"]); ?>
									<?php if($roomPerDay["SHOP_PRICETYPE_KIND"]==1): ?>
										<?php for($i=1;$i<=$roomPerDay["count_pay"];$i++): ?>
											<tr>
												<td>
													<?php echo $inputs->hidden("SHOP_PRICETYPE_MONEYKIND".$i, $roomPerDay["SHOP_PRICETYPE_MONEYKIND".$i]); ?>
													<?php echo $inputs->hidden("SHOP_PRICETYPE_MONEY".$i, $roomPerDay["SHOP_PRICETYPE_MONEY".$i]); ?>
													
													<?php print $roomPerDay["SHOP_PRICETYPE_MONEY".$i];?>  /
													<?php print number_format($roomPerDay["HOTELPAY_MONEY".$i])." 円";?>
												</td>
												<td>
													<?php echo $inputs->hidden("BOOKING_PRICEPERSON".$i, $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON".$i)); ?>
													<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON".$i); ?> 人
												</td>
											</tr>
					
										<?php endfor; ?>
									<?php elseif($roomPerDay["SHOP_PRICETYPE_KIND"]==2): ?>
											<tr>
												<td>
													<?php echo $inputs->hidden("SHOP_PRICETYPE_MONEY7MIN", $roomPerDay["SHOP_PRICETYPE_MONEY7MIN"]); ?>
													<?php echo $inputs->hidden("SHOP_PRICETYPE_MONEY7MAX", $roomPerDay["SHOP_PRICETYPE_MONEY7MAX"]); ?>
													
													<?php print $roomPerDay["SHOP_PRICETYPE_MONEYKIND7"];?>  /
													<?php print number_format($roomPerDay["HOTELPAY_MONEY7"])." 円";?>
												</td>
												<td>
													<?php echo $inputs->hidden("BOOKING_PRICEPERSON7", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON7")); ?>
													<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON7"); ?> 組
												</td>
											</tr>
					
										<?php if($roomPerDay["SHOP_PRICETYPE_ADDFLG"]==1): ?>
											<tr>
												<td>
													<?php echo $inputs->hidden("SHOP_PRICETYPE_ADDFLG", $roomPerDay["SHOP_PRICETYPE_ADDFLG"]); ?>
													<?php print $roomPerDay["SHOP_PRICETYPE_MONEY8"];?>  /
													<?php print number_format($roomPerDay["HOTELPAY_MONEY8"])." 円";?>
												</td>
												<td>
													<?php echo $inputs->hidden("BOOKING_PRICEPERSON8", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON8")); ?>
													<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON8"); ?> 人
												</td>
											</tr>
										<?php endif; ?>
									<?php endif; ?>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</section>

			<section>
				<h2>◆予約代表者の情報 <span class="colorRed">※</span></h2>
				<table class="style5 space">
					<tbody>
						<tr>
							<th>お名前</th>
							<td>
								<?php
									$booking_name1 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME1");
									$booking_name2 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME2");
									
									echo $inputs->hidden("BOOKING_NAME1", $booking_name1);
									echo $inputs->hidden("BOOKING_NAME2", $booking_name2);
								?>
								<?php echo $booking_name1." ".$booking_name2; ?>
							</td>
						</tr>
						<tr>
							<th>フリガナ</th>
							<td>
								<?php
									$booking_kana1 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_KANA1");
									$booking_kana2 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_KANA2");
									
									echo $inputs->hidden("BOOKING_KANA1", $booking_kana1);
									echo $inputs->hidden("BOOKING_KANA2", $booking_kana2);
								?>
								<?php echo $booking_kana1." ".$booking_kana2; ?>
							</td>
						</tr>
						<tr>
							<th>メールアドレス</th>
							<td>
								<?php
									$booking_mail = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS");
									
									echo $inputs->hidden("BOOKING_MAILADDRESS", $booking_mail);
								?>
								<?php echo $booking_mail; ?>
							</td>
						</tr>
						<tr>
							<th>ご住所</th>
							<td>
								<?php
									$arPref = cmGetAllPrefName();
									$booking_pref_id    = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PREF_ID");
									$booking_city    = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_CITY");
									$booking_address = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS");
									$booking_build   = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_BUILD");
									
									echo $inputs->hidden("BOOKING_PREF_ID", $booking_pref_id);
									echo $inputs->hidden("BOOKING_CITY", $booking_city);
									echo $inputs->hidden("BOOKING_ADDRESS", $booking_address);
									echo $inputs->hidden("BOOKING_BUILD", $booking_build);
								?>
								<?php echo $arPref[$booking_pref_id].$booking_city.$booking_address.$booking_build; ?>
								
							</td>
						</tr>
						<tr>
							<th>電話番号</th>
							<td>
								<?php
									$member_tel = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_TEL");
									echo $inputs->hidden("BOOKING_TEL", $member_tel);
								?>
								<?php echo $member_tel; ?>
							</td>
						</tr>
					</tbody>
				</table>
			</section>

			<?php
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION") != ""
					|| $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEMAND") == 1) {
			?>
				<section>
					<h2>◆ご質問項目 <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION_REC")==1)?'<span class="colorRed">※</span>':''?></h2>
					<?php echo $inputs->hidden("SHOPPLAN_QUESTION_REC", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION_REC")); ?>
					<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION") != "") {?>
						<table class="style5">
							<tbody>
								<tr>
									<th>ショップ<br>からの質問</th>
									<td><?php print redirectForReturn($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION"))?></td>
								</tr>
								<tr>
									<th>質問への回答</th>
									<td>
										<?php
											$booking_answer = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ANSWER");
											echo $inputs->hidden("BOOKING_ANSWER", $booking_answer);
										?>
										<?php echo nl2br($booking_answer); ?>
									</td>
								</tr>
							</tbody>
						</table>
					<?php }?>
		
					<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEMAND") == 1) {?>
						<table class="style5 space">
							<tbody>
								<tr>
									<th>ショップへの<br>メッセージ</th>
									<td>
										<?php
											$booking_demand = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DEMAND");
											echo $inputs->hidden("BOOKING_DEMAND", $booking_demand);
										?>
										<?php echo nl2br($booking_demand); ?>
									</td>
								</tr>
							</tbody>
						</table>
					<?php }?>
				</section>
			<?php }?>

			<section>
				<h2>◆お支払方法</h2>
				<table class="style5 space">
					<tbody>
						<tr>
							<th>お支払方法</th>
							<td>
								<div>
									<?php
										// 支払い方法を選択させる場合はコメントアウト解除
										/* $arrPayment = array(
											1 => '現地で現金決済',
											2 => '現地でカード決済',
											3 => '事前に現金決済',
											4 => '事前にカード決済',
										);
										$booking_payment  = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PAYMENT");
										echo $inputs->hidden("BOOKING_PAYMENT", $booking_payment);
										echo $arrPayment[$booking_payment]; */
									?>
									<?php 
										if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT1")==1){
											print "・現地で現金決済";
										}
										if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT2")==1){
											print "・現地でカード決済";
										}
										if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT3")==1){
											print "・事前に現金決済(振込等)";
										}
										if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT4")==1){
											print "・事前にカード決済";
										}
										if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT5") != ""){
											print "<br><br>". $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT5");
										}
									?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</section>

			<section>
				<h2>◆キャンセルポリシー</h2>
				<table class="style5 space">
				<tbody>
					<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG_CANCEL") == 1) {?>

						<?php if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {?>

							<?php if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {?>
								<?php
								$can = "";
								if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
									$can = "料金の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
								}
								else {
									$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
								}
								?>
								<tr><th>無連絡不泊</th><td><?php print $can;?></td></tr>
							<?php }?>

							<?php if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {?>
								<?php
								$can = "";
								if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
									$can = "料金の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
								}
								else {
									$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
								}
								?>
								<tr><th>当日キャンセル</th><td><?php print $can;?></td></tr>
							<?php }?>

							<?php for ($i=3; $i<=7; $i++) {?>
								<?php if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {?>
									<?php
									$can = "";
									if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
										$can = "料金の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
									}
									else {
										$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
									}
									?>
									<tr><th><?php print $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)?>～<?php print $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)?> 日前まで</th><td><?php print $can;?></td></tr>
								<?php }?>
							<?php }?>

						<?php }?>

					<?php }else{?>
						<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG1") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1") != "") {?>
							<?php
							$can = "";
							if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG1") == 1) {
								$can = "料金の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."%";
							}
							else {
								$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."円";
							}
							?>
							<tr><th>無連絡不泊</th><td><?php print $can;?></td></tr>
						<?php }?>
						<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG2") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2") != "") {?>
							<?php
							$can = "";
							if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG2") == 1) {
								$can = "料金の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."%";
							}
							else {
								$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."円";
							}
							?>
							<tr><th>当日</th><td><?php print $can;?></td></tr>
						<?php }?>

						<?php for ($i=3; $i<=6; $i++) {?>
							<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i) != "") {?>
								<?php
								$can = "";
								if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) == 1) {
									$can = "料金の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."%";
								}
								else {
									$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."円";
								}
								?>
								<tr><th><?php print $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i)?>～<?php print $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_TO".$i)?> 日前まで</th><td><?php print $can;?></td></tr>
							<?php }?>
						<?php }?>
					<?php }?>
				</tbody>
				</table>
			</section>


				<div class="bottom">
					<p>この内容で宜しければ予約するボタンをクリックして下さい。</p>
					<?php  print create_error_msg($shopBooking->getErrorByKey("BOOKING_NUMS"))?>
					<table  border="0" style="border:none; width: 200px;" width="200">
						<tr>
							<td style="border:none;">
								<input type="image" src="images/reservation/btn_regist.jpg" name="regist" value="この内容で予約する">
								<!--<?=$inputs->submit("","regist","この内容で予約する", "")?>-->
							</td>
							<td style="border:none;">
								<input type="image" src="images/reservation/btn_change.jpg" name="change" value="変更する">
								<!--<?=$inputs->submit("","change","変更する", "")?>-->
							</td>
						</tr>
					</table>

				</div>


				<?php
				$tmp = "";
				$tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
				$tmp .=  $inputs->hidden("SHOPPLAN_ID", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"));
				$tmp .=  $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
				$tmp .=  $inputs->hidden("HOTELPAY_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID"));
				$tmp .=  $inputs->hidden("HOTELPROVIDE_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"));
				$tmp .=  $inputs->hidden("SHOP_PRICETYPE_ID", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID"));
				
				$tmp .=  $inputs->hidden("SHOPPLAN_MEET_TIMEHOUR", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_MEET_TIMEHOUR"));
				$tmp .=  $inputs->hidden("SHOPPLAN_MEET_TIMEMIN", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_MEET_TIMEMIN"));
	
				if($collection->getByKey($collection->getKeyValue(), "MEMBER_ID") != ""){
						$tmp .=  $inputs->hidden("MEMBER_ID", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"));
						$tmp .=  $inputs->hidden("BOOKING_MEMBER_FLG", "1");
				}else{
						$tmp .=  $inputs->hidden("BOOKING_MEMBER_FLG", "2");
				}
				
				$tmp .=  $inputs->hidden("BOOKING_STATUS", "1");
				$tmp .=  $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));
				$tmp .=  $inputs->hidden("zaiko_num", $collection->getByKey($collection->getKeyValue(), "zaiko_num"));
				$tmp .=  $inputs->hidden("target_date", $collection->getByKey($collection->getKeyValue(), "target_date"));
				$tmp .=  $inputs->hidden("BOOKING_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
				print $tmp;
				?>