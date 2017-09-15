<div id="div_container">
<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
         	<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			
			<?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
            <div class="body_right">
                  <h1><img src="images/fe/dashboard_red.png" alt="" /> <?php echo get_title_string(t('Dashboard'))?> </h1>
                  <div class="top_box">
				  
                        <h3><span><?php echo t('Welcome')?></span><?php echo ' '.$name ?> </h3>
                       <!-- <h3><span>You have </span>2 <span>new messages</span></h3>-->
                        <h3><span><?php echo t('Local time is') ?></span> <?php echo '	'.$dt_current_time?></h3>
						
                  </div>
                <div>  <h3><?php echo t('My  Open Jobs')?><a href="<?php echo base_url().'buyer/active_jobs'?>" class="red_link right"><em><?php echo t('View more')?>..</em>.</a></h3>
				
                  <div class="shadow_big">
				  
                        <div class="right_box_all_inner" style="padding:0px;">
						
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="8"></td>
                                                <td valign="top" width="244" align="left"><div style="width:275px;"><?php echo t('Job Title')?></div></td>
                                                <td valign="top" width="176" align="center"><?php echo t('Quotes')?></td>
                                                <td valign="top" width="196" align="center"><?php echo t('Expiry Date')?></td>
                                              <td valign="top" width="89" align="center"><?php echo t('Option')?> </td>
                                          </tr>
                                    </table>
                              </div>
							  <?php
							  if($open_jobs)
							  {
							  	$i=1;
							  	foreach($open_jobs as $val)
								{
							  ?>
                              <div class="<?=($i++%2)?'white_box':'sky_box'?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="273"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a>
                                                      <div style="width:270px;"><?=$val['s_description']?></div></td>
                                        
                                               <td valign="top" width="211" align="center"><strong><?=$val['i_quotes']?></strong></td>
                                                <td valign="top" width="219" align="center"><?=$val['dt_expired_date']?></td>
                                                <td valign="top" width="100" align="center"> <a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="View" title="View" /></a>  </td>
                                          </tr>
                                    </table>
                              </div>
                              <?php
							  	}
							  
							  } else echo '<div class="white_box" style="padding:5px;">'.t('No record found').'</div>';
							  ?> 
                               
                              
                               
                        </div>
                  </div>
                  <div class="spacer"></div></div>
                   <div style="padding-top:20px;">  <h3><?php echo t('Completion Alert of Jobs')?></h3>
                  <div class="shadow_big">
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="11"></td>
                                                <td valign="top" width="273" align="left"><?php echo t('Job Title')?>  </td>
                                                <td valign="top" width="212" align="center"><?php echo t('Tradesman Name')?></td>
                                                <td valign="top" width="217" align="center"><?php echo t('Status')?></td>
                                                <td valign="top" width="89" align="center"><?php echo t('Option')?> </td>
                                          </tr>
                                    </table>
                              </div>
							  <?php
							  if($feedback_job_list)
							  {
							  	$i=1;
							  	foreach($feedback_job_list as $val)
								{ 
							  ?>
                              <div class="<?=($i++%2)?'white_box':'sky_box'?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                           <tr>
                                                <td valign="top" width="239"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?php echo $val['s_title']?></a><br/>
                                                       <?=$val['s_description']?></td>
                                        
                                               <td valign="top" width="189" align="center"><a href="<?php echo base_url().'tradesman_profile/'.encrypt($val['i_tradesman_id']) ?>" class="blue_link"><?php echo $val['s_username'] ?></a></td>
                                                <td valign="top" width="188" align="center"><?php echo t('Tradesman declared')?> <br />
<?php echo t('job as completed')?><br/>
                                                            
															<a href="<?php echo $pathtoclass.'give_feedback/'.$val['id']?>" class="lightbox_main blue_link"><strong><?php echo t('Accept')?></strong></a> &nbsp; &nbsp; 
															
															<a href="<?php echo $pathtoclass.'deny_feedback/'.$val['id']?>" class="lightbox_main blue_link"><strong><?php echo t('Deny')?></strong></a>  
															</td>
                                                             <td valign="top" width="87" align="center"> <a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>" /></a>  </td>
                                          </tr>
                                    </table>
                              </div>
                             <?php
							  	}							  
							  } else echo '<div class="white_box" style="padding:5px;">'.t('No record found').'</div>';
							  ?>    
                               
                                       
                        </div>
                  </div>
                  <div class="spacer"></div></div>
            </div>
			</div>
            <div class="spacer"></div>
      
	  </div>