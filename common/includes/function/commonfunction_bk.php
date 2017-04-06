<?php
	require_once 'Net/UserAgent/Mobile.php';
	require_once 'Mail/Queue.php';

	function cmDateDiff($date1, $date2) {
		$daydiff = (strtotime($date2)-strtotime($date1))/(3600*24);
		return $daydiff;
	}

	function cmFeatureImageG($id) {
		$ar = array();
		$ar[7] = "images/category/common-icon01.png";
		$ar[2] = "images/category/common-icon02.png";
		$ar[3] = "images/category/common-icon03.png";
		$ar[4] = "images/category/common-icon04.png";
		$ar[5] = "images/category/common-icon05.png";
		$ar[6] = "images/category/common-icon06.png";
		return $ar[$id];
	}

	function cmDateDivide($date) {
		$d = array();
		list($yy, $mm, $dd) = explode('-', $date);
		$d["y"] = $yy;
		$d["m"] = $mm;
		$d["d"] = $dd;
		return $d;
	}

	/************************************************************************
	 * cmGetLatLng
	 * @return
	 * @param $divede Object
	 * @param $item Object
	 *************************************************************************/
	function cmGetLatLng($address, $key) {
		$api_uri = 'http://maps.google.com/maps/geo?key=' . $key . '&output=xml&ie=UTF8&q=';

		$xml = simplexml_load_file($api_uri . urlencode($address));

		foreach($xml->Response as $res) {
			$code = $res->Status->code;

			if($code == '200') {
				$coordinates = $res->Placemark->Point->coordinates;

			}
			else {
				$coordinates = FALSE;
			}
		}

		return $coordinates;
	}

	function cmMailSendQueue($from, $to, $subject, $body, $cc=array(), $option="system") {
		//	Mail Queue
		$db_options['type'] = 'mdb2';
		$db_options['dsn'] = 'mysql://'.DB_SLAKER_USERNAME.':'.DB_SLAKER_PASSWORD.'@'.DB_SLAKER_HOST.'/'.DB_SLAKER_DATABASE;
		$mail_options['driver']    = 'smtp';
		$mail_options['host']      = 'localhost';
		$mail_options['port']      = 25;
		$mail_options['localhost'] = 'localhost';
		$mail_options['auth']      = false;
		$mail_options['username']  = MAIL_SLAKER_NOREPLY;
		$mail_options['password'] = "";

		switch ($option) {
			default:
				$db_options['mail_table'] = "mail_queue_system";
				break;
		}

		$mail_queue = new Mail_Queue($db_options, $mail_options);

		$subject = mb_convert_encoding($subject,'ISO-2022-JP', 'UTF-8');
		$body = mb_convert_encoding($body,'ISO-2022-JP', 'UTF-8');

		if (count($cc) > 0) {
			foreach ($cc as $s) {
				$to .= ",".$s;
			}
		}

		$hdrs = array('From'=>$from, 'To'=>$to, 'Subject'=>$subject);

		$mime = new Mail_mime();
		$mime->setTXTBody($body);

		$param = array();
		$param["text_charset"] = 'ISO-2022-JP';
		$body = $mime->get($param);
		$hdrs = $mime->headers($hdrs);

		$resp = $mail_queue->put($from, $to, $hdrs, $body);
		if (Mail_Queue::isError($resp)) {
			cmLogOutput("ERROR","[mail][from]".$from."[to]".$to."[subject]".$hdrs["Subject"]."[body]".str_replace("\r\n", "", $body)."[msg]".$resp->getMessage());
			return false;
		}
		return true;
	}

	/***************************************************************
	 *	Calendar Confirm
	 ****************************************************************/
	/*
	function cmCalendarConfirm($year = "", $month = "", $holiady="") {
	    if(empty($year) && empty($month)) {
	        $year = date("Y");
	        $month = date("n");
	    }
	    //月末の取得
	    $l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));
	    //初期出力
    	$tmp = <<<EOM
<table cellspacing="0" cellpadding="0" border="0" class="calendarConfirm">
    <caption>{$year}年{$month}月</caption>
    <tr>
        <th class="red">日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th class="blue">土</th>
    </tr>\n
EOM;

	    $lc = 0;
	    //月末分繰り返す
	    for ($i = 1; $i < $l_day + 1;$i++) {
	        //曜日の取得
	        $week = date("w", mktime(0, 0, 0, $month, $i, $year));
	        //曜日が日曜日の場合
	        if ($week == 0) {
	            $tmp .= "\t<tr>\n";
	            $lc++;
	        }
	        //1日の場合
	        if ($i == 1) {
	            if($week != 0) {
	                $tmp .= "\t<tr>\n";
	                $lc++;
	            }
	            $tmp .= repeat($week);
	        }

	        $val = "off";
	        $class = "";
	        $today = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($i, 2, "0", STR_PAD_LEFT);

	        if ($_POST["date"][$today] == "on") {
		        $val = "on";
		        $class = "active";
	        }

	        $flgHoliday = false;
	        $classHoliday = " ";
	        if (cmHolidayCheck($today)) {
	        	$flgHoliday = true;
	        	$classHoliday = " holiday ";
	        }
	        elseif ($holiady != "") {
		        $targetHliday = date("Y-m-d",strtotime("1 day" ,strtotime($today)));
	        	if ($holiady->getByKey($targetHliday, "M_HOLIDAY_ID") != "") {
	        		$flgHoliday = true;
		        	$classHoliday = " holiday ";
	        	}
	        }

	        if ($i == date("j") && $year == date("Y") && $month == date("n")) {
	            //現在の日付の場合
				$tmp .= '<td class=" '.$class.$classHoliday.'">';
	            $tmp .= $i;
				$tmp .= '<input type="hidden" id="date'.$today.'" name="date['.$today.']" value="'.$val.'" />';
	        	if ($flgHoliday) {
					$tmp .= '<input type="hidden" id="holiday'.$today.'" name="holiday['.$today.']" value="'.$flgHoliday.'" />';
				}
				$tmp .= '</td>';
	        }
	        elseif ($i < date("j") && $year == date("Y") && $month == date("n")) {
	            $tmp .= "\t\t<td class='ago'>{$i}</td>\n";
	        }
	        else {
	            $tmp .= '<td class="'.$class.$classHoliday.'">';
	            $tmp .= $i;
				$tmp .= '<input type="hidden" id="date'.$today.'" name="date['.$today.']" value="'.$val.'" />';
	        	if ($flgHoliday) {
					$tmp .= '<input type="hidden" id="holiday'.$today.'" name="holiday['.$today.']" value="'.$flgHoliday.'" />';
				}
				$tmp .= '</td>';
	            //現在の日付ではない場合
	        }
	        //月末の場合
	        if ($i == $l_day) {
	            $tmp .= repeat(6 - $week);
	        }
	        //土曜日の場合
	        if($week == 6) {
	            $tmp .= "\t</tr>\n";
	        }
	    }
	    if($lc < 6) {
	        $tmp .= "\t<tr>\n";
	        $tmp .= repeat(7);
	        $tmp .= "\t</tr>\n";
	    }
	    if($lc == 4) {
	        $tmp .= "\t<tr>\n";
	        $tmp .= repeat(7);
	        $tmp .= "\t</tr>\n";
	    }
	    $tmp .= "</table>\n";
	    return $tmp;
	}
	*/


	/***************************************************************
	 *	Calendar Select
	****************************************************************/
	function cmCalendarSelect($year = "", $month = "", $fromday="", $endday="", $hotelPayTarget="", $holiady="", $only=false) {
		if(empty($year) && empty($month)) {
			$year = date("Y");
			$month = date("n");
		}
		//月末の取得
		$l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));
		//初期出力
		$tmp = <<<EOM
<table cellspacing="0" cellpadding="0" border="0" class="calendar">
    <caption>{$year}年{$month}月</caption>
    <tr>
    	<th></th>
        <th class="red" style="background-color: #ffc6c6;">日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th class="blue">土</th>
    </tr>\n
