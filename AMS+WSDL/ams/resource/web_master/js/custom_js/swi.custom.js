/*
* File name: swi.custom.js
* Purpose: write all the common custom javascript use in the whole project
* Created on: 25th May, 2015
* Author: SWI Dev Team
*/
// Block UI and unblock it
function blockUI(message)
{
    
    $.blockUI({css: {border: 'none', padding: '5px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', borderRadius:'5px', opacity: .5, color: '#fff', fontSize:'14px',fontWeight:'bold'},
        message: message ? message : '<img src="'+base_url+'resource/web_master/img/indicator.black.gif"> Please wait...'
    }); 
}
function unblockUI()
{
    $.unblockUI()
}
jQuery(document).ready(function($){
    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });
    
    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
});

// UI confirmation
var UIconfirm = function(message, onSuccessCallback) {
    var $obj = $('#modal_confirmation');
    $obj.remove();
    // Add html if not added yet
    var modal_container = '<div class="modal fade" id="modal_confirmation"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">x</button><h3 class="text-yellow">Confirmation</h3></div><div class="modal-body"><p id="dialog_msg">Are you sure to delete this?</p></div><div class="modal-footer"><a href="javascript:;" class="btn btn-success" id="btn_continue">Yes</a><a href="javascript:;" class="btn btn-danger" id="btn_dont_continue" data-dismiss="modal">No</a></div></div></div></div>';
    $('footer').append(modal_container);
    
    if(message != '')
        $("#dialog_msg").html(message);  
    
    $obj.modal('show'); 
    $('#btn_continue').click(function(){
        onSuccessCallback();
        $obj.modal('hide');
    });    
}