$(document).ready(function(){	
	$(window).resize(function() {
		var innerWidth2; // 화면 width 값
		
		innerWidth2 = $(window).innerWidth();
		// 모바일 메뉴 노출 상태에서 화면이 커졌을 경우 헤더 메뉴 정상 노출을 위해 적용
		if(innerWidth2 > 768) {
			$("body").css("overflow",'');
			$(".snb").removeClass("open").css("left",""); 
		}
	});	

	$(".xo-navbar-sub-toggle").on('click', function(e){
		if($('.snb').hasClass("open")){
			
			$(".snb").animate({ 
				left: "-255px"
			}, 300, function() {
				$("body").css("overflow",'');
				$(".snb").removeClass("open").css("left","");   
			});		
		}else{
			$('.snb').addClass("open");
			$(".snb").addClass("open");
			$("body").css("overflow",'hidden');
			$(".snb").animate({ 
				left: "0px"
			}, 300);		
			
			$(".dim").on('click', function(){
			$(".snb").animate({ 
			left: "-255px"
			}, 300, function() {
			$(".snb").removeClass("open").css("left","");   
			$("body").css("overflow",'');
			});							
			$(this).off('click');
			});							
			e.stopPropagation();		
		}
	});	
})