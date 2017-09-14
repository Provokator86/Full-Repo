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
		<?php /*?>commented for now as there is not required timer as per client 9 May 2014<?php */?>
		//$(this).html(dealClockGenerater($(this).attr('clockData')));
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
				<a target="blank" href="<?php echo base_url().'top-offers/details/'.$val['s_seo_url']  ?>"><img src="<?php echo base_url(); ?>uploaded/deal/<?php echo $val['s_image_url']?$val['s_image_url']:"no-image.png";?> " alt="Image" /></a>
				
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
			
			<?php if($val['d_shipping']>0) { ?>
			<div class="free_shipping">
				<img src="<?php echo base_url(); ?>images/meanicons_7-16.png" alt="" />&nbsp;Rs.<?php echo $val['d_shipping']; ?>			
			</div>
			
			<?php } else { ?>
			<div class="free_shipping_green">
				<img src="<?php echo base_url(); ?>images/meanicons_7-16_green.png" alt="" />&nbsp;Free Shipping			
			</div>
			<?php } ?>
		
		
		
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
				<img src="<?= base_url() ?>uploaded/store/<?= $val['s_store_logo'] ?>" class="snap" alt="Store" />
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
		<li><a href="<?php echo base_url().'top-offers/details/'.$val['s_seo_url']  ?>"  target="blank" class="plus">Details</a></li>
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
		<p>No offer found.</p>	
		</div>	
	</div>		
</div>
<?php } ?>

</div>
<div class="clear"></div>
<div class="pagination">
	<?php echo $page_links; ?>
</div>