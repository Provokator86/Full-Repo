<?php
/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/
?>

<div class="deal_list_wrapper">
<script>
	function dealClockGenerater($timeOfExp){		
		$colckHtml = '';
		//$timeOfExp = '2013-10-3';
		$timestampObj = new Date();
		//$timeOfExpObj = new Date($timeOfExp.toString());			
		separateDateTime	= $timeOfExp.split(' ');			
		dateVal				= separateDateTime[0].split('-');			
		year	= dateVal[0];			
		mnth	= dateVal[1]-1;			
		day		= dateVal[2];			
		timeVal				= separateDateTime[1].split(':');			
		hour	= timeVal[0];			
		mins	= timeVal[1];			
		sec		= timeVal[2];			
		$timeOfExpObj	= new Date(year,mnth,day,hour,mins,sec);			
		//console.log($timeOfExpObj);			
		//console.log(parseInt($timestampObj.getTime()));			

		//console.log(parseInt($timeOfExpObj.getTime()) > parseInt($timestampObj.getTime()));
		if(parseInt($timeOfExpObj.getTime()) >= parseInt($timestampObj.getTime())){			
			seconds = Math.floor(($timeOfExpObj - ($timestampObj))/1000);
			minutes = Math.floor(seconds/60);
			hours = Math.floor(minutes/60);
			days = Math.floor(hours/24);
			
			hours = hours-(days*24);
			minutes = minutes-(days*24*60)-(hours*60);
			seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);
		

			$colckHtml +=   '<h3>Expires in:</h3>';
			$colckHtml +=   '<span class="dday"> ';
			//$colckHtml +=   (($timeOfExpObj.getTime()-$timestampObj.getTime())/ (1000 * 60 * 60 * 24));				
			$colckHtml +=   days;
			$colckHtml +=   '</span> days <span class="dmnth"> ';
			//$colckHtml +=   (23 -$timestampObj.getHours());				
			$colckHtml +=   hours;
			$colckHtml +=    '</span> hrs <span class="dmin"> ';
			//$colckHtml +=    (59 -$timestampObj.getMinutes());				
			$colckHtml +=   minutes;
			$colckHtml +=    '</span> min<span class="dsec"> ';
			//$colckHtml +=    (59 -$timestampObj.getSeconds());				
			$colckHtml +=    seconds;
			$colckHtml +=    '</span> sec' ;
			//console.log($colckHtml);
			return $colckHtml;
		} else {

			$colckHtml +=   '<h3>Expired on:</h3>';
			$colckHtml +=   '<span class="dday"> ';
			$colckHtml +=   ($timestampObj.getDay() - $timeOfExpObj.getDay());
			$colckHtml +=   '</span> days <span class="dmnth"> ';
			$colckHtml +=    $timestampObj.getHours();
			$colckHtml +=    '</span> hrs <span class="dmin"> ';
			$colckHtml +=    $timestampObj.getMinutes();
			$colckHtml +=    '</span> min<span class="dsec"> ';
			$colckHtml +=    $timestampObj.getSeconds();
			$colckHtml +=    '</span> sec' ;
			return $colckHtml;
		}
	}

	function calculateTime(){
		$('.deal_clock').each(function(){
			$(this).html(dealClockGenerater($(this).attr('clockData')));
			//console.log($(this).attr('clockData'));
		});
	}

	$(document).ready(function(){
		setInterval(function(){calculateTime()},1000);
		
		$(".pro_extend").mouseleave(function(){
			$(".shim").css({display:'none'});
		});
		
		$(".alert,.ilike").click(function(){
			$(".shim").css({display:'none'});
		});
		
	});

</script>

