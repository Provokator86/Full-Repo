<div>
                        <div id="feedback_div" class="lightbox" style="width:700px;">
                              <h1> <?php echo get_title_string(t('Feedback'))?></h1>
                              <div class="feedback_div_blue">
                                    <div class="left"><a href="<?=base_url().'job/job_details/'.encrypt($feedback_details[0]['i_job_id'])?>" class="grey_link"><strong><?=$feedback_details[0]['s_job_title']?></strong></a></div>
                                    <div class="right"> <?=show_star($feedback_details[0]['i_rating'])?></div>
                                    <div class="spacer"></div>
                                    <div class="com_job "> <img src="images/fe/dot1.png" alt="" class="left" />
                                          <p><em><?=$feedback_details[0]['s_comments']?></em></p>
                                          <img src="images/fe/dot2.png" alt=""  class="right"/>
                                          <div class="spacer"></div>
										  <?php
										  if($feedback_details[0]['i_positive'])
										  {
										  ?>
                                          <div class="feedback_img"><img src="images/fe/icon02.png" alt="" style="margin-right:5px;" /><?php get_title_string(t('Positive feedback'))?></div>
								<?php
								}
								else
								{
								?>		  
										  <div class="feedback_img_negative"><img style="margin-right: 5px;" alt="" src="images/icon05.png"><?php echo get_title_string(t('Negative feedback'))?></div>
								<?php } ?>		  
										  
                                          <h2 style="text-align:right;" class="right">- <?=$feedback_details[0]['s_sender_user']?><br/>
                                                <span> <?=$feedback_details[0]['dt_created_on']?></span></h2>
                                          <div class="spacer"></div>
                                    </div>
                              </div>
                        </div>
                  </div>