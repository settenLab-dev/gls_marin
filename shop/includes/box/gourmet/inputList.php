<?php if ($groumet->getErrorCount() > 0) {?>
<?php print create_error_caption($groumet->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<?php for ($i=1; $i<=5; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>一覧画像 <?php print $i;?></p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_PIC".$i))?>
			<?=$inputs->image("GOURMET_PIC".$i, $groumet->getByKey($groumet->getKeyValue(), "GOURMET_PIC".$i), IMG_GOURMET_LIST_WIDTH, IMG_GOURMET_LIST_HEIGHT, IMG_GOURMET_LIST_SIZE, "", 3)?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th width="160" valign="top">
			<p>ココトモレポート（画像）</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_PIC6"))?>
			<?=$inputs->image("GOURMET_PIC6", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_PIC6"), IMG_GOURMET_LIST_WIDTH, IMG_GOURMET_LIST_HEIGHT, IMG_GOURMET_LIST_SIZE, "", 3)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ココトモレポート(タイトル)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_CATCHCOPY"))?>
			<?=$inputs->textarea("GOURMET_CATCHCOPY", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_CATCHCOPY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ココトモレポート(本文)</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_STAFFPUSHU"))?>
			<?=$inputs->textarea("GOURMET_STAFFPUSHU", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_STAFFPUSHU"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />
<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","店舗一覧情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>