<?php
class couponPlan extends collection {
	const tableName = "COUPONPLAN";
	const keyName = "COUPONPLAN_ID";
	const tableKeyName = "COMPANY_ID";

	public function couponPlan($db) {
		parent::collection($db);
	}

	public function getPlanContentById($id){
		$sql  = "select ";
		$sql .= parent::decryptionList("COUPONPLAN_DETAIL")." ";
		$sql .= "from ".couponPlan::tableName." ";
		
		$where = "";
		if($id){
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponPlan::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
// 		echo $sql;
		parent::setCollection($sql, couponPlan::keyName);
	}
	
	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "COUPONPLAN_ID, COMPANY_ID, COUPONPLAN_SALE_FROM, COUPONPLAN_SALE_TO, ";
//		$sql .= "HOTELPLAN_DATE_POST_FROM, HOTELPLAN_DATE_POST_TO, HOTELPLAN_FLG_DAYUSE, ";
		$sql .= parent::decryptionList("COUPONPLAN_NAME, COUPONPLAN_USE_MEMO").", ";
		$sql .= "COUPONPLAN_STATUS, COUPONPLAN_POSITION ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponPlan::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponPlan::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

// 		if ($collection->getByKey($collection->getKeyValue(), "hotelPlan_SHOPNAME") != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("hotelPlan_SHOPNAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "hotelPlan_SHOPNAME")."%", true, 4)." ";
// 		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "hotelPlan_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelPlan_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("hotelPlan_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, couponPlan::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "COUPONPLAN_ID, COMPANY_ID, COUPONPLAN_SALE_FROM, COUPONPLAN_SALE_TO, COUPONPLAN_TYPE, COUPONPLAN_FLG_SEACRET, COUPONPLAN_FLG_COCOTOMO, COUPONPLAN_HOTELPLAN_ID, ";
		$sql .= "COUPONPLAN_SELL_PRICE, COUPONPLAN_DEAL_PRICE, COUPONPLAN_DEAL_SP, COUPONPLAN_DELIVERY_FEE, COUPONPLAN_DEALNUM_MIN, COUPONPLAN_DEALNUM_MAX, COUPONPLAN_DEALPER_MIN, COUPONPLAN_DEALPER_MAX, COUPONPLAN_PROVIDE_MAX, COUPONPLAN_PROVIDE_SELL, ";
		$sql .= "COUPONPLAN_USE_FROM, COUPONPLAN_USE_TO, COUPONPLAN_POSITION, COUPONPLAN_DELIVERY_FLG, COUPONPLAN_PROVIDE_FLG, COUPONPLAN_DEALNUM_FLG, COUPONPLAN_DEALPER_FLG, COUPONPLAN_USE_SEPARATE, ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC, COUPONPLAN_CATCH, COUPONPLAN_DETAIL, COUPONPLAN_USE_MEMO").", ";
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::decryptionList("COUPONPLAN_PIC".$i).", ";
		}
		$sql .= parent::decryptionList("COUPONPLAN_CATEGORY_LIST, COUPONPLAN_AREA_LIST, COUPONPLAN_SHOP_LIST, COUPONPLAN_NAME").", ";
		$sql .= parent::decryptionList("COUPONPLAN_USE, COUPONPLAN_RESERVE").", ";
		$sql .= "COUPONPLAN_STATUS  ";

		$sql .= "from ".couponPlan::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponPlan::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".couponPlan::tableKeyName, "=", $companyId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPONPLAN_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COUPONPLAN_ORDER ";
		parent::setCollection($sql, couponPlan::keyName);
