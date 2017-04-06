<?php
require_once('includes/applicationInc.php');

//  EPSILON オーダー情報送信プログラム(PHP版)
//
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
require_once "http/Request.php";
require_once "xml/Unserializer.php";

//char setting
//サーバ環境に応じ適宜変更してください。
mb_language("Japanese");
mb_internal_encoding("EUC-JP");


// 変数の初期化

// FORMで送信した内容をこのプログラムファイルで受け取るために、プログラムファイルの名前を設定します。
$my_self = "settlement.php"; 

// オーダー情報送信先URL(試験用)
// 本番環境でご利用の場合は契約時に弊社からお送りするURLに変更してください。
$order_url = "https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi";

//// 以下の各項目についてご利用環境に沿った設定に変更してください

// 契約番号(8桁) オンライン登録時に発行された契約番号を入力してください。
$contract_code = "61002840";

// 注文番号(注文毎にユニークな番号を割り当てます。ここでは仮に乱数を使用しています。)
$order_number = rand(0,99999999);

// 決済区分 (使用したい決済方法を指定してください。登録時に申し込まれていない決済方法は指定できません。)
$st_code = '11000-0000-00000-00000-00000-00000-00000';   // 指定方法はCGI設定マニュアルの「決済区分について」を参照してください。

// 課金区分 (1:一回のみ 2～10:月次課金)
// 月次課金について契約がない場合は利用できません。また、月次課金を設定した場合決済区分はクレジットカード決済のみとなります。
$mission_code = 1;

// 処理区分 (1:初回課金 2:登録済み課金 3:登録のみ 4:登録変更 8:月次課金解除 9:退会)
// 月次課金をご利用にならない場合は1:初回課金をご利用ください。
// 各処理区分のご利用に関してはCGI設定マニュアルの「処理区分について」を参照してください。
$process_code = 1;

// 追加情報 1,2  (入力は必須ではありません)
$memo1 = "試験用オーダー情報";
$memo2 = "";

// 商品コード (商品毎に識別コードを指定してください。ここでは仮に固定の値を指定しています。)
$item_code = "abc12345";

// 商品リストサンプル
$goods = array( 'mouse' =>
				array('name' => 'マウス', 'price' => '800')
              , 'keyboard' =>
				array('name' => 'キーボード', 'price' => '2980')
              , 'disp' =>
				array('name' => 'ディスプレイ', 'price' => '19800')
              , 'printer' =>
				array('name' => 'プリンタ', 'price' => '34800')
			  , 'camera' =>
				array('name' => 'デジカメ', 'price' => '42000')
             );


//// 変更設定ここまで
             
// エラーが発生した場合のメッセージ
$err_msg;

// オーダー情報を送信した結果を格納する連想配列
$responce = array();

// 商品名、価格
$item_name = "";
$item_price = 0;

// CGIのパラメータを取得

$item = $_REQUEST['item']; // 商品の番号(このCGIの中でのみ使用する値です)

if ($item){
  // 商品リストサンプルの連想配列から、商品名と価格を取り出しています。
// 商品名と価格
$item_name = $goods[$item]['name'];
$item_price = $goods[$item]['price'];

}
// ユーザー固有情報
// ここでは仮にフォームに入力してもらっていますが、ユーザーID等の値はクライアント様側で
// 管理されている値を使用してください。
$user_id = $_REQUEST['user_id'];            // ユーザーID
$user_name = $_REQUEST['user_name'];        // ユーザー氏名
$user_mail_add = $_REQUEST['user_mail_add'];// メールアドレス

// CGIの状態(入力画面から実行されたか、確認画面から実行されたか)を判別する値
$come_from = $_REQUEST['come_from'];        // CGIの状態設定

