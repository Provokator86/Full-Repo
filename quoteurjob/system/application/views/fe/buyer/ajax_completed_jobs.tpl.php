<script>
			$(".lightbox_main").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

</script>
<div class="shadow_big">
                              <div class="right_box_all_inner" style="padding:0px;">
							  <?php
							  	if($job_list)
								{
								$i=1;
								//pr($job_list);
							  ?>
                                    <div class="top_bg_banner">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                      <td valign="top" width="13"></td>
                                                      <td valign="top" width="389" align="left"><?php echo t('Jobs Details')?></td>
                                                      <td valign="top" width="196" align="left"><?php echo t('Tradesman Details')?></td>
                                                    
                                                      <td valign="top" width="115" align="center"><?php echo t('Options')?> </td>
                                
                                                </tr>
                                          </table>
                                    </div>
									<?php
										foreach($job_list as $val)
										{
											//echo $val['id'];
									?>
                                    <div class="<?php echo ($i++%2)? 'white_box': 'sky_box';?>">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                           <tr>
                                                     
                                                      <td width="402" valign="top">
                                                      <h5><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a></h5>
                                                     
                                                      <p> <?php echo t('Category')?>: <span class="light_grey_txt"><?=$val['s_category_name']?></span> &nbsp; | &nbsp;  <?php echo t('Completed on')?> <span class="light_grey_txt"><?=$val['dt_completed_date']?></span>
                                                 </p></td>
                                                <td width="200" align="left">
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="small_table">
                                                              <tr>
                                                                    <td width="20"><img src="images/fe/email.png" alt="" /></td>
                                                                    <td width="141"><a href="mailto:<?=$val['s_email']?>" class="grey_link"><?=$val['s_email']?></a></td>
                                                              </tr>
                                                              <tr>
                                                                    <td width="20"><img src="images/fe/phone.png" alt="" /></td>
                                                                    <td><?=$val['s_contact_no']?></td>
                                                              </tr>
                                                              <tr>
                                                                    <td width="20" valign="top"><img src="images/fe/address.png" alt="" /></td>
                                                                    <td><?=$val['s_address']?></td>
                                                              </tr>
                                                        </table>                                                 </td>
                                                     
                                                  
                                                 <td width="117" align="center" valign="top"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View')?>" title="<?php echo t('View')?>" /></a>  &nbsp;
												 <!--<a href="#history_div" class="lightbox_main"><img src="images/fe/history.png" alt="History" title="History"/></a> -->
												 <a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/history.png" alt="<?php echo t("History")?>" title="<?php echo t("History")?>"/></a> &nbsp; 
												 <a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board')?>" title="<?php echo t('My Private Message Board')?>" /></a> &nbsp; <a href="<?=base_url().'buyer/job_feedback/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/feedback.png" alt="<?php echo t('Feedback')?>" title="<?php echo t('Feedback')?>" /></a></td>
                                                    
                                                </tr>
                                          </table>
                                    </div>
                                   <?php
								   		}
								   } else echo  '<div class="white_box" style="padding:5px;">'.t('No job found').'</div>';
								   ?> 
									
                                    
                              </div>
                        </div>
						
						<div class="page"> <?=$page_links?></div>