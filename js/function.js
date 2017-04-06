$(function(){
	
	$('#background div:first-child').fadeIn('fast');
	
	var length = $('#indextop-back div').length;
	var count = 0;
	var speed = 2500;
	var wait = 35000
	
	setInterval(function(){ //index背景スライド実行
		if(count < length) {
			$('#indextop-back div:eq(' + count + ')').fadeIn(speed).prev().fadeOut(speed);
			count++;
		} else {
			$('#indextop-back div:eq(0)').fadeIn(speed);
			$('#indextop-back div:last-child').fadeOut(speed);
			count = 1;
		}
	},wait);
	
    $('a[href=#top]').click(function() {
        var speed = 500;
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $('body,html').animate({scrollTop:position}, 500, 'swing');
        return false;
    });
	
    $("input[type='checkbox']").change(function(){
        if($(this).is(":checked")){
            $(this).parent().addClass('checked');
        }else{
            $(this).parent().removeClass('checked');
        }
    });

	var radio = $('.radio-group');
	$('input', radio).each(function(){
		if ($(this).attr('checked') == 'checked') {
			$(this).next().addClass('checked');
		}
	});
	
	$('.radio', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('.radio',this).removeClass('checked');	
		});
		$(this).addClass('checked');
	});
	
	selectbox('.selectbox select', '.select-inner');

	$('ul#subimage li a').click(function() {
		return false;
	});
	$('ul#subimage li a').hover(function() {
		$('#mainimage img').attr('src',$(this).attr('href'));
	});

	$(".form input").focus(function(){
		if(this.value == this.defaultValue){
			$(this).css("color","#333").val('');
		}
	}).blur(function(){
		if($(this).val() == ''){
			$(this).css("color","#aaa").val(this.defaultValue);
		} else {
			$(this).css("color","#333");
		}
	});


	var imgoffset = $('#map').offset();
	var folder = 'images/front/';
	var onmouese = false;
	$('#maparea area').hover(function(e){
		$('.areabox').hide();
		var mapclass = $(this).attr('class');
		$('#map').attr('src', folder + 'index-' + mapclass + '.jpg');
		var position = e.pageX - imgoffset.left + 20;
		$('#' + mapclass).show().css('left', position + 'px');	
	},
	function() {
		var mapclass = $(this).attr('class');
		$('#' + mapclass).hide();
		$('#map').attr('src', folder + 'index-map-normal.jpg');
	});
	$('#maparea area').click(function() {
		return false;
	});
});

$(function(){
	if (window.PIE) {
		$('.radius5,.radius10,.radius30,.boxshadow1,.boxshabow2,.select-inner').each(function(){
			PIE.attach(this);
		});
	}
});

selectbox = function(select, obj){
	var set_selectbox = function(){
		var value = $(this).find('option:selected').html();
		$(this).siblings(obj).find('span').html(value);
	}
	$(select).each(set_selectbox).on('change', set_selectbox);
}

$(document).ready( function() {
	$('#searchafterList').hide();
		$(".close_bt a").click(function(){
		$('#searchafterList').slideToggle(800);
		$('#searchtable').slideToggle();
	});
});


$(document).ready(function(){
	$('.slideouter').bxSlider();
});