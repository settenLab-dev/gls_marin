			<?php if ($shopBooking->getCount() > 0) {?>
				<?php $k = 0;$can_cancel = 0;//print_r($shopBooking->getCollection());exit;?>
				
				<!--<h3>
				<?
				if($title == ""){
					if($ad["BOOKING_STATUS"] == 2){
						$title = "この予約はキャンセル済みです。";
					}
					else if ($ad["BOOKING_STATUS"] == 3) {
						$title = "この予約はノーショーです。";
					}
					else if ($ad["BOOKING_STATUS"] == 4) {
						$title = "この予約は宿泊済みです。";
					}
					else if ($ad["BOOKING_STATUS"] == 6) {
						$title = "この予約は受入れ不可です。";
					}
					else {
						$title = "以下より予約をキャンセルします。";
					}
				}
				
				?></h3>-->
				<?php // 予約内容一覧表の作成 ▼ ?>
				<?php
					$arrBookingKind = array(
						1 => "大人",
						2 => "小人",
						3 => "幼児",
						4 => "一律"
					);
					
					$arrBooking = array_shift($shopBooking->getCollection());
					
					// 料金タイプ(1名様/1 or グループ/2)
					$price_type_kind = $arrBooking["SHOP_PRICETYPE_KIND"];
					
					// 料金パターンカウント
					$price_type_cnt = 0;
					if($price_type_kind == 1){
						for($i = 1; $i <= 6; $i++){
							if(!empty($arrBooking["BOOKING_MONEYKIND".$i])){
								$price_type_cnt++;
							}
						}
					}else{
						$price_type_cnt = 1;
						$add_member_flg = false;
						// 追加人数がいる場合
						if(!empty($arrBooking["BOOKING_PRICEPERSON8"]) && $arrBooking["BOOKING_PRICEPERSON8"] > 0){
							$price_type_cnt = 2;
							$add_member_flg = true;
						}
					}
				?>
				<table cellspacing="0" cellpadding="5" class="tblInput cancel" id="sortList" width="100%">
					<thead>
						<tr>
							<th rowspan="2"><p>催行日</p></th>
							<th colspan="<?php echo $price_type_cnt; ?>"><p>申込人数</p></th>
							<th rowspan="2"><p>料金合計</p></th>
							<th class="last" rowspan="2"><p>ｷｬﾝｾﾙ</p></th>
						</tr>
						<tr>
							<?php if($price_type_kind == 1){ ?>
								<?php for($i = 1; $i <= $price_type_cnt; $i++){ ?>
									<th class="subcon">
										<p>
											<?php echo $arrBookingKind[$arrBooking["BOOKING_MONEYKIND".$i]]; ?><br>
											<?php echo $arrBooking["BOOKING_PRICETYPE".$i]; ?>
										</p>
									</th>
								<?php }?>
							<?php } else { ?>
								<th class="subcon">
									<p>
										<?php echo $arrBookingKind[$arrBooking["BOOKING_MONEYKIND7"]]; ?><br>
										<?php echo $arrBooking["BOOKING_PRICETYPE7"]; ?>
									</p>
								</th>
								<?php if($add_member_flg){ ?>
									<th class="subcon">
										<p>
											<?php echo $arrBookingKind[$arrBooking["BOOKING_MONEYKIND8"]]; ?><br>
											<?php echo $arrBooking["BOOKING_PRICETYPE8"]; ?>
										</p>
									</th>
								<?php } ?>
							<?php } ?>
						</tr>
					</thead>
					
					<tbody>
						<?php
						foreach ($shopBooking->getCollection() as $ad) {
							$rclass = '';
							if ($ad["BOOKING_STATUS"] == 2) {
								//	キャンセル済み
								$rclass = 'class="bgLightGrey"';
							}
							
							if($ad["BOOKING_STATUS"]==1 || $ad["BOOKING_STATUS"]==5){
								$can_cancel = 1;
							}
						?>
							<tr>
								<?php  
									$k++;
									$num = ceil(($k/$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NUM_ROOM")))-1;
									$ad["BOOKINGCONT_DATE"] = $num>0?date("Y-m-d",strtotime("+$num day",strtotime($ad["BOOKINGCONT_DATE"]))):$ad["BOOKINGCONT_DATE"];
								?>
								<td <?php echo $rclass; ?>><?php echo $ad['BOOKING_DATE']; ?></td>
								<?php if($price_type_kind == 1){ ?>
									<?php for($i = 1; $i <= $price_type_cnt; $i++){ ?>
										<td <?php echo $rclass; ?>>
											<?php echo $ad["BOOKING_PRICEPERSON".$i]; ?>人<br />
											<?php echo ($ad["BOOKING_PRICEPERSON".$i] > 0)?number_format($ad["BOOKING_MONEY".$i]):0; ?>円
										</td>
									<?php }?>
								<?php } else { ?>
									<td <?php echo $rclass; ?>>
										<?php echo $ad["BOOKING_PRICEPERSON7"]; ?>組<br />
										<?php echo ($ad["BOOKING_PRICEPERSON7"] > 0)?number_format($ad["BOOKING_MONEY7"]):0; ?>円
									</td>
									<?php if($add_member_flg){ ?>
										<td <?php echo $rclass; ?>>
											<?php echo $ad["BOOKING_PRICEPERSON8"]; ?>人<br />
											<?php echo ($ad["BOOKING_PRICEPERSON8"] > 0)?number_format($ad["BOOKING_MONEY8"]):0; ?>円
										</td>
									<?php } ?>
								<?php } ?>
								<td <?php echo $rclass; ?>><?php echo number_format($ad["BOOKING_ALL_MONEY"]); ?>円</td>
								<td <?php echo $rclass; ?>>
									<?php 
									if ($ad["BOOKING_STATUS"] == 1 || $ad["BOOKING_STATUS"] == 5) {?>
										<?php
											$checked = '';
											if ($_POST["canceldata"][$ad["BOOKING_ID"]] == 1) {
												$checked = 'checked="checked"';
											}
										?>
										<input type="checkbox" id="canceldata<?php echo $ad["BOOKING_ID"]?>" name="canceldata[<?php echo $ad["BOOKING_ID"]?>]" value="1" <?php echo $checked; ?> />
									<?php }else{?>
										<p><?php echo $ad["BOOKING_DATE_CANCEL"]; ?></p>
										<p><?php echo number_format($ad["BOOKING_MONEY_CANCEL"]); ?>円</p>
									<?php }?>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
				<?php // 予約内容一覧表の作成 ▲ ?>
				<br />
			<?php }?>

			<!-- 

			<?php print create_error_msg($shopBookingcont->getErrorByKey("targetCancel"))?>

			<?php
			$dataCancel = "";
			if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG_CANCEL") == 1) {

				if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {

					if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
						$can = "";
						if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {

// 							$can = "宿泊料の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
// 							print "無不泊連絡";
							?>

							<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "targetCancel") , "無不泊連絡 : 宿泊料の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%")?><br />

							<?php
						}
						else {
						?>

							<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "targetCancel") , "無不泊連絡 : ".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円")?><br />

						<?php
// 							$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
						}
// 						$dataCancel .= "無不泊連絡 ".$can."\n";
					}

					if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {

// 						print "当日キャンセル";

						$can = "";
						if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
						?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "targetCancel") , "当日キャンセル : 宿泊料の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%")?><br />

						<?php
