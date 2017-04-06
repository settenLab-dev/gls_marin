<?php
class form_make extends collection {
	const tableName = "FORM";
	const keyName = "FORM_ID";
	const tableKeyName = "FORM_ID";

	const formCoupon2user = 39;



	public function form_make($db) {
		parent::collection($db);
	}

	public function selectListAdmin($collection) {
		$sql  = "select ";
		$sql .= "f.FORM_ID, ";
		$sql .= "f.FORM_NAME, ";
		$sql .= "f.FORM_CATEGORY, ";
		$sql .= "f.FORM_MEMBER_FLG, ";
		$sql .= "f.FORM_DUPLICATE_FLG, ";
		$sql .= "f.FORM_LIMIT_FLG, ";
		$sql .= "f.FORM_DATE_FROM, ";
		$sql .= "f.FORM_DATE_TO, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "f.FORM_IMG".$i.", ";
		}
		$sql .= "f.FORM_TITLE, ";
		$sql .= "f.FORM_TEXT, ";
		$sql .= "f.FORM_BTN_FLG, ";
		$sql .= "f.FORM_PUBLIC_FLG, ";

		$sql .= "f.FORM_INPUT_NAME, ";
		$sql .= "f.FORM_INPUT_MAIL, ";
		$sql .= "f.FORM_INPUT_TEL, ";
		$sql .= "f.FORM_INPUT_ADDRES, ";
		$sql .= "f.FORM_INPUT_SEX, ";
		$sql .= "f.FORM_INPUT_JOB, ";
		$sql .= "f.FORM_INPUT_BIRTHDAY, ";
		$sql .= "f.FORM_INPUT_ETC, ";
		$sql .= "f.FORM_ADMIN_MEMO, ";

		$sql .= "f.FORM_REGIST_DATE, ";
		$sql .= "f.FORM_UP_DATE ";
		$sql .= "from ".form_make::tableName." f ";
		//$sql .= "inner join COMPANY c on e.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "FORM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "f.".form_make::keyName." = ".$collection->getByKey($collection->getKeyValue(), "FORM_ID")." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "FORM_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$FORM_NAM = "%".$collection->getByKey($collection->getKeyValue(), "FORM_NAME")."%";
			$where .= "FORM_NAME like '$FORM_NAM' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "FORM_DATE_TO") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$FORM_DATE = $collection->getByKey($collection->getKeyValue(), "FORM_DATE_FROM");
			$where .= "'".$collection->getByKey($collection->getKeyValue(), "FORM_DATE_FROM")."' between FORM_DATE_FROM and FORM_DATE_TO ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by FORM_ID desc ";

		parent::setCollection($sql, form_make::keyName);
	}

	public function selectBook($collection,$session) {
		$sql  = "select ";
		$sql .= "fb.FORMBOOK_ID, ";
		$sql .= "fb.MEMBER_ID, ";
		$sql .= "fb.COMPANY_ID, ";
		$sql .= "fb.COUPONSHOP_ID, ";
		$sql .= "fb.COUPONPLAN_ID ";

		$sql .= "from FORMBOOK fb ";
		//$sql .= "inner join COMPANY c on e.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($session != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "fb.MEMBER_ID = ".$session." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "fb.COMPANY_ID = ".$collection->getByKey($collection->getKeyValue(), "COMPANY_ID")." ";
		}


		if ($collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "fb.COUPONSHOP_ID = ".$collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID")." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "fb.COUPONPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID")." ";
		}


		if ($where != "") {
			$sql .= "where ".$where." ";
		}
