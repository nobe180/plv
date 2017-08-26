var JsonUrl = '/admin/instructor/reservation/json_check.php';

$(function(){
	instructor_id = $('[name=instructor_id]').val();
	year_month = $('[name=year_month]').val();
	MySchedule(year_month);
	
	
	
	$('#month_register').click(function(){
		var checked = $('input[name="month_all"]:checked').val();
		var count = $('.fc-body thead .fc-mon:not(.fc-other-month)').length; //月曜日の数
		var test = $('.fc-body thead .fc-mon:not(.fc-other-month)').eq(1).text().replace(/●/g,'');
		//月曜日の日にちを取得
		//var days = [];
		var txt ='';
		var days = '';
		for(var i = 0; i <count; i++){
			txt = $('.fc-body thead .fc-mon:not(.fc-other-month)').eq(i).text().replace(/●/g,'');
			if(txt <= 28){
				//days.push(txt);
				days += txt+'、';
			}
		}
		var default_day = '0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21';
		if(checked == '0') default_day = '';
		
		year_month = $('[name=year_month]').val();

		if(checked == '1' || checked == '0'){ 
			$.post(JsonUrl, {index:'all', instructor_id:instructor_id, year_month:year_month, day:days, default_day:default_day, month_all:checked}, function(result){
				//$('#test').empty().append(result['test']);
				$('#content').empty().append('<div id="calendar"></div>');
				MySchedule(result['year_month']);
			}, 'json');
		}
	});

	
	
	
});

function Run(str){
	$('#calendar').fullCalendar({
		lang: 'ja',
		theme: true,
		header: {
			left: 'prev', center: 'title', right: 'next'
	},defaultDate: str});
	ScheduleDate();
	MonthChange('.fc-left');
	MonthChange('.fc-right');
}


/*  ----- 月変更後処理-----  */
function MonthChange(a){
	$(a).click(function(){
		var str = $('.fc-center h2').html().replace(/年 /g,'-').replace(/月/g,'').split('-');
		var year_month = str[0]+'-'+keta(str[1]);
		$('[name=year_month]').val(year_month);
		$('#content').empty().append('<div id="calendar"></div>');
		MySchedule(year_month);
	});
}

/*  ----- スケジュールクリック処理 -----  */
//txt = $('.fc-body thead .fc-mon:not(.fc-other-month)').eq(i).text().replace(/●/g,'');
function ScheduleDate(){
	$('td.fc-day-number:not(.fc-other-month, .fc-mon)').click(function(e){
			var year_month_txt = $('.fc-center h2').html().replace(/年 /g,' 年 ').replace(/月/g,' 月 ');
			var day = $(this).text().replace(/●/g,'');
			var year_month = $('[name=year_month]').val();
			$('#modal h2').empty().append(year_month_txt+''+day+' 日');
			$.post(JsonUrl, {instructor_id:instructor_id, year_month:year_month, day:day}, Modal, 'json');
			e.stoppropagation();
	});
}

/*  ----- ポップアップ用-----  */
function Modal(result){
	
	if(result['lesson_member']){
		//$('#test').empty().append(result['test']);
	}

	//*  ----- フェードイン-----  */
	var contentTxt = $('#modal').html();
	$('body').prepend('<div id="overlay"></div><div id="popupContents" class="clearfix">'+contentTxt+'</div>');
	var documentH = $(document).height();
	$('#overlay').fadeIn();
	var ScrTop = $(document).scrollTop()+50;
	$('#popupContents').css({'animation':'bigEntrance 1.6s ease-out 1', 'top':ScrTop+'px'});
	var j = 0;
	var t = 0;
	/*  ----- 登録してる時間取得-----  */
	if(result['index'] == 'update'){
		var day = result['my_schedule'][0][result['day']];
		if(day){
			var time_array = day.split(',');
			for(var i = 0; i < time_array.length; i++){
				var change_no = time_array[i].replace(/_/g, '')
				if(time_array[i].indexOf('_') != -1){
					
					text = '<input type="checkbox" class="no" name="time" id="s'+change_no+'" value="'+change_no+'" checked OnClick="return false"><label for="s'+change_no+'" class="true">'+result['lesson_member'][j]+'</label>';
					if(t == 1){
						t = 0;
						j++;
					}else{
						t++;
					}
					
				}else{
					//$('#popupContents tr:eq('+time_array[i]+') td input[type="checkbox"] ').prop('checked', true);
					text = '<input type="checkbox" name="time" id="s'+change_no+'" value="'+change_no+'" checked><label for="s'+change_no+'"></label>';
				}
				$('#popupContents tr:eq('+change_no+') td').empty().append(text);
				text = '';
			}
		}
	}

	AllCheck();

	/*  ----- 登録-----  */
	$('.register').click(function(){
		year_month = $('[name=year_month]').val();
		var time_records = '';
		$('[name="time"]:checked').map(function() {
   			var val_ = $(this).val()+',';
			if($(this).attr('class')){
				var val_ = $(this).val()+'_,';
			}
 			time_records += val_;
		});
		time_records = time_records.substr(0, time_records.length-1); //末尾を削除
		
		$.post(JsonUrl, {index:result['index'], instructor_id:instructor_id, year_month:year_month, day:result['day'], time_records:time_records}, ModalClose, 'json');
	});
	/*  ----- キャンセル-----  */
	$('#cancel, #closeImg').click(function(){
		ModalClose();
	});

}

function ModalClose(result){
	//$('#test').empty().append(result['test']);
	$('#popupContents').css({'animation':'bigEntranceR 1.6s ease-out 1'});
	$('#overlay').fadeOut(function(){
		$('#overlay, #popupContents').remove();
	}),300;
	year_month = $('[name=year_month]').val();
	$('#content').empty().append('<div id="calendar"></div>');
	MySchedule(year_month);
}


/*  ----- スケジュール呼び出し-----  */
function MySchedule(str){

		Run(str);
		$.post(JsonUrl ,{instructor_id:instructor_id, year_month:str}, function(result){
			var my_month = result['my_schedule'][0]['month'];
			var txt = $('.fc-unselectable').html();
	
			for(var i = 0; i <= 31; i++){
				if(result['my_schedule'][0][(i)] != ''){
					txt = txt.replace(new RegExp('data-date="'+my_month+'-'+keta((i))+'">'+(i)+"<", "g"), 'data-date="'+my_month+'-'+keta((i))+'">'+(i)+"<span class='true'>●</span><");
					$('.fc-unselectable').html(txt);
				}
			}
	
			ScheduleDate();		
		}, 'json');
}


/*  ----- 0埋め設定-----  */
function keta(num){
	var a = num;
	a = ("0" + a).slice(-2);
	return a;
}


/*  ----- チェックボックス全選択-----  */
function AllCheck(){
	$('[name=all]').click(function(){
		if($(this).val() == 1){
			$('#popupContents td input[type="checkbox"]').not('.no').prop('checked', true);
		}else{
			$('#popupContents td input[type="checkbox"]').not('.no').prop('checked', false);
		}
	});
}