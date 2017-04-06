<?php

	//	INI SET
	ini_set('session.auto_start','0');
	ini_set('session.gc_probability','1');
	ini_set('session.gc_divisor','100');
	ini_set('session.gc_maxlifetime','10800');
	ini_set('session.serialize_handler','php');
	ini_set('session.cookie_lifetime','0');
	ini_set('session.cookie_path','/');
	ini_set('session.cookie_domain','');
	ini_set('session.cookie_secure','');
	ini_set('session.use_cookies','1');
	ini_set('session.use_only_cookies','1');
	ini_set('session.use_trans_sid','0');
	ini_set('session.referer_check','');
	ini_set('session.entropy_file','');
	ini_set('session.entropy_length','0');
	ini_set('session.cache_expire','180');
	ini_set('session.hash_function','1');
	ini_set('register_globals','Off');
	ini_Set('expose_php','Off');
	ini_set('magic_quotes_gpc','Off');
	ini_set('url_rewriter.tags','a=href,area=href,frame=src,input=src,form=fakeentry');
	ini_Set('display_errors','Off');
	ini_set('session.cache_limiter','none');
	error_reporting(0);

	//	DataBase
	define('DB_SLAKER_USERNAME', 'db_test');
	define('DB_SLAKER_PASSWORD', 'gateside_test10');
	define('DB_SLAKER_HOST', 'localhost');
	define('DB_SLAKER_DATABASE', 'db_test');
	define('DB_LANGUAGE', 'Japanese');
	define('DB_ENCODING', 'Shift_JIS');
	define('DB_OUTPUT', 'Shift_JIS');
	define('DB_SETNAMES', 'SET NAMES utf8');

	//	Site Config
	define('SLAKER_UPLOAD_IMAGES','jpg、gif、bmp、png');
	define('SLAKER_UPLOAD_IMAGE_SIZE', 1024);
	define('SLAKER_TAX', 5);

	//	Cookie Admin
	define('SITE_COOKIE_ADMIN_ID','mottookinawaadminid');
	define('SITE_COOKIE_ADMIN_PASS','mottookinawaadminpass');
	//	Cookie Shop
	define('SITE_COOKIE_SHOP_ID','mottookinawashopid');
	define('SITE_COOKIE_SHOP_PASS','mottookinawashoppass');
	//	Cookie Public
	define('SITE_COOKIE_PUBLIC_ID','mottookinawapublicid');
	define('SITE_COOKIE_PUBLIC_PASS','mottookinawapublicpass');
	//	Cookie Save Time
	define('SITE_COOKIE_SAVE_TIME', 2592000);
	//	Cookie Affiliate
	define('SITE_COOKIE_AFFILIATE','mottookinawacdata');

	//	Google key  取得後変更する
	define('SITE_GOOGLE_SHOP','AIzaSyBITfIf8OD58W4vF_UigrSW1xNyitvwZNY');
	define('SITE_GOOGLE_ADMIN','AIzaSyCIaTjfqIXVcbiiusjcoLm94n8cnpf_6-I');

	define('SITE_SLAKER_ENCRYPTION', 'motto okinawa manage your dreams');
	define('SITE_SLAKER_NAME', 'PlayBooking Management System');
	define('SITE_PUBLIC_NAME', '全国のレジャー予約！PlayBooking（仮）');
	define('SITE_PUBLIC_KEYWORD', '');
	define('SITE_PUBLIC_DESCRIPTION', 'サイト説明文を表示します');
	define('SITE_DIRECTIV', '/');
	define('SITE_COUPON_NUM', 3);

//リンカーンようなので不要。関連記述除去後に削除
	define('SITE_TL_ID', "N4931522");
	define('SITE_TL_PASS', "USz~I9JY");

	//	人数MAX
	define('SITE_STAY_NUM', 999);
	define('SITE_ROOM_NUM', 10);
	define('SITE_ADULT_NUM', 999);
	define('SITE_CHILD_NUM', 999);

	//	Path Slaker
	define('PATH_SLAKER', '/var/www/vhosts/playbooking.jp/httpdocs/');
	define('PATH_SLAKER_COMMON', PATH_SLAKER.'common/');
	define('PATH_SLAKER_ADMIN', PATH_SLAKER.'admin/');
	define('PATH_SLAKER_SHOP', PATH_SLAKER.'shop/');
	define('PATH_SLAKER_PUBLIC', PATH_SLAKER.'');
	define('PATH_SLAKER_MOBILE', PATH_SLAKER.'m/');
	define('PATH_SLAKER_SPHONE', PATH_SLAKER.'s/');
	define('PATH_SLAKER_XML', PATH_SLAKER_COMMON.'xml/');
