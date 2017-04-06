<?php
class xml {
	private $xml;
	private $dom;
	public $fileName;

	public function xml($fileName) {
		$this->fileName = $fileName;
	}

	public function create($itemList) {
		$this->setDom();
		$cnt = 0;
		$dataList = $this->dom->appendChild($this->dom->createElement('dataList'));
		foreach ($itemList as $item) {
			$data = $dataList->appendChild($this->dom->createElement('data'));

			foreach ($item as $k=>$v) {
				$name = "";
				$name = $data->appendChild($this->dom->createElement($k));
				$name->appendChild($this->dom->createTextNode($v));
			}
		}
		if (!$this->dom->save(PATH_SLAKER_XML.$this->fileName)) {
			return false;
		}
// 		if (!$this->dom->save(PATH_SLAKER_XML_ADMIN.$this->fileName)) {
// 			return false;
// 		}
// 		if (!$this->dom->save(PATH_SLAKER_XML_SHOP.$this->fileName)) {
// 			return false;
// 		}
// 		if (!$this->dom->save(PATH_SLAKER_XML_PUBLIC.$this->fileName)) {
// 			return false;
// 		}
// 		if (!$this->dom->save(PATH_SLAKER_XML_MOBILE.$this->fileName)) {
// 			return false;
// 		}
// 		if (!$this->dom->save(PATH_SLAKER_XML_SPHONE.$this->fileName)) {
// 			return false;
// 		}

		return true;
	}

	public function setDom() {
		$this->dom =  new DomDocument('1.0');
		$this->dom->encoding = "UTF-8";
		$this->dom->formatOutput = true;
	}
	public  function getDom() {
		return $this->dom;
	}

	public function load() {
		$this->xml = simplexml_load_file(PATH_SLAKER_XML.$this->fileName);
	}

	public function getXml() {
		if (!$this->xml) {
			return false;
		}
		return $this->xml;
	}

	public function getXmlByParentKey($target, $selected) {
		if (!$this->xml) {
			return false;
		}

		return $this->xml->xpath('data['.$target.'="'.$selected.'"]');
	}
	public function getXmlByParentKey2($target, $selected, $target2, $selected2, $ext="") {
		if (!$this->xml) {
			return false;
		}

		if ($ext == "") {
			return $this->xml->xpath('data['.$target.'="'.$selected.'" and '.$target2.'="'.$selected2.'"]');
		}
		else {
			return $this->xml->xpath('data['.$target.'='.$selected.' '.$ext.' '.$target2.'="'.$selected2.'"]');
		}
	}

	public function getCount() {
		return count($this->xml);
	}

	public function getNameByValue($val) {
		foreach ($this->xml as $x) {
			if ($x->value == $val) {
				return $x->name;
			}
		}
		return;
	}

	public function getByKey($Key, $target) {
		foreach ($this->xml as $x) {
			if ($x->value == $Key) {
				return $x->$target;
			}
		}
		return;
	}

	public function getFirstData() {
		foreach ($this->xml as $x) {
			return $x;
		}
	}

}

class xmlShop extends xml {
	private $xml;
	private $dom;
	public $fileName;

	public function xmlShop($fileName) {
		parent::xml($fileName);
	}

	public function create($itemList) {
		$this->setDom();
		$cnt = 0;
		$dataList = $this->dom->appendChild($this->dom->createElement('dataList'));
		foreach ($itemList as $item) {
			$data = $dataList->appendChild($this->dom->createElement('data'));

			foreach ($item as $k=>$v) {
				$name = "";
				$name = $data->appendChild($this->dom->createElement($k));
				$name->appendChild($this->dom->createTextNode($v));
			}
		}
		if (!$this->dom->save(PATH_SLAKER_XML_SHOP.$this->fileName)) {
			return false;
		}

		return true;
	}

	public function getXmlByParentKey($target, $selected) {
		if (!$this->xml) {
			return false;
		}

		return $this->xml->xpath('data['.$target.'="'.$selected.'"]');
	}

	public function setDom() {
		$this->dom =  new DomDocument('1.0');
		$this->dom->encoding = "UTF-8";
		$this->dom->formatOutput = true;
	}
	public function load() {
		$this->xml = simplexml_load_file(PATH_SLAKER_XML_SHOP.$this->fileName);
	}

	public function getXml() {
		if (!$this->xml) {
			return false;
		}
		return $this->xml;
	}
}



//	店舗アカウント内でXMLを設定する場合に使用する
class xmlSettings extends xml {
	private $xml;
	private $dom;
	public $fileName;

	public function xmlSettings($fileName) {
		parent::xml($fileName);
	}

	public function create($itemList) {
		$this->setDom();
		$cnt = 0;
		$dataList = $this->dom->appendChild($this->dom->createElement('dataList'));
		foreach ($itemList as $item) {
			$data = $dataList->appendChild($this->dom->createElement('data'));

			foreach ($item as $k=>$v) {
				$name = "";
				$name = $data->appendChild($this->dom->createElement($k));
				$name->appendChild($this->dom->createTextNode($v));
			}
		}
		if (!$this->dom->save(SITE_PATH."common/xml/".$this->fileName)) {
			return false;
		}

		return true;
	}

	public function getXmlByParentKey($target, $selected) {
		if (!$this->xml) {
			return false;
		}

		return $this->xml->xpath('data['.$target.'="'.$selected.'"]');
	}

	public function setDom() {
		$this->dom =  new DomDocument('1.0');
		$this->dom->encoding = "UTF-8";
		$this->dom->formatOutput = true;
	}
	public function load() {
		$this->xml = simplexml_load_file(SITE_PATH."common/xml/".$this->fileName);
	}

	public function getXml() {
		if (!$this->xml) {
			return false;
		}
		return $this->xml;
	}
}
?>