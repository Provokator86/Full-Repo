 <script type="text/javascript">
    /**
    * This function use to show the history of job.
    */
    function show_feedback(job_id)
    {
      
         $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/ajax_fetch_feedback',
                        data: "job_id="+job_id,
                        success: function(ret_){
                            
                                $("#feedback_list").html($.trim(ret_));
                                show_dialog('photo_zoom08');   
                            
                        }
         });
    }
    
    
    /**
    * This function use to show the history of job.
    */
    function show_history(job_id)
    {
         $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/ajax_fetch_job_history',
                        data: "job_id="+job_id,
                        success: function(msg){
                            if(msg!='error')
                            {
                                $("#history").html($.trim(msg));
                                show_dialog('photo_zoom02');   
                            }
                        }
         });
    }
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?> 
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
			 <h4><?php echo addslashes(t('Completed Jobs'))?></h4>
			  <div class="div01">
					<p><?php echo addslashes(t('This section consists of jobs completed by your chosen Tradesman'))?></p>
					<div class="spacer"></div>
			  </div>
			  <!-- job contents -->
			  <div id="job_list">
			  <?php echo $job_contents ?>
			  </div>
			  <!-- job contents -->
			  
			  <div class="icon_bar">
				  <ul>
				  <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View'))?></li>
				   <li>|</li>
				   <li><img src="images/fe/history.png" alt="" /><?php echo addslashes(t('History'))?></li>
			      <li>|</li>
				  <li><img src="images/fe/feedback.png" alt="" /><?php echo addslashes(t('Feedback'))?></li>
			      <li>|</li>
				  <li class="last"><img src="images/fe/mass.png" alt="" /><?php echo addslashes(t('Messages'))?></li>
				  </ul>
				   <div class="spacer"></div>
			 </div>
			 <div class="spacer"></div>
			   
	    </div>
			<?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
       <div class="spacer"></div>
            </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>

<!--lightbox-->
<div class="lightbox05 photo_zoom02">
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('History')); ?></h3>
      <div id="history">
      </div>
</div>
<!--lightbox-->
<!--lightbox-->
<div class="lightbox05 photo_zoom08 box02">
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h2><?php echo addslashes(t('Feedback'))?></h2>
         <div id="feedback_list">
         </div>
</div>
<!--lightbox-->