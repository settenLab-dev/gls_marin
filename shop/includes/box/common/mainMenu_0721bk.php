<div class="nav">

<ul class="nl clearFix">
	<?php if ($_SERVER['PHP_SELF'] == "/index.php" or $_SERVER['PHP_SELF'] == "/") {?>
	<li class="active"><a href="<?php print URL_SLAKER_SHOP;?>">管理ページTOP</a></li>
	<?php }else{?>
	<li><a href="<?php print URL_SLAKER_SHOP;?>">管理ページTOP</a></li>
	<?php }?>

	<?php if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_GURUME") == 1) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/gourmet.*\.php$/')) {?>
	<li class="active"><a href="gourmetBasic.html">グルメ情報</a></li><li>
		<?php }else{?>
	<li ><a href="gourmetBasic.html">グルメ情報</a></li><li>
		<?php }?>
	<?php }?>

	<?php if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_ACT") == 1) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/activity.*\.php$/')) {?>
	<li class="active"><a href="activityBasic.html">アクティビティ情報</a></li><li>
		<?php }else{?>
	<li ><a href="activityBasic.html">アクティビティ情報</a></li><li>
		<?php }?>
	<?php }?>

	<?php if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_AD") == 1) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/banner.*\.php$/')) {?>
	<li class="active"><a href="banner.html">広告バナー情報</a></li><li>
		<?php }else{?>
	<li ><a href="banner.html">広告バナー情報</a></li><li>
		<?php }?>
	<?php }?>

	<?php if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_AFI") == 1) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/affiliate.*\.php$/')) {?>
	<li class="active"><a href="affiliate.html">アフィリエイト情報</a></li><li>
		<?php }else{?>
	<li ><a href="affiliate.html">アフィリエイト情報</a></li><li>
		<?php }?>
	<?php }?>

	<?php if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_HOTERL") == 1) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/hotel.*\.php$/')) {?>
	<li class="active"><a href="hotelBasic.html">ホテル情報</a></li><li>
		<?php }else{?>
	<li ><a href="hotelBasic.html">ホテル情報</a></li><li>
		<?php }?>
	<?php }?>
	
	<?php if ($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_FUNC_HOTERL") == 2) {?>
		<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/actreserv.*\.php$/')) {?>
	<li class="active"><a href="leisureBasic.html">レジャー予約</a></li><li>
		<?php }else{?>
	<li ><a href="leisureBasic.html">レジャー予約</a></li><li>
		<?php }?>
	<?php }?>

	<?php if (cmCheckPtn($_SERVER['PHP_SELF'],'/company.*\.php$/')) {?>
	<li class="active"><a href="companyBasic.html">基本設定</a></li>
	<?php }else{?>
	<li ><a href="companyBasic.html">基本設定</a></li>
	<?php }?>
</ul>

</div>

