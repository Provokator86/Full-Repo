<div class="shadow_big">
  <div class="right_box_all_inner" style="padding:0px;">
		<div class="top_bg_banner">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						  <td valign="top" width="11"></td>
						  <td valign="top" width="225" align="left"><?php echo t('Jobs Details')?></td>
						  <td width="127" align="center"><?php echo t('Location')?></td>
						  <td valign="top" width="168" align="left"><?php echo t('Contact Details')?></td>                                                    
					 
						  <td valign="top" width="88" align="center"><?php echo t('Options')?> </td>
						  <td valign="top" width="94" align="center"><?php echo t('Action')?></td>
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
					   
						  <td width="250" valign="top">
						  <h5><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="blue_link"><?=$val['s_title']?></a></h5>
						 
						  <p><?php echo t('Category')?>: <span class="light_grey_txt"><?=$val['s_category_name']?></span> &nbsp; | &nbsp; <?php echo t('Assigned on')?> <span class="light_grey_txt"><?=$val['dt_fn_assigned_date']?></span> &nbsp;</p>
						  </td>
								   <td width="136" valign="top" align="center"><?=$val['s_state']?>, <?=$val['s_city']?>, <br />
						  <?=$val['s_postal_code']?></td>
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
						  
					  
						  <td width="97" align="center" valign="top"><a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>" /></a>  &nbsp; 
						  <?php /*?><a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['id']);?>')"><?php */?>
						  <a href="javascript:void(0);" onclick="window.location.href='<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['id'])?>'"><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board');?>" title="<?php echo t('My Private Message Board');?>" /></a> &nbsp;
						   <a href="javascript:void(0);" onclick="window.location.href='<?php echo base_url().'tradesman/showPdfInvoice/'.$val['id']?>'"><img src="images/fe/pdf_icon_small.gif" alt="<?php echo t('Download Invoice');?>" title="<?php echo t('Download Invoice');?>" /></a> </td>
						  <td width="86" align="center" valign="top">
						  <?php /*?><a href="javascript:void(0)" onclick="tb_show('', '<?php echo base_url().'tradesman/confirm_job_complete/'.$val['id']?>?height=150&width=400');" class="terminate_btn"><?php echo t('Job Completed')?></a><?php */?>
						  <a href="<?php echo base_url().'tradesman/confirm_job_complete/'.$val['id']?>" class="lightbox_main terminate_btn"><?php echo t('Job Completed')?></a>
						  </td>
					</tr>
			  </table>
		</div>
		<?php
			}
		}else {
		echo '<div class="white_box" style="padding:5px;"> '.t('No job found').'</div>';
		}
		?>		
		
		
		
<div style="display:none ;">
<div id="place_bid_div" class="lightbox" style="width:400px;">
  <h1>Job Completed</h1>

  
		<p style="text-align:center;"><input name="" type="radio" value="" />Yes &nbsp;  <input name="" type="radio" value="" />No</p>
	   <div style="text-align:center;"> <input  class="button" type="button" value="Submit"   /></div>
  
</div>
</div>                                     
		 
		
		
		
  </div>
</div>
						
<div class="page"> 
<?php echo $page_links;?>
</div>
<div class="spacer"></div>						