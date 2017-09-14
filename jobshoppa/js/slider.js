$(document).ready(function(){
$("#con_btn").click(function(){
$("#contact_cont").slideToggle('slow');	
});				  
//For login box	
$("#login").click(function(){
$("#login_cont").show('2000');
$("#login").html('<a href="#">Login</a>  <img  alt="arrow-dn"  src="images/up_arrow.png" />');
});
$(".close_btn").click(function(){
$("#login_cont").hide('2000');
$("#login").html('<a href="#">Login</a> <img  alt="arrow-dn"  src="images/dn_arrow.png" />');
});

//For Tab section
		$("#details_tabing ul li a").click(function() {
		   $( '#details_tabing ul li a').each(function(){
			 $('#details_tabing ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show();
		});

	
	
	
});