<div class="div01 noboder">
  <div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
				<th  align="left" valign="middle"><?php echo addslashes(t('Job Details'))?></th>
				<th  align="left" valign="middle" align="center" class="width18" ><?php echo addslashes(t('Quote(s)'))?></th>	
				<th  align="center" valign="middle"><?php echo addslashes(t('Option'))?></th>
		  </tr>
		  <?php if($job_list) { 
					$cnt = 1;
		  
				foreach($job_list as $val)
					{ 
                         $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
					$class = ($cnt%2 == 0)?'class="bgcolor"':'';
		   ?>
			<tr <?php echo $class ?>>
				<td valign="middle" align="left" class="leftboder"><h5><a href="<?php echo base_url().'job-details/'.$job_url;?>" target="_blank" ><?php echo $val['s_title'] ?></a></h5>
					  <?php echo $val['s_description'] ?><br />
					  <ul>
						  <li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'] ?></span> </li>	
				      </ul>
					  <ul class="spacer">
						  <li><?php echo addslashes(t('Budget'))?>:<span> TL <?php echo $val['d_budget_price'] ?></span></li>
						  <li>|</li>
						  <li><?php echo addslashes(t('Posted on'))?> <span><?php echo $val['dt_entry_date'] ?></span></li>
						  <li>|</li>
						  <li><?php echo addslashes(t('Time left'))?>:<span> <?php echo $val['s_days_left'] ?></span> </li>					   				      </ul>  
					  <ul class="spacer">
						  <li><?php echo addslashes(t('Highest quote'))?> <span><?php echo $val['max_quote'] ?> TL</span></li>
						  <li>|</li>
						  <li><?php echo addslashes(t('Average quote'))?>:<span> <?php echo $val['avg_quote'] ?> TL</span> </li>					   				      </ul>                                                                
			    </td>
				<td valign="middle" align="center" class="width18">					
					<?php echo $val['i_quotes']?>
				</td>
			  
			<td valign="middle" align="center" class="width17">
			<input class="login_button02" type="button" value="<?php echo addslashes(t('View Quotes'))?>" onclick="window.location.href='<?php echo base_url().'job-quotes/'.encrypt($val['id']);?>'"/>
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