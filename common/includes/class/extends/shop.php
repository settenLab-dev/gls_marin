<?php
class shop extends collection {
	const tableName = "SHOP";
	const keyName = "COMPANY_ID";
	const tableKeyName = "COMPANY_ID";

	public function shop($db) {
		parent::collection($db);
	}

	// 検索
	public function selectListPublicPlan($collection)  {


		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "search_date") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "search_date"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

		//	合計人数
		$checkNum = $this->resStayNum($collection);

		$sql  = "select ";
	//	$sql .= "SQL_CALC_FOUND_ROWS ";

		//	ショップ
		$sql .= "ct.COMPANY_ID, ";
		$sql .= "st.SHOP_ORDER, ";
		$sql .= "st.SHOP_NAME, ";
		$sql .= "st.SHOP_TEXT, ";
		$sql .= "st.SHOP_OPENTIME, ";
		$sql .= "st.SHOP_ADDRESS, ";
		for ($i=1; $i<=9; $i++) {
			$sql .= "st.SHOP_FACILITY".$i.", ";
		}
		$sql .= "st.SHOP_LANG_FLG, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "st.SHOP_LANG_TYPE".$i.", ";
		}
		for ($i=1; $i<=7; $i++) {
			$sql .= "st.SHOP_CHILD".$i.", ";
		}


		//	プラン
		$sql .= "spt.SHOPPLAN_ID, ";
		$sql .= "spt.SHOPPLAN_NAME, ";
		$sql .= "spt.SHOPPLAN_CATCH, ";
		$sql .= "spt.SHOPPLAN_CATEGORY1, ";
		$sql .= "spt.SHOPPLAN_CATEGORY2, ";
		$sql .= "spt.SHOPPLAN_CATEGORY3, ";
		$sql .= "spt.SHOPPLAN_CATEGORY_DETAIL, ";

		$sql .= "spt.SHOPPLAN_DISCRIPTION, ";
		$sql .= "spt.SHOPPLAN_INCLUDE, ";
		$sql .= "spt.SHOPPLAN_OPTION, ";
		$sql .= "spt.SHOPPLAN_GUIDE_FLG, ";

		$sql .= "spt.SHOPPLAN_SALE_FROM, ";
		$sql .= "spt.SHOPPLAN_SALE_TO, ";

		$sql .= "spt.SHOPPLAN_DEPARTS_MIN, ";
		$sql .= "spt.SHOPPLAN_ENTRY_FROM, ";
		$sql .= "spt.SHOPPLAN_ENTRY_TO, ";
		$sql .= "spt.SHOPPLAN_AGE_FROM, ";
		$sql .= "spt.SHOPPLAN_AGE_TO, ";

		$sql .= "spt.SHOPPLAN_PARENT1, ";
		$sql .= "spt.SHOPPLAN_PARENT2, ";

		$sql .= "spt.SHOPPLAN_MEET_PLACE1, ";
		$sql .= "spt.SHOPPLAN_MEET_PLACE2, ";
		$sql .= "spt.SHOPPLAN_MEET_PLACE3, ";
		$sql .= "spt.SHOPPLAN_PICKUP, ";
		$sql .= "spt.SHOPPLAN_PLAY_PLACE, ";

		$sql .= "spt.SHOPPLAN_AREA_LIST1, ";
		$sql .= "spt.SHOPPLAN_AREA_LIST2, ";
		$sql .= "spt.SHOPPLAN_AREA_LIST3, ";

		for ($i=1; $i<=12; $i++) {
			$sql .= "spt.SHOPPLAN_MEET_TIMEHOUR".$i.", ";
			$sql .= "spt.SHOPPLAN_MEET_TIMEMIN".$i.", ";
			$sql .= "spt.SHOPPLAN_PRICETYPE".$i.", ";
			$sql .= "spt.SHOPPLAN_ROOM".$i.", ";
		}

		$sql .= "spt.SHOPPLAN_USE_TIME, ";
		$sql .= "spt.SHOPPLAN_TAG_LIST, ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "spt.SHOPPLAN_SCEDULE_TITLE".$i.", ";
			$sql .= "spt.SHOPPLAN_SCEDULE_TIME".$i.", ";
			$sql .= "spt.SHOPPLAN_STOP".$i.", ";
		}

		$sql .= "spt.SHOPPLAN_GUEST_PREPARATION, ";
		$sql .= "spt.SHOPPLAN_ETC, ";

		$sql .= "spt.SHOPPLAN_CRAFT1, ";
		$sql .= "spt.SHOPPLAN_CRAFT2, ";

		$sql .= "spt.SHOPPLAN_ALL_TIME, ";
		$sql .= "spt.SHOPPLAN_PLAY_TIME, ";

		$sql .= "spt.SHOPPLAN_LISENCE, ";
		$sql .= "spt.SHOPPLAN_CAUTION, ";

		for ($i=1; $i<=6; $i++) {
			$sql .= "spt.SHOPPLAN_PIC".$i.", ";
		}
		$sql .= "spt.SHOPPLAN_RESERVE, ";
		$sql .= "spt.SHOPPLAN_SELL_PRICE, ";
		$sql .= "spt.SHOPPLAN_DEAL_PRICE, ";
		$sql .= "spt.SHOPPLAN_DEAL_SP, ";

		$sql .= "spt.SHOPPLAN_PROVIDE_FLG, ";
		$sql .= "spt.SHOPPLAN_PROVIDE_MAX, ";
		$sql .= "spt.SHOPPLAN_PROVIDE_SELL, ";

		$sql .= "spt.SHOPPLAN_DEALNUM_FLG, ";
		$sql .= "spt.SHOPPLAN_DEALNUM_MIN, ";
		$sql .= "spt.SHOPPLAN_DEALNUM_MAX, ";
		$sql .= "spt.SHOPPLAN_DEALPER_FLG, ";
		$sql .= "spt.SHOPPLAN_DEALPER_MIN, ";
		$sql .= "spt.SHOPPLAN_DEALPER_MAX, ";

		$sql .= "spt.SHOPPLAN_USE, ";
		$sql .= "spt.SHOPPLAN_USE_FROM, ";
		$sql .= "spt.SHOPPLAN_USE_TO, ";
		$sql .= "spt.SHOPPLAN_USE_MEMO, ";

		$sql .= "spt.SHOPPLAN_PAYMENT1, ";
		$sql .= "spt.SHOPPLAN_PAYMENT2, ";
		$sql .= "spt.SHOPPLAN_PAYMENT3, ";
		$sql .= "spt.SHOPPLAN_PAYMENT4, ";
		$sql .= "spt.SHOPPLAN_PAYMENT5, ";

		$sql .= "spt.SHOPPLAN_ACC_DAY, ";
		$sql .= "spt.SHOPPLAN_ACC_HOUR, ";
		$sql .= "spt.SHOPPLAN_ACC_MIN, ";

		$sql .= "spt.SHOPPLAN_CAN_DAY, ";
		$sql .= "spt.SHOPPLAN_CAN_HOUR, ";
		$sql .= "spt.SHOPPLAN_CAN_MIN, ";

		$sql .= "spt.SHOPPLAN_FLG_CANCEL, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "spt.SHOPPLAN_CANCEL_FLG".$i.", ";
			$sql .= "spt.SHOPPLAN_CANCEL_MONEY".$i.", ";
			if ($i >= 3) {
				$sql .= "spt.SHOPPLAN_CANCEL_FROM".$i.", ";
				$sql .= "spt.SHOPPLAN_CANCEL_TO".$i.", ";
			}
		}
		$sql .= "spt.SHOPPLAN_QUESTION, ";
		$sql .= "spt.SHOPPLAN_QUESTION_REC, ";
		$sql .= "spt.SHOPPLAN_DEMAND, ";


		//	在庫タイプ
		for ($i=1; $i<=12; $i++) {
		$sql .= "rt".$i.".ROOM_ID as ROOM_ID".$i.", ";
		}
	//	$sql .= "hprovt.ROOM_NAME ";

		//	料金タイプ
		for ($i=1; $i<=12; $i++) {
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_ID as SHOP_PRICETYPE_ID".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_KIND as SHOP_PRICETYPE_KIND".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND1 as SHOP_PRICETYPE_MONEYKIND1".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND2 as SHOP_PRICETYPE_MONEYKIND2".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND3 as SHOP_PRICETYPE_MONEYKIND3".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND4 as SHOP_PRICETYPE_MONEYKIND4".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND5 as SHOP_PRICETYPE_MONEYKIND5".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND6 as SHOP_PRICETYPE_MONEYKIND6".$i.", ";
			$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND7 as SHOP_PRICETYPE_MONEYKIND7".$i.", ";
		//	$sql .= "hpayt".$i.".SHOP_PRICETYPE_MONEYKIND8 as SHOP_PRICETYPE_MONEYKIND8".$i.", ";	
		}
		$sql .= "spt.SHOPPLAN_ORDER ";

		$sql .= $this->resFrom($collection);
		//	検索件数対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
			//	$sql .= "and ".parent::expsData("h.COMPANY_ID", "in", "(".$collection->getByKey($collection->getKeyValue(), "targetId")).") ";
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and st.COMPANY_ID in ($CID) ";
			}
		}

		$where = "";
		$where = $this->resWhere($collection);

		print $where;


		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		//  検索方法でgroup分化
			//  ショップで検索
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
			$sql .= "group by spt.SHOPPLAN_ID, ct.COMPANY_ID ";
		}
			//  プランで検索
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
			$sql .= "group by spt.SHOPPLAN_ID ";
		}

		$having = "";

		//==========================================================================

	//	print $sql;
		$sql = "(".$sql.") ";

		$sql .= "order by spt.SHOPPLAN_ORDER ";

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

	//	申し込みの最大人数
	private function resStayNum($collection) {
		//	宿泊人数
		$checkNum = 0;
		for ($roomNum=1; $roomNum<=1; $roomNum++) {
			//	大人数
			if($checkNum <= intval($collection->getByKey($collection->getKeyValue(), "priceper_num"))){
				$checkNum = intval($collection->getByKey($collection->getKeyValue(), "priceper_num"));
			}
		}

		if($checkNum == 0){
			$checkNum=1;
		}

		return $checkNum;
	}
	
	//	各部屋の人数
	private function resEveryRoomStayNum($collection) {
			$checkNum = 0;
//			print_r($collection);
			for ($roomNum=1; $roomNum<=1; $roomNum++) {
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
		//$checkNum = $this->resStayNum($collection);

		//	適用する○人用料金
		//$money_1 = $this->resStay1Money($collection);


		$sql = "select ";

		//	ショップ
		$sql .= "st.COMPANY_ID, ";
		$sql .= "st.SHOP_NAME, ";
		$sql .= "st.SHOP_ORDER ";
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

		$sql .= "group by st.COMPANY_ID ";
// 		$sql .= "group by sp.SHOPPLAN_ID, r.ROOM_ID ";

		$having = "";

		//=======================================================

		$sqlcc = $sql;

		$sql = "select ";
		$sql .= "SQL_CALC_FOUND_ROWS * from ";
		$sql .= "(".$sqlcc.") as UNI ";

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


		//$checkNum = $this->resStayNum($collection);

		// 現在の日付
		$DATE_S = date("Y-m-d");

		//	▼ショップ情報テーブル
		$sql .= "from (select ";
		$sql .= "s.COMPANY_ID, ";
		$sql .= "s.SHOP_ORDER, ";
		$sql .= "s.SHOP_AREA_LIST, ";
		$sql .= "s.SHOP_CATEGORY_LIST, ";
		$sql .= "s.SHOP_NAME, ";
		$sql .= "s.SHOP_NAME_KANA, ";
		$sql .= "s.SHOP_TEL, ";
		$sql .= "s.SHOP_ADDRESS, ";
		$sql .= "s.SHOP_OPENTIME, ";
		$sql .= "s.SHOP_CLOSEDAY, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "s.SHOP_PIC".$i.", ";
			$sql .= "s.SHOP_PIC_TEXT".$i.", ";
		}
		for ($i=1; $i<=9; $i++) {
			$sql .= "s.SHOP_FACILITY".$i.", ";
		}
		$sql .= "s.SHOP_LANG_FLG, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "s.SHOP_LANG_TYPE".$i.", ";
		}
		for ($i=1; $i<=7; $i++) {
			$sql .= "s.SHOP_CHILD".$i.", ";
		}
		$sql .= "s.SHOP_TEXT, ";
		$sql .= "s.SHOP_REGIST, ";
 		$sql .= "s.SHOP_STATUS ";

		$sql .= "from SHOP s ";
		
