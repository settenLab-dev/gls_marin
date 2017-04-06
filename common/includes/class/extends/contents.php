<?php
class contents extends collection {
	const tableName = "CONTENTS";
	const keyName = "CONTENTS_ID";
	const tableKeyName = "CONTENTS_ID";

	public function contents($db) {
		parent::collection($db);
	}

	// 検索
	public function selectListPublicKuchikomi($collection)  {
/*
		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}
*/
		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		//	クチコミ
		$sql .= "co.CONTENTS_ID, ";
		$sql .= "co.CONTENTS_CATEGORY, ";
		$sql .= "co.CONTENTS_AREA, ";
		$sql .= "co.COMPANY_ID, ";
		$sql .= "co.CONTENTS_FACILITY_NAME, ";
		$sql .= "co.MEMBER_ID, ";
		$sql .= "co.CONTENTS_NAME, ";
		$sql .= "co.CONTENTS_USE_DATE, ";
		$sql .= "co.CONTENTS_TITLE, ";
		$sql .= "co.CONTENTS_DETAIL, ";
		$sql .= "co.CONTENTS_WHO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "co.CONTENTS_PIC".$i.", ";
		}
		$sql .= "co.CONTENTS_FLG_PUBLIC, ";
		$sql .= "co.CONTENTS_STATUS, ";
		$sql .= "co.CONTENTS_REGIST, ";
		$sql .= "co.CONTENTS_UPDATE ";
	//	$sql .= "co.CONTENTS_DELETE ";

		$sql .= "from ";

		$sql .= $this->resFrom($collection);

		$where = "";
		$where = $this->resWhere($collection);

//		print $where;


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

			//  プランで検索
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			$sql .= "group by co.CONTENTS_ID ";
		}

		$having = "";
		//	金額
//		if ($collection->getByKey($collection->getKeyValue(), "budget_from") != "") {
//			if ($having != "") {
//				$having .= "and ";
//			}
//			$having .= parent::expsData("money_1", ">=", $collection->getByKey($collection->getKeyValue(), "budget_from"))." ";
//		}
//		 if ($collection->getByKey($collection->getKeyValue(), "budget_to") != "") {
//			if ($having != "") {
//				$having .= "and ";
//			}
//			$having .= parent::expsData("money_1", "<=", $collection->getByKey($collection->getKeyValue(), "budget_to"))." ";
//		}
//
//		if ($having != "") {
//			$sql .= "having ".$having." ";
//		}


		$sql = "(".$sql.") ";
	//	$sql = "(".$sql.") ";
	//	$sql = 

		$sql .= "order by CONTENTS_ID desc ";
//		if ($collection->getByKey($collection->getKeyValue(), "orderdata") == "") {
//			$sql .= "order by HOTEL_ORDER ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 1) {
//			$sql .= "order by money_all ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 2) {
//			$sql .= "order by money_all desc ";
//		}
// 		parent::setCollection($sql, "COMPANY_ID");

			//  プランで検索
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}
			//  プランで検索時の表示分母
		parent::setCollection($sql, "", false, true);
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			parent::setMaxCount();
		}

