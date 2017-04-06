<?php if ($groumet->getErrorCount() > 0) {?>
<?php print create_error_caption($groumet->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th width="160" valign="top">
			<p>店舗名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_SHOPNAME"))?>
			<?php print $inputs->text("GOURMET_SHOPNAME", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_SHOPNAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>営業時間</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_TIME"))?>
			<?=$inputs->textarea("GOURMET_BASIC_TIME", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_TIME"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ラストオーダー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_LASTORDER"))?>
			<?=$inputs->textarea("GOURMET_BASIC_LASTORDER", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_LASTORDER"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>定休日</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_HOLIDAY"))?>
			<?=$inputs->textarea("GOURMET_BASIC_HOLIDAY", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_HOLIDAY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>総席数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_SHEET"))?>
			<?php print $inputs->text("GOURMET_BASIC_SHEET", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_SHEET") ,"imeActive circle wNum",50)?> 席
			<p>※10文字以内で入力して下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>個室数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_SHEET_PRIVATE"))?>
			<?php print $inputs->text("GOURMET_BASIC_SHEET_PRIVATE", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_SHEET_PRIVATE") ,"imeActive circle wNum",50)?> 席
			<p>※10文字以内で入力して下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>座敷数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_SHEET_TATAMI"))?>
			<?php print $inputs->text("GOURMET_BASIC_SHEET_TATAMI", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_SHEET_TATAMI") ,"imeActive circle wNum",50)?> 席
			<p>※10文字以内で入力して下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>予算</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_MONEY"))?>
			<?=$inputs->textarea("GOURMET_BASIC_MONEY", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_MONEY"), "imeActive circle",30,4)?>
			<p>(例)昼：5,000円～ 夜：7,000円～ など</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>店舗住所 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<td valign="top">郵便番号</td>
					<td>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_ZIP"))?>
						<?php print $inputs->text("GOURMET_BASIC_ZIP", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'GOURMET_BASIC_PREF_ID\',\'GOURMET_BASIC_CITY\',\'GOURMET_BASIC_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
						<p>自動で住所が入力されます。</p>
					</td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td>
					<?php
					$arPref = cmGetPrefName();
					if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") == 3) {
					?>
					<p><?php print $arPref[$groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_PREF_ID")]?></p>
					<?php print $inputs->hidden("GOURMET_BASIC_PREF_ID", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_PREF_ID") ,"imeDisabled circle wNum",50)?>
					<?php
					}
					else {
					?>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_PREF_ID"))?>
						<?php if (count($arPref) > 0) {?>
						<select name=GOURMET_BASIC_PREF_ID id="GOURMET_BASIC_PREF_ID" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_PREF_ID")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						<?php }?>
		                </select>
		             <?php
		             }
		             ?>
					</td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_CITY"))?>
						<?php print $inputs->text("GOURMET_BASIC_CITY", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>その他住所</td>
					<td>
						<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_ADDRESS"))?>
						<?php print $inputs->text("GOURMET_BASIC_ADDRESS", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_ADDRESS") ,"imeActive circle", "50")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_TEL"))?>
			<?php print $inputs->text("GOURMET_BASIC_TEL", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_TEL") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>アクセス</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_ACCESS"))?>
			<?=$inputs->textarea("GOURMET_BASIC_ACCESS", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_ACCESS"), "imeActive circle",30,4)?>
			<p>(例)○○駅東口徒歩2分 など</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>駐車場</p>
		</th>
		<td align="left">
			<?php print create_error_msg($groumet->getErrorByKey("GOURMET_BASIC_PARKING"))?>
			<?=$inputs->textarea("GOURMET_BASIC_PARKING", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_PARKING"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />
<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","店舗基本情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>