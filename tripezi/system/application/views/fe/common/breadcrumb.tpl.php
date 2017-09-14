<div class="breadcrumb">
		<ul>
			  <li><a href="<?php echo base_url()?>"><?php echo 'Home'?></a>  &raquo; </li>
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
					<li><?php echo $key;?></li>
				<?php
					}else{
				?>					
					<li><a href="<?php echo $val;?>"><?php echo $key;?></a> &raquo; </li>
			  <?php
					}
					$x++;	
				}
			  }
		 ?>	
		</ul>
  </div> 
  <div class="spacer">&nbsp;</div> 
  