<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- top store slider link start -->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
<!--<link href="css/jquery.bxslider2.css" rel="stylesheet" type="text/css" media="all">-->
<script type="text/javascript">
$(document).ready(function() {
	$('.bxslider').bxSlider({
		infiniteLoop: true,
		hideControlOnEnd: true,
		auto: true,		
		pager:false
	});
	
	$('.slider1').bxSlider({
    slideWidth: 150,
    minSlides: 3,
    maxSlides: 7,
    slideMargin: 5,
	auto:true,
	pager:false
  });
	
});
</script>
<!-- top store slider link end -->
        <div class="banner_section">            
			<div class="banner">
				<? $this->load->view('elements/feature_deal.tpl.php');?>
			</div>
			
			<div class="ban_tab">
			 	<?php //echo $this->load->view('elements/popular_store.tpl.php');?>
				<?php echo $this->load->view('elements/most_popular.tpl.php');?>
			</div>
			
			<div class="clear"></div>
        </div>

         <div class="clear"></div>
        <div class="content">
                <div class="product_section">
                     <? //$this->load->view('elements/filter_box.tpl.php');?>
                 <div class="clear"></div>
                <?php /*?> <div id="deal_list">												
                      <?=$display_homepage_listing?>
                 </div>	<?php */?>
				 			 
				 	<!-- NEW DESIGN START HERE -->					
				 <div id="deal_list">												
                      <?php echo $display_product_listing; ?>
                 </div>				 
					<!-- NEW DESIGN END HERE -->
				
				<!-- BRAND SLIDER START -->
				<?php if(!empty($all_brand)) { ?>
				<div class="thumbslider">
                <div class="slider1">
					<?php foreach($all_brand as $key=>$val) {
							if($val["s_brand_logo"]!='')
								{
					 ?>
					<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%"><img src="<?php echo base_url().'uploaded/brand/'.$val['s_brand_logo'] ?>"></td>
						</tr>
						</table>				
					</div>
					
					<?php 		} 
							} 
					
					?>
					
					<!--<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%">
						<img src="http://static.jabong.com/images/jlite/logo-new.png"></td>
						</tr>
						</table>
					</div>
					<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%"><img src="http://img6a.flixcart.com/www/prod/images/flipkart_india-b1a41241.png"></td>
						</tr>
						</table>					
					</div>
					<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%">
						<img src="http://static.jabong.com/images/jlite/logo-new.png"></td>
						</tr>
						</table>
					</div>  
					<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%"><img src="http://img6a.flixcart.com/www/prod/images/flipkart_india-b1a41241.png"></td>
						</tr>
						</table>					
					</div>
					<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%">
						<img src="http://static.jabong.com/images/jlite/logo-new.png"></td>
						</tr>
						</table>
					</div>
  
					<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%"><img src="http://img6a.flixcart.com/www/prod/images/flipkart_india-b1a41241.png"></td>
						</tr>
						</table>					
					</div>
					
					<div class="slide">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
						<tr>
						<td align="center" valign="middle" height="100%">
						<img src="http://static.jabong.com/images/jlite/logo-new.png"></td>
						</tr>
						</table>
					</div>-->
				</div>
				
				</div>
                </div>
				<?php } ?>
				<!-- BRAND SLIDER END -->
				
                <div class="right_pan">
                    <?php echo $this->load->view('elements/subscribe.tpl.php');?>
                    <?php //echo $this->load->view('elements/most_popular.tpl.php');?>
                    <?php echo $this->load->view('elements/facebook_like_box.tpl.php');?>
                    <?php // echo $this->load->view('elements/latest_deal.tpl.php');?>
                    <?php echo $this->load->view('elements/forum.tpl.php');?>
                    <?php echo $this->load->view('common/ad.tpl.php');?>
                <div class="clear"></div>
<!-- start of top stores slider -->

<!-- end of top stores slider -->	
        
