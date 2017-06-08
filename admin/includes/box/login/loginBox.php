<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');

$dbmaster = new dbMaster();

if (empty($_POST["logout"])) {
	$sess = new session($db);
	$sess->start();
}

$inputs = new inputs();

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>ログイン｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body>
	<div id="login">
		<div class="loginData">
			<img src="<?=URL_SLAKER_COMMON?>assets/header/logo.png" alt="Slaker" />
			<div class="logininput circle">
				<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">

					<table cellspacing="20">
						<?php
						if ($adminInput->getErrorCount() > 0) {
						?>
						<tr>
							<td colspan="4">
								<?=create_error_caption($adminInput->getError())?>
							</td>
						</tr>
						<?php
						}
						?>
						<?php /*
						<tr>
							<th colspan="4"><?php print SITE_PUBLIC_NAME;?> SuperAdmin ログイン</th>
						</tr>
						*/?>
						<tr>
							<th>ID</th>
							<td>
								<?php print create_error_msg($adminInput->getErrorByKey("ADMIN_LOGIN_ID"))?>
								<?=$inputs->text("ADMIN_LOGIN_ID",$adminInput->getByKey($adminInput->getKeyValue(),"ADMIN_LOGIN_ID"),"imeDisabled circle",30)?>
							</td>
							<th>Password</th>
							<td>
								<?php print create_error_msg($adminInput->getErrorByKey("ADMIN_LOGIN_PASSWORD"))?>
								<?=$inputs->password("ADMIN_LOGIN_PASSWORD",$adminInput->getByKey($adminInput->getKeyValue(),"ADMIN_LOGIN_PASSWORD"),"imeDisabled circle",30)?>
							</td>
							<td>
								<?=$inputs->submit("","login","login", "circle")?>
							</td>
						</tr>
						<tr>
							<th colspan="4">
								<?php
								print $inputs->checkbox("loginAuto","loginAuto","auto",$adminInput->getByKey($adminInput->getKeyValue(),"loginAuto")," 次回から自動でログインする")
								?>
							</th>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>