<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookingcont.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopPlan.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mMail.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shopBookset.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelProvide.php');

///////////////////////
//	fax
require_once(PATH_SLAKER_COMMON.'includes/class/sendfax.php');
///////////////////////

class shopBooking extends collection {
	const tableName = "BOOKING2";
	const keyName = "BOOKING_ID";
	const tableKeyName = "BOOKING_ID";
	const mailRequestID = 12;
	const mailCancelID = 5;
	const mailBooking = 3;
	const mailBookingRequest = 6;
	
	const mailRequestID2shop = 20;
	const mailCancelID2shop = 21;
	const mailBooking2shop = 14;
	const mailBookingRequest2shop = 18;

	const mailRequestIDcoupon = 30;
	const mailBookingcoupon = 32;
	const mailBookingRequestcoupon = 29;
	
	const mailRequestID2coupon = 35;
	const mailBooking2coupon = 31;
	const mailBookingRequest2coupon = 28;

	private $bookingId;

	public function shopBooking($db) {
		parent::collection($db);
	}
	
	public function selectCompanyPayId($id){
		$sql  = "select  ";
		$sql .= parent::decryptionList(BOOKSET_BOOKING_MAILADDRESS).", ";
		$sql .= parent::decryptionList(BOOKSET_BOOKING_MAILADDRESS2).", ";
		$sql .= parent::decryptionList(BOOKSET_BOOKING_MAILADDRESS3);
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
	//print $sql;
		$result = $this->db->execute($sql);

		if (mysql_affected_rows() > 0) {
			//	count set
			while ($row = mysql_fetch_assoc($result)) {
				if($row['BOOKSET_BOOKING_MAILADDRESS3'] != ""){
					return $row['BOOKSET_BOOKING_MAILADDRESS'].",".$row['BOOKSET_BOOKING_MAILADDRESS2'].",".$row['BOOKSET_BOOKING_MAILADDRESS3'];
				}
				elseif($row['BOOKSET_BOOKING_MAILADDRESS2'] != ""){
					return $row['BOOKSET_BOOKING_MAILADDRESS'].",".$row['BOOKSET_BOOKING_MAILADDRESS2'];
				}
				else {
					return $row['BOOKSET_BOOKING_MAILADDRESS'];
				}
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
		$sql .= "from ".shopBooking::tableName." ";
	
		$where = "";
	
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopBooking::keyName, "=", $id)." ";
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
		$sql .= "from ".shopBooking::tableName." ";
		
		$where = "";
		
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopBooking::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		parent::setCollection($sql, hotelPay::keyName);
	}


	//?????????????????????
	public function createBookingCode($company_id="") {
		
		// ????????????????????????????????????1????????????
		$rand_str = substr(str_shuffle('ABCDEFGHIJKLMNPQRSTUVWXYZ'), 0, 1);
		
		$book_code .= $rand_str;
		$book_code .= $company_id;
		$book_code .= getmypid();

		return $book_code;
	}



	//?????????????????????
	public function createRandKey($n = 8) {
	/**	$str = array_merge(range('A', 'Z'));
		for ($i = 0; $i < $length; $i++) {
			$rand_key .= $str[rand(0, count($str)-1)];
		}
		return $rand_key;
*/
	    return substr(base_convert(bin2hex(openssl_random_pseudo_bytes($n)), 16, 36), 0, $n);
	}


	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "BOOKING_ID, sb.COMPANY_ID, sb.SHOPPLAN_ID, sb.SHOP_PRICETYPE_ID, sb.SHOP_PRICETYPE_KIND, HOTELPAY_ID, sb.ROOM_ID, BOOKING_HOW, BOOKING_SHOP_STATUS, ";
		$sql .= parent::decryptionList("BOOKING_CODE, BOOKING_KEY_CODE").", ";
		$sql .= "BOOKING_DATE, sp.SHOPPLAN_NAME, ";
		$sql .= parent::decryptionList("BOOKING_MEET_TIME").", ";
		$sql .= "BOOKING_MEET_PLACE, sa.SHOP_ACCESS_NAME, sa.SHOP_ACCESS_ADDRESS, ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKING_MONEYKIND".$i."".", ";
			$sql .= "BOOKING_PRICEPERSON".$i."".", ";
			$sql .= "BOOKING_MONEY".$i."".", ";
		}
		for ($i=1; $i<=8; $i++) {
			$sql .= parent::decryptionList("BOOKING_PRICETYPE".$i."").", ";
		}
		$sql .= "BOOKING_ALL_MONEY, BOOKING_DATE_CANCEL_END, ";
		$sql .= parent::decryptionList("BOOKING_DATE_CANCEL_END_TIME").", ";
		$sql .= "BOOKING_MEMBER_FLG, MEMBER_ID, ";

		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("BOOKING_NAME".$i."").", ";
			$sql .= parent::decryptionList("BOOKING_KANA".$i."").", ";
		}
		$sql .= "BOOKING_PREF_ID, ";
		$sql .= parent::decryptionList("BOOKING_ZIP,BOOKING_CITY, BOOKING_ADDRESS, BOOKING_BUILD, BOOKING_TEL").", ";
		$sql .= parent::decryptionList("BOOKING_MAILADDRESS, BOOKING_BIRTH, BOOKING_ANSWER, BOOKING_DEMAND").", ";
		$sql .= "BOOKING_AGE, BOOKING_REQUEST, ";
		$sql .= parent::decryptionList("BOOKING_REQUEST_ANSWER").", ";
		$sql .= "BOOKING_CHANGE_DATE, BOOKING_CANCEL_DATE, ";

		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKING_CANCEL_P".$i."".", ";
		}
		$sql .= "BOOKING_PAYMENT, BOOKING_PAYMENT_FLG, ";
		$sql .= parent::decryptionList("BOOKING_SHOPPLAN_CONTENTS").", ";
		$sql .= parent::decryptionList("BOOKING_MEMO").", ";
		$sql .= "BOOKING_STATUS, BOOKING_DATE_START, BOOKING_DATE_BOOK ";
		$sql .= "from ".shopBooking::tableName." sb ";
		$sql .= "left join SHOP s on sb.COMPANY_ID = s.COMPANY_ID ";
		$sql .= "left join SHOPPLAN sp on sb.SHOPPLAN_ID = sp.SHOPPLAN_ID ";
		$sql .= "left join ROOM r on sb.ROOM_ID = r.ROOM_ID ";
		$sql .= "left join SHOP_PRICETYPE spt on sb.SHOP_PRICETYPE_ID = spt.SHOP_PRICETYPE_ID ";
		$sql .= "left join SHOP_ACCESS sa on sb.COMPANY_ID = sa.COMPANY_ID and sb.BOOKING_MEET_PLACE = sa.SHOP_ACCESS_ID ";

		$where = "";

