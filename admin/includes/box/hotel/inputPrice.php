<?php if ($hotelPriceType->getCount() != 1) {?>

		<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
			<tr>
				<th colspan="2">
					<h3>料金タイプが見つかりませんでした。</h3>
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
				<th >料金タイプ名
				</th>
				<td><?php print $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_NAME")?></td>
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

					<?php if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ==1){?>
					    <?php for ($i=1; $i<=6; $i++) {	?>
					    <tr class="setmoney_num">
					    	<td><?php print $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY".$i) ?></td>
					        <td><?php print $inputs->text("num_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sun".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_mon".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_tue".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_wed".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_thu".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_fri".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sat".$i) ,"imeDisabled circle wTime",50)?></td>
					    </tr>
					    <?php }?>
					<?php }elseif ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ==2){?>

						<?php if($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_ADDFLG") == 1){
							$moneyname_num = 7;?>

					    <?php for ($i=7; $i<=$moneyname_num; $i++) {	?>
					    <tr class="setmoney_num">
					    	<td><?php print $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND".$i) ?></td>
					        <td><?php print $inputs->text("num_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sun".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_mon".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_tue".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_wed".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_thu".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_fri".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sat".$i) ,"imeDisabled circle wTime",50)?></td>
					    </tr>

					    <?php }?>
						<!-- 追加人数用料金枠 -->
					    <?php for ($i=8; $i<=8; $i++) {	?>
					    <tr class="setmoney_num">
					    	<td><?php print "人数追加"; ?></td>
					        <td><?php print $inputs->text("num_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sun".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_mon".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_tue".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_wed".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_thu".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_fri".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sat".$i) ,"imeDisabled circle wTime",50)?></td>
					    </tr>

					    <?php }
						}elseif($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_ADDFLG") == 2){
							$moneyname_num = 7;?>

					    <?php for ($i=7; $i<=$moneyname_num; $i++) {	?>
					    <tr class="setmoney_num">
					    	<td><?php print $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND".$i) ?></td>
					        <td><?php print $inputs->text("num_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sun".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_mon".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_tue".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_wed".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_thu".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_fri".$i) ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("num_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "num_sat".$i) ,"imeDisabled circle wTime",50)?></td>
					    </tr>

					    <?php }?>
					  <?php }?>
					<?php }?>




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
					    <?php  for ($i=1; $i<=1; $i++) {?>
					    <!-- <tr>
					    	<td>ﾎﾟｲﾝﾄ率</td>
					        <td><?php print $inputs->text("point_sun".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sun".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sun".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_mon".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_mon".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_mon".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_tue".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_tue".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_tue".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_wed".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_wed".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_wed".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_thu".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_thu".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_thu".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_fri".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_fri".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_fri".$i):1 ,"imeDisabled circle wTime",50)?></td>
					        <td><?php print $inputs->text("point_sat".$i, $hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sat".$i)?$hotelPayTarget->getByKey($hotelPayTarget->getKeyValue(), "point_sat".$i):1 ,"imeDisabled circle wTime",50)?></td>
					    </tr> -->
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
					<?php // 料金タイプの種別で分岐 ?>
					<?php if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ==1){?>

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

					<?php }elseif ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ==2){?>

						<?php // グループ単位の追加人数フラグで分岐 ?>
						<?php if($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_ADDFLG") == 1){?>

							var i;
							for (i = 7; i <= 8; i = i +1){
								$('.weekMoney'+i+'0').val(""+$('#num_sun'+i+'').val());
							}
							for (i = 7; i <= 8; i = i +1){
								$('.weekMoney'+i+'1').val(""+$('#num_mon'+i+'').val());
							}
							for (i = 7; i <= 8; i = i +1){
								$('.weekMoney'+i+'2').val(""+$('#num_tue'+i+'').val());
							}
							for (i = 7; i <= 8; i = i +1){
								$('.weekMoney'+i+'3').val(""+$('#num_wed'+i+'').val());
							}
							for (i = 7; i <= 8; i = i +1){
								$('.weekMoney'+i+'4').val(""+$('#num_thu'+i+'').val());
							}
							for (i = 7; i <= 8; i = i +1){
								$('.weekMoney'+i+'5').val(""+$('#num_fri'+i+'').val());
							}
							for (i = 7; i <= 8; i = i +1){
								$('.weekMoney'+i+'6').val(""+$('#num_sat'+i+'').val());
							}

					    <?php }elseif($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_ADDFLG") == 2){?>

							var i;
							for (i = 7; i <= 7; i = i +1){
								$('.weekMoney'+i+'0').val(""+$('#num_sun'+i+'').val());
							}
							for (i = 7; i <= 7; i = i +1){
								$('.weekMoney'+i+'1').val(""+$('#num_mon'+i+'').val());
							}
							for (i = 7; i <= 7; i = i +1){
								$('.weekMoney'+i+'2').val(""+$('#num_tue'+i+'').val());
							}
							for (i = 7; i <= 7; i = i +1){
								$('.weekMoney'+i+'3').val(""+$('#num_wed'+i+'').val());
							}
							for (i = 7; i <= 7; i = i +1){
								$('.weekMoney'+i+'4').val(""+$('#num_thu'+i+'').val());
							}
							for (i = 7; i <= 7; i = i +1){
								$('.weekMoney'+i+'5').val(""+$('#num_fri'+i+'').val());
							}
							for (i = 7; i <= 7; i = i +1){
								$('.weekMoney'+i+'6').val(""+$('#num_sat'+i+'').val());
							}

					  <?php }?>
					<?php }?>


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


						$('.weekNum0').val(""+$('#point_sun1').val());
						$('.weekNum1').val(""+$('#point_mon1').val());
						$('.weekNum2').val(""+$('#point_tue1').val());
						$('.weekNum3').val(""+$('#point_wed1').val());
						$('.weekNum4').val(""+$('#point_thu1').val());
						$('.weekNum5').val(""+$('#point_fri1').val());
						$('.weekNum6').val(""+$('#point_sat1').val());
						*/?>
					}
				    </script>



					<?php

					$from = cmDateDivide(date("Y-m-d"));
					$firstday = date("Y-m-01");
					$after_year = date("Y-m-d",strtotime("+12 month",strtotime($firstday)));
					$to = cmDateDivide(date("Y-m-d",strtotime("-1 day", strtotime($after_year))));
				//	print $to;

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
										print cmCalendar($y, $m, $from["d"], $to["d"], $hotelPayTarget, $hotelPriceType, "", $only);
									}
									else {
										print cmCalendar($y, $m, $from["d"], "", $hotelPayTarget, $hotelPriceType, "", $only);
									}
								}
								elseif ($to["y"] == $y and $to["m"] == $m) {
									print cmCalendar($y, $m, "", $to["d"], $hotelPayTarget, $hotelPriceType, "", $only);
								}
								else {
									print cmCalendar($y, $m, "", "", $hotelPayTarget, $hotelPriceType, "", $only);
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
										print cmCalendar($y, $m, $from["d"], $to["d"], $hotelPayTarget, $hotelPriceType, "", $only);
									}
									else {
										print cmCalendar($y, $m, $from["d"], "", $hotelPayTarget, $hotelPriceType, "", $only);
									}
								}
								elseif ($to["y"] == $y and $to["m"] == $m) {
									print cmCalendar($y, $m, "", $to["d"], $hotelPayTarget, $hotelPriceType, "", $only);
								}
								else {
									print cmCalendar($y, $m, "", "", $hotelPayTarget, $hotelPriceType, "", $only);
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

		<ul class="buttons">
			<li><?=$inputs->submit("","regist","料金設定を保存する", "circle")?></li>
		</ul>

		<?php print $inputs->hidden("SHOP_PRICETYPE_ID", $hotelPriceType->getKeyValue())?>

	<?php }?>