//		$sql .= "where ";
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "where s.COMPANY_ID in ($CID) ";
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
			$sql .= "s.SHOP_AREA_LIST like '$AREA_S' ";
		}
		//	カテゴリ
		if ($collection->getByKey($collection->getKeyValue(), "category") != "") {
			if ($CID != ""){
			  $sql .= "and ";
			}
			elseif ($AREA_S != "") {
			  $sql .= "and ";
			}
			else {
			  $sql .= "where ";
			}
			$CATE_S = "%:".$collection->getByKey($collection->getKeyValue(), "category").":%";
			$sql .= "s.SHOP_CATEGORY_LIST like '$CATE_S' ";
		}

		//	ショップID
		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			$COMPANY_S = $collection->getByKey($collection->getKeyValue(), "COMPANY_ID");
			$sql .= "where s.COMPANY_ID = '$COMPANY_S' ";
			$where_flg_company = true;
		}
		//	キーワード検索
		if ($collection->getByKey($collection->getKeyValue(), "free") != "") {
			if ($AREA_S != ""){
			  $sql .= "and ";
			}
			elseif ($CATE_S != "") {
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
			$sql .= "(s.SHOP_NAME like '$FREE_S' ";
			$sql .= "or s.SHOP_NAME_KANA like '$FREE_S' ";
			$sql .= "or s.SHOP_TEXT like '$FREE_S') ";
		}

		$sql .= ") st ";


		//	▼クライアント情報テーブル
		$sql .= "inner join (select ";
		$sql .= "c.COMPANY_ID ";
		$sql .= "from COMPANY c ";
		$sql .= "where ";
		$sql .= "c.COMPANY_STATUS = 2 ";
		$sql .= "and c.COMPANY_FUNC_HOTERL = 1 ";
		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and c.COMPANY_ID in ($CID) ";
 			}
 		}
		$sql .= ") ct ";
		$sql .= "on st.COMPANY_ID = ct.COMPANY_ID ";


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
		$sql .= "on st.COMPANY_ID = bt.COMPANY_ID ";
 

		//	▼プラン情報テーブル
		$sql .= "inner join (select ";
		$sql .= "sp.COMPANY_ID, ";
		$sql .= "sp.SHOP_ID, ";
		$sql .= "sp.SHOPPLAN_ID, ";

		$sql .= "sp.SHOPPLAN_FLG, ";
		$sql .= "sp.SHOPPLAN_LANG_FLG, ";

		$sql .= "sp.SHOPPLAN_NAME, ";
		$sql .= "sp.SHOPPLAN_CATCH, ";
		$sql .= "sp.SHOPPLAN_CATEGORY1, ";
		$sql .= "sp.SHOPPLAN_CATEGORY2, ";
		$sql .= "sp.SHOPPLAN_CATEGORY3, ";
		$sql .= "sp.SHOPPLAN_CATEGORY_DETAIL, ";

		$sql .= "sp.SHOPPLAN_DISCRIPTION, ";
		$sql .= "sp.SHOPPLAN_INCLUDE, ";
		$sql .= "sp.SHOPPLAN_OPTION, ";
		$sql .= "sp.SHOPPLAN_GUIDE_FLG, ";

		$sql .= "sp.SHOPPLAN_SALE_FROM, ";
		$sql .= "sp.SHOPPLAN_SALE_TO, ";

		$sql .= "sp.SHOPPLAN_DEPARTS_MIN, ";
		$sql .= "sp.SHOPPLAN_ENTRY_FROM, ";
		$sql .= "sp.SHOPPLAN_ENTRY_TO, ";
		$sql .= "sp.SHOPPLAN_AGE_FROM, ";
		$sql .= "sp.SHOPPLAN_AGE_TO, ";

		$sql .= "sp.SHOPPLAN_PARENT1, ";
		$sql .= "sp.SHOPPLAN_PARENT2, ";

		$sql .= "sp.SHOPPLAN_MEET_PLACE1, ";
		$sql .= "sp.SHOPPLAN_MEET_PLACE2, ";
		$sql .= "sp.SHOPPLAN_MEET_PLACE3, ";
		$sql .= "sp.SHOPPLAN_PICKUP, ";
		$sql .= "sp.SHOPPLAN_PLAY_PLACE, ";

		$sql .= "sp.SHOPPLAN_AREA_LIST1, ";
		$sql .= "sp.SHOPPLAN_AREA_LIST2, ";
		$sql .= "sp.SHOPPLAN_AREA_LIST3, ";

		for ($i=1; $i<=12; $i++) {
			$sql .= "sp.SHOPPLAN_MEET_TIMEHOUR".$i.", ";
			$sql .= "sp.SHOPPLAN_MEET_TIMEMIN".$i.", ";
			$sql .= "sp.SHOPPLAN_PRICETYPE".$i.", ";
			$sql .= "sp.SHOPPLAN_ROOM".$i.", ";
		}

		$sql .= "sp.SHOPPLAN_USE_TIME, ";
		$sql .= "sp.SHOPPLAN_TAG_LIST, ";

		for ($i=1; $i<=8; $i++) {
			$sql .= "sp.SHOPPLAN_SCEDULE_TITLE".$i.", ";
			$sql .= "sp.SHOPPLAN_SCEDULE_TIME".$i.", ";
			$sql .= "sp.SHOPPLAN_STOP".$i.", ";
		}

		$sql .= "sp.SHOPPLAN_GUEST_PREPARATION, ";
		$sql .= "sp.SHOPPLAN_ETC, ";

		$sql .= "sp.SHOPPLAN_CRAFT1, ";
		$sql .= "sp.SHOPPLAN_CRAFT2, ";

		$sql .= "sp.SHOPPLAN_ALL_TIME, ";
		$sql .= "sp.SHOPPLAN_PLAY_TIME, ";

		$sql .= "sp.SHOPPLAN_LISENCE, ";
		$sql .= "sp.SHOPPLAN_CAUTION, ";

		for ($i=1; $i<=6; $i++) {
			$sql .= "sp.SHOPPLAN_PIC".$i.", ";
		}
		$sql .= "sp.SHOPPLAN_RESERVE, ";
		$sql .= "sp.SHOPPLAN_SELL_PRICE, ";
		$sql .= "sp.SHOPPLAN_DEAL_PRICE, ";
		$sql .= "sp.SHOPPLAN_DEAL_SP, ";

		$sql .= "sp.SHOPPLAN_PROVIDE_FLG, ";
		$sql .= "sp.SHOPPLAN_PROVIDE_MAX, ";
		$sql .= "sp.SHOPPLAN_PROVIDE_SELL, ";

		$sql .= "sp.SHOPPLAN_DEALNUM_FLG, ";
		$sql .= "sp.SHOPPLAN_DEALNUM_MIN, ";
		$sql .= "sp.SHOPPLAN_DEALNUM_MAX, ";
		$sql .= "sp.SHOPPLAN_DEALPER_FLG, ";
		$sql .= "sp.SHOPPLAN_DEALPER_MIN, ";
		$sql .= "sp.SHOPPLAN_DEALPER_MAX, ";

		$sql .= "sp.SHOPPLAN_USE, ";
		$sql .= "sp.SHOPPLAN_USE_FROM, ";
		$sql .= "sp.SHOPPLAN_USE_TO, ";
		$sql .= "sp.SHOPPLAN_USE_MEMO, ";

		$sql .= "sp.SHOPPLAN_PAYMENT1, ";
		$sql .= "sp.SHOPPLAN_PAYMENT2, ";
		$sql .= "sp.SHOPPLAN_PAYMENT3, ";
		$sql .= "sp.SHOPPLAN_PAYMENT4, ";
		$sql .= "sp.SHOPPLAN_PAYMENT5, ";

		$sql .= "sp.SHOPPLAN_ACC_DAY, ";
		$sql .= "sp.SHOPPLAN_ACC_HOUR, ";
		$sql .= "sp.SHOPPLAN_ACC_MIN, ";

		$sql .= "sp.SHOPPLAN_CAN_DAY, ";
		$sql .= "sp.SHOPPLAN_CAN_HOUR, ";
		$sql .= "sp.SHOPPLAN_CAN_MIN, ";

		$sql .= "SHOPPLAN_FLG_CANCEL, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "sp.SHOPPLAN_CANCEL_FLG".$i.", ";
			$sql .= "sp.SHOPPLAN_CANCEL_MONEY".$i.", ";
			if ($i >= 3) {
				$sql .= "sp.SHOPPLAN_CANCEL_FROM".$i.", ";
				$sql .= "sp.SHOPPLAN_CANCEL_TO".$i.", ";
			}
		}
		$sql .= "sp.SHOPPLAN_QUESTION, ";
		$sql .= "sp.SHOPPLAN_QUESTION_REC, ";
		$sql .= "sp.SHOPPLAN_DEMAND, ";

		$sql .= "sp.SHOPPLAN_ORDER, ";
		$sql .= "sp.SHOPPLAN_STATUS, ";
		$sql .= "sp.SHOPPLAN_REGSIT ";

		$sql .= "from SHOPPLAN sp ";
		$sql .= "where ";
		$sql .= "sp.SHOPPLAN_STATUS = 2 ";
		if ($collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID") != "") {
			$PLAN_S = $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
			$sql .= "and sp.SHOPPLAN_ID = $PLAN_S ";
		}

		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "and sp.COMPANY_ID in ($CID) ";
 			}
 		}


		//	キーワード検索 161226追加
		if ($collection->getByKey($collection->getKeyValue(), "free") != "") {
			$FREE_S = "%".$collection->getByKey($collection->getKeyValue(), "free")."%";
			$sql .= "and (sp.SHOPPLAN_NAME like '$FREE_S' ";
			$sql .= "or sp.SHOPPLAN_CATCH like '$FREE_S' ";
			$sql .= "or sp.SHOPPLAN_DISCRIPTION like '$FREE_S') ";
		}


		//	プランの申し込み人数の範囲内にあるかどうか(priceper_num=合計人数または人数範囲）
		if ($collection->getByKey($collection->getKeyValue(), "priceper_num") != "") {

			$ENTRY_NUM = $collection->getByKey($collection->getKeyValue(), "priceper_num");

			//SHOP_PRICETYPE_FLGによって変動さす
			$sql .= "and ('$ENTRY_NUM' between sp.SHOPPLAN_ENTRY_FROM and sp.SHOPPLAN_ENTRY_TO) ";
		}



		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
		//	プラン販売期間
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and ('$DATE_S' between sp.SHOPPLAN_SALE_FROM and sp.SHOPPLAN_SALE_TO) ";
			}
			
		}
		else {
			//	指定日
			//	プラン販売期間
//			$sql .= "".parent::expsData("sp.SHOPPLAN_DATE_SALE_FROM", "<=", $date, true)." ";
//			$sql .= "and ".parent::expsData("sp.SHOPPLAN_DATE_SALE_TO", ">=", $date, true)." ";
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and '$DATE_S' between sp.SHOPPLAN_SALE_FROM and sp.SHOPPLAN_SALE_TO ";
			}
		}

		//　予約締め切り時間チェック
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") != 1) {
			//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "and DATEDIFF('".$date."','".date("Y-m-d")."') > sp.SHOPPLAN_ACC_DAY ";
				$sql .= "or DATEDIFF('".$date."','".date("Y-m-d")."') = sp.SHOPPLAN_ACC_DAY ";

			/*--2015-10-08追加（牛腸）--*/
				//if($date == date("Y-m-d")){

				//現在時刻を6～29時形式に変換

					$time_hour = date('H');
					$time_min = date('i');

				//締切時間の変換と比較
					$sql .= "and concat(case when sp.SHOPPLAN_ACC_HOUR = '1' then '5' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '2' then '6' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '3' then '7' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '4' then '8' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '5' then '9' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '6' then '10' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '7' then '11' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '8' then '12' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '9' then '13' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '10' then '14' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '11' then '15' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '12' then '16' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '13' then '17' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '14' then '18' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '15' then '19' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '16' then '20' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '17' then '21' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '18' then '22' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '19' then '23' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '20' then '24' ";
					$sql .= "else '' end)";
					$sql .= " >= ".$time_hour." ";

				//締切時間の変換と比較
					$sql .= "or concat(case when sp.SHOPPLAN_ACC_HOUR = '1' then '5' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '2' then '6' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '3' then '7' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '4' then '8' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '5' then '9' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '6' then '10' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '7' then '11' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '8' then '12' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '9' then '13' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '10' then '14' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '11' then '15' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '12' then '16' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '13' then '17' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '14' then '18' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '15' then '19' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '16' then '20' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '17' then '21' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '18' then '22' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '19' then '23' ";
					$sql .= "when sp.SHOPPLAN_ACC_HOUR = '20' then '24' ";
					$sql .= "else '' end)";
					$sql .= " >= ".$time_hour." ";

					$sql .= "and concat(case when sp.SHOPPLAN_ACC_MIN = '1' then '00' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '2' then '05' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '3' then '10' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '4' then '15' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '5' then '20' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '6' then '25' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '7' then '30' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '8' then '35' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '9' then '40' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '10' then '45' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '11' then '50' ";
					$sql .= "when sp.SHOPPLAN_ACC_MIN = '12' then '55' ";
					$sql .= "else '' end)";

					$sql .= " > ".$time_min." ";


				//}
			/*--2015-10-08追加（牛腸）--*/

				//$sql .= "and date_format('".$date."','%Y%m%d') - date_format('".date("Y-m-d")."','%Y%m%d') >= sp.SHOPPLAN_ACC_DAY ";
			}
		//print $sql;
		}
		//	プラン：最短連泊数