//		$where .= parent::expsData("linkhp.TL_ROOM_TYPECODE", "=", "linkr.TL_ROOM_TYPECODE")." ";

		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopBooking::keyName, "=", $collection->getByKey($collection->getKeyValue(), "BOOKING_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("sb.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("sb.SHOPPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))." ";
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
			$where .= parent::expsData("sb.ROOM_ID", "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("BOOKING_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "BOOKING_DATE"), true)." ";
			$where .= "and ".parent::expsData("BOOKING_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "BOOKING_DATE")))), true)." ";
		}

		//	?????????????????????
		if ($collection->getByKey($collection->getKeyValue(), "name") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$name = "%".$collection->getByKey($collection->getKeyValue(), "name")."%";
			$sql .= "(sb.BOOKING_NAME1 like '$name' ";
			$sql .= "or sb.BOOKING_NAME2 like '$name' ";
			$sql .= "or sb.BOOKING_KANA1 like '$name' ";
			$sql .= "or sb.BOOKING_KANA2 like '$name') ";
		}
		
		// ????????????
		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "(";
			$where .= parent::expsData("sb.BOOKING_NAME1", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_NAME")."%", true, 4)." ";
			$where .= " or ";
			$where .= parent::expsData("sb.BOOKING_NAME2", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_NAME")."%", true, 4)." ";
			$where .= ") ";
		}
		
		// ???????????????
		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_NAME_KANA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "(";
			$where .= parent::expsData("sb.BOOKING_KANA1", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_NAME_KANA")."%", true, 4)." ";
			$where .= " or ";
			$where .= parent::expsData("sb.BOOKING_KANA2", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_NAME_KANA")."%", true, 4)." ";
			$where .= ") ";
		}
		
		// ???????????????
		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_TITLE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			
			$where .= "(";
			$where .= parent::expsData("sb.BOOKING_NAME1", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_TITLE")."%", true, 4)." ";
			$where .= " or ";
			$where .= parent::expsData("sb.BOOKING_NAME2", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_TITLE")."%", true, 4)." ";
			$where .= " or ";
			$where .= parent::expsData("sb.BOOKING_KANA1", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_TITLE")."%", true, 4)." ";
			$where .= " or ";
			$where .= parent::expsData("sb.BOOKING_KANA2", "like", "%".$collection->getByKey($collection->getKeyValue(), "BOOKING_TITLE")."%", true, 4)." ";
			$where .= ") ";
		}
		
		// ?????????
		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_USE_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "BOOKING_DATE = '". $collection->getByKey($collection->getKeyValue(), "BOOKING_USE_DATE")."' ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by BOOKING_ID desc  ";
//		print_r($collection);
  	//	echo $sql;exit;

		parent::setCollection($sql, shopBooking::keyName);
	}

	public function selectBookedNum($collection) {
		$sql  = "select ";
		$sql .= "count(*) as num from ".shopBooking::tableName." ";

		$where = " BOOKING_STATUS <> 2 ";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOPPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))." ";
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



	public function select($id="", $shopPlanId="", $payId="", $roomId="", $comapnyId="" ) {
		$sql  = "select ";
		$sql .= "BOOKING_ID, COMPANY_ID, SHOPPLAN_ID, SHOP_PRICETYPE_ID, SHOP_PRICETYPE_KIND, HOTELPAY_ID, ROOM_ID, BOOKING_HOW, BOOKING_SHOP_STATUS, ";
		$sql .= parent::decryptionList("BOOKING_CODE, BOOKING_KEY_CODE").", ";
		$sql .= "BOOKING_DATE, ";
		$sql .= parent::decryptionList("BOOKING_MEET_TIME").", ";
		$sql .= "BOOKING_MEET_PLACE, ";
		
		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKING_MONEYKIND".$i."".", ";
			$sql .= "BOOKING_PRICEPERSON".$i."".", ";
			$sql .= "BOOKING_MONEY".$i."".", ";
		}
		for ($i=1; $i<=8; $i++) {
			$sql .= parent::decryptionList("BOOKING_PRICETYPE".$i."").", ";
		}
		$sql .= "BOOKING_ALL_MONEY, BOOKING_DATE_CANCEL_END, ";
		$sql .= parent::decryptionList("BOOKING_DATE_CANCEL_END_TIME").", ";
		$sql .= "BOOKING_MEMBER_FLG, MEMBER_ID, ";
		
		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("BOOKING_NAME".$i."").", ";
			$sql .= parent::decryptionList("BOOKING_KANA".$i."").", ";
		}
		$sql .= "BOOKING_PREF_ID, ";
		$sql .= parent::decryptionList("BOOKING_ZIP,BOOKING_CITY, BOOKING_ADDRESS, BOOKING_BUILD, BOOKING_TEL").", ";
		$sql .= parent::decryptionList("BOOKING_MAILADDRESS, BOOKING_BIRTH, BOOKING_ANSWER, BOOKING_DEMAND").", ";
		$sql .= "BOOKING_AGE, BOOKING_REQUEST, ";
		$sql .= parent::decryptionList("BOOKING_REQUEST_ANSWER").", ";
		$sql .= "BOOKING_CHANGE_DATE, BOOKING_CANCEL_DATE, ";
		
		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKING_CANCEL_P".$i."".", ";
		}
		$sql .= "BOOKING_PAYMENT, BOOKING_PAYMENT_FLG, ";
		$sql .= parent::decryptionList("BOOKING_SHOPPLAN_CONTENTS").", ";
		$sql .= parent::decryptionList("BOOKING_MEMO").", ";
		$sql .= "BOOKING_STATUS, BOOKING_DATE_START, BOOKING_DATE_BOOK, BOOKING_DATE_CANCEL, BOOKING_DATE_DELETE ";
		
		$sql .= "from ".shopBooking::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopBooking::keyName, "=", $id)." ";
		}

		if ($shopPlanId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOPPLAN_ID", "=", $shopPlanId)." ";
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
		
		parent::setCollection($sql, shopBooking::keyName);
	}

	public function selectCancelRoom($id,$companId){
		$sql = "select ";
		$sql.= "count(*) canceled from ".shopBookingcont::tableName;
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
		$sql.= " BOOKINGCONT_MONEY   from ".shopBookingcont::tableName;
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
	
	public function selectCancelData($id="", $shopPlanId="", $payId="", $roomId="", $comapnyId="", $memberId="") {
		$sql  = "select ";
		$sql .= "BOOKING_ID, sb.COMPANY_ID, sb.SHOPPLAN_ID, sb.SHOP_PRICETYPE_ID, sb.SHOP_PRICETYPE_KIND, HOTELPAY_ID, sb.ROOM_ID, BOOKING_HOW, BOOKING_SHOP_STATUS, ";
		$sql .= parent::decryptionList("BOOKING_CODE, BOOKING_KEY_CODE").", ";
		$sql .= "BOOKING_DATE, ";
		$sql .= parent::decryptionList("BOOKING_MEET_TIME").", ";
		$sql .= "BOOKING_MEET_PLACE, sa.SHOP_ACCESS_NAME, sa.SHOP_ACCESS_ADDRESS, ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKING_MONEYKIND".$i."".", ";
			$sql .= "BOOKING_PRICEPERSON".$i."".", ";
			$sql .= "BOOKING_MONEY".$i."".", ";
		}
		for ($i=1; $i<=8; $i++) {
			$sql .= parent::decryptionList("BOOKING_PRICETYPE".$i."").", ";
		}
		$sql .= "BOOKING_ALL_MONEY, BOOKING_DATE_CANCEL_END, ";
		$sql .= parent::decryptionList("BOOKING_DATE_CANCEL_END_TIME").", ";
		$sql .= "BOOKING_MEMBER_FLG, sb.MEMBER_ID, ";

		for ($i=1; $i<=2; $i++) {
			$sql .= parent::decryptionList("BOOKING_NAME".$i."").", ";
			$sql .= parent::decryptionList("BOOKING_KANA".$i."").", ";
		}
		$sql .= "BOOKING_PREF_ID, ";
		$sql .= parent::decryptionList("BOOKING_ZIP,BOOKING_CITY, BOOKING_ADDRESS, BOOKING_BUILD, BOOKING_TEL").", ";
		$sql .= parent::decryptionList("BOOKING_MAILADDRESS, BOOKING_BIRTH, BOOKING_ANSWER, BOOKING_DEMAND").", ";
		$sql .= "BOOKING_AGE, BOOKING_REQUEST, ";
		$sql .= parent::decryptionList("BOOKING_REQUEST_ANSWER").", ";
		$sql .= "BOOKING_CHANGE_DATE, BOOKING_CANCEL_DATE, ";

		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKING_CANCEL_P".$i."".", ";
		}
		$sql .= "BOOKING_MONEY_CANCEL, ";
		$sql .= "BOOKING_DATE_CANCEL, ";
		$sql .= "BOOKING_PAYMENT, BOOKING_PAYMENT_FLG, ";
		$sql .= parent::decryptionList("BOOKING_SHOPPLAN_CONTENTS").", ";
		$sql .= parent::decryptionList("BOOKING_MEMO").", ";
		$sql .= "BOOKING_STATUS, BOOKING_DATE_START, BOOKING_DATE_BOOK ";
		$sql .= "from ".shopBooking::tableName." sb ";
		$sql .= "left join SHOP s on sb.COMPANY_ID = s.COMPANY_ID ";
		$sql .= "left join SHOPPLAN sp on sb.SHOPPLAN_ID = sp.SHOPPLAN_ID ";
		$sql .= "left join ROOM r on sb.ROOM_ID = r.ROOM_ID ";
		$sql .= "left join SHOP_PRICETYPE spt on sb.SHOP_PRICETYPE_ID = spt.SHOP_PRICETYPE_ID ";
		$sql .= "left join SHOP_ACCESS sa on sb.COMPANY_ID = sa.COMPANY_ID and sb.BOOKING_MEET_PLACE = sa.SHOP_ACCESS_ID ";
		$sql .= "left join MEMBER mem on mem.MEMBER_ID = sb.MEMBER_ID ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopBooking::keyName, "=", $id)." ";
		}

		if ($shopPlanId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("sb.SHOPPLAN_ID", "=", $shopPlanId)." ";
		}

		if ($comapnyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("sb.COMPANY_ID", "=", $comapnyId)." ";
		}

		if ($memberId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("sb.MEMBER_ID", "=", $memberId)." ";
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
			$where .= parent::expsData("sb.ROOM_ID", "=", $roomId)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by BOOKING_DATE  ";
		
		parent::setCollection($sql, shopBooking::keyName);
	}


	private function setBookinId($id) {
		$this->bookingId = $id;
	}
	public function getBookingId() {
		return $this->bookingId;
	}


	public function updateBooking($id, $bookingCode) {
			$this->db->begin();

			$sql .= "update ".shopBooking::tableName." set ";
			$sql .= parent::expsData("BOOKING_BOOKING_CODE", "=", $bookingCode, true).", ";
			$sql .= parent::expsData("BOOKING_DATE_BOOK", "=", "now()")." ";
			$sql .= "where ";
			$sql .=  parent::expsData(shopBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}

			$bookingcont = new shopBookingcont($this->db);
			if (!$bookingcont->updateBooking($id, $bookingCode)) {
				$this->db->rollback();
				return false;
			}

			$this->db->commit();
			return true;
	}
	
	public function updateBookingStatus($id, $bookingStatus) {
			$this->db->begin();

			$sql .= "update ".shopBooking::tableName." set ";
			$sql .= parent::expsData("BOOKING_STATUS", "=", $bookingStatus, true)." ";
			$sql .= "where ";
			$sql .=  parent::expsData(shopBooking::keyName, "=", $id)." ";

			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}

			$bookingcont = new shopBookingcont($this->db);
			if (!$bookingcont->updateBookingStatus($id, $bookingStatus)) {
				$this->db->rollback();
				return false;
			}

			$this->db->commit();
			return true;
	}

	public function cancelBookingLink() {
		$this->db->begin();

		$sql .= "update ".shopBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$bookingcont = new shopBookingcont($this->db);
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

		$sql .= "update ".shopBooking::tableName." set ";
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
		$sql .= parent::expsData("BOOKING_ALL_MONEY", "=", $dataList["BOOKING_ALL_MONEY"]).", ";
		$sql .= parent::expsData("BOOKING_SERVICE", "=", $dataList["BOOKING_SERVICE"]).", ";
		$sql .= parent::expsData("BOOKING_ANSWER", "=", $dataList["BOOKING_ANSWER"], true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopBooking::keyName, "=", parent::getKeyValue())." ";
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
			
			$sql .= "update ".shopBooking::tableName." set ";
			$sql .= "BOOKING_REQUEST = ".$dataList["BOOKING_REQUEST"].", ";
			$sql .= parent::expsData("BOOKING_REQUEST_ANSWER", "=", $dataList["BOOKING_REQUEST_ANSWER"], true, 1).", ";
			$sql .= "BOOKING_STATUS = ".$dataList["BOOKING_STATUS"]."  ";
			$sql .= "where ";
			$sql .=  parent::expsData(shopBooking::keyName, "=", parent::getKeyValue())." ";
			
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				$stat = 0;
			}
			//????????shopBookingcont???
