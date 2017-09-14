<script>
function send_msg(param)
{
	//alert(param);
	$("#frm_msg_tra input[name=opd_job]").val(param)
	//$('#frm_msg_tra:input').val(param);
	$('#frm_msg_tra').submit();
}
</script>

<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
			</div>	
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
            <div class="body_right">
                  <h1><img src="images/fe/job.png" alt="" /> <?php echo get_title_string(t('Quotes'))?>   <span>(<?=$i_tot_quotes?>)</span></h1>
                 <h4><?php echo t('This section consists of all the bids you have placed in respect to all the jobs that are relevant to you')?></h4>
                  	<div id="job_list">		
                  	<?php echo $job_contents;?>
					</div> 
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>