<?php
class hotelPicGroup extends collection {
	const tableName = "HOTELPICGROUP";
	const keyName = "HOTELPICGROUP_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelPicGroup($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "HOTELPICGROUP_ID, COMPANY_ID,  ";
		$sql .= "HOTELPICGROUP_NAME, ";
		$sql .= "HOTELPICGROUP_ORDER, HOTELPICGROUP_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPicGroup::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPicGroup::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_NAME")."%", true, 4)." ";
		}

		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_STATUS", "in", "(2)")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPICGROUP_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, hotelPicGroup::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "HOTELPICGROUP_ID, COMPANY_ID,  ";
		$sql .= "HOTELPICGROUP_NAME, ";
		$sql .= "HOTELPICGROUP_ORDER, HOTELPICGROUP_STATUS ";
		$sql .= "from ".hotelPicGroup::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPicGroup::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPicGroup::tableKeyName, "=", $companyId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPICGROUP_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, hotelPicGroup::keyName);
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
		$sql  = "insert into ".hotelPicGroup::tableName." (";
		$sql .= "HOTELPICGROUP_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "HOTELPICGROUP_NAME, ";
		$sql .= "HOTELPICGROUP_ORDER, ";
		$sql .= "HOTELPICGROUP_STATUS, ";
		$sql .= "HOTELPICGROUP_DATE_REGIST, ";
		$sql .= "HOTELPICGROUP_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";
		$sql .= "'".$dataList["HOTELPICGROUP_NAME"]."', ";
		$sql .= "0, ";
		$sql .= "1, ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelPicGroup::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";
		$sql .= "HOTELPICGROUP_NAME = '".$dataList["HOTELPICGROUP_NAME"]."', ";
		$sql .= "HOTELPICGROUP_ORDER = '".$dataList["HOTELPICGROUP_ORDER"]."', ";
		$sql .= "HOTELPICGROUP_STATUS = '".$dataList["HOTELPICGROUP_STATUS"]."', ";
		$sql .= "HOTELPICGROUP_DATE_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  hotelPicGroup::keyName." = ".parent::getKeyValue()." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotelPicGroup::tableName." set ";
		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPicGroup::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPICGROUP_NAME"))) {
			parent::setError("HOTELPICGROUP_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPICGROUP_NAME"), 50)) {
			parent::setError("HOTELPICGROUP_NAME", "50文字以内で入力して下さい");
		}

	}

	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".hotelPicGroup::tableName." set ";
			$sql .= parent::expsData("HOTELPICGROUP_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelPicGroup::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$this->db->commit();
		return true;
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
				$this->setByKey($this->getKeyValue(), "hotelPicGroup_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPicGroup_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelPicGroup_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelPicGroup_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelPicGroup_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPicGroup_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelPicGroup_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelPicGroup_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPicGroup_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelPicGroup_LIST_AREA"));
			}
			*/


		}

	}


}
?>