/*
			$bookingCon = new shopBookingcont($this->db);
			$sql = '';
			$sql .= "update ".shopBookingcont::tableName." set ";
			$sql .= "BOOKINGCONT_STATUS = ".$dataList["BOOKING_STATUS"]."  ";
			$sql .= "where ";
			$sql .=  parent::expsData(shopBooking::keyName, "=", parent::getKeyValue())." and ";
			$sql .=  parent::expsData(shop::keyName, "=", $dataList['COMPANY_ID'])." ";
			
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				$stat = 0;
			}
*/			
			//?????????????????????
			$mMail = new mMail($this->db);
			$mMail->select(shopBooking::mailRequestID);
			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("???????????????????????????????????????????????????????????????????????????");
				parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
				$this->db->rollback();
				$stat = 0;
			}
			
//			print_r($dataList);exit;
			
			$from = MAIL_SLAKER_NOREPLY;
			$to = $dataList['BOOKING_MAILADDRESS'];
			
			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			
			//??????????????????
			$shop = new shop($this->db);
			$shop->select($dataList['COMPANY_ID']);
			
			$subject = cmReplace($subject, "[!SHOP_NAME!]", $shop->getByKey($shop->getKeyValue(), "SHOP_NAME"));

			if($dataList["BOOKING_REQUEST"] == 1){
				$body = cmReplace($body, "[!REQUEST_ANSWER!]", "??????????????????????????????");
			}
			else{
				$body = cmReplace($body, "[!REQUEST_ANSWER!]", "?????????????????????????????????????????????????????????????????????????????????????????????");
			}
			$body = cmReplace($body, "[!SHOP_NAME!]", $shop->getByKey($shop->getKeyValue(), "SHOP_NAME"));
			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y???m???d??? H:i:s"));
			
			$body = cmReplace($body, "[!MESSAGE!]", $dataList['BOOKING_REQUEST_ANSWER']);
			$body = cmReplace($body, "[!SHOP_TEL!]", $shop->getByKey($shop->getKeyValue(), "SHOP_TEL"));
			$body = cmReplace($body, "[!SHOP_URL!]", URL_PUBLIC."search-detail.html?basic=1&hid=".$dataList['COMPANY_ID']);
			
			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("???????????????????????????????????????????????????");
				parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
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
			parent::setErrorFirst("????????????????????????????????????????????????");
			parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
			$this->db->rollback();
			return false;
		}
		
		$from = MAIL_SLAKER_NOREPLY;
		$to = $to?$to:parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS");
		
		$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
		$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

		$shop = new shop($this->db);
		$shop->select(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
		
		//??????????????????
		$subject = cmReplace($subject, "[!SHOP_NAME!]", $shop->getByKey($shop->getKeyValue(), "SHOP_NAME"));
		$subject = cmReplace($subject, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		
		
		
		
		$body = cmReplace($body, "[!SHOP_TEL!]", $shop->getByKey($shop->getKeyValue(), "SHOP_TEL"));
		$body = cmReplace($body, "[!SHOP_ZIP!]", $shop->getByKey($shop->getKeyValue(), "SHOP_ZIP"));
		$body = cmReplace($body, "[!SHOP_ADDRESS!]", $shop->getByKey($shop->getKeyValue(), "SHOP_ADDRESS"));
		
		
		$body = cmReplace($body, "[!BOOKING_ID!]", parent::getByKey(parent::getKeyValue(), "BOOKING_ID"));
		$body = cmReplace($body, "[!SHOP_NAME!]", $shop->getByKey($shop->getKeyValue(), "SHOP_NAME"));
// 		$body = cmReplace($body, "[!SHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "shop_tel"));
		$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));
		
		$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y???m???d???"));
		$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
		$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
		$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
		$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
// 		$body = cmReplace($body, "[!SHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "shop_tel"));
// 		$body = cmReplace($body, "[!SHOP_ZIP!]", parent::getByKey(parent::getKeyValue(), "shop_zip"));
// 		$body = cmReplace($body, "[!SHOP_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "shop_address")); 
		$body = cmReplace($body, "[!SHOP_CHECKIN!]", $this->selectBookingDateId(parent::getByKey(parent::getKeyValue(), "BOOKING_ID"))." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!NIGHT_NUM!]", parent::getByKey(parent::getKeyValue(), "night_number"));
		$body = cmReplace($body, "[!ROOM_TYPE!]", parent::getByKey(parent::getKeyValue(), "room_type"));
		$body = cmReplace($body, "[!ROOM_NUM!]", parent::getByKey(parent::getKeyValue(), "room_number"));
		$body = cmReplace($body, "[!PLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
		$body = cmReplace($body, "[!SHOP_CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
		$body = cmReplace($body, "[!SHOP_CHECKOUT_TIME!]", parent::getByKey(parent::getKeyValue(), "check_out_time"));
		$body = cmReplace($body, "[!MEAL!]", parent::getByKey(parent::getKeyValue(), "meal"));
		$body = cmReplace($body, "[!PLAN_CONTENTS!]", parent::getByKey(parent::getKeyValue(), "plan_contents"));
		$body = cmReplace($body, "[!CANCEL!]", parent::getByKey(parent::getKeyValue(), "cancel"));
		$body = cmReplace($body, "[!PAYMENT!]", parent::getByKey(parent::getKeyValue(), "payment"));
		
//		if (parent::getByKey(parent::getKeyValue(), "BOOKING_HOW") == 1) {
//			$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????');
//		}
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 1) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 2) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 3) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 4) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
		}
		else{
		}

		
		$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "BOOKING_POINT_USE")*92/100));
		$question = "";
		if (parent::getByKey(parent::getKeyValue(), "question") != "") {
			$question  = "-----------------------------------------------------------------------\n";
			$question .= "?????????????????????????????????\n";
			$question .= "-----------------------------------------------------------------------\n";
			$question .= parent::getByKey(parent::getKeyValue(), "question")."\n";
			$question .= "-----------------------------------------------------------------------\n";
			$question .= parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER")."\n";
		}
		$body = cmReplace($body, "[!QUESTION!]", $question);
		
		$demand = "";
		if (parent::getByKey(parent::getKeyValue(), "demand") == 1) {
			$demand .= "-----------------------------------------------------------------------\n";
			$demand .= "[???????????????]\n";
			$demand = parent::getByKey(parent::getKeyValue(), "BOOKING_DEMAND")."\n";
			$demand .= "-----------------------------------------------------------------------\n";
		}
		
		$body = cmReplace($body, "[!SHOP_URL!]", parent::getByKey(parent::getKeyValue(), "shop_url"));
		
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
//		$body = cmReplace($body, "[!BOOKING_HOW!]", '????????????');
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 1) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 2) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 3) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
		}
		elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 4) {
			$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
		}
		else{
		}
		
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==1) $body = cmReplace($body, "[!REQUEST_ANSWER!]", '??????????????????????????????????????????????????????????????????????????????');
		if(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST")==2) $body = cmReplace($body, "[!REQUEST_ANSWER!]", '????????????????????????????????????????????????????????????????????????');
		
		
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("????????????????????????????????????????????????");
			parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
			$this->db->rollback();
			return false;
		}
		
//print_r($body);
		if($fax){
				//	FAX????????????
				$faxnumer = cmReplace($this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")), "-", "");
				 			//echo $faxnumer;
				// 			$faxnumer='0989888106';

				$sendfax = new sendfax($faxnumer, $body);
				if (!$sendfax->send()) {
					parent::setErrorFirst("??????FAX?????????????????????????????????");
					parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
					$this->db->rollback();
					return false;
				}

		}
		
		return true;
	}

	public function getPlanContentById($id){
		$shopPlan = new shopPlan($this->db);
		$shopPlan->getPlanContentById($id);
		return $shopPlan->getByKey($shopPlan->getKeyValue(), "SHOPPLAN_DISCRIPTION");
	}

	public function save($bookingcontArray,$is_request=false) {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
			$dataList['BOOKING_CODE']=$this->createBookingCode($dataList['COMPANY_ID']);
			$dataList['BOOKING_KEY_CODE']=$this->createRandKey();
		//print_r($dataList);exit;

		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
			$dataList['BOOKING_SHOPPLAN_CONTENTS']=$this->getPlanContentById($dataList['SHOPPLAN_ID']);
			$dataList['BOOKING_CODE']=$this->createBookingCode($dataList['COMPANY_ID']);
			$dataList['BOOKING_KEY_CODE']=$this->createRandKey();
// 			echo $dataList['BOOKING_SHOPPLAN_CONTENTS'];exit;
			$sql = $this->insert($dataList);
			//echo $sql;exit;
			$update_flg = false;
		}
		else {
			$sql = $this->update($dataList);
			$update_flg = true;
			//echo $sql;exit;
		}
 		
		//echo $sql;
		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}


		if ($this->saveDivide($this->getKeyValue())) {
			$idData = new collection($this->db);
			$idData->lastInsert(shopBooking::tableName);
			$id = $idData->getByKey($idData->getKeyValue(), "id");
 			$bookingcontArray["BOOKING_ID"] = $id;
			
		}

		$this->setBookinId($id);


