
<?php if (count($dspData) > 0) {?>
<?php foreach ($dspData as $d) {?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
	<tr>
	<th colspan="11" class="alignCenter"><h3><?php print $d["HOTELPAY_NAME"]?></h3></th>
	</tr>
	<?php //print_r($d) ?>
	<tr>
		<th width="55" style="border-bottom: 1px solid #f0f0f0;">
		<a href="shopProvideEditMonthly.html?id=<?php print $rid?>&key=<?php print $d["ROOM_ID"]?>&date=<?php print date("Y-m",strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))?>" class="popup" rel="windowCallUnload3"><?=$inputs->button("","","月間編集","circle")?></a>
		</th>
		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<th width="20" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE"))));
			$week = array("日", "月", "火", "水", "木", "金", "土");
			$time = strtotime($date);
			$w = date("w", $time);
			?>
			<p><?php print date("m/d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))) ?></p>
			<p>(<?php print $week[$w]?>)</p>
		</th>
		<?php }?>
	</tr>
	<tr>
		<td class="bgLightGrey alignCenter" style="border-bottom: 1px solid #f0f0f0; ">料金帯</td>
		<?php for ($i=0; $i<=$collection->getByKey($collection->getKeyValue(), "search_term"); $i++) {?>
		<td class="alignCenter" style="border-right: 1px solid #dcdcdc;">
			<?php
			$date = date("Y-m-d",strtotime($i." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE"))));
			$rnum = 0;
			if ($roomUsed[$d["ROOM_ID"]][$date]["stop"] == 2) {
				$rnum = "止";
			}
			elseif ($roomUsed[$d["ROOM_ID"]][$date]["request"] == 1) {
				$rnum = "問";
			}
			else {
				$rnum = intval($roomUsed[$d["ROOM_ID"]][$date]["num"]);
			}
			$rid = intval($roomUsed[$d["ROOM_ID"]][$date]["id"]);
// 			echo $d["ROOM_ID"];
			?>

			<a href="shopProvideEdit.html?id=<?php print $rid?>&key=<?php print $d["ROOM_ID"]?>&date=<?php print $date?>" class="popup" rel="windowCallUnload"><?php print $rnum?></a>

		</td>
		<?php }?>
	</tr>

</table>
	<?php }?>
<?php }?>

