<?php

//  EPSILON ���쥸�åȥ�����ǧ�ڴ�λ������ӥ˼����ֹ�ȯ�Դ�λ
//  ���饤�����¦�ץ����(PHP��)
//
//  ���Υץ����μ¹Ԥˤϡ��ʲ��Υ⥸�塼�뤬ɬ�פǤ���
//  ��PHP(ver5,,,,,
//  ��PEAR:
//  ��PEAR:HTTP_Request:
//  ��PEAR:Net_URL:
//  ��PEAR:Net_Socket:
//  ��PEAR:XML_Parser:
//  ��PEAR:XML_Serializer:
//

//include Libraly
//PEAR��ĥ�⥸�塼����ɤ߹��ߡ�
//���˳����Υ⥸�塼��򥤥󥹥ȡ���Ѥߤξ���Ŭ���ɤ߹�����ѥ����ѹ����Ƥ���������
require_once "http/Request.php";
require_once "xml/Unserializer.php";

//char setting
//�����дĶ��˱���Ŭ���ѹ����Ƥ���������
mb_language("Japanese");
mb_internal_encoding("EUC-JP");

// �ѿ�������

// �������������ǧCGI��URL(���)
// �������������ǧCGI�ˤĤ��Ƥ�2���ढ��ޤ��ΤǤ���դ��ꤤ�������ޤ���
// �ܺ٤�CGI����ޥ˥奢��Ρ֥������������ǧCGI-1,2�פ򤴳�ǧ�ꤤ�ޤ���
// ��CGI������
// CGI-1:ǧ�ڤ˥ѥ������/ȯ����IP̵����
// CGI-2:ǧ�ڤ˥ѥ��������/ȯ����IP������ͭ

// �ʲ��ˤ�CGI-1��2������ѥ�᡼������㤷�ޤ��Τ����Ѥ����CGI�ˤ�ä��ѹ����Ƥ���������

// ��³��URL������

// CGI-1���Ѥξ�� ���ִĶ��ؤ���³�ξ��Ϸ�������Ҥ��餴Ϣ�������ޤ�URL���ѹ����Ƥ�������
$getsales_url = 'https://beta.epsilon.jp/client/getsales.cgi';
// CGI-2���Ѥξ�� ���ִĶ��ؤ���³�ξ��Ϸ�������Ҥ��餴Ϣ�������ޤ�URL���ѹ����Ƥ�������
//my $getsales_url = 'https://beta.epsilon.jp/cgi-bin/order/getsales2.cgi';

// ȯ�Ԥ��줿�桼����ID(���󥳡���)�����Ϥ��Ƥ�������
// CGI-1,2����
$user_id = '00000000';

// ȯ�Ԥ��줿�ѥ���ɤ����Ϥ��Ƥ���������
// CGI-1���Ѥξ�� ���Ҥ��餪�Τ餻�����ѥ���ɤ����ꤷ�Ƥ���������
// CGI-2���Ѥξ�� ���ͤ����Ѥ��ޤ���Τ�Ŭ�����ͤ����ꤷ�Ƥ���������txZaDA9o,j6ralKCA
$passwd  = 'XXXXXXXX';

// ���顼��ȯ���������Υ�å�����
$err_msg;

// ���������������CGI��¹Ԥ�����̤��Ǽ����Ϣ������
$responce = array();

// �ƻ�ʧ����ˡ
$payment_name = array(
   1 => "���쥸�åȥ����ɷ��",
   2 => "���쥸�åȥ����ɷ��",
   3 => "����ӥ˷��",
   4 => "�ͥåȶ�Է��(����ѥ�ͥåȶ��)",
   5 => "�ͥåȶ�Է��(e-bank)",
   7 => "�ڥ�����",
   8 => "WebMoney",
   9 => "Do-Link���",
   12 => "BitCash���",
   13 => "�Żҥޥ͡����祳��");

