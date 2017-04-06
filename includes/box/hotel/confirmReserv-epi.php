<section>
                <h2>◆宿泊の内容の確認</h2>
                <table class="style1">
                <tbody>
                    <tr><th>ホテル名</th><td><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME")?></td></tr>
                    <tr><th>プラン名</th><td><?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME")?></td></tr>
                    <tr><th>部屋名</th><td><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></td></tr>
                    <tr><th>宿泊日</th><td><?php print $_POST['target_date']?$_POST['target_date']:$hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE")?></td></tr>
                    <tr><th class="bg1">チェックイン時間</th>
                    	<td class="bg1">
                    		<?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CHECKIN");?>
                    		<?php print $inputs->hidden("BOOKING_CHECKIN", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CHECKIN"));?>
                    	</td>
                    </tr>
                    <tr><th>泊&emsp;数</th><td><?php print $collection->getByKey($collection->getKeyValue(), "night_number")?>泊</td></tr>
                </tbody>
                </table>

                <table class="style2">
                <tbody>
                    <tr>
                        <th>部屋数</th>
                        <td align="left" style="text-align: left;"><?php print $collection->getByKey($collection->getKeyValue(), "room_number")?>室</td>
                    </tr>
                </tbody>
               </table>

               <table class="style2">
                <tbody>
                    <tr class="bg2">
                        <th class="bg3"></th>
                        <td></td><td class="normal">大人</td><td class="normal">男性</td><td class="normal">女性</td><td class="normal">小学生<br><span class="small">低学年<br></span></td><td class="normal">小学生<br><span class="small">高学年<br></span></td><td class="normal">幼児<br><span class="small">食事・布団あり</span></td><td class="normal">幼児<br><span class="small">食事あり</span></td><td class="normal">幼児<br><span class="small">布団あり</span></td><td class="normal">幼児<br><span class="small">食事・布団なし</span></td>
                    </tr>
                    <?php for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {?>
                    <tr class="bg1 ">
                        <th class="bg1" rowspan="1">人&emsp;数</th>
                        <td class="first"><?php print $roomNum?>部屋目：</td><td><?php print $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)?>名</td>
                        <td>
                                <?php print $inputs->hidden("adult_man_".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum));?>
                                <?php print $collection->getByKey($collection->getKeyValue(), "adult_man_".$roomNum);?>

                            名</td>
                        <td>
                        		<?php print $inputs->hidden("adult_woman_".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum));?>
                                <?php print $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);?>
                            名</td>
                        <?php for ($child=1; $child<=6; $child++) {?>
                        <td><?php print $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$child)?></td>
                        <?php }?>
                    </tr>
                    <?php }?>
                </tbody>
                </table>

                <table class="style3">
                <tbody>

 				<?php for ($nightNum=1; $nightNum<=$collection->getByKey($collection->getKeyValue(), "night_number"); $nightNum++) {?>

                    <tr>
                    	<th class="bg2" rowspan="<?php print $collection->getByKey($collection->getKeyValue(), "room_number")+1?>"><?php print $nightNum?>泊目</th>
                    	<td colspan="2" class="bg2">
                    	￥<?php print number_format($money_all[$nightNum])?>
                    	</td>
                    </tr>
	                	<?php for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {?>
                    <tr>
	                    <td class="first"><?php print $roomNum?>部屋目：</td>
	                    <td>
	                    <p>大人<?php print $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)?>人× ￥<?php print number_format($roomPerDay[$roomNum]["money_perperson"])?>＝￥<?php print number_format($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)*$roomPerDay[$roomNum]["money_perperson"])?></p>

	                    <?php for ($child=1; $child<=6; $child++) {?>
		                    <?php if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$child) > 0) {?>
	                    <p>
	                    <?php print $roomPerDay[$roomNum]["childMath".$child]?>＝￥<?php print number_format($roomPerDay[$roomNum]["childFee".$child])?>
	                    </p>
		                    <?php }?>
	                    <?php }?>
	                    </td>
                    </tr>
	                    <?php }?>

                <?php }?>
                </tbody>
                </table>

                <?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {?>
                <table class="style3">
                <tbody>
                    <tr><th class="bg1">サービス料金</th><td colspan="2" class=" bg1"><?php print number_format($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE"))?>%</td></tr>
                </tbody>
                </table>
                <?php }?>

                <table class="style3">
                <tbody>
                    <tr>
	                    <th class="bg1">合計料金</th>
	                    <td colspan="2" class="price bg1">
	                    	<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {?>
	                    	<b>￥<?php print number_format($money_all_all)?></b>（税込・サービス料込）
	                    	<?php
	                    	}else {
							?>
	                    	<b>￥<?php print number_format($money_all_all)?></b>（税込・サービス料込）
	                    	<?php }?>
                    	</td>
                    </tr>
                </tbody>
                </table>


                <table class="style4 space">
                <tbody>
                    <tr>
                        <th class="bg1">ココトモ！からのご予約<br>変更・キャンセルの締切</th>
                        <?php
                        $arData = cmHotelDaySelect();
                        $d = $arData[$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")];
                        $h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
                        $m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");
                        ?>
                        <td><b class="large red"><?php print $d?> <?php print $h?>時<?php print $m?>分</b><p class="small">※上記の時間を過ぎた場合は、サイト上から変更・キャンセルを行うことができません。<br>宿泊施設へ直接ご連絡ください。</p></td>
                    </tr>
                </tbody>
                </table>
                </section>

                <section>
                <h2>◆予約代表者の情報</h2>
                <table class="style5 space">
                <tbody>
                    <tr><th>お名前</th><td>'.$onamae.'</td></tr>
                    <tr><th>メールアドレス</th><td>'.$mailad.'<p class="small">※ご予約完了時にメールをお送りします。</p></td></tr>
                    <tr><th>ご住所</th>
                    <td>
                   '.$ad.'<br/>
                   '.$ad2.'
                    </td></tr>
                    <tr><th>電話番号</th><td>'.$tel.'<p class="small">※当日ご連絡がつく番号をご入力ください。</p></td></tr>
                </tbody>
                </table>
                </section>

                <?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION") != "") {?>
                <section>
                <h2>◆予約代表者の情報 <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION_REC")==1)?'<span class="colorRed">※</span>':''?></h2>
                <table class="style5 ">
                <tbody>
                    <tr><th>宿泊施設<br>からの質問</th><td><?php print redirectForReturn($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION"))?></td></tr>
                    <tr><th>質問の回答</th><td>
                    <?php print create_error_msg($hotelBooking->getErrorByKey("BOOKING_ANSWER"))?>

                    <?php print redirectForReturn($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER"));?>
                    <?php print $inputs->hidden("BOOKING_ANSWER", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER"));?>

                    </td></tr>
                </tbody>
                </table>
                <?php }?>

                <?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_DEMAND") == 1) {?>
                <table class="style5 space">
                <tbody>
                    <tr><th>宿泊施設への<br>メッセージ</th><td>
                    <?php print create_error_msg($hotelBooking->getErrorByKey("BOOKING_DEMAND"))?>

                    <?php print redirectForReturn($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DEMAND"));?>
                    <?php print $inputs->hidden("BOOKING_DEMAND", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DEMAND"));?>

                    </td></tr>
                </tbody>
                </table>
    			</section>
    			<?php }?>

                <section>
                <h2>◆お支払方法</h2>
                <table class="style5 space">
                <tbody>
                    <tr><th class="bg1"><b class="red">お支払金額</b><span>獲得するポイント</span></th><td class="price bg1"><b>￥<?php print number_format($money_all_all)?></b>（税込・サービス料込）</td></tr>
                    <tr>
                        <th>お支払方法</th>
                        <td class="radio-group">
                        	<div>
                        	<?php if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_HOW") == 1) {?>
                        	<p>現地決済</p>
                        	<?php }?>
                        	<?php if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_HOW") == 2) {?>
                        	<p>事前支払い</p>
                        	<?php }?>
                        	<?php print $inputs->hidden("BOOKING_HOW", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_HOW"));?>
                        </div>
                    </tr>
                </tbody>
                </table>
    			</section>

                <section>
                <h2>◆キャンセルポリシー</h2>
                <table class="style5 space">
                <tbody>
                	<?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {?>

	                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {?>

		                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {?>
		                		<?php
			                    $can = "";
			                    if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
									$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."%";
								}
								else {
									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")."円";
								}
			                    ?>
    	            			<tr><th>無連絡不泊</th><td><?php print $can;?></td></tr>
	    	            	<?php }?>

		                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {?>
		                		<?php
			                    $can = "";
			                    if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
									$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."%";
								}
								else {
									$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")."円";
								}
			                    ?>
    	            			<tr><th>当日キャンセル</th><td><?php print $can;?></td></tr>
	    	            	<?php }?>

	    	            	<?php for ($i=3; $i<=7; $i++) {?>
			                	<?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {?>
			                		<?php
				                    $can = "";
				                    if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
										$can = "宿泊料の".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."%";
									}
									else {
										$can = "".$hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)."円";
									}
				                    ?>
	    	            			<tr><th><?php print $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i)?>～<?php print $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i)?> 日前まで</th><td><?php print $can;?></td></tr>
		    	            	<?php }?>
	    	            	<?php }?>

	                	<?php }?>

                	<?php }else{?>
	                	<?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {?>
		                    <?php
		                    $can = "";
		                    if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
								$can = "宿泊料の".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."%";
							}
							else {
								$can = "".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")."円";
							}
		                    ?>
		                    <tr><th>無連絡不泊</th><td><?php print $can;?></td></tr>
	                	<?php }?>
	                	<?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {?>
		                    <?php
		                    $can = "";
		                    if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
								$can = "宿泊料の".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."%";
							}
							else {
								$can = "".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")."円";
							}
		                    ?>
		                    <tr><th>当日</th><td><?php print $can;?></td></tr>
	                	<?php }?>

	                	<?php for ($i=3; $i<=6; $i++) {?>
		                	<?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {?>
			                    <?php
			                    $can = "";
			                    if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
									$can = "宿泊料の".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."%";
								}
								else {
									$can = "".$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)."円";
								}
			                    ?>
			                    <tr><th><?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i)?>～<?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CANCEL_TO".$i)?> 日前まで</th><td><?php print $can;?></td></tr>
		                	<?php }?>
	                	<?php }?>
                	<?php }?>
                </tbody>
                </table>
                </section>


                <div class="bottom">
                	<p>この内容で宜しければ予約するボタンをクリックして下さい。</p>
                	<?php  print create_error_msg($hotelBooking->getErrorByKey("BOOKING_NUMS"))?>
                	<table  border="0" style="border:none; width: 200px;" width="200">
                		<tr>
                			<td style="border:none;">
                			<?=$inputs->submit("","regist","この内容で予約する", "")?>
                			</td>
                			<td style="border:none;">
                			<?=$inputs->submit("","change","変更する", "")?>
                			</td>
                		</tr>
                	</table>

                </div>


                <?php
                $tmp = "";
                $tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
                $tmp .=  $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"));
                $tmp .=  $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
                $tmp .=  $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
                $tmp .=  $inputs->hidden("HOTELPAY_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID"));
                $tmp .=  $inputs->hidden("HOTELPROVIDE_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"));
                $tmp .=  $inputs->hidden("BOOKING_STATUS", "1");
                $tmp .=  $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
                $tmp .=  $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
                $tmp .=  $inputs->hidden("BOOKING_STATUS", $collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS"));
                $tmp .=  $inputs->hidden("BOOKING_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
                $tmp .=  $inputs->hidden("onamae", "onamae");
                $tmp .=  $inputs->hidden("mailad", "mailad");
                $tmp .=  $inputs->hidden("ad", "ad");
                $tmp .=  $inputs->hidden("ad2", "ad2");
                $tmp .=  $inputs->hidden("tel", "tel");
                for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
	                $tmp .=  $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
	                for ($ddd=1; $ddd<=6; $ddd++) {
	                	$tmp .=  $inputs->hidden("child_number".$roomNum.$ddd, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$ddd));
	                }
				}
                print $tmp;
                ?>