/*		$bookingcont = new shopBookingcont($this->db);
		if (!$bookingcont->saveAll($bookingcontArray, $id)) {
			$this->db->rollback();
			return false;
		}
*/
		// ???????????????????????????????????????????????????????????????????????????
		if (($dataList['ROOM_ID'] > 0) && ($update_flg == false)){

			// ????????????????????????????????????????????????????????????
			if ($dataList['SHOP_PRICETYPE_KIND'] ==1){
				$booking_num = $dataList['BOOKING_PRICEPERSON1']+$dataList['BOOKING_PRICEPERSON2']+$dataList['BOOKING_PRICEPERSON3']+$dataList['BOOKING_PRICEPERSON4']+$dataList['BOOKING_PRICEPERSON5']+$dataList['BOOKING_PRICEPERSON6'];
			}elseif ($dataList['SHOP_PRICETYPE_KIND'] ==2){
			// ???????????????????????????????????????????????????????????????????????????????????????????????????
				$booking_num = $dataList['BOOKING_PRICEPERSON7'];
			}

			//print $booking_num;
			//??????????????????		
			for($i=0;$i<1;$i++){
				$sql = "";
				$sql .= "update HOTELPROVIDE set HOTELPROVIDE_BOOKEDNUM = HOTELPROVIDE_BOOKEDNUM+".$booking_num;
				$sql .= " where ROOM_ID=".$dataList["ROOM_ID"]." and COMPANY_ID = ".$dataList["COMPANY_ID"];
				// $sql .= " and HOTELPROVIDE_DATE = '".date('Y-m-d',strtotime($dataList["BOOKING_DATE"])+$i*60*60*24)."'";
				$sql .= " and HOTELPROVIDE_DATE = '".$dataList["BOOKING_DATE"]."'";
// 				print $sql;

				if (!$this->saveExec($sql)) {
					$this->db->rollback();
					return false;
				}

			}
		}else{
			//print"??????????????????";
		}

		// ????????????????????????????????????????????????????????????????????????
		if (($dataList['BOOKING_HOW'] == 0) && ($update_flg == false)){
			
			// ??????????????????????????????????????????ID??????????????????????????????????????????????????????
			$add_login_info = false;
			if($dataList["BOOKING_MEMBER_FLG"] == 2){
				// ??????????????????
				$dbMaster = new dbMaster();
				$memberRegist = new member($dbMaster);
				
				// ?????????????????????
				$login_pass = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8);
				
				// ????????????ID???????????????????????????
				$login_str .= "????????????ID: ".$dataList["BOOKING_MAILADDRESS"]."\n";
				$login_str .= "???????????????: ".$login_pass."\n";
				
				$memberRegist->db->begin();
				
				$sql  = "insert into ".member::tableName." (";
				$sql .= "MEMBER_ID, ";
				$sql .= "MEMBER_LOGIN_ID, ";
				$sql .= "MEMBER_LOGIN_PASSWORD, ";
				$sql .= "MEMBER_NAME1, ";
				$sql .= "MEMBER_NAME2, ";
				$sql .= "MEMBER_NAME_KANA1, ";
				$sql .= "MEMBER_NAME_KANA2, ";
				$sql .= "MEMBER_PREF, ";
				$sql .= "MEMBER_CITY, ";
				$sql .= "MEMBER_ADDRESS, ";
				$sql .= "MEMBER_BUILD, ";
				$sql .= "MEMBER_TEL1, ";
				$sql .= "MEMBER_STATUS, ";
				$sql .= "MEMBER_DATE_REGIST, ";
				$sql .= "MEMBER_DATE_UPDATE) values (";
				
				$sql .= "null, ";
				$sql .= parent::expsVal($dataList["BOOKING_MAILADDRESS"], true, 1).", ";
				$sql .= parent::expsVal($login_pass, true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_NAME1"], true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_NAME2"], true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_KANA1"], true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_KANA2"], true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_PREF_ID"]).", ";
				$sql .= parent::expsVal($dataList["BOOKING_CITY"], true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_ADDRESS"], true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_BUILD"], true, 1).", ";
				$sql .= parent::expsVal($dataList["BOOKING_TEL"], true, 1).", ";
				$sql .= "4, ";
				$sql .= "now(), ";
				$sql .= "now()) ";
				
				if (!$memberRegist->saveExec($sql)) {
					$memberRegist->db->rollback();
					parent::setErrorFirst("???????????????????????????????????????????????????");
					parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
					$this->db->rollback();
					return false;
				} else {
					$memberRegist->db->commit();
					
					// member_id ????????????????????????
					$idData = new collection($this->db);
					$idData->lastInsert(member::tableName);
					$id = $idData->getByKey($idData->getKeyValue(), "id");
					$member_id = $id;
					
					$booking_id = $this->getBookingId();
					
					$sql = "update ".shopBooking::tableName." set ";
					$sql .= parent::expsData("MEMBER_ID", "=", $member_id)." ";
					$sql .= "where ";
					$sql .=  parent::expsData(shopBooking::keyName, "=", $booking_id)." ";
					
					if (!$this->saveExec($sql)) {
						$this->db->rollback();
						return false;
					}
					
					$add_login_info = true;
				}
			}

			$mMail = new mMail($this->db);
			//?????????????????????????????????
			
			$mailid = !$is_request?shopBooking::mailBooking:shopBooking::mailBookingRequest;

			$mMail->select($mailid);

/*			if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")or($_SERVER['REQUEST_URI'] == "/reservation-hotelcoupon.html")){
				$mMail->select($mailid);
			}
			elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){

			}
			else{
			}
*/

			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("????????????????????????????????????????????????");
				parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
				$this->db->rollback();
				return false;
			}




			$from = MAIL_SLAKER_NOREPLY;
			$to = parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS");

			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$subject = cmReplace($subject, "[!SHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "shop_name"));

			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");

			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["BOOKING_ID"]);
			$body = cmReplace($body, "[!SHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "shop_name"));
			$body = cmReplace($body, "[!SHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "shop_tel"));
			$body = cmReplace($body, "[!NOTIFICATION_ID!]", parent::getByKey(parent::getKeyValue(), "NOTIFICATION_ID"));

			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y???m???d???"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
			$body = cmReplace($body, "[!SHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "shop_name"));
			$body = cmReplace($body, "[!SHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "shop_tel"));
			$body = cmReplace($body, "[!SHOP_ZIP!]", parent::getByKey(parent::getKeyValue(), "shop_zip"));
			$body = cmReplace($body, "[!SHOP_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "shop_address"));
			$body = cmReplace($body, "[!SHOP_CHECKIN!]", parent::getByKey(parent::getKeyValue(), "shop_checkin")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
			$body = cmReplace($body, "[!NIGHT_NUM!]", parent::getByKey(parent::getKeyValue(), "night_number"));
			$body = cmReplace($body, "[!ROOM_TYPE!]", parent::getByKey(parent::getKeyValue(), "room_type"));
			$body = cmReplace($body, "[!ROOM_NUM!]", parent::getByKey(parent::getKeyValue(), "room_number"));
			$body = cmReplace($body, "[!PLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
			$body = cmReplace($body, "[!SHOP_CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
			$body = cmReplace($body, "[!SHOP_CHECKOUT_TIME!]", parent::getByKey(parent::getKeyValue(), "check_out_time"));
			$body = cmReplace($body, "[!MEAL!]", parent::getByKey(parent::getKeyValue(), "meal"));
			$body = cmReplace($body, "[!PLAN_CONTENTS!]", parent::getByKey(parent::getKeyValue(), "plan_contents"));
			$body = cmReplace($body, "[!CANCEL!]", parent::getByKey(parent::getKeyValue(), "cancel"));
			$body = cmReplace($body, "[!PAYMENT!]", parent::getByKey(parent::getKeyValue(), "payment"));
			
			// ????????????????????????
			if($add_login_info){
				$body = cmReplace($body, "[!LOGIN_INFO!]", $login_str);
			}

			if (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 1) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 2) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 3) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 4) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
			}
			else{
			}

			$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "BOOKING_POINT_USE")*92/100));
			$question = "";
			if (parent::getByKey(parent::getKeyValue(), "question") != "") {
				$question  = "-----------------------------------------------------------------------\n";
				$question .= "?????????????????????????????????\n";
				$question .= "-----------------------------------------------------------------------\n";
				$question .= parent::getByKey(parent::getKeyValue(), "question")."\n";
				$question .= "-----------------------------------------------------------------------\n";
				$question .= parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER")."\n";
			}
			$body = cmReplace($body, "[!QUESTION!]", $question);

			$demand = "";
			if (parent::getByKey(parent::getKeyValue(), "demand") == 1) {
				$demand .= "-----------------------------------------------------------------------\n";
				$demand .= "[???????????????]\n";
				$demand = parent::getByKey(parent::getKeyValue(), "BOOKING_DEMAND")."\n";
				$demand .= "-----------------------------------------------------------------------\n";
			}

			$body = cmReplace($body, "[!SHOP_URL!]", parent::getByKey(parent::getKeyValue(), "shop_url"));

			$body = cmReplace($body, "[!MESSAGE!]", $demand);

			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("????????????????????????????????????????????????");
				parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
				$this->db->rollback();
				return false;
			}

			//???????????????????????????
			$mailid = !$is_request?shopBooking::mailBooking2shop:shopBooking::mailBookingRequest2shop;

			if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")or($_SERVER['REQUEST_URI'] == "/reservation-shopcoupon.html")){
				$mMail->select($mailid);
			}
			else{
				$mMail->select($mailid);
			}

			if ($mMail->getCount() != 1) {
				parent::setErrorFirst("????????????????????????????????????????????????");
				parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
				$this->db->rollback();
				return false;
			}
			
			$from = MAIL_SLAKER_NOREPLY;
			$to = $this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			//print "this??????".$to;


			// 		$to = 'jxxycc@qq.com';
	// 		print_r(parent::getCollection());
			//subject
			$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
			$subject = cmReplace($subject, "[!SHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "shop_name"));
			$subject = cmReplace($subject, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");
			
			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["BOOKING_ID"]?$bookingcontArray["BOOKING_ID"]:parent::getByKey(parent::getKeyValue(), "BOOKING_ID"));
			$body = cmReplace($body, "[!SHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "shop_name"));
			$body = cmReplace($body, "[!SHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "shop_tel"));
			
			$body = cmReplace($body, "[!ACCEPT_DATE!]", date("Y???m???d???"));
			$body = cmReplace($body, "[!NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAILADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!TEL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_TEL"));
			$body = cmReplace($body, "[!SHOP_NAME!]", parent::getByKey(parent::getKeyValue(), "shop_name"));
			$body = cmReplace($body, "[!SHOP_TEL!]", parent::getByKey(parent::getKeyValue(), "shop_tel"));
			$body = cmReplace($body, "[!SHOP_ZIP!]", parent::getByKey(parent::getKeyValue(), "shop_zip"));
			$body = cmReplace($body, "[!SHOP_ADDRESS!]", parent::getByKey(parent::getKeyValue(), "shop_address"));
			$body = cmReplace($body, "[!SHOP_CHECKIN!]", parent::getByKey(parent::getKeyValue(), "shop_checkin")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
			$body = cmReplace($body, "[!NIGHT_NUM!]", parent::getByKey(parent::getKeyValue(), "night_number"));
			$body = cmReplace($body, "[!ROOM_TYPE!]", parent::getByKey(parent::getKeyValue(), "room_type"));
			$body = cmReplace($body, "[!ROOM_NUM!]", parent::getByKey(parent::getKeyValue(), "room_number"));
			$body = cmReplace($body, "[!PLAN_NAME!]", parent::getByKey(parent::getKeyValue(), "plan_name"));
			$body = cmReplace($body, "[!SHOP_CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
			$body = cmReplace($body, "[!SHOP_CHECKOUT_TIME!]", parent::getByKey(parent::getKeyValue(), "check_out_time"));
			$body = cmReplace($body, "[!MEAL!]", parent::getByKey(parent::getKeyValue(), "meal"));
			$body = cmReplace($body, "[!PLAN_CONTENTS!]", parent::getByKey(parent::getKeyValue(), "plan_contents"));
			$body = cmReplace($body, "[!CANCEL!]", parent::getByKey(parent::getKeyValue(), "cancel"));
			$body = cmReplace($body, "[!PAYMENT!]", parent::getByKey(parent::getKeyValue(), "payment"));
			
			if (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 1) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 2) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 3) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????????????????????????????????????????????????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 4) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
			}
			else{
			}
			$body = cmReplace($body, "[!POINT!]", floor(parent::getByKey(parent::getKeyValue(), "BOOKING_POINT_USE")*92/100));
			$question = "";
			if (parent::getByKey(parent::getKeyValue(), "question") != "") {
				$question  = "-----------------------------------------------------------------------\n";
				$question .= "?????????????????????????????????\n";
				$question .= "-----------------------------------------------------------------------\n";
				$question .= parent::getByKey(parent::getKeyValue(), "question")."\n";
				$question .= "-----------------------------------------------------------------------\n";
				$question .= parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER")."\n";
			}
			$body = cmReplace($body, "[!QUESTION!]", $question);
			
			$demand = "";
			if (parent::getByKey(parent::getKeyValue(), "demand") == 1) {
				$demand .= "-----------------------------------------------------------------------\n";
				$demand .= "[???????????????]\n";
				$demand = parent::getByKey(parent::getKeyValue(), "BOOKING_DEMAND")."\n";
				$demand .= "-----------------------------------------------------------------------\n";
			}
			
			$body = cmReplace($body, "[!SHOP_URL!]", parent::getByKey(parent::getKeyValue(), "shop_url"));
			
			$body = cmReplace($body, "[!MESSAGE!]", $demand);

			//mail18
			
			$body = cmReplace($body, "[!BOOKING_NAME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2"));
			$body = cmReplace($body, "[!KANA!]", parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")." ".parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"));
			$body = cmReplace($body, "[!MAIL!]", parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS"));
			$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
			$body = cmReplace($body, "[!BOOKING_NIGHT!]", parent::getByKey(parent::getKeyValue(), "night_number"));
			$body = cmReplace($body, "[!CHECKIN_DAY!]", parent::getByKey(parent::getKeyValue(), "shop_checkin"));
			$body = cmReplace($body, "[!CHECKIN_TIME!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"));
			$body = cmReplace($body, "[!ROOM_NAME!]", parent::getByKey(parent::getKeyValue(), "room_type"));
			$body = cmReplace($body, "[!MONEY_ALL!]", parent::getByKey(parent::getKeyValue(), "payment"));
			$body = cmReplace($body, "[!MEMBER_ID!]", parent::getByKey(parent::getKeyValue(), "MEMBER_ID"));
