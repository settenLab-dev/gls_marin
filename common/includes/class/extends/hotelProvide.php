<?php
class hotelProvide extends collection {
	const tableName = "HOTELPROVIDE";
	const keyName = "HOTELPROVIDE_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelProvide($db) {
		parent::collection($db);
	}

	public function selectListPublic($collection) {
		$sql  = "select ";
		$sql .= "HOTELPROVIDE_ID, COMPANY_ID,  ROOM_ID, HOTELPROVIDE_DATE, HOTELPROVIDE_FLG_STOP, HOTELPROVIDE_FLG_REQUEST, HOTELPROVIDE_NUM, HOTELPROVIDE_BOOKEDNUM ";
		$sql .= "from ".hotelProvide::tableName." hprov ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelProvide::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelProvide::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}


		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPROVIDE_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"), true)." ";
			$where .= "and ".parent::expsData("HOTELPROVIDE_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE")))), true)." ";
		}


		//	宿泊数
//		if ($collection->getByKey($collection->getKeyValue(), "night_number") >= 1) {
//			//	1泊
//			//	部屋数
//			if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
//				if ($where != "") {
//					$where .= "and ";
//				}
//				$where .= parent::expsData("hprov.HOTELPROVIDE_NUM", ">=", $collection->getByKey($collection->getKeyValue(), "room_number"))." ";
//			}
//		}
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
				$where .= "HOTELPROVIDE_DATE = date_add(hprov.HOTELPROVIDE_DATE, interval ".($i-1)." day) ";
				$where .= "and ".parent::expsData("ROOM_ID", "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
				$where .= "and ".parent::expsData("COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
				$where .= "and HOTELPROVIDE_FLG_STOP = 1 ";
				// 部屋数
				if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
					$where .= "and ".parent::expsData("HOTELPROVIDE_NUM", ">=", $collection->getByKey($collection->getKeyValue(), "room_number"))." ";
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
				$where .= "HOTELPAY_DATE = date_add(hprov.HOTELPROVIDE_DATE, interval ".($i-1)." day) ";
				$where .= "and ".parent::expsData("ROOM_ID", "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
				$where .= "and ".parent::expsData("COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
				$where .= "and ".parent::expsData("HOTELPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
				$where .= ") ";
			}
		}


		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPROVIDE_DATE  ";
//		print_r($sql);exit;
		parent::setCollection($sql, hotelProvide::keyName);
//	print $sql;
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "HOTELPROVIDE_ID, COMPANY_ID,  ROOM_ID, HOTELPROVIDE_DATE, HOTELPROVIDE_FLG_STOP, HOTELPROVIDE_FLG_REQUEST, HOTELPROVIDE_NUM, HOTELPROVIDE_BOOKEDNUM ";
		$sql .= "from ".hotelProvide::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelProvide::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelProvide::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ROOM_ID", "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPROVIDE_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE"), true)." ";
			$where .= "and ".parent::expsData("HOTELPROVIDE_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPROVIDE_DATE")))), true)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPROVIDE_DATE  ";

		parent::setCollection($sql, hotelProvide::keyName);
	}

	public function select($id="", $companyId="", $roomId="" , $provideDate="") {
		$sql  = "select ";
		$sql  = "select ";
		$sql .= "HOTELPROVIDE_ID, COMPANY_ID,  ROOM_ID, HOTELPROVIDE_DATE, HOTELPROVIDE_FLG_STOP, HOTELPROVIDE_FLG_REQUEST, HOTELPROVIDE_NUM, HOTELPROVIDE_BOOKEDNUM ";
		$sql .= "from ".hotelProvide::tableName." ";

		$where = "";

		

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelProvide::tableKeyName, "=", $companyId)." ";
		}

		if ($roomId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ROOM_ID", "=", $roomId)." ";
		}
		
		if ($provideDate != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= "HOTELPROVIDE_DATE="."'".$provideDate."'"." ";
		}else{
			if ($id != "") {
				if ($where != "") {
					$where .= "and ";
				}
				$where .= parent::expsData("".hotelProvide::keyName, "=", $id)." ";
			}
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		$sql .= "order by HOTELPROVIDE_DATE  ";
		
		parent::setCollection($sql, hotelProvide::keyName);
	}

	public function saveAll() {
		$this->db->begin();
		$date = $_GET["date"]?$_GET["date"]:$_POST['date'];
		$tmp_arr = explode("-",$date);
		$total_day = get_total_days($tmp_arr[1], $tmp_arr[0]);
		
		for ($i = 1; $i <=$total_day; $i++) {
			if ($_POST["HOTELPROVIDE_FLG_STOP$i"]) {
				$d = $date.'-'.($i<10?'0'.$i:$i);
				//若是更新，找出HOTELPROVIDE_ID
				$this->setByKey($this->getKeyValue(), 'HOTELPROVIDE_ID', $_POST["HOTELPROVIDE_ID$i"]);
				$this->setByKey($this->getKeyValue(), 'HOTELPROVIDE_FLG_STOP', $_POST["HOTELPROVIDE_FLG_STOP$i"]);
				$this->setByKey($this->getKeyValue(), 'HOTELPROVIDE_FLG_REQUEST', $_POST["HOTELPROVIDE_FLG_REQUEST$i"]);
				$this->setByKey($this->getKeyValue(), 'HOTELPROVIDE_NUM', $_POST["HOTELPROVIDE_NUM$i"]);
				$this->setByKey($this->getKeyValue(), 'HOTELPROVIDE_DATE',$d);
				
				$this->setByKey($this->getKeyValue(), 'ROOM_ID', $_POST['ROOM_ID']);
				$this->setByKey($this->getKeyValue(), 'COMPANY_ID', $_POST["COMPANY_ID"]);
				
				$dataList = parent::getCollectionByKey(parent::getKeyValue());
				
				parent::setKeyValue($this->getByKey($this->getKeyValue(), 'HOTELPROVIDE_ID'));
				$sql = "";
				if (parent::saveDivide(parent::getKeyValue())) {
					$sql = $this->insert($dataList);
				}
				else {
					$sql = $this->update($dataList);
				}
// 				echo $this->getByKey($this->getKeyValue(), 'COMPANY_ID');exit;
// 				echo $sql;exit;
				if (!$this->saveExec($sql)) {
					$this->db->rollback();
					return false;
				}
			}
		}

		$this->db->commit();
		return true;
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
	
	/*
	public function save($hotelPlanTarget) {
		$this->db->begin();
		$sql = "";

		$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
		$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));

		for ($y=$from["y"]; $y<=$to["y"]; $y++) {
			for ($m=$from["m"]; $m<=$to["m"]; $m++) {
				for ($d=1; $d<=31; $d++) {

					$dd = str_pad($d, 2, "0", STR_PAD_LEFT);
					$mm = str_pad($m, 2, "0", STR_PAD_LEFT);


					if ($from["y"] == $y and $from["m"] == $m and $from["d"] > $d) {
// 					print "aa".$from["y"]."-".$from["m"]."-".$from["d"]."/".$y.'-'.$m.'-'.$dd.parent::getByKey($y.'-'.$m.'-'.$dd, "HOTELPAY_MONEY1")."<br />";
						continue;
					}
					if ($to["y"] == $y and $to["m"] == $m and $to["d"] < $d) {
						continue;
					}
					$dataList = array();
					$dataList["HOTELPAY_ID"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ID");
					$dataList["COMPANY_ID"] = parent::getByKey("COMPANY_ID", "COMPANY_ID");
					$dataList["HOTELPLAN_ID"] = parent::getByKey("HOTELPLAN_ID", "HOTELPLAN_ID");
					$dataList["ROOM_ID"] = parent::getByKey("ROOM_ID", "ROOM_ID");
					$dataList["HOTELPAY_DATE"] = $y.'-'.$mm.'-'.$dd;
					for ($i=1; $i<=4; $i++) {
						$dataList["HOTELPAY_PS_DATA".$i] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA".$i);
					}
					for ($i=1; $i<=14; $i++) {
						$dataList["HOTELPAY_BB_DATA".$i] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA".$i);
					}
					$dataList["HOTELPAY_SERVICE_FLG"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG");
					$dataList["HOTELPAY_SERVICE"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE");
					$dataList["HOTELPAY_REMARKS"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_REMARKS");
					for ($i=1; $i<=6; $i++) {
						$dataList["HOTELPAY_MONEY".$i] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i);
					}
					$dataList["HOTELPAY_FLG_STOP"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_FLG_STOP");
// 					$dataList["HOTELPAY_DATE"] = parent::getByKey($y.'-'.$m.'-'.$d, "HOTELPAY_DATE");
					$dataList["HOTELPAY_ROOM_NUM"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM");
					$dataList["HOTELPAY_ROOM_OVER"] = parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER");

// 					print_r($dataList);
// 					print parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ID");
// 					print "<br />-------------------------------<br />";
// 					continue;
// 					return ;
// 					if ($dataList["HOTELPAY_ID"] == "" or $dataList["HOTELPAY_ID"] <= 0) {
					if (parent::saveDivide($dataList["HOTELPAY_ID"])) {
						$sql = $this->insert($dataList);
					}
					else {
						$sql = $this->update($dataList);
					}

					if (!$this->saveExec($sql)) {
						$this->db->rollback();
						return false;
					}

				}
			}
		}

		$this->db->commit();
		return true;
	}
	*/

	public function insert($dataList) {
// 		for ($i = 1; $i <= 31; $i++) {
// 			if ($dataList["HOTELPROVIDE_FLG_STOP{$i}"]) {
// 				$tmp1[]=$dataList["HOTELPROVIDE_FLG_STOP{$i}"];
// 			}
// 			if ($dataList["HOTELPROVIDE_FLG_REQUEST{$i}"]) {
// 				$tmp2[]=$dataList["HOTELPROVIDE_FLG_REQUEST{$i}"];
// 			}
// 			if ($dataList["HOTELPROVIDE_NUM{$i}"]) {
// 				$tmp3[]=$dataList["HOTELPROVIDE_NUM{$i}"];
// 			}
// 		}
// 		$dataList["HOTELPROVIDE_FLG_STOP"] = count($tmp1)>0?implode(":",$tmp1):$dataList["HOTELPROVIDE_FLG_STOP"];
// 		$dataList["HOTELPROVIDE_FLG_REQUEST"] = count($tmp2)>0?implode(":",$tmp2):$dataList["HOTELPROVIDE_FLG_REQUEST"];
// 		$dataList["HOTELPROVIDE_NUM"] = count($tmp3)>0?implode(":",$tmp3):$dataList["HOTELPROVIDE_NUM"];
		
		$sql  = "insert into ".hotelProvide::tableName." (";
		$sql .= "HOTELPROVIDE_ID, ";
		$sql .= "ROOM_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "HOTELPROVIDE_DATE, ";
		$sql .= "HOTELPROVIDE_FLG_STOP, ";
		$sql .= "HOTELPROVIDE_FLG_REQUEST, ";
		$sql .= "HOTELPROVIDE_NUM, ";
		$sql .= "HOTELPROVIDE_DATE_REGIST, ";
		$sql .= "HOTELPROVIDE_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["ROOM_ID"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPROVIDE_DATE"], true).", ";
		$sql .= "'".parent::expsVal($dataList["HOTELPROVIDE_FLG_STOP"])."'".", ";
		$sql .= "'".parent::expsVal($dataList["HOTELPROVIDE_FLG_REQUEST"])."'".", ";
		$sql .= "'".parent::expsVal($dataList["HOTELPROVIDE_NUM"])."'".", ";
		$sql .= "now(), ";
		$sql .= "now()) ";
		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelProvide::tableName." set ";
		$sql .= parent::expsData("ROOM_ID", "=", $dataList["ROOM_ID"]).", ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("HOTELPROVIDE_DATE", "=", $dataList["HOTELPROVIDE_DATE"], true).", ";
		$sql .= parent::expsData("HOTELPROVIDE_FLG_STOP", "=", $dataList["HOTELPROVIDE_FLG_STOP"]).", ";
		$sql .= parent::expsData("HOTELPROVIDE_FLG_REQUEST", "=", $dataList["HOTELPROVIDE_FLG_REQUEST"]).", ";
		$sql .= parent::expsData("HOTELPROVIDE_NUM", "=", $dataList["HOTELPROVIDE_NUM"]).", ";
		$sql .= parent::expsData("HOTELPROVIDE_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelProvide::keyName, "=", $dataList["HOTELPROVIDE_ID"])." ";

		return $sql;
	}

	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".hotelProvide::tableName." set ";
