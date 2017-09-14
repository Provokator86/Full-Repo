<script type="text/javascript" src="<?php echo base_url(); ?>js/fe/jquery.zclip.js"></script> 
<script type="text/javascript">
var base_url = '<?php echo base_url() ?>';
$(document).ready(function(){

	setInterval(function(){calculateTime()},1000);
	
	$("#copy-description").zclip({
		path: base_url+"js/fe/ZeroClipboard.swf",
		copy:  $('#copy-description').text()
		
	});
	
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

                $colckHtml +=   '<span style="font-weight:bold;">Expires in:</span>';
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

                $colckHtml +=   '<span style="font-weight:bold;">Expired on:</span>';
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
<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>

<div class="content">
    <div class="product_section">
        <div class="prodct1">
            <div class="p_deatils_box">
                <div class="details_heading_box">
                    <div class="p_heaing"><?php echo $details['s_title'] ?></div>
                    <?php /*?><p class="p_sub_heading"><? echo $CategoryPath;?></p><?php */?>

                </div>

                <div class="de_in">
						<?php /* ?>
						<div class="p_de_left prod_details">
								<h3>Details :</h3>
								<ul>
									<li><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. </li>
									<li>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC</li>
								</ul>
								<p>
									<img src="<?php echo base_url(); ?>images/shop.png" alt="" /><strong>Store:</strong> Flipkart
								</p>							
								<p>
									<img src="<?php echo base_url(); ?>images/atthe_rate.png" alt="" />
									<strong>Deal Price:</strong> 
									<span class="red_color">40%</span> 
									<span class="strike_through">Rs. 70</span>
								</p>							
								<p>
									<img src="<?php echo base_url(); ?>images/meanicons_7-16.png" alt="" />
									<strong>Shipping Charge:</strong> Flipkart
								</p>							
								<p>
									<img src="<?php echo base_url(); ?>images/info-16.png" alt="" />
									<strong>Expires on:</strong> Flipkart
								</p>							
								<p>
									<img src="<?php echo base_url(); ?>images/122-16.png" alt="" />
									<strong>Coupon Code:</strong> <span class="coupon_code">INFI250</span>
								</p>							
								<br />
								<h3>How to get this deal :</h3>
								<ul>
									<li><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. </li>
									<li>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC</li>
								</ul>
							
								<a target="_blank" href="<?php echo base_url().'thankyou/shopdeal/'.$details["i_id"] ?>"><img src="<?= base_url() ?>images/grab.png" onmouseover="this.src='<?= base_url() ?>images/grabhover.png';" onmouseout="this.src='<?= base_url() ?>images/grab.png';" /></a>						
							
						</div>						
						<?php */?>
						
						<div class="p_de_left prod_details">
								<h3>Details :</h3>
								<?php echo htmlspecialchars_decode($details["s_summary"]) ?>
								<p>
									<img src="<?php echo base_url(); ?>images/shop.png" alt="" />
									<strong>Store:</strong> <?php echo $details["s_store_title"] ?>
								</p>	
														
								<p>									
									<img src="<?php echo base_url(); ?>images/atthe_rate.png" alt="" />
									<?php if($details["d_selling_price"]!=0){ ?>
									<strong>Deal Price:</strong> 
									<span class="red_color">Rs.<?php echo $details["d_selling_price"] ?></span> 
									<span class="strike_through">Rs.<?php echo $details["d_list_price"] ?></span>
									
									<?php } else { ?>
									
									<strong>Deal Offer:</strong> 
									<span class="red_color"><?php echo $details["s_discount_txt"] ?></span>
									<?php } ?>
								</p>	
													
								<p>
									<?php if($details["d_shipping"]>0) { ?>	
									<?php /*?><img src="<?php echo base_url(); ?>images/meanicons_7-16.png" alt="" /><?php */?>
									<img src="<?php echo base_url(); ?>images/shipping.png" alt="" />
									<strong>Shipping Charge:</strong> Rs.<?php echo $details["d_shipping"];?>									
									<?php } else { ?>	
							<?php /*?><img src="<?php echo base_url(); ?>images/meanicons_7-16_green.png" alt="" /><?php */?>
									
									<img src="<?php echo base_url(); ?>images/shipping.png" alt="" />
									<strong>Shipping Charge:</strong> Free shipping					
									
									<?php } ?>
								</p>
								
								<?php if($details["dt_exp_date"]!="" && $details["dt_exp_date"]!="0000-00-00 00:00:00") { ?>
								<p>
									<img src="<?php echo base_url(); ?>images/info-16.png" alt="" />
									<strong>Expires on:</strong> <span class="red_expire"><?php echo date('F j, Y',strtotime($details["dt_exp_date"])) ?></span>
								</p>	
								<?php } ?>
								<?php if($details["i_coupon_code"]!="") { ?>						
									<p>
										<img src="<?php echo base_url(); ?>images/122-16.png" alt="" />
										<strong>Coupon Code:</strong> 
										<span class="coupon_code"><?php echo $details["i_coupon_code"];?></span>
									</p>	
								<?php } ?>	
								
								<?php if($details["s_terms"]!="") { ?>				
									<br />								
									<h3>How to get this deal :</h3>
									<?php echo htmlspecialchars_decode($details["s_terms"]) ?>
								<?php } ?>
							
								<a target="_blank" href="<?php echo base_url().'thankyou/shopdeal/'.$details["i_id"] ?>"><img src="<?= base_url() ?>images/grab.png" onmouseover="this.src='<?= base_url() ?>images/grabhover.png';" onmouseout="this.src='<?= base_url() ?>images/grab.png';" /></a>						
							
						</div>

                        <div class="p_de_right">

               				<img src="<?=base_url().'uploaded/store/'.$details['s_store_logo'] ?>" alt="" class="details_store_logo" />
								
                                <div class="p_de_right_img">

									<?php if($details['s_image_url']!='') { ?>
                                    <img src="<?= base_url(); ?>uploaded/deal/<?= $details['s_image_url'] ?>" alt="" />
									<?php } else { ?>
									<img src="<?= base_url(); ?>uploaded/deal/no-image.png" alt="" />
									
									<?php } ?>
								   <?php /*?> <img  style="height:300px;" src="<?= $details['s_image_url'] ?>" alt="" /><?php */?>

                                </div>


                        

                            <div class="product_cashback">
								<img class="" src="<?php echo base_url(); ?>images/cashback.png">
								<strong><?php echo $details["i_cashback"]?$details["i_cashback"]:"0" ?>% Cash Back</strong>
							</div>
                            <div class="share_link">
								
							
                                <div class="share_link_heading">Share This link</div>

                                <?php //echo $this->load->view('elements/addThis.tpl.php'); ?>
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_facebook"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_pinterest_share"></a>
<a class="addthis_button_google_plusone_share"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-524965d170d796bb"></script>
								
								
                            </div>
							
							<div class="next_prev_wrapper">
							<a href="<?php echo $prev_deal_link ?>" class="prev">Previous</a>
							<a href="<?php echo $next_deal_link ?>" class="next">Next</a>
							</div>
							<?php
							$loggedin = $this->session->userdata('current_user_session');
							if($loggedin[0]["i_id"]>0)	
							{						
							?>

                           <?php /*?> <a style="text-align: center;margin: 64px" target="_blank" href="<?= base_url() . 'track/' . ($details['i_id']) ?>"><img src="<?= base_url() ?>images/grab.png" onmouseover="this.src='<?= base_url() ?>images/grabhover.png';" onmouseout="this.src='<?= base_url() ?>images/grab.png';" /></a><?php */?>
							
							<?php } else { ?>
							
							<?php /*?><a style="text-align: center;margin: 64px" href="javascript:void(0);"><img onclick="chekForGrabOffer('<?php echo $details['s_url'];?>')" src="<?= base_url() ?>images/grab.png" onmouseover="this.src='<?= base_url() ?>images/grabhover.png';" onmouseout="this.src='<?= base_url() ?>images/grab.png';" /></a><?php */?>
							<?php } ?>
							
							
                            
                        </div>

                        <div class="clear"></div>                    
						<div class="video_cls">
							<?php echo htmlspecialchars_decode($details['s_video']);?>
						</div>

                    <? //$this->load->view('elements/rating_box.tpl.php'); ?>
                    <? //$this->load->view('elements/related_offer_box.tpl.php'); ?>
                </div>

            </div>
        </div>

        <div class="clear"></div>
    </div>

    <div class="right_pan">
        <div class="clear"></div>
        <?php echo $this->load->view('elements/subscribe.tpl.php'); ?>
        <?php echo $this->load->view('elements/facebook_like_box.tpl.php'); ?>
        <?php //echo $this->load->view('elements/latest_deal.tpl.php'); ?>
        <?php echo $this->load->view('elements/forum.tpl.php'); ?>
        <?php echo $this->load->view('common/ad.tpl.php'); ?>

        <div class="clear"></div>
    </div>
    <div class="clear"></div>
	 <?php echo $this->load->view('common/social_box.tpl.php'); ?>

</div>
<div class="clear"></div>
<script type="text/javascript">
    $(window).load(function() {  
        $('#wize_slider')
        .after("<div class='ban_btm'><div id='pager'></div></div>")
        .cycle({ 
            fx:      'fade', 
            timeout:  900,
            pager:    '#pager'
        });
    });
</script>