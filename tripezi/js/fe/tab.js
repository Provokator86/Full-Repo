$(document).ready(function() {
	/*var index = 0;
	$('.tab-details > div.details').hide();
	$('.tab-details > div.details').filter(':eq(' + index + ')').fadeIn('slow');*/
	
	$(".tab-content ul li a").click(function() {
		$('.tab-content ul li a').removeClass();
		$(this).addClass('select');
		var index = $('.tab-content ul li a').index($(this));
		$('.tab-details > div.details').slideUp();
		$('.tab-details > div.details').filter(':eq(' + index + ')').fadeIn('slow');
  	});
});


