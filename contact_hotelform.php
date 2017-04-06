<?php
require_once('includes/applicationInc.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
//require("includes/box/login/loginAction.php");
//if (!$sess->sessionCheck()) {
//	require_once('login.php');
//	exit;
//}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta_new1.php"); ?>
<title>求人応募フォーム ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="予約,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="求人応募フォームです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="<?php print URL_PUBLIC?>css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print URL_PUBLIC?>js/jquery-ui-1.10.3.custom.min.js"></script>
<meta http-equiv="Content-Style-Type" content="text/css" />
<style type="text/css">
#formWrap {
	width:950px;
	margin:0 auto;
	color:#0000;
	line-height:120%;
	font-size:100%;
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
	background:#ecffe3;
	text-align:left;
}
input[type="checkbox"].ExpandCheckBox {
  display: none;
}
 
input[type="checkbox"].ExpandCheckBox + .ExpandHeader {
  display:block;
 
  text-align:left;

  background-color:#ffcf72;
 
  border:solid 1px #ffcf72;
}
 
input[type="checkbox"].ExpandCheckBox:checked + .ExpandHeader {
  display:block;
 
  text-align:left;
  background-color:#ffcf72;
   
}
 
 
input[type="checkbox"].ExpandCheckBox + label + div.panel1,
input[type="checkbox"].ExpandCheckBox + label + div.panel2,
input[type="checkbox"].ExpandCheckBox + label + div.panel3,
input[type="checkbox"].ExpandCheckBox + label + div.panel4,
input[type="checkbox"].ExpandCheckBox + label + div.panel5,
input[type="checkbox"].ExpandCheckBox + label + div.panel6,
input[type="checkbox"].ExpandCheckBox + label + div.panel7,
input[type="checkbox"].ExpandCheckBox + label + div.panel8,
input[type="checkbox"].ExpandCheckBox + label + div.panel9
{
  display: none;
}
 
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel1,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel2,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel3,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel4,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel5,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel6,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel7,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel8,
input[type="checkbox"].ExpandCheckBox:checked + label + div.panel9 {
  display: block;
}
</style>
</head>
<body id="top">

<!--header-->
<?php require("includes/box/common/header_job.php");?>
<!--/header-->
<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_mini" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="detail_n" class="reservation_n">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>求人応募フォーム</span></li>
        </ul>

<div id="formWrap">
  <h3><B>◆求人応募フォーム</B></h3>
  <p>下記フォームに必要事項を入力後、確認ボタンを押してください。</br></br>
本フォームにご記入される個人情報は今回の求人応募のみに使用させていただくものです。</br>
応募先の採用担当者だけに提供され、第三者に公開することは一切ございません。</br>
また、表示・送信される情報はSSLの暗号化技術によって保護されます。</p>
  <form method="post" action="mail_hotelform.php">
    <table class="formTable">
      <tr>
        <th>今回の応募職種</th>
        <td>応募先：ココトモ！リゾートホテル</br>
	  <select name="応募職種">
            <option value="a">①　職種：フロントスタッフ　/　雇用形態：契約社員・パート</option>
            <option value="b">②　職種：レストランスタッフ　/　雇用形態：契約社員・パート</option>
            <option value="c">③　職種：マリンスタッフ/　雇用形態：パート</option>
          </select>
	</td>
      </tr>
    </table>
<br/>
    <table class="formTable">
      <tr>
        <th>お名前 <font color="red">※必須</font></th>
        <td>姓<input size="10" type="text" name="姓" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?>" />名<input size="10" type="text" name="名" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2")?>" /></td>
      </tr>
      <tr>
        <th>フリガナ <font color="red">※必須</font></th>
        <td>セイ<input size="10" type="text" name="セイ" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1")?>" />メイ<input size="10" type="text" name="メイ" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2")?>" /></td>
      </tr>
      <tr>
        <th>性別 <font color="red">※必須</font></th>
        <td><input type="radio" name="性別" value="男性" /> 男性　
          <input type="radio" name="性別" value="女性" /> 女性 </td>
      </tr>
      <tr>
        <th>生年月日 <font color="red">※必須</font></th>
        <td>西暦<input size="5" type="text" name="西暦" /> 年<input size="5" type="text" name="月" /> 月<input size="5" type="text" name="日" /> 日</td>
      </tr>
      <tr>
        <th>年齢(半角数字) <font color="red">※必須</font></th>
        <td><input size="5" type="text" name="年齢" /> 歳</td>
      </tr>
    </table>
