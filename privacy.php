<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliate.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>プライバシーポリシー ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_short" class="clearfix">

	<!--main-->
		<!-- InstanceBeginEditable name="maincontents" -->
		<main id="rule">
	
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><span>プライバシーポリシー</span></li>
	        </ul>
	
			<section>
				<h2 class="t-title"><img src="./images/rule/title-privacy.png" width="724" height="39" alt="プライバシーポリシー" /></h2>
	
				<section>
					<div class="rule-List">
						<h3>1（個人情報の取得目的と利用範囲について）</h3>
						<p>当社は下記の目的で、個人情報を取得・利用します。</p>
						<ul>
							<li>(1) 当社及び提携企業が行う「旅行予約」業務の遂行</li>
							<li>(2) 当社及び提携企業の旅行商品、旅行関連商品、その他の商品、権利、デジタルコンテンツ及びサービス（以下、「商品等」といいます。）の販売（サービスの提供契約の締結等を含むものとします。以下同じ。）</li>
							<li>(3) キャンペーン・懸賞企画、アンケートの実施、市場調査・分析、新たなサービスの開発</li>
							<li>(4) 会員が当社で会員登録を必要とするサービスを利用する際の、会員登録等の作業の簡素化</li>
							<li>(5) 当社及び提携企業の商品等の広告・宣伝、販売の勧誘（電子メールによるものを含むものとします。）</li>
							<li>(6) チケット等、会員がポイントとの交換を希望または購入された商品等の発送業務</li>
						</ul>
					</div>
	
					<div class="rule-List">
						<h3>2（個人情報の第三者への開示）</h3>
						<p>当社は、会員本人の事前の同意なく個人情報を個人が識別可能な状態で第三者に開示または提供することはありません。ただし、次の場合はこの限りではありません。</p>
						<ul>
							<li>(1) 会員が個人情報を開示等をすることに事前に同意している場合。</li>
							<li>(2) 個人情報保護法その他の法令により認められる場合。</li>
							<li>(3) 犯罪捜査など法律手続の中で開示を要請された場合。</li>
							<li>(4) 予約の際に宿泊施設、旅行代理店等へ会員の個人情報を通知するなど、会員から求められた商品又はサービスを円滑に提供するために個人情報の開示等が必要な場合。</li>
							<li>(5) 会員のご利用代金の決済に関する事業者に必要な情報を開示する場合。</li>
							<li>(6) 当社又は提携企業が実施するポイントサービス等のサービス提供のために当該提携企業に開示する場合。</li>
							<li>(7) 当社が行う業務の全部又は一部を第三者に委託する場合。</li>
						</ul>
					</div>
	
					<div class="rule-List">
						<h3>3（個人情報の委託について）</h3>
						<p>当社と秘密保持契約を締結している業務提携先や委託先へ業務を委託し、ご本人の個人情報の取り扱いを委託する場合があります。</p>
					</div>
	
					<div class="rule-List">
						<h3>4（個人情報の提供に関しての任意性及び当該情報を与えなかった場合に生じる結果） </h3>
						<p>個人情報をご提供して頂くことはお客様の任意です。会員登録頂くにあたり、その他の個人情報の一部をご提供頂けない場合、会員登録が行えない場合があります。</p>
					</div>
	
					<div class="rule-List">
						<h3>5（個人情報の開示・訂正・誤った個人情報の利用停止について）</h3>
						<p>当社は、会員がご自身の個人情報の開示、訂正、追加、削除、利用停止、消去、第三者提供の停止（以下、まとめて「開示等」といいます。）を希望される場合には、合理的な範囲で遅滞なく対応いたします。お問い合わせや開示等の手続につきましては、下記お問合せ窓口までご連絡ください。開示等の請求が個人情報保護法及び当社の定める要件をみたさない場合、ご希望に添えない場合があります。</p>
						<p>※個人情報の開示等を請求する場合は、氏名、生年月日等、当社所定の方法により、ご本人様または代理人であることを確認させて頂きます。</p>
						<dl class="info">
							<dt>
								お客様相談窓口
							</dt>
							<dd>E-Mailアドレス：info@glaspe.net</dd>
							<dd>住所：沖縄県那覇市久米1-1-13 プランビル久米6F　glass space株式会社</dd>
							<dd>担当部署：カスタマーサポート</dd>
						</dl>
					</div>
	
					<div class="rule-List">
						<h3>6（個人情報に関するご確認事項の更新について）</h3>
						<p>当社は、個人情報保護を図るため、法令等の変更や必要に応じて、個人情報に関するご確認事項を改訂することがあります。その際は、最新の個人情報に関するご確認事項を本ウェブサイトに掲載いたします。</p>
					</div>
	
					<div class="rule-List">
						<p class="r-txt">平成25年10月10日　制定</p>
					</div>
				</section>
	
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
