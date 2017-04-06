<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPay.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelRoom.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookingcont.php');

require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlRoom.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/linkCount.php');

///////////////////////
//	fax
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
///////////////////////


$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('login.php');
	exit;
}


$collection = new collection($db);
$collection->setPost();
cmSetHotelSearchDef($collection);

$hotel = new hotel($dbMaster);
$hotel->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
$hotelBookset = new hotelBookset($dbMaster);
$hotelBookset->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));

///////////////////////
//	fax
$company = new company($dbMaster);
$company->select($collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
///////////////////////

$hotelBooking = new hotelBooking($dbMaster);
$is_request=false;
if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LINK") == "") {
	require_once('includes/box/hotel/reservcoupon.php');
}
else {
	require_once('includes/box/hotel/reservlink.php');
}

$inputs = new inputs(); 

// イプシロンテスト環境への接続用プログラム（注文画面）
// created by Gen Taguchi on 2009/11/04
// 
// POSTだったら以下を処理
if ($_SERVER['REQUEST_METHOD']=="POST") {
  // 通信にPEARを使います。「pear install HTTP_Request」などでインストールしておいてください。
  require_once "HTTP/Request.php";
  // 通信データを組み立てていきます。
  // テスト環境接続用のURLはイプシロンさんからもらってください。
  $req =& new HTTP_Request("https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi");
  $req->setMethod(HTTP_REQUEST_METHOD_POST);
  // イプシロンさんからもらう契約コード。XXXXXは適当に置き換えてください。
  $req->addPostData("contract_code", "61002840");
  // 結果をXMLでもらいます。
  $req->addPostData("xml", 1);
  // 以下はFormから。
  $req->addPostData("user_id", $_POST['user_id']);
  $req->addPostData("user_name", $_POST['user_name']);
  $req->addPostData("user_mail_add", $_POST['user_mail_add']);
  $req->addPostData("item_code", $_POST['item_code']);
  $req->addPostData("item_name", $_POST['item_name']);
  $req->addPostData("order_number", $_POST['order_number']);
  $req->addPostData("st_code", $_POST['st_code']);
  $req->addPostData("mission_code", $_POST['mission_code']);
  $req->addPostData("item_price", $_POST['item_price']);
  $req->addPostData("process_code", $_POST['process_code']);
  $req->addPostData("memo1", $_POST['memo1']);
  $req->addPostData("memo2", $_POST['memo2']);
  // 接続して結果を取得します。結果はXMLで返ってきます。
  if (!PEAR::isError($req->sendRequest())) {
    $xml = $req->getResponseBody();
  }
  // 結果を取り出すための正規表現パターン。
  $p_result = '!<result result="(0|1)" \/>!i';
  $p_redirect = '!<result redirect="([^"]*)" \/>!i';
  $p_error_code = '!<result err_code="([0-9]+)" \/>!i';
  $p_error_detail = '!<result err_detail="([^"]*)" \/>!i';
  // 処理結果を取り出します。
  $result = preg_match($p_result, $xml, $m1) ? $m1[1] : NULL;
  // 処理がOKだったらリダイレクト、NGだったらエラー表示。
  if ($result==1) {
    $redirect = preg_match($p_redirect, $xml, $m2) ? urldecode($m2[1]) : NULL;
    header("Location: $redirect");
  } else {
    $error_code = preg_match($p_error_code, $xml, $m3) ? $m3[1] : NULL;
    $error_detail = preg_match($p_error_detail, $xml, $m4) ? mb_convert_encoding(urldecode($m4[1]),"utf-8","sjis") : NULL;
    echo "ErrCode: $error_code, ErrMsg: $error_detail "; exit;
  }
}

?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php require("includes/box/common/meta_new2.php"); ?>
<title>クーポン購入手続き ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="クーポン購入,<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="クーポン購入ページです。<?php print SITE_PUBLIC_DESCRIPTION?>" />
<link rel="stylesheet" href="/css/jquery-ui-1.10.3.custom.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.min.js"></script>
<SCRIPT>
	history.forward();
</SCRIPT>
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_n.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_short" class="clearfix">

	<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="detail" class="reservation">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>クーポン購入手続き</span></li>
        </ul>
        <div class="mainbox">
        	<?php
			if ($hotelBooking->getErrorCount() > 0) {
			?>
				<?php print create_error_caption($hotelBooking->getError())?>
			<?php
			}
			?>
        	<form method="post" action="https://cocotomo.net/reservation-coupontest4.html" id="regist" name="regist">
            	<?php require("includes/box/hotel/confirmReserv-coupon2.php");?>
            </form>
        </div>

	</main>
	<!-- InstanceEndEditable -->
    <!--/main-->


</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_n.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
