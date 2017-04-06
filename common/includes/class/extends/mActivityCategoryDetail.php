<?php
class mActivityCategoryDetail extends collection {
	const tableName = "M_ACT_CATEGORY_D";
	const keyName = "M_ACT_CATEGORY_D_ID";
	const tableKeyName = "M_ACT_CATEGORY_ID";
	const xmlName = XML_ACTIVITY_CATEGORY_DETAIL;

	public function mActivityCategoryDetail($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "M_ACT_CATEGORY_D_ID, M_ACT_CATEGORY_ID, M_ACT_CATEGORY_D_ORDER, ";
		$sql .= "M_ACT_CATEGORY_D_STATUS, ADMIN_ID, ";
		$sql .= parent::decryptionList("M_ACT_CATEGORY_D_NAME, M_ACT_CATEGORY_D_URL")." ";
		$sql .= "from ".mActivityCategoryDetail::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mActivityCategoryDetail::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mActivityCategoryDetail::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_ACT_CATEGORY_D_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_NAME")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_URL") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_ACT_CATEGORY_D_URL", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_URL")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_ACT_CATEGORY_D_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_ACT_CATEGORY_D_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_ACT_CATEGORY_D_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_ACT_CATEGORY_D_ORDER, M_ACT_CATEGORY_ID desc, M_ACT_CATEGORY_D_ID desc ";

		parent::setCollection($sql, mActivityCategoryDetail::keyName);
	}

	public function select($id="", $statusComma="", $categoryId="") {
		$sql  = "select ";
		$sql .= "M_ACT_CATEGORY_D_ID, M_ACT_CATEGORY_ID, M_ACT_CATEGORY_D_ORDER, ";
		$sql .= "M_ACT_CATEGORY_D_STATUS, ADMIN_ID, ";
		$sql .= parent::decryptionList("M_ACT_CATEGORY_D_NAME, M_ACT_CATEGORY_D_URL")." ";
		$sql .= "from ".mActivityCategoryDetail::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mActivityCategoryDetail::keyName, "=", $id)." ";
		}

		if ($categoryId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mActivityCategoryDetail::tableKeyName, "=", $categoryId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_ACT_CATEGORY_D_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_ACT_CATEGORY_D_ORDER, M_ACT_CATEGORY_ID desc, M_ACT_CATEGORY_D_ID desc ";

		parent::setCollection($sql, mActivityCategoryDetail::keyName);
	}

	private function createXmlArray() {
		$itemList = array();
		$mActivityCategoryDetailAll = new mActivityCategoryDetail($this->db);
		$mActivityCategoryDetailAll->select("", "1,2");
		if ($mActivityCategoryDetailAll->getCount() > 0) {
			foreach ($mActivityCategoryDetailAll->getCollection() as $data) {
				$itemList[$data["M_ACT_CATEGORY_D_ID"]]["name"] = $data["M_ACT_CATEGORY_D_NAME"];
				$itemList[$data["M_ACT_CATEGORY_D_ID"]]["value"] = $data["M_ACT_CATEGORY_D_ID"];
				$itemList[$data["M_ACT_CATEGORY_D_ID"]]["category"] = $data["M_ACT_CATEGORY_ID"];
				$itemList[$data["M_ACT_CATEGORY_D_ID"]]["url"] = $data["M_ACT_CATEGORY_D_URL"];
				$itemList[$data["M_ACT_CATEGORY_D_ID"]]["status"] = $data["M_ACT_CATEGORY_D_STATUS"];
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
		$xml = new xml(mActivityCategoryDetail::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".mActivityCategoryDetail::tableName." (";
		$sql .= "M_ACT_CATEGORY_D_ID, ";
		$sql .= "M_ACT_CATEGORY_ID, ";
		$sql .= "M_ACT_CATEGORY_D_NAME, ";
		$sql .= "M_ACT_CATEGORY_D_URL, ";
		$sql .= "M_ACT_CATEGORY_D_ORDER, ";
		$sql .= "M_ACT_CATEGORY_D_STATUS, ";
		$sql .= "ADMIN_ID, ";
		$sql .= "M_ACT_CATEGORY_D_DATE_REGIST, ";
		$sql .= "M_ACT_CATEGORY_D_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["M_ACT_CATEGORY_ID"]).", ";
		$sql .= parent::expsVal($dataList["M_ACT_CATEGORY_D_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_ACT_CATEGORY_D_URL"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal($dataList["M_ACT_CATEGORY_D_STATUS"]).", ";
		$sql .= parent::expsVal($dataList["ADMIN_ID"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".mActivityCategoryDetail::tableName." set ";
		$sql .= parent::expsData("M_ACT_CATEGORY_ID", "=", $dataList["M_ACT_CATEGORY_ID"]).", ";
		$sql .= parent::expsData("M_ACT_CATEGORY_D_NAME", "=", $dataList["M_ACT_CATEGORY_D_NAME"], true, 1).", ";
		$sql .= parent::expsData("M_ACT_CATEGORY_D_URL", "=", $dataList["M_ACT_CATEGORY_D_URL"], true, 1).", ";
		$sql .= parent::expsData("M_ACT_CATEGORY_D_ORDER", "=", $dataList["M_ACT_CATEGORY_D_ORDER"]).", ";
		$sql .= parent::expsData("M_ACT_CATEGORY_D_STATUS", "=", $dataList["M_ACT_CATEGORY_D_STATUS"]).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", $dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsData("M_ACT_CATEGORY_D_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mActivityCategoryDetail::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".mActivityCategoryDetail::tableName." set ";
		$sql .= parent::expsData("M_ACT_CATEGORY_D_STATUS", "=", 3).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", parent::getByKey(parent::getKeyValue(), "ADMIN_ID")).", ";
		$sql .= parent::expsData("M_ACT_CATEGORY_D_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mActivityCategoryDetail::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mActivityCategoryDetail::xmlName);
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
			$sql  = "update ".mActivityCategoryDetail::tableName." set ";
			$sql .= parent::expsData("M_ACT_CATEGORY_D_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= mActivityCategoryDetail::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mActivityCategoryDetail::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_ACT_CATEGORY_ID"))) {
			parent::setError("M_ACT_CATEGORY_ID", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_ACT_CATEGORY_D_NAME"))) {
			parent::setError("M_ACT_CATEGORY_D_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_ACT_CATEGORY_D_NAME"), 50)) {
			parent::setError("M_ACT_CATEGORY_D_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_ACT_CATEGORY_D_URL"))) {
			parent::setError("M_ACT_CATEGORY_D_URL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "M_ACT_CATEGORY_D_URL"), CHK_PTN_WORDNUM)) {
			parent::setError("M_ACT_CATEGORY_D_URL", "半角英数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_ACT_CATEGORY_D_URL"), 20)) {
			parent::setError("M_ACT_CATEGORY_D_URL", "20文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_ACT_CATEGORY_D_STATUS"))) {
			parent::setError("M_ACT_CATEGORY_D_STATUS", "必須項目です");
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