<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
class hotelPay extends collection {
	const tableName = "HOTELPAY";
	const keyName = "HOTELPAY_ID";
	const tableKeyName = "COMPANY_ID";

	public function hotelPay($db) {
		parent::collection($db);
	}

	public function selectSetCheck($companyId) {
		$sql  = "select ";
		$sql .= "HOTELPLAN_ID, count(HOTELPAY_ID) num, ROOM_ID, HOTELPAY_ID  ";
		$sql .= "from ".hotelPay::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("COMPANY_ID", "=", $companyId)." ";
		$sql .= "group by HOTELPLAN_ID, ROOM_ID ";

		parent::setCollection($sql, "HOTELPAY_ID");
	}

	public function selectRoomUsed($roomId, $date) {
		$sql  = "select ";
		$sql .= "HOTELPAY_ID, ROOM_ID, HOTELPAY_DATE, ";
		$sql .= "sum(HOTELPAY_ROOM_NUM) use_num ";
		$sql .= "from ".hotelPay::tableName." ";
		$sql .= "where ";
		$sql .= parent::expsData("ROOM_ID", "=", $roomId)." ";
		$sql .= "and ".parent::expsData("HOTELPAY_DATE", "=", $date, true)." ";
		$sql .= "group by ROOM_ID ";

		parent::setCollection($sql, "HOTELPAY_ID");
	}

	//	宿泊人数の考え方
	private function resStayNum($collection) {
		//	宿泊人数
		$checkNum = 0;
		if ($collection->getByKey($collection->getKeyValue(), "room_number") != "") {
			for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {

				//	大人数
				$checkNum = intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
				//	小学生(低学年)
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"));
				//	小学生(高学年)
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"));
				//	幼児:食事・布団あり
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3"));
				//	幼児:布団あり
				$checkNum += intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5"));

			}
		}
		return $checkNum;
	}
	
	
	public function selectListPublic($collection) {
		$sql  = "select ";
		$sql .= "HOTELPAY_ID,";
		$sql .= "COMPANY_ID,";
		$sql .= "HOTELPLAN_ID,";
		$sql .= "ROOM_ID,";
		$sql .= "HOTELPAY_DATE,";

		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPAY_MONEY".$i.", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTELPAY_PS_DATA".$i.", ";
			$sql .= "HOTELPAY_PS_DATA".$i."2, ";
		}
		for ($i=1; $i<=14; $i++) {
			$sql .= "HOTELPAY_BB_DATA".$i.", ";
		}
/*
		for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {

			//	宿泊人数
			$checkNum = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);

			//	適用人数
			$money_num .= "( ";
			//	大人
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))." + ";
			//	小学生低 数える
			$money_num .= "case ";
			$money_num .= "when ";
			$money_num .= "hpay.HOTELPAY_PS_DATA2 = 1 ";
			$money_num .= "then ";
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"))." ";
			$money_num .= "else  ";
			$money_num .= "0  ";
			$money_num .= "end + ";
			//	小学生高 数える
			$money_num .= "case ";
			$money_num .= "when ";
			$money_num .= "hpay.HOTELPAY_PS_DATA22 = 1 ";
			$money_num .= "then ";
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"))." ";
			$money_num .= "else  ";
			$money_num .= "0  ";
			$money_num .= "end + ";
			//	幼児 食事・布団 数える
			$money_num .= "case ";
			$money_num .= "when ";
			$money_num .= "hpay.HOTELPAY_BB_DATA2 = 1 ";
			$money_num .= "then ";
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3"))." ";
			$money_num .= "else  ";
			$money_num .= "0  ";
			$money_num .= "end + ";
			//	幼児 布団 数える
			$money_num .= "case ";
			$money_num .= "when ";
			$money_num .= "hpay.HOTELPAY_BB_DATA9 = 1 ";
			$money_num .= "then ";
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5"))." ";
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
			$money_1 .= "hpay.HOTELPAY_MONEY1 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 2 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY2 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 3 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY3 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 4 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY4 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 5 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY5 ";
			$money_1 .= "else ";
			$money_1 .= "hpay.HOTELPAY_MONEY6 ";
			$money_1 .= "end ";
			$money_1 .= ") ";

			//	人部屋目の大人一人分の金額
			$sql .= "(".$money_1.") as money_".$roomNum.", ";

			//	大人数
			$alultnum = intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
			if ($alultnum > 0) {
				$adultmoney = "(".$money_1." * ".$alultnum.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $adultmoney;
				//	大人料金
				$sql .= "(".$adultmoney.") as money_adult_".$roomNum.", ";
			}

			//	小学生(低学年)
			$childnum1 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"));
			if ($childnum1 > 0) {
				$childmoney1 = "";

// 				$childmoney1 .= "((case when hpay.HOTELPAY_PS_DATA2=1 then ";
				$childmoney1 .= "(";
				$childmoney1 .= "(case when hpay.HOTELPAY_PS_DATA4=1 then ".$money_1." * (HOTELPAY_PS_DATA3/100) ";
				$childmoney1 .= "when hpay.HOTELPAY_PS_DATA4=2 then HOTELPAY_PS_DATA3 ";
				$childmoney1 .= "when hpay.HOTELPAY_PS_DATA4=3 then ".$money_1." - HOTELPAY_PS_DATA3 end )";
				$childmoney1 .= " * ".$childnum1.") ";
// 				$childmoney1 .= "else 0 end ) * ".$childnum1.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney1;
				//
				$sql .= "(".$childmoney1.") as money_child_".$roomNum."_1, ";
				$sql .= "(".$childmoney1." * ".$childnum1.") as money_child_".$roomNum."_1_all, ";
			}

			//	小学生(高学年)
			$childnum2 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"));
			if ($childnum2 > 0) {
				$childmoney2 = "";

// 				$childmoney2 .= "((case when hpay.HOTELPAY_PS_DATA22=1 then ";
				$childmoney2 .= "(case when hpay.HOTELPAY_PS_DATA22=1 then ";
				$childmoney2 .= "(case when hpay.HOTELPAY_PS_DATA42=1 then ".$money_1." * (HOTELPAY_PS_DATA32/100) ";
				$childmoney2 .= "when hpay.HOTELPAY_PS_DATA42=2 then HOTELPAY_PS_DATA32 ";
				$childmoney2 .= "when hpay.HOTELPAY_PS_DATA42=3 then ".$money_1." - HOTELPAY_PS_DATA32 end ) ";
				$childmoney2 .= " * ".$childnum2.") ";
// 				$childmoney2 .= "else 0 end ) * ".$childnum2.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney2;
				//
				$sql .= "(".$childmoney2.") as money_child_".$roomNum."_2, ";
				$sql .= "(".$childmoney2." * ".$childnum2.") as money_child_".$roomNum."_2_all, ";
			}
			//	幼児 食事布団あり
			$childnum3 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3"));
			if ($childnum3 > 0) {
				$childmoney3 = "";

// 				$childmoney3 .= "((case when hpay.HOTELPAY_BB_DATA2=1 then ";
				$childmoney3 .= "(";
				$childmoney3 .= "(case when hpay.HOTELPAY_BB_DATA4=1 then ".$money_1." * (HOTELPAY_BB_DATA3/100) ";
				$childmoney3 .= "when hpay.HOTELPAY_BB_DATA4=2 then HOTELPAY_BB_DATA3 ";
				$childmoney3 .= "when hpay.HOTELPAY_BB_DATA4=3 then ".$money_1." - HOTELPAY_BB_DATA3 end ) ";
				$childmoney3 .= " * ".$childnum3.") ";
// 				$childmoney3 .= "else 0 end ) * ".$childnum3.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney3;
				//
				$sql .= "(".$childmoney3.") as money_child_".$roomNum."_3, ";
				$sql .= "(".$childmoney3." * ".$childnum3.") as money_child_".$roomNum."_3_all, ";
			}
			//	幼児 食事あり
			$childnum4 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4"));
			if ($childnum4 > 0) {
				$childmoney4 = "";

				$childmoney4 .= "(";
				$childmoney4 .= "(case when hpay.HOTELPAY_BB_DATA11=1 then ".$money_1." * (HOTELPAY_BB_DATA10/100) ";
				$childmoney4 .= "when hpay.HOTELPAY_BB_DATA11=2 then HOTELPAY_BB_DATA10 ";
				$childmoney4 .= "when hpay.HOTELPAY_BB_DATA11=3 then ".$money_1." - HOTELPAY_BB_DATA10 end ) ";
				$childmoney4 .= " * ".$childnum4.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney4;
				//
				$sql .= "(".$childmoney4.") as money_child_".$roomNum."_4, ";
				$sql .= "(".$childmoney4." * ".$childnum4.") as money_child_".$roomNum."_4_all, ";
			}
			//	幼児 布団あり
			$childnum5 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5"));
			if ($childnum5 > 0) {
				$childmoney5 = "";

// 				$childmoney5 .= "((case when hpay.HOTELPAY_BB_DATA9=1 then ";
				$childmoney5 .= "(";
				$childmoney5 .= "(case when hpay.HOTELPAY_BB_DATA11=1 then ".$money_1." * (HOTELPAY_BB_DATA10/100) ";
				$childmoney5 .= "when hpay.HOTELPAY_BB_DATA11=2 then HOTELPAY_BB_DATA10 ";
				$childmoney5 .= "when hpay.HOTELPAY_BB_DATA11=3 then ".$money_1." - HOTELPAY_BB_DATA10 end ) ";
				$childmoney5 .= " * ".$childnum5.") ";
// 				$childmoney5 .= "else 0 end ) * ".$childnum5.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney5;
				//
				$sql .= "(".$childmoney5.") as money_child_".$roomNum."_5, ";
				$sql .= "(".$childmoney5." * ".$childnum5.") as money_child_".$roomNum."_5_all, ";
			}
			//	幼児 なし
			$childnum6 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6"));
			if ($childnum6 > 0) {
				$childmoney6 = "";

				$childmoney6 .= "(";
				$childmoney6 .= "(case when hpay.HOTELPAY_BB_DATA11=1 then ".$money_1." * (HOTELPAY_BB_DATA10/100) ";
				$childmoney6 .= "when hpay.HOTELPAY_BB_DATA11=2 then HOTELPAY_BB_DATA10 ";
				$childmoney6 .= "when hpay.HOTELPAY_BB_DATA11=3 then ".$money_1." - HOTELPAY_BB_DATA10 end ) ";
				$childmoney6 .= " * ".$childnum6.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childnum6;
				//
				$sql .= "(".$childmoney6.") as money_child_".$roomNum."_6, ";
				$sql .= "(".$childmoney6." * ".$childnum6.") as money_child_".$roomNum."_6_all, ";
			}

		}

		if ($money_all != "") {
			//$sql .= "(".$money_all.") as money_all, ";
		}
		*/

