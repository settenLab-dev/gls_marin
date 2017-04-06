<?php
class ShopAccess extends collection {
	const tableName = "SHOP_ACCESS";
	const keyName = "SHOP_ACCESS_ID";
	const tableKeyName = "COMPANY_ID";

	public function ShopAccess($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "SHOP_ACCESS_ID, COMPANY_ID,  ";
		$sql .= "SHOP_ACCESS_NAME, SHOP_ACCESS_ADDRESS, SHOP_ACCESS_PUBLICFLG, SHOP_ACCESS_ROUTE, SHOP_ACCESS_PARKINGFLG, SHOP_ACCESS_PARKINGCAP, SHOP_ACCESS_PARKINGMONEYFLG, ";
		$sql .= "SHOP_ACCESS_PARKINGMONEY, SHOP_ACCESS_PARKINGBOOKFLG, SHOP_ACCESS_ZIP, SHOP_ACCESS_TEL, ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "SHOP_ACCESS_PIC".$i.", SHOP_ACCESS_PIC_DISCRIPTION".$i.", ";
		}
		$sql .= "SHOP_ACCESS_ORDER, SHOP_ACCESS_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "SHOP_ACCESS_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".ShopAccess::keyName, "=", $collection->getByKey($collection->getKeyValue(), "SHOP_ACCESS_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".ShopAccess::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}



		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";
//	print_r($sql);

		parent::setCollection($sql, ShopAccess::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "SHOP_ACCESS_ID, COMPANY_ID,  ";
		$sql .= "SHOP_ACCESS_NAME, SHOP_ACCESS_ADDRESS, SHOP_ACCESS_PUBLICFLG, SHOP_ACCESS_ROUTE, SHOP_ACCESS_PARKINGFLG, SHOP_ACCESS_PARKINGCAP, SHOP_ACCESS_PARKINGMONEYFLG, ";
		$sql .= "SHOP_ACCESS_PARKINGMONEY, SHOP_ACCESS_PARKINGBOOKFLG, SHOP_ACCESS_ZIP, SHOP_ACCESS_TEL, ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "SHOP_ACCESS_PIC".$i.", SHOP_ACCESS_PIC_DISCRIPTION".$i.", ";
		}
		$sql .= "SHOP_ACCESS_ORDER, SHOP_ACCESS_STATUS ";

		$sql .= "from ".ShopAccess::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".ShopAccess::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".ShopAccess::tableKeyName, "=", $companyId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOP_ACCESS_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc, SHOP_ACCESS_ORDER ";
//	print_r($sql);

		parent::setCollection($sql, ShopAccess::keyName);
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

		$sql  = "insert into ".ShopAccess::tableName." (";
		$sql .= "SHOP_ACCESS_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "SHOP_ACCESS_NAME, ";
		$sql .= "SHOP_ACCESS_ADDRESS, ";

		$sql .= "SHOP_ACCESS_PUBLICFLG, ";

		$sql .= "SHOP_ACCESS_ROUTE, ";

		$sql .= "SHOP_ACCESS_PARKINGFLG, ";
		$sql .= "SHOP_ACCESS_PARKINGCAP, ";
		$sql .= "SHOP_ACCESS_PARKINGMONEYFLG, ";
		$sql .= "SHOP_ACCESS_PARKINGMONEY, ";
		$sql .= "SHOP_ACCESS_PARKINGBOOKFLG, ";

