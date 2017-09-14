<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
      // window.location.reload();
	  setTimeout('window.location.reload()',2000);
   }); 
});    
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#edit_email_form").submit();
       //check_duplicate();
   }); 
});    


///////////Submitting the form/////////
$("#edit_email_form").submit(function(){ 
 	
    var b_valid=true;
    var s_err="";
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; 
    var email= $.trim($("#txt_email").val()) ;
    var new_email= $.trim($("#txt_new_email").val()) ;
    var con_email= $.trim($("#txt_con_email").val()) ;
    var user_id = parseInt(<?php echo decrypt($user_id); ?>);
   
     $("#div_err").hide();            
    
     if(email=="") 
        {
             s_err +='<div class="error_massage"><strong>Please provide existing email</strong></div>'; 
           
            b_valid=false;
        } 
     else if(reg.test(email)== false) 
        {

        s_err +='<div class="error_massage"><strong>Please provide valid existing email</strong></div>';
        b_valid=false;
        } 
    /*confirm email validation*/
    else
    {
        
        //var txt_username =     $.trim($("#txt_username").val());    
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'tradesman/ajax_check_email_valid',
                data: "s_email="+email+"&user_id="+user_id,
                success: function(msg){
                   if(msg=='error')
                   {
                        s_err +='<div class="error_massage"><strong>You have typed incorrect email! Please type again...</strong></div>';
                        b_valid=false;                        
                   } 
                   
                }
            });    
    }  
     if(new_email=="") 
        {
           s_err +='<div class="error_massage"><strong>Please provide new email.</strong></div>';
            b_valid=false;
        } 
     else if(reg.test(new_email) == false) 
    {
        s_err +='<div class="error_massage"><strong>Please provide valid new email</strong></div>';
        b_valid=false;
    } 
    else
    {
         //var txt_username =     $.trim($("#txt_username").val());    
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'tradesman/ajax_check_email_exist',
                data: "s_email="+new_email+"&user_id="+user_id,
                success: function(msg){
                   if(msg=='error')
                   {
                        s_err +='<div class="error_massage"><strong>This email already exists.</strong></div>';
                        b_valid=false;                        
                   } 
                   
                }
            });
        
    }   
     if(con_email=="") 
        {
           s_err +='<div class="error_massage"><strong>Please confirm new email.</strong></div>';
            b_valid=false;
        }
    else if(reg.test(con_email) == false) 
    {
        s_err +='<div class="error_massage"><strong>Please provide valid confirm email</strong></div>';
        b_valid=false;
    }     
    else if(new_email != con_email)
    {
        s_err +='<div class="error_massage"><strong>Both new and confirm password should be same.</strong></div>';
            b_valid=false;
    }    
    
    /////////validating//////
     if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show();
    }
    
    return b_valid;
   //return false;
});    
///////////end Submitting the form/////////   

})
//});
</script>

<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php           
    //include_once(APPPATH."views/fe/common/message.tpl.php");
    ?>
     <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Edit </span> Email</h3>   
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; Please take a moment and fill the form out below. &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
            <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
                            <p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
                            <div id="form_box01">
                                <form name="edit_email_form" id="edit_email_form" action="<?php echo base_url().'tradesman/edit_email'?>" method="post">
                                <div class="label03">Existing Email <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="text" name="txt_email" id="txt_email" value="<?php echo $posted['txt_email']; ?>" size="48" />
                                </div>
                                <div class="clr"></div>
                                <div class="label03">New Email <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="text" name="txt_new_email" id="txt_new_email" value="<?php echo $posted['txt_new_email']; ?>" size="48" />
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Retype New Email <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="text" name="txt_con_email" id="txt_con_email" value="<?php echo $posted['txt_con_email']; ?>" size="48" />
                                </div>
                                <div class="clr"></div>
                    
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <input id="btn_save" type="submit" value="Save" />
                                    <input id="btn_cancel" type="reset" value="Cancel" />
                                </div>
                                </form>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
            <?php include_once(APPPATH.'views/fe/common/tradesman_right_menu.tpl.php'); ?> 
            </div>
            <div class="clr"></div>
        </div>         
        
        <div class="clr"></div>
</div>
</div>      