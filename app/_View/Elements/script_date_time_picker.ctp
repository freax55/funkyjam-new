$('.dtp').datepicker();
$('#ShopBusinessTimeStart').timepicker({
	minuteStep: 15,
	showSeconds: false,
	showMeridian: false,
	showInputs: false
});
$("#ShopBusinessTimeStart").on("click", function() {
	$(this).timepicker('showWidget');
	$(".dropdown-menu").css('left', '0px');
});

$('#ShopBusinessTimeEnd').timepicker({
	minuteStep: 15,
	showSeconds: false,
	showMeridian: false
});
$("#ShopBusinessTimeEnd").on("click", function() {
	$(this).timepicker('showWidget');
	$(".dropdown-menu").css('left', '130px');
});
