<?php if ($hotelPlan->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelPlan->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
		<th colspan="7">
			<h3>
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="hotelPlanEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しいプランを登録","circle ")?></a>
			<a href="hotelPlanOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","プランを並び替える","circle ")?></a>
			<?php }?>
			</h3>
		</th>
	</tr>
		<tr>
			<th width="20"><p>ID</p></th>
			<th><p>プラン名</p></th>
			<th><p>掲載期間</p></th>
			<th><p>販売期間</p></th>
			<th width="15"><p>編集</p></th>
			<th width="15"><p>複製</p></th>
			<th width="230"><p>料金設定</p></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($hotelPlan->getCount() > 0) {?>
			<?php foreach ($hotelPlan->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["HOTELPLAN_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_ID"]?></td>
			<td <?=$rclass?>>
				<?php
				if ($ad["HOTELPLAN_FLG_DAYUSE"] == 2) {
					print '<p class="colorRed">[日帰り]</p>';
				}
				?>
			<?=$ad["HOTELPLAN_NAME"]?>
			</td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_DATE_POST_FROM"]?><br />～<?=$ad["HOTELPLAN_DATE_POST_TO"]?></td>
			<td <?=$rclass?>><?=$ad["HOTELPLAN_DATE_SALE_FROM"]?><br />～<?=$ad["HOTELPLAN_DATE_SALE_TO"]?></td>
			
			<td <?=$rclass?> align="center">
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="hotelPlanEdit.html?id=<?=$ad["HOTELPLAN_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a>
			<?php }?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="hotelPlanCopy.html?id=<?=$ad["HOTELPLAN_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","複製","circle")?></a>
			<?php }?>
			</td>
			<td <?=$rclass?> align="center">
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3) {?>

				<?php
				$arRoom = array();
				$arTemp = explode(":", $ad["HOTELPLAN_ROOM_LIST"]);
				if (count($arTemp) > 0) {
					foreach ($arTemp as $data) {
						if ($data != "") {
							$arRoom[$data] = $data;
						}
					}
				}
				?>
				<?php if ($hotelRoom->getCount() >0) {?>
				<table class="inner">
					<?php
					foreach ($hotelRoom->getCollection() as $d) {
						if ($arRoom[$d["ROOM_ID"]] == "") {
							continue;
						}
					?>
					<tr>
						<th><?php print $d["ROOM_NAME"]?></th>
						<td>
							<?php
							$flg = false;
// 							$payCheck = $hotelPayCheck->getCollectionByKey($ad["HOTELPLAN_ID"]);
							if ($hotelPayCheck->getCount() > 0) {
								foreach ($hotelPayCheck->getCollection() as $a) {
									if ($ad["HOTELPLAN_ID"] == $a["HOTELPLAN_ID"] and $d["ROOM_ID"] == $a["ROOM_ID"]) {
										$flg = true;
										break;
									}
								}
							}
							?>
							<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
							<?php if ($flg) {?>
								<a href="hotelPayEdit.html?id=<?=$ad["HOTELPLAN_ID"]?>&key=<?php print $d["ROOM_ID"]?>" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","料金設定","circle")?></a>
								<?php /*
								<?=$inputs->submit("","search","料金設定old", "circle")?>
								*/?>
							<?php }else{?>
								<a href="hotelPayEdit.html?id=<?=$ad["HOTELPLAN_ID"]?>&key=<?php print $d["ROOM_ID"]?>" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","料金設定","circle bgOrange")?></a>
								<?php /*
								<?=$inputs->submit("","search","料金設定old", "circle bgOrange")?>
								*/?>
								<p class="colorRed">※未設定</p>
							<?php }?>
							<?php print $inputs->hidden("HOTELPLAN_ID", $ad["HOTELPLAN_ID"])?>
							<?php print $inputs->hidden("ROOM_ID", $d["ROOM_ID"])?>
							</form>
						
						<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
						<a href="<?=URL_PUBLIC?>plan-detail-preview.html?id=<?=$ad["HOTELPLAN_ID"]?>&rid=<?=$d["ROOM_ID"]?>&cid=<?=$ad["COMPANY_ID"]?>" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","プレビューする","circle")?></a>
						<?php }?>
						
						<?php 
						if ($ad["HOTELPLAN_FLG_SEACRET"] == 1) {?>
						<a href="hotelSecretURL.html?id=<?=$ad["HOTELPLAN_ID"]?>&rid=<?=$d["ROOM_ID"]?>&cid=<?=$ad["COMPANY_ID"]?>" class="popup" rel="windowCallUnload3">
						<?=$inputs->button("","","プランURL取得","circle")?></a>
						<?php }?>
						
						</td>
					</tr>
					<?php }?>
				</table>
				<?php }?>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />

