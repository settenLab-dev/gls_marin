<?php
class hotelPlan extends collection {
	const tableName = "HOTELPLAN";
	const keyName = "HOTELPLAN_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelPlan($db) {
		parent::collection($db);
	}

	public function getPlanContentById($id){
		$sql  = "select ";
// 		$sql .= " HOTELPLAN_CONTENTS ";
		$sql .= "HOTELPLAN_CONTENTS ";
		$sql .= "from ".hotelPlan::tableName." ";
		
		$where = "";
		if($id){
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPlan::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
// 		echo $sql;
		parent::setCollection($sql, hotelPlan::keyName);
	}
	
	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "HOTELPLAN_ID, COMPANY_ID,  HOTELPLAN_DATE_SALE_FROM, HOTELPLAN_DATE_SALE_TO, ";
		$sql .= "HOTELPLAN_DATE_POST_FROM, HOTELPLAN_DATE_POST_TO, HOTELPLAN_FLG_DAYUSE, ";
		$sql .= "HOTELPLAN_NAME, HOTELPLAN_ROOM_LIST, ";
		$sql .= "HOTELPLAN_ORDER, HOTELPLAN_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPlan::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPlan::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
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

		parent::setCollection($sql, hotelPlan::keyName);
	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "HOTELPLAN_ID, COMPANY_ID,  HOTELPLAN_DATE_SALE_FROM, HOTELPLAN_DATE_SALE_TO, ";
		$sql .= "HOTELPLAN_FLG_DAYUSE, HOTELPLAN_DATE_POST_FROM, HOTELPLAN_DATE_POST_TO, HOTELPLAN_ROOM_NUM, HOTELPLAN_FLG_SEACRET, HOTELPLAN_PAYMENT, ";
		$sql .= "HOTELPLAN_CONTENTS, HOTELPLAN_PIC, ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "HOTELPLAN_PIC".$i.", ";
		}
		$sql .= "HOTELPLAN_NAME, HOTELPLAN_FEATURE, HOTELPLAN_ROOM_LIST, ";
		$sql .= "HOTELPLAN_ACC, HOTELPLAN_CAN, HOTELPLAN_CHECKIN, HOTELPLAN_CHECKIN_LAST, HOTELPLAN_CHECKOUT, ";
		$sql .= "HOTELPLAN_ACC_DAY, HOTELPLAN_CAN_DAY, ";
		$sql .= "HOTELPLAN_ACC_HOUR, HOTELPLAN_ACC_MIN, HOTELPLAN_CAN_HOUR, HOTELPLAN_CAN_MIN, ";
