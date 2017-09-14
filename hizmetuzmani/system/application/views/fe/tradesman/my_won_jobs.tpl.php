<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
			  <h4><?php echo addslashes(t('My Won Jobs'))?></h4>			  
			  <div class="div01">
			  <p><?php echo addslashes(t('This section consists of the jobs that has been won by you.'))?></p>
			  <div class="spacer"></div>
			  </div>
			  <div id="job_list">
			  <?php echo $job_contents; ?>
			  </div>
			  
			  <div class="spacer"></div>
			  
			  <?php /*?><div class="icon_bar">
			  <ul>
			  <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View'))?></li>
			   <li>|</li>
			  <li class="last"><img src="images/fe/mass.png" alt="" /><?php echo addslashes(t('Messages'))?></li>
			  </ul>
			   <div class="spacer"></div>
			  </div><?php */?>
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