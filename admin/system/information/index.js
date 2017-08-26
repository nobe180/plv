$(function(){
	$('header ul li').each(function(){
		var id = $(this).attr('id');
		json('#'+id, '../json_check.php');
	});
	
	
	$('[name=info]').change(function(){
		var val = $(this).val();
		var ary = ['news', 'blog', 'plv', 'ppc'];

		for(var i = 0; i < ary.length; i++){
			if ($('.info_'+ary[i]).css('display') == 'block'){
				var now = ary[i];
			}
		}
		$('.info_'+now).fadeOut(function(){
			$('.info_'+ary[val]).fadeIn();
			$('#refine_select a').attr('href', 'update/?ID='+val);
			location.hash = '#ID='+val;
		});
		
	});	
});

function json(a,b){
	$(a).click(function(){
		var txt=$(this).text();
		var idname=$(this).attr('id');
		$.post(b,{txt:txt, idname:idname}, function(result){
				$('#container h1').empty().append(result[0]);
				$('#container article').empty().append(result[1]);
		}, 'json');
	});
}

function getParam(){
	var url=location.href;
	parameters=url.split("?");
	params=parameters[1].split("&");
	var paramsArray=[];
	for(i=0;i<params.length;i++){
		neet=params[i].split("=");
		paramsArray.push(neet[0]);
		paramsArray[neet[0]] = neet[1];
	}
	var categoryKey = paramsArray["ID"];
	$("#"+categoryKey+' table td').css({"background-color":"#000000 !important","color":"#ffffff"});
	return categoryKey;
}