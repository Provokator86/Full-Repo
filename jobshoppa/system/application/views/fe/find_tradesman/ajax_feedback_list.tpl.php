  <?php
  //pr($feedback_list);
  if($feedback_list)
  {
	//$i=1;
	  foreach($feedback_list as $feedback_val)
	  {
	  	//pr($val);
		$job_link = base_url().'job/job_details/'.encrypt($feedback_val['i_job_id']);
  ?>
                  <div class="review" style="display:block;">
                    <!--<h6><span class="blue">91</span> jobs won, <span class="blue">90</span> reviews</h6>-->
                    <div class="box">
                        <p class="blue_txt18"><?php echo  $feedback_val['s_job_title']?></p>
                        <p class="orng_txt12"><?php echo $feedback_val['s_sender_user']?></p>
                        <div class="view_box">
							<?php if($feedback_val['i_status']==2) {?>
							
								<p class="terminate_txt">This job was terminated due to the following : <?php echo  $feedback_val['s_terminate_reason']?></p>
								<?php } ?>	
                            <div class="top">&nbsp;</div>								
                            <div class="mid">
															
                                <p><?php echo  $feedback_val['s_comments']?></p>
                                <p class="grey_txt12"><?php echo $feedback_val['dt_created_on']?></p>
                                <p>&nbsp;</p>
                                <p><?php echo show_star($feedback_val['i_rating'])?></p>
								<?php if($feedback_val['i_positive'] == 1){ ?>
                                <p class="grey_txt12">Rating - <?php //echo $feedback_val['f_positive_feedback_percentage']?> Positive</p>
								<?php } else { ?>
								 <p class="red_txt">Rating -  Negative</p>
								 <?php } ?>
                            </div>
                            <div class="bot">&nbsp;</div>
                        </div>
                    </div>                  
                </div> 
			<?php 
				}
			} else echo 'No Reviews Found';
			
			?> 
  <div class="paging_box"> <?php echo $page_links?></div>