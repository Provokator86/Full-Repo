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
					<h1>My Payment Settings</h1>
					
					<div id="err_flds" style="text-align:center; margin-bottom:20px;">
					<?php
					if($message!='')
					{
						if($message_type=='err')
							echo '<div class="error_massage">'.$message.'</div>';
						if($message_type=='succ')
							echo '<div class="success_massage">'.$message.'</div>';
					}
					?>
					</div>
					<div class="clear"></div>
						
					<div id="pay_tabs">
					  <ul>
						<li><a id="sel_neft" href="#tabs-1">Bank Payment (NEFT)</a></li>
						<?php /*?><li><a id="sel_cheque" href="#tabs-2">Cheque</a></li><?php */?>
					  </ul>
					  <div id="tabs-1">
						<form action="<?=base_url()?>user/payment" method="post" id="neft_form" class="neft_form" >
							<input type="hidden" name="pay_type" value="neft" />
							<h1>Enter Bank details</h1>
							<div class="in_clm">
								<div class="in_rw1">Name of Bank Account Holder :</div>
								<div class="in_rw2">
								<input name="s_neft_name" id="s_neft_name" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_neft_name"] ?>">
								</div>								
								<div class="clear"></div>
								<span id="s_neft_name_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>

							<div class="in_clm">
								<div class="in_rw1">Bank name :</div>
								<div class="in_rw2">
								<input name="s_neft_bank_name" id="s_neft_bank_name" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_neft_bank_name"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_neft_bank_name_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>
							
							<div class="in_clm">
								<div class="in_rw1">Bank Branch Name :</div>
								<div class="in_rw2">
								<input name="s_neft_branch_name" id="s_neft_branch_name" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_neft_branch_name"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_neft_branch_name_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>

							<div class="in_clm">
								<div class="in_rw1">Bank Account number :</div>
								<div class="in_rw2">
								<input name="s_neft_account" id="s_neft_account" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_neft_account"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_neft_account_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>
							
							<div class="in_clm">
								<div class="in_rw1">IFSC Code for Bank :</div>
								<div class="in_rw2">
								<input name="s_neft_ifsc" id="s_neft_ifsc" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_neft_ifsc"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_neft_ifsc_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>
							
							<?php if(!empty($withdrawl_session)) { ?>
							
							<div class="in_clm">
								<div class="in_rw1">&nbsp;</div>
								<div class="in_rw2">
									<input class="in_rw_submit5" name="pay_neft" id="pay_neft" type="submit" value="Confirm"/>
								</div>
							</div>
							<div class="clear"></div>
							
							<?php } else { ?>

							<div class="in_clm">
								<div class="in_rw1">&nbsp;</div>
								<div class="in_rw2">
									<input class="in_rw_submit5" name="pay_neft" id="pay_neft" type="submit" value="Submit"/>
								</div>
							</div>
							<div class="clear"></div>
							<?php } ?>
							
						   </form>
					  </div>
					  
					  <?php /*?><div id="tabs-2">
							<form action="<?=base_url()?>user/payment" method="post" id="cheque_form" class="cheque_form" >
							<input type="hidden" name="pay_type" value="cheque" />
							<h1>Enter Cheque details</h1>
							<div class="in_clm">
								<div class="in_rw1">Full Name on Address :</div>
								<div class="in_rw2">
								<input name="s_cheque_name" id="s_cheque_name" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_cheque_name"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_cheque_name_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>

							<div class="in_clm">
								<div class="in_rw1">Full Address :</div>
								<div class="in_rw2">
								<input name="s_address" id="s_address" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_address"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_address_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>
							
							<div class="in_clm">
								<div class="in_rw1">City :</div>
								<div class="in_rw2">
								<input name="s_city" id="s_city" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_city"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_city_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>

							<div class="in_clm">
								<div class="in_rw1">State :</div>
								<div class="in_rw2">
								<input name="s_state" id="s_state" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_state"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_state_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>
							
							<div class="in_clm">
								<div class="in_rw1">Postal Code :</div>
								<div class="in_rw2">
								<input name="s_postal_code" id="s_postal_code" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_postal_code"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_postal_code_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>
							
							<div class="in_clm">
								<div class="in_rw1">Contact Number :</div>
								<div class="in_rw2">
								<input name="s_contact_number" id="s_contact_number" type="text" class="in_rw_input" value="<?php echo $pay_info[0]["s_contact_number"] ?>">
								</div>
								<div class="clear"></div>
								<span id="s_contact_number_err" class="error_massage"></span>
							</div>
							<div class="clear"></div>

							<div class="in_clm">
								<div class="in_rw1">&nbsp;</div>
								<div class="in_rw2">
									<input class="in_rw_submit5" id="pay_cheque" name="pay_cheque" type="submit" value="Submit" />
								</div>
							</div>
							<div class="clear"></div>
						   </form>
					  </div><?php */?>
					  
					</div>
					
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
	$( "#pay_tabs" ).tabs();
	
	<?php if($pay_type=='cheque') { ?>
		$("#sel_cheque").click();
	<?php } ?>
	
	$("#pay_neft").click(function(){
       $("#neft_form").submit();
    }); 
	///////////Submitting the form/////////
	$("#neft_form").submit(function(){	
		
		var b_valid=true;
		$("#err_flds").hide();
		var s_err="";
		if($.trim($("#s_neft_name").val())=='')
		{
			b_valid=false;
			$("#s_neft_name_err").html('Enter name as it is in bank account.').show();
		}
		if($.trim($("#s_neft_bank_name").val())=='')
		{
			b_valid=false;
			$("#s_neft_bank_name_err").html('Enter bank name.').show();
		}
		if($.trim($("#s_neft_branch_name").val())=='')
		{
			b_valid=false;
			$("#s_neft_branch_name_err").html('Enter branch name or branch code.').show();
		}
		if($.trim($("#s_neft_account").val())=='')
		{
			b_valid=false;
			$("#s_neft_account_err").html('Enter correct bank account number.').show();
		}
		if($.trim($("#s_neft_ifsc").val())=='')
		{
			b_valid=false;
			$("#s_neft_ifsc_err").html('Enter IFSC code.').show();
		}
		
		
		<?php /*?>if(!b_valid)
		{
			$("#err_flds").html(s_err).show();
			b_valid = false;
		}<?php */?>
		return b_valid;
	}); 
	
	
	$("#pay_cheque").click(function(){
       $("#cheque_form").submit();
    }); 
	///////////Submitting the form/////////
	$("#cheque_form").submit(function(){	
		
		var c_valid=true;
		$("#err_flds").hide();
		var s_err="";
		if($.trim($("#s_cheque_name").val())=='')
		{
			c_valid=false;
			$("#s_cheque_name_err").html('Enter cheque number.').show();
		}
		if($.trim($("#s_address").val())=='')
		{
			c_valid=false;
			$("#s_address_err").html('Enter full address.').show();
		}
		if($.trim($("#s_city").val())=='')
		{
			c_valid=false;
			$("#s_city_err").html('Enter city name.').show();
		}
		if($.trim($("#s_state").val())=='')
		{
			c_valid=false;
			$("#s_state_err").html('Enter state name.').show();
		}
		if($.trim($("#s_postal_code").val())=='')
		{
			c_valid=false;
			$("#s_postal_code_err").html('Enter postal code.').show();
		}
		if($.trim($("#s_contact_number").val())=='')
		{
			c_valid=false;
			$("#s_contact_number_err").html('Enter contact number.').show();
		}
		
		<?php /*?>if(!b_valid)
		{
			$("#err_flds").html(s_err).show();
			b_valid = false;
		}<?php */?>
		return c_valid;
	});
	
});	
</script>
<style type="text/css">
.in_rw1{ width:285px; font-size:16px;}
.success_massage{ color:green; float: left; font-weight: bold; margin-left: 5px; }
.error_massage{ color:red; }
</style>