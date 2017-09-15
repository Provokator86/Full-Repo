<script>
$(document).ready(function(){
	
///////////Submitting the form/////////
$("#login_form").submit(function(){	
    var b_valid=true;
    var s_err="";
	
   var pass	=	$.trim($("#txt_password").val());
	if($.trim($("#txt_user_name").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo t('Please provide username')?>.</strong></span></div>';
		b_valid=false;
	}
	if(pass== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo t('Please provide password')?>.</strong></span></div>';
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
	/*$('#btn_reg').click(function(){
		$("#form_buyer_reg").submit();
	}); */

});

</script>

      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
           		 <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>	
				 
				 <div id="div_err">
			 		<?php
						//show_msg("error");  
						echo validation_errors();
						//pr($posted);
					?>
				</div>	
            <div class="static_content">
                  <div class="shadow_big">
                        <h1><?php echo t('Login')?></h1>						
						<div class="right_box_all_inner">
						<?php show_msg("error") ?>
						<form name="login_form" id="login_form" action="<?php echo base_url().'user/login/TVNOaFkzVT0'?>" method="post">
						<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                             <div class="lable01"><?php echo t('Username')?><span class="red_text"> * </span></div>
                              <div class="fld01">
                                    <input type="text" id="txt_user_name"  name="txt_user_name" value="<?php echo $posted['txt_user_name'] ?>"  autocomplete="off" />
                              </div>
                              <div class="spacer"></div>
                              
                                <div class="lable01"><?php echo t('Password')?> <span class="red_text"> * </span></div>
                              <div class="fld01">
                                    <input type="password" id="txt_password"  name="txt_password" />
                              </div>
                               <div class="spacer"></div>
                              <div class="lable01"></div>
                              <div class="fld01" style="padding-top:0px;"> <a href="<?php echo base_url().'user/forget_password'?>" class="red_link"><?php echo t('Forget Password')?></a> </div>
                              <div class="spacer"></div>
                              <div class="lable01"></div>
                              <div class="fld01">
                                    <input name="submit" type="submit" value="<?php echo t('Login')?>"  class="button" />
                              </div>
                              <div class="spacer"></div>
							   </form>
                        </div>
						
                  </div>
                  <div class="spacer"></div>
            </div>
      </div>
      <div class="spacer"></div>