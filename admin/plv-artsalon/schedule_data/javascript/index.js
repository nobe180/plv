$(function(){
	DatePicker_();
	ListNew();
	hoverMinute();
});
var url = 'php/data.php';

function DatePicker_(){
	$.datepicker.setDefaults($.datepicker.regional["ja"]);
	$('.datepicker').datepicker({
		showMonthAfterYear: true,
		dateFormat: 'yy-m-d',  
		monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
		dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
	});
	
	$('#fixedTerm').change(function(){
		var val = $(this).val();
		window.location.href = '?id='+val.split('-').join('/');
	});
}

/*---------------キャプション表示用---------------*/
function hoverMinute(){
	$('.Schedule td').hover(function () {
        $('.caption', this).stop().fadeIn('fast');
    }, function () {
        $('.caption', this).stop().fadeOut('fast');
    });
}


/*---------------新規登録用---------------*/
function ListNew(){
	$('.Schedule td').click(function(e){
		var obj= {};
		var class_ = $(this).attr('class').split(' ');
		obj['schedule_id'] = 0;
		if ($(this).hasClass('on')){
			obj['schedule_id'] = 1;
			obj['data_id'] = class_[2].replace('data', '');
		}
		obj['minute'] = $('.caption', this).text().replace(' 分', '');
		obj['hour'] = class_[0];
		obj['index'] = $(this).parents('table').attr('id');
		obj['target_date'] = $('#weekData').val();
		$.post(url, obj, Modal, 'json');
		e.stoppropagation();
	});
}


