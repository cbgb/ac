$(document).ready(function() {

	//forms adjustment
	$('.formWrapper input:submit')
		.addClass('ui-state-default ui-corner-all');
	$('select, :text, :password')
		.addClass('ui-widget-content ui-corner-all');

	//hover effect on actives
	$('.ui-state-default').hover(function() {
		$(this).addClass('ui-state-hover');
	}, function() {
		$(this).removeClass('ui-state-hover');
	});

	//first input field focus
	$('input:visible:enabled:first').focus();

});
