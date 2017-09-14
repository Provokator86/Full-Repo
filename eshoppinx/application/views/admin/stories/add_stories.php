<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Stories</h6>
                        <div id="widget_tab">
              				<ul>
               					 <li><a href="#tab1" class="active_tab">Content</a></li>
               					 <!--<li><a href="#tab2">SEO</a></li>-->
             				 </ul>
            			</div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm');
						echo form_open('admin/stories/insertEditStories',$attributes) 
					?> 		
                    	<div id="tab1">
	 						<ul>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Description<span class="req">*</span></label>
									<div class="form_input">
                                    <input name="description" style=" width:295px" id="description" value="" type="text" tabindex="1" class="required tipTop" title="Please enter the description"/>
									</div>
								</div>
								</li>
                                <li>
                               
								<div class="form_grid_12">
									<label class="field_title" for="iso_code2">Select Product</label>
									<div class="form_input">
                                    <table style="padding:3px; border:solid #666666 1px; min-width:300px;">
                                     <?php if($added_product->num_rows() > 0){
									 	foreach($added_product->result() as $AddedProduct ){
										
										
										$imgdisplay=explode(',',$AddedProduct->image);
										$ImgSig=base_url().'images/product/'.$imgdisplay[0];
									 echo '<tr><td style="padding:3px; border:solid #666666 1px"><input name="seller_product_id[]" type="checkbox" value="'.$AddedProduct->seller_product_id.'" /></td><td style="padding:3px; border:solid #666666 1px"><img src="'.$ImgSig.'" width="50px"/></td><td  style="padding:3px; border:solid #666666 1px">'.$AddedProduct->product_name.'</td></tr>';
									 ?>
                                    		
									<?php }}else{echo 'No Product Added';} ?>
                                    </table>
									</div>
								</div>
								</li>
								<input type="hidden" name="stories_id" value=""/>
                                <input type="hidden" name="user_id" value="0"/>
                                <input type="hidden" name="status" value="1"/>
                                <input type="hidden" name="dateAdded" value="<?php echo $dateval = date('Y-m-d H:i:s'); ?>"/>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
									</div>
								</div>
								</li>
							</ul>
                        </div>
                        <!--<div id="tab2">
              <ul>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_title">Meta Title</label>
                    <div class="form_input">
                      <input name="meta_title" id="meta_title" type="text" tabindex="1" class="large tipTop" title="Please enter the page meta title"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_tag">Meta Keyword</label>
                    <div class="form_input">
                      <textarea name="meta_keyword" id="meta_keyword"  tabindex="2" class="large tipTop" title="Please enter the page meta keyword"></textarea>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_description">Meta Description</label>
                    <div class="form_input">
                      <textarea name="meta_description" id="meta_description" tabindex="3" class="large tipTop" title="Please enter the meta description"></textarea>
                    </div>
                  </div>
                </li>
              </ul>
             <ul><li><div class="form_grid_12">
				<div class="form_input">
					<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
				</div>
			</div></li></ul>
			</div>-->
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