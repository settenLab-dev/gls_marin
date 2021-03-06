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
<title>標識および旅行業約款 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content" class="clearfix">

<!--main-->
	<!-- InstanceBeginEditable name="maincontents" -->
	<main id="agreement">

		<ul id="panlist">
        	<li><a href="index.html">TOP</a></li>
            <li><span>標識および旅行業約款</span></li>
        </ul>

		<section id="profile">
			<h2 class="t-title"><img src="./images/rule/title-sign.png" width="697" height="39" alt="標識および旅行業約款" /></h2>
				<table style="width:694px;">
					<tr>
						<th>業務範囲</th>
						<td>
							国内旅行
						</td>
					</tr>
					<tr>
						<th>登録番号</th>
						<td>
							沖縄県知事登録旅行業 第3-322号
						</td>
					</tr>
					<tr>
						<th>登録年月日</th>
						<td>
							2013年7月19日
						</td>
					</tr>
					<tr>
						<th>有効期間</th>
						<td>
							2018年7月18日
						</td>
					</tr>
					<tr>
						<th>名称</th>
						<td>
							glass space 株式会社
						</td>
					</tr>
					<tr>
						<th>営業所の名称</th>
						<td>
							glass space 株式会社
						</td>
					</tr>
					<tr>
						<th>住所</th>
						<td>
							〒900-0033　沖縄県那覇市久米1丁目1番13号　プランビル久米6F
						</td>
					</tr>
					<tr>
						<th>営業時間</th>
						<td>
							平日 9:00～18:00　※サイトは24時間いつでもご利用いただけます。
							<br>営業時間外のメールのお問い合わせにつきましては、翌営業日の回答とさせていただきます。
							<br>あらかじめご了承ください。
						</td>
					</tr>
					<tr>
						<th>国内旅行業務取扱管理者</th>
						<td>
							宜保 春香　<br>ご旅行の契約に関してご不明な点がある場合、国内旅行業務取扱管理者がご説明させていただきます。
						</td>
					</tr>
				</table>
				<p>【旅行業務の取扱料金】　手配旅行の契約につきまして取扱料金は頂戴しません</p>
		</section>



		<section id="profile">
			<h2 class="t-title"><img src="./images/rule/travel-agreement.png" width="697" height="39" alt="標識・標準旅行業約款" /></h2>
			<section class="trade-agreement_n">
				<ul>
					<li>消費者庁</li>
					<li>観 光 庁</li>
				</ul>
				<p>旅行業法（昭和二十七年法律第二百三十九号）第十二条の三の規定に基づき、標準旅行業約款（平成十六年国土交通省告示第千五百九十三号）の一部を次のように改正し、旅行業法施行規則の一部を改正する省令（平成二十四年国土交通省令第八十九号）の施行の日（平成二十五年四月一日）から適用する。</p>
				<p>平成二十五年一月二十四日</p>