/*		if ($collection->getByKey($collection->getKeyValue(), "night_number") != "") {
			$NIGHT_NUM = $collection->getByKey($collection->getKeyValue(), "night_number");
			$sql .= "and (sp.SHOPPLAN_NIGHTS_FLG1 = 1 or (sp.SHOPPLAN_NIGHTS_FLG1 = 2 and sp.SHOPPLAN_NIGHTS_NUM1 <= '$NIGHT_NUM')) ";
		}
*/
		//	プラン：最長連泊数
/*		if ($collection->getByKey($collection->getKeyValue(), "night_number") != "") {
			$NIGHT_NUM = $collection->getByKey($collection->getKeyValue(), "night_number");
			$sql .= "and (sp.SHOPPLAN_NIGHTS_FLG2 = 1 or (sp.SHOPPLAN_NIGHTS_FLG2 = 2 and sp.SHOPPLAN_NIGHTS_NUM2 >= '$NIGHT_NUM')) ";
		}
*/
		$sql .= ") spt ";
		$sql .= "on st.COMPANY_ID = spt.COMPANY_ID ";

		//	▼料金テーブル
		for ($i=1; $i<=1; $i++) {
		$sql .= "inner join (select ";
		$sql .= "hpay.HOTELPAY_ID, ";
		$sql .= "hpay.COMPANY_ID, ";
		$sql .= "spr.SHOP_PRICETYPE_ID, ";
		$sql .= "hpay.HOTELPAY_DATE, ";

		$sql .= "hpay.HOTELPAY_SERVICE_FLG, ";
		$sql .= "hpay.HOTELPAY_SERVICE, ";
		$sql .= "hpay.HOTELPAY_MONEY_FLG, ";
		$sql .= "hpay.HOTELPAY_REMARKS, ";
//		for ($i=1; $i<=8; $i++) {
			$sql .= "hpay.HOTELPAY_MONEY1, ";
			$sql .= "hpay.HOTELPAY_MONEY2, ";
			$sql .= "hpay.HOTELPAY_MONEY3, ";
			$sql .= "hpay.HOTELPAY_MONEY4, ";
			$sql .= "hpay.HOTELPAY_MONEY5, ";
			$sql .= "hpay.HOTELPAY_MONEY6, ";
			$sql .= "hpay.HOTELPAY_MONEY7, ";
			$sql .= "hpay.HOTELPAY_MONEY8, ";
//		}
		$sql .= "hpay.HOTELPAY_FLG_STOP, ";
		$sql .= "hpay.HOTELPAY_ROOM_NUM, ";
		$sql .= "hpay.HOTELPAY_ROOM_OVER, ";

		$sql .= "spr.SHOP_PRICETYPE_NAME, ";
		$sql .= "spr.SHOP_PRICETYPE_KIND, ";

//		for ($i=1; $i<=7; $i++) {
			$sql .= "spr.SHOP_PRICETYPE_MONEY1, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY1MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY1MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND1, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY2, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY2MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY2MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND2, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY3, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY3MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY3MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND3, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY4, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY4MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY4MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND4, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY5, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY5MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY5MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND5, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY6, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY6MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY6MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND6, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY7, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY7MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY7MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND7, ";
//		}

		$sql .= "spr.SHOP_PRICETYPE_ADDFLG, ";

		$sql .= "spr.SHOP_PRICETYPE_ORDER, ";
		$sql .= "spr.SHOP_PRICETYPE_STATUS ";

		$sql .= "from HOTELPAY hpay  ";
		$sql .= "inner join SHOP_PRICETYPE spr on hpay.SHOP_PRICETYPE_ID = spr.SHOP_PRICETYPE_ID and hpay.COMPANY_ID = spr.COMPANY_ID ";

//		$stayNumEveryRoom = $this->selectNumEveryRoom($collection);
//		for ($i=1; $i<=8; $i++) {
/*
			$sql .= "hpay.HOTELPAY_MONEY1 <> 'x' ";
			$sql .= "and hpay.HOTELPAY_MONEY1 <> '' ";
			$sql .= "and hpay.HOTELPAY_MONEY1 is not null ";
*/
//		}

		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
				$sql .= "where ";

				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "hpay.COMPANY_ID in ($CID) ";
 			}
 		}

		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
				$sql .= "where ";
	 		}
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
			//	$sql .= "hpay.HOTELPAY_DATE >= '$DATE_S'";
				$sql .= "EXISTS (select HOTELPAY_DATE from HOTELPAY hpay2 where hpay2.HOTELPAY_DATE >= '$DATE_S') ";
			}
			
		}
		else {
			//	指定日
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
				$sql .= "where ";
	 		}

			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "hpay.HOTELPAY_DATE = '$date' ";
			}
		}

		$sql .= ") hpayt".$i." ";
		$sql .= "on st.COMPANY_ID = hpayt".$i.".COMPANY_ID ";
		$sql .= "and spt.SHOPPLAN_PRICETYPE".$i." = hpayt".$i.".SHOP_PRICETYPE_ID ";
		}

		for ($i=2; $i<=12; $i++) {
		$sql .= "left join (select ";
		$sql .= "hpay.HOTELPAY_ID, ";
		$sql .= "hpay.COMPANY_ID, ";
		$sql .= "spr.SHOP_PRICETYPE_ID, ";
		$sql .= "hpay.HOTELPAY_DATE, ";

		$sql .= "hpay.HOTELPAY_SERVICE_FLG, ";
		$sql .= "hpay.HOTELPAY_SERVICE, ";
		$sql .= "hpay.HOTELPAY_MONEY_FLG, ";
		$sql .= "hpay.HOTELPAY_REMARKS, ";
//		for ($i=1; $i<=8; $i++) {
			$sql .= "hpay.HOTELPAY_MONEY1, ";
			$sql .= "hpay.HOTELPAY_MONEY2, ";
			$sql .= "hpay.HOTELPAY_MONEY3, ";
			$sql .= "hpay.HOTELPAY_MONEY4, ";
			$sql .= "hpay.HOTELPAY_MONEY5, ";
			$sql .= "hpay.HOTELPAY_MONEY6, ";
			$sql .= "hpay.HOTELPAY_MONEY7, ";
			$sql .= "hpay.HOTELPAY_MONEY8, ";
//		}
		$sql .= "hpay.HOTELPAY_FLG_STOP, ";
		$sql .= "hpay.HOTELPAY_ROOM_NUM, ";
		$sql .= "hpay.HOTELPAY_ROOM_OVER, ";

		$sql .= "spr.SHOP_PRICETYPE_NAME, ";
		$sql .= "spr.SHOP_PRICETYPE_KIND, ";

//		for ($i=1; $i<=7; $i++) {
			$sql .= "spr.SHOP_PRICETYPE_MONEY1, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY1MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY1MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND1, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY2, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY2MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY2MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND2, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY3, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY3MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY3MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND3, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY4, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY4MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY4MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND4, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY5, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY5MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY5MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND5, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY6, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY6MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY6MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND6, ";

			$sql .= "spr.SHOP_PRICETYPE_MONEY7, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY7MIN, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEY7MAX, ";
			$sql .= "spr.SHOP_PRICETYPE_MONEYKIND7, ";
//		}

		$sql .= "spr.SHOP_PRICETYPE_ADDFLG, ";

		$sql .= "spr.SHOP_PRICETYPE_ORDER, ";
		$sql .= "spr.SHOP_PRICETYPE_STATUS ";

		$sql .= "from HOTELPAY hpay  ";
		$sql .= "inner join SHOP_PRICETYPE spr on hpay.SHOP_PRICETYPE_ID = spr.SHOP_PRICETYPE_ID and hpay.COMPANY_ID = spr.COMPANY_ID ";

//		$stayNumEveryRoom = $this->selectNumEveryRoom($collection);

/*			$sql .= "hpay.HOTELPAY_MONEY1 <> 'x' ";
			$sql .= "and hpay.HOTELPAY_MONEY1 <> '' ";
			$sql .= "and hpay.HOTELPAY_MONEY1 is not null ";
*/

		//	検索対象
		if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "company") {
 			if ($collection->getByKey($collection->getKeyValue(), "targetId") != "") {
			$sql .= "where ";

				$CID = $collection->getByKey($collection->getKeyValue(), "targetId");
				$sql .= "hpay.COMPANY_ID in ($CID) ";
 			}
 		}


		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
				$sql .= "where ";
	 		}
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//$sql .= "hpay.HOTELPAY_DATE >= '$DATE_S'";
				$sql .= "EXISTS (select HOTELPAY_DATE from HOTELPAY hpay2 where hpay2.HOTELPAY_DATE >= '$DATE_S') ";

			}
			
		}
		else {
			//	指定日
			//	料金設定日
			if ($collection->getByKey($collection->getKeyValue(), "limitptn") == "plan") {
				$sql .= "where ";
	 		}

			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				$sql .= "hpay.HOTELPAY_DATE = '$date' ";
			}
		}

		$sql .= ") hpayt".$i." ";
		$sql .= "on st.COMPANY_ID = hpayt".$i.".COMPANY_ID ";
		$sql .= "and spt.SHOPPLAN_PRICETYPE".$i." = hpayt".$i.".SHOP_PRICETYPE_ID ";
		}



		//	▼部屋テーブル
		for ($i=1; $i<=1; $i++) {
 		$sql .= "left join (select ";
 		$sql .= "r.COMPANY_ID, ";
 		$sql .= "r.ROOM_ID, ";
 		$sql .= "r.ROOM_NAME, ";
		$sql .= "hprov.HOTELPROVIDE_ID, ";
		$sql .= "hprov.HOTELPROVIDE_DATE, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_STOP, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_REQUEST, ";
		$sql .= "hprov.HOTELPROVIDE_NUM ";
 		$sql .= "from ROOM r ";
 		$sql .= "inner join HOTELPROVIDE hprov on r.COMPANY_ID = hprov.COMPANY_ID and r.ROOM_ID = hprov.ROOM_ID ";

 		$sql .= "where ";
		$sql .= "hprov.HOTELPROVIDE_FLG_STOP = 1 ";

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


		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "zaiko_num");
			//	$sql .= "and hprov.HOTELPROVIDE_DATE >= '$DATE_S' ";
				$sql .= "and EXISTS (select * from HOTELPROVIDE hprov2 where hprov2.HOTELPROVIDE_NUM >= '$ROOM_NUM' and hprov.HOTELPROVIDE_DATE >= '$DATE_S') ";
			}
			
		}
		else {
			//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "zaiko_num");
				$sql .= "and hprov.HOTELPROVIDE_DATE = '$date' ";
				$sql .= "and hprov.HOTELPROVIDE_NUM >= '$ROOM_NUM' ";
			}
		}


			//	在庫の引き落とし数(zaiko_num=合計人数または組数）
			if ($collection->getByKey($collection->getKeyValue(), "zaiko_num") != "") {
				if ($where != "") {
					$where .= "and ";
				}
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "zaiko_num");
				$where .= "(hprov.HOTELPROVIDE_NUM-hprov.HOTELPROVIDE_BOOKEDNUM) >= '$ROOM_NUM' ";
			}

 		$sql .= ") rt".$i." ";
 		$sql .= "on spt.COMPANY_ID = rt".$i.".COMPANY_ID ";
 		$sql .= "and rt".$i.".ROOM_ID = spt.SHOPPLAN_ROOM".$i." ";
// 		$sql .= "and rt.ROOM_ID = hpayt.ROOM_ID ";
 //		$sql .= " and rt.ROOM_ID = hprovt.ROOM_ID ";
		}

		for ($i=2; $i<=12; $i++) {
 		$sql .= "left join (select ";
 		$sql .= "r.COMPANY_ID, ";
 		$sql .= "r.ROOM_ID, ";
 		$sql .= "r.ROOM_NAME, ";
		$sql .= "hprov.HOTELPROVIDE_ID, ";
		$sql .= "hprov.HOTELPROVIDE_DATE, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_STOP, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_REQUEST, ";
		$sql .= "hprov.HOTELPROVIDE_NUM ";
 		$sql .= "from ROOM r ";
 		$sql .= "inner join HOTELPROVIDE hprov on r.COMPANY_ID = hprov.COMPANY_ID and r.ROOM_ID = hprov.ROOM_ID ";

 		$sql .= "where ";
		$sql .= "hprov.HOTELPROVIDE_FLG_STOP = 1 ";

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


		//	販売期間
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == 1) {
			//	指定なし
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "zaiko_num");
			//	$sql .= "and hprov.HOTELPROVIDE_DATE >= '$DATE_S' ";
				$sql .= "and EXISTS (select * from HOTELPROVIDE hprov2 where hprov2.HOTELPROVIDE_NUM >= '$ROOM_NUM' and hprov.HOTELPROVIDE_DATE >= '$DATE_S') ";
			}
			
		}
		else {
			//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "zaiko_num");
				$sql .= "and hprov.HOTELPROVIDE_DATE = '$date' ";
				$sql .= "and hprov.HOTELPROVIDE_NUM >= '$ROOM_NUM' ";
			}
		}


			//	在庫の引き落とし数(zaiko_num=合計人数または組数）
			if ($collection->getByKey($collection->getKeyValue(), "zaiko_num") != "") {
				if ($where != "") {
					$where .= "and ";
				}
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "zaiko_num");
				$where .= "(hprov.HOTELPROVIDE_NUM-hprov.HOTELPROVIDE_BOOKEDNUM) >= '$ROOM_NUM' ";
			}

 		$sql .= ") rt".$i." ";
 		$sql .= "on spt.COMPANY_ID = rt".$i.".COMPANY_ID ";
 		$sql .= "and rt".$i.".ROOM_ID = spt.SHOPPLAN_ROOM".$i." ";
