<?php 
$this->load->view('site/templates/header.php');
?>
	<section>
        	<div class="section_main">
            	<div class="main2">          
                <div class="container set_area" style="padding:30px 0 20px">
			<div id="content" style="float:left; width:100%">
				<div class="figure-row first" style="float:left; width:67%;">
					<div class="figure-product figure-640 big">
						
						<figure>
							<span class="wrapper-fig-image">
								<span class="fig-image"><img src="images/giftcards/<?php echo $this->config->item('giftcard_image'); ?>" alt="<?php echo $this->config->item('giftcard_title'); ?>" height="640" width="640"></span>
							</span>
                            
                            <figcaption><?php echo $this->config->item('giftcard_title'); ?></figcaption>
						    
                        </figure>
						
						<br class="hidden">
<!-- 						
						<p>by <a href="#" class="username">jack</a> + 117325 others</p>
						

						<br class="hidden">
						
                            <a href="#" class="button fancyd" rtid="1200377743085076480" tid="191021139391156225"><span><i></i></span><?php echo LIKED_BUTTON;?></a>
						
 -->
					</div>
					<!-- / figure-product figure-640 -->
                    <div class="might-fancy" style="display:inline-block; width:100%; text-align:center">
					<h3><?php if($this->lang->line('giftcard_you_might') != '') { echo stripslashes($this->lang->line('giftcard_you_might')); } else echo "You might also "; ?><?php echo LIKE_BUTTON;?>...</h3>
					<div style="height: 259px;" class="figure-row fancy-suggestions anim">
					<?php 
					$limitCount = 0;
					foreach ($relatedProductsArr as $relatedRow){
						if ($limitCount<3){
							$limitCount++;
						$img = 'dummyProductImage.jpg';
						$imgArr = explode(',', $relatedRow->image);
						if (count($imgArr)>0){
							foreach ($imgArr as $imgRow){
								if ($imgRow != ''){
									$img = $imgRow;
									break;
								}
							}
						}
						$fancyClass = 'fancy';
						$fancyText = LIKE_BUTTON;
						if (count($likedProducts)>0 && $likedProducts->num_rows()>0){
							foreach ($likedProducts->result() as $likeProRow){
								if ($likeProRow->product_id == $relatedRow->seller_product_id){
									$fancyClass = 'fancyd';$fancyText = LIKED_BUTTON;break;
								}
							}
						}
					?>
							<div class="figure-product figure-200" style="float:left; width:280px;">
								<a href="<?php echo base_url();?>things/<?php echo $relatedRow->id;?>/<?php echo url_title($relatedRow->product_name,'-');?>">
								<figure>
								<span class="wrapper-fig-image">
									<span class="fig-image">
										<img style="width: 200px; height: 200px;" src="<?php echo base_url();?>images/product/<?php echo $img;?>">
									</span>
								</span>
								<figcaption><?php echo $relatedRow->product_name;?></figcaption>
								</figure>
								</a>
								<br class="hidden">
								<span class="username"><a href="<?php if ($relatedRow->user_id != '0'){echo 'user/'.$relatedRow->user_name;}else {echo 'user/administrator';}?>"><?php if ($relatedRow->user_id != '0'){echo $relatedRow->full_name;}else {echo 'administrator';}?></a> <em>+ <?php echo $relatedRow->likes;?></em></span>
								<br class="hidden">
								<a href="#" item_img_url="images/product/<?php echo $img;?>" tid="<?php echo $relatedRow->seller_product_id;?>" class="button <?php echo $fancyClass;?>" <?php if ($loginCheck==''){?>require_login="true"<?php }?>><span><i></i></span><?php echo $fancyText;?></a>
							</div>
					<?php 
					}}
					?>
							</div>
				</div>
				</div>
                
                <aside id="sidebar" style="padding:25px; box-shadow:none">
				<section class="thing-section gift-section">

                    <h3><?php echo $this->config->item('giftcard_title'); ?></h3>

					<div class="thing-description" style="margin:10px 0;">
						
						<p><?php echo $this->config->item('giftcard_description'); ?></p>
						
					</div>
                    
                  
                    <?php 
					
						/*$attributes = array('class' => 'form_container left_label', 'id' => 'giftcard_form', 'method' => 'post' ,  'enctype' => 'multipart/form-data');
						echo form_open_multipart('site/giftcard/insertEditGiftcard',$attributes) */
					?>
                    <div id="GiftErr" style="color:#FF0000;"></div>
                    <div class="gift-option-area">
                        <p class="prices" style="margin-bottom;10px;">
                            <label for="gift-value" style="font-weight:normal;margin-bottom:5px;"><?php if($this->lang->line('giftcard_value') != '') { echo stripslashes($this->lang->line('giftcard_value')); } else echo "Value"; ?></label>
                            <?php $amtVal = explode(',',$this->config->item('giftcard_amounts'));  ?>
                       <select class="select-round select-white selectBox" name="price_value" id="price_value" style="height: 31px; line-height: 21px; padding: 5px 10px; width: 198px; display: none;">
       					<?php foreach($amtVal as $amts){ ?>
	                   	<option value="<?php echo $amts; ?>" <?php if($amts == $this->config->item('giftcard_default_amount')){ echo 'selected="selected"'; }?> ><?php echo '$'.$amts; ?></option>									
						<?php }	?>
						</select>
                        </p>
						<div class="option-area">
							<label for=""><?php if($this->lang->line('giftcard_reci_name') != '') { echo stripslashes($this->lang->line('giftcard_reci_name')); } else echo "Recipient name"; ?></label>
							<input id="recipient_name" name="recipient_name" class="ship_txt option required" type="text">
						</div>
						<div class="option-area">
							<label for=""><?php if($this->lang->line('giftcard_rec_email') != '') { echo stripslashes($this->lang->line('giftcard_rec_email')); } else echo "Recipient e-mail"; ?></label>
							<input id="recipient_mail" name="recipient_mail" class="ship_txt option required email"  type="text">
						</div>
						<div class="option-area">
							<label for=""><?php if($this->lang->line('giftcard_person_msg') != '') { echo stripslashes($this->lang->line('giftcard_person_msg')); } else echo "Personal message"; ?></label>
							<textarea type="text" id="description" name="description" class="option required ship_txt" style="width:224px;height:80px;margin-top:6px;"></textarea>
						</div>
                        <?php if($loginCheck!=''){ ?>
                        	<input type="hidden" name="sender_name" id="sender_name" value="<?php echo $this->session->userdata('session_user_name'); ?>" />
                            <input type="hidden" name="sender_mail" id="sender_mail" value="<?php echo $this->session->userdata('session_user_email'); ?>" />
                        <?php } ?>
						<input type="submit" name="addtocart" id="addtocart" <?php if ($loginCheck==''){echo 'require_login="true"';}?> class="start_btn_3 greencart create-gift-card" value="<?php if($this->lang->line('header_add_cart') != '') { echo stripslashes($this->lang->line('header_add_cart')); } else echo "Add to Cart"; ?>" onclick="javascript:ajax_add_gift_card();">
                        <!--<a href="#" class="greencart create-gift-card"><i class="ic-cart"></i><strong>Add to Cart</strong></a>-->
                    </div>

				
                    
