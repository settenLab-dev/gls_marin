	<?php
	if ($company->getErrorCount() > 0) {
	?>
				<?php print create_error_caption($company->getError())?>
	<?php
	}
	?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th width="160" valign="top">
			<p>企業名 </p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_NAME"))?>
			<?php print $inputs->text("COMPANY_NAME", $company->getByKey($company->getKeyValue(), "COMPANY_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>企業名(カナ)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_NAME_KANA"))?>
			<?php print $inputs->text("COMPANY_NAME_KANA", $company->getByKey($company->getKeyValue(), "COMPANY_NAME_KANA") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>店舗名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_SHOP_NAME"))?>
			<?php print $inputs->text("COMPANY_SHOP_NAME", $company->getByKey($company->getKeyValue(), "COMPANY_SHOP_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>店舗名(カナ) <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_SHOP_NAME_KANA"))?>
			<?php print $inputs->text("COMPANY_SHOP_NAME_KANA", $company->getByKey($company->getKeyValue(), "COMPANY_SHOP_NAME_KANA") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>メールアドレス <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_LOGIN_ID"))?>
			<?php print $company->getByKey($company->getKeyValue(), "COMPANY_LOGIN_ID");?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>店舗住所 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<td valign="top">郵便番号</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_ZIP"))?>
						<?php print $inputs->text("COMPANY_ZIP", $company->getByKey($company->getKeyValue(), "COMPANY_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'PREF_ID\',\'COMPANY_CITY\',\'COMPANY_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
					</td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("PREF_ID"))?>
						<?php
						$arPref = cmGetPrefName();
						?>
						<?php if (count($arPref) > 0) {?>
						<select name=PREF_ID id="PREF_ID" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($company->getByKey($company->getKeyValue(), "PREF_ID")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						<?php }?>
		                </select>
					</td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CITY"))?>
						<?php print $inputs->text("COMPANY_CITY", $company->getByKey($company->getKeyValue(), "COMPANY_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>その他住所</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_ADDRESS"))?>
						<?php print $inputs->text("COMPANY_ADDRESS", $company->getByKey($company->getKeyValue(), "COMPANY_ADDRESS") ,"imeActive circle", "50")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>請求書送付先 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?=$inputs->checkbox("COMPANY_CLAIM_FLG","COMPANY_CLAIM_FLG", 1,$company->getByKey($company->getKeyValue(), "COMPANY_CLAIM_FLG")," 店舗情報を使用する", "")?>
			<script type="text/javascript">
			$(function(){
			    $('#COMPANY_CLAIM_FLG').click(function(){
				    if(this.checked){
				    $('#tblClaim').addClass('dspNon');
				    }else{
				    $('#tblClaim').removeClass('dspNon');
				    }
			  	});

			  	<?php if ($company->getByKey($company->getKeyValue(), "COMPANY_CLAIM_FLG") == 1) {?>
			  	$('#tblClaim').addClass('dspNon');
			  	<?php }?>
			});
			</script>
			<table id="tblClaim" class="inner" cellspacing="10" style="">
				<tr>
					<td colspan="2">
					</td>
				</tr>
				<tr>
					<td valign="top">請求先名</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CLAIM_NAME"))?>
						<?php print $inputs->text("COMPANY_CLAIM_NAME", $company->getByKey($company->getKeyValue(), "COMPANY_CLAIM_NAME") ,"imeDisabled circle ", "")?>
					</td>
				</tr>
				<tr>
					<td valign="top">郵便番号</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CLAIM_ZIP"))?>
						<?php print $inputs->text("COMPANY_CLAIM_ZIP", $company->getByKey($company->getKeyValue(), "COMPANY_CLAIM_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'COMPANY_CLAIM_PREF_ID\',\'COMPANY_CLAIM_CITY\',\'COMPANY_CLAIM_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
					</td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CLAIM_PREF_ID"))?>
						<?php
						$arPref = cmGetPrefName();
						?>
						<?php if (count($arPref) > 0) {?>
						<select name=COMPANY_CLAIM_PREF_ID id="COMPANY_CLAIM_PREF_ID" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($company->getByKey($company->getKeyValue(), "COMPANY_CLAIM_PREF_ID")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						<?php }?>
		                </select>
					</td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CLAIM_CITY"))?>
						<?php print $inputs->text("COMPANY_CLAIM_CITY", $company->getByKey($company->getKeyValue(), "COMPANY_CLAIM_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>その他住所</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CLAIM_ADDRESS"))?>
						<?php print $inputs->text("COMPANY_CLAIM_ADDRESS", $company->getByKey($company->getKeyValue(), "COMPANY_CLAIM_ADDRESS") ,"imeActive circle", "50")?>
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
			<?php print create_error_msg($company->getErrorByKey("COMPANY_TEL1"))?>
			<?php print $inputs->text("COMPANY_TEL1", $company->getByKey($company->getKeyValue(), "COMPANY_TEL1") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号2 </p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_TEL2"))?>
			<?php print $inputs->text("COMPANY_TEL2", $company->getByKey($company->getKeyValue(), "COMPANY_TEL2") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>FAX </p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_FAX"))?>
			<?php print $inputs->text("COMPANY_FAX", $company->getByKey($company->getKeyValue(), "COMPANY_FAX") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>担当者名</p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_CHARGE"))?>
			<?php print $inputs->text("COMPANY_CHARGE", $company->getByKey($company->getKeyValue(), "COMPANY_CHARGE") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>契約プラン <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<td>契約プラン名</td>
					<td>
					<?php print $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_NAME");?>
					</td>
				</tr>
				<tr>
					<td>契約期間</td>
					<td>
						<?php print$company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_TERM");?>&nbsp;か月
					</td>
				</tr>
				<tr>
					<td>契約開始日</td>
					<td>
					<?php print $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_DATE_START");?>
					</td>
				</tr>
				<tr>
					<td>契約満了日</td>
					<td>
					<?php print $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_DATE_END");?>
					</td>
				</tr>
				<tr>
					<td>契約金額</td>
					<td>
					<?php if ($company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_PAY_FLG") == 2) {?>
					<?php print $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_PAY");?>&nbsp;%
					<?php }else{?>
					<?php print $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_PAY");?>&nbsp;円
					<?php }?>
					</td>
				</tr>
				<tr>
					<td>利用機能</td>
					<td>
						<?=$inputsOnly->checkbox("COMPANY_FUNC_AD", "COMPANY_FUNC_AD", 1, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_AD")," 広告バナー", "")?>&nbsp;
						<?=$inputsOnly->checkbox("COMPANY_FUNC_GURUME", "COMPANY_FUNC_GURUME", 1, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_GURUME")," グルメ情報", "")?><br />
						<?=$inputsOnly->checkbox("COMPANY_FUNC_ACT", "COMPANY_FUNC_ACT", 1, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_ACT")," アクティビティ情報", "")?><br />
						<?=$inputsOnly->checkbox("COMPANY_FUNC_AFI", "COMPANY_FUNC_AFI", 1, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_AFI")," アフィリエイト情報", "")?>&nbsp;
						<?=$inputsOnly->checkbox("COMPANY_FUNC_HOTERL", "COMPANY_FUNC_HOTERL", 1, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_HOTERL")," ホテル情報", "")?>&nbsp;
						<?=$inputsOnly->checkbox("COMPANY_FUNC_HOTERL", "COMPANY_FUNC_HOTERL", 2, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_HOTERL")," レジャー予約", "")?>&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","店舗情報を保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("company::keyName"), $company->getKeyValue())?>
