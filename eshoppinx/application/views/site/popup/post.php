<!-- Popup_post_start -->
<div style='display:none'>
  <div id='inline_example10' class="popup_page post_story_popup" style='background:#fff; display: block;'>  
  		<!--<div class="popup_page post_story_popup">           -->
            <ul>
                <li>
                    <a href="#" class="fancybox example19"><img src="images/site_new/post-pro-icon.png" alt=""></a>
                    <span>Post a Product</span>
                </li>
                <li>
                    <a href="stories/new"><img src="images/site_new/post-story-icon.png" alt=""></a>
                    <span>Post a Story</span>
                </li>
            </ul>
            
        
        <!--</div>-->
        
  </div>
  
</div>
<?php if($this->uri->segment(1) == 'things' || ($this->uri->segment(1) == 'user' && $this->uri->segment(3) == 'things')){ ?>
<div style='display:none'> 
<?php //echo $this->uri->segment(1); ?>
  <div id='report_popup' class="contact_frm" style='background:#fff;'>
  
  		<div class="popup_page">
        	<!--<a class="close_box cboxClose1" href="javascript:void(0);">x</a>-->
            <h2 style="font-size:24px; line-height:40px; color:#434343; margin:20px 0 20px 20px;">Why are you reporting this?</h2>
            <div style="float:left; width:90%; margin:0 0 7px 20px">
            	<input type="radio" name="name" id="name1" value="Not available" style="float:left; margin:3px 5px 0 0;" /><span style="float:left;">Not available</span>
            </div>
            <div style="float:left; width:90%; margin:0 0 7px 20px">
            	<input type="radio" name="name" id="name2" value="Bad image" style="float:left; margin:3px 5px 0 0;" /><span style="float:left;">Bad image</span>
            </div>
            <div style="float:left; width:90%; margin:0 0 7px 20px">
            	<input type="radio" name="name" id="name3" value="Incorrect price" style="float:left; margin:3px 5px 0 0;" /><span style="float:left;">Incorrect price</span>
            </div>
            <div style="float:left; width:90%; margin:0 0 7px 20px">
            	<span id="div_name" style="width: 100%;float: left;position: relative;bottom: 10px;color: red;"></span>
            </div>    
            <div style="display:inline-block; text-align:center; width:100%; margin:15px 0 0; font-size:14px; color:#434343">
            	<!--<a href="#" class="banner_join_btn blue-btn" style="background:#1197D4; padding:2px 8px; display:inline-block" onclick="javascript:product_report();">Report it</a>Thanks-->
                <input type="hidden" name="productid" id="productid" value="<?php echo $productDetails->row()->seller_product_id;?>">
            	<input type="hidden" name="sellerid" id="sellerid" value="<?php if($loginCheck != ''){echo $userDetails->row()->id;} ?>" />
                <button class="banner_join_btn blue-btn" style="background:#1197D4; padding:2px 8px; display:inline-block" onclick="javascript:product_report();" from_popup="true" >Report it</button>
                 <div id="loadingImgContact" style="display:none;"><img src="images/loading.gif" alt="Loading..." /></div>
             </div>   
  		</div>
        
  </div>
</div>
<?php } ?>

<div style='display:none'>
  <div id='inline_example14' class="popup_page post_story_step2_popup" style='background:#fff; display: block;'>  
        <ul>
            <li>
                <a class="example20" href="#"><div class="post_product_img"><img src="images/frm_web.png" /></div>  </a>
                <span><?php if($this->lang->line('templates_fromweb') != '') { echo stripslashes($this->lang->line('templates_fromweb')); } else echo "From Web"; ?></span>  
            </li>
            <li>
                <a class="example21" href="#"><div class="post_product_img"><img src="images/upload.png" /></div></a>
                    <span><?php if($this->lang->line('header_upload') != '') { echo stripslashes($this->lang->line('header_upload')); } else echo "Upload"; ?></span>
            </li>
            <li>
                <a href="mailto:<?php echo $this->config->item('email');?>"><div class="post_product_img"><img src="images/email.png" /></div></a>
                    <span><?php if($this->lang->line('referrals_email') != '') { echo stripslashes($this->lang->line('referrals_email')); } else echo "Email"; ?></span>
            </li>
        </ul>
        
  </div>  
