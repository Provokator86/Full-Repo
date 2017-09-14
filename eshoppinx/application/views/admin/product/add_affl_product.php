<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading;?></h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'edit_affliate_form', 'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/product/add_affiliate_product',$attributes) 
					?>
	 						<ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="product_name">Product Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="product_name" style=" width:295px" id="product_name" value="" type="text" tabindex="1" class="required large tipTop" title="Please enter the product name"/>
									</div>
								</div>
								</li>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="web_link">Website <span class="req">*</span></label>
									<div class="form_input">
										<input name="web_link" style=" width:295px" id="web_link" value="" type="text" tabindex="1" class="required large tipTop" title="Please enter the website"/>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="image">Product Image </label>
									<div class="form_input">
										<input name="image" id="image" type="file" tabindex="7" class="large tipTop" title="Please select product image"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="price">Price <span class="req">*</span></label>
									<div class="form_input">
										<input name="price" id="price" type="text" value="" tabindex="2" class="required number large tipTop" title="Please enter the product price"/>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="category_id">Category <span class="req">*</span></label>
									<div class="form_input">
										<select name="category_id" id="category_id" class="required large tipTop" title="Please select the category" style="width: 51%;">
											<option value="">Choose Category</option>
											<?php 
											if ($mainCategories != '' && count($mainCategories)>0 && $mainCategories->num_rows()>0){
												foreach ($mainCategories->result() as $maincat_row){
											?>		
													<option value="<?php echo $maincat_row->id;?>"><?php echo $maincat_row->cat_name;?></option>
											<?php 		
												}
											}
											?>
										</select>
									</div>
								</div>
								</li>
								<input type="hidden" name="pid" value="0"/>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Add</span></button>
									</div>
								</div>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script type="text/javascript">
<!--
$('#edit_affliate_form').validate();
//-->
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>