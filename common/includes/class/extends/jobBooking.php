<?php
//require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobBookingcont.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mMail.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/job.php');

///////////////////////
//	fax
//require_once(PATH_SLAKER_COMMON.'includes/class/sendfax.php');
///////////////////////

class jobBooking extends collection {
	const tableName = "JOBBOOKING";
	const keyName = "JOBBOOK_ID";
	const tableKeyName = "JOBBOOK_ID";
//	const mailRequestID = 12;
//	const mailCancelID = 5;
	const mailBooking = 35;
//	const mailBookingRequest = 6;
	
//	const mailRequestID2hotel = 20;
//	const mailCancelID2hotel = 21;
	const mailBooking2client = 36;
//	const mailBookingRequest2hotel = 18;

	private $bookingId;

	public function jobBooking($db) {
		parent::collection($db);
	}
	
	public function selectCompanyPayId($id){
		$sql  = "select  ";
		$sql .= parent::decryptionList(JOB_MAIL)." ";
		$sql .= "from JOB ";
	
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
					return $row['JOB_MAIL'];
				//	print $row['JOB_MAIL'];
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
		$sql .= " MAIL_DATE ";
		$sql .= "from ".jobBooking::tableName." ";
	
		$where = "";
	
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBooking::keyName, "=", $id)." ";
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
		$sql .= "from ".jobBooking::tableName." ";
		
		$where = "";
		
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBooking::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		parent::setCollection($sql, hotelPay::keyName);
	}