// 		$sql .= "HOTELPLAN_ACC_DAY, HOTELPLAN_ACC_HOUR, HOTELPLAN_ACC_MIN, HOTELPLAN_CAN_FLG, HOTELPLAN_CAN_DAY, HOTELPLAN_CAN_HOUR, HOTELPLAN_CAN_MIN,";
// 		for ($i=1; $i<=2; $i++) {
// 			$sql .= "HOTELPLAN_CHECKIN_HOUR".$i.", ";
// 			$sql .= "HOTELPLAN_CHECKIN_MIN".$i.", ";
// 		}
// 		$sql .= "HOTELPLAN_CHECKOUT_HOUR, HOTELPLAN_CHECKOUT_MIN, ";
		for ($i=1; $i<=2; $i++) {
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
		$sql .= "HOTELPLAN_QUESTION, HOTELPLAN_FOOD1, HOTELPLAN_FOOD2, HOTELPLAN_FOOD3, HOTELPLAN_DISCOUNT, ";
		$sql .= "HOTELPLAN_QUESTION_REC, HOTELPLAN_DEMAND, HOTELPLAN_ORDER, HOTELPLAN_STATUS,  ";
		$sql .= "HOTELPLAN_RECOMM_FLG, HOTELPLAN_RECOMM_URL, ";
		$sql .= "HOTELPLAN_RECOMM_TITLE, HOTELPLAN_RECOMM_COMMENT, HOTELPLAN_RECOMM_PIC ";

		$sql .= "from ".hotelPlan::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPlan::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPlan::tableKeyName, "=", $companyId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPLAN_ORDER ";
		parent::setCollection($sql, hotelPlan::keyName);
//	print_r($sql);
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
// 		print_r($dataList);
		$sql  = "insert into ".hotelPlan::tableName." (";
		$sql .= "HOTELPLAN_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "HOTELPLAN_ROOM_LIST, ";
		$sql .= "HOTELPLAN_DATE_SALE_FROM, ";
		$sql .= "HOTELPLAN_DATE_SALE_TO, ";

		$sql .= "HOTELPLAN_FLG_DAYUSE, ";
		$sql .= "HOTELPLAN_DATE_POST_FROM, ";
		$sql .= "HOTELPLAN_DATE_POST_TO, ";
		$sql .= "HOTELPLAN_ROOM_NUM, ";
		$sql .= "HOTELPLAN_FLG_SEACRET, ";
		$sql .= "HOTELPLAN_CONTENTS, ";
		$sql .= "HOTELPLAN_PAYMENT, ";
		$sql .= "HOTELPLAN_PIC, ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "HOTELPLAN_PIC".$i.", ";
		}
		$sql .= "HOTELPLAN_NAME, ";
		$sql .= "HOTELPLAN_FEATURE, ";
