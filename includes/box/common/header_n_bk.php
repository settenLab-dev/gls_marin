<header id="header">
	<div id="header-inner">
        <div class="left">
	<div class="logo"><a href="<?=URL_PUBLIC?>"><img src="<?=URL_PUBLIC?>images/front/cocotomo_logo.png"></a></div>
	<div class="intro"><a href="intro.html"><img src="<?=URL_PUBLIC?>images/front/intro_btn.png"></a></div>
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
	                <p>今すぐ簡単！無料会員登録！</p>
				    <a href="<?php print URL_PUBLIC?>regist.html"><img src="<?php print URL_PUBLIC?>images/front/regist_btn.png" width="160" height="40" alt="会員登録"></a>
		            </li>
		            <li>
	                <p>登録済みの方はログイン！</p>
	            			<a href="<?php print URL_PUBLIC?>login.html"><img src="<?php print URL_PUBLIC?>images/front/login_btn.png" width="159" height="40" alt="会員ログイン"></a>
	            </li>
	        	</ul>
	        </aside>
			<?php
// 				require_once('includes/box/login/loginBoxRight.php');
			}
			else {
			?>

		<aside id="status_cn">
				<img src="<?=URL_PUBLIC?>images/front/corner_hana.png">こんにちは！<B><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_HANDLENAME")?></B>さん
				<div id="r-side">
						<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					        	<?=$inputs->submit("","logout","ログアウト", "circle")?>
					       	</form>
				</div></br>
			<ul>
				<li>
					<div class="point">
						　現在のポイント：<span><?php 
						if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT")>0){
							print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT");
						}else {
							print 0;
						}?> P</span>
					</div>
				</li>
				<li>
					　<a href="<?php print URL_PUBLIC?>mypoint.html">▼ポイントの履歴</a>
				</li>
			</ul>
			<ul>
				<li>
					　<a href="<?php print URL_PUBLIC?>myhotel.html">▼予約の確認・ｷｬﾝｾﾙ</a>
				</li>				
					　<a href="<?php print URL_PUBLIC?>mybasic.html">▼会員情報の変更</a>
				<li>
					　<a href="<?php print URL_PUBLIC?>mypage.html">▼マイページへ</a>

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
                    <li class="navi01_n"><a href="<?=URL_PUBLIC?>">トップページ</a></li>
                    <li class="navi02_n"><a href="<?=URL_PUBLIC?>save-points.html">ココトモ！でポイント貯めよう！</a></li>
                    <li class="navi03_n"><a href="<?=URL_PUBLIC?>coupon_test.html">ココトモ！クーポン</a></li>
                    <li class="navi04_n"><a href="<?=URL_PUBLIC?>n_hotel.html">宿泊予約</a></li>
                    <li class="navi05_n"><a href="<?=URL_PUBLIC?>leisure-list.html">レジャー予約</a></li>
                    <li class="navi06_n"><a href="<?=URL_PUBLIC?>gourmet-list.html">グルメ情報</a></li>
                    <li class="navi07_n"><a href="<?=URL_PUBLIC?>n_affiliate.html">お買い物</a></li>
                    <li class="navi08_n"><a href="<?=URL_PUBLIC?>n_job.html">サービス業のお仕事探し</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>