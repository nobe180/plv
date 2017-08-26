$(function(){
	autosize(document.querySelectorAll('textarea'));
	var window_h = $(window).height();
	var contents_h = $('#wrapper').height();
	if(contents_h < window_h) $('#wrapper').css('height', '100vh');
	DataSave();
	addBtn();
	midashiAddBtn();
	midashiAddDel();
});

function addBtn(){
	$('.addBtn').click(function(){
		var index = $('div.contents_data .addBtn').index(this);
		var sort = parseInt($('.contents_data:eq('+index+') dl.title_box dt:eq(0) input:eq(1)').val());
		var txt_index =  parseInt($('div.contents_data:eq('+index+') textarea').length);
		if(txt_index == 0){
			$('div.contents_data:eq('+index+') p').before('<textarea name="content'+sort+'_1"></textarea>');
		}else{
			$('div.contents_data:eq('+index+') p').before('<textarea name="content'+sort+'_'+(txt_index+1)+'"></textarea>');
		}
		autosize(document.querySelectorAll('textarea'));
	});
}


function midashiAddBtn(){
	$('.midashi_btn').click(function(){
		//クリックイベント削除
		$('#modify').unbind('click');
		var obj= {};
		var new_sort = parseInt($('.contents_data:last dl.title_box dt:eq(0) input:eq(1)').val())+1;
		var this_ = $(this);
		obj['new_sort'] = new_sort;
		obj['relation'] = $('[name="idname"]').val();
		obj['idname'] = 'midashi_add';
		
		$.post('../common/data_check.php', obj, function(result){
			//$('#test').empty().append(result['test']);
			var new_midashi = '<div class="contents_data clearfix"><dl class="title_box"><dt><input type="hidden" value="'+result['id']+'" /><input type="text" name="sort'+new_sort+'" value="'+new_sort+'" class="sort" /></dt><dd><input type="text" name="title'+new_sort+'" value="" /></dd><dt>削除</dt></dl><textarea name="content'+new_sort+'_1"></textarea><p class="txt_right"><input type="button" value="本文追加" class="addBtn"></p></div>';
			$(this_).before(new_midashi);
			DataSave();
			addBtn();
			midashiAddDel();
			autosize(document.querySelectorAll('textarea'));
		}, 'json');
	});
}

function midashiAddDel(){
	$('div.contents_data dl.title_box dt:nth-of-type(2)').click(function(){
		var obj= {};
		index = $('dl.title_box dt:nth-of-type(2)').index(this);
		obj['del_ID'] = $('div.contents_data:eq('+index+') dl.title_box dt:nth-of-type(1) input:nth-of-type(1)').val();
		obj['idname'] = 'midashi_del';
		if (!confirm('削除します\nよろしいですか？')) {
			return false;
		}
		$.post('../common/data_check.php', obj, function(result){
			$('div.contents_data:eq('+index+')').remove();
			autosize(document.querySelectorAll('textarea'));
		}, 'json');
	});
}




function Completion(result){
	window.location.reload();
	//alert('ok');
	//$('#test').empty().append(result['test']);
}

function DataSave(a,b){
	$('#modify').click(function(){
		var obj = {};
		obj['FAQ'] = {};
		obj['contents'] = {};
		obj['inner_contents'] = {};
		$('input, textarea, input:checked').each(function(){
			obj[this.name] = this.value;
		});
		obj['relation'] = $('#relation').val();
		obj['title_index'] = $('.title_box').length;
		
		var count = 0;
		obj['faq_sort'] = [];
		for(var t = 0; t < obj['faq_title_index']; t++){
			var sort = $('dl.faq_title_box:eq('+t+') dt:eq(1) input').val();
			obj['faq_sort'].push(sort); 
			index = $('.faq_box:eq('+t+') tr').length;
			for(var i = 0; i < index; i += 2){
				var id = $('.faq_box:eq('+t+') tr:eq('+i+') th:eq(0) input').attr('name');
				var title = $('dl.faq_title_box:eq('+t+') dd input').val();
				var q = $('.faq_box:eq('+t+') tr:eq('+i+') td:eq(1) textarea').val();
				var a = $('.faq_box:eq('+t+') tr:eq('+(i+1)+') td:eq(1) textarea').val();
				obj['FAQ']['ID_'+count] = {id: id, sort: sort, title: title, q: q, a: a};
				count++;
			}
		}

		//alert(obj['title_index']);
		obj['sort'] = [];
		var count = 0;
		for(var i = 0; i < obj['title_index']; i++){
			
			var id = $('.title_box:eq('+i+') dt input:eq(0)').val();
			var inner_title = $('.title_box:eq('+i+') dd input').val();
			var sort = $('.title_box:eq('+i+') dt input:eq(1)').val();
			var textarea_index = $('.contents_data:eq('+i+') textarea').length;
			obj['sort'].push(sort);
			obj['inner_contents'][sort] = {};
			var faq_data_index = $('.title_box:eq('+i+')').parent().attr('class');
			if(faq_data_index.indexOf('faq_data') != -1){
				obj['inner_contents'][sort][0] = $('#faq_list_').val();
			}else{
				count2 = 0;
				
				for(var v = 0; v < textarea_index; v++){
					obj['inner_contents'][sort][v] = $('.contents_data:eq('+i+') textarea:eq('+v+')').val();
					count2++;
				}
			}

			obj['contents']['ID_'+count] = {
				id: id, 
				page_title: obj['pagetitle'],
				keywords: obj['keywords'],
				description: obj['description'], 
				contents_title: obj['contents_title'], 
				inner_title: inner_title, 
				inner_contents: obj['inner_contents'], 
				sort: sort, 
				relation: obj['idname']
			};
			count++;
		}

		//FAQ重複チェック
		var faq_overlap = obj['faq_sort'].filter(function (x, i, self) {
            return self.indexOf(x) !== self.lastIndexOf(x);
        });
		
		//重複チェック
		var overlap = obj['sort'].filter(function (x, i, self) {
            return self.indexOf(x) !== self.lastIndexOf(x);
        });
		
		if(overlap == ''){
			if(faq_overlap == ''){
				//alert('重複してません');
				$.post('../common/data_check.php', obj, Completion, 'json');
			}else{
				alert('FAQのソート番号が重複してます');
			}
		}else{
			
			alert('ソート番号が重複してます');
		}
			//alert(obj['idname']);
	});
}