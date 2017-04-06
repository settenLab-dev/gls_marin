<?php if ($activity->getErrorCount() > 0) {?>
<?php print create_error_caption($activity->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<?php for ($i=2; $i<=5; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>一覧画像 <?php print $i-1;?></p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_PIC".$i))?>
			<?=$inputs->image("ACTIVITY_PIC".$i, $activity->getByKey($activity->getKeyValue(), "ACTIVITY_PIC".$i), IMG_ACTIVITY_LIST_WIDTH, IMG_ACTIVITY_LIST_HEIGHT, IMG_ACTIVITY_LIST_SIZE, "", 3)?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>スタッフの一押し</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_STAFFPUSHU"))?>
			<?=$inputs->textarea("ACTIVITY_STAFFPUSHU", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_STAFFPUSHU"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />

<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","店舗一覧情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>
