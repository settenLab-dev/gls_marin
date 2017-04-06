<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');
$inputs = new inputs();
?>
<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
 <h2>こんにちは♪<b>ゲスト</b>さん</h2>
 <div id="loginBoxMin">
<div class="logout">すでに会員の方は<br />以下よりログインして下さい。</div>
 	<?php if ($memberInput->getErrorCount() > 0) {?>
 	<?=create_error_caption($memberInput->getError())?>
 	<?php }?>

	<p>ログインID</p>
	<?php print create_error_msg($memberInput->getErrorByKey("MEMBER_LOGIN_ID"))?>
 	<p><?=$inputs->text("MEMBER_LOGIN_ID",$memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_ID"),"imeDisabled ")?></p>
 	<p>パスワード</p>
 	<?php print create_error_msg($memberInput->getErrorByKey("MEMBER_LOGIN_PASSWORD"))?>
	<p><?=$inputs->password("MEMBER_LOGIN_PASSWORD",$memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_PASSWORD"),"imeDisabled")?></p>
	<p><?php print $inputs->checkbox("loginAuto","loginAuto","auto",$memberInput->getByKey($memberInput->getKeyValue(),"loginAuto")," 次回から自動でログイン")?></p>
	<div class="alignCenter">
		<?=$inputs->submit("","login","ログイン", "circle")?>
		<div class="logout">→<a href="<?=URL_PUBLIC?>forgot.html">パスワードを忘れた方</a></div>
	</div>
</div>
</form>
<div class="logout">→<a href="<?=URL_PUBLIC?>regist.html">まだ会員でない方はこちら！</a></div>