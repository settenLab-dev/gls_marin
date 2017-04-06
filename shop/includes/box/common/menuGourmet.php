<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetBasic.*\.php$/')) {?>
		--><li class="current"><a href="gourmetBasic.html">店舗基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetBasic.html">店舗基本情報</a></li><!--
		<?php }?>

		<?php
		if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_PREF_ID") != "" and
			$groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_CITY") != "" and
			$groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_ADDRESS") != "") {
		?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetMap.*\.php$/')) {?>
		--><li class="current"><a href="gourmetMap.html">店舗地図設定</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetMap.html">店舗地図設定</a></li><!--
		<?php }?>
		<?php
		}
		?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetCategory.*\.php$/')) {?>
		--><li class="current"><a href="gourmetCategory.html">カテゴリ・エリア設定</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetCategory.html">カテゴリ・エリア設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetList.*\.php$/')) {?>
		--><li class="current"><a href="gourmetList.html">一覧ページ設定</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetList.html">一覧ページ設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetMain.*\.php$/')) {?>
		--><li class="current"><a href="gourmetMain.html">メインページ設定</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetMain.html">メインページ設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetPic.*\.php$/')) {?>
		--><li class="current"><a href="gourmetPic.html">画像ギャラリー設定</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetPic.html">画像ギャラリー設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetCoupon.*\.php$/')) {?>
		--><li class="current"><a href="gourmetCoupon.html">クーポン設定</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetCoupon.html">クーポン設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmetPublic.*\.php$/')) {?>
		--><li class="current"><a href="gourmetPublic.html">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="gourmetPublic.html">公開設定</a></li><!--
		<?php }?>
	--></ul>

	<br class="clearfix" />
</div>