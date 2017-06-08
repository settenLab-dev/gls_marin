<?php if ($activity->getErrorCount() > 0) {?>
<?php print create_error_caption($activity->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th width="160" valign="top">
			<p>店舗名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_SHOPNAME"))?>
			<?php print $inputs->text("ACTIVITY_SHOPNAME", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_SHOPNAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>営業時間</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_TIME"))?>
			<?=$inputs->textarea("ACTIVITY_BASIC_TIME", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TIME"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>定休日</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_HOLIDAY"))?>
			<?=$inputs->textarea("ACTIVITY_BASIC_HOLIDAY", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_HOLIDAY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>受け入れ可能人数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_NUM"))?>
			<?php print $inputs->text("ACTIVITY_BASIC_NUM", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_NUM") ,"imeActive circle wNum",50)?> 人
			<p>※10文字以内で入力して下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>送迎</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_GREET"))?>
			<?php print $inputs->radio("ACTIVITY_BASIC_GREET1", "ACTIVITY_BASIC_GREET", 1, $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_GREET") ," あり")?>
			<?php print $inputs->radio("ACTIVITY_BASIC_GREET2", "ACTIVITY_BASIC_GREET", 2, $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_GREET") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>送迎範囲</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_GREET_RANGE"))?>
			<?=$inputs->textarea("ACTIVITY_BASIC_GREET_RANGE", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_GREET_RANGE"), "imeActive circle",30,4)?>
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
						<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_ZIP"))?>
						<?php print $inputs->text("ACTIVITY_BASIC_ZIP", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'ACTIVITY_BASIC_PREF_ID\',\'ACTIVITY_BASIC_CITY\',\'ACTIVITY_BASIC_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
					</td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td>
					<?php
					$arPref = cmGetPrefName();
					if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_STATUS") == 3) {
					?>
					<p><?php print $arPref[$activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PREF_ID")]?></p>
					<?php print $inputs->hidden("ACTIVITY_BASIC_PREF_ID", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PREF_ID") ,"imeDisabled circle wNum",50)?>
					<?php
					}
					else {
					?>
						<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_PREF_ID"))?>
						<?php if (count($arPref) > 0) {?>
						<select name=ACTIVITY_BASIC_PREF_ID id="ACTIVITY_BASIC_PREF_ID" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PREF_ID")==$k)?'selected="selected"':''?>><?php print $v;?></option>
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
						<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_CITY"))?>
						<?php print $inputs->text("ACTIVITY_BASIC_CITY", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>その他住所</td>
					<td>
						<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_ADDRESS"))?>
						<?php print $inputs->text("ACTIVITY_BASIC_ADDRESS", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ADDRESS") ,"imeActive circle", "50")?>
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
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_TEL"))?>
			<?php print $inputs->text("ACTIVITY_BASIC_TEL", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_TEL") ,"imeDisabled circle wNum",50)?>
			<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>アクセス</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_ACCESS"))?>
			<?=$inputs->textarea("ACTIVITY_BASIC_ACCESS", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_ACCESS"), "imeActive circle",30,4)?>
			<p>(例)○○駅東口徒歩2分 など</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>駐車場</p>
		</th>
		<td align="left">
			<?php print create_error_msg($activity->getErrorByKey("ACTIVITY_BASIC_PARKING"))?>
			<?=$inputs->textarea("ACTIVITY_BASIC_PARKING", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_PARKING"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />

<?php if ($activity->getByKey($activity->getKeyValue(), "ACTIVITY_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","アクティビティ情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>
