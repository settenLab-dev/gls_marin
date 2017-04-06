<?php
class coupon extends collection {
	const tableName = "COUPONSITE";
	const keyName = "COMPANY_ID";
	const tableKeyName = "COMPANY_ID";

	public function coupon($db) {
		parent::collection($db);
	}

	public function selectListPublicCoupon($collection)  {
		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		$sql .= "co.COMPANY_ID, ";
//		$sql .= "co.COUPON_PREF, ";
		$sql .= parent::decryptionList("COUPON_NAME").", ";
		$sql .= parent::decryptionList("COUPON_ADDRESS").", ";
		//	プラン
		$sql .= "cop.COUPONPLAN_ID, ";
		$sql .= "cop.COUPONPLAN_TYPE, ";
		$sql .= "cop.COUPONPLAN_SALE_FROM, ";
		$sql .= "cop.COUPONPLAN_SALE_TO, ";
		$sql .= "cop.COUPONPLAN_FLG_SEACRET, ";
		$sql .= "cop.COUPONPLAN_FLG_COCOTOMO, ";
		$sql .= "cop.COUPONPLAN_DEAL_SP, ";
		$sql .= "cop.COUPONPLAN_PROVIDE_FLG, ";
		$sql .= "cop.COUPONPLAN_DEALNUM_FLG, ";
		$sql .= "cop.COUPONPLAN_DEALPER_FLG, ";
		$sql .= "cop.COUPONPLAN_PROVIDE_MAX, ";
		$sql .= "cop.COUPONPLAN_PROVIDE_SELL, ";
		$sql .= "cop.COUPONPLAN_USE_FROM, ";
		$sql .= "cop.COUPONPLAN_USE_TO, ";
		$sql .= "cop.COUPONPLAN_POSITION, ";
		$sql .= "cop.COUPONPLAN_SELL_PRICE, ";
		$sql .= "cop.COUPONPLAN_DEAL_PRICE, ";
		$sql .= parent::decryptionList("COUPONPLAN_NAME").", ";
		$sql .= parent::decryptionList("COUPONPLAN_DETAIL").", ";
		$sql .= parent::decryptionList("COUPONPLAN_CATCH").", ";
		$sql .= parent::decryptionList("COUPONPLAN_SHOP_LIST").", ";
		$sql .= parent::decryptionList("COUPONPLAN_USE").", ";
		$sql .= parent::decryptionList("COUPONPLAN_RESERVE").", ";
		$sql .= parent::decryptionList("COUPONPLAN_CATEGORY_LIST").", ";
		$sql .= parent::decryptionList("COUPONPLAN_AREA_LIST").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC2").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC3").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC4")." ";
/*
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::decryptionList("jp.COUPON_PIC".$i).", ";
		}
*/
		$sql .= "from COUPONSITE co ";
		$sql .= "inner join COUPONPLAN cop on co.COMPANY_ID = cop.COMPANY_ID and cop.COUPONPLAN_STATUS = 2 ";
		$sql .= "inner join COMPANY c on co.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_COUPON = 1 ";
		$sql .=" and cop.COUPONPLAN_FLG_SEACRET=2 ";


		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "area") as $k => $v){
			$sql .= parent::expsData("cop.COUPONPLAN_AREA_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "area")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "area"))  ){
			$sql .= "or ";
				}
			}
		}

		//	企業ID
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$sql .= "and ".parent::expsData("cop.COMPANY_ID", "=",$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		//	カテゴリー
		if ($collection->getByKey($collection->getKeyValue(), "category") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "category") as $k => $v){
			$sql .= parent::expsData("cop.COUPONPLAN_CATEGORY_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "category")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "category"))  ){
			$sql .= "or ";
				}
			}
		}

//		$sql .= "inner join BOOKSET b on h.COMPANY_ID = b.COMPANY_ID ";

		if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") != "") {
			$sql .= "and ".parent::expsData("cop.COUPONPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"))." ";
		}


		$where = "";

		if ($where != "") {
			$where .= "and ";
		}
			//	掲載期間のチェック
			$where .= "".parent::expsData("cop.COUPONPLAN_SALE_FROM", "<=", date("Y-m-d"), true)." ";
			$where .= "and ".parent::expsData("cop.COUPONPLAN_SALE_TO", ">=", date("Y-m-d"), true)." ";

		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		$sql .= "group by cop.COUPONPLAN_ID ";
		$sql .= "order by cop.COUPONPLAN_ID desc ";

		parent::setCollection($sql, coupon::keyName);


		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}

		parent::setCollection($sql, "", false, true);
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			parent::setMaxCount();
		}


