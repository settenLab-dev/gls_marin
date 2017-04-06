<?php if ($affiliate->getErrorCount() > 0) {?>
<?php print create_error_caption($affiliate->getError())?>
<p class="colorRed">店舗基本情報に未設定項目があります。</p>
<?php }?>


<?php
if ($affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_STATUS") == 3 or $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") == 3) {
?>
<p>現在編集不可となっています。</p>
<p>詳細な情報は管理者にお問い合わせ下さい。</p>
<?php
}
else {
?>

<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<td align="left">
			<p>現在、アフィリエイト情報は、<h3><?php print cmFlgContentsStatus($affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_STATUS"))?></h3>となっています。</p>
		</td>
	</tr>
	<tr>
		<td align="left">
			<?php
			if ($affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_STATUS") == 1) {
			?>
			<?=$inputs->submit("","public","公開する", "circle large")?>
			<?php
			}
			else {
			?>
			<?=$inputs->submit("","notpublic","非公開にする", "circle large")?>
			<?php
			}
			?>
		</td>
	</tr>
</table>
<br />
<?php
}
?>
