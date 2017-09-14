<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="clear"></div>
<div class="right_pan2">
	<?php /*?><div><?php */?>
		<?php if($cntrlr=='home') { $extra_cls = 'edit-choice';} else {$extra_cls = '';} ?>
		
		<?php  if ($popular_deals){ ?>
	   <div class="prodct_heading_rght <?php echo $extra_cls; ?>">Editor's Choice <img src="<?php echo base_url().'images/editor.png' ?>" /></div>
	   <div class="right_product_box">
		   <div class="right_product_details  margin_btm" id="most_poplar">
		   
			   <?php  foreach ($popular_deals as $deal_meta):?>
				   <div class="rht_pdct_mst" >
					   <a href="<?=base_url().$deal_meta['s_seo_url']?>">
					   		<div class="right_product_mst">
						   <?php /*?><img src="<?=base_url()?>uploaded/deal/<?=$deal_meta['s_image_url']?>" alt="" /><?php */?>
						   <img src="<?=$deal_meta['s_image_url']?>" alt="" />
						   </div>
						   <div class="right_product_info">
							   <?=$deal_meta['s_title']?>
						   </div>
						</a>
				   </div>
			   <?php endforeach;?>
	
		   </div>
	   </div>
	   <?php }?>
   <?php /*?></div><?php */?>
</div>
<?php if($cntrlr=='home') { ?>
<?php /*?><div class="join_now_div">
	<h1>join For Free Now</h1>
	<div class="input_div">
		<input type="text" placeholder="*Enter your email address" />
		<input type="submit" value="Go" />
	</div>
</div><?php */?>
<?php } ?>

<div class="clear"></div>