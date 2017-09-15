<script>
			$(".lightbox_main").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

</script>
<div class="shadow_big" >
                        <div class="right_box_all_inner" style="padding:0px;">
						<?php
						
						?>
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="9"></td>
                                                <td valign="top" width="464" align="left"><?php echo t('Job Details')?> </td>
                                           
                                                <td valign="top" width="109" align="center"><?php echo t('Option')?> </td>
                                          </tr>
                                    </table>
                              </div>
							  <?php
							  	if($job_list)
									{
							  	//pr($job_list);
							  	$i=1;
							  	foreach($job_list as $val)
								{
							  ?>
                              <div class="<?=($i++%2)?'white_box':'sky_box'?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="463"><h5><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a></h5>
                                                      <p><?=$val['s_description']?></p>
                                                      <p><?php echo t('Category')?>: <span class="light_grey_txt"><?=$val['s_category_name']?></span> &nbsp; | &nbsp; <?php echo t('Completion Date')?>: <span class="light_grey_txt"><?=$val['dt_completed_date']?></span>  &nbsp; | &nbsp; <?php echo t('Buyer')?> : <a class="blue_link lightbox_main" href="#job_creator_div"> </a><?=$val['s_buyer_name']?></p></td>
                                                
                                                <td valign="top"  width="109" align="center"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" title="<?php echo t('View');?>" alt="<?php echo t('View');?>"/></a>  &nbsp;  <a href="<?=base_url().'tradesman/job_feedback/'.encrypt($val['id']);?>" class="lightbox_main"><img src="images/fe/feedback.png" alt="<?php echo t('Feedback');?>" title="<?php echo t('Feedback');?>"/></a> &nbsp; 
												
												<a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/history.png" alt="<?php echo t('History');?>" title="<?php echo t('History');?>"/></a> &nbsp;
												</td>
                                          </tr>
                                    </table>
                              </div>
							  <?php }
							  } else {
							  		echo '<div class="white_box" style="padding:5px;"> '.t('No job found').'</div>';
									
									}
							  ?>
							  
                              
                        </div>
                  </div>
                  <div class="page"> 
				  <?php echo $page_links;?>
				  </div>
                  <div class="spacer"></div>