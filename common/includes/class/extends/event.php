<?php
class event extends collection {
	const tableName = "EVENT";
	const keyName = "EVENT_ID";
	const tableKeyName = "EVENT_ID";

	public function event($db) {
		parent::collection($db);
	}

	// 検索
	public function selectListPublicEvent($collection)  {

		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		//	イベント
		$sql .= "e.EVENT_ID, ";
		$sql .= "e.EVENT_SHOW_FROM, ";
		$sql .= "e.EVENT_SHOW_TO, ";
		$sql .= "e.EVENT_POST_FROM, ";
		$sql .= "e.EVENT_POST_TO, ";
		$sql .= "e.EVENT_CATEGORY, ";
		$sql .= "e.EVENT_AREA, ";
		$sql .= "e.EVENT_NAME, ";
		$sql .= "e.EVENT_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "e.EVENT_PIC".$i.", ";
		}
		$sql .= "e.EVENT_PRICE, ";
		$sql .= "e.EVENT_ENTRY_HOW, ";
		$sql .= "e.EVENT_ADDRESS, ";
		$sql .= "e.EVENT_ACCESS, ";
		$sql .= "e.EVENT_LON, ";
		$sql .= "e.EVENT_LAT, ";
		$sql .= "e.EVENT_NOVELTY, ";
		$sql .= "e.EVENT_COMPANY, ";
		$sql .= "e.EVENT_CONTACT, ";
		$sql .= "e.EVENT_FLG_PUBLIC, ";
		$sql .= "e.EVENT_STATUS, ";
		$sql .= "e.EVENT_REGIST, ";
		$sql .= "e.EVENT_UPDATE ";
		$sql .= "from ";


		$sql .= $this->resFrom($collection);

		$where = "";
		$where = $this->resWhere($collection);

//		print $where;


		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		//  検索方法でgroup分化
			//  ホテルで検索
//		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
	//		$sql .= "group by hpt.HOTELPLAN_ID, rt.ROOM_ID ";
	//	}
			//  プランで検索
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			$sql .= "group by e.EVENT_ID ";
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

		//イベント登録降順(ID順)にならぶ
//		$sql .= "order by EVENT_ID desc ";

		//イベント開催日が近い順に並ぶ
		$sql .= "order by EVENT_POST_FROM asc ";

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

//	print_r($sql);

	}


	// 検索件数のカウント&IDの取得
	public function selectListCompanyCount($collection)  {

		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

/*
		//	宿泊人数
		$checkNum = $this->resStayNum($collection);

		//	適用する○人用料金
		$money_1 = $this->resStay1Money($collection);
*/

		$sql = "select ";

		//	ホテル
		$sql .= "e.EVENT_ID, ";
		$sql .= "e.EVENT_NAME ";
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

		$sql .= "group by e.EVENT_ID ";
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
 	//	print_r($sql);
		parent::setCollection($sql, "EVENT_ID");
// 		parent::setCollection($sql, "", false, true);

		parent::setMaxCount();
	
//	print_r($sql);
	}

	private function resFrom($collection) {
		$sql .= "EVENT e ";
//		$sql .= "inner join COMPANY c on h.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_HOTERL = 1 ";


//		print_r($sql);
		return $sql;
	}


	private function resWhere($collection) {

		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}
		$DATE_S = date("Y-m-d");

		$where = "";

		$where .= "e.EVENT_STATUS = 2 ";


		//	ID
		if ($collection->getByKey($collection->getKeyValue(), "EVENT_ID") != "") {
			$ID = $collection->getByKey($collection->getKeyValue(), "EVENT_ID");
			$where .= "and e.EVENT_ID = '$ID' ";
		}
		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			$AREA_S = "%:".$collection->getByKey($collection->getKeyValue(), "area").":%";
			$where .= "and e.EVENT_AREA like '$AREA_S' ";
		}
		//	カテゴリ
		if ($collection->getByKey($collection->getKeyValue(), "category") != "") {
			$CATE_S = "%:".$collection->getByKey($collection->getKeyValue(), "category").":%";
			$where .= "and e.EVENT_CATEGORY like '$CATE_S' ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "free") != "") {
			$FREE_S = "%".$collection->getByKey($collection->getKeyValue(), "free")."%";
			$where .= "and (e.EVENT_NAME like '$FREE_S' ";
			$where .= "or e.EVENT_DETAIL like '$FREE_S') ";
		}

		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
			//	イベント公開期間
			$where .= "and ('$DATE_S' between e.EVENT_SHOW_FROM and e.EVENT_SHOW_TO) ";
			//	イベント開催日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$where .= "and e.EVENT_POST_TO >= '$DATE_S' ";
			}
			
		}
		else {
			//	指定日
			//	イベント公開期間
			$where .= "and ('$DATE_S' between e.EVENT_SHOW_FROM and e.EVENT_SHOW_TO) ";
			//	イベント開催日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$where .= "and ('$date' between e.EVENT_POST_FROM and e.EVENT_POST_TO) ";
			}
		}
		return $where;
