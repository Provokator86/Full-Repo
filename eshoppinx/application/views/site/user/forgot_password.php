<?php 
$this->load->view('site/templates/header',$this->data);
?>

   <!-- Section_start -->
   <div id="mid-panel">
    <div class="wrapper">
        <div class="login">
            <h1><?php if($this->lang->line('forgot_enter_email') != '') { echo stripslashes($this->lang->line('forgot_enter_email')); } else echo "Forgot your password?"; ?></h1>
            
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
            <div class="clear"></div>
            <form action="site/user/forgot_password_user" method="post">
            <input type='hidden' />
                <div>
                    <input type="text" class="email" id="username" name="email" placeholder="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email address"; ?>" placeholder="Email address">
                    <input class="find_btn" type="hidden" name="next" value="/"/>
                    <input type="submit" class="sign_in" value="<?php if($this->lang->line('user_reset') != '') { echo stripslashes($this->lang->line('user_reset')); } else echo "Reset"; ?>">
                </div>
            </form>
            
            <div class="sep-1"></div>
        </div>
    </div>
  </div>
  <div class="clear"></div>
        
   <!-- Section_end -->

  <input type="hidden" value="emailinfoPopContent" id="emailinfoPopContent" />
</section>
<script type="text/javascript" src="js/site/jquery.validate.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
		var baseURL = '<?php echo base_url();?>';
</script>
<script>
	$("#SignupForm").validate();
</script>
<!-- Section_end -->
<?php 
$this->load->view('site/templates/footer');
?>
