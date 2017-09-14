<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Store Details</h6>
						<div id="widget_tab">
			              <ul>
			                <li><a href="#tab1" class="active_tab">Store Details</a></li>
			              </ul>
			            </div>
					</div>
					<div class="widget_content">
					<?php 
						//$attributes = array('class' => 'form_container left_label');
						//echo form_open('admin',$attributes) 
						
						$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/seller/insertEditSeller',$attributes)
					?>
					<div id="tab1">
	 						<ul>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Store Name</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->store_name; ?>
                                        <input type="text" name="store_name" value="<?php echo $storeDetails->row()->store_name;?>" class="tipTop large" title="Enter the store name" />
									</div>
								</div>
								</li>
                                <?php if($this->data['storeDetails']->row()->user_id>0) { ?>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Description</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->description; ?>
                                        <input type="text" name="description" value="<?php echo $storeDetails->row()->description;?>" class="tipTop large" title="Enter the description" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Address</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->address; ?>
                                        <input type="text" name="address" value="<?php echo $storeDetails->row()->address;?>" class="tipTop large" title="Enter the address" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">City</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->city; ?>
                                        <input type="text" name="city" value="<?php echo $storeDetails->row()->city;?>" class="tipTop large" title="Enter the city" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">State</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->state;?>
                                        <input type="text" name="state" value="<?php echo $storeDetails->row()->state;?>" class="tipTop large" title="Enter the state" />
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Country</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->country;?>
                                        <input type="text" name="country" value="<?php echo $storeDetails->row()->country;?>" class="tipTop large" title="Enter the country" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Postal Code</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->postal_code;?>
                                        <input type="text" name="postal_code" value="<?php echo $storeDetails->row()->postal_code;?>" class="tipTop large" title="Enter the postal code" />
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Phone Number</label>
									<div class="form_input">
										<?php //echo $storeDetails->row()->phone_no;?>
                                        <input type="text" name="phone_no" value="<?php echo $storeDetails->row()->phone_no;?>" class="tipTop large" title="Enter the phone number" />
									</div>
								</div>
								</li> 
                                <?php } ?>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Store Logo</label>
									<div class="form_input">
                                        <input name="store_logo" id="store_logo" type="file" tabindex="7" class="large tipTop" title="Please select store image" />
									</div>
                                    <?php if($storeDetails->row()->store_logo!='') { ?>
	                                    <div class="form_input"><img src="<?php echo base_url();?>images/store/<?php echo $storeDetails->row()->store_logo;?>" width="100px"/></div>
                                    <?php } ?>    
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						<input type="hidden" name="seller_id" value="<?php echo $storeDetails->row()->id;?>"/>
                        <input type="hidden" name="store_id" value="<?php echo $storeDetails->row()->store_id;?>"/>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>