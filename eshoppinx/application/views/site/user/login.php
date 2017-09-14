<?php 
session_start();
?>
<?php 
$this->load->view('site/templates/header',$this->data);
?>
   <!-- Section_start -->
   <div id="mid-panel">
    <div class="wrapper">
        <div class="login">
            <p>Hey there. Please <a href="<?php echo base_url('login') ?>">sign in</a> or <a href="<?php echo base_url('signup') ?>">sign up</a> before continuing.</p>
            
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
            
            <h1><?php if($this->lang->line('login_signto') != '') { echo stripslashes($this->lang->line('login_signto')); } else echo "Sign in to"; ?> <?php echo $siteTitle;?></h1>
            <a href="javascript:" class="signin_fb">Sign in with Facebook</a>
            <span>or sign in with email</span>
            
            
            <form action="site/user/login_user" method="post" autocomplete="off">
            <input type='hidden' />
                <div>
                    <input type="text" id="username" name="email"  class="email" placeholder="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>">
                    <input type="password" id="password" name="password" class="password" placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>">
                    <input type="submit" class="sign_in" value="<?php if($this->lang->line('signup_sign_in') != '') { echo stripslashes($this->lang->line('signup_sign_in')); } else echo "Sign in"; ?>">
                </div>
                <input class="next_url" type="hidden" name="next" value="<?php echo $next;?>"/>
            </form>
            
            <a href="<?php echo base_url('forgot-password') ?>"><?php if($this->lang->line('forgot_passsword') != '') { echo stripslashes($this->lang->line('forgot_passsword')); } else echo "Forgot Password"; ?> ?</a>
            <a href="<?php echo base_url('signup') ?>">Not a member yet? Join Us !</a>
        </div>
    </div>
  </div>
  <div class="clear"></div>
   <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer');
?>