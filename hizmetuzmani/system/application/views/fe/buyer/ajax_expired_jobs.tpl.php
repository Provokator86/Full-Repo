<div class="div01 noboder">
	<div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
			<th  align="left" valign="middle"><?php echo addslashes(t('Job Details'))?></th>
		   
			<th  align="center" valign="middle"><?php echo addslashes(t('Option'))?></th>
		  </tr>
		   <?php if($job_list) { 
					$cnt = 1;
		  
				foreach($job_list as $val)
					{ 
                        $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
					    $class = ($cnt%2 == 0)?'class="bgcolor"':'';
		   ?>
		  <tr>
			<td valign="middle" align="left" class="leftboder"><h5><a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><?php echo string_part($val['s_title'],50) ?></a></h5>
			<?php echo string_part($val['s_description'],150) ?>
			<div class="spacer"></div>
	  			<ul class="details">
				  <li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'] ?></span> </li>
				  <li>|</li>
				  <li><?php echo addslashes(t('Assigned on'))?> <span><?php echo $val['dt_fn_assigned_date'] ?></span></li>
				</ul>
			</td>
				
			<td valign="middle" align="center" class="width19">
			<a href="javascript:void(0);"><img src="images/fe/edit.png" alt="" onmouseover="this.src='images/fe/edit-hover.png'" onmouseout="this.src='images/fe/edit.png'"  onclick="this.src='images/fe/edit.png'" title="edit" /></a>
			
			
			<a href="javascript:void(0);" onclick="show_dialog('photo_zoom10')"><img src="images/fe/delete.png" alt="" onmouseover="this.src='images/fe/delete-hover.png'" onmouseout="this.src='images/fe/delete.png'" onclick="this.src='images/fe/delete.png'" title="delete" /></a>
			
			<a href="javascript:void(0);" onclick="show_history('<?php echo encrypt($val['id']) ;?>');"><img src="images/fe/history.png" alt="" onmouseover="this.src='images/fe/history-hover.png'" onmouseout="this.src='images/fe/history.png'"  onclick="this.src='images/fe/history.png'" title="history" /></a>
			
		   <a href="javascript:void(0);"><img src="images/fe/mass.png" alt="" onmouseover="this.src='images/fe/mass-hover.png'" onmouseout="this.src='images/fe/mass.png'" onclick="this.src='images/fe/mass.png'" title="Message " /></a>
			
			
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