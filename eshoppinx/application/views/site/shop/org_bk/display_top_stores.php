<?php 
$this->load->view('site/templates/header',$this->data);
?> 

  <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main">
            
            	<div class="main2">
                
                	<div class="main_box">
                    
                    	<h2 style="margin-bottom: 20px;"><?php if($this->lang->line('shop_topstoreson') != '') { echo stripslashes($this->lang->line('shop_topstoreson')); } else echo "Top stores on"; ?> <?php echo $siteTitle;?></h2>
                
                        
                        <div class="product_main" style="background-color: #fff;">
<?php 
if (count($topStores)>0 && $topStores['store_lists']->num_rows()>0){
	foreach ($topStores['store_lists']->result() as $store_list){
/*		$userImg = 'default_user.jpg';
		if ($store_list->thumbnail != ''){
			if (file_exists('images/users/'.$store_list->thumbnail)){
				$userImg = $store_list->thumbnail;
			}
		}
*/		$store_name = $store_list->store_name;
//		if ($store_name == '')$store_name = $store_list->user_name;
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
                            
                            	<div class="follow_main" style="height: 300px;">
                
                                    <div class="left_follow" style="width:300px;">
                                    <?php 
                                    $storeImg = 'dummy_store_logo.png';
                                    if ($store_list->store_logo != ''){
                                    	$storeImg = $store_list->store_logo;
                                    }
                                    ?>
                                        <a href="store/<?php echo $store_list->store_url;?>"><span class="follow_icon"><img src="images/store/<?php echo $storeImg;?>" /></span></a>
                                        
                                        <a class="follow_icon_links" href="store/<?php echo $store_list->store_url;?>" style="width:75%;overflow:hidden;height:20px;float: left;"><?php echo $store_name;?></a>
                                        
                                        <span class="follow_count"><?php echo $store_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                                    
                                    
                                    </div>
                    
                                        <div class="right_follow">
                                        
                                            <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:follow_store(this);"<?php }?> ><?php echo $followText;?></a>
                                                      	</div>	
                    
                    
                                      <ul class="store_list_follow">
                                       <?php 
                                      if ($topStores['prodDetails'][$store_list->id] != '' && $topStores['prodDetails'][$store_list->id]->num_rows()>0){
                                      	$limitCount = 0;
                                      	foreach ($topStores['prodDetails'][$store_list->id]->result() as $store_products){
											if ($limitCount==8)break;$limitCount++;
											$prodImg = 'dummyProductImage.jpg';
											$prodImgArr = array_filter(explode(',', $store_products->image));
											if (count($prodImgArr)>0){
												foreach ($prodImgArr as $prodImgArrRow){
													if (file_exists('images/product/thumb/'.$prodImgArrRow)){
														$prodImg = $prodImgArrRow;
														break;
													}
												}
											}
											if (isset($store_products->web_link)){
												$prod_uname = $store_products->user_name;
												if ($prod_uname=='') $prod_uname='anonymous';
												$prod_link = 'user/'.$prod_uname.'/things/'.$store_products->seller_product_id.'/'.str_replace(' ','-',$store_products->product_name);
											}else {
												$prod_link = 'things/'.$store_products->id.'/'.str_replace(' ','-',$store_products->product_name);
											}
                                      ?>
                                                
                                            <li><a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a></li>
                                      <?php 
                                      	}
                                      }
                                      ?>                 
                                  </ul>
                
               				 </div>
                            
                            
                            </div>
<?php 
	}
?>                            

<?php 
}else {
?>     
<p><?php if($this->lang->line('shop_nostoresavail') != '') { echo stripslashes($this->lang->line('shop_nostoresavail')); } else echo "No Stores available"; ?></p>
<?php 
}
?>                   
                        </div>
                        
                      </div>
                
                </div>
            
            
            
            </div>
        
        	
        	
        
		</section>
        
        
   <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer',$this->data);
?>   