// 		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(hotelProvide::keyName, "=", parent::getKeyValue())." ";

// 		if (!parent::saveExec($sql)) {
// 			$this->db->rollback();
// 			return false;
// 		}

// 		$this->db->commit();
// 		return true;

	}

	public function check() {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_DATE"))) {
			parent::setError("HOTELPROVIDE_DATE", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_FLG_STOP"))) {
			parent::setError("HOTELPROVIDE_FLG_STOP", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_FLG_REQUEST"))) {
			parent::setError("HOTELPROVIDE_FLG_REQUEST", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_FLG_REQUEST") == 1) {

			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_NUM"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_NUM"), CHK_PTN_NUM)) {
					parent::setError("HOTELPROVIDE_NUM", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_NUM"), 10)) {
					parent::setError("HOTELPROVIDE_NUM", "10文字以内で入力して下さい");
				}
			}

		}
		else {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_NUM"))) {
				//parent::setError("HOTELPROVIDE_NUM", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_NUM"), CHK_PTN_NUM)) {
				parent::setError("HOTELPROVIDE_NUM", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPROVIDE_NUM"), 10)) {
				parent::setError("HOTELPROVIDE_NUM", "10文字以内で入力して下さい");
			}
		}

	}

	/*
	public function check($hotelPlanTarget) {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA1"))) {
			parent::setError("HOTELPAY_PS_DATA1", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA1") == 1) {
				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"))) {
					parent::setError("HOTELPAY_PS_DATA3", "必須項目です");
				}
				elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_PS_DATA3", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), 10)) {
					parent::setError("HOTELPAY_PS_DATA3", "10文字以内で入力して下さい");
				}

				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA4"))) {
					parent::setError("HOTELPAY_PS_DATA4", "必須項目です");
				}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_PS_DATA3", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA3"), 10)) {
					parent::setError("HOTELPAY_PS_DATA3", "10文字以内で入力して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA1"))) {
			parent::setError("HOTELPAY_BB_DATA1", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA1") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"))) {
				parent::setError("HOTELPAY_BB_DATA3", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA3", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), 10)) {
				parent::setError("HOTELPAY_BB_DATA3", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA4"))) {
				parent::setError("HOTELPAY_BB_DATA4", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA3", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA3"), 10)) {
					parent::setError("HOTELPAY_BB_DATA3", "10文字以内で入力して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA5"))) {
			parent::setError("HOTELPAY_BB_DATA5", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA5") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"))) {
				parent::setError("HOTELPAY_BB_DATA6", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA6", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), 10)) {
				parent::setError("HOTELPAY_BB_DATA6", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA7"))) {
				parent::setError("HOTELPAY_BB_DATA7", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA6", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA6"), 10)) {
					parent::setError("HOTELPAY_BB_DATA6", "10文字以内で入力して下さい");
				}
			}
		}



		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA8"))) {
			parent::setError("HOTELPAY_BB_DATA8", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA8") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"))) {
				parent::setError("HOTELPAY_BB_DATA10", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA10", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), 10)) {
				parent::setError("HOTELPAY_BB_DATA10", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA11"))) {
				parent::setError("HOTELPAY_BB_DATA11", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA10", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA10"), 10)) {
					parent::setError("HOTELPAY_BB_DATA10", "10文字以内で入力して下さい");
				}
			}
		}



		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA12"))) {
			parent::setError("HOTELPAY_BB_DATA12", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA12") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"))) {
				parent::setError("HOTELPAY_BB_DATA13", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_BB_DATA13", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), 10)) {
				parent::setError("HOTELPAY_BB_DATA13", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA14"))) {
				parent::setError("HOTELPAY_BB_DATA14", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_BB_DATA13", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA13"), 10)) {
					parent::setError("HOTELPAY_BB_DATA13", "10文字以内で入力して下さい");
				}
			}
		}


		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG"))) {
			parent::setError("HOTELPAY_SERVICE_FLG", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG") == 2) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"))) {
				parent::setError("HOTELPAY_SERVICE", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_SERVICE", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), 10)) {
				parent::setError("HOTELPAY_SERVICE", "10文字以内で入力して下さい");
			}

		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_SERVICE", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE"), 10)) {
					parent::setError("HOTELPAY_SERVICE", "10文字以内で入力して下さい");
				}
			}
		}


		$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
		$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));

		$erCalender = array();

		for ($y=$from["y"]; $y<=$to["y"]; $y++) {
			for ($m=$from["m"]; $m<=$to["m"]; $m++) {
				for ($d=1; $d<=31; $d++) {


					$dd = str_pad($d, 2, "0", STR_PAD_LEFT);
					$mm = str_pad($m, 2, "0", STR_PAD_LEFT);

					if (strtotime($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM")) <= strtotime($y.'-'.$mm.'-'.$dd) and
						strtotime($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO")) >= strtotime($y.'-'.$mm.'-'.$dd) ) {


// 					if (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_FLG_STOP") == 1) {
						//	売りの場合
						for ($i=1; $i<=6; $i++) {
							if (!cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i))) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は必須項目です。";
							}
							elseif (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i), CHK_PTN_NUM) and parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) != "x") {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は「x」か半角数字で入力して下さい。";
							}
							elseif (!cmChekLength(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i), 10)) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は「x」半角数字10文字以内で入力して下さい。";
							}
							else {

								if (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) > parent::getByKey("BOOKSET_PAY_ALARM", "BOOKSET_PAY_ALARM")  and parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) != "x") {
									$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」がアラーム設定された金額を上回っています。";
								}
							}
						}

						if (!cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"))) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は必須項目です。";
						}
						elseif (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"), CHK_PTN_NUM)) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は半角数字で入力してください。";
						}
						elseif (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM") < 1 or parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM") > 10) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は1～10%で入力してください。";
						}


					}
				}
			}
		}

		if (count($erCalender) > 0) {
			parent::setError("calencer", $erCalender);
		}

	}
	*/

	/*
	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".hotelProvide::tableName." set ";
			$sql .= parent::expsData("HOTELPICGROUP_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelProvide::keyName." = ".$v." ";
			if (!parent::saveExec($sql)) {
				$this->db->rollback();
				return false;
			}
		}

		$this->db->commit();
		return true;
	}
	*/

	public function setPost() {
		if ($_POST) {

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
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
				$this->setByKey($this->getKeyValue(), "hotelProvide_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelProvide_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelProvide_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelProvide_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelProvide_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelProvide_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelProvide_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelProvide_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelProvide_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelProvide_LIST_AREA"));
			}
			*/


		}

	}


}
?>