EOM;

		$lc = 0;
		//月末分繰り返す
		for ($i = 1; $i < $l_day + 1;$i++) {

			$continuFrom = "";
			if ($fromday != "") {
				//	開始日の曜日
				$week = date("w", mktime(0, 0, 0, $month, $fromday, $year));
				$continuFrom = $fromday - $week;
			}
			if ($continuFrom != "") {
				if ($i < $continuFrom) {
					continue;
				}
			}

			$continuTo = "";
			if ($endday != "") {
				//	終了日の曜日
				$week = date("w", mktime(0, 0, 0, $month, $endday, $year));
				$continuTo = $endday + (6 - $week);
			}
			if ($continuTo != "") {
				if ($i > $continuTo) {
					continue;
				}
			}

			//曜日の取得
			$week = date("w", mktime(0, 0, 0, $month, $i, $year));
			//曜日が日曜日の場合
			if ($week == 0) {
				$tmp .= "\t<tr>\n";
				$tmp .= "<td>";

				$tmp .= cmCalenderInputHead();

				$tmp .= "</td>";
				$lc++;
			}
			//1日の場合
			if ($i == 1) {
				if($week != 0) {
					$tmp .= "\t<tr>\n";
					$tmp .= "<td>";

					$tmp .= cmCalenderInputHead();

					$tmp .= "</td>";
					$lc++;
				}
				$tmp .= repeat($week);
			}


// 			$val = "off";
// 			$class = "";
// 			$today = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($i, 2, "0", STR_PAD_LEFT);

			if ($_POST["date"][$today] == "on") {
				$val = "on";
				$class = "active";
			}

			$flgHoliday = false;
			$classHoliday = " ";
			if (cmHolidayCheck($today)) {
				$flgHoliday = true;
				$classHoliday = " holiday ";
			}
			elseif ($holiady != "") {
				$targetHliday = date("Y-m-d",strtotime("1 day" ,strtotime($today)));
				if ($holiady->getByKey($targetHliday, "M_HOLIDAY_ID") != "") {
					$flgHoliday = true;
					$classHoliday = " holiday ";
				}
			}

			//	入力項目を表示するか
			$flgInput = false;

			if ($fromday != "" and $endday != "") {
				if ($i >= $fromday and $i <= $endday) {
					$flgInput = true;
				}
			}
			else {
				if ($fromday != "") {
					if ($i >= $fromday) {
						// 		        	print "a".$i."/".$fromday."<br />";
						$flgInput = true;
					}
				}
				if ($endday != "") {
					if ($i <= $endday) {
						$flgInput = true;
					}
				}
				if ($fromday == "" and $endday == "") {
					$flgInput = true;
				}
			}

			if ($i == date("j") && $year == date("Y") && $month == date("n")) {
				//現在の日付の場合
				$tmp .= '<td class="today">';

				$tmp .= cmCalenderInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);

				// 				$tmp .= '<input id="button'.$today.'" type="button" onclick="dateCheck(\''.$today.'\')" value="'.$i.'" class="'.$class.$classHoliday.'" />';
				// 				$tmp .= '<input type="hidden" id="date'.$today.'" name="date['.$today.']" value="'.$val.'" />';
				// 				if ($flgHoliday) {
				// 					$tmp .= '<input type="hidden" id="holiday'.$today.'" name="holiday['.$today.']" value="'.$flgHoliday.'" />';
				// 				}
				$tmp .= '</td>';
			}
			elseif ($i < date("j") && $year == date("Y") && $month == date("n")) {
				//	本日以前の日付
				// 	            $tmp .= "\t\t<td class='ago'>{$i}</td>\n";
				$tmp .= '<td>';
				$tmp .= cmCalenderInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);
				$tmp .= '</td>';
			}
			else {
				//	本日以降の日付
				$tmp .= '<td>';

				$tmp .= cmCalenderInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);
				/*
					$tmp .= '<input id="button'.$today.'" type="button" onclick="dateCheck(\''.$today.'\')" value="'.$i.'"  class="'.$class.$classHoliday.'" />';
				$tmp .= '<input type="hidden" id="date'.$today.'" name="date['.$today.']" value="'.$val.'" />';
				if ($flgHoliday) {
				$tmp .= '<input type="hidden" id="holiday'.$today.'" name="holiday['.$today.']" value="'.$flgHoliday.'" />';
				}
				*/
				$tmp .= '</td>';
			}
			//月末の場合
			if ($i == $l_day) {
				$tmp .= repeat(6 - $week);
			}
			//土曜日の場合
			if($week == 6) {
				$tmp .= "\t</tr>\n";
			}
		}
		if($lc < 6) {
			$tmp .= "\t<tr>\n";
			$tmp .= repeat(7);
			$tmp .= "\t</tr>\n";
		}
		if($lc == 4) {
			$tmp .= "\t<tr>\n";
			$tmp .= repeat(7);
			$tmp .= "\t</tr>\n";
		}
		$tmp .= "</table>\n";
		return $tmp;
	}



	//	宿泊人数
	function cmStayNum($targetDate, $hotelPayList) {
		$checkNum = 0;
		//	大人数
		$checkNum = intval($hotelPayList[$targetDate]["adult_number"]);
		//	小学生(低学年)
		if ($hotelPayList[$targetDate]["HOTELPAY_PS_DATA2"] == 1) {
			$checkNum += intval($hotelPayList[$targetDate]["child_number1"]);
		}
		//	小学生(高学年)
		if ($hotelPayList[$targetDate]["HOTELPAY_PS_DATA22"] == 1) {
			$checkNum += intval($hotelPayList[$targetDate]["child_number2"]);
		}
		//	幼児:食事・布団あり
		if ($hotelPayList[$targetDate]["HOTELPAY_BB_DATA2"] == 1) {
			$checkNum += intval($hotelPayList[$targetDate]["child_number３"]);
		}
		//	幼児:布団あり
		if ($hotelPayList[$targetDate]["HOTELPAY_BB_DATA8"] == 1) {
			$checkNum += intval($hotelPayList[$targetDate]["child_number5"]);
		}
		return $checkNum;
	}

	//	料金単価
	function cmStayMoney1($targetDate, $hotelPayList) {
		$retMoney1 = 0;
		//	宿泊人数
		$num = cmStayNum($targetDate, $hotelPayList);
		if ($num > 0 and $num <= 6) {
			$retMoney1 = $hotelPayList[$targetDate]["HOTELPAY_MONEY".$num];
		}
		elseif ($checkNum > 0 and $checkNum >= 6) {
			$retMoney1 = $hotelPayList[$targetDate]["HOTELPAY_MONEY6"];
		}
		else {
			$retMoney1 = $hotelPayList[$targetDate]["HOTELPAY_MONEY1"];
		}
		return $retMoney1;
	}

	//	子供料金計算
	//	料金フラグ：単価金額：子供用金額
	function cmChildMoney($flg, $money1, $datamoney) {
		$ret = 0;
		if ($flg == 1) {
			//	パーセント
			$ret = $money1*($datamoney/100);
		}
		elseif ($flg == 2) {
			//	円
			$ret = $datamoney;
		}
		elseif ($flg == 3) {
			//	円引き
			$ret = $money1 - $datamoney;
		}
		return $ret;
	}
	//	宿泊合計 1部屋あたり
	function cmStayMoneySum($targetDate, $hotelPayList) {
		//	単価
		$pay = cmStayMoney1($targetDate, $hotelPayList) ;
		$payAll = 0;
		//	大人
		if ($hotelPayList[$targetDate]["adult_number"] != "") {
			$payALL += $pay * intval($hotelPayList[$targetDate]["adult_number"]);
		}
		//	小学生(低学年)
		if ($hotelPayList[$targetDate]["child_number1"] != "") {
			$payALL += cmChildMoney($hotelPayList[$targetDate]["HOTELPAY_PS_DATA4"] , $pay, $hotelPayList[$targetDate]["HOTELPAY_PS_DATA3"] )*intval($hotelPayList[$targetDate]["child_number1"]);
		}
		//	小学生(高学年)
		if ($hotelPayList[$targetDate]["child_number2"] != "") {
			$payALL += cmChildMoney($hotelPayList[$targetDate]["HOTELPAY_PS_DATA42"] , $pay, $hotelPayList[$targetDate]["HOTELPAY_PS_DATA32"] )*intval($hotelPayList[$targetDate]["child_number2"]);
		}
		//	幼児 食事布団あり
		if ($hotelPayList[$targetDate]["child_number3"] != "") {
			$payALL += cmChildMoney($hotelPayList[$targetDate]["HOTELPAY_BB_DATA4"] , $pay, $hotelPayList[$targetDate]["HOTELPAY_BB_DATA3"] )*intval($hotelPayList[$targetDate]["child_number3"]);
		}
		//	幼児 食事あり
		if ($hotelPayList[$targetDate]["child_number4"] != "") {
			$payALL += cmChildMoney($hotelPayList[$targetDate]["HOTELPAY_BB_DATA7"] , $pay, $hotelPayList[$targetDate]["HOTELPAY_BB_DATA6"] )*intval($hotelPayList[$targetDate]["child_number4"]);
		}
		//	幼児 布団あり
		if ($hotelPayList[$targetDate]["child_number5"] != "") {
			$payALL += cmChildMoney($hotelPayList[$targetDate]["HOTELPAY_BB_DATA11"] , $pay, $hotelPayList[$targetDate]["HOTELPAY_BB_DATA10"] )*intval($hotelPayList[$targetDate]["child_number5"]);
		}
		//	幼児 食事布団なし
		if ($hotelPayList[$targetDate]["child_number6"] != "") {
			$payALL += cmChildMoney($hotelPayList[$targetDate]["HOTELPAY_BB_DATA14"] , $pay, $hotelPayList[$targetDate]["HOTELPAY_BB_DATA13"] )*intval($hotelPayList[$targetDate]["child_number6"]);
		}
		return $payALL;
	}

	/***************************************************************
	 *	Calendar Public
	****************************************************************/
	function calendarPublic($targetDate, $hotelPayList) {
		$target = cmDateDivide($targetDate);
		$year = $target["y"];
		$month = $target["m"];


		//月末の取得
		$l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));
		//初期出力
		$tmp = <<<EOM
<table cellspacing="0" cellpadding="0" border="1" class="calendar" width="100%">
    <caption>{$year}年{$month}月</caption>
    <tr>
        <th class="red" width="100">日</th>
        <th width="100">月</th>
        <th width="100">火</th>
        <th width="100">水</th>
        <th width="100">木</th>
        <th width="100">金</th>
        <th width="100" class="blue">土</th>
    </tr>\n