		$sql .= "HOTELPAY_SERVICE_FLG, HOTELPAY_SERVICE, HOTELPAY_MONEY_FLG, HOTELPAY_FLG_STOP, HOTELPAY_ROOM_NUM, HOTELPAY_ROOM_OVER, ";
		$sql .= parent::decryptionList("HOTELPAY_REMARKS")." ";
		$sql .= "from ".hotelPay::tableName." hpay ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "next_flg") == "") {
			if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID") != "") {
				if ($where != "") {
					$where .= "and ";
				}
				$where .= parent::expsData("".hotelPay::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID"))." ";
			}
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ROOM_ID", "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
		}
		
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ACC_DAY") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= " HOTELPAY_DATE >= DATE_ADD(NOW(), INTERVAL ".$collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ACC_DAY" )." DAY) ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPAY_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE"), true)." ";
			$where .= "and ".parent::expsData("HOTELPAY_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))), true)." ";
		}


		if ($where != "") {
			$sql .= "where ".$where." ";
		}




		//==============================================================
		/*
		$linksql  = "select ";
		$linksql .= "'' as HOTELPAY_ID,";
		$linksql .= "TL_HOTEL_ID as COMPANY_ID,";
		$linksql .= "TL_PLAN_CODE as HOTELPLAN_ID,";
		$linksql .= "TL_ROOM_TYPECODE as ROOM_ID,";
		$linksql .= "TL_PAYMENT_DATE as HOTELPAY_DATE,";

		for ($i=1; $i<=6; $i++) {
			$linksql .= "TL_PAYMENT_PAY".$i." as HOTELPAY_MONEY".$i.", ";
		}

		for ($i=1; $i<=6; $i++) {
			$linksql .= "TL_PLAN_C_FLG_ACCEPT".$i.", ";
			$linksql .= "TL_PLAN_C_FLG_NUM".$i.", ";
			$linksql .= "TL_PLAN_C_MONEY".$i.", ";
			$linksql .= "TL_PLAN_C_FLG_MONEY".$i.", ";
		}

		$money_num = "";
		for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {

			//	宿泊人数
			$checkNum = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);

			//	適用人数
			$money_num .= "( ";
			//	大人
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum))." + ";
			//	小学生低 数える
			$money_num .= "case ";
			$money_num .= "when ";
			$money_num .= "linkhp.TL_PLAN_C_FLG_NUM2 = 1 ";
			$money_num .= "then ";
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"))." ";
			$money_num .= "else  ";
			$money_num .= "0  ";
			$money_num .= "end + ";
			//	小学生高 数える
			$money_num .= "case ";
			$money_num .= "when ";
			$money_num .= "linkhp.TL_PLAN_C_FLG_NUM1 = 1 ";
			$money_num .= "then ";
			$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"))." ";
			$money_num .= "else  ";
			$money_num .= "0  ";
			$money_num .= "end  ";
			for ($i=3; $i<=6; $i++) {
				$money_num .= "+ case ";
				$money_num .= "when ";
				$money_num .= "linkhp.TL_PLAN_C_FLG_NUM".$i." = 1 ";
				$money_num .= "then ";
				$money_num .= intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."".$i))." ";
				$money_num .= "else  ";
				$money_num .= "0  ";
				$money_num .= "end ";
			}

			//	人数から最小金額
			$money_1  = "( ";
			$money_1 .= "case ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 1 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY1 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 2 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY2 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 3 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY3 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 4 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY4 ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 5 ";
			$money_1 .= "then ";
			$money_1 .= "hpay.HOTELPAY_MONEY5 ";

			$money_1 .= "when ";
			$money_1 .= $money_num." = 6 ";
			$money_1 .= "then ";
			$money_1 .= "min(linkhpay.TL_PAYMENT_PAY6) ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 7 ";
			$money_1 .= "then ";
			$money_1 .= "min(linkhpay.TL_PAYMENT_PAY7) ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 8 ";
			$money_1 .= "then ";
			$money_1 .= "min(linkhpay.TL_PAYMENT_PAY8) ";
			$money_1 .= "when ";
			$money_1 .= $money_num." = 9 ";
			$money_1 .= "then ";
			$money_1 .= "min(linkhpay.TL_PAYMENT_PAY9) ";
			$money_1 .= "else ";
			$money_1 .= "min(linkhpay.TL_PAYMENT_PAY10) ";
			$money_1 .= "end ";
			$money_1 .= ") ";

			//	人部屋目の大人一人分の金額
			$linksql .= "(".$money_1.") as money_".$roomNum.", ";

			//	大人数
			$alultnum = intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
			if ($alultnum > 0) {
				$adultmoney = "(".$money_1." * ".$alultnum.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $adultmoney;
				//	大人料金
				$linksql .= "(".$adultmoney.") as money_adult_".$roomNum.", ";
			}

			//	小学生(低学年)
			$childnum1 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"));
			if ($childnum1 > 0) {
				$childmoney1 = "";
				$childmoney1 .= "(";
				$childmoney1 .= "(case when linkhp.TL_PLAN_C_FLG_MONEY2=1 then ".$money_1." * (TL_PLAN_C_MONEY2/100) ";
				$childmoney1 .= "when linkhp.TL_PLAN_C_FLG_MONEY2=2 then TL_PLAN_C_MONEY2 ";
				$childmoney1 .= "when linkhp.TL_PLAN_C_FLG_MONEY2=3 then ".$money_1." - TL_PLAN_C_MONEY2 end )";
				$childmoney1 .= " * ".$childnum1.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney1;
				//
				$linksql .= "(".$childmoney1.") as money_child_".$roomNum."_1, ";
				$linksql .= "(".$childmoney1." * ".$childnum1.") as money_child_".$roomNum."_1_all, ";
			}

			//	小学生(高学年)
			$childnum2 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"));
			if ($childnum2 > 0) {
				$childmoney2 = "";

				// 				$childmoney2 .= "((case when hpay.HOTELPAY_PS_DATA22=1 then ";
				$childmoney2 .= "(case when linkhp.TL_PLAN_C_FLG_NUM1=1 then ";
				$childmoney2 .= "(case when linkhp.TL_PLAN_C_FLG_MONEY1=1 then ".$money_1." * (TL_PLAN_C_MONEY1/100) ";
				$childmoney2 .= "when linkhp.TL_PLAN_C_FLG_MONEY1=2 then TL_PLAN_C_MONEY1 ";
				$childmoney2 .= "when linkhp.TL_PLAN_C_FLG_MONEY1=3 then ".$money_1." - TL_PLAN_C_MONEY1 end ) ";
				$childmoney2 .= " * ".$childnum2.") ";
				// 				$childmoney2 .= "else 0 end ) * ".$childnum2.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney2;
				//
				$linksql .= "(".$childmoney2.") as money_child_".$roomNum."_2, ";
				$linksql .= "(".$childmoney2." * ".$childnum2.") as money_child_".$roomNum."_2_all, ";
			}
			for ($i=3; $i<=6; $i++) {

				$childnum3 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."".$i));
				if ($childnum3 > 0) {
					$childmoney3 = "";

					// 				$childmoney3 .= "((case when hpay.HOTELPAY_BB_DATA2=1 then ";
					$childmoney3 .= "(";
					$childmoney3 .= "(case when linkhp.TL_PLAN_C_FLG_MONEY".$i."=1 then ".$money_1." * (TL_PLAN_C_MONEY".$i."/100) ";
					$childmoney3 .= "when linkhp.TL_PLAN_C_FLG_MONEY".$i."=2 then TL_PLAN_C_MONEY".$i." ";
					$childmoney3 .= "when linkhp.TL_PLAN_C_FLG_MONEY".$i."=3 then ".$money_1." - TL_PLAN_C_MONEY".$i." end ) ";
					$childmoney3 .= " * ".$childnum3.") ";
					// 				$childmoney3 .= "else 0 end ) * ".$childnum3.") ";
					//	合計料金計算
					if ($money_all != "") $money_all .= " + ";
					$money_all .= $childmoney3;
					//
					$linksql .= "(".$childmoney3.") as money_child_".$roomNum."_".$i.", ";
					$linksql .= "(".$childmoney3." * ".$childnum3.") as money_child_".$roomNum."_".$i."_all, ";
				}
			}

		}

		if ($money_all != "") {
			$linksql .= "(".$money_all.") as money_all, ";
		}

		$linksql .= "1 as HOTELPAY_SERVICE_FLG, ";
		$linksql .= "'' as HOTELPAY_SERVICE, ";
		$linksql .= "1 as HOTELPAY_MONEY_FLG, ";
		$linksql .= "case ";
		$linksql .= "when TL_PAYMENT_STATUS = 0 then 2 else 1 end as HOTELPAY_FLG_STOP, ";
		$linksql .= "1 as HOTELPAY_ROOM_NUM, ";
		$linksql .= "0 as HOTELPAY_ROOM_OVER, ";
		$linksql .= "'' as HOTELPAY_REMARKS ";

		$linksql .= "from TL_PAYMENT linkhpay ";
		$linksql .= "inner join TL_PLAN linkhp on linkhpay.TL_HOTEL_ID = linkhp.TL_HOTEL_ID ";
		$linksql .= "and linkhpay.TL_PLAN_CODE = linkhp.TL_PLAN_CODE ";
		$linksql .= "and linkhpay.TL_ROOM_TYPECODE = linkhp.TL_ROOM_TYPECODE ";
		$linksql .= "inner join COMPANY linkc on linkhpay.TL_HOTEL_ID = linkc.COMPANY_LINK ";

		$linkwhere = "";

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("linkc.COMPANY_ID", "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("linkhpay.TL_PLAN_CODE", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("linkhpay.", "=", $collection->getByKey($collection->getKeyValue(), "TL_ROOM_TYPECODE"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPAY_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE"), true)." ";
			$where .= "and ".parent::expsData("HOTELPAY_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))), true)." ";
		}


		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		*/
		//======================================================================

		$sql .= "order by HOTELPAY_DATE  ";
		//print_r($sql);exit;

		parent::setCollection($sql, hotelPay::keyName);
	}


	//	次の日以降の検索
	public function selectListPublicNext($collection) {
		$sql  = "select ";
		$sql .= "HOTELPAY_ID, COMPANY_ID,  HOTELPLAN_ID, ROOM_ID, HOTELPAY_DATE, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPAY_MONEY".$i.", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTELPAY_PS_DATA".$i.", ";
			$sql .= "HOTELPAY_PS_DATA".$i."2, ";
		}
		for ($i=1; $i<=14; $i++) {
			$sql .= "HOTELPAY_BB_DATA".$i.", ";
		}


		for ($roomNum=1; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {

			//	宿泊人数
			$checkNum = $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum);
			// 			$checkNum = $this->resStayNum($collection);

			//最低料金	人数設定1：部屋貸し2 と人数で切り替え
			if ($checkNum > 0 and $checkNum <= 6) {
				$money_1 = "hpay.HOTELPAY_MONEY".$checkNum."";
			}
			elseif ($checkNum > 0 and $checkNum >= 6) {
				$money_1 = "hpay.HOTELPAY_MONEY6";
			}
			else {
				$money_1 = "hpay.HOTELPAY_MONEY1";
			}
			//	人部屋目の大人一人分の金額
			$sql .= $money_1." as money_".$roomNum.", ";

			//	大人数
			$alultnum = intval($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum));
			if ($alultnum > 0) {
				$adultmoney = "(".$money_1." * ".$alultnum.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $adultmoney;
				//	大人料金
				$sql .= "(".$adultmoney.") as money_adult_".$roomNum.", ";
			}

			//	小学生(低学年)
			$childnum1 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1"));
			if ($childnum1 > 0) {
				$childmoney1 = "";

				// 				$childmoney1 .= "((case when hpay.HOTELPAY_PS_DATA2=1 then ";
				$childmoney1 .= "(";
				$childmoney1 .= "(case when hpay.HOTELPAY_PS_DATA4=1 then ".$money_1." * (HOTELPAY_PS_DATA3/100) ";
				$childmoney1 .= "when hpay.HOTELPAY_PS_DATA4=2 then HOTELPAY_PS_DATA3 ";
				$childmoney1 .= "when hpay.HOTELPAY_PS_DATA4=3 then ".$money_1." - HOTELPAY_PS_DATA3 end )";
				$childmoney1 .= " * ".$childnum1.") ";
				// 				$childmoney1 .= "else 0 end ) * ".$childnum1.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney1;
				//
				$sql .= "(".$childmoney1.") as money_child_".$roomNum."_1, ";
				$sql .= "(".$childmoney1." * ".$childnum1.") as money_child_".$roomNum."_1_all, ";
			}

			//	小学生(高学年)
			$childnum2 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2"));
			if ($childnum2 > 0) {
				$childmoney2 = "";

				// 				$childmoney2 .= "((case when hpay.HOTELPAY_PS_DATA22=1 then ";
				$childmoney2 .= "(case when hpay.HOTELPAY_PS_DATA22=1 then ";
				$childmoney2 .= "(case when hpay.HOTELPAY_PS_DATA42=1 then ".$money_1." * (HOTELPAY_PS_DATA32/100) ";
				$childmoney2 .= "when hpay.HOTELPAY_PS_DATA42=2 then HOTELPAY_PS_DATA32 ";
				$childmoney2 .= "when hpay.HOTELPAY_PS_DATA42=3 then ".$money_1." - HOTELPAY_PS_DATA32 end ) ";
				$childmoney2 .= " * ".$childnum2.") ";
				// 				$childmoney2 .= "else 0 end ) * ".$childnum2.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney2;
				//
				$sql .= "(".$childmoney2.") as money_child_".$roomNum."_2, ";
				$sql .= "(".$childmoney2." * ".$childnum2.") as money_child_".$roomNum."_2_all, ";
			}
			//	幼児 食事布団あり
			$childnum3 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3"));
			if ($childnum3 > 0) {
				$childmoney3 = "";

				// 				$childmoney3 .= "((case when hpay.HOTELPAY_BB_DATA2=1 then ";
				$childmoney3 .= "(";
				$childmoney3 .= "(case when hpay.HOTELPAY_BB_DATA4=1 then ".$money_1." * (HOTELPAY_BB_DATA3/100) ";
				$childmoney3 .= "when hpay.HOTELPAY_BB_DATA4=2 then HOTELPAY_BB_DATA3 ";
				$childmoney3 .= "when hpay.HOTELPAY_BB_DATA4=3 then ".$money_1." - HOTELPAY_BB_DATA3 end ) ";
				$childmoney3 .= " * ".$childnum3.") ";
				// 				$childmoney3 .= "else 0 end ) * ".$childnum3.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney3;
				//
				$sql .= "(".$childmoney3.") as money_child_".$roomNum."_3, ";
				$sql .= "(".$childmoney3." * ".$childnum3.") as money_child_".$roomNum."_3_all, ";
			}
			//	幼児 食事あり
			$childnum4 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4"));
			if ($childnum4 > 0) {
				$childmoney4 = "";

				$childmoney4 .= "(";
				$childmoney4 .= "(case when hpay.HOTELPAY_BB_DATA7=1 then ".$money_1." * (HOTELPAY_BB_DATA6/100) ";
				$childmoney4 .= "when hpay.HOTELPAY_BB_DATA7=2 then HOTELPAY_BB_DATA6 ";
				$childmoney4 .= "when hpay.HOTELPAY_BB_DATA7=3 then ".$money_1." - HOTELPAY_BB_DATA6 end ) ";
				$childmoney4 .= " * ".$childnum4.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney4;
				//
				$sql .= "(".$childmoney4.") as money_child_".$roomNum."_4, ";
				$sql .= "(".$childmoney4." * ".$childnum4.") as money_child_".$roomNum."_4_all, ";
			}
			//	幼児 布団あり
			$childnum5 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5"));
			if ($childnum5 > 0) {
				$childmoney5 = "";

				// 				$childmoney5 .= "((case when hpay.HOTELPAY_BB_DATA9=1 then ";
				$childmoney5 .= "(";
				$childmoney5 .= "(case when hpay.HOTELPAY_BB_DATA11=1 then ".$money_1." * (HOTELPAY_BB_DATA10/100) ";
				$childmoney5 .= "when hpay.HOTELPAY_BB_DATA11=2 then HOTELPAY_BB_DATA10 ";
				$childmoney5 .= "when hpay.HOTELPAY_BB_DATA11=3 then ".$money_1." - HOTELPAY_BB_DATA10 end ) ";
				$childmoney5 .= " * ".$childnum5.") ";
				// 				$childmoney5 .= "else 0 end ) * ".$childnum5.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childmoney5;
				//
				$sql .= "(".$childmoney5.") as money_child_".$roomNum."_5, ";
				$sql .= "(".$childmoney5." * ".$childnum5.") as money_child_".$roomNum."_5_all, ";
			}
			//	幼児 なし
			$childnum6 = intval($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6"));
			if ($childnum6 > 0) {
				$childmoney6 = "";

				$childmoney6 .= "(";
				$childmoney6 .= "(case when hpay.HOTELPAY_BB_DATA11=1 then ".$money_1." * (HOTELPAY_BB_DATA10/100) ";
				$childmoney6 .= "when hpay.HOTELPAY_BB_DATA11=2 then HOTELPAY_BB_DATA10 ";
				$childmoney6 .= "when hpay.HOTELPAY_BB_DATA11=3 then ".$money_1." - HOTELPAY_BB_DATA10 end ) ";
				$childmoney6 .= " * ".$childnum6.") ";
				//	合計料金計算
				if ($money_all != "") $money_all .= " + ";
				$money_all .= $childnum6;
				//
				$sql .= "(".$childmoney6.") as money_child_".$roomNum."_6, ";
				$sql .= "(".$childmoney6." * ".$childnum6.") as money_child_".$roomNum."_6_all, ";
			}

		}

		if ($money_all != "") {
			$sql .= "(".$money_all.") as money_all, ";
		}

		$sql .= "HOTELPAY_SERVICE_FLG, HOTELPAY_SERVICE, HOTELPAY_MONEY_FLG, HOTELPAY_FLG_STOP, HOTELPAY_ROOM_NUM, HOTELPAY_ROOM_OVER, ";
		$sql .= parent::decryptionList("HOTELPAY_REMARKS")." ";
		$sql .= "from ".hotelPay::tableName." hpay ";
