<script type="text/javascript">
function show_all()
{
	$("#frm_sh_all").submit();
}

</script>

<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
			</div>	
			
            <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
			
            <div class="body_right">
                  <h1><img src="images/fe/msg_board.png" alt="" /><?php echo get_title_string(t('My Private Message Board'))?></h1>
                  <form name="seacrh_pmb" id="search_pmb" action="<?php echo base_url().'private_message/private_message_board'?>" method="post">
				  <div class="grey_box02" >
                        <h3 style="border:0px;"><?php echo t('Filter option')?> </h3>
                        <span class="left"><?php echo t('Job')?> &nbsp;</span>
                        <select name="opd_job" id="opd_job" style="width:270px; margin-right:15px;">                              
                              <option value=""><?php echo t('Select')?></option>
                              <?php echo makeOptionJob(" i_buyer_user_id='".decrypt($user_id)."' And i_status!=0 ",$posted['src_job_id']) ?>
                        </select>
                        <!--<script type="text/javascript">
							$(document).ready(function(arg) {
								$("#opd_job").msDropDown();
								$("#opd_job").hide();
							})
						</script>-->
                        <div class="spacer"></div>
                        <br />
                        <input  class="button" type="submit" value="<?php echo t('Search')?>" style="margin-left:30px;" />
                        &nbsp;
                        <input  class="button" onclick="javascript:show_all();" type="button" value="<?php echo t('Show All')?>" />
                  </div>
				  </form>
				  
                  <div class="shadow_big" >
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="9"></td>
                                                <td valign="top" width="492" align="left"><?php echo t('Job Title')?> </td>
                                                <td valign="top" width="99" align="center"><?php echo t('Date')?> </td>
                                                <td valign="top" width="113" align="center"><?php echo t('Action')?> </td>
                                          </tr>
                                    </table>
                              </div>							  
							  		
							  
							  <?php
									if($pmb_list){
									$i=1;
										foreach($pmb_list as $val)
										{
											$class = ($i++%2) ? 'white_box' : 'sky_box';
									?>
							  
                              <div class="<?php echo $class ?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="428"><h5><a href="<?php echo base_url().'job/job_details/'.encrypt($val['job_id']) ?>" class="blue_link"><?php echo $val['s_job_title'] ?></a></h5>
                                                      <p> <a href="<?php echo base_url().'private_message/private_message_details/'.encrypt($val['id']) ?>" class="grey_link"><?php echo $val['s_message'] ?></a></p>
                                                     <p> <?php echo t('Tradesman Name')?>: <a href="<?php echo base_url().'tradesman/' ?>" class="light_grey_link"><?php echo $val['s_tradesman_name'] ?></a></p> </td>
                                                <td valign="top" width="87" align="center"><?php echo empty($val['dt_reply_on'])?'':$val['dt_reply_on']?></td>
                                                <td valign="top"  width="97" align="center"><a href="<?php echo base_url().'private_message/private_message_details/'.encrypt($val['id']) ?>"><img src="images/fe/view.png" alt="<?php echo t('View'); ?>" title="<?php echo t('View'); ?>"/></a> &nbsp; 
												<!--<a href="#delete_div" class="lightbox_main"><img src="images/fe/del_icon.png" alt=""/></a> -->
												<a href="<?php echo $pathtoclass.'chk_delete/'.encrypt($val['id'])?>" class="lightbox_main"><img src="images/fe/del_icon.png" alt="<?php echo t('Delete'); ?>" title="<?php echo t('Delete'); ?>"/></a>
												</td>
                                          </tr>
                                    </table>
                              </div>
							  
							  <?php }
									 } else {
										echo '<div class="white_box " style="padding:5px;">'.t('No Private message has been posted yet for this job').'</div>';
									} ?>
                              
                             
                              <div style="display: none;">
                                    <!--<div id="delete_div" class="lightbox">
                                          
                                          <h1>Are you sure you want to delete this message ?</h1>
                                          <div style="text-align:center">
                                                <input name="submit"  class="pink_button01" type="submit" value="Yes" />
                                                &nbsp;
                                                <input name="submit"  class="pink_button01" type="submit" value="No" />
                                          </div>
										  
										
                                    </div>-->
                              </div>
                        </div>
                  </div>
                  <!--<div class="page"> <a href="#"  class="active"> 1 </a> <a href="#"> 2 </a> <a href="#"> 3 </a> <a href="#"> 4 </a> <a href="#"> 5 </a><a href="#" style="background:none; color:#ff416b;">&gt;</a></div>-->
                  <div class="page">
				  	<?php echo $pagination;?>
				  </div>
				  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>
	  <form id="frm_sh_all" name="frm_sh_all" method="post" action="">
<input type="hidden" name="opd_job" id="opd_job" value="" />
<input type="submit" style="visibility:hidden;" />
</form>
