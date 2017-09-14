<?php
if($food_list) :
?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(document).ready(function(){
	$('.product').show(); 
	$('.product_box .product:first-child').show();
});


</script>

<div class="product_box">
<?php
if($food_list){
	foreach($food_list as $key=>$val)
	{
	
?>
<div class="product">
	<div class="pro_extend">
		<div class="in_pro">			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
				<tr>
				<td height="100%" width="100%" align="center" valign="middle">
				<a target="blank" href="<?php echo base_url().'food-dining/details/'.$val['s_seo_url']  ?>"><img src="<?php echo base_url(); ?>uploaded/deal/<?php echo $val['s_image_url']?$val['s_image_url']:"no-image.png";?> " alt="Image" /></a>
				
				</td>
				</tr>
			</table>
			
			
		</div>
		<div class="product_info">
			<div class="product_info_head"><?php echo strlen($val['s_title'])>35?string_part($val['s_title'],35):$val['s_title']; ?></div>
			<div class="pro_detls"><?= $val['coupon_meta'] ?></div>
			<div class="look_in" style="display:none;">					
					<p class="deal_clock" clockData="<?php echo $val['dt_exp_date'] ?>"></p>
			</div>
			
			<?php /*?><?php if($val['d_shipping']>0) { ?>
			<div class="free_shipping">
				<img src="<?php echo base_url(); ?>images/meanicons_7-16.png" alt="" />&nbsp;Rs.<?php echo $val['d_shipping']; ?>			
			</div>
			
			<?php } else { ?>
			<div class="free_shipping_green">
				<img src="<?php echo base_url(); ?>images/meanicons_7-16_green.png" alt="" />&nbsp;Free Shipping			
			</div>
			<?php } ?><?php */?>
			
			<div class="look_in">
				<?php if($val['d_selling_price']>0 && $val['d_list_price']>0) { ?>
						<?php if($val['d_discount']>0) { ?>
						<span class="line_thr_prod">Rs <?= number_format($val['d_list_price']) ?></span>
						<?php } ?>
					
						Rs <?= number_format($val['d_selling_price']) ?>
						<?php if($val['d_discount']>0) { ?>
						<span class="disc">(<?php echo $val['d_discount'] ?>% off)</span>	
						<?php } ?>
				
				<?php } else { ?>
					<?php echo $val['s_discount_txt']?$val['s_discount_txt']:"&nbsp;"; ?>
				<?php } ?>
			</div>
		
		
		
		<div class="product_cashback">
		<?php if($val['i_coupon_code']!='') { ?>
		<div class="offer-code">
			<div class="copy-code-icon"></div>
			<!--<div class="copy-code-text">Click to Copy &amp; Shop</div>-->
			<div class="offer-code-text"><?php echo $val['i_coupon_code']; ?></div>
		</div>
		<?php } else { ?>
		<div class="offer-code-none">
			No Code Needed
		</div>		
		<?php } ?>
		</div>
		
			<div class="store_image">     
				<img src="<?php echo base_url(); ?>uploaded/store/<?php echo $val['s_store_logo']?$val['s_store_logo']:"no-image.png";?> " class="snap" alt="store" />
			</div>			
			<div class="product_cashback_hover">
				<img class="" src="<?php echo base_url() ?>/images/cashback.png">
				<strong><?php echo $val["i_cashback"]?$val["i_cashback"]:"0" ?>% Cash Back</strong>
			</div>
		</div>
		
		<div class="product_icon_wrapper">
		<ul>
		<?php /*?><li><a href="javascript:void(0);" onclick="add_subscribe_deal(<?php echo  $val['i_id'] ?>)" target="_self" class="alert">Alert</a></li><?php */?>
		<li><a href="javascript:void(0);" onclick="add_favourite_deal(<?php echo $val['i_id'] ?>)" target="_self" class="ilike">Like</a></li>
		<li><a href="<?php echo base_url().'food-dining/details/'.$val['s_seo_url']  ?>"  target="blank" class="plus">Details</a></li>
		<li>
				<a href="javascript:void(0);" onclick="$('#shim_<?php echo $val['i_id'];?>').toggle();" class="share">Share</a>
					
					
				<div class="shim" id="shim_<?php echo $val['i_id'];?>" style=" display:none;position:absolute; background-color:#f8f8f8; width:175px; height:auto; left:2px; top:-45px;">
					<div class="share-opts">
						<div class="hd" style="margin:2px; color:#F07317; font-size:12px;">Share<span class="close" style="font-size:12px;"><a href="javascript:void(0);" onclick="$('#shim_<?php echo $val['i_id'];?>').hide();">X</a></span></div>
						
						<div class="fb" >
							<a id="ref_fb" target="_blank"  href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($val['s_url']) ?>&t=<?php echo urlencode($val['s_title']) ?>" onclick="javascript:window.open(this.href, 'sharer', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
<img src="<?php echo base_url().'images/facebook_hover.png' ?>" alt=""/></a>

							<a id="ref_tw" href="http://twitter.com/home?status=<?php echo urlencode($val['s_title']) ?>+<?php echo urlencode($val['s_url']) ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><img src="<?php echo base_url().'images/twitter_whte_hover.png' ?>" alt=""/></a>
							
							
							<a id="ref_gp" href="https://plus.google.com/share?url=<?php echo urlencode($val['s_url']) ?>"
onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/google_hover.png' ?>" alt=""/></a>

							
							<a id="ref_pin" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($val['s_url']) ?>&description=<?php echo urlencode($val['s_title']) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/p_hover.png' ?>" alt=""/></a>

						</div>
						
					
				</div>	
				</div>
		</li>
		</ul>
		</div>
		
		
	</div>

					
	<?php /*?><? if (intval($val['i_cashback'])): ?>
		<div class="cash_back_ribbon">Rs <?= $val['i_cashback'] ?> Cashback</div>
		<img src="<?= base_url() ?>images/cashback_offer.png" class="cash_back" />	
	<? endif; ?><?php */?>
</div>

<?php
		}
		
	}

else {	
?>
<div class="product">
	<div class="pro_extend">
		<div class="product_info">
		<p>No offer found.</p>	
		</div>	
	</div>		
</div>
<?php } ?>

</div>
<div id="page-nav-index" class="page-nav">
    <a href="<?= base_url() ?>food_dining/ajax_pagination_food_list/page/<?= $next_record_pointer ?>">Older</a>
</div>
<div class="clear"></div>
<?php
	endif;
?>