// 		$sql .= "and rt.ROOM_ID = hpayt.ROOM_ID ";
 //		$sql .= " and rt.ROOM_ID = hprovt.ROOM_ID ";
		}



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


		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ct.".shop::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

/*
		if ($collection->getByKey($collection->getKeyValue(), "usetime") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "spt.SHOPPLAN_ALL_TIME <= ".$collection->getByKey($collection->getKeyValue(), "usetime")." ";
		}



		if ($collection->getByKey($collection->getKeyValue(), "area") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "(spt.SHOPPLAN_AREA_LIST1 = ".$collection->getByKey($collection->getKeyValue(), "area")." ";
			$where .= "or spt.SHOPPLAN_AREA_LIST2 = ".$collection->getByKey($collection->getKeyValue(), "area")." ";
			$where .= "or spt.SHOPPLAN_AREA_LIST3 = ".$collection->getByKey($collection->getKeyValue(), "area").") ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "category") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "(spt.SHOPPLAN_CATEGORY1 = ".$collection->getByKey($collection->getKeyValue(), "category")." ";
			$where .= "or spt.SHOPPLAN_CATEGORY2 = ".$collection->getByKey($collection->getKeyValue(), "category")." ";
			$where .= "or spt.SHOPPLAN_CATEGORY3 = ".$collection->getByKey($collection->getKeyValue(), "category")." ";
			$where .= "or spt.SHOPPLAN_CATEGORY_DETAIL = ".$collection->getByKey($collection->getKeyValue(), "category").") ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "priceper_num") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= $collection->getByKey($collection->getKeyValue(), "priceper_num")." between spt.SHOPPLAN_ENTRY_FROM and spt.SHOPPLAN_ENTRY_TO ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "age") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= $collection->getByKey($collection->getKeyValue(), "age")." between spt.SHOPPLAN_AGE_FROM and spt.SHOPPLAN_AGE_TO ";
		}

		for ($i=1; $i<=33; $i++) {
			if ($collection->getByKey($collection->getKeyValue(), "tag".$i) != "") {
				if ($where != "") {
					$where .= "and ";
				}
				$where .= "spt.SHOPPLAN_TAG_LIST like ".$collection->getByKey($collection->getKeyValue(), "tag".$i)." ";
			}
		}

		for ($i=1; $i<=9; $i++) {
			if ($collection->getByKey($collection->getKeyValue(), "facility".$i) != "") {
				if ($where != "") {
					$where .= "and ";
				}
				$where .= "st.SHOP_FACILITY".$i." > 0 ";
				$where .= "and st.SHOP_FACILITY".$i." < 3 ";
			}
		}
*/
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
		for ($i=1; $i<=12; $i++){
			$adult_num = $collection->getByKey($collection->getKeyValue(), "priceper_num".$i);
/*			$child_num1 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."1");
			$child_num2 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."2");
			$child_num3 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."3");
			$child_num4 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."4");
			$child_num5 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."5");
			$child_num6 = $collection->getByKey($collection->getKeyValue(), "child_number".$i."6");
*/			
			$sql  = "select HOTELPAY_MONEY1, HOTELPAY_MONEY2, HOTELPAY_MONEY3, HOTELPAY_MONEY4, HOTELPAY_MONEY5, HOTELPAY_MONEY6, HOTELPAY_MONEY7, HOTELPAY_MONEY8 ";
			$sql .= "from HOTELPAY ";
			$sql .= "where ";
			$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
			$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
			$sql .= " and HOTELPAY_DATE = '".$date."' ";
			
			$result = $this->db->execute($sql);
			
			if (mysql_affected_rows() > 0) {
				$row = mysql_fetch_assoc($result);
			}
			
			$count = $adult_num;
	/*		if($child_num1 > 0 && $row["HOTELPAY_PS_DATA2"] == "1"){
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
	*/
			$stayNum[$i] = $count;
		}
//		print_r($stayNum);exit;
		return $stayNum;
	}


	//ルーム毎の大人人数計算
	public function selectMoneyEveryRoomUndecideSch($collection) {
		// プラン販売期間が検索期間範囲を設定
		$sql  = "select SHOPPLAN_ID, SHOPPLAN_SALE_FROM, SHOPPLAN_SALE_TO ";
		$sql .= "from SHOPPLAN ";
		$sql .= "where ";
		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");

		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}

		$from_date =  date("Y-m-d");
		$to_date =  $row["SHOPPLAN_SALE_TO"];
//		$to_date =  "2016-11-26";

//print $to_date;

		// 料金ようの人数計算
		$sql  = "select hp.HOTELPAY_MONEY1, hp.HOTELPAY_MONEY2, hp.HOTELPAY_MONEY3, hp.HOTELPAY_MONEY4, hp.HOTELPAY_MONEY5, hp.HOTELPAY_MONEY6, hp.HOTELPAY_MONEY7, hp.HOTELPAY_MONEY8, hp.SHOP_PRICETYPE_ID, ";
		$sql .= "spr.SHOP_PRICETYPE_KIND, spr.SHOP_PRICETYPE_MONEYKIND1, spr.SHOP_PRICETYPE_MONEYKIND2, spr.SHOP_PRICETYPE_MONEYKIND3, spr.SHOP_PRICETYPE_MONEYKIND4, spr.SHOP_PRICETYPE_MONEYKIND5, spr.SHOP_PRICETYPE_MONEYKIND6, spr.SHOP_PRICETYPE_MONEYKIND7 ";
		$sql .= "from HOTELPAY hp ";
		$sql .= "inner join SHOP_PRICETYPE spr on hp.SHOP_PRICETYPE_ID = spr.SHOP_PRICETYPE_ID ";
		$sql .= "where ";
//		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
		$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
		
	//	$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
//		$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
		$sql .= " and HOTELPAY_DATE <= '".$to_date."' and HOTELPAY_DATE>= '".$from_date."'";//fromに治す
		
//print $sql;
		$result = $this->db->execute($sql);
		//$row = array();