<?php if ($collection->getByKey($collection->getKeyValue(), "search") or $collection->getByKey($collection->getKeyValue(), "regist")) {?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">

	<?php if ($hotelPlanTarget->getCount() != 1) {?>

		<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
			<tr>
				<th colspan="2">
					<h3>プランが見つかりませんでした。</h3>
				</th>
			</tr>
		</table>

	<?php }elseif ($hotelRoomTrget->getCount() != 1) {?>
		<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
			<tr>
				<th colspan="2">
					<h3>部屋タイプが見つかりませんでした。</h3>
				</th>
			</tr>
		</table>
	<?php }else {?>

		<?php if ($hotelPayTarget->getErrorCount() > 0) {?>
		<?php print create_error_caption($hotelPayTarget->getError())?>
		<?php
		$ar = $hotelPayTarget->getErrorByKey("calencer");
			if (count($ar) > 0) {
				foreach ($ar as $d) {
					print create_error_msg($d);
				}
			}
		?>
		<?php }
// 		print_r($hotelPayTarget->getError());
		?>
		<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
			<tr>
				<th width="120">プラン名
				</th>
				<td><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_NAME")?></td>
			</tr>
			<tr>
				<th >部屋タイプ名
				</th>
				<td><?php print $hotelRoomTrget->getByKey($hotelRoomTrget->getKeyValue(), "ROOM_NAME")?></td>
			</tr>
			<tr>
				<th >売り出し期間
				</th>
				<td><?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM")?> ～ <?php print $hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO")?></td>
			</tr>
			<tr>
				<th >子供料金の設定 <span class="colorRed">※</span></th>
				<td>
					<table class="inner" cellspacing="5" width="100%">
						<tr>
							<th valign="top" colspan="2"></th>
							<th valign="top" >受け入れ</th>
							<th valign="top" >大人料金概算時<br />に数える</th>
							<th valign="top" >値段・率</th>
							<th valign="top" >単位</th>
						</tr>
						<tr>
							<th valign="top" colspan="2">小学生</th>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA1"))?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA11", "HOTELPAY_PS_DATA1", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA1") ," あり")?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA12", "HOTELPAY_PS_DATA1", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA1") ," なし")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA2"))?>
								<?=$inputs->checkbox("HOTELPAY_PS_DATA2","HOTELPAY_PS_DATA2",1,$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA2")," 数える", "")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA3"))?>
								<?php print $inputs->text("HOTELPAY_PS_DATA3", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA3") ,"imeDisabled circle wTime",50)?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA4"))?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA41", "HOTELPAY_PS_DATA4", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA4") ," %")?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA42", "HOTELPAY_PS_DATA4", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA4") ," 円")?><br />
								<?php print $inputs->radio("HOTELPAY_PS_DATA43", "HOTELPAY_PS_DATA4", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA4") ," 円引")?>
							</td>
						</tr>
						<tr>
							<th valign="top" rowspan="4">幼児</th>
							<th valign="top" >食事・<br />布団あり</th>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA1"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA11", "HOTELPAY_BB_DATA1", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA1") ," あり")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA12", "HOTELPAY_BB_DATA1", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA1") ," なし")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA2"))?>
								<?=$inputs->checkbox("HOTELPAY_BB_DATA2","HOTELPAY_BB_DATA2",1,$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA2")," 数える", "")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA3"))?>
								<?php print $inputs->text("HOTELPAY_BB_DATA3", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA3") ,"imeDisabled circle wTime",50)?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA4"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA41", "HOTELPAY_BB_DATA4", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA4") ," %")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA42", "HOTELPAY_BB_DATA4", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA4") ," 円")?><br />
								<?php print $inputs->radio("HOTELPAY_BB_DATA43", "HOTELPAY_BB_DATA4", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA4") ," 円引")?>
							</td>
						</tr>
						<tr>
							<th valign="top" >食事あり</th>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA5"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA51", "HOTELPAY_BB_DATA5", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA5") ," あり")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA52", "HOTELPAY_BB_DATA5", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA5") ," なし")?>
							</td>
							<td>-
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA6"))?>
								<?php print $inputs->text("HOTELPAY_BB_DATA6", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA6") ,"imeDisabled circle wTime",50)?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA7"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA71", "HOTELPAY_BB_DATA7", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA7") ," %")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA72", "HOTELPAY_BB_DATA7", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA7") ," 円")?><br />
								<?php print $inputs->radio("HOTELPAY_BB_DATA73", "HOTELPAY_BB_DATA7", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA7") ," 円引")?>
							</td>
						</tr>
						<tr>
							<th valign="top" >布団あり</th>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA8"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA81", "HOTELPAY_BB_DATA8", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA8") ," あり")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA82", "HOTELPAY_BB_DATA8", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA8") ," なし")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA9"))?>
								<?=$inputs->checkbox("HOTELPAY_BB_DATA9","HOTELPAY_BB_DATA9",1,$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA9")," 数える", "")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA10"))?>
								<?php print $inputs->text("HOTELPAY_BB_DATA10", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA10") ,"imeDisabled circle wTime",50)?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA11"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA111", "HOTELPAY_BB_DATA11", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA11") ," %")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA112", "HOTELPAY_BB_DATA11", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA11") ," 円")?><br />
								<?php print $inputs->radio("HOTELPAY_BB_DATA113", "HOTELPAY_BB_DATA11", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA11") ," 円引")?>
							</td>
						</tr>
						<tr>
							<th valign="top" >食事・<br />布団なし</th>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA12"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA121", "HOTELPAY_BB_DATA12", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA12") ," あり")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA122", "HOTELPAY_BB_DATA12", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA12") ," なし")?>
							</td>
							<td>-
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA13"))?>
								<?php print $inputs->text("HOTELPAY_BB_DATA13", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA13") ,"imeDisabled circle wTime",50)?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA14"))?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA141", "HOTELPAY_BB_DATA14", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA14") ," %")?>
								<?php print $inputs->radio("HOTELPAY_BB_DATA142", "HOTELPAY_BB_DATA14", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA14") ," 円")?><br />
								<?php print $inputs->radio("HOTELPAY_BB_DATA143", "HOTELPAY_BB_DATA14", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_BB_DATA14") ," 円引")?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th >サービス料 <span class="colorRed">※</span></th>
				<td>
					<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_SERVICE_FLG"))?>
					<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_BB_DATA13"))?>
					<?php print $inputs->radio("HOTELPAY_SERVICE_FLG1", "HOTELPAY_SERVICE_FLG", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE_FLG") ," サ込")?>
					<?php print $inputs->radio("HOTELPAY_SERVICE_FLG2", "HOTELPAY_SERVICE_FLG", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE_FLG") ," サ別")?>
					<?php print $inputs->text("HOTELPAY_SERVICE", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_SERVICE") ,"imeDisabled circle wTime",50)?> %
				</td>
			</tr>
			<tr>
				<th >料金特記事項</th>
				<td>
					<?php print create_error_msg($hotelPay->getErrorByKey("HOTELPAY_REMARKS"))?>
					<?=$inputs->textarea("HOTELPAY_REMARKS", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_REMARKS"), "imeActive circle",30,4)?>
				</td>
			</tr>
			<tr>
				<td align="left" colspan="2">

					<?php

					$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
					$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));

					for ($y=$from["y"]; $y<=$to["y"]; $y++) {
						for ($m=$from["m"]; $m<=$to["m"]; $m++) {

							if ($from["y"] == $y and $from["m"] == $m) {
								print cmCalendar($y, $m, $from["d"], "", $hotelPayTarget, "", $only);
							}
							elseif ($to["y"] == $y and $to["m"] == $m) {
								print cmCalendar($y, $m, "", $to["d"], $hotelPayTarget, "", $only);
							}
							else {
								print cmCalendar($y, $m, "", "", $hotelPayTarget, "", $only);
							}

						}
					}
					?>
				</td>
			</tr>
		</table>
		<br />

		<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
		<ul class="buttons">
			<li><?=$inputs->submit("","regist","料金設定を保存する", "circle")?></li>
		</ul>
		<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>

		<?php print $inputs->hidden("HOTELPLAN_ID", $hotelPlanTarget->getKeyValue())?>
		<?php print $inputs->hidden("ROOM_ID", $hotelRoomTrget->getKeyValue())?>

	<?php }?>
</form>
<?php }?>

