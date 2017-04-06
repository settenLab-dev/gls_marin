//現在の時間
var startTime;
//終了時間の配列
var endTime = new Array();
//終了時に表示するテキストの配列
var endText = new Array();
//現在時間と表示時間の差の配列
var timeDifference = new Array();
//日差の配列
var d = new Array();
//時差の配列
var h = new Array();
//分差の配列
var m = new Array();	
//秒差の配列
var s = new Array();
//カウントダウンする要素の数
var n;
//カウントダウンする時間
var countTime = 1000;

$(function() {
	n = $('.TimerEnd').length-1;
	if(n >= 0){	
		setData();
		countDown();
	}
});

function countDown() {
	startTime = startTime+countTime;		
	for(i=0; i<=n;i++){
		timeDifference[i] = endTime[i]-startTime;
		d[i] = Math.floor((timeDifference[i])/(24*60*60*1000))
		h[i] = Math.floor(((timeDifference[i])%(24*60*60*1000))/(60*60*1000))
		m[i] = Math.floor(((timeDifference[i])%(24*60*60*1000))/(60*1000))%60
		s[i] = Math.floor(((timeDifference[i])%(24*60*60*1000))/1000)%60%60
		
		if(timeDifference[i] >= 0){
			if(d[i]!=0){
				$(".TimeView:eq("+i+")").text(d[i]+'日'+h[i]+'時間'+m[i]+'分'+s[i]+'秒');	
			}else{
				if(h[i]!=0){
					$(".TimeView:eq("+i+")").text(h[i]+'時間'+m[i]+'分'+s[i]+'秒');		
				}else{
					if(m[i]!=0){
						$(".TimeView:eq("+i+")").text(m[i]+'分'+s[i]+'秒');
					}else{	
						if(s[i]>0){
							$(".TimeView:eq("+i+")").text(s[i]+'秒');
						}else{
							$(".TimeView:eq("+i+")").text(endText[i]);
						}
					}
				}
			}			
		}
		//$(".TimeView:eq("+i+")").text(d[i]+'日'+h[i]+'時間'+m[i]+'分'+s[i]+'秒');		
	}
	setTimeout('countDown()',countTime);
}

function setData(){
	now = $('#TimerStart').val();
	if(now == ""){
		startTime = new Date().getTime();	
	}else{
		startTime = new Date(now).getTime();	
	}

	for(i=0; i<=n;i++){
		$('.TimerEnd:eq('+i+')').val();
		endTime[i] = new Date($('.TimerEnd:eq('+i+')').val()).getTime();	
		endText[i] = $('.TimerEndText:eq('+i+')').val();
		timeDifference[i] = 0;	
		d[i] = 0;
		h[i] = 0;
		m[i] = 0;
		s[i] = 0;
	}
}

