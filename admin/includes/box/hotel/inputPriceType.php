

<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($hotelPriceType->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelPriceType->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>料金タイプコード</p>
		</td>
		<td align="left">
			<?php if ($hotelPriceType->getKeyValue() > 0) {?>
			<p><?php print $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_ID")?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>料金の種類  <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<?php if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") > 0) {?>
				<?php if ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") == 1) {?>
					<?php  print $inputs->radio("SHOP_PRICETYPE_KIND1", "SHOP_PRICETYPE_KIND", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ," 1名様ごとの料金を設定")?>
				<?php }elseif ($hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") == 2) {?>
					<?php  print $inputs->radio("SHOP_PRICETYPE_KIND2", "SHOP_PRICETYPE_KIND", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ," グループごとの料金を設定（貸切等)")?>
				<?php } ?>

			<?php }else{?>

			<p><span class="colorRed">※一度登録すると変更できません</span></p>
			<?php print create_error_msg($hotelPriceType->getErrorByKey("SHOP_PRICETYPE_KIND"))?>
			<?php  print $inputs->radio("SHOP_PRICETYPE_KIND1", "SHOP_PRICETYPE_KIND", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ," 1名様ごとの料金を設定")?>
			<?php  print $inputs->radio("SHOP_PRICETYPE_KIND2", "SHOP_PRICETYPE_KIND", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_KIND") ," グループごとの料金を設定（貸切等)")?>

			<?php }?>

		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>料金タイプ名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPriceType->getErrorByKey("SHOP_PRICETYPE_NAME"))?>
			<?php print $inputs->text("SHOP_PRICETYPE_NAME", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_NAME") ,"imeActive circle",50)?>
			<p>※全角30文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr id="person">

		<td colspan="2">
				<div class="person_title">1名様ごとの料金を設定</div>
		<table>
			<tr>
				<td width="160" valign="top">
					<p>料金種別(1) <span class="colorRed">※</span></p>
				</td>
				<td align="left">
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND11", "SHOP_PRICETYPE_MONEYKIND1", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND1") ," 大人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND12", "SHOP_PRICETYPE_MONEYKIND1", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND1") ," 小人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND13", "SHOP_PRICETYPE_MONEYKIND1", 3, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND1") ," 幼児")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND14", "SHOP_PRICETYPE_MONEYKIND1", 4, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND1") ," 一律")?>
				</td>
			</tr>
			<tr>
				<td width="160" valign="top">
					<p>対象年齢(1)<span class="colorRed">※</span></p>
				</td>
				<td align="left">
					<?php print $inputs->text("SHOP_PRICETYPE_MONEY1", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY1") ,"imeActive circle",50)?>
					<p> (例)0～5歳、20歳以上など　※30文字以内でご入力下さい。</p>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td width="160" valign="top">
					<p>料金種別(2) </p>
				</td>
				<td align="left">
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND21", "SHOP_PRICETYPE_MONEYKIND2", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND2") ," 大人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND22", "SHOP_PRICETYPE_MONEYKIND2", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND2") ," 小人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND23", "SHOP_PRICETYPE_MONEYKIND2", 3, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND2") ," 幼児")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND24", "SHOP_PRICETYPE_MONEYKIND2", 4, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND2") ," 一律")?>
				</td>
			</tr>
			<tr>
				<td width="160" valign="top">
					<p>対象年齢(2) </p>
				</td>
				<td align="left">
					<?php print $inputs->text("SHOP_PRICETYPE_MONEY2", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY2") ,"imeActive circle",50)?>
					<p> (例)0～5歳、20歳以上など　※30文字以内でご入力下さい。</p>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td width="160" valign="top">
					<p>料金種別(3) </p>
				</td>
				<td align="left">
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND31", "SHOP_PRICETYPE_MONEYKIND3", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND3") ," 大人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND32", "SHOP_PRICETYPE_MONEYKIND3", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND3") ," 小人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND33", "SHOP_PRICETYPE_MONEYKIND3", 3, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND3") ," 幼児")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND34", "SHOP_PRICETYPE_MONEYKIND3", 4, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND3") ," 一律")?>
				</td>
			</tr>
			<tr>
				<td width="160" valign="top">
					<p>対象年齢(3) </p>
				</td>
				<td align="left">
					<?php print $inputs->text("SHOP_PRICETYPE_MONEY3", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY3") ,"imeActive circle",50)?>
					<p> (例)0～5歳、20歳以上など　※30文字以内でご入力下さい。</p>
				</td>
			</tr>
		</table>
		<table>

			<tr>
				<td width="160" valign="top">
					<p>料金種別 (4)</p>
				</td>
				<td align="left">
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND41", "SHOP_PRICETYPE_MONEYKIND4", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND4") ," 大人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND42", "SHOP_PRICETYPE_MONEYKIND4", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND4") ," 小人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND43", "SHOP_PRICETYPE_MONEYKIND4", 3, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND4") ," 幼児")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND44", "SHOP_PRICETYPE_MONEYKIND4", 4, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND4") ," 一律")?>
				</td>
			</tr>
			<tr>
				<td width="160" valign="top">
					<p>対象年齢(4)</p>
				</td>
				<td align="left">
					<?php print $inputs->text("SHOP_PRICETYPE_MONEY4", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY4") ,"imeActive circle",50)?>
					<p> (例)0～5歳、20歳以上など　※30文字以内でご入力下さい。</p>
				</td>
			</tr>
		</table>
		<table>

			<tr>
				<td width="160" valign="top">
					<p>料金種別(5) </p>
				</td>
				<td align="left">
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND51", "SHOP_PRICETYPE_MONEYKIND5", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND5") ," 大人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND52", "SHOP_PRICETYPE_MONEYKIND5", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND5") ," 小人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND53", "SHOP_PRICETYPE_MONEYKIND5", 3, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND5") ," 幼児")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND54", "SHOP_PRICETYPE_MONEYKIND5", 4, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND5") ," 一律")?>
				</td>
			</tr>
			<tr>
				<td width="160" valign="top">
					<p>対象年齢(5)</p>
				</td>
				<td align="left">
					<?php print $inputs->text("SHOP_PRICETYPE_MONEY5", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY5") ,"imeActive circle",50)?>
					<p> (例)0～5歳、20歳以上など　※30文字以内でご入力下さい。</p>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td width="160" valign="top">
					<p>料金種別(6) </p>
				</td>
				<td align="left">
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND61", "SHOP_PRICETYPE_MONEYKIND6", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND6") ," 大人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND62", "SHOP_PRICETYPE_MONEYKIND6", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND6") ," 小人")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND63", "SHOP_PRICETYPE_MONEYKIND6", 3, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND6") ," 幼児")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_MONEYKIND64", "SHOP_PRICETYPE_MONEYKIND6", 4, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND6") ," 一律")?>
				</td>
			</tr>
			<tr>
				<td width="160" valign="top">
					<p>対象年齢(6) </p>
				</td>
				<td align="left">
					<?php //print create_error_msg($hotelPriceType->getErrorByKey("SHOP_PRICETYPE_NAME"))?>
					<?php print $inputs->text("SHOP_PRICETYPE_MONEY6", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY6") ,"imeActive circle",50)?>										<p> (例)0～5歳、20歳以上など　※30文字以内でご入力下さい。</p>
				</td>
			</tr>
		</table>

		</td>

	</tr>


	<tr id="group">
		<td colspan="2">
				<div class="group_title">グループごとの料金タイプを設定</div>
		<table>
				<?php $inputs->hidden("SHOP_PRICETYPE_MONEYKIND7", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND7"))?>
			<tr>
				<td width="160" valign="top">
					<p>料金タイトル・単位 <span class="colorRed">※</span></p>
				</td>
				<td align="left">
					<?php //print create_error_msg($hotelPriceType->getErrorByKey("SHOP_PRICETYPE_NAME"))?>
					<?php print $inputs->text("SHOP_PRICETYPE_MONEYKIND7", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEYKIND7") ,"imeActive circle",50)?>
					<p> (例)1グループ、1艘、1棟など　※全角30文字以内でご入力下さい。</p>
				</td>
			</tr>
			<tr>
				<td width="160" valign="top">
					<p>対象人数 <span class="colorRed">※</span></p>
				</td>
				<td align="left">
					<?php //print create_error_msg($hotelPriceType->getErrorByKey("SHOP_PRICETYPE_NAME"))?>
					<?php print $inputs->text("SHOP_PRICETYPE_MONEY7MIN", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY7MIN") ,"imeDisabled circle wNum",30)?> ～ 							<?php print $inputs->text("SHOP_PRICETYPE_MONEY7MAX", $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_MONEY7MAX") ,"imeDisabled circle wNum",30)?> 名
					<p> (例)1～30名、15～15名など　※半角数字でご入力下さい。</p>
				</td>
			</tr>

			<tr>
				<td width="160" valign="top">
					<p>人数追加の可否 <span class="colorRed">※</span></p>
				</td>
				<td align="left">
					<?php print create_error_msg($hotelPriceType->getErrorByKey("SHOP_PRICETYPE_ADDFLG"))?>
					<?php print $inputs->radio("SHOP_PRICETYPE_ADDFLG1", "SHOP_PRICETYPE_ADDFLG", 1, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_ADDFLG") ," 可能")?>
					<?php print $inputs->radio("SHOP_PRICETYPE_ADDFLG2", "SHOP_PRICETYPE_ADDFLG", 2, $hotelPriceType->getByKey($hotelPriceType->getKeyValue(), "SHOP_PRICETYPE_ADDFLG") ," 追加なし")?>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($hotelPriceType->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("hotelPriceType::keyName"), $hotelPriceType->getKeyValue())?><?php //print_r($hotelPriceType)?>