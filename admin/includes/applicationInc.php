<?php

	//	master
	require_once('../common/config.php');

	//	ini
	ini_set('session.name','mottookinawaadmin');
	ini_set('session.save_path',PATH_SESSION_SLKAER_ADMIN);

	//	ログファイル区分
	define('LOG_DIVIDE', "admin");

?>
