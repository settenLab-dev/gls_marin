<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/couponEdit.*\.php$/')) {?>
		--><li class="current"><a href="couponEdit.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="couponEdit.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">基本情報</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/couponShop.*\.php$/')) {?>
		--><li class="current"><a href="couponShop.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">店舗設定</a></li><!--
		<?php }else{?>
		--><li><a href="couponShop.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">店舗設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/couponPlan.*\.php$/')) {?>
		--><li class="current"><a href="couponPlan.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">クーポン情報登録・変更</a></li><!--
		<?php }else{?>
		--><li><a href="couponPlan.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">クーポン情報登録・変更</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/couponPublic.*\.php$/')) {?>
		--><li class="current"><a href="couponPublic.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="couponPublic.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">公開設定</a></li><!--
		<?php }?>
		
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/couponBooking.*\.php$/')) {?>
		--><li class="current"><a href="couponBooking.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">購入履歴</a></li><!--
		<?php }else{?>
		--><li><a href="couponBooking.html?id=<?php print cmIdCheck(constant("coupon::keyName"));?>">購入履歴</a></li><!--
		<?php }?>
	--></ul>
	<br class="clearfix" />
</div>