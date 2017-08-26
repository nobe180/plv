$(function(){
	$('.news_data').on('click', function(){
		var obj = {};
		obj['id'] = $(this).attr('data');
		var W = $(window).width();

		if(W > 600) {// PC用コード
			$.post('php/news_data.php', obj, NewsModal, 'json');	
		}else{ // スマートフォン・タブレット用コード
			//$.post('php/function.php', obj, Aco, 'json');
		}
	});
	
	
	
	//PREV,NEXTのホバー
	$('#news_prev, #news_next, .news_list p:nth-child(3)').hover(function(){
		$(this).not('').stop(true, false).fadeTo(300,0.5);
	},function(){
		$(this).fadeTo(300,1);
	});
	
	
	
	var count = $('.news_list').length;
	var start_display = 5; //初期表示数
	for(var i = start_display; i < count; i++){
		$('.news_list').eq(i).stop(true, false).fadeOut();
	}

	now = start_display;
	hyoji  = start_display * 2;
	//NEXTを押した時の処理
	
	$('#news_next div').click(function(){
	
		for(var i = now; i >= 0; i--){
			$('.news_list').eq(i).stop(true, false).fadeOut();
		}
		for(var i = now; i < hyoji; i++){
			$('.news_list').eq(i).stop(true, false).fadeIn();
		}
		hyoji = hyoji + start_display;
		now = now + start_display;
		if(count < now){
			$('#news_next div').stop(true, false).fadeOut();
		}else{
			$('#news_prev div').stop(true, false).fadeIn();
			//$('#info_prev').fadeIn();
		}
	});
	
	$('#news_prev div').click(function(){
		for(var i = (now-5); i < hyoji; i++){
			$('.news_list').eq(i).stop(true, false).fadeOut(1000);
		}
		for(var i = (now-6); i >= (now-10); i--){
			$('.news_list').eq(i).stop(true, false).fadeIn(1000);
		}
		hyoji = hyoji - start_display;
		now = now - start_display;
		if(5 == now){
			$('#news_prev div').stop(true, false).fadeOut();
		}else{	
			$('#news_next div').stop(true, false).fadeIn();
		}
	});
});


function NewsModal(result){
	//alert(result[0]['company']);

	$('#news_modal .news_detail p:nth-of-type(1)').empty().append(result['data'][0]['date']);
	$('#news_modal .news_detail h2').empty().append('【'+result['data'][0]['title']+'】');
	$('#news_modal .news_detail p:nth-of-type(2)').empty().append(result['content']);

	var contentTxt = $('#news_modal').html();

	$('body').prepend('<div id="overlay"></div><div id="popupContents" class="clearfix">'+contentTxt+'</div>');

	$('#overlay').stop(true, false).fadeIn();
	var t=$(document).scrollTop()+150;
	$('#popupContents').css({'animation':'bigEntrance 1.6s ease-out 1', 'top':t+'px'});

	$('#modal_cancel, #closeImg').click(function(){
		NewsModalClose();
	});
}


function NewsModalClose(){
	$('#popupContents').css({'animation':'bigEntranceR 1.6s ease-out 1'});
	$('#overlay').stop(true, false).fadeOut(function(){
		$('#overlay, #popupContents, .sp_detail').remove();
		$('#news_modal news_detail p').empty();
		$('#news_modal news_detail h2').empty();
	}),300;
}

