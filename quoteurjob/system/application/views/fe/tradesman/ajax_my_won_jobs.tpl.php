<div class="shadow_big" >
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="5"></td>
                                                <td valign="top" width="420" align="left"><?php echo t('Jobs Details')?> </td>
                                              <td valign="top" width="104" align="center"><?php echo t('Status')?></td>
                                                <td valign="top" width="77" align="center"> <?php echo t('Option')?> </td>
                                               
                                                <?php /*?><td valign="top" width="107" align="center"><?php echo t('Action')?> </td><?php */?>
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
                                                <td valign="top" width="417"><h5><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a></h5>
                                                      <p><?=$val['s_description']?></p>
                                                      <p><?php echo t('Category')?>: <span class="light_grey_txt"><?php echo $val['s_category_name']?></span> &nbsp; | &nbsp; <?php echo t('Creation Date')?> :<span class="light_grey_txt"><?=$val['dt_entry_date']?></span> &nbsp; | &nbsp; <?php echo t('Buyer')?> : <?=$val['s_buyer_name']?> </p></td>
                                                <td valign="top" width="103" align="center"><?php echo $val['s_is_active']?></td>
                                                <td width="75" align="center" valign="top"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>" /></a> </td>
                                              
                                                											
												<?php /*?><a href="javascript:void(0);" onclick="window.location.href='<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['id'])?>'"><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board');?>" title="<?php echo t('My Private Message Board');?>"/></a><?php */?>
												
                                          </tr>
                                    </table>
                              </div>
							  <?php }
							  } else {
							  		echo '<div class="white_box" style="padding:5px;">'.t(' No job found').'</div>';
									
									}
							  ?>
							  
                              
                        </div>
                  </div>
                  <div class="page"> 
				  <?php echo $page_links;?>
				  </div>
                  <div class="spacer"></div>