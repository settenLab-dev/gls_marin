<?php
   $ip=$_SERVER["REMOTE_ADDR"];
   $logfilename=dirname(__FILE__).'/iplog10.txt';
   $fp=fopen($logfilename,"a");
   fwrite($fp,$ip);
   fwrite($fp,"  ".$_SERVER['HTTP_USER_AGENT']);
   fwrite($fp,"  ".strftime('%c')."\r\n");
   fclose($fp);	

   $filename="header1.png";
   $file = @fopen($filename, "r");
   echo @fread($file, @filesize($filename));
   @fclose($file);
   exit;
?>