//部門の配列
var department = Array('live', 'rental', 'bar', 'lesson', 'session');
var department_txt = Array('ライブハウス', 'レンタル', 'バータイム', 'レッスン', 'セッション');
/*---------------詳細モーダルウィンドウ用---------------*/
function Modal(result){
	//alert(result['target_day']);
	
	if(result['page'] == 'new'){
		$('#conf').attr('id', 'conf_new');
		$('#saveImg').attr('id', 'saveImg_new');

		var department_content = '';
		for(var i = 0; i < department.length; i++){
			department_content += '<label class="check_design radio_box"><input type="radio" name="department" value="'+(i+1)+'" /><span class="lever">'+department_txt[i]+'</span></label>　　';
		}

		var array = [
					department_content,
					'<input type="text" name="company" value="" />',
					'<input type="text" name="name" value="" />',
					'<label><input type="radio" name="sex"  value="男性" />男性</label>　<label><input type="radio" name="sex" value="女性" />女性</label>',
					'郵便番号　：　<input type="text" name="postal" id="postal" class="postal" value="" /><br />\
					町域まで　：　<input type="text" name="prefecture"  id="prefecture" class="address"  value="" /><br />\
					　番地号　：　<input type="text" name="city" class="address" value="" /><br />\
					建物名等　：　<input type="text" name="address" class="address" value="" />',
					'<input type="text" name="tel" value="" />',
					'<input type="text" name="mail" value="" />',
					'<input type="text" class="datepicker" name="date" value="'+result['target_day']+'" />',
					'<select name="start_hour"></select> ： <select name="start_minute"></select>',
					'<select name="end_hour"></select>： <select name="end_minute"></select>',
					'<input type="text" name="price" value="" />',
					'<input type="text" name="time_" value="" />',
					'<input type="text" name="price_" value="" />',
					'<input type="text" name="title" value="" />',
					'<form method="POST" enctype="multipart/form-data" id="file_upload_form">\
						<input type="file" name="file">\
						<input type="button" id="fileup" value="イメージをアップロードする"><span>※ 推奨比率画像4：3（320×240）及び1MB以内</span>\
						<div class="sample_image"></div>\
					</form>',
					'<textarea name="memo"></textarea>',
					'<input type="text" name="registration_date" value="'+result['today']+'" disabled="disabled" />'];
	}else{
		$('#conf_new').attr('id', 'conf');
		$('#saveImg_new').attr('id', 'saveImg');

		var department_content = '';
		for(var i = 0; i < department.length; i++){
			var checked = '';
			if(result['schedule'][0]['department'] == (i+1)) checked = 'checked';
			department_content += '<label class="check_design radio_box"><input type="radio" name="department" value="'+(i+1)+'" '+checked+' /><span class="lever">'+department_txt[i]+'</span></label>　　';
		}

		if(result['schedule'][0]['sex'] == '男性') var checked_sex1 = 'checked';
		if(result['schedule'][0]['sex'] == '女性') var checked_sex2 = 'checked';

		var image = '';
		if(result['schedule'][0]['image'] != ''){
			image = '<img src="upload_file/'+result['schedule'][0]['image']+'" /><input type="hidden" name="image" value="'+result['schedule'][0]['image']+'" />';
		}
		
		var array = [
					department_content,
					'<input type="text" name="company" value="'+result['schedule'][0]['company']+'" />',
					'<input type="text" name="name" value="'+result['schedule'][0]['name']+'" />',
					'<label><input type="radio" name="sex"  value="男性" '+checked_sex1+' />男性</label>　<label><input type="radio" name="sex" value="女性" '+checked_sex2+' />女性</label>',
					'郵便番号　：　<input type="text" name="postal" id="postal" class="postal" value="'+result['schedule'][0]['postal']+'" /><br />\
					町域まで　：　<input type="text" name="prefecture"  id="prefecture" class="address"  value="'+result['schedule'][0]['prefecture']+'" /><br />\
					　番地号　：　<input type="text" name="city" class="address" value="'+result['schedule'][0]['city']+'" /><br />\
					建物名等　：　<input type="text" name="address" class="address" value="'+result['schedule'][0]['address']+'" />',
					'<input type="text" name="tel" value="'+result['schedule'][0]['tel']+'" />',
					'<input type="text" name="mail" value="'+result['schedule'][0]['mail']+'" />',
					'<input type="text" class="datepicker" name="date" value="'+result['schedule'][0]['date_']+'" />',
					'<select name="start_hour"></select> ： <select name="start_minute"></select>',
					'<select name="end_hour"></select>： <select name="end_minute"></select>',
					'<input type="text" name="price" value="'+result['schedule'][0]['price']+'" />',
					'<input type="text" name="time_" value="'+result['schedule'][0]['time_']+'" />',
					'<input type="text" name="price_" value="'+result['schedule'][0]['price_']+'" />',
					'<input type="text" name="title" value="'+result['schedule'][0]['title']+'" />',
					'<form method="POST" enctype="multipart/form-data" id="file_upload_form">\
						<input type="file" name="file">\
						<input type="button" id="fileup" value="イメージをアップロードする"><span>※ 推奨比率画像4：3（320×240）及び1MB以内</span>\
						<div class="sample_image">'+image+'</div>\
					</form>',
					'<textarea name="memo">'+result['schedule'][0]['memo']+'</textarea>',
					'<input type="text" name="registration_date" value="'+result['schedule'][0]['registration_date']+'" disabled="disabled" />\
					<input type="hidden" name="schedule_ID" value="'+result['schedule'][0]['ID']+'">'];	
		
	}

	$('#modal table td').each(function(i){
		$('#modal table td').eq(i).append(array[i]);
	});

	var contentTxt = $('#modal').html();
	$('body').prepend('<div id="overlay"></div><div id="popupContents" class="clearfix">'+contentTxt+'</div>');
	if(result['page'] == 'modify') $('#popupContents .control').append('<input type="button" id="delete" name="'+result['schedule'][0]['ID']+'" value="削除" class="btn" />');

	$('#overlay').fadeIn();
	var t = $(document).scrollTop()+150;
	$('#popupContents').css({'animation':'bigEntrance 1.6s ease-out 1', 'top':t+'px'});
	autosize(document.querySelectorAll('textarea'));
	
	$('#postcode1').jpostal({postcode:['#postal'], address:{'#prefecture':'%3%4%5'}});

	

	if(result['flag'] == 1){
		var start = result['schedule'][0]['start_time'].split(':');
		var end = result['schedule'][0]['end_time'].split(':');
	}else{
		var start = result['target_time'].split(':');
		var end = '00:00'.split(':');
	}

	//alert('start= '+start[0]+'　　end= '+end[0]);
		var before_hour = 10;//開始時間
		var after_hour = 23;//終了時間
		var before_minute = 0;
		var after_minute = 55;
		if(result['before_schedule'] != 0){
			before = result['before_schedule'].split(':');
			before_hour = before[0];
			before_minute = before[1];
		}
		
		if(result['after_schedule'] != 0){
			after = result['after_schedule'].split(':');
			after_hour = after[0];
			after_minute = after[1];
		}
	
		//after = result['after_schedule'].split(':');
		//alert('before= '+before_hour+'　　after= '+after_hour);
		//alert('before= '+before_minute+'　　after= '+after_minute);
	changeSelectDefault1(before_hour, after_hour, start[0], '[name="start_hour"]', before_minute, after_minute, result['flag'], 'start');
	changeSelectDefault1(before_hour, after_hour, end[0], '[name="end_hour"]', before_minute, after_minute, result['flag'], 'end');
	changeSelectDefault2(before_minute, start[1], '[name="start_minute"]', result['flag'], 'start');
	changeSelectDefault2(before_minute, end[1], '[name="end_minute"]', result['flag'], 'end');
	
	$('#modal_cancel, #closeImg').click(function(){
	
		ModalClose();
		
	});
	
	DatePicker_();
	FileUpload();
	jsonUrl = 'php/registration.php';
	JsonSave('#conf', jsonUrl);
	JsonSave('#saveImg', jsonUrl);
	JsonSave('#conf_new', jsonUrl);
	JsonSave('#saveImg_new', jsonUrl);
	JsonDel('#delete', jsonUrl)
}


