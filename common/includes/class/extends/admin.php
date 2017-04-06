<?php
class admin extends collection {
	const tableName = "ADMIN";
	const keyName = "ADMIN_ID";
	const tableKeyName = "ADMIN_ID";

	public function admin($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "ADMIN_ID, ADMIN_STATUS, ADMIN_LEVEL1, ADMIN_LEVEL2, ADMIN_LEVEL3, ADMIN_LEVEL4, ADMIN_LEVEL5, ADMIN_LEVEL6, ADMIN_LEVEL7, ";
		$sql .= parent::decryptionList("ADMIN_NAME, ADMIN_LOGIN_MAILADDRESS")." ";
		$sql .= "from ".admin::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "ADMIN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".admin::keyName, "=", $collection->getByKey($collection->getKeyValue(), "ADMIN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ADMIN_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ADMIN_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "ADMIN_NAME")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ADMIN_LOGIN_MAILADDRESS") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ADMIN_LOGIN_MAILADDRESS", "like", "%".$collection->getByKey($collection->getKeyValue(), "ADMIN_LOGIN_MAILADDRESS")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ADMIN_STATUS") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ADMIN_STATUS", "in", "(1,2)")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ADMIN_STATUS", "=", "1")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		parent::setCollection($sql, admin::keyName);
	}

	public function select($id="") {
		$sql  = "select ";
		$sql .= "ADMIN_ID, ADMIN_STATUS, ADMIN_LEVEL1, ADMIN_LEVEL2, ADMIN_LEVEL3, ADMIN_LEVEL4, ADMIN_LEVEL5, ADMIN_LEVEL6, ADMIN_LEVEL7, ";
		$sql .= parent::decryptionList("ADMIN_NAME, ADMIN_LOGIN_ID, ADMIN_LOGIN_PASSWORD, ADMIN_LOGIN_MAILADDRESS")." ";
		$sql .= "from ".admin::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".admin::keyName, "=", $id)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		parent::setCollection($sql, admin::keyName);
	}

	public  function selectDuplication($id, $loginId) {
		$sql  = "select ";
		$sql .= "ADMIN_ID ";
		$sql .= "from ".admin::tableName. " ";
		$sql .= "where ";
		$sql .= parent::expsData("ADMIN_STATUS", "=", 1)." and ";
		$sql .= parent::expsData("ADMIN_LOGIN_ID", "=", $loginId, true, 1)." ";
		if ($id != "") {
			$sql .= "and ".parent::expsData(admin::keyName, "<>", $id)." ";
		}
		parent::setCollection($sql, admin::keyName);
	}

	public function selectLogin(&$data) {
		$sql  = "select ";
		$sql .= "ADMIN_ID, ADMIN_STATUS, ADMIN_LEVEL1, ADMIN_LEVEL2, ADMIN_LEVEL3, ADMIN_LEVEL4, ADMIN_LEVEL5, ADMIN_LEVEL6, ADMIN_LEVEL7, ";
		$sql .= parent::decryptionList("ADMIN_NAME, ADMIN_LOGIN_ID, ADMIN_LOGIN_PASSWORD, ADMIN_LOGIN_MAILADDRESS")." ";
		$sql .= "from ".admin::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("ADMIN_STATUS", "=", 1)." ";
		$sql .= "and ".parent::expsData("ADMIN_LOGIN_ID", "=", $data->getByKey($data->getKeyValue(), "ADMIN_LOGIN_ID"), true, 1)." ";
		$sql .= "and ".parent::expsData("ADMIN_LOGIN_PASSWORD", "=", $data->getByKey($data->getKeyValue(), "ADMIN_LOGIN_PASSWORD"), true, 1)." ";
//print_r($sql);
		parent::setCollection($sql, admin::keyName);
	}

	public function selectLoginCookie() {
		$sql  = "select ";
		$sql .= "ADMIN_ID, ADMIN_STATUS, ADMIN_LEVEL1, ADMIN_LEVEL2, ADMIN_LEVEL3, ADMIN_LEVEL4, ADMIN_LEVEL5, ADMIN_LEVEL6, ADMIN_LEVEL7, ";
		$sql .= parent::decryptionList("ADMIN_NAME, ADMIN_LOGIN_ID, ADMIN_LOGIN_PASSWORD, ADMIN_LOGIN_MAILADDRESS")." ";
		$sql .= "from ".admin::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("ADMIN_STATUS", "=", 1)." ";
		$sql .= "and ".parent::expsData("ADMIN_LOGIN_ID", "=", $_COOKIE[SITE_COOKIE_ADMIN_ID], true, 1)." ";
		$sql .= "and ".parent::expsData("ADMIN_LOGIN_PASSWORD", "=", $_COOKIE[SITE_COOKIE_ADMIN_PASS], true, 1)." ";

		parent::setCollection($sql, admin::keyName);
	}

	public function checkLogin() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_ID"))) {
			parent::setError("ADMIN_LOGIN_ID", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD"))) {
			parent::setError("ADMIN_LOGIN_PASSWORD", "必須項目です");
		}
	}

	public function insert($dataList) {
		$sql  = "insert into ".admin::tableName." (";
		$sql .= "ADMIN_ID, ";
		$sql .= "ADMIN_NAME, ";
		$sql .= "ADMIN_LOGIN_ID, ";
		$sql .= "ADMIN_LOGIN_PASSWORD, ";
		$sql .= "ADMIN_STATUS, ";
		$sql .= "ADMIN_LOGIN_MAILADDRESS, ";

		$sql .= "ADMIN_LEVEL1, ";
		$sql .= "ADMIN_LEVEL2, ";
		$sql .= "ADMIN_LEVEL3, ";
		$sql .= "ADMIN_LEVEL4, ";
		$sql .= "ADMIN_LEVEL5, ";
		$sql .= "ADMIN_LEVEL6, ";
		$sql .= "ADMIN_LEVEL7, ";

		$sql .= "ADMIN_DATE_REGIST, ";
		$sql .= "ADMIN_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["ADMIN_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ADMIN_LOGIN_ID"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ADMIN_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= parent::expsVal($dataList["ADMIN_LOGIN_MAILADDRESS"], true, 1).", ";
		$sql .= $dataList["ADMIN_LEVEL1"].", ";
		$sql .= $dataList["ADMIN_LEVEL2"].", ";
		$sql .= $dataList["ADMIN_LEVEL3"].", ";
		$sql .= $dataList["ADMIN_LEVEL4"].", ";
		$sql .= $dataList["ADMIN_LEVEL5"].", ";
		$sql .= $dataList["ADMIN_LEVEL6"].", ";
		$sql .= $dataList["ADMIN_LEVEL7"].", ";

		$sql .= "now(), ";
		$sql .= "now()) ";
print_r($sql);
		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".admin::tableName." set ";
		$sql .= parent::expsData("ADMIN_NAME", "=", $dataList["ADMIN_NAME"], true, 1).", ";
		$sql .= parent::expsData("ADMIN_LOGIN_ID", "=", $dataList["ADMIN_LOGIN_ID"], true, 1).", ";
		$sql .= parent::expsData("ADMIN_LOGIN_PASSWORD", "=", $dataList["ADMIN_LOGIN_PASSWORD"], true, 1).", ";
		$sql .= parent::expsData("ADMIN_STATUS", "=", $dataList["ADMIN_STATUS"]).", ";
		$sql .= parent::expsData("ADMIN_LOGIN_MAILADDRESS", "=", $dataList["ADMIN_LOGIN_MAILADDRESS"], true, 1).", ";

		$sql .= parent::expsData("ADMIN_LEVEL1", "=", $dataList["ADMIN_LEVEL1"]).", ";
		$sql .= parent::expsData("ADMIN_LEVEL2", "=", $dataList["ADMIN_LEVEL2"]).", ";
		$sql .= parent::expsData("ADMIN_LEVEL3", "=", $dataList["ADMIN_LEVEL3"]).", ";
		$sql .= parent::expsData("ADMIN_LEVEL4", "=", $dataList["ADMIN_LEVEL4"]).", ";
		$sql .= parent::expsData("ADMIN_LEVEL5", "=", $dataList["ADMIN_LEVEL5"]).", ";
		$sql .= parent::expsData("ADMIN_LEVEL6", "=", $dataList["ADMIN_LEVEL6"]).", ";
		$sql .= parent::expsData("ADMIN_LEVEL7", "=", $dataList["ADMIN_LEVEL7"]).", ";

		$sql .= parent::expsData("ADMIN_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(admin::keyName, "=", parent::getKeyValue())." ";
print_r($sql);
		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".admin::tableName." set ";
		$sql .= parent::expsData("ADMIN_STATUS", "=", 2).", ";
		$sql .= parent::expsData("ADMIN_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(admin::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}



	public function setPost() {
		if ($_POST) {

			$this->setByKey($this->getKeyValue(), "ADMIN_LEVEL1", 2);
			$this->setByKey($this->getKeyValue(), "ADMIN_LEVEL2", 2);
			$this->setByKey($this->getKeyValue(), "ADMIN_LEVEL3", 2);
			$this->setByKey($this->getKeyValue(), "ADMIN_LEVEL4", 2);
			$this->setByKey($this->getKeyValue(), "ADMIN_LEVEL5", 2);
			$this->setByKey($this->getKeyValue(), "ADMIN_LEVEL6", 2);
			$this->setByKey($this->getKeyValue(), "ADMIN_LEVEL7", 2);

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

		}

	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_NAME"))) {
			parent::setError("ADMIN_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ADMIN_NAME"), 50)) {
			parent::setError("ADMIN_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_ID"))) {
			parent::setError("ADMIN_LOGIN_ID", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_ID"), CHK_PTN_WORDNUM)) {
			parent::setError("ADMIN_LOGIN_ID", "半角英数字で入力して下さい");
		}
		elseif (!cmCheckLengthBetween(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_ID"),15, 4)) {
			parent::setError("ADMIN_LOGIN_ID", "4～15文字以内で入力して下さい");
		}
		else {
			$adminDuplication = new admin($this->db);
			$adminDuplication->selectDuplication(parent::getKeyValue(), parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_ID"));
			if ($adminDuplication->getCount() > 0) {
				parent::setError("ADMIN_LOGIN_ID", "既に登録されています");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD"))) {
			parent::setError("ADMIN_LOGIN_PASSWORD", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD"), CHK_PTN_WORDNUM)) {
			parent::setError("ADMIN_LOGIN_PASSWORD", "半角英数字で入力して下さい");
		}
		elseif (!cmCheckLengthBetween(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD"),15, 4)) {
			parent::setError("ADMIN_LOGIN_PASSWORD", "4～15文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM))) {
			parent::setError("ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM, "必須項目です");
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM))) {
				if (parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD") != parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM)) {
					parent::setError("ADMIN_LOGIN_PASSWORD".WORDS_CONFIRM, "パスワードと確認用が一致していません");
				}
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_MAILADDRESS"))) {
			parent::setError("ADMIN_LOGIN_MAILADDRESS", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_MAILADDRESS"), CHK_PTN_MAILADDRESS)) {
			parent::setError("ADMIN_LOGIN_MAILADDRESS", "メールアドレスの形式を確認してください");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ADMIN_LOGIN_MAILADDRESS"), 100)) {
			parent::setError("ADMIN_LOGIN_MAILADDRESS", "100文字以内で入力して下さい");
		}

	}

}



?>