/*		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}
*/		

		// 総合比較用の連想配列
		$cheap_precheck = array();

		if (mysql_affected_rows() > 0) {
			while($row = mysql_fetch_array($result)) {
				
		//print_r($row);
		$count = $collection->getByKey($collection->getKeyValue(), "priceper_num");
/*		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8");
		}
*/
		$moneyArray["people_count"] = $count;

		//料金タイプで引っ張る料金を出し分ける。
		if($row["SHOP_PRICETYPE_KIND"] == 1){

			// 料金種別が大人か一律の場合に最安値計算に含める
			$cheap_check = array();
			if($row["SHOP_PRICETYPE_MONEYKIND1"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND1"] == 4){
				$cheap_check[1] = $row["HOTELPAY_MONEY1"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND2"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND2"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[2] = $row["HOTELPAY_MONEY2"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND3"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND3"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[3] = $row["HOTELPAY_MONEY3"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND4"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND4"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[4] = $row["HOTELPAY_MONEY4"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND5"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND5"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[5] = $row["HOTELPAY_MONEY5"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND6"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND6"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[6] = $row["HOTELPAY_MONEY6"];
			}
//print_r($cheapest);
			
			// 料金帯の中から最安値を比較
			$cheap_est = min($cheap_check);
			
			//$moneyArray["money_cheapest"] = $cheap_est;
			//$moneyArray["money_perperson"] = $cheap_est;
		//	$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY1"];

		}elseif($row["SHOP_PRICETYPE_KIND"] == 2){
			// グループ料金は1パターン
			$cheap_est = $row["HOTELPAY_MONEY7"];

			//$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY7"];
			//$moneyArray["money_cheapest"] = $row["HOTELPAY_MONEY7"];
		}

	//	$moneyALL = $collection->getByKey($collection->getKeyValue(), "priceper_num") * $moneyArray["money_perperson"];

		// 料金タイプごとの最安値からさらにプランの最安値を絞り込む

		$cheap_precheck[] = $cheap_est;

//		$moneyALL = $moneyArray["money_cheapest"];


/*
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
*/

//				$moneyArray["money_ALL"] = $moneyALL;
				//$moneyArray["point"] = $row["HOTELPAY_ROOM_NUM"];
				
/*
				if($moneyArray["money_ALL"] > 0){
					if(!$cheapest){
						$cheapest["money_ALL"] = $moneyArray["money_ALL"];
						$cheapest["money_perperson"] = $moneyArray["money_perperson"];
					//	$cheapest["point"] = $moneyArray["point"];
					}
					else{
						if ($cheapest["money_ALL"] > $moneyArray["money_ALL"]) {
							$cheapest["money_ALL"] = $moneyArray["money_ALL"];
							$cheapest["money_perperson"] = $moneyArray["money_perperson"];
					//		$cheapest["point"] = $moneyArray["point"];
						}
					}
				}
*/


		$moneyArray["money_cheapest"] = min($cheap_precheck);
		$moneyArray["money_perperson"] = min($cheap_precheck);


		//範囲内すべての最安値を比較
		$moneyALL = $moneyArray["money_cheapest"];
		$moneyArray["money_ALL"] = $moneyALL;


			}

		}



	//	print_r($cheap_precheck);
		//print_r($moneyArray);

//print $cheapest;
		return $moneyArray;
		//return $cheapest;
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
		$sql  = "select hp.HOTELPAY_MONEY1, hp.HOTELPAY_MONEY2, hp.HOTELPAY_MONEY3, hp.HOTELPAY_MONEY4, hp.HOTELPAY_MONEY5, hp.HOTELPAY_MONEY6, hp.HOTELPAY_MONEY7, hp.HOTELPAY_MONEY8, hp.SHOP_PRICETYPE_ID, ";
		$sql .= "spr.SHOP_PRICETYPE_KIND, spr.SHOP_PRICETYPE_MONEYKIND1, spr.SHOP_PRICETYPE_MONEYKIND2, spr.SHOP_PRICETYPE_MONEYKIND3, spr.SHOP_PRICETYPE_MONEYKIND4, spr.SHOP_PRICETYPE_MONEYKIND5, spr.SHOP_PRICETYPE_MONEYKIND6, spr.SHOP_PRICETYPE_MONEYKIND7 ";
		$sql .= "from HOTELPAY hp ";
		$sql .= "inner join SHOP_PRICETYPE spr on hp.SHOP_PRICETYPE_ID = spr.SHOP_PRICETYPE_ID ";
		$sql .= "where ";
//		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
		$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
		
	//	$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
//		$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
		$sql .= " and hp.HOTELPAY_DATE = '".$date."' ";
//print $sql;
		$result = $this->db->execute($sql);	
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}

//		print_r($row);
		$count = $collection->getByKey($collection->getKeyValue(), "priceper_num");
/*		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8");
		}
*/
		$moneyArray["people_count"] = $count;

		//料金タイプで引っ張る料金を出し分ける。
		if($row["SHOP_PRICETYPE_KIND"] == 1){

			// 料金種別が大人か一律の場合に最安値計算に含める
			$cheap_check = array();
			if($row["SHOP_PRICETYPE_MONEYKIND1"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND1"] == 4){
				$cheap_check[1] = $row["HOTELPAY_MONEY1"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND2"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND2"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[2] = $row["HOTELPAY_MONEY2"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND3"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND3"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[3] = $row["HOTELPAY_MONEY3"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND4"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND4"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[4] = $row["HOTELPAY_MONEY4"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND5"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND5"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[5] = $row["HOTELPAY_MONEY5"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND6"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND6"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[6] = $row["HOTELPAY_MONEY6"];
			}
//print_r($cheapest);
			
			// 料金帯の中から最安値を比較
			$cheap_est = min($cheap_check);
			
			$moneyArray["money_cheapest"] = $cheap_est;
			$moneyArray["money_perperson"] = $cheap_est;
		//	$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY1"];

		}elseif($row["SHOP_PRICETYPE_KIND"] == 2){
			// グループ料金は1パターン
			$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY7"];
			$moneyArray["money_cheapest"] = $row["HOTELPAY_MONEY7"];
		}

	//	$moneyALL = $collection->getByKey($collection->getKeyValue(), "priceper_num") * $moneyArray["money_perperson"];

		// 料金タイプごとの最安値からさらにプランの最安値を絞り込む
		$moneyALL = $moneyArray["money_cheapest"];

/*
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
*/

		$moneyArray["money_ALL"] = $moneyALL;
		//$moneyArray["point"] = $row["HOTELPAY_ROOM_NUM"];
//		print_r($moneyArray);
		return $moneyArray;
	}





	//料金データの表示用
	public function selectMoneyEveryRoomInsert($collection) {
		// 日付格式変更
		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "SEARCH_DATE") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "SEARCH_DATE"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

//print_r($collection);

		// 料金用の人数計算
		$sql  = "select hp.HOTELPAY_MONEY1, hp.HOTELPAY_MONEY2, hp.HOTELPAY_MONEY3, hp.HOTELPAY_MONEY4, hp.HOTELPAY_MONEY5, hp.HOTELPAY_MONEY6, hp.HOTELPAY_MONEY7, hp.HOTELPAY_MONEY8, hp.SHOP_PRICETYPE_ID, ";
		$sql .= "spr.SHOP_PRICETYPE_KIND, spr.SHOP_PRICETYPE_MONEYKIND1, spr.SHOP_PRICETYPE_MONEYKIND2, spr.SHOP_PRICETYPE_MONEYKIND3, spr.SHOP_PRICETYPE_MONEYKIND4, spr.SHOP_PRICETYPE_MONEYKIND5, spr.SHOP_PRICETYPE_MONEYKIND6, spr.SHOP_PRICETYPE_MONEYKIND7, ";
		$sql .= "spr.SHOP_PRICETYPE_MONEY7MIN, spr.SHOP_PRICETYPE_MONEY7MAX, spr.SHOP_PRICETYPE_MONEY1, spr.SHOP_PRICETYPE_MONEY2, spr.SHOP_PRICETYPE_MONEY3, spr.SHOP_PRICETYPE_MONEY4, spr.SHOP_PRICETYPE_MONEY5, spr.SHOP_PRICETYPE_MONEY6, spr.SHOP_PRICETYPE_ADDFLG ";

		$sql .= "from HOTELPAY hp ";
		$sql .= "inner join SHOP_PRICETYPE spr on hp.SHOP_PRICETYPE_ID = spr.SHOP_PRICETYPE_ID ";
		$sql .= "where ";
//		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
		$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
		
	//	$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
//		$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
		$sql .= " and hp.HOTELPAY_DATE = '".$date."' ";
//print $sql;
		$result = $this->db->execute($sql);	
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}

	//	print_r($row);

		$moneyArray["SHOP_PRICETYPE_KIND"] = $row["SHOP_PRICETYPE_KIND"];
		$moneyArray["SHOP_PRICETYPE_ADDFLG"] = $row["SHOP_PRICETYPE_ADDFLG"];

		$count = 0;

		if($row["SHOP_PRICETYPE_KIND"] ==1){
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON1") > 0){
				$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON1");
			}
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2") > 0){
				$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2");
			}
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3") > 0){
				$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3");
			}
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4") > 0){
				$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4");
			}
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5") > 0){
				$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5");
			}
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6") > 0){
				$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6");
			}
		}elseif($row["SHOP_PRICETYPE_KIND"] ==2){
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7") > 0){
				$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7");
			}
			//追加人数は数に入れない。そうしないと在庫引き落とし数がとんでもないことになる。
			if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8") > 0){
		//		$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8");
			}
		}
		$moneyArray["people_count"] = $count;

			//申し込み人数の範囲
			$moneyArray["SHOP_PRICETYPE_MONEY7MAX"] = $row["SHOP_PRICETYPE_MONEY7MAX"];
			$moneyArray["SHOP_PRICETYPE_MONEY7MIN"] = $row["SHOP_PRICETYPE_MONEY7MIN"];

		//料金タイプで引っ張る料金を出し分ける。
		if($row["SHOP_PRICETYPE_KIND"] == 1){


			for($i=1;$i<=6;$i++){
				if($row["HOTELPAY_MONEY".$i] > 0){
					$count_pay = $i;
				}
			}
			$moneyArray["count_pay"] = $count_pay;

			//料金種別
			$moneyArray["SHOP_PRICETYPE_MONEYKIND1"] = $row["SHOP_PRICETYPE_MONEYKIND1"];
			$moneyArray["SHOP_PRICETYPE_MONEYKIND2"] = $row["SHOP_PRICETYPE_MONEYKIND2"];
			$moneyArray["SHOP_PRICETYPE_MONEYKIND3"] = $row["SHOP_PRICETYPE_MONEYKIND3"];
			$moneyArray["SHOP_PRICETYPE_MONEYKIND4"] = $row["SHOP_PRICETYPE_MONEYKIND4"];
			$moneyArray["SHOP_PRICETYPE_MONEYKIND5"] = $row["SHOP_PRICETYPE_MONEYKIND5"];
			$moneyArray["SHOP_PRICETYPE_MONEYKIND6"] = $row["SHOP_PRICETYPE_MONEYKIND6"];

			//料金名
			$moneyArray["SHOP_PRICETYPE_MONEY1"] = $row["SHOP_PRICETYPE_MONEY1"];
			$moneyArray["SHOP_PRICETYPE_MONEY2"] = $row["SHOP_PRICETYPE_MONEY2"];
			$moneyArray["SHOP_PRICETYPE_MONEY3"] = $row["SHOP_PRICETYPE_MONEY3"];
			$moneyArray["SHOP_PRICETYPE_MONEY4"] = $row["SHOP_PRICETYPE_MONEY4"];
			$moneyArray["SHOP_PRICETYPE_MONEY5"] = $row["SHOP_PRICETYPE_MONEY5"];
			$moneyArray["SHOP_PRICETYPE_MONEY6"] = $row["SHOP_PRICETYPE_MONEY6"];

			//金額
			$moneyArray["HOTELPAY_MONEY1"] = $row["HOTELPAY_MONEY1"];
			$moneyArray["HOTELPAY_MONEY2"] = $row["HOTELPAY_MONEY2"];
			$moneyArray["HOTELPAY_MONEY3"] = $row["HOTELPAY_MONEY3"];
			$moneyArray["HOTELPAY_MONEY4"] = $row["HOTELPAY_MONEY4"];
			$moneyArray["HOTELPAY_MONEY5"] = $row["HOTELPAY_MONEY5"];
			$moneyArray["HOTELPAY_MONEY6"] = $row["HOTELPAY_MONEY6"];

			
			$PRICE_ALL1 = $moneyArray["HOTELPAY_MONEY1"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON1");
			$PRICE_ALL2 = $moneyArray["HOTELPAY_MONEY2"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2");
			$PRICE_ALL3 = $moneyArray["HOTELPAY_MONEY3"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3");
			$PRICE_ALL4 = $moneyArray["HOTELPAY_MONEY4"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4");
			$PRICE_ALL5 = $moneyArray["HOTELPAY_MONEY5"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5");
			$PRICE_ALL6 = $moneyArray["HOTELPAY_MONEY6"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6");

			//合計料金
			$SUM_ALL = $PRICE_ALL1+$PRICE_ALL2+$PRICE_ALL3+$PRICE_ALL4+$PRICE_ALL5+$PRICE_ALL6;

			//在庫引き落とし数
			$zaiko_num = $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON1")+
				     $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2")+
				     $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3")+
				     $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4")+
				     $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5")+
				     $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6");

			//$moneyArray["money_cheapest"] = $cheap_est;
			//$moneyArray["money_perperson"] = $cheap_est;
		//	$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY1"];

		}elseif($row["SHOP_PRICETYPE_KIND"] == 2){
			// グループ料金は1パターン

			$moneyArray["SHOP_PRICETYPE_MONEYKIND7"] = $row["SHOP_PRICETYPE_MONEYKIND7"];
			$moneyArray["SHOP_PRICETYPE_MONEY7"] = $row["SHOP_PRICETYPE_MONEY7"];
			$moneyArray["HOTELPAY_MONEY7"] = $row["HOTELPAY_MONEY7"];

			$PRICE_ALL7 = $moneyArray["HOTELPAY_MONEY7"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7");

			// 人数追加フラグがonの場合、追加人数分の合計料金を計算する
			if($row["SHOP_PRICETYPE_ADDFLG"]==1){
				$moneyArray["SHOP_PRICETYPE_MONEYKIND8"] = $row["SHOP_PRICETYPE_MONEYKIND8"];
				$money8 = "人数追加";
				$moneyArray["SHOP_PRICETYPE_MONEY8"] = $money8;
				$moneyArray["HOTELPAY_MONEY8"] = $row["HOTELPAY_MONEY8"];

				$PRICE_ALL8 = $moneyArray["HOTELPAY_MONEY8"] * $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8");

				//合計料金
				$SUM_ALL = $PRICE_ALL7+$PRICE_ALL8;

			}else{

				//合計料金
				$SUM_ALL = $PRICE_ALL7;

			}

			//在庫引き落とし数
			$zaiko_num = $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7");

//			$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY7"];
//			$moneyArray["money_cheapest"] = $row["HOTELPAY_MONEY7"];
		}

	//	$moneyALL = $collection->getByKey($collection->getKeyValue(), "priceper_num") * $moneyArray["money_perperson"];

		// 料金タイプごとの最安値からさらにプランの最安値を絞り込む
		$moneyALL = $SUM_ALL;

		$moneyArray["money_ALL"] = $moneyALL;
		//$moneyArray["point"] = $row["HOTELPAY_ROOM_NUM"];
	//	print_r($moneyArray);
		return $moneyArray;
	}


	//ルーム毎の大人人数計算+在庫状況
	public function selectMoneyEveryRoomDay($collection) {

//print_r($collection);

		// 日付格式変更
		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "SEARCH_DATE") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "SEARCH_DATE"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}

		$sql  = "select SHOPPLAN_ID, ";
		for($i=1;$i<=12;$i++){
			$sql .= "SHOPPLAN_PRICETYPE".$i.", ";
			$sql .= "SHOPPLAN_ROOM".$i.", ";
		}
		$sql .= "SHOPPLAN_SALE_FROM, SHOPPLAN_SALE_TO ";
		$sql .= "from SHOPPLAN ";
		$sql .= "where ";
		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");

		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}

		//print_r($row);
//print $sql;

		// PRICETYPE_IDとROOM_IDの取得と配列化
		$count_ptr = "";
		$arrayPR = array();
		for($i=1;$i<=12;$i++){
			if($row["SHOPPLAN_PRICETYPE".$i] >0 && $row["SHOPPLAN_ROOM".$i] >0 ){
				$arrayPR[$i][room] = $row["SHOPPLAN_ROOM".$i];
				$arrayPR[$i][pricetype] = $row["SHOPPLAN_PRICETYPE".$i];
				$count_ptr = $i;
			}
		}
//print_r($arrayPR);
//print $count_ptr;

	$arrayPrice = array();
	$arrayProvide = array();

	foreach($arrayPR as $pr){
//print_r($arrayPR);
		// 在庫テーブル
 		$sql  = "select ";
 		$sql .= "r.COMPANY_ID, ";
 		$sql .= "r.ROOM_ID, ";
		$sql .= "hprov.HOTELPROVIDE_ID, ";
		$sql .= "hprov.HOTELPROVIDE_DATE, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_STOP, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_REQUEST, ";
		$sql .= "hprov.HOTELPROVIDE_NUM, ";
		$sql .= "hprov.HOTELPROVIDE_BOOKEDNUM ";
 		$sql .= "from ROOM r ";
 		$sql .= "inner join HOTELPROVIDE hprov on r.COMPANY_ID = hprov.COMPANY_ID and r.ROOM_ID = hprov.ROOM_ID ";

 		$sql .= "where ";
	//	$sql .= "hprov.HOTELPROVIDE_FLG_STOP = 1 ";
		$sql .= "r.ROOM_ID = ".$pr[room];
		$sql .= " and hprov.HOTELPROVIDE_DATE = '".$date."' ";

		//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "priceper_num");
			//	$sql .= "and hprov.HOTELPROVIDE_DATE = '$date' ";
			//	$sql .= "and hprov.HOTELPROVIDE_NUM >= '1' ";
			}


			//	在庫の引き落とし数(zaiko_num=合計人数または組数）
			if ($collection->getByKey($collection->getKeyValue(), "priceper_num") != "") {
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "priceper_num");
			//	$sql .= "and (hprov.HOTELPROVIDE_NUM-hprov.HOTELPROVIDE_BOOKEDNUM >= '$ROOM_NUM') ";
			}

		// リクエストの時は在庫数無視
		$sql .= "or hprov.HOTELPROVIDE_FLG_REQUEST = '1' ";
		//$sql .= "and hprov.HOTELPROVIDE_FLG_STOP = 1 ";
		$sql .= "and r.ROOM_ID = ".$pr[room];
		$sql .= " and hprov.HOTELPROVIDE_DATE = '".$date."' ";

//print $sql;
//print_r($row_room);
		$row_room = "";
		$result_room = $this->db->execute($sql);	

		if (mysql_affected_rows() >= 0) {
			$row_room = mysql_fetch_assoc($result_room);
		}


			$room_prov = "";

			if($row_room ==""){
				//料金設定なし
			      $room_prov = "x";
			}
			if($row_room[HOTELPROVIDE_FLG_STOP]==1){
				if($row_room[HOTELPROVIDE_FLG_REQUEST] == 1){
					//リクエスト表示
					$room_prov = "R";
				}elseif($row_room[HOTELPROVIDE_FLG_REQUEST] == 2){
					// 提供-予約数で残室を表示
					$room_prov = $row_room[HOTELPROVIDE_NUM]-$row_room[HOTELPROVIDE_BOOKEDNUM];
				}
			}elseif($row_room[HOTELPROVIDE_FLG_STOP]==2){
				//売り止め
				$room_prov = "x";
			}

	   $arrayProvide[] = $room_prov;
	}
//print_r($arrayProvide);
//print $pr[room];

	foreach($arrayPR as $pr){

		// 料金の計算
		$sql  = "select hp.HOTELPAY_MONEY1, hp.HOTELPAY_MONEY2, hp.HOTELPAY_MONEY3, hp.HOTELPAY_MONEY4, hp.HOTELPAY_MONEY5, hp.HOTELPAY_MONEY6, hp.HOTELPAY_MONEY7, hp.HOTELPAY_MONEY8, hp.SHOP_PRICETYPE_ID, ";
		$sql .= "spr.SHOP_PRICETYPE_KIND, spr.SHOP_PRICETYPE_MONEYKIND1, spr.SHOP_PRICETYPE_MONEYKIND2, spr.SHOP_PRICETYPE_MONEYKIND3, spr.SHOP_PRICETYPE_MONEYKIND4, spr.SHOP_PRICETYPE_MONEYKIND5, spr.SHOP_PRICETYPE_MONEYKIND6, spr.SHOP_PRICETYPE_MONEYKIND7 ";
		$sql .= "from HOTELPAY hp ";
		$sql .= "inner join SHOP_PRICETYPE spr on hp.SHOP_PRICETYPE_ID = spr.SHOP_PRICETYPE_ID ";
		$sql .= "where ";
//		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
		$sql .= " spr.SHOP_PRICETYPE_ID = ".$pr[pricetype];
		
	//	$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
//		$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
		$sql .= " and hp.HOTELPAY_DATE = '".$date."' ";
//print $sql;
		$row = "";
		$result = $this->db->execute($sql);	
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}


//		print_r($row);
		$count = $collection->getByKey($collection->getKeyValue(), "priceper_num");
/*		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON2");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON3");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON4");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON5");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON6");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON7");
		}
		if($collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8") > 0){
			$count += $collection->getByKey($collection->getKeyValue(), "BOOKING_PRICEPERSON8");
		}
*/
		$moneyArray["people_count"] = $count;

		//料金タイプで引っ張る料金を出し分ける。
		if($row["SHOP_PRICETYPE_KIND"] == 1){

			// 料金種別が大人か一律の場合に最安値計算に含める
			$cheap_check = array();
			if($row["SHOP_PRICETYPE_MONEYKIND1"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND1"] == 4){
				$cheap_check[1] = $row["HOTELPAY_MONEY1"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND2"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND2"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[2] = $row["HOTELPAY_MONEY2"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND3"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND3"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[3] = $row["HOTELPAY_MONEY3"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND4"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND4"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[4] = $row["HOTELPAY_MONEY4"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND5"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND5"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[5] = $row["HOTELPAY_MONEY5"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND6"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND6"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[6] = $row["HOTELPAY_MONEY6"];
			}
//print_r($cheapest);
			
			// 料金帯の中から最安値を比較
			$cheap_est = min($cheap_check);
			
			$moneyArray["money_cheapest"] = $cheap_est;
			$moneyArray["money_perperson"] = $cheap_est;
		//	$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY1"];

		}elseif($row["SHOP_PRICETYPE_KIND"] == 2){
			// グループ料金は1パターン
			$cheap_est = $row["HOTELPAY_MONEY7"];

			$moneyArray["money_perperson"] = $cheap_est;
			$moneyArray["money_cheapest"] = $cheap_est;
		}
	   $arrayPrice[] = $cheap_est;

	}
//print_r($arrayPrice);
	//	$moneyALL = $collection->getByKey($collection->getKeyValue(), "priceper_num") * $moneyArray["money_perperson"];

		

		// 表示に使う料金と在庫の候補

		$arrayView = array();
		$count_view = count($arrayPrice);
		for($i=0;$i<$count_view;$i++){
			$arrayView[$i][room] = $arrayProvide[$i];
			$arrayView[$i][price] = $arrayPrice[$i];
		}

/*
		foreach( $arrayView as $key => $row_pr ) {
			  $tmp_room[$key] = $row_pr["room"];
			  $tmp_price[$key] = $row_pr["price"];
		}
		array_multisort($tmp_price, SORT_ASC, SORT_NUMERIC,
				$tmp_room, SORT_NUMERIC,
		                 $arrayView );
*/
		//asort($arrayView);
//		print_r($arrayView);

		// 代表の在庫ステータスと最安値候補を回して取得。xを除外する。

		foreach( $arrayView as $k => $v ) {
			  if($v["room"] == "x" || $v["price"] == "x"){
			   }else{
			     $ro[$k] = $v["room"];
			     $pri[$k] = $v["price"];
			   }
		}

		// 在庫最大値と最安値をそれぞれ計算し代入

		if(count($ro) >0){
			$dspRoom = max($ro);
//print_r($ro);
		}else{
			$dspRoom = "x";
		}

		if(count($pri) >0){
			$dspPrice = min($pri);
		}else{
			$dspPrice = "x";
		}

//		print_r($ro);print_r($pri);

	
		$moneyArray["calender_room"] = $dspRoom;
		$moneyArray["calender_price"] =$dspPrice;

//print $moneyArray["calender_room"]."/";
//print $moneyArray["calender_price"];

		// 料金タイプごとの最安値からさらにプランの最安値を絞り込む
		$moneyALL = $moneyArray["money_cheapest"];

		$moneyArray["SHOPPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
		$moneyArray["money_ALL"] = $moneyALL;
		//$moneyArray["point"] = $row["HOTELPAY_ROOM_NUM"];
//		print_r($moneyArray);
		return $moneyArray;
	}


	//ルーム毎の大人人数計算+在庫状況
	public function selectMoneyEveryRoomBook($collection) {
//print_r($collection);
		// 日付格式変更
		$date = "";
		if ($collection->getByKey($collection->getKeyValue(), "SEARCH_DATE") != "") {
			$date = str_replace("年", "-", $collection->getByKey($collection->getKeyValue(), "SEARCH_DATE"));
			$date = str_replace("月", "-", $date);
			$date = str_replace("日", "", $date);
		}
		$sql  = "select SHOPPLAN_ID, ";

		//$count_hour = "";
		for($i=1;$i<=12;$i++){
			$sql .= "SHOPPLAN_MEET_TIMEHOUR".$i.", ";
			$sql .= "SHOPPLAN_MEET_TIMEMIN".$i.", ";
			$sql .= "SHOPPLAN_PRICETYPE".$i.", ";
			$sql .= "SHOPPLAN_ROOM".$i.", ";
		}
		$sql .= "SHOPPLAN_SALE_FROM, SHOPPLAN_SALE_TO ";
		$sql .= "from SHOPPLAN ";
		$sql .= "where ";
		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");

		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}

		//print_r($row);
//print $sql;

		// HOUR&MINとPRICETYPE_IDとROOM_IDの取得と配列化
		$count_ptr = "";
		$arrayPR = array();
		for($i=1;$i<=12;$i++){
			if($row["SHOPPLAN_MEET_TIMEHOUR".$i] >0 && $row["SHOPPLAN_PRICETYPE".$i] >0 && $row["SHOPPLAN_ROOM".$i] >0 ){
				$arrayPR[$i][hour] = $row["SHOPPLAN_MEET_TIMEHOUR".$i];
				$arrayPR[$i][min] = $row["SHOPPLAN_MEET_TIMEMIN".$i];
				$arrayPR[$i][room] = $row["SHOPPLAN_ROOM".$i];
				$arrayPR[$i][pricetype] = $row["SHOPPLAN_PRICETYPE".$i];
				$count_ptr = $i;
			}
		}
//print_r($arrayPR);
//print $count_ptr;

	$arrayHour = array();
	$arrayMin = array();
	$arrayPid = array();
	$arrayRid = array();
	$arrayKind = array();
	$arrayGroup = array();
	$arrayPrice = array();
	$arrayProvide = array();

	foreach($arrayPR as $pr){

		$arrayHour[] = $pr["hour"];
		$arrayMin[] = $pr["min"];
		$arrayPid[] = $pr["pricetype"];
		$arrayRid[] = $pr["room"];

//print_r($arrayPR);
		// 在庫テーブル
 		$sql  = "select ";
 		$sql .= "r.COMPANY_ID, ";
 		$sql .= "r.ROOM_ID, ";
		$sql .= "hprov.HOTELPROVIDE_ID, ";
		$sql .= "hprov.HOTELPROVIDE_DATE, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_STOP, ";
		$sql .= "hprov.HOTELPROVIDE_FLG_REQUEST, ";
		$sql .= "hprov.HOTELPROVIDE_NUM, ";
		$sql .= "hprov.HOTELPROVIDE_BOOKEDNUM ";
 		$sql .= "from ROOM r ";
 		$sql .= "inner join HOTELPROVIDE hprov on r.COMPANY_ID = hprov.COMPANY_ID and r.ROOM_ID = hprov.ROOM_ID ";

 		$sql .= "where ";
	//	$sql .= "hprov.HOTELPROVIDE_FLG_STOP = 1 ";
		$sql .= "r.ROOM_ID = ".$pr[room];
		$sql .= " and hprov.HOTELPROVIDE_DATE = '".$date."' ";

		//	指定日
			if ($collection->getByKey($collection->getKeyValue(), "top_area") != "1") {
				//	提供部屋数
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "priceper_num");
			//	$sql .= "and hprov.HOTELPROVIDE_DATE = '$date' ";
			//	$sql .= "and hprov.HOTELPROVIDE_NUM >= '1' ";
			}


			//	在庫の引き落とし数(zaiko_num=合計人数または組数）
			if ($collection->getByKey($collection->getKeyValue(), "priceper_num") != "") {
				$ROOM_NUM = $collection->getByKey($collection->getKeyValue(), "priceper_num");
			//	$sql .= "and (hprov.HOTELPROVIDE_NUM-hprov.HOTELPROVIDE_BOOKEDNUM >= '$ROOM_NUM') ";
			}

		// リクエストの時は在庫数無視
		$sql .= "or hprov.HOTELPROVIDE_FLG_REQUEST = '1' ";
		//$sql .= "and hprov.HOTELPROVIDE_FLG_STOP = 1 ";
		$sql .= "and r.ROOM_ID = ".$pr[room];
		$sql .= " and hprov.HOTELPROVIDE_DATE = '".$date."' ";

//print $sql;
		$row_room = "";
		$result_room = $this->db->execute($sql);	

		if (mysql_affected_rows() >= 0) {
			$row_room = mysql_fetch_assoc($result_room);
		}


			$room_prov = "";

			if($row_room ==""){
				//料金設定なし
			      $room_prov = "x";
			}
			if($row_room[HOTELPROVIDE_FLG_STOP]==1){
				if($row_room[HOTELPROVIDE_FLG_REQUEST] == 1){
					//リクエスト表示
					$room_prov = "R";
				}elseif($row_room[HOTELPROVIDE_FLG_REQUEST] == 2){
					// 提供-予約数で残室を表示
					$room_prov = $row_room[HOTELPROVIDE_NUM]-$row_room[HOTELPROVIDE_BOOKEDNUM];
				}
			}elseif($row_room[HOTELPROVIDE_FLG_STOP]==2){
				//売り止め
				$room_prov = "x";
			}

	   $arrayProvide[] = $room_prov;
	}
//print_r($arrayProvide);
//print_r($arrayHour);
//print_r($arrayMin);
//print $pr[room];

	foreach($arrayPR as $pr){

		// 料金の計算
		$sql  = "select hp.HOTELPAY_MONEY1, hp.HOTELPAY_MONEY2, hp.HOTELPAY_MONEY3, hp.HOTELPAY_MONEY4, hp.HOTELPAY_MONEY5, hp.HOTELPAY_MONEY6, hp.HOTELPAY_MONEY7, hp.HOTELPAY_MONEY8, hp.SHOP_PRICETYPE_ID, ";
		$sql .= "spr.SHOP_PRICETYPE_KIND, spr.SHOP_PRICETYPE_MONEYKIND1, spr.SHOP_PRICETYPE_MONEYKIND2, spr.SHOP_PRICETYPE_MONEYKIND3, spr.SHOP_PRICETYPE_MONEYKIND4, spr.SHOP_PRICETYPE_MONEYKIND5, spr.SHOP_PRICETYPE_MONEYKIND6, spr.SHOP_PRICETYPE_MONEYKIND7, spr.SHOP_PRICETYPE_MONEY7MIN, spr.SHOP_PRICETYPE_MONEY7MAX, spr.SHOP_PRICETYPE_MONEY1, spr.SHOP_PRICETYPE_MONEY2, spr.SHOP_PRICETYPE_MONEY3, spr.SHOP_PRICETYPE_MONEY4, spr.SHOP_PRICETYPE_MONEY5, spr.SHOP_PRICETYPE_MONEY6 ";
		$sql .= "from HOTELPAY hp ";
		$sql .= "inner join SHOP_PRICETYPE spr on hp.SHOP_PRICETYPE_ID = spr.SHOP_PRICETYPE_ID ";
		$sql .= "where ";
//		$sql .= " SHOPPLAN_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
		$sql .= " spr.SHOP_PRICETYPE_ID = ".$pr[pricetype];
		
	//	$sql .= " spr.SHOP_PRICETYPE_ID = ".$collection->getByKey($collection->getKeyValue(), "SHOP_PRICETYPE_ID");
//		$sql .= " and ROOM_ID = ".$collection->getByKey($collection->getKeyValue(), "ROOM_ID");
		$sql .= " and hp.HOTELPAY_DATE = '".$date."' ";
//print $sql;
		$row = "";
		$result = $this->db->execute($sql);	
		if (mysql_affected_rows() > 0) {
			$row = mysql_fetch_assoc($result);
		}


//		print_r($row);
		$count = $collection->getByKey($collection->getKeyValue(), "priceper_num");
	//	$moneyArray["people_count"] = $count;

		//料金タイプで引っ張る料金を出し分ける。
		if($row["SHOP_PRICETYPE_KIND"] == 1){

			// 料金種別が大人か一律の場合に最安値計算に含める
			$cheap_check = array();
			if($row["SHOP_PRICETYPE_MONEYKIND1"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND1"] == 4){
				$cheap_check[1] = $row["HOTELPAY_MONEY1"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND2"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND2"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[2] = $row["HOTELPAY_MONEY2"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND3"] == 1 or $row["SHOP_PRICETYPE_MONEYKIND3"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[3] = $row["HOTELPAY_MONEY3"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND4"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND4"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[4] = $row["HOTELPAY_MONEY4"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND5"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND5"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[5] = $row["HOTELPAY_MONEY5"];
			}
			if($row["SHOP_PRICETYPE_MONEYKIND6"] == 1 || $row["SHOP_PRICETYPE_MONEYKIND6"] == 4){
		//		if($cheap_check != ""){ 
		//			$cheap_check .= ", ";
		//		}
				$cheap_check[6] = $row["HOTELPAY_MONEY6"];
			}
//print_r($cheapest);
			
			// 料金帯の中から最安値を比較
			$cheap_est = min($cheap_check);
			
		//	$moneyArray["money_cheapest"] = $cheap_est;
		//	$moneyArray["money_perperson"] = $cheap_est;
		//	$moneyArray["money_perperson"] = $row["HOTELPAY_MONEY1"];

		}elseif($row["SHOP_PRICETYPE_KIND"] == 2){
			// グループ料金は1パターン
			$cheap_est = $row["HOTELPAY_MONEY7"];
		//	$arrayGroup[] = $row["SHOP_PRICETYPE_MONEYKIND7"];

	   $arrayGroup[] = $row["SHOP_PRICETYPE_MONEYKIND7"];

	//		$moneyArray["money_perperson"] = $cheap_est;
	//		$moneyArray["money_cheapest"] = $cheap_est;
		}
	   $arrayKind[] = $row["SHOP_PRICETYPE_KIND"];
	   $arrayPrice[] = $cheap_est;

	}
//print_r($arrayPrice);

		

		// 表示に使う料金と在庫の候補

		$arrayView = array();
		$count_view = count($arrayPR);
		for($i=0;$i<$count_view;$i++){
			$moneyArray[$i][hour] = $arrayHour[$i];
			$moneyArray[$i][min] = $arrayMin[$i];
			$moneyArray[$i][rid] = $arrayRid[$i];
			$moneyArray[$i][pid] = $arrayPid[$i];
			$moneyArray[$i][room] = $arrayProvide[$i];
			$moneyArray[$i][price] = $arrayPrice[$i];
			$moneyArray[$i][kind] = $arrayKind[$i];
			$moneyArray[$i][group] = $arrayGroup[$i];
		}
//print_r($moneyArray);
		// 代表の在庫ステータスと最安値候補を回して取得。xを除外する。

		foreach( $moneyArray as $k => $v ) {
			     $ho[$k] = $v["hour"];
			     $mi[$k] = $v["min"];
			     $ri[$k] = $v["rid"];
			     $pi[$k] = $v["pid"];
			     $ro[$k] = $v["room"];
			     $pri[$k] = $v["price"];
			     $ki[$k] = $v["kind"];
			     $gp[$k] = $v["group"];
		}

		// 在庫最大値と最安値をそれぞれ計算し代入

		if(count($ro) >0){
			$dspRoom = max($ro);
//print_r($ro);
		}else{
			$dspRoom = "x";
		}

		if(count($pri) >0){
			$dspPrice = min($pri);
		}else{
			$dspPrice = "x";
		}

//		print_r($ro);print_r($pri);

	//	$moneyArray["calender_room"] = $dspRoom;
	//	$moneyArray["calender_price"] =$dspPrice;

//print $moneyArray["calender_room"]."/";
//print $moneyArray["calender_price"];

		// 料金タイプごとの最安値からさらにプランの最安値を絞り込む
	//	$moneyALL = $moneyArray["money_cheapest"];


	//	$moneyArray["SHOPPLAN_ID"] = $collection->getByKey($collection->getKeyValue(), "SHOPPLAN_ID");
	//	$moneyArray["money_ALL"] = $moneyALL;
	//	print_r($moneyArray);
		return $moneyArray;
	}





	public function selectListAdmin($collection) {
		$sql  = "select ";
		$sql .= "c.COMPANY_ID, SHOP_STATUS, SHOP_NAME, ";
		$sql .= parent::decryptionList("COMPANY_NAME").", ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from COMPANY c ";
		$sql .= "left join ".shop::tableName." a on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".shop::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "SHOP_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$SHOP_NAM = "%".$collection->getByKey($collection->getKeyValue(), "SHOP_NAME")."%";
			$where .= "SHOP_NAME like '$SHOP_NAM' ";
		}


		if ($where != "") {
			$where .= "and ";
		}
		$where .= parent::expsData("COMPANY_FUNC_HOTERL", "=", 1)." ";


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by SHOP_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, shop::keyName);

	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "a.COMPANY_ID, SHOP_STATUS, ";
		$sql .= "SHOP_NAME, ";
		$sql .= parent::decryptionList("COMPANY_CONTRACT_NAME")." ";
		$sql .= "from ".shop::tableName." a ";
		$sql .= "inner join COMPANY c on a.COMPANY_ID = c.COMPANY_ID ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("a.".shop::keyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "SHOP_NAME") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$SHOP_NAM = "%".$collection->getByKey($collection->getKeyValue(), "SHOP_NAME")."%";
			$where .= "SHOP_NAME like '$SHOP_NAM' ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by SHOP_ORDER, COMPANY_ID desc ";

		parent::setCollection($sql, shop::keyName);
	}

	public function select($id="", $statusComma="") {
		$sql  = "select ";
		$sql .= "SHOP_ID, COMPANY_ID, SHOP_NAME, SHOP_NAME_KANA, SHOP_TEL, SHOP_ADDRESS, SHOP_OPENTIME, SHOP_CLOSEDAY, SHOP_TEXT, ";

		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOP_PIC".$i.", ";
		}

		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOP_PIC_TEXT".$i.", ";
		}

			$sql .= "SHOP_PARKINGFLG, ";
			$sql .= "SHOP_PARKINGCAP, ";
			$sql .= "SHOP_PARKINGMONEYFLG, ";
			$sql .= "SHOP_PARKINGMONEY, ";
			$sql .= "SHOP_PARKINGBOOKFLG, ";

		for ($i=1; $i<=13; $i++) {
			$sql .= "SHOP_FACILITY".$i.", ";
		}

		for ($i=1; $i<=9; $i++) {
			$sql .= "SHOP_FACILITY_CHARGE".$i.", ";
		}
		for ($i=11; $i<=12; $i++) {
			$sql .= "SHOP_FACILITY_CHARGE".$i.", ";
		}

		$sql .= "SHOP_LANG_FLG, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "SHOP_LANG_TYPE".$i.", ";
		}

		for ($i=1; $i<=7; $i++) {
			$sql .= "SHOP_CHILD".$i.", ";
		}

		$sql .= "SHOP_CHARGE_LIST, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "SHOP_CHARGE_FLG".$i.", ";
		}
		$sql .= "SHOP_CHARGE_CARD, ";

		$sql .= "SHOP_SAFETY_SEASON, SHOP_SAFETY_ASSOCIATION, SHOP_SAFETY_PASS, ";

		$sql .= "SHOP_SAFETY_FACFLG, SHOP_SAFETY_FACCOMPANY, SHOP_SAFETY_FACNAME, SHOP_SAFETY_FACMONEY, SHOP_SAFETY_FACETC, ";

		$sql .= "SHOP_SAFETY_INJFLG, SHOP_SAFETY_INJCOMPANY, SHOP_SAFETY_INJNAME, SHOP_SAFETY_INJMONEY1, SHOP_SAFETY_INJMONEY2, SHOP_SAFETY_INJFEE, SHOP_SAFETY_INJETC, SHOP_SAFETY_HOSPITAL, ";

		$sql .= "SHOP_ORDER, SHOP_STATUS  ";
		$sql .= "from ".shop::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".shop::keyName, "=", $id)." ";
		}

		if ($statusComma != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("SHOP_STATUS", "in", "(".$statusComma.")")." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by SHOP_ORDER desc ";

		parent::setCollection($sql, shop::keyName);
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
			$sql  = "update ".shop::tableName." set ";
			$sql .= parent::expsData("SHOP_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= shop::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$this->db->commit();
		return true;
	}



	public function insert($dataList) {
		$sql  = "insert into ".shop::tableName." (";
		$sql .= "SHOP_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "SHOP_NAME, ";
		$sql .= "SHOP_NAME_KANA, ";
		$sql .= "SHOP_TEL, ";
		$sql .= "SHOP_ADDRESS, ";
		$sql .= "SHOP_OPENTIME, ";
		$sql .= "SHOP_CLOSEDAY, ";
		$sql .= "SHOP_TEXT, ";

		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOP_PIC".$i.", ";
		}

		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOP_PIC_TEXT".$i.", ";
		}

		$sql .= "SHOP_PARKINGFLG, ";
		$sql .= "SHOP_PARKINGCAP, ";
		$sql .= "SHOP_PARKINGMONEYFLG, ";
		$sql .= "SHOP_PARKINGMONEY, ";
		$sql .= "SHOP_PARKINGBOOKFLG, ";

		for ($i=1; $i<=13; $i++) {
			$sql .= "SHOP_FACILITY".$i.", ";
		}
		for ($i=1; $i<=9; $i++) {
			$sql .= "SHOP_FACILITY_CHARGE".$i.", ";
		}
		for ($i=11; $i<=12; $i++) {
			$sql .= "SHOP_FACILITY_CHARGE".$i.", ";
		}

		$sql .= "SHOP_LANG_FLG, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "SHOP_LANG_TYPE".$i.", ";
		}

		for ($i=1; $i<=7; $i++) {
			$sql .= "SHOP_CHILD".$i.", ";
		}

		$sql .= "SHOP_CHARGE_LIST, ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "SHOP_CHARGE_FLG".$i.", ";
		}
		$sql .= "SHOP_CHARGE_CARD, ";

		$sql .= "SHOP_SAFETY_SEASON, ";
		$sql .= "SHOP_SAFETY_ASSOCIATION, ";
		$sql .= "SHOP_SAFETY_PASS, ";

		$sql .= "SHOP_SAFETY_FACFLG, ";
		$sql .= "SHOP_SAFETY_FACCOMPANY, ";
		$sql .= "SHOP_SAFETY_FACNAME, ";
		$sql .= "SHOP_SAFETY_FACMONEY, ";
		$sql .= "SHOP_SAFETY_FACETC, ";

		$sql .= "SHOP_SAFETY_INJFLG, ";
		$sql .= "SHOP_SAFETY_INJCOMPANY, ";
		$sql .= "SHOP_SAFETY_INJNAME, ";
		$sql .= "SHOP_SAFETY_INJMONEY1, ";
		$sql .= "SHOP_SAFETY_INJMONEY2, ";
		$sql .= "SHOP_SAFETY_INJFEE, ";
		$sql .= "SHOP_SAFETY_INJETC, ";
		$sql .= "SHOP_SAFETY_HOSPITAL, ";

		$sql .= "SHOP_ORDER, ";
		$sql .= "SHOP_STATUS, ";
		$sql .= "SHOP_REGIST, ";
		$sql .= "SHOP_UPDATE) values (";


 		$sql .= "null, ";
		$sql .= "'".$dataList["COMPANY_ID"]."', ";
		$sql .= "'".$dataList["SHOP_NAME"]."', ";
		$sql .= "'".$dataList["SHOP_NAME_KANA"]."', ";
		$sql .= "'".$dataList["SHOP_TEL"]."', ";
		$sql .= "'".$dataList["SHOP_ADDRESS"]."', ";
		$sql .= "'".$dataList["SHOP_OPENTIME"]."', ";
		$sql .= "'".$dataList["SHOP_CLOSEDAY"]."', ";
		$sql .= "'".$dataList["SHOP_TEXT"]."', ";

		for ($i=1; $i<=6; $i++) {
			$sql .= "'".$dataList["SHOP_PIC".$i]."', ";
		}

		for ($i=1; $i<=6; $i++) {
			$sql .= "'".$dataList["SHOP_PIC_TEXT".$i]."', ";
		}

		$sql .= "'".$dataList["SHOP_PARKINGFLG"]."', ";
		$sql .= "'".$dataList["SHOP_PARKINGCAP"]."', ";
		$sql .= "'".$dataList["SHOP_PARKINGMONEYFLG"]."', ";
		$sql .= "'".$dataList["SHOP_PARKINGMONEY"]."', ";
		$sql .= "'".$dataList["SHOP_PARKINGBOOKFLG"]."', ";

		for ($i=1; $i<=13; $i++) {
			$sql .= "'".$dataList["SHOP_FACILITY".$i]."', ";
		}
		for ($i=1; $i<=9; $i++) {
			$sql .= "'".$dataList["SHOP_FACILITY_CHARGE".$i]."', ";
		}
		for ($i=11; $i<=12; $i++) {
			$sql .= "'".$dataList["SHOP_FACILITY_CHARGE".$i]."', ";
		}

		$sql .= "'".$dataList["SHOP_LANG_FLG"]."', ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "'".$dataList["SHOP_LANG_TYPE".$i]."', ";
		}

		for ($i=1; $i<=7; $i++) {
			$sql .= "'".$dataList["SHOP_CHILD".$i]."', ";
		}

		$sql .= "'".$dataList["SHOP_CHARGE_LIST"]."', ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "'".$dataList["SHOP_CHARGE_FLG".$i]."', ";
		}
		$sql .= "'".$dataList["SHOP_CHARGE_CARD"]."', ";

		$sql .= "'".$dataList["SHOP_SAFETY_SEASON"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_ASSOCIATION"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_PASS"]."', ";

		$sql .= "'".$dataList["SHOP_SAFETY_FACFLG"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_FACCOMPANY"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_FACNAME"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_FACMONEY"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_FACETC"]."', ";

		$sql .= "'".$dataList["SHOP_SAFETY_INJFLG"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_INJCOMPANY"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_INJNAME"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_INJMONEY1"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_INJMONEY2"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_INJFEE"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_INJETC"]."', ";
		$sql .= "'".$dataList["SHOP_SAFETY_HOSPITAL"]."', ";

		$sql .= "0, ";
		$sql .= "1, ";
		$sql .= "now(), ";
		$sql .= "now()) ";
	print $sql;
