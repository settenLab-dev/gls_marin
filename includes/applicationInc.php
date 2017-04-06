<?php

	//	master
	require_once('/var/www/vhosts/playbooking.jp/httpdocs/common/config.php');

	//	ini
	ini_set('session.name','mottookinawapublic');
	ini_set('session.save_path',PATH_SESSION_SLKAER_PUBLIC);

	//	ログファイル区分
	define('LOG_DIVIDE', "public");

?>
