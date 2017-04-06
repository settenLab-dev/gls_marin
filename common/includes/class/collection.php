<?php

/*******************************************************************************
 * collection
 *******************************************************************************/
class collection {
	public $db;
	private $collection;
	private $count;
	private $maxCount;

	private $keyValue;
	private $errors;

	public function collection($db) {
		$this->db = $db;
	}

	//	collection
	public function getCollection() {
		return $this->collection;
	}
	public function setCollection($sql, $key="",$max=false, $keyNothing=false) {
		$this->collection = array();
		$this->keyValue = "";
		//	SQL Execute
		$result = $this->db->execute($sql);

		if (mysql_affected_rows() > 0) {
			//	count set
			$this->count = mysql_num_rows($result);

			while ($row = mysql_fetch_assoc($result)) {
				if ($keyNothing) {
					$this->collection[] = $row;
				}
				else {
					$this->collection[$row[$key]] = $row;
					$this->keyValue = $row[$key];
				}
			}
		}
		else {
			$this->count = 0;
		}
	}
	public function setCollectionWithArray($sql,$key="") {
		$this->collection = array();
		$this->keyValue = "";
		//	SQL Execute
		$result = $this->db->execute($sql);

		if (mysql_affected_rows() > 0) {
			//	count set
			$this->count = mysql_num_rows($result);

			while ($row = mysql_fetch_assoc($result)) {
				if ($row["M_SHOP_MENU_TYPE"] == 2) {
					//	パターンリピート
					$this->collection[$row[$key]][$row["SHOP_DATA_GROUP"]] = $row;
				}
				else {
					$this->collection[$row[$key]] = $row;
					$this->keyValue = $row[$key];
				}
			}
		}
		else {
			$this->count = 0;
		}
	}
	public function getCollectionByKey($keyval) {
		return $this->collection[$keyval];
	}
	public function setCollectionByKey($key, $val) {
		$this->collection[$key] = $val;
	}

	//	value
//	public function getByKey($key,$col,$xss=true) {
	public function getByKey($key,$col) {
		return $this->collection[$key][$col];
//		if ($xss) {
//			return redirectForXss($this->collection[$key][$col]);
//		}
//		else {
//			return $this->collection[$key][$col];
//		}
	}
	public function setByKey($key,$col,$val) {
//		$this->collection[$key][$col] = redirectForXss($val);
		$this->collection[$key][$col] = ($val);
	}
	public function setByKeyArray($key, $col, $key2="", $val) {
//		$this->collection[$key][$col][$key2] = redirectForXss($val);
		$this->collection[$key][$col][$key2] = ($val);
	}
	public function getKeyValue() {
		return $this->keyValue;
	}
	public function setKeyValue($val) {
		$this->keyValue = $val;
	}

	//	count
	public function getCount() {
		return $this->count;
	}
	public function setCount($val) {
		$this->count = $val;
	}
	public function getCountByKey($keyval) {
		return count($this->collection[$keyval]);
	}

	//	expression
	public function expsData($target, $operate, $val, $str=false, $enc=0) {

		//	暗号化時で、かつLIKEを使用する場合
		if ($enc == 4 and $operate == "like") {
			return "aes_decrypt(".$target.",'".SITE_SLAKER_ENCRYPTION."') ".$operate." '".$val."'";
		}

		return $target." ".$operate." ".$this->expsVal($val, $str, $enc);
	}
	public function expsCols($targetLeft, $targetRight, $operate) {
		return $targetLeft." ".$operate." ".$targetRight;
	}
	public function expsVal($val, $str=false, $enc=0) {
		$val = redirectForSi($val);
		if ($str) {
			$val =  $this->encryption("'".$val."'", $enc);
		}
		else {
			$val = $val==""?'null':$val;
			$val = $this->encryption($val, $enc);
		}
		return $val;
	}

	//	Encryption
	public function encryption($val, $enc=0) {
		switch ($enc) {
			case 0:
				return $val;
				break;
			case 1:
				return "aes_encrypt(".$val.",'". SITE_SLAKER_ENCRYPTION."')";
				break;
			case 2:
				return "aes_decrypt(".$val.",'". SITE_SLAKER_ENCRYPTION."')";
				break;
			case 3:
				//	for search
				return "aes_decrypt(".$val.",'". SITE_SLAKER_ENCRYPTION."') ".$val;
				break;
			case 4:
				//	like befor
				return "aes_decrypt(".$val.",'". SITE_SLAKER_ENCRYPTION."')";
				break;
		}
	}
	//	Decrypttion List
	public function decryptionList($target) {
		$ret = "";
		$list = explode(",", $target);
		foreach ($list as $val) {
			if ($ret != "") {
				$ret .= ",";
			}
			$ret .= $this->encryption(trim($val), 3);
		}
		return $ret;
	}

	public function select($tableName,$keyName,$keyVal="") {
		$sql  = "select * from ";
		$sql .= "".$tableName." ";
		if ($keyVal != "") {
			$sql .= "where ";
			$sql .= $this->expsData($keyName,"=",$keyVal,true);
		}
		$this->setCollection($sql,$keyName);
	}

	public function saveDivide($keyVal) {
//		if ($this->getKeyValue() == "") {
		if ($keyVal == "") {
			//	insert
			return true;
		}
		else {
			//	update
			return false;
		}
	}

	public function setMaxCount() {
		$sql = "SELECT FOUND_ROWS();";
		$result = $this->db->execute($sql);
		if (mysql_affected_rows() > 0) {
			while($row = mysql_fetch_array($result)) {
				$this->maxCount = $row["FOUND_ROWS()"];
			}
		}
		else {
			$this->maxCount = 0;
		}
	}
	public function getMaxCount() {
		return $this->maxCount;
	}
	public function saveExec($sql) {
		$result = $this->db->execute($sql);

		if (!$result) {
			return false;
		}
		return true;
	}

	//	POST Data Set
	public function setPost() {
		if ($_POST) {
			foreach ($_POST as $k=>$v) {
				$this->setByKey($this->getKeyValue(), $k, $v);
			}
		}
	}

	//	Error
	public function setErrorFirst($msg) {
		$this->errors[SITE_ERROR_HEAD][] = $msg;
	}
	public function setError($target,$msg) {
		$this->errors[$target] = $msg;
	}
	public function getError() {
		return $this->errors;
	}
	public function getErrorByKey($errorKey) {
		return $this->errors[$errorKey];
	}
	public function getErrorCount() {
		return count($this->errors);
	}

	//	save
	public function save() {
		$dataList = $this->getCollectionByKey($this->getKeyValue());
		$sql = "";
		if ($this->saveDivide($this->getKeyValue())) {
			$sql = $this->insert($dataList);
		}
		else {
			$sql = $this->update($dataList);
		}
		return $this->saveExec($sql);
	}

	public function insert($dataList) {
		return "";
	}
	public function update($dataList) {
		return "";
	}

	public function lastInsert($tablename) {
		$sql  = "select last_insert_id() id from ".$tablename.";";
		$this->setCollection($sql, "id");
	}

}
?>
