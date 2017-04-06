<?php
class coupon extends collection {
	const tableName = "COUPON";
	const keyName = "COUPON_ID";
	const tableKeyName = "COMPANY_ID";

	public function coupon($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "COUPON_ID, COMPANY_ID, COUPON_FLG_TARGET, COUPON_PAY, COUPON_DATE_FROM, COUPON_DATE_TO, COUPON_ORDER, COUPON_STATUS, ";
		$sql .= parent::decryptionList("COUPON_NAME, COUPON_CONTENT, COUPON_MEMO")." ";
		$sql .= "from ".coupon::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COUPON_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".coupon::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COUPON_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".coupon::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPON_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "COUPON_NAME")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPON_CONTENT") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_CONTENT", "like", "%".$collection->getByKey($collection->getKeyValue(), "COUPON_CONTENT")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "COUPON_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COUPON_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COUPON_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COUPON_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COUPON_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COUPON_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_STATUS", "in", "(1,2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COUPON_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, coupon::keyName);
	}

	public function select($id="", $statusComma="", $companyId="", $flgTarget="") {
		$sql  = "select ";
		$sql .= "COUPON_ID, COMPANY_ID, COUPON_FLG_TARGET, COUPON_PAY, COUPON_DATE_FROM, COUPON_DATE_TO, COUPON_ORDER, COUPON_STATUS, ";
		$sql .= parent::decryptionList("COUPON_NAME, COUPON_CONTENT, COUPON_MEMO")." ";
		$sql .= "from ".coupon::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".coupon::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".coupon::tableKeyName, "=", $companyId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($flgTarget != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_FLG_TARGET", "=", $flgTarget)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COUPON_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, coupon::keyName);
	}

	public function save() {
		$this->db->begin();
// 		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		$sql = "";


		for ($i=1; $i<=SITE_COUPON_NUM; $i++) {
// 			if (parent::getByKey(parent::getKeyValue(), "COUPON_STATUS".$i) == 2) {

				$dataList["COUPON_ID"] = parent::getByKey(parent::getKeyValue(), "COUPON_ID".$i);
				$dataList["COMPANY_ID"] = parent::getByKey("COMPANY_ID", "COMPANY_ID");
				$dataList["COUPON_FLG_TARGET"] = parent::getByKey("COUPON_FLG_TARGET", "COUPON_FLG_TARGET");
				$dataList["COUPON_NAME"] = parent::getByKey(parent::getKeyValue(), "COUPON_NAME".$i);
				$dataList["COUPON_PAY"] = parent::getByKey(parent::getKeyValue(), "COUPON_PAY".$i);
				$dataList["COUPON_CONTENT"] = parent::getByKey(parent::getKeyValue(), "COUPON_CONTENT".$i);
				$dataList["COUPON_DATE_FROM"] = parent::getByKey(parent::getKeyValue(), "COUPON_DATE_FROM".$i);
				$dataList["COUPON_DATE_TO"] = parent::getByKey(parent::getKeyValue(), "COUPON_DATE_TO".$i);
				$dataList["COUPON_MEMO"] = parent::getByKey(parent::getKeyValue(), "COUPON_MEMO".$i);
				$dataList["COUPON_ORDER"] = $i;
				$dataList["COUPON_STATUS"] = parent::getByKey(parent::getKeyValue(), "COUPON_STATUS".$i);


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

// 			}
		}

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".coupon::tableName." (";
		$sql .= "COUPON_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "COUPON_FLG_TARGET, ";
		$sql .= "COUPON_NAME, ";
		$sql .= "COUPON_PAY, ";
		$sql .= "COUPON_CONTENT, ";
		$sql .= "COUPON_DATE_FROM, ";
		$sql .= "COUPON_DATE_TO, ";
		$sql .= "COUPON_MEMO, ";
		$sql .= "COUPON_ORDER, ";
		$sql .= "COUPON_STATUS, ";
		$sql .= "COUPON_DATE_REGIST, ";
		$sql .= "COUPON_DATE_UPDATE) values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["COUPON_FLG_TARGET"]).", ";
		$sql .= parent::expsVal($dataList["COUPON_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_PAY"]).", ";
		$sql .= parent::expsVal($dataList["COUPON_CONTENT"], true, 1).", ";
		if ($dataList["COUPON_DATE_FROM"] != "") {
			$sql .= parent::expsVal($dataList["COUPON_DATE_FROM"], true).", ";
		}
		else {
			$sql .= "null, ";
		}
		if ($dataList["COUPON_DATE_TO"] != "") {
			$sql .= parent::expsVal($dataList["COUPON_DATE_TO"], true).", ";
		}
		else {
			$sql .= "null, ";
		}
		$sql .= parent::expsVal($dataList["COUPON_MEMO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_ORDER"]).", ";
		$sql .= parent::expsVal($dataList["COUPON_STATUS"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".coupon::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("COUPON_FLG_TARGET", "=", $dataList["COUPON_FLG_TARGET"]).", ";
		$sql .= parent::expsData("COUPON_NAME", "=", $dataList["COUPON_NAME"], true, 1).", ";
		$sql .= parent::expsData("COUPON_PAY", "=", $dataList["COUPON_PAY"]).", ";
		$sql .= parent::expsData("COUPON_CONTENT", "=", $dataList["COUPON_CONTENT"], true, 1).", ";
		if ($dataList["COUPON_DATE_FROM"] != "") {
			$sql .= parent::expsData("COUPON_DATE_FROM", "=", $dataList["COUPON_DATE_FROM"], true).", ";
		}
		else {
			$sql .= "COUPON_DATE_FROM = null, ";
		}
		if ($dataList["COUPON_DATE_TO"] != "") {
			$sql .= parent::expsData("COUPON_DATE_TO", "=", $dataList["COUPON_DATE_TO"], true).", ";
		}
		else {
			$sql .= "COUPON_DATE_TO = null, ";
		}
		$sql .= parent::expsData("COUPON_MEMO", "=", $dataList["COUPON_MEMO"], true, 1).", ";
		$sql .= parent::expsData("COUPON_ORDER", "=", $dataList["COUPON_ORDER"]).", ";
		$sql .= parent::expsData("COUPON_STATUS", "=", $dataList["COUPON_STATUS"]).", ";
		$sql .= parent::expsData("COUPON_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(coupon::keyName, "=", $dataList["COUPON_ID"])." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".coupon::tableName." set ";
		$sql .= parent::expsData("COUPON_STATUS", "=", 3).", ";
		$sql .= parent::expsData("ADMIN_ID", "=", parent::getByKey(parent::getKeyValue(), "ADMIN_ID")).", ";
		$sql .= parent::expsData("COUPON_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(coupon::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".coupon::tableName." set ";
			$sql .= parent::expsData("COUPON_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= coupon::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$this->db->commit();
		return true;
	}

	public function check() {
		if (!$_POST) return;

		$flg = false;

		for ($i=1; $i<=SITE_COUPON_NUM; $i++) {

			if (parent::getByKey(parent::getKeyValue(), "COUPON_STATUS".$i) == 2) {

				$flg = true;

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_NAME".$i))) {
					parent::setError("COUPON_NAME".$i, "必須項目です");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_NAME".$i), 50)) {
					parent::setError("COUPON_NAME".$i, "50文字以内で入力して下さい");
				}

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_PAY".$i))) {
					parent::setError("COUPON_PAY".$i, "必須項目です");
				}
				elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_PAY".$i), CHK_PTN_NUM)) {
					parent::setError("COUPON_PAY".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_PAY".$i), 10)) {
					parent::setError("COUPON_PAY".$i, "10文字以内で入力して下さい");
				}

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_CONTENT".$i))) {
					parent::setError("COUPON_CONTENT".$i, "必須項目です");
				}

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_STATUS".$i))) {
					parent::setError("COUPON_STATUS".$i, "必須項目です");
				}

			}
			else {
				if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_NAME".$i))) {
					if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_NAME".$i), 50)) {
						parent::setError("COUPON_NAME".$i, "50文字以内で入力して下さい");
					}
				}

				if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_PAY".$i))) {
					if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_PAY".$i), CHK_PTN_NUM)) {
						parent::setError("COUPON_PAY".$i, "半角数字で入力して下さい");
					}
					elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_PAY".$i), 10)) {
						parent::setError("COUPON_PAY".$i, "10文字以内で入力して下さい");
					}
				}
			}

		}


// 		if (!$flg) {
// 			parent::setErrorFirst("保存の対象がみつかりませんでした。");
// 		}

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