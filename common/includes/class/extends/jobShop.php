<?php
class jobShop extends collection {
	const tableName = "JOB_SHOP";
	const keyName = "SHOP_ID";
	const tableKeyName = "COMPANY_ID";

	public function jobShop($db) {
		parent::collection($db);
	}

// 	public function selectProvide($collection) {
// 		$sql  = "select ";
// 		$sql .= "hpay.HOTELPAY_ID, hpay.COMPANY_ID, hpay.HOTELPLAN_ID, hpay.SHOP_ID ";
// 		$sql .= "from HOTELPAY hpay ";
// 		$sql .= "inner join ROOM r on hpay.SHOP_ID = r.SHOP_ID and hpay.HOTELPAY_FLG_STOP in (1,2) ";
// 		$sql .= "inner join HOTELPLAN hp on hpay.HOTELPLAN_ID = hp.HOTELPLAN_ID and hp.HOTELPLAN_STATUS in (1,2) ";

// 		$sql .= "group by hpay.HOTELPLAN_ID "

// 	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "SHOP_ID, COMPANY_ID, ";
		$sql .= parent::decryptionList("SHOP_NAME, SHOP_DISCRITION").", ";
		$sql .= "SHOP_ORDER, SHOP_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "SHOP_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobShop::keyName, "=", $collection->getByKey($collection->getKeyValue(), "SHOP_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobShop::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

// 		if ($collection->getByKey($collection->getKeyValue(), "hotelSHOP_SHOPNAME") != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("hotelSHOP_SHOPNAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "hotelSHOP_SHOPNAME")."%", true, 4)." ";
// 		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelSHOP_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelSHOP_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelSHOP_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, jobShop::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "SHOP_ID, COMPANY_ID,  ";
		$sql .= parent::decryptionList("SHOP_NAME, SHOP_DISCRITION").", ";
		$sql .= parent::decryptionList("SHOP_ZIP, SHOP_CITY, SHOP_ADDRESS").", ";
		$sql .= "SHOP_ORDER, SHOP_STATUS ";

		$sql .= "from ".jobShop::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobShop::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobShop::tableKeyName, "=", $companyId)." ";
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
			$where .= parent::expsData("SHOP_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc, SHOP_ORDER ";

		parent::setCollection($sql, jobShop::keyName);
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
			case "SHOP_PIC1":
				break;
			case "SHOP_PIC2":
				break;
			case "SHOP_PIC3":
				break;
			case "SHOP_PIC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".jobShop::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobShop::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
		$sql  = "insert into ".jobShop::tableName." (";
		$sql .= "SHOP_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "SHOP_NAME, ";
		$sql .= "SHOP_DISCRITION, ";
		$sql .= "SHOP_ZIP, ";
		$sql .= "SHOP_CITY, ";
		$sql .= "SHOP_ADDRESS, ";
		$sql .= "SHOP_PIC, ";
		$sql .= "SHOP_ORDER, ";
		$sql .= "SHOP_STATUS, ";
		$sql .= "SHOP_DATE_REGIST, ";
		$sql .= "SHOP_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["SHOP_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SHOP_DISCRITION"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SHOP_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SHOP_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SHOP_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["SHOP_PIC"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".jobShop::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("SHOP_NAME", "=", $dataList["SHOP_NAME"], true, 1).", ";
		$sql .= parent::expsData("SHOP_DISCRITION", "=", $dataList["SHOP_DISCRITION"], true, 1).", ";
		$sql .= parent::expsData("SHOP_ZIP", "=", $dataList["SHOP_ZIP"], true, 1).", ";
		$sql .= parent::expsData("SHOP_CITY", "=", $dataList["SHOP_CITY"], true, 1).", ";
		$sql .= parent::expsData("SHOP_ADDRESS", "=", $dataList["SHOP_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("SHOP_PIC", "=", $dataList["SHOP_PIC"], true, 1).", ";
		$sql .= parent::expsData("SHOP_STATUS", "=", $dataList["SHOP_STATUS"]).", ";
		$sql .= parent::expsData("SHOP_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobShop::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".jobShop::tableName." set ";
		$sql .= parent::expsData("SHOP_STATUS", "=", 2).", ";
		$sql .= parent::expsData("SHOP_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobShop::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".jobShop::tableName." set ";
			$sql .= parent::expsData("SHOP_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= jobShop::keyName." = ".$v." ";
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_NAME"))) {
			parent::setError("SHOP_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_NAME"), 30)) {
			parent::setError("SHOP_NAME", "30文字以内で入力して下さい");
		}

		/*
		for ($i=1; $i<=7; $i++) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_NUM".$i))) {
				parent::setError("SHOP_NUM".$i, "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_NUM".$i), CHK_PTN_NUM)) {
				parent::setError("SHOP_NUM".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_NUM".$i), 2)) {
				parent::setError("SHOP_NUM".$i, "半角数字2文字で入力して下さい");
			}
		}
		*/
		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "SHOP_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "SHOP_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOP_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("SHOP_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("SHOP_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "SHOP_PIC".$i, $msg);
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
						case "SHOP_PIC1":
							continue;
							break;
						case "SHOP_PIC2":
							continue;
							break;
						case "SHOP_PIC3":
							continue;
							break;
						case "SHOP_PIC4":
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
// 				if ("SHOP_PIC".$i."_setup" != "") {
// 					$this->setByKey($this->getKeyValue(), "SHOP_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOP_PIC".$i."_setup"));
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
				$this->setByKey($this->getKeyValue(), "SHOP_FEATURE_LIST", ":".$dataFearture.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_FEATURE_LIST", $this->getByKey($this->getKeyValue(), "SHOP_FEATURE_LIST"));
			}

			$dataFearture2 = "";
			if (count($_POST["fearture2"]) > 0) {
				foreach ($_POST["fearture2"] as $d) {
					if ($dataFearture2 != "") {
						$dataFearture2 .= ":";
					}
					$dataFearture2 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOP_FEATURE_LIST2", ":".$dataFearture2.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_FEATURE_LIST2", $this->getByKey($this->getKeyValue(), "SHOP_FEATURE_LIST2"));
			}

			$dataFearture3 = "";
			if (count($_POST["fearture3"]) > 0) {
				foreach ($_POST["fearture3"] as $d) {
					if ($dataFearture3 != "") {
						$dataFearture3 .= ":";
					}
					$dataFearture3 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOP_FEATURE_LIST3", ":".$dataFearture3.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_FEATURE_LIST3", $this->getByKey($this->getKeyValue(), "SHOP_FEATURE_LIST3"));
			}

			$dataPet = "";
			if (count($_POST["pet"]) > 0) {
				foreach ($_POST["pet"] as $d) {
					if ($dataPet != "") {
						$dataPet .= ":";
					}
					$dataPet .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOP_PET_LIST", ":".$dataPet.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOP_PET_LIST", $this->getByKey($this->getKeyValue(), "SHOP_PET_LIST"));
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
				$this->setByKey($this->getKeyValue(), "hotelSHOP_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelSHOP_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelSHOP_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelSHOP_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelSHOP_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelSHOP_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelSHOP_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelSHOP_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelSHOP_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelSHOP_LIST_AREA"));
			}
			*/


		}

	}


}
?>