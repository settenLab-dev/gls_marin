<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
	<?php
	if ($shopPlan->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($shopPlan->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="2" class="admin_title">プラン情報の登録</td>
	</tr>
	<tr>
		<th valign="top">
			<p>プランID</p>
		</th>
		<td align="left">
			<?php if ($shopPlan->getKeyValue() > 0) {?>
			<p><?php print $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ID");?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>プラン種別</p>
		</th>
		<td align="left">
			<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG") > 0) {?>
				<?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG") == 1) {?>
					<?php  print $inputs->radio("SHOPPLAN_FLG1", "SHOPPLAN_FLG", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG") ," 通常プラン")?>
				<?php }elseif ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG") == 2) {?>
					<?php  print $inputs->radio("SHOPPLAN_FLG2", "SHOPPLAN_FLG", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG") ," チケット")?>
				<?php } ?>

			<?php }else{?>

			<p><span class="colorRed">※一度登録すると変更できません</span></p>
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_FLG"))?>
			<input type="radio" id="SHOPPLAN_FLG1" name="SHOPPLAN_FLG" value="1" checked  /><label for="SHOPPLAN_FLG1" > 通常プラン</label>
			<?php  print $inputs->radio("SHOPPLAN_FLG2", "SHOPPLAN_FLG", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG") ," チケット")?>

			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>対応言語</p>
		</th>
		<td align="left"><p>※以降は下記より選択した言語でプラン内容を入力してください。</p>
			<?php  print $inputs->radio("SHOPPLAN_LANG_FLG1", "SHOPPLAN_LANG_FLG", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_LANG_FLG") ," 日本語")?>
			<?php  print $inputs->radio("SHOPPLAN_LANG_FLG2", "SHOPPLAN_LANG_FLG", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_LANG_FLG") ," 英語")?>
			<?php  print $inputs->radio("SHOPPLAN_LANG_FLG3", "SHOPPLAN_LANG_FLG", 3, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_LANG_FLG") ," 中国語")?>
			<?php  print $inputs->radio("SHOPPLAN_LANG_FLG4", "SHOPPLAN_LANG_FLG", 4, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_LANG_FLG") ," 韓国語")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>販売期間 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_SALE_FROM"))?>
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_SALE_TO"))?>
			<?php print $inputs->text("SHOPPLAN_SALE_FROM", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_SALE_FROM") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#SHOPPLAN_SALE_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("SHOPPLAN_SALE_TO", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_SALE_TO") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#SHOPPLAN_SALE_TO\').val(\'\');"')?>

			<script type="text/javascript">
			$(function() {
				$("#SHOPPLAN_SALE_FROM").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
				$("#SHOPPLAN_SALE_TO").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
			});
			</script>

		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>プラン名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_NAME"))?>
			<?php print $inputs->text("SHOPPLAN_NAME", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_NAME") ,"imeActive circle",100)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="15" id="standard_plan" width="100%">
	<tr>
		<td colspan="2" class="admin_title">(1)プランの基本情報</td>
	</tr>
	<tr>
		<th valign="top">
			<p>料金に含まれるもの <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_INCLUDE"))?>
			<?=$inputs->textarea("SHOPPLAN_INCLUDE", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_INCLUDE"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>別途費用 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_OPTION"))?>
			<?=$inputs->textarea("SHOPPLAN_OPTION", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_OPTION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ガイド同行</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_GUIDE_FLG"))?>
			<?php print $inputs->radio("SHOPPLAN_GUIDE_FLG1", "SHOPPLAN_GUIDE_FLG", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_GUIDE_FLG") ," ガイド同行あり")?>
			<?php print $inputs->radio("SHOPPLAN_GUIDE_FLG2", "SHOPPLAN_GUIDE_FLG", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_GUIDE_FLG") ," ガイド同行なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>最少催行人数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_DEPARTS_MIN"))?>
			<?php $arData = cmShopAgeSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_DEPARTS_MIN" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEPARTS_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 人
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>申し込み可能人数</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_ENTRY_FROM"))?>
			<?php $arData = cmShopPersonSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_ENTRY_FROM" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ENTRY_FROM")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> ～
			<?php }?>

			<?php $arData = cmShopPersonSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_ENTRY_TO" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ENTRY_TO")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 人
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>対象年齢</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_AGE_FROM"))?>
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_AGE_TO"))?>
			<?php $arData = cmShopAgeSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_AGE_FROM" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_AGE_FROM")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> ～
			<?php }?>

			<?php $arData = cmShopAgeSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_AGE_TO" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_AGE_TO")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 歳
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>対象年齢の補足</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PARENT1"))?>
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PARENT2"))?>
			保護者同伴：
			<?php $arData = cmShopChildAgeSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_PARENT1" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PARENT1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 歳未満
			<?php }?>  <br/><br/>

			保護者同意：
			<?php $arData = cmShopChildAgeSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_PARENT2" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PARENT2")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 歳未満
			<?php }?>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="admin_title">(2)集合場所・送迎・体験場所</td>
	</tr>

	<tr>
		<th valign="top">
			<p>集合場所(1) <span class="colorRed">※</span></p>
		</th>
		<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_MEET_PLACE1"))?>
			  	<?php if ($ShopAccess->getCount() >0) {?>
				<select name="SHOPPLAN_MEET_PLACE1" class="imeActive circle" style="width:100%;">
					<option value="0">未選択</option>

					<?php foreach ($ShopAccess->getCollection() as $d) {
						$checked = '';
						if ($d["SHOP_ACCESS_ID"] == $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_MEET_PLACE1")) {
							$checked = 'selected="selected"';
						}
					?>
					<option value="<?php print $d["SHOP_ACCESS_ID"];?>" <?php print $checked;?>><?php print $d["SHOP_ACCESS_NAME"];?></option>
					<?php }?>
				</select>
				<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>集合場所(2)</p>
		</th>
		<td align="left">
			  	<?php if ($ShopAccess->getCount() >0) {?>
				<select name="SHOPPLAN_MEET_PLACE2" class="imeActive circle" style="width:100%;">
					<option value="0">未選択</option>

					<?php foreach ($ShopAccess->getCollection() as $d) {
						$checked = '';
						if ($d["SHOP_ACCESS_ID"] == $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_MEET_PLACE2")) {
							$checked = 'selected="selected"';
						}
					?>
					<option value="<?php print $d["SHOP_ACCESS_ID"];?>" <?php print $checked;?>><?php print $d["SHOP_ACCESS_NAME"];?></option>
					<?php }?>
				</select>
				<?php }?>
		</td>	</tr>
	<tr>
		<th valign="top">
			<p>集合場所(3)</p>
		</th>
		<td align="left">
			  	<?php if ($ShopAccess->getCount() >0) {?>
				<select name="SHOPPLAN_MEET_PLACE3" class="imeActive circle" style="width:100%;">
					<option value="0">未選択</option>

					<?php foreach ($ShopAccess->getCollection() as $d) {
						$checked = '';
						if ($d["SHOP_ACCESS_ID"] == $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_MEET_PLACE3")) {
							$checked = 'selected="selected"';
						}
					?>
					<option value="<?php print $d["SHOP_ACCESS_ID"];?>" <?php print $checked;?>><?php print $d["SHOP_ACCESS_NAME"];?></option>
					<?php }?>
				</select>
				<?php }?>
		</td>	</tr>
	<tr>
		<th valign="top">
			<p>送迎について<span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOPPLAN_PICKUP", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PICKUP"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>体験場所 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PLAY_PLACE"))?>
			<?php print $inputs->textarea("SHOPPLAN_PLAY_PLACE", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PLAY_PLACE") ,"imeActive circle",30,4)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">(3)集合時間・料金タイプ・在庫タイプの設定</td>
	</tr>
	<tr>
		<th valign="top">
			<p>集合時間 <br/><span class="colorRed">※最大12個</span></p>
		</th>
		<td align="left">
			<table>
				<tr>
					<td>
					</td>
					<td>
					   集合時間
					</td>
					<td>
					   料金タイプ
					</td>
					<td>
					   在庫タイプ
					</td>
				</tr>
				<tr>

					<td style="width:25px;">
						(1)<span class="colorRed">※</span>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_MEET_TIMEHOUR1"))?>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_MEET_TIMEMIN1"))?>
						<?php $arData = cmShopHourSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="SHOPPLAN_MEET_TIMEHOUR1" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_MEET_TIMEHOUR1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> : 
						<?php }?>
						<?php $arData = cmShopMinSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="SHOPPLAN_MEET_TIMEMIN1" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_MEET_TIMEMIN1")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select>
						<?php }?>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PRICETYPE1"))?>
					  	<?php if ($hotelPriceType->getCount() >0) {?>
						<select name="SHOPPLAN_PRICETYPE1" class="imeActive circle" style="width:130px;" onfocus="this.style.width='100%';" onblur="this.style.width='130px';">
							<option value="">未選択</option>

							<?php foreach ($hotelPriceType->getCollection() as $d) {
								$checked = '';
								if ($d["SHOP_PRICETYPE_ID"] == $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PRICETYPE1")) {
									$checked = 'selected="selected"';
								}
							?>
							<option value="<?php print $d["SHOP_PRICETYPE_ID"];?>" <?php print $checked;?>><?php print $d["SHOP_PRICETYPE_NAME"];?></option>
							<?php }?>
						</select>
						<?php }?>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_ROOM1"))?>
						<?php
						if ($hotelRoom->getCount() >0) {?>
						<select name="SHOPPLAN_ROOM1" class="imeActive circle" style="width:130px;" onfocus="this.style.width='100%';" onblur="this.style.width='130px';">
							<option value="">未選択</option>

							<?php foreach ($hotelRoom->getCollection() as $d) {
								$checked = '';
								if ($d["ROOM_ID"] == $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ROOM1")) {
									$checked = 'selected="selected"';
								}
							?>
							<option value="<?php print $d["ROOM_ID"];?>" <?php print $checked;?>><?php print $d["ROOM_NAME"];?></option>
							<?php }?>
						</select>
						<?php }?>
					</td>
				</tr>
				<?php for ($i=2; $i<=12; $i++) { ?>
				<tr>

					<td style="width:25px;">
						<?php print "(".$i.")";?>
					</td>
					<td>
						<?php $arData = cmShopHourSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="SHOPPLAN_MEET_TIMEHOUR<?php print $i; ?>" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_MEET_TIMEHOUR".$i)==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select> : 
						<?php }?>
						<?php $arData = cmShopMinSelect();?>
						<?php if (count($arData) > 0) {?>
						<select name="SHOPPLAN_MEET_TIMEMIN<?php print $i; ?>" class="circle">
							<?php foreach ($arData as $k=>$v) {?>
							<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_MEET_TIMEMIN".$i)==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						</select>
						<?php }?>
					</td>
					<td>
					  	<?php if ($hotelPriceType->getCount() >0) {?>
						<select name="SHOPPLAN_PRICETYPE<?php print $i; ?>" class="imeActive circle" style="width:130px;" onfocus="this.style.width='100%';" onblur="this.style.width='130px';">
							<option value="">未選択</option>

							<?php foreach ($hotelPriceType->getCollection() as $d) {
								$checked = '';
								if ($d["SHOP_PRICETYPE_ID"] == $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PRICETYPE".$i)) {
									$checked = 'selected="selected"';
								}
							?>
							<option value="<?php print $d["SHOP_PRICETYPE_ID"];?>" <?php print $checked;?>><?php print $d["SHOP_PRICETYPE_NAME"];?></option>
							<?php }?>
						</select>
						<?php }?>
					</td>
					<td>
						<?php
						if ($hotelRoom->getCount() >0) {?>
						<select name="SHOPPLAN_ROOM<?php print $i; ?>" class="imeActive circle" style="width:130px;" onfocus="this.style.width='100%';" onblur="this.style.width='130px';">
							<option value="">未選択</option>

							<?php foreach ($hotelRoom->getCollection() as $d) {
								$checked = '';
								if ($d["ROOM_ID"] == $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ROOM".$i)) {
									$checked = 'selected="selected"';
								}
							?>
							<option value="<?php print $d["ROOM_ID"];?>" <?php print $checked;?>><?php print $d["ROOM_NAME"];?></option>
							<?php }?>
						</select>
						<?php }?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>	<tr>
		<th valign="top">
			<p>所要時間 <span class="colorRed">※</span></p>
		</th>
		<td align="left"> 集合から解散までの合計時間
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_ALL_TIME"))?>
			<?php print $inputs->text("SHOPPLAN_ALL_TIME", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ALL_TIME") ,"imeActive circle",100)?>
			<p>(例) 3時間 、3日間　など※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>体験時間 <span class="colorRed">※</span></p>
		</th>
		<td align="left"> 移動時間、準備時間等を除いた体験に要する時間
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PLAY_TIME"))?>
			<?php print $inputs->text("SHOPPLAN_PLAY_TIME", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PLAY_TIME") ,"imeActive circle",100)?>
			<p>(例) 2時間30分 、15分　など※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>

	<tr>
		<th valign="top">
			<p>参加資格 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_LISENCE"))?>
			<?php print $inputs->textarea("SHOPPLAN_LISENCE", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_LISENCE") ,"imeActive circle",30,4)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>注記内容 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CAUTION"))?>
			<?php print $inputs->textarea("SHOPPLAN_CAUTION", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAUTION") ,"imeActive circle",30,4)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">(4)体験スケジュール・持ち物</td>
	</tr>
	<tr>
		<th valign="top">
			<p>体験スケジュール <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table>
				<tr>
					<td>
					   行程
					</td>
					<td>
					   体験の流れ
					</td>
					<td>
					   所要時間
					</td>
				</tr>
				<tr>
					<td>
						<p>(1)</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_SCEDULE_TITLE1"))?>
						<?php print $inputs->textarea("SHOPPLAN_SCEDULE_TITLE1", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_SCEDULE_TITLE1") ,"imeActive circle",150,1)?>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_SCEDULE_TIME1"))?>
						約<?php print $inputs->text("SHOPPLAN_SCEDULE_TIME1", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_SCEDULE_TIME1") ,"imeActive circle",100)?>分
					</td>
				</tr>
				<?php for ($i=2; $i<=8; $i++) { ?>
					<tr>
						<td>
							<p>(<?php print $i; ?>)</p>
						</td>
						<td>
							<?php print $inputs->textarea("SHOPPLAN_SCEDULE_TITLE".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_SCEDULE_TITLE".$i) ,"imeActive circle",150,1)?>
						</td>
						<td>
							約<?php print $inputs->text("SHOPPLAN_SCEDULE_TIME".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_SCEDULE_TIME".$i) ,"imeActive circle",100)?>分
						</td>
					</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ゲストが準備するもの <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_GUEST_PREPARATION"))?>
			<?php print $inputs->textarea("SHOPPLAN_GUEST_PREPARATION", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_GUEST_PREPARATION") ,"imeActive circle",30,4)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">(5)開催条件・中止の対応等について</td>
	</tr>
	<tr>
		<th valign="top">
			<p>開催条件・中止について <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table>
				<tr>
					<td>
						<p>雨天時催行</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP1"))?>
						<?php print $inputs->text("SHOPPLAN_STOP1", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP1") ,"imeActive circle",100)?><br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<p>天候不良・自然災害による中止</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP2"))?>
						<?php print $inputs->text("SHOPPLAN_STOP2", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP2") ,"imeActive circle",100)?><br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<p>機材・設備故障による中止</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP3"))?>
						<?php print $inputs->text("SHOPPLAN_STOP3", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP3") ,"imeActive circle",100)?><br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<p>内容変更</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP4"))?>
						<?php print $inputs->text("SHOPPLAN_STOP4", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP4") ,"imeActive circle",100)?><br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<p>中止の確認方法</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP5"))?>
						<?php print $inputs->text("SHOPPLAN_STOP5", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP5") ,"imeActive circle",100)?><br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<p>中止連絡日</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP6"))?>
						<?php print $inputs->text("SHOPPLAN_STOP6", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP6") ,"imeActive circle",100)?><br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<p>中止連絡時間</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP7"))?>
						<?php print $inputs->text("SHOPPLAN_STOP7", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP7") ,"imeActive circle",100)?><br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<p>中止時の対応</p>
					</td>
					<td>
						<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_STOP8"))?>
						<?php print $inputs->text("SHOPPLAN_STOP8", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_STOP8") ,"imeActive circle",100)?><br /><br />
					</td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>その他 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_ETC"))?>
			<?php print $inputs->textarea("SHOPPLAN_ETC", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ETC") ,"imeActive circle",30,4)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">※モノづくり体験のみ下記を記入</td>
	</tr>
	<tr>
		<th valign="top">
			<p>作れる商品・作品の個数・サイズ <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CRAFT1"))?>
			<?php print $inputs->textarea("SHOPPLAN_CRAFT1", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CRAFT1") ,"imeActive circle",30,4)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>作品のお渡し(期間・別途料金・引渡し場所) <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CRAFT2"))?>
			<?php print $inputs->textarea("SHOPPLAN_CRAFT2", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CRAFT2") ,"imeActive circle",30,4)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">(6)決済・予約締切・キャンセルポリシー</td>
	</tr>
	<tr>
		<th valign="top">
			<p>決済方法 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<div class="labelNoWrap">
			<?php	
				$checked1 = '';
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT1") == "1") {
					$checked1 = 'checked="checked"';
				}

				$checked2 = '';
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT2") == "1") {
					$checked2 = 'checked="checked"';
				}

				$checked3 = '';
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT3") == "1") {
					$checked3 = 'checked="checked"';
				}

				$checked4 = '';
				if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT4") == "1") {
					$checked4 = 'checked="checked"';
				}
			?>

				<ul>
				<li><input type="checkbox" id="payment1" name="SHOPPLAN_PAYMENT1" value="1" <?php print $checked1;?>/><label for="payment1"> 現地で現金決済</label></li>
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG2") == 1) {?>
				<li><input type="checkbox" id="payment2" name="SHOPPLAN_PAYMENT2" value="1" <?php print $checked2;?>/><label for="payment2"> 現地でカード決済</label></li>
			<?php } ?>
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG3") == 1) {?>
				<li><input type="checkbox" id="payment3" name="SHOPPLAN_PAYMENT3" value="1" <?php print $checked3;?>/><label for="payment3"> 事前に現金決済(銀行振込等)</label></li>
			<?php } ?>
			<?php if ($shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG4") == 1) {?>
				<li><input type="checkbox" id="payment4" name="SHOPPLAN_PAYMENT4" value="1" <?php print $checked4;?>/><label for="payment4"> 事前にカード決済</label></li>
			<?php } ?>

				</ul>
			</div>

		</td>
	<tr>
		<th valign="top">
			<p>その他決済方法・備考</p>
		</th>
		<td align="left">
			<?php print $inputs->textarea("SHOPPLAN_PAYMENT5", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PAYMENT5") ,"imeActive circle",30,4)?>
		</td>
	</tr>

	</tr>
	<tr>
		<th valign="top">
			<p>予約受け付け・<span class="colorRed">※</span><br />予約変更締切</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_ACC_DAY"))?>
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_ACC_HOUR"))?>
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_ACC_MIN"))?>

			<?php $arData = cmShopDaySelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_ACC_DAY" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ACC_DAY")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 日前
			<?php }?>

			<?php $arData = cmShopHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_ACC_HOUR" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ACC_HOUR")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmShopMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_ACC_MIN" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_ACC_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>予約キャンセル締切</p>
		</th>
		<td align="left">

			<?php $arData = cmShopDaySelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_CAN_DAY" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_DAY")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 日前
			<?php }?>

			<?php $arData = cmShopHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_CAN_HOUR" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_HOUR")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmShopMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="SHOPPLAN_CAN_MIN" class="circle">
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CAN_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>

		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>キャンセルポリシー設定 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_FLG_CANCEL"))?>
			<?php print $inputs->radio("SHOPPLAN_FLG_CANCEL1", "SHOPPLAN_FLG_CANCEL", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG_CANCEL") ," 標準設定")?>
			<?php print $inputs->radio("SHOPPLAN_FLG_CANCEL2", "SHOPPLAN_FLG_CANCEL", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG_CANCEL") ," 個別設定")?>

			<table class="inner" id="candata" cellspacing="10">
			<?php for ($i=1; $i<=6; $i++) {?>
				<tr>
					<td valign="top" width="100">
						<?php if ($i == 1) {?>
						<p>無断キャンセル</p>
						<?php }elseif ($i == 2) {?>
						<p>当日キャンセル</p>
						<?php }else {?>
						<p>設定<?php print $i?></p>
						<?php }?>
					</td>
					<td align="left">

						<table class="inner" cellspacing="10">
							<?php if ($i >= 3) {?>
							<tr>
								<td valign="top" width="80">キャンセル日</td>
								<td >
									<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CANCEL_FROM".$i))?>
									<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CANCEL_TO".$i))?>
									<p>当日の<?php print $inputs->text("SHOPPLAN_CANCEL_FROM".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i) ,"imeDisabled circle wTime",50)?> 日前 ～
									<?php print $inputs->text("SHOPPLAN_CANCEL_TO".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_TO".$i) ,"imeDisabled circle wTime",50)?> 日前までのキャンセル</p>
								</td>
							</tr>
							<?php }?>
							<tr >
								<td valign="top" width="80">料金設定</td>
								<td >
									<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CANCEL_FLG".$i))?>
									<?php print $inputs->radio("SHOPPLAN_CANCEL_FLG1".$i, "SHOPPLAN_CANCEL_FLG".$i, 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) ," パーセンテージ")?>
									<?php print $inputs->radio("SHOPPLAN_CANCEL_FLG2".$i, "SHOPPLAN_CANCEL_FLG".$i, 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) ," 固定料金")?>
								</td>
							</tr>
							<tr>
								<td valign="top" >料金</td>
								<td >
									<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CANCEL_MONEY".$i))?>
									<?php print $inputs->text("SHOPPLAN_CANCEL_MONEY".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i) ,"imeDisabled circle wNum",50)?> ％ / 円
								</td>
							</tr>
						</table>

					</td>
				</tr>
			<?php }?>
			</table>

			<script type="text/javascript">
					$(function(){
					    $('#SHOPPLAN_FLG_CANCEL1').click(function(){
						    $('#candata').addClass('dspNon');
					  	});
					    $('#SHOPPLAN_FLG_CANCEL2').click(function(){
						    $('#candata').removeClass('dspNon');
					  	});

					    <?php if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG_CANCEL") == 1 or $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_FLG_CANCEL") == "") {?>
					    $('#candata').addClass('dspNon');
					    <?php }?>
					});
			</script>

		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>予約者への質問</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_QUESTION"))?>
			<?=$inputs->textarea("SHOPPLAN_QUESTION", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION"), "imeActive circle",30,4)?>
			<?=$inputs->checkbox("SHOPPLAN_QUESTION_REC","SHOPPLAN_QUESTION_REC",1,$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_QUESTION_REC")," 予約者の回答を必須にする", "")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>予約者からの要望を聞く</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_DEMAND"))?>
			<?=$inputs->checkbox("SHOPPLAN_DEMAND","SHOPPLAN_DEMAND",1,$shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEMAND")," 予約者からの要望を聞く", "")?>
		</td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="15" id="ticket" width="100%">
	<tr>
		<td colspan="2" class="admin_title">(1)チケットの基本情報</td>
	</tr>
		<tr>
		<th style="width:160px;" valign="top">
			<p>利用条件</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOPPLAN_USE", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_USE"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th style="width:160px;" valign="top">
			<p>予約方法 <span class="colorRed">※</span></p>
		</th>
		<td valign="top">
			<?php print $inputs->textarea("SHOPPLAN_RESERVE", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_RESERVE") ,"imeActive circle",30,4)?>
			<p>※全角500文字以内でご入力下さい。</p><br/>
		</td>
	</tr>
	<tr>
		<th style="width:160px;" valign="top">
			<p>チケットの有効期限 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_USE_FROM"))?>
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_USE_TO"))?>
			<?php print $inputs->text("SHOPPLAN_USE_FROM", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_USE_FROM") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#SHOPPLAN_USE_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("SHOPPLAN_USE_TO", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_USE_TO") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#SHOPPLAN_USE_TO\').val(\'\');"')?>

			<script type="text/javascript">
			$(function() {
				$("#SHOPPLAN_USE_FROM").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
				$("#SHOPPLAN_USE_TO").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
			});
			</script>
		</td>
	</tr>
	<tr>
		<th style="width:160px;" valign="top">
			<p>チケットの有効期限の備考 <span class="colorRed">※</span></p>
		</th>
		<td valign="top">
			<?php print $inputs->textarea("SHOPPLAN_USE_MEMO", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_USE_MEMO") ,"imeActive circle",1500,4)?>
			<p>※全角500文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="admin_title">(2)販売価格と枚数上限の設定</td>
	</tr>

	<tr>
		<th style="width:160px;" valign="top">
			<p>チケット販売価格 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_SELL_PRICE"))?>
			<?php print $inputs->text("SHOPPLAN_SELL_PRICE", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_SELL_PRICE") ,"imeDisabled circle wNum",100)?>円
			<p>※半角数字でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<th style="width:160px;" valign="top">
			<p>通常販売価格 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_DEAL_PRICE"))?>
			<?php print $inputs->radio("SHOPPLAN_DEAL_SP1", "SHOPPLAN_DEAL_SP", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEAL_SP") ,"特別価格と表示(割引率なし)")?><br/>
			<?php print $inputs->radio("SHOPPLAN_DEAL_SP2", "SHOPPLAN_DEAL_SP", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEAL_SP") ," 通常価格からの割引率を表示")?>
			<?php print $inputs->text("SHOPPLAN_DEAL_PRICE", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEAL_PRICE") ,"imeDisabled circle wNum",100)?>円
			<p>※半角数字でご入力下さい。</p>
		</td>
	</tr>

	<tr>
		<th style="width:160px;" valign="top">
			<p>1回の購入枚数制限 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_DEALNUM_MIN"))?>
			<?php print $inputs->radio("SHOPPLAN_DEALNUM_FLG1", "SHOPPLAN_DEALNUM_FLG", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALNUM_FLG") ," 設定しない")?><br/>
			<?php print $inputs->radio("SHOPPLAN_DEALNUM_FLG2", "SHOPPLAN_DEALNUM_FLG", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALNUM_FLG") ," 設定する")?>
			<?php print $inputs->text("SHOPPLAN_DEALNUM_MIN", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALNUM_MIN") ,"imeDisabled circle wNum",15)?>～<?php print $inputs->text("SHOPPLAN_DEALNUM_MAX", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALNUM_MAX") ,"imeDisabled circle wNum",15)?>枚
			<p>※半角数字でご入力下さい。</p>
	</tr>
	<tr>
		<th style="width:160px;" valign="top">
			<p>1人あたりの購入回数制限 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_DEALPER_MIN"))?>
			<?php print $inputs->radio("SHOPPLAN_DEALPER_FLG1", "SHOPPLAN_DEALPER_FLG", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALPER_FLG") ," 設定しない")?><br/>
			<?php print $inputs->radio("SHOPPLAN_DEALPER_FLG2", "SHOPPLAN_DEALPER_FLG", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALPER_FLG") ," 設定する")?>
			<?php print $inputs->text("SHOPPLAN_DEALPER_MIN", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALPER_MIN") ,"imeDisabled circle wNum",15)?>～<?php print $inputs->text("SHOPPLAN_DEALPER_MAX", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DEALPER_MAX") ,"imeDisabled circle wNum",15)?>回
			<p>※半角数字でご入力下さい。</p>
	</tr>
	<tr>
		<th style="width:160px;" valign="top">
			<p>販売上限枚数 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PROVIDE_MAX"))?>
			<?php print $inputs->radio("SHOPPLAN_PROVIDE_FLG1", "SHOPPLAN_PROVIDE_FLG", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PROVIDE_FLG") ," 設定しない")?><br/>
			<?php print $inputs->radio("SHOPPLAN_PROVIDE_FLG2", "SHOPPLAN_PROVIDE_FLG", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PROVIDE_FLG") ," 設定する")?>

			<?php print $inputs->text("SHOPPLAN_PROVIDE_MAX", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PROVIDE_MAX") ,"imeDisabled circle wNum",15)?>　枚　/　現在の販売枚数　<?php print $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PROVIDE_SELL")?>　枚/　残り　			<?php $couponProvide = ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PROVIDE_MAX")) - ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PROVIDE_SELL"))?>
			<?php print $couponProvide?>　枚
			<p>※半角数字でご入力下さい。</p>
		</td>
	</tr>
	<!--<tr>
		<th style="width:160px;" valign="top">
			<p>分割利用 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			許可しない　※現在、分割利用はご利用できません。
			<?php print $inputs->hidden("SHOPPLAN_USE_SEPARATE",  $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_USE_SEPARATE"))?>
			<?php print $inputs->radio("SHOPPLAN_USE_SEPARATE1", "SHOPPLAN_USE_SEPARATE", 1, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_USE_SEPARATE") ," 許可しない")?><br/>
			<?php print $inputs->radio("SHOPPLAN_USE_SEPARATE2", "SHOPPLAN_USE_SEPARATE", 2, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_USE_SEPARATE") ," 許可する")?>

		</td>
	</tr>-->
</table>


<table border="0" cellpadding="0" cellspacing="15" id="common" width="100%">
	<tr>
		<div class="admin_title">プラン詳細の登録</div>
	</tr>
	<tr>
		<th valign="top">
			<p>エリア <span class="colorRed">※</span></p>
		</th>
		<td align="left">　体験場所のエリアをお選びください。



		<script>

			// TOP⇒親エリアのソート
			$(function() {
				
				// 以下のセレクトボックスの変更で発動
				$('select[name="SHOPPLAN_AREA_LIST1"]').change(function() {
					
					// 選択されているTOPエリアのクラス名を取得
					var areaName = $('select[name="SHOPPLAN_AREA_LIST1"] option:selected').attr("class");
					console.log(areaName);
					
					// 親エリアの要素数を取得
					var count = $('select[name="SHOPPLAN_AREA_LIST2"]').children().length;
					
					// 親エリアの要素数分、for文で回す
					for (var i=0; i<count; i++) {
						
						var area_par = $('select[name="SHOPPLAN_AREA_LIST2"] option:eq(' + i + ')');
						
						if(area_par.attr("class") === areaName) {
							// 選択したTOPエリアと同じクラス名だった場合
							
							area_par.show();
						}else {
							// 選択したTOPエリアとクラス名が違った場合
							
							if(area_par.attr("class") === "msg2") {
								// 「エリアを選択して下さい」という要素だった場合
								
									area_par.show();  //「エリアを選択して下さい」を表示させる
								//	area_par.prop('selected',true);  //「エリアを選択して下さい」を強制的に選択されている状態にする
							} else {
								// 「エリア名を選択して下さい」という要素でなかった場合
								
								area_par.hide();
							}
						}
					}
				})
			})
		</script>

		<tr>

			<td width="160" valign="top">
				<p>TOPエリア <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_AREA_LIST1"))?>

			<select name="SHOPPLAN_AREA_LIST1" class="circle">
				<option value="0" class="msg1" selected="selected">未設定</option>
				<?php if ($mAreaTop->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mAreaTop->getCollection() as $data) {
						$selectd = '';
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_AREA_LIST1") == $data["M_AREA_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_AREA_ID"]?>" value="<?php print $data["M_AREA_ID"]?>" <?php print $selectd?>><?php print $data["M_AREA_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>

		<script>
			// 親⇒子エリアのソート
			$(function() {
				// 以下のセレクトボックスの変更で発動
				$('select[name="SHOPPLAN_AREA_LIST2"]').change(function() {
					
					// 選択されている親エリアのクラス名を取得
					var areaNameP = $('select[name="SHOPPLAN_AREA_LIST2"] option:selected').attr("value");
					console.log(areaNameP);
					
					// 子エリアの要素数を取得
					var countP = $('select[name="SHOPPLAN_AREA_LIST3"]').children().length;
					
					// 子エリアの要素数分、for文で回す
					for (var i=0; i<countP; i++) {
						
						var area_parP = $('select[name="SHOPPLAN_AREA_LIST3"] option:eq(' + i + ')');
						
						if(area_parP.attr("class") === areaNameP) {
							// 選択した親エリアと同じクラス名だった場合
							
							area_parP.show();
						}else {
							// 選択した親エリアとクラス名が違った場合
							
							if(area_parP.attr("value") === "msg3") {
								// 「エリアを選択して下さい」という要素だった場合
								
									area_parP.show();  //「エリアを選択して下さい」を表示させる
								//	area_parP.prop('selected',true);  //「エリアを選択して下さい」を強制的に選択されている状態にする
							} else {
								// 「エリア名を選択して下さい」という要素でなかった場合
								
								area_parP.hide();
							}
						}
					}
				})

			})
		</script>

		<tr>
			<td width="160" valign="top">
				<p>親エリア <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_AREA_LIST2"))?>

			<select name="SHOPPLAN_AREA_LIST2" class="circle">
				<option value="0" class="msg2" selected="selected">未設定</option>
				<?php if ($mAreaParent->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mAreaParent->getCollection() as $data) {
						$selectd = '';
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_AREA_LIST2") == $data["M_AREA_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_AREA_TOP"]?>" value="<?php print $data["M_AREA_ID"]?>" <?php print $selectd?>><?php print $data["M_AREA_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>
		<tr>
			<td width="160" valign="top">
				<p>子エリア <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_AREA_LIST3"))?>

			<select name="SHOPPLAN_AREA_LIST3" class="circle">
				<option value="0" class="msg3" selected="selected">未設定</option>
				<?php if ($mAreaChild->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mAreaChild->getCollection() as $data) {
						$selectd = '';
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_AREA_LIST3") == $data["M_AREA_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="<?php print $data["M_AREA_PARENT"]?>" value="<?php print $data["M_AREA_ID"]?>" <?php print $selectd?>><?php print $data["M_AREA_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>

		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>カテゴリー <span class="colorRed">※</span></p>
		</th>
		<td align="left">プラン内容に沿ったカテゴリーをお選びください。



		<script>

			// TOP⇒親エリアのソート
			$(function() {
				
				// 以下のセレクトボックスの変更で発動
				$('select[name="SHOPPLAN_CATEGORY1"]').change(function() {
					
					// 選択されているTOPエリアのクラス名を取得
					var cateName = $('select[name="SHOPPLAN_CATEGORY1"] option:selected').attr("class");
					console.log(cateName);
					
					// 親エリアの要素数を取得
					var count_cate = $('select[name="SHOPPLAN_CATEGORY2"]').children().length;
					
					// 親エリアの要素数分、for文で回す
					for (var i=0; i<count_cate; i++) {
						
						var cate_par = $('select[name="SHOPPLAN_CATEGORY2"] option:eq(' + i + ')');
						
						if(cate_par.attr("class") === cateName) {
							// 選択したTOPエリアと同じクラス名だった場合
							
							cate_par.show();
						}else {
							// 選択したTOPエリアとクラス名が違った場合
							
							if(cate_par.attr("class") === "msg5") {
								// 「エリアを選択して下さい」という要素だった場合
								
									cate_par.show();  //「エリアを選択して下さい」を表示させる
								//	area_par.prop('selected',true);  //「エリアを選択して下さい」を強制的に選択されている状態にする
							} else {
								// 「エリア名を選択して下さい」という要素でなかった場合
								
								cate_par.hide();
							}
						}
					}
				})
			})
		</script>

		<tr>

			<td width="160" valign="top">
				<p>TOPカテゴリー <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CATEGORY1"))?>

			<select name="SHOPPLAN_CATEGORY1" class="circle">
				<option value="0" class="msg4" selected="selected">未設定</option>
				<?php if ($mActivityCategoryTop->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mActivityCategoryTop->getCollection() as $data) {
						$selectd = '';
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CATEGORY1") == $data["M_ACT_CATEGORY_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_ACT_CATEGORY_ID"]?>" value="<?php print $data["M_ACT_CATEGORY_ID"]?>" <?php print $selectd?>><?php print $data["M_ACT_CATEGORY_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>

		<script>
			// 親⇒子エリアのソート
			$(function() {
				// 以下のセレクトボックスの変更で発動
				$('select[name="SHOPPLAN_CATEGORY2"]').change(function() {
					
					// 選択されている親エリアのクラス名を取得
					var cateNameP = $('select[name="SHOPPLAN_CATEGORY2"] option:selected').attr("value");
					console.log(cateNameP);
					
					// 子エリアの要素数を取得
					var countP = $('select[name="SHOPPLAN_CATEGORY3"]').children().length;
					
					// 子エリアの要素数分、for文で回す
					for (var i=0; i<countP; i++) {
						
						var cate_parP = $('select[name="SHOPPLAN_CATEGORY3"] option:eq(' + i + ')');
						
						if(cate_parP.attr("class") === cateNameP) {
							// 選択した親エリアと同じクラス名だった場合
							
							cate_parP.show();
						}else {
							// 選択した親エリアとクラス名が違った場合
							
							if(cate_parP.attr("value") === "msg6") {
								// 「エリアを選択して下さい」という要素だった場合
								
									cate_parP.show();  //「エリアを選択して下さい」を表示させる
								//	cate_parP.prop('selected',true);  //「エリアを選択して下さい」を強制的に選択されている状態にする
							} else {
								// 「エリア名を選択して下さい」という要素でなかった場合
								
								cate_parP.hide();
							}
						}
					}
				})

			})
		</script>

		<tr>
			<td width="160" valign="top">
				<p>親カテゴリ <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CATEGORY2"))?>

			<select name="SHOPPLAN_CATEGORY2" class="circle">
				<option value="0" class="msg5" selected="selected">未設定</option>
				<?php if ($mActivityCategoryParent->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mActivityCategoryParent->getCollection() as $data) {
						$selectd = '';
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CATEGORY2") == $data["M_ACT_CATEGORY_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="sort<?php print $data["M_ACT_CATEGORY_TOP"]?>" value="<?php print $data["M_ACT_CATEGORY_ID"]?>" <?php print $selectd?>><?php print $data["M_ACT_CATEGORY_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>



		<script>
			// 子⇒小カテゴリのソート
			$(function() {
				// 以下のセレクトボックスの変更で発動
				$('select[name="SHOPPLAN_CATEGORY3"]').change(function() {
					
					// 選択されている親エリアのクラス名を取得
					var cateNameC = $('select[name="SHOPPLAN_CATEGORY3"] option:selected').attr("value");
					console.log(cateNameC);
					
					// 子エリアの要素数を取得
					var countC = $('select[name="HOPPLAN_CATEGORY_DETAIL"]').children().length;
					
					// 子エリアの要素数分、for文で回す
					for (var i=0; i<countC; i++) {
						
						var cate_parC = $('select[name="SHOPPLAN_CATEGORY_DETAIL"] option:eq(' + i + ')');
						
						if(cate_parC.attr("class") === cateNameC) {
							// 選択した親エリアと同じクラス名だった場合
							
							cate_parC.show();
						}else {
							// 選択した親エリアとクラス名が違った場合
							
							if(cate_parC.attr("value") === "msg7") {
								// 「エリアを選択して下さい」という要素だった場合
								
									cate_parC.show();  //「エリアを選択して下さい」を表示させる
								//	cate_parP.prop('selected',true);  //「エリアを選択して下さい」を強制的に選択されている状態にする
							} else {
								// 「エリア名を選択して下さい」という要素でなかった場合
								
								cate_parC.hide();
							}
						}
					}
				})

			})
		</script>
		<tr>
			<td width="160" valign="top">
				<p>子カテゴリ <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CATEGORY3"))?>

			<select name="SHOPPLAN_CATEGORY3" class="circle">
				<option value="0" class="msg6" selected="selected">未設定</option>
				<?php if ($mActivityCategoryChild->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mActivityCategoryChild->getCollection() as $data) {
						$selectd = '';
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CATEGORY3") == $data["M_ACT_CATEGORY_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="<?php print $data["M_ACT_CATEGORY_PARENT"]?>" value="<?php print $data["M_ACT_CATEGORY_ID"]?>" <?php print $selectd?>><?php print $data["M_ACT_CATEGORY_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>
		<tr>
			<td width="160" valign="top">
				<p>詳細カテゴリ <span class="colorRed">※</span></p>
			</td>
			<td align="left">
				<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CATEGORY_DETAIL"))?>

			<select name="SHOPPLAN_CATEGORY_DETAIL" class="circle">
				<option value="0" class="msg7" selected="selected">未設定</option>
				<?php if ($mActivityCategoryDetail->getCount() > 0) {?>
					<?php
					$selectd = '';
					foreach ($mActivityCategoryDetail->getCollection() as $data) {
						$selectd = '';
						if ($shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CATEGORY_DETAIL") == $data["M_ACT_CATEGORY_D_ID"]) {
							$selectd = 'selected="selected"';
						}
					?>
					<option class="<?php print $data["M_ACT_CATEGORY_D_ID"]?>" value="<?php print $data["M_ACT_CATEGORY_D_ID"]?>" <?php print $selectd?>><?php print $data["M_ACT_CATEGORY_D_NAME"]?></option>
					<?php }?>
				<?php }?>
			</select>

			</td>
		</tr>
		</td>
	</tr>
		<tr>
			<td width="160" valign="top">
				<p>タグ <br/>複数選択可</p>
			</td>

			<td align="left" style="background:#f5f5f5;padding:5px!important;">
				<?php
				$arTag = array();
				$arTemp = explode(":", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_TAG_LIST"));
				if (count($arTemp) > 0) {
					foreach ($arTemp as $data) {
						if ($data != "") {
							$arTag[$data] = $data;
						}
					}
				}
				?>

				<?php if ($mTag->getCount() > 0) {?>
					<?php
					$checked = '';
					foreach ($mTag->getCollection() as $data) {
						$checked = '';
						if ($arTag[$data["M_TAG_ID"]] == $data["M_TAG_ID"]) {
							$checked = 'checked="checked"';
						}
					?>
					<input type="checkbox" id="tag<?php print $data["M_TAG_ID"]?>" name="tag[<?php print $data["M_TAG_ID"]?>]" value="<?php print $data["M_TAG_ID"]?>" <?php print $checked;?> <?php print $disabled;?> /><label for="tag<?php print $data["M_TAG_ID"]?>"> <?php print $data["M_TAG_NAME"]?></label>
					<?php }?>
				<?php }?>

			</td>
		</tr>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>キャッチコピー <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_CATCH"))?>
			<?php print $inputs->text("SHOPPLAN_CATCH", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_CATCH") ,"imeActive circle",100)?>
			<p>※全角100文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>プランの特徴・内容 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_DISCRIPTION"))?>
			<?=$inputs->textarea("SHOPPLAN_DISCRIPTION", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DISCRIPTION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>プラン画像1</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PIC1"))?>
			<?=$inputs->image("SHOPPLAN_PIC1", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PIC1"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

				<?php if ($hotelPic->getCount() > 0) {?>
				<a href="shopGalleryEdit.html?id=SHOPPLAN_PIC1" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("SHOPPLAN_PIC1_setup", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PIC1_setup") ,"imeDisabled circle wNum",50)?>
				<a href="shopGalleryEdit.html?id=SHOPPLAN_PIC1" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>

		</td>
	</tr>
	<?php for ($i=2; $i<=4; $i++) {?>
	<tr>
		<th valign="top">
			<p>プラン画像<?php print $i?></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shopPlan->getErrorByKey("SHOPPLAN_PIC".$i))?>
			<?=$inputs->image("SHOPPLAN_PIC".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

				<?php if ($hotelPic->getCount() > 0) {?>
				<a href="shopGalleryEdit.html?id=SHOPPLAN_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("SHOPPLAN_PIC".$i."_setup", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
				<a href="shopGalleryEdit.html?id=SHOPPLAN_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>

		</td>
	</tr>
	<?php }?>
</table>
<table border="0" cellpadding="0" cellspacing="15" id="common" width="100%">
	<tr>
		<div class="admin_title">プランの魅力(最大9件)</div>
	</tr>
	<?php for ($i=1; $i<=9; $i++) {?>
	<tr>
		<th valign="top">
			<p>画像<?php print $i?></p>
		</th>
		<td align="left">
			<?=$inputs->image("SHOPPLAN_POINT_PIC".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_POINT_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

				<?php if ($hotelPic->getCount() > 0) {?>
				<a href="shopGalleryEdit.html?id=SHOPPLAN_POINT_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("SHOPPLAN_POINT_PIC".$i."_setup", $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_POINT_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
				<a href="shopGalleryEdit.html?id=SHOPPLAN_POINT_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>

		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ポイント<?php print $i?></p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOPPLAN_POINT_TEXT".$i, $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_POINT_TEXT".$i), "imeActive circle",30,4)?>
		</td>
	</tr>
	<?php }?>
</table>

<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
	<?php if ($shopPlan->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
</ul>
<?php print $inputs->hidden(constant("shopPlan::keyName"), $shopPlan->getKeyValue())?>
