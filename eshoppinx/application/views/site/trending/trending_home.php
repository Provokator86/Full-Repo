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
.tags_con { background-color: #fff; }
.tags_con h3{ padding: 5px; }
.tags_con .tags_link_con{ float: left;height: 230px;width: 210px;margin: 5px;overflow: hidden; }
.tags_con .tags_link_con a{ float: left;width: auto;height: auto;line-height: 29px;margin-right: 10px;color: #B1B1B1;font-weight: bold; }
.tags_con .tags_link_con a:hover{ color:#000; }
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
                
                		<div id="category-settings">
                		<?php 
                			$sel_cat = $this->input->get('c');
                			$sel_price = $this->input->get('p');
                			$women_cat = "women";
                			$men_cat = "men";
                			$home_cat = "home";
                			$low_price = "low";
                			$medium_price = "medium";
                			$high_price = "high";
                			$cat_link = '';
                			if ($sel_cat!=''){
                				$cat_link = 'c='.$sel_cat.'&';
                			}
                			$price_link = '';
                			if ($sel_price!=''){
                				$price_link = '&p='.$sel_price;
                			}
                			if ($sel_cat != ''){
                				$sel_cat_arr = explode('-', $sel_cat);
                				if (in_array($women_cat, $sel_cat_arr)){
									$women_cat_arr = $sel_cat_arr;
                					if (($key=array_search("women", $women_cat_arr)) !== false){
                						unset($women_cat_arr[$key]);
                					}
                					$women_cat = implode('-', $women_cat_arr);
                				}elseif (!in_array($women_cat, $sel_cat_arr)){
                					$women_cat = 'women-'.$sel_cat;
                				}
                				if (in_array($men_cat, $sel_cat_arr)){
									$men_cat_arr = $sel_cat_arr;
									if (($key=array_search("men", $men_cat_arr)) !== false){
											unset($men_cat_arr[$key]);
									}
									$men_cat = implode('-', $men_cat_arr);
                				}elseif (!in_array($men_cat, $sel_cat_arr)){
                					$men_cat = 'men-'.$sel_cat;
                				}
                				if (in_array($home_cat, $sel_cat_arr)){
									$home_cat_arr = $sel_cat_arr;
									if (($key=array_search("home", $home_cat_arr)) !== false){
											unset($home_cat_arr[$key]);
									}
									$home_cat = implode('-', $home_cat_arr);
                				}elseif (!in_array($home_cat, $sel_cat_arr)){
                					$home_cat = 'home-'.$sel_cat;
                				}
                			}
                			if ($sel_price != ''){
                				$sel_price_arr = explode('-', $sel_price);
                				if (in_array($low_price, $sel_price_arr)){
									$low_price_arr = $sel_price_arr;
									if (($key=array_search("low", $low_price_arr)) !== false){
											unset($low_price_arr[$key]);
									}
									$low_price = implode('-', $low_price_arr);
                				}elseif (!in_array($low_price, $sel_price_arr)){
                					$low_price = 'low-'.$sel_price;
                				}
                				if (in_array($medium_price, $sel_price_arr)){
                					$medium_price_arr = $sel_price_arr;
									if (($key=array_search("medium", $medium_price_arr)) !== false){
											unset($medium_price_arr[$key]);
									}
									$medium_price = implode('-', $medium_price_arr);
                				}elseif (!in_array($medium_price, $sel_price_arr)){
                					$medium_price = 'medium-'.$sel_price;
                				}
                				if (in_array($high_price, $sel_price_arr)){
									$high_price_arr = $sel_price_arr;
									if (($key=array_search("high", $high_price_arr)) !== false){
											unset($high_price_arr[$key]);
									}
									$high_price = implode('-', $high_price_arr);
                				}elseif (!in_array($high_price, $$sel_price_arr)){
                					$high_price = 'high-'.$sel_price;
                				}
                			}
                		?>
							<div class="product-category-btns">
                            	<?php //echo $this->uri->segment(5); ?>
                                <?php 
									$cate=$this->input->get('c');
									$cate_split=explode('-',$cate);
									/*if(count($cate_split)>0)
									{
										foreach($cate_split as $list)
										{
											$list.",";
										}
									}*/
									
									$price=$this->input->get('p');
									$price_split=explode('-',$price);
								?>
                                <?php 
									//$women_product=$women_product->result_array();
									//echo $women_product['id'];
								?>
								<a <?php if(in_array('women',$cate_split)) { ?> class="active"<?php } ?> href="<?php echo base_url();?>trending?c=<?php echo $women_cat.$price_link;?>">Women</a>
								<a <?php if(in_array('men',$cate_split)) { ?> class="active"<?php } ?> href="<?php echo base_url();?>trending?c=<?php echo $men_cat.$price_link;?>">Men</a>
								<a <?php if(in_array('home',$cate_split)) { ?> class="active"<?php } ?> href="<?php echo base_url();?>trending?c=<?php echo $home_cat.$price_link;?>">Home</a>
							</div>
							<div class="price-category-btns">
								<a <?php if(in_array('low',$price_split)) { ?> class="active"<?php } ?> href="<?php echo base_url();?>trending?<?php echo $cat_link.'p='.$low_price;?>"><?php echo $currencySymbol?></a>
								<a <?php if(in_array('medium',$price_split)) { ?> class="active"<?php } ?> href="<?php echo base_url();?>trending?<?php echo $cat_link.'p='.$medium_price;?>"><?php echo $currencySymbol?><?php echo $currencySymbol?></a>
								<a <?php if(in_array('high',$price_split)) { ?> class="active"<?php } ?> href="<?php echo base_url();?>trending?<?php echo $cat_link.'p='.$high_price;?>"><?php echo $currencySymbol?><?php echo $currencySymbol?><?php echo $currencySymbol?></a>
							</div>
							<div class="clearfix"></div>
						</div>
                      <div class="product_main">
                            <?php 
                            if ($products_list->num_rows() > 0){
                            ?>
                            	<ul class="product_main_thumb">
                            	<?php 
                            	if ($hashtags->num_rows()>0){
                            	?>
                            		<li class="boxgrid tags_con">
                      					<h3>Top Tags</h3>
                      					<div class="tags_link_con">
                      					<?php foreach ($hashtags->result() as $hash_row){?>
                      						<a href="<?php echo base_url();?>tag/<?php echo substr($hash_row->tag_name, 1);?>"><?php echo $hash_row->tag_name;?></a>
                      					<?php }?>	
                      					</div>
                      				</li>
                      			<?php 
                            	}
                      			?>
                			<?php 
                			foreach ($products_list->result() as $products_list_row){
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
								if ($products_list_row->web_link != 'None'){
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
                                            
                                                    
                                                      
<div id ="<?php echo $products_list_row->id;?>" class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $products_list_row->seller_product_id;?>">
                                                      
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
    var url = '<?php echo base_url();?>/site/face_book/friend_list';
	    value = 'friend';
	$.post(url,{'fb_id':value},function(data){
	});
  });
</script>   
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
