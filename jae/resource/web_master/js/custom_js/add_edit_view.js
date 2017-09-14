/*** 
* File Name: add_edit_view.js
* Created By: SWI Dev
* Created On: Sept 11, 2017
* Purpose: Add Edit page required javascript code 
*/
// Display error
var is_scroll_initiated = true;

var markAsError = function(selector,msg,animate){
   
    //$(selector).next('.text-danger').html('<i class="fa fa-times-circle-o"></i> '+msg);    
    $(selector).next('.text-danger').html(msg);    
    //$(selector).parents('.form-group').addClass("has-error");
    $(selector).on('focus',function(){
        removeAsError($(this));
    });
    
    // below for dropdown chosen
    $(selector).on('click',function(){
        removeAsError($(this));
    });
    
    if(animate != 'no' && is_scroll_initiated)
    {
        var position_ = 0;
        var offset =  $(selector).offset();
        if(offset)
            position_ = offset.top || 0; 
        $('html, body').animate({scrollTop : position_}, 800);
        is_scroll_initiated = false;
    }   
}

// Hide error
var removeAsError = function(selector){
    $(selector).next('.text-danger').html('');    
    $(selector).parents('.form-group').removeClass("has-error");
    is_scroll_initiated = true;
} 
   
$(document).ready(function(){  
    // Click on cancel button
    $('#btn_cancel').click(function(i){
         window.location.href=g_controller+'show_list/';
    });  

    // Clieck on close button
    $('.btn-close').click(function(i){
         window.location.href=g_controller; 
    });  

    // Click on save button
    $('#btn_save').click(function(){
       //check_duplicate();
       $("#frm_add_edit").submit();
    }); 
    
    //Submitting search all//
    $("#btn_srchall").click(function(){
        $("#frm_search_3").submit();
        //window.location.href=g_controller+'show_list/h_search=';
    });
    //end Submitting search all//
    
    //$(".glyphicon-zoom-in").colorbox();
    
    //Submitting the form//                                            
    $("#btn_submit").click(function(){
        var formid=$(this).attr("search");
		if (search_action)    
        	$("#frm_search_"+formid).attr("action", search_action);
        $("#frm_search_"+formid).submit(); 
    });                                              
    //Submitting the form//
});
