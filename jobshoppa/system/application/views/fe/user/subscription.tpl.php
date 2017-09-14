<script type="text/javascript" language="javascript" >  
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    
    
///////////Submitting the form/////////
$("#form_buyer_reg").submit(function(){  

//alert(12423435);

    var b_valid=true;
    var s_err="";
   
    if($.trim($("#txt_credit_card_number").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide credit card number</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#opd_card_type").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select card type</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#txt_card_verification_no").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide card verification no</strong></div>';
        b_valid=false;
    }
    
    
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
	  
        $("#div_err").html(s_err).show("slow");
    }
    else
		$('#reg_buton').attr('disabled','disabled');  
  
    return b_valid;
}); 


///////////end Submitting the form///////// 
    /*$('#btn_reg').click(function(){
        $("#form_buyer_reg").submit();
    }); */

});
});





  
</script>

<div id="banner_section">
	<?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
<?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
	<div id="content">
		<div id="div_err">
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
		</div>
		<div id="inner_container02">
			<!--<div class="title">
                <h3><span>Welcome to Jobshoppa,</span> </h3>
            </div>-->
			<div class="clr"></div>
			<div id="registration_box">
				<!-- <p class="big_txt15">Registration is <span style="color:#f68e29;">FREE</span></p>
                <p>&nbsp;</p>-->
				<form id="form_buyer_reg" action="" method="post" enctype="multipart/form-data" >
					<div class="title04" style="margin:10px 0 0px;">
						<h3><span>Payment</span></h3>
					</div>
					<div class="clr"></div>
					<p style="text-align:right;"><span class="red_txt">*</span> Required field</p>
					<div class="clr"></div>
					<div class="label01" style="width:450px;">Payment Type :</div>
					<div class="field01" style="width:500px;"><strong>Membership Subscription</strong></div>
					<div class="clr"></div>
					<div class="label01" style="width:450px;">Payment Amount :</div>
					<div class="field01" style="width:500px;"><strong>£ <?php echo $amt_to_paid?></strong></div>
					<div class="clr"></div>					
					<div style=" border-top:1px solid #ddd; padding-top:15px; margin-top:15px;">
						<div class="right" style="width:600px;">
							<div class="label01" style="width:200px;">Card No<span class="red_txt">*</span> :</div>
							<div class="field01" style="width:350px;">
								<div id="parent_zip">
									<input type="text" name="txt_credit_card_number" id="txt_credit_card_number" value="<?php echo $posted["txt_credit_card_number"] ?>" size="48"/>
								</div>
							</div>
							<div class="label01" style="width:200px;">Card Type<span class="red_txt">*</span> :</div>
							<div class="field01" style="width:350px;">
								<div id="parent_zip">
									<select name="opd_card_type" id="opd_card_type">
										<option value="Visa">Visa</option>
										<option value="MasterCard">MasterCard</option>
										<option value="Discover">Discover</option>
										<option value="Amex">Amex</option>
									</select>
								</div>
							</div>
							<div class="clr"></div>
							<div class="label01" style="width:200px;">Expiration Date <span class="red_txt">*</span> :</div>
							<div class="field01" style="width:350px;">
								<div id="parent_zip">
									<select name="opd_exp_month" id="opd_exp_month" style="width:100px;">
										<?php
										for($i=1;$i<=12;$i++)
										{
										?>
										<option value="<?php echo $i;?>" <?php echo ($i==date("m")) ? 'selected' :''?>><?php echo $i;?></option>
										<?php } ?>
									</select>
									Month
									<select name="opd_exp_year" id="opd_exp_year" style="width:100px;">
										<?php
										$cur_date = date("Y");
										$max_exp_date = $cur_date + 5;
										for($i=$cur_date;$i<=$max_exp_date;$i++)
										{
										?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php } ?>
									</select>
									Year </div>
							</div>
							<div class="label01" style="width:200px;">Card Verification No<span class="red_txt">*</span> :</div>
							<div class="field01" style="width:350px;">
								<div id="parent_zip">
									<input type="text" name="txt_card_verification_no" id="txt_card_verification_no" value="<?php echo $posted["txt_card_verification_no"] ?>" size="48"/>
								</div>
							</div>
							<div class="label01" style="width:200px;"></div>
							<div class="field01" style="width:350px;">
								<input type="submit" name="submit" id="reg_buton" value="Submit" />
							</div>
						</div>
						<div class="left" style=" width:300px;text-align:center;background:#f1f1f1; border:1px solid #ddd; margin-top:10px; padding:20px;">
							<!--<p style="color:#F58726;"><strong>Pay using your paypal A/C</strong> </p>-->
							<p><img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" style="cursor:pointer;" onclick='window.location="<?php echo base_url().'user/paypal_payment/'.$i_user_id.'/'.$page?>"'></p>
							<p><strong>OR</strong></p>
							<p style="color:#F58726;"><strong>Pay using your credit / debit card</strong></p>
						</div>
						<div class="clr"></div>
					</div>
				</form>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
</div>
<?php  //End of content_section ?>
