<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($banner->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($banner->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>バナー表示場所</p>
		</td>
		<td align="left">
			<?php if ($mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_ID") == "") {?>
			<p class="colorRed">※バナー表示箇所が見つかりません。</p>
			<p class="colorRed">既にバナー表示箇所が閉じられている可能性があります。</p>
			<?php }else{?>
			<?php print $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_NAME");?>
			<?php print $inputs->hidden("M_BANNER_PLACE_ID", $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_ID"))?>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">画像 <span class="colorRed">※</span></td>
		<td>
		<?php print create_error_msg($banner->getErrorByKey("BANNER_PIC"))?>
		<?=$inputs->image("BANNER_PIC", $banner->getByKey($banner->getKeyValue(), "BANNER_PIC"), $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_SIZE_W"), $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_SIZE_H"), $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_SIZE_C"), "")?>
		</td>
	</tr>
	<tr>
		<td valign="top">画像<br />(マウスオーバー)</td>
		<td>
		<?php print create_error_msg($banner->getErrorByKey("BANNER_PIC_HOVER"))?>
		<?=$inputs->image("BANNER_PIC_HOVER", $banner->getByKey($banner->getKeyValue(), "BANNER_PIC_HOVER"), $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_SIZE_W"), $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_SIZE_H"), $mBannerplace->getByKey($mBannerplace->getKeyValue(), "M_BANNER_PLACE_SIZE_C"), "")?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>URL <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($banner->getErrorByKey("BANNER_URL"))?>
			<?php print $inputs->text("BANNER_URL", $banner->getByKey($banner->getKeyValue(), "BANNER_URL") ,"imeDisabled circle",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>ALT <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($banner->getErrorByKey("BANNER_ALT"))?>
			<?php print $inputs->text("BANNER_ALT", $banner->getByKey($banner->getKeyValue(), "BANNER_ALT") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($banner->getErrorByKey("BANNER_STATUS"))?>
			<?php print $inputs->radio("BANNER_STATUS1", "BANNER_STATUS", 1, $banner->getByKey($banner->getKeyValue(), "BANNER_STATUS") ," 公開")?>
			<?php print $inputs->radio("BANNER_STATUS2", "BANNER_STATUS", 2, $banner->getByKey($banner->getKeyValue(), "BANNER_STATUS") ," 非公開")?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("banner::keyName"), $banner->getKeyValue())?>
