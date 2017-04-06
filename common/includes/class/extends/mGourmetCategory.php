<?php
class mGourmetCategory extends collection {
	const tableName = "M_GOURMET_CATEGORY";
	const keyName = "M_GOURMET_CATEGORY_ID";
	const tableKeyName = "M_GOURMET_CATEGORY_ID";
	const xmlName = XML_GOURMET_CATEGORY;

	public function mGourmetCategory($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "M_GOURMET_CATEGORY_ID, M_GOURMET_CATEGORY_ORDER, M_GOURMET_CATEGORY_STATUS, ";
		$sql .= parent::decryptionList("M_GOURMET_CATEGORY_NAME, M_GOURMET_CATEGORY_URL")." ";
		$sql .= "from ".mGourmetCategory::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mGourmetCategory::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_GOURMET_CATEGORY_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_NAME")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_URL") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_GOURMET_CATEGORY_URL", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_URL")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_GOURMET_CATEGORY_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_GOURMET_CATEGORY_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_GOURMET_CATEGORY_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_GOURMET_CATEGORY_ORDER, M_GOURMET_CATEGORY_ID desc ";

		parent::setCollection($sql, mGourmetCategory::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "M_GOURMET_CATEGORY_ID, M_GOURMET_CATEGORY_ORDER, M_GOURMET_CATEGORY_STATUS, ";
		$sql .= parent::decryptionList("M_GOURMET_CATEGORY_NAME, M_GOURMET_CATEGORY_URL")." ";
		$sql .= "from ".mGourmetCategory::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mGourmetCategory::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_GOURMET_CATEGORY_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_GOURMET_CATEGORY_ORDER, M_GOURMET_CATEGORY_ID desc ";

		parent::setCollection($sql, mGourmetCategory::keyName);
	}

	private function createXmlArray() {
		$itemList = array();
		$mGourmetCategoryAll = new mGourmetCategory($this->db);
		$mGourmetCategoryAll->select("", "1,2");
		if ($mGourmetCategoryAll->getCount() > 0) {
			foreach ($mGourmetCategoryAll->getCollection() as $data) {
				$itemList[$data["M_GOURMET_CATEGORY_ID"]]["name"] = $data["M_GOURMET_CATEGORY_NAME"];
				$itemList[$data["M_GOURMET_CATEGORY_ID"]]["value"] = $data["M_GOURMET_CATEGORY_ID"];
				$itemList[$data["M_GOURMET_CATEGORY_ID"]]["url"] = $data["M_GOURMET_CATEGORY_URL"];
				$itemList[$data["M_GOURMET_CATEGORY_ID"]]["status"] = $data["M_GOURMET_CATEGORY_STATUS"];
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
		$xml = new xml(mGourmetCategory::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".mGourmetCategory::tableName." (";
		$sql .= "M_GOURMET_CATEGORY_ID, ";
		$sql .= "M_GOURMET_CATEGORY_NAME, ";
		$sql .= "M_GOURMET_CATEGORY_URL, ";
		$sql .= "M_GOURMET_CATEGORY_ORDER, ";
		$sql .= "M_GOURMET_CATEGORY_STATUS, ";
		$sql .= "ADMIN_ID, ";
		$sql .= "M_GOURMET_CATEGORY_DATE_REGIST, ";
		$sql .= "M_GOURMET_CATEGORY_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["M_GOURMET_CATEGORY_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_GOURMET_CATEGORY_URL"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal($dataList["M_GOURMET_CATEGORY_STATUS"]).", ";
		$sql .= parent::expsVal($dataList["ADMIN_ID"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".mGourmetCategory::tableName." set ";
		$sql .= parent::expsData("M_GOURMET_CATEGORY_NAME", "=", $dataList["M_GOURMET_CATEGORY_NAME"], true, 1).", ";
		$sql .= parent::expsData("M_GOURMET_CATEGORY_URL", "=", $dataList["M_GOURMET_CATEGORY_URL"], true, 1).", ";
		$sql .= parent::expsData("M_GOURMET_CATEGORY_ORDER", "=", $dataList["M_GOURMET_CATEGORY_ORDER"]).", ";
		$sql .= parent::expsData("M_GOURMET_CATEGORY_STATUS", "=", $dataList["M_GOURMET_CATEGORY_STATUS"]).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", $dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsData("M_GOURMET_CATEGORY_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mGourmetCategory::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".mGourmetCategory::tableName." set ";
		$sql .= parent::expsData("M_GOURMET_CATEGORY_STATUS", "=", 3).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", parent::getByKey(parent::getKeyValue(), "ADMIN_ID")).", ";
		$sql .= parent::expsData("M_GOURMET_CATEGORY_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mGourmetCategory::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mGourmetCategory::xmlName);
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
			$sql  = "update ".mGourmetCategory::tableName." set ";
			$sql .= parent::expsData("M_GOURMET_CATEGORY_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= mGourmetCategory::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mGourmetCategory::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_GOURMET_CATEGORY_NAME"))) {
			parent::setError("M_GOURMET_CATEGORY_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_GOURMET_CATEGORY_NAME"), 50)) {
			parent::setError("M_GOURMET_CATEGORY_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_GOURMET_CATEGORY_URL"))) {
			parent::setError("M_GOURMET_CATEGORY_URL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "M_GOURMET_CATEGORY_URL"), CHK_PTN_WORDNUM)) {
			parent::setError("M_GOURMET_CATEGORY_URL", "半角英数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_GOURMET_CATEGORY_URL"), 20)) {
			parent::setError("M_GOURMET_CATEGORY_URL", "20文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_GOURMET_CATEGORY_STATUS"))) {
			parent::setError("M_GOURMET_CATEGORY_STATUS", "必須項目です");
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