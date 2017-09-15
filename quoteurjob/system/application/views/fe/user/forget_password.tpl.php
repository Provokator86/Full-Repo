<script>
$(document).ready(function(){
	
	
///////////Submitting the form/////////
$("#forget_pass_form").submit(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = $.trim($("#txt_email").val());
	
	if($.trim($("#txt_user_name").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide username'))?>.</strong></span></div>';
		b_valid=false;
	}
	if(address== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide email'))?>.</strong></span></div>';
		b_valid=false;
	}
	else if(reg.test(address) == false) 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide valid email'))?>.</strong></span></div>';
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





});
</script>
<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
           		  <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>	
            <div class="static_content">
					<div id="div_err">
						<?php
							show_msg("error");  
							//show_msg("succ"); 
							echo validation_errors();
						?>
					</div>	
                  <div class="shadow_big">
                        <h1><?php echo get_title_string(t('Forget Password'))?></h1>
                        <div class="right_box_all_inner">
							<form name="forget_pass_form" id="forget_pass_form" action="<?php echo base_url().'user/forget_password' ?>" method="post">
                              <div class="lable01"><?php echo t('Username')?> <span class="red_text">* </span></div>
                              <div class="fld01">
                                    <input type="text"  name="txt_user_name" id="txt_user_name" />
                              </div>
                              <div class="spacer"></div>
                              
                               <div class="lable01"><?php echo t('Email')?> <span class="red_text">* </span></div>
                              <div class="fld01">
                                    <input type="text"  name="txt_email" id="txt_email"   />
                              </div>
                              <div class="spacer"></div>
                             
                              <div class="lable01"></div>
                              <div class="fld01">
                                    <input name="submit" type="submit" value="<?php echo t('Submit')?>"  class="button" />
                              </div>
                              <div class="spacer"></div>
							  </form>
                        </div>
                  </div>
                  <div class="spacer"></div>
            </div>
      </div>
      <div class="spacer"></div>
</div>