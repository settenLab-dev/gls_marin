<?php
class pointHistory extends collection {
	const tableName = "POINT_HISTORY";
	const keyName = "POINT_HISTORY_ID";
	const tableKeyName = "MEMBER_ID";

	public function pointHistory($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "POINT_HISTORY_ID, MEMBER_ID, POINT_HISTORY_NUM, POINT_HISTORY_LIMIT, POINT_HISTORY_STATUS, POINT_HISTORY_DIVIDE, POINT_HISTORY_TARGET_ID, POINT_HISTORY_DATE_REGIST, ";
		$sql .= parent::decryptionList("POINT_HISTORY_NAME")." ";
		$sql .= "from ".pointHistory::tableName." ";


		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".pointHistory::keyName, "=", $collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "MEMBER_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".pointHistory::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("POINT_HISTORY_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_NAME")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "POINT_HISTORY_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("POINT_HISTORY_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("POINT_HISTORY_STATUS", "in", "(0,1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by POINT_HISTORY_DATE_REGIST desc ";

		parent::setCollection($sql, pointHistory::keyName);
	}

	public function select($id="", $statusComma="", $memberId="") {
		$sql  = "select ";
		$sql .= "POINT_HISTORY_ID, MEMBER_ID, POINT_HISTORY_NUM, POINT_HISTORY_LIMIT, POINT_HISTORY_STATUS, POINT_HISTORY_DIVIDE, POINT_HISTORY_TARGET_ID, ";
		$sql .= parent::decryptionList("POINT_HISTORY_NAME")." ";
		$sql .= "from ".pointHistory::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".pointHistory::keyName, "=", $id)." ";
		}

		if ($memberId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".pointHistory::tableKeyName, "=", $memberId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("POINT_HISTORY_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by POINT_HISTORY_DATE_REGIST desc ";

		parent::setCollection($sql, pointHistory::keyName);
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
		$sql  = "insert into ".pointHistory::tableName." (";
		$sql .= "POINT_HISTORY_ID, ";
		$sql .= "MEMBER_ID, ";
		$sql .= "POINT_HISTORY_DIVIDE, ";
		$sql .= "POINT_HISTORY_TARGET_ID, ";
		$sql .= "POINT_HISTORY_NUM, ";
		$sql .= "POINT_HISTORY_NAME, ";
		$sql .= "POINT_HISTORY_LIMIT, ";
		$sql .= "POINT_HISTORY_STATUS, ";
		$sql .= "POINT_HISTORY_DATE_REGIST, ";
		$sql .= "POINT_HISTORY_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["MEMBER_ID"]).", ";
		$sql .= parent::expsVal($dataList["POINT_HISTORY_DIVIDE"]).", ";
		$sql .= parent::expsVal($dataList["POINT_HISTORY_TARGET_ID"]).", ";
		$sql .= parent::expsVal($dataList["POINT_HISTORY_NUM"]).", ";
		$sql .= parent::expsVal($dataList["POINT_HISTORY_NAME"], true, 1).", ";
		if ($dataList["POINT_HISTORY_LIMIT"] != "") {
			$sql .= parent::expsVal($dataList["POINT_HISTORY_LIMIT"], true).", ";
		}
		else {
			$sql .= "null, ";
		}
		$sql .= parent::expsVal($dataList["POINT_HISTORY_STATUS"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".pointHistory::tableName." set ";
		$sql .= parent::expsData("POINT_HISTORY_NAME", "=", $dataList["POINT_HISTORY_NAME"], true, 1).", ";
		$sql .= parent::expsData("POINT_HISTORY_DIVIDE", "=", $dataList["POINT_HISTORY_DIVIDE"]).", ";
		$sql .= parent::expsData("POINT_HISTORY_TARGET_ID", "=", $dataList["POINT_HISTORY_TARGET_ID"]).", ";
		$sql .= parent::expsData("POINT_HISTORY_NUM", "=", $dataList["POINT_HISTORY_NUM"]).", ";
		if ($dataList["POINT_HISTORY_LIMIT"] != "") {
			$sql .= parent::expsData("POINT_HISTORY_LIMIT", "=", $dataList["POINT_HISTORY_LIMIT"]).", ";
		}
		else {
			$sql .= parent::expsData("POINT_HISTORY_LIMIT", "=", "null").", ";
		}
		$sql .= parent::expsData("POINT_HISTORY_STATUS", "=", $dataList["POINT_HISTORY_STATUS"]).", ";
		$sql .= parent::expsData("POINT_HISTORY_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(pointHistory::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".pointHistory::tableName." set ";
		$sql .= parent::expsData("POINT_HISTORY_STATUS", "=", 2).", ";
		$sql .= parent::expsData("POINT_HISTORY_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(pointHistory::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}


		$this->db->commit();
		return true;

	}


	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "POINT_HISTORY_NAME"))) {
			parent::setError("POINT_HISTORY_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "POINT_HISTORY_NAME"), 50)) {
			parent::setError("POINT_HISTORY_NAME", "50文字以内で入力して下さい");
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