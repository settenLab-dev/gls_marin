<?php if (count($dspData) > 0) {?>
	<?php foreach ($dspData as $d) {?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<tr>
	<th colspan="11" class="alignCenter"><h3><?php print $d["ROOM_NAME"]?></h3>
	<div class="alignCenter">
		<?php print $d["HOTELPLAN_NAME"]?>
	</div></th>
	</tr>
	<?php //print_r($d) ?>
	<tr>
		<th width="55" style="border-bottom: 1px solid #f0f0f0;">
		<a href="hotelProvideEditMonthly.html?id=<?php print $rid?>&key=<?php print $d["ROOM_ID"]?>&date=<?php print date("Y-m",strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE")))?>" class="popup" rel="windowCallUnload3"><?=$inputs->button("","","月間編集","circle")?></a>
		</th>
		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<th width="20" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
			$week = array("日", "月", "火", "水", "木", "金", "土");
			$time = strtotime($date);
			$w = date("w", $time);
			?>
			<p><?php print date("m/d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE")))) ?></p>
			<p>(<?php print $week[$w]?>)</p>
		</th>
		<?php }?>
	</tr>
	<tr>
		<td class="bgLightGrey alignCenter" style="border-bottom: 1px solid #f0f0f0; ">提供室数</td>
		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<td class="alignCenter" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
			$rnum = 0;
			if ($roomUsed[$d["ROOM_ID"]][$date]["stop"] == 2) {
				$rnum = "止";
			}
			elseif ($roomUsed[$d["ROOM_ID"]][$date]["request"] == 1) {
				$rnum = "間";
			}
			else {
				$rnum = intval($roomUsed[$d["ROOM_ID"]][$date]["num"]);
			}
			$rid = intval($roomUsed[$d["ROOM_ID"]][$date]["id"]);
// 			echo $d["ROOM_ID"];
			?>
			<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
			<a href="hotelProvideEdit.html?id=<?php print $rid?>&key=<?php print $d["ROOM_ID"]?>&date=<?php print $date?>" class="popup" rel="windowCallUnload"><?php print $rnum?></a>
			<?php }else{?>
				<?php print $rnum?>
			<?php }?>
		</td>
		<?php }?>
	</tr>
	<tr>
		<td class="bgLightGrey alignCenter" style="border-bottom: 1px solid #f0f0f0; ">予約数</td>
		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<td class="alignCenter" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
			$numYoyaku = 0;
// 			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
// 			$rnum = 0;
// 			$rnum = intval($roomUsed[$d["ROOM_ID"]][$date]);
			?>
			<?php print intval($usedata[$d["ROOM_ID"]][$date]);?>
		</td>
		<?php }?>
	</tr>
	<tr>
		<td class="bgLightGrey alignCenter" style="border-bottom: 1px solid #f0f0f0; ">残室数</td>
		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<td class="alignCenter" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
			$numOver = intval($roomUsed[$d["ROOM_ID"]][$date]["num"]) - $numYoyaku;
			/*
			//	該当の曜日の基本部屋数
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
			$time = strtotime($date);
			$w = date("w", $time);
			$roomnum = $d["ROOM_NUM".($w+1)] - intval($roomUsed[$d["ROOM_ID"]][$date]);
			?>
			<?php print $roomnum?>
			*/?>
			<?php print $numOver-intval($roomUsed[$d["ROOM_ID"]][$date]["booked_num"]);//intval($usedata[$d["ROOM_ID"]][$date])?>
		</td>
		<?php }?>
	</tr>
	<?php
	/*
	//	プラン情報
	if (count($d["plan"]) > 0) {
	?>
		<?php foreach ($d["plan"] as $pl) {?>
	<tr>
		<td rowspan="2" class="bgIvory alignCenter" style="border-right: 1px solid #dcdcdc;">
			<?php print $pl["HOTELPLAN_NAME"]?>
		</td>
		<td width="55" class="bgIvory alignCenter" style="border-right: 1px solid #dcdcdc; border-bottom: 1px solid #dcdcdc;">提供室数</td>

		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<td width="20" class="bgIvory alignCenter" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
			$week = array("日", "月", "火", "水", "木", "金", "土");
			?>
			<?php if ($roomUsedPlan[$d["ROOM_ID"]][$pl["HOTELPLAN_ID"]][$date]["id"] != "") {?>
				<?php if ($hotel->getByKey($hotel->getKeyValue(), "HOTEL_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
				<a href="hotelProvideEdit.html?id=<?php print $roomUsedPlan[$d["ROOM_ID"]][$pl["HOTELPLAN_ID"]][$date]["id"]?>&key=<?php print $pl["HOTELPLAN_ID"]?>&r=<?php print $d["ROOM_ID"]?>" class="popup" rel="windowCallUnload"><?php print intval($roomUsedPlan[$d["ROOM_ID"]][$pl["HOTELPLAN_ID"]][$date]["num"])?></a>
				<?php }else{?>
					<?php print intval($roomUsedPlan[$d["ROOM_ID"]][$pl["HOTELPLAN_ID"]][$date]["num"])?>
				<?php }?>
			<?php }else{?>
				×
			<?php }?>
		</td>
		<?php }?>

	</tr>
	<tr>
		<td width="55" class="bgIvory alignCenter" style="border-right: 1px solid #dcdcdc; border-bottom: 1px solid #dcdcdc;">予約室数</td>

		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<td width="20" class="bgIvory alignCenter" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"))));
			?>
		</td>
		<?php }?>

	</tr>
		<?php }?>
	<?php
	}
	*/
	?>

</table>
	<?php }?>
<?php }?>

