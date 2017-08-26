$(function(){
	jsonUrl = '/admin/system/staff_list/json_check.php';
	Run();
	$('#postcode1').jpostal({postcode:['#postal'], address:{'#prefecture':'%3%4%5'}});
});

function Run(){
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
	var selected = $('[name=item]').val();
	var str = $('input[name="string"]').val();
	if(selected == 'furigana') str = kanaChange(str);
	var checked = $('input[name="refine"]:checked').val();
	$.post(jsonUrl, {item_:selected, string:str, refine_id:checked}, ContentList, 'json');
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
	var color = '';
	$('#list_table').empty();

	for(var i = 0; i < result['array'].length; i++){
			text += '<tr class="result_list">\
							<td><input type="hidden" name="index_id" value="'+result['array'][i]['ID']+'" />'+result['array'][i]['name']+'</td>\
							<td>〒'+result['array'][i]['postal']+'　'+result['array'][i]['prefecture']+' '+result['array'][i]['city']+'<br />'+result['array'][i]['address']+'</td>\
							<td>'+result['array'][i]['tel2']+'</td>\
							<td>'+result['array'][i]['mail1']+'</td>\
							<td width="150">'+result['array'][i]['bank']+'</td>\
							<td width="150">'+result['array'][i]['branch']+'</td>\
							<td width="150">'+result['array'][i]['number']+'</td>\
							</tr>';
		}

	var table = '<thead>\
						<tr><th width="140">氏名</th><th width="400">住所</th><th width="140">電話番号</th><th width="300">E-Mail</th><th colspan="3">振込先</th></tr>\
					</thead>\
					<tbody>'+text+'</tbody>';
	$('#list_table').append(table);
	$('#total').empty().append(result['array'].length);
	Run();
}



/*  ----- 詳細表示クリック用 -----  */
function ListDetail(a, b){
	$(a).dblclick(function(){
		var index = $(this).index();
		var id = $('table tbody tr:eq('+index+') input[name="index_id"]').val();
		$.post(b, {staff_id:id}, Modal, 'json');
	});
}


/*---------------詳細ポップアップ用---------------*/

var ary = Array('instructor', 'player', 'repair', 'staff', 'retirement');
var ary2 = Array('講師', '作編曲・演奏者', 'リペアマン', 'スタッフ', '退職');

function Modal(result){
	if(result['new_page'] == '1'){
		$('#conf').attr('id', 'conf_new');
		$('#saveImg').attr('id', 'saveImg_new');
		
		var array = [
					'<label class="checkbox"><input type="checkbox" name="instructor" value="0" /><span class="lever">講師</span></label>　\
					<label class="checkbox"><input type="checkbox" name="player" value="0" /><span class="lever">作編曲・演奏者</span></label>　\
					<label class="checkbox"><input type="checkbox" name="repair" value="0" /><span class="lever">リペアマン</span></label>　\
					<label class="checkbox"><input type="checkbox" name="staff" value="0" /><span class="lever">スタッフ</span></label>　\
					<label class="checkbox"><input type="checkbox" name="retirement" value="0" /><span class="lever">退職</span></label>',
					'<input type="text" name="english" value="" />',
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
					'<input type="text" name="bank" value="" />',
					'<input type="text" name="branch" value="" />',
					'<input type="text" name="number" value="" />',
					'<input type="text" name="instrument" value="" />',
					'<input type="text" name="genre" value="" />',
					'<input type="text" name="my_site" value="" />',
					'<textarea name="memo"></textarea>'];
	}else{
		$('#conf_new').attr('id', 'conf');
		$('#saveImg_new').attr('id', 'saveImg');

		
		var employment = '';
		for(var i = 0; i < ary.length; i++){
			var checked = '';
			if(result['array'][0][ary[i]] == '1') checked = 'checked';
			employment += '<label class="checkbox"><input type="checkbox" name="'+ary[i]+'" value="0" '+checked+' /><span class="lever">'+ary2[i]+'</span></label>　　';
		}

		if(result['array'][0]['sex'] == '男性') var checked_sex1 = 'checked';
		if(result['array'][0]['sex'] == '女性') var checked_sex2 = 'checked';

		var array = [
					employment,
					'<input type="text" name="english" value="'+result['array'][0]['english']+'" />',
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
					'<input type="text" name="bank" value="'+result['array'][0]['bank']+'" />',
					'<input type="text" name="branch" value="'+result['array'][0]['branch']+'" />',
					'<input type="text" name="number" value="'+result['array'][0]['number']+'" />',
					'<input type="text" name="instrument" value="'+result['array'][0]['instrument']+'" />',
					'<input type="text" name="genre" value="'+result['array'][0]['genre']+'" />',
					'<input type="text" name="my_site" value="'+result['array'][0]['my_site']+'" />',
					'<textarea name="memo">'+result['array'][0]['memo']+'</textarea>'];
					
			$('input[name=staff_ID]').attr('value', result['array'][0]['ID']);	
	}

	$('#modal table td').each(function(i){
		$('#modal table td').eq(i).append(array[i]);
	});

	var contentTxt = $('#modal').html();
	$('body').prepend('<div id="overlay"></div><div id="popupContents" class="clearfix">'+contentTxt+'</div>');

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

	jsonUrl2 = '/admin/system/staff_list/json_registration.php';
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
		$.post(b, {staff_id:id}, Modal, 'json');
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
		for(var i = 0; i < ary.length; i++){
			if($('input[name='+ary[i]+']').prop('checked')) {
					obj[ary[i]] = '1';
					flag = 0;
			 }
		}

		obj['furigana'] = kanaChange(obj['furigana']);
		obj['sex'] = $('input[name="sex"]:checked').val();
		obj['saveName'] = $(this).attr('id');

		if (flag != 0){
			alert('形態を選択してください。');
		}else{
			$.post(b, obj, SaveCompletion, 'json');
		}
		e.stoppropagation();
	});
}



/*---------------処理完了用---------------*/
function SaveCompletion(result){
	//var test = $('input[name=refine]:checked').val();
	//$('#test').empty().append(test);
	ModalClose();
	RefineSearch();
}