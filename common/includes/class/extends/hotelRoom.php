<?php
class hotelRoom extends collection {
	const tableName = "ROOM";
	const keyName = "ROOM_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelRoom($db) {
		parent::collection($db);
	}

// 	public function selectProvide($collection) {
// 		$sql  = "select ";
// 		$sql .= "hpay.HOTELPAY_ID, hpay.COMPANY_ID, hpay.HOTELPLAN_ID, hpay.ROOM_ID ";
// 		$sql .= "from HOTELPAY hpay ";
// 		$sql .= "inner join ROOM r on hpay.ROOM_ID = r.ROOM_ID and hpay.HOTELPAY_FLG_STOP in (1,2) ";
// 		$sql .= "inner join HOTELPLAN hp on hpay.HOTELPLAN_ID = hp.HOTELPLAN_ID and hp.HOTELPLAN_STATUS in (1,2) ";

// 		$sql .= "group by hpay.HOTELPLAN_ID "

// 	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "ROOM_ID, COMPANY_ID, ROOM_PET_FLG, ";
		$sql .= "ROOM_NAME, ROOM_DISCRITION, ";
		$sql .= "ROOM_ORDER, ROOM_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelRoom::keyName, "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelRoom::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

// 		if ($collection->getByKey($collection->getKeyValue(), "hotelRoom_SHOPNAME") != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("hotelRoom_SHOPNAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "hotelRoom_SHOPNAME")."%", true, 4)." ";
// 		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelRoom_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelRoom_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelRoom_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";
//	print_r($sql);

		parent::setCollection($sql, hotelRoom::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "ROOM_ID, COMPANY_ID,  ";
		$sql .= "ROOM_NAME, ROOM_DISCRITION, ";
		$sql .= "ROOM_CAPACITY_FROM, ROOM_CAPACITY_TO, ROOM_TYPE,  ROOM_BREADTH, ROOM_PET_FLG, ";
		$sql .= "ROOM_PET_LIST, ROOM_FEATURE_LIST, ROOM_FEATURE_LIST2, ROOM_FEATURE_LIST3, ";
		$sql .= "ROOM_YEAR_FROM, ROOM_MONTH_FROM, ROOM_DAY_FROM, ROOM_YEAR_TO, ROOM_MONTH_TO, ROOM_DAY_TO, ";
		for ($i=1; $i<=7; $i++) {
			$sql .= "ROOM_NUM".$i.", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "ROOM_PIC".$i.", ROOM_PIC_DISCRIPTION".$i.", ";
		}
		$sql .= "ROOM_ORDER, ROOM_STATUS ";

		$sql .= "from ".hotelRoom::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelRoom::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelRoom::tableKeyName, "=", $companyId)." ";
		}

		if ($hotelRoomGroupId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_ID", "=", $hotelRoomGroupId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ROOM_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc, ROOM_ORDER ";
//	print_r($sql);

		parent::setCollection($sql, hotelRoom::keyName);
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

	/*
	public function savePic($pic, $target) {

		switch ($target) {
			case "ROOM_PIC1":
				break;
			case "ROOM_PIC2":
				break;
			case "ROOM_PIC3":
				break;
			case "ROOM_PIC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".hotelRoom::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelRoom::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
		$sql  = "insert into ".hotelRoom::tableName." (";
		$sql .= "ROOM_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "ROOM_NAME, ";
		$sql .= "ROOM_DISCRITION, ";
		$sql .= "ROOM_CAPACITY_FROM, ";
		$sql .= "ROOM_CAPACITY_TO, ";
		$sql .= "ROOM_TYPE, ";
		$sql .= "ROOM_FEATURE_LIST, ";
		$sql .= "ROOM_FEATURE_LIST2, ";
		$sql .= "ROOM_FEATURE_LIST3, ";
		$sql .= "ROOM_BREADTH, ";
		$sql .= "ROOM_PET_FLG, ";
		$sql .= "ROOM_PET_LIST, ";
		$sql .= "ROOM_YEAR_FROM, ";
		$sql .= "ROOM_MONTH_FROM, ";
		$sql .= "ROOM_DAY_FROM, ";
		$sql .= "ROOM_YEAR_TO, ";
		$sql .= "ROOM_MONTH_TO, ";
		$sql .= "ROOM_DAY_TO, ";
		for ($i=1; $i<=7; $i++) {
			$sql .= "ROOM_NUM".$i.", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "ROOM_PIC".$i.", ";
			$sql .= "ROOM_PIC_DISCRIPTION".$i.", ";
		}
		$sql .= "ROOM_ORDER, ";
		$sql .= "ROOM_STATUS, ";
		$sql .= "ROOM_DATE_REGIST, ";
		$sql .= "ROOM_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";
		$sql .= "'".$dataList["ROOM_NAME"]."', ";
		$sql .= "'".$dataList["ROOM_DISCRITION"]."', ";
		$sql .= "'".$dataList["ROOM_CAPACITY_FROM"]."', ";
		$sql .= "'".$dataList["ROOM_CAPACITY_TO"]."', ";
		$sql .= "'".$dataList["ROOM_TYPE"]."', ";
		$sql .= "'".$dataList["ROOM_FEATURE_LIST"]."', ";
		$sql .= "'".$dataList["ROOM_FEATURE_LIST2"]."', ";
		$sql .= "'".$dataList["ROOM_FEATURE_LIST3"]."', ";
		$sql .= "'".$dataList["ROOM_BREADTH"]."', ";
		$sql .= "'".$dataList["ROOM_PET_FLG"]."', ";
		$sql .= "'".$dataList["ROOM_PET_LIST"]."', ";
		$sql .= "'".$dataList["ROOM_YEAR_FROM"]."', ";
		$sql .= "'".$dataList["ROOM_MONTH_FROM"]."', ";
		$sql .= "'".$dataList["ROOM_DAY_FROM"]."', ";
		$sql .= "'".$dataList["ROOM_YEAR_TO"]."', ";
		$sql .= "'".$dataList["ROOM_MONTH_TO"]."', ";
		$sql .= "'".$dataList["ROOM_DAY_TO"]."', ";
		for ($i=1; $i<=7; $i++) {
			$sql .= "'".$dataList["ROOM_NUM".$i]."', ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["ROOM_PIC".$i]."', ";
			$sql .= "'".$dataList["ROOM_PIC_DISCRIPTION".$i]."', ";
		}
		$sql .= (0).", ";
		$sql .= (1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//	print_r($sql);

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelRoom::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";
		$sql .= "ROOM_NAME = '".$dataList["ROOM_NAME"]."', ";
		$sql .= "ROOM_DISCRITION = '".$dataList["ROOM_DISCRITION"]."', ";
		$sql .= "ROOM_CAPACITY_FROM = '".$dataList["ROOM_CAPACITY_FROM"]."', ";
		$sql .= "ROOM_CAPACITY_TO = '".$dataList["ROOM_CAPACITY_TO"]."', ";
		$sql .= "ROOM_TYPE = '".$dataList["ROOM_TYPE"]."', ";
		$sql .= "ROOM_FEATURE_LIST = '".$dataList["ROOM_FEATURE_LIST"]."', ";
		$sql .= "ROOM_FEATURE_LIST2 = '".$dataList["ROOM_FEATURE_LIST2"]."', ";
		$sql .= "ROOM_FEATURE_LIST3 = '".$dataList["ROOM_FEATURE_LIST3"]."', ";
		$sql .= "ROOM_BREADTH = '".$dataList["ROOM_BREADTH"]."', ";
		$sql .= "ROOM_PET_FLG = '".$dataList["ROOM_PET_FLG"]."', ";
		$sql .= "ROOM_PET_LIST = '".$dataList["ROOM_PET_LIST"]."', ";
		$sql .= "ROOM_YEAR_FROM = '".$dataList["ROOM_YEAR_FROM"]."', ";
		$sql .= "ROOM_MONTH_FROM = '".$dataList["ROOM_MONTH_FROM"]."', ";
		$sql .= "ROOM_DAY_FROM = '".$dataList["ROOM_DAY_FROM"]."', ";
		$sql .= "ROOM_YEAR_TO = '".$dataList["ROOM_YEAR_TO"]."', ";
		$sql .= "ROOM_MONTH_TO = '".$dataList["ROOM_MONTH_TO"]."', ";
		$sql .= "ROOM_DAY_TO = '".$dataList["ROOM_DAY_TO"]."', ";
		for ($i=1; $i<=7; $i++) {
			$sql .= "ROOM_NUM".$i." = '".$dataList["ROOM_NUM".$i]."', ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "ROOM_PIC".$i." = '".$dataList["ROOM_PIC".$i]."', ";
			$sql .= "ROOM_PIC_DISCRIPTION".$i." = '".$dataList["ROOM_PIC_DISCRIPTION".$i]."', ";
		}
		$sql .= "ROOM_STATUS = '".$dataList["ROOM_STATUS"]."', ";
		$sql .= "ROOM_DATE_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  hotelRoom::keyName." = ".parent::getKeyValue()." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotelRoom::tableName." set ";
		$sql .= parent::expsData("ROOM_STATUS", "=", 2).", ";
		$sql .= parent::expsData("ROOM_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelRoom::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".hotelRoom::tableName." set ";
			$sql .= parent::expsData("ROOM_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelRoom::keyName." = ".$v." ";
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_NAME"))) {
			parent::setError("ROOM_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_NAME"), 30)) {
			parent::setError("ROOM_NAME", "30文字以内で入力して下さい");
		}
/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_CAPACITY_FROM"))) {
			parent::setError("ROOM_CAPACITY_FROM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_CAPACITY_FROM"), CHK_PTN_NUM)) {
			parent::setError("ROOM_CAPACITY_FROM", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_CAPACITY_FROM"), 1)) {
			parent::setError("ROOM_CAPACITY_FROM", "半角数字1文字で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_CAPACITY_TO"))) {
			parent::setError("ROOM_CAPACITY_TO", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_CAPACITY_TO"), CHK_PTN_NUM)) {
			parent::setError("ROOM_CAPACITY_TO", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_CAPACITY_TO"), 2)) {
			parent::setError("ROOM_CAPACITY_TO", "半角数字2文字で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_TYPE"))) {
			parent::setError("ROOM_TYPE", "必須項目です");
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_YEAR_FROM"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_YEAR_FROM"), CHK_PTN_NUM)) {
				parent::setError("ROOM_YEAR_FROM", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_YEAR_FROM"), 4)) {
				parent::setError("ROOM_YEAR_FROM", "半角数字4文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_MONTH_FROM"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_MONTH_FROM"), CHK_PTN_NUM)) {
				parent::setError("ROOM_MONTH_FROM", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_MONTH_FROM"), 2)) {
				parent::setError("ROOM_MONTH_FROM", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_DAY_FROM"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_DAY_FROM"), CHK_PTN_NUM)) {
				parent::setError("ROOM_DAY_FROM", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_DAY_FROM"), 2)) {
				parent::setError("ROOM_DAY_FROM", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_YEAR_TO"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_YEAR_TO"), CHK_PTN_NUM)) {
				parent::setError("ROOM_YEAR_TO", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_YEAR_TO"), 4)) {
				parent::setError("ROOM_YEAR_TO", "半角数字4文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_MONTH_TO"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_MONTH_TO"), CHK_PTN_NUM)) {
				parent::setError("ROOM_MONTH_TO", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_MONTH_TO"), 2)) {
				parent::setError("ROOM_MONTH_TO", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_DAY_TO"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_DAY_TO"), CHK_PTN_NUM)) {
				parent::setError("ROOM_DAY_TO", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_DAY_TO"), 2)) {
				parent::setError("ROOM_DAY_TO", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_BREADTH"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_BREADTH"), CHK_PTN_NUM)) {
				parent::setError("ROOM_BREADTH", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_BREADTH"), 10)) {
				parent::setError("ROOM_BREADTH", "半角数字10文字で入力して下さい");
			}
		}
*/
		/*
		for ($i=1; $i<=7; $i++) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "ROOM_NUM".$i))) {
				parent::setError("ROOM_NUM".$i, "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "ROOM_NUM".$i), CHK_PTN_NUM)) {
				parent::setError("ROOM_NUM".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "ROOM_NUM".$i), 2)) {
				parent::setError("ROOM_NUM".$i, "半角数字2文字で入力して下さい");
			}
		}
		*/
		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "ROOM_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "ROOM_PIC".$i, $this->getByKey($this->getKeyValue(), "ROOM_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("ROOM_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("ROOM_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "ROOM_PIC".$i, $msg);
				}
			}
		}


	}


	public function setPost($picFLg=false) {
		if ($_POST) {


			foreach ($_POST as $k=>$v) {
				/*
				if ($picFLg) {
					switch ($k) {
						case "ROOM_PIC1":
							continue;
							break;
						case "ROOM_PIC2":
							continue;
							break;
						case "ROOM_PIC3":
							continue;
							break;
						case "ROOM_PIC4":
							continue;
							break;
						default:
							$this->setByKey($this->getKeyValue(), $k, $v);
					}
				}else {
					$this->setByKey($this->getKeyValue(), $k, $v);
				}
			*/

				$this->setByKey($this->getKeyValue(), $k, $v);

			}

// 			for ($i=1; $i<=4; $i++) {
// 				if ("ROOM_PIC".$i."_setup" != "") {
// 					$this->setByKey($this->getKeyValue(), "ROOM_PIC".$i, $this->getByKey($this->getKeyValue(), "ROOM_PIC".$i."_setup"));
// 				}
// 			}

			$dataFearture = "";
			if (count($_POST["fearture"]) > 0) {
				foreach ($_POST["fearture"] as $d) {
					if ($dataFearture != "") {
						$dataFearture .= ":";
					}
					$dataFearture .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ROOM_FEATURE_LIST", ":".$dataFearture.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "ROOM_FEATURE_LIST", $this->getByKey($this->getKeyValue(), "ROOM_FEATURE_LIST"));
			}

			$dataFearture2 = "";
			if (count($_POST["fearture2"]) > 0) {
				foreach ($_POST["fearture2"] as $d) {
					if ($dataFearture2 != "") {
						$dataFearture2 .= ":";
					}
					$dataFearture2 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ROOM_FEATURE_LIST2", ":".$dataFearture2.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "ROOM_FEATURE_LIST2", $this->getByKey($this->getKeyValue(), "ROOM_FEATURE_LIST2"));
			}

			$dataFearture3 = "";
			if (count($_POST["fearture3"]) > 0) {
				foreach ($_POST["fearture3"] as $d) {
					if ($dataFearture3 != "") {
						$dataFearture3 .= ":";
					}
					$dataFearture3 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ROOM_FEATURE_LIST3", ":".$dataFearture3.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "ROOM_FEATURE_LIST3", $this->getByKey($this->getKeyValue(), "ROOM_FEATURE_LIST3"));
			}

			$dataPet = "";
			if (count($_POST["pet"]) > 0) {
				foreach ($_POST["pet"] as $d) {
					if ($dataPet != "") {
						$dataPet .= ":";
					}
					$dataPet .= $d;
				}
				$this->setByKey($this->getKeyValue(), "ROOM_PET_LIST", ":".$dataPet.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "ROOM_PET_LIST", $this->getByKey($this->getKeyValue(), "ROOM_PET_LIST"));
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
				$this->setByKey($this->getKeyValue(), "hotelRoom_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelRoom_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelRoom_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelRoom_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelRoom_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelRoom_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelRoom_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelRoom_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelRoom_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelRoom_LIST_AREA"));
			}
			*/


		}

	}


}
?>