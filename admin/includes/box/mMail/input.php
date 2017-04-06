<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($mMail->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($mMail->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>使用用途 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mMail->getErrorByKey("M_MAIL_USE"))?>
			<?php print $inputs->text("M_MAIL_USE", $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_USE") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>タイトル <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mMail->getErrorByKey("M_MAIL_TITLE"))?>
			<?php print $inputs->text("M_MAIL_TITLE", $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>内容 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mMail->getErrorByKey("M_MAIL_CONTENTS"))?>
			<?=$inputs->textarea("M_MAIL_CONTENTS", $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($mMail->getErrorByKey("M_MAIL_FLG_DELETE"))?>
			<?php print $inputs->radio("M_MAIL_FLG_DELETE1", "M_MAIL_FLG_DELETE", 1, $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_FLG_DELETE") ," 有効")?>
			<?php if ($mMail->getByKey($mMail->getKeyValue(), "M_MAIL_FLG_DELETE") == 2) {?>
				<?php print $inputs->radio("M_MAIL_FLG_DELETE2", "M_MAIL_FLG_DELETE", 2, $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_FLG_DELETE") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>管理メモ </p>
		</td>
		<td align="left">
			<?php print create_error_msg($mMail->getErrorByKey("M_MAIL_MEMO"))?>
			<?=$inputs->textarea("M_MAIL_MEMO", $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","メールテンプレート登録", "circle")?></li>
	<?php if ($mMail->getKeyValue() > 0 and $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_FLG_DELETE") != 2) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("mMail::keyName"), $mMail->getKeyValue())?>