// 		$sql .= "inner join HOTELPAY hpay2 on hpay";

		$where = "";

		/*
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID"))." ";
		}
		*/

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "ROOM_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ROOM_ID", "=", $collection->getByKey($collection->getKeyValue(), "ROOM_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE") != "") {
			$night = "";
			for ($nightNum=2; $nightNum<=$collection->getByKey($collection->getKeyValue(), "night_number"); $nightNum++) {
				if ($night != "") {
					$night .= "or ";
				}
				$night .= "".parent::expsData("HOTELPAY_DATE", "=", date("Y-m-d",strtotime(($nightNum-1)." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))), true)." ";
			}
			if ($night != "") {
				$where .= "and (".$night.") ";
			}
		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPAY_DATE  ";

		parent::setCollection($sql, hotelPay::keyName);
	}




	public function selectList($collection) {
		$sql  = "select ";
		$sql .= "HOTELPAY_ID, COMPANY_ID,  HOTELPLAN_ID, ROOM_ID, HOTELPAY_DATE, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPAY_MONEY".$i.", ";
// 			$sql .= parent::decryptionList("HOTELPAY_MONEY".$i).", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTELPAY_PS_DATA".$i.", ";
			$sql .= "HOTELPAY_PS_DATA".$i."2, ";
		}
		for ($i=1; $i<=14; $i++) {
			$sql .= "HOTELPAY_BB_DATA".$i.", ";
		}
		$sql .= "HOTELPAY_SERVICE_FLG, HOTELPAY_SERVICE, HOTELPAY_MONEY_FLG, HOTELPAY_FLG_STOP, HOTELPAY_ROOM_NUM, HOTELPAY_ROOM_OVER, ";
		$sql .= parent::decryptionList("HOTELPAY_REMARKS")." ";
		$sql .= "from ".hotelPay::tableName." ";

		$where = "";

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::keyName, "=", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "COMPANY_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::tableKeyName, "=", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"))." ";
		}

		if ($collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID") != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_ID", "=", $collection->getByKey($collection->getKeyValue(), "HOTELPLAN_ID"))." ";
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
			$where .= parent::expsData("HOTELPAY_DATE", ">=", $collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE"), true)." ";
			$where .= "and ".parent::expsData("HOTELPAY_DATE", "<=", date("Y-m-d",strtotime($collection->getByKey($collection->getKeyValue(), "search_term")." day" ,strtotime($collection->getByKey($collection->getKeyValue(), "HOTELPAY_DATE")))), true)." ";
		}


		/*
		$status = "";
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS1") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS1");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS2") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS2");
		}
		if ($collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS3") != "") {
			if ($status != "") {
				$status .= ", ";
			}
			$status .= $collection->getByKey($collection->getKeyValue(), "HOTELPICGROUP_STATUS3");
		}

		if ($status != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_STATUS", "in", "(".$status.")")." ";
		}
		else {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPICGROUP_STATUS", "in", "(2)")." ";
		}
		*/

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPAY_DATE  ";

		parent::setCollection($sql, hotelPay::keyName);
	}

	public function select($id="", $companyId="", $planId="", $roomId="" ) {
		$sql  = "select ";
		$sql .= "HOTELPAY_ID, COMPANY_ID,  HOTELPLAN_ID, ROOM_ID, HOTELPAY_DATE, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPAY_MONEY".$i.", ";
// 			$sql .= parent::decryptionList("HOTELPAY_MONEY".$i).", ";
		}
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTELPAY_PS_DATA".$i.", ";
			$sql .= "HOTELPAY_PS_DATA".$i."2, ";
		}
		for ($i=1; $i<=14; $i++) {
			$sql .= "HOTELPAY_BB_DATA".$i.", ";
		}
		$sql .= "HOTELPAY_FLG_STOP, HOTELPAY_ROOM_NUM, HOTELPAY_ROOM_OVER, ";
		$sql .= parent::decryptionList("HOTELPAY_REMARKS")." ";
		$sql .= "from ".hotelPay::tableName." ";

		$where = "";

		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::keyName, "=", $id)." ";
		}

		if ($companyId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::tableKeyName, "=", $companyId)." ";
		}

		if ($planId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("HOTELPLAN_ID", "=", $planId)." ";
		}

		if ($roomId != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("ROOM_ID", "=", $roomId)." ";
		}