EOM;

		$lc = 0;
	    //月末分繰り返す
	    for ($i = 1; $i < $l_day + 1;$i++) {
	        //曜日の取得
	        $week = date("w", mktime(0, 0, 0, $month, $i, $year));
	        //曜日が日曜日の場合
	        if ($week == 0) {
	            $tmp .= "\t<tr>\n";
	            $lc++;
	        }
	        //1日の場合
	        if ($i == 1) {
	            if($week != 0) {
	                $tmp .= "\t<tr>\n";
	                $lc++;
	            }
	            $tmp .= repeat($week);
	        }

	        $val = "off";
	        $class = "";
	        $today = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($i, 2, "0", STR_PAD_LEFT);

	        if ($_POST["date"][$today] == "on") {
		        $val = "on";
		        $class = "active";
	        }

	        $flgHoliday = false;
	        $classHoliday = " ";
	        if (cmHolidayCheck($today)) {
	        	$flgHoliday = true;
	        	$classHoliday = " holiday ";
	        }
	        elseif ($holiady != "") {
		        $targetHliday = date("Y-m-d",strtotime("1 day" ,strtotime($today)));
	        	if ($holiady->getByKey($targetHliday, "M_HOLIDAY_ID") != "") {
	        		$flgHoliday = true;
		        	$classHoliday = " holiday ";
	        	}
	        }

	        if ($i < date("j") && $year == date("Y") && $month == date("n")) {
	        	$tmp .= "\t\t<td class='bg4'>{$i}</td>\n";
	        }
// 	        elseif ($i == date("j") && $year == date("Y") && $month == date("n")) {
// 	            //現在の日付の場合
// 				$tmp .= '<td class="bg4  '.$class.$classHoliday.'">';
// 	            $tmp .= $i;
// 				$tmp .= '<input type="hidden" id="date'.$today.'" name="date['.$today.']" value="'.$val.'" />';
// 	        	if ($flgHoliday) {
// 					$tmp .= '<input type="hidden" id="holiday'.$today.'" name="holiday['.$today.']" value="'.$flgHoliday.'" />';
// 				}
// 				$tmp .= '</td>';
// 	        }
	        else {

	        	$date = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($i, 2, "0", STR_PAD_LEFT);

	        	if ($hotelPayList[$date]["HOTELPROVIDE_FLG_STOP"] == 1 or $hotelPayList[$date]["HOTELPROVIDE_NUM"] > 0) {
		            $tmp .= '<td class="bg1 '.$class.$classHoliday.'">';
	        	}
	        	else {
		            $tmp .= '<td class=" '.$class.$classHoliday.'" valign="top" align="center">';
	        	}
	            $tmp .= '<p>'.$i.'</p>';
	            if ($hotelPayList[$date]["money_all"] > 0) {
		            $tmp .= '<p>'.number_format($hotelPayList[$date]["money_all"]).'円</p>';
	            }
	            if ($hotelPayList[$date]["money_1"] > 0) {
		            $tmp .= '<p>'.number_format($hotelPayList[$date]["money_1"]).'円</p>';
	            }
	            else {
	            }
	            if ($hotelPayList[$date]["HOTELPROVIDE_FLG_STOP"] == 1) {
	            	//	売り
	            	if ($hotelPayList[$date]["HOTELPROVIDE_FLG_REQUEST"] == 1) {
	            		$tmp .= '<p>'."問".'</p>';
	            	}
	            	else {
	            		$tmp .= '<p>'.$hotelPayList[$date]["HOTELPROVIDE_NUM"].'</p>';
	            	}
	            }
	            else {
	            	$tmp .= '<p>'."×".'</p>';
	            }

	            if ($hotelPayList[$date]["HOTELPROVIDE_FLG_STOP"] == 1 or $hotelPayList[$date]["HOTELPROVIDE_NUM"] > 0) {

	            	$formname = "frm".$hotelPayList[$date]["COMPANY_ID"]."_".$hotelPayList[$date]["HOTELPLAN_ID"]."_".str_replace("-", "", $date);
// 	            	$formname = "frm".$hotelPayList[$date]["COMPANY_ID"]."_".$hotelPayList[$date]["HOTELPLAN_ID"]."_".$hotelPayList[$date]["HOTELPAY_ID"];
	            	$inputs = new inputs();
	            	if ($hotelPayList[$date]["HOTELPROVIDE_FLG_STOP"] == 1) {
	            		$tmp .= '<form action="reservation.html" method="post" id="'.$formname.'" name="'.$formname.'"><div style="text-align:center;">';
	            		$tmp .= ' <a href="javascript:void(0)" onclick="document.'.$formname.'.submit();" class="vacancy" >予約</a>';
	            		$tmp .=  $inputs->hidden("COMPANY_ID", $hotelPayList[$date]["COMPANY_ID"]);
	            		$tmp .=  $inputs->hidden("COMPANY_LINK", $hotelPayList[$date]["COMPANY_LINK"]);
	            		$tmp .=  $inputs->hidden("HOTELPLAN_ID", $hotelPayList[$date]["HOTELPLAN_ID"]);
	            		$tmp .=  $inputs->hidden("ROOM_ID", $hotelPayList[$date]["ROOM_ID"]);
	            		$tmp .=  $inputs->hidden("HOTELPAY_ID", $hotelPayList[$date]["HOTELPAY_ID"]);
	            		$tmp .=  $inputs->hidden("HOTELPROVIDE_ID", $hotelPayList[$date]["HOTELPROVIDE_ID"]);
	            		$tmp .=  $inputs->hidden("target_date", $date);

	            		$tmp .=  $inputs->hidden("night_number", $hotelPayList[$date]["night_number"]);
	            		$tmp .=  $inputs->hidden("room_number", $hotelPayList[$date]["room_number"]);
	            		for ($roomNum=1; $roomNum<=$hotelPayList[$date]["room_number"]; $roomNum++) {
		            		$tmp .=  $inputs->hidden("adult_number".$roomNum, $hotelPayList[$date]["adult_number".$roomNum]);
		            		for ($ddd=1; $ddd<=6; $ddd++) {
		            			$tmp .=  $inputs->hidden("child_number".$roomNum.$ddd, $hotelPayList[$date]["child_number".$roomNum.$ddd]);
		            		}
	            		}
	            		$tmp .= '</div></form>';
	            	}

	            }

	            /*
	            $tmp .= '<table cellspacing="0" width="100%" boder="0">';
	            $tmp .= '<tr>';
		            $tmp .= '<td align="center">';
		            $tmp .= $i;
		            $tmp .= '</td>';
	            $tmp .= '</tr>';
	            $tmp .= '<tr>';
		            $tmp .= '<td align="center">';
// 		            $tmp .= cmStayNum($date, $hotelPayList)."<br />";
		            $tmp .= cmStayMoneySum($date, $hotelPayList);
		            $tmp .= '</td>';
	            $tmp .= '</tr>';
	            $tmp .= '<tr>';
		            $tmp .= '<td align="center">';
// 		            $hotelPayList[$targetDate]["HOTELPAY_MONEY".$num];
		            $tmp .= cmStayMoney1($date, $hotelPayList);
		            $tmp .= '</td>';
	            $tmp .= '</tr>';
	            $tmp .= '<tr>';
		            $tmp .= '<td align="center">';
		            if ($hotelPayList[$date]["HOTELPROVIDE_FLG_STOP"] == 1) {
		            	//	売り
			            if ($hotelPayList[$date]["HOTELPROVIDE_FLG_REQUEST"] == 1) {
			            	$tmp .= "問";
			            }
			            else {
			            	$tmp .= $hotelPayList[$date]["HOTELPROVIDE_NUM"];
			            }
		            }
		            else {
		            	$tmp .= "×";
		            }
		            $tmp .= '</td>';
	            $tmp .= '</tr>';
	            $tmp .= '<tr>';
		            $tmp .= '<td align="center">';

		            $formname = "frm".$hotelPayList[$date]["COMPANY_ID"]."_".$hotelPayList[$date]["HOTELPLAN_ID"]."_".$hotelPayList[$date]["HOTELPAY_ID"];
		            $inputs = new inputs();
		            if ($hotelPayList[$date]["HOTELPROVIDE_FLG_STOP"] == 1) {
		            	$tmp .= '<form action="reservation.html" method="post" id="'.$formname.'" name="'.$formname.'">';
		            	$tmp .= ' <a href="javascript:void(0)" onclick="document.'.$formname.'.submit();" class="vacancy">料金・空室を見る</a>';
		            	$tmp .=  $inputs->hidden("COMPANY_ID", $hotelPayList[$date]["COMPANY_ID"]);
		            	$tmp .=  $inputs->hidden("HOTELPLAN_ID", $hotelPayList[$date]["HOTELPLAN_ID"]);
		            	$tmp .=  $inputs->hidden("ROOM_ID", $hotelPayList[$date]["ROOM_ID"]);
		            	$tmp .=  $inputs->hidden("HOTELPAY_ID", $hotelPayList[$date]["HOTELPAY_ID"]);
		            	$tmp .=  $inputs->hidden("HOTELPROVIDE_ID", $hotelPayList[$date]["HOTELPROVIDE_ID"]);
		            	$tmp .=  $inputs->hidden("night_number", $hotelPayList[$date]["night_number"]);
		            	$tmp .=  $inputs->hidden("room_number", $hotelPayList[$date]["room_number"]);
		            	$tmp .=  $inputs->hidden("adult_number", $hotelPayList[$date]["adult_number"]);
		            	for ($ddd=1; $ddd<=6; $ddd++) {
		            		$tmp .=  $inputs->hidden("child_number".$ddd, $hotelPayList[$date]["child_number".$ddd]);
		            	}
		            	$tmp .= '</form>';
		            }

		            $tmp .= '</td>';
	            $tmp .= '</tr>';
	            $tmp .= '</table>';
	            */

				$tmp .= '</td>';
	            //現在の日付ではない場合
	        }
	        //月末の場合
	        if ($i == $l_day) {
	            $tmp .= repeat(6 - $week);
	        }
	        //土曜日の場合
	        if($week == 6) {
	            $tmp .= "\t</tr>\n";
	        }
	    }
	    if($lc < 6) {
	        $tmp .= "\t<tr>\n";
	        $tmp .= repeat(7);
	        $tmp .= "\t</tr>\n";
	    }
	    if($lc == 4) {
	        $tmp .= "\t<tr>\n";
	        $tmp .= repeat(7);
	        $tmp .= "\t</tr>\n";
	    }
	    $tmp .= "</table>\n";
	    return $tmp;

	}






	/***************************************************************
	 *	Calendar
	 ****************************************************************/
	function cmCalendar($year = "", $month = "", $fromday="", $endday="", $hotelPayTarget="", $holiady="", $only=false) {
	    if(empty($year) && empty($month)) {
	        $year = date("Y");
	        $month = date("n");
	    }
	    //月末の取得
	    $l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));
	    //初期出力
    	$tmp = <<<EOM
<table cellspacing="0" cellpadding="0" border="0" class="calendar">
    <caption>{$year}年{$month}月</caption>
    <tr>
    	<th></th>
        <th class="red" style="background-color: #ffc6c6;">日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th class="blue">土</th>
    </tr>\n
