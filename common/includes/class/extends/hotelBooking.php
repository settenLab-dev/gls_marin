<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookingcont.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mMail.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');

///////////////////////
//	fax
require_once(PATH_SLAKER_COMMON.'includes/class/sendfax.php');
///////////////////////

class hotelBooking extends collection {
	const tableName = "BOOKING";
	const keyName = "BOOKING_ID";
	const tableKeyName = "BOOKING_ID";
	const mailRequestID = 12;
	const mailCancelID = 5;
	const mailBooking = 3;
	const mailBookingRequest = 6;
	
	const mailRequestID2hotel = 20;
	const mailCancelID2hotel = 21;
	const mailBooking2hotel = 14;
	const mailBookingRequest2hotel = 18;

	const mailRequestIDact = 30;
	const mailCancelIDact = 33;
	const mailBookingact = 32;
	const mailBookingRequestact = 29;
	
	const mailRequestID2act = 35;
	const mailCancelID2act = 34;
	const mailBooking2act = 31;
	const mailBookingRequest2act = 28;

	const mailRequestIDcoupon = 30;
	const mailBookingcoupon = 32;
	const mailBookingRequestcoupon = 29;
	
	const mailRequestID2coupon = 35;
	const mailBooking2coupon = 31;
	const mailBookingRequest2coupon = 28;

	private $bookingId;

	public function hotelBooking($db) {
		parent::collection($db);
	}
	
	public function selectCompanyPayId($id){
		$sql  = "select  ";
		$sql .= parent::decryptionList(BOOKSET_BOOKING_MAILADDRESS);
		$sql .= " from BOOKSET ";
	
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
					return $row['BOOKSET_BOOKING_MAILADDRESS'];
				//}
			}
		}
	}
	
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
	public function selectBookingDateId($id){
		$sql  = "select ";
		$sql .= " BOOKING_DATE ";
		$sql .= "from ".hotelBooking::tableName." ";
	
		$where = "";
	
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelBooking::keyName, "=", $id)." ";
		}
	
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
	
		$result = $this->db->execute($sql);
	
		if (mysql_affected_rows() > 0) {
			//	count set
	
			while ($row = mysql_fetch_assoc($result)) {
				return $row['BOOKING_DATE'];
			}
		}
	}
	public function selectHotelPayId($id){
		$sql  = "select ";
		$sql .= "HOTELPAY_ID ";
		$sql .= "from ".hotelBooking::tableName." ";
		
		$where = "";
		
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelBooking::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		parent::setCollection($sql, hotelPay::keyName);
	}
	
	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "hb.BOOKING_ID, hb.COMPANY_ID, hb.HOTELPLAN_ID, HOTELPAY_ID, hb.ROOM_ID, BOOKING_DATE, BOOKING_DATE_CANCEL_END, BOOKING_NUM_ROOM, hb.MEMBER_ID, BOOKING_NUM_NIGHT, ";
		$sql .= "BOOKING_LINK, BOOKING_BOOKING_CODE,TL_ROOM_NAME,TL_PLAN_NAME,TL_PLAN_CONTENTS, ";
		$sql .= parent::decryptionList("BOOKING_MEMBER_BIRTH,ROOM_NAME,HOTEL_NAME,HOTELPLAN_NAME,BOOKING_CHECKIN, BOOKING_DATE_CANCEL_END_TIME").", ";
		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKINGCONT_NUM".$i."".", ";
		}
		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("BOOKING_NAME".$i."").", ";
			$sql .= parent::decryptionList("BOOKING_KANA".$i."").", ";
		}
// 		$sql .= "case when BOOKING_LINK is null then ";
// 		$sql .= parent::encryption("HOTELPLAN_NAME", 2)." else TL_PLAN_NAME end as HOTELPLAN_NAME, ";
// 		$sql .= "case when BOOKING_LINK is null then ";
// 		$sql .= parent::encryption("ROOM_NAME", 2)." else TL_ROOM_NAME end as ROOM_NAME, ";
		$sql .= parent::decryptionList("BOOKING_ZIP").", ";
		$sql .= "BOOKING_PREF_ID, ";
		$sql .= parent::decryptionList("BOOKING_CITY, BOOKING_ADDRESS, BOOKING_BUILD, BOOKING_TEL").", ";
		$sql .= "BOOKING_AGE, ";
		$sql .= parent::decryptionList("BOOKING_MAILADDRESS, BOOKING_ANSWER, BOOKING_DEMAND").", ";
		$sql .= "BOOKING_STATUS, BOOKING_SERVICE, BOOKING_REQUEST, BOOKING_REQUEST_ANSWER, BOOKING_MONEY, BOOKING_HOW, BOOKING_POINT_USE, BOOKING_MONRY_CANCEL, ";
		$sql .= parent::decryptionList("BOOKING_MEMO").", ";
		$sql .= "BOOKING_DATE_START, BOOKING_DATE_BOOK, BOOKING_DATE_CANCEL, BOOKING_DATE_DELETE  ";
		$sql .= "from ".hotelBooking::tableName." hb ";
		$sql .= "left join HOTEL h on hb.COMPANY_ID = h.COMPANY_ID ";
		$sql .= "left join HOTELPLAN hp on hb.HOTELPLAN_ID = hp.HOTELPLAN_ID ";
		$sql .= "left join ROOM r on hb.ROOM_ID = r.ROOM_ID ";
