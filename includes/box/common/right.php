<div id="r-side">

    	<!--login-->
        <?php 
        require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');
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
					<p>こんにちは♪<span><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?></span>さん</p>
				</li>
				<li>
					<a href="">→ご本人でない時はログアウト</a>
				</li>
				<li>
					<div>
						<span>現 在</span>
						<strong><?php 
						if($sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT")>0){
							print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_POINT");
						}else {
							print 0;
						}?>ポイント</strong>
						<!--<a href="">→最近追加したお気に入り</a>-->
					</div>
				</li>
				<li>
					<a href="<?php print URL_PUBLIC?>mypage.html"><img src="<?php print URL_PUBLIC?>images/side/side-bt-mypage.png" width="180" height="46" alt="マイページへ" /></a>
				        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					        	<div class="alignCenter">
									<?=$inputs->submit("","logout","ログアウト", "circle")?>
					        	</div>
				           	</form>
				</li>
			</ul>
		</aside>


				<!--<aside id="side-member">
		        	<div id="member-box">
		                <div id="loginBoxMin">
			                <p>→<a href="<?php print URL_PUBLIC?>mypage.html">MYページTOPへ</a></p>
			                <p>→<a href="<?php print URL_PUBLIC?>mybasic.html">会員基本情報確認・変更</a></p>
				        	<p>→<a href="<?php print URL_PUBLIC?>myhotel.html">ホテル予約情報</a></p>
				        	<p>→<a href="<?php print URL_PUBLIC?>mypoint.html">ポイント履歴</a></p>
				        	<p>→<a href="<?php print URL_PUBLIC?>mycancellation.html">退会</a></p>
				        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
					        	<div class="alignCenter">
									<?=$inputs->submit("","logout","ログアウト", "circle")?>
					        	</div>
				           	</form>
						</div>
		            </div>
		        </aside>-->
                <?php
                }
                ?>

        <?php /*
        <aside id="side-member">
        	<div id="member-box">
                <h2>こんにちは♪<b>ゲスト</b>さん</h2>
                <div class="logout">→<a href="#">ご本人でない時はログアウト</a></div>
                <div class="point">
                    現在
                    <p><b>○○○○</b>ポイント</p>
                </div>
                <!--div class="rankup">
                    あと○○○ポイントで<br>
                    ●●●●クラスへＵＰ！
                </div-->
                <div class="favorite">→<a href="#">最近追加したお気に入り</a></div>
                <div class="btn"><a href="#">マイページへ</a></div>
            </div>
        </aside>
        */?>
        <?php //}?>

        <!--event-->
        <aside id="side-event">
        	<h2><img src="images/side/side-title-event.png" width="205" height="30" alt="イベント情報"></h2>
            <ul>
                <li class="clearfix">
                	<div class="date">2013年12月25日</div>
                    <div class="image"><a href="event4.html"><img src="images/event/event4.jpg" width="56" height="56"></a></div>
                    <div class="text">
                    	<div class="title"><a href="event4.html">1/3～1/8限定！お得なお年玉キャンペーン開催！年始はココトモ！を要チェック♪</a></div>
                    </div>
                </li>
                <li class="clearfix">
                	<div class="date">2013年11月05日</div>
                    <div class="image"><a href="event3.html"><img src="images/side/event/event3_top.jpg"></a></div>
                    <div class="text">
                    	<div class="title"><a href="event3.html">沖縄初！フィットネス＆バーチャルボクササイズin沖縄</a></div>
                        <p><a href="event3.html">元世界チャンピオン直接指導！初心者大歓迎♪</a></p>
                    </div>
                </li>
            	<li class="clearfix">
                	<div class="date">2013年10月10日</div>
                    <div class="image"><a href="event2.html"><img src="images/side/event/event2_top2.jpg"></a></div>
                    <div class="text">
                    	<div class="title"><a href="event2.html">全島1万人サッカー大会限定企画</a></div>
                        <p><a href="event2.html">無料会員登録プレゼント抽選結果発表！</a></p>
                    </div>
                </li>
                <li class="clearfix">
                	<div class="date">2013年10月10日</div>
                    <div class="image"><a href="event1.html"><img src="images/side/event/event1_top.jpg"></a></div>
                    <div class="text">
                    	<div class="title"><a href="event1.html">イベント情報について</a></div>
                    </div>
                </li>
            </ul>
        </aside>

			<?php 
			$banner =  new banner($dbMaster);
			$banner->selectIndex();
			?>
			<aside class="owner-BannerList">
				<h3 class="pr">【PR枠】</h3>
				<ul>
				<?php foreach ($banner->getCollection() as $data){?>
					<li><a href="<?php print $data['BANNER_URL']?>" target="_blank"><img src="<?php print URL_SLAKER_COMMON?>images/<?php print $data['BANNER_PIC']?>" width="205" height="60" alt="<?php print $data['BANNER_ALT']?>" /></a></li>
				<?php }?>
				</ul>
			</aside>