<!-- start just added -->
<div class="right_pan6">
    <div>
        <div class="prodct_heading_rght">Just added <span class="just_more"><a href="javascript:void(0);">More</a></span></div>
			<?php if(!empty($just_added)) {
					foreach($just_added as $value)
						{
			 ?>
			<div class="right_product_box">
				<div class="right_product_details">
				<div class="right_product_info">
				<?php echo $value["s_title"] ?><br />
				<span><a href="<?php echo base_url().getStoreUrls($value["i_store_id"]); ?>"><?php echo $value["i_store_id"]>0?'@'.getStoreTitles($value["i_store_id"]):""; ?></a></span>
				</div>    
				<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			
			<?php
					}
				}
			?>
			
			<?php /*?><div class="right_product_box">
				<div class="right_product_details">			
				<div class="right_product_info">Lorem Ipsum is simply dummy text of the printing and typesetting<br />
				<span>@bust buy</span>
				</div>			
				<div class="clear"></div>			
				</div>			
				<div class="clear"></div>			
			</div>
			
			<div class="right_product_box">			
				<div class="right_product_details">		
				<div class="right_product_info">Lorem Ipsum is simply dummy text of the printing and typesetting<br />
				<span>@bust buy</span>
				</div>			
				<div class="clear"></div>			
				</div>			
				<div class="clear"></div>			
			</div>
			
			<div class="right_product_box">			
				<div class="right_product_details">		
				<div class="right_product_info">Lorem Ipsum is simply dummy text of the printing and typesetting<br />
				<span>@bust buy</span>
				</div>			
				<div class="clear"></div>			
				</div>			
				<div class="clear"></div>			
			</div>
			
			<div class="right_product_box">			
				<div class="right_product_details">		
				<div class="right_product_info">Lorem Ipsum is simply dummy text of the printing and typesetting<br />
				<span>@bust buy</span>
				</div>			
				<div class="clear"></div>			
				</div>			
				<div class="clear"></div>			
			</div><?php */?>

	</div>
</div>
<!-- end just added -->				
<!-- start of how cash back works -->	
<div class="right_pan7">

		<div>	
			<div class="prodct_heading_rght">How cash back works</div>		
			<div class="right_product_box">	
				<div class="right_product_details">	
					<div class="right_product"><img alt="" src="<?php echo base_url()?>images/joinfree.jpg"></div>	
						<div class="right_product_info">	<span class="boldtxt">Join for Free</span><br />	
						<!--Creating an Extrabux account takes 30 seconds and doesn't require a credit card. All you need is an email address and password.--> Creating a My Deal Found account takes 30 seconds and doesn't require a credit card. All you need is an email address and password.
						</div>	
					<div class="clear"></div>	
				</div>	
				<div class="clear"></div>	
			</div>
		
		
			<div class="right_product_box">	
				<div class="right_product_details">	
					<div class="right_product"><img alt="" src="<?php echo base_url()?>images/shoponline.jpg"></div>	
					<div class="right_product_info">
					<span class="boldtxt">Shop Online </span><br />
					<!--Click to any store's website from Extrabux and make a purchase. The store sends us a sales commission from your order, which we use to put cash back in your Extrabux account! -->
					Click to any store's website from My Deal Found and make a purchase. The store sends us a sales commission from your order, which we use to put cash back in your My Deal Found account!
					</div>	
					<div class="clear"></div>	
				</div>	
				<div class="clear"></div>	
			</div>
			
			<div class="right_product_box">	
				<div class="right_product_details">		
					<div class="right_product"><img alt="" src="<?php echo base_url()?>images/getpaid.jpg"></div>		
					<div class="right_product_info">
					<span class="boldtxt">Get Paid!  </span><br />
					<!--Extrabux sends you cash back! Receive it via your credit card, PayPal, or a check in the mail. Or, you can donate it to a charity. -->My Deal Found sends you cash back! Receive it into your nominated bank account.</div>
					
					<div class="clear"></div>		
				</div>		
				<div class="clear"></div>	
			</div>
		
			<div class="right_product_box">	
				<div class="right_product_details">
					<div class="right_product_info">	
					<a href="<?php echo base_url().'user/signup' ?>" class="join_free">Join for Free</a>
					</div>	
					<div class="clear"></div>	
				</div>	
				<div class="clear"></div>	
			</div>
	
	
	</div>

		</div>

<!-- end of how cash back works -->

		 <div class="clear"></div>
</div>

 <?php echo $this->load->view('common/social_box.tpl.php');?>
</div>