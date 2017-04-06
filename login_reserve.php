<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");

if ($sess->sessionCheck()) {
	if($_SESSION['memberLoginInfo']['ref_url']){
		cmLocationChange($_SESSION['memberLoginInfo']['ref_url']);
	}else{
		cmLocationChange("mypage.html");
	}
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_detail.php"); ?>
<title>予約方法の選択 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
<div id="wrapper" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="content">

    <ul id="panlist">
        <li><a href="index.html">TOP</a></li>
        <li><span>会員ログイン</span></li>
    </ul>

	<section id="login_box">
		<h1>会員ログインして予約へ</h1>
		<div class="inner">
        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
        		<?php
						if ($memberInput->getErrorCount() > 0) {
						?>
								<?=create_error_caption($memberInput->getError())?>
						<?php
						}
				?>
			<div class="input_field">
				<ul class="box">
					<li class="title">
						<p>メールアドレス</p>
					</li>
					<li class="case">
                    				<?=$inputs->text("MEMBER_LOGIN_ID",$memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_ID"),"imeDisabled ", 30)?>
                    				<?php print create_error_msg($memberInput->getErrorByKey("MEMBER_LOGIN_ID"))?>
					</li>
				</ul>
				<ul class="box">
					<li class="title">
                    			<p>パスワード</p>
					</li>
					<li class="case">
                    				<?=$inputs->password("MEMBER_LOGIN_PASSWORD",$memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_PASSWORD"),"imeDisabled", 30)?>
						<?php print create_error_msg($memberInput->getErrorByKey("MEMBER_LOGIN_PASSWORD"))?>
					</li>
				</ul>
			</div>
			
			<div class="auto_check">
                    		<p><?php print $inputs->checkbox("loginAuto","loginAuto","auto",$memberInput->getByKey($memberInput->getKeyValue(),"loginAuto")," 次回から自動でログイン")?></p>
			</div>
			
			<div class="btn_login">
				<p>
					<?=$inputs->submit("","login","会員ログイン", "circle")?>
					<?php print $inputs->hidden('ref_url', $_SESSION['ref_url']);?>
				</p>
			</div>

                <?php
                if ($_POST) {
					foreach ($_POST as $k=>$v) {
						if ($k == "MEMBER_LOGIN_ID" or $k == "MEMBER_LOGIN_PASSWORD" or $k == "loginAuto" or $k == "login") continue;
						print $inputs->hidden($k, $v);
					}
				}
                ?>
           	</form>
           	
			<div class="pass_link">
				<a href="/reissue-password.html">
					<p>
						※パスワードを忘れた場合はこちら
					</p>
				</a>
			</div>
		</div>
	</section>

	<section id="regist_box">
		<h2>新規会員登録する</h2>
		<div class="inner">
			<a href="/regist.html">
				<p>
					新規会員登録はこちら
				</p>
			</a>
		</div>
	</section>

	<section id="normal_box">
		<h2>会員登録せずに予約</h2>
		<div class="inner">
			<a href="">
				<p>
					会員登録なしで予約へ進む
				</p>
			</a>
		</div>
	</section>





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
