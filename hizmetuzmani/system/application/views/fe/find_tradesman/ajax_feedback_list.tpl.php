							  <?php
							  if($feedback_list)
							  {
							  	$i=1;
							  	  foreach($feedback_list as $val)
								  {
									$job_link = base_url().'job/job_details/'.encrypt($val['i_job_id']);
							  ?>
                              
							  
							  <div class="<?php echo ($i++%2) ? 'feedback_div':'feedback_div_blue'?>">                                     
                                                <div class="left">
													<a href="<?php echo $job_link;?>" class="grey_link">
														<strong><?php echo  $val['s_job_title']?></strong>
													</a>
												</div>
                                                <div class="right">
													<?php echo show_star($val['i_rating']);?>
													<?php echo  $val['s_category_name']?>
												</div>
                                                <div class="spacer"></div>
												<?php if($val['i_status']==2) {?>
												<div class="terminate_box"><span class="pink_txt"><?php echo t('This job was terminated by the ')?><?php echo  $val['s_sender_user']?> <?php echo t('for')?> : </span><br />
                                               <?php echo  $val['s_terminate_reason']?></div>
												<?php }?>
                                                <div class="com_job "> <!--<img src="images/fe/dot1.png" width="8" height="6" alt="" />-->
                                                      <div style="background:url(images/fe/dot1.png) no-repeat;padding-left:10px;"> <p><em><?php echo  $val['s_comments']?></em></p>
                                                      <img src="images/fe/dot2.png" alt=""  class="right"/>
                                                      <div class="spacer"></div></div>
                                                       <?php if($val['i_positive'] == 1){ ?>
														  <div class="feedback_img">
															<img src="images/fe/icon02.png" alt="" style="margin-right:5px;" />
															<?php echo t('Positive feedback')?>
														  </div>
													  <?php } 
													  		else {
													  ?>
													  	 <div class="feedback_img">
															<img src="images/fe/icon05.png" alt="" style="margin-right:5px;" />
															<?php echo t('Negetive feedback')?>
														  </div>
														  <?php } ?>
                                                     <h2 style="text-align:right;"class="right">- <?php echo $val['s_sender_user']?><br/>
                                                            <span> <?php echo $val['dt_created_on']?></span></h2>
                                                      <div class="spacer"></div>
                                                </div>
                                        
                                                                                  
                                          
                              </div>
							  
                         	<?php 
								}
							} else echo t('No Record Found');?>     
                              
                      
                  <div class="page"> <?=$page_links?></div>