<hr class="head">
<hr class="head">

<header id="header2016">
	<div id="header-inner" class="clearfix">
        <div class="left">
            <h1 class="logo"><a href="/"><img src="images/index2016/logo.png" alt="PlayBooking"></a></h1>
        </div>
        <div class="left">
			<form name="key-search" method="POST" action="/plan-search.html">
			<div class="key-search-box">
	  			<input type="search" name="free" placeholder="例）フライボード、ダイビング" value="" class="">
				<button class="key-search-btn" onclick="document.key-search.submit();">検索</button>
			</div>
			</form>
        </div>

		<!--	<ul class="header_keyword">
				<li>【話題のワード】</li>
				<li><a href="">沖縄×フライボード</a></li>
				<li><a href="">北海道×ラフティング</a></li>
			</ul>
		-->

	<div class="right">
	    	<aside class="header_nav clearfix">




   <?php if (!$sess->sessionCheck()) { ?>
		<div class="mybox" style="line-height: 8px;margin-top: 15px;">
			<a href="/login.html">
			<img src="images/common/icon_login.png" style="float: left; margin:0 5px; width:25px;">
			<div>
			<!--ようこそ！<span>ゲストさん</span><br>-->
			<br>会員登録/ログイン
			</div>
			</a>
		</div>

   <?php }else{ ?>

		<div class="mybox">
			<div>
			<img src="images/common/icon_login.png" style="float: left; margin: 5px;width:25px;">
			</div>
			<div>
			ようこそ！<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_HANDLENAME")?>さん</span><br>
			（<a href="/mypage.html">マイページへ</a>／<a href="" onClick="document.logout.submit();return false">ログアウト</a>）
			</div>
						<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post" name="logout">
							<input type="hidden" name="logout" value="ログアウト">
							
					       	</form>

		</div>

   <?php } ?>

	        </aside>
		</div>
    </div>
</header>