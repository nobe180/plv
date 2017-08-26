var JsonUrl = '/admin/system/instructor_schedule/json_check.php';

$(function(){
	InstructorChange();
	year_month = $('[name=year_month]').val();
	MySchedule(year_month);
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

/*  ----- 講師の選択処理 -----  */
function InstructorChange(){
	$('select[name=instructor_id]').change(function(){
		$('#content').empty().append('<div id="calendar"></div>');
		year_month = $('[name=year_month]').val();
		MySchedule(year_month);
	});
}


/*  ----- スケジュールクリック処理 -----  */
function ScheduleDate(){
	$('td.fc-day-number:not(.fc-other-month)').click(function(){
		var txt = $(this).text();
		if(txt.indexOf('●') != -1) {
			var year_month_txt = $('.fc-center h2').html().replace(/年 /g,' 年 ').replace(/月/g,' 月 ');
			var day = $(this).text().replace(/●/g,'');
			var year_month = $('[name=year_month]').val();
			var instructor_name = $('[name=instructor_id] option:selected').text();
			$('#modal h2').empty().append(year_month_txt+''+day+' 日');
			$('#instructor_name').empty().append(instructor_name.replace(/　/g,'')+' スケジュール');
			$.post(JsonUrl, {instructor_id:instructor_id, year_month:year_month, day:day}, Modal, 'json');
		}
	});
}




/*  ----- ポップアップ用-----  */
function Modal(result){
	/*  ----- フェードイン-----  */
	var contentTxt = $('#modal').html();
	$('body').prepend('<div id="overlay"></div><div id="popupContents" class="clearfix">'+contentTxt+'</div>');
	var documentH = $(document).height();
	$('#overlay').fadeIn();
	var ScrTop = $(document).scrollTop()+50;
	$('#popupContents').css({'animation':'bigEntrance 1.6s ease-out 1', 'top':ScrTop+'px'});

	/*  ----- 登録してる時間取得-----  */
	var day = result['my_schedule'][0][result['day']];
	if(day){
		var time_array = day.split(',');
		for(var i = 0; i < time_array.length; i++){
			$('#popupContents tr:eq('+time_array[i]+') td').css({'background': '#a1b91d', 'color': '#ffffff'});
		}
	}

	/*  ----- キャンセル-----  */
	$('#cancel, #closeImg').click(function(){
		ModalClose();
	});
}

function ModalClose(result){
	$('#popupContents').css({'animation':'bigEntranceR 1.6s ease-out 1'});
	$('#overlay').fadeOut(function(){
		$('#overlay, #popupContents').remove();
	}),300;
	year_month = $('[name=year_month]').val();
	MySchedule(year_month);
}


/*  ----- スケジュール呼び出し-----  */
function MySchedule(str){
	Run(str);
	year_month = $('[name=year_month]').val();
	instructor_id = $('[name=instructor_id] option:selected').val();
	$.post(JsonUrl ,{instructor_id:instructor_id, year_month:str}, function(result){
		var my_month = year_month;
		var txt = $('.fc-unselectable').html();
		$('#test').empty().append(result['test']);
		for(var i = 0; i <= 28; i++){
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