$(function(){
	jsonUrl = '/admin/system/member_list/json_check.php';
	Run(0, 0);
	$('#postcode1').jpostal({postcode:['#postal'], address:{'#prefecture':'%3%4%5'}});
});

function Run(a, b){
	$('#search').click(function(e){
		RefineSearch();
		e.stoppropagation();
	});
	ListDetail('#list_table tr', jsonUrl);
	ListNew('#new_list', jsonUrl);
	$('#list_table').tablesorter();
	$.datepicker.setDefaults($.datepicker.regional["ja"]);
	$('.datepicker').datepicker({dateFormat:'yy-m-d'});
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



/*  ----- 詳細表示クリック用 -----  */
function ListDetail(a, b){
	$(a).click(function(){
		var index = $(this).index();
		var id = $('table tbody tr:eq('+index+') input[name="index_id"]').val();
		$.post(b, {user_id:id}, Modal, 'json');
	});
}


/*---------------詳細ポップアップ用---------------*/
//部門の配列
var department = Array('school', 'studio', 'repair', 'agency', 'produce', 'other');
var department_txt = Array('音楽院', 'レンタルスタジオ', '楽器リペア', '演奏派遣', '楽曲制作', 'その他');

//会員ステータスの配列
var status_ = Array('full', 'associate', 'online', 'studio_', 'withdrawal', 'other_');
var status_txt = Array('正会員', '準会員', 'オンライン会員', 'スタジオ会員', '退会', 'その他');

function Modal(result){
	if(result['new_page'] == '1'){
		$('#conf').attr('id', 'conf_new');
		$('#saveImg').attr('id', 'saveImg_new');

		var department_content = '';
		for(var i = 0; i < department.length; i++){
			department_content += '<label class="check_design"><input type="checkbox" name="'+department[i]+'" value="0"  /><span class="lever">'+department_txt[i]+'</span></label>　　';
		}
	
		var status_content  = '';
		for(var i = 0; i < status_.length; i++){
			status_content += '<label class="check_design radio_box"><input type="radio" name="status" value="'+status_[i]+'" /><span class="lever">'+status_txt[i]+'</span></label>　　';
		}

		var array = [
					department_content,
					status_content,
					'<label class="check_design recess_box"><input type="checkbox" name="recess" value="1" /><span class="lever">休会</span></label>',
					'<input type="text" name="furigana" value="" />',
					'<input type="text" name="name" value="" />',
					'<input type="text" name="birthdate_Y" class="birthday" value="" />年\
					<input type="text" name="birthdate_M" class="birthday" value="" />月\
					<input type="text" name="birthdate_D" class="birthday" value="" />日',
					'<label><input type="radio" name="sex"  value="男性" />男性</label>　\
					<label><input type="radio" name="sex" value="女性" />女性</label>',
					'郵便番号　：　<input type="text" name="postal" id="postal" class="postal" value="" /><br />\
					町域まで　：　<input type="text" name="prefecture"  id="prefecture" class="address"  value="" /><br />\
					　番地号　：　<input type="text" name="city" class="address" value="" /><br />\
					建物名等　：　<input type="text" name="address" class="address" value="" />',
					'<input type="text" name="tel1" value="" />',
					'<input type="text" name="tel2" value="" />',
					'<input type="text" name="mail1" value="" />',
					'<input type="text" name="mail2" value="" />',
					'<textarea name="memo1"></textarea>',
					'<input type="text" name="skype" value="" />',
					'<input type="text" name="registration_date" class="datepicker" value="" />',
					'<input type="text" name="admission_withdrawal" class="datepicker" value="" />',
					'<textarea name="memo2"></textarea>'];
	}else{
		$('#conf_new').attr('id', 'conf');
		$('#saveImg_new').attr('id', 'saveImg');

		var department_content = '';
		for(var i = 0; i < department.length; i++){
			var checked = '';
			if(result['array'][0][department[i]] == '1') checked = 'checked';
			department_content += '<label class="check_design"><input type="checkbox" name="'+department[i]+'" value="0" '+checked+' /><span class="lever">'+department_txt[i]+'</span></label>　　';
		}

		var status_content  = '';
		for(var i = 0; i < status_.length; i++){
			var checked = '';
			if(result['array'][0][status_[i]] == '1') checked = 'checked';
			status_content += '<label class="check_design radio_box"><input type="radio" name="status" value="'+status_[i]+'" '+checked+' /><span class="lever">'+status_txt[i]+'</span></label>　　';
		}

		if(result['array'][0]['recess'] == '1') var checked_recess = 'checked';
		if(result['array'][0]['sex'] == '男性') var checked_sex1 = 'checked';
		if(result['array'][0]['sex'] == '女性') var checked_sex2 = 'checked';

		var withdrawal = result['array'][0]['withdrawal_date'];
		var admission = result['array'][0]['admission_date'];
		if(withdrawal == '0000-00-00') withdrawal = '';
		if(admission == '0000-00-00') admission = '';


		var array = [
					department_content,
					status_content,
					'<label class="check_design recess_box"><input type="checkbox" name="recess" value="1" '+checked_recess+' /><span class="lever">休会</span></label>',
					'<input type="text" name="furigana" value="'+result['array'][0]['furigana']+'" />',
					'<input type="text" name="name" value="'+result['array'][0]['name']+'" />',
					'<input type="text" name="birthdate_Y" class="birthday" value="'+result['array'][0]['birthdate_Y']+'" />年\
					<input type="text" name="birthdate_M" class="birthday" value="'+result['array'][0]['birthdate_M']+'" />月\
					<input type="text" name="birthdate_D" class="birthday" value="'+result['array'][0]['birthdate_D']+'" />日',
					'<label><input type="radio" name="sex"  value="男性" '+checked_sex1+' />男性</label>　\
					<label><input type="radio" name="sex" value="女性" '+checked_sex2+' />女性</label>',
					'郵便番号　：　<input type="text" name="postal" id="postal" class="postal" value="'+result['array'][0]['postal']+'" /><br />\
					町域まで　：　<input type="text" name="prefecture"  id="prefecture" class="address"  value="'+result['array'][0]['prefecture']+'" /><br />\
					　番地号　：　<input type="text" name="city" class="address" value="'+result['array'][0]['city']+'" /><br />\
					建物名等　：　<input type="text" name="address" class="address" value="'+result['array'][0]['address']+'" />',
					'<input type="text" name="tel1" value="'+result['array'][0]['tel1']+'" />',
					'<input type="text" name="tel2" value="'+result['array'][0]['tel2']+'" />',
					'<input type="text" name="mail1" value="'+result['array'][0]['mail1']+'" />',
					'<input type="text" name="mail2" value="'+result['array'][0]['mail2']+'" />',
					'<textarea name="memo1">'+result['array'][0]['memo1']+'</textarea>',
					'<input type="text" name="skype" value="'+result['array'][0]['skype']+'" />',
					'<input type="text" name="registration_date" class="datepicker" value="'+result['array'][0]['registration_date']+'" />',
					'<input type="text" name="admission_date" class="datepicker" value="'+admission+'" />',
					'<input type="text" name="withdrawal_date" class="datepicker" value="'+withdrawal+'" />',
					'<textarea name="memo2">'+result['array'][0]['memo2']+'</textarea>'];
			$('input[name=user_ID]').attr('value', result['array'][0]['ID']);	
	}

	$('#modal table td').each(function(i){
		$('#modal table td').eq(i).append(array[i]);
	});

	var contentTxt = $('#modal').html();
	$('body').prepend('<div id="overlay"></div><div id="popupContents" class="clearfix">'+contentTxt+'</div>');

	//初期のステータスを取得
	now_status = $('input[name="status"]:checked').val();
	$('#overlay').fadeIn();
	var t=$(document).scrollTop()+150;
	$('#popupContents').css({'animation':'bigEntrance 1.6s ease-out 1', 'top':t+'px'});
	autosize(document.querySelectorAll('textarea'));
	 $('#postcode1').jpostal({postcode:['#postal'], address:{'#prefecture':'%3%4%5'}});

	$('#modal_cancel, #closeImg').click(function(){
		ModalClose();
	});
	$.datepicker.setDefaults($.datepicker.regional["ja"]);
	$('.datepicker').datepicker({dateFormat:'yy-m-d'});

	jsonUrl2 = '/admin/system/member_list/json_registration.php';
	JsonSave('#conf', jsonUrl2);
	JsonSave('#saveImg', jsonUrl2);
	JsonSave('#conf_new', jsonUrl2);
	JsonSave('#saveImg_new', jsonUrl2);
}


function ModalClose(){
	$('#popupContents').css({'animation':'bigEntranceR 1.6s ease-out 1'});
	$('#overlay').fadeOut(function(){
		$('#overlay, #popupContents').remove();
		$('#modal table td').empty();
	}),300;
	
}


/*---------------新規登録用---------------*/
function ListNew(a, b){
	$(a).click(function(e){
		var id = 0;
		$.post(b, {user_id:id}, Modal, 'json');
		e.stoppropagation();
	});
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