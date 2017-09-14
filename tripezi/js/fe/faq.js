(function($){    
$(document).ready(function()
{

	$(".firstpane div.menu-head").css({background:"url(images/fe/next.png) no-repeat right 8px"});
 
 	$(".firstpane div.menu-head").click(function() {
	
		$(".firstpane div.menu-head").css({background:"url(images/fe/next.png) no-repeat right 8px"})
		
		if(($(this).next().css('display'))=='none') {
			$(this).css({background:"url(images/fe/down.png) no-repeat right 8px"});
		}
		else {
			$(this).css({background:"url(images/fe/next.png) no-repeat right 8px"});
		}
		
  		$(this).next("div.menu-body-faq").slideToggle(300).siblings("div.menu-body-faq").slideUp("slow");
		
		/*if( $(this).siblings("div.menu_head").css('backgroundImage') == 'images/next.png' ) {
        	
		}
		else {
			
		}*/
	});
 
});
})(jQuery); 
