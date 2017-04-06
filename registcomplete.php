<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta201505.php"); ?>
<title>会員登録 仮登録完了 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
        <section class="box">
        	<h2 class="title"><img src="<?php print URL_PUBLIC?>images/regist2.png" width="207" height="29" alt="仮登録完了"></h2>
		<img src="images/intro/step2.png">
        	<p>ご入力頂いたメールアドレス宛てに会員登録ページのURLを記載したメールを送信しました。</p>
        	<p>メールに記載されているURLをクリックして頂き、会員情報の入力へお進み下さい。</p>
        	<p>※メールが届かない場合は、「cocotomo.net」のドメイン解除設定がされていないか、<br/>
		　誤ったアドレスが入力されている可能性がございます。正しいアドレスを再度入力いただくか、<br/>
		ドメイン解除設定後、info@cocotomo.netまでご連絡ください。</p>
        	<div class="logout">→<a href="<?php print URL_PUBLIC?>">TOPページへ</a></div>
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
