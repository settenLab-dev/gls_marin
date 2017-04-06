<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/affiliate.*\.php$/')) {?>
		--><li class="current"><a href="affiliate.html">アフィリエイト基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="affiliate.html">アフィリエイト基本情報</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/affiliateasp.*\.php$/')) {?>
		--><li class="current"><a href="affiliateasp.html">成約会員一覧</a></li><!--
		<?php }else{?>
		--><li><a href="affiliateasp.html">成約会員一覧</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/affiliatePublic.*\.php$/')) {?>
		--><li class="current"><a href="affiliatePublic.html">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="affiliatePublic.html">公開設定</a></li><!--
		<?php }?>
	--></ul>
	<br class="clearfix" />
</div>