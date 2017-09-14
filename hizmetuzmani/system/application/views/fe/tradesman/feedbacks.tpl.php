<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
			  <h4><?php echo addslashes(t('Feedback Received'))?></h4>
			  
			  <div class="div01">
			
			  <p><?php echo addslashes(t('This Section consists of all the jobs that has been mutually agreed as complete'))?></p>
			  <div class="spacer"></div>
			  </div>			  
			  <!-- feedback list -->
			  <div id="feedback_list">
			  <?php echo $feedback_contents ?>
			  </div>
			  <!-- feedback list -->
			  
			</div>
			<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
                  <div class="spacer"></div>
            </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>