// 							$can = "宿泊料の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
						}
						else {
						?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "targetCancel") , "当日キャンセル : ".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円")?><br />

						<?php
// 							$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
						}
// 						$dataCancel .= "当日キャンセル ".$can."\n";
					}

					for ($i=3; $i<=7; $i++) {
						if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {
							$can = "";
							if ($shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
							?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "targetCancel") , $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで : 宿泊料の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%")?><br />

							<?php
// 								$can = "宿泊料の".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
							}
							else {
							?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "targetCancel") , $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで : ".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円")?><br />

							<?php
// 								$can = "".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
							}
// 							$dataCancel .= $shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)."～".$shopBookset->getByKey($shopBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)."日前まで".$can."\n";
						}
					}

				}

			}
			else {

				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG1") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1") != "") {
					$can = "";
					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG1") == 1) {

// 						print "無不泊連絡";
					?>

					<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $shopPlancont->getByKey($shopPlancont->getKeyValue(), "targetCancel") , "無不泊連絡 : 宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."%")?><br />

					<?php
// 						$can = "宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."%";
					}
					else {
					?>

							<?php print $inputs->radio("targetCancel1", "targetCancel", 1, $shopPlancont->getByKey($shopPlancont->getKeyValue(), "targetCancel") , "無不泊連絡 : ".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."円")?><br />

						<?php
// 						$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY1")."円";
					}
// 					$dataCancel .= "無不泊連絡 ".$can."\n";
				}

				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG2") != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2") != "") {
					$can = "";

// 					print "当日キャンセル";

					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG2") == 1) {
					?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $shopPlancont->getByKey($shopPlancont->getKeyValue(), "targetCancel") , "当日キャンセル : 宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."%")?><br />

					<?php
// 						$can = "宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."%";
					}
					else {
					?>

						<?php print $inputs->radio("targetCancel2", "targetCancel", 2, $shopPlancont->getByKey($shopPlancont->getKeyValue(), "targetCancel") , "当日キャンセル : ".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."円")?><br />

					<?php
// 						$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY2")."円";
					}
// 					$dataCancel .= "当日キャンセル ".$can."\n";
				}

				for ($i=3; $i<=6; $i++) {
					if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) != "" and $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i) != "") {
						$can = "";
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) == 1) {
						?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $shopPlancont->getByKey($shopPlancont->getKeyValue(), "targetCancel") , $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i)."～".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_TO".$i)."日前まで : 宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."%")?>

						<?php
// 							$can = "宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."%";
						}
						else {
						?>

							<?php print $inputs->radio("targetCancel".$i, "targetCancel", $i, $shopPlancont->getByKey($shopPlancont->getKeyValue(), "targetCancel") , $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i)."～".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_TO".$i)."日前まで : 宿泊料の".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."円")?>

						<?php
// 							$can = "".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i)."円";
						}
// 						$dataCancel .= $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i)."～".$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_TO".$i)."日前まで".$can."\n";
					}
				}
			}

			?>
			<?php print $inputs->radio("targetCancel0", "targetCancel", 0, $shopBookingcont->getByKey($shopBookingcont->getKeyValue(), "targetCancel") , "キャンセル料なし")?>
			 -->
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

