function ChangeStyleBtn(i,p) {
var ciBtn;
var cpBtn;
ciBtn = i;
cpBtn = p;
document.images[ciBtn].src = cpBtn;
}
if(sv == "") {//null
	var ua = navigator.userAgent;
	if( ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) || ( ua.indexOf('windows') > 0 && ua.indexOf('phone') > 0) || ( ua.indexOf('firefox') > 0 && ua.indexOf('mobile') > 0) ) {//sp
		document.write('<ul class="change_ua"><li class="link"><a href="javascript:void(0)" onclick="ChangeStylesheet(0); return false;">PC</a></li>');
		document.write('<li> / <span class="dlk">Mobile</span></li></ul>');
	} else {//pc
		document.write('<ul class="change_ua"><li><span class="dlk">PC</span></li>');
		document.write('<li class="link"> / <a href="javascript:void(0)" onclick="ChangeStylesheet(2); return false;"><span>Mobile</span></a></li></ul>');
	}
} else if(sv == 0) {//pc
		document.write('<ul class="change_ua"><li><span class="dlk">PC</span></li>');
		document.write('<li class="link"> / <a href="javascript:void(0)" onclick="ChangeStylesheet(2); return false;"><span>Mobile</span></a></li></ul>');
} else if(sv == 2) {//sp
		document.write('<ul class="change_ua"><li class="link"><a href="javascript:void(0)" onclick="ChangeStylesheet(0); return false;">PC</a></li>');
		document.write('<li> / <span class="dlk">Mobile</span></li></ul>');
}