</div>

<div style='display:none'>

  <div id='inline_example15' class="popup_page post-product" style='background:#fff; display: block;'>
        <div class="comment_area post_product">
            <h2>Post a Products</h2>
            <!--<form method="post" action="#">-->
                <div>
                    <input class="input1 signup_scroll_1 url_" type="text" placeholder="Product URL">
                    <input class="post" type="submit" onclick="fetch_images(this);" value="POST">
                    <a href="#" class="example19" ><?php if($this->lang->line('signup_goback') != '') { echo stripslashes($this->lang->line('signup_goback')); } else echo "Go Back"; ?></a>
                    <div class="clear"></div>
                </div>
            <!--</form>-->
        </div>
        
  </div>
  
</div>

<div style='display:none'>
  <div id='inline_example16' class="popup_page post-product" style='background:#fff; display: block;'>
  
        <div class="comment_area post_product">
            <h2><?php if($this->lang->line('templates_select_file') != '') { echo stripslashes($this->lang->line('templates_select_file')); } else echo "Select a file to upload"; ?></h2>
                <div>
                    <input type="file"  class="signup_scroll_1" id="upload_product_img"  />  
                    <div class="clear"></div>                         
                    <input class="post start_btn_1" type="submit" id="upload_product" onclick="javascript:upload_product(this);"  value="Upload">
                    <a href="#" class="example19" ><?php if($this->lang->line('signup_goback') != '') { echo stripslashes($this->lang->line('signup_goback')); } else echo "Go Back"; ?></a>
                    <div class="clear"></div>
                </div>
                <a class="example22" id="example22" href="#">&nbsp;</a>
        </div>
        
  </div>
  
</div>

