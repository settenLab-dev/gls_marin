<?php
class mContract extends collection {
	const tableName = "M_CONTRACT";
	const keyName = "M_CONTRACT_ID";
	const tableKeyName = "M_CONTRACT_ID";
// 	const xmlName = XML_CONTRACT;

	public function mContract($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "M_CONTRACT_ID, M_CONTRACT_PAY_FLG, M_CONTRACT_PAY, M_CONTRACT_TERM,  M_CONTRACT_ORDER, M_CONTRACT_STATUS, ADMIN_ID, ";
		$sql .= "M_CONTRACT_FUNC_AD, M_CONTRACT_FUNC_GURUME, M_CONTRACT_FUNC_ACT, M_CONTRACT_FUNC_AFI, M_CONTRACT_FUNC_HOTEL, M_CONTRACT_FUNC_JOB, M_CONTRACT_FUNC_COUPON, ";
		$sql .= parent::decryptionList("M_CONTRACT_NAME, M_CONTRACT_REMARK, M_CONTRACT_MEMO")." ";
		$sql .= "from ".mContract::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_CONTRACT_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mContract::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_CONTRACT_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_CONTRACT_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_CONTRACT_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_CONTRACT_NAME")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_CONTRACT_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_CONTRACT_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_CONTRACT_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_CONTRACT_ORDER, M_CONTRACT_DATE_REGIST desc ";

		parent::setCollection($sql, mContract::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "M_CONTRACT_ID, M_CONTRACT_PAY_FLG, M_CONTRACT_PAY, M_CONTRACT_TERM,  M_CONTRACT_ORDER, M_CONTRACT_STATUS, ADMIN_ID, ";
		$sql .= "M_CONTRACT_FUNC_AD, M_CONTRACT_FUNC_GURUME, M_CONTRACT_FUNC_ACT, M_CONTRACT_FUNC_AFI, M_CONTRACT_FUNC_HOTEL, M_CONTRACT_FUNC_JOB, M_CONTRACT_FUNC_COUPON, ";
		$sql .= parent::decryptionList("M_CONTRACT_NAME, M_CONTRACT_REMARK, M_CONTRACT_MEMO")." ";
		$sql .= "from ".mContract::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mContract::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_CONTRACT_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_CONTRACT_ORDER, M_CONTRACT_DATE_REGIST desc ";

		parent::setCollection($sql, mContract::keyName);
	}

// 	private function createXmlArray() {
// 		$itemList = array();
// 		$mContractAll = new mContract($this->db);
// 		$mContractAll->select("", "1,2");
// 		if ($mContractAll->getCount() > 0) {
// 			foreach ($mContractAll->getCollection() as $data) {
// 				$itemList[$data["M_CONTRACT_ID"]]["name"] = $data["M_CONTRACT_NAME"];
// 				$itemList[$data["M_CONTRACT_ID"]]["value"] = $data["M_CONTRACT_ID"];
// 				$itemList[$data["M_CONTRACT_ID"]]["month"] = $data["M_CONTRACT_MONTH"];
// 				$itemList[$data["M_CONTRACT_ID"]]["money"] = $data["M_CONTRACT_MONEY"];
// 				$itemList[$data["M_CONTRACT_ID"]]["discription"] = $data["M_CONTRACT_DISCRIPTION"];
// 				$itemList[$data["M_CONTRACT_ID"]]["status"] = $data["M_CONTRACT_STATUS"];
// 				$itemList[$data["M_CONTRACT_ID"]]["reward"] = $data["M_CONTRACT_REWARD"];
// 			}
// 		}
// 		return $itemList;
// 	}

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

// 		$itemList = $this->createXmlArray();
// 		$xml = new xml(mContract::xmlName);
// 		if (!$xml->create($itemList)) {
// 			$this->db->rollback();
// 			return false;
// 		}

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".mContract::tableName." (";
		$sql .= "M_CONTRACT_ID, ";
		$sql .= "M_CONTRACT_PAY_FLG, ";
		$sql .= "M_CONTRACT_NAME, ";
		$sql .= "M_CONTRACT_PAY, ";
		$sql .= "M_CONTRACT_TERM, ";
		$sql .= "M_CONTRACT_FUNC_AD, ";
		$sql .= "M_CONTRACT_FUNC_GURUME, ";
		$sql .= "M_CONTRACT_FUNC_ACT, ";
		$sql .= "M_CONTRACT_FUNC_AFI, ";
		$sql .= "M_CONTRACT_FUNC_HOTEL, ";
		$sql .= "M_CONTRACT_FUNC_JOB, ";
		$sql .= "M_CONTRACT_FUNC_COUPON, ";
		$sql .= "M_CONTRACT_REMARK, ";
		$sql .= "M_CONTRACT_MEMO, ";
		$sql .= "M_CONTRACT_ORDER, ";
		$sql .= "M_CONTRACT_STATUS, ";
		$sql .= "ADMIN_ID, ";
		$sql .= "M_CONTRACT_DATE_REGIST, ";
		$sql .= "M_CONTRACT_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_PAY_FLG"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_PAY"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_TERM"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_FUNC_AD"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_FUNC_GURUME"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_FUNC_ACT"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_FUNC_AFI"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_FUNC_HOTEL"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_FUNC_JOB"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_FUNC_COUPON"]).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_REMARK"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_MEMO"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal($dataList["M_CONTRACT_STATUS"]).", ";
		$sql .= parent::expsVal($dataList["ADMIN_ID"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".mContract::tableName." set ";
		$sql .= parent::expsData("M_CONTRACT_PAY_FLG", "=", $dataList["M_CONTRACT_PAY_FLG"]).", ";
		$sql .= parent::expsData("M_CONTRACT_NAME", "=", $dataList["M_CONTRACT_NAME"], true, 1).", ";
		$sql .= parent::expsData("M_CONTRACT_PAY", "=", $dataList["M_CONTRACT_PAY"]).", ";
		$sql .= parent::expsData("M_CONTRACT_TERM", "=", $dataList["M_CONTRACT_TERM"]).", ";
		$sql .= parent::expsData("M_CONTRACT_FUNC_AD", "=", $dataList["M_CONTRACT_FUNC_AD"]).", ";
		$sql .= parent::expsData("M_CONTRACT_FUNC_GURUME", "=", $dataList["M_CONTRACT_FUNC_GURUME"]).", ";
		$sql .= parent::expsData("M_CONTRACT_FUNC_ACT", "=", $dataList["M_CONTRACT_FUNC_ACT"]).", ";
		$sql .= parent::expsData("M_CONTRACT_FUNC_AFI", "=", $dataList["M_CONTRACT_FUNC_AFI"]).", ";
		$sql .= parent::expsData("M_CONTRACT_FUNC_HOTEL", "=", $dataList["M_CONTRACT_FUNC_HOTEL"]).", ";
		$sql .= parent::expsData("M_CONTRACT_FUNC_JOB", "=", $dataList["M_CONTRACT_FUNC_JOB"]).", ";
		$sql .= parent::expsData("M_CONTRACT_FUNC_COUPON", "=", $dataList["M_CONTRACT_FUNC_COUPON"]).", ";
		$sql .= parent::expsData("M_CONTRACT_REMARK", "=", $dataList["M_CONTRACT_REMARK"], true, 1).", ";
		$sql .= parent::expsData("M_CONTRACT_MEMO", "=", $dataList["M_CONTRACT_MEMO"], true, 1).", ";
		$sql .= parent::expsData("M_CONTRACT_ORDER", "=", $dataList["M_CONTRACT_ORDER"]).", ";
		$sql .= parent::expsData("M_CONTRACT_STATUS", "=", $dataList["M_CONTRACT_STATUS"]).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", $dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsData("M_CONTRACT_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mContract::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".mContract::tableName." set ";
		$sql .= parent::expsData("M_CONTRACT_STATUS", "=", 3).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", parent::getByKey(parent::getKeyValue(), "ADMIN_ID")).", ";
		$sql .= parent::expsData("M_CONTRACT_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mContract::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

// 		$itemList = $this->createXmlArray();
// 		$xml = new xml(mContract::xmlName);
// 		if (!$xml->create($itemList)) {
// 			$this->db->rollback();
// 			return false;
// 		}

		$this->db->commit();
		return true;

	}

	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".mContract::tableName." set ";
			$sql .= parent::expsData("M_CONTRACT_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= mContract::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

// 		$itemList = $this->createXmlArray();
// 		$xml = new xml(mContract::xmlName);
// 		if (!$xml->create($itemList)) {
// 			$this->db->rollback();
// 			return false;
// 		}

		$this->db->commit();
		return true;
	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_NAME"))) {
			parent::setError("M_CONTRACT_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_NAME"), 50)) {
			parent::setError("M_CONTRACT_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_PAY_FLG"))) {
			parent::setError("M_CONTRACT_PAY_FLG", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_PAY"))) {
			parent::setError("M_CONTRACT_PAY", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_PAY"), CHK_PTN_NUM)) {
			parent::setError("M_CONTRACT_PAY", "半角英数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_PAY"), 10)) {
			parent::setError("M_CONTRACT_PAY", "10文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_TERM"))) {
			parent::setError("M_CONTRACT_TERM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_TERM"), CHK_PTN_NUM)) {
			parent::setError("M_CONTRACT_TERM", "半角英数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_TERM"), 10)) {
			parent::setError("M_CONTRACT_TERM", "10文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_CONTRACT_STATUS"))) {
			parent::setError("M_CONTRACT_STATUS", "必須項目です");
		}

	}


	public function setPost() {
		if ($_POST) {

			$this->setByKey($this->getKeyValue(), "M_CONTRACT_FUNC_AD", 2);
			$this->setByKey($this->getKeyValue(), "M_CONTRACT_FUNC_GURUME", 2);
			$this->setByKey($this->getKeyValue(), "M_CONTRACT_FUNC_ACT", 2);
			$this->setByKey($this->getKeyValue(), "M_CONTRACT_FUNC_AFI", 2);
			$this->setByKey($this->getKeyValue(), "M_CONTRACT_FUNC_HOTEL", 3);
			$this->setByKey($this->getKeyValue(), "M_CONTRACT_FUNC_JOB", 2);
			$this->setByKey($this->getKeyValue(), "M_CONTRACT_FUNC_COUPON", 2);

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