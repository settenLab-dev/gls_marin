<?php
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponBookingcont.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mMail.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/couponsite.php');

///////////////////////
//	fax
//require_once(PATH_SLAKER_COMMON.'includes/class/sendfax.php');
///////////////////////

class couponBooking extends collection {
	const tableName = "COUPONBOOKING";
	const keyName = "COUPONBOOK_ID";
	const tableKeyName = "COUPONBOOK_ID";
	const mailBooking = 37;

	const mailBooking2client = 38;

	private $bookingId;

	public function couponBooking($db) {
		parent::collection($db);
	}
	
	public function selectCompanyPayId($id){
		$sql  = "select  ";
		$sql .= parent::decryptionList(COUPON_MAIL)." ";
		$sql .= "from COUPONSITE ";
	
		$where = "";
	
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".company::keyName, "=", $id)." ";
		}
	
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
	
		$result = $this->db->execute($sql);

		if (mysql_affected_rows() > 0) {
			//	count set
			while ($row = mysql_fetch_assoc($result)) {
				//if($row['BOOKSET_BOOKING_MAILADDRESS2'] != ""){
				//	return $row['BOOKSET_BOOKING_MAILADDRESS'].",".$row['BOOKSET_BOOKING_MAILADDRESS2'];
				///}
				///else {
					return $row['COUPON_MAIL'];
				//	print $row['COUPON_MAIL'];
				//}
			}
		}
	}
/*	
	public function selectCompanyFaxId($id){
		$sql  = "select ";
		$sql .= parent::decryptionList(COMPANY_FAX)." ";
		$sql .= "from ".company::tableName." ";
	
		$where = "";
	
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".company::keyName, "=", $id)." ";
		}
	
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
	
		$result = $this->db->execute($sql);
	
		if (mysql_affected_rows() > 0) {
			//	count set
	
			while ($row = mysql_fetch_assoc($result)) {
				return $row['COMPANY_FAX'];
			}
		}
	}
*/
	public function selectBookingDateId($id){
		$sql  = "select ";
		$sql .= " MAIL_DATE ";
		$sql .= "from ".couponBooking::tableName." ";
	
		$where = "";
	
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponBooking::keyName, "=", $id)." ";
		}
	
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
	
		$result = $this->db->execute($sql);
	
		if (mysql_affected_rows() > 0) {
			//	count set
	
			while ($row = mysql_fetch_assoc($result)) {
				return $row['MAIL_DATE'];
			}
		}
	}
/*
	public function selectHotelPayId($id){
		$sql  = "select ";
		$sql .= "HOTELPAY_ID ";
		$sql .= "from ".couponBooking::tableName." ";
		
		$where = "";
		
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponBooking::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		parent::setCollection($sql, hotelPay::keyName);
	}
*/

	
	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "COUPONBOOK_ID, cob.COMPANY_ID, cob.COUPONPLAN_ID, cob.COUPONSHOP_ID, COUPONBOOK_NUM, MEMBER_ID, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("COUPONBOOK_NAME".$i."").", ";
			$sql .= parent::decryptionList("COUPONBOOK_KANA".$i."").", ";
		}
		$sql .= parent::decryptionList("COUPONSHOP_NAME, COUPONPLAN_NAME, COUPON_ID_NUM, COUPON_KEY_CODE").", ";
//		$sql .= parent::decryptionList("cos.COUPONSHOP_NAME, cop.COUPONPLAN_NAME, cob.COUPON_ID_NUM").", ";
		$sql .= " COUPONPLAN_USE_FROM, COUPONPLAN_USE_TO, COUPONBOOK_PRICE, COUPONBOOK_PRICE_ALL, COUPONBOOK_STATUS, COUPONUSE_FLG, COUPONBOOK_DATE ";

		$sql .= "from ".couponBooking::tableName." cob ";
		$sql .= "left join COUPONSITE co on cob.COMPANY_ID = co.COMPANY_ID ";
		$sql .= "left join COUPONPLAN cop on cob.COUPONPLAN_ID = cop.COUPONPLAN_ID ";
		$sql .= "left join COUPONSHOP cos on cob.COUPONSHOP_ID = cos.COUPONSHOP_ID ";
//		$sql .= "left join BOOKING hb on cob.COUPON_ID_NUM = hb.COUPON_ID_NUM and cob.COMPANY_ID = hb.COMPANY_ID ";


		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COUPONBOOK_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponBooking::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COUPONBOOK_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("cob.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("cob.COUPONPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_ID", "=", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("cob.COUPONSHOP_ID", "=", $collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"))." ";
		}
/*
		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("BOOKING_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "BOOKING_DATE"), true)." ";
			$where .= "and ".parent::expsData("BOOKING_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "BOOKING_DATE")))), true)." ";
		}
*/
		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COUPONBOOK_ID desc  ";
//		print_r($collection);
  		//echo $sql;

		parent::setCollection($sql, couponBooking::keyName);
	}

	public function selectBookedNum($collection) {
		$sql  = "select ";
		$sql .= "count(*) as num from ".couponBooking::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPONPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "MAIL_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MAIL_DATE", "=", $collection->getByKey($collection->getKeyValue(), "MAIL_DATE"), true)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			while($row = mysql_fetch_array($result)) {
				$bookedNum = $row["num"];
			}
		}

//		print_r($bookedNum);
//		exit;
		return $bookedNum;

	}

	
