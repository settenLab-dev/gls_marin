<header id="header2015">
	<div id="header-inner">
	
        <div class="left">
	<div class="logo"><a href="/index.html"><img src="/images/top2015/logo_index.png"></a></div>
    	<!--login-->

	<div class="right">
        <?php 
        //require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');
        //if (!cmCheckPtn($_SERVER['PHP_SELF'],'/login\.php$/')) {?>

        	<?php
			if (!$sess->sessionCheck()) {
			?>
		<aside class="login_cn">
			<ul>
				<li>
					<a href="https://cocotomo.net/regist.html">▼無料会員登録</a>
		           	 </li>
		           	 <li>
	            			<a href="https://cocotomo.net/login.html">▼会員ログイン</a>
	           		 </li>
	        	</ul>
	        </aside>
			<?php
// 				require_once('includes/box/login/loginBoxRight.php');
			}
			else {
			?>

		<aside>
				<img src="/images/front/corner_hana.png">こんにちは！<B><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_HANDLENAME")?></B>さん
<!--
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
-->
						<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post" id="form1" name="form1">
							<?php print $inputs->hidden("logout", $memberInput->getByKey($memberInput->getKeyValue(), "logout"))?>
							<a href="javascript:void(0)" onclick="document.form1.submit();">ログアウト</a>
					        	<!--<?=$inputs->submit("","logout","ログアウト", "circle")?>-->
					       	</form>
		</aside>
                <?php
                }
                ?>
	</div>


            <nav>
                <ul>
                    <li class="navi01"><a href="<?=URL_PUBLIC?>index.html" class="link1">HOME</a></li>
                    <li class="navi02"><a href="<?=URL_PUBLIC?>n_hotel.html" class="link2">宿泊予約</a></li>
                    <li class="navi04"><a href="<?=URL_PUBLIC?>n_coupon.html" class="link4">ココトモ！クーポン</a></li>
                    <li class="navi06"><a href="<?=URL_PUBLIC?>gourmet-list.html" class="link6">グルメ情報</a></li>
                    <li class="navi05"><a href="<?=URL_PUBLIC?>leisure-list.html" class="link5">レジャー予約</a></li>
                    <!--<li class="navi03"><a href="#" class="link3">レンタカー</a></li>-->
                    <li class="navi09"><a href="<?=URL_PUBLIC?>n_affiliate.html" class="link9">お買い物</a></li>
                    <li class="navi07"><a href="<?=URL_PUBLIC?>n_job.html" class="link7">仕事情報</a></li>
                    <li class="navi08"><a href="<?=URL_PUBLIC?>save-points.html" class="stay8">ココトモ！でポイント貯めよう！</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

