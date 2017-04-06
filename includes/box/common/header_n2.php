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
				    <a href="https://cocotomo.net/regist.html"><img src="<?php print URL_PUBLIC?>images/front/regist_btn.png" width="160" height="40" alt="会員登録"></a>
		            </li>
		            <li>
	                <p>登録済みの方はログイン！</p>
	            			<a href="https://cocotomo.net/login.html"><img src="<?php print URL_PUBLIC?>images/front/login_btn.png" width="159" height="40" alt="会員ログイン"></a>
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
					　<a href="https://cocotomo.net/mypoint.html">▼ポイントの履歴</a>
				</li>
			</ul>
			<ul>
				<li>
					　<a href="https://cocotomo.net/myhotel.html">▼予約の確認・ｷｬﾝｾﾙ</a>
				</li>				
					　<a href="https://cocotomo.net/mybasic.html">▼会員情報の変更</a>
				<li>
					　<a href="https://cocotomo.net/mypage.html">▼マイページへ</a>

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
                    <li class="navi01_n2"><a href="<?=URL_PUBLIC?>" class="link1">トップページ</a></li>
                    <li class="navi02_n2"><a href="<?=URL_PUBLIC?>save-points.html" class="link2">ココトモ！でポイント貯めよう！</a></li>
                    <li class="navi03_n2"><a href="<?=URL_PUBLIC?>coupon_test.html" class="link3">ココトモ！クーポン</a></li>
                    <li class="navi04_n2"><a href="<?=URL_PUBLIC?>n_hotel.html" class="link4">宿泊予約</a></li>
                    <li class="navi05_n2"><a href="<?=URL_PUBLIC?>leisure-list.html" class="link5">レジャー予約</a></li>
                    <li class="navi06_n2"><a href="<?=URL_PUBLIC?>gourmet-list.html" class="link6">グルメ情報</a></li>
                    <li class="navi07_n2"><a href="<?=URL_PUBLIC?>n_affiliate.html" class="link7">お買い物</a></li>
                    <li class="navi08_n2"><a href="<?=URL_PUBLIC?>n_job.html" class="link8">サービス業のお仕事探し</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>