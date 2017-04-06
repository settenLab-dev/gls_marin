<?php
class mMail extends collection {
	const tableName = "M_MAIL";
	const keyName = "M_MAIL_ID";
	const tableKeyName = "M_MAIL_ID";

	public function mMail($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "M_MAIL_ID, M_MAIL_FLG_DELETE, ";
		$sql .= parent::decryptionList("M_MAIL_USE, M_MAIL_USE, M_MAIL_TITLE, M_MAIL_CONTENTS, M_MAIL_MEMO")." ";
		$sql .= "from ".mMail::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "M_MAIL_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".admin::keyName, "=", $collection->getByKey($collection->getKeyValue(), "M_MAIL_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_MAIL_USE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_MAIL_USE", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_MAIL_USE")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_MAIL_TITLE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_MAIL_TITLE", "like", "%".$collection->getByKey($collection->getKeyValue(), "M_MAIL_TITLE")."%", true, 4)." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "M_MAIL_FLG_DELETE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_MAIL_FLG_DELETE", "in", "(1,2)")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("M_MAIL_FLG_DELETE", "=", "1")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		parent::setCollection($sql, mMail::keyName);
	}

	public function select($id="") {
		$sql .= "select ";
		$sql .= "M_MAIL_ID, M_MAIL_FLG_DELETE, ";
		$sql .= parent::decryptionList("M_MAIL_USE, M_MAIL_USE, M_MAIL_TITLE, M_MAIL_CONTENTS, M_MAIL_MEMO")." ";
		$sql .= "from ".mMail::tableName."  ";
		if ($id != "") {
			$sql .= "where ";
			$sql .= " ".parent::expsData("M_MAIL_ID","=",$id);
		}
		$sql .= " order by M_MAIL_ID desc ";
		parent::setCollection($sql, mMail::keyName);
	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_MAIL_USE"))) {
			parent::setError("M_MAIL_USE", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_MAIL_USE"),100)) {
			parent::setError("M_MAIL_USE", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_MAIL_TITLE"))) {
			parent::setError("M_MAIL_TITLE", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "M_MAIL_TITLE"),50)) {
			parent::setError("M_MAIL_TITLE", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_MAIL_CONTENTS"))) {
			parent::setError("M_MAIL_CONTENTS", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "M_MAIL_FLG_DELETE"))) {
			parent::setError("M_MAIL_FLG_DELETE", "必須項目です");
		}

	}

	//	save
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
		$sql  = "insert into ".mMail::tableName." (";
		$sql .= "M_MAIL_ID, ";
		$sql .= "M_MAIL_USE, ";
		$sql .= "M_MAIL_TITLE, ";
		$sql .= "M_MAIL_CONTENTS, ";
		$sql .= "M_MAIL_FLG_DELETE, ";
		$sql .= "ADMIN_ID, ";
		$sql .= "M_MAIL_MEMO, ";
		$sql .= "M_MAIL_DATE_REGIST, ";
		$sql .= "M_MAIL_DATE_UPDATE, ";
		$sql .= "M_MAIL_DATE_DELETE) ";
		$sql .= "values (";
		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["M_MAIL_USE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_MAIL_TITLE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["M_MAIL_CONTENTS"], true, 1).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= parent::expsVal($dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsVal($dataList["M_MAIL_MEMO"], true, 1).", ";
		$sql .= "now(), ";
		$sql .= "now(), ";
		$sql .= "null) ";

		return $sql;
	}

	public function update($dataList) {
		$sql  = "update ".mMail::tableName." set ";
		$sql .= parent::expsData("M_MAIL_USE","=",$dataList["M_MAIL_USE"], true, 1).", ";
		$sql .= parent::expsData("M_MAIL_TITLE","=",$dataList["M_MAIL_TITLE"], true, 1).", ";
		$sql .= parent::expsData("M_MAIL_CONTENTS","=",$dataList["M_MAIL_CONTENTS"], true, 1).", ";
		$sql .= parent::expsData("ADMIN_ID","=",$dataList["ADMIN_ID"]).", ";
		$sql .= parent::expsData("M_MAIL_MEMO","=",$dataList["M_MAIL_MEMO"], true, 1).", ";
		$sql .= "M_MAIL_DATE_UPDATE = now() ";
		$sql .= "where ";
		$sql .= mMail::keyName." = ".parent::getKeyValue()." ";
		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql  = "update ".mMail::tableName." set ";
		$sql .= "M_MAIL_FLG_DELETE = 2, ";
		$sql .= parent::expsData("ADMIN_ID","=", parent::getByKey(parent::getKeyValue(), "ADMIN_ID")).", ";
		$sql .= parent::expsData("M_MAIL_MEMO","=",parent::getByKey(parent::getKeyValue(), "M_MAIL_MEMO"), true, 1).", ";
		$sql .= "M_MAIL_DATE_DELETE = now() ";
		$sql .= "where ";
		$sql .= mMail::keyName." = ".parent::getKeyValue()." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}

}
?>