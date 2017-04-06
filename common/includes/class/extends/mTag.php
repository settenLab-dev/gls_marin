<?php
class mTag extends collection {
	const tableName = "M_TAG";
	const keyName = "M_TAG_ID";
	const tableKeyName = "M_TAG_ID";
	const xmlName = XML_TAG;

	public function mTag($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "M_TAG_ID, M_TAG_ORDER, M_TAG_STATUS, ";
		$sql .= parent::decryptionList("M_TAG_NAME, M_TAG_URL")." ";
		$sql .= "from ".mTag::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_TAG_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mTag::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_TAG_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_TAG_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_TAG_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_TAG_NAME")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_TAG_URL") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_TAG_URL", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_TAG_URL")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "M_TAG_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_TAG_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_TAG_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_TAG_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_TAG_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_TAG_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_TAG_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_TAG_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_TAG_ORDER, M_TAG_ID desc ";

		parent::setCollection($sql, mTag::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "M_TAG_ID, M_TAG_ORDER, M_TAG_STATUS, ";
		$sql .= parent::decryptionList("M_TAG_NAME, M_TAG_URL")." ";
		$sql .= "from ".mTag::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mTag::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_TAG_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_TAG_ORDER, M_TAG_ID desc ";

		parent::setCollection($sql, mTag::keyName);
	}

	private function createXmlArray() {
		$itemList = array();
		$mTagAll = new mTag($this->db);
		$mTagAll->select("", "1,2");
		if ($mTagAll->getCount() > 0) {
			foreach ($mTagAll->getCollection() as $data) {
				$itemList[$data["M_TAG_ID"]]["name"] = $data["M_TAG_NAME"];
				$itemList[$data["M_TAG_ID"]]["value"] = $data["M_TAG_ID"];
				$itemList[$data["M_TAG_ID"]]["url"] = $data["M_TAG_URL"];
				$itemList[$data["M_TAG_ID"]]["status"] = $data["M_TAG_STATUS"];
			}
		}
		return $itemList;
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

		$itemList = $this->createXmlArray();
		$xml = new xml(mTag::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".mTag::tableName." (";
		$sql .= "M_TAG_ID, ";
		$sql .= "M_TAG_NAME, ";
		$sql .= "M_TAG_URL, ";
		$sql .= "M_TAG_ORDER, ";
		$sql .= "M_TAG_STATUS, ";
		$sql .= "ADMIN_ID, ";
		$sql .= "M_TAG_DATE_REGIST, ";
		$sql .= "M_TAG_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["M_TAG_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_TAG_URL"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal($dataList["M_TAG_STATUS"]).", ";
		$sql .= parent::expsVal($dataList["ADMIN_ID"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//print $sql;
		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".mTag::tableName." set ";
		$sql .= parent::expsData("M_TAG_NAME", "=", $dataList["M_TAG_NAME"], true, 1).", ";
		$sql .= parent::expsData("M_TAG_URL", "=", $dataList["M_TAG_URL"], true, 1).", ";
		$sql .= parent::expsData("M_TAG_ORDER", "=", $dataList["M_TAG_ORDER"]).", ";
		$sql .= parent::expsData("M_TAG_STATUS", "=", $dataList["M_TAG_STATUS"]).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", $dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsData("M_TAG_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mTag::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".mTag::tableName." set ";
		$sql .= parent::expsData("M_TAG_STATUS", "=", 3).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", parent::getByKey(parent::getKeyValue(), "ADMIN_ID")).", ";
		$sql .= parent::expsData("M_TAG_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mTag::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mTag::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".mTag::tableName." set ";
			$sql .= parent::expsData("M_TAG_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= mTag::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mTag::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_TAG_NAME"))) {
			parent::setError("M_TAG_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_TAG_NAME"), 50)) {
			parent::setError("M_TAG_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_TAG_URL"))) {
			parent::setError("M_TAG_URL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "M_TAG_URL"), CHK_PTN_WORDNUM)) {
			parent::setError("M_TAG_URL", "半角英数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_TAG_URL"), 20)) {
			parent::setError("M_TAG_URL", "20文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_TAG_STATUS"))) {
			parent::setError("M_TAG_STATUS", "必須項目です");
		}

	}


	public function setPost() {
		if ($_POST) {
			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}
		}

	}


}
?>