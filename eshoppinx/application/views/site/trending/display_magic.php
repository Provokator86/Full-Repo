<?php 
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>  
<script type="text/javascript" src="js/validation.js"></script>

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
                        <div class="product_main">
                        <input type="hidden" name="magic_cat_val" value="<?php echo $magic_cat_val; ?>" />
                            <?php 
							if($magic_cat_val==1){
                            ?>
                            	<ul class="product_main_thumb">
                			<?php 
								$products_cate_list=$products_cate_list->result_array();
								echo $count = $products_cate_list['COUNT(*)'];
	                			foreach ($products_cate_list as $products_list_row){
	                				$prodImg = 'dummyProductImage.jpg';
	                				$prodImgArr = array_filter(explode(',', $products_list_row['image']));
	                				if (count($prodImgArr)>0){
	                					foreach ($prodImgArr as $prodImgArrRow){
											if (file_exists('images/product/thumb/'.$prodImgArrRow)){
												$prodImg = $prodImgArrRow;
												break;	
											}
	                					}
	                				}
	                				/*$userName = 'administrator';
	                				$fullName = 'administrator';
	                				if ($products_list_row['user_id'] > 0){
	                					$userName = $product_owners[$products_list_row['user_id']]['user_name'];
		                				$fullName = character_limiter($product_owners[$products_list_row['user_id']]['full_name'],20);
	                					if (strlen($fullName)>20){
	                						$fullName = substr($fullName, 0,20).'..';	
	                					}
	                				}*/
									$userName = 'administrator';
	                				$fullName = 'administrator';
	                				if ($products_list_row['user_id'] > 0){
	                					$userName = $products_list_row['user_name'];
		                				$fullName = character_limiter($products_list_row['full_name'],20);
	                					if (strlen($fullName)>20){
	                						$fullName = substr($fullName, 0,20).'..';	
	                					}
	                				}
	                				if ($fullName == '') $fullName=$userName;
	                				$userImg = 'default_user.jpg';
									if ($products_list_row['thumbnail'] != ''){
										$userImg = $products_list_row['thumbnail'];
									} 
		                			if ($products_list_row['web_link'] != 'None'){
	            						$prod_link = 'user/'.$products_list_row['user_name'].'/things/'.$products_list_row['seller_product_id'].'/'.url_title($products_list_row['product_name'],'-');
	            					}else {
	            						$prod_link = 'things/'.$products_list_row['id'].'/'.url_title($products_list_row['product_name'],'-');
	            					}
                			?>
                                        <li class="boxgrid captionfull">
                                        <a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a>
                                        
                                        <div class="info_links">
                                        	<a href="user/<?php echo $userName;?>"><img src="images/users/<?php echo $userImg;?>"/></a>
                                        	<a class="info_uname" href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                                        	<a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $products_list_row['product_name']; ?></a>
                                        </div>
                                        
                                        	<div class="cover boxcaption">
                                                      
                                                      <div class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $products_list_row['seller_product_id'];?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong>
                                                            
                                                            <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="save <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'save_box';}?>" data-pid="<?php echo $products_list_row['seller_product_id'];?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                            
                                                            <span><?php echo $products_list_row['likes'];?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="deal_tag_title">
                                                      
                                                      	<h2 style="padding-top:0px;"> <a class="" data-pid="<?php echo $products_list_row['seller_product_id']; ?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row['product_name'],25);?></a></h2>
                                                        
                                                        <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> | <span> <?php if (!isset($products_list_row['web_link'])){echo $currencySymbol;?><?php echo $products_list_row['sale_price'];}else {echo $currencySymbol;?><?php echo $products_list_row['price'];}?> </span></p>
                                                        
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
					                    <?php //echo $paginationDisplay; ?>
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
        
        	
        	
        
		</section>
        
        
   <!-- Section_end -->
<script type="text/javascript">
$('.example16').click(function(){
	$('#inline_example11 .popup_page').html('<div class="cnt_load"><img src="images/ajax-loader.gif"/></div>');
	var pid = $(this).data('pid');
	var pname = $(this).text();
	var purl = baseURL+$(this).attr('href');
	$.ajax({
		type:'get',
		url:baseURL+'site/product/get_product_popup',
		data:{'pid':pid},
		dataType:'html',
		success:function(data){
			window.history.pushState({"html":data,"pageTitle":pname},"", purl);
			$('#inline_example11 .popup_page').html(data);
		}
	});
});
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
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