// 		$sql .= "HOTELPLAN_ACC_DAY, ";
// 		$sql .= "HOTELPLAN_ACC_HOUR, ";
// 		$sql .= "HOTELPLAN_ACC_MIN, ";
// 		$sql .= "HOTELPLAN_CAN_FLG, ";
// 		$sql .= "HOTELPLAN_CAN_DAY, ";
// 		$sql .= "HOTELPLAN_CAN_HOUR, ";
// 		$sql .= "HOTELPLAN_CAN_MIN, ";
// 		for ($i=1; $i<=2; $i++) {
// 			$sql .= "HOTELPLAN_CHECKIN_HOUR".$i.", ";
// 			$sql .= "HOTELPLAN_CHECKIN_MIN".$i.", ";
// 		}
// 		$sql .= "HOTELPLAN_CHECKOUT_HOUR, ";
// 		$sql .= "HOTELPLAN_CHECKOUT_MIN, ";
		$sql .= "HOTELPLAN_ACC_DAY, ";
		$sql .= "HOTELPLAN_ACC, ";
		$sql .= "HOTELPLAN_ACC_HOUR, ";
		$sql .= "HOTELPLAN_ACC_MIN, ";
		$sql .= "HOTELPLAN_CAN_DAY, ";
		$sql .= "HOTELPLAN_CAN, ";
		$sql .= "HOTELPLAN_CAN_HOUR, ";
		$sql .= "HOTELPLAN_CAN_MIN, ";
		$sql .= "HOTELPLAN_CHECKIN, ";
		$sql .= "HOTELPLAN_CHECKIN_LAST, ";
		$sql .= "HOTELPLAN_CHECKOUT, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_NIGHTS_FLG".$i.", ";
			$sql .= "HOTELPLAN_NIGHTS_NUM".$i.", ";
		}
		$sql .= "HOTELPLAN_BF_FLG, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_BF_CHECK".$i.", ";
		}
		$sql .= "HOTELPLAN_DN_FLG, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_DN_CHECK".$i.", ";
		}
		$sql .= "HOTELPLAN_LN_FLG, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_LN_CHECK".$i.", ";
		}
		for ($i=1; $i<=3; $i++) {
			$sql .= "HOTELPLAN_FOOD".$i.", ";
		}
		$sql .= "HOTELPLAN_DISCOUNT, ";
		$sql .= "HOTELPLAN_FLG_CANCEL, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPLAN_CANCEL_FLG".$i.", ";
			$sql .= "HOTELPLAN_CANCEL_MONEY".$i.", ";
			if ($i >= 3) {
				$sql .= "HOTELPLAN_CANCEL_FROM".$i.", ";
				$sql .= "HOTELPLAN_CANCEL_TO".$i.", ";
			}
		}
		$sql .= "HOTELPLAN_QUESTION, ";
		$sql .= "HOTELPLAN_QUESTION_REC, ";
		$sql .= "HOTELPLAN_DEMAND, ";
		$sql .= "HOTELPLAN_RECOMM_FLG, ";
		$sql .= "HOTELPLAN_RECOMM_URL, ";
		$sql .= "HOTELPLAN_RECOMM_TITLE, ";
		$sql .= "HOTELPLAN_RECOMM_COMMENT, ";
		$sql .= "HOTELPLAN_RECOMM_PIC, ";
		$sql .= "HOTELPLAN_ORDER, ";
		$sql .= "HOTELPLAN_STATUS, ";
		$sql .= "HOTELPLAN_DATE_REGSIT, ";
		$sql .= "HOTELPLAN_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";
		$sql .= "'".$dataList["HOTELPLAN_ROOM_LIST"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_DATE_SALE_FROM"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_DATE_SALE_TO"]."', ";

		$sql .= "'".$dataList["HOTELPLAN_FLG_DAYUSE"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_DATE_POST_FROM"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_DATE_POST_TO"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_ROOM_NUM"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_FLG_SEACRET"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_CONTENTS"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_PAYMENT"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_PIC"]."', ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "'".$dataList["HOTELPLAN_PIC".$i]."', ";
		}

		$sql .= "'".$dataList["HOTELPLAN_NAME"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_FEATURE"]."', ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_ACC_DAY"]).", ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_ACC_HOUR"]).", ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_ACC_MIN"]).", ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CAN_FLG"]).", ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CAN_DAY"]).", ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CAN_HOUR"]).", ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CAN_MIN"]).", ";
// 		for ($i=1; $i<=2; $i++) {
// 			$sql .= parent::expsVal($dataList["HOTELPLAN_CHECKIN_HOUR".$i]).", ";
// 			$sql .= parent::expsVal($dataList["HOTELPLAN_CHECKIN_MIN".$i]).", ";
// 		}
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CHECKOUT_HOUR"]).", ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CHECKOUT_MIN"]).", ";
		$sql .= "'".$dataList["HOTELPLAN_ACC_DAY"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_ACC"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_ACC_HOUR"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_ACC_MIN"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_CAN_DAY"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_CAN"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_CAN_HOUR"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_CAN_MIN"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_CHECKIN_HOUR1"].':'.$dataList['HOTELPLAN_CHECKIN_MIN1']."', ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CHECKIN"], true, 1).", ";
		$sql .= "'".$dataList["HOTELPLAN_CHECKIN_HOUR2"].':'.$dataList['HOTELPLAN_CHECKIN_MIN2']."', ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CHECKIN_LAST"], true, 1).", ";
		$sql .= "'".$dataList["HOTELPLAN_CHECKIN_HOUR3"].':'.$dataList['HOTELPLAN_CHECKIN_MIN3']."', ";