// print_r($sql);

	}


	// 検索件数のカウント&IDの取得
	public function selectListCompanyCount($collection)  {
/*
		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}


		//	宿泊人数
		$checkNum = $this->resStayNum($collection);

		//	適用する○人用料金
		$money_1 = $this->resStay1Money($collection);
*/

		$sql = "select ";

		//	ホテル
		$sql .= "co.CONTENTS_ID, ";
		$sql .= "co.CONTENTS_TITLE ";
		//$sql .= $money_1." as money_1 ";

		//	ページャで検索対象IDを持ち越さないように初期化
		$collection->setByKey($collection->getKeyValue(), "targetId", "");

		
		$sql .= $this->resFrom($collection);

		$where = "";
		$where = $this->resWhere($collection);

//		print $where;

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "group by co.CONTENTS_ID ";
// 		$sql .= "group by hp.HOTELPLAN_ID, r.ROOM_ID ";

		$having = "";

		//	金額
//		if ($collection->getByKey($collection->getKeyValue(), "budget_from") != "") {
//			if ($having != "") {
//				$having .= "and ";
//			}
//			$having .= parent::expsData("money_1", ">=", $collection->getByKey($collection->getKeyValue(), "budget_from"))." ";
//		}
//		 if ($collection->getByKey($collection->getKeyValue(), "budget_to") != "") {
//			if ($having != "") {
//				$having .= "and ";
//			}
//			$having .= parent::expsData("money_1", "<=", $collection->getByKey($collection->getKeyValue(), "budget_to"))." ";
//		}
//
//		if ($having != "") {
//			$sql .= "having ".$having." ";
//		}
		$sqlcc = $sql;

		$sql = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS * from ";
		$sql .= "(".$sqlcc.") ";
	//	$sql .= "(".$sqlcc.") as UNI ";



//		$sql .= "order by HOTEL_ORDER ";
		// 		$sql .= "order by h.HOTEL_ORDER ";
//		if ($collection->getByKey($collection->getKeyValue(), "orderdata") == "") {
//			$sql .= "order by HOTEL_ORDER ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 1) {
//			$sql .= "order by money_1 ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 2) {
//			$sql .= "order by money_1 desc ";
//		}
/*
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "list") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}
*/
// 		print_r($sql);
		parent::setCollection($sql, "CONTENTS_ID");
// 		parent::setCollection($sql, "", false, true);

		parent::setMaxCount();
	
//	print_r($sql);
	}

	private function resFrom($collection) {
		$sql .= "CONTENTS co ";
	//	$sql .= "inner join COMPANY c on h.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_HOTERL = 1 ";
	//	$sql .= "and (c.COMPANY_LINK = '' or c.COMPANY_LINK is null) ";
		//	ホテルID
/*		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$COMPANY_S = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$sql .= "and h.COMPANY_ID = '$COMPANY_S' ";
//			$sql .= "and ".parent::expsData("h.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		//	宿種
		if ($collection->getByKey($collection->getKeyValue(), "kind") != "") {
			$KIND_S = $collection->getByKey($collection->getKeyValue(), "kind");
			$sql .= "and h.HOTEL_FLG_KIND = '$KIND_S' ";
//			$sql .= "and ".parent::expsData("h.HOTEL_FLG_KIND", "=", $collection->getByKey($collection->getKeyValue(), "kind"))." ";
		}
*/

//		$sql .= "inner join HOTELPLAN hp on h.COMPANY_ID = hp.COMPANY_ID and hp.HOTELPLAN_STATUS = 2 ";

/*		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			$PLAN_S = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
			$sql .= "and hp.HOTELPLAN_ID = '$PLAN_S' ";
		}
		$sql .=" and hp.HOTELPLAN_FLG_SEACRET=2 ";
		//	食事
		if ($collection->getByKey($collection->getKeyValue(), "meal2") == 2) {
			//	朝
			$sql .= "and hp.HOTELPLAN_BF_FLG = 2 ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "meal3") == 3) {
			//	夕
			$sql .= "and hp.HOTELPLAN_DN_FLG = 2 ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "meal4") == 4) {
			//	昼
			$sql .= "and hp.HOTELPLAN_LN_FLG = 2 ";
		}


		//	お勧めカテゴリ
		//==================================================================================
		if ($collection->getByKey($collection->getKeyValue(), "recommend") != "") {
			$RECOMMEND_S = $collection->getByKey($collection->getKeyValue(), "recommend");
			$sql .= "and hp.HOTELPLAN_RECOMM_URL = '$RECOMMEND_S' ";
		}
		//==================================================================================

		$sql .= "inner join HOTELPAY hpay on h.COMPANY_ID = hpay.COMPANY_ID and hp.HOTELPLAN_ID = hpay.HOTELPLAN_ID ";
		
		$stayNumEveryRoom = $this->selectNumEveryRoom($collection);
		for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
			$sql .= "and hpay.HOTELPAY_MONEY".$stayNumEveryRoom[$roomNum]." <> 'x' ";
			$sql .= "and hpay.HOTELPAY_MONEY".$stayNumEveryRoom[$roomNum]." <> '' ";
			$sql .= "and hpay.HOTELPAY_MONEY".$stayNumEveryRoom[$roomNum]." is not null ";
		}
		
		$sql .= "inner join HOTELPROVIDE hprov on h.COMPANY_ID = hprov.COMPANY_ID ";
		$sql .= "and hpay.HOTELPAY_DATE = hprov.HOTELPROVIDE_DATE ";
		$sql .= "and hprov.HOTELPROVIDE_FLG_STOP = 1 ";

		$sql .= "inner join ROOM r on h.COMPANY_ID = r.COMPANY_ID ";
		$sql .= "and r.ROOM_ID = hpay.ROOM_ID ";
		$sql .= "and r.ROOM_ID = hprov.ROOM_ID ";

		$sql .= "and hp.HOTELPLAN_ROOM_LIST like concat('%:', r.ROOM_ID, ':%')";
		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			$ROOM_S = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$sql .= "and r.ROOM_ID = '$ROOM_S' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "room_type") != "") {
			$ROOMTYPE_S = $collection->getByKey($collection->getKeyValue(), "room_type");
			$sql .= "and r.ROOM_TYPE = '$ROOMTYPE_S' ";
		}

		$sql .= " and hprov.HOTELPROVIDE_FLG_STOP = 1 ";
*/

	//	print_r($sql);
		return $sql;
	}


	private function resWhere($collection) {

		$where = "";

		//	公開中のものだけ表示
		$where .= "co.CONTENTS_STATUS = 2 ";

		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			$AREA_S = "%:".$collection->getByKey($collection->getKeyValue(), "area").":%";
			$where .= "and co.CONTENTS_AREA like '$AREA_S' ";
		}

		//	ID
		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_ID") != "") {
			$ID = $collection->getByKey($collection->getKeyValue(), "CONTENTS_ID");
			$where .= "and co.CONTENTS_ID = '$ID' ";
		}

		//	カテゴリ
		if ($collection->getByKey($collection->getKeyValue(), "category") != "") {
			$CATE_S = "%:".$collection->getByKey($collection->getKeyValue(), "category").":%";
			$where .= "and co.CONTENTS_CATEGORY like '$CATE_S' ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "free") != "") {
			$FREE_S = "%".$collection->getByKey($collection->getKeyValue(), "free")."%";
			$where .= "and (co.CONTENTS_FACILITY_NAME like '$FREE_S' ";
			$where .= "or co.CONTENTS_TITLE like '$FREE_S' ";
			$where .= "or co.CONTENTS_DETAIL like '$FREE_S') ";
		}


		return $where;

	}


	public function selectSide($collection) {
		$sql  = "select ";
		$sql .= "co.CONTENTS_ID, ";
		$sql .= "co.CONTENTS_CATEGORY, ";
		$sql .= "co.CONTENTS_AREA, ";
		$sql .= "co.COMPANY_ID, ";
		$sql .= "co.CONTENTS_FACILITY_NAME, ";
		$sql .= "co.MEMBER_ID, ";
		$sql .= "co.CONTENTS_NAME, ";
		$sql .= "co.CONTENTS_USE_DATE, ";
		$sql .= "co.CONTENTS_TITLE, ";
		$sql .= "co.CONTENTS_DETAIL, ";
		$sql .= "co.CONTENTS_WHO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "co.CONTENTS_PIC".$i.", ";
		}
		$sql .= "co.CONTENTS_FLG_PUBLIC, ";
		$sql .= "co.CONTENTS_STATUS, ";
		$sql .= "co.CONTENTS_REGIST, ";
		$sql .= "co.CONTENTS_UPDATE ";
		$sql .= "from ".contents::tableName." k ";

		$where = "";
