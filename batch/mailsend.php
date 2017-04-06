#!/usr/bin/php5
<?php
//require_once('includes/applicationInc.php');
require_once('/var/www/vhosts/cocotomo.net/httpdocs/common/config.php');
// define('LOG_DIVIDE', "batch");

// //	ログファイル保存先
// define('LOG4PHP_DIR', PATH_SLAKER_COMMON.'includes/lib/log4php/');
// define('LOG4PHP_CONFIGURATION', PATH_SLAKER.'common/log4php.properties');
// require_once(LOG4PHP_DIR.'LoggerManager.php');

// require_once(PATH_SLAKER_COMMON.'includes/lib/Mail/Queue.php');

//	Mail Queue
// $db_options['type'] = 'mdb2';
// $db_options['dsn'] = 'mysql://mottookinawa_1:mottookinawa987@mysql711.xserver.jp/mottookinawa_2';
// $db_options['mail_table'] = "mail_queue_system";
// $mail_options['driver']    = 'smtp';
// $mail_options['host']      = 'localhost';
// $mail_options['port']      = 25;
// $mail_options['localhost'] = "mysql711.xserver.jp";
// $mail_options['auth']      = true;
// $mail_options['username']  = 'info@kokomo-oki.net';
// $mail_options['password'] = "kokomo987";
$db_options['type'] = 'mdb2';
$db_options['dsn'] = 'mysql://'.DB_SLAKER_USERNAME.':'.DB_SLAKER_PASSWORD.'@'.DB_SLAKER_HOST.'/'.DB_SLAKER_DATABASE;
$db_options['mail_table'] = "mail_queue_system";
$mail_options['driver']    = 'smtp';
$mail_options['host']      = 'localhost';
$mail_options['port']      = 25;
$mail_options['localhost'] = DB_SLAKER_HOST;
$mail_options['auth']      = true;
$mail_options['username']  = MAIL_SLAKER_INFO;
$mail_options['password'] = "5+edrepH";


$mail_queue = new Mail_Queue($db_options, $mail_options);
$mail_queue->setBufferSize(20);
$limit = 50;
$mail_queue->container->setOption($limit);

// print_r($mail_queue->get());
while ($mail = $mail_queue->get()) {
    $result = $mail_queue->sendMail($mail);

}
?>
