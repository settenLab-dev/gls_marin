<?php
class hotel extends collection {
	const tableName = "HOTEL";
	const keyName = "COMPANY_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotel($db) {
		parent::collection($db);
	}

	// 検索
	public function selectListPublicHotel($collection)  {


		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

		//	宿泊人数
		$checkNum = $this->resStayNum($collection);

		$sql  = "select ";
	//	$sql .= "SQL_CALC_FOUND_ROWS ";

		//	ホテル
		$sql .= "ht.COMPANY_ID, ";
		$sql .= "ct.COMPANY_LINK, ";
		$sql .= "ht.HOTEL_ORDER, ";
		$sql .= "ht.HOTEL_PREF, ";
		$sql .= "ht.HOTEL_NAME, ";
		$sql .= "ht.HOTEL_PIC_APP, ";
		$sql .= "ht.HOTEL_DETAIL, ";
		$sql .= "ht.HOTEL_CATCHCOPY, ";
		$sql .= "ht.HOTEL_LIST_AREA, ";
		$sql .= "ht.HOTEL_ZIP, ";
		$sql .= "ht.HOTEL_CITY, ";
		$sql .= "ht.HOTEL_ADDRESS, ";
		//	プラン
		$sql .= "hpt.HOTELPLAN_ID, ";
		$sql .= "hpt.HOTELPLAN_ROOM_LIST, ";
		$sql .= "hpt.HOTELPLAN_BF_FLG, ";
		$sql .= "hpt.HOTELPLAN_DN_FLG, ";
		$sql .= "hpt.HOTELPLAN_LN_FLG, ";
		$sql .= "hpt.HOTELPLAN_DATE_SALE_FROM, ";
		$sql .= "hpt.HOTELPLAN_DATE_SALE_TO, ";
		$sql .= "hpt.HOTELPLAN_DATE_POST_FROM, ";
		$sql .= "hpt.HOTELPLAN_DATE_POST_TO, ";
		$sql .= "hpt.HOTELPLAN_FLG_DAYUSE, ";
		$sql .= "hpt.HOTELPLAN_NAME, ";
		$sql .= "hpt.HOTELPLAN_FEATURE, ";
		$sql .= "hpt.HOTELPLAN_DISCOUNT, ";
		$sql .= "hpt.HOTELPLAN_CHECKIN, ";
		$sql .= "hpt.HOTELPLAN_CHECKIN_LAST, ";
		$sql .= "hpt.HOTELPLAN_CHECKOUT, ";
		$sql .= "hpt.HOTELPLAN_FOOD1, ";
		$sql .= "hpt.HOTELPLAN_FOOD2, ";
		$sql .= "hpt.HOTELPLAN_FOOD3, ";
		$sql .= "hpt.HOTELPLAN_CONTENTS, ";
		$sql .= "hpt.HOTELPLAN_PIC, ";
		for ($i=2; $i<=4; $i++) {
			$sql .= "hpt.HOTELPLAN_PIC".$i.", ";
		}
		//	料金
//		$sql .= "hpay.HOTELPAY_DATE, ";
//		$sql .= "hpay.HOTELPAY_ROOM_NUM, ";
//
//		$money_1 = $this->resStay1Money($collection);
//		print_r($money_1);exit;
//
//		$sql .= $money_1." as money_1, ";
//
//		$money_all = $this->resStayAllMoney($collection, $money_1);
//
//		if ($money_all != "") {
//			$sql .= "(".$money_all.") as money_all, ";
//		}		
		//---------------------------------------


		//	部屋
		$sql .= "rt.ROOM_ID, ";
		$sql .= "rt.ROOM_TYPE, ";
// 		$sql .= "rt.ROOM_CAPACITY_TO, ";
		$sql .= "rt.ROOM_BREADTH, ";
		$sql .= "rt.ROOM_NAME, ";
		$sql .= "rt.ROOM_FEATURE_LIST, ";
		$sql .= "rt.ROOM_FEATURE_LIST2, ";
		$sql .= "rt.ROOM_FEATURE_LIST3 ";

		$sql .= $this->resFrom($collection);
		//	検索件数対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
			//	$sql .= "and ".parent::expsData("h.COMPANY_ID", "in", "(".$collection->getByKey($collection->getKeyValue(), "targetId")).") ";
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and ht.COMPANY_ID in ($CID) ";
			}
		}

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
			$sql .= "group by hpt.HOTELPLAN_ID, rt.ROOM_ID ";
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

		//==========================================================================

//		print $sql;
		$sql = "(".$sql.") ";

		$sql .= "order by HOTEL_ORDER ";
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

	public function selectListPublicHotel2($collection)  {

		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

		//	宿泊人数
		$checkNum = $this->resStayNum($collection);

		$sql  = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS ";

		//	ホテル
		$sql .= "h.COMPANY_ID, ";
		$sql .= "c.COMPANY_LINK, ";
		$sql .= "h.HOTEL_ORDER, h.HOTEL_PREF, ";
		$sql .= parent::decryptionList("HOTEL_NAME").", ";
		$sql .= parent::decryptionList("HOTEL_PIC_APP").", ";
		$sql .= parent::decryptionList("HOTEL_DETAIL").", ";
		$sql .= parent::decryptionList("HOTEL_CATCHCOPY").", ";
		$sql .= parent::decryptionList("HOTEL_LIST_AREA").", ";
		$sql .= parent::decryptionList("HOTEL_ZIP").", ";
		$sql .= parent::decryptionList("HOTEL_CITY").", ";
		$sql .= parent::decryptionList("HOTEL_ADDRESS").", ";
		//	プラン
		$sql .= "hp.HOTELPLAN_ID, ";
		$sql .= "hp.HOTELPLAN_ROOM_LIST, ";
		$sql .= "hp.HOTELPLAN_BF_FLG, ";
		$sql .= "hp.HOTELPLAN_DN_FLG, ";
		$sql .= "hp.HOTELPLAN_LN_FLG, ";
		$sql .= "hp.HOTELPLAN_DATE_SALE_FROM, ";
		$sql .= "hp.HOTELPLAN_DATE_SALE_TO, ";
		$sql .= "hp.HOTELPLAN_DATE_POST_FROM, ";
		$sql .= "hp.HOTELPLAN_DATE_POST_TO, ";
		$sql .= "hp.HOTELPLAN_FLG_DAYUSE, ";
		$sql .= parent::decryptionList("HOTELPLAN_NAME").", ";
		$sql .= parent::decryptionList("HOTELPLAN_FEATURE").", ";
		$sql .= parent::decryptionList("HOTELPLAN_DISCOUNT").", ";
		$sql .= parent::decryptionList("HOTELPLAN_CHECKIN").", ";
		$sql .= parent::decryptionList("HOTELPLAN_CHECKIN_LAST").", ";
		$sql .= parent::decryptionList("HOTELPLAN_CHECKOUT").", ";
		$sql .= parent::decryptionList("HOTELPLAN_FOOD1").", ";
		$sql .= parent::decryptionList("HOTELPLAN_FOOD2").", ";
		$sql .= parent::decryptionList("HOTELPLAN_FOOD3").", ";
		$sql .= parent::decryptionList("HOTELPLAN_CONTENTS").", ";
		$sql .= parent::decryptionList("HOTELPLAN_PIC").", ";
		for ($i=2; $i<=4; $i++) {
			$sql .= parent::decryptionList("HOTELPLAN_PIC".$i).", ";
		}
		//	料金
//		$sql .= "hpay.HOTELPAY_DATE, ";
//		$sql .= "hpay.HOTELPAY_ROOM_NUM, ";
//
//		$money_1 = $this->resStay1Money($collection);
//		print_r($money_1);exit;
//
//		$sql .= $money_1." as money_1, ";
//
//		$money_all = $this->resStayAllMoney($collection, $money_1);
//
//		if ($money_all != "") {
//			$sql .= "(".$money_all.") as money_all, ";
//		}		
		//---------------------------------------


		//	部屋
		$sql .= "r.ROOM_ID, ";
		$sql .= "r.ROOM_TYPE, ";
// 		$sql .= "r.ROOM_CAPACITY_TO, ";
		$sql .= "r.ROOM_BREADTH, ";
		$sql .= parent::decryptionList("ROOM_NAME").", ";
		$sql .= parent::decryptionList("ROOM_FEATURE_LIST").", ";
		$sql .= parent::decryptionList("ROOM_FEATURE_LIST2").", ";
		$sql .= parent::decryptionList("ROOM_FEATURE_LIST3")." ";

		$sql .= $this->resFrom($collection);
		//	検索件数対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$sql .= "and ".parent::expsData("h.COMPANY_ID", "in", "(".$collection->getByKey($collection->getKeyValue(), "targetId")).") ";
			}
		}

		$where = "";
		$where = $this->resWhere($collection);

//		print $where;


		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		$sql .= "group by hp.HOTELPLAN_ID, r.ROOM_ID ";

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





		//==========================================================================

		$sql = "(".$sql.")  ";


		$sql .= "order by HOTEL_ORDER ";
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


		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}
		parent::setCollection($sql, "", false, true);
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			parent::setMaxCount();
		}
//		print_r($sql);

	}

	//	宿泊大人人数の最大人数
	private function resStayNum($collection) {
		//	宿泊人数
		$checkNum = 0;
		if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				//	大人数
				if($checkNum <= intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))){
					$checkNum = intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
				}
			}
		}

		if($checkNum == 0){
			$checkNum=2;
		}

		return $checkNum;
	}
	
	//	各部屋の人数
	private function resEveryRoomStayNum($collection) {
		if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
			$checkNum = 0;
//			print_r($collection);
			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				//	大人数
				if($checkNum <= intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))){
					$checkNum = intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
				}
//				小学生(低学年)
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"));
//				小学生(高学年)
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"));
//				幼児:食事・布団あり
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3"));
//				幼児:布団あり
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5"));
				
				if($checkNum == 0){
					$checkNum=2;
				}
				
				$stayNum[$roomNum]=$checkNum;
//				print $roomNum.":".$checkNum."     ";
			}
		}
		return $stayNum;
	}
	

	// 検索件数のカウント&IDの取得
	public function selectListCompanyCount($collection)  {

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


		$sql = "select ";

		//	ホテル
		$sql .= "ht.COMPANY_ID, ";
		$sql .= "ct.COMPANY_LINK, ";
		$sql .= "ht.HOTEL_NAME, ";
		$sql .= "ht.HOTEL_ORDER ";
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

		$sql .= "group by ht.COMPANY_ID ";
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





		//=======================================================

		$sqlcc = $sql;

		$sql = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS * from ";
		$sql .= "(".$sqlcc.") as UNI ";



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

		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			if ($collection->getByKey($collection->getKeyValue(), "limit") != "") {
				$sql .= "limit ".$collection->getByKey($collection->getKeyValue(), "limit")." ";
			}
		}

// 		print_r($sql);
		parent::setCollection($sql, "COMPANY_ID");
// 		parent::setCollection($sql, "", false, true);

		parent::setMaxCount();
	
//	print_r($sql);
	}


	// 検索対象のテーブル
	private function resFrom($collection) {

		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}
		$checkNum = $this->resStayNum($collection);
		$DATE_S = date("Y-m-d");

		//	▼ホテル情報テーブル
		$sql .= "from (select ";
		$sql .= "h.COMPANY_ID, ";
		$sql .= "h.HOTEL_ORDER, ";
		$sql .= "h.HOTEL_PREF, ";
		$sql .= "h.HOTEL_NAME, ";
		$sql .= "h.HOTEL_PIC_APP, ";
		$sql .= "h.HOTEL_DETAIL, ";
		$sql .= "h.HOTEL_CATCHCOPY, ";
		$sql .= "h.HOTEL_LIST_AREA, ";
		$sql .= "h.HOTEL_ZIP, ";
		$sql .= "h.HOTEL_CITY, ";
 		$sql .= "h.HOTEL_ADDRESS ";

		$sql .= "from HOTEL h ";