//			$body = cmReplace($body, "[!BOOKING_HOW!]", parent::getByKey(parent::getKeyValue(), "BOOKING_HOW"));
			
			if (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 1) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '?????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 2) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 3) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????????????????????????????????????????????????????????????????');
			}
			elseif (parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT") == 4) {
				$body = cmReplace($body, "[!PAYMENT_HOW!]", '????????????????????????');
			}
			else{
			}
			$body = cmReplace($body, "[!BOOKING_REQUEST!]", parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST"));
			//mail14
			$body = cmReplace($body, "[!ADDRESS!]", parent::getByKey(parent::getKeyValue(), "BOOKING_CITY").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_ADDRESS").' '.parent::getByKey(parent::getKeyValue(), "BOOKING_BUILD"));
			$body = cmReplace($body, "[!BIRTHDAY!]", parent::getByKey(parent::getKeyValue(), "BOOKING_AGE"));
			$body = cmReplace($body, "[!JOB!]", parent::getByKey(parent::getKeyValue(), ""));
// 	 		echo $mailid.$from.'<BR>'.$to.'<BR>'.$subject.'<BR>'.$body;exit;	
			//print "$to";exit;	
			if (!cmMailSendQueue($from, $to, $subject, $body)) {
				parent::setErrorFirst("????????????????????????????????????????????????");
				parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
				$this->db->rollback();
				return false;
			}
			////////////////////////////////////////////////////////////////////////////////////////////
			// FAX??????????????????????????????????????????
			//	fax
// 			if (parent::getByKey(parent::getKeyValue(), "COMPANY_FAX") != "" || $this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))) {
// 				parent::setByKey(parent::setKeyValue(), "COMPANY_FAX",$this->selectCompanyFaxId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")));

// 				//	FAX????????????
// 				if (parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_HOW1") != 2) {
// 					//	FAX??????????????????

// 					$faxnumer = cmReplace(parent::getByKey(parent::getKeyValue(), "COMPANY_FAX"), "-", "");
					
// 					$sendfax = new sendfax($faxnumer, $body);
// 					if (!$sendfax->send()) {
// 						parent::setErrorFirst("??????FAX?????????????????????????????????");
// 						parent::setErrorFirst("??????????????????????????????????????????????????????????????????");
// 						$this->db->rollback();
// 						return false;
// 					}
// 				}
// 			}
			////////////////////////////////////////////////////////////////////////////////////////////
		}else{} //????????????????????????????????????????????????

		$this->db->commit();
		return $bookingcontArray["BOOKING_ID"];


	}


	public function updateOnly($bookingcontArray,$is_request=false) {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		//	$dataList['BOOKING_CODE']=$this->createBookingCode($dataList['COMPANY_ID']);
		//	$dataList['BOOKING_KEY_CODE']=$this->createRandKey();
		//print_r($dataList);exit;

		$sql = "";
		
		// ?????????????????????
		$all_money = 0;
		if ($dataList['SHOP_PRICETYPE_KIND'] == 1) {
			
			for($i = 1; $i <= 6; $i++){
				$all_money += ($dataList['BOOKING_PRICEPERSON'.$i] * $dataList['BOOKING_MONEY'.$i]);
			}
			
		} elseif($dataList['SHOP_PRICETYPE_KIND'] == 2) {
			$all_money += ($dataList['BOOKING_PRICEPERSON7'] * $dataList['BOOKING_MONEY7']);
			$all_money += ($dataList['BOOKING_PRICEPERSON8'] * $dataList['BOOKING_MONEY8']);
		}
		$dataList['BOOKING_ALL_MONEY'] = $all_money;
		
		// ??????????????????????????????
		$beforeBooking = new shopBooking($this->db);
		$beforeBooking->select($dataList["BOOKING_ID"]);
		$arrBeforeData = $beforeBooking->getCollectionByKey($beforeBooking->getKeyValue());

		// ?????????????????????SQL??????
		if (parent::saveDivide(parent::getKeyValue())) {
			$dataList['BOOKING_SHOPPLAN_CONTENTS']=$this->getPlanContentById($dataList['SHOPPLAN_ID']);
			$dataList['BOOKING_CODE']=$this->createBookingCode($dataList['COMPANY_ID']);
			$dataList['BOOKING_KEY_CODE']=$this->createRandKey();
// 			echo $dataList['BOOKING_SHOPPLAN_CONTENTS'];exit;
			$sql = $this->insert($dataList);
			//echo $sql;exit;
			$update_flg = false;
		}
		else {
			$sql = $this->update($dataList);
			$update_flg = true;
			//echo $sql;exit;
		}
		
		//echo $sql;
		
		// ??????????????????
		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		} else {
			$this->db->commit();
			
			// ????????????????????????????????????????????????
			if($dataList['BOOKING_STATUS'] == 2){
				// ??????????????????????????????????????????????????????????????????????????????????????????
				if(!empty($arrBeforeData) && $arrBeforeData['BOOKING_STATUS'] != 2){
					$this->cancel($arrBeforeData);
				}
			} elseif ($dataList['BOOKING_STATUS'] == 1){
				$sign = '-';
				
				// ?????????????????????????????????????????????????????????????????????
				if(!empty($arrBeforeData) && $arrBeforeData['BOOKING_STATUS'] == 2){
					$arrBeforeData = null;
					$sign = '+';
				}
				
				// ???????????????
				$this->stockUpdate($dataList , $arrBeforeData, $sign);
			}
		}
		return true;
	}




	public function insert($dataList) {
		$sql  = "insert into ".shopBooking::tableName." (";
		$sql .= "BOOKING_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "SHOP_ID, ";
		$sql .= "SHOPPLAN_ID, ";
		$sql .= "SHOP_PRICETYPE_ID, ";
		$sql .= "SHOP_PRICETYPE_KIND, ";
		$sql .= "HOTELPAY_ID, ";
		$sql .= "ROOM_ID, ";

		$sql .= "BOOKING_HOW, ";
		$sql .= "BOOKING_SHOP_STATUS, ";
		$sql .= "BOOKING_CODE, ";
		$sql .= "BOOKING_KEY_CODE, ";

		$sql .= "BOOKING_DATE, ";
		$sql .= "BOOKING_MEET_TIME, ";
		$sql .= "BOOKING_MEET_PLACE, ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKING_MONEYKIND".$i.", ";
			$sql .= "BOOKING_PRICETYPE".$i.", ";
			$sql .= "BOOKING_PRICEPERSON".$i.", ";
			$sql .= "BOOKING_MONEY".$i.", ";
		}

		$sql .= "BOOKING_ALL_MONEY, ";

		$sql .= "BOOKING_DATE_CANCEL_END, ";
		$sql .= "BOOKING_DATE_CANCEL_END_TIME, ";

		$sql .= "BOOKING_MEMBER_FLG, ";
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
		$sql .= "BOOKING_MAILADDRESS, ";

		$sql .= "BOOKING_BIRTH, ";
		$sql .= "BOOKING_AGE, ";

		$sql .= "BOOKING_ANSWER, ";
		$sql .= "BOOKING_DEMAND, ";
		$sql .= "BOOKING_REQUEST, ";
		$sql .= "BOOKING_REQUEST_ANSWER, ";

		$sql .= "BOOKING_CHANGE_DATE, ";
		$sql .= "BOOKING_CANCEL_DATE, ";

		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKING_CANCEL_P".$i.", ";
		}

		$sql .= "BOOKING_PAYMENT, ";
		$sql .= "BOOKING_PAYMENT_FLG, ";

		$sql .= "BOOKING_SHOPPLAN_CONTENTS, ";

		$sql .= "BOOKING_MEMO, ";

		$sql .= "BOOKING_STATUS, ";
		$sql .= "BOOKING_DATE_START, ";

		$sql .= "BOOKING_DATE_BOOK) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["SHOP_ID"]).", ";
		$sql .= parent::expsVal($dataList["SHOPPLAN_ID"]).", ";
		$sql .= parent::expsVal($dataList["SHOP_PRICETYPE_ID"]).", ";
		$sql .= parent::expsVal($dataList["SHOP_PRICETYPE_KIND"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_ID"]).", ";
		$sql .= parent::expsVal($dataList["ROOM_ID"]).", ";

		$sql .= parent::expsVal($dataList["BOOKING_HOW"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_SHOP_STATUS"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_CODE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_KEY_CODE"], true, 1).", ";

		$sql .= parent::expsVal($dataList["BOOKING_DATE"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKING_MEET_TIME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_MEET_PLACE"]).", ";

		for ($i=1; $i<=8; $i++) {
			$sql .= parent::expsVal($dataList["BOOKING_MONEYKIND".$i]).", ";
			$sql .= parent::expsVal($dataList["BOOKING_PRICETYPE".$i], true, 1).", ";
			$sql .= parent::expsVal($dataList["BOOKING_PRICEPERSON".$i]).", ";
			$sql .= parent::expsVal($dataList["BOOKING_MONEY".$i]).", ";
		}

		$sql .= parent::expsVal($dataList["BOOKING_ALL_MONEY"]).", ";

		$sql .= parent::expsVal($dataList["BOOKING_DATE_CANCEL_END"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKING_DATE_CANCEL_END_TIME"], true, 1).", ";

		$sql .= parent::expsVal($dataList["BOOKING_MEMBER_FLG"]).", ";
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
		$sql .= parent::expsVal($dataList["BOOKING_MAILADDRESS"], true, 1).", ";

		$sql .= parent::expsVal($dataList["BOOKING_BIRTH"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_AGE"]).", ";

		$sql .= parent::expsVal($dataList["BOOKING_ANSWER"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_DEMAND"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKING_REQUEST"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_REQUEST_ANSWER"], true, 1).", ";

		$sql .= parent::expsVal($dataList["BOOKING_CHANGE_DATE"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_CANCEL_DATE"]).", ";

		for ($i=1; $i<=7; $i++) {
			$sql .= parent::expsVal($dataList["BOOKING_CANCEL_P".$i]).", ";
		}

		$sql .= parent::expsVal($dataList["BOOKING_PAYMENT"]).", ";
		$sql .= parent::expsVal($dataList["BOOKING_PAYMENT_FLG"]).", ";

		$sql .= parent::expsVal($dataList["BOOKING_SHOPPLAN_CONTENTS"], true, 1).", ";

		$sql .= parent::expsVal($dataList["BOOKING_MEMO"], true, 1).", ";

// 		$sql .= "1, ";
		$sql .= parent::expsVal($dataList["BOOKING_STATUS"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
		//print_r($dataList);exit;
//print $sql;
		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".shopBooking::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("SHOP_ID", "=", $dataList["SHOP_ID"]).", ";
		$sql .= parent::expsData("SHOPPLAN_ID", "=", $dataList["SHOPPLAN_ID"]).", ";
		$sql .= parent::expsData("SHOP_PRICETYPE_ID", "=", $dataList["SHOP_PRICETYPE_ID"]).", ";
		$sql .= parent::expsData("SHOP_PRICETYPE_KIND", "=", $dataList["SHOP_PRICETYPE_KIND"]).", ";
		$sql .= parent::expsData("HOTELPAY_ID", "=", $dataList["HOTELPAY_ID"]).", ";
		$sql .= parent::expsData("ROOM_ID", "=", $dataList["ROOM_ID"]).", ";

		$sql .= parent::expsData("BOOKING_HOW", "=", $dataList["BOOKING_HOW"]).", ";
		$sql .= parent::expsData("BOOKING_SHOP_STATUS", "=", $dataList["BOOKING_SHOP_STATUS"]).", ";
		$sql .= parent::expsData("BOOKING_CODE", "=", $dataList["BOOKING_CODE"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_KEY_CODE", "=", $dataList["BOOKING_KEY_CODE"], true, 1).", ";

		$sql .= parent::expsData("BOOKING_DATE", "=", $dataList["BOOKING_DATE"], true).", ";
		$sql .= parent::expsData("BOOKING_MEET_TIME", "=", $dataList["BOOKING_MEET_TIME"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_MEET_PLACE", "=", $dataList["BOOKING_MEET_PLACE"]).", ";

		for ($i=1; $i<=8; $i++) {
			$sql .= parent::expsData("BOOKING_MONEYKIND".$i, "=", $dataList["BOOKING_MONEYKIND".$i]).", ";
			$sql .= parent::expsData("BOOKING_PRICETYPE".$i, "=", $dataList["BOOKING_PRICETYPE".$i], true, 1).", ";
			$sql .= parent::expsData("BOOKING_PRICEPERSON".$i, "=", $dataList["BOOKING_PRICEPERSON".$i]).", ";
			$sql .= parent::expsData("BOOKING_MONEY".$i, "=", $dataList["BOOKING_MONEY".$i]).", ";
		}

		$sql .= parent::expsData("BOOKING_ALL_MONEY", "=", $dataList["BOOKING_ALL_MONEY"]).", ";

		$sql .= parent::expsData("BOOKING_DATE_CANCEL_END", "=", $dataList["BOOKING_DATE_CANCEL_END"]).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL_END_TIME", "=", $dataList["BOOKING_DATE_CANCEL_END_TIME"], true, 1).", ";

		$sql .= parent::expsData("BOOKING_MEMBER_FLG", "=", $dataList["BOOKING_MEMBER_FLG"]).", ";
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
		$sql .= parent::expsData("BOOKING_MAILADDRESS", "=", $dataList["BOOKING_MAILADDRESS"], true, 1).", ";

		$sql .= parent::expsData("BOOKING_BIRTH", "=", $dataList["BOOKING_BIRTH"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_AGE", "=", $dataList["BOOKING_AGE"]).", ";

		$sql .= parent::expsData("BOOKING_ANSWER", "=", $dataList["BOOKING_ANSWER"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_DEMAND", "=", $dataList["BOOKING_DEMAND"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_REQUEST", "=", $dataList["BOOKING_REQUEST"]).", ";
		$sql .= parent::expsData("BOOKING_REQUEST_ANSWER", "=", $dataList["BOOKING_REQUEST_ANSWER"], true, 1).", ";

		$sql .= parent::expsData("BOOKING_CHANGE_DATE", "=", $dataList["BOOKING_CHANGE_DATE"]).", ";
		$sql .= parent::expsData("BOOKING_CANCEL_DATE", "=", $dataList["BOOKING_CANCEL_DATE"]).", ";

		for ($i=1; $i<=7; $i++) {
			$sql .= parent::expsData("BOOKING_CANCEL_P".$i, "=", $dataList["BOOKING_CANCEL_P".$i]).", ";
		}

		$sql .= parent::expsData("BOOKING_PAYMENT", "=", $dataList["BOOKING_PAYMENT"]).", ";
		$sql .= parent::expsData("BOOKING_PAYMENT_FLG", "=", $dataList["BOOKING_PAYMENT_FLG"]).", ";

		$sql .= parent::expsData("BOOKING_SHOPPLAN_CONTENTS", "=", $dataList["BOOKING_SHOPPLAN_CONTENTS"], true, 1).", ";
		$sql .= parent::expsData("BOOKING_MEMO", "=", $dataList["BOOKING_MEMO"], true, 1).", ";

		$sql .= parent::expsData("BOOKING_STATUS", "=", $dataList["BOOKING_STATUS"]).", ";
		$sql .= parent::expsData("BOOKING_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopBooking::keyName, "=", $this->getKeyValue())." ";
//print $sql;
		return $sql;
	}

	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".shopBooking::tableName." set ";
// 		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(shopBooking::keyName, "=", parent::getKeyValue())." ";

// 		if (!parent::saveExec($sql)) {
// 			$this->db->rollback();
// 			return false;
// 		}

// 		$this->db->commit();
// 		return true;

	}
	
	/**
	 * ???????????????
	 * @return boolean
	 */
	public function cancel($beforeData = null) {
		$this->db->begin();
		
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		// ???????????????????????????
		$cancel_money = $this->calcBookingCancelMoney($dataList);
		
		// ?????????????????????
		$sql .= "update ".shopBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()").", ";
		$sql .= parent::expsData("BOOKING_MONEY_CANCEL", "=", $cancel_money)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}
		
		$this->db->commit();
		
		// ?????????????????????
		if (!$this->stockUpdate($dataList)) {
			return false;
		}
		
		// ???????????????
		$this->mails(shopBooking::mailCancelID,'',false);
		
		$this->mails(shopBooking::mailCancelID2shop,$this->selectCompanyPayId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")),true);

		return true;
	}
	
	
	/**
	 * ???????????????
	 * @param unknown $dataList
	 * @param string $beforeData
	 * @param string $sign
	 * @return boolean
	 */
	public function stockUpdate($dataList , $beforeData = null, $sign = "-"){
		
		if(!empty($dataList)){
			$this->db->begin();
			
			$company_id   = $dataList["COMPANY_ID"];
			$room_id      = $dataList["ROOM_ID"];
			$booking_date = $dataList["BOOKING_DATE"];
			
			// ??????????????????
			$hotelProvide = new hotelProvide($this->db);
			$hotelProvide->select("", $company_id,$room_id,$booking_date);
			$provide_data = $hotelProvide->getCollectionByKey($hotelProvide->getKeyValue());
			
			/*
			* ?????????????????????????????????????????????????????????????????????
			* ???????????????????????????????????????????????????
			*/
			if($provide_data['HOTELPROVIDE_FLG_STOP'] == 1){
				// ?????????????????????
				$person_num        = 0;
				$before_person_num = 0;
					
				// 1?????????
				if($dataList["SHOP_PRICETYPE_KIND"] == 1){
					for($i = 1; $i <= 6; $i++){
						if($dataList["BOOKING_PRICEPERSON". $i] > 0){
							$person_num += $dataList["BOOKING_PRICEPERSON". $i];
						}
							
						if (!empty($beforeData) && $beforeData["BOOKING_PRICEPERSON". $i] > 0) {
							$before_person_num += $beforeData["BOOKING_PRICEPERSON". $i];
						}
					}
				// ??????????????????
				} else {
					$person_num = $dataList["BOOKING_PRICEPERSON7"];
			
					if (!empty($beforeData) ) {
						$before_person_num = $beforeData['BOOKING_PRICEPERSON7'];
					}
				}
					
				$change_person_num = $person_num;
					
				if (!empty($beforeData)) {
					// ?????????????????????????????????????????????(??????????????????????????????)
					if($person_num != $before_person_num){
						$change_person_num = $person_num - $before_person_num;
						$change_person_num = -$change_person_num;
					} else {
						$change_person_num = 0;
					}
				}
					
				$sql = "";
				$sql .= "update HOTELPROVIDE set HOTELPROVIDE_BOOKEDNUM = HOTELPROVIDE_BOOKEDNUM ".$sign." ".$change_person_num;
				$sql .= " where ROOM_ID=".$room_id." and COMPANY_ID = ".$company_id;
				$sql .= " and HOTELPROVIDE_DATE = '".$booking_date."'";
					
				if (!$this->saveExec($sql)) {
					$this->db->rollback();
					return false;
				}
			}
			
			$this->db->commit();
			
			return true;
		}
		
		return false;
	}
	
	
	/**
	 * ???????????????????????????
	 * @param unknown $company_id
	 * @param unknown $shop_plan_id
	 * @param unknown $all_money
	 * @param unknown $shopBooking
	 * @return number
	 */
	public function calcBookingCancelMoney($booking){
		
		$dbMaster = new dbMaster();
		
		$cancel_money = 0;
		$arrCancelMoney = array();
		$day_key = false;
		
		$all_money  = $booking['BOOKING_ALL_MONEY'];
		$company_id = $booking['COMPANY_ID'];
		$plan_id    = $booking['SHOPPLAN_ID'];
		
		// ??????????????????????????????????????????
		$booking_date = $booking['BOOKING_DATE'];
		
		$unix_booking_date = strtotime($booking_date);
		$now               = strtotime(date('Y-m-d'));
		$date_interval     = round(($unix_booking_date - $now) / (60*60*24));
		
		// ?????????????????????
		$shopPlan = new shopPlan($this->db);
		$shopPlan->select($plan_id, "", $company_id);
		$plan = $shopPlan->getCollectionByKey($shopPlan->getKeyValue());
		
		// ????????????????????????
		$shopBookset = new shopBookset($this->db);
		$shopBookset->select($company_id);
		$shop_bookset = $shopBookset->getCollectionByKey($shopBookset->getKeyValue());
		
		//// ???????????????????????????

		// ???????????????????????????????????????????????????????????????
		for ($i = 1; $i <= 7; $i++) {
			
			$arrCancelMoney[$i] = 0;
			
			// ????????????
			if ($plan['SHOPPLAN_FLG_CANCEL'] == 1) {
				// ?????????????????????????????????????????? ?????? ????????????????????????????????????????????????????????????
				if ($shop_bookset['BOOKSET_CANCEL_SET'] == 1 && $shop_bookset['BOOKSET_CANCEL_DATA'. $i] == 1) {
					// ???????????????
					if ($shop_bookset['BOOKSET_CANCEL_DIVIDE'. $i] == 1) {
						$arrCancelMoney[$i] = floor($all_money * ($shop_bookset['BOOKSET_CANCEL_PAY'. $i]/100));
					// ??????
					} else {
						$arrCancelMoney[$i] = $shop_bookset['BOOKSET_CANCEL_PAY'. $i];
					}
					
					// 1???????????????????????????????????????????????????????????????????????????
					if($date_interval > 0 && $i >= 3){
						if( $shop_bookset["BOOKSET_CANCEL_DATE_FROM". $i] <= $date_interval 
							&& $date_interval <= $shop_bookset["BOOKSET_CANCEL_DATE_TO". $i]){
							$day_key = $i;
						}
					}
				}
				// ????????????
			} else {
				// ????????????????????????6???????????????????????????????????????7????????????????????????
				if($i == 7){
					break;
				}
				
				// ???????????????
				if ($plan['SHOPPLAN_CANCEL_FLG'. $i] == 1) {
					$arrCancelMoney[$i] = floor($all_money * ($plan['SHOPPLAN_CANCEL_MONEY'. $i]/100));
				// ??????
				} else {
					$arrCancelMoney[$i] = $plan['SHOPPLAN_CANCEL_MONEY'. $i];
				}
				
				// 1???????????????????????????????????????????????????????????????????????????
				if($date_interval > 0 && $i >= 3){
					if( $shop_bookset["SHOPPLAN_CANCEL_FROM". $i] <= $date_interval
						&& $date_interval <= $shop_bookset["SHOPPLAN_CANCEL_TO". $i]){
						$day_key = $i;
					}
				}
			}
		}
		
		// ?????????????????????
		if ($date_interval < 0) {
			$cancel_money = $arrCancelMoney[1];
		// ?????????????????????
		} elseif ($date_interval == 0) {
			$cancel_money = $arrCancelMoney[2];
		// 1????????????
		} elseif ($date_interval >= 1) {
			// ?????????????????????????????????????????????
			if($day_key > 0){
				$cancel_money = $arrCancelMoney[$day_key];
			}
		}
		
		return $cancel_money;
	}
	
	public function noshow() {
		$sql .= "update ".shopBooking::tableName." set ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 3).", ";
		$sql .= parent::expsData("BOOKING_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopBooking::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			return false;
		}

		return true;
	}
	
	public function checkBookedNum($bookingcontArray){
		$sql  = "select ";
		$sql .= "count(*) as num from ".shopBooking::tableName." ";
		
		$where = " BOOKING_STATUS <> 2 ";
		
		if ($bookingcontArray[1]["COMPANY_ID"] != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $bookingcontArray[1]["COMPANY_ID"])." ";
		}
		
		if ($bookingcontArray[1]["SHOPPLAN_ID"] != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOPPLAN_ID", "=", $bookingcontArray[1]["SHOPPLAN_ID"])." ";
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
	
	/**
	 * ?????????????????????????????????
	 * @param unknown $bookingcontArray
	 */
	public function checkAll($bookingcontArray) {
		// ????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"))) {
			parent::setErrorFirst("??????????????????????????????????????????");
		}
		
		// ?????????ID
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_ID"))) {
			parent::setErrorFirst("???????????????????????????????????????");
		}
		
		// ???????????????ID
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_ID"))) {
			parent::setErrorFirst("??????????????????????????????????????????");
		}
		
		// ?????????ID
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_ID"))) {
			parent::setErrorFirst("???????????????????????????????????????");
		}
		
		// ?????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "target_date"))) {
			parent::setErrorFirst("???????????????????????????????????????");
			// parent::setError("BOOKING_DATE", "??????????????????");
		}
		
		// ??????????????????
		$price_person = 0;
		for($i = 1 ; $i <= 8; $i++){
			$price_person += parent::getByKey(parent::getKeyValue(), "BOOKING_PRICEPERSON".$i);
		}
		if($price_person == 0){
			// 			parent::setErrorFirst("????????????????????????????????????????????????");
			parent::setError("BOOKING_PRICEPERSON", "????????????????????????????????????????????????");
		}
		
		//// ????????????????????????
		// ?????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_NAME1"))
		|| !cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_NAME2")) ) {
			parent::setError("BOOKING_NAME", "??????????????????");
		}
		
		// ????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1"))
		|| !cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2")) ) {
			parent::setError("BOOKING_KANA", "??????????????????");
		}
		
		if ((cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")) && !preg_match('/^[???-???]+$/u', parent::getByKey(parent::getKeyValue(), "BOOKING_KANA1")))
		|| (cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2")) && !preg_match('/^[???-???]+$/u', parent::getByKey(parent::getKeyValue(), "BOOKING_KANA2"))) ) {
			parent::setError("BOOKING_KANA", "?????????????????????????????????????????????");
		}
		
		// ?????????????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_MAILADDRESS")) ) {
			parent::setError("BOOKING_MAILADDRESS", "??????????????????");
		}
		
		//// ?????????
		// ????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_PREF_ID")) ) {
			parent::setError("BOOKING_PREF_ID", "??????????????????");
		}
		// ?????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_CITY")) ) {
			parent::setError("BOOKING_CITY", "??????????????????");
		}
		// ???????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_ADDRESS")) ) {
			parent::setError("BOOKING_ADDRESS", "??????????????????");
		}
		// ?????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_BUILD")) ) {
			parent::setError("BOOKING_BUILD", "??????????????????");
		}
		
		// ????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_TEL")) ) {
			parent::setError("BOOKING_TEL", "??????????????????");
		} else {
			$member_tel = parent::getByKey(parent::getKeyValue(), "BOOKING_TEL");
			$member_tel = mb_convert_kana($member_tel, "n", "utf-8");
			if(!preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $member_tel)){
				parent::setError("BOOKING_TEL", "00-0000-0000???????????????-(????????????)?????????????????????????????????");
			}
			parent::setByKey(parent::getKeyValue(), "BOOKING_TEL", $member_tel);
		}
		
		// ???????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER")) ) {
			// ????????????????????????????????????
			if (parent::getByKey(parent::getKeyValue(), "SHOPPLAN_QUESTION_REC") == 1 ){
				parent::setError("BOOKING_ANSWER", "??????????????????");
			}
		}
		
		// ????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_MEET_PLACE")) ) {
			parent::setError("BOOKING_MEET_PLACE", "??????????????????");
		}
		
		// ?????????????????? ???????????????????????????????????????????????????
		/*if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT")) ) {
			parent::setError("BOOKING_PAYMENT", "??????????????????");
		}*/
/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_MEET_TIME"))) {
			parent::setError("BOOKING_MEET_TIME", "??????????????????");
		}

		//?????????????????????????????????
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_MEMBER_FLG") == 2) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))) {
				parent::setError("MEMBER_ID", "??????????????????????????????????????????");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_PAYMENT"))) {
			parent::setError("BOOKING_PAYMENT", "?????????????????????");
		}

		if (parent::getByKey(parent::getKeyValue(), "question_req") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER"))) {
				parent::setError("BOOKING_ANSWER", "???????????????????????????????????????");
			}
		}
*/
//		if (!$this->checkBookedNum($bookingcontArray)){
//			parent::setError("BOOKING_NUMS", "??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????");
//		}
// 		parent::setError("BOOKING_CHECKIN", "??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????");
	}
	
	public function checkRequestBooking(){
		if (!$_POST) return;
		
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST"))) {
			parent::setError("BOOKING_REQUEST", "??????????????????");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_REQUEST_ANSWER"))) {
			parent::setError("BOOKING_REQUEST_ANSWER", "??????????????????");
		}
	}
	
	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_ID"))) {
			parent::setErrorFirst("???????????????????????????????????????");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_ID"))) {
			parent::setErrorFirst("??????????????????????????????????????????");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_ID"))) {
			parent::setErrorFirst("?????????????????????????????????????????????");
		}
		
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_DATE"))) {
			parent::setError("BOOKING_DATE", "??????????????????");
		}
		

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_DATE_CANCEL_END"))) {
// 			parent::setError("BOOKING_DATE_CANCEL_END", "??????????????????");
// 		}

	/*	if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))) {
			parent::setError("MEMBER_ID", "??????????????????");
		}
*/

		if (parent::getByKey(parent::getKeyValue(), "question_req") == 1) {
			parent::setError("BOOKING_ANSWER", "??????????????????");
		}

/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_HOW"))) {
			parent::setError("BOOKING_HOW", "??????????????????");
		}
