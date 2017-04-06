<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if ($sess->sessionCheck()) {
	cmLocationChange("mypage.html");
}


$memberRegist = new member($dbMaster);
$memberRegist->setPost();
$memberRegist->checkRegist_forgetPWD();
// echo 1;exit;
if ($memberRegist->getByKey($memberRegist->getKeyValue(), "reset") and $memberRegist->getErrorCount() <= 0) {
	if (!$memberRegist->saveNewPwd()) {
		$memberRegist->setErrorFirst("会員情報の保存に失敗しました。");
		$memberRegist->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
	else {
		cmLocationChange("mypage.html");
	}
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<title>会員ログイン ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" -->
<!-- InstanceEndEditable -->

<!--content-->
<div id="content_short" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="index">

        <!--日付・人数から検索-->
        <section class="box" style="border: 2px solid #2fcff4;width: 700px;padding: 0 10px 10px;margin:0 auto;">
        	<h2 style="margin-top: -10px;"><img src="<?php print URL_PUBLIC?>images/reissuepass.png" width="207" height="29" alt="パスワード再発行"></h2>
        	<p>ログインID (メールアドレス)を入力して パスワードの再発行 を押してください。</p>
        	<p>まだ会員でない方は以下より会員登録を行ってください。</p>
        	<p>→<a href="<?php print URL_PUBLIC?>regist.html">新規会員登録</a></p>
        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
        		<?php
						if ($memberRegist->getErrorCount() > 0) {
						?>
								<?=create_error_caption($memberRegist->getError())?>
						<?php
						}
				?>
                <table class="tblInput" width="100%">
                    <tr>
                    	<th width="140">新規パスワード <span class="colorRed">※</span></th>
                    	<td>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_PASSWORD"))?>
                    	<?=$inputs->password("MEMBER_LOGIN_PASSWORD",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_PASSWORD"),"imeDisabled", 50)?>
                    	</td>
                    </tr>
                    <tr>
                    	<th width="140">パスワード(確認)  <span class="colorRed">※</span></th>
                    	<td>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))?>
                    	<?=$inputs->password("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM,$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM),"imeDisabled", 50)?>
                    	<p>※確認の為、もう一度ご入力下さい。</p>
                    	</td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                    		<?=$inputs->submit("","reset","パスワード変更してログイン", "circle")?>
                    	</td>
                    </tr>
                </table>

                <?php
                if ($_POST) {
					foreach ($_POST as $k=>$v) {
						if ($k == "MEMBER_LOGIN_ID" or $k == "MEMBER_LOGIN_PASSWORD" or $k == "loginAuto" or $k == "login") continue;
						print $inputs->hidden($k, $v);
					}
				}
                ?>
           	</form>
        </section>

        <ul id="social">
            <li><a href="#"><img src="images/common/common-bottom-twitter.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mixi.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-gree.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-fb.png"></a></li>
            <li><a href="#"><img src="images/common/common-bottom-mail.png"></a></li>
        </ul>

    </main>
	<!-- InstanceEndEditable -->
    <!--/main-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
