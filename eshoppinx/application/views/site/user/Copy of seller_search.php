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
                                <li><a class="find_btn" href="shopby/all?q=<?php echo $this->input->get('q');?>"><span><?php echo count($productList).' ';?></span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></a></li>
                            
                            	<li><a class="find_btn" href="search-people?q=<?php echo $this->input->get('q');?>"><span><?php if ($user_list){echo $user_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('onboarding_people') != '') { echo stripslashes($this->lang->line('onboarding_people')); } else echo "People"; ?></a></li>
                                
                                <li class="active"><a class="find_btn active" href="javascript:void();"><span><?php if ($sellers_list){echo $sellers_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('stores') != '') { echo stripslashes($this->lang->line('stores')); } else echo "Stores"; ?></a></li>
                            
                            
                            </ul>
                        
                        
                        </div>
                        
                        <div class="product_main" style="background-color: #fff;">
<?php 
if ($sellers_list!='' && $sellers_list->num_rows()>0){
	foreach ($sellers_list->result() as $store_list){
		$store_name = $store_list->store_name;
		$followClass = 'follow_btn';
		$followText= stripslashes($this->lang->line('onboarding_follow'));
		if ($followText == ''){
			$followText = 'Follow';
		}
		if ($loginCheck != ''){
			$followingListArr = explode(',', $store_list->followers);
			if (in_array($loginCheck, $followingListArr)){
				$followClass = 'following_btn';
				$followText= stripslashes($this->lang->line('display_following'));
		        if ($followText == ''){
					$followText = 'Following';
				}
			}
		}
?>                        
                        
                            <div class="store_list">
                            
                            	<div class="follow_main" style="height: 320px;">
                
                                    <div class="left_follow" style="width:300px;">
                                    <?php 
                                    $storeImg = 'dummy_store_logo.png';
                                    if ($store_list->store_logo != ''){
                                    	$storeImg = $store_list->store_logo;
                                    }
                                    ?>
                                        <a href="store/<?php echo $store_list->store_url;?>"><span class="follow_icon"><img src="images/store/<?php echo $storeImg;?>" /></span></a>
                                        <a class="follow_icon_links" href="store/<?php echo $store_list->store_url;?>" style="width:75%;overflow:hidden;height:20px;text-align: left;"><?php echo $store_name;?></a>
                                        
                                        <span class="follow_count"><?php echo $store_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                                    
                                    
                                    </div>
                    
                                        <div class="right_follow">
                                        
                                            <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:follow_store(this);"<?php }?> ><?php echo $followText;?></a>
                                                      	</div>	
                    
                    
                                      <ul class="store_list_follow">
                                      <?php 
                                      if ($prodDetails[$store_list->id]!='' && $prodDetails[$store_list->id]->num_rows()>0){
                                      	$limitCount = 0;
                                      	foreach ($prodDetails[$store_list->id]->result() as $store_products){
											if ($limitCount==8)break;$limitCount++;
											$prodImg = 'dummyProductImage.jpg';
											$prodImgArr = array_filter(explode(',', $store_products->image));
											if (count($prodImgArr)>0){
												foreach ($prodImgArr as $prodImgArrRow){
													if (file_exists('images/product/'.$prodImgArrRow)){
														$prodImg = $prodImgArrRow;
														break;
													}
												}
											}
											if (isset($store_products->web_link)){
												$prod_link = 'user/'.$store_products->user_name.'/things/'.$store_products->seller_product_id.'/'.url_title($store_products->product_name,'-');
											}else {
												$prod_link = 'things/'.$store_products->id.'/'.url_title($store_products->product_name,'-');
											}
                                      ?>
                                                
                                            <li style="width: 127px;"><a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a></li>
                                      <?php 
                                      	}
                                      }
                                      ?>                  
                                  </ul>
                
               				 </div>
                            
                            
                            </div>
<?php 
	}

}else {
?>     
<p><?php if($this->lang->line('shop_nostoresavail') != '') { echo stripslashes($this->lang->line('shop_nostoresavail')); } else echo "No stores available"; ?></p>
<?php 
}
?>                   
                        </div>
                
                </div>
            
            
            
            </div>
        
        	
        	
        
		</section>
        
        
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
