<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/mstAdmin\.php$/')) {?>
		--><li class="current"><a href="mstAdmin.html">管理者</a></li><!--
		<?php }else{?>
		--><li><a href="mstAdmin.html">管理者設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/mstTag\.php$/')) {?>
		--><li class="current"><a href="mstTag.html">タグ登録</a></li><!--
		<?php }else{?>
		--><li><a href="mstTag.html">タグ登録</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/mstActivityCategory\.php$/')) {?>
		--><li class="current"><a href="mstActivityCategory.html">アクティビティカテゴリ</a></li><!--
		<?php }else{?>
		--><li><a href="mstActivityCategory.html">アクティビティカテゴリ</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/mstActivityCategoryDetail\.php$/')) {?>
		--><li class="current"><a href="mstActivityCategoryDetail.html">詳細カテゴリ</a></li><!--
		<?php }else{?>
		--><li><a href="mstActivityCategoryDetail.html">詳細カテゴリ</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/mstArea\.php$/')) {?>
		--><li class="current"><a href="mstArea.html">エリア設定</a></li><!--
		<?php }else{?>
		--><li><a href="mstArea.html">エリア設定</a></li><!--
		<?php }?>

		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/mstMail\.php$/')) {?>
		--><li class="current"><a href="mstMail.html">メールテンプレート</a></li><!--
		<?php }else{?>
		--><li><a href="mstMail.html">メールテンプレート</a></li><!--
		<?php }?>

	--></ul>
	<br class="clearfix" />
</div>