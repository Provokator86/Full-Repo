 <h1><?php echo t('Jobs ')?> <span><?php echo t('by Category')?></span></h1>
	  <div class="shadow_small">
			<div class="left_box" style="padding-bottom:0px;">
				  <ul class="category">
				  	<?php
						if($category_list)
						{
							foreach($category_list as $val)
							{
					?>
						<li><a href="<?php echo base_url().'job/find_job/'.encrypt($val['id'])?>"><?php echo $val['s_category_name']?></a></li>
					<?php
							}
						} else {
					?>
						<li><a href="#"><?php echo t('No record found')?></a></li>
					<?php	
						}
					?>
				  </ul>
				  <div class="button_bg">
						<input  class="button_big" type="button" style="font-size:12px;" value="<?php echo t('All Category Jobs')?>"  onclick="window.location.href='<?php echo base_url().'job/find_job'?>'"/>
				  </div>
			</div>
	  </div>
