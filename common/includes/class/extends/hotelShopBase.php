<?php
class hotelShopBase extends collection {
	const tableName = "SHOP_BASE";
	const keyName = "SHOP_BASE_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelShopBase($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "SHOP_BASE_ID, COMPANY_ID, SHOP_BASE_PET_FLG, ";
		$sql .= "SHOP_BASE_NAME, SHOP_BASE_DISCRITION, ";
		$sql .= parent::decryptionList("SHOP_BASE_HOST, SHOP_BASE_MAIL, SHOP_BASE_TEL").", ";
		$sql .= "SHOP_BASE_ORDER, SHOP_BASE_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "SHOP_BASE_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelShopBase::keyName, "=", $collection->getByKey($collection->getKeyValue(), "SHOP_BASE_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelShopBase::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}



		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";
//	print_r($sql);

		parent::setCollection($sql, hotelShopBase::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "SHOP_BASE_ID, COMPANY_ID,  ";
		$sql .= "SHOP_BASE_NAME, SHOP_BASE_DISCRITION, ";
		$sql .= parent::decryptionList("SHOP_BASE_HOST, SHOP_BASE_MAIL, SHOP_BASE_TEL").", ";
		$sql .= "SHOP_BASE_CAPACITY_FROM, SHOP_BASE_CAPACITY_TO, SHOP_BASE_PET_FLG, ";
		$sql .= "SHOP_BASE_PET_LIST, SHOP_BASE_FEATURE_LIST, SHOP_BASE_FEATURE_LIST2, SHOP_BASE_FEATURE_LIST3, ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "SHOP_BASE_PIC".$i.", SHOP_BASE_PIC_DISCRIPTION".$i.", ";
		}
		$sql .= "SHOP_BASE_ORDER, SHOP_BASE_STATUS ";

		$sql .= "from ".hotelShopBase::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelShopBase::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelShopBase::tableKeyName, "=", $companyId)." ";
		}

		if ($hotelShopBaseGroupId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_ID", "=", $hotelShopBaseGroupId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOP_BASE_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc, SHOP_BASE_ORDER ";
//	print_r($sql);

		parent::setCollection($sql, hotelShopBase::keyName);
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
			case "SHOP_BASE_PIC1":
				break;
			case "SHOP_BASE_PIC2":
				break;
			case "SHOP_BASE_PIC3":
				break;
			case "SHOP_BASE_PIC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".hotelShopBase::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelShopBase::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {

		$sql  = "insert into ".hotelShopBase::tableName." (";
		$sql .= "SHOP_BASE_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "SHOP_BASE_NAME, ";
		$sql .= "SHOP_BASE_DISCRITION, ";

		$sql .= "SHOP_BASE_MAIL, ";
		$sql .= "SHOP_BASE_TEL, ";
		$sql .= "SHOP_BASE_HOST, ";

		$sql .= "SHOP_BASE_CAPACITY_FROM, ";
		$sql .= "SHOP_BASE_CAPACITY_TO, ";
	//	$sql .= "SHOP_BASE_TYPE, ";
	//	$sql .= "SHOP_BASE_FEATURE_LIST, ";
		$sql .= "SHOP_BASE_FEATURE_LIST2, ";
		$sql .= "SHOP_BASE_FEATURE_LIST3, ";
		$sql .= "SHOP_BASE_PET_FLG, ";
		$sql .= "SHOP_BASE_PET_LIST, ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "SHOP_BASE_PIC".$i.", ";
			$sql .= "SHOP_BASE_PIC_DISCRIPTION".$i.", ";
		}
		$sql .= "SHOP_BASE_ORDER, ";
		$sql .= "SHOP_BASE_STATUS, ";
		$sql .= "SHOP_BASE_DATE_REGIST, ";
		$sql .= "SHOP_BASE_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";
		$sql .= "'".$dataList["SHOP_BASE_NAME"]."', ";
		$sql .= "'".$dataList["SHOP_BASE_DISCRITION"]."', ";

		$sql .= parent::expsVal($dataList["SHOP_BASE_MAIL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SHOP_BASE_TEL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SHOP_BASE_HOST"], true, 1).", ";

		$sql .= "'".$dataList["SHOP_BASE_CAPACITY_FROM"]."', ";
		$sql .= "'".$dataList["SHOP_BASE_CAPACITY_TO"]."', ";
//		$sql .= "'".$dataList["SHOP_BASE_TYPE"]."', ";
//		$sql .= "'".$dataList["SHOP_BASE_FEATURE_LIST"]."', ";
		$sql .= "'".$dataList["SHOP_BASE_FEATURE_LIST2"]."', ";
		$sql .= "'".$dataList["SHOP_BASE_FEATURE_LIST3"]."', ";

		$sql .= "'".$dataList["SHOP_BASE_PET_FLG"]."', ";
		$sql .= "'".$dataList["SHOP_BASE_PET_LIST"]."', ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["SHOP_BASE_PIC".$i]."', ";
			$sql .= "'".$dataList["SHOP_BASE_PIC_DISCRIPTION".$i]."', ";
		}
		$sql .= (0).", ";
		$sql .= (1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
	print_r($sql);

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelShopBase::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";
		$sql .= "SHOP_BASE_NAME = '".$dataList["SHOP_BASE_NAME"]."', ";
		$sql .= "SHOP_BASE_DISCRITION = '".$dataList["SHOP_BASE_DISCRITION"]."', ";

		$sql .= parent::expsData("SHOP_BASE_MAIL", "=", $dataList["SHOP_BASE_MAIL"], true, 1).", ";
		$sql .= parent::expsData("SHOP_BASE_TEL", "=", $dataList["SHOP_BASE_TEL"], true, 1).", ";
		$sql .= parent::expsData("SHOP_BASE_HOST", "=", $dataList["SHOP_BASE_HOST"], true, 1).", ";

		$sql .= "SHOP_BASE_CAPACITY_FROM = '".$dataList["SHOP_BASE_CAPACITY_FROM"]."', ";
		$sql .= "SHOP_BASE_CAPACITY_TO = '".$dataList["SHOP_BASE_CAPACITY_TO"]."', ";
	//	$sql .= "SHOP_BASE_TYPE = '".$dataList["SHOP_BASE_TYPE"]."', ";
	//	$sql .= "SHOP_BASE_FEATURE_LIST = '".$dataList["SHOP_BASE_FEATURE_LIST"]."', ";
		$sql .= "SHOP_BASE_FEATURE_LIST2 = '".$dataList["SHOP_BASE_FEATURE_LIST2"]."', ";
		$sql .= "SHOP_BASE_FEATURE_LIST3 = '".$dataList["SHOP_BASE_FEATURE_LIST3"]."', ";

		$sql .= "SHOP_BASE_PET_FLG = '".$dataList["SHOP_BASE_PET_FLG"]."', ";
		$sql .= "SHOP_BASE_PET_LIST = '".$dataList["SHOP_BASE_PET_LIST"]."', ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "SHOP_BASE_PIC".$i." = '".$dataList["SHOP_BASE_PIC".$i]."', ";
			$sql .= "SHOP_BASE_PIC_DISCRIPTION".$i." = '".$dataList["SHOP_BASE_PIC_DISCRIPTION".$i]."', ";
		}
		$sql .= "SHOP_BASE_STATUS = '".$dataList["SHOP_BASE_STATUS"]."', ";
		$sql .= "SHOP_BASE_DATE_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  hotelShopBase::keyName." = ".parent::getKeyValue()." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotelShopBase::tableName." set ";
		$sql .= parent::expsData("SHOP_BASE_STATUS", "=", 2).", ";
		$sql .= parent::expsData("SHOP_BASE_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelShopBase::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".hotelShopBase::tableName." set ";
			$sql .= parent::expsData("SHOP_BASE_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelShopBase::keyName." = ".$v." ";
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_NAME"))) {
			parent::setError("SHOP_BASE_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_NAME"), 30)) {
			parent::setError("SHOP_BASE_NAME", "30文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_MAIL"))) {
			parent::setError("SHOP_BASE_MAIL", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_TEL"))) {
			parent::setError("SHOP_BASE_TEL", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_CAPACITY_FROM"))) {
			parent::setError("SHOP_BASE_CAPACITY_FROM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_CAPACITY_FROM"), CHK_PTN_NUM)) {
			parent::setError("SHOP_BASE_CAPACITY_FROM", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_CAPACITY_FROM"), 1)) {
			parent::setError("SHOP_BASE_CAPACITY_FROM", "半角数字1文字で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_CAPACITY_TO"))) {
			parent::setError("SHOP_BASE_CAPACITY_TO", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_CAPACITY_TO"), CHK_PTN_NUM)) {
			parent::setError("SHOP_BASE_CAPACITY_TO", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_BASE_CAPACITY_TO"), 2)) {
			parent::setError("SHOP_BASE_CAPACITY_TO", "半角数字2文字で入力して下さい");
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "SHOP_BASE_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOP_BASE_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("SHOP_BASE_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("SHOP_BASE_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "SHOP_BASE_PIC".$i, $msg);
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
						case "SHOP_BASE_PIC1":
							continue;
							break;
						case "SHOP_BASE_PIC2":
							continue;
							break;
						case "SHOP_BASE_PIC3":
							continue;
							break;
						case "SHOP_BASE_PIC4":
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
// 				if ("SHOP_BASE_PIC".$i."_setup" != "") {
// 					$this->setByKey($this->getKeyValue(), "SHOP_BASE_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOP_BASE_PIC".$i."_setup"));
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
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST", ":".$dataFearture.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST", $this->getByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST"));
			}

			$dataFearture2 = "";
			if (count($_POST["fearture2"]) > 0) {
				foreach ($_POST["fearture2"] as $d) {
					if ($dataFearture2 != "") {
						$dataFearture2 .= ":";
					}
					$dataFearture2 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST2", ":".$dataFearture2.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST2", $this->getByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST2"));
			}

			$dataFearture3 = "";
			if (count($_POST["fearture3"]) > 0) {
				foreach ($_POST["fearture3"] as $d) {
					if ($dataFearture3 != "") {
						$dataFearture3 .= ":";
					}
					$dataFearture3 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST3", ":".$dataFearture3.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST3", $this->getByKey($this->getKeyValue(), "SHOP_BASE_FEATURE_LIST3"));
			}

			$dataPet = "";
			if (count($_POST["pet"]) > 0) {
				foreach ($_POST["pet"] as $d) {
					if ($dataPet != "") {
						$dataPet .= ":";
					}
					$dataPet .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_PET_LIST", ":".$dataPet.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_BASE_PET_LIST", $this->getByKey($this->getKeyValue(), "SHOP_BASE_PET_LIST"));
			}




		}

	}


}
?>