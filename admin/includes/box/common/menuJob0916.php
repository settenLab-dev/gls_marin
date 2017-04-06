<div class="masterMenuWrap circle">
	<ul class="masterMenu"><!--
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/jobEdit.*\.php$/')) {?>
		--><li class="current"><a href="jobEdit.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">基本情報</a></li><!--
		<?php }else{?>
		--><li><a href="jobEdit.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">基本情報</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/jobBookset.*\.php$/')) {?>
		--><li class="current"><a href="jobBookset.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">問い合わせ基本設定</a></li><!--
		<?php }else{?>
		--><li><a href="jobBookset.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">問い合わせ基本設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/jobPic.*\.php$/')) {?>
		--><li class="current"><a href="jobPic.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">写真設定</a></li><!--
		<?php }else{?>
		--><li><a href="jobPic.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">写真設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/jobShop.*\.php$/')) {?>
		--><li class="current"><a href="jobShop.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">事業所設定</a></li><!--
		<?php }else{?>
		--><li><a href="jobShop.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">事業所設定</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/jobPlan.*\.php$/')) {?>
		--><li class="current"><a href="jobPlan.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">求人情報登録・変更</a></li><!--
		<?php }else{?>
		--><li><a href="jobPlan.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">求人情報登録・変更</a></li><!--
		<?php }?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/jobPublic.*\.php$/')) {?>
		--><li class="current"><a href="jobPublic.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">公開設定</a></li><!--
		<?php }else{?>
		--><li><a href="jobPublic.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">公開設定</a></li><!--
		<?php }?>
		
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/jobBooking.*\.php$/')) {?>
		--><li class="current"><a href="jobBooking.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">問い合わせ管理</a></li><!--
		<?php }else{?>
		--><li><a href="jobBooking.html?id=<?php print cmIdCheck(constant("job::keyName"));?>">問い合わせ管理</a></li><!--
		<?php }?>
	--></ul>
	<br class="clearfix" />
</div>