*/
	}


	public  function selectDuplication($id, $couponId) {
		$sql  = "select ";
		$sql .= "BOOKING_ID ";
		$sql .= "from ".shopBooking::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("BOOKING_STATUS", "=", 1)." and ";
	//	$sql .= parent::expsData("MEMBER_ID", "=", parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))." and ";
		$sql .= parent::expsData("COUPON_ID_NUM", "=", $couponId, true, 1)." ";
		if ($id != "") {
			$sql .= "and ".parent::expsData(shopBooking::keyName, "<>", $id)." ";
		}
		parent::setCollection($sql, shopBooking::keyName);
	}

	public function checkAllCoupon($bookingcontArray) {
		
		if (count($bookingcontArray) > 0) {
			foreach ($bookingcontArray as $k=>$d) {
				if ($d["BOOKINGCONT_NUM1"] + $d["BOOKINGCONT_NUM2"] != $d["adult_number"]) {
					parent::setErrorFirst($d["night_number"]."??????".$d["BOOKINGCONT_ROOM"]."?????????????????????????????????????????????????????????");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_CHECKIN"))) {
			parent::setError("BOOKING_CHECKIN", "??????????????????");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ID"))) {
			parent::setError("MEMBER_ID", "??????????????????????????????????????????");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_HOW"))) {
			parent::setError("BOOKING_HOW", "?????????????????????");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"))) {
			parent::setError("COUPON_ID_NUM", "?????????????????????????????????????????????");
		}
		elseif (!preg_match("/[ -~]+/", parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"))) {
			parent::setError("COUPON_ID_NUM", "?????????????????????????????????????????????????????????????????????");
		}
		else {	$couponDuplication = new shopBooking($this->db);
			$couponDuplication->selectDuplication("",parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM"));
			//print $couponDuplication->getCount();
			if ($couponDuplication->getCount() > 0) {
				parent::setError("COUPON_ID_NUM", "???????????????????????????????????????????????????????????????");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE"))) {
			parent::setError("COUPON_KEY_CODE", "??????????????????????????????????????????");
		}
		elseif (!preg_match("/[ -~]+/", parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE"))) {
			parent::setError("COUPON_KEY_CODE", "??????????????????????????????????????????????????????????????????");
		}
		else {	$couponIdKey = new couponBooking($this->db);
			$couponIdKey->selectIdKey(
				(parent::getByKey(parent::getKeyValue(), "COUPON_ID_NUM")),
				(parent::getByKey(parent::getKeyValue(), "COUPON_KEY_CODE")),
				(parent::getByKey(parent::getKeyValue(), "MEMBER_ID")),
				(parent::getByKey(parent::getKeyValue(), "COMPANY_ID")),
				(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_ID")));
			//print $couponIdKey->getCount();
			if ($couponIdKey->getCount() <= 0) {
				parent::setError("COUPON_ID_NUM", "????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????");
			}
		}


		if (parent::getByKey(parent::getKeyValue(), "question_req") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKING_ANSWER"))) {
				parent::setError("BOOKING_ANSWER", "???????????????????????????????????????");
			}
		}
	}


	public function getLastNotificationID($company_id) {
		$sql  = "select count(*) as num from ".shopBooking::tableName." ";
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

// 			$this->setByKey($this->getKeyValue(), "SHOP_PRICETYPE_KIND", 1);
// 			$this->setByKey($this->getKeyValue(), "BOOKING_MONEYKIND1", 1);
// 			$this->setByKey($this->getKeyValue(), "BOOKING_PAYMENT", 1);
// 			$this->setByKey($this->getKeyValue(), "BOOKING_MONEYKIND7", 4);
// 			$this->setByKey($this->getKeyValue(), "BOOKING_MONEYKIND8", 4);

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
				$this->setByKey($this->getKeyValue(), "shopBooking_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "shopBooking_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "shopBooking_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "shopBooking_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "shopBooking_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "shopBooking_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "shopBooking_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "shopBooking_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "shopBooking_LIST_AREA", $this->getByKey($this->getKeyValue(), "shopBooking_LIST_AREA"));
			}
			*/


		}

	}
	
	/**
	 * ???????????????????????????????????????
	 */
	public function checkCancelConfirm() {
		if (!$_POST) return;
		
		$arrHourData = cmShopHourSelect();
		$arrMinData  = cmShopMinSelect();
		
		$booking_date    = parent::getByKey(parent::getKeyValue(), "BOOKING_DATE");
		$plan_cancel_day = parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CAN_DAY");
		$cancel_data     = parent::getByKey(parent::getKeyValue(), "canceldata");
		
		$can_hour = $arrHourData[parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CAN_HOUR")];
		$can_min  = $arrMinData[parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CAN_MIN")];
		if($can_hour == 24){
			$booking_date = date("Y-m-d", strtotime($booking_date) + (24 * 60 * 60 * 1));
			$can_hour = "00";
		}
		$can_date = date("Y-m-d", strtotime($booking_date) - (24 * 60 * 60 * $plan_cancel_day));
		$cancel_target_date_time = strtotime($can_date . " ". $can_hour . ":" .$can_min . ":00");
		
		$cancel_target_data = date("Y-m-d H:i:s", $cancel_target_date_time);
		
		// ??????????????????????????????????????????
		if (time() > $cancel_target_date_time) {
			parent::setErrorFirst("???????????????????????????????????????????????????????????????????????????????????????????????????");
		}

		// ????????????????????????????????????????????????
		if (count($cancel_data) <= 0 && count(parent::getByKey(parent::getKeyValue(), "noshow")) <= 0) {
			parent::setErrorFirst("??????????????????????????????????????????????????????");
		}
		
		// ???????????????????????????
		if (parent::getByKey(parent::getKeyValue(), "BOOKING_STATUS") == 2) {
			parent::setErrorFirst("???????????????????????????");
		}
	
	}


}
?>