<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(document).ready(function(){
	$('.product').show(); 
	setInterval(function(){calculateTime()},1000);
	
});


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

                //$colckHtml +=   '<span style="font-weight:bold;">Expires in:</span>';
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

                //$colckHtml +=   '<span style="font-weight:bold;">Expired on:</span>';
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

</script>

<div class="product_box">
<?php
if($offer_list){
	
	foreach($offer_list as $key=>$val)
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
		
		<div class="product_cashback"><img src="<?= base_url() ?>images/cashback.png" class="" /> <strong>4.0% Cash Back</strong></div>
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

					
	<? if (intval($val['i_cashback'])): ?>
		<div class="cash_back_ribbon">Rs <?= $val['i_cashback'] ?> Cashback</div>
		<img src="<?= base_url() ?>images/cashback_offer.png" class="cash_back" />	
	<? endif; ?>
</div>

<?php
		}
		
	}

else {	
?>
<div class="product">
	<div class="pro_extend">
		<div class="product_info">
		<p>No product found.</p>	
		</div>	
	</div>		
</div>
<?php } ?>

</div>
<div class="clear"></div>
<div class="pagination">
	<?php echo $page_links; ?>
</div>