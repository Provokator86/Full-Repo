<script>
	$(document).ready(function() {
			$(".lightbox_main").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});

</script>

<div class="shadow_big" style="margin-top:5px;">
                        <div class="right_box_all_inner" style="padding:0px;">
                             
							  <?php
							 // pr($tradesman_list);
							  if($tradesman_list)
							  {
							  	$i=1;
							  	  foreach($tradesman_list as $val)
								  {
								//$img = (!empty($info["image"])&&file_exists($image_up_path."thumb_".trim($info["image"])))?" <img src='".$image_path."thumb_".$info["image"]."' />":" <img src='images/fe/man.png'/>";
								$img = (!empty($val["s_user_image"])&&file_exists($image_up_path."thumb_".trim($val["s_user_image"])))?" <img src='".$image_path."thumb_".$val["s_user_image"]."' width='66' height='65'  />":" <img src='images/fe/man.png'/>";
							  ?>
                              
							  
							  <div class="<?php echo ($i++%2) ? 'white_box':'white_box sky_box'?>">
                                    <div class="photo"><a href="<?php echo base_url();?>tradesman_profile/<?php echo encrypt($val['id'])?>"><?php echo $img;?></a></div>
                                    <div class="inner_box"> <span class="right"><a href="<?php echo base_url().'invite_tradesman/'.encrypt($val['id']);?>" class="lightbox_main blue_link" style="font-size:11px;"><?php echo t('Invite')?></a> | <a href="<?php echo base_url();?>tradesman_profile/<?php echo encrypt($val['id'])?>" class="blue_link" style="font-size:11px;"><?php echo t('View Profile')?> </a></span>
                                          <h6><a href="<?php echo base_url();?>tradesman_profile/<?php echo encrypt($val['id'])?>" class="red_link"><?php echo $val['s_name']?></a><span> - <?php echo t('Member since')?> <?php echo $val['dt_created_on']?></span><br />
                                            <span class="black_txt"><?php echo $val['s_city']?>, <?php echo $val['s_postal_code']?></span> </h6>
                                          <div class="inner_box_left">
                                                <h5><?php echo t('Main Skills & Trades')?>:</h5>
                                                <?php echo $val['s_skills']?><br />
												<?php if($val['i_feedback_received']>0) { ?>
                                                <?php echo $val['i_feedback_received']?> <?php echo t('Feedback reviews')?>,
												<?php } ?>
												<?php if($val['f_positive_feedback_percentage']>0) { ?>
												 <span class="pink_txt"><?php echo $val['f_positive_feedback_percentage']?>% <?php echo t('positive')?></span> 
												 <?php } ?>
											</div>
										
                                          <div class="inner_box_right"> 
										  <?php if($val['i_jobs_won'] > 0) { ?>
										  <span><?php echo $val['i_jobs_won']?> </span> <?php echo t('jobs won')?><br />
										  <?php } ?>
                                               <?php /*?> <span>35 </span>feedback comments<?php */?><br />
                                               <?php echo show_star($val['i_feedback_rating']);?>
											</div>
										<?php if($val['i_feedback_received']>0) { 
											$feedback = $val['feedback'];
										?>	
                                          <div class="com_job"> <img src="images/fe/dot1.png" alt="" class="left" />
                                                <p><em><?php echo $feedback['s_comments']?></em></p>
                                                <img src="images/fe/dot2.png" alt=""  class="right"/>
                                                <div class="spacer"></div>
												<?php if($feedback['i_positive'] == 1) {?> 
                                                <div class="feedback_img">
													<img src="images/fe/icon02.png" alt="" style="margin-right:5px;" />
														<?php echo t('Positive feedback');?>
												</div>
												 <?php } ?> 
                                                <h2 style="text-align:right;" class="right">- <?php echo $feedback['s_sender_user']?><br/>
                                                      <span> <?php echo $feedback['dt_created_on']?></span></h2>
                                                <div class="spacer"></div>
                                          </div>
										 <?php 
										 } else {
										 	echo '<div class="no_feedback"> '.t('No Feedback rating yet').'</div>';									  
										 }
										 ?> 
                                    </div>
                                    <div class="spacer"></div>
                              </div>
							  
                         	<?php 
								}
							} else echo '<div class="white_box" style="padding:5px;">'.t('No Record Found').'</div>';?>     
                              
                        </div>
                  </div>
                  <div class="page"> <?=$page_links?></div>