// 		$sql .= parent::expsVal($dataList["HOTELPLAN_CHECKOUT"], true, 1).", ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "'".$dataList["HOTELPLAN_NIGHTS_FLG".$i]."', ";
			$sql .= "'".$dataList["HOTELPLAN_NIGHTS_NUM".$i]."', ";
		}
		$sql .= "'".$dataList["HOTELPLAN_BF_FLG"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "'".$dataList["HOTELPLAN_BF_CHECK".$i]."', ";
		}
		$sql .= "'".$dataList["HOTELPLAN_DN_FLG"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "'".$dataList["HOTELPLAN_BF_CHECK".$i]."', ";
		}
		$sql .= "'".$dataList["HOTELPLAN_LN_FLG"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "'".$dataList["HOTELPLAN_LN_CHECK".$i]."', ";
		}
		for ($i=1; $i<=3; $i++) {
			$sql .= "'".$dataList["HOTELPLAN_FOOD".$i]."', ";
		}
		$sql .= "'".$dataList["HOTELPLAN_DISCOUNT"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_FLG_CANCEL"]."', ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "'".$dataList["HOTELPLAN_CANCEL_FLG".$i]."', ";
			$sql .= "'".$dataList["HOTELPLAN_CANCEL_MONEY".$i]."', ";
			if ($i >= 3) {
				$sql .= "'".$dataList["HOTELPLAN_CANCEL_FROM".$i]."', ";
				$sql .= "'".$dataList["HOTELPLAN_CANCEL_TO".$i]."', ";
			}
		}
		$sql .= "'".$dataList["HOTELPLAN_QUESTION"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_QUESTION_REC"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_DEMAND"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_RECOMM_FLG"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_RECOMM_URL"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_RECOMM_TITLE"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_RECOMM_COMMENT"]."', ";
		$sql .= "'".$dataList["HOTELPLAN_RECOMM_PIC"]."', ";
		$sql .= "0, ";
		$sql .= "1, ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//	print_r($sql);

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelPlan::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";
		$sql .= "HOTELPLAN_ROOM_LIST = '".$dataList["HOTELPLAN_ROOM_LIST"]."', ";
		$sql .= "HOTELPLAN_DATE_SALE_FROM = '".$dataList["HOTELPLAN_DATE_SALE_FROM"]."', ";
		$sql .= "HOTELPLAN_DATE_SALE_TO = '".$dataList["HOTELPLAN_DATE_SALE_TO"]."', ";

		$sql .= "HOTELPLAN_FLG_DAYUSE = '".$dataList["HOTELPLAN_FLG_DAYUSE"]."', ";
		$sql .= "HOTELPLAN_DATE_POST_FROM = '".$dataList["HOTELPLAN_DATE_POST_FROM"]."', ";
		$sql .= "HOTELPLAN_DATE_POST_TO = '".$dataList["HOTELPLAN_DATE_POST_TO"]."', ";
		$sql .= "HOTELPLAN_ROOM_NUM = '".$dataList["HOTELPLAN_ROOM_NUM"]."', ";
		$sql .= "HOTELPLAN_FLG_SEACRET = '".$dataList["HOTELPLAN_FLG_SEACRET"]."', ";
		$sql .= "HOTELPLAN_CONTENTS = '".$dataList["HOTELPLAN_CONTENTS"]."', ";
		$sql .= "HOTELPLAN_PAYMENT = '".$dataList["HOTELPLAN_PAYMENT"]."', ";
		$sql .= "HOTELPLAN_PIC = '".$dataList["HOTELPLAN_PIC"]."', ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "HOTELPLAN_PIC".$i." = '".$dataList["HOTELPLAN_PIC".$i]."', ";
		}

		$sql .= "HOTELPLAN_NAME = '".$dataList["HOTELPLAN_NAME"]."', ";
		$sql .= "HOTELPLAN_FEATURE = '".$dataList["HOTELPLAN_FEATURE"]."', ";
