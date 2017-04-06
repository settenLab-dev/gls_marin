<?php if ($hotelBookset->getErrorCount() > 0) {?>
<?php print create_error_caption($hotelBookset->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>キャンセル設定</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>基本キャンセル規定の設定 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_CANCEL_SET"))?>
			<?php print $inputs->radio("BOOKSET_CANCEL_SET1", "BOOKSET_CANCEL_SET", 1, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") ," あり")?>
			<?php print $inputs->radio("BOOKSET_CANCEL_SET2", "BOOKSET_CANCEL_SET", 2, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") ," なし")?>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>キャンセル規定</h3>
		</th>
	</tr>
	<?php for ($i=1; $i<=7; $i++) {?>
	<tr>
		<th valign="top" width="160">
			<p>キャンセル規定<?php print $i?></p>
			<?php if ($i == 1) {?>
			<p>(無連絡不着の場合)</p>
			<?php }elseif ($i == 2) {?>
			<p>(当日キャンセルの場合)</p>
			<?php }?>
		</th>
		<td align="left">

			<table class="inner" cellspacing="5">
				<tr>
					<th valign="top" width="80">設定</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_CANCEL_DATA".$i))?>
						<?php print $inputs->radio("BOOKSET_CANCEL_DATA1".$i, "BOOKSET_CANCEL_DATA".$i, 1, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) ," あり")?>
						<?php print $inputs->radio("BOOKSET_CANCEL_DATA2".$i, "BOOKSET_CANCEL_DATA".$i, 2, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) ," なし")?>
					</td>
				</tr>
			</table>
			<table class="inner" id="candata<?php print $i;?>" cellspacing="5">
				<?php if ($i >= 3) {?>
				<tr>
					<th valign="top" width="80">キャンセル日</th>
					<td >
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_CANCEL_DATE".$i))?>
						<p>利用日の<?php print $inputs->text("BOOKSET_CANCEL_DATE_FROM".$i, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i) ,"imeDisabled circle wTime",50)?> 日前 ～
						<?php print $inputs->text("BOOKSET_CANCEL_DATE_TO".$i, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i) ,"imeDisabled circle wTime",50)?> 日前までのキャンセル</p>
					</td>
				</tr>
				<?php }?>
				<tr >
					<th valign="top" width="80">料金設定</th>
					<td >
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_CANCEL_DIVIDE".$i))?>
						<?php print $inputs->radio("BOOKSET_CANCEL_DIVIDE1".$i, "BOOKSET_CANCEL_DIVIDE".$i, 1, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) ," 料金のパーセンテージで設定")?>
						<?php print $inputs->radio("BOOKSET_CANCEL_DIVIDE2".$i, "BOOKSET_CANCEL_DIVIDE".$i, 2, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) ," 固定料金で設定")?>
					</td>
				</tr>
				<tr>
					<th valign="top" >料金</th>
					<td >
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_CANCEL_PAY".$i))?>
						<?php print $inputs->text("BOOKSET_CANCEL_PAY".$i, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i) ,"imeDisabled circle wNum",50)?> ％ / 円
						<p>※料金設定を「パーセント」に設定した場合はパーセントで、<br />固定額の場合はキャンセル料金を入力して下さい。</p>
					</td>
				</tr>
			</table>


			<script type="text/javascript">
			$(function(){
			    $('#BOOKSET_CANCEL_DATA1<?php print $i;?>').click(function(){
				    $('#candata<?php print $i;?>').removeClass('dspNon');
			  	});
			    $('#BOOKSET_CANCEL_DATA2<?php print $i;?>').click(function(){
				    $('#candata<?php print $i;?>').addClass('dspNon');
			  	});

			    <?php if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 2 or $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == "") {?>
			    $('#candata<?php print $i;?>').addClass('dspNon');
			    <?php }?>
			});
			</script>


		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>キャンセル料補足</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_CANCEL_REMARKS"))?>
			<?=$inputs->textarea("BOOKSET_CANCEL_REMARKS", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_REMARKS"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>予約金の設定</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>予約金 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_DIVIDE"))?>
			<?php print $inputs->radio("BOOKSET_BOOKING_DIVIDE1", "BOOKSET_BOOKING_DIVIDE", 1, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_DIVIDE") ," 必要なし")?>
			<?php print $inputs->radio("BOOKSET_BOOKING_DIVIDE2", "BOOKSET_BOOKING_DIVIDE", 2, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_DIVIDE") ," 必要")?>
		</td>
	</tr>
</table>
<br />




<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>通知管理の設定</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>連絡先1 <span class="colorRed">※</span><br />PCメールアドレス</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<th valign="top" >PCメールアドレス</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS"))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS") ,"imeDisabled circle ",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" >確認の為、<br />もう一度入力</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM) ,"imeDisabled circle ",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>連絡先2<br />携帯メールアドレス</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<th valign="top" >携帯メールアドレス</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS2"))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS2", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2") ,"imeDisabled circle ",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" >確認の為、<br />もう一度入力</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM) ,"imeDisabled circle ",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>予約通知方法 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<th valign="top" >通知方法</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_HOW1"))?>
						<?php print $inputs->radio("BOOKSET_BOOKING_HOW11", "BOOKSET_BOOKING_HOW1", 1, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW1") ," FAX")?>
						<?php print $inputs->radio("BOOKSET_BOOKING_HOW12", "BOOKSET_BOOKING_HOW1", 2, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW1") ," メール")?>
						<?php print $inputs->radio("BOOKSET_BOOKING_HOW13", "BOOKSET_BOOKING_HOW1", 3, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW1") ," FAX・メール")?>
					</td>
				</tr>
				<tr>
					<th valign="top" >携帯メール</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_HOW2"))?>
						<?php print $inputs->radio("BOOKSET_BOOKING_HOW21", "BOOKSET_BOOKING_HOW2", 1, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW2") ," 受け取る")?>
						<?php print $inputs->radio("BOOKSET_BOOKING_HOW22", "BOOKSET_BOOKING_HOW2", 2, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW2") ," 受け取らない")?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>利用時当日予約の予約通知追加 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_HOW3"))?>
			<?php print $inputs->radio("BOOKSET_BOOKING_HOW31", "BOOKSET_BOOKING_HOW3", 1, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW3") ," 追加なし")?>
			<?php print $inputs->radio("BOOKSET_BOOKING_HOW32", "BOOKSET_BOOKING_HOW3", 2, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW3") ," FAXで受け取る")?>
			<?php print $inputs->radio("BOOKSET_BOOKING_HOW33", "BOOKSET_BOOKING_HOW3", 3, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOW3") ," メールで受け取る")?>
		</td>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>利用日当日の予約通知用の追加メールアドレス</p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<th valign="top" >PCメールアドレス</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS3"))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS3", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3") ,"imeDisabled circle ",50)?>
					</td>
				</tr>
				<tr>
					<th valign="top" >確認の為、<br />もう一度入力</th>
					<td>
						<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM))?>
						<?php print $inputs->text("BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM, $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM) ,"imeDisabled circle ",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>予約受け付け・予約変更締切</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_BOOKING_DAY"))?>
			<?php $arData = cmHotelDaySelect();?>

			<p>
			<?php if (count($arData) > 0) {?>
			<!-- 
			<select name="BOOKSET_BOOKING_DAY" class="circle" <?php print $disabled?>>
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_DAY")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select>
			 -->
			 <?php print $inputs->text("BOOKSET_BOOKING_DAY", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_DAY") ,"imeDisabled circle wNum",5)?> 日前
			<?php }?>
			<?php $arData = cmHotelHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="BOOKSET_BOOKING_HOUR" class="circle" <?php print $disabled?>>
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_HOUR")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="BOOKSET_BOOKING_MIN" class="circle" <?php print $disabled?>>
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_BOOKING_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
			</p>

			<p>※ここで設定した時間が、プランごとに設定できる時間の最大値になります。</p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>予約キャンセル締切</p>
		</th>
		<td align="left">
			<?php print create_error_msg($hotelBookset->getErrorByKey("BOOKSET_CANCEL_DAY"))?>
			<?php $arData = cmHotelDaySelect();?>

			<p>
			<?php if (count($arData) > 0) {?>
			<!-- 
			<select name="BOOKSET_CANCEL_DAY" class="circle" <?php print $disabled?>>
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DAY")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select>
			 -->
			<?php print $inputs->text("BOOKSET_CANCEL_DAY", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DAY") ,"imeDisabled circle wNum",5)?> 日前
			<?php }?>
			<?php $arData = cmHotelHourSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="BOOKSET_CANCEL_HOUR" class="circle" <?php print $disabled?>>
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_HOUR")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 時
			<?php }?>
			<?php $arData = cmHotelMinSelect();?>
			<?php if (count($arData) > 0) {?>
			<select name="BOOKSET_CANCEL_MIN" class="circle" <?php print $disabled?>>
				<?php foreach ($arData as $k=>$v) {?>
				<option value="<?php print $k;?>" <?php print ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_MIN")==$k)?'selected="selected"':''?>><?php print $v;?></option>
				<?php }?>
			</select> 分
			<?php }?>
			</p>

			<p>※ここで設定した時間が、プランごとに設定できる時間の最大値になります。</p>
		</td>
	</tr>
</table>
<br />



<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>料金アラームの設定</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>料金アラーム</p>
		</th>
		<td align="left">
			<?php print $inputs->text("BOOKSET_PAY_ALARM", $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_PAY_ALARM") ,"imeDisabled circle wNum",50)?> 円
			<p>設定した金額以下の料金が登録された場合にエラーメッセージを表示する</p>
		</td>
	</tr>
</table>
<br />


<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","ホテル予約設定を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>
