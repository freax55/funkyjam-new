$(document).ready(function(){
	/*ニュースの流れる記事*/
	var speed = 2000;
	var stop = 2000;
	var wrapp = $("#hotNews ul");
	var items = wrapp.find("li");
	var width = wrapp.width();
	var width = 500;
	var height = wrapp.css("height");
	var max = items.size();
	var now= -1;
	var oldNow = 0;
	var slide_speed = 1000;
	
	wrapp.css({"width":width, "height":height,"position":"relative","whiteSpace":"nowrap","overflow":"hidden"});
	items.css({"position":"absolute" ,"left":width});
	view(items.eq(0));

	function view(){
		now++;
		$(items.eq(now)).animate({"left": "-="+width}, speed,null,dilay);
	}

	function dilay(){
		setTimeout(unView,stop);
	}
	
	function unView(){
		oldNow = now;
		$(items.eq(oldNow)).animate({"left": "-="+width}, speed,null,reset);

		if(now+1 == max)
			now = -1;
		view();
	}
	function reset(){
		$(items.eq(oldNow)).css({"left":width});
	}
	
	/*eyecatch対応*/
	$('#kubotaBar a').live('mouseover', function() {
		if($("#uraBar:animated").size() == 0 || $("#moriBar:animated").size() == 0 || $("#uraBlock:animated").size() == 0 || $("#moriBlock:animated").size() == 0){
			$(".bar:animated").clearQueue();
			$(".block:animated").clearQueue();
			$('.bar a').contents().unwrap();
			/*aタグを消す*/
			$('#uraBar img').wrapAll('<a href="javascript:void(0)"></a>');
			$('#moriBar img').wrapAll('<a href="javascript:void(0)"></a>');
			/*バーを動かす*/
			$("#uraBar").animate({"left": "589px"},{easing:"easeInQuart",duration:slide_speed});
			$("#moriBar").animate({"left": "629px"},{easing:"easeInQuart",duration:slide_speed});
			/*ブロックを表示する*/
			$("#kubotaBlock").animate(
	    		{width: "show", opacity: "toggle"},
	    		{easing:"easeInQuart",duration:slide_speed}
	  		);
			$('#uraBlock').hide();
			$('#moriBlock').hide();
		}
	});
	$('#uraBar a').live('mouseover', function() {
		if($("#kubotaBar:animated").size() == 0 || $("#moriBar:animated").size() == 0 || $("#kuboBlock:animated").size() == 0 || $("#moriBlock:animated").size() == 0){											  
			$(".bar:animated").clearQueue();
			$(".block:animated").clearQueue();
			$('.bar a').contents().unwrap();
			$('#kubotaBar img').wrapAll('<a href="javascript:void(0)"></a>');
			$('#moriBar img').wrapAll('<a href="javascript:void(0)"></a>');
			$("#uraBar").animate({"left": "35px"},{easing:"easeInQuart",duration:slide_speed});
			$("#moriBar").animate({"left": "629px"},{easing:"easeInQuart",duration:slide_speed});
			$('#kubotaBlock').hide();
			$("#uraBlock").animate(
				{width: "show", opacity: "toggle"},
				{easing:"easeInQuart",duration:slide_speed}
			);
			$('#moriBlock').hide();
		}		
	});
	$('#moriBar a').live('mouseover', function() {
		if($("#kubotaBar:animated").size() == 0 || $("#uraBar:animated").size() == 0 || $("#kuboBlock:animated").size() == 0 || $("#uraBlock:animated").size() == 0){
			$(".bar:animated").clearQueue();
			$(".block:animated").clearQueue();
			$('.bar a').contents().unwrap();
			$('#kubotaBar img').wrapAll('<a href="javascript:void(0)"></a>');
			$('#uraBar img').wrapAll('<a href="javascript:void(0)"></a>');
			$("#uraBar").animate({"left": "35px"},{easing:"easeInQuart",duration:slide_speed});
			$("#moriBar").animate({"left": "75px"},{easing:"easeInQuart",duration:slide_speed});
			$('#kubotaBlock').hide();
			$('#uraBlock').hide();
			$("#moriBlock").animate(
	    		{width: "show", opacity: "toggle"},
	    		{easing:"easeInQuart",duration:slide_speed}
	  		);
		}
	});	
});