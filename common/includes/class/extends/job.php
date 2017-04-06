<?php
class job extends collection {
	const tableName = "JOB";
	const keyName = "COMPANY_ID";
	const tableKeyName = "COMPANY_ID";

	public function job($db) {
		parent::collection($db);
	}

	public function selectListPublicJob($collection)  {
		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		$sql .= "j.COMPANY_ID, ";
		$sql .= "j.JOB_PREF, ";
		$sql .= parent::decryptionList("JOBCOMPANY_NAME").", ";
		$sql .= parent::decryptionList("JOBCOMPANY_DETAIL").", ";
		$sql .= parent::decryptionList("JOBCOMPANY_CATCH").", ";
		$sql .= parent::decryptionList("JOB_ZIP").", ";
		$sql .= parent::decryptionList("JOB_CITY").", ";
		$sql .= parent::decryptionList("JOB_ADDRESS").", ";
		//	プラン
		$sql .= "jp.JOBPLAN_ID, ";
		$sql .= parent::decryptionList("JOBPLAN_SHOP_LIST").", ";
		$sql .= parent::decryptionList("JOB_SEASON_LIST").", ";
		$sql .= parent::decryptionList("JOB_EMPLOYTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_AREA_LIST").", ";
		$sql .= parent::decryptionList("JOB_COMPANYTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_KINDTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_ICON_LIST").", ";
		$sql .= "jp.JOB_SHOW_FROM, ";
		$sql .= "jp.JOB_SHOW_TO, ";
		$sql .= "jp.JOB_FLG_SEACRET, ";
		$sql .= "jp.JOB_FLG_TYPE, ";
		$sql .= "jp.JOB_FLG_COCOTOMO, ";
		$sql .= parent::decryptionList("JOB_NAME").", ";
		$sql .= parent::decryptionList("JOB_FEATURE").", ";
		$sql .= parent::decryptionList("JOB_CATCH").", ";
		$sql .= parent::decryptionList("JOB_CONTENTS").", ";
		$sql .= parent::decryptionList("JOB_MONEY, JOB_PIC2").", ";
		$sql .= parent::decryptionList("JOB_WORKTIME")." ";
/*
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::decryptionList("jp.JOB_PIC".$i).", ";
		}
*/
		$sql .= "from JOB j ";
		$sql .= "inner join JOBPLAN jp on j.COMPANY_ID = jp.COMPANY_ID and jp.JOB_STATUS = 2 ";
		$sql .= "inner join COMPANY c on j.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_JOB = 1 ";
		$sql .=" and jp.JOB_FLG_SEACRET=2 ";


		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "area") as $k => $v){
			$sql .= parent::expsData("jp.JOB_AREA_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "area")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "area"))  ){
			$sql .= "or ";
				}
			}
		}
		//	企業ID
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$sql .= "and ".parent::expsData("jp.COMPANY_ID", "=",$collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}
		//	期間
		if ($collection->getByKey($collection->getKeyValue(), "season") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "season") as $k => $v){
			$sql .= parent::expsData("jp.JOB_SEASON_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "season")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "season"))  ){
			$sql .= "or ";
				}
			}
		}
		//	雇用形態
		if ($collection->getByKey($collection->getKeyValue(), "employ") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "employ") as $k => $v){
			$sql .= parent::expsData("jp.JOB_EMPLOYTYPE_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "employ")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "employ"))  ){
			$sql .= "or ";
				}
			}
		}
		//	業種
		if ($collection->getByKey($collection->getKeyValue(), "company") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "company") as $k => $v){
			$sql .= parent::expsData("jp.JOB_COMPANYTYPE_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "company")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "company"))  ){
			$sql .= "or ";
				}
			}
		}
		//	職種
		if ($collection->getByKey($collection->getKeyValue(), "kind") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "kind") as $k => $v){
			$sql .= parent::expsData("jp.JOB_KINDTYPE_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "kind")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "kind"))  ){
			$sql .= "or ";
				}
			}
		}
		//	アイコン項目
		if ($collection->getByKey($collection->getKeyValue(), "icon") != "") {
			$sql .= "and ";
			foreach ($collection->getByKey($collection->getKeyValue(), "icon") as $k => $v){
			$sql .= parent::expsData("jp.JOB_ICON_LIST", "like", "%:".$k.":%", true, 4)." ";
				if (count($collection->getByKey($collection->getKeyValue(), "icon")) > 1 && $k != end($collection->getByKey($collection->getKeyValue(), "icon"))  ){
			$sql .= "or ";
				}
			}
		}
