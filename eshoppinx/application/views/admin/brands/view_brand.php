<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Brand</h6>
						<div id="widget_tab">
			              <ul>
			                <li><a href="#tab1" class="active_tab">Brand Details</a></li>
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
									<label class="field_title" for="admin_name">Brand Name</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->brand_name; ?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Store Url</label>
									<div class="form_input">
										<?php echo $storeDetails->row()->brand_url; ?>
									</div>
								</div>
								</li>
                                <?php /*if($this->data['storeDetails']->row()->user_id>0) { ?>
                                    <li>
                                    <div class="form_grid_12">
                                        <label class="field_title" for="admin_name">User Name</label>
                                        <div class="form_input">
                                            <?php echo $getuserDetails->row()->user_name; ?>
                                        </div>
                                    </div>
                                    </li>
                                <?php }*/ ?>
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
                                <?php /*if($this->data['storeDetails']->row()->user_id>0) { ?>
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
                                <?php }*/ ?>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Brand Logo</label>
									<div class="form_input">
                                    <?php if($storeDetails->row()->brand_logo!='') { ?>
										<img src="./images/brand/<?php echo $storeDetails->row()->brand_logo;?>" style="width:80px; height:80px;">
                                    <?php } else { ?>    
                                    	<img src="./images/store/dummy_store_logo.png" style="width:80px; height:80px;">
                                    <?php } ?>
									</div>
								</div>
								</li>
                                <?php /*if($this->data['storeDetails']->row()->user_id>0) { ?>
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
                                <?php }*/ ?>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/brands/display_brand_list"><span class="badge_style b_done">Back</span></a>
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