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
						echo form_open_multipart('admin/product/add_csv_product',$attributes) 
					?>
	 						<ul>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="image">Product File Path </label>
									<div class="form_input">
										<!--<input name="image" id="image" type="file" tabindex="7" class="large tipTop" title="Please select product image"/>-->
                                        <input name="file_path" style=" width:295px" id="file_path" value="" type="text" tabindex="1" class="required large tipTop" title="Please enter the full file path"/>
									</div>
								</div>
								</li>
								<input type="hidden" name="pid" value="0"/>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Crawl</span></button>
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