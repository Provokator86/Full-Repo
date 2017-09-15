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
                                                <td valign="top" width="9"></td>
                                                <td valign="top" width="435" align="left"><?php echo t('Jobs Details')?></td>
                                                <td valign="top" width="127" align="center"><?php echo t('Status')?></td>
                                                <td valign="top" width="142" align="center"><?php echo t('Options')?></td>
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
                              <div class="<?php echo ($i++%2) ? 'white_box' : 'sky_box'?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="435"><h5><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?php echo $val['s_title']?></a></h5>
                                                      <p> <?php echo $val['s_description']?></p>
                                                      <p><?php echo t('Category')?>: <span class="light_grey_txt"><?php echo $val['s_category_name']?></span> &nbsp; | &nbsp;   <?php echo t('Posted on')?> <span class="light_grey_txt"><?php echo $val['dt_entry_date']?></span> &nbsp; | &nbsp; <?php echo t('Time left')?>: <span class="light_grey_txt"><?php echo $val['s_days_left']?></span> &nbsp; | &nbsp; <?php echo t('Budget')?>: <span class="light_grey_txt"><?php echo $val['s_budget_price']?></span></p></td>
                                                <td valign="top" width="125" align="center"><?php echo $val['s_is_active']?></td>
                                                <td valign="top" width="143" align="center">
												<a href="<?php echo base_url().'job/job_details/'.encrypt($val['id']);?>"><img src="images/fe/view.png" alt="<?php echo t('View')?>" title="<?php echo t('View')?>" /></a>  &nbsp; 
												<?php
												if($val['i_status']==0 || $val['i_status']==1 || $val['i_status']==3 || $val['i_status']==4 || $val['i_status']==5){
												?>
												<a href="<?php echo base_url().'buyer/job_edit/'.encrypt($val['id']);?>"><img src="images/fe/edit.png" alt="<?php echo t('Edit')?>" title="<?php echo t('Edit')?>" /></a> &nbsp; 
												<?php } 
												if($val['i_status']==0 || $val['i_status']==2 || $val['i_status']==7){
												?>
												<?php /*?><a href="javascript:void(0)" onclick="tb_show('', '<?php echo base_url().'buyer/chk_delete/'.encrypt($val['id'])?>?height=150&width=400');"><img src="images/fe/del_icon.png" alt="Delete" title="Delete" /></a><?php */?>
												<a href="<?php echo base_url().'buyer/chk_delete/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/del_icon.png" alt="<?php echo t("Delete")?>" title="<?php echo t("Delete")?>" /></a> &nbsp; 
												<?php } ?>
												<!--<a href="#history_div" class="lightbox_main"><img src="images/fe/history.png" alt="History" title="History"/></a>-->
												<a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/history.png" alt="<?php echo t("History")?>" title="<?php echo t("History")?>"/></a> &nbsp; 
												<a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')">
												<?php /*?><a href="javascript:void(0);" onclick="window.location.href='<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['id'])?>'"><?php */?>
												<img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board')?>" title="<?php echo t('My Private Message Board')?>" /></a> </td>
                                          </tr>
                                    </table>
                              </div>
							  <?php
							  		}
							  }	else
							  	echo  '<div class="white_box" style="padding:5px;">'.t('No job found').'</div>';
							  ?>
							  
                              
                              
                              
                        </div>
                  </div>
                  <div class="page"> <?php echo $page_links;?></div>
                  <div class="spacer"></div>