<!-- 					<ul class="thing-info">
						<li><a href="gift-cards" id="show-someone" class="show" uid="6" tid="191021139391156225" tname="Gift Card" tuser="jack" timage="images/giftcards/<?php echo $this->config->item('giftcard_image'); ?>" price="" reacts="117325" username="jack" action="buy"><i></i>Share</a></li>
						<li><a href="#" class="list" id="show-add-to-list"><i></i>Add to list</a></li>
						<li><a href="#" class="feature" oid="3782843" ooid="6" otype="newthing"><i></i>Feature on my profile</a></li>
						<li><a href="#" class="own" tid="191021139391156225"><i></i>I own it</a></li>
						<li><a href="#" class="color"><i></i>Find similar colors</a></li>
                        

                    </ul>
 -->
<!--                     
 					<a href="#" class="report-link" require_login="true"><i class="ic-report"></i>Report</a>
-->					
					
					
				</section>
				<!-- / thing-section -->
			</aside>
				<!-- / figure-row -->
 <!--               <section class="comments comments-list comments-list-new">
                    
                    <button id="btn-viewall-comments" class="toggle">View all 28 comments <i></i></button>
					<button id="toggle-comments" class="toggle"><span>View all 28 comments</span> <i></i></button>
                    
					<!-- template for normal comments -->
					
					<!-- template for reported comments -->
					
<!--					<ol user_id="">
						
						<li class="loading"><span>Loading...</span></li>
					</ol>
					<ol user_id="">
						
						
						<li class="comment">
							<a class="milestone" id="comment-1866615"></a>
							<span class="vcard"><a href="#" class="url"><img src="images/site/comment-icon-5.jpg" alt="" class="photo"><span class="fn nickname">elkhazak</span></a></span>
							<p class="c-text"><a href="#">@yahiaoui_minou</a> i'll do it if u do it i promise also ;)</p>
							
                            
						</li>
						
						
						
						<li class="comment">
							<a class="milestone" id="comment-1866645"></a>
							<span class="vcard"><a href="#" class="url"><img src="images/site/comment-icon-4.jpg" alt="" class="photo"><span class="fn nickname">apichna90</span></a></span>
							<p class="c-text"><a href="#">@elkhazak</a></p>
							
                            
						</li>
						
						
					</ol>
					

				</section>
				<!-- / comments -->
				<?php 
				if (count($relatedProductsArr)>0){
				?>
                <div class="clear"></div>
				
				<?php }?>
<!-- 				
				<h3 id="recently-fancied-by">Recently <?php echo LIKED_BUTTON;?> by...</h3>

				<div class="recently-fancied">
					
					<div class="figure-row">
						<div class="user">
							<div class="vcard">
								<a href="#" class="url"><img src="images/site/comment-icon-1.jpg" alt="" class="photo"></a>
								<a href="#"><strong class="fn nickname">Nosenation</strong></a>
							</div>
							<!-- / vcard -->
<!-- 							
							<a href="#" class="follow-link">Follow</a>
							
						</div>
						<!-- /user -->

<!-- 						
						<div class="figure-product figure-140">
						
						
						
						<a href="#"><figure><span class="wrapper-fig-image"><span class="fig-image"><img src="images/site/comment-follow-1.jpg" alt=""></span></span></figure></a>
						
						
						</div>
						
						<div class="figure-product figure-140">
						
						
						
						<a href="#"><figure><span class="wrapper-fig-image"><span class="fig-image"><img src="images/site/comment-follow-2.jpg" alt=""></span></span></figure></a>
						
						
						</div>
						
						<div class="figure-product figure-140">
						
						
						
						<a href="#"><figure><span class="wrapper-fig-image"><span class="fig-image"><img src="images/site/comment-follow-3.jpg" alt=""></span></span></figure></a>
						
						
						</div>
						
					</div>
					<!-- / figure-row -->
					
<!-- 				</div>
				<!-- / recently-fancied -->
 				
                
                
			</div>
            
			<!-- / content -->

			
			</div>      
         	 </div>
         </div>
	</section>
    <?php 
$this->load->view('site/templates/footer');
?>