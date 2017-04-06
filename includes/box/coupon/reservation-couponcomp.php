<?php
require_once('includes/applicationInc.php');
//  EPSILON クレジットカード認証完了、コンビニ受付番号発行完了
//  クライアント側プログラム(PHP版)
//
//  このプログラムの実行には、以下のモジュールが必要です。
//  ・PHP(ver5,,,,,
//  ・PEAR:
//  ・PEAR:HTTP_Request:
//  ・PEAR:Net_URL:
//  ・PEAR:Net_Socket:
//  ・PEAR:XML_Parser:
//  ・PEAR:XML_Serializer:
//

//include Libraly
//PEAR拡張モジュールの読み込み。
//既に該当のモジュールをインストール済みの場合は適宜読み込み先パスを変更してください。
require_once "HTTP/Request.php";
require_once "XML/Unserializer.php";

//char setting
//サーバ環境に応じ適宜変更してください。
mb_language("Japanese");
mb_internal_encoding("EUC-JP");

// 変数の設定

// オーダー情報確認CGIのURL(試験用)
// オーダー情報確認CGIについては2種類ありますのでご注意お願いいたします。
// 詳細はCGI設定マニュアルの「オーダー情報確認CGI-1,2」をご確認願います。
// 各CGIの説明
// CGI-1:認証にパスワード要/発信元IP無制限
// CGI-2:認証にパスワード不要/発信元IPの制限有

// 以下にはCGI-1と2で設定パラメータが相違しますので利用されるCGIによって変更してください。

// 接続先URLの設定

// CGI-1利用の場合 本番環境への接続の場合は契約後弊社からご連絡いたしますURLに変更してください
$getsales_url = 'https://beta.epsilon.jp/client/getsales.cgi';
// CGI-2利用の場合 本番環境への接続の場合は契約後弊社からご連絡いたしますURLに変更してください
//my $getsales_url = 'https://beta.epsilon.jp/cgi-bin/order/getsales2.cgi';

// 発行されたユーザーID(契約コード)を入力してください
// CGI-1,2共通
$user_id = '61002840';

// 発行されたパスワードを入力してください。
// CGI-1利用の場合 弊社からお知らせしたパスワードを設定してください。
// CGI-2利用の場合 当値は利用しませんので適当な値を設定してください。txZaDA9o,j6ralKCA
$passwd  = 'EwFjtnXI';

// エラーが発生した場合のメッセージ
$err_msg;

// オーダー情報取得CGIを実行した結果を格納する連想配列
$responce = array();

// 各支払い方法
$payment_name = array(
   1 => "クレジットカード決済",
   2 => "クレジットカード決済",
   3 => "コンビニ決済",
   4 => "ネット銀行決済(ジャパンネット銀行)",
   5 => "ネット銀行決済(e-bank)",
   7 => "ペイジー",
   8 => "WebMoney",
   9 => "Do-Link決済",
   12 => "BitCash決済",
   13 => "電子マネーちょコム");

// コンビニ・ペイジー支払の場合の支払い方法の簡単な説明
$setsumei = array(
    # セブンイレブン
    11 => "以下の払込票ページをプリントアウトされるか、払込票番号をメモして<br>" . 
          "最寄りのセブンイレブンのレジにてお支払いください。<br>" ,
    # ファミリーマート
    21 => "ファミリーマート店頭にございます Famiポート／ファミネットにて<br>" .
          "以下の２つの数字をご入力頂き、発行されるFamiポート申込券をレジまで<br>" .
          "お持ちになり代金をお支払いください。<br>",
    # ローソン
    31 => "ローソンの店内に設置してあるLoppiのトップ画面の中から、「インターネット受付」<br>" .
          "をお選びください。次画面のジャンルの中から「インターネット受付」をお選び頂き、<br>" .
          "画面に従って以下の「お支払い受付番号」と、ご登録頂いた「電話番号」をご入力下さい。<br>" ,
    # セイコーマート
    32 => "セイコーマートの店内に設置してあるセイコーマートクラブステーション（情報端末）の<br>" .
          "トップ画面の中から、「インターネット受付」をお選び下さい。画面に従って以下の<br>" .
          "「お支払い受付番号」と、ご登録頂いた「電話番号」をご入力下さい。<br>" ,
    # ペイジー
    88 => "ペイジーでお支払い頂く際には銀行のATMもしくはオンラインバンキングで<br>お支払いただく方法がございます。<BR>" .
          "ご利用可能な銀行につきましては以下リンクでご確認お願いいたします。<BR><BR>".
          "<a href='http://www.epsilon.jp/service/payeasy_list.html' target='_blank'>ペイジーお支払可能銀行一覧</a><BR><BR>".
          "お支払可能な銀行、オンラインバンキングで「収納機関番号」、「確認番号」、<br>ご登録いただいた「電話番号」を入力の上ご入金お願いします。" );

