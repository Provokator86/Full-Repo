<?php
if($product_list) :
?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(document).ready(function(){
	$('.product').show(); 
	
	$(".pro_extend").mouseleave(function(){
		$(".shim").css({display:'none'});
	});
	
	$(".alert,.ilike").click(function(){
		$(".shim").css({display:'none'});
	});
	
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
				<img src="<?= $val['s_image_url'] ?>" alt="Image" />
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
		
		<div class="product_cashback">
			<img src="<?= base_url() ?>images/cashback.png" class="" /> <strong><?php echo $val["i_cashback"]?$val["i_cashback"].' Cash Back':"No Cash Back" ?> <!--4.0% Cash Back--></strong>
		</div>
			<div class="store_image">     
				<img src="<?= base_url() ?>uploaded/store/<?= $val['s_store_logo'] ?>" class="snap" alt="Store" />
			</div>			
		</div>
		
		<div class="product_icon_wrapper">
		<ul>
			<li><a href="javascript:void(0);" onclick="setPriceAlertDeal(<?php echo $val['i_id'] ?>)" class="alert">Alert</a></li>
			<li><a href="javascript:void(0);" onclick="favourite_deal(<?php echo $val['i_id'] ?>)" class="ilike">Like</a></li>
			<?php /*?><li><a href="javascript:void(0);" onclick="shareProduct(<?php echo $val['i_id'] ?>)" class="share">Share</a></li><?php */?>
			<li><a href="javascript:void(0);" onclick="$('#shim_<?php echo $val['i_id'];?>').toggle();" class="share">Share</a>
				<?php /*?>		
				<div class="shim" id="shim_<?php echo $val['i_id'];?>" style=" display:none;position:absolute; background-color:#f8f8f8; width:175px; height:auto; left:2px; top:-130px;">
					<div class="share-opts">
						<div class="hd" style="margin:2px; color:#F07317; font-size:12px;">Share<span class="close" style="font-size:12px;"><a href="javascript:void(0);" onclick="$('#shim_<?php echo $val['i_id'];?>').hide();">X</a></span></div>
						<div class="fb" style="margin:2px;"><a id="ref_fb" target="_blank"  href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($val['s_url']) ?>&t=<?php echo urlencode($val['s_title']) ?>" onclick="javascript:window.open(this.href, 'sharer', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
<img src="<?php echo base_url().'images/fbshare.jpg' ?>" alt=""/></a></div>
						<div class="tw" style="margin:2px;"><a id="ref_tw" href="http://twitter.com/home?status=<?php echo urlencode($val['s_title']) ?>+<?php echo urlencode($val['s_url']) ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><img src="<?php echo base_url().'images/twshare.jpg' ?>" alt=""/></a></div>
						<div class="gp" style="margin:2px;"><a id="ref_gp" href="https://plus.google.com/share?url=<?php echo urlencode($val['s_url']) ?>"
onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/gpshare.jpg' ?>" alt=""/></a></div>							
					</div>
				</div>	<?php */?>	
				
				<div class="shim" id="shim_<?php echo $val['i_id'];?>" style=" display:none;position:absolute; background-color:#f8f8f8; width:175px; height:auto; left:2px; top:-45px;">
										<div class="share-opts">
											<div class="hd" style="margin:2px; color:#F07317; font-size:12px;">Share<span class="close" style="font-size:12px;"><a href="javascript:void(0);" onclick="$('#shim_<?php echo $val['i_id'];?>').hide();">X</a></span></div>
											<div class="fb">
											<a id="ref_fb" target="_blank"  href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($val['s_url']) ?>&t=<?php echo urlencode($val['s_title']) ?>" onclick="javascript:window.open(this.href, 'sharer', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
			<img src="<?php echo base_url().'images/facebook_hover.png' ?>" alt=""/></a>
			
											<a id="ref_tw" href="http://twitter.com/home?status=<?php echo urlencode($val['s_title']) ?>+<?php echo urlencode($val['s_url']) ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><img src="<?php echo base_url().'images/twitter_whte_hover.png' ?>" alt=""/></a>
											
											<a id="ref_gp" href="https://plus.google.com/share?url=<?php echo urlencode($val['s_url']) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/google_hover.png' ?>" alt=""/></a>
											
											<a id="ref_pin" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($val['s_url']) ?>&media=<?php echo urlencode($val['s_image_url']) ?>&description=<?php echo urlencode($val['s_title']) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/p_hover.png' ?>" alt=""/></a>
											
											</div>
								
										</div>
									</div>	
													
			</li>
			
			
		</ul>
		</div>
	
		<a href="<?php echo base_url().'thankyou/index/'.$val['i_id']  ?>" target="_blank" class="product_the_offer_butt"><img src="<?php echo base_url().'images/cart.png'?>" />SHOP NOW</a>
		
	</div>

					
	<?php /*?><? if (intval($val['i_cashback'])): ?>
		<div class="cash_back_ribbon">Rs <?= $val['i_cashback'] ?> Cashback</div>
		<img src="<?= base_url() ?>images/cashback_offer.png" class="cash_back" />	
	<? endif; ?><?php */?>
</div>

<?php
		}
		
	}
	
?>

</div>
<div id="page-nav-index" class="page-nav">
    <a href="<?= base_url() ?>category/ajax_pagination_product_list/page/<?= $next_record_pointer ?>">Older</a>
</div>
<div class="clear"></div>
<?php /*?><div class="pagination">
	<?php echo $page_links; ?>
</div><?php */?>
<?php
	endif;
?>