<div class="job_categories">
    <div class="top_part"></div>
    <div class="midd_part">
      <h2><?php echo addslashes(t('Job Categories'))?> </h2>
	  
    
	  	<?php if(count($category_list)) {
	  		$k = 0;
	  		foreach($category_list as $val)
				{
                    $make_url   =   make_my_url($val['s_category_name']).'/'.encrypt($val['id']) ;
					if($k%6 ==0)
					{
						echo '<ul>';
					}
				$icon_image = $val['s_icon']?$category_icon_path.'thumb_'.$val['s_icon']:'images/fe/icon.png';	
	   ?>
        <li><img src="<?php echo $icon_image ?>" alt="" /><a href="<?php echo base_url().'job/find-job/'.$make_url ; ?>"><?php echo $val['s_category_name'] ?></a></li>
       
		<?php 
		
			if($k++%6 == 5)
			{
			echo '</ul>';
			}
				} 
			} 
		
		
		?>
     
     
      <div class="spacer"></div>
      <div class="more"><a href="<?php echo base_url().'job/find-job' ?>"><?php echo addslashes(t('All Category Jobs'))?></a></div>
       <div class="spacer"></div>
    </div>
    <div class="spacer"></div>
    <div class="bottom_part"></div>
  </div>