<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
$(document).ready(function(){
	$('.horizontal li').mouseenter(function(e){
		//console.log(111);
	});

});

</script>

<?php /*?><div id="bx-pager">

        <? foreach ($featured_deals as $deal_meta):?>

          <div class="slide">

            <a href="<?=base_url()?><?=$deal_meta['s_seo_url']?>">

                <div class="dl_imgbox">

                    <div class="display_img">

                       
					    <img alt="" src="<?=$deal_meta['s_image_url']?>" />

                    </div>

                    <div class="dl_img_news"><?=$deal_meta['s_title']?></div>

                </div> 

            </a>

          </div>

         <? endforeach;?>
</div><?php */?>


<div class='banner_tabs tabs_hover'>
					
					<?php /*?><div id='tab-1'><img src="<?php echo base_url().'images/signup.png' ?>" /></div>
					<div id='tab-2'><img src="<?php echo base_url().'images/Shop_online_new.png' ?>" /></div>
					<div id='tab-3'><img src="<?php echo base_url().'images/get_paid.png' ?>" /></div>
					<div id='tab-4'><img src="<?php echo base_url().'images/refer.png' ?>" /></div><?php */?>
					<div id='tab-1'><img src="<?php echo base_url().'images/Signup.jpg' ?>" /></div>
					<div id='tab-2'><img src="<?php echo base_url().'images/shop_online.jpg' ?>" /></div>
					<div id='tab-3'><img src="<?php echo base_url().'images/get_paid.jpg' ?>" /></div>
					<div id='tab-4'><img src="<?php echo base_url().'images/refer.jpg' ?>" /></div>
					<ul class='horizontal'>
						<li><a href="#tab-1">1 <span>Sign Up</span></a></li>
						<li><a href="#tab-2">2 <span>Shop Online</span></a></li>
						<li><a href="#tab-3">3 <span>Get Paid</span></a></li>
						<li><a href="#tab-4">4 <span>Refer &amp; Earn</span></a></li>
					</ul>
				</div>
<?php /*?><ul class="bxslider">
  <li><img src="<?php echo base_url().'images/banner1.jpg' ?>" /></li>
  <li><img src="<?php echo base_url().'images/banner3.jpg' ?>" /></li>
  <li><img src="<?php echo base_url().'images/banner4.jpg' ?>" /></li>
  <li><img src="<?php echo base_url().'images/banner5.jpg' ?>" /></li>
  <li><img src="<?php echo base_url().'images/banner6.jpg' ?>" /></li>
</ul><?php */?>