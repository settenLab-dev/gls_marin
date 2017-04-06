<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activityBasic.*\.php$/')) {?>
		--><li class="current"><a href="activityBasic.html">店舗基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="activityBasic.html">店舗基本情報</a></li><!--
		<?php }?>

		<?php
		if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PREF_ID") != "" and
			$activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_CITY") != "" and
			$activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ADDRESS") != "") {
		?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activityMap.*\.php$/')) {?>
		--><li class="current"><a href="activityMap.html">店舗地図設定</a></li><!--
		<?php }else{?>
		--><li><a href="activityMap.html">店舗地図設定</a></li><!--
		<?php }?>
		<?php
		}
		?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activityCategory.*\.php$/')) {?>
		--><li class="current"><a href="activityCategory.html">カテゴリ・エリア設定</a></li><!--
		<?php }else{?>
		--><li><a href="activityCategory.html">カテゴリ・エリア設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activityList.*\.php$/')) {?>
		--><li class="current"><a href="activityList.html">一覧ページ設定</a></li><!--
		<?php }else{?>
		--><li><a href="activityList.html">一覧ページ設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activityMain.*\.php$/')) {?>
		--><li class="current"><a href="activityMain.html">メインページ設定</a></li><!--
		<?php }else{?>
		--><li><a href="activityMain.html">メインページ設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activityCoupon.*\.php$/')) {?>
		--><li class="current"><a href="activityCoupon.html">クーポン設定</a></li><!--
		<?php }else{?>
		--><li><a href="activityCoupon.html">クーポン設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activityPublic.*\.php$/')) {?>
		--><li class="current"><a href="activityPublic.html">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="activityPublic.html">公開設定</a></li><!--
		<?php }?>
	--></ul>

	<br class="clearfix" />
</div>