$(function(){
	$('.item p span').on('click', function(){
		var data =$(this).attr('data');
		var index = $(this).parents('div.equipment_list').attr('id');
		$('.eq_img img').eq(index-1).attr('src', 'images/equipment/'+data+'.png');
		$('.eq_img img').error(function(){$(this).attr('src','images/equipment/no_image.png');});
	});
});