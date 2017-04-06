<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');

$companyInput = new company($dbMaster);
$companyInput->setPost();

if ($companyInput->getByKey($companyInput->getKeyValue(), "login")) {
	//	入力チェック
	$companyInput->checkLogin();
	if ($companyInput->getErrorCount() <= 0) {
			$company = new company($dbMaster);
			$company->selectLogin($companyInput);

			if ($company->getCount() > 0) {
				//	session set
				$_SESSION = array();
				$sess->setSessionList($sess->getSessionLogninKey(), $company->getCollectionByKey($company->getKeyValue()));

				//	cookie set
				if($companyInput->getByKey($companyInput->getKeyValue(), "loginAuto") == "auto") {
					$sess->setCookieData($companyInput->getByKey($companyInput->getKeyValue(),"COMPANY_LOGIN_ID"), $companyInput->getByKey($companyInput->getKeyValue(),"COMPANY_LOGIN_PASSWORD"), SITE_COOKIE_SAVE_TIME);
				}
			}
			else {
				$companyInput->setErrorFirst("ログインIDもしくはパスワードが間違っています");
			}
	}
}
elseif ($companyInput->getByKey($companyInput->getKeyValue(), "logout")) {
 	$sess->destroy();
 }
else {
	$company = new company($dbMaster);
	$company->selectLoginCookie();

	if ($company->getCount() > 0) {
		$sess->destroy();
		$sess->setSessionList($sess->getSessionLogninKey(), $company->getCollectionByKey($company->getKeyValue()));
		$sess->setCookieData($_COOKIE[SITE_COOKIE_SHOP_ID], $_COOKIE[SITE_COOKIE_SHOP_PASS], SITE_COOKIE_SAVE_TIME);
	}
}
?>