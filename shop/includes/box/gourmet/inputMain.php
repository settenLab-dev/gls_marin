<?php if ($groumet->getErrorCount() > 0) {?>
<?php print create_error_caption($groumet->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
<!--
	<?php for ($i=1; $i<=1; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>メイン画像</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_PIC".$i))?>
			<?=$inputs->image("GOURMET_PIC".$i, $groumet->getByKey($groumet->getKeyValue(), "GOURMET_PIC".$i), IMG_GOURMET_DETAIL_WIDTH, IMG_GOURMET_DETAIL_HEIGHT, IMG_GOURMET_DETAIL_SIZE, "", 3)?>
		</td>
	</tr>
	<?php }?>
-->
	<tr>
		<th valign="top">
			<p>キャッチコピー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_RECOMM_TITLE3"))?>
			<?php print $inputs->text("GOURMET_RECOMM_TITLE3", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_RECOMM_TITLE3") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>店舗紹介</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_RECOMM_CONTENT3"))?>
			<?=$inputs->textarea("GOURMET_RECOMM_CONTENT3", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_RECOMM_CONTENT3"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>新着情報</p>
		</th>
		<td align="left">
			※文章中にリンクを貼る場合は下記のように記入してください。</ br>
			<pre>&lt;a href="表示させたいページのURL" target="blank"&gt;表示させる文章&lt;/a&gt;</pre></ br>
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_TOPICKS"))?>
			<?=$inputs->textarea("GOURMET_TOPICKS", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_TOPICKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<?php for ($i=1; $i<=2; $i++) {?>
	<tr>
		<th valign="top">
			<p>おすすめ情報<?php print $i;?></p>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<td valign="top">おすすめ画像</td>
					<td>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_RECOMM_PIC".$i))?>
						<?=$inputs->image("GOURMET_RECOMM_PIC".$i, $groumet->getByKey($groumet->getKeyValue(), "GOURMET_RECOMM_PIC".$i), IMG_GOURMET_DETAIL_WIDTH, IMG_GOURMET_DETAIL_HEIGHT, IMG_GOURMET_DETAIL_SIZE, "", 3)?>
					</td>
				</tr>
				<tr>
					<td>タイトル</td>
					<td>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_RECOMM_TITLE".$i))?>
						<?php print $inputs->text("GOURMET_RECOMM_TITLE".$i, $groumet->getByKey($groumet->getKeyValue(), "GOURMET_RECOMM_TITLE".$i) ,"imeActive circle",50)?>
					</td>
				</tr>
				<tr>
					<td valign="top">記事</td>
					<td>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_RECOMM_CONTENT".$i))?>
						<?=$inputs->textarea("GOURMET_RECOMM_CONTENT".$i, $groumet->getByKey($groumet->getKeyValue(), "GOURMET_RECOMM_CONTENT".$i), "imeActive circle",30,7)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>

	<tr>
		<th valign="top">
			<p>メニュー情報</p>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<td>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_RECOMM_CONTENT4"))?>
						<?=$inputs->textarea("GOURMET_RECOMM_CONTENT4", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_RECOMM_CONTENT4"), "imeActive circle",30,7)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>


</table>
<br />
<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","店舗メイン情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>