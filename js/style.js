/*--cookie----------------------------------------------------------*/
name_style = "STYLE";
function  ChangeStylesheet(obj) {
	document.cookie = name_style+"="+obj+"; expires=Fri, 31-Dec-2030 23:59:59 GMT; path=/;";
	window.location.reload(true);
}
Cookie = document.cookie+";";
cSet1 = Cookie.indexOf(name_style);
if(cSet1 != -1) {
	cSet2 = Cookie.indexOf("=",cSet1);
	cSet3 = Cookie.indexOf(";",cSet2);
	sv = Cookie.substring(cSet2+1, cSet3);
} else {
	sv = 0;
}
/*------------------------------------------------------------------*/
if(sv == "") {//null
	var ua = navigator.userAgent;
	if( ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) || ( ua.indexOf('windows') > 0 && ua.indexOf('phone') > 0) || ( ua.indexOf('firefox') > 0 && ua.indexOf('mobile') > 0) ) {//sp
		document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=10.0, user-scalable=yes">');
		document.write('<link rel="stylesheet" href="/css/style_sp.css">');
		document.write('<?php $ua_flg = 2;?>');
	} else {//pc
		document.write('<link rel="stylesheet" href="/css/style201505.css">');
		document.write('<link rel="stylesheet" href="/css/detail.css">');
		document.write('<?php $ua_flg = 1;?>');
	}
} else if(sv == 0) {//pc
		document.write('<link rel="stylesheet" href="/css/style201505.css">');
		document.write('<link rel="stylesheet" href="/css/detail.css">');
		document.write('<?php $ua_flg = 1;?>');
} else if(sv == 2) {//sp
		document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=10.0, user-scalable=yes">');
		document.write('<link rel="stylesheet" href="/css/style_sp.css">');
		document.write('<?php $ua_flg = 2;?>');
}