//		$sql .= "inner join BOOKSET b on h.COMPANY_ID = b.COMPANY_ID ";

		if ($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID") != "") {
			$sql .= "and ".parent::expsData("jp.JOBPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))." ";
		}


		$where = "";

		if ($where != "") {
			$where .= "and ";
		}
			//	掲載期間のチェック
			$where .= "".parent::expsData("jp.JOB_SHOW_FROM", "<=", date("Y-m-d"), true)." ";
			$where .= "and ".parent::expsData("jp.JOB_SHOW_TO", ">=", date("Y-m-d"), true)." ";

		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		$sql .= "group by jp.JOBPLAN_ID ";
		$sql .= "order by JOBPLAN_ID desc ";

		parent::setCollection($sql, job::keyName);


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

	public function selectSide($collection) {
		$sql  = "select ";
		$sql .= "j.COMPANY_ID, ";
		$sql .= "j.JOB_PREF, ";
		$sql .= parent::decryptionList("JOBCOMPANY_NAME").", ";
		$sql .= parent::decryptionList("JOBCOMPANY_DETAIL").", ";
		$sql .= parent::decryptionList("JOBCOMPANY_CATCH").", ";
		$sql .= parent::decryptionList("JOB_ZIP").", ";
		$sql .= parent::decryptionList("JOB_CITY").", ";
		$sql .= parent::decryptionList("JOB_ADDRESS").", ";
		//	プラン
		$sql .= "jp.JOBPLAN_ID, ";
		$sql .= parent::decryptionList("JOBPLAN_SHOP_LIST").", ";
		$sql .= parent::decryptionList("JOB_SEASON_LIST").", ";
		$sql .= parent::decryptionList("JOB_EMPLOYTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_AREA_LIST").", ";
		$sql .= parent::decryptionList("JOB_COMPANYTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_KINDTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_ICON_LIST").", ";
		$sql .= "jp.JOB_SHOW_FROM, ";
		$sql .= "jp.JOB_SHOW_TO, ";
		$sql .= "jp.JOB_FLG_SEACRET, ";
		$sql .= "jp.JOB_FLG_TYPE, ";
		$sql .= "jp.JOB_FLG_COCOTOMO, ";
		$sql .= parent::decryptionList("JOB_NAME").", ";
		$sql .= parent::decryptionList("JOB_FEATURE").", ";
		$sql .= parent::decryptionList("JOB_CATCH").", ";
		$sql .= parent::decryptionList("JOB_CONTENTS").", ";
		$sql .= parent::decryptionList("JOB_MONEY").", ";
		$sql .= parent::decryptionList("JOB_PIC2").", ";
		$sql .= parent::decryptionList("JOB_WORKTIME")." ";

		$sql .= "from JOB j ";
		$sql .= "inner join JOBPLAN jp on j.COMPANY_ID = jp.COMPANY_ID and jp.JOB_STATUS = 2 ";
		$sql .= "inner join COMPANY c on j.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_JOB = 1 ";
		$sql .=" and jp.JOB_FLG_SEACRET=2 ";

		$where = "";

		if ($where != "") {
			$where .= "and ";
		}
		$where .= "'".date("Y-m-d")."' between jp.JOB_SHOW_FROM and jp.JOB_SHOW_TO ";

		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		//プランID順に並ぶ
		$sql .= "order by JOBPLAN_ID desc ";

		//TOPでは最新6件表示
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "top") {
				$sql .= "limit 6 ";
		}
		//サイドでは最新3件表示
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "side") {
				$sql .= "limit 3 ";
		}

		parent::setCollection($sql, JOBPLAN_ID);