//print($sql);
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
 		print_r($dataList);
		$sql  = "insert into ".couponPlan::tableName." (";
		$sql .= "COUPONPLAN_ID, ";
		$sql .= "COMPANY_ID, ";

		$sql .= "COUPONPLAN_SALE_FROM, ";
		$sql .= "COUPONPLAN_SALE_TO, ";

		$sql .= "COUPONPLAN_SHOP_LIST, ";
		$sql .= "COUPONPLAN_TYPE, ";
		$sql .= "COUPONPLAN_FLG_SEACRET, ";
		$sql .= "COUPONPLAN_FLG_COCOTOMO, ";

		$sql .= "COUPONPLAN_PIC, ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "COUPONPLAN_PIC".$i.", ";
		}
		$sql .= "COUPONPLAN_NAME, ";
		$sql .= "COUPONPLAN_CATCH, ";
		$sql .= "COUPONPLAN_DETAIL, ";

		$sql .= "COUPONPLAN_SELL_PRICE, ";
		$sql .= "COUPONPLAN_DEAL_PRICE, ";
		$sql .= "COUPONPLAN_DEAL_SP, ";
		$sql .= "COUPONPLAN_DELIVERY_FLG, ";
		$sql .= "COUPONPLAN_DELIVERY_FEE, ";

		$sql .= "COUPONPLAN_PROVIDE_FLG, ";
		$sql .= "COUPONPLAN_PROVIDE_MAX, ";
//		$sql .= "COUPONPLAN_PROVIDE_SELL, ";

		$sql .= "COUPONPLAN_DEALNUM_FLG, ";
		$sql .= "COUPONPLAN_DEALNUM_MIN, ";
		$sql .= "COUPONPLAN_DEALNUM_MAX, ";

		$sql .= "COUPONPLAN_DEALPER_FLG, ";
		$sql .= "COUPONPLAN_DEALPER_MIN, ";
		$sql .= "COUPONPLAN_DEALPER_MAX, ";

		$sql .= "COUPONPLAN_USE, ";
		$sql .= "COUPONPLAN_USE_FROM, ";
		$sql .= "COUPONPLAN_USE_TO, ";
		$sql .= "COUPONPLAN_USE_MEMO, ";
		$sql .= "COUPONPLAN_USE_SEPARATE, ";

		$sql .= "COUPONPLAN_RESERVE, ";
		$sql .= "COUPONPLAN_HOTELPLAN_ID, ";

		$sql .= "COUPONPLAN_AREA_LIST, ";
		$sql .= "COUPONPLAN_CATEGORY_LIST, ";

		$sql .= "COUPONPLAN_POSITION, ";
		$sql .= "COUPONPLAN_ORDER, ";
		$sql .= "COUPONPLAN_STATUS, ";
		$sql .= "COUPONPLAN_DATE_REGIST, ";
		$sql .= "COUPONPLAN_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_SALE_FROM"], true).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_SALE_TO"], true).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_SHOP_LIST"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_TYPE"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_FLG_SEACRET"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_FLG_COCOTOMO"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_PIC"], true, 1).", ";
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::expsVal($dataList["COUPONPLAN_PIC".$i], true, 1).", ";
		}

		$sql .= parent::expsVal($dataList["COUPONPLAN_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_CATCH"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DETAIL"], true, 1).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_SELL_PRICE"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DEAL_PRICE"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DEAL_SP"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DELIVERY_FLG"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DELIVERY_FEE"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_PROVIDE_FLG"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_PROVIDE_MAX"]).", ";
