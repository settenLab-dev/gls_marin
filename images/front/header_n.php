<header id="header">
	<div id="header-inner">
        <div class="left">
	<img src="<?=URL_PUBLIC?>images/front/cocotomo_logo.png">
	<div id="r-side"><a href="intro.html"><img src="<?=URL_PUBLIC?>images/front/intro_btn.png"></a></div>

       <div class="right">
	<div id="r-side">

    	<!--login-->
        <?php 
        //require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');
        //if (!cmCheckPtn($_SERVER['PHP_SELF'],'/login\.php$/')) {?>

        	<?php
			if (!$sess->sessionCheck()) {
			?>
			<aside class="login_cn">
				<ul>
					<li>
				    <a href="<?php print URL_PUBLIC?>regist.html"><img src="<?php print URL_PUBLIC?>images/common/side-bt-registration.png" width="180" height="60" alt="会員登録"></a>
	                <p>ココトモ！のご利用には<br>会員登録が必要です。</p>
		            </li>
		            <li>
	            	<a href="<?php print URL_PUBLIC?>login.html"><img src="<?php print URL_PUBLIC?>images/common/side-bt-login.png" width="180" height="60" alt="会員ログイン"></a>
	                <p>ポイントや予約、会員情報の確認は<br>今すぐログイン！</p>
	            </li>
	        	</ul>
	        </aside>
			<?php
// 				require_once('includes/box/login/loginBoxRight.php');
			}
			else {
			?>

		<aside id="status_cn">
			<ul>
				<li>
					<p>こんにちは！<span><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_HANDLENAME")?></span>さん</p>
				</li>
				<li>
						<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					        	<?=$inputs->submit("","logout","ログアウト", "circle")?>
					       	</form>
				</li>
				<li>
					<div>
						<span>現在のポイント</span>
						<strong><?php 
						if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT")>0){
							print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT");
						}else {
							print 0;
						}?>P</strong>
					</div>
					<a href="<?php print URL_PUBLIC?>mypoint.html">▼ポイントの履歴</a>
				</li>
				<li>
					<a href="<?php print URL_PUBLIC?>myhotel.html">▼予約の確認・ｷｬﾝｾﾙ</a>
					<a href="<?php print URL_PUBLIC?>mybasic.html">▼会員情報の変更</a>
					<a href="<?php print URL_PUBLIC?>mypage.html">▼マイページへ</a>
				        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					        	<?=$inputs->submit("","logout","ログアウト", "circle")?>
					       	</form>
				</li>
			</ul>
		</aside>
                <?php
                }
                ?>
	</div>
	</div>
            <nav>
                <ul>
                    <li class="navi01_n"><a href="<?=URL_PUBLIC?>">宿泊予約</a></li>
                    <li class="navi02_n"><a href="<?=URL_PUBLIC?>save-points.html">ココトモ！でポイント貯めよう！</a></li>
                    <li class="navi03_n"><a href="<?=URL_PUBLIC?>coupon_top.html">ココトモ！クーポン</a></li>
                    <li class="navi04_n"><a href="<?=URL_PUBLIC?>">宿泊予約</a></li>
                    <li class="navi05_n"><a href="<?=URL_PUBLIC?>leisure-list.html">レジャー予約</a></li>
                    <li class="navi06_n"><a href="<?=URL_PUBLIC?>gourmet-list.html">グルメ情報</a></li>
                    <li class="navi07_n"><a href="<?=URL_PUBLIC?>affiliate.html">お買い物</a></li>
                    <li class="navi08_n"><a href="<?=URL_PUBLIC?>job.html">サービス業のお仕事探し</a></li>
                </ul>
            </nav>
        </div>
        </div>
    </div>
</header>