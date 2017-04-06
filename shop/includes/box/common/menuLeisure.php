<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisureBasic.*\.php$/')) {?>
		--><li class="current"><a href="leisureBasic.html">レジャー基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="leisureBasic.html">レジャー基本情報</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisureBookset.*\.php$/')) {?>
		--><li class="current"><a href="leisureBookset.html">予約基本設定</a></li><!--
		<?php }else{?>
		--><li><a href="leisureBookset.html">予約基本設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisurePic.*\.php$/')) {?>
		--><li class="current"><a href="leisurePic.html">写真設定</a></li><!--
		<?php }else{?>
		--><li><a href="leisurePic.html">写真設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisureRoom.*\.php$/')) {?>
		--><li class="current"><a href="leisureRoom.html">在庫タイプ設定</a></li><!--
		<?php }else{?>
		--><li><a href="leisureRoom.html">在庫タイプ設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisurePlan.*\.php$/')) {?>
		--><li class="current"><a href="leisurePlan.html">プラン設定</a></li><!--
		<?php }else{?>
		--><li><a href="leisurePlan.html">プラン設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisureProvide.*\.php$/')) {?>
		--><li class="current"><a href="leisureProvide.html">提供在庫数調整</a></li><!--
		<?php }else{?>
		--><li><a href="leisureProvide.html">提供在庫数調整</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisurePublic.*\.php$/')) {?>
		--><li class="current"><a href="leisurePublic.html">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="leisurePublic.html">公開設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/leisureBooking.*\.php$/')) {?>
		--><li class="current"><a href="leisureBooking.html">予約管理</a></li><!--
		<?php }else{?>
		--><li><a href="leisureBooking.html">予約管理</a></li><!--
		<?php }?>
	--></ul>
	<br class="clearfix" />
</div>