// 		if ($statusComma != "") {
// 			if ($where != "") {
// 				$where .= "and ";
// 			}
// 			$where .= parent::expsData("HOTELPICGROUP_STATUS", "in", "(".$statusComma.")")." ";
// 		}

		if ($where != "") {
			$sql .= "where ".$where." ";
		}

		$sql .= "order by HOTELPAY_DATE  ";

		parent::setCollection($sql, hotelPay::keyName);
	}
	
	public function selectHotelService($id){
		$sql  = "select ";
		$sql .= "HOTELPAY_SERVICE ";
		$sql .= "from ".hotelPay::tableName." ";
		
		$where = "";
		
		if ($id != "") {
			if ($where != "") {
				$where .= "and ";
			}
			$where .= parent::expsData("".hotelPay::keyName, "=", $id)." ";
		}
		
		if ($where != "") {
			$sql .= "where ".$where." ";
		}
		
		parent::setCollection($sql, hotelPay::keyName);
	}
	
	public function saveOnly() {
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

	public function save($hotelPlanTarget) {
		$this->db->begin();
// 		$dataList = parent::getCollectionByKey(parent::getKeyValue());
		$sql = "";

		$from = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_FROM"));
		$to = cmDateDivide($hotelPlanTarget->getByKey($hotelPlanTarget->getKeyValue(), "HOTELPLAN_DATE_SALE_TO"));
		
		$cut = intval($to['y'])-intval($from['y']);
		
		for ($y=$from["y"]; $y<=$to["y"]; $y++) {
			if($from['m']>$to['m']){
				$ori_to_m = $to['m'];
				$ori_to_d = $to['d'];
				$to['m'] = 12;
				$to['d'] = 31;
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
							$dataList["HOTELPAY_PS_DATA".$i."2"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA".$i."2");
						}
						for ($i=1; $i<=14; $i++) {
							$dataList["HOTELPAY_BB_DATA".$i] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA".$i);
						}
						$dataList["HOTELPAY_SERVICE_FLG"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG");
						$dataList["HOTELPAY_MONEY_FLG"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_MONEY_FLG");
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
				$from['m']=1;
				$from['d']=1;
				$cut?$cut--:'';
				if ($cut==0) {
					$to['m']=$ori_to_m;
					$to['d']=$ori_to_d;
				}
			}else{
				if($cut>0){
					$ori_to_m = $ori_to_m?$ori_to_m:$to['m'];
					$ori_to_d = $ori_to_m?$ori_to_m:$to['d'];
					$to['m'] = 12;
					$to['d'] = 31;
				}
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
							$dataList["HOTELPAY_PS_DATA".$i."2"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA".$i."2");
						}
						for ($i=1; $i<=14; $i++) {
							$dataList["HOTELPAY_BB_DATA".$i] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_BB_DATA".$i);
						}
						$dataList["HOTELPAY_SERVICE_FLG"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_SERVICE_FLG");
						$dataList["HOTELPAY_MONEY_FLG"] = parent::getByKey(parent::getKeyValue(), "HOTELPAY_MONEY_FLG");
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
				if($cut>0){
					$from['m']=1;
					$from['d']=1;
					$cut?$cut--:'';
					if ($cut==0) {
						$to['m']=$ori_to_m;
						$to['d']=$ori_to_d;
					}
				}
				
			}
		}

		/*
		foreach (parent::getCollection() as $d) {
			$dataList = array();
			$dataList["HOTELPAY_ID"] = $d["HOTELPAY_ID"];
			$dataList["COMPANY_ID"] = parent::getByKey(parent::getKeyValue(), "COMPANY_ID");
			$dataList["HOTELPLAN_ID"] = $d["HOTELPLAN_ID"];
			$dataList["ROOM_ID"] = $d["ROOM_ID"];
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
				$dataList["HOTELPAY_MONEY".$i] = $d["HOTELPAY_MONEY".$i];
			}
			$dataList["HOTELPAY_FLG_STOP"] = $d["HOTELPAY_FLG_STOP"];
			$dataList["HOTELPAY_DATE"] = $d["HOTELPAY_DATE"];
			$dataList["HOTELPAY_ROOM_NUM"] = $d["HOTELPAY_ROOM_NUM"];
			$dataList["HOTELPAY_ROOM_OVER"] = $d["HOTELPAY_ROOM_OVER"];

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
		*/

		$this->db->commit();
		return true;
	}

	public function insert($dataList) {
		$sql  = "insert into ".hotelPay::tableName." (";
		$sql .= "HOTELPAY_ID, ";
		$sql .= "COMPANY_ID, ";
		$sql .= "HOTELPLAN_ID, ";
		$sql .= "ROOM_ID, ";
		$sql .= "HOTELPAY_DATE, ";
		for ($i=1; $i<=4; $i++) {
			$sql .= "HOTELPAY_PS_DATA".$i.", ";
			$sql .= "HOTELPAY_PS_DATA".$i."2, ";
		}
		for ($i=1; $i<=14; $i++) {
			$sql .= "HOTELPAY_BB_DATA".$i.", ";
		}
		$sql .= "HOTELPAY_SERVICE_FLG, ";
		$sql .= "HOTELPAY_SERVICE, ";
		$sql .= "HOTELPAY_MONEY_FLG, ";
		$sql .= "HOTELPAY_REMARKS, ";
		for ($i=1; $i<=6; $i++) {
			$sql .= "HOTELPAY_MONEY".$i.", ";
		}
		$sql .= "HOTELPAY_FLG_STOP, ";
		$sql .= "HOTELPAY_ROOM_NUM, ";
		$sql .= "HOTELPAY_ROOM_OVER, ";
		$sql .= "HOTELPAY_DATE_REGIST, ";
		$sql .= "HOTELPAY_DATE_UPDATE) values (";

		$sql .= "null, ";
		$sql .= parent::expsVal($dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPLAN_ID"]).", ";
		$sql .= parent::expsVal($dataList["ROOM_ID"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_DATE"], true).", ";
		for ($i=1; $i<=4; $i++) {
			$sql .= parent::expsVal($dataList["HOTELPAY_PS_DATA".$i]).", ";
			$sql .= parent::expsVal($dataList["HOTELPAY_PS_DATA".$i."2"]).", ";
		}
		for ($i=1; $i<=14; $i++) {
			$sql .= parent::expsVal($dataList["HOTELPAY_BB_DATA".$i]).", ";
		}
		$sql .= parent::expsVal($dataList["HOTELPAY_SERVICE_FLG"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_SERVICE"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_MONEY_FLG"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_REMARKS"], true, 1).", ";
		for ($i=1; $i<=6; $i++) {
			$sql .= parent::expsVal($dataList["HOTELPAY_MONEY".$i], true).", ";
		}
		$sql .= parent::expsVal($dataList["HOTELPAY_FLG_STOP"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_ROOM_NUM"]).", ";
		$sql .= parent::expsVal($dataList["HOTELPAY_ROOM_OVER"]).", ";
		$sql .= "now(), ";
		$sql .= "now()) ";

		return $sql;
	}

	public function update($dataList) {
		$sql .= "update ".hotelPay::tableName." set ";
		$sql .= parent::expsData("COMPANY_ID", "=", $dataList["COMPANY_ID"]).", ";
		$sql .= parent::expsData("HOTELPLAN_ID", "=", $dataList["HOTELPLAN_ID"]).", ";
		$sql .= parent::expsData("ROOM_ID", "=", $dataList["ROOM_ID"]).", ";
		$sql .= parent::expsData("HOTELPAY_DATE", "=", $dataList["HOTELPAY_DATE"], true).", ";
		for ($i=1; $i<=4; $i++) {
			$sql .= parent::expsData("HOTELPAY_PS_DATA".$i, "=", $dataList["HOTELPAY_PS_DATA".$i]).", ";
			$sql .= parent::expsData("HOTELPAY_PS_DATA".$i."2", "=", $dataList["HOTELPAY_PS_DATA".$i."2"]).", ";
		}
		for ($i=1; $i<=14; $i++) {
			$sql .= parent::expsData("HOTELPAY_BB_DATA".$i, "=", $dataList["HOTELPAY_BB_DATA".$i]).", ";
		}
		$sql .= parent::expsData("HOTELPAY_SERVICE_FLG", "=", $dataList["HOTELPAY_SERVICE_FLG"]).", ";
		$sql .= parent::expsData("HOTELPAY_SERVICE", "=", $dataList["HOTELPAY_SERVICE"]).", ";
		$sql .= parent::expsData("HOTELPAY_MONEY_FLG", "=", $dataList["HOTELPAY_MONEY_FLG"]).", ";
		$sql .= parent::expsData("HOTELPAY_REMARKS", "=", $dataList["HOTELPAY_REMARKS"], true, 1).", ";
		for ($i=1; $i<=6; $i++) {
			$sql .= parent::expsData("HOTELPAY_MONEY".$i, "=", $dataList["HOTELPAY_MONEY".$i], true).", ";
		}
		$sql .= parent::expsData("HOTELPAY_FLG_STOP", "=", $dataList["HOTELPAY_FLG_STOP"]).", ";
		$sql .= parent::expsData("HOTELPAY_ROOM_NUM", "=", $dataList["HOTELPAY_ROOM_NUM"]).", ";
		$sql .= parent::expsData("HOTELPAY_ROOM_OVER", "=", $dataList["HOTELPAY_ROOM_OVER"]).", ";
		$sql .= parent::expsData("HOTELPAY_DATE_UPDATE", "=", "now()")." ";
		$sql .= "where ";
		$sql .=  parent::expsData(hotelPay::keyName, "=", $dataList["HOTELPAY_ID"])." ";

		return $sql;
	}

	public function delete() {
// 		$this->db->begin();

// 		$sql .= "update ".hotelPay::tableName." set ";
// 		$sql .= parent::expsData("HOTELPICGROUP_STATUS", "=", 3).", ";
// 		$sql .= parent::expsData("HOTELPICGROUP_DATE_DELETE", "=", "now()")." ";
// 		$sql .= "where ";
// 		$sql .=  parent::expsData(hotelPay::keyName, "=", parent::getKeyValue())." ";

// 		if (!parent::saveExec($sql)) {
// 			$this->db->rollback();
// 			return false;
// 		}

// 		$this->db->commit();
// 		return true;

	}

	public function checkOnly($room) {
		if (!$_POST) return;

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_FLG_STOP"))) {
			parent::setError("HOTELPAY_FLG_STOP", "必須項目です");
		}

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_ROOM_NUM"))) {
			parent::setError("HOTELPAY_ROOM_NUM", "必須項目です");
		}
		elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_ROOM_NUM"), CHK_PTN_NUM)) {
			parent::setError("HOTELPAY_ROOM_NUM", "半角数字で入力して下さい");
		}
		elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_ROOM_NUM"), 10)) {
			parent::setError("HOTELPAY_ROOM_NUM", "10文字以内で入力して下さい");
		}
		else {
			if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_ROOM_NUM") > $room) {
				parent::setError("HOTELPAY_ROOM_NUM", "部屋数は".$room."部屋以内で入力して下さい");
			}
		}

	}

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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA12"))) {
			parent::setError("HOTELPAY_PS_DATA12", "必須項目です");
		}

		if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA12") == 1) {
			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA32"))) {
				parent::setError("HOTELPAY_PS_DATA32", "必須項目です");
			}
			elseif (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA32"), CHK_PTN_NUM)) {
				parent::setError("HOTELPAY_PS_DATA32", "半角数字で入力して下さい");
			}
			elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA32"), 10)) {
				parent::setError("HOTELPAY_PS_DATA32", "10文字以内で入力して下さい");
			}

			if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA42"))) {
				parent::setError("HOTELPAY_PS_DATA42", "必須項目です");
			}
		}
		else {
			if (cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA32"))) {
				if (!cmCheckPtn(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA32"), CHK_PTN_NUM)) {
					parent::setError("HOTELPAY_PS_DATA32", "半角数字で入力して下さい");
				}
				elseif (!cmChekLength(parent::getByKey(parent::getKeyValue(), "HOTELPAY_PS_DATA32"), 10)) {
					parent::setError("HOTELPAY_PS_DATA32", "10文字以内で入力して下さい");
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

		if (!cmCheckNull(parent::getByKey(parent::getKeyValue(), "HOTELPAY_MONEY_FLG"))) {
			parent::setError("HOTELPAY_MONEY_FLG", "必須項目です");
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

							if (!checkdate($mm, $dd, $y)) {
								continue;
							}

// 						if (parent::getByKey(parent::getKeyValue(), "HOTELPAY_MONEY_FLG") == 1) {
							//	人数別料金
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

									if (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) < parent::getByKey("BOOKSET_PAY_ALARM", "BOOKSET_PAY_ALARM")  and parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i) != "x") {
										$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」がアラーム設定された金額を下回っています。";
									}
								}
							}
// 						}
// 						else {
// 							if (!cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"))) {
// 								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「部屋料金」は必須項目です。";
// 							}
// 							elseif (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"), CHK_PTN_NUM)) {
// 								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「部屋料金」は半角数字で入力して下さい。";
// 							}
// 							elseif (!cmChekLength(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"), 10)) {
// 								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「部屋料金」は半角数字10文字以内で入力して下さい。";
// 							}
// 							else {
// 								if (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER") < parent::getByKey("BOOKSET_PAY_ALARM", "BOOKSET_PAY_ALARM")  and parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER") != "x") {
// 									$erCalender[] = $y.'-'.$mm.'-'.$dd."の「部屋料金」がアラーム設定された金額を下回っています。";
// 								}
// 							}
// 						}

						if (!cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"))) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は必須項目です。";
						}
						elseif (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"), CHK_PTN_NUM)) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は半角数字で入力してください。";
						}
						elseif (parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM") < 1 or parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM") > 10) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「ポイント率」は1～10%で入力してください。";
						}

						/*
						if (!cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"))) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「残部屋数」は必須項目です。";
						}
						elseif (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"), CHK_PTN_NUM)) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「残部屋数」は半角数字で入力して下さい。";
						}
						elseif (!cmChekLength(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"), 10)) {
							$erCalender[] = $y.'-'.$mm.'-'.$dd."の「残部屋数」は半角数字10文字以内で入力して下さい。";
						}
						*/

					/*
					}
					else {
						//	売り以外の場合
						for ($i=1; $i<=6; $i++) {
							if (cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i))) {
								if (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i), CHK_PTN_NUM)) {
									$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は半角数字で入力して下さい。";
								}
								elseif (!cmChekLength(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY".$i), 10)) {
									$erCalender[] = $y.'-'.$mm.'-'.$dd."の「".$i."人用金額」は半角数字10文字以内で入力して下さい。";
								}
							}
						}

						if (cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"))) {
							if (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"), CHK_PTN_NUM)) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「部屋数」は半角数字で入力してください。";
							}
							elseif (!cmChekLength(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM"), 10)) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「部屋数」は半角数字10文字以内で入力してください。";
							}
						}

						if (cmCheckNull(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"))) {
							if (!cmCheckPtn(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"), CHK_PTN_NUM)) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「残部屋数」は半角数字で入力して下さい。";
							}
							elseif (!cmChekLength(parent::getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER"), 10)) {
								$erCalender[] = $y.'-'.$mm.'-'.$dd."の「残部屋数」は半角数字10文字以内で入力して下さい。";
							}
						}
					}
					*/

