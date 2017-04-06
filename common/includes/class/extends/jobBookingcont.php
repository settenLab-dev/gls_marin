<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/jobBooking.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mMail.php');

class jobBookingcont extends collection {
	const tableName = "BOOKINGCONT";
	const keyName = "BOOKINGCONT_ID";
	const tableKeyName = "BOOKING_ID";

	public function jobBookingcont($db) {
		parent::collection($db);
	}

	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "BOOKINGCONT_ID, BOOKING_ID, COMPANY_ID, BOOKINGCONT_DATE, BOOKINGCONT_ROOM, ";
		$sql .= "BOOKINGCONT_LINK, BOOKINGCONT_BOOKING_CODE, ";
		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKINGCONT_NUM".$i.", ";
		}
		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKINGCONT_MONEY".$i.", ";
		}
		$sql .= "BOOKINGCONT_MONEY, BOOKINGCONT_MONEY_CANCEL, BOOKINGCONT_STATUS, BOOKINGCONT_DATE_CANCEL ";
		$sql .= "from ".jobBookingcont::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBookingcont::keyName, "=", $collection->getByKey($collection->getKeyValue(), "BOOKINGCONT_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "BOOKING_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBookingcont::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "BOOKING_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by BOOKING_ID  ";
		
// 		echo $sql;exit;

		parent::setCollection($sql, jobBookingcont::keyName);
	}

	public function select($id="", $bookingId="", $companyId="") {
		$sql  = "select ";
		$sql .= "BOOKINGCONT_ID, BOOKING_ID, COMPANY_ID, BOOKINGCONT_DATE, BOOKINGCONT_ROOM, ";
		$sql .= "BOOKINGCONT_LINK, BOOKINGCONT_BOOKING_CODE, ";
		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKINGCONT_NUM".$i.", ";
		}
		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKINGCONT_MONEY".$i.", ";
		}
		$sql .= "BOOKINGCONT_MONEY, BOOKINGCONT_MONEY_CANCEL, BOOKINGCONT_STATUS ";
		$sql .= "from ".jobBookingcont::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBookingcont::keyName, "=", $id)." ";
		}

		if ($bookingId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".jobBookingcont::tableKeyName, "=", $bookingId)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("COMPANY_ID", "=", $companyId)." ";
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by BOOKING_ID  ";

		parent::setCollection($sql, jobBookingcont::keyName);
	}

	public function save() {
// 		$this->db->begin();
		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		$sql = "";
		
		if (parent::saveDivide(parent::getKeyValue())) {
			$sql = $this->insert($dataList);
		}
		else {
			$sql = $this->update($dataList);
		}
		if (!$this->saveExec($sql)) {
// 			$this->db->rollback();
			return false;
		}

// 		$this->db->commit();
		return true;
	}

	public function saveAll($targetArray, $bookingid) {
// 		$this->db->begin();
		$sql = "";

		if (count($targetArray) > 0) {
			foreach ($targetArray as $data) {
				$registdata = new hotelBookingcont($this->db);
				$registdata->setByKey($registdata->getKeyValue(), "BOOKING_ID", $bookingid);
				$registdata->setByKey($registdata->getKeyValue(), "COMPANY_ID", $data["COMPANY_ID"]);
				$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_LINK", $data["BOOKINGCONT_LINK"]);
				$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_BOOKING_CODE", $data["BOOKINGCONT_BOOKING_CODE"]);
				$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_DATE", $data["BOOKINGCONT_DATE"]);
				$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_ROOM", $data["BOOKINGCONT_ROOM"]);
				for ($i=1; $i<=8; $i++) {
					$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_NUM".$i, $data["BOOKINGCONT_NUM".$i]);
				}
				for ($i=1; $i<=7; $i++) {
					$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_MONEY".$i, $data["BOOKINGCONT_MONEY".$i]);
				}
				$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_MONEY", $data["BOOKINGCONT_MONEY"]);
				$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_MONEY_CANCEL", $data["BOOKINGCONT_MONEY_CANCEL"]);
				$registdata->setByKey($registdata->getKeyValue(), "BOOKINGCONT_STATUS", $data["BOOKINGCONT_STATUS"]);

// 				print_r($data);
// 				return false;
				if (!$registdata->save()) {
// 					$this->db->rollback();
					return false;
				}
			}
		}
		else {
// 			$this->db->rollback();
			return false;
		}

// 		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".jobBookingcont::tableName." (";
		$sql .= "BOOKINGCONT_ID, ";
		$sql .= "BOOKING_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "BOOKINGCONT_LINK, ";
		$sql .= "BOOKINGCONT_BOOKING_CODE, ";
		$sql .= "BOOKINGCONT_DATE, ";
		$sql .= "BOOKINGCONT_ROOM, ";
		for ($i=1; $i<=8; $i++) {
			$sql .= "BOOKINGCONT_NUM".$i.", ";
		}
		for ($i=1; $i<=7; $i++) {
			$sql .= "BOOKINGCONT_MONEY".$i.", ";
		}
		$sql .= "BOOKINGCONT_MONEY, ";
		$sql .= "BOOKINGCONT_MONEY_CANCEL, ";
		$sql .= "BOOKINGCONT_STATUS, ";
		$sql .= "BOOKINGCONT_DATE_REGIST, ";
		$sql .= "BOOKINGCONT_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["BOOKING_ID"]).", ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["BOOKINGCONT_LINK"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKINGCONT_BOOKING_CODE"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKINGCONT_DATE"], true).", ";
		$sql .= parent::expsVal($dataList["BOOKINGCONT_ROOM"]).", ";
		for ($i=1; $i<=8; $i++) {
			$sql .= parent::expsVal($dataList["BOOKINGCONT_NUM".$i]).", ";
		}
		for ($i=1; $i<=7; $i++) {
			$sql .= parent::expsVal($dataList["BOOKINGCONT_MONEY".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["BOOKINGCONT_MONEY"]).", ";
		$sql .= parent::expsVal($dataList["BOOKINGCONT_MONEY_CANCEL"]).", ";
		$sql .= parent::expsVal($dataList["BOOKINGCONT_STATUS"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".jobBookingcont::tableName." set ";
		$sql .= parent::expsData("BOOKING_ID", "=", $dataList["BOOKING_ID"]).", ";
		$sql .= parent::expsData("BOOKINGCONT_LINK", "=", $dataList["BOOKINGCONT_LINK"], true).", ";
		$sql .= parent::expsData("BOOKINGCONT_BOOKING_CODE", "=", $dataList["BOOKINGCONT_BOOKING_CODE"], true).", ";
		$sql .= parent::expsData("BOOKINGCONT_DATE", "=", $dataList["BOOKINGCONT_DATE"], true).", ";
		$sql .= parent::expsData("BOOKINGCONT_ROOM", "=", $dataList["BOOKINGCONT_ROOM"]).", ";
		for ($i=1; $i<=8; $i++) {
			$sql .= parent::expsData("BOOKINGCONT_NUM".$i, "=", $dataList["BOOKINGCONT_NUM".$i]).", ";
		}
		for ($i=1; $i<=7; $i++) {
			$sql .= parent::expsData("BOOKINGCONT_MONEY".$i, "=", $dataList["BOOKINGCONT_MONEY".$i]).", ";
		}
		$sql .= parent::expsData("BOOKINGCONT_MONEY", "=", $dataList["BOOKINGCONT_MONEY"]).", ";
		$sql .= parent::expsData("BOOKINGCONT_MONEY_CANCEL", "=", $dataList["BOOKINGCONT_MONEY_CANCEL"]).", ";
		$sql .= parent::expsData("BOOKINGCONT_STATUS", "=", $dataList["BOOKINGCONT_STATUS"]).", ";
		$sql .= parent::expsData("BOOKINGCONT_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(jobBookingcont::keyName, "=", parent::getKeyValue())." ";

		return $sql;
	}



	public function updateBooking($id, $bookingCode) {

		$sql .= "update ".jobBookingcont::tableName." set ";
		$sql .= parent::expsData("BOOKINGCONT_BOOKING_CODE", "=", $bookingCode, true).", ";
		$sql .= parent::expsData("BOOKINGCONT_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData("BOOKING_ID", "=", $id)." ";

		if (!parent::saveExec($sql)) {
			return false;
		}

		return true;
	}
	
	public function updateBookingStatus($id, $bookingStatus) {
	
			$sql .= "update ".jobBookingcont::tableName." set ";
			$sql .= parent::expsData("BOOKINGCONT_STATUS", "=", $bookingStatus, true)." ";
			$sql .= "where ";
			$sql .=  parent::expsData("BOOKING_ID", "=", $id)." ";
	
			if (!parent::saveExec($sql)) {
				return false;
			}
	
			return true;
		}


	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".jobBookingcont::tableName." set ";
// 		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(jobBookingcont::keyName, "=", parent::getKeyValue())." ";

// 		if (!parent::saveExec($sql)) {
// 			$this->db->rollback();
// 			return false;
// 		}

// 		$this->db->commit();
// 		return true;

	}


	public function cancel($hotelBooking, $hotelBookset) {
		$this->db->begin();
		$hotelBooking->setByKey($hotelBooking->getKeyValue(),"ROOM_ID", parent::getByKey(parent::getKeyValue(), "ROOM_ID"));
		if (parent::getByKey(parent::getKeyValue(), "all_cancel")) {
			if (!$hotelBooking->cancel()) {
				$this->db->rollback();
				return false;
			}
		}

		if (count(parent::getByKey(parent::getKeyValue(), "canceldata")) <= 0) {
		}
		else {
			foreach (parent::getByKey(parent::getKeyValue(), "canceldata") as $k=>$v) {

				$cancel_money = 0;

				//	キャンセル金額計算
				if (parent::getByKey(parent::getKeyValue(), "targetCancel") == 1) {
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {
						//	共通
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {
							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
							//	無拍
								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
									//	パーセント
									$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")/100);
								}
								else {
									//	固定額
									$cancel_money = $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1");
								}
							}
						}
					}
					else {
						//	個別
						if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {
							if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")/100);
							}
							else {
								$cancel_money = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1");
							}
						}
					}
				}
				elseif (parent::getByKey(parent::getKeyValue(), "targetCancel") == 2) {
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {
							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
								//	パーセント
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")/100);
							}
							else {
								$cancel_money =  $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2");
							}
						}
					}
					else {

						if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {

							if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")/100);
							}
							else {
								$cancel_money = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2");
							}
						}
					}
				}
				elseif (parent::getByKey(parent::getKeyValue(), "targetCancel") >= 3) {

					$i = parent::getByKey(parent::getKeyValue(), "targetCancel");
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {

							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {
								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
									$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)/100);
								}
								else {
									$cancel_money = $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i);
								}
							}

					}
					else {

							if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {
								if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
									$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)/100);
								}
								else {
									$cancel_money = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i);
								}
							}

					}
				}
				
				if (!$this->targetDataCancel($k, $cancel_money)) {
					$this->db->rollback();
					return false;
				}
				/*
				$sql = "";
				$sql .= "update HOTELPROVIDE set HOTELPROVIDE_BOOKEDNUM = HOTELPROVIDE_BOOKEDNUM - ".$dataList["BOOKING_NUM_NIGHT"];
				$sql .= " where ROOM_ID=".parent::getByKey($k, "ROOM_ID");
				$sql .= " and COMPANY_ID = ".parent::getByKey($k, "COMPANY_ID");
				$sql .= " and HOTELPROVIDE_DATE = '".parent::getByKey($k, "BOOKING_DATE")."'";
				
				print_r($sql);exit;
				*/
				$sql = "";
				$sql .= "update HOTELPROVIDE set HOTELPROVIDE_BOOKEDNUM = HOTELPROVIDE_BOOKEDNUM - ".$hotelBooking->getByKey($hotelBooking->getKeyValue(), "night_number");
				// 				$sql .= " where ROOM_ID=".parent::getByKey($k, "ROOM_ID");
				$sql .= " where ROOM_ID=".parent::getByKey(parent::getKeyValue(), "ROOM_ID");
				$sql .= " and COMPANY_ID = ".parent::getByKey($k, "COMPANY_ID");
				$sql .= " and HOTELPROVIDE_DATE = '".parent::getByKey(parent::getKeyValue(), "BOOKINGCONT_DATE")."'";
				if (!$this->saveExec($sql)) {
					$this->db->rollback();
					return false;
				}
		