<!--		<aside class="bannerlink">
			<ul>
				<li><a href="#"><img src="images/sample/dummy-banner120.png"></a></li>
			</ul>
		</aside>-->

        <?php
        require_once(PATH_SLAKER_COMMON.'includes/class/extends/banner.php');
        $banner = new banner($dbMaster);
        $banner->select("", "1", "", "1");
        ?>
        <!--banner-->
        <aside class="bannerlink">
        	<ul>
        	<?php
        	if ($banner->getCount() > 0) {
				foreach ($banner->getCollection() as $ad) {
        	?>
        	<?php if ($ad["BANNER_PIC_HOVER"] == "") {?>
			<li><a href="<?=$ad["BANNER_URL"]?>" class="blank"><img src="<?php print URL_SLAKER_COMMON?>images/<?=$ad["BANNER_PIC"]?>" alt="<?=$ad["BANNER_ALT"]?>"  /></a></li>
			<?php }else{?>
			<li><a href="<?=$ad["BANNER_URL"]?>" class="blank"><img src="<?php print URL_SLAKER_COMMON?>images/<?=$ad["BANNER_PIC"]?>" onmouseout="<?php print URL_SLAKER_COMMON?>images/<?=$ad["BANNER_PIC"]?>" onmouseover="<?php print URL_SLAKER_COMMON?>images/<?=$ad["BANNER_PIC_HOVER"]?>" alt="<?=$ad["BANNER_ALT"]?>"  /></a></li>
			<?php }?>
            <?php
            	}
            }
            ?>
			<li><a href="http://www.cerulean-blue.co.jp/" class="blank"><img src="images/side/banner-right.jpg" alt="沖縄の遊びならおまかせ！セルリアンブルー"  /></a></li>
      		</ul>
        </aside>

		<?php if('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == URL_PUBLIC or 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == URL_PUBLIC.'index.html') {?>
        <!--banner-->
        <aside class="bannerlink">
        	<ul>
					<li><a href="job.html"><img src="./images/side/img_job.png" width="205" height="121" alt="サービス業専門のお仕事探し" /></a></li>
       		</ul>
        </aside>

		<aside id="leisure-blog">
		<h2><a href="http://cocotomo.ti-da.net/"><img src="images/side/outdoor.png" width="205" height="38"></a></h2>
			<ul>
				<li class="cf">
					<img src="images/side/tent.jpg" width="80" style="height: auto;">
					<div>
						<a href="http://cocotomo.ti-da.net/">ブログはじまります！</a>
						<p>アウトドア初心者＆上級者のスタッフが、沖縄の旬な外遊びをお届けします♪</p>
					</div>
				</li>
			</ul>
		</aside>

        <!--facebook-->
        <div id="side-fb">
		<h2><img src="images/side/title_facebook.png" width="203" height="22"></h2>
        	<div>
			<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F%25E7%259C%258C%25E6%25B0%2591%25E9%2599%2590%25E5%25AE%259A%25E3%2583%25AC%25E3%2582%25B8%25E3%2583%25A3%25E3%2583%25BC%25E3%2582%25B5%25E3%2582%25A4%25E3%2583%2588%25E3%2582%25B3%25E3%2582%25B3%25E3%2583%25A2-kokomo%2F159647334241391&amp;width=292&amp;height=590&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=true&amp;show_border=false&amp;appId=376679175764729" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:576px;" allowTransparency="true"></iframe>
			</div>
        </div>
		<?php }?>
    </div>