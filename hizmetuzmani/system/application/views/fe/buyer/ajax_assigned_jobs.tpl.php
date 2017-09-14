<div class="div01 noboder">
	<div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
				<th  align="left" valign="middle"><?php echo addslashes(t('Job Details'))?></th>
				<th align="center" valign="middle" class="margin00"><?php echo addslashes(t('Tradesman Details'))?></th>
				<th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Status'))?> </th>
				<th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Option'))?></th>
				
		  </tr>
		  <?php
              
           if($job_list) { 
					$cnt = 1;
		  
				foreach($job_list as $val)
					{ 
                         $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
					     $class = ($cnt%2 == 0)?'class="bgcolor"':'';
		   ?>
		  <tr <?php echo $class ?>>
			<td valign="middle" align="left" class="leftboder"><h5><a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank" ><?php echo string_part($val['s_title'],40) ?></a></h5>
				  <?php echo string_part($val['s_description'],140) ?>
				  <ul class="details spacer">
						<li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'] ?></span><br/> </li>
					   
						<li><?php echo addslashes(t('Assigned on'))?> <span><?php echo $val['dt_fn_assigned_date'] ?></span></li>
			</ul></td>
			<td align="left" valign="middle">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mail_box">
				<tr>
					  <td align="left" valign="top"><img src="images/fe/business_boss.png" alt="" /></td>
					  <td align="left" valign="top"><a href="mailto:<?php echo $val['s_email'] ?>"><?php echo $val['s_username'] ?></a></td>
				</tr>
				<tr>
					  <td align="left" valign="top"><img src="images/fe/mail.png" alt="" /></td>
					  <td align="left" valign="top"><a href="mailto:<?php echo $val['s_email'] ?>"><?php echo $val['s_email'] ?></a></td>
				</tr>
				<tr>
					  <td align="left" valign="top"><img src="images/fe/phone.png" alt="" width="20" height="20" /></td>
					  <td align="left" valign="top"><?php echo $val['s_gsm_no'] ?></td>
				</tr>
				<tr>
					  <td align="left" valign="top"><img src="images/fe/address.png" alt="" /></td>
					  <td align="left" valign="top"><?php echo $val['s_address'] ?></td>
				</tr>
			</table>
			</td>
				<td valign="middle" align="center" class="width19">
				<?php echo $val['s_is_active'] ?> 
				<?php if($val['i_status']==5) { ?>
				<h4>
				<a href="javascript:void(0);" class="job_accept" rel="<?php echo encrypt($val['id']) ?>"><?php echo addslashes(t('Accept'))?></a> | 
				<a href="javascript:void(0);" class="job_deny" rel="<?php echo encrypt($val['id']) ?>"><?php echo addslashes(t('Deny'))?></a>
				</h4>                 
				<?php } ?>                         
				</td>
				<td valign="middle" align="center" class="width19">
				<!--<a href="javascript:void(0);"><img src="images/fe/edit.png" alt="" onmouseover="this.src='images/fe/edit-hover.png'" onmouseout="this.src='images/fe/edit.png'" onclick="this.src='images/fe/edit.png'" title="edit" /></a>-->
				
				<a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank" ><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'" title="<?php echo addslashes(t('view')) ; ?>" /></a>
                
				 <a href="<?php echo base_url().'buyer/pmb_landing/'.encrypt($val['id']).'/'.encrypt($val['i_tradesman_id']);?>"><img src="images/fe/mass.png" alt="" onmouseover="this.src='images/fe/mass-hover.png'" onmouseout="this.src='images/fe/mass.png'" onclick="this.src='images/fe/mass.png'" title="<?php echo addslashes(t('Message')) ; ?>" /></a> 
                  
				 <?php
				  if($val['i_status']==4)
				  { 
				  ?>
				 <input class="login_button02" rel="<?php echo encrypt($val['id']) ?>" type="button" value="<?php echo addslashes(t('Terminate'))?>" />  
				 <?php } ?>                                                       
			
			</td>
		  </tr>
		  
		  <?php $cnt++; } } 
			  else { 
	    ?>
		  <tr>
			  <td class="leftboder">
				<p><?php echo addslashes(t('No item found')) ?></p>
			  </td>
			  <td align="left" valign="middle"></td>
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
  <?php echo $page_links ?>
  </div>
  