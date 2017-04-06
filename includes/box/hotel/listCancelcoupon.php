<?php if ($couponBooking->getCount() > 0) {?>
<?php $k = 0;$can_cancel = 0;//print_r($couponBooking->getCollection());exit;?>

<!--<h3>
<?
if($title == ""){
	if($ad["COUPONBOOK_STATUS"] == 2){
		$title = "この予約はキャンセル済みです。";
	}
	else if ($ad["COUPONBOOK_STATUS"] == 3) {
		$title = "この予約はノーショーです。";
	}
	else if ($ad["COUPONBOOK_STATUS"] == 4) {
		$title = "この予約は宿泊済みです。";
	}
	else if ($ad["COUPONBOOK_STATUS"] == 6) {
		$title = "この予約は受入れ不可です。";
	}
	else {
		$title = "以下より予約をキャンセルします。";
	}
}

?></h3>-->

<table cellspacing="0" cellpadding="5" class="tblInput cancel" id="sortList" width="100%">

			</table>
			<br />
			<table cellspacing="0" cellpadding="5" class="inner" width="100%">
				<tr><p>※予約をキャンセルする場合は、必ずキャンセルする部屋の「キャンセル」チェックボックスにチェックを入れ「キャンセル確認」ボタンを押してください。<br/>
							※プラン・日程・泊数・人数を変更する場合は予約を取り直してください。</p>
					<td align="center" class="bt-td">
						<? 
						if($can_cancel){
							print $inputs->submit("","cancelconfirm","キャンセル確認", "circle");
						}
						?>
					</td>
				</tr>
			</table>
			</form>
			<br/><br/>
			
			<?php if ($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_STATUS") == 5 || $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") != "") {
			?>			
			リクエスト回答
			<table cellspacing="0" cellpadding="5" class="tblInput " id="sortList" width="100%">
			<tr>
			<th width="160" valign="top">
				<p>予約リクエスト回答</p>
			</th>
			<td align="left">
				<?php 
				if($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") == 1){
					print "予約可能";
				}
				else if($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") == 2){
					print "受入れ不可";
				}
				else{
					print "回答待ち";
				}
				//print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",1,$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") ,"予約可能") ?>
				&nbsp; <?php 
				//print $inputs->radio("BOOKING_REQUEST","BOOKING_REQUEST",2,$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST") ,"受入れ不可") ?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>ホテルからのリクエスト回答</p>
			</th>
			<td align="left">
				<?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_REQUEST_ANSWER") ?>
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
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_ID")?>　　　[申込時間：<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_DATE_START")?>]</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>ホテル名</p>
			</th>
			<td align="left">
				<p><?php
				$couponTarget = new coupon($dbMaster);
				$couponTarget->select($couponBooking->getByKey($couponBooking->getKeyValue(), "COMPANY_ID"));
				$coupon_name = $couponTarget->getByKey($couponTarget->getKeyValue(), "HOTEL_NAME");
				$coupon_tel = $couponTarget->getByKey($couponTarget->getKeyValue(), "HOTEL_TEL");
				?>
				<a href="<?=URL_PUBLIC?>search-detail.html?undecide_sch=1&hid=<?=$couponBooking->getByKey($couponBooking->getKeyValue(), "COMPANY_ID")?>"><?=$coupon_name?></a>(TEL：<?=$coupon_tel?>)</p>
			</td>
			</tr>
			<!--<tr>
			<th width="160" valign="top">
				<p>予約時間</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_DATE_START")?></p>
			</td>
			</tr>-->
			<tr>
			<th width="160" valign="top">
				<p>チェックイン日・時間</p>
			</th>
			<td align="left">
			<?php $tmp = $couponBookingcont->getCollection();$tmp1=array_slice($tmp, 1);?>
				<p><?=$ad['BOOKINGCONT_DATE']?>　<?=$tmp1[0]["BOOKINGCONT_DATE"]." ".$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_CHECKIN")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>泊数</p>
			</th>
			<td align="left">
				<p><?php 
				print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NUM_NIGHT");
//				if($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NUM_NIGHT") > 1){
//					print $inputs->text("BOOKING_NUM_NIGHT", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NUM_NIGHT") ,"imeActive circle",20);
//				}else{ print 1;}?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>部屋数</p>
			</th>
			<td align="left">
				<p><?php 
				print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NUM_ROOM");
