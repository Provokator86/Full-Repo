<div class="body_left">
	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align"><?php echo addslashes(t('My Account'))?></h3>
				  <ul class="next_box03">
						<li><a href="<?php echo base_url().'buyer/edit-profile/'?>" <?php  if($this->left_menu==1) { echo 'class="select"';} ?>><?php echo addslashes(t('Edit Profile'))?></a></li>
						<li><a href="<?php echo base_url().'buyer/change-password/'?>" <?php  if($this->left_menu==2) { echo 'class="select"';} ?>><?php echo addslashes(t('Change Password'))?></a> </li>
						<li><a href="<?php echo base_url().'buyer/contact-details/'?>" <?php  if($this->left_menu==3) { echo 'class="select"';} ?>><?php echo addslashes(t('Contact Details'))?></a></li>
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align"><?php echo addslashes(t('My Jobs'))?></h3>
				  <ul class="next_box03">
						<li><a href="<?php echo base_url().'job/job-post'?>" <?php  if($this->left_menu==4) { echo 'class="select"';} ?>><?php echo addslashes(t('Post a Job'))?></a></li>
                            <li><a href="<?php echo base_url().'buyer/active-jobs'?>" <?php  if($this->left_menu==6) { echo 'class="select"';} ?>><?php echo addslashes(t('Active Jobs'))?> (<?php echo $job_count['i_active'] ;?>)</a></li>
						<li><a href="<?php echo base_url().'buyer/all-quotes'?>" <?php  if($this->left_menu==15) { echo 'class="select"';} ?>><?php echo addslashes(t('Job quotes'))?></a></li>
                        <li><a href="<?php echo base_url().'buyer/assigned-jobs'?>" <?php  if($this->left_menu==7) { echo 'class="select"';} ?>><?php echo addslashes(t('Assigned Jobs'))?> (<?php echo $job_count['i_assign'] ;?>)</a></li>
                        <li><a href="<?php echo base_url().'buyer/completed-jobs'?>" <?php  if($this->left_menu==8) { echo 'class="select"';} ?>><?php echo addslashes(t('Completed Jobs'))?> (<?php echo $job_count['i_complete'] ;?>)</a></li>
                        <li><a href="<?php echo base_url().'buyer/expired-jobs'?>" <?php  if($this->left_menu==9) { echo 'class="select"';} ?>><?php echo addslashes(t('Expired Jobs'))?> (<?php echo $job_count['i_expire'] ;?>)</a></li>
						<li><a href="<?php echo base_url().'buyer/all-jobs'?>" <?php  if($this->left_menu==5) { echo 'class="select"';} ?>><?php echo addslashes(t('All Jobs'))?> (<?php echo $job_count['i_total'] ;?>)</a></li>
					
						
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align"><?php echo addslashes(t('Message Board')); ?> </h3>
				  <ul class="next_box03">
						<li><a href="<?php echo base_url().'buyer/private-message-board/'?>" <?php  if($this->left_menu==10) { echo 'class="select"';} ?>><?php echo addslashes(t('My Private Message Board')); ?></a><?php echo ($i_new_message>0)?' ('.$i_new_message.')':''; ?></li>
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align">Tradesman </h3>
				  <ul class="next_box03">
						<li><a href="<?php echo base_url().'buyer/invite-tradesman/'?>" <?php  if($this->left_menu==11) { echo 'class="select"';} ?>><?php echo addslashes(t('Search')); ?>/<?php echo addslashes(t('Invite Tradesman')); ?> </a></li>
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align"><?php echo addslashes(t('My Settings')); ?></h3>
				  <ul class="next_box03">
						<li><a href="<?php echo base_url().'buyer/email-settings/'?>" <?php  if($this->left_menu==12) { echo 'class="select"';} ?>><?php echo addslashes(t('Email Settings')); ?></a></li>
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
	  <div class="box03_out">
			<div class="box03">
				  <h3 class="align">General</h3>
				  <ul class="next_box03">
						<!--<li><a href="buyer_alert.html">My Alerts</a></li>-->
						<li><a href="<?php echo base_url().'buyer/recommend-us/'; ?>" <?php  if($this->left_menu==13) { echo 'class="select"';} ?>>Recommend Us</a></li>
						<li><a  href="<?php echo base_url().'buyer/testimonial/'; ?>" <?php  if($this->left_menu==14) { echo 'class="select"';} ?>>My Testimonial</a></li>
				  </ul>
				  <div class="spacer"></div>
			</div>
	  </div>
</div>