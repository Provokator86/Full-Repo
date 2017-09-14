<?php 
@session_start();
unset($_SESSION['token']);
$social_login_session_array = $this->session->all_userdata(); 
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_templates.php');
?>

<script type="text/javascript">
		var baseURL = '<?php echo base_url();?>';
		var can_show_signin_overlay = false;
		if (navigator.platform.indexOf('Win') != -1) {document.write("<style>::-webkit-scrollbar, ::-webkit-scrollbar-thumb {width:7px;height:7px;border-radius:4px;}::-webkit-scrollbar, ::-webkit-scrollbar-track-piece {background:transparent;}::-webkit-scrollbar-thumb {background:rgba(255,255,255,0.3);}:not(body)::-webkit-scrollbar-thumb {background:rgba(0,0,0,0.3);}::-webkit-scrollbar-button {display: none;}</style>");}
	</script>
<!--[if lt IE 9]>
<script src="js/site/html5shiv/dist/html5shiv.js"></script>
<![endif]-->
<?php if (is_file('google-login-mats/index.php'))
{
	require_once 'google-login-mats/index.php';
}?>
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
            <div class="login">
                <?php 
                    $site_join_msg = str_replace("{SITENAME}",$siteTitle,$this->lang->line('signup_join_msg'));
                ?>
                <h1><?php if($this->lang->line('signup_join_msg') != '') { echo $site_join_msg; } else echo "Join".$siteTitle."today"; ?></h1>
                
                <?php if (validation_errors() != ''){?>
                <div id="validationErr">
                    <script>setTimeout("hideErrDiv('validationErr')", 3000);</script>
                    <p><?php echo validation_errors();?></p>
                </div>
                <?php }?>
                <?php if($flash_data != '') { ?>
                <div class="errorContainer" id="<?php echo $flash_data_type;?>">
                    <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
                    <p><span><?php echo $flash_data;?></span></p>
                </div>
                <?php } ?>
                 <?php 
                   $yoursitepage = str_replace("{SITENAME}",$siteTitle,$this->lang->line('signup_sitepage'));
                    $siteaccswrld = str_replace("{SITENAME}",$siteTitle,$this->lang->line('signup_access_wrld'));
                 ?>
                 <div class="clear"></div>
                
                <a href="javascript:" class="signin_fb">Sign in with Facebook</a>
                <span>or sign up with email</span>
                
                <form method="post" onSubmit="return signup_user(this);" autocomplete="off">
                <input name="referrer" type="hidden" class="referrer" value="" />
                <input name="invitation_key" type="hidden" class="invitation_key" value="" />
                <input type='hidden' name='csrfmiddlewaretoken' value='UFLfIU881eyZJbm7Bq0kUFZ9sVaWGh54' />
                <input type='hidden' name='api_id' id="api_id"  value='<?php echo $social_login_session_array['social_login_unique_id'];?>' />
                <input type='hidden' name='thumbnail' id='thumbnail' value='<?php echo $social_login_session_array['social_image_name'];?>' />
                <input type='hidden' name='loginUserType' id='loginUserType' value='<?php if($social_login_session_array['loginUserType'] != '') echo $social_login_session_array['loginUserType']; else echo "normal";?>' />
                <fieldset class="frm email-frm" style="display:<?php if($social_login_session_array['social_login_name'] == '') echo 'block'; else 'block'; ?>">
                    
                   
                    <div>
                        <input type="text" id="fullname" name="full_name"  class="fullname" placeholder="<?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "Full Name"; ?>" value="<?php echo $social_login_session_array['social_login_name'];?>" value="<?php echo $social_login_session_array['social_login_name'];?>">
                        
                        <input type="<?php if($social_login_session_array['loginUserType'] != 'google' && $social_login_session_array['loginUserType'] != 'facebook') echo 'text'; else echo 'hidden'; ?>" id="email" name="email" class="email signup_email" placeholder="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" value="<?php echo $social_login_session_array['social_email_name'];?>">
                        <?php 
                        $pwdLength = 10;
                        $userNewPwd = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $pwdLength);
                        ?>
                        <input type="<?php if($social_login_session_array['social_login_name'] == '') echo 'password'; else echo 'hidden'; ?>" id="user_password" name="password" class="password" placeholder="<?php if($this->lang->line('signup_min_chars') != '') { echo stripslashes($this->lang->line('signup_min_chars')); } else echo "Minimum 6 characters"; ?>" value="<?php if($social_login_session_array['social_login_name'] != '') echo $userNewPwd; ?>" >
                        
                        <input type="text" id="username" name="user_name" class="username" placeholder="<?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Username"; ?>">
                        <input type="submit" class="sign_in" value="<?php if($this->lang->line('signup_creat_myacc') != '') { echo stripslashes($this->lang->line('signup_creat_myacc')); } else echo "Sign Up"; ?>">
                    </div>
                    
                    </fieldset>
                </form>
                
                <a href="<?php echo base_url('login') ?>">Been here before ? Sign in</a>
            </div>
        </div>
    </div>
    <div class="clear"></div>
	<!-- Section_end -->
   
<script>
jQuery(function($){
	$('a.more').mouseover(function(){$('.sns-minor').show();return false;});
	$('a.more').click(function(){
		$('.sns-minor').toggleClass('toggle');
	});
	$('.sns-minor .trick').click(function(){
		$('.sns-minor').removeClass('toggle');
		return false;
	});
	$('.sns-major').mouseover(function(){$('.sns-minor').hide();return false;});
	$('.sns-minor').mouseover(function(){if ($(this).hasClass('toggle')==false) $(this).hide();});
});
</script>
<?php 
$this->load->view('site/templates/footer',$this->data);
?>