//				if($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NUM_ROOM") > 1){
//					print $inputs->text("BOOKING_NUM_ROOM", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NUM_ROOM") ,"imeActive circle",20);
//				}else{ print 1;}?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>プラン名</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "HOTELPLAN_NAME")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>部屋タイプ</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "ROOM_NAME")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>合計料金</p>
			</th>
			<td align="left">
				<p><?php print number_format($couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_MONEY"))?> 円</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>施設からの質問への回答</p>
			</th>
			<td align="left">
				<p><?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_ANSWER")?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>お客さまからのメッセージ</p>
			</th>
			<td align="left">
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_DEMAND")?></p>
			</td>
			</tr>	
			<tr>
			<th width="160" valign="top">
				<p>予約変更の締切</p>
			</th>
			<td align="left">
				<p><?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "HOTELPLAN_ACC_DAY")?>日前 <?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "HOTELPLAN_ACC_HOUR")?>時まで</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>キャンセルの締切</p>
			</th>
			<td align="left">
				<p><?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "HOTELPLAN_CAN_DAY")?>日前 <?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "HOTELPLAN_CAN_HOUR")?>時まで</p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>宿泊者名</p>
			</th>
			<td align="left">
				<?php 
				//print $inputs->text("BOOKING_NAME1", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NAME1") ,"imeDisabled circle wNum",20)
				print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NAME1") ?>	<?php 
				//print $inputs->text("BOOKING_NAME2", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NAME2") ,"imeDisabled circle wNum",20)
				print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_NAME2")?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>住所</p>
			</th>
			<td align="left">
				沖縄県 <?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_CITY")." ".$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_BUILD").$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_ADDRESS");
				//print $inputs->text("BOOKING_CITY", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_CITY") ," circle wNum",30)?> <?php 
				//print $inputs->text("BOOKING_BUILD", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_BUILD") ,"imeActive circle wNum",30)?> <?php 
				//print $inputs->text("BOOKING_ADDRESS", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_ADDRESS") ,"imeActive circle wNum",30)?>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>生年月日</p>
			</th>
			<td align="left">
			<?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "MEMBER_BIRTH_YEAR")."年".$couponBooking->getByKey($couponBooking->getKeyValue(), "MEMBER_BIRTH_MONTH")."月".$couponBooking->getByKey($couponBooking->getKeyValue(), "MEMBER_BIRTH_DAY") ."日";?>
			<!--<? print $inputs->hidden("MEMBER_ID",$couponBooking->getByKey($couponBooking->getKeyValue(), "MEMBER_ID"))?>
				<p><?php print $inputs->text("MEMBER_BIRTH_YEAR", $couponBooking->getByKey($couponBooking->getKeyValue(), "MEMBER_BIRTH_YEAR") ,"imeActive circle wNum",20)?>年 <?php print $inputs->text("MEMBER_BIRTH_MONTH", $couponBooking->getByKey($couponBooking->getKeyValue(), "MEMBER_BIRTH_MONTH"),"imeActive circle wNum",20)?>月 <?php print $inputs->text("MEMBER_BIRTH_DAY", $couponBooking->getByKey($couponBooking->getKeyValue(), "MEMBER_BIRTH_DAY") ,"imeActive circle wNum",20)?>日--></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>電話番号</p>
			</th>
			<td align="left">
				<p><?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_TEL");
				//print $inputs->text("BOOKING_TEL", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_TEL") ,"imeActive circle",20)?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>メールアドレス</p>
			</th>
			<td align="left">
				<p><?php print $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_MAILADDRESS");
				//print $inputs->text("BOOKING_MAILADDRESS", $couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_MAILADDRESS") ,"imeActive circle",20)?></p>
			</td>
			</tr>
			<tr>
			<th width="160" valign="top">
				<p>プラン内容</p>
			</th>
			<td align="left"><?php
				$couponPlan = new couponPlan($dbMaster);
				$couponPlan->select($couponBooking->getByKey($couponBooking->getKeyValue(), "HOTELPLAN_ID"));
				$coupon_feature = $couponPlan->getByKey($couponPlan->getKeyValue(), "HOTELPLAN_FEATURE");
				?>
				<p><?=$coupon_feature?></p>
				<p><?=$couponBooking->getByKey($couponBooking->getKeyValue(), "BOOKING_HOTELPLAN_CONTENTS")?></p>
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