*/


	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "JOBBOOK_ID, COMPANY_ID, jb.JOBPLAN_ID, MAIL_DATE, SEX, JOBBOOK_BIRTH1, JOBBOOK_BIRTH1, JOBBOOK_BIRTH2, JOBBOOK_BIRTH3, JOBBOOK_AGE, ";
	//	$sql .= "JOBBOOK_GRADUATION_DATE1, JOBBOOK_GRADUATION_DATE2, JOBBOOK_TOEFUL, JOBBOOK_TOEIC, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("JOBBOOK_NAME".$i."").", ";
			$sql .= parent::decryptionList("JOBBOOK_KANA".$i."").", ";
		}
		$sql .= parent::decryptionList("MAIL_ADDRESS, JOBBOOK_PREF, JOBBOOK_CITY, JOBBOOK_ADD, JOBBOOK_BILD, JOBBOOK_TEL1, JOBBOOK_TEL2, JOB_NAME")." ";
		$sql .= "from ".jobBooking::tableName." jb ";
	//	$sql .= "left join JOB j on jb.COMPANY_ID = j.COMPANY_ID ";
	//	$sql .= "left join JOBPLAN jp on jp.JOBPLAN_ID = jb.JOBPLAN_ID ";
		//$sql .= "left join JOB_SHOP js on jb.JOBSHOP_ID = js.JOBSHOP_ID ";
		//$sql .= "left join TL_PLAN linkhp on hb.HOTELPLAN_ID = linkhp.TL_PLAN_CODE ";
		//$sql .= "left join TL_ROOM linkr on hb.ROOM_ID = linkr.TL_ROOM_TYPECODE ";
		//$sql .= "left join BOOKINGCONT bkc on hb.BOOKING_ID = bkc.BOOKING_ID and hb.COMPANY_ID=bkc.COMPANY_ID ";


		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "JOBBOOK_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBooking::keyName, "=", $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("jb.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("jb.JOBPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_ID", "=", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "JOBSHOP_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("JOBSHOP_ID", "=", $collection->getByKey($collection->getKeyValue(), "JOBSHOP_ID"))." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by JOBBOOK_ID desc  ";
//		print_r($collection);
//  		echo $sql;exit;

		parent::setCollection($sql, jobBooking::keyName);
	}

	public function selectBookedNum($collection) {
		$sql  = "select ";
		$sql .= "count(*) as num from ".jobBooking::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("JOBPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))." ";
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
		$sql .= "from ".jobBooking::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBooking::keyName, "=", $id)." ";
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

		parent::setCollection($sql, jobBooking::keyName);
	}

	public function selectCancelRoom($id,$companId){
		$sql = "select ";
		$sql.= "count(*) canceled from ".jobBookingcont::tableName;
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
		$sql.= " BOOKINGCONT_MONEY   from ".jobBookingcont::tableName;
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
		$sql .= "BOOKING_LINK, BOOKING_BOOKING_CODE, ";
		$sql .= parent::decryptionList("HOTELPLAN_NAME,ROOM_NAME,HOTELPLAN_CONTENTS,BOOKING_CHECKIN, BOOKING_DATE_CANCEL_END_TIME").", ";
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
		$sql .= parent::decryptionList("BOOKING_MAILADDRESS, BOOKING_ANSWER, BOOKING_DEMAND, BOOKING_REQUEST_ANSWER ,BOOKING_HOTELPLAN_CONTENTS").", ";
		$sql .= "BOOKING_STATUS, BOOKING_SERVICE, BOOKING_REQUEST, BOOKING_MONEY, BOOKING_HOW, BOOKING_POINT_USE, BOOKING_MONRY_CANCEL, hp.HOTELPLAN_ACC_DAY, hp.HOTELPLAN_ACC_HOUR, hp.HOTELPLAN_ACC_MIN, hp.HOTELPLAN_CAN_DAY, hp.HOTELPLAN_CAN_HOUR, hp.HOTELPLAN_CAN_MIN, ";
		$sql .= parent::decryptionList("BOOKING_MEMO").", ";
		$sql .= "BOOKING_DATE_START, BOOKING_DATE_BOOK, BOOKING_DATE_CANCEL, BOOKING_DATE_DELETE  ";
		$sql .= "from ".jobBooking::tableName." hb ";
		$sql .= "left join HOTELPLAN hp on hb.HOTELPLAN_ID = hp.HOTELPLAN_ID ";
		$sql .= "left join ROOM r on hb.ROOM_ID = r.ROOM_ID ";
		$sql .= "left join MEMBER mem on mem.MEMBER_ID = hb.MEMBER_ID ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBooking::keyName, "=", $id)." ";
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
		
		parent::setCollection($sql, jobBooking::keyName);
	}


	private function setBookinId($id) {
		$this->bookingId = $id;
	}
	public function getBookingId() {
		return $this->bookingId;
	}


	public function updateBooking($id, $bookingCode) {
			$this->db->begin();

			$sql .= "update ".jobBooking::tableName." set ";
			$sql .= parent::expsData("BOOKING_BOOKING_CODE", "=", $bookingCode, true).", ";
			$sql .= parent::expsData("BOOKING_DATE_BOOK", "=", "now()")." ";
			$sql .= "where ";
			$sql .=  parent::expsData(jobBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}

			$bookingcont = new jobBookingcont($this->db);
			if (!$bookingcont->updateBooking($id, $bookingCode)) {
				$this->db->rollback();
				return false;
			}

			$this->db->commit();
			return true;
	}
	
	public function updateBookingStatus($id, $bookingStatus) {
			$this->db->begin();

			$sql .= "update ".jobBooking::tableName." set ";
			$sql .= parent::expsData("BOOKING_STATUS", "=", $bookingStatus, true)." ";
			$sql .= "where ";
			$sql .=  parent::expsData(jobBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}

			$bookingcont = new jobBookingcont($this->db);
			if (!$bookingcont->updateBookingStatus($id, $bookingStatus)) {
				$this->db->rollback();
				return false;
			}

			$this->db->commit();
			return true;
	}


	public function saveBooking(){
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		$sql .= "update ".jobBooking::tableName." set ";
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
		$sql .=  parent::expsData(jobBooking::keyName, "=", parent::getKeyValue())." ";
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

	public function getPlanContentById($id){
		$jobPlan = new jobPlan($this->db);
		$jobPlan->getPlanContentById($id);
		return $jobPlan->getByKey($jobPlan->getKeyValue(), "JOBPLAN_CONTENTS");
	}

	public function save($bookingcontArray,$is_request=false) {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		//print_r($dataList);exit;
		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
//		print_r($dataList);exit;
//			$dataList['JOBBOOK_JOBPLAN_CONTENTS']=$this->getPlanContentById($dataList['JOBPLAN_ID']);
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
			$idData->lastInsert(jobBooking::tableName);
			$id = $idData->getByKey($idData->getKeyValue(), "id");
 			$bookingcontArray["JOBBOOK_ID"] = $id;
		}

		$this->setBookinId($id);

/*
		$bookingcont = new jobBookingcont($this->db);
		if (!$bookingcont->saveAll($bookingcontArray, $id)) {
			$this->db->rollback();
			return false;
		}
*/

		//リンカーン以外(ココトモのみ）
		
/*
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
*/				
			
			$mMail = new mMail($this->db);
			//To user
			
			
			$mailid = !$is_request?jobBooking::mailBooking:jobBooking::mailBookingRequest;
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
			$subject = cmReplace($subject, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));

			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["JOBBOOK_ID"]);
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!COMPANY_ID!]", parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$body = cmReplace($body, "[!JOBPLAN_ID!]", parent::getByKey(parent::getKeyValue(), "JOBPLAN_ID"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_NAME1")." ".parent::getByKey(parent::getKeyValue(), "JOBBOOK_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_KANA1")." ".parent::getByKey(parent::getKeyValue(), "JOBBOOK_KANA2"));
			$body = cmReplace($body, "[!SEX!]", parent::getByKey(parent::getKeyValue(), "SEX"));
			$body = cmReplace($body, "[!BIRTH!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH1")."年".parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH2")."月".parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH3")."日");
			$body = cmReplace($body, "[!AGE!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_AGE"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "MAIL_ADDRESS"));
			$body = cmReplace($body, "[!TEL1!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_TEL1"));
			$body = cmReplace($body, "[!TEL2!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_TEL2"));
			$body = cmReplace($body, "[!ADDRESS!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_CITY").parent::getByKey(parent::getKeyValue(), "JOBBOOK_ADD").parent::getByKey(parent::getKeyValue(), "JOBBOOK_BILD"));
			$body = cmReplace($body, "[!ACCESS!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_STATION")."駅から".parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_TOOL")."で".parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_TIME")."分");
			$body = cmReplace($body, "[!FAMILY!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_FAMILY"));
			$body = cmReplace($body, "[!EDUCATION!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_EDUCATION"));
			$body = cmReplace($body, "[!SCHOOL!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SCHOOL_NAME")." ".parent::getByKey(parent::getKeyValue(), "JOBBOOK_SCHOOL_CORSE"));
			$body = cmReplace($body, "[!GRADUATION!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_GRADUATION_DATE1")."年".parent::getByKey(parent::getKeyValue(), "JOBBOOK_GRADUATION_DATE2")."月");
			$body = cmReplace($body, "[!ENG_SCORE!]", "TOEIC：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_TOEIC")."点　TOEFL：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_TOEFL")."点　STEP(英語検定)：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_STEP")."級");
			$body = cmReplace($body, "[!ENG_LEVEL!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_E_LEVEL"));
			$body = cmReplace($body, "[!LANGUAGE!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_LANGUAGE"));
			$body = cmReplace($body, "[!OS!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_OS"));
			$body = cmReplace($body, "[!SOFT!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SOFT"));
			$body = cmReplace($body, "[!SOFT_HOTEL!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SOFT_HOTEL"));
			$body = cmReplace($body, "[!SOFT_ETC!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SOFT_ETC"));
			$body = cmReplace($body, "[!CAPACITY!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_CAPACITY"));
			$body = cmReplace($body, "[!WORK_START!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_START"));
			$body = cmReplace($body, "[!INCOME!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_INCOME"));
			$body = cmReplace($body, "[!SELF_PR!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SELF_PR"));
			$body = cmReplace($body, "[!MEMO!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_MEMO"));
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address"));
			$body = cmReplace($body, "[!PLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
			$body = cmReplace($body, "[!PLAN_WORKTIME!]", parent::getByKey(parent::getKeyValue(), "plan_worktime"));
			$body = cmReplace($body, "[!PLAN_HOLYDAY!]", parent::getByKey(parent::getKeyValue(), "plan_holyday"));
			$body = cmReplace($body, "[!PLAN_TREAT!]", parent::getByKey(parent::getKeyValue(), "plan_treat"));
			$body = cmReplace($body, "[!PLAN_CONDITION!]", parent::getByKey(parent::getKeyValue(), "plan_condition"));
			$body = cmReplace($body, "[!PLAN_KIND!]", parent::getByKey(parent::getKeyValue(), "plan_kind"));
			$body = cmReplace($body, "[!PLAN_MEMO!]", parent::getByKey(parent::getKeyValue(), "plan_memo"));
			$body = cmReplace($body, "[!PLAN_MONEY!]", parent::getByKey(parent::getKeyValue(), "plan_money"));
			$body = cmReplace($body, "[!PLAN_EMPLOY!]", parent::getByKey(parent::getKeyValue(), "plan_employ"));
			$body = cmReplace($body, "[!PLAN_COMPANY!]", parent::getByKey(parent::getKeyValue(), "plan_company"));
			$body = cmReplace($body, "[!PLAN_AREA!]", parent::getByKey(parent::getKeyValue(), "plan_area"));
			$body = cmReplace($body, "[!PLAN_CONTENTS!]", parent::getByKey(parent::getKeyValue(), "plan_contents"));

			$work1 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY1") != "") {
				$work1  = "-----------------------------------------------------------------------\n";
				$work1 .= "【職務経歴１】\n";
				$work1 .= "-----------------------------------------------------------------------\n";
				$work1 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY1")."\n";
				$work1 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME1")."\n";
				$work1 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY1")."\n";
				$work1 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD11")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD12")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD13")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD14")."月\n";
				$work1 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND1")."\n";
				$work1 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION1")."\n";
				$work1 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE1")."\n";
				$work1 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL1")."\n";
				$work1 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO1")."\n";
				$work1 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK1!]", $work1);

			$work2 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY2") != "") {
				$work2  = "-----------------------------------------------------------------------\n";
				$work2 .= "【職務経歴２】\n";
				$work2 .= "-----------------------------------------------------------------------\n";
				$work2 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY2")."\n";
				$work2 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME2")."\n";
				$work2 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY2")."\n";
				$work2 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD21")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD22")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD23")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD24")."月\n";
				$work2 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND2")."\n";
				$work2 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION2")."\n";
				$work2 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE2")."\n";
				$work2 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL2")."\n";
				$work2 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO2")."\n";
				$work2 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK2!]", $work2);

			$work3 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY3") != "") {
				$work3  = "-----------------------------------------------------------------------\n";
				$work3 .= "【職務経歴３】\n";
				$work3 .= "-----------------------------------------------------------------------\n";
				$work3 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY3")."\n";
				$work3 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME3")."\n";
				$work3 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY3")."\n";
				$work3 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD31")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD32")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD33")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD34")."月\n";
				$work3 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND3")."\n";
				$work3 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION3")."\n";
				$work3 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE3")."\n";
				$work3 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL3")."\n";
				$work3 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO3")."\n";
				$work3 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK3!]", $work3);

			$work4 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY4") != "") {
				$work4  = "-----------------------------------------------------------------------\n";
				$work4 .= "【職務経歴４】\n";
				$work4 .= "-----------------------------------------------------------------------\n";
				$work4 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY4")."\n";
				$work4 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME4")."\n";
				$work4 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY4")."\n";
				$work4 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD41")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD42")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD43")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD44")."月\n";
				$work4 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND4")."\n";
				$work4 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION4")."\n";
				$work4 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE4")."\n";
				$work4 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL4")."\n";
				$work4 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO4")."\n";
				$work4 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK4!]", $work4);

			$work5 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY5") != "") {
				$work5  = "-----------------------------------------------------------------------\n";
				$work5 .= "【職務経歴５】\n";
				$work5 .= "-----------------------------------------------------------------------\n";
				$work5 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY5")."\n";
				$work5 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME5")."\n";
				$work5 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY5")."\n";
				$work5 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD51")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD52")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD53")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD54")."月\n";
				$work5 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND5")."\n";
				$work5 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION5")."\n";
				$work5 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE5")."\n";
				$work5 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL5")."\n";
				$work5 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO5")."\n";
				$work5 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK5!]", $work5);

			$work6 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY6") != "") {
				$work6  = "-----------------------------------------------------------------------\n";
				$work6 .= "【職務経歴６】\n";
				$work6 .= "-----------------------------------------------------------------------\n";
				$work6 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY6")."\n";
				$work6 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME6")."\n";
				$work6 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY6")."\n";
				$work6 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD61")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD62")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD63")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD64")."月\n";
				$work6 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND6")."\n";
				$work6 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION6")."\n";
				$work6 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE6")."\n";
				$work6 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL6")."\n";
				$work6 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO6")."\n";
				$work6 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK6!]", $work6);

			$work7 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY7") != "") {
				$work7  = "-----------------------------------------------------------------------\n";
				$work7 .= "【職務経歴７】\n";
				$work7 .= "-----------------------------------------------------------------------\n";
				$work7 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY7")."\n";
				$work7 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME7")."\n";
				$work7 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY7")."\n";
				$work7 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD71")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD72")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD73")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD74")."月\n";
				$work7 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND7")."\n";
				$work7 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION7")."\n";
				$work7 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE7")."\n";
				$work7 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL7")."\n";
				$work7 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO7")."\n";
				$work7 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK7!]", $work7);

			$work8 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY8") != "") {
				$work8  = "-----------------------------------------------------------------------\n";
				$work8 .= "【職務経歴８】\n";
				$work8 .= "-----------------------------------------------------------------------\n";
				$work8 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY8")."\n";
				$work8 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME8")."\n";
				$work8 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY8")."\n";
				$work8 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD81")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD82")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD83")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD84")."月\n";
				$work8 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND8")."\n";
				$work8 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION8")."\n";
				$work8 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE8")."\n";
				$work8 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL8")."\n";
				$work8 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO8")."\n";
				$work8 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK8!]", $work8);

			$work9 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY9") != "") {
				$work9  = "-----------------------------------------------------------------------\n";
				$work9 .= "【職務経歴９】\n";
				$work9 .= "-----------------------------------------------------------------------\n";
				$work9 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY9")."\n";
				$work9 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME9")."\n";
				$work9 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY9")."\n";
				$work9 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD91")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD92")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD93")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD94")."月\n";
				$work9 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND9")."\n";
				$work9 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION9")."\n";
				$work9 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE9")."\n";
				$work9 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL9")."\n";
				$work9 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO9")."\n";
				$work9 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK9!]", $work9);

			$work10 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY10") != "") {
				$work10  = "-----------------------------------------------------------------------\n";
				$work10 .= "【職務経歴１０】\n";
				$work10 .= "-----------------------------------------------------------------------\n";
				$work10 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY10")."\n";
				$work10 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME10")."\n";
				$work10 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY10")."\n";
				$work10 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD101")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD102")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD103")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD104")."月\n";
				$work10 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND10")."\n";
				$work10 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION10")."\n";
				$work10 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE10")."\n";
				$work10 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL10")."\n";
				$work10 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO10")."\n";
				$work10 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK10!]", $work10);



			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("予約メールの送信に失敗しました。");
				parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
				$this->db->rollback();
				return false;
			}
			
			//To client
			$mailid = !$is_request?jobBooking::mailBooking2client:jobBooking::mailBookingRequest2hotel;
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
			$subject = cmReplace($subject, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$subject = cmReplace($subject, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");
			
			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["JOBBOOK_ID"]);
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!COMPANY_ID!]", parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$body = cmReplace($body, "[!JOBPLAN_ID!]", parent::getByKey(parent::getKeyValue(), "JOBPLAN_ID"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y年m月d日"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_NAME1")." ".parent::getByKey(parent::getKeyValue(), "JOBBOOK_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_KANA1")." ".parent::getByKey(parent::getKeyValue(), "JOBBOOK_KANA2"));
			$body = cmReplace($body, "[!SEX!]", parent::getByKey(parent::getKeyValue(), "SEX"));
			$body = cmReplace($body, "[!BIRTH!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH1")."年".parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH2")."月".parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH3")."日");
			$body = cmReplace($body, "[!AGE!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_AGE"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "MAIL_ADDRESS"));
			$body = cmReplace($body, "[!TEL1!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_TEL1"));
			$body = cmReplace($body, "[!TEL2!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_TEL2"));
			$body = cmReplace($body, "[!ADDRESS!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_CITY").parent::getByKey(parent::getKeyValue(), "JOBBOOK_ADD").parent::getByKey(parent::getKeyValue(), "JOBBOOK_BILD"));
			$body = cmReplace($body, "[!ACCESS!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_STATION")."駅から".parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_TOOL")."で".parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_TIME")."分");
			$body = cmReplace($body, "[!FAMILY!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_FAMILY"));
			$body = cmReplace($body, "[!EDUCATION!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_EDUCATION"));
			$body = cmReplace($body, "[!SCHOOL!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SCHOOL_NAME")." ".parent::getByKey(parent::getKeyValue(), "JOBBOOK_SCHOOL_CORSE"));
			$body = cmReplace($body, "[!GRADUATION!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_GRADUATION_DATE1")."年".parent::getByKey(parent::getKeyValue(), "JOBBOOK_GRADUATION_DATE2")."月");
			$body = cmReplace($body, "[!ENG_SCORE!]", "TOEIC：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_TOEIC")."点　TOEFL：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_TOEFL")."点　STEP(英語検定)：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_STEP")."級");
			$body = cmReplace($body, "[!ENG_LEVEL!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_E_LEVEL"));
			$body = cmReplace($body, "[!LANGUAGE!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_LANGUAGE"));
			$body = cmReplace($body, "[!OS!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_OS"));
			$body = cmReplace($body, "[!SOFT!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SOFT"));
			$body = cmReplace($body, "[!SOFT_HOTEL!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SOFT_HOTEL"));
			$body = cmReplace($body, "[!SOFT_ETC!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SOFT_ETC"));
			$body = cmReplace($body, "[!CAPACITY!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_CAPACITY"));
			$body = cmReplace($body, "[!WORK_START!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_START"));
			$body = cmReplace($body, "[!INCOME!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_INCOME"));
			$body = cmReplace($body, "[!SELF_PR!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_SELF_PR"));
			$body = cmReplace($body, "[!MEMO!]", parent::getByKey(parent::getKeyValue(), "JOBBOOK_MEMO"));
			$body = cmReplace($body, "[!HOTEL_NAME!]", parent::getByKey(parent::getKeyValue(), "hotel_name"));
			$body = cmReplace($body, "[!HOTEL_TEL!]", parent::getByKey(parent::getKeyValue(), "hotel_tel"));
			$body = cmReplace($body, "[!HOTEL_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "hotel_address"));
			$body = cmReplace($body, "[!PLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
			$body = cmReplace($body, "[!PLAN_WORKTIME!]", parent::getByKey(parent::getKeyValue(), "plan_worktime"));
			$body = cmReplace($body, "[!PLAN_HOLYDAY!]", parent::getByKey(parent::getKeyValue(), "plan_holyday"));
			$body = cmReplace($body, "[!PLAN_TREAT!]", parent::getByKey(parent::getKeyValue(), "plan_treat"));
			$body = cmReplace($body, "[!PLAN_CONDITION!]", parent::getByKey(parent::getKeyValue(), "plan_condition"));
			$body = cmReplace($body, "[!PLAN_KIND!]", parent::getByKey(parent::getKeyValue(), "plan_kind"));
			$body = cmReplace($body, "[!PLAN_MEMO!]", parent::getByKey(parent::getKeyValue(), "plan_memo"));
			$body = cmReplace($body, "[!PLAN_MONEY!]", parent::getByKey(parent::getKeyValue(), "plan_money"));
			$body = cmReplace($body, "[!PLAN_EMPLOY!]", parent::getByKey(parent::getKeyValue(), "plan_employ"));
			$body = cmReplace($body, "[!PLAN_COMPANY!]", parent::getByKey(parent::getKeyValue(), "plan_company"));
			$body = cmReplace($body, "[!PLAN_AREA!]", parent::getByKey(parent::getKeyValue(), "plan_area"));
			$body = cmReplace($body, "[!PLAN_CONTENTS!]", parent::getByKey(parent::getKeyValue(), "plan_contents"));

			$work1 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY1") != "") {
				$work1  = "-----------------------------------------------------------------------\n";
				$work1 .= "【職務経歴１】\n";
				$work1 .= "-----------------------------------------------------------------------\n";
				$work1 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY1")."\n";
				$work1 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME1")."\n";
				$work1 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY1")."\n";
				$work1 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD11")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD12")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD13")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD14")."月\n";
				$work1 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND1")."\n";
				$work1 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION1")."\n";
				$work1 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE1")."\n";
				$work1 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL1")."\n";
				$work1 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO1")."\n";
				$work1 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK1!]", $work1);

			$work2 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY2") != "") {
				$work2  = "-----------------------------------------------------------------------\n";
				$work2 .= "【職務経歴２】\n";
				$work2 .= "-----------------------------------------------------------------------\n";
				$work2 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY2")."\n";
				$work2 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME2")."\n";
				$work2 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY2")."\n";
				$work2 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD21")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD22")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD23")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD24")."月\n";
				$work2 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND2")."\n";
				$work2 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION2")."\n";
				$work2 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE2")."\n";
				$work2 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL2")."\n";
				$work2 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO2")."\n";
				$work2 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK2!]", $work2);

			$work3 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY3") != "") {
				$work3  = "-----------------------------------------------------------------------\n";
				$work3 .= "【職務経歴３】\n";
				$work3 .= "-----------------------------------------------------------------------\n";
				$work3 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY3")."\n";
				$work3 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME3")."\n";
				$work3 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY3")."\n";
				$work3 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD31")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD32")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD33")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD34")."月\n";
				$work3 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND3")."\n";
				$work3 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION3")."\n";
				$work3 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE3")."\n";
				$work3 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL3")."\n";
				$work3 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO3")."\n";
				$work3 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK3!]", $work3);

			$work4 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY4") != "") {
				$work4  = "-----------------------------------------------------------------------\n";
				$work4 .= "【職務経歴４】\n";
				$work4 .= "-----------------------------------------------------------------------\n";
				$work4 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY4")."\n";
				$work4 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME4")."\n";
				$work4 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY4")."\n";
				$work4 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD41")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD42")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD43")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD44")."月\n";
				$work4 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND4")."\n";
				$work4 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION4")."\n";
				$work4 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE4")."\n";
				$work4 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL4")."\n";
				$work4 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO4")."\n";
				$work4 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK4!]", $work4);

			$work5 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY5") != "") {
				$work5  = "-----------------------------------------------------------------------\n";
				$work5 .= "【職務経歴５】\n";
				$work5 .= "-----------------------------------------------------------------------\n";
				$work5 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY5")."\n";
				$work5 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME5")."\n";
				$work5 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY5")."\n";
				$work5 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD51")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD52")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD53")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD54")."月\n";
				$work5 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND5")."\n";
				$work5 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION5")."\n";
				$work5 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE5")."\n";
				$work5 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL5")."\n";
				$work5 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO5")."\n";
				$work5 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK5!]", $work5);

			$work6 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY6") != "") {
				$work6  = "-----------------------------------------------------------------------\n";
				$work6 .= "【職務経歴６】\n";
				$work6 .= "-----------------------------------------------------------------------\n";
				$work6 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY6")."\n";
				$work6 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME6")."\n";
				$work6 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY6")."\n";
				$work6 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD61")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD62")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD63")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD64")."月\n";
				$work6 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND6")."\n";
				$work6 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION6")."\n";
				$work6 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE6")."\n";
				$work6 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL6")."\n";
				$work6 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO6")."\n";
				$work6 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK6!]", $work6);

			$work7 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY7") != "") {
				$work7  = "-----------------------------------------------------------------------\n";
				$work7 .= "【職務経歴７】\n";
				$work7 .= "-----------------------------------------------------------------------\n";
				$work7 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY7")."\n";
				$work7 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME7")."\n";
				$work7 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY7")."\n";
				$work7 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD71")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD72")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD73")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD74")."月\n";
				$work7 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND7")."\n";
				$work7 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION7")."\n";
				$work7 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE7")."\n";
				$work7 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL7")."\n";
				$work7 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO7")."\n";
				$work7 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK7!]", $work7);

			$work8 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY8") != "") {
				$work8  = "-----------------------------------------------------------------------\n";
				$work8 .= "【職務経歴８】\n";
				$work8 .= "-----------------------------------------------------------------------\n";
				$work8 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY8")."\n";
				$work8 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME8")."\n";
				$work8 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY8")."\n";
				$work8 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD81")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD82")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD83")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD84")."月\n";
				$work8 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND8")."\n";
				$work8 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION8")."\n";
				$work8 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE8")."\n";
				$work8 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL8")."\n";
				$work8 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO8")."\n";
				$work8 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK8!]", $work8);

			$work9 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY9") != "") {
				$work9  = "-----------------------------------------------------------------------\n";
				$work9 .= "【職務経歴９】\n";
				$work9 .= "-----------------------------------------------------------------------\n";
				$work9 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY9")."\n";
				$work9 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME9")."\n";
				$work9 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY9")."\n";
				$work9 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD91")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD92")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD93")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD94")."月\n";
				$work9 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND9")."\n";
				$work9 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION9")."\n";
				$work9 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE9")."\n";
				$work9 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL9")."\n";
				$work9 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO9")."\n";
				$work9 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK9!]", $work9);

			$work10 = "";
			if (parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY10") != "") {
				$work10  = "-----------------------------------------------------------------------\n";
				$work10 .= "【職務経歴１０】\n";
				$work10 .= "-----------------------------------------------------------------------\n";
				$work10 .= "企業名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_COMPANY10")."\n";
				$work10 .= "施設名：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME10")."\n";
				$work10 .= "業種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_COMPANY10")."\n";
				$work10 .= "在職期間：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD101")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD102")."月～".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD103")."年"
					.parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_PERIOD104")."月\n";
				$work10 .= "職種：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_KIND10")."\n";
				$work10 .= "役職：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_POSITION10")."\n";
				$work10 .= "雇用形態：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_TYPE10")."\n";
				$work10 .= "職務・業務内容：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_DETAIL10")."\n";
				$work10 .= "備考：".parent::getByKey(parent::getKeyValue(), "JOBBOOK_WORK_MEMO10")."\n";
				$work10 .= "-----------------------------------------------------------------------\n";
			}
			$body = cmReplace($body, "[!WORK10!]", $work10);

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
		return $bookingcontArray["JOBBOOK_ID"];

	}


	public function insert($dataList) {
//		print_r($dataList);exit;
		$sql  = "insert into ".jobBooking::tableName." (";
		$sql .= "JOBBOOK_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "JOBPLAN_ID, ";
		$sql .= "JOB_NAME, ";
		$sql .= "MEMBER_ID, ";
		$sql .= "JOBBOOK_NAME1, ";
		$sql .= "JOBBOOK_NAME2, ";
		$sql .= "JOBBOOK_KANA1, ";
		$sql .= "JOBBOOK_KANA2, ";
		$sql .= "SEX, ";
		$sql .= "JOBBOOK_BIRTH1, ";
		$sql .= "JOBBOOK_BIRTH2, ";
		$sql .= "JOBBOOK_BIRTH3, ";
		$sql .= "JOBBOOK_AGE, ";
		$sql .= "MAIL_ADDRESS, ";
		$sql .= "JOBBOOK_PREF, ";
		$sql .= "JOBBOOK_CITY, ";
		$sql .= "JOBBOOK_ADD, ";
		$sql .= "JOBBOOK_BILD, ";
		$sql .= "JOBBOOK_ACCESS_STATION, ";
		$sql .= "JOBBOOK_ACCESS_TOOL, ";
		$sql .= "JOBBOOK_ACCESS_TIME, ";
		$sql .= "JOBBOOK_TEL1, ";
		$sql .= "JOBBOOK_TEL2, ";
		$sql .= "JOBBOOK_FAMILY, ";
		$sql .= "JOBBOOK_EDUCATION, ";
		$sql .= "JOBBOOK_SCHOOL_NAME, ";
		$sql .= "JOBBOOK_SCHOOL_CORSE, ";
		$sql .= "JOBBOOK_GRADUATION_DATE1, ";
		$sql .= "JOBBOOK_GRADUATION_DATE2, ";
		$sql .= "JOBBOOK_SCHOOL_ETC, ";
		$sql .= "JOBBOOK_TOEIC, ";
		$sql .= "JOBBOOK_TOEFL, ";
		$sql .= "JOBBOOK_STEP, ";
		$sql .= "JOBBOOK_E_LEVEL, ";
		$sql .= "JOBBOOK_LANGUAGE, ";
		$sql .= "JOBBOOK_OS, ";
		$sql .= "JOBBOOK_SOFT, ";
		$sql .= "JOBBOOK_SOFT_HOTEL, ";
		$sql .= "JOBBOOK_SOFT_ETC, ";
		$sql .= "JOBBOOK_CAPACITY, ";
		$sql .= "JOBBOOK_WORK_START, ";
		$sql .= "JOBBOOK_INCOME, ";
		$sql .= "JOBBOOK_SELF_PR, ";
		$sql .= "JOBBOOK_MEMO, ";

		$sql .= "JOBBOOK_COMPANY1, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME1, ";
		$sql .= "JOBBOOK_WORK_COMPANY1, ";
		$sql .= "JOBBOOK_WORK_PERIOD11, ";
		$sql .= "JOBBOOK_WORK_PERIOD12, ";
		$sql .= "JOBBOOK_WORK_PERIOD13, ";
		$sql .= "JOBBOOK_WORK_PERIOD14, ";
		$sql .= "JOBBOOK_WORK_KIND1, ";
		$sql .= "JOBBOOK_WORK_POSITION1, ";
		$sql .= "JOBBOOK_WORK_TYPE1, ";
		$sql .= "JOBBOOK_WORK_DETAIL1, ";
		$sql .= "JOBBOOK_WORK_MEMO1, ";

		$sql .= "JOBBOOK_COMPANY2, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME2, ";
		$sql .= "JOBBOOK_WORK_COMPANY2, ";
		$sql .= "JOBBOOK_WORK_PERIOD21, ";
		$sql .= "JOBBOOK_WORK_PERIOD22, ";
		$sql .= "JOBBOOK_WORK_PERIOD23, ";
		$sql .= "JOBBOOK_WORK_PERIOD24, ";
		$sql .= "JOBBOOK_WORK_KIND2, ";
		$sql .= "JOBBOOK_WORK_POSITION2, ";
		$sql .= "JOBBOOK_WORK_TYPE2, ";
		$sql .= "JOBBOOK_WORK_DETAIL2, ";
		$sql .= "JOBBOOK_WORK_MEMO2, ";

		$sql .= "JOBBOOK_COMPANY3, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME3, ";
		$sql .= "JOBBOOK_WORK_COMPANY3, ";
		$sql .= "JOBBOOK_WORK_PERIOD31, ";
		$sql .= "JOBBOOK_WORK_PERIOD32, ";
		$sql .= "JOBBOOK_WORK_PERIOD33, ";
		$sql .= "JOBBOOK_WORK_PERIOD34, ";
		$sql .= "JOBBOOK_WORK_KIND3, ";
		$sql .= "JOBBOOK_WORK_POSITION3, ";
		$sql .= "JOBBOOK_WORK_TYPE3, ";
		$sql .= "JOBBOOK_WORK_DETAIL3, ";
		$sql .= "JOBBOOK_WORK_MEMO3, ";

		$sql .= "JOBBOOK_COMPANY4, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME4, ";
		$sql .= "JOBBOOK_WORK_COMPANY4, ";
		$sql .= "JOBBOOK_WORK_PERIOD41, ";
		$sql .= "JOBBOOK_WORK_PERIOD42, ";
		$sql .= "JOBBOOK_WORK_PERIOD43, ";
		$sql .= "JOBBOOK_WORK_PERIOD44, ";
		$sql .= "JOBBOOK_WORK_KIND4, ";
		$sql .= "JOBBOOK_WORK_POSITION4, ";
		$sql .= "JOBBOOK_WORK_TYPE4, ";
		$sql .= "JOBBOOK_WORK_DETAIL4, ";
		$sql .= "JOBBOOK_WORK_MEMO4, ";

		$sql .= "JOBBOOK_COMPANY5, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME5, ";
		$sql .= "JOBBOOK_WORK_COMPANY5, ";
		$sql .= "JOBBOOK_WORK_PERIOD51, ";
		$sql .= "JOBBOOK_WORK_PERIOD52, ";
		$sql .= "JOBBOOK_WORK_PERIOD53, ";
		$sql .= "JOBBOOK_WORK_PERIOD54, ";
		$sql .= "JOBBOOK_WORK_KIND5, ";
		$sql .= "JOBBOOK_WORK_POSITION5, ";
		$sql .= "JOBBOOK_WORK_TYPE5, ";
		$sql .= "JOBBOOK_WORK_DETAIL5, ";
		$sql .= "JOBBOOK_WORK_MEMO5, ";

		$sql .= "JOBBOOK_COMPANY6, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME6, ";
		$sql .= "JOBBOOK_WORK_COMPANY6, ";
		$sql .= "JOBBOOK_WORK_PERIOD61, ";
		$sql .= "JOBBOOK_WORK_PERIOD62, ";
		$sql .= "JOBBOOK_WORK_PERIOD63, ";
		$sql .= "JOBBOOK_WORK_PERIOD64, ";
		$sql .= "JOBBOOK_WORK_KIND6, ";
		$sql .= "JOBBOOK_WORK_POSITION6, ";
		$sql .= "JOBBOOK_WORK_TYPE6, ";
		$sql .= "JOBBOOK_WORK_DETAIL6, ";
		$sql .= "JOBBOOK_WORK_MEMO6, ";

		$sql .= "JOBBOOK_COMPANY7, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME7, ";
		$sql .= "JOBBOOK_WORK_COMPANY7, ";
		$sql .= "JOBBOOK_WORK_PERIOD71, ";
		$sql .= "JOBBOOK_WORK_PERIOD72, ";
		$sql .= "JOBBOOK_WORK_PERIOD73, ";
		$sql .= "JOBBOOK_WORK_PERIOD74, ";
		$sql .= "JOBBOOK_WORK_KIND7, ";
		$sql .= "JOBBOOK_WORK_POSITION7, ";
		$sql .= "JOBBOOK_WORK_TYPE7, ";
		$sql .= "JOBBOOK_WORK_DETAIL7, ";
		$sql .= "JOBBOOK_WORK_MEMO7, ";

		$sql .= "JOBBOOK_COMPANY8, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME8, ";
		$sql .= "JOBBOOK_WORK_COMPANY8, ";
		$sql .= "JOBBOOK_WORK_PERIOD81, ";
		$sql .= "JOBBOOK_WORK_PERIOD82, ";
		$sql .= "JOBBOOK_WORK_PERIOD83, ";
		$sql .= "JOBBOOK_WORK_PERIOD84, ";
		$sql .= "JOBBOOK_WORK_KIND8, ";
		$sql .= "JOBBOOK_WORK_POSITION8, ";
		$sql .= "JOBBOOK_WORK_TYPE8, ";
		$sql .= "JOBBOOK_WORK_DETAIL8, ";
		$sql .= "JOBBOOK_WORK_MEMO8, ";

		$sql .= "JOBBOOK_COMPANY9, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME9, ";
		$sql .= "JOBBOOK_WORK_COMPANY9, ";
		$sql .= "JOBBOOK_WORK_PERIOD91, ";
		$sql .= "JOBBOOK_WORK_PERIOD92, ";
		$sql .= "JOBBOOK_WORK_PERIOD93, ";
		$sql .= "JOBBOOK_WORK_PERIOD94, ";
		$sql .= "JOBBOOK_WORK_KIND9, ";
		$sql .= "JOBBOOK_WORK_POSITION9, ";
		$sql .= "JOBBOOK_WORK_TYPE9, ";
		$sql .= "JOBBOOK_WORK_DETAIL9, ";
		$sql .= "JOBBOOK_WORK_MEMO9, ";

		$sql .= "JOBBOOK_COMPANY10, ";
		$sql .= "JOBBOOK_WORK_COMPANY_NAME10, ";
		$sql .= "JOBBOOK_WORK_COMPANY10, ";
		$sql .= "JOBBOOK_WORK_PERIOD101, ";
		$sql .= "JOBBOOK_WORK_PERIOD102, ";
		$sql .= "JOBBOOK_WORK_PERIOD103, ";
		$sql .= "JOBBOOK_WORK_PERIOD104, ";
		$sql .= "JOBBOOK_WORK_KIND10, ";
		$sql .= "JOBBOOK_WORK_POSITION10, ";
		$sql .= "JOBBOOK_WORK_TYPE10, ";
		$sql .= "JOBBOOK_WORK_DETAIL10, ";
		$sql .= "JOBBOOK_WORK_MEMO10, ";

//		$sql .= "JOBBOOK_JOBPLAN_CONTENTS, ";
		$sql .= "MAIL_DATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["JOBPLAN_ID"]).", ";
		$sql .= parent::expsVal($dataList["JOB_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_ID"]).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_NAME1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_NAME2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_KANA1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_KANA2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SEX"]).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_BIRTH1"]).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_BIRTH2"]).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_BIRTH3"]).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_AGE"]).", ";
		$sql .= parent::expsVal($dataList["MAIL_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_PREF"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_ADD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_BILD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_ACCESS_STATION"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_ACCESS_TOOL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_ACCESS_TIME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_TEL1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_TEL2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_FAMILY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_EDUCATION"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_SCHOOL_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_SCHOOL_CORSE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_GRADUATION_DATE1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_GRADUATION_DATE2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_SCHOOL_ETC"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_TOEIC"]).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_TOEFL"]).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_STEP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_E_LEVEL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_LANGUAGE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_OS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_SOFT"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_SOFT_HOTEL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_SOFT_ETC"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_CAPACITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_START"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_INCOME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_SELF_PR"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_MEMO"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD11"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD12"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD13"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD14"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO1"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD21"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD22"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD23"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD24"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO2"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD31"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD32"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD33"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD34"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO3"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY4"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME4"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY4"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD41"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD42"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD43"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD44"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND4"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION4"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE4"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL4"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO4"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY5"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME5"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY5"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD51"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD52"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD53"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD54"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND5"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION5"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE5"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL5"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO5"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY6"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME6"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY6"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD61"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD62"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD63"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD64"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND6"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION6"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE6"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL6"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO6"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY7"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME7"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY7"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD71"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD72"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD73"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD74"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND7"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION7"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE7"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL7"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO7"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY8"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME8"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY8"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD81"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD82"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD83"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD84"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND8"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION8"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE8"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL8"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO8"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY9"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME9"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY9"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD91"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD92"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD93"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD94"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND9"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION9"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE9"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL9"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO9"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOBBOOK_COMPANY10"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY_NAME10"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_COMPANY10"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD101"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD102"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD103"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_PERIOD104"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_KIND10"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_POSITION10"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_TYPE10"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_DETAIL10"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBBOOK_WORK_MEMO10"], true, 1).", ";

