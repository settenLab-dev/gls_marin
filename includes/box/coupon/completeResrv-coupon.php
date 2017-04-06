<section class="box">

	<div id="fix_mes">
    	<p>ご入力頂いたメールアドレス宛てに購入確認メールを送信しました。</p>
    	<div>
    		<h3>クーポンの購入手続きが完了いたしました。</h3>
	    	<p>クーポン番号:<span><?=$saveStat?></span></p>
	    	<p>購入完了日時:<span><?=date('Y-m-d H:i:s')?></span></p>
	    </div>
    	<p><a href="myhotelbookingedit.html?id=<?=$saveStat?>"><img src="<?php print URL_PUBLIC?>images/form/btreservation-Confirmation.png" width="259" height="54" alt="予約内容の確認" /></a></p>
	<div class="logout r-txt">→<a href="<?php print URL_PUBLIC?>">TOPページへ</a></div>
	</div>

</section>