//print_r($sql);

	}

	public function selectListPrevCoupon($collection)  {
		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		$sql .= "co.COMPANY_ID, ";
//		$sql .= "co.COUPON_PREF, ";
		$sql .= parent::decryptionList("COUPON_NAME").", ";
		$sql .= parent::decryptionList("COUPON_ADDRESS").", ";
		//	プラン
		$sql .= "cop.COUPONPLAN_ID, ";
		$sql .= "cop.COUPONPLAN_SALE_FROM, ";
		$sql .= "cop.COUPONPLAN_SALE_TO, ";
		$sql .= "cop.COUPONPLAN_TYPE, ";
		$sql .= "cop.COUPONPLAN_FLG_SEACRET, ";
		$sql .= "cop.COUPONPLAN_FLG_COCOTOMO, ";
		$sql .= "cop.COUPONPLAN_DEAL_SP, ";
		$sql .= "cop.COUPONPLAN_PROVIDE_FLG, ";
		$sql .= "cop.COUPONPLAN_DEALNUM_FLG, ";
		$sql .= "cop.COUPONPLAN_DEALPER_FLG, ";
		$sql .= "cop.COUPONPLAN_PROVIDE_MAX, ";
		$sql .= "cop.COUPONPLAN_PROVIDE_SELL, ";
		$sql .= "cop.COUPONPLAN_USE_FROM, ";
		$sql .= "cop.COUPONPLAN_USE_TO, ";
		$sql .= "cop.COUPONPLAN_POSITION, ";
		$sql .= "cop.COUPONPLAN_SELL_PRICE, ";
		$sql .= "cop.COUPONPLAN_DEAL_PRICE, ";
		$sql .= parent::decryptionList("COUPONPLAN_NAME").", ";
		$sql .= parent::decryptionList("COUPONPLAN_DETAIL").", ";
		$sql .= parent::decryptionList("COUPONPLAN_CATCH").", ";
		$sql .= parent::decryptionList("COUPONPLAN_SHOP_LIST").", ";
		$sql .= parent::decryptionList("COUPONPLAN_USE").", ";
		$sql .= parent::decryptionList("COUPONPLAN_RESERVE").", ";
		$sql .= parent::decryptionList("COUPONPLAN_CATEGORY_LIST").", ";
		$sql .= parent::decryptionList("COUPONPLAN_AREA_LIST").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC2").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC3").", ";
		$sql .= parent::decryptionList("COUPONPLAN_PIC4")." ";
/*
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::decryptionList("jp.COUPON_PIC".$i).", ";
		}
*/
		$sql .= "from COUPONSITE co ";
		$sql .= "inner join COUPONPLAN cop on co.COMPANY_ID = cop.COMPANY_ID ";
		$sql .= "inner join COMPANY c on co.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_COUPON = 1 ";
		$sql .=" and cop.COUPONPLAN_FLG_SEACRET=2 ";


		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "area") as $k => $v){
			$sql .= parent::expsData("cop.COUPONPLAN_AREA_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "area")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "area"))  ){
			$sql .= "or ";
				}
			}
		}

		//	企業ID
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$sql .= "and ".parent::expsData("cop.COMPANY_ID", "=",$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		//	カテゴリー
		if ($collection->getByKey($collection->getKeyValue(), "category") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "category") as $k => $v){
			$sql .= parent::expsData("cop.COUPONPLAN_CATEGORY_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "category")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "category"))  ){
			$sql .= "or ";
				}
			}
		}

//		$sql .= "inner join BOOKSET b on h.COMPANY_ID = b.COMPANY_ID ";

		if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") != "") {
			$sql .= "and ".parent::expsData("cop.COUPONPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"))." ";
		}


		$where = "";

/*
		if ($where != "") {
			$where .= "and ";
		}
			//	掲載期間のチェック
			$where .= "".parent::expsData("cop.COUPONPLAN_SALE_FROM", "<=", date("Y-m-d"), true)." ";
			$where .= "and ".parent::expsData("cop.COUPONPLAN_SALE_TO", ">=", date("Y-m-d"), true)." ";
*/
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		$sql .= "group by cop.COUPONPLAN_ID ";
		$sql .= "order by cop.COUPONPLAN_ID desc ";

		parent::setCollection($sql, coupon::keyName);


		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}

		parent::setCollection($sql, "", false, true);
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			parent::setMaxCount();
		}