// 				print "".$cancel_money."\n";
// 				print "".$k."\n";

			}
		}

		$this->db->commit();
		return true;
	}

	public function noshow($hotelBooking, $hotelBookset) {
		$this->db->begin();
	
		if (parent::getByKey(parent::getKeyValue(), "all_cancel")) {
			if (!$hotelBooking->noshow()) {
				$this->db->rollback();
				return false;
			}
		}
	
		if (count(parent::getByKey(parent::getKeyValue(), "canceldata")) <= 0) {
		}
		else {
			foreach (parent::getByKey(parent::getKeyValue(), "canceldata") as $k=>$v) {
	
				$cancel_money = 0;
	
				//	キャンセル金額計算
				if (parent::getByKey(parent::getKeyValue(), "targetCancel") == 1) {
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {
						//	共通
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_SET") == 1) {
							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA1") == 1) {
								//	無拍
								if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE1") == 1) {
									//	パーセント
									$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1")/100);
								}
								else {
									//	固定額
									$cancel_money = $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY1");
								}
							}
						}
					}
					else {
						//	個別
						if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1") != "") {
							if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG1") == 1) {
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1")/100);
							}
							else {
								$cancel_money = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY1");
							}
						}
					}
				}
				elseif (parent::getByKey(parent::getKeyValue(), "targetCancel") == 2) {
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA2") == 1) {
							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE2") == 1) {
								//	パーセント
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2")/100);
							}
							else {
								$cancel_money =  $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY2");
							}
						}
					}
					else {
	
						if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2") != "") {
	
							if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG2") == 1) {
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2")/100);
							}
							else {
								$cancel_money = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY2");
							}
						}
					}
				}
				elseif (parent::getByKey(parent::getKeyValue(), "targetCancel") >= 3) {
	
					$i = parent::getByKey(parent::getKeyValue(), "targetCancel");
					if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_FLG_CANCEL") == 1) {
	
						if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DATA".$i) == 1) {
							if ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_DIVIDE".$i) == 1) {
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i)/100);
							}
							else {
								$cancel_money = $hotelBookset->getByKey($hotelBookset->getKeyValue(), "BOOKSET_CANCEL_PAY".$i);
							}
						}
	
					}
					else {
	
						if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) != "" and $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i) != "") {
							if ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_FLG".$i) == 1) {
								$cancel_money = parent::getByKey($k, "BOOKINGCONT_MONEY") * ($hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i)/100);
							}
							else {
								$cancel_money = $hotelBooking->getByKey($hotelBooking->getKeyValue(), "HOTELPLAN_CANCEL_MONEY".$i);
							}
						}
	
					}
				}
				
				if ($v ==1) {
					if (!$this->targetDataCancel($k, $cancel_money)) {
						$this->db->rollback();
						return false;
					}
				}elseif($v==2){
					if (!$this->targetDataNoshow($k, $cancel_money)) {
						$this->db->rollback();
						return false;
					}
				}
				
				// 				print "".$cancel_money."\n";
				// 				print "".$k."\n";
	
			}
		}
	
		$this->db->commit();
		return true;
	}
	
	public function targetDataCancel($id, $cancel_money) {

		$sql .= "update BOOKINGCONT set ";
		$sql .= parent::expsData("BOOKINGCONT_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKINGCONT_MONEY_CANCEL", "=", $cancel_money).", ";
		$sql .= parent::expsData("BOOKINGCONT_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData("BOOKINGCONT_ID", "=", $id)." ";

		if (!parent::saveExec($sql)) {
			return false;
		}

		return true;

	}
	public function targetDataNoshow($id, $cancel_money) {
	
		$sql .= "update BOOKINGCONT set ";
		$sql .= parent::expsData("BOOKINGCONT_STATUS", "=", 3).", ";
		$sql .= parent::expsData("BOOKINGCONT_MONEY_CANCEL", "=", $cancel_money).", ";
		$sql .= parent::expsData("BOOKINGCONT_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData("BOOKINGCONT_ID", "=", $id)." ";
// 	echo $sql;exit;
		if (!parent::saveExec($sql)) {
			return false;
		}
	
		return true;
	
	}
	public function cancelAll($id, $cancel_money) {

		$sql .= "update BOOKINGCONT set ";
		$sql .= parent::expsData("BOOKINGCONT_STATUS", "=", 2).", ";
		$sql .= parent::expsData("BOOKINGCONT_MONEY_CANCEL", "=", $cancel_money).", ";
		$sql .= parent::expsData("BOOKINGCONT_DATE_CANCEL", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData("BOOKING_ID", "=", $id)." ";

		if (!parent::saveExec($sql)) {
			return false;
		}

		return true;

	}


	public function check() {
		if (!$_POST) return;
	}

	public function checkCancel() {

		if (!$_POST) return;

//		if (count(parent::getByKey(parent::getKeyValue(), "canceldata")) <= 0) {
//			parent::setErrorFirst("キャンセルするデータを選択して下さい");
//		}

//		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "targetCancel"))) {
//			parent::setError("targetCancel", "必須項目です");
//		}

	}
	public function checkCancelConfirm() {
		if (!$_POST) return;
		if (time()>strtotime(parent::getByKey(parent::getKeyValue(), "BOOKINGCONT_DATE"))-24*60*60*parent::getByKey(parent::getKeyValue(), "HOTELPLAN_CAN_DAY")) {
			parent::setErrorFirst("予約キャンセルの締め切り日を超えました、キャンセルできませんでした");
		}
//		if (count(parent::getByKey(parent::getKeyValue(), "canceldata")) <= 0 && count(parent::getByKey(parent::getKeyValue(), "noshow")) <= 0) {
//			parent::setErrorFirst("キャンセルするデータを選択して下さい");
//		}
		/*
		else {
			$cancelAr = array();
			foreach (parent::getByKey(parent::getKeyValue(), "canceldata") as $k=>$v) {
				if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "cancelMoney".$k))) {
					parent::setError("cancelMoney".$k, "必須項目です");
				}
				elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "cancelMoney".$k), CHK_PTN_NUM)) {
					parent::setError("cancelMoney".$k, "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "cancelMoney".$k), 10)) {
					parent::setError("cancelMoney".$k, "10文字以内で入力して下さい");
				}
			}
		}
		*/

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
			$sql  = "update ".jobBookingcont::tableName." set ";
			$sql .= parent::expsData("HOTELPICGROUP_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= jobBookingcont::keyName." = ".$v." ";
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
				$this->setByKey($this->getKeyValue(), "hotelBookingcont_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBookingcont_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelBookingcont_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelBookingcont_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelBookingcont_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBookingcont_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelBookingcont_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelBookingcont_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelBookingcont_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelBookingcont_LIST_AREA"));
			}
			*/


		}

	}


}
?>