/*
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".event::keyName, "=", $id)." ";
		}
*/

		// ステータス公開中のもののみ
		if ($where != "") {
			$where .= "and ";
		}
		$where .= "CONTENTS_STATUS = 2 ";

		//	ID
		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_ID") != "") {
			$ID = $collection->getByKey($collection->getKeyValue(), "CONTENTS_ID");
			$where .= "and co.CONTENTS_ID = '$ID' ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		//イベントID順に並ぶ
		$sql .= "order by CONTENTS_ID desc ";

		//TOPでは最新6件表示
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "top") {
				$sql .= "limit 6 ";
		}
		//サイドでは最新3件表示
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "side") {
				$sql .= "limit 3 ";
		}

		parent::setCollection($sql, contents::keyName);
//print $sql;
	}

	public function selectListAdmin($collection) {
		$sql  = "select ";
		$sql .= "co.CONTENTS_ID, ";
		$sql .= "co.CONTENTS_CATEGORY, ";
		$sql .= "co.CONTENTS_AREA, ";
		$sql .= "co.COMPANY_ID, ";
		$sql .= "co.SHOP_ID, ";
		$sql .= "s.SHOP_NAME, ";
		$sql .= "co.SHOPPLAN_ID, ";
		$sql .= "co.CONTENTS_FACILITY_NAME, ";
		$sql .= "co.MEMBER_ID, ";
		$sql .= "co.CONTENTS_NAME, ";
		$sql .= "co.CONTENTS_USE_DATE, ";
		$sql .= "co.CONTENTS_TITLE, ";
		$sql .= "co.CONTENTS_DETAIL, ";
		$sql .= "co.CONTENTS_WHO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "co.CONTENTS_PIC".$i.", ";
		}

		$sql .= "co.CONTENTS_APPROV_SHOP, ";
		$sql .= "co.CONTENTS_APPROV_ADMIN, ";
		$sql .= "co.CONTENTS_FLG_PUBLIC, ";
		$sql .= "co.CONTENTS_STATUS, ";
		$sql .= "co.CONTENTS_REGIST, ";
		$sql .= "co.CONTENTS_UPDATE, ";
		$sql .= "co.CONTENTS_DELETE ";
		$sql .= "from CONTENTS co ";
		$sql .= "left join ".shop::tableName." s on s.COMPANY_ID = co.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".contents::keyName, "=", $collection->getByKey($collection->getKeyValue(), "CONTENTS_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_TITLE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$CONTENTS_NAM = "%".$collection->getByKey($collection->getKeyValue(), "CONTENTS_TITLE")."%";
			$where .= "CONTENTS_TITLE like '$CONTENTS_NAM' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_AREA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$CONTENTS_AREA = "%".$collection->getByKey($collection->getKeyValue(), "CONTENTS_AREA")."%";
			$where .= "CONTENTS_AREA like '$CONTENTS_AREA' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_USE_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$USE_DATE = $collection->getByKey($collection->getKeyValue(), "CONTENTS_USE_DATE");
			$where .= "CONTENTS_USE_DATE = '".$collection->getByKey($collection->getKeyValue(), "CONTENTS_USE_DATE")."' ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by CONTENTS_ID desc ";

		parent::setCollection($sql, contents::keyName);

	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "co.CONTENTS_ID, ";
		$sql .= "co.CONTENTS_CATEGORY, ";
		$sql .= "co.CONTENTS_AREA, ";
		$sql .= "co.COMPANY_ID, ";
		$sql .= "co.SHOP_ID, ";
		$sql .= "co.SHOPPLAN_ID, ";
		$sql .= "s.SHOP_NAME, ";
		$sql .= "co.CONTENTS_FACILITY_NAME, ";
		$sql .= "co.MEMBER_ID, ";
		$sql .= "co.CONTENTS_NAME, ";
		$sql .= "co.CONTENTS_USE_DATE, ";
		$sql .= "co.CONTENTS_TITLE, ";
		$sql .= "co.CONTENTS_DETAIL, ";
		$sql .= "co.CONTENTS_WHO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "co.CONTENTS_PIC".$i.", ";
		}
		$sql .= "co.CONTENTS_APPROV_SHOP, ";
		$sql .= "co.CONTENTS_APPROV_ADMIN, ";
		$sql .= "co.CONTENTS_STATUS, ";
		$sql .= "co.CONTENTS_FLG_PUBLIC, ";
		$sql .= "co.CONTENTS_STATUS, ";
		$sql .= "co.CONTENTS_REGIST, ";
		$sql .= "co.CONTENTS_UPDATE, ";
		$sql .= "co.CONTENTS_DELETE ";
		$sql .= "from CONTENTS co ";
		$sql .= "left join ".shop::tableName." s on s.COMPANY_ID = co.COMPANY_ID ";
	//	$sql .= "left join ".hotel::tableName." a on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("co.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("co.".contents::keyName, "=", $collection->getByKey($collection->getKeyValue(), "CONTENTS_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_TITLE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$CONTENTS_NAM = "%".$collection->getByKey($collection->getKeyValue(), "CONTENTS_TITLE")."%";
			$where .= "CONTENTS_TITLE like '$CONTENTS_NAM' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_AREA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$CONTENTS_AREA = "%".$collection->getByKey($collection->getKeyValue(), "CONTENTS_AREA")."%";
			$where .= "CONTENTS_AREA like '$CONTENTS_AREA' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "CONTENTS_USE_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$USE_DATE = $collection->getByKey($collection->getKeyValue(), "CONTENTS_USE_DATE");
			$where .= "CONTENTS_USE_DATE = '".$collection->getByKey($collection->getKeyValue(), "CONTENTS_USE_DATE")."' ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by CONTENTS_ID desc ";

		parent::setCollection($sql, contents::keyName);
	}

	public function select($id="",$key="" , $statusComma="") {
		$sql  = "select ";
		$sql .= "co.CONTENTS_ID, ";
		$sql .= "co.CONTENTS_CATEGORY, ";
		$sql .= "co.CONTENTS_AREA, ";
		$sql .= "co.COMPANY_ID, ";
		$sql .= "co.SHOP_ID, ";
		$sql .= "co.SHOPPLAN_ID, ";
		$sql .= "s.SHOP_NAME, ";
		$sql .= "co.CONTENTS_FACILITY_NAME, ";
		$sql .= "co.MEMBER_ID, ";
		$sql .= "co.CONTENTS_NAME, ";
		$sql .= "co.CONTENTS_USE_DATE, ";
		$sql .= "co.CONTENTS_TITLE, ";
		$sql .= "co.CONTENTS_DETAIL, ";
		$sql .= "co.CONTENTS_WHO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "co.CONTENTS_PIC".$i.", ";
		}
		$sql .= "co.CONTENTS_APPROV_SHOP, ";
		$sql .= "co.CONTENTS_APPROV_ADMIN, ";
		$sql .= "co.CONTENTS_STATUS, ";
		$sql .= "co.CONTENTS_FLG_PUBLIC, ";
		$sql .= "co.CONTENTS_STATUS, ";
		$sql .= "co.CONTENTS_REGIST, ";
		$sql .= "co.CONTENTS_UPDATE ";
		$sql .= "from ".contents::tableName." k ";
		$sql .= "left join ".shop::tableName." s on s.COMPANY_ID = co.COMPANY_ID ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".contents::keyName, "=", $id)." ";
		}
		if ($key != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".COMPANY_ID, "=", $key)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("CONTENTS_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by CONTENTS_ID desc ";

		parent::setCollection($sql, contents::keyName);
//print $sql;
	}

	public function save() {
		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
// 		print_r($dataList);exit;
		$sql = "";
// 		if (parent::getKeyValue() < 0 or parent::getKeyValue() == "") {
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

	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".hotel::tableName." set ";
			$sql .= parent::expsData("CONTENTS_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotel::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$this->db->commit();
		return true;
	}


	public function insert($dataList) {
		$sql  = "insert into ".contents::tableName." (";
		$sql .= "CONTENTS_ID, ";
		$sql .= "CONTENTS_CATEGORY, ";
		$sql .= "CONTENTS_AREA, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "SHOP_ID, ";
		$sql .= "SHOPPLAN_ID, ";
		$sql .= "CONTENTS_FACILITY_NAME, ";
		$sql .= "MEMBER_ID, ";
		$sql .= "CONTENTS_NAME, ";
		$sql .= "CONTENTS_USE_DATE, ";
		$sql .= "CONTENTS_TITLE, ";
		$sql .= "CONTENTS_DETAIL, ";
		$sql .= "CONTENTS_WHO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "CONTENTS_PIC".$i.", ";
		}
		$sql .= "CONTENTS_APPROV_SHOP, ";
		$sql .= "CONTENTS_APPROV_ADMIN, ";

		$sql .= "CONTENTS_FLG_PUBLIC, ";
		$sql .= "CONTENTS_STATUS, ";
		$sql .= "CONTENTS_REGIST, ";
		$sql .= "CONTENTS_UPDATE) values (";


 		$sql .= "null, ";
		$sql .= "'".$dataList["CONTENTS_CATEGORY"]."', ";
		$sql .= "'".$dataList["CONTENTS_AREA"]."', ";
		$sql .= "'".$dataList["COMPANY_ID"]."', ";
		$sql .= "'".$dataList["SHOP_ID"]."', ";
		$sql .= "'".$dataList["SHOPPLAN_ID"]."', ";
		$sql .= "'".$dataList["CONTENTS_FACILITY_NAME"]."', ";
		$sql .= "'".$dataList["MEMBER_ID"]."', ";
		$sql .= "'".$dataList["CONTENTS_NAME"]."', ";
		$sql .= "'".$dataList["CONTENTS_USE_DATE"]."', ";
		$sql .= "'".$dataList["CONTENTS_TITLE"]."', ";
		$sql .= "'".$dataList["CONTENTS_DETAIL"]."', ";
		$sql .= "'".$dataList["CONTENTS_WHO"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["CONTENTS_PIC".$i]."', ";
		}
		$sql .= "'".$dataList["CONTENTS_APPROV_SHOP"]."', ";
		$sql .= "'".$dataList["CONTENTS_APPROV_ADMIN"]."', ";

		$sql .= "'".$dataList["CONTENTS_FLG_PUBLIC"]."', ";
		$sql .= "'".$dataList["CONTENTS_STATUS"]."', ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//	print $sql;

		return $sql;
	}

	public function update($dataList) {
//	print_r($dataList);
		$sql .= "update ".contents::tableName." set ";
		$sql .= "CONTENTS_ID = '".$dataList["CONTENTS_ID"]."', ";
		$sql .= "CONTENTS_CATEGORY = '".$dataList["CONTENTS_CATEGORY"]."', ";
		$sql .= "CONTENTS_AREA = '".$dataList["CONTENTS_AREA"]."', ";
		$sql .= "COMPANY_ID = '".$dataList["COMPANY_ID"]."', ";
		$sql .= "SHOP_ID = '".$dataList["SHOP_ID"]."', ";
		$sql .= "SHOPPLAN_ID = '".$dataList["SHOPPLAN_ID"]."', ";
		$sql .= "CONTENTS_FACILITY_NAME = '".$dataList["CONTENTS_FACILITY_NAME"]."', ";
		$sql .= "MEMBER_ID = '".$dataList["MEMBER_ID"]."', ";
		$sql .= "CONTENTS_NAME = '".$dataList["CONTENTS_NAME"]."', ";
		$sql .= "CONTENTS_USE_DATE = '".$dataList["CONTENTS_USE_DATE"]."', ";
		$sql .= "CONTENTS_TITLE = '".$dataList["CONTENTS_TITLE"]."', ";
		$sql .= "CONTENTS_DETAIL = '".$dataList["CONTENTS_DETAIL"]."', ";
		$sql .= "CONTENTS_WHO = '".$dataList["CONTENTS_WHO"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "CONTENTS_PIC".$i." = '".$dataList["CONTENTS_PIC".$i]."', ";
		}
		$sql .= "CONTENTS_APPROV_SHOP = '".$dataList["CONTENTS_APPROV_SHOP"]."', ";
		$sql .= "CONTENTS_APPROV_ADMIN = '".$dataList["CONTENTS_APPROV_ADMIN"]."', ";

		$sql .= "CONTENTS_FLG_PUBLIC = '".$dataList["CONTENTS_FLG_PUBLIC"]."', ";
		$sql .= "CONTENTS_STATUS = '".$dataList["CONTENTS_STATUS"]."', ";
		$sql .= "CONTENTS_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  contents::keyName." = ".parent::getKeyValue() ;
//	print $sql;

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotel::tableName." set ";
		$sql .= parent::expsData("CONTENTS_STATUS", "=", 3).", ";
		$sql .= parent::expsData("CONTENTS_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(contents::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "CONTENTS_TITLE"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "CONTENTS_TITLE"), 100)) {
				parent::setError("CONTENTS_TITLE", "100文字以内で入力して下さい");
			}
		}
