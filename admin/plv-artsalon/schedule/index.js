$(function(){
	$('.on').on('click', function(){
		var obj = {};
		obj['id'] = $('.target_id', this).text();
		var W = $(window).width();
		$('.sp_detail').remove();
		$(this).parent().append('<div class="sp_detail"></div>');
		var ua = navigator.userAgent;
		if(W > 600) {// PC用コード
			$.post('function.php', obj, Modal, 'json');	
		}else{ // スマートフォン・タブレット用コード
			$.post('function.php', obj, Aco, 'json');
		}
	});
});


function Modal(result){
	//alert(result[0]['company']);
	var commaNum = result['data'][0]['price'].toString().replace(/(\d)(?=(\d\d\d)+$)/g , '$1,');//3桁区切り

	var date_ = result['data'][0]['date_'].replace('-', '<span class="size"> 年 </span>');
	date_ = date_.replace('-', '<span class="size"> 月 </span>')+'<span class="size"> 日（'+result['day']+'）</span>';

	var array = [
					'<h3>'+result['data'][0]['title']+'</h3>',
					'<span class="date_">'+date_+'</span><br />'+result['data'][0]['time_'],
					result['data'][0]['price_']
				];
	$('.schduleModal .live_image img').attr('src', 'http://plv-artsalon.com/schedule_data/images/no_image.png');
	if(result['data'][0]['image'] != ''){
		$('.schduleModal .live_image img').attr('src', 'http://plv-artsalon.com/schedule_data/upload_file/'+result['data'][0]['image']);
	}

	$('#modal table td').each(function(i){
		$('#modal table td').eq(i).append(array[i]);
	});


	var memo = '<div class="memo">'+result['memo']+'</div>';

	var contentTxt = $('#modal').html();
	$('body').prepend('<div id="overlay"></div><div id="popupContents" class="clearfix">'+contentTxt+memo+'</div>');

	$('#overlay').fadeIn();
	var t=$(document).scrollTop()+150;
	$('#popupContents').css({'animation':'bigEntrance 1.6s ease-out 1', 'top':t+'px'});

	$('#modal_cancel, #closeImg').click(function(){
		ModalClose();
	});
}


function ModalClose(){
	$('#popupContents').css({'animation':'bigEntranceR 1.6s ease-out 1'});
	$('#overlay').fadeOut(function(){
		$('#overlay, #popupContents, .sp_detail').remove();
		$('#modal table td').empty();
	}),300;
}







function Aco(result){
	var commaNum = result['data'][0]['price'].toString().replace(/(\d)(?=(\d\d\d)+$)/g , '$1,');//3桁区切り

	var date_ = result['data'][0]['date_'].replace('-', '<span class="size"> 年 </span>');
	date_ = date_.replace('-', '<span class="size"> 月 </span>')+'<span class="size"> 日（'+result['day']+'）</span>';

	var array = [
					'<h3>'+result['data'][0]['title']+'</h3>',
					'<span class="date_">'+date_+'</span><br />'+result['data'][0]['time_'],
					result['data'][0]['price_']
				];
	$('.schduleModal .live_image img').attr('src', '/test/schedule/images/no_image.png');
	if(result['data'][0]['image'] != ''){
		$('.schduleModal .live_image img').attr('src', '/test/schedule/upload_file/'+result['data'][0]['image']);
	}
	var contentTxt = $('#modal').html();
	$('.sp_detail').append(contentTxt);

	$('.sp_detail table td').each(function(i){
		$('.sp_detail table td').eq(i).append(array[i]);
	});
	var memo = '<div class="memo">'+result['memo']+'</div>';
	$('.sp_detail').append(memo);
	$('.sp_detail').slideDown();
}