//		$sql .= parent::expsVal($dataList["JOBBOOK_JOBPLAN_CONTENTS"], true, 1).", ";
		$sql .= "now()) ";
//		print_r($dataList);exit;

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".jobBooking::tableName." set ";
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
		$sql .= parent::expsData("BOOKING_DATE_BOOK", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobBooking::keyName, "=", $this->getKeyValue())." ";

		return $sql;
	}

	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".jobBooking::tableName." set ";
// 		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(jobBooking::keyName, "=", parent::getKeyValue())." ";

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
// 				parent::getByKey(parent::getKeyValue(), 'BOOKING_STATUS')==5?$this->mails(jobBooking::mailRequestID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))):$this->mails(jobBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));
// 				$this->mails(jobBooking::mailCancelID);
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
//		print_r($dataList);exit; 
		
		$sql .= "update ".jobBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobBooking::keyName, "=", parent::getKeyValue())." ";

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
		
		
		//parent::getByKey(parent::getKeyValue(), 'BOOKING_STATUS')==5?$this->mails(jobBooking::mailRequestID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))):$this->mails(jobBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));
		$this->mails(jobBooking::mailCancelID,'',false);
		
		$this->mails(jobBooking::mailCancelID2hotel,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")),true);
		
		return true;
	}
	
	public function noshow() {
		$sql .= "update ".jobBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 3).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			return false;
		}

		return true;
	}
	
	public function checkBookedNum($bookingcontArray){
		$sql  = "select ";
		$sql .= "count(*) as num from ".jobBooking::tableName." ";
		
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
		}

