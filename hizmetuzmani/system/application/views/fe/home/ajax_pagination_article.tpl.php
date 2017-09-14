<?php               
                      
  if(!empty($article_list))
  {
	  foreach($article_list as $val)
	  {
		  
		 ?>
			    <a href="<?php echo base_url().'article-details/'.encrypt($val['id']); ?>"><h2 style="font-size:14px;"><?php echo $val['s_title'] ?> </h2></a>
			  <div class="content_box">
				<p><?php echo string_part($val['s_desc_full'],400) ?> </p> 
			  </div>
			  <div class="read_more2">
			  <a href="<?php echo base_url().'article-details/'.encrypt($val['id']); ?>" style="float:right;font-size:12px; color:#F06003; font-weight:bold;"><?php echo addslashes(t('Read More'))?>...</a>
			  </div>
			  <div class="spacer"></div>
			  
		<?php
		  
	  }
  }
  else
  {
  ?>
  	 <h2 style="font-size:14px;"></h2>
	  <div class="content_box">
		<p><?php echo addslashes(t('No item found')) ?> </p>                
	  </div>
 <?php }

?>

<div class="page">
 <?php echo $page_links ?> 
</div>