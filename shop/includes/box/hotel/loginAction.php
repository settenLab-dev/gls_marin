<?php
require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

$memberInput = new member($dbMaster);
$memberInput->setPost();

//print_r($memberInput);


if ($memberInput->getByKey($memberInput->getKeyValue(), "login")) {
	//	入力チェック
	$memberInput->checkLogin();
	if ($memberInput->getErrorCount() <= 0) {
			$member = new member($dbMaster);
			$member->selectLogin($memberInput);


			if ($member->getCount() > 0) {
				//	session set
				$_SESSION = array();
				$sess->setSessionList($sess->getSessionLogninKey(), $member->getCollectionByKey($member->getKeyValue()));

				//	cookie set
				if($memberInput->getByKey($memberInput->getKeyValue(), "loginAuto") == "auto") {
					$sess->setCookieData($memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_ID"), $memberInput->getByKey($memberInput->getKeyValue(),"MEMBER_LOGIN_PASSWORD"), SITE_COOKIE_SAVE_TIME);
				}
			}
			else {
				$memberInput->setErrorFirst("ログインIDもしくはパスワードが間違っています");
			}
	}
}
elseif ($memberInput->getByKey($memberInput->getKeyValue(), "logout")) {
 	$sess->destroy();
 }
else {
	$member = new member($dbMaster);
	$member->selectLoginCookie();

	if ($member->getCount() > 0) {
		$sess->destroy();
		$sess->setSessionList($sess->getSessionLogninKey(), $member->getCollectionByKey($member->getKeyValue()));
		$sess->setCookieData($_COOKIE[SITE_COOKIE_PUBLIC_ID], $_COOKIE[SITE_COOKIE_PUBLIC_PASS], SITE_COOKIE_SAVE_TIME);
	}
}
?>