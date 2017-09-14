<script type="text/javascript" language="javascript" >     
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    
    $("#frm_login_form").submit(function(){  

    var b_valid=true;
    var s_err="";
   
   
    if($.trim($("#txt_user_name").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide a username or email.</strong></div>';
        b_valid=false;
    }
    else
    {
        var txt_username =     $.trim($("#txt_user_name").val());    
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'user/ajax_check_login_status',
                data: "s_username="+txt_username,
                success: function(msg){
                    if(msg)
                    {
                       if(msg=='error_user_exist')
                       {
                            s_err +='<div class="error_massage"><strong>Invalid user name or password. Please try again.</strong></div>';
                            b_valid=false;                        
                       } 
                    
                       if(msg=='error_user_active')
                       {
                            s_err +='<div class="error_massage"><strong>Your account is not active yet.</strong></div>';
                            b_valid=false;                        
                       } 
                   }
                }
            });
        
    }
     if($.trim($("#txt_password").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide a password.</strong></div>';
        b_valid=false;
    }

     if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }

    return b_valid;
    });
});});
</script>
<?php
    //var_dump($_COOKIE);
    $txt_user_name = $_COOKIE['User'] ;
    $txt_password =  $_COOKIE['pass'] ;
    
 
?>
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
                <h3><span>Hi! Welcome back to</span> Jobshoppa</h3>
            </div>
            <div class="clr"></div>
            <div id="login_form">
                <div class="top">&nbsp;</div>
                <div class="mid">
                    <div class="heading">Please Login From Here</div>
                    <div class="content">
                        <div class="box01">
                        <form name="frm_login_form" id="frm_login_form" action="" method="post">
                            <div class="label01">Username/Email :</div>
                            <div class="field01">
                                <input name="txt_user_name" id="txt_user_name" type="text" size="48" value="<?php echo $txt_user_name?>" autocomplete="off" />
                            </div>
                            <div class="clr"></div>
                            <div class="label01">Password :</div>
                            <div class="field01">
                                <input name="txt_password" id="txt_password" type="password" value="<?php echo $txt_password?>" size="48"  autocomplete="off"/>
                            </div>
                            <div class="clr"></div> 
                            <div class="label01">&nbsp;</div>   
                            <div class="field01"><a href="<?php echo base_url().'user/forget_password'?>">Forgot Password? </a>
							</div>
					
							
							<?=$facebook_root_div?>
							<script src="http://connect.facebook.net/en_US/all.js"></script>
							<script type="text/javascript"> 
							
							  
							  FB.init({appId: '<?=$facebook_app_id?>', status: true, cookie: true, xfbml: true, oauth: true});
							
							   function fblogincheck(){  
							   
								FB.login(function(response) {
								
								 if (response.authResponse) {
								 
								  var access_token = response.authResponse.accessToken;
								  //var encoded = enc(access_token);
							
								  
								  //$('#loading_fconnect').show();      
								 // animated_period_fn();
									   
								  window.location.href = '<?=base_url()?>'+'user/fconnect/'+access_token;
								  
								 } else {
								 // user cancelled login
								 }
								});
							   }
							   
							  function fblogoutcheck(){ 
							   FB.logout(function(response) {
							   window.location.href = '<?=base_url()?>'+'users/logout';
							   });   
							  }							
														
								</script>						
								<?=$button?>			
							
							
							
							
                            <div class="clr"></div>
                        </div>
                        <div class="box02">
                            <h6><span>All Fields are required</span></h6>
                            <p><img src="images/fe/icon-19.png" alt="" width="100" height="120" /></p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="field01">
                            <input type="submit" value="Login Now"  />
                        </div>
                    
                        <div class="field02">
                            <input name="chk_remember_me" id="chk_remember_me" type="checkbox" value="1" <?php 
                            if(!empty($_COOKIE['User']) && !empty($_COOKIE['pass']))
                            {
                               echo "checked"; 
                            }
                            ?> />
                            Keep me logged in</div>
                    </div>
                    </form> 
                </div>
                <div class="bot">&nbsp;</div>
            </div>
            <div id="login_problem">
                <h4 class="orange">Problems logging in?</h4>
                <p><img src="images/fe/img-11.jpg" alt="" width="260" height="180" /></p>
                <p class="big_txt15">Try using your email as your user id </p>
                <p>&nbsp;</p>
                <p class="big_txt15">Check that you are accepting our cookies Or <a href="<?php echo base_url().'user/forget_password'?>">try resetting your password</a></p>
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
</div>
</div>
