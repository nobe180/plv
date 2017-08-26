$(function(){
	del();
	add();
	$('.faq_box').css('display', 'none');
	puldown();
	faq_title_add();
	faq_title_del();
});

function add(){
	$('.add_btn').on('click', function(){
		var obj= {};
		obj['index']= 'add';
		class_ = $(this).parents('div').attr('class');
		target_class = class_.split(' ');
		target = target_class[1].split('_');
		flag_no = target_class[1].slice(-1);
		no = $('.'+target_class[1]+' table tr').length/2;
		obj['flag_no'] = target[2];
		$.post('json_check.php', obj, function(result){
			var del_txt = '<input type="submit" name="'+result['new']+'_'+target[2]+'" value="削除" class="del" />';
			var txt = '<tr><th rowspan="2">質問<span class="del_num">'+(no+1)+'</span>'+del_txt+'</th><td class="blue">Q</td><td><textarea name="Q_'+result['new']+'" class="q_txt"></textarea></td></tr><tr><td class="red">A</td><td><textarea name="A_'+result['new']+'"></textarea></td></tr>';
			$('.'+target_class[1]+' table').append(txt);
			del();
			autosize(document.querySelectorAll('textarea'));
		}, 'json');
	});

}





function del(){
	$('.faq_box table .del').on('click', function(){
		var obj= {};
		obj['index']= 'del';
		obj['del_ID'] = $(this).attr('name');
		index = $(this).parent().parent().attr('class');
		index_ = $(this).parent().parent().parent().parent().parent().attr('class');
		target_class = index_.split(' ');
	
		$.post('json_check.php', obj, function(result){
			var tag ='table.faq .'+index;
			var del_index = $(tag).index();
			var tag ='.'+target_class[1]+' table tr:eq('+del_index+')';
			$(tag).remove();
			$(tag).remove();
			var len = $('.'+target_class[1]+' .del').length;
			
			if(len == 0){
				$('.'+target_class[1]).prev('dl').remove();
				$('.'+target_class[1]).remove();
			}
			for(var i = 0; i < len; i++){
				$('.'+target_class[1]+' span.del_num:eq('+i+')').empty().append(i+1);
			}
			autosize(document.querySelectorAll('textarea'));
		}, 'json');
	});
}




function faq_title_add(){
	$('.faq_add_btn').on('click', function(){
		//クリックイベント削除
		$('#container .contents_data dl.faq_title_box dt:nth-of-type(1)').unbind('click');
		var obj= {};
		obj['index'] = 'faq_title_add';
		obj['new_sort'] = parseInt($('dl.faq_title_box:last dt:eq(1) input').val())+1;
		new_sort = obj['new_sort'];

		$.post('json_check.php', obj, function(result){
			var new_faq_title = '<dl class="faq_title_box"><dt></dt><dt><input type="text" name="sort'+new_sort+'" value="'+new_sort+'" class="sort"></dt><dd><input type="text" class="faq_title" name="" value=""></dd><dt>削除</dt></dl>';

			var new_faq_list = '<div class="faq_box flag_faq_'+new_sort+'"><table class="faq"><tr class="faq_'+new_sort+'_1"><th rowspan="2">質問<span class="del_num">1</span><input type="submit" name="'+result['new']+'" value="削除" class="del"></th><td class="blue">Q</td><td><textarea name="Q_'+new_sort+'_1" class="q_txt"></textarea></td></tr><tr><td class="red">A</td><td><textarea name="A_13_1" ></textarea></td></tr></table><div class="add_btn">追加</div></div>';

			var index = parseInt($('[name="faq_title_index"]').val());
			$('[name="faq_title_index"]').val(index+1);
			$('.faq_add_btn').before(new_faq_title+new_faq_list);
			$('.faq_box').css('display', 'none');
			add();
			del();
			puldown();
			faq_title_del();
			autosize(document.querySelectorAll('textarea'));
		}, 'json');
	});
}



function faq_title_del(){
	var id = '#container .contents_data dl.faq_title_box';
	$(id+' dt:nth-of-type(3)').on('click', function(){
		var obj= {};
		obj['index'] = 'faq_title_del';
		index = $(id+' dt:nth-of-type(3)').index(this);
		obj['flag'] = $(id+':eq('+index+') dt:eq(1) input').val();
		obj['flag_name'] = $(id+':eq('+index+') dd input').val();

		index = $(id+':eq('+index+')').next().attr('class');
		target_class = index.split(' ');
		if (!confirm('FAQを削除します\nよろしいですか？')) {
			return false;
		}
		$.post('json_check.php', obj, function(result){
			$('.'+target_class[1]).prev('dl').remove();
			$('.'+target_class[1]).remove();
		}, 'json');
	});
}



/* -------------- プルダウン設定 -------------- */
function puldown(){
	var id = '#container .contents_data dl.faq_title_box';
	$(id+' dt:nth-of-type(1)').on('click', function(){
		var index = $(id+' dt:nth-of-type(1)').index(this);
		//alert(index);
		var id2 = id+':eq('+index+')';
		$(id2+' dt:eq(0)').toggleClass('on');
		$('#container .contents_data .faq_box:eq('+index+')').slideToggle(function(){
			autosize(document.querySelectorAll('textarea'));
		});
		
	});
}