<div class="div01 noboder">
	<div class="find_box02">
		  <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
			  		<tr>
						<th   align="left" valign="middle"><?php echo addslashes(t('Job Details'))?> </th>
						<th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Location'))?></th>
						<th  align="left" valign="middle" ><?php echo addslashes(t('Contact Details'))?></th>
						<th align="center" valign="middle" class="margin00"><?php echo addslashes(t('Option'))?></th>
						<!--<th align="center" valign="middle" class="margin00"><?php echo addslashes(t('Action'))?></th>-->
				   </tr>
					  <?php  if($job_list) { 
								$i = 1;
					  
							foreach($job_list as $val)
								{ 
                                    $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
								    $class = ($i%2 == 0)?'class="bgcolor"':'';
					   ?>
					  <tr <?php echo $class ?>>
						<td valign="middle" align="left" class="leftboder" width="35%">
						<h5><a href="<?php echo base_url().'job-details/'.$job_url ?>" target="_blank"><?php echo string_part($val['s_title'],22) ?></a></h5>							  
						  <ul>
							<li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'];?></span></li>
						  </ul>
						  <ul class="spacer">								
							<li><?php echo addslashes(t('Assigned on'))?>: <span><?php echo $val['dt_fn_assigned_date'];?></span></li>
							</ul>
							<ul class="spacer">
							
							<li><?php echo addslashes(t('Status'))?>: <span><?php echo $val['s_is_active'];?></span></li>
						  </ul>
						</td>
						<td valign="middle" align="center" class="width21" ><?php echo $val['s_province'];?>, <?php echo $val['s_city'];?>,<br />
						<?php echo $val['s_postal_code'];?></td>
						<td valign="middle" align="center"> 
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mail_box">
									<tr>
										  <td align="left" valign="top"><img src="images/fe/mail.png" alt="" /></td>
										  <td align="left" valign="top"><a href="mailto:<?php echo $val['s_buyer_email'];?>"><?php echo $val['s_buyer_email'];?></a></td>
									</tr>
									<?php /*?><tr>
										  <td align="left" valign="top"><img src="images/fe/phone.png" alt="" width="20" height="20" /></td>
										  <td align="left" valign="top"><?php echo $val['s_gsm_no'];?></td>
									</tr><?php */?>
									<tr>
										  <td align="left" valign="top"><img src="images/fe/address.png" alt="" /></td>
										  <td align="left" valign="top"><?php echo $val['s_buyer_address'];?></td>
									</tr>
							  </table>                                                            </td>
						<td valign="middle" align="center" class="width18">
						
						<a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'" title="view" /></a>
						
						<a href="<?php echo base_url().'tradesman/pmb_landing/'.encrypt($val['id']) ?>"><img src="images/fe/mass.png" alt="" onmouseover="this.src='images/fe/mass-hover.png'" onmouseout="this.src='images/fe/mass.png'" onclick="this.src='images/fe/mass.png'" title="Message " /></a>
						<?php if($val['i_status']==4) { ?>
						<input class="login_button02" rel="<?php echo encrypt($val['id']) ?>" type="button" value="<?php echo addslashes(t('Job Completed'))?>" />
						<?php } ?>
						
						  </td>
						<!--<td valign="middle" align="center">
					<input class="login_button02" type="button" value="<?php echo addslashes(t('Job Completed'))?>" onclick="show_dialog('photo_zoom08')" />
					</td>-->
                   </tr>                                                      
					  <?php $i++; } } 
						  else { 
					  ?>
					  <tr>
						  <td class="leftboder">
							<p><?php echo addslashes(t('No item found')) ?></p>
						  </td>
						  <td align="left" valign="middle"></td>
						 <!-- <td align="left" valign="middle"></td>-->
						  <td align="right" valign="middle"  class="text02"></td>
						  <td align="center" valign="middle"></td>
						  
					  </tr>
					 <?php } ?>
					  
				</tbody>
		  </table>
	</div>
</div>

  <div class="spacer"></div>
  <div class="page">
	<?php echo $page_links; ?>
  </div>