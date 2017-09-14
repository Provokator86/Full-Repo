// When the document loads do everything inside here ...
$(document).ready(function(){
	// When a link is clicked
	$("a.tab1").click(function () {
		
		$(".active1").removeClass("active1");
		
		$(this).addClass("active1");
		// slide all content up
		$(".tsb_text").slideUp();
		
		// slide this content up
		var tsb_text_show = $(this).attr("title");
		$("#"+tsb_text_show).slideDown();
	  
	});

});


// When the document loads do everything inside here ...
$(document).ready(function(){
	// When a link is clicked
	$("a.tab1").click(function () {
		
		$(".active1").removeClass("active1");
		
		$(this).addClass("active1");
		// slide all content up
		$(".tsb_text02").slideUp();
		
		// slide this content up
		var tsb_text_show = $(this).attr("title");
		$("#"+tsb_text_show).slideDown();
	  
	});

});

