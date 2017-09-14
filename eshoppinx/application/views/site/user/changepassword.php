<?php $this->load->view('site/templates/header');?>
    
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
            <div class="container set_area" style="padding:30px 0 20px">
		
		        <?php if($flash_data != '') { ?>
		        <div class="errorContainer" id="<?php echo $flash_data_type;?>">
			        <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			        <p><span><?php echo $flash_data;?></span></p>
		        </div>
                <div class="clear"></div>
		        <?php } ?>
                                    
                <?php $this->load->view('site/user/user_sidebar_menu'); ?> 
                               
                <div id="content">
		        <form autocomplete="off" onsubmit="return change_user_password();" method="post" action="<?php echo base_url().'site/user_settings/change_user_password'?>">
		        <h2 class="ptit"><?php if($this->lang->line('change_password') != '') { echo stripslashes($this->lang->line('change_password')); } else echo "Change Password"; ?></h2>
		        <div style="display:none" class="notification-bar"></div>
		        <div class="section password">
			        <fieldset class="frm">
				        <label><?php if($this->lang->line('change_new_pwd') != '') { echo stripslashes($this->lang->line('change_new_pwd')); } else echo "New Password"; ?></label>
				        <input type="password" name="pass" id="pass">
				        <small class="comment"><?php if($this->lang->line('change_pwd_limt') != '') { echo stripslashes($this->lang->line('change_pwd_limt')); } else echo "New password, at least 6 characters."; ?></small>
				        <label><?php if($this->lang->line('change_conf_pwd') != '') { echo stripslashes($this->lang->line('change_conf_pwd')); } else echo "Confirm Password"; ?></label>
				        <input type="password" name="confirmpass" id="confirmpass">
				        <small class="comment"><?php if($this->lang->line('change_ur_pwd') != '') { echo stripslashes($this->lang->line('change_ur_pwd')); } else echo "Confirm your new password."; ?></small>
			        </fieldset>
		        </div>
		        <div class="btn-area">
			        <button id="save_password" class="btn-save"><?php if($this->lang->line('change_password') != '') { echo stripslashes($this->lang->line('change_password')); } else echo "Change Password"; ?></button>
			        <span style="display:none" class="checking"><i class="ic-loading"></i></span>
		        </div>
		        </form>
	        </div>

		    
		     </div>  
        </div>
    </div>
    <div class="clear"></div>
    <!-- Section_end -->
<?php $this->load->view('site/templates/footer');?>
