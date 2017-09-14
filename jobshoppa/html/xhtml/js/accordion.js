// JavaScript Document
$(document).ready(function () {
	
	$('.accordion li').click(function () {

		//slideup or hide all the Submenu
		$('.accordion li').children('ul').slideUp('slow');	
		
		//remove all the "Over" class, so that the arrow reset to default
		$('.accordion li > a').each(function () {
			if ($(this).attr('rel')!='') {
				$(this).removeClass($(this).attr('rel') + 'Over');	
			}
		});
		
		//show the selected submenu
		$(this).children('ul').slideDown('slow');
		
		//add "Over" class, so that the arrow pointing down
		$(this).children('a').addClass($(this).children('li a').attr('rel') + 'Over');			

	});

});