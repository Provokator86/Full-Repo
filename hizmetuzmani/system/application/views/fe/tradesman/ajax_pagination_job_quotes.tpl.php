<script type="text/javascript">
	$(document).ready(function(){
	//$("input[id^='txt_quote_']").numeric({});
	/******** validation for text box of GSM NUMBER, and FIRM PHONE to allow only numeric *******/
    
$(".numeric_valid").keydown(function(e){
		if(e.keyCode==8 || e.keyCode==9 || e.keyCode==46)
		{
			return true; 
		}    
		if($(this).val().length>9) // check for more than 7 digit
		{
			return false;
		}
		 
		 return (e.keyCode>=48 && e.keyCode<=57 || e.keyCode>=96 && e.keyCode<=105) //Only 0-9 digits are allowed

})  ;
/******** validation for text box to allow only numeric *******/ 
	 
});
	
</script>
<div id="div_err1">
</div>
<div class="div01 noboder">
	<div class="find_box02">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		  <tr>
				<th   align="left" valign="middle"><?php echo addslashes(t('Job Details'))?> </th>
				<th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Location'))?></th>
				<th  align="left" valign="middle" ><?php echo addslashes(t('Quoted Price'))?></th>
				<th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Option'))?> </th>
		  </tr>
		  
		  <?php if($job_quotes) { 
                    
             
					$i = 1;
		  
				foreach($job_quotes as $val)
					{ 
                        $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['i_job_id']) ;  
					$class = ($i%2 == 0)?'class="bgcolor"':'';
		   ?>
			  
		  <tr <?php echo $class ?>>
				<td valign="middle" align="left" class="leftboder"><h5>
				<a href="<?php echo base_url().'job-details/'.$job_url ;?>" target="_blank"><?php echo string_part($val['s_title'],25) ?></a></h5>
					  <?php echo string_part($val['s_description'],100) ?>
					  <div class="spacer"></div>
					  <ul>
							<li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category'] ?></span> </li>
						</ul>
						<ul class="spacer">
							<li><?php echo addslashes(t('Expiry Date'))?> <span><?php echo $val['dt_expire_date'];?></span></li>
							<li>|</li>
							
							<li><?php echo addslashes(t('Budget'))?>:<span> <?php echo $val['s_budget_price'] ?></span></li>
					  </ul></td>
				<td valign="middle" align="center" class="width20"><?php echo $val['s_province'].','. $val['s_city'].','.'<br/>'.
$val['s_postal_code'] ?></td>
			<td valign="top" align="left" class="width22">
			   <h3>TL</h3>
			   <?php if($val['i_job_status']==1 && $val['i_status']==1){ ?>
					  <div class="textfell">					  
					  <input type="text" class="disable_css numeric_valid" value="<?php echo $val['d_quote']?>" disabled="disabled" name="txt_quote_<?php echo $i?>" id="txt_quote_<?php echo $i?>" />
					  
				</div>
		
			 <!-- open lightbox to edit the message and quote -->
			 <span id="sp_edit">
			<a href="javascript:void(0);"  onclick="edit_quote('<?php echo encrypt($val['id']) ;?>');">
			<img src="images/fe/edit02.png" alt="<?php echo addslashes(t('Edit'))?>" title="<?php echo addslashes(t('Edit'))?>" />
			</a>
			</span>
			  <!-- open lightbox to edit the message and quote -->
			 
			<?php  } else { ?>
			<div class="textfell">
				<input type="text" class="disable_css numeric_valid" value="<?php echo $val['d_quote']; ?>" disabled="disabled" />
			</div>
			<?php } ?>
				 
			<div class="spacer margin05"></div>
			<span><?php echo string_part($val['s_comment'],35) ?></span>
				
				
				</td>
				<td valign="middle" align="center" class="width18"> 
				<a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'"  onclick="this.src='images/fe/view.png'"  title="view"/></a>
				
				<a href="<?php echo base_url().'tradesman/pmb_landing/'.encrypt($val['i_job_id'])  ;?>"><img src="images/fe/mass.png" alt="" onmouseover="this.src='images/fe/mass-hover.png'" onmouseout="this.src='images/fe/mass.png'"  onclick="this.src='images/fe/mass.png'"  title="message"/></a>                                                             </td>
		  </tr>			  
			  
		  <?php $i++; } } 
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