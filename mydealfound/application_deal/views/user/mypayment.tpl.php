<div class="clear"></div>
<div class="top_add_de"><img src="<?=base_url();?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="account_section">
		<div class="pro">
            <div class="account_left">
				<!--<div class="pro_left_heading">My Account</div>-->
			<?php echo $this->load->view('elements/left_account_block_tpl.php');?>

			</div>
			<div class="account_right">
				<div class="account_box">				       
					<h1><?php echo $title; ?></h1>
					<div class="clear"></div>
					<div class="earn_details">
					
					<div class="child_div">
						<span class="f_lft">Cashback Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_cashback_earn?$total_cashback_earn:"0.00";?></span>
						<div class="clear"></div>
					</div>
					
					<div class="child_div">
						<span class="f_lft">Paid Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_paid_earn?$total_paid_earn:"0.00";?></span>
						<div class="clear"></div>
					</div>
					
					<div class="child_div">
						<span class="f_lft">Referral Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_ref_earn?$total_ref_earn:"0.00";?></span>
						<div class="clear"></div>
					</div>
					
					<div class="child_div">
						<span class="f_lft">Available Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_pending_earn?$total_pending_earn:"0.00";?></span>
						<div class="clear"></div>
					</div>
					
				</div>
					
					<div class="clear"></div>
					
				</div>
			</div>
			<div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>	

    <?php /*?><div class="right_pan">
            <div class="clear"></div>
        <?php echo $this->load->view('elements/subscribe.tpl.php');?>
        <?php echo $this->load->view('elements/facebook_like_box.tpl.php');?>
       	<?php //echo $this->load->view('elements/latest_deal.tpl.php');?>
        <?php echo $this->load->view('elements/forum.tpl.php');?>
        <?php echo $this->load->view('common/ad.tpl.php');?>
        <div class="clear"></div>
    </div><?php */?>	
    <div class="clear"></div>
</div>
<?php echo $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){
	//$( "#pay_tabs" ).tabs();	
});	
</script>