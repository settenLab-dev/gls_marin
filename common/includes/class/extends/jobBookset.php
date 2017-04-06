<?php
class jobBookset extends collection {
	const tableName = "BOOKSET";
	const keyName = "COMPANY_ID";
	const tableKeyName = "COMPANY_ID";

	public function jobBookset($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "a.COMPANY_ID, ";
		$sql .= "from ".jobBookset::tableName." a ";
		$sql .= "inner join COMPANY c on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".jobBookset::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

// 		if ($collection->getByKey($collection->getKeyValue(), "hotelBookset_SHOPNAME") != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("hotelBookset_SHOPNAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "hotelBookset_SHOPNAME")."%", true, 4)." ";
// 		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelBookset_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelBookset_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelBookset_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, jobBookset::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "COMPANY_ID, BOOKSET_CANCEL_SET,  ";
		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKSET_CANCEL_DATA".$i.", BOOKSET_CANCEL_DIVIDE".$i.", BOOKSET_CANCEL_PAY".$i.", ";
			if ($i >= 3) {
				$sql .= "BOOKSET_CANCEL_DATE_FROM".$i.", BOOKSET_CANCEL_DATE_TO".$i.", ";
			}
		}
		$sql .= parent::decryptionList("BOOKSET_CANCEL_REMARKS").", ";
		$sql .= "BOOKSET_BOOKING_DIVIDE,  ";
		$sql .= parent::decryptionList("BOOKSET_BOOKING_MAILADDRESS, BOOKSET_BOOKING_MAILADDRESS2").", ";
		$sql .= "BOOKSET_BOOKING_HOW1, BOOKSET_BOOKING_HOW2, BOOKSET_BOOKING_HOW3, ";
		$sql .= parent::decryptionList("BOOKSET_BOOKING_MAILADDRESS3").", ";
		$sql .= "BOOKSET_BOOKING_DAY, BOOKSET_BOOKING_HOUR, BOOKSET_BOOKING_MIN, ";
		$sql .= "BOOKSET_CANCEL_DAY, BOOKSET_CANCEL_HOUR, BOOKSET_CANCEL_MIN, BOOKSET_PAY_ALARM ";
		$sql .= "from ".jobBookset::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBookset::keyName, "=", $id)." ";
		}

		/*
		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelBookset_STATUS", "in", "(".$statusComma.")")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, jobBookset::keyName);
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
		$sql  = "insert into ".jobBookset::tableName." (";
		$sql .= "COMPANY_ID, ";
		$sql .= "BOOKSET_CANCEL_SET, ";
		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKSET_CANCEL_DATA".$i.", ";
			$sql .= "BOOKSET_CANCEL_DIVIDE".$i.", ";
			$sql .= "BOOKSET_CANCEL_PAY".$i.", ";
			if ($i >= 3) {
				$sql .= "BOOKSET_CANCEL_DATE_FROM".$i.",";
				$sql .= "BOOKSET_CANCEL_DATE_TO".$i.", ";
			}
		}
		$sql .= "BOOKSET_CANCEL_REMARKS, ";
		$sql .= "BOOKSET_BOOKING_DIVIDE, ";
		$sql .= "BOOKSET_BOOKING_MAILADDRESS, ";
		$sql .= "BOOKSET_BOOKING_MAILADDRESS2, ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "BOOKSET_BOOKING_HOW".$i.", ";
		}
		$sql .= "BOOKSET_BOOKING_MAILADDRESS3, ";
		$sql .= "BOOKSET_BOOKING_DAY, ";
		$sql .= "BOOKSET_BOOKING_HOUR, ";
		$sql .= "BOOKSET_BOOKING_MIN, ";
		$sql .= "BOOKSET_CANCEL_DAY, ";
		$sql .= "BOOKSET_CANCEL_HOUR, ";
		$sql .= "BOOKSET_CANCEL_MIN, ";
		$sql .= "BOOKSET_PAY_ALARM, ";
		$sql .= "BOOKSET_DATE_REGIST, ";
		$sql .= "BOOKSET_DATE_UPDATE) values (";


		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_SET"]).", ";
		for ($i=1; $i<=7; $i++) {
			$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_DATA".$i]).", ";
			$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_DIVIDE".$i]).", ";
			$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_PAY".$i]).", ";
			if ($i >= 3) {
				$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_DATE_FROM".$i]).", ";
				$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_DATE_TO".$i]).", ";
			}
		}
		$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_REMARKS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_DIVIDE"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_MAILADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_MAILADDRESS2"], true, 1).", ";
		for ($i=1; $i<=3; $i++) {
			$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_HOW".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_MAILADDRESS3"], true, 1).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_DAY"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_HOUR"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_BOOKING_MIN"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_DAY"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_HOUR"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_CANCEL_MIN"]).", ";
		$sql .= parent::expsVal($dataList["BOOKSET_PAY_ALARM"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".jobBookset::tableName." set ";
		$sql .= parent::expsData("BOOKSET_CANCEL_SET", "=", $dataList["BOOKSET_CANCEL_SET"]).", ";
		for ($i=1; $i<=7; $i++) {
			$sql .= parent::expsData("BOOKSET_CANCEL_DATA".$i, "=", $dataList["BOOKSET_CANCEL_DATA".$i]).", ";
			$sql .= parent::expsData("BOOKSET_CANCEL_DIVIDE".$i, "=", $dataList["BOOKSET_CANCEL_DIVIDE".$i]).", ";
			$sql .= parent::expsData("BOOKSET_CANCEL_PAY".$i, "=", $dataList["BOOKSET_CANCEL_PAY".$i]).", ";
			if ($i >= 3) {
				$sql .= parent::expsData("BOOKSET_CANCEL_DATE_FROM".$i, "=", $dataList["BOOKSET_CANCEL_DATE_FROM".$i]).", ";
				$sql .= parent::expsData("BOOKSET_CANCEL_DATE_TO".$i, "=", $dataList["BOOKSET_CANCEL_DATE_TO".$i]).", ";
			}
		}
		$sql .= parent::expsData("BOOKSET_CANCEL_REMARKS", "=", $dataList["BOOKSET_CANCEL_REMARKS"], true, 1).", ";
		$sql .= parent::expsData("BOOKSET_BOOKING_DIVIDE", "=", $dataList["BOOKSET_BOOKING_DIVIDE"]).", ";
		$sql .= parent::expsData("BOOKSET_BOOKING_MAILADDRESS", "=", $dataList["BOOKSET_BOOKING_MAILADDRESS"], true, 1).", ";
		$sql .= parent::expsData("BOOKSET_BOOKING_MAILADDRESS2", "=", $dataList["BOOKSET_BOOKING_MAILADDRESS2"], true, 1).", ";
		for ($i=1; $i<=3; $i++) {
			$sql .= parent::expsData("BOOKSET_BOOKING_HOW".$i, "=", $dataList["BOOKSET_BOOKING_HOW".$i]).", ";
		}
		$sql .= parent::expsData("BOOKSET_BOOKING_MAILADDRESS3", "=", $dataList["BOOKSET_BOOKING_MAILADDRESS3"], true, 1).", ";
		$sql .= parent::expsData("BOOKSET_BOOKING_DAY", "=", $dataList["BOOKSET_BOOKING_DAY"]).", ";
		$sql .= parent::expsData("BOOKSET_BOOKING_HOUR", "=", $dataList["BOOKSET_BOOKING_HOUR"]).", ";
		$sql .= parent::expsData("BOOKSET_BOOKING_MIN", "=", $dataList["BOOKSET_BOOKING_MIN"]).", ";
		$sql .= parent::expsData("BOOKSET_CANCEL_DAY", "=", $dataList["BOOKSET_CANCEL_DAY"]).", ";
		$sql .= parent::expsData("BOOKSET_CANCEL_HOUR", "=", $dataList["BOOKSET_CANCEL_HOUR"]).", ";
		$sql .= parent::expsData("BOOKSET_CANCEL_MIN", "=", $dataList["BOOKSET_CANCEL_MIN"]).", ";
		$sql .= parent::expsData("BOOKSET_PAY_ALARM", "=", $dataList["BOOKSET_PAY_ALARM"]).", ";
		$sql .= parent::expsData("BOOKSET_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobBookset::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

// 	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".jobBookset::tableName." set ";
// 		$sql .= parent::expsData("hotelBookset_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("hotelBookset_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(jobBookset::keyName, "=", parent::getKeyValue())." ";

// 		if (!parent::saveExec($sql)) {
// 			$this->db->rollback();
// 			return false;
// 		}

// 		$this->db->commit();
// 		return true;

// 	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_SET"))) {
			parent::setError("BOOKSET_CANCEL_SET", "必須項目です");
		}

		for ($i=1; $i<=7; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i))) {
					parent::setError("BOOKSET_CANCEL_DIVIDE".$i, "必須項目です");
				}

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_PAY".$i))) {
					parent::setError("BOOKSET_CANCEL_PAY".$i, "必須項目です");
				}
				elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_PAY".$i), CHK_PTN_NUM)) {
					parent::setError("BOOKSET_CANCEL_PAY".$i, "半角数字で入力して下さい");
				}
				else {
					if ($dataList["BOOKSET_CANCEL_DIVIDE".$i] == 1) {
						if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_PAY".$i), 3)) {
							parent::setError("BOOKSET_CANCEL_PAY".$i, "3文字以内で入力して下さい");
						}
					}
					else {
						if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_PAY".$i), 10)) {
							parent::setError("BOOKSET_CANCEL_PAY".$i, "10文字以内で入力して下さい");
						}
					}
				}

				if ($i >= 3) {
					if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i))) {
						parent::setError("BOOKSET_CANCEL_DATE".$i, "必須項目です");
					}
					elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i), CHK_PTN_NUM)) {
						parent::setError("BOOKSET_CANCEL_DATE".$i, "半角数字で入力して下さい");
					}
					elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DATE_FROM".$i), 2)) {
						parent::setError("BOOKSET_CANCEL_DATE".$i, "2文字以内で入力して下さい");
					}

					if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i))) {
						parent::setError("BOOKSET_CANCEL_DATE".$i, "必須項目です");
					}
					elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i), CHK_PTN_NUM)) {
						parent::setError("BOOKSET_CANCEL_DATE".$i, "半角数字で入力して下さい");
					}
					elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "BOOKSET_CANCEL_DATE_TO".$i), 2)) {
						parent::setError("BOOKSET_CANCEL_DATE".$i, "2文字以内で入力して下さい");
					}
				}

			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS"))) {
			parent::setError("BOOKSET_BOOKING_MAILADDRESS", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS"), CHK_PTN_MAILADDRESS)) {
			parent::setError("BOOKSET_BOOKING_MAILADDRESS", "メールアドレスの形式で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS"), 100)) {
			parent::setError("BOOKSET_BOOKING_MAILADDRESS", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM))) {
			parent::setError("BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM, "必須項目です");
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM))) {
				if (parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS") != parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM)) {
					parent::setError("BOOKSET_BOOKING_MAILADDRESS".WORDS_CONFIRM, "メールアドレスと確認用が一致していません");
				}
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2"), CHK_PTN_MAILADDRESS)) {
				parent::setError("BOOKSET_BOOKING_MAILADDRESS2", "メールアドレスの形式で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2"), 100)) {
				parent::setError("BOOKSET_BOOKING_MAILADDRESS2", "100文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM))) {
				parent::setError("BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM, "必須項目です");
			}
			else {
				if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM))) {
					if (parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2") != parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM)) {
						parent::setError("BOOKSET_BOOKING_MAILADDRESS2".WORDS_CONFIRM, "メールアドレスと確認用が一致していません");
					}
				}
			}

		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_HOW1"))) {
			parent::setError("BOOKSET_BOOKING_HOW1", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_HOW3"))) {
			parent::setError("BOOKSET_BOOKING_HOW3", "必須項目です");
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3"), CHK_PTN_MAILADDRESS)) {
				parent::setError("BOOKSET_BOOKING_MAILADDRESS3", "メールアドレスの形式で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3"), 100)) {
				parent::setError("BOOKSET_BOOKING_MAILADDRESS3", "100文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM))) {
				parent::setError("BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM, "必須項目です");
			}
			else {
				if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM))) {
					if (parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3") != parent::getByKey(parent::getKeyValue(), "BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM)) {
						parent::setError("BOOKSET_BOOKING_MAILADDRESS3".WORDS_CONFIRM, "メールアドレスと確認用が一致していません");
					}
				}
			}
		}

	}


	public function setPost() {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			/*
			$dataCategory = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataCategory != "") {
						$dataCategory .= ":";
					}
					$dataCategory .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelBookset_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBookset_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelBookset_LIST_CATEGORY"));
			}

			$dataCategoryDetail = "";
			if (count($_POST["category"]) > 0) {
				if (count($_POST["categoryDetail"]) > 0) {
					foreach ($_POST["category"] as $d) {
						foreach ($_POST["categoryDetail"] as $dd) {
							if ($d != $dd) {
								continue;
							}
							if ($dataCategoryDetail != "") {
								$dataCategoryDetail .= ":";
							}
							$dataCategoryDetail .= $dd;
						}
					}
					$this->setByKey($this->getKeyValue(), "hotelBookset_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelBookset_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBookset_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelBookset_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelBookset_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBookset_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelBookset_LIST_AREA"));
			}
			*/


		}

	}


}
?>