<div style='display:none'>
  <div id='inline_example17' style='background:#fff;'>  
  		<div class="popup_page">        
        	
            <div class="post_product story_submit" style="border-right:none; padding:0px 0px 15px 0px">
                                <dl>
                            <dt><?php if($this->lang->line('header_prod_details') != '') { echo stripslashes($this->lang->line('header_prod_details')); } else echo "Product Details"; ?> <small><?php if($this->lang->line('header_change_later') != '') { echo stripslashes($this->lang->line('header_change_later')); } else echo "(Can be changed later)"; ?></small></dt>
                            <dd>
                                <div class="img" style="width: 180px;">
                                    <div class="photo-wrap" style="width: 180px;"><img class="photo" style="width:175px" src=""></div>
                                    <span class="controls" style="display: block;">
                                        <button class="prev" style="width: 40px;" onclick="set_prev();"><i></i><span class="hidden"><?php if($this->lang->line('header_prev') != '') { echo stripslashes($this->lang->line('header_prev')); } else echo "Prev"; ?></span></button>
                                        <button class="next" style="width: 40px;" onclick="set_next();"><i></i><span class="hidden"><?php if($this->lang->line('header_next') != '') { echo stripslashes($this->lang->line('header_next')); } else echo "Next"; ?></span></button>
                                        <span class="cur_">1 of 10</span>
                                    </span>
                                    <span class="size" style="width: 100%;">210 &times; 92</span>
                                </div>
                                <div class="frm" style="width: 257px;">
                                    <input type="hidden" value="" id="add_photo_url" style="width: 245px;">
                                    <label><?php if($this->lang->line('header_title') != '') { echo stripslashes($this->lang->line('header_title')); } else echo "Title"; ?></label>
                                    <input type="text" class="input-text" id="add_name" style="width: 245px;">
                                    <label><?php if($this->lang->line('header_weblink') != '') { echo stripslashes($this->lang->line('header_weblink')); } else echo "Web Link"; ?></label>
                                    <input type="text" class="input-text" placeholder="http://" id="add_link" style="width: 245px;">
                                    <label><?php if($this->lang->line('header_price') != '') { echo stripslashes($this->lang->line('header_price')); } else echo "Price"; ?></label>
                                    <input type="text" class="input-text" placeholder="" id="add_price" style="width: 245px;">
                                    
                                    <label><?php if($this->lang->line('lg_affiliate_code') != '') { echo stripslashes($this->lang->line('lg_affiliate_code')); } else echo "Affiliate Code"; ?></label>
                                    <input type="text" class="input-text" placeholder="<?php if($this->lang->line('lg_example') != '') { echo stripslashes($this->lang->line('lg_example')); } else echo "Example"; ?>: affid=xxx" id="add_affiliate_code" style="width: 235px;">
                                    <span style="color: #92959C;display: block;font-size: 12px;line-height: 18px;padding: 0px 0 3px;bottom: 5px;position: relative;"><?php if($this->lang->line('lg_note_affiliate') != '') { echo stripslashes($this->lang->line('lg_note_affiliate')); } else echo "Note: need to enter the affiliate id and your attribute type"; ?></span>
                                    
                                    <label><?php if($this->lang->line('lg_affiliate_script') != '') { echo stripslashes($this->lang->line('lg_affiliate_script')); } else echo "Affiliate Script"; ?></label>
                                    <textarea class="input-text" placeholder="<?php if($this->lang->line('lg_example') != '') { echo stripslashes($this->lang->line('lg_example')); } else echo "Example"; ?>: <script>xxx</script>" id="add_affiliate_script" style="width: 235px;border: 1px solid #BBBBBB;border-radius: 3px;padding: 7px;"></textarea>
                                    
									<?php if ($mainCategories->num_rows()>0){?>
                                    <label><?php if($this->lang->line('header_category') != '') { echo stripslashes($this->lang->line('header_category')); } else echo "Category"; ?></label>
                                        <select class="select-round selectBox categories_" id="add_category" style="width: 245px;">
                                        <option value=""><?php if($this->lang->line('header_choose_categry') != '') { echo stripslashes($this->lang->line('header_choose_categry')); } else echo "Choose a category"; ?></option>
                                        <?php 
					                      foreach ($mainCategories->result() as $row){
					                      	if ($row->cat_name != ''){
					                      ?>
                                                                <option value="<?php echo $row->id;?>"><?php echo $row->cat_name;?></option>
                                          <?php 
					                      	}
					                      }
                                          ?>                      
										</select>
                                     <?php }?>                           
                                      </div>
                                <textarea id="add_note" style="width: 99%;" maxlength="200" placeholder="<?php if($this->lang->line('header_sam_somethng') != '') { echo stripslashes($this->lang->line('header_sam_somethng')); } else echo "Say something about this"; ?>"></textarea>
                            </dd>
                        </dl>
                        <?php  
						if ($loginCheck != ''){
						echo '<input type="hidden" id="UserType" name="UserType" value="'.$userDetails->row()->group.'" />';
						
						}
						
						
						
						 ?>
                        <div class="btns-area">
                            <button class="start_btn_1" onclick="add_product_user(this);"><?php if($this->lang->line('header_add_to') != '') { echo stripslashes($this->lang->line('header_add_to')); } else echo "Add to"; ?> <?php echo $siteTitle;?></button>
                            <a href="#" class="example19" style="float:right; margin:20px 20px 0;"><?php if($this->lang->line('signup_goback') != '') { echo stripslashes($this->lang->line('signup_goback')); } else echo "Go Back"; ?></a>
                        </div>
                        
            </div>  
        </div>
  </div>  
</div>
<!-- Popup_post_end -->