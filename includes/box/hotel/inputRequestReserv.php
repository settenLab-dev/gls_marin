			<section>
				<h2>◆予約リクエストの内容</h2>
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
													<?php $arData = cmShopPersonSelect();?>
													<select name="BOOKING_PRICEPERSON<?php print $i;?>" id="BOOKING_PRICEPERSON<?php print $i;?>" class="circle">
													<?php foreach ($arData as $k=>$v) {?>
														<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON".$i)==$k)?'selected="selected"':''?>><?php print $v;?></option>
													<?php }?>
												</select> 人
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
													<?php $arData = cmShopPersonSelect();?>
													<select name="BOOKING_PRICEPERSON7" id="BOOKING_PRICEPERSON7" class="circle">
													<?php foreach ($arData as $k=>$v) {?>
														<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON7")==$k)?'selected="selected"':''?>><?php print $v;?></option>
													<?php }?>
													</select> 組
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
													<?php $arData = cmShopPersonSelect();?>
													<select name="BOOKING_PRICEPERSON8" id="BOOKING_PRICEPERSON8" class="circle">
													<?php foreach ($arData as $k=>$v) {?>
														<option value="<?php print $k;?>" <?php print ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PRICEPERSON8")==$k)?'selected="selected"':''?>><?php print $v;?></option>
													<?php }?>
													</select> 人
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
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_NAME")); ?>
								<?php
									$booking_name1 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME1");
									$booking_name2 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME2");
									
									if(empty($booking_name1)){
										$booking_name1 = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1");
									}
									
									if(empty($booking_name2)){
										$booking_name2 = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2");
									}
								?>
								姓<?php echo $inputs->text("BOOKING_NAME1", $booking_name1, "imeActive wNum circle",50)?>
								名<?php echo $inputs->text("BOOKING_NAME2", $booking_name2, "imeActive wNum circle",50)?>
							</td>
						</tr>
						<tr>
							<th>フリガナ</th>
							<td>
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_KANA")); ?>
								<?php
									$booking_kana1 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_KANA1");
									$booking_kana2 = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_KANA2");
									
									if(empty($booking_kana1)){
										$booking_kana1 = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1");
									}
									
									if(empty($booking_kana2)){
										$booking_kana2 = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2");
									}
								?>
								セイ<?php echo $inputs->text("BOOKING_KANA1", $booking_kana1, "imeActive wNum circle",50)?>
								メイ<?php echo $inputs->text("BOOKING_KANA2", $booking_kana2, "imeActive wNum circle",50)?>
							</td>
						</tr>
						<tr>
							<th>メールアドレス</th>
							<td>
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_MAILADDRESS")); ?>
								<?php
									$booking_mail = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS");
									
									if(empty($booking_mail)){
										$booking_mail = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_MAILADDRESS_SUB");
									}
								?>
								<?php echo $inputs->text("BOOKING_MAILADDRESS", $booking_mail, "imeActive circle",50)?>
								<p class="small">※ご予約完了時にメールをお送りします。</p>
							</td>
						</tr>
						<tr>
							<th>ご住所</th>
							<td>
								<?php
									// ログイン済みメンバーの場合は初期値に登録されているデータを設定
									$booking_pref_id = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PREF_ID");
									$arPref = cmGetAllPrefName();
									if(empty($booking_pref_id)){
										$booking_pref_id = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_PREF");
									}
									
									$booking_city = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_CITY");
									if(empty($booking_city)){
										$booking_city = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_CITY");
									}
									
									$booking_address = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS");
									if(empty($booking_address)){
										$booking_address = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ADDRESS");
									}
									
									$booking_build = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_BUILD");
									if(empty($booking_build)){
										$booking_build = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_BUILD");
									}
								?>
								
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_PREF_ID")); ?>
								都道府県
								<?php // echo $inputs->text("MEMBER_PREF", $member_pref, "imeActive circle",50)?>
								<select name="BOOKING_PREF_ID" id="BOOKING_PREF_ID" class="">
									<option value=''>未選択</option>
									<?php foreach ($arPref as $k=>$v) {?>
										<option value="<?php echo $k;?>" <?php echo ($booking_pref_id==$k)?'selected="selected"':''?>><?php echo $v;?></option>
									<?php }?>
								</select>
								<br/>
								
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_CITY")); ?>
								市町村<?php echo $inputs->text("BOOKING_CITY", $booking_city, "imeActive circle",50)?><br/>
								
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_ADDRESS")); ?>
								その他住所<?php echo $inputs->text("BOOKING_ADDRESS", $booking_address, "imeActive circle",50)?><br/>
								
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_BUILD")); ?>
								建物名<?php echo $inputs->text("BOOKING_BUILD", $booking_build, "imeActive circle",50)?>
							</td>
						</tr>
						<tr>
							<th>電話番号</th>
							<td>
								<?php
									$member_tel = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_TEL");
									if(empty($member_tel)){
										$member_tel = $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1");
									}
								?>
								<?php echo create_error_msg($shopBooking->getErrorByKey("BOOKING_TEL")); ?>
								<?php echo $inputs->text("BOOKING_TEL", $member_tel, "imeActive wNum circle",50)?>
								<p class="small">※当日ご連絡がつく番号をご入力ください。</p>
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
										<div>回答を入力して下さい。</div>
										<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_ANSWER"))?>
										<?php echo $inputs->textarea("BOOKING_ANSWER", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ANSWER"), "imeActive boxshadow2",30,4)?>
									</td>
								</tr>
							</tbody>
						</table>
					<?php }?>
		
					<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEMAND") == 1) {?>
						<table class="style5 space">
							<tbody>
								<tr><th>ショップへの<br>メッセージ</th><td><div>ご質問やご要望がありましたらご記入ください。</div>
								<?php print create_error_msg($shopBooking->getErrorByKey("BOOKING_DEMAND"))?>
								<?php echo $inputs->textarea("BOOKING_DEMAND", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DEMAND"), "imeActive boxshadow2",30,4)?>
								<p class="small">※内容によってはご要望にお応えできない場合もございます。<br>ご要望の対応につきましては、予約後に施設店舗へお問い合わせください。</p>
								</td></tr>
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
									<!-- 
									<?php
										// 支払い方法を選択させる場合はコメントアウト解除
										/* $arrPayment = array(
											1 => '現地で現金決済',
											2 => '現地でカード決済',
											3 => '事前に現金決済',
											4 => '事前にカード決済',
										);
										$booking_payment  = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PAYMENT"); */
									?>
									<?php // echo create_error_msg($shopBooking->getErrorByKey("BOOKING_PAYMENT")); ?>
									<select name="BOOKING_PAYMENT" id="BOOKING_PAYMENT" class="" style='width: auto;'>
										<option value=''>未選択</option>
										<?php foreach ($arrPayment as $k => $v):?>
											<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT".$k)==1):?>
												<option value="<?php echo $k;?>" <?php echo ($booking_payment==$k)?'selected="selected"':''?>><?php echo $v;?></option>
											<?php endif;?>
										<?php endforeach;?>
									</select>
									 -->
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
				<p>予約リクエスト内容の確認画面へお進み下さい。</p>
				<?php  print create_error_msg($shopBooking->getErrorByKey("BOOKING_NUMS"))?>
				<!-- <img src="images/reservation/reservation-submit.jpg"> -->
				<input type="image" src="images/reservation/request-reservation-submit.png" name="confirm_x" value="予約内容の確認画面へ">
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
	
				if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID") != ""){
					$tmp .=  $inputs->hidden("MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
					$tmp .=  $inputs->hidden("BOOKING_MEMBER_FLG", "1");
				}else{
					$tmp .=  $inputs->hidden("BOOKING_MEMBER_FLG", "2");
				}
				/*
				$tmp .=  $inputs->hidden("BOOKING_NAME1", $collection->getByKey($collection->getKeyValue(), "BOOKING_NAME1"));
				$tmp .=  $inputs->hidden("BOOKING_NAME2", $collection->getByKey($collection->getKeyValue(), "BOOKING_NAME2"));
				$tmp .=  $inputs->hidden("BOOKING_KANA1", $collection->getByKey($collection->getKeyValue(), "BOOKING_KANA1"));
				$tmp .=  $inputs->hidden("BOOKING_KANA2", $collection->getByKey($collection->getKeyValue(), "BOOKING_KANA2"));
	
				$tmp .=  $inputs->hidden("BOOKING_TEL", $collection->getByKey($collection->getKeyValue(), "BOOKING_TEL"));
				$tmp .=  $inputs->hidden("BOOKING_MAILADDRESS", $collection->getByKey($collection->getKeyValue(), "BOOKING_MAILADDRESS"));
				*/
	
				$tmp .=  $inputs->hidden("BOOKING_STATUS", "5");
				$tmp .=  $inputs->hidden("priceper_num", $collection->getByKey($collection->getKeyValue(), "priceper_num"));
				$tmp .=  $inputs->hidden("zaiko_num", $collection->getByKey($collection->getKeyValue(), "zaiko_num"));
				$tmp .=  $inputs->hidden("target_date", $collection->getByKey($collection->getKeyValue(), "target_date"));
				$tmp .=  $inputs->hidden("BOOKING_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
	
				print $tmp;
			?>