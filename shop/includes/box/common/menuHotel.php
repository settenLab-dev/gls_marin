<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/index.*\.php$/')) {?>
		--><li class="current"><a href="/">TOP</a></li><!--
		<?php }else{?>
		--><li><a href="/">TOP</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopBasic.*\.php$/')) {?>
		--><li class="current"><a href="shopBasic.html">ショップ基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="shopBasic.html">ショップ基本情報</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopBookset.*\.php$/')) {?>
		--><li class="current"><a href="shopBookset.html">予約基本設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopBookset.html">予約基本設定</a></li><!--
		<?php }?>

		<?php /* if (cmCheckPtn($_SERVER['PHP_SELF'],'/ShopBase.*\.php$/')) {?>
		--><li class="current"><a href="ShopBase.html">支店設定</a></li><!--
		<?php }else{?>
		--><li><a href="ShopBase.html">支店設定</a></li><!--
		<?php } */?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPlan.*\.php$/')) {?>
		--><li class="current"><a href="shopPlan.html">プラン基本設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopPlan.html">プラン基本設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPriceType.*\.php$/')) {?>
		--><li class="current"><a href="hotelPriceType.html">料金タイプ設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopPriceType.html">料金タイプ設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopRoom.*\.php$/')) {?>
		--><li class="current"><a href="shopRoom.html">在庫タイプ登録</a></li><!--
		<?php }else{?>
		--><li><a href="shopRoom.html">在庫タイプ登録</a></li><!--
		<?php }?>


		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopProvide.*\.php$/')) {?>
		--><li class="current"><a href="shopProvide.html">在庫数設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopProvide.html">在庫数設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPublic.*\.php$/')) {?>
		--><li class="current"><a href="shopPublic.html">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopPublic.html">公開設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/ShopAccess.*\.php$/')) {?>
		--><li class="current"><a href="ShopAccess.html">集合場所登録</a></li><!--
		<?php }else{?>
		--><li><a href="ShopAccess.html">集合場所登録</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPic.*\.php$/')) {?>
		--><li class="current"><a href="shopPic.html">画像登録</a></li><!--
		<?php }else{?>
		--><li><a href="shopPic.html">画像登録</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopBooking.*\.php$/')) {?>
		--><li class="current"><a href="shopBooking.html">予約管理</a></li><!--
		<?php }else{?>
		--><li><a href="shopBooking.html">予約管理</a></li><!--
		<?php }?>
	--></ul>
	<br class="clearfix" />
</div>