/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_NAME1"))) {
			parent::setError("JOBBOOK_NAME1", "姓は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_NAME2"))) {
			parent::setError("JOBBOOK_NAME2", "名は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_KANA1"))) {
			parent::setError("JOBBOOK_KANA1", "セイは必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_KANA2"))) {
			parent::setError("JOBBOOK_KANA2", "メイは必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SEX"))) {
			parent::setError("SEX", "性別は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH1"))) {
			parent::setError("JOBBOOK_BIRTH1", "生年月日は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH2"))) {
			parent::setError("JOBBOOK_BIRTH2", "生年月日は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_BIRTH3"))) {
			parent::setError("JOBBOOK_BIRTH3", "生年月日は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_AGE"))) {
			parent::setError("JOBBOOK_AGE", "年齢は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MAIL_ADDRESS"))) {
			parent::setError("MAIL_ADDRESS", "メールアドレスは必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_PREF"))) {
			parent::setError("JOBBOOK_PREF", "住所は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_CITY"))) {
			parent::setError("JOBBOOK_CITY", "住所は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_ADD"))) {
			parent::setError("JOBBOOK_ADD", "住所は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_STATION"))) {
			parent::setError("JOBBOOK_ACCESS_STATION", "最寄り駅は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_TOOL"))) {
			parent::setError("JOBBOOK_ACCESS_TOOL", "最寄り駅は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_ACCESS_TIME"))) {
			parent::setError("JOBBOOK_ACCESS_TIME", "最寄り駅は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_TEL1"))) {
			parent::setError("JOBBOOK_TEL1", "電話番号は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_FAMILY"))) {
			parent::setError("JOBBOOK_FAMILY", "家族構成は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_EDUCATION"))) {
			parent::setError("JOBBOOK_EDUCATION", "最終学歴は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_SCHOOL_NAME"))) {
			parent::setError("JOBBOOK_SCHOOL_NAME", "卒業校名は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_SCHOOL_CORSE"))) {
			parent::setError("JOBBOOK_SCHOOL_CORSE", "卒業学部・学科名は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_GRADUATION_DATE1"))) {
			parent::setError("JOBBOOK_GRADUATION_DATE1", "卒業年月は必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBBOOK_GRADUATION_DATE2"))) {
			parent::setError("JOBBOOK_GRADUATION_DATE2", "卒業年月は必須項目です");
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOBPLAN_ID"))) {
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
		$sql  = "select count(*) as num from ".jobBooking::tableName." ";
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
				$this->setByKey($this->getKeyValue(), "jobBooking_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "jobBooking_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "jobBooking_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "jobBooking_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "jobBooking_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "jobBooking_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "jobBooking_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "jobBooking_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "jobBooking_LIST_AREA", $this->getByKey($this->getKeyValue(), "jobBooking_LIST_AREA"));
			}
			*/


		}

	}


}
?>