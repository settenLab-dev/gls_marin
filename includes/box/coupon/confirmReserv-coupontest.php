<section></br>
                <h2>◆クーポン購入内容の確認</h2>

               <div class="bottom" style="text-align:left; padding-left:60px;">
                	<p>ご購入内容と金額をお確かめの上、カード番号および必要事項を入力してください。</br>
			ココトモのカード決済はGMOイプシロン株式会社が提供するクレジットカード決済機能を利用しています。</br>
			<font color="red">カード番号及び個人情報はセキュリティの高いSSL通信で暗号化され、安全に送信されます。</font></p>
			※原則として、購入後のキャンセルは受け付けておりません。必ずご購入前に内容をご確認ください。</br>
			※ご購入前に弊社の<a href="http://cocotomo.net/shop-info.html" target="blank">特定商取引に基づく表記</a>をご確認ください。
                </div>
</br>
                <table class="style1">
                <tbody>
                    <tr><th>クーポン名</th><td><?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_NAME")?></td></tr>
                    <tr><th>店舗名</th><td><?php print $couponShop->getByKey($couponShop->getKeyValue(), "COUPONSHOP_NAME")?></td></tr>
                </tbody>
                </table>

               <table class="style1">
                <tbody>
<!--
                    <tr>
			<th class="bg2">購入枚数</th>
                        <td><p><?php print $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NUM")?>枚</p></td>
                	<th class="bg2" colspan="2">クーポン1枚あたりの料金</th>
                    	<td>
                    	￥<?php print $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE")?>
                    	</td>
		</tr>
-->
                   <tr>
                	<th class="bg2">料金内訳</th>
	                    <td>
	                    <p>クーポン <?php print $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NUM")?>枚 × ￥<?php print $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE")?>
				＝￥<?php print number_format($collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE_ALL"))?></p>
	                    </td>
                    </tr>
                    <tr>
	                    <th class="bg1">合計料金</th>
	                    <td class="price bg1">
	                    	<b>￥<?php print number_format($collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE_ALL"))?></b>（税込）
                    	</td>
                    </tr>

                </tbody>
                </table>
                </section>

                <section>
                <h2>◆購入者の情報</h2>
                <?php print create_error_msg($couponBooking->getErrorByKey("MEMBER_ID"))?>
                <table class="style5 space">
                <tbody>
                    <tr><th>お名前</th><td><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?> <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2")?>　(<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1")?> <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2")?>)</td></tr>
                    <tr><th>メールアドレス</th><td><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID")?><p class="small">※ご予約完了時にメールをお送りします。</p></td></tr>
                    <tr><th>ご住所</th>
                    <td>
                    <?php $ar = cmGetPrefName();?>
                    <?php print $ar[$sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_PREF")]?>
                    <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_CITY")?>
                    <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ADDRESS")?>
                    <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_BUILD")?>
                    </td></tr>
                    <tr><th>電話番号</th><td><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1")?><p class="small">※ご利用当日ご連絡がつく番号をご入力ください。</p></td></tr>
                </tbody>
                </table>
                </section>

<!--
                <section>
                <h2>◆お支払方法</h2>
                <table class="style5 space">
                <tbody>
                    <tr><th class="bg1"><b class="red">お支払金額</b><span>獲得するポイント</span></th><td class="price bg1"><b>￥<?php print number_format($collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NUM"))*($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_SELL_PRICE"))?></b>（税込）</td></tr>
                    <tr><th><b>獲得ポイント</b></th><td><?php print floor(($collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NUM"))*($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_SELL_PRICE"))*92/100*1/100)?>ポイント（※税抜き価格より1％）</td></tr>
                    <tr>
                        <th>お支払方法</th>
                        <td class="radio-group">
                        	<div>
                        	<b>お支払いは事前カード決済のみとなります。</b>
                        ※ご利用可能なカード会社一覧<br/>
			<img src="./images/coupon/card_visa_b.gif" width="70" height="70" alt="VISA">
			<img src="./images/coupon/card_master_b.gif" width="70" height="70" alt="MASTER">
			<img src="./images/coupon/card_jcb_b.gif" width="70" height="70" alt="JCB">
			<img src="./images/coupon/card_amex_b.gif" width="70" height="70" alt="AMERICAN EXPRESS">
			<img src="./images/coupon/card_diners_b.gif" width="70" height="70" alt="Diners Club">
			</td>
                    </tr>
                </tbody>
                </table>
    			</section>
