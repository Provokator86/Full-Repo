<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="deal_list_wrapper">
    <div class="prodct1" style="margin:0;">
        <div class="prodct_heading"><?= $dealListData['title'] ?></div>
        <div class="product_box <?php echo ($cntrlr=='home')?'sub_product_box':''?>">
            <?php
				
				$current_dt	= now();
				if (count($dealListData['dealList'])) { 
					
					foreach ($dealListData['dealList'] as $dealMeta): 
					
			?>
                    
				<div class="product">
	<div class="pro_extend">
		<div class="in_pro">
			<!--
			<div class="in_pro_hover">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="90%">
					<tr>
					<td align="center" valign="middle" height="100%">
					<p><?php echo strlen($dealMeta["s_discount_txt"])>50?string_part(htmlspecialchars_decode($dealMeta["s_discount_txt"]),50):$dealMeta["s_discount_txt"] ?></p>
					</td>
					</tr>
				</table>
			</div>
			-->

			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
				<tr>
				<td height="100%" width="100%" align="center" valign="middle">
				<img src="<?php echo base_url(); ?>uploaded/deal/<?php echo $dealMeta['s_image_url']?$dealMeta['s_image_url']:"no-image.png";?> " alt="Image" />
				
				</td>
				</tr>
			</table>
			
			
		</div>
		<div class="product_info">
			<div class="product_info_head"><?php echo strlen($dealMeta['s_title'])>35?string_part($dealMeta['s_title'],35):$dealMeta['s_title']; ?></div>
			<div class="pro_detls"><?= $dealMeta['coupon_meta'] ?></div>
			<div class="look_in">
					<?php if($dealMeta['d_discount']>0) { ?>
					<?php /*?><span class="line_thr_prod">Rs <?= number_format($dealMeta['d_list_price']) ?></span><?php */?>
					<?php } ?>
				
					<?php /*?>Rs <?= number_format($dealMeta['d_selling_price']) ?>
					<p class="deal_clock" clockData="<?php echo $dealMeta['dt_exp_date'] ?>"></p><?php */?>
					
					<?php if($dealMeta['d_discount']>0) { ?>
					<?php /*?><span class="disc">(<?php echo $dealMeta['d_discount'] ?>% off)</span>	<?php */?>
					<?php } ?>
			
			</div>
		
		<?php /*?><div class="product_cashback">
			<img src="<?= base_url() ?>images/cashback.png" class="" /> 
			<strong><?php echo $dealMeta['i_coupon_code']?$dealMeta['i_coupon_code']:"No Code Needed"; ?></strong>
		</div><?php */?>
		
		<div class="product_cashback">
		<?php if($dealMeta['i_coupon_code']!='') { ?>
		<div class="offer-code">
			<div class="copy-code-icon"></div>
			<!--<div class="copy-code-text">Click to Copy &amp; Shop</div>-->
			<div class="offer-code-text"><?php echo $dealMeta['i_coupon_code']; ?></div>
		</div>
		<?php } else { ?>
		<div class="offer-code-none">
			No Code Needed
		</div>		
		<?php } ?>
		</div>
		
			<div class="store_image">     
				<img src="<?= base_url() ?>uploaded/store/<?= $dealMeta['s_store_logo'] ?>" class="snap" alt="Store" />
			</div>			
		</div>
		
		<!--<div class="product_icon_wrapper">
			<ul>
				<li><a href="#" target="_self" class="alert">Alert</a></li>
				<li><a href="#" target="_self" class="ilike">Like</a></li>
				<li><a href="#" target="_self" class="share">Share</a></li>
			</ul>
		</div>-->
		
		<?php /*?><a href="<?php echo $dealMeta['s_url']  ?>" target="_blank" class="product_the_offer_butt">Grab the offer</a><?php */?>
		<a href="<?php echo base_url().'top-offers/details/'.$dealMeta['s_seo_url']  ?>" target="_blank" class="product_the_offer_butt">View Details</a>
		<?php /*?><a href="<?php echo base_url().'thankyou/index/'.$dealMeta['i_id']  ?>" target="_blank" class="product_the_offer_butt">Grab the offer</a><?php */?>
		
	</div>

	<?php /*				
	<? if (intval($dealMeta['i_cashback'])): ?>
		<div class="cash_back_ribbon">Rs <?= $dealMeta['i_cashback'] ?> Cashback</div>
		<img src="<?= base_url() ?>images/cashback_offer.png" class="cash_back" />	
	<? endif; ?>
	<?php */ ?>
</div>

            <? endforeach; ?> 

            <? } else { ?>

                <div>
					<p style="font-size:12px; font-weight:normal; text-align:center;">No result found.</p>	
				</div>

            <? } ?>
            <div class="clear"></div>
        </div>

    </div>

    <?php

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

    <div class="pagination">
    	<?php echo $pagging;?>
    </div>
</div>

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