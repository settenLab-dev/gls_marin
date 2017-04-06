<?php
class hotelPic extends collection {
	const tableName = "HOTELPIC";
	const keyName = "HOTELPIC_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelPic($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "HOTELPIC_ID, COMPANY_ID, HOTELPICGROUP_ID,  ";
		$sql .= "HOTELPIC_DATA, HOTELPIC_DISCRIPTION, ";
		$sql .= "HOTELPIC_DISPLAY_FLG, HOTELPIC_ORDER, HOTELPIC_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPIC_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPic::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPIC_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPic::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

// 		if ($collection->getByKey($collection->getKeyValue(), "hotelPic_SHOPNAME") != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("hotelPic_SHOPNAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "hotelPic_SHOPNAME")."%", true, 4)." ";
// 		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPIC_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPIC_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPIC_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, hotelPic::keyName);
	}

	public function select($id="", $statusComma="", $companyId="", $hotelPicGroupId="") {
		$sql  = "select ";
		$sql .= "HOTELPIC_ID, COMPANY_ID, HOTELPICGROUP_ID,  ";
		$sql .= "HOTELPIC_DATA, HOTELPIC_DISCRIPTION, ";
		$sql .= "HOTELPIC_DISPLAY_FLG, HOTELPIC_ORDER, HOTELPIC_STATUS ";
		$sql .= "from ".hotelPic::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPic::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPic::tableKeyName, "=", $companyId)." ";
		}

		if ($hotelPicGroupId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_ID", "=", $hotelPicGroupId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPIC_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		
		
		$sql .= "order by COMPANY_ID desc, HOTELPICGROUP_ID ";

		
		parent::setCollection($sql, hotelPic::keyName);
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
		$sql  = "insert into ".hotelPic::tableName." (";
		$sql .= "HOTELPIC_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "HOTELPICGROUP_ID, ";
		$sql .= "HOTELPIC_DATA, ";
		$sql .= "HOTELPIC_DISCRIPTION, ";
		$sql .= "HOTELPIC_ORDER, ";
		$sql .= "HOTELPIC_DISPLAY_FLG, ";
		$sql .= "HOTELPIC_STATUS, ";
		$sql .= "HOTELPIC_DATE_REGIST, ";
		$sql .= "HOTELPIC_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";
		$sql .= $dataList["HOTELPICGROUP_ID"].", ";
		$sql .= "'".$dataList["HOTELPIC_DATA"]."', ";
		$sql .= "'".$dataList["HOTELPIC_DISCRIPTION"]."', ";
		$sql .= "0, ";
		$sql .= "'".$dataList["HOTELPIC_DISPLAY_FLG"]."', ";
		$sql .= "'".$dataList["HOTELPIC_STATUS"]."', ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//print_r($sql);
		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelPic::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";
		$sql .= "HOTELPICGROUP_ID = ".$dataList["HOTELPICGROUP_ID"].", ";
		$sql .= "HOTELPIC_DATA = '".$dataList["HOTELPIC_DATA"]."', ";
		$sql .= "HOTELPIC_DISCRIPTION = '".$dataList["HOTELPIC_DISCRIPTION"]."', ";
		$sql .= "HOTELPIC_ORDER = '".$dataList["HOTELPIC_ORDER"]."', ";
		$sql .= "HOTELPIC_DISPLAY_FLG = '".$dataList["HOTELPIC_DISPLAY_FLG"]."', ";
		$sql .= "HOTELPIC_STATUS = '".$dataList["HOTELPIC_STATUS"]."', ";
		$sql .= "HOTELPIC_DATE_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  hotelPic::keyName." = ".parent::getKeyValue()." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotelPic::tableName." set ";
		$sql .= parent::expsData("HOTELPIC_STATUS", "=", 3).", ";
		$sql .= parent::expsData("HOTELPIC_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPic::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".hotelPic::tableName." set ";
			$sql .= parent::expsData("HOTELPIC_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelPic::keyName." = ".$v." ";
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

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPICGROUP_ID"))) {
// 			parent::setError("HOTELPICGROUP_ID", "必須項目です");
// 		}

		$inputer = new inputs();
		$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
		$msg = $inputer->upload("HOTELPIC_DATA", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
		if (!$inputer->getHandle()) {
			if ($msg != "non") {
				parent::setError("HOTELPIC_DATA", $msg);
			}
			else {
				parent::setError("HOTELPIC_DATA", "必須項目です");
			}
		}
		else {
			parent::setByKey(parent::getKeyValue(), "HOTELPIC_DATA", $msg);
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPIC_DISPLAY_FLG")) or parent::getByKey(parent::getKeyValue(), "HOTELPIC_DISPLAY_FLG") <= 0) {
			parent::setError("HOTELPIC_DISPLAY_FLG", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPIC_STATUS"))) {
			parent::setError("HOTELPIC_STATUS", "必須項目です");
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
				$this->setByKey($this->getKeyValue(), "hotelPic_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPic_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelPic_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelPic_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelPic_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPic_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelPic_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelPic_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPic_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelPic_LIST_AREA"));
			}
			*/


		}

	}


}
?>