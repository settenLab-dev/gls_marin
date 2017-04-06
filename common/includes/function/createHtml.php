<?php

	/**************************************************************
	 * create_error_caption
	 * @return
	 * @param $errMsg Object
	 **************************************************************/
	function create_error_caption($errMsgs) {
		$out = "";
		$log = "";
		if (count($errMsgs) > 0) {
			if (!cmCheckMobile()) {
				$out .= '<div class="errorCaption">';
				$out .= '<p>以下の点をご確認下さい。</p>';
				$out .= '</div>';

				if (count($errMsgs[SITE_ERROR_HEAD]) > 0) {
					$out .= '<div class="errorFirst">';
					$out .= '<ul>';
					foreach ($errMsgs[SITE_ERROR_HEAD] as $msg) {
						$out .= '<li><p>'.$msg.'</p></li>';
						$log .= $msg." ";
					}
					$out .= '</ul>';
					$out .= '</div>';
					//	ログに残す
					cmLogOutput("ERROR", "[firstError]".$log);
				}
			}
			else {
				$out .= '<div>';
				$out .= '<font size="-1" color="#ff0000"><img src="assets/emoji/F9DC.gif" />以下の点をご確認下さい。</font><br />';
				$out .= '</div>';

				if (count($errMsgs[SITE_ERROR_HEAD]) > 0) {
					$out .= '<div>';
					foreach ($errMsgs[SITE_ERROR_HEAD] as $msg) {
						$out .= '<font size="-1" color="#ff0000">・'.$msg.'</font><br />';
						$log .= $msg." ";
					}
					$out .= '</div>';
					//	ログに残す
					cmLogOutput("ERROR", "[firstError]".$log);
				}
			}
		}
		return $out;
	}
	function create_error_msg($errMsg) {
		if ($errMsg != "") {
			if (!cmCheckMobile()) {
				$out .= '<div class="error">';
				$out .= '<p>'.$errMsg.'</p>';
				$out .= '</div>';
				return $out;
			}
			else {
				$out .= '<div align="left">';
				$out .= '<font size="-1" color="#ff0000"><img src="assets/emoji/F9DC.gif" />'.$errMsg.'</font><br />';
				$out .= '</div>';
				return $out;
			}
		}
	}


	/**************************************************************
	 * data type neme
	 * @return
	 * @param
	 **************************************************************/
	function create_style_class($data) {
		if ($data != "") {
			return "<br /><p>[".$data."]</p>";
		}
		return;
	}
	/**************************************************************
	 * sub name
	 * @return
	 * @param
	 **************************************************************/
	function create_sub_name($data) {
		if ($data != "") {
			return "(".$data.")";
		}
		return $data;
	}
	/**************************************************************
	 * size
	 * @return
	 * @param
	 **************************************************************/
	function create_width_height($item) {
		if ($item["SHOP_ITEM_WIDTH"] != "" and  $item["SHOP_ITEM_WIDTH"] != "" and  $item["SHOP_ITEM_WIDTH"] != "" and  $item["SHOP_ITEM_WIDTH"] != "") {
			//return $item["SHOP_ITEM_WIDTH"].":".$item["SHOP_ITEM_HEIGHT"]."(".$item["SHOP_ITEM_WIDTH_MOBILE"].":".$item["SHOP_ITEM_HTIGHT_MOBILE"].")";
		}

		$h = "";
		if ($item["SHOP_ITEM_HEIGHT"] != "" ) {
			$h = ":".$item["SHOP_ITEM_HEIGHT"];
		}

		$mH = "";
		if ($item["SHOP_ITEM_HEIGHT"] != "" ) {
			$mH = ":".$item["SHOP_ITEM_HTIGHT_MOBILE"];
		}
		return $item["SHOP_ITEM_WIDTH"].$h."(".$item["SHOP_ITEM_WIDTH_MOBILE"].$mH.")";
	}
	/**************************************************************
	 * required
	 * @return
	 * @param
	 **************************************************************/
	function create_required($data) {
		if ($data == 2) {
			return '<span class="colorEnji">※</span>';
		}
		return;
	}
?>
