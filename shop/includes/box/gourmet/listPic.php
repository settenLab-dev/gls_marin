<?php if ($gourmetPic->getErrorCount() > 0) {?>
<?php print create_error_caption($gourmetPic->getError())?>
<?php }?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<thead>
		<tr>
		<th colspan="3">
			<h3>写真グループ
			<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="gourmetPicGroupEdit.html" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","新しいグループを登録","circle ")?></a> <a href="gourmetPicGroupOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","グループを並び替える","circle ")?></a>
			<?php }?>
			</h3>
		</th>
	</tr>
		<tr>
			<th width="50"><p>ID</p></th>
			<th><p>名称</p></th>
			<th width="50"><p>編集</p></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>外観</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>店内</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>料理</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>飲み物</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<tr>
			<td <?=$rclass?>>-</td>
			<td <?=$rclass?>>その他</td>
			<td <?=$rclass?> align="center">-</td>
		</tr>
		<?php if ($gourmetPicGroup->getCount() > 0) {?>
			<?php foreach ($gourmetPicGroup->getCollection() as $ad) {?>
			<?php
			$rclass = '';
			if ($ad["GOURMETPICGROUP_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}
			?>
		<tr>
			<td <?=$rclass?>><?=$ad["GOURMETPICGROUP_ID"]?></td>
			<td <?=$rclass?>><?=$ad["GOURMETPICGROUP_NAME"]?></td>
			<td <?=$rclass?> align="center">
			<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="gourmetPicGroupEdit.html?id=<?=$ad["GOURMETPICGROUP_ID"]?>" class="popup" rel="windowCallUnload2"><?=$inputs->button("","","編集","circle")?></a>
			<?php }?>
			</td>
		</tr>
			<?php }?>
		<?php }else {?>
		<?php }?>
	</tbody>
</table>
<br />

<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>登録中の写真
			<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="gourmetPicEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい写真を登録","circle ")?></a> <a href="gourmetPicOrder.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","写真を並び替える","circle ")?></a>
			<?php }?>
			</h3>
		</th>
	</tr>
	<?php if ($gourmetPic->getCount() > 0) {?>
	<tr>
		<th colspan="2">
			<?php
			$cnt = 0;
			$cntAll = 0;
			foreach ($gourmetPic->getCollection() as $ad) {?>
			<?php
			$cnt++;
			$cntAll++;
			$rclass = '';
			if ($ad["GOURMETPIC_STATUS"] == 3) {
				$rclass = 'class="bgLightGrey"';
			}

			if ($cnt == 1) {
				print '<div class="clearfix">';
			}
			?>

			<table cellspacing="0" cellpadding="0" border="0" class="blockHotelPic">
				<tr>
					<td colspan="2">
						<?php if ($ad["GOURMETPICGROUP_ID"] > 0) {?>
						<?php print $gourmetPicGroup->getByKey($ad["GOURMETPICGROUP_ID"], "GOURMETPICGROUP_NAME")?>
						<?php }else{
							switch ($ad["GOURMETPICGROUP_ID"]) {
								case -1:
									print "外観";
									break;
								case -2:
									print "店内";
									break;
								case -3:
									print "料理";
									break;
								case -4:
									print "飲み物";
									break;
								case -5:
									print "その他";
									break;
							}
						}?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?=$inputsOnly->image("GOURMETPIC_DATA", $ad["GOURMETPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>
					</td>
				</tr>
				<?php /*
				<tr>
					<td colspan="2"><img src="<?php print URL_SLAKER_COMMON."images/".$ad["GOURMETPIC_DATA"]?>" /></td>
				</tr>
				*/?>
				<tr>
					<td>ステータス</td>
					<td>
						<?php
						if ($ad["GOURMETPIC_STATUS"] == 1) {
							print "非公開";
						}
						elseif ($ad["GOURMETPIC_STATUS"] == 2) {
							print "公開中";
						}
						?>
					</td>
				</tr>
				<tr>
					<td>ギャラリー</td>
					<td>
						<?php
						if ($ad["GOURMETPIC_DISPLAY_FLG"] == 1) {
							print "表示";
						}
						elseif ($ad["GOURMETPIC_STATUS"] == 2) {
							print "非表示";
						}
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left">
						<?php print redirectForReturn($ad["GOURMETPIC_DISCRIPTION"])?>
					</td>
				</tr>
						<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
				<tr>
					<td colspan="2" align="center">
						<a href="gourmetPicEdit.html?id=<?php print $ad["GOURMETPIC_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle ")?></a>
					</td>
				</tr>
						<?php }?>
			</table>
			<?php
			if ($i == 4 or $gourmetPic->getCount() == $cntAll) {
				print '</div>';
				$i = 0;
			}
			?>
			<?php }?>
		<?php }?>

		</th>
	</tr>
</table>
<br />
