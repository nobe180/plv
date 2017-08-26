$(function(){
	relation = [];
	relation_txt = [];
	var value = '';
	$('.edit li').each(function(e){
		
		var href = $('.edit li a').eq(e).attr('href');
 		
		// 見つからなかった場合には -1 が返される
		if(href.indexOf('=') != -1) {
			re = href.split('=');
			var result = re[1];
		}else{
			re = href.split('/');
			var result = re[3];
		}
		var href_txt = $('.edit li a').eq(e).text();
		value += '<option value="'+result+'">'+href_txt+'</option>';
	});
	$('#relation').append(value);
});