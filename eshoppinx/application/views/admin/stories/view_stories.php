<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Stories</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin',$attributes) 
					?>
	 						<ul>
                            	<li>
								<div class="form_grid_12">
									<label class="field_title" for="location_name">User Name <span class="req">*</span></label>
									<div class="form_input">
                                    <?php if($stories_details->row()->user_id=='' || $stories_details->row()->user_id=='0'){echo 'Admin';}else{ echo $stories_details->row()->user_name;}?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title"  for="currency_symbol">Product Name<span class="req">*</span></label>
									<div class="form_input">
                                    <table style="padding:3px; border:solid #666666 1px; min-width:300px;">
                                    <?php 
									
									if($ProductDetails->num_rows() > 0){
									foreach($ProductDetails as $ProductDetailsRow){
									$imgdisplay=explode(',',$ProductDetailsRow->image);
									$ImgSig=base_url().'images/product/'.$imgdisplay[0];
									
									echo '<tr><td style="padding:3px; border:solid #666666 1px"><img src="'.$ImgSig.'" width="50px"/></td><td  style="padding:3px; border:solid #666666 1px">'.$ProductDetailsRow->product_name.'</td></tr>';
									
									
									}}else{
									echo 'No Product Found';
									}
									?>
                                    </table>
									</div>
								</div>
								</li><li>
								<div class="form_grid_12">
									<label class="field_title" for="currency_symbol">Description<span class="req">*</span></label>
									<div class="form_input">
                                    <?php echo $stories_details->row()->description;?>
									</div>
								</div>
								</li>
                                
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/stories/display_stories_list" class="tipLeft" title="Go to Stories list"><span class="badge_style b_done">Back</span></a>
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
<?php 
$this->load->view('admin/templates/footer.php');
?>