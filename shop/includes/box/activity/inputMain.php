<?php if ($activity->getErrorCount() > 0) {?>
<?php print create_error_caption($activity->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<?php for ($i=1; $i<=1; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>メイン画像</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_PIC".$i))?>
			<?=$inputs->image("ACTIVITY_PIC".$i, $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC".$i), IMG_ACTIVITY_DETAIL_WIDTH, IMG_ACTIVITY_DETAIL_HEIGHT, IMG_ACTIVITY_DETAIL_SIZE, "", 3)?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>キャッチコピー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_CATCHCOPY"))?>
			<?=$inputs->textarea("ACTIVITY_CATCHCOPY", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_CATCHCOPY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>店舗紹介</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_CONTENT"))?>
			<?=$inputs->textarea("ACTIVITY_CONTENT", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_CONTENT"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>獲れたてトピックス</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_TOPICKS"))?>
			<?=$inputs->textarea("ACTIVITY_TOPICKS", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_TOPICKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<?php for ($i=1; $i<=4; $i++) {?>
	<tr>
		<th valign="top">
			<p>おすすめ情報<?php print $i;?></p>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<td valign="top">おすすめ画像</td>
					<td>
						<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_RECOMM_PIC".$i))?>
						<?=$inputs->image("ACTIVITY_RECOMM_PIC".$i, $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_PIC".$i), IMG_ACTIVITY_DETAIL_WIDTH, IMG_ACTIVITY_DETAIL_HEIGHT, IMG_ACTIVITY_DETAIL_SIZE, "", 3)?>
					</td>
				</tr>
				<tr>
					<td>タイトル</td>
					<td>
						<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_RECOMM_TITLE".$i))?>
						<?php print $inputs->text("ACTIVITY_RECOMM_TITLE".$i, $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_TITLE".$i) ,"imeActive circle",50)?>
					</td>
				</tr>
				<tr>
					<td valign="top">記事</td>
					<td>
						<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_RECOMM_CONTENT".$i))?>
						<?=$inputs->textarea("ACTIVITY_RECOMM_CONTENT".$i, $activity->getByKey($activity->getKeyValue(), "ACTIVITY_RECOMM_CONTENT".$i), "imeActive circle",30,7)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>
</table>
<br />

<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","店舗メイン情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>