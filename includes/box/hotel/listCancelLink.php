<?php $k = 0;$can_cancel = 0;?>
<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
				<thead>
					<tr>
						<th width="50" rowspan="2"><p>宿泊日</p></th>
						<th width="50" rowspan="2"><p>部屋目</p></th>
						<th rowspan="2"><p>大人</p></th>
						<th colspan="2"><p>小学生</p></th>
						<th colspan="4"><p>幼児</p></th>
						<!--<th rowspan="2"><p>料金合計</p></th>-->
					</tr>
					<tr>
						<th><p>低学年</p></th>
						<th><p>高学年</p></th>
						<th><p>食・布)</p></th>
						<th><p>食のみ</p></th>
						<th><p>布のみ</p></th>
						<th><p>なし</p></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($hotelBookingcont->getCount() > 0) {?>
						<?php foreach ($hotelBookingcont->getCollection() as $ad) {?>
						<?php
					//	print_r($ad);
						$rclass = '';
						if ($ad["BOOKINGCONT_STATUS"] == 2) {
							//	キャンセル済み
							$rclass = 'class="bgLightGrey"';
						}
						?>
					<tr>
					<?php  
						$k++;
						$num = ceil(($k/$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM")))-1;
						$ad["BOOKINGCONT_DATE"] = $num>0?date("Y-m-d",strtotime("+$num day",strtotime($ad["BOOKINGCONT_DATE"]))):$ad["BOOKINGCONT_DATE"];
						?>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_DATE"]?></td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_ROOM"]?></td>
						<td <?=$rclass?>>男:<?=$ad["BOOKINGCONT_NUM1"]?> 女:<?=$ad["BOOKINGCONT_NUM2"]?><br /><?=number_format($ad["BOOKINGCONT_MONEY1"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM3"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY2"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM4"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY3"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM5"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY4"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM6"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY5"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM7"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY6"])?>円</td>
						<td <?=$rclass?>><?=$ad["BOOKINGCONT_NUM8"]?>人<br /><?=number_format($ad["BOOKINGCONT_MONEY7"])?>円</td>
						<!--<td <?=$rclass?>><?=number_format($ad["BOOKINGCONT_MONEY"])?></td>-->
					</tr>
						<?php }?>
					<?php }else {?>
					<?php }?>
				</tbody>
			</table>
			<br />
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr><p>※予約をキャンセルする場合は、必ずキャンセルする部屋の「キャンセル」チェックボックスにチェックを入れ「キャンセル確認」ボタンを押してください。<br/>
							※プラン・日程・泊数・人数を変更する場合は予約を取り直してください。</p>
					<td align="center">
						<?=$inputs->submit("","cancelconfirm","キャンセル確認", "circle")?>
					</td>
				</tr>
			</table>
			<br/>
			<?php if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_STATUS") == 5 || $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") != "") {
			?>			
			リクエスト回答
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<tr>
			<th width="160" valign="top">
				<p>予約リクエスト回答</p>
			</th>
			<td align="left">
				<?php 
				if($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") == 1){
					print "予約可能";
				}
				else if($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") == 2){
					print "受入れ不可";
				}
				else{
					print "回答待ち";
				}
				//print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",1,$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") ,"予約可能") ?>
				&nbsp; <?php 
				//print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",2,$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST") ,"受入れ不可") ?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>ホテルからのリクエスト回答</p>
			</th>
			<td align="left">
				<?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER") ?>
			</td>
			</tr>
			</table>
			<?php }?>
			<br/>
			<div><a href="javascript:history.go(-1);">予約情報一覧に戻る</a></div><br/>
			
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post"  enctype="multipart/form-data">
			<table cellspacing="0" cellpadding="5" class="tblInput edit" id="sortList" width="100%">
			<tr>
			<th width="160" valign="top">
				<p>予約番号</p>
			</th>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ID")?>　　　[申込時間：<?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DATE_START")?>]</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>ホテル名</p>
			</th>
			<td align="left">
				<p><?php
				$hotelTarget = new hotel($dbMaster);
				$hotelTarget->select($hotelBooking->getByKey($hotelBooking->getKeyValue(), "COMPANY_ID"));
				$hotel_name = $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_NAME");
				$hotel_tel = $hotelTarget->getByKey($hotelTarget->getKeyValue(), "HOTEL_TEL");
				?>
				<a href="<?=URL_PUBLIC?>search-detail.html?undecide_sch=1&hid=<?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "COMPANY_ID")?>"><?=$hotel_name?></a>(TEL：<?=$hotel_tel?>)</p>
			</td>
			</tr>
			<!--<tr>
			<th width="160" valign="top">
				<p>予約時間</p>
			</th>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DATE_START")?></p>
			</td>
			</tr>-->
			<tr>
			<th width="160" valign="top">
				<p>チェックイン日・時間</p>
			</th>
			<td align="left">
			<?php $tmp = $hotelBookingcont->getCollection();$tmp1=array_slice($tmp, 1);?>
				<p><?=$ad['BOOKINGCONT_DATE']?>　<?=$tmp1[0]["BOOKINGCONT_DATE"]." ".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CHECKIN")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>泊数</p>
			</th>
			<td align="left">
				<p><?php 
				print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_NIGHT");
