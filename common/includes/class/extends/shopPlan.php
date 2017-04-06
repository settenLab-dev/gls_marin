<?php
class shopPlan extends collection {
	const tableName = "SHOPPLAN";
	const keyName = "SHOPPLAN_ID";
	const tableKeyName = "COMPANY_ID";

	public function shopPlan($db) {
		parent::collection($db);
	}

	public function getPlanContentById($id){
		$sql  = "select ";
// 		$sql .= " SHOPPLAN_CONTENTS ";
		$sql .= "SHOPPLAN_CONTENTS ";
		$sql .= "from ".shopPlan::tableName." ";
		
		$where = "";
		if($id){
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopPlan::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
// 		echo $sql;
		parent::setCollection($sql, shopPlan::keyName);
	}
	
	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "SHOPPLAN_ID, COMPANY_ID, SHOP_ID, ";
		$sql .= "SHOPPLAN_FLG, SHOPPLAN_LANG_FLG, SHOPPLAN_NAME, ";
		$sql .= "SHOPPLAN_SALE_FROM, SHOPPLAN_SALE_TO, ";
		$sql .= "SHOPPLAN_ORDER, SHOPPLAN_STATUS ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopPlan::keyName, "=", $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopPlan::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";
	//print_r($sql);
		parent::setCollection($sql, shopPlan::keyName);

	}

