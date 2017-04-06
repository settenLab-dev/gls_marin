<?php
class activity extends collection {
	const tableName = "ACTIVITY";
	const keyName = "COMPANY_ID";
	const tableKeyName = "COMPANY_ID";

	public function activity($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";
		$sql .= "a.COMPANY_ID, COMPANY_CONTRACT_DATE_END, ";
		$sql .= parent::decryptionList("ACTIVITY_SHOPNAME, ACTIVITY_LIST_CATEGORY, ACTIVITY_LIST_CATEGORY_DETAIL, ACTIVITY_CATCHCOPY, ACTIVITY_LIST_FEATURE, ACTIVITY_LIST_AREA, ACTIVITY_TOPICKS").", ";
		for ($i=1; $i<=5; $i++) {
			$sql .= parent::decryptionList("ACTIVITY_PIC".$i).", ";
		}
		$sql .= "ACTIVITY_RECOMM_FLG, ACTIVITY_RECOMM_URL, ACTIVITY_DATE_REGIST, ";
		$sql .= parent::decryptionList("ACTIVITY_RECOMM_TITLE, ACTIVITY_RECOMM_COMMENT, ACTIVITY_RECOMM_PIC").", ";

		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME, ACTIVITY_STAFFPUSHU, ACTIVITY_TOPICKS")." ";
		$sql .= "from ".activity::tableName." a ";
		$sql .= "inner join COMPANY c on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".activity::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ACTIVITY_RECOMM_FLG") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ACTIVITY_RECOMM_FLG", "=", $collection->getByKey($collection->getKeyValue(), "ACTIVITY_RECOMM_FLG"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ACTIVITY_SHOPNAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ACTIVITY_SHOPNAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "ACTIVITY_SHOPNAME")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "ACTIVITY_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ACTIVITY_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ACTIVITY_STATUS", "in", "(2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by ACTIVITY_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, activity::keyName);
		parent::setMaxCount();
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "COMPANY_ID, ACTIVITY_POINT, ACTIVITY_POINT_TERM, ACTIVITY_BASIC_PREF_ID, ACTIVITY_ORDER, ACTIVITY_STATUS, ";
		$sql .= parent::decryptionList("ACTIVITY_SHOPNAME, ACTIVITY_LIST_CATEGORY, ACTIVITY_LIST_CATEGORY_DETAIL, ACTIVITY_LIST_FEATURE, ACTIVITY_LIST_AREA").", ";
		$sql .= parent::decryptionList("ACTIVITY_SERVICE, ACTIVITY_PIC1, ACTIVITY_PIC2, ACTIVITY_PIC3, ACTIVITY_PIC4, ACTIVITY_PIC5").", ";
		$sql .= parent::decryptionList("ACTIVITY_CATCHCOPY, ACTIVITY_STAFFPUSHU, ACTIVITY_CONTENT, ACTIVITY_TOPICKS").", ";
		for ($i=1; $i<=4; $i++) {
			$sql .= parent::decryptionList("ACTIVITY_RECOMM_PIC".$i.", ACTIVITY_RECOMM_TITLE".$i.", ACTIVITY_RECOMM_CONTENT".$i."").", ";
		}
		$sql .= parent::decryptionList("ACTIVITY_BASIC_TIME, ACTIVITY_BASIC_HOLIDAY").", ";
		$sql .= parent::decryptionList("ACTIVITY_BASIC_NUM, ACTIVITY_BASIC_GREET, ACTIVITY_BASIC_GREET_RANGE").", ";
		$sql .= parent::decryptionList("ACTIVITY_BASIC_ZIP, ACTIVITY_BASIC_CITY, ACTIVITY_BASIC_ADDRESS").", ";
		$sql .= parent::decryptionList("ACTIVITY_BASIC_TEL, ACTIVITY_BASIC_ACCESS, ACTIVITY_BASIC_PARKING").", ";
		$sql .= parent::decryptionList("ACTIVITY_BASIC_LAT, ACTIVITY_BASIC_LNG, ACTIVITY_MEMO").", ";
		$sql .= "ACTIVITY_RECOMM_FLG, ACTIVITY_RECOMM_URL, ";
		$sql .= parent::decryptionList("ACTIVITY_RECOMM_TITLE, ACTIVITY_RECOMM_COMMENT, ACTIVITY_RECOMM_PIC")." ";
		$sql .= "from ".activity::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".activity::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ACTIVITY_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, activity::keyName);
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
		$sql  = "insert into ".activity::tableName." (";
		$sql .= "COMPANY_ID, ";
		$sql .= "ACTIVITY_SHOPNAME, ";
		$sql .= "ACTIVITY_LIST_CATEGORY, ";
		$sql .= "ACTIVITY_LIST_CATEGORY_DETAIL, ";
		$sql .= "ACTIVITY_LIST_FEATURE, ";
		$sql .= "ACTIVITY_LIST_AREA, ";
		$sql .= "ACTIVITY_SERVICE, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "ACTIVITY_PIC".$i.", ";
		}
		$sql .= "ACTIVITY_CATCHCOPY, ";
		$sql .= "ACTIVITY_STAFFPUSHU, ";
		$sql .= "ACTIVITY_CONTENT, ";
		$sql .= "ACTIVITY_TOPICKS, ";
		$sql .= "ACTIVITY_POINT, ";
		$sql .= "ACTIVITY_POINT_TERM, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "ACTIVITY_RECOMM_PIC".$i.", ";
			$sql .= "ACTIVITY_RECOMM_TITLE".$i.", ";
			$sql .= "ACTIVITY_RECOMM_CONTENT".$i.", ";
		}
		$sql .= "ACTIVITY_BASIC_TIME, ";
		$sql .= "ACTIVITY_BASIC_HOLIDAY, ";
		$sql .= "ACTIVITY_BASIC_NUM, ";
		$sql .= "ACTIVITY_BASIC_GREET, ";
		$sql .= "ACTIVITY_BASIC_GREET_RANGE, ";
		$sql .= "ACTIVITY_BASIC_ZIP, ";
		$sql .= "ACTIVITY_BASIC_PREF_ID, ";
		$sql .= "ACTIVITY_BASIC_CITY, ";
		$sql .= "ACTIVITY_BASIC_ADDRESS, ";
		$sql .= "ACTIVITY_BASIC_TEL, ";
		$sql .= "ACTIVITY_BASIC_ACCESS, ";
		$sql .= "ACTIVITY_BASIC_PARKING, ";
		$sql .= "ACTIVITY_BASIC_LAT, ";
		$sql .= "ACTIVITY_BASIC_LNG, ";
		$sql .= "ACTIVITY_RECOMM_FLG, ";
		$sql .= "ACTIVITY_RECOMM_URL, ";
		$sql .= "ACTIVITY_RECOMM_TITLE, ";
		$sql .= "ACTIVITY_RECOMM_COMMENT, ";
		$sql .= "ACTIVITY_RECOMM_PIC, ";
		$sql .= "ACTIVITY_MEMO, ";
		$sql .= "ACTIVITY_ORDER, ";
		$sql .= "ACTIVITY_STATUS, ";
		$sql .= "ACTIVITY_DATE_REGIST, ";
		$sql .= "ACTIVITY_DATE_UPDATE) values (";
