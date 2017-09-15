
<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
			</div>	
            <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
			
            
<div class="body_right">

<h1><img src="images/fe/settings.png" alt="" />  <?php echo get_title_string(t('Email Settings'))?></h1>
<div class="shadow_big">
<div class="right_box_all_inner">
		<div class="brd"><?php echo t('System would send you alert email to you in the following scenarios. If you would like to receive such emails, please check the following options')?></div>
	<form name="email_setting_frm" id="email_setting_frm" action="" method="post">
	<div class="box02">
		  <input name="chk_trade_place_quote" type="checkbox" value="tradesman_placed_quote" <?php if(!empty($email_key)) echo in_array('tradesman_placed_quote',$email_key) ? 'checked':''?>   style="vertical-align:middle; margin-right:5px;" />
		  <?php echo t('Tradesman has placed Quote against your Job')?>.</div>
	<div class="box02">
		  <input name="chk_trade_accept_reject_job" type="checkbox" value="tradesman_accepted_job_offer" <?php if(!empty($email_key)) echo in_array('tradesman_accepted_job_offer',$email_key) ? 'checked':''?>   style="vertical-align:middle; margin-right:5px;" />
		   <?php echo t('Tradesman has accepted/rejected the Job offer')?>.</div>
	<div class="box02">
		  <input name="chk_trade_submit_msg" type="checkbox" value="tradesman_post_msg" <?php if(!empty($email_key)) echo in_array('tradesman_post_msg',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
		   <?php echo t('Tradesman has submitted message against your Job')?>.</div>
	<div class="box02">
		  <input name="chk_trade_asked_feedback" type="checkbox" value="tradesman_feedback" <?php if(!empty($email_key)) echo in_array('tradesman_feedback',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
		   <?php echo t('Tradesman has completed the Job and asked for your feedback')?>.</div>
	<div class="box02">
		  <input name="chk_admin_approved_reject_job" type="checkbox" value="admin_buyer_cancel_job" <?php if(!empty($email_key)) echo in_array('admin_buyer_cancel_job',$email_key) ? 'checked':''?> style="vertical-align:middle; margin-right:5px;" />
		   <?php echo t('Admin has approved/rejected the Job you have posted')?>.</div>
   
	<br />
	<input  class="button" type="submit" value="<?php echo t('Save')?>" style=" margin-bottom:10px;"/>
	<div class="spacer"></div>
	</form>
	
</div>
</div>

<div class="spacer"></div>
</div>
<div class="spacer"></div>
</div>
  