//		$sql .= "where ";
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "where h.COMPANY_ID in ($CID) ";
 			}
 		}

		//	エリア
		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			if ($CID != ""){
			  $sql .= "and ";
			}
			else {
			  $sql .= "where ";
			}
			$AREA_S = "%:".$collection->getByKey($collection->getKeyValue(), "area").":%";
			$sql .= "h.HOTEL_LIST_AREA like '$AREA_S' ";
		}
		//	ホテルID
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$COMPANY_S = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$sql .= "where h.COMPANY_ID = '$COMPANY_S' ";
			$where_flg_company = true;
		}
		//	宿種
		if ($collection->getByKey($collection->getKeyValue(), "kind") != "") {
			$KIND_S = $collection->getByKey($collection->getKeyValue(), "kind");
			$sql .= "and h.HOTEL_FLG_KIND = '$KIND_S' ";
		}
		//	キーワード検索
		if ($collection->getByKey($collection->getKeyValue(), "free") != "") {
			if ($AREA_S != ""){
			  $sql .= "and ";
			}
			elseif ($COMPANY_S != "") {
			  $sql .= "and ";
			}
			elseif ($CID != "") {
			  $sql .= "and ";
			}
			else {
			  $sql .= "where ";
			}

			$FREE_S = "%".$collection->getByKey($collection->getKeyValue(), "free")."%";
			$sql .= "(h.HOTEL_NAME like '$FREE_S' ";
			$sql .= "or h.HOTEL_CATCHCOPY like '$FREE_S') ";
		}

		$sql .= ") ht ";


		//	▼クライアント情報テーブル
		$sql .= "inner join (select ";
		$sql .= "c.COMPANY_ID, ";
		$sql .= "c.COMPANY_LINK ";
		$sql .= "from COMPANY c ";
		$sql .= "where ";
		$sql .= "c.COMPANY_STATUS = 2 ";
		$sql .= "and c.COMPANY_FUNC_HOTERL = 1 ";
		$sql .= "and (c.COMPANY_LINK = '' or c.COMPANY_LINK is null) ";
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and c.COMPANY_ID in ($CID) ";
 			}
 		}
		$sql .= ") ct ";
		$sql .= "on ht.COMPANY_ID = ct.COMPANY_ID ";


		//	予約設定テーブル
		$sql .= "inner join (select * ";
		$sql .= "from BOOKSET b ";
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "where b.COMPANY_ID in ($CID) ";
 			}
 		}
		$sql .= ") bt ";
		$sql .= "on ht.COMPANY_ID = bt.COMPANY_ID ";
 

		//	▼プラン情報テーブル
		$sql .= "inner join (select ";
		$sql .= "hp.COMPANY_ID, ";
		$sql .= "hp.HOTELPLAN_ID, ";
		$sql .= "hp.HOTELPLAN_ROOM_LIST, ";
		$sql .= "hp.HOTELPLAN_BF_FLG, ";
		$sql .= "hp.HOTELPLAN_DN_FLG, ";
		$sql .= "hp.HOTELPLAN_LN_FLG, ";
		$sql .= "hp.HOTELPLAN_DATE_SALE_FROM, ";
		$sql .= "hp.HOTELPLAN_DATE_SALE_TO, ";
		$sql .= "hp.HOTELPLAN_DATE_POST_FROM, ";
		$sql .= "hp.HOTELPLAN_DATE_POST_TO, ";
		$sql .= "hp.HOTELPLAN_FLG_DAYUSE, ";
		$sql .= "hp.HOTELPLAN_NAME, ";
		$sql .= "hp.HOTELPLAN_FEATURE, ";
		$sql .= "hp.HOTELPLAN_DISCOUNT, ";
		$sql .= "hp.HOTELPLAN_CHECKIN, ";
		$sql .= "hp.HOTELPLAN_CHECKIN_LAST, ";
		$sql .= "hp.HOTELPLAN_CHECKOUT, ";
		$sql .= "hp.HOTELPLAN_FOOD1, ";
		$sql .= "hp.HOTELPLAN_FOOD2, ";
		$sql .= "hp.HOTELPLAN_FOOD3, ";
		$sql .= "hp.HOTELPLAN_CONTENTS, ";
		$sql .= "hp.HOTELPLAN_RECOMM_URL, ";
		$sql .= "hp.HOTELPLAN_PIC, ";
		for ($i=2; $i<=3; $i++) {
			$sql .= "hp.HOTELPLAN_PIC".$i.", ";
		}
		$sql .= "hp.HOTELPLAN_PIC4 ";
		$sql .= "from HOTELPLAN hp ";
		$sql .= "where ";
		$sql .= "hp.HOTELPLAN_STATUS = 2 ";
		$sql .= "and hp.HOTELPLAN_FLG_SEACRET=2 ";
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			$PLAN_S = $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
			$sql .= "and hp.HOTELPLAN_ID = '$PLAN_S' ";
		}

		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and hp.COMPANY_ID in ($CID) ";
 			}
 		}
		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
		//	プラン販売期間
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and '$DATE_S' between hp.HOTELPLAN_DATE_POST_FROM and hp.HOTELPLAN_DATE_POST_TO ";
			}
			
		}
		else {
			//	指定日
			//	プラン販売期間
//			$sql .= "".parent::expsData("hp.HOTELPLAN_DATE_SALE_FROM", "<=", $date, true)." ";
//			$sql .= "and ".parent::expsData("hp.HOTELPLAN_DATE_SALE_TO", ">=", $date, true)." ";
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and '$DATE_S' between hp.HOTELPLAN_DATE_POST_FROM and hp.HOTELPLAN_DATE_POST_TO ";
			}
		}

		//　予約締め切り時間チェック
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") != 1) {
			//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and DATEDIFF('".$date."','".date("Y-m-d")."') >= hp.HOTELPLAN_ACC_DAY ";

			/*--2015-10-08追加（牛腸）--*/
				if($date == date("Y-m-d")){

				//現在時刻を6～29時形式に変換

					$time_hour = date('H');
					$time_min = date('i');

				        if($time_hour == 00) {
					   $time_hour = 24;
					}
				        if($time_hour == 01) {
					   $time_hour = 25;
					}
				        if($time_hour == 02) {
					   $time_hour = 26;
					}
				        if($time_hour == 03) {
					   $time_hour = 27;
					}
				        if($time_hour == 04) {
					   $time_hour = 28;
					}
				        if($time_hour == 05) {
					   $time_hour = 29;
					}

				//締切時間の変換と比較
					$sql .= "and concat(case when hp.HOTELPLAN_ACC_HOUR = '16' then '6' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '17' then '7' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '18' then '8' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '19' then '9' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '20' then '10' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '21' then '11' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '22' then '12' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '23' then '13' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '24' then '14' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '1' then '15' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '2' then '16' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '3' then '17' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '4' then '18' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '5' then '19' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '6' then '20' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '7' then '21' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '8' then '22' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '9' then '23' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '10' then '24' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '11' then '25' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '12' then '26' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '13' then '27' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '14' then '28' ";
					$sql .= "when hp.HOTELPLAN_ACC_HOUR = '15' then '29' ";
					$sql .= "else '' end , ";

					$sql .= "case when hp.HOTELPLAN_ACC_MIN = '1' then '00' ";
					$sql .= "when hp.HOTELPLAN_ACC_MIN = '2' then '15' ";
					$sql .= "when hp.HOTELPLAN_ACC_MIN = '3' then '30' ";
					$sql .= "when hp.HOTELPLAN_ACC_MIN = '4' then '45' ";
					$sql .= "else '' end)";

					$sql .= " >= ".$time_hour.$time_min." ";

				}
			/*--2015-10-08追加（牛腸）--*/

				//$sql .= "and date_format('".$date."','%Y%m%d') - date_format('".date("Y-m-d")."','%Y%m%d') >= hp.HOTELPLAN_ACC_DAY ";
			}
		//print $sql;
		}
		//	プラン：最短連泊数
		if ($collection->getByKey($collection->getKeyValue(), "night_number") != "") {
			$NIGHT_NUM = $collection->getByKey($collection->getKeyValue(), "night_number");
			$sql .= "and (hp.HOTELPLAN_NIGHTS_FLG1 = 1 or (hp.HOTELPLAN_NIGHTS_FLG1 = 2 and hp.HOTELPLAN_NIGHTS_NUM1 <= '$NIGHT_NUM')) ";
		}
		//	プラン：最長連泊数
		if ($collection->getByKey($collection->getKeyValue(), "night_number") != "") {
			$NIGHT_NUM = $collection->getByKey($collection->getKeyValue(), "night_number");
			$sql .= "and (hp.HOTELPLAN_NIGHTS_FLG2 = 1 or (hp.HOTELPLAN_NIGHTS_FLG2 = 2 and hp.HOTELPLAN_NIGHTS_NUM2 >= '$NIGHT_NUM')) ";
		}

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
			$sql .= "and hpt.HOTELPLAN_RECOMM_URL = '$RECOMMEND_S' ";
		}
		//==================================================================================


		$sql .= ") hpt ";
		$sql .= "on ct.COMPANY_ID = hpt.COMPANY_ID ";



		//	▼料金テーブル
		$sql .= "inner join (select * ";
		$sql .= "from HOTELPAY hpay  ";
		$sql .= "where ";

		$stayNumEveryRoom = $this->selectNumEveryRoom($collection);
		for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
			$sql .= "hpay.HOTELPAY_MONEY".$stayNumEveryRoom[$roomNum]." <> 'x' ";
			$sql .= "and hpay.HOTELPAY_MONEY".$stayNumEveryRoom[$roomNum]." <> '' ";
			$sql .= "and hpay.HOTELPAY_MONEY".$stayNumEveryRoom[$roomNum]." is not null ";
		}
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and hpay.COMPANY_ID in ($CID) ";
 			}
 		}
		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and hpay.HOTELPAY_DATE >= '$DATE_S'";
			}
			
		}
		else {
			//	指定日
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and hpay.HOTELPAY_DATE = '$date' ";
			}
		}

		//	子供の受入のチェック
		//------------------------------
		if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {
				//	小学生(低学年)
				$childnum1 += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"));
				//	小学生(高学年)
				$childnum2 += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"));
				//	幼児 食事布団あり
				$childnum3 += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3"));
				//	幼児 食事あり
				$childnum4 += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4"));
				//	幼児 布団あり
				$childnum5 += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5"));
				//	幼児 なし
				$childnum6 += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6"));
			}
		}

		if ($childnum1 > 0) {
			$sql .= "and hpay.HOTELPAY_PS_DATA1 = '1' ";
		}
		//	小学生(高学年)受入
		if ($childnum2 > 0) {
			$sql .= "and hpay.HOTELPAY_PS_DATA12 = '1' ";
		}
		//	幼児：食事・布団あり 受入
		if ($childnum3 > 0) {
			$sql .= "and hpay.HOTELPAY_BB_DATA1 = '1' ";
		}
		//	幼児：食事 受入
		if ($childnum4 > 0) {
			$sql .= "and hpay.HOTELPAY_BB_DATA5 = '1' ";
		}
		//	幼児：布団あり 受入
		if ($childnum5 > 0) {
			$sql .= "and hpay.HOTELPAY_BB_DATA8 = '1' ";
		}
		//	幼児：食事・布団なし 受入
		if ($childnum6 > 0) {
			$sql .= "and hpay.HOTELPAY_BB_DATA12 = '1' ";
		}
		//------------------------------

		$sql .= ") hpayt ";
		$sql .= "on ht.COMPANY_ID = hpayt.COMPANY_ID ";
		$sql .= "and hpt.HOTELPLAN_ID = hpayt.HOTELPLAN_ID ";
  


 		//	▼在庫テーブル
		$sql .= "inner join (select * ";
		$sql .= "from HOTELPROVIDE hprov ";
		$sql .= "where ";
		$sql .= "hprov.HOTELPROVIDE_FLG_STOP = 1 ";
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and hprov.COMPANY_ID in ($CID) ";
 			}
 		}

		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "room_number");
				$sql .= "and hprov.HOTELPROVIDE_DATE >= '$DATE_S' ";
				$sql .= "and EXISTS (select * from HOTELPROVIDE hprov2 where hprov2.HOTELPROVIDE_NUM >= '$ROOM_NUM' and hprov.HOTELPROVIDE_DATE >= '$DATE_S') ";
			}
			
		}
		else {
			//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "room_number");
				$sql .= "and hprov.HOTELPROVIDE_DATE = '$date' ";
				$sql .= "and hprov.HOTELPROVIDE_NUM >= '$ROOM_NUM' ";
			}
		}

		//	宿泊部屋数
// 		if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("hprov.HOTELPROVIDE_NUM", ">=", $collection->getByKey($collection->getKeyValue(), "room_number"))." ";
// 		}

		//	宿泊数
		if ($collection->getByKey($collection->getKeyValue(), "night_number") >= 1) {
			//	1泊
			//	部屋数
			if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
				if ($where != "") {
					$where .= "and ";
				}
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "room_number");
				$where .= "(hprov.HOTELPROVIDE_NUM-hprov.HOTELPROVIDE_BOOKEDNUM) >= '$ROOM_NUM' ";
			}
		}
		$sql .= ") hprovt ";
		$sql .= "on ht.COMPANY_ID = hprovt.COMPANY_ID ";
		$sql .= "and hpayt.HOTELPAY_DATE = hprovt.HOTELPROVIDE_DATE ";



		//	▼部屋テーブル
 		$sql .= "inner join (select ";
 		$sql .= "r.COMPANY_ID, ";
 		$sql .= "r.ROOM_ID, ";
 		$sql .= "r.ROOM_TYPE, ";
 		$sql .= "r.ROOM_BREADTH, ";
 		$sql .= "r.ROOM_NAME, ";
 		$sql .= "r.ROOM_FEATURE_LIST, ";
 		$sql .= "r.ROOM_FEATURE_LIST2, ";
 		$sql .= "r.ROOM_FEATURE_LIST3, ";
 		$sql .= "r.ROOM_CAPACITY_FROM, ";
 		$sql .= "r.ROOM_CAPACITY_TO ";
 		$sql .= "from ROOM r ";
 		$sql .= "where ";
		//	宿泊人数
		$child_num = $childnum1+$childnum2+$childnum3+$childnum4+$childnum5+$childnum6;
		if ($checkNum > 0) {
			//	部屋に泊まれる人数
			$CAPACITY = $checkNum+$child_num;
			$sql .= "r.ROOM_CAPACITY_FROM <= '$CAPACITY' ";
			$sql .= "and r.ROOM_CAPACITY_TO >= '$CAPACITY' ";
		}
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and r.COMPANY_ID in ($CID) ";
 			}
 		}
		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			$ROOM_S = $collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$sql .= "and r.ROOM_ID = '$ROOM_S' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "room_type") != "") {
			$ROOMTYPE_S = $collection->getByKey($collection->getKeyValue(), "room_type");
			$sql .= "and r.ROOM_TYPE = '$ROOMTYPE_S' ";
		}


 		$sql .= ") rt ";
 		$sql .= "on ht.COMPANY_ID = rt.COMPANY_ID ";
 		$sql .= "and rt.ROOM_ID = hpayt.ROOM_ID ";
 		$sql .= " and rt.ROOM_ID = hprovt.ROOM_ID ";

