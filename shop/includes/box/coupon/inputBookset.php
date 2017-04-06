<?php if ($jobBookset->getErrorCount() > 0) {?>
<?php print create_error_caption($jobBookset->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>通知管理の設定</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>連絡先1 <span class="colorRed">※</span><br />PCメールアドレス</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<th valign="top" >PCメールアドレス</th>
					<td>
						<?php print create_error_msg($jobBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS"))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS", $jobBookset->getByKey($jobBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS") ,"imeDisabled circle ",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" >確認の為、<br />もう一度入力</th>
					<td>
						<?php print create_error_msg($jobBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM, $jobBookset->getByKey($jobBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM) ,"imeDisabled circle ",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />

<ul class="buttons">
	<li><?=$inputs->submit("","regist","問い合わせ設定を保存する", "circle")?></li>
</ul>
