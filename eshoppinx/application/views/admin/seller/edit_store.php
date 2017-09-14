<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Store</h6>
						<div id="widget_tab">
			              <ul>
			                <li><a href="#tab1" class="active_tab">Store Details</a></li>
			              </ul>
			            </div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin',$attributes) 
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
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Store Url</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->store_url; ?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">User Name</label>
									<div class="form_input">
										<?php echo $getuserDetails->row()->user_name; ?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Products Count</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->products_count;?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Followers Count</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->followers_count;?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Description</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->description; ?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Address</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->address; ?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">City</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->city; ?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">State</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->state;?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Country</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->country;?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Postal Code</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->postal_code;?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Phone Number</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->phone_no;?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Document</label>
									<div class="form_input">
										<a href="<?php echo base_url();?>store/<?php echo $storeDetails->row()->document;?>"><?php echo $storeDetails->row()->document;?></a>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->status;?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/seller/display_seller_list"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
								</li>
							</ul>
						</div>
						
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