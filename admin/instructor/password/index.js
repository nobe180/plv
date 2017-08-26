$(function(){

	$('#modify_btn').on('click', function(){
		var obj= {};
		var flag = 0;
		$('input').each(function(){
			if($(this).val() === ''){
				flag = 1;
			}else{
				obj[$(this).attr('name')] = $(this).val();
			}
		});

		if(flag !== 0){
			alert('必ず入力してください。');
		}else{
			$.post('/admin/instructor/password/json_check.php', obj, Completion, 'json');
		}

	});

    $('#cancel_btn').on('click', function(){
        location.reload();
	});

	function Completion(result){
		if(result['index'] === 0){
			alert('パスワードの変更をしました。');
			location.reload();
		}else if(result['index'] === 1){
			alert('現在のパスワードが違います。');
		}else if(result['index'] === 2){
			alert('確認用ののパスワードと違います。');
		}
	}
});