<br/>
  <h3>▼ご連絡先</h3>
    <table class="formTable">
      <tr>
        <th>Mail（半角）<font color="red">※必須</font></th>
        <td><input size="20" type="text" name="Email" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID")?>" /></td>
      </tr>
      <tr>
        <th>ご住所 <font color="red">※必須</font></th>
        <td><input size="5" type="text" name="都道府県" value="沖縄県" /><input size="20" type="text" name="市町村" /></br>建物名<input size="20" type="text" name="建物名" /></td>
      </tr>
       <tr>
        <th>最寄り駅 <font color="red">※必須</font></th>
        <td><input size="10" type="text" name="最寄駅" />駅より
	<select name="移動方法">
            <option value="徒歩">徒歩</option>
            <option value="車">車</option>
            <option value="バイク">バイク</option>
            <option value="モノレール">モノレール</option>
            <option value="バス">バス</option>
            <option value="自転車">自転車</option>
          </select>で<input size="5" type="text" name="移動時間" />分</td>
      </tr>
      <tr>
        <th>自宅電話番号（半角）<font color="red">※必須</font></th>
        <td><input size="20" type="text" name="自宅電話番号" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1")?>" />※携帯電話のみの方はこちらへご記入ください。</td>
      </tr>
      <tr>
        <th>携帯電話番号（半角）</th>
        <td><input size="20" type="text" name="携帯電話番号" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL2")?>" /></td>
      </tr>
      <tr>
        <th>同居されているご家族の状況(該当するもの全て選択) <font color="red">※必須</font></th>
        <td><input name="ご家族の状況[]" type="checkbox" value="単身" /> 単身　
          <input name="ご家族の状況[]" type="checkbox" value="親・兄弟姉妹と同居" /> 親・兄弟姉妹と同居　
          <input name="ご家族の状況[]" type="checkbox" value="配偶者あり" /> 配偶者あり　
          <input name="ご家族の状況[]" type="checkbox" value="子供あり" /> 子供あり</td>
      </tr>
    </table>
<br/>
  <h3>▼学歴・資格など</h3>
    <table class="formTable">
        <th>最終学歴 <font color="red">※必須</font></th>
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
        <th>上記卒業校名 <font color="red">※必須</font><br /></th>
        <td><input type="text" size="30" name="卒業校名" /></td>
      </tr>
      <tr>
        <th>学部・学科など <font color="red">※必須</font><br /></th>
        <td><input type="text" size="30" name="卒業校名" /></td>
      </tr>
      <tr>
        <th>卒業年月 <font color="red">※必須</font><br /></th>
        <td>西暦<input type="text" size="5" name="卒業年" />年 <input type="text" size="5" name="卒業月" />月</td>
      </tr>
      <tr>
        <th>その他学歴<br /></th>
        <td>※在学中の学校名/学部/学科/学年/卒業見込み年月・留学・修士課程等／在学中や中途退学など<br/>
		<textarea name="その他学歴" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