-->
<!--
               <div class="bottom">
                	<p>ご購入内容と金額をお確かめの上、カード番号および必要事項を入力してください。</br>
			ココトモのカード決済はGMOイプシロン株式会社が提供するクレジットカード決済機能を利用しています。</br>
			<font color="red">カード番号及び個人情報はセキュリティの高いSSL通信で暗号化され、安全に送信されます。</font></p>
			※原則として、購入後のキャンセルは受け付けておりません。必ずご購入前に内容をご確認ください。
			※ご購入前に弊社の<a href="http://cocotomo.net/shop-info.html" target="blank">特定商取引に基づく表記</a>をご確認ください。
               	<table  border="0" style="border:none; width: 200px;" width="200" id="btn">
                		<tr>
                			<td style="border:none;">
					<INPUT type="button" value="前のページに戻る" onclick="history.back()">
                			</td>
                		</tr>
                	</table>

                </div>
-->
		<input type="hidden" name="regist" value="a" />
		<section>
		<iframe style="padding-left:60px;" src="<?php print $redirect?>" width="800" height="900" id="charge_form" name="charge_form" sandbox="allow-top-navigation allow-same-origin allow-forms allow-scripts" frameborder="0" seamless="true"></iframe>
		</section>
               	<table  border="0" style="border:none;" id="btn">
                		<tr>
                			<td style="border:none;">
					<INPUT type="button" value="前のページに戻る" onclick="history.back()">
                			</td>
                		</tr>
                </table>
                <?php
		$coupon_id_num = $collection->getByKey($collection->getKeyValue(), "COUPON_NUM_MEMORY");

                $tmp = "";
                $tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
                $tmp .=  $inputs->hidden("COUPONPLAN_ID", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"));
                $tmp .=  $inputs->hidden("COUPONSHOP_ID", $collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"));
                $tmp .=  $inputs->hidden("COUPON_ID_NUM", "cp-".$coupon_id_num);
                $tmp .=  $inputs->hidden("COUPON_KEY_CODE", $couponBooking->KeyCodeStr());
                $tmp .=  $inputs->hidden("MEMBER_ID", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"));
                $tmp .=  $inputs->hidden("COUPONBOOK_NAME1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1"));
                $tmp .=  $inputs->hidden("COUPONBOOK_NAME2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2"));
                $tmp .=  $inputs->hidden("COUPONBOOK_KANA1", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1"));
                $tmp .=  $inputs->hidden("COUPONBOOK_KANA2", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2"));
                $tmp .=  $inputs->hidden("MAIL_ADDRESS", $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID"));
                $tmp .=  $inputs->hidden("COUPONBOOKPLAN_USE_FROM", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_FROM"));
                $tmp .=  $inputs->hidden("COUPONBOOKPLAN_USE_TO", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO"));
                $tmp .=  $inputs->hidden("COUPONBOOK_NUM", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_NUM"));
                $tmp .=  $inputs->hidden("COUPONBOOK_PRICE", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE"));
                $tmp .=  $inputs->hidden("COUPONBOOK_PRICE_ALL", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE_ALL"));
                $tmp .=  $inputs->hidden("COUPONBOOK_STATUS", "1");
                $tmp .=  $inputs->hidden("COUPONUSE_FLG", "1");
//                $tmp .=  $inputs->hidden("COUPONBOOK_DATE", now());
                print $tmp;
                ?>

		<!-- ユーザーID(重複するとエラー) -->
		<input type="hidden" name="user_id" value="cp-<?php print $coupon_id_num?>" />
		<!-- ユーザー名 -->
		<input type="hidden" name="user_name" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2")?>" />
		<!-- ユーザーメール -->
		<input type="hidden" name="user_mail_add" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID")?>" />
		<!-- 商品ID -->
		<input type="hidden" name="item_code" value="<?php print $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID")?>" />
		<!-- 商品名 -->
		<input type="hidden" name="item_name" value="<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_NAME")?>" />
		<!-- 商品ID（重複するとエラー）-->
		<input type="hidden" name="order_number" value="<?php print $coupon_id_num ?>" />
		<!-- 価格 -->
		<input type="hidden" name="item_price" value="<?php print $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE_ALL")?>" target="charge_form" />
		<!-- 決済区分 -->
		<input type="hidden" name="st_code" value="10000-0000-00000" />
		<!-- 課金区分 -->
		<input type="hidden" name="mission_code" value="1" />
		<!-- 処理区分 -->
		<input type="hidden" name="process_code" value="1" />
		<!-- メモ -->
		<input type="hidden" name="memo1" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID")?>" target="chrage_form" />
		<input type="hidden" name="memo2" value="<?php print $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_PRICE")?>" />