/*
	public function selectListAdminProvide($collection) {

		$sql  = "select ";
		$sql .= "BOOKINGCONT_DATE, BOOKING_NUM_ROOM, b.ROOM_ID, BOOKINGCONT_ID, BOOKING_LINK, BOOKING_BOOKING_CODE ";
		$sql .= "from BOOKINGCONT bc ";
		$sql .= "inner join BOOKING b on bc.BOOKING_ID = b.BOOKING_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("b.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("BOOKINGCONT_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"), true)." ";
			$where .= "and ".parent::expsData("BOOKINGCONT_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE")))), true)." ";
		}


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

// 		$sql .= "group by hb.ROOM_ID ";
		$sql .= "order by BOOKING_DATE  ";

		parent::setCollection($sql, "BOOKINGCONT_ID");
	}
*/


	public function select($id="", $hotelPlanId="", $payId="", $roomId="", $comapnyId="" ) {
		$sql  = "select ";
		$sql .= "BOOKING_ID, hb.COMPANY_ID, hb.HOTELPLAN_ID, HOTELPAY_ID, hb.ROOM_ID, BOOKING_DATE, BOOKING_DATE_CANCEL_END, BOOKING_NUM_ROOM, MEMBER_ID, BOOKING_NUM_NIGHT, ";
		$sql .= parent::decryptionList("BOOKING_CHECKIN, BOOKING_DATE_CANCEL_END_TIME").", ";
		$sql .= "BOOKING_LINK,BOOKING_BOOKING_CODE, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("BOOKING_NAME".$i."").", ";
			$sql .= parent::decryptionList("BOOKING_KANA".$i."").", ";
		}
		$sql .= parent::decryptionList("BOOKING_ZIP").", ";
		$sql .= "BOOKING_PREF_ID, ";
		$sql .= parent::decryptionList("BOOKING_CITY, BOOKING_ADDRESS, BOOKING_BUILD, BOOKING_TEL").", ";
		$sql .= "BOOKING_AGE, ";
		$sql .= parent::decryptionList("BOOKING_MAILADDRESS, BOOKING_ANSWER, BOOKING_DEMAND").", ";
		$sql .= "BOOKING_STATUS, BOOKING_SERVICE, BOOKING_MONEY, BOOKING_HOW, BOOKING_POINT_USE, BOOKING_MONRY_CANCEL, ";
		$sql .= parent::decryptionList("BOOKING_MEMO").", ";
		$sql .= "BOOKING_DATE_START, BOOKING_DATE_BOOK, BOOKING_DATE_CANCEL, BOOKING_DATE_DELETE  ";
		$sql .= "from ".couponBooking::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponBooking::keyName, "=", $id)." ";
		}

		if ($hotelPlanId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_ID", "=", $hotelPlanId)." ";
		}

		if ($comapnyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $comapnyId)." ";
		}

		if ($payId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPAY_ID", "=", $payId)." ";
		}

		if ($roomId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ROOM_ID", "=", $roomId)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by BOOKING_DATE  ";

		parent::setCollection($sql, couponBooking::keyName);
	}

	public function selectCancelRoom($id,$companId){
		$sql = "select ";
		$sql.= "count(*) canceled from ".couponBookingcont::tableName;
		$sql.= " where BOOKING_ID=$id and COMPANY_ID=$companId";
		$sql.= " and BOOKINGCONT_STATUS = 1";
		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			//	count set
			while ($row = mysql_fetch_assoc($result)) {
				return $row['canceled'];
			}
		}
	
	}
	
	public function selectCancelmoneyRoom($id,$companId){
		$sql = "select ";
		$sql.= " BOOKINGCONT_MONEY   from ".couponBookingcont::tableName;
		$sql.= " where BOOKING_ID=$id and COMPANY_ID=$companId";
		$sql.= " and BOOKINGCONT_STATUS = 1";
		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			//	count set
			while ($row = mysql_fetch_assoc($result)) {
				$money+=$row['BOOKINGCONT_MONEY'];
			}
		}
		return $money;
	}
	
	public function selectCancelData($id="", $hotelPlanId="", $roomId="", $comapnyId="", $memberId="") {
		$sql  = "select ";
		$sql .= parent::decryptionList("COUPONPLAN_NAME, COUPONSHOP_NAME, COUPONSHOP_TEL, COUPONSHOP_ADDRESS, COUPONSHOP_ACCESS, COUPONSHOP_HOLYDAY, COUPONSHOP_OPEN, COUPONPLAN_CATCH").", ";
		$sql .= "COUPONBOOK_ID, COUPONBOOK_STATUS, COUPONBOOK_PRICE, COUPONBOOK_PRICE_ALL, COUPONBOOK_NUM, COUPONBOOKPLAN_USE_FROM, COUPONBOOKPLAN_USE_TO, COUPONPLAN_USE_FROM, COUPONPLAN_USE_TO, COUPONPLAN_HOTELPLAN_ID, ";
		$sql .= parent::decryptionList("COUPONPLAN_DETAIL, COUPONPLAN_USE, COUPONPLAN_RESERVE, COUPONPLAN_USE_MEMO, COUPON_ID_NUM, COUPON_KEY_CODE, COUPONPLAN_PIC, COUPONBOOK_NAME1, COUPONBOOK_NAME2, COUPONBOOK_KANA1, COUPONBOOK_KANA2").", ";
		$sql .= parent::decryptionList("MAIL_ADDRESS, MEMBER_CITY, MEMBER_ADDRESS, MEMBER_BUILD, MEMBER_TEL1, MEMBER_TEL2, MEMBER_BIRTH_YEAR, MEMBER_BIRTH_MONTH, MEMBER_BIRTH_DAY").", ";
		$sql .= "COUPONBOOK_DATE  ";
		$sql .= "from ".couponBooking::tableName." cob ";
		$sql .= "left join COUPONPLAN cop on cob.COUPONPLAN_ID = cop.COUPONPLAN_ID ";
		$sql .= "left join COUPONSHOP cos on cob.COUPONSHOP_ID = cos.COUPONSHOP_ID ";
		$sql .= "left join MEMBER mem on mem.MEMBER_ID = cob.MEMBER_ID ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponBooking::keyName, "=", $id)." ";
		}

		if ($hotelPlanId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPONPLAN_ID", "=", $hotelPlanId)." ";
		}

		if ($comapnyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("cob.COMPANY_ID", "=", $comapnyId)." ";
		}

		if ($memberId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("cob.MEMBER_ID", "=", $memberId)." ";
		}
