<?php
class hotelPriceType extends collection {
	const tableName = "SHOP_PRICETYPE";
	const keyName = "SHOP_PRICETYPE_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelPriceType($db) {
		parent::collection($db);
	}

// 	public function selectProvide($collection) {
// 		$sql  = "select ";
// 		$sql .= "hpay.HOTELPAY_ID, hpay.COMPANY_ID, hpay.HOTELPLAN_ID, hpay.SHOP_PRICETYPE_ID ";
// 		$sql .= "from HOTELPAY hpay ";
// 		$sql .= "inner join SHOP_PRICETYPE r on hpay.SHOP_PRICETYPE_ID = r.SHOP_PRICETYPE_ID and hpay.HOTELPAY_FLG_STOP in (1,2) ";
// 		$sql .= "inner join HOTELPLAN hp on hpay.HOTELPLAN_ID = hp.HOTELPLAN_ID and hp.HOTELPLAN_STATUS in (1,2) ";

// 		$sql .= "group by hpay.HOTELPLAN_ID "

// 	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "SHOP_PRICETYPE_ID, COMPANY_ID, ";
		$sql .= "SHOP_PRICETYPE_NAME, SHOP_PRICETYPE_KIND, SHOP_PRICETYPE_MONEY1, SHOP_PRICETYPE_MONEY2, SHOP_PRICETYPE_MONEY3, SHOP_PRICETYPE_MONEY4, SHOP_PRICETYPE_MONEY5, SHOP_PRICETYPE_MONEY6, SHOP_PRICETYPE_MONEY7, ";

		$sql .= "SHOP_PRICETYPE_MONEY1MIN, SHOP_PRICETYPE_MONEY2MIN, SHOP_PRICETYPE_MONEY3MIN, SHOP_PRICETYPE_MONEY4MIN, SHOP_PRICETYPE_MONEY5MIN, SHOP_PRICETYPE_MONEY6MIN, SHOP_PRICETYPE_MONEY7MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY1MAX, SHOP_PRICETYPE_MONEY2MAX, SHOP_PRICETYPE_MONEY3MAX, SHOP_PRICETYPE_MONEY4MAX, SHOP_PRICETYPE_MONEY5MAX, SHOP_PRICETYPE_MONEY6MAX, SHOP_PRICETYPE_MONEY7MAX, ";

		$sql .= "SHOP_PRICETYPE_MONEYKIND1, SHOP_PRICETYPE_MONEYKIND2, SHOP_PRICETYPE_MONEYKIND3, SHOP_PRICETYPE_MONEYKIND4, SHOP_PRICETYPE_MONEYKIND5, SHOP_PRICETYPE_MONEYKIND6, SHOP_PRICETYPE_MONEYKIND7, ";
		$sql .= "SHOP_PRICETYPE_ADDFLG, SHOP_PRICETYPE_ORDER, SHOP_PRICETYPE_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPriceType::keyName, "=", $collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPriceType::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";
