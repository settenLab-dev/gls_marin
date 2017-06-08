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
// 									$k++;
// 									$num = ceil(($k/$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NUM_ROOM")))-1;
// 									$ad["BOOKINGCONT_DATE"] = $num>0?date("Y-m-d",strtotime("+$num day",strtotime($ad["BOOKINGCONT_DATE"]))):$ad["BOOKINGCONT_DATE"];
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
			<p>
				※予約をキャンセルする場合は、必ずキャンセルするプランの「キャンセル」チェックボックスにチェックを入れ「キャンセル確認」ボタンを押してください。<br/>
				※プランを変更する場合は予約を取り直してください。
			</p>
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center" class="bt-td">
						<?php
							if($can_cancel){
								print $inputs->submit("","cancelconfirm","キャンセル確認", "circle");
							}
						?>
					</td>
				</tr>
			</table>
			<br/><br/>
			
			<?php if ($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_STATUS") == 5 || $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") != "") { ?>
				リクエスト回答
				<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
					<tr>
						<th width="160" valign="top">
							<p>予約リクエスト回答</p>
						</th>
						<td align="left">
							<?php 
							if($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") == 1){
								print "予約可能";
							}
							else if($shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") == 2){
								print "受入れ不可";
							}
							else{
								print "回答待ち";
							}
							?>
							<?php //print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",1,$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") ,"予約可能") ?>
							&nbsp; <?php //print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",2,$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST") ,"受入れ不可") ?>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>ホテルからのリクエスト回答</p>
						</th>
						<td align="left">
							<?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER") ?>
						</td>
					</tr>
				</table>
			<?php }?>
			<br/>
			<div><a href="javascript:history.go(-1);">予約情報一覧に戻る</a></div><br/>
			
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
				<table cellspacing="0" cellpadding="5" class="tblInput edit" id="sortList" width="100%">
					<tr>
						<th width="160" valign="top">
							<p>予約番号</p>
						</th>
						<td align="left">
							<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ID")?>　　　[申込時間：<?=$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE_START")?>]</p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>催行会社名</p>
						</th>
						<td align="left">
							<p>
								<?php
									$shopTarget = new shop($dbMaster);
									$shopTarget->select($shopBooking->getByKey($shopBooking->getKeyValue(), "COMPANY_ID"));
									$shop_name  = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_NAME");
									$shop_tel   = $shopTarget->getByKey($shopTarget->getKeyValue(), "SHOP_TEL");
								?>
								<a href="<?php echo URL_PUBLIC; ?>shop-detail.html?cid=<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "COMPANY_ID"); ?>"><?php echo $shop_name; ?></a>(TEL：<?php echo $shop_tel; ?>)
							</p>
						</td>
					</tr>
					<!--<tr>
					<th width="160" valign="top">
						<p>予約時間</p>
					</th>
					<td align="left">
						<p><?=$shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_DATE_START")?></p>
					</td>
					</tr>-->
					<tr>
						<th width="160" valign="top">
							<p>催行日・コース</p>
						</th>
						<td align="left">
							<p><?php echo $ad['BOOKING_DATE']; ?>&nbsp;&nbsp;<?php echo $ad["BOOKING_MEET_TIME"]; ?></p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>集合場所</p>
						</th>
						<td align="left">
							<p><?php echo $ad["BOOKING_MEET_PLACE"]; ?></p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>プラン名</p>
						</th>
						<td align="left">
							<p><?php echo $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_NAME"); ?></p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>合計料金</p>
						</th>
						<td align="left">
							<p><?php echo number_format($ad["BOOKING_ALL_MONEY"]); ?> 円</p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>施設からの質問への回答</p>
						</th>
						<td align="left">
							<p><?php echo nl2br($ad["BOOKING_ANSWER"]); ?></p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>お客さまからのメッセージ</p>
						</th>
						<td align="left">
							<p><?php echo nl2br($ad["BOOKING_DEMAND"]); ?></p>
						</td>
					</tr>	
					<tr>
						<th width="160" valign="top">
							<p>予約変更の締切</p>
						</th>
						<td align="left">
							<p>
								<?php
									$arHourData = cmShopHourSelect();
									$arMinData = cmShopMinSelect();
									
									$plan_acc_day  = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ACC_DAY");
									$plan_acc_hour = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ACC_HOUR");
									$plan_acc_min  = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ACC_MIN");
								?>
								<?php echo $plan_acc_day; ?>日前&nbsp;<?php echo $arHourData[$plan_acc_hour].":".$arMinData[$plan_acc_min]; ?>まで
							</p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>キャンセルの締切</p>
						</th>
						<td align="left">
							<p>
								<?php
									$plan_can_day  = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_DAY");
									$plan_can_hour = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_HOUR");
									$plan_can_min  = $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_MIN");
								?>
								<?php echo $plan_can_day; ?>日前&nbsp;<?php echo $arHourData[$plan_can_hour].":".$arMinData[$plan_can_min]; ?>まで
							</p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>宿泊者名</p>
						</th>
						<td align="left">
							<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME1"); ?>
							<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_NAME2"); ?>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>住所</p>
						</th>
						<td align="left">
							<?php
								$arPref = cmGetAllPrefName();
								$booking_pref_id = $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_PREF_ID");
							?>
							<?php echo $arPref[$booking_pref_id]; ?>&nbsp;
							<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_CITY"); ?>&nbsp;
							<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS"); ?>&nbsp;
							<?php echo $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_BUILD"); ?>
							<?php //print $inputs->text("BOOKING_CITY", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_CITY") ," circle wNum",30)?> <?php 
							//print $inputs->text("BOOKING_BUILD", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_BUILD") ,"imeActive circle wNum",30)?> <?php 
							//print $inputs->text("BOOKING_ADDRESS", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_ADDRESS") ,"imeActive circle wNum",30)?>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>電話番号</p>
						</th>
						<td align="left">
							<p><?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_TEL");
							//print $inputs->text("BOOKING_TEL", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_TEL") ,"imeActive circle",20)?></p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>メールアドレス</p>
						</th>
						<td align="left">
							<p><?php print $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS");
							//print $inputs->text("BOOKING_MAILADDRESS", $shopBooking->getByKey($shopBooking->getKeyValue(), "BOOKING_MAILADDRESS") ,"imeActive circle",20)?></p>
						</td>
					</tr>
					<tr>
						<th width="160" valign="top">
							<p>プラン内容</p>
						</th>
						<td align="left">
							<p>
								<?php echo nl2br($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DISCRIPTION")); ?>
							</p>
						</td>
					</tr>
				</table>
				<br/>
				<!--<table cellspacing="0" cellpadding="5" class="inner" width="100%">
					<tr>
						<td align="center" class="bt-td">
							<?=$inputs->submit("","bookingConfirm","予約変更する", "circle")?>
						</td>
					</tr>
				</table> -->
			</form>
			<br/>
			<div><a href="javascript:history.go(-1);">予約情報一覧に戻る</a></div>