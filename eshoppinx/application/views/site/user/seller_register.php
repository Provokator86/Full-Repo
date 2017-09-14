<?php
$this->load->view('site/templates/header',$this->data);
?>
<style type="text/css" media="screen">


#edit-details {
    color: #FF3333;
    font-size: 11px;
}
.option-area select.option {
    border: 1px solid #D1D3D9;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 1px 1px 1px #EEEEEE;
    height: 22px;
    margin: 5px 0 12px;
}
a.selectBox.option {
    margin: 5px 0 10px;
    padding: 3px 0;
}
a.selectBox.option .selectBox-label {
    font: inherit !important;
    padding-left: 10px;

}

</style>



<div id="container-wrapper">
<div class="main2">      
            	<div class="main_box">   
	<div class="container ">
		

		<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
			<section class="merchant">
			<form action="site/user/seller_signup" method="post" id="seller_signup" onsubmit="return validateSellerSignup();">
				<div class="error-box" style="display:none;">
					<p><?php if($this->lang->line('seller_some_requi') != '') { echo stripslashes($this->lang->line('seller_some_requi')); } else echo "Some required information is missing or incomplete. Please correct your entries and try again"; ?>.</p>
					<ul></ul>
				</div>
				<dl style="float:left; width:50%; margin:40px 0 0">
					<dt style="font-size:18px; margin:0 0 20px"><?php if($this->lang->line('seller_merc_info') != '') { echo stripslashes($this->lang->line('seller_merc_info')); } else echo "Merchant Information"; ?></dt>
<!-- 					<dd class="radio"><span class="label">Account Type</span>
						<input type="radio" name="account" id="person_account" checked="checked" /> <label for="Personal">Personal</label>
						<input type="radio" name="account" id="business_account" /> <label for="accountB">Business</label>
					</dd>
 -->                    <dd><label for="" class="label"><?php if($this->lang->line('seller_brand') != '') { echo stripslashes($this->lang->line('seller_brand')); } else echo "Brand"; ?><sup style="color: red;">*</sup></label>
                        <input type="text" name="brand_name" id="brand_name" class="ship_txt" />
                    </dd>
					<dd><label for="" class="label"><?php if($this->lang->line('header_description') != '') { echo stripslashes($this->lang->line('header_description')); } else echo "Description"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="brand_description" id="brand_description" class="ship_txt"/>
						<!--p class="required"><span></span>This field is required</p-->
					</dd>
					<!--dd><label for="" class="label">Email</label>
						<input type="text" id="account_email" value="dhdh@hdhd.com"/>
					</dd-->
					<dd><label for="" class="label"><?php if($this->lang->line('seller_web_link') != '') { echo stripslashes($this->lang->line('seller_web_link')); } else echo "Website Link"; ?></label>
						<input type="text" name="web_url" id="web_url" style="margin-bottom: 10px;" class="ship_txt"/>
                    </dd>
					<dd><label for="" class="label"><?php if($this->lang->line('header_addrs_one') != '') { echo stripslashes($this->lang->line('header_addrs_one')); } else echo "Address Line 1"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="s_address" id="s_address" class="ship_txt"/>
                    </dd>
                    <dd><label for="" class="label"><?php if($this->lang->line('header_city') != '') { echo stripslashes($this->lang->line('header_city')); } else echo "City"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="s_city" id="s_city" class="ship_txt"/>
                    </dd>
                    <dd><label for="" class="label"><?php if($this->lang->line('checkout_state') != '') { echo stripslashes($this->lang->line('checkout_state')); } else echo "State"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="s_state" id="s_state" class="ship_txt"/>
                    </dd>
					<dd><label for="" class="label"><?php if($this->lang->line('seller_postal_code') != '') { echo stripslashes($this->lang->line('seller_postal_code')); } else echo "Postal Code"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="s_postal_code" id="s_postal_code" class="ship_txt"/>
					</dd>
					<dd>
						<label class="label"><?php if($this->lang->line('header_country') != '') { echo stripslashes($this->lang->line('header_country')); } else echo "Country"; ?><sup style="color: red;">*</sup></label>
						<?php 
						if(isset($countryList) && $countryList->num_rows()>0){
						?>
						<select name="s_country" class="select-white select-country" id="s_country">
						<?php 
							foreach ($countryList->result() as $country){
						?>
						<option value="<?php echo $country->country_code;?>"><?php echo $country->name;?></option>
						<?php 
							}
						?>						
						</select>
						<?php 
						}else {
						?>
						<input type="text" name="s_country" id="s_country" class="ship_txt"/>
						<?php }?>
					</dd>

					
					<dd><label for="" class="label"><?php if($this->lang->line('checkout_phone_no') != '') { echo stripslashes($this->lang->line('checkout_phone_no')); } else echo "Phone Number"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="s_phone_no" id="s_phone_no"  class="ship_txt"/>
                    </dd>

				</dl>
				<dl style="float:left; width:50%; margin:40px 0 0">
					<dt style="font-size:18px; margin:0 0 20px">Bank Information</dt>
					<dd><label for="" class="label"><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "Full Name"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="bank_name" id="bank_name"  class="ship_txt"/>
					</dd>
					<dd><label for="" class="label"><?php if($this->lang->line('seller_acc_num') != '') { echo stripslashes($this->lang->line('seller_acc_num')); } else echo "Account Number"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="bank_no" id="bank_no"  class="ship_txt"/>
					</dd>
					<dd><label for="" class="label"><?php if($this->lang->line('seller_bank_code') != '') { echo stripslashes($this->lang->line('seller_bank_code')); } else echo "Bank Code"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="bank_code" id="bank_code"  class="ship_txt"/>
					</dd>
					<dd><label for="" class="label">Paypal Email</label>
						<input type="text" name="paypal_email" id="paypal_email"  class="ship_txt"/>
					</dd>
                </dl>
				<div class="btn-area" style="float:left; margin:10px 0 0 40px">
					<button class="start_btn_1" id="sign-up" re-url="/sales/create?ntid=7220865&amp;ntoid=15301425" ><?php if($this->lang->line('seller_comp_signup') != '') { echo stripslashes($this->lang->line('seller_comp_signup')); } else echo "Complete Sign Up"; ?></button>
				</div>
				</form>
			</section>
		
		</div>
		</div>
		</div>


	<!-- / container -->
