<div id="loginData"  class="circle">
	<table cellspacing="10">
		<tr>
			<td align="center"><img src="<?=URL_SLAKER_COMMON?>assets/right/106.gif" alt="ログイン中" width="40" height="40" /><br />SignIn</td>
			<td>
				<h2>こんにちは<br /><?=$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_NAME")?><br /><?=$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_SHOP_NAME")?>さん</h2>
			</td>
		</tr>
	</table>
</div>