/*
		if ($payId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPAY_ID", "=", $payId)." ";
		}
*/
		if ($roomId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPONSHOP_ID", "=", $roomId)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COUPONBOOK_DATE  ";
		
		parent::setCollection($sql, couponBooking::keyName);
	}


	private function setBookinId($id) {
		$this->bookingId = $id;
	}
	public function getBookingId() {
		return $this->bookingId;
	}

	public function makeRandStr($length = 3) {
		$str = array_merge(range('A', 'Z'));
		for ($i = 0; $i < $length; $i++) {
			$r_str .= $str[rand(0, count($str)-1)];
		}
		return $r_str;
	}
 

	public function updateBooking($id, $bookingCode) {
			$this->db->begin();

			$sql .= "update ".couponBooking::tableName." set ";
			$sql .= parent::expsData("BOOKING_BOOKING_CODE", "=", $bookingCode, true).", ";
			$sql .= parent::expsData("BOOKING_DATE_BOOK", "=", "now()")." ";
			$sql .= "where ";
			$sql .=  parent::expsData(couponBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}

			$bookingcont = new couponBookingcont($this->db);
			if (!$bookingcont->updateBooking($id, $bookingCode)) {
				$this->db->rollback();
				return false;
			}

			$this->db->commit();
			return true;
	}
	
	public function updateBookingStatus($id, $bookingStatus) {
			$this->db->begin();

			$sql .= "update ".couponBooking::tableName." set ";
			$sql .= parent::expsData("COUPONBOOK_STATUS", "=", $bookingStatus, true)." ";
			$sql .= "where ";
			$sql .=  parent::expsData(couponBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
/*
			$bookingcont = new couponBookingcont($this->db);
			if (!$bookingcont->updateBookingStatus($id, $bookingStatus)) {
				$this->db->rollback();
				return false;
			}
*/
			$this->db->commit();
			return true;
	}


	public function saveBooking(){
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		$sql .= "update ".couponBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_NAME1", "=", $dataList["BOOKING_NAME1"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_NAME2", "=", $dataList["BOOKING_NAME2"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_KANA1", "=", $dataList["BOOKING_KANA1"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_KANA2", "=", $dataList["BOOKING_KANA2"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_CITY", "=", $dataList["BOOKING_CITY"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_BUILD", "=", $dataList["BOOKING_BUILD"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_ADDRESS", "=", $dataList["BOOKING_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_TEL", "=", $dataList["BOOKING_TEL"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_MAILADDRESS", "=", $dataList["BOOKING_MAILADDRESS"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_NUM_NIGHT", "=", $dataList["BOOKING_NUM_NIGHT"]).", ";
		$sql .= parent::expsData("BOOKING_NUM_ROOM", "=", $dataList["BOOKING_NUM_ROOM"]).", ";
		$sql .= parent::expsData("BOOKING_MONEY", "=", $dataList["BOOKING_MONEY"]).", ";
		$sql .= parent::expsData("BOOKING_SERVICE", "=", $dataList["BOOKING_SERVICE"]).", ";
		$sql .= parent::expsData("BOOKING_ANSWER", "=", $dataList["BOOKING_ANSWER"], true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponBooking::keyName, "=", parent::getKeyValue())." ";
// 		echo $sql;exit;
		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}
		
		$this->db->commit();
		return true;
	}
	
	
		
	public function mails($mailid,$to='',$fax=true){
		$this->db->begin();
		$mMail = new mMail($this->db);
		$mMail->select($mailid);
		if ($mMail->getCount() != 1) {
			parent::setErrorFirst("予約メールの取得に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		$from = MAIL_SLAKER_NOREPLY;
		$to = $to?$to:parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS");
		
		$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
		$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

		$hotel = new hotel($this->db);
		$hotel->select(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
		
		//引数入り変え
		$subject = cmReplace($subject, "[!HOTEL_NAME!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));
		$subject = cmReplace($subject, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		
		
		
		
		$body = cmReplace($body, "[!HOTEL_TEL!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TEL"));
		$body = cmReplace($body, "[!HOTEL_ZIP!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ZIP"));
		$body = cmReplace($body, "[!HOTEL_ADDRESS!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS"));
		
		
		$body = cmReplace($body, "[!BOOKING_ID!]", parent::getByKey(parent::getKeyValue(), "BOOKING_ID"));
		$body = cmReplace($body, "[!HOTEL_NAME!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));
// 		$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
		$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));
		
		$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
		$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
		$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
		$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
// 		$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
// 		$body = cmReplace($body, "[!HOTEL_ZIP!]", parent::getByKey(parent::getKeyValue(), "hotel_zip"));
// 		$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address")); 
		$body = cmReplace($body, "[!HOTEL_CHECKIN!]", $this->selectBookingDateId(parent::getByKey(parent::getKeyValue(), "BOOKING_ID"))." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!NIGHT_NUM!]", parent::getByKey(parent::getKeyValue(), "night_number"));
		$body = cmReplace($body, "[!ROOM_TYPE!]", parent::getByKey(parent::getKeyValue(), "room_type"));
		$body = cmReplace($body, "[!ROOM_NUM!]", parent::getByKey(parent::getKeyValue(), "room_number"));
		$body = cmReplace($body, "[!PLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
		$body = cmReplace($body, "[!HOTEL_CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!HOTEL_CHECKOUT_TIME!]", parent::getByKey(parent::getKeyValue(), "check_out_time"));
		$body = cmReplace($body, "[!MEAL!]", parent::getByKey(parent::getKeyValue(), "meal"));
		$body = cmReplace($body, "[!PLAN_CONTENTS!]", parent::getByKey(parent::getKeyValue(), "plan_contents"));
		$body = cmReplace($body, "[!CANCEL!]", parent::getByKey(parent::getKeyValue(), "cancel"));
		$body = cmReplace($body, "[!PAYMENT!]", parent::getByKey(parent::getKeyValue(), "payment"));
		
//		if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
//			$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済');
//		}
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '事前支払い … 施設より別途お支払のご案内をいたします。');
		}
		
		$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "BOOKING_POINT_USE")*92/100));
		$question = "";
		if (parent::getByKey(parent::getKeyValue(), "question") != "") {
			$question  = "-----------------------------------------------------------------------\n";
			$question .= "【施設からの質問】\n";
			$question .= "-----------------------------------------------------------------------\n";
			$question .= parent::getByKey(parent::getKeyValue(), "question")."\n";
			$question .= "-----------------------------------------------------------------------\n";
			$question .= parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER")."\n";
		}
		$body = cmReplace($body, "[!QUESTION!]", $question);
		
		$demand = "";
		if (parent::getByKey(parent::getKeyValue(), "demand") == 1) {
			$demand .= "-----------------------------------------------------------------------\n";
			$demand .= "[メッセージ]\n";
			$demand = parent::getByKey(parent::getKeyValue(), "BOOKING_DEMAND")."\n";
			$demand .= "-----------------------------------------------------------------------\n";
		}
		
		$body = cmReplace($body, "[!HOTEL_URL!]", parent::getByKey(parent::getKeyValue(), "hotel_url"));
		
		$body = cmReplace($body, "[!MESSAGE!]", $demand); 
		
		//mail21
// 		$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		$body = cmReplace($body, "[!BOOKING_NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
		$body = cmReplace($body, "[!MAIL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
		$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
		$body = cmReplace($body, "[!BOOKING_NIGHT!]", parent::getByKey(parent::getKeyValue(), "night_number"));
		$body = cmReplace($body, "[!CHECKIN_DAY!]", $this->selectBookingDateId(parent::getByKey(parent::getKeyValue(), "BOOKING_ID")));
		$body = cmReplace($body, "[!CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
		$body = cmReplace($body, "[!MONEY_ALL!]", parent::getByKey(parent::getKeyValue(), "payment"));
		$body = cmReplace($body, "[!MEMBER_ID!]", parent::getByKey(parent::getKeyValue(), "MEMBER_ID"));
//		$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済');
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '事前支払い … 施設より別途お支払のご案内をいたします。');
		}
		else {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
		}
		
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==1) $body = cmReplace($body, "[!REQUEST_ANSWER!]", 'リクエストありがとうございます。ご予約を承りました。');
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==2) $body = cmReplace($body, "[!REQUEST_ANSWER!]", '申し訳ございません。ご希望のお日にちは満室です。');
		
		
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("仮登録メールの送信に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		if($fax){
				//	FAX番号確認
				$faxnumer = cmReplace($this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")), "-", "");
				// 			echo $faxnumer;exit;
				// 			$faxnumer='0989888106';
				//テストするため、コメントアウトします
				$sendfax = new sendfax($faxnumer, $body);
				if (!$sendfax->send()) {
					parent::setErrorFirst("予約FAXの送信に失敗しました。");
					parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
					$this->db->rollback();
					return false;
				}
		}
		
		return true;
	}

	public function usedmails($mailid,$to='',$fax=true){
		$this->db->begin();
		$mMail = new mMail($this->db);
		$mMail->select($mailid);
		if ($mMail->getCount() != 1) {
			parent::setErrorFirst("予約メールの取得に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		$from = MAIL_SLAKER_NOREPLY;
		$to = $to?$to:parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS");
		
		$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
		$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

		$hotel = new hotel($this->db);
		$hotel->select(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
		
		//引数入り変え
		$subject = cmReplace($subject, "[!HOTEL_NAME!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));
		$subject = cmReplace($subject, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		
		
		
		
		$body = cmReplace($body, "[!HOTEL_TEL!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TEL"));
		$body = cmReplace($body, "[!HOTEL_ZIP!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ZIP"));
		$body = cmReplace($body, "[!HOTEL_ADDRESS!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_ADDRESS"));
		
		
		$body = cmReplace($body, "[!BOOKING_ID!]", parent::getByKey(parent::getKeyValue(), "BOOKING_ID"));
		$body = cmReplace($body, "[!HOTEL_NAME!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));
// 		$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
		$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));
		
		$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
		$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
		$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
		$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
// 		$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
// 		$body = cmReplace($body, "[!HOTEL_ZIP!]", parent::getByKey(parent::getKeyValue(), "hotel_zip"));
// 		$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address")); 
		$body = cmReplace($body, "[!HOTEL_CHECKIN!]", $this->selectBookingDateId(parent::getByKey(parent::getKeyValue(), "BOOKING_ID"))." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!NIGHT_NUM!]", parent::getByKey(parent::getKeyValue(), "night_number"));
		$body = cmReplace($body, "[!ROOM_TYPE!]", parent::getByKey(parent::getKeyValue(), "room_type"));
		$body = cmReplace($body, "[!ROOM_NUM!]", parent::getByKey(parent::getKeyValue(), "room_number"));
		$body = cmReplace($body, "[!PLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
		$body = cmReplace($body, "[!HOTEL_CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!HOTEL_CHECKOUT_TIME!]", parent::getByKey(parent::getKeyValue(), "check_out_time"));
		$body = cmReplace($body, "[!MEAL!]", parent::getByKey(parent::getKeyValue(), "meal"));
		$body = cmReplace($body, "[!PLAN_CONTENTS!]", parent::getByKey(parent::getKeyValue(), "plan_contents"));
		$body = cmReplace($body, "[!CANCEL!]", parent::getByKey(parent::getKeyValue(), "cancel"));
		$body = cmReplace($body, "[!PAYMENT!]", parent::getByKey(parent::getKeyValue(), "payment"));
		
//		if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
//			$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済');
//		}
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '事前支払い … 施設より別途お支払のご案内をいたします。');
		}
		
		$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "BOOKING_POINT_USE")*92/100));
		$question = "";
		if (parent::getByKey(parent::getKeyValue(), "question") != "") {
			$question  = "-----------------------------------------------------------------------\n";
			$question .= "【施設からの質問】\n";
			$question .= "-----------------------------------------------------------------------\n";
			$question .= parent::getByKey(parent::getKeyValue(), "question")."\n";
			$question .= "-----------------------------------------------------------------------\n";
			$question .= parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER")."\n";
		}
		$body = cmReplace($body, "[!QUESTION!]", $question);
		
		$demand = "";
		if (parent::getByKey(parent::getKeyValue(), "demand") == 1) {
			$demand .= "-----------------------------------------------------------------------\n";
			$demand .= "[メッセージ]\n";
			$demand = parent::getByKey(parent::getKeyValue(), "BOOKING_DEMAND")."\n";
			$demand .= "-----------------------------------------------------------------------\n";
		}
		
		$body = cmReplace($body, "[!HOTEL_URL!]", parent::getByKey(parent::getKeyValue(), "hotel_url"));
		
		$body = cmReplace($body, "[!MESSAGE!]", $demand); 
		
		//mail21
