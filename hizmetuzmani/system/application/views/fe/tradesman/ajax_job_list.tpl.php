<div class="shadow_big" style="margin-top:5px;">
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="8"></td>
                                                <td width="406" align="left"><?php echo t('Jobs Title')?></td>
                                                <td width="116" align="center"><?php echo t('Location')?></td>
                                                <td width="79" align="center"><?php echo t('Option')?></td>
                                                <td width="104" align="center"><?php echo t('Action')?></td>
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
                              <div class="<?php echo ($i++%2) ? 'white_box':'sky_box'?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="403"><h5><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?php echo $val['s_title']?></a></h5>
                                                      <p><?php echo $val['s_description']?></p>
                                                      <p> <?php echo t('Time left')?>: <span class="light_grey_txt"><?php echo $val['s_days_left']?></span> &nbsp; | &nbsp; <?php echo t('Budget')?>: <span class="light_grey_txt"><?php echo $val['s_budget_price']?></span></p></td>
                                                <td width="117" align="center" valign="top"><?php echo $val['s_state']?>, <?php echo $val['s_city']?>, <br />
                                                      <?php echo $val['s_postal_code']?></td>
												 <td width="66" align="center" valign="top"><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>" /></a>   </td>
                                               
                                                <td width="105" align="center" valign="top"><input name="" type="button" class="pink_button01" value="<?php echo t('Quote Now');?>"  onclick="window.location.href='<?php echo base_url().'job/quote_job/'.encrypt($val['id'])?>'"/></td>
                                          </tr>
                                    </table>
                              </div>
                         	<?php 
								}
							} else echo ' <div class="white_box">'.t('No Record Found').'</div>';?>     
                              
                        </div>
                  </div>
                  <div class="page"> <?=$page_links?></div>