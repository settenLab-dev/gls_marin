	<?php
	if ($member->getErrorCount() > 0) {
	?>
				<?php print create_error_caption($member->getError())?>
	<?php
	}
	?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th width="160" valign="top">
			<p>会員名 <span class="colorRed">※</span> </p>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<th valign="top">姓</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_NAME1"))?>
						<?php print $inputs->text("MEMBER_NAME1", $member->getByKey($member->getKeyValue(), "MEMBER_NAME1") ,"imeActive circle",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top">名</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_NAME2"))?>
						<?php print $inputs->text("MEMBER_NAME2", $member->getByKey($member->getKeyValue(), "MEMBER_NAME2") ,"imeActive circle",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>会員名(カナ) <span class="colorRed">※</span> </p>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<th valign="top">姓</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_NAME_KANA1"))?>
						<?php print $inputs->text("MEMBER_NAME_KANA1", $member->getByKey($member->getKeyValue(), "MEMBER_NAME_KANA1") ,"imeActive circle",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top">名</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_NAME_KANA2"))?>
						<?php print $inputs->text("MEMBER_NAME_KANA2", $member->getByKey($member->getKeyValue(), "MEMBER_NAME_KANA2") ,"imeActive circle",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ニックネーム <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_HANDLENAME"))?>
			<?php print $inputs->text("MEMBER_HANDLENAME", $member->getByKey($member->getKeyValue(), "MEMBER_HANDLENAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>職業 </p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("M_MEMBER_WORK_ID"))?>
			<?php $ar = cmWorkId();?>
			<?php if (count($ar) > 0) {?>
			<select name="M_MEMBER_WORK_ID" class="circle">
				<option value="">---</option>
				<?php
				foreach ($ar as $k=>$v) {
					$selected = '';
					if ($member->getByKey($member->getKeyValue(), "M_MEMBER_WORK_ID") == $k) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $k?>" <?php print $selected;?>><?php print $v;?></option>
				<?php
				}
				?>
			</select>
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>性別 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_SEX"))?>
			<?php print $inputs->radio("MEMBER_SEX1", "MEMBER_SEX", 1, $member->getByKey($member->getKeyValue(), "MEMBER_SEX") ," 男性")?>
			<?php print $inputs->radio("MEMBER_SEX2", "MEMBER_SEX", 2, $member->getByKey($member->getKeyValue(), "MEMBER_SEX") ," 女性")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>生年月日 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("birthday"))?>
			<select name="MEMBER_BIRTH_YEAR" class="circle">
				<?php
				for ($i=(date("Y")-80); $i<=(date("Y")-15); $i++) {
					$selected = '';
					if ($member->getByKey($member->getKeyValue(), "MEMBER_BIRTH_YEAR") == $i) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $i?>" <?php print $selected;?>><?php print $i;?></option>
				<?php
				}
				?>
			</select> 年
			<select name="MEMBER_BIRTH_MONTH" class="circle">
				<?php
				for ($i=1; $i<=12; $i++) {
					$selected = '';
					if ($member->getByKey($member->getKeyValue(), "MEMBER_BIRTH_MONTH") == $i) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $i?>" <?php print $selected;?>><?php print $i;?></option>
				<?php
				}
				?>
			</select> 月
			<select name="MEMBER_BIRTH_DAY" class="circle">
				<?php
				for ($i=1; $i<=31; $i++) {
					$selected = '';
					if ($member->getByKey($member->getKeyValue(), "MEMBER_BIRTH_DAY") == $i) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $i?>" <?php print $selected;?>><?php print $i;?></option>
				<?php
				}
				?>
			</select> 日
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>住所 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<th valign="top">郵便番号</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_ZIP"))?>
						<?php print $inputs->text("MEMBER_ZIP", $member->getByKey($member->getKeyValue(), "MEMBER_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'MEMBER_PREF\',\'MEMBER_CITY\',\'MEMBER_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
					</td>
				</tr>
				<tr>
					<th>都道府県</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_PREF"))?>
						<?php
						$arPref = cmGetAllPrefName();
						?>
						<?php if (count($arPref) > 0) {?>
						<select name=MEMBER_PREF id="MEMBER_PREF" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($member->getByKey($member->getKeyValue(), "MEMBER_PREF")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						<?php }?>
		                </select>
					</td>
				</tr>
				<tr>
					<th>市区町村</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_CITY"))?>
						<?php print $inputs->text("MEMBER_CITY", $member->getByKey($member->getKeyValue(), "MEMBER_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<th>その他住所</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_ADDRESS"))?>
						<?php print $inputs->text("MEMBER_ADDRESS", $member->getByKey($member->getKeyValue(), "MEMBER_ADDRESS") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<th>建物名</th>
					<td>
						<?php print create_error_msg($member->getErrorByKey("MEMBER_BUILD"))?>
						<?php print $inputs->text("MEMBER_BUILD", $member->getByKey($member->getKeyValue(), "MEMBER_BUILD") ,"imeActive circle", "50")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_TEL1"))?>
			<?php print $inputs->text("MEMBER_TEL1", $member->getByKey($member->getKeyValue(), "MEMBER_TEL1") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号2 </p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_TEL2"))?>
			<?php print $inputs->text("MEMBER_TEL2", $member->getByKey($member->getKeyValue(), "MEMBER_TEL2") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>メールアドレス <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_LOGIN_ID"))?>
			<?php print $inputs->text("MEMBER_LOGIN_ID", $member->getByKey($member->getKeyValue(), "MEMBER_LOGIN_ID") ,"imeDisabled circle",50)?>
			<p>※ログインIDとして使用します。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>パスワード <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_LOGIN_PASSWORD"))?>
			<?php print $inputs->password("MEMBER_LOGIN_PASSWORD", $member->getByKey($member->getKeyValue(), "MEMBER_LOGIN_PASSWORD") ,"imeDisabled circle",50)?>
			<p class="colorGrey">半角英数4～15文字で入力。</p>
			<?php print create_error_msg($member->getErrorByKey("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))?>
			<?php print $inputs->password("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, $member->getByKey($member->getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM) ,"imeDisabled circle",50)?>
			<p class="colorGrey">確認の為もう一度入力。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>携帯メールアドレス </p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_MAILADDRESS_SUB"))?>
			<?php print $inputs->text("MEMBER_MAILADDRESS_SUB", $member->getByKey($member->getKeyValue(), "MEMBER_MAILADDRESS_SUB") ,"imeDisabled circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>メールマガジン <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_FLG_MAILMAGAZINE"))?>
			<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE1", "MEMBER_FLG_MAILMAGAZINE", 1, $member->getByKey($member->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取る")?>
			<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE2", "MEMBER_FLG_MAILMAGAZINE", 2, $member->getByKey($member->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取らない")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($member->getErrorByKey("MEMBER_STATUS"))?>
			<?php print $inputs->radio("MEMBER_STATUS1", "MEMBER_STATUS", 1, $member->getByKey($member->getKeyValue(), "MEMBER_STATUS") ," 仮登録")?>
			<?php print $inputs->radio("MEMBER_STATUS2", "MEMBER_STATUS", 2, $member->getByKey($member->getKeyValue(), "MEMBER_STATUS") ," 登録済")?>
			<?php print $inputs->radio("MEMBER_STATUS3", "MEMBER_STATUS", 3, $member->getByKey($member->getKeyValue(), "MEMBER_STATUS") ," 退会")?>
			<?php if ($member->getByKey($member->getKeyValue(), "MEMBER_STATUS") == 4) {?>
				<?php print $inputs->radio("MEMBER_STATUS4", "MEMBER_STATUS", 4, $member->getByKey($member->getKeyValue(), "MEMBER_STATUS") ," 削除済")?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","会員登録", "circle")?></li>
	<?php if ($member->getKeyValue() > 0 and $member->getByKey($member->getKeyValue(), "M_CONTRACT_STATUS") != 3) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("member::keyName"), $member->getKeyValue())?>