// パラメータとして渡される(GET)トランザクションコードを取得します。
$trans_code = $_REQUEST['trans_code'];


// 結果問い合わせ用HTTPリクエスト送信

// CGI-1利用の場合 
// ※オーダー情報確認CGIの実行にはベーシック認証が必要です。 
$request = new HTTP_Request($getsales_url);
$request->setMethod(HTTP_REQUEST_METHOD_POST);
$request->addHeader("Content-Type","application/x-www-form-urlencoded");
$request->setBody("trans_code=" . $trans_code);

$request->setBasicAuth($user_id, $passwd);
$response = $request->sendRequest();


// CGI-2利用の場合 
//$request = new HTTP_Request($getsales_url);
//$request->setMethod(HTTP_REQUEST_METHOD_POST);
//$request->addHeader("Content-Type","application/x-www-form-urlencoded");
//$request->setBody("trans_code=" . $trans_code . "&contract_code=" . $user_id);
//$response = $request->sendRequest();

// 以降はCGI-1,2どちらも共通です。

if (PEAR::isError($response)) {
  // インターフェイスCGIの実行に失敗した場合
  	$err_msg = "データの送信に失敗しました<br><br>";
  	$err_msg .= "<br />res_statusCd=" . $request->getResponseCode();
  	$err_msg .= "<br />res_status=" . $request->getResponseHeader('Status');
	echo $err_msg;
    exit;
}


// CGIの実行に成功した場合、応答内容(XML)を解析します
    // 応答内容(XML)の解析
  	
$res_code = $request->getResponseCode();
$res_content = $request->getResponseBody();

//xml unserializer
$temp_xml_res = str_replace("x-sjis-cp932", "UTF-8", $res_content);
$unserializer =& new XML_Unserializer();
$unserializer->setOption('parseAttributes', TRUE);
$unseriliz_st = $unserializer->unserialize($temp_xml_res);
if ($unseriliz_st === true) {
	//xmlを解析
	$res_array = $unserializer->getUnserializedData();
	//error check
	if($res_array['result']['result'] == "0"){
		echo "処理に失敗しました<br><br>";
    	exit(1);
	}

	$res_param_array = array();
	//pram setting
	foreach($res_array['result'] as $uns_k => $uns_v){
		list($result_atr_key, $result_atr_val) = each($uns_v);
		$res_param_array[$result_atr_key] = mb_convert_encoding(urldecode($result_atr_val), "UTF-8" ,"auto");
	}
	$debug_printj .=  "<br />xml_memo2_msg=" . $xml_memo2_msg;
	
}else{
	//xml parser error
  	echo "xml parser error<br><br>";
    exit(1);
}
$result_html;

