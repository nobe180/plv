$(function(){
	jsonUrl = '/admin/system/member_list/json_check.php';
	Run(0, 0);
	$('.check_design input').click(function() {
		var obj= {};
		var index = $(this).parent().parent().parent().index() + 1;//trの要素番号
		if($(this).prop('checked') == false) {
			$('tr:eq('+index+') .check_design span').empty().append('OFF');
			obj['mail_select']= 0;
		}else {
			$('tr:eq('+index+') .check_design span').empty().append('ON');
			obj['mail_select']= 1;
		}
		obj['user_ID'] = $(this).val();
		$.post('/admin/system/mail_list/json_registration.php', obj, function(result){
			//$('#test').empty().append(result['test']);
		}, 'json');
	});
});

function Run(a, b){
	$('#search').click(function(e){
		RefineSearch();
		e.stoppropagation();
	});
	$('#list_table').tablesorter();
}


/*---------------絞り込み検索用---------------*/
function RefineSearch(){
	var obj= {};
	obj['item'] = $('[name=item]').val();
	obj['string'] = $('input[name="string"]').val();
	if(obj['item'] == 'name, furigana') {
		obj['string'] = kanaChange(obj['string']);
	}
	for(var i = 0; i < department.length; i++){
		if($('input[name=refine_'+department[i]+']').prop('checked')) obj['refine_'+department[i]] = '1'; 
	}
	
	for(i = 0; i < status_.length; i++){
		if($('input[name=refine_'+status_[i]+']').prop('checked')) obj['refine_'+status_[i]] = '1';
	}
	obj['refine_recess'] = '0';
	//$('#test').empty().append(obj['string']);
	if($('input[name=refine_recess]').prop('checked')) obj['refine_recess'] = '1';
	$.post(jsonUrl, obj, ContentList, 'json');
}

var preKana = "アイウエオァィゥェォカキクケコサシスセソタチツテトッナニヌネノハヒフヘホマミムメモヤユヨャュョラリルレロワヲンガギグゲゴザジズゼゾダヂヅデドバビブベボヴパピプペポー".split(''),
    halfKana = "ｱｲｳｴｵｧｨｩｪｫｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄｯﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖｬｭｮﾗﾘﾙﾚﾛﾜｦﾝｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾊﾋﾌﾍﾎｳﾊﾋﾌﾍﾎ-".split('');

function kanaChange(str){
	var kana = str;
	for(i=0;i<preKana.length;i++){					
		if (i < 55 || i == (preKana.length-1) ) {
			kana = kana.split(preKana[i]).join(halfKana[i]);
		} else if (i > 75) {
			kana = kana.split(preKana[i]).join(halfKana[i]+'ﾟ');
		} else {
			kana = kana.split(preKana[i]).join(halfKana[i]+'ﾞ');
		}		
	}				
	return kana;
}




function ContentList(result){
	var text = '';
	//$('#test').empty().append(result['test']);

	$('#list_table').empty();
	
	for(var i = 0; i < result['array'].length; i++){
		var registration_date = result['array'][i]['registration_date'];
		var admission_date = result['array'][i]['admission_date'];
		var withdrawal_date = result['array'][i]['withdrawal_date'];
		if(registration_date == '0000-00-00') registration_date = '';
		if(admission_date == '0000-00-00') admission_date = '';
		if(withdrawal_date == '0000-00-00') withdrawal_date = '';


		text += '<tr class="result_list">\
							<td><input type="hidden" name="index_id" value="'+result['array'][i]['ID']+'" />'+result['array'][i]['ID']+'</td>\
							<td>'+result['array'][i]['name']+'</td>\
							<td>'+result['array'][i]['furigana']+'</td>\
							<td>'+result['array'][i]['tel1']+'</td>\
							<td>'+result['array'][i]['tel2']+'</td>\
							<td>'+result['array'][i]['mail1']+'</td>\
							<td>'+registration_date+'</td>\
							<td>'+admission_date+'</td>\
							<td>'+withdrawal_date+'</td>\
							</tr>';
		}

	var table = '<thead>\
						<tr><th>ID</th><th>氏名</th><th>フリガナ</th><th>電話番号</th><th>携帯番号</th><th>E-Mail</th><th>登録日</th><th>入会日</th><th>退会日</th></tr>\
					</thead>\
					<tbody>'+text+'</tbody>';
	$('#list_table').append(table);
	$('#total').empty().append(result['array'].length);
	Run();
}


/*---------------登録用---------------*/
function JsonSave(a, b){
	$(a).click(function(e){
        var obj= {};
		obj['idname'] = 'modify';
		if(a == '#conf_new' || a == '#saveImg_new' ) obj['idname'] = 'upload';
		$('#popupContents  input, #popupContents textarea').each(function(){
			obj[$(this).attr('name')] = $(this).val();
		});
		var flag = 1;
		for(var i = 0; i < department.length; i++){
			if($('input[name='+department[i]+']').prop('checked')) {
					obj[department[i]] = '1';
					flag = 0;
			 }
		}

		obj['status'] = $('input[name="status"]:checked').val();
		for(var i = 0; i < status_.length; i++){
			if(obj['status'] == status_[i]){
				obj[status_[i]] = '1';
			}else{
				obj[status_[i]] = '0';	
			}
		}

		if($('input[name=recess]').prop('checked')){
			obj['recess'] = '1';
		}else{
			obj['recess'] = '0';
		};
//alert(now_status);
		//初期のステータスを取得
		obj['online_withdrawal'] = '0';
		obj['online_flag'] = '0';
		if(now_status == 'online'){
			obj['online_withdrawal'] = '1';
			obj['online_flag'] = '1';
		}
//alert(obj['online_withdrawal']);
		obj['name'] = obj['name'].replace('　', ' ');
		obj['furigana'] = kanaChange(obj['furigana']).replace('　', ' ');
		obj['sex'] = $('input[name="sex"]:checked').val();
		obj['saveName'] = $(this).attr('id');
		if (flag != 0){
			alert('部門とステータスを選択してください。');
		}else{
			$.post(b, obj, SaveCompletion, 'json');
		}
		e.stoppropagation();
	});
}



/*---------------処理完了用---------------*/
function SaveCompletion(result){
	$('#test').empty().append(result['test']);
	if(result['duplicate'] == '1'){
		alert('重複データです');
	}else{
		var scr = $(window).scrollTop();
		ModalClose();
		RefineSearch();
	}
}