//print_r(debug_backtrace());


		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".shop::tableName." set ";
		$sql .= "SHOP_NAME = '".$dataList["SHOP_NAME"]."', ";
		$sql .= "SHOP_NAME_KANA = '".$dataList["SHOP_NAME_KANA"]."', ";
		$sql .= "SHOP_TEL = '".$dataList["SHOP_TEL"]."', ";
		$sql .= "SHOP_ADDRESS = '".$dataList["SHOP_ADDRESS"]."', ";
		$sql .= "SHOP_OPENTIME = '".$dataList["SHOP_OPENTIME"]."', ";
		$sql .= "SHOP_CLOSEDAY = '".$dataList["SHOP_CLOSEDAY"]."', ";
		$sql .= "SHOP_TEXT = '".$dataList["SHOP_TEXT"]."', ";

		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOP_PIC".$i." = '".$dataList["SHOP_PIC".$i]."', ";
		}

		for ($i=1; $i<=6; $i++) {
			$sql .= "SHOP_PIC_TEXT".$i." = '".$dataList["SHOP_PIC_TEXT".$i]."', ";
		}

		$sql .= "SHOP_PARKINGFLG = '".$dataList["SHOP_PARKINGFLG"]."', ";
		$sql .= "SHOP_PARKINGCAP = '".$dataList["SHOP_PARKINGCAP"]."', ";
		$sql .= "SHOP_PARKINGMONEYFLG = '".$dataList["SHOP_PARKINGMONEYFLG"]."', ";
		$sql .= "SHOP_PARKINGMONEY = '".$dataList["SHOP_PARKINGMONEY"]."', ";
		$sql .= "SHOP_PARKINGBOOKFLG = '".$dataList["SHOP_PARKINGBOOKFLG"]."', ";

		for ($i=1; $i<=13; $i++) {
			$sql .= "SHOP_FACILITY".$i." = '".$dataList["SHOP_FACILITY".$i]."', ";
		}

		for ($i=1; $i<=9; $i++) {
			$sql .= "SHOP_FACILITY_CHARGE".$i." = '".$dataList["SHOP_FACILITY_CHARGE".$i]."', ";
		}
		for ($i=11; $i<=12; $i++) {
			$sql .= "SHOP_FACILITY_CHARGE".$i." = '".$dataList["SHOP_FACILITY_CHARGE".$i]."', ";
		}

		$sql .= "SHOP_LANG_FLG = '".$dataList["SHOP_LANG_FLG"]."', ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "SHOP_LANG_TYPE".$i." = '".$dataList["SHOP_LANG_TYPE".$i]."', ";
		}

		for ($i=1; $i<=7; $i++) {
			$sql .= "SHOP_CHILD".$i." = '".$dataList["SHOP_CHILD".$i]."', ";
		}

		$sql .= "SHOP_CHARGE_LIST = '".$dataList["SHOP_CHARGE_LIST"]."', ";
		for ($i=1; $i<=5; $i++) {
			$sql .= "SHOP_CHARGE_FLG".$i." = '".$dataList["SHOP_CHARGE_FLG".$i]."', ";
		}
		$sql .= "SHOP_CHARGE_CARD = '".$dataList["SHOP_CHARGE_CARD"]."', ";

		$sql .= "SHOP_SAFETY_SEASON = '".$dataList["SHOP_SAFETY_SEASON"]."', ";
		$sql .= "SHOP_SAFETY_ASSOCIATION = '".$dataList["SHOP_SAFETY_ASSOCIATION"]."', ";
		$sql .= "SHOP_SAFETY_PASS = '".$dataList["SHOP_SAFETY_PASS"]."', ";

		$sql .= "SHOP_SAFETY_FACFLG = '".$dataList["SHOP_SAFETY_FACFLG"]."', ";
		$sql .= "SHOP_SAFETY_FACCOMPANY = '".$dataList["SHOP_SAFETY_FACCOMPANY"]."', ";
		$sql .= "SHOP_SAFETY_FACNAME = '".$dataList["SHOP_SAFETY_FACNAME"]."', ";
		$sql .= "SHOP_SAFETY_FACMONEY = '".$dataList["SHOP_SAFETY_FACMONEY"]."', ";
		$sql .= "SHOP_SAFETY_FACETC = '".$dataList["SHOP_SAFETY_FACETC"]."', ";

		$sql .= "SHOP_SAFETY_INJFLG = '".$dataList["SHOP_SAFETY_INJFLG"]."', ";
		$sql .= "SHOP_SAFETY_INJCOMPANY = '".$dataList["SHOP_SAFETY_INJCOMPANY"]."', ";
		$sql .= "SHOP_SAFETY_INJNAME = '".$dataList["SHOP_SAFETY_INJNAME"]."', ";
		$sql .= "SHOP_SAFETY_INJMONEY1 = '".$dataList["SHOP_SAFETY_INJMONEY1"]."', ";
		$sql .= "SHOP_SAFETY_INJMONEY2 = '".$dataList["SHOP_SAFETY_INJMONEY2"]."', ";
		$sql .= "SHOP_SAFETY_INJFEE = '".$dataList["SHOP_SAFETY_INJFEE"]."', ";
		$sql .= "SHOP_SAFETY_INJETC = '".$dataList["SHOP_SAFETY_INJETC"]."', ";
		$sql .= "SHOP_SAFETY_HOSPITAL = '".$dataList["SHOP_SAFETY_HOSPITAL"]."', ";

		$sql .= "SHOP_ORDER = '".$dataList["SHOP_ORDER"]."', ";
		$sql .= "SHOP_STATUS = '".$dataList["SHOP_STATUS"]."', ";
		$sql .= "SHOP_UPDATE = "."now()"." ";
		$sql .= "where ";
		$sql .=  shop::keyName." = ".parent::getKeyValue() ;
