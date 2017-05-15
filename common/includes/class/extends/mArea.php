<?php
class mArea extends collection {
	const tableName = "M_AREA";
	const keyName = "M_AREA_ID";
	const tableKeyName = "M_AREA_ID";
	const xmlName = XML_AREA;

	public function mArea($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "M_AREA_ID, M_AREA_ORDER, M_AREA_STATUS, M_AREA_TYPE, M_AREA_CHILD, M_AREA_PARENT, M_AREA_TOP, ";
		$sql .= parent::decryptionList("M_AREA_NAME, M_AREA_URL")." ";
		$sql .= "from ".mArea::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mArea::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_AREA_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_AREA_NAME")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_URL") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_URL", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_AREA_URL")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_AREA_ORDER, M_AREA_ID desc ";

		parent::setCollection($sql, mArea::keyName);
	}


	public function selectListGroup($collection) {
		$sql  = "select ";
		$sql .= "M_AREA_ID, M_AREA_ORDER, M_AREA_STATUS, M_AREA_TYPE, M_AREA_CHILD, M_AREA_PARENT, M_AREA_TOP, ";
		$sql .= parent::decryptionList("M_AREA_NAME, M_AREA_URL")." ";
		$sql .= "from ".mArea::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mArea::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_AREA_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_AREA_NAME")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_URL") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_URL", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_AREA_URL")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "M_AREA_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_AREA_TOP, M_AREA_PARENT, M_AREA_ORDER, M_AREA_ID asc ";