//		$sql .= "inner join TL_PLAN linkhp on hb.BOOKING_LINK = linkhp.TL_HOTEL_ID ";
//		$sql .= "inner join (TL_PLAN linkhp inner join TL_ROOM linkr on linkhp.TL_HOTEL_ID = linkr.TL_HOTEL_ID) on hb.HOTELPLAN_ID = linkhp.TL_PLAN_CODE ";
		$sql .= "left join TL_PLAN linkhp on hb.HOTELPLAN_ID = linkhp.TL_PLAN_CODE and hb.BOOKING_LINK = linkhp.TL_HOTEL_ID ";
		$sql .= "left join TL_ROOM linkr on hb.ROOM_ID = linkr.TL_ROOM_TYPECODE and hb.BOOKING_LINK = linkr.TL_HOTEL_ID ";
		$sql .= "left join BOOKINGCONT bkc on hb.BOOKING_ID = bkc.BOOKING_ID and hb.COMPANY_ID=bkc.COMPANY_ID ";


		$where = "";

//		$where .= parent::expsData("linkhp.TL_ROOM_TYPECODE", "=", "linkr.TL_ROOM_TYPECODE")." ";

		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelBooking::keyName, "=", $collection->getByKey($collection->getKeyValue(), "BOOKING_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hb.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hb.HOTELPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPAY_ID", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_ID", "=", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hb.ROOM_ID", "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("BOOKING_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "BOOKING_DATE"), true)." ";
			$where .= "and ".parent::expsData("BOOKING_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "BOOKING_DATE")))), true)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by BOOKING_ID desc  ";
//		print_r($collection);
//  		echo $sql;exit;

		parent::setCollection($sql, hotelBooking::keyName);
	}

	public function selectBookedNum($collection) {
		$sql  = "select ";
		$sql .= "count(*) as num from ".hotelBooking::tableName." ";

		$where = " BOOKING_STATUS <> 2 ";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("BOOKING_DATE", "=", $collection->getByKey($collection->getKeyValue(), "BOOKING_DATE"), true)." ";
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
		$sql .= "from ".hotelBooking::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelBooking::keyName, "=", $id)." ";
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

		parent::setCollection($sql, hotelBooking::keyName);
	}

	public function selectCancelRoom($id,$companId){
		$sql = "select ";
		$sql.= "count(*) canceled from ".hotelBookingcont::tableName;
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
		$sql.= " BOOKINGCONT_MONEY   from ".hotelBookingcont::tableName;
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
	
	public function selectCancelData($id="", $hotelPlanId="", $payId="", $roomId="", $comapnyId="", $memberId="") {
		$sql  = "select ";
		$sql .= "HOTELPLAN_FLG_CANCEL, hb.BOOKING_ID, hb.COMPANY_ID, hb.HOTELPLAN_ID, HOTELPAY_ID, hb.ROOM_ID, BOOKING_DATE, BOOKING_DATE_CANCEL_END, BOOKING_NUM_ROOM, hb.MEMBER_ID, BOOKING_NUM_NIGHT, ";
		$sql .= "BOOKING_LINK, BOOKING_BOOKING_CODE, TL_PLAN_NAME, TL_ROOM_NAME, TL_PLAN_CONTENTS, HOTELPLAN_NAME, ROOM_NAME, HOTELPLAN_CONTENTS,";
		$sql .= parent::decryptionList("BOOKING_CHECKIN, BOOKING_DATE_CANCEL_END_TIME").", ";
		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("BOOKING_NAME".$i."").", ";
			$sql .= parent::decryptionList("BOOKING_KANA".$i."").", ";
		}

		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPLAN_CANCEL_FLG".$i.", ";
			$sql .= "HOTELPLAN_CANCEL_MONEY".$i.", ";
			if ($i >= 3) {
				$sql .= "HOTELPLAN_CANCEL_FROM".$i.", ";
				$sql .= "HOTELPLAN_CANCEL_TO".$i.", ";
			}
		}

		$sql .= parent::decryptionList("MEMBER_BIRTH_YEAR,MEMBER_BIRTH_MONTH,MEMBER_BIRTH_DAY").", ";
		$sql .= parent::decryptionList("BOOKING_ZIP").", ";
		$sql .= "BOOKING_PREF_ID, ";
		$sql .= parent::decryptionList("BOOKING_MEMBER_BIRTH,BOOKING_CITY, BOOKING_ADDRESS, BOOKING_BUILD, BOOKING_TEL").", ";
		$sql .= "BOOKING_AGE, ";
		$sql .= parent::decryptionList("BOOKING_MAILADDRESS, BOOKING_ANSWER, BOOKING_DEMAND, BOOKING_REQUEST_ANSWER, BOOKING_HOTELPLAN_CONTENTS, COUPON_ID_NUM").", ";
		$sql .= "BOOKING_STATUS, BOOKING_SERVICE, BOOKING_REQUEST, BOOKING_MONEY, BOOKING_HOW, BOOKING_POINT_USE, BOOKING_MONRY_CANCEL, hp.HOTELPLAN_ACC_DAY, hp.HOTELPLAN_ACC_HOUR, hp.HOTELPLAN_ACC_MIN, hp.HOTELPLAN_CAN_DAY, hp.HOTELPLAN_CAN_HOUR, hp.HOTELPLAN_CAN_MIN, ";
		$sql .= parent::decryptionList("BOOKING_MEMO").", ";
		$sql .= "BOOKING_DATE_START, BOOKING_DATE_BOOK, BOOKING_DATE_CANCEL, BOOKING_DATE_DELETE  ";
		$sql .= "from ".hotelBooking::tableName." hb ";
		$sql .= "left join HOTELPLAN hp on hb.HOTELPLAN_ID = hp.HOTELPLAN_ID ";
		$sql .= "left join ROOM r on hb.ROOM_ID = r.ROOM_ID ";
		$sql .= "left join TL_PLAN linkhp on hb.HOTELPLAN_ID = linkhp.TL_PLAN_CODE and hb.BOOKING_LINK = linkhp.TL_HOTEL_ID ";
		$sql .= "left join TL_ROOM linkr on hb.ROOM_ID = linkr.TL_ROOM_TYPECODE and hb.BOOKING_LINK = linkr.TL_HOTEL_ID ";
		$sql .= "left join MEMBER mem on mem.MEMBER_ID = hb.MEMBER_ID ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelBooking::keyName, "=", $id)." ";
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
			$where .= parent::expsData("hb.COMPANY_ID", "=", $comapnyId)." ";
		}

		if ($memberId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hb.MEMBER_ID", "=", $memberId)." ";
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
		
		parent::setCollection($sql, hotelBooking::keyName);
	}


	private function setBookinId($id) {
		$this->bookingId = $id;
	}
	public function getBookingId() {
		return $this->bookingId;
	}


	public function updateBooking($id, $bookingCode) {
			$this->db->begin();

			$sql .= "update ".hotelBooking::tableName." set ";
			$sql .= parent::expsData("BOOKING_BOOKING_CODE", "=", $bookingCode, true).", ";
			$sql .= parent::expsData("BOOKING_DATE_BOOK", "=", "now()")." ";
			$sql .= "where ";
			$sql .=  parent::expsData(hotelBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}

			$bookingcont = new hotelBookingcont($this->db);
			if (!$bookingcont->updateBooking($id, $bookingCode)) {
				$this->db->rollback();
				return false;
			}

			$this->db->commit();
			return true;
	}
	
	public function updateBookingStatus($id, $bookingStatus) {
			$this->db->begin();

			$sql .= "update ".hotelBooking::tableName." set ";
			$sql .= parent::expsData("BOOKING_STATUS", "=", $bookingStatus, true)." ";
			$sql .= "where ";
			$sql .=  parent::expsData(hotelBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}

			$bookingcont = new hotelBookingcont($this->db);
			if (!$bookingcont->updateBookingStatus($id, $bookingStatus)) {
				$this->db->rollback();
				return false;
			}

			$this->db->commit();
			return true;
	}

	public function cancelBookingLink() {
		$this->db->begin();

		$sql .= "update ".hotelBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$bookingcont = new hotelBookingcont($this->db);
		if (!$bookingcont->cancelAll(parent::getKeyValue(), 0)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}


	public function saveBooking(){
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		$sql .= "update ".hotelBooking::tableName." set ";
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
		$sql .=  parent::expsData(hotelBooking::keyName, "=", parent::getKeyValue())." ";
// 		echo $sql;exit;
		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}
		
		$this->db->commit();
		return true;
	}
	
	public function saveRequestBooking(){
			$this->db->begin();
			$dataList = parent::getCollectionByKey(parent::getKeyValue());
			
			if($dataList["BOOKING_REQUEST"] == 1){
				$dataList["BOOKING_STATUS"] = 1;
			}
			else {
				$dataList["BOOKING_STATUS"] = 6;
			}
			
			$sql .= "update ".hotelBooking::tableName." set ";
			$sql .= "BOOKING_REQUEST = ".$dataList["BOOKING_REQUEST"].", ";
			$sql .= parent::expsData("BOOKING_REQUEST_ANSWER", "=", $dataList["BOOKING_REQUEST_ANSWER"], true, 1).", ";
			$sql .= "BOOKING_STATUS = ".$dataList["BOOKING_STATUS"]."  ";
			$sql .= "where ";
			$sql .=  parent::expsData(hotelBooking::keyName, "=", parent::getKeyValue())." ";
			
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				$stat = 0;
			}
			//同?改?hotelBookingcont表
			$bookingCon = new hotelBookingcont($this->db);
			$sql = '';
			$sql .= "update ".hotelBookingcont::tableName." set ";
			$sql .= "BOOKINGCONT_STATUS = ".$dataList["BOOKING_STATUS"]."  ";
			$sql .= "where ";
			$sql .=  parent::expsData(hotelBooking::keyName, "=", parent::getKeyValue())." and ";
			$sql .=  parent::expsData(hotel::keyName, "=", $dataList['COMPANY_ID'])." ";
			
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				$stat = 0;
			}
			
			//メール内容設定
			$mMail = new mMail($this->db);
			$mMail->select(hotelBooking::mailRequestID);
			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("パスワードリマインダーメールの取得に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				$stat = 0;
			}
			