<div class="prodct1">
	<?php if (count($dealListData['dealList'])) { 
	
			foreach($dealListData['dealList'] as $ck=>$cv)
				{
			
	?>
	<div class="prodct_heading" style="padding:6px 0 6px 15px; text-align:left;">
	<?php echo $cv["s_category"]?><span style="font-size:11px;"> (<?php echo $cv["i_total_product"] ?>)</span><span style="float:right; font-size:11px;margin:2px 15px 2px 0;"><a href="<?php echo base_url().'category/'.$cv["s_url"] ?>">View More>></a></span>
	</div>	
	<div class="product_box <?php echo ($cntrlr=='home')?'sub_product_box':''?>">
		<?
			$current_dt	= now();
			if (count($cv['products'])) { 
				
				foreach ($cv['products'] as $dealMeta): ?>

				<div class="product">

					<div class="pro_extend">
						<div class="in_pro">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td height="100%" width="100%" align="center" valign="middle"><img src="<?= $dealMeta['s_image_url'] ?>" alt="<?= $dealMeta['s_image_url'] ?>" /><?php /*?><img src="<?= base_url() ?>uploaded/deal/<?= $dealMeta['s_image_url'] ?>" alt="<?= $dealMeta['s_image_url'] ?>" />  <?php */?> </td>
	</tr>
</table>

						    

							
						</div>
						<div class="product_info">
							<div class="product_info_head"><?php echo strlen($dealMeta['s_title'])>45?string_part($dealMeta['s_title'],45):$dealMeta['s_title']; ?></div>
							<div class="pro_detls"><?= $dealMeta['coupon_meta'] ?></div>
							<div class="look_in">
									<?php if($dealMeta['d_discount']>0) { ?>
									<span class="line_thr_prod">Rs <?= number_format($dealMeta['d_list_price']) ?></span>
									<?php } ?>
								
									Rs <?= number_format($dealMeta['d_selling_price']) ?>
									<?php if($dealMeta['d_discount']>0) { ?>
									<span class="disc">(<?php echo $dealMeta['d_discount'] ?>% off)</span>	
									<?php } ?>
							
							</div>
							
							
							<div class="product_cashback"><img src="<?= base_url() ?>images/cashback.png" class="" /><strong> 4.0% Cash Back</strong></div>

							<div class="store_image">     
								<img src="<?= base_url() ?>uploaded/store/<?= $dealMeta['s_store_logo'] ?>" class="snap" alt="Store" />
							</div>
							
							
							
						</div>
						
						<div class="product_icon_wrapper">
						<ul>
						<li><a href="javascript:void(0);" onclick="setPriceAlertDeal(<?php echo $dealMeta['i_id'] ?>)" class="alert">Alert</a></li>
						<li><a href="javascript:void(0);" onclick="favourite_deal(<?php echo $dealMeta['i_id'] ?>)" class="ilike">Like</a></li>
						<?php /*?><li><a href="javascript:void(0);" onclick="shareProduct(<?php echo $dealMeta['i_id'] ?>)" class="share">Share</a><?php */?>
						<li><a href="javascript:void(0);" onclick="$('#shim_<?php echo $dealMeta['i_id'];?>').toggle();" class="share">Share</a>
						
							<div class="shim" id="shim_<?php echo $dealMeta['i_id'];?>" style=" display:none;position:absolute; background-color:#f8f8f8; width:175px; height:auto; left:2px; top:-130px;">
								<div class="share-opts">
									<div class="hd" style="margin:2px; color:#F07317; font-size:12px;">Share<span class="close" style="font-size:12px;"><a href="javascript:void(0);" onclick="$('#shim_<?php echo $dealMeta['i_id'];?>').hide();">X</a></span></div>
									<div class="fb" style="margin:2px;"><a id="ref_fb" target="_blank"  href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($dealMeta['s_url']) ?>&t=<?php echo urlencode($dealMeta['s_title']) ?>" onclick="javascript:window.open(this.href, 'sharer', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
	<img src="<?php echo base_url().'images/fbshare.jpg' ?>" alt=""/></a></div>
									<div class="tw" style="margin:2px;"><a id="ref_tw" href="http://twitter.com/home?status=<?php echo urlencode($dealMeta['s_title']) ?>+<?php echo urlencode($dealMeta['s_url']) ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><img src="<?php echo base_url().'images/twshare.jpg' ?>" alt=""/></a></div>
									<div class="gp" style="margin:2px;"><a id="ref_gp" href="https://plus.google.com/share?url=<?php echo urlencode($dealMeta['s_url']) ?>"
	onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/gpshare.jpg' ?>" alt=""/></a></div>							
								</div>
							</div>						
						</li>
						
						</ul>
						</div>
						
				
<a href="<?php echo base_url().'thankyou/index/'.$dealMeta['i_id']  ?>" target="_blank" class="product_the_offer_butt"><img src="<?php echo base_url().'images/cart.png'?>" />SHOP NOW</a>
						
					</div>

					
					<? if (intval($dealMeta['i_cashback'])): ?>

						<div class="cash_back_ribbon">Rs <?= $dealMeta['i_cashback'] ?> Cashback</div>
						<img src="<?= base_url() ?>images/cashback_offer.png" class="cash_back" />	
					<? endif; ?>
				</div>
			<? endforeach; ?> 
		<? } else { ?>
			<div style="text-align: center">No Result Found</div>
		<? } ?>
		<div class="clear"></div>
	</div>
	<?php } } ?>
</div>
<?
$config['num_links'] = 2;
$config['cur_tag_open'] = '<li><a class="act" href="#">';
$config['cur_tag_close'] = '</a></li>';
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['prev_link'] = '&lsaquo; Previous';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';
$config['next_link'] = 'Next &rsaquo;';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';
$config['last_link'] = 'Last &raquo;';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';
$config['first_link'] = '&laquo; First';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';
$config['full_tag_open'] = '<ul>';
$config['full_tag_close'] = '</ul>';	
$config['div'] = '#deal_list';

if ($config['is_ajax'])
{
	$this->jquery_pagination->initialize($config);
	$pagging	= $this->jquery_pagination->create_links();
}
else
{
	$this->pagination->initialize($config);
	$pagging	= $this->pagination->create_links();
}

?>    

<?php /*?><div class="pagination">
	<?php echo $pagging;?>
</div><?php */?>
</div>