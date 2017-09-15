<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                   <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>

            <div class="body_right">
                  <h1><img src="images/fe/dashboard_red.png" alt="" /> <?php echo get_title_string(t('Dashboard'))?> </h1>
                  <div class="top_box">
                        <h3><span><?php echo t('Welcome')?></span> <?php echo ' '.$name ?></h3>
                        <!--<h3><span>You have </span>2 <span>new messages</span></h3>-->
                        <h3><span><?php echo t('Local time is ') ?> </span><?=$dt_current_time?></h3>
                  </div>
                <div>  <h3><?php echo t('My  Quotes')?><a href="<?php echo base_url().'tradesman/quote_jobs'?>" class="red_link right"><em><?php echo t('View more')?>..</em>.</a>  </h3>
                      <div class="shadow_big">
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="11"></td>
                                                <td valign="top" width="273" align="left"><?php echo t('Job Title')?>  </td>
                                                <td valign="top" width="210" align="center"><?php echo t('Quotes')?></td>
                                                 <td valign="top" width="88" align="center"><?php echo t('Options')?> </td>
                                                <td valign="top" width="219" align="center"> <?php echo t('Status')?></td>
                                             
                                          </tr>
                                    </table>
                              </div>
							  
                              <?php
							   if($quote_details)
				  				{
				  				$i=1;

							  foreach($quote_details as $val)
							  {				  
							  ?>

							  
							  <div class="<?=($i++%2)?'white_box':'sky_box'?>">
                              
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="273"><a href="<?=base_url().'job/job_details/'.encrypt($val['i_job_id'])?>" class="blue_link"><?=$val['job_details']['s_title']?></a><br/>
                                                      <p><?php echo substr_details($val['job_details']['s_description'])?></p>
                                                      <p><?php echo t('Date')?> :<span class="light_grey_txt"> <?=$val['dt_entry_date']?></span></p>                                                      
                                                      </td>
                                        
                                               <td valign="top" width="211" align="center"><strong><?=$val['job_details']['i_quotes']?></strong></td>
                                                  <td width="97" align="center" valign="top"><a href="<?=base_url().'job/job_details/'.encrypt($val['i_job_id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>"/></a>  </td>
                                                <td valign="top" width="219" align="center"><?php echo t('Quote placed')?> <br />
                                                      (<?=$val['s_quote']?>)</td>
                                          </tr>
                                    </table>
								
                              </div>
                               <?php } 
							   }else echo '<div class="white_box" style="padding:5px;">'.t('No Record Found').'</div>';
							   ?>
                               
                               
                              
                               
                        </div>
                  </div>
                      <div class="spacer"></div>
                  
                       <input name="" type="button" class="button" value="<?php echo t('My Won jobs')?>"  onclick="window.location.href='<?=base_url().'tradesman/my_won_jobs'?>'"    />
                           
                <!--<input name="" type="button" class="button" value="My Lost Jobs"   onclick="window.location.href='tradesman_lost_jobs.html'"  />-->
                  </div>
                   <div style="padding-top:20px;">  <h3><?php echo t('My Feedbacks')?><a href="<?php echo base_url().'tradesman/feedback_received'?>" class="red_link right"><em><?php echo t('View more')?>..</em>.</a></h3>
                  <div class="shadow_big" >
                        <div class="right_box_all_inner" style="padding:5px;">
                              
							  <?php
							  if($feedback_job_list)
							  {
							  $i=1;
							  	foreach($feedback_job_list as $val)
								{ $job_link = base_url().'job/job_details/'.encrypt($val['i_job_id']);
							  ?>
							  
                            <div class="<?php echo ($i++%2) ? 'feedback_div':'feedback_div_blue'?>">                                     
                                                <div class="left">
													<a href="<?php echo $job_link;?>" class="grey_link">
														<strong><?php echo  $val['s_job_title']?></strong>
													</a>
												</div>
                                                <div class="right">
													<?php echo show_star($val['i_rating']);?>
													<?php echo  $val['s_category_name']?>
												</div>
                                                <div class="spacer"></div>
												<?php if($val['i_status']==2) {?>
												<div class="terminate_box"><span class="pink_txt"><?php echo t('This job was terminated by the ')?><?php echo  $val['s_sender_user']?> <?php echo t('for')?> : </span><br />
                                               <?php echo  $val['s_terminate_reason']?></div>
												<?php }?>
                                                <div class="com_job "> <!--<img src="images/fe/dot1.png" width="8" height="6" alt="" />-->
                                                      <div style="background:url(images/fe/dot1.png) no-repeat;padding-left:10px;"> <p><em><?php echo  $val['s_comments']?></em></p>
                                                      <img src="images/fe/dot2.png" alt=""  class="right"/>
                                                      <div class="spacer"></div></div>
                                                       <?php if($val['i_positive'] == 1){ ?>
														  <div class="feedback_img">
															<img src="images/fe/icon02.png" alt="" style="margin-right:5px;" />
															<?php echo t('Positive feedback')?>
														  </div>
													  <?php } 
													  		else {
													  ?>
													  	 <div class="feedback_img">
															<img src="images/fe/icon05.png" alt="" style="margin-right:5px;" />
															<?php echo t('Negetive feedback')?>
														  </div>
														  <?php } ?>
                                                     <h2 style="text-align:right;"class="right">- <?php echo $val['s_sender_user']?><br/>
                                                            <span> <?php echo $val['dt_created_on']?></span></h2>
                                                      <div class="spacer"></div>
                                                </div>
                                        
                                                                                  
                                          
                              </div>
                            <?php } 
							}else echo '<div class="feedback_div" style="padding:5px;">'.t('No Record Found').'</div>';
							?>  
                              
                              
                              
                              
                        </div>
                  </div>
                  <div class="spacer"></div></div>
            </div>
            </div>
            <div class="spacer"></div>
      </div>