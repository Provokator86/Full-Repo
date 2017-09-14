<?php 
if(isset($countryList) && $this->uri->segment(2) == 'shipping' || isset($countryList) && $this->uri->segment(1) == 'cart'){
if($this->uri->segment(1) == 'cart'){
	$acURL = 'site/cart/insert_shipping_address';
}else{
	$acURL = 'site/user_settings/insertEdit_shipping_address';
}
?>
    <div style='display:none'>

  <div id='addshippingaddress' style='background:#fff; padding:0 10px;'>
  
  		<div class="popup_page">
        
        	<!--<a class="close_box" href="<?php if($this->uri->segment(1) == 'cart'){	echo base_url().'cart';}else{	echo base_url().'settings/shipping';}?>">x</a>-->  
    
		<form class="ltxt" method="post" id="shippingAddForm" action="<?php echo $acURL;?>">
			<dl>
				<dt><b style="float:left; width:100%;"><?php if($this->lang->line('header_new_ship') != '') { echo stripslashes($this->lang->line('header_new_ship')); } else echo "New Shipping Address"; ?></b>
				<small style="float:left; width:100%;"><?php echo ucfirst($siteTitle);?> <?php if($this->lang->line('header_ships_wide') != '') { echo stripslashes($this->lang->line('header_ships_wide')); } else echo "ships worldwide with global delivery services"; ?>.</small></dt>
				<dd class="left" style="width:50%; margin:0">
					<p><label><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "Full Name"; ?></label>
					<input name="full_name" class="full required ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('shipping_nickname') != '') { echo stripslashes($this->lang->line('shipping_nickname')); } else echo "Nickname"; ?></label>
					<input name="nick_name" class="full required ship_txt" placeholder="<?php if($this->lang->line('header_home_work') != '') { echo stripslashes($this->lang->line('header_home_work')); } else echo "E.g. Home, Work, Aunt Jane"; ?>" type="text"></p>
					<p><label><?php if($this->lang->line('header_country') != '') { echo stripslashes($this->lang->line('header_country')); } else echo "Country"; ?></label>
					<select name="country" class="full required">
						<?php 
						if ($countryList->num_rows()>0){
							foreach ($countryList->result() as $country){
						?>
						<option value="<?php echo $country->country_code;?>"><?php echo $country->name;?></option>
						<?php 
							}
						}
						?>
					</select></p>
					<p><label><?php if($this->lang->line('header_state_province') != '') { echo stripslashes($this->lang->line('header_state_province')); } else echo "State / Province"; ?></label>
					<input class="state required ship_txt" name="state" type="text"></p>
					<p><label><?php if($this->lang->line('header_zip_postal') != '') { echo stripslashes($this->lang->line('header_zip_postal')); } else echo "Zip / Postal Code"; ?></label>
					<input name="postal_code" class="zip required ship_txt" type="text"></p>
					<p style="float:left; width:230px"><input name="set_default" id="make_this_primary_addr ship_txt" value="true" type="checkbox" style="float:left">
					<label style="float:left; font-size:11px; width:auto" class="check" for="make_this_primary_addr"><?php if($this->lang->line('header_make_primary') != '') { echo stripslashes($this->lang->line('header_make_primary')); } else echo "Make this my primary shipping address"; ?></label></p>
				</dd>
				<dd class="right" style="width:50%; margin:0">
					<p><label><?php if($this->lang->line('header_addrs_one') != '') { echo stripslashes($this->lang->line('header_addrs_one')); } else echo "Address Line 1"; ?></label>
					<input name="address1" class="full required ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('header_addrs_two') != '') { echo stripslashes($this->lang->line('header_addrs_two')); } else echo "Address Line 2"; ?></label>
					<input name="address2" class="full ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('header_city') != '') { echo stripslashes($this->lang->line('header_city')); } else echo "City"; ?></label>
					<input name="city" class="full required ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('header_telephone') != '') { echo stripslashes($this->lang->line('header_telephone')); } else echo "Telephone"; ?></label>
					<input name="phone" class="full required digits ship_txt" placeholder="<?php if($this->lang->line('header_ten_only') != '') { echo stripslashes($this->lang->line('header_ten_only')); } else echo "10 digits only, no dashes"; ?>" type="text"></p>
				</dd>
			</dl>
			<div class="btns-area">
				<button type="submit" class="start_btn_3"><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></button>
				<button type="reset" class="start_btn_3"><?php if($this->lang->line('header_cancel') != '') { echo stripslashes($this->lang->line('header_cancel')); } else echo "Cancel"; ?></button>
			</div>
			<input type="hidden" name="user_id" value="<?php echo $loginCheck;?>"/>
		</form>
		</div></div>
        
      <div id='editshippingaddress' style='background:#fff;padding-left: 20px;padding-left: 20px;'>
  <div class="popup_page">
  <!--<a class="close_box" href="<?php if($this->uri->segment(1) == 'cart'){	echo base_url().'cart';}else{	echo base_url().'settings/shipping';}?>">x</a> -->
 <form class="ltxt" method="post" id="shippingEditForm" action="site/user_settings/insertEdit_shipping_address">
			<dl>
				<dt><b style="float:left; width:100%;"><?php if($this->lang->line('header_edit_curship') != '') { echo stripslashes($this->lang->line('header_edit_curship')); } else echo "Edit your current shipping address"; ?></b>
				<small style="float:left; width:100%;"><?php echo ucfirst($siteTitle);?> <?php if($this->lang->line('header_ships_wide') != '') { echo stripslashes($this->lang->line('header_ships_wide')); } else echo "ships worldwide with global delivery services"; ?>.</small></dt>
				<dd class="left" style="width:50%; margin:0">
					<p><label><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "Full Name"; ?></label>
					<input name="full_name" class="full required full_name ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('shipping_nickname') != '') { echo stripslashes($this->lang->line('shipping_nickname')); } else echo "Nickname"; ?></label>
					<input name="nick_name" class="full required nick_name ship_txt" placeholder="<?php if($this->lang->line('header_home_work') != '') { echo stripslashes($this->lang->line('header_home_work')); } else echo "E.g. Home, Work, Aunt Jane"; ?>" type="text"></p>
					<p><label><?php if($this->lang->line('header_country') != '') { echo stripslashes($this->lang->line('header_country')); } else echo "Country"; ?></label>
					<select name="country" class="full required country">
						<?php 
						if ($countryList->num_rows()>0){
							foreach ($countryList->result() as $country){
						?>
						<option value="<?php echo $country->country_code;?>"><?php echo $country->name;?></option>
						<?php 
							}
						}
						?>
					</select></p>
					<p><label><?php if($this->lang->line('header_state_province') != '') { echo stripslashes($this->lang->line('header_state_province')); } else echo "State / Province"; ?></label>
					<input class="state required ship_txt" name="state" type="text"></p>
					<p><label><?php if($this->lang->line('header_zip_postal') != '') { echo stripslashes($this->lang->line('header_zip_postal')); } else echo "Zip / Postal Code"; ?></label>
					<input name="postal_code" class="zip required postal_code ship_txt" type="text"></p>
					<p style="float:left; width:230px">
<input id="make_this_primary_addr ship_txt" type="checkbox" style="float:left" value="true" name="set_default">
<label class="check" for="make_this_primary_addr" style="float:left; font-size:11px; width:auto"><?php if($this->lang->line('header_make_primary') != '') { echo stripslashes($this->lang->line('header_make_primary')); } else echo "Make this my primary shipping address"; ?></label>
</p>
				</dd>
				<dd class="right" style="width:50%; margin:0">
					<p><label><?php if($this->lang->line('header_addrs_one') != '') { echo stripslashes($this->lang->line('header_addrs_one')); } else echo "Address Line 1"; ?></label>
					<input name="address1" class="full required address1 ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('header_addrs_two') != '') { echo stripslashes($this->lang->line('header_addrs_two')); } else echo "Address Line 2"; ?></label>
					<input name="address2" class="full address2 ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('header_city') != '') { echo stripslashes($this->lang->line('header_city')); } else echo "City"; ?></label>
					<input name="city" class="full required city ship_txt" type="text"></p>
					<p><label><?php if($this->lang->line('header_telephone') != '') { echo stripslashes($this->lang->line('header_telephone')); } else echo "Telephone"; ?></label>
					<input name="phone" class="full required digits phone ship_txt" placeholder="<?php if($this->lang->line('header_ten_only') != '') { echo stripslashes($this->lang->line('header_ten_only')); } else echo "10 digits only, no dashes"; ?>" type="text"></p>
				</dd>
			</dl>
			<div class="btns-area">
				<button type="submit" class="start_btn_3"><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></button>
				<button type="reset" class="start_btn_3"><?php if($this->lang->line('header_cancel') != '') { echo stripslashes($this->lang->line('header_cancel')); } else echo "Cancel"; ?></button>
			</div>
			<input type="hidden" name="user_id" value="<?php echo $loginCheck;?>"/>
			<input type="hidden" class="ship_id" name="ship_id" value="0"/>
		</form>
        </div>
        </div>   
        
        </div>
	
 <?php }?> 