<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

?>

<div class="deal_list_wrapper offers_list">

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

        $(document).ready(function(){

            setInterval(function(){calculateTime()},1000);
			
			$(".product").show(); // to show the first child also which is hidden by css

        });

    </script>

    <div class="prodct1">

        <div class="prodct_heading"><?= $dealListData['title'] ?></div>

        <div class="product_box <?php echo ($cntrlr=='home')?'sub_product_box':''?>">

            <?
				
				$current_dt	= now();
				if (count($dealListData['dealList'])) { ?>
					
                <? 
					
					foreach ($dealListData['dealList'] as $dealMeta): 
					
					?>
							<div class="product">
							<div class="pro_extend">
		<div class="in_pro">
			<?php /*?><div class="in_pro_hover">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="90%">
					<tr>
					<td align="center" valign="middle" height="100%">
					<p><?php echo strlen($dealMeta["s_discount_txt"])>50?string_part(htmlspecialchars_decode($dealMeta["s_discount_txt"]),50):$dealMeta["s_discount_txt"] ?></p>
					</td>
					</tr>
				</table>
			</div><?php */?>
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
					<?php /*?><span class="line_thr_prod">Rs <?= number_format($val['d_list_price']) ?></span><?php */?>
					<?php } ?>
				
					<?php /*?>Rs <?= number_format($val['d_selling_price']) ?><?php */?>
					<p class="deal_clock" clockData="<?php echo $dealMeta['dt_exp_date'] ?>"></p>
					
					<?php if($dealMeta['d_discount']>0) { ?>
					<?php /*?><span class="disc">(<?php echo $val['d_discount'] ?>% off)</span>	<?php */?>
					<?php } ?>
			
			</div>
		
		<?php /*?><div class="product_cashback">
			<img src="<?= base_url() ?>images/cashback.png" class="" /> 
			<strong><?php echo $val['i_coupon_code']?$val['i_coupon_code']:"No Code Needed"; ?></strong>
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
			<div class="product_cashback_hover">
				<img class="" src="<?php echo base_url() ?>/images/cashback.png">
				<strong>4.0% Cash Back</strong>
			</div>	
		</div>
		
		<div class="product_icon_wrapper">
		<ul>
		<?php /*?><li><a href="javascript:void(0);" onclick="add_subscribe_deal(<?php echo  $dealMeta['i_id'] ?>)" target="_self" class="alert">Alert</a></li><?php */?>
		<li><a href="javascript:void(0);" onclick="add_favourite_deal(<?php echo $dealMeta['i_id'] ?>)" target="_self" class="ilike">Like</a></li>
		<li><a href="<?php echo base_url().'top-offers/details/'.$dealMeta['s_seo_url']  ?>"  target="_blank" class="plus">Details</a></li>
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
		
		<?php /*?><a href="<?php echo $val['s_url']  ?>" target="_blank" class="product_the_offer_butt">Grab the offer</a><?php */?>
		<?php /*?><a href="<?php echo base_url().'top-offers/details/'.$dealMeta['s_seo_url']  ?>" target="_blank" class="product_the_offer_butt">View Details</a><?php */?>
		<?php /*?><a href="<?php echo base_url().'top-offers/details/'.$val['s_seo_url']  ?>" target="_blank" class="product_the_offer_butt"><img src="<?php echo base_url().'images/cart.png'?>" />SHOP NOW</a><?php */?>
		<?php /*?><a href="<?php echo base_url().'thankyou/index/'.$val['i_id']  ?>" target="_blank" class="product_the_offer_butt">Grab the offer</a><?php */?>
		
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

        <?php /*?><? if ($config['is_ajax']): echo 3;?>

        <script>

            $('.pagination ul li a').click(function(e){

                e.preventDefault();

                console.log($(this).attr('href'));

                if($(this).attr('href')=='#'){

                    return;

                }

                targetObj = $(this);

                $.post($(this).attr('href'),null,function(resData){

                    $(targetObj).parent().parent().parent().parent().html(resData);

                },'html');

                return;

            });

        </script>

<? echo 4; endif; ?><?php */?>

</div>