<ul class="rtxt"><li>消費者庁長官：阿南　久</li><li>観光庁長官：井手　憲文</li></ul>
			</section>

				<section id="rule">
					<h2 class="rulebtitle"><b>手配旅行契約の部</b></h2>
					<h3 class="s-title radius10">第一章　総則</h3>
					<div class="rule-List">
						<p>（適用範囲）</p>
						<ul>
							<li><b>第一条</b></li>
							<li>当社が旅行者との間で締結する手配旅行契約は、この約款の定めるところによります。この約款に定めのない事項については、法令又は一般に確立された慣習によります。</li>
							<li>２　当社が法令に反せず、かつ、旅行者の不利にならない範囲で書面により特約を結んだときは、前項の規定にかかわらず、その特約が優先します。</li>
						</ul>

						<ul>
							<li><b>第二条</b></li>
							<li>この約款で「手配旅行契約」とは、当社が旅行者の委託により、旅行者のために代理、媒介又は取次をすること等により旅行者が運送・宿泊機関等の提供する運送、宿泊その他の旅行に関するサービス（以下「旅行サービス」といいます。）の提供を受けることができるように、手配することを引き受ける契約をいいます。</li>
							<li>２　この約款で「国内旅行」とは、本邦内のみの旅行をいい、「海外旅行」とは、国内旅行以外の旅行をいいます。</li>
							<li>３　この約款で「旅行代金」とは、当社が旅行サービスを手配するために、運賃、宿泊料その他の運送・宿泊機関等に対して支払う費用及び当社所定の旅行業務取扱料金（変更手続料金及び取消手続料金を除きます。）をいいます。</li>
							<li>４　この部で「通信契約」とは、当社が提携するクレジットカード会社（以下「提携会社」といいます。）のカード会員との間で電話、郵便、ファクシミリその他の通信手段による申込みを受けて締結する手配旅行契約であって、当社が旅行者に対して有する手配旅行契約に基づく旅行代金等に係る債権又は債務を、当該債権又は債務が履行されるべき日以降に別に定める提携会社のカード会員規約に従って決済することについて、旅行者があらかじめ承諾し、かつ旅行代金等を第十六条第二項又約をいいます。</li>
							<li>５　この部で「電子承諾通知」とは、契約の申込みに対する承諾の通知であって、情報通信の技術を利用する方法のうち当社が使用する電子計算機、ファクシミリ装置、テレックス又は電話機（以下「電子計算機等」といいます。）と旅行者が使用する電子計算機等とを接続する電気通信回線を通じて送信する方法により行うものをいいます。</li>
							<li>６　この約款で「カード利用日」とは、旅行者又は当社が手配旅行契約に基づく旅行代金等の支払又は払戻債務を履行すべき日をいいます。　
（手配債務の終了）</li>
						</ul>

						<ul>
							<li><b>第三条</b></li>
							<li>当社が善良な管理者の注意をもって旅行サービスの手配をしたときは、手配旅行契約に基づく当社の債務の履行は終了します。したがって、満員、休業、条件不適当等の事由により、運送・宿泊機関等との間で旅行サービスの提供をする契約を締結できなかった場合であっても、当社がその義務を果たしたときは、旅行者は、当社に対し、当社所定の旅行業務取扱料金（以下「取扱料金」といいます。）を支払わなければなりません。通信契約を締結した場合においては、カード利用日は、当社が運送・宿泊機関等との間で旅行サービスの提供をする契約を締結できなかった旨、旅行者に通知した日とします。</li>
							<li>２　この約款で「国内旅行」とは、本邦内のみの旅行をいい、「海外旅行」とは、国内旅行以外の旅行をいいます。</li>
							<li>３　この約款で「旅行代金」とは、当社が旅行サービスを手配するために、運賃、宿泊料その他の運送・宿泊機関等に対して支払う費用及び当社所定の旅行業務取扱料金（変更手続料金及び取消手続料金を除きます。）をいいます。</li>
							<li>４　この部で「通信契約」とは、当社が提携するクレジットカード会社（以下「提携会社」といいます。）のカード会員との間で電話、郵便、ファクシミリその他の通信手段による申込みを受けて締結する手配旅行契約であって、当社が旅行者に対して有する手配旅行契約に基づく旅行代金等に係る債権又は債務を、当該債権又は債務が履行されるべき日以降に別に定める提携会社のカード会員規約に従って決済することについて、旅行者があらかじめ承諾し、かつ旅行代金等を第十六条第二項又約をいいます。</li>
							<li>５　この部で「電子承諾通知」とは、契約の申込みに対する承諾の通知であって、情報通信の技術を利用する方法のうち当社が使用する電子計算機、ファクシミリ装置、テレックス又は電話機（以下「電子計算機等」といいます。）と旅行者が使用する電子計算機等とを接続する電気通信回線を通じて送信する方法により行うものをいいます。</li>
							<li>６　この約款で「カード利用日」とは、旅行者又は当社が手配旅行契約に基づく旅行代金等の支払又は払戻債務を履行すべき日をいいます。<br>（手配債務の終了）</li>
							<li><b>第四条</b></li>
							<li>
								当社は、手配旅行契約の履行に当たって、手配の全部又は一部を本邦内又は本邦外の他の旅行業者、手配を業として行う者その他の補助者に代行させることがあります。
							</li>
						</ul>
					</div>


					<h3 class="s-title radius10">第二章　契約の成立</h3>
					<div class="rule-List">
						<p>（契約の申込み）　</p>
						<ul>
						<li><b>第五条</b></li>
						<li>社と手配旅行契約を締結しようとする旅行者は、当社所定の申込書に所定の事項を記入の上、当社が別に定める金額の申込金とともに、当社に提出しなければなりません。</li>
							<li>２　当社と通信契約を締結しようとする旅行者は、前項の規定にかかわらず、会員番号及び依頼しようとする旅行サービスの内容を当社に通知しなければなりません。</li>
							<li>３　第一項の申込金は、旅行代金、取消料その他の旅行者が当社に支払うべき金銭の一部として取り扱います。　</li>
						</ul>
						<p>（契約締結の拒否）　</p>

						<ul>
							<li><b>第六条</b></li>
							<li>当社は、次に掲げる場合において、手配旅行契約の締結に応じないことがあります
								<ul>
									<li>一　当社の業務上の都合があるとき。</li>
									<li>二　通信契約を締結しようとする場合であって、旅行者の有するクレジットカードが無効である等、旅行者が旅行代金等に係る債務の一部又は全部を提携会社のカード会員規約に従って決済できないとき。</li>
								</ul>
							</li>
							<li>（契約の成立時期）<br>
