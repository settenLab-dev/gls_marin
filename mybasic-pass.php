<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

/*
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	cmLocationChange("login.html");
}
*/

$memberRegist = new member($dbMaster);

$flgdata = false;

$memberRegist->select($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_ID"), "2");
if ($memberRegist->getCount() == 1) {
	$flgdata = true;
	$memberRegist->setByKey($memberRegist->getKeyValue(), "MEMBER_STATUS", 2);
	$memberRegist->setPost();
}

$memberRegist->check(false);

if ($memberRegist->getByKey($memberRegist->getKeyValue(), "regist") and $memberRegist->getErrorCount() <= 0) {
	if (!$memberRegist->save()) {
		$memberRegist->setErrorFirst("会員情報の保存に失敗しました。");
		$memberRegist->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
	}
}


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta_detail.php"); ?>
<title>会員基本情報 ｜ <?php print SITE_PUBLIC_NAME?></title>
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

        <!--日付・人数から検索-->
        <section class="box">
        	<h2 class="title">登録情報の設定</h2>
        	<p>こんにちは！ <?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?>さん。</p>
        	<p>以下より会員情報の基本確認・編集を行うことができます。</p>
        	<br />

        	<?php
					if ($memberRegist->getByKey($memberRegist->getKeyValue(), "regist") and $memberRegist->getErrorCount() <= 0) {
				?>
				<p>会員情報を保存しました。</p>
			<?php
				}
				else {
					require("includes/box/member/inputRegist-pass.php");
				}
			?>
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