//print $where;


	}

//公開終了分も表示
	public function selectALL($collection) {
		$sql  = "select ";
		$sql .= "e.EVENT_ID, ";
		$sql .= "e.EVENT_SHOW_FROM, ";
		$sql .= "e.EVENT_SHOW_TO, ";
		$sql .= "e.EVENT_POST_FROM, ";
		$sql .= "e.EVENT_POST_TO, ";
		$sql .= "e.EVENT_CATEGORY, ";
		$sql .= "e.EVENT_AREA, ";
		$sql .= "e.EVENT_NAME, ";
		$sql .= "e.EVENT_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "e.EVENT_PIC".$i.", ";
		}
		$sql .= "e.EVENT_PRICE, ";
		$sql .= "e.EVENT_ENTRY_HOW, ";
		$sql .= "e.EVENT_ADDRESS, ";
		$sql .= "e.EVENT_ACCESS, ";
//		$sql .= "e.EVENT_LON, ";
//		$sql .= "e.EVENT_LAT, ";
		$sql .= "e.EVENT_NOVELTY, ";
		$sql .= "e.EVENT_COMPANY, ";
		$sql .= "e.EVENT_CONTACT, ";
//		$sql .= "e.EVENT_FLG_PUBLIC, ";
		$sql .= "e.EVENT_STATUS, ";
//		$sql .= "e.EVENT_REGIST, ";
		$sql .= "e.EVENT_UPDATE ";
		$sql .= "from ".event::tableName." e ";

		$where = "";
/*
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".event::keyName, "=", $id)." ";
		}
*/

		if ($where != "") {
			$where .= "and ";
		}
	//	$where .= "'".date("Y-m-d")."' between e.EVENT_SHOW_FROM and e.EVENT_SHOW_TO ";

		//	ID
		if ($collection->getByKey($collection->getKeyValue(), "EVENT_ID") != "") {
			$ID = $collection->getByKey($collection->getKeyValue(), "EVENT_ID");
			$where .= "and e.EVENT_ID = '$ID' ";
		}

		// ステータス公開中のもののみ
		if ($where != "") {
			$where .= "and ";
		}
		$where .= "e.EVENT_STATUS = 2 ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		//イベントID順に並ぶ
//		$sql .= "order by EVENT_ID desc ";

		//イベント開催日が近い順に並ぶ
		$sql .= "order by EVENT_POST_FROM asc ";

		parent::setCollection($sql, event::keyName);
//print $sql;
	}


	public function selectSide($collection) {
		$sql  = "select ";
		$sql .= "e.EVENT_ID, ";
		$sql .= "e.EVENT_SHOW_FROM, ";
		$sql .= "e.EVENT_SHOW_TO, ";
		$sql .= "e.EVENT_POST_FROM, ";
		$sql .= "e.EVENT_POST_TO, ";
		$sql .= "e.EVENT_CATEGORY, ";
		$sql .= "e.EVENT_AREA, ";
		$sql .= "e.EVENT_NAME, ";
		$sql .= "e.EVENT_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "e.EVENT_PIC".$i.", ";
		}
		$sql .= "e.EVENT_PRICE, ";
		$sql .= "e.EVENT_ENTRY_HOW, ";
		$sql .= "e.EVENT_ADDRESS, ";
		$sql .= "e.EVENT_ACCESS, ";
