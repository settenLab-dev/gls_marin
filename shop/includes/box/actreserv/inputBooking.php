<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" widtd="100%">
	<?php
	if ($hotelPlan->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelPlan->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="160" valign="top">
			<p>レジャープラン <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php if ($hotelPlan->getCount() > 0) {?>
			<select id="HOTELPLAN_ID" name="HOTELPLAN_ID" class="circle">
				<?php
				foreach ($hotelPlan->getCollection() as $h) {
					$selected = '';
					if ($h["HOTELPLAN_ID"] == $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ID")) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $h["HOTELPLAN_ID"]?>" <?php print $selected?>><?php print $h["HOTELPLAN_NAME"]?></option>
				<?php }?>
			</select>
			<?php }else {?>
				<p>設定可能なプランがありません</p>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>在庫タイプ <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php if ($hotelPlan->getCount() > 0) {?>
				<?php foreach ($hotelPlan->getCollection() as $h) {?>
				<div id="roombox<?php print $h["HOTELPLAN_ID"]?>" class="labelNoWrap roomboxset dspNon">
					<ul>
				<?php
					$arRoom = array();
					$arTemp = explode(":", $h["HOTELPLAN_ROOM_LIST"]);
					if (count($arTemp) > 0) {
						foreach ($arTemp as $data) {
							if ($data != "") {
								$arRoom[] = $data;
							?>
						<li><input type="radio" id="room<?php print $h["HOTELPLAN_ID"]?><?php print $data?>" name="ROOM_ID" value="<?php print $data?>" <?php print $checked;?> <?php print $disabled;?> /><label for="room<?php print $h["HOTELPLAN_ID"]?><?php print $data?>"> <?php print $hotelRoom->getByKey($data, "ROOM_NAME")?></label></li>
							<?php
							}
						}
					}
				?>
					</ul>
				</div>
				<?php }?>
			<?php }?>


			<script type="text/javascript">
			$(document).ready(function(){
				$("#HOTELPLAN_ID").change(function () {
					$('.roomboxset').addClass('dspNon');
					$('#roombox'+$(this).val()).removeClass('dspNon');
					$("input[name='ROOM_ID']").attr("checked", false);
					urlchange();
				});
				$("input[name='ROOM_ID']").change(function () {
					urlchange();
				});

				urlchange();
			});

			<?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ID") !="") {?>
			$('#roombox<?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_ID")?>').removeClass('dspNon');
			urlchange();
			<?php }else{?>
			$('#roombox<?php print $arRoom[0]?>').removeClass('dspNon');
			urlchange();
			<?php }?>

			function urlchange() {
				$(".searchstay").attr('href', 'searchStayDate.html?id='+$("#HOTELPLAN_ID").val()+'&key='+$("input[name='ROOM_ID']:checked").val());
			}
			</script>

		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>利用日 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_DATE"))?>
			<?php print $inputs->text("BOOKING_DATE", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_DATE") ,"imeDisabled circle wNum",50)?>

			<a href="searchStayDate.html" class="popup searchstay" rel="windowCallUnload"></a>
			<a href="searchStayDate.html" class="popup searchstay" rel="windowCallUnload"><?=$inputs->button("","","宿泊日検索","circle ")?></a>

			<script type="text/javascript">
			</script>

			<?php /*
			<script type="text/javascript">
			$(function() {
				$("#BOOKING_DATE").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
	                changeYear: true,
	                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	                dayNamesMin: ['日','月','火','水','木','金','土']
				});
			});
			</script>
			*/?>

		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>部屋数 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("room_num"))?>
			<select id="room_num" name="room_num" class="circle">
				<?php for ($i=1; $i<=10; $i++) {?>
				<option value="<?php print $i?>"><?php print $i?>部屋</option>
				<?php }?>
			</select>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約者数 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php for ($i=1; $i<=10; $i++) {?>
			<table id="num<?php print $i?>" border="0" cellpadding="0" cellspacing="0" class="tblInput numboxset dspNon" summary="マスタデータ" width="100%">
				<tr>
					<th rowspan="7"><?php print $i?>部屋目</th>
					<th>大人(男性)</th>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("num1".$i))?>
						<?php print $inputs->text("num1".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "num1".$i) ,"imeDisabled circle wNum",50)?> 人
					</td>
				</tr>
				<tr>
					<th>大人(女性)</th>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("num2".$i))?>
						<?php print $inputs->text("num2".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "num2".$i) ,"imeDisabled circle wNum",50)?> 人
					</td>
				</tr>
				<tr>
					<th>小人</th>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("num3".$i))?>
						<?php print $inputs->text("num3".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "num3".$i) ,"imeDisabled circle wNum",50)?> 人
					</td>
				</tr>
				<tr>
					<th>幼児<br />(A)</th>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("num4".$i))?>
						<?php print $inputs->text("num4".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "num4".$i) ,"imeDisabled circle wNum",50)?> 人
					</td>
				</tr>
				<tr>
					<th>幼児<br />(B)</th>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("num5".$i))?>
						<?php print $inputs->text("num5".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "num5".$i) ,"imeDisabled circle wNum",50)?> 人
					</td>
				</tr>
				<tr>
					<th>幼児<br />(C)</th>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("num6".$i))?>
						<?php print $inputs->text("num6".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "num6".$i) ,"imeDisabled circle wNum",50)?> 人
					</td>
				</tr>
				<tr>
					<th>幼児<br />(D)</th>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("num7".$i))?>
						<?php print $inputs->text("num7".$i, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "num7".$i) ,"imeDisabled circle wNum",50)?> 人
					</td>
				</tr>
			</table>
			<?php }?>

			<script type="text/javascript">
			$(document).ready(function(){
				$("#room_num").change(function () {
					$('.numboxset').addClass('dspNon');
					var i;
					for (i = 1; i <= parseInt($(this).val()); i = i +1){
						$('#num'+i).removeClass('dspNon');
					}
				});
			});

			<?php if ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "room_num") !="") {?>
			var i;
			for (i = 1; i <= parseInt(<?php print $hotelPlan->getByKey($hotelPlan->getKeyValue(), "room_num")?>); i = i +1){
				$('#num'+i).removeClass('dspNon');
			}
			<?php }else{?>
			$('#num1').removeClass('dspNon');
			<?php }?>
			</script>

		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約代表者 氏名 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_NAME1"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_NAME2"))?>
			姓 <?php print $inputs->text("BOOKING_NAME1", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_NAME1") ,"imeActive circle wNum",50)?>
			名 <?php print $inputs->text("BOOKING_NAME2", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_NAME2") ,"imeActive circle wNum",50)?>
			<a href="searchMember.html" class="popup" rel="windowCallUnload"></a>
			<a href="searchMember.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","会員検索","circle ")?></a>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約代表者 氏名(カナ) <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_KANA1"))?>
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_KANA2"))?>
			姓 <?php print $inputs->text("BOOKING_KANA1", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_KANA1") ,"imeActive circle wNum",50)?>
			名 <?php print $inputs->text("BOOKING_KANA2", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_KANA2") ,"imeActive circle wNum",50)?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>予約代表者 住所 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<table class="inner" cellspacing="10">
				<tr>
					<td valign="top">郵便番号</td>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_ZIP"))?>
						<?php print $inputs->text("BOOKING_ZIP", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'BOOKING_PREF_ID\',\'BOOKING_CITY\',\'BOOKING_ADDRESS\');"')?>
						<p>※(例)000-0000の様に、-(ハイフン)付きで入力</p>
						<p>自動で住所が入力されます。</p>
					</td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_PREF_ID"))?>
						<?php
						$arPref = cmGetPrefName();
						?>
						<?php if (count($arPref) > 0) {?>
						<select name=BOOKING_PREF_ID id="BOOKING_PREF_ID" class="circle">
		                  <option value="">---</option>
							<?php foreach ($arPref as $k=>$v) {?>
		                  <option value="<?php print $k;?>" <?php print ($hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_PREF_ID")==$k)?'selected="selected"':''?>><?php print $v;?></option>
							<?php }?>
						<?php }?>
		                </select>
					</td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_CITY"))?>
						<?php print $inputs->text("BOOKING_CITY", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_CITY") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>その他住所</td>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_ADDRESS"))?>
						<?php print $inputs->text("BOOKING_ADDRESS", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_ADDRESS") ,"imeActive circle", "50")?>
					</td>
				</tr>
				<tr>
					<td>建物名</td>
					<td>
						<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_BUILD"))?>
						<?php print $inputs->text("BOOKING_BUILD", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_BUILD") ,"imeActive circle", "50")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>電話番号 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_TEL"))?>
			<?php print $inputs->text("BOOKING_TEL", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_TEL") ,"imeDisabled circle wNum",50)?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>メールアドレス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_MAILADDRESS"))?>
			<?php print $inputs->text("BOOKING_MAILADDRESS", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_MAILADDRESS") ,"imeDisabled circle ",50)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>予約者年齢 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_AGE"))?>
			<?php $ar = cmBookingAge();?>
			<?php if (count($ar) > 0) {?>
			<select name="BOOKING_AGE" class="circle">
				<?php
				foreach ($ar as $k=>$v) {
					$selected = '';
					if ($k == $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_AGE")) {
						$selected = 'selected="selected"';
					}
				?>
				<option value="<?php print $k?>" <?php print $selected?>><?php print $v?></option>
				<?php }?>
			</select>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>質問と回答 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_ANSWER"))?>
			<?=$inputs->textarea("BOOKING_ANSWER", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_ANSWER"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>決済方法 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_HOW"))?>
			<?php print $inputs->radio("BOOKING_HOW1", "BOOKING_HOW", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_HOW") ," 現地決済")?>
			<?php print $inputs->radio("BOOKING_HOW2", "BOOKING_HOW", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_HOW") ," 事前支払い")?>
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>金額 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_MONEY"))?>
			<?php print $inputs->text("BOOKING_MONEY", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_MONEY") ,"imeDisabled circle ",50)?> 円
		</td>
	</tr>
	<tr>
		<td widtd="160" valign="top">
			<p>キャンセル金額</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_MONRY_CANCEL"))?>
			<?php print $inputs->text("BOOKING_MONRY_CANCEL", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_MONRY_CANCEL") ,"imeDisabled circle ",50)?> 円
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			<p>ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_STATUS"))?>
			<?php print $inputs->radio("BOOKING_STATUS1", "BOOKING_STATUS", 1, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_STATUS") ," 予約")?>
			<?php print $inputs->radio("BOOKING_STATUS2", "BOOKING_STATUS", 2, $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_STATUS") ," キャンセル")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>管理メモ</p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelPlan->getErrorByKey("BOOKING_MEMO"))?>
			<?=$inputs->textarea("BOOKING_MEMO", $hotelPlan->getByKey($hotelPlan->getKeyValue(), "BOOKING_MEMO"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("hotelPlan::keyName"), $hotelPlan->getKeyValue())?>
