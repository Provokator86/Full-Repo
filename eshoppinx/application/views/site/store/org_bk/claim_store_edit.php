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
		
			<section class="merchant">
			<form action="site/store/claim_edit_function" method="post" id="seller_signup" onsubmit="return validateSellerSignup();" enctype="multipart/form-data">
				
				<!--<dl style="float:left; width:100%; margin:40px 0 0">
                    ryrtuyh
				</dl>-->
                <dt style="font-size:18px; margin:30px 0 20px"><?php  echo "Claim" ?> <a href="<?php echo prep_url($shopsDetails->row()->store_url); ?>" target="_blank"><?php echo $shopsDetails->row()->store_url; ?></a></dt>
                <!--<dd><label for="" class="label"><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "Full Name"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="full_name" value="<?php echo $userDetails->row()->full_name;?>" id="full_name"  class="ship_txt"/>
				</dd>-->
                <dd><label for="" class="label"><?php if($this->lang->line('seller_brand') != '') { echo stripslashes($this->lang->line('seller_brand')); } else echo "Brand"; ?><sup style="color: red;">*</sup></label>
                        <input type="text" name="store_name" id="brand_name" class="ship_txt" value="<?php echo $claimDetails->row()->store_name; ?>" />
                    </dd>
                    <dd><label for="" class="label"><?php if($this->lang->line('header_description') != '') { echo stripslashes($this->lang->line('header_description')); } else echo "Description"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="description" id="brand_description" class="ship_txt" value="<?php echo $claimDetails->row()->description; ?>"/>
					</dd>
					<dd><label for="" class="label"><?php if($this->lang->line('header_addrs_one') != '') { echo stripslashes($this->lang->line('header_addrs_one')); } else echo "Address Line 1"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="address" id="s_address" class="ship_txt" value="<?php echo $claimDetails->row()->address; ?>"/>
                    </dd>
                    <dd><label for="" class="label"><?php if($this->lang->line('header_city') != '') { echo stripslashes($this->lang->line('header_city')); } else echo "City"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="city" id="s_city" class="ship_txt" value="<?php echo $claimDetails->row()->city; ?>"/>
                    </dd>
                    <dd><label for="" class="label"><?php if($this->lang->line('checkout_state') != '') { echo stripslashes($this->lang->line('checkout_state')); } else echo "State"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="state" id="s_state" class="ship_txt" value="<?php echo $claimDetails->row()->state; ?>"/>
                    </dd>
					<dd><label for="" class="label"><?php if($this->lang->line('seller_postal_code') != '') { echo stripslashes($this->lang->line('seller_postal_code')); } else echo "Postal Code"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="postal_code" id="s_postal_code" class="ship_txt" value="<?php echo $claimDetails->row()->postal_code; ?>"/>
					</dd>
                    <dd>
						<label class="label"><?php if($this->lang->line('header_country') != '') { echo stripslashes($this->lang->line('header_country')); } else echo "Country"; ?><sup style="color: red;">*</sup></label>
						<?php 
						if(isset($countryList) && $countryList->num_rows()>0){
						?>
						<select name="country" class="select-white select-country" id="s_country">
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
						<input type="text" name="country" id="s_country" class="ship_txt" value="<?php echo $claimDetails->row()->country; ?>"/>
						<?php }?>
					</dd>

					
					<dd><label for="" class="label"><?php if($this->lang->line('checkout_phone_no') != '') { echo stripslashes($this->lang->line('checkout_phone_no')); } else echo "Phone Number"; ?><sup style="color: red;">*</sup></label>
						<input type="text" name="phone_no" id="s_phone_no"  class="ship_txt" value="<?php echo $claimDetails->row()->phone_no; ?>"/>
                    </dd>
                    <dd><label for="" class="label"><?php echo "Logo"; ?></label>
						<input type="file" name="store_logo" id="store_logo" class="ship_txt"/>&nbsp;
                        <?php if($shopsDetails->row()->store_logo!='') { ?>
	                        <img src="<?php echo base_url();?>images/store/<?php echo $shopsDetails->row()->store_logo;?>" width="100px"/>
                        <?php } ?>    
                    </dd>
				<div class="btn-area" style="float:left; margin:10px 0 10px 40px">
					<button class="start_btn_1" id="sign-up" ><?php if($this->lang->line('templates_submit') != '') { echo stripslashes($this->lang->line('templates_submit')); } else echo "Submit"; ?></button>
				</div>
                <?php 
					$store_id = $this->uri->segment(4,0);
				?>
                <input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id; ?>">
				</form>
			</section>
		
		</div>
		</div>
		</div>


	<!-- / container -->
</div>
<script>

function validateSellerSignup(){
	var full_name = $('#full_name').val();
	var brand = $('#brand_name').val();
	var description = $('#brand_description').val();
	var addr = $('#s_address').val();
	var city = $('#s_city').val();
	var state = $('#s_state').val();
	var pincode = $('#s_postal_code').val();
	var country = $('#s_country').val();
	var phone = $('#s_phone_no').val();
	var docume = $('#documentation').val();
	if(full_name == ''){
		alert('Full name required');
		$('#full_name').focus();
		return false;
	}else if(brand == ''){
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
	}else if(docume == ''){
		alert('Please upload a document');
		return false;
	}
}

</script>
<?php
$this->load->view('site/templates/footer');
?>