// 		$sql .= parent::expsData("HOTELPLAN_ACC_DAY", "=", $dataList["HOTELPLAN_ACC_DAY"]).", ";
// 		$sql .= parent::expsData("HOTELPLAN_ACC_HOUR", "=", $dataList["HOTELPLAN_ACC_HOUR"]).", ";
// 		$sql .= parent::expsData("HOTELPLAN_ACC_MIN", "=", $dataList["HOTELPLAN_ACC_MIN"]).", ";
// 		$sql .= parent::expsData("HOTELPLAN_CAN_FLG", "=", $dataList["HOTELPLAN_CAN_FLG"]).", ";
// 		$sql .= parent::expsData("HOTELPLAN_CAN_DAY", "=", $dataList["HOTELPLAN_CAN_DAY"]).", ";
// 		$sql .= parent::expsData("HOTELPLAN_CAN_HOUR", "=", $dataList["HOTELPLAN_CAN_HOUR"]).", ";
// 		$sql .= parent::expsData("HOTELPLAN_CAN_MIN", "=", $dataList["HOTELPLAN_CAN_MIN"]).", ";
// 		for ($i=1; $i<=2; $i++) {
// 			$sql .= parent::expsData("HOTELPLAN_CHECKIN_HOUR".$i, "=", $dataList["HOTELPLAN_CHECKIN_HOUR".$i]).", ";
// 			$sql .= parent::expsData("HOTELPLAN_CHECKIN_MIN".$i, "=", $dataList["HOTELPLAN_CHECKIN_MIN".$i]).", ";
// 		}
// 		$sql .= parent::expsData("HOTELPLAN_CHECKOUT_HOUR", "=", $dataList["HOTELPLAN_CHECKOUT_HOUR"]).", ";
// 		$sql .= parent::expsData("HOTELPLAN_CHECKOUT_MIN", "=", $dataList["HOTELPLAN_CHECKOUT_MIN"]).", ";
		$sql .= "HOTELPLAN_ACC_DAY = '".$dataList["HOTELPLAN_ACC_DAY"]."', ";
		$sql .= "HOTELPLAN_ACC = '".$dataList["HOTELPLAN_ACC"]."', ";
		$sql .= "HOTELPLAN_ACC_HOUR = '".$dataList["HOTELPLAN_ACC_HOUR"]."', ";
		$sql .= "HOTELPLAN_ACC_MIN = '".$dataList["HOTELPLAN_ACC_MIN"]."', ";
		$sql .= "HOTELPLAN_CAN_DAY = '".$dataList["HOTELPLAN_CAN_DAY"]."', ";
		$sql .= "HOTELPLAN_CAN = '".$dataList["HOTELPLAN_CAN"]."', ";
		$sql .= "HOTELPLAN_CAN_HOUR = '".$dataList["HOTELPLAN_CAN_HOUR"]."', ";
		$sql .= "HOTELPLAN_CAN_MIN = '".$dataList["HOTELPLAN_CAN_MIN"]."', ";
		
		
		$sql .= "HOTELPLAN_CHECKIN = '".$dataList["HOTELPLAN_CHECKIN_HOUR1"].':'.$dataList['HOTELPLAN_CHECKIN_MIN1']."', ";
		$sql .= "HOTELPLAN_CHECKIN_LAST = '".$dataList["HOTELPLAN_CHECKIN_HOUR2"].':'.$dataList['HOTELPLAN_CHECKIN_MIN2']."', ";
		$sql .= "HOTELPLAN_CHECKOUT = '".$dataList["HOTELPLAN_CHECKIN_HOUR3"].':'.$dataList['HOTELPLAN_CHECKIN_MIN3']."', ";
		
