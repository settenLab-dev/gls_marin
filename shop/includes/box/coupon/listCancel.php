			<B>▼クーポン購入者の情報</B> 
			<?php if ($couponBooking->getCount() > 0) {?>
			<?php foreach ($couponBooking->getCollection() as $ad) {?>

			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<td width="160" valign="top">
				<p>購入番号</p>
			</td>
			<td align="left">
				<p><?= $ad[COUPONBOOK_ID] ?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>クーポン番号<br/>（キーコード）</p>
			</td>
			<td align="left">
				<p> <?= $ad[COUPON_ID_NUM] ?>　(<?= $ad[COUPON_KEY_CODE]?>)</p>
				<font color="red" size="1">※受付の際は必ずクーポン番号とキーコードが一致することをお確かめ下さい。</font>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>購入者名</p>
			</td>
			<td align="left">
				<?= $ad[COUPONBOOK_NAME1]?> <?= $ad[COUPONBOOK_NAME2]?> ( <?= $ad[COUPONBOOK_KANA1]?>  <?= $ad[COUPONBOOK_KANA2]?>)
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>ステータス</p>
			</td>
			<td align="left">
				<?php
				if ($ad["COUPONBOOK_STATUS"] == 1) {
					print "<font color=blue><B>利用可能</B></font>　　　";

					print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\" enctype=\"multipart/form-data\">";
					print $inputs->submit("","used","利用済みにする", "circle");
					print $inputs->hidden("COUPONBOOK_ID", $ad["COUPONBOOK_ID"]);
					print $inputs->hidden("COMPANY_ID", $ad["COMPANY_ID"]);
					print "</form>";
					print "<font color=red size=1>※利用済み処理は一度しかできません。</font>";

				}
				elseif ($ad["COUPONBOOK_STATUS"] == 2) {
					print "<font color=red><B>利用済み</B></font>";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 3) {
					print "<font color=red><B>期限切れ</B></font>";
				}
				elseif ($ad["COUPONBOOK_STATUS"] == 4) {
					print "<font color=red><B>停止</B></font>";
				}
				?>


			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>メールアドレス</p>
			</td>
			<td align="left">
				<p> <?= $ad[MAIL_ADDRESS]?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>電話番号</p>
			</td>
			<td align="left">
				<p> <?= $ad[MEMBER_TEL1]?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>生年月日</p>
			</td>
			<td align="left">
				<p> <?= $ad[MEMBER_BIRTH_YEAR]?>年  <?= $ad[MEMBER_BIRTH_MONTH]?>月 <?= $ad[MEMBER_BIRTH_DAY]?>日</p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>住所</p>
			</td>
			<td align="left">
				沖縄県 <?= $ad[MEMBER_CITY]?> <?= $ad[MEMBER_ADDRESS]?> <?= $ad[MEMBER_BUILD]?>
			</td>
			</tr>
			</table>
			
			<br/>
			<br/>

			<B>▼購入クーポンの詳細</B> 
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<tr>
			<td width="160" valign="top">
				<p>クーポン名</p>
			</td>
			<td align="left">
				<p><?= $ad[COUPONPLAN_NAME]?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>有効期限
				</p>
			</td>
			<td align="left">
				<p><?= $ad[COUPONPLAN_USE_FROM]?>～<?= $ad[COUPONPLAN_USE_TO]?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>購入枚数
				</p>
			</td>
			<td align="left">
				<p><?= $ad[COUPONBOOK_NUM]?>枚</p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>合計金額
				</p>
			</td>
			<td align="left">
				<p><?= $ad[COUPONBOOK_PRICE_ALL]?>円</p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>クーポン内容</p>
			</td>
			<td align="left">
				<p><?= nl2br($ad[COUPONPLAN_DETAIL])?></p>
			</td>
			</tr>
			<tr>
			<td width="160" valign="top">
				<p>手数料(10％)
				</p>
			</td>
			<td align="left">
				<p><?= $ad[COUPONBOOK_PRICE_ALL]*0.1?>円</p>
			</td>
			</tr>
			</table>
	<?php }?>
		<?php }else {?>
		※購入データの読み込みに失敗しました。大変お手数ですがココトモ管理者までご連絡ください。
		<?php }?>