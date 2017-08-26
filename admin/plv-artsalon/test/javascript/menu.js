$(function(){
	var Height = $('header').outerHeight(true);

	$(window).scroll(function(){
		var sc = $(this).scrollTop();
		var top_ = parseInt($('nav').css('top'));
		
		if(Height < sc){
			if(top_ < 0){
				$('nav').stop(true, false).animate({'top': '0'});
				$('#page_top').stop(true, false).animate({'bottom': '0'});
			}
		}else{
			if(top_ > -1){
				$('nav').stop(true, false).animate({'top': '-7vw'});
				$('#page_top').stop(true, false).animate({'bottom': '-10vw'});
			}
		}
	});
	$('#page_top').click(function(){
		$('html,body').stop(true, false).animate({scrollTop:0},2000);
		return false;
	});
});