// ����ӥˡ��ڥ�������ʧ�ξ��λ�ʧ����ˡ�δ�ñ������
$setsumei = array(
    # ���֥󥤥�֥�
    11 => "�ʲ���ʧ��ɼ�ڡ�����ץ��ȥ����Ȥ���뤫��ʧ��ɼ�ֹ���⤷��<br>" . 
          "�Ǵ��Υ��֥󥤥�֥�Υ쥸�ˤƤ���ʧ������������<br>" ,
    # �ե��ߥ꡼�ޡ���
    21 => "�ե��ߥ꡼�ޡ���ŹƬ�ˤ������ޤ� Fami�ݡ��ȡ��ե��ߥͥåȤˤ�<br>" .
          "�ʲ��Σ��Ĥο���������ĺ����ȯ�Ԥ����Fami�ݡ��ȿ�������쥸�ޤ�<br>" .
          "�������ˤʤ����򤪻�ʧ������������<br>",
    # ������
    31 => "�������Ź������֤��Ƥ���Loppi�Υȥåײ��̤��椫�顢�֥��󥿡��ͥåȼ��ա�<br>" .
          "�����Ӥ��������������̤Υ�������椫��֥��󥿡��ͥåȼ��աפ�����ĺ����<br>" .
          "���̤˽��äưʲ��Ρ֤���ʧ�������ֹ�פȡ�����Ͽĺ�����������ֹ�פ����ϲ�������<br>" ,
    # ���������ޡ���
    32 => "���������ޡ��Ȥ�Ź������֤��Ƥ��륻�������ޡ��ȥ���֥��ơ������ʾ���ü���ˤ�<br>" .
          "�ȥåײ��̤��椫�顢�֥��󥿡��ͥåȼ��աפ����Ӳ����������̤˽��äưʲ���<br>" .
          "�֤���ʧ�������ֹ�פȡ�����Ͽĺ�����������ֹ�פ����ϲ�������<br>" ,
    # �ڥ�����
    88 => "�ڥ������Ǥ���ʧ��ĺ���ݤˤ϶�Ԥ�ATM�⤷���ϥ���饤��Х󥭥󥰤�<br>����ʧ����������ˡ���������ޤ���<BR>" .
          "�����Ѳ�ǽ�ʶ�ԤˤĤ��ޤ��Ƥϰʲ���󥯤Ǥ���ǧ���ꤤ�������ޤ���<BR><BR>".
          "<a href='http://www.epsilon.jp/service/payeasy_list.html' target='_blank'>�ڥ���������ʧ��ǽ��԰���</a><BR><BR>".
          "����ʧ��ǽ�ʶ�ԡ�����饤��Х󥭥󥰤ǡּ�Ǽ�����ֹ�ס��ֳ�ǧ�ֹ�ס�<br>����Ͽ�����������������ֹ�פ����Ϥξ头���⤪�ꤤ���ޤ���" );

// �ѥ�᡼���Ȥ����Ϥ����(GET)�ȥ�󥶥�����󥳡��ɤ�������ޤ���
$trans_code = $_REQUEST['trans_code'];


// ����䤤��碌��HTTP�ꥯ����������

// CGI-1���Ѥξ�� 
// ���������������ǧCGI�μ¹Ԥˤϥ١����å�ǧ�ڤ�ɬ�פǤ��� 
$request = new HTTP_Request($getsales_url);
$request->setMethod(HTTP_REQUEST_METHOD_POST);
$request->addHeader("Content-Type","application/x-www-form-urlencoded");
$request->setBody("trans_code=" . $trans_code);

$request->setBasicAuth($user_id, $passwd);
$response = $request->sendRequest();


// CGI-2���Ѥξ�� 
//$request = new HTTP_Request($getsales_url);
//$request->setMethod(HTTP_REQUEST_METHOD_POST);
//$request->addHeader("Content-Type","application/x-www-form-urlencoded");
//$request->setBody("trans_code=" . $trans_code . "&contract_code=" . $user_id);
//$response = $request->sendRequest();

// �ʹߤ�CGI-1,2�ɤ���ⶦ�̤Ǥ���

if (PEAR::isError($response)) {
  // ���󥿡��ե�����CGI�μ¹Ԥ˼��Ԥ������
  	$err_msg = "�ǡ����������˼��Ԥ��ޤ���<br><br>";
  	$err_msg .= "<br />res_statusCd=" . $request->getResponseCode();
  	$err_msg .= "<br />res_status=" . $request->getResponseHeader('Status');
	echo $err_msg;
    exit;
}


// CGI�μ¹Ԥ�����������硢��������(XML)����Ϥ��ޤ�
    // ��������(XML)�β���
  	
$res_code = $request->getResponseCode();
$res_content = $request->getResponseBody();

//xml unserializer
$temp_xml_res = str_replace("x-sjis-cp932", "EUC-JP", $res_content);
$unserializer =& new XML_Unserializer();
$unserializer->setOption('parseAttributes', TRUE);
$unseriliz_st = $unserializer->unserialize($temp_xml_res);
if ($unseriliz_st === true) {
	//xml�����
	$res_array = $unserializer->getUnserializedData();
	//error check
	if($res_array['result']['result'] == "0"){
		echo "�����˼��Ԥ��ޤ���<br><br>";
    	exit(1);
	}

	$res_param_array = array();
	//pram setting
	foreach($res_array['result'] as $uns_k => $uns_v){
		list($result_atr_key, $result_atr_val) = each($uns_v);
		$res_param_array[$result_atr_key] = mb_convert_encoding(urldecode($result_atr_val), "EUC-JP" ,"auto");
	}
	$debug_printj .=  "<br />xml_memo2_msg=" . $xml_memo2_msg;
	
}else{
	//xml parser error
  	echo "xml parser error<br><br>";
    exit(1);
}
$result_html;

