
<script type="text/javascript">
	function frm_submit()
	{
		$("#err").hide();
		//	$.fancybox.blockUI();
		if($("input:checked","#frm_invite").length>0)
		{
			var jobs_id = new Array();
			//$.fancybox.blockUI({ message: 'Just a moment please...' });
			//$.blockUI({ message: 'Just a moment please...' });
			var trades_id = <?php echo $tradesman_id?>; // tradesman to be invited
			
			$("input:checked","#frm_invite").each(function(){
					jobs_id.push($(this).val());
				
			});
			//alert(jobs_id);
			$.ajax({
				type: "POST",
			    url: base_url + "tradesman_invite",
			   //data: {'h_jobs_id':jobs_id},
			   data: "h_jobs_id="+jobs_id+"&tradesman_id="+trades_id,
			   dataType: 'script',
			   success: function(res){
			   //alert(res);
			   obj = eval('('+res+')');
			   	//alert(obj.flag);
				//alert(obj.msg);
			 //  	$.fancybox.blockUI();
				 if(res.flag)
				 {
				 	
					$('#div_err1').html('<div class="success_massage">'+obj.msg+'<div>').show();
					//window.location.reload();
					setTimeout('window.location.reload()',2000);
				 }
				 else
				 {
				 	$('#div_err1').html('<div class="success_massage">'+obj.msg+'<div>').show();
					//window.location.reload();
					setTimeout('window.location.reload()',2000);
				 }
			   }

			});
		}
		else
		{
			
			$('#div_err1').html('<div class="error_massage">Please select at least one job<div>');
		}
	}

</script> 
<div id="div_err1">
</div>
<div class="lightbox2" style="display:block;">
    <div class="close"><!--<a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/close.png" alt="" /></a>--></div>
    <div class="top">&nbsp;</div>
    <div class="mid">
        <h6>Invite this professional to quote on any or all of the active jobs below</h6>
		
        <ul class="list_pro">
		<form id="frm_invite" action="" method="post">
		<?php if($is_loggedin) {				
					if($is_buyer) {
					if(count($jobs)>0) {
					foreach($jobs as $val) 
					{
				?>
            <li>
                <input name="txt_jobs_id[]" id="txt_jobs_<?php echo $val['id'];?>" type="checkbox" value="<?php echo encrypt($val['id']);?>" /> <?php echo $val['s_part_title'];?> 
                
			</li>
			<?php 
					}
				}
				else
				{
					?>
						<p>You don't have any active jobs.</p>
					<?php		
				}
				} else	{ ?>
				<p>Only Buyer can acces this feature.</p>
			<?php		
				}
			} else { ?>
				<p>Please login to acces this feature</p>
			<?php } ?>
		</form>
            
        </ul>
        <div class="clr" style="padding-bottom:10px;"></div>
        <div class="link_box07" style="margin-left:240px;"><a href="javascript:void(0)" onclick="frm_submit();">Invite to quote </a></div>
    </div>
    <div class="bot">&nbsp;</div>
</div>



<!--
	<div id="invite_div" class="lightbox" style="width:600px;">
		<div id="div_err1">
		</div>
		  <h1>Invite Tradesman</h1>
		  		<?php if($is_loggedin) {
				
					if($is_buyer) {
					if(count($jobs)>0) {
				?>
				<p> <strong><?php echo t('List of Active jobs for which you want to invite the Tradesman')?></strong></p>
					
					<form id="frm_invite" action="" method="post">
					 <ul class="invite_list">
					 	<?php foreach($jobs as $val) {?>
						<li><input name="txt_jobs_id[]" id="txt_jobs_<?php echo $val['id'];?>" type="checkbox" value="<?php echo encrypt($val['id']);?>" />    <?php echo $val['s_part_title'];?></li>
						
						<?php } ?>
						
				   </ul>
					<div class="spacer"></div>   
				<br />
				<input  class="button" id="btn_smt" type="button" value="<?php echo t('Invite')?>" onclick="javascript: frm_submit();" />
					</form>
				<?php 
					}
					else
					{
						?>
							<p><?php echo addslashes(t('You don\'t have any active jobs.'))?>.</p>
						<?php		
					}
					} else	{ ?>
					<p><?php echo addslashes(t('Only Buyer can acces this feature'))?>.</p>
				<?php		
					}
				} else { ?>
					<p><?php echo addslashes(t('Please login to acces this feature'))?>.</p>
				<?php } ?>
				
	</div>-->
