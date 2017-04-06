                <div class="bottom">
                	<p>この内容で宜しければ「決済手続きへ進む」ボタンをクリックして下さい。</br>
			次のページよりGMOイプシロン株式会社が提供するカード決済画面へと移動します。</br>
			<font color="red">※現在、決済未実装のため、ボタンを押すと購入完了画面へ移動します。</font></p>
                	<?php  print create_error_msg($hotelBooking->getErrorByKey("BOOKING_NUMS"))?>
                	<table  border="0" style="border:none; width: 200px;" width="200">
                		<tr>
                			<td style="border:none;">
	               			<!--<?=$inputs->submit("","","カード決済手続きへ進む", "")?>-->
					<INPUT type="submit" value="カード決済手続きへ進む" target="charge_form">
                			</td>
                			<td style="border:none;">
					<INPUT type="button" value="　戻る　" onclick="history.back()">
                			</td>
                		</tr>
                	</table>

                </div>
		<!-- ユーザーのID。初回課金で重複するとエラーなのでランダム値にしています。 -->
		<input type="hidden" name="user_id" value="cp-<?php print date("Ymd").getmypid() ?>" />
		<!-- ユーザーの名前 -->
		<input type="hidden" name="user_name" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2")?>" />
		<!-- ユーザーのメアド -->
		<input type="hidden" name="user_mail_add" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID")?>" />
		<!-- 商品のID -->
		<input type="hidden" name="item_code" value="<?php print $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID")?>" />
		<!-- 商品の名前 -->
		<input type="hidden" name="item_name" value="<?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_NAME")?>" />
		<!-- 商品ID（重複するとエラー）。テスト用にランダムな数値を算出しています。 -->
		<input type="hidden" name="order_number" value="<?php print date("Ymd").getmypid() ?>" />
		<!-- 価格。1円で。 -->
		<input type="hidden" name="item_price" value="1" />
		<!-- 決済区分。クレジットカードはこれで。 -->
		<input type="hidden" name="st_code" value="10000-0000-00000" />
		<!-- 課金区分。「1」は1回課金です。 -->
		<input type="hidden" name="mission_code" value="1" />
		<!-- 処理区分。｢1」は初回課金です。 -->
		<input type="hidden" name="process_code" value="1" />
		<!-- 任意のメモをつけることもできます。 -->
		<input type="hidden" name="memo1" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID")?>" target="chrage_form"/>
		<input type="hidden" name="memo2" value="" />

                <?php
                $tmp = "";
                $tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
                $tmp .=  $inputs->hidden("COMPANY_LINK", $collection->getByKey($collection->getKeyValue(), "COMPANY_LINK"));
                $tmp .=  $inputs->hidden("HOTELPLAN_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"));
                $tmp .=  $inputs->hidden("ROOM_ID", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"));
                $tmp .=  $inputs->hidden("HOTELPAY_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID"));
                $tmp .=  $inputs->hidden("HOTELPROVIDE_ID", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"));
                $tmp .=  $inputs->hidden("MEMBER_ID", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"));
                $tmp .=  $inputs->hidden("BOOKING_STATUS", "1");
                $tmp .=  $inputs->hidden("night_number", $collection->getByKey($collection->getKeyValue(), "night_number"));
                $tmp .=  $inputs->hidden("room_number", $collection->getByKey($collection->getKeyValue(), "room_number"));
                $tmp .=  $inputs->hidden("BOOKING_STATUS", $collection->getByKey($collection->getKeyValue(), "BOOKING_STATUS"));
                $tmp .=  $inputs->hidden("BOOKING_DATE", $collection->getByKey($collection->getKeyValue(), "target_date"));
                $tmp .=  $inputs->hidden("target_date", $collection->getByKey($collection->getKeyValue(), "target_date"));
                
                for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
	                $tmp .=  $inputs->hidden("adult_number".$roomNum, $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
	                for ($ddd=1; $ddd<=6; $ddd++) {
	                	$tmp .=  $inputs->hidden("child_number".$roomNum.$ddd, $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$ddd));
	                }
				}
                print $tmp;
                ?>