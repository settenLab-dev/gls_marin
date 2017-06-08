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

