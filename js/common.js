$(document).ready(function() {
	if ($('.blank') != null) {
	    $('.blank').click(function(){
	        window.open(this.href, '_blank');
	        return false;
	    });
	}
});

/**********************************************************************************************************************
 *	ロード中画像表示
 **********************************************************************************************************************/
function LoadingMsg(imgPath){
    if(self.attachEvent || self.addEventListener){
    	var wimg = new Image();
        var PTop = '35%';
        var msgs ='Now Loading...';
        wimg.src = imgPath;
        document.write('<div id="Loadouter" style="top:',PTop,';position: absolute; width:95%; z-index: 100; color:#9999cc; text-align:center;"><table bgColor="white" cellpadding="10" cellspacing="0" id="Loadinner" style="margin:auto; border:1px solid #dcdcdc; font-size: 13px; text-align:left;"><tr><td align="center">',msgs,'</td></tr><tr><td><img src="',wimg.src,'" border=0></td></tr></table></div>');
        function by(id){ if(document.getElementById){ return document.getElementById(id).style; }; if(document.all){ return document.all(id).style ; }}
        function addEv(obj, type, func){ if(obj.addEventListener){ obj.addEventListener(type, func, false); }else{ if(obj.attachEvent) obj.attachEvent('on' + type, func); }}
        addEv(window, 'load', function(){by('Loadouter').display = 'none';});
    }
}

jQuery(function(){
    jQuery(".transmit")
        .css({
            opacity: "0.5"
    });
});

jQuery.fn.rollover = function(settings){
  settings = jQuery.extend({
    suffix: "_o"
  }, settings);
  return this.each(function(){
    var default_img = $(this).attr("src");
    if (!default_img.match((settings.suffix))) {
      var point = default_img.lastIndexOf(".");
      var mouseover_img = default_img.slice(0, point) + settings.suffix + default_img.slice(point);
      var preload_img = new Image();
      preload_img.src = mouseover_img;
      $(this).hover(
        function(){
        	$(this).attr("src", mouseover_img);
        },
        function(){
        	if ($(this).attr("class") != "active") {
        		$(this).attr("src", default_img);
        	}
        	else {
        		$(this).attr("src", mouseover_img);
        	}
        }
      );
    };
  });
};

$(document).ready(function(){
  if ($(".overAction img") != null) {
	  $(".overAction img").rollover();
  }

  /*
  $('ul > li').hover(function(){
		$(this).fadeTo(200,0.5);
	},function() {
		$(this).fadeTo(200,1);
	});
	*/
});

//	public logout submit
function logout() {
	document.frmLogout.submit();
}

