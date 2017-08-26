$(function(){
	$('header ul li').each(function(){
		var id = $(this).attr('id');
		json('#'+id, 'json_check.php');
	});
});

function json(a,b){
	$(a).click(function(){
		var txt=$(this).text();
		var idname=$(this).attr('id');
		$.post(b,{txt:txt, idname:idname}, function(result){
				$('#container h1').empty().append(result[0]);
				$('#container article').empty().append(result[1]);
				$('#postcode1').jpostal({postcode:['#postal'], address:{'#prefecture':'%3%4%5'}});
		}, 'json');
	});
}
