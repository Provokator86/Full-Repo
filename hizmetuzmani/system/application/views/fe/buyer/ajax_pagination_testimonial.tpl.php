  <div class="div01 noboder">
	<div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
			<th  align="left" valign="middle"><?php echo addslashes(t('Date'))?></th>
			<th align="left" valign="middle"><?php echo addslashes(t('Testimonial'))?> </th>
		
			<th  align="center" valign="middle"><?php echo addslashes(t('Status'))?> </th>
		  </tr>
		  <?php if($testimonial) 
		  		{
					$i = 1;
					foreach($testimonial as $value)
					{
						$class = (($i%2)==0)?"class='bgcolor'":"";
		  	
		   ?>
		  <tr <?php echo $class ?>>
			<td valign="middle" align="left" class="leftboder"><?php echo $value['dt_entry_date'] ?></td>
			<td align="left" valign="middle"><?php echo $value['s_full_content'] ?></td>		   
			<td align="center" valign="middle"><?php echo $value['s_is_active'] ?></td>
		  </tr>
		  <?php } } else { ?>
		   <tr>
			<td valign="middle" align="left" class="leftboder"></td>
			<td align="left" valign="middle"><?php echo addslashes(t('No item found'))?></td>		   
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