<?php
class mailcreate {

	private $from;
	private $to;
	private $subject;
	private $contents;

	private $shopData;
	private $price;

	//	constractor
	public function mailcreate() {
	}

	//	送信者
	public function setFrom($from) {
		$this->from = $from;
	}
	public function getFrom() {
		return $this->from;
	}

	//	宛先
	public function setTo($to) {
		$this->to = $to;
	}
	public function getTo() {
		return $this->to;
	}

	//	タイトル
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	public function getSubject() {
		return $this->subject;
	}

	//	メール内容
	public function setContents($contents, $flgAdd=false) {
		if ($flgAdd) {
			$this->contents .= $contents;
		}
		else {
			$this->contents = $contents;
		}
	}
	public function getContents() {
		return $this->contents;
	}
	public function replace($target, $data) {
		$this->contents = str_replace($target, $data, $this->contents);
	}


	//	WEB請求書企業データ
	public function setShopData($shopId, $shopName, $contractName, $money="", $flgAdd=false) {
		$data  = "";
		if ($shopName == "") {
			$data .= "【店舗名】設定されていません。\n";
		}
		else {
			$data .= "【店舗名】".$shopName."\n";
		}
		$data .= "・店舗ID\n".str_pad($shopId, 8, "0", STR_PAD_LEFT)."\n";
		$data .= "・契約プラン\n".$contractName."\n";
		if ($money != "") {
			$data .= "・ご利用料金\n".number_format($money)."円\n";
		}
		$data .= "\n";

		if ($flgAdd) {
			$this->shopData .= $data;
		}
		else {
			$this->shopData = $data;
		}
	}
	public function getShopData() {
		return $this->shopData;
	}

	//	合計金額
	public function setPrice($price, $flgAdd=false) {
		if ($flgAdd) {
			$this->price += $price;
		}
		else {
			$this->price = $price;
		}
	}
	public function getPrice() {
		return $this->price;
	}

	//	送信
	public function send($mail_queue) {
		if (!cmMailSendQueue($mail_queue, $this->from, $this->to, $this->subject, $this->contents)) {
			return false;
		}
		else {
			return true;
		}
	}
}

class mailcreateAgent extends mailcreate {

	private $shopData;

	public function mailcreateAgent() {
		parent::mailcreate();
	}

	//	WEB請求書企業データ
	public function setShopData($shopId, $shopName, $contractName, $money="", $moneyAgent="", $flgAdd=false) {
		$data  = "";
		if ($shopName == "") {
			$data .= "【店舗名】設定されていません。\n";
		}
		else {
			$data .= "【店舗名】".$shopName."\n";
		}
		$data .= "・店舗ID\n".str_pad($shopId, 8, "0", STR_PAD_LEFT)."\n";
		$data .= "・契約プラン\n".$contractName."\n";
		if ($money != "") {
			$data .= "・ご請求金額\n".number_format($money-$moneyAgent)."円\n";
			$data .= "（店舗料金：".number_format($money)."円）\n";
		}
		$data .= "\n";
		if ($flgAdd) {
			$this->shopData .= $data;
		}
		else {
			$this->shopData = $data;
		}
//print "-----------------".$this->shopData;
	}
public function getShopData() {
		return $this->shopData;
	}
}
?>