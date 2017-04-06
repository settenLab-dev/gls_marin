<div id="r-side">

    	<!--login-->
        <?php //if (!cmCheckPtn($_SERVER['PHP_SELF'],'/login\.php$/')) {?>

        	<?php
			if (!$sess->sessionCheck()) {
			?>
			<aside class="login_cn">
				<ul>
					<li>
				    <a href="<?php print URL_PUBLIC?>regist.html"><img src="<?php print URL_PUBLIC?>images/common/side-bt-registration.png" width="180" height="60" alt="会員登録"></a>
	                <p>ココモ。のご利用には<br>会員登録が必要です。</p>
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
                	<div class="date">2013年06月08日</div>
                    <div class="image"><a href="#"><img src="images/sample/img01.jpg"></a></div>
                    <div class="text">
                    	<div class="title"><a href="#">糸満市ウォーキング</a></div>
                        <p>イベント説明文。イベント説明文。イベント説明文。イベント説明</p>
                    </div>
                </li>
                <li class="clearfix">
                	<div class="date">2013年06月08日</div>
                    <div class="image"><a href="#"><img src="images/sample/img01.jpg"></a></div>
                    <div class="text">
                    	<div class="title"><a href="#">糸満市ウォーキング</a></div>
                        <p>イベント説明文。イベント説明文。イベント説明文。イベント説明</p>
                    </div>
                </li>
                <li class="clearfix">
                	<div class="date">2013年06月08日</div>
                    <div class="image"><a href="#"><img src="images/sample/img01.jpg"></a></div>
                    <div class="text">
                    	<div class="title"><a href="#">糸満市ウォーキング</a></div>
                        <p>イベント説明文。イベント説明文。イベント説明文。イベント説明</p>
                    </div>
                </li>
                <li class="clearfix">
                	<div class="date">2013年06月08日</div>
                    <div class="image"><a href="#"><img src="images/sample/img01.jpg"></a></div>
                    <div class="text">
                    	<div class="title"><a href="#">糸満市ウォーキング</a></div>
                        <p>イベント説明文。イベント説明文。イベント説明文。イベント説明</p>
                    </div>
                </li>
            </ul>
        </aside>

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
       		</ul>
        </aside>

		<aside id="leisure-blog">
		<h2><img src="images/common/info-blog.png" width="205" height="33"></h2>
			<ul>
				<li class="cf">
					<img src="images/sample/img02.jpg">
					<div>
						<a href="">2013/00/00</a>
						<p>テキストテキストテキストテキストテキストテキストテキストテキスト</p>
					</div>
				</li>
			</ul>
		</aside>

			<aside class="owner-BannerList">
				<ul>
					<li><a href="#"><img src="./images/banner/banner-a.png" width="205" height="60" alt="xxx" /></a></li>
					<li><a href="#"><img src="./images/banner/banner-a.png" width="205" height="60" alt="xxx" /></a></li>
					<li><a href="#"><img src="./images/banner/banner-a.png" width="205" height="60" alt="xxx" /></a></li>
					<li><a href="#"><img src="./images/banner/banner-a.png" width="205" height="60" alt="xxx" /></a></li>
					<li><a href="#"><img src="./images/banner/banner-a.png" width="205" height="60" alt="xxx" /></a></li>
					<li><a href="#"><img src="./images/banner/banner-a.png" width="205" height="60" alt="xxx" /></a></li>
				</ul>
			</aside>

		<aside class="bannerlink">
			<ul>
				<li><a href="#"><img src="images/sample/dummy-banner120.png"></a></li>
			</ul>
		</aside>
		
        <!--facebook-->
        <?php /*
        <div id="side-fb">
			<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FFacebookDevelopers&amp;width=205&amp;height=290&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=true&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:205px; height:290px;" allowTransparency="true"></iframe>
        </div>
        */?>

    </div>