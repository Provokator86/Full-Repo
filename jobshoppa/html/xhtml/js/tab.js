// JavaScript Document
$(document).ready(function() {
		$("#category ul li a").click(function() {
		
		   $( '#category ul li a').each(function(){
			 $('#category ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show();
		});
  });

$(document).ready(function() {
		$(".tab_box ul li a").click(function() {
		
		   $( '.tab_box ul li a').each(function(){
			 $('.tab_box ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).slideUp();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).slideDown();
		});
  });