// 		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_SHOPNAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_LIST_CATEGORY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_LIST_CATEGORY_DETAIL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_LIST_FEATURE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_LIST_AREA"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_SERVICE"], true, 1).", ";
		for ($i=1; $i<=5; $i++) {
			$sql .= parent::expsVal($dataList["ACTIVITY_PIC".$i], true, 1).", ";
		}
		$sql .= parent::expsVal($dataList["ACTIVITY_CATCHCOPY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_STAFFPUSHU"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_CONTENT"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_TOPICKS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_POINT"]).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_POINT_TERM"]).", ";
		for ($i=1; $i<=4; $i++) {
			$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_PIC".$i], true, 1).", ";
			$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_TITLE".$i], true, 1).", ";
			$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_CONTENT".$i], true, 1).", ";
		}
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_TIME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_HOLIDAY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_NUM"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_GREET"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_GREET_RANGE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_PREF_ID"]).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_TEL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_ACCESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_PARKING"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_LAT"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_BASIC_LNG"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_FLG"]).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_URL"]).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_TITLE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_COMMENT"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_RECOMM_PIC"], true, 1).", ";
		$sql .= parent::expsVal($dataList["ACTIVITY_MEMO"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".activity::tableName." set ";
		$sql .= parent::expsData("ACTIVITY_SHOPNAME", "=", $dataList["ACTIVITY_SHOPNAME"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_LIST_CATEGORY", "=", $dataList["ACTIVITY_LIST_CATEGORY"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_LIST_CATEGORY_DETAIL", "=", $dataList["ACTIVITY_LIST_CATEGORY_DETAIL"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_LIST_FEATURE", "=", $dataList["ACTIVITY_LIST_FEATURE"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_LIST_AREA", "=", $dataList["ACTIVITY_LIST_AREA"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_SERVICE", "=", $dataList["ACTIVITY_SERVICE"], true, 1).", ";
		for ($i=1; $i<=5; $i++) {
			$sql .= parent::expsData("ACTIVITY_PIC".$i, "=", $dataList["ACTIVITY_PIC".$i], true, 1).", ";
		}
		$sql .= parent::expsData("ACTIVITY_CATCHCOPY", "=", $dataList["ACTIVITY_CATCHCOPY"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_STAFFPUSHU", "=", $dataList["ACTIVITY_STAFFPUSHU"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_CONTENT", "=", $dataList["ACTIVITY_CONTENT"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_TOPICKS", "=", $dataList["ACTIVITY_TOPICKS"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_POINT", "=", $dataList["ACTIVITY_POINT"]).", ";
		$sql .= parent::expsData("ACTIVITY_POINT_TERM", "=", $dataList["ACTIVITY_POINT_TERM"]).", ";
		for ($i=1; $i<=4; $i++) {
			$sql .= parent::expsData("ACTIVITY_RECOMM_PIC".$i, "=", $dataList["ACTIVITY_RECOMM_PIC".$i], true, 1).", ";
			$sql .= parent::expsData("ACTIVITY_RECOMM_TITLE".$i, "=", $dataList["ACTIVITY_RECOMM_TITLE".$i], true, 1).", ";
			$sql .= parent::expsData("ACTIVITY_RECOMM_CONTENT".$i, "=", $dataList["ACTIVITY_RECOMM_CONTENT".$i], true, 1).", ";
		}
		$sql .= parent::expsData("ACTIVITY_BASIC_TIME", "=", $dataList["ACTIVITY_BASIC_TIME"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_HOLIDAY", "=", $dataList["ACTIVITY_BASIC_HOLIDAY"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_NUM", "=", $dataList["ACTIVITY_BASIC_NUM"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_GREET", "=", $dataList["ACTIVITY_BASIC_GREET"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_GREET_RANGE", "=", $dataList["ACTIVITY_BASIC_GREET_RANGE"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_ZIP", "=", $dataList["ACTIVITY_BASIC_ZIP"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_PREF_ID", "=", $dataList["ACTIVITY_BASIC_PREF_ID"]).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_CITY", "=", $dataList["ACTIVITY_BASIC_CITY"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_ADDRESS", "=", $dataList["ACTIVITY_BASIC_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_TEL", "=", $dataList["ACTIVITY_BASIC_TEL"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_ACCESS", "=", $dataList["ACTIVITY_BASIC_ACCESS"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_PARKING", "=", $dataList["ACTIVITY_BASIC_PARKING"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_LAT", "=", $dataList["ACTIVITY_BASIC_LAT"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_BASIC_LNG", "=", $dataList["ACTIVITY_BASIC_LNG"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_RECOMM_FLG", "=", $dataList["ACTIVITY_RECOMM_FLG"]).", ";
		$sql .= parent::expsData("ACTIVITY_RECOMM_URL", "=", $dataList["ACTIVITY_RECOMM_URL"]).", ";
		$sql .= parent::expsData("ACTIVITY_RECOMM_TITLE", "=", $dataList["ACTIVITY_RECOMM_TITLE"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_RECOMM_COMMENT", "=", $dataList["ACTIVITY_RECOMM_COMMENT"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_RECOMM_PIC", "=", $dataList["ACTIVITY_RECOMM_PIC"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_STATUS", "=", $dataList["ACTIVITY_STATUS"]).", ";
		$sql .= parent::expsData("ACTIVITY_MEMO", "=", $dataList["ACTIVITY_MEMO"], true, 1).", ";
		$sql .= parent::expsData("ACTIVITY_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(activity::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".activity::tableName." set ";
		$sql .= parent::expsData("ACTIVITY_STATUS", "=", 3).", ";
		$sql .= parent::expsData("ACTIVITY_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(activity::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function checkBasic() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_SHOPNAME"))) {
			parent::setError("ACTIVITY_SHOPNAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ACTIVITY_SHOPNAME"), 100)) {
			parent::setError("ACTIVITY_SHOPNAME", "100文字以内で入力して下さい");
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_NUM"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_NUM"), 20)) {
				parent::setError("ACTIVITY_BASIC_NUM", "20文字以内で入力して下さい");
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_ZIP"))) {
			parent::setError("ACTIVITY_BASIC_ZIP", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_ZIP"), CHK_PTN_ZIPCODE_JP)) {
			parent::setError("ACTIVITY_BASIC_ZIP", "郵便番号は000-0000の形式で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_PREF_ID"))) {
			parent::setError("ACTIVITY_BASIC_PREF_ID", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_CITY"))) {
			parent::setError("ACTIVITY_BASIC_CITY", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_CITY"), 100)) {
			parent::setError("ACTIVITY_BASIC_CITY", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_ADDRESS"))) {
			parent::setError("ACTIVITY_BASIC_ADDRESS", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_ADDRESS"), 50)) {
			parent::setError("ACTIVITY_BASIC_ADDRESS", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_TEL"))) {
			parent::setError("ACTIVITY_BASIC_TEL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ACTIVITY_BASIC_TEL"), CHK_PTN_TEL)) {
			parent::setError("ACTIVITY_BASIC_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
		}

		if (parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_FLG") == 1) {

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_URL"))) {
				parent::setError("ACTIVITY_RECOMM_URL", "必須項目です");
			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_URL"), CHK_PTN_URL)) {
// 				parent::setError("ACTIVITY_RECOMM_URL", "URLの形式を確認して下さい");
// 			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_TITLE"))) {
				parent::setError("ACTIVITY_RECOMM_TITLE", "必須項目です");
			}
			// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_TITLE"), 30)) {
			// 				parent::setError("ACTIVITY_RECOMM_TITLE", "30文字以内で入力して下さい");
			// 			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_COMMENT"))) {
				parent::setError("ACTIVITY_RECOMM_COMMENT", "必須項目です");
			}

			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("ACTIVITY_RECOMM_PIC", IMG_RECOMMEND_SIZE, IMG_RECOMMEND_WIDTH, IMG_RECOMMEND_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("ACTIVITY_RECOMM_PIC", $msg);
				}
				else {
					// 					parent::setError("ACTIVITY_RECOMM_PIC", "必須項目です");
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_PIC", $msg);
			}

		}

	}

	public function checkList() {
		if (!$_POST) return;

		for ($i=2; $i<=5; $i++) {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("ACTIVITY_PIC".$i, IMG_ACTIVITY_LIST_SIZE, IMG_ACTIVITY_LIST_WIDTH, IMG_ACTIVITY_LIST_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("ACTIVITY_PIC".$i, $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "ACTIVITY_PIC".$i, $msg);
			}
		}

	}

	public function checkMain() {
		if (!$_POST) return;

		for ($i=1; $i<=1; $i++) {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("ACTIVITY_PIC".$i, IMG_ACTIVITY_DETAIL_SIZE, IMG_ACTIVITY_DETAIL_WIDTH, IMG_ACTIVITY_DETAIL_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("ACTIVITY_PIC".$i, $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "ACTIVITY_PIC".$i, $msg);
			}
		}

		for ($i=1; $i<=4; $i++) {

			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("ACTIVITY_RECOMM_PIC".$i, IMG_ACTIVITY_DETAIL_SIZE, IMG_ACTIVITY_DETAIL_WIDTH, IMG_ACTIVITY_DETAIL_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("ACTIVITY_RECOMM_PIC".$i, $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_PIC".$i, $msg);
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_TITLE".$i))) {
				if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ACTIVITY_RECOMM_TITLE".$i), 50)) {
					parent::setError("ACTIVITY_RECOMM_TITLE".$i, "50文字以内で入力して下さい");
				}
			}

		}

	}

	public function check() {
		if (!$_POST) return;

		$this->checkBasic();
		$this->checkList();
		$this->checkMain();

	}


	public function setPost() {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			$dataCategory = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataCategory != "") {
						$dataCategory .= ":";
					}
					$dataCategory .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY"));
			}

			$dataCategoryDetail = "";
			if (count($_POST["categoryDetail"]) > 0) {
				foreach ($_POST["categoryDetail"] as $d) {
					if ($dataCategoryDetail != "") {
						$dataCategoryDetail .= ":";
					}
					$dataCategoryDetail .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL", "");
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL"));
			}

			/*
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
					$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL"));
			}
			*/


			$dataFeature = "";
			if (count($_POST["feature"]) > 0) {
				foreach ($_POST["feature"] as $d) {
					if ($dataFeature != "") {
						$dataFeature .= ":";
					}
					$dataFeature .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_FEATURE", ":".$dataFeature.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_FEATURE", $this->getByKey($this->getKeyValue(), "ACTIVITY_LIST_FEATURE"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "ACTIVITY_LIST_AREA", $this->getByKey($this->getKeyValue(), "ACTIVITY_LIST_AREA"));
			}


		}

	}


}
?>