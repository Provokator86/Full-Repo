<div class="breadcrumb">
	<ul>
		  <li><a href="<?php echo base_url()?>"><?php echo addslashes(t('Home'))?></a></li>
		  
		  <?php
			  if($breadcrumb)
			  {
				$total  = count($breadcrumb);
				$x=1;
				foreach($breadcrumb as $key=>$val){
			  ?>
				
				<?php
					if($x==$total)
					{
				?>
					<li>|</li>
					<li><?php echo $key;?></li>
				<?php
					}else{
				?>		
					<li>|</li>						
					<li><a href="<?php echo $val;?>"><?php echo $key;?></a></li>
			  <?php
					}
					$x++;	
				}
			  }
		 ?>	
	</ul>
    <div class="icon02">
			 <a href="https://twitter.com/#!/hizmet_uzmani" target="_blank"><img src="images/fe/tw.png" alt="" onmouseover="this.src='images/fe/tw-hover.png'" onmouseout="this.src='images/fe/tw.png'" /></a> <a href="https://www.facebook.com/hizmetuzmani" target="_blank"><img src="images/fe/facebook.png" alt="" onmouseover="this.src='images/fe/facebook-hover.png'" onmouseout="this.src='images/fe/facebook.png'" /></a> <a href="<?php echo base_url().'feeds'?>" target="_blank"><img src="images/fe/rss.png" alt="" onmouseover="this.src='images/fe/rss-hover.png'" onmouseout="this.src='images/fe/rss.png'"  class="lastimg"/></a> 	</div>
</div>