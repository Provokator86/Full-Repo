<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 

    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#contact_form").submit();
	   //check_duplicate();
   }); 
});    


///////////Submitting the form/////////
$("#contact_form").submit(function(){
    var b_valid=true;
    var s_err="";
	var pass=$("#txt_new_password").val();
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_password").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please provide your current password.</strong></div>';
			b_valid=false;
		}	
	 if($.trim($("#txt_new_password").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please provide new password.</strong></div>';
			b_valid=false;
		}
	else if(pass!='' && pass.length<6)
    {
        s_err +='<div class="error_massage"><strong>Please provide a new password. New password should be at least 6 characters.</strong></div>';
        b_valid=false;
    }
	
     else if($.trim($("#txt_password").val()) == $.trim($("#txt_new_password").val()))
     {
           s_err +='<div class="error_massage"><strong>Invalid current password.</strong></div>';
            b_valid=false;
     }	
	 if($.trim($("#txt_confirm_password").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please confirm your new password.</strong></div>';
			b_valid=false;
		}	
	else if($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val()))
	{
		s_err +='<div class="error_massage"><strong>Both new and confirm password should be same.</strong></div>';
			b_valid=false;
	}	
    
    /////////validating//////
     if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
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
                <h3><span>Change </span> Password</h3>   
            </div>
            <div class="clr"></div>
           <!-- <h6>&quot; Please take a moment and fill the form out below. &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
            <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
                            <p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
                            <div id="form_box01">
                            <form name="contact_form" id="contact_form" action="tradesman/change_password" method="post">    
                                <div class="label03">Existing Password <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                     <input type="password"  name="txt_password" id="txt_password" size="48" />
                                </div>
                                <div class="clr"></div>
                                <div class="label03">New Password <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="password"  name="txt_new_password" id="txt_new_password" size="48"  />       
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Retype New Password <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="password"  name="txt_confirm_password" id="txt_confirm_password" size="48" />
                                </div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    
                                    <input type="submit" value="Save" /> <input type="reset" value="Cancel" />
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