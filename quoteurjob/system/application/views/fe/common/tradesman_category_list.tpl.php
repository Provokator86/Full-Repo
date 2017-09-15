 <h1><?php echo t('Tradesmen')?> <span><?php echo t(' by Category')?></span></h1>
	  <div class="shadow_small">
			<div class="left_box" style="padding-bottom:0px;">
				<div style="overflow:auto;" class="scrollDiv">
				  <ul class="category">
				  	<?php
						if($category_list)
						{
							foreach($category_list as $val)
							{
					?>
						<li><a href="<?php echo base_url().'find-tradesman/'.encrypt($val['id'])?>"><?php echo $val['s_category_name']?></a></li>
					<?php
							}
						} else {
					?>
						<li><a href="#"><?php echo t('No record found')?></a></li>
					<?php	
						}
					?>
				  </ul>
				   </div>
				  <div class="button_bg">
						<input  class="button_big" type="button" value="<?php echo t('All Categories')?>"  onclick="window.location.href='<?php echo base_url().'find_tradesman'?>'"/>
				  </div>
			</div>
	  </div>