// パラメータの確認
if ($come_from == 'here'){
  if (empty($item_name)){
    $err_msg = "購入する商品を選択してください <br><br>";
  }
  elseif (empty($user_id)){
    $err_msg = "ユーザーIDを入力してください <br><br>";
  }
  elseif (empty($user_name)){
    $err_msg = "氏名を入力してください <br><br>";
  }
  elseif (empty($user_mail_add)){
    $err_msg = "メールアドレスを入力してください。 <br><br>";
  }
  
  
echo  "<br /><br />" . $err_msg;
    
  
  if (!empty($err_msg)){
    // パラメータに異常がある場合は、もう一度入力画面を表示します。
    order_form();
	exit(1);
  }
  else{
    // パラメータを正常に受け取れた場合は、購入確認画面を表示します。
    kakunin();
    exit(0);
  }
}
elseif ($come_from == 'kakunin'){  // 購入確認画面で[確認]ボタンを押した場合
	
	
  //EPSILONに情報を送信します。

  // httpリクエスト用のオプションを指定
  $option = array(
    "timeout" => "20", // タイムアウトの秒数指定
  //    "allowRedirects" => true, // リダイレクトの許可設定(true/false)
  //    "maxRedirects" => 3, // リダイレクトの最大回数
  );

  // HTTP_Requestの初期化
  $request = new HTTP_Request($order_url, $option);
  
  // HTTPのヘッダー設定
  //$http->addHeader("User-Agent", "xxxxx");
  //$http->addHeader("Referer", "xxxxxx");

  //set method
  $request->setMethod(HTTP_REQUEST_METHOD_POST);
  //set post data
  $request->addPostData('contract_code', $contract_code);
  $request->addPostData('user_id', $user_id);
  $request->addPostData('user_name', mb_convert_encoding($user_name, "EUC-JP", "auto"));
  $request->addPostData('user_mail_add', $user_mail_add);
  $request->addPostData('item_code', $item_code);
  $request->addPostData('item_name', mb_convert_encoding($item_name, "EUC-JP", "auto"));
  $request->addPostData('order_number', $order_number);
  $request->addPostData('st_code', $st_code);

  $request->addPostData('mission_code', $mission_code);
  $request->addPostData('item_price', $item_price);
  $request->addPostData('process_code', $process_code);
  $request->addPostData('memo1', $memo1);
  $request->addPostData('memo2', $memo2);
  $request->addPostData('xml', '1');
  
  // HTTPリクエスト実行
  $response = $request->sendRequest();
  if (!PEAR::isError($response)) {

    // 応答内容(XML)の解析
  	
  	$res_code = $request->getResponseCode();
  	$res_content = $request->getResponseBody();

		//xml unserializer
		$temp_xml_res = str_replace("x-sjis-cp932", "EUC-JP", $res_content);
		$unserializer =& new XML_Unserializer();
		$unserializer->setOption('parseAttributes', TRUE);
		$unseriliz_st = $unserializer->unserialize($temp_xml_res);
		if ($unseriliz_st === true) {
			//xmlを解析
			$res_array = $unserializer->getUnserializedData();
			$is_xml_error = false;
			$xml_redirect_url = "";
			$xml_error_cd = "";
			$xml_error_msg = "";
			$xml_memo1_msg = "";
			$xml_memo2_msg = "";
			foreach($res_array['result'] as $uns_k => $uns_v){
				//$debug_printj .=  "<br />k=" . $uns_k;
	    		list($result_atr_key, $result_atr_val) = each($uns_v);
				//$debug_printj .=  "<br />result_atr_key=" . $result_atr_key;
				//$debug_printj .=  "<br />result_atr_val=" . $result_atr_val;

			    switch ($result_atr_key) {
    			  case 'redirect':
    				$xml_redirect_url = rawurldecode($result_atr_val);
        			break;
			      case 'err_code':
    				$is_xml_error = true;
    				$xml_error_cd = $result_atr_val;
        			break;
    			  case 'err_detail':
					$xml_error_msg = mb_convert_encoding(urldecode($result_atr_val), "EUC-JP" ,"auto");
        			break;
				  case 'memo1':
					$xml_memo1_msg = mb_convert_encoding(urldecode($result_atr_val), "EUC-JP" ,"auto");
        			break;
				  case 'memo2':
					$xml_memo2_msg = mb_convert_encoding(urldecode($result_atr_val), "EUC-JP" ,"auto");
        			break;
				  default:
			        break;
    			}
			}
			
		}else{
			//xml parser error
		  	$err_msg = "xml parser error<br><br>";
  			order_form();
		    exit(1);
		}
	
	
	
  }else{ //http error
  	
	//$debug_printj .=  "http error";  	
  	$err_msg = "データの送信に失敗しました<br><br>";
  	$err_msg .= "<br />res_statusCd=" . $request->getResponseCode();
  	$err_msg .= "<br />res_status=" . $request->getResponseHeader('Status');
  	
  	order_form();
    exit(1);
	
  }


  if($is_xml_error){
    // データ送信結果が失敗だった場合、オーダー入力画面に戻し、エラーメッセージを表示します。
  	$err_msg = "error_cd:" . $xml_error_cd . "error_msg:" .  $xml_error_msg;
  	order_form();
    exit(1);
  }else{
    // データ送信に成功した場合、リダイレクト先URLへリダイレクトさせてください。
	header("Location: " . $xml_redirect_url);
    exit(0);
  }
  
}
order_form();


