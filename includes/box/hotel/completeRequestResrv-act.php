<section class="box">

	<div id="fix_mes">
    	<p>以下の内容で予約リクエストを送信いたしました。<br/>ご予約内容の確認・キャンセル・変更はマイページより行ってください。<br/><br/>
    	こちらのプランは予約リクエストの受付となります。<br/>予約リクエストの送信後、催行会社より予約可否をご連絡いたします。<br/>
    	通常1～2日以内に予約可否をご連絡いたしますが、<br/>万が一連絡がない場合は催行会社までお問い合わせください。</p>
    	<div>
    		<h3>予約のリクエストを送信いたしました。</h3>
	    	<p>予約番号:<span><?=$saveStat?></span></p>
	    	<p>予約申し込み日時:<span><?=date('Y-m-d H:i:s')?></span></p>
	    </div>
    	<p><a href="myhotelbookingedit.html?id=<?=$saveStat?>"><img src="<?php print URL_PUBLIC?>images/form/btreservation-Confirmation2.png" width="259" height="54" alt="（マイページ）予約内容の確認へ" /></a></p>
    	<div class="logout r-txt">→<a href="<?php print URL_PUBLIC?>">TOPページへ</a></div>
	</div>

</section>
