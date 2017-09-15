
      $(document).ready(function() {
		$(".signin").click(function(e) {          
			e.preventDefault();
			$("div#signin_menu").toggle();
			$(".signin").toggleClass("menu-open");
		});
		
		$("div#signin_menu").mouseup(function() {
			return false
		});
		$(document).mouseup(function(e) {
			if($(e.target).parent("a.signin").length==0) {
				$(".signin").removeClass("menu-open");
				$("div#signin_menu").hide();
			}
		});			
		
	});
	  
