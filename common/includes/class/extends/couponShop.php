<?php
class couponShop extends collection {
	const tableName = "COUPONSHOP";
	const keyName = "COUPONSHOP_ID";
	const tableKeyName = "COMPANY_ID";

	public function couponShop($db) {
		parent::collection($db);
	}

// 	public function selectProvide($collection) {
// 		$sql  = "select ";
// 		$sql .= "hpay.HOTELPAY_ID, hpay.COMPANY_ID, hpay.HOTELPLAN_ID, hpay.COUPONSHOP_ID ";
// 		$sql .= "from HOTELPAY hpay ";
// 		$sql .= "inner join ROOM r on hpay.COUPONSHOP_ID = r.COUPONSHOP_ID and hpay.HOTELPAY_FLG_STOP in (1,2) ";
// 		$sql .= "inner join HOTELPLAN hp on hpay.HOTELPLAN_ID = hp.HOTELPLAN_ID and hp.HOTELPLAN_STATUS in (1,2) ";

// 		$sql .= "group by hpay.HOTELPLAN_ID "

// 	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "COUPONSHOP_ID, COMPANY_ID, ";
		$sql .= parent::decryptionList("COUPONSHOP_NAME, COUPONSHOP_DETAIL").", ";
		$sql .= "COUPONSHOP_ORDER, COUPONSHOP_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponShop::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COUPONSHOP_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponShop::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

// 		if ($collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_COUPONSHOPNAME") != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("hotelCOUPONSHOP_COUPONSHOPNAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_COUPONSHOPNAME")."%", true, 4)." ";
// 		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelCOUPONSHOP_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelCOUPONSHOP_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelCOUPONSHOP_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, couponShop::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "COUPONSHOP_ID, COMPANY_ID,  ";
		$sql .= parent::decryptionList("COUPONSHOP_NAME, COUPONSHOP_KANA, COUPONSHOP_DETAIL, COUPONSHOP_PIC").", ";
		$sql .= parent::decryptionList(" COUPONSHOP_ADDRESS, COUPONSHOP_ACCESS, COUPONSHOP_TEL, COUPONSHOP_MEMO, COUPONSHOP_OPEN, COUPONSHOP_HOLYDAY").", ";
		$sql .= "COUPONSHOP_ORDER, COUPONSHOP_STATUS ";

