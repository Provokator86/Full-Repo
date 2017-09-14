<div class="div01 noboder">
	<div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
				<th  align="left" valign="middle"><?php echo addslashes(t('Job Details'))?></th>
				<th align="left" valign="middle"><?php echo addslashes(t('Tradesman Details'))?></th>
				<th  align="center" valign="middle"  class="margin00"><?php echo addslashes(t('Option'))?></th>
		  </tr>
		   <?php if($job_list) { 
					$cnt = 1;
		  
				foreach($job_list as $val)
					{ 
                         $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
					     $class = ($cnt%2 == 0)?'class="bgcolor"':'';
		   ?>
		  <tr <?php echo $class ?>>
			<td valign="middle" align="left" class="leftboder" ><h5><a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><?php echo string_part($val['s_title'],100) ?></a></h5>
				  <ul class="details">
						<li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'] ?></span> </li>
						</ul>
						<ul class="spacer">
						<li><?php echo addslashes(t('Assigned on'))?> <span><?php echo $val['dt_fn_assigned_date'] ?></span></li>
				  </ul>
			</td>
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
			<td valign="middle" align="center" class="width17">
			<a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'"  onclick="this.src='images/fe/view.png'" title="view"/></a> 
			<a href="javascript:void(0);" onclick="show_history('<?php echo encrypt($val['id']) ;?>');"><img src="images/fe/history.png" alt="" onmouseover="this.src='images/fe/history-hover.png'" onmouseout="this.src='images/fe/history.png'"  onclick="this.src='images/fe/history.png'" title="history"/></a> 
				<a href="<?php echo base_url().'buyer/pmb_landing/'.encrypt($val['id']); ?>"><img src="images/fe/mass.png" alt="" onmouseover="this.src='images/fe/mass-hover.png'" onmouseout="this.src='images/fe/mass.png'" onclick="this.src='images/fe/mass.png'"  title="Message "/></a> 
				<a href="javascript:void(0);"  onclick="show_feedback('<?php echo encrypt($val['id']) ;?>');"><img src="images/fe/feedback.png" alt="" onmouseover="this.src='images/fe/feedback-hover.png'" onmouseout="this.src='images/fe/feedback.png'"  onclick="this.src='images/fe/feedback.png'" title="feedback "/></a> 
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