// オーダー入力フォーム表示
// 以下はお客様がご購入の際閲覧するWeb画面となります。画面イメージ等は貴社のポリシーに沿った形で変更願います。


function order_form(){

global $my_self, $item, $item_name, $item_price, $user_name, $user_id, $user_mail_add, $goods, $err_msg, $debug_printj;

//echo "debugmsgSTAT<br / ><br / ><br / >" . $debug_printj;

echo <<<EOM

<html lang="ja"><head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=EUC-JP">
<title>商品購入サンプル画面</title>
<STYLE TYPE="text/css">
<!--
TABLE.S1 {font-size: 9pt; border-width: 0px; background-color: #E6ECFA; font-size: 9pt;}
TD.S1   {  border-width: 0px; background-color: #E6ECFA;color: #505050; font-size: 9pt;}
TH.S1   {  border-width: 0px; background-color: #7B8EB4;color: #E6ECFA; font-size: 9pt;}
TABLE {  border-style: solid;  border-width: 1px;  border-color: #7B8EB4; font-size: 8pt;}
TD   {  text-align: center; border-style: solid;  border-width: 2px; border-color: #FFFFFF #CCCCCC #CCCCCC #FFFFFF; color: #505050; font-size: 8pt;}
TH   {  background-color: #7B8EB4;border-style: solid;  border-width: 2px; border-color: #DDDDDD #AAAAAA #AAAAAA #DDDDDD; color: #E6ECFA; font-size: 8pt;}
-->
</STYLE>
</HEAD>
<BODY BGCOLOR="#E6ECFA" text="#505050" link="#555577" vlink="#555577" alink="#557755">
<BR>
<form action="${my_self}" method="post">
<table class=S1 width="400" border="0" cellpadding="0" cellspacing="0">
<tr class=S1><td class=S1>

<table class=S1 width="100%" cellpadding="6" align=center>
<tr class=S1><th class=S1 align=left><big>商品購入サンプル</big></th></tr>
</table>


<table class=S1 width="90%" align=center>
 <tr class=S1>
 
 <td class=S1>
 <font color="#EE5555"> ${err_msg} </font>
 <br>購入する商品を選択してください。<br>
EOM;

echo "   <table cellspacing=4 cellpadding=4 align=\"left\">\n";
echo "     <tr><th>商品名</th><th>価格</th></tr>\n";

// 商品リストの表示
foreach($goods as $key => $value){
  $checked = ($key == $item)? "checked" : "";
  echo "<tr>
  <td><input type=\"radio\" name=\"item\" value=\"${key}\" $checked/>${value['name']}</td>
  <td>${value['price']}円</td>
  </tr>  \n";
}
echo "</table><br><br>\n";

echo <<<EOM

  </td>
 </tr>
 <tr class=S1>
  <td class=S1>
    <br>以下の項目を入力してください<br>
   <table cellspacing=4 cellpadding=4 align="left">
    <tr>
     <td>ユーザーID</td>
     <td><input type="text" name="user_id" value="${user_id}"></td>
    </tr>
    <tr>
     <td>氏名</td>
     <td><input type="text" name="user_name" value="${user_name}"></td>
    </tr>
    <tr>
     <td>メールアドレス</td>
     <td><input type="text" name="user_mail_add" value="${user_mail_add}"></td>
    </tr>
   </table>
  </td>
 </tr>
 <tr class=S1>
  <td class=S1>
    <br>
    <input type="hidden" name="come_from" value="here">
    <input type="submit" name="go" value="送信">
  </td>
 </tr>
</table>
  </td>
 </tr>
</table>
</form>
</BODY>
</HTML>
EOM;
return(1);
}

// 購入確認画面表示
function kakunin(){

global $my_self, $item, $item_name, $item_price, $user_name, $user_id, $user_mail_add, $goods, $err_msg, $debug_printj;
		
//echo "debugmsgSTAT<br / ><br / ><br / >" . $debug_printj;

echo <<<EOM
<html lang="ja"><head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=EUC-JP">
<title>商品購入サンプル画面</title>
<STYLE TYPE="text/css">
<!--
TABLE.S1 {font-size: 9pt; border-width: 0px; background-color: #E6ECFA; font-size: 9pt;}
TD.S1   {  border-width: 0px; background-color: #E6ECFA;color: #505050; font-size: 9pt;}
TH.S1   {  border-width: 0px; background-color: #7B8EB4;color: #E6ECFA; font-size: 9pt;}
TABLE {  border-style: solid;  border-width: 1px;  border-color: #7B8EB4; font-size: 8pt;}
TD   {  text-align: center; border-style: solid;  border-width: 2px; border-color: #FFFFFF #CCCCCC #CCCCCC #FFFFFF; color: #505050; font-size: 8pt;}
TH   {  background-color: #7B8EB4;border-style: solid;  border-width: 2px; border-color: #DDDDDD #AAAAAA #AAAAAA #DDDDDD; color: #E6ECFA; font-size: 8pt;}
-->
</STYLE>
</HEAD>
<BODY BGCOLOR="#E6ECFA" text="#505050" link="#555577" vlink="#555577" alink="#557755">
<BR>
<table class=S1 width="400" border="0" cellpadding="0" cellspacing="0">
<tr class=S1><td class=S1>

<table class=S1 width="100%" cellpadding="6" align=center>
<tr class=S1><th class=S1 align=left><big>商品購入サンプル</big></th></tr>
</table>

<table class=S1 width="90%" align=center>
 <tr class=S1>
  <td class=S1>
    <br>以下の商品を注文します。<br>
    よろしければ[確認]ボタンを押してください。<br><br>

    商品名：${item_name}<br>
    価格：${item_price}円<br>
    <br>
    <table class=S1 align=center width="50%">
     <tr class=S1>
      <td class=S1>
       <form action="${my_self}" method="post">
        <input type="hidden" name="item" value="${item}">
        <input type="hidden" name="item_name" value="${item_name}">
        <input type="hidden" name="item_price" value="${item_price}">
        <input type="hidden" name="user_name" value="${user_name}">
        <input type="hidden" name="user_id" value="${user_id}">
        <input type="hidden" name="user_mail_add" value="${user_mail_add}">
        <input type="submit" name="go" value="戻る">
       </form>
      </td>
      <td class=S1>
       <form action="${my_self}" method="post">
        <input type="hidden" name="item" value="${item}">
        <input type="hidden" name="item_name" value="${item_name}">
        <input type="hidden" name="item_price" value="${item_price}">
        <input type="hidden" name="user_name" value="${user_name}">
        <input type="hidden" name="user_id" value="${user_id}">
        <input type="hidden" name="user_mail_add" value="${user_mail_add}">
        <input type="hidden" name="come_from" value="kakunin">
        <input type="submit" name="go" value="確認">
       </form>
      </td>
     </tr>
    
  </td>
 </tr>
</table>
  </td>
 </tr>
</table>
</form>
</BODY>
</HTML>
EOM;
return(1);
}

exit(0);

?>