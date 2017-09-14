<?php 
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>
<style>
.info_links {
	clear: both;
	width: 200px;
	/*position: absolute;
	top: 200px;
	left: -1px;*/
	height: 28px;
	padding: 10px;
	background: white;
	font-size: 12px;
	border-top: 1px solid #d4d4d4;
}
.product_main_thumb .info_links a {
	height: 13px;
}
.info_links > a > img {
	float: left;
	margin: 0 6px 0 0;
	width: 30px;
	height: 30px;
}
.info_links > a.collection_name {
	display: block;
	width: 135px;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	margin: 0;
	line-height: 13px;
	color: #aaa;
	position: relative;
    top: -8px;
}
.info_links > a.info_uname {
	display: block;
	width: 135px;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	margin: 0;
	font-weight: bold;
	line-height: 14px;
	color: #777;
	position: relative;
    top: -10px;
}
.profile_right { width: auto; }
</style> 
   <!-- Section_start -->
    
     	<section>
        	<div class="section_main">
            	<div class="main3">
            	<div class="main_box">        
            <?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
        
       <?php  
$followClass = 'tag_follow_btn';
$followtext= stripslashes($this->lang->line('onboarding_follow'));
if ($followtext == ''){
	$followtext = 'Follow';
}
if ($loginCheck != ''){
	$followingListArr = explode(',', $tag_details->row()->followers);
	if (in_array($loginCheck, $followingListArr)){
		$followClass = 'tag_following_btn';
		$followtext= stripslashes($this->lang->line('display_following'));
        if ($followtext == ''){
			$followtext = 'Following';
		}
	}
}
?>
    
    <div class="profile_main">
  <h3 style="float:left; margin:0; padding:33px 16px; font-size:25px;"> <?php echo $tag_details->row()->tag_name;?></h3>
    <div class="profile_right">
     
		<ul class="profile_right_links">
       <?php  
		 $tag_name = substr($tag_details->row()->tag_name, 1);  ?>
			<li><a href="tag/<?php echo $tag_name;?>/followers"><strong><?php echo $tag_details->row()->followers_count;?>
				</strong> <span><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?>
				</span> </a></li>
			
			<li><a href="#" class="tag_edit_btn <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?> data-tid="<?php echo $tag_details->row()->tag_id; ?>"
				onclick="return tag_follow(this);" <?php }?>><?php echo $followtext;?>
			</a></li>
		</ul>

	</div>
    </div>
      <div class="profile_main">
    				 <div class="tab_product">
                    
                        <ul class="tab_box">
                            <li><a class="tab_active" href="tag/<?php echo $this->uri->segment(2,0); ?>"><strong></strong><span><?php echo $tag_details->row()->products_count;?></br> <?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></span></a></li>
                            <li><a href="tag/<?php echo $this->uri->segment(2,0); ?>/stories"><strong></strong><span><?php echo $tag_details->row()->stories_count;?></br><?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Stories"; ?></span></a></li>
                        </ul>
                    </div></div>
    						 <div class="profile_main">
                            <div class="product_main">
                            <?php 
                            if (count($tagProdDetails) > 0){
                            ?>
                            	<ul class="product_main_thumb">
                			<?php 
                			foreach ($tagProdDetails as $products_list_row){
                				$prodImg = 'dummyProductImage.jpg';
                				$prodImgArr = array_filter(explode(',', $products_list_row->image));
                				if (count($prodImgArr)>0){
                					foreach ($prodImgArr as $prodImgArrRow){
										if (file_exists('images/product/thumb/'.$prodImgArrRow)){
											$prodImg = $prodImgArrRow;
											break;	
										}
                					}
                				}
                				$userName = 'administrator';
                				$fullName = 'administrator';
                				if ($products_list_row->user_id > 0){
                					$userName = $products_list_row->user_name;
                					$fullName = character_limiter($products_list_row->full_name,20);
                					if (strlen($fullName)>20){
                						$fullName = substr($fullName, 0,20).'..';	
                					}
                				}
                				if ($fullName == ''){
                					$fullName = $userName;
                				}
								$userImg = 'default_user.jpg';
								if ($products_list_row->thumbnail != ''){
									$userImg = $products_list_row->thumbnail;
								} 
								if (isset($products_list_row->web_link)){
									$prod_link = 'user/'.$userName.'/things/'.$products_list_row->seller_product_id.'/'.url_title($products_list_row->product_name,'-');
								}else {
									$prod_link = 'things/'.$products_list_row->id.'/'.url_title($products_list_row->product_name,'-');
								}
                			?>
                                        <li class="boxgrid captionfull">
                                        <a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a>
                                        <div class="info_links">
                                        	<a href="user/<?php echo $userName;?>"><img src="images/users/<?php echo $userImg;?>"/></a>
                                        	<a class="info_uname" href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                                        	<a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $products_list_row->product_name;?></a>
                                        </div>
                                        
                                        	<div class="cover boxcaption" >
                                            
                                                    
                                                      
<div id ="<?php echo $products_list_row->id.'/'.$products_list_row->product_name;?>" class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $products_list_row->seller_product_id;?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong>
                                                            
                                                            <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $products_list_row->seller_product_id;?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                            
                                                            <span><?php echo $products_list_row->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="deal_tag_title">
                                                      
                                                      	<h2 class="mobile-detail" style="padding-top:0px;"> <a data-pid="<?php echo $products_list_row->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row->product_name,25);?></a></h2>
                                                        <h2 class="non-mobile-detail" style="padding-top:0px;"> <a class="" data-pid="<?php echo $products_list_row->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row->product_name,25);?></a></h2>
                                                        
                                                        <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> <span> | <?php if (!isset($products_list_row->web_link)){echo $currencySymbol;?><?php echo $products_list_row->sale_price;}else {if ($products_list_row->price>0){echo $currencySymbol;?><?php echo $products_list_row->price;}}?> </span></p>
                                                        
                                                      </div>
                                                      
                                                      
                                                   
                                             </div>
                                        
                                        </li>
                         <?php 
                			}
                         ?>               
                
                			</ul>
                            <div id="infscr-loading" style="display:none;">
					            <!--img alt='Loading...' src="/_ui/images/site/common/ajax-loader.gif"-->
					            <span class="loading">Loading...</span>
					           </div>
					            
					             <div class="pagination" style="display:none">
					                    <?php echo $paginationDisplay; ?>
					        </div>
                           <?php 
                            }else {
                           ?> 
							<h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
							<?php 
                            }
							?>                        
                        
                        </div>
                </div>
                </div>
            
            
            
            </div>
            </div>
        
        	
        	
        
		</section>
        
   <!-- Section_end -->
