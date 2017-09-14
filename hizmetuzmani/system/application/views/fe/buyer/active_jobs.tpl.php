<script type="text/javascript">
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
			 <h4><?php echo addslashes(t('Active Jobs'))?></h4>
			  <div class="div01">
					<p><?php echo addslashes(t('All jobs that you have posted and have been approved by admin are listed below'))?></p>
				   
					<div class="spacer"></div>
			  </div>
			  <!-- job contents -->
			  <div id="job_list">
			  <?php echo $job_contents ?>
			  </div>
			  <!-- job contents -->
			  
			  <div class="spacer"></div>
			  
			  <div class="icon_bar">
			  <ul>
			  <li><img src="images/fe/edit.png" alt="" /> <?php echo addslashes(t('Edit'))?></li>
              <li>|</li>
			  <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View'))?></li>
			   <li>|</li>
			   <li><img src="images/fe/history.png" alt="" /><?php echo addslashes(t('History'))?></li>
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