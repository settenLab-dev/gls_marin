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
<title>旅行条件書 ｜ <?php print SITE_PUBLIC_NAME?></title>
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
		<main id="agreement">
		
				<ul id="panlist">
		        	<li><a href="index.html">TOP</a></li>
		            <li><span>旅行条件書</span></li>
		        </ul>
		
				<section id="profile">
					<h2 class="t-title"><img src="./images/rule/title-conditions.png" width="697" height="39" alt="旅行条件書" /></h2>
						<section id="rule">
							<h2 class="rulebtitle"><b>旅行条件書（国内手配旅行の場合）</b></h2>
							<p>
								本旅行条件書は、旅行業法第１２条の４に定める取引条件説明書面であり、また、国内旅行（弊社旅行業約款第２条第２項で定義）の手配に関する旅行契約が成立した場合には、同法第１２条の５に定める契約書面の一部となる。
							</p>
		
							<h3 class="s-title radius10">第１条（手配旅行契約）</h3>
							<div class="rule-List">
								<ul>
									<li>１．本旅行条件書の対象となる旅行は、glass space株式会社（以下「弊社」という）がお客様のために媒介する、国内の運送・宿泊機関等の提供する運送、宿泊その他の旅行に関するサービス（その付随サービス含む）（以下「旅行サービス」といいます。）とする。</li>
									<li>２．本旅行条件書において「旅行契約」とは、弊社がお客様の依頼により、お客様のために媒介することにより、お客様が旅行サービスの提供を受けられるように、手配することを引き受ける契約をいう。</li>
									<li>３．旅行契約の内容・条件は、本旅行条件書および弊社約款によるものとする。</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第２条（旅行の申し込みと旅行契約の成立時期）</h3>
							<div class="rule-List">
								<ul>
									<li>１． 弊社と旅行契約を締結しようするお客様は、以下のいずれかの方法により予約の申し込みをするものとし、その際の申込金は不要とする。
										<ul>
											<li>（１）弊社が運営するインターネット上の宿泊予約サイト「ココトモ！」（以下「当サイト」という）において、弊社所定の方法によりオンライン入力する方法 </li>
											<li>（２）カスタマーサポートへの電話（ただし、旅行代金の支払い方法が第５条第２項第１号に定める宿泊施設への直接支払である場合に限る）</li>
										</ul>
									</li>
									<li>２．旅行契約の成立時期は、以下のとおりとする。
										<ul>
											<li>（１）当サイトに予約申し込みした場合、お客様が、本旅行条件書および当サイトにおいて予約内容を提示するページ（以下「予約内容提示ページ」という。）に記載された旅行契約の内容および旅行条件等に同意のうえ予約申し込みを行い、当該予約申し込みが弊社によって承諾された時点とする。弊社は、かかる承諾後直ちに、予約成立した旨を当サイトに表示する。</li>
											<li>（２）カスタマーサポートに予約申し込みをした場合は、弊社が当該予約申し込みを口頭で承諾した時点とする。ただし、お客様は、第４条第２項により交付された書面により、契約内容に錯誤があったことが判明した場合には、旅行契約を取り消すことができる。</li>
										</ul>
									</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第３条（申し込み条件）</h3>
							<div class="rule-List">
								<ul>
									<li>１．弊社は、以下の事項を予約内容提示ページに表示するものとし、その記載は、本旅行条件書の一部を構成するものとみなす。
										<ul>
											<li>（１）施設およびサービスの内容 </li>
											<li>（２）旅行日程 </li>
											<li>（３）旅行代金その他宿泊に通常要する費用 </li>
											<li>（４）運送・宿泊機関が提示する取消料、変更料、その他旅行契約の変更または取消の条件 </li>
											<li>（５）旅行地における安全確保または衛生に関する特別の注意事項があるときは、当該事項 </li>
											<li>（６）その他の旅行条件</li>
										</ul>
									</li>
									<li>２．お客様は、第１項により表示された事項、本旅行条件書、弊社旅行業約款、別途定める「ココトモ！」会員規約を確認し、これらに同意のうえ、旅行の申し込みを行うものとする。
									</li>
									<li>３．弊社は、旅行契約成立後、第1項各号の事項をお客様が予約内容を確認するページ（以下「予約確認ページ」という）に表示する。</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第４条（取引条件説明書面・契約書面の交付）</h3>
							<div class="rule-List">
								<ul>
									<li>１．弊社は、本旅行条件書に記載した事項（予約内容提示ページおよび予約確認ページに記載された第３条第１項各号の事項を含む。次項において同じ。）を、それを記載した書面の交付に代えて、当サイトに掲示し、お客様はこれを申し込み時に必ず閲覧するものとする。お客様は、弊社がこの方法により契約内容を通知することに同意するものとする。</li>
									<li>２．弊社は、お客様がカスタマーサポートに予約申し込みした場合、本旅行条件書に記載した事項を記載した書面をお客様に郵送・ＦＡＸ・電子メール等で交付する。ただし、お客様が書面交付について不要の意思表示をした場合については、この限りでない。</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第５条（旅行代金の支払い）</h3>
							<div class="rule-List">
								<ul>
									<li>１．旅行代金とは、弊社が手配する宿泊サービスにかかる宿泊料その他の宿泊機関に対して支払う費用（以下「宿泊料金」といい、通常、サービス料および消費税を含む）をいう。また、弊社が手配した旅行についての取扱料金は発生しないものとする。</li>
									<li>２．本旅行条件書による旅行において、宿泊料金は、以下のいずれかの方法のうち予約内容提示ページで選択可能な方法として表示されたものの中から、お客様が選択した方法により支払うものとする。
										<ul>
											<li>（１）お客様が利用・宿泊時に運送・宿泊機関に対し直接支払う方法 </li>
											<li>（２）第６条に定める通信契約に基づき、クレジットカードで弊社に支払う方法 </li>
											<li>（３）その他予約内容提示ページに別の定めがあるときは、その方法</li>
										</ul>
									</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第６条（通信契約）</h3>
							<div class="rule-List">
								<ul>
									<li>１．「通信契約」とは、弊社（または弊社約款第４条に基づき弊社の手配を代行する者。以下本条において同じ）が提携するクレジットカード会社（弊社と契約するクレジットカード決済代行業者を通じて提携している場合を含む。）のカード会員（以下「会員」という）との間で、所定の伝票への会員の署名なくして会員のクレジットカードによる旅行代金等の支払いを受けることを条件に、オンライン入力による旅行の申し込みを受けて締結する旅行契約をいう。</li>
									<li>２．通信契約は、通常の旅行契約の旅行条件に加え、以下の条件に従うものとする。
										<ul>
											<li>（１）会員は、弊社に対し、申し込み時に「カード名」、「会員番号」、「カード有効期限」等を弊社所定の方法により通知するものとする。</li>
											<li>（２）会員および弊社が通信契約に基づく旅行代金等の支払いまたは払い戻し債務を履行すべき日（カード利用日）は、以下のとおりとする。</li>
										</ul>
										<ul>
											<li>[1]　会員が支払うべき旅行代金については、契約成立日 </li>
											<li>[2]　会員が支払うべき追加費用については、支払うべき金額を弊社が会員に通知した日 </li>
											<li>[3]　弊社が支払うべき払戻金については、払い戻すべき金額を弊社が会員に通知した日 </li>
										</ul>
									</li>
									<li>
										（３）弊社は、お客様のクレジットカードで決済できない場合、通信契約の締結に応じないことができる。
									</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第７条（旅行契約の内容変更）</h3>
							<div class="rule-List">
								<ul>
									<li>１．弊社は、お客様が旅行日程、サービスの内容その他の旅行契約の内容変更を求める場合、可能な限りその求めに応ずるものとする。</li>
									<li>２．お客様は、前項の変更を求める場合、当サイトの「予約の確認・変更・キャンセル」ページで変更依頼を行うものとする。ただし、同ページで変更ができない場合は、直接当該宿泊機関に連絡するものとする。</li>
									<li>３．お客様は、第１項の旅行内容の変更により発生する変更料・違約料等を、予約内容提示ページに記載されたキャンセルポリシー（以下「提示キャンセルポリシー」という）に従い支払うものとする。なお、提示キャンセルポリシーは、原則として宿泊機関の宿泊約款に基づくものであるが、宿泊機関との特約により当該約款と異なる場合があり、この場合には、提示キャンセルポリシーを優先する。</li>
									<li>４．第１項の旅行契約の内容の変更によって生ずる宿泊料金の増加または減少はお客様に帰属するものとする。</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第８条（お客様による旅行契約の任意解除）</h3>
							<div class="rule-List">
								<ul>
									<li>１．お客様は、いつでも旅行契約の全部または一部を解除することができる。</li>
									<li>２．お客様は、前項の解除をする場合、当サイトの「予約情報」ページで取消依頼を行うものとする。ただし、同ページで変更ができない場合は、直接当該運送・宿泊機関に連絡する。</li>
									<li>３．お客様は、第１項の旅行契約の解除により発生する取消料・違約料等を、予約内容提示ページに記載された提示キャンセルポリシーに従い支払うものとする。不泊の場合についても同様とする。なお、提示キャンセルポリシーは、原則として宿泊機関の宿泊約款に基づくものであるが、宿泊機関との特約により当該約款と異なる場合があり、この場合には、提示キャンセルポリシーを優先する。</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第９条（弊社の責に帰すべき事由による旅行契約の解除）</h3>
							<div class="rule-List">
								<p>お客様は、弊社の責に帰すべき事由により運送・宿泊サービスの手配が不可能となった場合、旅行契約を解除することができる。</p>
						</div>
		
							<h3 class="s-title radius10">第１０条（弊社の責任）</h3>
							<div class="rule-List">
								<ul>
									<li>１．弊社の責任の範囲は、特段の定めがある場合を除き、第１条第２項に記載した手配行為に限定する。</li>
									<li>２．弊社は、旅行契約の履行にあたり、弊社または弊社の手配代行者の故意または過失によりお客様が損害を被った場合、その損害を賠償するものとする。ただし、損害発生の翌日から起算して２年以内に弊社に対して通知があった場合に限る。</li>
									<li>３．弊社は、お客様が天災地変、戦乱、暴動、運送・宿泊機関のサービス提供の中止、宿泊機関の過剰予約受付（オーバーブッキング）による予約取消、官公署の命令その他の弊社または弊社の手配代行者の関与し得ない事由による損害を被った場合、その損害を賠償する責任を負わないものとする。</li>
									<li>４．弊社は、手荷物について生じた第２項の損害については、同項の規定にかかわらず、損害発生の翌日から起算して１４日以内に弊社に対して通知があった場合に限りお客様１名につき１５万円を限度（弊社に故意または重大な過失がある場合を除く）として賠償するものとする。</li>
								</ul>
						</div>
		
							<h3 class="s-title radius10">第１１条（お客様の責任）</h3>
							<div class="rule-List">
								<ul>
									<li>１．弊社は、お客様の故意、過失、法令、公序良俗に反する行動により弊社が損害を受けた場合、お客様に対して被った全ての損害の賠償を請求することができるものとする。</li>
									<li>２．お客様は、旅行契約を締結するに際し、弊社から提供された情報を活用し、お客様の権利義務その他の旅行契約の内容について理解するように努めなければならない。</li>
									<li>３．お客様は、旅行開始後において、第４条第１項に基づき当サイトに掲示された事項または同条第２項に記載された記載書面（以下総称して、この条項で「契約書面」という）の宿泊サービスを円滑に受領するため、万が一、契約書面と異なる宿泊サービスが提供されたと認識したときは、宿泊機関において速やかにその旨を弊社、弊社の手配代行者または当該宿泊機関に申し出なければならないものとする。</li>
								</ul>
								<p class="r-txt">以上<br />２０１３年９月１日 現在</p>
						</div>
		
		
						<div class="info">
							<ul>
								<li><b>【取扱旅行業者】</b></li>
								<li>沖縄県那覇市久米１丁目１番１３号プランビル久米６F</li>
								<li>glass space株式会社</li>
								<li>沖縄県知事登録旅行業 第3-322号</li>
								<li>一般社団法人 全国旅行業協会 正会員</li>
								<li>国内旅行業務取扱管理者：宜保　春香</li>
							</ul>
							<p>ご旅行の契約に関してご不明な点がある場合、国内旅行業務管理者がご説明させていただきます。</p>
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
