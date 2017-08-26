$(function(){
	$('header ul li').each(function(i){
		var id = $(this).attr('id');
		json('#'+id, 'json_check.php');
	});
});

function json(a,b){
	$(a).click(function(){
		var txt=$(this).text();
		var idname=$(this).attr('id');
		$.post(b,{txt:txt,idname:idname},content,'json');
	});
}

function content(result){
	var jsonUrl;
	$('#container h1').empty().append(result[0]);
	$('#container article').empty().append(result[1]);

	
	if(result['selectID']){
		$('#listSelect').val(result['selectID']);
		var idtxt = $('#listSelect').attr('id');
		if(result['completionName'] == 'counseling'){
			$.post('json_'+result['completionName']+'_check.php', {id:result['selectID'], txt:idtxt}, ContentCounseling, 'json');
		}else if(result['completionName'] == 'workers'){
			$.post('json_'+result['completionName']+'_check.php', {id:result['selectID'], txt:idtxt}, ContentWorkers, 'json');
		}
	}

	$('#workersListTable, #counselingListTable').css('width', '1600px');
	autosize(document.querySelectorAll('textarea'));
	
	//テーブルソート
	$('#counselingListTable').tablesorter();
	$('#workersListTable').tablesorter();



/*  ----- MIDI検定表示記述 -----  */
	JsonMidiLicenseSelect('#listSelect', 'json_midi_check.php');
	JsonMidiLicense('#midiLicense #prevBtn', 'json_midi_check.php');
	JsonMidiLicense('#midiLicense #nextBtn', 'json_midi_check.php');
	


/*  ----- 講師・演奏者一覧表示記述 -----  */
	jsonUrl = 'json_workersList_check.php';
	JsonList('#workersSelect .check', jsonUrl);
	JsonListSearch('#workersSelect #str', jsonUrl);
	JsonWorkersListDetail('.workersList', jsonUrl);



/*  ----- 講師・演奏者表示記述 -----  */
	jsonUrl = 'json_workers_check.php';
	JsonWorkersSelect('#workers #listSelect', jsonUrl);
	JsonWorkers('#workers #prevBtn', jsonUrl);
	JsonWorkers('#workers #nextBtn', jsonUrl);
	JsonWorkers('#workers #new', jsonUrl);
	JsonWorkersSave('#workers #save', jsonUrl);
	JsonWorkersNewSave('#workers #newSave', jsonUrl);
	$('#postcode1').jpostal({
		postcode:['#postal'],
		address:{'#prefecture':'%3%4%5'}
	});
	JsonCourse();
	JsonCourseAdd();
}


/*  ----- 共通function設定 -----  */
function Completion(result){
	alert('OK');
	if(result['completion']) alert('保存が完了しました。');
	var resultId = result['contentName'];
	var txt = $('#'+resultId).text();
	var idname = $('#'+resultId).attr('id');
	if(result['selectID']){
		$.post('json_check.php', {txt:txt, idname:idname, selectid:result['selectID'], contentName:resultId}, content, 'json');
	}else{
		$.post('json_check.php', {txt:txt, idname:idname}, content, 'json');
	}
}

function JsonList(a, b){
	$(a).click(function(){
		$('#str').val('');
		var checkId = $('input[name="result"]:checked').val();
		$.post(b, {id:checkId}, contentList, 'json');
	});
}

function JsonListSearch(a, b){
	$(a).keyup(function(e){
		var str = $(this).val();
		var checkId = $('input[name="result"]:checked').val();
		$.post(b, {searchStr:str, id:checkId}, contentList, 'json');
		e.stoppropagation();
	});
}

