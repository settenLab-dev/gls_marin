<div id="header">
	<h1>Slaker</h1>
	<a href="<?=URL_SLAKER_SHOP?>"><img src="<?=URL_SLAKER_COMMON?>assets/header/logo.png" alt="Slaker" /></a>
	<div id="headerMenu" class="circle">
		<form action="http://localhost.playbooking.shop" method="post">
		<table cellpadding="0" cellspacing="0" border="0" summary="メインアクション">
			<tr>
				<td><img src="<?=URL_SLAKER_COMMON?>assets/right/106.gif" alt="ログイン中" width="25" height="25" /></td>
				<td>こんにちは <?=$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_NAME")?> <?=$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_SHOP_NAME")?>さん&nbsp;&nbsp;</td>
				<td><?=$inputs->submit("","logout","ログアウト", "circle")?></td>
			</tr>
		</table>
		</form>
	</div>
</div>
