<div class="nav">

<ul class="nl clearFix">

		<?php if ($_SERVER['PHP_SELF'] == "/index.php" or $_SERVER['PHP_SELF'] == "/") {?>
		<li class="active"><a href="<?php print URL_SLAKER_ADMIN;?>">TOP</a></li>
		<?php }else{?>
		<li><a href="<?php print URL_SLAKER_ADMIN;?>">TOP</a></li>
		<?php }?>

	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL4") == 1 ) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/shop.*\.php$/')) {?>
		<li class="active"><a href="shop.html">レジャー管理画面</a></li>
		<?php }else{?>
		<li ><a href="shop.html">レジャー管理画面</a></li>
		<?php }?>
	<?php }?>
	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL5") == 1 ) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/kuchikomi.*\.php$/')) {?>
		<li class="active"><a href="kuchikomi.html">体験レポート</a></li>
		<?php }else{?>
		<li ><a href="kuchikomi.html">体験レポート</a></li>
		<?php }?>
	<?php }?>
	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL3") == 1 ) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/contents.*\.php$/')) {?>
		<li class="active"><a href="contents.html">コンテンツ管理</a></li>
		<?php }else{?>
		<li ><a href="contents.html">コンテンツ管理</a></li>
		<?php }?>
	<?php }?>
	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL2") == 1 ) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/member.*\.php$/')) {?>
		<li class="active"><a href="member.html">会員情報</a></li>
		<?php }else{?>
		<li ><a href="member.html">会員情報</a></li>
		<?php }?>
	<?php }?>
	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL1") == 1 ) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/company.*\.php$/')) {?>
		<li class="active"><a href="company.html">契約アカウント</a></li>
		<?php }else{?>
		<li ><a href="company.html">契約アカウント</a></li>
		<?php }?>
	<?php }?>
	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL6") == 1 ) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/invoice.*\.php$/')) {?>
		<li class="active"><a href="invoice.html">請求管理</a></li>
		<?php }else{?>
		<li ><a href="invoice.html">請求管理</a></li>
		<?php }?>
	<?php }?>

	<?php if ($admin->getByKey($admin->getKeyValue(), "ADMIN_LEVEL7") == 1 ) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/mst.*\.php$/')) {?>
		<li class="active"><a href="mstAdmin.html">基本設定</a></li>
		<?php }else{?>
		<li ><a href="mstAdmin.html">基本設定</a></li>
		<?php }?>
	<?php }?>
</ul>

</div>

