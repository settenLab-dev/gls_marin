<?php
class jobPlan extends collection {
	const tableName = "JOBPLAN";
	const keyName = "JOBPLAN_ID";
	const tableKeyName = "COMPANY_ID";

	public function jobPlan($db) {
		parent::collection($db);
	}

	public function getPlanContentById($id){
		$sql  = "select ";
		$sql .= parent::decryptionList("JOB_CONTENTS")." ";
		$sql .= "from ".jobPlan::tableName." ";
		
		$where = "";
		if($id){
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobPlan::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
// 		echo $sql;
		parent::setCollection($sql, jobPlan::keyName);
	}
	
	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "JOBPLAN_ID, COMPANY_ID,  JOB_SHOW_FROM, JOB_SHOW_TO, ";
//		$sql .= "HOTELPLAN_DATE_POST_FROM, HOTELPLAN_DATE_POST_TO, HOTELPLAN_FLG_DAYUSE, ";
		$sql .= parent::decryptionList("JOB_NAME").", ";
		$sql .= "JOB_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobPlan::keyName, "=", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobPlan::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
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

		parent::setCollection($sql, jobPlan::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "JOBPLAN_ID, COMPANY_ID, JOB_SHOW_FROM, JOB_SHOW_TO, JOB_FLG_SEACRET, JOB_FLG_COCOTOMO, JOB_FLG_TYPE, ";
		$sql .= parent::decryptionList("JOB_CONTENTS, JOB_PIC, JOB_CATCH, JOB_FEATURE").", ";
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::decryptionList("JOB_PIC".$i).", ";
		}
		$sql .= parent::decryptionList("JOBPLAN_SHOP_LIST, JOB_NAME, JOB_CONTENTS, JOB_SEASON_LIST, JOB_KINDTYPE_LIST, JOB_EMPLOYTYPE_LIST, JOB_COMPANYTYPE_LIST, JOB_AREA_LIST, JOB_ICON_LIST").", ";
		$sql .= parent::decryptionList("JOB_CONDITION, JOB_ACCESS, JOB_MONEY, JOB_WORKTIME, JOB_HOLYDAY, JOB_TREAT, JOB_MEMO, JOB_CONTACT").", ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "JOB_SEASON".$i.", ";
		}
		for ($i=1; $i<=15; $i++) {
			$sql .= "JOB_KINDTYPE".$i.", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "JOB_EMPLOYTYPE".$i.", ";
		}
		for ($i=1; $i<=15; $i++) {
			$sql .= "JOB_COMPANYTYPE".$i.", ";
		}
		for ($i=1; $i<=38; $i++) {
			$sql .= "JOB_AREA".$i.", ";
		}
		for ($i=1; $i<=35; $i++) {
			$sql .= "JOB_ICON".$i.", ";
		}
//		$sql .= "HOTELPLAN_ACC_HOUR, HOTELPLAN_ACC_MIN, HOTELPLAN_CAN_HOUR, HOTELPLAN_CAN_MIN, ";
// 		$sql .= "HOTELPLAN_ACC_DAY, HOTELPLAN_ACC_HOUR, HOTELPLAN_ACC_MIN, HOTELPLAN_CAN_FLG, HOTELPLAN_CAN_DAY, HOTELPLAN_CAN_HOUR, HOTELPLAN_CAN_MIN,";
// 		for ($i=1; $i<=2; $i++) {
// 			$sql .= "HOTELPLAN_CHECKIN_HOUR".$i.", ";
// 			$sql .= "HOTELPLAN_CHECKIN_MIN".$i.", ";
// 		}
// 		$sql .= "HOTELPLAN_CHECKOUT_HOUR, HOTELPLAN_CHECKOUT_MIN, ";
/*		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_NIGHTS_FLG".$i.", ";
			$sql .= "HOTELPLAN_NIGHTS_NUM".$i.", ";
			$sql .= "HOTELPLAN_BF_CHECK".$i.", ";
			$sql .= "HOTELPLAN_DN_CHECK".$i.", ";
			$sql .= "HOTELPLAN_LN_CHECK".$i.", ";
		}
		$sql .= "HOTELPLAN_BF_FLG, HOTELPLAN_DN_FLG, HOTELPLAN_LN_FLG, HOTELPLAN_FLG_CANCEL, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPLAN_CANCEL_FLG".$i.", ";
			$sql .= "HOTELPLAN_CANCEL_MONEY".$i.", ";
			if ($i >= 3) {
				$sql .= "HOTELPLAN_CANCEL_FROM".$i.", ";
				$sql .= "HOTELPLAN_CANCEL_TO".$i.", ";
			}
		}
*/
//		$sql .= parent::decryptionList("HOTELPLAN_QUESTION, HOTELPLAN_FOOD1, HOTELPLAN_FOOD2, HOTELPLAN_FOOD3, HOTELPLAN_DISCOUNT").", ";
//		$sql .= "HOTELPLAN_QUESTION_REC, HOTELPLAN_DEMAND, HOTELPLAN_ORDER, HOTELPLAN_STATUS,  ";
		$sql .= "JOB_STATUS  ";
//		$sql .= "HOTELPLAN_RECOMM_FLG, HOTELPLAN_RECOMM_URL, ";
//		$sql .= parent::decryptionList("HOTELPLAN_RECOMM_TITLE, HOTELPLAN_RECOMM_COMMENT, HOTELPLAN_RECOMM_PIC")." ";

