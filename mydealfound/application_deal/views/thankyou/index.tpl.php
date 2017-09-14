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
                    Connecting you to <?php echo $details["s_merchant"] ?>. Hope you enjoyed shopping with us today, and found what you have been looking for.
                </p>
                <p>
                    Do come back soon with more ideas.
                </p>
            </div>	
			
			<div id="loader" style="width:250px; margin:20px auto; ">
				<img src="<?php echo base_url() ?>images/ajax-loader1.gif" />
			</div>
        		 
		
        </div>
        <div class="clear"></div>
		
		
    </div>	

    <div class="right_pan">
        <div class="clear"></div>
        <? $this->load->view('elements/subscribe.tpl.php'); ?>
        <? $this->load->view('elements/facebook_like_box.tpl.php'); ?>
        <? $this->load->view('elements/latest_deal.tpl.php'); ?>
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