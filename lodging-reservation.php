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
<title>ココトモでポイントを貯めよう ｜ <?php print SITE_PUBLIC_NAME?></title>
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
		<main id="reservation">
	
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><a href="index.html">サイトの利用方法</a></li>
	            <li><span>宿泊予約の利用方法</span></li>
	        </ul>
	
			<section>
				<h2><img src="./images/rule/title-lodging-reservation.png" width="723" height="39" alt="宿泊予約の利用方法" /></h2>
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation2.png" width="225" height="30" alt="泊まりたい宿泊施設を探す" /></h3>
					<img class="reservationimg" src="./images/rule/reservation1.png" width="299" height="660" alt="TOPページ説明" />
					<dl class="descriptionList">
						<dt class="no1">ココトモ！ピックアップ</dt>
						<dd>旬のテーマや、ココトモ！が厳選したお得で楽しい情報を特集でご紹介します。</dd>
						<dt class="no2">日付・人数から検索</dt>
						<dd>宿泊予定の日付や、人数を入力して検索ボタンを押してください。ご希望の日付と人数で宿泊できる宿泊施設の候補が表示されます。</dd>
						<dt class="no3">地図から検索</dt>
						<dd>泊まりたいエリアの地図をクリックしてください。そのエリアの宿泊施設の候補が表示されます。</dd>
						<dt class="no4">キーワード検索</dt>
						<dd>宿泊施設の名前（一部でもOK）や特徴など、キーワードから宿泊施設を探すことができます。</dd>
						<dt class="no5">こだわりから検索</dt>
						<dd>おでかけの目的や、お部屋・宿泊施設やプランへのこだわりに合った宿泊施設の候補が探せます。</dd>
						<dt class="no6">人気の日程</dt>
						<dd>連休やおでかけシーズンなど、人気の高い日程に泊まれる宿泊施設を探すことができます。</dd>
						<!--<dt class="no7">こだわりから探す</dt>
						<dd>ココトモ！編集部一押しのおすすめスポットや、旬の楽しみ方をお届けします。</dd>
						<dt class="no8">新着レポートを見る</dt>
						<dd>実際に宿泊した県民の皆さんに、おすすめの楽しみ方をレポートしてもらいました！</dd>
						<dt class="no9">新規施設のご紹介</dt>
						<dd>ココトモ！新登場の宿泊施設をご紹介します。人気のあのホテルや、あこがれのお宿が登場するかも！？</dd>-->
					</dl>
				</section>
	
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation3.png" width="300" height="30" alt="【２】　宿泊施設・プランを比較する" /></h3>
					<img class="reservationimg" src="./images/rule/reservation1.png" width="299" height="660" alt="TOPページ説明" />
					<dl class="descriptionList">
						<dt class="no1">再検索枠</dt>
						<dd>条件を変えて検索しなおすことができます。</dd>
						<dt class="no2">表示の切り替え</dt>
						<dd>施設ごと、プランごとから選ぶ表示の切り替えができます。</dd>
						<dt class="no3">プランの検索結果</dt>
						<dd>検索した条件に合った施設とプランが表示されます。<br>
						施設の名前をクリックすると施設の基本情報を確認できます。<br>
						プランの名前をクリックするとプランの詳細や空室カレンダーを確認できます。</dd>
					</dl>
				</section>
	
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation4.png" width="300" height="30" alt="【３】　プラン詳細・空室カレンダーの見方" /></h3>
					<img class="reservationimg" src="./images/rule/reservation1.png" width="299" height="660" alt="TOPページ説明" />
					<dl class="descriptionList">
						<dt class="no1">プランの内容詳細</dt>
						<dd>このプランに含まれるお食事やサービス、特典、お部屋タイプなどの詳細を確認できます。</dd>
						<dt class="no2">空室カレンダー</dt>
						<dd>このプランの日ごとの料金や空室状況を確認することができます。</dd>
						<dt class="no3">予約へ進む</dt>
						<dd>日程や人数の条件が入力されている場合は、合計料金と予約へ進むボタンが表示されます。</dd>
						<dt class="no4">キャンセルポリシー・注意事項</dt>
						<dd>キャンセルの際に発生する料金や、ご宿泊の注意事項をご確認いただけます。</dd>
					</dl>
				</section>
	
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation5.png" width="300" height="30" alt="【４】　予約情報の入力" /></h3>
					<img class="reservationimg" src="./images/rule/reservation1.png" width="299" height="660" alt="TOPページ説明" />
					<dl class="descriptionList">
						<dt class="no1">宿泊内容</dt>
						<dd>選んだプランや日程、人数などの詳細が確認できます。<br>チェックイン時間や、人数の内訳を入力してください。</dd>
						<dt class="no2">宿泊者の情報</dt>
						<dd>
							<ul>
									<li>会員登録された情報が表示されます。</li>
									<li>特に当日のご連絡先など、お間違えがないようご確認ください。</li>
									<li>情報に誤りがあるときは、会員基本情報の変更より訂正をお願いいたします。</li>
									<li>また、原則として会員ご本人様のご宿泊または会員ご本人様を含むグループでのご予約のみ承ります。</li>
								</ul>
							</dd>
						<dt class="no3">宿泊施設からの質問</dt>
						<dd>
							<ul>
								<li>宿泊施設から、お客様へご質問がある場合に表示されます。</li>
								<li>空欄に回答をご入力ください。</li>
							</ul>
						</dd>
						<dt class="no4">宿泊施設への要望</dt>
						<dd>
							<ul>
								<li>お客様から宿泊施設へご要望を送ることができます。</li>
								<li>空欄に内容をご入力ください。</li>
							</ul>
						</dd>
						<dt class="no5">予約金、キャンセルポリシー</dt>
						<dd>予約金の有無やキャンセルの際に発生する料金が確認できます。</dd>
					</dl>
				</section>
	
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation6.png" width="300" height="30" alt="【５】　予約完了" /></h3>
					<img class="reservationimg" src="./images/rule/reservation1.png" width="299" height="660" alt="TOPページ説明" />
					<dl class="descriptionList">
						<dt class="no1">予約情報の入力・確認</dt>
						<dd>予約情報の入力が終わったら、「予約内容の確認へ進む」押して入力内容を確認してください。</dd>
						<dt class="no2">予約完了</dt>
						<dd>入力内容を確認したら、「予約する」ボタンを押してください。<br>予約完了画面と予約番号が表示されたら予約完了です。</dd>
					</dl>
				</section>
	
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation7.png" width="300" height="30" alt="【６】　予約内容の確認・変更・キャンセルについて　" /></h3>
					<img class="reservationimg" src="./images/rule/reservation1.png" width="299" height="660" alt="TOPページ説明" />
					<ul class="descriptionList">
						<li class="no1"><span class="stxt">予約完了後の内容はメニュー・マイページの「ホテル予約情報」から確認できます。</span></li>
						<li class="no2"><span>予約を変更する</span>
							<ul>
								<li class="ntxt">変更できるのは泊数・部屋数を減らす場合のみです。</li>
								<li>その他（プラン、施設、宿泊日（１泊の時）、人数など）のご変更はご予約をキャンセル後、予約を取りなおしてください。</li>
								<li>
									<p>
										※泊数・部屋数を追加する場合は、新たに追加分の予約をしてください。<br>
										※泊数・部屋数を減らす場合は、宿泊施設のキャンセルポリシーにより、キャンセル料が発生する場合がございます。<br>
									</p>
								</li>
							</ul>
						</li>
						<li class="no3"><span>予約をキャンセルする</span>
							<ul>
								<li class="ntxt">キャンセルしたい部屋に「キャンセル」のチェックを入れ、キャンセルボタンを押すとキャンセル画面が表示されます。</li>
								<li>予約の内容とキャンセルポリシーをご確認の上、「キャンセル」ボタンを押してください。</li>
								<li>サイトからキャンセルできる締め切り時間を過ぎた場合は直接宿泊施設へご連絡ください。</li>
							</ul>
							<p>※キャンセルポリシーにより、キャンセル料が発生する場合がございます。</p>
						</li>
					</ul>
				</section>
	
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation8.png" width="340" height="30" alt="お支払について" /></h3>
					<ul class="nlist">
						<li>ご利用料金のお支払いは、当日現地でお支払いください。</li>
						<li>予約金など、事前の入金が必要な場合は宿泊施設より別途ご案内いたします。</li>
					</ul>
				</section>
	
				<section class="reservation_cn">
					<h3><img src="./images/rule/title-lodging-reservation9.png" width="340" height="30" alt="チェックイン当日の流れ" /></h3>
					<ul class="nlist">
						<li>チェックイン当日に宿泊施設のフロントにて、お客様のお名前をお伝えください。</li>
						<li>念のため、ご予約完了ページまたはご予約完了通知メールをプリントアウトしてお持ちいただくと安心です。</li>
						<li>ご予約完了後のオプション追加やご要望のご連絡は宿泊施設まで直接ご連絡ください。</li>
					</ul>
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
