// JavaScript Document

/************top select box*************/
$(document).ready(function() {
 




/*------------------------------FAQ part ----------------------------------------------*/

/*$('.faq_contant').hide();
$('.faq_heading').click(function(){
		if( $(this).parents('.main_faq').find(".faq_contant" ).css('display') == 'none' ) {
			$(this).parents('.main_faq').find(".faq_contant" ).slideDown('slow');
		}
		else {
			$(this).parents('.main_faq').find(".faq_contant" ).slideUp('slow');
		}
		var class_selected = $(this).attr('class');
		if( class_selected=='faq_heading sel' )
			$(this).removeClass("sel");
		else
			$(this).addClass("sel");
	});*/




	$('.faq_contant').hide();
	$('.faq_heading').click(function(){
		if( $(this).parents('.main_faq').find(".faq_contant" ).css('display') == 'none' ) {
			$('.faq_contant').slideUp('slow');
			$('.faq_heading').removeClass("sel");
			$(this).parents('.main_faq').find(".faq_contant" ).slideDown('slow');
			$(this).addClass("sel");
		}
		else {
			$(this).parents('.main_faq').find(".faq_contant" ).slideUp('slow');
			$(this).removeClass("sel");
		}
		/*var class_selected = $(this).attr('class');
		if( class_selected=='faq_heading sel' )
			$(this).removeClass("sel");
		else
			$(this).addClass("sel");*/
	});
	
	
	
	
	
	/*$('.faq_heading').each(function(i){
		$('.faq_contant').hide();
		$('.faq_heading').click(function(){
			$('.faq_contant').slideUp('slow');
			$(this).parent('.main_faq').find('.faq_contant').slideDown('slow');				   
		})
		//$('.faq_contant').slideDown('slow');
		if( $(this).parents('.main_faq').find(".faq_contant" ).css('display') == 'none' ) {
			$(this).parents('.main_faq').find(".faq_contant" ).slideDown('slow');
		}
		else {
			$(this).parents('.main_faq').find(".faq_contant" ).slideUp('slow');
		}
		var class_selected = $(this).attr('class');
		if( class_selected=='faq_heading sel' )
			$(this).removeClass("sel");
		else
			$(this).addClass("sel");
	});
	*/
/*------------------------------FAQ part end ----------------------------------------------*/





});