EOM;

	    $lc = 0;
	    //月末分繰り返す
	    for ($i = 1; $i < $l_day + 1;$i++) {

	    	$continuFrom = "";
	    	if ($fromday != "") {
		    	//	開始日の曜日
		    	$week = date("w", mktime(0, 0, 0, $month, $fromday, $year));
		    	$continuFrom = $fromday - $week;
	    	}
	    	if ($continuFrom != "") {
	    		if ($i < $continuFrom) {
	    			continue;
	    		}
	    	}

	    	$continuTo = "";
	    	if ($endday != "") {
	    		//	終了日の曜日
	    		$week = date("w", mktime(0, 0, 0, $month, $endday, $year));
	    		$continuTo = $endday + (6 - $week);
	    	}
	    	if ($continuTo != "") {
	    		if ($i > $continuTo) {
	    			continue;
	    		}
	    	}

	        //曜日の取得
	        $week = date("w", mktime(0, 0, 0, $month, $i, $year));
	        //曜日が日曜日の場合
	        if ($week == 0) {
	            $tmp .= "\t<tr>\n";
	            $tmp .= "<td>";

	            	$tmp .= cmCalenderInputHead();

	            $tmp .= "</td>";
	            $lc++;
	        }
	        //1日の場合
	        if ($i == 1) {
	            if($week != 0) {
	                $tmp .= "\t<tr>\n";
		            $tmp .= "<td>";

		            $tmp .= cmCalenderInputHead();

		            $tmp .= "</td>";
	                $lc++;
	            }
	            $tmp .= repeat($week);
	        }


	        $val = "off";
	        $class = "";
	        $today = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($i, 2, "0", STR_PAD_LEFT);

	        if ($_POST["date"][$today] == "on") {
		        $val = "on";
		        $class = "active";
	        }

	    	$flgHoliday = false;
	        $classHoliday = " ";
	        if (cmHolidayCheck($today)) {
	        	$flgHoliday = true;
	        	$classHoliday = " holiday ";
	        }
	        elseif ($holiady != "") {
		        $targetHliday = date("Y-m-d",strtotime("1 day" ,strtotime($today)));
	        	if ($holiady->getByKey($targetHliday, "M_HOLIDAY_ID") != "") {
	        		$flgHoliday = true;
		        	$classHoliday = " holiday ";
	        	}
	        }

	        //	入力項目を表示するか
	        $flgInput = false;

	        if ($fromday != "" and $endday != "") {
	        	if ($i >= $fromday and $i <= $endday) {
	        		$flgInput = true;
	        	}
	        }
	        else {
		        if ($fromday != "") {
		        	if ($i >= $fromday) {
// 		        	print "a".$i."/".$fromday."<br />";
		        		$flgInput = true;
		        	}
		        }
		        if ($endday != "") {
		        	if ($i <= $endday) {
		        		$flgInput = true;
		        	}
		        }
		        if ($fromday == "" and $endday == "") {
	        		$flgInput = true;
		        }
	        }

	        if ($i == date("j") && $year == date("Y") && $month == date("n")) {
	            //現在の日付の場合
				$tmp .= '<td class="today">';

				$tmp .= cmCalenderInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);

// 				$tmp .= '<input id="button'.$today.'" type="button" onclick="dateCheck(\''.$today.'\')" value="'.$i.'" class="'.$class.$classHoliday.'" />';
// 				$tmp .= '<input type="hidden" id="date'.$today.'" name="date['.$today.']" value="'.$val.'" />';
// 				if ($flgHoliday) {
// 					$tmp .= '<input type="hidden" id="holiday'.$today.'" name="holiday['.$today.']" value="'.$flgHoliday.'" />';
// 				}
				$tmp .= '</td>';
	        }
	        elseif ($i < date("j") && $year == date("Y") && $month == date("n")) {
	        	//	本日以前の日付
// 	            $tmp .= "\t\t<td class='ago'>{$i}</td>\n";
	        	$tmp .= '<td>';
	        	$tmp .= cmCalenderInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);
	        	$tmp .= '</td>';
	        }
	        else {
	        	//	本日以降の日付
	            $tmp .= '<td>';

	            $tmp .= cmCalenderInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);
	            /*
				$tmp .= '<input id="button'.$today.'" type="button" onclick="dateCheck(\''.$today.'\')" value="'.$i.'"  class="'.$class.$classHoliday.'" />';
				$tmp .= '<input type="hidden" id="date'.$today.'" name="date['.$today.']" value="'.$val.'" />';
	        	if ($flgHoliday) {
					$tmp .= '<input type="hidden" id="holiday'.$today.'" name="holiday['.$today.']" value="'.$flgHoliday.'" />';
				}
				*/
				$tmp .= '</td>';
	        }
	        //月末の場合
	        if ($i == $l_day) {
	            $tmp .= repeat(6 - $week);
	        }
	        //土曜日の場合
	        if($week == 6) {
	            $tmp .= "\t</tr>\n";
	        }
	    }
	    if($lc < 6) {
	        $tmp .= "\t<tr>\n";
	        $tmp .= repeat(7);
	        $tmp .= "\t</tr>\n";
	    }
	    if($lc == 4) {
	        $tmp .= "\t<tr>\n";
	        $tmp .= repeat(7);
	        $tmp .= "\t</tr>\n";
	    }
	    $tmp .= "</table>\n";
	    return $tmp;
	}

	function repeat($n) {
	    return str_repeat("\t\t<td> </td>\n", $n);
	}

	function cmCalenderInput($y, $m, $d, $flgEnable=false, $hotelPayTarget="", $only=false) {
		$dd = str_pad($d, 2, "0", STR_PAD_LEFT);
		$mm = str_pad($m, 2, "0", STR_PAD_LEFT);

		$week = date("w", mktime(0, 0, 0, $m, $d, $y));

		$readonly = '';
		$disabled = '';
		if ($only) {
			$readonly = 'readonly="readonly"';
			$disabled = 'disabled="disabled"';
		}

		$tmp = '<table class="calenderInput">';
		$tmp .= '<tr>';
		$tmp .= '<th>';
		$tmp .= ''.$d.'日';
		$tmp .= '</th>';
		$tmp .= '</tr>';
		/*
		$tmp .= '<tr>';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<select name="flgStop['.$y.'-'.$mm.'-'.$dd.']" class="circle weekFlgStop'.$week.' dateStop'.$y.$mm.'" '.$disabled.'>';
			$tmp .= '<option value="">-</option>';
			if ($hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_FLG_STOP")==1) {
				$tmp .= '<option value="1" selected="selected">売り</option>';
			}
			else {
				$tmp .= '<option value="1">売り</option>';
			}
			if ($hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_FLG_STOP")==2) {
				$tmp .= '<option value="2" selected="selected">止め</option>';
			}
			else {
				$tmp .= '<option value="2">止め</option>';
			}
			$tmp .= '</select>';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		*/
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekMoney1'.$week.' dateMoney1'.$y.$mm.'" name="money1['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY1").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekMoney2'.$week.' dateMoney2'.$y.$mm.'" name="money2['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY2").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekMoney3'.$week.' dateMoney3'.$y.$mm.'" name="money3['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY3").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekMoney4'.$week.' dateMoney4'.$y.$mm.'" name="money4['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY4").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekMoney5'.$week.' dateMoney5'.$y.$mm.'" name="money5['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY5").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekMoney6'.$week.' dateMoney6'.$y.$mm.'" name="money6['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_MONEY6").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';

		/*
		$tmp .= '<tr  class="setmoney_room">';
		$tmp .= '<td>';
		if ($flgEnable) {
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekOver'.$week.' dateOver'.$y.$mm.'" name="over['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_OVER").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		*/

		$tmp .= '<tr>';
		$tmp .= '<td>';
		if ($flgEnable) {
			//	ポイント率
			if ($hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM") == "") {
				$hotelPayTarget->setByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM", 1);
			}
			$tmp .= '<input type="text" class="wTime circle imeDisabled weekNum'.$week.' dateNum'.$y.$mm.'" name="num['.$y.'-'.$mm.'-'.$dd.']" value="'.$hotelPayTarget->getByKey($y.'-'.$mm.'-'.$dd, "HOTELPAY_ROOM_NUM").'" '.$readonly.' />';
		}
		$tmp .= '</td>';
		$tmp .= '</tr>';
		/*
		$tmp .= '<tr>';
		$tmp .= '<td>';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		*/
		$tmp .= '</table>';
		return $tmp;
	}

	function cmCalenderInputHead() {
		$tmp = '<table class="calenderInput">';
		$tmp .= '<tr>';
		$tmp .= '<td>日付';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		/*
		$tmp .= '<tr>';
		$tmp .= '<td>売り';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		*/
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>1名';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>2名';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>3名';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>4名';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>5名';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr class="setmoney_num">';
		$tmp .= '<td>6名以上';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		/*
		$tmp .= '<tr  class="setmoney_room">';
		$tmp .= '<td>部屋料金';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		*/
		$tmp .= '<tr>';
		$tmp .= '<td>ﾎﾟｲﾝﾄ率';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		/*
		$tmp .= '<tr>';
		$tmp .= '<td>予約数';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		$tmp .= '<tr>';
		$tmp .= '<td>残部屋';
		$tmp .= '</td>';
		$tmp .= '</tr>';
		*/
		$tmp .= '</table>';
		return $tmp;
	}
	
	
/***************************************************************
 *	Calendar for input Room Number
 ****************************************************************/
function cmCalendarRoomNum($year = "", $month = "", $fromday="", $endday="", $hotelPayTarget="", $holiady="", $only=false) {
    if(empty($year) && empty($month)) {
        $year = date("Y");
        $month = date("n");
    }
    //月末の取得
    $l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));
    //初期出力
	$tmp = <<<EOM
<table cellspacing="0" cellpadding="0" border="0" class="calendar">
<caption>{$year}年{$month}月</caption>
<tr>
    <th class="red" style="background-color: #ffc6c6;">日</th>
    <th>月</th>
    <th>火</th>
    <th>水</th>
    <th>木</th>
    <th>金</th>
    <th class="blue">土</th>
</tr>\n
EOM;

    $lc = 0;
    //月末分繰り返す
    for ($i = 1; $i < $l_day + 1;$i++) {

    	$continuFrom = "";
    	if ($fromday != "") {
	    	//	開始日の曜日
	    	$week = date("w", mktime(0, 0, 0, $month, $fromday, $year));
	    	$continuFrom = $fromday - $week;
    	}
    	if ($continuFrom != "") {
    		if ($i < $continuFrom) {
    			continue;
    		}
    	}

    	$continuTo = "";
    	if ($endday != "") {
    		//	終了日の曜日
    		$week = date("w", mktime(0, 0, 0, $month, $endday, $year));
    		$continuTo = $endday + (6 - $week);
    	}
    	if ($continuTo != "") {
    		if ($i > $continuTo) {
    			continue;
    		}
    	}

        //曜日の取得
        $week = date("w", mktime(0, 0, 0, $month, $i, $year));

        $val = "off";
        $class = "";
        $today = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($i, 2, "0", STR_PAD_LEFT);

        if ($_POST["date"][$today] == "on") {
	        $val = "on";
	        $class = "active";
        }

    	$flgHoliday = false;
        $classHoliday = " ";
        if (cmHolidayCheck($today)) {
        	$flgHoliday = true;
        	$classHoliday = " holiday ";
        }
        elseif ($holiady != "") {
	        $targetHliday = date("Y-m-d",strtotime("1 day" ,strtotime($today)));
        	if ($holiady->getByKey($targetHliday, "M_HOLIDAY_ID") != "") {
        		$flgHoliday = true;
	        	$classHoliday = " holiday ";
        	}
        }

        //	入力項目を表示するか
        $flgInput = false;

        if ($fromday != "" and $endday != "") {
        	if ($i >= $fromday and $i <= $endday) {
        		$flgInput = true;
        	}
        }
        else {
	        if ($fromday != "") {
	        	if ($i >= $fromday) {
// 		        	print "a".$i."/".$fromday."<br />";
	        		$flgInput = true;
	        	}
	        }
	        if ($endday != "") {
	        	if ($i <= $endday) {
	        		$flgInput = true;
	        	}
	        }
	        if ($fromday == "" and $endday == "") {
        		$flgInput = true;
	        }
        }

        if ($i == date("j") && $year == date("Y") && $month == date("n")) {
            //現在の日付の場合
			$tmp .= '<td class="today">';

			$tmp .= cmCalendarRoomNumInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);

			$tmp .= '</td>';
        }
        elseif ($i < date("j") && $year == date("Y") && $month == date("n")) {
        	//	本日以前の日付
        	$tmp .= '<td>';
        	$tmp .= cmCalendarRoomNumInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);
        	$tmp .= '</td>';
        }
        else {
        	//	本日以降の日付
            $tmp .= '<td>';

            $tmp .= cmCalendarRoomNumInput($year, $month, $i, $flgInput, $hotelPayTarget, $only);

			$tmp .= '</td>';
        }
        //月末の場合
        if ($i == $l_day) {
            $tmp .= repeat(6 - $week);
        }
        //土曜日の場合
        if($week == 6) {
            $tmp .= "\t</tr>\n";
        }
    }
    if($lc < 6) {
        $tmp .= "\t<tr>\n";
        $tmp .= repeat(7);
        $tmp .= "\t</tr>\n";
    }
    if($lc == 4) {
        $tmp .= "\t<tr>\n";
        $tmp .= repeat(7);
        $tmp .= "\t</tr>\n";
    }
    $tmp .= "</table>\n";
    return $tmp;
}

