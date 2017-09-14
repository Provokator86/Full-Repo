<div class="shadow_big" >
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                               <td valign="top" width="6"></td>
                                                <td valign="top" width="350" align="left"><?php echo t('Job Details')?> </td>                                           
                                                <td valign="top" width="121" align="center"><?php echo t('Location')?> </td>
                                                <td valign="top" width="77" align="center"><?php echo t('Option')?> </td>
                                                <td valign="top" width="104" align="center"><?php echo t('Action')?> </td>
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
										  	 <td valign="top" width="401"><h5><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a></h5>
                                                      <p><?=$val['s_description']?></p>
                                                      <p><?php echo t('Category')?>: <span class="light_grey_txt"><?=$val['s_category_name']?></span>  &nbsp; | &nbsp;  <?php echo t('Expiry Date')?> <span class="light_grey_txt"><?=$val['dt_expired_date']?></span>&nbsp; | &nbsp; <?php echo t('Budget')?>: <span class="light_grey_txt"><?=$val['s_budget_price']?></span></p></td>
                                               
                                                <td valign="top" width="121" align="center"><?=$val['s_state']?>, <?=$val['s_city']?>, <br>
                                                      <?=$val['s_postal_code']?></td>
                                                <td valign="top" width="76" align="center"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>" /></a>  &nbsp; 
												
												<a href="<?php echo base_url().'tradesman/chk_invite_job_delete/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/del_icon.png" alt="<?php echo t('Delete');?>" title="<?php echo t('Delete');?>"/></a>
												</td>
                                                <td valign="top" width="105" align="center"> 
												
												<input class="pnk_btn" type="button" onclick="window.location.href='<?=base_url().'job/quote_job/'.encrypt($val['id'])?>'" value="<?php echo t('Quote Now');?>" name="">
												</td>
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
				  
                  