//		$sql .= parent::expsVal($dataList["COUPONPLAN_PROVIDE_SELL"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_DEALNUM_FLG"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DEALNUM_MIN"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DEALNUM_MAX"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_DEALPER_FLG"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DEALPER_MIN"]).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_DEALPER_MAX"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_USE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_USE_FROM"], true).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_USE_TO"], true).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_USE_MEMO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_USE_SEPARATE"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_RESERVE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_HOTELPLAN_ID"]).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_AREA_LIST"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPONPLAN_CATEGORY_LIST"], true, 1).", ";

		$sql .= parent::expsVal($dataList["COUPONPLAN_POSITION"]).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".couponPlan::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";

		$sql .= parent::expsData("COUPONPLAN_SALE_FROM", "=", $dataList["COUPONPLAN_SALE_FROM"], true).", ";
		$sql .= parent::expsData("COUPONPLAN_SALE_TO", "=", $dataList["COUPONPLAN_SALE_TO"], true).", ";

		$sql .= parent::expsData("COUPONPLAN_SHOP_LIST", "=", $dataList["COUPONPLAN_SHOP_LIST"], true, 1).", ";
		$sql .= parent::expsData("COUPONPLAN_TYPE", "=", $dataList["COUPONPLAN_TYPE"]).", ";
		$sql .= parent::expsData("COUPONPLAN_FLG_SEACRET", "=", $dataList["COUPONPLAN_FLG_SEACRET"]).", ";
		$sql .= parent::expsData("COUPONPLAN_FLG_COCOTOMO", "=", $dataList["COUPONPLAN_FLG_COCOTOMO"]).", ";

		$sql .= parent::expsData("COUPONPLAN_PIC", "=", $dataList["COUPONPLAN_PIC"], true, 1).", ";
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::expsData("COUPONPLAN_PIC".$i, "=", $dataList["COUPONPLAN_PIC".$i], true, 1).", ";
		}

		$sql .= parent::expsData("COUPONPLAN_NAME", "=", $dataList["COUPONPLAN_NAME"], true, 1).", ";
		$sql .= parent::expsData("COUPONPLAN_CATCH", "=", $dataList["COUPONPLAN_CATCH"], true, 1).", ";
		$sql .= parent::expsData("COUPONPLAN_DETAIL", "=", $dataList["COUPONPLAN_DETAIL"], true, 1).", ";

		$sql .= parent::expsData("COUPONPLAN_SELL_PRICE", "=", $dataList["COUPONPLAN_SELL_PRICE"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DEAL_PRICE", "=", $dataList["COUPONPLAN_DEAL_PRICE"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DEAL_SP", "=", $dataList["COUPONPLAN_DEAL_SP"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DELIVERY_FLG", "=", $dataList["COUPONPLAN_DELIVERY_FLG"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DELIVERY_FEE", "=", $dataList["COUPONPLAN_DELIVERY_FEE"]).", ";

		$sql .= parent::expsData("COUPONPLAN_PROVIDE_FLG", "=", $dataList["COUPONPLAN_PROVIDE_FLG"]).", ";
		$sql .= parent::expsData("COUPONPLAN_PROVIDE_MAX", "=", $dataList["COUPONPLAN_PROVIDE_MAX"]).", ";
//		$sql .= parent::expsData("COUPONPLAN_PROVIDE_SELL", "=", $dataList["COUPONPLAN_PROVIDE_SELL"]).", ";

		$sql .= parent::expsData("COUPONPLAN_DEALNUM_FLG", "=", $dataList["COUPONPLAN_DEALNUM_FLG"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DEALNUM_MIN", "=", $dataList["COUPONPLAN_DEALNUM_MIN"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DEALNUM_MAX", "=", $dataList["COUPONPLAN_DEALNUM_MAX"]).", ";

		$sql .= parent::expsData("COUPONPLAN_DEALPER_FLG", "=", $dataList["COUPONPLAN_DEALPER_FLG"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DEALPER_MIN", "=", $dataList["COUPONPLAN_DEALPER_MIN"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DEALPER_MAX", "=", $dataList["COUPONPLAN_DEALPER_MAX"]).", ";

		$sql .= parent::expsData("COUPONPLAN_USE", "=", $dataList["COUPONPLAN_USE"], true, 1).", ";
		$sql .= parent::expsData("COUPONPLAN_USE_FROM", "=", $dataList["COUPONPLAN_USE_FROM"], true).", ";
		$sql .= parent::expsData("COUPONPLAN_USE_TO", "=", $dataList["COUPONPLAN_USE_TO"], true).", ";
		$sql .= parent::expsData("COUPONPLAN_USE_MEMO", "=", $dataList["COUPONPLAN_USE_MEMO"], true, 1).", ";
		$sql .= parent::expsData("COUPONPLAN_USE_SEPARATE", "=", $dataList["COUPONPLAN_USE_SEPARATE"]).", ";

		$sql .= parent::expsData("COUPONPLAN_RESERVE", "=", $dataList["COUPONPLAN_RESERVE"], true, 1).", ";
		$sql .= parent::expsData("COUPONPLAN_HOTELPLAN_ID", "=", $dataList["COUPONPLAN_HOTELPLAN_ID"]).", ";

		$sql .= parent::expsData("COUPONPLAN_AREA_LIST", "=", $dataList["COUPONPLAN_AREA_LIST"], true, 1).", ";
		$sql .= parent::expsData("COUPONPLAN_CATEGORY_LIST", "=", $dataList["COUPONPLAN_CATEGORY_LIST"], true, 1).", ";

		$sql .= parent::expsData("COUPONPLAN_POSITION", "=", $dataList["COUPONPLAN_POSITION"]).", ";
		$sql .= parent::expsData("COUPONPLAN_STATUS", "=", $dataList["COUPONPLAN_STATUS"]).", ";
		$sql .= parent::expsData("COUPONPLAN_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponPlan::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".couponPlan::tableName." set ";
		$sql .= parent::expsData("COUPONPLAN_STATUS", "=", 3).", ";
		$sql .= parent::expsData("COUPONPLAN_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusPublic() {
		$this->db->begin();
print_r(parent::getKeyValue());
		$sql .= "update ".couponPlan::tableName." set ";
		$sql .= parent::expsData("COUPONPLAN_STATUS", "=", 2).", ";
		$sql .= parent::expsData("COUPONPLAN_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusDisabled() {
		$this->db->begin();

		$sql .= "update ".couponPlan::tableName." set ";
		$sql .= parent::expsData("COUPONPLAN_STATUS", "=", 1).", ";
		$sql .= parent::expsData("COUPONPLAN_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(couponPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}
/*
	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".couponPlan::tableName." set ";
			$sql .= parent::expsData("HOTELPLAN_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= couponPlan::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$this->db->commit();
		return true;
	}
*/
	public function check() {
		if (!$_POST) return;
/*
		if (count($_POST["room"]) <= 0) {
			parent::setError("room", "必須項目です");
		}
*/
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_SALE_FROM"))) {
			parent::setError("COUPONPLAN_SALE_FROM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_SALE_FROM"), CHK_PTN_DATE)) {
			parent::setError("COUPONPLAN_SALE_FROM", "日付の形式を確認して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_SALE_TO"))) {
			parent::setError("COUPONPLAN_SALE_TO", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_SALE_TO"), CHK_PTN_DATE)) {
			parent::setError("COUPONPLAN_SALE_TO", "日付の形式を確認して下さい");
		}

		if (parent::getByKey(parent::getKeyValue(), "COUPONPLAN_PIC_setup") != "") {
			$this->setByKey($this->getKeyValue(), "COUPONPLAN_PIC", $this->getByKey($this->getKeyValue(), "COUPONPLAN_PIC_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("COUPONPLAN_PIC", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("COUPONPLAN_PIC", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "COUPONPLAN_PIC", $msg);
			}
		}

		for ($i=2; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "COUPONPLAN_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_PIC".$i, $this->getByKey($this->getKeyValue(), "COUPONPLAN_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("COUPONPLAN_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("COUPONPLAN_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "COUPONPLAN_PIC".$i, $msg);
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_NAME"))) {
			parent::setError("COUPONPLAN_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_NAME"), 100)) {
			parent::setError("COUPONPLAN_NAME", "100文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPONPLAN_DETAIL"))) {
			parent::setError("COUPONPLAN_DETAIL", "必須項目です");
		}


// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"))) {
// 			parent::setError("HOTELPLAN_ACC_DAY", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_ACC_DAY", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"), 1)) {
// 			parent::setError("HOTELPLAN_ACC_DAY", "半角数字1文字で入力して下さい");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_HOUR"))) {
// 			parent::setError("HOTELPLAN_ACC_HOUR", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_HOUR"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_ACC_HOUR", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_HOUR"), 2)) {
// 			parent::setError("HOTELPLAN_ACC_HOUR", "半角数字2文字で入力して下さい");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_MIN"))) {
// 			parent::setError("HOTELPLAN_ACC_MIN", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_MIN"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_ACC_MIN", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_MIN"), 2)) {
// 			parent::setError("HOTELPLAN_ACC_MIN", "半角数字2文字で入力して下さい");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_FLG"))) {
// 			parent::setError("HOTELPLAN_CAN_FLG", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_FLG"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_FLG", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_FLG"), 1)) {
// 			parent::setError("HOTELPLAN_CAN_FLG", "半角数字1文字で入力して下さい");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"))) {
// 			parent::setError("HOTELPLAN_CAN_DAY", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_DAY", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"), 1)) {
// 			parent::setError("HOTELPLAN_CAN_DAY", "半角数字1文字で入力して下さい");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_HOUR"))) {
// 			parent::setError("HOTELPLAN_CAN_HOUR", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_HOUR"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_HOUR", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_HOUR"), 2)) {
// 			parent::setError("HOTELPLAN_CAN_HOUR", "半角数字2文字で入力して下さい");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_MIN"))) {
// 			parent::setError("HOTELPLAN_CAN_MIN", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_MIN"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_MIN", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_MIN"), 2)) {
// 			parent::setError("HOTELPLAN_CAN_MIN", "半角数字2文字で入力して下さい");
// 		}

// 		for ($i=1; $i<=2; $i++) {
// 			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_HOUR".$i))) {
// 				parent::setError("HOTELPLAN_CHECKIN_HOUR".$i, "必須項目です");
// 			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_HOUR".$i), CHK_PTN_NUM)) {
// 				parent::setError("HOTELPLAN_CHECKIN_HOUR".$i, "半角数字で入力して下さい");
// 			}
// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_HOUR".$i), 2)) {
// 				parent::setError("HOTELPLAN_CHECKIN_HOUR".$i, "半角数字2文字で入力して下さい");
// 			}

// 			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_MIN".$i))) {
// 				parent::setError("HOTELPLAN_CHECKIN_MIN".$i, "必須項目です");
// 			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_MIN".$i), CHK_PTN_NUM)) {
// 				parent::setError("HOTELPLAN_CHECKIN_MIN".$i, "半角数字で入力して下さい");
// 			}
// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_MIN".$i), 2)) {
// 				parent::setError("HOTELPLAN_CHECKIN_MIN".$i, "半角数字2文字で入力して下さい");
// 			}
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_HOUR"))) {
// 			parent::setError("HOTELPLAN_CHECKOUT_HOUR", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_HOUR"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_HOUR", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_HOUR"), 2)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_HOUR", "半角数字2文字で入力して下さい");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_MIN"))) {
// 			parent::setError("HOTELPLAN_CHECKOUT_MIN", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_MIN"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_MIN", "半角数字で入力して下さい");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_MIN"), 2)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_MIN", "半角数字2文字で入力して下さい");
// 		}

//		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"))) {
//			parent::setError("HOTELPLAN_ACC_DAY", "必須項目です");
//		}
		
		
//		if (!cmCheckSpan(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"),"BOOKSET_BOOKING_DAY")) {
//			parent::setError("HOTELPLAN_ACC_DAY", "ホテル全体の予約設定日に超えています");
//		}
// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC"))) {
// 			parent::setError("HOTELPLAN_ACC", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC"), CHK_PTN_TIME)) {
// 			parent::setError("HOTELPLAN_ACC", "00:00の形式で入力して下さい");
// 		}

//		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"))) {
//			parent::setError("HOTELPLAN_CAN_DAY", "必須項目です");
//		}
		
//		if (!cmCheckSpan(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"),"BOOKSET_CANCEL_DAY")) {
//			parent::setError("HOTELPLAN_CAN_DAY", "ホテル全体の予約設定日に超えています");
//		}
		
// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN"))) {
// 			parent::setError("HOTELPLAN_CAN", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN"), CHK_PTN_TIME)) {
// 			parent::setError("HOTELPLAN_CAN", "00:00の形式で入力して下さい");
// 		}

		/*jquery ??插件改?下拉
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN"))) {
			parent::setError("HOTELPLAN_CHECKIN", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN"), CHK_PTN_TIME)) {
			parent::setError("HOTELPLAN_CHECKIN", "00:00の形式で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_LAST"))) {
			parent::setError("HOTELPLAN_CHECKIN_LAST", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_LAST"), CHK_PTN_TIME)) {
			parent::setError("HOTELPLAN_CHECKIN_LAST", "00:00の形式で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT"))) {
			parent::setError("HOTELPLAN_CHECKOUT", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT"), CHK_PTN_TIME)) {
			parent::setError("HOTELPLAN_CHECKOUT", "00:00の形式で入力して下さい");
		}
*/
/*
		for ($i=1; $i<=2; $i++) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_FLG".$i))) {
				parent::setError("HOTELPLAN_NIGHTS_FLG".$i, "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_FLG".$i), CHK_PTN_NUM)) {
				parent::setError("HOTELPLAN_NIGHTS_FLG".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_FLG".$i), 1)) {
				parent::setError("HOTELPLAN_NIGHTS_FLG".$i, "半角数字1文字で入力して下さい");
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_NUM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_NUM".$i), CHK_PTN_NUM)) {
					parent::setError("HOTELPLAN_NIGHTS_NUM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_NUM".$i), 3)) {
					parent::setError("HOTELPLAN_NIGHTS_NUM".$i, "半角数字3文字で入力して下さい");
				}
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_BF_FLG"))) {
			parent::setError("HOTELPLAN_BF_FLG", "必須項目です");
		}
*/
// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DN_FLG"))) {
// 			parent::setError("HOTELPLAN_DN_FLG", "必須項目です");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_STATUS"))) {
// 			parent::setError("HOTELPLAN_STATUS", "必須項目です");
// 		}


//		if (parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_FLG") == 1) {

//			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_URL"))) {
//				parent::setError("HOTELPLAN_RECOMM_URL", "必須項目です");
//			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_URL"), CHK_PTN_URL)) {
// 				parent::setError("HOTELPLAN_RECOMM_URL", "URLの形式を確認して下さい");
// 			}

//			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_TITLE"))) {
//				parent::setError("HOTELPLAN_RECOMM_TITLE", "必須項目です");
//			}
			// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_TITLE"), 30)) {
			// 				parent::setError("HOTELPLAN_RECOMM_TITLE", "30文字以内で入力して下さい");
			// 			}

//			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_COMMENT"))) {
//				parent::setError("HOTELPLAN_RECOMM_COMMENT", "必須項目です");
//			}
/*
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("HOTELPLAN_RECOMM_PIC", IMG_RECOMMEND_SIZE, IMG_RECOMMEND_WIDTH, IMG_RECOMMEND_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("HOTELPLAN_RECOMM_PIC", $msg);
				}
				else {
					// 					parent::setError("HOTELPLAN_RECOMM_PIC", "必須項目です");
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_PIC", $msg);
			}

		}
*/
	}


	public function setPost() {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			$dataShop = "";
			if (count($_POST["room"]) > 0) {
				foreach ($_POST["room"] as $d) {
					if ($dataShop != "") {
						$dataShop .= ":";
					}
					$dataShop .= $d;
				}
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_SHOP_LIST", ":".$dataShop.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_SHOP_LIST", $this->getByKey($this->getKeyValue(), "COUPONPLAN_SHOP_LIST"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_AREA_LIST", ":".$dataArea.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_AREA_LIST", '');
			}			

			$dataCategory = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataCategory != "") {
						$dataCategory .= ":";
					}
					$dataCategory .= $d;
				}
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_CATEGORY_LIST", ":".$dataCategory.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_CATEGORY_LIST", '');
			}			
			


		}

	}

}
?>