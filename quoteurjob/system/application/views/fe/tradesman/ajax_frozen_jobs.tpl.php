<div class="shadow_big" >
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="7"></td>
                                                <td valign="top" width="352" align="left"><?php echo t('Job Details')?> </td>
                                                <td width="136" align="center"><?php echo t('Location')?></td>    
                                                <td width="138" align="center"><?php echo t('Status')?></td>
                                                <td valign="top" width="80" align="center"><?php echo t('Option')?> </td>
                                          </tr>
                                    </table>
                              </div>
							  <?php
							  if($job_list)
							  {
							  	$i=1;
							  	foreach($job_list as $val)
								{
							  ?>
                              <div class="<?=($i++%2)?'white_box':'sky_box'?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="349"><h5><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a></h5>
                                                      <p><?=$val['s_description']?></p>
                                                     <p> <?php echo t('Category')?>: <span class="light_grey_txt"><?=$val['s_category_name']?></span> </p>
                                                    </td>
                                                <td width="135" valign="top" align="center"><?=$val['s_state']?>, <?=$val['s_city']?>, <br />
                                                <?=$val['s_postal_code']?></td>
                                                <td width="139" align="center" valign="top" class=""><?php echo t('Job Awarded')?><br/>
                                              
												<a href="<?=base_url().'tradesman/pay_job/'.encrypt($val['id'])?>" class="blue_link"><strong><?php echo t('Accept')?></strong></a>												
												 &nbsp; &nbsp; 
												 <?php /*?><a href="javascript:void(0)" onclick="tb_show('', '<?php echo base_url().'tradesman/deny_job/'.$val['id']?>?height=150&width=400');" class="blue_link"><strong>Deny</strong></a><?php */?>
												 <a href="<?php echo base_url().'tradesman/deny_job/'.$val['id']?>" class="lightbox_main blue_link"><strong><?php echo t('Deny')?></strong></a>  </td>
                                                <td valign="top"  width="80" align="center"> <a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>" /></a>  &nbsp; 
												<?php /*?><a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><?php */?>
												<a href="javascript:void(0);" onclick="window.location.href='<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['id'])?>'"><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board');?>" title="<?php echo t('My Private Message Board');?>"/></a> &nbsp;</td>
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