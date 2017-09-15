<script>
			$(".lightbox_main").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

</script>
<div class="shadow_big">
                              <div class="right_box_all_inner" style="padding:0px;">
                                    <div class="top_bg_banner">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                      <td valign="top" width="11"></td>
                                                      <td valign="top" width="236" align="left"><?php echo t('Jobs Details')?></td>
                                                      <td valign="top" width="169" align="left"><?php echo t('Tradesman Details')?></td>
                                                    
                                                      <td width="112" align="center"><?php echo t('Status')?> </td>
                                                      <td valign="top" width="90" align="center"><?php echo t('Options')?> </td>
                                                      <td valign="top" width="95" align="center"><?php echo t('Action')?></td>
                                                </tr>
                                          </table>
                                    </div>
									<?php
									if($job_list)
									{
										$i=1;
										foreach($job_list as $val)
										{
											//echo $val['id'];
									?>
                                    <div class="<?php echo ($i++%2)? 'white_box': 'sky_box';?>">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                   
                                                      <td width="250" valign="top">
                                                      <h5><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?php echo $val['s_title']?></a></h5>
                                                    
                                                       <p><?php echo t('Category')?>: <span class="light_grey_txt"><?php echo $val['s_category_name']?></span> &nbsp; | &nbsp;   <?php echo t('Assigned on')?> <span class="light_grey_txt"><?php echo $val['dt_fn_assigned_date']?></span> &nbsp;</p>
                                                      </td>
                                                      <td width="176" align="left" valign="top">
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
                                                        </table>                                                   </td>
                                                      
                                                      <td width="117" align="center" valign="top" class="">
													  <?=$val['s_is_active']?> 
													  <?php
													  if($val['i_status']==5)
													  {
													  ?>
													   <?php /*?><a href="javascript:void(0)" onclick="tb_show('', '<?php echo base_url().'buyer/give_feedback/'.$val['id']?>?height=400&width=400');"  class="blue_link"><strong>Accept</strong></a> &nbsp; &nbsp; 
													   <a href="javascript:void(0)" onclick="tb_show('', '<?php echo base_url().'buyer/deny_feedback/'.$val['id']?>?height=300&width=400');"  class="blue_link"><strong>Deny</strong></a> <?php */?>													    
															<a href="<?php echo $pathtoclass.'give_feedback/'.$val['id']?>" class="lightbox_main blue_link"><strong><?php echo t('Accept')?></strong></a> &nbsp; &nbsp; 															
															<a href="<?php echo $pathtoclass.'deny_feedback/'.$val['id']?>" class="lightbox_main blue_link"><strong><?php echo t('Deny')?></strong></a> 
													  <?php
													  }
													  ?>
													  
													  </td>
													
													  
													   
                                                      <td width="97" align="center" valign="top"><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><img src="images/fe/view.png" alt="<?php echo t('View')?>" title="<?php echo t('View')?>" /></a>  &nbsp;
													  <!--<a href="#history_div" class="lightbox_main"><img src="images/fe/history.png" alt="History" title="History"/></a>--> 
													  <a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/history.png" alt="<?php echo t("History")?>" title="<?php echo t("History")?>"/></a> &nbsp; 
													  <a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board')?>" title="<?php echo t('My Private Message Board')?>" /></a> </td>
                                                      <td width="86" align="center" valign="top">
													  <?php
													  if($val['i_status']==4)
													  { 
													  ?>
													  <?php /*?><a class="terminate_btn" href="javascript:void(0)" onclick="tb_show('', '<?php echo base_url().'buyer/job_terminate_box/'.$val['id']?>?height=450&width=400');"><strong>Terminate</strong></a><?php */?>
													  <a class="lightbox_main terminate_btn" href="<?php echo base_url().'buyer/job_terminate_box/'.$val['id']?>" ><strong><?php echo t('Terminate')?></strong></a>
													  <?php } ?>
													  </td>
                                                </tr>
                                          </table>
                                    </div>
                                   <?php
								   		}
								   }else echo  '<div class="white_box" style="padding:5px;">'.t('No job found').'</div>';
								   ?> 
                              </div>
                        </div>