//		$sql .= "e.EVENT_LON, ";
//		$sql .= "e.EVENT_LAT, ";
		$sql .= "e.EVENT_NOVELTY, ";
		$sql .= "e.EVENT_COMPANY, ";
		$sql .= "e.EVENT_CONTACT, ";
//		$sql .= "e.EVENT_FLG_PUBLIC, ";
		$sql .= "e.EVENT_STATUS, ";
//		$sql .= "e.EVENT_REGIST, ";
		$sql .= "e.EVENT_UPDATE ";
		$sql .= "from ".event::tableName." e ";

		$where = "";
/*
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".event::keyName, "=", $id)." ";
		}
*/

		if ($where != "") {
			$where .= "and ";
		}
		$where .= "'".date("Y-m-d")."' between e.EVENT_SHOW_FROM and e.EVENT_SHOW_TO ";

		//	ID
		if ($collection->getByKey($collection->getKeyValue(), "EVENT_ID") != "") {
			$ID = $collection->getByKey($collection->getKeyValue(), "EVENT_ID");
			$where .= "and e.EVENT_ID = '$ID' ";
		}

		// ステータス公開中のもののみ
		if ($where != "") {
			$where .= "and ";
		}
		$where .= "e.EVENT_STATUS = 2 ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		//イベントID順に並ぶ
//		$sql .= "order by EVENT_ID desc ";

		//イベント開催日が近い順に並ぶ
		$sql .= "order by EVENT_POST_FROM asc ";

		//TOPでは最新6件表示
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "top") {
				$sql .= "limit 6 ";
		}
		//サイドでは最新3件表示
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "side") {
				$sql .= "limit 3 ";
		}

		parent::setCollection($sql, event::keyName);
//print $sql;
	}

	public function selectListAdmin($collection) {
		$sql  = "select ";
		$sql .= "e.EVENT_ID, ";
		$sql .= "e.EVENT_SHOW_FROM, ";
		$sql .= "e.EVENT_SHOW_TO, ";
		$sql .= "e.EVENT_POST_FROM, ";
		$sql .= "e.EVENT_POST_TO, ";
		$sql .= "e.EVENT_CATEGORY, ";
		$sql .= "e.EVENT_AREA, ";
		$sql .= "e.EVENT_NAME, ";
		$sql .= "e.EVENT_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "e.EVENT_PIC".$i.", ";
		}
		$sql .= "e.EVENT_PRICE, ";
		$sql .= "e.EVENT_ENTRY_HOW, ";
		$sql .= "e.EVENT_ADDRESS, ";
		$sql .= "e.EVENT_ACCESS, ";
//		$sql .= "e.EVENT_LON, ";
//		$sql .= "e.EVENT_LAT, ";
		$sql .= "e.EVENT_NOVELTY, ";
		$sql .= "e.EVENT_COMPANY, ";
		$sql .= "e.EVENT_CONTACT, ";
		$sql .= "e.EVENT_STATUS, ";
		$sql .= "e.EVENT_REGIST, ";
		$sql .= "e.EVENT_UPDATE ";
		$sql .= "from ".event::tableName." e ";
		//$sql .= "inner join COMPANY c on e.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "EVENT_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "e.".event::keyName." = ".$collection->getByKey($collection->getKeyValue(), "EVENT_ID")." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "EVENT_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$EVENT_NAM = "%".$collection->getByKey($collection->getKeyValue(), "EVENT_NAME")."%";
			$where .= "EVENT_NAME like '$EVENT_NAM' ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "EVENT_AREA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$EVENT_AREA = "%".$collection->getByKey($collection->getKeyValue(), "EVENT_AREA")."%";
			$where .= "EVENT_AREA like '$EVENT_AREA' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "EVENT_POST_TO") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$EVENT_POST = $collection->getByKey($collection->getKeyValue(), "EVENT_POST_FROM");
			$where .= "'".$collection->getByKey($collection->getKeyValue(), "EVENT_POST_FROM")."' between EVENT_POST_FROM and EVENT_POST_TO ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by EVENT_ID desc ";

		parent::setCollection($sql, event::keyName);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "e.EVENT_ID, ";
		$sql .= "e.EVENT_SHOW_FROM, ";
		$sql .= "e.EVENT_SHOW_TO, ";
		$sql .= "e.EVENT_POST_FROM, ";
		$sql .= "e.EVENT_POST_TO, ";
		$sql .= "e.EVENT_CATEGORY, ";
		$sql .= "e.EVENT_AREA, ";
		$sql .= "e.EVENT_NAME, ";
		$sql .= "e.EVENT_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "e.EVENT_PIC".$i.", ";
		}
		$sql .= "e.EVENT_PRICE, ";
		$sql .= "e.EVENT_ENTRY_HOW, ";
		$sql .= "e.EVENT_ADDRESS, ";
		$sql .= "e.EVENT_ACCESS, ";
