$(function(){
	
	$.datepicker.setDefaults($.datepicker.regional["ja"]);
	$('.datepicker').datepicker({dateFormat:'yy年mm月dd日'});
	autosize(document.querySelectorAll('textarea'));
});