//print_r($sql);
		$sql .= "order by FORMBOOK_ID desc ";

		parent::setCollection($sql, "FORMBOOK_ID");
	}



	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "f.FORM_ID, ";
		$sql .= "f.FORM_NAME, ";
		$sql .= "f.FORM_CATEGORY, ";
		$sql .= "f.FORM_MEMBER_FLG, ";
		$sql .= "f.FORM_DUPLICATE_FLG, ";
		$sql .= "f.FORM_LIMIT_FLG, ";
		$sql .= "f.FORM_DATE_FROM, ";
		$sql .= "f.FORM_DATE_TO, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "f.FORM_IMG".$i.", ";
		}
		$sql .= "f.FORM_TITLE, ";
		$sql .= "f.FORM_TEXT, ";
		$sql .= "f.FORM_BTN_FLG, ";
		$sql .= "f.FORM_PUBLIC_FLG, ";

		$sql .= "f.FORM_INPUT_NAME, ";
		$sql .= "f.FORM_INPUT_MAIL, ";
		$sql .= "f.FORM_INPUT_TEL, ";
		$sql .= "f.FORM_INPUT_ADDRES, ";
		$sql .= "f.FORM_INPUT_SEX, ";
		$sql .= "f.FORM_INPUT_JOB, ";
		$sql .= "f.FORM_INPUT_BIRTHDAY, ";
		$sql .= "f.FORM_INPUT_ETC, ";
		$sql .= "f.FORM_ADMIN_MEMO, ";

		$sql .= "f.FORM_REGIST_DATE, ";
		$sql .= "f.FORM_UP_DATE ";
		$sql .= "from ".form_make::tableName." f ";
		//$sql .= "inner join COMPANY c on e.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "FORM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "f.".form_make::keyName." = ".$collection->getByKey($collection->getKeyValue(), "FORM_ID")." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "FORM_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$FORM_NAM = "%".$collection->getByKey($collection->getKeyValue(), "FORM_NAME")."%";
			$where .= "FORM_NAME like '$FORM_NAM' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "FORM_DATE_TO") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "'".$collection->getByKey($collection->getKeyValue(), "FORM_DATE_FROM")."' between FORM_DATE_FROM and FORM_DATE_TO ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by FORM_ID desc ";

		parent::setCollection($sql, form_make::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "f.FORM_ID, ";
		$sql .= "f.FORM_NAME, ";
		$sql .= "f.FORM_CATEGORY, ";
		$sql .= "f.FORM_MEMBER_FLG, ";
		$sql .= "f.FORM_DUPLICATE_FLG, ";
		$sql .= "f.FORM_LIMIT_FLG, ";
		$sql .= "f.FORM_DATE_FROM, ";
		$sql .= "f.FORM_DATE_TO, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "f.FORM_IMG".$i.", ";
		}
		$sql .= "f.FORM_TITLE, ";
		$sql .= "f.FORM_TEXT, ";
		$sql .= "f.FORM_BTN_FLG, ";
		$sql .= "f.FORM_PUBLIC_FLG, ";

		$sql .= "f.FORM_INPUT_NAME, ";
		$sql .= "f.FORM_INPUT_MAIL, ";
		$sql .= "f.FORM_INPUT_TEL, ";
		$sql .= "f.FORM_INPUT_ADDRES, ";
		$sql .= "f.FORM_INPUT_SEX, ";
		$sql .= "f.FORM_INPUT_JOB, ";
		$sql .= "f.FORM_INPUT_BIRTHDAY, ";
		$sql .= "f.FORM_INPUT_ETC, ";
		$sql .= "f.FORM_ADMIN_MEMO, ";

		$sql .= "f.FORM_REGIST_DATE, ";
		$sql .= "f.FORM_UP_DATE ";
		$sql .= "from ".form_make::tableName." f ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".form_make::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("FORM_PUBLIC_FLG", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}
	//	$sql .= "limit 0,6 ";

		$sql .= "order by FORM_ID desc ";

		parent::setCollection($sql, form_make::keyName);
