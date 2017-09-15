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
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_password").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide existing password'))?>.</strong></span></div>';
			b_valid=false;
		}	
	 if($.trim($("#txt_new_password").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide new password'))?>.</strong></span></div>';
			b_valid=false;
		}	
	 if($.trim($("#txt_confirm_password").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please confirm new password'))?>.</strong></span></div>';
			b_valid=false;
		}	
	else if($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val()))
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Both new and confirm password should be same'))?>.</strong></span></div>';
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

<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
			</div>	
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
            <div class="body_right">
     
                        <h1><img src="images/fe/account.png" alt="" /> <?php echo get_title_string(t('Change Password'))?> </span></h1>
                        <div class="shadow_big">
                              <div class="right_box_all_inner">
							  
							  <form name="contact_form" id="contact_form" action="tradesman/change_password" method="post">
                                    <div class="left_txt"><span>*</span> <?php echo t('Required field')?></div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    <div class="lable01"><?php echo t('Existing Password')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="password"  name="txt_password" id="txt_password"  />
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('New Password')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="password"  name="txt_new_password" id="txt_new_password"  />
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Confirm  New Password')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="password"  name="txt_confirm_password" id="txt_confirm_password"  />
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"></div>
                                    <div class="fld01" style="padding-top:10px;">
                                          <input  class="button" type="button" id="btn_save" value="<?php echo t('Save')?>"/>
                                    </div>
                                    <div class="spacer"></div>
                              </div>
                              <div class="spacer"></div>
          
                        </div>
    
            </div>
            <div class="spacer"></div>
      </div>