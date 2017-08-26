$(function(){
	json(".button","json_check.php");
});

function json(a,b){
	$(a).click(function(){
		$('#contents').css({'animation':'none'});
		var val1=$('#id').val();
		var val2=$('#pass').val();
		$.post(b,{ID:val1,pass:val2},content,"json");
	});
}

function content(result){
	$('#test').empty().append(result['test']);
	if(result['result'] == 0){
		$('#contents').css({'animation':'shake 1s linear 1'});
		$('.notice').remove();
		$('h1').after('<p class="notice center">メールアドレス又はパスワードを確認の上、再度ログインしてください。</p>');
	}else{
		$('#test').empty().append(result['test']);
		location.href="/admin/instructor";
	}
}