//				if($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_NIGHT") > 1){
//					print $inputs->text("BOOKING_NUM_NIGHT", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_NIGHT") ,"imeActive circle",20);
//				}else{ print 1;}?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>部屋数</p>
			</th>
			<td align="left">
				<p><?php 
				print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM");
//				if($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM") > 1){
//					print $inputs->text("BOOKING_NUM_ROOM", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NUM_ROOM") ,"imeActive circle",20);
//				}else{ print 1;}?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>プラン名</p>
			</th>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "TL_PLAN_NAME")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>部屋タイプ</p>
			</th>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "TL_ROOM_NAME")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>合計料金</p>
			</th>
			<td align="left">
				<p><?php print number_format($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_MONEY"))?> 円</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>施設からの質問への回答</p>
			</th>
			<td align="left">
				<p><?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ANSWER")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>お客さまからのメッセージ</p>
			</th>
			<td align="left">
				<p><?=$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_DEMAND")?></p>
			</td>
			</tr>	
			<tr>
			<th width="160" valign="top">
				<p>予約変更の締切</p>
			</th>
			<td align="left">
				<p><?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ACC_DAY")?>日前 <?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_ACC_HOUR")?>時まで</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>キャンセルの締切</p>
			</th>
			<td align="left">
				<p><?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CAN_DAY")?>日前 <?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CAN_HOUR")?>時まで</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>宿泊者名</p>
			</th>
			<td align="left">
				<?php 
				//print $inputs->text("BOOKING_NAME1", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NAME1") ,"imeDisabled circle wNum",20)
				print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NAME1") ?>	<?php 
				//print $inputs->text("BOOKING_NAME2", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NAME2") ,"imeDisabled circle wNum",20)
				print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_NAME2")?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>住所</p>
			</th>
			<td align="left">
				沖縄県 <?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CITY")." ".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_BUILD").$hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ADDRESS");
				//print $inputs->text("BOOKING_CITY", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_CITY") ," circle wNum",30)?> <?php 
				//print $inputs->text("BOOKING_BUILD", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_BUILD") ,"imeActive circle wNum",30)?> <?php 
				//print $inputs->text("BOOKING_ADDRESS", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_ADDRESS") ,"imeActive circle wNum",30)?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>生年月日</p>
			</th>
			<td align="left">
			<?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_YEAR")."年".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_MONTH")."月".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_DAY") ."日";?>
			<!--<? print $inputs->hidden("MEMBER_ID",$hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_ID"))?>
				<p><?php print $inputs->text("MEMBER_BIRTH_YEAR", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_YEAR") ,"imeActive circle wNum",20)?>年 <?php print $inputs->text("MEMBER_BIRTH_MONTH", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_MONTH"),"imeActive circle wNum",20)?>月 <?php print $inputs->text("MEMBER_BIRTH_DAY", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "MEMBER_BIRTH_DAY") ,"imeActive circle wNum",20)?>日--></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>電話番号</p>
			</th>
			<td align="left">
				<p><?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_TEL");
				//print $inputs->text("BOOKING_TEL", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_TEL") ,"imeActive circle",20)?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>メールアドレス</p>
			</th>
			<td align="left">
				<p><?php print $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_MAILADDRESS");
				//print $inputs->text("BOOKING_MAILADDRESS", $hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_MAILADDRESS") ,"imeActive circle",20)?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>プラン内容</p>
			</th>
			<td align="left"><?php
				$hotel_feature = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "TL_PLAN_CONTENTS");
				?>
				<p><?php print  nl2br($hotel_feature); ?></p>
				<p><?php print  nl2br($hotelBooking->getByKey($hotelBooking->getKeyValue(), "BOOKING_HOTELPLAN_CONTENTS"));?></p>
			</td>
			</tr>
			</table>
			<br/>
			<!--<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr>
					<td align="center" class="bt-td">
						<?=$inputs->submit("","bookingConfirm","予約変更する", "circle")?>
					</td>
				</tr>
			</table> -->
			</form>
			<br/>
			<div><a href="javascript:history.go(-1);">予約情報一覧に戻る</a></div>