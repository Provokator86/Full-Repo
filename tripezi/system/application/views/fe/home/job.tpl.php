<!--open-->
<script type="text/javascript" src="js/fe/accordion.js"></script>
<!--open-->
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<h2>HR Contact</h2>
	<div class="border02"></div>
	<!--HR Contact-->
	<!--<div class="callbox">
		  <h5>Call us on</h5>
		  <h5><strong>+1 (563) 569 2569</strong><br />
				<strong>Ipsum@Ipsum.com</strong></h5>
	</div>-->
	<?php echo $jobs_hr_content["s_description"] ?>
	<!--HR Contact-->
	<!--jobs-box-->
	<div class="jobs-box">
		  <h2>Current Job Openings</h2>
		  <div id="firstpane">
		  
		  	<?php if($jobs) {
			
				foreach($jobs as $value)
					{
			 ?>
				
				<div class="menu-head"><?php echo $value["s_title"]; ?></div>
				<div class="menu-body" style="display:none">
					  <p><?php echo $value["s_full_content"]; ?></p>
				</div>
				
				<div class="spacer"></div>
			 <?php } } else { ?>	
				<p>No job found.</p>
			  <?php } ?>
					  
			<div class="spacer"></div>
		</div>
	</div>
	<!--jobs-box-->
</div>