		$sql .= "from ".jobPlan::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobPlan::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobPlan::tableKeyName, "=", $companyId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("JOB_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by JOB_ORDER ";
		parent::setCollection($sql, jobPlan::keyName);
//print $sql;
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
		$sql  = "insert into ".jobPlan::tableName." (";
		$sql .= "JOBPLAN_ID, ";
		$sql .= "COMPANY_ID, ";

		$sql .= "JOB_SHOW_FROM, ";
		$sql .= "JOB_SHOW_TO, ";

		$sql .= "JOBPLAN_SHOP_LIST, ";
		$sql .= "JOB_FLG_TYPE, ";
		$sql .= "JOB_FLG_SEACRET, ";
		$sql .= "JOB_FLG_COCOTOMO, ";

		$sql .= "JOB_PIC, ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "JOB_PIC".$i.", ";
		}
		$sql .= "JOB_NAME, ";
		$sql .= "JOB_CATCH, ";
		$sql .= "JOB_FEATURE, ";
		$sql .= "JOB_CONTENTS, ";

		$sql .= "JOB_SEASON_LIST, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "JOB_SEASON".$i.", ";
		}
		$sql .= "JOB_KINDTYPE_LIST, ";
		for ($i=1; $i<=15; $i++) {
			$sql .= "JOB_KINDTYPE".$i.", ";
		}
		$sql .= "JOB_EMPLOYTYPE_LIST, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "JOB_EMPLOYTYPE".$i.", ";
		}
		$sql .= "JOB_COMPANYTYPE_LIST, ";
		for ($i=1; $i<=15; $i++) {
			$sql .= "JOB_COMPANYTYPE".$i.", ";
		}
		$sql .= "JOB_AREA_LIST, ";
		for ($i=1; $i<=38; $i++) {
			$sql .= "JOB_AREA".$i.", ";
		}
		$sql .= "JOB_ICON_LIST, ";
		for ($i=1; $i<=35; $i++) {
			$sql .= "JOB_ICON".$i.", ";
		}

		$sql .= "JOB_CONDITION, ";
		$sql .= "JOB_ACCESS, ";
		$sql .= "JOB_MONEY, ";
		$sql .= "JOB_WORKTIME, ";
		$sql .= "JOB_HOLYDAY, ";
		$sql .= "JOB_TREAT, ";
		$sql .= "JOB_MEMO, ";
		$sql .= "JOB_CONTACT, ";
		$sql .= "JOB_ORDER, ";
		$sql .= "JOB_STATUS, ";
		$sql .= "JOB_DATE_REGIST, ";
		$sql .= "JOB_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";

		$sql .= parent::expsVal($dataList["JOB_SHOW_FROM"], true).", ";
		$sql .= parent::expsVal($dataList["JOB_SHOW_TO"], true).", ";

		$sql .= parent::expsVal($dataList["JOBPLAN_SHOP_LIST"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_FLG_TYPE"]).", ";
		$sql .= parent::expsVal($dataList["JOB_FLG_SEACRET"]).", ";
		$sql .= parent::expsVal($dataList["JOB_FLG_COCOTOMO"]).", ";

		$sql .= parent::expsVal($dataList["JOB_PIC"], true, 1).", ";
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::expsVal($dataList["JOB_PIC".$i], true, 1).", ";
		}

		$sql .= parent::expsVal($dataList["JOB_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_CATCH"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_FEATURE"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_CONTENTS"], true, 1).", ";

		$sql .= parent::expsVal($dataList["JOB_SEASON_LIST"], true, 1).", ";
		for ($i=1; $i<=5; $i++) {
			$sql .= parent::expsVal($dataList["JOB_SEASON".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["JOB_KINDTYPE_LIST"], true, 1).", ";
		for ($i=1; $i<=15; $i++) {
			$sql .= parent::expsVal($dataList["JOB_KINDTYPE".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["JOB_EMPLOYTYPE_LIST"], true, 1).", ";
		for ($i=1; $i<=4; $i++) {
			$sql .= parent::expsVal($dataList["JOB_EMPLOYTYPE".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["JOB_COMPANYTYPE_LIST"], true, 1).", ";
		for ($i=1; $i<=15; $i++) {
			$sql .= parent::expsVal($dataList["JOB_COMPANYTYPE".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["JOB_AREA_LIST"], true, 1).", ";
		for ($i=1; $i<=38; $i++) {
			$sql .= parent::expsVal($dataList["JOB_AREA".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["JOB_ICON_LIST"], true, 1).", ";
		for ($i=1; $i<=35; $i++) {
			$sql .= parent::expsVal($dataList["JOB_ICON".$i]).", ";
		}

		$sql .= parent::expsVal($dataList["JOB_CONDITION"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_ACCESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_MONEY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_WORKTIME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_HOLYDAY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_TREAT"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_MEMO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_CONTACT"], true, 1).", ";
		$sql .= parent::expsVal(0).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".jobPlan::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";

		$sql .= parent::expsData("JOB_SHOW_FROM", "=", $dataList["JOB_SHOW_FROM"], true).", ";
		$sql .= parent::expsData("JOB_SHOW_TO", "=", $dataList["JOB_SHOW_TO"], true).", ";

		$sql .= parent::expsData("JOBPLAN_SHOP_LIST", "=", $dataList["JOBPLAN_SHOP_LIST"], true, 1).", ";
		$sql .= parent::expsData("JOB_FLG_TYPE", "=", $dataList["JOB_FLG_TYPE"]).", ";
		$sql .= parent::expsData("JOB_FLG_SEACRET", "=", $dataList["JOB_FLG_SEACRET"]).", ";
		$sql .= parent::expsData("JOB_FLG_COCOTOMO", "=", $dataList["JOB_FLG_COCOTOMO"]).", ";

		$sql .= parent::expsData("JOB_PIC", "=", $dataList["JOB_PIC"], true, 1).", ";
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::expsData("JOB_PIC".$i, "=", $dataList["JOB_PIC".$i], true, 1).", ";
		}

		$sql .= parent::expsData("JOB_NAME", "=", $dataList["JOB_NAME"], true, 1).", ";
		$sql .= parent::expsData("JOB_CATCH", "=", $dataList["JOB_CATCH"], true, 1).", ";
		$sql .= parent::expsData("JOB_FEATURE", "=", $dataList["JOB_FEATURE"], true, 1).", ";
		$sql .= parent::expsData("JOB_CONTENTS", "=", $dataList["JOB_CONTENTS"], true, 1).", ";

		$sql .= parent::expsData("JOB_SEASON_LIST", "=", $dataList["JOB_SEASON_LIST"], true, 1).", ";
		for ($i=1; $i<=5; $i++) {
			$sql .= parent::expsData("JOB_SEASON".$i, "=", $dataList["JOB_SEASON".$i]).", ";
		}
		$sql .= parent::expsData("JOB_KINDTYPE_LIST", "=", $dataList["JOB_KINDTYPE_LIST"], true, 1).", ";
		for ($i=1; $i<=15; $i++) {
			$sql .= parent::expsData("JOB_KINDTYPE".$i, "=", $dataList["JOB_KINDTYPE".$i]).", ";
		}
		$sql .= parent::expsData("JOB_EMPLOYTYPE_LIST", "=", $dataList["JOB_EMPLOYTYPE_LIST"], true, 1).", ";
		for ($i=1; $i<=4; $i++) {
			$sql .= parent::expsData("JOB_EMPLOYTYPE".$i, "=", $dataList["JOB_EMPLOYTYPE".$i]).", ";
		}
		$sql .= parent::expsData("JOB_COMPANYTYPE_LIST", "=", $dataList["JOB_COMPANYTYPE_LIST"], true, 1).", ";
		for ($i=1; $i<=15; $i++) {
			$sql .= parent::expsData("JOB_COMPANYTYPE".$i, "=", $dataList["JOB_COMPANYTYPE".$i]).", ";
		}
		$sql .= parent::expsData("JOB_AREA_LIST", "=", $dataList["JOB_AREA_LIST"], true, 1).", ";
		for ($i=1; $i<=38; $i++) {
			$sql .= parent::expsData("JOB_AREA".$i, "=", $dataList["JOB_AREA".$i]).", ";
		}
		$sql .= parent::expsData("JOB_ICON_LIST", "=", $dataList["JOB_ICON_LIST"], true, 1).", ";
		for ($i=1; $i<=35; $i++) {
			$sql .= parent::expsData("JOB_ICON".$i, "=", $dataList["JOB_ICON".$i]).", ";
		}
		$sql .= parent::expsData("JOB_CONDITION", "=", $dataList["JOB_CONDITION"], true, 1).", ";
		$sql .= parent::expsData("JOB_ACCESS", "=", $dataList["JOB_ACCESS"], true, 1).", ";
		$sql .= parent::expsData("JOB_MONEY", "=", $dataList["JOB_MONEY"], true, 1).", ";
		$sql .= parent::expsData("JOB_WORKTIME", "=", $dataList["JOB_WORKTIME"], true, 1).", ";
		$sql .= parent::expsData("JOB_HOLYDAY", "=", $dataList["JOB_HOLYDAY"], true, 1).", ";
		$sql .= parent::expsData("JOB_TREAT", "=", $dataList["JOB_TREAT"], true, 1).", ";
		$sql .= parent::expsData("JOB_MEMO", "=", $dataList["JOB_MEMO"], true, 1).", ";
		$sql .= parent::expsData("JOB_CONTACT", "=", $dataList["JOB_CONTACT"], true, 1).", ";
		$sql .= parent::expsData("JOB_STATUS", "=", $dataList["JOB_STATUS"]).", ";
		$sql .= parent::expsData("JOB_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobPlan::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".jobPlan::tableName." set ";
		$sql .= parent::expsData("JOB_STATUS", "=", 3).", ";
		$sql .= parent::expsData("JOB_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusPublic() {
		$this->db->begin();

		$sql .= "update ".jobPlan::tableName." set ";
		$sql .= parent::expsData("JOB_STATUS", "=", 2).", ";
		$sql .= parent::expsData("JOB_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusDisabled() {
		$this->db->begin();

		$sql .= "update ".jobPlan::tableName." set ";
		$sql .= parent::expsData("JOB_STATUS", "=", 1).", ";
		$sql .= parent::expsData("JOB_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobPlan::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".jobPlan::tableName." set ";
			$sql .= parent::expsData("HOTELPLAN_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= jobPlan::keyName." = ".$v." ";
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
			parent::setError("room", "??????????????????");
		}
*/
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_SHOW_FROM"))) {
			parent::setError("JOB_SHOW_FROM", "??????????????????");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_SHOW_FROM"), CHK_PTN_DATE)) {
			parent::setError("JOB_SHOW_FROM", "???????????????????????????????????????");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_SHOW_TO"))) {
			parent::setError("JOB_SHOW_TO", "??????????????????");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_SHOW_TO"), CHK_PTN_DATE)) {
			parent::setError("JOB_SHOW_TO", "???????????????????????????????????????");
		}

		if (parent::getByKey(parent::getKeyValue(), "JOB_PIC_setup") != "") {
			$this->setByKey($this->getKeyValue(), "JOB_PIC", $this->getByKey($this->getKeyValue(), "JOB_PIC_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("JOB_PIC", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("JOB_PIC", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "JOB_PIC", $msg);
			}
		}

		for ($i=2; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "JOB_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "JOB_PIC".$i, $this->getByKey($this->getKeyValue(), "JOB_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("JOB_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("JOB_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "JOB_PIC".$i, $msg);
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_NAME"))) {
			parent::setError("JOB_NAME", "??????????????????");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_NAME"), 100)) {
			parent::setError("JOB_NAME", "100????????????????????????????????????");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_FEATURE"))) {
			parent::setError("JOB_FEATURE", "??????????????????");
		}


// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"))) {
// 			parent::setError("HOTELPLAN_ACC_DAY", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_ACC_DAY", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"), 1)) {
// 			parent::setError("HOTELPLAN_ACC_DAY", "????????????1??????????????????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_HOUR"))) {
// 			parent::setError("HOTELPLAN_ACC_HOUR", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_HOUR"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_ACC_HOUR", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_HOUR"), 2)) {
// 			parent::setError("HOTELPLAN_ACC_HOUR", "????????????2??????????????????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_MIN"))) {
// 			parent::setError("HOTELPLAN_ACC_MIN", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_MIN"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_ACC_MIN", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_MIN"), 2)) {
// 			parent::setError("HOTELPLAN_ACC_MIN", "????????????2??????????????????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_FLG"))) {
// 			parent::setError("HOTELPLAN_CAN_FLG", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_FLG"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_FLG", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_FLG"), 1)) {
// 			parent::setError("HOTELPLAN_CAN_FLG", "????????????1??????????????????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"))) {
// 			parent::setError("HOTELPLAN_CAN_DAY", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_DAY", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"), 1)) {
// 			parent::setError("HOTELPLAN_CAN_DAY", "????????????1??????????????????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_HOUR"))) {
// 			parent::setError("HOTELPLAN_CAN_HOUR", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_HOUR"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_HOUR", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_HOUR"), 2)) {
// 			parent::setError("HOTELPLAN_CAN_HOUR", "????????????2??????????????????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_MIN"))) {
// 			parent::setError("HOTELPLAN_CAN_MIN", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_MIN"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CAN_MIN", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_MIN"), 2)) {
// 			parent::setError("HOTELPLAN_CAN_MIN", "????????????2??????????????????????????????");
// 		}

// 		for ($i=1; $i<=2; $i++) {
// 			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_HOUR".$i))) {
// 				parent::setError("HOTELPLAN_CHECKIN_HOUR".$i, "??????????????????");
// 			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_HOUR".$i), CHK_PTN_NUM)) {
// 				parent::setError("HOTELPLAN_CHECKIN_HOUR".$i, "????????????????????????????????????");
// 			}
// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_HOUR".$i), 2)) {
// 				parent::setError("HOTELPLAN_CHECKIN_HOUR".$i, "????????????2??????????????????????????????");
// 			}

// 			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_MIN".$i))) {
// 				parent::setError("HOTELPLAN_CHECKIN_MIN".$i, "??????????????????");
// 			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_MIN".$i), CHK_PTN_NUM)) {
// 				parent::setError("HOTELPLAN_CHECKIN_MIN".$i, "????????????????????????????????????");
// 			}
// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_MIN".$i), 2)) {
// 				parent::setError("HOTELPLAN_CHECKIN_MIN".$i, "????????????2??????????????????????????????");
// 			}
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_HOUR"))) {
// 			parent::setError("HOTELPLAN_CHECKOUT_HOUR", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_HOUR"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_HOUR", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_HOUR"), 2)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_HOUR", "????????????2??????????????????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_MIN"))) {
// 			parent::setError("HOTELPLAN_CHECKOUT_MIN", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_MIN"), CHK_PTN_NUM)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_MIN", "????????????????????????????????????");
// 		}
// 		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT_MIN"), 2)) {
// 			parent::setError("HOTELPLAN_CHECKOUT_MIN", "????????????2??????????????????????????????");
// 		}

//		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"))) {
//			parent::setError("HOTELPLAN_ACC_DAY", "??????????????????");
//		}
		
		
//		if (!cmCheckSpan(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"),"BOOKSET_BOOKING_DAY")) {
//			parent::setError("HOTELPLAN_ACC_DAY", "??????????????????????????????????????????????????????");
//		}
// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC"))) {
// 			parent::setError("HOTELPLAN_ACC", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC"), CHK_PTN_TIME)) {
// 			parent::setError("HOTELPLAN_ACC", "00:00?????????????????????????????????");
// 		}

//		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"))) {
//			parent::setError("HOTELPLAN_CAN_DAY", "??????????????????");
//		}
		
//		if (!cmCheckSpan(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"),"BOOKSET_CANCEL_DAY")) {
//			parent::setError("HOTELPLAN_CAN_DAY", "??????????????????????????????????????????????????????");
//		}
		
// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN"))) {
// 			parent::setError("HOTELPLAN_CAN", "??????????????????");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN"), CHK_PTN_TIME)) {
// 			parent::setError("HOTELPLAN_CAN", "00:00?????????????????????????????????");
// 		}

		/*jquery ??????????????????
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN"))) {
			parent::setError("HOTELPLAN_CHECKIN", "??????????????????");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN"), CHK_PTN_TIME)) {
			parent::setError("HOTELPLAN_CHECKIN", "00:00?????????????????????????????????");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_LAST"))) {
			parent::setError("HOTELPLAN_CHECKIN_LAST", "??????????????????");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKIN_LAST"), CHK_PTN_TIME)) {
			parent::setError("HOTELPLAN_CHECKIN_LAST", "00:00?????????????????????????????????");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT"))) {
			parent::setError("HOTELPLAN_CHECKOUT", "??????????????????");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CHECKOUT"), CHK_PTN_TIME)) {
			parent::setError("HOTELPLAN_CHECKOUT", "00:00?????????????????????????????????");
		}
*/
/*
		for ($i=1; $i<=2; $i++) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_FLG".$i))) {
				parent::setError("HOTELPLAN_NIGHTS_FLG".$i, "??????????????????");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_FLG".$i), CHK_PTN_NUM)) {
				parent::setError("HOTELPLAN_NIGHTS_FLG".$i, "????????????????????????????????????");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_FLG".$i), 1)) {
				parent::setError("HOTELPLAN_NIGHTS_FLG".$i, "????????????1??????????????????????????????");
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_NUM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_NUM".$i), CHK_PTN_NUM)) {
					parent::setError("HOTELPLAN_NIGHTS_NUM".$i, "????????????????????????????????????");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NIGHTS_NUM".$i), 3)) {
					parent::setError("HOTELPLAN_NIGHTS_NUM".$i, "????????????3??????????????????????????????");
				}
			}
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_BF_FLG"))) {
			parent::setError("HOTELPLAN_BF_FLG", "??????????????????");
		}
*/
// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DN_FLG"))) {
// 			parent::setError("HOTELPLAN_DN_FLG", "??????????????????");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_STATUS"))) {
// 			parent::setError("HOTELPLAN_STATUS", "??????????????????");
// 		}


//		if (parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_FLG") == 1) {

//			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_URL"))) {
//				parent::setError("HOTELPLAN_RECOMM_URL", "??????????????????");
//			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_URL"), CHK_PTN_URL)) {
// 				parent::setError("HOTELPLAN_RECOMM_URL", "URL?????????????????????????????????");
// 			}

//			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_TITLE"))) {
//				parent::setError("HOTELPLAN_RECOMM_TITLE", "??????????????????");
//			}
			// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_TITLE"), 30)) {
			// 				parent::setError("HOTELPLAN_RECOMM_TITLE", "30????????????????????????????????????");
			// 			}

//			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_COMMENT"))) {
//				parent::setError("HOTELPLAN_RECOMM_COMMENT", "??????????????????");
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
					// 					parent::setError("HOTELPLAN_RECOMM_PIC", "??????????????????");
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
				$this->setByKey($this->getKeyValue(), "JOBPLAN_SHOP_LIST", ":".$dataShop.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "JOBPLAN_SHOP_LIST", $this->getByKey($this->getKeyValue(), "JOBPLAN_SHOP_LIST"));
			}

			$dataSeason = "";
			if (count($_POST["season"]) > 0) {
				foreach ($_POST["season"] as $d) {
					if ($dataSeason != "") {
						$dataSeason .= ":";
					}
					$dataSeason .= $d;
				}
				$this->setByKey($this->getKeyValue(), "JOB_SEASON_LIST", ":".$dataSeason.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "JOB_SEASON_LIST", '');
			}

			$dataEmploy = "";
			if (count($_POST["employ"]) > 0) {
				foreach ($_POST["employ"] as $d) {
					if ($dataEmploy != "") {
						$dataEmploy .= ":";
					}
					$dataEmploy .= $d;
				}
				$this->setByKey($this->getKeyValue(), "JOB_EMPLOYTYPE_LIST", ":".$dataEmploy.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "JOB_EMPLOYTYPE_LIST", '');
			}

			$dataKind = "";
			if (count($_POST["kind"]) > 0) {
				foreach ($_POST["kind"] as $d) {
					if ($dataKind != "") {
						$dataKind .= ":";
					}
					$dataKind .= $d;
				}
				$this->setByKey($this->getKeyValue(), "JOB_KINDTYPE_LIST", ":".$dataKind.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "JOB_KINDTYPE_LIST", '');
			}

			$dataCompany = "";
			if (count($_POST["company"]) > 0) {
				foreach ($_POST["company"] as $d) {
					if ($dataCompany != "") {
						$dataCompany .= ":";
					}
					$dataCompany .= $d;
				}
				$this->setByKey($this->getKeyValue(), "JOB_COMPANYTYPE_LIST", ":".$dataCompany.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "JOB_COMPANYTYPE_LIST", '');
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "JOB_AREA_LIST", ":".$dataArea.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "JOB_AREA_LIST", '');
			}			

			$dataIcon = "";
			if (count($_POST["icon"]) > 0) {
				foreach ($_POST["icon"] as $d) {
					if ($dataIcon != "") {
						$dataIcon .= ":";
					}
					$dataIcon .= $d;
				}
				$this->setByKey($this->getKeyValue(), "JOB_ICON_LIST", ":".$dataIcon.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "JOB_ICON_LIST", '');
			}			
			


		}

	}

}
?>