		$sql .= "SHOP_ACCESS_ZIP, ";
		$sql .= "SHOP_ACCESS_TEL, ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "SHOP_ACCESS_PIC".$i.", ";
			$sql .= "SHOP_ACCESS_PIC_DISCRIPTION".$i.", ";
		}
		$sql .= "SHOP_ACCESS_ORDER, ";
		$sql .= "SHOP_ACCESS_STATUS, ";
		$sql .= "SHOP_ACCESS_REGIST, ";
		$sql .= "SHOP_ACCESS_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";
		$sql .= "'".$dataList["SHOP_ACCESS_NAME"]."', ";
		$sql .= "'".$dataList["SHOP_ACCESS_ADDRESS"]."', ";

		$sql .= "'".$dataList["SHOP_ACCESS_PUBLICFLG"]."', ";

		$sql .= "'".$dataList["SHOP_ACCESS_ROUTE"]."', ";

		$sql .= "'".$dataList["SHOP_ACCESS_PARKINGFLG"]."', ";
		$sql .= "'".$dataList["SHOP_ACCESS_PARKINGCAP"]."', ";
		$sql .= "'".$dataList["SHOP_ACCESS_PARKINGMONEYFLG"]."', ";
		$sql .= "'".$dataList["SHOP_ACCESS_PARKINGMONEY"]."', ";
		$sql .= "'".$dataList["SHOP_ACCESS_PARKINGBOOKFLG"]."', ";

		$sql .= "'".$dataList["SHOP_ACCESS_ZIP"]."', ";
		$sql .= "'".$dataList["SHOP_ACCESS_TEL"]."', ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["SHOP_ACCESS_PIC".$i]."', ";
			$sql .= "'".$dataList["SHOP_ACCESS_PIC_DISCRIPTION".$i]."', ";
		}
		$sql .= (0).", ";
		$sql .= (1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
	//print_r($sql);

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".ShopAccess::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";
		$sql .= "SHOP_ACCESS_NAME = '".$dataList["SHOP_ACCESS_NAME"]."', ";
		$sql .= "SHOP_ACCESS_ADDRESS = '".$dataList["SHOP_ACCESS_ADDRESS"]."', ";

		$sql .= "SHOP_ACCESS_PUBLICFLG = '".$dataList["SHOP_ACCESS_PUBLICFLG"]."', ";

		$sql .= "SHOP_ACCESS_ROUTE = '".$dataList["SHOP_ACCESS_ROUTE"]."', ";

		$sql .= "SHOP_ACCESS_PARKINGFLG = '".$dataList["SHOP_ACCESS_PARKINGFLG"]."', ";
		$sql .= "SHOP_ACCESS_PARKINGCAP = '".$dataList["SHOP_ACCESS_PARKINGCAP"]."', ";
		$sql .= "SHOP_ACCESS_PARKINGMONEYFLG = '".$dataList["SHOP_ACCESS_PARKINGMONEYFLG"]."', ";
		$sql .= "SHOP_ACCESS_PARKINGMONEY = '".$dataList["SHOP_ACCESS_PARKINGMONEY"]."', ";
		$sql .= "SHOP_ACCESS_PARKINGBOOKFLG = '".$dataList["SHOP_ACCESS_PARKINGBOOKFLG"]."', ";

		$sql .= "SHOP_ACCESS_ZIP = '".$dataList["SHOP_ACCESS_ZIP"]."', ";
		$sql .= "SHOP_ACCESS_TEL = '".$dataList["SHOP_ACCESS_TEL"]."', ";

		for ($i=1; $i<=4; $i++) {
			$sql .= "SHOP_ACCESS_PIC".$i." = '".$dataList["SHOP_ACCESS_PIC".$i]."', ";
			$sql .= "SHOP_ACCESS_PIC_DISCRIPTION".$i." = '".$dataList["SHOP_ACCESS_PIC_DISCRIPTION".$i]."', ";
		}
		$sql .= "SHOP_ACCESS_STATUS = '".$dataList["SHOP_ACCESS_STATUS"]."', ";
		$sql .= "SHOP_ACCESS_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  ShopAccess::keyName." = ".parent::getKeyValue()." ";
	print_r($sql);
		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".ShopAccess::tableName." set ";
		$sql .= parent::expsData("SHOP_ACCESS_STATUS", "=", 2).", ";
		$sql .= parent::expsData("SHOP_ACCESS_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(ShopAccess::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".ShopAccess::tableName." set ";
			$sql .= parent::expsData("SHOP_ACCESS_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= ShopAccess::keyName." = ".$v." ";
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_NAME"))) {
			parent::setError("SHOP_ACCESS_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_NAME"), 100)) {
			parent::setError("SHOP_ACCESS_NAME", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_ADDRESS"))) {
			parent::setError("SHOP_ACCESS_ADDRESS", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_TEL"))) {
			parent::setError("SHOP_ACCESS_TEL", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_ROUTE"))) {
			parent::setError("SHOP_ACCESS_ROUTE", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_PUBLICFLG"))) {
			parent::setError("SHOP_ACCESS_PUBLICFLG", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_PARKINGFLG"))) {
			parent::setError("SHOP_ACCESS_PARKINGFLG", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_PARKINGMONEYFLG"))) {
			parent::setError("SHOP_ACCESS_PARKINGMONEYFLG", "必須項目です");
		}
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_PARKINGBOOKFLG"))) {
			parent::setError("SHOP_ACCESS_PARKINGBOOKFLG", "必須項目です");
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "SHOP_ACCESS_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "SHOP_ACCESS_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOP_ACCESS_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("SHOP_ACCESS_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("SHOP_ACCESS_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "SHOP_ACCESS_PIC".$i, $msg);
				}
			}
		}


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