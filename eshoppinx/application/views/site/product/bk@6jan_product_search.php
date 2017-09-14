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

.tab_product {
	float: left;
	width: 96%;
	margin: 20px 0px 0px;
	background:none; 
	list-style-type: none;
	border: 0; 
}
.tab_box li a{
	background: none;
	border: none;
}
.product_main{
	background: #FFFFFF;
}
.tab_box li.active{
	background: #FFFFFF;
	border-right: 1px solid #fff;
}
</style>

   <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main">
            
            	<div class="main3">
            		<div class="present products-grid-title-container">
						<h1>
							<span><?php if($this->lang->line('search_results_for') != '') { echo stripslashes($this->lang->line('search_results_for')); } else echo "Search results for"; ?></span>
							<span class="search-keywords">
							"<?php echo $this->input->get('q');?>"
							</span>
						</h1>
					</div>
                		<div class="tab_product">
                        
                            <ul class="tab_box">
                                <li class="active"><a class="find_btn active" href="<?php echo base_url();?>shopby/all?q=<?php echo $this->input->get('q');?>"><span><?php echo count($productList).' ';?></span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></a></li>
                            
                            	<li><a class="find_btn" href="search-people?q=<?php echo $this->input->get('q');?>"><span><?php if ($user_list){echo $user_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('onboarding_people') != '') { echo stripslashes($this->lang->line('onboarding_people')); } else echo "People"; ?></a></li>
                                
                                <li><a class="find_btn" href="search-stores?q=<?php echo $this->input->get('q');?>"><span><?php if ($sellers_list){echo $sellers_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('stores') != '') { echo stripslashes($this->lang->line('stores')); } else echo "Stores"; ?></a></li>
                            
                            
                            </ul>
                        
                        
                        </div>
                         
                        <div class="product_main">
                        
                            <?php 
                            if (count($productList) > 0){
                            ?>
                            	<ul class="product_main_thumb">
                			<?php 
                			foreach ($productList as $products_list_row){
							
							
							
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
                					$fullName = $products_list_row->full_name;
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
                                    
                                        
                                        	<div class="cover boxcaption">
                                                    
                                                      
<div id ="<?php echo $products_list_row->id.'/'.$products_list_row->product_name;?>" class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $products_list_row->seller_product_id;?>" >
                                                      
                           	                           		<strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong>
                                                            
                                                            <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $products_list_row->seller_product_id;?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                            
                                                            <span><?php echo $products_list_row->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="deal_tag_title">
                                                      
                                                      	<h2> <a class="" data-pid="<?php echo $products_list_row->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo $products_list_row->product_name;?></a></h2>
                                                        
                                                        <!--<p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> <span> <?php echo $currencySymbol;?><?php echo $products_list_row->sale_price;?> </span></p>-->
                                                        
                                                        
                                                        
                                                        
                                                        <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> <span> <?php if (!isset($products_list_row->web_link)){echo $currencySymbol;?><?php echo $products_list_row->sale_price;}else {if ($products_list_row->price>0){echo $currencySymbol;?><?php echo $products_list_row->price;}}?> </span></p>
                                                        
                                                      </div>
                                                      
                                                      
                                                   
                                             </div>
                                        
                                        </li>
                         <?php 
                			}
                         ?>               
                
                			</ul>
                            
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
        
        	
        	
        
		</section>
        
        
   <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