		$sql .= "from ".couponShop::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponShop::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponShop::tableKeyName, "=", $companyId)." ";
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
			$where .= parent::expsData("COUPONSHOP_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc, COUPONSHOP_ORDER ";

		parent::setCollection($sql, couponShop::keyName);
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
			case "COUPONSHOP_PIC1":
				break;
			case "COUPONSHOP_PIC2":
				break;
			case "COUPONSHOP_PIC3":
				break;
			case "COUPONSHOP_PIC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".couponShop::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponShop::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
		$sql  = "insert into ".couponShop::tableName." (";
		$sql .= "COUPONSHOP_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "COUPONSHOP_NAME, ";
		$sql .= "COUPONSHOP_KANA, ";
		$sql .= "COUPONSHOP_DETAIL, ";
		$sql .= "COUPONSHOP_ADDRESS, ";
		$sql .= "COUPONSHOP_TEL, ";
		$sql .= "COUPONSHOP_ACCESS, ";
		$sql .= "COUPONSHOP_OPEN, ";
		$sql .= "COUPONSHOP_HOLYDAY, ";
		$sql .= "COUPONSHOP_MEMO, ";
		$sql .= "COUPONSHOP_PIC, ";
		$sql .= "COUPONSHOP_ORDER, ";
		$sql .= "COUPONSHOP_STATUS, ";
		$sql .= "COUPONSHOP_DATE_REGIST, ";
		$sql .= "COUPONSHOP_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_KANA"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_DETAIL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_TEL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_ACCESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_OPEN"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_HOLYDAY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_MEMO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONSHOP_PIC"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".couponShop::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("COUPONSHOP_NAME", "=", $dataList["COUPONSHOP_NAME"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_KANA", "=", $dataList["COUPONSHOP_KANA"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_DETAIL", "=", $dataList["COUPONSHOP_DETAIL"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_ADDRESS", "=", $dataList["COUPONSHOP_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_TEL", "=", $dataList["COUPONSHOP_TEL"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_ACCESS", "=", $dataList["COUPONSHOP_ACCESS"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_OPEN", "=", $dataList["COUPONSHOP_OPEN"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_HOLYDAY", "=", $dataList["COUPONSHOP_HOLYDAY"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_MEMO", "=", $dataList["COUPONSHOP_MEMO"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_PIC", "=", $dataList["COUPONSHOP_PIC"], true, 1).", ";
		$sql .= parent::expsData("COUPONSHOP_STATUS", "=", $dataList["COUPONSHOP_STATUS"]).", ";
		$sql .= parent::expsData("COUPONSHOP_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponShop::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".couponShop::tableName." set ";
		$sql .= parent::expsData("COUPONSHOP_STATUS", "=", 2).", ";
		$sql .= parent::expsData("COUPONSHOP_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponShop::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".couponShop::tableName." set ";
			$sql .= parent::expsData("COUPONSHOP_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= couponShop::keyName." = ".$v." ";
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONSHOP_NAME"))) {
			parent::setError("COUPONSHOP_NAME", "??????????????????");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPONSHOP_NAME"), 30)) {
			parent::setError("COUPONSHOP_NAME", "30????????????????????????????????????");
		}

		/*
		for ($i=1; $i<=7; $i++) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONSHOP_NUM".$i))) {
				parent::setError("COUPONSHOP_NUM".$i, "??????????????????");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPONSHOP_NUM".$i), CHK_PTN_NUM)) {
				parent::setError("COUPONSHOP_NUM".$i, "????????????????????????????????????");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPONSHOP_NUM".$i), 2)) {
				parent::setError("COUPONSHOP_NUM".$i, "????????????2??????????????????????????????");
			}
		}
		*/
		if (parent::getByKey(parent::getKeyValue(), "COUPONPLAN_PIC_setup") != "") {
			$this->setByKey($this->getKeyValue(), "COUPONPLAN_PIC", $this->getByKey($this->getKeyValue(), "COUPONPLAN_PIC_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("COUPONSHOP_PIC", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("COUPONSHOP_PIC", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "COUPONSHOP_PIC", $msg);
			}
		}
/*
		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "COUPONSHOP_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_PIC".$i, $this->getByKey($this->getKeyValue(), "COUPONSHOP_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("COUPONSHOP_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("COUPONSHOP_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "COUPONSHOP_PIC".$i, $msg);
				}
			}
		}
*/

	}


	public function setPost($picFLg=false) {
		if ($_POST) {


			foreach ($_POST as $k=>$v) {
				/*
				if ($picFLg) {
					switch ($k) {
						case "COUPONSHOP_PIC1":
							continue;
							break;
						case "COUPONSHOP_PIC2":
							continue;
							break;
						case "COUPONSHOP_PIC3":
							continue;
							break;
						case "COUPONSHOP_PIC4":
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
// 				if ("COUPONSHOP_PIC".$i."_setup" != "") {
// 					$this->setByKey($this->getKeyValue(), "COUPONSHOP_PIC".$i, $this->getByKey($this->getKeyValue(), "COUPONSHOP_PIC".$i."_setup"));
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
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST", ":".$dataFearture.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST", $this->getByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST"));
			}

			$dataFearture2 = "";
			if (count($_POST["fearture2"]) > 0) {
				foreach ($_POST["fearture2"] as $d) {
					if ($dataFearture2 != "") {
						$dataFearture2 .= ":";
					}
					$dataFearture2 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST2", ":".$dataFearture2.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST2", $this->getByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST2"));
			}

			$dataFearture3 = "";
			if (count($_POST["fearture3"]) > 0) {
				foreach ($_POST["fearture3"] as $d) {
					if ($dataFearture3 != "") {
						$dataFearture3 .= ":";
					}
					$dataFearture3 .= $d;
				}
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST3", ":".$dataFearture3.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST3", $this->getByKey($this->getKeyValue(), "COUPONSHOP_FEATURE_LIST3"));
			}

			$dataPet = "";
			if (count($_POST["pet"]) > 0) {
				foreach ($_POST["pet"] as $d) {
					if ($dataPet != "") {
						$dataPet .= ":";
					}
					$dataPet .= $d;
				}
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_PET_LIST", ":".$dataPet.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "COUPONSHOP_PET_LIST", $this->getByKey($this->getKeyValue(), "COUPONSHOP_PET_LIST"));
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
				$this->setByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelCOUPONSHOP_LIST_AREA"));
			}
			*/


		}

	}


}
?>