function contentList(result){
	var jsonUrl = '';
	var text = '';
	var color = '';
	if(result['index'] == 'staffList'){
		$('#workersListTable').empty();
		jsonUrl = 'json_workersList_check.php';
		for(var i = 0; i < result['array'].length; i++){
			if(result['array'][i]['employment'] == '講師') color = 'ff3300';
			if(result['array'][i]['employment'] == '外部') color = '0066cc';
			if(result['array'][i]['employment'] == 'スタッフ') color = 'ff9900';
				text += '<tr class="result_list workersList">\
							<td>'+(i+1)+'<input type="hidden" name="indexID" value="'+result['array'][i]['ID']+'" /></td>\
							<td><span style="color:#'+color+';">'+result['array'][i]['employment']+'</span></td>\
							<td>'+result['array'][i]['name']+'</td>\
							<td>〒'+result['array'][i]['postal']+'　'+result['array'][i]['prefecture']+' '+result['array'][i]['city']+'<br />'+result['array'][i]['address']+'</td>\
							<td>'+result['array'][i]['mobile']+'</td>\
							<td>'+result['array'][i]['mail1']+'</td>\
							<td width="150">'+result['array'][i]['bank']+'</td>\
							<td width="150">'+result['array'][i]['branch']+'</td>\
							<td width="150">'+result['array'][i]['number']+'</td>\
						</tr>';
			}
		
		var table = '<thead>\
						<tr><th width="30"></th><th width="70">形態</th><th width="140">氏名</th><th width="400">住所</th><th width="140">電話番号</th><th width="300">E-Mail</th><th colspan="3">振込先</th></tr>\
					</thead>\
					<tbody>'+text+'</tbody>';
		$('#workersListTable').append(table);
		$('#total').empty().append(result['array'].length);
		$('#workersListTable').tablesorter();
		JsonWorkersListDetail('.workersList', jsonUrl);
	}
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

function SaveCompletion(result){
	if(result['saveName'] == 'conf' || result['saveName'] == 'conf_new' || result['saveName'] == 'saveImg_new' ){
		$('#popupContens').css({'animation':'bigEntranceR 1.6s ease-out 1'});
			$('#overlay').fadeOut(function(){
			$('#overlay, #popupContens').remove();
			$('#modalContens table td').empty();
		}),300;
	}else{
		alert('保存が完了しました。');
	}
}






/*  ----- MIDI検定表示設定 -----  */

function JsonMidiLicenseSelect(a,b){
	$(a).change(function(){
		var idNo = $(this).children(':selected').val();
		var idtxt = $(this).attr('id');
		$.post(b,{id:idNo, txt:idtxt},ContentMIDI, 'json');
	});
}

function JsonMidiLicense(a,b){
	$(a).click(function(){
		var idNo=$('#midiId').val();
		var idtxt=$(this).attr('id');
		$.post(b,{id:idNo, txt:idtxt},ContentMIDI, 'json');
	});
}

function ContentMIDI(result){
	$('#prev').empty().append('<input type="button" id="prevBtn" value="前へ" />');
	$('#next').empty().append('<input type="button" id="nextBtn" value="次へ" />');
	if(result[0] == 1){
		$('#prev').empty().append('<input type="button" value="" />');
	}
	if(result[0] == 2){
		$('#next').empty().append('<input type="button" value="" />');
	}

	$('select option').attr('selected', false);
	$('select').val(result[1]['midi_ID']);
	$('#midiId').val(result[1]['midi_ID']);
	var abc =　Array('','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o');
	$('#q1_1, #q1_2, #q2_1, #q2_2, #q3, #q4_1, #q4_2, #q5').empty();
	var online = Array('', 'furigana', 'name', 'birthdate_Y', 'birthdate_M', 'birthdate_D', 'sex', 'postal', 'prefecture', 'city', 'address');

	for(var i=1;i<=online.length;i++){
		var student=result[2]['online_'+online[i]];
		$('#student'+i).text(student);
	}

	if(result[2]['online_tel']==''){
		var tel=result[2]['online_mobile']+'（携帯）';
	}else{
		if(result[2]['online_mobile']==''){
			var tel=result[2]['online_tel']+'（自宅）';
		}else{
			var tel=result[2]['online_tel']+'（自宅）、'+result[2]['online_mobile']+'（携帯）';
		}
	}

	$('#tel').text(tel);

	var date=result[1]['midi_date'];
	var dateY=date.substr(0,4);
	var dateM=date.substr(5, 2);
	var dateD=date.substr(8, 2);
	var a=dateM.substr(0, 1);
	if(a=='0') var dateM=date.substr(6, 1);
	var b=dateD.substr(0, 1);
	if(b=='0') var dateD=date.substr(9, 1);

	$('#midi1').text(dateY);
	$('#midi2').text(dateM);
	$('#midi3').text(dateD);

	var arr = [
    	['#q1_1', 1, 6, 1, 1],
   		['#q1_2', 7, 12, 1, 7],
		['#q2_1', 1, 7, 2, 13],
		['#q2_2', 8, 13, 2, 20],
		['#q3', 1, 7, 3, 26],
		['#q4_1', 1, 8, 4, 33],
		['#q4_2', 9, 15, 4, 41],
		['#q5', 1, 3, 5, 48]
	];

	var str, txt, total, nowAnswer, aa;
	var answer = Array('',1,3,1,4,1,3,2,1,1,2,3,1,1,4,2,1,1,2,1,2,5,3,1,5,3,2,3,1,2,1,3,2,2,2,4,2,1,3,1,3,2,5,1,1,4,2,3,1,3,1);

	total = 0;
	for(var i = 0; i < arr.length; i++){
		aa = arr[i][4];
		for(var v = arr[i][1]; v <= arr[i][2]; v++){
			total += 2;
			nowAnswer = result[1][arr[i][3]+abc[v]];
			txt = '<td class="correct">'+nowAnswer+'</td>';
			if(answer[aa] != nowAnswer){
				txt = '<td class="incorrect">'+nowAnswer+'</td>';
				total -= 2;
			}
			aa ++;	
			$(arr[i][1]).append(txt.replace('0', ''));
		}
	}

	$('#grading span').empty().append(total);

	JsonMidiLicenseSelect('#listSelect','json_midi_check.php');
	JsonMidiLicense('#midiLicense #prevBtn', 'json_midi_check.php');
	JsonMidiLicense('#midiLicense #nextBtn', 'json_midi_check.php');
}



/*  ----- 講師・演奏者の表示設定 -----  */
function JsonWorkersSave(a,b){
	$(a).click(function(){
        var obj= {};
		obj['idname'] = 'modify';
		$('#workersForm input, #workersForm textarea').each(function(){
			obj[$(this).attr('name')] = $(this).val();
		});
		obj['work'] = $('#workersForm [name=work]:checked').val();
		obj['employment'] = $('#workersForm [name=employment]:checked').val();
		obj['id'] = obj['ID'];
		obj['major_category'] = checkBox('major_category');
		obj['course'] = checkBox('course');
		obj['days'] = checkBox('days');

		obj['textareaNum'] =  parseInt($('.academic textarea').length); //textareaの個数
		var index = $('.academic .check').length;
		for(var i = 0; i < index; i++){
			if($('#dell_check'+(i+1)).prop('checked')){
				obj['delete'+(i+1)] = 1;
			}
			else{
				obj['delete'+(i+1)] = 0;
			}
		}
		
		$.post(b, obj, Completion, 'json');
	});
}

function checkBox(a){
	var assignment1 = '';
	var assignment2 = '';
	$('#workersForm [name="'+a+'"]:checked').each(function(i){
		assignment1 += $(this).val()+',';
	});
	assignment2 = assignment1.substr(0, assignment1.length-1);
	return assignment2;
}



function JsonWorkersNewSave(a,b){
	$(a).click(function(){
		var obj= {};
		obj['idname'] = 'newSave';
		$('#workersForm input, #workersForm textarea').each(function(){
			obj[$(this).attr('name')] = $(this).val();
		});
		obj['work'] = $('#workersForm [name=work]:checked').val();
		obj['employment'] = $('#workersForm [name=employment]:checked').val();
		$('form').find("textarea, :text, select").val('').end().find(':checked').prop('checked', false);
		$('#newSave').css('display', 'none');
		$('#save').css('display', 'block');
		$.post(b, obj, Completion, 'json');
	});
}

function JsonWorkersSelect(a,b){
	$(a).change(function(){
		var idNo = $(this).children(':selected').val();
		var idtxt = $(this).attr('id');
		$.post(b,{id:idNo, txt:idtxt},ContentWorkers,'json');
	});
}


function JsonWorkers(a,b){
	$(a).click(function(){
		var idNo = $('#workersId').val();
		var idtxt = $(this).attr('id');
		$.post(b,{id:idNo, txt:idtxt}, ContentWorkers, 'json');
	});
}



function JsonCourse(){
	$('#course .check').on('change', function(){
		if($('#course .course0').prop('checked')) {
     		var addText = '<div class="courseType">【 アカデミック 】<span class="add">＋</span></div>\
						<table class="courseTable academic">\
							<tr>\
								<th rowspan="2" class="coruseTh1">1</th><th class="coruseTh1"></th><td><input type="text" class="course_name" name="about1" value="" /></td>\
								<th>コース名</th><td><input type="text" class="course_name" name="name1" value="" /></td>\
								<th>時間</th><td class="coruseTh2"><input type="text" class="course_ipt" name="minute1" value="" /></td>\
								<th>回数</th><td class="coruseTh2"><input type="text" class="course_ipt" name="num1" value="" /></td>\
								<th>料金（税込）</th><td class="coruseTh2"><input type="text" class="course_ipt" name="price1" value="" /></td>\
							</tr>\
							<tr><th class="coruseTh1">説明</th><td colspan="9" class="coruseTd"><textarea class="course_detail" name="detail1"></textarea></td></tr>\
						</table>';
			$('form #workers').before(addText);
		}else{
			$('.academic, .courseType').remove();
		}
		autosize(document.querySelectorAll('textarea'));
		JsonCourseAdd();
	});
}

function JsonCourseAdd(){
	$('form .add').click(function(){
		var txtIndex =  parseInt($('.academic textarea').length); //textareaの個数
		
		var addTxt = '<tr>\
								<th rowspan="2" class="coruseTh1">'+(txtIndex+1)+'</th><th class="coruseTh1"></th><td><input type="text" class="course_name" name="about'+(txtIndex+1)+'" value="" /></td>\
								<th>コース名</th><td><input type="text" class="course_name" name="name'+(txtIndex+1)+'" value="" /></td>\
								<th>時間</th><td class="coruseTh2"><input type="text" class="course_ipt" name="minute'+(txtIndex+1)+'" value="" /></td>\
								<th>回数</th><td class="coruseTh2"><input type="text" class="course_ipt" name="num'+(txtIndex+1)+'" value="" /></td>\
								<th>料金（税込）</th><td class="coruseTh2"><input type="text" class="course_ipt" name="price'+(txtIndex+1)+'" value="" /></td>\
							</tr>\
							<tr><th class="coruseTh1">説明</th><td colspan="9" class="coruseTd"><textarea class="course_detail" name="detail'+(txtIndex+1)+'"></textarea></td></tr>';

		$('.academic').append(addTxt);
		autosize(document.querySelectorAll('textarea'));
	});

}

function ContentWorkers(result){
	$('.workersTable:eq(1), .workersTable:eq(2), .courseTable, .courseType').remove();
	var jsonUrl = 'json_workers_check.php';
	if(result['flag'] == 1){
		$('form').find("textarea, :text, select").val('').end().find(':checked').prop('checked', false);
		$('#save').css('display', 'none');
		$('#newSave').css('display', 'block');
		$('#workersId').val(parseInt(result[3][(result[4]-1)]['ID'])+1);
	}else{
		//アカデミックだと一致しないためデミックに変更
		var course_array = ['デミック', 'ピンポイント', '集中講座', 'オンライン', 'グループ', 'イベント'];
		var days_array = ['日曜', '火曜', '水曜', '木曜', '金曜', '土曜', '不定期'];
		var tb1_array = ['english', 'furigana', 'name' ,'postal', 'prefecture', 'city', 'address', 'tel', 'mobile', 'mail1', 'mail2', 'bank', 'branch', 'number', 'instrument', 'genre', 'website'];
		var tb2_array = ['responsible', 'image'];
		var textarea_array = ['major', 'specialty_genre', 'educational', 'profile', 'catchphrase', 'keywords', 'description', 'comment', 'license', 'product', 'demo'];


		if(result[3][result[2]]['employment'] == '講師'){
			$('.controll').before(result[5]);
		}else{
			
		}


		$('#prev').empty().append('<input type="button" id="prevBtn" value="前へ" />');
		$('#next').empty().append('<input type="button" id="nextBtn" value="次へ" />');
		if(result[0] == 1){
			$('#prev').empty().append('<input type="button" value="" />');
		}
		if(result[0] == 2){
			$('#next').empty().append('<input type="button" value="" />');
		}

		$('#listSelect option:eq(3)').attr('selected', 'selected');
		//$('select option').attr('selected', false);
		$('select').val(result[1]);
		$('#workersId').val(result[1]);

		$(".workersTable:eq(0) input[name='work']").val([result[3][result[2]]['work']]);
		$(".workersTable:eq(0) input[name='employment']").val([result[3][result[2]]['employment']]);
		
 
		contentsCheckBox('course', course_array.length);
		contentsCheckBox('days', days_array.length);


		for(var i = 0; i < tb1_array.length; i++){
			$('.workersTable:eq(0) input').eq(i+7).val(result[3][result[2]][tb1_array[i]]);
		}
		for(var i = 0; i < tb2_array.length; i++){
			$('.workersTable:eq(1) input').eq(i).val(result[3][result[2]][tb2_array[i]]);
		}
		for(var i = 0; i < textarea_array.length; i++){
			$('.'+textarea_array[i]+'Td textarea').remove();
			$('.'+textarea_array[i]+'Td').append('<textarea name="'+textarea_array[i]+'">'+result[3][result[2]][textarea_array[i]]+'</textarea>');
		}
		autosize(document.querySelectorAll('textarea'));
		JsonWorkers('#prevBtn', jsonUrl);
		JsonWorkers('#nextBtn', jsonUrl);
		JsonCourse();
		JsonCourseAdd();
		
		
		function contentsCheckBox(a, b){
			$('#'+a+' input').prop('checked', false); //アイテムを全部checkedはずす
			for(var i = 0; i < b; i++){
				if(a == 'course') var idx = result[3][result[2]][a].indexOf(course_array[i]);
				if(a == 'days') var idx = result[3][result[2]][a].indexOf(days_array[i]);
				if(idx != -1) $('#'+a+' input:eq('+i+')').prop("checked",true);
			}
		}
		
			
	}
	
}



/*  ----- 講師・演奏者一覧の表示設定 -----  */
function JsonWorkersListDetail(a, b){
	$(a).dblclick(function(){
		var index = $(this).index();
		var id = $('table tbody tr:eq('+index+') input[name="indexID"]').val();
		$.post(b, {indexID:id}, ContentWorkersListModal, 'json');
	});
}

function ContentWorkersListModal(result){

	var color = '';
	if(result['array'][0]['employment'] == '講師') color = 'ff3300';
	if(result['array'][0]['employment'] == '外部') color = '0066cc';
	if(result['array'][0]['employment'] == 'スタッフ') color = 'ff9900';

	var array = [result['array'][0]['ID'], '<span style="color:#'+color+'">'+result['array'][0]['employment']+'<span>', result['array'][0]['furigana'], result['array'][0]['name'] ,
				'〒'+result['array'][0]['postal']+' '+result['array'][0]['prefecture']+result['array'][0]['city']+' '+result['array'][0]['address'], 
				result['array'][0]['tel'], result['array'][0]['mobile'], 
				'<a href="mailto:'+result['array'][0]['mail1']+'">'+result['array'][0]['mail1']+'</a>', '<a href="mailto:'+result['array'][0]['mail2']+'">'+result['array'][0]['mail2']+'</a>', 
				result['array'][0]['bank'], result['array'][0]['branch'], result['array'][0]['number'], result['array'][0]['instrument'], result['array'][0]['igenre'], 
				'<a href="'+result['array'][0]['website']+'" target="_blank">'+result['array'][0]['website']+'</a>'];

	$('#modalContens table td').each(function(i){
		$('#modalContens table td').eq(i).append(array[i]);
	});

	var contentTxt = $('#modalContens').html();
	$('body').prepend('<div id="overlay"><div id="popupContens" class="clearfix">'+contentTxt+'</div></div>');
	var documentH=$(document).height();
	$('#overlay').fadeIn();
	$('#popupContens').css({'animation':'bigEntrance 1.6s ease-out 1'});
	var height = $('#popupContens').height();

	if(height < $(window).height()){
		$('#overlay').css({'height':'100vh'});
	}else{
		$('#overlay').css({'height':100+height+200});
	}

	$('#modal_cancel, #closeImg').click(function(){
		$('#popupContens').css({'animation':'bigEntranceR 1.6s ease-out 1'});
		$('#overlay').fadeOut(function(){
			$('#overlay, #popupContens').remove();
			$('#modalContens table td').empty();
		}),300;
	});
}