//print_r($sql);

	}


	public function selectListCompanyCount($collection)  {

		$sql = "select ";

		//	ホテル
		$sql .= "co.COMPANY_ID, ";
		$sql .= parent::decryptionList("COUPON_NAME").", ";
//		$sql .= "j.COUPON_ORDER ";
		//$sql .= $money_1." as money_1 ";

		$sql .= $this->resFrom($collection);

		$where = "";
		$where = $this->resWhere($collection);


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "group by co.COMPANY_ID ";
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
		$sql .= "(".$sqlcc.") as UNI ";

		$sql .= "order by COUPONPLAN_ORDER ";
		// 		$sql .= "order by h.COUPON_ORDER ";
//		if ($collection->getByKey($collection->getKeyValue(), "orderdata") == "") {
//			$sql .= "order by COUPON_ORDER ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 1) {
//			$sql .= "order by money_1 ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 2) {
//			$sql .= "order by money_1 desc ";
//		}

		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}
		parent::setCollection($sql, "COMPANY_ID");
// 		parent::setCollection($sql, "", false, true);

		parent::setMaxCount();

	}


	private function resFrom($collection) {
		$sql .= "from COUPONSITE co ";
		$sql .= "inner join COMPANY c on co.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_COUPON = 1 ";
//		$sql .= "and (c.COMPANY_LINK = '' or c.COMPANY_LINK is null) ";
		$sql .= "inner join COUPONPLAN cop on co.COMPANY_ID = cop.COMPANY_ID and cop.COUPON_STATUS = 2 ";
		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			$sql .= "and ".parent::expsData("cop.COUPONPLAN_AREA_LIST", "=", $collection->getByKey($collection->getKeyValue(), "area"))." ";
		}
//		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
//			$sql .= "and ".parent::expsData("j.COUPON_AREA_LIST", "like", "%:".$collection->getByKey($collection->getKeyValue(), "area").":%", true, 4)." ";
//		}
		//	企業ID
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$sql .= "and ".parent::expsData("cop.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}
		//	カテゴリー
		if ($collection->getByKey($collection->getKeyValue(), "category") != "") {
			$sql .= "and ".parent::expsData("cop.COUPONPLAN_CATEGORY_LIST", "=", $collection->getByKey($collection->getKeyValue(), "category"))." ";
		}
//		$sql .= "inner join BOOKSET b on h.COMPANY_ID = b.COMPANY_ID ";

		if ($collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID") != "") {
			$sql .= "and ".parent::expsData("cop.COUPONPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "COUPONPLAN_ID"))." ";
		}
		$sql .=" and jp.COUPON_FLG_SEACRET=2 ";

		if ($collection->getByKey($collection->getKeyValue(), "free") != "") {
			$sql .= "and (".parent::expsData("cop.COUPON_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "free")."%", true, 4)." ";
			$sql .= "or ".parent::expsData("cosp.COUPON_CATCH", "like", "%".$collection->getByKey($collection->getKeyValue(), "free")."%", true, 4).") ";
		}

//		print_r($sql);exit;
		return $sql;
	}




	private function resWhere($collection) {

//		$date = "";
		$where = "";

		//	販売期間
			//	プラン販売期間
			//$where .= "".parent::expsData("hp.HOTELPLAN_DATE_SALE_FROM", "<=", date("Y-m-d"), true)." ";
			//$where .= "and ".parent::expsData("hp.HOTELPLAN_DATE_SALE_TO", ">=", date("Y-m-d"), true)." ";
			//	料金設定日
				$where .= "".parent::expsData("cop.COUPONPLAN_SALE_FROM", "<=", date("Y-m-d"), true)." ";
				//	提供部屋数
				$where .= "and ".parent::expsData("cop.COUPONPLAN_SALE_TO", ">=", date("Y-m-d"), true)." ";
			
/*
		else {
			//	指定日
			if ($where != "") {
				$where .= "and ";
			}
			//	プラン販売期間
			//$where .= "".parent::expsData("hp.HOTELPLAN_DATE_SALE_FROM", "<=", $date, true)." ";
			//$where .= "and ".parent::expsData("hp.HOTELPLAN_DATE_SALE_TO", ">=", $date, true)." ";
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$where .= "".parent::expsData("hpay.HOTELPAY_DATE", "=", $date, true)." ";
				//	提供部屋数
				$where .= "and ".parent::expsData("hprov.HOTELPROVIDE_DATE", "=", $date, true)." ";
			}
		}
	
		//　予約締め切り時間チェック
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") != 1) {
			//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				if ($where != "") {
					$where .= "and ";
				}
				$where .= "date_format('".$date."','%Y%m%d') - date_format('".date("Y-m-d")."','%Y%m%d') >= hp.HOTELPLAN_ACC_DAY ";
			}
		}
*/

		return $where;

	}


	public function selectListAdmin($collection) {
		$sql  = "select ";
		$sql .= "c.COMPANY_ID, COMPANY_CONTRACT_DATE_END, ";
		$sql .= parent::decryptionList("COUPON_NAME, COMPANY_NAME").", ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from COMPANY c ";
		$sql .= "left join ".coupon::tableName." a on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".coupon::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPON_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "COUPON_NAME")."%", true, 4)." ";
		}


		if ($where != "") {
			$where .= "and ";
		}
		$where .= parent::expsData("COMPANY_FUNC_COUPON", "=", 1)." ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, coupon::keyName);

	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "a.COMPANY_ID, COUPON_STATUS, COMPANY_CONTRACT_DATE_END, ";
		$sql .= parent::decryptionList("COUPON_NAME", "cop.COUPONPLAN_AREA_LIST", "cop.COUPONPLAN_CATEGORY_LIST").", ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from ".coupon::tableName." a ";
		$sql .= "inner join COMPANY c on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".coupon::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COUPON_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "COUPON_NAME")."%", true, 4)." ";
		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "COUPON_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COUPON_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COUPON_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COUPON_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COUPON_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COUPON_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "COUPON_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "COUPON_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COUPONPLAN_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, coupon::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "COMPANY_ID, ";
		$sql .= parent::decryptionList("COUPON_NAME, COUPON_KANA").", ";
		$sql .= parent::decryptionList("COUPON_ADDRESS, COUPON_TEL, COUPON_MAIL, COUPON_ACCESS, COUPON_OPEN, COUPON_HOLYDAY, COUPON_MEMO").", ";
