<?php
require_once('includes/applicationInc.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
/*require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('login.php');
	exit;
}*/

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>職業相談お問い合わせ ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="予約,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="ホテルの予約ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<style type="text/css">
#formWrap {
	width:950px;
	margin:0 auto;
	color:#555;
	line-height:120%;
	font-size:90%;
}
table.formTable{
	width:100%;
	margin:0 auto;
	border-collapse:collapse;
}
table.formTable td,table.formTable th{
	border:1px solid #ccc;
	padding:10px;
}
table.formTable th{
	width:30%;
	font-weight:normal;
	background:#efefef;
	text-align:left;
}
</style>
</head>
<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->
<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="detail_n" class="reservation_n">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>職業相談お問い合わせ</span></li>
        </ul>

<div id="formWrap">
  <h3>職業相談お問い合わせ</h3>
  <p>下記フォームに必要事項を入力後、確認ボタンを押してください。※以下に内容を追加していきます。</p>
  <form method="post" action="mail.php">
    <table class="formTable">
      <tr>
        <th>ご用件</th>
        <td><select name="お問い合わせ種類">
            <option value="職業相談ご希望">職業相談ご希望</option>
           <!-- <option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
            <option value="リンクについて">リンクについて</option>-->
          </select></td>
      </tr>
      <tr>
        <th>お名前</th>
        <td>姓<input size="10" type="text" name="姓" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?>" />名<input size="10" type="text" name="名" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2")?>" /> ※必須</td>
      </tr>
      <tr>
        <th>お名前（カナ）</th>
        <td>セイ<input size="10" type="text" name="セイ" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1")?>" />メイ<input size="10" type="text" name="メイ" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2")?>" /> ※必須</td>
      </tr>
      <tr>
        <th>電話番号（半角）</th>
        <td><input size="20" type="text" name="電話番号" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1")?>" />(例）000-0000-0000</td>
      </tr>
      <tr>
        <th>Mail（半角）</th>
        <td><input size="20" type="text" name="Email" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID")?>" /> ※必須</td>
      </tr>
      <tr>
        <th>性別</th>
        <td><input type="radio" name="性別" value="男性" /> 男性　
          <input type="radio" name="性別" value="女性" /> 女性 </td>
      </tr>
      <tr>
        <th>生年月日</th>
        <td>西暦<input size="5" type="text" name="西暦" /> 年<input size="5" type="text" name="月" /> 月<input size="5" type="text" name="日" /> 日　※必須</td>
      </tr>
      <tr>
        <th>現住所（都道府県）</th>
        <td><select name="現住所">
            <option value="沖縄県">沖縄県</option>
          </select></td>
      </tr>
      <tr>
        <th>希望の就業地域</th>
        <td><input type="radio" name="地域" value="県内" /> 県内　
          <input type="radio" name="地域" value="県外" /> 県外 </td>
      </tr>
        <th>最終学歴</th>
        <td><select name="最終学歴">
            <option value="選択してください">選択してください</option>
            <option value="大学院">大学院</option>
            <option value="大学">大学</option>
            <option value="高専">高専</option>
            <option value="短大">短大</option>
            <option value="専門各種学校">専門各種学校</option>
            <option value="高校">高校</option>
            <option value="その他">その他</option>
            <!--<option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
            <option value="リンクについて">リンクについて</option>-->
          </select></td>
      </tr>
      <tr>
        <th>現在の状況をお教えください(複数選択可)</th>
        <td><input name="現在の状況[]" type="checkbox" value="求職中" /> 求職中　
          <input name="現在の状況[]" type="checkbox" value="他社にて就業中" /> 他社にて就業中　
          <input name="現在の状況[]" type="checkbox" value="休職中" /> 休職中　
          <input name="現在の状況[]" type="checkbox" value="その他" /> その他</td>
      </tr>
      <tr>
        <th>ご相談内容<br /></th>
        <td><textarea name="ご相談内容" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
    <p align="center">
      <input type="submit" value="　 確認 　" />　<input type="reset" value="リセット" />
    </p>
  </form>
  <p>※IPアドレスを記録しております。いたずらや嫌がらせ等はご遠慮ください</p>
</div>
</main>
</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->
</body>
</html>