<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($mContract->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($mContract->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>契約プラン名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_NAME"))?>
			<?php print $inputs->text("M_CONTRACT_NAME", $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>金額フラグ <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_PAY_FLG"))?>
			<?php print $inputs->radio("M_CONTRACT_PAY_FLG1", "M_CONTRACT_PAY_FLG", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_PAY_FLG") ," 金額")?>
			<?php print $inputs->radio("M_CONTRACT_PAY_FLG2", "M_CONTRACT_PAY_FLG", 2, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_PAY_FLG") ," パーセント")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>金額 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_PAY"))?>
			<?php print $inputs->text("M_CONTRACT_PAY", $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_PAY") ,"imeDisabled circle",20)?>
			<p class="colorGrey">半角数字10文字以内で入力。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>契約月数 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_TERM"))?>
			<?php print $inputs->text("M_CONTRACT_TERM", $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_TERM") ,"imeDisabled circle",20)?> か月
			<p class="colorGrey">半角数字10文字以内で入力。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>有効にする機能</p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_FUNC_AD"))?>
			<?=$inputs->checkbox("M_CONTRACT_FUNC_AD", "M_CONTRACT_FUNC_AD", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_AD")," 広告バナー", "")?>&nbsp;
			<?=$inputs->checkbox("M_CONTRACT_FUNC_GURUME", "M_CONTRACT_FUNC_GURUME", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_GURUME")," グルメ情報", "")?><br />
			<?=$inputs->checkbox("M_CONTRACT_FUNC_ACT", "M_CONTRACT_FUNC_ACT", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_ACT")," アクティビティ情報", "")?><br />
			<?=$inputs->checkbox("M_CONTRACT_FUNC_AFI", "M_CONTRACT_FUNC_AFI", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_AFI")," アフィリエイト情報", "")?>&nbsp;
			<?=$inputs->checkbox("M_CONTRACT_FUNC_HOTEL1", "M_CONTRACT_FUNC_HOTEL", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_HOTEL")," ホテル情報", "")?>&nbsp;
			<?=$inputs->checkbox("M_CONTRACT_FUNC_HOTEL2", "M_CONTRACT_FUNC_HOTEL", 2, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_HOTEL")," レジャー情報", "")?>&nbsp;<br />
			<?=$inputs->checkbox("M_CONTRACT_FUNC_JOB", "M_CONTRACT_FUNC_JOB", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_JOB")," お仕事情報", "")?>&nbsp;
			<?=$inputs->checkbox("M_CONTRACT_FUNC_COUPON", "M_CONTRACT_FUNC_COUPON", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_FUNC_COUPON")," クーポン販売", "")?>&nbsp;
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>プラン説明</p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_REMARK"))?>
			<?=$inputs->textarea("M_CONTRACT_REMARK", $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_REMARK"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>メモ(非公開)</p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_MEMO"))?>
			<?=$inputs->textarea("M_CONTRACT_MEMO", $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mContract->getErrorByKey("M_CONTRACT_STATUS"))?>
			<?php print $inputs->radio("M_CONTRACT_STATUS1", "M_CONTRACT_STATUS", 1, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_STATUS") ," 公開")?>
			<?php print $inputs->radio("M_CONTRACT_STATUS2", "M_CONTRACT_STATUS", 2, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_STATUS") ," 非公開")?>
			<?php if ($mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_STATUS") == 3) {?>
				<?php print $inputs->radio("M_CONTRACT_STATUS3", "M_CONTRACT_STATUS", 3, $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","契約プラン登録", "circle")?></li>
	<?php if ($mContract->getKeyValue() > 0 and $mContract->getByKey($mContract->getKeyValue(), "M_CONTRACT_STATUS") != 3) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("mContract::keyName"), $mContract->getKeyValue())?>