<br/>
  <h3>▼語学・パソコンスキルなど</h3>
    <table class="formTable">
      <tr>
        <th>英語の資格</th>
        <td>
	TOEIC<input type="text" size="5" name="toeic" />点　TOEFL<input type="text" size="5" name="toefl" />点　英語検定(STEP)<input type="text" size="5" name="英検" />級<br/><br/>
	英会話によるコミュニケーションのレベルを教えてください。<br/>
	<select name="英語">
		<option value="ビジネス">ビジネス英会話レベル</option>
		<option value="日常会話">日常会話レベル</option>
		<option value="サービス">サービスで使えるレベル</option>
		<option value="挨拶">挨拶ができるレベル</option>
	</select>
      </tr>
      <tr>
        <th>英語以外の外国語</th>
        <td><textarea name="外国語" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>使用可能なOS</th>
        <td><input name="OS[]" type="checkbox" value="Windows" /> Windows　
          <input name="OS[]" type="checkbox" value="Mac" /> Mac　
          <input name="OS[]" type="checkbox" value="Unix" /> Linux(UNIX系）　
          <input name="OS[]" type="checkbox" value="Android" /> Android　
          <input name="OS[]" type="checkbox" value="iOS" /> iOS　
          <input name="OS[]" type="checkbox" value="その他" /> その他</td>
      </tr>
      <tr>
        <th>使用可能なソフト</th>
        <td><input name="使用ソフト[]" type="checkbox" value="word" /> Word　
          <input name="使用ソフト[]" type="checkbox" value="excel" /> Excel　
          <input name="使用ソフト[]" type="checkbox" value="powerpoint" /> Powerpoint　
          <input name="使用ソフト[]" type="checkbox" value="access" /> Access　
          <input name="使用ソフト[]" type="checkbox" value="photohop" /> Photoshop　
          <input name="使用ソフト[]" type="checkbox" value="illustrator" /> Illustrator</td>
      </tr>
      <tr>
        <th>使用可能なホテル関連ソフト</th>
        <td><input name="ホテルソフト[]" type="checkbox" value="Fidelio" /> Fidelio　
          <input name="ホテルソフト[]" type="checkbox" value="NEHOPS" /> NEHOPS　
          <input name="ホテルソフト[]" type="checkbox" value="その他" /> その他　
      </tr>
       <tr>
        <th>その他使用可能ソフト</th>
        <td><textarea name="その他ソフト" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
<br/>
  <h3>▼その他資格</h3>
    <table class="formTable">
      <tr>
        <th>取得資格など<br /></th>
        <td><textarea name="取得資格など" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
</br>
  <h3>▼自己PR・その他</h3>
    <table class="formTable">
      <tr>
        <th>入社可能時期 <font color="red">※必須<br /></th>
        <td><input type="text" size="30" name="入社時期" /></td>
      </tr>
      <tr>
        <th>現在の年収</th>
        <td><br/><input type="text" size="10" name="年収" />万円　※ご記入の内容は応募先企業に公開されます。</td>
      </tr>
      <tr>
        <th>自己PR <font color="red">※必須<br /></th>
        <td><textarea name="PR" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考</th>
        <td>寮、単身赴任、その他、応募先企業へのご希望やご質問をご記入ください。<br/>
	<textarea name="備考" cols="50" rows="5"></textarea></td>
      </tr>
    </table>

<br/>
  <h3>▼職務経歴①（最近のものよりご記入ください。最大10件まで入力可能です。）</h3>
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名1" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名1" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種1" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年1">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月1">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年1">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月1">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種1" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職1">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態1">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容1" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考1" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
</br>
 <input type="checkbox" id="Panel1" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel1">▼職務経歴②　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel1">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名2" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名2" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種2" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年2">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月2">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年2">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月2">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種2" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職2">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態2">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容2" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考2" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel2" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel2">▼職務経歴③　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel2">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名3" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名3" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種3" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年3">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月3">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年3">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月3">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種3" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職3">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態3">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容3" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考3" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel3" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel3">▼職務経歴④　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel3">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名4" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名4" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種4" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年4">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月4">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年4">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月4">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種4" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職4">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態4">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容4" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考4" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel4" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel4">▼職務経歴⑤　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel4">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名5" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名5" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種5" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年5">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月5">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年5">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月5">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種5" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職5">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態5">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容5" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考5" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel5" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel5">▼職務経歴⑥　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel5">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名6" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名6" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種6" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年6">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月6">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年6">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月6">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種6" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職4">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態6">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容6" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考6" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel6" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel6">▼職務経歴⑦　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel6">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名7" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名7" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種7" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年7">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月7">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年7">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月7">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種7" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職7">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態7">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容7" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考7" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel7" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel7">▼職務経歴⑧　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel7">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名8" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名8" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種8" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年8">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月8">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年8">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月8">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種8" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職8">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態8">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容8" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考8" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel8" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel8">▼職務経歴⑨　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel8">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名9" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名9" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種9" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年9">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月9">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年9">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月9">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種9" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職9">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態9">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容9" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考9" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel9" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel9">▼職務経歴⑩　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel9">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="企業名10" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="施設名10" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="業種10" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="在職年10">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="在職月10">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="退職年10">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="退職月10">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="職種10" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="役職10">
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="部長">部長(ディレクタークラス)</option>
            <option value="課長">課長(マネージャー、店長)</option>
            <option value="係長">係長・アシスタントマネージャー</option>
            <option value="主任">主任(キャプテンクラス)</option>
            <option value="スタッフ">従業員・スタッフ</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="雇用形態10">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="職務内容10" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="職務備考10" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
<br/>
<br/>
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
<?php require("includes/box/common/footer_n.php");?>
<!--/footer-->
</body>
</html>