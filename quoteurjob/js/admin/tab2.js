// JavaScript Document
$(document).ready(function() {
		$("#tabbar2 ul li a").click(function() {
		
		   $( '#tabbar2 ul li a').each(function(){
			 $('#tabbar2 ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show();
		});
  });