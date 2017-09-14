<div class="div01 noboder">
	<div class="find_box02">
		  <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
			  		<tr>
						<th   align="left" valign="middle"><?php echo addslashes(t('Job Details'))?> </th>
						<th  align="center" valign="middle"><?php echo addslashes(t('Location'))?></th>						
						<th align="center" valign="middle"><?php echo addslashes(t('Option'))?></th>
						<th align="center" valign="middle"><?php echo addslashes(t('Action'))?></th>
				    </tr>
					  <?php if($job_list) { 
								$i = 1;
					  
							foreach($job_list as $val)
								{ 
                                    $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
								    $class = ($i%2 == 0)?'class="bgcolor"':'';
					   ?>
					  <tr <?php echo $class ?>>
						<td valign="middle" align="left" class="leftboder"><h5><a href="<?php echo base_url().'job-details/'.$job_url ?>" target="_blank"><?php echo $val['s_title'] ?></a></h5>
						<?php echo string_part($val['s_description'],304) ?>
						<div class="spacer"></div>
							  
							  <ul>
									<li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'] ?></span></li>
							  </ul>
							  <ul class="spacer">	
									<li><?php echo addslashes(t('Assigned Date'))?> <span><?php echo $val['dt_fn_assigned_date'] ?></span>  </li>
									<li>|</li>
									<li><?php echo addslashes(t('Buyer'))?> <span>
									<!--<a href="javascript:void(0);" onclick="show_dialog('photo_zoom09')" >--> <?php echo $val['s_buyer_name'] ?><!--</a>--></span></li>
							  </ul>
					   </td>
						<td valign="middle" align="center" class="width21" ><?php echo $val['s_province'] ?>, <?php echo $val['s_city'] ?>,<br />
						<?php echo $val['s_postal_code'] ?></td>
						
						<td valign="middle" align="center" >
					   <a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" title="view" /></a>
						
						</td>
						<td valign="middle" align="center"><input class="login_button02" rel="<?php echo encrypt($val['id']) ?>" type="button" value="<?php echo addslashes(t('Job Completed'))?>" />
						</td>
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