/*---------------ファイルアップロード用---------------*/
function FileUpload(){
	$('#fileup').click(function(e){
		var fd = new FormData();
		if ($('input[name="file"]').val()!== '') {
			fd.append('file', $('input[name="file"]').prop('files')[0]);
		}
		fd.append('dir', $('#hoge').val());
		var postData = {
						type : 'POST',
						dataType : 'text',
						data : fd,
						processData : false,
						contentType : false
						};
		$.ajax('php/file_upload.php', postData).done(function(data_imege){
			data_imege = data_imege.replace(/\r?\n/g, '').split('"').join('');
			$('.sample_image').empty().append('<img src="upload_file/'+data_imege+'" /><input type="hidden" name="image" value="'+data_imege+'" />');
		});
	});
}



/*---------------モーダルウィンドウ閉じる用---------------*/
function ModalClose(result){
	
	$('#popupContents').css({'animation':'bigEntranceR 1.6s ease-out 1'});
	$('#overlay').fadeOut(function(){
		$('#overlay, #popupContents').remove();
		$('#modal table td').empty();
		location.reload();
	}),300;
}


/*---------------削除用---------------*/
function JsonDel(a, b){
	$(a).click(function(e){
        var obj = {};
		obj['idname'] = 'delete';
		obj['del_ID'] = $(this).attr('name');
		$.post(b, obj, SaveCompletion, 'json');
		e.stoppropagation();
	});
}


/*---------------登録用---------------*/
function JsonSave(a, b){
	$(a).click(function(e){
		var flag = 0;
        var obj = {};

		obj['idname'] = 'modify';
		if(a == '#conf_new' || a == '#saveImg_new' ) obj['idname'] = 'upload';
		$('#popupContents input, #popupContents textarea, #popupContents select').each(function(){
			obj[$(this).attr('name')] = $(this).val();
		});

		obj['name'] = obj['name'].replace('　', ' ');
		obj['sex'] = $('input[name="sex"]:checked').val();
		obj['department'] = $('input[name="department"]:checked').val();
		obj['saveName'] = $(this).attr('id');

		if(obj['department'] != 1 && obj['department'] != 2 && obj['department'] != 3 && obj['department'] != 4 && obj['department'] != 5) flag = 1; var error = 'カテゴリーを選択してください。';
		if(obj['end_hour'] == 'なし' || obj['end_minute'] == 'なし') flag = 1; var error = '終了時間を選択してください。';

		if (flag != 0){
			alert(error);
		}else{
			$.post(b, obj, SaveCompletion, 'json');
		}
		e.stoppropagation();
	});
}



function SaveCompletion() {
	ModalClose();
}





function changeSelectDefault2(a, target, c, flag, b){
	var valSubSel = '';
	//if(flag == 0 && b == 'end') valSubSel = '<option value="なし" selected>選択</option>';
	for(var i = Number(a); i <= 55 ; i += 5){
		var selected = '';
		//if(flag != 0 && b != 'end') {
			if(i == target) selected = ' selected';
		//}
		valSubSel += '<option value="'+('0'+i).slice(-2)+'"'+selected+'>'+('0'+i).slice(-2)+'</option>';
	}
	$(c).empty().append(valSubSel);
}

function changeSelectDefault1(a, b, target, c, d, e, flag, f){
	var valSubSel = '';
	//if(flag == 0 && f == 'end') valSubSel = '<option value="なし" selected>選択</option>';
	for(var i = a; i <= b ; i++){
		var selected = '';
		//if(flag != 0 && f != 'end') {
			if(i == target) selected = ' selected';
		//}
		valSubSel += '<option value="'+i+'"'+selected+'>'+i+'</option>';
	}
	$(c).empty().append(valSubSel);
	hourChange('[name="start_hour"]', b, d, e, '[name="start_minute"]', a);
	hourChange('[name="end_hour"]', b, d, e, '[name="end_minute"]', a);
	//hourChange('[name="start_hour"]', a, b, e, '[name="start_minute"]', a);
	//hourChange('[name="end_hour"]', a, b, e, '[name="end_minute"]', a);
}

function hourChange(a, b, c, d, e, f){
	$(a).change(function(){
		var val = $(this).val();
		//alert(b);
		//alert('b='+b+' c='+c+' d='+d+' f='+f);
		if(val == b){
			change(Number(c), Number(d), e);
		}else{
			change(0, 55, e);
		}
	});
}	
	
function change(num1, num2, select){
	//alert('num1='+num1+' num2='+num2);
	var valSubSel = '';
	for(var i = num1; i <= num2; i += 5){
		valSubSel += '<option value="'+('0'+i).slice(-2)+'">'+('0'+i).slice(-2)+'</option>';
	}
	$(select).empty().append(valSubSel);
}
