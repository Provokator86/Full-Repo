<div class="div01 noboder">
  <div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
				<th  align="left" valign="middle"><?php echo addslashes(t('Job Details'))?></th>
				<th  align="left" valign="middle" class="width18"><?php echo addslashes(t('Status'))?></th>
			   
				<th  align="center" valign="middle"><?php echo addslashes(t('Option'))?></th>
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
				<td valign="middle" align="left" class="leftboder"><h5><a href="<?php echo base_url().'job-details/'.$job_url;?>" target="_blank"><?php echo string_part($val['s_title'],40) ?></a></h5>
					  <?php echo string_part($val['s_description'],150) ?>
					  <ul>
						  <li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'] ?></span> </li>
						  <li>|</li>
						  <li><?php echo addslashes(t('Budget'))?>:<span> TL <?php echo $val['d_budget_price'] ?></span></li>
				      </ul>
					  <ul class=" spacer">
						  <li><?php echo addslashes(t('Posted on'))?> <span><?php echo $val['dt_entry_date'] ?></span></li>
						  <li>|</li>
						  <li><?php echo addslashes(t('Time left'))?>:<span> <?php echo $val['s_days_left'] ?></span> </li>					   				      </ul>                                                                  
			    </td>
				<td valign="middle" align="left" class="width18"><?php echo $val['s_is_active'] ?></td>
			  
<td valign="middle" align="center" class="width17">
<?php if($val['i_is_active']==1) { ?>
<a href="<?php echo base_url().'buyer/edit-job/'.encrypt($val['id']) ?>"><img src="images/fe/edit.png" alt="" onmouseover="this.src='images/fe/edit-hover.png'" onmouseout="this.src='images/fe/edit.png'" onclick="this.src='images/fe/edit.png'" title="<?php echo addslashes(t('Edit')) ; ?>" /></a>
<?php } ?>
<a href="<?php echo base_url().'job-details/'.$job_url;?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'" title="view" /></a>
<a href="javascript:void(0);" onclick="show_history('<?php echo encrypt($val['id']) ;?>');"><img src="images/fe/history.png" alt="" onmouseover="this.src='images/fe/history-hover.png'" onmouseout="this.src='images/fe/history.png'" onclick="this.src='images/fe/history.png'" title="<?php echo addslashes(t('history')) ; ?>" /></a>
 
 <a href="<?php echo base_url().'buyer/pmb_landing/'.encrypt($val['id']); ?>"><img src="images/fe/mass.png" alt="" onmouseover="this.src='images/fe/mass-hover.png'" onmouseout="this.src='images/fe/mass.png'" onclick="this.src='images/fe/mass.png'" title="<?php echo addslashes(t('Message')) ; ?>" /></a>

<!--<a href="javascript:void(0);" onclick="show_dialog('photo_zoom03')"><img src="images/fe/delete.png" alt="" onmouseover="this.src='images/fe/delete-hover.png'" onmouseout="this.src='images/fe/delete.png'" onclick="this.src='images/fe/delete.png'" title="delete" /></a>-->       
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

<!--lightbox-->
<div class="lightbox04 photo_zoom03">
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h3>Are you sure you want to delete the Job?</h3>
<div class="buttondiv">
<input class="login_button flote02" type="button" value="Yes" />
<input class="login_button flote02" type="button" value="No" />
</div>
</div>
<!--lightbox-->

<!--lightbox-->
<div class="lightbox05 photo_zoom02">
     <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h3>History</h3>
<div id="history">
</div>
</div>
<!--lightbox-->