/*
		//	連泊時の料金・在庫条件追加
		for ($i=2; $i<=SITE_STAY_NUM; $i++) {
			if ($collection->getByKey($collection->getKeyValue(), "night_number") >= $i) {
				//	提供部屋数
				$sql .= "and exists (";
				$sql .= "select ";
				$sql .= "HOTELPROVIDE_ID ";
				$sql .= "from HOTELPROVIDE ";
				$sql .= "where ";
				$sql .= "HOTELPROVIDE_DATE = date_add(hprovt.HOTELPROVIDE_DATE, interval ".($i-1)." day) ";
				$sql .= "and ROOM_ID = hprovt.ROOM_ID ";
				$sql .= "and COMPANY_ID = ht.COMPANY_ID ";
				$sql .= "and HOTELPROVIDE_FLG_STOP = 1 ";
				// 部屋数
				if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
					$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "room_number");
					$sql .= "and HOTELPROVIDE_NUM >= '$ROOM_NUM' ";
				}
				$sql .= ") ";
				//	料金設定
				$sql .= "and exists (";
				$sql .= "select ";
				$sql .= "HOTELPAY_ID ";
				$sql .= "from HOTELPAY ";
				$sql .= "where ";
				$sql .= "HOTELPAY_DATE = date_add(hpayt.HOTELPAY_DATE, interval ".($i-1)." day) ";
				$sql .= "and ROOM_ID = hprovt.ROOM_ID ";
				$sql .= "and COMPANY_ID = ht.COMPANY_ID ";
				$sql .= "and HOTELPLAN_ID = hpt.HOTELPLAN_ID ";
				$sql .= ") ";
			}
		}
*/
		$sql .= "and hpt.HOTELPLAN_ROOM_LIST like concat('%:', rt.ROOM_ID, ':%') ";





		//==================================================================================
		//	ホテルのこだわり
		if ($collection->getByKey($collection->getKeyValue(), "hKodawari0") != "") {
			//	]高級フラグの立っている施設検索
		}
		if ($collection->getByKey($collection->getKeyValue(), "hKodawari1") != "") {
			//	海が見えるリゾートホテル
			$sql .= "and rt.ROOM_FEATURE_LIST3 like '%:5:%' ";
			$sql .= "and ht.HOTEL_FLG_KIND = 1 ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "hKodawari2") != "") {
			//	夜景がきれいなビジネス・シティ
			$sql .= "and rt.ROOM_FEATURE_LIST3 like '%:6:%' ";
			$sql .= "and ht.HOTEL_FLG_KIND = 3 ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "hKodawari3") != "") {
			//	のんびり過ごせる小さなお宿
			$sql .= "and ht.HOTEL_FLG_KIND = 4 ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "hKodawari4") != "") {
			//	気楽に泊まれる貸し切りコテージ
		}
		if ($collection->getByKey($collection->getKeyValue(), "hKodawari5") != "") {
			//	ペットと一緒に泊まれるお宿
			$sql .= "and rt.ROOM_PET_FLG = 1 ";
		}

		//	施設にこだわり
		if ($collection->getByKey($collection->getKeyValue(), "cKodawari0") != "") {
			//	ホテルのプールで思いっきり遊ぶ
			$sql .= "and (ht.HOTEL_FACILITY_LIST8 like '%:1:%' ";
			$sql .= "or ht.HOTEL_FACILITY_LIST8 like '%:2:%' ";
			$sql .= "or ht.HOTEL_FACILITY_LIST8 like '%:3:%' ";
			$sql .= "or ht.HOTEL_FACILITY_LIST8 like '%:4:%') ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "cKodawari1") != "") {
			//	大浴場・スパでゆったりリラックス
			$sql .= "and (ht.HOTEL_FACILITY_LIST4 like '%:1:%' ";
			$sql .= "or ht.HOTEL_FACILITY_LIST4 like '%:3:%' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "cKodawari2") != "") {
			//	みんなでワイワイBBQを楽しむ
			$sql .= "and (ht.HOTEL_FACILITY_LIST1 like '%:8:%' ";
			$sql .= "or ht.HOTEL_FACILITY_LIST1 like '%:9:%') ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "cKodawari3") != "") {
			//	小さなお子様も安心の和室・和洋室
			$sql .= "and (rt.ROOM_TYPE= '8' ";
			$sql .= "or rt.ROOM_TYPE = '9') ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "cKodawari4") != "") {
			//	禁煙ルームで快適ステイ
			$sql .= "and rt.ROOM_FEATURE_LIST3 like '%:1:%' ";
		}
		if ($collection->getByKey($collection->getKeyValue(), "cKodawari5") != "") {
			//	みんなに優しいバリアフリー
			$sql .= "and (ht.HOTEL_DISABLED like '%:1:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:2:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:3:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:4:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:5:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:6:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:7:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:8:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:9:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:10:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:11:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:12:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:13:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:14:%' ";
			$sql .= "or ht.HOTEL_DISABLED like '%:15:%') ";
		}
		//==================================================================================

		return $sql;

	}


	// 検索条件
	private function resWhere($collection) {

		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}
		$checkNum = $this->resStayNum($collection);
		$DATE_S = date("Y-m-d");

		$where = "";

		//	連泊時の料金・在庫条件追加
		for ($i=2; $i<=SITE_STAY_NUM; $i++) {
			if ($collection->getByKey($collection->getKeyValue(), "night_number") >= $i) {
				//	提供部屋数
				if ($where != "") {
					$where .= "and ";
				}
				$where .= "exists (";
				$where .= "select ";
				$where .= "HOTELPROVIDE_ID ";
				$where .= "from HOTELPROVIDE ";
				$where .= "where ";
				$where .= "HOTELPROVIDE_DATE = date_add(hprovt.HOTELPROVIDE_DATE, interval ".($i-1)." day) ";
				$where .= "and ROOM_ID = hprovt.ROOM_ID ";
				$where .= "and COMPANY_ID = ht.COMPANY_ID ";
				$where .= "and HOTELPROVIDE_FLG_STOP = 1 ";
				// 部屋数
				if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
					$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "room_number");
					$where .= "and HOTELPROVIDE_NUM >= '$ROOM_NUM' ";
				}
				$where .= ") ";
				//	料金設定
				if ($where != "") {
					$where .= "and ";
				}
				$where .= "exists (";
				$where .= "select ";
				$where .= "HOTELPAY_ID ";
				$where .= "from HOTELPAY ";
				$where .= "where ";
				$where .= "HOTELPAY_DATE = date_add(hpayt.HOTELPAY_DATE, interval ".($i-1)." day) ";
				$where .= "and ROOM_ID = hprovt.ROOM_ID ";
				$where .= "and COMPANY_ID = ht.COMPANY_ID ";
				$where .= "and HOTELPLAN_ID = hpt.HOTELPLAN_ID ";
				$where .= ") ";
			}
		}

		return $where;

	}



	private function resStayAllMoney($collection, $money_1) {
		//	合計金額
		//---------------------------------------
		$money_all = "";
		if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
			for ($roomNum=1; $roomNum<=1; $roomNum++) {
				// 			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {

				//	大人数
				$alultnum = intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
				if ($alultnum > 0) {
					if ($money_all != "") $money_all .= " + ";
					$money_all .= "(".$money_1." * ".$alultnum.") ";
				}
				//	小学生(低学年)
				$childnum1 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"));
				if ($childnum1 > 0) {
					if ($money_all != "") $money_all .= " + ";
					$money_all .= "((case when hpay.HOTELPAY_PS_DATA2=1 then ";
					$money_all .= "(case when hpay.HOTELPAY_PS_DATA4=1 then ".$money_1." * (HOTELPAY_PS_DATA3/100) ";
					$money_all .= "when hpay.HOTELPAY_PS_DATA4=2 then HOTELPAY_PS_DATA3 ";
					$money_all .= "when hpay.HOTELPAY_PS_DATA4=3 then ".$money_1." - HOTELPAY_PS_DATA3 end )";
					$money_all .= "else 0 end ) * ".$childnum1.") ";
				}
				//	小学生(高学年)
				$childnum2 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"));
				if ($childnum2 > 0) {
					if ($money_all != "") $money_all .= " + ";
					$money_all .= "((case when hpay.HOTELPAY_PS_DATA22=1 then ";
					$money_all .= "(case when hpay.HOTELPAY_PS_DATA42=1 then ".$money_1." * (HOTELPAY_PS_DATA32/100) ";
					$money_all .= "when hpay.HOTELPAY_PS_DATA42=2 then HOTELPAY_PS_DATA32 ";
					$money_all .= "when hpay.HOTELPAY_PS_DATA42=3 then ".$money_1." - HOTELPAY_PS_DATA32 end ) ";
					$money_all .= "else 0 end ) * ".$childnum2.") ";
				}
				//	幼児 食事布団あり
				$childnum3 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3"));
				if ($childnum3 > 0) {
					if ($money_all != "") $money_all .= " + ";
					$money_all .= "((case when hpay.HOTELPAY_BB_DATA2=1 then ";
					$money_all .= "(case when hpay.HOTELPAY_BB_DATA4=1 then ".$money_1." * (HOTELPAY_BB_DATA3/100) ";
					$money_all .= "when hpay.HOTELPAY_BB_DATA4=2 then HOTELPAY_BB_DATA3 ";
					$money_all .= "when hpay.HOTELPAY_BB_DATA4=3 then ".$money_1." - HOTELPAY_BB_DATA3 end ) ";
					$money_all .= "else 0 end ) * ".$childnum3.") ";
				}
				//	幼児 布団あり
				$childnum5 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5"));
				if ($childnum5 > 0) {
					if ($money_all != "") $money_all .= " + ";
					$money_all .= "((case when hpay.HOTELPAY_BB_DATA9=1 then ";
					$money_all .= "(case when hpay.HOTELPAY_BB_DATA11=1 then ".$money_1." * (HOTELPAY_BB_DATA10/100) ";
					$money_all .= "when hpay.HOTELPAY_BB_DATA11=2 then HOTELPAY_BB_DATA10 ";
					$money_all .= "when hpay.HOTELPAY_BB_DATA11=3 then ".$money_1." - HOTELPAY_BB_DATA10 end ) ";
					$money_all .= "else 0 end ) * ".$childnum4.") ";
				}
			}
		}

		return $money_all;
	}





	private function resStay1Money($collection) {
		//	適用人数
//		print_r($collection);exit;
		$money_num .= "( ";
		//	大人
		$money_num .= intval($collection->getByKey($collection->getKeyValue(), "adult_number1"))." + ";
		//	小学生低 数える
		$money_num .= "case ";
		$money_num .= "when ";
		$money_num .= "hpay.HOTELPAY_PS_DATA2 = 1 ";
		$money_num .= "then ";
		$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number11"))." ";
		$money_num .= "else  ";
		$money_num .= "0  ";
		$money_num .= "end + ";
		//	小学生高 数える
		$money_num .= "case ";
		$money_num .= "when ";
		$money_num .= "hpay.HOTELPAY_PS_DATA22 = 1 ";
		$money_num .= "then ";
		$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number12"))." ";
		$money_num .= "else  ";
		$money_num .= "0  ";
		$money_num .= "end + ";
		//	幼児 食事・布団 数える
		$money_num .= "case ";
		$money_num .= "when ";
		$money_num .= "hpay.HOTELPAY_BB_DATA2 = 1 ";
		$money_num .= "then ";
		$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number13"))." ";
		$money_num .= "else  ";
		$money_num .= "0  ";
		$money_num .= "end + ";
		//	幼児 布団 数える
		$money_num .= "case ";
		$money_num .= "when ";
		$money_num .= "hpay.HOTELPAY_BB_DATA9 = 1 ";
		$money_num .= "then ";
		$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number15"))." ";
		$money_num .= "else  ";
		$money_num .= "0  ";
		$money_num .= "end ";
		$money_num .= ") ";

		//	人数から最小金額
		$money_1  = "( ";
		$money_1 .= "case ";
		$money_1 .= "when ";
		$money_1 .= $money_num." = 1 ";
		$money_1 .= "then ";
		$money_1 .= "min(hpay.HOTELPAY_MONEY1) ";
		$money_1 .= "when ";
		$money_1 .= $money_num." = 2 ";
		$money_1 .= "then ";
		$money_1 .= "min(hpay.HOTELPAY_MONEY2) ";
		$money_1 .= "when ";
		$money_1 .= $money_num." = 3 ";
		$money_1 .= "then ";
		$money_1 .= "min(hpay.HOTELPAY_MONEY3) ";
		$money_1 .= "when ";
		$money_1 .= $money_num." = 4 ";
		$money_1 .= "then ";
		$money_1 .= "min(hpay.HOTELPAY_MONEY4) ";
		$money_1 .= "when ";
		$money_1 .= $money_num." = 5 ";
		$money_1 .= "then ";
		$money_1 .= "min(hpay.HOTELPAY_MONEY5) ";
		$money_1 .= "else ";
		$money_1 .= "min(hpay.HOTELPAY_MONEY6) ";
		$money_1 .= "end ";
		$money_1 .= ") ";

		return $money_1;
	}
	
	//
	private function selectNumEveryRoom($collection) {
		//	適用人数
//		print_r($collection);exit;
		for ($i=1; $i<=$collection->getByKey($collection->getKeyValue(), "room_number"); $i++){
			$adult_num = $collection->getByKey($collection->getKeyValue(), "adult_number".$i);
			$child_num1 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."1");
			$child_num2 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."2");
			$child_num3 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."3");
			$child_num4 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."4");
			$child_num5 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."5");
			$child_num6 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."6");
			
			$sql  = "select HOTELPAY_MONEY1, HOTELPAY_MONEY2, HOTELPAY_MONEY3, HOTELPAY_MONEY4, HOTELPAY_MONEY5, HOTELPAY_MONEY6, HOTELPAY_PS_DATA1, HOTELPAY_PS_DATA2, HOTELPAY_PS_DATA3, HOTELPAY_PS_DATA4, HOTELPAY_PS_DATA12, HOTELPAY_PS_DATA22, HOTELPAY_PS_DATA32, HOTELPAY_PS_DATA42, HOTELPAY_BB_DATA1, HOTELPAY_BB_DATA2, HOTELPAY_BB_DATA3, HOTELPAY_BB_DATA4, HOTELPAY_BB_DATA5, HOTELPAY_BB_DATA6, HOTELPAY_BB_DATA7, HOTELPAY_BB_DATA8, HOTELPAY_BB_DATA9, HOTELPAY_BB_DATA10, HOTELPAY_BB_DATA11, HOTELPAY_BB_DATA12, HOTELPAY_BB_DATA13, HOTELPAY_BB_DATA14 ";
			$sql .= "from HOTELPAY ";
			$sql .= "where ";
			$sql .= " HOTELPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
			$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$sql .= " and HOTELPAY_DATE = '".$date."' ";
			
			$result = $this->db->execute($sql);
			
			if (mysql_affected_rows() > 0) {
				$row = mysql_fetch_assoc($result);
			}
			
			$count = $adult_num;
			if($child_num1 > 0 && $row["HOTELPAY_PS_DATA2"] == "1"){
				$count += $child_num1;
			}
			if($child_num2 > 0 && $row["HOTELPAY_PS_DATA22"] == "1"){
				$count += $child_num2;
			}
			if($child_num3 > 0 && $row["HOTELPAY_BB_DATA2"] == "1"){
				$count += $child_num3;
			}
			if($child_num5 > 0 && $row["HOTELPAY_BB_DATA9"] == "1"){
				$count += $child_num5;
			}
	
			$stayNum[$i] = $count;
		}
