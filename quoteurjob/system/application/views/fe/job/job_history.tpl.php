<div style="display: block;">
	<div id="history_div" class="lightbox">
		  <h1><?php echo get_title_string(t('History'))?></h1>
		  <div style=" height:400px; overflow:auto; width:500px;">
		  		 <?php
				  if($history_details)
				  {					
					$i=1;
						foreach($history_details as $val)
						{
				  ?>
				<div class="<?php echo ($i++%2) ? 'white_box' : 'sky_box'?>">
				<?=$val['msg_string']?>				
				</div>
				<?php } }
					else echo '<div class="white_box" style="padding:5px;">'.t('No Record Found').'</div>';
				 ?>
				
		  </div>
	</div>
</div>