// 		$sql .= parent::expsData("HOTELPLAN_CHECKIN", "=", $dataList["HOTELPLAN_CHECKIN"], true, 1).", ";
// 		$sql .= parent::expsData("HOTELPLAN_CHECKIN_LAST = ".$dataList["HOTELPLAN_CHECKIN_LAST"], true, 1).", ";
// 		$sql .= parent::expsData("HOTELPLAN_CHECKOUT", "=", $dataList["HOTELPLAN_CHECKOUT"], true, 1).", ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_NIGHTS_FLG".$i." = '".$dataList["HOTELPLAN_NIGHTS_FLG".$i]."', ";
			$sql .= "HOTELPLAN_NIGHTS_NUM".$i." = '".$dataList["HOTELPLAN_NIGHTS_NUM".$i]."', ";
		}
		$sql .= "HOTELPLAN_BF_FLG = '".$dataList["HOTELPLAN_BF_FLG"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_BF_CHECK".$i." = '".$dataList["HOTELPLAN_BF_CHECK".$i]."', ";
		}
		$sql .= "HOTELPLAN_DN_FLG = '".$dataList["HOTELPLAN_DN_FLG"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_DN_CHECK".$i." = '".$dataList["HOTELPLAN_DN_CHECK".$i]."', ";
		}
		$sql .= "HOTELPLAN_LN_FLG = '".$dataList["HOTELPLAN_LN_FLG"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTELPLAN_LN_CHECK".$i." = '".$dataList["HOTELPLAN_LN_CHECK".$i]."', ";
		}
		for ($i=1; $i<=3; $i++) {
			$sql .= "HOTELPLAN_FOOD".$i." = '".$dataList["HOTELPLAN_FOOD".$i]."', ";
		}
		$sql .= "HOTELPLAN_DISCOUNT = '".$dataList["HOTELPLAN_DISCOUNT"]."', ";
		$sql .= "HOTELPLAN_FLG_CANCEL = '".$dataList["HOTELPLAN_FLG_CANCEL"]."', ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPLAN_CANCEL_FLG".$i." = '".$dataList["HOTELPLAN_CANCEL_FLG".$i]."', ";
			$sql .= "HOTELPLAN_CANCEL_MONEY".$i." = '".$dataList["HOTELPLAN_CANCEL_MONEY".$i]."', ";
			if ($i >= 3) {
				$sql .= "HOTELPLAN_CANCEL_FROM".$i." = '".$dataList["HOTELPLAN_CANCEL_FROM".$i]."', ";
				$sql .= "HOTELPLAN_CANCEL_TO".$i." = '".$dataList["HOTELPLAN_CANCEL_TO".$i]."', ";
			}
		}
		$sql .= "HOTELPLAN_QUESTION = '".$dataList["HOTELPLAN_QUESTION"]."', ";
		$sql .= "HOTELPLAN_QUESTION_REC = '".$dataList["HOTELPLAN_QUESTION_REC"]."', ";
		$sql .= "HOTELPLAN_DEMAND = '".$dataList["HOTELPLAN_DEMAND"]."', ";
		$sql .= "HOTELPLAN_RECOMM_FLG = '".$dataList["HOTELPLAN_RECOMM_FLG"]."', ";
		$sql .= "HOTELPLAN_RECOMM_URL = '".$dataList["HOTELPLAN_RECOMM_URL"]."', ";
		$sql .= "HOTELPLAN_RECOMM_TITLE = '".$dataList["HOTELPLAN_RECOMM_TITLE"]."', ";
		$sql .= "HOTELPLAN_RECOMM_COMMENT = '".$dataList["HOTELPLAN_RECOMM_COMMENT"]."', ";
		$sql .= "HOTELPLAN_RECOMM_PIC = '".$dataList["HOTELPLAN_RECOMM_PIC"]."', ";
		$sql .= "HOTELPLAN_STATUS = '".$dataList["HOTELPLAN_STATUS"]."', ";
		$sql .= "HOTELPLAN_DATE_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  hotelPlan::keyName." = ".parent::getKeyValue()." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotelPlan::tableName." set ";
		$sql .= parent::expsData("HOTELPLAN_STATUS", "=", 3).", ";
		$sql .= parent::expsData("HOTELPLAN_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusPublic() {
		$this->db->begin();

		$sql .= "update ".hotelPlan::tableName." set ";
		$sql .= parent::expsData("HOTELPLAN_STATUS", "=", 2).", ";
		$sql .= parent::expsData("HOTELPLAN_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusDisabled() {
		$this->db->begin();

		$sql .= "update ".hotelPlan::tableName." set ";
		$sql .= parent::expsData("HOTELPLAN_STATUS", "=", 1).", ";
		$sql .= parent::expsData("HOTELPLAN_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPlan::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".hotelPlan::tableName." set ";
			$sql .= parent::expsData("HOTELPLAN_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelPlan::keyName." = ".$v." ";
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

		if (count($_POST["room"]) <= 0) {
			parent::setError("room", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"))) {
			parent::setError("HOTELPLAN_DATE_SALE_FROM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"), CHK_PTN_DATE)) {
			parent::setError("HOTELPLAN_DATE_SALE_FROM", "日付の形式を確認して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_SALE_TO"))) {
			parent::setError("HOTELPLAN_DATE_SALE_TO", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_SALE_TO"), CHK_PTN_DATE)) {
			parent::setError("HOTELPLAN_DATE_SALE_TO", "日付の形式を確認して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_FLG_DAYUSE"))) {
			parent::setError("HOTELPLAN_FLG_DAYUSE", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_POST_FROM"))) {
			parent::setError("HOTELPLAN_DATE_POST_FROM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_POST_FROM"), CHK_PTN_DATE)) {
			parent::setError("HOTELPLAN_DATE_POST_FROM", "日付の形式を確認して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_POST_TO"))) {
			parent::setError("HOTELPLAN_DATE_POST_TO", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DATE_POST_TO"), CHK_PTN_DATE)) {
			parent::setError("HOTELPLAN_DATE_POST_TO", "日付の形式を確認して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ROOM_NUM"))) {
			parent::setError("HOTELPLAN_ROOM_NUM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ROOM_NUM"), CHK_PTN_NUM)) {
			parent::setError("HOTELPLAN_ROOM_NUM", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ROOM_NUM"), 10)) {
			parent::setError("HOTELPLAN_ROOM_NUM", "10文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_FLG_SEACRET"))) {
			parent::setError("HOTELPLAN_FLG_SEACRET", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_PAYMENT"))) {
			parent::setError("HOTELPLAN_PAYMENT", "必須項目です");
		}


		if (parent::getByKey(parent::getKeyValue(), "HOTELPLAN_PIC_setup") != "") {
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_PIC", $this->getByKey($this->getKeyValue(), "HOTELPLAN_PIC_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("HOTELPLAN_PIC", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("HOTELPLAN_PIC", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "HOTELPLAN_PIC", $msg);
			}
		}

		for ($i=2; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "HOTELPLAN_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "HOTELPLAN_PIC".$i, $this->getByKey($this->getKeyValue(), "HOTELPLAN_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("HOTELPLAN_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("HOTELPLAN_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "HOTELPLAN_PIC".$i, $msg);
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NAME"))) {
			parent::setError("HOTELPLAN_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_NAME"), 50)) {
			parent::setError("HOTELPLAN_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_FEATURE"))) {
			parent::setError("HOTELPLAN_FEATURE", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_FLG_CANCEL"))) {
			parent::setError("HOTELPLAN_FLG_CANCEL", "必須項目です");
		}
		else {
			if (parent::getByKey(parent::getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 2) {
				//	個別設定
				for ($i=1; $i<=6; $i++) {

// 					if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i))) {
// 						parent::setError("HOTELPLAN_CANCEL_FLG".$i, "必須項目です");
// 					}

// 					if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i))) {
// 						parent::setError("HOTELPLAN_CANCEL_MONEY".$i, "必須項目です");
// 					}
					if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i))) {
						if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i), CHK_PTN_NUM)) {
							parent::setError("HOTELPLAN_CANCEL_MONEY".$i, "半角数字で入力して下さい");
						}
						else {
							if (parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
								if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i), 3)) {
									parent::setError("HOTELPLAN_CANCEL_MONEY".$i, "3文字以内で入力して下さい");
								}
							}
							else {
								if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i), 10)) {
									parent::setError("HOTELPLAN_CANCEL_MONEY".$i, "10文字以内で入力して下さい");
								}
							}
						}
					}


					if ($i >= 3) {
						if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i))) {
							if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i), CHK_PTN_NUM)) {
								parent::setError("HOTELPLAN_CANCEL_FROM".$i, "半角数字で入力して下さい");
							}
							elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_FROM".$i), 2)) {
								parent::setError("HOTELPLAN_CANCEL_FROM".$i, "2文字以内で入力して下さい");
							}
						}

						if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_TO".$i))) {
							if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_TO".$i), CHK_PTN_NUM)) {
								parent::setError("HOTELPLAN_CANCEL_TO".$i, "半角数字で入力して下さい");
							}
							elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CANCEL_TO".$i), 2)) {
								parent::setError("HOTELPLAN_CANCEL_TO".$i, "2文字以内で入力して下さい");
							}
						}
					}

				}
			}
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"))) {
			parent::setError("HOTELPLAN_ACC_DAY", "必須項目です");
		}
		
		
		if (!cmCheckSpan(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC_DAY"),"BOOKSET_BOOKING_DAY")) {
			parent::setError("HOTELPLAN_ACC_DAY", "ホテル全体の予約設定日に超えています");
		}
// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC"))) {
// 			parent::setError("HOTELPLAN_ACC", "必須項目です");
// 		}
// 		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_ACC"), CHK_PTN_TIME)) {
// 			parent::setError("HOTELPLAN_ACC", "00:00の形式で入力して下さい");
// 		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"))) {
			parent::setError("HOTELPLAN_CAN_DAY", "必須項目です");
		}
		
		if (!cmCheckSpan(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY"),"BOOKSET_CANCEL_DAY")) {
			parent::setError("HOTELPLAN_CAN_DAY", "ホテル全体の予約設定日に超えています");
		}
		
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

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_DN_FLG"))) {
// 			parent::setError("HOTELPLAN_DN_FLG", "必須項目です");
// 		}

// 		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_STATUS"))) {
// 			parent::setError("HOTELPLAN_STATUS", "必須項目です");
// 		}


		if (parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_FLG") == 1) {

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_URL"))) {
				parent::setError("HOTELPLAN_RECOMM_URL", "必須項目です");
			}
// 			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_URL"), CHK_PTN_URL)) {
// 				parent::setError("HOTELPLAN_RECOMM_URL", "URLの形式を確認して下さい");
// 			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_TITLE"))) {
				parent::setError("HOTELPLAN_RECOMM_TITLE", "必須項目です");
			}
			// 			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_TITLE"), 30)) {
			// 				parent::setError("HOTELPLAN_RECOMM_TITLE", "30文字以内で入力して下さい");
			// 			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPLAN_RECOMM_COMMENT"))) {
				parent::setError("HOTELPLAN_RECOMM_COMMENT", "必須項目です");
			}

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

	}


	public function setPost() {
		if ($_POST) {

			$this->setByKey($this->getKeyValue(), "HOTELPLAN_BF_CHECK1", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_BF_CHECK2", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_DN_CHECK1", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_DN_CHECK2", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_LN_CHECK1", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_LN_CHECK2", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_QUESTION_REC", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPLAN_DEMAND", 2);

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			$dataRoom = "";
			if (count($_POST["room"]) > 0) {
				foreach ($_POST["room"] as $d) {
					if ($dataRoom != "") {
						$dataRoom .= ":";
					}
					$dataRoom .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTELPLAN_ROOM_LIST", ":".$dataRoom.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "HOTELPLAN_ROOM_LIST", $this->getByKey($this->getKeyValue(), "HOTELPLAN_ROOM_LIST"));
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
				$this->setByKey($this->getKeyValue(), "hotelPlan_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPlan_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelPlan_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelPlan_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelPlan_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPlan_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelPlan_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelPlan_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPlan_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelPlan_LIST_AREA"));
			}
			*/


		}

	}


}
?>