// 	define('PATH_SLAKER_XML_ADMIN', PATH_SLAKER_ADMIN.'xml/');
// 	define('PATH_SLAKER_XML_SHOP', PATH_SLAKER_SHOP.'xml/');
// 	define('PATH_SLAKER_XML_PUBLIC', PATH_SLAKER_PUBLIC.'xml/');
// 	define('PATH_SLAKER_XML_MOBILE', PATH_SLAKER_MOBILE.'xml/');
// 	define('PATH_SLAKER_XML_SPHONE', PATH_SLAKER_SPHONE.'xml/');
	define('PATH_SESSION_SLKAER_ADMIN', PATH_SLAKER_COMMON.'sess/admin');
	define('PATH_SESSION_SLKAER_SHOP', PATH_SLAKER_COMMON.'sess/shop');
	define('PATH_SESSION_SLKAER_PUBLIC', PATH_SLAKER_COMMON.'sess/public');

	//	Image size
	//	gourmet list
	define('IMG_GOURMET_LIST_WIDTH', 800);
	define('IMG_GOURMET_LIST_HEIGHT', 600);
	define('IMG_GOURMET_LIST_SIZE', 1000000);
	//	gourmet detail
	define('IMG_GOURMET_DETAIL_WIDTH', 800);
	define('IMG_GOURMET_DETAIL_HEIGHT', 600);
	define('IMG_GOURMET_DETAIL_SIZE', 1000000);
	//	activity list
	define('IMG_ACTIVITY_LIST_WIDTH', 800);
	define('IMG_ACTIVITY_LIST_HEIGHT', 600);
	define('IMG_ACTIVITY_LIST_SIZE', 1000000);
	//	activity detail
	define('IMG_ACTIVITY_DETAIL_WIDTH', 800);
	define('IMG_ACTIVITY_DETAIL_HEIGHT', 600);
	define('IMG_ACTIVITY_DETAIL_SIZE', 1000000);
	//	hotel app
	define('IMG_HOTEL_APP_WIDTH', 800);
	define('IMG_HOTEL_APP_HEIGHT', 600);
	define('IMG_HOTEL_APP_SIZE', 1000000);
	//	hotel fac
	define('IMG_HOTEL_FAC_WIDTH', 800);
	define('IMG_HOTEL_FAC_HEIGHT', 600);
	define('IMG_HOTEL_FAC_SIZE', 1000000);
	//	affiiate
	define('IMG_AFFILIATE_WIDTH', 234);
	define('IMG_AFFILIATE_HEIGHT', 60);
	define('IMG_AFFILIATE_SIZE', 1000000);
	//	recommend
	define('IMG_RECOMMEND_WIDTH', 225);
	define('IMG_RECOMMEND_HEIGHT', 65);
	define('IMG_RECOMMEND_SIZE', 10000);


	//	メールアドレス
	define('MAIL_SLAKER_INFO','info@playbooking.jp');
	define('MAIL_SLAKER_NOREPLY','no-reply@playbooking.jp');
	define('MAIL_SLAKER_HOTEL','yoyaku@playbooking.jp');
	