//			print_r($dataList);exit;
			
			$from = MAIL_SLAKER_NOREPLY;
			$to = $dataList['BOOKING_MAILADDRESS'];
			
			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			
			//引数入り変え
			$hotel = new hotel($this->db);
			$hotel->select($dataList['COMPANY_ID']);
			
			$subject = cmReplace($subject, "[!HOTEL_NAME!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));

			if($dataList["BOOKING_REQUEST"] == 1){
				$body = cmReplace($body, "[!REQUEST_ANSWER!]", "ご予約を承りました。");
			}
			else{
				$body = cmReplace($body, "[!REQUEST_ANSWER!]", "申し訳ありません。ご希望のお日にちはご予約をお受けできません。");
			}
			$body = cmReplace($body, "[!HOTEL_NAME!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_NAME"));
			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日 H:i:s"));
			
			$body = cmReplace($body, "[!MESSAGE!]", $dataList['BOOKING_REQUEST_ANSWER']);
			$body = cmReplace($body, "[!HOTEL_TEL!]", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_TEL"));
			$body = cmReplace($body, "[!HOTEL_URL!]", URL_PUBLIC."search-detail.html?basic=1&hid=".$dataList['COMPANY_ID']);
			
			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("仮登録メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				$stat = 0;
			}
			
			$this->db->commit();
			$stat = 1;
			
			return $stat;
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
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '事前支払い');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 3) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", 'ココトモ！クーポン利用');
		}
		else{
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
			$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '事前支払い');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 3) {
			$body = cmReplace($body, "[!BOOKING_HOW!]", 'ココトモ！クーポン利用');
		}
		else {
			$body = cmReplace($body, "[!BOOKING_HOW!]", '');
		}
		
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==1) $body = cmReplace($body, "[!REQUEST_ANSWER!]", 'リクエストありがとうございます。ご予約を承りました。');
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==2) $body = cmReplace($body, "[!REQUEST_ANSWER!]", '申し訳ございません。ご希望のお日にちは満室です。');
		
		
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("仮登録メールの送信に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
//print_r($body);
		if($fax){
				//	FAX番号確認
				$faxnumer = cmReplace($this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")), "-", "");
				 			//echo $faxnumer;
				// 			$faxnumer='0989888106';

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
		$hotelPlan = new hotelPlan($this->db);
		$hotelPlan->getPlanContentById($id);
		return $hotelPlan->getByKey($hotelPlan->getKeyValue(), "HOTELPLAN_CONTENTS");
	}

	public function save($bookingcontArray,$is_request=false) {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		if($dataList["BOOKING_LINK"] != ""){
			$dataList["NOTIFICATION_ID"] = 0;
		}
		//print_r($dataList);exit;
		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
			$dataList['BOOKING_HOTELPLAN_CONTENTS']=$this->getPlanContentById($dataList['HOTELPLAN_ID']);
// 			echo $dataList['BOOKING_HOTELPLAN_CONTENTS'];exit;
			$sql = $this->insert($dataList);
// 			echo $sql;exit;
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
			$idData->lastInsert(hotelBooking::tableName);
			$id = $idData->getByKey($idData->getKeyValue(), "id");
 			$bookingcontArray["BOOKING_ID"] = $id;
		}

		$this->setBookinId($id);

		$bookingcont = new hotelBookingcont($this->db);
		if (!$bookingcont->saveAll($bookingcontArray, $id)) {
			$this->db->rollback();
			return false;
		}


		//リンカーン以外(ココトモのみ）
		if( $dataList["BOOKING_LINK"] == ""){
		
			//在庫管理追加		
			for($i=0;$i<$dataList["night_number"];$i++){
				$sql = "";
				$sql .= "update HOTELPROVIDE set HOTELPROVIDE_BOOKEDNUM = HOTELPROVIDE_BOOKEDNUM+".$dataList["room_number"];
				$sql .= " where ROOM_ID=".$dataList["ROOM_ID"]." and COMPANY_ID = ".$dataList["COMPANY_ID"];
				$sql .= " and HOTELPROVIDE_DATE = '".date('Y-m-d',strtotime($dataList["BOOKING_DATE"])+$i*60*60*24)."'";
				if (!$this->saveExec($sql)) {
					$this->db->rollback();
					return false;
				}
			}
				
			
			$mMail = new mMail($this->db);
			//ユーザー宛て予約メール
			
			
			$mailid = !$is_request?hotelBooking::mailBooking:hotelBooking::mailBookingRequest;
			$mailid2 = !$is_request?hotelBooking::mailBookingact:hotelBooking::mailBookingRequestact;
	//		$mMail->select($mailid);
			if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")or($_SERVER['REQUEST_URI'] == "/reservation-hotelcoupon.html")){
				$mMail->select($mailid);
			}
			elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$mMail->select($mailid2);
			}
			else{
			}

			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("予約メールの取得に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}

			$from = MAIL_SLAKER_NOREPLY;
			$to = parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS");

			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$subject = cmReplace($subject, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));

			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["BOOKING_ID"]);
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!HOTEL_ZIP!]", parent::getByKey(parent::getKeyValue(), "hotel_zip"));
			$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address"));
			$body = cmReplace($body, "[!HOTEL_CHECKIN!]", parent::getByKey(parent::getKeyValue(), "hotel_checkin")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
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

			if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '事前支払い … 施設より別途お支払のご案内をいたします。');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 3) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", 'ココトモ！クーポン利用 … 当日必ずクーポンをご提示ください。');
			}
			else{
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

			//クーポン利用時のクーポンIDを表示（利用なしの場合は非表示）
			if (parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM") != "") {
				$coupon_id_num = "クーポンID：";	
				$coupon_id_num .= parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM");	
			}
			else{
				$coupon_id_num = "";
			}
			$body = cmReplace($body, "[!COUPON_ID_NUM!]", $coupon_id_num);


			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("予約メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
			
			//ホテル宛て予約メール
			$mailid = !$is_request?hotelBooking::mailBooking2hotel:hotelBooking::mailBookingRequest2hotel;
			$mailid2 = !$is_request?hotelBooking::mailBooking2act:hotelBooking::mailBookingRequest2act;
	//		$mMail->select($mailid);
			if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")or($_SERVER['REQUEST_URI'] == "/reservation-hotelcoupon.html")){
				$mMail->select($mailid);
			}
			elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$mMail->select($mailid2);
			}
			else{
			}

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
			$subject = cmReplace($subject, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$subject = cmReplace($subject, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");
			
			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["BOOKING_ID"]?$bookingcontArray["BOOKING_ID"]:parent::getByKey(parent::getKeyValue(), "BOOKING_ID"));
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));
			
			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!HOTEL_ZIP!]", parent::getByKey(parent::getKeyValue(), "hotel_zip"));
			$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address"));
			$body = cmReplace($body, "[!HOTEL_CHECKIN!]", parent::getByKey(parent::getKeyValue(), "hotel_checkin")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
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
			
			if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済 … ご宿泊の際に現地で直接お支払いです。');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '事前支払い … お客様へお支払のご案内をお願いいたします。');

			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 3) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", 'ココトモ！クーポン利用 … 当日必ずクーポンIDをご確認ください。');

			}
			else{
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

			//クーポン利用時のクーポンIDを表示（利用なしの場合は非表示）
			if (parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM") != "") {
				$coupon_id_num = "クーポンID：";	
				$coupon_id_num .= parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM");	
			}
			else{
				$coupon_id_num = "";
			}
			$body = cmReplace($body, "[!COUPON_ID_NUM!]", $coupon_id_num);



			//mail18
			
			$body = cmReplace($body, "[!BOOKING_NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAIL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
			$body = cmReplace($body, "[!BOOKING_NIGHT!]", parent::getByKey(parent::getKeyValue(), "night_number"));
			$body = cmReplace($body, "[!CHECKIN_DAY!]", parent::getByKey(parent::getKeyValue(), "hotel_checkin"));
			$body = cmReplace($body, "[!CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
			$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
			$body = cmReplace($body, "[!MONEY_ALL!]", parent::getByKey(parent::getKeyValue(), "payment"));
			$body = cmReplace($body, "[!MEMBER_ID!]", parent::getByKey(parent::getKeyValue(), "MEMBER_ID"));
//			$body = cmReplace($body, "[!BOOKING_HOW!]", parent::getByKey(parent::getKeyValue(), "BOOKING_HOW"));
			if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
				$body = cmReplace($body, "[!BOOKING_HOW!]", '現地決済');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
				$body = cmReplace($body, "[!BOOKING_HOW!]", '事前支払い');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 3) {
				$body = cmReplace($body, "[!BOOKING_HOW!]", 'ココトモ！クーポン利用… 当日必ずクーポンIDをご確認ください。');
			}
			else{
			}

			$body = cmReplace($body, "[!BOOKING_REQUEST!]", parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST"));
			//mail14
			$body = cmReplace($body, "[!ADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CITY").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_ADDRESS").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_BUILD"));
			$body = cmReplace($body, "[!BIRTHDAY!]", parent::getByKey(parent::getKeyValue(), "BOOKING_AGE"));
			$body = cmReplace($body, "[!JOB!]", parent::getByKey(parent::getKeyValue(), ""));
	// 		echo $mailid.$from.'<BR>'.$to.'<BR>'.$subject.'<BR>'.$body;exit;		
			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("予約メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
			
			////////////////////////////////////////////////////////////////////////////////////////////
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
			////////////////////////////////////////////////////////////////////////////////////////////
		}//kokomoホテルのみ


		//リンカーン使用時のメール
/*	if($dataList["BOOKING_LINK"] != ""){
		sleep(5);
		if($dataList["BOOKING_STATUS"] != 9){
			$mMail = new mMail($this->db);
			//お客様のみメール送信
			
			
			$mailid = !$is_request?hotelBooking::mailBooking:hotelBooking::mailBookingRequest;
	//		$mMail->select($mailid);
			if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$mMail->select($mailid);
			}
			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("予約メールの取得に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}

			$from = MAIL_SLAKER_NOREPLY;
			$to = parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS");

			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$subject = cmReplace($subject, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));

			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["BOOKING_ID"]);
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!HOTEL_ZIP!]", parent::getByKey(parent::getKeyValue(), "hotel_zip"));
			$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address"));
			$body = cmReplace($body, "[!HOTEL_CHECKIN!]", parent::getByKey(parent::getKeyValue(), "hotel_checkin")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
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

			if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '事前支払い … 施設より別途お支払のご案内をいたします。');
			}
			$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "BOOKING_MONEY")*0.92/100));
			$question = "";
			if (parent::getByKey(parent::getKeyValue(), "question") != "") {
				$question  = "-----------------------------------------------------------------------\n";
				$question .= "【宿からの質問】\n";
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

			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("予約メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
		}
	}*/

		$this->db->commit();
		return $bookingcontArray["BOOKING_ID"];

	}



	public function linkmail($bookingcontArray) {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		//リンカーン使用時のメール
	if($dataList["BOOKING_LINK"] != ""){
			$mMail = new mMail($this->db);
			//お客様のみメール送信
			
			
			$mailid = !$is_request?hotelBooking::mailBooking:hotelBooking::mailBookingRequest;
			$mMail->select($mailid);
	/*		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$mMail->select($mailid);
			}
	*/
			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("予約メールの取得に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}

			$from = MAIL_SLAKER_NOREPLY;
			$to = parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS");

			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$subject = cmReplace($subject, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));

			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			$body = cmReplace($body, "[!BOOKING_ID!]", $this->bookingId);
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!HOTEL_ZIP!]", parent::getByKey(parent::getKeyValue(), "hotel_zip"));
			$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address"));
			$body = cmReplace($body, "[!HOTEL_CHECKIN!]", parent::getByKey(parent::getKeyValue(), "hotel_checkin")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
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

			if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '現地決済 … 宿泊の際に現地で直接お支払いください。');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 2) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '事前支払い … 施設より別途お支払のご案内をいたします。');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 3) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", 'ココトモ！クーポン利用 … 当日必ずクーポンをご提示ください。');
			}
			else{
			}

			$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "BOOKING_MONEY")*0.92/100));
			$question = "";
			if (parent::getByKey(parent::getKeyValue(), "question") != "") {
				$question  = "-----------------------------------------------------------------------\n";
				$question .= "【宿からの質問】\n";
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

			//クーポン利用時のクーポンIDを表示（利用なしの場合は非表示）
			if (parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM") != "") {
				$coupon_id_num = "クーポンID：";	
				$coupon_id_num .= parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM");	
			}
			else{
				$coupon_id_num = "";
			}
			$body = cmReplace($body, "[!COUPON_ID_NUM!]", $coupon_id_num);


			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("予約メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
	}
		$this->db->commit();
	}
	/*
	public function save($hotelPlanTarget) {
		$this->db->begin();
		$sql = "";

		$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
		$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));

		for ($y=$from["y"]; $y<=$to["y"]; $y++) {
			for ($m=$from["m"]; $m<=$to["m"]; $m++) {
				for ($d=1; $d<=31; $d++) {

					$dd = str_pad($d, 2, "0", STR_PAD_LEFT);
					$mm = str_pad($m, 2, "0", STR_PAD_LEFT);


					if ($from["y"] == $y and $from["m"] == $m and $from["d"] > $d) {
// 					print "aa".$from["y"]."-".$from["m"]."-".$from["d"]."/".$y.'-'.$m.'-'.$dd.parent::getByKey($y.'-'.$m.'-'.$dd, "HOTELPAY_MONEY1")."<br />";
						continue;
					}
					if ($to["y"] == $y and $to["m"] == $m and $to["d"] < $d) {
						continue;
					}
					$dataList = array();
					$dataList["HOTELPAY_ID"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ID");
					$dataList["COMPANY_ID"] = parent::getByKey("COMPANY_ID", "COMPANY_ID");
					$dataList["HOTELPLAN_ID"] = parent::getByKey("HOTELPLAN_ID", "HOTELPLAN_ID");
					$dataList["ROOM_ID"] = parent::getByKey("ROOM_ID", "ROOM_ID");
					$dataList["HOTELPAY_DATE"] = $y.'-'.$mm.'-'.$dd;
					for ($i=1; $i<=4; $i++) {
						$dataList["HOTELPAY_PS_DATA".$i] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA".$i);
					}
					for ($i=1; $i<=14; $i++) {
						$dataList["HOTELPAY_BB_DATA".$i] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA".$i);
					}
					$dataList["HOTELPAY_SERVICE_FLG"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG");
					$dataList["HOTELPAY_SERVICE"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE");
					$dataList["HOTELPAY_REMARKS"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_REMARKS");
					for ($i=1; $i<=6; $i++) {
						$dataList["HOTELPAY_MONEY".$i] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i);
					}
					$dataList["HOTELPAY_FLG_STOP"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_FLG_STOP");
// 					$dataList["HOTELPAY_DATE"] = parent::getByKey($y.'-'.$m.'-'.$d, "HOTELPAY_DATE");
					$dataList["HOTELPAY_ROOM_NUM"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM");
					$dataList["HOTELPAY_ROOM_OVER"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER");

// 					print_r($dataList);
// 					print parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ID");
// 					print "<br />-------------------------------<br />";
// 					continue;
// 					return ;
// 					if ($dataList["HOTELPAY_ID"] == "" or $dataList["HOTELPAY_ID"] <= 0) {
					if (parent::saveDivide($dataList["HOTELPAY_ID"])) {
						$sql = $this->insert($dataList);
					}
					else {
						$sql = $this->update($dataList);
					}

					if (!$this->saveExec($sql)) {
						$this->db->rollback();
						return false;
					}

				}
			}
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
		$sql  = "insert into ".hotelBooking::tableName." (";
		$sql .= "BOOKING_ID, ";
		$sql .= "NOTIFICATION_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "HOTELPLAN_ID, ";
		$sql .= "HOTELPAY_ID, ";
		$sql .= "ROOM_ID, ";
		$sql .= "BOOKING_LINK, ";
		$sql .= "BOOKING_BOOKING_CODE, ";
		$sql .= "BOOKING_DATE, ";
		$sql .= "BOOKING_CHECKIN, ";
		$sql .= "BOOKING_DATE_CANCEL_END, ";
		$sql .= "BOOKING_DATE_CANCEL_END_TIME, ";
		$sql .= "BOOKING_NUM_NIGHT, ";
		$sql .= "BOOKING_NUM_ROOM, ";
		$sql .= "MEMBER_ID, ";
		$sql .= "BOOKING_NAME1, ";
		$sql .= "BOOKING_NAME2, ";
		$sql .= "BOOKING_KANA1, ";
		$sql .= "BOOKING_KANA2, ";
		$sql .= "BOOKING_ZIP, ";
		$sql .= "BOOKING_PREF_ID, ";
		$sql .= "BOOKING_CITY, ";
		$sql .= "BOOKING_ADDRESS, ";
		$sql .= "BOOKING_BUILD, ";
		$sql .= "BOOKING_TEL, ";
		$sql .= "BOOKING_AGE, ";
		$sql .= "BOOKING_MAILADDRESS, ";
		$sql .= "BOOKING_ANSWER, ";
		$sql .= "BOOKING_DEMAND, ";
		$sql .= "BOOKING_STATUS, ";
		$sql .= "BOOKING_SERVICE, ";
		$sql .= "BOOKING_MONEY, ";
		$sql .= "BOOKING_HOW, ";
		$sql .= "BOOKING_POINT_USE, ";
		$sql .= "BOOKING_MONRY_CANCEL, ";
		$sql .= "BOOKING_MEMO, ";
		$sql .= "BOOKING_HOTELPLAN_CONTENTS, ";
		$sql .= "COUPON_ID_NUM, ";
		$sql .= "BOOKING_DATE_START) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["NOTIFICATION_ID"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPLAN_ID"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_ID"]).", ";
		$sql .= parent::expsVal($dataList["ROOM_ID"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_LINK"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKING_BOOKING_CODE"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKING_DATE"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKING_CHECKIN"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_DATE_CANCEL_END"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKING_DATE_CANCEL_END_TIME"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKING_NUM_NIGHT"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_NUM_ROOM"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_ID"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_NAME1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_NAME2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_KANA1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_KANA2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_PREF_ID"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_BUILD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_TEL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_AGE"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_MAILADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_ANSWER"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_DEMAND"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_STATUS"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_SERVICE"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_MONEY"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_HOW"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_POINT_USE"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_MONRY_CANCEL"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_MEMO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_HOTELPLAN_CONTENTS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_ID_NUM"], true, 1).", ";
		$sql .= "now()) ";
//		print_r($dataList);exit;

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelBooking::tableName." set ";
		$sql .= parent::expsData("HOTELPLAN_ID", "=", $dataList["HOTELPLAN_ID"]).", ";
		$sql .= parent::expsData("HOTELPAY_ID", "=", $dataList["HOTELPAY_ID"]).", ";
		$sql .= parent::expsData("ROOM_ID", "=", $dataList["ROOM_ID"]).", ";
		$sql .= parent::expsData("BOOKING_LINK", "=", $dataList["BOOKING_LINK"], true).", ";
		$sql .= parent::expsData("BOOKING_BOOKING_CODE", "=", $dataList["BOOKING_BOOKING_CODE"], true).", ";
		$sql .= parent::expsData("BOOKING_DATE", "=", $dataList["BOOKING_DATE"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_CHECKIN", "=", $dataList["BOOKING_CHECKIN"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL_END", "=", $dataList["BOOKING_DATE_CANCEL_END"], true).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL_END_TIME", "=", $dataList["BOOKING_DATE_CANCEL_END_TIME"], true).", ";
		$sql .= parent::expsData("BOOKING_NUM_NIGHT", "=", $dataList["BOOKING_NUM_NIGHT"]).", ";
		$sql .= parent::expsData("BOOKING_NUM_ROOM", "=", $dataList["BOOKING_NUM_ROOM"]).", ";
		$sql .= parent::expsData("MEMBER_ID", "=", $dataList["MEMBER_ID"]).", ";
		$sql .= parent::expsData("BOOKING_NAME1", "=", $dataList["BOOKING_NAME1"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_NAME2", "=", $dataList["BOOKING_NAME2"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_KANA1", "=", $dataList["BOOKING_KANA1"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_KANA2", "=", $dataList["BOOKING_KANA2"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_ZIP", "=", $dataList["BOOKING_ZIP"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_PREF_ID", "=", $dataList["BOOKING_PREF_ID"]).", ";
		$sql .= parent::expsData("BOOKING_CITY", "=", $dataList["BOOKING_CITY"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_ADDRESS", "=", $dataList["BOOKING_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_BUILD", "=", $dataList["BOOKING_BUILD"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_TEL", "=", $dataList["BOOKING_TEL"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_AGE", "=", $dataList["BOOKING_AGE"]).", ";
		$sql .= parent::expsData("BOOKING_MAILADDRESS", "=", $dataList["BOOKING_MAILADDRESS"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_ANSWER", "=", $dataList["BOOKING_ANSWER"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_DEMAND", "=", $dataList["BOOKING_DEMAND"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", $dataList["BOOKING_STATUS"]).", ";
		$sql .= parent::expsData("BOOKING_SERVICE", "=", $dataList["BOOKING_SERVICE"]).", ";
		$sql .= parent::expsData("BOOKING_REQUEST", "=", $dataList["BOOKING_REQUEST"]).", ";
		$sql .= parent::expsData("BOOKING_REQUEST_ANSWER", "=", $dataList["BOOKING_REQUEST_ANSWER"]).", ";
		$sql .= parent::expsData("BOOKING_MONEY", "=", $dataList["BOOKING_MONEY"]).", ";
		$sql .= parent::expsData("BOOKING_SERVICE", "=", $dataList["BOOKING_SERVICE"]).", ";
		$sql .= parent::expsData("BOOKING_HOW", "=", $dataList["BOOKING_HOW"]).", ";
		$sql .= parent::expsData("BOOKING_POINT_USE", "=", $dataList["BOOKING_POINT_USE"]).", ";
		$sql .= parent::expsData("BOOKING_MONRY_CANCEL", "=", $dataList["BOOKING_MONRY_CANCEL"]).", ";
		$sql .= parent::expsData("BOOKING_MEMO", "=", $dataList["BOOKING_MEMO"], true, 1).", ";
		$sql .= parent::expsData("COUPON_ID_NUM", "=", $dataList["COUPON_ID_NUM"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_DATE_BOOK", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelBooking::keyName, "=", $this->getKeyValue())." ";

		return $sql;
	}

	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".hotelBooking::tableName." set ";
// 		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(hotelBooking::keyName, "=", parent::getKeyValue())." ";

// 		if (!parent::saveExec($sql)) {
// 			$this->db->rollback();
// 			return false;
// 		}

// 		$this->db->commit();
// 		return true;

	}

	public function cancel() {
// 		print_r(parent::getCollection());exit; 
// 		print_r(parent::getCollection());
// 				parent::getByKey(parent::getKeyValue(), 'BOOKING_STATUS')==5?$this->mails(hotelBooking::mailRequestID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))):$this->mails(hotelBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));
// 				$this->mails(hotelBooking::mailCancelID);
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
//		print_r($dataList);exit; 
		
		$sql .= "update ".hotelBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelBooking::keyName, "=", parent::getKeyValue())." ";

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
		
		
		//parent::getByKey(parent::getKeyValue(), 'BOOKING_STATUS')==5?$this->mails(hotelBooking::mailRequestID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))):$this->mails(hotelBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));
		$this->mails(hotelBooking::mailCancelID,'',false);
		
		$this->mails(hotelBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")),true);

//print_r(debug_backtrace());
		return true;
	}
	
	public function noshow() {
		$sql .= "update ".hotelBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 3).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			return false;
		}

		return true;
	}
	
	public function checkBookedNum($bookingcontArray){
		$sql  = "select ";
		$sql .= "count(*) as num from ".hotelBooking::tableName." ";
		
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
	
	public function checkAll($bookingcontArray) {
		
		if (count($bookingcontArray) > 0) {
			foreach ($bookingcontArray as $k=>$d) {
				if ($d["BOOKINGCONT_NUM1"] + $d["BOOKINGCONT_NUM2"] != $d["adult_number"]) {
					parent::setErrorFirst($d["night_number"]."泊目".$d["BOOKINGCONT_ROOM"]."部屋の男性、女性の人数を確認して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"))) {
			parent::setError("BOOKING_CHECKIN", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))) {
			parent::setError("MEMBER_ID", "会員情報の取得に失敗しました");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_HOW"))) {
			parent::setError("BOOKING_HOW", "選択して下さい");
		}

		if (parent::getByKey(parent::getKeyValue(), "question_req") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER"))) {
				parent::setError("BOOKING_ANSWER", "質問への回答をお願いします");
			}
		}

//		if (!$this->checkBookedNum($bookingcontArray)){
//			parent::setError("BOOKING_NUMS", "ご指定のプランは販売を終了したか、予約受付時間を過ぎている可能性がございます。誠に恐れ入りますが、ほかのプランをご利用いただくか、別の日程をご指定ください。");
//		}
// 		parent::setError("BOOKING_CHECKIN", "ご指定のプランは販売を終了したか、予約受付時間を過ぎている可能性がございます。誠に恐れ入りますが、ほかのプランをご利用いただくか、別の日程をご指定ください。");
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ID"))) {
			parent::setErrorFirst("プランの取得に失敗しました");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_ID"))) {
			parent::setErrorFirst("料金情報の取得に失敗しました");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_ID"))) {
			parent::setErrorFirst("部屋タイプの取得に失敗しました");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_DATE"))) {
			parent::setError("BOOKING_DATE", "必須項目です");
		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_DATE_CANCEL_END"))) {
// 			parent::setError("BOOKING_DATE_CANCEL_END", "必須項目です");
// 		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_NUM_ROOM"))) {
			parent::setError("BOOKING_NUM_ROOM", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))) {
			parent::setError("MEMBER_ID", "必須項目です");
		}


		if (parent::getByKey(parent::getKeyValue(), "question_req") == 1) {
			parent::setError("BOOKING_ANSWER", "必須項目です");
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_HOW"))) {
			parent::setError("BOOKING_HOW", "必須項目です");
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

	public  function selectDuplication($id, $couponId) {
		$sql  = "select ";
		$sql .= "BOOKING_ID ";
		$sql .= "from ".hotelBooking::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 1)." and ";
	//	$sql .= parent::expsData("MEMBER_ID", "=", parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))." and ";
		$sql .= parent::expsData("COUPON_ID_NUM", "=", $couponId, true, 1)." ";
		if ($id != "") {
			$sql .= "and ".parent::expsData(hotelBooking::keyName, "<>", $id)." ";
		}
		parent::setCollection($sql, hotelBooking::keyName);
	}

	public function checkAllCoupon($bookingcontArray) {
		
		if (count($bookingcontArray) > 0) {
			foreach ($bookingcontArray as $k=>$d) {
				if ($d["BOOKINGCONT_NUM1"] + $d["BOOKINGCONT_NUM2"] != $d["adult_number"]) {
					parent::setErrorFirst($d["night_number"]."泊目".$d["BOOKINGCONT_ROOM"]."部屋の男性、女性の人数を確認して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"))) {
			parent::setError("BOOKING_CHECKIN", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))) {
			parent::setError("MEMBER_ID", "会員情報の取得に失敗しました");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_HOW"))) {
			parent::setError("BOOKING_HOW", "選択して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"))) {
			parent::setError("COUPON_ID_NUM", "クーポン番号を入力してください");
		}
		elseif (!preg_match("/[ -~]+/", parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"))) {
			parent::setError("COUPON_ID_NUM", "クーポン番号は全て半角英数字で入力してください");
		}
		else {	$couponDuplication = new hotelBooking($this->db);
			$couponDuplication->selectDuplication("",parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"));
			//print $couponDuplication->getCount();
			if ($couponDuplication->getCount() > 0) {
				parent::setError("COUPON_ID_NUM", "このクーポン番号はすでに利用されています。");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE"))) {
			parent::setError("COUPON_KEY_CODE", "キーコードを入力してください");
		}
		elseif (!preg_match("/[ -~]+/", parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE"))) {
			parent::setError("COUPON_KEY_CODE", "キーコードは全て半角英数字で入力してください");
		}
		else {	$couponIdKey = new couponBooking($this->db);
			$couponIdKey->selectIdKey(
				(parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM")),
				(parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE")),
				(parent::getByKey(parent::getKeyValue(), "MEMBER_ID")),
				(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")),
				(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ID")));
			//print $couponIdKey->getCount();
			if ($couponIdKey->getCount() <= 0) {
				parent::setError("COUPON_ID_NUM", "クーポン番号またはキーコードが有効でないか、このホテル・プランでご利用いただけないクーポンです。");
			}
		}


		if (parent::getByKey(parent::getKeyValue(), "question_req") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER"))) {
				parent::setError("BOOKING_ANSWER", "質問への回答をお願いします");
			}
		}
	}


	public function getLastNotificationID($company_id) {
		$sql  = "select count(*) as num from ".hotelBooking::tableName." ";
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
				$this->setByKey($this->getKeyValue(), "hotelBooking_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBooking_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelBooking_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelBooking_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelBooking_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBooking_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelBooking_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelBooking_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBooking_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelBooking_LIST_AREA"));
			}
			*/


		}

	}


}
?>