	public function select($id="", $statusComma="", $companyId="") {
		$sql  = "select ";
		$sql .= "SHOPPLAN_ID, COMPANY_ID, SHOP_ID, ";

		$sql .= "SHOPPLAN_FLG, SHOPPLAN_LANG_FLG, SHOPPLAN_NAME, SHOPPLAN_CATCH, SHOPPLAN_DISCRIPTION, ";
		$sql .= "SHOPPLAN_INCLUDE, SHOPPLAN_OPTION, SHOPPLAN_GUIDE_FLG, SHOPPLAN_SALE_FROM, SHOPPLAN_SALE_TO, SHOPPLAN_DEPARTS_MIN, SHOPPLAN_ENTRY_FROM, ";
		$sql .= "SHOPPLAN_ENTRY_TO, SHOPPLAN_AGE_FROM, SHOPPLAN_AGE_TO, SHOPPLAN_PARENT1, SHOPPLAN_PARENT2, SHOPPLAN_MEET_PLACE1, SHOPPLAN_MEET_PLACE2, ";
		$sql .= "SHOPPLAN_MEET_PLACE3, SHOPPLAN_PICKUP, SHOPPLAN_PLAY_PLACE, SHOPPLAN_AREA_LIST1, SHOPPLAN_AREA_LIST2, SHOPPLAN_AREA_LIST3, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "SHOPPLAN_PAYMENT".$i.", ";
		}
		for ($i=1; $i<=12; $i++) {
			$sql .= "SHOPPLAN_MEET_TIMEHOUR".$i.", ";
			$sql .= "SHOPPLAN_MEET_TIMEMIN".$i.", ";
			$sql .= "SHOPPLAN_PRICETYPE".$i.", ";
			$sql .= "SHOPPLAN_ROOM".$i.", ";
		}
		$sql .= "SHOPPLAN_USE_TIME, SHOPPLAN_TAG_LIST, SHOPPLAN_CATEGORY1, SHOPPLAN_CATEGORY2, SHOPPLAN_CATEGORY3, SHOPPLAN_CATEGORY_DETAIL, ";
		for ($i=1; $i<=8; $i++) {
			$sql .= "SHOPPLAN_SCEDULE_TITLE".$i.", ";
			$sql .= "SHOPPLAN_SCEDULE_TIME".$i.", ";
			$sql .= "SHOPPLAN_STOP".$i.", ";
		}
		for ($i=1; $i<=9; $i++) {
			$sql .= "SHOPPLAN_POINT_PIC".$i.", ";
			$sql .= "SHOPPLAN_POINT_TEXT".$i.", ";
		}
		$sql .= "SHOPPLAN_GUEST_PREPARATION, SHOPPLAN_ETC, SHOPPLAN_CRAFT1, SHOPPLAN_CRAFT2, SHOPPLAN_ALL_TIME, SHOPPLAN_PLAY_TIME, SHOPPLAN_LISENCE, SHOPPLAN_CAUTION, ";
		$sql .= "SHOPPLAN_PIC1, ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "SHOPPLAN_PIC".$i.", ";
		}
		$sql .= "SHOPPLAN_SELL_PRICE, SHOPPLAN_DEAL_PRICE, SHOPPLAN_DEAL_SP, SHOPPLAN_PROVIDE_FLG, SHOPPLAN_PROVIDE_MAX, SHOPPLAN_PROVIDE_SELL, ";
		$sql .= "SHOPPLAN_DEALNUM_FLG, SHOPPLAN_DEALNUM_MIN, SHOPPLAN_DEALNUM_MAX, SHOPPLAN_DEALPER_FLG, SHOPPLAN_DEALPER_MIN, SHOPPLAN_DEALPER_MAX, ";
		$sql .= "SHOPPLAN_USE, SHOPPLAN_USE_FROM, SHOPPLAN_USE_TO, SHOPPLAN_USE_MEMO, ";

		$sql .= "SHOPPLAN_ACC_DAY, SHOPPLAN_ACC_HOUR, SHOPPLAN_ACC_MIN, SHOPPLAN_CAN_DAY, SHOPPLAN_CAN_HOUR, SHOPPLAN_CAN_MIN, ";

		$sql .= "SHOPPLAN_FLG_CANCEL, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOPPLAN_CANCEL_FLG".$i.", ";
			$sql .= "SHOPPLAN_CANCEL_MONEY".$i.", ";
			if ($i >= 3) {
				$sql .= "SHOPPLAN_CANCEL_FROM".$i.", ";
				$sql .= "SHOPPLAN_CANCEL_TO".$i.", ";
			}
		}
		$sql .= "SHOPPLAN_QUESTION, SHOPPLAN_QUESTION_REC, SHOPPLAN_DEMAND, SHOPPLAN_ORDER, SHOPPLAN_STATUS ";

		$sql .= "from ".shopPlan::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopPlan::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shopPlan::tableKeyName, "=", $companyId)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOPPLAN_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by SHOPPLAN_ORDER ";
		parent::setCollection($sql, shopPlan::keyName);
	//print_r($sql);
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
		$sql  = "insert into ".shopPlan::tableName." (";
		$sql .= "SHOPPLAN_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "SHOP_ID, ";

		$sql .= "SHOPPLAN_FLG, ";
		$sql .= "SHOPPLAN_LANG_FLG, ";
		$sql .= "SHOPPLAN_NAME, ";
		$sql .= "SHOPPLAN_CATCH, ";
		$sql .= "SHOPPLAN_DISCRIPTION, ";

		$sql .= "SHOPPLAN_INCLUDE, ";
		$sql .= "SHOPPLAN_OPTION, ";
		$sql .= "SHOPPLAN_GUIDE_FLG, ";

		$sql .= "SHOPPLAN_SALE_FROM, ";
		$sql .= "SHOPPLAN_SALE_TO, ";

		$sql .= "SHOPPLAN_DEPARTS_MIN, ";

		$sql .= "SHOPPLAN_ENTRY_FROM, ";
		$sql .= "SHOPPLAN_ENTRY_TO, ";
		$sql .= "SHOPPLAN_AGE_FROM, ";
		$sql .= "SHOPPLAN_AGE_TO, ";
		$sql .= "SHOPPLAN_PARENT1, ";
		$sql .= "SHOPPLAN_PARENT2, ";

		for ($i=1; $i<=3; $i++) {
			$sql .= "SHOPPLAN_MEET_PLACE".$i.", ";
		}
		$sql .= "SHOPPLAN_PICKUP, ";
		$sql .= "SHOPPLAN_PLAY_PLACE, ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "SHOPPLAN_AREA_LIST".$i.", ";
		}
		for ($i=1; $i<=12; $i++) {
			$sql .= "SHOPPLAN_MEET_TIMEHOUR".$i.", ";
			$sql .= "SHOPPLAN_MEET_TIMEMIN".$i.", ";
			$sql .= "SHOPPLAN_PRICETYPE".$i.", ";
			$sql .= "SHOPPLAN_ROOM".$i.", ";
		}

		$sql .= "SHOPPLAN_USE_TIME, ";
		$sql .= "SHOPPLAN_TAG_LIST, ";
		$sql .= "SHOPPLAN_CATEGORY1, ";
		$sql .= "SHOPPLAN_CATEGORY2, ";
		$sql .= "SHOPPLAN_CATEGORY3, ";
		$sql .= "SHOPPLAN_CATEGORY_DETAIL, ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "SHOPPLAN_SCEDULE_TITLE".$i.", ";
			$sql .= "SHOPPLAN_SCEDULE_TIME".$i.", ";
			$sql .= "SHOPPLAN_STOP".$i.", ";
		}

		for ($i=1; $i<=9; $i++) {
			$sql .= "SHOPPLAN_POINT_PIC".$i.", ";
			$sql .= "SHOPPLAN_POINT_TEXT".$i.", ";
		}
		$sql .= "SHOPPLAN_GUEST_PREPARATION, ";

		$sql .= "SHOPPLAN_ETC, ";

		$sql .= "SHOPPLAN_CRAFT1, ";
		$sql .= "SHOPPLAN_CRAFT2, ";

		$sql .= "SHOPPLAN_ALL_TIME, ";
		$sql .= "SHOPPLAN_PLAY_TIME, ";

		$sql .= "SHOPPLAN_LISENCE, ";
		$sql .= "SHOPPLAN_CAUTION, ";

		$sql .= "SHOPPLAN_PIC1, ";
		for ($i=2; $i<=6; $i++) {
			$sql .= "SHOPPLAN_PIC".$i.", ";
		}

		$sql .= "SHOPPLAN_SELL_PRICE, ";
		$sql .= "SHOPPLAN_DEAL_PRICE, ";
		$sql .= "SHOPPLAN_DEAL_SP, ";

		$sql .= "SHOPPLAN_PROVIDE_FLG, ";
		$sql .= "SHOPPLAN_PROVIDE_MAX, ";
		$sql .= "SHOPPLAN_PROVIDE_SELL, ";

		$sql .= "SHOPPLAN_DEALNUM_FLG, ";
		$sql .= "SHOPPLAN_DEALNUM_MIN, ";
		$sql .= "SHOPPLAN_DEALNUM_MAX, ";
		$sql .= "SHOPPLAN_DEALPER_FLG, ";
		$sql .= "SHOPPLAN_DEALPER_MIN, ";
		$sql .= "SHOPPLAN_DEALPER_MAX, ";

		$sql .= "SHOPPLAN_USE, ";
		$sql .= "SHOPPLAN_USE_FROM, ";
		$sql .= "SHOPPLAN_USE_TO, ";
		$sql .= "SHOPPLAN_USE_MEMO, ";

		$sql .= "SHOPPLAN_PAYMENT1, ";
		$sql .= "SHOPPLAN_PAYMENT2, ";
		$sql .= "SHOPPLAN_PAYMENT3, ";
		$sql .= "SHOPPLAN_PAYMENT4, ";
		$sql .= "SHOPPLAN_PAYMENT5, ";

		$sql .= "SHOPPLAN_ACC_DAY, ";
		$sql .= "SHOPPLAN_ACC_HOUR, ";
		$sql .= "SHOPPLAN_ACC_MIN, ";

		$sql .= "SHOPPLAN_CAN_DAY, ";
		$sql .= "SHOPPLAN_CAN_HOUR, ";
		$sql .= "SHOPPLAN_CAN_MIN, ";

		$sql .= "SHOPPLAN_FLG_CANCEL, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOPPLAN_CANCEL_FLG".$i.", ";
			$sql .= "SHOPPLAN_CANCEL_MONEY".$i.", ";
			if ($i >= 3) {
				$sql .= "SHOPPLAN_CANCEL_FROM".$i.", ";
				$sql .= "SHOPPLAN_CANCEL_TO".$i.", ";
			}
		}
		$sql .= "SHOPPLAN_QUESTION, ";
		$sql .= "SHOPPLAN_QUESTION_REC, ";
		$sql .= "SHOPPLAN_DEMAND, ";

		$sql .= "SHOPPLAN_ORDER, ";
		$sql .= "SHOPPLAN_STATUS, ";
		$sql .= "SHOPPLAN_REGSIT, ";
		$sql .= "SHOPPLAN_UPDATE) values (";

		$sql .= "null, ";
		$sql .= $dataList["COMPANY_ID"].", ";
		$sql .= "'".$dataList["SHOP_ID"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_FLG"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_LANG_FLG"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_NAME"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CATCH"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DISCRIPTION"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_INCLUDE"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_OPTION"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_GUIDE_FLG"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_SALE_FROM"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_SALE_TO"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_DEPARTS_MIN"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_ENTRY_FROM"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_ENTRY_TO"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_AGE_FROM"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_AGE_TO"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PARENT1"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PARENT2"]."', ";

		for ($i=1; $i<=3; $i++) {
			$sql .= "'".$dataList["SHOPPLAN_MEET_PLACE".$i]."', ";
		}
		$sql .= "'".$dataList["SHOPPLAN_PICKUP"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PLAY_PLACE"]."', ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "'".$dataList["SHOPPLAN_AREA_LIST".$i]."', ";
		}
		for ($i=1; $i<=12; $i++) {
			$sql .= "'".$dataList["SHOPPLAN_MEET_TIMEHOUR".$i]."', ";
			$sql .= "'".$dataList["SHOPPLAN_MEET_TIMEMIN".$i]."', ";
			$sql .= "'".$dataList["SHOPPLAN_PRICETYPE".$i]."', ";
			$sql .= "'".$dataList["SHOPPLAN_ROOM".$i]."', ";
		}

		$sql .= "'".$dataList["SHOPPLAN_USE_TIME"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_TAG_LIST"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CATEGORY1"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CATEGORY2"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CATEGORY3"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CATEGORY_DETAIL"]."', ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "'".$dataList["SHOPPLAN_SCEDULE_TITLE".$i]."', ";
			$sql .= "'".$dataList["SHOPPLAN_SCEDULE_TIME".$i]."', ";
			$sql .= "'".$dataList["SHOPPLAN_STOP".$i]."', ";
		}

		for ($i=1; $i<=9; $i++) {
			$sql .= "'".$dataList["SHOPPLAN_POINT_PIC".$i]."', ";
			$sql .= "'".$dataList["SHOPPLAN_POINT_TEXT".$i]."', ";
		}


		$sql .= "'".$dataList["SHOPPLAN_GUEST_PREPARATION"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_ETC"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_CRAFT1"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CRAFT2"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_ALL_TIME"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PLAY_TIME"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_LISENCE"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CAUTION"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_PIC1"]."', ";
		for ($i=2; $i<=6; $i++) {
			$sql .= "'".$dataList["SHOPPLAN_PIC".$i]."', ";
		}

		$sql .= "'".$dataList["SHOPPLAN_SELL_PRICE"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEAL_PRICE"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEAL_SP"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_PROVIDE_FLG"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PROVIDE_MAX"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PROVIDE_SELL"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_DEALNUM_FLG"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEALNUM_MIN"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEALNUM_MAX"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEALPER_FLG"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEALPER_MIN"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEALPER_MAX"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_USE"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_USE_FROM"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_USE_TO"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_USE_MEMO"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_PAYMENT1"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PAYMENT2"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PAYMENT3"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PAYMENT4"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_PAYMENT5"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_ACC_DAY"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_ACC_HOUR"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_ACC_MIN"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_CAN_DAY"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CAN_HOUR"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_CAN_MIN"]."', ";

		$sql .= "'".$dataList["SHOPPLAN_FLG_CANCEL"]."', ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "'".$dataList["SHOPPLAN_CANCEL_FLG".$i]."', ";
			$sql .= "'".$dataList["SHOPPLAN_CANCEL_MONEY".$i]."', ";
			if ($i >= 3) {
				$sql .= "'".$dataList["SHOPPLAN_CANCEL_FROM".$i]."', ";
				$sql .= "'".$dataList["SHOPPLAN_CANCEL_TO".$i]."', ";
			}
		}
		$sql .= "'".$dataList["SHOPPLAN_QUESTION"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_QUESTION_REC"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_DEMAND"]."', ";

		$sql .= "0, ";
		$sql .= "1, ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//	print_r($sql);

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".shopPlan::tableName." set ";
		$sql .= "COMPANY_ID = ".$dataList["COMPANY_ID"].", ";
		$sql .= "SHOP_ID = '".$dataList["SHOP_ID"]."', ";

		$sql .= "SHOPPLAN_FLG = '".$dataList["SHOPPLAN_FLG"]."', ";
		$sql .= "SHOPPLAN_LANG_FLG = '".$dataList["SHOPPLAN_LANG_FLG"]."', ";
		$sql .= "SHOPPLAN_NAME = '".$dataList["SHOPPLAN_NAME"]."', ";
		$sql .= "SHOPPLAN_CATCH = '".$dataList["SHOPPLAN_CATCH"]."', ";
		$sql .= "SHOPPLAN_DISCRIPTION = '".$dataList["SHOPPLAN_DISCRIPTION"]."', ";

		$sql .= "SHOPPLAN_INCLUDE = '".$dataList["SHOPPLAN_INCLUDE"]."', ";
		$sql .= "SHOPPLAN_OPTION = '".$dataList["SHOPPLAN_OPTION"]."', ";
		$sql .= "SHOPPLAN_GUIDE_FLG = '".$dataList["SHOPPLAN_GUIDE_FLG"]."', ";

		$sql .= "SHOPPLAN_SALE_FROM = '".$dataList["SHOPPLAN_SALE_FROM"]."', ";
		$sql .= "SHOPPLAN_SALE_TO = '".$dataList["SHOPPLAN_SALE_TO"]."', ";

		$sql .= "SHOPPLAN_DEPARTS_MIN = '".$dataList["SHOPPLAN_DEPARTS_MIN"]."', ";

		$sql .= "SHOPPLAN_ENTRY_FROM = '".$dataList["SHOPPLAN_ENTRY_FROM"]."', ";
		$sql .= "SHOPPLAN_ENTRY_TO = '".$dataList["SHOPPLAN_ENTRY_TO"]."', ";
		$sql .= "SHOPPLAN_AGE_FROM = '".$dataList["SHOPPLAN_AGE_FROM"]."', ";
		$sql .= "SHOPPLAN_AGE_TO = '".$dataList["SHOPPLAN_AGE_TO"]."', ";
		$sql .= "SHOPPLAN_PARENT1 = '".$dataList["SHOPPLAN_PARENT1"]."', ";
		$sql .= "SHOPPLAN_PARENT2 = '".$dataList["SHOPPLAN_PARENT2"]."', ";

		for ($i=1; $i<=3; $i++) {
			$sql .= "SHOPPLAN_MEET_PLACE".$i." = '".$dataList["SHOPPLAN_MEET_PLACE".$i]."', ";
		}
		$sql .= "SHOPPLAN_PICKUP = '".$dataList["SHOPPLAN_PICKUP"]."', ";
		$sql .= "SHOPPLAN_PLAY_PLACE = '".$dataList["SHOPPLAN_PLAY_PLACE"]."', ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "SHOPPLAN_AREA_LIST".$i." = '".$dataList["SHOPPLAN_AREA_LIST".$i]."', ";
		}
		for ($i=1; $i<=12; $i++) {
			$sql .= "SHOPPLAN_MEET_TIMEHOUR".$i." = '".$dataList["SHOPPLAN_MEET_TIMEHOUR".$i]."', ";
			$sql .= "SHOPPLAN_MEET_TIMEMIN".$i." = '".$dataList["SHOPPLAN_MEET_TIMEMIN".$i]."', ";
			$sql .= "SHOPPLAN_PRICETYPE".$i." = '".$dataList["SHOPPLAN_PRICETYPE".$i]."', ";
			$sql .= "SHOPPLAN_ROOM".$i." = '".$dataList["SHOPPLAN_ROOM".$i]."', ";
		}

		$sql .= "SHOPPLAN_USE_TIME = '".$dataList["SHOPPLAN_USE_TIME"]."', ";
		$sql .= "SHOPPLAN_TAG_LIST = '".$dataList["SHOPPLAN_TAG_LIST"]."', ";
		$sql .= "SHOPPLAN_CATEGORY1 = '".$dataList["SHOPPLAN_CATEGORY1"]."', ";
		$sql .= "SHOPPLAN_CATEGORY2 = '".$dataList["SHOPPLAN_CATEGORY2"]."', ";
		$sql .= "SHOPPLAN_CATEGORY3 = '".$dataList["SHOPPLAN_CATEGORY3"]."', ";
		$sql .= "SHOPPLAN_CATEGORY_DETAIL = '".$dataList["SHOPPLAN_CATEGORY_DETAIL"]."', ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "SHOPPLAN_SCEDULE_TITLE".$i." = '".$dataList["SHOPPLAN_SCEDULE_TITLE".$i]."', ";
			$sql .= "SHOPPLAN_SCEDULE_TIME".$i." = '".$dataList["SHOPPLAN_SCEDULE_TIME".$i]."', ";
			$sql .= "SHOPPLAN_STOP".$i." = '".$dataList["SHOPPLAN_STOP".$i]."', ";
		}

		for ($i=1; $i<=9; $i++) {
			$sql .= "SHOPPLAN_POINT_PIC".$i." = '".$dataList["SHOPPLAN_POINT_PIC".$i]."', ";
			$sql .= "SHOPPLAN_POINT_TEXT".$i." = '".$dataList["SHOPPLAN_POINT_TEXT".$i]."', ";
		}


		$sql .= "SHOPPLAN_GUEST_PREPARATION = '".$dataList["SHOPPLAN_GUEST_PREPARATION"]."', ";

		$sql .= "SHOPPLAN_ETC = '".$dataList["SHOPPLAN_ETC"]."', ";

		$sql .= "SHOPPLAN_CRAFT1 = '".$dataList["SHOPPLAN_CRAFT1"]."', ";
		$sql .= "SHOPPLAN_CRAFT2 = '".$dataList["SHOPPLAN_CRAFT2"]."', ";

		$sql .= "SHOPPLAN_ALL_TIME = '".$dataList["SHOPPLAN_ALL_TIME"]."', ";
		$sql .= "SHOPPLAN_PLAY_TIME = '".$dataList["SHOPPLAN_PLAY_TIME"]."', ";

		$sql .= "SHOPPLAN_LISENCE = '".$dataList["SHOPPLAN_LISENCE"]."', ";
		$sql .= "SHOPPLAN_CAUTION = '".$dataList["SHOPPLAN_CAUTION"]."', ";

		$sql .= "SHOPPLAN_PIC1 = '".$dataList["SHOPPLAN_PIC1"]."', ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "SHOPPLAN_PIC".$i." = '".$dataList["SHOPPLAN_PIC".$i]."', ";
		}

		$sql .= "SHOPPLAN_SELL_PRICE = '".$dataList["SHOPPLAN_SELL_PRICE"]."', ";
		$sql .= "SHOPPLAN_DEAL_PRICE = '".$dataList["SHOPPLAN_DEAL_PRICE"]."', ";
		$sql .= "SHOPPLAN_DEAL_SP = '".$dataList["SHOPPLAN_DEAL_SP"]."', ";

		$sql .= "SHOPPLAN_PROVIDE_FLG = '".$dataList["SHOPPLAN_PROVIDE_FLG"]."', ";
		$sql .= "SHOPPLAN_PROVIDE_MAX = '".$dataList["SHOPPLAN_PROVIDE_MAX"]."', ";
		$sql .= "SHOPPLAN_PROVIDE_SELL = '".$dataList["SHOPPLAN_PROVIDE_SELL"]."', ";

		$sql .= "SHOPPLAN_DEALNUM_FLG = '".$dataList["SHOPPLAN_DEALNUM_FLG"]."', ";
		$sql .= "SHOPPLAN_DEALNUM_MIN = '".$dataList["SHOPPLAN_DEALNUM_MIN"]."', ";
		$sql .= "SHOPPLAN_DEALNUM_MAX = '".$dataList["SHOPPLAN_DEALNUM_MAX"]."', ";
		$sql .= "SHOPPLAN_DEALPER_FLG = '".$dataList["SHOPPLAN_DEALPER_FLG"]."', ";
		$sql .= "SHOPPLAN_DEALPER_MIN = '".$dataList["SHOPPLAN_DEALPER_MIN"]."', ";
		$sql .= "SHOPPLAN_DEALPER_MAX = '".$dataList["SHOPPLAN_DEALPER_MAX"]."', ";
		
		$sql .= "SHOPPLAN_USE = '".$dataList["SHOPPLAN_USE"]."', ";
		$sql .= "SHOPPLAN_USE_FROM = '".$dataList["SHOPPLAN_USE_FROM"]."', ";
		$sql .= "SHOPPLAN_USE_TO = '".$dataList["SHOPPLAN_USE_TO"]."', ";
		$sql .= "SHOPPLAN_USE_MEMO = '".$dataList["SHOPPLAN_USE_MEMO"]."', ";

		$sql .= "SHOPPLAN_PAYMENT1 = '".$dataList["SHOPPLAN_PAYMENT1"]."', ";
		$sql .= "SHOPPLAN_PAYMENT2 = '".$dataList["SHOPPLAN_PAYMENT2"]."', ";
		$sql .= "SHOPPLAN_PAYMENT3 = '".$dataList["SHOPPLAN_PAYMENT3"]."', ";
		$sql .= "SHOPPLAN_PAYMENT4 = '".$dataList["SHOPPLAN_PAYMENT4"]."', ";
		$sql .= "SHOPPLAN_PAYMENT5 = '".$dataList["SHOPPLAN_PAYMENT5"]."', ";

		$sql .= "SHOPPLAN_ACC_DAY = '".$dataList["SHOPPLAN_ACC_DAY"]."', ";
		$sql .= "SHOPPLAN_ACC_HOUR = '".$dataList["SHOPPLAN_ACC_HOUR"]."', ";
		$sql .= "SHOPPLAN_ACC_MIN = '".$dataList["SHOPPLAN_ACC_MIN"]."', ";

		$sql .= "SHOPPLAN_CAN_DAY = '".$dataList["SHOPPLAN_CAN_DAY"]."', ";
		$sql .= "SHOPPLAN_CAN_HOUR = '".$dataList["SHOPPLAN_CAN_HOUR"]."', ";
		$sql .= "SHOPPLAN_CAN_MIN = '".$dataList["SHOPPLAN_CAN_MIN"]."', ";
		
		$sql .= "SHOPPLAN_FLG_CANCEL = '".$dataList["SHOPPLAN_FLG_CANCEL"]."', ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOPPLAN_CANCEL_FLG".$i." = '".$dataList["SHOPPLAN_CANCEL_FLG".$i]."', ";
			$sql .= "SHOPPLAN_CANCEL_MONEY".$i." = '".$dataList["SHOPPLAN_CANCEL_MONEY".$i]."', ";
			if ($i >= 3) {
				$sql .= "SHOPPLAN_CANCEL_FROM".$i." = '".$dataList["SHOPPLAN_CANCEL_FROM".$i]."', ";
				$sql .= "SHOPPLAN_CANCEL_TO".$i." = '".$dataList["SHOPPLAN_CANCEL_TO".$i]."', ";
			}
		}
		$sql .= "SHOPPLAN_QUESTION = '".$dataList["SHOPPLAN_QUESTION"]."', ";
		$sql .= "SHOPPLAN_QUESTION_REC = '".$dataList["SHOPPLAN_QUESTION_REC"]."', ";
		$sql .= "SHOPPLAN_DEMAND = '".$dataList["SHOPPLAN_DEMAND"]."', ";

		$sql .= "SHOPPLAN_STATUS = '".$dataList["SHOPPLAN_STATUS"]."', ";
		$sql .= "SHOPPLAN_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  shopPlan::keyName." = ".parent::getKeyValue()." ";
