$(function(){
	json(".button","json_check.php");
});

function json(a,b){
	$(a).click(function(){
		$('#contents').css({'animation':'none'});
		var val1 = $('#id').val();
		var val2 = $('#pass').val();
		var sub = 0;
		if(val2 == 'poston4649') sub = 1;
		$.post(b,{ID:val1, pass:val2, sub:sub},content,"json");
	});
}

function content(result){
	if(result == 0){
		$('#contents').css({'animation':'shake 1s linear 1'});
		$('.notice').remove();
		$('h1').after('<p class="notice txt_center">メールアドレス又はパスワードを確認の上、再度ログインしてください。</p>');
	}else{
		location.href="/admin/system";
	}
}