// 						if ($to["y"] == $y and $to["m"] = $m and $to["d"] == $d) {
// 							break;
// 						}


					}
				}
			}
		}

		if (count($erCalender) > 0) {
			parent::setError("calencer", $erCalender);
		}

	}

	/*
	public function saveOrder() {
		$this->db->begin();
		foreach (parent::getByKey(parent::getKeyValue(), "order") as $k=>$v) {
			$sql  = "update ".hotelPay::tableName." set ";
			$sql .= parent::expsData("HOTELPICGROUP_ORDER","=",$k)." ";
			$sql .= "where ";
			$sql .= hotelPay::keyName." = ".$v." ";
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

			$this->setByKey($this->getKeyValue(), "HOTELPAY_PS_DATA2", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPAY_PS_DATA22", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPAY_BB_DATA2", 2);
			$this->setByKey($this->getKeyValue(), "HOTELPAY_BB_DATA9", 2);

			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}

			for ($i=1; $i<=6; $i++) {
// 				print_r($_POST["money".$i]);
				if (count($_POST["money".$i]) >0) {
					foreach ($_POST["money".$i] as $k=>$v) {
						$this->setByKey($k, "HOTELPAY_MONEY".$i, $v);
					}
				}
			}
			if (count($_POST["flgStop"]) >0) {
				foreach ($_POST["flgStop"] as $k=>$v) {
					$this->setByKey($k, "HOTELPAY_FLG_STOP", $v);
				}
			}
			if (count($_POST["num"]) >0) {
				foreach ($_POST["num"] as $k=>$v) {
					$this->setByKey($k, "HOTELPAY_ROOM_NUM", $v);
				}
			}
			if (count($_POST["over"]) >0) {
				foreach ($_POST["over"] as $k=>$v) {
					$this->setByKey($k, "HOTELPAY_ROOM_OVER", $v);
				}
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
				$this->setByKey($this->getKeyValue(), "hotelPay_LIST_CATEGORY", ":".$dataCategory.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPay_LIST_CATEGORY", $this->getByKey($this->getKeyValue(), "hotelPay_LIST_CATEGORY"));
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
					$this->setByKey($this->getKeyValue(), "hotelPay_LIST_CATEGORY_DETAIL", ":".$dataCategoryDetail.":");
				}
				else {
					$this->setByKey($this->getKeyValue(), "hotelPay_LIST_CATEGORY_DETAIL", "");
				}
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPay_LIST_CATEGORY_DETAIL", $this->getByKey($this->getKeyValue(), "hotelPay_LIST_CATEGORY_DETAIL"));
			}

			$dataArea = "";
			if (count($_POST["area"]) > 0) {
				foreach ($_POST["area"] as $d) {
					if ($dataArea != "") {
						$dataArea .= ":";
					}
					$dataArea .= $d;
				}
				$this->setByKey($this->getKeyValue(), "hotelPay_LIST_AREA", ":".$dataArea.":");
			}
			else {
				$this->setByKey($this->getKeyValue(), "hotelPay_LIST_AREA", $this->getByKey($this->getKeyValue(), "hotelPay_LIST_AREA"));
			}
			*/


		}

	}


}
?>