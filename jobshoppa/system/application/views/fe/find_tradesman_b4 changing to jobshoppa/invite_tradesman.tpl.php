
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
			   dataType: 'JSON',
			   success: function(res){
			 //  	$.fancybox.blockUI();
				 if(res.flag)
				 {
				 	
					$('#div_err1').html('<div class="success"><span class="left">'+res.msg+'</span><div>').show();
					//window.location.reload();
					setTimeout('window.location.reload()',2000);
				 }
				 else
				 {
				 	$('#div_err1').html('<div class="error"><span class="left">'+res.msg+'</span><div>').show();;
				 }
			   }

			});
		}
		else
		{
			//$("#div_err1").html("<span style='color:red;'><?php echo t('Select at least one job')?>.</span>").show();
			$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Please select at least one job'))?></span><div>');
		}
	}

</script> 

	<div id="invite_div" class="lightbox" style="width:600px;">
		<div id="div_err1">
		</div>
		  <h1><?php echo get_title_string(t('Invite Tradesman'))?></h1>
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
				
	</div>
