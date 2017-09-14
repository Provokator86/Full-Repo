 <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <th align="left" valign="middle"><?php echo addslashes(t('Jobs Title'))?></th>
             <!--<th align="left" valign="middle"><?php //echo addslashes(t('Category'))?></th>-->
             <th align="center" valign="middle"  class=" margin00"><?php echo addslashes(t('Quote(s)'))?></th>
             <th align="center" valign="middle"  class=" margin00"><?php echo addslashes(t('Option'))?></th>
      </tr>
	  
	  <?php if($job_list) { 
	  			$cnt = 1;
	  
	  		foreach($job_list as $val)
				{
                    $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ; 

				$class = ($cnt%2 == 0)?'class="bgcolor"':'';
				
	   ?>
      <tr <?php echo $class ?>>
            <td align="left" valign="middle" class="leftboder" width="65%"><h5>
			<a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><?php echo string_part($val['s_title'],50) ?></a></h5> 
            <p style="padding-bottom:0px;"><?php echo string_part($val['s_description'],100) ?></p> 
			<p style="padding-bottom:0px; color:#E46C0A;"><?php echo $val['s_keyword'] ?></p>
			<ul class="spacer">
			<li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'] ?></span></li>
			</ul>
			<ul  class="spacer"> 
			<li><?php echo addslashes(t('Time left'))?>: <span><?php echo ($val['i_status']!=6 || $val['i_status']!=7)?$val['i_days_left']:0; ?> <?php //echo addslashes(t('day'))?></span> </li>
			<li>|</li>
			<li><?php echo addslashes(t('Budget'))?>: <span><?php echo $val['s_budget_price'] ?></span></li>
			<li>|</li>
			<li><?php echo addslashes(t('Status'))?>: <span style="color:#E46C0A; font-weight:bold;"><?php echo $val['s_is_active'] ?></span></li>
			</ul>
			</td>
            <!--<td align="left" valign="middle"><?php //echo $val['s_category_name'] ?></td>-->
            <td align="center" valign="middle" width="15%"><strong><?php echo $val['i_quotes'] ?></strong></td>
            <td align="center" valign="middle" width="18%">
			
			<?php if($val['i_status']==1) { ?>
			<input class="small_button02" value="<?php echo addslashes(t('Quote'))?>" type="button" rel="<?php echo $val['id'] ?>"/>
			<p><a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank" style="color:#E46C0A;"><?php echo addslashes(t('View job'))?></a></p>
			<?php } else { ?>
			<p><a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank" style="color:#E46C0A;"><?php echo addslashes(t('View job'))?></a></p>
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
	
     
</table>


 <div class="page">
 <?php echo $page_links ?> 
</div>




