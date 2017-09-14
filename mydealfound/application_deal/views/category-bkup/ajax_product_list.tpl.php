<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(document).ready(function(){
	$('.product').show(); 
});
</script>
<div class="product_box">
<?php
if($product_list){
	foreach($product_list as $key=>$val)
	{
	
?>
<div class="product">
	<div class="pro_extend">
		<div class="in_pro">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
				<tr>
				<td height="100%" width="100%" align="center" valign="middle">
				<img src="<?= $val['s_image_url'] ?>" alt="<?= $val['s_image_url'] ?>" />
				<?php /*?><img src="<?= base_url() ?>uploaded/deal/<?= $val['s_image_url'] ?>" alt="<?= $val['s_image_url'] ?>" /><?php */?>   
				</td>
				</tr>
			</table>			
		</div>
		<div class="product_info">
			<div class="product_info_head"><?php echo strlen($val['s_title'])>35?string_part($val['s_title'],35):$val['s_title']; ?></div>
			<div class="pro_detls"><?= $val['coupon_meta'] ?></div>
			<div class="look_in">
					<?php if($val['d_discount']>0) { ?>
					<span class="line_thr_prod">Rs <?= number_format($val['d_list_price']) ?></span>
					<?php } ?>
				
					Rs <?= number_format($val['d_selling_price']) ?>
					<?php if($val['d_discount']>0) { ?>
					<span class="disc">(<?php echo $val['d_discount'] ?>% off)</span>	
					<?php } ?>
			
			</div>
		
			<div class="store_image">     
				<img src="<?= base_url() ?>uploaded/store/<?= $val['s_store_logo'] ?>" class="snap" alt="Store" />
			</div>			
		</div>
		
		<div class="product_icon_wrapper">
		<ul>
		<li><a href="#" target="_self" class="alert">Alert</a></li>
		<li><a href="#" target="_self" class="ilike">Like</a></li>
		<li><a href="#" target="_self" class="share">Share</a></li>
		</ul>
		</div>
		
		<a href="<?php echo $val['s_url']  ?>" target="_blank" class="product_the_offer_butt">Grab the offer</a>
	</div>

					
	<? if (intval($val['i_cashback'])): ?>
		<div class="cash_back_ribbon">Rs <?= $val['i_cashback'] ?> Cashback</div>
		<img src="<?= base_url() ?>images/cashback_offer.png" class="cash_back" />	
	<? endif; ?>
</div>

<?php
		}
		
	}
	
?>
</div>
<div class="clear"></div>
<div class="pagination">
	<?php echo $page_links; ?>
</div>