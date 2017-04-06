<section>
                <h2>◆宿泊の内容</h2>
                <table class="style1">
                <tbody>
                    <tr><th>ホテル名</th><td><?php print $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME")?></td></tr>
                    <tr><th>プラン名</th><td><?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME")?></td></tr>
                    <tr><th>部屋名</th><td><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></td></tr>
                    <tr><th>宿泊日</th><td><?php print date("Y年m月d日",strtotime($date))?></td></tr>
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
	                                名
                            </td>
                        <td>
                        		<?php print $inputs->hidden("adult_woman_".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum));?>
                                <?php print $collection->getByKey($collection->getKeyValue(), "adult_woman_".$roomNum);?>
                        		名
                            </td>
                        <?php for ($child=1; $child<=6; $child++) {?>
                        <td><?php print $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$child)?>名</td>
                        <?php }?>
                    </tr>
                    <?php }?>
                </tbody>
                </table>

                <table class="style3">
                <tbody>

                <?php $money_all_all = 0;?>
                <?php for ($nightNum=1; $nightNum<=$collection->getByKey($collection->getKeyValue(), "night_number"); $nightNum++) {?>

                    <tr>
                    	<th class="bg2" rowspan="<?php print $collection->getByKey($collection->getKeyValue(), "room_number")+1?>"><?php print $nightNum?>泊目</th>
                    	<td colspan="2" class="bg2">
                    	<?php
//                     	$money_all_all += $hotelPayDsp->getByKey($nightNum, "money_all");

                    	$tdate =  date("Ymd",strtotime(($nightNum-1)." day" ,strtotime($startDay)));
                    	?>
                    	￥<input type="hidden" id="ROOM_MONEY1" name="ROOM_MONEY1" value="<?php print $arPayList[$tdate]["money_all_all"]?>"><?php print number_format($arPayList[$tdate]["money_all_all"])?>
                    	</td>
                    </tr>
	                	<?php for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {?>
                    <tr>
	                    <td class="first"><?php print $roomNum?>部屋目：</td>
	                    <td>
	                    <p>大人<?php print $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)?>人
				×￥<input type="hidden" id="ADULT_MONEY1" name="ADULT_MONEY1" value="<?php print $arPayList[$tdate][$roomNum]["money_adult"]?>"><?php print number_format($arPayList[$tdate][$roomNum]["money_adult"])?>
				＝￥<input type="hidden" id="BOOKINGCONT_MONEY1" name="BOOKINGCONT_MONEY1" value="<?php print $arPayList[$tdate][$roomNum]["money_adult_all"]?>"><?php print number_format($arPayList[$tdate][$roomNum]["money_adult_all"])?></p>

	                    <?php for ($child=1; $child<=6; $child++) {?>
		                    <?php if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$child) > 0) {?>
	                    <p>
	                    <?php
	                    switch ($child) {
							case 1:
								print '小学生(低学年)';
								break;
							case 2:
								print '小学生(高学年)';
								break;
							case 3:
								print '幼児(食事布団あり)';
								break;
							case 4:
								print '幼児(食事あり)';
								break;
							case 5:
								print '幼児(布団あり)';
								break;
							case 6:
								print '幼児(食事布団なし)';
								break;
						}
	                    ?>
	                    <?php print $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$child)?>人
				×￥<input type="hidden" id="CHILD_MONEY<?php print $child ?>" name="CHILD_MONEY<?php print $child ?>" value="<?php print $arPayList[$tdate][$roomNum]["money_child".$child]?>"><?php print number_format($arPayList[$tdate][$roomNum]["money_child".$child])?>
				＝￥<input type="hidden" id="BOOKINGCONT_MONEY<?php print ($child+1) ?>" name="BOOKINGCONT_MONEY<?php print ($child+1) ?>" value="<?php print $arPayList[$tdate][$roomNum]["money_child".$child."_all"]?>"><?php print number_format($arPayList[$tdate][$roomNum]["money_child".$child."_all"])?>
	                    </p>
		                    <?php }?>
	                    <?php }?>
	                    </td>
                    </tr>
	                    <?php }?>

                <?php }?>
                </tbody>
                </table>

                <?php /*
                <?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {?>
                <table class="style3">
                <tbody>
                    <tr><th class="bg1">サービス料金</th><td colspan="2" class=" bg1"><?php print number_format($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE"))?>%</td></tr>
                </tbody>
                </table>
                <?php }?>
                */?>

                <table class="style3">
                <tbody>
                    <tr>
	                    <th class="bg1">合計料金</th>
	                    <td colspan="2" class="price bg1">
	                    	<?php /*
	                    	<?php if ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {?>

	                    	$money_all_all = $money_all_all + ($money_all_all * ($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_SERVICE")/100));
	                    	?>
	                    	<b>￥<?php print number_format($money_all_all)?></b>（税込・サービス料込）
	                    	<?php
	                    	}else {
							?>
	                    	<?php }*/?>
	                    	<b>￥<input type="hidden" id="BOOKING_MONEY" name="BOOKING_MONEY" value="<?php print $arPayList["money_all"]?>"><?php print number_format($arPayList["money_all"])?></b>（税込・サービス料込）
                    	</td>
                    </tr>
                </tbody>
                </table>


                <?php /*
                <table class="style4 space">
                <tbody>
                    <tr>
                        <th class="bg1">ココモ。からのご予約<br>変更・キャンセルの締切</th>
                        <?php
                        $arData = cmHotelDaySelect();

                        $d = $arData[$hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_DAY")];
                        $h = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_HOUR");
                        $m = $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CAN_MIN");

//                         $candate = date("Y年m月d日",strtotime("-".($d-1)." day" ,strtotime($hotelPay->getByKey($hotelPay->getKeyValue(), "HOTELPAY_DATE"))))
                        ?>
                        <td>
                        	<?php
                        	print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "TL_PLAN_CANCELDATA");
                        	?>
                        	<b class="large red"><?php print $d?> <?php print $h?>時<?php print $m?>分</b><p class="small">※上記の時間を過ぎた場合は、サイト上から変更・キャンセルを行うことができません。<br>宿泊施設へ直接ご連絡ください。</p>
                        </td>
                    </tr>
                </tbody>
                </table>
                */?>

                </section>

                <section>
                <h2>◆宿泊代表者の情報</h2>
                <?php print create_error_msg($hotelBooking->getErrorByKey("MEMBER_ID"))?>
                <table class="style5 space">
                <tbody>
                    <tr><th>お名前</th><td><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?> <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2")?></td></tr>
                    <tr><th>メールアドレス</th><td><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID")?><p class="small">※ご予約完了時にメールをお送りします。</p></td></tr>
                    <tr><th>ご住所</th>
                    <td>
                    <?php $ar = cmGetPrefName();?>
                    <?php print $ar[$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_PREF")]?>
                    <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_CITY")?>
                    <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ADDRESS")?>
                    <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_BUILD")?>
                    </td></tr>
                    <tr><th>電話番号</th><td><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1")?><p class="small">※当日ご連絡がつく番号をご入力ください。</p></td></tr>
                </tbody>
                </table>
                </section>

                <section>
                <h2>◆クーポン番号・キーコードの入力 <span class="colorRed">※</span></h2>
                <table class="style5 ">
                <tbody>
                    <tr><th>クーポン番号</th><td><div>マイページの「購入したクーポン」ページから確認できる「クーポン番号(cp-を含む英数字)」を入力して下さい。</div>
                    <?php print create_error_msg($hotelBooking->getErrorByKey("COUPON_ID_NUM"))?>
                    <?php print redirectForReturn($collection->getByKey($collection->getKeyValue(), "COUPON_ID_NUM"));?>
                    <?php print $inputs->hidden("COUPON_ID_NUM", $collection->getByKey($collection->getKeyValue(), "COUPON_ID_NUM"));?>
                    </td></tr>
                    <tr><th>キーコード</th><td><div>マイページの「購入したクーポン」ページから確認できる「キーコード」を入力して下さい。</div>
                    <?php print create_error_msg($hotelBooking->getErrorByKey("COUPON_KEY_CODE"))?>
                    <?php print redirectForReturn($collection->getByKey($collection->getKeyValue(), "COUPON_KEY_CODE"));?>
                    <?php print $inputs->hidden("COUPON_KEY_CODE", $collection->getByKey($collection->getKeyValue(), "COUPON_KEY_CODE"));?>
                    </td></tr>
                </tbody>
                </table>
   			</section>


                <?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION") != "") {?>
                <section>
                <h2>◆宿泊代表者の情報 <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION_REC")==1)?'<span class="colorRed">※</span>':''?></h2>
                <table class="style5 ">
                <tbody>
                    <tr><th>宿泊施設<br>からの質問</th><td><?php print redirectForReturn($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_QUESTION"))?></td></tr>
                    <tr><th>質問の回答</th><td><div>質問の回答を入力して下さい。</div>
                    <?php print create_error_msg($hotelBooking->getErrorByKey("BOOKING_ANSWER"))?>
                    <?=$inputs->textarea("BOOKING_ANSWER", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER"), "imeActive boxshadow2",30,4)?>
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
                    <tr><th class="bg1"><b class="red">お支払金額</b></th><td class="price bg1"><b>￥<input type="hidden" id="BOOKING_MONEY" name="BOOKING_MONEY" value="<?php print $arPayList["money_all"]?>"><?php print number_format($arPayList["money_all"])?></b>（税込・サービス料込）</td></tr>
                    <tr>
                        <th>お支払方法</th>
                        <td class="radio-group">
                        	<div>
                        	<?php print "ココトモ！クーポン利用";?>
                        </div>
                    </tr>
                </tbody>
                </table>
    			</section>

                <section>
                <h2>◆キャンセルポリシー</h2>
                <table class="style5 space">
                <tbody>
                	<?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "TL_PLAN_CANCELDATA") == "") {?>

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
    	            			<tr><th>無不泊連絡</th><td><?php print $can;?></td></tr>
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
		                    <tr>
		                    	<td><?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "TL_PLAN_CANCELDATA");?></td>
		                    </tr>
                	<?php }?>
                </tbody>
                </table>
                </section>

                <div class="bottom">
                	<p>この内容で宜しければ予約するボタンをクリックして下さい。</p>
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
                $tmp .=  $inputs->hidden("MEMBER_ID", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"));
                $tmp .=  $inputs->hidden("BOOKING_HOW", "3");
                $tmp .=  $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
                $tmp .=  $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
                $tmp .=  $inputs->hidden("target_date", $date);
                for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
	                $tmp .=  $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
	                for ($ddd=1; $ddd<=6; $ddd++) {
	                	$tmp .=  $inputs->hidden("child_number".$roomNum.$ddd, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$ddd));
	                }
				}
                print $tmp;
                ?>