function cmCalendarRoomNumInput($y, $m, $d, $flgEnable=false, $hotelPayTarget="", $only=false) {
	$dd = str_pad($d, 2, "0", STR_PAD_LEFT);
	$mm = str_pad($m, 2, "0", STR_PAD_LEFT);

	$week = date("w", mktime(0, 0, 0, $m, $d, $y));

	$readonly = '';
	$disabled = '';
	if ($only) {
		$readonly = 'readonly="readonly"';
		$disabled = 'disabled="disabled"';
	}

	$tmp = '<table class="calenderInput">';
	$tmp .= '<tr style="border-bottom: 1px solid #ccc">';
	$tmp .= '<th>';
	$tmp .= ''.$d.'日';
	$tmp .= '</th>';
	$tmp .= '</tr>';

	$tmp .= '<tr class="setmoney_num" style="border-bottom: 1px solid #ccc">';
	$tmp .= '<td style="border-bottom: 1px solid #ccc">';
	$tmp .= '<input type="radio" name="" value=""> 販売<br/><input type="radio" name="" value=""> 売止';
	$tmp .= '</td>';
	$tmp .= '</tr>';
	$tmp .= '<tr class="setmoney_num" style="border-bottom: 1px solid #ccc">';
	$tmp .= '<td style="border-bottom: 1px solid #ccc">';
	$tmp .= '<input type="radio" name="" value=""> リクエスト<br/><input type="radio" name="" value=""> 設定なし';
	$tmp .= '</td>';
	$tmp .= '</tr>';
	$tmp .= '<tr class="setmoney_num">';
	$tmp .= '<td>';
	$tmp .= '<input type="text" class="wTime circle" name="" value="" />';
	$tmp .= '</td>';
	$tmp .= '</tr>';
	$tmp .= '</table>';
	return $tmp;
}

