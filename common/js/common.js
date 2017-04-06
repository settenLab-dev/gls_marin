$('.circle').corner();

$(document).ready(function() {

	if ($("#tabMenu li") != null) {

  //Get all the LI from the #tabMenu UL
  $('#tabMenu li').click(function(){

    //perform the actions when it's not selected
    if (!$(this).hasClass('selected')) {

	    //remove the selected class from all LI
	    $('#tabMenu li').removeClass('selected');

	    //Reassign the LI
	    $(this).addClass('selected');

	    //Hide all the DIV in .boxBody
	    $('.boxBody div.parent').slideUp('1500');

	    //Look for the right DIV in boxBody according to the Navigation UL index, therefore, the arrangement is very important.
	    $('.boxBody div.parent:eq(' + $('#tabMenu > li').index(this) + ')').slideDown('1500');

	 }

  }).mouseover(function() {

    //Add and remove class, Personally I dont think this is the right way to do it, anyone please suggest
    $(this).addClass('mouseover');
    $(this).removeClass('mouseout');

  }).mouseout(function() {

    //Add and remove class
    $(this).addClass('mouseout');
    $(this).removeClass('mouseover');

  });

	//Mouseover with animate Effect for Category menu list
  $('.boxBody #category li').click(function(){

    //Get the Anchor tag href under the LI
    window.location = $(this).children().attr('href');
  }).mouseover(function() {

    //Change background color and animate the padding
    $(this).css('backgroundColor','#888');
    $(this).children().animate({paddingLeft:"20px"}, {queue:false, duration:300});
  }).mouseout(function() {

    //Change background color and animate the padding
    $(this).css('backgroundColor','');
    $(this).children().animate({paddingLeft:"0"}, {queue:false, duration:300});
  });

	//Mouseover effect for Posts, Comments, Famous Posts and Random Posts menu list.
//  $('#.boxBody li').click(function(){
//    window.location = $(this).children().attr('href');
//  }).mouseover(function() {
//    $(this).css('backgroundColor','#888');
//  }).mouseout(function() {
//    $(this).css('backgroundColor','');
//  });

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

$(document).ready( function () {
	if ($('.blank') != null) {
    $('.blank').click(function(){
        window.open(this.href, '_blank');
        return false;
    });
	}
});

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

function openWin(url,windowname,width,height) {
	var features="location=no, menubar=no, status=yes, scrollbars=yes, resizable=yes, toolbar=no";
	if (width) {
		if (window.screen.width > width)
			features+=", left="+(window.screen.width-width)/2;
		else width=window.screen.width;
		features+=", width="+width;
	}
	if (height) {
		if (window.screen.height > height)
			features+=", top="+(window.screen.height-height)/2;
		else height=window.screen.height;
		features+=", height="+height;
	}
	var win = window.open(url, "Slaker", features);
	win.focus();
}


//	public logout submit
function logout() {
	document.frmLogout.submit();
}


/**********************************************************************************************************************
 *	テーブル操作
 **********************************************************************************************************************/
function addRow(targetTable, targetItem, name, sort) {
	var table = document.getElementById(targetTable);
	var count = table.rows.length-1;
	var insData = document.getElementById(targetItem).value;
	var insRow = 1;
	var row, cell1, cell2;

	if (insData == "") {
		$().toastmessage( 'showToast', {
			inEffectDuration:500,
			text:"データを入力して下さい。",
			type:"error",
			sticky: false,
			position:"middle-center"
		});
		return;
	}

	if (count > 0) {
		for (var i=1; i<=count; i++) {
			if (insData == table.rows[i].cells[0].firstChild.nodeValue) {
				$().toastmessage( 'showToast', {
					inEffectDuration:500,
					text:"既に登録済みです。",
					type:"error",
					sticky: false,
					position:"middle-center"
				});
				return;
			}
			if (sort == 1) {
				if (insData > table.rows[i].cells[0].firstChild.nodeValue) {
					insRow++;
					continue;
				}
			}
			else {
				insRow++;
			}
		}
	}

	row = table.insertRow(insRow);
	cell1 = row.insertCell(0);
	cell2 = row.insertCell(1);
	var HTML1 = ''+insData+'<input type="hidden" name="' + name + '['+ insData + ']" value="'+insData+'" />';
	var HTML2 = '<input id="" name="" value="削除" onclick="removeRow(this)" type="button" class="circle">';
	cell1.innerHTML = HTML1;
	cell2.innerHTML = HTML2;

	document.getElementById(targetItem).value = "";

	$('.circle').corner();
}

function removeRow(o){
	var tr = o.parentNode.parentNode;
	tr.parentNode.deleteRow(tr.sectionRowIndex);
}

/**********************************************************************************************************************
 *	Select連動
 **********************************************************************************************************************/
$(document).ready(function(){
	//	地方エリア
	if ($(".linkRegion") != null) {
		$(".linkRegion").change(function () {
			if ($(".linkRegion").val() != "") {
				$.ajax({
					url:"xml/pref.xml",
					dataType:"xml",
					error: function(){
						$().toastmessage( 'showToast', {
							inEffectDuration:500,
							text:"都道府県XMLの読み込みに失敗しました。",
							type:"error",
							sticky: false,
							position:"middle-center"
						});
					},
					success: function (list) {
						var cval = $(".linkPref").val();
						$('.linkPref').find('option').remove().end().append('<option value="">---</option>');
						var optionItems = new Array();
						$(list).find("data").each(function(i){
							if ($(this).find("region").text() == $(".linkRegion").val()) {
//								if ($(this).find("status").text() == 1) {
									optionItems.push('<option value="' + $(this).find("value").text() + '">' + $(this).find("name").text() + '</option>');
//								}
							}
						});
						$(".linkPref").append(optionItems.join());
						$(".linkPref").val(cval);
					}
				});
			}
			else {
				$('.linkPref').find('option').remove().end().append('<option value="">---</option>');
			}
		}).trigger('change');
	}
	//	都道府県
	if ($(".linkPref") != null) {
		$(".linkPref").change(function () {
			if ($(".linkPref").val() != "") {
				$.ajax({
					url:"xml/city.xml",
					dataType:"xml",
					error: function(){
						$().toastmessage( 'showToast', {
							inEffectDuration:500,
							text:"市区町村XMLの読み込みに失敗しました。",
							type:"error",
							sticky: false,
							position:"middle-center"
						});
					},
					success: function (list) {
						var cval = $(".linkCity").val();
						$('.linkCity').find('option').remove().end().append('<option value="">---</option>');
						var optionItems = new Array();
						$(list).find("data").each(function(i){
							if ($(this).find("pref").text() == $(".linkPref").val()) {
//								if ($(this).find("status").text() == 1) {
									optionItems.push('<option value="' + $(this).find("value").text() + '">' + $(this).find("name").text() + '</option>');
//								}
							}
						});
						$(".linkCity").append(optionItems.join());
						$(".linkCity").val(cval);
					}
				});
			}
			else {
				$('.linkCity').find('option').remove().end().append('<option value="">---</option>');
			}
		}).trigger('change');
	}
	/*
	//	市区町村
	if ($(".linkCity") != null) {
		$(".linkCity").change(function () {
			if ($(".linkCity").val() != "") {
				$.ajax({
					url:"xml/town.xml",
					dataType:"xml",
					error: function(){
						$().toastmessage( 'showToast', {
							inEffectDuration:500,
							text:"タウンエリアXMLの読み込みに失敗しました。",
							type:"error",
							sticky: false,
							position:"middle-center"
						});
					},
					success: function (list) {
						var cval = $(".linkTown").val();
						$('.linkTown').find('option').remove().end().append('<option value="">---</option>');
						var optionItems = new Array();
						$(list).find("data").each(function(i){
							if ($(this).find("city").text() == $(".linkCity").val()) {
								if ($(this).find("status").text() == 1) {
									optionItems.push('<option value="' + $(this).find("value").text() + '">' + $(this).find("name").text() + '</option>');
								}
							}
						});
						$(".linkTown").append(optionItems.join());
						$(".linkTown").val(cval);
					}
				});
			}
			else {
				$('.linkTown').find('option').remove().end().append('<option value="">---</option>');
			}
		}).trigger('change');
	}
	*/

});

/**********************************************************************************************************************
 *	popup
 **********************************************************************************************************************/
var profilesShopAdd =
{
	windowCallUnload:
	{
		height:600,
		width:550,
		scrollbars:1,
		center:1,
		createnew:1,
		onUnload:unloadcallback
	},
};

function unloadcallback() {
	document.frmSearch.submit();
};

$(function() {
	if ($(".popShopAdd") != null) {
		$(".popShopAdd").popupwindow(profilesShopAdd);
	}
});

$(document).ready(function(){
	//	画像切替
	if ($('.thumbnail') != null ) {
	$('.thumbnail').hover(function(){
		$(this).fadeTo(200,0.5);
	},function() {
		$(this).fadeTo(200,1);
	});

	$('.thumbnail').click(function(){
		var src = $("img",this).attr("src");

		$('#shopImage .thumbnail').removeClass('currentimage');
	    $(this).addClass('currentimage');

		$("#targetImage").fadeOut("slow",function() {
			$(this).attr("src",src);
			$(this).fadeIn();
		});
		return false;
	});
	}

	if ($('.clicker') != null ) {
		$('.clicker').click(function(){
			var anc = $(".imgWrap a",this).attr("href");
//			alert(anc);
			document.location = ""+anc;
		});
	}
});
