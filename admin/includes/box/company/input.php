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
			<p>ログインID <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_LOGIN_ID"))?>
			<?php print $inputs->text("COMPANY_LOGIN_ID", $company->getByKey($company->getKeyValue(), "COMPANY_LOGIN_ID") ,"imeDisabled circle",50)?>
			<p>※ログインIDとして使用します。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>パスワード <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_LOGIN_PASSWORD"))?>
			<?php print $inputs->password("COMPANY_LOGIN_PASSWORD", $company->getByKey($company->getKeyValue(), "COMPANY_LOGIN_PASSWORD") ,"imeDisabled circle",50)?>
			<p class="colorGrey">半角英数4～15文字で入力。</p>
			<?php print create_error_msg($company->getErrorByKey("COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM))?>
			<?php print $inputs->password("COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM, $company->getByKey($company->getKeyValue(), "COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM) ,"imeDisabled circle",50)?>
			<p class="colorGrey">確認の為もう一度入力。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>連絡先メールアドレス <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_MAIL"))?>
			<?php print $inputs->text("COMPANY_MAIL", $company->getByKey($company->getKeyValue(), "COMPANY_MAIL") ,"imeDisabled circle",50)?>
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
						$arPref = cmGetAllPrefName();
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
			<p>契約内容 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner">

				<tr>
					<td>契約開始日</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CONTRACT_DATE_START"))?>
						<?php print $inputs->text("COMPANY_CONTRACT_DATE_START", $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_DATE_START") ,"imeDisabled circle wNum",50)?>&nbsp;
						<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COMPANY_CONTRACT_DATE_START\').val(\'\');"')?>
						<script type="text/javascript">
							$(function() {
								$("#COMPANY_CONTRACT_DATE_START").datepicker({
									dateFormat: 'yy-mm-dd',
									beforeShow: function(input, inst){
										var off = $('#COMPANY_CONTRACT_DATE_START').offset();
										inst.dpDiv.css({
											marginTop: (off.top-480) + 'px', marginLeft: (off.left-320) + 'px'
										});
									},
									changeMonth: true,
					                changeYear: true,
					                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
					                dayNamesMin: ['日','月','火','水','木','金','土'],
								});

								$('#COMPANY_CONTRACT_DATE_START').change(function() {
									if ($(this).val() != '' && $('#COMPANY_CONTRACT_TERM').val() != '') {
										$('#COMPANY_CONTRACT_DATE_END').val(DateAdd("m", $('#COMPANY_CONTRACT_TERM').val(), $(this).val()));
									}
								});

							});

							function DateAdd(cat,add,ymd){
								ymd = new Date(ymd)
								var result_ymd;
								if(cat=="d"){
									result_ymd = new Date(ymd.getFullYear(), ymd.getMonth(), ymd.getDate() + (add * 1));
								}else if(cat=="m"){
									result_ymd = new Date(ymd.getFullYear(), ymd.getMonth() + (add * 1), ymd.getDate());
								}else if(cat=="y"){
									result_ymd = new Date(ymd.getFullYear() + (add * 1), ymd.getMonth(), ymd.getDate());
								}
								return result_ymd.getFullYear()+"-"+result_ymd.getMonth()+"-"+result_ymd.getDate();
							}
						</script>
					</td>
				</tr>
			<!--	<tr>
					<td>契約満了日</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CONTRACT_DATE_END"))?>
						<?php print $inputs->text("COMPANY_CONTRACT_DATE_END", $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_DATE_END") ,"imeDisabled circle wNum",50)?>&nbsp;
						<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COMPANY_CONTRACT_DATE_END\').val(\'\');"')?>
						<script type="text/javascript">
							$(function() {
								$("#COMPANY_CONTRACT_DATE_END").datepicker({
									dateFormat: 'yy-mm-dd',
									beforeShow: function(input, inst){
										var off = $('#COMPANY_CONTRACT_DATE_END').offset();
										inst.dpDiv.css({
											marginTop: (off.top-500) + 'px', marginLeft: (off.left-320) + 'px'
										});
									},
									changeMonth: true,
					                changeYear: true,
					                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
					                dayNamesMin: ['日','月','火','水','木','金','土'],
								});
							});
						</script>
					</td>
				</tr>
			-->
				<tr>
					<td>手数料タイプ</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CONTRACT_PAY_FLG"))?>
						<?php print $inputs->radio("COMPANY_CONTRACT_PAY_FLG1", "COMPANY_CONTRACT_PAY_FLG", 1, $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_PAY_FLG") ," 固定金額")?>
						<?php print $inputs->radio("COMPANY_CONTRACT_PAY_FLG2", "COMPANY_CONTRACT_PAY_FLG", 2, $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_PAY_FLG") ," 売上パーセント")?>
					</td>
				</tr>
				<tr>
					<td>契約金額(または手数料率)</td>
					<td>
						<?php print create_error_msg($company->getErrorByKey("COMPANY_CONTRACT_PAY"))?>
						<?php print $inputs->text("COMPANY_CONTRACT_PAY", $company->getByKey($company->getKeyValue(), "COMPANY_CONTRACT_PAY") ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<td>利用機能</td>
					<td>
						<?=$inputs->checkbox("COMPANY_FUNC_HOTERL1", "COMPANY_FUNC_HOTERL", 1, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_HOTERL")," レジャー予約", "")?>&nbsp;
						<?=$inputs->checkbox("COMPANY_FUNC_COUPON", "COMPANY_FUNC_COUPON", 1, $company->getByKey($company->getKeyValue(), "COMPANY_FUNC_COUPON")," クーポン販売", "")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>メモ(非公開)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_MEMO"))?>
			<?=$inputs->textarea("COMPANY_MEMO", $company->getByKey($company->getKeyValue(), "COMPANY_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($company->getErrorByKey("COMPANY_STATUS"))?>
			<?php print $inputs->radio("COMPANY_STATUS1", "COMPANY_STATUS", 1, $company->getByKey($company->getKeyValue(), "COMPANY_STATUS") ," ".cmFlgCompanyStatus(1))?>
			<?php print $inputs->radio("COMPANY_STATUS2", "COMPANY_STATUS", 2, $company->getByKey($company->getKeyValue(), "COMPANY_STATUS") ," ".cmFlgCompanyStatus(2))?>
			<?php print $inputs->radio("COMPANY_STATUS3", "COMPANY_STATUS", 3, $company->getByKey($company->getKeyValue(), "COMPANY_STATUS") ," ".cmFlgCompanyStatus(3))?>
			<?php if ($company->getByKey($company->getKeyValue(), "COMPANY_STATUS") == 4) {?>
				<?php print $inputs->radio("COMPANY_STATUS4", "COMPANY_STATUS", 4, $company->getByKey($company->getKeyValue(), "COMPANY_STATUS") ," ".cmFlgCompanyStatus(4))?>
			<?php }?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","アカウント登録", "circle")?></li>
	<?php if ($company->getKeyValue() > 0 and $company->getByKey($company->getKeyValue(), "M_CONTRACT_STATUS") != 3) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("company::keyName"), $company->getKeyValue())?>