//		$sql .= "e.EVENT_LON, ";
//		$sql .= "e.EVENT_LAT, ";
		$sql .= "e.EVENT_NOVELTY, ";
		$sql .= "e.EVENT_COMPANY, ";
		$sql .= "e.EVENT_CONTACT, ";
//		$sql .= "e.EVENT_FLG_PUBLIC, ";
		$sql .= "e.EVENT_STATUS, ";
		$sql .= "e.EVENT_REGIST, ";
		$sql .= "e.EVENT_UPDATE ";
		$sql .= "from ".event::tableName." e ";
		//$sql .= "inner join COMPANY c on e.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "EVENT_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "e.".event::keyName." = ".$collection->getByKey($collection->getKeyValue(), "EVENT_ID")." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "EVENT_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$EVENT_NAM = "%".$collection->getByKey($collection->getKeyValue(), "EVENT_NAME")."%";
			$where .= "EVENT_NAME like '$EVENT_NAM' ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "EVENT_AREA") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$EVENT_AREA = "%".$collection->getByKey($collection->getKeyValue(), "EVENT_AREA")."%";
			$where .= "EVENT_AREA like '$EVENT_AREA' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "EVENT_POST_TO") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$EVENT_POST = $collection->getByKey($collection->getKeyValue(), "EVENT_POST_FROM");
			$where .= "'".$collection->getByKey($collection->getKeyValue(), "EVENT_POST_FROM")."' between EVENT_POST_FROM and EVENT_POST_TO ";
		}
		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTEL_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTEL_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTEL_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by EVENT_ID desc ";

		parent::setCollection($sql, event::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "e.EVENT_ID, ";
		$sql .= "e.EVENT_SHOW_FROM, ";
		$sql .= "e.EVENT_SHOW_TO, ";
		$sql .= "e.EVENT_POST_FROM, ";
		$sql .= "e.EVENT_POST_TO, ";
		$sql .= "e.EVENT_CATEGORY, ";
		$sql .= "e.EVENT_AREA, ";
		$sql .= "e.EVENT_NAME, ";
		$sql .= "e.EVENT_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "e.EVENT_PIC".$i.", ";
		}
		$sql .= "e.EVENT_PRICE, ";
		$sql .= "e.EVENT_ENTRY_HOW, ";
		$sql .= "e.EVENT_ADDRESS, ";
		$sql .= "e.EVENT_ACCESS, ";
//		$sql .= "e.EVENT_LON, ";
//		$sql .= "e.EVENT_LAT, ";
		$sql .= "e.EVENT_NOVELTY, ";
		$sql .= "e.EVENT_COMPANY, ";
		$sql .= "e.EVENT_CONTACT, ";