//print $sql;
	}

	public function selectListPublicJob1($collection)  {

		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		//	ホテル
		$sql .= "j.COMPANY_ID, ";
		$sql .= "j.JOB_PREF, ";
		$sql .= parent::decryptionList("JOBCOMPANY_NAME").", ";
//		$sql .= parent::decryptionList("JOB_PIC_APP").", ";
		$sql .= parent::decryptionList("JOBCOMPANY_DETAIL").", ";
		$sql .= parent::decryptionList("JOBCOMPANY_CATCH").", ";
		$sql .= parent::decryptionList("JOB_ZIP").", ";
		$sql .= parent::decryptionList("JOB_CITY").", ";
		$sql .= parent::decryptionList("JOB_ADDRESS").", ";
		//	プラン
		$sql .= "jp.JOBPLAN_ID, ";
		$sql .= parent::decryptionList("JOBPLAN_SHOP_LIST").", ";
		$sql .= parent::decryptionList("JOB_SEASON_LIST").", ";
		$sql .= parent::decryptionList("JOB_EMPLOYTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_AREA_LIST").", ";
		$sql .= parent::decryptionList("JOB_COMPANYTYPE_LIST").", ";
		$sql .= parent::decryptionList("JOB_KINDTYPE_LIST").", ";
		$sql .= "jp.JOB_SHOW_FROM, ";
		$sql .= "jp.JOB_SHOW_TO, ";
		$sql .= "jp.JOB_FLG_SEACRET, ";
		$sql .= "jp.JOB_FLG_COCOTOMO, ";
		$sql .= parent::decryptionList("JOB_NAME").", ";
		$sql .= parent::decryptionList("JOB_FEATURE").", ";
		$sql .= parent::decryptionList("JOB_CATCH").", ";
		$sql .= parent::decryptionList("JOB_CONTENTS").", ";
		$sql .= parent::decryptionList("JOB_PIC").", ";
		for ($i=2; $i<=3; $i++) {
			$sql .= parent::decryptionList("JOB_PIC".$i).", ";
		}
		$sql .= parent::decryptionList("JOB_PIC4")." ";

		//	事業所
//		$sql .= "s.SHOP_ID, ";
//		$sql .= parent::decryptionList("SHOP_NAME").", ";

		$sql .= $this->resFrom($collection);
		//	検索件数対象
/*
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$sql .= "and ".parent::expsData("j.COMPANY_ID", "in", "(".$collection->getByKey($collection->getKeyValue(), "targetId")).") ";
			}
		}
*/
		$where = "";
		$where = $this->resWhere($collection);

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "group by jp.JOBPLAN_ID";

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

//		$sql = "(".$sql.") union (".$linkSql.") ";
		$sql = "(".$sql.")  ";


		$sql .= "order by jp.JOB_ORDER ";
//		if ($collection->getByKey($collection->getKeyValue(), "orderdata") == "") {
//			$sql .= "order by JOB_ORDER ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 1) {
//			$sql .= "order by money_all ";
//		}
//		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 2) {
//			$sql .= "order by money_all desc ";
//		}

 		parent::setCollection($sql, job::keyName);

/*
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}

		parent::setCollection($sql, "", false, true);
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			parent::setMaxCount();
		}
*/
	//	print_r($sql);
	}


	/*
	public function selectListPlanCount($collection)  {
		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

		//	宿泊人数
		$checkNum = $this->resStayNum($collection);

		$money_1 = $this->resStay1Money($collection);


		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		//	ホテル
		$sql .= "h.COMPANY_ID, ";
		$sql .= $money_1." as money_1 ";

		$sql .= $this->resFrom($collection);

		$where = "";

		$where = $this->resWhere($collection);



		if ($where != "") {
			$sql .= "where ".$where." ";
		}

// 		$sql .= "group by h.COMPANY_ID ";
// 				$sql .= "group by hp.HOTELPLAN_ID, r.ROOM_ID ";

		$having = "";

		//	金額
		if ($collection->getByKey($collection->getKeyValue(), "budget_from") != "") {
			if ($having != "") {
				$having .= "and ";
			}
			$having .= parent::expsData("money_1", ">=", $collection->getByKey($collection->getKeyValue(), "budget_from"))." ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "budget_to") != "") {
			if ($having != "") {
				$having .= "and ";
			}
			$having .= parent::expsData("money_1", "<=", $collection->getByKey($collection->getKeyValue(), "budget_to"))." ";
		}

		if ($having != "") {
			$sql .= "having ".$having." ";
		}

		// 		$sql .= "order by h.JOB_ORDER ";
		if ($collection->getByKey($collection->getKeyValue(), "orderdata") == "") {
			$sql .= "order by h.JOB_ORDER ";
		}
		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 1) {
			$sql .= "order by ".$money_1." ";
		}
		elseif ($collection->getByKey($collection->getKeyValue(), "orderdata") == 2) {
			$sql .= "order by ".$money_1." desc ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}

		parent::setCollection($sql, "HOTELPLAN_ID");
		// 		parent::setCollection($sql, "", false, true);

		parent::setMaxCount();
	}
	*/


	public function selectListCompanyCount($collection)  {

		$sql = "select ";

		//	ホテル
		$sql .= "j.COMPANY_ID, ";
		$sql .= parent::decryptionList("JOBCOMPANY_NAME").", ";
//		$sql .= "j.JOB_ORDER ";
		//$sql .= $money_1." as money_1 ";

		$sql .= $this->resFrom($collection);

		$where = "";
		$where = $this->resWhere($collection);


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "group by j.COMPANY_ID ";
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

		$sql .= "order by JOB_ORDER ";
		// 		$sql .= "order by h.JOB_ORDER ";
//		if ($collection->getByKey($collection->getKeyValue(), "orderdata") == "") {
//			$sql .= "order by JOB_ORDER ";
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
		$sql .= "from JOB j ";
		$sql .= "inner join COMPANY c on j.COMPANY_ID = c.COMPANY_ID and c.COMPANY_STATUS = 2 and c.COMPANY_FUNC_JOB = 1 ";
//		$sql .= "and (c.COMPANY_LINK = '' or c.COMPANY_LINK is null) ";
		$sql .= "inner join JOBPLAN jp on j.COMPANY_ID = jp.COMPANY_ID and jp.JOB_STATUS = 2 ";
		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			$sql .= "and ".parent::expsData("jp.JOB_AREA_LIST", "=", $collection->getByKey($collection->getKeyValue(), "area"))." ";
		}