//		$sql .= "COUPONCOMPANY_CATCH, COUPONCOMPANY_DETAIL, ";
//		$sql .= parent::decryptionList("COUPON_PARKING_MEMO, COUPON_SEND_REMARKS, COUPON_ACCESS_REMARKS, COUPON_ACCESS_REMARKS_CAR").", ";
		$sql .= " COUPON_STATUS ";
		$sql .= "from ".coupon::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".coupon::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COUPON_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

//		$sql .= "order by COUPON_ORDER desc ";

		parent::setCollection($sql, coupon::keyName);
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
			$sql  = "update ".coupon::tableName." set ";
			$sql .= parent::expsData("COUPON_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= coupon::keyName." = ".$v." ";
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
			case "COUPON_PIC_APP":
				break;
			case "COUPON_PIC_FAC1":
				break;
			case "COUPON_PIC_FAC2":
				break;
			case "COUPON_PIC_FAC3":
				break;
			case "COUPON_PIC_FAC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".coupon::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(coupon::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
		$sql  = "insert into ".coupon::tableName." (";
		$sql .= "COMPANY_ID, ";
		$sql .= "COUPON_NAME, ";
		$sql .= "COUPON_KANA, ";
		$sql .= "COUPON_ADDRESS, ";
		$sql .= "COUPON_TEL, ";
		$sql .= "COUPON_MAIL, ";
		$sql .= "COUPON_ACCESS, ";
		$sql .= "COUPON_OPEN, ";
		$sql .= "COUPON_HOLYDAY, ";
		$sql .= "COUPON_MEMO, ";
		$sql .= "COUPON_PIC_APP, ";
		$sql .= "COUPON_STATUS, ";
		$sql .= "COUPON_DATE_REGIST, ";
		$sql .= "COUPON_DATE_UPDATE) values (";

// 		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["COUPON_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_KANA"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_TEL"], true , 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_MAIL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_ACCESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_OPEN"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_HOLYDAY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_MEMO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["COUPON_PIC_APP"], true, 1).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".coupon::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("COUPON_NAME", "=", $dataList["COUPON_NAME"], true, 1).", ";
		$sql .= parent::expsData("COUPON_KANA", "=", $dataList["COUPON_KANA"], true, 1).", ";
		$sql .= parent::expsData("COUPON_ADDRESS", "=", $dataList["COUPON_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("COUPON_TEL", "=", $dataList["COUPON_TEL"], true, 1).", ";
		$sql .= parent::expsData("COUPON_MAIL", "=", $dataList["COUPON_MAIL"], true, 1).", ";
		$sql .= parent::expsData("COUPON_ACCESS", "=", $dataList["COUPON_ACCESS"], true, 1).", ";
		$sql .= parent::expsData("COUPON_OPEN", "=", $dataList["COUPON_OPEN"], true, 1).", ";
		$sql .= parent::expsData("COUPON_HOLYDAY", "=", $dataList["COUPON_HOLYDAY"], true, 1).", ";
		$sql .= parent::expsData("COUPON_MEMO", "=", $dataList["COUPON_MEMO"], true, 1).", ";
		$sql .= parent::expsData("COUPON_PIC_APP", "=", $dataList["COUPON_PIC_APP"], true, 1).", ";
		$sql .= parent::expsData("COUPON_STATUS", "=", $dataList["COUPON_STATUS"]).", ";
		$sql .= parent::expsData("COUPON_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(coupon::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".coupon::tableName." set ";
		$sql .= parent::expsData("COUPON_STATUS", "=", 3).", ";
		$sql .= parent::expsData("COUPON_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(coupon::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_NAME"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_NAME"), 50)) {
				parent::setError("COUPON_NAME", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_KANA"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_KANA"), 50)) {
				parent::setError("COUPON_KANA", "50文字以内で入力して下さい");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_KANA"), CHK_PTN_KANA)) {
				parent::setError("COUPON_KANA", "全角カナで入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_TEL"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_TEL"), CHK_PTN_TEL)) {
				parent::setError("COUPON_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
			}
		}
/*
		if (parent::getByKey(parent::getKeyValue(), "COUPON_PIC_APP_setup") != "") {
			$this->setByKey($this->getKeyValue(), "COUPON_PIC_APP", $this->getByKey($this->getKeyValue(), "COUPON_PIC_APP_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("COUPON_PIC_APP", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("COUPON_PIC_APP", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "COUPON_PIC_APP", $msg);
			}
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "COUPON_PIC_FAC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "COUPON_PIC_FAC".$i, $this->getByKey($this->getKeyValue(), "COUPON_PIC_FAC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("COUPON_PIC_FAC".$i, IMG_HOTEL_FAC_SIZE, IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("COUPON_PIC_FAC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "COUPON_PIC_FAC".$i, $msg);
				}

			}
		}

		for ($i=1; $i<=3; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 3)) {
					parent::setError("COUPON_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=4; $i<=5; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 4)) {
					parent::setError("COUPON_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 6;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 3)) {
				parent::setError("COUPON_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=7; $i<=8; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 4)) {
					parent::setError("COUPON_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 9;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 3)) {
				parent::setError("COUPON_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=10; $i<=11; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 4)) {
					parent::setError("COUPON_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		for ($i=12; $i<=15; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 3)) {
					parent::setError("COUPON_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=30; $i<=49; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("COUPON_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_ROOM_DATA".$i), 10)) {
					parent::setError("COUPON_ROOM_DATA".$i, "10文字以内で入力して下さい");
				}
			}
		}

		for ($i=1; $i<=2; $i++) {

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_NUM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_NUM".$i), CHK_PTN_NUM)) {
					parent::setError("COUPON_FACILITY_NUM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_NUM".$i), 3)) {
					parent::setError("COUPON_FACILITY_NUM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_FROM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_FROM".$i), CHK_PTN_NUM)) {
					parent::setError("COUPON_FACILITY_FROM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_FROM".$i), 3)) {
					parent::setError("COUPON_FACILITY_FROM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_TO".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_TO".$i), CHK_PTN_NUM)) {
					parent::setError("COUPON_FACILITY_TO".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "COUPON_FACILITY_TO".$i), 3)) {
					parent::setError("COUPON_FACILITY_TO".$i, "3文字以内で入力して下さい");
				}
			}

		}
*/

	}



	public function setPost($picFLg=false) {
		if ($_POST) {

//print_r($_POST); exit;
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
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_AREA_LIST", '');
			}			

			$dataIcon = "";
			if (count($_POST["category"]) > 0) {
				foreach ($_POST["category"] as $d) {
					if ($dataIcon != "") {
						$dataIcon .= ":";
					}
					$dataIcon .= $d;
				}
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_CATEGORY_LIST", ":".$dataIcon.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "COUPONPLAN_CATEGORY_LIST", '');
			}			
			
		}

	}



}
?>