function cmCalendarRoomNumInputHead() {
	$tmp = '<table class="calenderInput">';
	$tmp .= '<tr>';
	$tmp .= '<td style="border-bottom: 1px solid #ccc">日付';
	$tmp .= '</td>';
	$tmp .= '</tr>';
	$tmp .= '<tr class="setmoney_num">';
	$tmp .= '<td style="border-bottom: 1px solid #ccc">ステータス';
	$tmp .= '</td>';
	$tmp .= '</tr>';
	$tmp .= '<tr class="setmoney_num">';
	$tmp .= '<td style="border-bottom: 1px solid #ccc">リクエスト予約';
	$tmp .= '</td>';
	$tmp .= '</tr>';
	$tmp .= '<tr class="setmoney_num">';
	$tmp .= '<td style="border-bottom: 1px solid #ccc">提供部屋数';
	$tmp .= '</td>';
	$tmp .= '</tr>';
	$tmp .= '</table>';
	return $tmp;
}
	

	/***************************************************************
	 *	Holiday Check
	 ****************************************************************/
	function cmHolidayCheck($target) {
		$wday = strftime( '%a', strtotime( $target ) );

		if ($wday == "Fri") {
			return true;
		}
		elseif ($wday == "Sat") {
			return true;
		}

		return false;
	}


	function cmGetPrefName() {
		$ar = array();
		/*
		$ar[1] = "北海道";
		$ar[2] = "青森県";
		$ar[3] = "岩手県";
		$ar[4] = "宮城県";
		$ar[5] = "秋田県";
		$ar[6] = "山形県";
		$ar[7] = "福島県";
		$ar[8] = "茨城県";
		$ar[9] = "栃木県";
		$ar[10] = "群馬県";
		$ar[11] = "埼玉県";
		$ar[12] = "千葉県";
		$ar[13] = "東京都";
		$ar[14] = "神奈川県";
		$ar[15] = "新潟県";
		$ar[16] = "富山県";
		$ar[17] = "石川県";
		$ar[18] = "福井県";
		$ar[19] = "山梨県";
		$ar[20] = "長野県";
		$ar[21] = "岐阜県";
		$ar[22] = "静岡県";
		$ar[23] = "愛知県";
		$ar[24] = "三重県";
		$ar[25] = "滋賀県";
		$ar[26] = "京都府";
		$ar[27] = "大阪府";
		$ar[28] = "兵庫県";
		$ar[29] = "奈良県";
		$ar[30] = "和歌山県";
		$ar[31] = "鳥取県";
		$ar[32] = "島根県";
		$ar[33] = "岡山県";
		$ar[34] = "広島県";
		$ar[35] = "山口県";
		$ar[36] = "徳島県";
		$ar[37] = "香川県";
		$ar[38] = "愛媛県";
		$ar[39] = "高知県";
		$ar[40] = "福岡県";
		$ar[41] = "佐賀県";
		$ar[42] = "長崎県";
		$ar[43] = "熊本県";
		$ar[44] = "大分県";
		$ar[45] = "宮崎県";
		$ar[46] = "鹿児島県";
		*/
		$ar[47] = "沖縄県";

		return $ar;
	}

	/***************************************************************
	 *	Cul Age
	 ****************************************************************/
	function cmCalculateAge($birthday) {
		if ($birthday == "") {
			return;
		}
		$birthday = intval(str_replace('-', '', $birthday));
		$today    = intval(date('Ymd'));
		return intval(($today - $birthday) / 10000);
	}

	/***************************************************************
	 *	Cul Birthday
	 ****************************************************************/
	function cmCalculateBirthday($age){
	  $ty = date("Y");
	  $tm = date("m");
	  $td = date("d");
	  $by = $ty - $age;
	  $birth['under'] = date("Y-m-d",mktime(0,0,0,$tm,$td+1,$by-1));
	  $birth['over'] = date("Y-m-d",mktime(0,0,0,$tm,$td,$by));
	  return $birth;
	}

	/***************************************************************
	 *	Mobile Check
	 ****************************************************************/
	function cmCheckMobile() {
		return Net_UserAgent_Mobile::isMobile();
	}
	function cmCheckSmartphone() {
		$ptn = '#iPhone|iPod|Android|dream|CUPCAKE|blackberry|webOS|incognito|webmat#i';
		return (boolean)preg_match($ptn, $_SERVER['HTTP_USER_AGENT']);
	}

	/***************************************************************
	 *	Extension
	 ****************************************************************/
	function cmGetExtension($name) {

		return pathinfo($name, PATHINFO_EXTENSION);
	}

	/***************************************************************
	 *	shop status
	 ****************************************************************/
	function cmFlgCompanyStatus($val) {
		if ($val == 1) {
			return "未契約";
		}
		elseif ($val == 2) {
			return "契約中";
		}
		elseif ($val == 3) {
			return "契約満了";
		}
		elseif ($val == 4) {
			return "強制削除";
		}
	}

	function cmFlgPublicStatus($val) {
		if ($val == 1) {
			return "公開";
		}
		elseif ($val == 2) {
			return "非公開";
		}
		elseif ($val == 3) {
			return "削除済";
		}
		return "";
	}

	function cmFlgContentsStatus($val) {
		if ($val == 1) {
			return "非公開";
		}
		elseif ($val == 2) {
			return "公開";
		}
		elseif ($val == 3) {
			return "編集不可";
		}
		return "";
	}

	/***************************************************************
	 *	flg delete
	 ****************************************************************/
	function cmFlgDelete($val) {
		if ($val == 1) {
			return "有効";
		}
		else {
			return "削除済";
		}
	}


	/***************************************************************
	 * cmStrimWidth
	 * $target	:	target string
	 * $s	:	start offset
	 * $length	:	width
	 * $word	:	add words
	 ****************************************************************/
	function cmStrimWidth($target, $s, $length, $word) {
		return mb_strimwidth($target, $s, $length, $word, utf8);
	}


	/***************************************************************
	 * cmCheckFile
	 ****************************************************************/
	function cmCheckFile($target) {
		if (file_exists($target)) {
			return true;
		}
		else {
			return false;
		}
	}

	/***************************************************************
	 * cmCheckDir
	 *
	 ****************************************************************/
	function cmCheckDir($target) {
		if (is_dir($target)) {
			return true;
		}
		else {
			return false;
		}
	}

	/***************************************************************
	 * cmMakeDir
	 *
	 ****************************************************************/
	function cmMakeDir($target) {
		if (mkdir($target, 0777, true)) {
			return true;
		}
		else {
			return false;
		}
	}

	/***************************************************************
	 * log
	 *
	 *	$type	:	INFO/WARN/DEBUG/ERROR
	 ***************************************************************/
	function cmLogOutput($type, $msg) {
		/*
		cmLogOutput("ERROR", "msg");
		*/
		switch (LOG_DIVIDE) {
			case "admin":
				$log =& LoggerManager::getLogger('Log.admin');
				break;
			case "public":
				$log =& LoggerManager::getLogger('Log.public');
				break;
			case "batch":
				$log =& LoggerManager::getLogger('Log.batch');
				break;
			case "sphone":
				$log =& LoggerManager::getLogger('Log.sphone');
				break;
			case "mobile":
				$log =& LoggerManager::getLogger('Log.mobile');
				break;
			case "shop":
				$log =& LoggerManager::getLogger('Log.shop');
				break;
			default:
				$log =& LoggerManager::getLogger('Log.miss');
				break;
		}
		$log->$type('[ip]'.$_SERVER["REMOTE_ADDR"]." [script]".$_SERVER["SCRIPT_FILENAME"]." [ua]".$_SERVER["HTTP_USER_AGENT"]);
		$log->$type($msg);
	}

	/***************************************************************
	 * id check
	 *
	 *
	 ***************************************************************/
	function cmIdCheck($id) {
		if ($_GET["id"] != "") {
			return $_GET["id"];
		}
		elseif($_POST[$id] !="")  {
			return $_POST[$id];
		}

		return -1;
	}

	/***************************************************************
	 * key check
	 *
	 *
	 ***************************************************************/
	function cmKeyCheck($id) {
		if ($_GET["key"] != "") {
			return $_GET["key"];
		}
		elseif($_POST[$id] !="")  {
			return $_POST[$id];
		}

		return -1;
	}

	/***************************************************************
	 * localtion change
	 *
	 *
	 ***************************************************************/
	function cmLocationChange($location) {
// 		header("HTTP/1.0 301 Moved Permanently");
		if (cmCheckMobile()) {
			header("Location: ".$location."?".ini_get('session.name')."=".session_id());
			exit;
		}
		else {
			header("Location: ".$location);
		}
	}

	/***************************************************************
	 *	replace
	 *
	 *
	 ***************************************************************/
	function cmReplaceGroup($target) {
		return ereg_replace('[0-9]+$',"",$target);
	}
	function cmReplace($target, $from, $to) {
		return str_replace($from, $to, $target);
	}

	/***************************************************************
	 * Check Function
	 *		true :OK
	 * 		false:ERROR
	 ***************************************************************/
	//	Null Check
	function cmCheckNull($target="") {
		if (!strlen(trim($target))) {
			return false;
		}
		return true;
	}
	//day
	
	function cmCheckSpan($target="",$key){
		require_once('includes/applicationInc.php');
		require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotel.php');
		require_once(PATH_SLAKER_COMMON.'includes/class/extends/hotelBookset.php');
		
		$dbMaster = new dbMaster();
		$sess = new sessionCompany($dbMaster);
		$sess->start();
		
		$hotelBookset = new hotelBookset($dbMaster);
		$hotelBookset->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));
		if ($target < $hotelBookset->getByKey($hotelBookset->getKeyValue(), $key)) {
			return false;
		}
		return true;
	}
	
	
	//	Char Length Check
	function cmChekLength($target="",$length="") {
		if (mb_strlen($target,"utf-8") > $length) {
			return false;
		}
		return true;
	}
	//	Char Length Between
	function cmCheckLengthBetween($target="",$lengthMax="",$lengthMin="") {
		if (mb_strlen($target,"utf-8") >= $lengthMin && mb_strlen($target,"utf-8") <= $lengthMax) {
			return true;
		}
		else {
			return false;
		}
	}
	//	Pattern Muching
	function cmCheckPtn($target="",$ptn="") {
		if (!preg_match($ptn,$target)) {
			return false;
		}
		return true;
	}

	/************************************************************************
	 * Xss
	 * @return
	 * @param $val Object
	 */
	function redirectForXss($val) {
		//$val = stripslashes($val);
		$val = htmlspecialchars(trim($val),ENT_QUOTES);
//		$val = htmlentities(trim($val), ENT_QUOTES, mb_internal_encoding("UTF-8"));
		return $val;
	}

	/************************************************************************
	 * command injection
	 * @return
	 * @param $val Object
	 */
	function redirectForOci($val) {
		return escapeshellarg($val);
	}

	/************************************************************************
	 * sql injection
	 * @return
	 * @param $val Object
	 */
	function redirectForSi($val) {
		return mysql_real_escape_string($val);
	}

	/************************************************************************
	 * return replace
	 * @return
	 * @param $val Object
	 */
	function redirectForReturn($val) {
		return str_replace(array("\r\n", "\n", "\r"),'<br />',$val);
	}


	function cmHotelKind() {
		$retAr = array();
		$retAr[1] = "リゾートホテル";
		$retAr[2] = "旅館";
		$retAr[3] = "ビジネス・シティホテル";
		$retAr[4] = "ペンション・民宿";
		$retAr[5] = "貸別荘・コンドミニアム";
		return $retAr;
	}

	function cmHotelService() {
		$retAr = array();
		$retAr[1] = "送迎";
		$retAr[2] = "ファックス送信";
		$retAr[3] = "共用パソコン利用可";
		$retAr[4] = "共用プリンター利用可";
		$retAr[5] = "クリーニング";
		$retAr[6] = "モーニングコール";
		$retAr[7] = "宅配便";
		$retAr[8] = "コンシェルジュ";
		$retAr[9] = "ルームサービス";
		$retAr[10] = "ペット宿泊可（有料・ケージあり）";
		$retAr[11] = "ペット宿泊可（有料・ケージ持ち込み）";
		$retAr[12] = "ペット宿泊可（有料・部屋、館内同伴可）";
		$retAr[13] = "ペット宿泊可（有料・ペットホテル）";
		$retAr[14] = "ペット宿泊可（無料・ケージあり）";
		$retAr[15] = "ペット宿泊可（無料・ケージ持ち込み）";
		$retAr[16] = "ペット宿泊可（無料・部屋、館内同伴可）";
		$retAr[17] = "ペット宿泊可（無料・ペットホテル）";
		return $retAr;
	}

	function cmHotelFacility1() {
		$retAr = array();
		$retAr[1] = "レストラン";
		$retAr[2] = "カフェ";
		$retAr[3] = "喫茶・ティーラウンジ";
		$retAr[4] = "ラウンジ";
		$retAr[5] = "バーラウンジ";
		$retAr[6] = "バー";
		$retAr[7] = "居酒屋";
		$retAr[8] = "バーベキュー（有料）";
		$retAr[9] = "バーベキュー（無料）";
		return $retAr;
	}
	function cmHotelFacility2() {
		$retAr = array();
		$retAr[1] = "カラオケ";
		$retAr[2] = "ゲームコーナー";
		$retAr[3] = "麻雀ルーム";
		return $retAr;
	}
	function cmHotelFacility3() {
		$retAr = array();
		$retAr[1] = "宴会場";
		$retAr[2] = "会議室";
		$retAr[3] = "多目的室";
		$retAr[4] = "結婚式場・チャペル";
		return $retAr;
	}
	function cmHotelFacility4() {
		$retAr = array();
		$retAr[1] = "大浴場";
		$retAr[2] = "サウナ";
		$retAr[3] = "露天風呂";
		$retAr[4] = "休憩所";
		return $retAr;
	}
	function cmHotelFacility5() {
		$retAr = array();
		$retAr[1] = "キッズ遊具コーナー（屋内）";
		$retAr[2] = "キッズ遊具コーナー（屋外）";
		$retAr[3] = "保育室";
		return $retAr;
	}
	function cmHotelFacility6() {
		$retAr = array();
		$retAr[1] = "売店・コンビニ";
		$retAr[2] = "ブティック";
		$retAr[3] = "フラワーショップ";
		$retAr[4] = "ドラッグストア";
		return $retAr;
	}
	function cmHotelFacility7() {
		$retAr = array();
		$retAr[1] = "美容室";
		$retAr[2] = "エステサロン";
		return $retAr;
	}
	function cmHotelFacility8() {
		$retAr = array();
		$retAr[1] = "屋外プール（通年）";
		$retAr[2] = "屋外プール（夏のみ）";
		$retAr[3] = "屋内プール（通年）";
		$retAr[4] = "屋内プール（夏のみ）";
		$retAr[5] = "幼児用プール";
		$retAr[6] = "ウォータースライダー（通年）";
		$retAr[7] = "ウォータースライダー（夏のみ）";
		return $retAr;
	}
	function cmHotelFacility9() {
		$retAr = array();
		$retAr[1] = "スポーツジム・フィットネス";
		$retAr[2] = "テニスコート";
		$retAr[3] = "卓球";
		$retAr[4] = "ゴルフ場";
		$retAr[5] = "体育館";
		$retAr[6] = "グラウンド";
		$retAr[7] = "自転車の貸し出し";
		$retAr[8] = "ダンスホール";
		$retAr[9] = "マリン・アクティビティショップ";
		$retAr[10] = "ダイビング機材乾燥室";
		$retAr[11] = "手作り体験工房";
		$retAr[11] = "ビーチ";
		return $retAr;
	}
	function cmHotelFacility10() {
		$retAr = array();
		$retAr[1] = "禁煙ルーム";
		$retAr[2] = "ライブラリー";
		$retAr[3] = "共用キッチン";
		$retAr[4] = "共用冷蔵庫";
		$retAr[5] = "自動販売機";
		$retAr[6] = "製氷機";
		$retAr[7] = "コインランドリー（有料）";
		$retAr[8] = "ランドリーコーナー（無料）";
		return $retAr;
	}

	function cmHotelAmenity() {
		$retAr = array();
		$retAr[1] = "タオル";
		$retAr[2] = "バスタオル";
		$retAr[3] = "ウォッシュタオル";
		$retAr[4] = "石鹸（固形）";
		$retAr[5] = "石鹸（液体）";
		$retAr[6] = "ボディーソープ";
		$retAr[7] = "リンスインシャンプー";
		$retAr[8] = "シャンプー";
		$retAr[9] = "リンス・コンディショナー";
		$retAr[10] = "洗顔用ソープ";
		$retAr[11] = "クレンジング・メイク落とし";
		$retAr[12] = "化粧水";
		$retAr[13] = "乳液";
		$retAr[14] = "入浴剤";
		$retAr[15] = "歯磨きセット";
		$retAr[16] = "カミソリ";
		$retAr[17] = "シャワーキャップ";
		$retAr[18] = "ヘアゴム";
		$retAr[19] = "くし・ブラシ";
		$retAr[20] = "綿棒";
		$retAr[21] = "ナイトウェア";
		$retAr[22] = "リラックスウェア";
		$retAr[23] = "パジャマ";
		$retAr[24] = "浴衣";
		$retAr[25] = "ナイトガウン";
		$retAr[26] = "バスローブ";
		$retAr[27] = "スリッパ（室内のみ）";
		$retAr[28] = "スリッパ（館内のみ）";
		$retAr[29] = "サンダル";
		$retAr[30] = "サンダル（室内のみ）";

		return $retAr;
	}

	function cmHotelRoom1() {
		$retAr = array();

		$retAr[1] = "テレビ";
		$retAr[2] = "テレビ（有料）";
		$retAr[3] = "衛星放送";
		$retAr[4] = "衛生放送（有料）";
		$retAr[5] = "有料ビデオ";
		$retAr[6] = "ケーブルTV";
		$retAr[7] = "有線放送";
		$retAr[8] = "CS放送";
		$retAr[9] = "CS放送（有料）";

		return $retAr;
	}
	function cmHotelRoom2() {
		$retAr = array();

		$retAr[1] = "電話";
		$retAr[2] = "ファックス";
		$retAr[3] = "ファックス（貸出）";
		$retAr[4] = "ファックス（一部）";
		$retAr[5] = "インターネット接続（有線LAN）";
		$retAr[6] = "インターネット接続（無線LAN）";
		$retAr[7] = "インターネット接続（一部、有線LAN）";
		$retAr[8] = "インターネット接続（一部、無線LAN）";

		return $retAr;
	}
	function cmHotelRoom3() {
		$retAr = array();

		$retAr[1] = "湯沸かしポット";
		$retAr[2] = "湯沸かしポット（貸出）";
		$retAr[3] = "お茶セット";
		$retAr[4] = "ミニバー";
		$retAr[5] = "ミニバー（有料）";
		$retAr[6] = "冷蔵庫（空室）";
		$retAr[7] = "冷蔵庫（有料）";
		$retAr[8] = "冷蔵庫（一部）";

		return $retAr;
	}
	function cmHotelRoom4() {
		$retAr = array();

		$retAr[1] = "ドライヤー";
		$retAr[2] = "ドライヤー（貸出）";
		$retAr[3] = "ドライヤー（一部）";
		$retAr[4] = "消臭スプレー";
		$retAr[5] = "消臭スプレー（貸出）";
		$retAr[6] = "ズボンプレッサー";
		$retAr[7] = "ズボンプレッサー（貸出）";
		$retAr[8] = "ズボンプレッサー（一部）";
		$retAr[9] = "アイロン";
		$retAr[10] = "アイロン（貸出）";
		$retAr[11] = "アイロン（一部）";

		return $retAr;
	}
	function cmHotelRoom5() {
		$retAr = array();

		$retAr[1] = "エアコン（個別空調）";
		$retAr[2] = "エアコン（有料・個別空調）";
		$retAr[3] = "空気清浄器";
		$retAr[4] = "空気清浄器（貸出）";
		$retAr[5] = "空気清浄器（一部）";
		$retAr[6] = "加湿器";
		$retAr[7] = "加湿器（貸出）";
		$retAr[8] = "加湿器（一部）";
		$retAr[9] = "洗浄機付トイレ";
		$retAr[10] = "洗浄機付トイレ（一部）";

		return $retAr;
	}
	function cmHotelRoom6() {
		$retAr = array();

		$retAr[1] = "CDプレイヤー";
		$retAr[2] = "CDプレイヤー（貸出）";
		$retAr[3] = "CDプレイヤー（一部）";
		$retAr[4] = "DVDプレイヤー";
		$retAr[5] = "DVDプレイヤー（貸出）";
		$retAr[6] = "DVDプレイヤー（一部）";
		$retAr[7] = "電気スタンド";
		$retAr[8] = "電気スタンド（貸出）";
		$retAr[9] = "電気スタンド（一部）";

		return $retAr;
	}
	function cmHotelRoom7() {
		$retAr = array();

		$retAr[1] = "電子レンジ";
		$retAr[2] = "電子レンジ（一部・要予約）";
		$retAr[3] = "食器セット";
		$retAr[4] = "食器セット（貸出）";
		$retAr[5] = "調理器具";
		$retAr[6] = "調理器具（貸出）";
		$retAr[7] = "ミニキッチン";
		$retAr[8] = "ミニキッチン（一部・要予約）";

		return $retAr;
	}
	function cmHotelRoom8() {
		$retAr = array();

		$retAr[1] = "パソコン";
		$retAr[2] = "パソコン（貸出）";
		$retAr[3] = "LANケーブル";
		$retAr[4] = "LANケーブル（貸出）";
		$retAr[5] = "プリンター";
		$retAr[6] = "プリンター（貸出）";

		return $retAr;
	}
	function cmHotelRoom9() {
		$retAr = array();

		$retAr[1] = "金庫";

		return $retAr;
	}

	function cmHotelPet() {
		$retAr = array();

		$retAr[1] = "超大型犬（30kg以上）";
		$retAr[2] = "大型犬（～30kg）";
		$retAr[3] = "中型犬（～20kg）";
		$retAr[4] = "小型犬（～10kg）";
		$retAr[5] = "超小型犬（5kg以下）";
		$retAr[6] = "猫";
		$retAr[7] = "小動物";

		//	同室できる
		$retAr[10] = "ペット可部屋のみ";
		$retAr[11] = "ペット可部屋のみ（ケージ利用）";
		$retAr[12] = "全部屋";
		$retAr[13] = "全部屋（ケージ利用）";

		//	同室できない
		$retAr[20] = "屋外";
		$retAr[21] = "ペットホテル";
		$retAr[22] = "別室にて預かり";
		$retAr[23] = "その他";

		//	ペット同伴OKの場所
		$retAr[30] = "レストラン（全席OK）";
		$retAr[31] = "レストラン（テラス席のみ）";
		$retAr[32] = "カフェ（全席OK）";
		$retAr[33] = "カフェ（テラス席のみ）";
		$retAr[34] = "バー・ラウンジ（全席OK）";
		$retAr[35] = "バー・ラウンジ（テラス席のみ）";
		$retAr[36] = "ロビー";
		$retAr[37] = "その他";

		//	ペット用設備
		$retAr[40] = "ドッグラン";
		$retAr[41] = "ペットホテル";
		$retAr[42] = "一時預かり";
		$retAr[43] = "温泉";
		$retAr[44] = "大浴場";
		$retAr[45] = "足洗い場";
		$retAr[46] = "トリミングサロン";
		$retAr[47] = "アジリティ";
		$retAr[48] = "その他";

		//	ペットの持ち物
		$retAr[50] = "首輪";
		$retAr[51] = "リード";
		$retAr[52] = "食器";
		$retAr[53] = "フード";
		$retAr[54] = "おやつ";
		$retAr[55] = "おもちゃ";
		$retAr[56] = "トイレシーツ";
		$retAr[57] = "粘着テープ";
		$retAr[58] = "消臭スプレー";
		$retAr[59] = "足ふきタオル";
		$retAr[60] = "バスタオル";
		$retAr[61] = "寝具（マット、シーツなど）";
		$retAr[62] = "ケージ";
		$retAr[63] = "その他";

		//	ペットの宿泊条件
		$retAr[70] = "トイレのしつけOK";
		$retAr[71] = "予防接種済み";
		$retAr[72] = "ダニ・ノミよけOK";
		$retAr[73] = "無駄吠えしない";
		$retAr[74] = "ひとりで留守番できる";
		$retAr[75] = "発情期は宿泊不可";
		$retAr[76] = "その他";

		return $retAr;
	}


	function cmHotelLocation() {
		$retAr = array();

		$retAr[1] = "駅から5分以内";
		$retAr[2] = "コンビニまで徒歩5分以内";
		$retAr[3] = "ビーチまで徒歩5分以内";
		$retAr[4] = "ゲレンデまで徒歩5分以内";

		return $retAr;
	}

	function cmHotelInternet() {
		$retAr = array();

		$retAr[1] = "ダイヤルアップ";
		$retAr[2] = "無線LAN";
		$retAr[3] = "優先LAN";
		$retAr[11] = "PC貸出あり";
		$retAr[12] = "インターネット接続無料";

		return $retAr;
	}

	function cmHotelSpa() {
		$retAr = array();

		$retAr[1] = "あり(男女ともあり(時間交代含む)・貸切可)";
		$retAr[2] = "あり(男女ともあり(時間交代含む)・貸切不可)";
		$retAr[3] = "あり(男女どちらか1つのみ(混浴含む)・貸切可)";
		$retAr[4] = "あり(男女どりらか1つのみ(混浴含む)・貸切不可)";
		$retAr[5] = "なし";

		return $retAr;
	}

	function cmHotelDaySelect($limit="") {
		$retAr = array();
		$dataAr = array();

		$retAr[1] = "当日";
		$retAr[2] = "前日";
		$retAr[3] = "2日前";
		$retAr[4] = "3日前";

		foreach ($retAr as $k=>$v) {
			$dataAr[$k] = $v;
			if ($limit != "" and $limit == $k) {
				break;
			}
		}
		return $dataAr;
	}

	function cmHotelHourSelect($limit="") {
		$retAr = array();
		$dataAr = array();

		$retAr[16] = "6";
		$retAr[17] = "7";
		$retAr[18] = "8";
		$retAr[19] = "9";
		$retAr[20] = "10";
		$retAr[21] = "11";
		$retAr[22] = "12";
		$retAr[23] = "13";
		$retAr[24] = "14";

		$retAr[1] = "15";
		$retAr[2] = "16";
		$retAr[3] = "17";
		$retAr[4] = "18";
		$retAr[5] = "19";
		$retAr[6] = "20";
		$retAr[7] = "21";
		$retAr[8] = "22";
		$retAr[9] = "23";
		$retAr[10] = "24";
		$retAr[11] = "25";
		$retAr[12] = "26";
		$retAr[13] = "27";
		$retAr[14] = "28";
		$retAr[15] = "29";

		foreach ($retAr as $k=>$v) {
			$dataAr[$k] = $v;
			if ($limit != "" and $limit == $k) {
				break;
			}
		}
		return $dataAr;
	}
	
	function cmHotelHourSelect_inputPlan($limit="") {
		$retAr = array();
		$dataAr = array();
	
		$retAr[0] = "0";
		$retAr[1] = "1";
		$retAr[2] = "2";
		$retAr[3] = "3";
		$retAr[4] = "4";
		$retAr[5] = "5";
		$retAr[6] = "6";
		$retAr[7] = "7";
		$retAr[8] = "8";
		$retAr[9] = "9";
		$retAr[10] = "10";
		$retAr[11] = "11";
		$retAr[12] = "12";
		$retAr[13] = "13";
		$retAr[14] = "14";
		$retAr[15] = "15";
		$retAr[16] = "16";
		$retAr[17] = "17";
		$retAr[18] = "18";
		$retAr[19] = "19";
		$retAr[20] = "20";
		$retAr[21] = "21";
		$retAr[22] = "22";
		$retAr[23] = "23";
		$retAr[24] = "24";
		
		foreach ($retAr as $k=>$v) {
			$dataAr[$k] = $v;
			if ($limit != "" and $limit == $k) {
				break;
			}
		}
		return $dataAr;
	}
	
	function cmHotelMinSelect($limit="") {
		$dataAr = array();
		$retAr = array();

		$retAr[1] = "00";
		$retAr[2] = "15";
		$retAr[3] = "30";
		$retAr[4] = "45";

		foreach ($retAr as $k=>$v) {
			$dataAr[$k] = $v;
			if ($limit != "" and $limit == $k) {
				break;
			}
		}
		return $dataAr;
	}
  
	function cmHotelMinSelect_inputPlan(){
		$dataAr = array();
		$retAr = array();
		
		for($i=0;$i<60;$i++){
			$retAr[$i] = $i>9?$i:'0'.$i;
		}
		
		foreach ($retAr as $k=>$v) {
			$dataAr[$k] = $v;
			if ($limit != "" and $limit == $k) {
				break;
			}
		}
		return $dataAr;
	}
	
	function cmHotelRoomType() {
		$retAr = array();
		$retAr[1] = "洋室シングル";
		$retAr[2] = "洋室セミダブル";
		$retAr[3] = "洋室ダブル";
		$retAr[4] = "洋室ツイン";
		$retAr[5] = "洋室トリプル";
		$retAr[6] = "洋室4ベッド";
		$retAr[7] = "洋室その他";
		$retAr[8] = "和室";
		$retAr[9] = "和洋室";
		$retAr[10] = "その他";
		return $retAr;
	}

	function cmHotelRoomFeature() {
		$retAr = array();
		$retAr[1] = "通常";
		$retAr[2] = "コーナールーム（角部屋）";
		$retAr[3] = "ジュニアスイート";
		$retAr[4] = "スイートルーム";
		$retAr[5] = "特別室";
		$retAr[6] = "コテージ";
		$retAr[7] = "客室以外（日帰り専用）（単独選択）";
		return $retAr;
	}
	function cmHotelRoomFeature2() {
		$retAr = array();
		$retAr[1] = "バス";
		$retAr[2] = "トイレ";
		$retAr[3] = "シャワーのみ（複数選択可）";
		return $retAr;
	}
	function cmHotelRoomFeature3() {
		$retAr = array();
		$retAr[1] = "禁煙";
		$retAr[2] = "喫煙";
		$retAr[3] = "ネット接続OK";
		$retAr[4] = "高層階";
		$retAr[5] = "海が見える";
		$retAr[6] = "夜景が見える";
		$retAr[7] = "バス・トイレ別";
		$retAr[8] = "洗浄機付きトイレ";
		$retAr[] = "ジャグジー";
		return $retAr;
	}


