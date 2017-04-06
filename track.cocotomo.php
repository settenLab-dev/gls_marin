<?php
require_once('../common/config.php');
// require_once('/home/mottookinawa/cocotomo.net/public_html/common/config.php');

// print "aa".$_COOKIE[SITE_COOKIE_AFFILIATE];
// print_r($_COOKIE);

header('Content-type: image/jpeg');
readfile(PATH_SLAKER_COMMON."assets/1px.jpg");

require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliateasp.php');
define('LOG_DIVIDE', "batch");
//	ログファイル保存先
define('LOG4PHP_DIR', PATH_SLAKER_COMMON.'includes/lib/log4php/');
define('LOG4PHP_CONFIGURATION', PATH_SLAKER.'common/log4php.properties');
require_once(LOG4PHP_DIR.'LoggerManager.php');


$dbMaster = new dbMaster();

$collection = new collection($dbMaster);
$collection->setByKey($collection->getKeyValue(), "AFFILIATEASP_IP", $_SERVER["REMOTE_ADDR"]);
$collection->setByKey($collection->getKeyValue(), "AFFILIATEASP_COOKIE", $_COOKIE[SITE_COOKIE_AFFILIATE]);
$collection->setByKey($collection->getKeyValue(), "AFFILIATEASP_STATUS1", 1);

$affiliateasp = new affiliateasp($dbMaster);
$affiliateasp->selectList($collection);

if ($affiliateasp->getCount() == 1) {
	if (!$affiliateasp->updateContract()) {
		$affiliateasp->setErrorFirst("アフィリエイトの成約設定に失敗しました。");
	}
}


?>
