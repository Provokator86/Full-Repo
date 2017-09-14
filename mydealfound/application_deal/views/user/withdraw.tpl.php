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
							<span class="f_lft">Available Balance:</span> 
							<span class="f_rt">Rs <?php echo $total_pending_earn?$total_pending_earn:"0.00";?></span>
							<div class="clear"></div>
						</div>						
						<p>
						You can request payout only if your current account balance more than Rs <?php echo $d_min_balance;?>
						</p>						
					</div>					
					<div class="clear"></div>
					
					<?php if($total_pending_earn>=$d_min_balance){ ?>
					<form action="" method="post" class="withdrawl_form">
						<input type="hidden" id="avl_amount" name="avl_amount" value="<?php echo $total_pending_earn; ?>" />
						<input name="pay_mode" value="neft" type="hidden" >
						<h1>Withdrawl Request</h1>
						<div class="in_clm">
								<div class="in_rw1">Withdrawl Amount:</div>
								<div class="in_rw2">
								<?php /*?><input name="d_amount" value="<?php echo $total_pending_earn;?>" type="text" class="in_rw_input" from-validation="required"><?php */?>
								<input name="d_amount" id="d_amount" type="text" class="in_rw_input" from-validation="required">
								<span class="err" style="color:red;" id="d_amount_err"></span>
								</div>
								<div class="clear"></div>
						</div>
						<div class="clear"></div>
						
						<?php /*?><div class="in_clm">
								<div class="in_rw1">Payment Mode:</div>
								<div class="in_rw2">
								<input name="pay_mode" style="margin:13px 0;" value="cheque" checked="checked" type="radio" >&nbsp;Cheque
								<input name="pay_mode" style="margin:13px 0;" value="neft" type="radio" >&nbsp;Online
								</div>
								<div class="clear"></div>
						</div>
						<div class="clear"></div><?php */?>

						<div class="in_clm">
								<div class="in_rw1">&nbsp;</div>
								<div class="in_rw2">
								<input class="in_rw_submit5" id="btn_request" name="btn_request" type="submit" value="Send Request" />
								</div>
						</div>
						<div class="clear"></div>
					</form>
					<?php } ?>
					
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
	$("#btn_request").click(function(){
		$("#d_amount_err").html('');
		var b_valid = true;
		var avl_amount 	= $("#avl_amount").val();
		var w_amount	= $.trim($("#d_amount").val()); 
		if(w_amount=="")
		{
			b_valid = false;
			$("#d_amount_err").html('provide withdrawl amount');
		}
		else if(w_amount>avl_amount)
		{
			b_valid = false;
			$("#d_amount_err").html('provide amount less than available amount');
		}
		else
		{
			b_valid = true;
			$("#d_amount_err").html('');
		}
		
		return b_valid;
	});
});	
</script>