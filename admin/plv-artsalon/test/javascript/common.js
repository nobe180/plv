$(function(){
	//リンクホバー
	$('a').hover(function(){
		$(this).not('').stop(true).fadeTo(300, 0.5);
	},function(){
		$(this).fadeTo(300,1);
	});

	$('a:not(.no_exe)').click(function(){
		$('body').css({'opacity': 0});
		$('body').animate({'opacity': 1}, 'slow');
	});
	
	
	
	var W = $(window).width();
		$('.sp_detail').remove();
		if(W > 640) {// PC用コード
		
		}else{ // スマートフォン・タブレット用コード
			var H = $('#menu_bottom').offset().top;
			$('header img').eq(0).css({'height': H, 'animation': 'header_animation 60s ease 0s infinite'});
		}
});