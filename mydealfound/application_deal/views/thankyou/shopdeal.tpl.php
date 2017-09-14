<style type="text/css">
.interstitialLayoutContent{background-color:white;border-radius:6px;margin:0;}
.interstitialMessage{font-size:26px;font-weight:bold;color:#528508}
.interstitialSubhead{font-size:18px;font-weight:bold;color:black}
.interstitialCouponDescrip{font-size:14px;color:#FF8002; font-weight:bold;line-height:24px;margin-top:12px}
.interstitialCoupon{background-color:#E2ECF5;border:1px dashed #1068AF;padding:12px;color:#1067aa;font-size:25px;font-weight:bold;float:left;margin-right:12px}

</style>
<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="product_section">
        <div class="input_fiela_box">
            <div class="hero-unit">
                <h1>Pleasure serving you at <a href="<?php echo base_url(); ?>">mydealfound.com</a></h1>
                <br/>
                <p>
                    Connecting you to <?php echo $details["s_store_title"] ?>. Hope you enjoyed shopping with us today, and found what you have been looking for.
                </p>
                <p>
                    Do come back soon with more ideas.
                </p>
            </div>	
			
			<div id="loader" style="width:250px; margin:20px auto; ">
				<img src="<?php echo base_url() ?>images/ajax-loader1.gif" />
			</div>
			
			
			<table align="center" style="width:100%;height:100%;">
            <tr>
                <td align="center" valign="middle">
                    <div class="interstitialLayoutContent">
					<table width="100%">
						<tr>
							<td>
								<table style="margin-bottom:20px" cellspacing="0" cellpadding="0">
									<tr>
									<td><div class="interstitialMessage">You're on your way to&nbsp;</div></td>
									<td>
									<?php if($details['s_store_logo']!="") { ?>
									<img src="<?php echo base_url().'uploaded/store/'.$details['s_store_logo'] ?>" />
									<?php } else { ?>
									<div class="interstitialMessage"><?php echo $details['s_store_title']; ?></div>
									<?php } ?>
									</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<div class="interstitialSubhead"><?php echo $details["s_title"] ?></div>
							</td>
						</tr>
						<tr>
							<td>
								<?php if($details["i_coupon_code"]!='') { ?>
								<div class="interstitialCouponDescrip">Enter Coupon at Checkout:</div>
								<div class="interstitialCoupon"><?php echo $details["i_coupon_code"] ?></div>
								<?php } ?>
							</td>
						</tr>
					</table>
                </div>
                </td>
            </tr>
        </table>
        		 
		
        </div>
        <div class="clear"></div>
		
		
    </div>	

    <div class="right_pan">
        <div class="clear"></div>
        <? $this->load->view('elements/subscribe.tpl.php'); ?>
        <? $this->load->view('elements/facebook_like_box.tpl.php'); ?>
        <?php //echo $this->load->view('elements/latest_deal.tpl.php'); ?>
        <? $this->load->view('elements/forum.tpl.php'); ?>
        <? $this->load->view('common/ad.tpl.php'); ?>
        <div class="clear"></div>

    </div>
    <div class="clear"></div>
</div>
 <? $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){
	$("#loader").show();	
	var redirect_url = '<?php echo $details["s_url"] ?>';
	if(redirect_url)
	{
		var tid = setTimeout(function() {
			window.location.href=redirect_url;
			}, 2000);  
	}  
	   						
});
</script>