//Pleskパネル上で設定のためコメントアウト
//	ini_set('include_path', PATH_SLAKER_COMMON.'includes/lib:.:/usr/share/pear:/usr/share/php');
//print_r(	ini_set('include_path', PATH_SLAKER_COMMON.'includes/lib:.:/usr/share/pear:/usr/share/php'));

	//	URL Slaker
	define('SLAKER_DOMAIN','playbooking.jp/');
	define('URL_SLAKER_COMMON', 'http://common.'.SLAKER_DOMAIN."");
	define('URL_SLAKER_ADMIN', 'http://admin.'.SLAKER_DOMAIN."");
	define('URL_SLAKER_SHOP', 'http://shop.'.SLAKER_DOMAIN."");
	define('URL_SLAKER_BATCH', 'http://batch.'.SLAKER_DOMAIN."");
	define('URL_PUBLIC', 'http://'.SLAKER_DOMAIN);
	define('URL_PUBLIC_SSL', 'https://'.SLAKER_DOMAIN);
	define('URL_PUBLIC_TEST', 'http://'.SLAKER_DOMAIN);
	define('URL_PUBLIC_LINK', 'https://www.tl-lincoln.net/accomodation/accomodation_image');

	//	Check Puttern
	define('CHK_PTN_KANA','/^[ァ-ヶー]+$/u');
	define('CHK_PTN_MAILADDRESS','/^[a-zA-Z0-9\_\-\.]+@[a-zA-Z0-9\_\-\.]+\.[a-zA-Z0-9]+$/');
	define('CHK_PTN_LOGIN_ID','/^[a-z0-9\_\-]+$/');
	define('CHK_PTN_LOGIN_PASSWORD','/^[a-zA-Z0-9]+$/');
	define('CHK_PTN_ZIPCODE_JP','/^\d{3}\-\d{4}$/');
	define('CHK_PTN_ZIPCODE_CN','/^\d{6}$/');
	define('CHK_PTN_TEL','/^\d{2,4}-\d{2,4}-\d{3,4}$/');
	define('CHK_PTN_CENTURY','/^20|19\d{2}$/');
	define('CHK_PTN_MONTH','/^\d{1,2}$/');
	define('CHK_PTN_DAY','/^\d{1,2}$/');
	define('CHK_PTN_FLG','/^1|2$/');
	define('CHK_PTN_NUM','/^\d*$/');
	define('CHK_PTN_PERCENT','/^(\d|\.)+$/');
	define('CHK_PTN_WORD','/^[a-zA-Z]*$/');
	define('CHK_PTN_WORDNUM','/^[0-9a-zA-Z]*$/');
	define('CHK_PTN_FILE','/^[0-9a-zA-Z]*\.[0-9a-zA-Z]*$/');
	define('CHK_PTN_KEYCODE','/^[0-9a-zA-Z\_\-]*$/');
	define('CHK_PTN_URL','/^(http|https):\/\/.+$/');
	define('CHK_PTN_DATE','/^\d{4}\-\d{1,2}\-\d{1,2}$/');
	define('CHK_PTN_TIME','/^\d{2}\:\d{2}$/');

	//	System Words
	define('WORDS_CONFIRM', "_confrim");
	define('WORDS_INPUT', "_input");
	define('WORDS_OLD', "_old");

	//	Function
	require_once(PATH_SLAKER_COMMON.'includes/function/commonfunction.php');
	require_once(PATH_SLAKER_COMMON.'includes/function/createHtml.php');

	//	Class
	require_once(PATH_SLAKER_COMMON.'includes/class/db.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/dbMaster.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/collection.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/inputs.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/session.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/xml.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/messages.php');

	//	XML　ここら辺は入れ替えする
	define('XML_GOURMET_CATEGORY', "gourmet_category.xml");
	define('XML_GOURMET_CATEGORY_DETAIL', "gourmet_category_detail.xml");
	define('XML_ACTIVITY_CATEGORY', "activity_category.xml");
	define('XML_ACTIVITY_CATEGORY_DETAIL', "activity_category_detail.xml");
	define('XML_FEATURE', "feature.xml");
	define('XML_FEATURE_A', "feature_a.xml");
	define('XML_FEATURE_H', "feature_h.xml");
	define('XML_AREA', "area.xml");
	define('XML_AFFILIATE_CATEGORY', "affiliate_category.xml");
	define('XML_AFFILIATE_CATEGORY_DETAIL', "affiliate_category_detail.xml");
	define('XML_RECOM_CATEGORY', "recom_category.xml");
	define('XML_RECOM_CATEGORY_A', "recom_category_a.xml");
	define('XML_RECOM_CATEGORY_H', "recom_category_h.xml");

	//	ログファイル保存先
	define('LOG4PHP_DIR', PATH_SLAKER_COMMON.'includes/lib/log4php/');
	define('LOG4PHP_CONFIGURATION', PATH_SLAKER_COMMON.'log4php.properties');
	require_once(LOG4PHP_DIR.'LoggerManager.php');
?>