//print $sql;
	}

	public function save() {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
// 		print_r($dataList);exit;
		$sql = "";
// 		if (parent::getKeyValue() < 0 or parent::getKeyValue() == "") {
		if (parent::saveDivide(parent::getKeyValue())) {
			$sql = $this->insert($dataList);
		}
		else {
			$sql = $this->update($dataList);
		}

		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".form_make::tableName." set ";
			$sql .= parent::expsData("FORM_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= form_make::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$this->db->commit();
		return true;
	}


	private function setBookinId($id) {
		$this->bookingId = $id;
	}
	public function getBookingId() {
		return $this->bookingId;
	}

	public function saveCouponForm($bookingcontArray,$is_request=false) {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());

	//	print_r($dataList);
		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
//		print_r($dataList);exit;
//			$dataList['COUPONBOOK_COUPONPLAN_CONTENTS']=$this->getPlanContentById($dataList['COUPONPLAN_ID']);
// 			echo $dataList['BOOKING_HOTELPLAN_CONTENTS'];exit;
			$sql = $this->insertCouponForm($dataList);
// 			echo $sql;exit;
	//	print_r(debug_backtrace());

		}
		else {
			//$sql = $this->update($dataList);
		}
 		
		//echo $sql;exit;
		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		if ($this->saveDivide($this->getKeyValue())) {
			$idData = new collection($this->db);
			$idData->lastInsert("FORMBOOK");
			$id = $idData->getByKey($idData->getKeyValue(), "id");
 			$bookingcontArray["FORMBOOK_ID"] = $id;
		}

		$this->setBookinId($id);

		//(ココトモのみ）
			
			
			$mMail = new mMail($this->db);
			//To user
			
			
			$mailid = !$is_request?form_make::formCoupon2user:form_make::mailBookingRequest2hotel;
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

			$body = cmReplace($body, "[!BOOKING_ID!]", $bookingcontArray["FORMBOOK_ID"]);

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
			

		$this->db->commit();
		return $bookingcontArray["FORMBOOK_ID"];



	}


	public function insertCouponForm($dataList) {
//	print_r($dataList);
		$sql  = "insert into FORMBOOK (";
		$sql .= "FORMBOOK_ID, ";
		$sql .= "MEMBER_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "COUPONSHOP_ID, ";
		$sql .= "COUPONPLAN_ID, ";

		$sql .= "FORMBOOK_REGIST_DATE, ";
		$sql .= "FORMBOOK_UP_DATE) values (";


 		$sql .= "null, ";
		$sql .= "'".$dataList["MEMBER_ID"]."', ";
		$sql .= "'".$dataList["COMPANY_ID"]."', ";
		$sql .= "'".$dataList["COUPONSHOP_ID"]."', ";
		$sql .= "'".$dataList["COUPONPLAN_ID"]."', ";

		$sql .= "now(), ";
		$sql .= "now()) ";
//	print $sql;

		return $sql;
	}




	public function insert($dataList) {
	print_r($dataList);
		$sql  = "insert into ".form_make::tableName." (";
		$sql .= "FORM_ID, ";
		$sql .= "FORM_NAME, ";
		$sql .= "FORM_CATEGORY, ";
		$sql .= "FORM_MEMBER_FLG, ";
		$sql .= "FORM_DUPLICATE_FLG, ";
		$sql .= "FORM_LIMIT_FLG, ";
		$sql .= "FORM_DATE_FROM, ";
		$sql .= "FORM_DATE_TO, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "FORM_IMG".$i.", ";
		}
		$sql .= "FORM_TITLE, ";
		$sql .= "FORM_TEXT, ";
		$sql .= "FORM_BTN_FLG, ";
		$sql .= "FORM_PUBLIC_FLG, ";

		$sql .= "FORM_INPUT_NAME, ";
		$sql .= "FORM_INPUT_MAIL, ";
		$sql .= "FORM_INPUT_TEL, ";
		$sql .= "FORM_INPUT_ADDRES, ";
		$sql .= "FORM_INPUT_SEX, ";
		$sql .= "FORM_INPUT_JOB, ";
		$sql .= "FORM_INPUT_BIRTHDAY, ";
		$sql .= "FORM_INPUT_ETC, ";
		$sql .= "FORM_ADMIN_MEMO, ";

		$sql .= "FORM_REGIST_DATE, ";
		$sql .= "FORM_UP_DATE) values (";


 		$sql .= "null, ";
		$sql .= "'".$dataList["FORM_NAME"]."', ";
		$sql .= "'".$dataList["FORM_CATEGORY"]."', ";
		$sql .= "'".$dataList["FORM_MEMBER_FLG"]."', ";
		$sql .= "'".$dataList["FORM_DUPLICATE_FLG"]."', ";
		$sql .= "'".$dataList["FORM_LIMIT_FLG"]."', ";
		$sql .= "'".$dataList["FORM_DATE_FROM"]."', ";
		$sql .= "'".$dataList["FORM_DATE_TO"]."', ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "'".$dataList["FORM_IMG".$i]."', ";
		}
		$sql .= "'".$dataList["FORM_TITLE"]."', ";
		$sql .= "'".$dataList["FORM_TEXT"]."', ";
		$sql .= "'".$dataList["FORM_BTN_FLG"]."', ";
		$sql .= "'".$dataList["FORM_PUBLIC_FLG"]."', ";

		$sql .= "'".$dataList["FORM_INPUT_NAME"]."', ";
		$sql .= "'".$dataList["FORM_INPUT_MAIL"]."', ";
		$sql .= "'".$dataList["FORM_INPUT_TEL"]."', ";
		$sql .= "'".$dataList["FORM_INPUT_ADDRES"]."', ";
		$sql .= "'".$dataList["FORM_INPUT_SEX"]."', ";
		$sql .= "'".$dataList["FORM_INPUT_JOB"]."', ";
		$sql .= "'".$dataList["FORM_INPUT_BIRTHDAY"]."', ";
		$sql .= "'".$dataList["FORM_INPUT_ETC"]."', ";
		$sql .= "'".$dataList["FORM_ADMIN_MEMO"]."', ";

		$sql .= "now(), ";
		$sql .= "now()) ";
