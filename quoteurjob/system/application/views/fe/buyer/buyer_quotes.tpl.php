<script>
function send_msg(param)
{
	$('#opd_job').val(param);
	$('#frm_msg').submit();
}
</script>

<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                   <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<div id="div_err">
				<?php
					echo validation_errors();
				?>
				</div>
            <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
            <div class="body_right">
                  <h1><img src="images/fe/feedback01.png" alt="" /> <?php echo t('Quote(s)')?> </h1>
                  <h3 style="border:0px; padding-top:0px;"><span><?php echo t('Job Overview')?></span></h3>
                  <div class="shadow_big">
                        <div class="right_box_all_inner">
                             <div style="line-height:20px;"> <a href="<?php echo base_url().'job/job_details/'.encrypt($job_details['id']);?>" class="blue_link" style="font-size:14px;"><?php echo $job_details['s_title']?></a><br />
                                 <?php echo t('Budget')?>: <span class="pink_txt"><?php echo $job_details['s_budget_price']?></span>&nbsp; | &nbsp; <?php echo t('Lowest Bid')?> : <span class="pink_txt"><?php echo $job_details['s_lowest_quote']?></span></div>
                                
                             
                              <p><?php echo $job_details['s_description']?></p>
                        </div>
                  </div>
                  <h3 style="border:0px;"> <span><?php echo t('Total no. of Quote(s) placed')?>:</span> <?php echo $job_details['i_quotes']?></h3>
                  <h3 style="border:0px;"> <span><?php echo t('View Quote(s)')?></span></h3>
                  <div class="shadow_big">
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="7"></td>
                                                <td width="189" align="center" valign="middle"><?php echo t('Tradesman')?>  </td>
                                                <td width="122" align="center" valign="middle"><?php echo t('Budget')?> </td>
                                                <td width="120" align="center" valign="middle"><?php echo t('City')?></td>
                                                <td width="159" align="center" valign="middle"><?php echo t('Action')?></td>
                                                <td width="116" align="center" valign="middle"><?php echo t('Options')?></td>
                                          </tr>
                                    </table>
                              </div>
							  
							  <?php
							  if($job_quote_details)
							  {
							  //pr($job_quote_details);
							  	foreach($job_quote_details as $val)
								{
								//pr($val);
							  ?>
                              <div class="<?php echo ($i++%2) ? 'white_box' : 'sky_box'?> ">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="185" align="center" valign="top"><a href="<?=base_url().'tradesman_profile/'.encrypt($val['i_tradesman_id'])?>" class="blue_link"><?php echo $val['s_username']?></a><br/>
                                                     <!-- <img src="images/fe/star.png" alt="" /> <img src="images/fe/star.png" alt="" /><img src="images/fe/star.png" alt="" /><img src="images/fe/half_star.png" alt="" /><img src="images/fe/half_star.png" alt="" />
                                                      <div class="feedback_img"><img src="images/fe/icon02.png" alt="" style="margin-right:5px;" />Positive feedback</div>-->
                                                       </td>
                                                <td width="122" align="center" valign="top"><?php echo $val['s_quote']?></td>
                                                <td width="121" align="center" valign="top"><?php echo $val['s_city']?></td>
                                                <td width="159" align="center" valign="top">
												<?php
												if($job_details['i_tradesman_id'] == $val['i_tradesman_id'])
													echo 'Assigned';
												elseif($job_details['i_is_active']==8 && $job_details['i_tradesman_id'])	
													echo '-';
												elseif(empty($job_details['i_tradesman_id']))
												{	
												?>
                                                      <a href="<?php echo $pathtoclass.'confirm_job_assign/'.encrypt($val['i_tradesman_id']).'/'.encrypt($job_details['id']).'/'.encrypt($val['id'])?>" class="lightbox_main terminate_btn" style="font-size:11px;"><strong><?php echo t('Accept Quote')?></strong></a>
												<?php } ?>	  
													  </td>
                                                <td width="116" align="center" valign="top">
												<a href="<?php
													echo base_url().'private_message/private_msg_land_buyer/'.encrypt($job_details['id']).'/'.encrypt($val['i_tradesman_id'])
												?>" ><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board')?>" title="<?php echo t('My Private Message Board')?>" /></a> </td>
                                          </tr>
                                    </table>
                              </div>
							  <?php
							  	}
							  } else echo  '<div class="white_box" style="padding:5px;">'.t('No quote found').'</div>';
							  ?>
                              
                              <div class="spacer"></div>
                        </div>
                  </div>
                  <div class="page"> <?php echo $pagination;?></div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>
</div>