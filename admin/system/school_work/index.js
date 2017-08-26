$(function(){
	 Run();
});

function Run(){
	jsonUrl = '/admin/system/school_work/json_check.php';
	RefineSearch('#search', jsonUrl);
	ListDetail('#list_table tr', jsonUrl);
	ListNew('#new_list', jsonUrl);
	$('#list_table').tablesorter();
	$.datepicker.setDefaults($.datepicker.regional["ja"]);
	$('.datepicker').datepicker({dateFormat:'yy-m-d'});
}
/*---------------絞り込み検索用---------------*/
function RefineSearch(a, b){
	$(a).click(function(e){
		var selected = $('[name=item]').val();
		var str = $('input[name="string"]').val();
		if(selected == 'furigana') str = kanaChange(str);
		var checked = $('input[name="refine"]:checked').val();
		var pc_sp = $('input[name="pc_sp"]:checked').val();
		var period1 = $('input[name="period1"]').val();
		var period2 = $('input[name="period2"]').val();
		$.post(b, {item_:selected, string:str, period1:period1, period2:period2, refine_id:checked, pc_sp:pc_sp}, ContentList, 'json');
		e.stoppropagation();
	});
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
	var jsonUrl = '';
	var text = '';
	var color = '';
	$('#list_table').empty();
	jsonUrl = 'json_check.php';

	for(var i = 0; i < result['array'].length; i++){
		if(result['array'][i][0]['result_etc'] == '体験レッスン') color = 'ff3300';
		if(result['array'][i][0]['result_etc'] == 'カウンセリング') color = '0066cc';
		if(result['array'][i][0]['result_etc'] == '来訪') color = 'ff9900';
			text += '<tr class="result_list">\
							<td><span style="color:#'+color+';">'+result['array'][i][0]['result_etc']+'</span><input type="hidden" name="index_id" value="'+result['array'][i][0]['ID']+'" /></td>\
							<td>'+result['array'][i][0]['admission']+'</td>\
							<td>'+result['user'][i][0]['name']+'</td>\
							<td>'+result['user'][i][0]['furigana']+'</td>\
							<td>'+result['user'][i][0]['tel2']+'</td>\
							<td>'+result['user'][i][0]['mail1']+'</td>\
							<td>'+result['array'][i][0]['major']+'</td>\
							</tr>';
		}

	var table = '<thead>\
						<tr><th width="140"></th><th width="100">申込日</th><th width="140">氏名</th><th width="140">フリガナ</th><th width="140">電話番号</th><th width="300">E-Mail</th><th>目的</th></tr>\
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
		$.post(b, {counseling_id:id}, Modal, 'json');
	});
}