//		print_r($stayNum);exit;
		return $stayNum;
	}


	//ルーム毎の大人人数計算
	public function selectMoneyEveryRoomUndecideSch($collection) {
		// プラン販売期間が検索期間範囲を設定
		$sql  = "select HOTELPLAN_ID, HOTELPLAN_DATE_SALE_FROM, HOTELPLAN_DATE_SALE_TO ";
		$sql .= "from HOTELPLAN ";
		$sql .= "where ";
		$sql .= " HOTELPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
		$result = $this->db->execute($sql);

		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}

		$from_date =  $row["HOTELPLAN_DATE_SALE_FROM"];
		$to_date =  $row["HOTELPLAN_DATE_SALE_TO"];

		// 料金ようの人数計算
		$sql  = "select HOTELPAY_MONEY1, HOTELPAY_MONEY2, HOTELPAY_MONEY3, HOTELPAY_MONEY4, HOTELPAY_MONEY5, HOTELPAY_MONEY6, HOTELPAY_PS_DATA1, HOTELPAY_PS_DATA2, HOTELPAY_PS_DATA3, HOTELPAY_PS_DATA4, HOTELPAY_PS_DATA12, HOTELPAY_PS_DATA22, HOTELPAY_PS_DATA32, HOTELPAY_PS_DATA42, HOTELPAY_BB_DATA1, HOTELPAY_BB_DATA2, HOTELPAY_BB_DATA3, HOTELPAY_BB_DATA4, HOTELPAY_BB_DATA5, HOTELPAY_BB_DATA6, HOTELPAY_BB_DATA7, HOTELPAY_BB_DATA8, HOTELPAY_BB_DATA9, HOTELPAY_BB_DATA10, HOTELPAY_BB_DATA11, HOTELPAY_BB_DATA12, HOTELPAY_BB_DATA13, HOTELPAY_BB_DATA14, HOTELPAY_ROOM_NUM ";
		$sql .= "from HOTELPAY ";
		$sql .= "where ";
		$sql .= " HOTELPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
		$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
		$sql .= " and HOTELPAY_DATE <= '".$to_date."' and HOTELPAY_DATE>= '".$from_date."'";
		
		$result = $this->db->execute($sql);
		
		$row = array();
		if (mysql_affected_rows() > 0) {
			while($row = mysql_fetch_array($result)) {
				
				$count = $collection->getByKey($collection->getKeyValue(), "adult_number");
				if($collection->getByKey($collection->getKeyValue(), "child_number1") > 0 && $row["HOTELPAY_PS_DATA2"] == "1"){
					$count += $collection->getByKey($collection->getKeyValue(), "child_number1");
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number2") > 0 && $row["HOTELPAY_PS_DATA22"] == "1"){
					$count += $collection->getByKey($collection->getKeyValue(), "child_number2");
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number3") > 0 && $row["HOTELPAY_BB_DATA2"] == "1"){
					$count += $collection->getByKey($collection->getKeyValue(), "child_number3");
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number5") > 0 && $row["HOTELPAY_BB_DATA9"] == "1"){
					$count += $collection->getByKey($collection->getKeyValue(), "child_number5");
				}
		
				$moneyArray["people_count"] = $count;
				$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY".$count];
		
				$moneyALL = $collection->getByKey($collection->getKeyValue(), "adult_number") * $moneyArray["money_perperson"];
		
				if($collection->getByKey($collection->getKeyValue(), "child_number1") > 0){
					if($row["HOTELPAY_PS_DATA4"] == "1"){ //%
						$moneyArray["perchildFee1"] = $row["HOTELPAY_PS_DATA3"]/100*$moneyArray["money_perperson"];
						$moneyArray["childFee1"] = $collection->getByKey($collection->getKeyValue(), "child_number1")*$row["HOTELPAY_PS_DATA3"]/100*$moneyArray["money_perperson"];
						$moneyALL += $moneyArray["childFee1"];
					}
					elseif ($row["HOTELPAY_PS_DATA4"] == "2") { //円
						$moneyArray["perchildFee1"] = $row["HOTELPAY_PS_DATA3"];
						$moneyArray["childFee1"] = $collection->getByKey($collection->getKeyValue(), "child_number1")*$row["HOTELPAY_PS_DATA3"];
						$moneyALL += $moneyArray["childFee1"];
					}
					elseif ($row["HOTELPAY_PS_DATA4"] == "3") { //円引き
						$moneyArray["perchildFee1"] = $moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA3"];
						$moneyArray["childFee1"] = $collection->getByKey($collection->getKeyValue(), "child_number1")*($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA3"]);
						$moneyALL += $moneyArray["childFee1"];
					}
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number2") > 0){
					if($row["HOTELPAY_PS_DATA42"] == "1"){ //%
						$moneyArray["perchildFee2"] = $row["HOTELPAY_PS_DATA32"]/100*$moneyArray["money_perperson"];
						$moneyArray["childFee2"] = $collection->getByKey($collection->getKeyValue(), "child_number2")*$row["HOTELPAY_PS_DATA32"]/100*$moneyArray["money_perperson"];
						$moneyALL += $moneyArray["childFee2"];
					}
					elseif ($row["HOTELPAY_PS_DATA42"] == "2") { //円
						$moneyArray["perchildFee2"] = $row["HOTELPAY_PS_DATA32"];
						$moneyArray["childFee2"] = $collection->getByKey($collection->getKeyValue(), "child_number2")*$row["HOTELPAY_PS_DATA32"];
						$moneyALL += $moneyArray["childFee2"];
					}
					elseif ($row["HOTELPAY_PS_DATA42"] == "3") { //円引き
						$moneyArray["perchildFee2"] = $moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA32"];
						$moneyArray["childFee2"] = $collection->getByKey($collection->getKeyValue(), "child_number2")*($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA32"]);
						$moneyALL += $moneyArray["childFee2"];
					}
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number3") > 0){
					if($row["HOTELPAY_BB_DATA4"] == "1"){ //%
						$moneyArray["perchildFee3"] = $row["HOTELPAY_BB_DATA3"]/100*$moneyArray["money_perperson"];
						$moneyArray["childFee3"] = $collection->getByKey($collection->getKeyValue(), "child_number3")*$row["HOTELPAY_BB_DATA3"]/100*$moneyArray["money_perperson"];
						$moneyALL += $moneyArray["childFee3"];
					}
					elseif ($row["HOTELPAY_BB_DATA4"] == "2") { //円
						$moneyArray["perchildFee3"] = $row["HOTELPAY_BB_DATA3"];
						$moneyArray["childFee3"] = $collection->getByKey($collection->getKeyValue(), "child_number3")*$row["HOTELPAY_BB_DATA3"];
						$moneyALL += $moneyArray["childFee3"];
					}
					elseif ($row["HOTELPAY_BB_DATA4"] == "3") { //円引き
						$moneyArray["perchildFee3"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA3"];
						$moneyArray["childFee3"] = $collection->getByKey($collection->getKeyValue(), "child_number3")*($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA3"]);
						$moneyALL += $moneyArray["childFee3"];
					}
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number4") > 0){
					if($row["HOTELPAY_BB_DATA7"] == "1"){ //%
						$moneyArray["perchildFee4"] = $row["HOTELPAY_BB_DATA6"]/100*$moneyArray["money_perperson"];
						$moneyArray["childFee4"] = $collection->getByKey($collection->getKeyValue(), "child_number4")*$row["HOTELPAY_BB_DATA6"]/100*$moneyArray["money_perperson"];
						$moneyALL += $moneyArray["childFee4"];
					}
					elseif ($row["HOTELPAY_BB_DATA7"] == "2") { //円
						$moneyArray["perchildFee4"] = $row["HOTELPAY_BB_DATA6"];
						$moneyArray["childFee4"] = $collection->getByKey($collection->getKeyValue(), "child_number4")*$row["HOTELPAY_BB_DATA6"];
						$moneyALL += $moneyArray["childFee4"];
					}
					elseif ($row["HOTELPAY_BB_DATA7"] == "3") { //円引き
						$moneyArray["perchildFee4"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA6"];
						$moneyArray["childFee4"] = $collection->getByKey($collection->getKeyValue(), "child_number4")*($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA6"]);
						$moneyALL += $moneyArray["childFee4"];
					}
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number5") > 0){
					if($row["HOTELPAY_BB_DATA11"] == "1"){ //%
						$moneyArray["perchildFee5"] = $row["HOTELPAY_BB_DATA10"]/100*$moneyArray["money_perperson"];
						$moneyArray["childFee5"] = $collection->getByKey($collection->getKeyValue(), "child_number5")*$row["HOTELPAY_BB_DATA10"]/100*$moneyArray["money_perperson"];
						$moneyALL += $moneyArray["childFee54"];
					}
					elseif ($row["HOTELPAY_BB_DATA11"] == "2") { //円
						$moneyArray["perchildFee5"] = $row["HOTELPAY_BB_DATA10"];
						$moneyArray["childFee5"] = $collection->getByKey($collection->getKeyValue(), "child_number5")*$row["HOTELPAY_BB_DATA10"];
						$moneyALL += $moneyArray["childFee5"];
					}
					elseif ($row["HOTELPAY_BB_DATA11"] == "3") { //円引き
						$moneyArray["perchildFee5"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA10"];
						$moneyArray["childFee5"] = $collection->getByKey($collection->getKeyValue(), "child_number5")*$moneyArray["perchildFee4"];
						$moneyALL += $moneyArray["childFee5"];
					}
		
				}
				if($collection->getByKey($collection->getKeyValue(), "child_number6") > 0 ){
					if($row["HOTELPAY_BB_DATA14"] == "1"){ //%
						$moneyArray["perchildFee6"] = $row["HOTELPAY_BB_DATA13"]/100*$moneyArray["money_perperson"];
						$moneyArray["childFee6"] = $collection->getByKey($collection->getKeyValue(), "child_number6")*$moneyArray["perchildFee6"];
						$moneyALL += $moneyArray["childFee6"];
					}
					elseif ($row["HOTELPAY_BB_DATA14"] == "2") { //円
						$moneyArray["perchildFee6"] = $row["HOTELPAY_BB_DATA13"];
						$moneyArray["childFee6"] = $collection->getByKey($collection->getKeyValue(), "child_number6")*$row["HOTELPAY_BB_DATA13"];
						$moneyALL += $moneyArray["childFee6"];
					}
					elseif ($row["HOTELPAY_BB_DATA14"] == "3") { //円引き
						$moneyArray["perchildFee6"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA13"];
						$moneyArray["childFee6"] = $collection->getByKey($collection->getKeyValue(), "child_number6")*($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA13"]);
						$moneyALL += $moneyArray["childFee6"];
					}
				}
				$moneyArray["money_ALL"] = $moneyALL;
				$moneyArray["point"] = $row["HOTELPAY_ROOM_NUM"];
				
				if($moneyArray["money_ALL"] > 0){
					if(!$cheapest){
						$cheapest["money_ALL"] = $moneyArray["money_ALL"];
						$cheapest["money_perperson"] = $moneyArray["money_perperson"];
						$cheapest["point"] = $moneyArray["point"];
					}
					else{
						if ($cheapest["money_ALL"] > $moneyArray["money_ALL"]) {
							$cheapest["money_ALL"] = $moneyArray["money_ALL"];
							$cheapest["money_perperson"] = $moneyArray["money_perperson"];
							$cheapest["point"] = $moneyArray["point"];
						}
					}
				}
			}
		}

//		print_r($cheapest);exit;
		return $cheapest;
	}


	
	//ルーム毎の大人人数計算
	public function selectMoneyEveryRoom($collection) {
		// 日付格式変更
		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "SEARCH_DATE") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "SEARCH_DATE"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

		// 料金ようの人数計算
		$sql  = "select HOTELPAY_MONEY1, HOTELPAY_MONEY2, HOTELPAY_MONEY3, HOTELPAY_MONEY4, HOTELPAY_MONEY5, HOTELPAY_MONEY6, HOTELPAY_PS_DATA1, HOTELPAY_PS_DATA2, HOTELPAY_PS_DATA3, HOTELPAY_PS_DATA4, HOTELPAY_PS_DATA12, HOTELPAY_PS_DATA22, HOTELPAY_PS_DATA32, HOTELPAY_PS_DATA42, HOTELPAY_BB_DATA1, HOTELPAY_BB_DATA2, HOTELPAY_BB_DATA3, HOTELPAY_BB_DATA4, HOTELPAY_BB_DATA5, HOTELPAY_BB_DATA6, HOTELPAY_BB_DATA7, HOTELPAY_BB_DATA8, HOTELPAY_BB_DATA9, HOTELPAY_BB_DATA10, HOTELPAY_BB_DATA11, HOTELPAY_BB_DATA12, HOTELPAY_BB_DATA13, HOTELPAY_BB_DATA14, HOTELPAY_ROOM_NUM ";
		$sql .= "from HOTELPAY ";
		$sql .= "where ";
		$sql .= " HOTELPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID");
		$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
		$sql .= " and HOTELPAY_DATE = '".$date."' ";

		$result = $this->db->execute($sql);	
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}


		$count = $collection->getByKey($collection->getKeyValue(), "adult_number");
		if($collection->getByKey($collection->getKeyValue(), "child_number1") > 0 && $row["HOTELPAY_PS_DATA2"] == "1"){
			$count += $collection->getByKey($collection->getKeyValue(), "child_number1");
		}
		if($collection->getByKey($collection->getKeyValue(), "child_number2") > 0 && $row["HOTELPAY_PS_DATA22"] == "1"){
			$count += $collection->getByKey($collection->getKeyValue(), "child_number2");
		}
		if($collection->getByKey($collection->getKeyValue(), "child_number3") > 0 && $row["HOTELPAY_BB_DATA2"] == "1"){
			$count += $collection->getByKey($collection->getKeyValue(), "child_number3");
		}
		if($collection->getByKey($collection->getKeyValue(), "child_number5") > 0 && $row["HOTELPAY_BB_DATA9"] == "1"){
			$count += $collection->getByKey($collection->getKeyValue(), "child_number5");
		}

		$moneyArray["people_count"] = $count;
		$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY".$count];

		$moneyALL = $collection->getByKey($collection->getKeyValue(), "adult_number") * $moneyArray["money_perperson"];


		if($collection->getByKey($collection->getKeyValue(), "child_number1") > 0){
			if($row["HOTELPAY_PS_DATA4"] == "1"){ //%
				$moneyArray["perchildFee1"] = $row["HOTELPAY_PS_DATA3"]/100*$moneyArray["money_perperson"];

		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath1"] = "小学生低学年".$collection->getByKey($collection->getKeyValue(), "child_number1")."人× ￥".number_format($row["HOTELPAY_PS_DATA3"]/100*$moneyArray["money_perperson"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath1"] = "小人(A)".$collection->getByKey($collection->getKeyValue(), "child_number1")."人× ￥".number_format($row["HOTELPAY_PS_DATA3"]/100*$moneyArray["money_perperson"]);}
				$moneyArray["childFee1"] = $collection->getByKey($collection->getKeyValue(), "child_number1")*$row["HOTELPAY_PS_DATA3"]/100*$moneyArray["money_perperson"];
				$moneyALL += $moneyArray["childFee1"];
			}
			elseif ($row["HOTELPAY_PS_DATA4"] == "2") { //円
				$moneyArray["perchildFee1"] = $row["HOTELPAY_PS_DATA3"];
				$moneyArray["childFee1"] = $collection->getByKey($collection->getKeyValue(), "child_number1")*$row["HOTELPAY_PS_DATA3"];
				$moneyALL += $moneyArray["childFee1"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath1"] = "小学生低学年".$collection->getByKey($collection->getKeyValue(), "child_number1")."人× ￥".number_format($row["HOTELPAY_PS_DATA3"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath1"] = "小人(A)".$collection->getByKey($collection->getKeyValue(), "child_number1")."人× ￥".number_format($row["HOTELPAY_PS_DATA3"]);}
			}
			elseif ($row["HOTELPAY_PS_DATA4"] == "3") { //円引き
				$moneyArray["perchildFee1"] = $moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA3"];
				$moneyArray["childFee1"] = $collection->getByKey($collection->getKeyValue(), "child_number1")*($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA3"]);
				$moneyALL += $moneyArray["childFee1"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath1"] = "小学生低学年".$collection->getByKey($collection->getKeyValue(), "child_number1")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA3"]));}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath1"] = "小人(A)".$collection->getByKey($collection->getKeyValue(), "child_number1")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA3"]));}
			}
		}
		if($collection->getByKey($collection->getKeyValue(), "child_number2") > 0){
			if($row["HOTELPAY_PS_DATA42"] == "1"){ //%
				$moneyArray["perchildFee2"] = $row["HOTELPAY_PS_DATA32"]/100*$moneyArray["money_perperson"];
				$moneyArray["childFee2"] = $collection->getByKey($collection->getKeyValue(), "child_number2")*$row["HOTELPAY_PS_DATA32"]/100*$moneyArray["money_perperson"];
				$moneyALL += $moneyArray["childFee2"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath2"] .= "小学生高学年".$collection->getByKey($collection->getKeyValue(), "child_number2")."人× ￥".number_format($row["HOTELPAY_PS_DATA32"]/100*$moneyArray["money_perperson"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath2"] .= "小人(B)".$collection->getByKey($collection->getKeyValue(), "child_number2")."人× ￥".number_format($row["HOTELPAY_PS_DATA32"]/100*$moneyArray["money_perperson"]);}
			}
			elseif ($row["HOTELPAY_PS_DATA42"] == "2") { //円
				$moneyArray["perchildFee2"] = $row["HOTELPAY_PS_DATA32"];
				$moneyArray["childFee2"] = $collection->getByKey($collection->getKeyValue(), "child_number2")*$row["HOTELPAY_PS_DATA32"];
				$moneyALL += $moneyArray["childFee2"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath2"] .= "小学生高学年".$collection->getByKey($collection->getKeyValue(), "child_number2")."人× ￥".number_format($row["HOTELPAY_PS_DATA32"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath2"] .= "小人(B)".$collection->getByKey($collection->getKeyValue(), "child_number2")."人× ￥".number_format($row["HOTELPAY_PS_DATA32"]);}
			}
			elseif ($row["HOTELPAY_PS_DATA42"] == "3") { //円引き
				$moneyArray["perchildFee2"] = $moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA32"];
				$moneyArray["childFee2"] = $collection->getByKey($collection->getKeyValue(), "child_number2")*($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA32"]);
				$moneyALL += $moneyArray["childFee2"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath2"] .= "小学生高学年".$collection->getByKey($collection->getKeyValue(), "child_number2")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA32"]));}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath2"] .= "小人(B)".$collection->getByKey($collection->getKeyValue(), "child_number2")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_PS_DATA32"]));}
			}
		}
		if($collection->getByKey($collection->getKeyValue(), "child_number3") > 0){
			if($row["HOTELPAY_BB_DATA4"] == "1"){ //%
				$moneyArray["perchildFee3"] = $row["HOTELPAY_BB_DATA3"]/100*$moneyArray["money_perperson"];
				$moneyArray["childFee3"] = $collection->getByKey($collection->getKeyValue(), "child_number3")*$row["HOTELPAY_BB_DATA3"]/100*$moneyArray["money_perperson"];
				$moneyALL += $moneyArray["childFee3"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath3"] .= "幼児（食事・布団あり）".$collection->getByKey($collection->getKeyValue(), "child_number3")."人× ￥".number_format($row["HOTELPAY_BB_DATA3"]/100*$moneyArray["money_perperson"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath3"] .= "幼児（A）".$collection->getByKey($collection->getKeyValue(), "child_number3")."人× ￥".number_format($row["HOTELPAY_BB_DATA3"]/100*$moneyArray["money_perperson"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA4"] == "2") { //円
				$moneyArray["perchildFee3"] = $row["HOTELPAY_BB_DATA3"];
				$moneyArray["childFee3"] = $collection->getByKey($collection->getKeyValue(), "child_number3")*$row["HOTELPAY_BB_DATA3"];
				$moneyALL += $moneyArray["childFee3"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath3"] .= "幼児（食事・布団あり）".$collection->getByKey($collection->getKeyValue(), "child_number3")."人× ￥".number_format($row["HOTELPAY_BB_DATA3"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath3"] .= "幼児（A）".$collection->getByKey($collection->getKeyValue(), "child_number3")."人× ￥".number_format($row["HOTELPAY_BB_DATA3"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA4"] == "3") { //円引き
				$moneyArray["perchildFee3"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA3"];
				$moneyArray["childFee3"] = $collection->getByKey($collection->getKeyValue(), "child_number3")*($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA3"]);
				$moneyALL += $moneyArray["childFee3"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath3"] .= "幼児（食事・布団あり）".$collection->getByKey($collection->getKeyValue(), "child_number3")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA3"]));}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath3"] .= "幼児（A）".$collection->getByKey($collection->getKeyValue(), "child_number3")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA3"]));}
			}
		}
		if($collection->getByKey($collection->getKeyValue(), "child_number5") > 0){
			if($row["HOTELPAY_BB_DATA11"] == "1"){ //%
				$moneyArray["perchildFee5"] = $row["HOTELPAY_BB_DATA10"]/100*$moneyArray["money_perperson"];
				$moneyArray["childFee5"] = $collection->getByKey($collection->getKeyValue(), "child_number5")*$row["HOTELPAY_BB_DATA10"]/100*$moneyArray["money_perperson"];
				$moneyALL += $moneyArray["childFee5"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath5"] .= "幼児（布団あり）".$collection->getByKey($collection->getKeyValue(), "child_number5")."人× ￥".number_format($row["HOTELPAY_BB_DATA10"]/100*$moneyArray["money_perperson"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath5"] .= "幼児（C）".$collection->getByKey($collection->getKeyValue(), "child_number5")."人× ￥".number_format($row["HOTELPAY_BB_DATA10"]/100*$moneyArray["money_perperson"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA11"] == "2") { //円
				$moneyArray["perchildFee5"] = $row["HOTELPAY_BB_DATA10"];
				$moneyArray["childFee5"] = $collection->getByKey($collection->getKeyValue(), "child_number5")*$row["HOTELPAY_BB_DATA10"];
				$moneyALL += $moneyArray["childFee5"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath5"] .= "幼児（布団あり）".$collection->getByKey($collection->getKeyValue(), "child_number5")."人× ￥".number_format($row["HOTELPAY_BB_DATA10"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath5"] .= "幼児（C）".$collection->getByKey($collection->getKeyValue(), "child_number5")."人× ￥".number_format($row["HOTELPAY_BB_DATA10"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA11"] == "3") { //円引き
				$moneyArray["perchildFee5"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA10"];
				$moneyArray["childFee5"] = $collection->getByKey($collection->getKeyValue(), "child_number5")*($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA10"]);
				$moneyALL += $moneyArray["childFee5"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath5"] .= "幼児（布団あり）".$collection->getByKey($collection->getKeyValue(), "child_number5")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA10"]));}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath5"] .= "幼児（C）".$collection->getByKey($collection->getKeyValue(), "child_number5")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA10"]));}
			}
		}
		if($collection->getByKey($collection->getKeyValue(), "child_number4") > 0){
			if($row["HOTELPAY_BB_DATA7"] == "1"){ //%
				$moneyArray["perchildFee4"] = $row["HOTELPAY_BB_DATA6"]/100*$moneyArray["money_perperson"];
				$moneyArray["childFee4"] = $collection->getByKey($collection->getKeyValue(), "child_number4")*$row["HOTELPAY_BB_DATA6"]/100*$moneyArray["money_perperson"];
				$moneyALL += $moneyArray["childFee4"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath4"] .= "幼児（食事あり）".$collection->getByKey($collection->getKeyValue(), "child_number4")."人× ￥".number_format($row["HOTELPAY_BB_DATA6"]/100*$moneyArray["money_perperson"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath4"] .= "幼児（B）".$collection->getByKey($collection->getKeyValue(), "child_number4")."人× ￥".number_format($row["HOTELPAY_BB_DATA6"]/100*$moneyArray["money_perperson"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA7"] == "2") { //円
				$moneyArray["perchildFee4"] = $row["HOTELPAY_BB_DATA10"];
				$moneyArray["childFee4"] = $collection->getByKey($collection->getKeyValue(), "child_number4")*$row["HOTELPAY_BB_DATA6"];
				$moneyALL += $moneyArray["childFee4"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath4"] .= "幼児（食事あり）".$collection->getByKey($collection->getKeyValue(), "child_number4")."人× ￥".number_format($row["HOTELPAY_BB_DATA6"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath4"] .= "幼児（B）".$collection->getByKey($collection->getKeyValue(), "child_number4")."人× ￥".number_format($row["HOTELPAY_BB_DATA6"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA7"] == "3") { //円引き
				$moneyArray["perchildFee4"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA6"];
				$moneyArray["childFee4"] = $collection->getByKey($collection->getKeyValue(), "child_number4")*$moneyArray["perchildFee4"];
				$moneyALL += $moneyArray["childFee4"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath4"] .= "幼児（食事あり）".$collection->getByKey($collection->getKeyValue(), "child_number4")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA6"]));}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath4"] .= "幼児（B）".$collection->getByKey($collection->getKeyValue(), "child_number4")."人× ￥".number_format(($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA6"]));}
			}

		}
		if($collection->getByKey($collection->getKeyValue(), "child_number6") > 0 ){
			if($row["HOTELPAY_BB_DATA14"] == "1"){ //%
				$moneyArray["perchildFee6"] = $row["HOTELPAY_BB_DATA13"]/100*$moneyArray["money_perperson"];
				$moneyArray["childFee6"] = $collection->getByKey($collection->getKeyValue(), "child_number6")*$moneyArray["perchildFee6"];
				$moneyALL += $moneyArray["childFee6"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath6"] .= "幼児（食事・布団なし）".$collection->getByKey($collection->getKeyValue(), "child_number6")."人× ￥".number_format($row["HOTELPAY_BB_DATA13"]/100*$moneyArray["money_perperson"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath6"] .= "幼児（D）".$collection->getByKey($collection->getKeyValue(), "child_number6")."人× ￥".number_format($row["HOTELPAY_BB_DATA13"]/100*$moneyArray["money_perperson"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA14"] == "2") { //円
				$moneyArray["perchildFee6"] = $row["HOTELPAY_BB_DATA13"];
				$moneyArray["childFee6"] = $collection->getByKey($collection->getKeyValue(), "child_number6")*$row["HOTELPAY_BB_DATA13"];
				$moneyALL += $moneyArray["childFee6"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath6"] .= "幼児（食事・布団なし）".$collection->getByKey($collection->getKeyValue(), "child_number6")."人× ￥".number_format($row["HOTELPAY_BB_DATA13"]);}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath6"] .= "幼児（D）".$collection->getByKey($collection->getKeyValue(), "child_number6")."人× ￥".number_format($row["HOTELPAY_BB_DATA13"]);}
			}
			elseif ($row["HOTELPAY_BB_DATA14"] == "3") { //円引き
				$moneyArray["perchildFee6"] = $moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA13"];
				$moneyArray["childFee6"] = $collection->getByKey($collection->getKeyValue(), "child_number6")*($moneyArray["money_perperson"]-$row["HOTELPAY_BB_DATA13"]);
				$moneyALL += $moneyArray["childFee6"];
		if (($_SERVER['REQUEST_URI'] == "/reservation.html")or($_SERVER['REQUEST_URI'] == "/reservation-request.html")){
				$moneyArray["childMath6"] .= "幼児（食事・布団なし）".$collection->getByKey($collection->getKeyValue(), "child_number6")."人× ￥".number_format(($moneyArray["HOTELPAY_BB_DATA13"]-$row["HOTELPAY_BB_DATA10"]));}
		elseif (($_SERVER['REQUEST_URI'] == "/reservation-act.html")or($_SERVER['REQUEST_URI'] == "/reservation-request-act.html")){
				$moneyArray["childMath6"] .= "幼児（D）".$collection->getByKey($collection->getKeyValue(), "child_number6")."人× ￥".number_format(($moneyArray["HOTELPAY_BB_DATA13"]-$row["HOTELPAY_BB_DATA10"]));}
			}
		}
		$moneyArray["money_ALL"] = $moneyALL;
		$moneyArray["point"] = $row["HOTELPAY_ROOM_NUM"];
//		print_r($moneyArray);
		return $moneyArray;
	}



	public function selectListAdmin($collection) {
		$sql  = "select ";
		$sql .= "c.COMPANY_ID, HOTEL_STATUS, COMPANY_CONTRACT_DATE_END, HOTEL_NAME, ";
		$sql .= parent::decryptionList("COMPANY_NAME").", ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from COMPANY c ";
		$sql .= "left join ".hotel::tableName." a on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".hotel::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTEL_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$HOTEL_NAM = "%".$collection->getByKey($collection->getKeyValue(), "HOTEL_NAME")."%";
			$where .= "HOTEL_NAME like '$HOTEL_NAM' ";
		}


		if ($where != "") {
			$where .= "and ";
		}
		$where .= parent::expsData("COMPANY_FUNC_HOTERL", "=", 1)." ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTEL_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, hotel::keyName);

	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "a.COMPANY_ID, HOTEL_STATUS, COMPANY_CONTRACT_DATE_END, ";
		$sql .= "HOTEL_NAME, ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from ".hotel::tableName." a ";
		$sql .= "inner join COMPANY c on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".hotel::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTEL_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$HOTEL_NAM = "%".$collection->getByKey($collection->getKeyValue(), "HOTEL_NAME")."%";
			$where .= "HOTEL_NAME like '$HOTEL_NAM' ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTEL_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, hotel::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "COMPANY_ID, HOTEL_FLG_KIND, HOTEL_FLG_PUBLIC, ";
		$sql .= "HOTEL_PREF, ";
		$sql .= "HOTEL_LIST_AREA, HOTEL_NAME, HOTEL_NAME_KANA, HOTEL_CATCHCOPY, HOTEL_CUSTOMER_CODE, HOTEL_NUMBER, HOTEL_SPA, ";
		$sql .= "HOTEL_ZIP, HOTEL_CITY, HOTEL_ADDRESS, HOTEL_TEL, HOTEL_PIC_APP, HOTEL_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_PIC_FAC".$i.", ";
		}
		$sql .= parent::decryptionList("HOTEL_LON, HOTEL_LAT").", ";
		$sql .= "HOTEL_ACCESS_SUM, ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "HOTEL_STATION".$i.", ";
		}
		$sql .= "HOTEL_LIST_LOCATION, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTEL_ACCESS_PLACE".$i.", HOTEL_ACCESS_HOW".$i.", HOTEL_ACCESS_IC".$i.", HOTEL_ACCESS_IC_TO".$i.", HOTEL_ACCESS_IC_FROM".$i.", ";
		}
		$sql .= "HOTEL_PARKING, HOTEL_SEND, ";
		$sql .= "HOTEL_PARKING_MEMO, HOTEL_SEND_REMARKS, HOTEL_ACCESS_REMARKS, HOTEL_ACCESS_REMARKS_CAR, ";
		for ($i=1; $i<=49; $i++) {
			$sql .= "HOTEL_ROOM_DATA".$i.", ";
		}
		for ($i=1; $i<=9; $i++) {
			$sql .= "HOTEL_ROOM_LIST".$i.", ";
		}
		$sql .= "HOTEL_ROOM_REMARKS, HOTEL_SPA_REMARKS, HOTEL_SPA_REMARKS2, HOTEL_SPA_NAME, ";
		$sql .= "HOTEL_SPA_FLG, HOTEL_SPA_KIND, ";
		for ($i=1; $i<=14; $i++) {
			$sql .= "HOTEL_SPA_DATA".$i.", ";
		}
		$sql .= "HOTEL_SPA_DATA15, ";
		for ($i=1; $i<=17; $i++) {
			$sql .= "HOTEL_AMENITY_DATA".$i.", ";
		}
		$sql .= "HOTEL_AMENITY_LIST, HOTEL_AMENITY_MEMO, ";
		for ($i=1; $i<=20; $i++) {
			$sql .= "HOTEL_FACILITY_DATA".$i.", ";
		}
		for ($i=1; $i<=10; $i++) {
			$sql .= "HOTEL_FACILITY_LIST".$i.", ";
		}
		$sql .= "HOTEL_FACILITY_MEMO, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTEL_FACILITY_NUM".$i.", ";
			$sql .= "HOTEL_FACILITY_FROM".$i.", ";
			$sql .= "HOTEL_FACILITY_TO".$i.", ";
		}
		for ($i=1; $i<=30; $i++) {
			$sql .= "HOTEL_SERVICE_DATA".$i.", ";
		}
		$sql .= "HOTEL_SERVICE_LIST, HOTEL_LIST_PET, HOTEL_PET_MEMO, HOTEL_PET_MEMO2, HOTEL_PET_MEMO3, HOTEL_PET_MEMO4, HOTEL_PET_MEMO5, HOTEL_PET_MEMO6, HOTEL_DATA_REAMRKS, HOTEL_TIME_RECEPT_FROM, HOTEL_TIME_RECEPT_TO, HOTEL_TIME_CHECKIN_FROM, HOTEL_TIME_CHECKIN_TO, ";
		$sql .= "HOTEL_TIME_CHECKOUT_FROM, HOTEL_TIME_CHECKOUT_TO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_FOOD_DATA".$i.", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_CHILD_LIST".$i.", ";
		}
		$sql .= "HOTEL_CHILD_MEMO, ";
		$sql .= "HOTEL_STAY_LIST, HOTEL_STAY_MEMO, HOTEL_CARD_LIST, HOTEL_CARD_MEMO, HOTEL_CAUTION, HOTEL_DISABLED, ";
		$sql .= "HOTEL_CARD_FLG, ";
		$sql .= "HOTEL_SPA_TAX, HOTEL_ORDER, HOTEL_STATUS  ";
		$sql .= "from ".hotel::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotel::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTEL_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTEL_ORDER desc ";

		parent::setCollection($sql, hotel::keyName);
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



	public function insert($dataList) {
		$sql  = "insert into ".hotel::tableName." (";
		$sql .= "COMPANY_ID, ";
		$sql .= "HOTEL_NAME, ";
		$sql .= "HOTEL_NAME_KANA, ";
		$sql .= "HOTEL_CATCHCOPY, ";
		$sql .= "HOTEL_CUSTOMER_CODE, ";
		$sql .= "HOTEL_NUMBER, ";
		$sql .= "HOTEL_SPA, ";
		$sql .= "HOTEL_FLG_KIND, ";
		$sql .= "HOTEL_LIST_AREA, ";
		$sql .= "HOTEL_FLG_PUBLIC, ";
		$sql .= "HOTEL_ZIP, ";
		$sql .= "HOTEL_PREF, ";
		$sql .= "HOTEL_CITY, ";
		$sql .= "HOTEL_ADDRESS, ";
		$sql .= "HOTEL_TEL, ";
		$sql .= "HOTEL_PIC_APP, ";
		$sql .= "HOTEL_DETAIL, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_PIC_FAC".$i.", ";
		}
		$sql .= "HOTEL_LON, ";
		$sql .= "HOTEL_LAT, ";
		$sql .= "HOTEL_ACCESS_SUM, ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "HOTEL_STATION".$i.", ";
		}
		$sql .= "HOTEL_LIST_LOCATION, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTEL_ACCESS_PLACE".$i.", ";
			$sql .= "HOTEL_ACCESS_HOW".$i.", ";
			$sql .= "HOTEL_ACCESS_IC".$i.", ";
			$sql .= "HOTEL_ACCESS_IC_TO".$i.", ";
			$sql .= "HOTEL_ACCESS_IC_FROM".$i.", ";
		}
		$sql .= "HOTEL_PARKING, ";
		$sql .= "HOTEL_PARKING_MEMO, ";
		$sql .= "HOTEL_SEND, ";
		$sql .= "HOTEL_SEND_REMARKS, ";
		$sql .= "HOTEL_ACCESS_REMARKS, ";
		$sql .= "HOTEL_ACCESS_REMARKS_CAR, ";
		for ($i=1; $i<=49; $i++) {
			$sql .= "HOTEL_ROOM_DATA".$i.", ";
		}
		for ($i=1; $i<=9; $i++) {
			$sql .= "HOTEL_ROOM_LIST".$i.", ";
		}
		$sql .= "HOTEL_ROOM_REMARKS, ";
		$sql .= "HOTEL_SPA_REMARKS, ";
		$sql .= "HOTEL_SPA_REMARKS2, ";
		$sql .= "HOTEL_SPA_NAME, ";
		$sql .= "HOTEL_SPA_FLG, ";
		$sql .= "HOTEL_SPA_KIND, ";
		for ($i=1; $i<=15; $i++) {
			$sql .= "HOTEL_SPA_DATA".$i.", ";
		}
		for ($i=1; $i<=17; $i++) {
			$sql .= "HOTEL_AMENITY_DATA".$i.", ";
		}
		$sql .= "HOTEL_AMENITY_LIST, ";
		$sql .= "HOTEL_AMENITY_MEMO, ";
		for ($i=1; $i<=20; $i++) {
			$sql .= "HOTEL_FACILITY_DATA".$i.", ";
		}
		for ($i=1; $i<=10; $i++) {
			$sql .= "HOTEL_FACILITY_LIST".$i.", ";
		}
		$sql .= "HOTEL_FACILITY_MEMO, ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTEL_FACILITY_NUM".$i.", ";
			$sql .= "HOTEL_FACILITY_FROM".$i.", ";
			$sql .= "HOTEL_FACILITY_TO".$i.", ";
		}
		for ($i=1; $i<=30; $i++) {
			$sql .= "HOTEL_SERVICE_DATA".$i.", ";
		}
		$sql .= "HOTEL_SERVICE_LIST, ";
		$sql .= "HOTEL_LIST_PET, ";
		$sql .= "HOTEL_DATA_REAMRKS, ";
		$sql .= "HOTEL_PET_MEMO, ";
		for ($i=2; $i<=6; $i++) {
			$sql .= "HOTEL_PET_MEMO".$i.", ";
		}
		$sql .= "HOTEL_TIME_RECEPT_FROM, ";
		$sql .= "HOTEL_TIME_RECEPT_TO, ";
		$sql .= "HOTEL_TIME_CHECKIN_FROM, ";
		$sql .= "HOTEL_TIME_CHECKIN_TO, ";
		$sql .= "HOTEL_TIME_CHECKOUT_FROM, ";
		$sql .= "HOTEL_TIME_CHECKOUT_TO, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_FOOD_DATA".$i.", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_CHILD_LIST".$i.", ";
		}
		$sql .= "HOTEL_CHILD_MEMO, ";

		$sql .= "HOTEL_STAY_LIST, ";
		$sql .= "HOTEL_STAY_MEMO, ";
		$sql .= "HOTEL_CARD_FLG, ";
		$sql .= "HOTEL_CARD_LIST, ";
		$sql .= "HOTEL_CARD_MEMO, ";
		$sql .= "HOTEL_CAUTION, ";
		$sql .= "HOTEL_DISABLED, ";

		$sql .= "HOTEL_SPA_TAX, ";
		$sql .= "HOTEL_ORDER, ";
		$sql .= "HOTEL_STATUS, ";
		$sql .= "HOTEL_DATE_REGIST, ";
		$sql .= "HOTEL_DATE_UPDATE) values (";


