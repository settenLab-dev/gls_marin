<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($admin->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($admin->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>管理者名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($admin->getErrorByKey("ADMIN_NAME"))?>
			<?php print $inputs->text("ADMIN_NAME", $admin->getByKey($admin->getKeyValue(), "ADMIN_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ログインID <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($admin->getErrorByKey("ADMIN_LOGIN_ID"))?>
			<?php print $inputs->text("ADMIN_LOGIN_ID", $admin->getByKey($admin->getKeyValue(), "ADMIN_LOGIN_ID") ,"imeDisabled circle",50)?>
			<p class="colorGrey">半角英数4～15文字で入力。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>パスワード <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($admin->getErrorByKey("ADMIN_LOGIN_PASSWORD"))?>
			<?php print $inputs->password("ADMIN_LOGIN_PASSWORD", $admin->getByKey($admin->getKeyValue(), "ADMIN_LOGIN_PASSWORD") ,"imeDisabled circle",50)?>
			<p class="colorGrey">半角英数4～15文字で入力。</p>
			<?php print create_error_msg($admin->getErrorByKey("ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM))?>
			<?php print $inputs->password("ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM, $admin->getByKey($admin->getKeyValue(), "ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM) ,"imeDisabled circle",50)?>
			<p class="colorGrey">確認の為もう一度入力。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>メールアドレス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($admin->getErrorByKey("ADMIN_LOGIN_MAILADDRESS"))?>
			<?php print $inputs->text("ADMIN_LOGIN_MAILADDRESS", $admin->getByKey($admin->getKeyValue(), "ADMIN_LOGIN_MAILADDRESS") ,"imeDisabled circle",50)?>
			<p class="colorGrey">管理者用メールアドレスを登録。</p>
		</td>
	</tr>
	<tr>
		<td>利用権限</td>
		<td>
			<?=$inputs->checkbox("ADMIN_LEVEL1", "ADMIN_LEVEL1", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL1")," 契約情報", "")?>  
			<?=$inputs->checkbox("ADMIN_LEVEL2", "ADMIN_LEVEL2", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL2")," 会員情報", "")?><br />
			<?=$inputs->checkbox("ADMIN_LEVEL3", "ADMIN_LEVEL3", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL3")," コンテンツ管理", "")?> 
			<?=$inputs->checkbox("ADMIN_LEVEL4", "ADMIN_LEVEL4", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL4")," クライアント管理", "")?><br />
			<?=$inputs->checkbox("ADMIN_LEVEL5", "ADMIN_LEVEL5", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL5")," レポート管理", "")?> 
			<?=$inputs->checkbox("ADMIN_LEVEL6", "ADMIN_LEVEL6", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL6")," 請求管理", "")?><br />
			<?=$inputs->checkbox("ADMIN_LEVEL7", "ADMIN_LEVEL7", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL7")," 基本設定", "")?>
		</td>
	</tr>



	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_STATUS") == 2) {?>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($admin->getErrorByKey("ADMIN_STATUS"))?>
			<?php print $inputs->radio("ADMIN_STATUS1", "ADMIN_STATUS", 1, $admin->getByKey($admin->getKeyValue(), "ADMIN_STATUS") ," 有効")?>
			<?php print $inputs->radio("ADMIN_STATUS2", "ADMIN_STATUS", 2, $admin->getByKey($admin->getKeyValue(), "ADMIN_STATUS") ," 削除済")?>
		</td>
	</tr>
	<?php }?>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","管理者登録", "circle")?></li>
	<?php if ($admin->getKeyValue() > 0 and $admin->getByKey($admin->getKeyValue(), "ADMIN_STATUS") != 2) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("admin::keyName"), $admin->getKeyValue())?>
