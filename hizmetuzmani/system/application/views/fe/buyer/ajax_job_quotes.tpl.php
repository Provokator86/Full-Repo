<div class="div01 noboder">
	<div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
				<!--<th  align="left" valign="middle"><?php echo addslashes(t('Job Details'))?></th>-->
				<th align="center" valign="middle" class="margin00"><?php echo addslashes(t('Tradesman details'))?></th>
				<th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Quote amount'))?></th>
				<th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Option'))?></th>
				
		  </tr>
		  <?php if($job_list) { 
					$cnt = 1;
		  
				foreach($job_list as $val)
					{ 
					$class = ($cnt%2 == 0)?'class="bgcolor"':'';
		   ?>
		  <tr <?php echo $class ?>>
			
			<td align="left" valign="middle" class="leftboder">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mail_box">
					<tr>
						  <td width="20px;" align="left" valign="top"><img src="images/fe/business_boss.png" alt="" /></td>
						  <td align="left" valign="top"><a href="<?php echo base_url().'tradesman-profile/'.encrypt($val['i_tradesman_id']) ?>"><?php echo $val['s_username'] ?></a></td>
					</tr>
					<?php /*?><tr>
						  <td align="left" valign="top"><img src="images/fe/mail.png" alt="" /></td>
						  <td align="left" valign="top"><a href="mailto:<?php echo $val['s_email'] ?>"><?php echo $val['s_email'] ?></a></td>
					</tr>
					<tr>
						  <td align="left" valign="top"><img src="images/fe/phone.png" alt="" width="20" height="20" /></td>
						  <td align="left" valign="top"><?php echo $val['s_gsm_no'] ?></td>
					</tr><?php */?>
					<tr>
						  <td align="left" valign="top"><img src="images/fe/address.png" alt="" /></td>
						  <td align="left" valign="top"><?php echo $val['s_address'] ?></td>
					</tr>
				</table>
			</td>
				
				<td valign="middle" align="center"><?php echo $val['s_quote'] ?></td>
				<td valign="middle" align="center" class="width19">
				<!--<input class="login_button02" type="button" value="<?php echo addslashes(t('Accept Quote'))?>" onclick="show_dialog('photo_zoom03')" /> --> 	
				<?php
				if($job_details['i_tradesman_id'] == $val['i_tradesman_id'])
					echo addslashes(t('Assigned'));
				elseif($job_details['i_is_active']==8 && $job_details['i_tradesman_id'])	
					echo '-';
				else if($val['i_status']==3)
					echo addslashes(t('Rejected'));	
				elseif(empty($job_details['i_tradesman_id']))
				{	
				?>			
				<input class="login_button02" rel="<?php echo encrypt($val['id']).','.encrypt($val['i_job_id']).','.encrypt($val['i_tradesman_id']) ?>" type="button" value="<?php echo addslashes(t('Accept Quote'))?>" />
				<a style="color:#0489E9;" href="javascript:void(0);" class="link_reject" rel="<?php echo encrypt($val['id']).','.encrypt($val['i_job_id']).','.encrypt($val['i_tradesman_id']) ?>"><?php echo addslashes(t('Reject Quote'))?></a>
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
			  <!--<td align="left" valign="middle"></td>-->
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
  