// 		$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		$body = cmReplace($body, "[!BOOKING_NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
		$body = cmReplace($body, "[!MAIL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
		$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
		$body = cmReplace($body, "[!BOOKING_NIGHT!]", parent::getByKey(parent::getKeyValue(), "night_number"));
		$body = cmReplace($body, "[!CHECKIN_DAY!]", $this->selectBookingDateId(parent::getByKey(parent::getKeyValue(), "BOOKING_ID")));
		$body = cmReplace($body, "[!CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
		$body = cmReplace($body, "[!MONEY_ALL!]", parent::getByKey(parent::getKeyValue(), "payment"));
		$body = cmReplace($body, "[!MEMBER_ID!]", parent::getByKey(parent::getKeyValue(), "MEMBER_ID"));
//		$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済');
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '事前支払い … 施設より別途お支払のご案内をいたします。');
		}
		else {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
		}
		
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==1) $body = cmReplace($body, "[!REQUEST_ANSWER!]", 'リクエストありがとうございます。ご予約を承りました。');
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==2) $body = cmReplace($body, "[!REQUEST_ANSWER!]", '申し訳ございません。ご希望のお日にちは満室です。');
		
		
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("仮登録メールの送信に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		if($fax){
				//	FAX番号確認
				$faxnumer = cmReplace($this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")), "-", "");
				// 			echo $faxnumer;exit;
				// 			$faxnumer='0989888106';
				//テストするため、コメントアウトします
				$sendfax = new sendfax($faxnumer, $body);
				if (!$sendfax->send()) {
					parent::setErrorFirst("予約FAXの送信に失敗しました。");
					parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
					$this->db->rollback();
					return false;
				}
		}
		
		return true;
	}


	public function getPlanContentById($id){
		$couponPlan = new couponPlan($this->db);
		$couponPlan->getPlanContentById($id);
		return $couponPlan->getByKey($couponPlan->getKeyValue(), "COUPONPLAN_CONTENTS");
	}

	public function save($bookingcontArray,$is_request=false) {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		//print_r($dataList);exit;
		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
//		print_r($dataList);exit;
//			$dataList['COUPONBOOK_COUPONPLAN_CONTENTS']=$this->getPlanContentById($dataList['COUPONPLAN_ID']);
// 			echo $dataList['BOOKING_HOTELPLAN_CONTENTS'];exit;
			$sql = $this->insert($dataList);
// 			echo $sql;exit;
	//	print_r(debug_backtrace());

		}
		else {
			$sql = $this->update($dataList);
		}
 		
		//echo $sql;exit;
		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		if ($this->saveDivide($this->getKeyValue())) {
			$idData = new collection($this->db);
			$idData->lastInsert(couponBooking::tableName);
			$id = $idData->getByKey($idData->getKeyValue(), "id");
 			$bookingcontArray["COUPONBOOK_ID"] = $id;
		}

		$this->setBookinId($id);

