	<?php
	if ($company->getErrorCount() > 0) {
	?>
				<?php print create_error_caption($company->getError())?>
	<?php
	}
	?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
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
<?php /*
<ul class="buttons">
	<li><?=$inputs->submit("","regist","契約プラン登録", "circle")?></li>
</ul>
*/?>
<?php print $inputs->hidden(constant("company::keyName"), $company->getKeyValue())?>
