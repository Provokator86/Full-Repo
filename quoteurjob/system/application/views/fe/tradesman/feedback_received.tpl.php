<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <div class="body_left">
               <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
				  
				  
            </div>
            <div class="body_right">
                  <h1><img src="images/fe/feedback01.png" alt="" /> <?php echo get_title_string(t('Feedback Received'))?> <span>(<?php echo $profile_info['i_feedback_received']?>) </span></h1>
                  <div class="shadow_big" >
                        <div class="right_box_all_inner">
                              <h4 style="border-bottom:1px solid #e0e0e0;"><span><?php echo $profile_info['i_jobs_won']?></span> <?php echo t('Jobs won')?>, <span><?php echo $profile_info['i_feedback_received']?></span> <?php echo t('feedback comments')?> - <span><?php echo $profile_info['f_positive_feedback_percentage']?>% <?php echo t('positive')?></span> </h4>
                              <br />
                              <div id="job_list">
								 <?php echo $feedback_contents;?>
							 </div>
                              
                        </div>
                  </div>
                  
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>
</div>