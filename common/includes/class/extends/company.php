<?php
class company extends collection {
	const tableName = "COMPANY";
	const keyName = "COMPANY_ID";
	const tableKeyName = "COMPANY_ID";

	public function company($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "COMPANY_ID, COMPANY_CONTRACT_DATE_START, COMPANY_CONTRACT_DATE_END, COMPANY_CONTRACT_TERM, ";
		$sql .= "COMPANY_FUNC_AD, COMPANY_FUNC_GURUME, COMPANY_FUNC_ACT, COMPANY_FUNC_AFI, COMPANY_FUNC_HOTERL, COMPANY_FUNC_JOB, COMPANY_FUNC_COUPON, COMPANY_STATUS, COMPANY_LINK, ";
		$sql .= parent::decryptionList("COMPANY_NAME, COMPANY_SHOP_NAME, COMPANY_LOGIN_ID, COMPANY_LOGIN_PASSWORD, COMPANY_MAIL, COMPANY_TEL1").", ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from ".company::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_CONTRACT_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".company::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_CONTRACT_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "COMPANY_NAME")."%", true, 4)." ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_NAME_KANA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_NAME_KANA", "like", "%".$collection->getByKey($collection->getKeyValue(), "COMPANY_NAME_KANA")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_SHOP_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_SHOP_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "COMPANY_SHOP_NAME")."%", true, 4)." ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_SHOP_NAME_KANA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_SHOP_NAME_KANA", "like", "%".$collection->getByKey($collection->getKeyValue(), "COMPANY_SHOP_NAME_KANA")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_LOGIN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_LOGIN_ID", "like", "%".$collection->getByKey($collection->getKeyValue(), "COMPANY_LOGIN_ID")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_CONTRACT_DATE_END_from") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_CONTRACT_DATE_END", ">=", $collection->getByKey($collection->getKeyValue(), "COMPANY_CONTRACT_DATE_END_from"), true)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_CONTRACT_DATE_END_to") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_CONTRACT_DATE_END", "<=", $collection->getByKey($collection->getKeyValue(), "COMPANY_CONTRACT_DATE_END_to"), true)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_STATUS", "in", "(2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, company::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "COMPANY_ID, PREF_ID, COMPANY_CLAIM_PREF_ID, M_CONTRACT_ID, COMPANY_CONTRACT_PAY, COMPANY_CONTRACT_PAY_FLG, ";
		$sql .= "COMPANY_CONTRACT_DATE_START, COMPANY_CONTRACT_DATE_END, COMPANY_CONTRACT_TERM, ";
		$sql .= "COMPANY_FUNC_AD, COMPANY_FUNC_GURUME, COMPANY_FUNC_ACT, COMPANY_FUNC_AFI, COMPANY_FUNC_HOTERL, COMPANY_FUNC_JOB, COMPANY_FUNC_COUPON, ";
		$sql .= "COMPANY_STATUS, COMPANY_CLAIM_FLG, COMPANY_LINK, ";
		$sql .= parent::decryptionList("COMPANY_NAME, COMPANY_NAME_KANA, COMPANY_SHOP_NAME, COMPANY_SHOP_NAME_KANA, COMPANY_LOGIN_ID, COMPANY_LOGIN_PASSWORD, COMPANY_MAIL").", ";
		$sql .= parent::decryptionList("COMPANY_ZIP, COMPANY_CITY, COMPANY_ADDRESS, COMPANY_TEL1, COMPANY_TEL2, COMPANY_FAX, COMPANY_CHARGE, COMPANY_CLAIM_NAME, COMPANY_CLAIM_ZIP").", ";
		$sql .= parent::decryptionList("COMPANY_CLAIM_CITY, COMPANY_CLAIM_ADDRESS, COMPANY_CONTRACT_NAME, COMPANY_MEMO")." ";
		$sql .= "from ".company::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".company::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, company::keyName);
	}

	public  function selectDuplication($id, $loginId, $password="") {
		$sql  = "select ";
		$sql .= "COMPANY_ID ";
		$sql .= "from ".company::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("COMPANY_STATUS", "<>", 4)." and ";
		$sql .= parent::expsData("COMPANY_LOGIN_ID", "=", $loginId, true, 1)." ";
		if ($password != "") {
			$sql .= "and ".parent::expsData("COMPANY_LOGIN_PASSWORD", "=", $password, true, 1)." ";
		}
		if ($id != "") {
			$sql .= "and ".parent::expsData(company::keyName, "<>", $id)." ";
		}
		parent::setCollection($sql, company::keyName);
	}

	public function save() {
		$this->db->begin();
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

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".company::tableName." (";
		$sql .= "COMPANY_ID, ";
		$sql .= "COMPANY_NAME, ";
		$sql .= "COMPANY_NAME_KANA, ";
		$sql .= "COMPANY_SHOP_NAME, ";
		$sql .= "COMPANY_SHOP_NAME_KANA, ";
		$sql .= "COMPANY_LOGIN_ID, ";
		$sql .= "COMPANY_LOGIN_PASSWORD, ";
		$sql .= "COMPANY_MAIL, ";
		$sql .= "COMPANY_ZIP, ";
		$sql .= "PREF_ID, ";
		$sql .= "COMPANY_CITY, ";
		$sql .= "COMPANY_ADDRESS, ";
		$sql .= "COMPANY_TEL1, ";
		$sql .= "COMPANY_TEL2, ";
		$sql .= "COMPANY_FAX, ";
		$sql .= "COMPANY_CHARGE, ";
		$sql .= "COMPANY_CLAIM_FLG, ";
		$sql .= "COMPANY_CLAIM_NAME, ";
		$sql .= "COMPANY_CLAIM_ZIP, ";
		$sql .= "COMPANY_CLAIM_PREF_ID, ";
		$sql .= "COMPANY_CLAIM_CITY, ";
		$sql .= "COMPANY_CLAIM_ADDRESS, ";
		$sql .= "M_CONTRACT_ID, ";
		$sql .= "COMPANY_CONTRACT_NAME, ";
		$sql .= "COMPANY_CONTRACT_PAY_FLG, ";
		$sql .= "COMPANY_CONTRACT_PAY, ";
		$sql .= "COMPANY_CONTRACT_DATE_START, ";
		$sql .= "COMPANY_CONTRACT_DATE_END, ";
		$sql .= "COMPANY_CONTRACT_TERM, ";
		$sql .= "COMPANY_FUNC_AD, ";
		$sql .= "COMPANY_FUNC_GURUME, ";
		$sql .= "COMPANY_FUNC_ACT, ";
		$sql .= "COMPANY_FUNC_AFI, ";
		$sql .= "COMPANY_FUNC_HOTERL, ";
		$sql .= "COMPANY_FUNC_JOB, ";
		$sql .= "COMPANY_FUNC_COUPON, ";
		$sql .= "COMPANY_LINK, ";
		$sql .= "COMPANY_MEMO, ";
		$sql .= "COMPANY_STATUS, ";
		$sql .= "COMPANY_DATE_REGIST, ";
		$sql .= "COMPANY_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_NAME_KANA"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_SHOP_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_SHOP_NAME_KANA"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_LOGIN_ID"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_MAIL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["PREF_ID"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_TEL1"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_TEL2"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FAX"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CHARGE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CLAIM_FLG"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CLAIM_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CLAIM_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CLAIM_PREF_ID"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CLAIM_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CLAIM_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_ID"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CONTRACT_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CONTRACT_PAY_FLG"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CONTRACT_PAY"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CONTRACT_DATE_START"], true).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CONTRACT_DATE_END"], true).", ";
		$sql .= parent::expsVal($dataList["COMPANY_CONTRACT_TERM"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FUNC_AD"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FUNC_GURUME"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FUNC_ACT"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FUNC_AFI"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FUNC_HOTERL"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FUNC_JOB"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_FUNC_COUPON"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_LINK"], true).", ";
		$sql .= parent::expsVal($dataList["COMPANY_MEMO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COMPANY_STATUS"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".company::tableName." set ";
		$sql .= parent::expsData("COMPANY_NAME", "=", $dataList["COMPANY_NAME"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_NAME_KANA", "=", $dataList["COMPANY_NAME_KANA"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_SHOP_NAME", "=", $dataList["COMPANY_SHOP_NAME"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_SHOP_NAME_KANA", "=", $dataList["COMPANY_SHOP_NAME_KANA"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_LOGIN_ID", "=", $dataList["COMPANY_LOGIN_ID"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_LOGIN_PASSWORD", "=", $dataList["COMPANY_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_MAIL", "=", $dataList["COMPANY_MAIL"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_ZIP", "=", $dataList["COMPANY_ZIP"], true, 1).", ";
		$sql .= parent::expsData("PREF_ID", "=", $dataList["PREF_ID"]).", ";
		$sql .= parent::expsData("COMPANY_CITY", "=", $dataList["COMPANY_CITY"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_ADDRESS", "=", $dataList["COMPANY_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_TEL1", "=", $dataList["COMPANY_TEL1"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_TEL2", "=", $dataList["COMPANY_TEL2"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_FAX", "=", $dataList["COMPANY_FAX"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_CHARGE", "=", $dataList["COMPANY_CHARGE"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_CLAIM_FLG", "=", $dataList["COMPANY_CLAIM_FLG"]).", ";
		$sql .= parent::expsData("COMPANY_CLAIM_NAME", "=", $dataList["COMPANY_CLAIM_NAME"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_CLAIM_ZIP", "=", $dataList["COMPANY_CLAIM_ZIP"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_CLAIM_PREF_ID", "=", $dataList["COMPANY_CLAIM_PREF_ID"]).", ";
		$sql .= parent::expsData("COMPANY_CLAIM_CITY", "=", $dataList["COMPANY_CLAIM_CITY"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_CLAIM_ADDRESS", "=", $dataList["COMPANY_CLAIM_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("M_CONTRACT_ID", "=", $dataList["M_CONTRACT_ID"]).", ";
		$sql .= parent::expsData("COMPANY_CONTRACT_NAME", "=", $dataList["COMPANY_CONTRACT_NAME"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_CONTRACT_PAY_FLG", "=", $dataList["COMPANY_CONTRACT_PAY_FLG"]).", ";
		$sql .= parent::expsData("COMPANY_CONTRACT_PAY", "=", $dataList["COMPANY_CONTRACT_PAY"]).", ";
		$sql .= parent::expsData("COMPANY_CONTRACT_DATE_START", "=", $dataList["COMPANY_CONTRACT_DATE_START"], true).", ";
		$sql .= parent::expsData("COMPANY_CONTRACT_DATE_END", "=", $dataList["COMPANY_CONTRACT_DATE_END"], true).", ";
		$sql .= parent::expsData("COMPANY_CONTRACT_TERM", "=", $dataList["COMPANY_CONTRACT_TERM"]).", ";
		$sql .= parent::expsData("COMPANY_FUNC_AD", "=", $dataList["COMPANY_FUNC_AD"]).", ";
		$sql .= parent::expsData("COMPANY_FUNC_GURUME", "=", $dataList["COMPANY_FUNC_GURUME"]).", ";
		$sql .= parent::expsData("COMPANY_FUNC_ACT", "=", $dataList["COMPANY_FUNC_ACT"]).", ";
		$sql .= parent::expsData("COMPANY_FUNC_AFI", "=", $dataList["COMPANY_FUNC_AFI"]).", ";
		$sql .= parent::expsData("COMPANY_FUNC_HOTERL", "=", $dataList["COMPANY_FUNC_HOTERL"]).", ";
		$sql .= parent::expsData("COMPANY_FUNC_JOB", "=", $dataList["COMPANY_FUNC_JOB"]).", ";
		$sql .= parent::expsData("COMPANY_FUNC_COUPON", "=", $dataList["COMPANY_FUNC_COUPON"]).", ";
		$sql .= parent::expsData("COMPANY_LINK", "=", $dataList["COMPANY_LINK"], true).", ";
		$sql .= parent::expsData("COMPANY_MEMO", "=", $dataList["COMPANY_MEMO"], true, 1).", ";
		$sql .= parent::expsData("COMPANY_STATUS", "=", $dataList["COMPANY_STATUS"]).", ";
		$sql .= parent::expsData("COMPANY_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(company::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".company::tableName." set ";
		$sql .= parent::expsData("COMPANY_STATUS", "=", 4).", ";
		$sql .= parent::expsData("COMPANY_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(company::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function selectLogin(&$data) {
		$sql  = "select ";
		$sql .= "COMPANY_ID, COMPANY_STATUS, COMPANY_CONTRACT_DATE_START, COMPANY_CONTRACT_DATE_END, PREF_ID, ";
		$sql .= "COMPANY_FUNC_AD, COMPANY_FUNC_GURUME, COMPANY_FUNC_ACT, COMPANY_FUNC_AFI, COMPANY_FUNC_HOTERL, COMPANY_FUNC_JOB, COMPANY_FUNC_COUPON, COMPANY_LINK, ";
		$sql .= parent::decryptionList("COMPANY_NAME, COMPANY_SHOP_NAME, COMPANY_LOGIN_ID, COMPANY_LOGIN_PASSWORD, COMPANY_MAIL").", ";
		$sql .= parent::decryptionList("COMPANY_ZIP, COMPANY_CITY, COMPANY_ADDRESS, COMPANY_TEL1")." ";
		$sql .= "from ".company::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("COMPANY_STATUS", "in", "(2,3)")." ";
		$sql .= "and ".parent::expsData("COMPANY_LOGIN_ID", "=", $data->getByKey($data->getKeyValue(), "COMPANY_LOGIN_ID"), true, 1)." ";
		$sql .= "and ".parent::expsData("COMPANY_LOGIN_PASSWORD", "=", $data->getByKey($data->getKeyValue(), "COMPANY_LOGIN_PASSWORD"), true, 1)." ";

		parent::setCollection($sql, company::keyName);
	}

	public function selectLoginCookie() {
		$sql  = "select ";
		$sql .= "COMPANY_ID, COMPANY_STATUS, COMPANY_CONTRACT_DATE_START, COMPANY_CONTRACT_DATE_END, PREF_ID, ";
		$sql .= "COMPANY_FUNC_AD, COMPANY_FUNC_GURUME, COMPANY_FUNC_ACT, COMPANY_FUNC_AFI, COMPANY_FUNC_HOTERL, COMPANY_FUNC_JOB, COMPANY_FUNC_COUPON, COMPANY_LINK, ";
		$sql .= parent::decryptionList("COMPANY_NAME, COMPANY_SHOP_NAME, COMPANY_LOGIN_ID, COMPANY_LOGIN_PASSWORD, COMPANY_MAIL").", ";
		$sql .= parent::decryptionList("COMPANY_ZIP, COMPANY_CITY, COMPANY_ADDRESS, COMPANY_TEL1")." ";
		$sql .= "from ".company::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("COMPANY_STATUS", "in", "(2,3)")." ";
		$sql .= "and ".parent::expsData("COMPANY_LOGIN_ID", "=", $_COOKIE[SITE_COOKIE_SHOP_ID], true, 1)." ";
		$sql .= "and ".parent::expsData("COMPANY_LOGIN_PASSWORD", "=", $_COOKIE[SITE_COOKIE_SHOP_PASS], true, 1)." ";

		parent::setCollection($sql, company::keyName);
	}

	public function checkLogin() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_ID"))) {
			parent::setError("COMPANY_LOGIN_ID", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD"))) {
			parent::setError("COMPANY_LOGIN_PASSWORD", "必須項目です");
		}
	}

	public function check() {
		if (!$_POST) return;

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_NAME"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_NAME"), 100)) {
				parent::setError("COMPANY_NAME", "100文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_NAME_KANA"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_NAME_KANA"), 100)) {
				parent::setError("COMPANY_NAME_KANA", "100文字以内で入力して下さい");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_NAME_KANA"), CHK_PTN_KANA)) {
				parent::setError("COMPANY_NAME_KANA", "全角カナで入力して下さい");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_SHOP_NAME"))) {
			parent::setError("COMPANY_SHOP_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_SHOP_NAME"), 100)) {
			parent::setError("COMPANY_SHOP_NAME", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_SHOP_NAME_KANA"))) {
			parent::setError("COMPANY_SHOP_NAME_KANA", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_SHOP_NAME_KANA"), 100)) {
			parent::setError("COMPANY_SHOP_NAME_KANA", "100文字以内で入力して下さい");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_SHOP_NAME_KANA"), CHK_PTN_KANA)) {
			parent::setError("COMPANY_SHOP_NAME_KANA", "全角カナで入力して下さい");
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_MAIL"))) {
			parent::setError("COMPANY_MAIL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_MAIL"), CHK_PTN_MAILADDRESS)) {
			parent::setError("COMPANY_MAIL", "メールアドレスの形式を確認して下さい。");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_MAIL"), 100)) {
			parent::setError("COMPANY_MAIL", "100文字以内で入力して下さい");
		}
		else {
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_ID"))) {
			parent::setError("COMPANY_LOGIN_ID", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_ID"), 100)) {
			parent::setError("COMPANY_LOGIN_ID", "100文字以内で入力して下さい");
		}
		else {
// 			$companyDuplication = new company($this->db);
// 			$companyDuplication->selectDuplication(parent::getKeyValue(), parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_ID"));
// 			if ($companyDuplication->getCount() > 0) {
// 				parent::setError("COMPANY_LOGIN_ID", "既に登録されています");
// 			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD"))) {
			parent::setError("COMPANY_LOGIN_PASSWORD", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD"), CHK_PTN_WORDNUM)) {
			parent::setError("COMPANY_LOGIN_PASSWORD", "半角英数字で入力して下さい");
		}
		elseif (!cmCheckLengthBetween(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD"),15, 4)) {
			parent::setError("COMPANY_LOGIN_PASSWORD", "4～15文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM))) {
			parent::setError("COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM, "必須項目です");
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM))) {
				if (parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD") != parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM)) {
					parent::setError("COMPANY_LOGIN_PASSWORD".WORDS_CONFIRM, "パスワードと確認用が一致していません");
				}
			}
		}

		if (parent::getErrorByKey("COMPANY_LOGIN_ID") == "" and parent::getErrorByKey("COMPANY_LOGIN_PASSWORD") == "") {
			$companyDuplication = new company($this->db);
			$companyDuplication->selectDuplication(parent::getKeyValue(), parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_ID"), parent::getByKey(parent::getKeyValue(), "COMPANY_LOGIN_PASSWORD"));
			if ($companyDuplication->getCount() > 0) {
				parent::setError("COMPANY_LOGIN_ID", "このIDとパスワードの組み合わせは既に登録されています");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_ZIP"))) {
			parent::setError("COMPANY_ZIP", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_ZIP"), CHK_PTN_ZIPCODE_JP)) {
			parent::setError("COMPANY_ZIP", "郵便番号は000-0000の形式で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "PREF_ID"))) {
			parent::setError("PREF_ID", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_CITY"))) {
			parent::setError("COMPANY_CITY", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_CITY"), 100)) {
			parent::setError("COMPANY_CITY", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_ADDRESS"))) {
			parent::setError("COMPANY_ADDRESS", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_ADDRESS"), 50)) {
			parent::setError("COMPANY_ADDRESS", "50文字以内で入力して下さい");
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_TEL1"))) {
			parent::setError("COMPANY_TEL1", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_TEL1"), CHK_PTN_TEL)) {
			parent::setError("COMPANY_TEL1", "電話番号は00-0000-0000の形式で入力して下さい");
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_TEL2"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_TEL2"), CHK_PTN_TEL)) {
				parent::setError("COMPANY_TEL2", "電話番号は00-0000-0000の形式で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_FAX"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_FAX"), CHK_PTN_TEL)) {
				parent::setError("COMPANY_FAX", "FAX番号は00-0000-0000の形式で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_CHARGE"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_CHARGE"), 50)) {
				parent::setError("COMPANY_CHARGE", "50文字以内で入力して下さい");
			}
		}

		if (parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_FLG") != 1) {

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_NAME"))) {
				if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_NAME"), 50)) {
					parent::setError("COMPANY_CLAIM_NAME", "50文字以内で入力して下さい");
				}
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_ZIP"))) {
				parent::setError("COMPANY_CLAIM_ZIP", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_ZIP"), CHK_PTN_ZIPCODE_JP)) {
				parent::setError("COMPANY_CLAIM_ZIP", "郵便番号は000-0000の形式で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_PREF_ID"))) {
				parent::setError("COMPANY_CLAIM_PREF_ID", "必須項目です");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_CITY"))) {
				parent::setError("COMPANY_CLAIM_CITY", "必須項目です");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_CITY"), 100)) {
				parent::setError("COMPANY_CLAIM_CITY", "100文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_ADDRESS"))) {
				parent::setError("COMPANY_CLAIM_ADDRESS", "必須項目です");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COMPANY_CLAIM_ADDRESS"), 50)) {
				parent::setError("COMPANY_CLAIM_ADDRESS", "50文字以内で入力して下さい");
			}

		}




		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COMPANY_STATUS"))) {
			parent::setError("COMPANY_STATUS", "必須項目です");
		}

	}


	public function setPost() {
		if ($_POST) {

			$this->setByKey($this->getKeyValue(), "COMPANY_FUNC_AD", 2);
			$this->setByKey($this->getKeyValue(), "COMPANY_FUNC_GURUME", 2);
			$this->setByKey($this->getKeyValue(), "COMPANY_FUNC_ACT", 2);
			$this->setByKey($this->getKeyValue(), "COMPANY_FUNC_AFI", 2);
			$this->setByKey($this->getKeyValue(), "COMPANY_FUNC_HOTERL", 3);
			$this->setByKey($this->getKeyValue(), "COMPANY_FUNC_JOB", 2);
			$this->setByKey($this->getKeyValue(), "COMPANY_FUNC_COUPON", 2);
			$this->setByKey($this->getKeyValue(), "COMPANY_CLAIM_FLG", 2);

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