//		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
//			$sql .= "and ".parent::expsData("j.JOB_AREA_LIST", "like", "%:".$collection->getByKey($collection->getKeyValue(), "area").":%", true, 4)." ";
//		}
		//	企業ID
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$sql .= "and ".parent::expsData("jp.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}
		//	期間
		if ($collection->getByKey($collection->getKeyValue(), "season") != "") {
			$sql .= "and ".parent::expsData("jp.JOB_SEASON_LIST", "=", $collection->getByKey($collection->getKeyValue(), "season"))." ";
		}
		//	雇用形態
		if ($collection->getByKey($collection->getKeyValue(), "employ") != "") {
			$sql .= "and ".parent::expsData("jp.JOB_EMPLOYTYPE_LIST", "=", $collection->getByKey($collection->getKeyValue(), "employ"))." ";
		}
		//	業種
		if ($collection->getByKey($collection->getKeyValue(), "company") != "") {
			$sql .= "and ".parent::expsData("jp.JOB_COMPANYTYPE_LIST", "=", $collection->getByKey($collection->getKeyValue(), "company"))." ";
		}
		//	職種
		if ($collection->getByKey($collection->getKeyValue(), "kind") != "") {
			$sql .= "and ".parent::expsData("jp.JOB_KINDTYPE_LIST", "=", $collection->getByKey($collection->getKeyValue(), "kind"))." ";
		}
		//	こだわり項目
		if ($collection->getByKey($collection->getKeyValue(), "icon") != "") {
			$sql .= "and ".parent::expsData("jp.JOB_ICON_LIST", "=", $collection->getByKey($collection->getKeyValue(), "icon"))." ";
		}
//		$sql .= "inner join BOOKSET b on h.COMPANY_ID = b.COMPANY_ID ";

		if ($collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID") != "") {
			$sql .= "and ".parent::expsData("jp.JOBPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"))." ";
		}
		$sql .=" and jp.JOB_FLG_SEACRET=2 ";

		if ($collection->getByKey($collection->getKeyValue(), "free") != "") {
			$sql .= "and (".parent::expsData("jp.JOB_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "free")."%", true, 4)." ";
			$sql .= "or ".parent::expsData("jp.JOB_CATCH", "like", "%".$collection->getByKey($collection->getKeyValue(), "free")."%", true, 4).") ";
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
				$where .= "".parent::expsData("jp.JOB_SHOW_FROM", "<=", date("Y-m-d"), true)." ";
				//	提供部屋数
				$where .= "and ".parent::expsData("jp.JOB_SHOW_TO", ">=", date("Y-m-d"), true)." ";
			
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
		$sql .= parent::decryptionList("JOBCOMPANY_NAME, COMPANY_NAME").", ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from COMPANY c ";
		$sql .= "left join ".job::tableName." a on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".job::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "JOBCOMPANY_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("JOBCOMPANY_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "JOBCOMPANY_NAME")."%", true, 4)." ";
		}


		if ($where != "") {
			$where .= "and ";
		}
		$where .= parent::expsData("COMPANY_FUNC_JOB", "=", 1)." ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by COMPANY_ID desc ";

		parent::setCollection($sql, job::keyName);

	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "a.COMPANY_ID, JOB_STATUS, COMPANY_CONTRACT_DATE_END, ";
		$sql .= parent::decryptionList("JOBCOMPANY_NAME", "hp.JOB_AREA_LIST", "hp.JOB_SEASON_LIST", "hp.JOB_COMPANYTYPE_LIST", "hp.JOB_KINDTYPE_LIST", "hp.JOB_EMPLOYTYPE_LIST", "hp.JOB_ICON_LIST").", ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from ".job::tableName." a ";
		$sql .= "inner join COMPANY c on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".job::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "JOBCOMPANY_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("JOBCOMPANY_NAME", "like", "%".$collection->getByKey($collection->getKeyValue(), "JOBCOMPANY_NAME")."%", true, 4)." ";
		}

		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "JOB_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "JOB_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "JOB_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "JOB_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "JOB_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "JOB_STATUS3");
		}
		if ($collection->getByKey($collection->getKeyValue(), "JOB_STATUS4") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "JOB_STATUS4");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("JOB_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("JOB_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by JOB_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, job::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "COMPANY_ID, ";
/*		$sql .= "JOBCOMPANY_NAME, ";
		$sql .= "JOBCOMPANY_KANA, ";
		$sql .= "JOBCOMPANY_CATCH, ";
		$sql .= "JOBCOMPANY_INTRO, ";
		$sql .= "JOBCOMPANY_DETAIL, ";
		$sql .= "JOB_ZIP, ";
		$sql .= "JOB_PREF, ";
		$sql .= "JOB_CITY, ";
		$sql .= "JOB_ADDRESS, ";
		$sql .= "JOB_TEL, ";
		$sql .= "JOB_MAIL, ";
		$sql .= "JOB_MANAGER, ";
		$sql .= "JOBCOMPANY_DATE, ";
		$sql .= "JOB_ORNER, ";
		$sql .= "JOB_PERSON, ";
		$sql .= "JOB_FUND, ";
		$sql .= "JOB_OFFICE, ";
		$sql .= "JOB_ASSOCIATE, ";
		$sql .= "JOBCOMPANY_URL, ";
		$sql .= "JOB_PIC_APP, ";
		$sql .= "JOB_STATUS ";
*/		$sql .= "JOB_PREF, ";
		$sql .= parent::decryptionList("JOBCOMPANY_NAME, JOBCOMPANY_KANA, JOBCOMPANY_CATCH").", ";
		$sql .= parent::decryptionList("JOB_ZIP, JOB_CITY, JOB_ADDRESS, JOB_TEL,JOBCOMPANY_DETAIL, JOBCOMPANY_CATCH, JOBCOMPANY_INTRO, JOB_MAIL").", ";
		$sql .= parent::decryptionList("JOB_MANAGER, JOBCOMPANY_DATE, JOB_ORNER, JOB_PERSON, JOB_FUND, JOB_OFFICE, JOB_ASSOCIATE, JOBCOMPANY_URL").", ";
//		$sql .= "JOBCOMPANY_CATCH, JOBCOMPANY_DETAIL, ";
//		$sql .= parent::decryptionList("JOB_PARKING_MEMO, JOB_SEND_REMARKS, JOB_ACCESS_REMARKS, JOB_ACCESS_REMARKS_CAR").", ";
		$sql .= " JOB_STATUS ";
		$sql .= "from ".job::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".job::keyName, "=", $id)." ";
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

//		$sql .= "order by JOB_ORDER desc ";

		parent::setCollection($sql, job::keyName);
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

	//print_r(debug_backtrace());


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
			$sql  = "update ".job::tableName." set ";
			$sql .= parent::expsData("JOB_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= job::keyName." = ".$v." ";
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
			case "JOB_PIC_APP":
				break;
			case "JOB_PIC_FAC1":
				break;
			case "JOB_PIC_FAC2":
				break;
			case "JOB_PIC_FAC3":
				break;
			case "JOB_PIC_FAC4":
				break;
			default:
				return false;
		}

		$this->db->begin();

		$sql .= "update ".job::tableName." set ";
		$sql .= parent::expsData($target, "=", $pic, true, 1)." ";
		$sql .= "where ";
		$sql .=  parent::expsData(job::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
		$sql  = "insert into ".job::tableName." (";
		$sql .= "COMPANY_ID, ";
		$sql .= "JOBCOMPANY_NAME, ";
		$sql .= "JOBCOMPANY_KANA, ";
		$sql .= "JOBCOMPANY_CATCH, ";
		$sql .= "JOBCOMPANY_INTRO, ";
		$sql .= "JOBCOMPANY_DETAIL, ";
		$sql .= "JOB_ZIP, ";
		$sql .= "JOB_PREF, ";
		$sql .= "JOB_CITY, ";
		$sql .= "JOB_ADDRESS, ";
		$sql .= "JOB_TEL, ";
		$sql .= "JOB_MAIL, ";
		$sql .= "JOB_MANAGER, ";
		$sql .= "JOBCOMPANY_DATE, ";
		$sql .= "JOB_ORNER, ";
		$sql .= "JOB_PERSON, ";
		$sql .= "JOB_FUND, ";
		$sql .= "JOB_OFFICE, ";
		$sql .= "JOB_ASSOCIATE, ";
		$sql .= "JOBCOMPANY_URL, ";
//		$sql .= "JOB_PIC_APP, ";
		$sql .= "JOB_STATUS, ";
		$sql .= "JOB_DATE_REGIST, ";
		$sql .= "JOB_DATE_UPDATE) values (";

// 		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["JOBCOMPANY_NAME"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBCOMPANY_KANA"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBCOMPANY_CATCH"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBCOMPANY_INTRO"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOBCOMPANY_DETAIL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_ZIP"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_PREF"]).", ";
		$sql .= parent::expsVal($dataList["JOB_CITY"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_ADDRESS"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_TEL"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOB_MAIL"], true, 1).", ";
		$sql .= parent::expsVal($dataList["JOB_MANAGER"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOBCOMPANY_DATE"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOB_ORNER"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOB_PERSON"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOB_FUND"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOB_OFFICE"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOB_ASSOCIATE"], true , 1).", ";
		$sql .= parent::expsVal($dataList["JOBCOMPANY_URL"], true , 1).", ";
//		$sql .= parent::expsVal($dataList["JOB_PIC_APP"], true, 1).", ";
		$sql .= parent::expsVal(1).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
//	print_r($dataList);
		$sql .= "update ".job::tableName." set ";
		$sql .= parent::expsData("JOBCOMPANY_NAME", "=", $dataList["JOBCOMPANY_NAME"], true, 1).", ";
		$sql .= parent::expsData("JOBCOMPANY_KANA", "=", $dataList["JOBCOMPANY_KANA"], true, 1).", ";
		$sql .= parent::expsData("JOBCOMPANY_CATCH", "=", $dataList["JOBCOMPANY_CATCH"], true, 1).", ";
		$sql .= parent::expsData("JOBCOMPANY_INTRO", "=", $dataList["JOBCOMPANY_INTRO"], true, 1).", ";
		$sql .= parent::expsData("JOBCOMPANY_DETAIL", "=", $dataList["JOBCOMPANY_DETAIL"], true, 1).", ";
		$sql .= parent::expsData("JOB_ZIP", "=", $dataList["JOB_ZIP"], true, 1).", ";
		$sql .= parent::expsData("JOB_PREF", "=", $dataList["JOB_PREF"]).", ";
		$sql .= parent::expsData("JOB_CITY", "=", $dataList["JOB_CITY"], true, 1).", ";
		$sql .= parent::expsData("JOB_ADDRESS", "=", $dataList["JOB_ADDRESS"], true, 1).", ";
		$sql .= parent::expsData("JOB_TEL", "=", $dataList["JOB_TEL"], true, 1).", ";
		$sql .= parent::expsData("JOB_MAIL", "=", $dataList["JOB_MAIL"], true, 1).", ";
		$sql .= parent::expsData("JOB_MANAGER", "=", $dataList["JOB_MANAGER"], true, 1).", ";
		$sql .= parent::expsData("JOBCOMPANY_DATE", "=", $dataList["JOBCOMPANY_DATE"], true, 1).", ";
		$sql .= parent::expsData("JOB_ORNER", "=", $dataList["JOB_ORNER"], true, 1).", ";
		$sql .= parent::expsData("JOB_PERSON", "=", $dataList["JOB_PERSON"], true, 1).", ";
		$sql .= parent::expsData("JOB_FUND", "=", $dataList["JOB_FUND"], true, 1).", ";
		$sql .= parent::expsData("JOB_OFFICE", "=", $dataList["JOB_OFFICE"], true, 1).", ";
		$sql .= parent::expsData("JOB_ASSOCIATE", "=", $dataList["JOB_ASSOCIATE"], true, 1).", ";
		$sql .= parent::expsData("JOBCOMPANY_URL", "=", $dataList["JOBCOMPANY_URL"], true, 1).", ";
//		$sql .= parent::expsData("JOB_PIC_APP", "=", $dataList["JOB_PIC_APP"], true, 1).", ";
		$sql .= parent::expsData("JOB_STATUS", "=", $dataList["JOB_STATUS"]).", ";
		$sql .= parent::expsData("JOB_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(job::keyName, "=", parent::getKeyValue())." ";
//	print_r($sql);

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".job::tableName." set ";
		$sql .= parent::expsData("JOB_STATUS", "=", 3).", ";
		$sql .= parent::expsData("JOB_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(job::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_NAME"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_NAME"), 50)) {
				parent::setError("JOB_NAME", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_NAME_KANA"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_NAME_KANA"), 50)) {
				parent::setError("JOB_NAME_KANA", "50文字以内で入力して下さい");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_NAME_KANA"), CHK_PTN_KANA)) {
				parent::setError("JOB_NAME_KANA", "全角カナで入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ZIP"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ZIP"), CHK_PTN_ZIPCODE_JP)) {
				parent::setError("JOB_ZIP", "郵便番号は000-0000の形式で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_CITY"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_CITY"), 50)) {
				parent::setError("JOB_CITY", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ADDRESS"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ADDRESS"), 50)) {
				parent::setError("JOB_ADDRESS", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_TEL"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_TEL"), CHK_PTN_TEL)) {
				parent::setError("JOB_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
			}
		}
/*
		if (parent::getByKey(parent::getKeyValue(), "JOB_PIC_APP_setup") != "") {
			$this->setByKey($this->getKeyValue(), "JOB_PIC_APP", $this->getByKey($this->getKeyValue(), "JOB_PIC_APP_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("JOB_PIC_APP", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("JOB_PIC_APP", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "JOB_PIC_APP", $msg);
			}
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "JOB_PIC_FAC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "JOB_PIC_FAC".$i, $this->getByKey($this->getKeyValue(), "JOB_PIC_FAC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("JOB_PIC_FAC".$i, IMG_HOTEL_FAC_SIZE, IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("JOB_PIC_FAC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "JOB_PIC_FAC".$i, $msg);
				}

			}
		}

		for ($i=1; $i<=3; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 3)) {
					parent::setError("JOB_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=4; $i<=5; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 4)) {
					parent::setError("JOB_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 6;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 3)) {
				parent::setError("JOB_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=7; $i<=8; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 4)) {
					parent::setError("JOB_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		$i = 9;
		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
				//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 3)) {
				parent::setError("JOB_ROOM_DATA".$i, "3文字以内で入力して下さい");
			}
		}

		for ($i=10; $i<=11; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 4)) {
					parent::setError("JOB_ROOM_DATA".$i, "4文字以内で入力して下さい");
				}
			}
		}

		for ($i=12; $i<=15; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 3)) {
					parent::setError("JOB_ROOM_DATA".$i, "3文字以内で入力して下さい");
				}
			}
		}

		for ($i=30; $i<=49; $i++) {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), CHK_PTN_NUM)) {
					//parent::setError("JOB_ROOM_DATA".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_ROOM_DATA".$i), 10)) {
					parent::setError("JOB_ROOM_DATA".$i, "10文字以内で入力して下さい");
				}
			}
		}

		for ($i=1; $i<=2; $i++) {

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_NUM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_NUM".$i), CHK_PTN_NUM)) {
					parent::setError("JOB_FACILITY_NUM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_NUM".$i), 3)) {
					parent::setError("JOB_FACILITY_NUM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_FROM".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_FROM".$i), CHK_PTN_NUM)) {
					parent::setError("JOB_FACILITY_FROM".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_FROM".$i), 3)) {
					parent::setError("JOB_FACILITY_FROM".$i, "3文字以内で入力して下さい");
				}
			}

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_TO".$i))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_TO".$i), CHK_PTN_NUM)) {
					parent::setError("JOB_FACILITY_TO".$i, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "JOB_FACILITY_TO".$i), 3)) {
					parent::setError("JOB_FACILITY_TO".$i, "3文字以内で入力して下さい");
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