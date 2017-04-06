<?php if ($coupon->getErrorCount() > 0) {?>
<?php print create_error_caption($coupon->getError())?>
<?php }?>

<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<?php for ($i=1; $i<=SITE_COUPON_NUM; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>クーポン <?php print $i;?></p>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<td valign="top">ステータス <span class="colorRed">※</span></td>
					<td>
						<?php
						if ($coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS".$i) == "") {
							$coupon->setByKey($coupon->getKeyValue(), "COUPON_STATUS".$i, 1);
						}
						?>
						<?php print create_error_msg($coupon->getErrorByKey("COUPON_STATUS".$i))?>
						<?php print $inputs->radio("COUPON_STATUS1".$i, "COUPON_STATUS".$i, 1, $coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS".$i) ," 非公開にする")?>
						<?php print $inputs->radio("COUPON_STATUS2".$i, "COUPON_STATUS".$i, 2, $coupon->getByKey($coupon->getKeyValue(), "COUPON_STATUS".$i) ," 公開する")?>
						<p>※非公開にする場合、以下の項目を入力する必要はありません。</p>
					</td>
				</tr>
				<tr>
					<td valign="top">クーポン名 <span class="colorRed">※</span></td>
					<td>
						<?php print create_error_msg($coupon->getErrorByKey("COUPON_NAME".$i))?>
						<?php print $inputs->text("COUPON_NAME".$i, $coupon->getByKey($coupon->getKeyValue(), "COUPON_NAME".$i) ,"imeActive circle",50)?>
					</td>
				</tr>
				<tr>
					<td valign="top">金額 <span class="colorRed">※</span></td>
					<td>
						<?php print create_error_msg($coupon->getErrorByKey("COUPON_PAY".$i))?>
						<?php print $inputs->text("COUPON_PAY".$i, $coupon->getByKey($coupon->getKeyValue(), "COUPON_PAY".$i) ,"imeDisabled circle wNum",50)?> 円
					</td>
				</tr>
				<tr>
					<td valign="top">対象期間</td>
					<td>
						<?php print create_error_msg($coupon->getErrorByKey("COUPON_DATE_FROM".$i))?>
						<?php print create_error_msg($coupon->getErrorByKey("COUPON_DATE_TO".$i))?>
						<?php print $inputs->text("COUPON_DATE_FROM".$i, $coupon->getByKey($coupon->getKeyValue(), "COUPON_DATE_FROM".$i) ,"imeDisabled circle wNum",50)?>
						～
						<?php print $inputs->text("COUPON_DATE_TO".$i, $coupon->getByKey($coupon->getKeyValue(), "COUPON_DATE_TO".$i) ,"imeDisabled circle wNum",50)?>

						<script type="text/javascript">
							$(function() {
								$("#COUPON_DATE_FROM<?php print $i;?>").datepicker({
									dateFormat: 'yy-mm-dd',
									changeMonth: true,
					                changeYear: true,
					                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
					                dayNamesMin: ['日','月','火','水','木','金','土'],
								});
								$("#COUPON_DATE_TO<?php print $i;?>").datepicker({
									dateFormat: 'yy-mm-dd',
									changeMonth: true,
					                changeYear: true,
					                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
					                dayNamesMin: ['日','月','火','水','木','金','土'],
								});
							});

						</script>
					</td>
				</tr>
				<tr>
					<td valign="top">詳細情報 <span class="colorRed">※</span></td>
					<td>
						<?php print create_error_msg($coupon->getErrorByKey("COUPON_CONTENT".$i))?>
						<?=$inputs->textarea("COUPON_CONTENT".$i, $coupon->getByKey($coupon->getKeyValue(), "COUPON_CONTENT".$i), "imeActive circle",30,4)?>
					</td>
				</tr>
				<tr>
					<td valign="top">非公開メモ</td>
					<td>
						<?php print create_error_msg($coupon->getErrorByKey("COUPON_MEMO".$i))?>
						<?=$inputs->textarea("COUPON_MEMO".$i, $coupon->getByKey($coupon->getKeyValue(), "COUPON_MEMO".$i), "imeActive circle",30,4)?>
					</td>
				</tr>
			</table>
			<?php print $inputs->hidden("COUPON_ID".$i, $coupon->getByKey($coupon->getKeyValue(), "COUPON_ID".$i))?>

		</td>
	</tr>
	<?php }?>
</table>
<br />

<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","クーポン情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>
