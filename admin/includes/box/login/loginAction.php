<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');

$adminInput = new admin($dbMaster);
$adminInput->setPost();

if ($adminInput->getByKey($adminInput->getKeyValue(), "login")) {
	//	入力チェック
	$adminInput->checkLogin();

	if ($adminInput->getErrorCount() <= 0) {
			$admin = new admin($dbMaster);
			$admin->selectLogin($adminInput);

			if ($admin->getCount() > 0) {
				//	session set
				$_SESSION = array();
				$sess->setSessionList($sess->getSessionLogninKey(), $admin->getCollectionByKey($admin->getKeyValue()));

				//	cookie set
				if($adminInput->getByKey($adminInput->getKeyValue(), "loginAuto") == "auto") {
					$sess->setCookieData($adminInput->getByKey($adminInput->getKeyValue(),"ADMIN_LOGIN_ID"), $adminInput->getByKey($adminInput->getKeyValue(),"ADMIN_LOGIN_PASSWORD"), SITE_COOKIE_SAVE_TIME);
				}
			}
			else {
				$adminInput->setErrorFirst("ログインIDもしくはパスワードが間違っています");
			}
	}
}
elseif ($adminInput->getByKey($adminInput->getKeyValue(), "logout")) {
 	$sess->destroy();
 }
else {
	$admin = new admin($dbMaster);
	$admin->selectLoginCookie();

	if ($admin->getCount() > 0) {
		$sess->destroy();
		$sess->setSessionList($sess->getSessionLogninKey(), $admin->getCollectionByKey($admin->getKeyValue()));
		$sess->setCookieData($_COOKIE[SITE_COOKIE_ADMIN_ID], $_COOKIE[SITE_COOKIE_ADMIN_PASS], SITE_COOKIE_SAVE_TIME);
//		cmLocationChange("top.php");
	}
}
?>