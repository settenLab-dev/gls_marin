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
					<h3>在庫タイプが見つかりませんでした。</h3>
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
				<th >在庫タイプ名
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
							<th valign="top" colspan="2">小人(A)</th>
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
							<th valign="top" colspan="2">小人(B)</th>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA12"))?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA121", "HOTELPAY_PS_DATA12", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA12") ," あり")?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA122", "HOTELPAY_PS_DATA12", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA12") ," なし")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA22"))?>
								<?=$inputs->checkbox("HOTELPAY_PS_DATA22","HOTELPAY_PS_DATA22",1,$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA22")," 数える", "")?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA32"))?>
								<?php print $inputs->text("HOTELPAY_PS_DATA32", $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA32") ,"imeDisabled circle wTime",50)?>
							</td>
							<td>
								<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_PS_DATA42"))?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA421", "HOTELPAY_PS_DATA42", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA42") ," %")?>
								<?php print $inputs->radio("HOTELPAY_PS_DATA422", "HOTELPAY_PS_DATA42", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA42") ," 円")?><br />
								<?php print $inputs->radio("HOTELPAY_PS_DATA423", "HOTELPAY_PS_DATA42", 3, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_PS_DATA42") ," 円引")?>
							</td>
						</tr>
						<tr>
							<th valign="top" rowspan="4">幼児</th>
							<th valign="top" >(A)</th>
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
							<th valign="top" >(B)</th>
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
							<th valign="top" >(C)</th>
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
							<th valign="top" >(D)</th>
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
				<th >料金設定 <span class="colorRed">※</span></th>
				<td>
					<?php print create_error_msg($hotelPayTarget->getErrorByKey("HOTELPAY_MONEY_FLG"))?>
					<?php print $inputs->radio("HOTELPAY_MONEY_FLG1", "HOTELPAY_MONEY_FLG", 1, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_MONEY_FLG") ," 人数あたりの料金")?>
					<?php print $inputs->radio("HOTELPAY_MONEY_FLG2", "HOTELPAY_MONEY_FLG", 2, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "HOTELPAY_MONEY_FLG") ," グループでの料金")?>

					<script type="text/javascript">
					$(document).ready(function(){
						$("#HOTELPLAN_ID").change(function () {
							$('.roomboxset').addClass('dspNon');
							$('#roombox'+$(this).val()).removeClass('dspNon');
							$("input[name='ROOM_ID']").attr("checked", false);
							urlchange();
						});
						$("input[name='HOTELPAY_MONEY_FLG']").change(function () {
							datachange();
						});
						datachange();
					});
					function datachange() {
						<?php /*
						if ($("input[name='HOTELPAY_MONEY_FLG']:checked").val() == 1) {
							$('.setmoney_room').addClass('dspNon');
							$('.setmoney_num').removeClass('dspNon');
						}
						if ($("input[name='HOTELPAY_MONEY_FLG']:checked").val() == 2) {
							$('.setmoney_room').removeClass('dspNon');
							$('.setmoney_num').addClass('dspNon');
						}
						*/?>
					}
					</script>

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
					<p class="colorRed">※料金を設定しない日は、「x（小文字のエックス）」を入力して下さい。</p>
					<br />

					<table cellspacing="10" cellpadding="0" border="0" class="calendar">
				    <caption>一括入力</caption>
					    <tr>
					    	<th></th>
					        <th class="red" style="background-color: #ffc6c6;">日</th>
					        <th>月</th>
					        <th>火</th>
					        <th>水</th>
					        <th>木</th>
					        <th>金</th>
					        <th class="blue">土</th>
					    </tr>
					    <?php for ($i=1; $i<=6; $i++) {
					    	if ($i>$hotelRoomTrget->getByKey($hotelRoomTrget->getKeyValue(), "ROOM_CAPACITY_TO")) {
					    	?>
					    <tr class="setmoney_num">
					    	<td><?php print $i?>名</td>
					        <td><?php print $inputs->text("num_sun".$i, 'x' ,"imeDisabled circle wTime",50,"readonly")?></td>
					        <td><?php print $inputs->text("num_mon".$i, 'x' ,"imeDisabled circle wTime",50,"readonly")?></td>
					        <td><?php print $inputs->text("num_tue".$i, 'x' ,"imeDisabled circle wTime",50,"readonly")?></td>
					        <td><?php print $inputs->text("num_wed".$i, 'x' ,"imeDisabled circle wTime",50,"readonly")?></td>
					        <td><?php print $inputs->text("num_thu".$i, 'x' ,"imeDisabled circle wTime",50,"readonly")?></td>
					        <td><?php print $inputs->text("num_fri".$i, 'x' ,"imeDisabled circle wTime",50,"readonly")?></td>
					        <td><?php print $inputs->text("num_sat".$i, 'x' ,"imeDisabled circle wTime",50,"readonly")?></td>
					    </tr>
					    <?php }else {?>
					    <tr class="setmoney_num">
					    	<td><?php print $i?>名</td>
					        <td><?php print $inputs->text("num_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sun".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_mon".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_tue".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_wed".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_thu".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_fri".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sat".$i) ,"imeDisabled circle wTime",50)?></td>
					    </tr>
					    <?php }}?>
					    <?php /*for ($i=1; $i<=1; $i++) {?>
					    <tr class="setmoney_room">
					    	<td>部屋金額</td>
					        <td><?php print $inputs->text("room_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "room_sun".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("room_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "room_mon".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("room_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "room_tue".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("room_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "room_wed".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("room_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "room_thu".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("room_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "room_fri".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("room_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "room_sat".$i) ,"imeDisabled circle wTime",50)?></td>
					    </tr>
					    <?php }*/?>
					    <?php for ($i=1; $i<=1; $i++) {?>
					    <tr>
					    	<td>ﾎﾟｲﾝﾄ率</td>
					        <td><?php print $inputs->text("point_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sun".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sun".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_mon".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_mon".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_tue".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_tue".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_wed".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_wed".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_thu".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_thu".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_fri".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_fri".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sat".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sat".$i):1 ,"imeDisabled circle wTime",50)?></td>
					    </tr>
					    <?php }?>
					    <tr>
					    	<td colspan="7" align="center">
							    <input type="button" value="反映する" onclick="reflection()" class="circle" />
					    	</td>
					    </tr>
				    </table>
				    <script type="text/javascript">
					function reflection() {
						<?php /*
						if ($("input[name='HOTELPAY_MONEY_FLG']:checked").val() == 1) {
						*/?>
							var i;
							for (i = 1; i <= 6; i = i +1){
								$('.weekMoney'+i+'0').val(""+$('#num_sun'+i+'').val());
							}
							for (i = 1; i <= 6; i = i +1){
								$('.weekMoney'+i+'1').val(""+$('#num_mon'+i+'').val());
							}
							for (i = 1; i <= 6; i = i +1){
								$('.weekMoney'+i+'2').val(""+$('#num_tue'+i+'').val());
							}
							for (i = 1; i <= 6; i = i +1){
								$('.weekMoney'+i+'3').val(""+$('#num_wed'+i+'').val());
							}
							for (i = 1; i <= 6; i = i +1){
								$('.weekMoney'+i+'4').val(""+$('#num_thu'+i+'').val());
							}
							for (i = 1; i <= 6; i = i +1){
								$('.weekMoney'+i+'5').val(""+$('#num_fri'+i+'').val());
							}
							for (i = 1; i <= 6; i = i +1){
								$('.weekMoney'+i+'6').val(""+$('#num_sat'+i+'').val());
							}
						<?php /*
						}
						if ($("input[name='HOTELPAY_MONEY_FLG']:checked").val() == 2) {
							$('.weekOver0').val(""+$('#room_sun1').val());
							$('.weekOver1').val(""+$('#room_mon1').val());
							$('.weekOver2').val(""+$('#room_tue1').val());
							$('.weekOver3').val(""+$('#room_wed1').val());
							$('.weekOver4').val(""+$('#room_thu1').val());
							$('.weekOver5').val(""+$('#room_fri1').val());
							$('.weekOver6').val(""+$('#room_sat1').val());
						}
						*/?>

						$('.weekNum0').val(""+$('#point_sun1').val());
						$('.weekNum1').val(""+$('#point_mon1').val());
						$('.weekNum2').val(""+$('#point_tue1').val());
						$('.weekNum3').val(""+$('#point_wed1').val());
						$('.weekNum4').val(""+$('#point_thu1').val());
						$('.weekNum5').val(""+$('#point_fri1').val());
						$('.weekNum6').val(""+$('#point_sat1').val());
					}
				    </script>



					<?php

					$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
					$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));
// 					$from=array('y'=>2013,'m'=>'04','d'=>'02');
// 					$to=array('y'=>2015,'m'=>'01','d'=>'02');
					$cut = intval($to['y'])-intval($from['y']);
					for ($y=$from["y"]; $y<=$to["y"]; $y++) {
						if($from['m']>$to['m']){
							$ori_to_m = $to['m'];
							$ori_to_d = $to['d'];
							$to['m'] = 12;
							$to['d'] = 31;
							for ($m=$from["m"]; $m<=$to["m"]; $m++) {

								if ($from["y"] == $y and $from["m"] == $m) {
									if ($from["y"] == $to["y"] and $from["m"] == $to["m"]) {
										//	最初の月でそのまま終了の場合
										print cmCalendar($y, $m, $from["d"], $to["d"], $hotelPayTarget, "", $only);
									}
									else {
										print cmCalendar($y, $m, $from["d"], "", $hotelPayTarget, "", $only);
									}
								}
								elseif ($to["y"] == $y and $to["m"] == $m) {
									print cmCalendar($y, $m, "", $to["d"], $hotelPayTarget, "", $only);
								}
								else {
									print cmCalendar($y, $m, "", "", $hotelPayTarget, "", $only);
								}
									
							}
							$from['m']=1;
							$from['d']=1;
							$cut?$cut--:'';
							if ($cut==0) {
								$to['m']=$ori_to_m;
								$to['d']=$ori_to_d;
							}
							//output_cal($y,$from, $to);
						}else{
							if($cut>0){
								$ori_to_m = $ori_to_m?$ori_to_m:$to['m'];
								$ori_to_d = $ori_to_m?$ori_to_m:$to['d'];
								$to['m'] = 12;
								$to['d'] = 31;
							}
							for ($m=$from["m"]; $m<=$to["m"]; $m++) {

								if ($from["y"] == $y and $from["m"] == $m) {
									if ($from["y"] == $to["y"] and $from["m"] == $to["m"]) {
										//	最初の月でそのまま終了の場合
										print cmCalendar($y, $m, $from["d"], $to["d"], $hotelPayTarget, "", $only);
									}
									else {
										print cmCalendar($y, $m, $from["d"], "", $hotelPayTarget, "", $only);
									}
								}
								elseif ($to["y"] == $y and $to["m"] == $m) {
									print cmCalendar($y, $m, "", $to["d"], $hotelPayTarget, "", $only);
								}
								else {
									print cmCalendar($y, $m, "", "", $hotelPayTarget, "", $only);
								}
									
							}
							if($cut>0){
								$from['m']=1;
								$from['d']=1;
								$cut?$cut--:'';
								if ($cut==0) {
									$to['m']=$ori_to_m;
									$to['d']=$ori_to_d;
								}
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