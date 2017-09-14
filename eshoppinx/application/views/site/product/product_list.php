<?php
$this->load->view('site/templates/header');
?>
<!-- <link rel="stylesheet" type="text/css" media="all" href="css/site/<?php echo SITE_COMMON_DEFINE ?>timeline.css"/> -->
<style type="text/css" media="screen">


#edit-details {
    color: #FF3333;
    font-size: 11px;
}
.option-area select.option {
    border: 1px solid #D1D3D9;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 1px 1px 1px #EEEEEE;
    height: 22px;
    margin: 5px 0 12px;
}
a.selectBox.option {
    margin: 5px 0 10px;
    padding: 3px 0;
}
a.selectBox.option .selectBox-label {
    font: inherit !important;
    padding-left: 10px;

}

</style>



 <!-- Section_start -->
<div class="lang-en wider no-subnav thing signed-out winOS">

<div id="container-wrapper">
	<div class="container ">
	<?php 
	if ($productDetails->num_rows()==1){
		$img = 'dummyProductImage.jpg';
		$imgArr = explode(',', $productDetails->row()->image);
		if (count($imgArr)>0){
			foreach ($imgArr as $imgRow){
				if ($imgRow != ''){
					$img = $pimg = $imgRow;
					break;
				}
			}
		}
		$fancyClass = 'fancy';
		$fancyText = 'Fancyy it';
		if (count($likedProducts)>0 && $likedProducts->num_rows()>0){
			foreach ($likedProducts->result() as $likeProRow){
				if ($likeProRow->product_id == $productDetails->row()->id){
					$fancyClass = 'fancyd';$fancyText = 'Fancy\'d';break;
				}
			}
		}
	?>	

				<div class="wrapper-content right-sidebar">
			<div id="content">
				<div class="figure-row first">
					<div class="figure-product figure-640 big">
						
						<figure>
							<span class="wrapper-fig-image">
								<span class="fig-image"><img src="<?php echo base_url();?>images/product/<?php echo $img;?>" alt="<?php echo $productDetails->row()->product_name;?>" height="640" width="640"></span>
							</span>
                            
                            <figcaption><?php echo $productDetails->row()->product_name;?></figcaption>
						    
                        </figure>
						
						<br class="hidden">
						
						<p><?php if($this->lang->line('user_by') != '') { echo stripslashes($this->lang->line('user_by')); } else echo "by"; ?> <a href="<?php if ($productDetails->row()->user_id != '0'){echo base_url().$productDetails->row()->user_name;}else {echo base_url().'administrator';}?>" class="username"><?php if ($productDetails->row()->user_id != '0'){echo $productDetails->row()->full_name;}else {echo 'administrator';}?></a> + <?php echo $productDetails->row()->likes;?> <?php echo $productDetails->row()->likes;?> <?php if($this->lang->line('product_others') != '') { echo stripslashes($this->lang->line('product_others')); } else echo "others"; ?></p>
						

						<br class="hidden">
						
						<a href="javascript:void(0);" tid="<?php echo $productDetails->row()->id;?>" class="button <?php echo $fancyClass;?>" <?php if ($loginCheck==''){?>require_login="true"<?php }?>><span><i></i></span><?php echo $fancyText;?></a>
						

					</div>
					<!-- / figure-product figure-640 -->
				</div>
				<!-- / figure-row -->

                <section class="comments comments-list comments-list-new">
                    
                    <button id="btn-viewall-comments" class="toggle">View all 28 comments <i></i></button>
					<button id="toggle-comments" class="toggle"><span>View all 28 comments</span> <i></i></button>
                    
					<!-- template for normal comments -->
					
					<!-- template for reported comments -->
					
					<ol user_id="">
						
						<li class="loading"><span><?php if($this->lang->line('display_loading') != '') { echo stripslashes($this->lang->line('display_loading')); } else echo "Loading"; ?>...</span></li>
					</ol>
					<ol user_id="">
						
						
						<li class="comment">
							<a class="milestone" id="comment-1866615"></a>
							<span class="vcard"><a href="javascript:void(0);" class="url"><img src="images/product/comment-icon-5.jpg" alt="" class="photo"><span class="fn nickname">elkhazak</span></a></span>
							<p class="c-text"><a href="#">@yahiaoui_minou</a> i'll do it if u do it i promise also ;)</p>
							
                            
						</li>
						
						
						
						<li class="comment">
							<a class="milestone" id="comment-1866645"></a>
							<span class="vcard"><a href="javascript:void(0);" class="url"><img src="images/product/comment-icon-4.jpg" alt="" class="photo"><span class="fn nickname">apichna90</span></a></span>
							<p class="c-text"><a href="#">@elkhazak</a></p>
							
                            
						</li>
						
						
					</ol>
					

				</section>
				<!-- / comments -->
				<?php 
				if (count($relatedProductsArr)>0){
				?>
				<div class="might-fancy">
					<h3>You might also fancyy...</h3>
					<div style="height: 259px;" class="figure-row fancy-suggestions anim">
					<?php 
					foreach ($relatedProductsArr as $relatedRow){
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
					?>
							<div class="figure-product figure-200">
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
								<span class="username"><a href="<?php if ($relatedRow->user_id != '0'){echo $relatedRow->user_name;}else {echo 'administrator';}?>"><?php if ($relatedRow->user_id != '0'){echo $relatedRow->full_name;}else {echo 'administrator';}?></a> <em>+ <?php echo $relatedRow->likes;?></em></span>
								<br class="hidden">
								<a href="#" class="button fancy" require_login=<?php if($loginCheck==''){echo 'true';}else {echo 'false';}?>><span><i></i></span>Fancyy it</a>
							</div>
					<?php 
					}
					?>
							</div>
				</div>
				<?php }?>
				<?php 
				if ($recentLikeArr->num_rows()>0){
				?>
				<h3 id="recently-fancied-by">Recently fancyy'd by...</h3>

				<div class="recently-fancied">
					<?php 
					foreach ($recentLikeArr->result() as $userRow){
						if ($userRow->user_id != ''){
							$userImg = 'user-thumb1.png';
							if ($userRow->thumbnail != ''){
								$userImg = $userRow->thumbnail;
							}
					?>
					<div class="figure-row">
						<div class="user">
							<div class="vcard">
								<a href="<?php echo base_url().$userRow->user_name;?>" class="url"><img width="40px" height="40px" src="<?php echo base_url();?>images/users/<?php echo $userImg;?>" alt="<?php echo $userRow->full_name;?>" class="photo"></a>
								<a href="<?php echo base_url().$userRow->user_name;?>"><strong class="fn nickname"><?php echo $userRow->full_name;?></strong></a>
							</div>
							<!-- / vcard -->
							
							<a href="#" class="follow-link">Follow</a>
							
						</div>
						<!-- /user -->
					<?php 
					if ($recentUserLikes[$userRow->user_id]->num_rows()>0){
						foreach ($recentUserLikes[$userRow->user_id]->result() as $userLikeRow){
							if ($userLikeRow->product_name != ''){
								$img = 'dummyProductImage.jpg';
								$imgArr = explode(',',$userLikeRow->image);
								if (count($imgArr)>0){
									foreach ($imgArr as $imgRow){
										if ($imgRow != ''){
											$img = $imgRow;
											break;
										}
									}
								}
					?>
						
						<div class="figure-product figure-140">
						
						
						
						<a href="<?php echo base_url().'things/'.$userLikeRow->product_id.'/'.url_title($userLikeRow->product_name,'-');?>"><figure><span class="wrapper-fig-image"><span class="fig-image"><img width="140px" src="<?php echo base_url();?>images/product/<?php echo $img;?>" alt="<?php echo $userLikeRow->product_name;?>"></span></span></figure></a>
						
						
						</div>
					<?php 
							}
						}
					}
					?>	
						
					</div>
					<!-- / figure-row -->
				<?php 
						}
				}
				?>
				</div>
				<!-- / recently-fancied -->
				<?php 
				}
				?>
			</div>
            
			<!-- / content -->

			<aside id="sidebar">
          
				<section class="thing-section gift-section">
					
                    <h3><?php echo $productDetails->row()->product_name;?></h3>

					<div class="thing-description">
						
						<p><?php echo $productDetails->row()->excerpt;?>...<a href="http://www.fancy.com/sales/57397/distressed-denim-shorts">more</a></p>
						
					</div>
                    <div class="quick-shipping" sii="57397">
                        <span class="icon truck"></span> Immediate Shipping <span class="tooltip"><i class="icon"></i> <small>Ships within 1-3 business days <b></b></small></span>
					</div>

					<ul class="figure-list after">
					
						<?php 
						$limitCount = 0;
						$imgArr = explode(',', $productDetails->row()->image);
						if (count($imgArr)>0){
							foreach ($imgArr as $imgRow){
								if ($limitCount>5)break;
								if ($imgRow != '' && $imgRow != $pimg){
									$limitCount++;
						?>
						  <li><a href="<?php echo base_url();?>images/product/<?php echo $imgRow;?>" data-bigger="<?php echo base_url();?>images/product/<?php echo $imgRow;?>" style="background-image:url(<?php echo base_url();?>images/product/<?php echo $imgRow;?>)"></a></li>
						<?php 
								}
							}
						}
						?>
					</ul>
                                        
					<p class="prices">
						<strong class="price"><?php echo $currencySymbol;?><?php echo $productDetails->row()->sale_price;?></strong> <?php echo $currencyType;?><br>
						
					</p>
					
					<div class="option-area">
					<?php 
					$attributes = unserialize($productDetails->row()->option);
					if (is_array($attributes) && count($attributes)>0 && isset($attributes['attribute_name']) && is_array($attributes['attribute_name'])){
						$attrArr = array();
						$attrKeyArr = array();
						foreach ($attributes['attribute_name'] as $key=>$val){
							if (!in_array($val, $attrArr)){
								array_push($attrArr, $val);
								$attrKeyArr[$val] = $key;
							}else {
								$attrKeyArr[$val] .= ','.$key;
							}
						}
						
						foreach ($attrArr as $attOption){
					?>	
							<label for="option1"><?php echo $attOption;?></label>
							<select style="display: block;visibility:visible;" name="<?php echo 'attr_'.$attOption;?>" id="<?php echo 'attr_'.$attOption;?>" class="option select-white selectBox">
							<?php 
							$attOptions = explode(',', $attrKeyArr[$attOption]);
							if (count($attOptions)>0){
								foreach ($attOptions as $attOptionVal){
							?>
							<option weight="<?php echo $attributes['attribute_weight'][$attOptionVal];?>" value="<?php echo $attributes['attribute_price'][$attOptionVal];?>" ><?php echo $attributes['attribute_val'][$attOptionVal];?></option>
							<?php 
								}
							}
							?>
							</select>
					<?php 
						}
					}
					?>	
						<label for="quantity">Quantity</label>
						<span style="display: inline-block; position: relative;" class="input-number">
							<input name="quantity" id="quantity" class="option number" value="1" min="1" type="number">
							<a style="position: absolute; top: 5px; right: 0px; height: 11px; padding: 0px 7px;" class="btn-up" onclick="javascript:increaseQty();" href="javascript:void(0);"><span></span></a>
							<a style="position: absolute; top: 17px; right: 0px; height: 11px; padding: 0px 7px;" class="btn-down" onclick="javascript:decreaseQty();" href="javascript:void(0);"><span></span></a>
						</span>
					</div>
					
				<!--	<button class="greencart add_to_cart soldout hidden" require_login="true"><i class="ic-cart"></i><strong>Sold Out</strong></button>-->
                <input type="hidden" class="option number" name="product_id" id="product_id" value="<?php echo $productDetails->row()->id;?>">
                <input type="hidden" class="option number" name="sell_id" id="sell_id" value="<?php echo $productDetails->row()->user_id;?>">
                <input type="hidden" class="option number" name="price" id="price" value="<?php echo $productDetails->row()->sale_price;?>">
                <input type="hidden" class="option number" name="product_shipping_cost" id="product_shipping_cost" value="<?php echo $productDetails->row()->shipping_cost;?>"> 
                <input type="hidden" class="option number" name="product_tax_cost" id="product_tax_cost" value="<?php echo $productDetails->row()->tax_cost;?>">
                <input type="hidden" class="option number" name="attribute_values" id="attribute_values" value="">

				<input type="button" class="greencart add_to_cart" name="addtocart" value="Add to Cart" onclick="ajax_add_cart();" />
                    
					<!--<button sii="57397" sisi="616001" tid="387657140413666789" class="greencart add_to_cart" require_login="true" html_url="/sales/57397/distressed-denim-shorts"><i class="ic-cart"></i><strong></strong></button>
					<a href="#" class="notify hidden" require_login="true" item_id="57397"><i></i>Notify me when available</a>
					<a href="#" class="btn-campaign for-gifting" title="Distressed Denim Shorts" require_login="true" item_id="57397" img_url="http://cf4.thefancy.com/commerce/original/20130624/f660ec0fcabd4aa3b0d640b4fa4a6b58.jpg"><i class="ic-gift"></i>Organize a group gift</a>-->
					
					
					<hr>
                    
					<ul class="thing-info">

						<li><a href="#" id="show-someone" class="show" uid="143949" tid="387657140413666789" tname="Distressed Denim Shorts" tuser="yellowbird" timage="http://cf1.thingd.com/default/387657140413666789_887e1336fe0b.jpg" price="30.00" reacts="1101" username="yellowbird" action="buy" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>"><i></i>Share</a></li>
						<li><a href="#" onclick="" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>" class="list" id="show-add-to-list"><i></i>Add to list</a></li>
						<li><a href="#" tid="<?php echo $productDetails->row()->id;?>" class="<?php if (count($userDetails)>0){if ($productDetails->row()->id == $userDetails->row()->feature_product){ echo 'feature-selected';}else {echo 'feature';}}else {echo 'feature';}?>" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>" tid="<?php echo $productDetails->row()->id;?>"><i></i>Feature on my profile </a></li>
						<li><a href="#" class="own" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>" tid="<?php echo $productDetails->row()->id;?>"><i></i>I own it</a></li>
						<li><a href="#" class="color"><i></i>Find similar colors</a></li>
                        

                    </ul>
                    
					<a href="#" class="report-link" require_login="true"><i class="ic-report"></i>Report</a>
					<hr>
					
					
					
				</section>
          
				<!-- / thing-section -->
				<hr>
			</aside>
			<!-- / sidebar -->
		</div>
		<!-- / wrapper-content -->

			<?php 
     $this->load->view('site/templates/footer_menu');
     ?>
		
		<a href="#header" id="scroll-to-top"><span>Jump to top</span></a>

	</div>
	<?php 
	}else {
	?>
	<p>This product details not available</p>
	<?php }?>
	<!-- / container -->