</div>
<script type="text/javascript" src="js/site/jquery.validate.js"></script>
<script>
$("#seller_signup").validate({
/*		rules: {
			firstname: "required",
			lastname: "required",
			username: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			agree: "required"
		},
		messages: {
			firstname: "Please enter your firstname",
			lastname: "Please enter your lastname",
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: "Please enter a valid email address",
			agree: "Please accept our policy"
		}
*/	});

function validateSellerSignup(){
	var brand = $('#brand_name').val();
	var description = $('#brand_description').val();
	var addr = $('#s_address').val();
	var city = $('#s_city').val();
	var state = $('#s_state').val();
	var pincode = $('#s_postal_code').val();
	var country = $('#s_country').val();
	var phone = $('#s_phone_no').val();
	var bank_name = $('#bank_name').val();
	var bank_no = $('#bank_no').val();
	var bank_code = $('#bank_code').val();
	if(brand == ''){
		alert('Brand name required');
		$('#brand_name').focus();
		return false;
	}else if(description == ''){
		alert('Description required');
		$('#brand_description').focus();
		return false;
	}else if(addr == ''){
		alert('Adrress line 1 required');
		$('#s_address').focus();
		return false;
	}else if(city == ''){
		alert('City name required');
		$('#s_city').focus();
		return false;
	}else if(state == ''){
		alert('State name required');
		$('#s_state').focus();
		return false;
	}else if(pincode == ''){
		alert('Postal code required');
		$('#s_postal_code').focus();
		return false;
	}else if(country == ''){
		alert('Country name required');
		$('#s_country').focus();
		return false;
	}else if(phone == ''){
		alert('Phone number required');
		$('#s_phone_no').focus();
		return false;
	}else if(bank_name == ''){
		alert('Name in bank required');
		$('#bank_name').focus();
		return false;
	}else if(bank_no == ''){
		alert('Account number required');
		$('#bank_no').focus();
		return false;
	}else if(bank_code == ''){
		alert('Bank code required');
		$('#bank_code').focus();
		return false;
	}
}

</script>
<?php
$this->load->view('site/templates/footer');
?>