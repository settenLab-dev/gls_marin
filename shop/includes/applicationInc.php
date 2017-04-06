<?php

	//	master
	require_once('../common/config.php');

	//	ini
	ini_set('session.name','mottookinawashop');
	ini_set('session.save_path',PATH_SESSION_SLKAER_SHOP);

	//	ログファイル区分
	define('LOG_DIVIDE', "shop");

?>
