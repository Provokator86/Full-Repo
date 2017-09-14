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
						echo form_open_multipart('admin/product/edit_affiliate_product',$attributes) 
					?>
	 						<ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="product_name">Product Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="product_name" style=" width:295px" id="product_name" value="<?php echo $product_details->row()->product_name;?>" type="text" tabindex="1" class="required large tipTop" title="Please enter the product name"/>
									</div>
								</div>
								</li>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="web_link">Website <span class="req">*</span></label>
									<div class="form_input">
										<input name="web_link" style=" width:295px" id="web_link" value="<?php echo $product_details->row()->web_link;?>" type="text" tabindex="1" class="required large tipTop" title="Please enter the website"/>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="image">Product Image </label>
									<div class="form_input">
										<input name="image" id="image" type="file" tabindex="7" class="large tipTop" title="Please select product image"/>
									</div>
									<div class="form_input"><img src="<?php echo base_url();?>images/product/<?php echo $product_details->row()->image;?>" style="max-width:200px;"/></div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="price">Price <span class="req">*</span></label>
									<div class="form_input">
										<input name="price" id="price" type="text" value="<?php echo $product_details->row()->price;?>" tabindex="2" class="required number large tipTop" title="Please enter the product price"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" ><?php if($this->lang->line('lg_affiliate_code') != '') { echo stripslashes($this->lang->line('lg_affiliate_code')); } else echo "Affiliate Code"; ?></label>
									<div class="form_input">
		                            	<input type="text" class="large" placeholder="<?php if($this->lang->line('lg_example') != '') { echo stripslashes($this->lang->line('lg_example')); } else echo "Example"; ?>: aid=xxx" id="edit_affiliate_code" name="affiliate_code" style="" value="<?php echo str_replace('"', "'", $product_details->row()->affiliate_code);?>">
		                            	<span style="color: #92959C;display: block;font-size: 12px;line-height: 18px;padding: 0px 0 3px;"><?php if($this->lang->line('lg_note_affiliate') != '') { echo stripslashes($this->lang->line('lg_note_affiliate')); } else echo "Note: need to enter the affiliate id and your attribute type"; ?></span>
		                            </div>
		                        </div>    
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" ><?php if($this->lang->line('lg_affiliate_script') != '') { echo stripslashes($this->lang->line('lg_affiliate_script')); } else echo "Affiliate Script"; ?></label>
									<div class="form_input">
			                            <textarea class="large" placeholder="<?php if($this->lang->line('lg_example') != '') { echo stripslashes($this->lang->line('lg_example')); } else echo "Example"; ?>: <script>xxx</script>" id="edit_affiliate_script" name="affiliate_script" style="width:50%;border: 1px solid #BBBBBB;border-radius: 3px;padding: 7px;"><?php echo str_replace('"', "'", $product_details->row()->affiliate_script);?></textarea>
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
													<option <?php if ($maincat_row->id==$product_details->row()->category_id){?>selected="selected"<?php }?> value="<?php echo $maincat_row->id;?>"><?php echo $maincat_row->cat_name;?></option>
											<?php 		
												}
											}
											?>
										</select>
									</div>
								</div>
								</li>
								<input type="hidden" name="pid" value="<?php echo $product_details->row()->seller_product_id;?>"/>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
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