/*---------------詳細ポップアップ用---------------*/
function Modal(result){

	if(result['new_page'] == '1'){
		$('#conf').attr('id', 'conf_new');
		$('#saveImg').attr('id', 'saveImg_new');

		var age_etc = '';
		for( var i = 10; i <= 90; i += 10){
			var checked = [];
			age_etc += '<label><input type="radio" name="age_etc" class="check" value="'+i+'代" />'+i+'代</label>　';
		}

		var advertisement_ary = ['PC', 'SP', 'チラシ（ポスティング）', 'チラシ（張り紙）'];
		var advertisement = '';
		for( var i = 0; i < advertisement_ary.length; i++){
			advertisement += '<label><input type="radio" name="advertisement" class="check" value="'+advertisement_ary[i]+'" />'+advertisement_ary[i]+'</label>　';
		}

		var array = ['<label><input type="radio" name="result_etc" class="check" value="カウンセリング" />カウンセリングフォーム</label>　\
					<label><input type="radio" name="result_etc" class="check" value="体験レッスン" />体験レッスンフォーム</label>　\
					<label><input type="radio" name="result_etc" class="check" value="来訪" />来訪</label>', 
					'<input type="text" name="admission" class="datepicker" value="" />', 
					'<input type="text" name="furigana" value="" />', 
					'<input type="text" name="name" value="" />', 
					'<label><input type="radio" name="sex" class="check" value="男性" />男性</label>　\
					<label><input type="radio" name="sex" class="check" value="女性" />女性</label>', 
					'<input type="text" name="age" value="" />', 
					'<label><input type="radio" name="age_etc" class="check" value="10歳未満" />10歳未満</label>　\
					'+age_etc,
					'<input type="text" name="tel1" value="" />', 
					'<input type="text" name="tel2" value="" />',
					'<input type="text" name="mail1" value="" />',
					'<input type="text" name="mail2" value="" />',
					advertisement+'<input type="text" name="advertisement_etc" value="" placeholder="その他" />',
					'<textarea name="web_portal" placeholder="WEB広告、ポータルサイト等" ></textarea>', 
					'<textarea name="search_word"></textarea>', 
					'<label id="introducer_true"><input type="radio" name="introducer" class="check" value="有り" />有り</label>　\
					<label id="introducer_false"><input type="radio" name="introducer" class="check" value="無し" />無し</label>　\
					<span id="introducer_name"><input type="text" name="introducer_name"  value=""  placeholder="紹介者名" /></span>',
					'<textarea name="major"></textarea>', 
					'<textarea name="experience"></textarea>', 
					'<textarea name="genre"></textarea>', 
					'<textarea name="artist"></textarea>', 
					'<input type="text" name="result" value="" />', 
					'<textarea name="request"></textarea>', 
					'<input type="text" name="major_category" value="" />', 
					'<input type="text" name="instructor" value="" />', 
					'<input type="text" name="skype" value="" />', 
					'<textarea name="date"></textarea>', 
					'<textarea name="memo"></textarea>', 
					'<input type="text" name="interviewer" value="" />'
							];
	}else{
		$('#conf_new').attr('id', 'conf');
		$('#saveImg_new').attr('id', 'saveImg');

		if(result['array'][0][0]['result_etc'] == 'カウンセリング') var result_checked1 = 'checked';
		if(result['array'][0][0]['result_etc'] == '体験レッスン') var result_checked2 = 'checked';
		if(result['array'][0][0]['result_etc'] == '来訪') var result_checked3 = 'checked';

		if(result['user'][0][0]['sex'] == '男性') var checked_sex1 = 'checked';
		if(result['user'][0][0]['sex'] == '女性') var checked_sex2 = 'checked';

		var advertisement_ary = ['PC', 'SP', 'チラシ（ポスティング）', 'チラシ（張り紙）'];
		var advertisement = '';
		for( var i = 0; i < advertisement_ary.length; i++){
			var checked1 = [];
			if(result['array'][0][0]['advertisement'] == advertisement_ary[i]) checked1[i] = 'checked';
			advertisement += '<label><input type="radio" name="advertisement" value="'+advertisement_ary[i]+'" '+checked1[i]+' />'+advertisement_ary[i]+'</label>　';
		}

		if(result['array'][0][0]['introducer'] == '有り') var checked_introducer1 = 'checked';
		if(result['array'][0][0]['introducer'] == '無し') var checked_introducer2 = 'checked';


		var admission = result['array'][0][0]['admission'];
		if(result['array'][0][0]['admission'] == '0000-00-00')  admission = '';
		var counseling_id = result['array'][0][0]['ID'];
		if(result['array'][0][0]['ID'] == '0')  counseling_id = '0';
		if(result['array'][0][0]['age_etc'] == '10歳未満') var checked_age = 'checked';
		var age_etc = '';
		for( var i = 10; i <= 90; i += 10){
			var checked2 = [];
			if(result['array'][0][0]['age_etc'] == i+'代') checked2[i] = 'checked';
			age_etc += '<label><input type="radio" name="age_etc" value="'+i+'代" '+checked2[i]+' />'+i+'代</label>　';
		}

		var array = ['<label><input type="radio" name="result_etc" value="カウンセリング" '+result_checked1+' />カウンセリングフォーム</label>　\
					<label><input type="radio" name="result_etc" value="体験レッスン" '+result_checked2+' />体験レッスンフォーム</label>　\
					<label><input type="radio" name="result_etc" value="来訪" '+result_checked3+' />来訪</label>', 
					'<input type="text" name="admission" class="datepicker" value="'+admission+'" />', 
					'<input type="text" name="furigana" value="'+kanaChange(result['user'][0][0]['furigana'])+'" />', 
					'<input type="text" name="name" value="'+result['user'][0][0]['name']+'" />', 
					'<label><input type="radio" name="sex"  value="男性" '+checked_sex1+' />男性</label>　\
					<label><input type="radio" name="sex" value="女性" '+checked_sex2+' />女性</label>', 
					'<input type="text" name="age" value="'+result['array'][0][0]['age']+'" />', 
					'<label><input type="radio" name="age_etc" value="10歳未満" '+checked_age+' />10歳未満</label>　\
					'+age_etc,
					'<input type="text" name="tel1" value="'+result['user'][0][0]['tel1']+'" />', 
					'<input type="text" name="tel2" value="'+result['user'][0][0]['tel2']+'" />',
					'<input type="text" name="mail1" value="'+result['user'][0][0]['mail1']+'" />',
					'<input type="text" name="mail2" value="'+result['user'][0][0]['mail2']+'" />',
					advertisement+'<input type="text" name="advertisement_etc" value="'+result['array'][0][0]['advertisement_etc']+'" placeholder="その他" />',
					'<textarea name="web_portal" placeholder="WEB広告、ポータルサイト等" >'+result['array'][0][0]['web_portal']+'</textarea>', 
					'<textarea name="search_word">'+result['array'][0][0]['search_word']+'</textarea><input type="hidden" name="before_word" value="'+result['array'][0][0]['search_word']+'" />', 
					'<label id="introducer_true"><input type="radio" name="introducer" value="有り" '+checked_introducer1+' />有り</label>　\
					<label id="introducer_false"><input type="radio" name="introducer" value="無し" '+checked_introducer2+' />無し</label>　\
					<span id="introducer_name"><input type="text" name="introducer_name"  value="'+result['array'][0][0]['introducer_name']+'"  placeholder="紹介者名" /></span>',
					'<textarea name="major">'+result['array'][0][0]['major'].replace(/、/g, "\n")+'</textarea>', 
					'<textarea name="experience">'+result['array'][0][0]['experience']+'</textarea>', 
					'<textarea name="genre">'+result['array'][0][0]['genre']+'</textarea>', 
					'<textarea name="artist">'+result['array'][0][0]['artist']+'</textarea>', 
					'<input type="text" name="result" value="'+result['array'][0][0]['result']+'" />', 
					'<textarea name="request">'+result['array'][0][0]['txt']+'</textarea>', 
					'<input type="text" name="major_category" value="'+result['array'][0][0]['major_category']+'" />', 
					'<input type="text" name="instructor" value="'+result['array'][0][0]['instructor']+'" />', 
					'<input type="text" name="skype" value="'+result['array'][0][0]['skype']+'" />', 
					'<textarea name="date">'+result['array'][0][0]['date'].replace(/、/g, "\n")+'</textarea>', 
					'<textarea name="memo">'+result['array'][0][0]['memo']+'</textarea>', 
					'<input type="text" name="interviewer" value="'+result['array'][0][0]['interviewer']+'" />'
					];

		$('#userID').attr('value', result['user'][0][0]['ID']);	
		$('#counselingID').attr('value', counseling_id);	
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


	$('#modal_cancel, #closeImg').click(function(){
		ModalClose();
	});
	$.datepicker.setDefaults($.datepicker.regional["ja"]);
	$('.datepicker').datepicker({dateFormat:'yy-m-d'});

	jsonUrl = '/admin/system/school_work/json_registration.php';
	JsonSave('#conf', jsonUrl);
	JsonSave('#saveImg', jsonUrl);
	JsonSave('#conf_new', jsonUrl);
	JsonSave('#saveImg_new', jsonUrl);
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
	$(a).click(function(){
		var id = 0;
		$.post(b, {counseling_id:id}, Modal, 'json');
	});
}



/*---------------登録用---------------*/
function JsonSave(a, b){
	$(a).click(function(){
        var obj= {};
		obj['idname'] = 'modify';
		if(a == '#conf_new' || a == '#saveImg_new' ) obj['idname'] = 'upload';
		$('#popupContents table input, #popupContents table textarea').each(function(){
			obj[$(this).attr('name')] = $(this).val();
		});
		obj['furigana'] = kanaChange(obj['furigana']);
		obj['result_etc'] = $('input[name="result_etc"]:checked').val();
		obj['age_etc'] = $('input[name="age_etc"]:checked').val();
		obj['sex'] = $('input[name="sex"]:checked').val();
		obj['advertisement'] = $('input[name="advertisement"]:checked').val();
		obj['introducer'] = $('input[name="introducer"]:checked').val();
		obj['saveName'] = $(this).attr('id');

		obj['userID'] = $('#userID').val();
		obj['counselingID'] = $('#counselingID').val();
		if(obj['admission'] == ''){
			alert('カウンセリング申込日を入力してください。');
		}else{
			$.post(b, obj, SaveCompletion, 'json');
		}
	});
}



/*---------------処理完了用---------------*/
function SaveCompletion(result){
		ModalClose();
}