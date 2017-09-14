// JavaScript Document
jQuery(function($) {
$(document).ready(function() {
		$("#tabbar ul li a").click(function() {
		
		   $( '#tabbar ul li a').each(function(){
			 $('#tabbar ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide("slow");           
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show("slow");
		});       
        
        $(this).toggle(function(e) {
          alert("First handler for .toggle() called."+e.target.id+" "+currentId);
          
        }, function(e) {
          alert("Second handler for .toggle() called."+e.target.id+" "+currentId);
        });   
        
  })});