if ($res_param_array['payment_code'] == 3){
  // ����ӥ˻�ʧ�ξ��
  if ($res_param_array['conveni_code'] == 11){
    // ���֥󥤥�֥�ξ��
    $result_html = $setsumei[11] . "<br><br>\n";
    $result_html .= "ʧ��ɼ : <a href=\"" . $res_param_array['haraikomi_url'] . "\">�����򥯥�å�</a>  <br>\n";
    $result_html .= "ʧ��ɼ�ֹ� : " . $res_param_array['receipt_no'] . "<br>\n";
  }
  elseif ($res_param_array['conveni_code'] == 21){
    // �ե��ߥ꡼�ޡ��Ȥξ��
    $result_html = $setsumei[21] . "<br><br>\n";
    $result_html .="��ȥ����ɡ� " . $res_param_array['kigyou_code'] . "<br>\n";
    $result_html .= "��ʸ�ֹ� : " . $res_param_array['receipt_no'] . "<br>\n";
  }
  elseif (($res_param_array['conveni_code'] == 31) || ($res_param_array['conveni_code'] == 32)){
    // �����󡢥��������ޡ��Ȥξ��
    $result_html = $setsumei{$res_param_array{'conveni_code'}} . "<br><br>\n";
    $result_html .= "����ʧ�������ֹ� : " . $res_param_array['receipt_no'] .  "<br>\n";
  }
  else {  // ����(�۾�)
    print_html("��ʧ����μ����˼��Ԥ��ޤ��� $res_param_array{'conveni_code'}");
    exit(0);
  }
  $conveni_limit_date = split("-",$res_param_array['conveni_limit']);
  $result_html .= "<br>��ʧ���¡�" . $conveni_limit_date[0] . "ǯ"
                . $conveni_limit_date[1] . "��" . $conveni_limit_date[2] . "��<br>\n";
  print_html("",$payment_name[$res_param_array['payment_code']],mb_convert_encoding(urldecode($res_param_array['item_name']), "EUC-JP" ,"auto"),$res_param_array['item_price'],$result_html);
  exit (0);
}
elseif ($res_param_array['payment_code'] == 7 ){
  // �ڥ������ξ��
  $result_html = $setsumei[88] . "<br><br>\n";
  $result_html .= "��Ǽ�����ֹ桧 " . $res_param_array['kigyou_code'] . "<br>\n";
  $result_html .= "��ǧ�ֹ� : " . $res_param_array['receipt_no'] .  "<br>\n";
  print_html("",$payment_name[$res_param_array['payment_code']],mb_convert_encoding(urldecode($res_param_array['item_name']), "EUC-JP" ,"auto"),$res_param_array['item_price'],$result_html);
  exit(0);
}
else {
  // ����ʳ��η�Ѥξ��
  print_html("",$payment_name[$res_param_array['payment_code']],mb_convert_encoding(urldecode($res_param_array['item_name']), "EUC-JP" ,"auto"),$res_param_array['item_price'],"����ʸ���꤬�Ȥ��������ޤ�����");
  exit(0);
}

// HTML����
function print_html($err_msg,$payment_name,$item_name,$item_price,$result_setsumei){
echo <<<EOM
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML lang="ja"><head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=EUC-JP">
<title>EPSILON�����饤�����¦����ץ�</title>
<STYLE TYPE="text/css">
<!--
TABLE.S1 {font-size: 9pt; border-width: 0px; background-color: #FAE9E6; font-size: 9pt;}
TD.S1   {  border-width: 0px; background-color: #FAE9E6;color: #505050; font-size: 9pt;}
TH.S1   {  border-width: 0px; background-color: #DC9485;color: #FAE9E6; font-size: 9pt;}
TABLE {  border-style: solid;  border-width: 1px;  border-color: #DC9485; font-size: 8pt;}
TD   {  text-align: center; border-style: solid;  border-width: 2px; 
        border-color: #FFFFFF #CCCCCC #CCCCCC #FFFFFF; color: #505050; font-size: 8pt;}
TH   {  background-color: #DC9485;border-style: solid;  border-width: 2px;
        border-color: #DDDDDD #AAAAAA #AAAAAA #DDDDDD; color: #FAE9E6; font-size: 8pt;}
-->
</STYLE>
</HEAD>
<BODY BGCOLOR="#FAE9E6" text="#505050" link="#555577" vlink="#555577" alink="#557755">
<BR>
<table class=S1 width="500" border="0" cellpadding="0" cellspacing="0">
<tr class=S1><td class=S1>
<table class=S1 width="100%" cellpadding="6" align=center>
<tr class=S1><th class=S1 align=left><big> ��λ���� (��ѥ���ץ����)</big></th></tr>
</table>

<br>
�����ˡ��${payment_name}<br><br>
����̾: ${item_name}<br>
����: ${item_price}��<br><br>

${result_setsumei}
<br>${err_msg}
</td></tr>
</table>
</BODY>
</HTML>
EOM;
return(1);
}

exit(1);