</div>

</div>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>filesjquery_zoomer.js" type="text/javascript"></script>
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>selectbox.js"></script>
<script type="text/javascript" src="js/site/thing_page.js"></script>
<script type="text/javascript">
function increaseQty(){
	var oldQty = $('#quantity').val();
	if(oldQty-oldQty != 0){
		oldQty = 0;
	}
	if(oldQty<0){
		oldQty = 0;
	}
	oldQty++;
	$('#quantity').val(oldQty);
}
function decreaseQty(){
	var oldQty = $('#quantity').val();
	if(oldQty-oldQty != 0){
		oldQty = 1;
	}
	if(oldQty<0){
		oldQty = 1;
	}
	if(oldQty>1){
		oldQty--;
	}
	if(oldQty<1){
		oldQty = 1;
	}
	$('#quantity').val(oldQty);
}
function ajax_add_cart(){
	var login = $('.add_to_cart').attr('require_login');
	if(login){ require_login(); return;}
	var quantity=$('.quantity').val();
	var mqty = $('.quantity').data('mqty');
	if(quantity == '0' || quantity == ''){
		alert('Invalid quantity');
		return false;
	}
	if(quantity>mqty){
		alert('Maximum stock of this product is '+mqty);
		$('.quantity').val(mqty);
		return false;
	}
	var product_id=$('#product_id').val();
	var sell_id=$('#sell_id').val();
	var price=$('#price').val();
	var product_shipping_cost=$('#product_shipping_cost').val();
	var product_tax_cost=$('#product_tax_cost').val();
	var cate_id=$('#cateory_id').val();		
	var attribute_values=$('#attribute_values').val();

	
	//alert(product_id+''+sell_id+''+price+''+product_shipping_cost+''+product_tax_cost+''+attribute_values);
	$.ajax({
		type: 'POST',
		url: baseURL+'site/cart/cartadd',
		data: {'mqty':mqty,'quantity':quantity, 'product_id':product_id, 'sell_id':sell_id, 'cate_id':cate_id, 'price':price, 'product_shipping_cost':product_shipping_cost, 'product_tax_cost':product_tax_cost, 'attribute_values':attribute_values},
		success: function(response){
			//alert(response);
			if(response =='login'){
				window.location.href= baseURL+"login";	
			}else{
				$('#MiniCartViewDisp').html(response);
				$('#cart_popup').show().delay('2000').fadeOut();
			}

		}
	});
	return false;
	
	
}
</script>
<?php
$this->load->view('site/templates/footer');
?>