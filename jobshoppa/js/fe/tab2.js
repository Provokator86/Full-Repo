// JavaScript Document
$(document).ready(function() {
		$("#how_tab ul li a").click(function() {
		
		   $( '#how_tab ul li a').each(function(){
			 $('#how_tab ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show();
		});
  });