if ($res_param_array['payment_code'] == 3){
  // コンビニ支払の場合
  if ($res_param_array['conveni_code'] == 11){
    // セブンイレブンの場合
    $result_html = $setsumei[11] . "<br><br>\n";
    $result_html .= "払込票 : <a href=\"" . $res_param_array['haraikomi_url'] . "\">ここをクリック</a>  <br>\n";
    $result_html .= "払込票番号 : " . $res_param_array['receipt_no'] . "<br>\n";
  }
  elseif ($res_param_array['conveni_code'] == 21){
    // ファミリーマートの場合
    $result_html = $setsumei[21] . "<br><br>\n";
    $result_html .="企業コード： " . $res_param_array['kigyou_code'] . "<br>\n";
    $result_html .= "注文番号 : " . $res_param_array['receipt_no'] . "<br>\n";
  }
  elseif (($res_param_array['conveni_code'] == 31) || ($res_param_array['conveni_code'] == 32)){
    // ローソン、セイコーマートの場合
    $result_html = $setsumei{$res_param_array{'conveni_code'}} . "<br><br>\n";
    $result_html .= "お支払い受付番号 : " . $res_param_array['receipt_no'] .  "<br>\n";
  }
  else {  // 不明(異常)
    print_html("支払情報の取得に失敗しました $res_param_array{'conveni_code'}");
    exit(0);
  }
  $conveni_limit_date = split("-",$res_param_array['conveni_limit']);
  $result_html .= "<br>支払期限：" . $conveni_limit_date[0] . "年"
                . $conveni_limit_date[1] . "月" . $conveni_limit_date[2] . "日<br>\n";
  print_html("",$payment_name[$res_param_array['payment_code']],mb_convert_encoding(urldecode($res_param_array['item_name']), "UTF-8" ,"auto"),$res_param_array['item_price'],$result_html);
  exit (0);
}
elseif ($res_param_array['payment_code'] == 7 ){
  // ペイジーの場合
  $result_html = $setsumei[88] . "<br><br>\n";
  $result_html .= "収納機関番号： " . $res_param_array['kigyou_code'] . "<br>\n";
  $result_html .= "確認番号 : " . $res_param_array['receipt_no'] .  "<br>\n";
  print_html("",$payment_name[$res_param_array['payment_code']],mb_convert_encoding(urldecode($res_param_array['item_name']), "UTF-8" ,"auto"),$res_param_array['item_price'],$result_html);
  exit(0);
}
else {
  // それ以外の決済の場合
  print_html("",$payment_name[$res_param_array['payment_code']],mb_convert_encoding(urldecode($res_param_array['item_name']), "UTF-8" ,"auto"),$res_param_array['item_price'],"ご注文ありがとうございました。");
  exit(0);
}


// HTML出力
function print_html($err_msg,$payment_name,$item_name,$item_price,$result_setsumei){?>

<!doctype html><html>
<!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!--<link href="/css/style.css" rel="stylesheet" type="text/css">-->
<link rel="stylesheet" href="/common/css/common.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/css/base.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/css/style_new.css" type="text/css" media="screen" />
<!--<link rel="stylesheet" href="/css/new-style.css" type="text/css" media="screen" />-->
<link rel="stylesheet" href="/js/slider/jquery.bxslider.css" type="text/css" media="screen">
<link href="/js/scroller/li-scroller_n.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
<script src="/js/scroller/jquery.li-scroller.1.0.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/slider/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/js/function.js"></script>

<!--[if lt IE 9]>
<script src="/js/html5shiv.js"></script>
<script src="/js/PIE.js"></script>
<![endif]-->
<title>クーポン購入完了しました ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="クーポン購入,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="クーポン購入ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.min.js"></script>
</head>

<body id="top">

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_short" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="detail" class="reservation">

        <div class="mainbox">
<table class=S1 width="500" border="0" cellpadding="0" cellspacing="0">
<tr class=S1><td class=S1>
<table class=S1 width="100%" cellpadding="6" align=center>
<tr class=S1><th class=S1 align=left><big> 完了画面</big></th></tr>
</table>

<br>
決済方法：${payment_name}<br><br>
商品名: ${item_name}<br>
価格: ${item_price}円<br><br>

${result_setsumei}
<br>${err_msg}
<input type="image" src="images/reservation/coupon-submit2.jpg" id="btn" >
					
</td></tr>
</table>
        </div>

	</main>
	<!-- InstanceEndEditable -->
    <!--/main-->


</div>
<!--/content-->

</body>
<!-- InstanceEnd --></html>
<?php } ?>