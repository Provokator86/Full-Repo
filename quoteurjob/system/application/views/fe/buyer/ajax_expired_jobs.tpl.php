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
							  	
							  ?>
                                    <div class="top_bg_banner">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="12"></td>
                                                <td valign="top" width="583" align="left"><?php echo t('Jobs Details')?></td>
                                               
                                                <td valign="top" width="118" align="center"><?php echo t('Options')?> </td>
                                          </tr>
                                    	</table>
                                    </div>
									<?php
									if($job_list)
									{
									$i=1;
									//pr($job_list);
										foreach($job_list as $val)
										{
											//echo $val['id'];
									?>
                                    <div class="<?php echo ($i++%2)? 'white_box': 'sky_box';?>">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="587" valign="top"><h5><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a></h5>
                                                    
                                                <p><?php echo t('Category')?>: <span class="light_grey_txt"><?=$val['s_category_name']?></span> &nbsp; | &nbsp; <?php echo t('Expired on')?> <span class="light_grey_txt"><?=$val['dt_expired_date']?></span> &nbsp; | &nbsp; <?php echo t('Budget')?>: <span class="light_grey_txt"><?=$val['s_budget_price']?></span></p></td>
                                             
                                                
                                                <td width="116" align="center" valign="top"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View')?>" title="<?php echo t('View')?>" /></a>  &nbsp;
												<?php /*?><a href="javascript:void(0)" onclick="tb_show('', '<?php echo base_url().'buyer/chk_delete/'.encrypt($val['id'])?>?height=150&width=400');"><img src="images/fe/del_icon.png" alt="Delete" title="Delete" /></a> <?php */?>
												<a href="<?php echo base_url().'buyer/chk_delete/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/del_icon.png" alt="<?php echo t("Delete")?>" title="<?php echo t("Delete")?>" /></a>&nbsp; 
												<!--<a href="#history_div" class="lightbox_main"><img src="images/fe/history.png" alt="History" title="History"/></a>-->
												<a href="<?php echo base_url().'job/job_history/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/history.png" alt="<?php echo t("History")?>" title="<?php echo t("History")?>"/></a> &nbsp; 
												<a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board')?>" title="<?php echo t('My Private Message Board')?>" /></a> </td>
                                          </tr>
                                    </table>
                                    </div>
                                   <?php
								   		}
								   }else
								   	{	
									echo '<div class="white_box" style="padding:5px;">'.t(' No job found').'</div>'; 
									}
								   ?> 
									
                                    
                              </div>
                        </div>
						
						<div class="page"> <?=$page_links?></div>