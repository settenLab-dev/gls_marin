<script type="text/javascript">
function gotoNEW(){
	var month = $("#NEW_MONTH").find("option:selected").text();
	var year = $("#NEW_YEAR").find("option:selected").text();
	var newdate =year.toString()+'-'+month.toString();
	window.location.href="http://shop.cocotomo.net/leisureProvideEditMonthly.html?id=&key=<?php echo $_GET['key']?>&date="+newdate;
}
</script>
<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" widtd="100%">
	<?php
	if ($hotelProvide->getErrorCount() > 0) {
	?>
	<tr>
		<td colspan="2">
				<?php print create_error_caption($hotelProvide->getError())?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td widtd="160" valign="top">
			<p>入力月間</p>
		</td>
		<td align="left">
			<p><select id="NEW_YEAR"  onchange="gotoNEW();" >
			<?php $date = explode('-',$_GET['date']);
			$newy = $date[0];
			$newm =$date[1];
			for($i=2013;$i<2024;$i++){
			?>
			<option <?php if($newy == $i){?> selected="selected"<?php }?>><?php echo $i?></option>
			<?php }?>
			</select> 年 <select  onchange="gotoNEW();" id="NEW_MONTH">
			<?php 
			for($i=1;$i<13;$i++){
			?>
			<option <?php if($newm == $i){?> selected="selected"<?php }?>><?php echo $i>9?$i:'0'.$i?></option>
			<?php }?>
			</select> 月</p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>在庫タイプ名</p>
		</td>
		<td align="left">
			<p><?php print $hotelRoom->getByKey($hotelRoom->getKeyValue(), "ROOM_NAME")?></p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>販売ステータス <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelProvide->getErrorByKey("HOTELPROVIDE_FLG_STOP"))?>
			<?php if ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") == 1) {?>
			<p>現在ステータスは「販売」に設定されています。</p>
			<?php }elseif ($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") == 2) {?>
			<p>現在ステータスは「売止」に設定されています。</p>
			<?php }else{?>
			<p>現在ステータスは未設定です</p>
			<?php }?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_STOP", "HOTELPROVIDE_FLG_STOP", 1, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") ," 販売")?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_STOP0", "HOTELPROVIDE_FLG_STOP", 2, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_STOP") ," 売止(キャンセル再販無し)")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>リクエスト予約 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelProvide->getErrorByKey("HOTELPROVIDE_FLG_REQUEST"))?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_REQUEST", "HOTELPROVIDE_FLG_REQUEST", 1, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST") ," 設定する")?>
			<?php print $inputs->radio("HOTELPROVIDE_FLG_REQUEST0", "HOTELPROVIDE_FLG_REQUEST", 2, $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_FLG_REQUEST") ," 設定しない")?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p>提供部屋数の変更 <span class="colorRed">※</span></p>
		</td>
		<td align="left">
			<?php print create_error_msg($hotelProvide->getErrorByKey("HOTELPROVIDE_NUM"))?>
				<p>変更前 <?php print intval($nowUsed)?>席 → <?php print $inputs->text("HOTELPROVIDE_NUM", $hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPROVIDE_NUM") ,"imeDisabled circle wNum",50)?> 席</p>
			<p>※半角数字10文字以内でご入力下さい。</p>
			<p>※リクエスト予約設定時は未入力でも可。</p>
		</td>
	</tr>
</table>
<br />
<ul class="buttons">
	<li><input type="button" value="反映する" onclick="reflection()" class="circle" /></li>
</ul>
<br/><br/>


<?php

$from = cmDateDivide($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));



$to = cmDateDivide($hotelProvide->getByKey($hotelProvide->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));

for ($y=$from["y"]; $y<=$to["y"]; $y++) {
	for ($m=$from["m"]; $m<=$to["m"]; $m++) {
				if ($from["y"] == $y and $from["m"] == $m) {
					if ($from["y"] == $to["y"] and $from["m"] == $to["m"]) {
						//	最初の月でそのまま終了の場合
						$y = $newy;
						$m = $newm;
						print cmCalendarRoomNum($y, $m, $from["d"], $to["d"], $hotelProvide, "", $only,$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
					}
					else {
						print cmCalendarRoomNum($y, $m, $from["d"], "", $hotelProvide, "", $only,$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
					}
				}
				elseif ($to["y"] == $y and $to["m"] == $m) {
					print cmCalendarRoomNum($y, $m, "", $to["d"], $hotelProvide, "", $only,$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
				}
				else {
					print cmCalendarRoomNum($y, $m, "", "", $hotelProvide, "", $only,$sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
				}
					
			}
	

}
?>


<ul class="buttons">
	<li><?=$inputs->submit("","regist","保存する", "circle")?></li>
</ul>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelProvide->getKeyValue())?>
<?php print $inputs->hidden(constant("hotelRoom::keyName"), $hotelRoom->getKeyValue())?>
