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
		s_err +='<div class="error_massage"><strong>Please provide  username.</strong></div>';
		b_valid=false;
	}
	if(address== '')
	{
		s_err +='<div class="error_massage"><strong>Please provide email.</strong></div>';
		b_valid=false;
	}
	else if(reg.test(address) == false) 
	{
		s_err +='<div class="error_massage"><strong>Please provide valid email.</strong></div>';
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
					<div id="div_err">
                        <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>    
						<?php
							show_msg("error");  
							//show_msg("succ"); 
							echo validation_errors();
						?>
					</div>	


<div id="inner_container02">
            <div class="title">
                <h3><span>Hi! Welcome back to</span> Jobshoppa</h3>
            </div>
            <div class="clr"></div>
            <div id="login_form">
                <div class="top">&nbsp;</div>
                <div class="mid">
                    <div class="heading">Reset your password</div>
                    <div class="content">
                        <div class="box01">
                        <form name="forget_pass_form" id="forget_pass_form" action="<?php echo base_url().'user/forget_password' ?>" method="post">
                            <div class="lable01">Username : <span class="red_text">* </span></div> 
                            <div class="field01">
                                <input name="txt_user_name" id="txt_user_name" type="text" size="48"/>
                            </div>
                            <div class="clr"></div>
                            <div class="lable01">Email : <span class="red_text">* </span></div> 
                            <div class="field01">
                                <input name="txt_email" id="txt_email" type="text" size="48" />
                            </div>
                            
                        </div>

                    </div>
                    <div class="bottom">
                        <div class="field01">
                            <input name="submit" type="submit" value="Submit"  />
                        </div>  
                    </div>
                    </form> 
                </div>
                <div class="bot">&nbsp;</div>
            </div>
            <div id="login_problem">
                <h4 class="orange">Problems logging in?</h4>
                <p><img src="images/fe/img-11.jpg" alt="" width="260" height="180" /></p>
                <p class="big_txt15">Try using your email as your username </p>
                <p>&nbsp;</p>
                <p class="big_txt15">Check that you are accepting our cookies Or try <a href="<?php echo base_url().'user/forget_password'?>">resetting your password</a></p>
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
</div>
</div>