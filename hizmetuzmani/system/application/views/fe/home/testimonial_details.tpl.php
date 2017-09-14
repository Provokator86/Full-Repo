<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
		<div class="top_part"></div>
		<div class="midd_part height02">
			  <div class="spacer"></div>
			  <h2><?php echo addslashes(t('Testimonials'))?></h2>
			  <div class="content_box">
			 
			  <p><?php echo $testimonial_details['s_content'] ?></p>
			  <div class="testi_writer"> - <?php echo $testimonial_details['s_person_name']?><br>
<span><?php echo $testimonial_details['dt_created_on'] ?></span></div>	
			  <div class="spacer"></div>

		  </div>
		  
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
  </div>