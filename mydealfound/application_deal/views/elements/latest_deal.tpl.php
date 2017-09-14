<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="clear"></div>
<div class="right_pan3">
<div>
		<div class="prodct_heading_rght">Trending Now ! <img src="<?php echo base_url().'images/trend.png' ?>" /></div>
		<div class="right_product_box">  
		<?php 
			if($trending_now){
		 		foreach ($trending_now as $key=>$deal_meta){ 
		 
		 ?>
			
				<div class="right_product_details">
						<?php /*?><a href="<?= base_url().$deal_meta['s_seo_url']?>"> <?php */?>
						<a target="_blank" href="<?= base_url().'thankyou/index/'.$deal_meta['i_id']?>"> 
						   <div class="right_product">
						   <?php /*?><img style="max-width: 49px;max-height: 49px;"src="<?=base_url()?>uploaded/deal/<?=$deal_meta['s_image_url']?>" alt="" /><?php */?>
						   <img style="max-width: 49px;max-height: 49px;"src="<?php echo $deal_meta['s_image_url']?>" alt="" />
						   </div>
						</a>
						<div class="right_product_info"><?php echo $deal_meta['s_title']?></div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>

			<?php } 
				}
			?>
		</div>
</div>

</div>

<div class="clear"></div>