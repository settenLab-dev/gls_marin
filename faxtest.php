<?php
require_once('includes/applicationInc.php');
print "aa";
require_once(PATH_SLAKER_COMMON.'includes/class/sendfax.php');
ini_Set('display_errors','On');

$body = "テスト\nてすと";

$sendfax = new sendfax("05014097102", $body);
if (!$sendfax->send()) {
	print "失敗";
}
else {
	print "成功";
}
?>