//		$sql .= "e.EVENT_FLG_PUBLIC, ";
		$sql .= "e.EVENT_STATUS, ";
		$sql .= "e.EVENT_REGIST, ";
		$sql .= "e.EVENT_UPDATE ";
		$sql .= "from ".event::tableName." e ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".event::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("EVENT_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}
	//	$sql .= "limit 0,6 ";

		$sql .= "order by EVENT_ID desc ";

		parent::setCollection($sql, event::keyName);
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
			$sql .= parent::expsData("HOTEL_ORDER","=",$k)." ";
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


	/*
	public function savePic($pic, $target) {

		switch ($target) {
			case "HOTEL_PIC_APP":
				break;
			case "HOTEL_PIC_FAC1":
				break;
			case "HOTEL_PIC_FAC2":
				break;
			case "HOTEL_PIC_FAC3":
				break;
			case "HOTEL_PIC_FAC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".hotel::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotel::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
	print_r($dataList);
		$sql  = "insert into ".event::tableName." (";
		$sql .= "EVENT_ID, ";
		$sql .= "EVENT_SHOW_FROM, ";
		$sql .= "EVENT_SHOW_TO, ";
		$sql .= "EVENT_POST_FROM, ";
		$sql .= "EVENT_POST_TO, ";
		$sql .= "EVENT_CATEGORY, ";
		$sql .= "EVENT_AREA, ";
		$sql .= "EVENT_NAME, ";
		$sql .= "EVENT_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "EVENT_PIC".$i.", ";
		}
		$sql .= "EVENT_PRICE, ";
		$sql .= "EVENT_ENTRY_HOW, ";
		$sql .= "EVENT_ADDRESS, ";
		$sql .= "EVENT_ACCESS, ";
//		$sql .= "EVENT_LON, ";
//		$sql .= "EVENT_LAT, ";
		$sql .= "EVENT_NOVELTY, ";
		$sql .= "EVENT_COMPANY, ";
		$sql .= "EVENT_CONTACT, ";
//		$sql .= "EVENT_FLG_PUBLIC, ";
		$sql .= "EVENT_STATUS, ";
		$sql .= "EVENT_REGIST, ";
		$sql .= "EVENT_UPDATE) values (";


 		$sql .= "null, ";
		$sql .= "'".$dataList["EVENT_SHOW_FROM"]."', ";
		$sql .= "'".$dataList["EVENT_SHOW_TO"]."', ";
		$sql .= "'".$dataList["EVENT_POST_FROM"]."', ";
		$sql .= "'".$dataList["EVENT_POST_TO"]."', ";
		$sql .= "'".$dataList["EVENT_CATEGORY"]."', ";
		$sql .= "'".$dataList["EVENT_AREA"]."', ";
		$sql .= "'".$dataList["EVENT_NAME"]."', ";
		$sql .= "'".$dataList["EVENT_DETAIL"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["EVENT_PIC".$i]."', ";
		}
		$sql .= "'".$dataList["EVENT_PRICE"]."', ";
		$sql .= "'".$dataList["EVENT_ENTRY_HOW"]."', ";
		$sql .= "'".$dataList["EVENT_ADDRESS"]."', ";
		$sql .= "'".$dataList["EVENT_ACCESS"]."', ";
//		$sql .= "'".$dataList["EVENT_LON"]."', ";
//		$sql .= "'".$dataList["EVENT_LAT"]."', ";
		$sql .= "'".$dataList["EVENT_NOVELTY"]."', ";
		$sql .= "'".$dataList["EVENT_COMPANY"]."', ";
		$sql .= "'".$dataList["EVENT_CONTACT"]."', ";
//		$sql .= "'".$dataList["EVENT_FLG_PUBLIC"]."', ";
		$sql .= "'".$dataList["EVENT_STATUS"]."', ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//	print $sql;

		return $sql;
	}

	public function update($dataList) {
//	print_r($dataList);
		$sql .= "update ".event::tableName." set ";
		$sql .= "EVENT_ID = '".$dataList["EVENT_ID"]."', ";
		$sql .= "EVENT_SHOW_FROM = '".$dataList["EVENT_SHOW_FROM"]."', ";
		$sql .= "EVENT_SHOW_TO = '".$dataList["EVENT_SHOW_TO"]."', ";
		$sql .= "EVENT_POST_FROM = '".$dataList["EVENT_POST_FROM"]."', ";
		$sql .= "EVENT_POST_TO = '".$dataList["EVENT_POST_TO"]."', ";
		$sql .= "EVENT_CATEGORY = '".$dataList["EVENT_CATEGORY"]."', ";
		$sql .= "EVENT_AREA = '".$dataList["EVENT_AREA"]."', ";
		$sql .= "EVENT_NAME = '".$dataList["EVENT_NAME"]."', ";
		$sql .= "EVENT_DETAIL = '".$dataList["EVENT_DETAIL"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "EVENT_PIC".$i." = '".$dataList["EVENT_PIC".$i]."', ";
		}
		$sql .= "EVENT_PRICE = '".$dataList["EVENT_PRICE"]."', ";
		$sql .= "EVENT_ENTRY_HOW = '".$dataList["EVENT_ENTRY_HOW"]."', ";
		$sql .= "EVENT_ADDRESS = '".$dataList["EVENT_ADDRESS"]."', ";
		$sql .= "EVENT_ACCESS = '".$dataList["EVENT_ACCESS"]."', ";
//		$sql .= "EVENT_LON = '".$dataList["EVENT_LON"]."', ";
//		$sql .= "EVENT_LAT = '".$dataList["EVENT_LAT"]."', ";
		$sql .= "EVENT_NOVELTY = '".$dataList["EVENT_NOVELTY"]."', ";
		$sql .= "EVENT_COMPANY = '".$dataList["EVENT_COMPANY"]."', ";
		$sql .= "EVENT_CONTACT = '".$dataList["EVENT_CONTACT"]."', ";
//		$sql .= "EVENT_FLG_PUBLIC = '".$dataList["EVENT_FLG_PUBLIC"]."', ";
		$sql .= "EVENT_STATUS = '".$dataList["EVENT_STATUS"]."', ";
		$sql .= "EVENT_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  event::keyName." = ".parent::getKeyValue() ;
//	print $sql;

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotel::tableName." set ";
		$sql .= parent::expsData("EVENT_STATUS", "=", 3).", ";
		$sql .= parent::expsData("EVENT_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(event::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusPublic() {
		$this->db->begin();

		$sql .= "update ".event::tableName." set ";
		$sql .= parent::expsData("EVENT_STATUS", "=", 2).", ";
		$sql .= parent::expsData("EVENT_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(event::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function statusDisabled() {
		$this->db->begin();

		$sql .= "update ".event::tableName." set ";
		$sql .= parent::expsData("EVENT_STATUS", "=", 1).", ";
		$sql .= parent::expsData("EVENT_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(event::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "EVENT_NAME"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "EVENT_NAME"), 100)) {
				parent::setError("EVENT_NAME", "100文字以内で入力して下さい");
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

		if (parent::getByKey(parent::getKeyValue(), "EVENT_PIC_APP_setup") != "") {
			$this->setByKey($this->getKeyValue(), "EVENT_PIC_APP", $this->getByKey($this->getKeyValue(), "EVENT_PIC_APP_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "EVENT_ID"));
			$msg = $inputer->upload("EVENT_PIC_APP", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("EVENT_PIC_APP", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "EVENT_PIC_APP", $msg);
			}
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "EVENT_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "EVENT_PIC".$i, $this->getByKey($this->getKeyValue(), "EVENT_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "EVENT_ID"));
//				$this->setByKey($this->getKeyValue(), "EVENT_PIC".$i, $this->getByKey($this->getKeyValue(), "EVENT_PIC".$i."_input"));
				$msg = $inputer->upload("EVENT_PIC".$i, IMG_HOTEL_FAC_SIZE, IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("EVENT_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "EVENT_PIC".$i, $msg);
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

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}
			if (count($_POST["undecide_sch"]) == "") {
				$this->setByKey($this->getKeyValue(), "search_date", date('Y年m月d日'));
				$this->setByKey($this->getKeyValue(), "undecide_sch", "1");
			}
			else {
				$this->setByKey($this->getKeyValue(), "search_date", parent::getByKey(parent::getKeyValue(), "search_date"));
				$this->setByKey($this->getKeyValue(), "undecide_sch", "2");
			}

			$dataCategory = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataCategory != "") {
						$dataCategory .= ":";
					}
					$dataCategory .= $d;
				}
				$this->setByKey($this->getKeyValue(), "EVENT_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "EVENT_CATEGORY", '');
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "EVENT_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "EVENT_AREA", '');
			}

		}

	}


}
?>