第七条　手配旅行契約は、当社が契約の締結を承諾し、第五条第一項の申込金を受理した時に成立するものとします。</li>
							<li>２　通信契約は、前項の規定にかかわらず、当社が第五条第二項の申込みを承諾する旨の通知を発した時に成立するものとします。ただし、当該契約において電子承諾通知を発する場合は、当該通知が旅行者に到達した時に成立するものとします。</li>
						</ul>
						<p>（契約成立の特則）</p>

						<ul>
							<li><b>第七条</b></li>
							<li>手配旅行契約は、当社が契約の締結を承諾し、第五条第一項の申込金を受理した時に成立するものとします。</li>
							<li>（２　通信契約は、前項の規定にかかわらず、当社が第五条第二項の申込みを承諾する旨の通知を発した時に成立するものとします。ただし、当該契約において電子承諾通知を発する場合は、当該通知が旅行者に到達した時に成立するものとします。</li>
						</ul>
						<p>（契約成立の特則）</p>

						<ul>
							<li><b>第八条</b></li>
							<li>当社は、第五条第一項の規定にかかわらず、書面による特約をもって、申込金の支払いを受けることなく、契約の締結の承諾のみにより手配旅行契約を成立させることがあります。</li>
							<li>立させることがあります。<br>２　前項の場合において、手配旅行契約の成立時期は、前項の書面において明らかにします</li>
						</ul>
						<p>（乗車券及び宿泊券等の特則）</p>

						<ul>
							<li><b>第九条</b></li>
							<li>当社は、第五条第一項及び前条第一項の規定にかかわらず、運送サービス又は宿泊サービスの手配のみを目的とする手配旅行契約であって旅行代金と引換えに当該旅行サービスの提供を受ける権利を表示した書面を交付するものについては、口頭による申込みを受け付けることがあります。</li>
							<li>２　前項の場合において、手配旅行契約は、当社が契約の締結を承諾した時に成立するものとします。</li>
						</ul>
						<p>（契約書面）</p>

						<ul>
							<li><b>第十条</b></li>
							<li>当社は、手配旅行契約の成立後速やかに、旅行者に、旅行日程、旅行サービスの内容、旅行代金その他の旅行条件及び当社の責任に関する事項を記載した書面（以下「契約書面」といいます。）を交付します。ただし、当社が手配するすべての旅行サービスについて乗車券類、宿泊券その他の旅行サービスの提供を受ける権利を表示した書面を交付するときは、当該契約書面を交付しないことがあります。</li>
							<li>２　前項本文の契約書面を交付した場合において、当社が手配旅行契約により手配する義務を負う旅行サービスの範囲は、当該契約書面に記載するところによります。</li>
						</ul>
						<p>（情報通信の技術を利用する方法）</p>

						<ul>
							<li><b>第十一条</b></li>
							<li>当社は、あらかじめ旅行者の承諾を得て、手配旅行契約を締結しようとするときに旅行者に交付する旅行日程、旅行サービスの内容、旅行代金その他の旅行条件及び当社の責任に関する事項を記載した書面又は契約書面の交付に代えて、情報通信の技術を利用する方法により当該書面に記載すべき事項（以下この条において「記載事項」といいます。）を提供したときは、旅行者の使用する通信機器に備えられたファイルに記載事項が記録されたことを確認します。</li>
							<li>２　前項の場合において、旅行者の使用に係る通信機器に記載事項を記録するためのファイルが備えられていないときは、当社の使用する通信機器に備えられたファイル（専ら当該旅行者の用に供するものに限ります。）に記載事項を記録し、旅行者が記載事項を閲覧したことを確認します。</li>
						</ul>
						<p>（情報通信の技術を利用する方法）</p>
					</div>


					<h3 class="s-title radius10">第三章　契約の変更及び解除</h3>
					<div class="rule-List">
						<p>（契約内容の変更）　</p>
						<ul>
							<li><b>第十二条</b></li>
							<li>旅行者は、当社に対し、旅行日程、旅行サービスの内容その他の手配旅行契約の内容を変更するよう求めることができます。この場合において、当社は、可能な限り旅行者の求めに応じます。</li>
							<li>２　前項の旅行者の求めにより手配旅行契約の内容を変更する場合、旅行者は、既に完了した手配を取り消す際に運送・宿泊機関等に支払うべき取消料、違約料その他の手配の変更に要する費用を負担するほか、当社に対し、当社所定の変更手続料金を支払わなければなりません。また、当該手配旅行契約の内容の変更によって生ずる旅行代金の増加又は減少は旅行者に帰属するものとします。</li>
						</ul>
						<p>（旅行者による任意解除）</p>

						<ul>
							<li><b>第十三条</b></li>
							<li>旅行者は、当社に対し、旅行日程、旅行サービスの内容その他の手配旅行契約の内容を変更するよう求めることができます。この場合において、当社は、可能な限り旅行者の求めに応じます。</li>
							<li>２　前項の規定に基づいて手配旅行契約が解除されたときは、旅行者は、既に旅行者が提供を受けた旅行サービスの対価として、又はいまだ提供を受けていない旅行サービスに係る取消料、違約料その他の運送・宿泊機関等に対して既に支払い、又はこれから支払う費用を負担するほか、当社に対し、当社所定の取消手続料金及び当社が得るはずであった取扱料金を支払わなければなりません。</li>
						</ul>
						<p>（旅行者の責に帰すべき事由による解除）</p>

						<ul>
							<li><b>第十四条</b></li>
							<li>当社は、次に掲げる場合において、手配旅行契約を解除することがあります
								<ul>
									<li>一　旅行者が所定の期日までに旅行代金を支払わないとき。</li>
									<li>二　通信契約を締結した場合であって、旅行者の有するクレジットカードが無効になる等、旅行者が旅行代金等に係る債務の一部又は全部を提携会社のカード会員規約に従って決済できなくなったとき。</li>
								</ul>
							</li>
							<li>２　前項の規定に基づいて手配旅行契約が解除されたときは、旅行者は、いまだ提供を受けていない旅行サービスに係る取消料、違約料その他の運送・宿泊機関等に対して既に支払い、又はこれから支払わなければならない費用を負担するほか、当社に対し、当社所定の取消手続料金及び当社が得るはずであった取扱料金を支払わなければなりません。　</li>
						</ul>
						<p>（当社の責に帰すべき事由による解除）</p>

						<ul>
							<li><b>第十五条</b></li>
							<li>旅行者は、当社の責に帰すべき事由により旅行サービスの手配が不可能になったときは、手配旅行契約を解除することができます。</li>
							<li>２　前項の規定に基づいて手配旅行契約が解除されたときは、当社は、旅行者が既にその提供を受けた旅行サービスの対価として、運送・宿泊機関等に対して既に支払い、又はこれから支払わなければならない費用を除いて、既に収受した旅行代金を旅行者に払い戻します。</li>
							<li>３　前項の規定は、旅行者の当社に対する損害賠償の請求を妨げるものではありません。</li>
						</ul>
					</div>


					<h3 class="s-title radius10">第四章　旅行代金</h3>
					<div class="rule-List">
						<p>（旅行代金）</p>
						<ul>
							<li><b>第十六条</b></li>
							<li>行者は、旅行開始前の当社が定める期間までに、当社に対し、旅行代金を支払わなければなりません。</li>
							<li>２　通信契約を締結したときは、当社は、提携会社のカードにより所定の伝票への旅行者の署名なくして旅行代金の支払いを受けます。この場合において、カード利用日は、当社が確定した旅行サービスの内容を旅行者に通知した日とします。</li>
							<li>３　当社は、旅行開始前において、運送・宿泊機関等の運賃・料金の改訂、為替相場の変動その他の事由により旅行代金の変動を生じた場合は、当該旅行代金を変更することがあります。</li>
							<li>４　前項の場合において、旅行代金の増加又は減少は、旅行者に帰属するものとします。</li>
							<li>５　当社は、旅行者と通信契約を締結した場合であって、第三章又は第四章の規定により旅行者が負担すべき費用等が生じたときは、当社は、提携会社のカードにより所定の伝票への旅行者の署名なくして当該費用等の支払いを受けます。この場合において、カード利用日は旅行者が当社に支払うべき費用等の額又は当社が旅行者に払い戻すべき額を、当社が旅行者に通知した日とします。ただし、第十四条第一項第二号の規定により当社が手配旅行契約を解除した場合は、旅行者は、当社の定める期日までに、当社の定める支払方法により、旅行者が当社に支払うべき費用等を支払わなければなりません。</li>
						</ul>
						<p>（旅行代金の精算）　</p>

						<ul>
							<li><b>第十七条</b></li>
							<li>当社は、当社が旅行サービスを手配するために、運送・宿泊機関等に対して支払った費用で旅行者の負担に帰すべきもの及び取扱料金（以下「精算旅行代金」といいます。）と旅行代金として既に収受した金額とが合致しない場合において、旅行終了後、次項及び第三項に定めるところにより速やかに旅行代金の精算をします。</li>
							<li>２　精算旅行代金が旅行代金として既に収受した金額を超えるときは、旅行者は、当社に対し、その差額を支払わなければなりません。</li>
							<li>３　精算旅行代金が旅行代金として既に収受した金額に満たないときは、当社は、旅行者にその差額を払い戻します。</li>
						</ul>
						<p>（乗車券及び宿泊券等の特則）</p>

					</div>

					<h3 class="s-title radius10">第五章　団体・グループ手配</h3>
					<div class="rule-List">
						<p>（団体・グループ手配）</p>
						<ul>
							<li><b>第十八条</b></li>
							<li>当社は、同じ行程を同時に旅行する複数の旅行者がその責任ある代表者（以下「契約責任者」といいます。）を定めて申し込んだ手配旅行契約の締結については、本章の規定を適用します。</li>
						</ul>
						<p>（契約責任者）　</p>

						<ul>
							<li><b>第十九条</b></li>
							<li>当社は、特約を結んだ場合を除き、契約責任者はその団体・グループを構成する旅行者（以下「構成者」といいます。）の手配旅行契約の締結に関する一切の代理権を有しているものとみなし、当該団体・グループに係る旅行業務に関する取引及び第二十二条第一項の業務は、当該契約責任者との間で行います</li>
							<li>２　契約責任者は、当社が定める日までに、構成者の名簿を当社に提出し、又は人数を当社に通知しなければなりません。</li>
							<li>３　当社は、契約責任者が構成者に対して現に負い、又は将来負うことが予測される債務又は義務については、何らの責任を負うものではありません。</li>
							<li>４　当社は、契約責任者が団体・グループに同行しない場合、旅行開始後においては、あらかじめ契約責任者が選任した構成者を契約責任者とみなします。　</li>
						</ul>
						<p>（契約成立の特則）</p>

						<ul>
							<li><b>第二十条</b></li>
							<li>当社は、契約責任者と手配旅行契約を締結する場合において、第五条第一項の規定にかかわらず、申込金の支払いを受けることなく手配旅行契約の締結を承諾することがあります。</li>
							<li>２　前項の規定に基づき申込金の支払いを受けることなく手配旅行契約を締結する場合には、当社は、契約責任者にその旨を記載した書面を交付するものとし、手配旅行契約は、当社が当該書面を交付した時に成立するものとします。</li>
						</ul>
						<p>（構成者の変更）</p>

						<ul>
							<li><b>第二十一条</b></li>
							<li>当社は、契約責任者から構成者の変更の申出があったときは、可能な限りこれに応じます。</li>
							<li>２　前項の変更によって生じる旅行代金の増加又は減少及び当該変更に要する費用は、構成者に帰属するものとします。</li>
						</ul>
						<p>（添乗サービス）</p>

						<ul>
							<li><b>第二十二条</b></li>
							<li>当社は、契約責任者からの求めにより、団体・グループに添乗員を同行させ、添乗サービスを提供することがあります。　</li>
							<li>２　添乗員が行う添乗サービスの内容は、原則として、あらかじめ定められた旅行日程上、団体・グループ行動を行うために必要な業務とします。</li>
							<li>３　添乗員が添乗サービスを提供する時間帯は、原則として、八時から二十時までとします。</li>
							<li>４　当社が添乗サービスを提供するときは、契約責任者は、当社に対し、所定の添乗サービス料を支払わなければなりません。</li>
						</ul>
					</div>


					<h3 class="s-title radius10">第六章　責任</h3>
					<div class="rule-List">
						<p>（当社の責任）</p>
						<ul>
							<li><b>第二十三条</b></li>
							<li>当社は、手配旅行契約の履行に当たって、当社又は当社が第四条の規定に基づいて手配を代行させた者（以下「手配代行者」といいます。）が故意又は過失により旅行者に損害を与えたときは、その損害を賠償する責に任じます。ただし、損害発生の翌日から起算して二年以内に当社に対して通知があったときに限ります。</li>
							<li>２　旅行者が天災地変、戦乱、暴動、運送・宿泊機関等の旅行サービス提供の中止、官公署の命令その他の当社又は当社の手配代行者の関与し得ない事由により損害を被ったときは、当社は、前項の場合を除き、その損害を賠償する責任を負うものではありません。</li>
							<li>３　当社は、手荷物について生じた第一項の損害については、同項の規定にかかわらず、損害発生の翌日から起算して、国内旅行にあっては十四日以内に、海外旅行にあっては二十一日以内に当社に対して通知があったときに限り、旅行者一名につき十五万円を限度（当社に故意又は重大な過失がある場合を除きます。）として賠償します。</li>
						</ul>
						<p>（旅行者の責任）</p>

						<ul>
							<li><b>第二十四条</b></li>
							<li>旅行者の故意又は過失により当社が損害を被ったときは、当該旅行者は、損害を賠償しなければなりません</li>
							<li>２　旅行者は、手配旅行契約を締結するに際しては、当社から提供された情報を活用し、旅行者の権利義務その他の手配旅行契約の内容について理解するよう努めなければなりません。</li>
							<li>３　旅行者は、旅行開始後において、契約書面に記載された旅行サービスを円滑に受領するため、万が一契約書面と異なる旅行サービスが提供されたと認識したときは、旅行地において速やかにその旨を当社、当社の手配代行者又は当該旅行サービス提供者に申し出なければなりません。</li>
						</ul>
					</div>


					<h3 class="s-title radius10">第七章　弁済業務保証金</h3>
					<div class="rule-List">
						<p>（弁済業務保証金））</p>
						<ul>
							<li><b>第二十五条</b></li>
							<li>当社は、一般社団法人全国旅行業協会（東京都港区虎ノ門四丁目一番二十号）の保証社員になっております。</li>
							<li>２　当社と手配旅行契約を締結した旅行者又は構成者は、その取引によって生じた債権に関し、前項の一般社団法人全国旅行業協会が供託している弁済業務保証金から3,000,000円に達するまで弁済を受けることができます。</li>
							<li>３　当社は、旅行業法第二十二条の十第一項の規定に基づき、一般社団法人 全国旅行業協会に弁済業務保証金分担金を納付しておりますので、同法第七条第一項に基づく営業保証金は供託しておりません。</li>
						</ul>
					</div>
				<section>

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
