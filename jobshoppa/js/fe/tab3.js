// JavaScript Document
$(document).ready(function() {
		$("#pro_tab ul li a").click(function() {
		
		   $( '#pro_tab ul li a').each(function(){
			 $('#pro_tab ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show();
		});
  });