/*
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"), CHK_PTN_ZIPCODE_JP)) {
				parent::setError("HOTEL_ZIP", "郵便番号は000-0000の形式で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"), 50)) {
				parent::setError("HOTEL_CITY", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"), 50)) {
				parent::setError("HOTEL_ADDRESS", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"), CHK_PTN_TEL)) {
				parent::setError("HOTEL_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
			}
		}
*/
		/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME"))) {
			parent::setError("HOTEL_NAME", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME"), 50)) {
			parent::setError("HOTEL_NAME", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"))) {
			parent::setError("HOTEL_NAME_KANA", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"), 50)) {
			parent::setError("HOTEL_NAME_KANA", "50文字以内で入力して下さい");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"), CHK_PTN_KANA)) {
			parent::setError("HOTEL_NAME_KANA", "全角カナで入力して下さい");
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FLG_KIND"))) {
			parent::setError("HOTEL_FLG_KIND", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FLG_PUBLIC"))) {
			parent::setError("HOTEL_FLG_PUBLIC", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"))) {
			parent::setError("HOTEL_ZIP", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ZIP"), CHK_PTN_ZIPCODE_JP)) {
			parent::setError("HOTEL_ZIP", "郵便番号は000-0000の形式で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_PREF"))) {
			parent::setError("HOTEL_PREF", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"))) {
			parent::setError("HOTEL_CITY", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_CITY"), 50)) {
			parent::setError("HOTEL_CITY", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"))) {
			parent::setError("HOTEL_ADDRESS", "必須項目です");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ADDRESS"), 50)) {
			parent::setError("HOTEL_ADDRESS", "50文字以内で入力して下さい");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"))) {
			parent::setError("HOTEL_TEL", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_TEL"), CHK_PTN_TEL)) {
			parent::setError("HOTEL_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
		}
		*/

		if (parent::getByKey(parent::getKeyValue(), "CONTENTS_PIC_APP_setup") != "") {
			$this->setByKey($this->getKeyValue(), "CONTENTS_PIC_APP", $this->getByKey($this->getKeyValue(), "CONTENTS_PIC_APP_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "CONTENTS_ID"));
			$msg = $inputer->upload("CONTENTS_PIC_APP", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("CONTENTS_PIC_APP", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "CONTENTS_PIC_APP", $msg);
			}
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "CONTENTS_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "CONTENTS_PIC".$i, $this->getByKey($this->getKeyValue(), "CONTENTS_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "CONTENTS_ID"));
				$msg = $inputer->upload("CONTENTS_PIC".$i, IMG_HOTEL_FAC_SIZE, IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("CONTENTS_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "CONTENTS_PIC".$i, $msg);
				}

			}
		}
/*
		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_PARKING"))) {
			parent::setError("HOTEL_PARKING", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_SEND"))) {
			parent::setError("HOTEL_SEND", "必須項目です");
		}


		for ($i=1; $i<=3; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=4; $i<=5; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 4)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 6;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
				parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=7; $i<=8; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 4)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 9;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
				parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=10; $i<=11; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 4)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		for ($i=12; $i<=15; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 3)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=30; $i<=49; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("HOTEL_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_ROOM_DATA".$i), 10)) {
					parent::setError("HOTEL_ROOM_DATA".$i, "10文字以内で入力して下さい");
				}
			}
		}

		for ($i=1; $i<=2; $i++) {

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_NUM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_NUM".$i), CHK_PTN_NUM)) {
					parent::setError("HOTEL_FACILITY_NUM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_NUM".$i), 3)) {
					parent::setError("HOTEL_FACILITY_NUM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_FROM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_FROM".$i), CHK_PTN_NUM)) {
					parent::setError("HOTEL_FACILITY_FROM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_FROM".$i), 3)) {
					parent::setError("HOTEL_FACILITY_FROM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_TO".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_TO".$i), CHK_PTN_NUM)) {
					parent::setError("HOTEL_FACILITY_TO".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_FACILITY_TO".$i), 3)) {
					parent::setError("HOTEL_FACILITY_TO".$i, "3文字以内で入力して下さい");
				}
			}

		}
*/


	}

	public function setPost($picFLg=false) {
		if ($_POST) {

			$this->setByKey($this->getKeyValue(), "CONTENTS_APPROV_SHOP", 1);
			$this->setByKey($this->getKeyValue(), "CONTENTS_APPROV_ADMIN", 1);
			$this->setByKey($this->getKeyValue(), "CONTENTS_STATUS", 1);

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			$dataLocation = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataCategory != "") {
						$dataCategory .= ":";
					}
					$dataCategory .= $d;
				}
				$this->setByKey($this->getKeyValue(), "CONTENTS_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "CONTENTS_CATEGORY", '');
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "CONTENTS_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "CONTENTS_AREA", '');
			}

		}

	}


}
?>