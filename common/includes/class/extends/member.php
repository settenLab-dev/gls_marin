<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mMail.php');
class member extends collection {
	const tableName = "MEMBER";
	const keyName = "MEMBER_ID";
	const tableKeyName = "MEMBER_ID";
	const mailRegistId = 1;
	const mailRegistUrl = "registmail.html";
	const mailRegistUrl2 = "registmail_event.html";
	const mailResetId = 22;
	const mailResetUrl = "reset_password.html";
	
	const mailFinishedId = 24;
	const mailOutId = 7;
	
	public function member($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= parent::decryptionList("MEMBER_KEY1, MEMBER_KEY2").", ";
		$sql .= "MEMBER_ID, MEMBER_SEX, M_MEMBER_WORK_ID, MEMBER_PREF, MEMBER_FLG_MAILMAGAZINE, MEMBER_POINT, MEMBER_STATUS, MEMBER_DATE_UPDATE, MEMBER_DATE_REGIST, ";
		$sql .= parent::decryptionList("MEMBER_LOGIN_ID, MEMBER_LOGIN_PASSWORD, MEMBER_MAILADDRESS_SUB, MEMBER_NAME1, MEMBER_NAME2").", ";
		$sql .= parent::decryptionList("MEMBER_NAME_KANA1, MEMBER_NAME_KANA2, MEMBER_HANDLENAME, MEMBER_BIRTH_YEAR, MEMBER_BIRTH_MONTH, MEMBER_BIRTH_DAY").", ";
		$sql .= parent::decryptionList("MEMBER_ZIP, MEMBER_CITY, MEMBER_ADDRESS, MEMBER_BUILD, MEMBER_TEL1, MEMBER_TEL2")." ";
		$sql .= "from ".member::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".member::keyName, "=", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_NAME1") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_NAME1", "like", "%".$collection->getByKey($collection->getKeyValue(), "MEMBER_NAME1")."%", true, 4)." ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_NAME2") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_NAME2", "like", "%".$collection->getByKey($collection->getKeyValue(), "MEMBER_NAME2")."%", true, 4)." ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_NAME_KANA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "(";
			$where .= parent::expsData("MEMBER_NAME_KANA1", "like", "%".$collection->getByKey($collection->getKeyValue(), "MEMBER_NAME_KANA1")."%", true, 4)." ";
			$where .= " or ";
			$where .= parent::expsData("MEMBER_NAME_KANA2", "like", "%".$collection->getByKey($collection->getKeyValue(), "MEMBER_NAME_KANA2")."%", true, 4)." ";
			$where .= ") ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_LOGIN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_LOGIN_ID", "like", "%".$collection->getByKey($collection->getKeyValue(), "MEMBER_LOGIN_ID")."%", true, 4)." ";
		}


		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_LOGIN_PASSWORD") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_LOGIN_PASSWORD", "like", "%".$collection->getByKey($collection->getKeyValue(), "MEMBER_LOGIN_PASSWORD")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "MEMBER_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_STATUS", "in", "(2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by MEMBER_ID desc ";

		parent::setCollection($sql, member::keyName);
	}

	public function select($id="", $statusComma="", $key1="", $key2="") {
		$sql  = "select ";
		$sql .= "MEMBER_ID, MEMBER_SEX, M_MEMBER_WORK_ID, MEMBER_PREF, MEMBER_FLG_MAILMAGAZINE, MEMBER_POINT, MEMBER_STATUS, ";
		$sql .= parent::decryptionList("MEMBER_LOGIN_ID, MEMBER_LOGIN_PASSWORD, MEMBER_MAILADDRESS_SUB, MEMBER_NAME1, MEMBER_NAME2").", ";
		$sql .= parent::decryptionList("MEMBER_NAME_KANA1, MEMBER_NAME_KANA2, MEMBER_HANDLENAME, MEMBER_BIRTH_YEAR, MEMBER_BIRTH_MONTH, MEMBER_BIRTH_DAY").", ";
		$sql .= parent::decryptionList("MEMBER_ZIP, MEMBER_CITY, MEMBER_ADDRESS, MEMBER_BUILD, MEMBER_TEL1, MEMBER_TEL2")." ";
		$sql .= "from ".member::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".member::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("MEMBER_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($key1 != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= " ".parent::expsData("MEMBER_KEY1", "=", $key1, true, 1)." ";
		}

		if ($key2 != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= " ".parent::expsData("MEMBER_KEY2", "=", $key2, true, 1)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by MEMBER_ID desc ";

		parent::setCollection($sql, member::keyName);
	}

	public  function selectDuplication($id, $loginId) {
		$sql  = "select ";
		$sql .= "MEMBER_ID ";
		$sql .= "from ".member::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("MEMBER_STATUS", "<>", 4)." and ";
		$sql .= parent::expsData("MEMBER_STATUS", "<>", 3)." and ";
		$sql .= parent::expsData("MEMBER_LOGIN_ID", "=", $loginId, true, 1)." ";
		if ($id != "") {
			$sql .= "and ".parent::expsData(member::keyName, "<>", $id)." ";
		}
		parent::setCollection($sql, member::keyName);
	}
	
	public function selectInUse($id, $loginId) {
		$sql  = "select ";
		$sql .= "MEMBER_ID , ";
		$sql .= parent::decryptionList("MEMBER_KEY1")." ";;
		$sql .= "from ".member::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("MEMBER_STATUS", "<>", 4)." and ";
		$sql .= parent::expsData("MEMBER_STATUS", "<>", 3)." and ";
		$sql .= parent::expsData("MEMBER_LOGIN_ID", "=", $loginId, true, 1)." ";
		
		if ($id != "") {
			$sql .= "and ".parent::expsData(member::keyName, "<>", $id)." ";
		}
		parent::setCollection($sql, member::keyName);
	}

	public  function selectDuplicationNickname($id, $nickname) {
		$sql  = "select ";
		$sql .= "MEMBER_ID ";
		$sql .= "from ".member::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("MEMBER_STATUS", "<>", 4)." and ";
		$sql .= parent::expsData("MEMBER_STATUS", "<>", 3)." and ";
		$sql .= parent::expsData("MEMBER_HANDLENAME", "=", $nickname, true, 1)." ";
		if ($id != "") {
			$sql .= "and ".parent::expsData(member::keyName, "<>", $id)." ";
		}
		parent::setCollection($sql, member::keyName);
	}

	public function saveBirth(){
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		parent::getKeyValue()?parent::getKeyValue():parent::setKeyValue($dataList[member::keyName]);
		$sql .= "update ".member::tableName." set ";
		$sql .= parent::expsData("MEMBER_BIRTH_YEAR", "=", $dataList["MEMBER_BIRTH_YEAR"],true,1).", ";
		$sql .= parent::expsData("MEMBER_BIRTH_MONTH", "=", $dataList["MEMBER_BIRTH_MONTH"],true,1).", ";
		$sql .= parent::expsData("MEMBER_BIRTH_DAY", "=", $dataList["MEMBER_BIRTH_DAY"],true,1)." ";
	
		$sql .= "where ";
		$sql .=  parent::expsData(member::keyName, "=", parent::getKeyValue())." ";
		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}
		$this->db->commit();
		return true;
	}
	
	public function save() {
		$this->db->begin();

		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		
		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
			$sess = session_id();
			$sess = sha1($sess);
			$time = time();
			$time = sha1($time);
			parent::setByKey(parent::getKeyValue(), "MEMBER_KEY1", $sess);
			parent::setByKey(parent::getKeyValue(), "MEMBER_KEY2", $time);
			parent::setByKey(parent::getKeyValue(), "MEMBER_STATUS", 1);
			$sql = $this->insert($dataList);
		}
		else {
			$sql = $this->update($dataList);
		}

		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}
		
		
		
		if($dataList['regist'] == '退会する') $this->mails(member::mailOutId);
		if($dataList['regist'] == '登録する') $this->mails(member::mailFinishedId);
		
		$this->db->commit();
		
		return true;
	}

	public function save2() {
		$this->db->begin();

		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		
		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
			$sess = session_id();
			$sess = sha1($sess);
			$time = time();
			$time = sha1($time);
			parent::setByKey(parent::getKeyValue(), "MEMBER_KEY1", $sess);
			parent::setByKey(parent::getKeyValue(), "MEMBER_KEY2", $time);
			parent::setByKey(parent::getKeyValue(), "MEMBER_STATUS", 1);
			$sql = $this->insert2($dataList);
		}
		else {
			$sql = $this->update($dataList);
		}

		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}
		
		
		
		if($dataList['regist'] == '退会する') $this->mails(member::mailOutId);
		if($dataList['regist'] == '登録する') $this->mails(member::mailFinishedId);
		
		$this->db->commit();
		
		return true;
	}


	public function mails($mailid){
		$this->db->begin();
		
		$mMail = new mMail($this->db);
		$mMail->select($mailid);
		if ($mMail->getCount() != 1) {
			parent::setErrorFirst("仮登録メールの取得に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		$from = MAIL_SLAKER_NOREPLY;
		$to = parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID");
		$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
		$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");
		
// 		echo $from.'<BR>'.$to.'<BR>'.$subject.'<BR>'.$body;exit;
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("仮登録メールの送信に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		//return true;
		
	}
	
	public function saveNewPwd(){
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		
		$sql .= "update ".member::tableName." set ";
		$sql .= parent::expsData("MEMBER_LOGIN_PASSWORD", "=", $dataList["MEMBER_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_KEY2", "=", $_GET["key"], true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData("MEMBER_KEY1", "=", $_GET['id'], true, 1)." ";

		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}
		
		$this->db->commit();
		return true;
	}
	
	public function saveRegist() {
		$this->db->begin();

		$sess = session_id();
		$sess = sha1($sess);
		$time = time();
		$time = sha1($time);
		parent::setByKey(parent::getKeyValue(), "MEMBER_KEY1", $sess);
		parent::setByKey(parent::getKeyValue(), "MEMBER_KEY2", $time);
		parent::setByKey(parent::getKeyValue(), "MEMBER_STATUS", 1);

		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		$sql = "";
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

		$mMail = new mMail($this->db);
		$mMail->select(member::mailRegistId);
		if ($mMail->getCount() != 1) {
			parent::setErrorFirst("仮登録メールの取得に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}

		$from = MAIL_SLAKER_NOREPLY;
		$to = parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID");
		$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
		$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");
		$body = cmReplace($body, "[!URL!]", URL_PUBLIC_SSL.member::mailRegistUrl."?guid=on&id=".$sess."&key=".$time);
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("仮登録メールの送信に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function saveRegist2() {
		$this->db->begin();

		$sess = session_id();
		$sess = sha1($sess);
		$time = time();
		$time = sha1($time);
		parent::setByKey(parent::getKeyValue(), "MEMBER_KEY1", $sess);
		parent::setByKey(parent::getKeyValue(), "MEMBER_KEY2", $time);
		parent::setByKey(parent::getKeyValue(), "MEMBER_STATUS", 1);

		$dataList = parent::getCollectionByKey(parent::getKeyValue());

		$sql = "";
		if (parent::saveDivide(parent::getKeyValue())) {
			$sql = $this->insert2($dataList);
		}
		else {
			$sql = $this->update($dataList);
		}

		if (!$this->saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$mMail = new mMail($this->db);
		$mMail->select(member::mailRegistId);
		if ($mMail->getCount() != 1) {
			parent::setErrorFirst("仮登録メールの取得に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}

		$from = MAIL_SLAKER_NOREPLY;
		$to = parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID");
		$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
		$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");
		$body = cmReplace($body, "[!URL!]", URL_PUBLIC_SSL.member::mailRegistUrl2."?guid=on&id=".$sess."&key=".$time);
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("仮登録メールの送信に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	
	public function reset_email(){
		$mMail = new mMail($this->db);
		$mMail->select(member::mailResetId);
		if ($mMail->getCount() != 1) {
			parent::setErrorFirst("パスワードリマインダーメールの取得に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		$from = MAIL_SLAKER_NOREPLY;
		$to = parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID");
		$subject = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_TITLE");
		$body = $mMail->getByKey($mMail->getKeyValue(), "M_MAIL_CONTENTS");
		
		$this->selectInUse('', parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"));
		$sess = parent::getBykey(parent::getKeyValue(), "MEMBER_KEY1");
		$time = time();
		$time = sha1($time);
		
		$body = cmReplace($body, "[!URL!]", URL_PUBLIC.member::mailResetUrl."?id=".$sess."&key=".$time);
		if (!cmMailSendQueue($from, $to, $subject, $body)) {
			parent::setErrorFirst("仮登録メールの送信に失敗しました。");
			parent::setErrorFirst("大変お手数ですが管理者にお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}
		
		return true;
	}
	
	public function insert($dataList) {
		$sql  = "insert into ".member::tableName." (";
		$sql .= "MEMBER_ID, ";
		$sql .= "MEMBER_KEY1, ";
		$sql .= "MEMBER_KEY2, ";
		$sql .= "MEMBER_LOGIN_ID, ";
		$sql .= "MEMBER_LOGIN_PASSWORD, ";
		$sql .= "MEMBER_MAILADDRESS_SUB, ";
		$sql .= "MEMBER_NAME1, ";
		$sql .= "MEMBER_NAME2, ";
		$sql .= "MEMBER_NAME_KANA1, ";
		$sql .= "MEMBER_NAME_KANA2, ";
		$sql .= "MEMBER_HANDLENAME, ";
		$sql .= "MEMBER_SEX, ";
		$sql .= "MEMBER_BIRTH_YEAR, ";
		$sql .= "MEMBER_BIRTH_MONTH, ";
		$sql .= "MEMBER_BIRTH_DAY, ";
		$sql .= "M_MEMBER_WORK_ID, ";
		$sql .= "MEMBER_ZIP, ";
		$sql .= "MEMBER_PREF, ";
		$sql .= "MEMBER_CITY, ";
		$sql .= "MEMBER_ADDRESS, ";
		$sql .= "MEMBER_BUILD, ";
		$sql .= "MEMBER_TEL1, ";
		$sql .= "MEMBER_TEL2, ";
		$sql .= "MEMBER_FLG_MAILMAGAZINE, ";
		$sql .= "MEMBER_STATUS, ";
		$sql .= "MEMBER_DATE_REGIST, ";
		$sql .= "MEMBER_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["MEMBER_KEY1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_KEY2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_LOGIN_ID"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_MAILADDRESS_SUB"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME_KANA1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME_KANA2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_HANDLENAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_SEX"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BIRTH_YEAR"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BIRTH_MONTH"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BIRTH_DAY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_MEMBER_WORK_ID"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_PREF"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BUILD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_TEL1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_TEL2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_FLG_MAILMAGAZINE"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_STATUS"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function insert2($dataList) {
		$sql  = "insert into ".member::tableName." (";
		$sql .= "MEMBER_ID, ";
		$sql .= "MEMBER_KEY1, ";
		$sql .= "MEMBER_KEY2, ";
		$sql .= "MEMBER_LOGIN_ID, ";
		$sql .= "MEMBER_LOGIN_PASSWORD, ";
		$sql .= "MEMBER_MAILADDRESS_SUB, ";
		$sql .= "MEMBER_NAME1, ";
		$sql .= "MEMBER_NAME2, ";
		$sql .= "MEMBER_NAME_KANA1, ";
		$sql .= "MEMBER_NAME_KANA2, ";
		$sql .= "MEMBER_HANDLENAME, ";
		$sql .= "MEMBER_SEX, ";
		$sql .= "MEMBER_BIRTH_YEAR, ";
		$sql .= "MEMBER_BIRTH_MONTH, ";
		$sql .= "MEMBER_BIRTH_DAY, ";
		$sql .= "M_MEMBER_WORK_ID, ";
		$sql .= "MEMBER_ZIP, ";
		$sql .= "MEMBER_PREF, ";
		$sql .= "MEMBER_CITY, ";
		$sql .= "MEMBER_ADDRESS, ";
		$sql .= "MEMBER_BUILD, ";
		$sql .= "MEMBER_TEL1, ";
		$sql .= "MEMBER_TEL2, ";
		$sql .= "MEMBER_FLG_MAILMAGAZINE, ";
		$sql .= "MEMBER_STATUS, ";
		$sql .= "MEMBER_EVENT_FLG, ";
		$sql .= "MEMBER_DATE_REGIST, ";
		$sql .= "MEMBER_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["MEMBER_KEY1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_KEY2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_LOGIN_ID"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_MAILADDRESS_SUB"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME_KANA1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_NAME_KANA2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_HANDLENAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_SEX"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BIRTH_YEAR"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BIRTH_MONTH"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BIRTH_DAY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_MEMBER_WORK_ID"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_PREF"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_BUILD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_TEL1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_TEL2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["MEMBER_FLG_MAILMAGAZINE"]).", ";
		$sql .= parent::expsVal($dataList["MEMBER_STATUS"]).", ";
		$sql .= "now(), ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}
	public function update($dataList) {
		$sql .= "update ".member::tableName." set ";
		$sql .= parent::expsData("MEMBER_LOGIN_ID", "=", $dataList["MEMBER_LOGIN_ID"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_LOGIN_PASSWORD", "=", $dataList["MEMBER_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_MAILADDRESS_SUB", "=", $dataList["MEMBER_MAILADDRESS_SUB"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_NAME1", "=", $dataList["MEMBER_NAME1"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_NAME2", "=", $dataList["MEMBER_NAME2"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_NAME_KANA1", "=", $dataList["MEMBER_NAME_KANA1"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_NAME_KANA2", "=", $dataList["MEMBER_NAME_KANA2"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_HANDLENAME", "=", $dataList["MEMBER_HANDLENAME"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_SEX", "=", $dataList["MEMBER_SEX"]).", ";
		$sql .= parent::expsData("MEMBER_BIRTH_YEAR", "=", $dataList["MEMBER_BIRTH_YEAR"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_BIRTH_MONTH", "=", $dataList["MEMBER_BIRTH_MONTH"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_BIRTH_DAY", "=", $dataList["MEMBER_BIRTH_DAY"], true, 1).", ";
		$sql .= parent::expsData("M_MEMBER_WORK_ID", "=", $dataList["M_MEMBER_WORK_ID"]).", ";
		$sql .= parent::expsData("MEMBER_ZIP", "=", $dataList["MEMBER_ZIP"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_PREF", "=", $dataList["MEMBER_PREF"]).", ";
		$sql .= parent::expsData("MEMBER_CITY", "=", $dataList["MEMBER_CITY"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_ADDRESS", "=", $dataList["MEMBER_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_BUILD", "=", $dataList["MEMBER_BUILD"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_TEL1", "=", $dataList["MEMBER_TEL1"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_TEL2", "=", $dataList["MEMBER_TEL2"], true, 1).", ";
		$sql .= parent::expsData("MEMBER_FLG_MAILMAGAZINE", "=", $dataList["MEMBER_FLG_MAILMAGAZINE"]).", ";
		$sql .= parent::expsData("MEMBER_STATUS", "=", $dataList["MEMBER_STATUS"]).", ";
		$sql .= parent::expsData("MEMBER_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(member::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".member::tableName." set ";
		$sql .= parent::expsData("MEMBER_STATUS", "=", 4).", ";
		$sql .= parent::expsData("MEMBER_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(member::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function savePoint($pointHistory) {
		$this->db->begin();

		//	ポイント履歴更新
		if (!$pointHistory->save()) {
			$this->setErrorFirst("ポイント履歴情報の保存に失敗しました。");
			$this->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}

		//	会員ポイント合計更新
		if (!$this->updatePointPlus($pointHistory->getByKey($pointHistory->getKeyValue(), "POINT_HISTORY_NUM"))) {
			$this->setErrorFirst("ポイント情報の保存に失敗しました。");
			$this->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
			$this->db->rollback();
			return false;
		}


		$this->db->commit();
		return true;
	}

	public function updatePointPlus($diff) {
		$this->db->begin();
		
		
		$sql .= "update ".member::tableName." set ";
 		$sql .= "MEMBER_POINT = MEMBER_POINT + ".$diff." , ";
//		$sql .= "MEMBER_POINT = IFNULL(".$diff.", MEMBER_POINT + ".$diff."), ";
 		$sql .= parent::expsData("MEMBER_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(member::keyName, "=", parent::getKeyValue())." ";
//		print_r($sql);
//		exit;
			
		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}


	public function selectLogin(&$data) {
		$sql  = "select ";
		$sql .= "MEMBER_ID, MEMBER_SEX, M_MEMBER_WORK_ID, MEMBER_PREF, MEMBER_FLG_MAILMAGAZINE, MEMBER_STATUS, MEMBER_POINT, ";
		$sql .= parent::decryptionList("MEMBER_LOGIN_ID, MEMBER_LOGIN_PASSWORD, MEMBER_MAILADDRESS_SUB, MEMBER_NAME1, MEMBER_NAME2").", ";
		$sql .= parent::decryptionList("MEMBER_NAME_KANA1, MEMBER_NAME_KANA2, MEMBER_HANDLENAME, MEMBER_BIRTH_YEAR, MEMBER_BIRTH_MONTH, MEMBER_BIRTH_DAY").", ";
		$sql .= parent::decryptionList("MEMBER_ZIP, MEMBER_CITY, MEMBER_ADDRESS, MEMBER_BUILD, MEMBER_TEL1, MEMBER_TEL2")." ";
		$sql .= "from ".member::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("MEMBER_STATUS", "in", "(2)")." ";
		$sql .= "and ".parent::expsData("MEMBER_LOGIN_ID", "=", $data->getByKey($data->getKeyValue(), "MEMBER_LOGIN_ID"), true, 1)." ";
		$sql .= "and ".parent::expsData("MEMBER_LOGIN_PASSWORD", "=", $data->getByKey($data->getKeyValue(), "MEMBER_LOGIN_PASSWORD"), true, 1)." ";
//print_r($sql);
		parent::setCollection($sql, member::keyName);
	}

	public function selectLoginCookie() {
		$sql  = "select ";
		$sql .= "MEMBER_ID, MEMBER_SEX, M_MEMBER_WORK_ID, MEMBER_PREF, MEMBER_FLG_MAILMAGAZINE, MEMBER_STATUS, MEMBER_POINT, ";
		$sql .= parent::decryptionList("MEMBER_LOGIN_ID, MEMBER_LOGIN_PASSWORD, MEMBER_MAILADDRESS_SUB, MEMBER_NAME1, MEMBER_NAME2").", ";
		$sql .= parent::decryptionList("MEMBER_NAME_KANA1, MEMBER_NAME_KANA2, MEMBER_HANDLENAME, MEMBER_BIRTH_YEAR, MEMBER_BIRTH_MONTH, MEMBER_BIRTH_DAY").", ";
		$sql .= parent::decryptionList("MEMBER_ZIP, MEMBER_CITY, MEMBER_ADDRESS, MEMBER_BUILD, MEMBER_TEL1, MEMBER_TEL2")." ";
		$sql .= "from ".member::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("MEMBER_STATUS", "in", "(2)")." ";
		$sql .= "and ".parent::expsData("MEMBER_LOGIN_ID", "=", $_COOKIE[SITE_COOKIE_PUBLIC_ID], true, 1)." ";
		$sql .= "and ".parent::expsData("MEMBER_LOGIN_PASSWORD", "=", $_COOKIE[SITE_COOKIE_PUBLIC_PASS], true, 1)." ";

		parent::setCollection($sql, member::keyName);
	}

	public function checkLogin() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"))) {
			parent::setError("MEMBER_LOGIN_ID", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"))) {
			parent::setError("MEMBER_LOGIN_PASSWORD", "必須項目です");
		}
	}
	
  	public function checkRegist_forgetPWD(){
  		if (!$_POST) return;
  		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"))) {
  			parent::setError("MEMBER_LOGIN_PASSWORD", "必須項目です");
  		}
  		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"), CHK_PTN_WORDNUM)) {
  			parent::setError("MEMBER_LOGIN_PASSWORD", "半角英数字で入力して下さい");
  		}
  		elseif (!cmCheckLengthBetween(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"),15, 4)) {
  			parent::setError("MEMBER_LOGIN_PASSWORD", "4～15文字以内で入力して下さい");
  		}
  		
  		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))) {
  			parent::setError("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, "必須項目です");
  		}
  		else {
  			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))) {
  				if (parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD") != parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM)) {
  					parent::setError("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, "パスワードと確認用が一致していません");
  				}
  			}
  		}
  	}
	public function checkRegist_forget(){
		if (!$_POST) return;
		
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"))) {
			parent::setError("MEMBER_LOGIN_ID", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"), CHK_PTN_MAILADDRESS)) {
			parent::setError("MEMBER_LOGIN_ID", "メールアドレスの形式を確認して下さい。");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"), 100)) {
			parent::setError("MEMBER_LOGIN_ID", "100文字以内で入力して下さい");
		}
		else {
			$memberInUse = new member($this->db);
			$memberInUse->selectInUse(parent::getKeyValue(), parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"));
			if ($memberInUse->getCount() == 0) {
				parent::setError("MEMBER_LOGIN_ID", "メールアドレスが無効です");
			}
		}
	}
	
	public function checkRegist1() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"))) {
			parent::setError("MEMBER_LOGIN_ID", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"), CHK_PTN_MAILADDRESS)) {
			parent::setError("MEMBER_LOGIN_ID", "メールアドレスの形式を確認して下さい。");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"), 100)) {
			parent::setError("MEMBER_LOGIN_ID", "100文字以内で入力して下さい");
		}
		else {
			$memberInUse = new member($this->db);
			$memberInUse->selectInUse(parent::getKeyValue(), parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"));
			if ($memberInUse->getCount() > 0) {
				parent::setError("MEMBER_LOGIN_ID", "既に登録されています");
			}
		}
		/**
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"))) {
			parent::setError("MEMBER_LOGIN_PASSWORD", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"), CHK_PTN_WORDNUM)) {
			parent::setError("MEMBER_LOGIN_PASSWORD", "半角英数字で入力して下さい");
		}
		elseif (!cmCheckLengthBetween(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"),15, 4)) {
			parent::setError("MEMBER_LOGIN_PASSWORD", "4～15文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))) {
			parent::setError("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, "必須項目です");
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))) {
				if (parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD") != parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM)) {
					parent::setError("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, "パスワードと確認用が一致していません");
				}
			}
		}
		*/

	}

	public function check($flgIdCheck=true) {
		if (!$_POST) return;

		//if ($flgIdCheck) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"))) {
				parent::setError("MEMBER_LOGIN_ID", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"), CHK_PTN_MAILADDRESS)) {
				parent::setError("MEMBER_LOGIN_ID", "メールアドレスの形式を確認して下さい。");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"), 100)) {
				parent::setError("MEMBER_LOGIN_ID", "100文字以内で入力して下さい");
			}
			else {
				$memberDuplication = new member($this->db);
				$memberDuplication->selectDuplication(parent::getKeyValue(), parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_ID"));
				if ($memberDuplication->getCount() > 0) {
					parent::setError("MEMBER_LOGIN_ID", "既に登録されています");
				}
			}
			
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"))) {
				parent::setError("MEMBER_LOGIN_PASSWORD", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"), CHK_PTN_WORDNUM)) {
				parent::setError("MEMBER_LOGIN_PASSWORD", "半角英数字で入力して下さい");
			}
			elseif (!cmCheckLengthBetween(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD"),15, 4)) {
				parent::setError("MEMBER_LOGIN_PASSWORD", "4～15文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))) {
				parent::setError("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, "必須項目です");
			}
			else {
				if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))) {
					if (parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD") != parent::getByKey(parent::getKeyValue(), "MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM)) {
						parent::setError("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM, "パスワードと確認用が一致していません");
					}
				}
			}
			
		//}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_MAILADDRESS_SUB"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_MAILADDRESS_SUB"), CHK_PTN_MAILADDRESS)) {
				parent::setError("MEMBER_MAILADDRESS_SUB", "メールアドレスの形式を確認して下さい。");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_MAILADDRESS_SUB"), 100)) {
				parent::setError("MEMBER_MAILADDRESS_SUB", "100文字以内で入力して下さい");
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME1"))) {
			parent::setError("MEMBER_NAME1", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME1"), 100)) {
			parent::setError("MEMBER_NAME1", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME2"))) {
			parent::setError("MEMBER_NAME2", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME2"), 100)) {
			parent::setError("MEMBER_NAME2", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME_KANA1"))) {
			parent::setError("MEMBER_NAME_KANA1", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME_KANA1"), 100)) {
			parent::setError("MEMBER_NAME_KANA1", "100文字以内で入力して下さい");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME_KANA1"), CHK_PTN_KANA)) {
			parent::setError("MEMBER_NAME_KANA1", "全角カナで入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME_KANA2"))) {
			parent::setError("MEMBER_NAME_KANA2", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME_KANA2"), 100)) {
			parent::setError("MEMBER_NAME_KANA2", "100文字以内で入力して下さい");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_NAME_KANA2"), CHK_PTN_KANA)) {
			parent::setError("MEMBER_NAME_KANA2", "全角カナで入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_HANDLENAME"))) {
			parent::setError("MEMBER_HANDLENAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_HANDLENAME"), 100)) {
			parent::setError("MEMBER_HANDLENAME", "100文字以内で入力して下さい");
		}
		else {
			$memberDuplication = new member($this->db);
			$memberDuplication->selectDuplicationNickname(parent::getKeyValue(), parent::getByKey(parent::getKeyValue(), "MEMBER_HANDLENAME"));
			if ($memberDuplication->getCount() > 0) {
				parent::setError("MEMBER_HANDLENAME", "既に登録されています");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_SEX"))) {
			parent::setError("MEMBER_SEX", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_BIRTH_YEAR"))) {
			parent::setError("birthday", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_BIRTH_MONTH"))) {
			parent::setError("birthday", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_BIRTH_DAY"))) {
			parent::setError("birthday", "必須項目です");
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ZIP"))) {
			parent::setError("MEMBER_ZIP", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_ZIP"), CHK_PTN_ZIPCODE_JP)) {
			parent::setError("MEMBER_ZIP", "郵便番号は000-0000の形式で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_PREF"))) {
			parent::setError("MEMBER_PREF", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_CITY"))) {
			parent::setError("MEMBER_CITY", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_CITY"), 100)) {
			parent::setError("MEMBER_CITY", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_ADDRESS"))) {
			parent::setError("MEMBER_ADDRESS", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_ADDRESS"), 50)) {
			parent::setError("MEMBER_ADDRESS", "50文字以内で入力して下さい");
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_BUILD"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "MEMBER_BUILD"), 50)) {
				parent::setError("MEMBER_BUILD", "50文字以内で入力して下さい");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_TEL1"))) {
			parent::setError("MEMBER_TEL1", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_TEL1"), CHK_PTN_TEL)) {
			parent::setError("MEMBER_TEL1", "電話番号は00-0000-0000の形式で入力して下さい");
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_TEL2"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "MEMBER_TEL2"), CHK_PTN_TEL)) {
				parent::setError("MEMBER_TEL2", "電話番号は00-0000-0000の形式で入力して下さい");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_FLG_MAILMAGAZINE"))) {
			parent::setError("MEMBER_FLG_MAILMAGAZINE", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "MEMBER_STATUS"))) {
			parent::setError("MEMBER_STATUS", "必須項目です");
		}

	}


	public function setPost() {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

// 			$dataPage = "";
// 			if (count($_POST["page"]) > 0) {
// 				foreach ($_POST["page"] as $d) {
// 					if ($dataPage != "") {
// 						$dataPage .= ",";
// 					}
// 					$dataPage .= $d;
// 				}
// 				$this->setByKey($this->getKeyValue(), "REQRUIT_CONTENTS", $dataPage);
// 			}
		}

	}


}
?>