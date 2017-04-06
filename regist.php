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
$memberRegist->checkRegist1();

if ($memberRegist->getByKey($memberRegist->getKeyValue(), "mailsend") and $memberRegist->getErrorCount() <= 0) {
	if (!$memberRegist->saveRegist()) {
		$memberRegist->setErrorFirst("会員情報の保存に失敗しました。");
		$memberRegist->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
	else {
		cmLocationChange("registcomplete.html");
	}
}

print $_SERVER['HTTP_X_DCMGUID'];
print $_SERVER['HTTP_X_UP_SUBNO'];
print $_SERVER['HTTP_X_JPHONE_UID'];


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_detail.php"); ?>
<title>【無料】新規会員登録 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
        <li><span>新規会員登録</span></li>
    </ul>


        <section id="regist_mail">
        	<h1>新規会員登録</h1>

			<ol class="stepBar step5">
			<li class="step current">仮登録メール送信</li>
			<li class="step">メールを受信</li>
			<li class="step">登録情報の入力</li>
			<li class="step">入力内容の確認</li>
			<li class="step">登録の完了</li>
			</ol>

        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
				<div class="inner">
					<p class="coment">会員登録するメールアドレス(ID)を入力してください。<br>
						入力したメールアドレス宛に仮登録メールが届きます。<br>
						メール受信制限をされている方は playbooking.jp からのメール受信を許可してください。</p>
					<ul class="box">
						<li class="title">
							<p>登録メールアドレス</p>
						</li>
						<li class="case">
								<?=$inputs->text("MEMBER_LOGIN_ID",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_ID"),"imeDisabled ", 50)?>
								<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_ID"))?>						
						</li>						
					</ul>
			   
					<div class="text_link">
					<ul class="link">
						<li>
							<a href="/member-term.html"><p>【会員規約】</p></a>
						</li>
						<li>
							<a href="/privacy.html"><p>【プライバシーポリシー】</p></a>					
						</li>						
					</ul>
					</div>
				   <div class="btn_regist">
							<?=$inputs->submit("","mailsend","上記に同意して仮登録メールを送信", "circle")?>
				   </div>
				</div>
           	</form>
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