// 	function cmHotelRoomData() {
// 		$retAr = array();

// 		$retAr[1]["name"] = "部屋総数";
// 		$retAr[1]["data"] = "number";
// 		$retAr[1]["length"] = "3";
// 		$retAr[1]["val"][] = array("1"=>"a", "2"=>"b");

// 		return $retAr;
// 	}


	function cmHotelChild1() {
		$retAr = array();
		$retAr[1] = "ベビーベッド";
		$retAr[2] = "ベビーベッド（要予約）";
		$retAr[3] = "ベッドガード";
		$retAr[4] = "ベッドガード（要予約）";
		$retAr[5] = "ベビーカー（要予約）";
		$retAr[6] = "ベビーチェア";
		$retAr[7] = "食器";
		$retAr[8] = "踏み台";
		$retAr[9] = "シャンプーハット";
		$retAr[10] = "お風呂用チェア";
		$retAr[11] = "ベビーソープ";
		$retAr[12] = "補助便座";
		$retAr[13] = "砂遊びセット";
		$retAr[14] = "絵本";
		$retAr[15] = "アームヘルパー（プール用）";
		$retAr[16] = "その他";
		return $retAr;
	}
	function cmHotelChild2() {
		$retAr = array();
		$retAr[1] = "お子様用パジャマ";
		$retAr[2] = "お子様用スリッパ";
		$retAr[3] = "お子様用歯磨きセット";
		$retAr[4] = "その他";
		return $retAr;
	}
	function cmHotelChild3() {
		$retAr = array();
		$retAr[1] = "紙おむつ";
		$retAr[2] = "水遊びパンツ";
		$retAr[3] = "粉ミルク";
		$retAr[4] = "おしりふき";
		$retAr[5] = "ベビーフード";
		$retAr[6] = "おやつ";
		$retAr[7] = "その他";
		return $retAr;
	}
	function cmHotelChild4() {
		$retAr = array();
		$retAr[1] = "離乳食ご用意可能（無料）";
		$retAr[2] = "離乳食ご用意可能（無料・要予約）";
		$retAr[3] = "離乳食ご用意可能（有料）";
		$retAr[4] = "離乳食ご用意可能（有料・要予約）";
		$retAr[5] = "お子様メニューあり";
		$retAr[6] = "アレルギー対応可能（要予約）";
		$retAr[7] = "ミルク用の白湯ご用意";
		$retAr[8] = "その他";
		return $retAr;
	}

	function cmHotelStay() {
		$retAr = array();
		$retAr[1] = "朝刊サービス";
		$retAr[2] = "夕刊サービス";
		$retAr[3] = "屋内プール利用無料";
		$retAr[4] = "屋外プール利用無料";
		$retAr[5] = "大浴場利用無料";
		$retAr[6] = "温泉施設利用無料";
		$retAr[7] = "バレーパーキング";
		$retAr[8] = "女性にアメニティプレゼント";
		$retAr[9] = "ウェルカムドリンクサービス";
		$retAr[10] = "その他（複数記入できるようにする）";
		return $retAr;
	}

	function cmHotelDisabled() {
		$retAr = array();
		$retAr[1] = "車椅子利用可";
		$retAr[2] = "車椅子貸出あり（要予約）";
		$retAr[3] = "車椅子対応のバリアフリールームあり（要予約）";
		$retAr[4] = "館内に車椅子対応トイレあり";
		$retAr[5] = "手話対応可能";
		$retAr[6] = "筆談対応可能";
		$retAr[7] = "点字案内あり";
		$retAr[8] = "点字ブロック誘導あり";
		$retAr[9] = "バリアフリートイレあり";
		$retAr[10] = "バリアフリールームあり（要予約）";
		$retAr[11] = "お部屋の浴室に手すりあり";
		$retAr[12] = "お部屋のトイレに手すりあり";
		$retAr[13] = "高齢者用料理のご用意可能（要予約）";
		$retAr[14] = "アレルギーメニュー対応可能（要予約）";
		$retAr[15] = "大浴場内に手すりあり";
		return $retAr;
	}

	function cmHotelCard() {
		$retAr = array();
		$retAr[1] = "VISA";
		$retAr[2] = "JCB";
		$retAr[3] = "American Express";
		$retAr[4] = "Diner's Club";
		$retAr[5] = "UC";
		$retAr[6] = "DC";
		$retAr[7] = "NICOS";
		$retAr[8] = "OMC";
		$retAr[9] = "Bank Card";
		$retAr[10] = "UFJ Card";
		$retAr[11] = "Master Card";
		$retAr[12] = "Discover";
		$retAr[13] = "Saison";
		$retAr[14] = "AEON";
		$retAr[15] = "JACCS";
		$retAr[16] = "APLUS";
		$retAr[17] = "CF";
		$retAr[18] = "LIFE";
		$retAr[19] = "ORICO";
		$retAr[20] = "TOP";
		$retAr[21] = "View";
		$retAr[22] = "West";
		$retAr[23] = "JTB";
		$retAr[24] = "Daimaru";
		$retAr[25] = "Takashimaya";
		$retAr[26] = "楽天カード";
		$retAr[27] = "ANA";
		$retAr[28] = "JAS";
		$retAr[29] = "JAL";
		$retAr[30] = "MEDIA";
		$retAr[31] = "デビットカード";
		return $retAr;
	}


	function cmBookingAge() {
		$retAr = array();
		$retAr[1] = "20代";
		$retAr[2] = "30代";
		$retAr[3] = "40代";
		$retAr[4] = "50代";
		$retAr[5] = "60代";
		$retAr[6] = "70代";
		$retAr[7] = "80代";
		return $retAr;
	}

	function cmWorkId() {
		$retAr = array();
		$retAr[1] = "IT関連";
		$retAr[2] = "営業";
		return $retAr;
	}

	function cmMeal($flg=false) {
		$retAr = array();
		if ($flg) {
			$retAr[""] = "指定しない";
			$retAr[1] = "食事なし";
		}
		$retAr[2] = "朝食あり";
		$retAr[3] = "夕食あり";
		$retAr[4] = "昼食あり";
		return $retAr;
	}

	function cmBudget($flg) {
		$retAr = array();
		if ($flg == 1) {
			$retAr[""] = "下限なし";
		}
		for ($i=5000; $i<=10000; $i+=1000) {
			$retAr[$i] = "￥".number_format($i);
		}
		for ($i=12000; $i<=20000; $i+=2000) {
			$retAr[$i] = "￥".number_format($i);
		}
		for ($i=30000; $i<=50000; $i+=10000) {
			$retAr[$i] = "￥".number_format($i);
		}
		if ($flg == 2) {
			$retAr[""] = "上限なし";
		}
		return $retAr;
	}


	function cmSetHotelSearchDef($collection) {
		if ($collection->getByKey($collection->getKeyValue(), "search_date") == "") {
			$collection->setByKey($collection->getKeyValue(), "search_date", date("Y年m月d日"));
		}
		if ($collection->getByKey($collection->getKeyValue(), "undecide_sch") == "") {
			$collection->setByKey($collection->getKeyValue(), "undecide_sch", 2);
		}
		if ($collection->getByKey($collection->getKeyValue(), "night_number") == "") {
			$collection->setByKey($collection->getKeyValue(), "night_number", 1);
		}
		if ($collection->getByKey($collection->getKeyValue(), "room_number") == "") {
			$collection->setByKey($collection->getKeyValue(), "room_number", 1);
		}
		for ($roomNum=1; $roomNum<=SITE_ROOM_NUM; $roomNum++) {

			if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == "") {
				if ($roomNum == 1) {
					$collection->setByKey($collection->getKeyValue(), "adult_number".$roomNum, 2);
				}
				else {
					$collection->setByKey($collection->getKeyValue(), "adult_number".$roomNum, 0);
				}
			}

			for ($j=1; $j<=6; $j++) {
				if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$j) == "") {
					$collection->setByKey($collection->getKeyValue(), "child_number".$roomNum.$j, 0);
				}
			}
		}


		//	部屋別の人数が違うか
		if ($collection->getByKey($collection->getKeyValue(), "room_number") > 1)  {

			$collection->setByKey($collection->getKeyValue(), "room_difference", true);

			for ($roomNum=2; $roomNum<=$collection->getByKey($collection->getKeyValue(), "room_number"); $roomNum++) {

				if ($collection->getByKey($collection->getKeyValue(), "adult_number1") != $collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum)) {
					$collection->setByKey($collection->getKeyValue(), "room_difference", false);
					break;
				}

				for ($j=1; $j<=6; $j++) {
					if ($collection->getByKey($collection->getKeyValue(), "child_number1".$j) != $collection->getByKey($collection->getKeyValue(), "child_number".$roomNum.$j)) {
						$collection->setByKey($collection->getKeyValue(), "room_difference", false);
						break;
					}
				}
			}
		}
		else {
			$collection->setByKey($collection->getKeyValue(), "room_difference", true);
		}
	}



	function obj2arr($obj)
	{
		if ( !is_object($obj) ) return $obj;

		$arr = (array) $obj;

		foreach ( $arr as &$a )
		{
			$a = obj2arr($a);
		}

		return $arr;
	}

?>
