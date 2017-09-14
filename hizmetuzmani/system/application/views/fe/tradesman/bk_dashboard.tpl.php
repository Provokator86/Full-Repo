<script type="text/javascript">
$(document).ready(function() {
    $('#btn_membership').click(function(){
        
        var b_valid =   true ;
        alert($('input[name=payment_type]:checked').val());
        var payment_type    =   $('input[name=payment_type]:checked').val();
        if(payment_type==2)
        {
            if($.trim($("#ta_bank").val())=='')
            {
                $("err_ta_bank").text('<?php echo addslashes(t('Please provide bank transfer details')); ?>').slideDown(500);
                b_valid =   false ;
            }
            else
            {
               $("err_ta_bank").text('').hide(); 
            }
        }
        if(b_valid)
        {
            $('#frm_membership').submit();
            
        }
    });
    
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
        <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			  <h4><?php echo addslashes(t('Dashboard'))?> </h4>
			  <div class="div01">
					<p><?php echo addslashes(t('Welcome'))?> <span><?php echo $name ?></span></p>
					<p><?php echo addslashes(t('You have'))?><span> <?php echo $i_new_msg ; ?> </span><?php echo addslashes(t('new messages'))?>&nbsp;&nbsp;</p>
					<p class="float06"><?php echo addslashes(t('Local time is'))?><span> <?php echo $dt_local_time?></span></p>    	 				  <p class="float06"><?php echo addslashes(t('Current Plane'))?> <span><?php echo $s_plan ; ?></span></p>
					<p class="float06"><?php echo addslashes(t('Expiry date')) ;?> <span><?php echo $dt_expire_date; ?></span></p> 
                   
                         <p class="float06"><span><a href="javascript:void(0);" onclick="show_dialog('membership_plan');"><?php echo addslashes(t('Please Click')) ;?></a></span> <?php echo addslashes(t('here to upgrade your membership plan')) ;?></p>  
                  
					<!--<p class="float06">Your membership has expired <span><a href="javascript:void(0);">Please Click</a></span> here to renew</p>-->
					<div class="spacer"></div>
			  </div>
			  <div class="div02">
					<h5><?php echo addslashes(t('My Quotes'))?></h5>
					<div class="find_box02">
						  <table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
								  <tr>
									<th valign="middle" align="left"><?php echo addslashes(t('Job Details'))?></th>
									<th valign="middle" align="center" class="margin00"><?php echo addslashes(t('Quotes'))?></th>
									<th valign="middle" align="center"  class="margin00"><?php echo addslashes(t('Option(s)'))?></th>
									<th valign="middle" align="center" class="margin00"><?php echo addslashes(t('My Price'))?></th>
								  </tr>
							  <?php
							   if($quote_details)
				  				{  $i=1;
							 	 foreach($quote_details as $val)
							  		{		
										$class = ($i%2 == 0)?'class="bgcolor"':'';	
							  ?>
							  <tr <?php echo $class ?>>
									<td valign="middle" align="left" class="leftboder" width="55%">
									<h5><a href="<?php echo base_url().'job-details/'.encrypt($val['i_job_id']); ?>"><?php echo string_part($val['job_details']['s_title'],50)?></a></h5>
										  <?php echo string_part($val['job_details']['s_description'],100)?> 
										  <div class="spacer"></div>
										  <ul><li><?php echo addslashes(t('Date'))?> : <span><?=$val['dt_entry_date']?></span></li></ul></td>
									<td valign="middle" align="center"><?php echo $val['job_details']['i_quotes'] ?></td>
									<td valign="middle" align="center">
								   
								   <a href="<?php echo base_url().'job-details/'.encrypt($val['i_job_id']); ?>"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'"  title="view" /></a>                                                            </td>
									<td valign="middle" align="center"><?php echo $val['s_quote'] ?></td>
							  </tr>
								<?php } } else { ?>	
								<tr>
									<td valign="middle" align="left" class="leftboder">
									<p><?php echo addslashes(t('No item found'))?></p>
									</td>
									<td valign="middle" align="center"></td>
									<td valign="middle" align="center"></td>
									<td valign="middle" align="center"></td>
							  </tr>
							 <?php } ?>   
									  
								</tbody>
						  </table>
					</div>
					<div class="margin10"></div>
					<input class="small_button" type="button" value="<?php echo addslashes(t('My Won Jobs'))?>" onclick="window.location.href='<?php echo base_url().'tradesman/my-won-jobs' ?>'" />
					<!--<input class="small_button" type="button" value="My Lost Jobs" onclick="window.location.href='javascript:void(0);'" />-->
			  </div>
			  <div class="div02">
					<h5><?php echo addslashes(t('Pending Buyer Reviews'))?></h5>
					<div class="find_box02">
						  <table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								  <tr>
									<th valign="middle" align="left"><?php echo addslashes(t('Job Details'))?> </th>
									<!--<th valign="middle" align="center" class="margin00"><?php //echo addslashes(t('Feedback'))?></th>-->
									<th valign="middle" align="center"  class=" margin00"><?php echo addslashes(t('Option'))?> </th>
										
								  </tr>
									  
							  <?php
							  if($feedback_job_list)
							  {
							  $i=1;
							  	foreach($feedback_job_list as $val)
								{ $class = ($i%2 == 0)?'class="bgcolor"':'';
							  ?>
									  
								  <tr <?php echo $class ?>>
										<td valign="middle" align="left" class="leftboder" width="75%">
										<h5><a href="<?php echo base_url().'job-details/'.encrypt($val['id']); ?>"><?php echo $val['s_job_title'] ?></a></h5>
											  <?php echo $val['s_job_description'] ?> <div class="spacer"></div><ul>
													<li><?php echo addslashes(t('Completion Date'))?> <span><?php echo $val['dt_completed_on'] ?></span></li>
											  </ul></td>
									    <?php /*?><td valign="middle" align="center">
										<h6><a href="tradesman_profile.html"><?php echo $val['s_comments'] ?></a></h6>
										</td><?php */?>
										<td valign="middle" align="center">
									  <a href="<?php echo base_url().'job-details/'.encrypt($val['id']); ?>"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'"  title="<?php echo addslashes(t('view'))?>" /></a></td>
										
								  </tr>
								<?php } }else { ?>	
								<tr>
									<td valign="middle" align="left" class="leftboder">
									<p><?php echo addslashes(t('No item found'))?></p>
									</td>
									<!--<td valign="middle" align="center"></td>-->
									<td valign="middle" align="center"></td>
									
							  </tr>
							 <?php } ?>     
									  
									  
								</tbody>
						  </table>
					</div>
			  </div>
			  
			  <div class="spacer"></div>
			  
			  <?php include_once(APPPATH."views/fe/common/symbol_hints.tpl.php"); ?>
			   <div class="spacer"></div>
		</div>
			<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
		  <div class="spacer"></div>
	</div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
      
<!--lightbox-->
<div class="lightbox_membership membership_plan"> 
<div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
    <h3><?php echo addslashes(t('Choose a membership plan')); ?> </h3>
    
    <form action="<?php echo base_url().'tradesman/payment_update_membership' ?>" method="post" name="frm_membership" id="frm_membership">
   <div class="inner_box_membership" >
   <ul>
   <li><input name="radio_membership_plan" type="radio" value="1" />1 <?php echo addslashes(t('month membership plan')); ?></li>
   <li><input name="radio_membership_plan" type="radio" value="2" checked="checked" />3 <?php echo addslashes(t('month membership plan')); ?></li>
   </ul>
    <div class="spacer"></div>
   </div>
   
   <div class="inner_box_membership02">
   <ul>
      <li><input type="radio" name="payment_type" value="1" checked="clecked" />&nbsp;<?php echo  addslashes(t('Payment using Paypal')); ?></li>
   <li> <input type="radio" name="payment_type" value="2" />&nbsp;<?php echo addslashes(t('Bank transfer')); ?> </li>
   
    <textarea name="ta_bank" id="ta_bank" cols="20" rows="4"></textarea>
   </ul>
   <div class="spacer"></div>
   </div>
   
   <div>
   
  
    <div class="spacer"></div>
  
   <div class="err" id="err_ta_bank" style="display: none;"><?php echo addslashes(t('please provide bank transfer info.'))?></div>
   
   </div>
   <div class="spacer"></div>
    <input  class="small_button marginright" value="<?php echo addslashes(t('Submit'))?>"  type="button" id="btn_membership"/>
    </form>
</div>
<!--lightbox-->