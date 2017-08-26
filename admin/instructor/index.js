$(function(){
	/* -------------- SP用メニュー -------------- */
	$('.btn-menu').click(function () {
		$('.btn-menu').toggleClass('is-open');
		$('header ul').slideToggle();
		return false;
	});
});