//print_r($sql);
		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".shopPlan::tableName." set ";
		$sql .= parent::expsData("SHOPPLAN_STATUS", "=", 3).", ";
		$sql .= parent::expsData("SHOPPLAN_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusPublic() {
		$this->db->begin();

		$sql .= "update ".shopPlan::tableName." set ";
		$sql .= parent::expsData("SHOPPLAN_STATUS", "=", 2).", ";
		$sql .= parent::expsData("SHOPPLAN_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopPlan::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusDisabled() {
		$this->db->begin();

		$sql .= "update ".shopPlan::tableName." set ";
		$sql .= parent::expsData("SHOPPLAN_STATUS", "=", 1).", ";
		$sql .= parent::expsData("SHOPPLAN_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shopPlan::keyName, "=", parent::getKeyValue())." ";

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
			$sql  = "update ".shopPlan::tableName." set ";
			$sql .= parent::expsData("SHOPPLAN_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= shopPlan::keyName." = ".$v." ";
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

		if (parent::getByKey(parent::getKeyValue(), "SHOPPLAN_PIC1_setup") != "") {
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_PIC1", $this->getByKey($this->getKeyValue(), "SHOPPLAN_PIC1_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("SHOPPLAN_PIC1", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("SHOPPLAN_PIC1", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "SHOPPLAN_PIC1", $msg);
			}
		}

		for ($i=2; $i<=6; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "SHOPPLAN_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "SHOPPLAN_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOPPLAN_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("SHOPPLAN_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("SHOPPLAN_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "SHOPPLAN_PIC".$i, $msg);
				}
			}
		}
		for ($i=1; $i<=9; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "SHOPPLAN_POINT_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "SHOPPLAN_POINT_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOPPLAN_POINT_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("SHOPPLAN_POINT_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("SHOPPLAN_POINT_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "SHOPPLAN_POINT_PIC".$i, $msg);
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_NAME"))) {
			parent::setError("SHOPPLAN_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_NAME"), 50)) {
			parent::setError("SHOPPLAN_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_FLG_CANCEL"))) {
			parent::setError("SHOPPLAN_FLG_CANCEL", "必須項目です");
		}
		else {
			if (parent::getByKey(parent::getKeyValue(), "SHOPPLAN_FLG_CANCEL") == 2) {
				//	個別設定
				for ($i=1; $i<=6; $i++) {

					if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i))) {
						if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i), CHK_PTN_NUM)) {
							parent::setError("SHOPPLAN_CANCEL_MONEY".$i, "半角数字で入力して下さい");
						}
						else {
							if (parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_FLG".$i) == 1) {
								if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i), 3)) {
									parent::setError("SHOPPLAN_CANCEL_MONEY".$i, "3文字以内で入力して下さい");
								}
							}
							else {
								if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_MONEY".$i), 10)) {
									parent::setError("SHOPPLAN_CANCEL_MONEY".$i, "10文字以内で入力して下さい");
								}
							}
						}
					}


					if ($i >= 3) {
						if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i))) {
							if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i), CHK_PTN_NUM)) {
								parent::setError("SHOPPLAN_CANCEL_FROM".$i, "半角数字で入力して下さい");
							}
							elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_FROM".$i), 2)) {
								parent::setError("SHOPPLAN_CANCEL_FROM".$i, "2文字以内で入力して下さい");
							}
						}

						if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_TO".$i))) {
							if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_TO".$i), CHK_PTN_NUM)) {
								parent::setError("SHOPPLAN_CANCEL_TO".$i, "半角数字で入力して下さい");
							}
							elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOPPLAN_CANCEL_TO".$i), 2)) {
								parent::setError("SHOPPLAN_CANCEL_TO".$i, "2文字以内で入力して下さい");
							}
						}
					}

				}
			}
		}

	}


	public function setPost() {
		if ($_POST) {

			$this->setByKey($this->getKeyValue(), "SHOPPLAN_PAYMENT1", 2);
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_PAYMENT2", 2);
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_PAYMENT3", 2);
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_PAYMENT4", 2);
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_QUESTION_REC", 2);
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_FLG", 1);
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_LANG_FLG", 1);
			$this->setByKey($this->getKeyValue(), "SHOPPLAN_DEMAND", 2);

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}


			$dataTag = "";
			if (count($_POST["tag"]) > 0) {
				foreach ($_POST["tag"] as $d) {
					if ($dataTag != "") {
						$dataTag .= ":";
					}
					$dataTag .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOPPLAN_TAG_LIST", ":".$dataTag.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "SHOPPLAN_TAG_LIST", '');
			}


		}

	}


}
?>