//	print $sql;

		return $sql;
	}

	public function update($dataList) {
//	print_r($dataList);
		$sql .= "update ".form_make::tableName." set ";
		$sql .= "FORM_ID = '".$dataList["FORM_ID"]."', ";
		$sql .= "FORM_NAME = '".$dataList["FORM_NAME"]."', ";
		$sql .= "FORM_CATEGORY = '".$dataList["FORM_CATEGORY"]."', ";
		$sql .= "FORM_MEMBER_FLG = '".$dataList["FORM_MEMBER_FLG"]."', ";
		$sql .= "FORM_DUPLICATE_FLG = '".$dataList["FORM_DUPLICATE_FLG"]."', ";
		$sql .= "FORM_LIMIT_FLG = '".$dataList["FORM_LIMIT_FLG"]."', ";
		$sql .= "FORM_DATE_FROM = '".$dataList["FORM_DATE_FROM"]."', ";
		$sql .= "FORM_DATE_TO = '".$dataList["FORM_DATE_TO"]."', ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "FORM_IMG".$i." = '".$dataList["FORM_IMG".$i]."', ";
		}
		$sql .= "FORM_TITLE = '".$dataList["FORM_TITLE"]."', ";
		$sql .= "FORM_TEXT = '".$dataList["FORM_TEXT"]."', ";
		$sql .= "FORM_BTN_FLG = '".$dataList["FORM_BTN_FLG"]."', ";
		$sql .= "FORM_PUBLIC_FLG = '".$dataList["FORM_PUBLIC_FLG"]."', ";

		$sql .= "FORM_INPUT_NAME = '".$dataList["FORM_INPUT_NAME"]."', ";
		$sql .= "FORM_INPUT_MAIL = '".$dataList["FORM_INPUT_MAIL"]."', ";
		$sql .= "FORM_INPUT_TEL = '".$dataList["FORM_INPUT_TEL"]."', ";
		$sql .= "FORM_INPUT_ADDRES = '".$dataList["FORM_INPUT_ADDRES"]."', ";
		$sql .= "FORM_INPUT_SEX = '".$dataList["FORM_INPUT_SEX"]."', ";
		$sql .= "FORM_INPUT_JOB = '".$dataList["FORM_INPUT_JOB"]."', ";
		$sql .= "FORM_INPUT_BIRTHDAY = '".$dataList["FORM_INPUT_BIRTHDAY"]."', ";
		$sql .= "FORM_INPUT_ETC = '".$dataList["FORM_INPUT_ETC"]."', ";
		$sql .= "FORM_ADMIN_MEMO = '".$dataList["FORM_ADMIN_MEMO"]."', ";

		$sql .= "FORM_UP_DATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  form_make::keyName." = ".parent::getKeyValue() ;