//	print_r($sql);

		parent::setCollection($sql, hotelPriceType::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "SHOP_PRICETYPE_ID, COMPANY_ID,  ";
		$sql .= "SHOP_PRICETYPE_NAME, SHOP_PRICETYPE_KIND, SHOP_PRICETYPE_MONEY1, SHOP_PRICETYPE_MONEY2, SHOP_PRICETYPE_MONEY3, SHOP_PRICETYPE_MONEY4, SHOP_PRICETYPE_MONEY5, SHOP_PRICETYPE_MONEY6, SHOP_PRICETYPE_MONEY7, ";

		$sql .= "SHOP_PRICETYPE_MONEY1MIN, SHOP_PRICETYPE_MONEY2MIN, SHOP_PRICETYPE_MONEY3MIN, SHOP_PRICETYPE_MONEY4MIN, SHOP_PRICETYPE_MONEY5MIN, SHOP_PRICETYPE_MONEY6MIN, SHOP_PRICETYPE_MONEY7MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY1MAX, SHOP_PRICETYPE_MONEY2MAX, SHOP_PRICETYPE_MONEY3MAX, SHOP_PRICETYPE_MONEY4MAX, SHOP_PRICETYPE_MONEY5MAX, SHOP_PRICETYPE_MONEY6MAX, SHOP_PRICETYPE_MONEY7MAX, ";

		$sql .= "SHOP_PRICETYPE_MONEYKIND1, SHOP_PRICETYPE_MONEYKIND2, SHOP_PRICETYPE_MONEYKIND3, SHOP_PRICETYPE_MONEYKIND4, SHOP_PRICETYPE_MONEYKIND5, SHOP_PRICETYPE_MONEYKIND6, SHOP_PRICETYPE_MONEYKIND7, ";
		$sql .= "SHOP_PRICETYPE_ADDFLG, SHOP_PRICETYPE_ORDER, SHOP_PRICETYPE_STATUS ";

		$sql .= "from ".hotelPriceType::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPriceType::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPriceType::tableKeyName, "=", $companyId)." ";
		}

		if ($hotelPriceTypeGroupId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_ID", "=", $hotelPriceTypeGroupId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOP_PRICETYPE_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc, SHOP_PRICETYPE_ORDER ";
//	print_r($sql);

		parent::setCollection($sql, hotelPriceType::keyName);
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
			case "SHOP_PRICETYPE_PIC1":
				break;
			case "SHOP_PRICETYPE_PIC2":
				break;
			case "SHOP_PRICETYPE_PIC3":
				break;
			case "SHOP_PRICETYPE_PIC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".hotelPriceType::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPriceType::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
//print_r($dataList);
		$sql  = "insert into ".hotelPriceType::tableName." (";
		$sql .= "SHOP_PRICETYPE_ID, ";
		$sql .= "COMPANY_ID, ";

		$sql .= "SHOP_PRICETYPE_NAME, ";
		$sql .= "SHOP_PRICETYPE_KIND, ";

		$sql .= "SHOP_PRICETYPE_MONEY1, ";
		$sql .= "SHOP_PRICETYPE_MONEY2, ";
		$sql .= "SHOP_PRICETYPE_MONEY3, ";
		$sql .= "SHOP_PRICETYPE_MONEY4, ";
		$sql .= "SHOP_PRICETYPE_MONEY5, ";
		$sql .= "SHOP_PRICETYPE_MONEY6, ";
		$sql .= "SHOP_PRICETYPE_MONEY7, ";

		$sql .= "SHOP_PRICETYPE_MONEY1MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY2MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY3MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY4MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY5MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY6MIN, ";
		$sql .= "SHOP_PRICETYPE_MONEY7MIN, ";

		$sql .= "SHOP_PRICETYPE_MONEY1MAX, ";
		$sql .= "SHOP_PRICETYPE_MONEY2MAX, ";
		$sql .= "SHOP_PRICETYPE_MONEY3MAX, ";
		$sql .= "SHOP_PRICETYPE_MONEY4MAX, ";
		$sql .= "SHOP_PRICETYPE_MONEY5MAX, ";
		$sql .= "SHOP_PRICETYPE_MONEY6MAX, ";
		$sql .= "SHOP_PRICETYPE_MONEY7MAX, ";

		$sql .= "SHOP_PRICETYPE_MONEYKIND1, ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND2, ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND3, ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND4, ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND5, ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND6, ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND7, ";

		$sql .= "SHOP_PRICETYPE_ADDFLG, ";

		$sql .= "SHOP_PRICETYPE_ORDER, ";
		$sql .= "SHOP_PRICETYPE_STATUS, ";
		$sql .= "SHOP_PRICETYPE_REGIST, ";
		$sql .= "SHOP_PRICETYPE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";

		$sql .= "'".$dataList["SHOP_PRICETYPE_NAME"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_KIND"]."', ";

		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY1"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY2"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY3"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY4"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY5"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY6"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY7"]."', ";

		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY1MIN"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY2MIN"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY3MIN"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY4MIN"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY5MIN"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY6MIN"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY7MIN"]."', ";

		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY1MAX"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY2MAX"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY3MAX"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY4MAX"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY5MAX"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY6MAX"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEY7MAX"]."', ";

		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEYKIND1"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEYKIND2"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEYKIND3"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEYKIND4"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEYKIND5"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEYKIND6"]."', ";
		$sql .= "'".$dataList["SHOP_PRICETYPE_MONEYKIND7"]."', ";

		$sql .= "'".$dataList["SHOP_PRICETYPE_ADDFLG"]."', ";

		$sql .= (0).", ";
		$sql .= (1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
	print_r($sql);

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelPriceType::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";

		$sql .= "SHOP_PRICETYPE_NAME = '".$dataList["SHOP_PRICETYPE_NAME"]."', ";
		$sql .= "SHOP_PRICETYPE_KIND = '".$dataList["SHOP_PRICETYPE_KIND"]."', ";

		$sql .= "SHOP_PRICETYPE_MONEY1 = '".$dataList["SHOP_PRICETYPE_MONEY1"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY2 = '".$dataList["SHOP_PRICETYPE_MONEY2"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY3 = '".$dataList["SHOP_PRICETYPE_MONEY3"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY4 = '".$dataList["SHOP_PRICETYPE_MONEY4"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY5 = '".$dataList["SHOP_PRICETYPE_MONEY5"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY6 = '".$dataList["SHOP_PRICETYPE_MONEY6"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY7 = '".$dataList["SHOP_PRICETYPE_MONEY7"]."', ";

		$sql .= "SHOP_PRICETYPE_MONEY1MIN = '".$dataList["SHOP_PRICETYPE_MONEY1MIN"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY2MIN = '".$dataList["SHOP_PRICETYPE_MONEY2MIN"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY3MIN = '".$dataList["SHOP_PRICETYPE_MONEY3MIN"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY4MIN = '".$dataList["SHOP_PRICETYPE_MONEY4MIN"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY5MIN = '".$dataList["SHOP_PRICETYPE_MONEY5MIN"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY6MIN = '".$dataList["SHOP_PRICETYPE_MONEY6MIN"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY7MIN = '".$dataList["SHOP_PRICETYPE_MONEY7MIN"]."', ";

		$sql .= "SHOP_PRICETYPE_MONEY1MAX = '".$dataList["SHOP_PRICETYPE_MONEY1MAX"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY2MAX = '".$dataList["SHOP_PRICETYPE_MONEY2MAX"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY3MAX = '".$dataList["SHOP_PRICETYPE_MONEY3MAX"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY4MAX = '".$dataList["SHOP_PRICETYPE_MONEY4MAX"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY5MAX = '".$dataList["SHOP_PRICETYPE_MONEY5MAX"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY6MAX = '".$dataList["SHOP_PRICETYPE_MONEY6MAX"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEY7MAX = '".$dataList["SHOP_PRICETYPE_MONEY7MAX"]."', ";

		$sql .= "SHOP_PRICETYPE_MONEYKIND1 = '".$dataList["SHOP_PRICETYPE_MONEYKIND1"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND2 = '".$dataList["SHOP_PRICETYPE_MONEYKIND2"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND3 = '".$dataList["SHOP_PRICETYPE_MONEYKIND3"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND4 = '".$dataList["SHOP_PRICETYPE_MONEYKIND4"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND5 = '".$dataList["SHOP_PRICETYPE_MONEYKIND5"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND6 = '".$dataList["SHOP_PRICETYPE_MONEYKIND6"]."', ";
		$sql .= "SHOP_PRICETYPE_MONEYKIND7 = '".$dataList["SHOP_PRICETYPE_MONEYKIND7"]."', ";

		$sql .= "SHOP_PRICETYPE_ADDFLG = '".$dataList["SHOP_PRICETYPE_ADDFLG"]."', ";

		$sql .= "SHOP_PRICETYPE_STATUS = '".$dataList["SHOP_PRICETYPE_STATUS"]."', ";
		$sql .= "SHOP_PRICETYPE_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  hotelPriceType::keyName." = ".parent::getKeyValue()." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotelPriceType::tableName." set ";
		$sql .= parent::expsData("SHOP_PRICETYPE_STATUS", "=", 2).", ";
		$sql .= parent::expsData("SHOP_PRICETYPE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPriceType::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".hotelPriceType::tableName." set ";
			$sql .= parent::expsData("SHOP_PRICETYPE_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelPriceType::keyName." = ".$v." ";
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_NAME"))) {
			parent::setError("SHOP_PRICETYPE_NAME", "必須項目です");
		}
/*
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_NAME"), 30)) {
			parent::setError("SHOP_PRICETYPE_NAME", "30文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_CAPACITY_FROM"))) {
			parent::setError("SHOP_PRICETYPE_CAPACITY_FROM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_CAPACITY_FROM"), CHK_PTN_NUM)) {
			parent::setError("SHOP_PRICETYPE_CAPACITY_FROM", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_CAPACITY_FROM"), 1)) {
			parent::setError("SHOP_PRICETYPE_CAPACITY_FROM", "半角数字1文字で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_CAPACITY_TO"))) {
			parent::setError("SHOP_PRICETYPE_CAPACITY_TO", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_CAPACITY_TO"), CHK_PTN_NUM)) {
			parent::setError("SHOP_PRICETYPE_CAPACITY_TO", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_CAPACITY_TO"), 2)) {
			parent::setError("SHOP_PRICETYPE_CAPACITY_TO", "半角数字2文字で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_TYPE"))) {
			parent::setError("SHOP_PRICETYPE_TYPE", "必須項目です");
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_YEAR_FROM"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_YEAR_FROM"), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_YEAR_FROM", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_YEAR_FROM"), 4)) {
				parent::setError("SHOP_PRICETYPE_YEAR_FROM", "半角数字4文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_MONTH_FROM"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_MONTH_FROM"), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_MONTH_FROM", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_MONTH_FROM"), 2)) {
				parent::setError("SHOP_PRICETYPE_MONTH_FROM", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_DAY_FROM"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_DAY_FROM"), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_DAY_FROM", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_DAY_FROM"), 2)) {
				parent::setError("SHOP_PRICETYPE_DAY_FROM", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_YEAR_TO"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_YEAR_TO"), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_YEAR_TO", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_YEAR_TO"), 4)) {
				parent::setError("SHOP_PRICETYPE_YEAR_TO", "半角数字4文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_MONTH_TO"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_MONTH_TO"), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_MONTH_TO", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_MONTH_TO"), 2)) {
				parent::setError("SHOP_PRICETYPE_MONTH_TO", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_DAY_TO"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_DAY_TO"), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_DAY_TO", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_DAY_TO"), 2)) {
				parent::setError("SHOP_PRICETYPE_DAY_TO", "半角数字2文字で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_BREADTH"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_BREADTH"), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_BREADTH", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_BREADTH"), 10)) {
				parent::setError("SHOP_PRICETYPE_BREADTH", "半角数字10文字で入力して下さい");
			}
		}*/

		/*
		for ($i=1; $i<=7; $i++) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_NUM".$i))) {
				parent::setError("SHOP_PRICETYPE_NUM".$i, "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_NUM".$i), CHK_PTN_NUM)) {
				parent::setError("SHOP_PRICETYPE_NUM".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_PRICETYPE_NUM".$i), 2)) {
				parent::setError("SHOP_PRICETYPE_NUM".$i, "半角数字2文字で入力して下さい");
			}
		}
		*/
		


	}


	public function setPost($picFLg=false) {
		if ($_POST) {


			foreach ($_POST as $k=>$v) {

				$this->setByKey($this->getKeyValue(), $k, $v);

			}


		}

	}


}
?>