/*
		$bookingcont = new couponBookingcont($this->db);
		if (!$bookingcont->saveAll($bookingcontArray, $id)) {
			$this->db->rollback();
			return false;
		}
*/

		//リンカーン以外(ココトモのみ）
		

			//在庫管理追加		
//			for($i=0;$i<1;$i++){
			if($dataList["COUPONBOOK_NUM"] > 0 ){
				$sql = "";
				$sql .= "update COUPONPLAN set COUPONPLAN_PROVIDE_SELL = COUPONPLAN_PROVIDE_SELL+".$dataList["COUPONBOOK_NUM"];
				$sql .= " where COUPONPLAN_ID=".$dataList["COUPONPLAN_ID"]." and COMPANY_ID = ".$dataList["COMPANY_ID"];
			//	$sql .= " and HOTELPROVIDE_DATE = '".date('Y-m-d',strtotime($dataList["BOOKING_DATE"])+$i*60*60*24)."'";
				if (!$this->saveExec($sql)) {
					$this->db->rollback();
					return false;
				}
			}
				
			
			$mMail = new mMail($this->db);
			//To user
			
			
			$mailid = !$is_request?couponBooking::mailBooking:couponBooking::mailBookingRequest;
			$mMail->select($mailid);
			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("予約メールの取得に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}

			$from = MAIL_SLAKER_NOREPLY;
			$to = parent::getByKey(parent::getKeyValue(), "MAIL_ADDRESS");

			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$subject = cmReplace($subject, "[!COUPONPLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));

			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["COUPONBOOK_ID"]);

			$body = cmReplace($body, "[!COUPON_ID_NUM!]", parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"));
			$body = cmReplace($body, "[!COUPON_KEY_CODE!]", parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE"));

			$body = cmReplace($body, "[!COMPANY_ID!]", parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$body = cmReplace($body, "[!COUPONPLAN_ID!]", parent::getByKey(parent::getKeyValue(), "COUPONPLAN_ID"));
			$body = cmReplace($body, "[!COUPONSHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "couponshop_name"));
			$body = cmReplace($body, "[!COUPONSHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "couponshop_tel"));
			$body = cmReplace($body, "[!COUPONSHOP_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "couponshop_address"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NAME1")." ".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_KANA1")." ".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "MAIL_ADDRESS"));
			$body = cmReplace($body, "[!COUPONBOOK_NUM!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NUM"));
			$body = cmReplace($body, "[!COUPONBOOK_PRICE!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_PRICE"));
			$body = cmReplace($body, "[!COUPONBOOK_PRICE_ALL!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_PRICE_ALL"));
			$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_PRICE_ALL")*0.92/100));
			$body = cmReplace($body, "[!COUPONPLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
			$body = cmReplace($body, "[!COUPONPLAN_DETAIL!]", parent::getByKey(parent::getKeyValue(), "plan_detail"));
			$body = cmReplace($body, "[!COUPONPLAN_RESERVE!]", parent::getByKey(parent::getKeyValue(), "plan_reserve"));
			$body = cmReplace($body, "[!COUPONPLAN_USE!]", parent::getByKey(parent::getKeyValue(), "plan_use"));
			$body = cmReplace($body, "[!COUPONPLAN_USE_FROMTO!]", parent::getByKey(parent::getKeyValue(), "plan_useto"));
			$body = cmReplace($body, "[!COUPONPLAN_USE_MEMO!]", parent::getByKey(parent::getKeyValue(), "plan_use_memo"));


			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("予約メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
			
			//To client
			$mailid = !$is_request?couponBooking::mailBooking2client:couponBooking::mailBookingRequest2hotel;
			$mMail->select($mailid);

			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("予約メールの取得に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
			
			$from = MAIL_SLAKER_NOREPLY;
			$to = $this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			// 		$to = 'jxxycc@qq.com';
	// 		print_r(parent::getCollection());
			//subject
			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$subject = cmReplace($subject, "[!COUPONPLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));

			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["COUPONBOOK_ID"]);

			$body = cmReplace($body, "[!COUPON_ID_NUM!]", parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"));
			$body = cmReplace($body, "[!COUPON_KEY_CODE!]", parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE"));

			$body = cmReplace($body, "[!COMPANY_ID!]", parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$body = cmReplace($body, "[!COUPONPLAN_ID!]", parent::getByKey(parent::getKeyValue(), "COUPONPLAN_ID"));
			$body = cmReplace($body, "[!COUPONSHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "couponshop_name"));
			$body = cmReplace($body, "[!COUPONSHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "couponshop_tel"));
			$body = cmReplace($body, "[!COUPONSHOP_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "couponshop_address"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NAME1")." ".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_KANA1")." ".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "MAIL_ADDRESS"));
			$body = cmReplace($body, "[!COUPONBOOK_NUM!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NUM"));
			$body = cmReplace($body, "[!COUPONBOOK_PRICE!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_PRICE"));
			$body = cmReplace($body, "[!COUPONBOOK_PRICE_ALL!]", parent::getByKey(parent::getKeyValue(), "COUPONBOOK_PRICE_ALL"));
			$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_PRICE_ALL")*0.92/100));
			$body = cmReplace($body, "[!COUPONPLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
			$body = cmReplace($body, "[!COUPONPLAN_DETAIL!]", parent::getByKey(parent::getKeyValue(), "plan_detail"));
			$body = cmReplace($body, "[!COUPONPLAN_RESERVE!]", parent::getByKey(parent::getKeyValue(), "plan_reserve"));
			$body = cmReplace($body, "[!COUPONPLAN_USE!]", parent::getByKey(parent::getKeyValue(), "plan_use"));
			$body = cmReplace($body, "[!COUPONPLAN_USE_FROMTO!]", parent::getByKey(parent::getKeyValue(), "plan_useto"));
			$body = cmReplace($body, "[!COUPONPLAN_USE_MEMO!]", parent::getByKey(parent::getKeyValue(), "plan_use_memo"));

/*
			$work1 = "";
			if (parent::getByKey(parent::getKeyValue(), "COUPONBOOK_COMPANY1") != "") {
				$work1  = "-----------------------------------------------------------------------\n";
				$work1 .= "【職務経歴１】\n";
				$work1 .= "-----------------------------------------------------------------------\n";
				$work1 .= "企業名：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_COMPANY1")."\n";
				$work1 .= "施設名：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_COMPANY_NAME1")."\n";
				$work1 .= "業種：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_COMPANY1")."\n";
				$work1 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_PERIOD11")."年"
					.parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_PERIOD12")."月～".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_PERIOD13")."年"
					.parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_PERIOD14")."月\n";
				$work1 .= "職種：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_KIND1")."\n";
				$work1 .= "役職：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_POSITION1")."\n";
				$work1 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_TYPE1")."\n";
				$work1 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_DETAIL1")."\n";
				$work1 .= "備考：".parent::getByKey(parent::getKeyValue(), "COUPONBOOK_WORK_MEMO1")."\n";
				$work1 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK1!]", $work1);
*/

	// 		echo $mailid.$from.'<BR>'.$to.'<BR>'.$subject.'<BR>'.$body;exit;		
			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("予約メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
			
/*			////////////////////////////////////////////////////////////////////////////////////////////
			//	fax
			if (parent::getByKey(parent::getKeyValue(), "COMPANY_FAX") != "" || $this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))) {
				parent::setByKey(parent::setKeyValue(), "COMPANY_FAX",$this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));
				//	FAX番号確認
				if (parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_HOW1") != 2) {
					//	FAX通知希望確認

					$faxnumer = cmReplace(parent::getByKey(parent::getKeyValue(), "COMPANY_FAX"), "-", "");
					//テストするため、コメントアウトします
					$sendfax = new sendfax($faxnumer, $body);
					if (!$sendfax->send()) {
						parent::setErrorFirst("予約FAXの送信に失敗しました。");
						parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
						$this->db->rollback();
						return false;
					}
				}
			}
*/			////////////////////////////////////////////////////////////////////////////////////////////
		//kokomoホテルのみ


		$this->db->commit();
		return $bookingcontArray["COUPONBOOK_ID"];



	}


	public function insert($dataList) {
	//	print_r($dataList);
		$sql  = "insert into ".couponBooking::tableName." (";
		$sql .= "COUPONBOOK_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "COUPONPLAN_ID, ";
		$sql .= "COUPONSHOP_ID, ";
		$sql .= "COUPON_ID_NUM, ";
		$sql .= "COUPON_KEY_CODE, ";
		$sql .= "MEMBER_ID, ";
		$sql .= "COUPONBOOK_NAME1, ";
		$sql .= "COUPONBOOK_NAME2, ";
		$sql .= "COUPONBOOK_KANA1, ";
		$sql .= "COUPONBOOK_KANA2, ";
		$sql .= "MAIL_ADDRESS, ";
		$sql .= "COUPONBOOKPLAN_USE_FROM, ";
		$sql .= "COUPONBOOKPLAN_USE_TO, ";
		$sql .= "COUPONBOOK_NUM, ";
		$sql .= "COUPONBOOK_PRICE, ";
		$sql .= "COUPONBOOK_PRICE_ALL, ";
		$sql .= "COUPONBOOK_STATUS, ";
		$sql .= "COUPONUSE_FLG, ";
		$sql .= "COUPONUSE_DATE, ";
		$sql .= "COUPONBOOK_DATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_ID"]).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_ID"]).", ";
		$sql .= parent::expsVal($dataList["COUPON_ID_NUM"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_KEY_CODE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_ID"]).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_NAME1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_NAME2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_KANA1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_KANA2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MAIL_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOKPLAN_USE_FROM"]).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOKPLAN_USE_TO"]).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_NUM"]).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_PRICE"]).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_PRICE_ALL"]).", ";
		$sql .= parent::expsVal($dataList["COUPONBOOK_STATUS"]).", ";
		$sql .= "1, ";
		$sql .= "null, ";
		$sql .= "now()) ";
	//	print_r($dataList);exit;

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".couponBooking::tableName." set ";
		$sql .= parent::expsData("COUPONPLAN_ID", "=", $dataList["COUPONPLAN_ID"]).", ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("COUPONSHOP_ID", "=", $dataList["COUPONSHOP_ID"]).", ";
		$sql .= parent::expsData("COUPON_ID_NUM", "=", $dataList["COUPON_ID_NUM"], true).", ";
		$sql .= parent::expsData("COUPON_KEY_CODE", "=", $dataList["COUPON_KEY_CODE"]).", ";
		$sql .= parent::expsData("MEMBER_ID", "=", $dataList["MEMBER_ID"]).", ";
		$sql .= parent::expsData("COUPONBOOK_NAME1", "=", $dataList["COUPONBOOK_NAME1"], true, 1).", ";
		$sql .= parent::expsData("COUPONBOOK_NAME2", "=", $dataList["COUPONBOOK_NAME2"], true, 1).", ";
		$sql .= parent::expsData("COUPONBOOK_KANA1", "=", $dataList["COUPONBOOK_KANA1"], true, 1).", ";
		$sql .= parent::expsData("COUPONBOOK_KANA2", "=", $dataList["COUPONBOOK_KANA2"], true, 1).", ";
		$sql .= parent::expsData("MAIL_ADDRESS", "=", $dataList["MAIL_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("COUPONBOOKPLAN_USE_FROM", "=", $dataList["COUPONBOOKPLAN_USE_FROM"]).", ";
		$sql .= parent::expsData("COUPONBOOKPLAN_USE_TO", "=", $dataList["COUPONBOOKPLAN_USE_TO"]).", ";
		$sql .= parent::expsData("COUPONBOOK_NUM", "=", $dataList["COUPONBOOK_NUM"]).", ";
		$sql .= parent::expsData("COUPONBOOK_PRICE", "=", $dataList["COUPONBOOK_PRICE"]).", ";
		$sql .= parent::expsData("COUPONBOOK_PRICE_ALL", "=", $dataList["COUPONBOOK_PRICE_ALL"]).", ";
		$sql .= parent::expsData("COUPONBOOK_STATUS", "=", $dataList["COUPONBOOK_STATUS"]).", ";
		$sql .= parent::expsData("COUPONUSE_FLG", "=", $dataList["COUPONUSE_FLG"]).", ";
		$sql .= parent::expsData("COUPONBOOK_DATE", "=", $dataList["COUPONBOOK_DATE"]).", ";
		$sql .= parent::expsData("COUPONUSE_DATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponBooking::keyName, "=", $this->getKeyValue())." ";

		return $sql;
	}

	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".couponBooking::tableName." set ";
// 		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(couponBooking::keyName, "=", parent::getKeyValue())." ";

// 		if (!parent::saveExec($sql)) {
// 			$this->db->rollback();
// 			return false;
// 		}

// 		$this->db->commit();
// 		return true;

	}

	public function statusBookingUsed() {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		//print_r($dataList);exit; 
		
		$sql .= "update ".couponBooking::tableName." set ";
		$sql .= parent::expsData("COUPONBOOK_STATUS", "=", 2).", ";
		$sql .= parent::expsData("COUPONUSE_DATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponBooking::keyName, "=", parent::getKeyValue())." ";
//print $sql;
		if (!parent::saveExec($sql)) {
			return false;
		}

		$this->db->commit();
		return true;


/* ステータス変更した時点でご利用ありがとうございましたメールが送信されるようにする */
		
	}


	public  function selectIdKey($couponId, $key, $memberId, $companyId, $hotelplanId) {
		$sql  = "select ";
		$sql .= "COUPONBOOK_ID ";
		$sql .= "from ".couponBooking::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("COUPONBOOK_STATUS", "=", 1)." and ";
		$sql .= parent::expsData("MEMBER_ID", "=", $memberId)." and ";
		$sql .= parent::expsData("COUPON_KEY_CODE", "=", $key, true, 1)." and ";
		$sql .= parent::expsData("COMPANY_ID", "=", $companyId)." and ";
	//	$sql .= parent::expsData("COUPONPLAN_HOTELPLAN_ID", "=", $hotelplanId)." and ";
		$sql .= parent::expsData("COUPON_ID_NUM", "=", $couponId, true, 1)." ";
//print $sql;
		parent::setCollection($sql, couponBooking::keyName);
	}



	public function cancel() {
// 		print_r(parent::getCollection());exit; 
// 		print_r(parent::getCollection());
// 				parent::getByKey(parent::getKeyValue(), 'BOOKING_STATUS')==5?$this->mails(couponBooking::mailRequestID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))):$this->mails(couponBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));
// 				$this->mails(couponBooking::mailCancelID);
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
//		print_r($dataList);exit; 
		
		$sql .= "update ".couponBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			return false;
		}
		
		//在庫管理追加
		for($i=0;$i<$dataList["night_number"];$i++){
			$sql = "";
			$sql .= "update HOTELPROVIDE set HOTELPROVIDE_BOOKEDNUM = HOTELPROVIDE_BOOKEDNUM - ".$dataList["BOOKING_NUM_NIGHT"];
			$sql .= " where ROOM_ID=".$dataList["ROOM_ID"]." and COMPANY_ID = ".$dataList["COMPANY_ID"];
			$sql .= " and HOTELPROVIDE_DATE = '".date('Y-m-d',strtotime($dataList["BOOKING_DATE"])+$i*60*60*24)."'";
			if (!$this->saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}
		
		
		//parent::getByKey(parent::getKeyValue(), 'BOOKING_STATUS')==5?$this->mails(couponBooking::mailRequestID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))):$this->mails(couponBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));
		$this->mails(couponBooking::mailCancelID,'',false);
		
		$this->mails(couponBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")),true);
		
		return true;
	}
	
	public function noshow() {
		$sql .= "update ".couponBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 3).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			return false;
		}

		return true;
	}
	
	public function checkBookedNum($bookingcontArray){
		$sql  = "select ";
		$sql .= "count(*) as num from ".couponBooking::tableName." ";
		
		$where = " BOOKING_STATUS <> 2 ";
		
		if ($bookingcontArray[1]["COMPANY_ID"] != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $bookingcontArray[1]["COMPANY_ID"])." ";
		}
		
		if ($bookingcontArray[1]["HOTELPLAN_ID"] != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_ID", "=", $bookingcontArray[1]["HOTELPLAN_ID"])." ";
		}
		
		if ($bookingcontArray[1]["BOOKING_DATE"]!= "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("BOOKING_DATE", "=", $bookingcontArray[1]["BOOKING_DATE"], true)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			while($row = mysql_fetch_array($result)) {
				$bookedNum = $row["num"];
			}
		}
		
		//		print_r($bookedNum);
		//		exit;
		return $bookedNum;
	}
	

	// $lengthで桁数指定 ランダムキーコード作成
	public function KeyCodeStr($length = 5) {
		static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
		$k_str = '';
		for ($i = 0; $i < $length; ++$i) {
			$k_str .= $chars[mt_rand(0, 61)];
		}
		return $k_str;

	}

	public function CouponIdNumStr($length = 10) {
		static $chars = '0123456789';
		$c_str = '';
		for ($i = 0; $i < $length; ++$i) {
			$c_str .= $chars[mt_rand(0, 61)];
		}
		return $c_str;
	}

/*
	// 購入済みクーポンとの照合用
	public  function couponStatusCheck($member, $couponId) {
		$sql  = "select ";
		$sql .= "COUPONBOOK_ID, COMPANY_ID, cplan.COUPONPLAN_ID, cplan.HOTELPLAN_ID, COUPON_ID_NUM, MEMBER_ID, COUPON_KEY, COUPONBOOK_STATUS, cplan.COUPONPLAN_USE_FROM, cplan.COUPONPLAN_USE_TO ";
		$sql .= "from ".couponBooking::tableName." cp ";
		$sql .= "left join COUPONPLAN cplan on cp.COUPONPLAN_ID = cplan.COUPONPLAN_ID and cp.COMPANY_ID = cplan.COMPANY_ID";
		$sql .= "where ";
		$sql .= parent::expsData("MEMBER_ID", "=", $memberId)." ";
		$sql .= parent::expsData("COUPON_ID_NUM", "=", $couponId, true, 1)." ";
		parent::setCollection($sql, couponBooking::keyName);
	}
*/

	public function checkAll($bookingcontArray) {
		
		if (count($bookingcontArray) > 0) {
		}

/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NAME1"))) {
			parent::setError("COUPONBOOK_NAME1", "姓は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_NAME2"))) {
			parent::setError("COUPONBOOK_NAME2", "名は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_KANA1"))) {
			parent::setError("COUPONBOOK_KANA1", "セイは必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_KANA2"))) {
			parent::setError("COUPONBOOK_KANA2", "メイは必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SEX"))) {
			parent::setError("SEX", "性別は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_BIRTH1"))) {
			parent::setError("COUPONBOOK_BIRTH1", "生年月日は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_BIRTH2"))) {
			parent::setError("COUPONBOOK_BIRTH2", "生年月日は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_BIRTH3"))) {
			parent::setError("COUPONBOOK_BIRTH3", "生年月日は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_AGE"))) {
			parent::setError("COUPONBOOK_AGE", "年齢は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MAIL_ADDRESS"))) {
			parent::setError("MAIL_ADDRESS", "メールアドレスは必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_PREF"))) {
			parent::setError("COUPONBOOK_PREF", "住所は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_CITY"))) {
			parent::setError("COUPONBOOK_CITY", "住所は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_ADD"))) {
			parent::setError("COUPONBOOK_ADD", "住所は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_ACCESS_STATION"))) {
			parent::setError("COUPONBOOK_ACCESS_STATION", "最寄り駅は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_ACCESS_TOOL"))) {
			parent::setError("COUPONBOOK_ACCESS_TOOL", "最寄り駅は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_ACCESS_TIME"))) {
			parent::setError("COUPONBOOK_ACCESS_TIME", "最寄り駅は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_TEL1"))) {
			parent::setError("COUPONBOOK_TEL1", "電話番号は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_FAMILY"))) {
			parent::setError("COUPONBOOK_FAMILY", "家族構成は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_EDUCATION"))) {
			parent::setError("COUPONBOOK_EDUCATION", "最終学歴は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_SCHOOL_NAME"))) {
			parent::setError("COUPONBOOK_SCHOOL_NAME", "卒業校名は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_SCHOOL_CORSE"))) {
			parent::setError("COUPONBOOK_SCHOOL_CORSE", "卒業学部・学科名は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_GRADUATION_DATE1"))) {
			parent::setError("COUPONBOOK_GRADUATION_DATE1", "卒業年月は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONBOOK_GRADUATION_DATE2"))) {
			parent::setError("COUPONBOOK_GRADUATION_DATE2", "卒業年月は必須項目です");
		}
