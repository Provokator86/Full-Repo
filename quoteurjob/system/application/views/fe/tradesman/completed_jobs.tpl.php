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
                   <h1><img src="images/fe/job_secure.png" alt="" /> <?php echo get_title_string(t('Completed Jobs'))?> <span>(<?=$i_completed_jobs?>)</span></h1>
                    <h4 style="font-size:14px;"><?php echo t('This Section consists of all the jobs that has been mutually agreed as complete')?></h4>
                  	<div id="job_list">		
                  	<?php echo $job_contents;?>
					</div> 
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>