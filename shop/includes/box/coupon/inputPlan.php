<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" widtd="100%">
	<?php
	if ($couponPlan->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($couponPlan->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
<!--
	<tr>
		<td width="160" valign="top">
			<p>クーポン情報コード</p>
		</td>
		<td align="left">
			<?php if ($couponPlan->getKeyValue() > 0) {?>
			<p><?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID")?><?php print str_pad($couponPlan->getKeyValue(), 8, "0", STR_PAD_LEFT);?></p>
			<?php }else{?>
			<p>登録すると表示されます</p>
			<?php }?>
		</td>
	</tr>
-->
	<tr>
		<td width="160" valign="top">
			<p>販売する店舗 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("room"))?>
			<?php
			$arShop = array();
			$arTemp = explode(":", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SHOP_LIST"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arShop[$data] = $data;
					}
				}
			}

			if ($couponShop->getCount() >0) {
			?>
			<div class="labelNoWrap">
				<ul>
			<?php
				foreach ($couponShop->getCollection() as $d) {
					$checked = '';
					if ($arShop[$d["COUPONSHOP_ID"]] != "") {
						$checked = 'checked="checked"';
					}
			?>
			<li><input type="checkbox" id="room<?php print $d["COUPONSHOP_ID"]?>" name="room[<?php print $d["COUPONSHOP_ID"]?>]" value="<?php print $d["COUPONSHOP_ID"]?>" <?php print $checked;?> <?php print $disabled;?> /><label for="room<?php print $d["COUPONSHOP_ID"]?>"> <?php print $d["COUPONSHOP_NAME"]?></label></li>
			<?php
				}
			?>
				</ul>
			</div>
			<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>販売期間 <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SALE_FROM")?> ～
			<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SALE_TO")?>

			<?php print $inputs->hidden("COUPONPLAN_SALE_FROM",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SALE_FROM"))?>
			<?php print $inputs->hidden("COUPONPLAN_SALE_TO",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SALE_TO"))?>

<!--
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_SALE_FROM"))?>
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_SALE_TO"))?>
			<?php print $inputs->text("COUPONPLAN_SALE_FROM", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SALE_FROM") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COUPONPLAN_SALE_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("COUPONPLAN_SALE_TO", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SALE_TO") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COUPONPLAN_SALE_TO\').val(\'\');"')?>

			<script type="text/javascript">
			$(function() {
				$("#COUPONPLAN_SALE_FROM").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
				$("#COUPONPLAN_SALE_TO").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
			});
			</script>
-->
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>クーポン名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_NAME"))?>

			<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_NAME")?> 
			<?php print $inputs->hidden("COUPONPLAN_NAME",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_NAME"))?>
<!--
			<?php print $inputs->text("COUPONPLAN_NAME", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_NAME") ,"imeActive circle",100)?>
			<p>※全角100文字以内でご入力下さい。</p>
-->
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>キャッチコピー <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print $inputs->text("COUPONPLAN_CATCH", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_CATCH") ,"imeActive circle",300)?>
			<p>※全角300文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>クーポンの詳細</p>
		</td>
		<td align="left">
			<?=$inputs->textarea("COUPONPLAN_DETAIL", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DETAIL"), "imeActive circle",1500,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>利用条件</p>
		</td>
		<td align="left">
			<?=$inputs->textarea("COUPONPLAN_USE", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE"), "imeActive circle",1500,4)?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>予約方法 <span class="colorRed">※</span></p>
		</td>
		<td valign="top">
			<?php print $inputs->textarea("COUPONPLAN_RESERVE", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_RESERVE") ,"imeActive circle",1500,4)?>
			<p>※全角500文字以内でご入力下さい。</p><br/>
			※WEB宿泊予約を行う場合はホテルプランIDを入力してください。</br>
			<?php print $inputs->textarea("COUPONPLAN_HOTELPLAN_ID", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_HOTELPLAN_ID") ,"imeActive circle",100)?>

		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>クーポンの有効期限 <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_FROM")?> ～
			<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO")?>

			<?php print $inputs->hidden("COUPONPLAN_USE_FROM",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_FROM"))?>
			<?php print $inputs->hidden("COUPONPLAN_USE_TO",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO"))?>
<!--
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_USE_FROM"))?>
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_USE_TO"))?>
			<?php print $inputs->text("COUPONPLAN_USE_FROM", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_FROM") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COUPONPLAN_USE_FROM\').val(\'\');"')?> ～
			<?php print $inputs->text("COUPONPLAN_USE_TO", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_TO") ,"imeDisabled circle wNum",50)?>
			<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COUPONPLAN_USE_TO\').val(\'\');"')?>

			<script type="text/javascript">
			$(function() {
				$("#COUPONPLAN_USE_FROM").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
				$("#COUPONPLAN_USE_TO").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
			});
			</script>
-->
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>クーポンの有効期限の備考 <span class="colorRed">※</span></p>
		</td>
		<td valign="top">
			<?php print $inputs->textarea("COUPONPLAN_USE_MEMO", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_MEMO") ,"imeActive circle",1500,4)?>
			<p>※全角500文字以内でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>クーポン販売価格 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SELL_PRICE")?> 円
			<?php print $inputs->hidden("COUPONPLAN_SELL_PRICE",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SELL_PRICE"))?>

<!--
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_SELL_PRICE"))?>

			<?php print $inputs->text("COUPONPLAN_SELL_PRICE", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_SELL_PRICE") ,"imeDisabled circle wNum",100)?> 円
			<p>※半角数字でご入力下さい。</p>
-->
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>通常販売価格 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_DEAL_PRICE"))?>
			<?php print $inputs->radio("COUPONPLAN_DEAL_SP1", "COUPONPLAN_DEAL_SP", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEAL_SP") ,"特別価格と表示(割引率なし)")?><br/>
			<?php print $inputs->radio("COUPONPLAN_DEAL_SP2", "COUPONPLAN_DEAL_SP", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEAL_SP") ," 通常価格からの割引率を表示")?>
			<?php print $inputs->text("COUPONPLAN_DEAL_PRICE", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEAL_PRICE") ,"imeDisabled circle wNum",100)?>円
			<p>※半角数字でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>送料の設定 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_DELIVERY_FEE"))?>
			<?php print $inputs->radio("COUPONPLAN_DELIVERY_FLG1", "COUPONPLAN_DELIVERY_FLG", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DELIVERY_FLG") ," 設定しない")?><br/>
			<?php print $inputs->radio("COUPONPLAN_DELIVERY_FLG2", "COUPONPLAN_DELIVERY_FLG", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DELIVERY_FLG") ," 設定する")?>
			<?php print $inputs->text("COUPONPLAN_DELIVERY_FEE", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DELIVERY_FEE") ,"imeDisabled circle wNum",100)?>円
			<p>※半角数字でご入力下さい。</p>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>1回の購入枚数制限 <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<?php 
			if ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_FLG") ==1){
				print "設定しない";
			}
			elseif ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_FLG") ==2){
				print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_MIN")."～".$couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_MAX")." 枚";
			}
			else{
			}
			?>


			<?php print $inputs->hidden("COUPONPLAN_DEALNUM_FLG",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_FLG"))?>
			<?php print $inputs->hidden("COUPONPLAN_DEALNUM_MIN",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_MIN"))?>
			<?php print $inputs->hidden("COUPONPLAN_DEALNUM_MAX",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_MAX"))?>
<!--
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_DEALNUM_MIN"))?>

			<?php print $inputs->radio("COUPONPLAN_DEALNUM_FLG1", "COUPONPLAN_DEALNUM_FLG", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_FLG") ," 設定しない")?><br/>
			<?php print $inputs->radio("COUPONPLAN_DEALNUM_FLG2", "COUPONPLAN_DEALNUM_FLG", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_FLG") ," 設定する")?>
			<?php print $inputs->text("COUPONPLAN_DEALNUM_MIN", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_MIN") ,"imeDisabled circle wNum",15)?>～<?php print $inputs->text("COUPONPLAN_DEALNUM_MAX", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALNUM_MAX") ,"imeDisabled circle wNum",15)?>枚
			<p>※半角数字でご入力下さい。</p>
-->
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>1人あたりの購入回数制限 <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<?php 
			if ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_FLG") ==1){
				print "設定しない";
			}
			elseif ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_FLG") ==2){
				print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_MAX")." 回";
			}
			else{
			}
			?>

			<?php print $inputs->hidden("COUPONPLAN_DEALPER_FLG",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_FLG"))?>
			<?php print $inputs->hidden("COUPONPLAN_DEALPER_MIN",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_MIN"))?>
			<?php print $inputs->hidden("COUPONPLAN_DEALPER_MAX",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_MAX"))?>
<!--
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_DEALPER_MIN"))?>

			<?php print $inputs->radio("COUPONPLAN_DEALPER_FLG1", "COUPONPLAN_DEALPER_FLG", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_FLG") ," 設定しない")?><br/>
			<?php print $inputs->radio("COUPONPLAN_DEALPER_FLG2", "COUPONPLAN_DEALPER_FLG", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_FLG") ," 設定する")?>
			<?php print $inputs->text("COUPONPLAN_DEALPER_MIN", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_MIN") ,"imeDisabled circle wNum",15)?>～<?php print $inputs->text("COUPONPLAN_DEALPER_MAX", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_DEALPER_MAX") ,"imeDisabled circle wNum",15)?>回
			<p>※半角数字でご入力下さい。</p>
-->
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>販売上限枚数 <span class="colorRed">※</span></p>
		</td>
		<td align="left">

			<?php 
			if ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_FLG") ==1){
				print "設定しない(現在の販売枚数　".$couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_SELL")."　枚)";
			}
			elseif ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_FLG") ==2){
				$couponProvide = ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_MAX")) - ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_SELL"));
				print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_MAX")."　枚　/　現在の販売枚数　".$couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_SELL")."　枚/　残り　".$couponProvide."　枚";
			}
			else{
			}
			?>

			<?php print $inputs->hidden("COUPONPLAN_PROVIDE_FLG",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_FLG"))?>
			<?php print $inputs->hidden("COUPONPLAN_PROVIDE_MAX",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_MAX"))?>
<!--
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_PROVIDE_MAX"))?>
			<?php print $inputs->radio("COUPONPLAN_PROVIDE_FLG1", "COUPONPLAN_PROVIDE_FLG", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_FLG") ," 設定しない")?><br/>
			<?php print $inputs->radio("COUPONPLAN_PROVIDE_FLG2", "COUPONPLAN_PROVIDE_FLG", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_FLG") ," 設定する")?>

			<?php print $inputs->text("COUPONPLAN_PROVIDE_MAX", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_MAX") ,"imeDisabled circle wNum",15)?>　枚　/　現在の販売枚数　<?php print $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_SELL")?>　枚/　残り　			<?php $couponProvide = ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_MAX")) - ($couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PROVIDE_SELL"))?>
			<?php print $couponProvide?>　枚
			<p>※半角数字でご入力下さい。</p>
-->
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>分割利用 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			許可しない　※現在、分割利用はご利用できません。
			<?php print $inputs->hidden("COUPONPLAN_USE_SEPARATE",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_SEPARATE"))?>
<!--			<?php print $inputs->radio("COUPONPLAN_USE_SEPARATE1", "COUPONPLAN_USE_SEPARATE", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_SEPARATE") ," 許可しない")?><br/>
			<?php print $inputs->radio("COUPONPLAN_USE_SEPARATE2", "COUPONPLAN_USE_SEPARATE", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_USE_SEPARATE") ," 許可する")?>
-->
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>プラン画像1</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_PIC"))?>
			<?=$inputs->image("COUPONPLAN_PIC", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PIC"), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

			<?php if ($couponPic->getCount() > 0) {?>
				<a href="couponGalleryEdit.html?id=COUPONPLAN_PIC" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("COUPONPLAN_PIC_setup", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PIC_setup") ,"imeDisabled circle wNum",50)?>
				<a href="couponGalleryEdit.html?id=COUPONPLAN_PIC&key=<?php print cmKeyCheck("COMPANY_ID")?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>

		</td>
	</tr>
	<?php for ($i=2; $i<=4; $i++) {?>
	<tr>
		<td width="160" valign="top">
			<p>プラン画像<?php print $i?></p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_PIC".$i))?>
			<?=$inputs->image("COUPONPLAN_PIC".$i, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>
<!--
				<?php if ($couponPic->getCount() > 0) {?>
				<a href="hotelGalleryEdit.html?id=COUPONPLAN_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
				<?php print $inputsOnly->text("COUPONPLAN_PIC".$i."_setup", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
				<a href="hotelGalleryEdit.html?id=COUPONPLAN_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
				<?php }?>
-->

		</td>
	</tr>
	<?php }?>
<!-- 
	<tr>
		<td width="160" valign="top">
			<p>ココトモ限定クーポン設定</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_FLG_COCOTOMO"))?>
			<?php print $inputs->radio("COUPONPLAN_FLG_COCOTOMO1", "COUPONPLAN_FLG_COCOTOMO", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_FLG_COCOTOMO") ," ココトモ限定クーポンに設定")?>
			<?php print $inputs->radio("COUPONPLAN_FLG_COCOTOMO2", "COUPONPLAN_FLG_COCOTOMO", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_FLG_COCOTOMO") ," 設定しない")?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>シークレット設定</p>
		</td>
		<td align="left">
			<?php print create_error_msg($couponPlan->getErrorByKey("COUPONPLAN_FLG_SEACRET"))?>
			<?php print $inputs->radio("COUPONPLAN_FLG_SEACRET1", "COUPONPLAN_FLG_SEACRET", 1, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_FLG_SEACRET") ," シークレットを設定")?>
			<?php print $inputs->radio("COUPONPLAN_FLG_SEACRET2", "COUPONPLAN_FLG_SEACRET", 2, $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_FLG_SEACRET") ," 設定しない")?>
		</td>
	</tr>

	<tr>
		<td valign="top">
			<p>エリア <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<div class="checkboxarea">
				<?php
				$arArea = array();
				$arTemp = explode(":", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_AREA_LIST"));
				if (count($arTemp) > 0) {
					foreach ($arTemp as $data) {
						if ($data != "") {
							$arArea[$data] = $data;
						}
					}
				}
				?>
				<?php
				$dataArea = cmJobArea();
				$cnt = 0;
				if (count($dataArea) > 0) {
					foreach ($dataArea as $k=>$v) {
						$cnt++;
						if ($cnt > 31) {
							break;
						}
						$checked = '';
						if ($arArea[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="area<?php print $k?>" name="area[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="area<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>
			</div>
			<br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>カテゴリー <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<div class="checkboxarea">
				<?php
				$arCategory = array();
				$arTemp = explode(":", $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_CATEGORY_LIST"));
				if (count($arTemp) > 0) {
					foreach ($arTemp as $data) {
						if ($data != "") {
							$arCategory[$data] = $data;
						}
					}
				}
				?>
				<?php
				$dataCategory = cmCouponCategory();
				$cnt = 0;
				if (count($dataCategory) > 0) {
					foreach ($dataCategory as $k=>$v) {
						$cnt++;
						if ($cnt > 25) {
							break;
						}
						$checked = '';
						if ($arCategory[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="category<?php print $k?>" name="category[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="category<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>
			</div>
			<br />
		</td>
	</tr>
	<tr>

		<td valign="top">
			<p>掲載位置 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			

		</td>
	</tr>
-->

			<?php print $inputs->hidden("COUPONPLAN_FLG_COCOTOMO",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_FLG_COCOTOMO"))?>
			<?php print $inputs->hidden("COUPONPLAN_FLG_SEACRET",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_FLG_SEACRET"))?>
			<?php print $inputs->hidden("COUPONPLAN_AREA_LIST",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_AREA_LIST"))?>
			<?php print $inputs->hidden("COUPONPLAN_CATEGORY_LIST",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_CATEGORY_LIST"))?>
			<?php print $inputs->hidden("COUPONPLAN_POSITION",  $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_POSITION"))?>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>

<!--
	<?php if ($couponPlan->getKeyValue() > 0 ) {?>
	<li><?=$inputs->submit("","delete","削除する", "circle")?></li>
	<?php }?>
-->
</ul>
<?php print $inputs->hidden($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"), $couponPlan->getKeyValue())?>