*/

	}

	public function checkRequestBooking(){
		if (!$_POST) return;
		
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST"))) {
			parent::setError("BOOKING_REQUEST", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST_ANSWER"))) {
			parent::setError("BOOKING_REQUEST_ANSWER", "必須項目です");
		}
	}
	
	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_ID"))) {
			parent::setErrorFirst("プランの取得に失敗しました");
		}

	}

	/*
	public function check($hotelPlanTarget) {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA1"))) {
			parent::setError("HOTELPAY_PS_DATA1", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA1") == 1) {
				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"))) {
					parent::setError("HOTELPAY_PS_DATA3", "必須項目です");
				}
				elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_PS_DATA3", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), 10)) {
					parent::setError("HOTELPAY_PS_DATA3", "10文字以内で入力して下さい");
				}

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA4"))) {
					parent::setError("HOTELPAY_PS_DATA4", "必須項目です");
				}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_PS_DATA3", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), 10)) {
					parent::setError("HOTELPAY_PS_DATA3", "10文字以内で入力して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA1"))) {
			parent::setError("HOTELPAY_BB_DATA1", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA1") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"))) {
				parent::setError("HOTELPAY_BB_DATA3", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA3", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), 10)) {
				parent::setError("HOTELPAY_BB_DATA3", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA4"))) {
				parent::setError("HOTELPAY_BB_DATA4", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA3", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), 10)) {
					parent::setError("HOTELPAY_BB_DATA3", "10文字以内で入力して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA5"))) {
			parent::setError("HOTELPAY_BB_DATA5", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA5") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"))) {
				parent::setError("HOTELPAY_BB_DATA6", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA6", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), 10)) {
				parent::setError("HOTELPAY_BB_DATA6", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA7"))) {
				parent::setError("HOTELPAY_BB_DATA7", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA6", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), 10)) {
					parent::setError("HOTELPAY_BB_DATA6", "10文字以内で入力して下さい");
				}
			}
		}



		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA8"))) {
			parent::setError("HOTELPAY_BB_DATA8", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA8") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"))) {
				parent::setError("HOTELPAY_BB_DATA10", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA10", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), 10)) {
				parent::setError("HOTELPAY_BB_DATA10", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA11"))) {
				parent::setError("HOTELPAY_BB_DATA11", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA10", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), 10)) {
					parent::setError("HOTELPAY_BB_DATA10", "10文字以内で入力して下さい");
				}
			}
		}



		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA12"))) {
			parent::setError("HOTELPAY_BB_DATA12", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA12") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"))) {
				parent::setError("HOTELPAY_BB_DATA13", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA13", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), 10)) {
				parent::setError("HOTELPAY_BB_DATA13", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA14"))) {
				parent::setError("HOTELPAY_BB_DATA14", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA13", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), 10)) {
					parent::setError("HOTELPAY_BB_DATA13", "10文字以内で入力して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG"))) {
			parent::setError("HOTELPAY_SERVICE_FLG", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"))) {
				parent::setError("HOTELPAY_SERVICE", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_SERVICE", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), 10)) {
				parent::setError("HOTELPAY_SERVICE", "10文字以内で入力して下さい");
			}

		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_SERVICE", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), 10)) {
					parent::setError("HOTELPAY_SERVICE", "10文字以内で入力して下さい");
				}
			}
		}


		$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
		$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));

		$erCalender = array();

		for ($y=$from["y"]; $y<=$to["y"]; $y++) {
			for ($m=$from["m"]; $m<=$to["m"]; $m++) {
				for ($d=1; $d<=31; $d++) {


					$dd = str_pad($d, 2, "0", STR_PAD_LEFT);
					$mm = str_pad($m, 2, "0", STR_PAD_LEFT);

					if (strtotime($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM")) <= strtotime($y.'-'.$mm.'-'.$dd) and
						strtotime($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO")) >= strtotime($y.'-'.$mm.'-'.$dd) ) {


// 					if (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_FLG_STOP") == 1) {
						//	売りの場合
						for ($i=1; $i<=6; $i++) {
							if (!cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i))) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は必須項目です。";
							}
							elseif (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i), CHK_PTN_NUM) and parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) != "x") {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は「x」か半角数字で入力して下さい。";
							}
							elseif (!cmChekLength(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i), 10)) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は「x」半角数字10文字以内で入力して下さい。";
							}
							else {

								if (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) > parent::getByKey("BOOKSET_PAY_ALARM", "BOOKSET_PAY_ALARM")  and parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) != "x") {
									$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」がアラーム設定された金額を上回っています。";
								}
							}
						}

						if (!cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"))) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は必須項目です。";
						}
						elseif (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"), CHK_PTN_NUM)) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は半角数字で入力してください。";
						}
						elseif (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM") < 1 or parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM") > 10) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は1～10%で入力してください。";
						}


					}
				}
			}
		}

		if (count($erCalender) > 0) {
			parent::setError("calencer", $erCalender);
		}

	}
	*/

	public function getLastNotificationID($company_id) {
		$sql  = "select count(*) as num from ".couponBooking::tableName." ";
		$sql .= "where COMPANY_ID= ".$company_id;
		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			while($row = mysql_fetch_array($result)) {
				return $row["num"];
			}
		}
		else {
			return 1;
		}
	}

	public function setPost() {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}


			/*
			$dataCategory = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataCategory != "") {
						$dataCategory .= ":";
					}
					$dataCategory .= $d;
				}
				$this->setByKey($this->getKeyValue(), "couponBooking_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "couponBooking_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "couponBooking_LIST_CATEGORY"));
			}

			$dataCategoryDetail = "";
			if (count($_POST["category"]) > 0) {
				if (count($_POST["categoryDetail"]) > 0) {
					foreach ($_POST["category"] as $d) {
						foreach ($_POST["categoryDetail"] as $dd) {
							if ($d != $dd) {
								continue;
							}
							if ($dataCategoryDetail != "") {
								$dataCategoryDetail .= ":";
							}
							$dataCategoryDetail .= $dd;
						}
					}
					$this->setByKey($this->getKeyValue(), "couponBooking_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "couponBooking_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "couponBooking_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "couponBooking_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "couponBooking_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "couponBooking_LIST_AREA", $this->getByKey($this->getKeyValue(), "couponBooking_LIST_AREA"));
			}
			*/


		}

	}


}
?>