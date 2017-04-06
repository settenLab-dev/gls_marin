<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopTop.*\.php$/')) {?>
		--><li class="current"><a href="shopTop.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">TOP</a></li><!--
		<?php }else{?>
		--><li><a href="shopTop.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">TOP</a></li><!--
		<?php }?>


		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopBasic.*\.php$/')) {?>
		--><li class="current"><a href="shopBasic.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">ショップ基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="shopBasic.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">ショップ基本情報</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopBookset.*\.php$/')) {?>
		--><li class="current"><a href="shopBookset.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">予約基本設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopBookset.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">予約基本設定</a></li><!--
		<?php }?>

		<?php /* if (cmCheckPtn($_SERVER['PHP_SELF'],'/ShopBase.*\.php$/')) {?>
		--><li class="current"><a href="ShopBase.html">支店設定</a></li><!--
		<?php }else{?>
		--><li><a href="ShopBase.html">支店設定</a></li><!--
		<?php } */?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPlan.*\.php$/')) {?>
		--><li class="current"><a href="shopPlan.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">プラン基本設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopPlan.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">プラン基本設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPriceType.*\.php$/')) {?>
		--><li class="current"><a href="shopPriceType.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">料金タイプ設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopPriceType.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">料金タイプ設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopRoom.*\.php$/')) {?>
		--><li class="current"><a href="shopRoom.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">在庫タイプ登録</a></li><!--
		<?php }else{?>
		--><li><a href="shopRoom.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">在庫タイプ登録</a></li><!--
		<?php }?>


		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopProvide.*\.php$/')) {?>
		--><li class="current"><a href="shopProvide.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">在庫数設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopProvide.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">在庫数設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPublic.*\.php$/')) {?>
		--><li class="current"><a href="shopPublic.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="shopPublic.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">公開設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/ShopAccess.*\.php$/')) {?>
		--><li class="current"><a href="ShopAccess.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">集合場所登録</a></li><!--
		<?php }else{?>
		--><li><a href="ShopAccess.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">集合場所登録</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopPic.*\.php$/')) {?>
		--><li class="current"><a href="shopPic.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">画像登録</a></li><!--
		<?php }else{?>
		--><li><a href="shopPic.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">画像登録</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shopBooking.*\.php$/')) {?>
		--><li class="current"><a href="shopBooking.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">予約管理</a></li><!--
		<?php }else{?>
		--><li><a href="shopBooking.html?id=<?php print cmIdCheck(constant("shop::keyName"));?>">予約管理</a></li><!--
		<?php }?>
	--></ul>
	<br class="clearfix" />
</div>