//	print $sql;

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotel::tableName." set ";
		$sql .= parent::expsData("FORM_PUBLIC_FLG", "=", 3).", ";
		$sql .= parent::expsData("FORM_DELITE_DATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(form_make::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusPublic() {
		$this->db->begin();

		$sql .= "update ".form_make::tableName." set ";
		$sql .= parent::expsData("FORM_PUBLIC_FLG", "=", 2).", ";
		$sql .= parent::expsData("FORM_UP_DATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(form_make::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusDisabled() {
		$this->db->begin();

		$sql .= "update ".form_make::tableName." set ";
		$sql .= parent::expsData("FORM_PUBLIC_FLG", "=", 1).", ";
		$sql .= parent::expsData("FORM_UP_DATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(form_make::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "FORM_NAME"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "FORM_NAME"), 100)) {
				parent::setError("FORM_NAME", "100文字以内で入力して下さい");
			}
		}
/*
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"), CHK_PTN_ZIPCODE_JP)) {
				parent::setError("HOTEL_ZIP", "郵便番号は000-0000の形式で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"), 50)) {
				parent::setError("HOTEL_CITY", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"), 50)) {
				parent::setError("HOTEL_ADDRESS", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"), CHK_PTN_TEL)) {
				parent::setError("HOTEL_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
			}
		}
*/
		/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME"))) {
			parent::setError("HOTEL_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME"), 50)) {
			parent::setError("HOTEL_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"))) {
			parent::setError("HOTEL_NAME_KANA", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"), 50)) {
			parent::setError("HOTEL_NAME_KANA", "50文字以内で入力して下さい");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"), CHK_PTN_KANA)) {
			parent::setError("HOTEL_NAME_KANA", "全角カナで入力して下さい");
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FLG_KIND"))) {
			parent::setError("HOTEL_FLG_KIND", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FLG_PUBLIC"))) {
			parent::setError("HOTEL_FLG_PUBLIC", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"))) {
			parent::setError("HOTEL_ZIP", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"), CHK_PTN_ZIPCODE_JP)) {
			parent::setError("HOTEL_ZIP", "郵便番号は000-0000の形式で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_PREF"))) {
			parent::setError("HOTEL_PREF", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"))) {
			parent::setError("HOTEL_CITY", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"), 50)) {
			parent::setError("HOTEL_CITY", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"))) {
			parent::setError("HOTEL_ADDRESS", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"), 50)) {
			parent::setError("HOTEL_ADDRESS", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"))) {
			parent::setError("HOTEL_TEL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"), CHK_PTN_TEL)) {
			parent::setError("HOTEL_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
		}
		*/

		if (parent::getByKey(parent::getKeyValue(), "FORM_IMG_APP_setup") != "") {
			$this->setByKey($this->getKeyValue(), "FORM_IMG_APP", $this->getByKey($this->getKeyValue(), "FORM_IMG_APP_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "FORM_ID"));
			$msg = $inputer->upload("FORM_IMG_APP", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("FORM_IMG_APP", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "FORM_IMG_APP", $msg);
			}
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "FORM_IMG".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "FORM_IMG".$i, $this->getByKey($this->getKeyValue(), "FORM_IMG".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "FORM_ID"));
//				$this->setByKey($this->getKeyValue(), "EVENT_PIC".$i, $this->getByKey($this->getKeyValue(), "EVENT_PIC".$i."_input"));
				$msg = $inputer->upload("FORM_IMG".$i, IMG_HOTEL_FAC_SIZE, IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("FORM_IMG".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "FORM_IMG".$i, $msg);
				}

			}
		}
/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_PARKING"))) {
			parent::setError("HOTEL_PARKING", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_SEND"))) {
			parent::setError("HOTEL_SEND", "必須項目です");
		}


		for ($i=1; $i<=3; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=4; $i<=5; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 4)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 6;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
				parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=7; $i<=8; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 4)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 9;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
				parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=10; $i<=11; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 4)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		for ($i=12; $i<=15; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=30; $i<=49; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 10)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "10文字以内で入力して下さい");
				}
			}
		}

		for ($i=1; $i<=2; $i++) {

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_NUM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_NUM".$i), CHK_PTN_NUM)) {
					parent::setError("HOTEL_FACILITY_NUM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_NUM".$i), 3)) {
					parent::setError("HOTEL_FACILITY_NUM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_FROM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_FROM".$i), CHK_PTN_NUM)) {
					parent::setError("HOTEL_FACILITY_FROM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_FROM".$i), 3)) {
					parent::setError("HOTEL_FACILITY_FROM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_TO".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_TO".$i), CHK_PTN_NUM)) {
					parent::setError("HOTEL_FACILITY_TO".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_TO".$i), 3)) {
					parent::setError("HOTEL_FACILITY_TO".$i, "3文字以内で入力して下さい");
				}
			}

		}
*/


	}

	public function setPost($picFLg=false) {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}
			if (count($_POST["undecide_sch"]) == "") {
				$this->setByKey($this->getKeyValue(), "search_date", date('Y年m月d日'));
				$this->setByKey($this->getKeyValue(), "undecide_sch", "1");
			}
			else {
				$this->setByKey($this->getKeyValue(), "search_date", parent::getByKey(parent::getKeyValue(), "search_date"));
				$this->setByKey($this->getKeyValue(), "undecide_sch", "2");
			}

			$dataCategory = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataCategory != "") {
						$dataCategory .= ":";
					}
					$dataCategory .= $d;
				}
				$this->setByKey($this->getKeyValue(), "EVENT_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "EVENT_CATEGORY", '');
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "EVENT_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "EVENT_AREA", '');
			}

		}

	}


}
?>