// 		$sql .= "null, ";
		$sql .= "'".$dataList["COMPANY_ID"]."', ";
		$sql .= "'".$dataList["HOTEL_NAME"]."', ";
		$sql .= "'".$dataList["HOTEL_NAME_KANA"]."', ";
		$sql .= "'".$dataList["HOTEL_CATCHCOPY"]."', ";
		$sql .= "'".$dataList["HOTEL_CUSTOMER_CODE"]."', ";
		$sql .= "'".$dataList["HOTEL_NUMBER"]."', ";
		$sql .= "'".$dataList["HOTEL_SPA"]."', ";
		$sql .= "'".$dataList["HOTEL_FLG_KIND"]."', ";
		$sql .= "'".$dataList["HOTEL_LIST_AREA"]."', ";
		$sql .= "'".$dataList["HOTEL_FLG_PUBLIC"]."', ";
		$sql .= "'".$dataList["HOTEL_ZIP"]."', ";
		$sql .= "'".$dataList["HOTEL_PREF"]."', ";
		$sql .= "'".$dataList["HOTEL_CITY"]."', ";
		$sql .= "'".$dataList["HOTEL_ADDRESS"]."', ";
		$sql .= "'".$dataList["HOTEL_TEL"]."', ";
		$sql .= "'".$dataList["HOTEL_PIC_APP"]."', ";
		$sql .= "'".$dataList["HOTEL_DETAIL"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["HOTEL_PIC_FAC".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_LON"]."', ";
		$sql .= "'".$dataList["HOTEL_LAT"]."', ";
		$sql .= "'".$dataList["HOTEL_ACCESS_SUM"]."', ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "'".$dataList["HOTEL_STATION".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_LIST_LOCATION"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "'".$dataList["HOTEL_ACCESS_PLACE".$i]."', ";
			$sql .= "'".$dataList["HOTEL_ACCESS_HOW".$i]."', ";
			$sql .= "'".$dataList["HOTEL_ACCESS_IC".$i]."', ";
			$sql .= "'".$dataList["HOTEL_ACCESS_IC_TO".$i]."', ";
			$sql .= "'".$dataList["HOTEL_ACCESS_IC_FROM".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_PARKING"]."', ";
		$sql .= "'".$dataList["HOTEL_PARKING_MEMO"]."', ";
		$sql .= "'".$dataList["HOTEL_SEND"]."', ";
		$sql .= "'".$dataList["HOTEL_SEND_REMARKS"]."', ";
		$sql .= "'".$dataList["HOTEL_ACCESS_REMARKS"]."', ";
		$sql .= "'".$dataList["HOTEL_ACCESS_REMARKS_CAR"]."', ";
		for ($i=1; $i<=49; $i++) {
			if ($i == 28 or $i == 27) {
				$sql .= "'".$dataList["HOTEL_ROOM_DATA".$i]."', ";
			}
			else {
				$sql .= "'".$dataList["HOTEL_ROOM_DATA".$i]."', ";
			}
		}
		for ($i=1; $i<=9; $i++) {
				$sql .= "'".$dataList["HOTEL_ROOM_LIST".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_ROOM_REMARKS"]."', ";
		$sql .= "'".$dataList["HOTEL_SPA_REMARKS"]."', ";
		$sql .= "'".$dataList["HOTEL_SPA_REMARKS2"]."', ";
		$sql .= "'".$dataList["HOTEL_SPA_NAME"]."', ";
		$sql .= "'".$dataList["HOTEL_SPA_FLG"]."', ";
		$sql .= "'".$dataList["HOTEL_SPA_KIND"]."', ";
		for ($i=1; $i<=14; $i++) {
			$sql .= "'".$dataList["HOTEL_SPA_DATA".$i]."', ";
		}
		$sql .= "'". $dataList["HOTEL_SPA_DATA15"]."', ";
		for ($i=1; $i<=17; $i++) {
			$sql .= "'".$dataList["HOTEL_AMENITY_DATA".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_AMENITY_LIST"]."', ";
		$sql .= "'".$dataList["HOTEL_AMENITY_MEMO"]."', ";
		for ($i=1; $i<=20; $i++) {
			$sql .= "'".$dataList["HOTEL_FACILITY_DATA".$i]."', ";
		}
		for ($i=1; $i<=10; $i++) {
			$sql .= "'".$dataList["HOTEL_FACILITY_LIST".$i]."', ";
		}
		$sql .= "'". $dataList["HOTEL_FACILITY_MEMO"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "'".$dataList["HOTEL_FACILITY_NUM".$i]."', ";
			$sql .= "'".$dataList["HOTEL_FACILITY_FROM".$i]."', ";
			$sql .= "'".$dataList["HOTEL_FACILITY_TO".$i]."', ";
		}
		for ($i=1; $i<=30; $i++) {
			$sql .= "'".$dataList["HOTEL_SERVICE_DATA".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_SERVICE_LIST"]."', ";
		$sql .= "'".$dataList["HOTEL_LIST_PET"]."', ";
		$sql .= "'".$dataList["HOTEL_PET_MEMO"]."', ";
		for ($i=2; $i<=6; $i++) {
			$sql .= "'". $dataList["HOTEL_PET_MEMO".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_DATA_REAMRKS"]."', ";
		$sql .= "'".$dataList["HOTEL_TIME_RECEPT_FROM"]."', ";
		$sql .= "'".$dataList["HOTEL_TIME_RECEPT_TO"]."', ";
		$sql .= "'".$dataList["HOTEL_TIME_CHECKIN_FROM"]."', ";
		$sql .= "'".$dataList["HOTEL_TIME_CHECKIN_TO"]."', ";
		$sql .= "'".$dataList["HOTEL_TIME_CHECKOUT_FROM"]."', ";
		$sql .= "'".$dataList["HOTEL_TIME_CHECKOUT_TO"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["HOTEL_FOOD_DATA".$i]."', ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "'".$dataList["HOTEL_CHILD_LIST".$i]."', ";
		}
		$sql .= "'".$dataList["HOTEL_CHILD_MEMO"]."', ";

		$sql .= "'".$dataList["HOTEL_STAY_LIST"]."', ";
		$sql .= "'".$dataList["HOTEL_STAY_MEMO"]."', ";
		$sql .= "'".$dataList["HOTEL_CARD_FLG"]."', ";
		$sql .= "'".$dataList["HOTEL_CARD_LIST"]."', ";
		$sql .= "'".$dataList["HOTEL_CARD_MEMO"]."', ";
		$sql .= "'".$dataList["HOTEL_CAUTION"]."', ";
		$sql .= "'".$dataList["HOTEL_DISABLED"]."', ";

		$sql .= "'".$dataList["HOTEL_SPA_TAX"]."', ";
		$sql .= "0, ";
		$sql .= "1, ";
		$sql .= "now(), ";
		$sql .= "now()) ";
//	print $sql;
//print_r(debug_backtrace());


		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotel::tableName." set ";
		$sql .= "HOTEL_NAME = '".$dataList["HOTEL_NAME"]."', ";
		$sql .= "HOTEL_NAME_KANA = '".$dataList["HOTEL_NAME_KANA"]."', ";
		$sql .= "HOTEL_CATCHCOPY = '".$dataList["HOTEL_CATCHCOPY"]."', ";
		$sql .= "HOTEL_CUSTOMER_CODE = '".$dataList["HOTEL_CUSTOMER_CODE"]."', ";
		$sql .= "HOTEL_NUMBER = '".$dataList["HOTEL_NUMBER"]."', ";
		$sql .= "HOTEL_SPA = '".$dataList["HOTEL_SPA"]."', ";
		$sql .= "HOTEL_FLG_KIND = '".$dataList["HOTEL_FLG_KIND"]."', ";
		$sql .= "HOTEL_LIST_AREA = '".$dataList["HOTEL_LIST_AREA"]."', ";
		$sql .= "HOTEL_FLG_PUBLIC = '".$dataList["HOTEL_FLG_PUBLIC"]."', ";
		$sql .= "HOTEL_ZIP = '".$dataList["HOTEL_ZIP"]."', ";
		$sql .= "HOTEL_PREF = '".$dataList["HOTEL_PREF"]."', ";
		$sql .= "HOTEL_CITY = '".$dataList["HOTEL_CITY"]."', ";
		$sql .= "HOTEL_ADDRESS = '".$dataList["HOTEL_ADDRESS"]."', ";
		$sql .= "HOTEL_TEL = '".$dataList["HOTEL_TEL"]."', ";
		$sql .= "HOTEL_PIC_APP = '".$dataList["HOTEL_PIC_APP"]."', ";
		$sql .= "HOTEL_DETAIL = '".$dataList["HOTEL_DETAIL"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_PIC_FAC".$i." = '".$dataList["HOTEL_PIC_FAC".$i]."', ";
		}
		$sql .= "HOTEL_LON = '".$dataList["HOTEL_LON"]."', ";
		$sql .= "HOTEL_LAT = '".$dataList["HOTEL_LAT"]."', ";
		$sql .= "HOTEL_ACCESS_SUM = '".$dataList["HOTEL_ACCESS_SUM"]."', ";
		for ($i=1; $i<=3; $i++) {
			$sql .= "HOTEL_STATION".$i." = '".$dataList["HOTEL_STATION".$i]."', ";
		}
		$sql .= "HOTEL_LIST_LOCATION = '".$dataList["HOTEL_LIST_LOCATION"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTEL_ACCESS_PLACE".$i." = '".$dataList["HOTEL_ACCESS_PLACE".$i]."', ";
			$sql .= "HOTEL_ACCESS_HOW".$i." = '".$dataList["HOTEL_ACCESS_HOW".$i]."', ";
			$sql .= "HOTEL_ACCESS_IC".$i." = '".$dataList["HOTEL_ACCESS_IC".$i]."', ";
			$sql .= "HOTEL_ACCESS_IC_TO".$i." = '".$dataList["HOTEL_ACCESS_IC_TO".$i]."', ";
			$sql .= "HOTEL_ACCESS_IC_FROM".$i." = '".$dataList["HOTEL_ACCESS_IC_FROM".$i]."', ";
		}

		$sql .= "HOTEL_PARKING = '".$dataList["HOTEL_PARKING"]."', ";
		$sql .= "HOTEL_PARKING_MEMO = '".$dataList["HOTEL_PARKING_MEMO"]."', ";
		$sql .= "HOTEL_SEND = '".$dataList["HOTEL_SEND"]."', ";
		$sql .= "HOTEL_SEND_REMARKS = '".$dataList["HOTEL_SEND_REMARKS"]."', ";
		$sql .= "HOTEL_ACCESS_REMARKS = '".$dataList["HOTEL_ACCESS_REMARKS"]."', ";
		$sql .= "HOTEL_ACCESS_REMARKS_CAR = '".$dataList["HOTEL_ACCESS_REMARKS_CAR"]."', ";
		for ($i=1; $i<=49; $i++) {
			if ($i == 28 or $i == 27) {
				$sql .= "HOTEL_ROOM_DATA".$i." = '".$dataList["HOTEL_ROOM_DATA".$i]."', ";
			}
			else {
				$sql .= "HOTEL_ROOM_DATA".$i." = '".$dataList["HOTEL_ROOM_DATA".$i]."', ";
			}
		}
		for ($i=1; $i<=9; $i++) {
			$sql .= "HOTEL_ROOM_LIST".$i." = '".$dataList["HOTEL_ROOM_LIST".$i]."', ";
		}
		$sql .= "HOTEL_ROOM_REMARKS = '".$dataList["HOTEL_ROOM_REMARKS"]."', ";
		$sql .= "HOTEL_SPA_REMARKS = '".$dataList["HOTEL_SPA_REMARKS"]."', ";
		$sql .= "HOTEL_SPA_REMARKS2 = '".$dataList["HOTEL_SPA_REMARKS2"]."', ";
		$sql .= "HOTEL_SPA_NAME = '".$dataList["HOTEL_SPA_NAME"]."', ";
		$sql .= "HOTEL_SPA_FLG = '".$dataList["HOTEL_SPA_FLG"]."', ";
		$sql .= "HOTEL_SPA_KIND = '".$dataList["HOTEL_SPA_KIND"]."', ";
		for ($i=1; $i<=14; $i++) {
			$sql .= "HOTEL_SPA_DATA".$i." = '".$dataList["HOTEL_SPA_DATA".$i]."', ";
		}
		$sql .= "HOTEL_SPA_DATA15 = '".$dataList["HOTEL_SPA_DATA15"]."', ";
		for ($i=1; $i<=17; $i++) {
			$sql .= "HOTEL_AMENITY_DATA".$i." = '".$dataList["HOTEL_AMENITY_DATA".$i]."', ";
		}
		$sql .= "HOTEL_AMENITY_LIST = '".$dataList["HOTEL_AMENITY_LIST"]."', ";
		$sql .= "HOTEL_AMENITY_MEMO = '".$dataList["HOTEL_AMENITY_MEMO"]."', ";
		for ($i=1; $i<=20; $i++) {
			$sql .= "HOTEL_FACILITY_DATA".$i." = '".$dataList["HOTEL_FACILITY_DATA".$i]."', ";
		}
		for ($i=1; $i<=10; $i++) {
			$sql .= "HOTEL_FACILITY_LIST".$i." = '".$dataList["HOTEL_FACILITY_LIST".$i]."', ";
		}
		$sql .= "HOTEL_FACILITY_MEMO = '".$dataList["HOTEL_FACILITY_MEMO"]."', ";
		for ($i=1; $i<=2; $i++) {
			$sql .= "HOTEL_FACILITY_NUM".$i." = '".$dataList["HOTEL_FACILITY_NUM".$i]."', ";
			$sql .= "HOTEL_FACILITY_FROM".$i." = '".$dataList["HOTEL_FACILITY_FROM".$i]."', ";
			$sql .= "HOTEL_FACILITY_TO".$i." = '".$dataList["HOTEL_FACILITY_TO".$i]."', ";
		}
		for ($i=1; $i<=30; $i++) {
			$sql .= "HOTEL_SERVICE_DATA".$i." = '".$dataList["HOTEL_SERVICE_DATA".$i]."', ";
		}
		$sql .= "HOTEL_SERVICE_LIST = '".$dataList["HOTEL_SERVICE_LIST"]."', ";
		$sql .= "HOTEL_LIST_PET = '".$dataList["HOTEL_LIST_PET"]."', ";
		$sql .= "HOTEL_PET_MEMO = '".$dataList["HOTEL_PET_MEMO"]."', ";
		for ($i=2; $i<=6; $i++) {
			$sql .= "HOTEL_PET_MEMO".$i." = '".$dataList["HOTEL_PET_MEMO".$i]."', ";
		}
		$sql .= "HOTEL_DATA_REAMRKS = '".$dataList["HOTEL_DATA_REAMRKS"]."', ";
		$sql .= "HOTEL_TIME_RECEPT_FROM = '".$dataList["HOTEL_TIME_RECEPT_FROM"]."', ";
		$sql .= "HOTEL_TIME_RECEPT_TO = '".$dataList["HOTEL_TIME_RECEPT_TO"]."', ";
		$sql .= "HOTEL_TIME_CHECKIN_FROM = '".$dataList["HOTEL_TIME_CHECKIN_FROM"]."', ";
		$sql .= "HOTEL_TIME_CHECKIN_TO = '".$dataList["HOTEL_TIME_CHECKIN_TO"]."', ";
		$sql .= "HOTEL_TIME_CHECKOUT_FROM = '".$dataList["HOTEL_TIME_CHECKOUT_FROM"]."', ";
		$sql .= "HOTEL_TIME_CHECKOUT_TO = '".$dataList["HOTEL_TIME_CHECKOUT_TO"]."', ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_FOOD_DATA".$i." = '".$dataList["HOTEL_FOOD_DATA".$i]."', ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTEL_CHILD_LIST".$i." = '".$dataList["HOTEL_CHILD_LIST".$i]."', ";
		}
		$sql .= "HOTEL_CHILD_MEMO = '".$dataList["HOTEL_CHILD_MEMO"]."', ";

		$sql .= "HOTEL_STAY_LIST = '".$dataList["HOTEL_STAY_LIST"]."', ";
		$sql .= "HOTEL_STAY_MEMO = '".$dataList["HOTEL_STAY_MEMO"]."', ";
		$sql .= "HOTEL_CARD_FLG = '".$dataList["HOTEL_CARD_FLG"]."', ";
		$sql .= "HOTEL_CARD_LIST = '".$dataList["HOTEL_CARD_LIST"]."', ";
		$sql .= "HOTEL_CARD_MEMO = '".$dataList["HOTEL_CARD_MEMO"]."', ";
		$sql .= "HOTEL_CAUTION = '".$dataList["HOTEL_CAUTION"]."', ";
		$sql .= "HOTEL_DISABLED = '".$dataList["HOTEL_DISABLED"]."', ";

		$sql .= "HOTEL_SPA_TAX = '".$dataList["HOTEL_SPA_TAX"]."', ";
		$sql .= "HOTEL_ORDER = '".$dataList["HOTEL_ORDER"]."', ";
		$sql .= "HOTEL_STATUS = '".$dataList["HOTEL_STATUS"]."', ";
		$sql .= "HOTEL_DATE_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  hotel::keyName." = ".parent::getKeyValue() ;
//	print $sql;

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".hotel::tableName." set ";
		$sql .= parent::expsData("HOTEL_STATUS", "=", 3).", ";
		$sql .= parent::expsData("HOTEL_DATE_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotel::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME"), 50)) {
				parent::setError("HOTEL_NAME", "50文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"), 50)) {
				parent::setError("HOTEL_NAME_KANA", "50文字以内で入力して下さい");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTEL_NAME_KANA"), CHK_PTN_KANA)) {
				parent::setError("HOTEL_NAME_KANA", "全角カナで入力して下さい");
			}
		}

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

		if (parent::getByKey(parent::getKeyValue(), "HOTEL_PIC_APP_setup") != "") {
			$this->setByKey($this->getKeyValue(), "HOTEL_PIC_APP", $this->getByKey($this->getKeyValue(), "HOTEL_PIC_APP_setup"));
		}
		else {
			$inputer = new inputs();
			$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
			$msg = $inputer->upload("HOTEL_PIC_APP", IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
			if (!$inputer->getHandle()) {
				if ($msg != "non") {
					parent::setError("HOTEL_PIC_APP", $msg);
				}
				else {
				}
			}
			else {
				parent::setByKey(parent::getKeyValue(), "HOTEL_PIC_APP", $msg);
			}
		}

		for ($i=1; $i<=4; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "HOTEL_PIC_FAC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "HOTEL_PIC_FAC".$i, $this->getByKey($this->getKeyValue(), "HOTEL_PIC_FAC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("HOTEL_PIC_FAC".$i, IMG_HOTEL_FAC_SIZE, IMG_HOTEL_FAC_WIDTH, IMG_HOTEL_FAC_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("HOTEL_PIC_FAC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "HOTEL_PIC_FAC".$i, $msg);
				}

			}
		}

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


	}

	public function setPost($picFLg=false) {
		if ($_POST) {

			/*
			foreach ($_POST as $k=>$v) {
				if ($picFLg) {
					switch ($k) {
						case "HOTEL_PIC_APP":
							continue;
							break;
						case "HOTEL_PIC_FAC1":
							continue;
							break;
						case "HOTEL_PIC_FAC2":
							continue;
							break;
						case "HOTEL_PIC_FAC3":
							continue;
							break;
						case "HOTEL_PIC_FAC4":
							continue;
							break;
						default:
							$this->setByKey($this->getKeyValue(), $k, $v);
					}
				}else {
					$this->setByKey($this->getKeyValue(), $k, $v);
				}
			}
			*/

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			$dataLocation = "";
			if (count($_POST["location"]) > 0) {
				foreach ($_POST["location"] as $d) {
					if ($dataLocation != "") {
						$dataLocation .= ":";
					}
					$dataLocation .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_LIST_LOCATION", ":".$dataLocation.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "HOTEL_LIST_LOCATION", $this->getByKey($this->getKeyValue(), "HOTEL_LIST_LOCATION"));
				$this->setByKey($this->getKeyValue(), "HOTEL_LIST_LOCATION", '');
			}

			$dataInternet = "";
			if (count($_POST["internet"]) > 0) {
				foreach ($_POST["internet"] as $d) {
					if ($dataInternet != "") {
						$dataInternet .= ":";
					}
					$dataInternet .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_ROOM_DATA27", ":".$dataInternet.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "HOTEL_ROOM_DATA27", $this->getByKey($this->getKeyValue(), "HOTEL_ROOM_DATA27"));
				$this->setByKey($this->getKeyValue(), "HOTEL_ROOM_DATA27", '');
			}

			$dataPet = "";
			if (count($_POST["pet"]) > 0) {
				foreach ($_POST["pet"] as $d) {
					if ($dataPet != "") {
						$dataPet .= ":";
					}
					$dataPet .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_LIST_PET", ":".$dataPet.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "HOTEL_LIST_PET", $this->getByKey($this->getKeyValue(), "HOTEL_LIST_PET"));
				$this->setByKey($this->getKeyValue(), "HOTEL_LIST_PET", '');
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_LIST_AREA", ":".$dataArea.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "HOTEL_LIST_AREA", $this->getByKey($this->getKeyValue(), "HOTEL_LIST_AREA"));
				$this->setByKey($this->getKeyValue(), "HOTEL_LIST_AREA", '');
			}

			$dataService = "";
			if (count($_POST["service"]) > 0) {
				foreach ($_POST["service"] as $d) {
					if ($dataService != "") {
						$dataService .= ":";
					}
					$dataService .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_SERVICE_LIST", ":".$dataService.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_SERVICE_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_SERVICE_LIST"));
				$this->setByKey($this->getKeyValue(), "HOTEL_SERVICE_LIST", '');
			}

			for ($i=1; $i<=9; $i++) {
				$dataRoomList = "";
				if (count($_POST["roomlist".$i]) > 0) {
					foreach ($_POST["roomlist".$i] as $d) {
						if ($dataRoomList != "") {
							$dataRoomList .= ":";
						}
						$dataRoomList .= $d;
					}
					$this->setByKey($this->getKeyValue(), "HOTEL_ROOM_LIST".$i, ":".$dataRoomList.":");
				}
				else {
// 					$this->setByKey($this->getKeyValue(), "HOTEL_ROOM_LIST".$i, $this->getByKey($this->getKeyValue(), "HOTEL_ROOM_LIST".$i));
					$this->setByKey($this->getKeyValue(), "HOTEL_ROOM_LIST".$i, '');
				}
			}

			for ($i=1; $i<=10; $i++) {
				$dataFacilitylist = "";
				if (count($_POST["facilitylist".$i]) > 0) {
					foreach ($_POST["facilitylist".$i] as $d) {
						if ($dataFacilitylist != "") {
							$dataFacilitylist .= ":";
						}
						$dataFacilitylist .= $d;
					}
					$this->setByKey($this->getKeyValue(), "HOTEL_FACILITY_LIST".$i, ":".$dataFacilitylist.":");
				}
				else {
// 					$this->setByKey($this->getKeyValue(), "HOTEL_FACILITY_LIST".$i, $this->getByKey($this->getKeyValue(), "HOTEL_FACILITY_LIST".$i));
					$this->setByKey($this->getKeyValue(), "HOTEL_FACILITY_LIST".$i, '');
				}
			}

			$dataAemnity = "";
			if (count($_POST["amenity"]) > 0) {
				foreach ($_POST["amenity"] as $d) {
					if ($dataAemnity != "") {
						$dataAemnity .= ":";
					}
					$dataAemnity .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", ":".$dataAemnity.":");
			}
			else {
// 				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST"));
				$this->setByKey($this->getKeyValue(), "HOTEL_AMENITY_LIST", '');
			}

			for ($i=1; $i<=4; $i++) {
				$datachildlist = "";
				if (count($_POST["child".$i]) > 0) {
					foreach ($_POST["child".$i] as $d) {
						if ($datachildlist != "") {
							$datachildlist .= ":";
						}
						$datachildlist .= $d;
					}
					$this->setByKey($this->getKeyValue(), "HOTEL_CHILD_LIST".$i, ":".$datachildlist.":");
				}
				else {
					//$this->setByKey($this->getKeyValue(), "HOTEL_CHILD_LIST".$i, $this->getByKey($this->getKeyValue(), "HOTEL_CHILD_LIST".$i));
					$this->setByKey($this->getKeyValue(), "HOTEL_CHILD_LIST".$i, '');
				}
			}

			$dataStay = "";
			if (count($_POST["stay"]) > 0) {
				foreach ($_POST["stay"] as $d) {
					if ($dataStay != "") {
						$dataStay .= ":";
					}
					$dataStay .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_STAY_LIST", ":".$dataStay.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "HOTEL_STAY_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_STAY_LIST"));
				$this->setByKey($this->getKeyValue(), "HOTEL_STAY_LIST", '');
			}

			$dataCard = "";
			if (count($_POST["card"]) > 0) {
				foreach ($_POST["card"] as $d) {
					if ($dataCard != "") {
						$dataCard .= ":";
					}
					$dataCard .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_CARD_LIST", ":".$dataCard.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "HOTEL_CARD_LIST", $this->getByKey($this->getKeyValue(), "HOTEL_CARD_LIST"));
				$this->setByKey($this->getKeyValue(), "HOTEL_CARD_LIST", '');
			}

			$dataDisabled = "";
			if (count($_POST["disabled"]) > 0) {
				foreach ($_POST["disabled"] as $d) {
					if ($dataDisabled != "") {
						$dataDisabled .= ":";
					}
					$dataDisabled .= $d;
				}
				$this->setByKey($this->getKeyValue(), "HOTEL_DISABLED", ":".$dataDisabled.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "HOTEL_DISABLED", $this->getByKey($this->getKeyValue(), "HOTEL_DISABLED"));
				$this->setByKey($this->getKeyValue(), "HOTEL_DISABLED", '');
			}

		}

	}


}
?>