//	print $sql;

		return $sql;
	}

	public function delete() {
		$this->db->begin();

		$sql .= "update ".shop::tableName." set ";
		$sql .= parent::expsData("SHOP_STATUS", "=", 3).", ";
		$sql .= parent::expsData("SHOP_DELETE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(shop::keyName, "=", parent::getKeyValue())." ";

		if (!parent::saveExec($sql)) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();
		return true;

	}

	public function check() {
		if (!$_POST) return;


		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_NAME"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_NAME"), 100)) {
				parent::setError("SHOP_NAME", "100文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_NAME_KANA"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_NAME_KANA"), 100)) {
				parent::setError("SHOP_NAME_KANA", "100文字以内で入力して下さい");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_NAME_KANA"), CHK_PTN_KANA)) {
				parent::setError("SHOP_NAME_KANA", "全角カナで入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_ADDRESS"))) {
			if (!cmChekLength(parent::getByKey(parent::getKeyValue(), "SHOP_ADDRESS"), 100)) {
				parent::setError("SHOP_ADDRESS", "100文字以内で入力して下さい");
			}
		}

		if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "SHOP_TEL"))) {
			if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "SHOP_TEL"), CHK_PTN_TEL)) {
				parent::setError("SHOP_TEL", "電話番号は00-0000-0000の形式で入力して下さい");
			}
		}


		for ($i=1; $i<=6; $i++) {
			if (parent::getByKey(parent::getKeyValue(), "SHOP_PIC".$i."_setup") != "") {
				$this->setByKey($this->getKeyValue(), "SHOP_PIC".$i, $this->getByKey($this->getKeyValue(), "SHOP_PIC".$i."_setup"));
			}
			else {
				$inputer = new inputs();
				$inputer->setId(parent::getByKey(parent::getKeyValue(), "COMPANY_ID"));
				$msg = $inputer->upload("SHOP_PIC".$i, IMG_HOTEL_APP_SIZE, IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, 1);
				if (!$inputer->getHandle()) {
					if ($msg != "non") {
						parent::setError("SHOP_PIC".$i, $msg);
					}
					else {
					}
				}
				else {
					parent::setByKey(parent::getKeyValue(), "SHOP_PIC".$i, $msg);
				}

			}
		}


	}

	public function setPost($picFLg=false) {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			$dataCard = "";
			if (count($_POST["card"]) > 0) {
				foreach ($_POST["card"] as $d) {
					if ($dataCard != "") {
						$dataCard .= ":";
					}
					$dataCard .= $d;
				}
				$this->setByKey($this->getKeyValue(), "SHOP_CHARGE_CARD", ":".$dataCard.":");
			}
			else {
				//$this->setByKey($this->getKeyValue(), "SHOP_LIST_AREA", $this->getByKey($this->getKeyValue(), "SHOP_LIST_AREA"));
				$this->setByKey($this->getKeyValue(), "SHOP_CHARGE_CARD", '');
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
					$this->setByKey($this->getKeyValue(), "SHOP_ROOM_LIST".$i, ":".$dataRoomList.":");
				}
				else {
// 					$this->setByKey($this->getKeyValue(), "SHOP_ROOM_LIST".$i, $this->getByKey($this->getKeyValue(), "SHOP_ROOM_LIST".$i));
					$this->setByKey($this->getKeyValue(), "SHOP_ROOM_LIST".$i, '');
				}
			}


		}

	}


}
?>