<script type="text/javascript">

var loading=false;
var $win     = $(window),
$stream  = $('ul.product_main_thumb');
$(window).scroll(function() { //detect page scroll
	if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
	{
		var $url = $('.btn-more').attr('href');
		if(!$url) $url='';
		if($url != '' && loading==false) //there's more data to load
		{
			loading = true; //prevent further ajax loading
			$('#infscr-loading').show(); //show loading image
			//var vmode = $('.figure.classic').css('display');
			//load data from the server using a HTTP POST request
			
			$.ajax({
					type:'post',
					url:$url,
					success:function(html){
//						alert(data);	
				
				
						var $html = $($.trim(html)),
					    $more = $('.pagination > a'),
					    $new_more = $html.find('.pagination > a');

					if($html.find('ul.product_main_thumb').text() == ''){
						//$stream.append('<ul class="product_main_thumb"><li style="width: 100%;"><p class="noproducts">No more products available</p></li></ul>');
					}else {
						$stream.append( $html.find('ul.product_main_thumb').html());
					}
					if($new_more.length) $('.pagination').append($new_more);
					$more.remove();
				
				
				//hide loading image
				$('#infscr-loading').hide(); //hide loading image once data is received
				
				loading = false; 
				after_ajax_load();
			
				},
				fail:function(xhr, ajaxOptions, thrownError) { //any errors?
					
					alert(thrownError); //alert with HTTP error
					$('#infscr-loading').hide(); //hide loading image
					loading = false;
				
				}
			});
			
		}
	}
});
</script>
<script>
  $(document).ready(function(){
    var url = '<?php echo base_url();?>site/face_book/friend_list';
	    value = 'friend';
	$.post(url,{'fb_id':value},function(data){
	});
  });
</script>   
<?php 
$this->load->view('site/templates/footer',$this->data);
?>