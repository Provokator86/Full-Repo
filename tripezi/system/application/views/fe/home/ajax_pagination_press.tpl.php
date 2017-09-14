
<div class="press-left-box">
	<?php if($press_list) 
			{
				foreach($press_list as $value)
					{
		
	 ?>
	  <h5><?php echo $value["s_title"] ?></h5>
	  <p><?php echo $value["s_desc_full"] ?></p>
	  <br class="spacer" />
	  <?php 
		 } } else {
	  ?>
	  <p>No press found.</p>
	  
	  <?php } ?>
	  
	  <!--page-number-->
	  <div class="page-number">
			<?php echo $page_links ?>
	  </div>
	  <!--page-number-->
</div>