//print $sql;
		parent::setCollection($sql, mArea::keyName);
	}


	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "M_AREA_ID, M_AREA_ORDER, M_AREA_STATUS, M_AREA_TYPE, M_AREA_CHILD, M_AREA_PARENT, M_AREA_TOP, ";
		$sql .= parent::decryptionList("M_AREA_NAME, M_AREA_URL")." ";
		$sql .= "from ".mArea::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mArea::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_AREA_ORDER, M_AREA_ID desc ";

		parent::setCollection($sql, mArea::keyName);
	}

	public function selectTop($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "M_AREA_ID, M_AREA_ORDER, M_AREA_STATUS, M_AREA_TYPE, M_AREA_CHILD, M_AREA_PARENT, M_AREA_TOP, ";
		$sql .= parent::decryptionList("M_AREA_NAME, M_AREA_URL")." ";
		$sql .= "from ".mArea::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mArea::keyName, "=", $id)." ";
		}


		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$where .= "and ";
		}
		$where .= parent::expsData("M_AREA_TYPE", "=", "1")." ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_AREA_ORDER, M_AREA_ID desc ";

		parent::setCollection($sql, mArea::keyName);
	}

	public function selectParent($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "M_AREA_ID, M_AREA_ORDER, M_AREA_STATUS, M_AREA_TYPE, M_AREA_CHILD, M_AREA_PARENT, M_AREA_TOP, ";
		$sql .= parent::decryptionList("M_AREA_NAME, M_AREA_URL")." ";
		$sql .= "from ".mArea::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mArea::keyName, "=", $id)." ";
		}


		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$where .= "and ";
		}
		$where .= parent::expsData("M_AREA_TYPE", "=", "2")." ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_AREA_ORDER, M_AREA_ID desc ";

		parent::setCollection($sql, mArea::keyName);
	}


	public function selectChild($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "M_AREA_ID, M_AREA_ORDER, M_AREA_STATUS, M_AREA_TYPE, M_AREA_CHILD, M_AREA_PARENT, M_AREA_TOP, ";
		$sql .= parent::decryptionList("M_AREA_NAME, M_AREA_URL")." ";
		$sql .= "from ".mArea::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".mArea::keyName, "=", $id)." ";
		}


		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_AREA_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$where .= "and ";
		}
		$where .= parent::expsData("M_AREA_TYPE", "=", "3")." ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by M_AREA_ORDER, M_AREA_ID desc ";

		parent::setCollection($sql, mArea::keyName);
	}

	
	/**
	 * TOPエリアプラン数取得
	 * @return Array area_idをキーにしたプラン数
	 */
	public function selectTopAreaPlanCnt(){
		$sql  = " SELECT ";
		$sql .= " SHOPPLAN_AREA_LIST1 as area_id , COUNT(*) as cnt";
		$sql .= " FROM SHOPPLAN ";
		
		$sql .= " WHERE SHOPPLAN_STATUS = 2 ";
		
		$sql .= "GROUP BY SHOPPLAN_AREA_LIST1";
		parent::setCollection($sql, "", false, true);
		return parent::getCollection();
	}
	
	/**
	 * TOPカテゴリプラン数取得
	 * @return Array area_idをキーにしたプラン数
	 */
	public function selectTopCategoryPlanCnt(){
		$sql  = " SELECT ";
		$sql .= " SHOPPLAN_CATEGORY1 as category_id , COUNT(*) as cnt";
		$sql .= " FROM SHOPPLAN ";
	
		$sql .= " WHERE SHOPPLAN_STATUS = 2 ";
	
		$sql .= "GROUP BY SHOPPLAN_CATEGORY1";
		parent::setCollection($sql, "", false, true);
		return parent::getCollection();
	}


	private function createXmlArray() {
		$itemList = array();
		$mAreaAll = new mArea($this->db);
		$mAreaAll->select("", "1,2");
		if ($mAreaAll->getCount() > 0) {
			foreach ($mAreaAll->getCollection() as $data) {
				$itemList[$data["M_AREA_ID"]]["name"] = $data["M_AREA_NAME"];
				$itemList[$data["M_AREA_ID"]]["value"] = $data["M_AREA_ID"];
				$itemList[$data["M_AREA_ID"]]["url"] = $data["M_AREA_URL"];
				$itemList[$data["M_AREA_ID"]]["status"] = $data["M_AREA_STATUS"];
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
		$xml = new xml(mArea::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".mArea::tableName." (";
		$sql .= "M_AREA_ID, ";
		$sql .= "M_AREA_NAME, ";
		$sql .= "M_AREA_URL, ";
		$sql .= "M_AREA_ORDER, ";
		$sql .= "M_AREA_STATUS, ";
		$sql .= "ADMIN_ID, ";
		$sql .= "M_AREA_TYPE, ";
		$sql .= "M_AREA_CHILD, ";
		$sql .= "M_AREA_PARENT, ";
		$sql .= "M_AREA_TOP, ";
		$sql .= "M_AREA_DATE_REGIST, ";
		$sql .= "M_AREA_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["M_AREA_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_AREA_URL"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal($dataList["M_AREA_STATUS"]).", ";
		$sql .= parent::expsVal($dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsVal($dataList["M_AREA_TYPE"]).", ";
		$sql .= parent::expsVal($dataList["M_AREA_CHILD"]).", ";
		$sql .= parent::expsVal($dataList["M_AREA_PARENT"]).", ";
		$sql .= parent::expsVal($dataList["M_AREA_TOP"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//print $sql;
		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".mArea::tableName." set ";
		$sql .= parent::expsData("M_AREA_NAME", "=", $dataList["M_AREA_NAME"], true, 1).", ";
		$sql .= parent::expsData("M_AREA_URL", "=", $dataList["M_AREA_URL"], true, 1).", ";
		$sql .= parent::expsData("M_AREA_ORDER", "=", $dataList["M_AREA_ORDER"]).", ";
		$sql .= parent::expsData("M_AREA_STATUS", "=", $dataList["M_AREA_STATUS"]).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", $dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsData("M_AREA_TYPE", "=", $dataList["M_AREA_TYPE"]).", ";
		$sql .= parent::expsData("M_AREA_CHILD", "=", $dataList["M_AREA_CHILD"]).", ";
		$sql .= parent::expsData("M_AREA_PARENT", "=", $dataList["M_AREA_PARENT"]).", ";
		$sql .= parent::expsData("M_AREA_TOP", "=", $dataList["M_AREA_TOP"]).", ";
		$sql .= parent::expsData("M_AREA_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mArea::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".mArea::tableName." set ";
		$sql .= parent::expsData("M_AREA_STATUS", "=", 3).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", parent::getByKey(parent::getKeyValue(), "ADMIN_ID")).", ";
		$sql .= parent::expsData("M_AREA_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(mArea::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mArea::xmlName);
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
			$sql  = "update ".mArea::tableName." set ";
			$sql .= parent::expsData("M_AREA_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= mArea::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$itemList = $this->createXmlArray();
		$xml = new xml(mArea::xmlName);
		if (!$xml->create($itemList)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_AREA_TYPE"))) {
			parent::setError("M_AREA_TYPE", "作成するエリアのタイプを選択してください");
		}
		if ((parent::getByKey(parent::getKeyValue(), "M_AREA_TYPE")) == "2") {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_AREA_TOP"))) {
				parent::setError("M_AREA_TOP", "トップエリアを選択してください");
			}
			elseif (parent::getByKey(parent::getKeyValue(), "M_AREA_TOP") == "0") {
				parent::setError("M_AREA_TOP", "トップエリアを選択してください");
			}

		}
		if ((parent::getByKey(parent::getKeyValue(), "M_AREA_TYPE")) == "3") {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_AREA_TOP")) || (parent::getByKey(parent::getKeyValue(), "M_AREA_TOP") == "0")) {
				parent::setError("M_AREA_TOP", "トップエリアを選択してください");
			}
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_AREA_PARENT")) || (parent::getByKey(parent::getKeyValue(), "M_AREA_PARENT") == "0")) {
				parent::setError("M_AREA_PARENT", "親エリアを選択してください");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_AREA_NAME"))) {
			parent::setError("M_AREA_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_AREA_NAME"), 50)) {
			parent::setError("M_AREA_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_AREA_URL"))) {
			parent::setError("M_AREA_URL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "M_AREA_URL"), CHK_PTN_WORDNUM)) {
			parent::setError("M_AREA_URL", "半角英数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_AREA_URL"), 20)) {
			parent::setError("M_AREA_URL", "20文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_AREA_STATUS"))) {
			parent::setError("M_AREA_STATUS", "必須項目です");
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