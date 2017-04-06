<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$dbMaster = new dbMaster();


$sess = new sessionMember($dbMaster);
$sess->start();

$key1 = cmIdCheck("MEMBER_KEY1");
$key2 = cmKeyCheck("MEMBER_KEY2");

$flgdata = false;

// $collection = new collection($dbMaster);
// $collection->setByKey($collection->getKeyValue(), "MEMBER_STATUS1", 1);
// $memberRegista = new member($dbMaster);
// $memberRegista->selectList($collection);
// print_r($memberRegista->getCollection());

$memberRegist = new member($dbMaster);

if ($key1 != "" and $key2 != "") {
	$memberRegist->select("", "1", $key1, $key2);
	if ($memberRegist->getCount() == 1) {
		$flgdata = true;
		$memberRegist->setByKey($memberRegist->getKeyValue(), "MEMBER_STATUS", 2);
		$memberRegist->setPost();
	}
}
else {
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
<title>新規会員登録 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<script src="<?php print URL_SLAKER_COMMON?>js/ajaxzip3.js" type="text/javascript"></script>
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

<?php if ($flgdata) {?>
        		<?php
			if ($memberRegist->getByKey($memberRegist->getKeyValue(), "regist") and $memberRegist->getErrorCount() <= 0) {?>

				<ol class="stepBar step5">
				<li class="step">仮登録メール送信</li>
				<li class="step">メールを受信</li>
				<li class="step">登録情報の入力</li>
				<li class="step">入力内容の確認</li>
				<li class="step current">登録の完了</li>
				</ol>
				
					<div class="inner">
						<p class="notice">会員登録が完了しました。</p>
						<p>ログインページよりご登録のメールアドレス、パスワードでログインしてください。</p>
						<p class="btn"><a href="<?php print URL_PUBLIC?>login.html">会員ログインページへ</a></p>
					</div>

						<a href="/"><p class="btn_top">TOPページへ</p></a>

			<?php }else {?>
				
				<ol class="stepBar step5">
				<li class="step">仮登録メール送信</li>
				<li class="step">メールを受信</li>
				<li class="step current">登録情報の入力</li>
				<li class="step">入力内容の確認</li>
				<li class="step">登録の完了</li>
				</ol>
					<div class="inner">
						<p>現在、仮登録の状態となっています。</p>
			        		<p>登録情報、設定するパスワードを入力の上、「登録する」ボタンをクリックしてください。</p>
			        		<br />
						<?php require("includes/box/member/inputRegist.php");?>
					</div>
					
			<?php } ?>



  <?php }else {?>
           	
			<ol class="stepBar step5">
			<li class="step current">仮登録メール送信</li>
			<li class="step">メールを受信</li>
			<li class="step">登録情報の入力</li>
			<li class="step">入力内容の確認</li>
			<li class="step">登録の完了</li>
			</ol>
          	
				<div class="inner">
			           	<p class="alert">【！】仮登録のデータが見つかりませんでした。</p>
			           	<p>URLが間違っているか、既に登録済みである可能性があります。</p>
				</div>
						<a href="/"><p class="btn_top">TOPページへ</p></a>

		<?php }?>
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
