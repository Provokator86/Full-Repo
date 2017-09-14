<div class="body_left">
	  	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align"><?php echo addslashes(t('Job Prospects'))?> </h3>
				  <ul class="next_box03">
						<li><a href="<?php echo base_url().'tradesman/quote-jobs/' ?>" <?php  if($this->left_menu==9) { echo 'class="select"';} ?>><?php echo addslashes(t('Quotes'))?> (<?php echo $i_tot_quotes;?>)</a></li>
						<li><a href="<?php echo base_url().'tradesman/job-invitation/' ?>" <?php  if($this->left_menu==10) { echo 'class="select"';} ?>><?php echo addslashes(t('Job invitations'))?> (<?php echo $i_tot_invitation;?>)</a></li>
                        <li><a href="<?php echo base_url().'tradesman/private-message-board/' ?>" <?php  if($this->left_menu==17) { echo 'class="select"';} ?>><?php echo addslashes(t('My Private Message Board'))?></a><?php echo ($i_new_message>0)?' ('.$i_new_message.')':''; ?></li>
                        <br/>
                        <li><a href="<?php echo base_url().'tradesman/jobs-you-got/' ?>" <?php  if($this->left_menu==12) { echo 'class="select"';} ?>><?php echo addslashes(t('Jobs You Got'))?> (<?php echo $job_count['i_frozen'] ;?>)</a></li>
                        <li><a href="<?php echo base_url().'tradesman/progress-jobs/' ?>" <?php  if($this->left_menu==13) { echo 'class="select"';} ?>><?php echo addslashes(t('In Progress'))?> (<?php echo $job_count['i_progress'] ;?>)</a></li>
                        <li><a href="<?php echo base_url().'tradesman/pending-jobs/' ?>" <?php  if($this->left_menu==14) { echo 'class="select"';} ?>><?php echo addslashes(t('Pending Jobs'))?> (<?php echo $job_count['i_pending'] ;?>)</a></li>
                        <li><a href="<?php echo base_url().'tradesman/completed-jobs/' ?>" <?php  if($this->left_menu==15) { echo 'class="select"';} ?>><?php echo addslashes(t('Completed Jobs'))?> (<?php echo $job_count['i_complete'] ;?>)</a></li>
                         <li><a href="<?php echo base_url().'tradesman/all-jobs/' ?>" <?php  if($this->left_menu==22) { echo 'class="select"';} ?>><?php echo addslashes(t('All Jobs'))?> (<?php echo $job_count['i_total'] ;?>)</a></li>
                       
                        <br/> 
					    <?php if($i_membership[0]['i_plan_type']!=2) { ?>
                        <li><a href="<?php echo base_url().'tradesman/radar-jobs/' ?>" <?php  if($this->left_menu==11) { echo 'class="select"';} ?>><?php echo addslashes(t('Radar Jobs'))?> </a></li>
                        <?php } ?>
                        <li><a href="<?php echo base_url().'tradesman/feedback-received/' ?>" <?php  if($this->left_menu==16) { echo 'class="select"';} ?>><?php echo addslashes(t('Feedback Received'))?> (<?php echo $i_total_feedback ?>)</a></li>
                        <li><a href="<?php echo base_url().'tradesman/testimonial/' ?>" <?php  if($this->left_menu==21) { echo 'class="select"';} ?>><?php echo addslashes(t('My Testimonial'))?></a></li>
                        
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
      
          <div class="box03_out">
                <div class="box03"><?php //echo '=='.$i_membership[0]['i_plan_type'] ?>
                      <h3 class="align"><?php echo addslashes(t('My Account'))?></h3>
                      <ul class="next_box03">
                        <li><a href="<?php echo base_url().'tradesman-profile/'.$loggedin['user_id'] ?>" <?php  if($this->left_menu==2) { echo 'class="select"';} ?>><?php echo addslashes(t('View Trade Profile'))?></a></li>
                         <li><a href="<?php echo base_url().'tradesman/professional-information/' ?>" <?php  if($this->left_menu==8) { echo 'class="select"';} ?>><?php echo addslashes(t('Professional Information'))?></a></li>
                         <li><a href="<?php echo base_url().'tradesman/album/' ?>" <?php  if($this->left_menu==3) { echo 'class="select"';} ?>><?php echo addslashes(t('My Album'))?></a></li>
                        <li><a href="<?php echo base_url().'tradesman/edit-profile/' ?>" <?php  if($this->left_menu==1) { echo 'class="select"';} ?>><?php echo addslashes(t('Edit My Profile'))?></a></li>
                           <li><a href="<?php echo base_url().'tradesman/contact-details/' ?>" <?php  if($this->left_menu==5) { echo 'class="select"';} ?>><?php echo addslashes(t('Contact Details'))?></a></li>
                       
                        <br/>                     
                         <li><a href="<?php echo base_url().'tradesman/membership-history/' ?>" <?php  if($this->left_menu==6) { echo 'class="select"';} ?>><?php echo addslashes(t('Membership History'))?></a></li>
                         <li><a href="<?php echo base_url().'tradesman/contact-list/' ?>" <?php  if($this->left_menu==7) { echo 'class="select"';} ?>><?php echo addslashes(t('Contact List'))?></a></li>
                        
                               
                      </ul>
                      <div class="spacer"></div>
                </div>
          </div>
	  	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align"><?php echo addslashes(t('My Settings'))?></h3>
				  <ul class="next_box03">
                         <li><a href="<?php echo base_url().'tradesman/change-password/' ?>" <?php  if($this->left_menu==4) { echo 'class="select"';} ?>><?php echo addslashes(t('Change Password'))?></a> </li>
						<li><a href="<?php echo base_url().'tradesman/email-settings/' ?>" <?php  if($this->left_menu==18) { echo 'class="select"';} ?>><?php echo addslashes(t('Email Settings'))?></a></li>
                          <?php if($i_membership[0]['i_plan_type']!=2) { ?>
                        <li><a href="<?php echo base_url().'tradesman/radar-setting/' ?>" <?php  if($this->left_menu==19) { echo 'class="select"';} ?>><?php echo addslashes(t('Radar Settings'))?></a></li>
                    <?php } ?>    
                        <li><a href="<?php echo base_url().'tradesman/recommend-us/' ?>" <?php  if($this->left_menu==20) { echo 'class="select"';} ?>><?php echo addslashes(t('Recommend Us'))?></a></li>
                        
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
</div>