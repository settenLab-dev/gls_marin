<?php
class sendfax {

	const fromMailaddress = "yoyaku@glaspe.net";
	private $faxNumber;
	private $faxContents;


	public function sendfax($faxNumber, $faxContents) {
		$this->faxNumber = $faxNumber;
		$this->faxContents = $faxContents;
	}

	public function send() {

		mb_language('Japanese');
		mb_internal_encoding('utf-8');

		// 		$from = mb_convert_encoding($from,'UTF-8', 'EUC-JP');
		// 		$to = mb_convert_encoding($to,'UTF-8', 'EUC-JP');
		// 		$subject = mb_convert_encoding($subject,'UTF-8', 'EUC-JP');
		// 		$body = mb_convert_encoding($body,'UTF-8', 'EUC-JP');

		$header = "From: ".sendfax::fromMailaddress."\r\n";
		$to = $this->faxNumber."@cl1.faximo.jp";
		$subject = "予約FAX";

		$body = $this->faxContents;
		$body = mb_convert_kana($body,"KV");
		$subject = mb_convert_kana($subject,"KV");

// 		print $header;
		if (mb_send_mail($to, $subject, $body, $header)) {
			return true;
		}
		return false;

	}

}

?>